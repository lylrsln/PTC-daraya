<?php
// Set waktu eksekusi maksimal menjadi 600 detik (10 menit)
set_time_limit(600);

// Koneksi ke database MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penjadwalan2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan tahun akademik yang dipilih dari URL atau set default (misal tahun akademik ID 1)
$tahun_akademik_id = isset($_GET['tahun_akademik_id']) ? $_GET['tahun_akademik_id'] : 1;

// Query untuk mengambil nama tahun akademik yang dipilih
$sql_tahun_akademik = "
    SELECT tahun_akademik_nama 
    FROM tahun_akademik 
    WHERE tahun_akademik_id = $tahun_akademik_id
";
$result_tahun_akademik = $conn->query($sql_tahun_akademik);
$tahun_akademik_nama = '';

if ($result_tahun_akademik->num_rows > 0) {
    $row = $result_tahun_akademik->fetch_assoc();
    $tahun_akademik_nama = $row['tahun_akademik_nama'];
} else {
    die("Tidak ada data ditemukan untuk tahun akademik.");
}

// Fetching data dari Flask API (URL untuk Flask API)
$flask_url = "http://127.0.0.1:5000/penjadwalan2?tahun_akademik_id=$tahun_akademik_id"; 

// Inisialisasi cURL session untuk berinteraksi dengan Flask API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $flask_url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
curl_setopt($ch, CURLOPT_TIMEOUT, 600);  
$response = curl_exec($ch);  

// Cek jika terjadi error saat mengambil data dari Flask API
if (curl_errno($ch)) {
    die('Error fetching data from Flask API: ' . curl_error($ch));
}

curl_close($ch);  

// Mendekode respons JSON setelah perubahan
$data = json_decode($response, true);

// Memeriksa error decoding JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding JSON response from Flask API: ' . json_last_error_msg());
}

// Urutan hari yang diinginkan (dimulai dari Senin)
$urutan_hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

// Mengambil data waktu (hari dan jam mulai-jam selesai) berdasarkan tahun_akademik_id
$sql_waktu = "
    SELECT * 
    FROM waktu 
    ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'), jam_mulai
";
$result_waktu = $conn->query($sql_waktu);

// Mengambil data ruangan
$sql_ruangan = "SELECT * FROM ruangan";
$result_ruangan = $conn->query($sql_ruangan);

// Query untuk mengambil data jadwal berdasarkan tahun akademik yang dipilih
$sql_jadwal = "
    SELECT 
        dm.jadwal_id, 
        dm.dosen_id, 
        dm.matkul_id, 
        dm.waktu_id, 
        dm.kelas_id, 
        dm.ruangan_id, 
        dm.tahun_akademik_id, 
        dm.prodi_id,
        d.nama_dosen, 
        m.nama_matkul, 
        p.nama_prodi, 
        p.jurusan, 
        ta.tahun_akademik_nama, 
        w.hari, 
        w.jam_mulai, 
        w.jam_selesai, 
        k.nama_kelas, 
        r.nama_ruangan
    FROM jadwal2 dm
    JOIN dosen d ON dm.dosen_id = d.dosen_id
    JOIN matakuliah m ON dm.matkul_id = m.matkul_id
    JOIN prodi p ON dm.prodi_id = p.prodi_id
    JOIN tahun_akademik ta ON dm.tahun_akademik_id = ta.tahun_akademik_id
    JOIN waktu w ON dm.waktu_id = w.waktu_id
    JOIN kelas k ON dm.kelas_id = k.kelas_id
    JOIN ruangan r ON dm.ruangan_id = r.ruangan_id
    WHERE dm.tahun_akademik_id = $tahun_akademik_id  -- Filter berdasarkan tahun akademik
";
$result_jadwal = $conn->query($sql_jadwal);

// Membaca data ruangan ke dalam array
$ruangan_arr = [];
while ($row = $result_ruangan->fetch_assoc()) {
    $ruangan_arr[$row['ruangan_id']] = $row['nama_ruangan'];
}

