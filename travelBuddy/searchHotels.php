
<head>
    <title>Search Hotels!</title>
</head>

<?php
    require "header.php";
    require "inc/dbhandler_inc.php";
    
    $today = date("Y-m-d");
    $date1 = $today;
    $date2 = date("Y-m-d", strtotime("+5 days"));
?>

<!--Search query content-->
    <div class="w3-container" id="searchq" align="center">
        <br>
        <form id="searchHotels" action="inc/searchHotels_inc.php" method="post">
            
            <div class="search-city">
                <i class="fas fa-hotel"></i>
                <input type="text" name="city" autocomplete="off" placeholder="Where do you want to go..." value="<?php if(isset($_GET["city"])) echo $_GET["city"]?>">
                &emsp;
            
                <label for="checkin">Check-in</label>
                <input type="date" name="checkin" class="selector" value="<?php if(isset($_GET["checkin"])) echo $_GET["checkin"]; else echo $date1;?>" min="<?php echo $date1; ?>" required>
                &emsp;
                <label for="checkout">Check-out</label>
                <input type="date" name="checkout" class="selector" value="<?php if(isset($_GET["checkout"])) echo $_GET["checkout"]; else echo $date2;?>" min="<?php echo $date1; ?>" required>
                &emsp;

                <label for="room">Room Type</label>
                <select name="room" class="selector">
                    <!-- <option value="none" selected disabled hidden>Select</option> -->
                    <option value="Single">Single Bed</option>
                    <option value="Double">Double Bed</option>
                    <option value="Suite">Suite</option>
                </select>
                &emsp;

                <label for="pax">No. of Guests</label>
                <select name="pax" class="selector" value="<?php if(isset($_GET["pax"])) echo $_GET["pax"]?>">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                </select>
            </div>
            
            <button type="submit" name="search-submit" value="Search">Search
                <i class="fas fa-search"></i>
            </button>
        </form>

    <?php
                
        if (isset($_GET["error"])) {
            
            if ($_GET["error"] == "emptyfields") {
                echo "<p>Fill in all fields!</p>";
            }

            if ($_GET["error"] == "invalidCity") {
                echo "<p>Enter valid City!</p>";
            }

            if ($_GET["error"] == "sqlerror") {
                echo "<p>Something went wrong, please try again!</p>";
            }

        }

    ?>

    </div>

    <?php
                
        if (isset($_GET["error"]) && $_GET["error"] == "none"):

            $city = $_GET["city"];
            $chki = $_GET["checkin"];
            $chko = $_GET["checkout"];
            $room = $_GET["room"];
            
            // Search by room
            if ($room == "Single") {
                $sql = "SELECT * FROM hotels WHERE cityname=? AND rate1 > 0 ORDER BY rate1";
            }
            if ($room == "Double") {
                $sql = "SELECT * FROM hotels WHERE cityname=? AND rate2 > 0 ORDER BY rate2";
            }
            if ($room == "Suite") {
                $sql = "SELECT * FROM hotels WHERE cityname=? AND rate3 > 0 ORDER BY rate3";
            }

            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location:../searchHotels.php?error=searcherror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "s", $city);
            mysqli_stmt_execute($stmt);
            $resultData = mysqli_stmt_get_result($stmt);
            $resultCheck = mysqli_num_rows($resultData);

            echo "<p style=\"padding-left: 20px\">".$resultCheck." Hotels in ".$city." from ".date("l, j F", strtotime($chki))." to ".date("l, j F", strtotime($chko))."</p>";

    ?>

    <div align="center">
        <table id="table1" style="width: 90%">
            <tr>
                <!-- <th></th> -->
                <th>Hotel Name</th>
                <th>Description</th>
                <th>Rating</th>
                <th>Rate</th>
                <th></th>
            </tr>
            <?php
                
                if ($resultCheck > 0) {
                    while ($hotel = mysqli_fetch_assoc($resultData)) {
                        echo "<tr>";

                        // Get rate by room
                        if ($room == "Single") {
                            $rate = $hotel['rate1'];
                        }
                        if ($room == "Double") {
                            $rate = $hotel['rate2'];
                        }
                        if ($room == "Suite") {
                            $rate = $hotel['rate3'];
                        }

                        // echo "<input id=\"checker\" type=\"checkbox\">";
                        echo "<td name=\"lt\" width=\"15%\">".$hotel['name']."</td>";
                        echo "<td><p align=left>".$hotel['description']."</p><p align=left>Amenities: ".$hotel['amenities']."</p></td>";
                        echo "<td width=\"10%\"><p>";
                            $i = 1;                                                             // display rating here
                            while ($i <= $hotel['rating']) {
                                echo "<i class=\"fa fa-star checked\"></i>";
                                $i++;
                            }
                            while ($i <= 5) {
                                echo "<i class=\"fa fa-star\"></i>";
                                $i++;
                            }
                        echo "</p></td>";
                        echo "<td width=\"10%\">₹".$rate."<br>per night</td>";
                        echo "<td name=\"rt\" width=\"5%\"> <input type=\"radio\" name=\"selection\"> </td>";

                        echo "</tr>";
                    }
                }
            ?>
        </table>
    
    </div>

    <div align="center"> 
        
        <?php

            if (isset($_GET["bookerror"])) {
                
                if ($_GET["bookerror"] == "ef1") {
                    echo "<p>Select Hotel to book!</p>";
                }

                if ($_GET["bookerror"] == "login") {
                    echo "<p>Login to make bookings!</p>";
                }
            }

        ?>

        <form id="bookHotel" action="inc/confirmBooking_inc.php" method="post">
            <input type="text" name="hotel" id="hotel" style="display: none">
            <input type="text" name="checkin" value="<?php if(isset($_GET["checkin"])) echo $_GET["checkin"]?>" style="display: none">
            <input type="text" name="checkout" value="<?php if(isset($_GET["checkout"])) echo $_GET["checkout"]?>" style="display: none">
            <input type="text" name="room" value="<?php if(isset($_GET["room"])) echo $_GET["room"]?>" style="display: none">
            <input type="text" name="pax" value="<?php if(isset($_GET["pax"])) echo $_GET["pax"]?>" style="display: none">
            <input type="text" name="url" value="<?php echo $_SESSION["url"]?>" style="display: none">
            <button type="submit" name="bookHotel-submit">Book</button>
        </form>
    </div>

    <?php endif; ?>

    <script type="text/javascript">
        
        $("#table1 tr").click(function(){
            $(this).addClass('selected').siblings().removeClass('selected');    
            var value=$(this).find('td:first').html();
            $("#hotel").val(value);
        });

    </script>