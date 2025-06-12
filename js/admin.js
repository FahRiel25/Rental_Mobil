// Admin Panel JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin Panel Rental Mobil siap digunakan!');
    
    // Toggle Mobile Menu di Admin
    const adminMenuToggle = document.getElementById('admin-menu-toggle');
    const adminSidebar = document.querySelector('.admin-sidebar');
    
    if (adminMenuToggle && adminSidebar) {
        adminMenuToggle.addEventListener('click', function() {
            adminSidebar.classList.toggle('active');
        });
    }
    
    // Inisialisasi DataTables
    const dataTables = document.querySelectorAll('table.datatable');
    if (dataTables.length > 0) {
        dataTables.forEach(table => {
            $(table).DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
                }
            });
        });
    }
    
    // Modal untuk Tambah/Edit Data
    const tambahMobilBtn = document.getElementById('tambahMobilBtn');
    const editMobilBtns = document.querySelectorAll('.edit-mobil');
    
    if (tambahMobilBtn) {
        tambahMobilBtn.addEventListener('click', function() {
            showModal('tambahMobilModal');
        });
    }
    
    // Format input harga dengan titik sebagai pemisah ribuan
    const hargaInputs = document.querySelectorAll('input[name="harga"]');
    if (hargaInputs.length > 0) {
        hargaInputs.forEach(input => {
            // Format saat kehilangan fokus
            input.addEventListener('blur', function() {
                const value = this.value.replace(/\./g, '');
                if (!isNaN(value) && value !== '') {
                    this.value = parseInt(value).toLocaleString('id-ID');
                }
            });
            
            // Hapus format saat mendapatkan fokus
            input.addEventListener('focus', function() {
                this.value = this.value.replace(/\./g, '');
            });
        });
    }
    
    // Preview gambar sebelum upload
    const fileInputs = document.querySelectorAll('input[type="file"][accept="image/*"]');
    if (fileInputs.length > 0) {
        fileInputs.forEach(input => {
            const previewId = input.getAttribute('data-preview');
            if (!previewId) return;
            
            const preview = document.getElementById(previewId);
            if (!preview) return;
            
            input.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    
                    reader.addEventListener('load', function() {
                        preview.src = this.result;
                        preview.style.display = 'block';
                    });
                    
                    reader.readAsDataURL(file);
                }
            });
        });
    }
    
    // Konfirmasi sebelum menghapus data
    const deleteButtons = document.querySelectorAll('.btn-action.delete, a[onclick]');
    if (deleteButtons.length > 0) {
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    e.preventDefault();
                }
            });
        });
    }
    
    // Toggle Password Visibility
    const togglePasswordBtns = document.querySelectorAll('.toggle-password');
    if (togglePasswordBtns.length > 0) {
        togglePasswordBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                
                // Ganti icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    }
    
    // Chart.js untuk Dashboard
    const dashboardChart = document.getElementById('dashboard-chart');
    if (dashboardChart) {
        const ctx = dashboardChart.getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pendapatan',
                    data: [12000000, 19000000, 15000000, 18000000, 22000000, 25000000, 30000000, 28000000, 26000000, 24000000, 20000000, 18000000],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Pendapatan: Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }
});

// Fungsi untuk menampilkan notifikasi
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Fungsi untuk memformat angka ke Rupiah
function formatRupiah(angka) {
    return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}