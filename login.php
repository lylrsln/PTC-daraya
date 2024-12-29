<?php
// Database connection
$servername = "localhost";
$username = "root";  // Ganti dengan username database Anda
$password = "";      // Ganti dengan password database Anda
$dbname = "penjadwalan2"; // Ganti dengan nama database Anda

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start the session
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input
    $user_email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_password = mysqli_real_escape_string($conn, $_POST['password']);

    // Prepare SQL query to check if user exists
    $stmt = $conn->prepare("SELECT id, email, password FROM user WHERE email = ?");
    $stmt->bind_param("s", $user_email);  // Bind email parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika pengguna ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifikasi password yang di-hash
        if (password_verify($user_password, $row['password'])) {
            // Password valid, simpan session
            $_SESSION['user_id'] = $row['id']; // Simpan ID pengguna di session
            $_SESSION['email'] = $user_email;  // Simpan email di session

            // Redirect ke halaman dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Password tidak cocok
            echo "Invalid email or password.";
        }
    } else {
        // Pengguna tidak ditemukan
        echo "Invalid email or password.";
    }

    // Close the statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
