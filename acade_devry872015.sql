-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2015 at 09:11 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `doc_param`
--

INSERT INTO `doc_param` (`id`, `name`, `slug`, `doc_type_id`, `doc_sub_type`, `created_at`, `updated_at`) VALUES
(1, 'education', 'Education', 1, 'jobSeeker', NULL, NULL),
(2, 'language_skills', 'Language Skills', 1, 'jobSeeker', '2015-06-14 09:16:06', '2015-06-14 09:24:36'),
(4, 'files', 'Files', 1, 'jobSeeker', NULL, NULL),
(8, 'experience', 'Experience', 1, 'jobSeeker', '2015-07-02 12:21:49', '2015-07-02 12:21:49'),
(9, 'company', 'Company', 1, 'employer', '2015-07-06 08:11:17', '2015-07-06 08:11:17'),
(13, 'files', 'Files', 1, 'employer', NULL, NULL),
(14, 'company', 'Company', 2, 'employer', NULL, NULL);

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
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type_id` mediumint(9) DEFAULT NULL,
  `doc_param_id` mediumint(9) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doc_param_id` (`doc_param_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `param`
--

INSERT INTO `param` (`id`, `name`, `slug`, `type_id`, `doc_param_id`, `created_at`, `updated_at`) VALUES
(1, 'institute', 'Institute', 1, 1, NULL, NULL),
(2, 'degree', 'Degree', 1, 1, '2015-06-14 09:16:49', '2015-06-14 09:21:30'),
(3, 'language', 'Language', 1, 2, '2015-06-14 09:18:06', '2015-06-14 09:21:29'),
(4, 'user_photo', 'User Photo', 1, 4, NULL, NULL),
(5, 'profile_pic', 'Profile Picture', 3, 4, NULL, NULL),
(15, 'company_name', 'Company Name', 1, 9, NULL, NULL),
(17, 'company_logo', 'Company Logo', 1, 13, NULL, NULL),
(18, 'job_description', 'Job Description', 1, 14, NULL, NULL),
(19, 'main_field', 'Main Field', 1, 14, NULL, NULL),
(20, 'user_photo', 'User Photo', 1, 13, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `param_type`
--

INSERT INTO `param_type` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'text', NULL, NULL),
(2, 'select', NULL, NULL),
(3, 'file', NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `param_value`
--

INSERT INTO `param_value` (`id`, `param_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 'UC San Diego', '2015-06-14 12:27:45', '2015-06-14 12:27:45'),
(2, 3, 'Hebrew', '2015-06-14 09:28:03', '2015-06-14 09:28:03');

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
  `ref_user_id` mediumint(9) unsigned NOT NULL,
  `param_id` mediumint(9) NOT NULL,
  `iteration` tinyint(4) DEFAULT NULL,
  `value_short` text,
  `value_long` text,
  `value_ref` int(9) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doc_type` (`doc_type`,`ref_user_id`,`param_id`),
  KEY `doc_type_2` (`doc_type`),
  KEY `ref_user_id` (`ref_user_id`),
  KEY `param_id` (`param_id`),
  KEY `ref_user_id_2` (`ref_user_id`),
  KEY `value_ref` (`value_ref`),
  KEY `doc_type_3` (`doc_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=451 ;

--
-- Dumping data for table `sys_param_values`
--

INSERT INTO `sys_param_values` (`id`, `doc_type`, `ref_user_id`, `param_id`, `iteration`, `value_short`, `value_long`, `value_ref`, `created_at`, `updated_at`) VALUES
(443, 1, 166, 15, NULL, NULL, NULL, NULL, NULL, NULL),
(444, 1, 166, 17, NULL, 'uploads/userimgs/166/לוגו.jpg', 'לוגו.jpg', NULL, '2015-07-07 11:20:14', '2015-07-07 11:20:14'),
(445, 1, 167, 15, NULL, NULL, NULL, NULL, NULL, NULL),
(446, 1, 167, 4, NULL, NULL, NULL, NULL, NULL, NULL),
(447, 1, 168, 15, NULL, 'AcadeME', NULL, NULL, NULL, NULL),
(448, 1, 168, 4, NULL, 'uploads/userimgs/168/dor.jpg', NULL, NULL, NULL, NULL),
(449, 1, 168, 17, NULL, 'uploads/userimgs/168/לוגו.jpg', 'לוגו.jpg', NULL, '2015-07-07 11:45:21', '2015-07-07 11:45:21'),
(450, 1, 168, 4, NULL, 'uploads/userimgs/168/dor.jpg', 'dor.jpg', NULL, '2015-07-07 11:45:25', '2015-07-07 11:45:25');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `type_post`
--

INSERT INTO `type_post` (`id`, `user_id`, `title`, `description_short`, `description`, `authorized`, `created_at`, `updated_at`) VALUES
(1, 160, 'NEW JOB', 'this is a new job for  saving blah brap brap brap ', 'descibe longggggggg', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
  `registration` timestamp NULL DEFAULT '0000-00-00 00:00:00',
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=169 ;

--
-- Dumping data for table `type_user`
--

INSERT INTO `type_user` (`id`, `type`, `subtype`, `status`, `email`, `password`, `password_new`, `first_name`, `last_name`, `street_1`, `street_2`, `city`, `state`, `zipcode`, `country`, `phone_1`, `phone_2`, `mobile`, `date_of_birth`, `registration`, `last_login`, `send_newsletters`, `send_notifications`, `created_at`, `updated_at`, `remember_token`) VALUES
(160, 'tech-admin', 'employer', 'inactive', 'd@s.q', '$2y$10$unCQL.vgw5LWU27fLfLrYOrLhf3nyUUjiS1TXkytFiIj5Iw37eq.O', NULL, 'd', 's', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-07-07 04:12:40', 0, 0, '2015-07-06 14:42:58', '2015-07-07 07:11:31', 'hmioCtoyq79cAlJeGfA2gbCoPasi9xANlFFIkLpaCdNtKXLWYUrW9Lsr01Ou'),
(164, 'tech-admin', 'jobSeeker', 'inactive', 'dorshoham1234@gmail.com', '$2y$10$s24DONi503nehz3msEcCI.RMO3r9mZfn8zdSlkX6kD0EdYApKOY7S', NULL, 'dor', 'shoham', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-07-07 08:53:06', 0, 0, '2015-07-07 12:09:35', '2015-07-07 12:09:35', 'b6GxgzNPcpKvobzDcpbBx3XTecRv3e3mHKQrS8E5sFdb7VtUlIpm5kXsyexQ'),
(168, 'tech-admin', 'employer', 'active', 'dorshoham88@gmail.com', '$2y$10$ZPvBDHBrMLsRC0.2pHT7qudoebeeh8Jz6XIU1c9HB4ocxCHMmS.GK', NULL, 'dor', 'shoham', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2015-07-07 11:54:46', 0, 0, '2015-07-07 11:45:08', '2015-07-07 11:54:46', '');

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