-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2015 at 03:20 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nyu`
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
-- Table structure for table `css`
--

CREATE TABLE IF NOT EXISTS `css` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `property` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `css`
--

INSERT INTO `css` (`id`, `property`, `value`) VALUES
(1, 'main_color', '#5D2C87'),
(2, 'logo', 'http://cims.nyu.edu/~oza/NYULogo.png');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `doc_param`
--

INSERT INTO `doc_param` (`id`, `name`, `slug`, `doc_type_id`, `doc_sub_type`, `created_at`, `updated_at`) VALUES
(1, 'education', 'Education', 1, 'jobseeker', NULL, NULL),
(2, 'education', 'Education', 2, NULL, NULL, NULL),
(3, 'employment', 'Employment', 1, 'jobseeker', NULL, NULL),
(4, 'employment', 'Employment', 2, NULL, NULL, NULL),
(5, 'career_goals', 'Career Goals', 1, 'jobseeker', NULL, NULL),
(6, 'career_goals', 'Career Goals', 2, NULL, NULL, NULL),
(7, 'company', 'Company', 1, 'employer', NULL, NULL),
(8, 'files', 'Files', 1, 'jobseeker', NULL, NULL),
(9, 'files', 'Files', 1, 'employer', NULL, NULL);

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
  `authorized` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type_id` mediumint(9) DEFAULT NULL,
  `doc_param_id` mediumint(9) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doc_param_id` (`doc_param_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `param`
--

INSERT INTO `param` (`id`, `authorized`, `name`, `slug`, `type_id`, `doc_param_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'degree', 'Degree', 2, 1, NULL, NULL),
(2, 1, 'degree', 'Degree', 2, 2, NULL, NULL),
(3, 1, 'major', 'Major', 2, 1, NULL, NULL),
(4, 1, 'minor', 'Minor', 2, 1, NULL, NULL),
(5, 1, 'major', 'Major', 2, 2, NULL, NULL),
(6, 1, 'minor', 'Minor', 2, 2, NULL, NULL),
(7, 1, 'main_field', 'Main Field', 2, 3, NULL, NULL),
(8, 1, 'main_field', 'Main Field', 2, 4, NULL, NULL),
(9, 1, 'profession', 'Profession', 2, 3, NULL, NULL),
(10, 1, 'profession', 'Profession', 2, 4, NULL, NULL),
(11, 1, 'job_title', 'Job Title', 1, 5, NULL, NULL),
(12, 1, 'job_title', 'Job Title', 1, 6, NULL, NULL),
(13, 1, 'language', 'Language', 1, 5, NULL, NULL),
(14, 1, 'language', 'Language', 1, 6, NULL, NULL),
(15, 1, 'location', 'Location', 1, 5, NULL, NULL),
(16, 1, 'location', 'Location', 1, 6, NULL, NULL),
(17, 1, 'main_field', 'Main Field', 1, 5, NULL, NULL),
(18, 1, 'profession', 'Profession', 1, 5, NULL, NULL),
(19, 1, 'company_name', 'Company Name', 1, 7, NULL, NULL),
(20, 1, 'contact_person', 'Contact Person', 1, 7, NULL, NULL),
(21, 1, 'contact_title', 'Contact Title', 1, 7, NULL, NULL),
(22, 1, 'main_field', 'Main Field', 1, 7, NULL, NULL),
(23, 1, 'secondary_field', 'Secondary Field', 1, 7, NULL, NULL),
(24, 1, 'short_company_description', 'Short Company Description', 1, 7, NULL, NULL),
(25, 1, 'youtube', 'Company YouTube Video', 1, 7, NULL, NULL),
(26, 1, 'site_link', 'Site Link', 1, 7, NULL, NULL),
(27, 1, 'user_photo', 'User Photo', 6, 8, NULL, NULL),
(28, 1, 'company_logo', 'Company Logo', 6, 9, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `param_type`
--

INSERT INTO `param_type` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'text', NULL, NULL),
(2, 'select', NULL, NULL),
(3, 'checkbox', NULL, NULL),
(4, 'checklist', NULL, NULL),
(5, 'textarea', NULL, NULL),
(6, 'file\r\n', NULL, NULL),
(7, 'date', NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `param_value`
--

INSERT INTO `param_value` (`id`, `param_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 'GSCE', '2015-11-17 09:27:19', '2015-11-17 09:27:19'),
(2, 1, 'A-Levels', '2015-11-17 09:27:19', '2015-11-17 09:27:19'),
(3, 1, 'General Academic Studies Degree', '2015-11-17 09:27:19', '2015-11-17 09:27:19'),
(4, 1, 'BA', '2015-11-17 09:27:19', '2015-11-17 09:27:19'),
(5, 3, 'Business Administration', '2015-11-17 09:37:08', '2015-11-17 09:37:08'),
(6, 3, 'Life Sciences', '2015-11-17 09:37:08', '2015-11-17 09:37:08'),
(7, 3, 'Nursing', '2015-11-17 09:37:08', '2015-11-17 09:37:08'),
(8, 3, 'Philosophy And Sociology', '2015-11-17 09:37:08', '2015-11-17 09:37:08'),
(9, 4, 'Accounting', '2015-11-17 09:39:54', '2015-11-17 09:39:54'),
(10, 4, 'Finance', '2015-11-17 09:39:54', '2015-11-17 09:39:54'),
(11, 9, 'Back Office', '2015-11-17 10:09:19', '2015-11-17 10:09:19'),
(12, 9, 'Analyst', '2015-11-17 10:09:19', '2015-11-17 10:09:19'),
(13, 7, 'Administration', '2015-11-17 10:11:04', '2015-11-17 10:11:04'),
(14, 7, 'Finance', '2015-11-17 10:11:04', '2015-11-17 10:11:04');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=237 ;

