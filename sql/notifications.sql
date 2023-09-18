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
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` varchar(512) DEFAULT NULL,
  `type` varchar(64) DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `listing_id` varchar(32) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `description`, `type`, `completed`, `user_id`, `listing_id`, `created`) VALUES
(8, 'Purchased goku gif', 'You have successfully bidded over the buyout price or your bid was selected by the lister, congratulations on your new item! Please leave a review below based on your item/experience with the lister, you can either do it now or at a later date by revisiting this notification, thank you.', 'bidding', 1, 14, '6d68d178def9', '2023-05-16 03:23:58'),
(9, 'Purchased purchase for free!', 'You have successfully purchased this item! Congratulations! Please leave a review below based on your item/experience with the lister. You can either do it now or at a later date by revisiting this notification.', 'purchase', 1, 14, 'bd801957f418', '2023-05-16 04:21:26'),
(10, 'Purchased Excalibur', 'You have successfully bidded over the buyout price or your bid was selected by the lister, congratulations on your new item! Please leave a review below based on your item/experience with the lister, you can either do it now or at a later date by revisiting this notification, thank you.', 'bidding', 1, 11, '02c3438ff806', '2023-05-16 16:34:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
