<?php
    
require "../header.php";
require 'dbhandler_inc.php';
require 'functions_inc.php';

if (isset($_POST['bookFlight-submit'])) {
    
    //Fetch search_form data
    $flt1 = $_POST['flt1'];
    $flt2 = $_POST['flt2'];
    $trip = $_POST['trip'];
    $dept = $_POST['dept'];
    $retn = $_POST['retn'];
    $pax = $_POST['pax'];
    $url = $_POST['url'];

    if (inputMatch($trip, "single") && empty($flt1)) {
        header("Location: $url&bookerror=ef1");
        exit();
    }

    if (inputMatch($trip, "round") && (empty($flt1) || empty($flt2))) {
        header("Location: $url&bookerror=ef2");
        exit();
    }

    if (!isset($_SESSION['username'])) {
        header("Location: $url&bookerror=login");
        exit();
    }

    header("Location:../confirmFlightBooking.php?error=none&flt1=".$flt1."&flt2=".$flt2."&dept=".$dept."&retn=".$retn."&trip=".$trip."&pax=".$pax);

    // fetchResults($conn, $trip, $orig, $dest, $dept, $retn);
    mysqli_close($conn);                                                    //close connection
}

else if (isset($_POST['bookHotel-submit'])) {

    //Fetch search_form data
    $hotel = $_POST['hotel'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $room = $_POST['room'];
    $pax = $_POST['pax'];
    $url = $_POST['url'];

    if (empty($hotel)) {
        header("Location: $url&bookerror=ef1");
        exit();
    }

    if (!isset($_SESSION['username'])) {
        header("Location: $url&bookerror=login");
        exit();
    }

    header("Location:../confirmHotelBooking.php?error=none&hotel=".$hotel."&checkin=".$checkin."&checkout=".$checkout."&room=".$room."&pax=".$pax);

    // fetchResults($conn, $trip, $orig, $dest, $dept, $retn);
    mysqli_close($conn);                                                    //close connection
}

else if (isset($_POST['bookTour-submit'])) {

    //Fetch search_form data
    $flt1 = $_POST['flt1'];
    $flt2 = $_POST['flt2'];
    $hotel = $_POST['hotel'];
    $sdate = $_POST['startdate'];
    $edate = $_POST['enddate'];
    $room = $_POST['room'];
    $pax = $_POST['pax'];
    $url = $_POST['url'];

    if (empty($hotel)) {
        header("Location: $url&bookerror=ef1");
        exit();
    }

    if (!isset($_SESSION['username'])) {
        header("Location: $url&bookerror=login");
        exit();
    }

    header("Location:../confirmTourBooking.php?error=none&flt1=".$flt1."&flt2=".$flt2."&hotel=".$hotel."&startdate=".$sdate."&enddate=".$edate."&room=".$room."&pax=".$pax);

    // fetchResults($conn, $trip, $orig, $dest, $dept, $retn);
    mysqli_close($conn);                                                    //close connection
}

else {                                                                      //redirect
    header("Location:../index.php");
    exit();
}
