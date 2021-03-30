<?php
    session_start();
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];

    date_default_timezone_set("Asia/Kolkata");
?>

<!DOCTYPE html>
<html>
<head>
    <!-- <title>Welcome to travelBuddy!</title> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/5599e0ab03.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel = "icon" href = "img/globe-americas-solid.svg" type = "image/x-icon"> 

    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="style.css?v=1.6">

</head>
<body>


    <header>
        <nav>
            
<!--Nav-Bar-->    
            <div class="w3-cell-row" id="navBar">
                <div class="w3-container w3-cell" style="padding-left: 15px; padding-top: 5px;">
                    <a href="index.php" style="color: Black;">
                       <i class="fas fa-globe-americas fa-3x">travelBuddy</i>
                    </a>
                </div>

                <div class="w3-container w3-cell">
                    <?php
                        if (isset($_SESSION["username"])) {
                            echo "Welcome ".$_SESSION["username"]." (".$_SESSION["email"].") ";
                            echo "<a href=\"myBookings.php\"><button type=\"submit\" name=\"viewBookings\">My Bookings</button></a>";
                        }
                    ?>
                </div>

                <div class="w3-container w3-cell">
                    <a href="searchFlights.php"><button>Flights</button></a>
                    <a href="searchHotels.php"><button>Hotels</button></a>
                    <a href="searchTours.php"><button>Tours</button></a>
                </div>

                <div class="w3-container w3-cell">

                    <?php 
                        if (isset($_SESSION["username"]))
                            echo "<a href=\"inc/logout_inc.php\"><button>Logout</button></a>";

                        if (!isset($_SESSION["username"])):
                    ?>

                        <button onclick="document.getElementById('id01').style.display='block'">Login</button>
                        
                    <?php endif; ?>
                
                </div>
            </div>

        </nav>
    </header>

<!--Login form content-->
    <div id="id01" class="modal">
        <form class="modal-content animate" action="inc/login_inc.php" method="post">
            
            <div class="imgcontainer">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>

            <div class="container">
                <label for="uid"><b>Username</b></label>
                <input type="text" placeholder="Username/Email" name="uid" autocomplete="off" required>

                <br>

                <label for="pwd"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="pwd" required>
                
                <button type="submit" name="login-submit">Login</button>
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>

            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                <span class="psw">Forgot <a href="#">password?</a></span>
            </div>
        </form>
    </div>

    <hr>

<!--Login button action-->
    <script>
    // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>
