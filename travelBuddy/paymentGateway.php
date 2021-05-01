
<head>
	<title>Payment Gateway</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		* {box-sizing: border-box}
		body {
			font-family: "Lato", sans-serif;
			padding: 20px;
		}
		table[name=banktable] {
			width: 70%;
		}

		/*Style the table*/
		.row:after {
			display: table;
			width: 1000px;
			margin: 0 auto;
		}

		/*Left Column*/
		.leftcolumn {
			margin-left: 50px;
			width: 70%;
		}

		/*Right Column*/
		.rightcolumn {
			float: right;
			margin-right: 50px;
			width: 20%;
		}

		/* Style the tab */
		.tab {
		  float: left;
		  border: 1px solid #ccc;
		  background-color: #f1f1f1;
		  width: 30%;
		  height: 600px;
		}

		/* Style the buttons inside the tab */
		.tab button {
		  display: block;
		  background-color: inherit;
		  color: black;
		  padding: 22px 20px;
		  width: 100%;
		  border: none;
		  outline: none;
		  text-align: left;
		  cursor: pointer;
		  transition: 0.3s;
		  font-size: 17px;
		}

		/* Change background color of buttons on hover */
		.tab button:hover {
		  background-color: #ddd;
		}

		/* Create an active/current "tab button" class */
		.tab button.active {
		  background-color: #ccc;
		}

		/* Style the tab content */
		.tabcontent {
		  float: left;
		  padding: 0px 12px;
		  border: 1px solid #ccc;
		  width: 70%;
		  border-left: none;
		  height: 600px;
		}

		/*Style the fare summary*/
		.summary {
			background-color: #f1f1f1;
			padding: 20px;
			margin-top: 20px; 
		}

		.paynow {
			border-radius: 50px;
		}

        a, a:focus, a:hover{
            background-color: transparent;
            color: #0055b7;
            text-decoration: none;
        }
        .lnk{
            color: #0055b7;
        }

        .selector {
        	width: auto;
        	border: 1px solid #ccc;
        	padding: 12px 20px;
        }

        .netbank {
        	text-align: left;
        	border: 1px solid #ccc;
        	padding: 12px 20px;
        }
	</style>
</head>

<?php  
	require "header.php";

	$bookid = $_GET["bookid"];
	$totv = $_GET["totv"];

	if (isset($_GET["error"]) && $_GET["error"] == "empty"){
		echo '<script>alert("Please fill out all fields correctly.")</script>';
	}
?>

<h2>Payment Gateway</h2>
<!-- <p>Click on the buttons inside the tabbed menu:</p> -->

