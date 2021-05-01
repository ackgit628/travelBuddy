<?php

// ***************functions for signup***************
function emptyInputSignup($fname, $lname, $uname, $email, $pass1, $pass2) {
    $result;
    if (empty($fname) || empty($lname) || empty($uname) || empty($email) || empty($pass1) || empty($pass2)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidUsername($uname) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $uname)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidPassword($pass1, $pass2) {
    $result;
    if ($pass1 !== $pass2) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function userExists($conn, $uname, $email) {
    $sql = "SELECT * FROM users WHERE uname=? OR email=?";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $uname, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $fname, $lname, $uname, $email, $pass1, $phone) {
    $sql = "INSERT INTO users (fname, lname, uname, email, pword, phone) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    $hashedpwd = password_hash($pass1, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssss", $fname, $lname, $uname, $email, $hashedpwd, $phone);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location:../index.php?error=none");
    exit();
}

// ***************functions for login****************
function emptyInputLogin($uname, $pword) {
    $result;
    if (empty($uname) || empty($pword)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $uname, $pword) {
    $user = userExists($conn, $uname, $uname);

    if ($user === false) {
        header("Location:../index.php?error=invaliduser");                  //user does not exist
        exit();
    }

    $pwdHashed = $user["pword"];
    $checkPwd = password_verify($pword, $pwdHashed);

    if ($checkPwd === false) {
        header("Location:../index.php?error=loginfailed");                  //password match failed
        exit();
    }
    else if ($checkPwd === true) {
        session_start();
        $_SESSION["username"] = $user["uname"];
        $_SESSION["email"] = $user["email"];
        if(isset($_SESSION['url'])) 
           $url = $_SESSION['url'];                                         // holds url for last page visited.
        else 
           $url = "index.php";                                              // default page for 

        header("Location: $url");
        exit();
    }
}

// ***************functions for tour operator****************
//check if employee exists in database
function employeeExists($conn, $uname, $email) {
    $sql = "SELECT * FROM employees WHERE empid=?";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../empLogin.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $uname);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

//employee login
function loginEmployee($conn, $uname, $pword) {
    $user = employeeExists($conn, $uname, $uname);

    if ($user === false) {
        header("Location:../empLogin.php?error=invaliduser");                  //user does not exist
        exit();
    }

    $pwdHashed = $user["pword"];
    $checkPwd = password_verify($pword, $pwdHashed);

    if ($checkPwd === false) {
        header("Location:../empLogin.php?error=loginfailed");                  //password match failed
        exit();
    }
    else if ($checkPwd === true) {
        session_start();
        $_SESSION["username"] = $user["empid"];
        $_SESSION["usertype"] = $user["utype"];
        $_SESSION["email"] = $user["email"];
        $url = "../empHome.php";                                              // default page for 

        header("Location: $url");
        exit();
    }
}

//create employee
function createEmployee($conn, $fname, $lname, $empid, $email, $pass1, $phone, $utype) {
    $sql = "INSERT INTO employees (fname, lname, empid, pword, email, phone, utype) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../empHome.php?error=sqlerror");
        exit();
    }

    $hashedpwd = password_hash($pass1, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssss", $fname, $lname, $empid, $hashedpwd, $email, $phone, $utype);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location:../empHome.php?error=none");
    exit();
}

