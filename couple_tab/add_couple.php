<head>
    <meta http-equiv="refresh" content="1; url=../index.php#couple-tab/" />
</head>
<?php 

	//Add a check so you can't add bad info.
	
	include '../db_connect.php';
	
	$retreatList = mysqli_query($link, "SELECT * FROM retreats LEFT JOIN places
       ON retreats.placeID = places.placeID");
	
	$couple = $_POST['coupleName']; 
	$retreatID = $_POST['retreat'];
	$statusID = $_POST['status'];
    $shortDescript = $_POST['shortDescript'];
	
	while($row = mysqli_fetch_array($retreatList)){
        // If couple is potential
        if ($retreatID == 0) {
            $sql = mysqli_query ($link, "INSERT INTO couples (name, retreatID, statusID, shortDescript)
					               VALUES ('$couple','$retreatID','$statusID','$shortDescript')");
            echo "Couple Added!";

            exit;
        };
        
        // Assign to retreat
		if ($row['retreatID'] == $retreatID) {
			$coupleList = mysqli_query($link, "SELECT coupleID, name FROM couples 
									WHERE couples.retreatID = ".$retreatID);
            // Check if retreat is private
            $private = FALSE;
            if ($row['private'] == 1) {
				$private = TRUE;
            } else {	
                $maxCouples = $row['maxCouples'];
                
			};
			$numCouples = 0;

            // Make sure the retreat isn't full
            while ($row = mysqli_fetch_array($coupleList)) {
                $numCouples++;
			};
			if ($private || $numCouples > $maxCouples) {
				echo "Retreat is full!";
				exit;
			} else if ($numCouples <= $maxCouples) {
				$sql = mysqli_query ($link, "INSERT INTO couples (name, retreatID, statusID, shortDescript)
					VALUES ('$couple','$retreatID','$statusID','$shortDescript')");
                echo "Couple Added!";
				exit;
			};
		};
	};

?> 