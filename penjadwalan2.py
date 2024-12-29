from flask import Flask, jsonify, request
import pandas as pd
import random
import mysql.connector
from sqlalchemy import create_engine, text
import time
from datetime import timedelta

app = Flask(__name__)

# Fungsi untuk menghubungkan ke database MySQL dengan SQLAlchemy
def connect_db():
    try:
        engine = create_engine('mysql+mysqlconnector://root:@localhost/penjadwalan2')
        print("Connected to the database successfully!")
        return engine
    except Exception as e:
        print(f"Error connecting to MySQL: {e}")
        exit()

# Fungsi untuk menghubungkan ke database dengan mysql.connector
def get_db_connection():
    connection = mysql.connector.connect(
        host='localhost',
        user='root',
        password='',
        database='penjadwalan2'
    )
    return connection

# Fungsi untuk memuat data dari database
def load_data_from_db(tahun_akademik_id):
    try:
        engine = connect_db()

        # Query data utama
        query = '''
        SELECT dm.*, d.nama_dosen, m.nama_matkul, k.nama_kelas, p.nama_prodi, p.jurusan, ta.tahun_akademik_nama
        FROM dosen_mk dm
        JOIN dosen d ON dm.dosen_id = d.dosen_id
        JOIN matakuliah m ON dm.matkul_id = m.matkul_id
        JOIN kelas k ON dm.kelas_id = k.kelas_id
        JOIN prodi p ON dm.prodi_id = p.prodi_id
        JOIN tahun_akademik ta ON dm.tahun_akademik_id = ta.tahun_akademik_id
        WHERE dm.tahun_akademik_id = %s
        '''
        dosen_mk = pd.read_sql_query(query, engine, params=(tahun_akademik_id,))
        waktu = pd.read_sql_query('SELECT * FROM waktu', engine)
        ruangan = pd.read_sql_query('SELECT * FROM ruangan', engine)

        # Validasi tipe data
        if not isinstance(waktu, pd.DataFrame) or not isinstance(ruangan, pd.DataFrame):
            raise ValueError("'waktu' and 'ruangan' must be pandas DataFrames")

        return dosen_mk, waktu, ruangan
    except Exception as e:
        print(f"Error loading data from database: {e}")
        raise

def initialize_population(dosen_mk, waktu, ruangan, population_size=100):
    population = []

    for _ in range(population_size):
        individual = []
        for _, row in dosen_mk.iterrows():
            # Ensure 'waktu' and 'ruangan' are DataFrames
            if isinstance(waktu, pd.DataFrame) and isinstance(ruangan, pd.DataFrame):
                # Sample a random 'waktu' row from the DataFrame
                waktu_sample = waktu.sample(1).iloc[0].to_dict()  # Random row from 'waktu' DataFrame
                # Sample a random 'ruangan' row from the DataFrame
                ruangan_sample = ruangan.sample(1).iloc[0].to_dict()  # Random row from 'ruangan' DataFrame

                individual.append({
                    'dosen_id': row['dosen_id'],
                    'matkul_id': row['matkul_id'],
                    'kelas_id': row['kelas_id'],
                    'prodi_id': row['prodi_id'],
                    'tahun_akademik_id': row['tahun_akademik_id'],
                    'waktu': {
                        'waktu_id': waktu_sample['waktu_id'],
                        'hari': waktu_sample['hari'],  # Or any other attributes you need
                        'jam_mulai': waktu_sample['jam_mulai'],
                        'jam_selesai': waktu_sample['jam_selesai']
                    },
                    'ruangan': {
                        'ruangan_id': ruangan_sample['ruangan_id'],
                        'nama_ruangan': ruangan_sample['nama_ruangan']  # Or any other attributes you need
                    },
                })
            else:
                raise TypeError("'waktu' and 'ruangan' should be pandas DataFrame objects.")
        population.append(individual)

    return population

# Fungsi untuk menghitung fitness (menghindari bentrok)
def calculate_fitness(individual):
    conflicts = 0
    schedule = []

    for entry in individual:
        waktu = entry['waktu']
        ruangan = entry['ruangan']

        for s in schedule:
            if (s['waktu']['waktu_id'] == waktu['waktu_id'] and 
                (s['ruangan']['ruangan_id'] == ruangan['ruangan_id'])):
                conflicts += 1
        schedule.append({
            'waktu': waktu,
            'ruangan': ruangan,
        })

    return 1 / (1 + conflicts)  # Nilai fitness semakin tinggi jika konflik semakin sedikit

