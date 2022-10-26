<?php

// file: eliminar_gastos.php

require_once("../../core/db_connection.php");

session_start();

//Comprobamos user
$currentuser = null;
if ( isset($_SESSION["currentuser"]) ){
  $currentuser = $_SESSION["currentuser"];
} else {
  echo "Inicia sesion para acceder <br>";
  echo "<a href='../users/login.php'>Logeate</a>";
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
  <body>
  Gasto eliminado de forma correcta. Vuelva a  <a href="gastos.php">GASTOS</a>      
  </body>
</html>