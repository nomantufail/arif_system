-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2015 at 12:17 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `expense_titles`
--

INSERT INTO `expense_titles` (`id`, `title`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(2, 'Tire Puncher', '2015-05-05 13:18:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'Wheel Change', '2015-05-05 13:18:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, 'Oil change', '2015-06-04 10:16:26', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
(4, 'sales', 'add_product_sale'),
(5, 'stock', 'show'),
(6, 'accounts', 'index'),
(7, 'reports', 'daily'),
(8, 'suppliers', 'all'),
(9, 'settings', 'accounts'),
(10, 'payments', 'edit'),
(11, 'daybook', 'summary'),
(12, 'receipts', 'make'),
(13, 'admin', 'home'),
(14, 'tankers', 'all'),
(15, 'expenses', 'add_payment'),
(16, 'withdrawls', 'accounts'),
(17, 'source_destination', 'index'),
(18, 'ledgers', 'bank_accounts');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `product_id`, `quantity`, `tanker`, `purchase_id`, `price_per_unit`, `updated_at`) VALUES
(1, 1, 900, 'tlv-238', 1, 99, '2015-06-04 15:15:43'),
(2, 2, 1000, 'tlv-238', 1, 90, '2015-06-04 15:14:28'),
(3, 1, 0, 'tlu-013', 0, 0, '0000-00-00 00:00:00'),
(4, 2, 0, 'tlu-013', 0, 0, '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `address`, `inerted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'Akram', '', '', '2015-06-04 10:12:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'Haider f/s', '', '', '2015-06-04 10:12:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
(1, 'Hino 1', 'tlv-238', 50000, 4, '2015-06-04 10:13:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'Hino 2', 'tlu-013', 40000, 5, '2015-06-04 10:13:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
  `product_number_for_freight_voucher` int(11) NOT NULL DEFAULT '0',
  `bank_ac` varchar(100) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `voucher_date`, `summary`, `tanker`, `voucher_type`, `product_sale_id`, `product_for_freight_voucher`, `product_number_for_freight_voucher`, `bank_ac`, `inserted_at`, `deleted_at`, `updated_at`, `deleted`) VALUES
(1, '2015-06-04', '', 'tlv-238', 'purchase', 0, '', 0, '', '2015-06-04 10:14:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, '2015-06-04', '', 'tlv-238', 'product_sale', 0, '', 0, '', '2015-06-04 10:15:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, '2015-06-04', '', '', 'expense_payable', 0, '', 0, '', '2015-06-04 10:16:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, '2015-06-04', '', '', 'expense payment', 0, '', 0, '', '2015-06-04 10:17:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `voucher_entries`
--

INSERT INTO `voucher_entries` (`id`, `voucher_id`, `item_id`, `ac_title`, `ac_sub_title`, `ac_type`, `related_customer`, `related_supplier`, `related_business`, `related_other_agent`, `related_tanker`, `quantity`, `cost_per_item`, `purchase_price_per_item_for_sale`, `amount`, `freight`, `source`, `destination`, `dr_cr`, `description`, `deleted_at`, `deleted`) VALUES
(1, 1, 1, 'HSD', '', 'asset', '', '', 'Malik Petroleum', '', '', 1000, 99, 0, 99000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(2, 1, 1, 'HSD', '', 'payable', '', 'Akram', '', '', '', 1000, 99, 0, 99000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(3, 1, 2, 'PMG', '', 'asset', '', '', 'Malik Petroleum', '', '', 1000, 90, 0, 90000, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(4, 1, 2, 'PMG', '', 'payable', '', 'Akram', '', '', '', 1000, 90, 0, 90000, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(5, 2, 1, 'HSD', '', 'receivable', 'Ahmad', '', '', '', '', 100, 102, 99, 10200, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(6, 2, 1, 'HSD', '', 'revenue', '', '', 'Malik Petroleum', '', '', 100, 102, 99, 10200, 0, '', '', 0, '', '0000-00-00 00:00:00', 0),
(7, 3, 0, 'Oil change', '', 'expense', '', '', '', '', 'tlv-238', 0, 0, 0, 1200, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(8, 3, 0, 'expense a/c', '', 'payable', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1200, 0, '', '', 0, 'Oil change', '0000-00-00 00:00:00', 0),
(9, 4, 0, 'expense a/c', '', 'payable', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1200, 0, '', '', 1, '', '0000-00-00 00:00:00', 0),
(10, 4, 0, 'Yasir Ali (Al-Falah 12*****897)', 'current', 'bank', '', '', 'Malik Petroleum', '', '', 0, 0, 0, 1200, 0, '', '', 0, '', '0000-00-00 00:00:00', 0);

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
