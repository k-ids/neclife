-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2020 at 06:18 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `neclive`
--

-- --------------------------------------------------------

--
-- Table structure for table `gsk_export_da_items`
--

CREATE TABLE `gsk_export_da_items` (
  `id` int(11) NOT NULL,
  `da_no` int(11) DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `financial_year` varchar(10) DEFAULT NULL,
  `marks_drum_no` varchar(255) DEFAULT NULL,
  `kind_of_package` varchar(255) DEFAULT NULL,
  `description_of_goods` varchar(255) DEFAULT NULL,
  `qty` varchar(50) DEFAULT NULL,
  `rate` varchar(50) DEFAULT NULL,
  `amount` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gsk_export_da_items`
--

INSERT INTO `gsk_export_da_items` (`id`, `da_no`, `invoice_no`, `financial_year`, `marks_drum_no`, `kind_of_package`, `description_of_goods`, `qty`, `rate`, `amount`, `created_at`) VALUES
(13, 1, 'GX8ckhST4wPc4ca4238a0b923820dcc509a6f75849b', '2020-2021', '1-2', '10/15/20/25', 'CEFEPIME HCL', '34.00', '12.00', '408.00', '2020-08-26 10:30:59'),
(14, 1, 'GX8ckhST4wPc4ca4238a0b923820dcc509a6f75849b', '2020-2021', '12-34', 'EXPORT STANDARD PACKING', '2- MERCAPTOBENZOTHIAZOLE (CEFTRIZXONE)', '349.00', '120.00', '41880.00', '2020-08-26 10:30:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gsk_export_da_items`
--
ALTER TABLE `gsk_export_da_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gsk_export_da_items`
--
ALTER TABLE `gsk_export_da_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
