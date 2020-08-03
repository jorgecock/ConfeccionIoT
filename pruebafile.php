<?php
	if (!empty($_POST)){
		if (empty($_POST['nombre'])){
			echo("Debe llenar nombre");
		} else {
			echo("hola ");
			$nombre=$_POST['nombre'];
			$foto=$_FILES["foto"];
			print_r($foto);
		}			
	} else{
		echo("no hay datos");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PruebaFile</title>
</head>

<body>
	<form action="" method="post" enctype="multipart/form-data">
		<label for='nombre'>Nombre</label>
		<input type="text" name="nombre" id="nombre" placeholder="Nombre">
		<label for="foto">Foto</label>
		<input type="file" name="foto" id="foto" accept="image/png, .jpeg, .jpg, image/gif">
		<input type="submit" value="Enviar">
	</form>
</body>
</html>
