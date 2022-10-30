
<?php

//file: login.php

require_once (__DIR__.'./../../core/ViewManager.php');
require_once (__DIR__.'./../../core/I18n.php');

$view = ViewManager::getInstance();
$view->setVariable("title", "Login");
//$errors = $view->getVariable("errors");

?>

<html lang="es">
<head>
        <meta charset="UTF-8"></meta>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="./../../css/style.css" type="text/css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oxanium">
		<title>personal area redirect</title>
  </head>
    <body class="bodylog">
        <div class="center">
            <p class="texto">Sesion iniciada correctamente accede a :</p><br>
            <button class="texto"><a href="./view/gastos/personal_area.php">ACCEDE A TU AREA PERSONAL</a></button>
        </div>
    </body>

</html>

<?php $view->moveToFragment("css"); ?>
<link rel="stylesheet" type="text/css" href="./css/style.css">
<?php $view->moveToDefaultFragment(); ?>
