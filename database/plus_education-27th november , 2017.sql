-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2017 at 05:20 AM
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
-- Table structure for table `tbl_centre_master`
--

DROP TABLE IF EXISTS `tbl_centre_master`;
CREATE TABLE IF NOT EXISTS `tbl_centre_master` (
  `centre_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `centre_name` varchar(100) DEFAULT NULL,
  `centre_image` varchar(200) DEFAULT NULL,
  `region_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`centre_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_centre_master`
--

INSERT INTO `tbl_centre_master` (`centre_id`, `centre_name`, `centre_image`, `region_id`) VALUES
(1, 'BRIGHTON', 'brighton.jpg', 1),
(2, 'CANTERBURY', 'canterbury.jpg', 1),
(3, 'CHELMSFORD', 'chelmsford.jpg', 1),
(4, 'CHESTER', 'chester.jpg', 1),
(5, 'EDINBURGH', 'edinburgh.jpg', 1),
(6, 'EFFINGHAM', 'effingham.jpg', 1),
(7, 'LIVERPOOL', 'liverpool.jpg', 1),
(8, 'LONDON GREENWICH', 'london_greenwich.jpg', 1),
(9, 'LONDON KINGSTON', 'london_kingston.jpg', 1),
(10, 'LOUGHBOROUGH', 'loughborough.jpg', 1),
(11, 'STIRLING', 'stirling.jpg', 1),
(12, 'WINDSOR', 'windsor.jpg', 1),
(13, 'LOS ANGELES', 'los_angeles.jpg', 2),
(14, 'MIAMI', 'miami.jpg', 2),
(15, 'NEW YORK CENTRAL', 'new_york_central.jpg', 2),
(16, 'NEW YORK RIDER', 'new_york_rider.jpg', 2),
(17, 'DUBLIN', 'dublin.jpg', 3),
(18, 'MALTA VILLAGE', 'malta_village.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_feature`
--

DROP TABLE IF EXISTS `tbl_course_feature`;
CREATE TABLE IF NOT EXISTS `tbl_course_feature` (
  `course_feature_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `feature_title` varchar(100) DEFAULT NULL,
  `feature_description` text,
  `feature_image` varchar(200) DEFAULT NULL,
  `course_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`course_feature_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_language`
--

DROP TABLE IF EXISTS `tbl_course_language`;
CREATE TABLE IF NOT EXISTS `tbl_course_language` (
  `course_language_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `course_name` varchar(100) DEFAULT NULL,
  `corse_description` text,
  `language_id` int(11) DEFAULT NULL,
  `course_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`course_language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_course_language`
--

INSERT INTO `tbl_course_language` (`course_language_id`, `course_name`, `corse_description`, `language_id`, `course_id`) VALUES
(1, 'JUNIOR SUMMER COURSES', 'Our summer school offers students opportunities to practice their English under the supervision of qualified and experienced teachers. Classes are learner-centred with all students being given the opportunity to speak as much as possible. Lessons involve the use of pair and group work, as well as whole class participation. We use specially designed text books which have been specifically written for teenage students on short summer courses. At the end of the course, students are given an end-of-course-certificate which includes assessment comments from his/her teachers.\r\n', 1, 1),
(2, 'test', 'test', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_master`
--

DROP TABLE IF EXISTS `tbl_course_master`;
CREATE TABLE IF NOT EXISTS `tbl_course_master` (
  `course_master_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `course_image` varchar(200) DEFAULT NULL,
  `course_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active , 0:inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not deleted and 1 = deleted',
  PRIMARY KEY (`course_master_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_course_master`
--

INSERT INTO `tbl_course_master` (`course_master_id`, `course_image`, `course_status`, `delete_flag`) VALUES
(1, '1510738919.jpg', 1, 0),
(2, '1510741150.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_specification`
--

DROP TABLE IF EXISTS `tbl_course_specification`;
CREATE TABLE IF NOT EXISTS `tbl_course_specification` (
  `course_specification_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `specification_option` varchar(100) DEFAULT NULL,
  `specification_value` varchar(200) DEFAULT NULL,
  `course_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`course_specification_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_course_specification`
--

INSERT INTO `tbl_course_specification` (`course_specification_id`, `specification_option`, `specification_value`, `course_id`) VALUES
(20, 'Class Size', '15 students per class', 1),
(19, 'Time', 'Morning or/and afternoon', 1),
(18, 'Class hours', '15 hours per week', 1),
(17, 'Level', 'Elementary - Advanced', 1),
(16, 'Age', '11-17', 1),
(14, 'o4', 'v4', 2),
(13, 'o3', 'v3', 2),
(12, 'o2', 'v2', 2),
(11, 'o1', 'v1', 2),
(15, 'o5', 'v5', 2),
(21, 'Course Length', 'min. 2-4 weeks', 1);

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
-- Table structure for table `tbl_region_master`
--

DROP TABLE IF EXISTS `tbl_region_master`;
CREATE TABLE IF NOT EXISTS `tbl_region_master` (
  `region_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `region_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`region_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_region_master`
--

INSERT INTO `tbl_region_master` (`region_id`, `region_name`) VALUES
(1, 'UNITED KINGDOM'),
(2, 'USA'),
(3, 'IRELAND'),
(4, 'MALTA');

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
