<?php
// file: view/layouts/welcome.php

$view = ViewManager::getInstance();

?>
<!DOCTYPE html>
<html>

<head>
	<title><?= $view->getVariable("title", "no title") ?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="./css/style.css" type="text/css">
	
	<?= $view->getFragment("css") ?>
	<?= $view->getFragment("javascript") ?>
	

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
				<div>
					<img class="imagenreg" src="../../images/oie_transparent2.png">
				</div>
			</header> 
		<main>
			<!-- flash message -->
			<div id="flash">
				<?= $view->popFlash() ?>
			</div>
			<?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
		</main>
		
		<footer>

		</footer>
	</body>

</html>