-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 22. Mrz 2013 um 13:42
-- Server Version: 5.5.29
-- PHP-Version: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `nakade`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `credentials`
--

CREATE TABLE IF NOT EXISTS `credentials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT 'user ID',
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(32) COLLATE utf8_bin NOT NULL COMMENT 'md5 verschlüsseltes passwort',
  `email` varchar(120) COLLATE utf8_bin NOT NULL COMMENT 'die nakade email des accounts',
  `created` datetime NOT NULL COMMENT 'für die zeitspanne von verifikation und erstellung  ',
  `verifyString` varchar(16) COLLATE utf8_bin NOT NULL COMMENT 'zeichenkette für die benutzer email',
  `verified` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'verified flag',
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'aktives konto ',
  `firstLogin` datetime DEFAULT NULL COMMENT 'erster LogIn',
  `lastLogin` datetime DEFAULT NULL COMMENT 'letzter LogIn',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `uid` (`uid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;