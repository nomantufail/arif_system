-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2015 at 10:08 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `name`, `role`) VALUES
(2, 'test', '123', 'Test User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'H.M.Hussain', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'M.Aslam.Agency', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'Zafar Patwari', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, 'Haider f/s', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, 'Safdar Lahore', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(6, 'Rana Asif', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(7, 'Saith Riaz', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(8, 'Rehmat f/s', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(9, 'Sajid Zafarwal', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(10, 'M.Aslam Admore', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(11, 'Roy M.Aslam Kaleki', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(12, 'Qaisar Panwan', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(13, 'other', '', '', '2015-08-06 19:39:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `expense_titles`
--

CREATE TABLE IF NOT EXISTS `expense_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `payments_view`
--
CREATE TABLE IF NOT EXISTS `payments_view` (
`voucher_id` int(11)
,`voucher_date` date
,`summary` varchar(250)
,`account` varchar(100)
,`agent` varchar(100)
,`agent_type` varchar(8)
,`entry_id` int(11)
,`amount` double
);
-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `inserted_at`, `updated_at`) VALUES
(1, 'HSD', 'High speed deisel', '2015-06-04 10:12:59', '0000-00-00 00:00:00'),
(2, 'PMG', 'Premier Motor Gasoline', '2015-06-04 10:13:08', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `router`
--

CREATE TABLE IF NOT EXISTS `router` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller` varchar(100) NOT NULL,
  `function` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `router`
--

INSERT INTO `router` (`id`, `controller`, `function`) VALUES
(1, 'customers', 'all'),
(2, 'products', 'show'),
(3, 'purchases', 'credit_purchase'),
(4, 'sales', 'add_freight_sale'),
(5, 'stock', 'show'),
(6, 'accounts', 'index'),
(7, 'reports', 'daily'),
(8, 'suppliers', 'all'),
(9, 'settings', 'accounts'),
(10, 'payments', 'make'),
(11, 'daybook', 'summary'),
(12, 'receipts', 'history'),
(13, 'admin', 'payments_view'),
(14, 'tankers', 'all'),
(15, 'expenses', 'titles'),
(16, 'withdrawls', 'withdraw'),
(17, 'source_destination', 'show'),
(18, 'ledgers', 'customers');

-- --------------------------------------------------------

--
-- Stand-in structure for view `route_sales_view`
--
CREATE TABLE IF NOT EXISTS `route_sales_view` (
`invoice_id` int(11)
,`date` date
,`summary` varchar(250)
,`tanker` varchar(100)
,`entry_id` int(11)
,`freight` double
,`source` varchar(100)
,`destination` varchar(100)
);
-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL DEFAULT '0',
  `tanker` varchar(100) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `price_per_unit` double NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `product_id`, `quantity`, `tanker`, `purchase_id`, `price_per_unit`, `updated_at`) VALUES
