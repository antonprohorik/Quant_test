<?php
session_start();
require_once 'templates/head.php';
?>

<!doctype html>
<html lang="ru">
<head>
    <title>Добавить задачу</title>
</head>
<body>
    <?php require_once 'templates/header.php'; ?>
    <section class="main">
        <div class="container">
            <div class="row">
                <h2 class="display-6 mb-3">Добавить задачу</h2>
            </div>
            <div class="row">
                <form action="actions/add-task.php" method="post">
                    <div class="mb-3">
                        <label for="titleField" class="form-label">Тема задачи</label>
                        <input type="text" name="title" class="form-control" id="titleField" required>
                    </div>
                    <div class="mb-3">
                        <label for="descriptionField" class="form-label">Описание</label>
                        <textarea name="description" class="form-control" id="descriptionField" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить задачу</button>
                </form>
            </div>
        </div>
    </section>
    <?php require_once 'templates/scripts.php'; ?>
</body>
</html>
