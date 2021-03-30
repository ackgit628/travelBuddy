<?php

if (isset($_POST['search-submit'])) {
    
    require 'dbhandler_inc.php';
    require 'functions_inc.php';

    //Fetch search_form data
    $trip = $_POST['trip'];
    $orig = $_POST['origin'];
    $dest = $_POST['destination'];
    $dept = $_POST['departure'];
    $retn = $_POST['return'];
    $pax = $_POST['pax'];

    if (emptyInputSearch($orig, $dest, $dept) !== false) {
        header("Location:../searchFlights.php?error=emptyfields&orig=".$orig."&dest=".$dest."&dept=".$dept."&retn=".$retn."&trip=".$trip."&pax=".$pax);
        exit();
    }

    if (inputMatch($trip, "round") && empty($retn)) {
        header("Location:../searchFlights.php?error=emptyreturn&orig=".$orig."&dest=".$dest."&dept=".$dept."&trip=".$trip."&pax=".$pax);
        exit();
    }

    if (($cityo = lookupCity($conn, $orig)) === false) {
        header("Location:../searchFlights.php?error=invalidOrigCity&dest=".$dest."&dept=".$dept."&retn=".$retn."&trip=".$trip."&pax=".$pax);
        exit();
    }

    if (($cityd = lookupCity($conn, $dest)) === false) {
        header("Location:../searchFlights.php?error=invalidDestCity&orig=".$orig."&dept=".$dept."&retn=".$retn."&trip=".$trip."&pax=".$pax);
        exit();
    }
    
    if (inputMatch($cityo["cityname"], $cityd["cityname"]) !== false) {
        header("Location:../searchFlights.php?error=invalidDestination&orig=".$orig."&dept=".$dept."&retn=".$retn."&trip=".$trip."&pax=".$pax);
        exit();
    }

    header("Location:../searchFlights.php?error=none&orig=".$cityo["cityname"]."&dest=".$cityd["cityname"]."&dept=".$dept."&retn=".$retn."&trip=".$trip."&pax=".$pax);

    // fetchResults($conn, $trip, $orig, $dest, $dept, $retn);
    mysqli_close($conn);                                                    //close connection
}

else {                                                                      //redirect
    header("Location:../index.php");
    exit();
}

    // header("Location:../searchFlights.php?error=none");