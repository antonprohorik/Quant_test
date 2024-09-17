<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/Task.php';

$config = require '../config/database.php';
$db = (new Database($config))->getConnection();
$task = new Task($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $task->updateTask($taskId, $title, $description);
    header('Location: ../my-tickets.php');
    exit();
}
