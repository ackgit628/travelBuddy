-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2021 at 08:04 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travelbuddy`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `bookingID` tinytext NOT NULL,
  `uname` tinytext NOT NULL,
  `start` date NOT NULL,
  `endd` date NOT NULL,
  `pax` int(11) NOT NULL,
  `totv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `bookingID`, `uname`, `start`, `endd`, `pax`, `totv`) VALUES
(9, 'ETKT0020201124232535', 'test', '2020-11-25', '2020-11-27', 0, 18000),
(10, 'ETKT002020112513016', 'test', '2020-11-25', '2020-11-25', 0, 5000),
(22, 'BKNG0020210209212055', 'test', '2021-02-11', '2021-02-12', 0, 5000),
(24, 'BKNG002021021263441', 'test', '2021-02-13', '2021-02-14', 0, 5000),
(26, 'TPKG0020210225191726', 'demo', '2021-02-26', '2021-03-03', 0, 52000),
(28, 'TPKG002021022634717', 'test', '2021-02-26', '2021-03-03', 0, 47000),
(30, 'BKNG0020210310133137', 'demo', '2021-03-11', '2021-03-14', 0, 15000),
(31, 'ETKT0020210311193309', 'demo', '2021-03-11', '2021-03-11', 0, 3000),
(32, 'ETKT0020210312105706', 'test', '2021-03-12', '2021-03-12', 0, 12000),
(40, 'BKNG0020210313235515', 'demo', '2021-03-14', '2021-03-18', 0, 16000),
(41, 'BKNG0020210313235610', 'demo', '2021-03-14', '2021-03-18', 0, 16000),
(42, 'BKNG0020210313235714', 'demo', '2021-03-14', '2021-03-16', 0, 8000),
(43, 'BKNG0020210313235949', 'demo', '2021-03-16', '2021-03-20', 0, 16000),
(44, 'TPKG002021031985118', 'test', '2021-03-20', '2021-03-21', 0, 10000),
(46, 'ETKT002021040203323', 'test', '2021-04-02', '2021-04-02', 0, 3000),
(48, 'BKNG002021042121259', 'demo', '2021-04-22', '2021-04-24', 3, 32000),
(49, 'TPKG002021042223311', 'demo', '2021-04-22', '2021-04-25', 2, 21000),
(51, 'ETKT0020210426122154', 'test', '2021-04-26', '2021-04-26', 1, 4500),
(52, 'BKNG0020210426123104', 'test', '2021-04-26', '2021-05-01', 1, 25000),
(53, 'ETKT002021042735758', 'demo', '2021-04-27', '2021-04-27', 1, 3500),
(54, 'ETKT002021042744407', 'demo', '2021-04-27', '2021-04-27', 1, 3500),
(55, 'TPKG0020210427231257', 'demo', '2021-04-30', '2021-05-09', 1, 141000);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `citycode` char(3) NOT NULL,
  `cityname` tinytext NOT NULL,
  `akacity` tinytext DEFAULT NULL,
  `airportname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `citycode`, `cityname`, `akacity`, `airportname`) VALUES
(1, 'BOM', 'MUMBAI', 'BOMBAY', 'Chhatrapati Shivaji Maharaj International Airport'),
(2, 'DEL', 'NEW DELHI', 'DELHI', 'Indira Gandhi International Airport'),
(3, 'CCU', 'KOLKATA', 'CALCUTTA', 'Netaji Subhas Chandra Bose International Airport'),
(4, 'BLR', 'BENGALURU', 'BANGALORE', 'Kempegowda International Airport'),
(5, 'GOI', 'GOA', NULL, 'Dabolim Airport');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `fname` tinytext NOT NULL,
  `lname` tinytext NOT NULL,
  `empid` tinytext NOT NULL,
  `pword` longtext NOT NULL,
  `email` tinytext NOT NULL,
  `phone` tinytext NOT NULL,
  `utype` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `fname`, `lname`, `empid`, `pword`, `email`, `phone`, `utype`) VALUES
(2, 'admin', '', 'admin', '$2y$10$vn8yWEfVynd9fqMrC9JTaeLn25QzfVgy8btVJl30PN7yc69krfkca', 'admin@travelbuddy.com', '9009001234', 'admin'),
(3, 'Adesh', 'Malik', 'emp001', '$2y$10$qdbrWQLaympnEgnfml6JjOl.mFFT8pji7u0S8nJl9yU6SsHnzfPfW', 'adesh@tbd.com', '990011233', 'employee'),
(5, 'test', '  ', 'test', '$2y$10$YZlNG6T32H0skH.4HhlZ4.8JzbYzaTJ1II7HvsbjywpEr2cYHMlKm', 'test@test.com', '9009001234', 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `flightbookings`
--

CREATE TABLE `flightbookings` (
  `id` int(11) NOT NULL,
  `bookingID` tinytext NOT NULL,
  `fname` tinytext NOT NULL,
  `lname` tinytext NOT NULL,
  `gender` tinytext NOT NULL,
  `dob` date NOT NULL,
  `fltcd` tinytext NOT NULL,
  `doj` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `flightbookings`
--

INSERT INTO `flightbookings` (`id`, `bookingID`, `fname`, `lname`, `gender`, `dob`, `fltcd`, `doj`) VALUES
(13, 'ETKT0020201124232535', 'john', 'doe', 'Male', '1989-11-11', 'AI323', '2020-11-25'),
(14, 'ETKT0020201124232535', 'john', 'doe', 'Male', '1989-11-11', 'AI324', '2020-11-27'),
(15, 'ETKT0020201124232535', 'jane', 'doe', 'Female', '1990-10-10', 'AI323', '2020-11-25'),
(16, 'ETKT0020201124232535', 'jane', 'doe', 'Female', '1990-10-10', 'AI324', '2020-11-27'),
(17, 'ETKT002020112513016', 'adam', 'smith', 'Male', '1982-12-06', 'SG957', '2020-11-25'),
(25, 'TPKG0020210225191726', 'pete', 'davis', 'Male', '1993-11-16', 'SG195', '2021-02-26'),
(26, 'TPKG0020210225191726', 'pete', 'davis', 'Male', '1993-11-16', 'SG196', '2021-03-03'),
(27, 'TPKG0020210225191726', 'ann', 'perkins', 'Female', '1976-07-21', 'SG195', '2021-02-26'),
(28, 'TPKG0020210225191726', 'ann', 'perkins', 'Female', '1976-07-21', 'SG196', '2021-03-03'),
(33, 'TPKG002021022634717', 'smith', 'jones', 'Male', '1991-12-11', 'SG195', '2021-02-26'),
(34, 'TPKG002021022634717', 'smith', 'jones', 'Male', '1991-12-11', 'SG196', '2021-03-03'),
(35, 'TPKG002021022634717', 'francis', 'jones', 'Female', '1994-03-02', 'SG195', '2021-02-26'),
(36, 'TPKG002021022634717', 'francis', 'jones', 'Female', '1994-03-02', 'SG196', '2021-03-03'),
(47, 'ETKT0020210311193309', 'demo5', 'demo5', 'Male', '2020-11-28', 'SG195', '2021-03-11'),
(48, 'ETKT0020210312105706', 'd1', 'd1', 'Male', '1999-11-11', 'SG195', '2021-03-12'),
(49, 'ETKT0020210312105706', 'd2', 'd2', 'Male', '1999-12-12', 'SG195', '2021-03-12'),
(50, 'ETKT0020210312105706', 'd3', 'd3', 'Male', '1999-09-11', 'SG195', '2021-03-12'),
(51, 'ETKT0020210312105706', 'd4', 'd4', 'Male', '1999-06-17', 'SG195', '2021-03-12'),
(52, 'TPKG002021031985118', 'john', 'doe', 'Male', '1995-02-01', 'SG195', '2021-03-20'),
(53, 'TPKG002021031985118', 'john', 'doe', 'Male', '1995-02-01', 'SG195', '2021-03-21'),
(55, 'ETKT002021040203323', 'stephen ', 'king', 'Male', '1969-09-23', 'SG195', '2021-04-02'),
(56, 'TPKG002021042223311', 'ariana', 'grande', 'Female', '1992-09-09', 'SG195', '2021-04-22'),
(57, 'TPKG002021042223311', 'ariana', 'grande', 'Female', '1992-09-09', 'SG196', '2021-04-25'),
(58, 'TPKG002021042223311', 'akhilesh', 'hessa', 'Male', '1996-06-09', 'SG195', '2021-04-22'),
(59, 'TPKG002021042223311', 'akhilesh', 'hessa', 'Male', '1996-06-09', 'SG196', '2021-04-25'),
(62, 'ETKT0020210426122154', 'john', 'smith', 'Male', '1991-07-02', 'AI126', '2021-04-26'),
(63, 'ETKT002021042735758', 'jon', 'jon', 'Male', '1996-01-12', '6E441', '2021-04-27'),
(64, 'ETKT002021042744407', 'don', 'smith', 'Male', '1999-02-20', '6E441', '2021-04-27'),
(65, 'TPKG0020210427231257', 'Sneha', 'Hessa', 'Female', '1999-12-16', 'SG195', '2021-04-30'),
(66, 'TPKG0020210427231257', 'Sneha', 'Hessa', 'Female', '1999-12-16', 'SG196', '2021-05-09');

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` int(11) NOT NULL,
  `fltcode` varchar(6) NOT NULL,
  `airline` tinytext NOT NULL,
  `origcode` char(3) NOT NULL,
  `origcity` tinytext NOT NULL,
  `destcode` char(3) NOT NULL,
  `destcity` tinytext NOT NULL,
  `deptime` time NOT NULL,
  `arrtime` time NOT NULL,
  `opdays` int(11) NOT NULL,
  `seats` int(11) NOT NULL,
  `fare` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`id`, `fltcode`, `airline`, `origcode`, `origcity`, `destcode`, `destcity`, `deptime`, `arrtime`, `opdays`, `seats`, `fare`) VALUES