# Fungsi seleksi berdasarkan fitness
def selection(population):
    population = sorted(population, key=lambda ind: calculate_fitness(ind), reverse=True)
    return population[:len(population)//2]  # Ambil separuh terbaik

# Fungsi crossover untuk menghasilkan keturunan baru
def crossover(parent1, parent2):
    point = random.randint(0, len(parent1) - 1)
    child1 = parent1[:point] + parent2[point:]
    child2 = parent2[:point] + parent1[point:]
    return child1, child2

def mutate(individual, waktu, ruangan, mutation_rate=0.1):
    if not isinstance(waktu, pd.DataFrame) or not isinstance(ruangan, pd.DataFrame):
        raise TypeError("Expected 'waktu' and 'ruangan' to be pandas DataFrame objects.")
    
    for entry in individual:
        # Mutate the 'waktu' field
        if random.random() < mutation_rate:
            new_waktu = waktu.sample(1).iloc[0].to_dict()  # Sampling from DataFrame
            entry['waktu'] = new_waktu

        # Mutate the 'ruangan' field
        if random.random() < mutation_rate:
            new_ruangan = ruangan.sample(1).iloc[0].to_dict()  # Sampling from DataFrame
            entry['ruangan'] = new_ruangan

# Algoritma genetika utama
def genetic_algorithm(dosen_mk, waktu, ruangan, generations=100, population_size=100):
    population = initialize_population(dosen_mk, waktu, ruangan, population_size)
    total_fitness = 0  # Variabel untuk menjumlahkan total fitness

    start_time = time.time()  # Mulai timer untuk algoritma genetika

    for generation in range(generations):
        population = selection(population)
        next_generation = []
        while len(next_generation) < population_size:
            parent1, parent2 = random.sample(population, 2)
            child1, child2 = crossover(parent1, parent2)
            next_generation.extend([child1, child2])

        for individual in next_generation:
            mutate(individual, waktu, ruangan)

        population = next_generation
        best_fitness = max(calculate_fitness(ind) for ind in population)
        total_fitness += best_fitness  # Menambahkan fitness terbaik dari generasi ini ke total fitness
        print(f'Generation {generation + 1}: Best Fitness = {best_fitness}')

    end_time = time.time()  # Waktu selesai

    best_individual = max(population, key=lambda ind: calculate_fitness(ind))
    
    duration = end_time - start_time  # Durasi waktu yang dibutuhkan
    print(f"Total Processing Time: {duration:.2f} seconds")
    print(f"Total Fitness across generations: {total_fitness:.2f}")

    return best_individual, total_fitness, duration

def save_schedule_to_db(schedule, engine):
    data_to_insert = []
    used_combinations = set()  # To keep track of already used time-room combinations

    # Load already used combinations from the database to avoid conflicts
    with engine.connect() as conn:
        query_check_used_combinations = text('SELECT ruangan_id, waktu_id FROM jadwal2')
        result = conn.execute(query_check_used_combinations).fetchall()

        # Menyimpan kombinasi yang sudah ada dalam set
        for row in result:
            used_combinations.add((row[0], row[1]))  # row[0] = ruangan_id, row[1] = waktu_id

    # Retrieve all available ruangan and waktu from the database
    with engine.connect() as conn:
        query_ruangan = text('SELECT ruangan_id FROM ruangan')
        query_waktu = text('SELECT waktu_id FROM waktu')

        ruangan_list = [row[0] for row in conn.execute(query_ruangan).fetchall()]
        waktu_list = [row[0] for row in conn.execute(query_waktu).fetchall()]

    # Jika daftar ruangan atau waktu kosong, beri peringatan dan hentikan
    if not ruangan_list or not waktu_list:
        print("Error: ruangan_list atau waktu_list kosong. Pastikan data tersedia di database.")
        return

    for entry in schedule:
        try:
            # Validate 'waktu' and 'ruangan' exist
            if 'waktu' not in entry or 'ruangan' not in entry:
                print(f"Skipping entry due to missing 'waktu' or 'ruangan' keys: {entry}")
                continue

            waktu = entry['waktu']
            ruangan = entry['ruangan']

            # Ensure 'waktu_id' and 'ruangan_id' exist in their respective dictionaries
            if 'waktu_id' not in waktu or 'ruangan_id' not in ruangan:
                print(f"Skipping entry due to missing 'waktu_id' or 'ruangan_id': {entry}")
                continue

            original_ruangan_id = ruangan['ruangan_id']
            original_waktu_id = waktu['waktu_id']

            # Check for conflicts and resolve
            if (original_ruangan_id, original_waktu_id) in used_combinations:
                print(f"Conflict found: ruangan_id = {original_ruangan_id} and waktu_id = {original_waktu_id} already exists.")
                
                new_combination_found = False
                for _ in range(len(ruangan_list) * len(waktu_list)):  # Max attempts based on total combinations
                    new_ruangan_id = random.choice(ruangan_list)
                    new_waktu_id = random.choice(waktu_list)
                    
                    if (new_ruangan_id, new_waktu_id) not in used_combinations:
                        # Set new valid combination
                        entry['waktu']['waktu_id'] = new_waktu_id
                        entry['ruangan']['ruangan_id'] = new_ruangan_id
                        used_combinations.add((new_ruangan_id, new_waktu_id))
                        print(f"Conflict resolved. New combination: ruangan_id = {new_ruangan_id}, waktu_id = {new_waktu_id}")
                        new_combination_found = True
                        break

                if not new_combination_found:
                    print(f"Unable to resolve conflict for entry: {entry}, skipping entry.")
                    continue  # Skip this entry if no valid combination found

            # Add the current (or newly found) combination to the used set
            used_combinations.add((entry['ruangan']['ruangan_id'], entry['waktu']['waktu_id']))

            # Prepare data for insertion
            data_to_insert.append({
                'dosen_id': entry['dosen_id'],
                'matkul_id': entry['matkul_id'],
                'kelas_id': entry['kelas_id'],
                'prodi_id': entry['prodi_id'],
                'tahun_akademik_id': entry['tahun_akademik_id'],
                'ruangan_id': entry['ruangan']['ruangan_id'],
                'waktu_id': entry['waktu']['waktu_id']
            })

        except Exception as e:
            print(f"Error processing entry: {entry}, Error: {e}")

    # Insert new schedules into the database if there are no conflicts
    if data_to_insert:
        try:
            with engine.connect() as conn:
                insert_query = text(''' 
                    INSERT INTO jadwal2 (dosen_id, matkul_id, kelas_id, prodi_id, tahun_akademik_id, ruangan_id, waktu_id)
                    VALUES (:dosen_id, :matkul_id, :kelas_id, :prodi_id, :tahun_akademik_id, :ruangan_id, :waktu_id)
                ''')
                
                # Execute the insertion
                conn.execute(insert_query, data_to_insert)
                conn.commit()  # Commit the transaction to save the data
                print("Schedules successfully inserted into the database.")
        except Exception as e:
            print(f"Error inserting data into jadwal2: {e}")
    else:
        print("No valid schedules to insert.")

# Helper function to convert Timedelta to string
def timedelta_to_str(td):
    if isinstance(td, timedelta):
        return str(td)
    return td  # Return the value as is if it's not a Timedelta

# Convert all values in the schedule that are Timedelta objects
def convert_schedule_to_serializable(schedule):
    for entry in schedule:
        for key, value in entry.items():
            if isinstance(value, dict):
                for sub_key, sub_value in value.items():
                    entry[key][sub_key] = timedelta_to_str(sub_value)
            else:
                entry[key] = timedelta_to_str(value)
    return schedule


# Fungsi utama untuk menangani request
@app.route('/penjadwalan2', methods=['GET'])
def generate_schedule():
    try:
        # Ambil parameter tahun_akademik_id
        tahun_akademik_id = request.args.get('tahun_akademik_id', type=int)
        if not tahun_akademik_id:
            return jsonify({"error": "tahun_akademik_id is required and must be a valid integer"}), 400

        # Load data dari database
        dosen_mk, waktu, ruangan = load_data_from_db(tahun_akademik_id)

        # Jalankan algoritma genetika
        best_schedule, total_fitness, duration = genetic_algorithm(dosen_mk, waktu, ruangan)

        # Konversi schedule ke format serializable
        best_schedule = convert_schedule_to_serializable(best_schedule)

        # Simpan ke database
        save_schedule_to_db(best_schedule, connect_db())

        return jsonify({
            "best_schedule": best_schedule,
            "total_fitness": total_fitness,
            "processing_time_seconds": duration
        })

    except Exception as e:
        print(f"Error in generate_schedule endpoint: {e}")
        return jsonify({"error": str(e)}), 400

if __name__ == '__main__':
    app.run(debug=True)