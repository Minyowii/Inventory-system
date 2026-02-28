<?php
session_start();
include '../config.php';

// Cek session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Query suppliers yang valid saja
$suppliers = mysqli_query($conn, "SELECT * FROM suppliers WHERE SupplierName IS NOT NULL AND SupplierName != ''");
$categories = mysqli_query($conn, "SELECT * FROM categories");

if (isset($_POST['submit'])) {
    $ItemName = mysqli_real_escape_string($conn, $_POST['ItemName']);
    $Quantity = intval($_POST['Quantity']);
    $SupplierID = intval($_POST['SupplierID']);
    $category_id = intval($_POST['category_id']);

    // Validasi
    if (empty($ItemName) || $Quantity < 0) {
        $error = "Please fill all fields correctly!";
    } else {
        // Gunakan prepared statement
        $query = "INSERT INTO inventory (ItemName, Quantity, SupplierID, category_id) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "siii", $ItemName, $Quantity, $SupplierID, $category_id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: inventory_read.php?success=created");
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
  <title>Add Inventory Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">➕ Add New Inventory Item</h2>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm bg-white">
      <div class="mb-3">
        <label class="form-label">Item Name</label>
        <input type="text" name="ItemName" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Quantity</label>
        <input type="number" name="Quantity" class="form-control" value="0" min="0" required>
      </div>

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
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select" required>
          <option value="">-- Select Category --</option>
          <?php while ($c = mysqli_fetch_assoc($categories)) { ?>
            <option value="<?= $c['id_category'] ?>"><?= htmlspecialchars($c['name']) ?></option>
          <?php } ?>
        </select>
      </div>

      <button type="submit" name="submit" class="btn btn-success">Save</button>
      <a href="inventory_read.php" class="btn btn-secondary">Back</a>
    </form>
  </div>
</body>
</html>