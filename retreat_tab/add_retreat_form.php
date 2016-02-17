

<!--

Create the form for adding a retreat
Form submits to add_retreat.php

-->

<h2>Add Retreat</h2>

<form action='retreat_tab/add_retreat.php' method='post' name='addRetreatForm'>
	
	<li><strong>Retreat: </strong>
	<select name='retreat'> 
		<?php
			include '../db_connect.php';
			
			$placeQuery = mysqli_query($link, "SELECT * FROM places");		//Select places for retreats

			while ($places = mysqli_fetch_array($placeQuery)) { //loop places
				echo "<option value='".$places['placeID']."'>".$places['place']."</option>";
			};
		?>
    </select></li><br>
	
    <li><label for="from">Start Date: </label>
<input type='text' id='from' class='datepicker' name='startDate' required></li><br>
	
    <li><strong>End Date: </strong>
        <input type='text' id='to' class='datepicker' name='endDate' required></li><br>
	
    <li><strong>Private: </strong>
        <input type='checkbox' value='1' name='private' style='margin:0'></li><br>
    <li><input type='submit' value='Submit'></li>
</form>
