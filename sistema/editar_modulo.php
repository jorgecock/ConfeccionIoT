<?php
	session_start();
	//if($_SESSION['rol']!=1){
	//	header("location: ./");
	//}
	include "../conexion.php";
	
	/* Validar envio por Post */
	if (!empty($_POST)) 
	{
		$alert='';
		if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['rol'])) 
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios</p>';
		}else{
			
			$idusuario=$_POST['idUsuario'];/* mmmm  verificar*/
			$nombre=$_POST['nombre'];
			$email=$_POST['correo'];
			$user=$_POST['usuario'];
			$clave=md5($_POST['clave']);
			$rol=$_POST['rol'];

			$query= mysqli_query($conexion,"SELECT * FROM usuario 
											WHERE ((usuario='$user' OR correo='$email') AND idusuario!=$idusuario)");
			$result=mysqli_fetch_array($query);
			if ($result>0){
				$alert='<p class="msg_error">El usuario o el correo ya existe</p>';
			}else{
				if(empty($_POST['clave'])){
					$sql_update = mysqli_query($conexion,"UPDATE usuario SET nombre='$nombre', correo='$email', usuario='$user', rol='$rol' WHERE idUsuario='$idusuario' ");
				}else{
					$sql_update = mysqli_query($conexion,"UPDATE usuario SET nombre='$nombre', correo='$email', usuario='$user', clave='$clave', rol='$rol' WHERE idUsuario='$idusuario' ");
				}

				if($sql_update){
					//$alert='<p class="msg_save">Usuario Actualizado Correctamente</p>';
					header('location: lista_modulos.php');
				}else{
					$alert='<p class="msg_error">Error al actualizar el Módulo</p>';
				}
			}
		}
	}


	//Mostrar Datos Recibidos de Get
	if (empty($_GET['id'])){
		header('location: lista_modulos.php');
	}
	$iduser=$_GET['id'];
	$sql=mysqli_query($conexion,"SELECT u.idusuario, u.nombre, u.correo, u.usuario, (u.rol) as idrol, (r.rol) as rol FROM usuario u INNER JOIN rol r on u.rol= r.idrol WHERE (idusuario=$iduser AND status=1)");
	$result_sql=mysqli_num_rows($sql);
	if ($result_sql==0){
		header('location: lista_modulos.php'); 
	}else{
		while ($data=mysqli_fetch_array($sql)) {
			$iduser=$data['idusuario'];
			$nombre=$data['nombre'];
			$correo=$data['correo'];
			$usuario=$data['usuario'];
			$rol=$data['rol'];
			
			$idrol=$data['idrol'];
			/* echo $idrol; echo(" "); echo $rol;*/ /*muestra el rol del usuario a editar*/
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php  include "includes/scripts.php"; ?> 
	<title>Actualizar Módulos</title>
</head>

<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar Módulo</h1>
			<hr>
			<div class="alert"> <?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<input type="hidden" name="idUsuario" value="<?php echo $iduser; ?>">
				<label for='nombre'>Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" value="<?php echo $nombre; ?>">
				<label for='correo'>Correo Electrónico</label>
				<input type="email" name="correo" id="correo" placeholder="Correo Electrónico" value="<?php echo $correo; ?>">
				<label for="usuario">Usuario</label>
				<input type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?php echo $usuario; ?>">
				<label for="clave">Clave</label>
				<input type="password" name="clave" id="clave" placeholder="Clave de Acceso" >
				<label for="rol">Tipo de Módulo</label>

				<?php
					$query_rol = mysqli_query($conexion,"SELECT * FROM rol");
					$result_rol = mysqli_num_rows($query_rol);
				?>

				<select name="rol" id="rol" class="notItemOne">
					<?php 
						if($result_rol>0){
							while ($rol_a= mysqli_fetch_array($query_rol)) { ?>		
						
							<option value="<?php echo $rol_a["idrol"]; ?>"     
								<?php if($idrol==$rol_a["idrol"]){echo " selected";} ?>>
								<?php echo $rol_a["rol"];?>		
							</option><?php
							}
						}
					?>
					
				</select>
				<br>
				<input type="submit" value="Actualizar Módulo" class="btn_save">
				<br>
				<a class="btn_cancel" href="lista_modulos.php">Cancelar</a>
			</form>
		</div>
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>