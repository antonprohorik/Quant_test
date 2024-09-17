<?php
session_start();
require_once 'templates/head.php';
?>

<!doctype html>
<html lang="ru">
<head>
    <title>Войти</title>
</head>
<body>
    <?php require_once 'templates/header.php'; ?>
    <section class="main">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    Авторизация
                </div>
                <div class="card-body">
                    <form method="post" action="actions/login.php">
                        <div class="mb-3">
                            <label for="emailField" class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-control" id="emailField" required>
                        </div>
                        <div class="mb-3">
                            <label for="passwordField" class="form-label">Пароль</label>
                            <input type="password" name="password" class="form-control" id="passwordField" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Войти</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php require_once 'templates/scripts.php'; ?>
</body>
</html>
