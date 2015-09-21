<?php
	$dsn = 'mysql:host=localhost;dbname=tablero';
	$nombre_usuario = 'root';
	$contraseña = '';
	$opciones = array(
	    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	); 

	try{

	    $con = new PDO($dsn, $nombre_usuario, $contraseña, $opciones);

	}catch(PDOException $e){

	    echo "ERROR: " . $e->getMessage();

	}
?>
