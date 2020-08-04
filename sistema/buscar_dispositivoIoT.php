<?php
	//Busqueda Dispositivo IoT

	//Validar usuario con acceso a este módulo
	session_start();
	//if($_SESSION['rol']!=1){
	//	header("location: ./");
	//}	

	include "includes/scripts.php";

	$busqueda=strtolower($_REQUEST['busqueda']);
	if(empty($busqueda)){
		header("location: lista_usuarios.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Dispositivos IoT</title>
</head>
<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		<h1>Dispositivos IoT</h1>
		<a href="registro_dispositivoIoT.php" class="btn_new">Crear Disposito IoT</a>
		
		<form action="buscar_dispositivoIoT.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" value="<?php echo $busqueda; ?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>ID</th>
				<th>Dirección</th>
				<th>Nombre</th>
				<th>Localización</th>
				<th>Serie</th>
				<th>Referencia</th>
				<th>Fecha Creación</th>
				<th>Usuario Creador </th>
				<th>Acciones</th>
			</tr>

			<?php
				//paginador
				include "../conexion.php";
				$sql_register=mysqli_query($conexion,"
					SELECT COUNT(*) as total_registro 
					FROM moduloiot u 
					INNER JOIN tiposmodulosiot r ON u.idtipomoduloiot=r.idtipomoduloiot
					INNER JOIN usuario m ON u.usuario_id = m.idusuario 
					WHERE (m.nombre LIKE '%$busqueda%' OR u.nombre LIKE '%$busqueda%' OR u.localizacion LIKE '%$busqueda%' OR u.direccion LIKE '%$busqueda%' OR u.serie LIKE '%$busqueda%' OR r.referencia LIKE '%$busqueda%') AND u.status=1");
				include "calculonumpaginas.php";

				//Crear lista
				$query = mysqli_query($conexion,"
					SELECT u.idmoduloIoT, u.direccion, u.nombre AS 'nombremoduloiot', u.localizacion, u.serie, r.referencia, u.created_at, m.nombre AS 'nombreusuariocreador'
					FROM moduloiot u 
					INNER JOIN tiposmodulosiot r ON u.idtipomoduloiot=r.idtipomoduloiot
					INNER JOIN usuario m ON u.usuario_id = m.idusuario   
					WHERE (m.nombre LIKE '%$busqueda%' OR u.nombre LIKE '%$busqueda%' OR u.localizacion LIKE '%$busqueda%' OR u.direccion LIKE '%$busqueda%' OR u.serie LIKE '%$busqueda%' OR r.referencia LIKE '%$busqueda%') AND u.status=1 ORDER BY u.idmoduloIoT ASC LIMIT $desde,$por_pagina");
				mysqli_close($conexion);
				
				$result = mysqli_num_rows($query);
				if($result>0){
					while ($data=mysqli_fetch_array($query)) {
						$formato='Y-m-d H:i:s';
						$fecha= DateTime::createFromFormat($formato,$data['created_at']);
						?>
							<tr>
								<td><?php echo $data['idmoduloIoT']; ?></td>
								<td><?php echo $data['direccion']; ?></td>
								<td><?php echo $data['nombremoduloiot']; ?></td>
								<td><?php echo $data['localizacion']; ?></td>
								<td><?php echo $data['serie']; ?></td>
								<td><?php echo $data['referencia']; ?></td>
								<td><?php echo $fecha->format('Y-m-d'); ?></td>
								<td><?php echo $data['nombreusuariocreador']; ?></td>
								<td>
									<a class="link_edit" href="editar_dispositivoIoT.php?id=<?php echo $data['idmoduloIoT']; ?>">Editar</a>
									|  
									<a class="link_delete" href="eliminar_confirmar_dispositivoIoT.php?id=<?php echo $data['idmoduloIoT']; ?>">Eliminar</a>
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