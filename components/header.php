
<header class="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/тестовое/">Задачник</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/тестовое/">Задачи</a>
                    </li>
                    <?php 
                     $config = require __DIR__ .'/../config/app.php';
                        if($user) {
                            ?>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Мои задачи
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/тестовое/add-ticket.php">Добавить</a></li>
                            <li><a class="dropdown-item" href="/тестовое/my-tickets.php">Мои задачи 
                                <?php
                                $q = $db->prepare("SELECT COUNT(*) as count FROM `tasks` WHERE `user_id` = :id");
                                $q->execute(['id' => $user['id']]);
                                $count = $q->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <span class="badge bg-secondary"><?= $count['count'] ?></span>
                            </a>
                        </li>
                        </ul>
                    </li>
                            <?php
                        }
                    ?>
                    
                
                </ul>
                <div class="right-side d-flex">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                               <?= !$user ? 'Аккаунт' : $user['name'] ?> 
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                                <?php 
                                if (!$user) {
                                    ?>
                                    <li><a class="dropdown-item" href="/тестовое/login.php">Вход</a></li>
                                    <li><a class="dropdown-item" href="/тестовое/register.php">Регистрация</a></li>
                                    <?php
                                } else {
                                    ?>
                                    <li>
                                    <form action="/тестовое/actions/user/logout.php" method="post">
                                        <button type="submit" class="dropdown-item" type="submit">Выход</button>
                                    </form>
                                    </li>
                                    <?php
                                }
                                ?> 
                            </ul>
                        </li>
                    </ul>
                    <form method="get" action="/тестовое/" class="d-flex">
                        <input class="form-control me-2" value="<?= $_GET['q'] ?? '' ?>" name="q" type="search" placeholder="Поиск задач" aria-label="Поиск задач">
                        <button class="btn btn-outline-success" type="submit">Поиск</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</header>