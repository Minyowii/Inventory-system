<?php
session_start();
include '../config.php';

// Cek session dan role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$error = '';

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    // Validasi input
    if (empty($username) || empty($password) || empty($email) || empty($full_name)) {
        $error = "All fields are required!";
    } else {
        // Cek jika username sudah ada
        $check_query = "SELECT user_id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "Username already exists!";
        } else {
            mysqli_stmt_close($stmt);
            
            // Hash password yang aman
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Gunakan prepared statement
            $query = "INSERT INTO users (username, password, email, full_name, role, is_active) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "sssssi", $username, $hashed_password, $email, $full_name, $role, $is_active);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: users_read.php?success=created");
                exit();
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-4">
    <h2 class="mb-4">➕ Add New User</h2>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm bg-white">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required maxlength="50">
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required minlength="6">
        <div class="form-text">Minimum 6 characters</div>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="full_name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-select" required>
          <option value="staff">Staff</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <div class="mb-3 form-check">
        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" checked>
        <label class="form-check-label" for="is_active">Active User</label>
      </div>

      <button type="submit" name="submit" class="btn btn-success">Save User</button>
      <a href="users_read.php" class="btn btn-secondary">Back to Users</a>
    </form>
  </div>
</body>
</html>