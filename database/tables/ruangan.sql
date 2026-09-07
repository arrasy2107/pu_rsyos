-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 07, 2026 at 06:47 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pu_rsyos`
--

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id` int NOT NULL,
  `nama_ruangan` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id`, `nama_ruangan`, `status`) VALUES
(1, 'La Ruffa', 1),
(2, 'Ade Irma\r\n\r\n', 1),
(3, 'Dewi Sartika', 1),
(4, 'Edelweis 1', 1),
(5, 'Edelweis 2\r\n', 1),
(6, 'Edelweis 3\r\n', 1),
(7, 'Perinatal 2\r\n', 1),
(8, 'Perinatal 3\r\n', 1),
(9, 'ICU\r\n', 1),
(10, 'HCU\r\n', 1),
(11, 'Sudirman', 1),
(12, 'tes2', 0),
(13, 'Perina 1', 1),
(14, 'ICU Covid', 1),
(15, 'Herlina', 1),
(16, 'Thamrin', 1),
(17, 'PICU', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
