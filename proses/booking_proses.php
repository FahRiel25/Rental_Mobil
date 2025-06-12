<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setFlash('error', 'Akses tidak valid');
    header("Location: ../cars.php");
    exit();
}

if (!isset($_SESSION['user'])) {
    $_SESSION['redirect_url'] = $_SERVER['HTTP_REFERER'] ?? '../cars.php';
    setFlash('error', 'Silakan login terlebih dahulu');
    header("Location: ../login.php");
    exit();
}

$required_fields = ['car_id', 'tanggal_mulai', 'tanggal_selesai', 'metode_pembayaran', 'nama', 'telepon', 'alamat'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        setFlash('error', 'Harap isi semua field yang diperlukan');
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

$car_id = intval($_POST['car_id']);
$user_id = $_SESSION['user']['id'];
$tanggal_mulai = $db->real_escape_string($_POST['tanggal_mulai']);
$tanggal_selesai = $db->real_escape_string($_POST['tanggal_selesai']);
$metode_pembayaran = $db->real_escape_string($_POST['metode_pembayaran']);
$nama = $db->real_escape_string($_POST['nama']);
$telepon = $db->real_escape_string($_POST['telepon']);
$alamat = $db->real_escape_string($_POST['alamat']);
$catatan = isset($_POST['catatan']) ? $db->real_escape_string($_POST['catatan']) : '';

$bukti_pembayaran = null;
$foto_ktp = null;

if ($tanggal_selesai < $tanggal_mulai) {
    setFlash('error', 'Tanggal selesai tidak boleh sebelum tanggal mulai');
    header("Location: ../booking.php?car_id=$car_id");
    exit();
}

$car = $db->query("SELECT harga FROM mobil WHERE id = $car_id")->fetch_assoc();
if (!$car) {
    setFlash('error', 'Data mobil tidak ditemukan');
    header("Location: ../cars.php");
    exit();
}

$durasi = calculateDuration($tanggal_mulai, $tanggal_selesai);
$total_harga = $car['harga'] * $durasi;

if (in_array($metode_pembayaran, ['transfer_bank', 'ewallet'])) {
    if (isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['bukti_pembayaran']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $allowed)) {
            setFlash('error', 'Format bukti pembayaran tidak valid.');
            header("Location: ../booking.php?car_id=$car_id");
            exit();
        }

        $bukti_pembayaran = uniqid('bukti_') . '.' . $ext;
        move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], '../images/bukti/' . $bukti_pembayaran);
    } else {
        setFlash('error', 'Harap unggah bukti pembayaran.');
        header("Location: ../booking.php?car_id=$car_id");
        exit();
    }
}

if (isset($_FILES['foto_ktp']) && $_FILES['foto_ktp']['error'] === 0) {
    $ext = strtolower(pathinfo($_FILES['foto_ktp']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($ext, $allowed)) {
        setFlash('error', 'Format foto KTP tidak valid.');
        header("Location: ../booking.php?car_id=$car_id");
        exit();
    }

    $foto_ktp = uniqid('ktp_') . '.' . $ext;
    move_uploaded_file($_FILES['foto_ktp']['tmp_name'], '../images/ktp/' . $foto_ktp);
}

$query = "INSERT INTO booking (
    user_id, mobil_id, tanggal_mulai, tanggal_selesai, durasi, total, catatan, status,
    metode_pembayaran, bukti_pembayaran, nama, telepon, alamat, foto_ktp
) VALUES (?, ?, ?, ?, ?, ?, ?, 'diproses', ?, ?, ?, ?, ?, ?)";

$stmt = $db->prepare($query);
$stmt->bind_param(
    'iissidsssssss',
    $user_id, $car_id, $tanggal_mulai, $tanggal_selesai, $durasi, $total_harga,
    $catatan, $metode_pembayaran, $bukti_pembayaran,
    $nama, $telepon, $alamat, $foto_ktp
);

if ($stmt->execute()) {
    $db->query("UPDATE mobil SET status = 'tidak tersedia' WHERE id = $car_id");
    $booking_id = $db->insert_id;
    setFlash('success', 'Booking berhasil dibuat. Silakan cek detail transaksi.');
    header("Location: ../transaksi.php?id=$booking_id");
} else {
    setFlash('error', 'Gagal menyimpan booking.');
    header("Location: ../booking.php?car_id=$car_id");
}
exit();
