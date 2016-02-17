<!--

Create the form for adding a couple
Form submits to add_couple.php

-->
        <h2>Add Couple</h2>

<?php
    include '../db_connect.php';    
    
	$retreatList = mysqli_query($link, "SELECT * FROM retreats LEFT JOIN places
       							ON retreats.placeID = places.placeID 
       							WHERE endDate > CURDATE()
       							ORDER BY startDate ASC"); // Join Places and Retreats tables 
	$statusList = mysqli_query($link, "SELECT * FROM couple_status");
	
	echo "<form action='couple_tab/add_couple.php' method='post' id='addCouple'>";
    echo "<li><strong>Couple Name: </strong><br><input type='text' name='coupleName' required></input></li>";
    echo "<li><strong>Retreat: </strong><br>";
	echo "<select name='retreat'> "; //get list of retreats
    echo "<option value='0'>Not Yet Assigned</option>";
	while ($row = mysqli_fetch_array($retreatList)) { //loop retreat table
		$stDate = strtotime($row['startDate']);
		$fStDate = date("m/d", $stDate);
	
		echo "<option value='".$row['retreatID']."'>".$row['place']." -- ".$fStDate."</option>";
	};
	echo "</select></li><br>";
	echo "<li><strong>Status: </strong><br><select name='status'>";
	while ($row = mysqli_fetch_array($statusList)) { //loop retreat table
		echo "<option value='".$row['statusID']."'>".$row['status']."</option>";
	};
	echo "</select></li><br>";
    echo "<li><textarea name='shortDescript' placeholder='Short description of couple'></textarea></li><br>";
	echo "<li><input type='submit' value='Submit'></li><br>";
	echo "</form>";

	// Make sure you can't add blank names

?>