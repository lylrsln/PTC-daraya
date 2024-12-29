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

// Ambil ID kelas dari URL (query string)
if (isset($_GET['id'])) {
    $kelas_id = $_GET['id'];

    // Validasi ID kelas apakah valid (berupa angka)
    if (!is_numeric($kelas_id)) {
        echo "<script>alert('ID kelas tidak valid!'); window.location.href = 'kelas.php';</script>";
        exit;
    }

    // Ambil data kelas berdasarkan ID
    $sql = "SELECT * FROM kelas WHERE kelas_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $kelas_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika data ditemukan
    if ($result->num_rows > 0) {
        $kelas = $result->fetch_assoc();
    } else {
        echo "<script>alert('Data kelas tidak ditemukan!'); window.location.href = 'kelas.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID kelas tidak valid!'); window.location.href = 'kelas.php';</script>";
    exit;
}

// Ambil daftar program studi untuk dropdown
$result_prodi = $conn->query("SELECT prodi_id, nama_prodi FROM prodi");

// Update data kelas
if (isset($_POST['update'])) {
    $kode_kelas = $_POST['kode_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $prodi_id = $_POST['prodi_id'];


    // Validasi input
    if (empty($kode_kelas) || empty($nama_kelas) || empty($prodi_id)) {
        echo "<script>alert('Semua field harus diisi!');</script>";
    } else {
        // SQL untuk memperbarui data kelas
        $sql_update = "UPDATE kelas SET kode_kelas = ?, nama_kelas = ?, prodi_id = ? WHERE kelas_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssii", $kode_kelas, $nama_kelas, $prodi_id, $kelas_id);

        if ($stmt_update->execute()) {
            echo "<script>alert('Data kelas berhasil diperbarui!'); window.location.href = 'kelas.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data kelas: " . $conn->error . "');</script>";
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
    <title>Edit Data Kelas | Institut Teknologi Bacharuddin Jusuf Habibie</title>
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
    <!-- Form untuk mengedit data kelas -->
    <form method="POST">
    <br><center><h1>Edit Data Kelas</h1></center><br>
    <div class="mb-3 row">
        <div class="col">
            <label for="kode_kelas" class="form-label">Kode Kelas</label>
            <input type="text" class="form-control" name="kode_kelas" id="kode_kelas" value="<?php echo htmlspecialchars($kelas['kode_kelas']); ?>" required>
        </div>
        <div class="col">
            <label for="nama_kelas" class="form-label">Nama Kelas</label>
            <input type="text" class="form-control" name="nama_kelas" id="nama_kelas" value="<?php echo htmlspecialchars($kelas['nama_kelas']); ?>" required>
        </div>
        <div class="col">
            <label for="prodi_id" class="form-label">Program Studi</label>
            <select class="form-select" name="prodi_id" id="prodi_id" required>
                <option value="">Pilih Program Studi</option>
                <?php
                // Menampilkan daftar program studi, dengan memilih program studi yang terkait dengan kelas
                while ($row_prodi = $result_prodi->fetch_assoc()) {
                    $selected = ($kelas['prodi_id'] == $row_prodi['prodi_id']) ? "selected" : "";
                    echo "<option value='" . $row_prodi['prodi_id'] . "' $selected>" . htmlspecialchars($row_prodi['nama_prodi']) . "</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <center><button type="submit" name="update">Update Kelas</button></center><br>
    </form>
</body>
</html>
