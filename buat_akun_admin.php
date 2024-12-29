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

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['password_confirm']);

    // Validate that passwords match
    if ($user_password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    // SQL query to insert new user into database
    $sql = "INSERT INTO user (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$hashed_password')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New account created successfully.";
        header("Location: login.html"); // Redirect to login page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
