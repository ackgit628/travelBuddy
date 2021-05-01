<?php

require 'dbhandler_inc.php';
require 'functions_inc.php';

// delete passenger information
if (isset($_POST['submit-cancel'])) {

    //Fetch search_form data
    $bookid = $_POST['bookid'];
    $url = $_POST['url'];

    if (empty($bookid)) {
        header("Location: $url?error=empty");
    }

    deleteBooking($conn, $bookid, $url);    
    mysqli_close($conn);                                                    //close connection
}

if (isset($_POST['deleteEmp-submit'])) {

    //Fetch search_form data
    $empid = $_POST['emp_id'];
    $url = $_POST['url'];

    if (empty($empid)) {
        header("Location: $url?error=empty");
    }

    deleteEmployee($conn, $empid, $url);    
    mysqli_close($conn);                                                    //close connection
}

else {                                                                      //redirect
    header("Location:../index.php");
    exit();
}