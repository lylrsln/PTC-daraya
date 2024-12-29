<?php
// Koneksi ke database MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penjadwalan2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Fetching data from Flask API (assuming Flask is running at http://127.0.0.1:5000)
$flask_url = 'http://127.0.0.1:5000/penjadwalan2';  // URL for Flask API

// Initialize cURL session to interact with Flask API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $flask_url);  // URL to the Flask API
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Return response instead of printing
curl_setopt($ch, CURLOPT_TIMEOUT, 10);  // Set a timeout for the cURL request (10 seconds)
$response = curl_exec($ch);  // Execute cURL request

// Check if there was an error with the cURL request
if (curl_errno($ch)) {
    die('Error fetching data from Flask API: ' . curl_error($ch));
}

curl_close($ch);  // Close cURL session

// Decode JSON response
$data = json_decode($response, true);

// Cek error decoding JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding JSON response from Flask API: ' . json_last_error_msg());
}

// Fungsi untuk mendapatkan nama tahun akademik berdasarkan ID
function getNamaTahun($tahun_akademik_id, $conn) {
    $query = "SELECT tahun_akademik_nama FROM tahun_akademik WHERE tahun_akademik_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $tahun_akademik_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['tahun_akademik_nama'];
    } else {
        return "Tahun Tidak Ditemukan";
    }
}

// Fungsi untuk mendapatkan daftar tahun akademik
function getTahunAkademik($conn) {
    $query = "SELECT tahun_akademik_id, tahun_akademik_nama FROM tahun_akademik";
    $result = $conn->query($query);
    return $result;
}

// Menyimpan tahun akademik yang dipilih dari URL jika ada
$tahun_akademik = isset($_POST['tahun_akademik']) ? $_POST['tahun_akademik'] : '';

$tahun_akademik_list = getTahunAkademik($conn); // Ambil daftar tahun akademik
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
                        <!-- Manajemen Data Dosen -->
                        <br><center><h1>PEMBUATAN JADWAL</h1></center><br>

                        <form method="GET" action="penjadwalan2.php?tahun_akademik_id=">
                            <label for="tahun_akademik">Pilih Tahun Akademik:</label>
                            <select name="tahun_akademik_id" id="tahun_akademik" class="form-control">
                                <?php
                                // Mengambil daftar tahun akademik dari database
                                $sql_tahun_akademik = "SELECT tahun_akademik_id, tahun_akademik_nama FROM tahun_akademik ORDER BY tahun_akademik_nama";
                                $result_tahun_akademik = $conn->query($sql_tahun_akademik);

                                if ($result_tahun_akademik->num_rows > 0) {
                                    while ($row = $result_tahun_akademik->fetch_assoc()) {
                                        $selected = ($row['tahun_akademik_id'] == $tahun_akademik) ? 'selected' : ''; // Menandai tahun yang dipilih
                                        echo "<option value='" . $row['tahun_akademik_id'] . "' $selected>" . $row['tahun_akademik_nama'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Tidak ada tahun akademik</option>";
                                }
                                ?>
                            </select>
                            <!-- Tombol untuk submit -->
                            <button type="submit" class="btn btn-primary mt-3">Buat Jadwal</button>
                        </form>

                            <?php
                            // Jika ada tahun akademik yang dipilih, tampilkan nama tahun akademik
                            if (!empty($tahun_akademik)) {
                                $tahun_nama = getNamaTahun($tahun_akademik, $conn);
                                echo "<p class='mt-4'>Tahun Akademik Terpilih: $tahun_nama</p>";
                            }
                            ?>
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
