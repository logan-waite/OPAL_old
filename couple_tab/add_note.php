<?php
	include '../db_connect.php';
	
	$couple = $_POST['coupleID'];
	$noteContent = $_POST['newNote'];
	$date = date('Y-m-d', time());

	$sql = mysqli_query ($link, "INSERT INTO notes (coupleID, noteContent, noteDate)
					VALUES ('$couple','$noteContent','$date')");

?>