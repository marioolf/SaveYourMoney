<?php
//file: editar_gastos.php

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

//Pillamos el id del gasto
$gastoid = null;
if (isset($_REQUEST["id"])) {
  $gastoid = $_REQUEST["id"];
}

if (!isset($gastoid)) {
    die("Necesitas un id de gasto");  
}

try{
    $stmt = $db->prepare("SELECT * from gastos where id=?");
    $stmt->execute(array($gastoid));
    $gasto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$gasto){
      die("error: No existe el gasto");
    }
    $stmt->closeCursor();   
    
}catch(PDOException $ex){
    die("exception! ".$ex->getMessage());
}

$errors = array(); 
$updateOK = false;

if (isset($_POST["submit"])){

    // Validamos los campos obligatorios Nombre, Importe y Tipo

    $validationOK = true;
    if (strlen(trim($_POST["nombre"])) == 0 ) {
      $errors["nombre"] = "Tiene que existir un Nombre de gasto";
      $validationOK = false;
    }
    if (strlen(trim($_POST["importe"])) == 0) {
      $errors["importe"] = "Tiene que existir un Importe de gasto ";
      $validationOK = false;
    }
    if (strlen(trim($_POST["tipo"])) == 0) {
      $errors["tipo"] = "Tienes que poner un tipo al gasto";
      $validationOK = false;
    }
    
    if ($validationOK) {
      try{
      
        $stmt = $db->prepare("UPDATE gastos set nombre =?,importe=?,tipo=?,descr=? where id =?");
        $stmt->execute(array($_POST["nombre"], $_POST["importe"],$_POST["tipo"],$_POST["descr"], $gastoid));  
      
        $updateOK = true;
        
      }catch(PDOException $ex){
        die("exception! ".$ex->getMessage());
      }
    }    
}

?>


<html>
  <body><?php include("../layout/header.php"); ?>
    <h1>Modifica gasto</h1>
    <?php if ($updateOK): ?>
      Gasto modificado de forma correcta. Vuelva a  <a href="gastos.php">GASTOS</a>   
    <?php else: ?>

      <form action="editar_gastos.php" method="POST">
	    Nombre: <input type="text" name="nombre" 
			  value="<?= isset($_POST["nombre"])?$_POST["nombre"]:$gasto["nombre"] ?>">
	    <?= isset($errors["nombre"])?$errors["nombre"]:"" ?><br>

      Importe: <input type="float" name="importe" 
			  value="<?= isset($_POST["importe"])?$_POST["importe"]:$gasto["importe"] ?>">
	    <?= isset($errors["importe"])?$errors["importe"]:"" ?><br>

      Tipo: <input type="text" name="tipo" 
			  value="<?= isset($_POST["tipo"])?$_POST["tipo"]:$gasto["tipo"] ?>">
	    <?= isset($errors["tipo"])?$errors["tipo"]:"" ?><br>
	    
	    Descripcion: <br>
	    <textarea name="descr" rows="4" cols="50"><?= 
	      isset($_POST["descr"])?
		    htmlentities($_POST["descr"]):
		    htmlentities($gasto["descr"])
	    ?></textarea>	    
	    <?= isset($errors["descr"])?$errors["descr"]:"" ?><br>
	    
	    <input type="hidden" name="id" value="<?= $gasto["id"] ?>">
	    <input type="submit" name="submit" value="submit">
      </form>
    
    <?php endif ?>
  </body>
</html>

