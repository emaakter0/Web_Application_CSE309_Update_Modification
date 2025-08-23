-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2025 at 04:14 PM
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
-- Database: `kittypups`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `pet_name` varchar(50) NOT NULL,
  `pet_age` int(11) DEFAULT NULL,
  `pet_type` enum('cat','dog','bird','rabbit') NOT NULL,
  `problem` text DEFAULT NULL,
  `previous_treatment` text DEFAULT NULL,
  `doctor` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `parent_name`, `email`, `phone_number`, `pet_name`, `pet_age`, `pet_type`, `problem`, `previous_treatment`, `doctor`, `status`, `appointment_date`, `appointment_time`) VALUES
(1, 1, 'aa', 'shahmarufsiraj@gmail.com', '11111111', 'xaas', 143, 'dog', '11', '11', 'Dr. Smith', 1, '2025-08-21', '16:06:00'),
(2, 1, 'aa', 'shahmarufsirajs@gmail.com', '11111111', 'xaas', 155, 'dog', '11', '11', 'Dr. Smith', 1, '2025-08-21', '18:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(32, 1, 9, 1, '2025-08-18 08:22:42'),
(38, 3, 1, 1, '2025-08-18 14:04:59'),
(39, 3, 1, 1, '2025-08-18 14:05:13'),
(40, 3, 10, 1, '2025-08-18 14:21:28');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `username` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `delivery_method` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `district` varchar(50) NOT NULL,
  `area` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `status`, `total_amount`, `shipping_cost`, `delivery_method`, `full_name`, `phone`, `district`, `area`, `address`, `notes`) VALUES
(1, 1, '2025-08-19 00:00:00', 'pending', 40.00, 1.00, 'pickup', 'Shahmaruf Mugdho', '01758551245', 'Dhaka', 'Basundhara R/A', 'House 65, Yousuf Villa, 2 floor\r\nD block Road 04 Boro mosjid', 'sss'),
(2, 1, '2025-08-18 00:00:00', 'pending', 0.00, 12.00, 'pickup', 'Shahmaruf Mugdho', '01758551245', 'Dhaka', 'Basundhara R/A', 'House 65, Yousuf Villa, 2 floor\r\nD block Road 04 Boro mosjid', 'sss'),
(3, 1, '2025-08-18 00:00:00', 'pending', 10.00, 12.00, 'pickup', 'Shahmaruf Mugdho', '01758551245', 'Joypurhat', 'Basundhara R/A', 'House 65, Yousuf Villa, 2 floor\r\nD block Road 04 Boro mosjid', 'sas'),
(4, 1, '2025-08-05 00:00:00', 'pending', 10.00, 11.00, 'pickup', 'Shahmaruf Mugdho', '01758551245', 'abcdef', 'Basundhara R/A', 'House 65, Yousuf Villa, 2 floor\r\nD block Road 04 Boro mosjid', 'sd'),
(5, 1, '2025-08-05 00:00:00', 'pending', 0.00, 11.00, 'pickup', 'Shahmaruf Mugdho', '01758551245', 'abcdef', 'Basundhara R/A', 'House 65, Yousuf Villa, 2 floor\r\nD block Road 04 Boro mosjid', 'sd'),
(6, 1, '2025-08-18 00:00:00', 'pending', 10.00, 1.00, 'pickup', 'Shahmaruf Mugdho', '01758551245', 'Dhaka', 'Basundhara R/A', 'House 65, Yousuf Villa, 2 floor\r\nD block Road 04 Boro mosjid', 'ss'),
(7, 1, '2025-08-18 00:00:00', 'pending', 0.00, 1.00, 'pickup', 'Shahmaruf Mugdho', '01758551245', 'Dhaka', 'Basundhara R/A', 'House 65, Yousuf Villa, 2 floor\r\nD block Road 04 Boro mosjid', 'ss'),
(8, 1, '2025-08-18 00:00:00', 'pending', 0.00, 1.00, 'pickup', 'Shahmaruf Mugdho', '01758551245', 'Dhaka', 'Basundhara R/A', 'House 65, Yousuf Villa, 2 floor\r\nD block Road 04 Boro mosjid', 'ss'),
(9, 2, '2025-08-13 00:00:00', 'pending', 202.00, 10.00, 'Courier', 'Shahmaruf Siraj Mugdho', '01758551245', 'Joypurhat', 'Basundhara R/A', 'Road 07', 'dsddd'),
(10, 1, '2025-08-19 00:00:00', 'processing', 10.00, 10.00, 'Pickup', 'Shahmaruf Siraj Mugdho', '01758551245', 'abcde', 'Basundhara R/A', 'Road 07', 'sdsdfds'),
(11, 2, '2025-08-18 00:00:00', 'pending', 10.00, 60.00, 'Courier', 'Shahmaruf Siraj Mugdho', '01020', 'Dhaka', 'Basundhara R/A', 'Road 07', 'eefdr'),
(12, 1, '2025-08-18 00:00:00', 'pending', 30.00, 60.00, 'Courier', 'Shahmaruf Siraj Mugdho', '01758551245', 'abcde', 'Basundhara R/A', 'Road 07', 'adasda'),
(13, 1, '2025-08-18 00:00:00', 'pending', 10.00, 60.00, 'Courier', 'Shahmaruf Siraj Mugdho', '01758551245', 'abcde', 'Basundhara R/A', 'Road 07', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 10.00),
(2, 1, 1, 1, 10.00),
(3, 1, 1, 1, 10.00),
(4, 1, 1, 1, 10.00),
(5, 3, 1, 1, 10.00),
(6, 4, 1, 1, 10.00),
(7, 6, 1, 1, 10.00),
(8, 9, 1, 1, 10.00),
(9, 9, 2, 1, 10.00),
(10, 9, 2, 1, 10.00),
(11, 9, 2, 1, 10.00),
(12, 9, 2, 1, 10.00),
(13, 9, 2, 1, 10.00),
(14, 9, 2, 1, 10.00),
(15, 9, 2, 1, 10.00),
(16, 9, 2, 1, 10.00),
(17, 9, 2, 1, 10.00),
(18, 9, 2, 1, 10.00),
(19, 9, 2, 1, 10.00),
(20, 9, 3, 1, 10.00),
(21, 9, 6, 1, 12.00),
(22, 9, 6, 1, 12.00),
(23, 9, 6, 1, 12.00),
(24, 9, 6, 1, 12.00),
(25, 9, 6, 1, 12.00),
(26, 9, 6, 1, 12.00),
(27, 10, 1, 1, 10.00),
(28, 11, 1, 1, 10.00),
(29, 12, 1, 1, 10.00),
(30, 12, 7, 2, 10.00),
(31, 13, 8, 1, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `disease` varchar(255) NOT NULL,
  `medication` text NOT NULL,
  `instructions` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `category` enum('cat','dog','rabbit','bird','cat food','kitten food','food','medicine','accessories') DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `brand_name` varchar(200) NOT NULL,
  `weight` varchar(200) NOT NULL,
  `stock` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `rating`, `category`, `description`, `brand_name`, `weight`, `stock`) VALUES
