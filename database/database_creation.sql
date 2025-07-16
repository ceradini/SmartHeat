-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 16, 2025 at 10:28 AM
-- Server version: 8.4.4
-- PHP Version: 8.0.30

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
  `id` int NOT NULL,
  `command` text NOT NULL,
  `executed` tinyint(1) NOT NULL DEFAULT '0',
  `inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `execution_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `global_settings`
--

CREATE TABLE `global_settings` (
  `name` varchar(32) NOT NULL,
  `value` text
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
  `id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `thermostat_status` tinyint(1) NOT NULL DEFAULT '0',
  `manual_state` text NOT NULL,
  `home_order` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `rule_id` int DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `thermostat_status`, `manual_state`, `home_order`, `rule_id`, `active`) VALUES
(1, 'Bedroom 1', 1, '{\"state\":1,\"temp\":\"22\",\"duration\":\"1\",\"end\":\"2025-07-10 20:52:36\",\"old_rule\":\"4\"}', 1, NULL, 1),
(2, 'Bedroom 2', 0, '{\"state\":0,\"temp\":\"null\",\"duration\":\"\",\"end\":\"\",\"old_rule\":\"5\"}', 4, 4, 1),
(3, 'Service bathroom', 0, '{\"state\":0,\"temp\":\"null\",\"duration\":\"\",\"end\":\"\",\"old_rule\":\"5\"}', 5, 4, 1),
(4, 'Bedroom 3', 0, '{\"state\":0,\"temp\":\"null\",\"duration\":\"\",\"end\":\"\",\"old_rule\":null}', 6, 4, 1),
(5, 'Bathroom', 0, '{\"state\":0,\"temp\":\"null\",\"duration\":\"\",\"end\":\"\",\"old_rule\":null}', 3, 4, 1),
(6, 'Living room', 0, '{\"state\":0,\"temp\":\"null\",\"duration\":\"\",\"end\":\"\",\"old_rule\":\"4\"}', 2, 4, 1),
(7, 'Guest room', 0, '{\"state\":0,\"temp\":false,\"duration\":\"\",\"end\":\"\",\"old_rule\":null}', 5, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rooms_scheduling`
--

CREATE TABLE `rooms_scheduling` (
  `id` int NOT NULL,
  `rooms` varchar(64) NOT NULL,
  `days` varchar(32) NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `temp` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `rooms_scheduling`
--

INSERT INTO `rooms_scheduling` (`id`, `rooms`, `days`, `start`, `end`, `temp`) VALUES
(6, '[\"1\",\"3\",\"4\",\"6\"]', '[\"1\",\"3\",\"5\",\"6\"]', '06:00:00', '08:00:00', 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `rooms_settings`
--

CREATE TABLE `rooms_settings` (
  `id` int NOT NULL,
  `room_id` int NOT NULL,
  `temp_threshold` text
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
  `id` int NOT NULL,
  `room_id` int NOT NULL,
  `temp` float(10,1) NOT NULL,
  `humidity` float(10,1) NOT NULL,
  `heat_index` float(10,1) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `rooms_temperature`
--

INSERT INTO `rooms_temperature` (`id`, `room_id`, `temp`, `humidity`, `heat_index`, `time`) VALUES
(1, 1, 15.0, 63.3, 10.0, '2021-04-27 14:43:51'),
(2, 2, 19.0, 63.3, 15.0, '2021-04-27 14:43:51'),
(3, 3, 18.0, 65.3, 18.0, '2021-04-27 14:43:51'),
(4, 4, 22.0, 63.3, 22.0, '2021-04-27 14:43:51'),
(5, 5, 17.5, 63.3, 18.8, '2021-04-27 14:43:51'),
(6, 6, 24.0, 63.3, 25.0, '2021-04-27 14:43:51'),
(7, 7, 26.0, 65.0, 27.0, '2023-09-20 20:20:19');

-- --------------------------------------------------------

--
-- Table structure for table `rooms_temp_offsets`
--

CREATE TABLE `rooms_temp_offsets` (
  `name` varchar(16) NOT NULL,
  `room_id` int NOT NULL,
  `temperature_offset` float NOT NULL DEFAULT '0',
  `humidity_offset` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `rooms_temp_offsets`
--

INSERT INTO `rooms_temp_offsets` (`name`, `room_id`, `temperature_offset`, `humidity_offset`) VALUES
('bagno', 5, 0.8, 0),
('bagno_servizio', 3, 0, 0),
('davide_matteo', 2, 0, 0),
('miriam', 4, 0, 0),
('nadia_tiziano', 1, 0, 0),
('soffitta', 7, 0, 0),
('soggiorno', 6, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `id` int NOT NULL,
  `name` varchar(64) NOT NULL,
  `temp_default` decimal(4,2) NOT NULL DEFAULT '10.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `name`, `temp_default`) VALUES
(4, 'Comfort', 17.50),
(5, 'Vacanze', 12.00);

-- --------------------------------------------------------

--
-- Table structure for table `rules_scheduling`
--

CREATE TABLE `rules_scheduling` (
  `id` int NOT NULL,
  `rule_id` int NOT NULL,
  `day` tinyint UNSIGNED NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `temp` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `rules_scheduling`
--

INSERT INTO `rules_scheduling` (`id`, `rule_id`, `day`, `start`, `end`, `temp`) VALUES
(50, 5, 3, '00:00:00', '23:59:00', 15.00),
(51, 5, 6, '00:00:00', '23:59:00', 21.50),
(52, 5, 7, '00:00:00', '23:59:00', 21.00),
(53, 4, 1, '00:00:00', '23:59:00', 18.00),
(54, 4, 4, '00:00:00', '23:59:00', 17.00),
(55, 4, 6, '00:00:00', '23:59:00', 20.00),
(56, 4, 7, '07:00:00', '08:30:00', 20.00),
(57, 4, 7, '17:00:00', '23:30:00', 20.50);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `rule_id` (`rule_id`);

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
-- Indexes for table `rooms_temp_offsets`
--
ALTER TABLE `rooms_temp_offsets`
  ADD PRIMARY KEY (`name`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rules_scheduling`
--
ALTER TABLE `rules_scheduling`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rule_id` (`rule_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commands`
--
ALTER TABLE `commands`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rooms_scheduling`
--
ALTER TABLE `rooms_scheduling`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rooms_settings`
--
ALTER TABLE `rooms_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rooms_temperature`
--
ALTER TABLE `rooms_temperature`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rules_scheduling`
--
ALTER TABLE `rules_scheduling`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`rule_id`) REFERENCES `rules` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

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

--
-- Constraints for table `rooms_temp_offsets`
--
ALTER TABLE `rooms_temp_offsets`
  ADD CONSTRAINT `rooms_temp_offsets_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rules_scheduling`
--
ALTER TABLE `rules_scheduling`
  ADD CONSTRAINT `rules_scheduling_ibfk_1` FOREIGN KEY (`rule_id`) REFERENCES `rules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
