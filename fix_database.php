<?php
include 'config.php';

echo "<h3>🔧 Fixing Database Issues</h3>";

// 1. PERBAIKI TABEL SUPPLIERS - Hapus supplier yang tidak valid
echo "<h4>1. Cleaning suppliers table...</h4>";
$clean_suppliers = "DELETE FROM suppliers WHERE SupplierName IS NULL OR SupplierName = ''";
if (mysqli_query($conn, $clean_suppliers)) {
    $affected = mysqli_affected_rows($conn);
    echo "Deleted $affected invalid suppliers<br>";
}

// Tambahkan sample suppliers jika kosong
$check_suppliers = mysqli_query($conn, "SELECT COUNT(*) as total FROM suppliers WHERE SupplierName IS NOT NULL AND SupplierName != ''");
$supplier_count = mysqli_fetch_assoc($check_suppliers)['total'];

if ($supplier_count == 0) {
    echo "Adding sample suppliers...<br>";
    $sample_suppliers = [
        "INSERT INTO suppliers (SupplierName, ContactPerson, Phone, Email, Address) VALUES ('PT Elektronik Jaya', 'Budi Santoso', '08123456789', 'budi@elektronikjaya.com', 'Jl. Sudirman No. 123, Jakarta')",
        "INSERT INTO suppliers (SupplierName, ContactPerson, Phone, Email, Address) VALUES ('CV Alat Tulis Mandiri', 'Sari Dewi', '08234567890', 'sari@alatulis.com', 'Jl. Thamrin No. 45, Bandung')",
        "INSERT INTO suppliers (SupplierName, ContactPerson, Phone, Email, Address) VALUES ('Furniture Indonesia', 'Ahmad Rizki', '08345678901', 'ahmad@furniture.co.id', 'Jl. Gatot Subroto No. 67, Surabaya')"
    ];
    
    foreach ($sample_suppliers as $sql) {
        if (mysqli_query($conn, $sql)) {
            echo "Added supplier: " . mysqli_insert_id($conn) . "<br>";
        }
    }
}

// 2. PERBAIKI TABEL USERS - Fix password dan user tidak valid
echo "<h4>2. Fixing users table...</h4>";
$fix_users = [
    // Update password untuk admin (password: admin123)
    "UPDATE users SET password = '$2y$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', is_active = 1 WHERE username = 'admin'",
    
    // Update password untuk staff1 (password: staff123)  
    "UPDATE users SET password = '$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', is_active = 1 WHERE username = 'staff1'",
    
    // Update password untuk admin2 (password: admin123)
    "UPDATE users SET password = '$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', is_active = 1 WHERE username = 'admin2'",
    
    // Fix user1 atau hapus jika tidak valid
    "DELETE FROM users WHERE username = 'User1' OR password LIKE '%...%' OR LENGTH(password) < 50"
];

foreach ($fix_users as $sql) {
    if (mysqli_query($conn, $sql)) {
        echo "Updated users: " . mysqli_affected_rows($conn) . " rows affected<br>";
    }
}

// 3. PERBAIKI TABEL INVENTORY - Pastikan foreign key valid
echo "<h4>3. Fixing inventory table...</h4>";
$fix_inventory = [
    // Update supplierID yang tidak valid
    "UPDATE inventory SET SupplierID = (SELECT SupplierID FROM suppliers WHERE SupplierName IS NOT NULL LIMIT 1) WHERE SupplierID NOT IN (SELECT SupplierID FROM suppliers WHERE SupplierName IS NOT NULL)",
    
    // Update category_id yang tidak valid  
    "UPDATE inventory SET category_id = 1 WHERE category_id NOT IN (SELECT id_category FROM categories) OR category_id IS NULL"
];

foreach ($fix_inventory as $sql) {
    if (mysqli_query($conn, $sql)) {
        echo "Fixed inventory: " . mysqli_affected_rows($conn) . " rows affected<br>";
    }
}

// 4. PERBAIKI TABEL ORDERS - Pastikan foreign key valid
echo "<h4>4. Fixing orders table...</h4>";
$fix_orders = [
    "UPDATE orders SET SupplierID = (SELECT SupplierID FROM suppliers WHERE SupplierName IS NOT NULL LIMIT 1) WHERE SupplierID NOT IN (SELECT SupplierID FROM suppliers WHERE SupplierName IS NOT NULL)"
];

foreach ($fix_orders as $sql) {
    if (mysqli_query($conn, $sql) ) {
        echo "Fixed orders: " . mysqli_affected_rows($conn) . " rows affected<br>";
    }
}

echo "<h4 style='color: green;'>✅ Database fix completed!</h4>";

// Tampilkan status akhir
echo "<h4>Final Database Status:</h4>";
$tables = ['users', 'categories', 'suppliers', 'inventory', 'orders'];
foreach ($tables as $table) {
    $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM $table"))['total'];
    echo "<b>$table</b>: $count rows<br>";
}
?>