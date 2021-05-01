<?php
    
require "../header.php";
require 'dbhandler_inc.php';
require 'functions_inc.php';

if (isset($_POST['reviewBooking-submit'])) {

    //Fetch search_form data
    $flt1 = $_POST['flt1'];
    $flt2 = $_POST['flt2'];
    $hotel = $_POST['hotel'];
    $sdate = $_POST['sdate'];
    $edate = $_POST['edate'];
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

    header("Location:../reviewBooking.php?error=none&flt1=".$flt1."&flt2=".$flt2."&hotel=".$hotel."&sdate=".$sdate."&edate=".$edate."&room=".$room."&pax=".$pax);

    // fetchResults($conn, $trip, $orig, $dest, $dept, $retn);
    mysqli_close($conn);                                                    //close connection
}

else {                                                                      //redirect
    header("Location:../index.php");
    exit();
}
