-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2025 at 01:34 PM
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
-- Database: `question`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `questions_ID` int(11) NOT NULL,
  `commentText` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT NULL,
  `email` text NOT NULL,
  `message` text NOT NULL,
  `is_admin_reply` text NOT NULL,
  `parent_id` text DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `username` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_name` text NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_name`, `sender_email`, `subject`, `message`, `created_at`) VALUES
(2, 'dv', '54be53bf@gmail.com', 'hhih', 'chao cau', '2025-12-01 12:12:07'),
(3, 'admin', 'admin@example.com', '', '', '2025-12-01 19:14:01'),
(4, 'vvvv', 'nhudthgcs220086@fpt.edu.vn', '', '', '2025-12-01 19:14:01'),
(5, 'ggggg', 'naaaa@gmail.com', '', '', '2025-12-01 19:14:01'),
(6, 'HÀ', 'ha@gmail.com', 'COMP1841', 'Does Java-SpringFramework exist?', '2025-12-02 09:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `Modulename` varchar(100) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `Modulename`, `created_at`, `description`) VALUES
(1, 'COMP1770', NULL, ''),
(2, 'COMP1773', NULL, ''),
(3, 'COMP1841', NULL, ''),
(4, 'AIGW201', NULL, ''),
(5, 'COMP1843', NULL, ''),
(7, 'COMP1677', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `ID` int(11) NOT NULL,
  `questiontext` text DEFAULT NULL,
  `questiondate` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `moduleid` int(11) DEFAULT NULL,
  `questiontime` time DEFAULT NULL,
  `username` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`ID`, `questiontext`, `questiondate`, `image`, `users_id`, `moduleid`, `questiontime`, `username`) VALUES
(71, 'Do you enjoy your work environment?', '2025-11-07', 'image/img_690e05a119fdc9.93180481.png', 1, 2, '15:59:57', 'scdcd'),
(86, 'What is AI chart?', '2025-12-01', 'image/img_692c8f768b7427.25232419.png', NULL, 1, '16:22:43', 'hA'),
(97, 'Java-SpringFramework exist?\r\n', '2025-12-02', 'image/img_692eb5e77ee3a7.74935646.png', 36, 3, '16:48:23', 'Hà');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@example.com', 'pass123', 'admin', '2025-11-27 16:37:41'),
(28, 'ggggg', 'naaaa@gmail.com', '$2y$10$yTOuADNFxA80XsJPQ3uGvuvmEfkTWFo740tk3xF0ZDHBmCIYTrD56', 'user', '2025-12-02 08:10:21'),
(35, 'Huỳnh Như', 'nhudthgcs220086@fpt.edu.vn', '$2y$10$2AuMCkYYk.5Hk9aPEBnZVeaVmrwsY7AA3LBQDrLcCjfigaWJaPqOa', 'user', '2025-12-02 09:42:57'),
(36, 'Hà', 'ha@gmail.com', '$2y$10$c1hGNcNzu5eLBKLinDYyUeL6OI2ZvgAFUadxhaZTeT/BwgdOo8Ssa', 'user', '2025-12-02 09:48:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`),
  ADD KEY `id_3` (`id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `questions_ID` (`questions_ID`),
  ADD KEY `questions_ID_2` (`questions_ID`),
  ADD KEY `questions_ID_3` (`questions_ID`),
  ADD KEY `questions_ID_4` (`questions_ID`),
  ADD KEY `questions_ID_5` (`questions_ID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sender_email` (`sender_email`),
  ADD UNIQUE KEY `sender_name` (`sender_name`) USING HASH;

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Modulename` (`Modulename`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `users_id` (`users_id`),
  ADD KEY `categoryid` (`moduleid`),
  ADD KEY `authorid` (`users_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`questions_ID`) REFERENCES `questions` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`moduleid`) REFERENCES `module` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `questions_ibfk_3` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`email`) REFERENCES `messages` (`sender_email`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
