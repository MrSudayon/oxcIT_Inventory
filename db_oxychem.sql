-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2024 at 05:06 AM
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
  `assettype` varchar(120) NOT NULL,
  `assettag` varchar(120) NOT NULL,
  `model` varchar(120) NOT NULL,
  `serial` varchar(120) NOT NULL,
  `supplier` varchar(120) NOT NULL,
  `empId` int(11) NOT NULL,
  `lastused` varchar(120) NOT NULL,
  `status` varchar(120) NOT NULL,
  `turnoverdate` date NOT NULL,
  `reason` varchar(120) NOT NULL,
  `datepurchased` date NOT NULL,
  `cost` int(11) NOT NULL,
  `repair_cost` int(11) NOT NULL,
  `remarks` varchar(120) NOT NULL,
  `datedeployed` date NOT NULL,
  `cpu` varchar(120) NOT NULL,
  `memory` varchar(120) NOT NULL,
  `storage` varchar(120) NOT NULL,
  `dimes` varchar(120) NOT NULL,
  `mobile` varchar(120) NOT NULL,
  `plan` varchar(120) NOT NULL,
  `os` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets_tbl`
--

INSERT INTO `assets_tbl` (`id`, `assettype`, `assettag`, `model`, `serial`, `supplier`, `empId`, `lastused`, `status`, `turnoverdate`, `reason`, `datepurchased`, `cost`, `repair_cost`, `remarks`, `datedeployed`, `cpu`, `memory`, `storage`, `dimes`, `mobile`, `plan`, `os`) VALUES
(1, 'Monitor', 'MNTR-1', 'Dell', 'DEL1464160ASD', 'Dell Inc.', 2, '', 'Deployed', '2024-04-12', '', '2024-04-10', 4500, 0, 'Bnew', '2024-04-13', '', '', '', '27 Inches', '', '', ''),
(2, 'Monitor', 'MNTR-2', 'ASFASFASF', 'ASFASFA', 'FASf', 2, '', 'Deployed', '0000-00-00', '', '2024-04-01', 4200, 0, 'Motherboard', '2024-04-13', '', '', '', '15\\\\\\', '', '', '');

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
(2, 'Desktop', 0),
(3, 'Monitor', 1),
(4, 'Printer', 1),
(5, 'Mobile', 1),
(6, 'UPS', 1),
(7, 'AVR', 1),
(8, 'OS-L', 1),
(9, 'MSO-L', 1),
(10, 'Keyboard', 1),
(11, 'SIM', 1),
(12, 'Microsoft', 1),
(13, 'HDD', 1);

-- --------------------------------------------------------

--
-- Table structure for table `component_tbl`
--

CREATE TABLE `component_tbl` (
  `id` int(11) NOT NULL,
  `assetId` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` varchar(120) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `component_tbl`
--

