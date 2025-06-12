<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php'; 

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rental Mobil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <h1>Login</h1>

            <?php flash('error'); ?>
            <?php flash('success'); ?>

            <form action="proses/login_proses.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            
            <div class="auth-links">
                <p>Belum punya akun? <a href="register.php">Daftar disini</a></p>
                <p><a href="forgot-password.php">Lupa password?</a></p>
            </div>
        </div>
    </div>
    
    <script src="js/script.js"></script>
    <script src="js/auth.js"></script>
</body>
</html>
