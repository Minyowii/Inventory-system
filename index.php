<?php
// Jalankan session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika user sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Jika belum login, redirect ke login
header("Location: login.php");
exit();
?>