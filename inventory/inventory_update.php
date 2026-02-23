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

// Ambil data item dengan prepared statement
$stmt = mysqli_prepare($conn, "SELECT * FROM inventory WHERE ItemID = ?");
mysqli_stmt_bind_param($stmt, "i", $ItemID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$item = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$item) {
    header("Location: inventory_read.php?error=item_not_found");
    exit();
}

$suppliers = mysqli_query($conn, "SELECT * FROM suppliers WHERE SupplierName IS NOT NULL AND SupplierName != ''");
$categories = mysqli_query($conn, "SELECT * FROM categories");

if (isset($_POST['submit'])) {
    $ItemName = mysqli_real_escape_string($conn, $_POST['ItemName']);
    $Quantity = intval($_POST['Quantity']);
    $SupplierID = intval($_POST['SupplierID']);
    $category_id = intval($_POST['category_id']);

    // Gunakan prepared statement untuk update
    $stmt = mysqli_prepare($conn, "UPDATE inventory SET ItemName = ?, Quantity = ?, SupplierID = ?, category_id = ? WHERE ItemID = ?");
    mysqli_stmt_bind_param($stmt, "siiii", $ItemName, $Quantity, $SupplierID, $category_id, $ItemID);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: inventory_read.php?success=updated");
        exit();
    } else {
        $error = "Error updating record: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Inventory</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4">✏️ Edit Inventory Item</h2>

  <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" class="card p-4 shadow-sm bg-white">
    <div class="mb-3">
      <label class="form-label">Item Name</label>
      <input type="text" name="ItemName" value="<?= htmlspecialchars($item['ItemName']) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Quantity</label>
      <input type="number" name="Quantity" value="<?= $item['Quantity'] ?>" class="form-control" min="0" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Supplier</label>
      <select name="SupplierID" class="form-select" required>
        <?php 
        mysqli_data_seek($suppliers, 0);
        while ($s = mysqli_fetch_assoc($suppliers)) { ?>
          <option value="<?= $s['SupplierID'] ?>" <?= $s['SupplierID'] == $item['SupplierID'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($s['SupplierName']) ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Category</label>
      <select name="category_id" class="form-select" required>
        <?php 
        mysqli_data_seek($categories, 0);
        while ($c = mysqli_fetch_assoc($categories)) { ?>
          <option value="<?= $c['id_category'] ?>" <?= $c['id_category'] == $item['category_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['name']) ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <button type="submit" name="submit" class="btn btn-warning">Update</button>
    <a href="inventory_read.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>