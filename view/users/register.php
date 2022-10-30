
<?php
require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
$user = $view->getVariable("user");
$view->setVariable("title", "Register");
?>
<?php
//file: register.php



/*
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
*/
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
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oxanium">
		<title>register</title>

	</head>
	<body class="bodyreg" data-lang="es">
		<header>
		</header> 
	  
		<p class="textoreg">SaveYourMoney es una aplicacón que te permitirá hacer un seguimiento de todos tus gastos,
				¡Olvídate de acabar el mes a 0!</p>


        <div class="container">
              <form action="index.php?controller=users&amp;action=register" method="POST">
                  <label class="labelreg">Usuario : </label>   

                  <input class="inputreg" type="text" name="username" value="<?= $user->getUsername() ?>" placeholder="<?= i18n("Username") ?>">
			<?= isset($errors["username"]) ? i18n($errors["username"]) : "" ?><br>

                  <label class="labelreg">Email : </label>   

                              <input class="inputreg" type="text" name="email" value="" placeholder="<?= i18n("Email") ?>">
                  <?= isset($errors["username"]) ? i18n($errors["username"]) : "" ?><br>

                  <label class="labelreg">Contraseña : </label>  
                  <input class="inputreg" type="password" name="passwd" value="" placeholder="<?= i18n("Password") ?>">
			<?= isset($errors["passwd"]) ? i18n($errors["passwd"]) : "" ?><br>

                  <button class="buttonreg" type="submit">Register </button>
              </form>
         </div>



		
    
    
		<footer class="footerreg">
			<div>
				<p class='textoreg'>SaveYourMoney creado por Manuel Márquez, Mario López y Lander Lluvia. </p>
			</div>
		</footer>
	</body>
</html>

<?php $view->moveToFragment("css"); ?>
<link rel="stylesheet" type="text/css" href="./css/style.css">
<?php $view->moveToDefaultFragment(); ?>
