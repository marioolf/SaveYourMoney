<html lang="es">

  <link rel="stylesheet" href="../../css/style.css" media="screen">

  <div class="menu">
    <img class="imagen" src="../../images/oie_transparent2.png">
    <button class="opciones"><a href="../gastos/gastos.php">Gastos</a></button>
    <button class="opciones"><a href="../gastos/personal_area.php">Menu</a></button> 
    <button class="opciones"><a href="../users/login.php">Login</a></button>
      <?php if (isset($_SESSION["currentuser"])): ?>
        <div style="float:right">Hello <?=$_SESSION["currentuser"] ?> 
          <button class="opciones"><a href="../users/logout.php">(Logout)</a></button>
        </div>
      <?php endif ?>
  </div>

</html>