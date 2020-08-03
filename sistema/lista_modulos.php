<?php
	//Lista Modulos

	//Validar usuario con acceso a este módulo
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
	<title>Módulos</title>
</head>
<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		<h1>Módulos</h1>
		<a href="registro_modulo.php" class="btn_new">Crear Módulo</a>
		
		<form action="buscar_modulo.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Planta</th>
				<th>Descripción</th>
				<th>Usuario Creador </th>
				<th>Acciones</th>
			</tr>

			<?php
				//paginador
				include "../conexion.php";
				$sql_register=mysqli_query($conexion,"SELECT COUNT(*) as total_registro FROM modulos WHERE status=1");
				include "calculonumpaginas.php";

				//Crear lista
				$query = mysqli_query($conexion,"
					SELECT u.idmodulo, u.nombre AS 'nombremodulo', r.nombre AS 'planta', u.descripcion, m.nombre
					FROM modulos u 
					INNER JOIN plantas r ON u.idplanta = r.idplanta 
					INNER JOIN usuario m ON u.usuario_id = m.idusuario
					WHERE u.status=1 ORDER BY u.idmodulo ASC LIMIT $desde,$por_pagina");
				mysqli_close($conexion);
				$result = mysqli_num_rows($query);
				if($result>0){
					while ($data=mysqli_fetch_array($query)) {
						?>
							<tr>
								<td><?php echo $data['idmodulo']; ?></td>
								<td><?php echo $data['nombremodulo']; ?></td>
								<td><?php echo $data['planta']; ?></td>
								<td><?php echo $data['descripcion']; ?></td>
								<td><?php echo $data['nombre']; ?></td>
								<td>
									<a class="link_edit" href="editar_modulo.php?id=<?php echo $data['idmodulo']; ?>">Editar</a>
									|  
									<a class="link_delete" href="eliminar_confirmar_modulo.php?id=<?php echo $data['idmodulo']; ?>">Eliminar</a>
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