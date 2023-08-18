<?php
include 'funciones.php';

csrf();

if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])){
	die();
}

$error = false;
$config = include 'config.php';

try{
	$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
	$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

	if (isset($_POST['nombre'])){
		$consultaSQL = "SELECT * FROM juegos WHERE NOMBRE_JUEGO LIKE '%" . $_POST['nombre'] . "%'";
	}else{
		$consultaSQL = "SELECT * FROM juegos";
	}

	$sentencia = $conexion->prepare($consultaSQL);
	$sentencia->execute();

	$juegos = $sentencia->fetchAll();

} catch(PDOException $error) {
	$error= $error->getMessage();
}

$titulo = isset($_POST['nombre']) ? 'Listado de juegos (' . $_POST['nombre'] . ')' : 'Listado de juegos';

?>

<?php include "temps/header.php"; ?>

<?php
if ($error) {
?>
	<center>
	<div class="alert-container">
		<div class="warning advice" role="alert">
			<?= $error ?>
		</div>
	</div>
	</center>
<?php
}
?>
	<div>
		<hr><br>
		<table class="table-anhadir-juego">
			<a href="crear.php"><button class="boton-anhadir">A&ntilde;adir juego</button></a>
		</table>
		<br><br><br>
		<form method="post">
		<div class="div-input-busqueda" style="margin-left: 3%;">
			<input type="text" id="nombre" name="nombre" placeholder="" class="input-busqueda">
			<label class="label-busqueda">Nombre del juego</label>
		</div><br><br><br>
		<div>
			<input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
		</div>
		<button type="submit" name="submit" class="boton-listar">Ver resultados</button><br><br><br>
		</form>
	</div>

	<div>
		<h2 style="margin-left: 3%;"><?=$titulo?></h2><br>
		<center>
		<table class="listado">
			<thead>
				<tr>
					<th class="th-naranja">ID Juego</th>
					<th class="th-naranja">Nombre</th>
					<th class="th-naranja">G&eacute;nero</th>
					<th class="th-naranja">Descripci&oacute;n</th>
					<th class="th-naranja">Sistema Operativo (m&iacute;nimo)</th>
					<th class="th-naranja">Procesador (m&iacute;nimo)</th>
					<th class="th-naranja">Memoria RAM (m&iacute;nimo)</th>
					<th class="th-naranja">Tarjeta gr&aacute;fica (m&iacute;nimo)</th>
					<th class="th-naranja">Sistema Operativo (recomendado)</th>
					<th class="th-naranja">Procesador (recomendado)</th>
					<th class="th-naranja">Memoria RAM (recomendado)</th>
					<th class="th-naranja">Tarjeta gr&aacute;fica (recomendado)</th>
					<th class="th-naranja">Red</th>
					<th class="th-naranja"></th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ($juegos && $sentencia->rowCount() > 0){
					foreach ($juegos as $juego){
				?>
						<tr>
							<td class="td-blanco"><?php echo escapar($juego["ID_JUEGO"]); ?></td>
							<td class="td-blanco"><?php echo escapar($juego["NOMBRE_JUEGO"]); ?></td>
							<td class="td-blanco"><?php echo escapar($juego["GENERO_JUEGO"]); ?></td>
							<td class="td-blanco"><?php echo escapar($juego["DESC_JUEGO"]); ?></td>
							<td class="td-blanco"><?php echo escapar($juego["SO_M"]); ?></td>
							<td class="td-blanco"><?php echo escapar($juego["PROCESADOR_M"]); ?></td>
							<td class="td-blanco"><?php echo escapar($juego["RAM_M"]); ?></td>
							<td class="td-blanco"><?php echo escapar($juego["GRAFICA_M"]); ?></td>
							<td class="td-blanco"><?php echo escapar($juego["SO_R"]); ?></td>
							<td class="td-blanco"><?php echo escapar($juego["PROCESADOR_R"]); ?></td>
							<td class="td-blanco"><?php echo escapar($juego["RAM_R"]); ?></td>
							<td class="td-blanco"><?php echo escapar($juego["GRAFICA_R"]); ?></td>
							<td class="td-blanco"><?php echo escapar($juego["DESC_RED"]); ?></td>
							<td class="td-blanco">
								<a href="<?='borrar.php?id=' . escapar($juego["ID_JUEGO"]) ?>" class="botones-accion">Eliminar</a>
								<a href="<?='editar.php?id=' . escapar($juego["ID_JUEGO"]) ?>" class="botones-accion">Editar</a>
							</td>
						</tr>
				<?php
					}
				}
				?>
			<tbody>
		</table>
		</center><br><br><hr><br>
	</div>

<?php include "temps/footer.php"; ?>