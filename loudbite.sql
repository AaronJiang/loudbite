-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 26, 2012 at 01:52 PM
-- Server version: 5.1.62
-- PHP Version: 5.3.10-1ubuntu2ppa6~lucid

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `loudbite`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(20) NOT NULL,
  `status` varchar(10) DEFAULT 'pending',
  `email_newsletter_status` varchar(3) DEFAULT 'out',
  `email_type` varchar(4) DEFAULT 'text',
  `email_favorite_artists_status` varchar(3) DEFAULT 'out',
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `email`, `password`, `status`, `email_newsletter_status`, `email_type`, `email_favorite_artists_status`, `created_date`) VALUES
(1, 'Aaron', 'aaron@loudbite.com', '123', 'active', 'out', 'text', 'out', '2012-10-24 14:37:38'),
(2, 'Sandy', 'sandy@loudbite.com', '123', 'active', 'out', 'text', 'out', NULL),
(3, 'Wendy', 'wendy@loudbite.com', '123', 'active', 'out', 'text', 'out', '2012-10-24 15:10:58'),
(4, 'salaros', 'salar@gmail.com', '123456', 'pending', 'out', 'text', 'out', '2012-10-24 15:36:42'),
(6, 'aaron.jiang', 'aaron.jijesoft@gmail.com', 'jijesoft', 'active', 'out', 'text', 'out', '2012-11-06 15:08:08');

-- --------------------------------------------------------

--
-- Table structure for table `accounts_artists`
--

CREATE TABLE IF NOT EXISTS `accounts_artists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `rating` int(1) DEFAULT NULL,
  `is_fav` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `accounts_artists`
--

INSERT INTO `accounts_artists` (`id`, `account_id`, `artist_id`, `created_date`, `rating`, `is_fav`) VALUES
(1, 10, 1, '2012-10-24 16:01:11', 3, 1),
(2, 10, 2, '2012-10-24 16:05:19', 4, 1),
(3, 10, 3, '2012-10-31 17:30:20', 3, 1),
(4, 1, 6, '2012-10-31 17:37:15', 4, 1),
(5, 1, 10, '2012-11-01 14:08:07', 3, 1),
(6, 1, 11, '2012-11-01 14:11:31', 3, 1),
(7, 1, 12, '2012-11-01 14:17:45', 3, 1),
(8, 1, 13, '2012-11-01 14:18:07', 3, 1),
(9, 1, 14, '2012-11-01 14:18:16', 3, 1),
(10, 1, 15, '2012-11-01 14:18:19', 3, 1),
(11, 1, 16, '2012-11-01 14:19:33', 3, 1),
(12, 1, 17, '2012-11-01 14:19:45', 4, 1),
(13, 1, 18, '2012-11-01 14:20:18', 4, 1),
(14, 1, 19, '2012-11-01 14:20:29', 5, 1),
(15, 0, 20, '2012-11-01 14:24:07', 4, 1),
(16, 0, 21, '2012-11-01 14:24:30', 5, 1),
(17, 0, 22, '2012-11-01 14:27:21', 5, 1),
(18, 0, 23, '2012-11-01 14:28:52', 5, 1),
(19, 1, 24, '2012-11-01 14:30:26', 4, 1),
(20, 1, 27, '2012-11-02 13:15:24', 3, 0),
(21, 1, 28, '2012-11-02 13:15:39', 2, 0),
(22, 1, 29, '2012-11-02 13:16:37', 4, 1),
(23, 1, 31, '2012-11-26 13:22:33', 5, 1),
(24, 1, 32, '2012-11-26 13:24:06', 5, 1),
(25, 1, 33, '2012-11-26 13:26:39', 4, 1),
(26, 1, 34, '2012-11-26 13:27:47', 5, 1),
(27, 1, 35, '2012-11-26 13:28:57', 5, 1),
(28, 2, 36, '2012-11-26 13:29:58', 5, 1),
(29, 2, 37, '2012-11-26 13:31:38', 5, 1),
(30, 2, 38, '2012-11-26 13:32:17', 5, 1),
(31, 2, 39, '2012-11-26 13:33:12', 5, 1),
(32, 2, 40, '2012-11-26 13:33:46', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE IF NOT EXISTS `artists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_name` varchar(200) NOT NULL,
  `genre` varchar(100) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `artist_name`, `genre`, `created_date`) VALUES
(39, 'Justin Timberlake', 'pop', '2012-11-26 13:33:12'),
(38, 'Katy Perry', 'pop', '2012-11-26 13:32:17'),
(37, 'Black Eyed Peas', 'r_n_b', '2012-11-26 13:31:38'),
(28, 'Justin Biber', 'pop', '2012-11-02 13:15:39'),
(36, 'p!nk', 'rock', '2012-11-26 13:29:58'),
(33, 'Mariah Carey', 'hip_hop', '2012-11-26 13:26:39'),
(34, 'Maroon5', 'electronic', '2012-11-26 13:27:47'),
(35, 'Avril Lavigne', 'hip_hop', '2012-11-26 13:28:57'),
(32, 'Michael Jackson', 'r_n_b', '2012-11-26 13:24:06'),
(29, 'Lady gaga', 'pop', '2012-11-02 13:16:37'),
(31, 'The Beatles', 'country', '2012-11-26 13:22:33'),
(40, 'John Lennon', 'hip_hop', '2012-11-26 13:33:46');
