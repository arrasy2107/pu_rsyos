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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `nip` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_role` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `nip`, `username`, `password`, `remember_token`, `id_role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'dr. Ananto Pratikno SpOG. MARS', NULL, 'direktur', '$2y$10$AaxS17VLNyjHy6wOb/fPFOekvJpjO/1nAMLNgCZ3jLh0hjn.uo1N2', '', 1, 1, '2021-07-27 22:50:16', '2022-08-09 06:32:46'),
(7, 'Bagian Keperawatan 1', NULL, 'keperawatan1', '$2y$10$tnZVYGs6SRjenyjb6FcyXe69PMomkhgCUTO2hyU4HA.vQDEyEejyO', NULL, 3, 1, '2021-08-25 00:11:27', '2021-10-30 04:48:47'),
(8, 'Pengawas Umum 3', NULL, 'pengawas3', '$2y$10$hwXXCaL4ujSnnyG.XBCX3ONq3eWCj5i8NLKk5QAP9CoHO1uVQYTei', NULL, 2, 1, '2021-09-16 23:13:17', '2021-10-28 19:12:55'),
(17, 'admin', NULL, 'admin', '$2y$10$KAtlVCQSGCAq3/9Xo8Zn6O.rCA99UJYxpTWPD5escJwtefZ85nr3i', NULL, 3, 1, '2021-10-14 10:58:46', '2021-10-30 09:15:33'),
(18, 'dr. Mariani Sukirman', NULL, 'wadirpelayanan', '$2y$10$2wypWRQ2Zn8XzTozU4qUv.NvyWSXmhTPb9pwxE5BF37QZcZbdLS2O', NULL, 1, 1, '2021-10-14 12:23:45', '2021-10-14 06:20:44'),
(19, 'Thadeus Joko Utomo, SE., Ak.', '0', '0', '$2y$10$REySocGWpliv1VuLAeLLcupVOo9h6LRJ2S/7bYkbg6O9t17J3bxoS', NULL, 1, 0, '2021-10-14 12:24:14', '2026-07-17 03:03:23'),
(21, 'Ns. Devi A.C.SKeP', '0', '0', '$2y$10$8Uu81F23LiZQmaRbiA/cf.6/Uus3qmSgYY9ZEjLOk.qVgwdxwfhlK', NULL, 2, 0, '2021-10-17 13:36:17', '2022-04-26 00:14:53'),
(22, 'Ns. Imelda Manik SKeP', NULL, '0', '$2y$10$zYQFS2Lo4VHAp9O12R3T2ugcMkQx305k.sTPMJFHjYknsXifpZgsu', NULL, 2, 0, '2021-10-17 13:36:17', '2022-01-29 00:36:04'),
(23, 'Agustina Soge AMdK', '0', '0', '$2y$10$P0R3feang6yMENUPJ4VXSeSjk1tVrav18lxOwbiGVz7sj8pIOHhzG', NULL, 2, 0, '2021-10-17 13:36:17', '2022-04-26 00:15:02'),
(24, 'Herlina Sidabariba', '0', '0', '$2y$10$zgov2ZKZXPORpdBIRaN1aeX1GiNTb78nwkqIP333sOsdQrFCxbU6y', NULL, 2, 0, '2021-10-17 13:36:17', '2022-04-26 00:15:23'),
(25, 'Ns. Suparni Sijabat Skep', '0', '0', '$2y$10$9UoJPyJsmUGnQZ1kOJTWG.R6MAmJyoPvlH9w52IQQ14JgxpKsMVQW', NULL, 2, 0, '2021-10-17 13:36:17', '2022-04-26 00:15:10'),
(26, 'Rostina Sihite', '392', 'pengawas0392', '$2y$10$28rSb.kkn5e8w8DxOoEQ1ufe0U40w0FRu7FJsH6wB1HnXOSxy/PHy', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:37:01'),
(27, 'Dewi Goretti', '513', 'pengawas0513', '$2y$10$1SY9FfdvEPzE9KfcrKvQDuWpu6fDB3e2Z3hJXIuAvA8tnQ5p9OO3q', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:37:29'),
(28, 'Martha Rosude', '630', 'pengawas0630', '$2y$10$fvnFqNwnQoc43YCHbK.tD.PNm9slTro9SIRsK6crE0lF9DvgWteWG', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:37:54'),
(29, 'Agnes Monalisa', '0', '0', '$2y$10$zYQFS2Lo4VHAp9O12R3T2ugcMkQx305k.sTPMJFHjYknsXifpZgsu', NULL, 2, 0, '2021-10-17 13:36:17', '2022-04-26 00:15:49'),
(30, 'Magdalena Pane', '459', 'pengawas0459', '$2y$10$KUDxg63/S8R69k8.7Dv5PuS1gMuHgE4X/xc97GKUFuKICoJZn9/WC', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:38:25'),
(31, 'Ns. Nidya Ayu Nicke SKeP', '0', '0', '$2y$10$Yl0CWh3IQPs7yGlMx0v/5OBydua68DB4IgX1AHH07bIe5MXhDVcnq', NULL, 2, 0, '2021-10-17 13:36:17', '2022-04-26 00:15:56'),
(32, 'Gusrida', '490', 'pengawas0490', '$2y$10$6mBsBpLzaRmFzdylHMRuoutqrUxwlEdDj.zpKlxKQuWEbZxXeLw0S', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:38:55'),
(33, 'Netty Sumarni L', '511', 'pengawas0511', '$2y$10$1Oj1zgll/cos42xppmX1euXPztC8OPJeysDDHLgAwYt1nZm6xxTGe', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:39:06'),
(34, 'Asmaul Husni Trisni', '1151', 'pengawas1151', '$2y$10$DPfjoXbYSIncsvFE3W0sIeoEbkFXkOG6OrCFBu/a1WSNX/W3Tno8e', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:39:18'),
(35, 'Sediana Shinta Marbun', '380', 'pengawas0380', '$2y$10$Imf.d7UMymt0H6W0PntuiOA9opGuE52MJs3sWBO9hc3M7szNXQUXy', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:39:29'),
(36, 'Rusmiati Turnip', '643', 'pengawas0643', '$2y$10$wEvIGiFBk7V8i1R322GCVe1zNOUo4DA4VUDVZTvHE9MrKAs.WI/oS', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:39:47'),
(37, 'Eka Nofrita', '700', 'pengawas0700', '$2y$10$XgnbN//AeG0WXj8EApPzfuI/ApjtDStQnHJsmC/zQIAiKVZjPcZw2', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:40:01'),
(38, 'Erlina Silalahi', '489', 'pengawas0489', '$2y$10$AgDj1Uf2fZ5/n2AT/XZEFuDt3wAtSZ0SMqc94uG.GpMjweV8UjCL2', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:40:14'),
(39, 'Juliana Dame', '788', 'pengawas0788', '$2y$10$xXw3RoR91niCp59bQweNqeIJKWyB2Fsqair5IAttycfFJLvOX2tQ6', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:40:26'),
(40, 'Mawarni', '0', '0', '$2y$10$Xemi2bqsKesberMN//AhreZ35mH.ZkP6fO4U.IplDq87vAj96J.xu', NULL, 2, 0, '2021-10-17 13:36:17', '2026-07-17 03:05:58'),
(41, 'Nani Sri Mulya', '794', 'pengawas0794', '$2y$10$muWGmpUvaJJ0GK1uRYQMiePDTpz/lLkehbO.x3iBSuLW5adP..8o6', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:40:51'),
(42, 'Benedikta Eni K', '553', 'pengawas0553', '$2y$10$fgRgKakBW8ATIuHn9iRs6.buF48GinR9Ox55CW4P5gO.TXxejeXvW', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:41:16'),
(43, 'Betaria Sonat', '0', '0', '$2y$10$qZVQTGtMygusEHxjlgZIouYXhFmaUX8vbtY9lKxIIeOLAtXGJQiEW', NULL, 2, 0, '2021-10-17 13:36:17', '2026-07-17 03:03:48'),
(44, 'Nerli Tekla', '565', 'pengawas0565', '$2y$10$ytieQuka2xDFaEWQslrYMu74eCS69uFoVMd.WoKmkvUoi2xJ0kZvu', NULL, 2, 1, '2021-10-17 13:36:17', '2022-05-06 07:32:22'),
(45, 'Yuliawati', '578', 'pengawas0578', '$2y$10$cMyrzDHVh.CyJrFHDKfmWe3rC/e4pqJ8.EBHXQQLQGap1scf2kfOe', NULL, 2, 1, '2021-10-17 13:36:17', '2023-01-26 03:48:35'),
(46, 'Betty Elisabeth M', '474', 'pengawas0474', '$2y$10$Q.Oneziw7r0T5zeui.OHA.DBMr/vIMzfVv.zBCAOxE8xXB/OMANDG', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:41:51'),
(47, 'Ns. Denny R Silaen SKeP', '0', '0', '$2y$10$2TaERFHz/M66E34k9TVsxOUpbTI0IWWBGFlN7TMocPJORUfGz.rvm', NULL, 2, 0, '2021-10-17 13:36:17', '2022-04-26 00:16:22'),
(48, 'Andri Rotua', '628', 'pengawas0628', '$2y$10$Yej3LXZhiG8VM0nQQE5bBO60rga1.2dfh/tdEgtzRDjHzurrWvKfe', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:42:14'),
(49, 'Sri Nova Eka Putri', '697', 'pengawas0697', '$2y$10$jJV41.aQG0PXxCHncu/I.eEaQ3Vr2H0i4Uy.4oFgjX0Y9NxQnqu7m', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:42:27'),
(50, 'Adri Yosep', '571', 'pengawas0571', '$2y$10$ZZrNBiYcdTXldsPyHtWcMeA7CJv3o3dRCzHRzJ/Bfz.BwUpt0Giti', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:42:40'),
(51, 'Tiara Manurung', '442', 'pengawas0442', '$2y$10$6j12Uu80ccBFjDuJF1UuhedL5vNs0y8AnCKYec1O1U021vzrEEq0q', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:42:51'),
(52, 'Blasius Pati Libunaen', '586', 'pengawas0586', '$2y$10$tcNRRsBWDK4c90/yuo/lB.INK.s.LopkD0MBkgNSsP6G/w7x9yQ8i', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:43:03'),
(53, 'Evalin Erwin', '533', 'pengawas0533', '$2y$10$cmBFxfTul6VncwyMzPaNNehmdDJ6wcDYAzx8j3TtmAIqDhCKP3pJC', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:43:14'),
(54, 'Ns. Maria Sijabat SKeP', '534', 'pengawas0534', '$2y$10$Z6fhjTqDfShxg7lCDcy/wuwZj7BF0fx9xVzfFXQ7o9H8GNbGuIF0m', NULL, 2, 1, '2021-10-17 13:36:17', '2022-04-08 03:34:13'),
(55, 'Yulianawati', '366', 'pengawas0366', '$2y$10$8/PKexArFdYjo7h6D9lafe4wzSkFX4PGOWb89KOcnX3nsUgdJWn/S', NULL, 2, 1, '2021-10-17 13:36:17', '2022-03-28 07:43:37'),
(56, 'Irvan Sianturi', '0', '0', '$2y$10$BDbm.dLM64e7O26Ij9A0Tu4AA6BunEosfAr4VJbybvJECbAOfL4c2', NULL, 2, 0, '2021-10-17 13:36:17', '2026-07-17 03:05:20'),
(57, 'agnesh monalisa sagala', '597', 'pengawas0597', '$2y$10$YhnG96N/jwrGWVyNaFe4rO0pCsOzMDJmfAdNfPMc4cF28nxMBkeu2', NULL, 2, 1, '2021-10-18 12:30:33', '2022-03-28 07:44:02'),
(58, 'EDP', NULL, 'edp', '$2y$10$vboaiOBbcldmvAShPJW3C.m5AUV3xd3LPs9Dge96iLZw3Ef4wnl5G', NULL, 2, 1, '2021-10-30 09:49:01', '2023-07-12 07:44:17'),
(59, 'Harmonika Malau', '515', 'Pengawas0515', '$2y$10$wKyfDFmBDMAiJMjxbqlYxOpWAQTt40O8MBkGf/hJ15eDFV6fP.yLG', NULL, 2, 1, '2021-11-08 10:35:06', '2022-03-28 07:44:13'),
(60, 'Ns. Nora Yetti Sinaga', '1177', 'pengawas1177', '$2y$10$cUPGiDx/X9dxKdjL3q3npexv513TDJDLQay77qhmoOIh37SVwDkfS', NULL, 2, 1, '2022-01-25 08:07:54', '2022-03-28 07:44:26'),
(61, 'Sumiharyanti Natalia Rezeki Putri Sijabat', '1344', 'pengawas1344', '$2y$10$7BJxe71p4C.Yu6ScnPobKOBqoJEKlW993FOM58r9m7VslF1Htlj1O', NULL, 2, 1, '2022-01-26 08:31:43', '2022-03-28 07:44:37'),
(62, 'Zulvia Dewinta', '1077', 'pengawas1077', '$2y$10$VaOusINk1TaKnTBQ1Ui3VeMDaNytQOcMoKCGNnKuM5GDkEPwVh4TK', NULL, 2, 1, '2022-01-26 14:43:28', '2022-03-28 07:35:47'),
(63, 'Alvrina', NULL, 'ina', '$2y$10$YZz8iwVeG8hflxoDy.tlS.gVFl9S3QBmLP2X9RosElDnoIy8iW/Yi', NULL, 3, 1, '2022-03-02 07:56:44', '2022-03-02 07:56:44'),
(64, 'Admin EDP', NULL, 'adminedp', '$2y$10$n4A9OXSKWsZ.ZxrL9A6jzO99OYSmJSFL245Vkl64eISgJ42qeujiK', NULL, 3, 1, '2022-03-16 14:53:15', '2022-03-16 07:56:16'),
(65, 'Charly Novalia Putri', '1247', 'pengawas1247', '$2y$10$8mDpmxnHGUYvm/gmXxQXsuLfUU33lUyhJ7mB621AuxKFUTZIXJ2jy', NULL, 2, 1, '2022-03-28 07:57:57', '2022-03-28 01:04:29'),
(66, 'Yelvia Yufri Yanti', '0836', 'pengawas0836', '$2y$10$4vmWY.WcKPsYsi/eK.JKsePXWQ0qaABoReDS2g6J3nBImRopgygcK', NULL, 2, 1, '2022-03-28 07:59:12', '2022-03-28 01:00:51'),
(67, 'Meilan Rismawaty', '396', 'pengawas0396', '$2y$10$VfHWaiTttKC4IVQACboPb.O1FDE09IBMJ5Zno17PGDpetR4rmV74.', NULL, 2, 1, '2022-03-28 08:06:25', '2022-06-27 05:19:35'),
(68, 'Dian Rahmadani', '0', '0', '$2y$10$qL8zY8fJ60N1AqGYwoJqdudCWAMXmL/ClPAonupB505zU5WxUpdqi', NULL, 2, 0, '2022-03-28 08:07:19', '2023-01-17 08:00:42'),
(69, 'Mesrahwati Zai', '640', 'pengawas0640', '$2y$10$rE4svgyptCWgm/rlZj7eEeZ7EpSt4oMuVfuOriGFUe7VXpWc7xchy', NULL, 2, 1, '2022-03-28 08:08:41', '2022-03-28 01:17:05'),
(70, 'Novia', '1498', 'pengawas1498', '$2y$10$RV2RjFQVjwvswAWeFR8sPOgGJz11Vt8hyrvqUkeSCJSl5uYUUPdgK', NULL, 2, 1, '2022-03-28 08:09:15', '2022-03-28 01:19:02'),
(71, 'Ririn Septrina', '826', 'pengawas0826', '$2y$10$MiIoIY15pzb9W6f7uTVoXeYJXBSL5MogRHDoOunzFW6lDVIvSwga.', NULL, 2, 1, '2022-03-28 08:10:30', '2022-03-28 01:23:02'),
(72, 'Ester Maranata Nababan', '1057', 'pengawas1057', '$2y$10$5EbnOZKd5JC5Z4gxleutZulutMPmo7VDenhFgAC0GtIKhHohUIplS', NULL, 2, 1, '2022-03-28 08:11:22', '2022-03-28 01:17:59'),
(73, 'Herlina Sidabariba', '0', '0', '$2y$10$hdAr4Awlx5hn57q8O/YwJuUenm9DTiqWQKGLkck9b1NC9c1VQ2CRS', NULL, 2, 0, '2022-05-07 07:02:59', '2024-05-28 05:04:36'),
(74, 'malvin', '0', '0', '$2y$10$5fsDL4E2Ujw/fIkEb3mAqeVNrXsla1Mj6JFb.L8q6V/6yON0/3Dv2', NULL, 2, 0, '2022-05-30 12:53:09', '2023-02-28 01:04:10'),
(75, 'marliana sembiring', '0', '0', '$2y$10$kdoVMlPrUoa9tVOikju75eO2ef1BAZgrXGEX6eBohvboxzYKyFV0y', NULL, 2, 0, '2022-06-27 07:50:13', '2026-07-17 03:04:41'),
(76, 'ega rahmi jelvita', '1249', 'pengawas1249', '$2y$10$ixj8qhB0KIsfjsjVm./5Ieqk71XjcvCoint99Oack9dt0SltS8LcO', NULL, 2, 1, '2022-08-04 09:09:54', '2022-08-04 02:26:41'),
(77, 'olva jasela', '1229', 'pengawas1229', '$2y$10$4q8tI7mt8PSC4opTddY8ae7KcvoAvx5CyX6.HhD3VG8z2uVKq8ym6', NULL, 2, 1, '2022-08-04 09:19:13', '2022-08-04 02:28:30'),
(78, 'renita situmorang', '0514', 'pengawas0514', '$2y$10$7Ch3TjCxOPjksrfvqXgNa.dpC45FB6EjReWoFwA9Q5/a3MKmMcSeS', NULL, 2, 1, '2022-08-04 09:30:34', '2024-10-08 07:30:13'),
(79, 'debora adventia sabojiat', '1112', 'pengawas1112', '$2y$10$ktyjd/3IT.yyixqd7UXNU.eOuKXQlzzxcBmXSWwaMOSWLYONUhplO', NULL, 2, 1, '2022-08-04 09:31:52', '2022-08-04 02:35:01'),
(80, 'Dian Rahmadani', '1236', 'pengawas1236', '$2y$10$DyRv2vHuIH3IBKZwZi5itOtiKoU0phntwxYvNC7Ul599gUKNyOMSa', NULL, 2, 1, '2023-01-17 15:01:40', '2023-01-17 08:18:28'),
(82, 'kep', '9897', 'kep', '$2y$10$q9fQ3x7D6UAyHE7ZCPE7dOoA.SmjK7KXjlL3lWufGmIEgvn8nnhWa', NULL, 2, 1, '2023-11-28 08:34:52', '2023-11-28 01:38:51'),
(83, 'nova novianti', '1239', 'pengawas1239', '$2y$10$1ZGFdQMnOmZvPFU9/fJ./.H6hV9x0z/Rg19rnuiMKE1aAw4tfZpIy', NULL, 2, 1, '2023-12-04 11:59:25', '2023-12-04 05:14:48'),
(84, 'bernadeth selvia', '1408', 'pengawas1408', '$2y$10$3uQrPDwGeFDEUBc/xs77hO87c/DI774NeEH61yBuZd4hSgzPHee8O', NULL, 2, 1, '2023-12-04 11:59:50', '2023-12-04 05:13:22'),
(85, 'Anggryeny Sahanas', '1306', 'pengawas1306', '$2y$10$FH94KSlbllQtNEuEyTfh/OhqSXY7riIKrJWxpLsCf.aS4LX63..G.', NULL, 2, 1, '2023-12-04 12:00:17', '2023-12-04 05:12:22'),
(86, 'ervina', '1104', 'pengawas1104', '$2y$10$I6VO3pyXa.Tuc/6jzkrUne90TYzs5sBaKmSpF006btHhQPac4qYoG', NULL, 2, 1, '2023-12-04 12:00:47', '2023-12-04 05:19:34'),
(87, 'FABER VERAWATY SIAHAAN', '1211', 'pengawas1211', '$2y$10$FeNkiLVUAN4q6Wr0kk2ew.dMoyfVQLURzZVtOqkdwkz7EQ1c9N8c2', NULL, 2, 1, '2023-12-04 12:01:25', '2023-12-04 05:18:19'),
(88, 'Rusmawati sijabat', '1578', 'pengawas1578', '$2y$10$PJyqGaqNGk3dxMjF9gWK.eHbklqo1MiPV7g4J/tRcweqRF7j6CQz6', NULL, 2, 1, '2023-12-04 12:02:02', '2023-12-04 05:16:59'),
(89, 'Agnes Tiyas Sito Resmi', '1354', 'pengawas1354', '$2y$10$yb0C1R45iQo5oaq.B.Eb8uKg4f8BT4si1mdJRrSFzihI7390t2NjC', NULL, 2, 1, '2023-12-04 12:02:31', '2023-12-04 05:15:55'),
(90, 'rika silvia', '1436', 'pengawas1436', '$2y$10$4FA2QEN4Nw/IDQXGlwGZLOv.SOKmVBR3HhikzzbAvtCw1O6skoPai', NULL, 2, 1, '2023-12-04 12:03:40', '2023-12-04 05:07:09'),
(91, 'Yuni Sari Ramadhani', '1577', 'pengawas1577', '$2y$10$oU82lMeeh3.QwbbwJw.LYe1reZobffOwsy943o8N5Kj9mXQJhNeU6', NULL, 2, 1, '2023-12-04 12:04:20', '2023-12-04 05:08:27'),
(92, 'ros endang susilawati samosir', '934', 'pengawas934', '$2y$10$jVHdqe9YQWw5nXYw/Qt5R.FSSbFBUMrTHKlBJkS1GIAvg9TT8t4uq', NULL, 2, 1, '2023-12-04 12:05:06', '2023-12-04 05:11:14'),
(93, 'yohanes suban raya', '1432', 'pengawas1432', '$2y$10$ss9qBbkinnws7sWaT7tqmuDxz0DD1lT8Ogvf4YyZiDMhhih5LDRoO', NULL, 2, 1, '2023-12-04 12:05:37', '2023-12-04 05:09:36'),
(94, 'Irma Apriyenita Marpaung', '1312', 'pengawas1312', '$2y$10$5i2o0tElKwqVLUaGBFgVfecbybnK.diDhxXW2zPKD9kfoioH1ejRW', NULL, 2, 1, '2023-12-21 13:06:23', '2023-12-21 06:09:27'),
(95, 'Tri Wahyuni', '1591', 'pengawas1591', '$2y$10$bl88.LXuNr.5gmr404wmJebpnahPdJ6zI1lBB9dpYX5TLk6vvSVGO', NULL, 2, 1, '2024-01-11 07:38:11', '2024-01-11 00:39:27'),
(96, 'Sr. Clara', '1327', 'clara', '$2y$10$JZy5cSJcJTtelHrw3YDGUOQ8EbGT8QJBjvYFQSthGKdI68g1ANg.W', NULL, 3, 1, '2024-05-08 11:46:57', '2024-05-08 04:48:04'),
(97, 'Setiawati', '313', 'pengawas313', '$2y$10$IT38GhJUVO3EJvif4fEHNeRPmnvFIBkiumqUXr8HDBxIgDAQTLDq.', NULL, 2, 1, '2024-05-20 08:18:23', '2024-06-15 02:41:42'),
(98, 'Herlina Sidabariba', '0', '0', '$2y$10$qW8UsAV2ny6wCChVNhjJaev.UxYkqZgu.nKVflgR0v4jeqRD8ehJe', NULL, 2, 0, '2024-05-28 11:54:30', '2024-05-28 05:04:44'),
(99, 'Herlina Sidabariba', '540', 'pengawas540', '$2y$10$Z0yscI2IE0fH7QyI4jUZmu6tHxgInPo1CEGrslTGuDtHIgTwVLDm.', NULL, 2, 1, '2024-05-28 12:05:06', '2024-10-24 00:36:37'),
(100, 'Ns. Nidya Ayunicke, S.Kep', '1187', 'pengawas1187', '$2y$10$VfvnoPrsE.8LtFNoUh3K8OPhZKmWNcSoUYF9oXn8puZtDC0HpK4/S', NULL, 2, 1, '2024-05-29 16:25:07', '2024-05-30 02:50:01'),
(101, 'Pelitaria Hia', '1293', 'pengawas1293', '$2y$10$1XvTqmPnl..2zDf1xSToee1ikopXkPUTOv8gxj9dKc6DBeD.Y658O', NULL, 2, 1, '2024-09-26 09:42:17', '2024-10-12 03:00:58'),
(102, 'Muhammad Vikhi Ramadoni', '977', 'pengawas977', '$2y$10$l3UyhdusqZDDoeoSlmnUMerWa/NCUmGYYm33pfeiracHYi8vsO2lK', NULL, 2, 1, '2024-09-30 08:20:21', '2024-10-02 00:56:23'),
(103, 'Yoseph Samin Sanonce Anin', '1611', 'pengawas1611', '$2y$10$sUc0tx6JbO44mLa8PCCjxuv9OAOWhhbqwJGwsq1M7WGQaxSc9hI52', NULL, 2, 1, '2024-09-30 08:21:08', '2024-10-02 00:58:57'),
(104, 'Y. Paraswari', '1030', 'pengawas1030', '$2y$10$woFgxtmW14AfmrBv0.0iG.Hidod59gMMG7yT87cmJ5btyNhZPnljW', NULL, 2, 1, '2024-09-30 08:21:38', '2024-10-02 01:02:13'),
(105, 'Gusnita', '654', 'pengawas654', '$2y$10$KWOS9jsdCNkwKWV2PQ/7AOxex4DECc6bkdYr4xJgm7MPoJZ/hLOV2', NULL, 2, 1, '2025-02-01 13:02:34', '2025-02-05 07:23:06'),
(106, 'dr. MPP', '999', 'mpp', '$2y$10$zNs79csMViKNB7vR8bP/KedhsD9L8twrG69wP5kT.u2rMEWQ6zfGK', NULL, 3, 1, '2025-06-19 09:30:40', '2025-06-19 02:31:18'),
(107, 'Rohani Raja Guk Guk', '394', 'pengawas394', '$2y$10$ieLevXlqMDmeggH9bffGdumo/VzlQBDD91JABUdfLS7raEa3U6s8u', NULL, 2, 1, '2025-09-16 13:32:16', '2025-09-16 06:49:13'),
(108, 'Mariana Yulianti Diaz', '1364', 'pengawas1364', '$2y$10$YbYQ0dc.Xprf.XCzuZCdVuZWOM/rHBxOd3S13iPCxlpvPa6lOy/Fy', NULL, 2, 1, '2026-01-26 12:27:49', '2026-01-26 05:35:11'),
(109, 'Fiska Sriyunima Ningsih', '1700', 'pengawas1700', '$2y$10$JkAPuYaImnk0mzyMouF9ZuLTgeLxoCUqXIZGyBrzIZIJmY7urrhQe', NULL, 2, 1, '2026-01-26 12:28:53', '2026-01-26 05:36:15'),
(110, 'Margareta Erni Simanjuntak', '1619', 'pengawas1619', '$2y$10$rtIyB2/m1xsPOdEzI9eWeOh1dtVMOaRiA5mwlYo9KteiT3ktMvvky', NULL, 2, 1, '2026-01-26 12:30:00', '2026-01-26 05:33:47'),
(111, 'Vivi Gusmita', '1082', 'pengawas1082', '$2y$10$Em2l3U4qw/DPXT.f.Tk8kO3uVZIL2pNsbUG3WlfTs1rVWPrs0QRa6', NULL, 2, 1, '2026-01-26 12:37:47', '2026-01-26 05:45:11'),
(112, 'Elsa Wulan Sari', '1517', 'pengawas1517', '$2y$10$Di7H1Rg/WvuwwwH0Jbkd5.RnhKMMw7kt0HZjVnBy4IYmsPLD42xgW', NULL, 2, 1, '2026-01-26 12:38:28', '2026-01-26 06:29:26'),
(113, 'Sil Oktavia', '1277', 'pengawas1277', '$2y$10$eD6z3WfMkTdTXcE7LPfcF.d97iSuv1mc5dsD4qvhLpqY4soraGS.W', NULL, 2, 1, '2026-02-09 09:54:30', '2026-02-09 04:03:28'),
(114, 'dr. Mila Gunawan , MARS, FISQua', '0', 'milgun', '$2y$10$80Sn3SSgOVP/jWGU/UN4oeMTE8VU/6Akf2K0w8RzCbEPgIlzgaeZm', NULL, 1, 1, '2026-03-03 09:52:45', '2026-03-03 02:53:33'),
(115, 'Direktur', '01', 'Direktur1', '$2y$10$6gSX0kVdYBe26T6Rz4.PhOv6zZeK/0hoE9f9iJzBg2T4eKXE1DGcq', NULL, 1, 1, '2026-05-07 10:13:04', '2026-05-07 03:15:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
