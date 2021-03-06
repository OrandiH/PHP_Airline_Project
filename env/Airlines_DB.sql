-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 17, 2018 at 10:05 PM
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
('admin@gmail.com', 'ae2b1fca515949e5d54fb22b8ed95575', 'admin', 'user', 23);

-- --------------------------------------------------------

--
-- Table structure for table `booked_flights`
--

CREATE TABLE `booked_flights` (
  `BookingID` int(11) NOT NULL,
  `flightID` varchar(30) DEFAULT NULL,
  `userName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booked_flights`
--

INSERT INTO `booked_flights` (`BookingID`, `flightID`, `userName`) VALUES
(29, 'FLG1010', 'idnarosirrah@gmail.com'),
(30, 'FLG1010', 'idnarosirrah@gmail.com'),
(31, 'FLG1010', 'idnarosirrah@gmail.com'),
(32, 'FLG1010', 'idnarosirrah@gmail.com'),
(33, 'FLG1010', 'idnarosirrah@gmail.com'),
(34, 'FLG1010', 'idnarosirrah@gmail.com'),
(35, 'FLG1010', 'idnarosirrah@gmail.com'),
(36, 'FLG1010', 'idnarosirrah@gmail.com'),
(37, 'FLG1010', 'idnarosirrah@gmail.com');

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
('Lharris@gmail.com', 'Liz', 'Brown', 23, '61 Lakeland Drive,Greendale', '6e73a1d9fd95715c927c26822445d8d1', 'f30aa7a662c728b7407c54ae6bfd27d1'),
('idnarosirrah@gmail.com', 'Orandi', 'Harris', 23, '50 Highland Pike Road, 3', '787d941078d5f393ebf68b6026a139a7', 'f30aa7a662c728b7407c54ae6bfd27d1'),
('wwhite@gmail.com', 'Walter', 'White', 26, '237 Old Hope Road,Kingston', 'fc4567a7c609b4e6e264e97079386963', 'bf548c326c232ee4906c5e84f9dd5808');

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment`
--

CREATE TABLE `customer_payment` (
  `userName` varchar(50) NOT NULL,
  `confirmationNum` int(11) NOT NULL,
  `amount_received` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_payment`
--

INSERT INTO `customer_payment` (`userName`, `confirmationNum`, `amount_received`) VALUES
('idnarosirrah@gmail.com', 2147483647, 320),
('idnarosirrah@gmail.com', 2147483647, 320),
('idnarosirrah@gmail.com', 2147483647, 320),
('idnarosirrah@gmail.com', 2147483647, 320),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 240),
('idnarosirrah@gmail.com', 2147483647, 240),
('idnarosirrah@gmail.com', 2147483647, 240),
('idnarosirrah@gmail.com', 2147483647, 240),
('idnarosirrah@gmail.com', 2147483647, 240),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 1556464089, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 736635769, 200),
('idnarosirrah@gmail.com', 1554224431, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 1700620852, 200),
('idnarosirrah@gmail.com', 181297328, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200),
('idnarosirrah@gmail.com', 2147483647, 200);

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
  `AmountOfSeats` int(11) NOT NULL,
  `Cost` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flightID`, `flightName`, `airlineName`, `depatureCity`, `destinationCity`, `depatureDate`, `returnDate`, `AmountOfSeats`, `Cost`) VALUES
('FLG1001', 'DZ9081', 'JetBlue', 'Kingston', 'Miami', '2018-04-10', '2018-04-22', 2, 400),
('FLG1002', 'BH2341', 'American Airlines', 'Montego Bay', 'New York', '2018-05-02', '0000-00-00', 9, 500),
('FLG1003', 'DR2192', 'Delta', 'Kingston', 'Detroit', '2018-04-30', '2018-04-10', 10, 350.45),
('FLG1004', 'DM8728', 'Spirit', 'Montego Bay', 'California', '2018-05-03', '0000-00-00', 7, 600),
('FLG1005', 'JN4128', 'Delta', 'Kingston', 'Atlanta', '2018-04-29', '0000-00-00', 6, 450.6),
('FLG1006', 'AS4618', 'American Airlines', 'Kingston', 'Miami', '2018-04-30', '2018-05-02', 5, 340.2),
('FLG1007', 'AD5728', 'JetBlue', 'California', 'Paris', '2018-05-04', '2018-05-20', 7, 800.5),
('FLG1008', 'HJ8902', 'Spirit', 'Miami', 'Toronto', '2018-05-01', '0000-00-00', 9, 200),
('FLG1009', 'JK8347', 'American Airlines', 'New York', 'London', '2018-05-03', '2018-05-16', 9, 300),
('FLG1010', 'LP4562', 'Delta', 'Miami', 'Kingston', '2018-05-06', '0000-00-00', 7, 250);

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
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
