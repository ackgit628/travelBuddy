<?php
    
require 'dbhandler_inc.php';
require 'functions_inc.php';

if (isset($_POST['signup-submit'])) {

    //Fetch signup_form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    if (emptyInputSignup($fname, $lname, $uname, $email, $pass1, $pass2) !== false) {
        header("Location:../index.php?error=emptyfields&fname=".$fname."&lname=".$lname."&uname=".$uname."&email=".$email."&phone=".$phone);
        exit();
    }

    if (invalidUsername($uname) !== false) {
        header("Location:../index.php?error=invalidusername&fname=".$fname."&lname=".$lname."&email=".$email."&phone=".$phone);
        exit();
    }

    if (invalidEmail($email) !== false) {
        header("Location:../index.php?error=invalidemail&fname=".$fname."&lname=".$lname."&uname=".$uname."&phone=".$phone);
        exit();
    }

    if (invalidPassword($pass1, $pass2) !== false) {
        header("Location:../index.php?error=incorrectpassword&fname=".$fname."&lname=".$lname."&uname=".$uname."&email=".$email."&phone=".$phone);
        exit();
    }

    if (userExists($conn, $uname, $email) !== false) {
        header("Location:../index.php?error=userexists&fname=".$fname."&lname=".$lname."&phone=".$phone);
        exit();
    }

    // $utype = "admin";

    createUser($conn, $fname, $lname, $uname, $email, $pass1, $phone);
    mysqli_close($conn);                                                    //close connection
}

if (isset($_POST['addEmp-submit'])) {

    //Fetch signup_form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $empid = $_POST['empid'];
    $utype = $_POST['utype'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    if (emptyInputSignup($fname, $lname, $empid, $email, $pass1, $utype) !== false) {
        header("Location:../empHome.php?error=emptyfields&fname=".$fname."&lname=".$lname."&empid=".$empid."&email=".$email."&phone=".$phone);
        exit();
    }

    if (invalidUsername($empid) !== false) {
        header("Location:../empHome.php?error=invalidempid&fname=".$fname."&lname=".$lname."&email=".$email."&phone=".$phone);
        exit();
    }

    if (invalidEmail($email) !== false) {
        header("Location:../empHome.php?error=invalidemail&fname=".$fname."&lname=".$lname."&empid=".$empid."&phone=".$phone);
        exit();
    }

    if (invalidPassword($pass1, $pass2) !== false) {
        header("Location:../empHome.php?error=incorrectpassword&fname=".$fname."&lname=".$lname."&empid=".$empid."&email=".$email."&phone=".$phone);
        exit();
    }

    if (employeeExists($conn, $empid, $email) !== false) {
        header("Location:../empHome.php?error=userexists&fname=".$fname."&lname=".$lname."&phone=".$phone);
        exit();
    }

    // $utype = "admin";

    createEmployee($conn, $fname, $lname, $empid, $email, $pass1, $phone, $utype);
    mysqli_close($conn);                                                    //close connection
}

else {                                                                      //redirect 
    header("Location:../index.php");
    exit();
}