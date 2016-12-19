-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2016 at 10:40 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `budget_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `profile_ID` smallint(6) NOT NULL,
  `home` float NOT NULL DEFAULT '0',
  `rent` float NOT NULL DEFAULT '0',
  `car` float NOT NULL DEFAULT '0',
  `fuel` float NOT NULL DEFAULT '0',
  `phone` float NOT NULL DEFAULT '0',
  `utilities` float NOT NULL DEFAULT '0',
  `insurance` float NOT NULL DEFAULT '0',
  `entertainment` float NOT NULL DEFAULT '0',
  `giving` float NOT NULL DEFAULT '0',
  `other` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `finance_info`
--

CREATE TABLE `finance_info` (
  `profile_ID` smallint(6) NOT NULL,
  `income` float NOT NULL DEFAULT '0',
  `amount_saved` float NOT NULL DEFAULT '0',
  `goal` float NOT NULL DEFAULT '0',
  `months_to_goal` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `profile_ID` smallint(6) NOT NULL,
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `password_md5` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`profile_ID`);

--
-- Indexes for table `finance_info`
--
ALTER TABLE `finance_info`
  ADD PRIMARY KEY (`profile_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`profile_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `profile_ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
