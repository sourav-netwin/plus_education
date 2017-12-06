-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2017 at 06:21 AM
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_course_feature`
--

INSERT INTO `tbl_course_feature` (`course_feature_id`, `feature_title`, `feature_description`, `feature_image`, `course_id`) VALUES
(1, 'COURSE AIMS BOXED', '\r\n								1. Students will develop and increase their vocabulary.<br>\r\n								2. Students will improve their speaking and listening skills.<br>\r\n								3. Students will be introduced to British culture.<br>\r\n								4. Students will be provided with lots of opportunities to use their English in and outside the classroom.<br>\r\n								5. Students will build their confidence in using English.<br>\r\n								6. Students will make new friends.', '1511946558.jpg', 1),
(2, ' COURSE LEVELS BOXED', '\r\n								<u>Level 1- Elementary:</u><br>\r\n								The course covers basic vocabulary such as places, families, jobs, times, interests and hobbies, food and drink. It introduces grammar for initial communication. Students also learn to introduce themselves, talk about jobs, ask questions, give a description, plan a trip, and talk about their likes and dislikes.<br>\r\n								<br><u>Level 2- Pre- intermediate:</u><br>\r\n								This level builds on students’ vocabulary, revising and developing lexis for more sophisticated interaction. Students learn to communicate on a variety of topics: talking about daily lives and routines, making comparisons, talking about free-time activities and life experiences, describing activities, people and feelings, talking about past events.<br>\r\n								<br><u>Level 3- Intermediate:</u><br>\r\n								At this level students are taught a range of techniques to increase their vocabulary while grammatical concepts are revised and reinforced. Skills and functions include: introducing themselves and each other, discussing differences, planning a trip, completing and collating surveys, making complaints, giving advice and creating an advertisement.<br>\r\n								<br><u>Level 4- Upper-Intermediate:</u><br>\r\n								Students are expected to refine and develop vocabulary topics and areas of grammatical competency. Functions include: asking for and giving personal information, making future predictions, participating in an interview, talking about character and emotions, discussing hypothetical situations, writing a magazine article.<br>\r\n								<br><u>Level 5- Advanced:</u><br>\r\n								At this level students take an active role in discovering which areas of language they need to work on and improve, and to learn ways of doing this effectively. Students work with authentic texts and begin to identify aspects of phonology such as word stress and intonation. Functions covered include: debating, hypothesising, evaluating, identifying and participating in debates on contemporary topics.<br>', '15119465581.jpg', 1),
(3, ' EXAMS BOXED', '\r\n								PLUS is a registered centre for the Trinity Graded Examinations in Spoken English. We encourage students to take this exam because it is a spoken exam and particularly suits the emphasis of our courses.<br>\r\n								The Trinity examination, offered at 12 levels, tests the students’ abilities in fluency, pronunciation, accuracy of language, vocabulary range, and communication strategies. Students can enroll to take this exam before arrival and we will then organise an exam for them at the centre they are studying. Trinity preparation lessons can also be offered (usually in the afternoons and as an extra to the study course) at an additional cost.\r\n', '15119465582.jpg', 1),
(4, 'OUR TEACHERS BOXED', 'All our teachers are professional, well-prepared and have been selected for their experience, friendliness and enthusiasm. They hold at least a certificate in ELT/TESOL or have a qualified teacher status in conformity with the British Council criteria.', '15119465583.jpg', 1),
(5, 'SYLLABUS BOXED', '\r\n								PLUS courses are designed for students who wish to become more proficient in English and more confident in their speaking and listening skills. Our highly-interactive course reflects our students’ needs and is focused on functional and communicative language studies with a specific focus on vocabulary and pronunciation. Reading and writing skills are also enhanced through course book work as well as through diary writing which is included in the daily schedule. We strongly believe that students will learn much more if they are enjoying their study so our lessons are always fun and educational.', '15119465584.jpg', 1),
(6, 'THE PLUS COURSE BOOK BOXED', '&lt;iframe src="https://www.youtube.com/embed/RKhfXO0g-PY" allowfullscreen="" width="484" height="315" frameborder="0"&gt;&lt;/iframe&gt;<br>', '15119465585.jpg', 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_course_language`
--

