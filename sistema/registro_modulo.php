<?php
	//Registro Modulo
	
	//Validar usuario con acceso a este módulo
	session_start();
	//if($_SESSION['rol']!=1){
	//	header("location: ./");
	//}

	include "includes/scripts.php";
	
	//Validar datos recibidos de forma por Post.

	$alert='';
	$nombre='';
	$descripcion='';
	$idplanta='';

	if (!empty($_POST)) 
	{
		if (empty($_POST['nombre']) || empty($_POST['descripcion'])) 
		{
			$idplanta=$_POST['idplanta'];
			$alert='<p class="msg_error">Los campos Nombre y descripción son obligatorios</p>';
		}else{
			$nombre=$_POST['nombre'];
			$descripcion=$_POST['descripcion'];
			$idplanta=$_POST['idplanta'];
			$usuario_id=$_SESSION['idUser'];

			include "../conexion.php";
			$query= mysqli_query($conexion,"SELECT * FROM modulos WHERE ((nombre='$nombre') AND status=1)");
			$result=mysqli_fetch_array($query);
			if ($result>0){
				$alert='<p class="msg_error">El nombre del Módulo ya existe</p>';
			}else{
				$query_insert = mysqli_query($conexion,"INSERT INTO modulos(nombre,idplanta,descripcion,usuario_id)
					VALUES ('$nombre',$idplanta,'$descripcion',$usuario_id)");

				if($query_insert){
					//$alert='<p class="msg_save">Usuario creado Correctamente</p>';
					mysqli_close($conexion);
					header('location: lista_modulos.php');
				}else{
					$alert='<p class="msg_error">Error al crear el módulo</p>';
				}
			}
			mysqli_close($conexion);
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registro de Módulo</title>
</head>

<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Registro de Módulo</h1>
			<hr>
			<div class="alert"> <?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				
				<!-- Nombre -->	
				<label for='nombre'>Nombre del Módulo</label>
				<input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
				
				<!-- Descripción -->	
				<label for='descripcion'>Descripción del módulo</label>
				<input type="text" name="descripcion" id="descripcion" value="<?php echo $descripcion; ?>">
				
				
				<!-- planta -->	
				<label for="idplanta">Planta</label>

				<?php
					include "../conexion.php";
					$query_plantas = mysqli_query($conexion,"SELECT * FROM plantas");
					mysqli_close($conexion);
					$result_num_plantas = mysqli_num_rows($query_plantas);
				?>

				<select name="idplanta" id="idplanta">

					<?php 
						if($result_num_plantas>0){
							while ($planta= mysqli_fetch_array($query_plantas)) { ?>
								<option value="<?php echo $planta['idplanta']; ?>" 
										<?php 
										if($idplanta==$planta['idplanta']){
											echo(" selected");
										} ?> 
								>
									<?php echo $planta["nombre"]; ?>
								</option>
						<?php }
						}
					?>
					
				</select>
				<br>

				<!-- Botones de crear y cancelar -->
				<input type="submit" value="Crear Módulo" class="btn_save">
				<br>
				<a class="btn_cancel" href="lista_modulos.php">Cancelar</a>
			</form>
		</div>
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>