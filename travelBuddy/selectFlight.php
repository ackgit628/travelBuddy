
<head>
    <title>Select Flight</title>
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


    <div class="w3-cell-row">

        <?php
                    
            if (isset($_GET["error"]) && $_GET["error"] == "none"):

                $orig = $_GET["origcity"];
                $dest = $_GET["destcity"];
                $dept = $_GET["startdate"];
                $retn = $_GET["enddate"];
                $pax = $_GET["pax"];
                $dow1 = dayOfWeek(date("l", strtotime($dept)));              //returns integer value of binary count of day of the week
                $dow2 = dayOfWeek(date("l", strtotime($retn)));              //returns integer value of binary count of day of the week

                //Flight1
                $sql = "SELECT * FROM flights WHERE origcity=? AND destcity=? AND opdays & ? > 0 ORDER BY fare, deptime";
                $stmt = mysqli_stmt_init($conn);                            //prepared statement
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location:../searchFlights.php?error=searcherror");
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "sss", $orig, $dest, $dow1);
                mysqli_stmt_execute($stmt);
                $flt1Data = mysqli_stmt_get_result($stmt);
                $flt1Check = mysqli_num_rows($flt1Data);


                //Flight2
                $sql = "SELECT * FROM flights WHERE origcity=? AND destcity=? AND opdays & ? > 0 ORDER BY fare, deptime";
                $stmt = mysqli_stmt_init($conn);                            //prepared statement
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location:../searchFlights.php?error=searcherror");
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "sss", $orig, $dest, $dow2);
                mysqli_stmt_execute($stmt);
                $flt2Data = mysqli_stmt_get_result($stmt);
                $flt2Check = mysqli_num_rows($flt2Data);
                
        ?>

        <div class="w3-container w3-cell">

            <?php echo "<p>".$flt1Check." Flights from ".$orig." to ".$dest." on ".date("l, j F, Y", strtotime($dept))."</p>"; ?>

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
                    if ($flt1Check > 0) {
                        while ($flt1 = mysqli_fetch_assoc($flt1Data)) {
                            echo "<tr>";

                            echo "<td name=\"lt\">".$flt1['fltcode']."</td>";
                            echo "<td>".$flt1['airline']."</td>";
                            echo "<td>".$flt1['origcity']."</td>";
                            echo "<td>".$flt1['destcity']."</td>";
                            echo "<td>".$flt1['deptime']."</td>";
                            echo "<td>".$flt1['arrtime']."</td>";
                            echo "<td>₹".$flt1['fare']."</td>";
                            echo "<td name=\"rt\" width=\"5%\"> <input type=\"radio\" name=\"selection1\"> </td>";

                            echo "</tr>";
                        }
                    }
                ?>
            </table>

        </div>

        <div class="w3-container w3-cell" style="border-left: 2px solid lightgrey;">

            <?php echo "<p>".$flt2Check." Flights from ".$dest." to ".$orig." on ".date("l, j F, Y", strtotime($retn))."</p>"; ?>

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
                    if ($flt2Check > 0) {
                        while ($flt2 = mysqli_fetch_assoc($flt2Data)) {
                            echo "<tr>";

                            echo "<td name=\"lt\">".$flt2['fltcode']."</td>";
                            echo "<td>".$flt2['airline']."</td>";
                            echo "<td>".$flt2['origcity']."</td>";
                            echo "<td>".$flt2['destcity']."</td>";
                            echo "<td>".$flt2['deptime']."</td>";
                            echo "<td>".$flt2['arrtime']."</td>";
                            echo "<td>₹".$flt2['fare']."</td>";
                            echo "<td name=\"rt\" width=\"5%\"> <input type=\"radio\" name=\"selection2\"> </td>";

                            echo "</tr>";
                        }
                    }
                ?>
            </table>

        </div>

    </div>

    <div align="center">

        <form id="searchFlights" action="inc/searchTours_inc.php" method="post">
            <input type="text" name="flt1" id="flt1" style="display: none">
            <input type="text" name="flt2" id="flt2" style="display: none">
            <input type="text" name="orig" value="<?php echo $_GET["origcity"]?>" style="display: none">
            <input type="text" name="dest" value="<?php echo $_GET["destcity"]?>" style="display: none">
            <input type="text" name="dept" value="<?php echo $_GET["startdate"]?>" style="display: none">
            <input type="text" name="retn" value="<?php echo $_GET["enddate"]?>" style="display: none">
            <input type="text" name="room" value="<?php echo $_GET["room"]?>" style="display: none">
            <input type="text" name="pax" value="<?php echo $_GET["pax"]?>" style="display: none">
            <input type="text" name="url" value="<?php echo $_SESSION["url"]?>" style="display: none">
            <button type="submit" name="bookFlight-submit">Continue</button>
        </form>

    </div>

    <?php 
        endif; 

        echo "<div align=\"center\">";

        if (isset($_GET["bookerror"])) {
            
            if ($_GET["bookerror"] == "ef1") {
                echo "<p>Select Flight to book!</p>";
            }

            if ($_GET["bookerror"] == "ef2") {
                echo "<p>Select both flights to proceed!</p>";
            }

            if ($_GET["bookerror"] == "login" && !isset($_SESSION["username"])) {
                echo "<p>Login to continue!</p>";
            }
        }
    
        echo "</div>";

    ?>


    <script type="text/javascript">

        // document.getElementById("date1").onload = function () {
        //     var input = document.getElementById("date2");
        //     input.setAttribute("min", this.value);
        // }
        
        $("#table1 tr").click(function(){
            $(this).addClass('selected').siblings().removeClass('selected');    
            var value = $(this).find('td:first').html();
            $("#flt1").val(value);
            $("input[name=selection1]").checked;
        });

        $("#table2 tr").click(function(){
            $(this).addClass('selected').siblings().removeClass('selected');    
            var value = $(this).find('td:first').html();
            $("#flt2").val(value);
            radiobtn = document.getElementsByName("selection2");
            radiobtn.checked = true;
        });

    </script>

    