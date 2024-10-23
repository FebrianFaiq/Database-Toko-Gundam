<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $nama_barang = $_POST['nama_barang'];
    $tipe_barang = $_POST['tipe_barang'];
    $deskripsi_barang = $_POST['deksripsi_barang'];
    
    // Menangani file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["gambar_barang"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi format file (hanya gambar)
    $check = getimagesize($_FILES["gambar_barang"]["tmp_name"]);
    if ($check === false) {
        die("File yang diupload bukan gambar.");
    }

    // Validasi ukuran file (misalnya maksimal 2MB)
    if ($_FILES["gambar_barang"]["size"] > 2000000) {
        die("Ukuran file terlalu besar. Maksimal 2MB.");
    }

    // Validasi format file yang diizinkan (jpg, png, jpeg)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        die("Hanya file JPG, JPEG, PNG yang diizinkan.");
    }

    // Pindahkan file gambar ke folder tujuan
    if (move_uploaded_file($_FILES["gambar_barang"]["tmp_name"], $target_file)) {
        // Jika upload berhasil, simpan data barang dan path gambar ke database
        $stmt = $pdo->prepare("INSERT INTO barang (nama_barang, tipe_barang, gambar_barang, deskripsi_barang) VALUES (?, ?,?,?)");
        $stmt->execute([$nama_barang, $tipe_barang, $target_file,$deskripsi_barang]);
        header("Location: list_barang.php");

        echo "Barang berhasil ditambahkan!";
    } else {
        echo "Maaf, terjadi kesalahan saat mengupload gambar.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
</head>
<body>
    <h2>Tambah Barang Gundam</h2>
    <form action="tambah_barang.php" method="POST" enctype="multipart/form-data">
        <label>Nama Barang:</label><br>
        <input type="text" name="nama_barang" required><br><br>
       
        
        
        <label>Tipe Barang:</label><br>
        <select name="tipe_barang" required>
            <option value="HG">HG</option>
            <option value="RG">RG</option>
            <option value="MG">MG</option>
            <option value="PG">PG</option>
        </select><br><br>

        <label>Deksripsi Barang:</label><br>
        <textarea id="deskripsi_barang" name="deksripsi_barang" required></textarea><br><br>
        
        <label>Upload Gambar:</label><br>
        <input type="file" name="gambar_barang" required><br><br>
        
        <button type="submit" name="submit">Tambah Barang</button>
    </form>
    <a href="list_barang.php">Kembali ke List Barang</a>
</body>
</html>
