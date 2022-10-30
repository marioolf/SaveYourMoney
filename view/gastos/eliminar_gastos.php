<?php

// file: eliminar_gastos.php

require_once("../../core/PDOConnection.php");
$db=PDOConnection::getInstance();


session_start();

//Comprobamos user
$currentuser = null;
if ( isset($_SESSION["currentuser"]) ){
  $currentuser = $_SESSION["currentuser"];
} else {
  echo "Inicia sesion para acceder <br>";
  echo "<a href='./users/login.php'>Logeate</a>";
  die();
}

if (!isset($_POST['id'])) {
  die("Necesitas un id de gasto");
}

try {
  $stmt = $db->prepare("SELECT count(*) from gastos where id=? and author=?");
  $stmt->execute(array($_POST["id"], $currentuser));
  
  $stmt->closeCursor();   
  
} catch(PDOException $ex) {
  die("exception! ".$ex->getMessage());
}



try {
  $stmt = $db->prepare("DELETE FROM gastos where id=?");
  $stmt->execute(array($_POST["id"]));  
} catch(PDOException $ex) {
  die("exception! ".$ex->getMessage());
}

?>
<html>
  <head>
		<meta charset="UTF-8"></meta>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oxanium">
		<title>eliminar gasto</title>

	</head>
  <body class="bodygastos" data-lang="es">
    <p class="texto">Gasto eliminado de forma correcta. Vuelva a  <a href="gastos.php">GASTOS</a></p>    
  </body>
</html>
