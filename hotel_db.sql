-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 03, 2026 at 03:13 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int UNSIGNED NOT NULL,
  `room_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `guest_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `guest_phone` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `total_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('booked','checked_in','checked_out','cancelled') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'booked',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `room_id`, `user_id`, `guest_name`, `guest_phone`, `check_in`, `check_out`, `total_price`, `status`, `created_at`) VALUES
(2, 1, 1, 'Kayis Bintang Saputra', '081329382932', '2026-07-03', '2026-07-09', 720.00, 'booked', '2026-07-03 10:04:02'),
(3, 2, 1, 'Ripki', '081312356432', '2026-07-03', '2026-07-30', 8100000.00, 'booked', '2026-07-03 10:05:35');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int UNSIGNED NOT NULL,
  `room_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `room_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `type_id` int UNSIGNED NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `capacity` tinyint UNSIGNED NOT NULL DEFAULT '2',
  `status` enum('available','occupied','maintenance') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'available',
  `image_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_code`, `room_name`, `type_id`, `price`, `capacity`, `status`, `image_path`, `created_at`) VALUES
(1, 'K01', 'Kamar Anggrek', 2, 1200000.00, 3, 'available', '4d9453189499778dab780298889aed86.jpg', '2026-07-03 09:47:27'),
(2, 'K02', 'Kamar Dahlia', 1, 300000.00, 2, 'available', '372b0df7ebdf9553688f56b12316b212.jpg', '2026-07-03 09:55:41'),
(3, 'K03', 'Kamar Mawar', 3, 120000.00, 2, 'maintenance', '460a43c67b98d4685c0ebeda1133fc66.jpg', '2026-07-03 09:57:04');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` int UNSIGNED NOT NULL,
  `type_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `type_name`, `description`, `created_at`) VALUES
(1, 'Standard', 'Kamar standar untuk 1-2 tamu.', '2026-07-03 09:28:59'),
(2, 'Deluxe', 'Kamar deluxe dengan fasilitas lebih lengkap.', '2026-07-03 09:28:59'),
(3, 'Suite', 'Kamar suite dengan ruang tamu terpisah.', '2026-07-03 09:28:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','petugas') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'petugas',
  `full_name` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `failed_login` int UNSIGNED NOT NULL DEFAULT '0',
  `last_attempt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `full_name`, `created_at`, `failed_login`, `last_attempt`) VALUES
(1, 'admin', '$2y$10$mVrNMY02IwSPcZLNdM.whes0h.wKH/FfKSQ38jGrpHVu.rKqzyUYq', 'admin', 'Administrator', '2026-07-03 09:28:59', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_code` (`room_code`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_name` (`type_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `room_types` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
