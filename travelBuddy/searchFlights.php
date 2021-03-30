
<head>
    <title>Search Flights!</title>
</head>

<?php
    require "header.php";
    require "inc/functions_inc.php";
    require "inc/dbhandler_inc.php";
    $today = date("Y-m-d");
?>

<!--Search query content-->
    <div class="w3-container" id="searchq" align="center">
        <form id="searchFlights" action="inc/searchFlights_inc.php" method="post">
            
            <input type="radio" name="trip" value="single" <?php if(!isset($_GET["trip"]) || $_GET["trip"] == "single"): ?>checked="checked"<?php endif ?> align="left"> One-Way
            <input type="radio" name="trip" value="round" <?php if(isset($_GET["trip"]) && $_GET["trip"] == "round"): ?>checked="checked"<?php endif ?>> Round-Trip
            
            <div class="search-city">
                <i class="fas fa-plane-departure"></i>
                <input type="text" name="origin" autocomplete="off" placeholder="Origin..." value="<?php if(isset($_GET["orig"])) echo $_GET["orig"]?>">
                <i class="fas fa-plane-arrival"></i>
                <input type="text" name="destination" autocomplete="off" placeholder="Destination..." value="<?php if(isset($_GET["dest"])) echo $_GET["dest"]?>">
            
                <label for="departure">Departure</label>
                <input type="date" name="departure" id="date1" value="<?php if(isset($_GET["dept"])) echo $_GET["dept"]; else echo $today;?>" min="<?php echo $today; ?>" required>
                <label for="return">Return</label>
                <input type="date" name="return" id="date2" value="<?php if(isset($_GET["retn"])) echo $_GET["retn"]?>">

                <label for="pax">No. of Passengers</label>
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

        <?php
                    
            if (isset($_GET["error"])) {
                
                if ($_GET["error"] == "emptyfields") {
                    echo "<p>Fill in all fields!</p>";
                }

                if ($_GET["error"] == "invalidOrigCity") {
                    echo "<p>Enter valid Origin City!</p>";
                }

                if ($_GET["error"] == "invalidDestCity") {
                    echo "<p>Enter valid Destination City!</p>";
                }

                if ($_GET["error"] == "invalidDestination") {
                    echo "<p>Origin and Destination cannot be same!</p>";
                }

                if ($_GET["error"] == "emptytrip") {
                    echo "<p>Select One-Way or Round-Trip!</p>";
                }

                if ($_GET["error"] == "emptyreturn") {
                    echo "<p>Enter Return Date!</p>";
                }

                if ($_GET["error"] == "sqlerror") {
                    echo "<p>Something went wrong, please try again!</p>";
                }
            }

        ?>

    </div>

    <div class="w3-cell-row">

        <?php
                    
            if (isset($_GET["error"]) && $_GET["error"] == "none"):

                $orig = $_GET["orig"];
                $dest = $_GET["dest"];
                $dept = $_GET["dept"];
                $pax = $_GET["pax"];

                $dow1 = dayOfWeek(date("l", strtotime($dept)));              //returns integer value of binary count of day of the week

                $sql = "SELECT * FROM flights WHERE origcity=? AND destcity=? AND opdays & ? > 0 ORDER BY fare, deptime";
                $stmt = mysqli_stmt_init($conn);                            //prepared statement
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location:../searchFlights.php?error=searcherror");
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "sss", $orig, $dest, $dow1);
                mysqli_stmt_execute($stmt);
                $resultData = mysqli_stmt_get_result($stmt);
                $resultCheck = mysqli_num_rows($resultData);
                
        ?>

        <div class="w3-container w3-cell">

            <?php echo "<p>".$resultCheck." Flights from ".$orig." to ".$dest." on ".date("l, j F, Y", strtotime($dept))."</p>"; ?>

            <table id="table1">
                <tr>
                    <th>Flight Code</th>
                    <th>Airline</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Fare</th>
                    <th></th>
                </tr>
                <?php
                    if ($resultCheck > 0) {
                        while ($flt = mysqli_fetch_assoc($resultData)) {
                            echo "<tr>";

                            echo "<td name=\"lt\">".$flt['fltcode']."</td>";
                            echo "<td>".$flt['airline']."</td>";
                            echo "<td>".$flt['origcity']."</td>";
                            echo "<td>".$flt['destcity']."</td>";
                            echo "<td>".$flt['deptime']."</td>";
                            echo "<td>".$flt['arrtime']."</td>";
                            echo "<td>₹".$flt['fare']."</td>";
                            echo "<td name=\"rt\" width=\"5%\"> <input type=\"radio\" name=\"selection\"> </td>";

                            echo "</tr>";
                        }
                    }
                ?>
            </table>

        </div>

        <?php endif; ?>

        <?php
                
            if (isset($_GET["error"]) && $_GET["error"] == "none" && $_GET["trip"] == "round"):

                $retn = $_GET["retn"];
                
                $dow2 = dayOfWeek(date("l", strtotime($retn)));              //returns integer value of binary count of day of the week

                $sql = "SELECT * FROM flights WHERE origcity=? AND destcity=? AND opdays & ? > 0 ORDER BY fare, deptime";
                $stmt = mysqli_stmt_init($conn);                            //prepared statement
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location:../searchFlights.php?error=searcherror");
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "sss", $orig, $dest, $dow2);
                mysqli_stmt_execute($stmt);
                $resultData = mysqli_stmt_get_result($stmt);
                $resultCheck = mysqli_num_rows($resultData);

        ?>

        <div class="w3-container w3-cell" style="border-left: 2px solid lightgrey;">

            <?php echo "<p>".$resultCheck." Flights from ".$dest." to ".$orig." on ".date("l, j F, Y", strtotime($retn))."</p>"; ?>

            <table id="table2">
                <tr>
                    <th>Flight Code</th>
                    <th>Airline</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Fare</th>
                    <th></th>
                </tr>
                <?php
                    if ($resultCheck > 0) {
                        while ($flt = mysqli_fetch_assoc($resultData)) {
                            echo "<tr>";

                            echo "<td name=\"lt\">".$flt['fltcode']."</td>";
                            echo "<td>".$flt['airline']."</td>";
                            echo "<td>".$flt['origcity']."</td>";
                            echo "<td>".$flt['destcity']."</td>";
                            echo "<td>".$flt['deptime']."</td>";
                            echo "<td>".$flt['arrtime']."</td>";
                            echo "<td>₹".$flt['fare']."</td>";
                            echo "<td name=\"rt\" width=\"5%\"> <input type=\"radio\" name=\"selection\"> </td>";

                            echo "</tr>";
                        }
                    }
                ?>
            </table>

        </div>

        <?php endif; ?>

    </div>

    <div align="center">

        <?php

            if (isset($_GET["bookerror"])) {
                
                if ($_GET["bookerror"] == "ef1") {
                    echo "<p>Select Flight to book!</p>";
                }

                if ($_GET["bookerror"] == "ef2") {
                    echo "<p>Select both flights!</p>";
                }

                if ($_GET["bookerror"] == "login" && !isset($_SESSION["username"])) {
                    echo "<p>Login to book flights!</p>";
                }
            }

            if (isset($_GET["error"]) && $_GET["error"] == "none"): 
        ?>

        <form id="searchFlights" action="inc/confirmBooking_inc.php" method="post">
            <input type="text" name="flt1" id="flt1" style="display: none">
            <input type="text" name="flt2" id="flt2" style="display: none">
            <input type="text" name="trip" value="<?php echo $_GET["trip"]?>" style="display: none">
            <input type="text" name="dept" value="<?php echo $_GET["dept"]?>" style="display: none">
            <input type="text" name="retn" value="<?php echo $_GET["retn"]?>" style="display: none">
            <input type="text" name="pax" value="<?php echo $_GET["pax"]?>" style="display: none">
            <input type="text" name="url" value="<?php echo $_SESSION["url"]?>" style="display: none">
            <button type="submit" name="bookFlight-submit">Book</button>
        </form>

    </div>

        <?php endif; ?>

    <script type="text/javascript">

        document.getElementById("date1").onload = function () {
            var input = document.getElementById("date2");
            input.setAttribute("min", this.value);
        }
        
        $("#table1 tr").click(function(){
            $(this).addClass('selected').siblings().removeClass('selected');    
            var value=$(this).find('td:first').html();
            $("#flt1").val(value);
        });

        $("#table2 tr").click(function(){
            $(this).addClass('selected').siblings().removeClass('selected');    
            var value=$(this).find('td:first').html();
            $("#flt2").val(value);
        });

    </script>