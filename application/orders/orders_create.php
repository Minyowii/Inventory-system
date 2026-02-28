<?php
session_start();
include '../config.php';

// Cek session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil data supplier untuk dropdown (hanya yang valid)
$suppliers = mysqli_query($conn, "SELECT * FROM suppliers WHERE SupplierName IS NOT NULL AND SupplierName != ''");

if (isset($_POST['submit'])) {
    $SupplierID = intval($_POST['SupplierID']);
    $ItemName = mysqli_real_escape_string($conn, $_POST['ItemName']);
    $Quantity = intval($_POST['Quantity']);
    $OrderDate = $_POST['OrderDate'];
    $OrderStatus = mysqli_real_escape_string($conn, $_POST['OrderStatus']);

    // Validasi input
    if (empty($ItemName) || $Quantity <= 0 || empty($OrderDate)) {
        $error = "Please fill all fields correctly!";
    } else {
        // Gunakan prepared statement
        $stmt = mysqli_prepare($conn, "INSERT INTO orders (SupplierID, ItemName, Quantity, OrderDate, OrderStatus) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "isiss", $SupplierID, $ItemName, $Quantity, $OrderDate, $OrderStatus);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: orders_read.php?success=created");
            exit();
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Order</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">➕ Add New Order</h2>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm bg-white">
      <div class="mb-3">
        <label class="form-label">Supplier</label>
        <select name="SupplierID" class="form-select" required>
          <option value="">-- Select Supplier --</option>
          <?php while ($s = mysqli_fetch_assoc($suppliers)) { ?>
            <option value="<?= $s['SupplierID'] ?>"><?= htmlspecialchars($s['SupplierName']) ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Item Name</label>
        <input type="text" name="ItemName" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Quantity</label>
        <input type="number" name="Quantity" class="form-control" min="1" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Order Date</label>
        <input type="date" name="OrderDate" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="OrderStatus" class="form-select" required>
          <option value="Pending">Pending</option>
          <option value="Processing">Processing</option>
          <option value="Shipped">Shipped</option>
          <option value="Delivered">Delivered</option>
          <option value="Cancelled">Cancelled</option>
        </select>
      </div>

      <button type="submit" name="submit" class="btn btn-success">Save</button>
      <a href="orders_read.php" class="btn btn-secondary">Back</a>
    </form>
  </div>
</body>
</html>