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
	<title>Tipos de Dispositivos IoT</title>
</head>
<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		<h1>Tipos de Dispositivos IoT</h1>
		<a href="registro_tipodispositivoIoT.php" class="btn_new">Crear Tipo de Disposito IoT</a>

		<form action="buscar_tipodispositivoIoT.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>Tipo de Dispositivo IoT</th>
				<th>Descripción</th>
				<th>Referencia</th>
				<th>Acciones</th>
			</tr>

			<?php
				//paginador
				$sql_register=mysqli_query($conexion,"SELECT COUNT(*) as total_registro FROM tiposmodulosiot WHERE status=1");
				include "calculonumpaginas.php";

				//Crear lista
				$query = mysqli_query($conexion,"SELECT idtipomoduloiot, tipomoduloiot, descripcion, referencia FROM tiposmodulosiot WHERE status=1 ORDER BY idtipomoduloiot ASC LIMIT $desde,$por_pagina");
				$result = mysqli_num_rows($query);
				if($result>0){
					while ($data=mysqli_fetch_array($query)) {
						?>
							<tr>
								<td><?php echo $data['idtipomoduloiot']; ?></td>
								<td><?php echo $data['tipomoduloiot']; ?></td>
								<td><?php echo $data['descripcion']; ?></td>
								<td><?php echo $data['referencia']; ?></td>
								<td>
									<a class="link_edit" href="editar_tipodispositivoIoT.php?id=<?php echo $data['idtipomoduloiot']; ?>">Editar</a>
									|  
									<a class="link_delete" href="eliminar_confirmar_tipodispositivoIoT.php?id=<?php echo $data['idtipomoduloiot']; ?>">Eliminar</a>
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