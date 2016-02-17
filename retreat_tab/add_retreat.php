<?php
//**********
//	ADDS RETREATS INTO DATABASE
//**********

    include '../db_connect.php';
	
	
	$retreat = $_POST['retreat'];
	$rawStDate = $_POST['startDate'];
	$rawEndDate = $_POST['endDate'];
	$private = $_POST['private'];
	
	$startDate = strtotime ($rawStDate);
	$endDate = strtotime($rawEndDate);
	
	$fStDate = date("Y-m-d H:i:s", $startDate);
	$fEndDate = date("Y-m-d H:i:s", $endDate);
	
//	echo $fStDate;
//	echo $fEndDate;
	
	$sql = mysqli_query($link, "INSERT INTO retreats (placeID, startDate, endDate, private)
			VALUES ('$retreat','$fStDate','$fEndDate', '$private')");
	
    header('Location: ../index.php#retreat-tab');	
?>
