-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2020 at 06:35 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `family_tree`
--

-- --------------------------------------------------------

--
-- Table structure for table `tree`
--

CREATE TABLE `tree` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `birth_date` datetime NOT NULL,
  `parent_id` int(11) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tree`
--

INSERT INTO `tree` (`id`, `name`, `birth_date`, `parent_id`, `type`) VALUES
(19, 'Hesham', '2020-02-01 00:00:00', 0, 1),
(20, 'Mohamed', '2020-02-02 00:00:00', 19, 2),
(21, 'Loay', '2020-02-03 00:00:00', 20, 3),
(22, 'Yomna', '2020-02-04 00:35:07', 19, 2),
(23, 'Retal', '2020-02-05 00:35:07', 22, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tree`
--
ALTER TABLE `tree`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tree`
--
ALTER TABLE `tree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
