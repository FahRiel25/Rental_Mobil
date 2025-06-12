<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

if (!isset($_GET['id'])) {
    setFlash('error', 'ID transaksi tidak ditemukan');
    header("Location: profile.php");
    exit();
}

$booking_id = intval($_GET['id']);

$query = $db->prepare("SELECT b.*, m.merk, m.model, m.gambar, u.nama, u.email, u.telepon
    FROM booking b
    JOIN mobil m ON b.mobil_id = m.id
    JOIN users u ON b.user_id = u.id
    WHERE b.id = ?");
$query->bind_param('i', $booking_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    setFlash('error', 'Transaksi tidak ditemukan');
    header("Location: profile.php");
    exit();
}

$booking = $result->fetch_assoc();
?>

<main class="container">
    <h1>Detail Transaksi #<?= $booking['id'] ?></h1>

    <div class="booking-details">
        <img src="images/cars/<?= htmlspecialchars($booking['gambar']) ?>" alt="<?= $booking['merk'] ?>" style="width: 250px; border-radius: 8px; margin-bottom: 20px;">

        <div class="car-info">
            <p><strong>Mobil:</strong> <?= $booking['merk'] ?> <?= $booking['model'] ?></p>
            <p><strong>Tanggal:</strong> <?= formatDate($booking['tanggal_mulai']) ?> - <?= formatDate($booking['tanggal_selesai']) ?></p>
            <p><strong>Durasi:</strong> <?= $booking['durasi'] ?> hari</p>
            <p><strong>Total:</strong> <?= formatCurrency($booking['total']) ?></p>
            <p><strong>Status:</strong> <span class="status-badge <?= $booking['status'] ?>"><?= ucfirst($booking['status']) ?></span></p>
        </div>

        <hr>

        <div class="payment-info">
            <h3>Informasi Pembayaran</h3>
            <p><strong>Metode Pembayaran:</strong> <?= ucwords(str_replace('_', ' ', $booking['metode_pembayaran'])) ?></p>
            
            <?php if ($booking['bukti_pembayaran']): ?>
                <p><strong>Bukti Pembayaran:</strong></p>
                <img src="images/bukti/<?= htmlspecialchars($booking['bukti_pembayaran']) ?>" alt="Bukti" style="max-width: 300px; border: 1px solid #ccc; border-radius: 6px;">
            <?php elseif ($booking['metode_pembayaran'] === 'cod'): ?>
                <p><em>Pembayaran akan dilakukan saat penjemputan.</em></p>
            <?php else: ?>
                <p><em>Belum ada bukti pembayaran.</em></p>
            <?php endif; ?>
        </div>

        <hr>

        <div class="user-info">
            <h3>Informasi Pelanggan</h3>
            <p><strong>Nama:</strong> <?= htmlspecialchars($booking['nama']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($booking['email']) ?></p>
            <p><strong>Telepon:</strong> <?= htmlspecialchars($booking['telepon']) ?></p>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
