<?php 
	include "includes/scripts.php";
	session_start();
	if($_SESSION['rol']!=1 AND $_SESSION['rol']!=4 AND $_SESSION['rol']!=5){
		header("location: ./");
	}
	
	//mostrar datos a enviar por post
	if(!empty($_POST)){
		
		//seguridad
		if(empty($_POST['id'])){
			header('location: lista_clientes.php');
		}

		$id=$_POST['id'];
		
		//Query para borrar cambiando el estatus a 0
		include "../conexion.php";
		$fecha=date('y-m-d H:i:s');
		$query_delete=mysqli_query($conexion,"UPDATE cliente SET status=0, deleted_at ='$fecha' WHERE idcliente='$id'");
		mysqli_close($conexion);

		if($query_delete){
			header('location: lista_clientes.php');
		}else{
			echo "Error al eliminar cliente";
		}
	}



	//Mostrar Datos Recibidos de Get
	if (empty($_REQUEST['id'])){
		header('location: lista_clientes.php');
	}else{
		$id=$_REQUEST['id'];
		include "../conexion.php";
		$query=mysqli_query($conexion,"SELECT nit, nombre, telefono FROM cliente WHERE idcliente='$id'");
		mysqli_close($conexion);
		$result=mysqli_num_rows($query);
		if ($result>0){
			while ($data=mysqli_fetch_array($query)) {
				$nit=$data['nit'];
				$nombre=$data['nombre'];
				$telefono=$data['telefono'];
			}

		}else{
			header('location: lista_clientes.php'); 
		}
	}
	
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Eliminar Cliente</title>
</head>
<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		<div class="data_delete">
			<h2>Está seguro de eliminar el registro de Cliente:</h2>
			<p>NIT: 
				<span>
					<?php 
						if($nit==0){
							echo "C/F";
						}else{
							echo $nit;
						} 
					?>	
				</span>
			</p>
			<p>Nombre: <span><?php echo $nombre; ?></span></p>
			<p>Teléfono: <span><?php echo $telefono; ?></span></p>

			<form method="post" action="">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<a href="lista_clientes.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Aceptar" class="btn_ok"> 
			</form>	
		</div>
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>