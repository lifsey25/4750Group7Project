<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require 'db.php';

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $product_id = (int)$_POST['add_to_cart'];
        if (!in_array($product_id, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $product_id;
        }
    } elseif (isset($_POST['remove_from_cart'])) {
        $product_id = (int)$_POST['remove_from_cart'];
        $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($id) => $id != $product_id);
    }
}

// Get product list
$all_products = $pdo->query("SELECT * FROM Product")->fetchAll();
$cart_items = [];

if (!empty($_SESSION['cart'])) {
    $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
    $stmt = $pdo->prepare("SELECT * FROM Product WHERE product_id IN ($placeholders)");
    $stmt->execute(array_values($_SESSION['cart']));
    $cart_items = $stmt->fetchAll();
} else {
    $cart_items = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <h1>Your Cart</h1>

    <div class="product-list">
        <h2>Products in Cart</h2>
        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($cart_items as $item): ?>
                    <li style="display: flex; justify-content: space-between; align-items: center;">
                        <span><?= htmlspecialchars($item['product_name']) ?> - $<?= htmlspecialchars($item['product_price']) ?></span>
                        <form method="POST">
                            <input type="hidden" name="remove_from_cart" value="<?= $item['product_id'] ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="product-list">
        <h2>Add More Products</h2>
        <?php foreach ($all_products as $product): ?>
            <div class="product-item">
                <span><?= htmlspecialchars($product['product_name']) ?> - $<?= htmlspecialchars($product['product_price']) ?></span>
                <form method="POST">
                    <input type="hidden" name="add_to_cart" value="<?= $product['product_id'] ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="text-align:center; margin-top:30px;">
        <a href="index.php">← Back to Home</a>
    </div>
</body>
</html>
