<?php
include 'funciones.php';

csrf();

if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
	die();
}

$config = include 'config.php';

$resultado = [
	'error' => false,
	'mensaje' => ''
];

if (!isset($_GET['id'])) {
	$resultado['error'] = true;
	$resultado['mensaje'] = 'El juego no existe';
}

if (isset($_POST['submit'])) {

	try {

		$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
		$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

		$juegos = [
			"id"			=> $_GET['id'],
			"nombre"		=> $_POST['nombre'],
			"genero"		=> $_POST['genero'],
			"desc"			=> $_POST['desc'],
			"so_m"			=> $_POST['so_m'],
			"procesador_m"	=> $_POST['procesador_m'],
			"ram_m"			=> $_POST['ram_m'],
			"grafica_m"		=> $_POST['grafica_m'],
			"so_r"			=> $_POST['so_r'],
			"procesador_r"	=> $_POST['procesador_r'],
			"ram_r"			=> $_POST['ram_r'],
			"grafica_r"		=> $_POST['grafica_r'],
			"red"			=> $_POST['red'],
		];

		$consultaSQL = "UPDATE	JUEGOS
						SET		NOMBRE_JUEGO = :nombre,
								GENERO_JUEGO = :genero,
								DESC_JUEGO = :desc,
								SO_M = :so_m,
								PROCESADOR_M = :procesador_m,
								RAM_M = :ram_m,
								GRAFICA_M = :grafica_m,
								SO_R = :so_r,
								PROCESADOR_R = :procesador_r,
								RAM_R = :ram_r,
								GRAFICA_R = :grafica_r,
								DESC_RED = :red,
								updated_at = NOW()
						WHERE	ID_JUEGO = :id";

		$consulta = $conexion->prepare($consultaSQL);
		$consulta->execute($juegos);

	} catch(PDOException $error) {

		$resultado['error'] = true;
		$resultado['mensaje'] = $error->getMessage();
	}
}

try {
	$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
	$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
		
	$id = $_GET['id'];
	$consultaSQL = "SELECT * FROM JUEGOS WHERE ID_JUEGO =" . $id;

	$sentencia = $conexion->prepare($consultaSQL);
	$sentencia->execute();

	$juegos = $sentencia->fetch(PDO::FETCH_ASSOC);

	if (!$juegos) {
		$resultado['error'] = true;
		$resultado['mensaje'] = 'No se ha encontrado el juego.';
	}

} catch(PDOException $error) {

	$resultado['error'] = true;
	$resultado['mensaje'] = $error->getMessage();
}
?>
<?php require "temps/header.php";

if ($resultado['error']) {
?>

	<center>
	<div class="alert-container">
		<div class="warning advice" role="alert">
		<?= $resultado['mensaje'] ?>
		</div>
	</div>
	</center>

<?php
}

if (isset($_POST['submit']) && !$resultado['error']) {
?>

	<center>
	<div class="alert-container">
		<div class="warning ok" role="alert">
			La informaci&oacute;n del juego ha sido actualizada correctamente.
		</div>
	</div>
	</center>

<?php
}

