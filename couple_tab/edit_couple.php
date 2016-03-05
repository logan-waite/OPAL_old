<head>
    <meta http-equiv="refresh" content="1; url=../index.php#couple-tab/" />
</head>
<?php
    include '../db_connect.php';

    $coupleID = $_POST['coupleID'];
    $retreatID = $_POST['retreat'];
    $statusID = $_POST['status'];
	$coupleName = $_POST['coupleName']; 

	$retreatQuery = mysqli_query($link, "SELECT * FROM retreats LEFT JOIN places
       ON retreats.placeID = places.placeID");

        // If couple cancels
        if ($statusID == 4) {
            $sql = mysqli_query ($link, "UPDATE couples SET
                                name = '$coupleName',
                                retreatID = '0',
                                statusID = '4'
                                WHERE coupleID = '$coupleID'");
            echo "Couple canceled!";
            exit;
        }
        
        // If couple is potential
        if ($statusID == 1) {
            $sql = mysqli_query ($link, "UPDATE couples SET
                                name = '$coupleName',
                                retreatID = '0',
                                statusID = '1'
                                WHERE coupleID = '$coupleID'");
            echo "Couple updated!";
            exit;
        }

	while($retreat = mysqli_fetch_array($retreatQuery)){
               
        // Assign to retreat
		if ($retreat['retreatID'] == $retreatID) {
			$coupleQuery = mysqli_query($link, "SELECT coupleID, name FROM couples 
									WHERE couples.retreatID = ".$retreatID);
            // Check if retreat is private
            if ($retreat['private'] == 1) {
				$maxCouples = 1;
            } else {	
				$maxCouples = $retreat['maxCouples'];
			};
			$numCouples = 0;

            // Make sure the retreat isn't full
            while ($couple = mysqli_fetch_array($coupleQuery)) {
				$numCouples++;
			};
			if ($numCouples >= $maxCouples) {
				echo "Retreat is full!";
				exit;
			} elseif ($numCouples <= $maxCouples) {
				$sql = mysqli_query ($link, "UPDATE couples SET
                                        name = '$coupleName',
                                        retreatID = '$retreatID',
                                        statusID = '$statusID'
                                    WHERE coupleID = '$coupleID'");
                echo "Couple updated!";
				exit;
			};
		};
	};
?>