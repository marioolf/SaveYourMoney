<?php
// file: ver_gastos.php
require_once("../../core/PDOConnection.php");
$db=PDOConnection::getInstance();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['id'])) {
  die("Necesitas un id de gasto");
}

$currentuser = null;
if (isset($_SESSION["currentuser"])) {
  $currentuser = $_SESSION["currentuser"];
}
try {

    $stmt = $db->prepare("SELECT * FROM gastos where id=? ORDER BY fecha");
    $stmt->execute(array($_GET["id"]));
    
    $gasto = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$gasto){
      die("error: No esxiste ese gasto");
    }
    $stmt->closeCursor(); 
    
    
  } catch(PDOException $ex) {
    die("exception! ".$ex->getMessage());
}

?>

<html>
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
		<title>vista gasto</title>

	</head>
  <body class="bodygastos" data-lang="es">
    <?php include("./../layouts/header.php"); ?>

    <?php if ($gasto["author"] == $currentuser): ?>
      <div class="container">
        <h1 class="texto">Gasto: <?= htmlentities($gasto["nombre"]) ?></h1>
        <em class="texto">Gasto de : <?= $gasto["author"] ?></em>
        <hr>
        <p class="textoleft">Importe:</p>
        <p class="texto"><?= htmlentities($gasto["importe"]) ?> €</p> 
        <hr>
        <p class="textoleft">Tipo:</p>
        <p class="texto"><?= htmlentities($gasto["tipo"]) ?></p>
        <hr>
        <p class="textoleft">Descripcion:</p>
        <p class="texto"><?= htmlentities($gasto["descr"]) ?></p>  
        <hr>
        <p class="textoleft">Fecha:</p>
        <p class="texto"><?= htmlentities($gasto["fecha"]) ?></p>  
        <hr>
        <p class="textoleft">Archivo:</p>
        <p class="file"><?= htmlentities($gasto["archivo"]) ?></p> 
      </div>

		<?php endif ?>

  </body>
</html>

