// Booking Process JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Validasi Form Booking
    const bookingForm = document.getElementById('booking-form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            const tanggalMulai = document.getElementById('tanggal_mulai');
            const tanggalSelesai = document.getElementById('tanggal_selesai');
            const today = new Date().toISOString().split('T')[0];
            
            // Validasi tanggal
            if (!tanggalMulai.value || !tanggalSelesai.value) {
                e.preventDefault();
                alert('Harap pilih tanggal mulai dan selesai!');
                return;
            }
            
            if (tanggalMulai.value < today) {
                e.preventDefault();
                alert('Tanggal mulai tidak boleh kurang dari hari ini!');
                tanggalMulai.focus();
                return;
            }
            
            if (tanggalSelesai.value < tanggalMulai.value) {
                e.preventDefault();
                alert('Tanggal selesai tidak boleh kurang dari tanggal mulai!');
                tanggalSelesai.focus();
                return;
            }
            
            // Validasi minimal rental 1 hari
            const startDate = new Date(tanggalMulai.value);
            const endDate = new Date(tanggalSelesai.value);
            const diffTime = Math.abs(endDate - startDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            
            if (diffDays < 1) {
                e.preventDefault();
                alert('Minimal rental adalah 1 hari!');
                return;
            }
        });
    }
    
    // Pilih Mobil untuk Booking
    const pilihMobilBtns = document.querySelectorAll('.btn-pilih-mobil');
    if (pilihMobilBtns.length > 0) {
        pilihMobilBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const mobilId = this.getAttribute('data-id');
                const mobilMerk = this.getAttribute('data-merk');
                const mobilModel = this.getAttribute('data-model');
                const mobilHarga = this.getAttribute('data-harga');
                
                // Set nilai ke form booking
                document.getElementById('mobil_id').value = mobilId;
                document.getElementById('mobil-info').textContent = `${mobilMerk} ${mobilModel}`;
                document.getElementById('harga-per-hari').value = mobilHarga;
                
                // Scroll ke form booking
                document.getElementById('booking-form').scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    }
    
    // Hitung Total Pembayaran
    function hitungTotal() {
        const hargaPerHari = parseFloat(document.getElementById('harga-per-hari').value) || 0;
        const tanggalMulai = document.getElementById('tanggal_mulai').value;
        const tanggalSelesai = document.getElementById('tanggal_selesai').value;
        
        if (tanggalMulai && tanggalSelesai) {
            const start = new Date(tanggalMulai);
            const end = new Date(tanggalSelesai);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            
            document.getElementById('durasi').textContent = diffDays;
            document.getElementById('total-harga').value = (hargaPerHari * diffDays).toLocaleString('id-ID');
        }
    }
    
    // Event listener untuk perubahan tanggal
    const tanggalInputs = document.querySelectorAll('#tanggal_mulai, #tanggal_selesai');
    if (tanggalInputs.length > 0) {
        tanggalInputs.forEach(input => {
            input.addEventListener('change', hitungTotal);
        });
    }
    
    // Inisialisasi hitung total saat halaman dimuat
    hitungTotal();
});