
<head>
    <title>Search Tours!</title>
</head>

<?php
    require "header.php";
    require "inc/dbhandler_inc.php";
    require "inc/functions_inc.php";
    
    $today = date("Y-m-d");
    $date1 = $today;
    $date2 = date("Y-m-d", strtotime("+5 days"));
?>

<!--Search query content-->
    <div class="w3-container" id="searchq" align="center">
        <br>
        <form id="searchTours" action="inc/searchTours_inc.php" method="post">
            
            <div class="search-city">
                <input type="text" name="destcity" autocomplete="off" placeholder="Destination..." value="<?php if(isset($_GET["destcity"])) echo $_GET["destcity"]?>">
                <input type="text" name="origcity" autocomplete="off" placeholder="From.." value="<?php if(isset($_GET["origcity"])) echo $_GET["origcity"]?>">
                &emsp;
            
                <label for="startdate">Leaving on</label>
                <input type="date" name="startdate" class="selector" value="<?php if(isset($_GET["startdate"])) echo $_GET["startdate"]; else echo $date1;?>" min="<?php echo $date1; ?>" required>
                <label for="enddate">Returning</label>
                <input type="date" name="enddate" class="selector" value="<?php if(isset($_GET["enddate"])) echo $_GET["enddate"]; else echo $date2;?>" min="<?php echo $date1; ?>" required>
                &emsp;

                <label for="room">Room Type</label>
                <select name="room" class="selector">
                    <option value="Single">Single Bed</option>
                    <option value="Double">Double Bed</option>
                    <option value="Suite">Suite</option>
                </select>

                <label for="pax">No. of Guests</label>
                <select name="pax" class="selector">
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
            
            <button type="submit" name="searchTour-submit" value="Search">Search
                <i class="fas fa-search"></i>
            </button>
        </form>

    <?php
                
        if (isset($_GET["error"])) {
            
            if ($_GET["error"] == "emptyfields") {
                echo "<p>Fill in all fields!</p>";
            }

            if ($_GET["error"] == "invalidDestCity") {
                echo "<p>Enter valid Destination City!</p>";
            }

            if ($_GET["error"] == "invalidOrigCity") {
                echo "<p>Enter valid Origin City!</p>";
            }

            if ($_GET["error"] == "sqlerror") {
                echo "<p>Something went wrong, please try again!</p>";
            }

        }

    ?>

    </div>

    