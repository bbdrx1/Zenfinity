-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2023 at 02:26 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zenfinityaccount`
--

-- --------------------------------------------------------

--
-- Table structure for table `archiveaccount`
--

CREATE TABLE `archiveaccount` (
    `ID` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(25) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `Email` VARCHAR(255) NOT NULL,
    `type` ENUM('admin', 'customer', 'supplier') NOT NULL,
    PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `archiveaccount`
INSERT INTO `archiveaccount` (`ID`, `username`, `password`, `Email`, `type`) VALUES
(1, 'archived_admin', 'hashed_password_1', 'admin@example.com', 'admin'),
(2, 'archived_customer', 'hashed_password_2', 'customer@example.com', 'customer'),
(3, 'archived_supplier', 'hashed_password_3', 'supplier@example.com', 'supplier');


-- --------------------------------------------------------

--
-- Table structure for table `archiveproduct`
--

CREATE TABLE `archiveproduct` (
  `ProductID` int(255) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `ProductType` varchar(255) NOT NULL,
  `Color` text NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Quantity` int(255) NOT NULL,
  `Price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `ProductID` int(255) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `ProductType` varchar(255) NOT NULL,
  `Color` text NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Quantity` varchar(255) NOT NULL,
  `Price` int(255) NOT NULL,
  `EntryTimestamp` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `InventoryID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`ProductID`, `ProductName`, `ProductType`, `Color`, `Description`, `Quantity`, `Price`, `EntryTimestamp`, `InventoryID`) VALUES
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', '40', 4500, '2025-04-11 02:05:55.000000', 81),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', '40', 4500, '2025-04-11 02:06:34.000000', 82),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', '40', 4500, '2025-04-11 02:06:57.000000', 83),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', '40', 4500, '2025-04-11 02:07:18.000000', 84),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', '40', 4500, '2025-04-11 02:07:51.000000', 85),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', '40', 4500, '2025-04-11 02:08:23.000000', 86);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(255) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `ProductType` varchar(255) NOT NULL,
  `Color` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Quantity` int(255) NOT NULL,
  `Price` int(255) NOT NULL,
  `ImageURL` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `ProductType`, `Color`, `Description`, `Quantity`, `Price`, `ImageURL`) VALUES
