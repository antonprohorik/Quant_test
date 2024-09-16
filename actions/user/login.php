<?php

session_start();
require_once __DIR__ . '/../../app/requires.php';

$email = $_POST['email'];
$password = $_POST['password'];

//TO DO: validation

//1ищем пользователя по почте, 
//2если нашли идем на след шаг, иначк авторизация не полчуилась
//3если пароли совпадают, то идем на след шаг, иначе не вошли
// 4 вошли- создаем сессию 

$query = $db->prepare("SELECT * FROM `users` WHERE `email` = :email");
$query->execute([
    'email' => $email,
]);
$user = $query->fetch(\PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['auth_error'] = true;
    header('Location: /тестовое/login.php');
    die();
}

if (!password_verify($password, $user['password'])) {
    $_SESSION['auth_error'] = true;
    header('Location: /тестовое/login.php');
    die();
}

$_SESSION['user'] = $user['id'];

header('Location: /тестовое/');
