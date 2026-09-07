-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 13, 2026 at 01:32 AM
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
-- Table structure for table `log_jenis`
--

CREATE TABLE `log_jenis` (
  `id` int NOT NULL,
  `jenis` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_jenis`
--

INSERT INTO `log_jenis` (`id`, `jenis`) VALUES
(1, 'draft Laporan IGD'),
(2, 'draft Laporan Umum'),
(3, 'draft Laporan IRJ'),
(4, 'detail IRJ'),
(5, 'Kirim Laporan'),
(6, 'Piket'),
(7, 'Pengguna'),
(8, 'Ruangan'),
(9, 'Dokter Jaga (IGD)'),
(10, 'Dokter IRJ'),
(11, 'Jenis SDMK'),
(12, 'Subrumpun SDMK'),
(13, 'Verifikasi Laporan'),
(14, 'Laporan'),
(15, 'Login'),
(16, 'draft Laporan IBS'),
(17, 'detail IBS'),
(18, 'Catatan Pasien');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_jenis`
--
ALTER TABLE `log_jenis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log_jenis`
--
ALTER TABLE `log_jenis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
