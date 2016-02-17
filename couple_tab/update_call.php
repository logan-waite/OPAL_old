<?php
	include '../db_connect.php';
	
	$coupleID = $_GET['coupleID'];
	
	$callQuery = mysqli_query($link, "SELECT preRetreatCall FROM couples WHERE coupleID = '$coupleID'");
	$callStatus = mysqli_fetch_array($callQuery);
	
	if ($callStatus['preRetreatCall'] == 0) {
		$sql = mysqli_query("UPDATE couples SET preRetreatCall = 1 WHERE coupleID = '$coupleID'");
    };
?>