(1,'Acrylic High Gloss', 'Marine Plywood Acrylic High Gloss', 'Iron Gray', '4ft x 8ft x18mm', 38, 4500.00, 'images/ah_gray.png'),
(2,'PET G High Gloss', 'Marine Plywood PET G High Gloss', 'Light Gray', '4ft x 8ft x18mm', 93, 4500.00, 'images/petg_white.png'),
(3,'UV High Gloss', 'Marine Plywood UV High Gloss', 'Black', '4ft x 8ft x18mm', 2, 3500.00, 'images/ub_black.png'),
(4,'Amber wood', 'Marine Plywood Amber Wood', 'Reddish Brown', '4ft x 8ft x18mm', 38, 4500.00, 'images/amber_wood.jpg'),
(5,'Almond Teak', 'Marine Plywood Almond Teak', 'Light, Neutral Tone', '4ft x 8ft x18mm', 93, 4500.00, 'images/almond_n.jpg'),
(6,'Iron Gray', 'Marine Plywood Iron Gray', 'Iron Gray', '4ft x 8ft x18mm', 2, 3500.00, 'images/iron_gray.jpg'),
(7,'Dec Wood', 'Marine Plywood Dec Wood', 'Light Gray', '4ft x 8ft x18mm', 38, 4500.00, 'images/decwood.jpg'),
(8,'White View', 'Marine Plywood White View', 'Light, Neutral Tone', '4ft x 8ft x18mm', 93, 4500.00, 'images/whiteview.jpg'),
(9,'Lime Oak', 'Marine Plywood Lime Oak', 'Light Gray', '4ft x 8ft x18mm', 2, 3500.00, 'images/limeoak.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `theinventory`
--

CREATE TABLE `theinventory` (
  `ProductID` int(255) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `ProductType` varchar(255) NOT NULL,
  `Color` text NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Quantity` int(255) NOT NULL,
  `Price` int(255) NOT NULL,
  `EntryTimestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `InventoryID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theinventory`
--

INSERT INTO `theinventory` (`ProductID`, `ProductName`, `ProductType`, `Color`, `Description`, `Quantity`, `Price`, `EntryTimestamp`, `InventoryID`) VALUES
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 15, 3500, '2025-04-11 18:07:37', 37),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 15, 3500, '2025-04-11 18:07:37', 38),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 15, 3500, '2025-04-11 18:07:37', 39),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 15, 3500, '2025-04-11 18:07:37', 40),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 15, 3500, '2025-04-11 18:07:37', 42),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 15, 3500, '2025-04-11 18:07:37', 42),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 10, 3500, '2025-04-11 18:07:37', 44),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 1, 3500, '2025-04-11 18:07:37', 45),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 1, 3500, '2025-04-11 18:07:37', 46),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 10, 3500, '2025-04-11 18:07:37', 47),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 25, 3500, '2025-04-11 18:07:37', 48),
(2, ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 255, 2500, '2025-04-11 18:07:37', 49),
(2, ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 3, 4500, '2025-04-11 18:07:37', 50),
(2, ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 28, 4500, '2025-04-11 18:07:37', 51),
(3, ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8 ft x 18mm', 49, 3500, '2025-04-11 18:07:37', 54),
(3, ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8 ft x 18mm', 5, 3500, '2025-04-11 18:07:37', 55),
(3, ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8 ft x 18mm', 50, 3500, '2025-04-11 18:07:37', 56),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 40, 4500, '2025-04-11 18:07:37', 57),
(2, ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 35, 4500, '2025-04-11 18:07:37', 58),
(3, ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 75, 3500, '2025-04-11 18:07:37', 59),
(3, ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 20, 3500, '2025-04-11 18:07:37', 60),
(2, ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 35, 4500, '2025-04-11 18:07:37', 61),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 40, 4500, '2025-04-11 18:07:37', 62),
(3, ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 75, 3500, '2025-04-11 18:07:37', 63),
(2, ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 35, 4500, '2025-04-11 18:07:37', 64),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 20, 4500, '2025-04-11 18:07:37', 65),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 40, 4500, '2025-04-11 18:07:37', 66),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 10, 4500, '2025-04-11 18:07:37', 76);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `TransactionNumber` int(255) NOT NULL,
  `SoldTo` text NOT NULL,
  `Address` varchar(255) NOT NULL,
  `ProductName` text NOT NULL,
  `ProductType` varchar(255) NOT NULL,
  `Color` text NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Quantity` int(255) NOT NULL,
  `Price` int(255) NOT NULL,
  `TotalAmount` int(11) NOT NULL,
  `Entrytimestamp` datetime(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`TransactionNumber`, `SoldTo`, `Address`, `ProductName`, `ProductType`, `Color`, `Description`, `Quantity`, `Price`, `TotalAmount`, `Entrytimestamp`) VALUES
(3, 'LOLO MO', 'Sa bahay kubo', ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', '4ft x 8ft x18mm', 1, 4500, 0, '2025-04-11 18:07:37'),
(3, 'LOLO MO', 'Sa bahay kubo', ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', '4ft x 8ft x18mm', 1, 5500, 0, '2025-04-11 18:07:37'),
(4, 'Wendy Canillo', 'Colegio De San Pedro', ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 5, 22500, 0, '2025-04-11 18:07:37'),
(4, 'Wendy Canillo', 'Colegio De San Pedro', ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 5, 22500, 0, '2025-04-11 18:07:37'),
(4, 'Wendy Canillo', 'Colegio De San Pedro', ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 65, 1365000, 0, '2025-04-11 18:07:37'),
(5, 'Ma\'am Wendy Ganda', 'Sa Encantadia', ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 2, 9000, 0, '2025-04-11 18:07:37'),
(5, 'Ma\'am Wendy Ganda', 'Sa Encantadia', ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 5, 22500, 0, '2025-04-11 18:07:37'),
(5, 'Ma\'am Wendy Ganda', 'Sa Encantadia', ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 30, 315000, 0, '2025-04-11 18:07:37'),
(6, 'tabora', 'BOSS TERMINAL ROOM', ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 1, 4500, 0, '2025-04-11 18:07:37'),
(7, 'tabora', 'BOSS TERMINAL ROOM', ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 49, 882000, 0, '2025-04-11 18:07:37'),
(8, 'ery', 'fdg', ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 50, 3500, 0, '2025-04-11 18:07:37'),
(9, 'tabora', 'meow', ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 50, 175000, 0, '2025-04-11 18:07:37'),
(12, 'tabora', 'meow', ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 5, 17500, 0, '2025-04-11 18:07:37'),
(12, 'tabora', 'meow', ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 5, 22500, 0, '2025-04-11 18:07:37'),
(13, 'BOSS', 'meow', ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 2, 9000, 0, '2025-04-11 18:07:37'),
(13, 'BOSS', 'meow', ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 2, 9000, 0, '2025-04-11 18:07:37'),
(14, 'BOSS', 'TERMINAL ROOM', ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 30, 135000, 0, '2025-04-11 18:07:37');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_counter`
--

CREATE TABLE `transaction_counter` (
  `last_transaction_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transaction_counter`
--

INSERT INTO `transaction_counter` (`last_transaction_number`) VALUES
(14);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
    `ID` int(255) NOT NULL,
    `username` varchar(25) NOT NULL,
    `password` varchar(255) NOT NULL,
    `Email` varchar(255) NOT NULL,
    `type` ENUM('admin', 'customer', 'supplier') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `username`, `password`, `Email`, `type`) VALUES
(1, 'test_admin', '123', 'admin@test.com', 'admin'),
(2, 'test_customer', '123', 'customer@test.com', 'customer'),
(3, 'test_supplier', '123', 'supplier@test.com', 'supplier');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archiveproduct`
--
ALTER TABLE `archiveproduct`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`InventoryID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD UNIQUE KEY `ProductName` (`ProductName`);


--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `InventoryID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