//delete employee
function deleteEmployee($conn, $empid, $url) {

    $sql = "DELETE FROM employees WHERE empid=?";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement 
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../empHome.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $empid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: $url");
    exit();
}
// ***************functions for search***************
function emptyInputSearch($orig, $dest, $dept) {
    $result;
    if (empty($orig) || empty($dest) || empty($dept)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function emptyInputSearch2($orig, $dest, $dept, $retn) {
    $result;
    if (empty($orig) || empty($dest) || empty($dept) || empty($retn)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

// ***************functions for searchFlights***************
function inputMatch($orig, $dest) {
    $result;
    if ($orig === $dest) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function lookupCity($conn, $city) {
    $sql = "SELECT cityname FROM cities WHERE cityname=? OR akacity=? OR citycode=?";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../searchFlights.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $city, $city, $city);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function dayOfWeek($dow) {
    switch ($dow) {
        case 'Monday':
            return 1;
            break;

        case 'Tuesday':
            return 2;
            break;

        case 'Wednesday':
            return 4;
            break;

        case 'Thursday':
            return 8;
            break;

        case 'Friday':
            return 16;
            break;

        case 'Saturday':
            return 32;
            break;

        case 'Sunday':
            return 64;
            break;
        
        default:
            # code...
            break;
    }
}

function checkFlightSeats($conn, $flt, $dept, $pax) {

    //check if there exists an entry for queried flt no and date
    $sql = "SELECT * FROM flightseats WHERE fltcode=? AND depdate=?";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $flt, $dept);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $resultCheck = mysqli_num_rows($resultData);

    if ($resultCheck > 0) {                                         //if exists, check available seats
        $result = mysqli_fetch_assoc($resultData);
        if ($pax > $result["avlseats"]) {
            return 0;
        } else {
            return 1;
        }
    } else {
        return 1;
    }

}

function updateFlightSeats($conn, $flt, $dept, $pax) {

    //check table flightseats if input flight and date exist in dB
    $sql = "SELECT * FROM flightseats WHERE fltcode=? AND depdate=?";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $flt, $dept);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $resultCheck = mysqli_num_rows($resultData);

    if ($resultCheck > 0) {                                         //if exists, update row 
        $result = mysqli_fetch_assoc($resultData);
        
        $avl = $result['avlseats'] - $pax;

        $sql = "UPDATE flightseats SET avlseats=? WHERE fltcode=? AND depdate=?";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:../index.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sss", $avl, $flt, $dept);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } 

    else {                                                          //if not exists, insert row
        $sql = "SELECT * FROM flights WHERE fltcode=?";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:../index.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $flt);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $result = mysqli_fetch_assoc($resultData);

        $tot = $result['seats'];   
        $avl = $tot - $pax;

        $sql = "INSERT INTO flightseats (fltcode, depdate, totseats, avlseats) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:../index.php?error=sqlerror");
            exit();
        }
        
        mysqli_stmt_bind_param($stmt, "ssss", $flt, $dept, $tot, $avl);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    return;
}


function createFlightBooking($conn, $fname, $lname, $gender, $dob, $flt1, $flt2, $dept, $retn, $pax, $uname, $bookid, $totv) {
    
    if (!empty($flt2)) {

        $t1 = checkFlightSeats($conn, $flt1, $dept, $pax);
        $t2 = checkFlightSeats($conn, $flt2, $retn, $pax);

        if ($t1 && $t2) {
                
            for ($i=0; $i < $pax; $i++) { 
                    
                $sql = "INSERT INTO flightbookings (bookingID, fname, lname, gender, dob, fltcd, doj) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);                            //prepared statement
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location:../index.php?error=sqlerror");
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "sssssss", $bookid, $fname[$i], $lname[$i], $gender[$i], $dob[$i], $flt1, $dept);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                $sql = "INSERT INTO flightbookings (bookingID, fname, lname, gender, dob, fltcd, doj) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);                            //prepared statement
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location:../index.php?error=sqlerror");
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "sssssss", $bookid, $fname[$i], $lname[$i], $gender[$i], $dob[$i], $flt2, $retn);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            
            }

            updateFlightSeats($conn, $flt1, $dept, $pax);
            updateFlightSeats($conn, $flt2, $retn, $pax);

            $sql = "INSERT INTO bookings (bookingID, uname, start, endd, pax, totv) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location:../index.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "ssssss", $bookid, $uname, $dept, $retn, $pax, $totv);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

        } else {
            header("Location:../index.php?booking=fail1");
            exit();
        }

    } else {

        $t1 = checkFlightSeats($conn, $flt1, $dept, $pax);

        if ($t1) {
                
            for ($i=0; $i < $pax; $i++) { 
                
                $sql = "INSERT INTO flightbookings (bookingID, fname, lname, gender, dob, fltcd, doj) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);                            //prepared statement
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location:../index.php?error=sqlerror");
                    exit();
                }

                mysqli_stmt_bind_param($stmt, "sssssss", $bookid, $fname[$i], $lname[$i], $gender[$i], $dob[$i], $flt1, $dept);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }

            updateFlightSeats($conn, $flt1, $dept, $pax);

            $sql = "INSERT INTO bookings (bookingID, uname, start, endd, pax, totv) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location:../index.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "ssssss", $bookid, $uname, $dept, $dept, $pax, $totv);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

        } else {
            header("Location:../index.php?booking=fail1");
            exit();
        }        
    }

    header("Location:../paymentGateway.php?&bookid=".$bookid."&totv=".$totv);
    exit();
}

