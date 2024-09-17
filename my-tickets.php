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
         if (isset($_SESSION["user"])) {
            $config = require __DIR__ .'/config/app.php';
        }
     ?>
    <title>Мои задачи</title>
    
</head>
<body>
<?php require_once __DIR__ .'/components/header.php'; ?>
<section class="main">
    <div class="container">
        <div class="row">
            <h2 class="display-6 mb-3">Мои задачи</h2>
            <div class="col text-end">
                <form action="/тестовое/actions/tickets/remove-all.php" method="post">
                    <input type="hidden" name="id" value="<?= $ticket['id']; ?>">   
                    <button type="submit" class="btn btn-danger">Удалить все задачи</button>
                </form> 
            </div>
        </div>
        <div class="row">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col" style="width: 30%">Название</th>
                    <th scope="col" style="width: 40%">Описание</th>
                    <th scope="col" style="width: 20%">Статус</th>
                    <th scope="col" style="width: 10%">Действия</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    
                    $tags = $db->query("SELECT * FROM `tasks_tags`")->fetchAll(PDO::FETCH_ASSOC);;

                    $query = $db->prepare("SELECT * FROM `tasks` WHERE `user_id` = :user_id");
                    $query->execute(['user_id' => $_SESSION['user']]);
                    $tickets = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($tickets as $ticket) {
                        $tagId = $ticket['tag_id'];
                        $tag = array_filter($tags, function ($tag) use ($tagId) {
                            return (int)$tag['id'] === (int)$tagId;
                        });
                        $tag = array_shift($tag);
                        ?>
                    <tr>
                    <td style="text-align: left"><?= $ticket['title']; ?></td>
                    <td style="text-align: left"><?= $ticket['description']; ?></td>
                    <td style="text-align: left">
                        <span class="badge rounded-pill" 
                        style="background:<?= $tag['background']; ?>; color:<?= $tag['color']; ?>">
                            <?= $tag['label']; ?>
                        </span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Действия
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li>
                        <form action="/тестовое/actions/tickets/change_tag.php" method="post">
                        <input type="hidden" name="id" value="<?= $ticket['id']; ?>"> 
                        <input type="hidden" name="tag" value="<?= $config['success_tickets_tag']; ?>">   
                        <button type="submit" class="dropdown-item">Выполнено</button>
                        </li>
                        </form>  
                        <li>
                        <form action="/тестовое/actions/tickets/change_tag.php" method="post">
                        <input type="hidden" name="id" value="<?= $ticket['id']; ?>">  
                        <input type="hidden" name="tag" value="<?= $config['in_progress_tickets_tag']; ?>">    
                        <button type="submit" class="dropdown-item">В процессе</button>
                        </li>
                        </form>     
                        <li>
                        <form action="/тестовое/actions/tickets/change_tag.php" method="post">
                        <input type="hidden" name="id" value="<?= $ticket['id']; ?>">   
                        <input type="hidden" name="tag" value="<?= $config['reject_tickets_tag']; ?>">    
                        <button type="submit" class="dropdown-item">Не выполнена</button>
                        </li>
                        </form>  
                        <li>
                        <form action="/тестовое/edit-ticket.php" method="get">
                        <input type="hidden" name="id" value="<?= $ticket['id']; ?>">   
                        <button type="submit" class="dropdown-item">Редактировать</button>
                        </form>   
                        </li>
                        <li>
                        <form action="/тестовое/actions/tickets/remove.php" method="post">
                        <input type="hidden" name="id" value="<?= $ticket['id']; ?>">   
                        <button type="submit" class="dropdown-item">Удалить</button>
                        </form>   
                        </li>
                        </ul>
                        </div>
                    </td>
                </tr>
                    <?php  
                    
                    } 
                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php require_once __DIR__ .'/components/scripts.php'; ?>
</body>
</html>

