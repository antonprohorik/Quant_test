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

// Получаем задачи и теги
$tickets = $task->getTasksByUser($userId);
$tags = $tag->getAllTags();
?>

<!doctype html>
<html lang="ru">
<head>
    <?php require_once 'templates/head.php'; ?>
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
                        <?php
                        // Получаем информацию о теге
                        $tagId = $ticket['tag_id'];
                        $tagInfo = $tag->getTagById($tagId);
                        ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($ticket['title']); ?>
                                    <span class="badge rounded-pill" style="background: <?= $tagInfo['background']; ?>; color: <?= $tagInfo['color']; ?>">
                                        <?= htmlspecialchars($tagInfo['label']); ?>
                                    </span>
                                </h5>
                                <p class="card-text"><?= htmlspecialchars($ticket['description']); ?></p>
                                <p class="card-text"><small class="text-muted">Добавлено: <?= date('d.m.Y H:i', strtotime($ticket['created_at'])); ?></small></p>
                                <form action="actions/delete-task.php" method="post">
                                    <input type="hidden" name="id" value="<?= $ticket['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Удалить</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
       