// ***************functions for searchHotels***************

//calculates trip duration
function dateDifference($start_date, $end_date) {
    // calulating the difference in timestamps 
    $diff = strtotime($start_date) - strtotime($end_date);
     
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds
    return ceil(abs($diff / 86400));
}

//checks if there are sufficient rooms for entire trip duration
function checkHotelRooms($conn, $hotel, $chkin, $chkout, $room, $pax){

    $nrooms = ($pax%2 == 0) ? $pax/2 : ($pax+1)/2;
    $nights = dateDifference($chkin, $chkout);

    if ($room == "Single") {
        $roomx = "room1";
    }
    if ($room == "Double") {
        $roomx = "room2";
    }
    if ($room == "Suite") {
        $roomx = "room3";
    }

    $date = date_create($chkin);
    $avl = 1;

    for ($i=0; $i < $nights; $i++) {

        date_modify($date, '+1 day');
        $chkin = date_format($date, 'Y-m-d');
        
        //check if there exists an entry for queried hotel and dates
        $sql = "SELECT * FROM hotelrooms WHERE hotel=? AND checkin=?";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:../index.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $hotel, $chkin);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $resultCheck = mysqli_num_rows($resultData);

        if ($resultCheck > 0) {                                         //if exists, check available seats
            $result = mysqli_fetch_assoc($resultData);
            if ($nrooms > $result[$roomx]) {
                $avl *= 0;
            } else {
                $avl *= 1;
            }
        } else {
            $avl *= 1;
        }

    }

    return $avl;

}

//updates available rooms after a booking is made
function updateHotelRooms($conn, $hotel, $chkin, $chkout, $room, $pax) {

    //preparing to update hotel rooms
    $sql = "SELECT * from hotels WHERE name=?";
    $stmt = mysqli_stmt_init($conn);                                //prepared statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $hotel);
    mysqli_stmt_execute($stmt);
    $result = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    $tot1 = $result["room1"];
    $tot2 = $result["room2"];
    $tot3 = $result["room3"];                                       //finding total no. of rooms from hotels table

    $d1 = $chkin; $i = 0;
    $nights = dateDifference($chkin, $chkout);
    $nrooms = ($pax%2 == 0) ? $pax/2 : ($pax+1)/2;
    $dates[] = "";

    //get daterange from hotelrooms for input hotel and dates if it exists in dB
    $sql = "SELECT * FROM hotelrooms WHERE hotel=? AND checkin>=? AND checkin<? ORDER BY checkin";
    $stmt = mysqli_stmt_init($conn);                                //prepared statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $hotel, $chkin, $chkout);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $resultCheck = mysqli_num_rows($resultData);
    while ($result = mysqli_fetch_assoc($resultData)) {
        $dates[$i] = $result["checkin"];
        $i++;
    }


    for ($i=0, $k=0; $i < $nights; $i++) {                                //execute only one update or insert statement for each night
        
        if ($d1 == $dates[$k]) {

            $sql = "SELECT * FROM hotelrooms WHERE hotel=? AND checkin=?";
            $stmt = mysqli_stmt_init($conn);                                //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location:../index.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "ss", $hotel, $d1);
            mysqli_stmt_execute($stmt);
            $resultData = mysqli_stmt_get_result($stmt);
            $resultCheck = mysqli_num_rows($resultData);
            $result = mysqli_fetch_assoc($resultData);

            $room1 = $result["room1"];
            $room2 = $result["room2"];
            $room3 = $result["room3"];

            if ($room == "Single") {
                $room1 -= $nrooms;
            }
            if ($room == "Double") {
                $room2 -= $nrooms;
            }
            if ($room == "Suite") {
                $room3 -= $nrooms;
            }

            $sql = "UPDATE hotelrooms SET room1=?, room2=?, room3=? WHERE hotel=? AND checkin=?";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location:../index.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "sssss", $room1, $room2, $room3, $hotel, $d1);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $k++;

        }
        else {
            
            $room1 = $tot1;
            $room2 = $tot2;
            $room3 = $tot3;

            if ($room == "Single") {
                $room1 -= $nrooms;
            }
            if ($room == "Double") {
                $room2 -= $nrooms;
            }
            if ($room == "Suite") {
                $room3 -= $nrooms;
            }

            $sql = "INSERT INTO hotelrooms (hotel, checkin, room1, room2, room3) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location:../index.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "sssss", $hotel, $d1, $room1, $room2, $room3);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        $dtemp = strtotime("+1 day", strtotime($d1));
        $d1 = date("Y-m-d", $dtemp);
    }

    return;
}

