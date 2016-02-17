<?php
	include '../db_connect.php';

	$coupleID = $_POST['couple'];
	$amountPaid = $_POST['amountPaid'];

    echo $coupleID;
    echo $amountPaid;
	
	$coupleQuery = mysqli_query($link, "SELECT couples.*, retreats.*
								FROM couples 
									JOIN retreats ON couples.retreatID = retreats.retreatID
								WHERE couples.coupleID = $coupleID");
    $couples = mysqli_fetch_array($coupleQuery);	
	
	$paymentQuery = mysqli_query($link, "SELECT * FROM paid_status WHERE coupleID = $coupleID");
	$goodPayment = TRUE;
	$noInfo = TRUE;
	
	if ($couples['placeID'] == 1 && $couples['private'] == 0) { 	//Sundance not private
		$retreatPrice = 3395;
	} elseif ($couples['placeID'] == 2 && $couples['private'] == 0) {	//San Diego not private
		$retreatPrice = 3895;
	} elseif ($couples['placeID'] == 3 && $couples['private'] == 0) {	//Texas Hill Country not private
		$retreatPrice = 3895;
	} elseif ($couples['placeID'] == 1 && $couples['private'] == 1) {	//Sundance Private
		$retreatPrice = 9495;
	} elseif ($couples['placeID'] == 2 && $couples['private'] == 1) {	//San Diego Private
		$retreatPrice = 10495;
	} elseif ($couples['placeID'] == 3 && $couples['private'] == 1) {	//Texas Hill Country Private
		$retreatPrice = 10995;
	};
		
    // Which couples made a payment?
	while ($payment = mysqli_fetch_array($paymentQuery)) {
		$noInfo = FALSE;
		$pastPaid += $payment['amountPaid'];
	};

	
	if (!is_numeric($amountPaid)) {
		echo "Bad Value!";
	} else {
		if (($amountPaid + $pastPaid) > $retreatPrice) {
			echo "Charge is greater than remaining balance";
			$goodPayment = FALSE;
		} elseif ($noInfo && ($amountPaid + $pastPaid) < $retreatPrice) {
			$payType = '1';
		} elseif (($amountPaid + $pastPaid) < $retreatPrice) {
			$payType = '2';
		} elseif (($amountPaid + $pastPaid) == $retreatPrice) {
			$payType = '3';
		};
		
		if ($goodPayment) {
			$sql = mysqli_query($link, "INSERT INTO paid_status (coupleID, amountPaid, payTypeID)
					VALUES ('$coupleID','$amountPaid','$payType')");
		};
	};
		header('Location: ../index.php');

	
?>