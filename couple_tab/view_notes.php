<style>
	#newNote {
		width = 500px;
		height = 500px;
	}
</style>
<h3><u>Couple Notes</u></h3>
<?php
	include '../db_connect.php';
	
	$coupleID = $_GET['coupleID'];
	
	$coupleQuery = mysqli_query($link, "SELECT couples.*, couple_status.*, retreats.*, places.*
                                FROM couples 
                                    JOIN couple_status ON couples.statusID = couple_status.statusID										                                       JOIN retreats ON couples.retreatID = retreats.retreatID
                                    JOIN places ON retreats.placeID = places.placeID
								WHERE couples.coupleID = $coupleID");
	$couple = mysqli_fetch_array($coupleQuery);
	
	$stDate = strtotime($couple['startDate']);
	$fStDate = date("M d", $stDate);
	
	echo "<li><h4>".$couple['name']."</h4></li>
        <li><h5>".$couple['place']." -- ".$fStDate."</h5></li>";

	$noteQuery = mysqli_query($link, "SELECT * FROM notes WHERE coupleID = $coupleID");
	
	while ($notes = mysqli_fetch_array($noteQuery)) {
		$noteDate = strtotime($notes['noteDate']);
		$fDate = date("M d", $noteDate);
		$note = $notes['noteContent'];
		
		echo "<li><strong>".$fDate."</strong> -- ";
		echo $note."</li>";
	};
	
?>
	<form action='#' method='post' id='addNote'>
        <li><textarea name="newNote" placeholder='Insert New Note Here' autofocus required></textarea></li>
		<?php
			echo "<input type='hidden' name='coupleID' value='".$coupleID."'><br>";
		?>
        <li><input type='submit' value='Submit' onClick="sendOverlay('addNote', 'couple_tab/add_note.php', 'couple-tab')"></li>
	</form>
