<?php

// delete passenger information

if (isset($_POST['submit-cancel'])) {
    
    // require "../header.php";
    require 'dbhandler_inc.php';
    require 'functions_inc.php';

    //Fetch search_form data
    $bookid = $_POST['bookid'];
    $url = $_POST['url'];

    if (empty($bookid)) {
        header("Location: $url?error=empty");
    }

    deleteBooking($conn, $bookid, $url);    
    mysqli_close($conn);                                                    //close connection
}

else {                                                                      //redirect
    header("Location:../index.php");
    exit();
}