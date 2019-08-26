-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2019 at 03:44 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `aId` int(11) NOT NULL,
  `aName` varchar(50) NOT NULL,
  `aDate` datetime NOT NULL,
  `aEmail` varchar(100) NOT NULL,
  `aPassword` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aId`, `aName`, `aDate`, `aEmail`, `aPassword`) VALUES
(1, 'Shakzee', '2018-01-27 13:09:25', 'admin@hotmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cId` int(11) NOT NULL,
  `cName` varchar(100) NOT NULL,
  `cStatus` int(11) NOT NULL DEFAULT '1',
  `cDate` datetime NOT NULL,
  `cDp` varchar(200) NOT NULL,
  `adminId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='add caetegory i.e phone/laptops';

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cId`, `cName`, `cStatus`, `cDate`, `cDp`, `adminId`) VALUES
(1, 'Phones', 1, '0000-00-00 00:00:00', 'download.jpg', 1),
(3, 'Computers', 1, '0000-00-00 00:00:00', 'download_(1).jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `mId` int(11) NOT NULL,
  `mName` varchar(200) DEFAULT NULL,
  `mDate` datetime NOT NULL,
  `mStatus` int(11) NOT NULL DEFAULT '1',
  `productId` int(11) NOT NULL,
  `adminId` int(11) NOT NULL,
  `mDp` varchar(200) NOT NULL,
  `mDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`mId`, `mName`, `mDate`, `mStatus`, `productId`, `adminId`, `mDp`, `mDescription`) VALUES
(3, 'iphone 6', '2018-04-01 14:25:50', 1, 12, 1, 'iphone6s-plus-gold-select-2015.jpg', 'iphone 6iphone 6iphone 6');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pId` int(11) NOT NULL,
  `pName` varchar(200) NOT NULL,
  `pStatus` int(11) NOT NULL DEFAULT '1',
  `pDate` datetime NOT NULL,
  `categoryId` int(11) NOT NULL,
  `adminID` int(11) NOT NULL,
  `pDp` varchar(200) DEFAULT NULL,
  `pCompany` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pId`, `pName`, `pStatus`, `pDate`, `categoryId`, `adminID`, `pDp`, `pCompany`) VALUES
(12, 'Iphone', 1, '2018-03-25 16:22:32', 1, 1, 'apple.jpg', 'Apple');

-- --------------------------------------------------------

--
-- Table structure for table `specs`
--

CREATE TABLE `specs` (
  `spId` int(11) NOT NULL,
  `spName` varchar(100) NOT NULL,
  `spDate` datetime NOT NULL,
  `spStatus` int(11) DEFAULT '1',
  `adminId` int(11) NOT NULL,
  `modelId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specs`
--

INSERT INTO `specs` (`spId`, `spName`, `spDate`, `spStatus`, `adminId`, `modelId`) VALUES
(11, 'color', '2018-11-21 16:50:32', 1, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `spec_values`
--

CREATE TABLE `spec_values` (
  `spvId` int(11) NOT NULL,
  `spvName` varchar(100) NOT NULL,
  `specId` int(11) NOT NULL,
  `adminId` int(11) NOT NULL,
  `spvStatus` int(11) DEFAULT '1',
  `spvDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `spec_values`
--

INSERT INTO `spec_values` (`spvId`, `spvName`, `specId`, `adminId`, `spvStatus`, `spvDate`) VALUES
(19, 'red', 11, 1, 1, '2018-11-21 16:50:32'),
(20, 'green', 11, 1, 1, '2018-11-21 16:50:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uId` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `link` varchar(200) DEFAULT NULL,
  `date` datetime NOT NULL,
  `status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uId`, `first_name`, `last_name`, `email`, `password`, `link`, `date`, `status`) VALUES
(6, 'alex', 'john', 'john@shakzee.com', 'dc468c70fb574ebd07287b38d0d0676d', 'OtgkiYJIlX9LahSFuWyb', '2018-12-30 11:43:58', 0),
(7, 'shakzee', 'Shakzee', 'shakzee171@gmail.com', 'dc468c70fb574ebd07287b38d0d0676d', 'cVny8QE6D5b3NwOIzJt0', '2018-12-30 11:49:10', 0),
(8, 'ami', 'john', 'ami@shakzee.com', 'dc468c70fb574ebd07287b38d0d0676d', 'ZhqQl6Yp8OkbS93Xgaerok', '2018-12-30 12:05:19', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aId`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cId`),
  ADD KEY `categories_admin_aId_fk` (`adminId`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`mId`),
  ADD KEY `models_admin_aId_fk` (`adminId`),
  ADD KEY `models_products_pId_fk` (`productId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pId`),
  ADD KEY `products_admin_aId_fk` (`adminID`),
  ADD KEY `products_categories_cId_fk` (`categoryId`);

--
-- Indexes for table `specs`
--
ALTER TABLE `specs`
  ADD PRIMARY KEY (`spId`),
  ADD KEY `specs_admin_aId_fk` (`adminId`),
  ADD KEY `specs_models_mId_fk` (`modelId`);

--
-- Indexes for table `spec_values`
--
ALTER TABLE `spec_values`
  ADD PRIMARY KEY (`spvId`),
  ADD KEY `spec_values_admin_aId_fk` (`adminId`),
  ADD KEY `spec_values_specs_spId_fk` (`specId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `aId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `mId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `specs`
--
ALTER TABLE `specs`
  MODIFY `spId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `spec_values`
--
ALTER TABLE `spec_values`
  MODIFY `spvId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_admin_aId_fk` FOREIGN KEY (`adminId`) REFERENCES `admin` (`aId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `models`
--
ALTER TABLE `models`
  ADD CONSTRAINT `models_admin_aId_fk` FOREIGN KEY (`adminId`) REFERENCES `admin` (`aId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `models_products_pId_fk` FOREIGN KEY (`productId`) REFERENCES `products` (`pId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_admin_aId_fk` FOREIGN KEY (`adminID`) REFERENCES `admin` (`aId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_categories_cId_fk` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`cId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `specs`
--
ALTER TABLE `specs`
  ADD CONSTRAINT `specs_admin_aId_fk` FOREIGN KEY (`adminId`) REFERENCES `admin` (`aId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `specs_models_mId_fk` FOREIGN KEY (`modelId`) REFERENCES `models` (`mId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `spec_values`
--
ALTER TABLE `spec_values`
  ADD CONSTRAINT `spec_values_admin_aId_fk` FOREIGN KEY (`adminId`) REFERENCES `admin` (`aId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spec_values_specs_spId_fk` FOREIGN KEY (`specId`) REFERENCES `specs` (`spId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
