<?php
// Jalankan session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Konfigurasi database (VERSI DOCKER)
$host = "db";          // <-- PENTING: pakai nama service dari docker-compose
$user = "root";
$pass = "root";        // <-- sama seperti di docker-compose.yml
$db = "inv_db";      // <-- juga harus sama dengan MYSQL_DATABASE

// Koneksi ke database
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("❌ Database connection failed: " . mysqli_connect_error());
}

// Set karakter koneksi ke UTF-8
mysqli_set_charset($conn, "utf8mb4");

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>