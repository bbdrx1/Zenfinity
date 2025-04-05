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
  `ID` int(255) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archiveaccount`
--

INSERT INTO `archiveaccount` (`ID`, `username`, `password`, `Email`, `type`) VALUES
(27, 'renato', 'cac036e2a615b8d38c8534e75f44cb7c', '', 'Admin'),
(25, 'Renato', 'e2c25b2e85b92e33a9cfd6a75a64860e', '', 'Admin'),
(38, 'example', '1a79a4d60de6718e8e5b326e338ae533', '', 'User'),
(39, 'NATOY', 'b76e79670751dbaea6fe173f23ece013', '', 'User'),
(42, 'tabora', 'cac036e2a615b8d38c8534e75f44cb7c', 'acfwvces2@gmail.com', 'User'),
(40, 'tabora', '36b92df28ee9b4ac5665121ffe7528ce', '', 'Admin'),
(41, 'tabora', '990735d2253d36bbb606757d76b7ed4d', '', 'User'),
(32, 'Ate Wendy', 'e93d6bb8e1a7903dffb0968143b82991', '', 'User'),
(26, 'Renato', 'e2c25b2e85b92e33a9cfd6a75a64860e', '', 'Admin');

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
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', '40', 4500, '2023-11-20 02:05:55.000000', 81),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', '40', 4500, '2023-11-20 02:06:34.000000', 82),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', '40', 4500, '2023-11-20 02:06:57.000000', 83),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', '40', 4500, '2023-11-20 02:07:18.000000', 84),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', '40', 4500, '2023-11-20 02:07:51.000000', 85),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', '40', 4500, '2023-11-20 02:08:23.000000', 86);

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
  `Price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `ProductType`, `Color`, `Description`, `Quantity`, `Price`) VALUES
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 38, 4500),
(2, ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 93, 4500),
(3, ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', '4', 2, 3500);

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
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 15, 3500, '2023-10-07 12:54:22', 37),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 15, 3500, '2023-10-07 12:55:52', 38),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 15, 3500, '2023-10-07 12:57:34', 39),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 15, 3500, '2023-10-07 14:26:34', 40),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 15, 3500, '2023-10-07 14:39:06', 42),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 15, 3500, '2023-10-07 14:40:25', 42),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 10, 3500, '2023-10-07 14:41:02', 44),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 1, 3500, '2023-10-07 15:24:03', 45),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 1, 3500, '2023-10-07 15:24:03', 46),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 10, 3500, '2023-10-07 15:24:34', 47),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 25, 3500, '2023-10-07 15:24:53', 48),
(2, ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 255, 2500, '2023-10-10 11:06:04', 49),
(2, ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 3, 4500, '2023-10-10 13:06:15', 50),
(2, ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 28, 4500, '2023-10-11 13:29:21', 51),
(3, ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8 ft x 18mm', 49, 3500, '2023-10-21 14:07:10', 54),
(3, ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8 ft x 18mm', 5, 3500, '2023-10-21 14:07:28', 55),
(3, ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8 ft x 18mm', 50, 3500, '2023-10-21 14:08:07', 56),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 40, 4500, '2023-10-28 12:06:14', 57),
(2, ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 35, 4500, '2023-10-28 12:06:37', 58),
(3, ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 75, 3500, '2023-10-28 12:06:58', 59),
(3, ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 20, 3500, '2023-10-28 13:06:10', 60),
(2, ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 35, 4500, '2023-10-28 14:17:25', 61),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 40, 4500, '2023-10-28 14:17:25', 62),
(3, ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 75, 3500, '2023-10-28 14:17:25', 63),
(2, ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 35, 4500, '2023-10-28 14:19:43', 64),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 20, 4500, '2023-11-15 18:32:22', 65),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 40, 4500, '2023-11-16 14:11:21', 66),
(1, ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 10, 4500, '2023-11-18 14:22:56', 76);

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
(3, 'LOLO MO', 'Sa bahay kubo', ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', '4ft x 8ft x18mm', 1, 4500, 0, '2023-10-27 07:38:06.000000'),
(3, 'LOLO MO', 'Sa bahay kubo', ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', '4ft x 8ft x18mm', 1, 5500, 0, '2023-10-27 07:38:06.000000'),
(4, 'Wendy Canillo', 'Colegio De San Pedro', ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 5, 22500, 0, '2023-10-28 06:11:16.000000'),
(4, 'Wendy Canillo', 'Colegio De San Pedro', ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 5, 22500, 0, '2023-10-28 06:11:16.000000'),
(4, 'Wendy Canillo', 'Colegio De San Pedro', ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 65, 1365000, 0, '2023-10-28 06:11:16.000000'),
(5, 'Ma\'am Wendy Ganda', 'Sa Encantadia', ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 2, 9000, 0, '2023-10-28 07:09:56.000000'),
(5, 'Ma\'am Wendy Ganda', 'Sa Encantadia', ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 5, 22500, 0, '2023-10-28 07:09:56.000000'),
(5, 'Ma\'am Wendy Ganda', 'Sa Encantadia', ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 30, 315000, 0, '2023-10-28 07:09:56.000000'),
(6, 'tabora', 'BOSS TERMINAL ROOM', ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 1, 4500, 0, '2023-11-06 09:48:51.000000'),
(7, 'tabora', 'BOSS TERMINAL ROOM', ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 49, 882000, 0, '2023-11-15 11:34:07.000000'),
(8, 'ery', 'fdg', ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 50, 3500, 0, '2023-11-16 03:51:27.000000'),
(9, 'tabora', 'meow', ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 50, 175000, 0, '2023-11-16 03:51:34.000000'),
(12, 'tabora', 'meow', ' Uv High Gloss', ' Marine Plywood Uv High Gloss', ' Dark Gray', ' 4ft x 8ft x 18mm', 5, 17500, 0, '2023-11-16 04:30:31.000000'),
(12, 'tabora', 'meow', ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 5, 22500, 0, '2023-11-16 04:30:31.000000'),
(13, 'BOSS', 'meow', ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 2, 9000, 0, '2023-11-16 04:31:12.000000'),
(13, 'BOSS', 'meow', ' PET G High Gloss', ' Marine Plywood PET G High Gloss', ' Light Blue', ' 4ft x 8ft x18mm', 2, 9000, 0, '2023-11-16 04:31:12.000000'),
(14, 'BOSS', 'TERMINAL ROOM', ' Acrylic High Gloss', ' Marine Plywood Acrylic High Gloss', ' Light Gray', ' 4ft x 8ft x18mm', 30, 135000, 0, '2023-11-18 07:23:27.000000');

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
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `username`, `password`, `Email`, `type`) VALUES
(1, 'Admin Tabora', 'a50bc9bdf224ef31de1fa35b78dbb1fc', '', 'admin'),
(34, 'demoUser', 'aa9002fda8075cc8e3522e667f38723e', '', 'User'),
(36, 'Ate Wendy', '34c0200ecd6bfc8505b54ceeadf448b8', '', 'User'),
(44, 'Admin Wendy', 'a50bc9bdf224ef31de1fa35b78dbb1fc', 'wendy@gmail.com', 'User'),
(46, 'Admin Natoy', '70118837ec057a3c1bfe4b289ed28c01', 'renato.tabora@cdsp.edu.ph', 'Admin'),
(47, 'Natoy', '7d6068285aa63888269fba64d9565e4a', 'sadasdasd@gamil.com', 'User'),
(48, 'User Natoy', '70118837ec057a3c1bfe4b289ed28c01', 'aslcjropiweuvct@gmail.com', 'User');

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
  ADD PRIMARY KEY (`ProductID`),
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
