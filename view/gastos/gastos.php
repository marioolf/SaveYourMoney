<?php

// file: gastos.php

require_once("../../core/PDOConnection.php");
$db=PDOConnection::getInstance();

session_start();

if ( !isset($_SESSION["currentuser"]) ){
	echo "No has iniciado sesion<br>";
	echo "<a href='./users/login.php'>Logeate</a>";
	die();
  }

//Instanciamos el usuario
$currentuser = null;
if (isset($_SESSION["currentuser"]) ){
  $currentuser = $_SESSION["currentuser"];
}

//Cargamos los gastos
try {

    $stmt = $db->query("SELECT * FROM gastos ORDER BY fecha");  
    $gastos = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  } catch(PDOException $ex) {
    die("exception! ".$ex->getMessage());
  }
  
?>


<html lang="es">
	<head>
		<meta charset="UTF-8"></meta>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="./../../css/style.css" type="text/css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oxanium">
		<title>gastos</title>

	</head>

	<?php
			include('./../layouts/header.php');
	?>

	<body class="bodygastos" data-lang="es">
		
		<div class="container">
			<h1 class="texto">Gastos</h1>
		
			<table class="tablagastos">
				<tr>
					<th>Nombre</th>
					<th>Descripcion</th>
					<th>Importe</th>
					<th>Tipo de gasto</th>
					<th>Fecha</th>
					<th>Acciones</th>
				</tr>
			
			<?php foreach ($gastos as $gasto) : ?>
				<?php if ($gasto["author"] == $currentuser): 
					//Mostramos solo los gastos del usuario logeado
				?>
					
				<tr>	    
				<td>
					<a href="vista_gastos.php?id=<?= $gasto["id"] ?>"><?= htmlentities($gasto["nombre"]) ?>
				</td>
				<td>
				<?= $gasto["descr"] ?>
				</td>
				<td>
				<?= $gasto["importe"] ?> €
				</td>
				<td>
				<?= $gasto["tipo"] ?>
				</td>
				<td>
				<?= $gasto["fecha"] ?>
				</td>
				<td>&nbsp;
				
				<?php endif ?>

				<?php if (isset($currentuser) && ($gasto["author"] == $currentuser)): ?>
				
					<?php 
					//Boton Borrar
					?>
				<form 		    
					method="POST" 
					action="eliminar_gastos.php" 
					id="eliminar_gastos_<?= $gasto["id"]; ?>"
					style="display: inline" 
					>
				
					<input type="hidden" name="id" value="<?= $gasto["id"] ?>">
				
					<a href="#" 
					onclick="
					if (confirm('Estas seguro de borrar el gasto?')) {
						document.getElementById('eliminar_gastos_<?= $gasto["id"] ?>').submit() }" > Eliminar </a>
				
				</form>
				
				&nbsp;
				
				<?php 
				// Boton Editar
				?>		  
				<a href="editar_gastos.php?id=<?= $gasto["id"] ?>" > Editar </a>
				
				<?php endif; ?>

				</td>
				</tr> 


			<?php endforeach; ?>
			
			</table>
			
			<?php if (isset($currentuser)): ?>
			<p class="texto"><a href="añadir_gastos.php">Create gasto</a></p>
			<?php endif; ?>
		</div>
	</body>
	
</html>
