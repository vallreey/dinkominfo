-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 29, 2022 at 10:36 AM
-- Server version: 5.7.38
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dinkomin_arsip`
--

-- --------------------------------------------------------

--
-- Table structure for table `odm_access_log`
--

CREATE TABLE `odm_access_log` (
  `file_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `action` enum('A','B','C','V','D','M','X','I','O','Y','R') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odm_access_log`
--

INSERT INTO `odm_access_log` (`file_id`, `user_id`, `timestamp`, `action`) VALUES
(1, 2, '2021-07-27 03:57:54', 'A'),
(1, 2, '2021-07-27 04:02:00', 'Y'),
(1, 1, '2021-08-12 01:53:51', 'V'),
(1, 1, '2021-08-12 01:53:52', 'V'),
(1, 1, '2021-08-12 01:53:53', 'V'),
(1, 1, '2021-08-12 01:53:53', 'V'),
(1, 1, '2021-08-12 01:53:53', 'V'),
(1, 1, '2021-10-07 00:49:02', 'V'),
(1, 1, '2021-10-07 00:49:03', 'V'),
(1, 1, '2021-10-07 00:49:03', 'V'),
(1, 3, '2021-10-07 01:00:18', 'V'),
(2, 2, '2021-10-07 03:09:36', 'A'),
(3, 2, '2021-10-07 03:10:44', 'A'),
(2, 2, '2021-10-07 03:11:57', 'Y'),
(3, 2, '2021-10-07 03:11:57', 'Y'),
(1, 2, '2021-10-07 03:13:31', 'V'),
(4, 2, '2021-10-07 07:19:52', 'A'),
(1, 1, '2021-10-08 01:46:37', 'V'),
(1, 1, '2021-10-08 01:46:49', 'V'),
(1, 1, '2021-10-08 01:46:49', 'V'),
(4, 2, '2021-10-12 01:54:05', 'Y'),
(2, 2, '2021-10-12 02:16:36', 'M'),
(5, 4, '2021-10-12 02:20:58', 'A'),
(5, 4, '2021-10-12 02:21:25', 'O'),
(5, 4, '2021-10-12 02:21:25', 'D'),
(5, 2, '2021-10-12 02:22:28', 'Y'),
(5, 2, '2021-10-12 02:23:04', 'V'),
(5, 2, '2021-10-12 02:23:33', 'V'),
(5, 4, '2021-10-12 02:25:53', 'I'),
(5, 4, '2021-10-12 02:26:47', 'Y'),
(6, 4, '2021-10-13 01:56:48', 'A'),
(6, 4, '2021-10-13 01:57:33', 'O'),
(6, 4, '2021-10-13 01:57:33', 'D'),
(6, 4, '2021-10-13 01:58:42', 'V'),
(6, 4, '2021-10-13 01:59:05', 'R'),
(6, 4, '2021-10-13 01:59:43', 'I'),
(6, 4, '2021-10-13 02:02:01', 'R'),
(6, 4, '2021-10-13 02:02:23', 'Y'),
(6, 4, '2021-10-13 02:02:28', 'V'),
(6, 4, '2021-10-13 02:02:42', 'X'),
(7, 4, '2021-10-13 02:54:22', 'A'),
(1, 4, '2021-10-13 08:52:52', 'V'),
(3, 4, '2021-10-13 08:53:35', 'V'),
(3, 4, '2021-10-13 08:53:47', 'D'),
(1, 1, '2021-10-14 01:02:07', 'V'),
(1, 1, '2021-10-14 01:02:21', 'V'),
(1, 1, '2021-10-14 01:02:21', 'V'),
(1, 1, '2021-10-14 01:02:21', 'V'),
(1, 1, '2021-10-14 01:02:21', 'V'),
(1, 1, '2021-10-14 01:02:21', 'V'),
(7, 2, '2021-10-14 01:06:09', 'Y'),
(1, 2, '2021-10-14 01:08:38', 'V'),
(1, 1, '2021-10-14 02:10:01', 'V'),
(1, 1, '2021-10-14 02:10:12', 'V'),
(1, 1, '2021-10-14 02:10:12', 'V'),
(1, 5, '2021-10-14 02:17:14', 'V'),
(1, 5, '2021-10-14 02:27:00', 'V'),
(1, 5, '2021-10-14 02:27:09', 'V'),
(1, 1, '2021-10-14 03:10:34', 'V'),
(1, 1, '2021-10-14 03:10:34', 'V'),
(1, 1, '2021-10-14 03:10:34', 'V'),
(1, 1, '2021-10-14 03:10:34', 'V'),
(1, 1, '2021-10-14 03:18:47', 'V'),
(1, 1, '2021-10-14 03:18:47', 'V'),
(1, 1, '2021-10-14 03:18:48', 'V'),
(1, 1, '2021-10-14 03:18:48', 'V'),
(1, 1, '2021-10-14 03:58:10', 'V'),
(1, 1, '2021-10-14 03:58:10', 'V'),
(1, 1, '2021-10-14 03:58:10', 'V'),
(3, 1, '2021-10-14 03:58:58', 'D'),
(3, 1, '2021-10-14 03:58:58', 'D'),
(3, 1, '2021-10-14 03:59:02', 'V'),
(3, 1, '2021-10-14 03:59:03', 'V'),
(1, 1, '2021-11-03 08:37:00', 'V'),
(1, 1, '2021-11-03 08:37:23', 'V'),
(1, 1, '2021-11-03 08:42:23', 'D'),
(1, 1, '2021-11-03 08:42:23', 'V'),
(8, 6, '2021-11-04 04:24:35', 'A'),
(8, 6, '2021-11-04 04:26:54', 'Y'),
(1, 8, '2021-11-04 04:28:54', 'D'),
(1, 1, '2021-11-04 07:31:08', 'V'),
(1, 1, '2021-11-04 07:31:08', 'V'),
(1, 1, '2021-11-04 07:31:09', 'V'),
(1, 1, '2021-11-04 07:31:09', 'V'),
(1, 1, '2021-11-04 07:31:09', 'V'),
(1, 1, '2021-11-04 07:31:27', 'V'),
(1, 1, '2021-11-04 07:31:27', 'V'),
(1, 1, '2021-11-04 07:31:28', 'V'),
(1, 1, '2021-11-04 07:36:28', 'V'),
(1, 1, '2021-11-04 07:36:28', 'V'),
(1, 2, '2021-11-09 01:10:03', 'V'),
(5, 2, '2021-11-09 01:10:39', 'V'),
(8, 2, '2021-11-09 01:11:46', 'V'),
(1, 2, '2021-11-09 01:15:11', 'V'),
(1, 2, '2021-11-09 01:15:20', 'V'),
(1, 1, '2021-11-10 01:43:59', 'V'),
(1, 1, '2021-11-10 01:44:00', 'V'),
(1, 1, '2021-11-10 01:44:00', 'V'),
(7, 1, '2021-11-10 01:44:07', 'V'),
(7, 1, '2021-11-10 01:44:07', 'V'),
(7, 1, '2021-11-10 01:44:07', 'V'),
(7, 1, '2021-11-10 01:44:08', 'V'),
(1, 1, '2021-11-10 01:44:24', 'V'),
(1, 1, '2021-11-10 01:44:24', 'V'),
(1, 1, '2021-11-10 01:44:24', 'V'),
(1, 1, '2021-11-10 01:44:24', 'V'),
(1, 1, '2021-11-10 01:46:54', 'D'),
(1, 1, '2021-11-10 01:46:54', 'D'),
(1, 1, '2021-11-10 01:49:04', 'V'),
(1, 1, '2021-11-10 01:49:04', 'V'),
(1, 1, '2021-11-10 01:49:05', 'V'),
(1, 1, '2021-11-10 01:49:05', 'V'),
(1, 1, '2021-11-10 01:49:05', 'V'),
(1, 1, '2021-11-10 02:03:20', 'V'),
(1, 1, '2021-11-10 02:06:45', 'V'),
(1, 1, '2021-11-10 02:06:45', 'V'),
(1, 1, '2021-11-10 02:07:02', 'V'),
(1, 1, '2021-11-10 02:07:02', 'V'),
(1, 1, '2021-11-10 02:07:02', 'V'),
(1, 1, '2021-11-10 02:07:03', 'V'),
(1, 1, '2021-11-10 02:07:03', 'V'),
(1, 1, '2021-11-10 02:07:03', 'V'),
(1, 1, '2021-11-10 02:07:04', 'V'),
(1, 1, '2021-11-10 02:07:04', 'V'),
(1, 1, '2021-11-10 02:07:04', 'V'),
(1, 1, '2021-11-10 02:07:04', 'V'),
(1, 1, '2021-11-10 02:07:04', 'V'),
(1, 1, '2021-11-10 02:07:05', 'V'),
(1, 1, '2021-11-10 02:07:28', 'V'),
(1, 1, '2021-11-10 02:07:28', 'V'),
(1, 1, '2021-11-10 02:08:23', 'V'),
(1, 1, '2021-11-10 02:08:23', 'V'),
(1, 1, '2021-11-10 02:08:23', 'V'),
(1, 1, '2021-11-10 02:08:35', 'V'),
(1, 1, '2021-11-10 02:09:25', 'V'),
(1, 1, '2021-11-10 02:09:58', 'V'),
(1, 1, '2021-11-10 02:14:30', 'V'),
(1, 1, '2021-11-10 02:23:33', 'V'),
(1, 1, '2021-11-10 02:23:48', 'V'),
(1, 1, '2021-11-10 02:28:48', 'V'),
(1, 1, '2021-11-11 01:26:18', 'V'),
(1, 1, '2021-11-11 01:26:47', 'D'),
(1, 1, '2021-11-11 06:35:40', 'V'),
(1, 2, '2021-11-12 01:09:56', 'V'),
(1, 2, '2021-11-12 01:10:16', 'V'),
(1, 2, '2021-11-12 01:10:35', 'V'),
(1, 1, '2021-11-12 01:31:12', 'D'),
(1, 2, '2021-11-12 01:31:35', 'V'),
(1, 2, '2021-11-12 01:31:53', 'V'),
(1, 1, '2021-11-12 01:32:02', 'V'),
(1, 1, '2021-11-12 01:32:32', 'V'),
(1, 1, '2021-11-12 01:32:37', 'D'),
(1, 1, '2021-11-12 01:32:51', 'V'),
(1, 1, '2021-11-12 01:33:37', 'V'),
(1, 1, '2021-11-12 01:33:43', 'V'),
(1, 1, '2021-11-12 01:33:46', 'D'),
(1, 1, '2021-11-12 01:35:48', 'V'),
(1, 1, '2021-11-12 01:36:08', 'V'),
(1, 1, '2021-11-12 01:36:35', 'V'),
(1, 2, '2021-11-12 01:38:16', 'V'),
(1, 1, '2021-11-12 01:38:54', 'V'),
(1, 1, '2021-11-12 01:40:50', 'V'),
(1, 1, '2021-11-12 01:41:14', 'D'),
(1, 1, '2021-11-12 01:41:44', 'V'),
(1, 1, '2021-11-12 01:41:52', 'V'),
(1, 1, '2021-11-12 01:42:18', 'V'),
(1, 1, '2021-11-12 01:42:23', 'D'),
(1, 1, '2021-11-12 01:42:26', 'V'),
(1, 1, '2021-11-12 01:43:56', 'V'),
(1, 1, '2021-11-12 01:44:07', 'V'),
(1, 1, '2021-11-12 01:44:48', 'V'),
(1, 1, '2021-11-12 02:11:13', 'V'),
(1, 1, '2021-11-12 02:11:33', 'V'),
(1, 1, '2021-11-12 02:11:52', 'V'),
(1, 1, '2021-11-12 02:12:25', 'V'),
(1, 1, '2021-11-12 02:12:32', 'V'),
(1, 1, '2021-11-12 02:18:04', 'D'),
(1, 1, '2021-11-12 02:28:24', 'V'),
(1, 1, '2021-11-12 02:28:28', 'V'),
(1, 1, '2021-11-12 02:32:08', 'V'),
(1, 1, '2021-11-12 02:32:19', 'V'),
(1, 1, '2021-11-12 02:35:27', 'D'),
(1, 1, '2021-11-12 02:39:46', 'V'),
(1, 2, '2021-11-15 02:39:59', 'V'),
(1, 2, '2021-11-15 02:40:16', 'V'),
(1, 1, '2021-11-15 02:43:38', 'V'),
(1, 1, '2021-11-15 02:43:50', 'V'),
(1, 1, '2021-11-15 02:43:50', 'V'),
(1, 1, '2021-11-15 02:44:04', 'V'),
(1, 1, '2021-11-15 02:44:16', 'V'),
(1, 1, '2021-11-15 02:44:16', 'V'),
(2, 1, '2021-11-15 02:44:37', 'V'),
(2, 1, '2021-11-15 02:44:37', 'V'),
(2, 1, '2021-11-15 02:44:37', 'V'),
(1, 1, '2021-11-15 02:44:42', 'V'),
(1, 1, '2021-11-15 02:44:53', 'V'),
(1, 1, '2021-11-15 02:44:53', 'V'),
(7, 1, '2021-11-15 02:45:12', 'V'),
(7, 1, '2021-11-15 02:45:13', 'V'),
(7, 1, '2021-11-15 02:45:13', 'V'),
(8, 1, '2021-11-15 02:45:16', 'V'),
(8, 1, '2021-11-15 02:45:27', 'V'),
(8, 1, '2021-11-15 02:45:27', 'V'),
(4, 1, '2021-11-15 02:46:07', 'V'),
(2, 1, '2021-11-15 02:46:13', 'V'),
(2, 1, '2021-11-15 02:46:13', 'V'),
(2, 1, '2021-11-15 02:46:13', 'V'),
(1, 1, '2021-11-15 02:46:23', 'V'),
(1, 1, '2021-11-15 02:46:34', 'V'),
(1, 1, '2021-11-15 02:46:34', 'V'),
(7, 1, '2021-11-15 02:47:16', 'V'),
(7, 1, '2021-11-15 02:47:16', 'V'),
(7, 1, '2021-11-15 02:47:17', 'V'),
(1, 1, '2021-11-15 02:50:47', 'V'),
(1, 1, '2021-11-15 02:50:58', 'V'),
(1, 1, '2021-11-15 02:50:58', 'V'),
(2, 1, '2021-11-15 02:52:56', 'V'),
(2, 1, '2021-11-15 02:52:56', 'V'),
(2, 1, '2021-11-15 02:52:56', 'V'),
(1, 2, '2021-11-15 02:54:01', 'V'),
(1, 2, '2021-11-15 02:54:14', 'V'),
(1, 1, '2021-11-15 02:56:20', 'V'),
(1, 1, '2021-11-15 02:56:31', 'V'),
(1, 1, '2021-11-15 02:56:31', 'V'),
(5, 2, '2021-11-30 01:08:36', 'V'),
(8, 2, '2021-11-30 07:12:57', 'V'),
(5, 2, '2021-12-08 08:28:21', 'V'),
(1, 2, '2021-12-16 00:54:04', 'V'),
(8, 1, '2021-12-22 04:24:55', 'V'),
(1, 1, '2021-12-22 04:25:11', 'D'),
(5, 1, '2021-12-22 04:25:21', 'V'),
(4, 1, '2021-12-22 04:25:28', 'V'),
(2, 1, '2021-12-22 04:25:31', 'V'),
(1, 1, '2021-12-22 13:49:28', 'V'),
(8, 1, '2021-12-22 13:50:13', 'V'),
(1, 1, '2021-12-28 01:06:13', 'V'),
(1, 1, '2021-12-28 01:06:14', 'V'),
(1, 1, '2021-12-28 01:06:19', 'V'),
(1, 1, '2021-12-28 01:06:20', 'V'),
(1, 1, '2021-12-28 01:06:26', 'V'),
(1, 1, '2021-12-28 01:06:26', 'V'),
(2, 1, '2021-12-28 01:06:30', 'V'),
(2, 1, '2021-12-28 01:06:30', 'V'),
(7, 1, '2021-12-28 01:06:34', 'V'),
(7, 1, '2021-12-28 01:06:34', 'V'),
(8, 1, '2021-12-28 01:06:41', 'V'),
(8, 1, '2021-12-28 01:06:41', 'V'),
(1, 1, '2021-12-28 01:07:03', 'V'),
(1, 1, '2021-12-28 01:07:04', 'V'),
(9, 1, '2022-03-17 01:33:00', 'A'),
(9, 1, '2022-03-17 01:33:44', 'O'),
(9, 1, '2022-03-17 01:33:44', 'D'),
(9, 1, '2022-03-17 01:53:35', 'R'),
(9, 1, '2022-03-17 01:55:04', 'Y'),
(9, 1, '2022-03-17 02:17:44', 'I'),
(9, 1, '2022-03-17 02:19:23', 'R'),
(10, 1, '2022-03-22 02:34:04', 'A'),
(10, 1, '2022-03-22 07:56:51', 'Y'),
(10, 1, '2022-03-22 07:59:12', 'V'),
(11, 1, '2022-03-22 08:00:19', 'A'),
(12, 1, '2022-04-23 05:29:17', 'A'),
(12, 1, '2022-04-23 05:32:32', 'V'),
(12, 1, '2022-04-23 05:32:57', 'Y'),
(10, 1, '2022-04-27 07:14:43', 'V'),
(13, 1, '2022-04-27 07:17:30', 'A'),
(12, 1, '2022-05-09 06:43:35', 'V'),
(12, 1, '2022-05-10 01:30:04', 'V'),
(10, 1, '2022-05-15 03:53:50', 'V'),
(14, 1, '2022-05-16 04:37:41', 'A'),
(15, 1, '2022-05-16 04:38:14', 'A'),
(16, 1, '2022-05-16 04:38:42', 'A'),
(17, 1, '2022-05-16 04:39:13', 'A'),
(18, 1, '2022-05-16 04:39:41', 'A'),
(19, 1, '2022-05-16 04:40:09', 'A'),
(20, 1, '2022-05-16 04:40:37', 'A'),
(21, 1, '2022-05-16 04:41:04', 'A'),
(22, 1, '2022-05-16 04:41:32', 'A'),
(23, 1, '2022-05-16 04:41:59', 'A'),
(15, 1, '2022-05-16 04:43:19', 'X'),
(22, 1, '2022-05-16 04:43:32', 'X'),
(23, 1, '2022-05-16 04:43:39', 'X'),
(21, 1, '2022-05-16 04:43:45', 'X'),
(20, 1, '2022-05-16 04:43:50', 'X'),
(19, 1, '2022-05-16 04:43:56', 'X'),
(18, 1, '2022-05-16 04:44:02', 'X'),
(17, 1, '2022-05-16 04:44:07', 'X'),
(16, 1, '2022-05-16 04:44:13', 'X'),
(14, 1, '2022-05-16 04:44:24', 'V'),
(14, 1, '2022-05-16 04:44:33', 'V'),
(14, 1, '2022-05-16 04:45:08', 'V');

-- --------------------------------------------------------

--
-- Table structure for table `odm_admin`
--

CREATE TABLE `odm_admin` (
  `id` int(11) UNSIGNED DEFAULT NULL,
  `admin` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odm_admin`
