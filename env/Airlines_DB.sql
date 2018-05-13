-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 12, 2018 at 11:58 PM
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

-- --------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `Airlines_DB` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `Airlines_DB`;
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
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`userName`, `firstName`, `lastName`, `age`, `mailAddress`, `credit_card_Num`, `password`) VALUES
('idnarosirrah@gmail.com', 'Orandi', 'Harris', 23, '50 Highland Pike Road, 3', '787d941078d5f393ebf68b6026a139a7', '$2y$10$FySScbc71fpAlIzQ2f47J.lDhb0YaNp9xBe25.q4pWlKjSoj.oPDy'),
('jbrown@gmail.com', 'John', 'Brown', 24, '237 Old Hope Road,Kingston', 'fc4567a7c609b4e6e264e97079386963', '$2y$10$8qCJvZzM048wAC5Hh28.1.M1ZNLqAxd6T0Byu87Wkmu28qLUmhrVm'),
('sueJames@hotmail.com', 'Susan', 'James', 32, '62 Lakeland Drive,Greendale', 'a1173cc1f3125ba4eba451e71a363257', '$2y$10$ZXMgSVz.CmMNZEAlAyup4ewbukZNwIS8HtanQOS9R36iu93Y/RdYW'),
('wsmith@gmail.com', 'Will', 'Smith', 22, '94 Old Hope Road,Kingston', '9b8a421bff5f30d20f118185eb6e4523', '$2y$10$gJPcVacAdi6s7Yn8Y4QuWOKLGp375.UsVu9k3MvaACHcRxIJbC3BG'),
('tbrown@hotmail.com', 'Tanya', 'Brown', 32, '240 Old Hope Road,Kingston', '6e73a1d9fd95715c927c26822445d8d1', '$2y$10$.zk4Ckk3rpUpUrqFqKMwZ.NwMcbhAwhgnGyfdqKFWTFtpH2GKN2nu');

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
  `airlineName` varchar(60) NOT NULL,
  `depatureCity` varchar(30) NOT NULL,
  `destinationCity` varchar(30) NOT NULL,
  `depatureDate` date NOT NULL,
  `returnDate` date NOT NULL,
  `AmountOfSeats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flightID`, `flightName`, `airlineName`, `depatureCity`, `destinationCity`, `depatureDate`, `returnDate`, `AmountOfSeats`) VALUES
('FLG1001', 'DZ9081', 'JetBlue', 'Kingston', 'Miami', '2018-04-10', '2018-04-22', 2),
('FLG1002', 'BH2341', 'American Airlines', 'Montego Bay', 'New York', '2018-05-02', '0000-00-00', 9),
('FLG1003', 'DR2192', 'Delta', 'Kingston', 'Detroit', '2018-04-30', '2018-04-10', 10),
('FLG1004', 'DM8728', 'Spirit', 'Montego Bay', 'California', '2018-05-03', '0000-00-00', 7),
('FLG1005', 'JN4128', 'Delta', 'Kingston', 'Atlanta', '2018-04-29', '0000-00-00', 6),
('FLG1006', 'AS4618', 'American Airlines', 'Kingston', 'Miami', '2018-04-30', '2018-05-02', 5),
('FLG1007', 'AD5728', 'JetBlue', 'California', 'Paris', '2018-05-04', '2018-05-20', 7),
('FLG1008', 'HJ8902', 'Spirit', 'Miami', 'Toronto', '2018-05-01', '0000-00-00', 9),
('FLG1009', 'JK8347', 'American Airlines', 'New York', 'London', '2018-05-03', '2018-05-16', 9),
('FLG1010', 'LP4562', 'Delta', 'Miami', 'Kingston', '2018-05-06', '0000-00-00', 7);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booked_flights`
--
ALTER TABLE `booked_flights`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
