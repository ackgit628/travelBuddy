<?php
    require "header.php";
    require "inc/dbhandler_inc.php";
    require "inc/functions_inc.php";
?>

<head>
    <title>Review your Booking!</title>
    <style type="text/css">
		* {box-sizing: border-box}

    	/*Style the table*/
		.row:after {
			display: table;
			width: 100px;
			margin: 0 ;
		}

		/*Left Column*/
		.leftcolumn {
			margin-left: 50px;
			width: 70%;
		}

		/*Right Column*/
		.rightcolumn {
			float: right;
			margin-right: 50px;
			width: 20%;
		}

		/* Style the contentbox */
		.contentbox {
			margin: auto;
			padding: 0px 12px;
			border: 1px solid #ccc;
			width: 70%;
		}

		/* Style the content */
		.content {
			margin: auto;
			padding: 0px 12px;
		}

		/*Style the fare summary*/
		.summary {
			background-color: #ddd;
			padding: 20px;
			margin-top: 20px; 
		}
    </style>
</head>

<?php

    $pax = $_GET["pax"];
    $flt1 = $flt2 = $dept = $retn = "";
    $hotel = $sdate = $edate = $room = "";
    $resultCheck1 = $resultCheck2 = $resultCheck3 = 0;
    $sub1 = $sub2 = $sub3 = 0;

	if (isset($_GET["flt1"])) {
		$flt1 = $_GET["flt1"];
        $dept = $_GET["sdate"];

        $sql = "SELECT * FROM flights WHERE fltcode=?";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:../reviewBooking.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $flt1);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $resultCheck1 = mysqli_num_rows($resultData);

        if ($resultCheck1 > 0) {
	        	
	        $flt1Detail = mysqli_fetch_assoc($resultData);

	        $doj1 = date("F j, Y", strtotime($dept));
	        $tod1 = date("G:i", strtotime($flt1Detail['deptime']));
	        $toa1 = date("G:i", strtotime($flt1Detail['arrtime']));
	        $sub1 = $flt1Detail['fare']*$pax; 
	    }
	}

	if (isset($_GET["flt2"])) {
		$flt2 = $_GET["flt2"];
        $retn = $_GET["edate"];

        $sql = "SELECT * FROM flights WHERE fltcode=?";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:../confirmFlightBooking.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $flt2);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $resultCheck2 = mysqli_num_rows($resultData);

        if ($resultCheck2 > 0) {
	        	
	        $flt2Detail = mysqli_fetch_assoc($resultData);

	        $doj2 = date("F j, Y", strtotime($retn));
	        $tod2 = date("G:i", strtotime($flt2Detail['deptime']));
	        $toa2 = date("G:i", strtotime($flt2Detail['arrtime']));
	        $sub2 = $flt2Detail['fare']*$pax; 
	    }
	}

	if (isset($_GET["hotel"])) {
	    $hotel = $_GET['hotel'];
	    $sdate = $_GET['sdate'];
	    $edate = $_GET['edate'];
	    $room = $_GET['room'];

		$sql = "SELECT * FROM hotels WHERE name=?";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: confirmTourBooking.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $hotel);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $resultCheck3 = mysqli_num_rows($resultData);

        if ($resultCheck3 > 0) {
	        	
	        $hotelDetail = mysqli_fetch_assoc($resultData);

	        // Get rate by room
	        if ($room == "Single") {
	            $rate = $hotelDetail['rate1'];
	        }
	        if ($room == "Double") {
	            $rate = $hotelDetail['rate2'];
	        }
	        if ($room == "Suite") {
	            $rate = $hotelDetail['rate3'];
	        }

	        $chki = date("F j, Y", strtotime($sdate));
	        $chko = date("F j, Y", strtotime($edate));
	        $ndays = dateDifference($sdate, $edate);
	        $nrooms = ($pax%2 == 0) ? $pax/2 : ($pax+1)/2;
	        $sub3 = $rate*$ndays*$nrooms; 
	    }
	}
?>

<main>
	
	<div class="row">

		<div class="leftcolumn">

			<?php if ($resultCheck1 > 0): ?>
				<div class="contentbox">
					<div class="content">
							<h2><?php echo $flt1Detail['airline']." Flight ".$flt1Detail['fltcode']; ?></h2>
				            <p><?php echo $flt1Detail['origcity']." to ".$flt1Detail['destcity']; ?></p>
				            <p><?php echo $doj1; ?></p>
				            <p><?php echo "Departure time: ".$tod1."hrs."; ?></p>
				            <p><?php echo "Arrival time: ".$toa1."hrs."; ?></p>
					</div>
				</div>	<br>
	        <?php endif; ?>

			<?php if ($resultCheck2 > 0): ?>
				<div class="contentbox">
					<div class="content">
							<h2><?php echo $flt2Detail['airline']." Flight ".$flt2Detail['fltcode']; ?></h2>
				            <p><?php echo $flt2Detail['origcity']." to ".$flt2Detail['destcity']; ?></p>
				            <p><?php echo $doj2; ?></p>
				            <p><?php echo "Departure time: ".$tod2."hrs."; ?></p>
				            <p><?php echo "Arrival time: ".$toa2."hrs."; ?></p>
					</div>
				</div>	<br>
	        <?php endif; ?>

			<?php if ($resultCheck3 > 0): ?>
				<div class="contentbox">
					<div class="content">
							<h2><?php echo $hotelDetail['name'].", ".$hotelDetail['cityname']; ?></h2>
				            <p><?php echo $chki." to ".$chko; ?></p>
				            <p><?php echo "Room selected: ".$room; ?></p>
				            <p><?php echo "No. of Rooms: ".$nrooms; ?></p>
				            <p><?php echo $ndays." nights"; ?></p>
					</div>
				</div>	<br>
	        <?php endif; ?>

		</div>

		<div class="rightcolumn">

			<div class="summary">
				blue
			</div>
			
		</div>

	</div>
</main>