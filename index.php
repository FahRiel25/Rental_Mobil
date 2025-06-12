<?php 
require_once 'includes/header.php'; 
require_once 'config/database.php';

if (!$db) {
    echo "Koneksi database gagal!";
    exit;
}
?>

<main>
    <section class="hero">
        <div class="container">
            <h1>Rental Mobil Berkualitas dengan Harga Terbaik</h1>
            <p>Temukan mobil impian Anda untuk perjalanan bisnis atau liburan</p>
            <a href="cars.php" class="btn btn-primary">Lihat Mobil Tersedia</a>
        </div>
    </section>

    <section class="featured-cars">
        <div class="container">
            <h2>Mobil Populer</h2>
            <div class="cars-grid">
                <?php
                $cars = $db->query("SELECT * FROM mobil WHERE status = 'tersedia' ORDER BY RAND() LIMIT 3");
                while($car = $cars->fetch_assoc()):
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
                <?php endwhile; ?>
            </div>
            <div class="text-center">
                <a href="cars.php" class="btn btn-primary">Lihat Semua Mobil</a>
            </div>
        </div>
    </section>

    <section class="why-us">
        <div class="container">
            <h2>Kenapa Memilih Kami?</h2>
            <div class="features-grid">
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>Armada Terawat</h3>
                    <p>Semua mobil kami melalui pemeriksaan rutin untuk memastikan kondisi terbaik</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <h3>Harga Kompetitif</h3>
                    <p>Harga sewa terjangkau dengan kualitas pelayanan terbaik</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>24/7 Support</h3>
                    <p>Tim kami siap membantu Anda kapan saja selama masa rental</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Penjemputan</h3>
                    <p>Layanan penjemputan mobil di lokasi yang telah disepakati</p>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <div class="container">
            <h2>Apa Kata Pelanggan Kami?</h2>
            <div class="testimonial-slider">
                <div class="testimonial">
                    <p>"Pelayanan sangat memuaskan, mobil bersih dan nyaman. Harga juga kompetitif dibanding tempat lain."</p>
                    <h4>Budi Santoso</h4>
                    <span>Pelanggan sejak 2022</span>
                </div>
                <div class="testimonial">
                    <p>"Proses booking mudah dan cepat. Mobil sesuai gambar dan deskripsi. Recommended!"</p>
                    <h4>Ani Wijaya</h4>
                    <span>Pelanggan sejak 2023</span>
                </div>
            </div>
        </div>
    </section>

    <script src="js/script.js"></script>
</main>

<?php require_once 'includes/footer.php'; ?>
