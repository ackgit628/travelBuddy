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

// ***************functions for login***************
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

function updateFlightSeats($conn, $flt, $dept, $pax) {

    //check flightseats if input flight and date exist in dB
    $sql = "SELECT * FROM flightseats WHERE fltcode=? AND depdate=?";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror1");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $flt, $dept);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $resultCheck = mysqli_num_rows($resultData);

    if ($resultCheck > 0) {                                         //if exists, update row 
        $result = mysqli_fetch_assoc($resultData);
        
        $sold = $result['soldseats'] + $pax;
        $avl = $result['totseats'] - $sold;

        $sql = "UPDATE flightseats SET soldseats=?, avlseats=? WHERE fltcode=? AND depdate=?";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:../index.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ssss", $sold, $avl, $flt, $dept);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } 

    else {                                                          //if not exists, insert row
        $sql = "SELECT * FROM flights WHERE fltcode=?";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:../index.php?error=sqlerror2");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $flt);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $result = mysqli_fetch_assoc($resultData);

        $tot = $result['seats'];                                    //finding total no. of seats from flights table
        $sold = $pax;
        $avl = $tot - $sold;

        $sql = "INSERT INTO flightseats (fltcode, depdate, soldseats, totseats, avlseats) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:../index.php?error=sqlerror3");
            exit();
        }
        
        mysqli_stmt_bind_param($stmt, "sssss", $flt, $dept, $sold, $tot, $avl);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    return;
}


function createFlightBooking($conn, $fname, $lname, $gender, $dob, $flt1, $flt2, $dept, $retn, $uname, $bookid, $totv) {
    
    for ($i=0; $i < count($fname); $i++) { 
            
        $sql = "INSERT INTO flightbookings (bookingID, fname, lname, gender, dob, fltcd, doj) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:../index.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sssssss", $bookid, $fname[$i], $lname[$i], $gender[$i], $dob[$i], $flt1, $dept);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if (!empty($flt2)) {
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
    }

    if (!empty($flt2)) {

        updateFlightSeats($conn, $flt1, $dept, count($fname));
        updateFlightSeats($conn, $flt2, $retn, count($fname));

        $sql = "INSERT INTO bookings (bookingID, uname, start, endd, totv) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:../index.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sssss", $bookid, $uname, $dept, $retn, $totv);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    } else {

        updateFlightSeats($conn, $flt1, $dept, count($fname));

        $sql = "INSERT INTO bookings (bookingID, uname, start, endd, totv) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);                            //prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:../index.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sssss", $bookid, $uname, $dept, $dept, $totv);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
    }

    header("Location:../index.php?booking=success");
    exit();
}

// ***************functions for searchHotels***************

function dateDifference($start_date, $end_date)
{
    // calulating the difference in timestamps 
    $diff = strtotime($start_date) - strtotime($end_date);
     
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds
    return ceil(abs($diff / 86400));
}

function updateHotelRooms($conn, $hotel, $chkin, $chkout, $room, $pax) {

    //preparing to update hotel rooms
    $sql = "SELECT * from hotels WHERE name=?";
    $stmt = mysqli_stmt_init($conn);                                //prepared statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror1");
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
        header("Location:../index.php?error=sqlerror1");
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
                header("Location:../index.php?error=sqlerror1");
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

function createHotelBooking($conn, $fname, $lname, $gender, $dob, $hname, $checkin, $checkout, $room, $uname, $bookid, $totv) {

    for ($i=0; $i < count($fname); $i++) { 
            
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

    updateHotelRooms($conn, $hname, $checkin, $checkout, $room, count($fname));

    $sql = "INSERT INTO bookings (bookingID, uname, start, endd, totv) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $bookid, $uname, $checkin, $checkout, $totv);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location:../index.php?booking=success");
    exit();
}

// ***************functions for tourBooking***************
function createTourBooking($conn, $fname, $lname, $gender, $dob, $flt1, $flt2, $hname, $sdate, $edate, $room, $pax, $uname, $bookid, $totv) {

    for ($i=0; $i < count($fname); $i++) { 
            
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

        // insert into bookings
    $sql = "INSERT INTO bookings (bookingID, uname, start, endd, totv) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $bookid, $uname, $sdate, $edate, $totv);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location:../index.php?booking=success");
    exit();
}

//functions for modify booking
function deleteReservation($conn, $bookid) {
    $sql = "SELECT * FROM flightbookings WHERE bookingID=?";
    $stmt = mysqli_stmt_init($conn);                            //prepared statement 
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location:../index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $bookid);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $resultCheck = mysqli_num_rows($resultData);
    $result = mysqli_fetch_assoc($resultData);

    $seats = $resultCheck;
}

function deleteBooking($conn, $bookid, $url) {
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