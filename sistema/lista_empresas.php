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
	<title>Empresas</title>
</head>
<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		<h1>Empresas</h1>
		<a href="registro_empresa.php" class="btn_new">Crear Empresa</a>
		
		<form action="buscar_empresa.php" method="get" class="form_search">
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
				$sql_register=mysqli_query($conexion,"SELECT COUNT(*) as total_registro FROM empresas WHERE status=1");
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
									<a class="link_edit" href="editar_empresa.php?id=<?php echo $data['idempresa']; ?>">Editar</a>
									
									<?php if($data['idempresa']!=1){ ?>
										|  <a class="link_delete" href="eliminar_confirmar_empresa.php?id=<?php echo $data['idempresa']; ?>">Eliminar</a>
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