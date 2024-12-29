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

// Mendapatkan tahun akademik yang dipilih
$tahun_akademik_id = isset($_POST['tahun_akademik_id']) ? $_POST['tahun_akademik_id'] : 1;

// Query untuk mengambil data tahun akademik
$sql_ta = "SELECT tahun_akademik_nama FROM tahun_akademik WHERE tahun_akademik_id = ?";
$stmt_ta = $conn->prepare($sql_ta);
$stmt_ta->bind_param("i", $tahun_akademik_id);
$stmt_ta->execute();
$result_ta = $stmt_ta->get_result();
$tahun_akademik_nama = $result_ta->fetch_assoc()['tahun_akademik_nama'];

// Query untuk mengambil data jadwal dari jadwal2 beserta informasi terkait
$sql_jadwal2 = "
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
    WHERE dm.tahun_akademik_id = ?
    ORDER BY FIELD(w.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'), w.jam_mulai
";

// Persiapkan query
$stmt = $conn->prepare($sql_jadwal2);
$stmt->bind_param("i", $tahun_akademik_id);
$stmt->execute();
$result_jadwal2 = $stmt->get_result();

// Membentuk matriks jadwal berdasarkan hari, jam, dan ruangan
$matriks_jadwal = [];
$ruangan_arr = [];
$jam_arr = [];
$hari_urut = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

while ($row = $result_jadwal2->fetch_assoc()) {
    $hari = $row['hari'];
    $jam_mulai = $row['jam_mulai'];
    $jam_selesai = $row['jam_selesai'];
    $ruangan = $row['nama_ruangan'];
    $matkul = $row['nama_matkul'];
    $kelas = $row['nama_kelas'];
    $dosen = $row['nama_dosen'];

    // Menyusun data ke dalam matriks berdasarkan hari, jam_mulai, dan ruangan
    if (!isset($matriks_jadwal[$hari])) {
        $matriks_jadwal[$hari] = [];
    }
    if (!isset($matriks_jadwal[$hari][$jam_mulai])) {
        $matriks_jadwal[$hari][$jam_mulai] = [];
    }
    $matriks_jadwal[$hari][$jam_mulai][$ruangan] = [
        'matkul' => $matkul,
        'kelas' => $kelas,
        'dosen' => $dosen,
        'jam_selesai' => $jam_selesai
    ];

    // Menambahkan ruangan dan jam yang terdaftar
    if (!in_array($ruangan, $ruangan_arr)) {
        $ruangan_arr[] = $ruangan;
    }
    if (!in_array($jam_mulai, $jam_arr)) {
        $jam_arr[] = $jam_mulai;
    }
}

// Urutkan jam yang terdaftar
sort($jam_arr);
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
        h1 {
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
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
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
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <center><h3>Jadwal Mata Kuliah Tahun Akademik: <?= $tahun_akademik_nama ?></h3></center>

    <!-- Tombol Export dan Print -->
    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        <button onclick="exportTableToExcel()">Export ke Excel</button>
        <button onclick="printPDF()">Cetak PDF</button>
    </div>

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
            <?php foreach ($hari_urut as $hari) { ?>
                <?php foreach ($jam_arr as $jam) { ?>
                    <tr>
                        <td><?= $hari ?></td>
                        <td><?= $jam ?></td>
                        <?php foreach ($ruangan_arr as $ruangan) {
                            echo isset($matriks_jadwal[$hari][$jam][$ruangan]) 
                                ? "<td>{$matriks_jadwal[$hari][$jam][$ruangan]['matkul']}<br>{$matriks_jadwal[$hari][$jam][$ruangan]['kelas']}<br>{$matriks_jadwal[$hari][$jam][$ruangan]['dosen']}</td>" 
                                : "<td>-</td>";
                        } ?>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    // Fungsi untuk mencetak jadwal dalam format PDF
    function printPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.html(document.getElementById('jadwalTable'), {
            callback: function (doc) {
                doc.save('jadwal_mata_kuliah.pdf');
            },
            margin: [10, 10, 10, 10]
        });
    }

    // Fungsi untuk mengekspor tabel ke Excel
    function exportTableToExcel() {
        var table = document.getElementById("jadwalTable");
        var wb = XLSX.utils.table_to_book(table, { sheet: "Jadwal" });
        XLSX.writeFile(wb, "jadwal_mata_kuliah.xlsx");
    }
</script>

</body>
</html>
