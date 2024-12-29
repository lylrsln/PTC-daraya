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

// Tambah data ruangan
if (isset($_POST['add'])) {
    $kode_ruangan = $_POST['kode_ruangan'];
    $nama_ruangan = $_POST['nama_ruangan'];
    $kapasitas = $_POST['kapasitas'];
    $lokasi = $_POST['lokasi'];

    // Validasi input (bisa ditambah lebih lanjut sesuai kebutuhan)
    if (empty($kode_ruangan) || empty($nama_ruangan) || empty($kapasitas) || empty($lokasi)) {
        echo "<script>alert('Semua field harus diisi!');</script>";
    } else {
        // SQL untuk menyisipkan data ruangan
        $sql = "INSERT INTO ruangan (kode_ruangan, nama_ruangan, kapasitas, lokasi) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Query Prepare Gagal: ' . $conn->error);
        }
        $stmt->bind_param("ssis", $kode_ruangan, $nama_ruangan, $kapasitas, $lokasi);
        if ($stmt->execute()) {
            echo "<script>alert('Data ruangan berhasil ditambahkan!');</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data ruangan: " . $conn->error . "');</script>";
        }
        $stmt->close();
    }
}

// Cek apakah parameter delete ada di URL
if (isset($_GET['delete'])) {
    // Ambil ID yang akan dihapus
    $ruangan_id = $_GET['delete'];

    // Validasi ID jika diperlukan
    if (is_numeric($ruangan_id)) {
        // Siapkan query untuk menghapus data berdasarkan ID
        $query = "DELETE FROM ruangan WHERE ruangan_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $ruangan_id);  // Mengikat ID waktu_id ke parameter query
        $stmt->execute();

        // Cek apakah penghapusan berhasil
        if ($stmt->affected_rows > 0) {
            // Jika berhasil, tampilkan pesan atau redirect
            echo "<script>alert('Data berhasil dihapus!');</script>";
            header("Location: ruangan.php");  // Redirect kembali ke halaman yang sama atau halaman lain
            exit();
        } else {
            // Jika gagal
            echo "<script>alert('Gagal menghapus data!');</script>";
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "<script>alert('ID tidak valid!');</script>";
    }
}

// Menghandle tombol submit "Tambah Dosen"
if (isset($_POST['tambah'])) {
    // Ambil data dari form dan proses untuk disimpan ke database
    $kode_ruangan = $_POST['kode_ruangan'];
    $nama_ruangan = $_POST['nama_ruangan'];
    $kapasitas = $_POST['kapasitas'];
    $lokasi = $_POST['lokasi'];

    // SQL query untuk menyimpan data dosen
    $sql = "INSERT INTO ruangan (kode_ruangan, nama_ruangan, kapasitas, lokasi) VALUES ('$kode_ruangan', '$nama_ruangan', '$kapasitas', '$lokasi')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data dosen berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data dosen: " . $conn->error . "');</script>";
    }
}

// Menghandle tombol submit "Simpan Perubahan"
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $kode_ruangan = $_POST['kode_ruangan'];
    $nama_ruangan = $_POST['nama_ruangan'];
    $kapasitas = $_POST['kapasitas'];
    $lokasi = $_POST['lokasi'];

    // SQL query untuk mengupdate data dosen
    $sql = "UPDATE ruangan SET nama_ruangan='$nama_ruangan', kode_ruangan='$kode_ruangan', kapasitas='$kapasitas', lokasi='$lokasi' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data dosen berhasil diperbarui!');</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data dosen: " . $conn->error . "');</script>";
    }
}

// Ambil semua data ruangan
$result = $conn->query("SELECT * FROM ruangan");
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
            <!-- Manajemen Data Ruangan -->
            <br><center><h2>Tambah Data Ruangan</h2></center><br>
            
            <!-- Form Tambah Ruangan -->
            <form method="POST" action="">
                <div class="mb-3 row">
                    <div class="col">
                        <label for="kode_ruangan" class="form-label">Kode Ruangan:</label>
                        <input type="text" class="form-control" id="kode_ruangan" name="kode_ruangan" placeholder="Masukkan Kode Ruangan" required>
                    </div>

                    <div class="col">
                        <label for="nama_ruangan" class="form-label">Nama Ruangan:</label>
                        <input type="text" class="form-control" id="nama_ruangan" name="nama_ruangan" placeholder="Masukkan Nama Ruangan" required>
                    </div>

                    <div class="col">
                        <label for="kapasitas" class="form-label">Kapasitas:</label>
                        <input type="number" class="form-control" id="kapasitas" name="kapasitas" placeholder="Masukkan Kapasitas" required>
                    </div>

                    <div class="col">
                        <label for="lokasi" class="form-label">Lokasi:</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Masukkan Lokasi" required>
                    </div>
                </div>

                <!-- Tombol Tambah Ruangan -->
                <div class="text-center mt-3">
                    <center><button type="submit" name="tambah" class="btn btn-primary">Tambah Ruangan</button><center></br>
                </div>
            </form>

            <!-- Daftar Ruangan -->
            <div class="card mb-4">
                <div class="card-header">
                    <center><h2>Daftar Ruangan</h2></center>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Ruangan</th>
                                <th>Nama Ruangan</th>
                                <th>Kapasitas</th>
                                <th>Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Tampilkan data ruangan
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['kode_ruangan']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_ruangan']); ?></td>
                                        <td><?php echo htmlspecialchars($row['kapasitas']); ?></td>
                                        <td><?php echo htmlspecialchars($row['lokasi']); ?></td>
                                        <td>
                                            <a href="edit_ruangan.php?id=<?php echo $row['ruangan_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="?delete=<?php echo $row['ruangan_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>Tidak ada data ruangan yang ditemukan.</td></tr>";
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