// Membaca data waktu ke dalam array
$waktu_arr = [];
while ($row = $result_waktu->fetch_assoc()) {
    $waktu_arr[$row['waktu_id']] = [
        'hari' => $row['hari'],
        'jam_mulai' => $row['jam_mulai'],
        'jam_selesai' => $row['jam_selesai'],
    ];
}

// Menginisialisasi matriks berdasarkan waktu dan ruangan
$matriks_jadwal = [];
$jadwal_cek = [];  // Array untuk mengecek duplikasi

foreach ($waktu_arr as $waktu) {
    foreach ($ruangan_arr as $ruangan_id => $ruangan) {
        // Pastikan tidak ada duplikat kombinasi waktu_id dan ruangan_id
        $matriks_jadwal[$waktu['hari']][$waktu['jam_mulai']][$ruangan_id] = [];
        $jadwal_cek[$waktu['hari']][$waktu['jam_mulai']][$ruangan_id] = false;
    }
}

function cariAlternatif($hari, $jam_mulai, $matriks_jadwal, $ruangan_arr) {
    // Cek apakah ada ruangan yang kosong pada hari dan jam yang dimaksud
    foreach ($ruangan_arr as $ruangan_id => $ruangan) {
        if (!isset($matriks_jadwal[$hari][$jam_mulai][$ruangan_id])) {
            // Jika ditemukan ruangan kosong, kembalikan id ruangan tersebut
            return $ruangan_id;
        }
    }

    // Jika tidak ada ruangan kosong pada jam tersebut, coba cari waktu alternatif
    foreach ($matriks_jadwal[$hari] as $jam => $ruangan) {
        if ($jam > $jam_mulai) {
            // Cari ruangan yang kosong pada waktu lebih lanjut
            foreach ($ruangan_arr as $ruangan_id => $ruangan) {
                if (!isset($matriks_jadwal[$hari][$jam][$ruangan_id])) {
                    // Jika ditemukan ruangan kosong pada jam berikutnya
                    return [$jam, $ruangan_id];
                }
            }
        }
    }

    // Jika tidak ada alternatif yang ditemukan, kembalikan null
    return null;
}

// Isi matriks dengan data jadwal yang sesuai tahun akademik
foreach ($result_jadwal as $row) {
    $waktu_id = $row['waktu_id'];
    $ruangan_id = $row['ruangan_id'];
    $hari = $waktu_arr[$waktu_id]['hari'];
    $jam_mulai = $waktu_arr[$waktu_id]['jam_mulai'];

    // Cek duplikasi pada hari, jam mulai, dan ruangan
if (!isset($jadwal_cek[$hari][$jam_mulai][$ruangan_id]) || $jadwal_cek[$hari][$jam_mulai][$ruangan_id] === false) {
    // Jika belum ada jadwal, masukkan ke matriks
    $matriks_jadwal[$hari][$jam_mulai][$ruangan_id] = [
        'matkul' => $row['nama_matkul'],
        'kelas' => $row['nama_kelas'],
        'dosen' => $row['nama_dosen'],
    ];
    $jadwal_cek[$hari][$jam_mulai][$ruangan_id] = true;
} else {
    // Cari alternatif jika terjadi duplikasi
    $alternatif = cariAlternatif($hari, $jam_mulai, $matriks_jadwal, $ruangan_arr);
    if ($alternatif !== null) {
        if (is_array($alternatif)) {
            // Jika alternatif ditemukan, pindahkan jadwal ke alternatif waktu dan ruangan
            list($jam, $ruangan_id_baru) = $alternatif;
            $matriks_jadwal[$hari][$jam][$ruangan_id_baru] = [
                'matkul' => $row['nama_matkul'],
                'kelas' => $row['nama_kelas'],
                'dosen' => $row['nama_dosen'],
            ];
            $jadwal_cek[$hari][$jam][$ruangan_id_baru] = true;
        } else {
            // Jika alternatif hanya ruangan, alihkan ke ruangan lain pada jam yang sama
            $matriks_jadwal[$hari][$jam_mulai][$alternatif] = [
                'matkul' => $row['nama_matkul'],
                'kelas' => $row['nama_kelas'],
                'dosen' => $row['nama_dosen'],
            ];
            $jadwal_cek[$hari][$jam_mulai][$alternatif] = true;
        }
    }
}

}

