<?php
$config = include 'config.php';

try {
	$conexion = new PDO('mysql:host=' . $config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['options']);
	$sql = file_get_contents("data/migracion.sql");

	$conexion->exec($sql);

	echo "La base de datos gamers_shroud y la tabla de juegos se han creado con exito.";

} catch(PDOException $error){

	echo $error->getMessage();
}
?>