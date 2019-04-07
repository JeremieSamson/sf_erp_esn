-- phpMyAdmin SQL Dump
-- version 4.3.12
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 04 Avril 2019 à 21:07
-- Version du serveur :  10.3.14-MariaDB
-- Version de PHP :  5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `esnlille_erp2`
--

-- --------------------------------------------------------

--
-- Structure de la table `Activity`
--

CREATE TABLE IF NOT EXISTS `Activity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `createdAt` datetime NOT NULL,
  `old` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `new` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3877 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Apply`
--

CREATE TABLE IF NOT EXISTS `Apply` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` date DEFAULT NULL,
  `motivation` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `skill` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `knowEsn` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality_id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `student` tinyint(1) NOT NULL,
  `olderasmus` tinyint(1) NOT NULL,
  `availabletime` int(11) NOT NULL,
  `mobile` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `archived` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=402 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `apply_country`
--

CREATE TABLE IF NOT EXISTS `apply_country` (
  `apply_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Caisse`
--

CREATE TABLE IF NOT EXISTS `Caisse` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `montant` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=349 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Card`
--

CREATE TABLE IF NOT EXISTS `Card` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=238 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Comment`
--

CREATE TABLE IF NOT EXISTS `Comment` (
  `id` int(11) NOT NULL,
  `thread_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `ancestors` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `depth` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `state` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Country`
--

CREATE TABLE IF NOT EXISTS `Country` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `EsnerFollow`
--

CREATE TABLE IF NOT EXISTS `EsnerFollow` (
  `id` int(11) NOT NULL,
  `trialstarted` datetime NOT NULL,
  `comment` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Operation`
--

