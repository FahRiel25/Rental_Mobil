// DOM Ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Website Rental Mobil siap digunakan!');
    
    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    // Date Picker untuk Form Booking
    const dateInputs = document.querySelectorAll('input[type="date"]');
    if (dateInputs.length > 0) {
        // Set min date to today
        const today = new Date().toISOString().split('T')[0];
        dateInputs.forEach(input => {
            input.min = today;
            
            // Jika input tanggal mulai
            if (input.id === 'tanggal_mulai') {
                input.addEventListener('change', function() {
                    const tanggalSelesai = document.getElementById('tanggal_selesai');
                    if (tanggalSelesai) {
                        tanggalSelesai.min = this.value;
                        
                        // Jika tanggal selesai sebelumnya lebih kecil dari tanggal mulai
                        if (tanggalSelesai.value && tanggalSelesai.value < this.value) {
                            tanggalSelesai.value = this.value;
                        }
                    }
                });
            }
        });
    }
    
    // Hitung Total Harga Booking
    const bookingForm = document.getElementById('booking-form');
    if (bookingForm) {
        const hargaPerHari = document.getElementById('harga-per-hari');
        const totalHarga = document.getElementById('total-harga');
        const durasi = document.getElementById('durasi');
        
        function hitungTotal() {
            if (hargaPerHari && totalHarga && durasi) {
                const harga = parseFloat(hargaPerHari.value) || 0;
                const hari = parseInt(durasi.textContent) || 0;
                const total = harga * hari;
                totalHarga.value = total.toLocaleString('id-ID');
            }
        }
        
        // Hitung saat tanggal berubah
        const tanggalMulai = document.getElementById('tanggal_mulai');
        const tanggalSelesai = document.getElementById('tanggal_selesai');
        
        if (tanggalMulai && tanggalSelesai) {
            tanggalMulai.addEventListener('change', hitungDurasi);
            tanggalSelesai.addEventListener('change', hitungDurasi);
        }
        
        function hitungDurasi() {
            if (tanggalMulai.value && tanggalSelesai.value) {
                const start = new Date(tanggalMulai.value);
                const end = new Date(tanggalSelesai.value);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 untuk inklusif
                
                if (durasi) {
                    durasi.textContent = diffDays;
                }
                
                hitungTotal();
            }
        }
        
        // Hitung saat halaman dimuat jika ada nilai
        hitungDurasi();
    }
    
    // Validasi Form Kontak
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            let valid = true;
            const inputs = this.querySelectorAll('input[required], textarea[required]');
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('error');
                    valid = false;
                } else {
                    input.classList.remove('error');
                }
            });
            
            // Validasi email
            const email = this.querySelector('input[type="email"]');
            if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                email.classList.add('error');
                valid = false;
            }
            
            if (!valid) {
                e.preventDefault();
                alert('Harap isi semua field yang diperlukan dengan benar!');
            }
        });
    }
    
    // Testimonial Slider
    const testimonialSlider = document.querySelector('.testimonial-slider');
    if (testimonialSlider && testimonialSlider.children.length > 1) {
        let currentIndex = 0;
        const testimonials = Array.from(testimonialSlider.children);
        const testimonialCount = testimonials.length;
        
        function showTestimonial(index) {
            testimonials.forEach((testimonial, i) => {
                testimonial.style.display = i === index ? 'block' : 'none';
            });
        }
        
        // Auto slide setiap 5 detik
        setInterval(() => {
            currentIndex = (currentIndex + 1) % testimonialCount;
            showTestimonial(currentIndex);
        }, 5000);
        
        // Tampilkan testimonial pertama
        showTestimonial(0);
    }
    
    // Smooth Scroll untuk Anchor Link
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Animasi Scroll
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.animate');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementPosition < windowHeight - 100) {
                element.classList.add('animated');
            }
        });
    };
    
    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Jalankan sekali saat halaman dimuat
});

// Fungsi untuk menampilkan modal
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

// Fungsi untuk menyembunyikan modal
function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Event listener untuk modal
document.addEventListener('DOMContentLoaded', function() {
    // Tutup modal saat klik close button
    document.querySelectorAll('.modal .close').forEach(closeBtn => {
        closeBtn.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) {
                hideModal(modal.id);
            }
        });
    });
    
    // Tutup modal saat klik di luar konten modal
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                hideModal(this.id);
            }
        });
    });
    
    // Tampilkan modal login/register
    const loginBtn = document.getElementById('login-btn');
    const registerBtn = document.getElementById('register-btn');
    
    if (loginBtn) {
        loginBtn.addEventListener('click', function(e) {
            e.preventDefault();
            showModal('login-modal');
        });
    }
    
    if (registerBtn) {
        registerBtn.addEventListener('click', function(e) {
            e.preventDefault();
            showModal('register-modal');
        });
    }
});