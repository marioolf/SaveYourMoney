<?php
//file: add_comment.php

require_once("db_connection.php");
session_start();

// security check ...
$currentuser = null;
if ( isset($_SESSION["currentuser"]) ){
  $currentuser = $_SESSION["currentuser"];
} else {
  echo "Not in session, this is a restricted area<br>";
  echo "<a href='login.php'>Go to login.php</a>";
  die();
}

$errors = array(); // validation errors
$commentOK = false; // was the comment successfully inserted into db?

if (isset($_POST["id"])){
  //process comment form
  
  // validate fields length
  $validationOK = true;
  if (strlen(trim($_POST["content"])) == 0 ) {
    $errors["content"] = "comment cannot be empty";
    $validationOK = false;
  }
    
  if ($validationOK) {
    // validation all OK, now insert...
    try{
    
      $stmt = $db->prepare("INSERT INTO comments(content, author, post) values (?,?,?)");
      $stmt->execute(array($_POST["content"], $currentuser, $_POST["id"]));  
    
      $commentOK = true;
      
    }catch(PDOException $ex){
      die("exception! ".$ex->getMessage());
    }
  } else {
    //show the previous view in order to see the errors
    $_GET["id"] = $_POST["id"]; //set the post id in order to view_post.php work    
    include("view_post.php");    
    die();
  }
}
?>

<html>  
  <body>      
      Comment added correctly. Please go back to <a href="view_post.php?id=<?=$_POST["id"] ?>">the post</a>            
  </body>
</html>