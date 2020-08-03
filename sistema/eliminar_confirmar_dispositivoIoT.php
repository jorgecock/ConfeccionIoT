<?php 
	include "includes/scripts.php";
	session_start();
	//if($_SESSION['rol']!=1){
	//	header("location: ./");
	//}
	include "../conexion.php";
	

	//mostrar datos a enviar por post
	if(!empty($_POST)){
		
		//seguridad
		if(empty($_POST['idusuario'])){
			header('location: lista_dispositivosIoT.php');
		}

		$idusuario=$_POST['idusuario'];
		
		//$query_delete=mysqli_query($conexion,"DELETE FROM usuario WHERE idusuario=$idusuario");
		$query_delete=mysqli_query($conexion,"UPDATE  usuario SET status=0 WHERE idusuario=$idusuario");


		if($query_delete){
			header('location: lista_dispositivosIoT.php');
		}else{
			echo "Error al eliminar";
		}
	}



	//Mostrar Datos Recibidos de Get
	if (empty($_REQUEST['id'])){
		header('location: lista_dispositivosIoT.php');
	}else{
		
		$idusuario=$_REQUEST['id'];
		$query=mysqli_query($conexion,"SELECT u.nombre, u.usuario, r.rol FROM usuario u INNER JOIN rol r on u.rol= r.idrol WHERE idusuario=$idusuario");
		$result=mysqli_num_rows($query);
		if ($result>0){
			while ($data=mysqli_fetch_array($query)) {
				$nombre=$data['nombre'];
				$usuario=$data['usuario'];
				$rol=$data['rol'];
			}

		}else{
			header('location: lista_dispositivosIoT.php'); 
		}
	}
	
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Eliminar Dispositivo IoT</title>
</head>
<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		<div class="data_delete">
			<h2>Está seguro de eliminar el registro:</h2>
			<p>Nombre: <span><?php echo $nombre; ?></span></p>
			<p>Usuario: <span><?php echo $usuario; ?></span></p>
			<p>Rol: <span><?php echo $rol; ?></span></p>

			<form method="post" action="">
				<input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
				<a href="lista_usuarios.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Aceptar" class="btn_ok"> 
			</form>	
		</div>
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>