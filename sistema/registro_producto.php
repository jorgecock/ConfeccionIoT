<?php
	//Registro producto

	include "includes/scripts.php";
	session_start();
	//if($_SESSION['rol']!=1){
	//	header("location: ./");
	//}
	

	if (!empty($_POST)) 
	{
		$alert='';
		if (empty($_POST['nombre']) || empty($_POST['referencia']) || empty($_POST['precio']) || empty($_POST['existencia'])) 
		{
			$alert='<p class="msg_error">Los campos, Nombre, Referencia, Precio y Existencia son obligatorios</p>';
		}else{
			$nombre=$_POST['nombre'];
			$referencia=$_POST['referencia'];
			$descripcion=$_POST['descripcion'];
			$precio=$_POST['precio'];
			$existencia=$_POST['existencia'];
			$foto=$_FILES['foto'];
			$nombre_foto=$foto['name'];
			$type=$foto['type'];
			$url_temp=$foto['tmp_name'];
			$size=$foto['size'];
			$imgProducto='img_producto.png';
			$usuario_id=$_SESSION['idUser'];

			if ($nombre_foto !='')
			{
				$destino='img/uploads/';
				$img_nombre ='img_'.md5(date('d-m-Y H:m:s'));
				$imgProducto=$img_nombre.'.jpg';
				$src=$destino.$imgProducto;
			}

			include "../conexion.php";
			$query= mysqli_query($conexion,"SELECT * FROM producto WHERE ((referencia='$referencia' OR nombre='$nombre') AND status=1)");
			$result=mysqli_fetch_array($query);
			mysqli_close($conexion);

			if ($result>0){
				$alert='<p class="msg_error">El nombre del producto o la referencia ya existen</p>';
			}else{
				include "../conexion.php";
				$query_insert = mysqli_query($conexion,"INSERT INTO producto (nombre,referencia,descripcion,precio,existencia,foto, usuario_id)
					VALUES ('$nombre','$referencia','$descripcion','$precio','$existencia','$imgProducto', '$usuario_id')");
				mysqli_close($conexion);
				if($query_insert){
					if ($nombre_foto !='')
					{
						move_uploaded_file($url_temp,$src);
					} 
					//$alert='<p class="msg_save">Producto creado Correctamente</p>';
					header('location: lista_productos.php');
 				}else{
					$alert='<p class="msg_error">Error al crear el producto</p>';
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registro de Productos</title>
</head>

<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Registro de Productos</h1>
			<hr>
			<div class="alert"> <?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id">
				<label for='nombre'>Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre del Producto">
				<label for='referencia'>Referencia</label>
				<input type="text" name="referencia" id="referencia" placeholder="Referencia">
				<label for="descripcion">Descripción</label>
				<input type="text" name="descripcion" id="descripcion" placeholder="Descripción">
				<label for="precio">Precio</label>
				<input type="number" name="precio" id="precio" placeholder="Precio">
				<label for="existencia">Existencia</label>
				<input type="number" name="existencia" id="existencia" placeholder="Existencia">
				<div class="photo">
					<label for="foto">Foto</label>
			        <div class="prevPhoto">
			        <span class="delPhoto notBlock">X</span>
			        <label for="foto"></label>
			        </div>
			        <div class="upimg">
			        <input type="file" name="foto" id="foto" accept="image/png, .jpeg, .jpg, image/gif">
			        </div>
			        <div id="form_alert"></div>
				</div>
				<br>
				<button type="submit" class="btn_save"><i class="far fa-save fa-lg"></i> Crear Producto</button>
				<br>
				<a class="btn_cancel" href="lista_productos.php">Cancelar</a>
			</form>
		</div>
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>