<?php
	//Registro maquina

	include "includes/scripts.php";
	session_start();
	//if($_SESSION['rol']!=1){
	//	header("location: ./");
	//}
	include "../conexion.php";


	if (!empty($_POST)) 
	{
		$alert='';
		if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave']) || empty($_POST['rol'])) 
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios</p>';
		}else{
			$nombre=$_POST['nombre'];
			$email=$_POST['correo'];
			$user=$_POST['usuario'];
			$clave=md5($_POST['clave']);
			$rol=$_POST['rol'];

			$query= mysqli_query($conexion,"SELECT * FROM usuario WHERE ((usuario='$user' OR correo='$email') AND status=1)");
			$result=mysqli_fetch_array($query);
			if ($result>0){
				$alert='<p class="msg_error">El usuario o el correo ya existe</p>';
			}else{
				$query_insert = mysqli_query($conexion,"INSERT INTO usuario(nombre,correo,usuario,clave,rol)
					VALUES ('$nombre','$email','$user','$clave','$rol')");
				if($query_insert){
					//$alert='<p class="msg_save">Usuario creado Correctamente</p>';
					header('location: lista_maquinas.php');
				}else{
					$alert='<p class="msg_error">Error al crear el usuario</p>';
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registro de Máquina</title>
</head>

<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Registro de Máquina</h1>
			<hr>
			<div class="alert"> <?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<label for='nombre'>Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre Completo">
				<label for='correo'>Correo Electrónico</label>
				<input type="email" name="correo" id="correo" placeholder="Correo Electrónico">
				<label for="usuario">Usuario</label>
				<input type="text" name="usuario" id="usuario" placeholder="Usuario">
				<label for="clave">Clave</label>
				<input type="password" name="clave" id="clave" placeholder="Clave de Acceso">
				<label for="rol">Tipo de usuario</label>


				<?php
					$query_rol = mysqli_query($conexion,"SELECT * FROM rol");
					$result_rol = mysqli_num_rows($query_rol);
				?>

				<select name="rol" id="rol">

					<?php 
						if($result_rol>0){
							while ($rol= mysqli_fetch_array($query_rol)) {
								?><option value="<?php echo $rol["idrol"]; ?>"><?php echo $rol["rol"]; ?></option><?php
							}
						}
					?>
					
				</select>
				<br>
				<input type="submit" value="Crear Máquina" class="btn_save">
				<br>
				<a class="btn_cancel" href="lista_maquinas.php">Cancelar</a>
			</form>
		</div>
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>