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

// Ambil data pencarian
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$sql = $search ? 
    "SELECT * FROM matakuliah WHERE nama_matkul LIKE '%$search%' OR kode_matkul LIKE '%$search%' OR sks LIKE '%$search%' OR semester LIKE '%$search%' OR prodi_id LIKE '%$search%'" :
    "SELECT * FROM dosen";

if (isset($_POST['add'])) {
    $nama_matkul = $_POST['nama_matkul'];
    $kode_matkul = $_POST['kode_matkul'];
    $sks = $_POST['sks'];
    $semester = $_POST['semester'];
    $prodi_id = $_POST['prodi_id'];

    // Siapkan query untuk mencegah SQL Injection
    $stmt = $conn->prepare("INSERT INTO matakuliah (nama_matkul, kode_matkul, sks, semester, prodi_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiii", $nama_matkul, $kode_matkul, $sks, $semester, $prodi_id);  // "ss" untuk dua parameter string

    // Eksekusi query
    if ($stmt->execute()) {
        echo "<script>alert('Data dosen berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data dosen: " . $stmt->error . "');</script>";
    }
}
    
// Hapus data dosen
if (isset($_GET['delete'])) {
    $matkul_id = $_GET['delete'];

    // Pastikan ID valid
    if (is_numeric($matkul_id)) {
        $sql = "DELETE FROM matakuliah WHERE matkul_id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Query Prepare Gagal: ' . $conn->error);
        }
        $stmt->bind_param("i", $matkul_id);
        if ($stmt->execute()) {
            echo "<script>alert('Data matkul berhasil dihapus!');</script>";
        } else {
            echo "<script>alert('Gagal menghapus data matkul: " . $conn->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('ID tidak valid.');</script>";
    }
}

// Edit data dosen
if (isset($_POST['edit'])) {
    // Pastikan ID tersedia sebelum digunakan
    if (isset($_POST['matkul_id']) && !empty($_POST['matkul_id'])) {
        $id = $_POST['id'];
        $nama_matkul = $_POST['nama_matkul'];
        $kode_matkul = $_POST['kode_matkul'];
        $sks = $_POST['sks'];
        $semester = $_POST['semester'];
        $prodi_id = $_POST['prodi_id'];


        $sql = "UPDATE matakuliah SET nama_matkul='$nama_matkul', kode_matkul='$kode_matkul', sks='$sks', semester='$semester', prodi_id='$prodi_id' WHERE id='$id'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issiii", $id, $nama_matkul, $kode_matkul, $sks, $semester, $prodi_id);
        if ($stmt->execute()) {
            echo "<script>alert('Data dosen berhasil diperbarui!');</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data dosen: " . $conn->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('ID tidak ditemukan, tidak dapat memperbarui data.');</script>";
    }
}

// Menghandle tombol submit "Tambah Dosen"
if (isset($_POST['tambah'])) {
    // Ambil data dari form dan proses untuk disimpan ke database
    $nama_matkul = $_POST['nama_matkul'];
    $kode_matkul = $_POST['kode_matkul'];
    $sks = $_POST['sks'];
    $semester = $_POST['semester'];
    $prodi_id = $_POST['prodi_id'];

    // SQL query untuk menyimpan data dosen
    $sql = "INSERT INTO matakuliah (nama_matkul, kode_matkul, sks, semester, prodi_id) VALUES ('$nama_matkul', '$kode_matkul', '$sks', '$semester', '$prodi_id')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data dosen berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data dosen: " . $conn->error . "');</script>";
    }
}

// Menghandle tombol submit "Simpan Perubahan"
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama_matkul = $_POST['nama_matkul'];
    $kode_matkul = $_POST['kode_matkul'];
    $sks = $_POST['sks'];
    $semester = $_POST['semester'];
    $prodi_id = $_POST['prodi_id'];

    // SQL query untuk mengupdate data dosen
    $sql = "UPDATE matakuliah SET nama_matkul='$nama_matkul', kode_matkul='$kode_matkul', sks='$sks', semester='$semester', prodi_id='$prodi_id' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data matakuliah berhasil diperbarui!');</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data matakuliah: " . $conn->error . "');</script>";
    }
}

// Ambil semua data mata kuliah
$result = $conn->query("SELECT * FROM matakuliah");

