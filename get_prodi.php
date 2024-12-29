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

// Ambil parameter tahun akademik dari query string
$tahun_akademik = isset($_GET['tahun_akademik']) ? $conn->real_escape_string($_GET['tahun_akademik']) : '';

// Query untuk mengambil data program studi berdasarkan tahun akademik
$sql = "SELECT p.prodi_id, p.nama_prodi
        FROM prodi p
        JOIN jadwal2 j ON p.prodi_id = j.prodi_id
        JOIN tahun_akademik ta ON j.tahun_akademik_id = ta.tahun_akademik_id
        WHERE ta.tahun_akademik_nama = '$tahun_akademik'
        GROUP BY p.prodi_id";  // Pastikan Anda menggunakan GROUP BY agar tidak ada duplikasi program studi

// Eksekusi query
$result = $conn->query($sql);

// Membuat array untuk menyimpan data program studi
$prodi = [];
while ($row = $result->fetch_assoc()) {
    $prodi[] = $row;
}

// Kembalikan data dalam format JSON
echo json_encode($prodi);

// Tutup koneksi
$conn->close();
?>
