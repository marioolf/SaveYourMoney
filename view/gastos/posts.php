<?php

// file: posts.php

require_once("db_connection.php");

session_start();

// set the current user if exists
$currentuser = null;
if (isset($_SESSION["currentuser"]) ){
  $currentuser = $_SESSION["currentuser"];
}

// load posts
try {

  $stmt = $db->query("SELECT * FROM posts");  
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $ex) {
  die("exception! ".$ex->getMessage());
}

?>


<html>
  <body>
    <?php include("header.php"); ?>
    <h1>Posts</h1>
    
    <table border="1">
      <tr>
	<th>title</th><th>author_id</th><th>actions</th>
      </tr>
    
    <?php foreach ($posts as $post): ?>
	    <tr>	    
	      <td>
		    <a href="view_post.php?id=<?= $post["id"] ?>"><?= htmlentities($post["title"]) ?>
	      </td>
	      <td>
		<?= $post["author"] ?>
	      </td>
	      <td>&nbsp;
		<?php
		//show actions ONLY for the author of the post (if logged)
		
		
		if (isset($currentuser) && $currentuser == $post["author"]): ?>
		
		  <?php 
		  // 'Delete Button': show it as a link, but do POST in order to preserve
		  // the good semantic of HTTP
		  ?>
		  <form 		    
		    method="POST" 
		    action="delete_post.php" 
		    id="delete_post_<?= $post["id"]; ?>"
		    style="display: inline" 
		    >
		  
		    <input type="hidden" name="id" value="<?= $post["id"] ?>">
		  
		    <a href="#" 
		      onclick="
		      if (confirm('are you sure?')) {
			    document.getElementById('delete_post_<?= $post["id"] ?>').submit() 
		      }"
		    >
		      Delete</a>
		  
		  </form>
		  
		  &nbsp;
		  
		  <?php 
		  // 'Edit Button'
		  ?>		  
		  <a href="edit_post.php?id=<?= $post["id"] ?>">Edit</a>
		
		<?php endif; ?>

	      </td>
	    </tr>    
    <?php endforeach; ?>
    
    </table>
    
    <?php if (isset($currentuser)): ?>
      <a href="add_post.php">Create post</a>    
    <?php endif; ?>
  </body>
</html>