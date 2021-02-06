-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 05 Lut 2021, 23:05
-- Wersja serwera: 10.3.27-MariaDB-0+deb10u1
-- Wersja PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `fudex_app`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `translate`
--

DROP TABLE IF EXISTS `translate`;
CREATE TABLE IF NOT EXISTS `translate` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `hash` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EN',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ukey` (`hash`,`lang_code`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tabela Truncate przed wstawieniem `translate`
--

TRUNCATE TABLE `translate`;
--
-- Zrzut danych tabeli `translate`
--

INSERT INTO `translate` (`id`, `hash`, `txt`, `lang_code`) VALUES
(1, 'ERR_EMAIL_PASS', 'Invalid e-mail address or password!', 'EN'),
(2, 'ERR_EMAIL_PASS', 'Niepoprawny adres e-mail lub hasło!', 'PL'),
(3, 'ERR_EMAIL', 'Invalid e-mail address!', 'EN'),
(4, 'ERR_EMAIL', 'Niepoprawny adres e-mail!', 'PL'),
(5, 'ERR_PASS_LENGTH', 'Password length min. 8 characters!', 'EN'),
(6, 'ERR_PASS_LENGTH', 'Hasło musi zawierać co najmniej 8 znaków!', 'PL'),
(7, 'ERR_PASS_BIG_LETTER', 'Password must contain big letter!', 'EN'),
(8, 'ERR_PASS_BIG_LETTER', 'Hasło musi zawierać dużą literę!', 'PL'),
(9, 'ERR_PASS_SMALL_LETTER', 'Password must contain small letter!', 'EN'),
(10, 'ERR_PASS_SMALL_LETTER', 'Hasło musi zawierać małą literę!', 'PL'),
(11, 'ERR_PASS_NUMBER', 'Password must contain number!', 'EN'),
(12, 'ERR_PASS_NUMBER', 'Hasło musi zawierać cyfrę!', 'PL'),
(13, 'OK_ACCOUNT_CREATED', 'Account has been created! Confirm your e-mail address by clicking the link in the message sent to the e-mail address provided.', 'EN'),
(14, 'OK_ACCOUNT_CREATED', 'Konto zostało utworzone! Potwierdź swój adres e-mail klikając link w wiadomości wysłanej na podany adres e-mail.', 'PL'),
(15, 'ERR_USER_EXISTS', 'Account already exists! Activate your account or recover your password!', 'EN'),
(16, 'ERR_USER_EXISTS', 'Konto już istnieje! Aktywuj swoje konto lub odzyskaj hasło!', 'PL'),
(17, 'TXT_EMAIL_ADDRESS', 'Email address', 'EN'),
(18, 'TXT_EMAIL_ADDRESS', 'Adres email', 'PL'),
(19, 'TXT_EMAIL_ADDRESS_PLACEHOLDER', 'Enter email address', 'EN'),
(20, 'TXT_EMAIL_ADDRESS_PLACEHOLDER', 'Podaj adres email', 'PL'),
(21, 'TXT_PASS_PLACEHOLDER', 'Enter password', 'EN'),
(22, 'TXT_PASS_PLACEHOLDER', 'Podaj hasło', 'PL'),
(23, 'TXT_PASS', 'Password', 'EN'),
(24, 'TXT_PASS', 'Hasło', 'PL'),
(25, 'TXT_SIGN_UP', 'Sign Up', 'EN'),
(26, 'TXT_SIGN_UP', 'Utwórz konto', 'PL'),
(27, 'TXT_SIGN_IN', 'Sign In', 'EN'),
(28, 'TXT_SIGN_IN', 'Zaloguj się', 'PL'),
(29, 'TXT_RESET_PASS', 'Reset password', 'EN'),
(30, 'TXT_RESET_PASS', 'Odzyskaj hasło', 'PL'),
(31, 'TXT_FORGOT_PASS', 'Forgot Password?', 'EN'),
(32, 'TXT_FORGOT_PASS', 'Odzyskaj Hasło?', 'PL'),
(33, 'TXT_SIGN_UP_DESC', 'Create new account now.', 'EN'),
(34, 'TXT_SIGN_UP_DESC', 'Utwórz swoje nowe konto.', 'PL'),
(35, 'TXT_SIGN_IN_DESC', 'Login to your account now.', 'EN'),
(36, 'TXT_SIGN_IN_DESC', 'Zaloguj się do swojego konta.', 'PL'),
(37, 'TXT_CREATE_ACCOUNT', 'Create new account', 'EN'),
(38, 'TXT_CREATE_ACCOUNT', 'Utwórz konto', 'PL'),
(39, 'TXT_DONT_HAVE_ACCOUNT', 'Do not have an account?', 'EN'),
(40, 'TXT_DONT_HAVE_ACCOUNT', 'Nie posiadasz jeszcze konta?', 'PL'),
(41, 'TXT_HAVE_ACCOUNT', 'Have an account?', 'EN'),
(42, 'TXT_HAVE_ACCOUNT', 'Posiadasz konto?', 'PL'),
(43, 'TXT_REGISTER_TITLE', 'Welcome!', 'EN'),
(44, 'TXT_REGISTER_TITLE', 'Zapraszamy!', 'PL'),
(45, 'TXT_REGISTER_DESC', 'You do not have an account? Register a new one now.', 'EN'),
(46, 'TXT_REGISTER_DESC', '\r\n\r\nNie masz konta? Utwórz nowe konto już dziś.', 'PL'),
(47, 'TXT_EMAIL_ADDRESS_ERROR', 'Invalid email address!', 'EN'),
(48, 'TXT_EMAIL_ADDRESS_ERROR', 'Niepoprawny adres email!', 'PL'),
(49, 'TXT_PASS_ERROR', 'Invalid password. Password must contain: number, small letter, big letter and minimum lenght 8 characters!', 'EN'),
(50, 'TXT_PASS_ERROR', 'Niepoprawne hasło. Hasło musi zawierać: cyfrę, małą i dużą literę i mieć długość conajmniej 8 znaków!', 'PL'),
(51, 'TXT_SIGN_UP_PAGE_TITLE', 'Sign Up', 'EN'),
(52, 'TXT_SIGN_UP_PAGE_TITLE', 'Rejestracja', 'PL'),
(53, 'TXT_SIGN_UP_PAGE_DESC', 'Create new account now.', 'EN'),
(54, 'TXT_SIGN_UP_PAGE_DESC', 'Utwórz nowe konto już dziś.', 'PL'),
(55, 'SUBJECT_ACCOUNT_ACTIVATION', 'Account activation', 'EN'),
(56, 'SUBJECT_ACCOUNT_ACTIVATION', 'Aktywacja konta', 'PL'),
(57, 'TXT_ACTIVATION_TITLE', 'Activate account', 'EN'),
(58, 'TXT_ACTIVATION_TITLE', 'Aktywuj konto', 'PL'),
(59, 'TXT_ACTIVATION_DESC', 'Confirm your email address and activate your account.', 'EN'),
(60, 'TXT_ACTIVATION_DESC', 'Potwierdź adres email i aktywuj swoje konto.', 'PL'),
(61, 'TXT_ACTIVATION', 'Activation', 'EN'),
(62, 'TXT_ACTIVATION', 'Aktywacja', 'PL'),
(63, 'TXT_ACTIVATE_DESC', 'Confirm your email address and activate your account.', 'EN'),
(64, 'TXT_ACTIVATE_DESC', 'Potwierdź adres email i aktywuj swoje konto.', 'PL'),
(65, 'TXT_ACTIVATE_TITLE', 'Account activation', 'EN'),
(66, 'TXT_ACTIVATE_TITLE', 'Aktywacja konta', 'PL'),
(67, 'OK_ACCOUNT_ACTIVATED', 'Account has been activated.', 'EN'),
(68, 'OK_ACCOUNT_ACTIVATED', 'Konto jest już aktywne.', 'PL'),
(69, 'TXT_CODE_MSG_ERROR', 'You have not received the message with the activation link. Try to', 'EN'),
(70, 'TXT_CODE_MSG_ERROR', 'Wiadomość aktywacyjna nie dotarła', 'PL'),
(71, 'TXT_ACTIVATION_PAGE_TITLE', 'Account activation', 'EN'),
(72, 'TXT_ACTIVATION_PAGE_TITLE', 'Aktywacja konta', 'PL'),
(73, 'TXT_ACTIVATION_PAGE_DESC', 'Activate your account', 'EN'),
(74, 'TXT_ACTIVATION_PAGE_DESC', 'Aktywuj swoje konto', 'PL'),
(75, 'ERR_ACTIVATION_CODE', 'Error activation code', 'EN'),
(76, 'ERR_ACTIVATION_CODE', 'Niepoprawny kod aktywacyjny', 'PL');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
