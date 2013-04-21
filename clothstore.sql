-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2013 at 06:38 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `clothstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `blank`
--

CREATE TABLE IF NOT EXISTS `blank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

CREATE TABLE IF NOT EXISTS `captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `captcha_time` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `word` varchar(20) NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `mobile` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `pan_no` varchar(45) NOT NULL,
  `service_tax_no` varchar(45) NOT NULL,
  `compniescol` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE IF NOT EXISTS `parties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`id`, `name`, `address`, `contact`) VALUES
(1, 'Mayur', 'sadas', '9998574979'),
(2, 'Nimesh', '54645465', '4564654');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `category` varchar(45) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `active`) VALUES
(1, 'Levis Jeans 32 Blue', 'Jeans', 1),
(2, 'Spykar Jeans Black', 'Jeans', 1),
(3, 'Tee Sypkar R215', 'T-Shirt', 1),
(4, 'Levis 512', 'T-Shirt', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE IF NOT EXISTS `purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `bill_no` varchar(20) NOT NULL,
  `amount` double NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `recieved` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_purchases_parties1` (`party_id`),
  KEY `fk_purchases_companies1` (`company_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `company_id`, `party_id`, `date`, `bill_no`, `amount`, `image`, `recieved`) VALUES
(1, 0, 1, '2013-04-14', '1', 80000, NULL, 0),
(2, 0, 1, '2013-04-16', '123', 12330, NULL, 0),
(3, 0, 1, '2013-04-17', '1235', 80000, NULL, 1),
(4, 0, 1, '2013-04-17', '123456', 8000, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE IF NOT EXISTS `purchase_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `mrp` double NOT NULL,
  `purchase_price` double NOT NULL,
  `quantity` double NOT NULL,
  `sold` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_purchase_details_purchases1` (`purchase_id`),
  KEY `fk_purchase_details_products1` (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_id`, `barcode`, `mrp`, `purchase_price`, `quantity`, `sold`, `product_id`) VALUES
(1, 1, 'LJB32', 2200, 1200, 30, 1, 1),
(2, 1, 'LT512', 3200, 900, 30, 1, 4),
(3, 2, 'TSR215', 900, 400, 200, 1, 3),
(4, 2, 'SJB32', 1300, 700, 20, 1, 2),
(5, 4, 'LJB32', 800, 500, 20, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `party_name` varchar(255) NOT NULL,
  `party_contact` varchar(10) NOT NULL,
  `type` enum('Estimate','Invoice') NOT NULL DEFAULT 'Estimate',
  `id2` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `less` double NOT NULL,
  `amount` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sales_parties1` (`party_contact`),
  KEY `fk_sales_companies1` (`company_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `company_id`, `party_name`, `party_contact`, `type`, `id2`, `datetime`, `less`, `amount`) VALUES
(1, 1, 'Mayur Taunk', '9998574979', '', 1, '2013-04-14 14:41:24', 0, 7600),
(2, 1, 'Mayur Taunk', '9998574979', '', 2, '2013-04-14 20:06:23', 0, 158800),
(45, 1, '', '', '', 3, '2013-04-19 10:00:33', 0, 0),
(46, 1, '', '', '', 4, '2013-04-19 10:01:55', 0, 0),
(47, 1, '', '', '', 5, '2013-04-19 10:03:19', 0, 0),
(48, 1, '', '', '', 6, '2013-04-19 10:03:41', 0, 0),
(49, 1, '', '', '', 49, '2013-04-19 10:04:09', 0, 0),
(50, 1, '', '', '', 50, '2013-04-19 10:06:16', 0, 0),
(51, 1, '', '', '', 51, '2013-04-19 10:06:57', 0, 0),
(52, 1, '', '', '', 52, '2013-04-19 10:08:52', 0, 0),
(53, 1, '', '', '', 53, '2013-04-19 10:09:25', 0, 0),
(54, 1, '', '', '', 54, '2013-04-19 10:10:31', 0, 0),
(55, 1, '', '', '', 55, '2013-04-19 10:11:13', 0, 0),
(56, 1, '', '', '', 56, '2013-04-19 10:12:16', 0, 800),
(57, 1, '', '', '', 57, '2013-04-19 10:13:05', 0, 2200),
(58, 1, '', '', '', 58, '2013-04-19 10:13:51', 0, 0),
(59, 1, '', '', '', 59, '2013-04-19 10:14:25', 0, 0),
(60, 1, '', '', '', 60, '2013-04-19 10:26:47', 0, 0),
(61, 1, '', '', '', 61, '2013-04-19 10:32:51', 0, 1600),
(62, 1, '', '', '', 62, '2013-04-19 10:42:37', 0, 3200),
(63, 1, '', '', '', 63, '2013-04-19 17:39:37', 0, 209200);

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE IF NOT EXISTS `sale_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `purchase_detail_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `quantity` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_details_purchase_details1` (`purchase_detail_id`),
  KEY `fk_sale_details_sales1` (`sale_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `sale_details`
--

INSERT INTO `sale_details` (`id`, `sale_id`, `purchase_detail_id`, `price`, `quantity`) VALUES
(1, 1, 1, 4400, 2),
(2, 1, 2, 3200, 1),
(3, 2, 1, 61600, 26),
(4, 2, 2, 92800, 28),
(44, 63, 3, 180000, 200),
(54, 63, 2, 3200, 1),
(42, 63, 4, 26000, 20),
(60, 63, 5, 16000, 20),
(59, 63, 1, 4400, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `fullname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `status` enum('Active','Suspended','Disabled') NOT NULL DEFAULT 'Active',
  `last_modified` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created`, `username`, `password`, `fullname`, `email`, `status`, `last_modified`, `last_login`) VALUES
(3, '2013-03-22 08:11:38', 'admin', 'c4f4b2eb6d63dd4dd8afed001c61c956', 'mayur taunk', 'mayur@gmail.com', 'Active', '2013-03-22 17:43:47', '2013-03-22 14:41:27'),
(4, '2013-03-24 10:45:14', 'mayur', '99', '', 'mayurtaunk@gmail.com', 'Active', '0000-00-00 00:00:00', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
