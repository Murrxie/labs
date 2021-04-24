<?php  session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Airbus23.ru</title>
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Trade+Winds&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><img class="logo" src="../images/logo.jpg" alt="">Airbus23.ru</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <h3 class="main-text">Дешевые авиабилеты</h3>
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="../index.php">Главная<span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="../pages/aboutUs.php">О нас</a>
                <?php if ($_SESSION['name']): ?>
                <a class="nav-item nav-link" href="../pages/orders.php">Мои заказы</a>
                <?php endif; ?>
                <?php if ($_SESSION['name'] == 'admin@mail.ru'): ?>
                    <a class="nav-item nav-link" href="../admin.php">Админ панель</a>
                <?php endif; ?>
                <?php if ($_SESSION['name']): ?>
                <a class="nav-item nav-link" href="../app/logout.php">Выход</a>
                <?php else: ?>
                <a class="nav-item nav-link" href="#" data-toggle="modal" data-target="#loginModal">Вход/регистрация</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Личный кабинет</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#login">Вход</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#registration">Регистрация</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="login">
                            <form id="loginForm">
                                <div class="form-group">
                                    <label for="loginEmail">Email</label>
                                    <input type="text" class="form-control" name="loginEmail" id="loginEmail" aria-describedby="emailHelp" required>
                                </div>
                                <div class="form-group">
                                    <label for="loginPassword">Пароль (Минимум 6 символов. 1 Строчная, 1 прописная, 1 цифра)</label>
                                    <input name="loginPassword" type="password" class="form-control" id="loginPassword" required minlength="6" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Запомнить меня</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Войти</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="registration">
                            <form id="registrationForm">
                                <div class="form-group">
                                    <label for="registrationEmail">Email</label>
                                    <input type="email" class="form-control" id="registrationEmail" aria-describedby="emailHelp" required name="email">
                                </div>
                                <div class="form-group">
                                    <label for="registrationPassword">Пароль (Минимум 6 символов. 1 Строчная, 1 прописная, 1 цифра)</label>
                                    <input type="password" class="form-control" id="registrationPassword" required minlength="6" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" name="password">
                                </div>
                                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