(1, 1, 50000, '00000', 16, 82.5, '2015-08-07 00:48:12'),
(2, 2, 0, '00000', 0, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `inerted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `address`, `inerted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'Irfan Virik SB', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'Ch.Mukhtar Patoki', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'other', '', '', '2015-08-06 19:39:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tankers`
--

CREATE TABLE IF NOT EXISTS `tankers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `number` varchar(100) NOT NULL,
  `capacity` double NOT NULL,
  `chambers` tinyint(4) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tankers`
--

INSERT INTO `tankers` (`id`, `name`, `number`, `capacity`, `chambers`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'other', '00000', 40000, 5, '2015-08-06 19:38:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_accounts`
--

CREATE TABLE IF NOT EXISTS `user_bank_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `bank` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_bank_accounts`
--

INSERT INTO `user_bank_accounts` (`id`, `title`, `account_number`, `bank`, `type`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'noman', '123456789', 'alflah', 'current', '2015-08-06 18:16:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE IF NOT EXISTS `vouchers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_date` date NOT NULL,
  `summary` varchar(250) NOT NULL,
  `tanker` varchar(100) NOT NULL,
  `voucher_type` varchar(100) NOT NULL,
  `product_sale_id` int(11) NOT NULL,
  `product_for_freight_voucher` varchar(100) NOT NULL,
  `product_number_for_freight_voucher` int(11) NOT NULL DEFAULT '0',
  `bank_ac` varchar(100) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `voucher_date`, `summary`, `tanker`, `voucher_type`, `product_sale_id`, `product_for_freight_voucher`, `product_number_for_freight_voucher`, `bank_ac`, `inserted_at`, `deleted_at`, `updated_at`, `deleted`) VALUES
(1, '2015-08-06', 'opening balance H.M.Hussain', '', 'opening_balance', 0, '', 0, '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, '2015-08-06', 'opening balance M.Aslam.Agency', '', 'opening_balance', 0, '', 0, '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, '2015-08-06', 'opening balance Zafar Patwari', '', 'opening_balance', 0, '', 0, '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, '2015-08-06', 'opening balance Haider f/s', '', 'opening_balance', 0, '', 0, '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, '2015-08-06', 'opening balance Safdar Lahore', '', 'opening_balance', 0, '', 0, '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(6, '2015-08-06', 'opening balance Rana Asif', '', 'opening_balance', 0, '', 0, '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(7, '2015-08-06', 'opening balance Saith Riaz', '', 'opening_balance', 0, '', 0, '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(8, '2015-08-06', 'opening balance Rehmat f/s', '', 'opening_balance', 0, '', 0, '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(9, '2015-08-06', 'opening balance Sajid Zafarwal', '', 'opening_balance', 0, '', 0, '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(10, '2015-08-06', 'opening balance M.Aslam Admore', '', 'opening_balance', 0, '', 0, '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(11, '2015-08-06', 'opening balance Roy M.Aslam Kaleki', '', 'opening_balance', 0, '', 0, '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(12, '2015-08-06', 'opening balance Qaisar Panwan', '', 'opening_balance', 0, '', 0, '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(13, '2015-08-06', 'opening balance Irfan Virik SB', '', 'opening_balance', 0, '', 0, '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(14, '2015-08-06', 'opening balance Ch.Mukhtar Patoki', '', 'opening_balance', 0, '', 0, '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(15, '2015-08-06', '', '00000', 'purchase', 0, '', 0, '', '2015-08-06 19:46:06', '2015-08-07 00:47:50', '0000-00-00 00:00:00', 1),
(16, '2015-08-06', '', '00000', 'purchase', 0, '', 0, '', '2015-08-06 19:48:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(20, '2015-08-09', '', '', 'payment', 0, '', 0, '', '2015-08-09 05:00:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(21, '2015-08-09', '', '', 'payment', 0, '', 0, 'noman (alflah 12****789)', '2015-08-09 05:17:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(22, '2015-08-09', '', '', 'payment', 0, '', 0, '', '2015-08-09 06:09:01', '2015-08-09 11:09:06', '0000-00-00 00:00:00', 1),
(23, '2015-08-09', '', '', 'payment', 0, '', 0, '', '2015-08-09 19:13:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(24, '2015-08-09', '', '', 'payment', 0, '', 0, '', '2015-08-09 19:14:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(25, '2015-08-09', '', '', 'payment', 0, '', 0, 'noman (alflah 12****789)', '2015-08-09 19:14:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(26, '2015-08-09', '', '', 'payment', 0, '', 0, '', '2015-08-09 19:42:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `voucher_entries`
--

CREATE TABLE IF NOT EXISTS `voucher_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL DEFAULT '0',
  `ac_title` varchar(100) NOT NULL,
  `ac_sub_title` varchar(100) NOT NULL,
  `ac_type` varchar(100) NOT NULL,
  `related_customer` varchar(100) NOT NULL,
  `related_supplier` varchar(100) NOT NULL,
  `related_business` varchar(100) NOT NULL,
  `related_other_agent` varchar(100) NOT NULL,
  `related_tanker` varchar(100) NOT NULL,
  `quantity` double NOT NULL,
  `cost_per_item` double NOT NULL,
  `purchase_price_per_item_for_sale` double NOT NULL DEFAULT '0',
  `amount` double NOT NULL,
  `freight` double NOT NULL DEFAULT '0',
  `source` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `dr_cr` tinyint(4) NOT NULL,
  `description` text NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `voucher_entries`
--

INSERT INTO `voucher_entries` (`id`, `voucher_id`, `item_id`, `ac_title`, `ac_sub_title`, `ac_type`, `related_customer`, `related_supplier`, `related_business`, `related_other_agent`, `related_tanker`, `quantity`, `cost_per_item`, `purchase_price_per_item_for_sale`, `amount`, `freight`, `source`, `destination`, `dr_cr`, `description`, `deleted_at`, `deleted`) VALUES
(1, 1, 0, 'H.M.Hussain', 'opening balance', 'receivable', 'H.M.Hussain', '', '', '', '', 0, 0, 0, 1362928, 0, '', '', 1, 'opening balance H.M.Hussain', '0000-00-00 00:00:00', 0),
(2, 1, 0, 'capital account', 'opening balance', 'capital', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1362928, 0, '', '', 0, 'opening balance H.M.Hussain', '0000-00-00 00:00:00', 0),
(3, 2, 0, 'M.Aslam.Agency', 'opening balance', 'receivable', 'M.Aslam.Agency', '', '', '', '', 0, 0, 0, 2187146, 0, '', '', 1, 'opening balance M.Aslam.Agency', '0000-00-00 00:00:00', 0),
(4, 2, 0, 'capital account', 'opening balance', 'capital', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 2187146, 0, '', '', 0, 'opening balance M.Aslam.Agency', '0000-00-00 00:00:00', 0),
(5, 3, 0, 'Zafar Patwari', 'opening balance', 'receivable', 'Zafar Patwari', '', '', '', '', 0, 0, 0, 710400, 0, '', '', 1, 'opening balance Zafar Patwari', '0000-00-00 00:00:00', 0),
(6, 3, 0, 'capital account', 'opening balance', 'capital', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 710400, 0, '', '', 0, 'opening balance Zafar Patwari', '0000-00-00 00:00:00', 0),
(7, 4, 0, 'Haider f/s', 'opening balance', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 666504, 0, '', '', 1, 'opening balance Haider f/s', '0000-00-00 00:00:00', 0),
(8, 4, 0, 'capital account', 'opening balance', 'capital', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 666504, 0, '', '', 0, 'opening balance Haider f/s', '0000-00-00 00:00:00', 0),
(9, 5, 0, 'Safdar Lahore', 'opening balance', 'receivable', 'Safdar Lahore', '', '', '', '', 0, 0, 0, 823680, 0, '', '', 1, 'opening balance Safdar Lahore', '0000-00-00 00:00:00', 0),
(10, 5, 0, 'capital account', 'opening balance', 'capital', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 823680, 0, '', '', 0, 'opening balance Safdar Lahore', '0000-00-00 00:00:00', 0),
(11, 6, 0, 'Rana Asif', 'opening balance', 'receivable', 'Rana Asif', '', '', '', '', 0, 0, 0, 2000000, 0, '', '', 0, 'opening balance Rana Asif', '0000-00-00 00:00:00', 0),
(12, 6, 0, 'capital account', 'opening balance', 'capital', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 2000000, 0, '', '', 1, 'opening balance Rana Asif', '0000-00-00 00:00:00', 0),
(13, 7, 0, 'Saith Riaz', 'opening balance', 'receivable', 'Saith Riaz', '', '', '', '', 0, 0, 0, 1072000, 0, '', '', 0, 'opening balance Saith Riaz', '0000-00-00 00:00:00', 0),
(14, 7, 0, 'capital account', 'opening balance', 'capital', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1072000, 0, '', '', 1, 'opening balance Saith Riaz', '0000-00-00 00:00:00', 0),
(15, 8, 0, 'Rehmat f/s', 'opening balance', 'receivable', 'Rehmat f/s', '', '', '', '', 0, 0, 0, 1000000, 0, '', '', 1, 'opening balance Rehmat f/s', '0000-00-00 00:00:00', 0),
(16, 8, 0, 'capital account', 'opening balance', 'capital', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1000000, 0, '', '', 0, 'opening balance Rehmat f/s', '0000-00-00 00:00:00', 0),
(17, 9, 0, 'Sajid Zafarwal', 'opening balance', 'receivable', 'Sajid Zafarwal', '', '', '', '', 0, 0, 0, 2023250, 0, '', '', 0, 'opening balance Sajid Zafarwal', '0000-00-00 00:00:00', 0),
(18, 9, 0, 'capital account', 'opening balance', 'capital', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 2023250, 0, '', '', 1, 'opening balance Sajid Zafarwal', '0000-00-00 00:00:00', 0),
(19, 10, 0, 'M.Aslam Admore', 'opening balance', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 1619000, 0, '', '', 1, 'opening balance M.Aslam Admore', '0000-00-00 00:00:00', 0),
(20, 10, 0, 'capital account', 'opening balance', 'capital', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1619000, 0, '', '', 0, 'opening balance M.Aslam Admore', '0000-00-00 00:00:00', 0),
(21, 11, 0, 'Roy M.Aslam Kaleki', 'opening balance', 'receivable', 'Roy M.Aslam Kaleki', '', '', '', '', 0, 0, 0, 76500, 0, '', '', 1, 'opening balance Roy M.Aslam Kaleki', '0000-00-00 00:00:00', 0),
(22, 11, 0, 'capital account', 'opening balance', 'capital', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 76500, 0, '', '', 0, 'opening balance Roy M.Aslam Kaleki', '0000-00-00 00:00:00', 0),
(23, 12, 0, 'Qaisar Panwan', 'opening balance', 'receivable', 'Qaisar Panwan', '', '', '', '', 0, 0, 0, 61000, 0, '', '', 1, 'opening balance Qaisar Panwan', '0000-00-00 00:00:00', 0),
(24, 12, 0, 'capital account', 'opening balance', 'capital', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 61000, 0, '', '', 0, 'opening balance Qaisar Panwan', '0000-00-00 00:00:00', 0),
(25, 13, 0, 'Irfan Virik SB', 'opening balance', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 2078776, 0, '', '', 0, 'opening balance Irfan Virik SB', '0000-00-00 00:00:00', 0),
(26, 13, 0, 'capital account', 'opening balance', 'capital', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 2078776, 0, '', '', 1, 'opening balance Irfan Virik SB', '0000-00-00 00:00:00', 0),
(27, 14, 0, 'Ch.Mukhtar Patoki', 'opening balance', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 0, 0, 0, 440379, 0, '', '', 1, 'opening balance Ch.Mukhtar Patoki', '0000-00-00 00:00:00', 0),
(28, 14, 0, 'capital account', 'opening balance', 'capital', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 440379, 0, '', '', 0, 'opening balance Ch.Mukhtar Patoki', '0000-00-00 00:00:00', 0),
(29, 15, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 50000, 82.5, 0, 4125000, 0, '', '', 1, '', '2015-08-07 00:47:50', 1),
(30, 15, 1, 'HSD', '', 'payable', '', 'other', '', '', '', 50000, 82.5, 0, 4125000, 0, '', '', 0, '', '2015-08-07 00:47:50', 1),
(31, 16, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 50000, 82.5, 0, 4125000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(32, 16, 1, 'HSD', '', 'payable', '', 'other', '', '', '', 50000, 82.5, 0, 4125000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(34, 17, 0, 'noman (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 0, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(36, 18, 0, '', '', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 0, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(37, 19, 0, 'payment', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 0, 0, 0, 1000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(38, 19, 0, 'cash', '', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(39, 20, 0, 'payment', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 0, 0, 0, 2000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(40, 20, 0, 'cash', '', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 2000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(41, 21, 0, 'payment', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 0, 0, 0, 1000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(42, 21, 0, 'noman (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(43, 22, 0, 'payment', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 0, 0, 0, 3000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(44, 22, 0, 'cash', '', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 3000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(45, 23, 0, 'payment', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 0, 0, 0, 4444, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(46, 23, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 4444, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(47, 24, 0, 'payment', '', 'receivable', 'H.M.Hussain', '', '', '', '', 0, 0, 0, 5555, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(48, 24, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 5555, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(49, 25, 0, 'payment', '', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 0, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(50, 25, 0, 'noman (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 0, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(51, 26, 0, 'payment', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 0, 0, 0, 5555, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(52, 26, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 5555, 0, '', '', 0, '', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_accounts`
--

CREATE TABLE IF NOT EXISTS `withdraw_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `withdraw_accounts`
--

INSERT INTO `withdraw_accounts` (`id`, `title`, `description`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'Personal Account', '', '2015-05-06 16:08:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Structure for view `payments_view`
--
DROP TABLE IF EXISTS `payments_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `payments_view` AS select `vouchers`.`id` AS `voucher_id`,`vouchers`.`voucher_date` AS `voucher_date`,`vouchers`.`summary` AS `summary`,(case when (`vouchers`.`bank_ac` = '') then 'cash' else `vouchers`.`bank_ac` end) AS `account`,(case when (`voucher_entries`.`related_supplier` = '') then `voucher_entries`.`related_customer` else `voucher_entries`.`related_supplier` end) AS `agent`,(case when (`voucher_entries`.`related_supplier` = '') then 'customer' else 'supplier' end) AS `agent_type`,`voucher_entries`.`id` AS `entry_id`,`voucher_entries`.`amount` AS `amount` from (`vouchers` join `voucher_entries` on((`voucher_entries`.`voucher_id` = `vouchers`.`id`))) where ((`vouchers`.`voucher_type` = 'payment') and (`voucher_entries`.`dr_cr` = '1') and (`vouchers`.`deleted` = 0));

-- --------------------------------------------------------

--
-- Structure for view `route_sales_view`
--
DROP TABLE IF EXISTS `route_sales_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `route_sales_view` AS select `vouchers`.`id` AS `invoice_id`,`vouchers`.`voucher_date` AS `date`,`vouchers`.`summary` AS `summary`,`vouchers`.`tanker` AS `tanker`,`voucher_entries`.`id` AS `entry_id`,`voucher_entries`.`amount` AS `freight`,`voucher_entries`.`source` AS `source`,`voucher_entries`.`destination` AS `destination` from (`vouchers` join `voucher_entries` on((`voucher_entries`.`voucher_id` = `vouchers`.`id`))) where ((`voucher_entries`.`dr_cr` = 0) and (`vouchers`.`voucher_type` = 'route_sale') and (`vouchers`.`deleted` = 0) and (`voucher_entries`.`deleted` = 0));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
