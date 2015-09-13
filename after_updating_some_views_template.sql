-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2015 at 06:55 AM
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
-- Stand-in structure for view `cash_ledgers`
--
CREATE TABLE IF NOT EXISTS `cash_ledgers` (
`voucher_id` int(11)
,`voucher_date` date
,`summary` varchar(250)
,`credit_amount` double
,`debit_amount` double
);
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(2, 'test', '2015-08-07 16:53:39', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'test destination', '2015-08-07 16:53:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `current_purchase_cost_view`
--
CREATE TABLE IF NOT EXISTS `current_purchase_cost_view` (
`product` varchar(100)
,`tanker` varchar(100)
,`cost_per_item` double
,`voucher_id` int(11)
,`voucher_entry_id` int(11)
);
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'H.M.Hussain', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'M.Aslam.Agency', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'Zafar Patwari', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, 'Haider f/s', '9999999', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, 'Safdar Lahore', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(6, 'Rana Asif', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(7, 'Saith Riaz', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(8, 'Rehmat f/s', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(9, 'Sajid Zafarwal', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(10, 'M.Aslam Admore', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(11, 'Roy M.Aslam Kaleki', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(12, 'Qaisar Panwan', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(13, 'other', '', '', '2015-08-06 19:39:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(14, 'MUZAMMAL PETROLEUM', '', 'ZAFARWAL', '2015-08-08 07:04:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(15, 'SEHOLE F/S', '', '', '2015-08-08 07:53:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `expense_payments_view`
--
CREATE TABLE IF NOT EXISTS `expense_payments_view` (
`voucher_id` int(11)
,`voucher_date` date
,`summary` varchar(250)
,`account` varchar(100)
,`amount` double
);
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `expense_titles`
--

INSERT INTO `expense_titles` (`id`, `title`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'test title', '2015-08-07 17:00:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `inserted_at`, `updated_at`) VALUES
(1, 'HSD', 'High speed deisel', '2015-06-04 10:12:59', '0000-00-00 00:00:00'),
(2, 'PMG', 'Premier Motor Gasoline', '2015-06-04 10:13:08', '0000-00-00 00:00:00'),
(3, 'CASH', 'CASH', '2015-08-08 14:22:08', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `receipts_view`
--
CREATE TABLE IF NOT EXISTS `receipts_view` (
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
(3, 'purchases', 'invoices'),
(4, 'sales', 'add_product_sale'),
(5, 'stock', 'show'),
(6, 'accounts', 'index'),
(7, 'reports', 'daily'),
(8, 'suppliers', 'all'),
(9, 'settings', 'accounts'),
(10, 'payments', 'edit'),
(11, 'daybook', 'summary'),
(12, 'receipts', 'make'),
(13, 'admin', 'login'),
(14, 'tankers', 'all'),
(15, 'expenses', 'show'),
(16, 'withdrawls', 'accounts'),
(17, 'source_destination', 'show'),
(18, 'ledgers', 'customers');

-- --------------------------------------------------------

--
-- Stand-in structure for view `route_sale_view`
--
CREATE TABLE IF NOT EXISTS `route_sale_view` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `product_id`, `quantity`, `tanker`, `purchase_id`, `price_per_unit`, `updated_at`) VALUES
(1, 1, 0, '00000', 208, 75, '2015-08-25 14:41:37'),
(2, 2, 0, '00000', 65, 74.11, '2015-08-08 13:29:57'),
(3, 1, 0, 'TTA 224', 70, 81.4, '2015-08-08 13:33:58'),
(4, 2, 1000, 'TTA 224', 203, 50.12, '2015-08-23 22:39:06'),
(5, 1, 0, 'TTA 236', 43, 81.8, '2015-08-08 12:51:56'),
(6, 2, 0, 'TTA 236', 48, 74.11, '2015-08-08 13:06:11'),
(7, 1, 0, 'GLTA 1381', 150, 81.3, '2015-08-11 19:55:55'),
(8, 2, 0, 'GLTA 1381', 62, 74.11, '2015-08-08 13:24:05'),
(9, 1, 0, 'TTA 753', 135, 81.9, '2015-08-11 17:13:52'),
(10, 2, 0, 'TTA 753', 40, 74.11, '2015-08-08 12:48:20'),
(11, 3, 0, 'GLTA 1381', 0, 0, '0000-00-00 00:00:00'),
(12, 3, 0, 'TTA 224', 0, 0, '0000-00-00 00:00:00'),
(13, 3, 0, 'TTA 236', 0, 0, '0000-00-00 00:00:00'),
(14, 3, 0, 'TTA 753', 0, 0, '0000-00-00 00:00:00'),
(15, 3, 0, '00000', 0, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `stock_history_view`
--
CREATE TABLE IF NOT EXISTS `stock_history_view` (
`voucher_id` int(11)
,`voucher_entry_id` int(11)
,`voucher_date` date
,`inserted_at` timestamp
,`cost_per_item` double
,`in_out` varchar(3)
,`s_in` double
,`s_out` double
,`agent_type` varchar(8)
,`agent` varchar(100)
,`product` varchar(100)
,`tanker` varchar(100)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `stock_view`
--
CREATE TABLE IF NOT EXISTS `stock_view` (
`product` varchar(100)
,`tanker` varchar(100)
,`quantity` double
,`price_per_unit` double
,`purchase_id` int(11)
,`product_id` int(11)
,`id` int(11)
);
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `address`, `inerted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'Irfan Virik SB', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'Ch.Mukhtar Patoki', '', '', '2015-08-06 18:14:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'other', '', '', '2015-08-06 19:39:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, 'P.S.O', '', 'MACHHIKEY', '2015-08-08 07:27:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, 'ADMORE', '', 'MACHHIKEY', '2015-08-08 15:00:39', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tankers`
--

INSERT INTO `tankers` (`id`, `name`, `number`, `capacity`, `chambers`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'other', '00000', 40000, 5, '2015-08-06 19:38:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'HINO', 'TTA 224', 15000, 3, '2015-08-08 06:50:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'HINO', 'TTA 236', 15000, 3, '2015-08-08 06:50:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, 'BEDFORD', 'GLTA 1381', 10000, 2, '2015-08-08 06:50:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, 'HINO', 'TTA 753', 25000, 3, '2015-08-08 06:56:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_bank_accounts`
--

INSERT INTO `user_bank_accounts` (`id`, `title`, `account_number`, `bank`, `type`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'madina o/c', '123456789', 'alflah', 'current', '2015-08-06 18:16:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'madina oil company', '02027901401803', 'HBL', 'current', '2015-08-08 11:36:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'madina oil co', '0185273281001173', 'MCB', 'current', '2015-08-08 11:43:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=209 ;

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
(15, '2015-07-31', '', '00000', 'purchase', 0, '', 0, '', '2015-08-06 19:46:06', '2015-08-08 12:18:37', '0000-00-00 00:00:00', 1),
(16, '2015-08-07', 'test sale', '00000', 'product_sale', 0, '', 0, '', '2015-08-07 16:50:35', '2015-08-07 22:45:01', '0000-00-00 00:00:00', 1),
(17, '2015-08-01', '', 'TTA 224', 'purchase', 0, '', 0, '', '2015-08-08 06:53:22', '2015-08-08 12:18:07', '0000-00-00 00:00:00', 1),
(18, '2015-08-01', '', 'TTA 753', 'purchase', 0, '', 0, '', '2015-08-08 06:57:05', '2015-08-08 12:19:08', '0000-00-00 00:00:00', 1),
(19, '2015-08-02', '', 'GLTA 1381', 'purchase', 0, '', 0, '', '2015-08-08 06:58:51', '2015-08-08 12:08:27', '0000-00-00 00:00:00', 1),
(20, '2015-08-01', '', 'TTA 753', 'product_sale', 0, '', 0, '', '2015-08-08 07:05:22', '2015-08-08 12:20:38', '0000-00-00 00:00:00', 1),
(21, '2015-08-01', '', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-08 07:06:13', '2015-08-08 12:06:53', '0000-00-00 00:00:00', 1),
(22, '2015-08-01', '', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-08 07:07:21', '2015-08-08 12:20:30', '0000-00-00 00:00:00', 1),
(23, '2015-08-02', '', 'TTA 753', 'purchase', 0, '', 0, '', '2015-08-08 07:10:41', '2015-08-08 12:19:26', '0000-00-00 00:00:00', 1),
(24, '2015-08-02', '', 'TTA 753', 'product_sale', 0, '', 0, '', '2015-08-08 07:12:06', '2015-08-08 12:20:15', '0000-00-00 00:00:00', 1),
(25, '2015-08-03', '', 'GLTA 1381', 'purchase', 0, '', 0, '', '2015-08-08 07:13:12', '2015-08-08 12:19:36', '0000-00-00 00:00:00', 1),
(26, '2015-08-03', '', 'TTA 224', 'purchase', 0, '', 0, '', '2015-08-08 07:14:51', '2015-08-08 12:19:47', '0000-00-00 00:00:00', 1),
(27, '2015-08-03', '', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-08 07:16:25', '2015-08-08 12:20:09', '0000-00-00 00:00:00', 1),
(28, '2015-07-31', '', '00000', 'purchase', 0, '', 0, '', '2015-08-08 07:22:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(29, '2015-08-01', '', 'TTA 236', 'purchase', 0, '', 0, '', '2015-08-08 07:32:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(30, '2015-08-01', '', 'TTA 753', 'purchase', 0, '', 0, '', '2015-08-08 07:33:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(31, '2015-08-01', '', 'GLTA 1381', 'purchase', 0, '', 0, '', '2015-08-08 07:34:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(32, '2015-08-01', '', 'TTA 224', 'purchase', 0, '', 0, '', '2015-08-08 07:34:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(33, '2015-08-01', '', 'TTA 236', 'product_sale', 0, '', 0, '', '2015-08-08 07:37:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(34, '2015-08-01', '', 'TTA 753', 'product_sale', 0, '', 0, '', '2015-08-08 07:38:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(35, '2015-08-01', '', 'GLTA 1381', 'product_sale', 0, '', 0, '', '2015-08-08 07:39:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(36, '2015-08-01', '', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-08 07:40:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(37, '2015-08-01', '', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-08 07:41:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(38, '2015-08-02', '', 'TTA 753', 'purchase', 0, '', 0, '', '2015-08-08 07:45:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(39, '2015-08-02', '', 'TTA 753', 'product_sale', 0, '', 0, '', '2015-08-08 07:46:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(40, '2015-08-02', '', 'TTA 753', 'purchase', 0, '', 0, '', '2015-08-08 07:47:29', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(41, '2015-08-02', '', 'TTA 753', 'product_sale', 0, '', 0, '', '2015-08-08 07:48:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(42, '2015-08-03', '', 'GLTA 1381', 'purchase', 0, '', 0, '', '2015-08-08 07:48:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(43, '2015-08-03', '', 'TTA 236', 'purchase', 0, '', 0, '', '2015-08-08 07:49:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(44, '2015-08-03', '', 'TTA 224', 'purchase', 0, '', 0, '', '2015-08-08 07:50:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(45, '2015-08-03', '', 'TTA 236', 'product_sale', 0, '', 0, '', '2015-08-08 07:51:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(46, '2015-08-03', '', 'GLTA 1381', 'product_sale', 0, '', 0, '', '2015-08-08 07:54:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(47, '2015-08-03', '', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-08 07:55:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(48, '2015-08-03', '', 'TTA 236', 'purchase', 0, '', 0, '', '2015-08-08 07:56:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(49, '2015-08-03', '', 'TTA 236', 'product_sale', 0, '', 0, '', '2015-08-08 07:57:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(50, '2015-08-04', '\n\n\n', 'TTA 224', 'purchase', 0, '', 0, '', '2015-08-08 07:58:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(51, '2015-08-04', '', 'TTA 236', 'product_sale', 0, '', 0, '', '2015-08-08 08:06:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(52, '2015-08-08', '', 'GLTA 1381', 'product_sale', 0, '', 0, '', '2015-08-08 08:08:12', '2015-08-08 13:08:51', '0000-00-00 00:00:00', 1),
(53, '2015-08-03', '', '00000', 'product_sale', 0, '', 0, '', '2015-08-08 08:09:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(54, '2015-08-04', 'SUPLLY THROUGH TTA 236\n', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-08 08:09:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(55, '2015-08-04', '', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-08 08:12:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(56, '2015-08-05', '', 'TTA 224', 'purchase', 0, '', 0, '', '2015-08-08 08:13:47', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(57, '2015-08-05', '', 'TTA 753', 'purchase', 0, '', 0, '', '2015-08-08 08:15:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(58, '2015-08-05', '', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-08 08:18:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(59, '2015-08-05', '', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-08 08:19:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(60, '2015-08-05', '', 'TTA 753', 'product_sale', 0, '', 0, '', '2015-08-08 08:19:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(61, '2015-08-05', '', 'GLTA 1381', 'product_sale', 0, '', 0, '', '2015-08-08 08:20:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(62, '2015-08-05', '', 'GLTA 1381', 'purchase', 0, '', 0, '', '2015-08-08 08:21:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(63, '2015-08-05', '', 'GLTA 1381', 'product_sale', 0, '', 0, '', '2015-08-08 08:24:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(64, '2015-08-06', 'PURCHASES THROUGH GLTA 1\n381', 'TTA 224', 'purchase', 0, '', 0, '', '2015-08-08 08:26:39', '2015-08-08 13:27:41', '0000-00-00 00:00:00', 1),
(65, '2015-08-06', 'GLTA 1381', '00000', 'purchase', 0, '', 0, '', '2015-08-08 08:28:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(66, '2015-08-06', '', 'TTA 224', 'purchase', 0, '', 0, '', '2015-08-08 08:29:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(67, '2015-08-06', 'GLTA 1381\n', '00000', 'product_sale', 0, '', 0, '', '2015-08-08 08:29:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(68, '2015-08-06', '', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-08 08:30:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(69, '2015-08-06', '', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-08 08:32:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(70, '2015-08-07', '', 'TTA 224', 'purchase', 0, '', 0, '', '2015-08-08 08:33:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(71, '2015-08-07', '', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-08 08:33:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(72, '2015-08-01', 'amount received by AR  F/s irfan virk sb\n', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 11:48:18', '2015-08-11 14:15:36', '0000-00-00 00:00:00', 1),
(73, '2015-08-02', 'cash rcvd by haider f/s', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 11:50:21', '2015-08-11 14:14:00', '0000-00-00 00:00:00', 1),
(74, '2015-08-03', 'rcvd by AR f/s irfan sb', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 11:52:14', '2015-08-11 14:13:41', '0000-00-00 00:00:00', 1),
(75, '2015-08-03', 'rcvd by AR f/s irfan sb', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 11:53:18', '2015-08-11 14:13:33', '0000-00-00 00:00:00', 1),
(76, '2015-08-03', 'rcvd by Behria F/s ch mukhtar', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 11:54:28', '2015-08-11 14:13:25', '0000-00-00 00:00:00', 1),
(77, '2015-08-03', 'cash rcvd by Haider F/s', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 11:55:32', '2015-08-11 14:13:13', '0000-00-00 00:00:00', 1),
(78, '2015-08-03', 'rcvd by AR F/s irfan sb', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 11:58:00', '2015-08-11 14:13:00', '0000-00-00 00:00:00', 1),
(79, '2015-08-03', 'rcvd d.d pso by self', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 11:59:49', '2015-08-11 14:12:49', '0000-00-00 00:00:00', 1),
(80, '2015-08-04', 'rcvd by taj f/s ch mukhtar', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:01:14', '2015-08-11 14:12:40', '0000-00-00 00:00:00', 1),
(81, '2015-08-04', 'pay order rcvd by irfan sb', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:02:29', '2015-08-11 14:11:38', '0000-00-00 00:00:00', 1),
(82, '2015-08-04', 'd.d pso rcvd by myself', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:03:56', '2015-08-11 14:11:29', '0000-00-00 00:00:00', 1),
(83, '2015-08-05', 'rcvd by AR F/s irfan sb', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:05:51', '2015-08-11 14:11:14', '0000-00-00 00:00:00', 1),
(84, '2015-08-05', 'rcvd by Ar F/s irfan sb from 1195', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:07:06', '2015-08-11 14:11:04', '0000-00-00 00:00:00', 1),
(85, '2015-08-05', '', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:07:33', '2015-08-08 17:07:51', '0000-00-00 00:00:00', 1),
(86, '2015-08-05', 'rcvd by AR F/s irfan sb from 0822', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:08:33', '2015-08-11 14:10:52', '0000-00-00 00:00:00', 1),
(87, '2015-08-05', 'cash rcvd by my self', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:09:31', '2015-08-11 14:10:11', '0000-00-00 00:00:00', 1),
(88, '2015-08-05', 'rcvd by ABL irfan sb', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:10:36', '2015-08-11 14:10:02', '0000-00-00 00:00:00', 1),
(89, '2015-08-05', 'rcvd bybirfan sb ABL', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:11:39', '2015-08-11 14:09:55', '0000-00-00 00:00:00', 1),
(90, '2015-08-05', 'pso d.d rcvd by my self', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:27:11', '2015-08-11 14:09:48', '0000-00-00 00:00:00', 1),
(91, '2015-08-06', 'rcvd by AR F/s irfan sb', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:29:38', '2015-08-11 14:09:39', '0000-00-00 00:00:00', 1),
(92, '2015-08-06', 'rcvd by AR F/s irfan sb', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:29:55', '2015-08-08 19:52:16', '0000-00-00 00:00:00', 1),
(93, '2015-08-06', 'rcvd by AR F/s irfan sb from 0822', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:35:48', '2015-08-11 14:08:38', '0000-00-00 00:00:00', 1),
(94, '2015-08-06', 'rcvd by haider f/s', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:36:29', '2015-08-11 14:08:31', '0000-00-00 00:00:00', 1),
(95, '2015-08-06', 'rcvd pso d.d by my self', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:39:38', '2015-08-11 14:08:18', '0000-00-00 00:00:00', 1),
(96, '2015-08-07', 'rcvd by AR F/s irfan sb', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:40:28', '2015-08-11 14:08:09', '0000-00-00 00:00:00', 1),
(97, '2015-08-07', 'rcvd by AR F/s irfan sb', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:41:29', '2015-08-11 14:08:01', '0000-00-00 00:00:00', 1),
(98, '2015-08-07', 'rcvd by AR F/s irfan sb', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:42:35', '2015-08-11 14:07:52', '0000-00-00 00:00:00', 1),
(99, '2015-08-08', 'rcvd chq hbl', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:43:37', '2015-08-11 14:07:44', '0000-00-00 00:00:00', 1),
(100, '2015-08-08', 'rcvd by Haider F/s', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:44:35', '2015-08-11 14:07:28', '0000-00-00 00:00:00', 1),
(101, '2015-08-08', 'rcvd by AR F/s irfan sf', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:46:19', '2015-08-11 14:07:19', '0000-00-00 00:00:00', 1),
(102, '2015-08-08', 'cash rcvd by my self', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:49:15', '2015-08-11 14:07:11', '0000-00-00 00:00:00', 1),
(103, '2015-08-01', 'from zaferwal HBL', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:51:00', '2015-08-11 14:16:50', '0000-00-00 00:00:00', 1),
(104, '2015-08-03', 'from zaferwal ABL', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 12:53:34', '2015-08-11 14:17:18', '0000-00-00 00:00:00', 1),
(105, '2015-07-31', 'chq rcvd by m.hussain 31-07-2015', '', 'receipt', 0, '', 0, 'madina oil company (HBL 02*********803)', '2015-08-08 13:15:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(106, '2015-07-31', 'ballance 31-07-2015', '', 'receipt', 0, '', 0, 'madina oil co (MCB 01***********173)', '2015-08-08 13:18:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(107, '2015-08-03', 'online hbl', '', 'payment', 0, '', 0, 'madina oil company (HBL 02*********803)', '2015-08-08 13:20:01', '2015-08-11 14:17:15', '0000-00-00 00:00:00', 1),
(108, '2015-08-03', 'online mcb', '', 'payment', 0, '', 0, 'madina oil co (MCB 01***********173)', '2015-08-08 13:21:19', '2015-08-11 14:17:12', '0000-00-00 00:00:00', 1),
(109, '2015-08-03', 'from h.m hussain', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:22:00', '2015-08-11 14:17:09', '0000-00-00 00:00:00', 1),
(110, '2015-08-03', 'from m.aslam', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:22:54', '2015-08-11 14:17:06', '0000-00-00 00:00:00', 1),
(111, '2015-08-03', 'from safdar lahore', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:24:09', '2015-08-11 14:17:03', '0000-00-00 00:00:00', 1),
(112, '2015-08-04', 'pay order NBP', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:26:39', '2015-08-11 14:17:25', '0000-00-00 00:00:00', 1),
(113, '2015-08-04', 'from safdar lahore 0195', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:27:22', '2015-08-11 14:17:23', '0000-00-00 00:00:00', 1),
(114, '2015-08-05', 'from h.m.hussain 0822', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:30:01', '2015-08-11 14:17:51', '0000-00-00 00:00:00', 1),
(115, '2015-08-05', 'from aslam 1195', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:30:49', '2015-08-11 14:17:47', '0000-00-00 00:00:00', 1),
(116, '2015-08-05', 'frpm aslam 0822', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:31:19', '2015-08-11 14:17:34', '0000-00-00 00:00:00', 1),
(117, '2015-08-05', 'from zafarwal abl', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:31:55', '2015-08-11 14:17:32', '0000-00-00 00:00:00', 1),
(118, '2015-08-05', 'from zafarwal abl', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:33:02', '2015-08-11 14:17:30', '0000-00-00 00:00:00', 1),
(119, '2015-08-06', 'from zafarwal\n\n\n', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:34:34', '2015-08-11 14:17:59', '0000-00-00 00:00:00', 1),
(120, '2015-08-06', 'from aslam 0822', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:35:48', '2015-08-11 14:17:57', '0000-00-00 00:00:00', 1),
(121, '2015-08-07', 'from h.m.hussain', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:36:40', '2015-08-11 14:18:06', '0000-00-00 00:00:00', 1),
(122, '2015-08-07', 'from aslam', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:37:04', '2015-08-11 14:18:04', '0000-00-00 00:00:00', 1),
(123, '2015-08-07', 'from safdar lahore', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:37:35', '2015-08-11 14:18:01', '0000-00-00 00:00:00', 1),
(124, '2015-08-08', 'from haider via hbl 0202', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:39:56', '2015-08-11 14:18:16', '0000-00-00 00:00:00', 1),
(125, '2015-08-08', 'from safdar lahore', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:40:21', '2015-08-11 14:18:13', '0000-00-00 00:00:00', 1),
(126, '2015-08-03', 'pso d.d from haider', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:49:47', '2015-08-11 14:16:57', '0000-00-00 00:00:00', 1),
(127, '2015-08-04', 'from haider f/s', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:52:06', '2015-08-11 14:17:21', '0000-00-00 00:00:00', 1),
(128, '2015-08-05', 'from sehole f/s', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:52:44', '2015-08-11 14:17:28', '0000-00-00 00:00:00', 1),
(129, '2015-08-06', 'from haider f/s', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 13:54:01', '2015-08-11 14:17:54', '0000-00-00 00:00:00', 1),
(130, '2015-08-08', 'pso d.d''s previous', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 14:02:16', '2015-08-11 14:18:11', '0000-00-00 00:00:00', 1),
(131, '2015-08-08', 'on cheque facility', 'TTA 224', 'purchase', 0, '', 0, '', '2015-08-08 14:04:17', '2015-08-11 13:45:44', '0000-00-00 00:00:00', 1),
(132, '2015-08-08', 'glta 1381', '00000', 'purchase', 0, '', 0, '', '2015-08-08 14:06:16', '2015-08-11 13:45:34', '0000-00-00 00:00:00', 1),
(133, '2015-08-08', '', 'TTA 753', 'purchase', 0, '', 0, '', '2015-08-08 14:06:55', '2015-08-11 13:45:22', '0000-00-00 00:00:00', 1),
(134, '2015-08-08', '', 'GLTA 1381', 'product_sale', 0, '', 0, '', '2015-08-08 14:07:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(135, '2015-08-08', '', 'TTA 753', 'product_sale', 0, '', 0, '', '2015-08-08 14:14:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(136, '2015-08-08', 'FROM HAIDER', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-08 15:01:41', '2015-08-11 14:18:08', '0000-00-00 00:00:00', 1),
(137, '2015-08-12', 'GLTA 1381', '00000', 'purchase', 0, '', 0, '', '2015-08-11 08:48:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(138, '2015-08-08', '', 'TTA 753', 'purchase', 0, '', 0, '', '2015-08-11 08:48:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(139, '2015-08-08', '', 'TTA 224', 'purchase', 0, '', 0, '', '2015-08-11 08:49:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(140, '2015-08-08', '', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-11 08:52:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(141, '2015-08-08', '', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-11 08:52:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(142, '2015-08-08', '', 'GLTA 1381', 'product_sale', 0, '', 0, '', '2015-08-11 08:53:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(143, '2015-08-10', '', 'TTA 224', 'purchase', 0, '', 0, '', '2015-08-11 08:58:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(144, '2015-08-10', '', 'GLTA 1381', 'purchase', 0, '', 0, '', '2015-08-11 08:59:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(145, '2015-08-10', '', 'GLTA 1381', 'product_sale', 0, '', 0, '', '2015-08-11 08:59:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(146, '2015-08-10', '', 'GLTA 1381', 'product_sale', 0, '', 0, '', '2015-08-11 09:00:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(147, '2015-07-31', '', '', 'receipt', 0, '', 0, 'madina oil company (HBL 02*********803)', '2015-08-11 09:25:50', '2015-08-11 14:26:51', '0000-00-00 00:00:00', 1),
(148, '2015-07-31', '', '', 'receipt', 0, '', 0, 'madina oil company (HBL 02*********803)', '2015-08-11 09:25:50', '2015-08-11 14:26:31', '0000-00-00 00:00:00', 1),
(149, '2015-08-01', 'muzammzl petroleum', '', 'receipt', 0, '', 0, '', '2015-08-11 10:54:41', '2015-08-11 16:08:42', '0000-00-00 00:00:00', 1),
(150, '2015-08-08', '', 'GLTA 1381', 'purchase', 0, '', 0, '', '2015-08-11 12:30:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(151, '2015-08-10', '', 'TTA 224', 'product_sale', 0, '', 0, '', '2015-08-11 14:44:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(152, '2015-08-11', 'HBL AR F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:03:12', '2015-08-11 20:09:27', '0000-00-00 00:00:00', 1),
(153, '2015-08-01', 'HBL AR F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:10:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(154, '2015-08-03', 'HBL AR F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:11:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(155, '2015-08-03', 'HBL AR F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:12:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(156, '2015-08-03', 'HAIDER F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:13:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(157, '2015-08-03', 'BAHRIA F/S ', '', 'receipt', 0, '', 0, '', '2015-08-11 15:14:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(158, '2015-08-03', 'HAIDER F/S\n', '', 'receipt', 0, '', 0, '', '2015-08-11 15:14:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(159, '2015-08-03', 'AR F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:15:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(160, '2015-08-03', 'D.D PSO', '', 'receipt', 0, '', 0, '', '2015-08-11 15:16:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(161, '2015-08-04', 'TAJ F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:16:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(162, '2015-08-04', 'PAY ORDER', '', 'receipt', 0, '', 0, '', '2015-08-11 15:18:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(163, '2015-08-04', 'D.D PSO', '', 'receipt', 0, '', 0, '', '2015-08-11 15:18:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(164, '2015-08-05', 'AR F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:19:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(165, '2015-08-05', 'AR F/S 0195', '', 'receipt', 0, '', 0, '', '2015-08-11 15:20:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(166, '2015-08-05', 'AR F/S 0822', '', 'receipt', 0, '', 0, '', '2015-08-11 15:20:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(167, '2015-08-05', '', '', 'receipt', 0, '', 0, '', '2015-08-11 15:21:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(168, '2015-08-05', 'HAIDER F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:21:29', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(169, '2015-08-05', 'AR F/S ABL', '', 'receipt', 0, '', 0, '', '2015-08-11 15:22:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(170, '2015-08-05', 'AR F/S ABL', '', 'receipt', 0, '', 0, '', '2015-08-11 15:23:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(171, '2015-08-05', 'D.D PSO', '', 'receipt', 0, '', 0, '', '2015-08-11 15:24:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(172, '2015-08-06', 'AR F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:24:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(173, '2015-08-06', 'AR F/S HBL', '', 'receipt', 0, '', 0, '', '2015-08-11 15:25:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(174, '2015-08-06', 'HAIDER F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:26:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(175, '2015-08-06', '', '', 'receipt', 0, '', 0, '', '2015-08-11 15:26:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(176, '2015-08-07', 'AR F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:27:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(177, '2015-08-07', '', '', 'receipt', 0, '', 0, '', '2015-08-11 15:28:13', '2015-08-11 20:29:47', '0000-00-00 00:00:00', 1),
(178, '2015-08-07', 'AR F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:30:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(179, '2015-08-07', 'AR F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:30:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(180, '2015-08-08', 'CHQ ABL', '', 'receipt', 0, '', 0, '', '2015-08-11 15:33:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(181, '2015-08-08', 'HAIDER F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:34:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(182, '2015-08-11', 'AR F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:34:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(183, '2015-08-08', 'CASH RCVD', '', 'receipt', 0, '', 0, '', '2015-08-11 15:35:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(184, '2015-08-10', 'D.D PSO', '', 'receipt', 0, '', 0, '', '2015-08-11 15:35:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(185, '2015-08-10', 'D.D PSO', '', 'receipt', 0, '', 0, '', '2015-08-11 15:36:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(186, '2015-08-10', 'D.D PSO', '', 'receipt', 0, '', 0, '', '2015-08-11 15:37:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(187, '2015-08-10', 'AR F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:37:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(188, '2015-08-10', 'ABL IRFAN SB', '', 'receipt', 0, '', 0, '', '2015-08-11 15:37:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(189, '2015-08-10', 'AR F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:38:26', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(190, '2015-08-10', 'AR F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:38:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(191, '2015-08-10', 'HAIDER F/S', '', 'receipt', 0, '', 0, '', '2015-08-11 15:39:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(192, '2015-08-10', 'ABL IRFAN SB', '', 'receipt', 0, '', 0, '', '2015-08-11 15:40:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(193, '2015-08-11', 'CH MUKHTAR', '', 'receipt', 0, '', 0, '', '2015-08-11 15:41:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(194, '2015-08-11', 'CH MUKHTAR UBL', '', 'receipt', 0, '', 0, '', '2015-08-11 15:41:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(195, '2015-08-11', 'CH MUKHTAR UBL', '', 'receipt', 0, '', 0, '', '2015-08-11 15:42:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(196, '2015-08-10', 'IRFAN SB AB\r\n', '', 'receipt', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-11 15:43:09', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(197, '2015-08-18', 'some summaryf', '', 'payment', 0, '', 0, 'cash', '2015-08-12 05:32:29', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(198, '2015-08-12', '', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-12 05:38:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(199, '2015-08-16', 'test payment expense by cash', '', 'expense payment', 0, '', 0, '', '2015-08-16 04:42:35', '2015-08-16 09:58:08', '0000-00-00 00:00:00', 1),
(200, '2015-08-12', 'another testt', '', 'expense payment', 0, '', 0, '', '2015-08-16 04:58:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(201, '2015-08-16', 'cxcx', '', 'expense payment', 0, '', 0, '', '2015-08-16 18:35:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(202, '2015-08-17', '', '', 'payment', 0, '', 0, 'madina o/c (alflah 12****789)', '2015-08-17 06:01:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(203, '2015-08-23', '', 'TTA 224', 'purchase', 0, '', 0, '', '2015-08-23 17:39:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(204, '2015-08-24', '', '00000', 'product_sale', 0, '', 0, '', '2015-08-24 03:46:58', '2015-08-25 14:40:14', '0000-00-00 00:00:00', 1),
(205, '2015-08-25', '', '00000', 'product_sale', 0, '', 0, '', '2015-08-25 09:38:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(206, '2015-08-25', '', '00000', 'product_sale', 0, '', 0, '', '2015-08-25 09:39:28', '2015-08-25 14:40:10', '0000-00-00 00:00:00', 1),
(207, '2015-08-25', '', '00000', 'product_sale', 0, '', 0, '', '2015-08-25 09:40:39', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(208, '2015-08-25', '', '00000', 'purchase', 0, '', 0, '', '2015-08-25 09:41:11', '2015-08-25 14:41:37', '0000-00-00 00:00:00', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=427 ;

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
(29, 15, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 5000, 82.5, 0, 412500, 0, '', '', 1, '', '2015-08-08 12:18:37', 1),
(30, 15, 1, 'HSD', '', 'payable', '', 'other', '', '', '', 5000, 82.5, 0, 412500, 0, '', '', 0, '', '2015-08-08 12:18:37', 1),
(31, 16, 1, 'HSD', '', 'receivable', 'Haider f/s', '', '', '', '', 100, 100, 82.5, 10000, 0, '', '', 1, '', '2015-08-07 22:45:01', 1),
(32, 16, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 100, 100, 82.5, 10000, 0, '', '', 0, '', '2015-08-07 22:45:01', 1),
(33, 17, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 82, 0, 1230000, 0, '', '', 1, '', '2015-08-08 12:18:07', 1),
(34, 17, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 15000, 82, 0, 1230000, 0, '', '', 0, '', '2015-08-08 12:18:07', 1),
(35, 18, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 20000, 82, 0, 1640000, 0, '', '', 1, '', '2015-08-08 12:19:08', 1),
(36, 18, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 20000, 82, 0, 1640000, 0, '', '', 0, '', '2015-08-08 12:19:08', 1),
(37, 19, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 10000, 82, 0, 820000, 0, '', '', 1, '', '2015-08-08 12:08:27', 1),
(38, 19, 1, 'HSD', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 10000, 82, 0, 820000, 0, '', '', 0, '', '2015-08-08 12:08:27', 1),
(39, 20, 1, 'HSD', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 20000, 82.9, 82, 1658000, 0, '', '', 1, '', '2015-08-08 12:20:38', 1),
(40, 20, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 20000, 82.9, 82, 1658000, 0, '', '', 0, '', '2015-08-08 12:20:38', 1),
(41, 21, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 15000, 0, 82, 0, 0, '', '', 1, '', '2015-08-08 12:06:53', 1),
(42, 21, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 15000, 0, 82, 0, 0, '', '', 0, '', '2015-08-08 12:06:53', 1),
(43, 22, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 15000, 82.94, 82, 1244100, 0, '', '', 1, '', '2015-08-08 12:20:30', 1),
(44, 22, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 15000, 82.94, 82, 1244100, 0, '', '', 0, '', '2015-08-08 12:20:30', 1),
(45, 23, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 10000, 82, 0, 820000, 0, '', '', 1, '', '2015-08-08 12:19:26', 1),
(46, 23, 1, 'HSD', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 10000, 82, 0, 820000, 0, '', '', 0, '', '2015-08-08 12:19:26', 1),
(47, 24, 1, 'HSD', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 10000, 82.9, 82, 829000, 0, '', '', 1, '', '2015-08-08 12:20:14', 1),
(48, 24, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 10000, 82.9, 82, 829000, 0, '', '', 0, '', '2015-08-08 12:20:14', 1),
(49, 25, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 10000, 82, 0, 820000, 0, '', '', 1, '', '2015-08-08 12:19:36', 1),
(50, 25, 1, 'HSD', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 10000, 82, 0, 820000, 0, '', '', 0, '', '2015-08-08 12:19:36', 1),
(51, 26, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 81.8, 0, 1227000, 0, '', '', 1, '', '2015-08-08 12:19:47', 1),
(52, 26, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 15000, 81.8, 0, 1227000, 0, '', '', 0, '', '2015-08-08 12:19:47', 1),
(53, 27, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 15000, 82.94, 81.8, 1244100, 0, '', '', 1, '', '2015-08-08 12:20:09', 1),
(54, 27, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 15000, 82.94, 81.8, 1244100, 0, '', '', 0, '', '2015-08-08 12:20:09', 1),
(55, 28, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 5000, 82.5, 0, 412500, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(56, 28, 1, 'HSD', '', 'payable', '', 'other', '', '', '', 5000, 82.5, 0, 412500, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(57, 29, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 82, 0, 1230000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(58, 29, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 15000, 82, 0, 1230000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(59, 30, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 20000, 82, 0, 1640000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(60, 30, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 20000, 82, 0, 1640000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(61, 30, 2, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 5000, 74.11, 0, 370550, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(62, 30, 2, 'PMG', '', 'payable', '', 'Irfan Virik SB', '', '', '', 5000, 74.11, 0, 370550, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(63, 31, 1, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 10000, 74.47, 0, 744700, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(64, 31, 1, 'PMG', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 10000, 74.47, 0, 744700, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(65, 32, 1, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 74.11, 0, 1111650, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(66, 32, 1, 'PMG', '', 'payable', '', 'P.S.O', '', '', '', 15000, 74.11, 0, 1111650, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(67, 33, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 15000, 82.94, 82, 1244100, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(68, 33, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 15000, 82.94, 82, 1244100, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(69, 34, 1, 'HSD', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 20000, 82.9, 82, 1658000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(70, 34, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 20000, 82.9, 82, 1658000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(71, 34, 2, 'PMG', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 5000, 74.11, 74.11, 370550, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(72, 34, 2, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 5000, 74.11, 74.11, 370550, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(73, 35, 1, 'PMG', '', 'receivable', 'H.M.Hussain', '', '', '', '', 10000, 74.47, 74.47, 744700, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(74, 35, 1, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 10000, 74.47, 74.47, 744700, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(75, 36, 1, 'PMG', '', 'receivable', 'Safdar Lahore', '', '', '', '', 10000, 75.08, 74.11, 750800, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(76, 36, 1, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 10000, 75.08, 74.11, 750800, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(77, 37, 1, 'PMG', '', 'receivable', 'Haider f/s', '', '', '', '', 5000, 74.47, 74.11, 372350, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(78, 37, 1, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 5000, 74.47, 74.11, 372350, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(79, 38, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 10000, 82, 0, 820000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(80, 38, 1, 'HSD', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 10000, 82, 0, 820000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(81, 38, 2, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 74.47, 0, 1117050, 0, '', '', 1, '', '2015-08-08 12:47:07', 1),
(82, 38, 2, 'PMG', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 15000, 74.47, 0, 1117050, 0, '', '', 0, '', '2015-08-08 12:47:07', 1),
(83, 39, 1, 'HSD', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 10000, 82.9, 82, 829000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(84, 39, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 10000, 82.9, 82, 829000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(85, 39, 2, 'PMG', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 15000, 74.47, 74.47, 1117050, 0, '', '', 1, '', '2015-08-08 12:47:48', 1),
(86, 39, 2, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 15000, 74.47, 74.47, 1117050, 0, '', '', 0, '', '2015-08-08 12:47:48', 1),
(87, 40, 1, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 74.11, 0, 1111650, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(88, 40, 1, 'PMG', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 15000, 74.11, 0, 1111650, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(89, 41, 1, 'PMG', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 15000, 74.11, 74.11, 1111650, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(90, 41, 1, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 15000, 74.11, 74.11, 1111650, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(91, 42, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 10000, 82, 0, 820000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(92, 42, 1, 'HSD', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 10000, 82, 0, 820000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(93, 43, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 81.8, 0, 1227000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(94, 43, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 15000, 81.8, 0, 1227000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(95, 44, 1, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 74.11, 0, 1111650, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(96, 44, 1, 'PMG', '', 'payable', '', 'P.S.O', '', '', '', 15000, 74.11, 0, 1111650, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(97, 45, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 15000, 82.94, 81.8, 1244100, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(98, 45, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 15000, 82.94, 81.8, 1244100, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(99, 46, 1, 'HSD', '', 'receivable', 'SEHOLE F/S', '', '', '', '', 5000, 83, 82, 415000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(100, 46, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 5000, 83, 82, 415000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(101, 47, 1, 'PMG', '', 'receivable', 'Haider f/s', '', '', '', '', 15000, 74.47, 74.11, 1117050, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(102, 47, 1, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 15000, 74.47, 74.11, 1117050, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(103, 48, 1, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 74.11, 0, 1111650, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(104, 48, 1, 'PMG', '', 'payable', '', 'P.S.O', '', '', '', 15000, 74.11, 0, 1111650, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(105, 49, 1, 'PMG', '', 'receivable', 'Safdar Lahore', '', '', '', '', 10000, 75.08, 74.11, 750800, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(106, 49, 1, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 10000, 75.08, 74.11, 750800, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(107, 50, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 81.8, 0, 1227000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(108, 50, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 15000, 81.8, 0, 1227000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(109, 51, 1, 'PMG', '', 'receivable', 'H.M.Hussain', '', '', '', '', 5000, 74.47, 74.11, 372350, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(110, 51, 1, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 5000, 74.47, 74.11, 372350, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(111, 52, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 5000, 82.94, 82, 414700, 0, '', '', 1, '', '2015-08-08 13:08:51', 1),
(112, 52, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 5000, 82.94, 82, 414700, 0, '', '', 0, '', '2015-08-08 13:08:51', 1),
(113, 53, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 5000, 82.94, 82.5, 414700, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(114, 53, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 5000, 82.94, 82.5, 414700, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(115, 54, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 5000, 82.94, 81.8, 414700, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(116, 54, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 5000, 82.94, 81.8, 414700, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(117, 55, 1, 'HSD', '', 'receivable', 'Zafar Patwari', '', '', '', '', 10000, 83.17, 82.94, 831700, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(118, 55, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 10000, 83.17, 82.94, 831700, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(119, 56, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 81.8, 0, 1227000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(120, 56, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 15000, 81.8, 0, 1227000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(121, 57, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 25000, 81.8, 0, 2045000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(122, 57, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 25000, 81.8, 0, 2045000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(123, 58, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 5000, 82.94, 81.8, 414700, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(124, 58, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 5000, 82.94, 81.8, 414700, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(125, 59, 1, 'HSD', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 10000, 83.32, 81.8, 833200, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(126, 59, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 10000, 83.32, 81.8, 833200, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(127, 60, 1, 'HSD', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 25000, 82, 81.8, 2050000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(128, 60, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 25000, 82, 81.8, 2050000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(129, 61, 1, 'HSD', '', 'receivable', 'SEHOLE F/S', '', '', '', '', 5000, 83, 82, 415000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(130, 61, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 5000, 83, 82, 415000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(131, 62, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 5000, 81.8, 0, 409000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(132, 62, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 5000, 81.8, 0, 409000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(133, 62, 2, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 5000, 74.11, 0, 370550, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(134, 62, 2, 'PMG', '', 'payable', '', 'Irfan Virik SB', '', '', '', 5000, 74.11, 0, 370550, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(135, 63, 1, 'PMG', '', 'receivable', 'SEHOLE F/S', '', '', '', '', 5000, 74.71, 74.11, 373550, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(136, 63, 1, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 5000, 74.71, 74.11, 373550, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(137, 64, 1, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 10000, 74.11, 0, 741100, 0, '', '', 1, '', '2015-08-08 13:27:41', 1),
(138, 64, 1, 'PMG', '', 'payable', '', 'Irfan Virik SB', '', '', '', 10000, 74.11, 0, 741100, 0, '', '', 0, '', '2015-08-08 13:27:41', 1),
(139, 65, 1, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 10000, 74.11, 0, 741100, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(140, 65, 1, 'PMG', '', 'payable', '', 'Irfan Virik SB', '', '', '', 10000, 74.11, 0, 741100, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(141, 66, 1, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 74.11, 0, 1111650, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(142, 66, 1, 'PMG', '', 'payable', '', 'P.S.O', '', '', '', 15000, 74.11, 0, 1111650, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(143, 67, 1, 'PMG', '', 'receivable', 'Safdar Lahore', '', '', '', '', 10000, 75.08, 74.11, 750800, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(144, 67, 1, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 10000, 75.08, 74.11, 750800, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(145, 68, 1, 'PMG', '', 'receivable', 'Haider f/s', '', '', '', '', 5000, 74.47, 74.11, 372350, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(146, 68, 1, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 5000, 74.47, 74.11, 372350, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(147, 69, 1, 'PMG', '', 'receivable', 'Zafar Patwari', '', '', '', '', 10000, 74.57, 74.11, 745700, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(148, 69, 1, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 10000, 74.57, 74.11, 745700, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(149, 70, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 81.4, 0, 1221000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(150, 70, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 15000, 81.4, 0, 1221000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(151, 71, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 15000, 82.94, 81.4, 1244100, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(152, 71, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 15000, 82.94, 81.4, 1244100, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(153, 72, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1588000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(154, 72, 0, 'receipt', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 0, 0, 0, 1588000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(155, 73, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 400000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(156, 73, 0, 'receipt', '', 'receivable', 'Zafar Patwari', '', '', '', '', 0, 0, 0, 400000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(157, 74, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1280000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(158, 74, 0, 'receipt', '', 'receivable', 'H.M.Hussain', '', '', '', '', 0, 0, 0, 1280000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(159, 75, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 150000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(160, 75, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 150000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(161, 76, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1940000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(162, 76, 0, 'receipt', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 0, 0, 0, 1940000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(163, 77, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 415000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(164, 77, 0, 'receipt', '', 'receivable', 'H.M.Hussain', '', '', '', '', 0, 0, 0, 415000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(165, 78, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 700000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(166, 78, 0, 'receipt', '', 'receivable', 'Safdar Lahore', '', '', '', '', 0, 0, 0, 700000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(167, 79, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1110000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(168, 79, 0, 'receipt', '', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 1110000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(169, 80, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 320000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(170, 80, 0, 'receipt', '', 'receivable', 'Safdar Lahore', '', '', '', '', 0, 0, 0, 320000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(171, 81, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 600000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(172, 81, 0, 'receipt', '', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 600000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(173, 82, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 80000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(174, 82, 0, 'receipt', '', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 80000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(175, 83, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 670000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(176, 83, 0, 'receipt', '', 'receivable', 'H.M.Hussain', '', '', '', '', 0, 0, 0, 670000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(177, 84, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 150000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(178, 84, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 150000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(179, 85, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 0, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(180, 85, 0, 'receipt', '', 'receivable', 'H.M.Hussain', '', '', '', '', 0, 0, 0, 0, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(181, 86, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 200000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(182, 86, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 200000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(183, 87, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 250000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(184, 87, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 250000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(185, 88, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 446000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(186, 88, 0, 'receipt', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 0, 0, 0, 446000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(187, 89, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1116790, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(188, 89, 0, 'receipt', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 0, 0, 0, 1116790, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(189, 90, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 788550, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(190, 90, 0, 'receipt', '', 'receivable', 'SEHOLE F/S', '', '', '', '', 0, 0, 0, 788550, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(191, 91, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 653000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(192, 91, 0, 'receipt', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 0, 0, 0, 653000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(193, 92, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 653000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(194, 92, 0, 'receipt', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 0, 0, 0, 653000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(195, 93, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 200000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(196, 93, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 200000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(197, 94, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 250000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(198, 94, 0, 'receipt', '', 'receivable', 'Zafar Patwari', '', '', '', '', 0, 0, 0, 250000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(199, 95, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 325000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(200, 95, 0, 'receipt', '', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 325000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(201, 96, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 850000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(202, 96, 0, 'receipt', '', 'receivable', 'H.M.Hussain', '', '', '', '', 0, 0, 0, 850000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(203, 97, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 100000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(204, 97, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 100000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(205, 98, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 700000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(206, 98, 0, 'receipt', '', 'receivable', 'Safdar Lahore', '', '', '', '', 0, 0, 0, 700000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(207, 99, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 250000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(208, 99, 0, 'receipt', '', 'receivable', 'H.M.Hussain', '', '', '', '', 0, 0, 0, 250000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(209, 100, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 250000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(210, 100, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 250000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(211, 101, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 300000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(212, 101, 0, 'receipt', '', 'receivable', 'Safdar Lahore', '', '', '', '', 0, 0, 0, 300000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(213, 102, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1407500, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(214, 102, 0, 'receipt', '', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 1407500, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(215, 103, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 1588000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(216, 103, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1588000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(217, 104, 0, 'payment', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 0, 0, 0, 1940000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(218, 104, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1940000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(219, 105, 0, 'madina oil company (HBL 02*********803)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 232000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(220, 105, 0, 'receipt', '', 'receivable', 'other', '', '', '', '', 0, 0, 0, 232000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(221, 106, 0, 'madina oil co (MCB 01***********173)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 170000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(222, 106, 0, 'receipt', '', 'receivable', 'other', '', '', '', '', 0, 0, 0, 170000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(223, 107, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 230000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(224, 107, 0, 'madina oil company (HBL 02*********803)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 230000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(225, 108, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 170000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(226, 108, 0, 'madina oil co (MCB 01***********173)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 170000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(227, 109, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 1280000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(228, 109, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1280000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(229, 110, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 150000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(230, 110, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 150000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(231, 111, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 700000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(232, 111, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 700000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(233, 112, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 600000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(234, 112, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 600000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(235, 113, 0, 'payment', '', 'payable', '', 'Ch.Mukhtar Patoki', '', '', '', 0, 0, 0, 320000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(236, 113, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 320000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(237, 114, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 670000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(238, 114, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 670000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(239, 115, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 150000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(240, 115, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 150000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(241, 116, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 200000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(242, 116, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 200000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(243, 117, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 446000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(244, 117, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 446000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(245, 118, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 1116790, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(246, 118, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1116790, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(247, 119, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 653000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(248, 119, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 653000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(249, 120, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 200000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(250, 120, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 200000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(251, 121, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 850000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(252, 121, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 850000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(253, 122, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 100000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(254, 122, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 100000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(255, 123, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 700000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(256, 123, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 700000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(257, 124, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 288000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(258, 124, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 288000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(259, 125, 0, 'payment', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 300000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(260, 125, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 300000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(261, 126, 0, 'payment', '', 'payable', '', 'P.S.O', '', '', '', 0, 0, 0, 1110000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(262, 126, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1110000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(263, 127, 0, 'payment', '', 'payable', '', 'P.S.O', '', '', '', 0, 0, 0, 800000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(264, 127, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 800000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(265, 128, 0, 'payment', '', 'payable', '', 'P.S.O', '', '', '', 0, 0, 0, 788550, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(266, 128, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 788550, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(267, 129, 0, 'payment', '', 'payable', '', 'P.S.O', '', '', '', 0, 0, 0, 325000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(268, 129, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 325000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(269, 130, 0, 'payment', '', 'payable', '', 'P.S.O', '', '', '', 0, 0, 0, 1423050, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(270, 130, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1423050, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(271, 131, 1, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 74.11, 0, 1111650, 0, '', '', 1, '', '2015-08-11 13:45:44', 1),
(272, 131, 1, 'PMG', '', 'payable', '', 'P.S.O', '', '', '', 15000, 74.11, 0, 1111650, 0, '', '', 0, '', '2015-08-11 13:45:44', 1),
(273, 132, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 10000, 81.4, 0, 814000, 0, '', '', 1, '', '2015-08-11 13:45:34', 1),
(274, 132, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 10000, 81.4, 0, 814000, 0, '', '', 0, '', '2015-08-11 13:45:34', 1),
(275, 133, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 25000, 81.4, 0, 2035000, 0, '', '', 1, '', '2015-08-11 13:45:22', 1),
(276, 133, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 25000, 81.4, 0, 2035000, 0, '', '', 0, '', '2015-08-11 13:45:22', 1),
(277, 134, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 10000, 82.94, 81.4, 829400, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(278, 134, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 10000, 82.94, 81.4, 829400, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(279, 135, 1, 'HSD', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 25000, 81.9, 81.4, 2047500, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(280, 135, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 25000, 81.9, 81.4, 2047500, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(281, 136, 0, 'payment', '', 'payable', '', 'ADMORE', '', '', '', 0, 0, 0, 1111650, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(282, 136, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1111650, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(283, 137, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 10000, 81.3, 0, 813000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(284, 137, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 10000, 81.3, 0, 813000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(285, 138, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 25000, 81.3, 0, 2032500, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(286, 138, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 25000, 81.3, 0, 2032500, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(287, 139, 1, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 74.11, 0, 1111650, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(288, 139, 1, 'PMG', '', 'payable', '', 'P.S.O', '', '', '', 15000, 74.11, 0, 1111650, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(289, 140, 1, 'PMG', '', 'receivable', 'Safdar Lahore', '', '', '', '', 10000, 75.08, 74.11, 750800, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(290, 140, 1, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 10000, 75.08, 74.11, 750800, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(291, 141, 1, 'PMG', '', 'receivable', 'H.M.Hussain', '', '', '', '', 5000, 74.47, 74.11, 372350, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(292, 141, 1, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 5000, 74.47, 74.11, 372350, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(293, 142, 1, 'HSD', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 5000, 83.32, 81.8, 416600, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(294, 142, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 5000, 83.32, 81.8, 416600, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(295, 143, 1, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 15000, 14.11, 0, 1111650, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(296, 143, 1, 'PMG', '', 'payable', '', 'P.S.O', '', '', '', 15000, 14.11, 0, 1111650, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(297, 144, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 10000, 81.3, 0, 813000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(298, 144, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 10000, 81.3, 0, 813000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(299, 145, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 5000, 82.94, 81.3, 414700, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(300, 145, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 5000, 82.94, 81.3, 414700, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(301, 146, 1, 'HSD', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 5000, 83.32, 81.3, 416600, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(302, 146, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 5000, 83.32, 81.3, 416600, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(303, 147, 0, 'madina oil company (HBL 02*********803)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 232000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(304, 147, 0, 'receipt', '', 'receivable', '0', '', '', '', '', 0, 0, 0, 232000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(305, 148, 0, 'madina oil company (HBL 02*********803)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 232000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(306, 148, 0, 'receipt', '', 'receivable', '0', '', '', '', '', 0, 0, 0, 232000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(307, 149, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1588000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(308, 149, 0, 'receipt', '', 'receivable', '0', '', '', '', '', 0, 0, 0, 1588000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(309, 150, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 10000, 81.3, 0, 813000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(310, 150, 1, 'HSD', '', 'payable', '', 'Irfan Virik SB', '', '', '', 10000, 81.3, 0, 813000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(311, 151, 1, 'PMG', '', 'receivable', 'H.M.Hussain', '', '', '', '', 15000, 74.47, 74.11, 1117050, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(312, 151, 1, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 15000, 74.47, 74.11, 1117050, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(313, 152, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1588000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(314, 152, 0, 'receipt', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 0, 0, 0, 1588000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(315, 153, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1588000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(316, 153, 0, 'receipt', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 0, 0, 0, 1588000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(317, 154, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1280000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(318, 154, 0, 'receipt', '', 'receivable', 'H.M.Hussain', '', '', '', '', 0, 0, 0, 1280000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(319, 155, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 150000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(320, 155, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 150000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(321, 156, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 400000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(322, 156, 0, 'receipt', '', 'receivable', 'Zafar Patwari', '', '', '', '', 0, 0, 0, 400000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(323, 157, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1940000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(324, 157, 0, 'receipt', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 0, 0, 0, 1940000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(325, 158, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 415000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(326, 158, 0, 'receipt', '', 'receivable', 'SEHOLE F/S', '', '', '', '', 0, 0, 0, 415000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(327, 159, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 700000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(328, 159, 0, 'receipt', '', 'receivable', 'Safdar Lahore', '', '', '', '', 0, 0, 0, 700000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(329, 160, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1110000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(330, 160, 0, 'receipt', '', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 1110000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(331, 161, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 320000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(332, 161, 0, 'receipt', '', 'receivable', 'Safdar Lahore', '', '', '', '', 0, 0, 0, 320000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(333, 162, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 600000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(334, 162, 0, 'receipt', '', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 600000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(335, 163, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 80000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(336, 163, 0, 'receipt', '', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 80000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(337, 164, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 670000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(338, 164, 0, 'receipt', '', 'receivable', 'H.M.Hussain', '', '', '', '', 0, 0, 0, 670000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(339, 165, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 150000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(340, 165, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 150000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(341, 166, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 200000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(342, 166, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 200000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(343, 167, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 250000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0);
INSERT INTO `voucher_entries` (`id`, `voucher_id`, `item_id`, `ac_title`, `ac_sub_title`, `ac_type`, `related_customer`, `related_supplier`, `related_business`, `related_other_agent`, `related_tanker`, `quantity`, `cost_per_item`, `purchase_price_per_item_for_sale`, `amount`, `freight`, `source`, `destination`, `dr_cr`, `description`, `deleted_at`, `deleted`) VALUES
(344, 167, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 250000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(345, 168, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 250000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(346, 168, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 250000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(347, 169, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 446000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(348, 169, 0, 'receipt', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 0, 0, 0, 446000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(349, 170, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1116790, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(350, 170, 0, 'receipt', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 0, 0, 0, 1116790, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(351, 171, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 788550, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(352, 171, 0, 'receipt', '', 'receivable', 'SEHOLE F/S', '', '', '', '', 0, 0, 0, 788550, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(353, 172, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 653000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(354, 172, 0, 'receipt', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 0, 0, 0, 653000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(355, 173, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 200000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(356, 173, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 200000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(357, 174, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 250000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(358, 174, 0, 'receipt', '', 'receivable', 'Zafar Patwari', '', '', '', '', 0, 0, 0, 250000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(359, 175, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 325000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(360, 175, 0, 'receipt', '', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 325000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(361, 176, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 850000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(362, 176, 0, 'receipt', '', 'receivable', 'H.M.Hussain', '', '', '', '', 0, 0, 0, 850000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(363, 177, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 100000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(364, 177, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 100000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(365, 178, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 100000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(366, 178, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 100000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(367, 179, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 700000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(368, 179, 0, 'receipt', '', 'receivable', 'Safdar Lahore', '', '', '', '', 0, 0, 0, 700000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(369, 180, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 250000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(370, 180, 0, 'receipt', '', 'receivable', 'H.M.Hussain', '', '', '', '', 0, 0, 0, 250000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(371, 181, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 250000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(372, 181, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 250000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(373, 182, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 300000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(374, 182, 0, 'receipt', '', 'receivable', 'Safdar Lahore', '', '', '', '', 0, 0, 0, 300000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(375, 183, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1407500, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(376, 183, 0, 'receipt', '', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 1407500, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(377, 184, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1111000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(378, 184, 0, 'receipt', '', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 1111000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(379, 185, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 600000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(380, 185, 0, 'receipt', '', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 600000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(381, 186, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 511650, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(382, 186, 0, 'receipt', '', 'payable', '', 'Irfan Virik SB', '', '', '', 0, 0, 0, 511650, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(383, 187, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 975000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(384, 187, 0, 'receipt', '', 'receivable', 'H.M.Hussain', '', '', '', '', 0, 0, 0, 975000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(385, 188, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 450000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(386, 188, 0, 'receipt', '', 'receivable', 'H.M.Hussain', '', '', '', '', 0, 0, 0, 450000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(387, 189, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 400000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(388, 189, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 400000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(389, 190, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 500000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(390, 190, 0, 'receipt', '', 'receivable', 'Safdar Lahore', '', '', '', '', 0, 0, 0, 500000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(391, 191, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 250000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(392, 191, 0, 'receipt', '', 'receivable', 'Zafar Patwari', '', '', '', '', 0, 0, 0, 250000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(393, 192, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1425370, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(394, 192, 0, 'receipt', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 0, 0, 0, 1425370, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(395, 193, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 150000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(396, 193, 0, 'receipt', '', 'receivable', 'M.Aslam Admore', '', '', '', '', 0, 0, 0, 150000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(397, 194, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 788550, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(398, 194, 0, 'receipt', '', 'receivable', 'SEHOLE F/S', '', '', '', '', 0, 0, 0, 788550, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(399, 195, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 172000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(400, 195, 0, 'receipt', '', 'receivable', 'MUZAMMAL PETROLEUM', '', '', '', '', 0, 0, 0, 172000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(401, 196, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 471040, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(402, 196, 0, 'receipt', '', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 471040, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(403, 197, 0, 'payment', '', 'receivable', 'Haider f/s', '', '', '', '', 0, 0, 0, 22224, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(404, 197, 0, 'cash', '', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 22224, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(405, 198, 0, 'payment', '', 'payable', '', 'ADMORE', '', '', '', 0, 0, 0, 400000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(406, 198, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 400000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(407, 199, 0, 'expense a/c', '', 'payable', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(408, 199, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(409, 200, 0, 'expense a/c', '', 'payable', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 100000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(410, 200, 0, 'madina oil co (MCB 01***********173)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 100000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(411, 201, 0, 'expense a/c', '', 'payable', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 5555, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(412, 201, 0, 'cash', '', 'cash', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 5555, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(413, 202, 0, 'payment', '', 'payable', '', 'ADMORE', '', '', '', 0, 0, 0, 71040, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(414, 202, 0, 'madina o/c (alflah 12****789)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 71040, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(415, 203, 1, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 1000, 50.12, 0, 50120, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(416, 203, 1, 'PMG', '', 'payable', '', 'ADMORE', '', '', '', 1000, 50.12, 0, 50120, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(417, 204, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 500, 85, 82.94, 42500, 0, '', '', 1, '', '2015-08-25 14:40:14', 1),
(418, 204, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 500, 85, 82.94, 42500, 0, '', '', 0, '', '2015-08-25 14:40:14', 1),
(419, 205, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 500, 85, 81.3, 42500, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(420, 205, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 500, 85, 81.3, 42500, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(421, 206, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 500, 85, 81.3, 42500, 0, '', '', 1, '', '2015-08-25 14:40:10', 1),
(422, 206, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 500, 85, 81.3, 42500, 0, '', '', 0, '', '2015-08-25 14:40:10', 1),
(423, 207, 1, 'HSD', '', 'receivable', 'H.M.Hussain', '', '', '', '', 9500, 82, 81.3, 779000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(424, 207, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 9500, 82, 81.3, 779000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(425, 208, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 1000, 75, 0, 75000, 0, '', '', 1, '', '2015-08-25 14:41:37', 1),
(426, 208, 1, 'HSD', '', 'payable', '', 'ADMORE', '', '', '', 1000, 75, 0, 75000, 0, '', '', 0, '', '2015-08-25 14:41:37', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `voucher_entries_of_latest_purchases_view`
--
CREATE TABLE IF NOT EXISTS `voucher_entries_of_latest_purchases_view` (
`voucher_entry_id` int(11)
);
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
-- Structure for view `cash_ledgers`
--
DROP TABLE IF EXISTS `cash_ledgers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cash_ledgers` AS select `ve`.`voucher_id` AS `voucher_id`,`v`.`voucher_date` AS `voucher_date`,`v`.`summary` AS `summary`,(case when (`ve`.`dr_cr` = 0) then `ve`.`amount` else 0 end) AS `credit_amount`,(case when (`ve`.`dr_cr` = 1) then `ve`.`amount` else 0 end) AS `debit_amount` from (`voucher_entries` `ve` join `vouchers` `v` on((`ve`.`voucher_id` = `v`.`id`))) where ((`ve`.`ac_title` = 'cash') and (`v`.`deleted` = 0) and (`ve`.`deleted` = 0));

-- --------------------------------------------------------

--
-- Structure for view `current_purchase_cost_view`
--
DROP TABLE IF EXISTS `current_purchase_cost_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `current_purchase_cost_view` AS select `stock_history_view`.`product` AS `product`,`stock_history_view`.`tanker` AS `tanker`,`stock_history_view`.`cost_per_item` AS `cost_per_item`,`stock_history_view`.`voucher_id` AS `voucher_id`,`stock_history_view`.`voucher_entry_id` AS `voucher_entry_id` from (`stock_history_view` join `voucher_entries_of_latest_purchases_view` on((`voucher_entries_of_latest_purchases_view`.`voucher_entry_id` = `stock_history_view`.`voucher_entry_id`))) where (`stock_history_view`.`in_out` = 'in');

-- --------------------------------------------------------

--
-- Structure for view `expense_payments_view`
--
DROP TABLE IF EXISTS `expense_payments_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `expense_payments_view` AS select `vouchers`.`id` AS `voucher_id`,`vouchers`.`voucher_date` AS `voucher_date`,`vouchers`.`summary` AS `summary`,`voucher_entries`.`ac_title` AS `account`,`voucher_entries`.`amount` AS `amount` from (`vouchers` join `voucher_entries` on((`voucher_entries`.`voucher_id` = `vouchers`.`id`))) where ((`vouchers`.`deleted` = 0) and (`voucher_entries`.`deleted` = 0) and (`vouchers`.`voucher_type` = 'expense payment') and (`voucher_entries`.`dr_cr` = '0'));

-- --------------------------------------------------------

--
-- Structure for view `payments_view`
--
DROP TABLE IF EXISTS `payments_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `payments_view` AS select `vouchers`.`id` AS `voucher_id`,`vouchers`.`voucher_date` AS `voucher_date`,`vouchers`.`summary` AS `summary`,(case when (`vouchers`.`bank_ac` = '') then 'cash' else `vouchers`.`bank_ac` end) AS `account`,(case when (`voucher_entries`.`related_supplier` = '') then `voucher_entries`.`related_customer` else `voucher_entries`.`related_supplier` end) AS `agent`,(case when (`voucher_entries`.`related_supplier` = '') then 'customer' else 'supplier' end) AS `agent_type`,`voucher_entries`.`id` AS `entry_id`,`voucher_entries`.`amount` AS `amount` from (`vouchers` join `voucher_entries` on((`voucher_entries`.`voucher_id` = `vouchers`.`id`))) where ((`vouchers`.`voucher_type` = 'payment') and (`voucher_entries`.`dr_cr` = '1') and (`vouchers`.`deleted` = 0));

-- --------------------------------------------------------

--
-- Structure for view `receipts_view`
--
DROP TABLE IF EXISTS `receipts_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `receipts_view` AS select `vouchers`.`id` AS `voucher_id`,`vouchers`.`voucher_date` AS `voucher_date`,`vouchers`.`summary` AS `summary`,(case when (`vouchers`.`bank_ac` = '') then 'cash' else `vouchers`.`bank_ac` end) AS `account`,(case when (`voucher_entries`.`related_supplier` = '') then `voucher_entries`.`related_customer` else `voucher_entries`.`related_supplier` end) AS `agent`,(case when (`voucher_entries`.`related_supplier` = '') then 'customer' else 'supplier' end) AS `agent_type`,`voucher_entries`.`id` AS `entry_id`,`voucher_entries`.`amount` AS `amount` from (`vouchers` join `voucher_entries` on((`voucher_entries`.`voucher_id` = `vouchers`.`id`))) where ((`vouchers`.`voucher_type` = 'receipt') and (`voucher_entries`.`dr_cr` = '0') and (`vouchers`.`deleted` = 0));

-- --------------------------------------------------------

--
-- Structure for view `route_sale_view`
--
DROP TABLE IF EXISTS `route_sale_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `route_sale_view` AS select `vouchers`.`id` AS `invoice_id`,`vouchers`.`voucher_date` AS `date`,`vouchers`.`summary` AS `summary`,`vouchers`.`tanker` AS `tanker`,`voucher_entries`.`id` AS `entry_id`,`voucher_entries`.`amount` AS `freight`,`voucher_entries`.`source` AS `source`,`voucher_entries`.`destination` AS `destination` from (`vouchers` join `voucher_entries` on((`voucher_entries`.`voucher_id` = `vouchers`.`id`))) where ((`voucher_entries`.`dr_cr` = 0) and (`vouchers`.`voucher_type` = 'route_sale') and (`vouchers`.`deleted` = 0) and (`voucher_entries`.`deleted` = 0));

-- --------------------------------------------------------

--
-- Structure for view `stock_history_view`
--
DROP TABLE IF EXISTS `stock_history_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `stock_history_view` AS select `vouchers`.`id` AS `voucher_id`,`voucher_entries`.`id` AS `voucher_entry_id`,`vouchers`.`voucher_date` AS `voucher_date`,`vouchers`.`inserted_at` AS `inserted_at`,`voucher_entries`.`cost_per_item` AS `cost_per_item`,(case when (`vouchers`.`voucher_type` = 'purchase') then 'in' else 'out' end) AS `in_out`,(case when (`vouchers`.`voucher_type` = 'purchase') then `voucher_entries`.`quantity` else 0 end) AS `s_in`,(case when (`vouchers`.`voucher_type` = 'purchase') then 0 else `voucher_entries`.`quantity` end) AS `s_out`,(case when (`vouchers`.`voucher_type` = 'purchase') then 'supplier' else 'customer' end) AS `agent_type`,(case when (`vouchers`.`voucher_type` = 'purchase') then `voucher_entries`.`related_supplier` else `voucher_entries`.`related_customer` end) AS `agent`,`voucher_entries`.`ac_title` AS `product`,`vouchers`.`tanker` AS `tanker` from (`vouchers` join `voucher_entries` on((`voucher_entries`.`voucher_id` = `vouchers`.`id`))) where (((`voucher_entries`.`related_supplier` <> '') or (`voucher_entries`.`related_customer` <> '')) and (`vouchers`.`voucher_type` in ('product_sale','product_sale_with_freight','purchase')) and (`vouchers`.`deleted` = 0) and (`voucher_entries`.`deleted` = 0)) group by `voucher_entries`.`voucher_id`,`voucher_entries`.`item_id` order by `vouchers`.`voucher_date`,`vouchers`.`inserted_at`;

-- --------------------------------------------------------

--
-- Structure for view `stock_view`
--
DROP TABLE IF EXISTS `stock_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `stock_view` AS select `cpcv`.`product` AS `product`,`cpcv`.`tanker` AS `tanker`,(sum(`stock_history_view`.`s_in`) - sum(`stock_history_view`.`s_out`)) AS `quantity`,`cpcv`.`cost_per_item` AS `price_per_unit`,`cpcv`.`voucher_id` AS `purchase_id`,`products`.`id` AS `product_id`,`stock_history_view`.`voucher_entry_id` AS `id` from ((`stock_history_view` left join `current_purchase_cost_view` `cpcv` on(((`cpcv`.`product` = `stock_history_view`.`product`) and (`cpcv`.`tanker` = `stock_history_view`.`tanker`)))) left join `products` on((`products`.`name` = `cpcv`.`product`))) group by `stock_history_view`.`product`,`stock_history_view`.`tanker`;

-- --------------------------------------------------------

--
-- Structure for view `voucher_entries_of_latest_purchases_view`
--
DROP TABLE IF EXISTS `voucher_entries_of_latest_purchases_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `voucher_entries_of_latest_purchases_view` AS select max(`stock_history_view`.`voucher_entry_id`) AS `voucher_entry_id` from `stock_history_view` where (`stock_history_view`.`in_out` = 'in') group by `stock_history_view`.`product`,`stock_history_view`.`tanker`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
