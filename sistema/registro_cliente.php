<?php
	//Registro Cliente

	include "includes/scripts.php";
	session_start();
	//if($_SESSION['rol']!=1){
	//	header("location: ./");
	//}
	
	
	if (!empty($_POST)) 
	{
		
		$alert='';

		if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])) 
		{
			$alert='<p class="msg_error">Los campos Nombre, Telefono y Dirección son obligatorios</p>';
		}else{	
			$nit=$_POST['nit'];
			$nombre=$_POST['nombre'];
			$telefono=$_POST['telefono'];
			$direccion=$_POST['direccion'];
			$usuario_id=$_SESSION['idUser'];

			$result=0;
			include "../conexion.php";
			if(is_numeric($nit) AND  $nit!=0){
				$query= mysqli_query($conexion,"SELECT * FROM cliente WHERE (nit='$nit' AND status=1)");
				$result=mysqli_fetch_array($query);
			}
			if ($result>0){
				$alert='<p class="msg_error">El Nit ya existe</p>';
			}else{
				$query_insert = mysqli_query($conexion,"INSERT INTO cliente(nit,nombre,telefono,direccion,usuario_id)
					VALUES ('$nit','$nombre','$telefono','$direccion','$usuario_id')");
				
				if($query_insert){
					//$alert='<p class="msg_save">Usuario creado Correctamente</p>';
					mysqli_close($conexion);
					header('location: lista_clientes.php');
				}else{
					$alert='<p class="msg_error">Error al crear el cliente</p>';
				}
			}
			mysqli_close($conexion);
		}
		
	}else{
		$nit='';
		$nombre='';
		$telefono='';
		$direccion='';
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"> 
	<title>Registro de Clientes</title>
</head>

<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Registro de Clientes</h1>
			<hr>
			<div class="alert"> <?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<label for='nit'>Nit de la Empresa</label>
				<input type="number" name="nit" id="nit" placeholder="Nit de la Empresa" value="<?php echo $nit; ?>">
				<label for='nombre'>Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre de la empresa" value="<?php echo $nombre; ?>">
				<label for='telefono'>Teléfono</label>
				<input type="number" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $telefono; ?>">
				<label for='direccion'>Dirección</label>
				<input type="text" name="direccion" id="direccion" placeholder="Dirección" value="<?php echo $direccion; ?>">
				<br>
				<input type="submit" value="Crear Cliente" class="btn_save">
				<br>
				<a class="btn_cancel" href="lista_clientes.php">Cancelar</a>
			</form>
		</div>
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>