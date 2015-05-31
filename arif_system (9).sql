-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2015 at 12:46 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `arif_system`
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
(1, 'virik', 'virik123', 'viriklogistics', 2),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'lahore', '2015-05-06 19:10:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'karachi', '2015-05-06 19:11:39', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, 'faisalabad', '2015-05-06 19:11:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(2, 'Akram Ali bhutta', '123456', 'lahore, Punjab, Pakistan', '2015-04-10 12:25:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(9, 'Ahmad', '', '', '2015-05-17 12:32:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `expense_titles`
--

INSERT INTO `expense_titles` (`id`, `title`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'tea expense', '2015-05-05 12:00:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'Tire Puncher', '2015-05-05 13:18:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'Wheel Change', '2015-05-05 13:18:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, 'Oil Change', '2015-05-05 13:18:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, 'Driver salary', '2015-05-17 07:08:29', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(6, 'other expense', '2015-05-26 08:08:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `inserted_at`, `updated_at`) VALUES
(2, 'PMG', 'Premier Motor Gasoline', '2015-05-07 20:50:32', '0000-00-00 00:00:00'),
(3, 'HSD', 'High Speed Deisel', '2015-05-16 16:04:03', '0000-00-00 00:00:00'),
(4, 'New Product', '', '2015-05-29 07:39:08', '0000-00-00 00:00:00');

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
(2, 'products', 'index'),
(3, 'purchases', 'invoices'),
(4, 'sales', 'product_with_freight_history'),
(5, 'stock', 'show'),
(6, 'accounts', 'index'),
(7, 'reports', 'index'),
(8, 'suppliers', 'index'),
(9, 'settings', 'accounts'),
(10, 'payments', 'make'),
(11, 'daybook', 'index'),
(12, 'receipts', 'make'),
(13, 'admin', 'home'),
(14, 'tankers', 'all'),
(15, 'expenses', 'add'),
(16, 'withdrawls', 'accounts'),
(17, 'source_destination', 'index'),
(18, 'ledgers', 'withdrawls');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `product_id`, `quantity`, `tanker`, `purchase_id`, `price_per_unit`, `updated_at`) VALUES
(1, 2, 900, 'tlv-238', 18, 100, '2015-05-31 11:54:43'),
(2, 3, 0, 'tlv-238', 1, 100, '2015-05-31 11:28:33'),
(3, 4, 0, 'tlv-238', 1, 100, '2015-05-31 11:28:33'),
(4, 2, 123, 'tlu-249', 16, 123, '2015-05-29 17:21:16'),
(5, 3, 123, 'tlu-249', 16, 123, '2015-05-29 17:21:16'),
(6, 4, 0, 'tlu-249', 0, 0, '0000-00-00 00:00:00');

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
(1, 'arshad', '', '', '2015-04-14 07:27:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(4, 'noman tufail', '03154379760', '', '2015-04-20 05:04:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, 'Test supp Zeeshan', '92348578934', 'lahore, punjab', '2015-05-17 06:24:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tankers`
--

INSERT INTO `tankers` (`id`, `name`, `number`, `capacity`, `chambers`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'hino 1', 'tlv-238', 40000, 4, '2015-05-29 07:42:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'hino 2', 'tlu-249', 50000, 3, '2015-05-29 07:42:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_bank_accounts`
--

INSERT INTO `user_bank_accounts` (`id`, `title`, `account_number`, `bank`, `type`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'Yasir Ali', '1234567897', 'Al-Falah', 'current', '2015-04-30 12:58:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'Mukhtar shah', '9876543212', 'Standard Charted', 'current', '2015-04-30 12:58:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `voucher_date`, `summary`, `tanker`, `voucher_type`, `product_sale_id`, `product_for_freight_voucher`, `inserted_at`, `deleted_at`, `updated_at`, `deleted`) VALUES
(1, '2015-05-29', '', 'tlv-238', 'purchase', 0, '', '2015-05-29 07:43:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, '2015-05-29', '', 'tlv-238', 'product_sale_with_freight', 0, '', '2015-05-29 07:44:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, '2015-05-29', '', 'tlv-238', 'freight_sale', 2, 'New Product', '2015-05-29 07:44:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, '2015-05-29', '', 'tlv-238', 'product_sale', 0, '', '2015-05-29 07:48:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, '2015-05-29', '', 'tlv-238', 'product_sale_with_freight', 0, '', '2015-05-29 07:48:54', '2015-05-29 15:47:46', '0000-00-00 00:00:00', 1),
(6, '2015-05-29', '', 'tlv-238', 'freight_sale', 5, 'PMG', '2015-05-29 07:48:54', '2015-05-29 15:47:46', '0000-00-00 00:00:00', 1),
(7, '2015-05-29', '', 'tlv-238', 'freight_sale', 5, 'New Product', '2015-05-29 07:48:54', '2015-05-29 15:47:46', '0000-00-00 00:00:00', 1),
(8, '2015-05-29', 'paid to noman tufail', '', 'payment', 0, '', '2015-05-29 08:05:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(9, '2015-05-29', '', 'tlv-238', 'product_sale_with_freight', 0, '', '2015-05-29 10:28:40', '2015-05-29 15:33:16', '0000-00-00 00:00:00', 1),
(10, '2015-05-29', '', 'tlv-238', 'freight_sale', 9, 'PMG', '2015-05-29 10:28:40', '2015-05-29 15:33:16', '0000-00-00 00:00:00', 1),
(11, '2015-05-29', '', 'tlv-238', 'product_sale', 0, '', '2015-05-29 10:48:04', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(12, '2015-05-29', '', '', 'expense_payable', 0, '', '2015-05-29 11:26:37', '2015-05-29 16:27:37', '0000-00-00 00:00:00', 1),
(13, '2015-05-29', '', '', 'expense payment', 0, '', '2015-05-29 11:27:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(14, '2015-05-29', '', '', 'expense payment', 0, '', '2015-05-29 11:34:25', '2015-05-29 16:34:29', '0000-00-00 00:00:00', 1),
(15, '2015-05-29', '', '', 'expense_payable', 0, '', '2015-05-29 11:36:10', '2015-05-29 16:36:28', '0000-00-00 00:00:00', 1),
(16, '2015-05-29', '', 'tlu-249', 'purchase', 0, '', '2015-05-29 12:21:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(17, '2015-05-31', '', 'tlv-238', 'product_sale', 0, '', '2015-05-31 06:28:33', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(18, '2015-05-31', '', 'tlv-238', 'purchase', 0, '', '2015-05-31 06:29:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(19, '2015-05-31', '', 'tlv-238', 'product_sale_with_freight', 0, '', '2015-05-31 06:54:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(20, '2015-05-31', '', 'tlv-238', 'freight_sale', 19, 'PMG', '2015-05-31 06:54:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `voucher_entries`
--

CREATE TABLE IF NOT EXISTS `voucher_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_id` int(11) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `voucher_entries`
--

INSERT INTO `voucher_entries` (`id`, `voucher_id`, `ac_title`, `ac_sub_title`, `ac_type`, `related_customer`, `related_supplier`, `related_business`, `related_other_agent`, `related_tanker`, `quantity`, `cost_per_item`, `purchase_price_per_item_for_sale`, `amount`, `freight`, `source`, `destination`, `dr_cr`, `description`, `deleted_at`, `deleted`) VALUES
(1, 1, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 1000, 100, 0, 100000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(2, 1, 'PMG', '', 'payable', '', 'noman tufail', '', '', '', 1000, 100, 0, 100000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(3, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 1000, 100, 0, 100000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(4, 1, 'HSD', '', 'payable', '', 'noman tufail', '', '', '', 1000, 100, 0, 100000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(5, 1, 'New Product', '', 'asset', '', '', 'Malik Petroleum', '', '', 1000, 100, 0, 100000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(6, 1, 'New Product', '', 'payable', '', 'noman tufail', '', '', '', 1000, 100, 0, 100000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(7, 2, 'New Product', '', 'receivable', 'Ahmad', '', '', '', '', 100, 102, 100, 10200, 7000, '', '', 1, '', '0000-00-00 00:00:00', 0),
(8, 2, 'New Product', '', 'revenue', '', '', 'Malik Petroleum', '', '', 100, 102, 100, 10200, 7000, '', '', 0, '', '0000-00-00 00:00:00', 0),
(9, 3, 'freight_cash', '', 'receivable', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 7000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(10, 3, 'freight a/c', '', 'revenue', '', '', '', '', 'tlv-238', 0, 0, 0, 7000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(11, 4, 'PMG', '', 'receivable', 'Ahmad', '', '', '', '', 100, 102, 100, 10200, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(12, 4, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 100, 102, 100, 10200, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(13, 4, 'HSD', '', 'receivable', 'Ahmad', '', '', '', '', 100, 103, 100, 10300, 0, '', '', 1, '', '2015-05-29 15:47:53', 1),
(14, 4, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 100, 103, 100, 10300, 0, '', '', 0, '', '2015-05-29 15:47:53', 1),
(15, 5, 'PMG', '', 'receivable', 'Ahmad', '', '', '', '', 100, 102, 100, 10200, 4000, '', '', 1, '', '2015-05-29 12:58:17', 1),
(16, 5, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 100, 102, 100, 10200, 4000, '', '', 0, '', '2015-05-29 12:58:17', 1),
(17, 5, 'New Product', '', 'receivable', 'Ahmad', '', '', '', '', 100, 102, 100, 10200, 4000, '', '', 1, '', '0000-00-00 00:00:00', 0),
(18, 5, 'New Product', '', 'revenue', '', '', 'Malik Petroleum', '', '', 100, 102, 100, 10200, 4000, '', '', 0, '', '0000-00-00 00:00:00', 0),
(19, 6, 'freight_cash', '', 'receivable', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 4000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(20, 6, 'freight a/c', '', 'revenue', '', '', '', '', 'tlv-238', 0, 0, 0, 4000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(21, 7, 'freight_cash', '', 'receivable', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 4000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(22, 7, 'freight a/c', '', 'revenue', '', '', '', '', 'tlv-238', 0, 0, 0, 4000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(23, 8, 'cash', '', 'payable', '', 'noman tufail', '', '', '', 0, 0, 0, 100000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(24, 8, 'Yasir Ali (Al-Falah 12*****897)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 100000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(25, 9, 'PMG', '', 'receivable', 'Ahmad', '', '', '', '', 0, 0, 100, 0, 0, '', '', 1, '', '2015-05-29 15:33:16', 1),
(26, 9, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 0, 0, 100, 0, 0, '', '', 0, '', '2015-05-29 15:33:16', 1),
(27, 10, 'freight_cash', '', 'receivable', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 0, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(28, 10, 'freight a/c', '', 'revenue', '', '', '', '', 'tlv-238', 0, 0, 0, 0, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(29, 11, 'PMG', '', 'receivable', 'Ahmad', '', '', '', '', 100, 102, 100, 10200, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(30, 11, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 100, 102, 100, 10200, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(31, 12, 'tea expense', '', 'expense', '', '', '', '', 'tlv-238', 0, 0, 0, 100, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(32, 12, 'expense a/c', '', 'payable', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 100, 0, '', '', 0, 'tea expense', '0000-00-00 00:00:00', 0),
(33, 13, 'expense a/c', '', 'payable', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(34, 13, 'Yasir Ali (Al-Falah 12*****897)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(35, 14, 'expense a/c', '', 'payable', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 123, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(36, 14, 'Yasir Ali (Al-Falah 12*****897)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 123, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(37, 15, 'tea expense', '', 'expense', '', '', '', '', 'tlv-238', 0, 0, 0, 1233, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(38, 15, 'expense a/c', '', 'payable', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1233, 0, '', '', 0, 'tea expense', '0000-00-00 00:00:00', 0),
(39, 16, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 123, 123, 0, 15129, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(40, 16, 'HSD', '', 'payable', '', 'Test supp Zeeshan', '', '', '', 123, 123, 0, 15129, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(41, 16, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 123, 123, 0, 15129, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(42, 16, 'PMG', '', 'payable', '', 'Test supp Zeeshan', '', '', '', 123, 123, 0, 15129, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(43, 17, 'PMG', '', 'receivable', 'Ahmad', '', '', '', '', 800, 102, 100, 81600, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(44, 17, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 800, 102, 100, 81600, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(45, 17, 'HSD', '', 'receivable', 'Ahmad', '', '', '', '', 1000, 102, 100, 102000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(46, 17, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 1000, 102, 100, 102000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(47, 17, 'New Product', '', 'receivable', 'Ahmad', '', '', '', '', 900, 102, 100, 91800, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(48, 17, 'New Product', '', 'revenue', '', '', 'Malik Petroleum', '', '', 900, 102, 100, 91800, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(49, 18, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 1000, 100, 0, 100000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(50, 18, 'PMG', '', 'payable', '', 'noman tufail', '', '', '', 1000, 100, 0, 100000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(51, 19, 'PMG', '', 'receivable', 'Ahmad', '', '', '', '', 100, 102, 100, 10200, 4000, '', '', 1, '', '0000-00-00 00:00:00', 0),
(52, 19, 'PMG', '', 'revenue', '', '', 'Malik Petroleum', '', '', 100, 102, 100, 10200, 4000, '', '', 0, '', '0000-00-00 00:00:00', 0),
(53, 20, 'freight_cash', '', 'receivable', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 4000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(54, 20, 'freight a/c', '', 'revenue', '', '', '', '', 'tlv-238', 0, 0, 0, 4000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
