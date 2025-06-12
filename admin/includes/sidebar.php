<div class="admin-sidebar">
    <div class="admin-brand">
        <h2>Admin Panel</h2>
        <p>Rental Mobil</p>
    </div>
    <nav class="admin-nav">
        <ul>
            <li><a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="mobil.php" class="<?= basename($_SERVER['PHP_SELF']) == 'mobil.php' ? 'active' : '' ?>"><i class="fas fa-car"></i> Mobil</a></li>
            <li><a href="booking.php" class="<?= basename($_SERVER['PHP_SELF']) == 'booking.php' ? 'active' : '' ?>"><i class="fas fa-calendar-check"></i> Booking</a></li>
            <li><a href="users.php" class="<?= basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : '' ?>"><i class="fas fa-users"></i> Pengguna</a></li>
            <li><a href="../proses/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>
</div>
