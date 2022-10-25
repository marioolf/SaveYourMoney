<?php
// file: ver_gastos.php
require_once("../../core/db_connection.php");

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

    $stmt = $db->prepare("SELECT * FROM gastos where id=?");
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
  <body>
    <?php include("../layout/header.php"); ?>

    <?php if ($gasto["author"] == $currentuser): ?>

        <h1>Gasto: <?= htmlentities($gasto["nombre"]) ?></h1>
        <em>gasto de : <?= $gasto["author"] ?></em>
        <hr>Importe :</hr>
        <p>
        <?= htmlentities($gasto["importe"]) ?> €
        </p> 
        <hr>Tipo :</hr>
        <p>
        <?= htmlentities($gasto["tipo"]) ?> 
        </p>
        <hr>Descripcion :</hr>
        <p>
        <?= htmlentities($gasto["descr"]) ?>
        </p>  

		<?php endif ?>

  </body>
</html>