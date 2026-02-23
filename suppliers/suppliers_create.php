<?php
session_start();
include '../config.php';

// Cek session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $SupplierName = mysqli_real_escape_string($conn, $_POST['SupplierName']);
    $ContactPerson = mysqli_real_escape_string($conn, $_POST['ContactPerson']);
    $Phone = mysqli_real_escape_string($conn, $_POST['Phone']);
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $Address = mysqli_real_escape_string($conn, $_POST['Address']);

    // Gunakan prepared statement
    $stmt = mysqli_prepare($conn, "INSERT INTO suppliers (SupplierName, ContactPerson, Phone, Email, Address) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssss", $SupplierName, $ContactPerson, $Phone, $Email, $Address);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: suppliers_read.php?success=created");
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
  <title>Add Supplier</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">➕ Add New Supplier</h2>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm bg-white">
      <div class="mb-3">
        <label class="form-label">Supplier Name</label>
        <input type="text" name="SupplierName" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Contact Person</label>
        <input type="text" name="ContactPerson" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="Phone" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="Email" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">Address</label>
        <textarea name="Address" class="form-control" rows="3"></textarea>
      </div>

      <button type="submit" name="submit" class="btn btn-success">Save</button>
      <a href="suppliers_read.php" class="btn btn-secondary">Back</a>
    </form>
  </div>
</body>
</html>