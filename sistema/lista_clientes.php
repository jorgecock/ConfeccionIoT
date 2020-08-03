<?php
	//Lista Clientes
	
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
	<title>Clientes</title>
</head>
<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		<h1>Clientes</h1>
		<a href="registro_cliente.php" class="btn_new">Crear Cliente</a>
		
		<form action="buscar_cliente.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda">
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
				$sql_register=mysqli_query($conexion,"SELECT COUNT(*) as total_registro FROM cliente WHERE status=1");
				include "calculonumpaginas.php";

				//Crear lista
				$query = mysqli_query($conexion,"SELECT u.idcliente, u.nit, u.nombre AS'nombreempresa', u.telefono, u.direccion, r.nombre AS 'nombreusuario', u.dateadd FROM cliente u INNER JOIN usuario r ON u.usuario_id = r.idusuario WHERE u.status=1 ORDER BY u.idcliente ASC LIMIT $desde,$por_pagina");
				mysqli_close($conexion);
				$result = mysqli_num_rows($query);
				if($result>0){
					while ($data=mysqli_fetch_array($query)) {
						if($data['nit']==0){
							$nit='C/F';
						}else{
							$nit=$data['nit'];
						}

						?>
							<tr>
								<td><?php echo $data['idcliente']; ?></td>
								<td><?php echo $nit; ?></td>
								<td><?php echo $data['nombreempresa']; ?></td>
								<td><?php echo $data['telefono']; ?></td>
								<td><?php echo $data['direccion']; ?></td>
								<td><?php echo $data['nombreusuario']; ?></td>
								<td><?php echo $data['dateadd']; ?></td>

								<td>
									<a class="link_edit" href="editar_cliente.php?id=<?php echo $data['idcliente']; ?>">Editar</a>
									<?php
										//solo se permite acceso a Admin y a Administrador
										if($_SESSION['rol']==1 || $_SESSION['rol']==5){ ?>
											| <a class="link_delete" href="eliminar_confirmar_cliente.php?id=
											<?php echo $data['idcliente']; ?>">Eliminar</a>
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