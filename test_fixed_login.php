<?php
include 'config.php';

echo "<h3>🧪 Testing Fixed Login System</h3>";

$test_accounts = [
    ['admin', 'admin123'],
    ['staff1', 'staff123'],
    ['admin2', 'admin123']
];

foreach ($test_accounts as $account) {
    $username = $account[0];
    $password = $account[1];
    
    $query = "SELECT * FROM users WHERE username = ? AND is_active = 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    
    if ($user) {
        if (password_verify($password, $user['password'])) {
            echo "✅ <b>$username</b>: Login SUCCESS (Role: {$user['role']})<br>";
        } else {
            echo "❌ <b>$username</b>: Password FAILED<br>";
        }
    } else {
        echo "❌ <b>$username</b>: User not found or inactive<br>";
    }
    mysqli_stmt_close($stmt);
}

echo "<hr><h4>Available Suppliers for Dropdown:</h4>";
$suppliers = mysqli_query($conn, "SELECT SupplierID, SupplierName FROM suppliers WHERE SupplierName IS NOT NULL AND SupplierName != ''");
while ($s = mysqli_fetch_assoc($suppliers)) {
    echo "SupplierID: {$s['SupplierID']} - {$s['SupplierName']}<br>";
}

echo "<h4>Available Categories for Dropdown:</h4>";
$categories = mysqli_query($conn, "SELECT id_category, name FROM categories");
while ($c = mysqli_fetch_assoc($categories)) {
    echo "CategoryID: {$c['id_category']} - {$c['name']}<br>";
}
?>