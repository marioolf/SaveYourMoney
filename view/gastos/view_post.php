<?php
// file: view_post.php
require_once("db_connection.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['id'])) {
  die("error, this page requires a post id");
}

// set the current user if exists
$currentuser = null;
if (isset($_SESSION["currentuser"])) {
  $currentuser = $_SESSION["currentuser"];
}

// load post and comments
try {
  $stmt = $db->prepare("SELECT * FROM posts where id=?");
  $stmt->execute(array($_GET["id"]));
  
  $post = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$post){
    die("error: No such post");
  }
  $stmt->closeCursor(); //close the query before doing next
  
  //comments
  $stmt = $db->prepare("SELECT * FROM comments where post=?");
  $stmt->execute(array($_GET["id"]));
  $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $ex) {
  die("exception! ".$ex->getMessage());
}

?>
<html>
  <body>
    <?php include("header.php"); ?>
    <h1>Post: <?= htmlentities($post["title"]) ?></h1>
    <em>by <?= $post["author"] ?></em>
    <p>
    <?= htmlentities($post["content"]) ?>
    </p>

    <h2>Comments</h2>    
    
    <?php foreach($comments as $comment): ?>
      <hr>
      <p><?= $comment["author"]; ?> commented...</p>
      <p><?= $comment["content"]; ?></p>
    <?php endforeach; ?>
    
    <?php if (isset($currentuser) ): ?>    
    <h3>Write a comment</h3>
    
    <form method="POST" action="add_comment.php">
      Comment: <br>
      <?= isset($errors["content"])?$errors["content"]:"" ?><br>
      <textarea type="text" name="content"><?= 
	    isset($_POST["content"])? $_POST["content"]:""      
      ?></textarea>
      <input type="hidden" name="id" value="<?= $_GET["id"] ?>" ><br>    
      <input type="submit" name="submit" value="do comment">
    </form>
    
    <?php endif ?>
  </body>
</html>