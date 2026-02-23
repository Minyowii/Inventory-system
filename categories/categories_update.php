<?php
session_start();
include '../config.php';

// Cek session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: categories_read.php?error=invalid_id");
    exit();
}

$id = intval($_GET['id']);

// Ambil data kategori
$result = mysqli_query($conn, "SELECT * FROM categories WHERE id_category = $id");
$category = mysqli_fetch_assoc($result);

if (!$category) {
    header("Location: categories_read.php?error=category_not_found");
    exit();
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Gunakan prepared statement
    $stmt = mysqli_prepare($conn, "UPDATE categories SET name = ?, description = ? WHERE id_category = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $name, $description, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: categories_read.php?success=updated");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Category</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">✏️ Edit Category</h2>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm bg-white">
      <div class="mb-3">
        <label class="form-label">Category Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($category['description']) ?></textarea>
      </div>

      <button type="submit" name="submit" class="btn btn-warning">Update</button>
      <a href="categories_read.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</body>
</html>