INSERT INTO `component_tbl` (`id`, `assetId`, `name`, `quantity`, `description`, `status`) VALUES
(1, 0, 'Keyboards', 2, 'Keyboards Pasig', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dept_tbl`
--

CREATE TABLE `dept_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dept_tbl`
--

INSERT INTO `dept_tbl` (`id`, `name`, `status`) VALUES
(1, 'IT', 1),
(2, 'Boracay', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_tbl`
--

CREATE TABLE `employee_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `division` varchar(120) NOT NULL,
  `location` varchar(120) NOT NULL,
  `empStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_tbl`
--

INSERT INTO `employee_tbl` (`id`, `name`, `division`, `location`, `empStatus`) VALUES
(1, 'Ezekiel Santos', 'IT', 'Pasig', 1),
(2, 'Fernando Sudayon', 'IT', 'Pasig ', 1),
(3, 'Ezekiel Sl', 'Please Select', 'Please Select', 0),
(4, 'boracay', 'Boracay', 'Boracay', 1),
(5, 'Mam ', 'Boracay', 'Pasig ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `history_tbl`
--

CREATE TABLE `history_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `action` varchar(120) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_tbl`
--

INSERT INTO `history_tbl` (`id`, `name`, `action`, `date`) VALUES
(1, 'Ezekiel', 'Added asset record: MNTR-1', '2024-04-12 16:26:15'),
(2, 'Ezekiel', 'Updated item: MNTR-1, ID: 1 from Assets Record', '2024-04-12 16:29:37'),
(3, 'Ezekiel', 'Added Monitor record: MNTR-2', '2024-04-12 16:34:07'),
(4, 'Ezekiel', 'Generated accountability form for asset/s: MNTR-1', '2024-04-12 16:34:46'),
(5, 'Ezekiel', 'Updated reference id: 1', '2024-04-12 16:39:17'),
(6, 'Ezekiel', 'Updated reference id: 1', '2024-04-12 16:40:41'),
(7, 'Ezekiel', 'Updated reference id: 1', '2024-04-12 16:40:48'),
(8, 'Ezekiel', 'Updated reference id: 1', '2024-04-12 16:43:37'),
(9, 'Ezekiel', 'Updated reference id: 1', '2024-04-12 16:43:43'),
(10, '', 'Downloaded accountability file reference id: ', '2024-04-12 16:43:50'),
(11, 'Ezekiel', 'Generated turnover form for multiple assets: MNTR-1', '2024-04-12 16:43:59'),
(12, 'Ezekiel', 'Turnover asset: MNTR-1, last used by: Fernando Sudayon', '2024-04-12 16:45:28'),
(13, 'Ezekiel', 'Updated reference id: 1', '2024-04-12 16:46:02'),
(14, 'Ezekiel', 'Updated item: MNTR-1, ID: 1 from Assets Record', '2024-04-13 09:41:05'),
(15, 'Ezekiel', 'Updated item: MNTR-1, ID: 1 from Assets Record', '2024-04-13 09:41:50'),
(16, 'Ezekiel', 'Updated item: MNTR-2, ID: 2 from Assets Record', '2024-04-13 09:48:45'),
(17, 'Ezekiel', 'Generated accountability form for asset/s: MNTR-1, MNTR-1, MNTR-2', '2024-04-13 09:49:09'),
(18, '', 'Deleted turnover reference code for Asset Tag: MNTR-2', '2024-04-13 09:50:15'),
(19, 'Ezekiel', 'Updated item: MNTR-2, ID: 2 from Assets Record', '2024-04-13 09:52:58'),
(20, 'Ezekiel', 'Generated accountability form for asset/s: MNTR-1, MNTR-1, MNTR-2', '2024-04-13 09:53:06'),
(21, 'Ezekiel', 'Updated reference id: 3', '2024-04-13 10:30:02'),
(22, 'Ezekiel', 'Updated reference id: 5', '2024-04-13 10:30:12'),
(23, 'Ezekiel', 'Generated turnover form for multiple assets: MNTR-1, MNTR-1, MNTR-2', '2024-04-13 10:30:19'),
(24, 'Ezekiel', 'Generated turnover form for multiple assets: MNTR-2, MNTR-1, MNTR-1', '2024-04-13 10:31:08'),
(25, '', 'Deleted turnover reference code for Asset Tag: ', '2024-04-13 10:33:03'),
(26, '', 'Deleted turnover reference code for Asset Tag: ', '2024-04-13 10:33:05'),
(27, '', 'Deleted turnover reference code for Asset Tag: ', '2024-04-13 10:33:06'),
(28, 'Ezekiel', 'Generated turnover form for multiple assets: MNTR-1, MNTR-1, MNTR-2', '2024-04-13 10:33:13'),
(29, '', 'Deleted turnover reference code for Asset Tag: ', '2024-04-13 10:34:15'),
(30, '', 'Deleted turnover reference code for Asset Tag: ', '2024-04-13 10:34:16'),
(31, 'Ezekiel', 'Generated turnover form for multiple assets: MNTR-1, MNTR-1, MNTR-2', '2024-04-13 10:34:22'),
(32, 'Ezekiel', 'Updated reference id: 3', '2024-04-13 10:44:16'),
(33, 'Ezekiel', 'Updated reference id: 1', '2024-04-13 10:44:22'),
(34, 'Ezekiel', 'Updated reference id: 5', '2024-04-13 10:44:57');

-- --------------------------------------------------------

--
-- Table structure for table `loc_tbl`
--

CREATE TABLE `loc_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loc_tbl`
--

INSERT INTO `loc_tbl` (`id`, `name`, `status`) VALUES
(1, 'Pasig ', 1),
(2, 'Boracay', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reference_tbl`
--

CREATE TABLE `reference_tbl` (
  `id` int(11) NOT NULL,
  `assetId` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `accountabilityRef` varchar(120) NOT NULL,
  `accountabilityStatus` int(11) NOT NULL,
  `accountabilityFile` blob NOT NULL,
  `accountabilityDate` date NOT NULL,
  `turnoverRef` varchar(120) NOT NULL,
  `turnoverStatus` int(11) NOT NULL,
  `turnoverFile` blob NOT NULL,
  `turnoverDate` date NOT NULL,
  `turnoverReason` varchar(120) NOT NULL,
  `referenceStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reference_tbl`
--

INSERT INTO `reference_tbl` (`id`, `assetId`, `name`, `accountabilityRef`, `accountabilityStatus`, `accountabilityFile`, `accountabilityDate`, `turnoverRef`, `turnoverStatus`, `turnoverFile`, `turnoverDate`, `turnoverReason`, `referenceStatus`) VALUES
(1, 1, '2', 'ACCT-SCXZW-2024', 2, 0x5343585a512e706466, '2024-04-12', 'TRNO-UPR5J-2024', 2, 0x5343585a51202831292e706466, '2024-04-12', 'Resign', 0),
(3, 1, '2', 'ACCT-A2NZQ-2024', 2, 0x5343585a512e706466, '2024-04-13', 'TRNO-UD8FP-2024', 2, 0x4f56452d3234303232312d303432333638202831292e706466, '2024-04-13', '', 1),
(5, 2, '2', 'ACCT-A2NZQ-2024', 2, 0x5343585a51202831292e706466, '2024-04-13', 'TRNO-UD8FP-2024', 2, 0x5265706f7274202831292e706466, '2024-04-13', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `specs_tbl`
--

CREATE TABLE `specs_tbl` (
  `id` int(11) NOT NULL,
  `assetId` int(11) NOT NULL,
  `type` varchar(60) NOT NULL,
  `cpu` varchar(120) NOT NULL,
  `memory` varchar(120) NOT NULL,
  `storage` varchar(120) NOT NULL,
  `os` varchar(120) NOT NULL,
  `dimes` varchar(120) NOT NULL,
  `hertz` varchar(120) NOT NULL,
  `plan` varchar(120) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specs_tbl`
--

INSERT INTO `specs_tbl` (`id`, `assetId`, `type`, `cpu`, `memory`, `storage`, `os`, `dimes`, `hertz`, `plan`, `status`) VALUES
(1, 17, '', '1', 'Laptop', '', '', '', '', '', 0),
(2, 0, '', '', '', '', '', '', '', '', 1),
(3, 0, '', '', '', '', '', '', '', '', 1),
(4, 0, '', '', '', '', '', '', '', '', 1),
(5, 0, '', '', '', '', '', '', '', '', 0);

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
(1, 'Ezekiel', '', 'admin', 'admin', 1),
(2, 'Andong', 'sudayonfernando01@gmail.com', 'admin', 'user', 1);

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
-- Indexes for table `component_tbl`
--
ALTER TABLE `component_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dept_tbl`
--
ALTER TABLE `dept_tbl`
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
-- Indexes for table `loc_tbl`
--
ALTER TABLE `loc_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reference_tbl`
--
ALTER TABLE `reference_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reference_tbl_ibfk_1` (`assetId`);

--
-- Indexes for table `specs_tbl`
--
ALTER TABLE `specs_tbl`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category_tbl`
--
ALTER TABLE `category_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `component_tbl`
--
ALTER TABLE `component_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dept_tbl`
--
ALTER TABLE `dept_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee_tbl`
--
ALTER TABLE `employee_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `history_tbl`
--
ALTER TABLE `history_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `loc_tbl`
--
ALTER TABLE `loc_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reference_tbl`
--
ALTER TABLE `reference_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `specs_tbl`
--
ALTER TABLE `specs_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
