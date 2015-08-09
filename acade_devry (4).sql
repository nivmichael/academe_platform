-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2015 at 05:01 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `acade_devry`
--

-- --------------------------------------------------------

--
-- Table structure for table `--type_user_params`
--

CREATE TABLE IF NOT EXISTS `--type_user_params` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `p_name` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `doc_param`
--

CREATE TABLE IF NOT EXISTS `doc_param` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `doc_type_id` mediumint(9) NOT NULL,
  `doc_sub_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doc_type_id` (`doc_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `doc_param`
--

INSERT INTO `doc_param` (`id`, `name`, `slug`, `doc_type_id`, `doc_sub_type`, `created_at`, `updated_at`) VALUES
(1, 'education', 'Education', 1, 'jobSeeker', NULL, NULL),
(2, 'language_skills', 'Language Skills', 1, 'jobSeeker', '2015-06-14 09:16:06', '2015-06-14 09:24:36'),
(8, 'experience', 'Experience', 1, 'jobSeeker', '2015-07-02 12:21:49', '2015-07-02 12:21:49'),
(9, 'company', 'Company', 1, 'employer', '2015-07-06 08:11:17', '2015-07-06 08:11:17'),
(13, 'files', 'Files', 1, 'employer', NULL, NULL),
(14, 'company', 'Company', 2, NULL, NULL, NULL),
(16, 'files', 'Files', 2, NULL, NULL, NULL),
(17, 'education', 'Education', 2, NULL, '2015-07-13 11:46:37', '2015-07-13 11:46:37'),
(18, 'files', 'Files', 1, 'jobSeeker', '2015-07-20 11:34:10', '2015-07-20 11:34:10');

-- --------------------------------------------------------

--
-- Table structure for table `doc_type`
--

CREATE TABLE IF NOT EXISTS `doc_type` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `doc_type`
--

INSERT INTO `doc_type` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'user', NULL, NULL),
(2, 'post', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `param`
--

CREATE TABLE IF NOT EXISTS `param` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `authorized` tinyint(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type_id` mediumint(9) DEFAULT NULL,
  `doc_param_id` mediumint(9) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doc_param_id` (`doc_param_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `param`
--

INSERT INTO `param` (`id`, `authorized`, `name`, `slug`, `type_id`, `doc_param_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'institute', 'Institute', 1, 1, NULL, '2015-07-19 07:34:42'),
(3, 1, 'language', 'Language', 2, 2, '2015-06-14 09:18:06', '2015-08-03 06:28:44'),
(15, 1, 'company_name', 'Company Name', 1, 9, NULL, '2015-07-20 04:48:12'),
(17, 1, 'company_logo', 'Company Logo', 3, 13, NULL, '2015-07-20 08:58:01'),
(18, 0, 'job_description', 'Job Description', 4, 14, NULL, '2015-07-20 05:23:04'),
(19, 1, 'main_field', 'Main Field', 2, 14, NULL, '2015-07-19 10:27:14'),
(21, 1, 'profession', 'Profession', 1, 14, '2015-07-09 08:55:52', '2015-08-03 12:00:42'),
(24, 1, 'profession', 'Profession', 1, 8, '2015-07-13 11:29:51', '2015-08-03 12:00:42'),
(31, 1, 'degree', 'Degree', 2, 17, '2015-07-20 05:30:25', '2015-07-20 05:31:52'),
(33, 1, 'major', 'Major', 2, 17, '2015-07-20 05:35:03', '2015-07-20 05:35:03'),
(35, 1, 'user_photo', 'User Photo', 3, 18, '2015-07-20 11:26:32', '2015-07-20 11:26:32'),
(36, 1, 'profile_pic', 'Profile picture', 3, 18, '2015-07-20 11:45:32', '2015-07-20 11:45:32'),
(37, 1, 'faculty', 'Faculty', 2, 1, '2015-08-03 11:49:50', '2015-08-03 11:49:50');

-- --------------------------------------------------------

--
-- Table structure for table `param_type`
--

CREATE TABLE IF NOT EXISTS `param_type` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `param_type`
--

INSERT INTO `param_type` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'text', NULL, NULL),
(2, 'select', NULL, NULL),
(3, 'file', NULL, NULL),
(4, 'textarea', '2015-07-19 10:25:39', '2015-07-19 10:25:39');

-- --------------------------------------------------------

--
-- Table structure for table `param_value`
--

CREATE TABLE IF NOT EXISTS `param_value` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `param_id` mediumint(9) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `param_id` (`param_id`),
  KEY `param_name` (`value`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `param_value`
--

INSERT INTO `param_value` (`id`, `param_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 'UC San Diego', '2015-06-14 12:27:45', '2015-06-14 12:27:45'),
(2, 3, 'Hebrew', '2015-06-14 09:28:03', '2015-06-14 09:28:03'),
(3, 1, 'UCLA', '2015-07-13 11:25:36', '2015-07-13 11:25:36'),
(4, 1, 'TAU', '2015-07-13 11:26:51', '2015-07-13 11:27:19'),
(5, 1, 'NYU', '2015-07-13 11:26:56', '2015-07-13 11:27:21');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('dorshoham88@gmail.com', '75fa8688393ae0cbb151bc4247018b91ace5d71774828824d7ca67f3ac6719f5', '2015-06-30 03:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `sys_param_values`
--

CREATE TABLE IF NOT EXISTS `sys_param_values` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `doc_type` mediumint(9) NOT NULL DEFAULT '12',
  `ref_id` mediumint(9) unsigned NOT NULL,
  `param_id` mediumint(9) NOT NULL,
  `iteration` tinyint(4) DEFAULT NULL,
  `value_short` text,
  `value_long` text,
  `value_ref` int(9) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doc_type` (`doc_type`,`ref_id`,`param_id`),
  KEY `doc_type_2` (`doc_type`),
  KEY `ref_user_id` (`ref_id`),
  KEY `param_id` (`param_id`),
  KEY `ref_user_id_2` (`ref_id`),
  KEY `value_ref` (`value_ref`),
  KEY `doc_type_3` (`doc_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1634 ;

--
-- Dumping data for table `sys_param_values`
--

INSERT INTO `sys_param_values` (`id`, `doc_type`, `ref_id`, `param_id`, `iteration`, `value_short`, `value_long`, `value_ref`, `created_at`, `updated_at`) VALUES
(534, 1, 6, 15, NULL, 'AcadeME', NULL, NULL, NULL, NULL),
(535, 1, 6, 17, NULL, '', NULL, NULL, NULL, NULL),
(536, 1, 6, 17, NULL, 'uploads/userimgs/6/לוגו.jpg', 'לוגו.jpg', NULL, '2015-07-30 06:50:41', '2015-07-30 06:50:41'),
(1026, 2, 32, 19, NULL, 'Web Applications', NULL, NULL, NULL, NULL),
(1027, 2, 32, 21, NULL, 'Web Developer', NULL, NULL, NULL, NULL),
(1168, 2, 32, 31, 0, '6', NULL, NULL, NULL, NULL),
(1169, 2, 32, 33, 0, '6', NULL, NULL, NULL, NULL),
(1170, 2, 32, 31, 1, '3', NULL, NULL, NULL, NULL),
(1171, 2, 32, 33, 1, '3', NULL, NULL, NULL, NULL),
(1172, 2, 32, 31, 2, '1', NULL, NULL, NULL, NULL),
(1173, 2, 32, 33, 2, '1', NULL, NULL, NULL, NULL),
(1435, 1, 36, 3, NULL, '', NULL, NULL, NULL, NULL),
(1436, 1, 36, 1, NULL, '', NULL, NULL, NULL, NULL),
(1437, 1, 36, 37, NULL, '', NULL, NULL, NULL, NULL),
(1438, 1, 36, 24, NULL, '', NULL, NULL, NULL, NULL),
(1439, 2, 37, 3, 0, '', NULL, NULL, NULL, NULL),
(1440, 2, 37, 1, 0, '', NULL, NULL, NULL, NULL),
(1441, 2, 37, 37, 0, '', NULL, NULL, NULL, NULL),
(1442, 2, 37, 24, 0, '', NULL, NULL, NULL, NULL),
(1443, 2, 37, 3, 1, '3', NULL, NULL, NULL, NULL),
(1444, 2, 37, 3, 2, '2', NULL, NULL, NULL, NULL),
(1445, 2, 37, 3, 0, '', NULL, NULL, NULL, NULL),
(1446, 2, 37, 3, 0, '', NULL, NULL, NULL, NULL),
(1447, 2, 37, 3, 0, '', NULL, NULL, NULL, NULL),
(1448, 2, 37, 1, 0, '1', NULL, NULL, NULL, NULL),
(1449, 2, 37, 37, 0, '2', NULL, NULL, NULL, NULL),
(1450, 2, 37, 3, 0, '', NULL, NULL, NULL, NULL),
(1451, 2, 37, 1, 0, '1', NULL, NULL, NULL, NULL),
(1452, 2, 37, 37, 0, '2', NULL, NULL, NULL, NULL),
(1453, 2, 37, 1, 1, '1', NULL, NULL, NULL, NULL),
(1454, 2, 37, 37, 1, '1', NULL, NULL, NULL, NULL),
(1455, 2, 37, 3, 0, '', NULL, NULL, NULL, NULL),
(1456, 2, 37, 1, 0, '1', NULL, NULL, NULL, NULL),
(1457, 2, 37, 37, 0, '2', NULL, NULL, NULL, NULL),
(1458, 2, 37, 1, 2, '2', NULL, NULL, NULL, NULL),
(1459, 2, 37, 37, 2, '2', NULL, NULL, NULL, NULL),
(1460, 2, 37, 3, 0, '', NULL, NULL, NULL, NULL),
(1461, 2, 37, 1, 0, '4', NULL, NULL, NULL, NULL),
(1462, 2, 37, 37, 0, '3', NULL, NULL, NULL, NULL),
(1463, 2, 37, 3, 0, '', NULL, NULL, NULL, NULL),
(1464, 2, 37, 1, 0, '', NULL, NULL, NULL, NULL),
(1465, 2, 37, 37, 0, '', NULL, NULL, NULL, NULL),
(1466, 2, 37, 3, 0, '', NULL, NULL, NULL, NULL),
(1467, 2, 37, 1, 0, '1', NULL, NULL, NULL, NULL),
(1468, 2, 37, 37, 0, '2', NULL, NULL, NULL, NULL),
(1469, 2, 37, 3, 0, '', NULL, NULL, NULL, NULL),
(1470, 2, 37, 1, 0, '1', NULL, NULL, NULL, NULL),
(1471, 2, 37, 37, 0, '2', NULL, NULL, NULL, NULL),
(1472, 2, 37, 3, 0, '', NULL, NULL, NULL, NULL),
(1473, 2, 37, 3, 0, '', NULL, NULL, NULL, NULL),
(1474, 2, 37, 1, 0, '1', NULL, NULL, NULL, NULL),
(1475, 2, 37, 37, 0, '1', NULL, NULL, NULL, NULL),
(1476, 2, 37, 3, 0, '', NULL, NULL, NULL, NULL),
(1477, 2, 37, 1, 0, '3', NULL, NULL, NULL, NULL),
(1478, 2, 37, 37, 0, '3', NULL, NULL, NULL, NULL),
(1479, 2, 37, 3, 0, '', NULL, NULL, NULL, NULL),
(1480, 2, 37, 1, 0, '3', NULL, NULL, NULL, NULL),
(1481, 2, 37, 37, 0, '3', NULL, NULL, NULL, NULL),
(1482, 2, 37, 3, 0, '1', NULL, NULL, NULL, NULL),
(1483, 2, 37, 1, 0, '3', NULL, NULL, NULL, NULL),
(1484, 2, 37, 37, 0, '3', NULL, NULL, NULL, NULL),
(1485, 2, 37, 24, 1, 'The Messiah', NULL, NULL, NULL, NULL),
(1486, 2, 37, 3, 0, '1', NULL, NULL, NULL, NULL),
(1487, 2, 37, 1, 0, '3', NULL, NULL, NULL, NULL),
(1488, 2, 37, 37, 0, '3', NULL, NULL, NULL, NULL),
(1489, 2, 37, 24, 0, 'Web Developer', NULL, NULL, NULL, NULL),
(1490, 2, 37, 3, 0, '1', NULL, NULL, NULL, NULL),
(1491, 2, 37, 1, 0, '3', NULL, NULL, NULL, NULL),
(1492, 2, 37, 37, 0, '3', NULL, NULL, NULL, NULL),
(1493, 2, 37, 24, 0, 'Web Developer', NULL, NULL, NULL, NULL),
(1494, 2, 37, 3, 0, '1', NULL, NULL, NULL, NULL),
(1495, 1, 40, 15, NULL, 'AcadeME', NULL, NULL, NULL, NULL),
(1496, 1, 40, 17, NULL, 'uploads/userimgs/40/לוגו.jpg', 'לוגו.jpg', NULL, '2015-08-06 07:30:26', '2015-08-06 07:30:26'),
(1497, 2, 44, 19, NULL, 'main', NULL, NULL, NULL, NULL),
(1498, 2, 44, 21, NULL, 'prof', NULL, NULL, NULL, NULL),
(1499, 2, 44, 31, NULL, 'deg', NULL, NULL, NULL, NULL),
(1500, 2, 44, 33, NULL, 'm,aj', NULL, NULL, NULL, NULL),
(1501, 2, 45, 19, NULL, 'm', NULL, NULL, NULL, NULL),
(1502, 2, 45, 21, NULL, 'p', NULL, NULL, NULL, NULL),
(1503, 2, 45, 31, 0, '2', NULL, NULL, NULL, NULL),
(1504, 2, 45, 33, 0, '2', NULL, NULL, NULL, NULL),
(1505, 2, 45, 31, 1, '1', NULL, NULL, NULL, NULL),
(1506, 2, 45, 33, 1, '1', NULL, NULL, NULL, NULL),
(1507, 2, 45, 31, 2, '3', NULL, NULL, NULL, NULL),
(1508, 2, 45, 33, 2, '3', NULL, NULL, NULL, NULL),
(1509, 2, 46, 19, NULL, 'm', NULL, NULL, NULL, NULL),
(1510, 2, 46, 21, NULL, 'p', NULL, NULL, NULL, NULL),
(1511, 2, 46, 31, 0, '1', NULL, NULL, NULL, NULL),
(1512, 2, 46, 33, 0, '1', NULL, NULL, NULL, NULL),
(1513, 2, 46, 31, 1, '1', NULL, NULL, NULL, NULL),
(1514, 2, 46, 33, 1, '1', NULL, NULL, NULL, NULL),
(1515, 2, 46, 31, 0, '2', NULL, NULL, NULL, NULL),
(1516, 2, 46, 33, 0, '2', NULL, NULL, NULL, NULL),
(1517, 2, 46, 31, 2, '4', NULL, NULL, NULL, NULL),
(1518, 2, 46, 33, 2, '4', NULL, NULL, NULL, NULL),
(1519, 1, 40, 17, NULL, 'uploads/userimgs/40/‏‏עותק של wanted logo - Copy.jpg', '‏‏עותק של wanted logo - Copy.jpg', NULL, '2015-08-06 08:02:44', '2015-08-06 08:02:44'),
(1520, 2, 47, 19, 0, 'q', NULL, NULL, NULL, NULL),
(1521, 2, 47, 21, 0, 'q', NULL, NULL, NULL, NULL),
(1522, 2, 47, 19, 1, 'w', NULL, NULL, NULL, NULL),
(1523, 2, 47, 21, 1, 'w', NULL, NULL, NULL, NULL),
(1524, 2, 47, 31, 0, '1', NULL, NULL, NULL, NULL),
(1525, 2, 47, 33, 0, '1', NULL, NULL, NULL, NULL),
(1526, 2, 47, 31, 1, '2', NULL, NULL, NULL, NULL),
(1527, 2, 47, 33, 1, '2', NULL, NULL, NULL, NULL),
(1528, 2, 48, 19, 0, 'volvo', NULL, NULL, NULL, NULL),
(1529, 2, 48, 21, 0, 'גדשגדש', NULL, NULL, NULL, NULL),
(1530, 2, 48, 19, 1, '2', NULL, NULL, NULL, NULL),
(1531, 2, 48, 21, 1, 'pro evolution', NULL, NULL, NULL, NULL),
(1532, 2, 48, 31, 0, 'saab', NULL, NULL, NULL, NULL),
(1533, 2, 48, 33, 0, 'mercedes', NULL, NULL, NULL, NULL),
(1534, 2, 48, 31, 1, '5', NULL, NULL, NULL, NULL),
(1535, 2, 48, 33, 1, '4', NULL, NULL, NULL, NULL),
(1536, 2, 47, 21, 0, 'q', NULL, NULL, NULL, NULL),
(1537, 2, 47, 19, 0, 'q', NULL, NULL, NULL, NULL),
(1538, 2, 47, 31, 0, '1', NULL, NULL, NULL, NULL),
(1539, 2, 47, 33, 0, '1', NULL, NULL, NULL, NULL),
(1540, 2, 46, 31, 0, '2', NULL, NULL, NULL, NULL),
(1541, 2, 46, 33, 0, '2', NULL, NULL, NULL, NULL),
(1542, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1543, 2, 48, 19, 0, 'volvo', NULL, NULL, NULL, NULL),
(1544, 2, 48, 31, 0, 'saab', NULL, NULL, NULL, NULL),
(1545, 2, 48, 33, 0, 'mercedes', NULL, NULL, NULL, NULL),
(1546, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1547, 2, 48, 19, 0, 'active', NULL, NULL, NULL, NULL),
(1548, 2, 48, 31, 0, 'saab', NULL, NULL, NULL, NULL),
(1549, 2, 48, 33, 0, 'mercedes', NULL, NULL, NULL, NULL),
(1550, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1551, 2, 48, 19, 0, 'active', NULL, NULL, NULL, NULL),
(1552, 2, 48, 31, 0, 'inactive', NULL, NULL, NULL, NULL),
(1553, 2, 48, 33, 0, 'active', NULL, NULL, NULL, NULL),
(1554, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1555, 2, 48, 19, 0, '5', NULL, NULL, NULL, NULL),
(1556, 2, 48, 31, 0, '1', NULL, NULL, NULL, NULL),
(1557, 2, 48, 33, 0, '2', NULL, NULL, NULL, NULL),
(1558, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1559, 2, 48, 19, 0, '2', NULL, NULL, NULL, NULL),
(1560, 2, 48, 31, 0, '1', NULL, NULL, NULL, NULL),
(1561, 2, 48, 33, 0, '2', NULL, NULL, NULL, NULL),
(1562, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1563, 2, 48, 19, 0, '2', NULL, NULL, NULL, NULL),
(1564, 2, 48, 31, 0, '4', NULL, NULL, NULL, NULL),
(1565, 2, 48, 33, 0, '5', NULL, NULL, NULL, NULL),
(1566, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1567, 2, 48, 19, 0, '2', NULL, NULL, NULL, NULL),
(1568, 2, 48, 31, 0, '4', NULL, NULL, NULL, NULL),
(1569, 2, 48, 33, 0, '5', NULL, NULL, NULL, NULL),
(1570, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1571, 2, 48, 19, 0, '3', NULL, NULL, NULL, NULL),
(1572, 2, 48, 31, 0, '4', NULL, NULL, NULL, NULL),
(1573, 2, 48, 33, 0, '5', NULL, NULL, NULL, NULL),
(1574, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1575, 2, 48, 19, 0, '2', NULL, NULL, NULL, NULL),
(1576, 2, 48, 31, 0, '4', NULL, NULL, NULL, NULL),
(1577, 2, 48, 33, 0, '5', NULL, NULL, NULL, NULL),
(1578, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1579, 2, 48, 19, 0, '4', NULL, NULL, NULL, NULL),
(1580, 2, 48, 31, 0, '4', NULL, NULL, NULL, NULL),
(1581, 2, 48, 33, 0, '5', NULL, NULL, NULL, NULL),
(1582, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1583, 2, 48, 19, 0, '1', NULL, NULL, NULL, NULL),
(1584, 2, 48, 31, 0, '4', NULL, NULL, NULL, NULL),
(1585, 2, 48, 33, 0, '5', NULL, NULL, NULL, NULL),
(1586, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1587, 2, 48, 19, 0, '5', NULL, NULL, NULL, NULL),
(1588, 2, 48, 31, 0, '4', NULL, NULL, NULL, NULL),
(1589, 2, 48, 33, 0, '5', NULL, NULL, NULL, NULL),
(1590, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1591, 2, 48, 19, 0, '3', NULL, NULL, NULL, NULL),
(1592, 2, 48, 31, 0, '4', NULL, NULL, NULL, NULL),
(1593, 2, 48, 33, 0, '5', NULL, NULL, NULL, NULL),
(1594, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1595, 2, 48, 19, 0, '3', NULL, NULL, NULL, NULL),
(1596, 2, 48, 31, 0, '4', NULL, NULL, NULL, NULL),
(1597, 2, 48, 33, 0, '5', NULL, NULL, NULL, NULL),
(1598, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1599, 2, 48, 19, 0, '2', NULL, NULL, NULL, NULL),
(1600, 2, 48, 31, 0, '4', NULL, NULL, NULL, NULL),
(1601, 2, 48, 33, 0, '5', NULL, NULL, NULL, NULL),
(1602, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1603, 2, 48, 19, 0, '1', NULL, NULL, NULL, NULL),
(1604, 2, 48, 31, 0, '3', NULL, NULL, NULL, NULL),
(1605, 2, 48, 33, 0, '4', NULL, NULL, NULL, NULL),
(1606, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1607, 2, 48, 19, 0, '1', NULL, NULL, NULL, NULL),
(1608, 2, 48, 31, 0, '3', NULL, NULL, NULL, NULL),
(1609, 2, 48, 33, 0, '4', NULL, NULL, NULL, NULL),
(1610, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1611, 2, 48, 19, 0, '2', NULL, NULL, NULL, NULL),
(1612, 2, 48, 31, 0, '3', NULL, NULL, NULL, NULL),
(1613, 2, 48, 33, 0, '4', NULL, NULL, NULL, NULL),
(1614, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1615, 2, 48, 19, 0, '2', NULL, NULL, NULL, NULL),
(1616, 2, 48, 31, 0, '3', NULL, NULL, NULL, NULL),
(1617, 2, 48, 33, 0, '4', NULL, NULL, NULL, NULL),
(1618, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1619, 2, 48, 19, 0, '2', NULL, NULL, NULL, NULL),
(1620, 2, 48, 31, 0, '3', NULL, NULL, NULL, NULL),
(1621, 2, 48, 33, 0, '4', NULL, NULL, NULL, NULL),
(1622, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1623, 2, 48, 19, 0, '1', NULL, NULL, NULL, NULL),
(1624, 2, 48, 31, 0, '3', NULL, NULL, NULL, NULL),
(1625, 2, 48, 33, 0, '4', NULL, NULL, NULL, NULL),
(1626, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1627, 2, 48, 19, 0, '1', NULL, NULL, NULL, NULL),
(1628, 2, 48, 31, 0, '3', NULL, NULL, NULL, NULL),
(1629, 2, 48, 33, 0, '1', NULL, NULL, NULL, NULL),
(1630, 2, 48, 21, 0, 'professional', NULL, NULL, NULL, NULL),
(1631, 2, 48, 19, 0, '1', NULL, NULL, NULL, NULL),
(1632, 2, 48, 31, 0, '3', NULL, NULL, NULL, NULL),
(1633, 2, 48, 33, 0, '1', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `type_post`
--

CREATE TABLE IF NOT EXISTS `type_post` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `description_short` text NOT NULL,
  `description` text NOT NULL,
  `authorized` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `type_post`
--

INSERT INTO `type_post` (`id`, `user_id`, `title`, `description_short`, `description`, `authorized`, `created_at`, `updated_at`) VALUES
(30, 6, '', '', '', 0, '2015-08-02 11:13:17', '2015-08-02 11:13:17'),
(31, 12, 'eqw', '', 'ewq', 0, '2015-08-04 04:50:50', '2015-08-04 04:50:50'),
(32, 13, 'SaaS Dev', '', 'Developing SaaS', 0, '2015-08-04 05:25:16', '2015-08-05 03:34:47'),
(33, 13, 'dsadsa', '', '', 0, '2015-08-05 05:25:52', '2015-08-05 10:07:28'),
(34, 13, 'sadsadsa', '', '', 0, '2015-08-05 05:28:35', '2015-08-05 10:07:10'),
(35, 13, 'tittt', '', 'desc', 0, '2015-08-05 06:40:55', '2015-08-05 06:40:55'),
(36, 13, '1', '', '', 0, '2015-08-05 06:44:29', '2015-08-05 06:44:29'),
(37, 13, '6', '', '1', 0, '2015-08-05 06:49:52', '2015-08-05 06:49:52'),
(38, 13, 'r', '', '', 0, '2015-08-05 07:02:35', '2015-08-05 07:02:35'),
(39, 13, 'qqqqqqq', '', 'qqqq', 0, '2015-08-05 08:59:29', '2015-08-05 08:59:29'),
(40, 13, '321', '', '321', 0, '2015-08-05 09:04:50', '2015-08-05 09:04:50'),
(41, 13, 'titit', '', '123', 0, '2015-08-05 09:30:33', '2015-08-05 09:30:33'),
(42, 13, '1', '', '1', 0, '2015-08-05 09:40:44', '2015-08-05 09:40:44'),
(43, 13, 'title', '', 'description', 0, '2015-08-05 10:17:22', '2015-08-05 10:17:22'),
(44, 40, 'new', '', 'desc', 0, '2015-08-06 07:34:18', '2015-08-06 07:34:18'),
(45, 40, 'tit', '', 'des', 0, '2015-08-06 07:58:14', '2015-08-06 07:58:14'),
(46, 40, 'hello world', '', 'd', 0, '2015-08-06 07:59:01', '2015-08-06 08:46:59'),
(47, 40, 'שלום כיתה א', '', '', 0, '2015-08-06 08:03:29', '2015-08-06 08:46:39'),
(48, 40, 'גדשגדש', '', 'שדגדגש', 0, '2015-08-06 08:43:01', '2015-08-06 08:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `type_user`
--

CREATE TABLE IF NOT EXISTS `type_user` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('tech-admin','content-admin','user') DEFAULT 'tech-admin',
  `subtype` text,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `password_new` varchar(255) DEFAULT NULL,
  `first_name` varchar(15) DEFAULT NULL,
  `last_name` varchar(15) DEFAULT NULL,
  `street_1` varchar(256) DEFAULT NULL,
  `street_2` varchar(256) DEFAULT NULL,
  `city` varchar(25) DEFAULT NULL,
  `state` varchar(25) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `country` varchar(25) DEFAULT NULL,
  `phone_1` varchar(20) DEFAULT NULL,
  `phone_2` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `date_of_birth` timestamp NULL DEFAULT NULL,
  `registration` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `send_newsletters` tinyint(1) NOT NULL,
  `send_notifications` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `remember_token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `send_newsletters` (`send_newsletters`),
  KEY `send_notifications` (`send_notifications`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `type_user`
--

INSERT INTO `type_user` (`id`, `type`, `subtype`, `status`, `email`, `password`, `password_new`, `first_name`, `last_name`, `street_1`, `street_2`, `city`, `state`, `zipcode`, `country`, `phone_1`, `phone_2`, `mobile`, `date_of_birth`, `registration`, `last_login`, `send_newsletters`, `send_notifications`, `created_at`, `updated_at`, `remember_token`) VALUES
(6, 'tech-admin', 'employer', 'active', 'd@gfgf.gf', '$2y$10$GaNLsP.TjNe6KuuUJmI3H.m0to.ZRw4Mgmgovmme4Fru068R.XE1W', NULL, 'ddd', 'd', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '2015-07-30 06:50:33', '2015-08-03 09:22:19', 'RUer8Hsy4cq97bHXPPR3839E372Jyl01JHq0ybQ6kcuzE4mNTts0EvScE0Bu'),
(7, 'tech-admin', 'jobSeeker', 'active', 'd@d.d', '$2y$10$CEps.dZ1Rv1dGLgLI76asObPfC6mawucsgaIsGQD6g37NhOix8pWu', NULL, 'ddd', 'd', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '2015-07-30 10:58:20', '2015-07-30 11:44:25', 'fCI7LKkcAfDaFSNyY0FwvSm38FSzzQmojzthxGntALUuEM5jpIK9RurBNzbI'),
(8, 'tech-admin', 'jobSeeker', 'active', 'd@d.qqwqwqwq', '$2y$10$JC3fKg.ncF6vP4yl4PWYxOSyX4nYZzN7FVNRIuNBEYHwVbko.CPuC', NULL, 'Dor', 'Shoham', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-08-02 11:24:39', 0, 0, '2015-07-30 11:45:00', '2015-08-02 11:29:05', 'ytdVf94S5RXF3OgtsVQPgf98sdA183sP5KuBMVL1voBduicVTiKJK1FV3nZM'),
(9, 'tech-admin', 'jobSeeker', 'active', 'dorsss@gmail.com', '$2y$10$rwAWzRXuea1UAWDXrQJpN.oiowyFQTtRYMvC4SsJjGuouFdNpGfVm', NULL, 'Dor', 'Shoham', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-08-03 11:50:33', 0, 0, '2015-08-02 11:29:37', '2015-08-04 03:57:35', 'qkC4iyqKTK5eVevw32hcvxjp941FsNYyO51L7oljiaj6G5cYQZ6H7nmbGqRK'),
(10, 'tech-admin', 'jobSeeker', 'active', 'd@qqq.da', '$2y$10$X1r3BAeZV0HC62D09LwYkO/0NzhLBVcFpkl3wkugqgsVh1QpaI46e', NULL, 'dss', 's', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '2015-08-04 03:58:17', '2015-08-04 03:58:54', 'WF8kFbms1voKMMyf1mL8jTct2jp3MppMzB6uhuJeiLcolu9GvwMK67xVpDgt'),
(11, 'tech-admin', 'jobSeeker', 'active', 'a@QQ.D', '$2y$10$L3Gg/qS8QMDexoqS68fTOeCnK8Zs9Yy0/StJrNkXWDgZM4H.gwVNi', NULL, 'ddd', 's', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '2015-08-04 03:59:23', '2015-08-04 04:40:50', '7BUYyibktciYzxBXMUuGxvCBr6TVBkHeqmPlIXM75FKF3ssJC6nChy2AyJXd'),
(12, 'tech-admin', 'employer', 'active', 'dorshoham88@gmail.com', '$2y$10$RuhfckG.7NHJ1XWZvRQnwuHquag3/Cb3I6SclzSQwKWYpI8amBd76', NULL, 'ddd', 'd', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '2015-08-04 04:41:56', '2015-08-04 05:12:35', 'vce8RnydYQf8KIyR6ILGL8RvUGJvviyyHB0G4NOHthCRssb9keD5nTZrK78g'),
(13, 'tech-admin', 'employer', 'active', 'd@123.kkk', '$2y$10$OkGp63Lv97kTR3jTlvNDTuhUtA4oeEzk2kS8ezq3c13/rnUNCyyXK', NULL, 'ddd', 's', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '2015-08-04 05:22:38', '2015-08-05 10:19:29', 'Gz7xzDgZDaljl5gEtx2sNZww6o9QdQMIosQNTH0Ay3QCAZU6WMWJ3moqJTu7'),
(14, 'tech-admin', 'jobSeeker', 'active', 'd@d.dsqqqwe', '$2y$10$uvJX3Z07O2wJpuQaRN7.g.qhGj4RtjyibSxetvrJ2Fcd/0mvttEgW', NULL, 'ddd', 'd', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '2015-08-05 10:20:08', '2015-08-05 10:29:52', '9tQfPcFPuaJhGueazovfbRLPBdcuTCb1x2xhsir4EyYikLLT08xDvuVxh6km'),
(15, 'tech-admin', 'employer', 'active', 'd@d.mnop', '$2y$10$nusEZ.9iBB6pxfpMBfE6dedoKcRBYrRrFKdt2i5nuJFKSC64JSmdS', NULL, 'dor', 'shoham', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '2015-08-05 10:21:40', '2015-08-05 10:28:13', 'HB6eMt0ay4qwyCxOegNUCr7Vq44Pf7WNikcV9bF1aY9JGBt9NUdahnZzWofs'),
(16, 'tech-admin', 'jobSeeker', 'active', 'dorshoham@gmail.com', '$2y$10$ImAw9eg5f1mBdLV9LEoCjeIFXUGklCfHAc.XQwWA7C8kVWqeZvnrO', NULL, 'Dor', 'Shoham', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-08-05 11:39:21', 0, 0, '2015-08-05 10:30:26', '2015-08-05 11:39:32', 'C0eOKuhsfwEjW0fXPxDZi8JyvljbTPkP4GxiSbLKvdvTcoOt6P5U4LrdJHCs'),
(21, 'tech-admin', 'jobSeeker', 'active', 'd@qbbbc.x', '$2y$10$QcIZpmfbIdP2QfMQL5.Mbeoi6yV80zs9OzoO.0b2/6B87yUS7tK9O', NULL, 'dor', 'ss', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '2015-08-06 04:00:35', '2015-08-06 04:09:52', 'nAhAn06Qqi3K1LvWdej9utZYgxYPW8mzJWhLEvvmhkEtCBslLC5Bq6E5thbb'),
(23, 'tech-admin', 'jobSeeker', 'active', 'd@dd.qqqew', '$2y$10$UtP7BOeWpTM1Quq/C/8T5.NZKMjLwlcpbjATWsusJVUBScbD.cAau', NULL, 'Ddd', 'dorrr', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '2015-08-06 04:12:26', '2015-08-06 04:18:08', 'bzKI5neV5E6oWC6lYo7SXQHB6rWYA50HPpeFpE84dqJQfW3DHEMUnjhiLdeB'),
(24, 'tech-admin', 'jobSeeker', 'active', 'd@ddd.dewqewqewq', '$2y$10$fWOe1PlZT0r1O7uiLWwJo.oZ5eaIa0A4Dz72vPMN3utpef7dh8qN6', NULL, 'ddd', 's', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '2015-08-06 04:41:51', '2015-08-06 04:43:35', 'nEobdeVQgLhWH0HQDLyu1xWhNV9zZ1tNi8uCN78oJFoWLiOl7fOTUtCqZGHX'),
(32, 'tech-admin', 'jobSeeker', 'active', 'd@ee.v', '$2y$10$WZw19cQt2xLWULOeV.n28.JF38PdygpPL6s7ipuA4nWzjjzB6tOXm', NULL, 'ddd', 'd', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '2015-08-06 05:20:05', '2015-08-06 05:24:49', 'c8P8w5qqYFJjaILQRUheEWYTP7GSwMmKbpbkxdSQIOtD7IvFSSfYQh4isMIY'),
(33, 'tech-admin', 'jobSeeker', 'active', 'd@ddddsadsads.dsa', '$2y$10$P6hVE4QgATBP6OT5HkD4LefJvSzmGiibASkFLFqGBlo4ntceZIIJi', NULL, 'ddd', 's', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '2015-08-06 05:26:04', '2015-08-06 05:34:01', 'eiM0zcvcRaOi7gzEIYmSEIZivyGvsmOF1yKD0kGkGXIKdCNMbFZB4SMSKKLl'),
(37, 'tech-admin', 'jobSeeker', 'active', 'd@fdsfdsfdsfdsfdsfdsfds.d', '$2y$10$4fy0bnp/XpLjGHIDC0s0uOkiM1dRjuVd.FCVsPvSg/.zpHyvQu9E2', NULL, 'Dor', 'Shoham', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-08-06 07:25:38', 0, 0, '2015-08-06 05:38:47', '2015-08-06 07:26:14', 'RF3Gmu14XnVzXQcpbxx57yEoJ8Gth4M3Mb1ppEHfiSpqk1by86aDVsyytGNJ'),
(40, 'tech-admin', 'employer', 'active', 'minmin@maxmax.com', '$2y$10$41SRGyk1ghgspqaNJQQRK.nhAWJOxKsOhbcAwNdu.FzQE1eQYsxwu', NULL, 'ddd', 's', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '2015-08-06 07:30:01', '2015-08-06 07:30:01', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doc_param`
--
ALTER TABLE `doc_param`
  ADD CONSTRAINT `doc_param_ibfk_1` FOREIGN KEY (`doc_type_id`) REFERENCES `doc_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `param`
--
ALTER TABLE `param`
  ADD CONSTRAINT `param_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `param_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `param_ibfk_2` FOREIGN KEY (`doc_param_id`) REFERENCES `doc_param` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
