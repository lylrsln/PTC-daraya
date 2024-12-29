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

// Ambil ID waktu dari URL (query string)
if (isset($_GET['id'])) {
    $waktu_id = $_GET['id'];

    // Ambil data waktu berdasarkan ID
    $sql = "SELECT * FROM waktu WHERE waktu_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $waktu_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika data ditemukan
    if ($result->num_rows > 0) {
        $waktu = $result->fetch_assoc();
    } else {
        echo "<script>alert('Data waktu tidak ditemukan!'); window.location.href = 'Waktu.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID waktu tidak valid!'); window.location.href = 'Waktu.php';</script>";
    exit;
}

// Update data waktu
if (isset($_POST['edit'])) {
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    // Validasi input
    if (empty($hari) || empty($jam_mulai) || empty($jam_selesai)) {
        echo "<script>alert('Semua field harus diisi!');</script>";
    } else {
        // SQL untuk memperbarui data waktu
        $sql_update = "UPDATE waktu SET hari = ?, jam_mulai = ?, jam_selesai = ? WHERE waktu_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssi", $hari, $jam_mulai, $jam_selesai, $waktu_id);

        if ($stmt_update->execute()) {
            echo "<script>alert('Data waktu berhasil diperbarui!'); window.location.href = 'Waktu.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data waktu: " . $conn->error . "');</script>";
        }
        $stmt_update->close();
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
        <title>Edit Data Waktu | Institut Teknologi Bacharuddin Jusuf Habibie</title>
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

        <!-- Form untuk mengedit data waktu -->
        <form method="POST">
        <br><center><h1>Edit Data Waktu</h1></center><br>
        <div class="mb-3 row">
        <div class="col">
            <label for="hari" class="form-label">Hari:</label>
            <input type="text" class="form-control" name="hari" value="<?php echo htmlspecialchars($waktu['hari']); ?>" required>
        </div>

        <div class="col">
            <label for="jam_mulai" class="form-label">Jam Mulai:</label>
            <input type="time" class="form-control" name="jam_mulai" value="<?php echo htmlspecialchars($waktu['jam_mulai']); ?>" required>
        </div>

        <div class="col">
            <label for="jam_selesai" class="form-label">Jam Selesai:</label>
            <input type="time" class="form-control" name="jam_selesai" value="<?php echo htmlspecialchars($waktu['jam_selesai']); ?>" required>
        </div>
        </div>
            <center><button type="submit" name="edit">Perbarui Waktu</button></center><br>
        </form>
    </body>
</html>
