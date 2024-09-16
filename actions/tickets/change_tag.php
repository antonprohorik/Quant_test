<?php
session_start();
require_once __DIR__ . '/../../app/requires.php';
$config = require __DIR__ . '/../../config/app.php';

if (!isset($_SESSION['user'])) {
    echo 'Error handle action';
    die();
}

$id = $_POST['id'];
$tag = $_POST['tag'];

$q= $db->prepare("SELECT * FROM `tasks_tags` WHERE `id` = :id");
$q->execute(['id' => $tag]);
$tagExists = $q->fetch(PDO::FETCH_ASSOC);

if(!$tagExists) {
    echo 'Error handle action';
    die();
}

$query = $db->prepare("SELECT * FROM `users` WHERE `id` = :id");
$query->execute(['id' => $_SESSION['user']]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if((int)$user['group_id'] === $config['default_user_group']) {
    $q = $db->prepare("UPDATE `tasks` SET `tag_id` = :tag WHERE `id` = :id");
    try{
        $q->execute([
            'tag' => $tag,
            'id' => $id
        ]);
    } catch(\PDOException $e) {
        echo $e->getMessage();
    }
}

header('Location: /тестовое/my-tickets.php');