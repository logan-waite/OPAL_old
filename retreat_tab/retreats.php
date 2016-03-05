
<?php

	// Loop retreats, and for each retreat, list the couples who will be attending.
	
	$retreatList = mysqli_query($link, "SELECT * FROM retreats LEFT JOIN places
       							ON retreats.placeID = places.placeID 
       							WHERE endDate > CURDATE() 
       							ORDER BY startDate ASC"); // Join Places and Retreats tables 

	 //loop retreat table
    while ($retreats = mysqli_fetch_array($retreatList)) {
		$numCouples = 0;
		//Determine which retreat
        $retreat = $retreats['retreatID']; 
        //Determine if retreat is private
		$private = $retreats['private']; 
        // Determin if retreat is advanced
        $advanced = $retreats['advanced'];
		//Pick only the couples for this retreat.
        $coupleList = mysqli_query($link, "SELECT coupleID, name, statusID FROM couples 
									WHERE couples.retreatID = ".$retreat."&& couples.statusID IN (2,3)"); 

		// Format Date strings
        $stDate = strtotime($retreats['startDate']);
		$endDate = strtotime($retreats['endDate']);
		$fStDate = date("M d", $stDate);
		$fEndDate = date("M d", $endDate);
		
		//start table
        echo "<div class='table'>"; 
		echo "<div class='header'>".$retreats['place']."</div><div class='header'>".$fStDate." to ".$fEndDate."</div>" ;

		// Tell user if retreat is private
		if ($private == 1 && $advanced == 1) {
			echo "<div class='header'>Private / Advanced</div>";
		} else if ($private == 1 || $advanced == 1) {
            if ($private == 1) {
                echo "<div class='header'>Private</div>";
            } else if ($advanced == 1) {
                echo "<div class='header'>Advanced</div>";
            } else {
                echo "</br>";
            }
        } else {
			echo "</br>";
		};
		
        echo "<div class='couple-wrapper'>";
        //loop couples attending
		while ($couple = mysqli_fetch_array($coupleList)) { 
            $numCouples++;
			
			//Differentiate between reserved couples and sold couples
			echo "<div class='name'";
		 	if ($couple['statusID'] == '2') {	//Reserved - colored background
		 		echo "style='background-color:#55ff55'>";
		 	} else if ($couple['statusID'] == '3') {		//Sold - no color
				echo ">";
		 	};
		 	echo $couple['name'];
            echo "</div>";
		};

        echo "</div>";
        // Check car
        if ($retreats['carReserved'] == 1) {
            $isDone1 = 'btn-success';
        } else {
            $isDone1 = 'btn-danger';
        };
        
        // Check house
        if ($retreats['houseReserved'] == 1) {
            $isDone2 = 'btn-success';
        } else {
            $isDone2 = 'btn-danger';
        };
        
        // Check restaurant
        if ($retreats['restReserved'] == 1) {
             $isDone3 = 'btn-success';
        } else {
            $isDone3 = 'btn-danger';
        };
        
        echo "<div class='reservations'>";
        //car icon
        echo "<div class='icons'><i class='fa fa-car fa-2x $isDone1' onClick='retreatReserve(1,$retreat,this)'></i></div>"; 
        //house icon
        echo "<div class='icons'><i class='fa fa-home fa-2x $isDone2' onClick='retreatReserve(2,$retreat,this)'></i></div>"; 
        //restaurant icon
        echo "<div class='icons'><i class='fa fa-cutlery fa-2x $isDone3' onClick='retreatReserve(3,$retreat,this)'></i></div>"; 
        echo "</div>"; //end reservations div
            
		echo "</div>"; //end table

	};
	
?>