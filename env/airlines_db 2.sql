-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 09, 2018 at 12:17 AM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `airlines_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `firstname`, `lastname`, `age`) VALUES
('web@gmail.com', '$2y$10$xWeicZFfBBXUu/NqC/5CkuDQs0DOCO/zKCOHKLx/2ClaLLmga9EFC', 'web', 'class', 25);

-- --------------------------------------------------------

--
-- Table structure for table `booked_flights`
--

DROP TABLE IF EXISTS `booked_flights`;
CREATE TABLE IF NOT EXISTS `booked_flights` (
  `BookingID` int(11) NOT NULL AUTO_INCREMENT,
  `flightID` varchar(30) DEFAULT NULL,
  `userName` varchar(50) NOT NULL,
  PRIMARY KEY (`BookingID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booked_flights`
--

INSERT INTO `booked_flights` (`BookingID`, `flightID`, `userName`) VALUES
(1, 'DL41', 'pb@gmail.com'),
(2, 'DL41', 'pb@gmail.com'),
(3, 'DL41', 'pb@gmail.com'),
(4, 'BW 6061', 'pb@gmail.com'),
(5, 'BW6565', 'pb@gmail.com'),
(6, 'DL40', 'pb@gmail.com'),
(7, 'DL40', 'pb@gmail.com'),
(8, 'DL40', 'pb@gmail.com'),
(9, 'DL40', 'pb@gmail.com'),
(10, 'DL40', 'pb@gmail.com'),
(11, 'DL40', 'pb@gmail.com'),
(12, 'DL40', 'pb@gmail.com'),
(13, 'DL40', 'pb@gmail.com'),
(14, 'DL40', 'pb@gmail.com'),
(15, 'DL40', 'pb@gmail.com'),
(16, 'DL40', 'pb@gmail.com'),
(17, 'DL40', 'pb@gmail.com'),
(18, 'DL40', 'pb@gmail.com'),
(19, 'DL40', 'pb@gmail.com'),
(20, 'DL40', 'pb@gmail.com'),
(21, 'DL40', 'pb@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `userName` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `mailAddress` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `credit_card_Num` varchar(150) NOT NULL,
  `profile_pic` varchar(150) NOT NULL,
  PRIMARY KEY (`userName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`userName`, `firstName`, `lastName`, `age`, `mailAddress`, `password`, `credit_card_Num`, `profile_pic`) VALUES
('pb@gmail.com', 'Perry', 'Blazed', 19, '47 Saint Ave', 'pass1', '1001016677', '');

-- --------------------------------------------------------

--
-- Table structure for table `customer_login`
--

DROP TABLE IF EXISTS `customer_login`;
CREATE TABLE IF NOT EXISTS `customer_login` (
  `userName` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  PRIMARY KEY (`userName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment`
--

DROP TABLE IF EXISTS `customer_payment`;
CREATE TABLE IF NOT EXISTS `customer_payment` (
  `userName` varchar(50) NOT NULL,
  `confirmationNum` int(11) NOT NULL,
  `amount_received` float NOT NULL,
  PRIMARY KEY (`userName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_payment`
--

INSERT INTO `customer_payment` (`userName`, `confirmationNum`, `amount_received`) VALUES
('pb@gmail.com', 304326803, 320);

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

DROP TABLE IF EXISTS `flight`;
CREATE TABLE IF NOT EXISTS `flight` (
  `flightID` varchar(30) NOT NULL,
  `flightName` varchar(30) NOT NULL,
  `depatureCity` varchar(30) NOT NULL,
  `destinationCity` varchar(30) NOT NULL,
  `depatureDate` date NOT NULL,
  `returnDate` date NOT NULL,
  `AmountOfSeats` int(11) NOT NULL,
  PRIMARY KEY (`flightID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flightID`, `flightName`, `depatureCity`, `destinationCity`, `depatureDate`, `returnDate`, `AmountOfSeats`) VALUES
('AA2473', 'American Airline', 'JA', 'LA', '2018-04-25', '2018-04-25', 8),
('AA4583', 'American Airline', 'JFK', 'BUF', '2018-05-16', '2018-05-29', 9),
('AA5609', 'American Airline', 'JA', 'LA', '2018-05-16', '2018-05-29', 6),
('AA6060', 'American Airline', 'JA', 'LA', '2018-05-25', '2018-05-25', 280),
('BW 6061', 'Caribbean Airline', 'JA', 'LA', '2018-05-25', '2018-05-25', 250),
('BW1010', 'Caribbean Airline', 'JA', 'LA', '2018-05-25', '2018-05-25', 15),
('BW4545', 'Caribbean Airline', 'JA', 'LA', '2018-04-25', '2018-05-16', 11),
('BW6565', 'Caribbean Airline', 'JA', 'LA', '2018-05-25', '2018-05-25', 150),
('DL40', 'Delta Airline', 'JA', 'LA', '2018-05-25', '2018-05-25', 240),
('DL41', 'Delta Airline', 'JA', 'LA', '2018-05-25', '2018-05-25', 180),
('J4 1071', 'Jet Blue', 'JFK', 'BUF', '2018-05-16', '2018-05-29', 150),
('J5 1071', 'Jet Blue', 'JFK', 'BUF', '2018-05-16', '2018-05-29', 200),
('J6 3623', 'Jet Blue', 'JFK', 'BUF', '2018-05-16', '2018-04-29', 10);

-- --------------------------------------------------------

--
-- Table structure for table `flight_cost`
--

DROP TABLE IF EXISTS `flight_cost`;
CREATE TABLE IF NOT EXISTS `flight_cost` (
  `flightID` varchar(30) NOT NULL,
  `cost` float NOT NULL,
  PRIMARY KEY (`flightID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flight_cost`
--

INSERT INTO `flight_cost` (`flightID`, `cost`) VALUES
('AA2473', 800),
('AA4583', 450),
('AA5609', 680),
('AA6060', 450),
('BW 6061', 400),
('BW1010', 890),
('BW4545', 740),
('BW6565', 800),
('DL40', 730),
('DL41', 580),
('J4 1071', 440),
('J5 1071', 670),
('J6 3623', 950);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_payment`
--
ALTER TABLE `customer_payment`
  ADD CONSTRAINT `FK_Username_Payment` FOREIGN KEY (`userName`) REFERENCES `customer` (`userName`);

--
-- Constraints for table `flight_cost`
--
ALTER TABLE `flight_cost`
  ADD CONSTRAINT `FK_FlightID_Cost` FOREIGN KEY (`flightID`) REFERENCES `flight` (`flightID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
