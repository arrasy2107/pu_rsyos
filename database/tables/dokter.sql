-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 07, 2026 at 06:46 AM
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
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int NOT NULL,
  `id_sdmk_jenis` int NOT NULL,
  `nama_dokter` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `id_sdmk_jenis`, `nama_dokter`, `status`) VALUES
(1, 5, 'dr.Mayetti,SpA (K)', 1),
(2, 5, 'dr.Finny Fitry Yani,SpA(K)', 1),
(3, 5, 'dr.Eka Agustia Rini,SpA(K)', 1),
(4, 5, 'dr. Yuni Handayani Gusmira,M.Ked(Ped),SpA', 1),
(5, 4, 'dr.Ananto Pratikno,SpOG,MARS', 1),
(6, 4, 'dr.Engga Lift Irwanto,SpOG(K)', 1),
(7, 4, 'dr.Ferry Iskandar Kharisma Sinaga,SpOG', 0),
(8, 4, 'dr.Herry Harianto AR,SpOG(K)', 0),
(9, 4, 'dr. Mashdarul Ma\'arif, Sp.OG', 1),
(10, 17, 'dr.Alexander Cahyadi,SpBS', 1),
(11, 22, 'dr. Edi Leonardo Simbolon,SpOT', 1),
(12, 22, 'dr.Hendra Maska,SpOT', 1),
(13, 19, 'dr.Alvarino,SpB.SpU', 1),
(14, 43, 'DR.dr.Daan Khambri,SpB(K)Onk,M.Kes', 1),
(15, 6, 'dr.Yahya Marpaung,SpB, FINACS', 1),
(16, 6, 'dr.I Piet Iskandar,MD MS, FINACS', 1),
(17, 6, 'dr.Musrineldy,SpB', 1),
(18, 34, 'dr.Benni Raymond ,SpBP-RE', 1),
(19, 3, 'DR.dr.Najirman,SpPD-KR', 1),
(20, 3, 'dr.H.A.M.Hanif,SpPD-KKV,MARS', 1),
(21, 3, 'dr.Fauzar,SpPD-KP', 1),
(22, 3, 'dr.Raveinal,SpPD-KAI,FINASIM', 1),
(23, 3, 'dr.Eifel Faheri,SpPD,KHOM', 1),
(24, 3, 'dr.Deasy Natalia,MM,SpPD', 1),
(25, 3, 'dr. Alex Chandra,SpPD', 1),
(26, 36, 'dr.Ellya Thaher,SpM', 1),
(27, 36, 'dr.Kemala Sayuti,SpM (K)', 1),
(28, 36, 'dr.Harmen,SpM', 1),
(29, 36, 'dr.Julita,SpM', 0),
(30, 33, 'dr.Krisna Lukman,SpTHT', 0),
(31, 33, 'dr.Novialdi,SpTHT-KL', 1),
(32, 33, 'dr.Al Hafiz,SpTHT-KL(K), FICS', 1),
(33, 20, 'dr.Isramaiharti,SpKK(K)', 0),
(34, 20, 'dr.Rina Gustia,SpKK', 1),
(35, 8, 'dr.Eddy Widodo,SpAn', 1),
(36, 8, 'dr.Emilzon Taslim,SpAn,KAO,M.Kes', 1),
(37, 8, 'dr.Rinal Effendi,SpAn', 1),
(38, 21, 'dr.Syarif Indra,SpS', 1),
(39, 21, 'dr.Novi Arius,SpS,M.Biomed', 1),
(40, 21, 'dr.Restu Susanti,SpS,M.Biomed', 1),
(41, 21, 'dr.Risky Ilona Saputra, Sp. N', 1),
(42, 29, 'dr.Kurniawan Sejahtera,SpKJ', 1),
(43, 29, 'dr.Dian Budianti Amalina,M.Ked.(K.J),SpKJ', 1),
(44, 23, 'dr.Oea Khairsyaf,SpP(K)', 1),
(45, 23, 'dr.Irvan Medison,SpP', 1),
(46, 7, 'dr.Ratih Mayasari Injomanoto,SpRad', 1),
(47, 37, 'dr.Yose Ramda Ilhami,SpJP', 1),
(48, 37, 'dr.Ivan Mahendra Raditya,SpJP', 1),
(49, 24, 'DR.dr.Rika Susanti,SpF(K)', 1),
(50, 31, 'dr. Rendra Sanjaya Yofa Zebua, Sp. KFR', 1),
(51, 46, 'drg.Haryadi Mangkuto,SpBM', 1),
(52, 1, 'dr.Susanti Effendi', 1),
(53, 1, 'dr.V.Mariani', 1),
(54, 1, 'dr.Yashinta Arif', 1),
(55, 1, 'dr.Astrid Cundikiawan', 1),
(56, 1, 'dr.Andhita Satya Pratama Giovanni', 0),
(57, 1, 'dr.Anisa Persia', 1),
(58, 1, 'dr.Elsa Giatri', 0),
(59, 1, 'dr.Tiffany Adelina', 0),
(60, 1, 'dr. Suci Maulidia', 1),
(61, 1, 'dr. Meilani', 0),
(62, 1, 'dr. Airena Niza Nugroho', 0),
(63, 1, 'dr. Elfon Lindo Pratama', 1),
(64, 1, 'dr. Lany Arza', 0),
(65, 1, 'dr. Fajar Satria Pratama', 1),
(66, 1, 'dr.Syahmedi Hikmatuhani', 0),
(67, 1, 'dr.Reza Oktarama Putra', 1),
(68, 1, 'dr. Briantono Indroprasto Widodo', 0),
(69, 2, 'Drg.Zulfaeda', 0),
(70, 2, 'Drg.Sandra Meitreyana Kuswinar', 1),
(71, 2, 'Drg.Beta Cyndiana', 0),
(72, 2, 'Drg. Felix Calvin Emanuel Waruwu', 1),
(73, 1, 'dr. Sherly Primasari Agus', 1),
(74, 1, 'dr. Yolanda Wulandari Erwen', 1),
(75, 1, 'dr. Gabriel Audrey Wijaya', 1),
(76, 1, 'dr. Yolanda Wulandari', 0),
(77, 1, 'dr. Firlando Riyanda', 1),
(78, 1, 'dr. Hidayat Mahmud', 1),
(79, 5, 'dr.Ivanny Khosasih,SpA,CIMI', 1),
(80, 1, 'dr. Firlando Ryanda', 0),
(81, 1, 'dr. Melati Wijaya', 0),
(82, 1, 'dr. Ameliora Restky Sayeti', 1),
(83, 1, 'dr. Kartika Julia Maghend', 1),
(84, 1, 'dr. Attahiyyata Yusuf,M.Biomed', 1),
(85, 1, 'dr. Reno Hulandari', 1),
(86, 1, 'dr.Fersa SEpta Fandiska', 1),
(87, 1, 'dr. Yudha Risman', 1),
(88, 1, 'dr. Vovinda Rujiana', 1),
(89, 8, 'dr. Syahpikal Sahana,Sp.An.', 1),
(90, 1, 'dr. Restu Evanila Putri', 1),
(91, 1, 'dr. Indra Anas Sulaiman', 1),
(92, 1, 'dr. Muhammad Akhyar Marpaung', 1),
(93, 1, 'dr. Rizqy Aulia Lubis', 1),
(94, 1, 'dr. Carolus Marudut Taripardo', 1),
(95, 1, 'dr. Felisia Varian Wibowo', 1),
(96, 29, 'dr. Ariadi, Sp.KJ', 1),
(97, 2, 'drg. Richard Oktario', 1),
(98, 3, 'dr. M. Agung Pratama Yudha, Sp. PD', 1),
(99, 3, 'dr. Muthia Faurin, Sp.PD', 1),
(100, 1, 'dr. Edwido Leonori Saputra', 1),
(101, 1, 'dr. Fauzan Akbara Yazid', 1),
(102, 4, 'dr. Alfa Febrianda, Sp. OG', 1),
(103, 36, 'dr. Pattih Primasakti, Sp.M', 1),
(104, 58, 'dr. Ade Nofendra, Sp.A, Subsp.HO (K)', 0),
(105, 1, 'dr. Anandila Maulina', 1),
(106, 1, 'dr. Muhammad Zaki Raihan', 1),
(107, 1, 'dr. Elsya Mulyani', 1),
(108, 4, 'dr. Mila Permata Sari, SpOG', 1),
(109, 56, 'dr. Syamel Muhammad, Sp OG,Subsp. Onk', 1),
(110, 59, 'dr. Deasy Archika Alvares, Sp.DVE', 1),
(111, 37, 'dr. Harry Andromeda, M.Ked (Cardio), Sp. JP FIHA', 1),
(112, 36, 'dr. Harlin Farhani, Sp.M', 1),
(113, 26, 'dr. Sofyan Ali Basit, Sp.BA', 1),
(114, 1, 'dr. Priyanka Prima Putri', 1),
(115, 51, 'drg. Netta Anggraini, MDSc.,Sp.Perio', 1),
(116, 1, 'dr. Luthviyah Domahata Permana', 1),
(117, 48, 'drg. Wanda Septya Ekatra, Sp.KG', 1),
(118, 47, 'drg. Asep Darya Darma Putra, Sp. KGA', 1),
(119, 46, 'drg. Megy Rahmadian, Sp.B.M.M', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
