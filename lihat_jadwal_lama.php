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

// Ambil data tahun akademik
$sql_tahun = "SELECT * FROM tahun_akademik"; 
$result_tahun = $conn->query($sql_tahun);

// Ambil data prodi
$sql_prodi = "SELECT * FROM prodi";
$result_prodi = $conn->query($sql_prodi);

// Ambil data pencarian
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$tahun_akademik = isset($_GET['tahun_akademik']) ? $conn->real_escape_string($_GET['tahun_akademik']) : '';
$prodi_id = isset($_GET['prodi_id']) ? $conn->real_escape_string($_GET['prodi_id']) : '';
$angkatan = isset($_GET['angkatan']) ? $conn->real_escape_string($_GET['angkatan']) : '';

// Query untuk menampilkan data jadwal dengan nama-nama terkait dan data waktu
$sql = "SELECT j.*, d.nama_dosen, m.nama_matkul, k.nama_kelas, r.nama_ruangan, ta.tahun_akademik_nama, w.hari, w.jam_mulai, w.jam_selesai, p.nama_prodi
        FROM jadwal2 j
        LEFT JOIN dosen d ON j.dosen_id = d.dosen_id
        LEFT JOIN matakuliah m ON j.matkul_id = m.matkul_id
        LEFT JOIN kelas k ON j.kelas_id = k.kelas_id
        LEFT JOIN ruangan r ON j.ruangan_id = r.ruangan_id
        LEFT JOIN tahun_akademik ta ON j.tahun_akademik_id = ta.tahun_akademik_id
        LEFT JOIN waktu w ON j.waktu_id = w.waktu_id
        LEFT JOIN prodi p ON j.prodi_id = p.prodi_id";

// Tambahkan kondisi untuk tahun akademik, pencarian, prodi, dan angkatan
if ($tahun_akademik) {
    $sql .= " WHERE ta.tahun_akademik_nama = '$tahun_akademik'";
}
if ($search) {
    $sql .= " AND (d.nama_dosen LIKE '%$search%' OR m.nama_matkul LIKE '%$search%')";
}
if ($prodi_id) {
    $sql .= " AND j.prodi_id = '$prodi_id'";
}
if ($angkatan) {
    $sql .= " AND k.angkatan = '$angkatan'";
}

$result = $conn->query($sql);

// Kelompokkan jadwal berdasarkan prodi_id
$jadwal_by_prodi = [];
while ($row = $result->fetch_assoc()) {
    $jadwal_by_prodi[$row['prodi_id']][] = $row;
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
    <title>Manajemen Data Kelas | Institut Teknologi Bacharuddin Jusuf Habibie</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/dosen.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Script untuk menampilkan prodi berdasarkan tahun akademik -->
    <script>
        function filterProdi() {
            var tahunAkademik = document.getElementById('tahun_akademik').value;
            var prodiSelect = document.getElementById('prodi_id');
            
            // Set semua pilihan prodi menjadi disabled
            for (var i = 0; i < prodiSelect.options.length; i++) {
                prodiSelect.options[i].disabled = true;
            }

            // Enable semua pilihan prodi setelah tahun akademik dipilih
            if (tahunAkademik) {
                // Fetch Prodi berdasarkan Tahun Akademik
                fetch('get_prodi.php?tahun_akademik=' + tahunAkademik)
                    .then(response => response.json())
                    .then(data => {
                        // Clear the previous options
                        prodiSelect.innerHTML = '<option value="">--Pilih Program Studi--</option>';
                        
                        // Add available prodi options
                        data.forEach(function(prodi) {
                            var option = document.createElement('option');
                            option.value = prodi.prodi_id;
                            option.textContent = prodi.nama_prodi;
                            prodiSelect.appendChild(option);
                        });

                        // Enable prodi select
                        prodiSelect.disabled = false;
                    });
            } else {
                // Reset prodi select if no year selected
                prodiSelect.innerHTML = '<option value="">--Pilih Program Studi--</option>';
                prodiSelect.disabled = true;
            }
        }
    </script>
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
                <h1 class="mt-4">Jadwal Kuliah</h1>
                    <div class="row">
                        <div class="col-md-12">
                            <form method="GET" class="form">
                                <div class="row">
                                    <!-- Tahun Akademik -->
                                    <div class="col-md-3 mb-3">
                                        <label for="tahun_akademik" class="form-label">Tahun Akademik</label>
                                        <select name="tahun_akademik" id="tahun_akademik" class="form-select" onchange="filterProdi()">
                                            <option value="">--Pilih Tahun Akademik--</option>
                                            <?php while ($row_tahun = $result_tahun->fetch_assoc()) : ?>
                                                <option value="<?= $row_tahun['tahun_akademik_nama'] ?>" <?= ($row_tahun['tahun_akademik_nama'] == $tahun_akademik) ? 'selected' : '' ?>>
                                                    <?= $row_tahun['tahun_akademik_nama'] ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <!-- Program Studi -->
                                    <div class="col-md-3 mb-3">
                                        <label for="prodi_id" class="form-label">Program Studi</label>
                                        <select name="prodi_id" id="prodi_id" class="form-select">
                                            <option value="">--Pilih Program Studi--</option>
                                            <?php while ($row_prodi = $result_prodi->fetch_assoc()) : ?>
                                                <option value="<?= $row_prodi['prodi_id'] ?>" <?= ($row_prodi['prodi_id'] == $prodi_id) ? 'selected' : '' ?>>
                                                    <?= $row_prodi['nama_prodi'] ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <!-- Angkatan dan Pencarian berdampingan -->
                                    <div class="col-md-2 mb-3">
                                        <label for="angkatan" class="form-label">Angkatan</label>
                                        <input type="text" class="form-control" id="angkatan" name="angkatan" value="<?= $angkatan ?>" placeholder="Angkatan" />
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="search" class="form-label">Pencarian</label>
                                        <input type="text" class="form-control" id="search" name="search" value="<?= $search ?>" placeholder="Cari Dosen atau Matakuliah" />
                                    </div>
                                </div>

                                <!-- Tombol Cari di bawah pencarian -->
                                <div class="row">
                                    <div class="col-md-2 mb-3 d-flex align-items-end justify-content-center">
                                        <button type="submit" class="btn btn-primary w-100">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <h2 class="mt-4">Jadwal Kuliah Berdasarkan Program Studi</h2>
                    <div class="row">
                        <?php foreach ($jadwal_by_prodi as $prodi_id => $jadwal_list) : ?>
                            <div class="col-md-12 mb-4">
                                <h3>Program Studi: <?= $jadwal_list[0]['nama_prodi'] ?></h3>
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Matakuliah</th>
                                            <th>Dosen</th>
                                            <th>Kelas</th>
                                            <th>Ruangan</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($jadwal_list as $jadwal) : ?>
                                            <tr>
                                                <td><?= $jadwal['nama_matkul'] ?></td>
                                                <td><?= $jadwal['nama_dosen'] ?></td>
                                                <td><?= $jadwal['nama_kelas'] ?></td>
                                                <td><?= $jadwal['nama_ruangan'] ?></td>
                                                <td><?= $jadwal['hari'] ?>, <?= $jadwal['jam_mulai'] ?> - <?= $jadwal['jam_selesai'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>

<?php $conn->close(); ?>
