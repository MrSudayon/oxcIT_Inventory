-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2024 at 07:29 AM
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
  `lastused` varchar(120) NOT NULL,
  `status` varchar(120) NOT NULL,
  `location` varchar(120) NOT NULL,
  `datepurchased` date NOT NULL,
  `cost` int(11) NOT NULL,
  `repair_cost` int(11) NOT NULL,
  `remarks` varchar(120) NOT NULL,
  `datedeployed` date NOT NULL,
  `dateturnover` date NOT NULL,
  `accountability_ref` varchar(120) NOT NULL,
  `turnover_ref` varchar(120) NOT NULL,
  `reason` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets_tbl`
--

INSERT INTO `assets_tbl` (`id`, `department`, `assettype`, `assettag`, `model`, `serial`, `supplier`, `CPU`, `MEMORY`, `STORAGE`, `OS`, `Others`, `assigned`, `lastused`, `status`, `location`, `datepurchased`, `cost`, `repair_cost`, `remarks`, `datedeployed`, `dateturnover`, `accountability_ref`, `turnover_ref`, `reason`) VALUES
(1, 'IT', 'Laptop', 'LPTP-1', 'Dell Inspiron 3480', '31PRBV2', '', 'Intel Core i7 8565U 1.80GHz', '8 GB ', '250 SSD', 'Windows 10 Pro', '', 'Ezekiel Santos', 'Ezekiel Santos', 'Deployed', 'Pasig', '2019-08-01', 0, 0, '', '2019-08-02', '2024-02-29', 'ACCT-D4NY-2024', '', 'Resign'),
(2, '', 'Laptop', 'LPTP-2', 'HP Notebook 14', 'CND4352C6H', '', 'Intel core i3-4030U 1.90Ghz', '10 GB', '700 GB', 'Windows 10', '', 'Rodney Cascante', 'Rodney Cascante', 'Deployed', '', '2019-01-01', 0, 0, '', '0000-00-00', '0000-00-00', '', '', ''),
(3, '', 'Laptop', 'LPTP-3', 'Asus X455 LAB', 'GAN0CV16F41042A', '', 'Intel core i3-5005U 2Ghz', '4 GB', '500 GB', 'Windows 10', '', '', '', 'To be Deploy', '', '2019-01-01', 0, 0, '', '0000-00-00', '0000-00-00', '', '', ''),
(4, '', 'Laptop', 'LPTP-4', 'Acer Aspire A315-41', 'NXGY9SP001816095AF3400', '', 'AMD Ryzen 3 2200U', '4 GB', '1 TB', 'Windows 10', '', '', 'Rico Razal', 'For repair', '', '2019-01-01', 0, 0, 'LCD broken', '0000-00-00', '0000-00-00', '', '', ''),
(5, '', 'Laptop', 'LPTP-5', 'Acer Aspire E5-521', 'NXMLFSP00143522A333400', '', 'AMD E2-6110 APU ', '2 GB', '500 GB', 'Windows 7', '', '', 'Jon Alejo', 'Sell', '', '2019-01-01', 0, 0, '', '0000-00-00', '0000-00-00', '', '', ''),
(6, '', 'Laptop', 'LPTP-6', 'Lenovo  80T7', '80T700BJPH', '', 'Intel Pentium N3710 1.60Ghz', '4 GB', '500 GB', 'Windows 10', '', '', 'Dennis Patris', 'Sell', '', '2019-01-01', 0, 0, '', '0000-00-00', '0000-00-00', '', '', ''),
(7, '', 'Laptop', 'LPTP-7', 'Dell Ispiron 15 3552', 'CWPLWB2', '', 'Intel Pentium N3700 1.60Ghz', '4 GB', '500 GB', 'Windows 10 Pro', '', '', '', 'Sell', '', '2019-01-01', 0, 0, '', '0000-00-00', '0000-00-00', '', '', ''),
(8, '', 'Laptop', 'LPTP-8', 'Acer Aspire ES1-433', 'NXGLYSP0016450801F7200', '', 'Intel core i3-6006U 2Ghz', '4 GB', '480 SSD', 'Windows 10 Pro', '', '', 'Jose Mari Caluag', 'To be Deploy', '', '2019-01-01', 0, 0, '', '0000-00-00', '0000-00-00', '', '', ''),
(9, '', 'Laptop', 'LPTP-9', 'Acer Aspire A315-41', 'NXGY9SP00181904F283400', '', 'AMD Ryzen 3 2200U', '12 GB', '1 TB', 'Windows 10 Pro', '', '', 'Mike Montilla', 'For repair', '', '2019-01-01', 0, 0, '', '0000-00-00', '0000-00-00', '', '', ''),
(10, '', 'Laptop', 'LPTP-10', 'Acer TravelMate P249-G2-MG', 'NXVEASP039811037F17600', '', 'Intel core i5 7200U 2.50Ghz', '12 GB', '480 SSD', 'Windows 10 Pro', '', '', 'Hyacinth Mansilungan', 'For repair', '', '2019-01-01', 0, 0, '', '0000-00-00', '0000-00-00', '', '', ''),
(11, '', 'Laptop', 'LPTP-11', 'Asus UX305LA', 'FBN0CJ00466847F', '', 'Intel core i5-5200U 2.20Ghz', '8 GB', '500 GB', 'Windows 10 Pro', '', '', 'Hanz Gabriel Mercado', 'To be Deploy', '', '2019-01-01', 0, 0, '', '0000-00-00', '0000-00-00', '', '', ''),
(12, '', 'Laptop', 'LPTP-12', 'Lenovo Ideapad 320', '', '', 'Intel core i3-6006U 2Ghz', '4 GB', '1 TB', 'Windows 10 Pro', '', '', 'Herlene Cantores', 'To be Deploy', '', '2019-01-01', 0, 0, '', '0000-00-00', '0000-00-00', '', '', ''),
(13, '', 'Laptop', 'LPTP-13', 'Acer Aspire ES-4736', '', '', 'Intel core i3-5005U 2Ghz', '4 GB', '250 SSD', 'Windows 10 Pro', '', '', 'Jessam Cherreguine', 'For repair', '', '2019-01-01', 0, 0, '', '0000-00-00', '0000-00-00', '', '', ''),
(14, 'Sales/Marketing', 'Laptop', 'LPTP-14', 'Lenovo ideapad 510S', 'MP17QZV6', '', 'Intel core i5-7200U 2Ghz', '8 GB', '250 SSD', '', '', 'Jerry Demegillo', 'Jerry Demegillo', 'Deployed', 'Pasig', '2019-01-01', 0, 0, '', '0000-00-00', '0000-00-00', '', '', ''),
(15, '', 'Laptop', 'LPTP-15', 'Acer Aspire ES1-433', 'NXGLLSP00164600D977200', '', 'Intel core i3-6006U 2Ghz', '4 GB', '500 GB', 'Windows 10 Pro', '', '', 'Ryan Cancicio', 'For repair', '', '2019-01-01', 0, 0, '', '0000-00-00', '0000-00-00', '', '', ''),
(16, '', 'Laptop', 'LPTP-16', 'Asus X555B', 'HBN0CV16T837476', '', 'AMD A9 9420 3Ghz', '4 GB', '500 GB', 'Windows 10 Pro', '', '', 'Andimar Binauhan', 'Sell', '', '2019-01-01', 0, 0, '', '0000-00-00', '0000-00-00', '', '', '');

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
(10, 'Keyboard', 1);

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
(1, 'IT', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_tbl`
--

