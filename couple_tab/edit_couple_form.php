<h2>Edit Couple</h2>

<form action='couple_tab/edit_couple.php' method='post' id='editCouple'>
	<?php
		include '../db_connect.php';
		
		$coupleID = $_GET['coupleID'];
        
        $coupleQuery = mysqli_query($link, "SELECT coupleID, name, retreatID, statusID FROM couples
									WHERE coupleID = '$coupleID'");
      $statusQuery = mysqli_query($link, "SELECT * FROM couple_status");
		$retreatQuery = mysqli_query($link, "SELECT * FROM retreats 
                                        JOIN places
			                             ON retreats.placeID = places.placeID
                                      WHERE endDate > CURDATE() 
                                      ORDER BY startDate ASC");   // Join Places and Retreats tables 
  
		$couple = mysqli_fetch_array($coupleQuery);
        $selected = '';
        echo "<li><strong>Couple: </strong><input type='text' name='coupleName' required value='".$couple['name']."' style='width: 200px;'></input></li>";
        echo "<li><strong>Retreat: </strong>";
		echo "<select name='retreat'>";
        echo "<option value='0'>Not Assigned</option>";
		while ($retreats = mysqli_fetch_array($retreatQuery)) {
            $stDate = strtotime($retreats['startDate']);
            $fStDate = date("M d", $stDate);
			if ($retreats['retreatID'] == $couple['retreatID']) {
                $selected = 'selected';
            } else {
                $selected = '';   
            };
            echo "<option value='".$retreats['retreatID']."' $selected>".$retreats['place']." -- ".$fStDate."</option>";
		};
        echo "</select></li><br>";
        echo "<li><strong>Status: </strong>";
        echo "<select name='status'>";
        while ($status = mysqli_fetch_array($statusQuery)) {
            if ($status['statusID'] == $couple['statusID']) {
                $selected = 'selected';
            } else {
                $selected = '';   
            };
            echo "<option value='".$status['statusID']."' $selected>".$status['status'];
        }
		echo "</select></li><br>";
        echo "<input type='hidden' value='$coupleID' name='coupleID'>";
        echo "<li><input type='submit' value='Submit'></li><br>";
	?>
</form>
</div>
