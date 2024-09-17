<?php
session_start();
require_once __DIR__ . '/../../app/requires.php';
$config =require_once __DIR__ . '/../../config/app.php';

if (!isset($_SESSION['user'])) {
    echo 'Error handle action';
    die();
}

$query = $db->prepare("SELECT * FROM `users` WHERE `id` = :id");
$query->execute(['id' => $_SESSION['user']]);
$user = $query->fetch(PDO::FETCH_ASSOC);


$query = $db->prepare("DELETE FROM `tasks`");
$query->execute();

header('Location: /тестовое/my-tickets.php');
