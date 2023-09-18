-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2023 at 07:01 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final`
--

-- --------------------------------------------------------

--
-- Table structure for table `sz_users`
--

CREATE TABLE `sz_users` (
  `id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(128) NOT NULL,
  `roles` varchar(256) DEFAULT 'user',
  `profile_img` varchar(512) NOT NULL DEFAULT 'default.png',
  `suspended` int(11) NOT NULL DEFAULT 0,
  `bio` varchar(128) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `location` varchar(56) DEFAULT NULL,
  `joined` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sz_users`
--

INSERT INTO `sz_users` (`id`, `username`, `password`, `email`, `roles`, `profile_img`, `suspended`, `bio`, `birthday`, `location`, `joined`, `rating`) VALUES
(10, 'user', '$2y$10$FeLOsZo5zw20dEn7WQ/fk.o0OUVd9KX1hkVbjutBNtR0ZxulHCHG2', 'user@gmail.com', 'user', '10.png', 0, NULL, NULL, NULL, '2023-05-02 01:54:21', 0),
(11, 'admin', '$2y$10$GnKPVMmXlFgobmgi4ZEamedaJqqPrU.XOorVqh0mwMquFnWjeio2a', 'admin@gmail.com', 'user,admin,superadmin', '11.gif', 0, 'sup sup, try not to get banned', '2002-04-28', 'USA', '2023-05-02 01:54:21', 1),
(12, 'tinnyman', '$2y$10$fO1p9mU.mD7hAAtLGEBTz.BIEbXdlf4Sw2GV2mu.onp/FUhvTQwbC', 'tinnyman@gmail.com', 'user,admin', '12.png', 0, '', '2002-11-19', 'Wisconsin Rapids, Wisconsin', '2023-05-02 01:54:21', 0),
(13, 'longusername', '$2y$10$IU6YkHJM9xy/2BDlzUu0COYQBi/15y3RtG9vk189Tfqa0DoHib/Oe', 'longusername@gmail.com', 'user', 'default.png', 0, 'MAXING OUT ALL THE CHARACTERS, LOREM IPSUM, LOREM IPSUM, LOREM IPSUM, LOREM IPSUM, LOREM IPSUM', '2002-04-28', 'THE NETHERLANDS', '2023-05-02 03:53:42', 0),
(14, 'seeddummy', '$2y$10$qz0c7F9dXsSKoBFeJ9u5d.FKpWMHD14Q70yY1coUWjiKUaiGlUbaG', 'seed@gmail.com', 'user,admin', '14.png', 0, 'All these items gotta sell...', '2001-05-18', 'Venezuela', '2023-05-09 19:27:02', 5),
(15, 'logan', '$2y$10$wblffNRkmagDhppAbWuYM.IPJIdUfeuwlmYfxTtPUUsS7szmGwAeW', 'logan@gmail.com', 'user,admin', '15.png', 0, '', '0000-00-00', '', '2023-05-13 00:29:26', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sz_users`
--
ALTER TABLE `sz_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sz_users`
--
ALTER TABLE `sz_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
