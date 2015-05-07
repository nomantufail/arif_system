-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2015 at 10:44 PM
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
(2, 'lahore', '2015-05-06 19:10:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'arshad', '', '', '2015-04-10 12:24:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'akram', '', '', '2015-04-10 12:25:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'noman', '', '', '2015-04-10 14:27:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(4, 'shahid', '', '', '2015-04-10 14:28:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `expense_titles`
--

INSERT INTO `expense_titles` (`id`, `title`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'tea expense', '2015-05-05 12:00:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'Tire Puncher', '2015-05-05 13:18:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'Wheel Change', '2015-05-05 13:18:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, 'Oil Change', '2015-05-05 13:18:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoices`
--

CREATE TABLE IF NOT EXISTS `purchase_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_date` date NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `transaction_type` tinyint(4) NOT NULL DEFAULT '1',
  `paid` double NOT NULL,
  `extra_info` text NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `purchase_invoices`
--

INSERT INTO `purchase_invoices` (`id`, `invoice_date`, `supplier_id`, `transaction_type`, `paid`, `extra_info`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, '2015-04-14', 2, 0, 0, '', '2015-04-14 10:22:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoice_items`
--

CREATE TABLE IF NOT EXISTS `purchase_invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL DEFAULT '0',
  `cost_per_item` double NOT NULL DEFAULT '0',
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `purchase_invoice_items`
--

INSERT INTO `purchase_invoice_items` (`id`, `invoice_id`, `product_id`, `quantity`, `cost_per_item`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 1, 1, 12, 1112, '2015-04-14 10:22:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `router`
--

CREATE TABLE IF NOT EXISTS `router` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller` varchar(100) NOT NULL,
  `function` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `router`
--

INSERT INTO `router` (`id`, `controller`, `function`) VALUES
(1, 'customers', 'index'),
(2, 'products', 'index'),
(3, 'purchases', 'credit_purchase'),
(4, 'sales', 'add_product_sale'),
(5, 'stock', 'index'),
(6, 'accounts', 'suppliers_ledger'),
(7, 'reports', 'index'),
(8, 'suppliers', 'index'),
(9, 'settings', 'accounts'),
(10, 'payments', 'make'),
(11, 'daybook', 'index'),
(12, 'receipts', 'make'),
(13, 'admin', 'login'),
(14, 'tankers', 'index'),
(15, 'expenses', 'titles'),
(16, 'withdrawls', 'withdraw'),
(17, 'source_destination', 'index');

-- --------------------------------------------------------

--
-- Table structure for table `sale_invoices`
--

CREATE TABLE IF NOT EXISTS `sale_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `transaction_type` tinyint(4) NOT NULL DEFAULT '1',
  `recieved` double NOT NULL,
  `extra_info` text NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sale_invoices`
--

INSERT INTO `sale_invoices` (`id`, `invoice_date`, `customer_id`, `transaction_type`, `recieved`, `extra_info`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, '2015-04-10', 3, 0, 4, '', '2015-04-10 14:28:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, '2015-04-10', 4, 0, 4, '', '2015-04-10 14:29:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sale_invoice_items`
--

CREATE TABLE IF NOT EXISTS `sale_invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL DEFAULT '0',
  `sale_price_per_item` double NOT NULL DEFAULT '0',
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sale_invoice_items`
--

INSERT INTO `sale_invoice_items` (`id`, `invoice_id`, `product_id`, `quantity`, `sale_price_per_item`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 1, 1, 3, 4, '2015-04-10 14:28:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 2, 1, 3, 4, '2015-04-10 14:29:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
(4, 'noman', '', '', '2015-04-20 05:04:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, 'zeeshan', '03154379760', 'Lahore, Punjab Pakistan', '2015-05-07 19:39:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
(1, 'Yasir Ali', '123456789', 'Al-Falah', 'current', '2015-04-30 12:58:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'Mukhtar shah', '987654321', 'Standard Charted', 'current', '2015-04-30 12:58:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `amount` double NOT NULL,
  `source` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `dr_cr` tinyint(4) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
