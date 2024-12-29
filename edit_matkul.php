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

// Ambil data matakuliah berdasarkan ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    $matkul_id = $_GET['id'];
    $sql = "SELECT * FROM matakuliah WHERE matkul_id=?";
    $stmt = $conn->prepare($sql);

    // Periksa apakah prepare berhasil
    if ($stmt === false) {
        die('Query Prepare Gagal: ' . $conn->error);
    }

    $stmt->bind_param("i", $matkul_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $matkul = $result->fetch_assoc();
    } else {
        die("Data matkul tidak ditemukan.");
    }

    $stmt->close();
} else {
    die("ID matkul tidak ditemukan.");
}

// Ambil daftar prodi untuk dropdown
$result_prodi = $conn->query("SELECT prodi_id, nama_prodi FROM prodi");

// Edit data matkul
if (isset($_POST['edit'])) {
    $id = $_POST['matkul_id'];
    $nama_matkul = $_POST['nama_matkul'];
    $kode_matkul = $_POST['kode_matkul'];
    $sks = (int)$_POST['sks'];
    $semester = (int)$_POST['semester'];
    $prodi_id = (int)$_POST['prodi_id'];

    $sql = "UPDATE matakuliah SET nama_matkul=?, kode_matkul=?, sks=?, semester=?, prodi_id=? WHERE matkul_id=?";
    $stmt = $conn->prepare($sql);

    // Periksa apakah prepare berhasil
    if ($stmt === false) {
        die('Query Prepare Gagal: ' . $conn->error);
    }

    $stmt->bind_param("ssiiii", $nama_matkul, $kode_matkul, $sks, $semester, $prodi_id, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Data matkul berhasil diperbarui!'); window.location.href='Matkul.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data matkul: " . $conn->error . "');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Matakuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control, .form-select {
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Profil Matakuliah</h1>
    <form method="POST">
        <input type="hidden" name="matkul_id" value="<?php echo $matkul['matkul_id']; ?>">

        <!-- Nama Mata Kuliah -->
        <div class="mb-3">
            <label for="nama_matkul" class="form-label">Nama Mata Kuliah</label>
            <input type="text" class="form-control" id="nama_matkul" name="nama_matkul" value="<?php echo htmlspecialchars($matkul['nama_matkul']); ?>" required>
        </div>

        <!-- Kode Mata Kuliah -->
        <div class="mb-3">
            <label for="kode_matkul" class="form-label">Kode Mata Kuliah</label>
            <input type="text" class="form-control" id="kode_matkul" name="kode_matkul" value="<?php echo htmlspecialchars($matkul['kode_matkul']); ?>" required>
        </div>

        <!-- SKS -->
        <div class="mb-3">
            <label for="sks" class="form-label">SKS</label>
            <input type="number" class="form-control" id="sks" name="sks" value="<?php echo htmlspecialchars($matkul['sks']); ?>" required>
        </div>

        <!-- Semester -->
        <div class="mb-3">
            <label for="semester" class="form-label">Semester</label>
            <input type="number" class="form-control" id="semester" name="semester" value="<?php echo htmlspecialchars($matkul['semester']); ?>" required>
        </div>

        <!-- Program Studi -->
        <div class="mb-3">
            <label for="prodi_id" class="form-label">Program Studi</label>
            <select class="form-select" name="prodi_id" required>
                <option value="">Pilih Program Studi</option>
                <?php
                while ($row_prodi = $result_prodi->fetch_assoc()) {
                    $selected = ($row_prodi['prodi_id'] == $matkul['prodi_id']) ? 'selected' : '';
                    echo "<option value='" . $row_prodi['prodi_id'] . "' $selected>" . $row_prodi['nama_prodi'] . "</option>";
                }
                ?>
            </select>
        </div>

        <!-- Tombol Simpan -->
        <div class="mb-3 text-center">
            <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
