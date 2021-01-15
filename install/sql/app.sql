-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 25 Lis 2020, 14:41
-- Wersja serwera: 10.3.25-MariaDB-0+deb10u1
-- Wersja PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `app`
--
CREATE DATABASE IF NOT EXISTS `app` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `app`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NULL DEFAULT current_timestamp(),
  `role` enum('user','admin','worker') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `baned` tinyint(1) NOT NULL DEFAULT 0,
  `closed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tabela Truncate przed wstawieniem `user`
--

TRUNCATE TABLE `user`;
--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `email`, `pass`, `time`, `role`, `ip`, `active`, `baned`, `closed`) VALUES
(1, 'user@woo.xx', '5f4dcc3b5aa765d61d8327deb882cf99', '2020-09-02 20:03:39', 'user', '1.2.3.3', 1, 0, 0),
(2, 'woo@woo.xx', '5f4dcc3b5aa765d61d8327deb882cf99', '2020-09-02 20:03:39', 'worker', '1.2.3.3', 1, 0, 0),
(88, 'boo@woo.xx', '5f4dcc3b5aa765d61d8327deb882cf99', '2020-09-07 18:22:49', 'admin', '127.0.0.1', 1, 0, 0),
(128, 'boo3@woo.xx', '5f4dcc3b5aa765d61d8327deb882cf99', '2020-10-13 14:39:00', 'user', '127.0.0.1', 1, 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_activation`
--

DROP TABLE IF EXISTS `user_activation`;
CREATE TABLE IF NOT EXISTS `user_activation` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `rf_user_id` bigint(22) NOT NULL,
  `code` varchar(30) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `rf_user_id` (`rf_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `user_activation`
--

TRUNCATE TABLE `user_activation`;
--
-- Zrzut danych tabeli `user_activation`
--

INSERT INTO `user_activation` (`id`, `rf_user_id`, `code`, `time`, `ip`) VALUES
(23, 88, '5f567a7975abc', '2020-09-07 18:22:49', '127.0.0.1'),
(24, 89, '5f567c61bd41d', '2020-09-07 18:30:57', '127.0.0.1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_auth`
--

DROP TABLE IF EXISTS `user_auth`;
CREATE TABLE IF NOT EXISTS `user_auth` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `rf_user_id` bigint(22) NOT NULL,
  `token` varchar(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `rf_user_id` (`rf_user_id`),
  UNIQUE KEY `token` (`token`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `user_auth`
--

TRUNCATE TABLE `user_auth`;
--
-- Zrzut danych tabeli `user_auth`
--

INSERT INTO `user_auth` (`id`, `rf_user_id`, `token`, `created`, `expires`) VALUES
(1, 1, '352a96ef-f05c-11ea-9c9a-d6f20c4dbea5', '2020-09-06 16:00:10', '2020-09-06 17:15:40'),
(20, 88, 'cd0c6b52-f9a1-11ea-a3e7-f2c7e188c9d9', '2020-09-07 18:49:10', '2020-09-18 12:26:31');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_info`
--

DROP TABLE IF EXISTS `user_info`;
CREATE TABLE IF NOT EXISTS `user_info` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `rf_user_id` bigint(22) NOT NULL,
  `alias` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `avatar` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mail` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `www` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `gender` enum('NONE','MALE','FEMALE') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NONE',
  `age` int(11) NOT NULL DEFAULT 0,
  `about` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `rf_user_id` (`rf_user_id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tabela Truncate przed wstawieniem `user_info`
--

TRUNCATE TABLE `user_info`;
--
-- Zrzut danych tabeli `user_info`
--

INSERT INTO `user_info` (`id`, `rf_user_id`, `alias`, `name`, `country`, `city`, `address`, `avatar`, `mail`, `mobile`, `www`, `gender`, `age`, `about`) VALUES
(1, 88, 'Maxiu', 'Max Boy', 'Polska', 'Warszawa', 'Rubinowa 123', '/media/images/avatar/avatar-88.webp', 'mail@woo.xx', '+48 000 000 000', 'http://woo.xx', 'MALE', 0, 'Php Web Developer'),
(2, 1, 'user.1566099831', 'Bad Jony', '', '', '', '', '', '', '', 'NONE', 0, 'I am web developer from Poland. I am php programmer. Living in a small town Warsaw.'),
(3, 2, 'Spaceto', 'Maste Blaster', 'USA', 'New York', '', '/media/images/avatar/avatar-2.webp', 'Banks@boo.xx', '', '', 'NONE', 0, 'I am web developer from Poland. I am javascript programmer.'),
(4, 128, 'user.1924825727', '', '', '', '', '', '', '', '', 'NONE', 0, '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_login`
--

DROP TABLE IF EXISTS `user_login`;
CREATE TABLE IF NOT EXISTS `user_login` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `rf_user_id` bigint(22) NOT NULL,
  `ip` varchar(50) NOT NULL DEFAULT '',
  `info` text NOT NULL DEFAULT '',
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8mb4;

--
-- Tabela Truncate przed wstawieniem `user_login`
--

TRUNCATE TABLE `user_login`;
--
-- Zrzut danych tabeli `user_login`
--

INSERT INTO `user_login` (`id`, `rf_user_id`, `ip`, `info`, `time`) VALUES
(6, 88, '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686; rv:81.0) Gecko/20100101 Firefox/81.0', '2020-10-16 14:57:27'),
(7, 88, '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686; rv:81.0) Gecko/20100101 Firefox/81.0', '2020-10-16 14:58:51');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
