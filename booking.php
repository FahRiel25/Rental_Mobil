<?php
session_start();
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/config/database.php';

if (!isset($_GET['car_id'])) {
    header("Location: cars.php?error=missing_car_id");
    exit();
}

$car_id = intval($_GET['car_id']);

$query = $db->prepare("SELECT * FROM mobil WHERE id = ?");
$query->bind_param('i', $car_id);
$query->execute();
$car = $query->get_result()->fetch_assoc();

if (!$car) {
    header("Location: cars.php?error=car_not_found");
    exit();
}

if (!isset($_SESSION['user'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit();
}
?>

<main class="container">
    <h1>Booking <?= htmlspecialchars($car['merk']) ?> <?= htmlspecialchars($car['model']) ?></h1>

    <div class="booking-details">
        <img src="images/cars/<?= htmlspecialchars($car['gambar']) ?>" alt="<?= htmlspecialchars($car['merk']) ?>">

        <div class="car-info">
            <p><strong>Harga per Hari:</strong> Rp <?= number_format($car['harga'], 0, ',', '.') ?></p>
            <p><strong>Tahun:</strong> <?= htmlspecialchars($car['tahun']) ?></p>
            <p><strong>Status:</strong>
                <span class="status-badge <?= $car['status'] === 'tersedia' ? 'available' : 'unavailable' ?>">
                    <?= ucfirst($car['status']) ?>
                </span>
            </p>
        </div>
    </div>

    <form action="proses/booking_proses.php" method="post" enctype="multipart/form-data" class="booking-form">
        <input type="hidden" name="car_id" value="<?= $car['id'] ?>">

        <div class="form-group">
            <label for="tanggal_mulai">Tanggal Mulai:</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" required min="<?= date('Y-m-d') ?>">
        </div>

        <div class="form-group">
            <label for="tanggal_selesai">Tanggal Selesai:</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai" required>
        </div>

        <div class="form-group">
            <label for="nama">Nama Lengkap:</label>
            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($_SESSION['user']['nama'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="telepon">Nomor HP:</label>
            <input type="text" id="telepon" name="telepon" value="<?= htmlspecialchars($_SESSION['user']['telepon'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat Lengkap:</label>
            <textarea id="alamat" name="alamat" rows="2" required><?= htmlspecialchars($_SESSION['user']['alamat'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="foto_ktp">Upload Foto KTP:</label>
            <input type="file" id="foto_ktp" name="foto_ktp" accept="image/*" required>
        </div>

        <div class="form-group">
            <label for="catatan">Catatan (Opsional):</label>
            <textarea id="catatan" name="catatan" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="metode_pembayaran">Metode Pembayaran:</label>
            <select name="metode_pembayaran" id="metode_pembayaran" required>
                <option value="">-- Pilih Metode --</option>
                <option value="transfer_bank">Transfer Bank</option>
                <option value="ewallet">E-Wallet</option>
                <option value="cod">Bayar di Tempat (COD)</option>
            </select>
        </div>

        <div class="form-group" id="buktiGroup" style="display: none;">
            <label for="bukti_pembayaran">Upload Bukti Pembayaran:</label>
            <input type="file" name="bukti_pembayaran" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Konfirmasi Booking</button>
    </form>
</main>

<script>
    const metodeSelect = document.getElementById('metode_pembayaran');
    const buktiGroup = document.getElementById('buktiGroup');

    function toggleBuktiPembayaran() {
        const val = metodeSelect.value;
        buktiGroup.style.display = (val === 'transfer_bank' || val === 'ewallet') ? 'block' : 'none';
    }

    metodeSelect.addEventListener('change', toggleBuktiPembayaran);
    document.addEventListener('DOMContentLoaded', toggleBuktiPembayaran);

    document.getElementById('tanggal_mulai').addEventListener('change', function () {
        const tanggalSelesai = document.getElementById('tanggal_selesai');
        tanggalSelesai.min = this.value;
        if (tanggalSelesai.value && tanggalSelesai.value < this.value) {
            tanggalSelesai.value = this.value;
        }
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
