
<head>
    <title>Past Bookings</title>
</head>

<?php
    require "header.php";
    require "inc/functions_inc.php";
    require "inc/dbhandler_inc.php";


    $uname = $_SESSION['username'];
    $today = date("Y-m-d");

    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];
?>

<div align="center">

    <form id="dateRange" action="pastBookings.php" method="post">
        <span>Fetch Bookings between</span>
        <input type="date" name="date1" value="<?php echo $date1; ?>">
        <input type="date" name="date2" value="<?php echo $date2; ?>">
        <button type="submit" name="submit-fetch">Fetch</button>
    </form>

</div>

<?php
    //Past Bookings

    $sql1 = "SELECT * FROM bookings WHERE uname=? AND start>? AND endd<?";                             //check for bookings
    $stmt = mysqli_stmt_init($conn);                                            //prepared statement
    if (!mysqli_stmt_prepare($stmt, $sql1)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $uname, $date1, $date2);
    mysqli_stmt_execute($stmt);
    $bookingData = mysqli_stmt_get_result($stmt);                               //save booking data
    $bookingCheck = mysqli_num_rows($bookingData);

    if ($bookingCheck > 0):

        echo "<h3 style=\"padding: 20px;\">".$bookingCheck." Past Bookings found</h3>";
        echo "<table id=\"table1\" align=\"center\" style=\"width: 80%\">";
        echo "<tr><th>Booking Ref#</th><th>Booking Details</th></tr>";

        while ($booking = mysqli_fetch_assoc($bookingData)):

            echo "<tr><td name=\"lt\">".$booking["bookingID"]."</td>";          //---table1 header booking ref#
            echo "<td name=\"rt\">";                                            //---booking details
                

            
            //retrieving fight bookings
            $sql2 = "SELECT DISTINCT bookingID, fltcd, doj FROM flightbookings WHERE bookingID=? ORDER BY doj";     //check for flightbookings
            $stmt = mysqli_stmt_init($conn);                                    //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql2)) {
                header("Location:../index.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "s", $booking["bookingID"]);
            mysqli_stmt_execute($stmt);
            $fltBookingData = mysqli_stmt_get_result($stmt);                     //save booked flight data
            $fltBookingCheck = mysqli_num_rows($fltBookingData);

            if ($fltBookingCheck > 0) :
                while ($fltBooking = mysqli_fetch_assoc($fltBookingData)) :

                    $sql3 = "SELECT * FROM flights WHERE fltcode=?";            //get flight information
                    $stmt = mysqli_stmt_init($conn);                            //prepared statement
                    if (!mysqli_stmt_prepare($stmt, $sql3)) {
                        header("Location:../index.php?error=sqlerror");
                        exit();
                    }

                    mysqli_stmt_bind_param($stmt, "s", $fltBooking["fltcd"]);
                    mysqli_stmt_execute($stmt);
                    $flightData = mysqli_stmt_get_result($stmt);                //save flight data
                    $flightCheck = mysqli_num_rows($flightData);
                    $fltInfo = mysqli_fetch_assoc($flightData);

                    $doj = date("l, j F, Y", strtotime($fltBooking['doj']));    //date of journey
                    $tod = date("G:i", strtotime($fltInfo['deptime']));         //departure time
                    $toa = date("G:i", strtotime($fltInfo['arrtime']));         //arrival time


                    // flight details 
                    echo "<p><b>".$fltInfo["airline"]." ".$fltInfo["fltcode"]."</b></p>";      //---table2 header flight#
                    echo "<p>".$doj."</p>";
                    echo "<p>(".$fltInfo["origcode"].") ".$fltInfo["origcity"]." ------> (".$fltInfo["destcode"].") ".$fltInfo["destcity"]."</p>";
                    echo "<p> ".$tod."hrs ------- ".$toa."hrs </p>";


                    $sql4 = "SELECT * FROM flightbookings WHERE fltcd=? AND bookingID=? ORDER BY doj";       //get passeneger information
                    $stmt = mysqli_stmt_init($conn);                            //prepared statement
                    if (!mysqli_stmt_prepare($stmt, $sql4)) {
                        header("Location:../index.php?error=sqlerror");
                        exit();
                    }

                    mysqli_stmt_bind_param($stmt, "ss", $fltBooking["fltcd"], $fltBooking["bookingID"]);
                    mysqli_stmt_execute($stmt);
                    $passData = mysqli_stmt_get_result($stmt);                  //save passenger data
                    $passCheck = mysqli_num_rows($passData);

                    // passenger details
                    echo "<p><table align=\"center\" style=\"width: 50%\">";           //---table3 passengers 
                    echo "<tr> <th>Name</th> <th>Gender</th> <th>Age</th> </tr>";

                    if ($passCheck > 0):
                        $count = 1;
                        while ($bookedPass = mysqli_fetch_assoc($passData)):

                            $age = (date("md", strtotime($bookedPass['dob'])) > date("md")                        //calculate age
                                    ? ((date("Y") - date("Y", strtotime($bookedPass['dob']))) - 1)
                                    : (date("Y") - date("Y", strtotime($bookedPass['dob']))));

                            echo "<tr><td name=\"lt\">".$count.". ".$bookedPass['fname']." ".$bookedPass['lname']." </td>";     //echo passinfo
                            echo "<td> ".$bookedPass['gender']." </td>";
                            echo "<td name=\"rt\"> ".$age." </td></tr>";
                            
                            $count++;
                        endwhile;
                    endif;

                    echo "</table></p>";

                endwhile;
            endif;

            

            //retrieving hotel bookings
            $sql5 = "SELECT DISTINCT bookingID, hname, room, checkin, checkout FROM hotelbookings WHERE bookingID=? ORDER BY checkin";     //check for hotelbookings
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql5)) {
                header("Location:../index.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "s", $booking["bookingID"]);
            mysqli_stmt_execute($stmt);
            $htlBookingData = mysqli_stmt_get_result($stmt);                  //save booked hotel data
            $htlBookingCheck = mysqli_num_rows($htlBookingData);
            $htlBooking = mysqli_fetch_assoc($htlBookingData);

            if ($htlBookingCheck > 0) :

                $sql6 = "SELECT * FROM hotels WHERE name=?";     //check for hotelbookings
                $stmt = mysqli_stmt_init($conn);                            //prepared statement
                if (!mysqli_stmt_prepare($stmt, $sql6)) {
                    header("Location:../index.php?error=sqlerror");
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "s", $htlBooking["hname"]);
                mysqli_stmt_execute($stmt);
                $hotelData = mysqli_stmt_get_result($stmt);                  //save hotel info
                $hotelCheck = mysqli_num_rows($hotelData);
                $hotelInfo = mysqli_fetch_assoc($hotelData);

                $sql7 = "SELECT * FROM hotelbookings WHERE bookingID=? ORDER BY checkin";     //check for hotelbookings
                $stmt = mysqli_stmt_init($conn);                            //prepared statement
                if (!mysqli_stmt_prepare($stmt, $sql7)) {
                    header("Location:../index.php?error=sqlerror");
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "s", $booking["bookingID"]);
                mysqli_stmt_execute($stmt);
                $guestData = mysqli_stmt_get_result($stmt);                  //save booked hotel data
                $guestCheck = mysqli_num_rows($guestData);


                $chki = date("l, j F, Y", strtotime($htlBooking["checkin"]));
                $chko = date("l, j F, Y", strtotime($htlBooking["checkout"]));
                $nights = dateDifference($htlBooking["checkin"], $htlBooking["checkout"]);
                $pax = $guestCheck;
                $nrooms = ($pax%2 == 0) ? $pax/2 : ($pax+1)/2;

                // hotel details 
                echo "<p><b>".$hotelInfo["name"].", ".$hotelInfo["cityname"]."</b></p>";      //---table2 header hotel#
                echo "<p> Check-in: ".$chki." 12PM </p><p> Check-out: ".$chko." 10AM </p>";
                echo "<p> Room type: ".$htlBooking["room"]."</p>";
                echo "<p> ".$nrooms." room(s) &emsp; ".$nights." night(s) </p>";


                // guest details
                echo "<p><table align=\"center\" style=\"width: 50%\">";           //---table3 passengers 
                echo "<tr> <th>Name</th> <th>Gender</th> <th>Age</th> </tr>";

                $count = 1;
                while ($guestInfo = mysqli_fetch_assoc($guestData)) :
                    $age = (date("md", strtotime($guestInfo['dob'])) > date("md")                        //calculate age
                                    ? ((date("Y") - date("Y", strtotime($guestInfo['dob']))) - 1)
                                    : (date("Y") - date("Y", strtotime($guestInfo['dob']))));

                    echo "<tr><td name=\"lt\">".$count.". ".$guestInfo['fname']." ".$guestInfo['lname']." </td>";     //echo passinfo
                    echo "<td> ".$guestInfo['gender']." </td>";
                    echo "<td name=\"rt\"> ".$age." </td></tr>";
                    
                    $count++;
                endwhile;

                echo "</table></p>";

            endif;


            echo "</td></tr>";
        
        endwhile;

        else :
            echo "<h3 style=\"padding: 20px;\">No Past Bookings found</h3>";
            echo "<p align=\"center\"><img src=\"img/bwTrip2.jpg\" width=\"768px\" height=\"447px\"></p>";
            echo "<br><h4 align=\"center\">Looks empty here...</h4>";
            echo "<br><p align=\"center\"><button name=\"goBack\" onclick=\"goBack()\">
            <i class=\"fas fa-arrow-left\"></i>  Back        </button>";

    endif;

    echo "</table>";

?>

<div align="center">

    <button name="goBack" onclick="goBack()">
        <i class="fas fa-arrow-left"></i>  Back        
    </button>

</div>

<script type="text/javascript">
        
        $("#table1 tr").click(function(){
            $(this).addClass('selected').siblings().removeClass('selected');    
            var value=$(this).find('td:first').html();
            $("#bookid").val(value);
        });

        function goBack() {
            window.history.back();
        }

</script>