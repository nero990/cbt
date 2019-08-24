-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 23, 2016 at 12:54 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `computer_based_test`
--
CREATE DATABASE IF NOT EXISTS `computer_based_test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `computer_based_test`;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_classes`
--

CREATE TABLE IF NOT EXISTS `cbt_classes` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `_class` varchar(7) NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cbt_classes`
--

INSERT INTO `cbt_classes` (`class_id`, `_class`) VALUES
(1, 'JSS I'),
(2, 'JSS II'),
(3, 'JSS III'),
(4, 'SSS I'),
(5, 'SSS II'),
(6, 'SSS III');

-- --------------------------------------------------------

--
-- Table structure for table `cbt_questions`
--

CREATE TABLE IF NOT EXISTS `cbt_questions` (
  `quest_id` int(11) NOT NULL AUTO_INCREMENT,
  `subj_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `a` text NOT NULL,
  `b` text NOT NULL,
  `c` text NOT NULL,
  `d` text NOT NULL,
  `answer` varchar(2) NOT NULL,
  PRIMARY KEY (`quest_id`),
  KEY `course_id` (`subj_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `cbt_questions`
--

INSERT INTO `cbt_questions` (`quest_id`, `subj_id`, `class_id`, `question`, `a`, `b`, `c`, `d`, `answer`) VALUES
(10, 10, 3, 'Feeling or opinion one has about something is known as __________________', 'Attibutes', 'Attitde', 'Tolerance', 'Transparency', 'B'),
(11, 10, 3, 'Reward and importance of right attitude to work is that __________________', 'It leads to lower productivity', 'It leads to inefficiency', 'It leads to higher productivity', 'None of the above', 'C'),
(12, 10, 3, 'Manner one conducts itself is known as __________', 'Behaviour', 'Disregard', 'Integrity', 'Tolerance', 'A'),
(14, 10, 3, 'The headcount of people living in a geographical location is known as ___________', 'Population death', 'Population Cencus', 'Population birth', 'Population migrate', 'B'),
(15, 10, 3, 'All these are importance of population census except __________', 'It is a tool for corruption', 'It is a tool for national planning', 'It assist the government in formulating policies', 'It assist in distribution and allocation of resources', 'A'),
(16, 10, 3, 'Right to vote and be voted for is known as', 'Policatical Rights', 'Social Right', 'Legal Right', 'Cultural Right', 'A'),
(17, 10, 3, 'The right of Nigerian Citizens are normally spelt out under the ___________', 'Superstitious belief', 'Constitution', 'All of the above', 'None of the above', 'B'),
(18, 10, 3, 'For population census figure to be acceptable in Nigeria, it must be conducted in a way and manner that will reflect the following except _____________', 'It must be free and fair', 'There must be adequate and enough funder', 'It must be conducted during raining season', 'There must be enough and adequate planning years', 'C'),
(19, 10, 3, 'No man is above the law is one of the principles of _____________', 'Rule of labour', 'Rule of man', 'Rule of law', 'None of the above', 'C'),
(20, 2, 2, 'What''s the past tense of "GO"?', 'Went', 'Gone', 'Going', 'Go', 'A'),
(21, 2, 2, 'I have ___________ him his book', 'give', 'given', 'gave', 'giving', 'B'),
(27, 3, 6, 'A group of computer systems and other computing hardware devices that are linked together through communication channels to facilitate communication and resource sharing among a wide range of users is called', 'Computer Network', 'Computer Networking', 'Computer Communication', 'Network Topology', 'A'),
(28, 3, 6, 'Which of the following types of network consist of computers connected at a single site/individual office building', 'Personal Area Network (PAN)', 'Local Area Network (LAN)', 'Metropolitan Area Network (MAN)', 'Wide Area Network (WAN)', 'B'),
(29, 3, 6, 'The arrangement of various elements (links, nodes, etc) of a computer network is called', 'Network', 'Logical Network', 'Networking', 'Network Topology', 'D'),
(30, 3, 6, '____________________ is basically a system of internet servers that support specially formatted documents.', 'Web World Wide', 'Weber', 'World Wide Web', 'Webpage', 'C'),
(31, 3, 6, 'Which of the following is a software for web development?', 'Dreamweaver', 'Microsoft Access', 'CorelDraw', 'Microsoft Excel', 'A'),
(32, 3, 6, 'Which of the following is NOT a type of Network Topology', 'Bus Topology', 'Moon Topology', 'Star Topology', 'Ring Topology', 'B'),
(33, 3, 6, 'The following are networking devices EXCEPT', 'Router', 'Switch', 'Socket', 'Bridge', 'C'),
(34, 3, 6, 'WWW stands for what?', 'World Web Wide', 'Web World Wide', 'World Wide Web', 'Window Web Wide', 'C'),
(35, 3, 6, 'The following are benefits of computer network EXCEPT', 'It increases processor speed', 'It helps to enhance connectivity', 'Resource sharing', 'Ease data sharing', 'A'),
(36, 3, 6, 'The following are benefit of WWW EXCEPT', 'Networking', 'Exchange of business information', 'Enhances communication', 'None of the above', 'D'),
(37, 3, 6, '_____________ are networking hardware used to connect one device to other network device', 'MySQL', 'Netbeans', 'Sybases', 'Networking cables', 'D'),
(38, 3, 6, 'HTML stands for _______________', 'Hyper Text Makeup Language', 'Hyper Text Markup Language', 'Hyper Test Makeup Language', 'Hyper Test Markup Language', 'B'),
(39, 3, 6, 'An organised collection of data which contains schema, tables, queries, reports, view and other objects is called', 'File', 'Data Management System', 'Data', 'Database', 'D'),
(40, 3, 6, 'The following are types of network cables EXCEPT', 'Oracle', 'Fibre optic', 'Patch cable', 'Twisted pair', 'A'),
(41, 3, 6, 'The device used to join two network segments together is called', 'Bridge', 'NIC', 'Modem', 'Hub', 'A'),
(42, 3, 6, 'A software package designed to define, manipulate, retrieve and manage data in a database is called', 'Management Information System', 'Database Information System', 'Database Management System', 'Information System', 'C'),
(43, 3, 6, '________________ provides the physical link between two components', 'Network cables', 'Network connectors', 'Network switch', 'Network', 'B'),
(44, 3, 6, 'NIC stands for ____________', 'Network Interface Card', 'Network Information Communication', 'Network Internet Communication', 'Network  Internet Controller', 'A'),
(45, 3, 6, '__________________ is a device that makes it possible for computers to communicate over telephone lines.', 'Router', 'Switch', 'Modem', 'Hub', 'C'),
(46, 3, 6, 'What is the full meaning of DBMS', 'Data Management System', 'Database Management System', 'Database Manage System', 'Data Manage System', 'B'),
(47, 3, 6, 'Which among the following is NOT a database object', 'Chairs', 'Tables', 'Reports', 'Queries', 'A'),
(48, 3, 6, 'HTTP stands for', 'Hyper Text Transfer Protocol', 'Hyper Transfer Text Protocol', 'Hyper Text Transfering Protocol', 'Hyper Transfering Text Protocol', 'A'),
(49, 3, 6, 'The processing of Turning OFF the computer system is known as', 'OFF', 'Booting', 'Shutdown', 'Boot OFF', 'C'),
(50, 3, 6, '____________ is a collection of webpages', 'Website', 'Webpage', 'Home Page', 'Index Page', 'A'),
(51, 3, 6, 'Among the following, which is NOT a form of database organisation', 'Hierarchical Database', 'Relational Database', 'Relation Database', 'Object-Oriented Database', 'C'),
(52, 3, 6, '_________________ is a document that is accessed through the internet', 'Website', 'Webpage', 'Homepage', 'Document File', 'B'),
(53, 3, 6, '__________________ is a request for data or information from a database table or combination of tables', 'Query', 'Form', 'Modules', 'Macro', 'A'),
(54, 3, 6, '_____________ is the initial or main webpage of a website', 'Website', 'Webpage', 'Home Page', 'First Page', 'C'),
(55, 3, 6, '___________ is the formatted result of database queries and contains useful data for decision-making and analysis', 'Form', 'Report', 'Module', 'Macro', 'B'),
(56, 3, 6, 'The process of Turning ON or restarting the computer system is referred to as', 'Booting', 'Shutdown', 'Switch OFF', 'Hibernate', 'A'),
(57, 3, 3, '_________ is the processing of starting/restarting the computer system', 'ONing', 'Booting', 'Shutdown', 'Hibernate', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `cbt_results`
--

CREATE TABLE IF NOT EXISTS `cbt_results` (
  `result_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `subj_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `total_question` int(11) NOT NULL,
  `answered_quest` int(11) NOT NULL,
  `total_valid_ans` int(11) NOT NULL,
  `total_wrong_ans` int(11) NOT NULL,
  `unanswered` int(11) NOT NULL,
  `score` decimal(10,2) NOT NULL,
  `test_date` date NOT NULL,
  PRIMARY KEY (`result_id`),
  KEY `cand_course_id` (`student_id`),
  KEY `subj_id` (`subj_id`,`class_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=136 ;

--
-- Dumping data for table `cbt_results`
--

INSERT INTO `cbt_results` (`result_id`, `student_id`, `subj_id`, `class_id`, `total_question`, `answered_quest`, `total_valid_ans`, `total_wrong_ans`, `unanswered`, `score`, `test_date`) VALUES
(29, 1, 2, 2, 5, 5, 2, 3, 0, '40.00', '2016-02-18'),
(58, 4, 3, 6, 30, 29, 22, 7, 1, '73.33', '2016-02-18'),
(59, 10, 3, 6, 30, 30, 24, 6, 0, '80.00', '2016-02-18'),
(60, 7, 3, 6, 30, 30, 17, 13, 0, '56.67', '2016-02-18'),
(62, 9, 3, 6, 30, 30, 23, 7, 0, '76.67', '2016-02-18'),
(63, 6, 3, 6, 30, 30, 23, 7, 0, '76.67', '2016-02-18'),
(64, 8, 3, 6, 30, 30, 22, 8, 0, '73.33', '2016-02-18'),
(90, 3, 10, 3, 9, 9, 4, 5, 0, '44.44', '2016-02-22'),
(127, 13, 10, 3, 9, 1, 1, 0, 8, '11.11', '2016-02-22'),
(134, 11, 3, 6, 30, 0, 0, 0, 30, '0.00', '2016-02-23'),
(135, 5, 10, 3, 9, 0, 0, 0, 9, '0.00', '2016-02-23');

-- --------------------------------------------------------

--
-- Table structure for table `cbt_students`
--

CREATE TABLE IF NOT EXISTS `cbt_students` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` varchar(40) NOT NULL,
  `other_names` varchar(80) NOT NULL,
  `class_id` int(11) NOT NULL,
  `reg_no` varchar(10) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `subj_id` int(11) DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `stop_time` datetime DEFAULT NULL,
  `session_val` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `session_val` (`session_val`),
  KEY `class_id` (`class_id`),
  KEY `subj_id` (`subj_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `cbt_students`
--

INSERT INTO `cbt_students` (`student_id`, `surname`, `other_names`, `class_id`, `reg_no`, `state`, `subj_id`, `duration`, `start_time`, `stop_time`, `session_val`) VALUES
(1, 'NKEM', 'CHRIS', 2, '58017153IH', 0, NULL, NULL, NULL, NULL, NULL),
(2, 'OKEKE', 'PAUL MONDAY', 4, '57881357VA', 0, NULL, NULL, NULL, NULL, NULL),
(3, 'ADAMS', 'CHRISTIANA', 3, '55786311XE', 0, NULL, NULL, NULL, NULL, NULL),
(4, 'ALABI', 'MUYIWA', 6, '51419051ZQ', 0, NULL, NULL, NULL, NULL, NULL),
(5, 'ALAO', 'SUKURAT', 3, '69858577RH', 1, 10, '00:15:00', '2016-02-23 13:48:39', '2016-02-23 14:03:39', 'd46d2375ec91bf5024b04bff1bd4951ff5cfba4d'),
(6, 'OLORODE', 'NURUDEEN', 6, '67252374TU', 0, NULL, NULL, NULL, NULL, NULL),
(7, 'SULAIMAN', 'FATAI', 6, '61831781AX', 0, NULL, NULL, NULL, NULL, NULL),
(8, 'OLAOYE', 'MUSTAPHA', 6, '66040717IE', 0, NULL, NULL, NULL, NULL, NULL),
(9, 'ABDULSALAM', 'SODIQ', 6, '67740064QJ', 0, NULL, NULL, NULL, NULL, NULL),
(10, 'OLATUNJI', 'SAMUEL', 6, '67501156YZ', 0, NULL, NULL, NULL, NULL, NULL),
(11, 'OLUSANYA', 'KUNMI', 6, '68514882HP', 0, NULL, NULL, NULL, NULL, NULL),
(12, 'KELVIN', 'HART', 4, '69987533XE', 0, NULL, NULL, NULL, NULL, NULL),
(13, 'AKANO', 'OKIKI', 3, '64031716KG', 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cbt_students_answers`
--

CREATE TABLE IF NOT EXISTS `cbt_students_answers` (
  `student_ans_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `subj_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `student_ans` varchar(2) NOT NULL,
  `remark` tinyint(1) NOT NULL,
  PRIMARY KEY (`student_ans_id`),
  KEY `cand_course_id` (`subj_id`),
  KEY `question_id` (`quest_id`),
  KEY `student_id` (`student_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=671 ;

--
-- Dumping data for table `cbt_students_answers`
--

INSERT INTO `cbt_students_answers` (`student_ans_id`, `student_id`, `subj_id`, `class_id`, `quest_id`, `student_ans`, `remark`) VALUES
(60, 10, 3, 6, 27, 'A', 1),
(61, 10, 3, 6, 28, 'B', 1),
(62, 10, 3, 6, 29, 'D', 1),
(63, 10, 3, 6, 30, 'C', 1),
(64, 10, 3, 6, 31, 'B', 0),
(65, 10, 3, 6, 32, 'B', 1),
(66, 10, 3, 6, 33, 'C', 1),
(67, 10, 3, 6, 34, 'C', 1),
(68, 10, 3, 6, 35, 'D', 0),
(70, 10, 3, 6, 36, 'D', 1),
(72, 10, 3, 6, 37, 'D', 1),
(74, 10, 3, 6, 38, 'B', 1),
(76, 7, 3, 6, 27, 'B', 0),
(78, 10, 3, 6, 39, 'D', 1),
(81, 10, 3, 6, 40, 'A', 1),
(83, 7, 3, 6, 28, 'B', 1),
(84, 10, 3, 6, 41, 'A', 1),
(87, 10, 3, 6, 42, 'C', 1),
(88, 7, 3, 6, 29, 'D', 1),
(91, 10, 3, 6, 43, 'A', 0),
(93, 10, 3, 6, 44, 'A', 1),
(94, 7, 3, 6, 30, 'D', 0),
(95, 10, 3, 6, 45, 'C', 1),
(97, 7, 3, 6, 31, 'B', 0),
(98, 10, 3, 6, 46, 'B', 1),
(99, 10, 3, 6, 47, 'A', 1),
(101, 10, 3, 6, 48, 'A', 1),
(104, 7, 3, 6, 32, 'C', 0),
(105, 10, 3, 6, 49, 'C', 1),
(107, 10, 3, 6, 50, 'A', 1),
(110, 7, 3, 6, 33, 'A', 0),
(113, 10, 3, 6, 51, 'D', 0),
(114, 7, 3, 6, 34, 'C', 1),
(116, 10, 3, 6, 52, 'A', 0),
(119, 7, 3, 6, 35, 'A', 1),
(122, 7, 3, 6, 36, 'D', 1),
(123, 10, 3, 6, 53, 'A', 1),
(126, 7, 3, 6, 37, 'D', 1),
(128, 10, 3, 6, 54, 'C', 1),
(131, 7, 3, 6, 38, 'D', 0),
(133, 7, 3, 6, 39, 'D', 1),
(135, 7, 3, 6, 40, 'D', 0),
(136, 10, 3, 6, 55, 'C', 0),
(139, 7, 3, 6, 41, 'C', 0),
(141, 10, 3, 6, 56, 'A', 1),
(142, 7, 3, 6, 42, 'B', 0),
(144, 7, 3, 6, 43, 'B', 1),
(145, 7, 3, 6, 44, 'A', 1),
(146, 7, 3, 6, 45, 'B', 0),
(147, 7, 3, 6, 46, 'B', 1),
(150, 7, 3, 6, 47, 'A', 1),
(151, 7, 3, 6, 48, 'A', 1),
(152, 7, 3, 6, 49, 'C', 1),
(154, 7, 3, 6, 50, 'C', 0),
(156, 7, 3, 6, 51, 'C', 1),
(157, 8, 3, 6, 27, 'A', 1),
(159, 8, 3, 6, 28, 'B', 1),
(160, 8, 3, 6, 29, 'D', 1),
(161, 7, 3, 6, 52, 'A', 0),
(164, 8, 3, 6, 30, 'C', 1),
(166, 7, 3, 6, 53, 'B', 0),
(169, 7, 3, 6, 54, 'C', 1),
(171, 8, 3, 6, 31, 'B', 0),
(173, 8, 3, 6, 32, 'B', 1),
(174, 8, 3, 6, 33, 'C', 1),
(177, 8, 3, 6, 34, 'C', 1),
(178, 7, 3, 6, 56, 'A', 1),
(181, 7, 3, 6, 55, 'B', 1),
(184, 8, 3, 6, 35, 'A', 1),
(187, 8, 3, 6, 36, 'D', 1),
(190, 8, 3, 6, 37, 'D', 1),
(194, 8, 3, 6, 38, 'A', 0),
(197, 8, 3, 6, 39, 'D', 1),
(202, 8, 3, 6, 40, 'A', 1),
(207, 8, 3, 6, 41, 'D', 0),
(210, 8, 3, 6, 42, 'C', 1),
(212, 8, 3, 6, 43, 'A', 0),
(216, 8, 3, 6, 44, 'A', 1),
(221, 8, 3, 6, 45, 'A', 0),
(223, 8, 3, 6, 46, 'B', 1),
(226, 8, 3, 6, 47, 'A', 1),
(228, 8, 3, 6, 48, 'A', 1),
(229, 8, 3, 6, 49, 'C', 1),
(232, 8, 3, 6, 50, 'A', 1),
(233, 8, 3, 6, 51, 'C', 1),
(234, 8, 3, 6, 52, 'A', 0),
(235, 8, 3, 6, 53, 'D', 0),
(236, 8, 3, 6, 54, 'C', 1),
(237, 8, 3, 6, 55, 'D', 0),
(238, 8, 3, 6, 56, 'A', 1),
(414, 3, 10, 3, 10, 'B', 1),
(415, 3, 10, 3, 12, 'B', 0),
(416, 3, 10, 3, 14, 'C', 0),
(417, 3, 10, 3, 15, 'B', 0),
(418, 3, 10, 3, 16, 'A', 1),
(419, 3, 10, 3, 17, 'B', 1),
(420, 3, 10, 3, 18, 'B', 0),
(421, 3, 10, 3, 19, 'C', 1),
(422, 3, 10, 3, 11, 'B', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cbt_students_subjects`
--

CREATE TABLE IF NOT EXISTS `cbt_students_subjects` (
  `student_subj_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `subj_id` int(11) NOT NULL,
  PRIMARY KEY (`student_subj_id`),
  KEY `cand_id` (`student_id`),
  KEY `course_id` (`subj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_subjects`
--

CREATE TABLE IF NOT EXISTS `cbt_subjects` (
  `subj_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(50) NOT NULL,
  PRIMARY KEY (`subj_id`),
  UNIQUE KEY `course` (`subject`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `cbt_subjects`
--

INSERT INTO `cbt_subjects` (`subj_id`, `subject`) VALUES
(9, 'Basic Science'),
(5, 'Chemistry'),
(10, 'Civic Education'),
(3, 'Computer Studies'),
(2, 'English Language'),
(8, 'Further Mathematics'),
(6, 'Geography'),
(4, 'Government'),
(7, 'History'),
(1, 'Mathematics');

-- --------------------------------------------------------

--
-- Table structure for table `cbt_subjs_classes`
--

CREATE TABLE IF NOT EXISTS `cbt_subjs_classes` (
  `subj_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `subj_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `max_time` time DEFAULT NULL,
  PRIMARY KEY (`subj_class_id`),
  KEY `subj_id` (`subj_id`,`class_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `cbt_subjs_classes`
--

INSERT INTO `cbt_subjs_classes` (`subj_class_id`, `subj_id`, `class_id`, `max_time`) VALUES
(1, 7, 4, NULL),
(2, 7, 5, NULL),
(3, 7, 6, NULL),
(4, 8, 4, NULL),
(5, 8, 5, NULL),
(6, 8, 6, NULL),
(7, 2, 1, NULL),
(8, 2, 2, NULL),
(9, 2, 3, NULL),
(10, 2, 4, NULL),
(11, 2, 5, NULL),
(12, 2, 6, NULL),
(13, 5, 4, NULL),
(14, 5, 5, NULL),
(15, 5, 6, NULL),
(16, 1, 1, NULL),
(17, 1, 2, NULL),
(18, 1, 3, NULL),
(19, 1, 4, NULL),
(20, 1, 5, NULL),
(21, 1, 6, NULL),
(40, 3, 1, NULL),
(41, 3, 2, NULL),
(42, 3, 3, NULL),
(43, 3, 4, NULL),
(44, 3, 5, '01:30:00'),
(45, 3, 6, '00:05:00'),
(46, 6, 4, NULL),
(47, 6, 5, NULL),
(48, 6, 6, NULL),
(49, 4, 4, NULL),
(50, 4, 5, NULL),
(51, 4, 6, NULL),
(52, 9, 1, NULL),
(53, 9, 2, NULL),
(54, 9, 3, NULL),
(55, 10, 1, NULL),
(56, 10, 2, NULL),
(57, 10, 3, '00:15:00'),
(58, 10, 4, NULL),
(59, 10, 5, NULL),
(60, 10, 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cbt_users`
--

CREATE TABLE IF NOT EXISTS `cbt_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `hashed_password` varchar(40) NOT NULL,
  `hint` varchar(40) NOT NULL,
  `date_created` datetime NOT NULL,
  `creator_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cbt_users`
--

INSERT INTO `cbt_users` (`user_id`, `username`, `hashed_password`, `hint`, `date_created`, `creator_id`) VALUES
(1, 'admin', 'dd94709528bb1c83d08f3088d4043f4742891f4f', 'ad', '2016-02-09 16:23:56', 1),
(2, 'nero360', '167efa20c7389fa21a6527d8544aaaadaef9494c', 'Boss', '2016-02-09 16:24:21', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cbt_questions`
--
ALTER TABLE `cbt_questions`
  ADD CONSTRAINT `cbt_questions_ibfk_1` FOREIGN KEY (`subj_id`) REFERENCES `cbt_subjects` (`subj_id`),
  ADD CONSTRAINT `cbt_questions_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `cbt_classes` (`class_id`);

--
-- Constraints for table `cbt_results`
--
ALTER TABLE `cbt_results`
  ADD CONSTRAINT `cbt_results_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `cbt_students` (`student_id`),
  ADD CONSTRAINT `cbt_results_ibfk_2` FOREIGN KEY (`subj_id`) REFERENCES `cbt_subjects` (`subj_id`),
  ADD CONSTRAINT `cbt_results_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `cbt_classes` (`class_id`);

--
-- Constraints for table `cbt_students`
--
ALTER TABLE `cbt_students`
  ADD CONSTRAINT `cbt_students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `cbt_classes` (`class_id`),
  ADD CONSTRAINT `cbt_students_ibfk_2` FOREIGN KEY (`subj_id`) REFERENCES `cbt_subjects` (`subj_id`);

--
-- Constraints for table `cbt_students_answers`
--
ALTER TABLE `cbt_students_answers`
  ADD CONSTRAINT `cbt_students_answers_ibfk_2` FOREIGN KEY (`quest_id`) REFERENCES `cbt_questions` (`quest_id`),
  ADD CONSTRAINT `cbt_students_answers_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `cbt_students` (`student_id`),
  ADD CONSTRAINT `cbt_students_answers_ibfk_4` FOREIGN KEY (`class_id`) REFERENCES `cbt_classes` (`class_id`),
  ADD CONSTRAINT `cbt_students_answers_ibfk_5` FOREIGN KEY (`subj_id`) REFERENCES `cbt_subjects` (`subj_id`);

--
-- Constraints for table `cbt_students_subjects`
--
ALTER TABLE `cbt_students_subjects`
  ADD CONSTRAINT `cbt_students_subjects_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `cbt_students` (`student_id`),
  ADD CONSTRAINT `cbt_students_subjects_ibfk_2` FOREIGN KEY (`subj_id`) REFERENCES `cbt_subjects` (`subj_id`);

--
-- Constraints for table `cbt_subjs_classes`
--
ALTER TABLE `cbt_subjs_classes`
  ADD CONSTRAINT `cbt_subjs_classes_ibfk_1` FOREIGN KEY (`subj_id`) REFERENCES `cbt_subjects` (`subj_id`),
  ADD CONSTRAINT `cbt_subjs_classes_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `cbt_classes` (`class_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
