<?php
    require "header.php";
    require "inc/dbhandler_inc.php";
    require "inc/functions_inc.php";
?>

<head>
    <title>Confirm your Booking!</title>
    <style type="text/css">
        .card {
            text-align: left;
            width: auto;
            padding: 15px;
        }
    </style>
</head>

<!-- Footer containing Flight Information -->
<div class="footer" align="center">

    <?php

        $flt1 = $_GET["flt1"];
        $flt2 = $_GET["flt2"];
        $dept = $_GET["startdate"];
        $retn = $_GET["enddate"];
        $pax = $_GET["pax"];

        //Flight1
        $sql1 = "SELECT * FROM flights WHERE fltcode=?";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql1)) {
            header("Location:searchTours.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $flt1);
        mysqli_stmt_execute($stmt);
        $flt1Data = mysqli_stmt_get_result($stmt);
        $flt1Check = mysqli_num_rows($flt1Data);
        $flt1 = mysqli_fetch_assoc($flt1Data);

        //Flight2
        $sql2 = "SELECT * FROM flights WHERE fltcode=?";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql2)) {
            header("Location:searchTours.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $flt2);
        mysqli_stmt_execute($stmt);
        $flt2Data = mysqli_stmt_get_result($stmt);
        $flt2Check = mysqli_num_rows($flt2Data);
        $flt2 = mysqli_fetch_assoc($flt2Data);


        $doj1 = date("F j, Y", strtotime($dept));                   //date of journey
        $tod1 = date("G:i", strtotime($flt1['deptime']));           //departure time
        $toa1 = date("G:i", strtotime($flt1['arrtime']));           //arrival time

        $doj2 = date("F j, Y", strtotime($retn));                   //date of journey
        $tod2 = date("G:i", strtotime($flt2['deptime']));           //departure time
        $toa2 = date("G:i", strtotime($flt2['arrtime']));           //arrival time

        $flt1cd = $flt1["fltcode"];
        $flt2cd = $flt2["fltcode"];


        echo "<div class=\"w3-cell-row\">";
        echo "<div class=\"w3-container w3-cell\">";
        echo "<b>".$flt1["airline"]." ".$flt1["fltcode"]."</b>";
        echo "<br>".$doj1;
        echo "<br>(".$flt1["origcode"].") ".$flt1["origcity"]." ---> (".$flt1["destcode"].") ".$flt1["destcity"];
        echo "<br>".$tod1."hrs ---- ".$toa1."hrs";
        echo "<br>Fare: ₹".$flt1['fare'];
        echo "</div>";
        echo "<div class=\"w3-container w3-cell\">";
        echo "<b>".$flt2["airline"]." ".$flt2["fltcode"]."</b>";
        echo "<br>".$doj2;
        echo "<br>(".$flt2["origcode"].") ".$flt2["origcity"]." ---> (".$flt2["origcode"].") ".$flt2["destcity"];
        echo "<br>".$tod2."hrs ---- ".$toa2."hrs";
        echo "<br>Fare: ₹".$flt2['fare'];
        echo "</div>";
        echo "</div>";

        $sub1 = $flt1['fare'] * $pax;
        $sub2 = $flt2['fare'] * $pax;
        $sub3 = $sub1 + $sub2;

    ?>

</div>

<h1 style="padding-left: 10px;"><b> Confirm your Booking!</b></h1>

<div class="w3-cell-row">

    <form id="validate-guest" action="inc/validateBooking_inc.php" method="post">

<!-- Container for Guest Information -->
    <div class="w3-container w3-cell" style="width: 78%; border-right: 2px solid lightgrey; padding-left: 20px; padding-right: 100px;">

        <h1>Enter guest information</h1>

        <?php
            $i = 1;
            while ($i <= $pax):
        ?>
        
        <p id="GFG_DOWN">Guest <?php echo $i; ?> Details</p> 
        
        <input type="text" name="fname[]" autocomplete="off" placeholder="Firstname">
        <input type="text" name="lname[]" autocomplete="off" placeholder="Lastname">
        <label style="padding-left: 10px;" for="gender">Gender</label>
        <select name="gender[]" class="selector">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        <label style="padding-left: 10px;" for="dob">DOB</label>
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

        <br><br><br><br><br><br><br><br><br>

    </div>

<!-- Container for Hotel Information -->
    <div class="w3-container w3-cell" style="padding-left: 50px">
        <?php
            $hotel = $_GET["hotel"];
            $checkin = $_GET["startdate"];
            $checkout = $_GET["enddate"];
            $room = $_GET["room"];
            $pax = $_GET["pax"];

            $sql = "SELECT * FROM hotels WHERE name=?";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: confirmHotelBooking.php?error=sqlerror");
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

            $chki = date("F j, Y", strtotime($checkin));
            $chko = date("F j, Y", strtotime($checkout));
            $nights = dateDifference($checkin, $checkout);
            $nrooms = ($pax%2 == 0) ? $pax/2 : ($pax+1)/2;
            $sub4 = $rate*$nights*$nrooms; 
        ?>

        <div class="card">
            <!-- <h4><b>Fare Summary</b></h4>
            Base Fare: <span style="float: right; font-weight: bold;">₹<?php echo $sub1; ?></span>
            <hr>
            Convenience Fee: <span style="float: right; font-weight: bold;">₹100</span>
            <hr style="display: block; border: 1px solid #ddd;">
            <p><b>Grand Total:</b> <span style="float: right; font-weight: bold;">₹<?php echo $sub1+100; ?></span> </p> -->

            <h4><b><?php echo $flt1['airline']." ".$flt1['fltcode']; ?></b></h4>
            <p><?php echo $doj1; ?>
            <span style="float: right; font-weight: bold;">₹<?php echo $sub1; ?></span></p>
            <h4><b><?php echo $flt2['airline']." ".$flt2['fltcode']; ?></b></h4>
            <p><?php echo $doj2; ?>
            <span style="float: right; font-weight: bold;">₹<?php echo $sub2; ?></span></p>
            <p class="price">Subtotal:<span style="float: right; font-weight: bold;">₹<?php echo $sub3; ?></span></p>
            <!-- <p><button>Add to Cart</button></p> -->
        </div>

        <br>

        <div class="card" style="text-align: center;">
            <h2><?php echo $hotelDetail['name'].", ".$hotelDetail['cityname']; ?></h2>
            <p><?php echo $chki." to ".$chko; ?></p>
            <p><?php echo "Room selected: ".$room; ?></p>
            <p><?php echo "No. of Guests: ".$pax; ?></p>
            <p><?php echo "No. of Rooms: ".$nrooms; ?></p>
            <p><?php echo $nights." nights"; ?></p>
            <p style="color: grey"><?php echo "Rate: ₹".$rate."per night"; ?></p>
            <p class="price" style="text-align: left;">Subtotal:<span style="float: right; font-weight: bold;">₹<?php echo $sub4; ?></span></p>
            <!-- <p><button>Add to Cart</button></p> -->
        </div>

        <br>


        <br>

        <?php
            $totv = $sub3 + $sub4;
        ?>

        <div class="card">
            <p class="price" style="text-align: left;">Total Amount:<span style="float: right; font-weight: bold;">₹<?php echo $totv; ?></span></p>
            <input type="text" name="flt1" value="<?php echo $flt1cd; ?>" style="display: none">
            <input type="text" name="flt2" value="<?php echo $flt2cd; ?>" style="display: none">
            <input type="text" name="hotel" value="<?php echo $hotel; ?>" style="display: none">
            <input type="text" name="sdate" value="<?php echo $dept; ?>" style="display: none">
            <input type="text" name="edate" value="<?php echo $retn; ?>" style="display: none">
            <input type="text" name="room" value="<?php echo $room; ?>" style="display: none">
            <input type="text" name="pax" value="<?php echo $pax; ?>" style="display: none">
            <input type="text" name="totv" value="<?php echo $totv; ?>" style="display: none">
            <input type="text" name="url" value="<?php echo $_SESSION["url"]; ?>" style="display: none;">
            <p><input type="submit" name="validateTour-submit" value="Confirm Booking"></p></form>
        </div>

        <br>


    <br><br><br><br><br><br><br><br><br>

</div>