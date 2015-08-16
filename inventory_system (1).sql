-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2015 at 06:41 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
(3, 'purchases', 'invoices'),
(4, 'sales', 'add_freight_sale'),
(5, 'stock', 'show'),
(6, 'accounts', 'index'),
(7, 'reports', 'daily'),
(8, 'suppliers', 'all'),
(9, 'settings', 'accounts'),
(10, 'payments', 'make'),
(11, 'daybook', 'summary'),
(12, 'receipts', 'make'),
(13, 'admin', 'route_sale_view'),
(14, 'tankers', 'all'),
(15, 'expenses', 'titles'),
(16, 'withdrawls', 'accounts'),
(17, 'source_destination', 'show'),
(18, 'ledgers', 'withdrawls');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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

-- --------------------------------------------------------

--
-- Structure for view `route_sales_view`
--
DROP TABLE IF EXISTS `route_sales_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `route_sales_view` AS select `vouchers`.`id` AS `invoice_id`,`vouchers`.`voucher_date` AS `date`,`vouchers`.`summary` AS `summary`,`vouchers`.`tanker` AS `tanker`,`voucher_entries`.`id` AS `entry_id`,`voucher_entries`.`amount` AS `freight`,`voucher_entries`.`source` AS `source`,`voucher_entries`.`destination` AS `destination` from (`vouchers` join `voucher_entries` on((`voucher_entries`.`voucher_id` = `vouchers`.`id`))) where ((`voucher_entries`.`dr_cr` = 0) and (`vouchers`.`voucher_type` = 'route_sale') and (`vouchers`.`deleted` = 0) and (`voucher_entries`.`deleted` = 0));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
