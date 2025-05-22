-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 22, 2025 at 12:10 AM
-- Server version: 8.0.42-0ubuntu0.24.10.1
-- PHP Version: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catalyticgreat`
--
CREATE DATABASE IF NOT EXISTS `catalyticgreat` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `catalyticgreat`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_pid_if_not_exists` (IN `new_pid` INT)   BEGIN
  IF NOT EXISTS (SELECT 1 FROM pids WHERE pid = new_pid) THEN
    INSERT INTO pids (pid, field_name)
    VALUES (new_pid, CONCAT('pid_', new_pid))$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `remove_expired_pins` ()   BEGIN
  DELETE FROM `access_pins` WHERE `expires_at` < CURRENT_TIMESTAMP$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `access_pins`
--

CREATE TABLE `access_pins` (
  `access_pin_id` int NOT NULL,
  `user_id` int NOT NULL,
  `pin_code` varchar(6) NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pids`
--

CREATE TABLE `pids` (
  `pid` int NOT NULL,
  `field_name` varchar(100) NOT NULL,
  `units` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pids`
--

INSERT INTO `pids` (`pid`, `field_name`, `units`) VALUES
(57, 'Heated Cat / Nox Monitor test status', NULL),
(58, 'Evaporative system test status', NULL),
(59, 'Secondary air sys test status', NULL),
(60, 'A/C refrigerant test status', NULL),
(61, 'Fuel System 2 Status', NULL),
(62, 'Catalyst test status', NULL),
(63, 'Oxygen Sensor test status', NULL),
(64, 'Oxygen Sensor Heater test status', NULL),
(65, 'Long Term Fuel Trim (Bank 1)', '%'),
(66, 'EGR System test status', NULL),
(67, 'Barometric Pressure (absolute)', 'kPa'),
(68, 'ECU voltage', 'V'),
(69, 'Comm. Throttle Actuator Cntrl', '%'),
(70, 'Fuel type', NULL),
(71, 'Long term secondary oxygen sensor trim bank 3', '%'),
(72, 'Fuel Level Input', '%'),
(73, 'O2 Sensor 1 lambda', NULL),
(74, 'O2 Sensor 1 current', 'mA'),
(75, 'Warm-ups since ECU reset', NULL),
(76, 'Absolute Engine Load', '%'),
(77, 'Vehicle Speed', 'km/h'),
(78, 'Oxygen sensors present', NULL),
(79, 'Commanded Equivalence Ratio', '%'),
(80, 'Distance since ECU reset', 'km'),
(81, 'Time Since Engine Start', 'h'),
(82, 'Number of Fault Codes', NULL),
(83, 'O2 Sensor Voltage B1S2', 'mV'),
(84, 'Intake Manifold Pressure', 'kPa'),
(85, 'CAT Temperature B1S1', '°C'),
(86, 'Engine RPM', '/min'),
(87, 'Relative Throttle Position', '%'),
(88, 'MIL status', NULL),
(89, 'Component test status', NULL),
(90, 'Absolute Throttle Position', '%'),
(91, 'Ignition monitoring status', NULL),
(92, 'Intake Air Temperature', '°C'),
(93, 'Misfire status', NULL),
(94, 'Fuel system test status', NULL),
(95, 'Fuel System 1 Status', NULL),
(96, 'Ambient Air Temperature', '°C'),
(97, 'Calculated Load Value', '%'),
(98, 'Timing Advance (Cyl. #1)', '°'),
(99, 'OBD conforms to', NULL),
(100, 'Distance since MIL activated', 'km'),
(101, 'Long term secondary oxygen sensor trim bank 1', '%'),
(102, 'Absolute Throttle Position B', '%'),
(103, 'Coolant Temperature', '°C'),
(104, 'Commanded Evaporative Purge', '%'),
(105, 'Fuel Pressure (gauge)', 'kPa'),
(106, 'O2 Sensor fuel trim B1S2', '%'),
(107, 'Absolute Throttle Position E', '%'),
(108, 'Short Term Fuel Trim (Bank 1)', '%'),
(109, 'Absolute Throttle Position D', '%');

-- --------------------------------------------------------

--
-- Table structure for table `predictions`
--

CREATE TABLE `predictions` (
  `prediction_id` int NOT NULL,
  `batch_id` int NOT NULL,
  `binary_classification` enum('issue','no_issue','normal') NOT NULL,
  `trouble_code_category` int NOT NULL,
  `vehicle_hours` float NOT NULL,
  `remaining_lifetime_hours` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `predictions`
--

INSERT INTO `predictions` (`prediction_id`, `batch_id`, `binary_classification`, `trouble_code_category`, `vehicle_hours`, `remaining_lifetime_hours`, `created_at`, `updated_at`) VALUES
(4, 16, 'normal', 13, 19.3696, 43780.6, '2025-04-26 15:52:06', '2025-04-26 15:52:06'),
(5, 17, 'normal', 13, 19.3696, 43780.6, '2025-04-26 15:53:28', '2025-04-26 15:53:28'),
(6, 18, 'normal', 13, 19.3696, 43780.6, '2025-04-26 18:21:20', '2025-04-26 18:21:20'),
(7, 19, 'normal', 13, 16.0157, 43784, '2025-04-26 19:44:46', '2025-04-26 19:44:46'),
(8, 20, 'normal', 13, 16.003, 43784, '2025-04-26 19:44:51', '2025-04-26 19:44:51'),
(9, 21, 'normal', 13, 15.6266, 43784.4, '2025-04-26 19:46:33', '2025-04-26 19:46:33'),
(10, 22, 'normal', 13, 15.6266, 43784.4, '2025-04-26 19:46:41', '2025-04-26 19:46:41'),
(11, 23, 'normal', 13, 16.7273, 43783.3, '2025-04-26 19:46:56', '2025-04-26 19:46:56');

-- --------------------------------------------------------

--
-- Table structure for table `reading_batches`
--

CREATE TABLE `reading_batches` (
  `batch_id` int NOT NULL,
  `user_id` int NOT NULL,
  `vehicle_id` int NOT NULL,
  `recorded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reading_batches`
--

INSERT INTO `reading_batches` (`batch_id`, `user_id`, `vehicle_id`, `recorded_at`) VALUES
(4, 1, 6, '2025-04-24 02:37:09'),
(5, 1, 6, '2025-04-24 17:52:25'),
(6, 1, 6, '2025-04-24 17:53:24'),
(16, 1, 6, '2025-04-26 15:51:58'),
(17, 1, 6, '2025-04-26 15:53:28'),
(18, 1, 6, '2025-04-26 18:21:13'),
(19, 2, 13, '2025-04-26 19:44:38'),
(20, 2, 13, '2025-04-26 19:44:51'),
(21, 2, 13, '2025-04-26 19:46:33'),
(22, 2, 13, '2025-04-26 19:46:41'),
(23, 2, 13, '2025-04-26 19:46:56');

-- --------------------------------------------------------

--
-- Table structure for table `reading_values`
--

CREATE TABLE `reading_values` (
  `batch_id` int NOT NULL,
  `pid` int NOT NULL,
  `value` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reading_values`
--

INSERT INTO `reading_values` (`batch_id`, `pid`, `value`) VALUES
(4, 57, 0),
(4, 58, 256),
(4, 59, 0),
(4, 60, 0),
(4, 61, 0),
(4, 62, 256),
(4, 63, 256),
(4, 64, 256),
(4, 65, 6.25),
(4, 66, 256),
(4, 67, 97),
(4, 68, 14.724),
(4, 69, 2.35294),
(4, 70, 1),
(4, 71, 0),
(4, 72, 7.45098),
(4, 73, 0.99559),
(4, 74, -0.0273438),
(4, 75, 126),
(4, 76, 24.3137),
(4, 77, 0),
(4, 78, 3),
(4, 79, 99.9969),
(4, 80, 5805),
(4, 81, 0.265833),
(4, 82, 0),
(4, 83, 725),
(4, 84, 34),
(4, 85, 350.1),
(4, 86, 702),
(4, 87, 1.96078),
(4, 88, 0),
(4, 89, 1),
(4, 90, 12.1569),
(4, 91, 0),
(4, 92, 46),
(4, 93, 1),
(4, 94, 1),
(4, 95, 2),
(4, 96, 50),
(4, 97, 23.5294),
(4, 98, 1.5),
(4, 99, 3),
(4, 100, 0),
(4, 101, -0.392157),
(4, 102, 12.1569),
(4, 103, 103),
(4, 104, 43.1373),
(4, 105, 12930),
(4, 106, 99.2188),
(4, 107, 6.27451),
(4, 108, -0.78125),
(4, 109, 6.27451),
(5, 57, 0),
(5, 58, 256),
(5, 59, 0),
(5, 60, 0),
(5, 61, 0),
(5, 62, 256),
(5, 63, 256),
(5, 64, 256),
(5, 65, 6.25),
(5, 66, 256),
(5, 67, 97),
(5, 68, 14.724),
(5, 69, 2.35294),
(5, 70, 1),
(5, 71, 0),
(5, 72, 7.45098),
(5, 73, 0.99559),
(5, 74, -0.0273438),
(5, 75, 126),
(5, 76, 24.3137),
(5, 77, 0),
(5, 78, 3),
(5, 79, 99.9969),
(5, 80, 5805),
(5, 81, 0.265833),
(5, 82, 0),
(5, 83, 725),
(5, 84, 34),
(5, 85, 350.1),
(5, 86, 702),
(5, 87, 1.96078),
(5, 88, 0),
(5, 89, 1),
(5, 90, 12.1569),
(5, 91, 0),
(5, 92, 46),
(5, 93, 1),
(5, 94, 1),
(5, 95, 2),
(5, 96, 50),
(5, 97, 23.5294),
(5, 98, 1.5),
(5, 99, 3),
(5, 100, 0),
(5, 101, -0.392157),
(5, 102, 12.1569),
(5, 103, 103),
(5, 104, 43.1373),
(5, 105, 12930),
(5, 106, 99.2188),
(5, 107, 6.27451),
(5, 108, -0.78125),
(5, 109, 6.27451),
(6, 57, 0),
(6, 58, 256),
(6, 59, 0),
(6, 60, 0),
(6, 61, 0),
(6, 62, 256),
(6, 63, 256),
(6, 64, 256),
(6, 65, 6.25),
(6, 66, 256),
(6, 67, 97),
(6, 68, 14.724),
(6, 69, 2.35294),
(6, 70, 1),
(6, 71, 0),
(6, 72, 7.45098),
(6, 73, 0.99559),
(6, 74, -0.0273438),
(6, 75, 126),
(6, 76, 24.3137),
(6, 77, 0),
(6, 78, 3),
(6, 79, 99.9969),
(6, 80, 5805),
(6, 81, 0.265833),
(6, 82, 0),
(6, 83, 725),
(6, 84, 34),
(6, 85, 350.1),
(6, 86, 702),
(6, 87, 1.96078),
(6, 88, 0),
(6, 89, 1),
(6, 90, 12.1569),
(6, 91, 0),
(6, 92, 46),
(6, 93, 1),
(6, 94, 1),
(6, 95, 2),
(6, 96, 50),
(6, 97, 23.5294),
(6, 98, 1.5),
(6, 99, 3),
(6, 100, 0),
(6, 101, -0.392157),
(6, 102, 12.1569),
(6, 103, 103),
(6, 104, 43.1373),
(6, 105, 12930),
(6, 106, 99.2188),
(6, 107, 6.27451),
(6, 108, -0.78125),
(6, 109, 6.27451),
(16, 57, 0),
(16, 58, 256),
(16, 59, 0),
(16, 60, 0),
(16, 61, 0),
(16, 62, 256),
(16, 63, 256),
(16, 64, 256),
(16, 65, 6.25),
(16, 66, 256),
(16, 67, 97),
(16, 68, 14.724),
(16, 69, 2.35294),
(16, 70, 1),
(16, 71, 0),
(16, 72, 7.45098),
(16, 73, 0.99559),
(16, 74, -0.0273438),
(16, 75, 126),
(16, 76, 24.3137),
(16, 77, 0),
(16, 78, 3),
(16, 79, 99.9969),
(16, 80, 5805),
(16, 81, 0.265833),
(16, 82, 0),
(16, 83, 725),
(16, 84, 34),
(16, 85, 350.1),
(16, 86, 702),
(16, 87, 1.96078),
(16, 88, 0),
(16, 89, 1),
(16, 90, 12.1569),
(16, 91, 0),
(16, 92, 46),
(16, 93, 1),
(16, 94, 1),
(16, 95, 2),
(16, 96, 50),
(16, 97, 23.5294),
(16, 98, 1.5),
(16, 99, 3),
(16, 100, 0),
(16, 101, -0.392157),
(16, 102, 12.1569),
(16, 103, 103),
(16, 104, 43.1373),
(16, 105, 12930),
(16, 106, 99.2188),
(16, 107, 6.27451),
(16, 108, -0.78125),
(16, 109, 6.27451),
(17, 57, 0),
(17, 58, 256),
(17, 59, 0),
(17, 60, 0),
(17, 61, 0),
(17, 62, 256),
(17, 63, 256),
(17, 64, 256),
(17, 65, 6.25),
(17, 66, 256),
(17, 67, 97),
(17, 68, 14.724),
(17, 69, 2.35294),
(17, 70, 1),
(17, 71, 0),
(17, 72, 7.45098),
(17, 73, 0.99559),
(17, 74, -0.0273438),
(17, 75, 126),
(17, 76, 24.3137),
(17, 77, 0),
(17, 78, 3),
(17, 79, 99.9969),
(17, 80, 5805),
(17, 81, 0.265833),
(17, 82, 0),
(17, 83, 725),
(17, 84, 34),
(17, 85, 350.1),
(17, 86, 702),
(17, 87, 1.96078),
(17, 88, 0),
(17, 89, 1),
(17, 90, 12.1569),
(17, 91, 0),
(17, 92, 46),
(17, 93, 1),
(17, 94, 1),
(17, 95, 2),
(17, 96, 50),
(17, 97, 23.5294),
(17, 98, 1.5),
(17, 99, 3),
(17, 100, 0),
(17, 101, -0.392157),
(17, 102, 12.1569),
(17, 103, 103),
(17, 104, 43.1373),
(17, 105, 12930),
(17, 106, 99.2188),
(17, 107, 6.27451),
(17, 108, -0.78125),
(17, 109, 6.27451),
(18, 57, 0),
(18, 58, 256),
(18, 59, 0),
(18, 60, 0),
(18, 61, 0),
(18, 62, 256),
(18, 63, 256),
(18, 64, 256),
(18, 65, 6.25),
(18, 66, 256),
(18, 67, 97),
(18, 68, 14.724),
(18, 69, 2.35294),
(18, 70, 1),
(18, 71, 0),
(18, 72, 7.45098),
(18, 73, 0.99559),
(18, 74, -0.0273438),
(18, 75, 126),
(18, 76, 24.3137),
(18, 77, 0),
(18, 78, 3),
(18, 79, 99.9969),
(18, 80, 5805),
(18, 81, 0.265833),
(18, 82, 0),
(18, 83, 725),
(18, 84, 34),
(18, 85, 350.1),
(18, 86, 702),
(18, 87, 1.96078),
(18, 88, 0),
(18, 89, 1),
(18, 90, 12.1569),
(18, 91, 0),
(18, 92, 46),
(18, 93, 1),
(18, 94, 1),
(18, 95, 2),
(18, 96, 50),
(18, 97, 23.5294),
(18, 98, 1.5),
(18, 99, 3),
(18, 100, 0),
(18, 101, -0.392157),
(18, 102, 12.1569),
(18, 103, 103),
(18, 104, 43.1373),
(18, 105, 12930),
(18, 106, 99.2188),
(18, 107, 6.27451),
(18, 108, -0.78125),
(18, 109, 6.27451),
(19, 57, 0),
(19, 58, 256),
(19, 59, 0),
(19, 60, 0),
(19, 61, 0),
(19, 62, 256),
(19, 63, 256),
(19, 64, 256),
(19, 65, 3.125),
(19, 66, 256),
(19, 67, 96),
(19, 68, 14.913),
(19, 69, 3.13725),
(19, 70, 1),
(19, 71, 0),
(19, 72, 1.56863),
(19, 73, 0.993149),
(19, 74, -0.0351562),
(19, 75, 126),
(19, 76, 25.8824),
(19, 77, 0),
(19, 78, 3),
(19, 79, 99.9969),
(19, 80, 5811),
(19, 81, 0.0291667),
(19, 82, 0),
(19, 83, 1275),
(19, 84, 35),
(19, 85, 142.6),
(19, 86, 726.5),
(19, 87, 2.35294),
(19, 88, 0),
(19, 89, 1),
(19, 90, 12.9412),
(19, 91, 0),
(19, 92, 37),
(19, 93, 1),
(19, 94, 1),
(19, 95, 2),
(19, 96, 25),
(19, 97, 23.1373),
(19, 98, 1.5),
(19, 99, 3),
(19, 100, 0),
(19, 101, -0.392157),
(19, 102, 12.549),
(19, 103, 59),
(19, 104, 20),
(19, 105, 12920),
(19, 106, 99.2188),
(19, 107, 6.27451),
(19, 108, 1.5625),
(19, 109, 5.88235),
(20, 57, 0),
(20, 58, 256),
(20, 59, 0),
(20, 60, 0),
(20, 61, 0),
(20, 62, 256),
(20, 63, 256),
(20, 64, 256),
(20, 65, 3.125),
(20, 66, 256),
(20, 67, 96),
(20, 68, 14.913),
(20, 69, 3.13725),
(20, 70, 1),
(20, 71, 0),
(20, 72, 1.56863),
(20, 73, 0.993149),
(20, 74, -0.0351562),
(20, 75, 126),
(20, 76, 25.8824),
(20, 77, 0),
(20, 78, 3),
(20, 79, 99.9969),
(20, 80, 5811),
(20, 81, 0.0572222),
(20, 82, 0),
(20, 83, 1275),
(20, 84, 34),
(20, 85, 142.6),
(20, 86, 707),
(20, 87, 2.35294),
(20, 88, 0),
(20, 89, 1),
(20, 90, 12.549),
(20, 91, 0),
(20, 92, 41),
(20, 93, 1),
(20, 94, 1),
(20, 95, 2),
(20, 96, 25),
(20, 97, 24.3137),
(20, 98, 0),
(20, 99, 3),
(20, 100, 0),
(20, 101, -0.392157),
(20, 102, 12.549),
(20, 103, 67),
(20, 104, 20),
(20, 105, 12920),
(20, 106, 99.2188),
(20, 107, 6.27451),
(20, 108, -0.78125),
(20, 109, 5.88235),
(21, 57, 0),
(21, 58, 256),
(21, 59, 0),
(21, 60, 0),
(21, 61, 0),
(21, 62, 256),
(21, 63, 256),
(21, 64, 256),
(21, 65, -0.78125),
(21, 66, 256),
(21, 67, 96),
(21, 68, 14.983),
(21, 69, 98.8235),
(21, 70, 1),
(21, 71, 0),
(21, 72, 1.56863),
(21, 73, 1.40475),
(21, 74, 0.632812),
(21, 75, 126),
(21, 76, 32.9412),
(21, 77, 0),
(21, 78, 3),
(21, 79, 118.674),
(21, 80, 5811),
(21, 81, 0.0811111),
(21, 82, 0),
(21, 83, 1275),
(21, 84, 23),
(21, 85, 228),
(21, 86, 1187),
(21, 87, 1.96078),
(21, 88, 0),
(21, 89, 1),
(21, 90, 15.6863),
(21, 91, 0),
(21, 92, 44),
(21, 93, 1),
(21, 94, 1),
(21, 95, 4),
(21, 96, 31),
(21, 97, 8.62745),
(21, 98, 23),
(21, 99, 3),
(21, 100, 0),
(21, 101, 0),
(21, 102, 11.7647),
(21, 103, 71),
(21, 104, 0),
(21, 105, 13170),
(21, 106, 99.2188),
(21, 107, 30.9804),
(21, 108, 0),
(21, 109, 5.88235),
(22, 57, 0),
(22, 58, 256),
(22, 59, 0),
(22, 60, 0),
(22, 61, 0),
(22, 62, 256),
(22, 63, 256),
(22, 64, 256),
(22, 65, 5.46875),
(22, 66, 256),
(22, 67, 96),
(22, 68, 14.983),
(22, 69, 2.35294),
(22, 70, 1),
(22, 71, 0),
(22, 72, 1.56863),
(22, 73, 1.40475),
(22, 74, 0.632812),
(22, 75, 126),
(22, 76, 32.9412),
(22, 77, 0),
(22, 78, 3),
(22, 79, 118.674),
(22, 80, 5811),
(22, 81, 0.0858333),
(22, 82, 0),
(22, 83, 1275),
(22, 84, 27),
(22, 85, 247.8),
(22, 86, 1187),
(22, 87, 1.96078),
(22, 88, 0),
(22, 89, 1),
(22, 90, 15.6863),
(22, 91, 0),
(22, 92, 44),
(22, 93, 1),
(22, 94, 1),
(22, 95, 4),
(22, 96, 31),
(22, 97, 16.8627),
(22, 98, 23),
(22, 99, 3),
(22, 100, 0),
(22, 101, 0),
(22, 102, 11.7647),
(22, 103, 71),
(22, 104, 0),
(22, 105, 13170),
(22, 106, 99.2188),
(22, 107, 6.27451),
(22, 108, 5.46875),
(22, 109, 5.88235),
(23, 57, 0),
(23, 58, 256),
(23, 59, 0),
(23, 60, 0),
(23, 61, 0),
(23, 62, 256),
(23, 63, 256),
(23, 64, 256),
(23, 65, -0.78125),
(23, 66, 256),
(23, 67, 96),
(23, 68, 14.983),
(23, 69, 1.96078),
(23, 70, 1),
(23, 71, 0),
(23, 72, 1.56863),
(23, 73, 2),
(23, 74, 2.40625),
(23, 75, 126),
(23, 76, 13.7255),
(23, 77, 0),
(23, 78, 3),
(23, 79, 199.997),
(23, 80, 5811),
(23, 81, 0.0905556),
(23, 82, 0),
(23, 83, 1275),
(23, 84, 22),
(23, 85, 345.9),
(23, 86, 1133),
(23, 87, 1.96078),
(23, 88, 0),
(23, 89, 1),
(23, 90, 72.549),
(23, 91, 0),
(23, 92, 43),
(23, 93, 1),
(23, 94, 1),
(23, 95, 4),
(23, 96, 30),
(23, 97, 17.6471),
(23, 98, 7.5),
(23, 99, 3),
(23, 100, 0),
(23, 101, 0),
(23, 102, 11.7647),
(23, 103, 73),
(23, 104, 0),
(23, 105, 12970),
(23, 106, 99.2188),
(23, 107, 6.66667),
(23, 108, 3.90625),
(23, 109, 6.66667);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int NOT NULL,
  `role_name` enum('driver','mechanic','dvla','epa') NOT NULL,
  `permissions` json NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `role` enum('driver','mechanic','dvla','epa') NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `phone_number`, `role`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Elikem Gale-Zoyiku', 'egalezoyiku@gmail.com', '0507586382', 'driver', '$2y$10$RQ77eNjEG/SCVJ92NSxvlu1PxuzVaXlRQy/tVlB5o4sxzQ4osVC7i', '2025-04-18 19:24:08', '2025-04-18 19:24:08'),
(2, 'Pablo Mathias', 'pablo@gmail.com', '0507586382', 'driver', '$2y$10$QyNBRJIYZatHCHCV8XKWyu0h9k.PbMAQ58J41P9mSoDL34c/2Mt9m', '2025-04-19 10:12:11', '2025-04-19 10:12:11'),
(3, 'Test User', 'elikem.gale-zoyiku@ashesi.edu.gh', '0507586382', 'driver', '$2y$10$wjavxG7lNIfrSRtbgxxUQ.shYo3Kfb.e/elVfBSdDbcg6Q9R5.opG', '2025-04-21 17:16:56', '2025-04-21 17:16:56'),
(4, 'Kimberly Erickson', 'sazon@mailinator.com', '9621322901', 'epa', '$2y$10$XyVv2DcjCvdHhCPIg6f7UuQwfl81qKe31RZQVcxliXaJf10WDclsu', '2025-04-21 17:37:18', '2025-04-21 17:37:18'),
(5, 'Test DVLA', 'testdvla@gmail.com', '0552816008', 'mechanic', '$2y$10$.Gg2CbXUWUrMqkKsdy3SdO9IBy/YZFGsuwZL5DMSMpZun1c5WEWXq', '2025-04-22 23:06:22', '2025-04-22 23:06:22'),
(6, 'Pascal Mathias', 'pablo.gustav30@gmail.com', '0274567678', 'driver', '$2y$10$ZPN9lP7LW8bR.yqNHD1cz.hyie0tbRSar5BXBt3nVwKPXE33s/sY6', '2025-04-22 23:09:27', '2025-04-22 23:09:27'),
(7, 'Elikem DVLA', 'elikem.dvla@gmail.com', '0552816008', 'dvla', '$2y$10$AiRHPl70RcjfI1tmXiSfiOhirCjDLrgyHN/DCloFyAZuAsV3QQTsy', '2025-04-25 23:37:45', '2025-04-25 23:37:45');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int NOT NULL,
  `user_id` int NOT NULL,
  `vin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `user_id`, `vin`) VALUES
(9, 1, 'GR-224-24'),
(6, 1, 'testtrial123'),
(7, 2, 'GR224-19'),
(10, 2, 'GR235-23'),
(12, 2, 'GR7505-22'),
(13, 2, 'GR750522');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_pins`
--
ALTER TABLE `access_pins`
  ADD PRIMARY KEY (`access_pin_id`),
  ADD UNIQUE KEY `unique_active_pin` (`user_id`,`pin_code`);

--
-- Indexes for table `pids`
--
ALTER TABLE `pids`
  ADD PRIMARY KEY (`pid`),
  ADD UNIQUE KEY `field_name` (`field_name`);

--
-- Indexes for table `predictions`
--
ALTER TABLE `predictions`
  ADD PRIMARY KEY (`prediction_id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `reading_batches`
--
ALTER TABLE `reading_batches`
  ADD PRIMARY KEY (`batch_id`),
  ADD KEY `vehicle_id` (`vehicle_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `reading_values`
--
ALTER TABLE `reading_values`
  ADD PRIMARY KEY (`batch_id`,`pid`),
  ADD KEY `reading_values_ibfk_2` (`pid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `idx_role_name` (`role_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`vin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_pins`
--
ALTER TABLE `access_pins`
  MODIFY `access_pin_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pids`
--
ALTER TABLE `pids`
  MODIFY `pid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `predictions`
--
ALTER TABLE `predictions`
  MODIFY `prediction_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reading_batches`
--
ALTER TABLE `reading_batches`
  MODIFY `batch_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `access_pins`
--
ALTER TABLE `access_pins`
  ADD CONSTRAINT `access_pins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `predictions`
--
ALTER TABLE `predictions`
  ADD CONSTRAINT `predictions_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `reading_batches` (`batch_id`) ON DELETE CASCADE;

--
-- Constraints for table `reading_batches`
--
ALTER TABLE `reading_batches`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reading_batches_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`vehicle_id`) ON DELETE CASCADE;

--
-- Constraints for table `reading_values`
--
ALTER TABLE `reading_values`
  ADD CONSTRAINT `reading_values_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `reading_batches` (`batch_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reading_values_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `pids` (`pid`);

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `cleanup_expired_pins` ON SCHEDULE EVERY 1 DAY STARTS '2025-04-22 18:02:51' ON COMPLETION NOT PRESERVE ENABLE DO CALL `remove_expired_pins`()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
