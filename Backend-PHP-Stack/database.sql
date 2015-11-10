-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Host: db599367450.db.1and1.com
-- Generation Time: Nov 04, 2015 at 01:03 PM
-- Server version: 5.1.73-log
-- PHP Version: 5.4.45-0+deb7u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db599367450`
--

-- --------------------------------------------------------

--
-- Table structure for table `error_log`
--

CREATE TABLE IF NOT EXISTS `error_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `level` int(11) NOT NULL,
  `filename` varchar(127) NOT NULL,
  `classname` varchar(63) NOT NULL,
  `functionname` varchar(63) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `caption` varchar(160) COLLATE latin1_german2_ci NOT NULL,
  `filename` varchar(100) COLLATE latin1_german2_ci NOT NULL,
  `mediatype` varchar(20) COLLATE latin1_german2_ci NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `size` int(11) NOT NULL COMMENT 'byte',
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `public` tinyint(1) NOT NULL COMMENT '0=false, 1=true',
  `verified` tinyint(1) NOT NULL COMMENT '0=false, 1=true',
  `length` int(11) NOT NULL COMMENT 'sec',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(2) COLLATE latin1_german2_ci NOT NULL,
  `msg` text COLLATE latin1_german2_ci NOT NULL,
  `language` varchar(2) COLLATE latin1_german2_ci NOT NULL DEFAULT 'DE' COMMENT 'DE, EN',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(127) NOT NULL,
  `email` varchar(127) NOT NULL,
  `email_notification_flag` int(1) NOT NULL,
  `password` varchar(127) NOT NULL,
  `token` varchar(127) NOT NULL,
  `last_ip` varchar(127) NOT NULL,
  `last_login` int(11) NOT NULL,
  `permission` int(2) NOT NULL COMMENT '0=Read, 1=R&W, 2=Mod, 3=Admin',
  PRIMARY KEY (`id`),
  KEY `email` (`email`,`token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `user` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
