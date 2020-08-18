<?php	
	//Registro  Empresa

	include "includes/scripts.php";
	session_start();
	//if($_SESSION['rol']!=1){
	//	header("location: ./");
	//}
	


	$material="";
	$descripcatalogo="";
	$descripbreve="";
	$marca="";
	$ref="";
	$tipomaterial="";
	$mundo="";
	$tipoproducto="";
	$caracteristica1="";
	$caracteristica2="";
	$fit="";
	$categoria="";
	$segmento="";
	$coleccion="";
	$tema="";
	$combiprendas="";
	$diseñador="";


	if (!empty($_POST)) 
	{
		$alert='';
		if (empty($_POST['material']) || empty($_POST['ref'])) 
		{
			$alert='<p class="msg_error">Los campos Material y Referencia son obligatorios</p>';
		}else{
			
			$material=$_POST['material'];
			$descripcatalogo=$_POST['descripcatalogo'];
			$descripbreve=$_POST['descripbreve'];
			$marca=$_POST['marca'];
			$ref=$_POST['ref'];
			$tipomaterial=$_POST['tipomaterial'];
			$mundo=$_POST['mundo'];
			$tipoproducto=$_POST['tipoproducto'];
			$caracteristica1=$_POST['caracteristica1'];
			$caracteristica2=$_POST['caracteristica2'];
			$fit=$_POST['fit'];
			$categoria=$_POST['categoria'];
			$segmento=$_POST['segmento'];
			$coleccion=$_POST['coleccion'];
			$tema=$_POST['tema'];
			$combiprendas=$_POST['combiprendas'];
			$diseñador=$_POST['diseñador'];


			/*
			include "../conexion.php";
			$query= mysqli_query($conexion,"SELECT * FROM usuario WHERE ((usuario='$user' OR correo='$email') AND status=1)");
			$result=mysqli_fetch_array($query);
			if ($result>0){
				$alert='<p class="msg_error">El usuario o el correo ya existe</p>';
			}else{
				$query_insert = mysqli_query($conexion,"INSERT INTO usuario(nombre,correo,usuario,clave,rol)
					VALUES ('$nombre','$email','$user','$clave','$rol')");
				if($query_insert){
					//$alert='<p class="msg_save">Usuario creado Correctamente</p>';
					mysqli_close($conexion);
					*/
					header('location: index.php');
					/*
				}else{
					$alert='<p class="msg_error">Error al crear Información de diseño</p>';
				}
			}
			mysqli_close($conexion);
			*/
		}
	} 
?>	


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registro de Ficha Tecnica</title>
</head>

<body>
	<?php  include "includes/header.php"; ?>

	<section id="container">
		
		<div class="form_register">
			<h1>Registro de Ficha Técnica</h1>
			<hr/>
			<div class="alert"> <?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				
				<label for='material'>Material</label>
				<input type="text" name="material" id="material" placeholder="<?php echo $material; ?>">
				
				<label for='descripcatalogo'>Descripción Catálogo</label>
				<input type="text" name="descripcatalogo" id="descripcatalogo" value="<?php echo $descripcatalogo; ?>">

				<label for='descripbreve'>Descripción Breve</label>
				<input type="text" name="descripbreve" id="descripbreve"  placeholder="<?php echo $descripbreve; ?>">
				
				<label for='marca'>Marca</label>
				<input type="text" name="marca" id="marca"  placeholder="<?php echo $marca; ?>">

				<label for='ref'>Referencia</label>
				<input type="text" name="ref" id="ref"  placeholder="<?php echo $ref; ?>">

				<label for='tipomaterial'>Tipo de Material</label>
				<input type="text" name="tipomaterial" id="tipomaterial"  placeholder="<?php echo $tipomaterial; ?>">

				<label for='mundo'>Mundo</label>
				<input type="text" name="mundo" id="mundo"  placeholder="<?php echo $mundo; ?>">

				<label for='tipoproducto'>Tipo de Producto</label>
				<input type="text" name="tipoproducto" id="tipoproducto"  placeholder="<?php echo $tipoproducto; ?>">

				<label for='caracteristica1'>Característica 1</label>
				<input type="text" name="caracteristica1" id="caracteristica1" placeholder="<?php echo $caracteristica1; ?>">

				<label for='caracteristica2'>Característica 2</label>
				<input type="text" name="caracteristica2" id="caracteristica2"  placeholder="<?php echo $caracteristica2; ?>">

				<label for='fit'>Fit</label>
				<input type="text" name="fit" id="fit"  placeholder="<?php echo $fit; ?>">

				<label for="categoria">Categoría</label>
				<input type="text" name="categoria" id="categoria"  placeholder="<?php echo $categoria; ?>">
				
				<label for="segmento">Segmento</label>
				<input type="text" name="segmento" id="segmento"  placeholder="<?php echo $segmento; ?>">
				
				<label for="coleccion">Colección</label>
				<input type="text" name="coleccion" id="coleccion" placeholderplaceholder="<?php echo $coleccion; ?>">

				<label for="tema">Tema</label>
				<input type="text" name="tema" id="tema"  placeholderplaceholder="<?php echo $tema; ?>">

				<label for="combiprendas">Combinación de prendas</label>
				<input type="text" name="combiprendas" id="combiprendas"  placeholder="<?php echo $combiprendas; ?>">

				<label for="diseñador">Diseñador</label>
				<input type="text" name="diseñador" id="diseñador"  placeholder="<?php echo $diseñador; ?>">

				<br>
				<input type="submit" value="Crear Información de diseño" class="btn_save">
				<br>
				<a class="btn_cancel" href="index.php">Cancelar</a>
			</form>
			<hr/>
			<h1>F-002 - Versión: 02</h1>
		</div>
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>