// Ambil daftar prodi untuk dropdown
$result_prodi = $conn->query("SELECT prodi_id, nama_prodi FROM prodi");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Manajemen Data Matakuliah | Institut Teknologi Bacharuddin Jusuf Habibie</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/dosen.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">PENJADWALAN</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <a class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            </a>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="setting.html">Settings</a></li>
                        <li><a class="dropdown-item" href="activity_log.html">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

    <!-- Sidebar -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Manajemen
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="Dosen.php">Dosen</a>
                                <a class="nav-link" href="kelas.php">Kelas</a>
                                <a class="nav-link" href="ruangan.php">Ruangan</a>
                                <a class="nav-link" href="matkul.php">Matakuliah</a>
                                <a class="nav-link" href="prodi.php">Prodi</a>
                                <a class="nav-link" href="waktu.php">Waktu</a>
                                <a class="nav-link" href="tahunakademik.php">Tahun Akademik</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseJadwal" aria-expanded="false" aria-controls="collapseJadwal">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Jadwal
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseJadwal" aria-labelledby="headingTree" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="dosen_mk.php">Dosen Matakuliah</a>
                                <a class="nav-link" href="buat_jadwal.php">Buat Jadwal</a>
                                <a class="nav-link" href="lihat_jadwal.php">Lihat Jadwal</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">Tugas PTC daraya</div>
            </nav>
        </div>

        <!-- Content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <!-- Form Tambah Data Matakuliah -->
                    <form method="POST">
                        <br><center><h2>Tambah Data Mata Kuliah</h2></center><br>
                        <input type="hidden" name="id" id="id" value="">
                        <div class="mb-3 row">
                            <div class="col">
                                <label for="nama_matkul" class="form-label">Nama Mata Kuliah:</label>
                                <input type="text" class="form-control" name="nama_matkul" id="nama_matkul" placeholder="Masukkan Nama Mata Kuliah" required>
                            </div>

                            <div class="col">
                                <label for="kode_matkul" class="form-label">Kode Mata Kuliah:</label>
                                <input type="text" class="form-control" name="kode_matkul" id="kode_matkul" placeholder="Masukkan Kode Mata Kuliah" required>
                            </div>

                            <div class="col">
                                <label for="sks" class="form-label">SKS:</label>
                                <input type="number" class="form-control" name="sks" id="sks" placeholder="Masukkan SKS" required>
                            </div>

                            <div class="col">
                                <label for="semester" class="form-label">Semester:</label>
                                <input type="number" class="form-control" name="semester" id="semester" placeholder="Masukkan Semester" required>
                            </div>

                            <div class="col">
                                <label for="prodi_id" class="form-label">Prodi:</label>
                                <select name="prodi_id" id="prodi_id" class="form-control" required>
                                    <option value="">Pilih Program Studi</option>
                                    <?php
                                    while ($row_prodi = $result_prodi->fetch_assoc()) {
                                        echo "<option value='" . $row_prodi['prodi_id'] . "'>" . $row_prodi['nama_prodi'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                            <center><button type="submit" name="add" class="btn btn-primary mt-3">Tambah Mata Kuliah</button></center><br>

                            <button type="submit" name="edit" id="edit-btn" style="display: none;">Simpan Perubahan</button>
                        
                    </form>

                    <!-- Daftar Mata Kuliah -->
                    <form method="POST">
                        <div class="card mb-4">
                            <div class="card-header">
                                <center><h2>Daftar Mata Kuliah</h2></center>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama Mata Kuliah</th>
                                            <th>Kode Mata Kuliah</th>
                                            <th>SKS</th>
                                            <th>Semester</th>
                                            <th>Prodi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                        ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['nama_matkul']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['kode_matkul']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['sks']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['semester']); ?></td>
                                                    <td>
                                                        <?php 
                                                        $prodi_id = $row['prodi_id'];
                                                        $prodi_result = $conn->query("SELECT nama_prodi FROM prodi WHERE prodi_id = $prodi_id");
                                                        if ($prodi_result->num_rows > 0) {
                                                            $prodi_row = $prodi_result->fetch_assoc();
                                                            echo htmlspecialchars($prodi_row['nama_prodi']); 
                                                        } else {
                                                            echo "Prodi tidak ditemukan";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="edit_matkul.php?id=<?php echo $row['matkul_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                        <a href="?delete=<?php echo $row['matkul_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center'>Tidak ada data mata kuliah yang ditemukan.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </main>

            <!-- Footer -->
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; daraya</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
