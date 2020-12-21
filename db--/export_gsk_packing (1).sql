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
-- Table structure for table `export_gsk_packing`
--

CREATE TABLE `export_gsk_packing` (
  `id` int(11) NOT NULL,
  `gsk_id` int(11) NOT NULL,
  `da_no` int(11) NOT NULL,
  `serial_no` int(11) NOT NULL,
  `excise_serial_no` varchar(50) NOT NULL,
  `bag_no` varchar(10) NOT NULL,
  `batch_no` varchar(255) NOT NULL,
  `mfg_date` varchar(50) NOT NULL,
  `retest_date` varchar(50) NOT NULL,
  `tare_wt` varchar(50) DEFAULT NULL,
  `net_wt` varchar(50) DEFAULT NULL,
  `gross_wt` varchar(50) DEFAULT NULL,
  `tare_wt_corrugated` varchar(50) DEFAULT NULL,
  `gross_wt_corrugated` varchar(50) DEFAULT NULL,
  `gross_wt_pallet` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `export_gsk_packing`
--
ALTER TABLE `export_gsk_packing`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `export_gsk_packing`
--
ALTER TABLE `export_gsk_packing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
