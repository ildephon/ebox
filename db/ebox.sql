-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2024 at 01:14 PM
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
-- Database: `ebox`
--

-- --------------------------------------------------------

--
-- Table structure for table `citizen_feedback`
--

CREATE TABLE `citizen_feedback` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `pdf` varchar(255) DEFAULT NULL,
  `audio` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `pin` int(11) DEFAULT NULL,
  `focus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sectorofficer`
--

CREATE TABLE `sectorofficer` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `district` int(11) NOT NULL,
  `sector` int(11) NOT NULL,
  `confirmation_code` varchar(10) DEFAULT NULL,
  `code_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sectorofficer`
--

INSERT INTO `sectorofficer` (`id`, `first_name`, `last_name`, `email`, `password`, `district`, `sector`, `confirmation_code`, `code_created_at`) VALUES
(14, 'Admin', 'Admin', 'Admin@gmail.com', '$2y$10$x9VpOtE7oIOG587lPY7/G.VHAU3c.B0rX3Y3EpUjulGQQXvHiBV/2', 1, 1, '899214', '2024-10-06 20:04:13');

-- --------------------------------------------------------

--
-- Table structure for table `sectorstaff`
--

CREATE TABLE `sectorstaff` (
  `id` int(11) NOT NULL,
  `staff_reader_name` varchar(100) NOT NULL,
  `staffname` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `sectorOfficer_email` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sectorstaff`
--

INSERT INTO `sectorstaff` (`id`, `staff_reader_name`, `staffname`, `description`, `image`, `sectorOfficer_email`, `email`, `password`) VALUES
(13, 'aaaaaaaaaaaaa', 'aaaaaaaaaaaaa', ' aaaaaaaaaaaaa aaaaaaaaaaaaa aaaaaaaaaaaaa aaaaaaaaaaaaa aaaaaaaaaaaaa aaaaaaaaaaaaa', '1727365828_8.jpg', 'Admin@gmail.com', 'uwera@gmail.com', '$2y$10$KAB88BamgGo/i2/PdiXPT.MOJtp009ClxnrGJvmfVhNJ7D1qPRFz.'),
(14, 'Petter Kayumba', 'Aggriculture ', 'Agriculture is the practice of cultivating plants, raising animals, and managing natural resources to produce food, fiber, fuel, and other essential products for human survival and economic growth. ', '66eed50789a17.jpg', 'Admin@gmail.com', 'petter@gmail.com', '$2y$10$pyf1XjRXT87jWm8bszAf6OxNkRwLiPaqENh/GDz6o35NcJCBHLAlG'),
(15, 'Karara', 'Sport', 'Sport encompasses a wide range of physical activities, competitions, and games that promote physical fitness, teamwork, skill development, and entertainment.', '66eed56b4f814.jpg', 'Admin@gmail.com', 'karara@gmail.com', '$2y$10$rlLLh67fQ6iaooi/z6uWjepDpPUQef8Fr4vdiEtinlxdAYAe/EBGK');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_district`
--

CREATE TABLE `tbl_district` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_district`
--

INSERT INTO `tbl_district` (`id`, `name`) VALUES
(1, 'Kicukiro');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sector`
--

CREATE TABLE `tbl_sector` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `district_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sector`
--

INSERT INTO `tbl_sector` (`id`, `name`, `district_id`) VALUES
(1, 'Niboyi', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `citizen_feedback`
--
ALTER TABLE `citizen_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `sectorofficer`
--
ALTER TABLE `sectorofficer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sectorstaff`
--
ALTER TABLE `sectorstaff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_district`
--
ALTER TABLE `tbl_district`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sector`
--
ALTER TABLE `tbl_sector`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `citizen_feedback`
--
ALTER TABLE `citizen_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sectorofficer`
--
ALTER TABLE `sectorofficer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sectorstaff`
--
ALTER TABLE `sectorstaff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_district`
--
ALTER TABLE `tbl_district`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_sector`
--
ALTER TABLE `tbl_sector`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
