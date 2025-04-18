<?php
require 'db.php';

function getProducts() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM Product");
    return $stmt->fetchAll();
}

function addProduct($title, $price, $description, $category) {
    $newProduct = [
        'id' => time(),  // Unique ID using timestamp
        'title' => $title,
        'price' => $price,
        'description' => $description,
        'category' => $category
    ];

    // Save locally
    $localProducts = [];
    if (file_exists('products.json')) {
        $localProducts = json_decode(file_get_contents('products.json'), true) ?? [];
    }
    
    $localProducts[] = $newProduct;
    file_put_contents('products.json', json_encode($localProducts, JSON_PRETTY_PRINT));

    return $newProduct;
}

?>

