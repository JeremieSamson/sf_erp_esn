-- phpMyAdmin SQL Dump
-- version 4.3.11.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 16 Avril 2015 à 21:51
-- Version du serveur :  5.6.23
-- Version de PHP :  5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `esn_erp`
--

-- --------------------------------------------------------

--
-- Structure de la table `University`
--

CREATE TABLE IF NOT EXISTS `University` (
  `id` int(11) NOT NULL,
  `cigle` longtext COLLATE utf8_unicode_ci NOT NULL,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `University`
--

INSERT INTO `University` (`id`, `cigle`, `name`) VALUES
(92, 'EC-Lille', 'École centrale de Lille'),
(93, 'EDHEC', 'École des hautes Études commerciales du Nord'),
(94, 'ENSAM', 'École nationale supérieure d''arts et métiers'),
(95, 'ENSCL', 'École nationale supérieure de chimie de Lille'),
(96, 'Epitech', 'École pour l''informatique et les nouvelles technologies'),
(97, 'ESPE', 'Ecole SupÃ©rieure du Professorat et de l''Education'),
(98, 'ESAAT', 'Ecole Supérieure Arts Appliqués et Textile'),
(99, 'ESA Lille', 'École supérieure des affaires de Lille'),
(100, 'ESTIT', 'École supérieure des techniques industrielles et des textiles'),
(101, 'ICAM', 'Institut catholique d''arts et métiers'),
(102, 'IAE', 'Institut d''Administration des Entreprises'),
(103, 'IESEG', 'Institut d''économie scientifique et de gestion'),
(104, 'ISA', 'Institut supérieur d''agriculture de Lille'),
(105, 'ISEN', 'Institut supérieur de l''électronique et du numérique'),
(106, 'ISEFAC', 'Institut supérieur européen de formation par l''action'),
(107, 'ISEG', 'Institut supérieur européen de gestion'),
(108, 'Lille 1', 'Lille 1'),
(109, 'Lille 2', 'Lille 2'),
(110, 'Lille 3', 'Lille 3'),
(111, 'OTH', 'Non Etudiant'),
(112, 'Polytech', 'Polytech'),
(113, 'ESC Lille', 'Skema Business School'),
(114, 'Catho', 'Univeristé catholique de Lille');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `University`
--
ALTER TABLE `University`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `University`
--
ALTER TABLE `University`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=115;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
