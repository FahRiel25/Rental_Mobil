<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h1>Profil Pengguna</h1>
        <table>
            <tr><td><strong>Nama:</strong></td><td><?= htmlspecialchars($user['nama']) ?></td></tr>
            <tr><td><strong>Email:</strong></td><td><?= htmlspecialchars($user['email']) ?></td></tr>
            <tr><td><strong>Username:</strong></td><td><?= htmlspecialchars($user['username']) ?></td></tr>
            <tr><td><strong>Telepon:</strong></td><td><?= htmlspecialchars($user['telepon']) ?></td></tr>
            <tr><td><strong>Alamat:</strong></td><td><?= htmlspecialchars($user['alamat']) ?></td></tr>
        </table>
        <p><a href="logout.php" class="btn">Logout</a></p>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
