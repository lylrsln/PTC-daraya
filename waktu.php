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

// Tambah data waktu
if (isset($_POST['add'])) {
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    // Validasi input
    if (empty($hari) || empty($jam_mulai) || empty($jam_selesai)) {
        echo "<script>alert('Semua field harus diisi!');</script>";
    } else {
        // SQL untuk menyisipkan data waktu
        $sql = "INSERT INTO waktu (hari, jam_mulai, jam_selesai) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Query Prepare Gagal: ' . $conn->error);
        }
        $stmt->bind_param("sss", $hari, $jam_mulai, $jam_selesai);
        if ($stmt->execute()) {
            echo "<script>alert('Data waktu berhasil ditambahkan!');</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data waktu: " . $conn->error . "');</script>";
        }
        $stmt->close();
    }
}

// Hapus data waktu
// Cek apakah parameter delete ada di URL
if (isset($_GET['delete'])) {
    // Ambil ID yang akan dihapus
    $waktu_id = $_GET['delete'];

    // Validasi ID jika diperlukan
    if (is_numeric($waktu_id)) {
        // Siapkan query untuk menghapus data berdasarkan ID
        $query = "DELETE FROM waktu WHERE waktu_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $waktu_id);  // Mengikat ID waktu_id ke parameter query
        $stmt->execute();

        // Cek apakah penghapusan berhasil
        if ($stmt->affected_rows > 0) {
            // Jika berhasil, tampilkan pesan atau redirect
            echo "<script>alert('Data berhasil dihapus!');</script>";
            header("Location: waktu.php");  // Redirect kembali ke halaman yang sama atau halaman lain
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
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    // SQL query untuk menyimpan data dosen
    $sql = "INSERT INTO waktu (hari, jam_mulai, jam_selesai) VALUES ('$hari', '$jam_mulai', '$jam_selesai')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data dosen berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data dosen: " . $conn->error . "');</script>";
    }
}

// Menghandle tombol submit "Simpan Perubahan"
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];


    // SQL query untuk mengupdate data dosen
    $sql = "UPDATE waktu SET hari='$hari', jam_mulai='$jam_mulai', jam_selesai='$jam_selesai' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data matakuliah berhasil diperbarui!');</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data matakuliah: " . $conn->error . "');</script>";
    }
}
// Ambil semua data waktu
$result = $conn->query("SELECT * FROM waktu");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Manajemen Waktu | Institut Teknologi Bacharuddin Jusuf Habibie</title>
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
                                    <a class="nav-link" href="matkul.php">Matkul</a>
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
                    <div class="sb-sidenav-footer">
                        Tugas PTC daraya
                    </div>
                </nav>
                    </div>
                    <div id="layoutSidenav_content">
                        <main>
                            <div class="container-fluid px-4">
                                <form method="POST">
                                    <br><center><h2>Tambah Data Waktu</h2></center><br>
                                    <div class="mb-3 row">
                                    <div class="col">
                                        <label for="hari" class="form-label">Hari:</label>
                                        <input type="text" class="form-control" id="hari" name="hari" placeholder="Masukkan Hari" required>
                                    </div>

                                    <div class="col">
                                        <label for="jam_mulai" class="form-label">Jam Mulai:</label>
                                        <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                                    </div>

                                    <div class="col">
                                        <label for="jam_selesai" class="form-label">Jam Selesai:</label>
                                        <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                                    </div>
                                </div>
                                <center><button type="submit" name="add" class="btn btn-primary mt-3">Tambah Waktu</button></center><br>
                                
                            </form>
                        
                            <form method="POST" action=""> 
                            <div class="card mb-4">
                                <div class="card-header">
                                    <center><h2>Daftar Waktu</h2></center>
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jam Mulai</th>
                                                <th>Jam Selesai</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Periksa apakah ada data yang diambil
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['hari']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['jam_mulai']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['jam_selesai']); ?></td>
                                                        <td>
                                                            <a href="edit_waktu.php?id=<?php echo $row['waktu_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                            <a href="?delete=<?php echo $row['waktu_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>

                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='4' class='text-center'>Tidak ada data waktu yang ditemukan.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Kelompok daraya</div>
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