if (isset($juegos) && $juegos) {
?>

<div>
	<hr><br>
	<table width="98%">
		<tr>
			<th style="text-align: left;">
				<h2 class="titulo-pagina">Editando el juego <?= escapar($juegos['NOMBRE_JUEGO']) ?></h2><br><br>
			</th>
			<td style="text-align: right;">
				<a href="index.php"><button class="boton-anhadir">Volver a inicio</button></a>
			</td>
		</tr>
	</table>
	<form method="post">
		<div class="div-input-crear" style="margin-left: 3%;">
			<input type="text" name="nombre" id="nombre" placeholder="" class="input-crear" value="<?= escapar($juegos['NOMBRE_JUEGO']) ?>" required>
			<label for="nombre" class="label-crear">Nombre</label>
		</div><br><br><br><br>
		<div class="div-input-crear" style="margin-left: 3%;">
			<input type="text" name="genero" id="genero" placeholder="" class="input-crear" value="<?= escapar($juegos['GENERO_JUEGO']) ?>" required>
			<label for="genero" class="label-crear">G&eacute;nero</label>
		</div><br><br><br><br>
		<div class="div-input-crear" style="margin-left: 3%;">
			<textarea name="desc" id="desc" placeholder="" class="input-crear" rows="4" cols="50" required></textarea>
			<label for="desc" class="label-crear" value="<?= escapar($juegos['DESC_JUEGO']) ?>">Descripci&oacute;n</label>
		</div><br><br><br><br>
		<div class="div-input-crear" style="margin-left: 3%;">
			<input type="text" name="so_m" id="so_m" placeholder="" class="input-crear" value="<?= escapar($juegos['SO_M']) ?>" required>
			<label for="so_m" class="label-crear">Sistema operativo (m&iacute;nimo)</label>
		</div><br><br><br><br>
		<div class="div-input-crear" style="margin-left: 3%;">
			<input type="text" name="procesador_m" id="procesador_m" placeholder="" class="input-crear" value="<?= escapar($juegos['PROCESADOR_M']) ?>" required>
			<label for="procesador_m" class="label-crear">Procesador (m&iacute;nimo)</label>
		</div><br><br><br><br>
		<div class="div-input-crear" style="margin-left: 3%;">
			<input type="text" name="ram_m" id="ram_m" placeholder="" class="input-crear" value="<?= escapar($juegos['RAM_M']) ?>" required>
			<label for="ram_m" class="label-crear">Memoria RAM (m&iacute;nimo)</label>
		</div><br><br><br><br>
		<div class="div-input-crear" style="margin-left: 3%;">
			<input type="text" name="grafica_m" id="grafica_m" placeholder="" class="input-crear" value="<?= escapar($juegos['GRAFICA_M']) ?>" required>
			<label for="grafica_m" class="label-crear">Tarjeta gr&aacute;fica (m&iacute;nimo)</label>
		</div><br><br><br><br>
		<div class="div-input-crear" style="margin-left: 3%;">
			<input type="text" name="so_r" id="so_r" placeholder="" class="input-crear" value="<?= escapar($juegos['SO_R']) ?>" required>
			<label for="so_r" class="label-crear">Sistema operativo (recomendado)</label>
		</div><br><br><br><br>
		<div class="div-input-crear" style="margin-left: 3%;">
			<input type="text" name="procesador_r" id="procesador_r" placeholder="" class="input-crear" value="<?= escapar($juegos['PROCESADOR_R']) ?>" required>
			<label for="procesador_r" class="label-crear">Procesador (recomendado)</label>
		</div><br><br><br><br>
		<div class="div-input-crear" style="margin-left: 3%;">
			<input type="text" name="ram_r" id="ram_r" placeholder="" class="input-crear" value="<?= escapar($juegos['RAM_R']) ?>" required>
			<label for="ram_r" class="label-crear">Memoria RAM (recomendado)</label>
		</div><br><br><br><br>
		<div class="div-input-crear" style="margin-left: 3%;">
			<input type="text" name="grafica_r" id="grafica_r" placeholder="" class="input-crear" value="<?= escapar($juegos['GRAFICA_R']) ?>" required>
			<label for="grafica_r" class="label-crear">Tarjeta gr&aacute;fica (recomendado)</label>
		</div><br><br><br><br>
		<div class="div-input-crear" style="margin-left: 3%;">
			<input type="text" name="red" id="red" placeholder="" class="input-crear" value="<?= escapar($juegos['DESC_RED']) ?>">
			<label for="red" class="label-crear">Red</label>
		</div><br><br><br><br>
		<table class="formulario">
			<tr class="botones-crear">
				<th>
					<input type="submit" name="submit" class="boton-anhadir" value="Actualizar">
				</th>
			</tr>
		</table>
		<input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
	</form>
</div><br><br><hr><br>

<?php
}

require "temps/footer.php";
?>