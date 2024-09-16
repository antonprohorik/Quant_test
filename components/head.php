<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <link rel="stylesheet" href="src/scss/app.css">
<?php
    require_once __DIR__ . '/../app/requires.php';
    $user = NULL;
    if (isset($_SESSION['user'])) {
        $query = $db->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $query->execute(['id' => $_SESSION['user']]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
    }
?>