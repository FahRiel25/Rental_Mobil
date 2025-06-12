-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2025 at 06:31 PM
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
-- Database: `mobil`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mobil_id` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `durasi` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `status` enum('diproses','disetujui','ditolak','selesai') NOT NULL DEFAULT 'diproses',
  `tanggal_booking` timestamp NOT NULL DEFAULT current_timestamp(),
  `catatan` text DEFAULT NULL,
  `metode_pembayaran` enum('transfer_bank','cod','ewallet') DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `foto_ktp` varchar(255) DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `user_id`, `mobil_id`, `tanggal_mulai`, `tanggal_selesai`, `durasi`, `harga`, `total`, `status`, `tanggal_booking`, `catatan`, `metode_pembayaran`, `nama`, `telepon`, `alamat`, `foto_ktp`, `bukti_pembayaran`) VALUES
(1, 1, 2, '2025-06-13', '2025-06-14', 1, 0, 300000, 'diproses', '2025-06-12 06:19:11', '', NULL, '', '', '', NULL, NULL),
(2, 1, 2, '2025-06-13', '2025-06-14', 1, 0, 300000, 'diproses', '2025-06-12 06:19:15', '', NULL, '', '', '', NULL, NULL),
(3, 1, 2, '2025-06-13', '2025-06-14', 1, 0, 300000, 'diproses', '2025-06-12 06:25:46', '', NULL, '', '', '', NULL, NULL),
(4, 1, 2, '2025-06-13', '2025-06-14', 1, 0, 300000, 'selesai', '2025-06-12 06:27:40', '', NULL, '', '', '', NULL, NULL),
(5, 1, 2, '2025-06-13', '2025-06-14', 1, 0, 300000, 'ditolak', '2025-06-12 06:31:16', '', NULL, '', '', '', NULL, NULL),
(6, 1, 1, '2025-06-13', '2025-06-21', 8, 0, 2800000, 'selesai', '2025-06-12 06:40:59', '', NULL, '', '', '', NULL, NULL),
(7, 1, 1, '2025-06-14', '2025-06-19', 5, 0, 1750000, 'selesai', '2025-06-12 07:14:25', '', NULL, '', '', '', NULL, NULL),
(8, 1, 1, '2025-06-13', '2025-06-15', 3, 0, 1050000, 'selesai', '2025-06-12 13:07:47', '', 'transfer_bank', 'Muhsyam fahriel Septiansyah', '085736564592', 'Dsn. Nglencong RT04/RW03, Desa kauman, Kec. Sine, Kab. Ngawi', 'ktp_684ad123d093c.jpg', 'bukti_684ad123d0698.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id` int(11) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `tahun` int(4) NOT NULL,
  `warna` varchar(30) NOT NULL,
  `kursi` int(2) NOT NULL,
  `harga` int(11) NOT NULL,
  `status` enum('tersedia','tidak tersedia') NOT NULL DEFAULT 'tersedia',
  `gambar` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id`, `merk`, `model`, `tahun`, `warna`, `kursi`, `harga`, `status`, `gambar`, `deskripsi`, `created_at`) VALUES
(1, 'Toyota', 'Avanza', 2022, 'Putih', 7, 350000, 'tidak tersedia', 'avanza.jpg', 'Mobil keluarga dengan 7 kursi, irit bahan bakar', '2025-06-12 02:17:30'),
(2, 'Daihatsu', 'Xenia', 2021, 'Merah', 5, 300000, 'tersedia', 'xenia.jpg', 'Mobil city car dengan desain compact', '2025-06-12 02:17:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `username`, `password`, `telepon`, `alamat`, `role`, `created_at`) VALUES
(1, 'Muhsyam fahriel Septiansyah', 'muhsyamfahriel25@gmail.com', 'demo', '$2y$10$yvQy8NoYo4pJbi.qc11lyO5rCehuTBs5LmZAoF30nBRP/kptvhUeu', '085736564592', 'Dsn. Nglencong RT04/RW03, Desa kauman, Kec. Sine, Kab. Ngawi', 'user', '2025-06-12 02:57:28'),
(2, 'Admin', 'admin@email.com', 'admin', '$2y$10$L9oPSY3Ty.HSvvdHEe7OeOHN5BCQzQwUCxwhvUQ6DFZcffG2dzq6i', '0800000000', 'Kantor', 'admin', '2025-06-12 07:24:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `mobil_id` (`mobil_id`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`mobil_id`) REFERENCES `mobil` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
