<?php
	define("DATABASE_USER", "root");
	define("DATABASE_PASS", "");
	define("DATABASE_HOST", "localhost");
	define("DATABASE_NAME", "JANAH_ECommerce");
	
	try{
		$pdo = new PDO("mysql:host=".DATABASE_HOST.";dbname=".DATABASE_NAME.";charset=utf8", DATABASE_USER /* must be changed*/ , DATABASE_PASS);
	} catch(PDOException $error){
		exit("Error : ".$error->getMessage());
	}	
?>
