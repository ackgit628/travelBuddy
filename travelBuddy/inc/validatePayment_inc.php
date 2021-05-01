<?php
    
require "../header.php";
require 'dbhandler_inc.php';
require 'functions_inc.php';

if (isset($_POST['payupi-submit'])) {
    
    //Fetch search_form data
    $vpa = $_POST['vpa'];
    $url = $_POST['url'];

    if (empty($vpa)) {
        header("Location: $url&error=empty");
        exit();
    }

    header("Location:../index.php?booking=success");

    // fetchResults($conn, $trip, $orig, $dest, $dept, $retn);
    mysqli_close($conn);                                                    //close connection
}

else if (isset($_POST['paycard-submit'])) {

    //Fetch search_form data
    $cardnumber = $_POST['cardnumber'];
    $cardname = $_POST['cardname'];
    $month = $_POST['xpmonth'];
    $year = $_POST['xpyear'];
    $cvv = $_POST['cvv'];
    $url = $_POST['url'];

    if (empty($cardnumber) || empty($cardname) || empty($month) || empty($year) || empty($cvv)) {
        header("Location: $url&error=empty");
        exit();
    }

    header("Location:../index.php?booking=success");

    // fetchResults($conn, $trip, $orig, $dest, $dept, $retn);
    mysqli_close($conn);                                                    //close connection
}

else if (isset($_POST['paynetb-submit'])) {

    //Fetch search_form data
    $bank = $_POST['bank'];
    $url = $_POST['url'];

    if (empty($bank)) {
        header("Location: $url&error=empty");
        exit();
    }

    header("Location:../index.php?booking=success");

    // fetchResults($conn, $trip, $orig, $dest, $dept, $retn);
    mysqli_close($conn);                                                    //close connection
}

else {                                                                      //redirect
    header("Location:../index.php");
    exit();
}
