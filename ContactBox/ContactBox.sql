-- phpMyAdmin SQL Dump
-- version 4.6.5.1deb3+deb.cihar.com~xenial.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 04, 2016 at 08:54 PM
-- Server version: 5.7.16-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ContactBox`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `house_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apartment_number` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `address_type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `city`, `street`, `house_number`, `apartment_number`, `person_id`, `address_type_id`) VALUES
(1, 'Ząb', 'Zębowa', '3', '-', 16, 1),
(2, 'Zakopane', 'Krakowska', '130', '-', 16, 2),
(3, 'Zakopane', 'Krupówki', '1', '-', 16, 3);

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `email_type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id`, `email`, `person_id`, `email_type_id`) VALUES
(1, 'kamil.stoch@gmail.com', 16, 1),
(2, 'kamil.stoch@skoczek.pl', 16, 2),
(3, 'kamil@stoch.com', 16, 3),
(10, 'dhghzfgh', 22, 1);

-- --------------------------------------------------------

--
-- Table structure for table `info_type`
--

CREATE TABLE `info_type` (
  `id` int(11) NOT NULL,
  `name` varchar(12) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `info_type`
--

INSERT INTO `info_type` (`id`, `name`) VALUES
(1, 'dom'),
(3, 'inne'),
(2, 'praca');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `first_name`, `last_name`, `description`) VALUES
(16, 'Kamil', 'Stoch', 'skoczek narciarski'),
(22, 'u', 'u', 'u');

-- --------------------------------------------------------

--
-- Table structure for table `persons_groups`
--

CREATE TABLE `persons_groups` (
  `person_id` int(11) NOT NULL,
  `person_group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `persons_groups`
--

INSERT INTO `persons_groups` (`person_id`, `person_group_id`) VALUES
(16, 1),
(22, 1),
(22, 5);

-- --------------------------------------------------------

--
-- Table structure for table `person_group`
--

CREATE TABLE `person_group` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `person_group`
--

INSERT INTO `person_group` (`id`, `group_name`) VALUES
(1, 'abcdef'),
(5, 'xyz XYZ');

-- --------------------------------------------------------

--
-- Table structure for table `phone`
--

CREATE TABLE `phone` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `phone_type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `phone`
--

INSERT INTO `phone` (`id`, `phone_number`, `person_id`, `phone_type_id`) VALUES
(1, '+48 662 206 385', 16, 1),
(2, '+48 123 456 789', 16, 3),
(3, '+48 999 999 999', 16, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D4E6F81217BBB47` (`person_id`),
  ADD KEY `IDX_D4E6F819EA97B0B` (`address_type_id`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E7927C74217BBB47` (`person_id`),
  ADD KEY `IDX_E7927C74788CE45C` (`email_type_id`);

--
-- Indexes for table `info_type`
--
ALTER TABLE `info_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D5B585A75E237E06` (`name`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `persons_groups`
--
ALTER TABLE `persons_groups`
  ADD PRIMARY KEY (`person_id`,`person_group_id`),
  ADD KEY `IDX_85191A63217BBB47` (`person_id`),
  ADD KEY `IDX_85191A636A127C70` (`person_group_id`);

--
-- Indexes for table `person_group`
--
ALTER TABLE `person_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone`
--
ALTER TABLE `phone`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_444F97DD217BBB47` (`person_id`),
  ADD KEY `IDX_444F97DD550E00A1` (`phone_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `info_type`
--
ALTER TABLE `info_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `person_group`
--
ALTER TABLE `person_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `phone`
--
ALTER TABLE `phone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_D4E6F81217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `FK_D4E6F819EA97B0B` FOREIGN KEY (`address_type_id`) REFERENCES `info_type` (`id`);

--
-- Constraints for table `email`
--
ALTER TABLE `email`
  ADD CONSTRAINT `FK_E7927C74217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `FK_E7927C74788CE45C` FOREIGN KEY (`email_type_id`) REFERENCES `info_type` (`id`);

--
-- Constraints for table `persons_groups`
--
ALTER TABLE `persons_groups`
  ADD CONSTRAINT `FK_85191A63217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_85191A636A127C70` FOREIGN KEY (`person_group_id`) REFERENCES `person_group` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `phone`
--
ALTER TABLE `phone`
  ADD CONSTRAINT `FK_444F97DD217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `FK_444F97DD550E00A1` FOREIGN KEY (`phone_type_id`) REFERENCES `info_type` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
