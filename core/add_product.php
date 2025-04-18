<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product_name'] ?? '';
    $price = $_POST['product_price'] ?? 0;
    $stock = $_POST['product_in_stock'] ?? 0;

    $stmt = $pdo->prepare("INSERT INTO Product (product_name, product_price, product_in_stock) VALUES (?, ?, ?)");
    $stmt->execute([$name, $price, $stock]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Add Product</h1>
    <form method="POST">
        <label>Product Name:<br><input name="product_name" required></label><br><br>
        <label>Price:<br><input name="product_price" type="number" step="0.01" required></label><br><br>
        <label>Stock Quantity:<br><input name="product_in_stock" type="number" required></label><br><br>
        <button type="submit">Add</button>
    </form>
</body>
</html>
