<?php
require_once __DIR__ . '/../../app/requires.php';
$config = require_once __DIR__ . '/../../config/app.php';

session_start();
if (!isset($_SESSION['user'])) {
    echo 'Error handle action';
    die();
}

$title = $_POST['title'];
$description = $_POST['description'];
//TO DO: Add validation


$query = $db->prepare("INSERT INTO `tasks` (`title`, `description`, `tag_id`, `user_id`) VALUES (:title, :description, :tag_id, :user_id);");

try {
    $query->execute([
        'title' => $title,
        'description' => $description,
        'tag_id' => $config['default_tickets_tag'],
        'user_id' => $_SESSION['user']
    ]);
    header('Location: /тестовое/my-tickets.php' );
} catch (\PDOException $e) {
    echo $e->getMessage();
}