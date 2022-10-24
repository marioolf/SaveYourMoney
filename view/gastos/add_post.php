<?php
//file: add_post.php

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
$postOK = false; // was the post successfully inserted into db?

if (isset($_POST["submit"])){
  //process post form
  
  // validate fields length
  $validationOK = true;
  if (strlen(trim($_POST["title"])) == 0 ) {
    $errors["title"] = "title is mandatory";
    $validationOK = false;
  }
  if (strlen(trim($_POST["content"])) == 0) {
    $errors["content"] = "content is mandatory";
    $validationOK = false;
  }
  
  if ($validationOK) {
    // validation all OK, now insert...
    try{
    
      $stmt = $db->prepare("INSERT INTO posts(title, content, author) values (?,?,?)");
      $stmt->execute(array($_POST["title"], $_POST["content"], $currentuser));  
    
      $postOK = true;
      
    }catch(PDOException $ex){
      die("exception! ".$ex->getMessage());
    }
  }    
}
?>

<html>
  <body><?php include("header.php"); ?>
    <h1>Create post</h1>
    <?php if ($postOK): ?>
      Post added correctly. Please go back to <a href="posts.php">the posts</a>    
    <?php else: ?>      
      <form action="add_post.php" method="POST">
	    Title: <input type="text" name="title" 
			     value="<?= isset($_POST["title"])?$_POST["title"]:"" ?>">
	    <?= isset($errors["title"])?$errors["title"]:"" ?><br>
	    
	    Contents: <br>
	    <textarea name="content" rows="4" cols="50"><?= isset($_POST["content"])?$_POST["content"]:"" ?></textarea>
	    <?= isset($errors["content"])?$errors["content"]:"" ?><br>
	    
	    <input type="submit" name="submit" value="submit">
      </form>
    
    <?php endif ?>
  </body>
</html>