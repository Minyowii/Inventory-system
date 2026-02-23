<?php
session_start();
include 'config.php';

// Cek apakah sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data user dari session
$username = $_SESSION['username'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Ambil data statistik
$total_categories = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM categories"))['total'];
$total_suppliers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM suppliers WHERE SupplierName IS NOT NULL AND SupplierName != ''"))['total'];
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE is_active = 1"))['total'];

// Ambil low stock items (quantity < 10)
$low_stock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM inventory WHERE Quantity < 10"))['total'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>

<body class="bg-light">
    <div class="container mt-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>Welcome, <?= htmlspecialchars($username) ?> 👋</h2>
                <span class="badge bg-secondary text-capitalize"><?= htmlspecialchars($role) ?></span>
            </div>
            <div>
                <a href="logout.php" class="btn btn-outline-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>

        <!-- Statistik -->
        <div class="row mb-4">
            <div class="col-md-2 mb-3">
                <div class="card text-center border-primary shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-box-seam fs-1 text-primary"></i>
                        <h5 class="mt-2">Inventory</h5>
                        <h3><?= $total_inventory ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="card text-center border-success shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-tags fs-1 text-success"></i>
                        <h5 class="mt-2">Categories</h5>
                        <h3><?= $total_categories ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="card text-center border-warning shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-truck fs-1 text-warning"></i>
                        <h5 class="mt-2">Suppliers</h5>
                        <h3><?= $total_suppliers ?></h3>
                    </div>
                </div>
            </div>

            <?php if ($role === 'admin'): ?>
                <div class="col-md-2 mb-3">
                    <div class="card text-center border-info shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-people fs-1 text-info"></i>
                            <h5 class="mt-2">Users</h5>
                            <h3><?= $total_users ?></h3>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-md-2 mb-3">
                <div class="card text-center border-danger shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
                        <h5 class="mt-2">Low Stock</h5>
                        <h3><?= $low_stock ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Navigasi -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Quick Navigation</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="inventory/inventory_read.php" class="btn btn-outline-primary w-100 h-100 py-3">
                                    <i class="bi bi-box-seam fs-2 d-block mb-2"></i>
                                    Manage Inventory
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a href="categories/categories_read.php"
                                    class="btn btn-outline-success w-100 h-100 py-3">
                                    <i class="bi bi-tags fs-2 d-block mb-2"></i>
                                    Manage Categories
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a href="suppliers/suppliers_read.php" class="btn btn-outline-warning w-100 h-100 py-3">
                                    <i class="bi bi-truck fs-2 d-block mb-2"></i>
                                    Manage Suppliers
                                </a>
                            </div>

                            <?php if ($role === 'admin'): ?>
                                <div class="col-md-3">
                                    <a href="users/users_read.php" class="btn btn-outline-info w-100 h-100 py-3">
                                        <i class="bi bi-people fs-2 d-block mb-2"></i>
                                        Manage Users
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>