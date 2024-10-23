<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';
$barang = $pdo->query("SELECT * FROM barang")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>List Barang</title>
</head>
<body>
    <h2>Daftar Gundam</h2>
    <ul>
        <?php foreach ($barang as $b): ?>
            <li>
                <img src="<?php echo $b['gambar_barang']; ?>" alt="<?php echo $b['nama_barang']; ?>" style="width:100px;"><br>
                <strong><?php echo $b['nama_barang']; ?></strong><br>
             
                <a href="detail_barang.php?id=<?php echo $b['id']; ?>">Detail Barang</a>
                <a href="edit_barang.php?id=<?php echo $b['id']; ?>">Edit</a>
                <a href="delete_barang.php?id=<?php echo $b['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">Hapus</a>
            </li><br>
        <?php endforeach; ?>
    </ul>
    <a href="tambah_barang.php">Tambah Barang Baru</a><br>
    <br>
    <a href="index.php">home</a><br>
    <a href="logout.php">Logout</a>
</body>
</html>
