<?php
    require "header.php";
?>

<head>
    <title>Login for Employees</title>
    <style type="text/css">
    	* {box-sizing: border-box}

    	.login {
    		width: 30%;
    		margin: auto;
    		padding: 100px 30px;
    		/*border: 1aapx solid #f1f1f1;*/
    	}
    </style>
</head>

<main>
	<div class="login">
		<form action="inc/login_inc.php" method="post">
			<h5><b>Enter your credentials</b></h5>
			<input type="text" name="uid" placeholder="Employee ID.." autocomplete="off">
			<input type="password" name="pwd" placeholder="Password..">
			<button type="submit" name="empLogin-submit">Login</button>
            <label class="psw">
                <input type="checkbox" checked="checked" name="remember"> Remember me
            </label>
		</form>

		<?php
	        if (isset($_GET["error"])) {
	            if ($_GET["error"] == "loginfailed") {
	                echo "<p align=center><b>Employee ID and Password do not match!</b></p>";
	            }

	            if ($_GET["error"] == "invaliduser") {
	                echo "<p align=center><b>Employee ID does not exist!</b></p>";
	            }
	            
	            if ($_GET["error"] == "sqlerror") {
	                echo "<p align=\"center\">Something went wrong, try again!</p>";
	            }
	        }

	        if (isset($_GET["booking"])) {
	            if ($_GET["booking"] == "success") {
	                echo "<h3 align=\"center\"><b>Booking Completed Succesfully!</b></h3>";
	            }

	            if ($_GET["booking"] == "failed") {
	                echo "<h3 align=\"center\"><b>Booking Failed. Please Try Again</b></h3>";
	            }
	        }
	    ?>

	</div>
</main>