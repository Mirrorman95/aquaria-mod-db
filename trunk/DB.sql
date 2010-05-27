-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 27, 2010 at 02:42 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `aqmoddb`
--

-- --------------------------------------------------------

--
-- Table structure for table `mods`
--
-- Creation: May 26, 2010 at 07:44 PM
-- Last update: May 26, 2010 at 08:06 PM
--

DROP TABLE IF EXISTS `mods`;
CREATE TABLE IF NOT EXISTS `mods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mname` varchar(25) NOT NULL,
  `aname` varchar(40) NOT NULL,
  `mpicture` varchar(4) DEFAULT NULL,
  `mfile` varchar(25) NOT NULL,
  `mdesc` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mext` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mods`
--

INSERT INTO `mods` (`id`, `mname`, `aname`, `mpicture`, `mfile`, `mdesc`, `date`, `mext`) VALUES
(1, 'Costumes Mod', 'Alphasoldier', 'png', 'baaab', ' A small mod where you can wear every costumes, there is also a new one', '2010-05-25 23:53:20', ''),
(2, 'Angry Li', 'Yogoda', 'png', 'caaab', 'A Shoot''em Up game where you control Li''s submarine.', '2010-05-26 00:23:10', ''),
(3, 'Jukebox v1.5b1', 'Dolphin''s Cry', 'jpg', 'daaab', 'This mod allows you to browse through and listen to the songs from the game''s main content. "Prev" and "Next" cycle through the list of songs, "Rand" goes to a randomly chosen song, and "Exit" returns you to the title screen.', '2010-05-26 00:27:10', ''),
(4, 'Beauty of Aquaria v1.0.5', 'Yogoda', 'png', 'eaaab', 'A map based on the veil where you can enjoy the beauty of Aquaria<br />\r\nNo combats, no violence, only peaceful creatures.<br />\r\nPlay with dauphins and waterfalls in a beautiful sunset.', '2010-05-26 20:05:57', 'rar');
