<?php
//file: view/layouts/default.php

$view = ViewManager::getInstance();
$currentuser = $view->getVariable("currentusername");

?>
<!DOCTYPE html>
<html>

<head>
	<title><?= $view->getVariable("title", "no title") ?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="./view/CSS/headerFooter.css" type="text/css">
	<link rel="stylesheet" href="./view/CSS/flash.css" type="text/css">
	<!-- enable ji18n() javascript function to translate inside your scripts -->
	<script src="index.php?controller=language&amp;action=i18njs">
	</script>
	<?= $view->getFragment("css") ?>
	<?= $view->getFragment("javascript") ?>
	<script src="https://code.highcharts.com/highcharts.js"></script>
</head>

<body>
	<header>
		<div class="header">
			<div>
				<img id="logoIMG" src="./view/Imgs/logo.png" alt="">
			</div>
			<div class="usuarioactual">
		<?= sprintf(i18n("Hello %s"), $currentuser) ?>
			</div>
			<div class="header">
				<?php if (isset($currentuser)) : ?>
					<a class="link" href="index.php?controller=users&amp;action=logout"><?= i18n("Logout") ?></a>
				<?php endif ?>

			</div>
		</div>
	</header>

	<main>
		<div id="flash">
			<?= $view->popFlash() ?>
		</div>

		<?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
	</main>

</body>

</html>