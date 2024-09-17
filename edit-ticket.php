<?php
session_start();
require_once 'classes/Database.php';
require_once 'classes/Task.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$config = require 'config/database.php';
$db = (new Database($config))->getConnection();
$task = new Task($db);

$taskId = $_GET['id'] ?? null;

if (!$taskId) {
    echo 'ID задачи не задан.';
    exit();
}

$taskData = $task->getTaskById($taskId, $_SESSION['user']);

if (!$taskData) {
    echo 'Задача не найдена.';
    exit();
}

require_once 'templates/head.php';
?>

<!doctype html>
<html lang="ru">
<head>
    <title>Редактировать задачу</title>
</head>
<body>
    <?php require_once 'templates/header.php'; ?>
    <section class="main">
        <div class="container">
            <div class="row">
                <h2 class="display-6 mb-3">Редактировать задачу</h2>
            </div>
            <div class="row">
                <form action="actions/edit-task.php" method="post">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($taskData['id']); ?>">
                    <div class="mb-3">
                        <label for="titleField" class="form-label">Тема задачи</label>
                        <input type="text" name="title" class="form-control" id="titleField" value="<?= htmlspecialchars($taskData['title']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="descriptionField" class="form-label">Описание</label>
                        <textarea name="description" class="form-control" id="descriptionField" required><?= htmlspecialchars($taskData['description']); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                </form>
            </div>
        </div>
    </section>
    <?php require_once 'templates/scripts.php'; ?>
</body>
</html>
