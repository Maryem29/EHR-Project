-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 09, 2025 at 08:42 PM
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
-- Database: `ehr_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `username`, `password`, `email`) VALUES
(2, 'k', '$2y$10$x/eJMP6VERT60a1.CzQ69O9IYnUzJmC8p2.1PRiLaBDutV09IpFea', 'k@gmail.com'),
(4, 'm', '$2y$10$/QvJn0XBNfEtg0Soa7fCueiKem0gDk7akQx9wJXsLfSX4bCFldJWi', 'm@gmail.com'),
(6, 'l', '$2y$10$7.QH9oB/5Ft2SYXvOgeNpeGGmGMT6DaYOTpLH0KsUIhX5YmfoBhcq', 'l@gmail.com'),
(7, 'n', '$2y$10$dk3Gz.w/LWrkesBdV0oNn.wEf3RZflIKQsjpcnXCxhoc3DQFCZTbq', 'n@gmail.com'),
(8, 'r', '$2y$10$393unfa1/yT1GV5yZw6y3.3/b8aZSk27hQZT0H2R0MwY9YJfp9q7W', 'r@gmail.com'),
(9, 'h', '$2y$10$LzSsoCYZC0ZFMZ7EbFjdKe.57dVT9Rh9uvDEO0Vk4tO6zEro1NDvm', 'h@mail.com');

-- --------------------------------------------------------

--
-- Table structure for table `ehr_records`
--

CREATE TABLE `ehr_records` (
  `ehr_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `medical_history` text NOT NULL,
  `allergies` text DEFAULT NULL,
  `medications` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ehr_records`
--

INSERT INTO `ehr_records` (`ehr_id`, `patient_id`, `doctor_id`, `medical_history`, `allergies`, `medications`) VALUES
(1, 1, 6, 'no', 'no', 'yes'),
(2, 2, 7, 'no, no', 'no', 'no'),
(3, 3, 8, 'no,no', 'no', ' no'),
(4, 4, 6, 'no', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `weight` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `doctor_id`, `name`, `age`, `gender`, `weight`) VALUES
(1, 6, 'la', 47, 'Female', 80.00),
(2, 7, 'na', 76, 'Male', 76.00),
(3, 8, 'ra', 43, 'Female', 67.00),
(4, 6, 'lb', 65, 'Other', 65.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ehr_records`
--
ALTER TABLE `ehr_records`
  ADD PRIMARY KEY (`ehr_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ehr_records`
--
ALTER TABLE `ehr_records`
  MODIFY `ehr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ehr_records`
--
ALTER TABLE `ehr_records`
  ADD CONSTRAINT `ehr_records_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ehr_records_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
