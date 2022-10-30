<?php
//file: personal_area.php
require_once("../../core/PDOConnection.php");
$db=PDOConnection::getInstance();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// security check ...
if ( !isset($_SESSION["currentuser"]) ){
  echo "Not in session, this is a restricted area<br>";
  echo "<a href='./../../index.php'>Go to login.php</a>";
  die();
}



?>

<html lang="es">
	<head>

		<meta charset="UTF-8"></meta>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="./../../css/style.css" type="text/css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oxanium">
		<title>main</title>

	</head>
	<body class="bodypa" data-lang="es">

		<?php
		include('./../layouts/header.php');
		?>

		    

			<p class="textopa">Aqui se muestra una grafica con tus ultimos 12 meses:</p>

			<div id=graf>
		
			<?php include('graficaTarta.php'); ?>
				
			</div>
            <button class = "cambiograf" onclick="location.href = './personal_area.php';">Grafico de Barras</button>
			<p class="textopa">Hola <?= $_SESSION["currentuser"] ?>, estás en tu area personal de SaveYourMoney. Por Manu, Lander y Mario<br></p>
	
	
		</div>
        <p class="textopa"><a href="./../users/logout.php">Cerrar la sesión</a></p>
   
		<footer class="footerpa">
			<div>
				<p>SaveYourMoney creado por Manuel Márquez, Mario López y Lander Lluvia. </p>
			</div>
			
		</footer>
	</body>
</html>

