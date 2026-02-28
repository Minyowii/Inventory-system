<?php
session_start();
include '../config.php';

// Cek session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Hanya ambil suppliers yang valid
$result = mysqli_query($conn, "SELECT * FROM suppliers WHERE SupplierName IS NOT NULL AND SupplierName != ''");

// Pesan sukses/error
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Suppliers List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>🚚 Suppliers List</h2>
      <a href="suppliers_create.php" class="btn btn-primary">+ Add New Supplier</a>
    </div>

    <!-- Notifikasi -->
    <?php if ($success): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <?php
        $messages = [
            'created' => 'Supplier created successfully!',
            'updated' => 'Supplier updated successfully!', 
            'deleted' => 'Supplier deleted successfully!'
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
            'invalid_id' => 'Invalid supplier ID!',
            'delete_failed' => 'Failed to delete supplier!',
            'supplier_used' => 'Cannot delete supplier - it is being used in inventory!'
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
              <th>ID</th>
              <th>Supplier Name</th>
              <th>Contact Person</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?= $row['SupplierID'] ?></td>
              <td><?= htmlspecialchars($row['SupplierName']) ?></td>
              <td><?= htmlspecialchars($row['ContactPerson'] ?? '—') ?></td>
              <td><?= htmlspecialchars($row['Phone'] ?? '—') ?></td>
              <td><?= htmlspecialchars($row['Email'] ?? '—') ?></td>
              <td>
                <a href="suppliers_update.php?id=<?= $row['SupplierID'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="suppliers_delete.php?id=<?= $row['SupplierID'] ?>" class="btn btn-sm btn-danger"
                  onclick="return confirm('Are you sure you want to delete <?= htmlspecialchars($row['SupplierName']) ?>?')">Delete</a>
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