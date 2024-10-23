<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mengambil data barang berdasarkan ID
    $stmt = $pdo->prepare("SELECT * FROM barang WHERE id = ?");
    $stmt->execute([$id]);
    $barang = $stmt->fetch();

    if (!$barang) {
        die("Barang tidak ditemukan!");
    }
} else {
    die("ID barang tidak ditentukan!");
}

if (isset($_POST['update'])) {
    $nama_barang = $_POST['nama_barang'];
    $tipe_barang = $_POST['tipe_barang'];
    $deskripsi_barang = $_POST['deskripsi_barang'];

    // Menangani file upload
    $target_dir = "uploads/";
    if (!empty($_FILES["gambar_barang"]["name"])) {
        $target_file = $target_dir . basename($_FILES["gambar_barang"]["name"]);
        move_uploaded_file($_FILES["gambar_barang"]["tmp_name"], $target_file);
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $target_file = $barang['gambar_barang'];
    }

    // Update data barang di database
    $stmt = $pdo->prepare("UPDATE barang SET nama_barang = ?, tipe_barang = ?, gambar_barang = ?, deskripsi_barang = ? WHERE id = ?");
    $stmt->execute([$nama_barang, $tipe_barang, $target_file,$deskripsi_barang, $id]);

    echo "Barang berhasil diupdate!";
    header("Location: list_barang.php"); // Redirect ke daftar barang setelah update
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
</head>
<body>
    <h2>Edit Barang Gundam</h2>
    <form action="edit_barang.php?id=<?php echo $barang['id']; ?>" method="POST" enctype="multipart/form-data">
        <label>Nama Barang:</label><br>
        <input type="text" name="nama_barang" value="<?php echo $barang['nama_barang']; ?>" required><br><br>
        
        <label>Tipe Barang:</label><br>
        <select name="tipe_barang" required>
            <option value="HG" <?php echo $barang['tipe_barang'] == 'HG' ? 'selected' : ''; ?>>HG</option>
            <option value="RG" <?php echo $barang['tipe_barang'] == 'RG' ? 'selected' : ''; ?>>RG</option>
            <option value="MG" <?php echo $barang['tipe_barang'] == 'MG' ? 'selected' : ''; ?>>MG</option>
            <option value="PG" <?php echo $barang['tipe_barang'] == 'PG' ? 'selected' : ''; ?>>PG</option>
        </select><br><br>
        <label>Deksripsi Barang:</label><br>

        <textarea id="deskripsi_barang" name="deskripsi_barang" required><?php echo $barang['deskripsi_barang']; ?></textarea> <br>

        
        <label>Upload Gambar (Kosongkan jika tidak ingin mengganti):</label><br>
        <input type="file" name="gambar_barang"><br><br>
        
        <button type="submit" name="update">Update Barang</button>
    </form>
    <a href="list_barang.php">Kembali ke List Barang</a>
</body>
</html>
