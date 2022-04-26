-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 21, 2022 at 06:11 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nti_banking`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocked_users`
--

CREATE TABLE `blocked_users` (
  `id` tinyint(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `user_id` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` tinyint(10) NOT NULL,
  `user_id` tinyint(11) NOT NULL,
  `transaction_id` tinyint(11) NOT NULL,
  `reason` char(150) NOT NULL,
  `status` enum('pending','completed','refused') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `transaction_id`, `reason`, `status`) VALUES
(3, 5, 3, 'Help Me', 'completed'),
(5, 5, 1, 'Hey BN', 'refused');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` tinyint(11) NOT NULL,
  `user_sender_id` tinyint(11) NOT NULL,
  `user_receiver_id` tinyint(11) NOT NULL,
  `type` enum('deposit','withdraw') NOT NULL,
  `status` enum('pending','completed','refused') NOT NULL DEFAULT 'pending',
  `amount` decimal(10,0) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_sender_id`, `user_receiver_id`, `type`, `status`, `amount`, `reason`, `date`) VALUES
(1, 5, 3, 'deposit', 'pending', '5', 'Helping This ', '2022-04-21 03:41:16'),
(2, 5, 3, 'deposit', 'pending', '5', 'Helping This ', '2022-04-21 03:41:16'),
(3, 3, 5, 'withdraw', 'completed', '50', 'Help Me Body', '2022-04-21 04:10:15'),
(4, 5, 3, 'deposit', 'pending', '14', 'Helping You Darling', '2022-04-21 03:41:16'),
(5, 5, 4, 'deposit', 'pending', '5', 'Helping Abdo', '2022-04-21 03:41:16'),
(6, 5, 4, 'deposit', 'completed', '5', 'Hey BEBE', '2022-04-21 03:47:41'),
(7, 5, 4, 'deposit', 'completed', '13', 'Hey Lebda', '2022-04-21 03:42:50');

-- --------------------------------------------------------

--
-- Table structure for table `transactions_log`
--

CREATE TABLE `transactions_log` (
  `id` tinyint(11) NOT NULL,
  `transaction_id` tinyint(11) NOT NULL,
  `status` enum('pending','completed','refused') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions_log`
--

INSERT INTO `transactions_log` (`id`, `transaction_id`, `status`) VALUES
(1, 1, 'refused'),
(2, 1, 'completed'),
(3, 3, 'refused'),
(4, 3, 'completed'),
(5, 1, 'completed'),
(6, 1, 'refused'),
(7, 2, 'completed'),
(8, 1, 'completed'),
(9, 1, 'refused'),
(10, 2, 'refused'),
(11, 4, 'completed'),
(12, 1, 'completed'),
(13, 3, 'completed'),
(14, 2, 'completed'),
(15, 4, 'completed'),
(16, 1, 'completed'),
(17, 2, 'completed'),
(18, 2, 'completed'),
(19, 2, 'completed'),
(20, 4, 'completed'),
(21, 4, 'completed'),
(22, 3, 'completed'),
(23, 3, 'completed'),
(24, 3, 'refused'),
(25, 7, 'completed'),
(26, 6, 'completed'),
(27, 6, 'completed'),
(28, 6, 'completed'),
(29, 6, 'completed'),
(30, 6, 'completed'),
(31, 5, 'completed'),
(32, 5, 'completed'),
(33, 5, 'completed'),
(34, 5, 'completed'),
(35, 5, 'completed'),
(36, 5, 'completed'),
(37, 4, 'completed'),
(38, 4, 'completed'),
(39, 4, 'completed'),
(40, 4, 'completed'),
(41, 4, 'completed'),
(42, 2, 'completed'),
(43, 2, 'completed'),
(44, 2, 'completed'),
(45, 2, 'completed'),
(46, 1, 'completed'),
(47, 1, 'completed'),
(48, 1, 'completed'),
(49, 1, 'completed'),
(50, 1, 'completed'),
(51, 1, 'completed'),
(52, 1, 'completed'),
(53, 1, 'completed'),
(54, 1, 'completed'),
(55, 1, 'completed'),
(56, 1, 'completed'),
(57, 1, 'completed'),
(58, 1, 'completed'),
(59, 1, 'completed'),
(60, 1, 'completed'),
(61, 3, 'completed'),
(62, 7, 'completed'),
(63, 6, 'completed'),
(64, 6, 'completed'),
(65, 6, 'completed'),
(66, 6, 'completed'),
(67, 6, 'completed'),
(68, 6, 'completed'),
(69, 6, 'completed'),
(70, 6, 'completed'),
(71, 6, 'completed'),
(72, 6, 'completed'),
(73, 6, 'completed'),
(74, 6, 'completed'),
(75, 6, 'completed'),
(76, 3, 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` tinyint(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `balance` decimal(10,0) NOT NULL DEFAULT 100,
  `image` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(150) NOT NULL,
  `mobile` char(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `verify` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `country`, `balance`, `image`, `email`, `password`, `mobile`, `date`, `role`, `verify`) VALUES
(3, 'Abdelaziz', 'Omar', 'Egypt', '39', '625f03355b99e.png', 'abdelazizomar851@gmail.com', 'd46a2c0515e1be9d6e8dc7ed94f93c90', '01146770238', '2022-04-21 04:10:15', 'user', 0),
(4, 'Kendall', 'Carson', 'Peru', '130', '625f036355209.png', 'abdelazizomar2@gmail.com', 'd46a2c0515e1be9d6e8dc7ed94f93c90', '01146770238', '2022-04-20 02:46:09', 'user', 0),
(5, 'Mahmoud', 'Ahmed Lebda', 'Afganistan', '206', '625f58382d8d9.png', 'mahmodbashalebda@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', '01227087359', '2022-04-21 04:10:15', 'user', 0),
(6, 'Mahmoud', 'Ahmed Lebda', 'Afganistan', '9999999999', '62609d04ad36b.png', 'mahmodbashalebda1@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', '01227087359', '2022-04-20 23:53:40', 'admin', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blockedusers_FK_1` (`user_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_FK_1` (`user_sender_id`),
  ADD KEY `receiver_FK_1` (`user_receiver_id`);

--
-- Indexes for table `transactions_log`
--
ALTER TABLE `transactions_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blocked_users`
--
ALTER TABLE `blocked_users`
  MODIFY `id` tinyint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` tinyint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` tinyint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transactions_log`
--
ALTER TABLE `transactions_log`
  MODIFY `id` tinyint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` tinyint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD CONSTRAINT `blockedusers_FK_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`id`) REFERENCES `transactions` (`user_sender_id`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `transactions` (`user_receiver_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `receiver_FK_1` FOREIGN KEY (`user_receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sender_FK_1` FOREIGN KEY (`user_sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions_log`
--
ALTER TABLE `transactions_log`
  ADD CONSTRAINT `transactions_log_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
