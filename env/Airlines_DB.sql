-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 16, 2018 at 04:06 AM
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
-- Table structure for table `Booked_Flights`
--

CREATE TABLE `Booked_Flights` (
  `BookingID` int(11) NOT NULL,
  `flightID` int(30) NOT NULL,
  `userName` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
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
-- Table structure for table `Customer_Login`
--

CREATE TABLE `Customer_Login` (
  `userName` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Customer_Payment`
--

CREATE TABLE `Customer_Payment` (
  `userName` varchar(50) NOT NULL,
  `confirmationNum` int(11) NOT NULL,
  `amount_received` decimal(10, 2) NOT NULL -- specify 2 decimal points
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Flight`
--

CREATE TABLE `Flight` (
  `flightID` varchar(30) NOT NULL,
  `flightName` varchar(30) NOT NULL, -- add flight name
  `depatureCity` varchar(30) NOT NULL,
  `destinationCity` varchar(30) NOT NULL,
  `depatureDate` date NOT NULL,
  `returnDate` date NOT NULL,
  `AmountOfSeats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Flight_Cost`
--

CREATE TABLE `Flight_Cost` (
  `flightID` varchar(30) NOT NULL,
  `cost` decimal(10, 2) NOT NULL specify 2 decimal points
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Booked_Flights`
--
ALTER TABLE `Booked_Flights`
  ADD PRIMARY KEY (`BookingID`);

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`userName`);

--
-- Indexes for table `Customer_Login`
--
ALTER TABLE `Customer_Login`
  ADD PRIMARY KEY (`userName`);

--
-- Indexes for table `Customer_Payment`
--
ALTER TABLE `Customer_Payment`
  ADD PRIMARY KEY (`userName`);

--
-- Indexes for table `Flight`
--
ALTER TABLE `Flight`
  ADD PRIMARY KEY (`flightID`);

--
-- Indexes for table `Flight_Cost`
--
ALTER TABLE `Flight_Cost`
  ADD PRIMARY KEY (`flightID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Booked_Flights`
--
ALTER TABLE `Booked_Flights`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Customer_Login`
--
ALTER TABLE `Customer_Login`
  ADD CONSTRAINT `FK_Username` FOREIGN KEY (`userName`) REFERENCES `Customer` (`userName`);

--
-- Constraints for table `Customer_Payment`
--
ALTER TABLE `Customer_Payment`
  ADD CONSTRAINT `FK_Username_Payment` FOREIGN KEY (`userName`) REFERENCES `Customer` (`userName`);

--
-- Constraints for table `Flight_Cost`
--
ALTER TABLE `Flight_Cost`
  ADD CONSTRAINT `FK_FlightID_Cost` FOREIGN KEY (`flightID`) REFERENCES `Flight` (`flightID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
