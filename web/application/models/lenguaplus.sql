-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 07-01-2014 a las 05:23:53
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de datos: `tmm_porfolio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `langtracker`
--

CREATE TABLE IF NOT EXISTS `langtracker` (
  `langtracker_id` int(11) NOT NULL AUTO_INCREMENT,
  `langtracker_key` varchar(4000) COLLATE utf8_unicode_ci NOT NULL,
  `langtracker_type` enum('ugc','msg') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'msg',
  `langtracker_file` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `langtracker_linenum` int(4) NOT NULL,
  `langtracker_url` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `langtracker_host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `langtracker_es` varchar(4000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `langtracker_en` varchar(4000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `langtracker_language` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `langtracker_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'debug',
  `langtracker_added` int(11) DEFAULT NULL,
  `langtracker_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`langtracker_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=492 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmt_sessions`
--

CREATE TABLE IF NOT EXISTS `tmt_sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` varchar(4000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`),
  KEY `ip_address` (`ip_address`),
  KEY `user_agent` (`user_agent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `user_passhash` varchar(32) NOT NULL,
  `user_screenname` varchar(32) NOT NULL,
  `user_status` int(11) DEFAULT NULL COMMENT '-1 is deleted, 0 is unverified, 1 is extra space, 2 is normal user, 10 is GOD',
  `user_last_login` int(11) DEFAULT NULL,
  `user_2ndlast_login` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `users_status_key` (`user_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

---
INSERT INTO `users` (`user_id`, `user_email`, `user_passhash`, `user_screenname`, `user_status`, `user_last_login`, `user_2ndlast_login`) VALUES
(1, 'eli@taylormadetraffic.com', 'df749b0c433f2d82151488ab8861c200', 'Eli Taylor', 10, 1389042155, 1389041565);


# temp1234
UPDATE users SET user_passhash = '03fdaba43a6202f9418df497937761a0' WHERE user_email = 'eli@taylormadetraffic.com'
