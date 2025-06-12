<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../register.php");
    exit();
}

$required_fields = ['nama', 'email', 'username', 'password', 'confirm_password', 'telepon'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        setFlash('error', "Field $field harus diisi");
        header("Location: ../register.php");
        exit();
    }
}

$nama = $db->real_escape_string($_POST['nama']);
$email = $db->real_escape_string($_POST['email']);
$username = $db->real_escape_string($_POST['username']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$telepon = $db->real_escape_string($_POST['telepon']);
$alamat = isset($_POST['alamat']) ? $db->real_escape_string($_POST['alamat']) : '';

if ($password !== $confirm_password) {
    setFlash('error', 'Konfirmasi password tidak cocok');
    header("Location: ../register.php");
    exit();
}

$query = "SELECT id FROM users WHERE username = ? OR email = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('ss', $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    setFlash('error', 'Username atau email sudah terdaftar');
    header("Location: ../register.php");
    exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO users (nama, email, username, password, telepon, alamat, role) 
          VALUES (?, ?, ?, ?, ?, ?, 'user')";
$stmt = $db->prepare($query);
$stmt->bind_param('ssssss', $nama, $email, $username, $hashed_password, $telepon, $alamat);

if ($stmt->execute()) {
    setFlash('success', 'Registrasi berhasil. Silakan login');
    header("Location: ../login.php");
} else {
    setFlash('error', 'Terjadi kesalahan saat menyimpan data');
    header("Location: ../register.php");
}
exit();
?>