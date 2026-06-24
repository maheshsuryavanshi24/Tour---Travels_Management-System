-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2026 at 07:22 AM
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
-- Database: `tour_travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'Admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `seats` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `booking_status` varchar(50) DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `package_id`, `seats`, `amount`, `payment_status`, `booking_status`, `booking_date`, `payment_method`) VALUES
(1, 1, 3, 'A1', 15000.00, 'Paid', 'Confirmed', '2026-05-14 04:18:06', NULL),
(2, 1, 4, 'A2, A3, B2, B3', 80000.00, 'Paid', 'Confirmed', '2026-05-14 04:23:58', NULL),
(3, 1, 4, 'A2, A3, B2, B3', 80000.00, 'Paid', 'Confirmed', '2026-05-14 04:24:23', NULL),
(4, 1, 4, 'A2, A3, B2, B3', 80000.00, 'Paid', 'Confirmed', '2026-05-14 04:30:33', NULL),
(5, 1, 4, 'A2, A3, B2, B3', 80000.00, 'Paid', 'Confirmed', '2026-05-14 04:30:47', NULL),
(6, 1, 4, 'A1', 20000.00, 'Paid', 'Confirmed', '2026-05-14 04:31:02', NULL),
(7, 1, 4, 'A1', 20000.00, 'Paid', 'Confirmed', '2026-05-14 04:31:19', NULL),
(8, 1, 4, 'A1', 20000.00, 'Paid', 'Confirmed', '2026-05-14 05:15:12', NULL),
(9, 1, 3, 'A1, A2', 30000.00, 'Paid', 'Confirmed', '2026-05-14 05:17:56', NULL),
(10, 1, 4, 'A1', 20000.00, 'Paid', 'Confirmed', '2026-05-14 12:02:06', NULL),
(11, 1, 4, 'A1', 20000.00, 'Paid', 'Confirmed', '2026-05-14 12:12:16', NULL),
(12, 1, 4, 'A1, A2', 40000.00, 'Paid', 'Confirmed', '2026-05-14 15:14:29', NULL),
(13, 1, 4, 'A1, A2', 40000.00, 'Paid', 'Confirmed', '2026-05-14 15:14:54', NULL),
(14, 1, 3, 'A1, A2, A3', 45000.00, 'Paid', 'Confirmed', '2026-05-14 18:04:24', NULL),
(15, 1, 3, 'A2', 15000.00, 'Paid', 'Confirmed', '2026-05-15 07:41:56', NULL),
(16, 1, 4, 'A1, B1, C1', 60000.00, 'Paid', 'Confirmed', '2026-05-15 11:29:16', NULL),
(17, 1, 4, 'A4, B4, C2, C3, C4, D1, D2, D3, D4', 180000.00, 'Paid', 'Confirmed', '2026-05-15 11:56:32', NULL),
(18, 1, 4, 'A4, B4, C2, C3, C4, D1, D2, D3, D4', 180000.00, 'Paid', 'Confirmed', '2026-05-15 11:56:42', NULL),
(19, 1, 3, 'A4', 15000.00, 'Paid', 'Confirmed', '2026-05-16 01:53:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `id` int(11) NOT NULL,
  `bus_name` varchar(100) DEFAULT NULL,
  `bus_number` varchar(50) DEFAULT NULL,
  `bus_type` varchar(50) DEFAULT NULL,
  `seat_type` varchar(50) DEFAULT NULL,
  `total_seats` int(11) DEFAULT NULL,
  `from_city` varchar(100) DEFAULT NULL,
  `to_city` varchar(100) DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `arrival_time` time DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` enum('Available','Unavailable') DEFAULT 'Available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `available_seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`id`, `bus_name`, `bus_number`, `bus_type`, `seat_type`, `total_seats`, `from_city`, `to_city`, `departure_time`, `arrival_time`, `price`, `status`, `created_at`, `available_seats`) VALUES
(1, 'mhrtc', 'ns2425', 'AC', 'Sleeper', 40, 'Miraj', 'Pune', '23:10:30', '27:06:30', 600.00, 'Available', '2026-05-14 09:43:09', 4);

-- --------------------------------------------------------

--
-- Table structure for table `bus_bookings`
--

