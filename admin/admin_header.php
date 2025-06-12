<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Rental Mobil</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header style="background-color: #2c3e50; padding: 20px 0;">
        <div class="container">
            <h1 style="color: white; text-align: center;">Admin Panel</h1>
            <nav style="text-align: center; margin-top: 15px;">
                <a href="dashboard.php" style="color: white; margin: 0 15px;">Dashboard</a>
                <a href="mobil.php" style="color: white; margin: 0 15px;">Kelola Mobil</a>
                <a href="booking.php" style="color: white; margin: 0 15px;">Kelola Booking</a>
                <a href="../proses/logout.php" style="color: #e74c3c; margin: 0 15px;">Logout</a>
            </nav>
        </div>
    </header>
    <main class="container" style="margin-top: 30px;">