CREATE TABLE IF NOT EXISTS `Operation` (
  `id` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `montant` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=302 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ParticipateTrip`
--

CREATE TABLE IF NOT EXISTS `ParticipateTrip` (
  `id` int(11) NOT NULL,
  `trip` int(11) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `dateInscription` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `PermanenceReport`
--

CREATE TABLE IF NOT EXISTS `PermanenceReport` (
  `id` int(11) NOT NULL,
  `amountBefore` decimal(10,2) NOT NULL,
  `amountAfter` decimal(10,2) NOT NULL,
  `amountSell` decimal(10,2) NOT NULL,
  `sellCard` int(11) NOT NULL,
  `availableCard` int(11) NOT NULL,
  `comments` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `owner_id` int(11) NOT NULL,
  `fivty` int(11) NOT NULL,
  `twenty` int(11) NOT NULL,
  `ten` int(11) NOT NULL,
  `five` int(11) NOT NULL,
  `two` int(11) NOT NULL,
  `one` int(11) NOT NULL,
  `fivtycent` int(11) NOT NULL,
  `twentycent` int(11) NOT NULL,
  `tencent` int(11) NOT NULL,
  `frequentation` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Pole`
--

CREATE TABLE IF NOT EXISTS `Pole` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `color` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Post`
--

CREATE TABLE IF NOT EXISTS `Post` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Rule`
--

CREATE TABLE IF NOT EXISTS `Rule` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Thread`
--

CREATE TABLE IF NOT EXISTS `Thread` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permalink` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_commentable` tinyint(1) NOT NULL,
  `num_comments` int(11) NOT NULL,
  `last_comment_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Trip`
--

CREATE TABLE IF NOT EXISTS `Trip` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `nb_place` int(11) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `University`
--

CREATE TABLE IF NOT EXISTS `University` (
  `id` int(11) NOT NULL,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cigle` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `galaxy_roles` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `section` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_section` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `galaxy_picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(13) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pole_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `mentor_id` int(11) DEFAULT NULL,
  `university_id` int(11) DEFAULT NULL,
  `nationality_id` int(11) DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hascare` tinyint(1) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `erasmus_year_start` date DEFAULT NULL,
  `erasmus_year_end` date DEFAULT NULL,
  `esncard` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `arrivalDate` date DEFAULT NULL,
  `leavingDate` date DEFAULT NULL,
  `esner` tinyint(1) NOT NULL,
  `inscription` date DEFAULT NULL,
  `study` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `erasmusProgramme_id` int(11) DEFAULT NULL,
  `follow_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1703 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Activity`
--
ALTER TABLE `Activity`
  ADD PRIMARY KEY (`id`), ADD KEY `IDX_55026B0CA76ED395` (`user_id`);

--
-- Index pour la table `Apply`
--
ALTER TABLE `Apply`
  ADD PRIMARY KEY (`id`), ADD KEY `IDX_7CEEA31B1C9DA55A` (`nationality_id`);

--
-- Index pour la table `apply_country`
--
ALTER TABLE `apply_country`
  ADD PRIMARY KEY (`apply_id`,`country_id`), ADD KEY `IDX_D3BBF05C4DDCCBDE` (`apply_id`), ADD KEY `IDX_D3BBF05CF92F3E70` (`country_id`);

--
-- Index pour la table `Caisse`
--
ALTER TABLE `Caisse`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Card`
--
ALTER TABLE `Card`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Comment`
--
ALTER TABLE `Comment`
  ADD PRIMARY KEY (`id`), ADD KEY `IDX_5BC96BF0E2904019` (`thread_id`), ADD KEY `IDX_5BC96BF0F675F31B` (`author_id`);

--
-- Index pour la table `Country`
--
ALTER TABLE `Country`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `EsnerFollow`
--
ALTER TABLE `EsnerFollow`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `Operation`
--
ALTER TABLE `Operation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ParticipateTrip`
--
ALTER TABLE `ParticipateTrip`
  ADD PRIMARY KEY (`id`), ADD KEY `IDX_E3253ECD7656F53B` (`trip`), ADD KEY `IDX_E3253ECD8D93D649` (`user`);

--
-- Index pour la table `PermanenceReport`
--
ALTER TABLE `PermanenceReport`
  ADD PRIMARY KEY (`id`), ADD KEY `IDX_F014AAC17E3C61F9` (`owner_id`);

--
-- Index pour la table `Pole`
--
ALTER TABLE `Pole`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Post`
--
ALTER TABLE `Post`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Rule`
--
ALTER TABLE `Rule`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Thread`
--
ALTER TABLE `Thread`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Trip`
--
ALTER TABLE `Trip`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `University`
--
ALTER TABLE `University`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_2DA1797792FC23A8` (`username_canonical`), ADD UNIQUE KEY `UNIQ_2DA17977A0D96FBF` (`email_canonical`), ADD UNIQUE KEY `UNIQ_2DA179778711D3BC` (`follow_id`), ADD KEY `IDX_2DA17977419C3385` (`pole_id`), ADD KEY `IDX_2DA179774B89032C` (`post_id`), ADD KEY `IDX_2DA1797797C22770` (`erasmusProgramme_id`), ADD KEY `IDX_2DA17977DB403044` (`mentor_id`), ADD KEY `IDX_2DA17977309D1878` (`university_id`), ADD KEY `IDX_2DA179771C9DA55` (`nationality_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Activity`
--
ALTER TABLE `Activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3877;
--
-- AUTO_INCREMENT pour la table `Apply`
--
ALTER TABLE `Apply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=402;
--
-- AUTO_INCREMENT pour la table `Caisse`
--
ALTER TABLE `Caisse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=349;
--
-- AUTO_INCREMENT pour la table `Card`
--
ALTER TABLE `Card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=238;
--
-- AUTO_INCREMENT pour la table `Comment`
--
ALTER TABLE `Comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Country`
--
ALTER TABLE `Country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=194;
--
-- AUTO_INCREMENT pour la table `EsnerFollow`
--
ALTER TABLE `EsnerFollow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT pour la table `Operation`
--
ALTER TABLE `Operation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=302;
--
-- AUTO_INCREMENT pour la table `ParticipateTrip`
--
ALTER TABLE `ParticipateTrip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT pour la table `PermanenceReport`
--
ALTER TABLE `PermanenceReport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=225;
--
-- AUTO_INCREMENT pour la table `Pole`
--
ALTER TABLE `Pole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT pour la table `Post`
--
ALTER TABLE `Post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `Rule`
--
ALTER TABLE `Rule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Trip`
--
ALTER TABLE `Trip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `University`
--
ALTER TABLE `University`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=117;
--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1703;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Activity`
--
ALTER TABLE `Activity`
ADD CONSTRAINT `FK_55026B0CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);

--
-- Contraintes pour la table `Apply`
--
ALTER TABLE `Apply`
ADD CONSTRAINT `FK_7CEEA31B1C9DA55A` FOREIGN KEY (`nationality_id`) REFERENCES `Country` (`id`);

--
-- Contraintes pour la table `apply_country`
--
ALTER TABLE `apply_country`
ADD CONSTRAINT `FK_D3BBF05C4DDCCBDE` FOREIGN KEY (`apply_id`) REFERENCES `Apply` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `FK_D3BBF05CF92F3E70` FOREIGN KEY (`country_id`) REFERENCES `Country` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Comment`
--
ALTER TABLE `Comment`
ADD CONSTRAINT `FK_5BC96BF0E2904019` FOREIGN KEY (`thread_id`) REFERENCES `Thread` (`id`),
ADD CONSTRAINT `FK_5BC96BF0F675F31B` FOREIGN KEY (`author_id`) REFERENCES `User` (`id`);

--
-- Contraintes pour la table `ParticipateTrip`
--
ALTER TABLE `ParticipateTrip`
ADD CONSTRAINT `FK_E3253ECD7656F53B` FOREIGN KEY (`trip`) REFERENCES `Trip` (`id`),
ADD CONSTRAINT `FK_E3253ECD8D93D649` FOREIGN KEY (`user`) REFERENCES `User` (`id`);

--
-- Contraintes pour la table `User`
--
ALTER TABLE `User`
ADD CONSTRAINT `FK_2DA179771C9DA55` FOREIGN KEY (`nationality_id`) REFERENCES `Country` (`id`),
ADD CONSTRAINT `FK_2DA17977309D1878` FOREIGN KEY (`university_id`) REFERENCES `University` (`id`),
ADD CONSTRAINT `FK_2DA17977419C3385` FOREIGN KEY (`pole_id`) REFERENCES `Pole` (`id`),
ADD CONSTRAINT `FK_2DA179774B89032C` FOREIGN KEY (`post_id`) REFERENCES `Post` (`id`),
ADD CONSTRAINT `FK_2DA179778711D3BC` FOREIGN KEY (`follow_id`) REFERENCES `EsnerFollow` (`id`),
ADD CONSTRAINT `FK_2DA1797797C22770` FOREIGN KEY (`erasmusProgramme_id`) REFERENCES `Country` (`id`),
ADD CONSTRAINT `FK_2DA17977DB403044` FOREIGN KEY (`mentor_id`) REFERENCES `User` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
