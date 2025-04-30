<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require 'db.php';

// Handle product deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM Product WHERE product_id = ?");
    $stmt->execute([$delete_id]);
    header("Location: admin.php");
    exit;
}

// Fetch products
$stmt = $pdo->query("SELECT * FROM Product");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .product-list {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .product-item form {
            margin: 0;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>. You are logged in as <strong>Administrator</strong>.</p>

    <div class="product-list">
        <h2>Product List</h2>
        <?php if (empty($products)): ?>
            <p>No products found.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="product-item">
                    <span><?= htmlspecialchars($product['product_name']) ?> - $<?= htmlspecialchars($product['product_price']) ?></span>
                    <form method="POST">
                        <input type="hidden" name="delete_id" value="<?= $product['product_id'] ?>">
                        <button type="submit">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div style="text-align:center; margin-top:30px;">
        <a href="index.php">← Back to Home</a>
    </div>
</body>
</html>
