-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2024 at 06:50 PM
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
-- Database: `mailer`
--
DROP DATABASE IF EXISTS `mailer`;
CREATE DATABASE IF NOT EXISTS `mailer` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mailer`;

-- --------------------------------------------------------

--
-- Table structure for table `recovery_code`
--

DROP TABLE IF EXISTS `recovery_code`;
CREATE TABLE `recovery_code` (
  `code_id` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `verification_code` int(10) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recovery_code`
--

INSERT INTO `recovery_code` (`code_id`, `email`, `verification_code`, `creation_date`) VALUES
(1, 'fidelisalen@gmail.com', 948184, '2024-08-10 16:37:15'),
(2, 'fidelisalen@gmail.com', 714091, '2024-08-10 16:39:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recovery_code`
--
ALTER TABLE `recovery_code`
  ADD PRIMARY KEY (`code_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recovery_code`
--
ALTER TABLE `recovery_code`
  MODIFY `code_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
