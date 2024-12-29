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

// Ambil data dosen, matakuliah, dan prodi untuk dropdown
$dosen_result = $conn->query("SELECT dosen_id, nama_dosen FROM dosen");
$matkul_result = $conn->query("SELECT matkul_id, nama_matkul FROM matakuliah");
$kelas_result = $conn->query("SELECT kelas_id, nama_kelas FROM kelas");
$prodi_result = $conn->query("SELECT prodi_id, nama_prodi FROM prodi");
$tahun_result = $conn->query("SELECT tahun_akademik_id, tahun_akademik_nama FROM tahun_akademik");

// Ambil semua data dosen_mk
$result = $conn->query("SELECT * FROM dosen_mk");

// Handle delete action
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    
    // Cek apakah ID valid di database
    $stmt = $conn->prepare("SELECT dosen_mk_id FROM dosen_mk WHERE dosen_mk_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // ID valid, lakukan delete
        $stmt = $conn->prepare("DELETE FROM dosen_mk WHERE dosen_mk_id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: dosen_mk.php");
            exit;
        } else {
            echo "Gagal menghapus data.";
        }
    } else {
        echo "ID tidak ditemukan di database.";
    }
    $stmt->close();
}

// Mendapatkan nama dosen, nama matkul, dan nama prodi berdasarkan ID
function getNamaDosen($dosen_id, $conn) {
    $stmt = $conn->prepare("SELECT nama_dosen FROM dosen WHERE dosen_id = ?");
    $stmt->bind_param("i", $dosen_id);
    $stmt->execute();
    $stmt->bind_result($nama_dosen);
    $stmt->fetch();
    $stmt->close();
    return $nama_dosen;
}

function getNamaMatkul($matkul_id, $conn) {
    $stmt = $conn->prepare("SELECT nama_matkul FROM matakuliah WHERE matkul_id = ?");
    $stmt->bind_param("i", $matkul_id);
    $stmt->execute();
    $stmt->bind_result($nama_matkul);
    $stmt->fetch();
    $stmt->close();
    return $nama_matkul;
}

function getNamaKelas($kelas_id, $conn) {
    $stmt = $conn->prepare("SELECT nama_kelas FROM kelas WHERE kelas_id = ?");
    $stmt->bind_param("i", $kelas_id);
    $stmt->execute();
    $stmt->bind_result($nama_kelas);
    $stmt->fetch();
    $stmt->close();
    return $nama_kelas;
}

function getNamaProdi($prodi_id, $conn) {
    $stmt = $conn->prepare("SELECT nama_prodi FROM prodi WHERE prodi_id = ?");
    $stmt->bind_param("i", $prodi_id);
    $stmt->execute();
    $stmt->bind_result($nama_prodi);
    $stmt->fetch();
    $stmt->close();
    return $nama_prodi;
}

function getNamaTahun($tahun_akademik_id, $conn) {
    // Query untuk mendapatkan nama tahun akademik berdasarkan ID
    $query = "SELECT tahun_akademik_nama FROM tahun_akademik WHERE tahun_akademik_id = ?";
    
    // Persiapkan statement
    if ($stmt = $conn->prepare($query)) {
        // Bind parameter
        $stmt->bind_param("i", $tahun_akademik_id);
        
        // Eksekusi statement
        $stmt->execute();
        
        // Ambil hasil eksekusi
        $result = $stmt->get_result();
        
        // Periksa apakah ada hasil
        if ($result->num_rows > 0) {
            // Ambil data hasil query
            $row = $result->fetch_assoc();
            // Kembalikan nama tahun akademik
            return $row['tahun_akademik_nama'];
        } else {
            // Jika tidak ditemukan, kembalikan pesan error
            return "Tahun Tidak Ditemukan";
        }
        
        // Tutup statement
        $stmt->close();
    } else {
        // Jika query gagal disiapkan, kembalikan pesan error
        return "Gagal menyiapkan query: " . $conn->error;
    }
}



$edit_data = null; // Menyimpan data yang akan diedit

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM dosen_mk WHERE dosen_mk_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result_edit = $stmt->get_result();
    
    if ($result_edit->num_rows > 0) {
        $edit_data = $result_edit->fetch_assoc();
    } else {
        echo "<script>alert('ID tidak ditemukan!'); window.location.href = 'dosen_mk.php';</script>";
    }
    $stmt->close();
}

