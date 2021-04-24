<?php
include_once 'templates/header.php';

$cities = include_once './app/cities.php';
?>
<div class="container-fluid content">
    <div class="search-form-block">
        <form action="" novalidate class="search-form">
            <div class="form-row">
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="from">Вылет</label>
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
                            <label class="input-group-text" for="to">Прибытие</label>
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
                    <input type="number" class="form-control" placeholder="Количество пассажиров" required min="1"
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
                            <option value="0">Любой</option>
                            <option value="1">Бюджет</option>
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
                        <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1"
                               aria-describedby="basic-addon1" required name="dateTo">
                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                        <div class="invalid-feedback">
                            Пожалуйста, укажите дату вылета
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon2">Обратно</span>
                        </div>
                        <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker2"
                               required name="dateBack">
                        <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                        <div class="invalid-feedback">
                            Пожалуйста, укажите дату прибытия
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <button id="searchButton" class="btn btn-warning" type="submit">Найти билеты</button>
                </div>
            </div>
            <div class="search-result"></div>
        </form>
    </div>
</div>

<?php
include_once 'templates/footer.php'
?>
