<?php
session_start();
include '../config.php';

// Cek session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Validasi OrderID
if (!isset($_GET['OrderID']) || !is_numeric($_GET['OrderID'])) {
    header("Location: orders_read.php?error=invalid_id");
    exit();
}

$OrderID = intval($_GET['OrderID']);

// Gunakan prepared statement
$stmt = mysqli_prepare($conn, "DELETE FROM orders WHERE OrderID = ?");
mysqli_stmt_bind_param($stmt, "i", $OrderID);

if (mysqli_stmt_execute($stmt)) {
    header("Location: orders_read.php?success=deleted");
    exit();
} else {
    header("Location: orders_read.php?error=delete_failed");
}

mysqli_stmt_close($stmt);
?>