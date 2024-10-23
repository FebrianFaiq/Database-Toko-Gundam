<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus data barang dari database
    $stmt = $pdo->prepare("DELETE FROM barang WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: list_barang.php"); // Redirect ke daftar barang setelah hapus
    exit;
} else {
    die("ID barang tidak ditentukan!");
}
?>