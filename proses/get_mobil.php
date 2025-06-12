<?php
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $db->query("SELECT * FROM mobil WHERE id = $id");
    echo json_encode($result->fetch_assoc());
}
?>