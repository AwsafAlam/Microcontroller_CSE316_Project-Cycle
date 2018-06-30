-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 30, 2018 at 08:48 PM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Cycle`
--

-- --------------------------------------------------------

--
-- Table structure for table `Bicycle`
--

CREATE TABLE `Bicycle` (
  `bicycle_id` int(11) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `imei` varchar(11) NOT NULL,
  `ride_count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Bicycle`
--

INSERT INTO `Bicycle` (`bicycle_id`, `phone_number`, `imei`, `ride_count`) VALUES
(3, 198324839, 'kkkkbfs', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Ride`
--

CREATE TABLE `Ride` (
  `ride_id` int(11) NOT NULL,
  `bicycle_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `source_lat` int(11) NOT NULL,
  `source_lng` int(11) NOT NULL,
  `dst_lat` double NOT NULL,
  `dst_lng` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Ride_Location`
--

CREATE TABLE `Ride_Location` (
  `ride_id` int(11) NOT NULL,
  `latitude` int(11) NOT NULL,
  `longitude` int(11) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `user_id` int(11) NOT NULL,
  `username` int(11) NOT NULL,
  `email` int(11) NOT NULL,
  `phone` int(11) NOT NULL,
  `ride_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Bicycle`
--
ALTER TABLE `Bicycle`
  ADD PRIMARY KEY (`bicycle_id`);

--
-- Indexes for table `Ride`
--
ALTER TABLE `Ride`
  ADD PRIMARY KEY (`ride_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Bicycle`
--
ALTER TABLE `Bicycle`
  MODIFY `bicycle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Ride`
--
ALTER TABLE `Ride`
  MODIFY `ride_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