CREATE TABLE `employee_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `division` varchar(120) NOT NULL,
  `location` varchar(120) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_tbl`
--

INSERT INTO `employee_tbl` (`id`, `name`, `division`, `location`, `status`) VALUES
(1, 'Ezekiel Santos', 'IT', 'Pasig', 1),
(2, 'Fernando Sudayon', 'IT', 'Pasig', 1),
(3, 'Ezekiel Sl', 'Please Select', 'Please Select', 1);

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
(1, 'andong', 'Added a new Asset Data', '2024-02-28'),
(2, 'andong', 'Turnover Record Tags: LPTP-1 ', '2024-02-29'),
(3, 'andong', 'Deleted Accountability Ref for Asset ID: 1', '2024-03-01'),
(4, 'andong', 'Deleted Turnover Ref for Asset Tag: LPTP-1', '2024-03-01'),
(5, 'andong', 'Added a new Asset Data', '2024-03-01'),
(6, 'andong', 'Turnover asset: LPTP-1, assigned to: Fernando Sudayon', '2024-03-01'),
(7, 'andong', 'Turnover asset: PRNTR-1, assigned to: ', '2024-03-01'),
(8, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(9, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(10, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(11, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(12, 'andong', 'Turnover asset: PRNTR-1, Last used by: ', '2024-03-01'),
(13, 'andong', 'Viewed turnover form: PRNTR-1, Last used by: ', '2024-03-01'),
(14, 'andong', 'Viewed turnover form: PRNTR-1, Last used by: ', '2024-03-01'),
(15, 'andong', 'Viewed turnover form: PRNTR-1, Last used by: ', '2024-03-01'),
(16, 'andong', 'Viewed turnover form: PRNTR-1, Last used by: ', '2024-03-01'),
(17, 'andong', 'Viewed turnover form: PRNTR-1, Last used by: ', '2024-03-01'),
(18, 'andong', 'Viewed turnover form: PRNTR-1, Last used by: ', '2024-03-01'),
(19, 'andong', 'Viewed turnover form: PRNTR-1, Last used by: ', '2024-03-01'),
(20, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(21, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(22, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(23, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(24, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(25, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(26, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(27, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(28, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(29, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(30, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(31, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(32, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(33, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(34, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(35, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(36, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(37, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(38, 'andong', 'Viewed turnover form: PRNTR-1, Last used by: ', '2024-03-01'),
(39, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(40, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(41, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(42, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(43, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(44, 'andong', 'Viewed turnover form: PRNTR-1, Last used by: ', '2024-03-01'),
(45, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(46, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(47, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(48, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(49, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(50, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(51, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-01'),
(52, 'andong', 'Added a new Asset Data', '2024-03-04'),
(53, 'andong', 'Added a new Asset Data', '2024-03-04'),
(54, 'andong', 'Deleted Tag: PRNTR-1 from Assets Record', '2024-03-04'),
(55, 'andong', 'Deleted Tag: PRNTR-2 from Assets Record', '2024-03-04'),
(56, 'andong', 'Deleted Tag: UPS-1 from Assets Record', '2024-03-04'),
(57, 'andong', 'Added a new Asset Data', '2024-03-04'),
(58, 'andong', 'Added a new Asset Data', '2024-03-04'),
(59, 'andong', 'Generated turnover form: UPS-1, Last used by: ', '2024-03-04'),
(60, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(61, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(62, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(63, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(64, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(65, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(66, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(67, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(68, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(69, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(70, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(71, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(72, 'andong', 'Generated turnover form: MBL-1, Last used by: none', '2024-03-04'),
(73, 'andong', 'Viewed turnover form: MBL-1, Last used by: none', '2024-03-04'),
(74, 'andong', 'Viewed turnover form: MBL-1, Last used by: none', '2024-03-04'),
(75, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(76, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(77, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(78, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(79, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(80, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(81, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(82, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(83, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(84, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(85, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(86, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(87, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(88, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(89, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(90, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(91, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(92, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(93, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(94, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(95, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(96, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(97, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(98, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(99, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(100, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(101, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(102, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(103, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(104, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(105, 'andong', 'Viewed turnover form: MBL-1, Last used by: none', '2024-03-04'),
(106, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(107, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(108, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(109, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(110, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(111, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(112, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(113, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(114, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(115, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(116, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(117, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(118, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(119, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(120, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(121, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(122, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(123, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(124, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(125, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(126, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(127, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(128, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(129, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(130, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(131, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(132, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(133, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(134, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(135, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(136, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(137, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(138, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(139, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(140, 'andong', 'Viewed turnover form: UPS-1, Last used by: ', '2024-03-04'),
(141, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(142, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(143, 'andong', 'Deleted turnover reference code for Asset Tag: UPS-1', '2024-03-04'),
(144, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(145, 'andong', 'Viewed turnover form: , Last used by: ', '2024-03-04'),
(146, 'andong', 'Viewed turnover form: MBL-1, Last used by: none', '2024-03-04'),
(147, 'andong', 'Viewed turnover form: MBL-1, Last used by: none', '2024-03-04'),
(148, 'andong', 'Viewed turnover form: MBL-1, from Reference tbl Last used by: none', '2024-03-04'),
(149, 'andong', 'Viewed turnover form: MBL-1, from Reference tbl Last used by: none', '2024-03-04'),
(150, 'andong', 'Viewed turnover form: LPTP-1, Last used by: Fernando Sudayon', '2024-03-04'),
(151, '', 'Viewed accountability form: , from Reference tbl Last used by: ', '2024-03-04'),
(152, 'andong', 'Viewed accountability form: MBL-1, from Reference tbl Last used by: none', '2024-03-04'),
(153, 'andong', 'Viewed accountability form: MBL-1, from Reference tbl Last used by: none', '2024-03-04'),
(154, 'andong', 'Added division: ', '2024-03-04'),
(155, 'andong', 'Added division: ', '2024-03-04'),
(156, 'andong', 'Added division: adsg', '2024-03-04'),
(157, 'andong', 'Added division: IT', '2024-03-04'),
(158, 'andong', 'Added division: IT', '2024-03-04'),
(159, '', 'Updated location name: Pasig ', '2024-03-04'),
(160, 'andong', 'Generated a report for: Array', '2024-03-04'),
(161, 'andong', 'Generated a report for: 1, 5, 6', '2024-03-04'),
(162, 'andong', 'Generated a report for: 1, 5, 6', '2024-03-04'),
(163, 'andong', 'Generated a report for: 1, 5, 6', '2024-03-04'),
(164, 'andong', 'Generated a report for: 1, 5, 6', '2024-03-04'),
(165, 'andong', 'Generated a report for: 0, 1', '2024-03-04'),
(166, 'andong', 'Generated a report for: Array', '2024-03-04'),
(167, 'andong', 'Generated a report for: Array', '2024-03-04'),
(168, 'andong', 'Generated a report for asset IDs: 1', '2024-03-04'),
(169, 'andong', 'Generated accountability form: LPTP-1, Last used by: Ezekiel Santos', '2024-03-05'),
(170, 'andong', 'Generated a report for asset IDs: 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15', '2024-03-05'),
(171, 'andong', 'Generated a report for asset IDs: 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15', '2024-03-05'),
(172, 'andong', 'Generated a report for asset IDs: 16', '2024-03-05'),
(173, 'andong', 'Generated a report for asset IDs: 1, 15', '2024-03-05'),
(174, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(175, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(176, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(177, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(178, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(179, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(180, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(181, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(182, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(183, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(184, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(185, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(186, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(187, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(188, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(189, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(190, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(191, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(192, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(193, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(194, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(195, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(196, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(197, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(198, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(199, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(200, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(201, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(202, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(203, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(204, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05'),
(205, 'andong', 'Viewed accountability form for: LPTP-1', '2024-03-05');

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
(1, 'Pasig ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reference_tbl`
--

CREATE TABLE `reference_tbl` (
  `id` int(11) NOT NULL,
  `assetId` int(11) NOT NULL,
  `remarks` varchar(120) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, 'Andong', 'sudayonfernando01@gmail.com', 'admin', 'admin', 1);

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
  ADD KEY `assetId` (`assetId`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `category_tbl`
--
ALTER TABLE `category_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dept_tbl`
--
ALTER TABLE `dept_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_tbl`
--
ALTER TABLE `employee_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `history_tbl`
--
ALTER TABLE `history_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `loc_tbl`
--
ALTER TABLE `loc_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reference_tbl`
--
ALTER TABLE `reference_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reference_tbl`
--
ALTER TABLE `reference_tbl`
  ADD CONSTRAINT `reference_tbl_ibfk_1` FOREIGN KEY (`assetId`) REFERENCES `assets_tbl1` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
