-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 02, 2025 at 10:21 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_penerbangan`
--

CREATE TABLE `jadwal_penerbangan` (
  `id_jadwal` int NOT NULL,
  `id_rute` int NOT NULL,
  `waktu_berangkat` time NOT NULL,
  `waktu_tiba` time NOT NULL,
  `harga` int NOT NULL,
  `kapasitas_kursi` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_penerbangan`
--

INSERT INTO `jadwal_penerbangan` (`id_jadwal`, `id_rute`, `waktu_berangkat`, `waktu_tiba`, `harga`, `kapasitas_kursi`) VALUES
(1, 1, '13:00:00', '14:00:00', 1000000, 212),
(2, 2, '15:00:00', '16:00:00', 950000, 229),
(4, 8, '13:00:00', '13:30:00', 900000, 170),
(5, 7, '18:00:00', '19:00:00', 1200000, 186),
(6, 1, '11:00:00', '12:00:00', 50000000, 120),
(8, 11, '00:04:00', '02:44:00', 2000000, 199);

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE `kota` (
  `id_kota` int NOT NULL,
  `nama_kota` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`id_kota`, `nama_kota`) VALUES
(1, 'Jakarta'),
(2, 'Bali'),
(3, 'Surabaya'),
(4, 'Yogyakarta'),
(5, 'Bengkulu'),
(6, 'Lombok'),
(7, 'Aceh'),
(8, 'Banten'),
(10, 'Medan'),
(11, 'Padang'),
(12, 'Malang');

-- --------------------------------------------------------

--
-- Table structure for table `maskapai`
--

CREATE TABLE `maskapai` (
  `id_maskapai` int NOT NULL,
  `logo_maskapai` text COLLATE utf8mb4_general_ci,
  `nama_maskapai` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `kapasitas` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maskapai`
--

INSERT INTO `maskapai` (`id_maskapai`, `logo_maskapai`, `nama_maskapai`, `kapasitas`) VALUES
(1, 'Garuda-Indonesia-Logo.png', 'Garuda Indonesia', 25),
(2, 'AirAsia_New_Logo.svg.png', 'Air Asia', 250),
(3, 'lion.png', 'Lion Air', 150),
(6, 'Qatar_Airways_logo.svg.png', 'Qatar Airways', 200);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id_order_detail` int NOT NULL,
  `id_user` int NOT NULL,
  `id_penerbangan` int NOT NULL,
  `id_order` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_tiket` int NOT NULL,
  `total_harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id_order_detail`, `id_user`, `id_penerbangan`, `id_order`, `jumlah_tiket`, `total_harga`) VALUES
(18, 23, 4, '681491b53c050', 1, 900000),
(19, 23, 6, '681494af20f93', 1, 50000000),
(20, 23, 8, '6814995d44989', 49, 98000000),
(21, 23, 8, '68149bd36dd8d', 49, 98000000);

-- --------------------------------------------------------

--
-- Table structure for table `order_tiket`
--

CREATE TABLE `order_tiket` (
  `id_order` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `struk` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Proses','Approved','Reject') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_tiket`
--

INSERT INTO `order_tiket` (`id_order`, `tanggal_transaksi`, `struk`, `status`) VALUES
('68148fae57af4', '2025-05-02', 'e14fe9acd2601cc1ade7', 'Reject'),
('681490f3496b3', '2025-05-02', 'a2bda626681be440d776', 'Reject'),
('6814917864038', '2025-05-02', '7fb5c0fc88296562ad1c', 'Reject'),
('6814918b2e031', '2025-05-02', '03e7560c40808e720e32', 'Reject'),
('6814918d86e5b', '2025-05-02', '87c788b9c4865788c1b7', 'Reject'),
('681491a756516', '2025-05-02', '8437b81ef52af7e90865', 'Reject'),
('681491b53c050', '2025-05-02', '1468a054cc1cdb660d4c', 'Reject'),
('681494af20f93', '2025-05-02', '63ede9e156dddf941c6c', 'Reject'),
('6814995d44989', '2025-05-02', 'dcee2ded2b3c0c3d0b33', 'Reject'),
('68149bd36dd8d', '2025-05-02', 'da7b01cad3115f04e47d', 'Reject');

-- --------------------------------------------------------

--
-- Table structure for table `rute`
--

CREATE TABLE `rute` (
  `id_rute` int NOT NULL,
  `id_maskapai` int NOT NULL,
  `rute_asal` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `rute_tujuan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_pergi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rute`
--

INSERT INTO `rute` (`id_rute`, `id_maskapai`, `rute_asal`, `rute_tujuan`, `tanggal_pergi`) VALUES
(1, 1, 'Jakarta', 'Bali', '2024-02-24'),
(2, 2, 'Jakarta', 'Bali', '2024-02-25'),
(3, 3, 'Bali', 'Yogyakarta', '2024-02-24'),
(7, 3, 'Jakarta', 'Bali', '2024-02-24'),
(8, 2, 'Bali', 'Yogyakarta', '2024-02-24'),
(10, 2, 'Malang', 'Jakarta', '2025-03-24'),
(11, 6, 'Malang', 'Padang', '2025-03-24');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `roles` enum('Admin','Maskapai','Pelanggan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `nama_lengkap`, `password`, `roles`) VALUES
(1, 'rendiadmin', 'Rendi Admin', 'rendiadmin', 'Admin'),
(22, 'irving', 'irving', '123', 'Pelanggan'),
(23, 'user', 'user', '123', 'Pelanggan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal_penerbangan`
--
ALTER TABLE `jadwal_penerbangan`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_rute` (`id_rute`);

--
-- Indexes for table `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id_kota`);

--
-- Indexes for table `maskapai`
--
ALTER TABLE `maskapai`
  ADD PRIMARY KEY (`id_maskapai`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id_order_detail`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_penerbangan` (`id_penerbangan`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `order_tiket`
--
ALTER TABLE `order_tiket`
  ADD PRIMARY KEY (`id_order`);

--
-- Indexes for table `rute`
--
ALTER TABLE `rute`
  ADD PRIMARY KEY (`id_rute`),
  ADD KEY `id_maskapai` (`id_maskapai`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal_penerbangan`
--
ALTER TABLE `jadwal_penerbangan`
  MODIFY `id_jadwal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kota`
--
ALTER TABLE `kota`
  MODIFY `id_kota` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `maskapai`
--
ALTER TABLE `maskapai`
  MODIFY `id_maskapai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id_order_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `rute`
--
ALTER TABLE `rute`
  MODIFY `id_rute` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_penerbangan`
--
ALTER TABLE `jadwal_penerbangan`
  ADD CONSTRAINT `jadwal_penerbangan_ibfk_1` FOREIGN KEY (`id_rute`) REFERENCES `rute` (`id_rute`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`id_penerbangan`) REFERENCES `jadwal_penerbangan` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_3` FOREIGN KEY (`id_order`) REFERENCES `order_tiket` (`id_order`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rute`
--
ALTER TABLE `rute`
  ADD CONSTRAINT `rute_ibfk_1` FOREIGN KEY (`id_maskapai`) REFERENCES `maskapai` (`id_maskapai`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
