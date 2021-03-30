
<head>
    <title>Select Hotel</title>
</head>

<?php
    require "header.php";
    require "inc/dbhandler_inc.php";
    require "inc/functions_inc.php";
?>

<!--Search query content-->
    <div class="w3-container" id="searchq" align="center">
        <form id="searchTours" action="inc/searchTours_inc.php" method="post">
            
            <div class="search-city">
                <input type="text" name="destcity" autocomplete="off" placeholder="Destination..." value="<?php if(isset($_GET["destcity"])) echo $_GET["destcity"]?>">
                <input type="text" name="origcity" autocomplete="off" placeholder="From.." value="<?php if(isset($_GET["origcity"])) echo $_GET["origcity"]?>">
            
                <label for="startdate">Leaving on</label>
                <input type="date" name="startdate" value="<?php if(isset($_GET["startdate"])) echo $_GET["startdate"]?>" required>
                <label for="enddate">Returning</label>
                <input type="date" name="enddate" value="<?php if(isset($_GET["enddate"])) echo $_GET["enddate"]?>" required>

                <label for="room">Room Type</label>
                <select name="room">
                    <option value="Single">Single Bed</option>
                    <option value="Double">Double Bed</option>
                    <option value="Suite">Suite</option>
                </select>

                <label for="pax">No. of Guests</label>
                <select name="pax">
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

    </div>

    <?php
                
        if (isset($_GET["error"]) && $_GET["error"] == "none"):

            $city = $_GET["destcity"];
            $chki = $_GET["startdate"];
            $chko = $_GET["enddate"];
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
                header("Location:../searchTours.php?error=sqlerror");
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

                        echo "<td name=\"lt\" width=\"15%\">".$hotel['name']."</td>";
                        echo "<td><p align=left>".$hotel['description']."</p><p align=left>".$hotel['amenities']."</p></td>";
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

        <button name="goBack" onclick="goBack()">   <i class="fas fa-arrow-left"></i>  Back    </button>

        <form id="searchFlights" action="inc/searchTours_inc.php" method="post">
            <input type="text" name="hotel" id="hotel" style="display: none">
            <input type="text" name="flt1" value="<?php echo $_GET["flt1"]?>" style="display: none">
            <input type="text" name="flt2" value="<?php echo $_GET["flt2"]?>" style="display: none">
            <input type="text" name="orig" value="<?php echo $_GET["origcity"]?>" style="display: none">
            <input type="text" name="dest" value="<?php echo $_GET["destcity"]?>" style="display: none">
            <input type="text" name="dept" value="<?php echo $_GET["startdate"]?>" style="display: none">
            <input type="text" name="retn" value="<?php echo $_GET["enddate"]?>" style="display: none">
            <input type="text" name="room" value="<?php echo $_GET["room"]?>" style="display: none">
            <input type="text" name="pax" value="<?php echo $_GET["pax"]?>" style="display: none">
            <input type="text" name="url" value="<?php echo $_SESSION["url"]?>" style="display: none">
            <button type="submit" name="bookHotel-submit">Continue</button>
        </form>

    </div>

        
    <?php
        endif;

        echo "<div align=\"center\">";

        if (isset($_GET["bookerror"])) {
            
            if ($_GET["bookerror"] == "ef1") {
                echo "<p>Select Hotel to book!</p>";
            }

            if ($_GET["bookerror"] == "login") {
                echo "<p>Login to make bookings!</p>";
            }
        }

        echo "</div><br><br><br><br><br><br><br><br><br>";

    ?>


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

        ?>

    </div>

    

    <script type="text/javascript">
        
        $("#table1 tr").click(function(){
            $(this).addClass('selected').siblings().removeClass('selected');    
            var value=$(this).find('td:first').html();
            $("#hotel").val(value);
        });

        function goBack() {
            window.history.back();
        }

    </script>