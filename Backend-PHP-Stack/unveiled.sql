-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 09. Mai 2016 um 22:20
-- Server-Version: 5.5.49-0ubuntu0.14.04.1
-- PHP-Version: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `unveiled`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `error_log`
--

CREATE TABLE `error_log` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `level` int(11) NOT NULL,
  `filename` varchar(127) NOT NULL,
  `classname` varchar(63) NOT NULL,
  `functionname` varchar(63) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `caption` varchar(160) COLLATE latin1_german2_ci NOT NULL,
  `filename` varchar(100) COLLATE latin1_german2_ci NOT NULL,
  `file_url` text COLLATE latin1_german2_ci NOT NULL,
  `thumbnail_url` text COLLATE latin1_german2_ci NOT NULL,
  `mediatype` varchar(20) COLLATE latin1_german2_ci NOT NULL,
  `uploaded_at` int(11) NOT NULL,
  `size` int(11) NOT NULL COMMENT 'byte',
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `public` tinyint(1) NOT NULL COMMENT '0=false, 1=true',
  `verified` tinyint(1) NOT NULL COMMENT '0=false, 1=true',
  `length` int(11) NOT NULL COMMENT 'sec',
  `resolution` varchar(256) COLLATE latin1_german2_ci NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `code` varchar(11) COLLATE latin1_german2_ci NOT NULL,
  `type` varchar(2) COLLATE latin1_german2_ci NOT NULL,
  `msg` text COLLATE latin1_german2_ci NOT NULL,
  `language` varchar(2) COLLATE latin1_german2_ci NOT NULL DEFAULT 'DE' COMMENT 'DE, EN'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

--
-- Daten für Tabelle `messages`
--

INSERT INTO `messages` (`id`, `code`, `type`, `msg`, `language`) VALUES
(1, 'S001', 'E', 'Fehlende Parameter.', 'DE'),
(2, 'A001', 'S', 'Nutzer wurde erfolgreich angelegt.', 'DE'),
(3, 'S001', 'E', 'Fehlende Parameter.', 'DE'),
(4, 'A001', 'S', 'Nutzer wurde erfolgreich angelegt.', 'DE'),
(5, 'A002', 'E', 'Dieser Nutzer existiert bereits.', 'DE'),
(6, 'A003', 'S', 'Nutzer erfolgreich eingeloggt.', 'DE'),
(7, 'A002', 'E', 'Dieser Nutzer existiert bereits.', 'DE'),
(8, 'A003', 'S', 'Nutzer erfolgreich eingeloggt.', 'DE'),
(9, 'A004', 'E', 'Email oder Passwort falsch.', 'DE'),
(10, 'A005', 'E', 'Sie müssen eingeloggt sein um diese Aktion durchzuführen.', 'DE'),
(11, 'A004', 'E', 'Email oder Passwort falsch.', 'DE'),
(12, 'A005', 'E', 'Sie müssen eingeloggt sein um diese Aktion durchzuführen.', 'DE'),
(13, 'A006', 'S', 'Nutzer würde erfolgreich ausgeloggt.', 'DE'),
(14, 'A007', 'S', 'Aktion wurde erfolgreich durchgeführt.', 'DE'),
(15, 'A006', 'S', 'Nutzer würde erfolgreich ausgeloggt.', 'DE'),
(16, 'A007', 'S', 'Aktion wurde erfolgreich durchgeführt.', 'DE'),
(17, 'A008', 'E', 'Sie haben nicht die Berechtigung diese Aktion durchzuführen.', 'DE'),
(18, 'A009', 'S', 'Daten wurden erfolgreich gespeichert.', 'DE'),
(19, 'A010', 'E', 'Fehler beim Speichern der Daten.', 'DE'),
(20, 'A011', 'E', 'Der angeforderte Nutzer existiert nicht.', 'DE'),
(21, 'A010', 'E', 'Fehler beim Speichern der Daten.', 'DE'),
(22, 'A011', 'E', 'Der angeforderte Nutzer existiert nicht.', 'DE'),
(23, 'A012', 'S', 'Das alte Passwort ist nicht korrekt.', 'DE'),
(24, 'A012', 'S', 'Das alte Passwort ist nicht korrekt.', 'DE');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(127) NOT NULL,
  `email` varchar(127) NOT NULL,
  `email_notification_flag` int(1) NOT NULL,
  `password` varchar(127) NOT NULL,
  `token` varchar(127) NOT NULL,
  `last_ip` varchar(127) NOT NULL,
  `last_login` int(11) NOT NULL,
  `permission` int(2) NOT NULL COMMENT '0=Read, 1=R&W, 2=Mod, 3=Admin',
  `acc_active` int(1) NOT NULL DEFAULT '1',
  `acc_approved` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `error_log`
--
ALTER TABLE `error_log`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indizes für die Tabelle `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`,`token`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `error_log`
--
ALTER TABLE `error_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `user` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
