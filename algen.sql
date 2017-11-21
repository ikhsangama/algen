-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2017 at 09:49 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `algen`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(10) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `nama`, `password`) VALUES
('admin', 'Ulil Albab', '21232f297a57a5a743894a0e4a801fc3'),
('admin23', 'admin234', '78e0d5058803a3d6481b946b5e7a2510');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id_lokasi` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `lat` varchar(15) NOT NULL,
  `lng` varchar(15) NOT NULL,
  `foto` varchar(60) NOT NULL,
  `keterangan` text NOT NULL,
  `update_by` varchar(10) NOT NULL DEFAULT 'admin',
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `nama`, `lat`, `lng`, `foto`, `keterangan`, `update_by`, `waktu_update`) VALUES
('Bandung', 'Bandung', '-6.891406589620', '107.61065483093', '', '', 'admin', '2017-11-21 15:25:59'),
('Jakarta', 'Jakarta', '-6.362749954013', '106.82704210281', '', '', 'admin', '2017-11-21 15:37:09'),
('Semarang', 'Semarang', '-7.051106731382', '110.44087886810', '', '', 'admin', '2017-11-21 15:20:13'),
('Surabaya', 'Surabaya', '-7.282124743507', '112.79511809349', '', '', 'admin', '2017-11-21 15:46:43'),
('Yogyakarta', 'Yogyakarta', '-7.771376074830', '110.37749290466', '', '', 'admin', '2017-11-21 15:54:25');

-- --------------------------------------------------------

--
-- Table structure for table `rute`
--

CREATE TABLE `rute` (
  `id` int(11) NOT NULL,
  `asal` varchar(25) NOT NULL,
  `tujuan` varchar(25) NOT NULL,
  `jarak` int(11) NOT NULL,
  `rute` text,
  `update_by` varchar(10) NOT NULL DEFAULT 'admin',
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rute`
--

INSERT INTO `rute` (`id`, `asal`, `tujuan`, `jarak`, `rute`, `update_by`, `waktu_update`) VALUES
(161, 'Bandung', 'Semarang', 315561, '-6.891411915282799,107.61065348982811,-7.051175941391232,110.44088691473007', 'admin', '2017-11-21 15:30:52'),
(162, 'Semarang', 'Bandung', 315559, '-7.050989606729123,110.44088155031204,-6.891353332998017,107.61065885424614', 'admin', '2017-11-21 15:31:50'),
(163, 'Jakarta', 'Bandung', 105230, '-6.362632663768454,106.82704478502274,-6.8913493387510645,107.6106508076191', 'admin', '2017-11-21 15:38:38'),
(164, 'Jakarta', 'Semarang', 409519, '-6.362635329456152,106.8270394206047,-7.050877805895867,110.44086813926697', 'admin', '2017-11-21 15:39:41'),
(165, 'Bandung', 'Jakarta', 105226, '-6.891392276904051,107.61065483093262,-6.3627359591563,106.82704210281372', 'admin', '2017-11-21 15:40:45'),
(166, 'Semarang', 'Jakarta', 409522, '-7.051092756283487,110.44087886810303,-6.362735625945413,106.82704143226147', 'admin', '2017-11-21 15:41:41'),
(167, 'Surabaya', 'Bandung', 578766, '-7.282007678218099,112.7951180934906,-6.891379295602392,107.61065550148487', 'admin', '2017-11-21 15:47:21'),
(168, 'Surabaya', 'Jakarta', 672194, '-7.282103458911777,112.79508590698242,-6.362735292734511,106.8270417675376', 'admin', '2017-11-21 15:48:30'),
(169, 'Surabaya', 'Semarang', 263331, '-7.282110442919899,112.7951180934906,-7.051048169059575,110.44088020920753', 'admin', '2017-11-21 15:49:40'),
(170, 'Bandung', 'Surabaya', 578766, '-6.891392276904051,107.61065449565649,-7.282070201728789,112.79512077569962', 'admin', '2017-11-21 15:51:09'),
(171, 'Jakarta', 'Surabaya', 672198, '-6.3627199650330875,106.82704143226147,-7.282110110348087,112.79511876404285', 'admin', '2017-11-21 15:51:49'),
(172, 'Semarang', 'Surabaya', 263331, '-7.051092090802558,110.44087886810303,-7.282110442919899,112.7951180934906', 'admin', '2017-11-21 15:50:24'),
(173, 'Yogyakarta', 'Bandung', 323204, '-7.77134817029906,110.37749357521534,-6.89137729847903,107.61065550148487', 'admin', '2017-11-21 15:55:09'),
(174, 'Yogyakarta', 'Jakarta', 425203, '-7.771361790368105,110.37749323993921,-6.3627359591563,106.82704210281372', 'admin', '2017-11-21 15:55:54'),
(175, 'Yogyakarta', 'Semarang', 80490, '-7.771361458171306,110.37749256938696,-7.051092090802558,110.44087886810303', 'admin', '2017-11-21 15:56:37'),
(176, 'Yogyakarta', 'Surabaya', 274584, '-7.771361790368105,110.37749223411083,-7.282110110348087,112.79511775821447', 'admin', '2017-11-21 15:57:17'),
(177, 'Bandung', 'Yogyakarta', 323204, '-6.891391944050162,107.61065483093262,-7.771361790368105,110.37749290466309', 'admin', '2017-11-21 15:57:55'),
(178, 'Jakarta', 'Yogyakarta', 425204, '-6.3627206314549,106.82704210281372,-7.771361458171306,110.37749256938696', 'admin', '2017-11-21 15:58:58'),
(179, 'Semarang', 'Yogyakarta', 80490, '-7.771362122564905,110.3774918988347,-7.051092756283487,110.44087920337915', 'admin', '2017-11-21 15:59:37'),
(180, 'Surabaya', 'Yogyakarta', 274583, '-7.282110775491712,112.79511775821447,-7.771361458171306,110.37749357521534', 'admin', '2017-11-21 16:00:14');

-- --------------------------------------------------------

--
-- Table structure for table `variabel_algen`
--

CREATE TABLE `variabel_algen` (
  `id_variabel` int(11) NOT NULL,
  `prob_crossover` int(11) NOT NULL,
  `prob_mutasi` int(11) NOT NULL,
  `jml_krom_awal` int(11) NOT NULL,
  `jml_generasi` int(11) NOT NULL,
  `update_by` varchar(10) NOT NULL DEFAULT 'admin',
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `variabel_algen`
--

INSERT INTO `variabel_algen` (`id_variabel`, `prob_crossover`, `prob_mutasi`, `jml_krom_awal`, `jml_generasi`, `update_by`, `waktu_update`) VALUES
(1, 90, 90, 5, 5, 'admin', '2017-11-21 20:26:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `rute`
--
ALTER TABLE `rute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variabel_algen`
--
ALTER TABLE `variabel_algen`
  ADD PRIMARY KEY (`id_variabel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rute`
--
ALTER TABLE `rute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `variabel_algen`
--
ALTER TABLE `variabel_algen`
  MODIFY `id_variabel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
