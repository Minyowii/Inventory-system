<?php
session_start();
include '../config.php';

// Cek session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Validasi ItemID
if (!isset($_GET['ItemID']) || !is_numeric($_GET['ItemID'])) {
    header("Location: inventory_read.php?error=invalid_id");
    exit();
}

$ItemID = intval($_GET['ItemID']);

// Gunakan prepared statement untuk keamanan
$stmt = mysqli_prepare($conn, "DELETE FROM inventory WHERE ItemID = ?");
mysqli_stmt_bind_param($stmt, "i", $ItemID);

if (mysqli_stmt_execute($stmt)) {
    header("Location: inventory_read.php?success=deleted");
    exit();
} else {
    die("Error deleting record: " . mysqli_error($conn));
}

mysqli_stmt_close($stmt);
?>