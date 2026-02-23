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

// Ambil data order
$result = mysqli_query($conn, "SELECT * FROM orders WHERE OrderID = $OrderID");
$order = mysqli_fetch_assoc($result);

if (!$order) {
    header("Location: orders_read.php?error=order_not_found");
    exit();
}

$suppliers = mysqli_query($conn, "SELECT * FROM suppliers WHERE SupplierName IS NOT NULL AND SupplierName != ''");

if (isset($_POST['submit'])) {
    $SupplierID = intval($_POST['SupplierID']);
    $ItemName = mysqli_real_escape_string($conn, $_POST['ItemName']);
    $Quantity = intval($_POST['Quantity']);
    $OrderDate = $_POST['OrderDate'];
    $OrderStatus = mysqli_real_escape_string($conn, $_POST['OrderStatus']);

    // Gunakan prepared statement untuk update
    $stmt = mysqli_prepare($conn, "UPDATE orders SET SupplierID = ?, ItemName = ?, Quantity = ?, OrderDate = ?, OrderStatus = ? WHERE OrderID = ?");
    mysqli_stmt_bind_param($stmt, "isissi", $SupplierID, $ItemName, $Quantity, $OrderDate, $OrderStatus, $OrderID);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: orders_read.php?success=updated");
        exit();
    } else {
        $error = "Error updating order: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Order</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">✏️ Edit Order</h2>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm bg-white">
      <div class="mb-3">
        <label class="form-label">Supplier</label>
        <select name="SupplierID" class="form-select" required>
          <?php 
          mysqli_data_seek($suppliers, 0);
          while ($s = mysqli_fetch_assoc($suppliers)) { ?>
            <option value="<?= $s['SupplierID'] ?>" <?= $s['SupplierID'] == $order['SupplierID'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($s['SupplierName']) ?>
            </option>
          <?php } ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Item Name</label>
        <input type="text" name="ItemName" value="<?= htmlspecialchars($order['ItemName']) ?>" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Quantity</label>
        <input type="number" name="Quantity" value="<?= $order['Quantity'] ?>" class="form-control" min="1" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Order Date</label>
        <input type="date" name="OrderDate" value="<?= $order['OrderDate'] ?>" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Order Status</label>
        <select name="OrderStatus" class="form-select" required>
          <option value="Pending" <?= $order['OrderStatus'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
          <option value="Processing" <?= $order['OrderStatus'] == 'Processing' ? 'selected' : '' ?>>Processing</option>
          <option value="Shipped" <?= $order['OrderStatus'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
          <option value="Delivered" <?= $order['OrderStatus'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
          <option value="Cancelled" <?= $order['OrderStatus'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>
      </div>

      <button type="submit" name="submit" class="btn btn-warning">Update</button>
      <a href="orders_read.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</body>
</html>