--

INSERT INTO `odm_admin` (`id`, `admin`) VALUES
(1, 1),
(2, 1),
(3, 0),
(4, 0),
(6, 0),
(7, 0),
(8, 0),
(9, 0),
(10, 0),
(11, 0),
(12, 0),
(13, 0),
(14, 0),
(15, 0),
(16, 0),
(17, 0),
(18, 0),
(19, 0),
(20, 0),
(21, 0),
(22, 0),
(23, 0),
(24, 0),
(25, 0),
(26, 0),
(27, 0),
(28, 0),
(29, 0),
(30, 0),
(31, 0),
(32, 0),
(33, 0),
(34, 0),
(35, 0),
(36, 0),
(37, 0),
(38, 0),
(39, 0);

-- --------------------------------------------------------

--
-- Table structure for table `odm_category`
--

CREATE TABLE `odm_category` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odm_category`
--

INSERT INTO `odm_category` (`id`, `name`) VALUES
(1, 'SOP'),
(2, 'Materi Rapat'),
(7, 'Peraturan Bupati'),
(4, 'Buku Manual'),
(5, 'Keputusan Bupati'),
(6, 'Keputusan Kepala Dinas'),
(8, 'Surat'),
(9, 'SKP'),
(10, 'RKA/DPA'),
(11, 'Kepegawaian'),
(12, 'Foto'),
(13, 'Standar Pelayanan'),
(14, 'Lainnya'),
(15, 'Keuangan'),
(16, 'Data');

-- --------------------------------------------------------

--
-- Table structure for table `odm_data`
--

CREATE TABLE `odm_data` (
  `id` int(11) UNSIGNED NOT NULL,
  `category` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `owner` int(11) UNSIGNED DEFAULT NULL,
  `realname` varchar(255) NOT NULL DEFAULT '',
  `created` datetime NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT '',
  `status` smallint(6) DEFAULT NULL,
  `department` smallint(6) UNSIGNED DEFAULT NULL,
  `default_rights` tinyint(4) DEFAULT NULL,
  `publishable` tinyint(4) DEFAULT NULL,
  `reviewer` int(11) UNSIGNED DEFAULT NULL,
  `reviewer_comments` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odm_data`
