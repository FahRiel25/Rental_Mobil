<?php
include 'includes/header.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    
    // In a real application, you would save this to database or send email
    $_SESSION['contact_success'] = true;
    header("Location: contact.php?success=1");
    exit();
}
?>

<main>
    <section class="page-header">
        <div class="container">
            <h1>Hubungi Kami</h1>
            <p>Kami siap membantu Anda 24/7</p>
        </div>
    </section>

    <section class="contact-section">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info">
                    <h2>Informasi Kontak</h2>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h3>Alamat</h3>
                            <p>Jl. Contoh No. 123, Kota Bandung, Jawa Barat</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h3>Telepon</h3>
                            <p>(022) 1234567</p>
                            <p>0812 3456 7890 (WhatsApp)</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h3>Email</h3>
                            <p>info@rentalmobil.com</p>
                            <p>cs@rentalmobil.com</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h3>Jam Operasional</h3>
                            <p>Senin - Minggu: 08.00 - 22.00 WIB</p>
                            <p>24 Jam untuk Emergency</p>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <?php if(isset($_GET['success'])): ?>
                    <div class="alert success">
                        <p>Terima kasih telah menghubungi kami. Kami akan segera merespons pesan Anda.</p>
                    </div>
                    <?php endif; ?>
                    
                    <h2>Kirim Pesan</h2>
                    <form action="contact.php" method="POST">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Pesan</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="map-section">
        <div class="container">
            <h2>Lokasi Kami</h2>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.923599381783!2d107.6101573147726!3d-6.897780695019785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64a2e7b3d0f%3A0x1e2a5b1b3b4b5b6b!2sBandung%20City%20Hall!5e0!3m2!1sen!2sid!4v1621234567890!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>
</main>

<?php
include 'includes/footer.php';
?>