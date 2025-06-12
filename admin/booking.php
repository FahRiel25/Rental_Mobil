<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

// Handle status change
if (isset($_GET['approve'])) {
    $id = $db->real_escape_string($_GET['approve']);
    $db->query("UPDATE booking SET status = 'disetujui' WHERE id = $id");
    $_SESSION['success'] = "Booking telah disetujui";
    header("Location: booking.php");
    exit();
}

if (isset($_GET['reject'])) {
    $id = $db->real_escape_string($_GET['reject']);
    $db->query("UPDATE booking SET status = 'ditolak' WHERE id = $id");
    $_SESSION['success'] = "Booking telah ditolak";
    header("Location: booking.php");
    exit();
}

if (isset($_GET['complete'])) {
    $id = $db->real_escape_string($_GET['complete']);
    $db->query("UPDATE booking SET status = 'selesai' WHERE id = $id");
    $_SESSION['success'] = "Booking telah diselesaikan";
    header("Location: booking.php");
    exit();
}

// Get all bookings
$bookings = $db->query("
    SELECT b.*, m.merk, m.model, m.gambar, u.nama, u.email, u.telepon 
    FROM booking b
    JOIN mobil m ON b.mobil_id = m.id
    JOIN users u ON b.user_id = u.id
    ORDER BY b.tanggal_booking DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Booking - Rental Mobil</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include '../includes/admin_header.php'; ?>
    
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <h1>Manajemen Booking</h1>
            
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            
            <div class="filters">
                <form method="GET">
                    <div class="form-group">
                        <label for="status">Filter Status:</label>
                        <select id="status" name="status" onchange="this.form.submit()">
                            <option value="">Semua</option>
                            <option value="diproses" <?= isset($_GET['status']) && $_GET['status'] == 'diproses' ? 'selected' : '' ?>>Diproses</option>
                            <option value="disetujui" <?= isset($_GET['status']) && $_GET['status'] == 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
                            <option value="ditolak" <?= isset($_GET['status']) && $_GET['status'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                            <option value="selesai" <?= isset($_GET['status']) && $_GET['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        </select>
                    </div>
                </form>
            </div>
            
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Mobil</th>
                            <th>Tanggal</th>
                            <th>Durasi</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($booking = $bookings->fetch_assoc()): 
                            $start = new DateTime($booking['tanggal_mulai']);
                            $end = new DateTime($booking['tanggal_selesai']);
                            $durasi = $start->diff($end)->days + 1;
                            $total = $durasi * $booking['harga'];
                        ?>
                        <tr>
                            <td>#<?= $booking['id'] ?></td>
                            <td>
                                <strong><?= $booking['nama'] ?></strong><br>
                                <?= $booking['email'] ?><br>
                                <?= $booking['telepon'] ?>
                            </td>
                            <td>
                                <img src="../images/cars/<?= $booking['gambar'] ?>" alt="<?= $booking['merk'] ?>" class="car-thumbnail">
                                <?= $booking['merk'] ?> <?= $booking['model'] ?>
                            </td>
                            <td>
                                <?= date('d M Y', strtotime($booking['tanggal_mulai'])) ?><br>
                                s/d<br>
                                <?= date('d M Y', strtotime($booking['tanggal_selesai'])) ?>
                            </td>
                            <td><?= $durasi ?> hari</td>
                            <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
                            <td><span class="status-badge <?= $booking['status'] ?>"><?= ucfirst($booking['status']) ?></span></td>
                            <td>
                                <a href="booking_detail.php?id=<?= $booking['id'] ?>" class="btn-action view" title="Detail"><i class="fas fa-eye"></i></a>
                                <?php if($booking['status'] == 'diproses'): ?>
                                    <a href="booking.php?approve=<?= $booking['id'] ?>" class="btn-action approve" title="Setujui"><i class="fas fa-check"></i></a>
                                    <a href="booking.php?reject=<?= $booking['id'] ?>" class="btn-action reject" title="Tolak"><i class="fas fa-times"></i></a>
                                <?php elseif($booking['status'] == 'disetujui'): ?>
                                    <a href="booking.php?complete=<?= $booking['id'] ?>" class="btn-action complete" title="Selesai"><i class="fas fa-check-double"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <script src="../js/admin.js"></script>
    <script src="js/booking.js"></script>
</body>
</html>