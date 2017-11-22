-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 07, 2017 at 02:38 AM
-- Server version: 5.5.58-0ubuntu0.14.04.1
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
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `sno` int(4) NOT NULL AUTO_INCREMENT,
  `quesNo` int(4) NOT NULL,
  `answer` tinyint(1) NOT NULL,
  PRIMARY KEY (`quesNo`),
  KEY `sno` (`sno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`sno`, `quesNo`, `answer`) VALUES
(1, 1, 2),
(2, 2, 1),
(3, 3, 3),
(4, 4, 1),
(5, 5, 1),
(6, 6, 2),
(7, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mcqs`
--

CREATE TABLE IF NOT EXISTS `mcqs` (
  `quesNo` int(4) NOT NULL AUTO_INCREMENT,
  `question` varchar(2000) NOT NULL,
  PRIMARY KEY (`quesNo`),
  KEY `quesNo` (`quesNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `mcqs`
--

INSERT INTO `mcqs` (`quesNo`, `question`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(2, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(3, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(4, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(5, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(6, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(7, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum. \r\n\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `Members`
--

CREATE TABLE IF NOT EXISTS `Members` (
  `sno` int(4) NOT NULL AUTO_INCREMENT,
  `team_no` int(3) NOT NULL,
  `name1` varchar(200) NOT NULL,
  `id1` int(6) NOT NULL,
  `branch1` varchar(30) NOT NULL,
  `mail1` varchar(200) NOT NULL,
  `name2` varchar(200) NOT NULL,
  `id2` int(6) NOT NULL,
  `branch2` varchar(30) NOT NULL,
  `mail2` varchar(200) NOT NULL,
  PRIMARY KEY (`sno`),
  KEY `team_no` (`team_no`),
  KEY `team_no_2` (`team_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `Members`
--

INSERT INTO `Members` (`sno`, `team_no`, `name1`, `id1`, `branch1`, `mail1`, `name2`, `id2`, `branch2`, `mail2`) VALUES
(7, 9, 'ans', 46821, 'csw', 'asd@ad.cpm', 'hul', 46601, 'ad', 'adsd@dsc.com');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `sno` int(4) NOT NULL AUTO_INCREMENT,
  `quesNo` int(4) NOT NULL,
  `option1` varchar(500) NOT NULL,
  `option2` varchar(500) NOT NULL,
  `option3` varchar(500) NOT NULL,
  `option4` varchar(500) NOT NULL,
  PRIMARY KEY (`sno`),
  UNIQUE KEY `sno` (`sno`),
  KEY `quesNo` (`quesNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`sno`, `quesNo`, `option1`, `option2`, `option3`, `option4`) VALUES
(7, 1, 'Cannot change window; will lead to immediate disqualification.', 'Recheck all questions before submitting', 'Cannot change window; will lead to immediate disqualification.', 'Recheck all questions before submitting'),
(8, 2, 'Recheck all questions before submitting', 'Cannot change window; will lead to immediate disqualification.', 'Recheck all questions before submitting', 'Cannot change window; will lead to immediate disqualification.'),
(9, 3, 'Cannot change window; will lead to immediate disqualification.', 'Recheck all questions before submitting.', 'Recheck all questions before submitting.', 'Cannot change window; will lead to immediate disqualification.'),
(10, 4, 'Recheck all questions before submitting.', 'Cannot change window; will lead to immediate disqualification', 'Recheck all questions before submitting.', 'Cannot change window; will lead to immediate disqualification'),
(11, 5, 'Cannot change window; will lead to immediate disqualification', 'Cannot change window; will lead to immediate disqualification', 'Cannot change window; will lead to immediate disqualification', 'Cannot change window; will lead to immediate disqualification'),
(12, 6, 'Recheck all questions before submitting', 'Recheck all questions before submitting', 'Recheck all questions before submitting', 'Recheck all questions before submitting'),
(13, 7, 'asdads', 'sdafv', 'acqdasqwwad', 'cxzcac');

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

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`quesNo`) REFERENCES `mcqs` (`quesNo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Members`
--
ALTER TABLE `Members`
  ADD CONSTRAINT `Members_ibfk_1` FOREIGN KEY (`team_no`) REFERENCES `Teams` (`TeamNo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`quesNo`) REFERENCES `mcqs` (`quesNo`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
