
        <h3>Make Payment</h3>
        
<form action='#' method='post' id='makePayment'>
<?php
	include '../db_connect.php';
	
    $coupleID = $_GET['coupleID'];
	//Choose couple
	$coupleQuery = mysqli_query($link, "SELECT couples.*, paid_status.*, retreats.* FROM couples
                                    LEFT JOIN paid_status ON couples.coupleID = paid_status.coupleID
                                    JOIN retreats ON couples.retreatID = retreats.retreatID
                                    WHERE couples.coupleID = '$coupleID'");
	
    $coupleName = '';
    $retreatPrice = '';
    $pastPaid = '';
    
    while ($couple = mysqli_fetch_array($coupleQuery)) {
        $coupleName = $couple['name'];
        
        if ($couple['placeID'] == 1 && $couple['private'] == 0) { 	//Sundance not private
            $retreatPrice = 3395;
	   } elseif ($couple['placeID'] == 2 && $couple['private'] == 0) {	//San Diego not private
            $retreatPrice = 3895;
        } elseif ($couple['placeID'] == 3 && $couple['private'] == 0) {	//Texas Hill Country not private
            $retreatPrice = 3895;
	   } elseif ($couple['placeID'] == 1 && $couple['private'] == 1) {	//Sundance Private
            $retreatPrice = 9495;
	   } elseif ($couple['placeID'] == 2 && $couple['private'] == 1) {	//San Diego Private
            $retreatPrice = 10495;
	   } elseif ($couple['placeID'] == 3 && $couple['private'] == 1) {	//Texas Hill Country Private
            $retreatPrice = 10995;
	   };
    
       if (!$couple['amountPaid']) {
            $amountPaid = 0;
        } else {
            $amountPaid = $couple['amountPaid'];
        };
        $pastPaid += $amountPaid;

    };
	echo "<li><strong style='font-size: 14pt'>".$coupleName."</strong></li>";
    echo "<li><strong>Amount remaining: </strong>".($retreatPrice - $pastPaid)." of $retreatPrice</li>";
	echo "<li><strong>Amount being paid: </strong>";
    echo "<input type='hidden' name='couple' value='$coupleID'>";
	echo "<input type='text' name='amountPaid' autofocus required></li>";
	echo "<li><input type='submit' value='Submit' onClick=\"sendOverlay('makePayment', 'couple_tab/make_payment.php', 'couple-tab')\"></li>";
	
?>
</form>