--
-- Dumping data for table `sys_param_values`
--

INSERT INTO `sys_param_values` (`id`, `doc_type`, `ref_id`, `param_id`, `iteration`, `value_short`, `value_long`, `value_ref`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, NULL, NULL, 1, NULL, NULL),
(2, 1, 1, 1, 1, NULL, NULL, 2, NULL, NULL),
(11, 1, 3, 19, NULL, 'AcadeME', NULL, NULL, NULL, NULL),
(12, 1, 3, 20, NULL, 'Hen West', NULL, NULL, NULL, NULL),
(13, 1, 3, 21, NULL, 'Marketing Manger', NULL, NULL, NULL, NULL),
(14, 1, 3, 22, NULL, 'Web Apps', NULL, NULL, NULL, NULL),
(15, 1, 3, 23, NULL, 'SaaS', NULL, NULL, NULL, NULL),
(16, 1, 3, 24, NULL, 'lorem ipsum', NULL, NULL, NULL, NULL),
(17, 1, 3, 25, NULL, '', NULL, NULL, NULL, NULL),
(18, 1, 3, 26, NULL, 'www.nba.com', NULL, NULL, NULL, NULL),
(19, 2, 1, 2, NULL, '', NULL, NULL, NULL, NULL),
(20, 2, 1, 5, NULL, '', NULL, NULL, NULL, NULL),
(21, 2, 1, 6, NULL, '', NULL, NULL, NULL, NULL),
(22, 2, 1, 8, NULL, '', NULL, NULL, NULL, NULL),
(23, 2, 1, 10, NULL, '', NULL, NULL, NULL, NULL),
(24, 2, 1, 12, NULL, '', NULL, NULL, NULL, NULL),
(25, 2, 1, 14, NULL, '', NULL, NULL, NULL, NULL),
(26, 2, 1, 16, NULL, '', NULL, NULL, NULL, NULL),
(27, 2, 2, 2, NULL, NULL, NULL, 1, NULL, NULL),
(28, 2, 2, 5, NULL, NULL, NULL, 5, NULL, NULL),
(29, 2, 2, 6, NULL, NULL, NULL, 9, NULL, NULL),
(30, 2, 2, 8, NULL, NULL, NULL, 13, NULL, NULL),
(31, 2, 2, 10, NULL, NULL, NULL, 11, NULL, NULL),
(32, 2, 2, 12, NULL, '', NULL, NULL, NULL, NULL),
(33, 2, 2, 14, NULL, '', NULL, NULL, NULL, NULL),
(34, 2, 2, 16, NULL, '', NULL, NULL, NULL, NULL),
(35, 2, 3, 2, NULL, NULL, NULL, 1, NULL, NULL),
(36, 2, 3, 5, NULL, NULL, NULL, 5, NULL, NULL),
(37, 2, 3, 6, NULL, NULL, NULL, 9, NULL, NULL),
(38, 2, 3, 8, NULL, NULL, NULL, 13, NULL, NULL),
(39, 2, 3, 10, NULL, NULL, NULL, 11, NULL, NULL),
(40, 2, 3, 12, NULL, '', NULL, NULL, NULL, NULL),
(41, 2, 3, 14, NULL, '', NULL, NULL, NULL, NULL),
(42, 2, 3, 16, NULL, '', NULL, NULL, NULL, NULL),
(43, 1, 4, 1, NULL, NULL, NULL, 2, NULL, NULL),
(44, 1, 4, 3, NULL, NULL, NULL, 7, NULL, NULL),
(45, 1, 4, 4, NULL, NULL, NULL, 10, NULL, NULL),
(46, 1, 4, 7, NULL, NULL, NULL, 13, NULL, NULL),
(47, 1, 4, 9, NULL, NULL, NULL, 12, NULL, NULL),
(48, 1, 4, 11, NULL, '', NULL, NULL, NULL, NULL),
(49, 1, 4, 13, NULL, '', NULL, NULL, NULL, NULL),
(50, 1, 4, 15, NULL, '', NULL, NULL, NULL, NULL),
(51, 1, 4, 17, NULL, '', NULL, NULL, NULL, NULL),
(52, 1, 4, 18, NULL, '', NULL, NULL, NULL, NULL),
(53, 1, 5, 1, NULL, NULL, NULL, 1, NULL, NULL),
(54, 1, 5, 3, NULL, NULL, NULL, 5, NULL, NULL),
(55, 1, 5, 4, NULL, NULL, NULL, 9, NULL, NULL),
(56, 1, 5, 7, NULL, NULL, NULL, 13, NULL, NULL),
(57, 1, 5, 9, NULL, NULL, NULL, 11, NULL, NULL),
(58, 1, 5, 11, NULL, 'CEO', NULL, NULL, NULL, NULL),
(59, 1, 5, 13, NULL, 'German', NULL, NULL, NULL, NULL),
(60, 1, 5, 15, NULL, 'Berlin', NULL, NULL, NULL, NULL),
(61, 1, 5, 17, NULL, 'Web', NULL, NULL, NULL, NULL),
(62, 1, 5, 18, NULL, 'Web Developer', NULL, NULL, NULL, NULL),
(63, 1, 6, 1, NULL, NULL, NULL, 2, NULL, NULL),
(64, 1, 6, 3, NULL, NULL, NULL, 7, NULL, NULL),
(65, 1, 6, 4, NULL, NULL, NULL, 10, NULL, NULL),
(66, 1, 6, 7, NULL, NULL, NULL, 13, NULL, NULL),
(67, 1, 6, 9, NULL, NULL, NULL, 12, NULL, NULL),
(68, 1, 6, 11, NULL, 'CTO', NULL, NULL, NULL, NULL),
(69, 1, 6, 13, NULL, 'French', NULL, NULL, NULL, NULL),
(70, 1, 6, 15, NULL, 'Germany', NULL, NULL, NULL, NULL),
(71, 1, 6, 17, NULL, 'Web', NULL, NULL, NULL, NULL),
(72, 1, 6, 18, NULL, 'Designer', NULL, NULL, NULL, NULL),
(73, 1, 7, 1, 0, NULL, NULL, 1, NULL, NULL),
(74, 1, 7, 3, 0, NULL, NULL, 6, NULL, NULL),
(75, 1, 7, 4, 0, NULL, NULL, 9, NULL, NULL),
(76, 1, 7, 7, 0, NULL, NULL, 10, NULL, NULL),
(77, 1, 7, 9, 0, NULL, NULL, 11, NULL, NULL),
(78, 1, 7, 11, NULL, 'jt', NULL, NULL, NULL, NULL),
(79, 1, 7, 13, NULL, 'ln', NULL, NULL, NULL, NULL),
(80, 1, 7, 15, NULL, 'lc', NULL, NULL, NULL, NULL),
(81, 1, 7, 17, NULL, 'mf', NULL, NULL, NULL, NULL),
(82, 1, 7, 18, NULL, 'pr', NULL, NULL, NULL, NULL),
(83, 1, 7, 1, 1, NULL, NULL, 1, NULL, NULL),
(84, 1, 7, 3, 1, NULL, NULL, 6, NULL, NULL),
(85, 1, 7, 4, 1, NULL, NULL, 9, NULL, NULL),
(86, 1, 7, 7, 1, NULL, NULL, 13, NULL, NULL),
(87, 1, 7, 9, 1, NULL, NULL, 12, NULL, NULL),
(88, 1, 8, 1, 0, NULL, NULL, 4, NULL, NULL),
(89, 1, 8, 3, 0, NULL, NULL, 6, NULL, NULL),
(90, 1, 8, 4, 0, NULL, NULL, 10, NULL, NULL),
(91, 1, 8, 7, 0, NULL, NULL, 13, NULL, NULL),
(92, 1, 8, 9, 0, NULL, NULL, 11, NULL, NULL),
(93, 1, 8, 11, 0, 'dfgfdgd', NULL, NULL, NULL, NULL),
(94, 1, 8, 13, 0, '', NULL, NULL, NULL, NULL),
(95, 1, 8, 15, 0, '', NULL, NULL, NULL, NULL),
(96, 1, 8, 17, 0, '', NULL, NULL, NULL, NULL),
(97, 1, 8, 18, 0, '', NULL, NULL, NULL, NULL),
(98, 1, 8, 1, 1, NULL, NULL, 1, NULL, NULL),
(99, 1, 8, 3, 1, NULL, NULL, 5, NULL, NULL),
(100, 1, 8, 4, 1, NULL, NULL, 9, NULL, NULL),
(101, 1, 8, 7, 1, NULL, NULL, 13, NULL, NULL),
(102, 1, 8, 9, 1, NULL, NULL, 12, NULL, NULL),
(103, 1, 8, 11, 1, 'fdgfdg', NULL, NULL, NULL, NULL),
(104, 1, 8, 13, 1, 'dfgdfgfd', NULL, NULL, NULL, NULL),
(105, 1, 8, 15, 1, 'fdgfdgfd', NULL, NULL, NULL, NULL),
(106, 1, 8, 17, 1, 'dfg', NULL, NULL, NULL, NULL),
(107, 1, 8, 18, 1, 'dfgdfg', NULL, NULL, NULL, NULL),
(108, 1, 8, 11, 2, 'dfgdfgdfg', NULL, NULL, NULL, NULL),
(109, 1, 8, 13, 2, '', NULL, NULL, NULL, NULL),
(110, 1, 8, 15, 2, '', NULL, NULL, NULL, NULL),
(111, 1, 8, 17, 2, '', NULL, NULL, NULL, NULL),
(112, 1, 8, 18, 2, '', NULL, NULL, NULL, NULL),
(113, 1, 9, 1, 0, NULL, NULL, 1, NULL, NULL),
(114, 1, 9, 3, 0, NULL, NULL, 5, NULL, NULL),
(115, 1, 9, 4, 0, NULL, NULL, 10, NULL, NULL),
(116, 1, 9, 7, 0, NULL, NULL, 13, NULL, NULL),
(117, 1, 9, 9, 0, NULL, NULL, 12, NULL, NULL),
(118, 1, 9, 11, NULL, 'Team Leader', NULL, NULL, NULL, NULL),
(119, 1, 9, 13, NULL, 'German', NULL, NULL, NULL, NULL),
(120, 1, 9, 15, NULL, 'New York', NULL, NULL, NULL, NULL),
(121, 1, 9, 17, NULL, 'Web', NULL, NULL, NULL, NULL),
(122, 1, 9, 18, NULL, 'Pokemon Master', NULL, NULL, NULL, NULL),
(123, 1, 9, 1, 1, NULL, NULL, 2, NULL, NULL),
(124, 1, 9, 3, 1, NULL, NULL, 7, NULL, NULL),
(125, 1, 9, 4, 1, NULL, NULL, 9, NULL, NULL),
(126, 1, 9, 7, 1, NULL, NULL, 13, NULL, NULL),
(127, 1, 9, 9, 1, NULL, NULL, 11, NULL, NULL),
(128, 1, 9, 7, 2, NULL, NULL, 10, NULL, NULL),
(129, 1, 9, 9, 2, NULL, NULL, 11, NULL, NULL),
(130, 1, 10, 1, NULL, NULL, NULL, 1, NULL, NULL),
(131, 1, 10, 3, NULL, NULL, NULL, 5, NULL, NULL),
(132, 1, 10, 4, NULL, NULL, NULL, 9, NULL, NULL),
(133, 1, 10, 7, 0, NULL, NULL, 13, NULL, NULL),
(134, 1, 10, 9, 0, NULL, NULL, 12, NULL, NULL),
(135, 1, 10, 11, NULL, '', NULL, NULL, NULL, NULL),
(136, 1, 10, 13, NULL, '', NULL, NULL, NULL, NULL),
(137, 1, 10, 15, NULL, '', NULL, NULL, NULL, NULL),
(138, 1, 10, 17, NULL, '', NULL, NULL, NULL, NULL),
(139, 1, 10, 18, NULL, '', NULL, NULL, NULL, NULL),
(140, 1, 10, 7, 1, NULL, NULL, 10, NULL, NULL),
(141, 1, 10, 9, 1, NULL, NULL, 11, NULL, NULL),
(142, 1, 11, 1, NULL, NULL, NULL, 1, NULL, NULL),
(143, 1, 11, 3, NULL, NULL, NULL, 5, NULL, NULL),
(144, 1, 11, 4, NULL, NULL, NULL, 9, NULL, NULL),
(147, 1, 11, 11, NULL, '', NULL, NULL, NULL, NULL),
(148, 1, 11, 13, NULL, '', NULL, NULL, NULL, NULL),
(149, 1, 11, 15, NULL, '', NULL, NULL, NULL, NULL),
(150, 1, 11, 17, NULL, '', NULL, NULL, NULL, NULL),
(151, 1, 11, 18, NULL, '', NULL, NULL, NULL, NULL),
(154, 1, 11, 27, NULL, 'img/No-Photo.gif', 'dor.jpg', NULL, '2015-11-23 06:55:59', '2015-11-23 06:55:59'),
(160, 1, 12, 11, NULL, 'jt', NULL, NULL, NULL, NULL),
(161, 1, 12, 13, NULL, 'la', NULL, NULL, NULL, NULL),
(162, 1, 12, 15, NULL, 'lc', NULL, NULL, NULL, NULL),
(163, 1, 12, 17, NULL, 'mf', NULL, NULL, NULL, NULL),
(164, 1, 12, 18, NULL, 'pr', NULL, NULL, NULL, NULL),
(170, 1, 12, 27, NULL, 'uploads/userimgs/12/54e9d0c1bbd77 - Copy.jpg', '54e9d0c1bbd77 - Copy.jpg', NULL, '2015-11-23 08:31:03', '2015-11-23 08:31:03'),
(171, 1, 12, 1, 0, NULL, NULL, 1, NULL, NULL),
(172, 1, 12, 3, 0, NULL, NULL, 5, NULL, NULL),
(173, 1, 12, 4, 0, NULL, NULL, 9, NULL, NULL),
(174, 1, 12, 1, 1, NULL, NULL, 2, NULL, NULL),
(175, 1, 12, 3, 1, NULL, NULL, 6, NULL, NULL),
(176, 1, 12, 4, 1, NULL, NULL, 10, NULL, NULL),
(177, 1, 12, 7, 0, NULL, NULL, 13, NULL, NULL),
(178, 1, 12, 9, 0, NULL, NULL, 12, NULL, NULL),
(179, 1, 13, 19, NULL, 'AcadeME', NULL, NULL, NULL, NULL),
(180, 1, 13, 20, NULL, 'Hen West', NULL, NULL, NULL, NULL),
(181, 1, 13, 21, NULL, 'Marketing Manager', NULL, NULL, NULL, NULL),
(182, 1, 13, 22, NULL, 'web', NULL, NULL, NULL, NULL),
(183, 1, 13, 23, NULL, 'SaaS', NULL, NULL, NULL, NULL),
(184, 1, 13, 24, NULL, 'Weeb Saas all over the place', NULL, NULL, NULL, NULL),
(185, 1, 13, 25, NULL, '', NULL, NULL, NULL, NULL),
(186, 1, 13, 26, NULL, 'www.academe.com', NULL, NULL, NULL, NULL),
(187, 1, 13, 28, NULL, 'uploads/userimgs/13/לוגו.jpg', 'לוגו.jpg', NULL, '2015-11-23 08:35:03', '2015-11-23 08:35:03'),
(188, 1, 14, 19, NULL, 'AcadeME', NULL, NULL, NULL, NULL),
(189, 1, 14, 20, NULL, 'Hen West', NULL, NULL, NULL, NULL),
(190, 1, 14, 21, NULL, 'Marketing Manager', NULL, NULL, NULL, NULL),
(191, 1, 14, 22, NULL, 'Web', NULL, NULL, NULL, NULL),
(192, 1, 14, 23, NULL, 'Saas', NULL, NULL, NULL, NULL),
(193, 1, 14, 24, NULL, 'lorem ipsum m', NULL, NULL, NULL, NULL),
(194, 1, 14, 25, NULL, '', NULL, NULL, NULL, NULL),
(195, 1, 14, 26, NULL, 'www.academe.com', NULL, NULL, NULL, NULL),
(196, 1, 14, 28, NULL, 'uploads/userimgs/14/לוגו.jpg', 'לוגו.jpg', NULL, '2015-11-23 08:39:19', '2015-11-23 08:39:19'),
(197, 2, 4, 2, NULL, NULL, NULL, 1, NULL, NULL),
(198, 2, 4, 5, NULL, NULL, NULL, 5, NULL, NULL),
(199, 2, 4, 6, NULL, NULL, NULL, 9, NULL, NULL),
(200, 2, 4, 8, NULL, NULL, NULL, 13, NULL, NULL),
(201, 2, 4, 10, NULL, NULL, NULL, 11, NULL, NULL),
(202, 2, 4, 12, NULL, 'Web Developer', NULL, NULL, NULL, NULL),
(203, 2, 4, 14, NULL, 'Hebrew', NULL, NULL, NULL, NULL),
(204, 2, 4, 16, NULL, 'tel aviv', NULL, NULL, NULL, NULL),
(205, 2, 8, 2, NULL, NULL, NULL, 1, NULL, NULL),
(206, 2, 8, 5, NULL, NULL, NULL, 5, NULL, NULL),
(207, 2, 8, 6, NULL, NULL, NULL, 9, NULL, NULL),
(208, 2, 8, 8, NULL, NULL, NULL, 10, NULL, NULL),
(209, 2, 8, 10, NULL, NULL, NULL, 11, NULL, NULL),
(210, 2, 8, 12, NULL, 'dsa', NULL, NULL, NULL, NULL),
(211, 2, 8, 14, NULL, 'dsa', NULL, NULL, NULL, NULL),
(212, 2, 8, 16, NULL, 'dsa', NULL, NULL, NULL, NULL),
(213, 2, 9, 2, NULL, NULL, NULL, 1, NULL, NULL),
(214, 2, 9, 5, NULL, NULL, NULL, 5, NULL, NULL),
(215, 2, 9, 6, NULL, NULL, NULL, 9, NULL, NULL),
(216, 2, 9, 8, NULL, NULL, NULL, 13, NULL, NULL),
(217, 2, 9, 10, NULL, NULL, NULL, 11, NULL, NULL),
(218, 2, 9, 12, NULL, '', NULL, NULL, NULL, NULL),
(219, 2, 9, 14, NULL, '', NULL, NULL, NULL, NULL),
(220, 2, 9, 16, NULL, '', NULL, NULL, NULL, NULL),
(221, 2, 10, 2, NULL, NULL, NULL, 2, NULL, NULL),
(222, 2, 10, 5, NULL, NULL, NULL, 5, NULL, NULL),
(223, 2, 10, 6, NULL, NULL, NULL, 9, NULL, NULL),
(224, 2, 10, 8, NULL, NULL, NULL, 13, NULL, NULL),
(225, 2, 10, 10, NULL, NULL, NULL, 11, NULL, NULL),
(226, 2, 10, 12, NULL, '1', NULL, NULL, NULL, NULL),
(227, 2, 10, 14, NULL, '2', NULL, NULL, NULL, NULL),
(228, 2, 10, 16, NULL, '3', NULL, NULL, NULL, NULL),
(229, 2, 11, 2, NULL, NULL, NULL, 2, NULL, NULL),
(230, 2, 11, 5, NULL, NULL, NULL, 5, NULL, NULL),
(231, 2, 11, 6, NULL, NULL, NULL, 9, NULL, NULL),
(232, 2, 11, 8, NULL, NULL, NULL, 13, NULL, NULL),
(233, 2, 11, 10, NULL, NULL, NULL, 12, NULL, NULL),
(234, 2, 11, 12, NULL, '1', NULL, NULL, NULL, NULL),
(235, 2, 11, 14, NULL, '2', NULL, NULL, NULL, NULL),
(236, 2, 11, 16, NULL, '3', NULL, NULL, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `type_post`
--

INSERT INTO `type_post` (`id`, `user_id`, `title`, `description_short`, `description`, `authorized`, `created_at`, `updated_at`) VALUES
(3, 3, 'Web Dev NYU', 'dev the web', '', 1, '2015-11-17 09:21:18', '2015-11-17 09:21:18'),
(10, 14, 'Saas Dev', '', '', 1, '2015-11-23 08:51:56', '2015-11-23 08:51:56'),
(11, 14, 'Pokemon Master', '', '', 1, '2015-11-23 08:52:40', '2015-11-23 08:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `type_user`
--

CREATE TABLE IF NOT EXISTS `type_user` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('tech-admin','content-admin','user') NOT NULL DEFAULT 'user',
  `subtype` text,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `password_new` varchar(255) DEFAULT NULL,
  `first_name` varchar(15) DEFAULT NULL,
  `last_name` varchar(15) DEFAULT NULL,
  `gender` set('male','female','','') NOT NULL,
  `martial_status` varchar(255) DEFAULT NULL,
  `education_status` set('student','graduate','intern','') NOT NULL,
  `street_1` varchar(256) DEFAULT NULL,
  `city` varchar(25) DEFAULT NULL,
  `state` varchar(25) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `country` varchar(25) DEFAULT NULL,
  `phone_1` varchar(20) DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `type_user`
--

INSERT INTO `type_user` (`id`, `type`, `subtype`, `status`, `email`, `password`, `password_new`, `first_name`, `last_name`, `gender`, `martial_status`, `education_status`, `street_1`, `city`, `state`, `zipcode`, `country`, `phone_1`, `mobile`, `date_of_birth`, `registration`, `last_login`, `send_newsletters`, `send_notifications`, `created_at`, `updated_at`, `remember_token`) VALUES
(9, 'user', 'jobseeker', 'active', 'dorshoham88@gmail.com', '$2y$10$JrCG0k56cNLnxvCoqx3vjugYc3E5VgbHJuOjVqhKY2ohd.z8yJURO', NULL, 'dor', 'Shoham', 'male', 'married', 'graduate', '', 'Tel Aviv-Yafo, Israel', 'Alabama', '', 'Israel', '0542037641', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-11-23 06:33:37', 0, 0, '2015-11-22 07:14:18', '2015-11-25 10:22:23', 'psIsQyegRNZ05B3dNpPGxoRjV9D8wK2qin7WB5bmhNCpQZBgktufKNkZqHW7'),
(12, 'user', 'jobseeker', 'active', 'd@dd.dd', '$2y$10$eYMpaCCWPsLygvNyT0SISucmptQaL2prSPyTDfadSWuAWCXkP0E0y', NULL, 'Dor', 'Shoham', '', '', '', '', '', '', '', '', '0542037641', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-11-23 08:31:49', 0, 0, '2015-11-23 08:29:26', '2015-11-23 08:32:57', '8tD1JAyNafQLisk9x2IZP0JIhcJLdfKq26U61daSltlpLe19kS42squjocTP'),
(14, 'user', 'employer', 'active', 'd@d.d', '$2y$10$BnLQx7C2hMw/eUZVhfwESeEmJu/ST4CzLVPTw0eOekkPI8fOn0d0W', NULL, 'Dor', 'Shoham', '', '', '', 'HaHashmonaim 84', 'Tel Aviv', '', '47252', '', '', '0542037641', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '2015-11-23 08:39:13', '2015-11-25 10:20:58', '8bdcip6lHPqoSKiCHYyeobRXwOWWnds7Pwdgi7XpHHMXYgzcB5Yp9X2R3eJH');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doc_param`
--
ALTER TABLE `doc_param`
  ADD CONSTRAINT `doc_param_ibfk_1` FOREIGN KEY (`doc_type_id`) REFERENCES `doc_type` (`id`);

--
-- Constraints for table `param`
--
ALTER TABLE `param`
  ADD CONSTRAINT `param_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `param_type` (`id`),
  ADD CONSTRAINT `param_ibfk_2` FOREIGN KEY (`doc_param_id`) REFERENCES `doc_param` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
