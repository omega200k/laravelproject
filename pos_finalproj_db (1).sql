-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2026 at 02:36 PM
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
-- Database: `pos_finalproj_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES
(1, 'Juan dela Cruz', 'juan.delacruz@example.com', '0917 123 4567', '2026-11-18 22:08:45'),
(2, 'Ana Reyes', 'ana.reyes@example.com', '0928 555 0192', '2026-11-18 22:08:45'),
(3, 'Carlo Mendoza', 'carlo.mendoza@example.com', NULL, '2026-11-18 22:08:45'),
(4, 'Bianca Lim', 'bianca.lim@example.com', '0905 888 2210', '2026-11-18 22:08:45'),
(5, 'Paolo Villanueva', 'paolo.v@example.com', '+63 917 777 3344', '2026-11-18 22:08:45');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock_quantity`, `image`, `created_at`) VALUES
(1, 'Wireless Mouse', 599.00, 37, NULL, '2026-11-18 22:08:45'),
(2, 'Mechanical Keyboard', 2499.50, 16, NULL, '2026-11-18 22:08:45'),
(3, 'USB-C Hub 7-in-1', 1299.00, 24, NULL, '2026-11-18 22:08:45'),
(4, '27\" IPS Monitor', 9999.00, 43, 'product-images/ce9f25af-e1d3-4830-9063-6b7e78cf0839.jpg', '2026-11-18 22:08:45'),
(5, 'Laptop Stand (Aluminum)', 749.00, 28, NULL, '2026-11-18 22:08:45'),
(6, 'Webcam 1080p', 1899.00, 4, NULL, '2026-11-18 22:08:45'),
(7, 'HDMI Cable 2m', 249.00, 112, NULL, '2026-11-18 22:08:45'),
(8, 'Gaming Mousepad XL', 399.00, 0, NULL, '2026-11-18 22:08:45'),
(9, 'RTX 5090 12gb', 498000.00, 1, 'product-images/e81a68b1-65e0-4cf1-809c-7d2c446af827.jpg', '2026-11-18 14:17:16');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `sold_by` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `customer_id`, `sold_by`, `quantity`, `total_price`, `created_at`) VALUES
(1, 1, 1, 1, 3, 1797.00, '2026-11-12 22:08:45'),
(2, 2, 2, 1, 2, 4999.00, '2026-11-13 22:08:45'),
(3, 3, NULL, 1, 1, 1299.00, '2026-11-14 22:08:45'),
(4, 4, 3, 1, 1, 9999.00, '2026-11-15 22:08:45'),
(5, 5, 4, 1, 4, 2996.00, '2026-11-16 22:08:45'),
(6, 7, NULL, 1, 5, 1245.00, '2026-11-17 22:08:45'),
(7, 4, NULL, 1, 3, 29997.00, '2026-11-18 14:14:12'),
(8, 4, NULL, 1, 1, 9999.00, '2026-11-23 12:40:54'),
(9, 7, 4, 1, 3, 747.00, '2026-11-23 12:41:32'),
(10, 9, NULL, 3, 1, 498000.00, '2026-11-23 12:51:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'staff',
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `role`, `password`, `avatar`, `created_at`) VALUES
(1, 'admin', 'Foilan Santos', 'admin', '$2y$12$e5GlPUWtcpKf1RUghQtyH.kzZRAj7VgqCGEwbs6d/M17Fagxjx8Bm', 'avatar/f1f0c7d3-16b1-40e1-a7bf-83a80e245fbf.jpg', '2026-11-18 22:06:16'),
(3, 'TwinkleToes', 'Allen Iturrios', 'staff', '$2y$12$WnCNnsVr7wVaIV3fg/8x5ebklPYtob1e7le8Q4eIGA1yA.RPqz7VK', 'avatar/4061677f-b504-4df6-bb39-1abd112bff84.jpg', '2026-11-18 22:10:37'),
(4, 'LPstaff', 'Lester Policena', 'staff', '$2y$12$Q0ALoGc5giNnyJrnguLhvejI6y6q.kR7HSH/G0ukTTpWd.Q3fgClO', 'avatar/9b0dcba9-377f-4a66-8ed0-48310d0479cd.jpg', '2026-11-18 22:10:37'),
(6, 'Coolguy25', 'Reimone Bradley Valdes', 'staff', '$2y$12$0kslbNvEtBe5j2xE417ea.lTnZsYy9/DN705WidQp8vTmI4AE3P46', 'avatar/42a95895-cce1-490a-b3a6-dd30f1239c6f.jpg', '2026-11-22 08:47:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `sold_by` (`sold_by`);

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
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `sales_ibfk_3` FOREIGN KEY (`sold_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
