<?php
session_start();
require_once __DIR__ . '/../../app/requires.php';
$config =require_once __DIR__ . '/../../config/app.php';

if (!isset($_SESSION['user'])) {
    echo 'Error handle action';
    die();
}

$id = $_POST['id'];

$query = $db->prepare("SELECT user_id FROM `tasks` WHERE `id` = :id");
$query->execute(['id' => $id]);
$ticket = $query->fetch(PDO::FETCH_ASSOC);

$query = $db->prepare("SELECT * FROM `users` WHERE `id` = :id");
$query->execute(['id' => $_SESSION['user']]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if ($ticket['user_id'] != $_SESSION['user'] && (int)$user['group_id'] != $config['admin_user_group']) {
    echo 'Error handle action';
    die();
}

$query = $db->prepare("DELETE FROM `tasks` WHERE `id` = :id");
$query->execute(['id' => $id]);

 header('Location: /тестовое/my-tickets.php');