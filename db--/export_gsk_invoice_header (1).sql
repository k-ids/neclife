-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2020 at 06:17 PM
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
-- Table structure for table `export_gsk_invoice_header`
--

CREATE TABLE `export_gsk_invoice_header` (
  `id` int(11) NOT NULL,
  `invoice_id` varchar(255) NOT NULL,
  `invoice_type` tinyint(4) DEFAULT NULL COMMENT '1-gst, 2-lut',
  `financial_year` varchar(9) DEFAULT NULL,
  `export_type` varchar(50) DEFAULT NULL,
  `address` longtext NOT NULL,
  `buyer_order_number` varchar(50) DEFAULT NULL,
  `buyer_order_date` varchar(50) DEFAULT NULL,
  `contract_number` varchar(50) DEFAULT NULL,
  `contract_date` varchar(50) DEFAULT NULL,
  `da_no` int(11) DEFAULT NULL,
  `da_no_name` varchar(50) NOT NULL,
  `da_date` varchar(25) NOT NULL,
  `po_no` varchar(100) DEFAULT NULL,
  `lic_no` varchar(50) NOT NULL,
  `lic_date` varchar(25) NOT NULL,
  `indent_no` varchar(50) DEFAULT NULL,
  `indent_date` varchar(50) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `invoice_date` varchar(50) DEFAULT NULL,
  `export_reference` varchar(255) DEFAULT NULL,
  `other_reference` varchar(255) NOT NULL,
  `buyer` varchar(255) DEFAULT NULL,
  `consignee` varchar(255) DEFAULT NULL,
  `notify` varchar(255) DEFAULT NULL,
  `notify_1` varchar(255) DEFAULT NULL,
  `pre_carriage_by` varchar(50) DEFAULT NULL,
  `Place_of_reciept` varchar(50) DEFAULT NULL,
  `vessel_flight_no` varchar(50) DEFAULT NULL,
  `port_of_loading` varchar(50) DEFAULT NULL,
  `port_of_discharge` varchar(50) DEFAULT NULL,
  `final_destination` varchar(50) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `term_of_delivery` varchar(50) DEFAULT NULL,
  `term_of_delivery1` varchar(100) DEFAULT NULL,
  `payment_terms` varchar(100) DEFAULT NULL,
  `payment_terms1` varchar(100) DEFAULT NULL,
  `shipping_marks` longtext NOT NULL,
  `freight` decimal(15,2) DEFAULT NULL,
  `currency` varchar(50) DEFAULT NULL,
  `net_weight` decimal(15,2) DEFAULT NULL,
  `tare_weight` decimal(15,2) DEFAULT NULL,
  `gross_weight` decimal(15,2) DEFAULT NULL,
  `product_description` varchar(2000) DEFAULT NULL,
  `declaration` varchar(200) DEFAULT NULL,
  `total` decimal(13,2) NOT NULL,
  `total_amount_words` varchar(255) NOT NULL,
  `ad_lic_file_no` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) NOT NULL,
  `ie_code_no` varchar(255) NOT NULL,
  `cin_no` varchar(255) NOT NULL,
  `gstin` varchar(255) NOT NULL,
  `state` varchar(50) NOT NULL,
  `state_code` varchar(10) NOT NULL,
  `tin_number` varchar(50) NOT NULL,
  `state_of_origin` varchar(25) NOT NULL,
  `district_code` varchar(5) NOT NULL,
  `district_of_origin` varchar(25) NOT NULL,
  `declaretion_final` longtext NOT NULL,
  `currency_name` varchar(10) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `export_gsk_invoice_header`
--

