<?php
	session_start(); 
	//if($_SESSION['rol']!=1){
	//	header("location: ./");
	//}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php  include "includes/scripts.php"; ?>
	<title>Máquinas</title>
</head>
<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		<h1>Máquinas</h1>
		<a href="registro_maquina.php" class="btn_new">Crear Máquina</a>
		
		<form action="buscar_maquina.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>Módulo</th>
				<th>Serial</th>	
				<th>Nombre</th>
				<th>Lim A. MA</th>
				<th>Lim A. ME</th>
				<th>MTTF</th>
				<th>MTBF</th>	
				<th>Tipo</th>
				<th>Estado</th>
				<th>C.Costos</th>
				<th>Descripción</th>	
				<th>Fecha de compra</th>
				<th>Acciones</th>
			</tr>

			<?php
				//paginador
				include "../conexion.php";
				$sql_register=mysqli_query($conexion,"SELECT COUNT(*) as total_registro FROM maquinas WHERE status=1");
				include "calculonumpaginas.php";


				//Crear lista
				$query = mysqli_query($conexion,"SELECT u.idmaquina, v.nombre AS 'modulo', u.serial, u.nombre AS 'maquina', u.corriente_encenmotap, u.corriente_encendido, u.MTTF, u.MTBF, u.tipo_maquina, r.estado, u.centrocostos, u.descripcion, u.fechacompra FROM maquinas u JOIN (estadosmaquinas r, modulos v) ON (u.idmodulo = v.idmodulo AND u.idestado=r.idestado)  WHERE u.status=1 ORDER BY u.idmaquina ASC LIMIT $desde,$por_pagina");
				mysqli_close($conexion);
				$result = mysqli_num_rows($query);
				if($result>0){
					while ($data=mysqli_fetch_array($query)) {
						?>
							<tr>
								<td><?php echo $data['idmaquina']; ?></td>
								<td><?php echo $data['modulo']; ?></td>
								<td><?php echo $data['serial']; ?></td>
								<td><?php echo $data['maquina']; ?></td>
								<td><?php echo $data['corriente_encenmotap']; ?></td>
								<td><?php echo $data['corriente_encendido']; ?></td>
								<td><?php echo $data['MTTF']; ?></td>
								<td><?php echo $data['MTBF']; ?></td>
								<td><?php echo $data['tipo_maquina']; ?></td>
								<td><?php echo $data['estado']; ?></td>
								<td><?php echo $data['centrocostos']; ?></td>
								<td><?php echo $data['descripcion']; ?></td>
								<td><?php echo $data['fechacompra']; ?></td>

								<td>
									<a class="link_edit" href="editar_maquina.php?id=<?php echo $data['idmaquina']; ?>">Editar</a>
									|  
									<a class="link_delete" href="eliminar_confirmar_maquina.php?id=<?php echo $data['idmaquina']; ?>">Eliminar</a>
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