CREATE TABLE `bus_bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bus_id` int(11) DEFAULT NULL,
  `journey_date` date DEFAULT NULL,
  `seats` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('Pending','Paid') DEFAULT 'Pending',
  `booking_status` enum('Booked','Cancelled') DEFAULT 'Booked',
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_bookings`
--

INSERT INTO `bus_bookings` (`id`, `user_id`, `bus_id`, `journey_date`, `seats`, `total_amount`, `payment_status`, `booking_status`, `booking_date`) VALUES
(1, NULL, 1, '2026-05-31', '1', 600.00, 'Pending', 'Booked', '2026-05-14 09:46:34'),
(2, NULL, 1, '2026-05-31', '1', 600.00, 'Pending', 'Booked', '2026-05-14 09:50:14'),
(3, NULL, 1, '2026-05-16', '6,7', 1200.00, 'Pending', 'Booked', '2026-05-14 11:46:38'),
(4, NULL, 1, '2026-05-16', '6,7', 1200.00, 'Pending', 'Booked', '2026-05-14 11:51:48'),
(5, NULL, 1, '2026-05-16', '6,7', 1200.00, 'Pending', 'Booked', '2026-05-14 11:51:57'),
(6, NULL, 1, '2026-05-16', '6,7', 1200.00, 'Paid', 'Booked', '2026-05-14 11:52:20'),
(7, NULL, 1, '2026-05-13', '1', 600.00, 'Paid', 'Booked', '2026-05-14 12:22:13'),
(8, 1, 1, '2026-05-01', '1', 600.00, 'Paid', 'Cancelled', '2026-05-14 12:42:48'),
(9, 1, 1, '2026-05-24', '2,3', 1200.00, 'Paid', 'Cancelled', '2026-05-14 15:15:40'),
(10, 1, 1, '2026-05-08', '2', 600.00, 'Paid', 'Cancelled', '2026-05-14 17:22:27'),
(11, 1, 1, '2026-05-15', '11', 600.00, 'Paid', 'Cancelled', '2026-05-14 17:46:37'),
(12, 1, 1, '2026-04-27', '1', 600.00, 'Paid', 'Cancelled', '2026-05-14 18:02:57'),
(13, 1, 1, '2026-05-30', '3,7', 1200.00, 'Paid', 'Cancelled', '2026-05-15 07:38:09'),
(14, 1, 1, '2026-05-15', '15', 600.00, 'Paid', 'Cancelled', '2026-05-15 07:43:04'),
(15, 1, 1, '2026-05-22', '2', 600.00, 'Paid', 'Cancelled', '2026-05-15 11:35:42'),
(16, 1, 1, '2026-05-29', '2', 600.00, 'Paid', 'Cancelled', '2026-05-15 11:39:36'),
(17, 1, 1, '2026-05-22', '5,8', 1200.00, 'Paid', 'Cancelled', '2026-05-15 11:43:11'),
(18, 1, 1, '2026-04-30', '11', 600.00, 'Paid', 'Cancelled', '2026-05-16 02:14:54');

-- --------------------------------------------------------

--
-- Table structure for table `bus_tour`
--

CREATE TABLE `bus_tour` (
  `id` int(11) NOT NULL,
  `bus_id` int(11) DEFAULT NULL,
  `tour_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `total_seats` int(11) NOT NULL DEFAULT 16
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `title`, `description`, `price`, `image`, `total_seats`) VALUES
(2, 'Manali Trip', '5 Days Manali Adventure', 22000.00, 'manali.png', 16),
(3, 'Goa Tour', 'Beach trip', 15000.00, 'goa.png', 16),
(4, 'Manali Trip', 'Snow adventure', 20000.00, 'manali.jpg', 16);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `seat_number` varchar(10) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `package_id`, `seat_number`, `status`) VALUES
(1, 1, 'A1', 'Available'),
(2, 1, 'A2', 'Available'),
(3, 1, 'A3', 'Available'),
(4, 1, 'A4', 'Available'),
(5, 1, 'B1', 'Available'),
(6, 1, 'B2', 'Available'),
(7, 1, 'B3', 'Available'),
(8, 1, 'B4', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `id` int(11) NOT NULL,
  `tour_name` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `from_city` varchar(100) DEFAULT NULL,
  `to_city` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `email`, `password`, `created_at`) VALUES
(1, 'nilesh', '7020070774', 'patilnileshV25@gmail.com', '412134f251683973df3dcdf8da754d3e', '2026-05-13 17:08:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_bookings`
--
ALTER TABLE `bus_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_tour`
--
ALTER TABLE `bus_tour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bus_bookings`
--
ALTER TABLE `bus_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `bus_tour`
--
ALTER TABLE `bus_tour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bus_tour`
--
ALTER TABLE `bus_tour`
  ADD CONSTRAINT `bus_tour_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`),
  ADD CONSTRAINT `bus_tour_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
