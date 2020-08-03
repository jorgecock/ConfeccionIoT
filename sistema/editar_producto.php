<?php
	//Registro producto

	include "includes/scripts.php";
	session_start();
	//if($_SESSION['rol']!=1){
	//	header("location: ./");
	//}
	
	//validar desde post luego de dar submit
	if (!empty($_POST)) 
	{
		$alert='';
		if (empty($_POST['nombre']) || empty($_POST['referencia']) || empty($_POST['precio']) || empty($_POST['id']) || empty($_POST['foto_actual']) || empty($_POST['foto_remove'])) 
		{
			$alert='<p class="msg_error">Los campos, Nombre, Referencia, Precio y Existencia son obligatorios</p>';
		}else{

			$idproducto=$_POST['id'];
			$imgProducto=$_POST['foto_actual'];
			$imgRemove=$_POST['foto_remove'];
			$nombre=$_POST['nombre'];
			$referencia=$_POST['referencia'];
			$descripcion=$_POST['descripcion'];
			$precio=$_POST['precio'];
			$foto=$_FILES['foto'];
			$nombre_foto=$foto['name'];
			$type=$foto['type'];
			$url_temp=$foto['tmp_name'];
			$size=$foto['size'];
			$usuario_id=$_SESSION['idUser'];
			$upd='';

			if ($nombre_foto !='')
			{
				$destino='img/productos/';
				$img_nombre ='img_'.md5(date('d-m-Y H:m:s'));
				$imgProducto=$img_nombre.'.jpg';
				$src=$destino.$imgProducto;
			}else{
				if($_POST['foto_actual']!=$_POST['foto_remove']){
					$imgProducto='img_producto.png';
				}
			}

			include "../conexion.php";
			$query_update= mysqli_query($conexion,"UPDATE producto 
								SET nombre='$nombre', referencia='$referencia', descripcion='$descripcion', precio=$precio,foto= '$imgProducto'
								WHERE idproducto=$idproducto");
			mysqli_close($conexion);

			if($query_update){

				if(($nombre_foto !='' && ($_POST['foto_actual']!='img_producto.png')) || ($_POST['foto_actual']!=$_POST['foto_remove'])){
					echo("Borrar fichero"); echo ($_POST['foto_actual']);
					unlink('img/productos/'.$_POST['foto_actual']);//Borra archivo de directorio
				}


				if ($nombre_foto !=''){
					move_uploaded_file($url_temp,$src);
				} 
				//$alert='<p class="msg_save">Producto actualizado Correctamente</p>';
				header('location: lista_productos.php');
 			}else{
					$alert='<p class="msg_error">Error al crear el producto</p>';
			}
		}
	}



	//Validar producto GET desde lista
	if (empty($_REQUEST['id'])){
		header('location: lista_productos.php');
	}else{
		$id_producto=$_REQUEST['id'];
		if(!is_numeric($id_producto)){
			header('location: lista_productos.php');
		}
		include "../conexion.php";
		$query_producto=mysqli_query($conexion,"SELECT idproducto,nombre,descripcion,referencia,precio,foto FROM producto WHERE (idproducto=$id_producto AND status=1)");// 
		mysqli_close($conexion);
		$result=mysqli_num_rows($query_producto);

		$foto='';
		$classRemove='notBlock'; 

		if($result>0){
			$data_producto=mysqli_fetch_assoc($query_producto);
			if($data_producto['foto']!='img_producto.png'){
				$classRemove ='';
				$foto='<img id="img" src="img/productos/'.$data_producto['foto'].'" alt="Producto">';
			}
			//print_r($data_producto);
		}else{
			header('location: lista_productos.php');
		}
	}
		

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Actualizar Productos</title>
</head>

<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar Producto</h1>
			<hr>
			<div class="alert"> <?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $data_producto['idproducto']; ?>">
				<input type="hidden" id="foto_actual" name="foto_actual" value="<?php echo $data_producto['foto']; ?>">
				<input type="hidden" id="foto_remove" name="foto_remove" value="<?php echo $data_producto['foto']; ?>">

				<label for='nombre'>Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre del Producto" value="<?php echo $data_producto['nombre']; ?>">
				<label for='referencia'>Referencia</label>
				<input type="text" name="referencia" id="referencia" placeholder="Referencia" value="<?php echo $data_producto['referencia']; ?>">
				<label for="descripcion">Descripción</label>
				<input type="text" name="descripcion" id="descripcion" placeholder="Descripción" value="<?php echo $data_producto['descripcion']; ?>">
				<label for="precio">Precio</label>
				<input type="number" name="precio" id="precio" placeholder="Precio" value="<?php echo $data_producto['precio']; ?>">
				
				<div class="photo">
					<label for="foto">Foto</label>
			        <div class="prevPhoto">
			        	<span class="delPhoto <?php echo $classRemove; ?>">X</span>
			        	<label for="foto"></label>
			        	<?php echo $foto; ?>
			        </div>
			        <div class="upimg">
			        	<input type="file" name="foto" id="foto" accept="image/png, .jpeg, .jpg, image/gif">
			        </div>
			        <div id="form_alert"></div>
				</div>
				<br>
				<button type="submit" class="btn_save"><i class="far fa-save fa-lg"></i> Actualizar Producto</button>
				<br>
				<a class="btn_cancel" href="lista_productos.php">Cancelar</a>
			</form>
		</div>
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>