INSERT INTO `export_gsk_invoice_header` (`id`, `invoice_id`, `invoice_type`, `financial_year`, `export_type`, `address`, `buyer_order_number`, `buyer_order_date`, `contract_number`, `contract_date`, `da_no`, `da_no_name`, `da_date`, `po_no`, `lic_no`, `lic_date`, `indent_no`, `indent_date`, `invoice_no`, `invoice_date`, `export_reference`, `other_reference`, `buyer`, `consignee`, `notify`, `notify_1`, `pre_carriage_by`, `Place_of_reciept`, `vessel_flight_no`, `port_of_loading`, `port_of_discharge`, `final_destination`, `country`, `term_of_delivery`, `term_of_delivery1`, `payment_terms`, `payment_terms1`, `shipping_marks`, `freight`, `currency`, `net_weight`, `tare_weight`, `gross_weight`, `product_description`, `declaration`, `total`, `total_amount_words`, `ad_lic_file_no`, `pan_number`, `ie_code_no`, `cin_no`, `gstin`, `state`, `state_code`, `tin_number`, `state_of_origin`, `district_code`, `district_of_origin`, `declaretion_final`, `currency_name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 'GX8ckhST4wPc4ca4238a0b923820dcc509a6f75849b', 0, '2020-2021', NULL, '<p>Address</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Addresss</p>\r\n', 'PO090', '2020-08-11', 'GSK-CONTRACT-09', '12.12.2020', 1, 'A000001-R 2020-2021', '11-Aug-2020', 'PO090', 'GKS-LC_9090', '09.09.2020', 'GSK-INDENT-2020', '12.12.2023', 'GSK_090909', '12.12.20202', '<p>dadad</p>\r\n', 'GSK-Other reference', 'A.A. ONATE WILLY Y COMPANIA S.C.NORTE 196 NO. 694, COL.PENSADOR  MEXICANO 15510,MEXICO,D.F.', 'AFA CHEMIE PHARMACEUTICAL CO.NAVARD ST, NAVARD SQUARE, 17 SHAHRIVAR ST.,SANAYE FELEZI ST. 5TH KM 15 KARAZ ROADTEHRAN, IRAN+982166780781+982164059', 'ACS DOBFAR   S.P.ACENTRO DIREZIONALE COLLEONI  PALAZZO PEGASOINGRESSO 3, 20864,  AGRATE BRIANZA,  MBITALY', 'ABCA PHARMA LAB (THILAND) CO., LTD.103/61-62 MOO 4 RATCHAPHRUEK RD., BANGKRANG.MUANG, NONTHABURI 11000 THILANDFAX: (662) 9262487(662)  926-2428-30', '', 'by Pre-Carrier', '', 'IGI AIRPORT NEW DELHI', '', 'BEIRUT LEBANON', 'INDIA', 'C&F', '', '10 DAYS FROM COA CONFIRMATION', '', 'dadA\r\nDAD\r\nAD\r\nAD\r\nA\r\n', NULL, NULL, '96.00', '96.00', '96.00', NULL, 'adadsadsa', '42288.00', 'Forty Two Thousand Two Hundred Eighty Eight Only', 'File-no-0908', 'AABCS6468G', '3095006365', 'CIN-12234', '13EDWERR2442342342342', 'himachal pradesh', '09', '3095006365', 'himachal pradesh', '0911', 'Kangra', '<ol>\r\n	<li>We declare that this Invoice shows actual price of the goods described &amp; that all the particulars are true and correct.</li>\r\n	<li>Cetified that the Country of Origin of these goods is India.</li>\r\n	<li>In case of any Quality issue please intimate in writing along with the Test Report within 21 days for Oral products and 30 days for Sterile products from the date of shipment. Any claims received after the above mentioned period shall not be entertained and the buyer will be liable to pay the Full Invoice on due date.</li>\r\n	<li>For any delay in receipt after due date, a penal interest @ 21 % for the delayed period will be payable by the buyer to the seller.</li>\r\n</ol>\r\n', 'INR', '1', NULL, '2020-08-26', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `export_gsk_invoice_header`
--
ALTER TABLE `export_gsk_invoice_header`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `export_gsk_invoice_header`
--
ALTER TABLE `export_gsk_invoice_header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
