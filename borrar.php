<?php
include 'funciones.php';

$config = include 'config.php';

$resultado = [
	'error' => false,
	'mensaje' => ''
];

try {
	$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
	$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
		
	$id = $_GET['id'];
	$consultaSQL = "DELETE FROM JUEGOS WHERE ID_JUEGO =" . $id;

	$sentencia = $conexion->prepare($consultaSQL);
	$sentencia->execute();

	#alert('<center><div class="alert-container"><div class="warning advice" role="alert">El juego seleccionado ha sido eliminado correctamente.</div></div></center>');
	#header('Location: /index.php');

} catch(PDOException $error) {

	$resultado['error'] = true;
	$resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "temps/header.php"; ?>

	<center>
	<div class="alert-container">
		<div class="warning advice" role="alert">
			El juego ha sido eliminado con &eacute;xito.
		</div>
	</div>
	</center>

	<table width="98%">
		<tr>
			<td style="text-align: center;">
				<a href="index.php"><button class="boton-anhadir">Volver al listado</button></a>
			</td>
		</tr>
	</table>

<?php require "temps/footer.php"; ?>