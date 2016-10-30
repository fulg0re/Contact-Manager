-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 28, 2016 at 07:29 PM
-- Server version: 5.7.13-0ubuntu0.16.04.2
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `contact_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `home_phone` varchar(255) NOT NULL,
  `work_phone` varchar(255) NOT NULL,
  `cell_phone` varchar(255) NOT NULL,
  `best_phone` varchar(10) NOT NULL,
  `adress1` varchar(255) NOT NULL,
  `adress2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `birthday` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `firstname`, `lastname`, `email`, `home_phone`, `work_phone`, `cell_phone`, `best_phone`, `adress1`, `adress2`, `city`, `state`, `zip`, `country`, `birthday`) VALUES
(54, 'Pavlo', 'Denys', 'fulg0re.den@gmail.com', '289083', '288411', '+380673515035', 'cell_phone', 'Ternopil1', 'Ternopil2', 'Ternopil3', 'Ternopil4', '46016', 'Ukraine', '11-07-1989'),
(55, 'Mykola', 'Miha', 'myk.m@gmail.com', '283083', '281411', '+380674515035', 'cell_phone', 'Ternopil1', 'Ternopil2', 'Ternopil3', 'Ternopil4', '46014', 'Ukraine', '17-07-1989'),
(56, 'Oleh', 'Kolos', 'oleh.k@gmail.com', '383083', '581411', '+380974515035', 'cell_phone', 'Ternopil1', 'Ternopil2', 'Ternopil3', 'Ternopil4', '45014', 'Ukraine', '17-05-1989'),
(59, 'Oleh', 'Kolos', 'oleh.k@gmail.com', '383083', '581411', '+380974515035', 'cell_phone', 'Ternopil1', 'Ternopil2', 'Ternopil3', 'Ternopil4', '45014', 'Ukraine', '17-05-1989'),
(65, 'Den', 'Sorton', 'Daniel.Smith@gmail.com', '267586', '145689', '+380976584521', 'cell_phone', '', '', '', '', '', '', '1988-08-11'),
(66, 'Kurt', 'Richard', 'k.rich@gmail.com', '458692', '478521', '+380992458611', 'cell_phone', '', '', '', '', '', '', '1977-03-22'),
(67, 'Marchal', 'Leo', 'march.leo@gmail.com', '458125', '354689', '+380675896420', 'cell_phone', '', '', '', '', '', '', '1984-02-01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'qwe', '056eafe7cf52220de2df36845b8ed170c67e23e3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
