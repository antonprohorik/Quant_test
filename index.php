<?php
    session_start();
?>
<!doctype html>
<html lang="ru">
<head>
     <?php require_once __DIR__ .'/components/head.php'; 
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
                <li><a class="dropdown-item" href="#">по тому</a></li>
                <li><a class="dropdown-item" href="#">по сему</a></li>
                <li><a class="dropdown-item" href="#">ага там сям</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">сбросить</a></li>
            </ul>
        </div>
    </div>
</div>
        <div class="row">
            <?php
            if(isset($_GET['q'])) {
                $q = $db->prepare("SELECT * FROM `tasks` WHERE `title` LIKE :q ORDER BY `id` DESC");
                $q->execute(['q'=> "%{$_GET['q']}%"]);
                $tickets = $q->fetchAll(PDO::FETCH_ASSOC);
            }else {
            $tickets = $db->query("SELECT * FROM `tasks` ORDER BY `id` DESC")->fetchAll(PDO::FETCH_ASSOC);
            }

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