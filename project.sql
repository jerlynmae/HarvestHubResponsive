-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2025 at 01:47 AM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `farms`
--

CREATE TABLE `farms` (
  `id` int(11) NOT NULL,
  `farm_name` varchar(150) NOT NULL,
  `farm_location` varchar(255) NOT NULL,
  `farm_type` varchar(100) NOT NULL,
  `farm_size` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farms`
--

INSERT INTO `farms` (`id`, `farm_name`, `farm_location`, `farm_type`, `farm_size`, `created_at`) VALUES
(1, 'Mang Juan Farm', 'Laon, Mogpog Marinduque', 'Owned', '2 hectares', '2025-09-12 13:59:30'),
(2, 'Mang Juan Farm', 'Laon, Mogpog Marinduque', 'Owned', '2 hectares', '2025-09-12 14:00:23');

-- --------------------------------------------------------

--
-- Table structure for table `farm_inputs`
--

CREATE TABLE `farm_inputs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `date_added` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farm_inputs`
--

INSERT INTO `farm_inputs` (`id`, `user_id`, `type`, `cost`, `date_added`) VALUES
(5, 2, 'Seed', 200.00, '2025-09-13'),
(6, 2, 'Seed', 600.00, '2025-09-13'),
(7, 2, 'Seed', 700.00, '2025-09-13'),
(8, 5, 'Seed', 700.00, '2025-09-15');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `lot_size` varchar(50) DEFAULT '1 lot',
  `contact_number` varchar(20) DEFAULT NULL,
  `mode_of_payment` varchar(50) DEFAULT NULL,
  `date_time` datetime DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Pending',
  `delivery_fee` decimal(10,2) DEFAULT 0.00,
  `service_fee` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) DEFAULT 0.00,
  `delivery_datetime` datetime DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `name`, `address`, `lot_size`, `contact_number`, `mode_of_payment`, `date_time`, `status`, `delivery_fee`, `service_fee`, `total`, `delivery_datetime`, `note`, `created_at`) VALUES
(1, NULL, 'Laon, Mogpog Marinduque', '1 lot', NULL, NULL, '2025-09-18 14:32:29', 'Cancelled', 50.00, 5.00, 205.00, '2025-09-18 09:32:29', '', '2025-09-18 14:32:29'),
(2, NULL, 'Laon, Mogpog Marinduque', '1 lot', NULL, NULL, '2025-09-18 14:33:04', 'Completed', 50.00, 5.00, 205.00, '2025-09-18 09:33:04', '', '2025-09-18 14:33:04'),
(3, NULL, 'Laon, Mogpog Marinduque', '1 lot', NULL, NULL, '2025-09-18 17:46:55', 'Pending', 50.00, 5.00, 205.00, NULL, NULL, '2025-09-18 17:46:55'),
(4, NULL, 'Laon, Mogpog Marinduque', '1 lot', NULL, NULL, '2025-09-18 17:53:19', 'Pending', 5.00, 5.00, 160.00, NULL, NULL, '2025-09-18 17:53:19');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 2, 6, 1, 150.00),
(2, 3, 6, 1, 150.00),
(3, 4, 7, 1, 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category`, `name`, `price`, `image`, `user_id`, `stock`) VALUES
(4, 'vegetable', 'kangkong', 150.00, NULL, 0, 0),
(6, 'fruits', 'Mangga', 150.00, '1757934033_Blue Bold Modern Minimalist Resume (1).png', 5, 0),
(7, 'Fruits', 'Apple', 150.00, '1758023293_apple.jpg', 2, 12),
(8, 'Fruits', 'Banana', 150.00, '1758086609_banana.jpg', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','farmer') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contact`, `address`, `password`, `role`) VALUES
(1, 'Alaiza Labaguis Milambiling', 'alaiza@gmail.com', '09531137624', 'Laon, Mogpog Marinduque', '$2y$10$FeHugrYCrMFylNS1dxKuo.15MUcC0NGLgEdK4pRywMYZnMzhHQylm', 'customer'),
(2, 'Mae errg Luz', 'jerlynmaeloslosmagante@gmail.com', '09531137624', 'Laon, Mogpog Marinduque', '$2y$10$GqicHcGvHBMElqLFnSgoluMgr8dCUKc5KdkAtoP0TSRMvCNgMZhfG', 'farmer'),
(4, 'Mae errg Luz', 'jerlynmaeloslosmagante12@gmail.com', '09531137624', 'Laon, Mogpog Marinduque', '$2y$10$dgprS2iKYVzWAIajr3VnVu7nPoR3UfGe3c7U0mCPMin0ZTQMfmpTu', 'farmer'),
(5, 'Jerlyn Mae L. Magante', 'magante.jerlynmae@marsu.edu.ph', '09531137624', 'Laon, Mogpog Marinduque', '$2y$10$DSPIIluN/2j1/4aVG9Um.uxQCsIICdwupO8fMl7JeqrTgzZ4dzOya', 'customer'),
(6, 'jerlyn mae Magante loslos', 'maemagante31@gmail.com', '09531137624', 'Laon, Mogpog Marinduque', '$2y$10$E.hRb740J4inG3orZGDOCOA3x5T8IpJymk5XHoHNKWM53kEpna/IO', 'farmer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `farms`
--
ALTER TABLE `farms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farm_inputs`
--
ALTER TABLE `farm_inputs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

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
-- AUTO_INCREMENT for table `farms`
--
ALTER TABLE `farms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `farm_inputs`
--
ALTER TABLE `farm_inputs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
