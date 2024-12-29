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

// Mendapatkan ID Prodi yang dipilih
$prodi_id = isset($_GET['prodi_id']) ? $conn->real_escape_string($_GET['prodi_id']) : '';

if (!empty($prodi_id)) {
    // Ambil jurusan berdasarkan prodi_id
    $result = $conn->query("SELECT jurusan FROM prodi WHERE prodi_id = '$prodi_id'");

    // Cek jika ada jurusan yang ditemukan
    if ($result->num_rows > 0) {
        echo '<option value="">Pilih Jurusan</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['jurusan'] . '">' . $row['jurusan'] . '</option>';
        }
    } else {
        echo '<option value="">Tidak ada jurusan ditemukan</option>';
    }
}
?>
