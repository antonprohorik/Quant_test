<?php
session_start();
require_once __DIR__ . '/../../app/requires.php';
$config = require_once __DIR__ . '/../../config/app.php';

$email = $_POST['email'];
$name = $_POST['name'];
$dob = $_POST['dob'];
$password = $_POST['password'];
$passwordConfirm = $_POST['password_confirmation'];

$error = false;
$fields = [
    'email' => [
        'value'=> $email,
        'error'=> false,
    ],
    'name' => [
        'value'=> $name,
        'error'=> false,
    ],
    'dob' => [
        'value'=> $dob,
        'error'=> false,
    ],
    'password' => [
        'error'=> false,
    ],
];

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $fields['email']['error'] = true;
    $error = true;
}

if (empty($name)) {
    $fields['name']['error'] = true;
    $error = true;
}

if (empty($dob)) {
    $fields['dob']['error'] = true;
    $error = true;
}

if ($password !== $passwordConfirm) {
    $fields['password']['error'] = true;
    $error = true;
}

if ($error) {
    $_SESSION['fields'] = $fields;
    header('Location: /тестовое/register.php');
}

$query = $db->prepare("INSERT INTO `users` ( `email`, `name`, `dob`, `password`, `group_id`) VALUES (:email, :name, :dob, :password, :group_id)");
try {
    $query->execute([
        'email' => $email,
        'name' => $name,
        'dob' => $dob,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'group_id' => $config['default_user_group'],
    ]);
    header('Location: /тестовое/login.php');
} catch (\PDOException $e) {
    $_SESSION['fields'] = $fields;
    header('Location: /тестовое/register.php');
}
