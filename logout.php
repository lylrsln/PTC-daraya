<?php
// Start session to logout user
session_start();
session_destroy(); // Hapus semua sesi
header("Location: login.html"); // Redirect ke halaman login
exit();
?>
