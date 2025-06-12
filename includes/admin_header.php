<?php
require_once __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' | ' : '' ?>Admin Rental Mobil</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <?= isset($additionalCSS) ? $additionalCSS : '' ?>
</head>
<body>
    <?php
    // Tampilkan flash message jika ada
    if(isset($_SESSION['flash'])) {
        echo '<div class="alert ' . $_SESSION['flash']['type'] . '">' . $_SESSION['flash']['message'] . '</div>';
        unset($_SESSION['flash']);
    }
    ?>