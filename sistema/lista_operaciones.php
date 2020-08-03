<?php
	session_start(); 
	//if($_SESSION['rol']!=1){
	//	header("location: ./");
	//}
	include "../conexion.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php  include "includes/scripts.php"; ?>
	<title>Operaciones</title>
</head>
<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		<h1>Operaciones</h1>
		<a href="registro_operacion.php" class="btn_new">Crear Operación</a>
		
		<form action="buscar_operacion.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Correo</th>
				<th>Usuario</th>
				<th>Rol</th>
				<th>Acciones</th>
			</tr>

			<?php
				//paginador
				$sql_register=mysqli_query($conexion,"SELECT COUNT(*) as total_registro FROM usuario WHERE status=1");
				include "calculonumpaginas.php";


				//Crear lista
				$query = mysqli_query($conexion,"SELECT u.idusuario, u.nombre, u.correo, u.usuario, r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE status=1 ORDER BY idusuario ASC LIMIT $desde,$por_pagina");
				$result = mysqli_num_rows($query);
				if($result>0){
					while ($data=mysqli_fetch_array($query)) {
						?>
							<tr>
								<td><?php echo $data['idusuario']; ?></td>
								<td><?php echo $data['nombre']; ?></td>
								<td><?php echo $data['correo']; ?></td>
								<td><?php echo $data['usuario']; ?></td>
								<td><?php echo $data['rol']; ?></td>
								<td>
									<a class="link_edit" href="editar_operacion.php?id=<?php echo $data['idusuario']; ?>">Editar</a>
									
									<?php if($data['idusuario']!=1){ ?>
										|  <a class="link_delete" href="eliminar_confirmar_operacion.php?id=<?php echo $data['idusuario']; ?>">Eliminar</a>
										<?php
										} 
									?>
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