-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 10, 2016 at 10:14 AM
-- Server version: 5.7.12-0ubuntu1
-- PHP Version: 7.0.4-7ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `normal_forms`
--

-- --------------------------------------------------------

--
-- Table structure for table `industries`
--

CREATE TABLE `industries` (
  `id` int(50) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `industries`
--

INSERT INTO `industries` (`id`, `name`) VALUES
(1, 'Finance'),
(2, 'Food Service'),
(3, 'Information Technology'),
(4, 'Technology Management'),
(5, 'Marketing Communications'),
(6, 'Oil and Gas'),
(7, 'Food and Beverage'),
(8, 'High Voltage');

-- --------------------------------------------------------

--
-- Table structure for table `postal_codes`
--

CREATE TABLE `postal_codes` (
  `id` int(50) UNSIGNED NOT NULL,
  `code` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `postal_codes`
--

INSERT INTO `postal_codes` (`id`, `code`) VALUES
(1, 123),
(2, 21345),
(3, 45546),
(4, 45654),
(5, 4555),
(6, 45755),
(7, 45786),
(8, 78785);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(50) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`) VALUES
(1, 'Business Analyst'),
(2, 'Economic Development Intern'),
(3, 'Food Service Director'),
(4, 'IT Project Manager'),
(5, 'Assistant Manager'),
(6, 'Electrical Technician'),
(7, 'Engineer'),
(8, 'Bartender'),
(9, 'Mechanical Engineer');

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE `workers` (
  `id` int(100) UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `postal_code_id` int(50) NOT NULL,
  `industry_id` int(50) NOT NULL,
  `joining_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workers`
--

INSERT INTO `workers` (`id`, `firstname`, `lastname`, `email`, `postal_code_id`, `industry_id`, `joining_date`) VALUES
(1, 'Luis', 'Sanchez', 'lfsd86@gmail.com', 1, 1, '08/07/14'),
(2, 'Danny', 'Echols', 'echolsdaasny@gmail.com', 2, 2, '08/07/14'),
(3, 'Troy', 'Hamlet', 'trasaam@ymail.com', 3, 7, '08/11/14'),
(4, 'Kavon', 'Mckenzie', 'kavsdon@gmail.com', 4, 3, '08/11/14'),
(5, 'Saloni', 'Rawat', 'rawat.ssoni@gmail.com', 5, 4, '08/11/14'),
(6, 'Matshidiso', 'Letshwenyo', 'cryshwenysdo@yahoo.com', 5, 5, '08/12/14'),
(7, 'Themba', 'Pasi', 'themsdbapasi@gmail.com', 6, 8, '08/12/14'),
(8, 'Prabir', 'ADHIKARI', 'arawebir@gmail.com', 7, 6, '08/13/14'),
(9, 'Jorge', 'Aguilera', 'jorgeaslendo@yahoo.es', 8, 6, '08/13/14');

-- --------------------------------------------------------

--
-- Table structure for table `worker_skills`
--

CREATE TABLE `worker_skills` (
  `id` int(50) UNSIGNED NOT NULL,
  `worker_id` int(20) NOT NULL,
  `skill_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `worker_skills`
--

INSERT INTO `worker_skills` (`id`, `worker_id`, `skill_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 2, 3),
(5, 3, 3),
(6, 3, 8),
(7, 4, 4),
(8, 5, 5),
(9, 5, 1),
(10, 6, 4),
(11, 6, 5),
(12, 7, 2),
(13, 7, 6),
(14, 8, 6),
(15, 8, 9),
(16, 9, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `industries`
--
ALTER TABLE `industries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postal_codes`
--
ALTER TABLE `postal_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worker_skills`
--
ALTER TABLE `worker_skills`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `industries`
--
ALTER TABLE `industries`
  MODIFY `id` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `postal_codes`
--
ALTER TABLE `postal_codes`
  MODIFY `id` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `worker_skills`
--
ALTER TABLE `worker_skills`
  MODIFY `id` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
