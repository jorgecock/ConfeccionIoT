<?php
	session_start();
	//if($_SESSION['rol']!=1){
	//	header("location: ./");
	//}
	include "includes/scripts.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Productos</title>
</head>
<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		<?php 
			$busqueda=strtolower($_REQUEST['busqueda']);
			if(empty($busqueda)){
				header("location: lista_productos.php");
			}
		 ?>

		<h1>Productos</h1>
		<a href="registro_producto.php" class="btn_new">Crear usuario</a>
		
		
		<form action="buscar_producto.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" value="<?php echo $busqueda; ?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Referencia</th>
				<th>Descripción</th>
				<th>Precio</th>
				<th>Existencia</th>
				<th>Usuario creador</th>
				<th>Fecha Creación</th>
				<th>Foto</th>
				<th>Acciones</th>
			</tr>

			<?php
				//paginador
				include "../conexion.php";
				$sql_register=mysqli_query($conexion,"
					SELECT COUNT(*) as total_registro 
					FROM producto u INNER JOIN usuario r ON u.usuario_id=r.idusuario
					WHERE (u.idproducto LIKE '%$busqueda%' OR u.nombre LIKE '%$busqueda%' OR u.referencia LIKE '%$busqueda%' OR u.descripcion LIKE '%$busqueda%' OR u.precio LIKE '%$busqueda%' OR r.nombre LIKE '%$busqueda%' OR u.created_at LIKE '%$busqueda%') AND u.status=1");
				include "calculonumpaginas.php";

				//Crear lista
				$query = mysqli_query($conexion,"
					SELECT u.idproducto, u.nombre AS 'nombreproducto', u.referencia, u.descripcion, u.precio, u.existencia, r.nombre AS 'nombreusuario', u.created_at, u.foto 
					FROM producto u INNER JOIN usuario r ON u.usuario_id = r.idusuario 
					WHERE (u.idproducto LIKE '%$busqueda%' OR u.nombre LIKE '%$busqueda%' OR u.referencia LIKE '%$busqueda%' OR u.descripcion LIKE '%$busqueda%' OR u.precio LIKE '%$busqueda%' OR r.nombre LIKE '%$busqueda%' OR u.created_at LIKE '%$busqueda%') AND u.status=1 
					ORDER BY u.idproducto ASC LIMIT $desde,$por_pagina");
				mysqli_close($conexion);
				$result = mysqli_num_rows($query);
				
				//Desplegar lista
				if($result>0){
					while ($data=mysqli_fetch_array($query)) {
						if(strval($data['foto'])!="img_producto.png"){
							$foto='img/productos/'.$data['foto']; //nombre de archivo de foto guardada
						}else{
							$foto='img/img_producto.png'; //foto por defecto
						}
						?>
							<tr class="row<?php echo $data['idproducto']; ?>">
								<td><?php echo $data['idproducto']; ?></td>
								<td><?php echo $data['nombreproducto']; ?></td>
								<td><?php echo $data['referencia']; ?></td>
								<td><?php echo $data['descripcion']; ?></td>
								<td class="celPrecio"><?php echo $data['precio']; ?></td>
								<td class="celExistencia"><?php echo $data['existencia']; ?></td>
								<td><?php echo $data['nombreusuario']; ?></td>
								<td><?php echo $data['created_at']; ?></td>
								<td class="img_producto"><img src="<?php echo $foto; ?>" alt="<?php echo $data['nombre']; ?>"></td>
								
								<?php 
									//verificacion de usuario
									if($_SESSION['rol']==1 || $_SESSION['rol']==4){ ?>
								<td>
									<a class="link_add add_product" product="<?php echo $data['idproducto']; ?>" href="#"><i class="fas fa-plus"></i> Agregar</a>
									| 
									<a class="link_edit" href="editar_producto.php?id=<?php echo $data['idproducto']; ?>"><i class="far fa-edit"></i> Editar</a>
									|  
									<a class="link_delete del_product" href="#" product="<?php echo $data['idproducto']; ?>"><i class="far fa-trash-alt"></i> Eliminar</a>
								</td>
								<?php } ?>
							</tr>
						<?php
					}
				}
			?>
		</table>
		<?php include "paginador.php"; ?>
	</section>
	<?php  include "includes/footer.php"; ?>
</body>
</html>