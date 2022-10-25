<html lang="es">

  <link rel="stylesheet" href="../../css/header.css" media="screen">

  <div class="menu">
    <img class="imagen" src="../../images/oie_transparent2.png">
    <button class="opciones"><a href="posts.php">Posts</a></button>
    <button class="opciones"><a href="login.php">Login</a></button>
      <?php if (isset($_SESSION["currentuser"])): ?>
        <div style="float:right">Hello <?=$_SESSION["currentuser"] ?> 
          <button class="opciones"><a href="logout.php">(Logout)</a></button>
        </div>
      <?php endif ?>
  </div>

</html>