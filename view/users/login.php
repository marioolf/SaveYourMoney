
<?php

//file: login.php

require_once (__DIR__.'./../../core/ViewManager.php');
require_once (__DIR__.'./../../core/I18n.php');

$view = ViewManager::getInstance();
$view->setVariable("title", "Login");
$errors = $view->getVariable("errors");

?>

<html lang="es">
	<head>
		<meta charset="UTF-8"></meta>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<link rel="stylesheet" href="./../../css/style.css" type="text/css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oxanium">
		<title>login</title>

	</head>
	<body class="bodylog" data-lang="es">
		<header>
			
		</header> 
	  
		<p class="texto">SaveYourMoney is an application that allows you to follow your expenses,Stop ending your month with no money!</p>
	
		<div class="container">

		<?= isset($errors["general"])?$errors["general"]:"" ?>

		<form method="post" action="index.php?controller=users&amp;action=login">
		<div class="username">
			<input class="inputlog" type="text" name="username" placeholder="<?= i18n("Username") ?>" required>
		</div>
		<div class="username">
			<input class="inputlog" type="password" name="passwd" placeholder="<?= i18n("Password") ?>" required>
		</div>
		<!-- <div class="recordar">Recuperar contraseña</div> -->

		<input class="buttonlog" type="submit" value="<?= i18n("Log in") ?>">

		<div class="registrarse">
			<p class="texto"><?= i18n("Not user? ") ?><a href="index.php?controller=users&amp;action=register"><?= i18n("Register here!") ?></a></p>
		</div>
	</form>
			
		</div>
		
		<footer class="footerlog">
			<div>
				<p>SaveYourMoney creado por Manuel Márquez, Mario López y Lander Lluvia. </p>
			</div>

			<?php
				include(__DIR__."./../layouts/language_select_element.php");
			?>
		
		</footer>
	</body>

</html>
