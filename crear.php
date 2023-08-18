<?php

include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
	die();
}

if (isset($_POST['submit'])) {

	$resultado = [
		'error' => false,
		'mensaje' => 'El juego ' . escapar($_POST['nombre']) . ' ha sido a&ntilde;adido con &eacute;xito'
	];

	$config = include 'config.php';

	try{
		$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
		$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

		// Codigo que inserta un juego

		$juego = [
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

		$consultaSQL = "INSERT INTO juegos (NOMBRE_JUEGO, GENERO_JUEGO, DESC_JUEGO, SO_M, PROCESADOR_M, RAM_M, GRAFICA_M, SO_R, PROCESADOR_R, RAM_R, GRAFICA_R, DESC_RED)";
		$consultaSQL .= "values (:" . implode(", :", array_keys($juego)) . ")";

		$sentencia = $conexion->prepare($consultaSQL);
		$sentencia->execute($juego);

	} catch(PDOException $error) {
		$resultado['error'] = true;
		$resultado['mensaje'] = $error->getMessage();
	}
}

?>

<?php include "temps/header.php"; ?>

<?php

if (isset($resultado)) {
?>
	<center>
	<div class="alert-container">
		<div class="warning <?= $resultado['error'] ? 'advice' : 'ok' ?>" role="alert">
			<?= $resultado['mensaje'] ?>
		</div>
	</div>
	</center>
<?php
}
?>
	<div>
		<hr><br>
		<table width="98%">
			<tr>
				<th style="text-align: left;">
					<h2 class="titulo-pagina">A&ntilde;adir juego</h2><br><br>
				</th>
				<td style="text-align: right;">
					<a href="index.php"><button class="boton-anhadir">Volver a inicio</button></a>
				</td>
			</tr>
		</table>
		<form method="post">
			<div class="div-input-crear" style="margin-left: 3%;">
				<input type="text" name="nombre" id="nombre" placeholder="" class="input-crear" required>
				<label for="nombre" class="label-crear">Nombre</label>
			</div><br><br><br><br>
			<div class="div-input-crear" style="margin-left: 3%;">
				<input type="text" name="genero" id="genero" placeholder="" class="input-crear" required>
				<label for="genero" class="label-crear">G&eacute;nero</label>
			</div><br><br><br><br>
			<div class="div-input-crear" style="margin-left: 3%;">
				<textarea name="desc" id="desc" placeholder="" class="input-crear" rows="4" cols="50" required></textarea>
				<label for="desc" class="label-crear">Descripci&oacute;n</label>
			</div><br><br><br><br>
			<div class="div-input-crear" style="margin-left: 3%;">
				<input type="text" name="so_m" id="so_m" placeholder="" class="input-crear" required>
				<label for="so_m" class="label-crear">Sistema operativo (m&iacute;nimo)</label>
			</div><br><br><br><br>
			<div class="div-input-crear" style="margin-left: 3%;">
				<input type="text" name="procesador_m" id="procesador_m" placeholder="" class="input-crear" required>
				<label for="procesador_m" class="label-crear">Procesador (m&iacute;nimo)</label>
			</div><br><br><br><br>
			<div class="div-input-crear" style="margin-left: 3%;">
				<input type="text" name="ram_m" id="ram_m" placeholder="" class="input-crear" required>
				<label for="ram_m" class="label-crear">Memoria RAM (m&iacute;nimo)</label>
			</div><br><br><br><br>
			<div class="div-input-crear" style="margin-left: 3%;">
				<input type="text" name="grafica_m" id="grafica_m" placeholder="" class="input-crear" required>
				<label for="grafica_m" class="label-crear">Tarjeta gr&aacute;fica (m&iacute;nimo)</label>
			</div><br><br><br><br>
			<div class="div-input-crear" style="margin-left: 3%;">
				<input type="text" name="so_r" id="so_r" placeholder="" class="input-crear" required>
				<label for="so_r" class="label-crear">Sistema operativo (recomendado)</label>
			</div><br><br><br><br>
			<div class="div-input-crear" style="margin-left: 3%;">
				<input type="text" name="procesador_r" id="procesador_r" placeholder="" class="input-crear" required>
				<label for="procesador_r" class="label-crear">Procesador (recomendado)</label>
			</div><br><br><br><br>
			<div class="div-input-crear" style="margin-left: 3%;">
				<input type="text" name="ram_r" id="ram_r" placeholder="" class="input-crear" required>
				<label for="ram_r" class="label-crear">Memoria RAM (recomendado)</label>
			</div><br><br><br><br>
			<div class="div-input-crear" style="margin-left: 3%;">
				<input type="text" name="grafica_r" id="grafica_r" placeholder="" class="input-crear" required>
				<label for="grafica_r" class="label-crear">Tarjeta gr&aacute;fica (recomendado)</label>
			</div><br><br><br><br>
			<div class="div-input-crear" style="margin-left: 3%;">
				<input type="text" name="red" id="red" placeholder="" class="input-crear">
				<label for="red" class="label-crear">Red</label>
			</div><br><br><br><br>
			<table class="formulario">
				<tr class="botones-crear">
					<th>
						<input type="submit" name="submit" class="boton-anhadir" value="A&ntilde;adir juego">
					</th>
				</tr>
			</table>
			<input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
		</form>
	</div><br><br><hr><br>

<?php include "temps/footer.php"; ?>