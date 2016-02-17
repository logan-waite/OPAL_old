<?php
    include "../db_connect.php";

    $retreats = array();

    $retreatQuery = mysqli_query($link, "SELECT retreats.retreatID,
                                                retreats.startDate,
                                                retreats.endDate,
                                                places.place
                                        FROM retreats
                                        JOIN places
                                            ON retreats.placeID = places.placeID
                                        WHERE endDate > CURDATE() 
       							        ORDER BY startDate ASC");
?>
<h2>Delete Retreat</h2>
<div class='alert alert-danger'>
    Are you sure you want to delete this retreat? This cannot be undone!
</div>
<form action='retreat_tab/delete_retreat.php' method='post'>
    <label for="retreats">Retreats: </label>
    <select name='retreat' id='retreats'>
    <?php
        while ($row = mysqli_fetch_array($retreatQuery)) {

            // Format Date strings
            $stDate = date("M d", strtotime($row['startDate']));
            $endDate = date("M d", strtotime($row['endDate']));        
        
            echo "<option value='".$row['retreatID']."'>".$row['place']." -- ".$stDate."</option>";
        }
    ?>
    </select><br>
    <input type="submit" value='Delete'>
    <?php
    ?>
</form>