<div class="row">

	<div class="leftcolumn">
		
		<div class="tab">
			<h4 style="padding-left: 16px;"><b>Payment Options</b></h4>
			<button class="tablinks" onclick="selectOption(event, 'UPI')"> <img src="img/bhim-upi-icon.svg" height="22px" width="22px"> UPI</button>
			<button class="tablinks" onclick="selectOption(event, 'Card')" id="defaultOpen"> <i class="far fa-credit-card"></i> Credit/Debit/ATM Card </button>
			<button class="tablinks" onclick="selectOption(event, 'NetBanking')"> <i class="fas fa-landmark"></i> NetBanking </button>
		</div>

		<div id="UPI" class="tabcontent">
			
			<form id="payupi" action="inc/validatePayment_inc.php" method="post">
				<br> <br>
				&emsp;&emsp;&emsp;&emsp; 
				<label for="vpa"><b>Enter UPI id</b></label> <br>
				&emsp;&emsp;&emsp;&emsp; 
				<input type="text" name="vpa" placeholder="xxxxxxxx@upi" style="width: 70%;"> <br> <br>
            	<input type="text" name="url" value="<?php echo $_SESSION["url"]; ?>" style="display: none;">

				&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;
				<button type="submit" name="payupi-submit" class="paynow">Verify & Pay</button>
			</form>

			<div align="center">
				<img src="img/google-pay-icon.svg" height="70px" width="70px">
				<img src="img/PhonePe_Logo.svg" height="100px" width="100px">
				<img src="img/bhim-upi-icon.svg" height="30px" width="30px">
				<img src="img/SBI-Logo.svg" height="30px" width="30px">
				<!-- <img src="img/HDFC_Bank_Logo.svg" height="30px" width="120px"> -->
				<img src="img/paytm-logo.svg" height="100px" width="100px">
			</div>

			<p>By continuing to pay, I understand and agree with the <a href="privacy_policy.php" target="_blank" class="lnk">privacy policy</a>, the <a href="user_agreement.php" target="_blank" class="lnk">user agreement</a> and <a href="privacy_policy.php" target="_blank" class="lnk">terms of service</a> of travelBuddy</p>

		</div>

		<div id="Card" class="tabcontent">
			<form id="paycard" action="inc/validatePayment_inc.php" method="post">
				<br> <br>
				&emsp;&emsp;&emsp;&emsp; 
				<label for="cardnumber"><b>Card Number</b></label> <br>
				&emsp;&emsp;&emsp;&emsp; 
				<input type="text" name="cardnumber" placeholder="Enter your Card Number" style="width: 70%;"> <br> <br>

				&emsp;&emsp;&emsp;&emsp; 
				<label for="cardname"><b>Name on Card</b></label> <br>
				&emsp;&emsp;&emsp;&emsp; 
				<input type="text" name="cardname" placeholder="Enter your Name on Card" style="width: 70%;"> <br> <br>

				&emsp;&emsp;&emsp;&emsp; 
				<label for="expiry"><b>Expiry Month & Year</b></label> &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;
				<label for="cvv"><b>Card CVV</b></label> <br>

				&emsp;&emsp;&emsp;&emsp; 
				<select name="xpmonth" class="selector">
					<option value=null selected disabled hidden>Month</option>
					<?php
						for ($i=1; $i < 13; $i++) { 
							echo "<option value=\"$i\">$i</option>";
						}
					?>
				</select>
				<select name="xpyear" class="selector">
					<option value=null selected disabled hidden>Year</option>
					<?php
						$today = date("Y");
						for ($i=0; $i < 25; $i++) { 
							$today = date("Y", strtotime("+$i year", strtotime($today)));
							echo "<option value=\"$today\">$today</option>";
						}
					?>
				</select>

				&emsp;&emsp;&emsp;&nbsp;
				<input type="password" name="cvv" placeholder="Enter your CVV"> <br> <br>
            	<input type="text" name="url" value="<?php echo $_SESSION["url"]; ?>" style="display: none;">

				&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;
				<button type="submit" name="paycard-submit" class="paynow">Pay Now</button>
			</form>

			<p>By continuing to pay, I understand and agree with the <a href="privacy_policy.php" target="_blank" class="lnk">privacy policy</a>, the <a href="user_agreement.php" target="_blank" class="lnk">user agreement</a> and <a href="privacy_policy.php" target="_blank" class="lnk">terms of service</a> of travelBuddy</p>

		</div>

		<div id="NetBanking" class="tabcontent">
			
			<form id="paynetb" action="inc/validatePayment_inc.php" method="post">
				<br> <br>
				&emsp;&emsp;&emsp;&emsp; 
				<label><b>Select your Bank</b></label> <br>

				<div align="center">
					<table name="banktable">
						<tr>
							<td class="netbank">
								<input type="radio" name="bank" value="sbi">
								<img src="img/SBI-Logo.svg" height="30px" width="30px"> State Bank of India 
							</td>
						</tr>
						<tr>
							<td class="netbank">
								<input type="radio" name="bank" value="icici">
								<img src="img/icici-icon.jpg" height="30px" width="30px"> ICICI Bank 
							</td>
						</tr>
						<tr>
							<td class="netbank">
								<input type="radio" name="bank" value="hdfc">
								<img src="img/hdfc-icon.jpg" height="30px" width="30px"> HDFC Bank 
							</td>
						</tr>
						<tr>
							<td class="netbank">
								<input type="radio" name="bank" value="axis">
								<img src="img/axis-icon.png" height="30px" width="30px"> Axis Bank 
							</td>
						</tr>
						<tr>
							<td class="netbank">
								<input type="radio" name="bank" value="kotak">
								<img src="img/kotak-icon.png" height="30px" width="30px"> Kotak Mahindra 
							</td>
						</tr>
					</table>
				</div>	
            	<input type="text" name="url" value="<?php echo $_SESSION["url"]; ?>" style="display: none;">

				&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;
				<button type="submit" name="paynetb-submit" class="paynow">Pay</button>
			</form>

			<p>By continuing to pay, I understand and agree with the <a href="privacy_policy.php" target="_blank" class="lnk">privacy policy</a>, the <a href="user_agreement.php" target="_blank" class="lnk">user agreement</a> and <a href="privacy_policy.php" target="_blank" class="lnk">terms of service</a> of travelBuddy</p>

		</div>

	</div>

	<div class="rightcolumn">
		
		<div class="summary">
			<h4><b>Fare Summary</b></h4>
			Base Fare: <span style="float: right; font-weight: bold;">₹<?php echo $totv; ?></span>
			<hr>
			Convenience Fee: <span style="float: right; font-weight: bold;">₹100</span>
			<hr style="display: block; border: 1px solid #ddd;">
			<p><b>Grand Total:</b> <span style="float: right; font-weight: bold;">₹<?php echo $totv+100; ?></span> </p>
		</div>

	</div>
  
</div>



<script>
	function selectOption(evt, optn) {
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		document.getElementById(optn).style.display = "block";
		evt.currentTarget.className += " active";
	}

	// Get the element with id="defaultOpen" and click on it
	document.getElementById("defaultOpen").click();
</script>
   
</body>