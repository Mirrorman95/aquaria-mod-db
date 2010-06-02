-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 02, 2010 at 12:27 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aqmoddb`
--

-- --------------------------------------------------------

--
-- Table structure for table `mods`
--
-- Creation: May 26, 2010 at 07:44 PM
-- Last update: May 29, 2010 at 12:17 PM
--

DROP TABLE IF EXISTS `mods`;
CREATE TABLE `mods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mname` varchar(25) NOT NULL,
  `aname` varchar(40) NOT NULL,
  `mpicture` varchar(4) DEFAULT NULL,
  `mfile` varchar(25) NOT NULL,
  `mdesc` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mext` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mods`
--

INSERT INTO `mods` (`id`, `mname`, `aname`, `mpicture`, `mfile`, `mdesc`, `date`, `mext`) VALUES
(1, 'Costumes Mod', 'Alphasoldier', 'png', 'CostumeMod', ' A small mod where you can wear every costumes, there is also a new one', '2010-05-25 23:53:20', 'zip'),
(2, 'Angry Li', 'Yogoda', 'png', 'AngryLi', 'A Shoot''em Up game where you control Li''s submarine.', '2010-05-26 00:23:10', 'zip'),
(3, 'Jukebox v1.5b1', 'Dolphin''s Cry', 'jpg', 'Jukebox', 'This mod allows you to browse through and listen to the songs from the game''s main content. "Prev" and "Next" cycle through the list of songs, "Rand" goes to a randomly chosen song, and "Exit" returns you to the title screen.', '2010-05-26 00:27:10', 'zip'),
(4, 'Beauty of Aquaria v1.0.5', 'Yogoda', 'png', 'BeautyofAquaria', 'A map based on the veil where you can enjoy the beauty of Aquaria<br />\r\nNo combats, no violence, only peaceful creatures.<br />\r\nPlay with dauphins and waterfalls in a beautiful sunset.', '2010-05-26 20:05:57', 'rar'),
(5, 'Sacrifice', 'TheBear', 'jpg', 'Sacrifice', 'Aquaria: Sacrifice is an extensive, narrative driven prequel campaign with roughly 5 hours of content. The story is told through a classic adventure dialogue system, around 18,000 words in length, focusing on Princess Elena during the final days of Mithalas.<br />\r\n- 20+ new maps / vendors / arena system', '2010-05-28 22:04:55', 'zip');
