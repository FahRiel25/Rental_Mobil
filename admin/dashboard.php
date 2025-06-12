<?php
require_once '../includes/auth.php'; 
require_once '../config/database.php';
require_once '../includes/functions.php';

$stats = [
    'total_cars' => $db->query("SELECT COUNT(*) FROM mobil")->fetch_row()[0],
    'available_cars' => $db->query("SELECT COUNT(*) FROM mobil WHERE status = 'tersedia'")->fetch_row()[0],
    'total_bookings' => $db->query("SELECT COUNT(*) FROM booking")->fetch_row()[0],
    'active_bookings' => $db->query("SELECT COUNT(*) FROM booking WHERE status = 'diproses'")->fetch_row()[0],
    'total_users' => $db->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetch_row()[0]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Rental Mobil</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include '../includes/admin_header.php'; ?>
    
    <div class="admin-container">
        <?php include __DIR__ . '/includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <h1>Dashboard</h1>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Mobil</h3>
                    <p><?= $stats['total_cars'] ?></p>
                    <i class="fas fa-car"></i>
                </div>
                <div class="stat-card">
                    <h3>Mobil Tersedia</h3>
                    <p><?= $stats['available_cars'] ?></p>
                    <i class="fas fa-car-side"></i>
                </div>
                <div class="stat-card">
                    <h3>Total Booking</h3>
                    <p><?= $stats['total_bookings'] ?></p>
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-card">
                    <h3>Booking Aktif</h3>
                    <p><?= $stats['active_bookings'] ?></p>
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="stat-card">
                    <h3>Total Pelanggan</h3>
                    <p><?= $stats['total_users'] ?></p>
                    <i class="fas fa-users"></i>
                </div>
            </div>

            <section class="recent-bookings">
                <h2>Booking Terbaru</h2>
                <?php
                $bookings = $db->query("
                    SELECT b.*, m.merk, m.model, u.nama 
                    FROM booking b
                    JOIN mobil m ON b.mobil_id = m.id
                    JOIN users u ON b.user_id = u.id
                    ORDER BY b.tanggal_booking DESC
                    LIMIT 5
                ");
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Mobil</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($booking = $bookings->fetch_assoc()): ?>
                        <tr>
                            <td>#<?= $booking['id'] ?></td>
                            <td><?= $booking['nama'] ?></td>
                            <td><?= $booking['merk'] ?> <?= $booking['model'] ?></td>
                            <td><?= date('d M Y', strtotime($booking['tanggal_mulai'])) ?> - <?= date('d M Y', strtotime($booking['tanggal_selesai'])) ?></td>
                            <td><span class="status-badge <?= $booking['status'] ?>"><?= ucfirst($booking['status']) ?></span></td>
                            <td>
                                <a href="booking_detail.php?id=<?= $booking['id'] ?>" class="btn-action view" title="Detail"><i class="fas fa-eye"></i></a>
                                <?php if($booking['status'] == 'diproses'): ?>
                                    <a href="proses/approve_booking.php?id=<?= $booking['id'] ?>" class="btn-action approve" title="Setujui"><i class="fas fa-check"></i></a>
                                    <a href="proses/reject_booking.php?id=<?= $booking['id'] ?>" class="btn-action reject" title="Tolak"><i class="fas fa-times"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <footer style="text-align: center; margin-top: 40px; padding: 20px 0; background-color: #f1f1f1;">
        <p>&copy; <?= date('Y') ?> Muhsyam Fahriel Septiansyah - Admin Panel</p>
    </footer>

    <script src="../js/admin.js"></script>
</body>
</html>
