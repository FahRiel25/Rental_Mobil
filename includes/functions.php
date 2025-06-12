<?php
function redirect($url) {
    header("Location: " . $url);
    exit();
}

function setFlash($name, $message, $class = 'alert error') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION[$name] = $message;
    $_SESSION[$name . '_class'] = $class;
}

function flash($name) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!empty($_SESSION[$name])) {
        $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : 'alert';
        echo '<div class="' . htmlspecialchars($class) . '">' . htmlspecialchars($_SESSION[$name]) . '</div>';
        unset($_SESSION[$name]);
        unset($_SESSION[$name . '_class']);
    }
}

function sanitize_input($data) {
    global $db;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $db->real_escape_string($data);
}

function getAvailableCars($limit = null) {
    global $db;
    $query = "SELECT * FROM mobil WHERE status = 'tersedia' ORDER BY merk, model";
    if ($limit) {
        $query .= " LIMIT " . intval($limit);
    }
    $result = $db->query($query);
    $cars = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $cars[] = $row;
        }
    }
    return $cars;
}

function formatDate($date, $format = 'd M Y') {
    return date($format, strtotime($date));
}

function formatCurrency($amount) {
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

function calculateDuration($startDate, $endDate) {
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $interval = $start->diff($end);
    return max(1, $interval->days + 1);
}