    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>Tentang Kami</h3>
                    <p>Rental Mobil terpercaya dengan armada terbaik dan pelayanan profesional sejak 2010.</p>
                </div>
                <div class="footer-col">
                    <h3>Link Cepat</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">Tentang Kami</a></li>
                        <li><a href="cars.php">Daftar Mobil</a></li>
                        <li><a href="contact.php">Kontak</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Kontak</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> Jl. Merpati No. 123, Ngawi</li>
                        <li><i class="fas fa-phone"></i> (022) 1234567</li>
                        <li><i class="fas fa-envelope"></i> muhsyam@email.com</li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Sosial Media</h3>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <?= date('Y') ?> Muhsyam fahriel Septiansyah. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
    <?= isset($additionalJS) ? $additionalJS : '' ?>
</body>
</html>