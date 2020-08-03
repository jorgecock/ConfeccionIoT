<?php
	//Registro Planta

	include "includes/scripts.php";
	session_start();
	if($_SESSION['rol']!=1){
		header("location: ./");
	}
	
	
	if (!empty($_POST)) 
	{
		$alert='';
		$nombre=$_POST['nombre'];
		$direccion=$_POST['direccion'];
		$codigo=$_POST['codigo'];
		$ciudad=$_POST['ciudad'];
		$telefono=$_POST['telefono'];

		if (empty($_POST['nombre']) || empty($_POST['codigo'])) 
		{
			$alert='<p class="msg_error">Los campos nombre y código son obligatorios</p>';
		}else{
			
			include "../conexion.php";
			$query= mysqli_query($conexion,"SELECT * FROM plantas WHERE (codigo='$codigo' AND status=1)");
			$result=mysqli_fetch_array($query);
			if ($result>0){
				$alert='<p class="msg_error">El código de planta ya existe</p>';
			}else{
				$query_insert = mysqli_query($conexion,"INSERT INTO plantas(nombre,direccion,codigo,ciudad,telefono)
					VALUES ('$nombre','$direccion','$codigo','$ciudad','$telefono')");
				mysqli_close($conexion);
				if($query_insert){
					mysqli_close($conexion);
					header('location: lista_plantas.php');
				}else{
					$alert='<p class="msg_error">Error al crear Planta</p>';
				}
			}
			mysqli_close($conexion);
		}
	}else{
		$nombre='';
		$direccion='';
		$codigo='';
		$ciudad='';
		$telefono='';
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"> 
	<title>Registro de plantas</title>
</head>

<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Registro de Planta</h1>
			<hr>
			<div class="alert"> <?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<label for='nombre'>Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" value="<?php echo $nombre; ?>">
				<label for='direccion'>Dirección</label>
				<input type="text" name="direccion" id="direccion" placeholder="Direccion" value="<?php echo $direccion; ?>">
				<label for="codigo">Código</label>
				<input type="text" name="codigo" id="codigo" placeholder="Código" value="<?php echo $codigo; ?>">
				<label for="ciudad">Ciudad</label>
				<input type="text" name="ciudad" id="ciudad" placeholder="Ciudad" value="<?php echo $ciudad; ?>">
				<label for="telefono">Teléfono</label>
				<input type="text" name="telefono" id="telefono" placeholder="Teléfono" value="<?php echo $telefono; ?>">
				<br>
				<input type="submit" value="Crear Planta" class="btn_save">
				<br>
				<a class="btn_cancel" href="lista_plantas.php">Cancelar</a>
			</form>
		</div>
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>