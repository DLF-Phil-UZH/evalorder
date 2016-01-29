-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 29. Jan 2016 um 01:28
-- Server Version: 5.5.46-log
-- PHP-Version: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `elk`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `eva_courses`
--

CREATE TABLE IF NOT EXISTS `eva_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `type` varchar(50) NOT NULL,
  `surveyType` varchar(50) NOT NULL COMMENT '"onlineumfrage" or "papierumfrage"',
  `language` varchar(50) DEFAULT NULL,
  `turnout` int(11) DEFAULT NULL,
  `ordererFirstname` varchar(100) NOT NULL COMMENT 'AAI attribute',
  `ordererSurname` varchar(100) NOT NULL COMMENT 'AAI attribute',
  `ordererEmail` varchar(100) NOT NULL COMMENT 'AAI attribute',
  `ordererUniqueId` varchar(50) NOT NULL COMMENT 'AAI attribute',
  `orderTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `participantFile1` varchar(100) DEFAULT NULL COMMENT 'Name of first Excel file containing participant addresses',
  `participantFile2` varchar(100) DEFAULT NULL COMMENT 'Name of second Excel file containing participant addresses',
  `lastExport` timestamp NULL DEFAULT NULL COMMENT 'Timestamp of last export to an XML file',
  `semester` char(10) NOT NULL COMMENT '"FS <YEAR>" or "HS <YEAR>" (e. g. "HS 2015", "FS 2016")',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=277 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `eva_courses_lecturers`
--

CREATE TABLE IF NOT EXISTS `eva_courses_lecturers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lecturer_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=403 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `eva_lecturers`
--

CREATE TABLE IF NOT EXISTS `eva_lecturers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `gender` char(1) NOT NULL COMMENT '"m" or "f"',
  `title` varchar(50) DEFAULT NULL COMMENT 'optional',
  `email` varchar(100) NOT NULL,
  `courseId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=306 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `eva_participants`
--

CREATE TABLE IF NOT EXISTS `eva_participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `courseId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
