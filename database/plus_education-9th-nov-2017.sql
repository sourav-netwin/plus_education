-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2017 at 08:53 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plus_education`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_language`
--

DROP TABLE IF EXISTS `tbl_language`;
CREATE TABLE IF NOT EXISTS `tbl_language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `language_name` varchar(100) DEFAULT NULL,
  `short_name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_language`
--

INSERT INTO `tbl_language` (`language_id`, `language_name`, `short_name`) VALUES
(1, 'English', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_program`
--

DROP TABLE IF EXISTS `tbl_program`;
CREATE TABLE IF NOT EXISTS `tbl_program` (
  `program_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `program_image` varchar(100) DEFAULT NULL,
  `program_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active , 0:inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not deleted and 1 = deleted',
  PRIMARY KEY (`program_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_program`
--

INSERT INTO `tbl_program` (`program_id`, `program_image`, `program_status`, `delete_flag`) VALUES
(1, '1510112536.jpg', 1, 0),
(2, '1510112605.jpg', 1, 0),
(3, '1510112708.jpg', 1, 0),
(4, '1510112755.jpg', 1, 0),
(5, '1510112799.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_program_language`
--

DROP TABLE IF EXISTS `tbl_program_language`;
CREATE TABLE IF NOT EXISTS `tbl_program_language` (
  `program_language_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `language_id` int(11) DEFAULT NULL,
  `program_title` varchar(100) DEFAULT NULL,
  `program_short_description` varchar(200) DEFAULT NULL,
  `program_description` text,
  `program_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`program_language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_program_language`
--

INSERT INTO `tbl_program_language` (`program_language_id`, `language_id`, `program_title`, `program_short_description`, `program_description`, `program_id`) VALUES
(1, 1, 'JUNIOR USA SUMMER COURSE', 'Giving valuable reputation and credibility to your business', 'Giving valuable reputation and credibility to your business', 1),
(2, 1, 'JUNIOR EUROPE SUMMER COURSE', 'Readable code, well documented and FREE support', 'Readable code, well documented and FREE support', 2),
(3, 1, 'JUNIOR ALL YEAR ROUND IN USA', 'Readable code, well documented and FREE support', 'Readable code, well documented and FREE support', 3),
(4, 1, 'JUNIOR ALL YEAR ROUND', 'Leave it to the theme, it knows how to deal with screen sizes', 'Leave it to the theme, it knows how to deal with screen sizes', 4),
(5, 1, 'ENGLISH STARS', 'Readable code, well documented and FREE support', 'Readable code, well documented and FREE support', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `userName` varchar(100) DEFAULT NULL,
  `userEmail` varchar(50) DEFAULT NULL,
  `userId` varchar(50) DEFAULT NULL,
  `userPassword` varchar(100) DEFAULT NULL,
  `userImage` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`users_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`users_id`, `userName`, `userEmail`, `userId`, `userPassword`, `userImage`) VALUES
(1, 'Stefano Marra', 'smarra@plus-ed.com', 'stefano', '317a58affea472972b63bffdd3392ae0', '1509945920.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
