<?php

class Database {

    private $connection;

    public function __construct() {
        if (!$this->connection = mysqli_connect(
            'localhost',
            'mysql',
            'mysql'
        )) {
            die('Отсутствует подключение к базе данных');
        }
        if (!$this->connection->select_db('airbus')) {
            die('Отсутствует база данных airbus');
        }
    }

    public function register(string $email, string $password): void {
        $password = md5($password);
        $query = sprintf("INSERT INTO users (email, password) VALUES ('%s', '%s')", $email, $password);
        if (!$result = $this->connection->query($query)) {
            throw new Exception('Не удалось зарегистрировать пользователя');
        }
        return;
    }

    public function findForAuth(string $email, string $password): ?array {
        $result = $this->connection->query(sprintf(
            "SELECT id, email, password FROM users WHERE email = '%s' AND password = '%s'",
            $email,
            $password
        ));
        return mysqli_fetch_row($result);
    }

    public function findAirports(int $id): ?array {
        $result = $this->connection->query(sprintf(
            "SELECT id, name FROM airports WHERE city_id = '%s'",
            $id
        ));
        return (array)mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function findTickets(array $data): array {
        $where = [];
        $dateFrom = (new DateTime($data['dateFrom']))->format('Y-m-d');
        $dateTo = (new DateTime($data['dateTo']))->format('Y-m-d');
        $where[] = sprintf("(t.date = '%s' OR t.date = '%s')", $dateFrom, $dateTo);
        $where[] = sprintf('t.count >= %s', (int)$data['count']);
        $where[] = sprintf('t.city_from_id = %s', $data['from']);
        $where[] = sprintf('t.city_to_id = %s', $data['to']);
        if ($class = $data['class']) {
            $where[] = sprintf('t.class_id = %s', (int)$class);
        }

        $query = sprintf(
            "SELECT t.id, t.date, fc.name as fromCity, tc.name as toCity, t.price, t.count, c.name as class, 
            af.name as airportFrom, at.name as airportTo 
            FROM tickets t
            INNER JOIN city fc on fc.id = t.city_from_id
            INNER join city tc on tc.id = t.city_to_id
            INNER JOIN class c on c.id = t.class_id
            INNER JOIN airports `af`  on t.airport_from_id = af.id
            INNER JOIN airports `at` on t.airport_to_id = at.id
            WHERE %s",
            implode(' AND ', $where)
        );
        $result = $this->connection->query($query);
        return (array)mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function bookTickets(int $ticketId, int $count): bool {
        $result = mysqli_fetch_row($this->connection->query(sprintf(
            "SELECT COUNT(*) FROM orders WHERE user_id = %s AND ticket_id = %s",
            $_SESSION['id'],
            $ticketId
        )));
        try {
            $transactionStarted = $this->connection->query("BEGIN");
            if ($result[0]) {
                $transactionStarted && $this->updateTicketCount($ticketId, $count);
            } else {
                $transactionStarted && $this->insertOrderRow($ticketId, $count);
            }
            $this->decreaseTicketsCount($ticketId, $count);
            $this->connection->query("COMMIT");
            return true;
        } catch (Exception $e) {
            $this->connection->query("ROLLBACK");
            return false;
        }
    }

    public function getClasses(): array {
        $result = $this->connection->query("SELECT * FROM class");
        return (array)mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getCities(): array {
        $result = $this->connection->query("SELECT * FROM city");
        return (array)mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getTickets(): array {
        $result = $this->connection->query("
        SELECT t.id, t.date, fc.name as fromCity, tc.name as toCity, t.price, t.count, c.name as class,
        af.name as airportFrom, at.name as airportTo
        FROM tickets t
        INNER JOIN city fc on fc.id = t.city_from_id
        INNER join city tc on tc.id = t.city_to_id 
        INNER JOIN airports `af`  on t.airport_from_id = af.id
        INNER JOIN airports `at` on t.airport_to_id = at.id
        INNER JOIN class c on c.id = t.class_id
        ");
        return (array)mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function createTicket(array $data) {
        $query = sprintf("INSERT INTO tickets (city_from_id, airport_from_id, city_to_id, airport_to_id, `date`, class_id, price, `count`)
            VALUES (%s, %s, %s, %s, '%s', %s, %s, %s)",
            (int)$data['from'],
            (int)$data['fromAirport'],
            (int)$data['to'],
            (int)$data['toAirport'],
            (new DateTime($data['dateFrom']))->format('Y-m-d'),
            (int)$data['class'],
            (int)$data['price'],
            (int)$data['count']
        );
        if (!$result = $this->connection->query($query)) {
            throw new Exception('Не удалось создать билет');
        }
        return;
    }

    public function removeTicket(int $id): void {
        $query = sprintf("DELETE FROM tickets WHERE id = '%s'", $id);
        if (!$result = $this->connection->query($query)) {
            throw new Exception('Невозможно удалить билет т.к. он используется в заказах');
        }
        return;
    }

    public function getUserOrders(): array {
        $result = $this->connection->query(sprintf(
            "SELECT fc.name as fromCity, tc.name as toCity, c.name as class, o.count
            FROM orders o
            INNER JOIN tickets t on t.id = o.ticket_id
            INNER JOIN city fc on fc.id = t.city_from_id   
            INNER JOIN city tc on tc.id = t.city_to_id
            INNER JOIN class c on c.id = t.class_id   
            WHERE user_id = %s",
            $_SESSION['id']
        ));
        return (array)mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    private function updateTicketCount(int $ticketId, int $count) {
        if (!$this->connection->query(sprintf(
            "UPDATE orders SET `count` = `count` + %s WHERE user_id = %s AND ticket_id = %s",
            $count,
            $_SESSION['id'],
            $ticketId
        ))) {
            throw new Exception('Невозможно увеличить количество билетов');
        }
    }

    private function insertOrderRow(int $ticketId, int $count): void {
        if (!$this->connection->query(sprintf(
            "INSERT INTO orders (user_id, ticket_id, `count`) VALUES (%s, %s, %s)",
            $_SESSION['id'],
            (int)$ticketId,
            (int)$count
        ))) {
            throw new Exception('Не удалось забронировать билеты');
        }
    }

    private function decreaseTicketsCount(int $ticketId, int $count): void {
        if (!$this->connection->query(sprintf(
            "UPDATE tickets SET `count` = `count` - %s WHERE id = %s",
            $count,
            $ticketId
        ))) {
            throw new Exception('Невозможно уменьшить количество билетов');
        }
    }

}
