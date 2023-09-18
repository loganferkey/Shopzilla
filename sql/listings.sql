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
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `guid` varchar(12) NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` varchar(256) NOT NULL,
  `type` varchar(16) NOT NULL,
  `buyout` decimal(10,2) DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `img_path` varchar(512) NOT NULL DEFAULT 'default.png',
  `user_id` int(11) NOT NULL,
  `sold` tinyint(1) NOT NULL DEFAULT 0,
  `tags` varchar(32) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`guid`, `title`, `description`, `type`, `buyout`, `price`, `img_path`, `user_id`, `sold`, `tags`, `created`, `archived`) VALUES
('02c3438ff806', 'Excalibur', 'If you pull it out I\'ll give you 5 bucks off', 'bidding', '99999999.99', NULL, '02c3438ff806.jpg', 14, 1, 'other', '2023-05-16 06:00:46', 0),
('033cb7eeaa34', 'my roommate\'s lamp', 'He isn\'t paying rent so I\'m selling his stuff, this one\'s pretty good about 35 lumens', 'purchase', NULL, '25.00', '033cb7eeaa34.jpg', 14, 0, 'homedecor', '2023-05-16 05:36:03', 0),
('19c65ee0bb3f', 'New/Used Toyota 4Runner', 'Runs like brand new, only 750k miles with a slight scratch on the frontend, 35K OBO NO HAGGLING!', 'purchase', NULL, '35000.00', '19c65ee0bb3f.jpg', 11, 0, 'automotive', '2023-05-03 18:17:10', 0),
('1a823b6ed90f', 'milwaukee toolset', 'This is definitely not stolen from Home Depot', 'purchase', NULL, '1300.00', '1a823b6ed90f.jpg', 14, 0, 'tools', '2023-05-16 05:44:14', 0),
('1d92adaa16cd', 'Office Chair', 'Rarely used almost brand new', 'purchase', NULL, '135.99', '1d92adaa16cd.jpg', 11, 0, 'homedecor', '2023-05-03 18:29:40', 0),
('1f419c387b29', 'Gigabag', 'SUPER HUGE beanbag, costed me a fortune for all those foam peanuts!', 'purchase', NULL, '660.00', '1f419c387b29.jpg', 14, 0, 'homedecor', '2023-05-16 05:41:04', 0),
('272470dbe512', 'void', 'lovecraftian horror', 'purchase', NULL, '9999999.00', 'default.png', 14, 0, 'none', '2023-05-16 05:46:28', 0),
('2b409d511624', 'catalytic converter', 'asking for slightly more than the junkyard, idk what car it is I just sawed it off in a parking lot', 'purchase', NULL, '750.00', '2b409d511624.jpg', 14, 0, 'automotive', '2023-05-16 05:32:49', 0),
('4571fd993880', 'Corsair Vengeance 2x16gb', 'Didn\'t fit my slot, only slightly cracked the ram when trying to install', 'purchase', NULL, '129.99', '4571fd993880.jpg', 14, 0, 'electronics', '2023-05-16 05:55:15', 0),
('638859d5b0a4', '2004 honda civic', '138k miles, need frame replacement', 'purchase', NULL, '1375.00', '638859d5b0a4.jpg', 10, 0, 'automotive', '2023-05-03 19:32:00', 0),
('6483bd3a9e1f', 'i7 9700k', 'Didn\'t fit my motherboard slot, don\'t try to lowball me I KNOW WHAT I GOT', 'purchase', NULL, '359.99', '6483bd3a9e1f.jpg', 14, 0, 'electronics', '2023-05-16 05:57:04', 0),
('686308c15f2e', 'my silverware', 'Really need the money on these, they\'ve only been used for a little less than 13 years', 'purchase', NULL, '70.00', '686308c15f2e.jpg', 14, 0, 'homedecor', '2023-05-16 05:42:17', 0),
('6d68d178def9', 'goku gif', 'Limited edition from the movie, good luck getting this for cheap!', 'bidding', '13000000.00', NULL, '6d68d178def9.gif', 11, 1, 'other', '2023-05-03 06:37:41', 0),
('839b30a481fd', 'captain america suit', 'yes im wearing it in the picture, i washed it since then', 'purchase', NULL, '119.00', '839b30a481fd.png', 12, 0, 'other', '2023-05-03 22:15:49', 0),
('83a78b80fd6d', 'SUPER RARE PHILOSOPHERS STONE', 'You aren\'t gonna be able to find this anywhere else, good luck, NO HAGGLING!', 'purchase', NULL, '1217428934.34', '83a78b80fd6d.jpg', 11, 0, 'other', '2023-05-03 18:40:58', 0),
('88853cb6d70d', 'Rigid 2A Impact', 'Pretty much runs like new, I\'ll throw in the socket for an extra 5', 'purchase', NULL, '129.99', '88853cb6d70d.png', 14, 0, 'tools', '2023-05-16 05:48:08', 0),
('ad6317225be7', 'wheels', 'Set of wheels, I don\'t know what car they\'re for nor do I care, enjoy!', 'purchase', NULL, '3000.00', 'ad6317225be7.jpg', 14, 0, 'automotive', '2023-05-16 05:29:19', 0),
('b8ff111364d8', 'freshly built PC', 'I\'m not sure what\'s in here my friend gifted it to me', 'bidding', '1990.00', NULL, 'b8ff111364d8.jpg', 14, 0, 'electronics', '2023-05-16 06:00:00', 0),
('bd801957f418', 'purchase for free!', 'This is free so you should probably just buy it at no extra charge besides shipping...', 'purchase', NULL, '0.00', 'default.png', 11, 1, 'other', '2023-05-03 06:36:56', 0),
('bde00d833c56', 'RTX 4090 GPU', 'Selling my old GPU', 'purchase', NULL, '1699.00', 'bde00d833c56.jpg', 14, 0, 'electronics', '2023-05-16 05:58:33', 0),
('c1aafdc7f251', 'Cupcake', 'My friend just had a litter of dogs, this one is named Cupcake, super friendly!', 'purchase', NULL, '850.00', 'c1aafdc7f251.jpg', 14, 0, 'other', '2023-05-16 06:03:17', 0),
('c743027e0c80', 'set of fine china', 'Passed down 52 generations from my grandma, these ain\'t cheap!!!', 'purchase', NULL, '5000.00', 'c743027e0c80.jpg', 14, 0, 'homedecor', '2023-05-16 05:34:23', 0),
('da19b88ff2ec', 'Gaming PC', 'i5 3200k and GTX 580, pretty good deal NO HAGGLING', 'purchase', NULL, '5300.00', 'da19b88ff2ec.jpg', 14, 0, 'electronics', '2023-05-16 05:53:53', 0),
('dd35d0811e3b', 'Advance Auto Parts', 'Yup, I\'m selling the whole store, I gotta talk to the owner after you buy it but I\'m sure he\'ll be okay with it', 'purchase', NULL, '980000.00', 'dd35d0811e3b.jpg', 14, 0, 'tools', '2023-05-16 05:52:13', 0),
('de7b21d7d91f', 'Craftsman Full Toolbox', 'Includes every socket ever made in the history of mankind', 'bidding', '8000.00', NULL, 'de7b21d7d91f.jpg', 14, 0, 'tools', '2023-05-16 05:45:03', 0),
('de917efbe248', 'Torque Wrench', 'I\'ve cracked a kajillion lugnuts with this, I don\'t think it\'ll ever break', 'purchase', NULL, '359.99', 'de917efbe248.jpg', 14, 0, 'tools', '2023-05-16 05:50:40', 0),
('f802102fbf8c', 'calipers for honda civic 09', 'Set of calipers that didn\'t fit right, bid whatever you want, buyout at 2k', 'bidding', '2000.00', NULL, 'f802102fbf8c.jpg', 14, 0, 'automotive', '2023-05-16 05:31:20', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`guid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
