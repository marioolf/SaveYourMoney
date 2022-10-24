<?php
//file: edit_post.php

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

//get the post id, from GET or POST parameters
$postid = null;
if (isset($_REQUEST["id"])) {
  $postid = $_REQUEST["id"];
}

if (!isset($postid)) {
  die("this page requires a post id");  
}

// load post
try{
  $stmt = $db->prepare("SELECT * from posts where id=?");
  $stmt->execute(array($postid));
  $post = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if (!$post){
    die("error: No such post");
  }
  $stmt->closeCursor(); //close the query before doing next    
  
}catch(PDOException $ex){
  die("exception! ".$ex->getMessage());
}

// security: check if the user owns this post
if ($post["author"] != $currentuser) {
  die("you do not own this post!");  
}

$errors = array(); // validation errors
$updateOK = false; // was the post update successfully?

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
    // validation all OK, now update...
    try{
    
      $stmt = $db->prepare("UPDATE posts set title=?, content=? where id=?");
      $stmt->execute(array($_POST["title"], $_POST["content"], $postid));  
    
      $updateOK = true;
      
    }catch(PDOException $ex){
      die("exception! ".$ex->getMessage());
    }
  }    
}

?>
<html>
  <body><?php include("header.php"); ?>
    <h1>Modify post</h1>
    <?php if ($updateOK): ?>
      Post modified correctly. Please go back to <a href="posts.php">the posts</a>    
    <?php else: ?>
    
      <?php
	  // edit form. in $post there is the original post to update.
	  // in $_POST there is the values the user has put in the last
	  // submission. If there are $_POST values, the form will show
	  // them. Else, the original values of the post will be shown
	  // ($post var)
      ?>
      <form action="edit_post.php" method="POST">
	    Title: <input type="text" name="title" 
			  value="<?= isset($_POST["title"])?$_POST["title"]:$post["title"] ?>">
	    <?= isset($errors["title"])?$errors["title"]:"" ?><br>
	    
	    Contents: <br>
	    <textarea name="content" rows="4" cols="50"><?= 
	      isset($_POST["content"])?
		    htmlentities($_POST["content"]):
		    htmlentities($post["content"])
	    ?></textarea>	    
	    <?= isset($errors["content"])?$errors["content"]:"" ?><br>
	    
	    <input type="hidden" name="id" value="<?= $post["id"] ?>">
	    <input type="submit" name="submit" value="submit">
      </form>
    
    <?php endif ?>
  </body>
</html>