// Tutup koneksi ke database
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Mata Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 20px;
            color: #333;
        }
        h3 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 14px;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        td {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .container {
            margin-right: 10%;
            max-width: 90%;
            padding-top: 60px;
        }
        @media screen and (max-width: 768px) {
            table {
                width: 100%;
                overflow-x: auto;
                display: block;
            }
            th, td {
                padding: 10px;
            }
        }
        .button-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .button-container button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 0 10px;
        }
        .button-container button:hover {
            background-color: #45a049;
        }
        button:focus {
            outline: none;
        }
        @media print {
            button {
                display: none;
            }
            body {
                margin: 0;
                padding: 20px;
            }
            table {
                width: 100%;
                border: 1px solid #333;
            }
            th, td {
                font-size: 12px;
                padding: 8px;
                text-align: center;
                border: 1px solid #ddd;
            }
            th {
                background-color: #4CAF50;
                color: white;
            }
            h3 {
                text-align: center;
                font-size: 18px;
            }
        }
    </style>
    <!-- jQuery and Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jsPDF for PDF Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <!-- SheetJS for Excel Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h3>Jadwal Mata Kuliah Tahun Akademik: <?= $tahun_akademik_nama ?></h3>

    <!-- Tombol Cetak PDF, Export Excel, dan Simpan -->
    <div class="button-container">
        <button onclick="printPDF()">Cetak PDF</button>
        <button onclick="exportToExcel()">Export to Excel</button>
        <form action="simpan_jadwal.php" method="POST" style="margin-bottom: 20px;">
            <input type="hidden" name="matriks_jadwal" value="<?= htmlspecialchars(json_encode($matriks_jadwal)); ?>">
            <button type="submit" class="btn btn-success">Simpan Jadwal</button>
        </form>
    </div>

    <!-- Tabel Matriks Jadwal -->
    <table class="table table-bordered" id="jadwalTable">
        <thead>
            <tr>
                <th>Hari</th>
                <th>Jam</th>
                <?php foreach ($ruangan_arr as $ruangan) { ?>
                    <th><?= $ruangan ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menampilkan jadwal dari matriks
            foreach ($urutan_hari as $hari) {
                foreach ($waktu_arr as $jam_data) {
                    if ($jam_data['hari'] === $hari) {
                        ?>
                        <tr>
                            <td><?= $hari ?></td>
                            <td><?= $jam_data['jam_mulai'] ?> - <?= $jam_data['jam_selesai'] ?></td>
                            <?php
                            foreach ($ruangan_arr as $ruangan_id => $ruangan) {
                                $jadwal = isset($matriks_jadwal[$hari][$jam_data['jam_mulai']][$ruangan_id]) ? $matriks_jadwal[$hari][$jam_data['jam_mulai']][$ruangan_id] : null;
                                if ($jadwal) {
                                    echo "<td>{$jadwal['dosen']}<br>{$jadwal['matkul']}<br>{$jadwal['kelas']}</td>";
                                } else {
                                    echo "<td>-</td>";
                                }
                            }
                            ?>
                        </tr>
                        <?php
                    }
                }
            }
            ?>
        </tbody>
    </table>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script>
    // Fungsi untuk mencetak ke PDF menggunakan jsPDF
    function printPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Menangkap elemen jadwal
        html2canvas(document.getElementById('jadwalTable')).then(function (canvas) {
            // Menambahkan gambar hasil tangkapan canvas ke PDF
            doc.addImage(canvas.toDataURL('image/png'), 'PNG', 10, 10);
            doc.save('jadwal_mata_kuliah.pdf');
        });
    }

    // Fungsi untuk mengekspor ke Excel menggunakan SheetJS
    function exportToExcel() {
        const table = document.getElementById('jadwalTable');
        const wb = XLSX.utils.table_to_book(table, {sheet: "Jadwal Mata Kuliah"});
        XLSX.writeFile(wb, 'jadwal_mata_kuliah.xlsx');
    }
</script>

</body>
</html>
