<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' | ' : '' ?>Rental Mobil</title>
    
    <link rel="stylesheet" href="/Rental_Mobil/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?= isset($additionalCSS) ? $additionalCSS : '' ?>
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="/Rental_Mobil/index.php" class="logo">Rental<span>Mobil</span></a>
                <ul class="nav-links">
                    <li><a href="/Rental_Mobil/index.php">Home</a></li>
                    <li><a href="/Rental_Mobil/about.php">Tentang Kami</a></li>
                    <li><a href="/Rental_Mobil/cars.php">Mobil</a></li>
                    <li><a href="/Rental_Mobil/contact.php">Kontak</a></li>
                    <?php if(isset($_SESSION['user'])): ?>
                        <li><a href="/Rental_Mobil/profile.php"><?= $_SESSION['user']['nama'] ?></a></li>
                        <li><a href="/Rental_Mobil/proses/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="/Rental_Mobil/login.php">Login</a></li>
                        <li><a href="/Rental_Mobil/register.php">Daftar</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <?php
    if(isset($_SESSION['flash'])) {
        echo '<div class="alert ' . $_SESSION['flash']['type'] . '">' . $_SESSION['flash']['message'] . '</div>';
        unset($_SESSION['flash']);
    }
    ?>
