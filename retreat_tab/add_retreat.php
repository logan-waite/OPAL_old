<?php
//**********
//	ADDS RETREATS INTO DATABASE
//**********

    include '../db_connect.php';
	
	
	$retreat = $_POST['retreat'];
	$rawStDate = $_POST['startDate'];
	$rawEndDate = $_POST['endDate'];
	$private = $_POST['private'];
    $advanced = $_POST['advanced'];
	
	$startDate = strtotime ($rawStDate);
	$endDate = strtotime($rawEndDate);
	
	$fStDate = date("Y-m-d H:i:s", $startDate);
	$fEndDate = date("Y-m-d H:i:s", $endDate);
	
//	echo $fStDate;
//	echo $fEndDate;
	
	$sql = mysqli_query($link, "INSERT INTO retreats (placeID, startDate, endDate, private, advanced)
			VALUES ('$retreat','$fStDate','$fEndDate', '$private', '$advanced')");
	
    header('Location: ../index.php#retreat-tab');	
?>
