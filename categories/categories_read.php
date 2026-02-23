<?php
session_start();
include '../config.php';

// Cek session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM categories");

// Pesan sukses/error
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Categories List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>📁 Categories List</h2>
      <a href="categories_create.php" class="btn btn-primary">+ Add New Category</a>
    </div>

    <!-- Notifikasi -->
    <?php if ($success): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <?php
        $messages = [
            'created' => 'Category created successfully!',
            'updated' => 'Category updated successfully!', 
            'deleted' => 'Category deleted successfully!'
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
            'invalid_id' => 'Invalid category ID!',
            'delete_failed' => 'Failed to delete category!',
            'category_used' => 'Cannot delete category - it is being used in inventory!'
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
              <th>Name</th>
              <th>Description</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?= $row['id_category'] ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['description']) ?></td>
              <td>
                <a href="categories_update.php?id=<?= $row['id_category'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="categories_delete.php?id=<?= $row['id_category'] ?>" class="btn btn-sm btn-danger"
                  onclick="return confirm('Are you sure you want to delete <?= htmlspecialchars($row['name']) ?>?')">Delete</a>
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