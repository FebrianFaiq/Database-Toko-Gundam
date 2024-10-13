<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h2>Selamat Datang di Toko Gundam</h2>
    <a href="list_barang.php">Lihat Daftar Barang</a><br><br>
    <a href="logout.php">Logout</a>
</body>
</html>
