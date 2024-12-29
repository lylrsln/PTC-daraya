<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db = "penjadwalan2";

$conn = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data ruangan berdasarkan ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    $ruangan_id = $_GET['id'];
    $sql = "SELECT * FROM ruangan WHERE ruangan_id=?";
    $stmt = $conn->prepare($sql);

    // Periksa apakah prepare berhasil
    if ($stmt === false) {
        die('Query Prepare Gagal: ' . $conn->error);
    }

    $stmt->bind_param("i", $ruangan_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $ruangan = $result->fetch_assoc();
    } else {
        die("Data ruangan tidak ditemukan.");
    }

    $stmt->close();
} else {
    die("ID ruangan tidak ditemukan.");
}

// Edit data ruangan
if (isset($_POST['edit'])) {
    $id = $_POST['ruangan_id'];
    $kode_ruangan = $_POST['kode_ruangan'];
    $nama_ruangan = $_POST['nama_ruangan'];
    $kapasitas = (int)$_POST['kapasitas'];
    $lokasi = $_POST['lokasi'];

    $sql = "UPDATE ruangan SET kode_ruangan=?, nama_ruangan=?, kapasitas=?, lokasi=? WHERE ruangan_id=?";
    $stmt = $conn->prepare($sql);

    // Periksa apakah prepare berhasil
    if ($stmt === false) {
        die('Query Prepare Gagal: ' . $conn->error);
    }

    $stmt->bind_param("ssisi", $kode_ruangan, $nama_ruangan, $kapasitas, $lokasi, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Data ruangan berhasil diperbarui!'); window.location.href='Ruangan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data ruangan: " . $conn->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Edit Data Ruangan | Institut Teknologi Bacharuddin Jusuf Habibie</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/dosen.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
body {
    font-family: Arial, sans-serif;
    margin: 0; /* Menghapus margin default */
    height: 85vh; /* Membuat body mengisi tinggi penuh viewport */
    display: flex;
    justify-content: center; /* Menyusun konten secara horizontal di tengah */
    align-items: center; /* Menyusun konten secara vertikal di tengah */
}

form {
    max-width: 800px; /* Membatasi lebar maksimum form */
    width: 100%; /* Membuat form responsif agar menyesuaikan lebar layar */
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color:rgb(255, 255, 255);
}

    </style>
</head>
<body>
    <form method="POST">
    <br><center><h1>Edit Data Ruangan</h1></center><br>
        <input type="hidden" name="ruangan_id" value="<?php echo $ruangan['ruangan_id']; ?>">
        <div class="mb-3 row">
        <div class="col">
    <label for="kode_ruangan" class="form-label">Kode Ruangan:</label>
    <input type="text" class="form-control" name="kode_ruangan" value="<?php echo htmlspecialchars($ruangan['kode_ruangan']); ?>" required>
</div>

<div class="col">
    <label for="nama_ruangan" class="form-label">Nama Ruangan:</label>
    <input type="text" class="form-control" name="nama_ruangan" value="<?php echo htmlspecialchars($ruangan['nama_ruangan']); ?>" required>
</div>

<div class="col">
    <label for="kapasitas" class="form-label">Kapasitas:</label>
    <input type="number" class="form-control" name="kapasitas" value="<?php echo htmlspecialchars($ruangan['kapasitas']); ?>" required>
</div>

<div class="col">
    <label for="lokasi" class="form-label">Lokasi:</label>
    <input type="text" class="form-control" name="lokasi" value="<?php echo htmlspecialchars($ruangan['lokasi']); ?>" required>
</div>
</div>
        <center><button type="submit" name="edit">Simpan Perubahan</button></center><br>
    </form>
</body>
</html>
