-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2019 at 10:05 AM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webview`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_table`
--

CREATE TABLE `activity_table` (
  `activity_id` int(11) NOT NULL,
  `activity_user_id` int(11) NOT NULL,
  `activity_agent` varchar(60) NOT NULL,
  `activity_time` varchar(20) NOT NULL,
  `activity_ip` varchar(15) NOT NULL,
  `activity_login_status` tinyint(1) NOT NULL COMMENT '1: Success | 2: UnSuccess',
  `activity_desc` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Activity Table';

--
-- Dumping data for table `activity_table`
--

INSERT INTO `activity_table` (`activity_id`, `activity_user_id`, `activity_agent`, `activity_time`, `activity_ip`, `activity_login_status`, `activity_desc`) VALUES
(1, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/201', '1563604719', '::1', 1, 'User login into the Dashboard.'),
(2, 3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '1563607395', '::1', 1, 'User login into the Dashboard.');

-- --------------------------------------------------------

--
-- Table structure for table `api_table`
--

CREATE TABLE `api_table` (
  `api_id` int(11) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `api_status` tinyint(1) NOT NULL COMMENT '0: Inactive | 1: Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='API Table';

--
-- Dumping data for table `api_table`
--

INSERT INTO `api_table` (`api_id`, `api_key`, `api_status`) VALUES
(1, 'UQZQcFU2UhdXZgE3BklXMAE0UjoBBlJKU21dbgRgBzcAOAZ9WUYBPVA0W2ZQSFU7XHwANlcLBjQ-', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookmark_table`
--

CREATE TABLE `bookmark_table` (
  `bookmark_id` int(11) NOT NULL,
  `bookmark_user_id` int(11) NOT NULL,
  `bookmark_content_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Bookmark Table';

-- --------------------------------------------------------

--
-- Table structure for table `captcha_table`
--

CREATE TABLE `captcha_table` (
  `captcha_id` bigint(13) UNSIGNED NOT NULL,
  `captcha_time` int(10) UNSIGNED NOT NULL,
  `captcha_ip_address` varchar(45) NOT NULL,
  `captcha_word` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `captcha_table`
--

INSERT INTO `captcha_table` (`captcha_id`, `captcha_time`, `captcha_ip_address`, `captcha_word`) VALUES
(1038, 1563607390, '::1', '87170');

-- --------------------------------------------------------

--
-- Table structure for table `content_table`
--

CREATE TABLE `content_table` (
  `content_id` int(11) NOT NULL,
  `content_user_id` int(11) NOT NULL,
  `content_title` varchar(120) NOT NULL,
  `content_sub_title` varchar(120) DEFAULT NULL,
  `content_description` mediumtext DEFAULT NULL,
  `content_property1` varchar(100) NOT NULL COMMENT 'Custom Property',
  `content_property2` varchar(100) NOT NULL,
  `content_orientation` tinyint(1) NOT NULL COMMENT '1: It does not matter | 2: portrait | 3: landscape',
  `content_primary_color` varchar(30) DEFAULT '#4CAF50',
  `content_dark_color` varchar(30) DEFAULT '#388E3C',
  `content_accent_color` varchar(30) DEFAULT '#CDDC39',
  `content_type_id` tinyint(4) NOT NULL,
  `content_access` tinyint(1) NOT NULL COMMENT '1: Indirect Access | 2: Direct Access',
  `content_category_id` smallint(6) NOT NULL,
  `content_user_role_id` tinyint(4) NOT NULL,
  `content_image` varchar(100) DEFAULT NULL,
  `content_url` varchar(200) NOT NULL,
  `content_url1` varchar(255) DEFAULT NULL,
  `content_url2` varchar(255) DEFAULT NULL,
  `content_url3` varchar(255) DEFAULT NULL,
  `content_url4` varchar(255) DEFAULT NULL,
  `content_url5` varchar(255) DEFAULT NULL,
  `content_url1_text` varchar(40) DEFAULT NULL,
  `content_url2_text` varchar(40) DEFAULT NULL,
  `content_url3_text` varchar(40) DEFAULT NULL,
  `content_url4_text` varchar(40) DEFAULT NULL,
  `content_url5_text` varchar(40) DEFAULT NULL,
  `content_email` varchar(120) NOT NULL,
  `content_viewed` int(11) NOT NULL,
  `content_featured` tinyint(1) NOT NULL COMMENT '0: Not Featured | 1: Featured',
  `content_special` tinyint(1) NOT NULL COMMENT '0: Not Special | 1: Special',
  `content_publish_date` varchar(20) NOT NULL,
  `content_publish_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `content_expired_date` varchar(20) NOT NULL,
  `content_order` int(11) NOT NULL DEFAULT 1,
  `content_rtl` tinyint(1) NOT NULL COMMENT '0: Disable | 1: Enable',
  `content_fullscreen` tinyint(1) NOT NULL COMMENT '0: Disable | 1: Enable',
  `content_toolbar` tinyint(1) NOT NULL COMMENT '0: Disable | 1: Enable',
  `content_banner_ads` tinyint(1) NOT NULL COMMENT '0: Disable | 1: Enable',
  `content_interstitial_ads` tinyint(1) NOT NULL COMMENT '0: Disable | 1: Enable',
  `content_admob_app_id` varchar(200) DEFAULT NULL,
  `content_admob_banner_unit_id` varchar(200) DEFAULT NULL,
  `content_admob_interstitial_unit_id` varchar(200) DEFAULT NULL,
  `content_menu` tinyint(1) NOT NULL COMMENT '0: Disable | 1: Enable',
  `content_loader` varchar(10) NOT NULL DEFAULT 'pull' COMMENT 'pull | dialog | hide',
  `content_pull_to_refresh` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: Disable | 1: Enable',
  `content_onesignal_app_id` varchar(255) NOT NULL,
  `content_onesignal_rest_api_key` varchar(255) NOT NULL,
  `content_status` tinyint(1) NOT NULL COMMENT '0: Inactive | 1: Active | 2: Expired'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Item Tables';

--
-- Dumping data for table `content_table`
--

INSERT INTO `content_table` (`content_id`, `content_user_id`, `content_title`, `content_sub_title`, `content_description`, `content_property1`, `content_property2`, `content_orientation`, `content_primary_color`, `content_dark_color`, `content_accent_color`, `content_type_id`, `content_access`, `content_category_id`, `content_user_role_id`, `content_image`, `content_url`, `content_url1`, `content_url2`, `content_url3`, `content_url4`, `content_url5`, `content_url1_text`, `content_url2_text`, `content_url3_text`, `content_url4_text`, `content_url5_text`, `content_email`, `content_viewed`, `content_featured`, `content_special`, `content_publish_date`, `content_publish_timestamp`, `content_expired_date`, `content_order`, `content_rtl`, `content_fullscreen`, `content_toolbar`, `content_banner_ads`, `content_interstitial_ads`, `content_admob_app_id`, `content_admob_banner_unit_id`, `content_admob_interstitial_unit_id`, `content_menu`, `content_loader`, `content_pull_to_refresh`, `content_onesignal_app_id`, `content_onesignal_rest_api_key`, `content_status`) VALUES
(100, 1, 'Multi WebView', 'webview.inw24.com', NULL, 'p1', 'p2', 1, '#4caf50', '#388e3c', '#cddc39', 0, 1, 0, 0, '9759a0f1a4826bb90d77622a6e4a0ce2.png', 'http://webview.inw24.com/assets/webview/home.html', 'http://webview.inw24.com/assets/webview/interactive.html', 'http://webview.inw24.com/assets/webview/features.html', 'http://webview.inw24.com/assets/webview/about.html', 'https://www.Google.com', '', 'Interactive HTML', 'Features', 'About App', 'Google.com', '', 'inw24.com@gmail.com', 28, 0, 0, '1563604873', '2019-07-20 06:41:13', '2352004873', 1, 0, 0, 1, 0, 1, 'ca-app-pub-3940256099942544~3347511713', 'ca-app-pub-3940256099942544/6300978111', 'ca-app-pub-3940256099942544/1033173712', 1, 'pull', 1, '', '', 1),
(101, 3, 'CodeIgniter', 'www.codeigniter.com', NULL, 'p1', 'p2', 2, '#4caf50', '#388e3c', '#cddc39', 0, 1, 0, 0, '380eadb242c8969db50f4d95eec5f616.jpg', 'https://www.codeigniter.com', 'https://www.codeigniter.com/download', 'https://www.codeigniter.com/docs', 'https://www.codeigniter.com/community', 'https://www.codeigniter.com/contribute', '', 'Download', 'Documentation', 'Community', 'Contribute', '', 'test@codeigniter.com', 0, 0, 0, '1563607340', '2019-07-20 07:22:20', '2352007340', 1, 0, 0, 0, 0, 0, '', '', '', 1, 'pull', 1, '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `currency_table`
--

CREATE TABLE `currency_table` (
  `currency_id` int(11) NOT NULL,
  `currency_code` varchar(5) NOT NULL COMMENT 'eg. IRR, USD, GBP, etc...',
  `currency_prefix` varchar(15) NOT NULL,
  `currency_suffix` varchar(15) NOT NULL,
  `currency_decimals` tinyint(1) NOT NULL,
  `currency_rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Currency Table';

--
-- Dumping data for table `currency_table`
--

INSERT INTO `currency_table` (`currency_id`, `currency_code`, `currency_prefix`, `currency_suffix`, `currency_decimals`, `currency_rate`) VALUES
(1, 'USD', '', '$', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_setting_table`
--

CREATE TABLE `email_setting_table` (
  `email_setting_id` tinyint(4) NOT NULL,
  `email_setting_mailtype` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_smtpport` smallint(6) NOT NULL,
  `email_setting_smtphost` varchar(60) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_smtpuser` varchar(60) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_smtppass` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_crypto` varchar(5) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_fromname` varchar(40) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_fromemail` varchar(60) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_cc` varchar(60) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_signature` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `email_setting_status` tinyint(1) NOT NULL COMMENT '0: Disable | 1: Enable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='Email Setting Table';

--
-- Dumping data for table `email_setting_table`
--

INSERT INTO `email_setting_table` (`email_setting_id`, `email_setting_mailtype`, `email_setting_smtpport`, `email_setting_smtphost`, `email_setting_smtpuser`, `email_setting_smtppass`, `email_setting_crypto`, `email_setting_fromname`, `email_setting_fromemail`, `email_setting_cc`, `email_setting_signature`, `email_setting_status`) VALUES
(1, 'mail', 0, '', '', 'XG0HY1UxATcDZgY3', 'none', 'inw24', 'inw24.com@gmail.com', '', 'Best Regards,<br>\r\nwww.inw24.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `onesignal_table`
--

CREATE TABLE `onesignal_table` (
  `onesignal_id` int(11) NOT NULL,
  `onesignal_content_id` int(11) NOT NULL,
  `onesignal_app_id` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `onesignal_rest_api_key` varchar(255) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='OneSignal Table';

-- --------------------------------------------------------

--
-- Table structure for table `page_table`
--

CREATE TABLE `page_table` (
  `page_id` int(11) NOT NULL,
  `page_title` varchar(100) NOT NULL,
  `page_slug` varchar(100) NOT NULL,
  `page_type` tinyint(2) NOT NULL COMMENT '1:News | 2: Annunciation | 3: Page | 4: Version',
  `page_content` mediumtext NOT NULL,
  `page_image` varchar(60) NOT NULL,
  `page_keyword` varchar(100) NOT NULL,
  `page_publish_time` varchar(15) NOT NULL,
  `page_status` tinyint(4) NOT NULL COMMENT '0:Inactive | 1: Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Page Table';

--
-- Dumping data for table `page_table`
--

INSERT INTO `page_table` (`page_id`, `page_title`, `page_slug`, `page_type`, `page_content`, `page_image`, `page_keyword`, `page_publish_time`, `page_status`) VALUES
(1, 'Version 1.0.0', 'version-100', 4, '<p><code class=\"html plain\">Version 1.0.0 - July 25th, 2019</code></p>\r\n<p><code class=\"html plain\">- Initial release.</code></p>', '', '', '1543731622', 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting_table`
--

CREATE TABLE `setting_table` (
  `setting_id` int(11) NOT NULL,
  `setting_app_name` varchar(50) NOT NULL,
  `setting_app_desc` varchar(100) NOT NULL,
  `setting_website` varchar(50) NOT NULL,
  `setting_email` varchar(50) NOT NULL,
  `setting_phone1` varchar(15) NOT NULL,
  `setting_phone2` varchar(15) NOT NULL,
  `setting_phone3` varchar(15) NOT NULL,
  `setting_sms_no` varchar(20) NOT NULL,
  `setting_address` varchar(100) NOT NULL,
  `setting_logo` varchar(50) NOT NULL,
  `setting_favicon` varchar(50) NOT NULL,
  `setting_version_code` smallint(6) NOT NULL,
  `setting_version_string` varchar(25) NOT NULL,
  `setting_skype` varchar(60) NOT NULL,
  `setting_telegram` varchar(60) NOT NULL,
  `setting_whatsapp` varchar(60) NOT NULL,
  `setting_instagram` varchar(60) NOT NULL,
  `setting_facebook` varchar(60) NOT NULL,
  `setting_twiiter` varchar(60) NOT NULL,
  `setting_custom1` varchar(60) NOT NULL,
  `setting_custom2` varchar(60) NOT NULL,
  `setting_one_signal_app_id` varchar(255) NOT NULL,
  `setting_one_signal_rest_api_key` varchar(255) NOT NULL,
  `setting_text_maintenance` varchar(255) NOT NULL,
  `setting_site_maintenance` tinyint(1) NOT NULL COMMENT '0: No | 1: Yes',
  `setting_android_maintenance` tinyint(1) NOT NULL COMMENT '0: No | 1: Yes',
  `setting_ios_maintenance` tinyint(1) NOT NULL COMMENT '0: No | 1: Yes',
  `setting_other_maintenance` tinyint(1) NOT NULL COMMENT '0: No | 1: Yes',
  `setting_disable_registration` tinyint(1) NOT NULL COMMENT '0: No | 1: Yes',
  `setting_checking` int(11) NOT NULL,
  `setting_pc` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Setting Table';

--
-- Dumping data for table `setting_table`
--

INSERT INTO `setting_table` (`setting_id`, `setting_app_name`, `setting_app_desc`, `setting_website`, `setting_email`, `setting_phone1`, `setting_phone2`, `setting_phone3`, `setting_sms_no`, `setting_address`, `setting_logo`, `setting_favicon`, `setting_version_code`, `setting_version_string`, `setting_skype`, `setting_telegram`, `setting_whatsapp`, `setting_instagram`, `setting_facebook`, `setting_twiiter`, `setting_custom1`, `setting_custom2`, `setting_one_signal_app_id`, `setting_one_signal_rest_api_key`, `setting_text_maintenance`, `setting_site_maintenance`, `setting_android_maintenance`, `setting_ios_maintenance`, `setting_other_maintenance`, `setting_disable_registration`, `setting_checking`, `setting_pc`) VALUES
(1, 'Multi WebView', 'Multi WebView + Admin Panel', 'http://webview.inw24.com', 'inw24.com@gmail.com', '', '', '', '', '', '', '', 7, '1.9.0', '1', '2', '3', '4', '5', '6', '7', '8', 'UmBQNgRqV2ZdOQg~Bj4AZ1J7VDAGMFAzUWIMIVZiVzUPZVMxD3xWa11uWzQGNFd4AWcAPlM4VzQFMwdgVT5QM1M9AWdWNVc0', 'UR9RQAUIUD4DHAdHAEAHZlYfVCxcaQwqVlpbHFYHDzwOT1MrC2VWYlEIWlgOEw9hVUkBUQxHBj5TDlQCVUIFI1JKDnRfFQRvBkdQOwkVUjtRHFFDBRRQPwMeB0QARAct', 'We are under maintenance mode. Please try again later.', 1, 0, 1, 1, 1, 17, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role_table`
--

CREATE TABLE `user_role_table` (
  `user_role_id` smallint(6) NOT NULL,
  `user_type_id` smallint(6) NOT NULL,
  `user_role_title` varchar(30) NOT NULL,
  `user_role_price` float NOT NULL,
  `user_role_permission` text NOT NULL COMMENT 'Seprrate laste segment with |',
  `user_role_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1: Active | 2: Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User Role Table';

--
-- Dumping data for table `user_role_table`
--

INSERT INTO `user_role_table` (`user_role_id`, `user_type_id`, `user_role_title`, `user_role_price`, `user_role_permission`, `user_role_status`) VALUES
(1, 1, 'Super Admin', 0, 'No need to set permission for Super Admin.', 1),
(2, 1, 'Admin', 0, 'index users_list show_user add_user delete_user users_role delete_role general_settings email_settings pages add_page delete_page edit_page users_activity content_list add_content edit_content delete_content push_notification', 1),
(3, 1, 'Employee', 0, 'index users_list show_user add_user delete_user users_role delete_role general_settings email_settings pages add_page delete_page edit_page users_activity content_list add_content edit_content delete_content push_notification', 1),
(4, 1, 'Admin Demo', 0, 'index users_list show_user add_user users_role general_settings email_settings pages add_page edit_page users_activity content_list add_content edit_content push_notification', 1),
(5, 2, 'Regular User', 0, 'index content_list edit_content add_content push_notification', 1),
(6, 2, 'VIP User', 0, 'index content_list edit_content add_content push_notification', 1),
(7, 2, 'User Demo', 0, 'index content_list edit_content add_content push_notification', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `user_image` varchar(80) NOT NULL DEFAULT 'avatar.png',
  `user_credit` float NOT NULL,
  `user_coin` int(11) NOT NULL,
  `user_type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1: Staff | 2: User | 3: Guest',
  `user_role_id` smallint(6) NOT NULL DEFAULT 5,
  `user_duration` int(11) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_mobile` varchar(15) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Deactive | 1: Active',
  `user_reg_date` varchar(12) NOT NULL,
  `user_last_login` varchar(12) NOT NULL,
  `user_reg_from` tinyint(1) NOT NULL COMMENT '1: Admin | 2: Website | 3: Android | 4: iOS | 5: Other',
  `user_note` text NOT NULL,
  `user_referral` int(11) NOT NULL,
  `user_mobile_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: No| 1: Yes',
  `user_email_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: No| 1: Yes',
  `user_document_verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: No| 1: Yes',
  `user_online` tinyint(1) NOT NULL COMMENT '0: Offline | 1: Online'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User Table';

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `user_username`, `user_firstname`, `user_lastname`, `user_image`, `user_credit`, `user_coin`, `user_type`, `user_role_id`, `user_duration`, `user_email`, `user_password`, `user_mobile`, `user_phone`, `user_status`, `user_reg_date`, `user_last_login`, `user_reg_from`, `user_note`, `user_referral`, `user_mobile_verified`, `user_email_verified`, `user_document_verified`, `user_online`) VALUES
(1, 'admin', 'Demo', 'Admin', '886f1f2b7244ab0ee3f763dfd37bef3d.jpg', 0, 0, 1, 1, 0, 'inw24.com@gmail.com', 'd21933a6ee50e4dcaa8424f85582c3f51abf6379', '920', '', 0, '1542740963', '', 0, '', 0, 0, 0, 0, 0),
(2, 'demoadmin', 'Demo', 'Admin', 'avatar.png', 0, 0, 1, 4, 0, 'demoadmin@gmail.com', 'd21933a6ee50e4dcaa8424f85582c3f51abf6379', '919', '', 0, '1552569558', '', 0, '', 1, 0, 0, 0, 0),
(3, 'demouser', 'Demo', 'User', 'avatar.png', 0, 0, 2, 7, 0, 'demouser@gmail.com', 'd21933a6ee50e4dcaa8424f85582c3f51abf6379', '918', '', 0, '1552569577', '', 0, '', 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_type_table`
--

CREATE TABLE `user_type_table` (
  `user_type_id` smallint(6) NOT NULL COMMENT '1: Staff | 2: User | 3: Guest',
  `user_type_title` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User Type Table';

--
-- Dumping data for table `user_type_table`
--

INSERT INTO `user_type_table` (`user_type_id`, `user_type_title`) VALUES
(1, 'Staff'),
(2, 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_table`
--
ALTER TABLE `activity_table`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `api_table`
--
ALTER TABLE `api_table`
  ADD PRIMARY KEY (`api_id`);

--
-- Indexes for table `bookmark_table`
--
ALTER TABLE `bookmark_table`
  ADD PRIMARY KEY (`bookmark_id`);

--
-- Indexes for table `captcha_table`
--
ALTER TABLE `captcha_table`
  ADD PRIMARY KEY (`captcha_id`),
  ADD KEY `captcha_word` (`captcha_word`);

--
-- Indexes for table `content_table`
--
ALTER TABLE `content_table`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `currency_table`
--
ALTER TABLE `currency_table`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `email_setting_table`
--
ALTER TABLE `email_setting_table`
  ADD PRIMARY KEY (`email_setting_id`);

--
-- Indexes for table `onesignal_table`
--
ALTER TABLE `onesignal_table`
  ADD PRIMARY KEY (`onesignal_id`);

--
-- Indexes for table `page_table`
--
ALTER TABLE `page_table`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `setting_table`
--
ALTER TABLE `setting_table`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `user_role_table`
--
ALTER TABLE `user_role_table`
  ADD PRIMARY KEY (`user_role_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_type_table`
--
ALTER TABLE `user_type_table`
  ADD PRIMARY KEY (`user_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_table`
--
ALTER TABLE `activity_table`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `api_table`
--
ALTER TABLE `api_table`
  MODIFY `api_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookmark_table`
--
ALTER TABLE `bookmark_table`
  MODIFY `bookmark_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `captcha_table`
--
ALTER TABLE `captcha_table`
  MODIFY `captcha_id` bigint(13) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1039;

--
-- AUTO_INCREMENT for table `content_table`
--
ALTER TABLE `content_table`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `currency_table`
--
ALTER TABLE `currency_table`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_setting_table`
--
ALTER TABLE `email_setting_table`
  MODIFY `email_setting_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `onesignal_table`
--
ALTER TABLE `onesignal_table`
  MODIFY `onesignal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_table`
--
ALTER TABLE `page_table`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `setting_table`
--
ALTER TABLE `setting_table`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_role_table`
--
ALTER TABLE `user_role_table`
  MODIFY `user_role_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_type_table`
--
ALTER TABLE `user_type_table`
  MODIFY `user_type_id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT '1: Staff | 2: User | 3: Guest', AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
