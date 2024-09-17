<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Удаляем информацию о пользователе из сессии
    unset($_SESSION['user']);
    session_destroy();
    header('Location: ../login.php');
    exit();
} else {
    echo 'Метод запроса должен быть POST';
}
