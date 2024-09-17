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

// Получаем список тегов
$tags = $tag->getAllTags();

// Логика сортировки
$validSortColumns = ['created_at', 'title'];
$sort = $_GET['sort'] ?? '-created_at';
$order = (strpos($sort, '-') === 0) ? 'DESC' : 'ASC';
$sortColumn = ltrim($sort, '-');

if (!in_array($sortColumn, $validSortColumns)) {
    $sortColumn = 'created_at';
}

// Логика поиска
$searchQuery = $_GET['q'] ?? '';
$tickets = $task->getTasksByUser($userId, $sortColumn, $order, $searchQuery);

require_once 'templates/head.php';
?>

<!doctype html>
<html lang="ru">
<head>
    <title>Мои задачи</title>
</head>
<body>
    <?php require_once 'templates/header.php'; ?>
    <section class="main">
        <div class="container">
            <div class="row align-items-center mb-3">
                <h2 class="display-6">Мои задачи</h2>
                <div class="col text-end">
                    <form method="get" action="my-tickets.php" class="d-flex">
                        <input class="form-control me-2" name="q" value="<?= $_GET['q'] ?? '' ?>" type="search" placeholder="Поиск задач" aria-label="Поиск задач">
                        <button class="btn btn-outline-success" type="submit">Поиск</button>
                    </form>
                </div>
            </div>

            <div class="btn-group mb-3">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Сортировать
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="?sort=-created_at">С конца</a></li>
                    <li><a class="dropdown-item" href="?sort=created_at">С начала</a></li>
                    <li><a class="dropdown-item" href="?sort=title">По названию (А-Я)</a></li>
                    <li><a class="dropdown-item" href="?sort=-title">По названию (Я-А)</a></li>
                </ul>
            </div>

            <div class="row">
                <?php if (empty($tickets)): ?>
                    <div class="alert alert-warning" role="alert">
                        Ничего не найдено по данному запросу!
                    </div>
                <?php else: ?>
                    <?php foreach ($tickets as $ticket): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($ticket['title']); ?>
                                    <span class="badge rounded-pill" style="background-color: <?= $ticket['tag_background']; ?>; color: <?= $ticket['tag_color']; ?>">
                                        <?= htmlspecialchars($ticket['tag_label']); ?>
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
        </div>
    </section>
    <?php require_once 'templates/scripts.php'; ?>
</body>
</html>
