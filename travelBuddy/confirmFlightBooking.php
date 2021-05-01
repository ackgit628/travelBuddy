<?php
    require "header.php";
    require "inc/dbhandler_inc.php";
?>

<head>
    <title>Confirm your Booking!</title>
</head>

<h1 style="padding-left: 10px;"><b> Confirm your Booking!</b></h1>

<div class="w3-cell-row">

    <form id="validate-passenger" action="inc/validateBooking_inc.php" method="post">

    <div class="w3-container w3-cell" style="width: 76%; border-right: 2px solid lightgrey; padding-left: 20px; padding-right: 100px;">

        <h1>Enter passenger information</h1>

        <?php
        
            if (isset($_GET["bookerror"])) {
                if ($_GET["bookerror"] = "emptyfields") {
                    echo "<center><h4><b>Fill in all fields!</b></h4></center>";
                }
            }

            $pax = $_GET["pax"]; $i = 1;
            while ($i <= $pax):
        ?>
        
        <p id="GFG_DOWN">Passenger <?php echo $i; ?> Details</p> 
        
        <input type="text" name="fname[]" autocomplete="off" placeholder="Firstname">
        <input type="text" name="lname[]" autocomplete="off" placeholder="Lastname">
        <label for="gender" style="padding-left: 10px;">Gender</label>
        <select name="gender[]" class="selector">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        <label for="dob" style="padding-left: 10px;">DOB</label>
        <input type="date" name="dob[]" class="selector">
        <br>
        <input type="text" name="phone[]" autocomplete="off" placeholder="Mobile no.">
        <input type="text" name="addr[]" autocomplete="off" placeholder="Address">

        <?php 
            $i++; endwhile;
        ?>

    </div>

    <div class="w3-container w3-cell" style="padding-left: 50px">
        <?php
            $sub1 = $sub2 = 0;
            $flt1 = $_GET["flt1"];
            $dept = $_GET["dept"];
            $flt2 = $retn = "";

            $sql = "SELECT * FROM flights WHERE fltcode=?";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location:../confirmFlightBooking.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "s", $flt1);
            mysqli_stmt_execute($stmt);
            $resultData = mysqli_stmt_get_result($stmt);
            $flt1Detail = mysqli_fetch_assoc($resultData);

            $doj1 = date("F j, Y", strtotime($dept));
            $tod1 = date("G:i", strtotime($flt1Detail['deptime']));
            $toa1 = date("G:i", strtotime($flt1Detail['arrtime']));
            $sub1 = $flt1Detail['fare']*$pax; 
        ?>

        <div class="card">
            <h2><?php echo $flt1Detail['airline']." Flight ".$flt1Detail['fltcode']; ?></h2>
            <p><?php echo $flt1Detail['origcity']." to ".$flt1Detail['destcity']; ?></p>
            <p><?php echo $doj1; ?></p>
            <p><?php echo "Departure time: ".$tod1."hrs."; ?></p>
            <p><?php echo "Arrival time: ".$toa1."hrs."; ?></p>
            <p><?php echo "No. of Passengers: ".$pax; ?></p>
            <p style="color: grey"><?php echo "Fare: ₹".$flt1Detail['fare']; ?></p>
            <p class="price" style="text-align: left; padding: 10px 15px;">Subtotal:<span style="float: right; font-weight: bold;">₹<?php echo $sub1; ?></span></p>
            <!-- <p><button>Add to Cart</button></p> -->
        </div>

        <br>

        <?php 
            if ($_GET["trip"] === "round"): 
                $flt2 = $_GET["flt2"];
                $retn = $_GET["retn"];

                $sql = "SELECT * FROM flights WHERE fltcode=?";
                $stmt = mysqli_stmt_init($conn);                            //prepared statement
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location:../confirmFlightBooking.php?error=sqlerror");
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "s", $flt2);
                mysqli_stmt_execute($stmt);
                $resultData = mysqli_stmt_get_result($stmt);
                $flt2Detail = mysqli_fetch_assoc($resultData);

                $doj2 = date("F j, Y", strtotime($retn));
                $tod2 = date("G:i", strtotime($flt2Detail['deptime']));
                $toa2 = date("G:i", strtotime($flt2Detail['arrtime']));
                $sub2 = $flt2Detail['fare']*$pax; 
        ?>

        <div class="card">
            <h2><?php echo $flt2Detail['airline']." Flight ".$flt2Detail['fltcode']; ?></h2>
            <p><?php echo $flt2Detail['origcity']." to ".$flt2Detail['destcity']; ?></p>
            <p><?php echo $doj2; ?></p>
            <p><?php echo "Departure time: ".$tod2."hrs."; ?></p>
            <p><?php echo "Arrival time: ".$toa2."hrs."; ?></p>
            <p><?php echo "No. of Passengers: ".$pax; ?></p>
            <p style="color: grey"><?php echo "Fare: ₹".$flt2Detail['fare']; ?></p>
            <p class="price" style="text-align: left; padding: 10px 15px;">Subtotal:<span style="float: right; font-weight: bold;">₹<?php echo $sub2; ?></span></p>
            <!-- <p><button>Add to Cart</button></p> -->
        </div>

        <br>

        <?php
            endif; 
            $totv = $sub1 + $sub2;
        ?>

        <div class="card">
            <p class="price" style="text-align: left; padding: 10px 15px;">Total Amount:<span style="float: right; font-weight: bold;">₹<?php echo $totv; ?></span></p>
            <input type="text" name="flt1" value="<?php echo $flt1; ?>" style="display: none">
            <input type="text" name="flt2" value="<?php echo $flt2; ?>" style="display: none">
            <input type="text" name="dept" value="<?php echo $dept; ?>" style="display: none">
            <input type="text" name="retn" value="<?php echo $retn; ?>" style="display: none">
            <input type="text" name="pax" value="<?php echo $pax; ?>" style="display: none">
            <input type="text" name="totv" value="<?php echo $totv; ?>" style="display: none">
            <input type="text" name="url" value="<?php echo $_SESSION["url"]; ?>" style="display: none;">
            <p><input type="submit" name="validateFlight-submit" value="Confirm Booking"></p></form>
        </div>

        <br>

</div>