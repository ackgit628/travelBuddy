<?php
    require "header.php";
    require "inc/dbhandler_inc.php";
    require "inc/functions_inc.php";
?>

<head>
    <title>Confirm your Booking!</title>
</head>

<h1 style="padding-left: 10px;"><b> Confirm your Booking!</b></h1>

<div class="w3-cell-row">

    <form id="review-guest" action="inc/reviewBooking_inc.php" method="post">

    <div class="w3-container w3-cell" style="width: 75%; border-right: 2px solid lightgrey; padding-left: 20px; padding-right: 100px;">

        <h1>Enter guest information</h1>

        <?php
            $pax = $_GET["pax"]; $i = 1;
            while ($i <= $pax):
        ?>
        
        <p id="GFG_DOWN">Guest <?php echo $i; ?> Details</p> 
        
        <input type="text" name="fname[]" autocomplete="off" placeholder="Firstname">
        <input type="text" name="lname[]" autocomplete="off" placeholder="Lastname">
        <label style="padding-left: 10px;">Gender</label>
        <select name="gender[]" class="selector">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        <label style="padding-left: 10px;">DOB</label>
        <input type="date" name="dob[]" class="selector">
        <br>
        <input type="text" name="phone[]" autocomplete="off" placeholder="Mobile no.">
        <input type="text" name="addr[]" autocomplete="off" placeholder="Address">

        <?php 
            $i++; endwhile; 
            if (isset($_GET["bookerror"])) {
                if ($_GET["bookerror"] = "emptyfields") {
                    echo "<p>Fill in all fields</p>";
                }
            }
        ?>

    </div>

    <div class="w3-container w3-cell" style="padding-left: 50px">
        <?php
            $sub1 = $sub2 = $sub3 = $nrooms = 0;
            $flt1 = $_GET["flt1"];
            $flt2 = $_GET["flt2"];
            $hotel = $_GET["hotel"];
            $sdate = $_GET["startdate"];
            $edate = $_GET["enddate"];
            $room = $_GET["room"];
            $pax = $_GET["pax"];

            // $fltcd1 = substr($flt1, -5);                                //extracting flight code from table data
            // $fltcd2 = substr($flt2, -5);

            //FLT1
            $sql = "SELECT * FROM flights WHERE fltcode=?";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location:../confirmTourBooking.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "s", $flt1);
            mysqli_stmt_execute($stmt);
            $resultData = mysqli_stmt_get_result($stmt);
            $flt1Detail = mysqli_fetch_assoc($resultData);

            $doj1 = date("F j, Y", strtotime($sdate));
            $tod1 = date("G:i", strtotime($flt1Detail['deptime']));
            $toa1 = date("G:i", strtotime($flt1Detail['arrtime']));
            $sub1 = $flt1Detail['fare']*$pax; 

            //FLT2
            $sql = "SELECT * FROM flights WHERE fltcode=?";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location:../confirmTourBooking.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "s", $flt2);
            mysqli_stmt_execute($stmt);
            $resultData = mysqli_stmt_get_result($stmt);
            $flt2Detail = mysqli_fetch_assoc($resultData);

            $doj2 = date("F j, Y", strtotime($edate));
            $tod2 = date("G:i", strtotime($flt2Detail['deptime']));
            $toa2 = date("G:i", strtotime($flt2Detail['arrtime']));
            $sub2 = $flt2Detail['fare']*$pax; 

            //HOTEL
            $sql = "SELECT * FROM hotels WHERE name=?";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: confirmTourBooking.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "s", $hotel);
            mysqli_stmt_execute($stmt);
            $resultData = mysqli_stmt_get_result($stmt);
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
        ?>

        <!-- Flight1 card -->
        <div class="card">
            <h2><?php echo $flt1Detail['airline']." Flight ".$flt1Detail['fltcode']; ?></h2>
            <p><?php echo $flt1Detail['origcity']." to ".$flt1Detail['destcity']; ?></p>
            <p><?php echo $doj1; ?></p>
            <p><?php echo "Departure time: ".$tod1."hrs."; ?></p>
            <p><?php echo "Arrival time: ".$toa1."hrs."; ?></p>
            <p><?php echo "No. of Passengers: ".$pax; ?></p>
            <p style="color: grey"><?php echo "Fare: ₹".$flt1Detail['fare']; ?></p>
            <p class="price"><?php echo "Subtotal: ₹".$sub1; ?></p>
            <!-- <p><button>Add to Cart</button></p> -->
        </div>

        <br>

        <!-- Flight2 card -->
        <div class="card">
            <h2><?php echo $flt2Detail['airline']." Flight ".$flt2Detail['fltcode']; ?></h2>
            <p><?php echo $flt2Detail['origcity']." to ".$flt2Detail['destcity']; ?></p>
            <p><?php echo $doj2; ?></p>
            <p><?php echo "Departure time: ".$tod2."hrs."; ?></p>
            <p><?php echo "Arrival time: ".$toa2."hrs."; ?></p>
            <p><?php echo "No. of Passengers: ".$pax; ?></p>
            <p style="color: grey"><?php echo "Fare: ₹".$flt2Detail['fare']; ?></p>
            <p class="price"><?php echo "Subtotal: ₹".$sub2; ?></p>
            <!-- <p><button>Add to Cart</button></p> -->
        </div>

        <br>
        
        <!-- Hotel card -->
        <div class="card">
            <h2><?php echo $hotelDetail['name'].", ".$hotelDetail['cityname']; ?></h2>
            <p><?php echo $chki." to ".$chko; ?></p>
            <p><?php echo "Room selected: ".$room; ?></p>
            <p><?php echo "No. of Guests: ".$pax; ?></p>
            <p><?php echo "No. of Rooms: ".$nrooms; ?></p>
            <p><?php echo $ndays." nights"; ?></p>
            <p style="color: grey"><?php echo "Rate: ₹".$rate."per night"; ?></p>
            <p class="price"><?php echo "Subtotal: ₹".$sub3; ?></p>
            <!-- <p><button>Add to Cart</button></p> -->
        </div>

        <br>

        <br>

        <?php
            $totv = $sub1 + $sub2 + $sub3;
        ?>

        <div class="card">
            <p class="price"><?php echo "Total Amount: ₹".$totv; ?></p>
            <input type="text" name="flt1" value="<?php echo $flt1; ?>" style="display: none">
            <input type="text" name="flt2" value="<?php echo $flt2; ?>" style="display: none">
            <input type="text" name="hotel" value="<?php echo $hotel; ?>" style="display: none">
            <input type="text" name="sdate" value="<?php echo $sdate; ?>" style="display: none">
            <input type="text" name="edate" value="<?php echo $edate; ?>" style="display: none">
            <input type="text" name="room" value="<?php echo $room; ?>" style="display: none">
            <input type="text" name="pax" value="<?php echo $pax; ?>" style="display: none">
            <input type="text" name="totv" value="<?php echo $totv; ?>" style="display: none">
            <input type="text" name="url" value="<?php echo $_SESSION["url"]; ?>" style="display: none;">
            <p><input type="submit" name="reviewTour-submit" value="Confirm Booking"></p></form>
        </div>

        <br>
    </div>

</div>