<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM barang WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $barang = $stmt->fetch();
} else {
    header('Location: list_barang.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Barang</title>
</head>
<body>
    <h2>Detail Barang</h2>
    <img src="<?php echo $barang['gambar_barang']; ?>" alt="<?php echo $barang['nama_barang']; ?>" style="width:200px;"><br>
    <strong><?php echo $barang['nama_barang']; ?></strong><br>
    Tipe: <?php echo $barang['tipe_barang']; ?><br><br>
    <b>detail barang:</b> <br><?php echo $barang['deskripsi_barang']; ?><br><br>
    <a href="list_barang.php">Kembali ke List Barang</a>
</body>
</html>
