<?php
session_start();
include '../config.php';

// Cek session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil semua data order dengan join supplier
$query = "SELECT o.*, s.SupplierName 
          FROM orders o 
          LEFT JOIN suppliers s ON o.SupplierID = s.SupplierID AND s.SupplierName IS NOT NULL";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

// Pesan sukses/error
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Orders List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>📋 Orders List</h2>
      <a href="orders_create.php" class="btn btn-primary">+ Add New Order</a>
    </div>

    <!-- Notifikasi -->
    <?php if ($success): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <?php
        $messages = [
            'created' => 'Order created successfully!',
            'updated' => 'Order updated successfully!', 
            'deleted' => 'Order deleted successfully!'
        ];
        echo $messages[$success] ?? 'Operation completed successfully!';
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <?php
        $messages = [
            'invalid_id' => 'Invalid order ID!',
            'delete_failed' => 'Failed to delete order!'
        ];
        echo $messages[$error] ?? 'An error occurred!';
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <div class="card shadow-sm">
      <div class="card-body">
        <table class="table table-bordered table-striped">
          <thead class="table-dark">
            <tr>
              <th>OrderID</th>
              <th>Supplier</th>
              <th>Item Name</th>
              <th>Quantity</th>
              <th>Order Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
              <tr>
                <td><?= $row['OrderID'] ?></td>
                <td><?= htmlspecialchars($row['SupplierName'] ?? '—') ?></td>
                <td><?= htmlspecialchars($row['ItemName']) ?></td>
                <td><?= $row['Quantity'] ?></td>
                <td><?= $row['OrderDate'] ?></td>
                <td>
                  <span class="badge bg-<?= 
                    $row['OrderStatus'] == 'Delivered' ? 'success' : 
                    ($row['OrderStatus'] == 'Cancelled' ? 'danger' : 
                    ($row['OrderStatus'] == 'Processing' ? 'warning' : 'info')) 
                  ?>">
                    <?= $row['OrderStatus'] ?>
                  </span>
                </td>
                <td>
                  <a href="orders_update.php?OrderID=<?= $row['OrderID'] ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="orders_delete.php?OrderID=<?= $row['OrderID'] ?>" 
                     class="btn btn-sm btn-danger"
                     onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>