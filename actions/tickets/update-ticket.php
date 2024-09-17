<?php
require_once __DIR__ . '/../../app/requires.php';

session_start();
if (!isset($_SESSION['user'])) {
    echo 'Error handle action';
    die();
}

$taskId = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];

// TO DO: Add validation

$query = $db->prepare("UPDATE tasks SET title = :title, description = :description WHERE id = :id AND user_id = :user_id");

try {
    $query->execute([
        'title' => $title,
        'description' => $description,
        'id' => $taskId,
        'user_id' => $_SESSION['user']
    ]);
    header('Location: /тестовое/my-tickets.php');
} catch (\PDOException $e) {
    echo $e->getMessage();
}