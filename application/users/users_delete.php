<?php
session_start();
include '../config.php';

// Cek session dan role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Validasi input
if (!isset($_GET['user_id']) || !is_numeric($_GET['user_id'])) {
    header("Location: users_read.php?error=invalid_id");
    exit();
}

$user_id = intval($_GET['user_id']);
$current_user_id = $_SESSION['user_id'];

// Hindari user menghapus dirinya sendiri
if ($user_id == $current_user_id) {
    header("Location: users_read.php?error=self_delete");
    exit();
}

// Gunakan prepared statement
$stmt = mysqli_prepare($conn, "DELETE FROM users WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: users_read.php?success=deleted");
} else {
    header("Location: users_read.php?error=delete_failed");
}

mysqli_stmt_close($stmt);
exit();
?>