(1, 'AI123', 'AIR INDIA', 'DEL', 'NEW DELHI', 'BOM', 'MUMBAI', '06:00:00', '08:00:00', 126, 10, 4000),
(2, 'AI124', 'AIR INDIA', 'BOM', 'MUMBAI', 'DEL', 'NEW DELHI', '09:00:00', '11:00:00', 126, 10, 4000),
(3, 'SG956', 'SPICEJET', 'DEL', 'NEW DELHI', 'BOM', 'MUMBAI', '08:30:00', '10:30:00', 31, 10, 5000),
(4, 'SG957', 'SPICEJET', 'BOM', 'MUMBAI', 'DEL', 'NEW DELHI', '11:30:00', '13:30:00', 31, 10, 5000),
(5, 'AI125', 'AIR INDIA', 'DEL', 'NEW DELHI', 'BOM', 'MUMBAI', '16:00:00', '18:00:00', 77, 10, 4500),
(6, 'AI126', 'AIR INDIA', 'BOM', 'MUMBAI', 'DEL', 'NEW DELHI', '19:00:00', '21:00:00', 77, 10, 4500),
(7, 'AI322', 'AIR INDIA', 'DEL', 'NEW DELHI', 'CCU', 'KOLKATA', '11:00:00', '13:00:00', 63, 10, 5000),
(8, 'AI323', 'AIR INDIA', 'CCU', 'KOLKATA', 'DEL', 'NEW DELHI', '15:00:00', '17:00:00', 63, 20, 5000),
(9, 'AI324', 'AIR INDIA', 'DEL', 'NEW DELHI', 'CCU', 'KOLKATA', '18:00:00', '20:00:00', 127, 20, 4000),
(10, 'AI321', 'AIR INDIA', 'CCU', 'KOLKATA', 'DEL', 'NEW DELHI', '08:00:00', '10:00:00', 127, 20, 4000),
(11, '6E441', 'INDIGO', 'BOM', 'MUMBAI', 'GOI', 'GOA', '10:00:00', '11:00:00', 63, 20, 3500),
(12, '6E442', 'INDIGO', 'GOI', 'GOA', 'BOM', 'MUMBAI', '18:00:00', '19:00:00', 63, 20, 3500),
(13, 'SG195', 'SPICEJET', 'BOM', 'MUMBAI', 'GOI', 'GOA', '10:30:00', '11:30:00', 123, 20, 3000),
(14, 'SG196', 'SPICEJET', 'GOI', 'GOA', 'BOM', 'MUMBAI', '17:30:00', '18:30:00', 123, 20, 3000);

