-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 16, 2019 at 11:06 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `AutoDirect`
--

-- --------------------------------------------------------

--
-- Table structure for table `CAR`
--

CREATE TABLE `CAR` (
  `car_id` varchar(20) NOT NULL,
  `year` int(11) NOT NULL,
  `make` varchar(20) NOT NULL,
  `model` varchar(40) NOT NULL,
  `engine` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `CLIENT`
--

CREATE TABLE `CLIENT` (
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `First_name` varchar(20) NOT NULL,
  `Last_name` varchar(20) NOT NULL,
  `address` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `EMPLOYEE`
--

CREATE TABLE `EMPLOYEE` (
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `postion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `HAS_PARTS`
--

CREATE TABLE `HAS_PARTS` (
  `category` varchar(30) NOT NULL,
  `cr_id` varchar(20) NOT NULL,
  `pt_num` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `MANAGES`
--

CREATE TABLE `MANAGES` (
  `od_num` varchar(40) NOT NULL,
  `e_username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ORDERS`
--

CREATE TABLE `ORDERS` (
  `order_number` varchar(40) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cusername` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `PART`
--

CREATE TABLE `PART` (
  `part_number` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `num_stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `PARTS_PURCHASED`
--

CREATE TABLE `PARTS_PURCHASED` (
  `od_number` varchar(40) NOT NULL,
  `pt_nm` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE `USERS` (
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `type_usr` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CAR`
--
ALTER TABLE `CAR`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `CLIENT`
--
ALTER TABLE `CLIENT`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `EMPLOYEE`
--
ALTER TABLE `EMPLOYEE`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `HAS_PARTS`
--
ALTER TABLE `HAS_PARTS`
  ADD KEY `cr_id` (`cr_id`),
  ADD KEY `pt_num` (`pt_num`);

--
-- Indexes for table `MANAGES`
--
ALTER TABLE `MANAGES`
  ADD KEY `od_num` (`od_num`),
  ADD KEY `e_username` (`e_username`);

--
-- Indexes for table `ORDERS`
--
ALTER TABLE `ORDERS`
  ADD PRIMARY KEY (`order_number`),
  ADD KEY `cusername` (`cusername`);

--
-- Indexes for table `PART`
--
ALTER TABLE `PART`
  ADD PRIMARY KEY (`part_number`);

--
-- Indexes for table `PARTS_PURCHASED`
--
ALTER TABLE `PARTS_PURCHASED`
  ADD KEY `od_number` (`od_number`),
  ADD KEY `pt_nm` (`pt_nm`);

--
-- Indexes for table `USERS`
--
ALTER TABLE `USERS`
  ADD PRIMARY KEY (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `HAS_PARTS`
--
ALTER TABLE `HAS_PARTS`
  ADD CONSTRAINT `HAS_PARTS_ibfk_1` FOREIGN KEY (`cr_id`) REFERENCES `CAR` (`car_id`),
  ADD CONSTRAINT `HAS_PARTS_ibfk_2` FOREIGN KEY (`pt_num`) REFERENCES `PART` (`part_number`);

--
-- Constraints for table `MANAGES`
--
ALTER TABLE `MANAGES`
  ADD CONSTRAINT `MANAGES_ibfk_1` FOREIGN KEY (`od_num`) REFERENCES `ORDERS` (`order_number`),
  ADD CONSTRAINT `MANAGES_ibfk_2` FOREIGN KEY (`e_username`) REFERENCES `EMPLOYEE` (`username`);

--
-- Constraints for table `ORDERS`
--
ALTER TABLE `ORDERS`
  ADD CONSTRAINT `ORDERS_ibfk_1` FOREIGN KEY (`cusername`) REFERENCES `CLIENT` (`username`);

--
-- Constraints for table `PARTS_PURCHASED`
--
ALTER TABLE `PARTS_PURCHASED`
  ADD CONSTRAINT `PARTS_PURCHASED_ibfk_1` FOREIGN KEY (`od_number`) REFERENCES `ORDERS` (`order_number`),
  ADD CONSTRAINT `PARTS_PURCHASED_ibfk_2` FOREIGN KEY (`pt_nm`) REFERENCES `PART` (`part_number`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
