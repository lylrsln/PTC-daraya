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

// Query untuk mendapatkan jumlah
$queryDosen = "SELECT COUNT(*) AS jumlah_dosen FROM dosen";
$queryProdi = "SELECT COUNT(*) AS jumlah_prodi FROM prodi";
$queryMatkul = "SELECT COUNT(*) AS jumlah_matkul FROM matakuliah";
$queryKelas = "SELECT COUNT(*) AS jumlah_kelas FROM kelas";
$queryRuangan = "SELECT COUNT(*) AS jumlah_ruangan FROM ruangan";

// Eksekusi query dan periksa hasilnya
$resultDosen = mysqli_query($conn, $queryDosen);
if (!$resultDosen) {
    die('Error: ' . mysqli_error($conn));
}

$resultProdi = mysqli_query($conn, $queryProdi);
if (!$resultProdi) {
    die('Error: ' . mysqli_error($conn));
}

$resultMatkul = mysqli_query($conn, $queryMatkul);
if (!$resultMatkul) {
    die('Error: ' . mysqli_error($conn));
}

$resultKelas = mysqli_query($conn, $queryKelas);
if (!$resultKelas) {
    die('Error: ' . mysqli_error($conn));
}

$resultRuangan = mysqli_query($conn, $queryRuangan);
if (!$resultRuangan) {
    die('Error: ' . mysqli_error($conn));
}

// Fetch hasil query
$rowDosen = mysqli_fetch_assoc($resultDosen);
$rowProdi = mysqli_fetch_assoc($resultProdi);
$rowMatkul = mysqli_fetch_assoc($resultMatkul);
$rowKelas = mysqli_fetch_assoc($resultKelas);
$rowRuangan = mysqli_fetch_assoc($resultRuangan);

// Persiapkan data untuk chart
$data = array(
    'jumlah_dosen' => $rowDosen['jumlah_dosen'],
    'jumlah_prodi' => $rowProdi['jumlah_prodi'],
    'jumlah_matkul' => $rowMatkul['jumlah_matkul'],
    'jumlah_kelas' => $rowKelas['jumlah_kelas'],
    'jumlah_ruangan' => $rowRuangan['jumlah_ruangan']
);

// Return data sebagai JSON
header('Content-Type: application/json');
echo json_encode($data);

// Tutup koneksi
$conn->close();
?>