--

INSERT INTO `odm_data` (`id`, `category`, `owner`, `realname`, `created`, `description`, `comment`, `status`, `department`, `default_rights`, `publishable`, `reviewer`, `reviewer_comments`) VALUES
(1, 5, 2, 'Indikator 12-Perbup No 50 Th 2020 SPBE.pdf', '2021-07-27 10:57:54', '', '', 0, 3, 0, -1, 1, 'To=Pemilik;Subject=File Expired;Comments=Your file was rejected because you did not revise it for more than 90 Hari'),
(2, 4, 2, 'BOOKLET KOMPETENSI TEKNIS SDM SPBE.pdf', '2021-10-07 10:09:36', '', '', 0, 3, 0, -1, 1, 'To=Pemilik;Subject=File Expired;Comments=Your file was rejected because you did not revise it for more than 90 Hari'),
(3, 5, 2, 'BD 37 (PENILAIAN KINERJA).pdf', '2021-10-07 10:10:44', '', '', 0, 3, 0, -1, 1, 'To=Pemilik;Subject=File Expired;Comments=Your file was rejected because you did not revise it for more than 90 Hari'),
(4, 5, 2, '01raperbup_tusi setda_hasil rapat tim_ke hukum_hasil prov.pptx', '2021-10-07 14:19:52', '', '', 0, 3, 0, -1, 1, 'To=Pemilik;Subject=File Expired;Comments=Your file was rejected because you did not revise it for more than 90 Hari'),
(5, 2, 4, 'DESA CERDAS PURWAKARTA.pptx', '2021-10-12 09:20:58', '', '', 0, 2, 0, -1, 1, 'To=Pemilik;Subject=File Expired;Comments=Your file was rejected because you did not revise it for more than 90 Hari'),
(6, 16, 4, '0-6203821465_20210819_064740_0000.pdf', '2021-10-13 08:56:48', '', '', 0, 2, 0, -1, 1, 'To=Pemilik;Subject=File Expired;Comments=Your file was rejected because you did not revise it for more than 90 Hari'),
(7, 15, 4, 'CALK 2020.pdf', '2021-10-13 09:54:22', 'LAPORAN KEUANGAN DINKOMINFO TAHUN 2020', 'UNTUK PERIODE YANG BERAKHIR TANGGAL 31 DESEMBER 2020', 0, 2, 0, -1, 1, 'To=Pemilik;Subject=File Expired;Comments=Your file was rejected because you did not revise it for more than 90 Hari'),
(8, 13, 6, 'SP DATA CENTER.pdf', '2021-11-04 11:24:35', 'STANDAR PELAYANAN DATA CENTER DINKOMINFO', 'DISAHKAN TANGGAL 21 November 2021', 0, 2, 0, -1, 1, 'To=Pemilik;Subject=File Expired;Comments=Your file was rejected because you did not revise it for more than 90 Hari'),
(9, 4, 1, '01 SK Pelantikan HMPS Sistem Informasi 2021.pdf', '2022-03-17 08:33:00', 'nyoba disuruh mas aaf', 'bismillah', 0, 1, 0, -1, 1, 'To=Author(s);Subject=;Comments=;'),
(10, 16, 5, 'rules (1).docx', '2022-03-22 09:34:04', 'data nyoba', 'nyoba', 0, 3, 0, 1, 1, 'To= Author(s);Subject=;Comments=;'),
(11, 16, 1, 'rules (1) (1).docx', '2022-03-22 15:00:19', '', '', 0, 3, 0, 0, NULL, NULL),
(12, 16, 5, 'FORM_A02_FORMAT_PROPOSAL.doc', '2022-04-23 12:29:17', 'ok', 'ok', 0, 3, 0, 1, 1, 'To= Author(s);Subject=;Comments=;'),
(13, 4, 1, 'guntingan_radar_09 maret 2022.pdf', '2022-04-27 14:17:30', '', '', 0, 1, 0, 0, NULL, NULL),
(14, 4, 5, 'AdminLTE 3  DataTables (1).pdf', '2022-05-16 11:37:41', 'percobaan 1', 'percobaan 2', 0, 1, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `odm_department`
--

CREATE TABLE `odm_department` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odm_department`
--

INSERT INTO `odm_department` (`id`, `name`) VALUES
(1, 'Bidang Statistik dan Persandian'),
(2, 'Sekretariat'),
(3, 'Bidang Penyelenggaraan e-Government'),
(4, 'Bidang Pegelolaan Infokom');

-- --------------------------------------------------------

--
-- Table structure for table `odm_dept_perms`
--

CREATE TABLE `odm_dept_perms` (
  `fid` int(11) UNSIGNED DEFAULT NULL,
  `dept_id` int(11) UNSIGNED DEFAULT NULL,
  `rights` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odm_dept_perms`
--

INSERT INTO `odm_dept_perms` (`fid`, `dept_id`, `rights`) VALUES
(1, 4, 2),
(1, 3, 2),
(1, 1, 2),
(1, 2, 2),
(2, 2, -1),
(2, 1, -1),
(2, 3, 1),
(2, 4, -1),
(3, 4, 2),
(3, 3, 2),
(3, 1, 2),
(3, 2, 2),
(4, 4, 0),
(4, 3, 1),
(4, 1, 0),
(4, 2, 0),
(5, 4, 0),
(5, 3, 1),
(5, 1, 0),
(5, 2, 2),
(6, 4, -1),
(6, 3, 0),
(6, 1, 1),
(6, 2, 2),
(7, 4, -1),
(7, 3, 0),
(7, 1, 1),
(7, 2, 4),
(8, 4, -1),
(8, 3, 0),
(8, 1, 0),
(8, 2, 1),
(9, 4, 0),
(9, 3, 0),
(9, 1, 1),
(9, 4, 0),
(9, 2, 0),
(10, 4, 0),
(10, 3, 0),
(10, 1, 1),
(10, 4, 0),
(10, 2, 0),
(11, 4, 0),
(11, 3, 0),
(11, 1, 1),
(11, 4, 0),
(11, 2, 0),
(12, 4, 0),
(12, 3, 0),
(12, 1, 1),
(12, 2, 0),
(13, 4, -1),
(13, 3, -1),
(13, 1, -1),
(13, 2, -1),
(14, 4, 0),
(14, 3, 0),
(14, 1, 1),
(14, 2, 0),
(15, 4, 0),
(15, 3, 0),
(15, 1, 1),
(15, 2, 0),
(16, 4, 0),
(16, 3, 0),
(16, 1, 1),
(16, 2, 0),
(17, 4, 0),
(17, 3, 0),
(17, 1, 1),
(17, 2, 0),
(18, 4, 0),
(18, 3, 0),
(18, 1, 1),
(18, 2, 0),
(19, 4, 0),
(19, 3, 0),
(19, 1, 1),
(19, 2, 0),
(20, 4, 0),
(20, 3, 0),
(20, 1, 1),
(20, 2, 0),
(21, 4, 0),
(21, 3, 0),
(21, 1, 1),
(21, 2, 0),
(22, 4, 0),
(22, 3, 0),
(22, 1, 1),
(22, 2, 0),
(23, 4, 0),
(23, 3, 0),
(23, 1, 1),
(23, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `odm_dept_reviewer`
--

CREATE TABLE `odm_dept_reviewer` (
  `dept_id` int(11) UNSIGNED DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odm_dept_reviewer`
--

INSERT INTO `odm_dept_reviewer` (`dept_id`, `user_id`) VALUES
(1, 1),
(2, 2),
(1, 2),
(3, 2),
(4, 2),
(2, 3),
(1, 3),
(3, 3),
(4, 3),
(2, 4),
(2, 6),
(2, 7),
(3, 8),
(3, 9),
(1, 10),
(1, 11),
(4, 12),
(4, 13),
(4, 14),
(3, 14),
(1, 14),
(2, 14),
(1, 15),
(3, 16),
(2, 17),
(4, 18),
(2, 19),
(2, 20),
(2, 21),
(3, 22),
(4, 23),
(1, 24),
(1, 25),
(4, 26),
(1, 27),
(4, 28),
(3, 29),
(4, 30),
(2, 31),
(4, 32),
(3, 33),
(2, 34),
(1, 35),
(4, 36),
(2, 37),
(1, 38),
(2, 39),
(4, 40);

-- --------------------------------------------------------

--
-- Table structure for table `odm_filetypes`
--

CREATE TABLE `odm_filetypes` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odm_filetypes`
--

INSERT INTO `odm_filetypes` (`id`, `type`, `active`) VALUES
(1, 'image/gif', 1),
(2, 'text/html', 1),
(3, 'text/plain', 1),
(4, 'application/pdf', 1),
(5, 'image/pdf', 1),
(6, 'application/x-pdf', 1),
(7, 'application/msword', 1),
(8, 'image/jpeg', 1),
(9, 'image/pjpeg', 1),
(10, 'image/png', 1),
(11, 'application/msexcel', 1),
(12, 'application/msaccess', 1),
(13, 'text/richtxt', 1),
(14, 'application/mspowerpoint', 1),
(15, 'application/octet-stream', 1),
(16, 'application/x-zip-compressed', 1),
(17, 'application/x-zip', 1),
(18, 'application/zip', 1),
(19, 'image/tiff', 1),
(20, 'image/tif', 1),
(21, 'application/vnd.ms-powerpoint', 1),
(22, 'application/vnd.ms-excel', 1),
(23, 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 1),
(24, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 1),
(25, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 1),
(26, 'application/vnd.oasis.opendocument.chart', 1),
(27, 'application/vnd.oasis.opendocument.chart-template', 1),
(28, 'application/vnd.oasis.opendocument.formula', 1),
(29, 'application/vnd.oasis.opendocument.formula-template', 1),
(30, 'application/vnd.oasis.opendocument.graphics', 1),
(31, 'application/vnd.oasis.opendocument.graphics-template', 1),
(32, 'application/vnd.oasis.opendocument.image', 1),
(33, 'application/vnd.oasis.opendocument.image-template', 1),
(34, 'application/vnd.oasis.opendocument.presentation', 1),
(35, 'application/vnd.oasis.opendocument.presentation-template', 1),
(36, 'application/vnd.oasis.opendocument.spreadsheet', 1),
(37, 'application/vnd.oasis.opendocument.spreadsheet-template', 1),
(38, 'application/vnd.oasis.opendocument.text', 1),
(39, 'application/vnd.oasis.opendocument.text-master', 1),
(40, 'application/vnd.oasis.opendocument.text-template', 1),
(41, 'application/vnd.oasis.opendocument.text-web', 1),
(42, 'text/csv', 1),
(43, 'audio/mpeg', 0),
(44, 'image/x-dwg', 1),
(45, 'image/x-dfx', 1),
(46, 'drawing/x-dwf', 1),
(47, 'image/svg', 1),
(48, 'video/3gpp', 1),
(49, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `odm_log`
--

CREATE TABLE `odm_log` (
  `id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL,
  `modified_by` varchar(25) DEFAULT NULL,
  `note` text,
  `revision` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odm_log`
--

INSERT INTO `odm_log` (`id`, `modified_on`, `modified_by`, `note`, `revision`) VALUES
(1, '2021-07-27 10:57:54', 'Erni', 'Initial import', 'current'),
(2, '2021-10-07 10:09:36', 'Erni', 'Initial import', 'current'),
(3, '2021-10-07 10:10:44', 'Erni', 'Initial import', 'current'),
(4, '2021-10-07 14:19:52', 'Erni', 'Initial import', 'current'),
(5, '2021-10-12 09:20:58', 'sekdin', 'Initial import', '0'),
(5, '2021-10-12 09:25:53', 'sekdin', '123', 'current'),
(6, '2021-10-13 08:56:48', 'Sekdin', 'Initial import', '0'),
(6, '2021-10-13 08:59:43', 'Sekdin', '', 'current'),
(7, '2021-10-13 09:54:22', 'Sekdin', 'Initial import', 'current'),
(8, '2021-11-04 11:24:35', 'Keuangan', 'Initial import', 'current'),
(9, '2022-03-17 08:33:00', 'kominfo', 'Initial import', '0'),
(9, '2022-03-17 09:17:43', 'kominfo', '', 'current'),
(10, '2022-03-22 09:34:04', 'kominfo', 'Initial import', 'current'),
(11, '2022-03-22 15:00:19', 'kominfo', 'Initial import', 'current'),
(12, '2022-04-23 12:29:17', 'kominfo', 'Initial import', 'current'),
(13, '2022-04-27 14:17:30', 'kominfo', 'Initial import', 'current'),
(14, '2022-05-16 11:37:41', 'kominfo', 'Initial import', 'current'),
(15, '2022-05-16 11:38:14', 'kominfo', 'Initial import', 'current'),
(16, '2022-05-16 11:38:42', 'kominfo', 'Initial import', 'current'),
(17, '2022-05-16 11:39:13', 'kominfo', 'Initial import', 'current'),
(18, '2022-05-16 11:39:41', 'kominfo', 'Initial import', 'current'),
(19, '2022-05-16 11:40:09', 'kominfo', 'Initial import', 'current'),
(20, '2022-05-16 11:40:37', 'kominfo', 'Initial import', 'current'),
(21, '2022-05-16 11:41:04', 'kominfo', 'Initial import', 'current'),
(22, '2022-05-16 11:41:32', 'kominfo', 'Initial import', 'current'),
(23, '2022-05-16 11:41:59', 'kominfo', 'Initial import', 'current');

-- --------------------------------------------------------

--
-- Table structure for table `odm_odmsys`
--

CREATE TABLE `odm_odmsys` (
  `id` int(11) NOT NULL,
  `sys_name` varchar(16) DEFAULT NULL,
  `sys_value` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odm_odmsys`
--

INSERT INTO `odm_odmsys` (`id`, `sys_name`, `sys_value`) VALUES
(1, 'version', '1.4.0');

-- --------------------------------------------------------

--
-- Table structure for table `odm_rights`
--

CREATE TABLE `odm_rights` (
  `RightId` tinyint(4) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odm_rights`
--

INSERT INTO `odm_rights` (`RightId`, `Description`) VALUES
(0, 'none'),
(1, 'view'),
(-1, 'forbidden'),
(2, 'read'),
(3, 'write'),
(4, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `odm_settings`
--

CREATE TABLE `odm_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `validation` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odm_settings`
--

INSERT INTO `odm_settings` (`id`, `name`, `value`, `description`, `validation`) VALUES
(1, 'debug', 'False', '(True/False) - Default=False - Debug the installation (not working)', 'bool'),
(2, 'demo', 'False', '(True/False) This setting is for a demo installation, where random people will be all loggging in as the same username/password like \"demo/demo\". This will keep users from removing files, users, etc.', 'bool'),
(3, 'authen', 'mysql', '(Default = mysql) Currently only MySQL authentication is supported', ''),
(4, 'title', 'PRIMBON DINKOMINFO', 'This is the browser window title', 'maxsize=255'),
(5, 'site_mail', 'root@localhost', 'The email address of the administrator of this site', 'email|maxsize=255|req'),
(6, 'root_id', '1', 'This variable sets the root user id.  The root user will be able to access all files and have authority for everything.', 'num|req'),
(7, 'dataDir', '/home/dinkominfobjr/odm_data/', 'location of file repository. This should ideally be outside the Web server root. Make sure the server has permissions to read/write files to this folder!. (Examples: Linux - /var/www/document_repository/ : Windows - c:/document_repository/', 'maxsize=255'),
(8, 'max_filesize', '5000000', 'Set the maximum file upload size', 'num|maxsize=255'),
(9, 'revision_expiration', '90', 'This var sets the amount of days until each file needs to be revised,  assuming that there are 30 days in a month for all months.', 'num|maxsize=255'),
(10, 'file_expired_action', '1', 'Choose an action option when a file is found to be expired The first two options also result in sending email to reviewer  (1) Remove from file list until renewed (2) Show in file list but non-checkoutable (3) Send email to reviewer only (4) Do Nothing', 'num'),
(11, 'authorization', 'True', 'True or False. If set True, every document must be reviewed by an admin before it can go public. To disable set to False. If False, all newly added/checked-in documents will immediately be listed', 'bool'),
(12, 'allow_signup', 'True', 'Should we display the sign-up link?', 'bool'),
(13, 'allow_password_reset', 'True', 'Should we allow users to reset their forgotten password?', 'bool'),
(14, 'try_nis', 'False', 'Attempt NIS password lookups from YP server?', 'bool'),
(15, 'theme', 'tweeter', 'Which theme to use?', ''),
(16, 'language', 'english', 'Set the default language (english, spanish, turkish, etc.). Local users may override this setting. Check include/language folder for languages available', 'alpha|req'),
(17, 'max_query', '500', 'Set this to the maximum number of rows you want to be returned in a file listing. If your file list is slow decrease this value.', 'num');

-- --------------------------------------------------------

--
-- Table structure for table `odm_udf`
--

CREATE TABLE `odm_udf` (
  `id` int(11) NOT NULL,
  `table_name` varchar(50) DEFAULT NULL,
  `display_name` varchar(16) DEFAULT NULL,
  `field_type` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `odm_user`
--

CREATE TABLE `odm_user` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(25) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `department` int(11) UNSIGNED DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `pw_reset_code` char(32) DEFAULT NULL,
  `can_add` tinyint(1) DEFAULT '1',
  `can_checkin` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odm_user`
--

INSERT INTO `odm_user` (`id`, `username`, `password`, `department`, `phone`, `Email`, `last_name`, `first_name`, `pw_reset_code`, `can_add`, `can_checkin`) VALUES
(1, 'kominfo', '46a74849b92e843eebddc486ad600f0c', 1, '5555551212', 'admin@example.com', 'User', 'Admin', '', 1, 1),
(2, 'Erni', '01cfcd4f6b8770febfb40cb906715822', 3, '081391643137', 'ernianajr@gmail.com', 'Anjarningsih', 'Erni', NULL, 1, 1),
(3, 'Mitha', 'a234831a04b592976adb5e3f627d2aaa', 3, '0812345678', 'mita@gmail.com', 'Sasmitomukti', 'Akik', NULL, 1, 1),
(4, 'Sekdin', '46a74849b92e843eebddc486ad600f0c', 2, '', 'dinkominfo@banjarnegarakab.go.id', 'Dinkominfo', 'Sekretaris', NULL, 1, 1),
(5, 'aaff', 'e10adc3949ba59abbe56e057f20f883e', 3, '085290555050', 'aaf@banjarnegarakab.go.id', 'Afsyus', 'Salam', NULL, 1, 1),
(6, 'Keuangan', '46a74849b92e843eebddc486ad600f0c', 2, '', 'dinkominfo@banjarnegarakab.go.id', 'Keuangan', 'Kasubag', NULL, 1, 1),
(7, 'Kepegawaian', '46a74849b92e843eebddc486ad600f0c', 2, '', 'dinkominfo@banjarnegarakab.go.id', 'Kepegawaian', 'Kasubag', NULL, 1, 1),
(8, 'Aplikasi', '46a74849b92e843eebddc486ad600f0c', 3, '', 'dinkominfo@banjarnegarakab.go.id', 'Aplikasi', 'Kasie', NULL, 1, 1),
(9, 'Infrastruktur', '9465efb0b695070336f1400f8af40e54', 3, '', 'dinkominfo@banjarnegarakab.go.id', 'Infrastruktur', 'Kasi', NULL, 1, 1),
(10, 'Statistik', '46a74849b92e843eebddc486ad600f0c', 1, '', 'dinkominfo@banjarnegarakab.go.id', 'Statistik', 'Kasi', NULL, 1, 1),
(11, 'Persandian', '46a74849b92e843eebddc486ad600f0c', 1, '', 'dinkominfo@banjarnegarakab.go.id', 'Persandian', 'Kasi', NULL, 1, 1),
(12, 'Informasi', '46a74849b92e843eebddc486ad600f0c', 4, '', 'dinkominfo@banjarnegarakab.go.id', 'Informasi', 'Kasi', NULL, 1, 1),
(13, 'Komunikasi', '46a74849b92e843eebddc486ad600f0c', 4, '', 'dinkominfo@banjarnegarakab.go.id', 'Komunikasi', 'Kasi', NULL, 1, 1),
(14, 'Riono', '46a74849b92e843eebddc486ad600f0c', 2, '', 'repository@banjarnegarkab.go.id', 'Rahadi Prasetyo', 'Riono', NULL, 1, 1),
(15, 'Wiwik', '46a74849b92e843eebddc486ad600f0c', 1, '', 'repository@banjarnegarkab.go.id', 'Pratiwi', 'Wiwik', NULL, 1, 1),
(16, 'Heri', '46a74849b92e843eebddc486ad600f0c', 3, '', 'repository@banjarnegarkab.go.id', 'Setyobudi', 'Heri', NULL, 1, 1),
(17, 'Setya', '46a74849b92e843eebddc486ad600f0c', 2, '', 'repository@banjarnegarkab.go.id', 'Adi Prabawyuwana', 'Setya', NULL, 1, 1),
(18, 'Tutus', '46a74849b92e843eebddc486ad600f0c', 4, '', 'repository@banjarnegarkab.go.id', 'Liyanto', 'Tutus', NULL, 1, 1),
(19, 'Aris', '46a74849b92e843eebddc486ad600f0c', 2, '', 'repository@banjarnegarkab.go.id', 'Soesilowati', 'Aris', NULL, 1, 1),
(20, 'Hesty', '46a74849b92e843eebddc486ad600f0c', 2, '', 'repository@banjarnegarkab.go.id', 'Nilawati', 'Hesty', NULL, 1, 1),
(21, 'Nursolikhah', '46a74849b92e843eebddc486ad600f0c', 2, '', 'repository@banjarnegarkab.go.id', 'SE', 'Nursolikhah', NULL, 1, 1),
(22, 'Agus', '46a74849b92e843eebddc486ad600f0c', 3, '', 'repository@banjarnegarkab.go.id', 'Budiarto', 'Agus', NULL, 1, 1),
(23, 'Khadir', '46a74849b92e843eebddc486ad600f0c', 4, '', 'repository@banjarnegarkab.go.id', 'SH', 'Khadir', NULL, 1, 1),
(24, 'Achmad', '46a74849b92e843eebddc486ad600f0c', 1, '', 'repository@banjarnegarkab.go.id', 'Sugiarto', 'Achmad', NULL, 1, 1),
(25, 'Lestari', '46a74849b92e843eebddc486ad600f0c', 1, '', 'repository@banjarnegarkab.go.id', 'Puji Utami', 'Lestari', NULL, 1, 1),
(26, 'Arif', '46a74849b92e843eebddc486ad600f0c', 4, '', 'repository@banjarnegarkab.go.id', 'Widodo Al Aziz', 'Arif', NULL, 1, 1),
(27, 'Sutopo', '46a74849b92e843eebddc486ad600f0c', 1, '', 'repository@banjarnegarkab.go.id', 'Topo', 'Sutopo', NULL, 1, 1),
(28, 'Kasmun', '46a74849b92e843eebddc486ad600f0c', 4, '', 'repository@banjarnegarkab.go.id', 'S S T', 'Kasmun', NULL, 1, 1),
(29, 'Eko', '46a74849b92e843eebddc486ad600f0c', 3, '', 'repository@banjarnegarkab.go.id', 'Yuwono', 'Eko', NULL, 1, 1),
(30, 'Eny', '46a74849b92e843eebddc486ad600f0c', 4, '', 'repository@banjarnegarkab.go.id', 'Rodiyatun', 'Eny', NULL, 1, 1),
(31, 'Eny Yul', '46a74849b92e843eebddc486ad600f0c', 2, '', 'repository@banjarnegarkab.go.id', 'Yuliati', 'Eny', NULL, 1, 1),
(32, 'Muji', '46a74849b92e843eebddc486ad600f0c', 4, '', 'repository@banjarnegarkab.go.id', 'Prasetyo', 'Muji', NULL, 1, 1),
(33, 'Purwandi', '46a74849b92e843eebddc486ad600f0c', 3, '', 'repository@banjarnegarkab.go.id', 'Kominfo', 'Purwandi', NULL, 1, 1),
(34, 'Warno', '46a74849b92e843eebddc486ad600f0c', 2, '', 'repository@banjarnegarkab.go.id', 'Kominfo', 'Warno', NULL, 1, 1),
(35, 'Sudarno', '46a74849b92e843eebddc486ad600f0c', 1, '', 'repository@banjarnegarkab.go.id', 'Kominfo', 'Sudarno', NULL, 1, 1),
(36, 'Bagus', '46a74849b92e843eebddc486ad600f0c', 4, '', 'repository@banjarnegarkab.go.id', 'Subiantoro', 'Bagus', NULL, 1, 1),
(37, 'Sudin', '46a74849b92e843eebddc486ad600f0c', 2, '', 'repository@banjarnegarkab.go.id', 'A Md', 'Sudin', NULL, 1, 1),
(38, 'Nurnaningsih', '46a74849b92e843eebddc486ad600f0c', 1, '', 'repository@banjarnegarkab.go.id', 'Kominfo', 'Nurnaningsih', NULL, 1, 1),
(39, 'Mohammad', '46a74849b92e843eebddc486ad600f0c', 2, '', 'repository@banjarnegarkab.go.id', 'Nasrulloh', 'Mohammad', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `odm_user_perms`
--

CREATE TABLE `odm_user_perms` (
  `fid` int(11) UNSIGNED DEFAULT NULL,
  `uid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `rights` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odm_user_perms`
--

INSERT INTO `odm_user_perms` (`fid`, `uid`, `rights`) VALUES
(1, 2, 4),
(2, 2, 4),
(3, 2, 4),
(4, 2, 4),
(5, 4, 4),
(6, 4, 4),
(7, 4, 4),
(8, 6, 4),
(9, 1, 4),
(10, 1, 4),
(11, 1, 4),
(12, 1, 4),
(12, 5, -1),
(13, 1, 4),
(14, 1, 4),
(15, 1, 4),
(15, 5, 1),
(16, 1, 4),
(16, 5, 1),
(17, 1, 4),
(17, 5, 1),
(18, 1, 4),
(19, 1, 4),
(19, 5, 1),
(20, 1, 4),
(20, 5, 1),
(21, 1, 4),
(21, 5, 1),
(22, 1, 4),
(22, 5, 1),
(23, 1, 4),
(23, 5, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `odm_category`
--
ALTER TABLE `odm_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `odm_data`
--
ALTER TABLE `odm_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_idx` (`id`,`owner`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`),
  ADD KEY `publishable` (`publishable`),
  ADD KEY `description` (`description`(200));

--
-- Indexes for table `odm_department`
--
ALTER TABLE `odm_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `odm_dept_perms`
--
ALTER TABLE `odm_dept_perms`
  ADD KEY `rights` (`rights`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `fid` (`fid`);

--
-- Indexes for table `odm_filetypes`
--
ALTER TABLE `odm_filetypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `odm_log`
--
ALTER TABLE `odm_log`
  ADD KEY `id` (`id`),
  ADD KEY `modified_on` (`modified_on`);

--
-- Indexes for table `odm_odmsys`
--
ALTER TABLE `odm_odmsys`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `odm_settings`
--
ALTER TABLE `odm_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`(200));

--
-- Indexes for table `odm_udf`
--
ALTER TABLE `odm_udf`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `odm_user`
--
ALTER TABLE `odm_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `odm_user_perms`
--
ALTER TABLE `odm_user_perms`
  ADD KEY `user_perms_idx` (`fid`,`uid`,`rights`),
  ADD KEY `fid` (`fid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `rights` (`rights`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `odm_category`
--
ALTER TABLE `odm_category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `odm_data`
--
ALTER TABLE `odm_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `odm_department`
--
ALTER TABLE `odm_department`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `odm_filetypes`
--
ALTER TABLE `odm_filetypes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `odm_odmsys`
--
ALTER TABLE `odm_odmsys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `odm_settings`
--
ALTER TABLE `odm_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `odm_udf`
--
ALTER TABLE `odm_udf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `odm_user`
--
ALTER TABLE `odm_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
