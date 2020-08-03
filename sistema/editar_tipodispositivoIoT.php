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
		if (empty($_POST['tipomoduloIoT']) OR empty($_POST['referencia']) ) 
		{
			$alert='<p class="msg_error">Los campos Tipo Modulo y Referencia son necesarios</p>';
		}else{
			
			$idtipomoduloiot=$_POST['id'];/* mmmm  verificar*/
			$tipomoduloIoT=$_POST['tipomoduloIoT'];
			$descripcion=$_POST['descripcion'];
			$referencia=$_POST['referencia'];
			
			$query= mysqli_query($conexion,"SELECT * FROM tiposmodulosiot 
											WHERE (referencia='$referencia' AND idtipomoduloiot!=$idtipomoduloiot)");
			$result=mysqli_fetch_array($query);
			$result=count($result);

			if ($result>0){
				$alert='<p class="msg_error">El Tipo de dispositivo IoT ya existe</p>';
			}else{
				
				$sql_update = mysqli_query($conexion,"UPDATE tiposmodulosiot SET tipomoduloIoT='$tipomoduloIoT', descripcion='$descripcion', referencia='$referencia' WHERE idtipomoduloiot='$idtipomoduloiot'");
				

				if($sql_update){
					//$alert='<p class="msg_save">Usuario Actualizado Correctamente</p>';
					header('location: lista_tiposdispositivosIoT.php');
				}else{
					$alert='<p class="msg_error">Error al actualizar el dispositivo IoT</p>';
				}
			}
		}
	}


	//Mostrar Datos Recibidos de Get
	if (empty($_REQUEST['id'])){
		mysqli_close($conexion);
		header('location: lista_tiposdispositivosIoT.php');
	}
	$idtipmodIoT=$_REQUEST['id'];
	$sql=mysqli_query($conexion,"SELECT idtipomoduloiot, tipomoduloIoT, descripcion, referencia  FROM tiposmodulosIoT WHERE (idtipomoduloiot=$idtipmodIoT AND status=1)");
	mysqli_close($conexion);
	$result_sql=mysqli_num_rows($sql);
	if ($result_sql==0){
		header('location: lista_tiposdispositivosIoT.php'); 
	}else{
		while ($data=mysqli_fetch_array($sql)) {
			$idtipmodIoT=$data['idtipomoduloiot'];
			$tipomoduloIoT=$data['tipomoduloIoT'];
			$descripcion=$data['descripcion'];
			$referencia=$data['referencia'];
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php  include "includes/scripts.php"; ?> 
	<title>Actualizar Tipo de Dispositivo IoT</title>
</head>

<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar Tipo de Dispositivo IoT</h1>
			<hr>
			<div class="alert"> <?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<input type="hidden" name="id" value="<?php echo $idtipmodIoT; ?>">
				<label for='tipomoduloIoT'>Tipo de Dispositivo IoT</label>
				<input type="text" name="tipomoduloIoT" id="tipomoduloIoT" placeholder="Tipo de modulo IoT" value="<?php echo $tipomoduloIoT; ?>">
				<label for='descripcion'>Descripción</label>
				<input type="text" name="descripcion" id="descripcion" placeholder="Descripción" value="<?php echo $descripcion; ?>">
				<label for="referencia">Referencia</label>
				<input type="text" name="referencia" id="referencia" placeholder="Referencia" value="<?php echo $referencia; ?>">
				<br>
				<input type="submit" value="Actualizar Tipo de Dispositivo IoT" class="btn_save">
				<br>
				<a class="btn_cancel" href="lista_tiposdispositivosIoT.php">Cancelar</a>
			</form>
		</div>
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>