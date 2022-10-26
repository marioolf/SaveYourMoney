<?php

// file: gastos.php

require_once("../../core/db_connection.php");
session_start();

if ( !isset($_SESSION["currentuser"]) ){
	echo "No has iniciado sesion<br>";
	echo "<a href='../users/login.php'>Logeate</a>";
	die();
  }

//Instanciamos el usuario
$currentuser = null;
if (isset($_SESSION["currentuser"]) ){
  $currentuser = $_SESSION["currentuser"];
}

//Cargamos los gastos
try {

    $stmt = $db->query("SELECT * FROM gastos");  
    $gastos = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  } catch(PDOException $ex) {
    die("exception! ".$ex->getMessage());
  }
  
?>


<html>
  <body>
    <?php include("../layout/header.php"); ?>
    <h1>Gastos</h1>
  
    <table border="1">
      <tr>
	<th>Nombre</th><th>Descripcion</th><th>Importe</th><th>Tipo de gasto</th>
      </tr>
    
    <?php foreach ($gastos as $gasto) : ?>
		<?php if ($gasto["author"] == $currentuser): 
            //Mostramos solo los gastos del usuario logeado
        ?>
            
	    <tr>	    
	      <td>
		    <a href="vista_gastos.php?id=<?= $gasto["id"] ?>"><?= htmlentities($gasto["nombre"]) ?>
	      </td>
	      <td>
		<?= $gasto["descr"] ?>
	      </td>
		  <td>
		<?= $gasto["importe"] ?> €
	      </td>
		  <td>
		<?= $gasto["tipo"] ?>
	      </td>
	      <td>&nbsp;
		
		<?php endif ?>

		<?php if (isset($currentuser) && ($gasto["author"] == $currentuser)): ?>
		
            <?php 
            //Boton Borrar
		    ?>
		  <form 		    
		    method="POST" 
		    action="eliminar_gastos.php" 
		    id="eliminar_gastos_<?= $gasto["id"]; ?>"
		    style="display: inline" 
		    >
		  
		    <input type="hidden" name="id" value="<?= $gasto["id"] ?>">
		  
		    <a href="#" 
		      onclick="
		      if (confirm('Estas seguro de borrar el gasto?')) {
			    document.getElementById('eliminar_gastos_<?= $gasto["id"] ?>').submit() }" > Eliminar </a>
		  
		  </form>
		  
		  &nbsp;
		  
		  <?php 
		  // Boton Editar
		  ?>		  
		  <a href="editar_gastos.php?id=<?= $gasto["id"] ?>" > Editar </a>
		
		<?php endif; ?>

	      </td>
	    </tr> 


    <?php endforeach; ?>
    
    </table>
    
    <?php if (isset($currentuser)): ?>
      <a href="añadir_gastos.php">Create gasto</a>    
    <?php endif; ?>
  </body>
</html>