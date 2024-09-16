<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: /тестовое/login.php');
    }
?>
<!doctype html>
<html lang="ru">
<head>
     <?php require_once __DIR__ .'/components/head.php'; 
     $config = require __DIR__ .'/config/app.php';
     ?>
    <title>Главная</title>
</head>
<?php 
    require_once __DIR__ . '/database/db.php';
?>
<body>
<?php require_once __DIR__ .'/components/header.php'; ?>
<section class="main">
    <div class="container">
    <div class="row align-items-center mb-3">
    <h2 class="display-6">Задачи</h2>
    <div class="col text-end">
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Сортировать
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?sort=-created_at">С конца</a></li>
                <li><a class="dropdown-item" href="?sort=created_at">С начала</a></li>
                <li><a class="dropdown-item" href="?sort=description">По названию</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="?sort=-created_at">Сбросить</a></li>
            </ul>
        </div>
    </div>


    <div class="form-check ">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="<?= $config['success_tickets_tag']; ?>">
  <label class="form-check-label" for="flexRadioDefault1">
    Выполнена
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="<?= $config['in_progress_tickets_tag']; ?>" checked>
  <label class="form-check-label" for="flexRadioDefault2">
    В процессе
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" value="<?= $config['reject_tickets_tag']; ?>" checked>
  <label class="form-check-label" for="flexRadioDefault3">
    Не выполнена
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault4" value="<?= $config['default_tickets_tag']; ?>" checked>
  <label class="form-check-label" for="flexRadioDefault4">
    Создана
  </label>
</div>
</div>
        <div class="row">
            <?php
            $sort = $_GET['sort'] ?? '-created_at';
            $order = (strpos($sort, '-') === 0) ? 'DESC' : 'ASC';
            $sort = ltrim($sort, '-');
            $query = $db->prepare("SELECT * FROM `tasks` WHERE `user_id` = :user_id ORDER BY `{$sort}` {$order}");
            $query->execute(['user_id' => $_SESSION['user']]);
            $tickets = $query->fetchAll(PDO::FETCH_ASSOC);


            if(empty($tickets)) {
                ?>
                <div class="alert alert-warning" role="alert">
                Ничего не найдено по данному запросу!
                </div>
                <?php
            }

            $tags = $db->query("SELECT * FROM `tasks_tags`")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($tickets as $ticket) {
                $tagId = $ticket['tag_id'];
                        $tag = array_filter($tags, function ($tag) use ($tagId) {
                            return (int)$tag['id'] === (int)$tagId;
                        });
                $tag = array_shift($tag);
                ?>
                <div class="card mb-3">
               
                <div class="card-body">
                <h5 class="card-title"><?= $ticket['title'] ?>
                <span class="badge rounded-pill" 
                        style="background:<?= $tag['background']; ?>; color:<?= $tag['color']; ?>">
                            <?= $tag['label']; ?>
                        </span>
                 </h5>
                    <p class="card-text"><?= $ticket['description'] ?></p>
                    <p class="card-text"><small class="text-muted">Добавлено: <?= date('d.m.Y H:i', strtotime($ticket['created_at'])) ?></small></p>
                </div>
                </div>
                <?php
            }
            ?>            
        </div>
    </div>
</section>
<?php require_once __DIR__ .'/components/scripts.php'; ?>
</body>
</html>