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
-- Table structure for table `dokter_irj`
--

CREATE TABLE `dokter_irj` (
  `id` int NOT NULL,
  `id_sdmk_jenis` int NOT NULL,
  `nama` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokter_irj`
--

INSERT INTO `dokter_irj` (`id`, `id_sdmk_jenis`, `nama`, `jam_mulai`, `jam_selesai`, `status`) VALUES
(1, 5, 'dr.Mayetti,SpA (K)', NULL, NULL, 1),
(2, 5, 'dr.Finny Fitry Yani,SpA(K)', NULL, NULL, 1),
(3, 5, 'dr.Eka Agustia Rini,SpA(K)', NULL, NULL, 1),
(4, 5, 'dr. Yuni Handayani Gusmira,M.Ked(Ped),SpA', NULL, NULL, 1),
(5, 4, 'dr.Ananto Pratikno,SpOG,MARS', NULL, NULL, 1),
(6, 4, 'dr.Engga Lift Irwanto,SpOG(K)', NULL, NULL, 1),
(7, 4, 'dr.Ferry Iskandar Kharisma Sinaga,SpOG', NULL, NULL, 0),
(8, 4, 'dr.Herry Harianto AR,SpOG(K)', NULL, NULL, 0),
(9, 4, 'dr. Mashdarul Ma\'arif, Sp.OG', NULL, NULL, 1),
(10, 17, 'dr.Alexander Cahyadi,SpBS', NULL, NULL, 1),
(11, 22, 'dr. Edi Leonardo Simbolon,SpOT', NULL, NULL, 1),
(12, 22, 'dr.Hendra Maska,SpOT', NULL, NULL, 1),
(13, 19, 'dr.Alvarino,SpB.SpU', NULL, NULL, 1),
(14, 43, 'DR.dr.Daan Khambri,SpB(K)Onk,M.Kes', NULL, NULL, 1),
(15, 6, 'dr.Yahya Marpaung,SpB, FINACS', NULL, NULL, 1),
(16, 6, 'dr.I Piet Iskandar,MD MS, FINACS', NULL, NULL, 1),
(17, 6, 'dr.Musrineldy,SpB', NULL, NULL, 1),
(18, 34, 'dr.Benni Raymond ,SpBP-RE', NULL, NULL, 0),
(19, 3, 'DR.dr.Najirman,SpPD-KR', NULL, NULL, 1),
(20, 3, 'dr.H.A.M.Hanif,SpPD-KKV,MARS', NULL, NULL, 1),
(21, 3, 'dr.Fauzar,SpPD-KP', NULL, NULL, 1),
(22, 3, 'dr.Raveinal,SpPD-KAI,FINASIM', NULL, NULL, 1),
(23, 3, 'dr.Eifel Faheri,SpPD,KHOM', NULL, NULL, 0),
(24, 3, 'dr.Deasy Natalia,MM,SpPD', NULL, NULL, 1),
(25, 3, 'dr. Alex Chandra,SpPD', NULL, NULL, 1),
(26, 36, 'dr.Ellya Thaher,SpM', NULL, NULL, 1),
(27, 36, 'dr.Kemala Sayuti,SpM (K)', NULL, NULL, 1),
(28, 36, 'dr.Harmen,SpM', NULL, NULL, 1),
(29, 36, 'dr.Julita,SpM', NULL, NULL, 0),
(30, 33, 'dr.Krisna Lukman,SpTHT', NULL, NULL, 0),
(31, 33, 'dr.Novialdi,SpTHT-KL', NULL, NULL, 1),
(32, 33, 'dr.Al Hafiz,SpTHT-KL(K), FICS', NULL, NULL, 1),
(33, 20, 'dr.Isramaiharti,SpKK(K)', NULL, NULL, 0),
(34, 20, 'dr.Rina Gustia,SpKK', NULL, NULL, 1),
(35, 8, 'dr.Eddy Widodo,SpAn', NULL, NULL, 1),
(36, 8, 'dr.Emilzon Taslim,SpAn,KAO,M.Kes', NULL, NULL, 1),
(37, 8, 'dr.Rinal Effendi,SpAn', NULL, NULL, 1),
(38, 21, 'dr.Syarif Indra,SpS', NULL, NULL, 1),
(39, 21, 'dr.Novi Arius,SpS,M.Biomed', NULL, NULL, 1),
(40, 21, 'dr.Restu Susanti,SpS,M.Biomed', NULL, NULL, 1),
(41, 21, 'dr.Risky Ilona Saputra, Sp. N', NULL, NULL, 1),
(42, 29, 'dr.Kurniawan Sejahtera,SpKJ', NULL, NULL, 1),
(43, 29, 'dr.Dian Budianti Amalina,M.Ked.(K.J),SpKJ', NULL, NULL, 1),
(44, 23, 'dr.Oea Khairsyaf,SpP(K)', NULL, NULL, 1),
(45, 23, 'dr.Irvan Medison,SpP', NULL, NULL, 1),
(46, 7, 'dr.Ratih Mayasari Injomanoto,SpRad', NULL, NULL, 1),
(47, 37, 'dr.Yose Ramda Ilhami,SpJP', NULL, NULL, 1),
(48, 37, 'dr.Ivan Mahendra Raditya,SpJP', NULL, NULL, 1),
(49, 24, 'DR.dr.Rika Susanti,SpF(K)', NULL, NULL, 1),
(50, 31, 'dr. Rendra Sanjaya Yofa Zebua, Sp. KFR', NULL, NULL, 1),
(51, 46, 'drg.Haryadi Mangkuto,SpBM', NULL, NULL, 1),
(52, 1, 'dr.Susanti Effendi', NULL, NULL, 1),
(53, 1, 'dr.V.Mariani', NULL, NULL, 1),
(54, 1, 'dr.Yashinta Arif', NULL, NULL, 1),
(55, 1, 'dr.Astrid Cundikiawan', NULL, NULL, 1),
(56, 1, 'dr.Andhita Satya Pratama Giovanni', NULL, NULL, 1),
(57, 1, 'dr.Anisa Persia', NULL, NULL, 1),
(58, 1, 'dr.Elsa Giatri', NULL, NULL, 1),
(59, 1, 'dr.Tiffany Adelina', NULL, NULL, 1),
(60, 1, 'dr. Suci Maulidia', NULL, NULL, 1),
(61, 1, 'dr. Meilani', NULL, NULL, 1),
(62, 1, 'dr. Airena Niza Nugroho', NULL, NULL, 1),
(63, 1, 'dr. Elfon Lindo Pratama', NULL, NULL, 1),
(64, 1, 'dr. Lany Arza', NULL, NULL, 1),
(65, 1, 'dr. Fajar Satria Pratama', NULL, NULL, 1),
(66, 1, 'dr.Syahmedi Hikmatuhani', NULL, NULL, 0),
(67, 1, 'dr.Reza Oktarama Putra', NULL, NULL, 1),
(68, 1, 'dr. Briantono Indroprasto Widodo', NULL, NULL, 1),
(69, 2, 'Drg.Zulfaeda', NULL, NULL, 0),
(70, 2, 'Drg.Sandra Meitreyana Kuswinar', NULL, NULL, 1),
(71, 2, 'Drg.Beta Cyndiana', NULL, NULL, 0),
(72, 2, 'Drg. Felix Calvin Emanuel Waruwu', NULL, NULL, 1),
(73, 20, 'Dr. Sri Lestari, SpKK', NULL, NULL, 0),
(74, 6, 'dr. Juni Mitra, SpB(K)BD', NULL, NULL, 1),
(75, 37, 'dr. Putri Handayani, SpJP', NULL, NULL, 1),
(76, 33, 'dr. Novialdi, Sp THT', NULL, NULL, 1),
(77, 5, 'dr.Ivanny Khosasih,SpA,CIMI', '08:00:00', '13:00:00', 1),
(78, 1, 'dr. Melati Wijaya', '00:00:00', '00:00:00', 1),
(79, 38, 'dr.Muhammad Ade RefdianMenkher, SpoT', '02:00:00', '21:00:00', 0),
(80, 23, 'dr. Hafis Herdiman,SpP', '09:30:00', '20:59:00', 1),
(81, 34, 'dr. Benni Raymond,SpBP-RE', '10:00:00', '22:00:00', 1),
(82, 37, 'dr. Aris Albirru Amsal,M.Ked,SpJP', '06:08:00', '21:40:00', 1),
(83, 53, 'drg.Shelvy Soetanto,SpKG', '07:30:00', '18:29:00', 1),
(84, 5, 'dr. Rinang Mariko, SpA.(K)', '08:00:00', '22:00:00', 1),
(85, 43, 'dr. Ari Oktavenra,SpB(K), Onk', '16:15:00', '20:00:00', 1),
(86, 4, 'dr. Dharma Yosua Sardol Simarmata,Sp.OG.', '14:00:00', '16:00:00', 1),
(87, 56, 'dr. Dolly Nurdin Lubis,M.Kes.,Sp.OG,Subsp.Onk.', '13:00:00', '18:30:00', 1),
(88, 2, 'drg. Shelvy Soetanto, SpKG', '08:30:00', '11:30:00', 1),
(89, 23, 'dr. Kornelis Aribowo, Sp.P', '08:00:00', '14:00:00', 1),
(90, 8, 'dr. Syahpikal Sahana,Sp.An.', '07:00:00', '07:00:00', 1),
(91, 33, 'dr. Irwan Triansyah,Sp.THT-KL', '08:37:00', '17:37:00', 1),
(92, 57, 'RSYS DP', '07:00:00', '13:59:00', 1),
(93, 57, 'RSYS DS', '14:00:00', '21:00:00', 1),
(94, 4, 'dr. Ranni Fistri Khaisari, Sp.OG', '16:00:00', '18:00:00', 1),
(95, 20, 'dr.Miranda Ashar,Sp.DV', '08:00:00', '21:00:00', 1),
(96, 8, 'dr. Rendy Pranda Joni, SpAn', '07:00:00', '06:00:00', 1),
(97, 1, 'dr. Muhammad Akhyar Marpaung', '01:00:00', '12:00:00', 1),
(98, 1, 'dr. Rizqy Aulia Lubis', '00:00:00', '12:00:00', 1),
(99, 1, 'dr. Carolus Marudut Taripardo', '00:00:00', '14:00:00', 1),
(100, 1, 'dr. Felisia Varian Wibowo', '00:00:00', '00:00:00', 1),
(101, 29, 'dr. Ariadi, Sp.KJ', '09:00:00', '18:00:00', 1),
(102, 2, 'drg. Richard Oktario', '09:30:00', '12:30:00', 1),
(103, 3, 'dr. M. Agung Pratama Yudha, Sp. PD', '08:00:00', '14:30:00', 1),
(104, 3, 'dr. Muthia Faurin, Sp.PD', '15:00:00', '19:00:00', 1),
(105, 1, 'dr. Edwido Leonori Saputra', '00:00:00', '00:00:00', 1),
(106, 1, 'dr. Fauzan Akbara Yazid', '00:00:00', '00:00:00', 1),
(107, 4, 'dr. Alfa Febrianda, Sp. OG', '00:00:00', '00:00:00', 1),
(108, 36, 'dr. Pattih Primasakti, Sp.M', '00:00:00', '00:00:00', 1),
(109, 58, 'dr. Ade Nofendra, Sp.A, Subsp.HO (K)', '00:00:00', '00:00:00', 1),
(110, 1, 'dr. Anandila Maulina', '00:00:00', '00:00:00', 1),
(111, 1, 'dr. Muhammad Zaki Raihan', '00:00:00', '00:00:00', 1),
(112, 1, 'dr. Elsya Mulyani', '00:00:00', '00:00:00', 1),
(113, 4, 'dr. Mila Permata Sari, SpOG', '13:00:00', '16:00:00', 1),
(114, 56, 'dr. Syamel Muhammad, Sp OG,Subsp. Onk', '07:00:00', '09:00:00', 1),
(115, 59, 'dr. Deasy Archika Alvares, Sp.DVE', '09:00:00', '11:00:00', 1),
(116, 37, 'dr. Harry Andromeda, M.Ked (Cardio), Sp. JP FIHA', '16:00:00', '18:00:00', 1),
(117, 36, 'dr. Harlin Farhani, Sp.M', '08:00:00', '18:00:00', 1),
(118, 26, 'dr. Sofyan Ali Basit, Sp.BA', '16:00:00', '18:00:00', 1),
(119, 1, 'dr. Priyanka Prima Putri', '00:00:00', '00:00:00', 1),
(120, 51, 'drg. Netta Anggraini, MDSc.,Sp.Perio', '14:00:00', '17:00:00', 1),
(121, 1, 'dr. Luthviyah Domahata Permana', '00:00:00', '00:00:00', 1),
(122, 48, 'drg. Wanda Septya Ekatra, Sp.KG', '17:00:00', '21:00:00', 1),
(123, 47, 'drg. Asep Darya Darma Putra, Sp. KGA', '17:00:00', '21:00:00', 1),
(124, 46, 'drg. Megy Rahmadian, Sp.B.M.M', '10:00:00', '17:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dokter_irj`
--
ALTER TABLE `dokter_irj`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dokter_irj`
--
ALTER TABLE `dokter_irj`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
