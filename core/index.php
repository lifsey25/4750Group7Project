<?php
require 'api.php';
$products = getProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Test</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Products</h1>
    <a href="add_product.php">Add Product</a>
    <div class="products">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <h2><?= htmlspecialchars($product['title']) ?></h2>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <strong>$<?= htmlspecialchars($product['price']) ?></strong>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
