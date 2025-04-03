<?php
require 'api.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 	$title = $_POST['title'] ?? '';
	$price = $_POST['price'] ?? '';
	$description = $_POST['description'] ?? '';
	$category = $_POST['category'] ?? 'electronics';

	$response = addProduct($title, $price, $description, $category);
	if ($response) {
		header('Location: index.php');
		exit;
	} else {
		echo "Error adding product.";
							        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
</head>
<body>
    <h1>Add a New Product</h1>
    <form method="POST" action="">
        <label>Title: <input type="text" name="title" required></label><br>
        <label>Price: <input type="number" step="0.01" name="price" required></label><br>
        <label>Description: <textarea name="description" required></textarea></label><br>
        <label>Category: <input type="text" name="category" value="electronics"></label><br>
        <button type="submit">Add Product</button>
    </form>
</body>
</html>
