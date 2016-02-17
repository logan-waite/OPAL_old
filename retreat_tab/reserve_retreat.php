<?php
    include '../db_connect.php';

    $id = $_GET['id'];
    $retreatID = $_GET['retreatID'];
        
if ($id == 1) {
        $sql = mysqli_query($link, "UPDATE retreats SET carReserved = 1 WHERE retreatID = '$retreatID'");
    } else if ($id == 2) {
        $sql = mysqli_query($link, "UPDATE retreats SET houseReserved = 1 WHERE retreatID = '$retreatID'");  
    } else if ($id == 3) {
        $sql = mysqli_query($link, "UPDATE retreats SET restReserved = 1 WHERE retreatID = '$retreatID'");  
    };
?>
