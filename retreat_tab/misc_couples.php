
<div class='table'>

<?php
//    Creates table of couples that are not assigned to a retreat
    
    $coupleList = mysqli_query($link, "SELECT * FROM couples WHERE retreatID = '0' ORDER BY name");
    
    while ($couple = mysqli_fetch_array($coupleList)) {
        $coupleID = $couple['coupleID'];
        echo "<h5>".$couple['name']."<i class='edit fa fa-pencil-square-o' onClick=\"coupleButton('edit_couple_form.php',$coupleID)\"></i></h5>";
        echo "<p>".$couple['shortDescript'];
        echo "</p>";
        echo "<hr>";
    };
?>
</div>
