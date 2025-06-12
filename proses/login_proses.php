<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php");
    exit();
}

$username = $db->real_escape_string($_POST['username']);
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username = ? LIMIT 1";
$stmt = $db->prepare($query);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;

        $redirect_url = $_SESSION['redirect_url'] ?? ($user['role'] === 'admin' ? '../admin/dashboard.php' : '../index.php');
        unset($_SESSION['redirect_url']);
        
        header("Location: $redirect_url");
    } else {
        flash('error', 'Password salah');
        header("Location: ../login.php");
    }
} else {
    flash('error', 'Username tidak ditemukan');
    header("Location: ../login.php");
}
exit();
