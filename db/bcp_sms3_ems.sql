-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 02:17 PM
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
-- Database: `bcp_sms3_ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `bcp_sms3_booking`
--

CREATE TABLE `bcp_sms3_booking` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `event_title` varchar(100) DEFAULT NULL,
  `attendees` int(100) DEFAULT NULL,
  `date_booked` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `booked_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Ongoing','Completed','Cancelled') DEFAULT 'Pending',
  `action` enum('Approve','Cancel','Pending') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bcp_sms3_event_history`
--

CREATE TABLE `bcp_sms3_event_history` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `event_title` varchar(100) DEFAULT NULL,
  `attendees` int(100) DEFAULT NULL,
  `date_booked` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `booked_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Cancelled','Completed') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bcp_sms3_event_history`
--

INSERT INTO `bcp_sms3_event_history` (`id`, `name`, `contact`, `event_title`, `attendees`, `date_booked`, `time`, `booked_at`, `status`) VALUES
(33, 'Mia Richardson', '09190123456', 'Entrepreneurship Forum', 9, '2024-11-14', '12:00:00', '2024-11-14 12:39:15', 'Approved'),
(35, 'Yuji', '1234567890', 'Research Festival', 5, '2024-11-14', '09:05:00', '2024-11-14 13:05:49', 'Approved'),
(36, 'pat', '45454', 'Research Festival', 55, '2024-11-14', '09:06:00', '2024-11-14 13:06:47', 'Approved'),
(37, 'pat', '09480362543', 'Research Festival', 55, '2024-11-14', '09:08:00', '2024-11-14 13:07:48', 'Cancelled'),
(38, 'Yuji', '0912345678', 'Suntukan sa court', 55, '2024-12-06', '09:09:00', '2024-11-14 13:09:33', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `bcp_sms3_useracc`
--

CREATE TABLE `bcp_sms3_useracc` (
  `ID` int(11) NOT NULL,
  `Fname` varchar(25) NOT NULL,
  `Email` varchar(25) NOT NULL,
  `accountId` int(6) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bcp_sms3_useracc`
--

INSERT INTO `bcp_sms3_useracc` (`ID`, `Fname`, `Email`, `accountId`, `password`) VALUES
(11, 'Christopher Reboton ', 'test@gmail.com', 123456, '$2y$10$vVDLRqtCU3LILDRvX5OuqeitEWnuZ40sj8jOk2sjDvX7FJDvbmGm6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bcp_sms3_booking`
--
ALTER TABLE `bcp_sms3_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bcp_sms3_event_history`
--
ALTER TABLE `bcp_sms3_event_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bcp_sms3_useracc`
--
ALTER TABLE `bcp_sms3_useracc`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bcp_sms3_booking`
--
ALTER TABLE `bcp_sms3_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `bcp_sms3_event_history`
--
ALTER TABLE `bcp_sms3_event_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `bcp_sms3_useracc`
--
ALTER TABLE `bcp_sms3_useracc`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
