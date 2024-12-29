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

// Fungsi untuk memeriksa apakah ada bentrok jadwal
function is_schedule_conflicting($conn, $new_waktu_id, $new_ruangan_id, $new_dosen_id, $edit_id) {
    // Query untuk memeriksa bentrok, tidak memeriksa jadwal yang sedang diedit
    $check_query = "SELECT * FROM jadwal2 WHERE waktu_id = ? AND (ruangan_id = ? OR dosen_id = ?) AND jadwal_id != ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("iiii", $new_waktu_id, $new_ruangan_id, $new_dosen_id, $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika ada jadwal yang bentrok
    return $result->num_rows > 0;
}

// Proses Edit Jadwal
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $edit_query = "SELECT j.*, d.nama_dosen, m.nama_matkul, k.nama_kelas, r.nama_ruangan, ta.tahun_akademik_nama, w.hari, w.jam_mulai, w.jam_selesai
                   FROM jadwal2 j
                   LEFT JOIN dosen d ON j.dosen_id = d.dosen_id
                   LEFT JOIN matakuliah m ON j.matkul_id = m.matkul_id
                   LEFT JOIN kelas k ON j.kelas_id = k.kelas_id
                   LEFT JOIN ruangan r ON j.ruangan_id = r.ruangan_id
                   LEFT JOIN tahun_akademik ta ON j.tahun_akademik_id = ta.tahun_akademik_id
                   LEFT JOIN waktu w ON j.waktu_id = w.waktu_id
                   WHERE j.jadwal_id = '$edit_id'";

    $edit_result = $conn->query($edit_query);
    $edit_row = $edit_result->fetch_assoc();

    // Proses penyimpanan perubahan
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $dosen_id = $_POST['dosen_id'];
        $matkul_id = $_POST['matkul_id'];
        $prodi_id = $_POST['prodi_id'];
        $waktu_id = $_POST['waktu_id'];
        $kelas_id = $_POST['kelas_id'];
        $ruangan_id = $_POST['ruangan_id'];
        $tahun_akademik_id = $_POST['tahun_akademik_id'];

        // Validasi input, pastikan tidak ada yang kosong
        if (empty($matkul_id) || empty($prodi_id) || empty($tahun_akademik_id)) {
            $message = "Mohon pastikan semua data terisi dengan benar!";
        } else {
            // Mengecek bentrok jadwal menggunakan fungsi is_schedule_conflicting
            if (is_schedule_conflicting($conn, $waktu_id, $ruangan_id, $dosen_id, $edit_id)) {
                // Jadwal bentrok, beri peringatan
                $message = "Jadwal bentrok, silakan pilih waktu, ruangan, atau dosen yang lain!";
            } else {
                // Tidak ada bentrok, lakukan pembaruan jadwal
                $update_sql = "UPDATE jadwal2 SET dosen_id = ?, matkul_id = ?, prodi_id = ?, waktu_id = ?, kelas_id = ?, ruangan_id = ?, tahun_akademik_id = ?
                               WHERE jadwal_id = ?";

                $stmt = $conn->prepare($update_sql);
                $stmt->bind_param("iiiiiisi", $dosen_id, $matkul_id, $prodi_id, $waktu_id, $kelas_id, $ruangan_id, $tahun_akademik_id, $edit_id);

                if ($stmt->execute()) {
                    $message = "Jadwal berhasil diperbarui!";
                } else {
                    $message = "Error: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Jadwal</title>
    
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        
        .container {
            max-width: 800px;
            margin-top: 50px;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            font-size: 2.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }
        
        .form-group label {
            font-weight: bold;
            color: #495057;
        }
        
        .form-select, .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease;
        }
        
        .form-select:focus, .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }
        
        button[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        
        .modal-content {
            padding: 20px;
        }
        
        .modal-header {
            background-color: #28a745;
            color: white;
        }
        
        .modal-footer button {
            background-color: #007bff;
            color: white;
        }
        
        .modal-footer button:hover {
            background-color: #0056b3;
        }
        
        /* Adjust spacing between form elements */
        .form-group {
            margin-bottom: 20px;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .container {
                margin-top: 30px;
                padding: 20px;
            }
        }

        /* Center the button and tahun akademik */
        .centered-button {
            display: flex;
            justify-content: center;
        }

        .centered-dropdown {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Jadwal</h1>

        <form method="POST">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="dosen_id">Dosen:</label>
                    <select name="dosen_id" id="dosen_id" class="form-select" required>
                        <option value="<?php echo $edit_row['dosen_id']; ?>"><?php echo $edit_row['nama_dosen']; ?></option>
                        <?php
                        // Menampilkan daftar dosen
                        $dosen_query = "SELECT * FROM dosen";
                        $dosen_result = $conn->query($dosen_query);
                        while ($dosen = $dosen_result->fetch_assoc()) {
                            echo "<option value='" . $dosen['dosen_id'] . "'>" . $dosen['nama_dosen'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6 form-group">
                    <label for="matkul_id">Mata Kuliah:</label>
                    <select name="matkul_id" id="matkul_id" class="form-select" required>
                        <option value="<?php echo $edit_row['matkul_id']; ?>"><?php echo $edit_row['nama_matkul']; ?></option>
                        <?php
                        $matkul_query = "SELECT * FROM matakuliah";
                        $matkul_result = $conn->query($matkul_query);
                        while ($matkul = $matkul_result->fetch_assoc()) {
                            echo "<option value='" . $matkul['matkul_id'] . "'>" . $matkul['nama_matkul'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6 form-group">
                    <label for="prodi_id">Prodi:</label>
                    <select name="prodi_id" id="prodi_id" class="form-select" required>
                        <option value="<?php echo $edit_row['prodi_id']; ?>"><?php echo $edit_row['prodi_id']; ?></option>
                        <?php
                        $prodi_query = "SELECT * FROM prodi";
                        $prodi_result = $conn->query($prodi_query);
                        while ($prodi = $prodi_result->fetch_assoc()) {
                            echo "<option value='" . $prodi['prodi_id'] . "'>" . $prodi['nama_prodi'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6 form-group">
                    <label for="waktu_id">Waktu:</label>
                    <select name="waktu_id" id="waktu_id" class="form-select" required>
                        <option value="<?php echo $edit_row['waktu_id']; ?>"><?php echo $edit_row['hari'] . " - " . $edit_row['jam_mulai'] . " to " . $edit_row['jam_selesai']; ?></option>
                        <?php
                        $waktu_query = "SELECT * FROM waktu";
                        $waktu_result = $conn->query($waktu_query);
                        while ($waktu = $waktu_result->fetch_assoc()) {
                            echo "<option value='" . $waktu['waktu_id'] . "'>" . $waktu['hari'] . " - " . $waktu['jam_mulai'] . " to " . $waktu['jam_selesai'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6 form-group">
                    <label for="kelas_id">Kelas:</label>
                    <select name="kelas_id" id="kelas_id" class="form-select" required>
                        <option value="<?php echo $edit_row['kelas_id']; ?>"><?php echo $edit_row['nama_kelas']; ?></option>
                        <?php
                        $kelas_query = "SELECT * FROM kelas";
                        $kelas_result = $conn->query($kelas_query);
                        while ($kelas = $kelas_result->fetch_assoc()) {
                            echo "<option value='" . $kelas['kelas_id'] . "'>" . $kelas['nama_kelas'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6 form-group">
                    <label for="ruangan_id">Ruangan:</label>
                    <select name="ruangan_id" id="ruangan_id" class="form-select" required>
                        <option value="<?php echo $edit_row['ruangan_id']; ?>"><?php echo $edit_row['nama_ruangan']; ?></option>
                        <?php
                        $ruangan_query = "SELECT * FROM ruangan";
                        $ruangan_result = $conn->query($ruangan_query);
                        while ($ruangan = $ruangan_result->fetch_assoc()) {
                            echo "<option value='" . $ruangan['ruangan_id'] . "'>" . $ruangan['nama_ruangan'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mt-3 centered-dropdown">
                <div class="col-md-6 form-group">
                    <label for="tahun_akademik_id">Tahun Akademik:</label>
                    <select name="tahun_akademik_id" id="tahun_akademik_id" class="form-select" required>
                        <option value="<?php echo $edit_row['tahun_akademik_id']; ?>"><?php echo $edit_row['tahun_akademik_nama']; ?></option>
                        <?php
                        $ta_query = "SELECT * FROM tahun_akademik";
                        $ta_result = $conn->query($ta_query);
                        while ($ta = $ta_result->fetch_assoc()) {
                            echo "<option value='" . $ta['tahun_akademik_id'] . "'>" . $ta['tahun_akademik_nama'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Centered Button -->
            <div class="centered-button">
                <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <!-- Modal for Success/Error message -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalMessage">
                    <?php if (isset($message)) { echo $message; } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        // Display success or error message in a modal
        <?php if (isset($message)) { ?>
            document.getElementById('modalMessage').innerText = '<?php echo $message; ?>';
            var myModal = new bootstrap.Modal(document.getElementById('statusModal'), {
                keyboard: false
            });
            myModal.show();
        <?php } ?>
    </script>
</body>
</html>



