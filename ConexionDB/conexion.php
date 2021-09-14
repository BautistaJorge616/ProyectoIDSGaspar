<?php


	//Conectar con la base de datos
	$server = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'gestordb';

	//Intentar conectarnos 
	try {
	 	$conn = new PDO("mysql:host=$server;port=3307;dbname=$database;",$username,$password);
	 	echo "ONLINE</br>";
	 } catch (PDOException $e) {
	 	die('Connected failed: '.$e->getMessage());
	 } 

?>
	