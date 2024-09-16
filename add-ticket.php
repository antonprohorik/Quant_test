<?php 
session_start(); 
if (!isset($_SESSION['user'])) {
    header('Location: /тестовое/login.php');
}
?>
<!doctype html>
<html lang="ru">
<head>
     <?php require_once __DIR__ .'/components/head.php'; ?>
    <title>Добавить задачу</title>
</head>
<body>
<?php require_once __DIR__ .'/components/header.php'; ?>
<section class="main">
    <div class="container">
        <div class="row">
            <h2 class="display-6 mb-3">Добавить задачу</h2>
        </div>
        <div class="row">
            <form action="/тестовое/actions/tickets/store.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="fullNameField" class="form-label">Тема задачи</label>
                    <input type="text" name="title" class="form-control" id="fullNameField" aria-describedby="emailHelp" required>
                </div>
                <div class="mb-3">
                    <label for="dobField" class="form-label">Описание</label>
                    <textarea name="description" class="form-control" id="dobField" aria-describedby="emailHelp"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Добавить задачу</button>
            </form>
        </div>
    </div>
</section>
<?php require_once __DIR__ .'/components/scripts.php'; ?>
</body>
</html>