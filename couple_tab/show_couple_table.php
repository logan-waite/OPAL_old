<?php
	if(!empty($_GET['order'])) {
		if ($_GET['order'] == 'retreat') {
			$orderby = 'ORDER BY sortColumn ASC, couples.retreatID DESC, couples.name';
		} elseif ($_GET['order'] == 'name') {
			$orderby = 'ORDER BY name ASC';
		} elseif ($_GET['order'] == 'status') {
			$orderby = 'ORDER BY couple_status.statusID ASC';
		}
	} else {
		$orderby = 'ORDER BY name ASC';
	}

	$coupleQuery = mysqli_query($link, "SELECT couples.coupleID,
        couples.name,
		couples.retreatID,
		couples.preRetreatCall,
        couples.infoEmail,
        couples.finalEmail,
        couples.shortDescript,
        couple_status.status,
        retreats.startDate,
        retreats.endDate,
        retreats.private,
        retreats.carReserved,
        retreats.houseReserved,
        retreats.restReserved,
        places.place,
        places.maxCouples,
        IFNULL(retreats.endDate, adddate(curdate(), 1460)) as sortColumn
									FROM couples
										JOIN couple_status ON couples.statusID = couple_status.statusID
										LEFT JOIN retreats ON couples.retreatID = retreats.retreatID
										LEFT JOIN places ON retreats.placeID = places.placeID
									WHERE endDate > CURDATE() OR couples.retreatID = '0' AND couples.statusID <> 4
									$orderby");

echo "<table id='coupleTable'>";
	echo "<tr>
			<th><a href='?order=name#couple-tab'>Name <i class='fa fa-chevron-down'></i></a></th>
			<th><a href='?order=retreat#couple-tab'>Retreat <i class='fa fa-chevron-down'></i></a></th>
            <th><a href='?order=status#couple-tab'>Status <i class='fa fa-chevron-down'></i></a></th>
			<th>Paid Status</th>
<!--			<th>Amount Paid</th> -->
			<th>Emails</th>
			<th id='prc'>Pre-Retreat Call</th>
			<th>Notes</th>
		</th>";

		$num = 0;

    while ($couples = mysqli_fetch_array($coupleQuery)) {

        $num++;
        $stDate = strtotime($couples['startDate']);
		$fStDate = date("M d", $stDate);
        $retreatInfo = '';

        // Check Private Retreat
        if ($couples['private'] == 1) {
			$private = "(Private)";
		} else {
			$private = '';
		};

        // Check if couple is assigned to retreat
        if (!empty($couples['retreatID'])) {
            $retreatInfo = $couples['place']." $private -- ".$fStDate;
        } else {
            $retreatInfo = "Not Assigned";
        };

		if ($couples['preRetreatCall'] == 1) {
			$call_status = 'btn-success';
		} else {
			$call_status = 'btn-danger';
		};

		// Determine Full Price of retreats

		if ($couples['placeID'] == 1 && $couples['private'] == 0) { 	//Sundance not private
			$retreatPrice = 3395;
		} elseif ($couples['placeID'] == 2 && $couples['private'] == 0) {	//San Diego not private
			$retreatPrice = 3895;
		} elseif ($couples['placeID'] == 3 && $couples['private'] == 0) {	//Texas Hill Country not private
			$retreatPrice = 3895;
		} elseif ($couples['placeID'] == 1 && $couples['private'] == 1) {	//Sundance Private
			$retreatPrice = 9495;
		} elseif ($couples['placeID'] == 2 && $couples['private'] == 1) {	//San Diego Private
			$retreatPrice = 10495;
		} elseif ($couples['placeID'] == 3 && $couples['private'] == 1) {	//Texas Hill Country Private
			$retreatPrice = 10995;
		};

		$coupleID = $couples['coupleID'];
		$paidQuery = mysqli_query($link, "SELECT * FROM paid_status
									JOIN pay_type ON paid_status.payTypeID = pay_type.payTypeID
									WHERE coupleID = '$coupleID'");

		$paymentStatus = '';
		$totalAmountPaid = 0.00;
        $statusAlert = '';
        $buttonType = '';

		//Determine status of payments
        while ($status = mysqli_fetch_array($paidQuery)) {
			$amountPaid = $status['amountPaid'];
			$totalAmountPaid = $totalAmountPaid + $amountPaid;

			if ($status['payTypeID'] == '3') {
                $statusAlert = 'Paid in Full';
                $buttonType = 'btn-success';
            } else {
                $statusAlert = 'Add Payment';
                $buttonType = 'btn-info';
            };

//            $statusAlert = $status['payType'];

        };

        if (empty($statusAlert)) {
            $statusAlert = 'Make Deposit';
        };
        if (empty($buttonType)) {
            $buttonType = 'btn-danger';
        };

       // Check info email
        if ($couples['infoEmail'] == 1) {
            $infoEmail = "<button class='email btn btn-success'><i class='fa fa-check'></i>&nbsp Info</button>";
        } else {
            $infoEmail = "<button class='email btn btn-danger' onClick='email(1, $coupleID,this)'><i class='fa fa-times'>&nbsp</i> Info</button>";
        };

        // Check final email
        if ($couples['finalEmail'] == 1) {
            $finalEmail = "<button class='email btn btn-success'><i class='fa fa-check'></i>&nbsp Final</button>";
        } else {
            $finalEmail = "<button class='email btn btn-danger' onClick='email(2, $coupleID,this)'><i class='fa fa-times'></i>&nbsp Final</button>";
        };

        // Check misc email
        if ($couples['miscEmail'] == 1) {
            $miscEmail = "<div class='email'><i class='fa fa-check'></i></div>";
        } else {
            $miscEmail = "<div class='email'><i class='fa fa-times' onClick='email(3, $coupleID,this)'></i></div>";
        };

		echo "<tr>
            <!--Edit button for form-->
			<td>".$couples['name']."
                    <i class='edit fa fa-pencil-square-o fa-lg' onClick=\"coupleButton('edit_couple_form.php',$coupleID)\"></i>
            </td>
			<td>".$retreatInfo."</td>
            <td>".$couples['status']."</td>
			<td>
                <button type='button' class='btn $buttonType navbar-btn' onclick=\"coupleButton('make_payment_form.php','$coupleID')\">
                        <i class='fa fa-credit-card fa-lg'></i>&nbsp $statusAlert
                    </button></td>
<!--			<td>$totalAmountPaid / $retreatPrice</td>    -->
			<td>$infoEmail $finalEmail</td>
            <td><button class='btn $call_status' onClick=\"callStatus($coupleID,this)\"><i class='fa fa-phone fa-lg'></i></button></td>
            <td><button class='btn btn-default' onClick=\"coupleButton('view_notes.php', $coupleID)\"><i class='fa fa-sticky-note-o fa-lg'></i></button></td>
            ";
//        echo "<form action='update_call.php' method='post'>
//				<input type='hidden' value='$coupleID' name='coupleID'>
//				<input type='submit' name='updateCall' value='' style='width=2em; height=2em;";
//			if ($call_status) {
//				echo "background-color: green'>";
//			} else {
//				echo "background-color: red'>";
//			};
//		echo "</form></td>";
//		echo "<td><form action='couple_tab/view_notes.php' method='post'>
//				<input type='hidden' value='".$couples['coupleID']."' name='coupleID'>
//				<input type='submit' value='View'>
//				</form></td>";
		echo "</tr>";

	};
	echo "</table>";
?>
