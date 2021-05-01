<?php
    require "header.php";
    $today = date("Y-m-d");

    $date1 = $today;
    $date2 = date("Y-m-d", strtotime("+5 days"));
?>

<head>
    <title>Welcome to travelBuddy!</title>
</head>

<main>
    
    <div class="w3-cell-row" >

    <?php 
        if (!isset($_SESSION["username"])):
    ?>

        <div class="w3-container w3-cell" style="width: 35%; border-right: 2px solid lightgrey;">
            <p align=center>
                <b>Existing User? </b>
                <button onclick="document.getElementById('id01').style.display='block'">Login</button>
            </p>


    <!--Register form content-->
            <form id="signup_form" action="inc/signup_inc.php" method="post">
                <h4><b>New User? Register now</b></h4>
                <input type="text" name="fname" autocomplete="off" placeholder="First-name.." value="<?php if(isset($_GET["fname"])) echo $_GET["fname"]?>">
                <input type="text" name="lname" autocomplete="off" placeholder="Last-name.." value="<?php if(isset($_GET["lname"])) echo $_GET["lname"]?>">
                <br>
                <input type="text" name="uname" autocomplete="off" placeholder="Username.." value="<?php if(isset($_GET["uname"])) echo $_GET["uname"]?>">
                <br>                
                <input type="text" name="email" autocomplete="off" placeholder="Email-id.." value="<?php if(isset($_GET["email"])) echo $_GET["email"]?>">
                <input type="text" name="phone" autocomplete="off" placeholder="Phone-no.." value="<?php if(isset($_GET["phone"])) echo $_GET["phone"]?>">
                <br>
                <input type="password" name="pass1" placeholder="New Password.." required>
                <input type="password" name="pass2" placeholder="Confirm Password.." required>
                <br>
                &emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                <button type="submit" name="signup-submit">Submit</button>
            </form>
            <?php
                
                if (isset($_GET["error"])) {
                    
                    if ($_GET["error"] == "emptyfields") {
                        echo "<p>Fill in all fields!</p>";
                    }

                    if ($_GET["error"] == "invalidemail") {
                        echo "<p>Enter valid Email-id!</p>";
                    }

                    if ($_GET["error"] == "invalidusername") {
                        echo "<p>Enter valid Username!</p>";
                    }

                    if ($_GET["error"] == "incorrectpassword") {
                        echo "<p>Passwords do not match!</p>";
                    }

                    if ($_GET["error"] == "userexists") {
                        echo "<p>User already registered!</p>";
                    }

                    if ($_GET["error"] == "none") {
                        echo "<h4 align=\"center\"><b>Sign-up Successful!</b></h4>";
                    }
                }

            ?>
        </div>

<!--Search query content-->
        <div class="w3-container w3-cell" id="searchq" align="center">
            <form id="searchFlights" action="inc/searchFlights_inc.php" method="post">
                <p></p>
                <label>
                    <input type="radio" checked="checked" name="trip" value="single" align="left"> One-Way
                </label>
                <label>
                    <input type="radio" name="trip" value="round" > Round-Trip
                </label>
                
                <div class="search-city">
                    <i class="fas fa-plane-departure"></i>
                    <input type="text" name="origin" autocomplete="off" placeholder="Origin..." >
                    &emsp;
                    <i class="fas fa-plane-arrival"></i>
                    <input type="text" name="destination" autocomplete="off" placeholder="Destination..." >
                    &emsp;

                    <label for="pax">No. of Passengers</label>
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
                    &emsp;

                    <br>
                
                    <label for="departure">Departure</label>
                    <input type="date" name="departure" class="selector" value="<?php echo $date1; ?>" min="<?php echo $date1; ?>" required>
                    &emsp;
                    <label for="departure">Return</label>
                    <input type="date" name="return" class="selector" value="<?php echo $date2; ?>" min="<?php echo $date1; ?>">

                    <!-- <p></p> -->

                    <p></p>

                </div>
                
                <button type="submit" name="search-submit" value="Search">Search
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

    <?php endif;
        if (isset($_SESSION["username"])):
    ?>

    <!--Search query content-->
        <div class="w3-container w3-cell" id="searchq" align="center">
            <form id="searchFlights" action="inc/searchFlights_inc.php" method="post">
                <p></p>
                <label>
                    <input type="radio" checked="checked" name="trip" value="single" align="left"> One-Way
                </label>
                <label>
                    <input type="radio" name="trip" value="round" > Round-Trip
                </label>
                
                <div class="search-city">
                    <i class="fas fa-plane-departure"></i>
                    <input type="text" name="origin" autocomplete="off" placeholder="Origin..." >
                    &emsp;
                    <i class="fas fa-plane-arrival"></i>
                    <input type="text" name="destination" autocomplete="off" placeholder="Destination..." >
                    &emsp;

                    <label for="pax">No. of Passengers</label>
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
                    &emsp;
                
                    <label for="departure">Departure</label>
                    <input type="date" name="departure" class="selector" value="<?php echo $date1; ?>" min="<?php echo $date1; ?>" required>
                    &emsp;
                    <label for="departure">Return</label>
                    <input type="date" name="return" class="selector" value="<?php echo $date2; ?>" min="<?php echo $date1; ?>">

                    <p></p>

                </div>
                
                <button type="submit" name="search-submit" value="Search">Search
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    <?php endif; ?>
    </div>


 <!--Login form content
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
    </div> -->

    <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "loginfailed") {
                echo "<p align=center><b>Username and Password do not match!</b></p>";
            }

            if ($_GET["error"] == "invaliduser") {
                echo "<p align=center><b>User does not exist!</b></p>";
            }
            
            if ($_GET["error"] == "sqlerror") {
                echo "<p align=\"center\">Something went wrong, try again!</p>";
            }
        }

        if (isset($_GET["booking"])) {
            if ($_GET["booking"] == "success") {
                echo "<h3 align=\"center\"><b>Booking Completed Succesfully!</b></h3>";
            }

            if ($_GET["booking"] == "fail1") {
                echo "<h3 align=\"center\"><b>Booking Failed.<br>The flight you were searching for is no longer available.<br>Please Try Again</b></h3>";
            }

            if ($_GET["booking"] == "fail2") {
                echo "<h3 align=\"center\"><b>Booking Failed.<br>The hotel you were searching for is no longer available.<br>Please Try Again</b></h3>";
            }

            if ($_GET["booking"] == "fail3") {
                echo "<h3 align=\"center\"><b>Booking Failed.<br>The tour package you were searching for is no longer available.<br>Please Try Again</b></h3>";
            }
        }
    ?>

<!--Login button action-->
<!--     <script>
    // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script> -->

</main>

<?php
    require "footer.php";
?>