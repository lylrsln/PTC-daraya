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

// Tambah data kelas
if (isset($_POST['add'])) {
    $kode_kelas = $_POST['kode_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $prodi_id = $_POST['prodi_id'];

    // Validasi input
    if (empty($kode_kelas) || empty($nama_kelas) || empty($prodi_id)) {
        echo "<script>alert('Semua field harus diisi!');</script>";
    } else {
        // SQL untuk menyisipkan data kelas
        $sql = "INSERT INTO kelas (kode_kelas, nama_kelas, prodi_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Query Prepare Gagal: ' . $conn->error);
        }
        $stmt->bind_param("ssi", $kode_kelas, $nama_kelas, $prodi_id);
        if ($stmt->execute()) {
            echo "<script>alert('Data kelas berhasil ditambahkan!');</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data kelas: " . $conn->error . "');</script>";
        }
        $stmt->close();
    }
}

// Edit data kelas
if (isset($_POST['edit'])) {
    $kelas_id = $_POST['kelas_id'];
    $kode_kelas = $_POST['kode_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $prodi_id = $_POST['prodi_id'];

    // Validasi input
    if (empty($kode_kelas) || empty($nama_kelas) || empty($prodi_id)) {
        echo "<script>alert('Semua field harus diisi!');</script>";
    } else {
        // SQL untuk update data kelas
        $sql = "UPDATE kelas SET kode_kelas = ?, nama_kelas = ?, prodi_id = ? WHERE kelas_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Query Prepare Gagal: ' . $conn->error);
        }
        $stmt->bind_param("ssii", $kode_kelas, $nama_kelas, $prodi_id, $kelas_id);
        if ($stmt->execute()) {
            echo "<script>alert('Data kelas berhasil diperbarui!');</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data kelas: " . $conn->error . "');</script>";
        }
        $stmt->close();
    }
}

// Hapus data dosen
if (isset($_GET['delete'])) {
    $kelas_id = $_GET['delete'];

    // Pastikan ID valid
    if (is_numeric($kelas_id)) {
        $sql = "DELETE FROM kelas WHERE kelas_id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Query Prepare Gagal: ' . $conn->error);
        }
        $stmt->bind_param("i", $kelas_id);
        if ($stmt->execute()) {
            echo "<script>alert('Data kelas berhasil dihapus!');</script>";
        } else {
            echo "<script>alert('Gagal menghapus data kelas: " . $conn->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('ID tidak valid.');</script>";
    }
}


// Ambil semua data kelas
$result = $conn->query("SELECT * FROM kelas");

// Ambil daftar program studi (prodi) untuk dropdown
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
        <title>Manajemen Data Kelas | Institut Teknologi Bacharuddin Jusuf Habibie</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/dosen.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body>
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
                            
                    <div class="sb-sidenav-footer">
                        
                        Tugas PTC daraya
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">

                    <form method="POST">
                        <br><center><h2>Tambah Data Kelas</h2></center><br>
                        <div class="mb-3 row">
                            <div class="col">
                                <label for="kode_kelas" class="form-label">Kode Kelas</label>
                                <input type="text" class="form-control" id="kode_kelas" name="kode_kelas" placeholder="Masukkan Kode Kelas" required>
                            </div>
                            <!-- Input Nama Kelas -->
                            <div class="col">
                                <label for="nama_kelas" class="form-label">Nama Kelas</label>
                                <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" placeholder="Masukkan Nama Kelas" required>
                            </div>

                            <!-- Dropdown Program Studi -->
                            <div class="col">
                                <label for="prodi_id" class="form-label">Program Studi:</label>
                                <select name="prodi_id" class="form-select" required>
                                    <option value="">Pilih Program Studi</option>
                                    <?php
                                    while ($row_prodi = $result_prodi->fetch_assoc()) {
                                        echo "<option value='" . $row_prodi['prodi_id'] . "'>" . $row_prodi['nama_prodi'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <center><button type="submit" name="add" class="btn btn-primary mt-3">Tambah Kelas</button></center><br>
                    </form>
                    
                    <!-- Tabel untuk menampilkan data kelas dan opsi edit/hapus -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <center><h2>Daftar Kelas</h2></center>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode Kelas</th>
                                        <th>Nama Kelas</th>
                                        <th>Program Studi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Periksa apakah ada data yang diambil
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            // Ambil nama program studi berdasarkan ID
                                            $prodi_query = $conn->query("SELECT nama_prodi FROM prodi WHERE prodi_id=" . $row['prodi_id']);
                                            $prodi = $prodi_query->fetch_assoc();
                                            ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['kode_kelas']); ?></td>
                                                <td><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                                                <td><?php echo htmlspecialchars($prodi['nama_prodi']); ?></td>
                                                <td>
                                                    <a href="edit_kelas.php?id=<?php echo $row['kelas_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="?delete=<?php echo $row['kelas_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center'>Tidak ada data kelas yang ditemukan.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                </main>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>

