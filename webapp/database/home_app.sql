-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 30, 2021 at 01:24 PM
-- Server version: 10.6.4-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `home_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `commands`
--

CREATE TABLE `commands` (
  `id` int(11) NOT NULL,
  `command` text NOT NULL,
  `executed` tinyint(1) NOT NULL DEFAULT 0,
  `inserted` timestamp NOT NULL DEFAULT current_timestamp(),
  `execution_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `global_settings`
--

CREATE TABLE `global_settings` (
  `name` varchar(32) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `global_settings`
--

INSERT INTO `global_settings` (`name`, `value`) VALUES
('global_state', '1'),
('min_diff_threshold', '0.5'),
('state_manual', '{\"state\":\"0\",\"duration\":\"\",\"end\":\"\"}');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `thermostat_status` tinyint(1) NOT NULL DEFAULT 0,
  `manual_state` text NOT NULL,
  `home_order` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `thermostat_status`, `manual_state`, `home_order`) VALUES
(1, 'Camera TN', 0, '{\"state\":0,\"temp\":false,\"duration\":\"\",\"end\":\"\"}', 0),
(2, 'Camera DM', 0, '{\"state\":\"0\",\"temp\":\"20\",\"duration\":\"2\",\"end\":\"2021-10-10 18:00:43\"}', 0),
(3, 'Bagno V', 0, '{\"state\":\"0\",\"temp\":null,\"duration\":\"\",\"end\":\"\"}', 0),
(4, 'Camera M', 0, '{\"state\":\"0\",\"temp\":null,\"duration\":\"\",\"end\":\"\"}', 0),
(5, 'Bagno N', 0, '{\"state\":\"0\",\"temp\":null,\"duration\":\"\",\"end\":\"\"}', 0),
(6, 'Soggiorno', 0, '{\"state\":\"0\",\"temp\":null,\"duration\":\"\",\"end\":\"\"}', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rooms_scheduling`
--

CREATE TABLE `rooms_scheduling` (
  `id` int(11) NOT NULL,
  `rooms` varchar(64) NOT NULL,
  `days` varchar(32) NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `temp` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `rooms_settings`
--

CREATE TABLE `rooms_settings` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `temp_threshold` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `rooms_settings`
--

INSERT INTO `rooms_settings` (`id`, `room_id`, `temp_threshold`) VALUES
(1, 1, '{\"min\":\"15\",\"max\":\"19.5\"}'),
(2, 2, '{\"min\":\"19.7\",\"max\":\"21\"}'),
(3, 3, '{\"min\":false,\"max\":false}'),
(4, 4, '{\"min\":false,\"max\":false}'),
(5, 5, '{\"min\":false,\"max\":false}'),
(6, 6, '{\"min\":false,\"max\":false}');

-- --------------------------------------------------------

--
-- Table structure for table `rooms_temperature`
--

CREATE TABLE `rooms_temperature` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `temp` float(10,1) NOT NULL,
  `humidity` float(10,1) NOT NULL,
  `heat_index` float(10,1) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `rooms_temperature`
--

INSERT INTO `rooms_temperature` (`id`, `room_id`, `temp`, `humidity`, `heat_index`, `time`) VALUES
(1, 1, 19.2, 63.3, 18.8, '2021-04-27 14:43:51'),
(2, 2, 19.2, 63.3, 18.8, '2021-04-27 14:43:51'),
(3, 3, 19.2, 63.3, 18.8, '2021-04-27 14:43:51'),
(4, 4, 19.2, 63.3, 18.8, '2021-04-27 14:43:51'),
(5, 5, 19.2, 63.3, 18.8, '2021-04-27 14:43:51'),
(6, 6, 19.2, 63.3, 18.8, '2021-04-27 14:43:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commands`
--
ALTER TABLE `commands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applied` (`executed`);

--
-- Indexes for table `global_settings`
--
ALTER TABLE `global_settings`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms_scheduling`
--
ALTER TABLE `rooms_scheduling`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms` (`rooms`),
  ADD KEY `days` (`days`);

--
-- Indexes for table `rooms_settings`
--
ALTER TABLE `rooms_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `rooms_temperature`
--
ALTER TABLE `rooms_temperature`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commands`
--
ALTER TABLE `commands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rooms_scheduling`
--
ALTER TABLE `rooms_scheduling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rooms_settings`
--
ALTER TABLE `rooms_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rooms_temperature`
--
ALTER TABLE `rooms_temperature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rooms_settings`
--
ALTER TABLE `rooms_settings`
  ADD CONSTRAINT `rooms_settings_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rooms_temperature`
--
ALTER TABLE `rooms_temperature`
  ADD CONSTRAINT `rooms_temperature_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
