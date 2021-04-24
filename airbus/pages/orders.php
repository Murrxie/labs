<?php
include_once '../templates/header.php';
include_once '../app/Database.php';
$db = new Database();
$orders = $db->getUserOrders();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="orders">
                <?php if ($_SESSION['name']): ?>
                    <table class="table-striped">
                        <thead>
                        <tr>
                            <th>Город отправки</th>
                            <th>Город прибытия</th>
                            <th>Класс</th>
                            <th>Количество</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= $order['fromCity'] ?></td>
                                <td><?= $order['toCity'] ?></td>
                                <td><?= $order['class'] ?></td>
                                <td><?= $order['count'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <? else: ?>
                    <p style="text-align: center">Для просмотра заказов необходимо авторизоваться</p>
                <? endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
include_once '../templates/footer.php';
?>


