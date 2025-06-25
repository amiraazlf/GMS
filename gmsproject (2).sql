-- phpMyAdmin SQL Dump
-- version 5.2.2-dev+20241224.b76b7eef71
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 07:13 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gmsproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(225) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `phone`, `role`, `user_id`) VALUES
(4, 'gmsadmin', 'gmsadmin@gmail.com', '$2y$10$dKsLGD3QEjpMaRJEIvdU8eb6vnfZnpYYLW6FtkmE7rOey6zb1nf2y', '0899723612', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_description` text DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `number_of_chairs` int(11) DEFAULT NULL,
  `seating_arrangement` text DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `user_id`, `event_name`, `event_description`, `event_date`, `event_location`, `created_at`, `number_of_chairs`, `seating_arrangement`, `admin_id`) VALUES
(7, 2, 'Workshop', 'A hands-on educational session where participants actively engage in learning and practice skills.', '2024-12-29 00:00:00', 'Bandung', '2024-10-07 02:17:45', 10, '0', 4),
(9, 2, 'Seminar', 'An academic or professional session where a speaker or group discusses a particular subject, often with an audience Q&A.', '2024-12-03 00:00:00', 'Surabaya', '2024-10-07 02:20:21', 100, NULL, 4),
(11, 2, 'Summit', 'A high-level meeting of leaders or experts to discuss and make decisions on important issues.\r\n\r\n', '2024-12-04 00:00:00', 'Malang', '2024-10-07 02:53:50', 25, NULL, 4),
(12, 2, 'Networking Event', 'A casual or formal gathering designed to help participants meet and build professional relationships.', '2025-12-25 00:00:00', 'Jakarta', '2024-10-07 05:24:29', 46, NULL, 4),
(13, 2, 'Exhibition', 'A display event where artists, companies, or organizations showcase their products, services, or work to an audience.', '2024-12-09 00:00:00', 'Bandung', '2024-10-07 05:27:58', 300, NULL, 4),
(14, 2, 'Product Launch', 'An event designed to introduce a new product or service to the market, often with demonstrations and promotions.', '2024-12-12 00:00:00', 'Semarang', '2024-10-07 05:32:33', 33, 'sawf', 4),
(15, 2, 'Gala', 'A formal social event, often featuring dinner and entertainment, organized to celebrate an occasion or raise funds.', '2024-12-11 00:00:00', 'Jakarta', '2024-10-07 06:06:27', 100, 'front', 4),
(16, 2, 'Team Building', 'Activities or events aimed at improving teamwork, collaboration, and morale within a group or organization.', '2024-12-21 00:00:00', 'Bandung', '2024-10-07 07:52:31', 88, 'terserah', 4),
(17, 2, 'Workshop', 'A hands-on educational session where participants actively engage in learning and practice skills.', '2024-12-27 00:00:00', 'Semarang', '2024-10-08 16:24:23', 5, '0', 4),
(18, 2, 'Exhibition', 'A display event where artists, companies, or organizations showcase their products, services, or work to an audience.', '2024-12-12 00:00:00', 'Yogyakarta', '2024-10-14 02:30:00', 45, NULL, 4),
(19, 2, 'Gala', 'A formal social event, often featuring dinner and entertainment, organized to celebrate an occasion or raise funds.', '2024-12-14 00:00:00', 'Surabaya', '2024-10-14 03:00:02', 33, NULL, 4),
(51, 4, 'Team Building', 'Activities or events aimed at improving teamwork, collaboration, and morale within a group or organization.', '2024-12-10 00:00:00', 'Malang', '2024-12-29 05:43:49', 2, NULL, 4),
(60, 4, 'Workshop', 'ok', '2024-12-26 00:00:00', 'Malang', '2024-12-29 15:42:54', 2, NULL, 4),
(61, 4, 'Product Launch', 'ok', '2024-12-29 00:00:00', 'Surabaya', '2024-12-29 15:48:01', 2, NULL, 4),
(62, 4, 'Workshop', 'ok', '2024-12-29 00:00:00', 'Yogyakarta', '2024-12-29 15:50:56', 2, NULL, 4),
(64, 4, 'Product Launch', 'ok', '2024-12-19 00:00:00', 'Jakarta', '2024-12-29 16:02:19', 2, NULL, 4),
(65, 4, 'Workshop', 'ok', '2024-12-30 00:00:00', 'Malang', '2024-12-29 23:36:49', 2, NULL, 4),
(67, 4, 'Conference', 'ok', '2024-12-30 00:00:00', 'Bandung', '2024-12-29 23:40:39', 2, NULL, 4),
(77, 4, 'Conference', 'h', '2024-12-30 00:00:00', 'Jakarta', '2024-12-30 00:09:04', 2, NULL, 4),
(79, 4, 'Product Launch', 'birthday party', '2025-12-12 00:00:00', 'Bogor', '2024-12-30 00:10:58', 25, NULL, 4),
(81, 4, 'IT Workshop', 'IT Workshop for freshgraduate', '2025-02-05 00:00:00', 'Surabaya', '2025-01-02 14:46:18', 10, NULL, 4),
(82, 4, 'IT Workshop', 'IT Workshop for fresh graduate', '2025-02-05 00:00:00', 'Bogor', '2025-01-02 14:51:43', 15, NULL, 4),
(91, 2, 'SaJu\'s Wedding', 'Baek Sa-Eon & Hong Hee-Joo\'s Wedding Ceremony', '2025-01-21 17:00:00', 'Jakarta', '2025-01-02 16:17:22', 10, NULL, NULL),
(92, 2, 'SaJu\'s Wedding', 'Baek Sa-Eon & Hong Hee-Joo\'s Wedding Ceremony', '2025-01-28 12:00:00', 'Bogor', '2025-01-02 16:17:56', 10, NULL, NULL),
(93, 2, 'SaJu\'s Wedding', 'Baek Sa-Eon & Hong Hee-Joo\'s Wedding Ceremony', '2025-01-22 12:00:00', 'Bogor', '2025-01-02 16:18:52', 10, NULL, NULL),
(94, 2, 'Marketing Workshop', 'Marketing', '2025-01-20 12:00:00', 'Magetan', '2025-01-02 16:25:36', 5, NULL, NULL),
(95, 2, 'Marketing Workshop', 'Marketing', '2025-01-20 12:00:00', 'Magetan', '2025-01-02 16:27:12', 5, NULL, NULL),
(96, 2, 'Marketing Workshop', 'Marketing', '2025-01-22 12:00:00', 'Magetan', '2025-01-02 16:28:24', 5, NULL, NULL),
(97, 2, 'Annual Company Meeting', 'A gathering to discuss the company\'s annual performance and future goals.', '2025-01-14 12:00:00', 'Malang', '2025-01-02 16:50:52', 15, NULL, NULL),
(98, 2, 'Tech Innovation Summit', 'An event to showcase the latest advancements in technology and innovation.', '2025-02-14 12:00:00', 'Jakarta', '2025-01-02 16:54:13', 10, NULL, NULL),
(99, 3, 'IT Workshop', 'IT Workshop', '2025-01-30 12:00:00', 'Yogyakarta', '2025-01-02 17:15:40', 16, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `seat_numbers` text DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rsvp`
--

CREATE TABLE `rsvp` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `guest_name` varchar(255) DEFAULT NULL,
  `guest_email` varchar(255) DEFAULT NULL,
  `attendance` enum('yes','no') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rsvp`
--

INSERT INTO `rsvp` (`id`, `event_id`, `guest_name`, `guest_email`, `attendance`, `created_at`) VALUES
(1, NULL, NULL, NULL, NULL, '2024-10-08 15:14:36'),
(2, NULL, NULL, NULL, NULL, '2024-10-08 15:14:36'),
(3, NULL, NULL, NULL, NULL, '2024-10-08 15:14:36'),
(4, NULL, NULL, NULL, NULL, '2024-10-08 15:14:36'),
(5, NULL, NULL, NULL, NULL, '2024-10-08 15:14:36'),
(6, NULL, NULL, NULL, NULL, '2024-10-08 15:14:36'),
(7, NULL, NULL, NULL, NULL, '2024-10-08 15:14:36'),
(8, NULL, NULL, NULL, NULL, '2024-10-08 15:14:36'),
(9, NULL, NULL, NULL, NULL, '2024-10-08 15:14:36'),
(10, NULL, NULL, NULL, NULL, '2024-10-08 15:14:36'),
(11, NULL, NULL, NULL, NULL, '2024-10-08 15:14:36'),
(12, 9, 'sawkadna', 'ajd@gmail.com', 'no', '2024-10-08 15:14:36'),
(13, NULL, NULL, NULL, NULL, '2024-10-08 15:14:36'),
(14, 14, 'sawkadna', 'ajd@gmail.com', 'yes', '2024-10-08 15:14:36'),
(15, NULL, NULL, NULL, NULL, '2024-10-08 15:14:36'),
(16, 15, 'rifa', 'rifa@gmail.com', 'no', '2024-10-08 15:14:36'),
(17, 15, 'rifa', 'rifa@gmail.com', 'yes', '2024-10-08 15:14:36'),
(18, 15, 'rifa', 'rifa@gmail.com', 'yes', '2024-10-08 15:14:36'),
(19, 15, 'amira', 'amira@gmail.com', 'yes', '2024-10-08 15:14:36'),
(20, 16, 'amira', 'amira@gmail.com', 'yes', '2024-10-08 15:14:36'),
(21, 15, 'amiru', 'amiruru@gmail.com', 'yes', '2024-10-08 15:14:36'),
(22, 16, 'rifa', 'rifa@gmail.com', 'yes', '2024-10-08 15:14:36'),
(23, 16, 'amiru', 'amiruru@gmail.com', 'yes', '2024-10-08 15:14:36'),
(25, 15, 'riri', 'riri@gmail.com', 'yes', '2024-10-08 15:14:36'),
(26, 16, 'riri', 'riri@gmail.com', 'yes', '2024-10-08 15:14:36'),
(27, 7, 'amira', 'amiraazlf@gmail.com', 'yes', '2024-10-08 16:25:31'),
(28, 17, 'fifi', 'fifi@gmail.com', 'yes', '2024-10-09 08:16:44'),
(29, 17, 'rifa', 'rifa@gmail.com', 'yes', '2024-10-09 08:29:14'),
(30, 17, 'tira', 'tira@gmail.com', 'yes', '2024-10-09 08:43:17'),
(31, 17, 'tira', 'tira@gmail.com', 'yes', '2024-10-09 08:45:01'),
(32, 18, 'kevin', 'kevin@gmail.com', 'yes', '2024-10-14 02:35:21'),
(33, 19, 'Rifa', 'rifamarthak@gmail.com', 'yes', '2024-10-14 03:02:47'),
(34, 9, NULL, NULL, 'no', '2024-12-11 14:12:37'),
(35, 7, NULL, NULL, 'no', '2024-12-11 14:12:50'),
(36, 7, NULL, NULL, 'yes', '2024-12-11 14:13:02'),
(37, 7, NULL, NULL, 'yes', '2024-12-11 14:14:11'),
(38, 51, NULL, NULL, 'yes', '2024-12-29 05:50:46'),
(39, 51, NULL, NULL, 'no', '2024-12-29 05:50:54'),
(40, 11, NULL, NULL, 'yes', '2024-12-29 16:09:01'),
(41, 15, NULL, NULL, 'no', '2024-12-29 23:23:08'),
(44, 18, 'joshua', 'joshuahong@gmail.com', 'yes', '2025-01-02 13:52:15'),
(45, 17, NULL, NULL, 'yes', '2025-01-02 14:55:00'),
(46, 92, 'Park Do-Jae', 'dojaepark@gmail.com', 'yes', '2025-01-02 16:29:52'),
(47, 96, 'Joshua Hong', 'joshuahong@gmail.com', 'yes', '2025-01-02 16:55:22');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `seat_number` varchar(10) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `event_id`, `seat_number`, `is_available`) VALUES
(2, 15, 'A2', 1),
(3, 15, 'A3', 1),
(4, 15, 'A4', 1),
(5, 15, 'A5', 1),
(6, 15, 'B1', 1),
(7, 15, 'B2', 0),
(8, 15, 'B3', 1),
(10, 15, 'A7', 1),
(11, 15, 'A8', 1),
(12, 15, 'A9', 1),
(13, 15, 'A10', 1),
(14, 15, 'A11', 1),
(15, 15, 'A12', 1),
(16, 15, 'A13', 1),
(17, 15, 'A14', 1),
(18, 15, 'A15', 1),
(19, 15, 'A16', 1),
(20, 15, 'A17', 1),
(21, 15, 'A18', 1),
(22, 15, 'A19', 1),
(23, 15, 'A20', 1),
(24, 15, 'A21', 1),
(25, 15, 'A22', 1),
(26, 15, 'A23', 1),
(27, 15, 'A24', 1),
(28, 15, 'A25', 1),
(29, 15, 'A26', 1),
(30, 15, 'A27', 1),
(31, 15, 'A28', 1),
(32, 15, 'A29', 1),
(33, 15, 'A30', 1),
(34, 15, 'A31', 1),
(35, 15, 'A32', 1),
(36, 15, 'A33', 1),
(37, 15, 'A34', 1),
(38, 15, 'A35', 1),
(39, 15, 'A36', 1),
(40, 15, 'A37', 1),
(41, 15, 'A38', 1),
(42, 15, 'A39', 1),
(43, 15, 'A40', 1),
(44, 15, 'A41', 0),
(45, 15, 'A42', 0),
(46, 15, 'A43', 1),
(47, 15, 'A44', 1),
(48, 15, 'A45', 1),
(49, 15, 'A46', 1),
(50, 15, 'A47', 1),
(51, 15, 'A48', 1),
(52, 15, 'A49', 1),
(53, 15, 'A50', 1),
(54, 15, 'A51', 1),
(55, 15, 'A52', 1),
(56, 15, 'A53', 1),
(57, 15, 'A54', 1),
(58, 15, 'A55', 1),
(59, 15, 'A56', 1),
(60, 15, 'A57', 1),
(61, 15, 'A58', 1),
(62, 15, 'A59', 1),
(63, 15, 'A60', 1),
(64, 15, 'A61', 1),
(65, 15, 'A62', 1),
(66, 15, 'A63', 1),
(67, 15, 'A64', 1),
(68, 15, 'A65', 1),
(69, 15, 'A66', 1),
(70, 15, 'A67', 1),
(71, 15, 'A68', 1),
(72, 15, 'A69', 1),
(73, 15, 'A70', 1),
(74, 15, 'A71', 1),
(75, 15, 'A72', 1),
(76, 15, 'A73', 1),
(77, 15, 'A74', 1),
(78, 15, 'A75', 1),
(79, 15, 'A76', 1),
(80, 15, 'A77', 1),
(81, 15, 'A78', 1),
(82, 15, 'A79', 1),
(83, 15, 'A80', 1),
(84, 15, 'A81', 1),
(85, 15, 'A82', 1),
(86, 15, 'A83', 1),
(87, 15, 'A84', 1),
(88, 15, 'A85', 1),
(89, 15, 'A86', 1),
(90, 15, 'A87', 1),
(91, 15, 'A88', 1),
(92, 15, 'A89', 1),
(93, 15, 'A90', 1),
(94, 15, 'A91', 1),
(95, 15, 'A92', 1),
(96, 15, 'A93', 1),
(97, 15, 'A94', 1),
(98, 15, 'A95', 1),
(99, 15, 'A96', 1),
(100, 15, 'A97', 1),
(101, 15, 'A98', 1),
(102, 15, 'A99', 1),
(103, 15, 'A100', 1),
(104, 16, 'A1', 1),
(105, 16, 'A2', 1),
(106, 16, 'A3', 1),
(107, 16, 'A4', 1),
(108, 16, 'A5', 1),
(109, 16, 'A6', 1),
(110, 16, 'A7', 1),
(111, 16, 'A8', 1),
(112, 16, 'A9', 1),
(113, 16, 'A10', 1),
(114, 16, 'A11', 1),
(115, 16, 'A12', 1),
(116, 16, 'A13', 1),
(117, 16, 'A14', 1),
(118, 16, 'A15', 1),
(119, 16, 'A16', 1),
(120, 16, 'A17', 1),
(121, 16, 'A18', 1),
(122, 16, 'A19', 1),
(123, 16, 'A20', 1),
(124, 16, 'A21', 1),
(125, 16, 'A22', 1),
(126, 16, 'A23', 1),
(127, 16, 'A24', 1),
(128, 16, 'A25', 1),
(129, 16, 'A26', 1),
(130, 16, 'A27', 1),
(131, 16, 'A28', 1),
(132, 16, 'A29', 1),
(133, 16, 'A30', 1),
(134, 16, 'A31', 1),
(135, 16, 'A32', 1),
(136, 16, 'A33', 1),
(137, 16, 'A34', 1),
(138, 16, 'A35', 1),
(139, 16, 'A36', 1),
(140, 16, 'A37', 1),
(141, 16, 'A38', 1),
(142, 16, 'A39', 1),
(143, 16, 'A40', 1),
(144, 16, 'A41', 1),
(145, 16, 'A42', 1),
(146, 16, 'A43', 1),
(147, 16, 'A44', 1),
(148, 16, 'A45', 1),
(149, 16, 'A46', 1),
(150, 16, 'A47', 1),
(151, 16, 'A48', 1),
(152, 16, 'A49', 1),
(153, 16, 'A50', 1),
(154, 16, 'A51', 1),
(155, 16, 'A52', 1),
(156, 16, 'A53', 1),
(157, 16, 'A54', 1),
(158, 16, 'A55', 1),
(159, 16, 'A56', 1),
(160, 16, 'A57', 1),
(161, 16, 'A58', 1),
(162, 16, 'A59', 1),
(163, 16, 'A60', 0),
(164, 16, 'A61', 0),
(165, 16, 'A62', 0),
(166, 16, 'A63', 0),
(167, 16, 'A64', 1),
(168, 16, 'A65', 1),
(169, 16, 'A66', 1),
(170, 16, 'A67', 1),
(171, 16, 'A68', 1),
(172, 16, 'A69', 1),
(173, 16, 'A70', 1),
(174, 16, 'A71', 1),
(175, 16, 'A72', 1),
(176, 16, 'A73', 1),
(177, 16, 'A74', 1),
(178, 16, 'A75', 1),
(179, 16, 'A76', 0),
(180, 16, 'A77', 0),
(181, 16, 'A78', 1),
(182, 16, 'A79', 1),
(183, 16, 'A80', 1),
(184, 16, 'A81', 1),
(185, 16, 'A82', 1),
(186, 16, 'A83', 1),
(187, 16, 'A84', 1),
(188, 16, 'A85', 1),
(189, 16, 'A86', 1),
(190, 16, 'A87', 1),
(191, 16, 'A88', 1),
(192, 17, 'A1', 1),
(193, 17, 'A2', 1),
(194, 17, 'A3', 1),
(195, 17, 'A4', 1),
(196, 17, 'A5', 1),
(197, 17, 'A6', 1),
(198, 17, 'A7', 1),
(199, 17, 'A8', 1),
(200, 17, 'A9', 1),
(201, 17, 'A10', 1),
(202, 17, 'A11', 1),
(203, 17, 'A12', 1),
(204, 17, 'A13', 1),
(205, 17, 'A14', 1),
(206, 17, 'A15', 1),
(207, 17, 'A16', 1),
(208, 17, 'A17', 1),
(209, 17, 'A18', 1),
(210, 17, 'A19', 1),
(211, 17, 'A20', 0),
(212, 17, 'A21', 0),
(213, 17, 'A22', 1),
(214, 17, 'A23', 1),
(215, 17, 'A24', 1),
(216, 17, 'A25', 1),
(217, 17, 'A26', 1),
(218, 17, 'A27', 0),
(219, 17, 'A28', 1),
(220, 17, 'A29', 1),
(221, 17, 'A30', 1),
(222, 17, 'A31', 1),
(223, 17, 'A32', 1),
(224, 17, 'A33', 1),
(225, 17, 'A34', 1),
(226, 17, 'A35', 0),
(227, 17, 'A36', 1),
(228, 17, 'A37', 0),
(229, 17, 'A38', 0),
(230, 17, 'A39', 1),
(231, 17, 'A40', 1),
(232, 17, 'A41', 1),
(233, 17, 'A42', 1),
(234, 17, 'A43', 1),
(235, 17, 'A44', 1),
(236, 17, 'A45', 1),
(237, 17, 'A46', 1),
(238, 17, 'A47', 1),
(239, 17, 'A48', 1),
(240, 17, 'A49', 1),
(241, 17, 'A50', 1),
(242, 18, 'A1', 1),
(243, 18, 'A2', 1),
(244, 18, 'A3', 1),
(245, 18, 'A4', 1),
(246, 18, 'A5', 1),
(247, 18, 'A6', 1),
(248, 18, 'A7', 1),
(249, 18, 'A8', 1),
(250, 18, 'A9', 1),
(251, 18, 'A10', 0),
(252, 18, 'A11', 1),
(253, 18, 'A12', 1),
(254, 18, 'A13', 1),
(255, 18, 'A14', 1),
(256, 18, 'A15', 1),
(257, 18, 'A16', 1),
(258, 18, 'A17', 1),
(259, 18, 'A18', 1),
(260, 18, 'A19', 1),
(261, 18, 'A20', 0),
(262, 18, 'A21', 0),
(263, 18, 'A22', 1),
(264, 18, 'A23', 1),
(265, 18, 'A24', 1),
(266, 18, 'A25', 1),
(267, 18, 'A26', 1),
(268, 18, 'A27', 1),
(269, 18, 'A28', 1),
(270, 18, 'A29', 1),
(271, 18, 'A30', 1),
(272, 18, 'A31', 1),
(273, 18, 'A32', 1),
(274, 18, 'A33', 1),
(275, 18, 'A34', 1),
(276, 18, 'A35', 1),
(277, 18, 'A36', 1),
(278, 18, 'A37', 1),
(279, 18, 'A38', 1),
(280, 18, 'A39', 1),
(281, 18, 'A40', 1),
(282, 18, 'A41', 1),
(283, 18, 'A42', 1),
(284, 18, 'A43', 1),
(285, 18, 'A44', 1),
(286, 18, 'A45', 1),
(287, 19, 'A1', 1),
(288, 19, 'A2', 1),
(289, 19, 'A3', 1),
(290, 19, 'A4', 1),
(291, 19, 'A5', 1),
(292, 19, 'A6', 1),
(293, 19, 'A7', 1),
(294, 19, 'A8', 1),
(295, 19, 'A9', 1),
(296, 19, 'A10', 0),
(297, 19, 'A11', 0),
(298, 19, 'A12', 1),
(299, 19, 'A13', 1),
(300, 19, 'A14', 1),
(301, 19, 'A15', 1),
(302, 19, 'A16', 1),
(303, 19, 'A17', 1),
(304, 19, 'A18', 1),
(305, 19, 'A19', 1),
(306, 19, 'A20', 1),
(307, 19, 'A21', 1),
(308, 19, 'A22', 1),
(309, 19, 'A23', 1),
(310, 19, 'A24', 1),
(311, 19, 'A25', 1),
(312, 19, 'A26', 1),
(313, 19, 'A27', 1),
(314, 19, 'A28', 1),
(315, 19, 'A29', 1),
(324, 14, 'A3', 1),
(325, 7, 'A3', 1),
(326, 19, 'A10', 0),
(327, 92, 'A1', 1),
(328, 92, 'A2', 1),
(329, 92, 'A3', 1),
(330, 92, 'A4', 0),
(331, 92, 'A5', 1),
(332, 92, 'A6', 1),
(333, 92, 'A7', 1),
(334, 92, 'A8', 1),
(335, 92, 'A9', 1),
(336, 92, 'A10', 1),
(337, 96, 'A1', 1),
(338, 96, 'A2', 1),
(339, 96, 'A3', 0),
(340, 96, 'A4', 1),
(341, 96, 'A5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(225) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `phone`) VALUES
(1, 'admin', 'admin@example.com', 'password123', ''),
(2, 'amira zulfa', 'amiraazlf@gmail.com', '$2y$10$BY3hA6SJVe4GzTJm6f07j.b6CgFjrLJDpFAsQdmc2cU9EuHICfune', '0852584285861'),
(3, 'rifa', 'rifa@gmail.com', '$2y$10$8fZdMO.jfUF/OMuBXNlhA.cN8nUk/n/tFprDHFBMkZg/k42jdyWiu', '08258428586'),
(4, 'gmsadmin', 'admin@example.com', '$2y$10$Q7Ci75d0Brbr5IaWnaS9H.chDEmjQgfwBG57bKAsHZXoFzUhKupLC', '1234567890'),
(5, 'kevin', 'kevinaqila5@gmail.com', '$2y$10$lb0ubDlnKOQQrYNgTMyNm.Svs/hi3BHyNXhvK6zxZ.871DFUeuVCC', '0812345678');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `admin_ibfk_1` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_admin_id` (`admin_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `rsvp`
--
ALTER TABLE `rsvp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rsvp`
--
ALTER TABLE `rsvp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=342;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_admin_id` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Constraints for table `rsvp`
--
ALTER TABLE `rsvp`
  ADD CONSTRAINT `rsvp_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
