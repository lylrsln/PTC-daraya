from flask import Flask, jsonify, request
import mysql.connector
from datetime import datetime, timedelta

app = Flask(__name__)

# Fungsi untuk menghubungkan ke database
def get_db_connection():
    connection = mysql.connector.connect(
        host='localhost',
        user='root',
        password='',
        database='penjadwalan2'
    )
    return connection

# Fungsi untuk mengubah objek datetime menjadi string
def datetime_converter(o):
    if isinstance(o, datetime):
        return o.strftime('%Y-%m-%d %H:%M:%S')  # Format string yang sesuai

# Helper function untuk mengubah timedelta menjadi string (HH:MM:SS)
def timedelta_to_str(td):
    if isinstance(td, timedelta):
        total_seconds = int(td.total_seconds())  # Total seconds
        hours = total_seconds // 3600
        minutes = (total_seconds % 3600) // 60
        seconds = total_seconds % 60
        return f"{hours:02}:{minutes:02}:{seconds:02}"
    return str(td)  # Jika bukan timedelta, kembalikan sebagai string biasa

# Fungsi untuk mengonversi objek time menjadi format string (jam:menit:detik)
def time_to_str(t):
    if isinstance(t, datetime):
        return t.strftime('%H:%M:%S')  # Untuk datetime
    elif isinstance(t, timedelta):
        return timedelta_to_str(t)  # Untuk timedelta
    elif isinstance(t, str):  # Untuk tipe data string
        return t
    return str(t)

# Route untuk mengambil data jadwal berdasarkan tahun akademik
@app.route('/penjadwalan2', methods=['GET'])
def penjadwalan():
    tahun_akademik_id = request.args.get('tahun_akademik_id', type=int)

    if not tahun_akademik_id:
        return jsonify({"error": "tahun_akademik_id is required and must be a valid integer"}), 400

    try:
        tahun_akademik_id = int(tahun_akademik_id)
    except ValueError:
        return jsonify({"error": "tahun_akademik_id must be a valid integer"}), 400

    # Mengambil data dari database
    connection = get_db_connection()
    cursor = connection.cursor(dictionary=True)

    # Query SQL untuk mengambil data jadwal
    query = """
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
    WHERE dm.tahun_akademik_id = %s
    """

    cursor.execute(query, (tahun_akademik_id,))
    jadwal = cursor.fetchall()

    cursor.close()
    connection.close()

    # Jika tidak ada jadwal, kembalikan error
    if not jadwal:
        return jsonify({"error": "Jadwal tidak ditemukan untuk tahun akademik ini"}), 404

    # Menyiapkan data yang akan dikirimkan dalam respons JSON
    jadwal_response = {}
    
    for row in jadwal:
        hari = row['hari']
        
        if hari not in jadwal_response:
            jadwal_response[hari] = []
        
        # Menyiapkan data dalam format yang sesuai
        jadwal_item = {
            "dosen_id": row['dosen_id'],
            "kelas": {
                "kelas_id": row['kelas_id'],
                "kode_kelas": row['nama_kelas'],
                "nama_kelas": row['nama_kelas'],
                "prodi_id": row['prodi_id'],
            },
            "matkul_id": row['matkul_id'],
            "prodi_id": row['prodi_id'],
            "ruangan": {
                "ruangan_id": row['ruangan_id'],
                "nama_ruangan": row['nama_ruangan'],
                "kode_ruangan": row['nama_ruangan'],
                "kapasitas": 40,  # Kapasitas bisa disesuaikan
                "lokasi": "Kampus 2 Gedung Pemuda",  # Lokasi ruangan
            },
            "tahun_akademik_id": row['tahun_akademik_id'],
            "waktu": {
                "waktu_id": row['waktu_id'],
                "jam_mulai": time_to_str(row['jam_mulai']),  # Mengonversi waktu mulai
                "jam_selesai": time_to_str(row['jam_selesai']),  # Mengonversi waktu selesai
            }
        }
        
        # Menambahkan item jadwal ke hari yang sesuai
        jadwal_response[hari].append(jadwal_item)

    return jsonify(jadwal_response)

if __name__ == '__main__':
    app.run(debug=True)
