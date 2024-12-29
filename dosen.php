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
    "SELECT * FROM dosen WHERE nama_dosen LIKE '%$search%' OR nip LIKE '%$search%'" :
    "SELECT * FROM dosen";

if (isset($_POST['add'])) {
    $nama_dosen = $_POST['nama_dosen'];
    $nip = $_POST['nip'];

    // Siapkan query untuk mencegah SQL Injection
    $stmt = $conn->prepare("INSERT INTO dosen (nama_dosen, nip) VALUES (?, ?)");
    $stmt->bind_param("ss", $nama_dosen, $nip);  // "ss" untuk dua parameter string

    // Eksekusi query
    if ($stmt->execute()) {
        echo "<script>alert('Data dosen berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data dosen: " . $stmt->error . "');</script>";
    }
}
    
// Hapus data dosen
if (isset($_GET['delete'])) {
    $dosen_id = $_GET['delete'];

    // Pastikan ID valid
    if (is_numeric($dosen_id)) {
        $sql = "DELETE FROM dosen WHERE dosen_id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Query Prepare Gagal: ' . $conn->error);
        }
        $stmt->bind_param("i", $dosen_id);
        if ($stmt->execute()) {
            echo "<script>alert('Data dosen berhasil dihapus!');</script>";
        } else {
            echo "<script>alert('Gagal menghapus data dosen: " . $conn->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('ID tidak valid.');</script>";
    }
}

// Edit data dosen
if (isset($_POST['edit'])) {
    // Pastikan ID tersedia sebelum digunakan
    if (isset($_POST['dosen_id']) && !empty($_POST['dosen_id'])) {
        $id = $_POST['dosen_id'];
        $nama = $_POST['nama_dosen'];
        $nip = $_POST['nip'];

        $sql = "UPDATE dosen SET nama_dosen='$nama', nip='$nip' WHERE dosen_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $id, $nama);
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
    $nama_dosen = $_POST['nama_dosen'];
    $nip = $_POST['nip'];

    // SQL query untuk menyimpan data dosen
    $sql = "INSERT INTO dosen (nama_dosen, nip) VALUES ('$nama_dosen', '$nip')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data dosen berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data dosen: " . $conn->error . "');</script>";
    }
}

// Menghandle tombol submit "Simpan Perubahan"
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama_dosen = $_POST['nama_dosen'];
    $nip = $_POST['nip'];

    // SQL query untuk mengupdate data dosen
    $sql = "UPDATE dosen SET nama_dosen='$nama_dosen', nip='$nip' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data dosen berhasil diperbarui!');</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data dosen: " . $conn->error . "');</script>";
    }
}


// Ambil semua data dosen
$result = $conn->query("SELECT * FROM dosen");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Manajemen Data Dosen | Institut Teknologi Bacharuddin Jusuf Habibie</title>
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
                    <div class="sb-sidenav-footer">
                        Tugas PTC daraya
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">

                        <form method="POST">
                            <div class="text-center">
                            <br><center><h2>Tambah Data Dosen</h2></center><br>
                            </div>

                            <!-- Hidden ID input untuk edit -->
                            <input type="hidden" name="id" id="id" value="">

                            <div class="mb-3 row">
                                <div class="col">
                                    <label for="nama_dosen" class="form-label">Nama Dosen</label>
                                    <input type="text" class="form-control" name="nama_dosen" id="nama_dosen" placeholder="Masukkan Nama Dosen" required>
                                </div>
                                <div class="col">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control" name="nip" id="nip" placeholder="Masukkan NIP" required>
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" name="tambah" class="btn btn-primary mx-2" id="tambah-btn">Tambah Dosen</button>
                                <button type="submit" name="edit" class="btn btn-warning mx-2" id="edit-btn" style="display: none;">Simpan Perubahan</button>
                            </div>
                        </form>


        <form method="POST">
        <br>
        <div class="card mb-4">
            <div class="card-header">
                <center><h2>Data Dosen</h2></center>
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Dosen</th>
                            <th>NIP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query database untuk mengambil data dosen
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['nama_dosen']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nip']); ?></td>
                                    <td>
                                        <a href="edit_dosen.php?id=<?php echo $row['dosen_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="?delete=<?php echo $row['dosen_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>Tidak ada data dosen yang ditemukan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            </div>

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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <!-- <script>
            $(document).ready(function () {
                // Aktifkan DataTables pada tabel
                $('#example').DataTable({
                    "paging": true,        // Aktifkan pagination
                    "lengthChange": true,  // Aktifkan pilihan jumlah baris (10, 25, 50, dll.)
                    "searching": true,     // Aktifkan pencarian
                    "ordering": true,      // Aktifkan sorting
                    "info": true,          // Tampilkan informasi jumlah data
                    "autoWidth": false,    // Nonaktifkan lebar otomatis kolom
                    "pageLength": 5        // Jumlah baris per halaman (default 5)
                });
            });
        </script> -->
    </body>
</html>
