<?php
    include "../db_connect.php";

    $couples = array();

    $couplesQuery = mysqli_query($link, "SELECT couples.coupleID,
                                                couples.name
                                        FROM couples
       							        ORDER BY name");
?>
<h2>Delete Retreat</h2>
<div class='alert alert-danger'>
    Are you sure you want to delete this couple? This cannot be undone!
</div>
<form action='retreat_tab/delete_retreat.php' method='post'>
    <label for="retreats">Couples: </label>
    <select name='retreat' id='retreats'>
    <?php
        while ($row = mysqli_fetch_array($couplesQuery)) {      
        
            echo "<option value='".$row['coupleID']."'>".$row['name']."</option>";
        }
    ?>
    </select><br>
    <input type="submit" value='Delete'>
    <?php
    ?>
</form>