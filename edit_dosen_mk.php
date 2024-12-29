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

// Ambil ID dosen_mk dari URL (query string)
if (isset($_GET['id'])) {
    $dosen_mk_id = $_GET['id'];

    // Validasi ID dosen_mk apakah valid (berupa angka)
    if (!is_numeric($dosen_mk_id)) {
        echo "<script>alert('ID tidak valid!'); window.location.href = 'dosen_mk.php';</script>";
        exit;
    }

    // Ambil data dosen_mk berdasarkan ID
    $sql = "SELECT * FROM dosen_mk WHERE dosen_mk_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dosen_mk_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika data ditemukan
    if ($result->num_rows > 0) {
        $dosen_mk = $result->fetch_assoc();
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href = 'dosen_mk.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID tidak valid!'); window.location.href = 'dosen_mk.php';</script>";
    exit;
}

// Ambil daftar dosen, mata kuliah, program studi, dan tahun akademik untuk dropdown
$result_dosen = $conn->query("SELECT dosen_id, nama_dosen FROM dosen");
$result_matkul = $conn->query("SELECT matkul_id, nama_matkul FROM matakuliah");
$result_kelas = $conn->query("SELECT kelas_id, nama_kelas FROM kelas");
$result_prodi = $conn->query("SELECT prodi_id, nama_prodi FROM prodi");
$result_tahun = $conn->query("SELECT tahun_akademik_id, tahun_akademik_nama FROM tahun_akademik");

// Update data dosen_mk
if (isset($_POST['update'])) {
    $dosen_id = $_POST['dosen_id'];
    $matkul_id = $_POST['matkul_id'];
    $kelas_id = $_POST['kelas_id'];
    $prodi_id = $_POST['prodi_id'];
    $jurusan = $_POST['jurusan'];
    $tahun_akademik_id = $_POST['tahun_akademik_id'];

    // Validasi input
    if (empty($dosen_id) || empty($matkul_id) || empty($kelas_id) || empty($prodi_id) || empty($jurusan)) {
        echo "<script>alert('Semua field harus diisi!');</script>";
    } else {
        // SQL untuk memperbarui data dosen_mk
        $sql_update = "UPDATE dosen_mk SET dosen_id = ?, matkul_id = ?, kelas_id = ?, prodi_id = ?, jurusan = ?, tahun_akademik_id = ? WHERE dosen_mk_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("iiiisii", $dosen_id, $matkul_id, $kelas_id, $prodi_id, $jurusan, $tahun_akademik_id, $dosen_mk_id);

        if ($stmt_update->execute()) {
            echo "<script>alert('Data berhasil diperbarui!'); window.location.href = 'dosen_mk.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data: " . $conn->error . "');</script>";
        }
        $stmt_update->close();
    }
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
    <script type="text/javascript">
        function updateJurusan() {
            // Mendapatkan ID Prodi yang dipilih
            var prodi_id = document.querySelector('select[name="prodi_id"]').value;
            
            // Memastikan Prodi dipilih
            if (prodi_id != "") {
                // Mengirim request AJAX untuk mendapatkan jurusan berdasarkan prodi
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "get_jurusan.php?prodi_id=" + prodi_id, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Menampilkan jurusan di dropdown jurusan
                        document.getElementById("jurusan").innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            } else {
                document.getElementById("jurusan").innerHTML = '<option value="">Pilih Prodi terlebih dahulu</option>';
            }
        }

        // Memanggil fungsi updateJurusan saat halaman pertama kali dimuat dan saat prodi dipilih
        window.onload = function() {
            updateJurusan();
        };
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            height: 85vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        form {
            max-width: 800px;
            width: 100%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: rgb(255, 255, 255);
        }
    </style>
</head>
<body>
    <!-- Form untuk mengedit data dosen_mk -->
    <form method="POST">
        <br><center><h1>Edit Data Dosen-MK</h1></center><br>
        <div class="mb-3 row">
            <!-- Dropdown Dosen -->
            <div class="col">
                <label for="dosen_id" class="form-label">Dosen:</label>
                <select class="form-select" name="dosen_id" id="dosen_id" required>
                    <option value="">Pilih Dosen</option>
                    <?php
                    while ($row_dosen = $result_dosen->fetch_assoc()) {
                        $selected = ($dosen_mk['dosen_id'] == $row_dosen['dosen_id']) ? "selected" : "";
                        echo "<option value='" . $row_dosen['dosen_id'] . "' $selected>" . htmlspecialchars($row_dosen['nama_dosen']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Dropdown Mata Kuliah -->
            <div class="col">
                <label for="matkul_id" class="form-label">Mata Kuliah:</label>
                <select class="form-select" name="matkul_id" id="matkul_id" required>
                    <option value="">Pilih Mata Kuliah</option>
                    <?php
                    while ($row_matkul = $result_matkul->fetch_assoc()) {
                        $selected = ($dosen_mk['matkul_id'] == $row_matkul['matkul_id']) ? "selected" : "";
                        echo "<option value='" . $row_matkul['matkul_id'] . "' $selected>" . htmlspecialchars($row_matkul['nama_matkul']) . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        
        <!-- Dropdown Mata Kuliah -->
        <div class="col">
                <label for="kelas_id" class="form-label">Kelas:</label>
                <select class="form-select" name="kelas_id" id="kelas_id" required>
                    <option value="">Pilih Kelas</option>
                    <?php
                    while ($row_kelas = $result_kelas->fetch_assoc()) {
                        $selected = ($dosen_mk['kelas_id'] == $row_kelas['kelas_id']) ? "selected" : "";
                        echo "<option value='" . $row_kelas['kelas_id'] . "' $selected>" . htmlspecialchars($row_kelas['nama_kelas']) . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <!-- Dropdown Program Studi -->
            <div class="col">
                <label for="prodi_id" class="form-label">Program Studi:</label>
                <select class="form-select" name="prodi_id" id="prodi_id" onchange="updateJurusan()" required>
                    <option value="">Pilih Program Studi</option>
                    <?php
                    while ($row_prodi = $result_prodi->fetch_assoc()) {
                        $selected = ($dosen_mk['prodi_id'] == $row_prodi['prodi_id']) ? "selected" : "";
                        echo "<option value='" . $row_prodi['prodi_id'] . "' $selected>" . htmlspecialchars($row_prodi['nama_prodi']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col">
                <label for="jurusan" class="form-label">Jurusan:</label>
                <select class="form-select" name="jurusan" id="jurusan" required>
                    <!-- Jurusan akan diupdate secara dinamis melalui AJAX -->
                    <option value="<?php echo htmlspecialchars($dosen_mk['jurusan']); ?>"><?php echo htmlspecialchars($dosen_mk['jurusan']); ?></option>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <!-- Dropdown Tahun Akademik -->
            <div class="col">
                <label for="tahun_akademik_id" class="form-label">Tahun Akademik:</label>
                <select class="form-select" name="tahun_akademik_id" id="tahun_akademik_id" required>
                    <option value="">Pilih Tahun Akademik</option>
                    <?php
                    while ($row_tahun = $result_tahun->fetch_assoc()) {
                        $selected = ($dosen_mk['tahun_akademik_id'] == $row_tahun['tahun_akademik_id']) ? "selected" : "";
                        echo "<option value='" . $row_tahun['tahun_akademik_id'] . "' $selected>" . htmlspecialchars($row_tahun['tahun_akademik_nama']) . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <button type="submit" name="update">Update Data</button>
    </form>
</body>
</html>
