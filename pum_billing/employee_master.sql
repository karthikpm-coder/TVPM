-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 06:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `khadi_poom`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee_master`
--

CREATE TABLE `employee_master` (
  `emp_id` varchar(20) NOT NULL,
  `emp_name` varchar(50) NOT NULL,
  `design` varchar(50) NOT NULL,
  `region_code` varchar(50) NOT NULL,
  `region_name` varchar(50) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `flag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_master`
--

INSERT INTO `employee_master` (`emp_id`, `emp_name`, `design`, `region_code`, `region_name`, `contact_no`, `email_id`, `flag`) VALUES
('', 'Namasivayamoorthy', 'Sr.Programmer', '10', 'Head Office', '9841496632', 'mnnanamchi@gmail.com', 0),
('131', 'Namasivayamoorthy', 'Sr.Programmer', '16', 'Chennai', '9841496632', 'mnnamachi@gmail.com', 1),
('1312', 'Namasivayamoorthy', 'Sr.Programmer', '10', 'Head Office', '9841496632', 'mnnanamchi@gmail.com', 0),
('1435', 'Mrudhula', 'IAS', '10', 'Head Office', '6369305715', 'mrudhulaandherworld@gmail.com', 0),
('4567', 'Sakthivel', 'System Co-ordinator', '16', 'Chennai', '9865134171', 'sakthivel123@gmail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee_master`
--
ALTER TABLE `employee_master`
  ADD PRIMARY KEY (`emp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
