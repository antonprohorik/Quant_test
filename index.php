<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/Task.php';
require_once 'classes/Tag.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$config = require 'config/database.php';
$db = (new Database($config))->getConnection();
$task = new Task($db);
$tag = new Tag($db);

$userId = $_SESSION['user'];

// Получаем список задач и теги
$tickets = $task->getTasksByUser($userId);
$tags = $tag->getAllTags();

require_once 'templates/head.php';
?>

<!doctype html>
<html lang="ru">
<head>
    <title>Главная</title>
</head>
<body>
    <?php require_once 'templates/header.php'; ?>
    <section class="main">
        <div class="container">
            <div class="row align-items-center mb-3">
                <h2 class="display-6">Задачи</h2>
                <div class="col text-end">
                    <a href="add-task.php" class="btn btn-primary">Добавить задачу</a>
                </div>
            </div>
            <div class="row">
                <?php if (empty($tickets)): ?>
                    <div class="alert alert-warning" role="alert">
                        Нет задач.
                    </div>
                <?php else: ?>
                    <?php foreach ($tickets as $ticket): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($ticket['title']); ?></h5>
                                <p class="card-text"><?= htmlspecialchars($ticket['description']); ?></p>
                                <p class="card-text"><small class="text-muted">Добавлено: <?= date('d.m.Y H:i', strtotime($ticket['created_at'])); ?></small></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php require_once 'templates/scripts.php'; ?>
</body>
</html>
