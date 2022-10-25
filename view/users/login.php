<?php
//file: login.php

require_once("../../core/db_connection.php");
session_start();

if (isset($_POST["username"])){
  //process login form
  try{    
    $stmt = $db->prepare("SELECT count(username) FROM users where username=? and passwd=?");
    $stmt->execute(array($_POST["username"], $_POST["passwd"]));

    if ($stmt->fetchColumn() == 1) {
      // username/password is valid, put the username in _SESSION
      $_SESSION["currentuser"] = $_POST["username"];
      
      // send user to the restricted area (HTTP 302 code)
      header("Location: ../gastos/personal_area.php");
      die();
    }else{
      echo "Username is not valid<br>";
    }
  } catch(PDOException $ex) {
    die("exception! ".$ex->getMessage());
  }
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
		<link rel="stylesheet" href="../../css/login.css" media="screen">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oxanium">
		<title>login</title>

	</head>
	<body data-lang="es">
		<header>
			<div>
				<img class="imagen" src="images/oie_transparent.png">
			</div>
		</header> 
	  
		<p class="texto">SaveYourMoney es una aplicacón que te permitirá hacer un seguimiento de todos tus gastos,
				¡Olvídate de acabar el mes a 0!</p>
	  
			
		<div class="container">

			<form action="login.php" method="POST">
				<label>Usuario : </label>   
				<input type="text" placeholder="Introduce tu usuario" name="username">
				<label>Contraseña : </label>  
				<input type="password" placeholder="Introduce tu contraseña" name="passwd">
				<input type="checkbox" placeholder="Recuerdame" checked="checked">
				<a class="color">Recuerdame</a>

				<button type="submit">Login </button>
			</form>

			<a href="#" class="fpass"> ¿Olvidaste tu contraseña? </a>  
			<p class="texto"><a href="./register.php">Registrate!</a></p>
			
		</div>
    
    

    
    
		<footer>
			<div>
				<p>SaveYourMoney creado por Manuel Márquez, Mario López y Lander Lluvia. </p>
			</div>
		</footer>
	</body>
</html>