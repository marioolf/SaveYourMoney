<?php
//file: añadir_gastos.php

require_once("../../core/PDOConnection.php");
$db=PDOConnection::getInstance();

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
  if (strlen(trim($_POST["fecha"])) == null) {
    $errors["fecha"] = "Tienes que poner una fecha al gasto";
    $validationOK = false;
  }
  
  if ($validationOK) {
    try{

      $stmt = $db->prepare("INSERT INTO gastos(nombre,importe,tipo,descr,author,fecha,archivo) values (?,?,?,?,?,?,?)");
      $stmt->execute(array($_POST["nombre"], $_POST["importe"],$_POST["tipo"],$_POST["descr"],$currentuser,$_POST["fecha"],$_POST["archivo"])); 
      $gastoOK = true;
      
    }catch(PDOException $ex){
      die("exception! ".$ex->getMessage());
    }
  }    
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
		<title>anadir gasto</title>

	</head>
  <body class="bodygastos" data-lang="es">
    <?php include("./../layouts/header.php"); ?>
    <div class="container">
      <h1 class="texto">Crear gasto </h1>
      <?php if ($gastoOK): ?>
        <p class="texto">Gasto añadido de forma correcta. Vuelva a  <a href="gastos.php">GASTOS</a></p>  
      <?php else: ?>      
        
        <form action="añadir_gastos.php" method="POST">

          <label class="labellog">Nombre:</label><br>
          <input class="inputgasto" type="text" name="nombre" 
              value="<?= isset($_POST["nombre"])?$_POST["nombre"]:"" ?>">
          <?= isset($errors["nombre"])?$errors["nombre"]:"" ?><br>

          <label class="labellog">Importe:</label><br>
          <input class="inputgasto" type="float" name="importe" 
              value="<?= isset($_POST["importe"])?$_POST["importe"]:"" ?>">
          <?= isset($errors["importe"])?$errors["importe"]:"" ?><br>

          <label class="labellog">Tipo:</label><br>
          <div class="divtipo">
            <select class="selecttipo" name="tipo">
              <option >Otros</option>
              <option>Casa</option>
              <option>Comida</option>
              <option>Regalos</option>
            </select><br>
          </div>
          
          <label class="labellog">Descripcion:</label><br>
          <textarea class="textarea" name="descr" rows="4" cols="50"><?= isset($_POST["descr"])?$_POST["descr"]:"" ?></textarea>
          <?= isset($errors["descr"])?$errors["descr"]:"" ?><br>

          <label class="labellog">Fecha:</label><br> 
          <input type="date" value="<?php echo date('Y-m-d'); ?>" name="fecha" 
          value="<?= isset($_POST["fecha"])?$_POST["fecha"]:"" ?>">
          <?= isset($errors["fecha"])?$errors["fecha"]:"" ?><br>

          <label class="labellog">Archivo:</label><br>
          <input class="inputgasto" type="file" name="archivo" 
              value="<?= isset($_POST["archivo"])?$_POST["archivo"]:"" ?>">
          <?= isset($errors["archivo"])?$errors["archivo"]:"" ?><br>

          <input class="inputbtn" type="submit" name="submit" value="Submit">
        </form>
      
      <?php endif ?>
    </div>
  </body>
</html>