(1, 'abc', 10.00, 'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8Y2F0fGVufDB8fDB8fHww', '5', 'cat', 'aaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaa', '10', 50),
(2, 'Dog', 10.00, 'https://images.unsplash.com/photo-1534361960057-19889db9621e?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '4', 'dog', 'aaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaa', '10', 40),
(3, 'Rabbit', 10.00, 'https://plus.unsplash.com/premium_photo-1661832480567-68a86cb46f34?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '3', 'rabbit', 'aaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaa', '10', 13),
(4, 'Bird', 10.00, 'https://plus.unsplash.com/premium_photo-1674487959493-8894cc9473ea?q=80&w=1236&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '4.5', 'bird', 'aaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaa', '20', 20),
(6, 'ABC', 12.00, 'https://images.unsplash.com/photo-1552053831-71594a27632d?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fGRvZ3xlbnwwfHwwfHx8MA%3D%3D', '0', 'rabbit', 'asdasd', 'asda', '10', 20),
(7, 'cat1', 10.00, 'https://images.unsplash.com/photo-1573865526739-10659fec78a5?q=80&w=715&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '5', 'cat', 'abcd', 'xyz', '10', 20),
(8, 'cat1', 10.00, 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?q=80&w=1143&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '5', 'cat', 'abcd', 'xyz', '10', 20),
(9, 'cat3', 100.00, 'https://images.unsplash.com/photo-1592194996308-7b43878e84a6?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '4', 'cat', 'abcd', 'xyz', '20', 30),
(10, 'Cat Food 1', 100.00, 'https://plus.unsplash.com/premium_photo-1726761692986-6bcde87fc2b8?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8Y2F0JTIwZm9vZHxlbnwwfHwwfHx8MA%3D%3D', '4', 'cat food', 'abcd', 'xyz', '20', 30),
(11, 'Cat Food 2', 100.00, 'https://images.unsplash.com/photo-1655210913315-e8147faf7600?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8Y2F0JTIwZm9vZHxlbnwwfHwwfHx8MA%3D%3D', '4', 'kitten food', 'abcd', 'xyz', '20', 30),
(14, 'abcd', 12.00, 'https://images.unsplash.com/photo-1552053831-71594a27632d?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fGRvZ3xlbnwwfHwwfHx8MA%3D%3D', '0', 'dog', 'aaaa', 'asdaa', '10', 20),
(18, 'Cat Food 1', 100.00, 'https://images.unsplash.com/photo-1655210913151-87ce369ff7d8?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '4', 'food', 'This is one of the best cat food of Bangladesh ever', 'Catsy', '10', 50),
(19, 'Cat Food 2', 100.00, 'https://media.istockphoto.com/id/2162663066/photo/healthy-dog-food-containing-protein-fat-and-carbohydrates.jpg?s=2048x2048&w=is&k=20&c=1r_UgzPxaN5dPwQNAYYbL_JTv9fTysQ84KT5dIA4ER8=', '4', 'food', 'This is one of the best cat food of Bangladesh ever', 'Catsy', '10', 50),
(20, 'Cat carrying bag', 100.00, 'https://media.istockphoto.com/id/157638031/photo/woman-with-pet-carrier.jpg?s=2048x2048&w=is&k=20&c=S7bMetyT0ew4tbyMpMjimY-aKaXlKJbrhJQ9ycjNRq4=', '4', 'accessories', 'This is one of the best cat food of Bangladesh ever', 'Catsy', '10', 50),
(21, 'Christmas Decoration', 100.00, 'https://images.unsplash.com/photo-1704128145534-9f3c14cb23e0?q=80&w=686&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '4', 'accessories', 'This is one of the best cat food of Bangladesh ever', 'Catsy', '10', 50),
(22, 'Cat Medicine', 100.00, 'https://images.unsplash.com/photo-1642177116193-c93e662f0924?q=80&w=880&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '4', 'medicine', 'This is one of the best cat food of Bangladesh ever', 'Catsy', '10', 50),
(23, 'Dog Medicine', 100.00, 'https://images.unsplash.com/photo-1647002380359-9441b5393673?q=80&w=1069&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '4', 'medicine', 'This is one of the best cat food of Bangladesh ever', 'Catsy', '10', 50);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `expires` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','admin','doctor') NOT NULL DEFAULT 'customer',
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `approved` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `phone`, `address`, `approved`, `created_at`, `updated_at`) VALUES
(1, 'Customer', 'customer@example.com', 'abcd', 'customer', '01758551245', '123 Pet Street, Dhaka', 1, '2025-08-16 13:08:32', '2025-08-18 08:19:11'),
(2, 'Admin', 'admin@example.com', 'abcd', 'admin', '+8801722222222', '456 Admin Road, Dhaka', 1, '2025-08-16 13:08:32', '2025-08-17 16:57:29'),
(3, 'Doctor', 'doctor@example.com', 'abcd', 'doctor', '+8801733333333', '789 Manager Lane, Dhaka', 1, '2025-08-16 13:08:32', '2025-08-17 16:57:33'),
(4, 'ema', 'ema@gmail.com', 'abcd', 'doctor', '01758551245', 'C Block', 1, '2025-08-17 14:51:15', '2025-08-17 15:03:33'),
(7, 'joy', 'joy@gmail.com', 'abcd', 'customer', '01758551245', 'X block', 1, '2025-08-17 14:55:37', '2025-08-17 14:55:37'),
(8, 'hima', 'hima@gmail.com', 'abcd', 'doctor', '01758551245', 'cc', 1, '2025-08-17 15:02:08', '2025-08-17 15:03:18'),
(9, 'gray', 'gray@gmail.com', 'abcd', 'doctor', '01758551245', 'aa', 1, '2025-08-17 15:05:42', '2025-08-17 15:05:42'),
(10, 'joynob', 'joynob@gmail.com', 'abcd', 'admin', NULL, NULL, 1, '2025-08-17 16:55:57', '2025-08-17 17:02:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `district_id` (`district_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

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
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `areas_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
