<?php
    require "header.php";
    require 'inc/dbhandler_inc.php';
    require 'inc/functions_inc.php';
    $today = date("Y-m-d");

    $date1 = $today;
    $date2 = date("Y-m-d", strtotime("+5 days"));
?>

<head>
    <title>Welcome back!</title>
    <style type="text/css">
    	* {box-sizing: border-box}

    	.center {
    		width: 30%;
    		margin: auto;
    		padding: 100px 30px;
    		/*border: 1px solid #f1f1f1;*/
    	}

    	/* Style the tab */
		.tab {
		  overflow: hidden;
		  width: 80%;
		  margin: auto;
		  border: 1px solid #ccc;
		  background-color: #f1f1f1;
		}

		/* Style the buttons that are used to open the tab content */
		.tab button {
		  width: 33.33%;
		  font-weight: bold;
		  color: black;
		  background-color: inherit;
		  float: left;
		  border: none;
		  outline: none;
		  cursor: pointer;
		  margin: auto;
		  padding: 14px 16px;
		  transition: 0.3s;
		}

		/* Change background color of buttons on hover */
		.tab button:hover {
		  background-color: #ddd;
		}

		/* Create an active/current tablink class */
		.tab button.active {
		  background-color: #ccc;
		}

		/* Style the tab content */
		.tabcontent {
		  display: none;
		  width: 80%;
		  margin: auto;
		  padding: 16px 12px;
		  border: 1px solid #ccc;
		  border-top: none;
		}

		.tabcontent {
		  animation: fadeEffect 1s; /* Fading effect takes 1 second */
		}

		/* Go from zero to full opacity */
		@keyframes fadeEffect {
		  from {opacity: 0;}
		  to {opacity: 1;}
		}

		.form-content {
			width: 50%;
			margin: auto;
		}
		.table-content {
			width: 60%;
			margin: auto;
		}
		.selector {
			padding: 14px 22.8px;
		}
    </style>
</head>

