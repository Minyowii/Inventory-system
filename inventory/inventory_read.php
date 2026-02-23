<?php
include '../config.php';

$query = "SELECT i.*, s.SupplierName, c.name as CategoryName
          FROM inventory i
          LEFT JOIN suppliers s ON i.SupplierID = s.SupplierID
          LEFT JOIN categories c ON i.category_id = c.id_category";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Inventory List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>📦 Inventory List</h2>
      <a href="inventory_create.php" class="btn btn-primary">+ Add New Item</a>
    </div>

    <table class="table table-bordered table-striped shadow-sm">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Item Name</th>
          <th>Quantity</th>
          <th>Supplier</th>
          <th>Category</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?= $row['ItemID'] ?></td>
            <td><?= htmlspecialchars($row['ItemName']) ?></td>
            <td><?= $row['Quantity'] ?></td>
            <td><?= $row['SupplierName'] ?? '—' ?></td>
            <td><?= $row['CategoryName'] ?? '—' ?></td>
            <td>
              <a href="inventory_update.php?ItemID=<?= $row['ItemID'] ?>" class="btn btn-sm btn-warning">Edit</a>
              <a href="inventory_delete.php?ItemID=<?= $row['ItemID'] ?>" class="btn btn-sm btn-danger"
                onclick="return confirm('Are you sure?')">Delete</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

</body>

</html>