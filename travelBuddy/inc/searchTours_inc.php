<?php
    
require "../header.php";
require 'dbhandler_inc.php';
require 'functions_inc.php';

if (isset($_POST['searchTour-submit'])) {

    //Fetch search_form data
    $dcity = $_POST['destcity'];
    $ocity = $_POST['origcity'];
    $sdate = $_POST['startdate'];
    $edate = $_POST['enddate'];
    $room = $_POST['room'];
    $pax = $_POST['pax'];

    if (emptyInputSearch2($dcity, $ocity, $sdate, $edate) !== false) {
        header("Location:../searchTours.php?error=emptyfields&destcity=".$dcity."&origcity=".$ocity."&startdate=".$sdate."&enddate=".$edate."&room=".$room."&pax=".$pax);
        exit();
    }

    if (($cityd = lookupCity($conn, $dcity)) === false) {
        header("Location:../searchTours.php?error=invalidDestCity&origcity=".$ocity."&startdate=".$sdate."&enddate=".$edate."&room=".$room."&pax=".$pax);
        exit();
    }

    if (($cityo = lookupCity($conn, $ocity)) === false) {
        header("Location:../searchTours.php?error=invalidOrigCity&destcity=".$dcity."&startdate=".$sdate."&enddate=".$edate."&room=".$room."&pax=".$pax);
        exit();
    }

    header("Location:../selectFlight.php?error=none&destcity=".$cityd['cityname']."&origcity=".$cityo['cityname']."&startdate=".$sdate."&enddate=".$edate."&room=".$room."&pax=".$pax);

    // fetchResults($conn, $trip, $orig, $dest, $dept, $retn);
    mysqli_close($conn);                                                    //close connection
}

else if (isset($_POST['bookFlight-submit'])) {
    
    //Fetch search_form data
    $flt1 = $_POST['flt1'];
    $flt2 = $_POST['flt2'];
    $orig = $_POST['orig'];
    $dest = $_POST['dest'];
    $dept = $_POST['dept'];
    $retn = $_POST['retn'];
    $room = $_POST['room'];
    $pax = $_POST['pax'];
    $url = $_POST['url'];

    if ((empty($flt1) || empty($flt2))) {
        header("Location: $url&bookerror=ef2");
        exit();
    }

    if (!isset($_SESSION['username'])) {
        header("Location: $url&bookerror=login");
        exit();
    }

    header("Location:../selectHotel.php?error=none&destcity=".$dest."&origcity=".$orig."&startdate=".$dept."&enddate=".$retn."&room=".$room."&pax=".$pax."&flt1=".$flt1."&flt2=".$flt2);

    // fetchResults($conn, $trip, $orig, $dest, $dept, $retn);
    mysqli_close($conn);                                                    //close connection
}

else if (isset($_POST['bookHotel-submit'])) {

    //Fetch search_form data
    $hotel = $_POST['hotel'];
    $flt1 = $_POST['flt1'];
    $flt2 = $_POST['flt2'];
    $orig = $_POST['orig'];
    $dest = $_POST['dest'];
    $dept = $_POST['dept'];
    $retn = $_POST['retn'];
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

    header("Location:../enterDetails.php?error=none&destcity=".$dest."&origcity=".$orig."&startdate=".$dept."&enddate=".$retn."&room=".$room."&pax=".$pax."&flt1=".$flt1."&flt2=".$flt2."&hotel=".$hotel);

    // fetchResults($conn, $trip, $orig, $dest, $dept, $retn);
    mysqli_close($conn);                                                    //close connection
}

else {                                                                      //redirect
    header("Location:../index.php");
    exit();
}

    // header("Location:../searchHotels.php?error=none");