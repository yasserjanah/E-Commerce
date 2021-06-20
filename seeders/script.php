<?php

	include_once "../database/connection.php";
	$products = file_get_contents("./products.json");
	$JSONData = json_decode($products, true);

	foreach($JSONData as $row){
	
		$data = $row["category"];
				
		$ProducttoBeInserted = $pdo->prepare('INSERT INTO Products(sku, name, description, price, image, catID) VALUES (?, ?, ?, ?, ?, ?)');
		$ProducttoBeInserted->execute([$row['sku'], $row['name'], $row['description'], $row['price'], $row['image'], $data[0]['id']]);

		$CategorytoBeInserted = $pdo->prepare('INSERT INTO Categories (id, name) VALUES (?,?)');
		$CategorytoBeInserted->execute([$data[0]['id'], $data[0]['name']]);
	}
?>
