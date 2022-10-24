<?php

// file: delete_post.php

require_once("db_connection.php");

session_start();

if (!isset($_POST['id'])) {
  die("error, this page requires a post id");
}

// security check ...
$currentuser = null;
if ( isset($_SESSION["currentuser"]) ){
  $currentuser = $_SESSION["currentuser"];
} else {
  echo "Not in session, this is a restricted area<br>";
  echo "<a href='login.php'>Go to login.php</a>";
  die();
}

// security check: is the post from the current user?
try {
  $stmt = $db->prepare("SELECT count(*) from posts where id=? and author=?");
  $stmt->execute(array($_POST["id"], $currentuser));
 
  
  if ($stmt->fetchColumn() == 0){
    die("error: No such post owned by this user, are you the author?");
  }
  $stmt->closeCursor(); //close the query before doing next    
  
} catch(PDOException $ex) {
  die("exception! ".$ex->getMessage());
}


// delete the post
try {
  $stmt = $db->prepare("DELETE FROM posts where id=?");
  $stmt->execute(array($_POST["id"]));  
} catch(PDOException $ex) {
  die("exception! ".$ex->getMessage());
}

?>
<html>
  <body>
   Post deleted. Please go back to <a href="posts.php">the posts</a>      
  </body>
</html>