-- phpMyAdmin SQL Dump
-- Version: 5.2.1
-- Host: 127.0.0.1
-- Server Version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `zenfinityaccount`

-- Table structure for `archiveaccount`
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

-- Table structure for `archiveproduct`
CREATE TABLE `archiveproduct` (
    `ProductID` INT NOT NULL AUTO_INCREMENT,
    `ProductName` VARCHAR(255) NOT NULL,
    `ProductType` VARCHAR(255) NOT NULL,
    `Color` TEXT NOT NULL,
    `Description` VARCHAR(255) NOT NULL,
    `Quantity` INT NOT NULL,
    `Price` INT NOT NULL,
    PRIMARY KEY (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `archiveproduct`
INSERT INTO `archiveproduct` (`ProductID`, `ProductName`, `ProductType`, `Color`, `Description`, `Quantity`, `Price`) VALUES
(1, 'Archived Acrylic High Gloss', 'Marine Plywood Acrylic High Gloss', 'Light Gray', '4ft x 8ft x18mm', 10, 4500),
(2, 'Archived PET G High Gloss', 'Marine Plywood PET G High Gloss', 'Light Blue', '4ft x 8ft x18mm', 5, 4500),
(3, 'Archived UV High Gloss', 'Marine Plywood UV High Gloss', 'Dark Gray', '4ft x 8ft x18mm', 2, 3500);

-- Table structure for `product`
CREATE TABLE `product` (
    `ProductID` INT NOT NULL AUTO_INCREMENT,
    `ProductName` VARCHAR(255) NOT NULL,
    `ProductType` VARCHAR(255) NOT NULL,
    `Color` TEXT NOT NULL,
    `Description` VARCHAR(255) NOT NULL,
    `Quantity` INT NOT NULL,
    `Price` INT NOT NULL,
    PRIMARY KEY (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `product`
INSERT INTO `product` (`ProductName`, `ProductType`, `Color`, `Description`, `Quantity`, `Price`) VALUES
('Acrylic High Gloss', 'Marine Plywood Acrylic High Gloss', 'Light Gray', '4ft x 8ft x18mm', 38, 4500),
('PET G High Gloss', 'Marine Plywood PET G High Gloss', 'Light Blue', '4ft x 8ft x18mm', 93, 4500),
('UV High Gloss', 'Marine Plywood UV High Gloss', 'Dark Gray', '4ft x 8ft x18mm', 2, 3500);

-- Table structure for `inventory`
CREATE TABLE `inventory` (
    `InventoryID` INT NOT NULL AUTO_INCREMENT,
    `ProductID` INT NOT NULL,
    `ProductName` VARCHAR(255) NOT NULL,
    `ProductType` VARCHAR(255) NOT NULL,
    `Color` TEXT NOT NULL,
    `Description` VARCHAR(255) NOT NULL,
    `Quantity` INT NOT NULL,
    `Price` INT NOT NULL,
    `EntryTimestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`InventoryID`),
    FOREIGN KEY (`ProductID`) REFERENCES `product`(`ProductID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `inventory`
INSERT INTO `inventory` (`ProductID`, `ProductName`, `ProductType`, `Color`, `Description`, `Quantity`, `Price`, `EntryTimestamp`) VALUES
(1, 'Acrylic High Gloss', 'Marine Plywood Acrylic High Gloss', 'Light Gray', '4ft x 8ft x18mm', 50, 4500, '2023-11-20 10:00:00'),
(2, 'PET G High Gloss', 'Marine Plywood PET G High Gloss', 'Light Blue', '4ft x 8ft x18mm', 100, 4500, '2023-11-20 10:15:00'),
(3, 'UV High Gloss', 'Marine Plywood UV High Gloss', 'Dark Gray', '4ft x 8ft x18mm', 20, 3500, '2023-11-20 10:30:00');

-- Table structure for `sales`
CREATE TABLE `sales` (
    `SalesID` INT NOT NULL AUTO_INCREMENT,
    `CustomerName` VARCHAR(255) NOT NULL,
    `CustomerAddress` VARCHAR(255) NOT NULL,
    `ProductID` INT NOT NULL,
    `ProductName` VARCHAR(255) NOT NULL,
    `ProductType` VARCHAR(255) NOT NULL,
    `Color` TEXT NOT NULL,
    `Description` VARCHAR(255) NOT NULL,
    `Quantity` INT NOT NULL,
    `Price` INT NOT NULL,
    `TotalAmount` INT NOT NULL,
    `OrderTimestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`SalesID`),
    FOREIGN KEY (`ProductID`) REFERENCES `product`(`ProductID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `sales`
INSERT INTO `sales` (`CustomerName`, `CustomerAddress`, `ProductID`, `ProductName`, `ProductType`, `Color`, `Description`, `Quantity`, `Price`, `TotalAmount`, `OrderTimestamp`) VALUES
('John Doe', '123 Main St, City A', 1, 'Acrylic High Gloss', 'Marine Plywood Acrylic High Gloss', 'Light Gray', '4ft x 8ft x18mm', 5, 4500, 22500, '2023-11-20 12:00:00'),
('Jane Smith', '456 Elm St, City B', 2, 'PET G High Gloss', 'Marine Plywood PET G High Gloss', 'Light Blue', '4ft x 8ft x18mm', 10, 4500, 45000, '2023-11-20 12:15:00'),
('Alice Johnson', '789 Oak St, City C', 3, 'UV High Gloss', 'Marine Plywood UV High Gloss', 'Dark Gray', '4ft x 8ft x18mm', 2, 3500, 7000, '2023-11-20 12:30:00');

-- Table structure for `transaction`
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

-- Dumping data for `transaction`
INSERT INTO `transaction` (`SoldTo`, `Address`, `ProductName`, `ProductType`, `Color`, `Description`, `Quantity`, `Price`, `TotalAmount`, `EntryTimestamp`) VALUES
('LOLO MO', 'Sa bahay kubo', 'PET G High Gloss', 'Marine Plywood PET G High Gloss', 'Light Blue', '4ft x 8ft x18mm', 1, 4500, 4500, '2023-10-27 07:38:06'),
('Maria Clara', '123 Bahay Kubo St', 'Acrylic High Gloss', 'Marine Plywood Acrylic High Gloss', 'Light Gray', '4ft x 8ft x18mm', 3, 4500, 13500, '2023-11-21 11:00:00');

-- Table structure for `transaction_counter`
CREATE TABLE `transaction_counter` (
    `last_transaction_number` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `transaction_counter`
INSERT INTO `transaction_counter` (`last_transaction_number`) VALUES (14);

-- Table structure for `user`
CREATE TABLE `user` (
    `ID` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(25) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `Email` VARCHAR(255) NOT NULL,
    `type` ENUM('admin', 'customer', 'supplier') NOT NULL,
    PRIMARY KEY (`ID`),
    UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `user`
INSERT INTO `user` (`username`, `password`, `Email`, `type`) VALUES
('test_admin', 'hashed_password_admin', 'admin@test.com', 'admin'),
('test_customer', 'hashed_password_customer', 'customer@test.com', 'customer'),
('test_supplier', 'hashed_password_supplier', 'supplier@test.com', 'supplier');

-- Table structure for `theinventory`
CREATE TABLE `theinventory` (
    `ProductID` INT NOT NULL,
    `ProductName` VARCHAR(255) NOT NULL,
    `ProductType` VARCHAR(255) NOT NULL,
    `Color` TEXT NOT NULL,
    `Description` VARCHAR(255) NOT NULL,
    `Quantity` INT NOT NULL,
    `Price` INT NOT NULL,
    `EntryTimestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `InventoryID` INT NOT NULL,
    PRIMARY KEY (`InventoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `theinventory`
INSERT INTO `theinventory` (`ProductID`, `ProductName`, `ProductType`, `Color`, `Description`, `Quantity`, `Price`, `EntryTimestamp`, `InventoryID`) VALUES
(1, 'Acrylic High Gloss', 'Marine Plywood Acrylic High Gloss', 'Light Gray', '4ft x 8ft x18mm', 15, 3500, '2023-10-07 12:54:22', 37),
(2, 'PET G High Gloss', 'Marine Plywood PET G High Gloss', 'Light Blue', '4ft x 8ft x18mm', 20, 4500, '2023-10-07 12:55:00', 38);





COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
