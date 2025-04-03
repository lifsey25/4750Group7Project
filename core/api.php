<?php
function getProducts() {
	$response = file_get_contents('https://fakestoreapi.com/products');
	return json_decode($response, true);
}

function addProduct($title, $price, $description, $category) {
	$data = [
		'title' => $title,
		'price' => $price,
		'description' => $description,
		'category' => $category
	];

	$options = [
		'http' => [
			'header' => "Content-Type: application/json",
			'method' => 'POST',
			'content' => json_encode($data)
		]
];

	$context = stream_context_create($options);
	$response = file_get_contents('https://fakestoreapi.com/products', false, $context);
	
	return json_decode($response, true);
}
?>

