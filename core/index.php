<?php
session_start();

// Require login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    echo '<p><a href="admin.php">Go to Admin Panel</a></p>';
}

require 'api.php';
$products = getProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product List</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <h1>Products</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>! <a href="logout.php">Logout</a></p>
    <a href="cart.php">View Cart</a>
    <div class="products">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <h2><?= htmlspecialchars($product['product_name']) ?></h2>
                <p>In Stock: <?= htmlspecialchars($product['product_in_stock']) ?></p>
                <strong>$<?= htmlspecialchars($product['product_price']) ?></strong>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
