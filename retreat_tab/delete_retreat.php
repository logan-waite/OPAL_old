<head>
    <meta http-equiv="refresh" content="1; url=../index.php#couple-tab/" />
</head>

<?php
    
    include "../db_connect.php";
    
    $retreatID = $_POST['retreat'];

    $deleteRetreatSQL = mysqli_query($link, "DELETE FROM retreats WHERE retreatID = $retreatID");
    $updateCoupleSQL = mysqli_query($link, "UPDATE couples
                                            SET retreatID = 0
                                            WHERE retreatID = $retreatID");
    echo "Retreat Deleted!";

?>