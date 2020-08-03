<?php
	session_start(); 
	if($_SESSION['rol']!=1){
		header("location: ./");
	}
	include "../conexion.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php  include "includes/scripts.php"; ?>
	<title>Plantas</title>
</head>
<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		<h1>Plantas</h1>
		<a href="registro_planta.php" class="btn_new">Crear Planta</a>
		
		<form action="buscar_planta.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Direccion</th>
				<th>Codigo</th>
				<th>Ciudad</th>
				<th>Teléfono</th>
				<th>Acciones</th>
			</tr>

			<?php
				//paginador
				$sql_register=mysqli_query($conexion,"SELECT COUNT(*) as total_registro FROM plantas WHERE status=1");
				include "calculonumpaginas.php";
				
				//Crear lista
				$query = mysqli_query($conexion,"SELECT idplanta, nombre, direccion, codigo, ciudad, telefono FROM plantas WHERE status=1 ORDER BY idplanta ASC LIMIT $desde,$por_pagina");
				mysqli_close($conexion);
				$result = mysqli_num_rows($query);
				if($result>0){
					while ($data=mysqli_fetch_array($query)) {
						?>
							<tr>
								<td><?php echo $data['idplanta']; ?></td>
								<td><?php echo $data['nombre']; ?></td>
								<td><?php echo $data['direccion']; ?></td>
								<td><?php echo $data['codigo']; ?></td>
								<td><?php echo $data['ciudad']; ?></td>
								<td><?php echo $data['telefono']; ?></td>
								<td>
									<a class="link_edit" href="editar_planta.php?id=<?php echo $data['idplanta']; ?>">Editar</a>
									|  
									<a class="link_delete" href="eliminar_confirmar_planta.php?id=<?php echo $data['idplanta']; ?>">Eliminar</a>
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