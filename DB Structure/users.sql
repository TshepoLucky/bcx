-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2019 at 01:12 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `d2rks1d3r`
--

CREATE DATABASE `d2rks1d3r`;

USE `d2rks1d3r`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `salt` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `joined` datetime DEFAULT NULL,
  `group` int(11) NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `surname`  varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cell` varchar(10) NOT NULL,
  `address` varchar(200) NULL DEFAULT NULL,
  `jobtitle` varchar(100) NULL DEFAULT NULL,
  UNIQUE (`username`),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

CREATE INDEX `users_index`
ON users (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


COMMIT;