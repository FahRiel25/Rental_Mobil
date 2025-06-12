<?php
// Fungsi untuk redirect
function redirect($url) {
    header("Location: " . $url);
    exit();
}

// Fungsi untuk menampilkan pesan flash
function flash($name = '', $message = '', $class = 'alert') {
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : $class;
            echo '<div class="' . $class . '">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

// Fungsi untuk validasi input
function sanitize_input($data) {
    global $db;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $db->real_escape_string($data);
}

// Fungsi untuk mendapatkan daftar mobil tersedia
function getAvailableCars($limit = null) {
    global $db;
    $query = "SELECT * FROM mobil WHERE status = 'tersedia' ORDER BY merk, model";
    if ($limit) {
        $query .= " LIMIT $limit";
    }
    $result = $db->query($query);
    $cars = [];
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
    return $cars;
}

// Fungsi untuk memformat tanggal
function formatDate($date, $format = 'd M Y') {
    return date($format, strtotime($date));
}

// Fungsi untuk memformat uang
function formatCurrency($amount) {
    return 'Rp ' . number_format($amount, 0, ',', '.');
}
require_once 'includes/functions.php';
?>