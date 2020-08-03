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
	<title>Cliente</title>
</head>
<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		<?php 
			$busqueda=strtolower($_REQUEST['busqueda']);
			if(empty($busqueda)){
				header("location: lista_clientes.php");
			}
		 ?>

		<h1>Clientes</h1>
		<a href="registro_cliente.php" class="btn_new">Crear Cliente</a>
		
		
		<form action="buscar_cliente.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" value="<?php echo $busqueda; ?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>Nit</th>
				<th>Nombre</th>
				<th>Telefono</th>
				<th>Dirección</th>
				<th>Usuario creador</th>
				<th>Fecha de creación</th>				
				<th>Acciones</th>
			</tr>

			<?php
				include "../conexion.php";
				//paginador
				$sql_register=mysqli_query($conexion,"
					SELECT COUNT(*) as total_registro 
					FROM cliente u INNER JOIN usuario r ON u.usuario_id=r.idusuario 
					WHERE ((u.idcliente LIKE '%$busqueda%' OR u.nit LIKE '%$busqueda%' OR u.nombre LIKE '%$busqueda%' OR u.telefono LIKE '%$busqueda%' OR u.direccion LIKE '%$busqueda%' OR r.nombre LIKE '%$busqueda%' OR u.dateadd LIKE '%$busqueda%') AND u.status=1)");
				include "calculonumpaginas.php";

				//Crear lista
				$query = mysqli_query($conexion,"
					SELECT u.idcliente, u.nit, u.nombre AS'nombreempresa', u.telefono, u.direccion, r.nombre AS 'nombreusuario', u.dateadd 
					FROM cliente u INNER JOIN usuario r ON u.usuario_id = r.idusuario 
					WHERE ((u.idcliente LIKE '%$busqueda%' OR u.nit LIKE '%$busqueda%' OR u.nombre LIKE '%$busqueda%' OR u.telefono LIKE '%$busqueda%' OR u.direccion LIKE '%$busqueda%' OR r.nombre LIKE '%$busqueda%' OR u.dateadd LIKE '%$busqueda%') AND u.status=1) 
					ORDER BY u.idcliente ASC LIMIT $desde,$por_pagina");
				mysqli_close($conexion);
				$result = mysqli_num_rows($query);
				
				//Desplegar lista
				if($result>0){
					while ($data=mysqli_fetch_array($query)) {
						?>
							<tr>
								<td><?php echo $data['idcliente']; ?></td>
								<td><?php echo $data['nit']; ?></td>
								<td><?php echo $data['nombreempresa']; ?></td>
								<td><?php echo $data['telefono']; ?></td>
								<td><?php echo $data['direccion']; ?></td>
								<td><?php echo $data['nombreusuario']; ?></td>
								<td><?php echo $data['dateadd']; ?></td>

								<td>
									<a class="link_edit" href="editar_cliente.php?id=<?php echo $data['idcliente']; ?>">Editar</a>
									|  
									<a class="link_delete" href="eliminar_confirmar_cliente.php?id=<?php echo $data['idcliente']; ?>">Eliminar</a>
										
								</td>
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