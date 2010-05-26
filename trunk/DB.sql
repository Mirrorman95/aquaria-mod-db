-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 26, 2010 at 06:29 AM
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

CREATE TABLE IF NOT EXISTS `mods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mname` varchar(25) NOT NULL,
  `aname` varchar(40) NOT NULL,
  `mpicture` varchar(4) DEFAULT NULL,
  `mfile` varchar(25) NOT NULL,
  `mdesc` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mods`
--

INSERT INTO `mods` (`id`, `mname`, `aname`, `mpicture`, `mfile`, `mdesc`, `date`) VALUES
(1, 'Costumes Mod', 'Alphasoldier', 'png', 'baaab', ' A small mod where you can wear every costumes, there is also a new one', '2010-05-25 23:53:20'),
(2, 'Angry Li', 'Yogoda', 'png', 'caaab', 'A Shoot''em Up game where you control Li''s submarine.', '2010-05-26 00:23:10'),
(3, 'Jukebox v1.5b1', 'Dolphin''s Cry', 'jpg', 'daaab', 'This mod allows you to browse through and listen to the songs from the game''s main content. "Prev" and "Next" cycle through the list of songs, "Rand" goes to a randomly chosen song, and "Exit" returns you to the title screen.', '2010-05-26 00:27:10');