-- --------------------------------------------------------

--
-- Table structure for table `flightseats`
--

CREATE TABLE `flightseats` (
  `id` int(11) NOT NULL,
  `fltcode` tinytext NOT NULL,
  `depdate` date NOT NULL,
  `totseats` int(11) NOT NULL,
  `avlseats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `flightseats`
--

INSERT INTO `flightseats` (`id`, `fltcode`, `depdate`, `totseats`, `avlseats`) VALUES
(1, 'SG195', '2021-03-11', 20, 19),
(2, 'SG195', '2021-03-12', 20, 16),
(3, 'SG195', '2021-04-02', 20, 0),
(4, 'SG195', '2021-04-22', 20, 18),
(5, 'SG196', '2021-04-25', 20, 18),
(6, 'SG195', '2021-04-23', 20, 20),
(7, 'AI126', '2021-04-26', 10, 9),
(8, '6E441', '2021-04-27', 20, 18),
(9, 'SG195', '2021-04-30', 20, 19),
(10, 'SG196', '2021-05-09', 20, 19);

-- --------------------------------------------------------

--
-- Table structure for table `hotelbookings`
--

CREATE TABLE `hotelbookings` (
  `id` int(11) NOT NULL,
  `bookingID` tinytext NOT NULL,
  `fname` tinytext NOT NULL,
  `lname` tinytext NOT NULL,
  `gender` tinytext NOT NULL,
  `dob` date NOT NULL,
  `hname` tinytext NOT NULL,
  `room` tinytext NOT NULL,
  `checkin` date NOT NULL,
  `checkout` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotelbookings`
--

INSERT INTO `hotelbookings` (`id`, `bookingID`, `fname`, `lname`, `gender`, `dob`, `hname`, `room`, `checkin`, `checkout`) VALUES
(3, 'BKNG0020210209212055', 'akhilesh', 'hessa', 'Male', '1996-06-19', 'Golden Sand Resort', 'Single', '2021-02-11', '2021-02-12'),
(6, 'BKNG002021021263441', 'john', 'doe', 'Male', '2021-02-10', 'Golden Sand Resort', 'Single', '2021-02-13', '2021-02-14'),
(9, 'TPKG0020210225191726', 'pete', 'davis', 'Male', '1993-11-16', 'The Lazy Cabana', 'Double', '2021-02-26', '2021-03-03'),
(10, 'TPKG0020210225191726', 'ann', 'perkins', 'Female', '1976-07-21', 'The Lazy Cabana', 'Double', '2021-02-26', '2021-03-03'),
(13, 'TPKG002021022634717', 'smith', 'jones', 'Male', '1991-12-11', 'Holiday Inn', 'Double', '2021-02-26', '2021-03-03'),
(14, 'TPKG002021022634717', 'francis', 'jones', 'Female', '1994-03-02', 'Holiday Inn', 'Double', '2021-02-26', '2021-03-03'),
(17, 'BKNG0020210310133137', 'jack', 'leach', 'Male', '1212-12-12', 'Beach Resort', 'Single', '2021-03-11', '2021-03-14'),
(18, 'BKNG0020210310133137', 'jill', 'b', 'Female', '0909-09-09', 'Beach Resort', 'Single', '2021-03-11', '2021-03-14'),
(19, 'BKNG0020210310133137', 'baby', 'sparrow', 'Male', '1111-11-11', 'Beach Resort', 'Single', '2021-03-11', '2021-03-14'),
(30, 'BKNG0020210313235515', 'a1', 'a1', 'Male', '2021-03-04', 'Holiday Inn', 'Single', '2021-03-14', '2021-03-18'),
(31, 'BKNG0020210313235610', 'b1', 'b1', 'Male', '2021-03-05', 'Holiday Inn', 'Single', '2021-03-14', '2021-03-18'),
(32, 'BKNG0020210313235714', 'c1', 'c1', 'Male', '2021-03-06', 'Holiday Inn', 'Single', '2021-03-14', '2021-03-16'),
(33, 'BKNG0020210313235949', 'd1', 'd2', 'Male', '2021-03-07', 'Holiday Inn', 'Single', '2021-03-16', '2021-03-20'),
(34, 'TPKG002021031985118', 'john', 'doe', 'Male', '1995-02-01', 'Holiday Inn', 'Single', '2021-03-20', '2021-03-21'),
(38, 'BKNG002021042121259', 'prince', 'phillip', 'Male', '1908-05-09', 'The Lazy Cabana', 'Double', '2021-04-22', '2021-04-24'),
(39, 'BKNG002021042121259', 'queen', 'elizabeth', 'Female', '1912-12-06', 'The Lazy Cabana', 'Double', '2021-04-22', '2021-04-24'),
(40, 'BKNG002021042121259', 'princess', 'diana', 'Female', '1965-07-15', 'The Lazy Cabana', 'Double', '2021-04-22', '2021-04-24'),
(41, 'TPKG002021042223311', 'ariana', 'grande', 'Female', '1992-09-09', 'Hotel Sea View', 'Single', '2021-04-22', '2021-04-25'),
(42, 'TPKG002021042223311', 'akhilesh', 'hessa', 'Male', '1996-06-09', 'Hotel Sea View', 'Single', '2021-04-22', '2021-04-25'),
(44, 'BKNG0020210426123104', 'smith', 'jones', 'Male', '1995-11-05', 'Golden Sand Resort', 'Single', '2021-04-26', '2021-05-01'),
(45, 'TPKG0020210427231257', 'Sneha', 'Hessa', 'Female', '1999-12-16', 'Holiday Inn', 'Suite', '2021-04-30', '2021-05-09');

-- --------------------------------------------------------

--
-- Table structure for table `hotelrooms`
--

CREATE TABLE `hotelrooms` (
  `id` int(11) NOT NULL,
  `hotel` tinytext NOT NULL,
  `checkin` date NOT NULL,
  `room1` int(11) NOT NULL,
  `room2` int(11) NOT NULL,
  `room3` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotelrooms`
--

INSERT INTO `hotelrooms` (`id`, `hotel`, `checkin`, `room1`, `room2`, `room3`) VALUES
(12, 'Holiday Inn', '2021-03-14', 12, 10, 5),
(13, 'Holiday Inn', '2021-03-15', 12, 10, 5),
(14, 'Holiday Inn', '2021-03-16', 12, 10, 5),
(15, 'Holiday Inn', '2021-03-17', 12, 10, 5),
(16, 'Holiday Inn', '2021-03-18', 14, 10, 5),
(17, 'Holiday Inn', '2021-03-19', 14, 10, 5),
(18, 'The Lazy Cabana', '2021-04-22', 16, 8, 9),
(19, 'The Lazy Cabana', '2021-04-23', 16, 3, 9),
(20, 'Hotel Sea View', '2021-04-22', 11, 8, 0),
(21, 'Hotel Sea View', '2021-04-23', 11, 8, 0),
(22, 'Hotel Sea View', '2021-04-24', 11, 8, 0),
(23, 'Beach Resort', '2021-04-23', 10, 5, 0),
(24, 'Beach Resort', '2021-04-24', 10, 5, 0),
(25, 'Golden Sand Resort', '2021-04-26', 19, 12, 7),
(26, 'Golden Sand Resort', '2021-04-27', 19, 12, 7),
(27, 'Golden Sand Resort', '2021-04-28', 19, 12, 7),
(28, 'Golden Sand Resort', '2021-04-29', 19, 12, 7),
(29, 'Golden Sand Resort', '2021-04-30', 19, 12, 7),
(30, 'Holiday Inn', '2021-04-30', 15, 10, 4),
(31, 'Holiday Inn', '2021-05-01', 15, 10, 4),
(32, 'Holiday Inn', '2021-05-02', 15, 10, 4),
(33, 'Holiday Inn', '2021-05-03', 15, 10, 4),
(34, 'Holiday Inn', '2021-05-04', 15, 10, 4),
(35, 'Holiday Inn', '2021-05-05', 15, 10, 4),
(36, 'Holiday Inn', '2021-05-06', 15, 10, 4),
(37, 'Holiday Inn', '2021-05-07', 15, 10, 4),
(38, 'Holiday Inn', '2021-05-08', 15, 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `cityname` tinytext DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `room1` int(11) NOT NULL,
  `room2` int(11) NOT NULL,
  `room3` int(11) NOT NULL,
  `rate1` int(11) DEFAULT NULL,
  `rate2` int(11) NOT NULL,
  `rate3` int(11) NOT NULL,
  `description` text NOT NULL,
  `amenities` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `cityname`, `rating`, `room1`, `room2`, `room3`, `rate1`, `rate2`, `rate3`, `description`, `amenities`) VALUES
(1, 'Beach Resort', 'Goa', 2, 10, 5, 0, 2500, 5000, 0, 'This self-described “biking hotel” offers all the necessities for two-wheeled tours: Preparation advice, expert guides, equipment fixes and most importantly, post-ride comfort and care.', 'WiFi, Parking'),
(2, 'Holiday Inn', 'Goa', 4, 15, 10, 5, 4000, 7000, 15000, 'Perched on a hill in the jungle and overlooking the ocean, Holiday Inn is renowned for service and serenity.', 'AC, WiFi, Swimming pool, Parking'),
(3, 'Golden Sand Resort', 'Goa', 5, 20, 12, 7, 5000, 9000, 22000, 'Perched on a hill in the jungle and overlooking the ocean, Holiday Inn is renowned for service and serenity.', 'AC, WiFi, Swimming pool, Easy access Beach, Parking'),
(4, 'Hotel Sea View', 'Goa', 3, 12, 8, 0, 3000, 6000, 0, 'This self-described “biking hotel” offers all the necessities for two-wheeled tours: Preparation advice, expert guides, equipment fixes and most importantly, post-ride comfort and care.', 'AC, WiFi, Parking'),
(5, 'The Lazy Cabana', 'Goa', 5, 16, 10, 9, 5500, 8000, 21000, 'Perched on a hill in the jungle and overlooking the ocean, Holiday Inn is renowned for service and serenity.', 'AC, WiFi, Swimming pool, Resto-bar, Easy access Beach, Parking');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` tinytext DEFAULT NULL,
  `lname` tinytext DEFAULT NULL,
  `uname` tinytext DEFAULT NULL,
  `email` tinytext DEFAULT NULL,
  `pword` longtext DEFAULT NULL,
  `phone` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `uname`, `email`, `pword`, `phone`) VALUES
(1, 'test', 'name', 'test', 'test@testmail.com', '$2y$10$AFhy60wWVyowSFpqFamCbuyKCAvGwT/TrCbBX0V6lHWjAsLrPpknG', ''),
(2, 'arsene', 'wenger', 'wenger', 'wenger@arsenal.com', '$2y$10$weAEn8UY.dxGAyP5DCmUiOijFCoxPg8acTc7vtMnJfhfOAinbf6/O', '900900'),
(3, 'elon', 'musk', 'spaceman', 'elon@tesla.com', '$2y$10$Im/YaU/XG8BCAXUQbqUCLOSvWQiAwdqly3/2ul20633fPNsHxB/GK', '1-RICH'),
(4, 'demo', 'one', 'demo', 'demo@demo.com', '$2y$10$DPkrpx1w3TOkVmqpV8nFreFvfc7.LgldNv6f/MNm6ve0S1Tsx37Ke', '900900'),
(5, 'SNEHA', 'H', 'hsneha', 'sneha.hessa@yahoo.com', '$2y$10$BQ4WdXthXmYRyaRZ.iu0heZVmS32TnGq0N.KiAtYmOKgn3Yrl.xZq', '9167328474');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flightbookings`
--
ALTER TABLE `flightbookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flightseats`
--
ALTER TABLE `flightseats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotelbookings`
--
ALTER TABLE `hotelbookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotelrooms`
--
ALTER TABLE `hotelrooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `flightbookings`
--
ALTER TABLE `flightbookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `flightseats`
--
ALTER TABLE `flightseats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `hotelbookings`
--
ALTER TABLE `hotelbookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `hotelrooms`
--
ALTER TABLE `hotelrooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
