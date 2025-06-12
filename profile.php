<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

if (!isset($_SESSION['user'])) {
    setFlash('error', 'Silakan login terlebih dahulu');
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
?>

<?php include 'includes/header.php'; ?>

<main>
    <div class="container">
        <h1>Profil Pengguna</h1>
        <table>
            <tr><td><strong>Nama:</strong></td><td><?= htmlspecialchars($user['nama']) ?></td></tr>
            <tr><td><strong>Email:</strong></td><td><?= htmlspecialchars($user['email']) ?></td></tr>
            <tr><td><strong>Username:</strong></td><td><?= htmlspecialchars($user['username']) ?></td></tr>
            <tr><td><strong>Telepon:</strong></td><td><?= htmlspecialchars($user['telepon']) ?></td></tr>
            <tr><td><strong>Alamat:</strong></td><td><?= htmlspecialchars($user['alamat']) ?></td></tr>
        </table>

        <br>
        <a href="logout.php" class="btn btn-outline">Logout</a>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
