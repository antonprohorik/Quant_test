<?php
session_start();
require_once 'templates/head.php';
?>

<!doctype html>
<html lang="ru">
<head>
    <title>Регистрация</title>
</head>
<body>
    <?php require_once 'templates/header.php'; ?>
    <section class="main">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    Регистрация
                </div>
                <div class="card-body">
                    <form method="post" action="actions/register.php">
                        <div class="mb-3">
                            <label for="emailRegisterField" class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-control" id="emailRegisterField" required>
                        </div>
                        <div class="mb-3">
                            <label for="fullNameField" class="form-label">ФИО</label>
                            <input type="text" name="name" class="form-control" id="fullNameField" required>
                        </div>
                        <div class="mb-3">
                            <label for="dobField" class="form-label">Дата рождения</label>
                            <input type="date" name="dob" class="form-control" id="dobField" required>
                        </div>
                        <div class="mb-3">
                            <label for="passwordRegisterField" class="form-label">Пароль</label>
                            <input type="password" name="password" class="form-control" id="passwordRegisterField" required>
                        </div>
                        <div class="mb-3">
                            <label for="passwordConfirmField" class="form-label">Подтверждение пароля</label>
                            <input type="password" name="password_confirmation" class="form-control" id="passwordConfirmField" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Создать аккаунт</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php require_once 'templates/scripts.php'; ?>
</body>
</html>
