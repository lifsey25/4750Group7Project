<?php
require 'api.php';
$products = getProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Products</h1>
    <a href="add_product.php">Add Product</a>
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