INSERT INTO `tbl_course_language` (`course_language_id`, `course_name`, `corse_description`, `language_id`, `course_id`) VALUES
(1, 'JUNIOR SUMMER COURSES', 'Our summer school offers students opportunities to practice their English under the supervision of qualified and experienced teachers. Classes are learner-centred with all students being given the opportunity to speak as much as possible. Lessons involve the use of pair and group work, as well as whole class participation. We use specially designed text books which have been specifically written for teenage students on short summer courses. At the end of the course, students are given an end-of-course-certificate which includes assessment comments from his/her teachers.', 1, 1),
(2, 'ADULT COURSES', 'ADULT COURSES', 1, 2),
(3, NULL, NULL, NULL, 3),
(4, NULL, NULL, NULL, 4),
(5, NULL, NULL, NULL, 5),
(6, NULL, NULL, NULL, 6),
(7, NULL, NULL, NULL, 7),
(8, NULL, NULL, NULL, 8),
(9, NULL, NULL, NULL, 9),
(10, NULL, NULL, NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_master`
--

DROP TABLE IF EXISTS `tbl_course_master`;
CREATE TABLE IF NOT EXISTS `tbl_course_master` (
  `course_master_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `course_image` varchar(200) DEFAULT NULL,
  `course_front_image` varchar(200) DEFAULT NULL,
  `course_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active , 0:inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not deleted and 1 = deleted',
  PRIMARY KEY (`course_master_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_course_master`
--

INSERT INTO `tbl_course_master` (`course_master_id`, `course_image`, `course_front_image`, `course_status`, `delete_flag`) VALUES
(1, '1511946212.jpg', '1511946212.jpg', 1, 0),
(2, '1511948319.jpg', '1511948319.jpg', 1, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_course_specification`
--

INSERT INTO `tbl_course_specification` (`course_specification_id`, `specification_option`, `specification_value`, `course_id`) VALUES
(1, 'Age', '11-17', 1),
(2, 'Level', 'Elementary - Advanced', 1),
(3, 'Class hours', '15 hours per week', 1),
(4, 'Time', 'Morning or/and afternoon', 1),
(5, 'Class Size', '15 students per class', 1),
(6, 'Course Length', 'min. 2-4 weeks', 1),
(7, 'Age', '11-17', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_junior_centre`
--

DROP TABLE IF EXISTS `tbl_junior_centre`;
CREATE TABLE IF NOT EXISTS `tbl_junior_centre` (
  `junior_centre_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `centre_id` int(11) DEFAULT NULL,
  `centre_banner` varchar(100) DEFAULT NULL,
  `centre_description` text,
  `centre_address` text,
  `centre_latitude` varchar(100) DEFAULT NULL,
  `centre_longitude` varchar(100) DEFAULT NULL,
  `junior_centre_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active & 0:Inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:not delete & 1:delete',
  PRIMARY KEY (`junior_centre_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_junior_centre`
--

INSERT INTO `tbl_junior_centre` (`junior_centre_id`, `centre_id`, `centre_banner`, `centre_description`, `centre_address`, `centre_latitude`, `centre_longitude`, `junior_centre_status`, `delete_flag`) VALUES
(1, 2, '1512127952.jpg', '<p class="MsoNormal" style="font-weight: normal;">\r\n										<span style="font-weight: bold;">Canterbury</span> is a typical historic English city located in the\r\n										district of Kent in southeast of England. It is one of the most visited cities\r\n										in the UK. The city centre is dominated by Canterbury Cathedral - the oldest\r\n										Cathedral in England. &nbsp;It is an\r\n										impressive building with plenty of ornate details and stained glass windows.\r\n										There are also the ancient ruins of St. Augustine’s Abbey, St. Martin’s Church\r\n										and the Norman Castle and these represent the city’s history, heritage and\r\n										culture. The city has vibrant leisure attractions including fine restaurants,\r\n										welcoming pubs and quaint cafes. The city centre is a pedestrianised area with\r\n										charming black-and-white Victorian houses. There is also a great selection of\r\n										shops. Canterbury is very close to the beautiful beaches of Whitstable and\r\n										Herne Bay as well as stunning English countryside.\r\n									</p>\r\n\r\n									<p class="MsoNormal">\r\n										<span style="font-weight: bold;">Plus </span>hold their summer courses at the\r\n										University of Kent.&nbsp;<span style="font-weight: normal;">&nbsp;The University\r\n										is set in 450 acres of parkland and is less than a 25-minute walk\r\n										from the city centre. It is situated on a hill and has a stunning views of the\r\n										Cathedral. There are various modern buildings surrounded by green open spaces,\r\n										fields and forests. The campus is self-contained and includes all the necessary\r\n										amenities such as bars, shops, a sports centre, a bookshop and bus stops. It is\r\n										an open campus but very safe and offers 24-hour security. The sports facilities\r\n										are excellent with multi-purpose halls, squash courts, a climbing wall, playing\r\n										fields and many others.</span>\r\n									</p>\r\n\r\n									<p class="MsoNormal" style="font-weight: normal;">\r\n										<span style="font-weight: bold;">Campus Highlights/ Facilities</span>\r\n									</p>\r\n									<ul style="font-weight: normal;">\r\n										<li>\r\n											<span style="text-indent: -18pt;">- Green open spaces with beautiful views over the city</span>\r\n										</li>\r\n										<li>\r\n											<span style="text-indent: -18pt;">- Outdoor playing fields and an artificial football pitch</span>\r\n										</li>\r\n										<li>\r\n											<span style="text-indent: -18pt;">- Tennis courts</span>\r\n										</li>\r\n										<li>\r\n											<span style="text-indent: -18pt;">- Multi-purpose sports hall</span>\r\n										</li>\r\n										<li>\r\n											<span style="text-indent: -18pt;">- On-site cinema</span>\r\n										</li>\r\n										<li>\r\n											<span style="text-indent: -18pt;">- On-site bus stops</span>\r\n										</li>\r\n										<li>\r\n											<span style="text-indent: -18pt;">- On- site cafes, bars, a gift shop and supermarket</span>\r\n										</li>\r\n										<li>\r\n											<span style="text-indent: -18pt;">- Wi-Fi for students and staff.</span>\r\n										</li>\r\n									</ul>', 'canterbury', '51.280233', '1.0789089', 1, 0),
(2, 1, '1512091004.jpg', ' <div style="">Brighton is located on the south coast of England in East Sussex. It is only an hour away from Central London by train and 30 minutes away from London Gatwick, one of the main international airports in the UK. Brighton offers many attractions: The Royal Pavilion, great museums, a beautiful beach and superb shopping. Its famous seafront seafront and the Pier is full of amusements, rides and charming sea views. Brighton is home to beautiful Regency houses and colourful narrow shopping streets known as the Lanes, which are packed with vintage shops, cafes and restaurants. Nearby, there is the famous South Downs National Park with the dramatic Seven Sisters cliffs and beautiful&nbsp;English villages. It is a culturally vibrant destination&nbsp;that provides many events through&nbsp;the year: art and music festivals, horse races, beach and water-sports festival and many more .&nbsp;</div><div style=""><br></div><div style="">The PLUS centre is brand new with all the teaching, catering, accommodation and student social communal facilities located close together on this one campus. The campus is located about 4 miles to the north of Brighton making it an excellent base for exploring this corner of England on full day trips and local excursions. The town centre of Brighton is easily accessed by bus from a local bus stop or by train from Falmer, which is within walking distance. From this centre you can easily reach places like Eastbourne, Oxford, Cambridge, Arundel, Canterbury and of course central London with its fabulous museums and world class tourist attractions.</div><div style=""><div style="font-family: Arial, Verdana; font-size: 12px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal;"><br></div><div style=""><div style=""><span style="font-family: Arial, Verdana; font-size: 12px; font-weight: bold;">Campus Highlights/ Facilities</span></div><div style=""><ul><li>- Green open spaces around the campus for students to relax</li><li>- Easy-access to Brighton city centre- a popular tourist destination</li><li>- Free Wi-Fi for students and group leaders</li><li>- Safe and secure environment</li><li>- Easy-access to the main international airports.</li></ul></div></div></div><br>						', 'brighton', '50.82253', '-0.137163', 1, 0),
(3, 3, '1512091407.jpg', ' <p class="MsoNormal" style="margin-bottom: 0.0001pt; text-align: justify;"><span style="font-weight: bold;">Chelmsford</span> is a city in Essex\r\nin the east of England. It is approximately 50km north east of London and there\r\nis a railway station with direct trains to London Liverpool Street in Central\r\nLondon (35 minutes travel time). Chelmsford is an urban area with a mix of\r\nVictorian and modern buildings and a vibrant city centre with two shopping\r\ncentres and a wide range of restaurants and pubs. Chelmsford is surrounded by many\r\nparks and picturesque English villages. Places to visit include Marsh Farm\r\nAnimal Adventure Park, Tropical Wings Zoo, Chelmsford Cathedral, Shire Hall, Chelmsford\r\nMuseum and many more.</p><p class="MsoNormal" style="margin-bottom: 0.0001pt; text-align: justify;"><span style="font-weight: bold;">The PLUS centre</span> is located at one of the largest agricultural\r\nuniversities in the UK. It is surrounded by its own farm, landscaped gardens\r\nand offers a secure university environment with plenty of open areas for\r\nrecreation. The campus is a self contained with lots of modern teaching, living\r\nand sporting facilities in modern brick buildings. The city centre is easily\r\naccessible from the campus by bus (15 minutes travel time). &nbsp;</p><p class="MsoNormal" style="font-weight: normal; margin-bottom: 0.0001pt; text-align: justify;"><o:p></o:p></p><div style="font-weight: normal;"><br></div><div style="font-weight: normal;"><span style="font-weight: bold;">Campus Highlights/ Facilities</span></div><div style="font-weight: normal;"><ul><li><span style="text-indent: -24px;">- Experience the magnificient British countryside thanks to a picturesque 220 hectare campus, including beautiful landscaped gardens</span></li><li><span style="text-indent: -18pt; text-align: justify;">- Self-contained campus with all facilities within\r\nwalking distance</span></li><li><span style="text-align: justify; text-indent: -18pt;">- Safe and secure environment</span></li><li><span style="text-indent: -18pt;">- Academy centre</span></li><li><span style="text-align: justify; text-indent: -18pt;">- Complimentary Wi-Fi for the students and group\r\nleaders</span></li><li><span style="text-align: justify; text-indent: -18pt;">- Outdoor sports facilities for football,\r\nbasketball, rugby, volleyball and tennis</span></li><li><span style="text-align: justify; text-indent: -18pt;">- Indoor sports hall</span></li><li><span style="text-align: justify; text-indent: -18pt;">- 24 hour CCTV.</span></li></ul></div><br>	', 'chelmsform', '51.7355868', '0.4685497', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_junior_centre_program`
--

DROP TABLE IF EXISTS `tbl_junior_centre_program`;
CREATE TABLE IF NOT EXISTS `tbl_junior_centre_program` (
  `junior_centre_program_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `program_id` int(11) DEFAULT NULL,
  `junior_centre_id` int(11) NOT NULL COMMENT 'foreign key',
  PRIMARY KEY (`junior_centre_program_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_junior_centre_program`
--

INSERT INTO `tbl_junior_centre_program` (`junior_centre_program_id`, `program_id`, `junior_centre_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 1, 2),
(4, 2, 2),
(5, 4, 3);

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
-- Table structure for table `tbl_program_banner`
--

DROP TABLE IF EXISTS `tbl_program_banner`;
CREATE TABLE IF NOT EXISTS `tbl_program_banner` (
  `program_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `program_image` varchar(100) DEFAULT NULL,
  `program_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active , 0:inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not deleted and 1 = deleted',
  PRIMARY KEY (`program_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_program_banner`
--

INSERT INTO `tbl_program_banner` (`program_id`, `program_image`, `program_status`, `delete_flag`) VALUES
(1, '1511917327.jpg', 1, 0),
(2, '1511917360.jpg', 1, 0),
(3, '1511917411.jpg', 1, 0),
(4, '1511917451.jpg', 1, 0),
(5, '1511917486.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_program_banner_language`
--

DROP TABLE IF EXISTS `tbl_program_banner_language`;
CREATE TABLE IF NOT EXISTS `tbl_program_banner_language` (
  `program_language_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `language_id` int(11) DEFAULT NULL,
  `program_title` varchar(100) DEFAULT NULL,
  `program_short_description` varchar(200) DEFAULT NULL,
  `program_description` text,
  `program_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`program_language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_program_banner_language`
--

INSERT INTO `tbl_program_banner_language` (`program_language_id`, `language_id`, `program_title`, `program_short_description`, `program_description`, `program_id`) VALUES
(1, 1, 'JUNIOR USA SUMMER COURSE', 'Giving valuable reputation and credibility to your business', 'Giving valuable reputation and credibility to your business', 1),
(2, 1, 'JUNIOR EUROPE SUMMER COURSE', 'Readable code, well documented and FREE support', 'Readable code, well documented and FREE support', 2),
(3, 1, 'JUNIOR ALL YEAR ROUND IN USA', 'Readable code, well documented and FREE support', 'Readable code, well documented and FREE support', 3),
(4, 1, 'JUNIOR ALL YEAR ROUND', 'Leave it to the theme, it knows how to deal with screen sizes', 'Leave it to the theme, it knows how to deal with screen sizes', 4),
(5, 1, 'ENGLISH STARS', 'Readable code, well documented and FREE support', 'Readable code, well documented and FREE support', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_program_course`
--

DROP TABLE IF EXISTS `tbl_program_course`;
CREATE TABLE IF NOT EXISTS `tbl_program_course` (
  `program_course_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `program_course_name` varchar(100) DEFAULT NULL,
  `program_course_description` text,
  `program_course_logo` varchar(100) DEFAULT NULL,
  `program_course_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Active & 0:Inactive',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:not delete & 1:delete',
  PRIMARY KEY (`program_course_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_program_course`
--

INSERT INTO `tbl_program_course` (`program_course_id`, `program_course_name`, `program_course_description`, `program_course_logo`, `program_course_status`, `delete_flag`) VALUES
(1, 'CLASSIC', '<div style="font-weight: normal;">A 2-week programme includes:&nbsp;</div><ul style=""><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to London</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge</li><li style="">-&nbsp;<b>5 Half Day Excursions&nbsp;</b>to Brighton (travelcards included)</li></ul>A 3-week programme includes:<br><ul style=""><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to London</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Portsmouth</li><li>-&nbsp;<b>5 Half Day Excursions&nbsp;</b>to Brighton (travelcards included)</li></ul>', '1512019094.jpg', 1, 0),
(2, 'CLASSIC PREMIUM', '<div style="font-weight: normal;">A 2-week programme includes:&nbsp;</div><ul style=""><li style="font-weight: normal;"><span style="font-weight: bold;">- 2 Full Day Excursions</span>&nbsp;to London</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Oxford</li><li style="">- <span style="font-weight: bold;">5 Half Day&nbsp;</span><span style="font-weight: bold;">Excursions</span>&nbsp;to Brighton (travelcards included)&nbsp;</li></ul>A 3-week programme includes:&nbsp;<br><ul style=""><li><span style="font-weight: bold;">- 2 Full Day Excursions</span>&nbsp;to London</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Oxford</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Portsmouth</li><li>-&nbsp;<span style="font-weight: bold;">5 Half Day&nbsp;</span><span style="font-weight: bold;">Excursions</span>&nbsp;to Brighton (travelcards included)&nbsp;</li></ul>', '1512020203.jpg', 1, 0),
(3, 'CLASSIC PLUS ACADEMY', 'A 2-week programme includes: <br>\r\n<ul style="font-weight: normal;"><li><span style="font-weight: bold;">- 2 Full Day Excursions </span>to London</li><li style="font-weight: normal;"><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Oxford</li><li><span style="font-weight: bold;">- 1 Full Day Excursion </span>to Portsmouth.</li></ul>\r\n<div style="font-weight: normal;">A 3-week programme includes:</div>\r\n<div style="font-weight: normal;"><ul><li><span style="font-weight: bold;">- 2 Full Day Excursions&nbsp;</span>to London</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Oxford</li><li><span style="font-weight: bold;">- 1 Full Day Excursion&nbsp;</span>to Portsmouth</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Brighton.</li></ul><div>*All excursions include a walking tour and transport is provided by<span style="text-decoration: underline;"><span style="font-weight: bold;">&nbsp;Private Coach</span></span>&nbsp;and escorted by PLUS staff.</div></div>', '1512020306.jpg', 1, 0),
(4, 'CLASSIC PREMIUM PLUS ACADEMY', 'A 2-week programme includes:<br>\r\n<ul style="font-weight: normal;"><li><span style="font-weight: bold;">- 2 Full Day Excursions</span> to London (late return; River Cruise included)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge.</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Canterbury</li><li><span style="font-weight: bold;">- 1 Half Day Excursion</span>&nbsp;to Chelmsford.</li></ul>\r\nA  3-week programme includes:\r\n<div style="font-weight: normal;"><ul><li><span style="font-weight: bold;">- 2 Full Day Excursions</span>&nbsp;to London (late return; River Cruise included)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Cambridge.</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Canterbury</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Rochester and Whitstable</li><li><span style="font-weight: bold;">- 1 Half Day Excursion</span>&nbsp;to Chelmsford.</li></ul><div><div>*All excursions include a walking tour* and transport is provided by&nbsp;<span style="text-decoration: underline;"><span style="font-weight: bold;">Private Coach</span></span>&nbsp;and escorted by PLUS staff.&nbsp;</div></div></div>', '1512021004.jpg', 1, 0),
(5, 'EXPERIENCE', '<div>A 2-week programme includes:<br><ul style="font-weight: normal;"><li><span style="font-weight: bold;">A weekend away</span> in Las Vegas &amp; Grand Canyon (4 days/3 nights):</li><li>- A visit to Hoover Dam, Las Vegas Strip, dinner at Hard Rock Cafe and Fremont Street LED Experience and an optional limo tour of Las Vegas&nbsp;</li><li>- A visit to Grand Canyon and an overnight in Arizona</li><li>- A visit to Calico Ghost Town</li><li>- Shopping at outlets</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to San Diego visiting: La Jolla Beach, Mission Beach, Old Town and Gas Lamp District</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Los Angeles visiting: Beverly Hills, Rodeo Drive, Hollywood Bus Tour with dinner at Hard Rock Cafe</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> Los Angeles visiting: The Getty Museum, Venice Beach, Santa Monica</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Los Angeles visiting: California Science Centre, &nbsp;LA Farmer''s Market &amp; The Grove, Huntington Beach</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Malibu and Santa Barbara</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Los Angeles visiting Griffith Observatory, Downtown Los Angeles Bus Tour (Olvera Street, Union Station, pictures outside the Walt Disney Concert Hall and Staples Centre).</li></ul>In addition, a&nbsp;3-week programme includes:&nbsp;<br><ul style="font-weight: normal;"><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Pasadena, Universal CityWalk. Optional excursion to Norton Simon Museum.</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to UCLA, Manhattan Beach, Roundhouse Aquarium</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to LACMA, Melrose Avenue.&nbsp;&nbsp;</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Six Flags</li><li><span style="font-weight: bold;">- 1 Half Day Excursion:</span> Shopping at Outlets.</li></ul>* All overnight excursions include half board with breakfast and dinner provided.</div>\r\n<div>* All excursions are organised by private coach and supervised by PLUS USA staff.</div>', '1512132644.jpg', 1, 0),
(6, 'CLASSIC SUPERIOR', 'A 2-week programme includes: <br><ul style="font-weight: normal;"><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to San Diego visiting: La Jolla Beach, Mission Beach, Old Town and Gas Lamp District</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Los Angeles visiting: Beverly Hills, Rodeo Drive, Hollywood Bus Tour with dinner at Hard Rock Cafe</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> Los Angeles visiting: The Getty Museum, Venice Beach, Santa Monica</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Los Angeles visiting: California Science Centre, LA Farmer''s Market &amp; The Grove, Huntington Beach</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Malibu and Santa Barbara</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Los Angeles visiting Griffith Observatory, Downtown Los Angeles Bus Tour (Olvera Street, Union Station, pictures outside the Walt Disney Concert Hall and Staples Centre).</li></ul>\r\nIn addition, a 3-week programme includes:\r\n<br>\r\n<ul style="font-weight: normal;"><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Pasadena, Universal CityWalk. Optional excursion to Norton Simon Museum.</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to UCLA, Manhattan Beach, Roundhouse Aquarium</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to&nbsp; LACMA, Melrose Avenue.&nbsp;</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Six Flags</li><li><span style="font-weight: bold;">- 1 Half Day Excursion:</span> Shopping at outlets.</li></ul>', '1512132879.jpg', 1, 0),
(7, 'CLASSIC PREMIUM PLUS WEEKEND AWAY', '<p class="p2" style="font-weight: normal;">A 2-week programme includes:</p>\r\n<ul style="font-weight: normal;"><li><span style="font-weight: bold;">- A weekend</span>&nbsp;in London (3 days 2 nights)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span> to Manchester</li><li><span style="font-weight: bold;">- 5 Half Day Excursions</span> to Liverpool City Centre (travelcards included).</li></ul>\r\n<div style="font-weight: normal;">A 3-week programme includes:</div>\r\n<div style="font-weight: normal;"><ul><li><span style="font-weight: bold;">- A weekend</span>&nbsp;in London (3 days 2 nights)</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to Manchester</li><li><span style="font-weight: bold;">- 1 Full Day Excursion</span>&nbsp;to York</li><li><span style="font-weight: bold;">- 7 Half Day Excursions</span>&nbsp;to Liverpool City Centre (travelcards included).</li></ul><div>*All excursions include a walking tour and transport is provided by Private Coach and escorted by PLUS staff.</div></div>', '1512090334.jpg', 1, 0);

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
(1, 'Stefano Marra', 'smarra@plus-ed.com', 'stefano', '317a58affea472972b63bffdd3392ae0', '1512108982.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
