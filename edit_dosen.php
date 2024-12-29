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

// Ambil data dosen berdasarkan ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    $dosen_id = $_GET['id'];
    $sql = "SELECT * FROM dosen WHERE dosen_id=?";  // Ubah 'id' menjadi 'dosen_id'
    $stmt = $conn->prepare($sql);

    // Periksa apakah prepare berhasil
    if ($stmt === false) {
        die('Query Prepare Gagal: ' . $conn->error);
    }

    $stmt->bind_param("i", $dosen_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $dosen = $result->fetch_assoc();
    } else {
        die("Data dosen tidak ditemukan.");
    }

    $stmt->close();
} else {
    die("ID dosen tidak ditemukan.");
}

// Edit data dosen
if (isset($_POST['edit'])) {
    $id = $_POST['dosen_id'];  // Ubah 'id' menjadi 'dosen_id'
    $nama = $_POST['nama_dosen'];
    $nip = $_POST['nip'];

    $sql = "UPDATE dosen SET nama_dosen=?, nip=? WHERE dosen_id=?";  // Ubah 'id' menjadi 'dosen_id'
    $stmt = $conn->prepare($sql);

    // Periksa apakah prepare berhasil
    if ($stmt === false) {
        die('Query Prepare Gagal: ' . $conn->error);
    }

    $stmt->bind_param("sii", $nama, $nip, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Data dosen berhasil diperbarui!'); window.location.href='dosen.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data dosen: " . $conn->error . "');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Manajemen Data Ruangan | Institut Teknologi Bacharuddin Jusuf Habibie</title>
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
    <form  method="POST">
        <br><center><h1>Edit Profil Dosen</h1></center><br>
        <input type="hidden" name="dosen_id" value="<?php echo $dosen['dosen_id']; ?>"> <!-- Ubah 'id' menjadi 'dosen_id' -->

        <!-- Baris pertama: Nama Dosen, NIP, Email -->
        <div class="mb-3 row">
<div class="col">
    <label for="nama_dosen" class="form-label">Nama Dosen:</label>
    <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" value="<?php echo $dosen['nama_dosen']; ?>" required>
</div>

<div class="col">
    <label for="nip" class="form-label">NIP:</label>
    <input type="text" class="form-control" id="nip" name="nip"  value="<?php echo $dosen['nip']; ?>" required>
</div>

</div>

       <center><button type="submit" name="edit">Simpan Perubahan</button></center><br>
</div>

    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