//creates hotel bookings
function createHotelBooking($conn, $fname, $lname, $gender, $dob, $hname, $checkin, $checkout, $room, $pax, $uname, $bookid, $totv) {

    $t1 = checkHotelRooms($conn, $hname, $checkin, $checkout, $room, $pax);

    if ($t1) {
        
        for ($i=0; $i < $pax; $i++) { 
                
            $sql = "INSERT INTO hotelbookings (bookingID, fname, lname, gender, dob, hname, room, checkin, checkout) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location:../index.php?error=sqlerror");
                exit();
            }
            
            mysqli_stmt_bind_param($stmt, "sssssssss", $bookid, $fname[$i], $lname[$i], $gender[$i], $dob[$i], $hname, $room, $checkin, $checkout);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

        }

        updateHotelRooms($conn, $hname, $checkin, $checkout, $room, $pax);

        $sql = "INSERT INTO bookings (bookingID, uname, start, endd, pax, totv) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:../index.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ssssss", $bookid, $uname, $checkin, $checkout, $pax, $totv);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location:../paymentGateway.php?&bookid=".$bookid."&totv=".$totv);
        exit();

    }

    header("Location:../index.php?booking=fail2");
    exit();
}


// ***************functions for tourBooking***************

function checkTourAvailability($conn, $flt1, $flt2, $hname, $sdate, $edate, $room, $pax) {

    $t1 = checkFlightSeats($conn, $flt1, $sdate, $pax);
    $t2 = checkFlightSeats($conn, $flt2, $edate, $pax);
    $t3 = checkHotelRooms($conn, $hname, $sdate, $edate, $room, $pax);

    return $t1*$t2*$t3;
}

function createTourBooking($conn, $fname, $lname, $gender, $dob, $flt1, $flt2, $hname, $sdate, $edate, $room, $pax, $uname, $bookid, $totv) {

    $t1 = checkTourAvailability($conn, $flt1, $flt2, $hname, $sdate, $edate, $room, $pax);         //check availability for flights and hotels

    if ($t1) {

        for ($i=0; $i < $pax; $i++) { 
                
                // book flt1
            $sql1 = "INSERT INTO flightbookings (bookingID, fname, lname, gender, dob, fltcd, doj) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql1)) {
                header("Location:../index.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "sssssss", $bookid, $fname[$i], $lname[$i], $gender[$i], $dob[$i], $flt1, $sdate);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

                // book flt2
            $sql2 = "INSERT INTO flightbookings (bookingID, fname, lname, gender, dob, fltcd, doj) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql2)) {
                header("Location:../index.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "sssssss", $bookid, $fname[$i], $lname[$i], $gender[$i], $dob[$i], $flt2, $edate);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

                // book hotel
            $sql3 = "INSERT INTO hotelbookings (bookingID, fname, lname, gender, dob, hname, room, checkin, checkout) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql3)) {
                header("Location:../index.php?error=sqlerror");
                exit();
            }
            
            mysqli_stmt_bind_param($stmt, "sssssssss", $bookid, $fname[$i], $lname[$i], $gender[$i], $dob[$i], $hname, $room, $sdate, $edate);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        updateFlightSeats($conn, $flt1, $sdate, $pax);
        updateFlightSeats($conn, $flt2, $edate, $pax);
        updateHotelRooms($conn, $hname, $sdate, $edate, $room, $pax);

            // insert into bookings
        $sql = "INSERT INTO bookings (bookingID, uname, start, endd, pax, totv) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:../index.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ssssss", $bookid, $uname, $sdate, $edate, $pax, $totv);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location:../paymentGateway.php?&bookid=".$bookid."&totv=".$totv);
        exit();

    }

    header("Location:../index.php?booking=fail3");
    exit();

}

// ************functions for Cancel Booking***************

//reset flight seats when a booking is deleted
function resetFlightSeats($conn, $bookid) {                     

    $sql = "SELECT * FROM bookings WHERE bookingID=?";          //fetch pax from bookings table
    $stmt = mysqli_stmt_init($conn);                            //prepared statement 
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $bookid);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($resultData);

    $pax = $result['pax'];

    $sql1 = "SELECT DISTINCT fltcd, doj FROM flightbookings WHERE bookingID=?";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement 
    if (!mysqli_stmt_prepare($stmt, $sql1)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $bookid);
    mysqli_stmt_execute($stmt);
    $result1Data = mysqli_stmt_get_result($stmt);

    if ($result1Check = mysqli_num_rows($result1Data)) {

        while ($result1 = mysqli_fetch_assoc($result1Data)) {           //update for all fltcodes and dojs
            
            $sql2 = "SELECT * FROM flightseats WHERE fltcode=? AND depdate=?";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql2)) {
                header("Location:../index.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "ss", $result1['fltcd'], $result1['doj']);
            mysqli_stmt_execute($stmt);
            $result2Data = mysqli_stmt_get_result($stmt);
            $result2 = mysqli_fetch_assoc($result2Data);
            
            $avl = $result2['avlseats'] + $pax;

            $sql3 = "UPDATE flightseats SET avlseats=? WHERE fltcode=? AND depdate=?";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql3)) {
                header("Location:../index.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "sss", $avl, $result1['fltcd'], $result1['doj']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

        }
    }

    return;
}

