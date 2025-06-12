<?php
require_once '../includes/auth.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
include '../includes/admin_header.php';
include 'includes/sidebar.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambah_mobil'])) {
        $merk = $db->real_escape_string($_POST['merk']);
        $model = $db->real_escape_string($_POST['model']);
        $tahun = $db->real_escape_string($_POST['tahun']);
        $warna = $db->real_escape_string($_POST['warna']);
        $kursi = $db->real_escape_string($_POST['kursi']);
        $harga = $db->real_escape_string($_POST['harga']);
        $status = $db->real_escape_string($_POST['status']);
        
        $gambar = 'default.jpg';
        if ($_FILES['gambar']['error'] === 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                $_SESSION['error'] = "Format gambar tidak valid.";
                header("Location: mobil.php");
                exit();
            }
        }
        $gambar = uniqid().'.'.$ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], '../images/cars/'.$gambar);
    }

        
        $query = "INSERT INTO mobil (merk, model, tahun, warna, kursi, harga, status, gambar) 
                  VALUES ('$merk', '$model', '$tahun', '$warna', '$kursi', '$harga', '$status', '$gambar')";
        $db->query($query);
        $_SESSION['success'] = "Mobil berhasil ditambahkan";
}
    
    if (isset($_POST['edit_mobil'])) {
        $id = $db->real_escape_string($_POST['id']);
        $merk = $db->real_escape_string($_POST['merk']);
        $model = $db->real_escape_string($_POST['model']);
        $tahun = $db->real_escape_string($_POST['tahun']);
        $warna = $db->real_escape_string($_POST['warna']);
        $kursi = $db->real_escape_string($_POST['kursi']);
        $harga = $db->real_escape_string($_POST['harga']);
        $status = $db->real_escape_string($_POST['status']);
        
        $query = "UPDATE mobil SET 
                  merk = '$merk',
                  model = '$model',
                  tahun = '$tahun',
                  warna = '$warna',
                  kursi = '$kursi',
                  harga = '$harga',
                  status = '$status'";
                  
        if ($_FILES['gambar']['error'] === 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                $_SESSION['error'] = "Format gambar tidak valid.";
                header("Location: mobil.php");
                exit();
            }

            $old_img = $db->query("SELECT gambar FROM mobil WHERE id = $id")->fetch_row()[0];
            if ($old_img != 'default.jpg') {
                unlink('../images/cars/'.$old_img);
            }

            $gambar = uniqid().'.'.$ext;
            move_uploaded_file($_FILES['gambar']['tmp_name'], '../images/cars/'.$gambar);
            $query .= ", gambar = '$gambar'";
        }

        $query .= " WHERE id = $id";
        $db->query($query);
        $_SESSION['success'] = "Data mobil berhasil diperbarui";
    }


    if (isset($_GET['hapus'])) {
        $id = $db->real_escape_string($_GET['hapus']);
        
        $gambar = $db->query("SELECT gambar FROM mobil WHERE id = $id")->fetch_row()[0];
        if ($gambar != 'default.jpg') {
            unlink('../images/cars/'.$gambar);
        }
        
        $db->query("DELETE FROM mobil WHERE id = $id");
        $_SESSION['success'] = "Mobil berhasil dihapus";
        header("Location: mobil.php");
        exit();
    }

$cars = $db->query("SELECT * FROM mobil ORDER BY merk, model");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Mobil - Rental Mobil</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include '../includes/admin_header.php'; ?>
    
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <h1>Manajemen Mobil</h1>
            
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            
            <div class="action-buttons">
                <button id="tambahMobilBtn" class="btn-primary">
                    <i class="fas fa-plus"></i> Tambah Mobil
                </button>
            </div>
            
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Merk & Model</th>
                            <th>Tahun</th>
                            <th>Harga/Hari</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while($car = $cars->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="width: 120px;">
                                <div style="width: 100px; height: 70px; overflow: hidden; border-radius: 6px;">
                                    <img src="../images/cars/<?= $car['gambar'] ?>" alt="<?= $car['merk'] ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </td>


                            <td>
                                <strong><?= $car['merk'] ?></strong><br>
                                <?= $car['model'] ?><br>
                                <small>Kursi: <?= $car['kursi'] ?>, Warna: <?= $car['warna'] ?></small>
                            </td>
                            <td><?= $car['tahun'] ?></td>
                            <td>Rp <?= number_format($car['harga'], 0, ',', '.') ?></td>
                            <td><span class="status-badge <?= $car['status'] ?>"><?= ucfirst($car['status']) ?></span></td>
                            <td>
                                <button class="btn-action edit edit-mobil" data-id="<?= $car['id'] ?>" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="mobil.php?hapus=<?= $car['id'] ?>" class="btn-action delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div id="tambahMobilModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Tambah Mobil Baru</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="merk">Merk</label>
                    <input type="text" id="merk" name="merk" required>
                </div>
                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" id="model" name="model" required>
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input type="number" id="tahun" name="tahun" min="2000" max="<?= date('Y') ?>" required>
                </div>
                <div class="form-group">
                    <label for="warna">Warna</label>
                    <input type="text" id="warna" name="warna" required>
                </div>
                <div class="form-group">
                    <label for="kursi">Jumlah Kursi</label>
                    <input type="number" id="kursi" name="kursi" min="2" max="8" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga per Hari (Rp)</label>
                    <input type="number" id="harga" name="harga" min="100000" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="tidak tersedia">Tidak Tersedia</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar Mobil</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*">
                </div>
                <button type="submit" name="tambah_mobil" class="btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    
    <div id="editMobilModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Mobil</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="edit_id" name="id">
                <div class="form-group">
                    <label for="edit_merk">Merk</label>
                    <input type="text" id="edit_merk" name="merk" required>
                </div>
                <div class="form-group">
                    <label for="edit_model">Model</label>
                    <input type="text" id="edit_model" name="model" required>
                </div>
                <div class="form-group">
                    <label for="edit_tahun">Tahun</label>
                    <input type="number" id="edit_tahun" name="tahun" min="2000" max="<?= date('Y') ?>" required>
                </div>
                <div class="form-group">
                    <label for="edit_warna">Warna</label>
                    <input type="text" id="edit_warna" name="warna" required>
                </div>
                <div class="form-group">
                    <label for="edit_kursi">Jumlah Kursi</label>
                    <input type="number" id="edit_kursi" name="kursi" min="2" max="8" required>
                </div>
                <div class="form-group">
                    <label for="edit_harga">Harga per Hari (Rp)</label>
                    <input type="number" id="edit_harga" name="harga" min="100000" required>
                </div>
                <div class="form-group">
                    <label for="edit_status">Status</label>
                    <select id="edit_status" name="status" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="tidak tersedia">Tidak Tersedia</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_gambar">Gambar Mobil</label>
                    <input type="file" id="edit_gambar" name="gambar" accept="image/*">
                    <small>Biarkan kosong jika tidak ingin mengubah gambar</small>
                </div>
                <button type="submit" name="edit_mobil" class="btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    
    <script src="../js/admin.js"></script>
    <script>
    document.querySelectorAll('.edit-mobil').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');

            fetch(`proses/get_mobil.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('edit_merk').value = data.merk;
                    document.getElementById('edit_model').value = data.model;
                    document.getElementById('edit_tahun').value = data.tahun;
                    document.getElementById('edit_warna').value = data.warna;
                    document.getElementById('edit_kursi').value = data.kursi;
                    document.getElementById('edit_harga').value = data.harga;
                    document.getElementById('edit_status').value = data.status;

                    document.getElementById('editMobilModal').style.display = 'block';
                });
        });
    });
    </script>
</body>
</html>