<?php

if (isset($_POST['search-submit'])) {
    
    require 'dbhandler_inc.php';
    require 'functions_inc.php';

    //Fetch search_form data
    $city = $_POST['city'];
    $chki = $_POST['checkin'];
    $chko = $_POST['checkout'];
    $pax = $_POST['pax'];
    $room = $_POST['room'];

    if (emptyInputSearch($city, $chki, $chko) !== false) {
        header("Location:../searchHotels.php?error=emptyfields&city=".$city."&checkin=".$chki."&checkout=".$chko."&room=".$room."&pax=".$pax);
        exit();
    }

    if (($cityo = lookupCity($conn, $city)) === false) {
        header("Location:../searchHotels.php?error=invalidCity&checkin=".$chki."&checkout=".$chko."&room=".$room."&pax=".$pax);
        exit();
    }

    header("Location:../searchHotels.php?error=none&city=".$cityo['cityname']."&checkin=".$chki."&checkout=".$chko."&room=".$room."&pax=".$pax);

    // fetchResults($conn, $trip, $orig, $dest, $dept, $retn);
    mysqli_close($conn);                                                    //close connection
}

else {                                                                      //redirect
    header("Location:../index.php");
    exit();
}

    // header("Location:../searchHotels.php?error=none");