//reset hotel rooms when a booking is deleted
function resetHotelRooms($conn, $bookid) {                     

    $sql = "SELECT * FROM bookings WHERE bookingID=?";          //fetch pax from bookings table
    $stmt = mysqli_stmt_init($conn);                            //prepared statement 
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $bookid);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($resultData);

    $pax = $result['pax'];
    $nrooms = ($pax%2 == 0) ? $pax/2 : ($pax+1)/2;

    $sql1 = "SELECT DISTINCT hname, room, checkin, checkout FROM hotelbookings WHERE bookingID=?";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement 
    if (!mysqli_stmt_prepare($stmt, $sql1)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $bookid);
    mysqli_stmt_execute($stmt);
    $result1Data = mysqli_stmt_get_result($stmt);
    if ($result1Check = mysqli_num_rows($result1Data)) {
            
        $result1 = mysqli_fetch_assoc($result1Data);

        $hotel = $result1['hname'];
        $room = $result1['room'];
        $chkin = $result1['checkin'];
        $chkout = $result1['checkout'];

        $d1 = $chkin;
        $nights = dateDifference($chkin, $chkout);

        for ($i=0; $i < $nights; $i++) {                                //execute only one update or insert statement for each night
        
            $sql2 = "SELECT * FROM hotelrooms WHERE hotel=? AND checkin=?";
            $stmt = mysqli_stmt_init($conn);                                //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql2)) {
                header("Location:../index.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "ss", $hotel, $d1);
            mysqli_stmt_execute($stmt);
            $result2Data = mysqli_stmt_get_result($stmt);
            $result2Check = mysqli_num_rows($result2Data);
            $result2 = mysqli_fetch_assoc($result2Data);

            $room1 = $result2["room1"];
            $room2 = $result2["room2"];
            $room3 = $result2["room3"];

            if ($room == "Single") {
                $room1 += $nrooms;
            }
            if ($room == "Double") {
                $room2 += $nrooms;
            }
            if ($room == "Suite") {
                $room3 += $nrooms;
            }

            $sql = "UPDATE hotelrooms SET room1=?, room2=?, room3=? WHERE hotel=? AND checkin=?";
            $stmt = mysqli_stmt_init($conn);                            //prepared statement
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location:../index.php?error=sqlerror");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "sssss", $room1, $room2, $room3, $hotel, $d1);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);


            $dtemp = strtotime("+1 day", strtotime($d1));
            $d1 = date("Y-m-d", $dtemp);
        }
    }

    return;
}

//delete bookings
function deleteBooking($conn, $bookid, $url) {

    resetFlightSeats($conn, $bookid);
    resetHotelRooms($conn, $bookid);

    $sql = "DELETE FROM bookings WHERE bookingID=?";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement 
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $bookid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $sql = "DELETE FROM flightbookings WHERE bookingID=?";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement 
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $bookid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $sql = "DELETE FROM hotelbookings WHERE bookingID=?";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement 
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $bookid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: $url");
    exit();
}