// Handle Update data dosen_mk
if (isset($_POST['edit'])) {
    // Pastikan ID tersedia sebelum digunakan
    if (isset($_POST['dosen_mk_id']) && !empty($_POST['dosen_mk_id'])) {
        $id = $_POST['dosen_mk_id'];
        // Lakukan update seperti biasa
    } else {
        // Tambah data baru jika tidak ada ID
        if (isset($_POST['dosen_id']) && isset($_POST['matkul_id']) && isset($_POST['kelas_id']) && isset($_POST['prodi_id']) && isset($_POST['jurusan']) && isset($_POST['tahun_akademik_id']) ) {
            $dosen_id = $_POST['dosen_id'];
            $matkul_id = $_POST['matkul_id'];
            $kelas_id = $_POST['kelas_id'];
            $prodi_id = $_POST['prodi_id'];
            $jurusan = $_POST['jurusan'];
            $tahun_akademik_id = $_POST['tahun_akademik_id'];

            // Query insert untuk menambah data baru
            $sql = "INSERT INTO dosen_mk (dosen_id, matkul_id, kelas_id, prodi_id, jurusan, tahun_akademik_id) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiiisi", $dosen_id, $matkul_id, $kelas_id, $prodi_id, $jurusan, $tahun_akademik_id);
            
            if ($stmt->execute()) {
                echo "<script>alert('Data dosen berhasil ditambahkan!'); window.location.href = 'dosen_mk.php';</script>";
            } else {
                echo "<script>alert('Gagal menambahkan data dosen: " . $conn->error . "');</script>";
            }
            $stmt->close();
        }
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
        <title>Manajemen Data Dosen Matakuliah| Institut Teknologi Bacharuddin Jusuf Habibie</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/dosen.css" rel="stylesheet" />
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
        </script>
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body>
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
                        <!-- Manajemen Data Dosen -->
                        
                        <br><center><h1>Manajemen Data Dosen-MK</h1></center>
                        <br>
                        <form method="POST" action="">
                            <div class="mb-3 row">
        <div class="col">
            <label for="dosen_id" class="form-label">Dosen:</label>
            <select name="dosen_id" class="form-select" required>
                <?php while ($dosen = $dosen_result->fetch_assoc()) { ?>
                    <option value="<?php echo $dosen['dosen_id']; ?>" 
                        <?php echo ($edit_data && $edit_data['dosen_id'] == $dosen['dosen_id']) ? 'selected' : ''; ?>>
                        <?php echo $dosen['nama_dosen']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col">
            <label for="matkul_id" class="form-label">Matakuliah:</label>
            <select name="matkul_id" class="form-select" required>
                <?php while ($matkul = $matkul_result->fetch_assoc()) { ?>
                    <option value="<?php echo $matkul['matkul_id']; ?>" 
                        <?php echo ($edit_data && $edit_data['matkul_id'] == $matkul['matkul_id']) ? 'selected' : ''; ?>>
                        <?php echo $matkul['nama_matkul']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col">
            <label for="kelas_id" class="form-label">Kelas:</label>
            <select name="kelas_id" class="form-select" required>
                <?php while ($kelas = $kelas_result->fetch_assoc()) { ?>
                    <option value="<?php echo $kelas['kelas_id']; ?>" 
                        <?php echo ($edit_data && $edit_data['kelas_id'] == $kelas['kelas_id']) ? 'selected' : ''; ?>>
                        <?php echo $kelas['nama_kelas']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col">
            <label for="prodi_id" class="form-label">Program Studi:</label>
            <select name="prodi_id" class="form-select" required onchange="updateJurusan()">
                <?php while ($prodi = $prodi_result->fetch_assoc()) { ?>
                    <option value="<?php echo $prodi['prodi_id']; ?>" 
                        <?php echo ($edit_data && $edit_data['prodi_id'] == $prodi['prodi_id']) ? 'selected' : ''; ?>>
                        <?php echo $prodi['nama_prodi']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col">
            <label for="jurusan" class="form-label">Jurusan:</label>
            <select name="jurusan" id="jurusan" class="form-select" required>
                <option value="">Pilih Prodi terlebih dahulu</option>
            </select>
        </div>
    </div>
    <div class="col">
        <label for="tahun_akademik_id" class="form-label">Tahun Akademik:</label>
        <select name="tahun_akademik_id" class="form-select" required>
            <option value="" disabled selected>Pilih Tahun Akademik</option>
            <?php if ($tahun_result && $tahun_result->num_rows > 0): ?>
                <?php while ($tahun = $tahun_result->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($tahun['tahun_akademik_id']); ?>" 
                        <?php echo ($edit_data && $edit_data['tahun_akademik_id'] == $tahun['tahun_akademik_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($tahun['tahun_akademik_nama']); ?>
                    </option>
                <?php endwhile; ?>
            <?php else: ?>
                <option value="" disabled>Tidak ada data tahun akademik</option>
            <?php endif; ?>
        </select>
    </div>

    
                            <br><center><button class="btn btn-primary mt-3" type="submit" name="edit">Update Data</button></center><br>
                        </form>
                        <div class="card mb-4">
    <div class="card-header">
        <center><h2>Daftar Dosen-MK</h2></center>
    </div>
    <div class="card-body">
        <table id="datatablesSimple" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Dosen</th>
                    <th>Matakuliah</th>
                    <th>Kelas</th>
                    <th>Prodi</th>
                    <th>Jurusan</th>
                    <th>Tahun Akademik</th>

                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo getNamaDosen($row['dosen_id'], $conn); ?></td>
                        <td><?php echo getNamaMatkul($row['matkul_id'], $conn); ?></td>
                        <td><?php echo getNamaKelas($row['kelas_id'], $conn); ?></td>
                        <td><?php echo getNamaProdi($row['prodi_id'], $conn); ?></td>
                        <td><?php echo $row['jurusan']; ?></td>
                        <td><?php echo getNamaTahun($row['tahun_akademik_id'], $conn); ?></td>
                        <td>
                            <a href="edit_dosen_mk.php?id=<?php echo $row['dosen_mk_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="?delete=<?php echo $row['dosen_mk_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
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
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
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

