-- phpMyAdmin SQL Dump
-- version 4.3.11.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 16 Avril 2015 à 21:53
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
-- Structure de la table `Country`
--

CREATE TABLE IF NOT EXISTS `Country` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `Country`
--

INSERT INTO `Country` (`id`, `name`, `nationality`, `language`) VALUES
(1, 'Afghanistan', 'Afghan', 'language'),
(2, 'Albania', 'Albanian', 'language'),
(3, 'Algeria', 'Algerian', 'language'),
(4, 'Andorra', 'Andorran', 'language'),
(5, 'Angola', 'Angolan', 'language'),
(6, 'Antigua and Barbuda', 'Antiguans, Barbudans', 'language'),
(7, 'Argentina', 'Argentinean', 'language'),
(8, 'Armenia', 'Armenian', 'language'),
(9, 'Australia', 'Australian', 'language'),
(10, 'Austria', 'Austrian', 'language'),
(11, 'Azerbaijan', 'Azerbaijani', 'language'),
(12, 'The Bahamas', 'Bahamian', 'language'),
(13, 'Bahrain', 'Bahraini', 'language'),
(14, 'Bangladesh', 'Bangladeshi', 'language'),
(15, 'Barbados', 'Barbadian', 'language'),
(16, 'Belarus', 'Belarusian', 'language'),
(17, 'Belgium', 'Belgian', 'language'),
(18, 'Belize', 'Belizean', 'language'),
(19, 'Benin', 'Beninese', 'language'),
(20, 'Bhutan', 'Bhutanese', 'language'),
(21, 'Bolivia', 'Bolivian', 'language'),
(22, 'Bosnia and Herzegovina', 'Bosnian, Herzegovinian', 'language'),
(23, 'Botswana', 'Batswana', 'language'),
(24, 'Brazil', 'Brazilian', 'language'),
(25, 'Brunei', 'Bruneian', 'language'),
(26, 'Bulgaria', 'Bulgarian', 'language'),
(27, 'Burkina Faso', 'Burkinabe', 'language'),
(28, 'Burundi', 'Burundian', 'language'),
(29, 'Cambodia', 'Cambodian', 'language'),
(30, 'Cameroon', 'Cameroonian', 'language'),
(31, 'Canada', 'Canadian', 'language'),
(32, 'Cape Verde', 'Cape Verdian', 'language'),
(33, 'Central African Republic', 'Central African', 'language'),
(34, 'Chad', 'Chadian', 'language'),
(35, 'Chile', 'Chilean', 'language'),
(36, 'China', 'Chinese', 'language'),
(37, 'Colombia', 'Colombian', 'language'),
(38, 'Comoros', 'Comoran', 'language'),
(39, 'Congo, Republic of the', 'Congolese', 'language'),
(40, 'Congo, Democratic Republic of the', 'Congolese', 'language'),
(41, 'Costa Rica', 'Costa Rican', 'language'),
(42, 'Cote d''Ivoire', 'Ivorian', 'language'),
(43, 'Croatia', 'Croatian', 'language'),
(44, 'Cuba', 'Cuban', 'language'),
(45, 'Cyprus', 'Cypriot', 'language'),
(46, 'Czech Republic', 'Czech', 'language'),
(47, 'Denmark', 'Danish', 'language'),
(48, 'Djibouti', 'Djibouti', 'language'),
(49, 'Dominica', 'Dominican', 'language'),
(50, 'Dominican Republic', 'Dominican', 'language'),
(51, 'East Timor', 'East Timorese', 'language'),
(52, 'Ecuador', 'Ecuadorean', 'language'),
(53, 'Egypt', 'Egyptian', 'language'),
(54, 'El Salvador', 'Salvadoran', 'language'),
(55, 'Equatorial Guinea', 'Equatorial Guinean', 'language'),
(56, 'Eritrea', 'Eritrean', 'language'),
(57, 'Estonia', 'Estonian', 'language'),
(58, 'Ethiopia', 'Ethiopian', 'language'),
(59, 'Fiji', 'Fijian', 'language'),
(60, 'Finland', 'Finnish', 'language'),
(61, 'France', 'French', 'language'),
(62, 'Gabon', 'Gabonese', 'language'),
(63, 'The Gambia', 'Gambian', 'language'),
(64, 'Georgia', 'Georgian', 'language'),
(65, 'Germany', 'German', 'language'),
(66, 'Ghana', 'Ghanaian', 'language'),
(67, 'Greece', 'Greek', 'language'),
(68, 'Grenada', 'Grenadian', 'language'),
(69, 'Guatemala', 'Guatemalan', 'language'),
(70, 'Guinea', 'Guinean', 'language'),
(71, 'Guinea-Bissau', 'Guinea-Bissauan', 'language'),
(72, 'Guyana', 'Guyanese', 'language'),
(73, 'Haiti', 'Haitian', 'language'),
(74, 'Honduras', 'Honduran', 'language'),
(75, 'Hungary', 'Hungarian', 'language'),
(76, 'Iceland', 'Icelander', 'language'),
(77, 'India', 'Indian', 'language'),
(78, 'Indonesia', 'Indonesian', 'language'),
(79, 'Iran', 'Iranian', 'language'),
(80, 'Iraq', 'Iraqi', 'language'),
(81, 'Ireland', 'Irish', 'language'),
(82, 'Israel', 'Israeli', 'language'),
(83, 'Italy', 'Italian', 'language'),
(84, 'Jamaica', 'Jamaican', 'language'),
(85, 'Japan', 'Japanese', 'language'),
(86, 'Jordan', 'Jordanian', 'language'),
(87, 'Kazakhstan', 'Kazakhstani', 'language'),
(88, 'Kenya', 'Kenyan', 'language'),
(89, 'Kiribati', 'I-Kiribati', 'language'),
(90, 'Korea, North', 'North Korean', 'language'),
(91, 'Korea, South', 'South Korean', 'language'),
(92, 'Kuwait', 'Kuwaiti', 'language'),
(93, 'Kyrgyz Republic', 'Kirghiz', 'language'),
(94, 'Laos', 'Laotian', 'language'),
(95, 'Latvia', 'Latvian', 'language'),
(96, 'Lebanon', 'Lebanese', 'language'),
(97, 'Lesotho', 'Mosotho', 'language'),
(98, 'Liberia', 'Liberian', 'language'),
(99, 'Libya', 'Libyan', 'language'),
(100, 'Liechtenstein', 'Liechtensteiner', 'language'),
(101, 'Lithuania', 'Lithuanian', 'language'),
(102, 'Luxembourg', 'Luxembourger', 'language'),
(103, 'Macedonia', 'Macedonian', 'language'),
(104, 'Madagascar', 'Malagasy', 'language'),
(105, 'Malawi', 'Malawian', 'language'),
(106, 'Malaysia', 'Malaysian', 'language'),
(107, 'Maldives', 'Maldivan', 'language'),
(108, 'Mali', 'Malian', 'language'),
(109, 'Malta', 'Maltese', 'language'),
(110, 'Marshall Islands', 'Marshallese', 'language'),
(111, 'Mauritania', 'Mauritanian', 'language'),
(112, 'Mauritius', 'Mauritian', 'language'),
(113, 'Mexico', 'Mexican', 'language'),
(114, 'Federated States of Micronesia', 'Micronesian', 'language'),
(115, 'Moldova', 'Moldovan', 'language'),
(116, 'Monaco', 'Monegasque', 'language'),
(117, 'Mongolia', 'Mongolian', 'language'),
(118, 'Morocco', 'Moroccan', 'language'),
(119, 'Mozambique', 'Mozambican', 'language'),
(120, 'Myanmar (Burma);', 'Burmese', 'language'),
(121, 'Namibia', 'Namibian', 'language'),
(122, 'Nauru', 'Nauruan', 'language'),
(123, 'Nepal', 'Nepalese', 'language'),
(124, 'Netherlands', 'Dutch', 'language'),
(125, 'New Zealand', 'New Zealander', 'language'),
(126, 'Nicaragua', 'Nicaraguan', 'language'),
(127, 'Niger', 'Nigerien', 'language'),
(128, 'Nigeria', 'Nigerian', 'language'),
(129, 'Norway', 'Norwegian', 'language'),
(130, 'Oman', 'Omani', 'language'),
(131, 'Pakistan', 'Pakistani', 'language'),
(132, 'Palau', 'Palauan', 'language'),
(133, 'Panama', 'Panamanian', 'language'),
(134, 'Papua New Guinea', 'Papua New Guinean', 'language'),
(135, 'Paraguay', 'Paraguayan', 'language'),
(136, 'Peru', 'Peruvian', 'language'),
(137, 'Philippines', 'Filipino', 'language'),
(138, 'Poland', 'Polish', 'language'),
(139, 'Portugal', 'Portuguese', 'language'),
(140, 'Qatar', 'Qatari', 'language'),
(141, 'Romania', 'Romanian', 'language'),
(142, 'Russia', 'Russian', 'language'),
(143, 'Rwanda', 'Rwandan', 'language'),
(144, 'Saint Kitts and Nevis', 'Kittian and Nevisian', 'language'),
(145, 'Saint Lucia', 'Saint Lucian', 'language'),
(146, 'Samoa', 'Samoan', 'language'),
(147, 'San Marino', 'Sammarinese', 'language'),
(148, 'Sao Tome and Principe', 'Sao Tomean', 'language'),
(149, 'Saudi Arabia', 'Saudi Arabian', 'language'),
(150, 'Senegal', 'Senegalese', 'language'),
(151, 'Serbia and Montenegro', 'Serbian', 'language'),
(152, 'Seychelles', 'Seychellois', 'language'),
(153, 'Sierra Leone', 'Sierra Leonean', 'language'),
(154, 'Singapore', 'Singaporean', 'language'),
(155, 'Slovakia', 'Slovak', 'language'),
(156, 'Slovenia', 'Slovene', 'language'),
(157, 'Solomon Islands', 'Solomon Islander', 'language'),
(158, 'Somalia', 'Somali', 'language'),
(159, 'South Africa', 'South African', 'language'),
(160, 'Spain', 'Spanish', 'language'),
(161, 'Sri Lanka', 'Sri Lankan', 'language'),
(162, 'Sudan', 'Sudanese', 'language'),
(163, 'Suriname', 'Surinamer', 'language'),
(164, 'Swaziland', 'Swazi', 'language'),
(165, 'Sweden', 'Swedish', 'language'),
(166, 'Switzerland', 'Swiss', 'language'),
(167, 'Syria', 'Syrian', 'language'),
(168, 'Taiwan', 'Taiwanese', 'language'),
(169, 'Tajikistan', 'Tadzhik', 'language'),
(170, 'Tanzania', 'Tanzanian', 'language'),
(171, 'Thailand', 'Thai', 'language'),
(172, 'Togo', 'Togolese', 'language'),
(173, 'Tonga', 'Tongan', 'language'),
(174, 'Trinidad and Tobago', 'Trinidadian', 'language'),
(175, 'Tunisia', 'Tunisian', 'language'),
(176, 'Turkey', 'Turkish', 'language'),
(177, 'Turkmenistan', 'Turkmen', 'language'),
(178, 'Tuvalu', 'Tuvaluan', 'language'),
(179, 'Uganda', 'Ugandan', 'language'),
(180, 'Ukraine', 'Ukrainian', 'language'),
(181, 'United Arab Emirates', 'Emirian', 'language'),
(182, 'United Kingdom', 'British', 'language'),
(183, 'United States', 'American', 'language'),
(184, 'Uruguay', 'Uruguayan', 'language'),
(185, 'Uzbekistan', 'Uzbekistani', 'language'),
(186, 'Vanuatu', 'Ni-Vanuatu', 'language'),
(187, 'Vatican City (Holy See);', 'none', 'language'),
(188, 'Venezuela', 'Venezuelan', 'language'),
(189, 'Vietnam', 'Vietnamese', 'language'),
(190, 'Yemen', 'Yemeni', 'language'),
(191, 'Zambia', 'Zambian', 'language'),
(192, 'Zimbabwe', 'Zimbabwean', 'language');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Country`
--
ALTER TABLE `Country`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Country`
--
ALTER TABLE `Country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=193;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
