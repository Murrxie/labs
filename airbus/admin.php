<?php
include_once './templates/header.php';
include_once './app/Database.php';
$db = new Database();
$tickets = $db->getTickets();
$cities = $db->getCities();
$classes = $db->getClasses();
?>
    <div class="container-fluid">
        <div class="row">
            <div class="orders">
                <?php if ($_SESSION['name'] == 'admin@mail.ru'): ?>
                    <div class="row">
                        <div class="col ml-2 mt-2">
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal">Создать
                            </button>
                        </div>
                    </div>
                    <table class="table-striped">
                        <thead>
                        <tr>
                            <th>Отправка (город, аэропорт)</th>
                            <th>Прибытие (город, аэропорт)</th>
                            <th>Дата</th>
                            <th>Класс</th>
                            <th>Цена</th>
                            <th>Количество</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr data-id="<?= $ticket['id'] ?>">
                                <td> <?= $ticket['fromCity'] ?>(<?= $ticket['airportFrom'] ?>)</td>
                                <td> <?= $ticket['toCity'] ?>(<?= $ticket['airportTo'] ?>)</td>
                                <td> <?= $ticket['date'] ?></td>
                                <td> <?= $ticket['class'] ?></td>
                                <td> <?= $ticket['price'] ?></td>
                                <td> <?= $ticket['count'] ?></td>
                                <td>
                                    <button class="btn btn-danger"
                                            onclick="removeTicket(<?= $ticket['id'] ?>)">
                                        Удалить
                                    </button>
                                </td>
                            </tr>
                        <? endforeach; ?>
                        </tbody>
                    </table>
                <? else: ?>
                    <p style="text-align: center">Для редактирования билетов необходимо быть администратором</p>
                <? endif; ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="" novalidate id="ticketCreationForm" class="ticket-creation-form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Создание билета</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="from">Город вылета</label>
                                    </div>
                                    <select class="custom-select" id="from" required name="from">
                                        <? foreach ($cities as $city): ?>
                                            <option value="<?= $city['id'] ?>"><?= $city['name'] ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="to">Город прибытия</label>
                                    </div>
                                    <select class="custom-select" id="to" required name="to">
                                        <? foreach ($cities as $city): ?>
                                            <option value="<?= $city['id'] ?>"><?= $city['name'] ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="fromAirport">Аэропорт вылета</label>
                                    </div>
                                    <select class="custom-select" id="fromAirport" required name="fromAirport">
                                        <option value="">Аэропорты отсутствуют</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="toAirport">Аэропорт прибытия</label>
                                    </div>
                                    <select class="custom-select" id="toAirport" required name="toAirport">
                                        <option value="">Аэропорты отсутствуют</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <input type="number" class="form-control" placeholder="Количество пассажиров" required
                                       min="1"
                                       name="count">
                                <div class="invalid-feedback">
                                    Пожалуйста, укажите количество пассажиров
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Класс</label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect01" required name="class">
                                        <option value="1" selected>Бюджет</option>
                                        <option value="2">Комфорт</option>
                                        <option value="3">Бизнес</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Туда</span>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input"
                                           data-target="#datetimepicker1"
                                           aria-describedby="basic-addon1" required name="dateTo">
                                    <div class="input-group-append" data-target="#datetimepicker1"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div class="invalid-feedback">
                                        Пожалуйста, укажите дату вылета
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <input class="form-control" placeholder="Цена" required
                                       min="1"
                                       name="price">
                                <div class="invalid-feedback">
                                    Пожалуйста, укажите цену билета
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
include_once './templates/footer.php';
