-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 16, 2017 at 10:33 PM
-- Server version: 5.5.57-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `coding`
--

-- --------------------------------------------------------

--
-- Table structure for table `Teams`
--

CREATE TABLE IF NOT EXISTS `Teams` (
  `TeamNo` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `language` varchar(10) NOT NULL,
  `password` varchar(256) NOT NULL,
  PRIMARY KEY (`TeamNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `Teams`
--

INSERT INTO `Teams` (`TeamNo`, `name`, `language`, `password`) VALUES
(9, 'anshul', 'C', '240bc306d1a19916d636f3d614e03024');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
