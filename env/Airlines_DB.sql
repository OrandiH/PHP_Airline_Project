-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 25, 2018 at 05:37 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Airlines_DB`
--
CREATE DATABASE IF NOT EXISTS `Airlines_DB` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `Airlines_DB`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `age` int(11) NOT NULL
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

CREATE TABLE `booked_flights` (
  `BookingID` int(11) NOT NULL,
  `flightID` varchar(30) DEFAULT NULL,
  `userName` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `userName` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `mailAddress` varchar(100) NOT NULL,
  `credit_card_Num` varchar(150) NOT NULL,
  `profile_pic` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_login`
--

CREATE TABLE `customer_login` (
  `userName` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment`
--

CREATE TABLE `customer_payment` (
  `userName` varchar(50) NOT NULL,
  `confirmationNum` int(11) NOT NULL,
  `amount_received` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `flightID` varchar(30) NOT NULL,
  `flightName` varchar(30) NOT NULL,
  `depatureCity` varchar(30) NOT NULL,
  `destinationCity` varchar(30) NOT NULL,
  `depatureDate` date NOT NULL,
  `returnDate` date NOT NULL,
  `AmountOfSeats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flightID`, `flightName`, `depatureCity`, `destinationCity`, `depatureDate`, `returnDate`, `AmountOfSeats`) VALUES
('FLG1001', 'DZ9081', 'Kingston', 'Miami', '2018-04-10', '2018-04-22', 2),
('FLG1002', 'BH2341', 'Montego Bay', 'New York', '2018-05-02', '0000-00-00', 9),
('FLG1003', 'DR2192', 'Kingston', 'Detroit', '2018-04-30', '2018-04-10', 10),
('FLG1004', 'DM8728', 'Montego Bay', 'California', '2018-05-03', '0000-00-00', 7),
('FLG1005', 'JN4128', 'Kingston', 'Atlanta', '2018-04-29', '0000-00-00', 6),
('FLG1006', 'AS4618', 'Kingston', 'Miami', '2018-04-30', '2018-05-02', 5),
('FLG1007', 'AD5728', 'California', 'Paris', '2018-05-04', '2018-05-20', 7),
('FLG1008', 'HJ8902', 'Miami', 'Toronto', '2018-05-01', '0000-00-00', 9),
('FLG1009', 'JK8347', 'New York', 'London', '2018-05-03', '2018-05-16', 9),
('FLG1010', 'LP4562', 'Miami', 'Kingston', '2018-05-06', '0000-00-00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `flight_cost`
--

CREATE TABLE `flight_cost` (
  `flightID` varchar(30) NOT NULL,
  `cost` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flight_cost`
--

INSERT INTO `flight_cost` (`flightID`, `cost`) VALUES
('FLG1001', 400),
('FLG1002', 300),
('FLG1003', 450),
('FLG1004', 315.23),
('FLG1005', 219.27),
('FLG1006', 321),
('FLG1007', 250),
('FLG1008', 300),
('FLG1009', 270),
('FLG1010', 400);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `booked_flights`
--
ALTER TABLE `booked_flights`
  ADD PRIMARY KEY (`BookingID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`userName`);

--
-- Indexes for table `customer_login`
--
ALTER TABLE `customer_login`
  ADD PRIMARY KEY (`userName`);

--
-- Indexes for table `customer_payment`
--
ALTER TABLE `customer_payment`
  ADD PRIMARY KEY (`userName`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`flightID`);

--
-- Indexes for table `flight_cost`
--
ALTER TABLE `flight_cost`
  ADD PRIMARY KEY (`flightID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booked_flights`
--
ALTER TABLE `booked_flights`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_login`
--
ALTER TABLE `customer_login`
  ADD CONSTRAINT `FK_Username` FOREIGN KEY (`userName`) REFERENCES `customer` (`userName`);

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
