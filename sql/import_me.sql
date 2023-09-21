-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Vært: localhost:3306
-- Genereringstid: 21. 09 2023 kl. 09:52:44
-- Serverversion: 8.0.34-0ubuntu0.20.04.1
-- PHP-version: 7.4.3-4ubuntu2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `persondosimetri`
--
CREATE DATABASE IF NOT EXISTS `persondosimetri` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `persondosimetri`;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `historik`
--

CREATE TABLE `historik` (
  `id` int NOT NULL,
  `date` date NOT NULL,
  `TLD` varchar(50) NOT NULL,
  `name` text NOT NULL,
  `effective_dose` decimal(2,1) NOT NULL,
  `skin_dose` decimal(2,1) NOT NULL,
  `finger_dose` decimal(3,1) DEFAULT NULL,
  `comment` varchar(400) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Data dump for tabellen `historik`
--

INSERT INTO `historik` (`id`, `date`, `TLD`, `name`, `effective_dose`, `skin_dose`, `finger_dose`, `comment`) VALUES
(1, '2020-10-31', 'TLD-1234', 'James May', '0.0', '0.0', NULL, ''),
(2, '2020-10-31', 'TLD-1234', 'Tony Stark', '0.1', '0.1', NULL, ''),
(3, '2020-10-31', 'TLD-1234', 'Bruce Wayne', '0.0', '0.0', NULL, ''),
(4, '2020-10-31', 'TLD-1234', 'Barry Allen', '0.0', '0.0', NULL, ''),
(5, '2020-10-31', 'TLD-1234', 'Donald J. Trump', '0.1', '0.1', NULL, ''),
(6, '2020-10-31', 'TLD-1234', 'Diana Prince', '0.0', '0.0', NULL, ''),
(7, '2020-10-31', 'TLD-1234', 'Arthur Curry', '0.1', '0.1', NULL, ''),
(8, '2020-10-31', 'TLD-1234', 'Barbara Gordon', '0.3', '0.3', NULL, ''),
(9, '2020-10-31', 'TLD-1234', 'Steven Rogers', '0.2', '0.2', NULL, ''),
(10, '2020-10-31', 'TLD-1234', 'Billy Batson', '0.0', '0.0', NULL, ''),
(11, '2020-10-31', 'TLD-1234', 'Matthew Michael Murdock', '0.1', '0.1', NULL, ''),
(12, '2020-10-31', 'TLD-1234', 'Floyd Lawton', '0.1', '0.1', NULL, ''),
(13, '2020-10-31', 'TLD-1234', 'Oliver Queen', '0.0', '0.0', NULL, ''),
(14, '2020-10-31', 'TLD-1234', 'Robert Bruce Banner', '0.0', '0.0', NULL, ''),
(15, '2020-10-31', 'TLD-1234', 'Hal Jordan', '0.1', '0.1', NULL, ''),
(16, '2020-10-31', 'TLD-1234', 'Peter Parker', '0.0', '0.0', NULL, ''),
(17, '2020-10-31', 'TLD-1234', 'Clark Kent', '0.1', '0.1', NULL, ''),
(18, '2020-10-31', 'TLD-1234', 'Natalia Allanovna Romanova', '0.1', '0.2', NULL, ''),
(19, '2020-10-31', 'TLD-1234', 'Walter Kovacs', '0.1', '0.1', NULL, ''),
(20, '2020-10-31', 'TLD-1234', 'Loki Laufeyson', '0.3', '0.2', NULL, ''),
(21, '2020-10-31', 'TLD-1234', 'Remy LeBeau', '0.0', '0.0', NULL, ''),
(22, '2020-10-31', 'TLD-1234', 'Alec Holland', '0.0', '0.0', NULL, ''),
(23, '2020-10-31', 'TLD-1234', 'Dru-Zod', '0.1', '0.1', NULL, ''),
(24, '2020-10-31', 'TLD-1234', 'Raven Darkholme', '0.1', '0.1', NULL, ''),
(25, '2020-10-31', 'TLD-1234', 'Adrian Veidt', '0.2', '0.2', NULL, ''),
(26, '2020-11-30', 'TLD-1234', 'Maz ‘Magnus’ Eisenhardt', '0.0', '0.0', NULL, ''),
(27, '2020-08-31', 'TLD-1234', 'Maz ‘Magnus’ Eisenhardt', '0.0', '0.0', NULL, ''),
(28, '2020-10-31', 'TLD-1234', 'Jonathan Osterman', '0.0', '0.0', NULL, ''),
(29, '2020-10-31', 'TLD-1234', 'Reed Richards', '0.0', '0.0', NULL, ''),
(43, '2020-01-31', 'TLD-1234', 'James May', '0.0', '0.0', NULL, ''),
(44, '2020-01-31', 'TLD-1234', 'Tony Stark', '0.2', '0.2', NULL, ''),
(45, '2020-01-31', 'TLD-1234', 'Barry Allen', '0.0', '0.1', NULL, ''),
(46, '2020-01-31', 'TLD-1234', 'Donald J. Trump', '0.1', '0.1', NULL, ''),
(47, '2020-01-31', 'TLD-1234', 'Diana Prince', '0.0', '0.0', NULL, ''),
(50, '2020-01-31', 'TLD-1234', 'Billy Batson', '0.0', '0.0', NULL, ''),
(51, '2020-01-31', 'TLD-1234', 'Matthew Michael Murdock', '0.1', '0.1', NULL, ''),
(52, '2020-01-31', 'TLD-1234', 'Floyd Lawton', '0.2', '0.2', NULL, ''),
(54, '2020-01-31', 'TLD-1234', 'Hal Jordan', '0.2', '0.1', NULL, ''),
(55, '2020-01-31', 'TLD-1234', 'Peter Parker', '0.0', '0.0', NULL, ''),
(56, '2020-01-31', 'TLD-1234', 'Clark Kent', '0.1', '0.1', NULL, ''),
(57, '2020-01-31', 'TLD-1234', 'Natalia Allanovna Romanova', '0.1', '0.1', NULL, ''),
(58, '2020-01-31', 'TLD-1234', 'Walter Kovacs', '0.8', '1.2', NULL, 'Der har ikke vÃ¦ret opfÃ¸lgning pÃ¥ denne aflÃ¦sning. /JN'),
(59, '2020-01-31', 'TLD-1234', 'Loki Laufeyson', '0.2', '0.3', NULL, ''),
(60, '2020-01-31', 'TLD-1234', 'Dru-Zod', '0.3', '0.1', NULL, ''),
(63, '2020-01-31', 'TLD-1234', 'Reed Richards', '0.0', '0.0', NULL, ''),
(76, '2020-02-29', 'TLD-1234', 'James May', '0.0', '0.0', NULL, ''),
(77, '2020-02-29', 'TLD-1234', 'Tony Stark', '0.1', '0.1', NULL, ''),
(79, '2020-02-29', 'TLD-1234', 'Donald J. Trump', '0.1', '0.1', NULL, ''),
(80, '2020-02-29', 'TLD-1234', 'Diana Prince', '0.0', '0.0', NULL, ''),
(81, '2020-02-29', 'TLD-1234', 'Arthur Curry', '0.1', '0.1', NULL, ''),
(82, '2020-02-29', 'TLD-1234', 'Billy Batson', '0.0', '0.0', NULL, ''),
(83, '2020-02-29', 'TLD-1234', 'Floyd Lawton', '0.2', '0.3', NULL, ''),
(84, '2020-02-29', 'TLD-1234', 'Oliver Queen', '0.0', '0.0', NULL, ''),
(85, '2020-02-29', 'TLD-1234', 'Hal Jordan', '0.1', '0.1', NULL, ''),
(86, '2020-02-29', 'TLD-1234', 'Peter Parker', '0.0', '0.0', NULL, ''),
(87, '2020-02-29', 'TLD-1234', 'Clark Kent', '0.1', '0.1', NULL, ''),
(88, '2020-02-29', 'TLD-1234', 'Natalia Allanovna Romanova', '0.2', '0.2', NULL, ''),
(89, '2020-02-29', 'TLD-1234', 'Walter Kovacs', '0.3', '0.4', NULL, ''),
(90, '2020-02-29', 'TLD-1234', 'Loki Laufeyson', '0.2', '0.2', NULL, ''),
(91, '2020-02-29', 'TLD-1234', 'Remy LeBeau', '0.0', '0.0', NULL, ''),
(92, '2020-02-29', 'TLD-1234', 'Dru-Zod', '0.1', '0.1', NULL, ''),
(93, '2020-02-29', 'TLD-1234', 'Raven Darkholme', '0.0', '0.0', NULL, ''),
(94, '2020-02-29', 'TLD-1234', 'Adrian Veidt', '0.1', '0.1', NULL, ''),
(95, '2020-02-29', 'TLD-1234', 'Jonathan Osterman', '0.0', '0.0', NULL, ''),
(107, '2020-06-30', 'TLD-1234', 'James May', '0.0', '0.0', NULL, ''),
(108, '2020-03-31', 'TLD-1234', 'Tony Stark', '0.1', '0.1', NULL, ''),
(110, '2020-03-31', 'TLD-1234', 'Diana Prince', '0.0', '0.0', NULL, ''),
(112, '2020-03-31', 'TLD-1234', 'Billy Batson', '0.0', '0.0', NULL, ''),
(113, '2020-03-31', 'TLD-1234', 'Floyd Lawton', '0.1', '0.1', NULL, ''),
(114, '2020-03-31', 'TLD-1234', 'Oliver Queen', '0.0', '0.0', NULL, ''),
(115, '2020-03-31', 'TLD-1234', 'Hal Jordan', '0.1', '0.1', NULL, ''),
(116, '2020-03-31', 'TLD-1234', 'Peter Parker', '0.0', '0.0', NULL, ''),
(117, '2020-03-31', 'TLD-1234', 'Clark Kent', '0.1', '0.1', NULL, ''),
(118, '2020-03-31', 'TLD-1234', 'Walter Kovacs', '0.2', '0.3', NULL, ''),
(119, '2020-03-31', 'TLD-1234', 'Loki Laufeyson', '0.1', '0.2', NULL, ''),
(120, '2020-03-31', 'TLD-1234', 'Alec Holland', '0.0', '0.0', NULL, ''),
(121, '2020-03-31', 'TLD-1234', 'Dru-Zod', '0.1', '0.1', NULL, ''),
(122, '2020-03-31', 'TLD-1234', 'Raven Darkholme', '0.0', '0.0', NULL, ''),
(123, '2020-03-31', 'TLD-1234', 'Adrian Veidt', '0.0', '0.1', NULL, ''),
(124, '2020-03-31', 'TLD-1234', 'Maz ‘Magnus’ Eisenhardt', '0.3', '0.4', NULL, ''),
(125, '2020-03-31', 'TLD-1234', 'Jonathan Osterman', '0.0', '0.0', NULL, ''),
(126, '2020-03-31', 'TLD-1234', 'Reed Richards', '0.0', '0.0', NULL, ''),
(141, '2020-04-30', 'TLD-1234', 'James May', '0.0', '0.0', NULL, ''),
(142, '2020-04-30', 'TLD-1234', 'Tony Stark', '0.1', '0.1', NULL, ''),
(144, '2020-04-30', 'TLD-1234', 'Barry Allen', '0.0', '0.0', NULL, ''),
(145, '2020-04-30', 'TLD-1234', 'Donald J. Trump', '0.0', '0.0', NULL, ''),
(146, '2020-04-30', 'TLD-1234', 'Diana Prince', '0.0', '0.0', NULL, ''),
(147, '2020-04-30', 'TLD-1234', 'Arthur Curry', '0.0', '0.0', NULL, ''),
(148, '2020-03-31', 'TLD-1234', 'Arthur Curry', '0.1', '0.1', NULL, ''),
(149, '2020-04-30', 'TLD-1234', 'Billy Batson', '0.0', '0.0', NULL, ''),
(150, '2020-04-30', 'TLD-1234', 'Matthew Michael Murdock', '0.1', '0.1', NULL, ''),
(151, '2020-04-30', 'TLD-1234', 'Floyd Lawton', '0.1', '0.1', NULL, ''),
(152, '2020-04-30', 'TLD-1234', 'Oliver Queen', '0.0', '0.0', NULL, ''),
(153, '2020-04-30', 'TLD-1234', 'Robert Bruce Banner', '0.0', '0.0', NULL, ''),
(154, '2020-04-30', 'TLD-1234', 'Hal Jordan', '0.0', '0.0', NULL, ''),
(155, '2020-04-30', 'TLD-1234', 'Peter Parker', '0.0', '0.0', NULL, ''),
(156, '2020-04-30', 'TLD-1234', 'Clark Kent', '0.1', '0.1', NULL, ''),
(157, '2020-04-30', 'TLD-1234', 'Natalia Allanovna Romanova', '0.1', '0.1', NULL, ''),
(158, '2020-03-31', 'TLD-1234', 'Natalia Allanovna Romanova', '0.2', '0.2', NULL, ''),
(159, '2020-04-30', 'TLD-1234', 'Walter Kovacs', '0.2', '0.2', NULL, ''),
(160, '2020-04-30', 'TLD-1234', 'Loki Laufeyson', '0.1', '0.1', NULL, ''),
(161, '2020-04-30', 'TLD-1234', 'Remy LeBeau', '0.0', '0.0', NULL, ''),
(162, '2020-03-31', 'TLD-1234', 'Remy LeBeau', '0.0', '0.0', NULL, ''),
(163, '2020-04-30', 'TLD-1234', 'Alec Holland', '0.0', '0.0', NULL, ''),
(164, '2020-04-30', 'TLD-1234', 'Dru-Zod', '0.0', '0.0', NULL, ''),
(165, '2020-04-30', 'TLD-1234', 'Raven Darkholme', '0.0', '0.0', NULL, ''),
(166, '2020-04-30', 'TLD-1234', 'Maz ‘Magnus’ Eisenhardt', '0.2', '0.2', NULL, ''),
(167, '2020-04-30', 'TLD-1234', 'Jonathan Osterman', '0.0', '0.0', NULL, ''),
(168, '2020-04-30', 'TLD-1234', 'Reed Richards', '0.0', '0.0', NULL, ''),
(186, '2020-05-31', 'TLD-1234', 'James May', '0.0', '0.0', NULL, ''),
(187, '2020-05-31', 'TLD-1234', 'Tony Stark', '0.1', '0.1', NULL, ''),
(188, '2020-05-31', 'TLD-1234', 'Bruce Wayne', '0.0', '0.0', NULL, ''),
(190, '2020-05-31', 'TLD-1234', 'Barry Allen', '0.0', '0.0', NULL, ''),
(191, '2020-05-31', 'TLD-1234', 'Donald J. Trump', '0.0', '0.0', NULL, ''),
(192, '2020-05-31', 'TLD-1234', 'Diana Prince', '0.0', '0.0', NULL, ''),
(193, '2020-05-31', 'TLD-1234', 'Arthur Curry', '0.1', '0.1', NULL, ''),
(194, '2020-05-31', 'TLD-1234', 'Billy Batson', '0.0', '0.0', NULL, ''),
(195, '2020-05-31', 'TLD-1234', 'Matthew Michael Murdock', '0.1', '0.1', NULL, ''),
(196, '2020-05-31', 'TLD-1234', 'Floyd Lawton', '0.2', '0.2', NULL, ''),
(197, '2020-05-31', 'TLD-1234', 'Oliver Queen', '0.0', '0.0', NULL, ''),
(198, '2020-05-31', 'TLD-1234', 'Robert Bruce Banner', '0.0', '0.0', NULL, ''),
(199, '2020-05-31', 'TLD-1234', 'Peter Parker', '0.0', '0.0', NULL, ''),
(200, '2020-05-31', 'TLD-1234', 'Clark Kent', '0.1', '0.1', NULL, ''),
(201, '2020-05-31', 'TLD-1234', 'Natalia Allanovna Romanova', '0.2', '0.2', NULL, ''),
(202, '2020-05-31', 'TLD-1234', 'Walter Kovacs', '0.1', '0.1', NULL, ''),
(203, '2020-05-31', 'TLD-1234', 'Loki Laufeyson', '0.2', '0.2', NULL, ''),
(204, '2020-05-31', 'TLD-1234', 'Remy LeBeau', '0.0', '0.0', NULL, ''),
(205, '2020-05-31', 'TLD-1234', 'Alec Holland', '0.0', '0.0', NULL, ''),
(206, '2020-05-31', 'TLD-1234', 'Dru-Zod', '0.1', '0.1', NULL, ''),
(207, '2020-05-31', 'TLD-1234', 'Raven Darkholme', '0.1', '0.1', NULL, ''),
(208, '2020-05-31', 'TLD-1234', 'Jonathan Osterman', '0.0', '0.0', NULL, ''),
(209, '2020-05-31', 'TLD-1234', 'Reed Richards', '0.0', '0.0', NULL, ''),
(224, '2020-03-31', 'TLD-1234', 'James May', '0.0', '0.0', NULL, ''),
(225, '2020-06-30', 'TLD-1234', 'Tony Stark', '0.2', '0.2', NULL, ''),
(226, '2020-06-30', 'TLD-1234', 'Bruce Wayne', '0.0', '0.0', NULL, ''),
(227, '2020-06-30', 'TLD-1234', 'Barry Allen', '0.0', '0.0', NULL, ''),
(228, '2020-06-30', 'TLD-1234', 'Donald J. Trump', '0.1', '0.1', NULL, ''),
(229, '2020-06-30', 'TLD-1234', 'Billy Batson', '0.0', '0.0', NULL, ''),
(230, '2020-06-30', 'TLD-1234', 'Matthew Michael Murdock', '0.1', '0.1', NULL, ''),
(231, '2020-06-30', 'TLD-1234', 'Robert Bruce Banner', '0.0', '0.0', NULL, ''),
(232, '2020-06-30', 'TLD-1234', 'Peter Parker', '0.0', '0.0', NULL, ''),
(233, '2020-06-30', 'TLD-1234', 'Natalia Allanovna Romanova', '0.2', '0.2', NULL, ''),
(234, '2020-06-30', 'TLD-1234', 'Loki Laufeyson', '0.3', '0.3', NULL, ''),
(235, '2020-06-30', 'TLD-1234', 'Remy LeBeau', '0.0', '0.0', NULL, ''),
(236, '2020-06-30', 'TLD-1234', 'Alec Holland', '0.1', '0.1', NULL, ''),
(237, '2020-06-30', 'TLD-1234', 'Dru-Zod', '0.1', '0.1', NULL, ''),
(238, '2020-06-30', 'TLD-1234', 'Raven Darkholme', '0.2', '0.2', NULL, ''),
(239, '2020-06-30', 'TLD-1234', 'Jonathan Osterman', '0.0', '0.0', NULL, ''),
(240, '2020-06-30', 'TLD-1234', 'Reed Richards', '0.0', '0.0', NULL, ''),
(249, '2020-07-31', 'TLD-1234', 'James May', '0.0', '0.0', NULL, ''),
(250, '2020-07-31', 'TLD-1234', 'Tony Stark', '0.1', '0.1', NULL, ''),
(252, '2020-07-31', 'TLD-1234', 'Donald J. Trump', '0.0', '0.0', NULL, ''),
(253, '2020-07-31', 'TLD-1234', 'Diana Prince', '0.0', '0.0', NULL, ''),
(254, '2020-07-31', 'TLD-1234', 'Arthur Curry', '0.1', '0.1', NULL, ''),
(255, '2020-07-31', 'TLD-1234', 'Billy Batson', '0.0', '0.0', NULL, ''),
(256, '2020-07-31', 'TLD-1234', 'Matthew Michael Murdock', '0.1', '0.1', NULL, ''),
(257, '2020-07-31', 'TLD-1234', 'Floyd Lawton', '0.1', '0.1', NULL, ''),
(258, '2020-07-31', 'TLD-1234', 'Robert Bruce Banner', '0.0', '0.0', NULL, ''),
(259, '2020-07-31', 'TLD-1234', 'Peter Parker', '0.0', '0.0', NULL, ''),
(260, '2020-07-31', 'TLD-1234', 'Natalia Allanovna Romanova', '0.2', '0.3', NULL, ''),
(261, '2020-07-31', 'TLD-1234', 'Walter Kovacs', '0.0', '0.0', NULL, ''),
(262, '2020-07-31', 'TLD-1234', 'Alec Holland', '0.0', '0.0', NULL, ''),
(263, '2020-07-31', 'TLD-1234', 'Dru-Zod', '0.1', '0.1', NULL, ''),
(264, '2020-07-31', 'TLD-1234', 'Raven Darkholme', '0.1', '0.1', NULL, ''),
(265, '2020-06-30', 'TLD-1234', 'Maz ‘Magnus’ Eisenhardt', '0.2', '0.1', NULL, ''),
(266, '2020-07-31', 'TLD-1234', 'Reed Richards', '0.0', '0.0', NULL, ''),
(276, '2020-08-31', 'TLD-1234', 'James May', '0.0', '0.0', NULL, ''),
(277, '2020-08-31', 'TLD-1234', 'Tony Stark', '0.3', '0.3', NULL, ''),
(278, '2020-08-31', 'TLD-1234', 'Bruce Wayne', '0.0', '0.0', NULL, ''),
(280, '2020-08-31', 'TLD-1234', 'Barry Allen', '0.0', '0.1', NULL, ''),
(281, '2020-07-31', 'TLD-1234', 'Barry Allen', '0.0', '0.0', NULL, ''),
(282, '2020-08-31', 'TLD-1234', 'Donald J. Trump', '0.1', '0.1', NULL, ''),
(283, '2020-08-31', 'TLD-1234', 'Diana Prince', '0.0', '0.0', NULL, ''),
(284, '2020-08-31', 'TLD-1234', 'Billy Batson', '0.0', '0.0', NULL, ''),
(285, '2020-08-31', 'TLD-1234', 'Matthew Michael Murdock', '0.1', '0.2', NULL, ''),
(286, '2020-08-31', 'TLD-1234', 'Floyd Lawton', '0.1', '0.1', NULL, ''),
(287, '2020-08-31', 'TLD-1234', 'Oliver Queen', '0.0', '0.0', NULL, ''),
(288, '2020-08-31', 'TLD-1234', 'Robert Bruce Banner', '0.0', '0.0', NULL, ''),
(289, '2020-08-31', 'TLD-1234', 'Hal Jordan', '0.1', '0.1', NULL, ''),
(290, '2020-08-31', 'TLD-1234', 'Peter Parker', '0.1', '0.1', NULL, ''),
(291, '2020-08-31', 'TLD-1234', 'Walter Kovacs', '0.2', '0.2', NULL, ''),
(292, '2020-08-31', 'TLD-1234', 'Loki Laufeyson', '0.3', '0.3', NULL, ''),
(293, '2020-08-31', 'TLD-1234', 'Remy LeBeau', '0.0', '0.0', NULL, ''),
(294, '2020-07-31', 'TLD-1234', 'Remy LeBeau', '0.0', '0.0', NULL, ''),
(295, '2020-08-31', 'TLD-1234', 'Alec Holland', '0.0', '0.0', NULL, ''),
(296, '2020-08-31', 'TLD-1234', 'Dru-Zod', '0.3', '0.3', NULL, ''),
(297, '2020-08-31', 'TLD-1234', 'Raven Darkholme', '0.2', '0.2', NULL, ''),
(298, '2020-08-31', 'TLD-1234', 'Adrian Veidt', '0.1', '0.1', NULL, ''),
(299, '2020-06-30', 'TLD-1234', 'Adrian Veidt', '0.1', '0.1', NULL, ''),
(300, '2020-08-31', 'TLD-1234', 'Jonathan Osterman', '0.0', '0.0', NULL, ''),
(301, '2020-08-31', 'TLD-1234', 'Reed Richards', '0.0', '0.0', NULL, ''),
(321, '2020-09-30', 'TLD-1234', 'James May', '0.0', '0.0', NULL, ''),
(322, '2020-09-30', 'TLD-1234', 'Tony Stark', '0.2', '0.2', NULL, ''),
(323, '2020-09-30', 'TLD-1234', 'Bruce Wayne', '0.1', '0.1', NULL, ''),
(325, '2020-09-30', 'TLD-1234', 'Barry Allen', '0.1', '0.1', NULL, ''),
(326, '2020-09-30', 'TLD-1234', 'Donald J. Trump', '0.1', '0.1', NULL, ''),
(327, '2020-09-30', 'TLD-1234', 'Diana Prince', '0.0', '0.0', NULL, ''),
(328, '2020-09-30', 'TLD-1234', 'Arthur Curry', '0.0', '0.0', NULL, ''),
(329, '2020-08-31', 'TLD-1234', 'Arthur Curry', '0.0', '0.0', NULL, ''),
(330, '2020-09-30', 'TLD-1234', 'Barbara Gordon', '0.2', '0.2', NULL, ''),
(331, '2020-09-30', 'TLD-1234', 'Steven Rogers', '0.1', '0.1', NULL, ''),
(332, '2020-09-30', 'TLD-1234', 'Billy Batson', '0.0', '0.0', NULL, ''),
(333, '2020-09-30', 'TLD-1234', 'Matthew Michael Murdock', '0.2', '0.2', NULL, ''),
(334, '2020-09-30', 'TLD-1234', 'Floyd Lawton', '0.3', '0.3', NULL, ''),
(335, '2020-09-30', 'TLD-1234', 'Oliver Queen', '0.0', '0.0', NULL, ''),
(336, '2020-09-30', 'TLD-1234', 'Robert Bruce Banner', '0.0', '0.0', NULL, ''),
(337, '2020-09-30', 'TLD-1234', 'Hal Jordan', '0.1', '0.1', NULL, ''),
(338, '2020-09-30', 'TLD-1234', 'Peter Parker', '0.0', '0.0', NULL, ''),
(339, '2020-09-30', 'TLD-1234', 'Clark Kent', '0.1', '0.1', NULL, ''),
(340, '2020-08-31', 'TLD-1234', 'Clark Kent', '0.1', '0.1', NULL, ''),
(341, '2020-09-30', 'TLD-1234', 'Natalia Allanovna Romanova', '0.1', '0.1', NULL, ''),
(342, '2020-08-31', 'TLD-1234', 'Natalia Allanovna Romanova', '0.1', '0.1', NULL, ''),
(343, '2020-09-30', 'TLD-1234', 'Walter Kovacs', '0.3', '0.3', NULL, ''),
(344, '2020-09-30', 'TLD-1234', 'Loki Laufeyson', '0.3', '0.3', NULL, ''),
(345, '2020-09-30', 'TLD-1234', 'Remy LeBeau', '0.0', '0.0', NULL, ''),
(346, '2020-09-30', 'TLD-1234', 'Alec Holland', '0.1', '0.1', NULL, ''),
(347, '2020-09-30', 'TLD-1234', 'Dru-Zod', '0.1', '0.1', NULL, ''),
(348, '2020-09-30', 'TLD-1234', 'Raven Darkholme', '0.1', '0.1', NULL, ''),
(349, '2020-09-30', 'TLD-1234', 'Adrian Veidt', '0.1', '0.1', NULL, ''),
(350, '2020-10-31', 'TLD-1234', 'Maz ‘Magnus’ Eisenhardt', '0.0', '0.0', NULL, ''),
(351, '2020-09-30', 'TLD-1234', 'Maz ‘Magnus’ Eisenhardt', '0.0', '0.0', NULL, ''),
(352, '2020-09-30', 'TLD-1234', 'Jonathan Osterman', '0.0', '0.0', NULL, ''),
(353, '2020-09-30', 'TLD-1234', 'Reed Richards', '0.0', '0.0', NULL, ''),
(367, '2020-11-30', 'TLD-1234', 'James May', '0.0', '0.0', NULL, ''),
(368, '2020-11-30', 'TLD-1234', 'Tony Stark', '0.2', '0.2', NULL, ''),
(369, '2020-11-30', 'TLD-1234', 'Bruce Wayne', '0.0', '0.0', NULL, ''),
(372, '2020-11-30', 'TLD-1234', 'Donald J. Trump', '0.1', '0.1', NULL, ''),
(373, '2020-11-30', 'TLD-1234', 'Diana Prince', '0.0', '0.1', NULL, ''),
(374, '2020-11-30', 'TLD-1234', 'Arthur Curry', '0.2', '0.2', NULL, ''),
(375, '2020-11-30', 'TLD-1234', 'Barbara Gordon', '0.4', '0.3', NULL, ''),
(376, '2020-11-30', 'TLD-1234', 'Billy Batson', '0.1', '0.0', NULL, ''),
(377, '2020-11-30', 'TLD-1234', 'Matthew Michael Murdock', '0.1', '0.1', NULL, ''),
(378, '2020-11-30', 'TLD-1234', 'Floyd Lawton', '0.2', '0.2', NULL, ''),
(379, '2020-11-30', 'TLD-1234', 'Oliver Queen', '0.0', '0.0', NULL, ''),
(380, '2020-11-30', 'TLD-1234', 'Robert Bruce Banner', '0.0', '0.0', NULL, ''),
(381, '2020-11-30', 'TLD-1234', 'Hal Jordan', '0.1', '0.1', NULL, ''),
(382, '2020-11-30', 'TLD-1234', 'Peter Parker', '0.1', '0.1', NULL, ''),
(383, '2020-11-30', 'TLD-1234', 'Clark Kent', '0.1', '0.1', NULL, ''),
(384, '2020-11-30', 'TLD-1234', 'Natalia Allanovna Romanova', '0.3', '0.3', NULL, ''),
(385, '2020-11-30', 'TLD-1234', 'Walter Kovacs', '0.2', '0.2', NULL, ''),
(386, '2020-11-30', 'TLD-1234', 'Loki Laufeyson', '0.1', '0.1', NULL, ''),
(387, '2020-11-30', 'TLD-1234', 'Remy LeBeau', '0.0', '0.0', NULL, ''),
(388, '2020-11-30', 'TLD-1234', 'Alec Holland', '0.0', '0.0', NULL, ''),
(389, '2020-11-30', 'TLD-1234', 'Dru-Zod', '0.1', '0.1', NULL, ''),
(391, '2020-11-30', 'TLD-1234', 'Raven Darkholme', '0.1', '0.1', NULL, ''),
(392, '2020-11-30', 'TLD-1234', 'Adrian Veidt', '0.2', '0.1', NULL, ''),
(393, '2020-11-30', 'TLD-1234', 'Jonathan Osterman', '0.0', '0.0', NULL, ''),
(394, '2020-11-30', 'TLD-1234', 'Reed Richards', '0.0', '0.0', NULL, ''),
(406, '2020-07-31', 'TLD-1234', 'Bruce Wayne', '0.0', '0.0', NULL, ''),
(407, '2020-03-31', 'TLD-1234', 'Donald J. Trump', '0.0', '0.0', NULL, ''),
(408, '2020-12-31', 'TLD-1234', 'James May', '0.0', '0.0', NULL, ''),
(409, '2020-12-31', 'TLD-1234', 'Tony Stark', '0.1', '0.1', NULL, ''),
(410, '2020-12-31', 'TLD-1234', 'Bruce Wayne', '0.0', '0.0', NULL, ''),
(412, '2020-12-31', 'TLD-1234', 'Barry Allen', '0.0', '0.0', NULL, ''),
(413, '2020-12-31', 'TLD-1234', 'Donald J. Trump', '0.0', '0.1', NULL, ''),
(414, '2020-12-31', 'TLD-1234', 'Diana Prince', '0.0', '0.0', NULL, ''),
(415, '2020-12-31', 'TLD-1234', 'Arthur Curry', '0.2', '0.2', NULL, ''),
(416, '2020-12-31', 'TLD-1234', 'Steven Rogers', '0.0', '0.0', NULL, ''),
(417, '2020-12-31', 'TLD-1234', 'Billy Batson', '0.0', '0.0', NULL, ''),
(418, '2020-12-31', 'TLD-1234', 'Matthew Michael Murdock', '0.1', '0.1', NULL, ''),
(419, '2020-12-31', 'TLD-1234', 'Floyd Lawton', '0.2', '0.2', NULL, ''),
(420, '2020-12-31', 'TLD-1234', 'Oliver Queen', '0.0', '0.0', NULL, ''),
(421, '2020-12-31', 'TLD-1234', 'Robert Bruce Banner', '0.0', '0.0', NULL, ''),
(422, '2020-12-31', 'TLD-1234', 'Hal Jordan', '0.1', '0.1', NULL, ''),
(423, '2020-12-31', 'TLD-1234', 'Peter Parker', '0.0', '0.0', NULL, ''),
(424, '2020-12-31', 'TLD-1234', 'Clark Kent', '0.1', '0.1', NULL, ''),
(425, '2020-12-31', 'TLD-1234', 'Natalia Allanovna Romanova', '0.2', '0.2', NULL, ''),
(426, '2020-12-31', 'TLD-1234', 'Walter Kovacs', '0.3', '0.3', NULL, ''),
(427, '2020-12-31', 'TLD-1234', 'Loki Laufeyson', '0.1', '0.1', NULL, ''),
(428, '2020-12-31', 'TLD-1234', 'Remy LeBeau', '0.0', '0.0', NULL, ''),
(429, '2020-12-31', 'TLD-1234', 'Alec Holland', '0.0', '0.0', NULL, ''),
(430, '2020-12-31', 'TLD-1234', 'Dru-Zod', '0.1', '0.1', NULL, ''),
(432, '2020-12-31', 'TLD-1234', 'Adrian Veidt', '0.2', '0.2', NULL, ''),
(433, '2020-12-31', 'TLD-1234', 'Jonathan Osterman', '0.0', '0.0', NULL, ''),
(434, '2020-12-31', 'TLD-1234', 'Reed Richards', '0.0', '0.0', NULL, ''),
(447, '2020-11-30', 'TLD-1234', 'Barry Allen', '0.1', '0.1', NULL, ''),
(450, '2020-07-31', 'TLD-1234', 'Oliver Queen', '0.0', '0.0', NULL, ''),
(451, '2020-07-31', 'TLD-1234', 'Hal Jordan', '0.1', '0.1', NULL, ''),
(452, '2020-07-31', 'TLD-1234', 'Clark Kent', '0.2', '0.2', NULL, ''),
(453, '2020-07-31', 'TLD-1234', 'Loki Laufeyson', '0.2', '0.2', NULL, ''),
(454, '2020-07-31', 'TLD-1234', 'Adrian Veidt', '0.0', '0.0', NULL, ''),
(455, '2020-07-31', 'TLD-1234', 'Maz ‘Magnus’ Eisenhardt', '0.0', '0.1', NULL, ''),
(456, '2020-07-31', 'TLD-1234', 'Jonathan Osterman', '0.0', '0.0', NULL, ''),
(459, '2020-06-30', 'TLD-1234', 'Diana Prince', '0.0', '0.0', NULL, ''),
(460, '2020-06-30', 'TLD-1234', 'Arthur Curry', '0.2', '0.2', NULL, ''),
(461, '2020-06-30', 'TLD-1234', 'Floyd Lawton', '0.1', '0.1', NULL, ''),
(462, '2020-06-30', 'TLD-1234', 'Oliver Queen', '0.0', '0.0', NULL, ''),
(463, '2020-06-30', 'TLD-1234', 'Hal Jordan', '0.1', '0.1', NULL, ''),
(464, '2020-06-30', 'TLD-1234', 'Clark Kent', '0.1', '0.1', NULL, ''),
(465, '2020-06-30', 'TLD-1234', 'Walter Kovacs', '0.2', '0.2', NULL, ''),
(471, '2020-04-30', 'TLD-1234', 'Bruce Wayne', '0.0', '0.0', NULL, ''),
(472, '2020-05-31', 'TLD-1234', 'Hal Jordan', '0.1', '0.1', NULL, ''),
(473, '2020-05-31', 'TLD-1234', 'Adrian Veidt', '0.1', '0.1', NULL, ''),
(474, '2020-05-31', 'TLD-1234', 'Maz ‘Magnus’ Eisenhardt', '0.1', '0.1', NULL, ''),
(476, '2020-04-30', 'TLD-1234', 'Adrian Veidt', '0.0', '0.0', NULL, ''),
(478, '2020-03-31', 'TLD-1234', 'Bruce Wayne', '0.0', '0.0', NULL, ''),
(479, '2020-03-31', 'TLD-1234', 'Barry Allen', '0.0', '0.1', NULL, ''),
(481, '2020-03-31', 'TLD-1234', 'Matthew Michael Murdock', '0.1', '0.1', NULL, ''),
(482, '2020-03-31', 'TLD-1234', 'Robert Bruce Banner', '0.0', '0.0', NULL, ''),
(484, '2020-02-29', 'TLD-1234', 'Barry Allen', '0.0', '0.0', NULL, ''),
(485, '2020-02-29', 'TLD-1234', 'Bruce Wayne', '0.1', '0.1', NULL, ''),
(487, '2020-02-29', 'TLD-1234', 'Matthew Michael Murdock', '0.1', '0.1', NULL, ''),
(488, '2020-02-29', 'TLD-1234', 'Robert Bruce Banner', '0.0', '0.0', NULL, ''),
(490, '2020-02-29', 'TLD-1234', 'Maz ‘Magnus’ Eisenhardt', '0.3', '0.3', NULL, ''),
(491, '2020-02-29', 'TLD-1234', 'Reed Richards', '0.0', '0.0', NULL, ''),
(496, '2020-01-31', 'TLD-1234', 'Bruce Wayne', '0.0', '0.1', NULL, ''),
(497, '2020-01-31', 'TLD-1234', 'Oliver Queen', '0.0', '0.0', NULL, ''),
(498, '2020-01-31', 'TLD-1234', 'Robert Bruce Banner', '0.0', '0.0', NULL, ''),
(499, '2020-01-31', 'TLD-1234', 'Adrian Veidt', '0.0', '0.0', NULL, ''),
(500, '2020-01-31', 'TLD-1234', 'Jonathan Osterman', '0.0', '0.0', NULL, ''),
(506, '2020-01-31', 'TLD-1234', 'Arthur Curry', '0.0', '0.0', NULL, ''),
(507, '2020-01-31', 'TLD-1234', 'Remy LeBeau', '0.0', '0.0', NULL, ''),
(509, '2020-11-30', 'TLD-1234', 'Steven Rogers', '0.0', '0.0', NULL, ''),
(510, '2020-01-31', 'TLd-1234', 'Alec Holland', '0.0', '0.0', NULL, ''),
(511, '2020-02-29', 'TLd-1234', 'Alec Holland', '0.0', '0.0', NULL, ''),
(513, '2020-12-31', 'TLD-1234', 'Barbara Gordon', '0.2', '0.2', NULL, ''),
(514, '2020-12-31', 'TLD-1234', 'Raven Darkholme', '0.1', '0.1', NULL, ''),
(517, '2021-01-31', 'TLD-1234', 'James May', '0.0', '0.0', NULL, ''),
(518, '2021-01-31', 'TLD-1234', 'Tony Stark', '0.2', '0.2', NULL, ''),
(519, '2021-01-31', 'TLD-1234', 'Bruce Wayne', '0.0', '0.0', NULL, ''),
(521, '2021-01-31', 'TLD-1234', 'Barry Allen', '0.1', '0.1', NULL, ''),
(522, '2021-01-31', 'TLD-1234', 'Donald J. Trump', '0.0', '0.0', NULL, ''),
(523, '2021-01-31', 'TLD-1234', 'Diana Prince', '0.0', '0.0', NULL, ''),
(524, '2021-01-31', 'TLD-1234', 'Arthur Curry', '0.1', '0.1', NULL, ''),
(525, '2021-01-31', 'TLD-1234', 'Barbara Gordon', '0.1', '0.1', NULL, ''),
(526, '2021-01-31', 'TLD-1234', 'Steven Rogers', '0.0', '0.0', NULL, ''),
(527, '2021-01-31', 'TLD-1234', 'Billy Batson', '0.0', '0.0', NULL, ''),
(528, '2021-01-31', 'TLD-1234', 'Matthew Michael Murdock', '0.1', '0.1', NULL, ''),
(529, '2021-01-31', 'TLD-1234', 'Floyd Lawton', '0.2', '0.2', NULL, ''),
(530, '2021-01-31', 'TLD-1234', 'Oliver Queen', '0.0', '0.0', NULL, ''),
(531, '2021-01-31', 'TLD-1234', 'Robert Bruce Banner', '0.0', '0.0', NULL, ''),
(532, '2021-01-31', 'TLD-1234', 'Hal Jordan', '0.1', '0.1', NULL, ''),
(533, '2021-01-31', 'TLD-1234', 'Peter Parker', '0.0', '0.0', NULL, ''),
(534, '2021-01-31', 'TLD-1234', 'Clark Kent', '0.2', '0.2', NULL, ''),
(535, '2021-01-31', 'TLD-1234', 'Natalia Allanovna Romanova', '0.2', '0.2', NULL, ''),
(536, '2021-01-31', 'TLD-1234', 'Walter Kovacs', '0.2', '0.2', NULL, ''),
(537, '2021-01-31', 'TLD-1234', 'Loki Laufeyson', '0.3', '0.3', NULL, ''),
(538, '2021-01-31', 'TLD-1234', 'Remy LeBeau', '0.0', '0.0', NULL, ''),
(539, '2021-01-31', 'TLD-1234', 'Alec Holland', '0.1', '0.1', NULL, ''),
(540, '2021-01-31', 'TLD-1234', 'Dru-Zod', '0.0', '0.0', NULL, ''),
(541, '2021-01-31', 'TLD-1234', 'Raven Darkholme', '0.1', '0.1', NULL, ''),
(542, '2021-01-31', 'TLD-1234', 'Adrian Veidt', '0.3', '0.3', NULL, 'yu890y0'),
(543, '2021-01-31', 'TLD-1234', 'Jonathan Osterman', '0.0', '0.0', NULL, ''),
(544, '2021-01-31', 'TLD-1234', 'Reed Richards', '0.0', '0.0', NULL, ''),
(558, '2021-06-04', 'TLD-1234', 'Alfred Pennyworth', '0.2', '0.9', NULL, NULL),
(569, '2021-10-01', 'TLD-1234', 'Hal Jordan', '5.0', '0.9', NULL, '');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `personale`
--

CREATE TABLE `personale` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `personel_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Data dump for tabellen `personale`
--

INSERT INTO `personale` (`id`, `name`, `category`, `personel_type`) VALUES
(1, 'James May', 'C', 'Fuldtids Netflix-seer'),
(2, 'Tony Stark', 'C', 'Bogholder'),
(3, 'Bruce Wayne', 'C', 'Kaptajn'),
(4, 'Barry Allen', 'C', 'Bogholder'),
(5, 'Donald J. Trump', 'C', 'Bogholder'),
(6, 'Diana Prince', 'C', 'Bogholder'),
(7, 'Arthur Curry', 'C', 'fiskeopdrætter'),
(8, 'Barbara Gordon', 'C', 'Bogholder'),
(9, 'Steven Rogers', 'C', 'Professionel senge-tester'),
(10, 'Billy Batson', 'C', 'Kaptajn'),
(11, 'Matthew Michael Murdock', 'C', 'Fuldtids Netflix-seer'),
(12, 'Floyd Lawton', 'C', 'Gartner'),
(13, 'Oliver Queen', 'C', 'fiskeopdrætter'),
(14, 'Robert Bruce Banner', 'C', 'Bogholder'),
(15, 'Hal Jordan', 'C', 'Bogholder'),
(16, 'Peter Parker', 'C', 'fiskeopdrætter'),
(17, 'Clark Kent', 'C', 'fiskeopdrætter'),
(18, 'Natalia Allanovna Romanova', 'C', 'Bogholder'),
(19, 'Walter Kovacs', 'C', 'fiskeopdrætter'),
(20, 'Loki Laufeyson', 'C', 'Bogholder'),
(21, 'Remy LeBeau', 'C', 'Bogholder'),
(22, 'Alec Holland', 'C', 'Gartner'),
(23, 'Dru-Zod', 'C', 'fiskeopdrætter'),
(24, 'Raven Darkholme', 'C', 'Professionel havfrue'),
(25, 'Adrian Veidt', 'C', 'Professionel havfrue'),
(26, 'Maz ‘Magnus’ Eisenhardt', 'C', 'Bogholder'),
(27, 'Jonathan Osterman', 'C', 'Bogholder'),
(28, 'Reed Richards', 'C', 'Bogholder');

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `historik`
--
ALTER TABLE `historik`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `personale`
--
ALTER TABLE `personale`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `historik`
--
ALTER TABLE `historik`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=665;

--
-- Tilføj AUTO_INCREMENT i tabel `personale`
--
ALTER TABLE `personale`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
