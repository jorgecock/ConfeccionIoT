 <?php
	//Registro  Dispositivo IoT

	include "includes/scripts.php";
	session_start();
	//if($_SESSION['rol']!=1){
	//	header("location: ./");
	//}

	if (!empty($_POST)) 
	{
		$alert='';
		$nombre=$_POST['nombre'];
		$direccion=$_POST['direccion'];
		$serie=$_POST['serie'];
		$tipo=$_POST['tipo'];
		$localizacion=$_POST['localizacion'];
		$usuario_id=$_SESSION['idUser'];

		if (empty($_POST['direccion']) || empty($_POST['nombre']) || empty($_POST['serie']) || empty($_POST['tipo']) || empty($_POST['localizacion'])) 
		{
			$alert='<p class="msg_error">Los campos: Nombre, Dirección, Localización, Serie y Tipo son obligatorios</p>';
		}else{
			include "../conexion.php";
			$query= mysqli_query($conexion,"SELECT * FROM moduloiot WHERE ((direccion='$direccion' OR nombre='$nombre' OR serie='$serie') AND status=1)");
			$result=mysqli_fetch_array($query);
			if ($result>0){
				$alert='<p class="msg_error">El nombre, direccion o serie ya existen. Estos campos no pueden estar repetidos.</p>';
			}else{
				$query_insert = mysqli_query($conexion,"INSERT INTO moduloiot(direccion,nombre, localizacion, serie, idtipomoduloiot, usuario_id)
					VALUES ('$direccion','$nombre','$localizacion','$serie','$tipo', $usuario_id)");
				if($query_insert){
					//$alert='<p class="msg_save">Usuario creado Correctamente</p>';
					mysqli_close($conexion);
					header('location: lista_dispositivosIoT.php');
				}else{
					$alert='<p class="msg_error">Error al crear el Dispositivo IoT</p>';
				}
			}
			mysqli_close($conexion);
		}
	}else{
		$nombre='';
		$direccion='';
		$serie='';
		$tipo=1;
		$localizacion='';
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registro de Dispositivo IoT</title>
</head>

<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Registro de Dispositivo IoT</h1>
			<hr>
			<div class="alert"> <?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<label for='direccion'>Dirección</label>
				<input type="text" name="direccion" id="direccion" placeholder="Dirección" value="<?php echo $direccion; ?>">
				<label for='nombre'>Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>">
				<label for="localizacion">Localización</label>
				<input type="text" name="localizacion" id="localizacion" placeholder="Localización" value="<?php echo $localizacion; ?>">
				<label for="serie">Serie</label>
				<input type="text" name="serie" id="serie" placeholder="Serie" value="<?php echo $serie; ?>">
				<label for="tipo">Tipo de Dispositivo IoT</label>

				<?php
					include "../conexion.php";
					$query_tipo = mysqli_query($conexion,"SELECT * FROM tiposmodulosiot");
					mysqli_close($conexion);
					$result_tipo = mysqli_num_rows($query_tipo);
				?>

				<select name="tipo" id="tipo">

					<?php 
						if($result_tipo>0){
							while ($tipoa= mysqli_fetch_array($query_tipo)) { ?>
								<option value="<?php echo $tipoa["idtipomoduloiot"]; ?>"
									<?php if($tipo==$tipoa["idtipomoduloiot"]){echo " selected";} ?>>	
									<?php echo $tipoa["tipomoduloIoT"]; ?>
								</option><?php
							}
						}
					?>
					
				</select>
				<br>
				<input type="submit" value="Crear Dispositivo IoT" class="btn_save">
				<br>
				<a class="btn_cancel" href="lista_dispositivosIoT.php">Cancelar</a>
			</form>
		</div>
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>