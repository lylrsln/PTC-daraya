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

// Ambil data prodi berdasarkan ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    $prodi_id = $_GET['id'];
    $sql = "SELECT * FROM prodi WHERE prodi_id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Query Prepare Gagal: ' . $conn->error);
    }

    $stmt->bind_param("i", $prodi_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $prodi = $result->fetch_assoc();
    } else {
        die("Data prodi tidak ditemukan.");
    }

    $stmt->close();
} else {
    die("ID prodi tidak ditemukan.");
}

// Edit data prodi
if (isset($_POST['edit'])) {
    $id = $_POST['prodi_id'];
    $kode_prodi = $_POST['kode_prodi']; // Ambil kode_prodi dari form
    $nama_prodi = $_POST['nama_prodi'];
    $jurusan = $_POST['jurusan'];

    if (empty($nama_prodi) || empty($jurusan)) {
        echo "<script>alert('Nama prodi dan jurusan tidak boleh kosong.');</script>";
    } else {
        $sql = "UPDATE prodi SET kode_prodi=?, nama_prodi=?, jurusan=? WHERE prodi_id=?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Query Prepare Gagal: ' . $conn->error);
        }

        $stmt->bind_param("sssi", $kode_prodi, $nama_prodi, $jurusan, $id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Data prodi berhasil diperbarui!'); window.location.href='prodi.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data prodi: " . $conn->error . "');</script>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Edit Data Prodi | Institut Teknologi Bacharuddin Jusuf Habibie</title>
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
    <br><center><h1>Edit Data Prodi</h1></center><br>
        <input type="hidden" name="prodi_id" value="<?php echo $prodi['prodi_id']; ?>">
        <div class="mb-3 row">
        <!-- Tampilkan Kode Prodi di Formulir -->
        <div class="col">
    <label for="kode_prodi" class="form-label">Kode Prodi:</label>
    <input type="text" class="form-control" name="kode_prodi" value="<?php echo htmlspecialchars($prodi['kode_prodi']); ?>" readonly>
</div>

<div class="col">
    <label for="nama_prodi" class="form-label">Nama Prodi:</label>
    <input type="text" class="form-control" name="nama_prodi" value="<?php echo htmlspecialchars($prodi['nama_prodi']); ?>" required>
</div>

<div class="col">
    <label for="jurusan" class="form-label">Jurusan:</label>
    <input type="text" class="form-control" name="jurusan" value="<?php echo htmlspecialchars($prodi['jurusan']); ?>" required>
</div>
</div>
        <center><button type="submit" name="edit">Perbarui Prodi</button></center><br>
    </form>

</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>


