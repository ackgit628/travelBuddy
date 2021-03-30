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

    <form id="validate-guest" action="inc/validateBooking_inc.php" method="post">

    <div class="w3-container w3-cell" style="border-right: 2px solid lightgrey; padding-left: 20px; padding-right: 300px;">

        <h1>Enter guest information</h1>

        <?php
            $pax = $_GET["pax"]; $i = 1;
            while ($i <= $pax):
        ?>
        
        <p id="GFG_DOWN">Guest <?php echo $i; ?> Details</p> 
        
        <input type="text" name="fname[]" autocomplete="off" placeholder="Firstname">
        <input type="text" name="lname[]" autocomplete="off" placeholder="Lastname">
        <label style="padding-left: 10px;">Gender</label>
        <select name="gender[]">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        <label style="padding-left: 10px;">DOB</label>
        <input type="date" name="dob[]">
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
            $sub1 = $nrooms = 0;
            $hotel = $_GET["hotel"];
            $checkin = $_GET["checkin"];
            $checkout = $_GET["checkout"];
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
            $sub1 = $rate*$nights*$nrooms; 
        ?>

        <div class="card">
            <h2><?php echo $hotelDetail['name'].", ".$hotelDetail['cityname']; ?></h2>
            <p><?php echo $chki." to ".$chko; ?></p>
            <p><?php echo "Room selected: ".$room; ?></p>
            <p><?php echo "No. of Guests: ".$pax; ?></p>
            <p><?php echo "No. of Rooms: ".$nrooms; ?></p>
            <p><?php echo $nights." nights"; ?></p>
            <p style="color: grey"><?php echo "Rate: ₹".$rate."per night"; ?></p>
            <p class="price"><?php echo "Subtotal: ₹".$sub1; ?></p>
            <!-- <p><button>Add to Cart</button></p> -->
        </div>

        <br>

        <br>

        <?php
            $totv = $sub1;
        ?>

        <div class="card">
            <p class="price"><?php echo "Total Amount: ₹".$totv; ?></p>
            <input type="text" name="hotel" value="<?php echo $hotel; ?>" style="display: none">
            <input type="text" name="checkin" value="<?php echo $checkin; ?>" style="display: none">
            <input type="text" name="checkout" value="<?php echo $checkout; ?>" style="display: none">
            <input type="text" name="room" value="<?php echo $room; ?>" style="display: none">
            <input type="text" name="pax" value="<?php echo $pax; ?>" style="display: none">
            <input type="text" name="totv" value="<?php echo $totv; ?>" style="display: none">
            <input type="text" name="url" value="<?php echo $_SESSION["url"]; ?>" style="display: none;">
            <p><input type="submit" name="validateHotel-submit" value="Confirm Booking"></p></form>
        </div>

        <br>

</div>