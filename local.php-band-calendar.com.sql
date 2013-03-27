-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 27, 2013 at 01:22 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `local.php-band-calendar.com`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `time` int(22) NOT NULL,
  `timeAdded` int(22) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `address` varchar(300) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `managerId` int(11) NOT NULL,
  `managerIP` varchar(46) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `name`, `time`, `timeAdded`, `description`, `address`, `lat`, `lng`, `managerId`, `managerIP`) VALUES
(1, 'title2', NULL, 1363606980, 1363585380, 'd', 'Nashvile, TN', 36.166667, -86.783333, 1, '127.0.0.1'),
(2, 'title1', NULL, 1585284902, 1364328282, 'a description', 'Nashvile, TN', 36.166667, -86.783333, 1, '127.0.0.1'),
(3, 'title2', NULL, 1485284902, 1364329170, 'a description', 'Nashvile, TN', 36.166667, -86.783333, 1, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE IF NOT EXISTS `managers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`id`, `username`, `password`) VALUES
(1, 'admin', 'dab6J8ZolRqQ.%AqZ38aK9a#');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
