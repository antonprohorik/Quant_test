<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';

$config = require '../config/database.php';
$db = (new Database($config))->getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password_confirmation'];

    // Проверка на совпадение паролей
    if ($password !== $passwordConfirm) {
        $_SESSION['register_error'] = 'Пароли не совпадают';
        header('Location: ../register.php');
        exit();
    }

    // Попытка регистрации
    if ($user->register($email, $name, $dob, $password)) {
        header('Location: ../login.php');
        exit();
    } else {
        $_SESSION['register_error'] = 'Ошибка при регистрации';
        header('Location: ../register.php');
        exit();
    }
}