<main>

	<?php
		if (isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "admin"):
	?>
		<!-- Tab links -->
		<div class="tab">
		  <button class="tablinks" onclick="openTab(event, 'add')" id="defaultOpen">Add Employee</button>
		  <button class="tablinks" onclick="openTab(event, 'block')">Block Employee</button>
		  <button class="tablinks" onclick="openTab(event, 'delete')">Delete Employee</button>
		</div>

		<!-- Tab content -->
		<div id="add" class="tabcontent">
		  <h3>Add an Employee</h3>
		  <div class="form-content">
		  	<form action="inc/signup_inc.php" method="post">
		  		<label>
		  			Name: &emsp;&emsp;&emsp;&emsp;	
		  			<input type="text" name="fname" autocomplete="off" placeholder="First Name.." value="<?php if(isset($_GET["fname"])) echo $_GET["fname"]?>">
		  			<input type="text" name="lname" autocomplete="off" placeholder="Last Name.." value="<?php if(isset($_GET["lname"])) echo $_GET["lname"]?>">
		  		</label>
		  		<br>	
		  		<label>
		  			Employee ID: &emsp;	
		  			<input type="text" name="empid" autocomplete="off" placeholder="Employee ID.." value="<?php if(isset($_GET["empid"])) echo $_GET["empid"]?>">
		  			<select name="utype" class="selector">
		  				<option selected disabled hidden>Select Employee Type</option>
		  				<option>admin</option>
		  				<option>employee</option>
		  			</select>
		  		</label>
		  		<br>
		  		<label>
		  			Contact Details : 
		  			<input type="text" name="email" autocomplete="off" placeholder="Email ID.." value="<?php if(isset($_GET["email"])) echo $_GET["email"]?>">
		  			<input type="text" name="phone" autocomplete="off" placeholder="Contact Number.." value="<?php if(isset($_GET["phone"])) echo $_GET["phone"]?>">
		  		</label>
		  		<br>
		  		<label>
		  			Password: &emsp;&emsp;&nbsp;
		  			<input type="password" name="pass1" autocomplete="off" placeholder="Enter Password..">
		  			<input type="password" name="pass2" autocomplete="off" placeholder="Re-enter Password..">
		  		</label>
		  		<br>
		  		<p align="center">
		  			<button type="submit" name="addEmp-submit">Submit</button>
		  		</p>
		  	</form>
            <?php
                
                if (isset($_GET["error"])) {
                    
                    if ($_GET["error"] == "emptyfields") {
                        echo "<p align=\"center\">Fill in all fields!</p>";
                    }

                    if ($_GET["error"] == "invalidemail") {
                        echo "<p align=\"center\">Enter valid Email-id!</p>";
                    }

                    if ($_GET["error"] == "invalidusername") {
                        echo "<p align=\"center\">Enter valid Employee ID!</p>";
                    }

                    if ($_GET["error"] == "incorrectpassword") {
                        echo "<p align=\"center\">Passwords do not match!</p>";
                    }

                    if ($_GET["error"] == "userexists") {
                        echo "<p align=\"center\">Employee ID already exists!</p>";
                    }

                    if ($_GET["error"] == "none") {
                        echo "<h4 align=\"center\"><b>Employee added Successfully!</b></h4>";
                    }
                }

            ?>
		  </div>
		</div>

		<div id="block" class="tabcontent">
		  <h3>Block an Employee</h3>
		</div>

		<div id="delete" class="tabcontent">
		  <h3>Delete an Employee</h3>
		  <div class="table-content">
		  	<?php
		  		$sql = "SELECT * FROM employees WHERE utype = 'employee'";
                $stmt = mysqli_stmt_init($conn);                            //prepared statement
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location:../empHome.php?error=sqlerror");
                    exit();
                }
                mysqli_stmt_execute($stmt);
                $resultData = mysqli_stmt_get_result($stmt);
                $resultCheck = mysqli_num_rows($resultData);

                echo "<p>".$resultCheck." Employees found in Database.</p>";
		  	?>
		  	<table id="table1">
		  		<tr>
		  			<th>Employee ID</th>
		  			<th>Employee Name</th>
		  			<th>Email</th>
		  			<th>Employee Type</th>
		  			<th></th>
		  		</tr>
		  		<?php		  		
	                if ($resultCheck > 0) {
			  			while ($result = mysqli_fetch_assoc($resultData)) {
	                        echo "<tr>";

	                        echo "<td name=\"lt\">".$result['empid']."</td>";
	                        echo "<td>".$result['fname']." ".$result['lname']."</td>";
	                        echo "<td>".$result['email']."</td>";
	                        echo "<td>".$result['utype']."</td>";
	                        echo "<td name=\"rt\" width=\"5%\"> <input type=\"radio\" name=\"selection1\"> </td>";

	                        echo "</tr>";
	                    }
	                }
		  		?>
		  	</table>
		  	<form action="inc/cancelBooking_inc.php" method="post">
		  		<input type="text" name="emp_id" id="emp_id" style="display: none;">
		        <input type="text" name="url" value="<?php echo $_SESSION["url"]?>" style="display: none">
		        <p align="center">
		        	<button type="submit" name="deleteEmp-submit" class="cancelbtn">Delete Employee</button>
		        </p>
		  	</form>
		  </div>
		</div>
	<?php
		endif;
	?>

	<div class="center">

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

<script type="text/javascript">
	function openTab(evt, tabName) {
	  // Declare all variables
	  var i, tabcontent, tablinks;

	  // Get all elements with class="tabcontent" and hide them
	  tabcontent = document.getElementsByClassName("tabcontent");
	  for (i = 0; i < tabcontent.length; i++) {
	    tabcontent[i].style.display = "none";
	  }

	  // Get all elements with class="tablinks" and remove the class "active"
	  tablinks = document.getElementsByClassName("tablinks");
	  for (i = 0; i < tablinks.length; i++) {
	    tablinks[i].className = tablinks[i].className.replace(" active", "");
	  }

	  // Show the current tab, and add an "active" class to the button that opened the tab
	  document.getElementById(tabName).style.display = "block";
	  evt.currentTarget.className += " active";
	}

	// Get the element with id="defaultOpen" and click on it
	document.getElementById("defaultOpen").click();

	$("#table1 tr").click(function(){
        $(this).addClass('selected').siblings().removeClass('selected');    
        var value = $(this).find('td:first').html();
        $("#emp_id").val(value);
        $("input[name=selection1]").checked;
    });

 //    function confirmAction() {
	//   var txt;
	//   var r = confirm("Are you sure you want to delete this Employee?\nThis action cannot be reversed.");
	//   if (r == true) {
	//     txt = "You pressed OK!";
	//   } else {
	//     txt = "You pressed Cancel!";
	//   }
	// }
</script>