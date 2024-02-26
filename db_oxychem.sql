-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2024 at 01:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_oxychem`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets_tbl`
--

CREATE TABLE `assets_tbl` (
  `id` int(11) NOT NULL,
  `department` varchar(120) NOT NULL,
  `assettype` varchar(120) NOT NULL,
  `assettag` varchar(120) NOT NULL,
  `model` varchar(120) NOT NULL,
  `serial` varchar(120) NOT NULL,
  `supplier` varchar(120) NOT NULL,
  `CPU` varchar(120) NOT NULL,
  `MEMORY` varchar(120) NOT NULL,
  `STORAGE` varchar(120) NOT NULL,
  `OS` varchar(120) NOT NULL,
  `Others` varchar(120) NOT NULL,
  `assigned` varchar(120) NOT NULL,
  `status` varchar(120) NOT NULL,
  `location` varchar(120) NOT NULL,
  `datepurchased` date NOT NULL,
  `remarks` varchar(120) NOT NULL,
  `datedeployed` date NOT NULL,
  `dateturnover` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets_tbl`
--

INSERT INTO `assets_tbl` (`id`, `department`, `assettype`, `assettag`, `model`, `serial`, `supplier`, `CPU`, `MEMORY`, `STORAGE`, `OS`, `Others`, `assigned`, `status`, `location`, `datepurchased`, `remarks`, `datedeployed`, `dateturnover`) VALUES
(1, '', 'Monitor', 'MNTR-1', 'yep', 'dad', 'ad', 'ad', 'd', 'ad', 'ad', 'ad', 'Fernando Sudayon', 'Archive', '', '2024-02-15', 'asdsad', '2024-02-16', '0000-00-00'),
(2, 'IT', 'Monitor', 'MNTR-2', 'asds', 'dad', 'ad', 'ad', 'd', 'ad', 'ad', 'ad', 'Fernando Sudayon', 'Archive', 'Pasig', '2024-02-15', 'asdsad', '2024-02-16', '0000-00-00'),
(3, 'IT', 'Monitor', 'MNTR-3', 'ad', 'da', 'ad', 'ada', 'dad', 'a', 'd', '', 'Ezekiel', 'To be Deploy', 'Pasig', '2024-02-15', 'asd', '0000-00-00', '0000-00-00'),
(4, 'IT', 'Printer', 'PRNTR-1', 'ad', 'ada', 'da', 'ad', 'ada', 'd', 'da', '', 'Fernando Sudayon', 'Archive', 'Pasig', '2024-02-16', 'ad', '0000-00-00', '0000-00-00'),
(5, 'IT', 'Printer', 'PRNTR-2', 'Model eupdate e1', 'ada', 'da', 'ad', 'ada', 'd', 'da', '', 'Fernando Sudayon', 'To be Deploy', 'Pasig', '2024-02-16', 'ad', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `category_tbl`
--

CREATE TABLE `category_tbl` (
  `id` int(11) NOT NULL,
  `assetType` varchar(120) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_tbl`
--

INSERT INTO `category_tbl` (`id`, `assetType`, `status`) VALUES
(1, 'Laptop', 1),
(2, 'Monitor', 1),
(3, 'Printer', 1),
(4, 'Mobile', 1),
(5, 'UPS', 1),
(6, 'AVR', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_tbl`
--

CREATE TABLE `employee_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `division` varchar(120) NOT NULL,
  `location` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_tbl`
--

INSERT INTO `employee_tbl` (`id`, `name`, `division`, `location`) VALUES
(1, 'Ezekiel', 'IT', 'Pasig'),
(2, 'Fernando Sudayon', 'IT', 'Pasig');

-- --------------------------------------------------------

--
-- Table structure for table `history_tbl`
--

CREATE TABLE `history_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `action` varchar(120) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_tbl`
--

INSERT INTO `history_tbl` (`id`, `name`, `action`, `date`) VALUES
(1, 'user', 'Turnover Record Tags: MNTR-3 ', '2024-02-17'),
(2, 'user', 'Turnover Record Tags: PRNTR-2 ', '2024-02-17'),
(3, 'user', 'Logged out', '2024-02-17'),
(4, '', 'Logged out', '2024-02-17'),
(5, '', 'Logged out', '2024-02-17'),
(6, '', 'Logged out', '2024-02-17'),
(7, 'user1', 'Logged in', '2024-02-17'),
(8, 'user1', 'Logged out', '2024-02-17'),
(9, 'user1', 'Logged in', '2024-02-17'),
(10, 'user1', 'Logged out', '2024-02-17'),
(11, 'user', 'Logged in', '2024-02-17'),
(12, 'user', 'Logged out', '2024-02-17'),
(13, 'user1', 'Logged in', '2024-02-17'),
(14, 'user1', 'Logged out', '2024-02-17'),
(15, 'user', 'Logged in', '2024-02-17'),
(16, 'user', 'Logged out', '2024-02-17'),
(17, 'user', 'Logged in', '2024-02-17'),
(18, 'user', 'Logged out', '2024-02-17'),
(19, 'user', 'Logged in', '2024-02-17'),
(20, 'user', 'Logged out', '2024-02-17'),
(21, 'user', 'Logged in', '2024-02-17'),
(22, 'user', 'Logged out', '2024-02-17'),
(23, 'user1', 'Logged in', '2024-02-17'),
(24, 'user1', 'Logged out', '2024-02-17');

-- --------------------------------------------------------

--
-- Table structure for table `users_tbl`
--

CREATE TABLE `users_tbl` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role` varchar(60) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_tbl`
--

INSERT INTO `users_tbl` (`id`, `username`, `email`, `password`, `role`, `status`) VALUES
(1, 'user', 'admin@gmail.com', 'admin', 'admin', 1),
(2, 'user1', 'user@gmail.com', '123456', 'user', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets_tbl`
--
ALTER TABLE `assets_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_tbl`
--
ALTER TABLE `category_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_tbl`
--
ALTER TABLE `employee_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_tbl`
--
ALTER TABLE `history_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets_tbl`
--
ALTER TABLE `assets_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category_tbl`
--
ALTER TABLE `category_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employee_tbl`
--
ALTER TABLE `employee_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `history_tbl`
--
ALTER TABLE `history_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
