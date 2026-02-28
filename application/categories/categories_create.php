<?php
session_start();
include '../config.php';

// Cek session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Gunakan prepared statement
    $stmt = mysqli_prepare($conn, "INSERT INTO categories (name, description) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $name, $description);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: categories_read.php?success=created");
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
  <title>Add Category</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">➕ Add New Category</h2>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm bg-white">
      <div class="mb-3">
        <label class="form-label">Category Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
      </div>

      <button type="submit" name="submit" class="btn btn-success">Save</button>
      <a href="categories_read.php" class="btn btn-secondary">Back</a>
    </form>
  </div>
</body>
</html>