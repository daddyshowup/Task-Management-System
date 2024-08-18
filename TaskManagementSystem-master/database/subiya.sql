-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2024at 011:00 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `Rohitdb`  
-- --------------------------------------------------------
-- Table structure for table `tasks`


CREATE TABLE `tasks` (
  `Sno` int(11) NOT NULL,
  `task-name` varchar(200) NOT NULL,
  `task-desc` text NOT NULL,
  `due-date` timestamp NULL DEFAULT current_timestamp(),
  `priority` int(10) DEFAULT 4,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user-id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`Sno`, `task-name`, `task-desc`, `due-date`, `priority`, `timestamp`, `user-id`) VALUES
(1, 'is it working now??', 'i think yessss', '2022-11-25 18:29:00', 4, '2022-11-25 14:51:33', 1),
(2, 'hello this is today task with 1st priority', 'and this is first priority task description', '2022-11-25 18:29:00', 1, '2022-11-25 14:52:03', 1),
(3, '2nd priority task', '', '2022-11-25 18:29:00', 2, '2022-11-25 14:52:20', 1),
(4, 'another task with 1st priority here', 'and also with due date of 1 jan 2023', '2023-01-01 18:29:00', 1, '2022-11-25 14:53:14', 1),
(5, 'hii this is task with 3rd priority', '', '2022-12-11 18:29:00', 3, '2022-11-25 14:53:46', 1),
(6, 'task with no priorityy sett', '', '2022-11-25 18:29:00', 4, '2022-11-25 14:54:21', 1),
(7, 'aaaa', 'aaaa', '2022-11-25 18:29:00', 4, '2022-11-25 14:54:43', 1),
(8, 'zzzz', 'zzzz', '2022-11-25 18:29:00', 4, '2022-11-25 14:54:57', 1),
(9, 'another task here ', '', '2022-11-25 18:29:00', 2, '2022-11-25 14:55:21', 1),
(10, 'my task', '', '2022-11-25 18:29:00', 2, '2022-11-25 14:55:30', 1),
(11, 'why it is not getting save in database?', 'now it got saved ', '2022-11-25 18:29:00', 3, '2022-11-25 14:56:04', 1),
(12, 'completeddddddddd', 'yeahhhhhhhh', '2022-11-25 18:29:00', 4, '2022-11-25 14:56:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `created_at`) VALUES
(1, 'rohit@gmail.com', 'Rohit', '$2y$10$3pyaQ.kpPUDYMc8xGsUunOTgRPvPmSAoqiZ7H0YXpSD...', '2024-08-17 21:05:32');

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`Sno`),
  ADD KEY `user-id` (`user-id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `Sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `test` FOREIGN KEY (`user-id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
