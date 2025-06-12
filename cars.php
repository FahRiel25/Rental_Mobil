<?php
include 'includes/header.php';
require_once 'config/database.php';

if (isset($_GET['id'])) {
    $id = $db->real_escape_string($_GET['id']);
    $car = $db->query("SELECT * FROM mobil WHERE id = $id")->fetch_assoc();

    if (!$car) {
        header("Location: cars.php");
        exit();
    }
}
?>

<main>
    <?php if (isset($car)): ?>
        <section class="car-detail">
            <div class="container">
                <div class="car-detail-grid">
                    <div class="car-images">
                        <div class="main-image">
                            <img src="images/cars/<?= $car['gambar'] ?>" alt="<?= $car['merk'] ?> <?= $car['model'] ?>">
                        </div>
                    </div>

                    <div class="car-info">
                        <h1><?= $car['merk'] ?> <?= $car['model'] ?></h1>
                        <div class="car-meta">
                            <span><i class="fas fa-calendar-alt"></i> Tahun: <?= $car['tahun'] ?></span>
                            <span><i class="fas fa-palette"></i> Warna: <?= $car['warna'] ?></span>
                            <span><i class="fas fa-chair"></i> Kursi: <?= $car['kursi'] ?></span>
                        </div>

                        <div class="car-price">
                            <h3>Rp <?= number_format($car['harga'], 0, ',', '.') ?> <small>/hari</small></h3>
                            <p class="status <?= $car['status'] === 'tersedia' ? 'available' : 'unavailable' ?>">
                                Status: <?= ucfirst($car['status']) ?>
                            </p>
                        </div>

                        <div class="car-description">
                            <h3>Deskripsi</h3>
                            <p>Mobil <?= $car['merk'] ?> <?= $car['model'] ?> tahun <?= $car['tahun'] ?> dengan warna <?= $car['warna'] ?> merupakan salah satu armada terbaik kami. Dengan <?= $car['kursi'] ?> kursi yang nyaman, mobil ini cocok untuk perjalanan keluarga maupun bisnis.</p>
                            <ul>
                                <li>AC dingin</li>
                                <li>Audio system lengkap</li>
                                <li>Safety features lengkap</li>
                                <li>Bahan bakar irit</li>
                            </ul>
                        </div>

                        <?php if ($car['status'] === 'tersedia'): ?>
                            <a href="booking.php?car_id=<?= $car['id'] ?>" class="btn btn-primary">Booking Sekarang</a>
                        <?php else: ?>
                            <button class="btn btn-disabled" disabled>Tidak Tersedia</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php else: ?>
        <section class="page-header">
            <div class="container">
                <h1>Daftar Mobil</h1>
                <p>Temukan mobil yang sesuai dengan kebutuhan Anda</p>
            </div>
        </section>

        <section class="cars-listing">
            <div class="container">
                <div class="cars-grid">
                    <?php
                    $cars = $db->query("SELECT * FROM mobil WHERE status = 'tersedia' ORDER BY merk, model");

                    if ($cars->num_rows > 0):
                        while ($car = $cars->fetch_assoc()):
                    ?>
                        <div class="car-card">
                            <img src="images/cars/<?= $car['gambar'] ?>" alt="<?= $car['merk'] ?> <?= $car['model'] ?>">
                            <div class="car-info">
                                <h3><?= $car['merk'] ?> <?= $car['model'] ?></h3>
                                <div class="car-details">
                                    <span><i class="fas fa-calendar-alt"></i> <?= $car['tahun'] ?></span>
                                    <span><i class="fas fa-chair"></i> <?= $car['kursi'] ?> Kursi</span>
                                    <span><i class="fas fa-palette"></i> <?= $car['warna'] ?></span>
                                </div>
                                <div class="car-price">
                                    <p>Rp <?= number_format($car['harga'], 0, ',', '.') ?> <small>/hari</small></p>
                                    <a href="cars.php?id=<?= $car['id'] ?>" class="btn btn-outline">Detail</a>
                                </div>
                            </div>
                        </div>
                    <?php
                        endwhile;
                    else:
                    ?>
                        <div class="no-results">
                            <p>Tidak ada mobil yang tersedia.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>
