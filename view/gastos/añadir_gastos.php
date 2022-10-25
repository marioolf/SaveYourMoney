<?php
//file: añadir_gastos.php

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

$errors = array(); 
$gastoOK = false; 

if (isset($_POST["submit"])){

    $validationOK = true;

// Validamos los campos obligatorios Nombre, Importe y Tipo

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

      $stmt = $db->prepare("INSERT INTO gastos(nombre,importe,tipo,descr,author) values (?,?,?,?,?)");
      $stmt->execute(array($_POST["nombre"], $_POST["importe"],$_POST["tipo"],$_POST["descr"], $currentuser)); 
      $gastoOK = true;
      
    }catch(PDOException $ex){
      die("exception! ".$ex->getMessage());
    }
  }    
}
?>

<html>
  <body><?php include("../layout/header.php"); ?>
    <h1>Crear gasto </h1>
    <?php if ($gastoOK): ?>
      Gasto añadido de forma correcta. Vuelva a  <a href="gastos.php">GASTOS</a>    
    <?php else: ?>      
      
      <form action="añadir_gastos.php" method="POST">

	    Nombre: <input type="text" name="nombre" 
			     value="<?= isset($_POST["nombre"])?$_POST["nombre"]:"" ?>">
	    <?= isset($errors["nombre"])?$errors["nombre"]:"" ?><br>

      Importe: <input type="float" name="importe" 
			     value="<?= isset($_POST["importe"])?$_POST["importe"]:"" ?>">
	    <?= isset($errors["importe"])?$errors["importe"]:"" ?><br>

      Tipo: <input type="text" name="tipo" 
			     value="<?= isset($_POST["tipo"])?$_POST["tipo"]:"" ?>">
	    <?= isset($errors["tipo"])?$errors["tipo"]:"" ?><br>
	    
	    Descripcion: <br>
	    <textarea name="descr" rows="4" cols="50"><?= isset($_POST["descr"])?$_POST["descr"]:"" ?></textarea>
	    <?= isset($errors["descr"])?$errors["descr"]:"" ?><br>
	    
	    <input type="submit" name="submit" value="submit">
      </form>
    
    <?php endif ?>
  </body>
</html>