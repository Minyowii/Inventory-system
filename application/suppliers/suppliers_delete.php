<?php
session_start();
include '../config.php';

// Cek session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: suppliers_read.php?error=invalid_id");
    exit();
}

$id = intval($_GET['id']);

// Cek jika supplier digunakan di inventory
$check = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM inventory WHERE SupplierID = $id"))['total'];

if ($check > 0) {
    header("Location: suppliers_read.php?error=supplier_used");
    exit();
}

// Gunakan prepared statement
$stmt = mysqli_prepare($conn, "DELETE FROM suppliers WHERE SupplierID = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: suppliers_read.php?success=deleted");
} else {
    header("Location: suppliers_read.php?error=delete_failed");
}

mysqli_stmt_close($stmt);
exit();
?>