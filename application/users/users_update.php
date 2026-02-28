<?php
include '../config.php';

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil ID user dari URL
if (!isset($_GET['id'])) {
    header("Location: users_read.php");
    exit();
}

$id = $_GET['id'];

// Ambil data user dari database
$query = "SELECT * FROM users WHERE user_id = $id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Proses update data
if (isset($_POST['update'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $is_active = $_POST['is_active'];

    $update = "UPDATE users 
               SET full_name='$full_name', email='$email', role='$role', is_active='$is_active'
               WHERE user_id=$id";
    if (mysqli_query($conn, $update)) {
        header("Location: users_read.php?success=updated");
        exit();
    } else {
        $error = "Gagal mengupdate data!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User - Inventory Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-3">✏️ Update User</h4>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control" value="<?= $user['full_name'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="staff" <?= $user['role'] == 'staff' ? 'selected' : '' ?>>Staff</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="is_active" class="form-select">
                                <option value="1" <?= $user['is_active'] == 1 ? 'selected' : '' ?>>Aktif</option>
                                <option value="0" <?= $user['is_active'] == 0 ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                        </div>
                        <button type="submit" name="update" class="btn btn-primary w-100">Simpan Perubahan</button>
                        <a href="users_read.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
