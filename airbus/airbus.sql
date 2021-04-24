-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 24, 2021 at 12:53 AM
-- Server version: 5.7.25
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `airbus`
--

-- --------------------------------------------------------

--
-- Table structure for table `airports`
--

CREATE TABLE `airports` (
  `id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `airports`
--

INSERT INTO `airports` (`id`, `city_id`, `name`) VALUES
(1, 7, 'Платов'),
(2, 1, 'Домодедово'),
(3, 1, 'Внуково');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`) VALUES
(1, 'Москва'),
(4, 'Новороссийск'),
(6, 'Владивосток'),
(7, 'Ростов-на-Дону'),
(9, 'Санкт-Петербург'),
(12, 'Новосибирск'),
(14, 'Казань'),
(15, 'Екатеринбург'),
(17, 'Нижний Новгород'),
(18, 'Челябинск'),
(21, 'Самара'),
(22, 'Омск');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `name`) VALUES
(1, 'Бюджет'),
(2, 'Комфорт'),
(3, 'Бизнес');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `ticket_id` int(10) UNSIGNED NOT NULL,
  `count` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `ticket_id`, `count`) VALUES
(4, 9, 1, 7),
(5, 9, 2, 3),
(6, 9, 4, 1),
(7, 10, 1, 4),
(8, 11, 1, 2),
(9, 11, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `city_from_id` int(10) UNSIGNED NOT NULL,
  `city_to_id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `class_id` int(10) UNSIGNED NOT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `count` int(10) UNSIGNED NOT NULL,
  `airport_from_id` int(10) UNSIGNED NOT NULL,
  `airport_to_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `city_from_id`, `city_to_id`, `date`, `class_id`, `price`, `count`, `airport_from_id`, `airport_to_id`) VALUES
(1, 1, 7, '2020-12-30', 2, 9000, 24, 2, 1),
(2, 1, 7, '2020-12-30', 1, 6000, 17, 2, 1),
(4, 1, 7, '2020-12-30', 3, 12000, 4, 3, 1),
(5, 1, 7, '2020-12-30', 1, 15, 1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'User id',
  `email` varchar(256) NOT NULL COMMENT 'User email',
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(3, '14', 'aab3238922bcc25a6f606eb525ffdc56'),
(4, 'test@mail.ru', 'ad0234829205b9033196ba818f7a872b'),
(5, 'itachi1371@gmail.com', '3b852ab907ae37cd47ec8498a8bb7f08'),
(6, 'test@mail.ru', '3b852ab907ae37cd47ec8498a8bb7f08'),
(7, 'itachi1371@gmail.com', '3b852ab907ae37cd47ec8498a8bb7f08'),
(8, 'test@mail.ru', '119182cda0af2c4c12656711fae9b7cb'),
(9, 'sweetfantasy2019@mail.ru', 'c2db0793a2b8c8f20af9215f4c5b0711'),
(10, 'test@mail.ru', 'ed3dcc518a63f723162cc8279a6906b0'),
(11, 'admin@mail.ru', 'e64b78fc3bc91bcbc7dc232ba8ec59e0'),
(12, 'admin@mail.ru', 'e64b78fc3bc91bcbc7dc232ba8ec59e0'),
(13, 'admin@mail.ru', 'e64b78fc3bc91bcbc7dc232ba8ec59e0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airports`
--
ALTER TABLE `airports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_airports_city` (`city_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_users` (`user_id`),
  ADD KEY `fk_orders_tickets` (`ticket_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_from_id` (`city_from_id`),
  ADD KEY `fk_city_city_to_id` (`city_to_id`),
  ADD KEY `fk_class_class_id` (`class_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airports`
--
ALTER TABLE `airports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'User id', AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `airports`
--
ALTER TABLE `airports`
  ADD CONSTRAINT `fk_airports_city` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_tickets` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`),
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_city_city_from_id` FOREIGN KEY (`city_from_id`) REFERENCES `city` (`id`),
  ADD CONSTRAINT `fk_city_city_to_id` FOREIGN KEY (`city_to_id`) REFERENCES `city` (`id`),
  ADD CONSTRAINT `fk_class_class_id` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
