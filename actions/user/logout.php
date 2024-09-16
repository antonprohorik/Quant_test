<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    unset($_SESSION['user']);
    session_destroy();
    header('Location: /тестовое/login.php'); 
} else {
    echo 'Only POST requests allowed';
    die();
}
