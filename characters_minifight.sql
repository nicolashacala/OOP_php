-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 23, 2018 at 03:22 PM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.25-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `characters_minifight`
--

CREATE TABLE `characters_minifight` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `damage` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '1',
  `expCap` int(11) NOT NULL DEFAULT '100',
  `timeAsleep` int(10) NOT NULL DEFAULT '0',
  `type` enum('wizard','warrior') NOT NULL,
  `skill` tinyint(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `characters_minifight`
--

INSERT INTO `characters_minifight` (`id`, `name`, `damage`, `experience`, `level`, `expCap`, `timeAsleep`, `type`, `skill`) VALUES
(3, 'kobal3', 70, 20, 4, 140, 0, 'wizard', 0),
(4, 'peepee', 50, 0, 1, 100, 0, 'wizard', 0),
(6, 'paapaa', 60, 0, 1, 100, 0, 'wizard', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `characters_minifight`
--
ALTER TABLE `characters_minifight`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `characters_minifight`
--
ALTER TABLE `characters_minifight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
