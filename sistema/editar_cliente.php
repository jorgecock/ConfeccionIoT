
<?php
	include "includes/scripts.php";
	session_start();
	//if($_SESSION['rol']!=1){
	//	header("location: ./");
	//}
	
	
	/* Validar envio por Post */
	if (!empty($_POST)) 
	{
		$alert='';
		if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])) 
		{
			$alert='<p class="msg_error">Los campos Nombre, Teléfono y Dirección son obligatorios</p>';
		}else{
			
			$idcliente=$_POST['id'];/* mmmm  verificar*/
			$nit=$_POST['nit'];
			$nombre=$_POST['nombre'];
			$telefono=$_POST['telefono'];
			$direccion=$_POST['direccion'];
		
			include "../conexion.php";
			$result=0;
			if(is_numeric($nit) AND $nit!=0){
				$query= mysqli_query($conexion,"SELECT * FROM cliente 
										WHERE (nit='$nit' AND idcliente!='$idcliente')");
				$result=mysqli_fetch_array($query);
				$result=count($result);
			}
			
			if ($result>0){
				$alert='<p class="msg_error">El Nit ya existe</p>';
			}else{
				if ($nit==''){
					$nit=0;
				}

				$fecha=date('y-m-d H:i:s');
				$sql_update = mysqli_query($conexion,"UPDATE cliente SET nit='$nit', nombre='$nombre', telefono='$telefono', direccion='$direccion', updated_at='$fecha' WHERE idcliente='$idcliente' ");
				if($sql_update){
					//$alert='<p class="msg_save">Usuario Actualizado Correctamente</p>';
					mysqli_close($conexion);
					header('location: lista_clientes.php');
				}else{
					$alert='<p class="msg_error">Error al actualizar el cliente</p>';
				}
			}
			mysqli_close($conexion);
		}
	}


	//Mostrar Datos Recibidos de Get
	if (empty($_REQUEST['id'])){
		header('location: lista_clientes.php');
	}
	$idcliente=$_REQUEST['id'];
	include "../conexion.php";
	$sql=mysqli_query($conexion,"SELECT idcliente, nit, nombre, telefono, direccion FROM cliente WHERE (idcliente=$idcliente AND status=1)");
	mysqli_close($conexion);
	$result_sql=mysqli_num_rows($sql);
	if ($result_sql==0){
		header('location: lista_clientes.php'); 
	}else{
		while ($data=mysqli_fetch_array($sql)) {
			$idcliente=$data['idcliente'];
			$nit=$data['nit'];
			$nombre=$data['nombre'];
			$telefono=$data['telefono'];
			$direccion=$data['direccion'];
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Actualizar Cliente</title>
</head>

<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar Cliente</h1>
			<hr>
			<div class="alert"> <?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<input type="hidden" name="id" value="<?php echo $idcliente; ?>">
				<label for='nit'>Nit</label>
				<input type="number" name="nit" id="nit" placeholder="NIT" value="<?php echo $nit; ?>">
				<label for='nombre'>Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>">
				<label for="telefono">Teléfono</label>
				<input type="number" name="telefono" id="telefono" placeholder="Teléfono" value="<?php echo $telefono; ?>">
				<label for="direccion">Dirección</label>
				<input type="text" name="direccion" id="direccion" placeholder="Dirección" value="<?php echo $direccion; ?>">
				<br>
				<input type="submit" value="Actualizar Cliente" class="btn_save">
				<br>
				<a class="btn_cancel" href="lista_clientes.php">Cancelar</a>
			</form>
		</div>
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>