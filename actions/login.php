<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';

$config = require '../config/database.php';
$db = (new Database($config))->getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Проверяем корректность введенных данных
    if ($user->login($email, $password)) {
        header('Location: ../index.php');
        exit();
    } else {
        $_SESSION['auth_error'] = 'Неверные учетные данные';
        header('Location: ../login.php');
        exit();
    }
}

