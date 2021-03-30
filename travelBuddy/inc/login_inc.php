<?php

if (isset($_POST['login-submit'])) {
    
    require 'dbhandler_inc.php';
    require 'functions_inc.php';

    $uname = $_POST['uid'];
    $pword = $_POST['pwd'];

    if (emptyInputLogin($uname, $pword) !== false) {
        header("Location:../index.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $uname, $pword);
}

else {                                                                              //redirect
    header("Location:../index.php");
    exit();
}