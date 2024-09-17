<?php 
session_start(); 
if (!isset($_SESSION['user'])) {
    header('Location: /тестовое/login.php');
}

require_once __DIR__ . '/app/requires.php';

$taskId = $_GET['id'];

$query = $db->prepare("SELECT * FROM tasks WHERE id = :id AND user_id = :user_id");
$query->execute(['id' => $taskId, 'user_id' => $_SESSION['user']]);
$task = $query->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    echo 'Задача не найдена';
    die();
}
?>
<!doctype html>
<html lang="ru">
<head>
     <?php require_once __DIR__ .'/components/head.php'; ?>
    <title>Редактировать задачу</title>
</head>
<body>
<?php require_once __DIR__ .'/components/header.php'; ?>
<section class="main">
    <div class="container">
        <div class="row">
            <h2 class="display-6 mb-3">Редактировать задачу</h2>
        </div>
        <div class="row">
            <form action="/тестовое/actions/tickets/update-ticket.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $task['id']; ?>"> 
                <div class="mb-3">
                    <label for="titleField" class="form-label">Тема задачи</label>
                    <input type="text" name="title" class="form-control" id="titleField" value="<?= htmlspecialchars($task['title']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="descriptionField" class="form-label">Описание</label>
                    <textarea name="description" class="form-control" id="descriptionField"><?= htmlspecialchars($task['description']); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </form>
        </div>
    </div>
</section>
<?php require_once __DIR__ .'/components/scripts.php'; ?>
</body>
</html>