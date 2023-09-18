-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2023 at 07:02 PM
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
-- Table structure for table `logging`
--

CREATE TABLE `logging` (
  `errid` int(11) NOT NULL,
  `errorlevel` int(11) NOT NULL,
  `line` int(11) NOT NULL,
  `errormessage` varchar(512) NOT NULL,
  `stacktrace` varchar(512) NOT NULL,
  `occurance` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logging`
--

INSERT INTO `logging` (`errid`, `errorlevel`, `line`, `errormessage`, `stacktrace`, `occurance`) VALUES
(13, 5, 175, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column \'profilePicture\' in \'field list\'', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-03 17:34:17'),
(14, 5, 175, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column \'profilePicture\' in \'field list\'', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-03 17:36:14'),
(15, 5, 175, 'SQLSTATE[42S22]: Column not found: 1054 Unknown column \'profilePicture\' in \'field list\'', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-03 17:36:15'),
(16, 5, 130, 'SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \':type AND WHERE tags = :tags AND archived = 0 ORDER BY created DESC\' at line 1', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-04 01:44:53'),
(17, 5, 130, 'SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \':type AND WHERE tags = :tags AND archived = 0 ORDER BY created DESC\' at line 1', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-04 01:45:12'),
(18, 5, 175, 'SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near \'WHERE tags = \'all\' AND archived = 0 ORDER BY created DESC\' at line 1', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-04 01:45:40'),
(19, 5, 175, 'SQLSTATE[HY093]: Invalid parameter number: parameter was not defined', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-04 01:47:20'),
(20, 5, 175, 'SQLSTATE[23000]: Integrity constraint violation: 1048 Column \'listing_id\' cannot be null', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-10 16:07:17'),
(21, 5, 175, 'SQLSTATE[42S02]: Base table or view not found: 1146 Table \'final.users\' doesn\'t exist', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-15 02:52:42'),
(22, 5, 175, 'SQLSTATE[42S02]: Base table or view not found: 1146 Table \'final.users\' doesn\'t exist', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-15 02:52:42'),
(23, 5, 175, 'SQLSTATE[42S02]: Base table or view not found: 1146 Table \'final.users\' doesn\'t exist', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-15 02:52:42'),
(24, 5, 175, 'SQLSTATE[42S02]: Base table or view not found: 1146 Table \'final.users\' doesn\'t exist', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-15 02:52:42'),
(25, 5, 175, 'SQLSTATE[42S02]: Base table or view not found: 1146 Table \'final.users\' doesn\'t exist', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-15 02:52:42'),
(26, 5, 175, 'SQLSTATE[42S02]: Base table or view not found: 1146 Table \'final.users\' doesn\'t exist', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-15 02:52:42'),
(27, 5, 175, 'SQLSTATE[42S02]: Base table or view not found: 1146 Table \'final.users\' doesn\'t exist', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-15 02:52:42'),
(28, 5, 175, 'SQLSTATE[42S02]: Base table or view not found: 1146 Table \'final.users\' doesn\'t exist', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-15 02:52:42'),
(29, 5, 175, 'SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens', 'D:\\xampp\\htdocs\\webprogramming1\\finalproject\\libs\\pdo.php', '2023-05-15 03:12:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logging`
--
ALTER TABLE `logging`
  ADD PRIMARY KEY (`errid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logging`
--
ALTER TABLE `logging`
  MODIFY `errid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
