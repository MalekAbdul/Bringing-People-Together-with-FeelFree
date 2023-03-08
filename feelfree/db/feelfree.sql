-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2021 at 02:58 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `feelfree`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `ca` int(11) NOT NULL DEFAULT 0,
  `ta` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `pd` datetime NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `name` text NOT NULL,
  `phone` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` text DEFAULT NULL,
  `birthday` datetime NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'default.png',
  `level` tinyint(1) NOT NULL DEFAULT 2,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `vkey` text NOT NULL,
  `verification` tinyint(1) NOT NULL DEFAULT 0,
  `otp` text DEFAULT NULL,
  `otp_create` datetime NOT NULL DEFAULT current_timestamp(),
  `reg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `phone`, `email`, `pass`, `birthday`, `gender`, `photo`, `level`, `status`, `vkey`, `verification`, `otp`, `otp_create`, `reg_date`) VALUES
(1, 'Abdul Malek', '1778681516', 'abdul.malek2697@gmail.com', '$2y$10$bHIopsLKVjdQBTm2WUKrxetuQaFVlSqzmdpxEIiUjrYa.L/1Op.xm', '1997-10-24 00:00:00', 1, 'malek.jpg', 1, 1, '605f90c5d53df184b8f2d2d9c380ad4b', 0, '75700', '2020-02-25 14:16:54', '2020-02-06 19:56:58');

-- --------------------------------------------------------

--
-- Table structure for table `verification`
--

CREATE TABLE `verification` (
  `vid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `bcn` varchar(25) NOT NULL,
  `nidn` varchar(17) NOT NULL,
  `bcp` varchar(255) NOT NULL,
  `nidp` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `sub_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `users_email_uindex` (`email`);

--
-- Indexes for table `verification`
--
ALTER TABLE `verification`
  ADD PRIMARY KEY (`vid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `verification`
--
ALTER TABLE `verification`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
