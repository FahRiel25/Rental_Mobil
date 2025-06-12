<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../contact.php");
    exit();
}

// Validasi input
$required_fields = ['nama', 'email', 'pesan'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        setFlash('error', "Field $field harus diisi");
        header("Location: ../contact.php");
        exit();
    }
}

// Sanitasi input
$nama = $db->real_escape_string($_POST['nama']);
$email = $db->real_escape_string($_POST['email']);
$telepon = isset($_POST['telepon']) ? $db->real_escape_string($_POST['telepon']) : '';
$pesan = $db->real_escape_string($_POST['pesan']);

// Simpan ke database
$query = "INSERT INTO kontak (nama, email, telepon, pesan) VALUES (?, ?, ?, ?)";
$stmt = $db->prepare($query);
$stmt->bind_param('ssss', $nama, $email, $telepon, $pesan);

if ($stmt->execute()) {
    // Kirim email notifikasi (contoh sederhana)
    $to = 'admin@rentalmobil.com';
    $subject = 'Pesan Baru dari ' . $nama;
    $message = "Email: $email\nTelepon: $telepon\nPesan:\n$pesan";
    mail($to, $subject, $message);
    
    setFlash('success', 'Pesan Anda telah terkirim. Kami akan segera menghubungi Anda');
} else {
    setFlash('error', 'Terjadi kesalahan saat mengirim pesan');
}

header("Location: ../contact.php");
exit();
?>