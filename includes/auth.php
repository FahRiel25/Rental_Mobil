<?php
session_start();

if(!isset($_SESSION['user'])) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Silakan login terlebih dahulu'
    ];
    header("Location: ../login.php");
    exit();
}

if($_SESSION['user']['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    header("Location: ../login.php?timeout=1");
    exit();
}

$_SESSION['last_activity'] = time();
?>