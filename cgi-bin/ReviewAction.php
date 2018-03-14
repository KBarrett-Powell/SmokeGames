<?php
	$gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
	if (!$gamesdb) { die("Failed to connect: " . mysqli_connect_error()); }
	//$insert = "INSERT INTO Reviews VALUES (".$_GET["GameID"].",".$GLOBALS[""].",".$_SESSION['username'].");";
	//$result = mysqli_query($gamesdb, $insert);
	$Uname = $_POST['foo'];
	$Review = $_POST['foo'];
	$Rating = $_POST['foo'];
	$foo = $_POST['foo'];
	echo "hellooooo";
?>