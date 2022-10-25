<?php
//file: personal_area.php

session_start();

// security check ...
if ( !isset($_SESSION["currentuser"]) ){
  echo "Not in session, this is a restricted area<br>";
  echo "<a href='../users/login.php'>Go to login.php</a>";
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
		<link rel="stylesheet" href="../../css/personal_area.css" media="screen">
		
		<!-- highcharts stuff -->
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/series-label.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>
		<script src="https://code.highcharts.com/modules/accessibility.js"></script>

		<!-- docReady function, which allows us to run javascript when DOM is ready -->
		<script src="docready.js"></script>

		<!-- my JavaScript code, which adds the charts to 'container' using highcharts -->
		<script src="charts.js"></script>
		
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oxanium">
		<title>main</title>

	</head>
	<body data-lang="es">

		<?php
		include('../layout/header.php');
		?>
			<p class="texto">Esto es una pequeña explicacion de lo que deberia
			pasar, ademas aqui tienes una tabla completamente copiada:</p>
			<p class="texto">Hola <?= $_SESSION["currentuser"] ?>, estás en tu area personal de SaveYourMoney. Por Manu, Lander y Mario<br></p>
			
			<div class="chart">
				<figure class="highcharts-figure">
					<div id="container"></div>
						<p class="highcharts-description">
							Gastos en los últimos doce meses, separado por tipo de gasto.
						</p>
				</figure>
			</div>
		
<<<<<<< HEAD
		<div class="chart">
			<figure class="highcharts-figure">
				<div id="container"></div>
					<p class="highcharts-description">
						Gastos en los últimos doce meses, separado por tipo de gasto.
					</p>
			</figure>
		</div>
	  
        <p class="texto"><a href="../users/logout.php">Cerrar la sesión</a></p>
    
		<footer>
			<div>
				<p>SaveYourMoney creado por Manuel Márquez, Mario López y Lander Lluvia. </p>
			</div>
		</footer>
=======
			<p class="texto"><a href="logout.php">Cerrar la sesión</a></p>
		
			<footer>
				<div>
					<p>SaveYourMoney creado por Manuel Márquez, Mario López y Lander Lluvia. </p>
				</div>
			</footer>
>>>>>>> 21f4ec9a110b69cf3e1c2733d2936ff75a749116
	</body>
</html>

