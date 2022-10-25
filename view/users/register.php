<?php
//file: register.php

require_once("../../core/db_connection.php");
session_start();

$errors = array(); // validation errors
$registerOK = false; // was the register ok?

if (isset($_POST["username"])){
  //process register form
  
  // validate fields length
  $validationOK = true;
  if (strlen($_POST["username"]) < 5) {
    $errors["username"] = "Username must be at least 5 characters length";
    $validationOK = false;
  }
  if (strlen($_POST["passwd"]) < 5) {
    $errors["passwd"] = "Password must be at least 5 characters length";
    $validationOK = false;
  }
  
  // validate if user exists...
  if ($validationOK) {
    try{
  
      $stmt = $db->prepare("SELECT count(username) FROM users where username=?");
      $stmt->execute(array($_POST["username"]));
    
      if ($stmt->fetchColumn() > 0) {   
	    // username already exists!
	    $errors["username"] = "Username already exists";
	    $validationOK = false;
      }
    }catch(PDOException $ex){
      die("exception! ".$ex->getMessage());
    }
  }
  
  if ($validationOK) {
    // validation all OK, now insert...
    try{
    
      $stmt = $db->prepare("INSERT INTO users values (?,?)");
      $stmt->execute(array($_POST["username"], $_POST["passwd"]));  
    
      $registerOK = true;
      
    }catch(PDOException $ex){
      die("exception! ".$ex->getMessage());
    }
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
		<link rel="stylesheet" href="../../css/style.css" media="screen">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oxanium">
		<title>register</title>

	</head>
	<body class="bodyreg" data-lang="es">
		<header>
			<div>
				<img class="imagenreg" src="../../images/oie_transparent2.png">
			</div>
		</header> 
	  
		<p class="textoreg">SaveYourMoney es una aplicacón que te permitirá hacer un seguimiento de todos tus gastos,
				¡Olvídate de acabar el mes a 0!</p>

      <?php if ($registerOK): ?>
      <p>Bienvenido a la aplicación. Por favor <a href="login.php">logueate</a></p>

      <?php else: 

      ?> 
        <div class="container">
              <form action="register.php" method="POST">
                  <label class="labelreg">Usuario : </label>   
                  <input class="inputreg" type="text" name="username" 
                  value="<?= isset($_POST["username"])?$_POST["username"]:"" ?>">
          <?= isset($errors["username"])?$errors["username"]:"" ?><br>
                  <label class="labelreg">Contraseña : </label>  
                  <input class="inputreg" type="password" name="passwd" 
                  value="<?= isset($_POST["passwd"])?$_POST["passwd"]:"" ?>">
          <?= isset($errors["passwd"])?$errors["passwd"]:"" ?><br>

                  <button class="buttonreg" type="submit">Register </button>
              </form>
         </div>

      <?php endif ?>


		
    
    
		<footer class="footerreg">
			<div>
				<p class='textoreg'>SaveYourMoney creado por Manuel Márquez, Mario López y Lander Lluvia. </p>
			</div>
		</footer>
	</body>
</html>