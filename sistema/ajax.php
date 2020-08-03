<?php  

	include "../conexion.php";
	session_start();
	//print_r($_POST);
	//exit;

	if(!empty($_POST)){

		//Extraer datos del producto
		if($_POST['action']=='infoProducto'){
			$producto_id=$_POST['producto'];
			$query=mysqli_query($conexion,"SELECT idproducto, nombre, descripcion FROM producto WHERE idproducto='$producto_id' AND status=1");
			mysqli_close($conexion);

			$result=mysqli_num_rows($query);
			if($result>0){
				$data=mysqli_fetch_assoc($query);
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
				exit;
			}
			echo 'Error';
			exit;
		}

		//Agregar productos a entrada
		if($_POST['action']=='addProduct'){
			//echo "Agregar Producto";
			
			if(!empty($_POST['cantidad']) || !empty($_POST['precio']) || !empty($_POST['producto_id'])){
				$cantidad=$_POST['cantidad'];
				$precio=$_POST['precio'];
				$producto_id=$_POST['producto_id'];
				$usuario_id=$_SESSION['idUser'];

				$query_insert=mysqli_query($conexion,"INSERT INTO entradas (idproducto, cantidad, precio, usuario_id) VALUES ('$producto_id', '$cantidad', '$precio', '$usuario_id')");
				if($query_insert){
					//ejecutar procedimiento almacenado
					$query_upd=mysqli_query($conexion,"CALL actualizar_precio_producto($cantidad, $precio, $producto_id)");
					$result_pro=mysqli_num_rows($query_upd);
					if ($result_pro>0){
						$data=mysqli_fetch_assoc($query_upd);
						$data['producto_id']=$producto_id;
						
						echo json_encode($data, JSON_UNESCAPED_UNICODE);
						exit;
					}
				}else{
					echo 'Error';
				}
				mysqli_close($conexion);
			}else{
				echo 'Error campos vacios.';
			}
			exit;
		}

		//Eliminar producto
		if($_POST['action']=='delProduct'){
			if(empty($_POST['producto_id']) || !is_numeric($_POST['producto_id'])){
				echo 'Error';
			}else{
				$idproducto=$_POST['producto_id'];
				$query_delete=mysqli_query($conexion,"UPDATE producto SET status=0 WHERE idproducto=$idproducto");
				mysqli_close($conexion);

				if($query_delete){
					header("location: lista_productos.php");
				}else{
					echo("Error al eliminar producto");
				}
			}
			exit;
		}
		
	}
	exit;
?>