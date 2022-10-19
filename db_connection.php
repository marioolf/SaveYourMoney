<?php
// file: db_connection.php

$dbhost = "127.0.0.1";
$dbname = "sym";
$dbuser = "root";
$dbpass = "";

$db = new PDO(
	"mysql:host=$dbhost;dbname=$dbname;charset=utf8", // connection string
	$dbuser, 
	$dbpass, 
	array( // options
	  PDO::ATTR_EMULATE_PREPARES => false,
	  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	)
);
?>