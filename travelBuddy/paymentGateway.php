
<head>
    <title>Payment Gateway</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {box-sizing: border-box}
        body {
            font-family: "Lato", sans-serif;
            padding: 20px;
        }

        /*Style the table*/
        .row:after {
            display: table;
            width: 1000px;
            margin: 0 auto;
        }

        /*Left Column*/
        .leftcolumn {
            float: left;
            width: 70%;
        }

        /*Right Column*/
        .rightcolumn {
            float: left;
            width: 30%;
        }

        /* Style the tab */
        .tab {
          float: left;
          border: 1px solid #ccc;
          background-color: #f1f1f1;
          width: 30%;
          height: 300px;
        }

        /* Style the buttons inside the tab */
        .tab button {
          display: block;
          background-color: inherit;
          color: black;
          padding: 22px 16px;
          width: 100%;
          border: none;
          outline: none;
          text-align: center;
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
          height: 300px;
        }

        /*Style the fare summary*/
        .summary {
            background-color: #ddd;
            padding: 20px;
            margin-top: 20px; 
        }
    </style>
</head>

<?php  
    require "header.php";
?>

<h2>Payment Gateway</h2>
<p>Click on the buttons inside the tabbed menu:</p>

<div class="row">

    <div class="leftcolumn">
        
        <div class="tab">
            <h4 style="padding-left: 16px;"><b>Payment Options</b></h4>
            <button class="tablinks" onclick="selectOption(event, 'UPI')"> <img src="img/upi-icon.svg" height="22px" width="22px"> UPI</button>
            <button class="tablinks" onclick="selectOption(event, 'Card')" id="defaultOpen"> <i class="far fa-credit-card"></i> Credit/Debit/ATM Card </button>
            <button class="tablinks" onclick="selectOption(event, 'NetBanking')"> <i class="fas fa-landmark"></i> NetBanking </button>
        </div>

        <div id="UPI" class="tabcontent">
            <h3>UPI</h3>
            <p>UPI is the capital city of England.</p>
        </div>

        <div id="Card" class="tabcontent">
            <h3>Card</h3>
            <p>Card is the capital of France.</p> 
        </div>

        <div id="NetBanking" class="tabcontent">
            <h3>NetBanking</h3>
            <p>NetBanking is the capital of Japan.</p>
        </div>

    </div>

    <div class="rightcolumn">
        
        <div class="summary">
            <p>Fare Summary</p>
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