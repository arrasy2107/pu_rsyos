-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 07, 2026 at 06:48 AM
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
-- Table structure for table `sdmk_jenis`
--

CREATE TABLE `sdmk_jenis` (
  `id` int NOT NULL,
  `id_subrumpun` int NOT NULL,
  `jenis` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sdmk_jenis`
--

INSERT INTO `sdmk_jenis` (`id`, `id_subrumpun`, `jenis`, `status`) VALUES
(1, 1, 'Dokter Umum', 1),
(2, 2, 'Dokter Gigi', 1),
(3, 3, 'Dokter Spesialis Penyakit Dalam (Sp.PD)', 1),
(4, 3, 'Dokter Spesialis Obstetri & Ginekologi - Kebidanan & Kandungan (Sp.OG)', 1),
(5, 3, 'Dokter Spesialis Anak (Sp.A)', 1),
(6, 3, 'Dokter Spesialis Bedah (Sp.B)', 1),
(7, 3, 'Dokter Spesialis Radiologi (Sp.Rad)', 1),
(8, 3, 'Dokter Spesialis Anestesiologi (Sp.An)', 1),
(9, 3, 'Dokter Spesialis Patologi Klinik (SP.PK)', 1),
(10, 3, 'Dokter Spesialis Patologi Anatomi (Sp.PA)', 1),
(11, 3, 'Dokter Spesialis Rehabilitasi Medik (Sp.RM)', 1),
(12, 3, 'Dokter Spesialis Okupasi (Sp.OK)', 1),
(13, 3, 'Dokter Spesialis Penerbangan (Sp.KP)', 1),
(14, 3, 'Dokter Spesialis Gizi Klinik (Sp.GK)', 1),
(15, 3, 'Dokter Spesialis Bedah Thoraks Dan Kardiovaskuler (Sp.BTKV)', 1),
(16, 3, 'Dokter Spesialis Mikrobiologi Klinik (Sp.MK)', 1),
(17, 3, 'Dokter Spesialis Bedah Syaraf (Sp.BS)', 1),
(18, 3, 'Dokter Spesialis Kelautan', 1),
(19, 3, 'Dokter Spesialis Urologi (Sp.U)', 1),
(20, 3, 'Dokter Spesialis Ilmu Kesehatan Kulit Dan Kelamin (Sp.KK)', 1),
(21, 3, 'Dokter Spesialis Neurologi/Saraf (Sp.S)', 1),
(22, 3, 'Dokter Spesialis Orthopedi & Traumatologi (Sp.OT)', 1),
(23, 3, 'Dokter Spesialis Paru & Pulmonologi (Sp.P)', 1),
(24, 3, 'Dokter Spesialis Forensik (Sp.F)', 1),
(25, 3, 'Dokter Spesialis Parasitologi Klinik (Sp.ParK)', 1),
(26, 3, 'Dokter Spesialis Bedah Anak (Sp.BA)', 1),
(27, 3, 'Dokter Spesialis Farmakologi Klinik (Sp.FK)', 1),
(28, 3, 'Dokter Spesialis Kedokteran Olah Raga (Sp.KO)', 1),
(29, 3, 'Dokter Spesialis Psikiatri - Kedokteran Jiwa (Sp.KJ)', 1),
(30, 3, 'Dokter Spesialis Ofthalmologi', 1),
(31, 3, 'Dokter Spesialis Kedokteran Fisik Dan Rehabilitasi (Sp.KFR)', 1),
(32, 3, 'Dokter Spesialis Nuklir (Sp.KN)', 1),
(33, 3, 'Dokter Spesialis Ilmu Kesehatan THT Kl & (Sp.THT-KL)', 1),
(34, 3, 'Dokter Spesialis Bedah Plastik (Sp.BP)', 1),
(35, 3, 'Dokter Spesialis Andrologi (Sp.And)', 1),
(36, 3, 'Dokter Spesialis Mata (Sp.M)', 1),
(37, 3, 'Dokter Spesialis Jantung dan Pembuluh Darah (Sp.JP)', 1),
(38, 3, 'Dokter Spesialis Bedah Orthopedi', 1),
(39, 3, 'Dokter Spesialis Patologi Forensik', 1),
(40, 3, 'Dokter Spesialis Gizi Medik', 1),
(41, 3, 'Dokter Spesialis Kedaruratan Medik - Emergency (Sp.EM)', 1),
(42, 3, 'Dokter Spesialis Akupunktur Klinik (Sp.Ak)', 1),
(43, 3, 'Dokter Spesialis Onkologi Radiasi (Sp.Onk.Rad)', 1),
(44, 3, 'Dokter Spesialis Lainnya yang belum tercantum', 1),
(45, 4, 'Dokter Gigi Spesialis Kawat Gigi - Orthodontis (Sp.Ort)', 1),
(46, 4, 'Dokter Gigi Spesialis Bedah mulut / Maksilofasial (Sp.BM)', 1),
(47, 4, 'Dokter Gigi Spesialis Anak - Pedodontis (Sp.KGA)', 1),
(48, 4, 'Dokter Gigi Spesialis Konservasi Gigi (Sp.KG)', 1),
(49, 4, 'Dokter Gigi Spesialis Gigi Tiruan (Prostodontis) (Sp.Pros)', 1),
(50, 4, 'Dokter Gigi Spesialis Penyakit Mulut (Sp.PM)', 1),
(51, 4, 'Dokter Gigi Spesialis Periodonsia (Sp.Perio)', 1),
(52, 4, 'Dokter Gigi Spesialis Radiologi kedokteran gigi (Sp.RKG)', 1),
(53, 4, 'Dokter Gigi Spesialis lainnya yang belum tercantum', 1),
(56, 3, 'Dokter Spesialis Obsgyn Onkologi Ginekologi', 1),
(57, 1, 'Dokter Umum dan Dokter Spesialis', 1),
(58, 3, 'Dokter Spesialis Anak Subspesialis Hematologi Onkologi', 1),
(59, 3, 'Dokter Spesialis Dermatologi, Venereologi, dan Estetika (DVE)', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sdmk_jenis`
--
ALTER TABLE `sdmk_jenis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sdmk_jenis`
--
ALTER TABLE `sdmk_jenis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
