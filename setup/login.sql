-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 09, 2012 at 11:38 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET NAMES utf8;

--
-- Database: `jigowatt_phplogin`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_activate`
--

CREATE TABLE IF NOT EXISTS `login_activate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login_forgot`
--

CREATE TABLE IF NOT EXISTS `login_forgot` (
  `email` varchar(255) NOT NULL,
  `code` varchar(32) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login_levels`
--

CREATE TABLE IF NOT EXISTS `login_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(255) NOT NULL,
  `level_level` int(1) NOT NULL,
  `level_disabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `level_level` (`level_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login_levels`
--

INSERT IGNORE INTO `login_levels` (`id`, `level_name`, `level_level`, `level_disabled`) VALUES
(1, 'Admin', 1, 0),
(2, 'Special', 2, 0),
(3, 'User', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `login_profiles`
--

CREATE TABLE IF NOT EXISTS `login_profiles` (
  `p_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `profile_label` varchar(255) DEFAULT NULL,
  `profile_value` longtext,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login_settings`
--

CREATE TABLE IF NOT EXISTS `login_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) NOT NULL,
  `option_value` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login_settings`
--

INSERT IGNORE INTO `login_settings` (`id`, `option_name`, `option_value`) VALUES
(1, 'site_address', 'http://jigowatt.co.uk/themeforest/login/'),
(2, 'default_session', '0'),
(3, 'admin_email', 'no-reply@jigowatt.co.uk'),
(4, 'block-msg-enable', '1'),
(5, 'block-msg', '<h1>Sorry, Hank.</h1>\r\n\r\n<p>We have detected that your user level does not entitle you to view the page requested.</p>\r\n\r\n<p>Please contact the website administrator if you feel this is in error.</p>\r\n\r\n<h5>What to do now?</h5>\r\n<p>To see this page you must <a href=''logout.php''>logout</a> and login with sufficiant privileges.</p>'),
(6, 'block-msg-out', 'You need to login to do that.'),
(7, 'block-msg-out-enable', '1'),
(8, 'email-welcome-msg', 'Hello {{full_name}} !\r\n\r\nThanks for registering at {{site_address}}. Here are your account details:\r\n\r\nName: {{full_name}}\r\nUsername: {{username}}\r\nEmail: {{email}}\r\nPassword: *hidden*\r\n\r\nYou will first have to activate your account by clicking on the following link:\r\n\r\n{{activate}}'),
(9, 'email-activate-msg', 'Hi there {{full_name}} !\r\n\r\nYour account at {{site_address}} has been successfully activated :). \r\n\r\nFor your reference, your username is <strong>{{username}}</strong>. \r\n\r\nSee you soon!'),
(10, 'email-activate-subj', 'You''ve activated your account at Jigowatt !'),
(11, 'email-activate-resend-subj', 'Here''s your activation link again for Jigowatt'),
(12, 'email-activate-resend-msg', 'Why hello, {{full_name}}. \r\n\r\nI believe you requested this:\r\n{{activate}}\r\n\r\nClick the link above to activate your account :)'),
(13, 'email-welcome-subj', 'Thanks for signing up with Jigowatt :)'),
(14, 'email-forgot-success-subj', 'Your password has been reset at Jigowatt'),
(15, 'email-forgot-success-msg', 'Welcome back, {{full_name}} !\r\n\r\nI''m just letting you know your password at {{site_address}} has been successfully changed. \r\n\r\nHopefully you were the one that requested this password reset !\r\n\r\nCheers'),
(16, 'email-forgot-subj', 'Lost your password at Jigowatt?'),
(17, 'email-forgot-msg', 'Hi {{full_name}},\r\n\r\nYour username is <strong>{{username}}</strong>.\r\n\r\nTo reset your password at Jigowatt, please click the following password reset link:\r\n{{reset}}\r\n\r\nSee you soon!'),
(18, 'email-add-user-subj', 'You''re registered with Jigowatt !'),
(19, 'email-add-user-msg', 'Hello {{full_name}} !\r\n\r\nYou''re now registered at {{site_address}}. Here are your account details:\r\n\r\nName: {{full_name}}\r\nUsername: {{username}}\r\nEmail: {{email}}\r\nPassword: {{password}}'),
(20, 'profile-fields', 'a:1:{s:11:"textarea[0]";s:3:"Bio";}'),
(21, 'pw-encrypt-force-enable', '0'),
(22, 'pw-encryption', 'MD5'),
(23, 'phplogin_db_version', '1203090');

-- --------------------------------------------------------

--
-- Table structure for table `login_users`
--

CREATE TABLE IF NOT EXISTS `login_users` (
  `user_id` int(8) NOT NULL AUTO_INCREMENT,
  `user_level` longtext NOT NULL,
  `restricted` int(1) NOT NULL DEFAULT '0',
  `username` varchar(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login_users`
--

INSERT IGNORE INTO `login_users` (`user_id`, `user_level`, `restricted`, `username`, `name`, `email`, `password`) VALUES
(1, 'a:3:{i:0;s:1:"3";i:1;s:1:"1";i:2;s:1:"2";}', 0, 'admin', 'Demo Admin', 'test.admin@jigowatt.co.uk', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'a:2:{i:0;s:1:"2";i:1;s:1:"3";}', 0, 'special', 'Demo Special', 'test.special@jigowatt.co.uk', '0bd6506986ec42e732ffb866d33bb14e'),
(3, 'a:1:{i:0;s:1:"3";}', 0, 'user', 'Demo User', 'test.user@jigowatt.co.uk', 'ee11cbb19052e40b07aac0ca060c23ee');