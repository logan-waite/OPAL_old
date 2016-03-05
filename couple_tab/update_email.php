<?php
    include '../db_connect.php';
    
    $id = $_GET['id'];
    $coupleID = $_GET['coupleID'];
    
    if ($id == 1) {
        $sql = mysqli_query($link, "UPDATE couples SET infoEmail = 1 WHERE coupleID = '$coupleID'");  
    } else if ($id == 2) {
        $sql = mysqli_query($link, "UPDATE couples SET finalEmail = 1 WHERE coupleID = '$coupleID'");  
    } else if ($id == 3) {
        $sql = mysqli_query($link, "UPDATE couples SET miscEmail = 1 WHERE coupleID = '$coupleID'");  
    };
?>