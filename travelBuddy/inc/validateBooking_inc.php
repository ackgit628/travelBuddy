<?php
    
require "../header.php";
require 'dbhandler_inc.php';
require 'functions_inc.php';

// validate passenger information

if (isset($_POST['validateFlight-submit'])) {

    //Fetch search_form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $addr = $_POST['addr'];
    $flt1 = $_POST['flt1'];
    $flt2 = $_POST['flt2'];
    $dept = $_POST['dept'];
    $retn = $_POST['retn'];
    $pax = $_POST['pax'];
    $totv = $_POST['totv'];
    $url = $_POST['url'];
    $uname = $_SESSION['username'];
    $emptyCount = 0;

    for ($i=0; $i < count($fname); $i++) { 
            
        if (emptyInputSearch($fname[$i], $lname[$i], $dob[$i])) {
            $emptyCount++;
        }
    }

    if ($emptyCount > 0) {
        header("Location: $url&bookerror=emptyfields");
        exit();
    }

    $today = date("YmdGis");
    $bookid = "ETKT00".$today;

    // header("Location: $url&hello");

    createFlightBooking($conn, $fname, $lname, $gender, $dob, $flt1, $flt2, $dept, $retn, $pax, $uname, $bookid, $totv);
    mysqli_close($conn);                                                    //close connection
}

elseif (isset($_POST['validateHotel-submit'])) {

    //Fetch search_form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $addr = $_POST['addr'];
    $hname = $_POST['hotel'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $room = $_POST['room'];
    $pax = $_POST['pax'];
    $totv = $_POST['totv'];
    $url = $_POST['url'];
    $uname = $_SESSION['username'];
    $emptyCount = 0;

    for ($i=0; $i < count($fname); $i++) { 
            
        if (emptyInputSearch($fname[$i], $lname[$i], $dob[$i])) {
            $emptyCount++;
        }
    }

    if ($emptyCount > 0) {
        header("Location: $url&bookerror=emptyfields");
        exit();
    }

    $today = date("YmdGis");
    $bookid = "BKNG00".$today;

    // header("Location: $url&hello=".$checkin);

    createHotelBooking($conn, $fname, $lname, $gender, $dob, $hname, $checkin, $checkout, $room, $pax, $uname, $bookid, $totv);
    mysqli_close($conn);                                                    //close connection
}

elseif (isset($_POST['validateTour-submit'])) {

    //Fetch search_form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $addr = $_POST['addr'];
    $flt1 = $_POST['flt1'];
    $flt2 = $_POST['flt2'];    
    $hotel = $_POST['hotel'];
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
    $room = $_POST['room'];
    $pax = $_POST['pax'];
    $totv = $_POST['totv'];
    $url = $_POST['url'];
    $uname = $_SESSION['username'];
    $emptyCount = 0;

    for ($i=0; $i < count($fname); $i++) { 
            
        if (emptyInputSearch($fname[$i], $lname[$i], $dob[$i])) {
            $emptyCount++;
        }
    }

    if ($emptyCount > 0) {
        header("Location: $url&bookerror=emptyfields");
        exit();
    }

    $today = date("YmdGis");
    $bookid = "TPKG00".$today;

    // header("Location: $url&hello=".$checkin);

    createTourBooking($conn, $fname, $lname, $gender, $dob, $flt1, $flt2, $hotel, $sdate, $edate, $room, $pax, $uname, $bookid, $totv);
    mysqli_close($conn);                                                    //close connection
}

else {                                                                      //redirect
    header("Location:../index.php");
    exit();
}

    // header("Location:../searchHotels.php?error=none"); 