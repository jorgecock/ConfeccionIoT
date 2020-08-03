 <?php
	//Registro TipodedispositivoIoT

	include "includes/scripts.php";
	session_start();
	//if($_SESSION['rol']!=1){
	//	header("location: ./");
	//}
	

	if (!empty($_POST)) 
	{
		$alert='';
		$tipomoduloIoT=$_POST['tipomoduloIoT'];
		$descripcion=$_POST['descripcion'];
		$referencia=$_POST['referencia'];

		if (empty($_POST['tipomoduloIoT']) || empty($_POST['referencia'])) 
		{
			$alert='<p class="msg_error">Los campos Tipo Dispositivo y Referencia son obligatorios</p>';
		}else{
			include "../conexion.php";
			$query= mysqli_query($conexion,"SELECT * FROM tiposmodulosiot WHERE (referencia='$referencia' AND status=1)");
			$result=mysqli_fetch_array($query);
			if ($result>0){
				$alert='<p class="msg_error">El tipo de dispositivo ya existe, no puede haber dos tipos de dispositivos con la misma referencia.</p>';
			}else{
				$query_insert = mysqli_query($conexion,"INSERT INTO tiposmodulosiot (tipomoduloIoT,descripcion,referencia)
					VALUES ('$tipomoduloIoT','$descripcion','$referencia')");
				if($query_insert){
					mysqli_close($conexion);
					header('location: lista_tiposdispositivosIoT.php');
				}else{
					$alert='<p class="msg_error">Error al crear tipo de modulo</p>';
				}
			}
			mysqli_close($conexion);
		}
	}else{
		$tipomoduloIoT='';
		$descripcion='';
		$referencia='';
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registro de Tipo de Dispositivo IoT</title>
</head>

<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Registro de Tipo de Dispositivo IoT</h1>
			<hr>
			<div class="alert"> <?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<label for='tipomoduloIoT'>Tipo de Dispositivo IoT</label>
				<input type="text" name="tipomoduloIoT" id="tipomoduloIoT" placeholder="Tipo de módulo IoT" value="<?php echo $tipomoduloIoT; ?>">
				<label for='descripcion'>Descripción</label>
				<input type="text" name="descripcion" id="descripcion" placeholder="Descripcion" value="<?php echo $descripcion; ?>">
				<label for="referencia">Referencia</label>
				<input type="text" name="referencia" id="referencia" placeholder="Referencia" value="<?php echo $referencia; ?>">
				<br>
				<input type="submit" value="Crear Tipo Dispositivo IoT" class="btn_save">
				<br>
				<a class="btn_cancel" href="lista_tiposdispositivosIoT.php">Cancelar</a>
			</form>
		</div>
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>