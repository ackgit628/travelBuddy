<?php
    
require 'dbhandler_inc.php';
require 'functions_inc.php';

if (isset($_POST['login-submit'])) {

    $uname = $_POST['uid'];
    $pword = $_POST['pwd'];

    if (emptyInputLogin($uname, $pword) !== false) {
        header("Location:../index.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $uname, $pword);
}

if (isset($_POST['empLogin-submit'])) {

    $uname = $_POST['uid'];
    $pword = $_POST['pwd'];

    if (emptyInputLogin($uname, $pword) !== false) {
        header("Location:../empLogin.php?error=emptyinput");
        exit();
    }

    loginEmployee($conn, $uname, $pword);
}

else {                                                                              //redirect
    header("Location:../index.php");
    exit();
}