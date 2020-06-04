-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 03, 2020 at 02:46 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resa_v2`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `IsPlaceForReservation` (IN `idEtab` INT, IN `dateday` DATE, IN `arrival` TIME, IN `duration` INT, OUT `avaible` INT)  NO SQL
BEGIN
    SELECT SUM(src.places) - IFNULL((
        SELECT SUM(f.places) not_avaible 
        FROM reservation as r 
        INNER JOIN furniture as f ON r.idFurniture = f.id 
        WHERE r.idEtablishement = idEtab
        AND CAST(r.arrival as DATE) = dateday
        AND CAST(r.arrival as TIME) <= arrival
        AND CAST(FROM_UNIXTIME(UNIX_TIMESTAMP(r.arrival)+r.duration) as TIME) >= arrival LIMIT 1   
    ),0)  - IFNULL((
        SELECT SUM(f.places) not_avaible 
        FROM reservation as r 
        INNER JOIN furniture as f ON r.idFurniture = f.id 
        WHERE r.idEtablishement = idEtab
        AND CAST(r.arrival as DATE) = dateday
        AND CAST(r.arrival as TIME) >= arrival
        AND CAST(FROM_UNIXTIME(UNIX_TIMESTAMP(arrival)+duration) as TIME) >= r.arrival LIMIT 1
    ),0) avaible
    FROM (
        SELECT f.places 
        FROM `zone_has_schudle` as zhs 
        INNER JOIN schudle as s ON s.id = zhs.idSchudle 
        INNER JOIN zone as z ON z.id = zhs.idZone 
        LEFT JOIN has_furniture as hf ON hf.idZone = z.id
        LEFT JOIN furniture as f ON f.id = hf.idFurniture 
        WHERE CAST(s.begin as time) <= arrival 
        AND CAST(s.end as time) >= CAST(FROM_UNIXTIME(UNIX_TIMESTAMP(arrival)+duration) as TIME) 
        AND hf.idZone IS NOT NULL AND f.idEtablishement = idEtab
    ) src LIMIT 1;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `client_mark`
--

CREATE TABLE `client_mark` (
  `id` int(11) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idEtablishment` int(11) DEFAULT NULL,
  `mark` int(11) DEFAULT NULL,
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `Id` int(11) NOT NULL,
  `ISO` varchar(2) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Iso3` varchar(3) DEFAULT NULL,
  `NumCode` int(11) DEFAULT NULL,
  `PhoneCode` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`Id`, `ISO`, `Name`, `Iso3`, `NumCode`, `PhoneCode`) VALUES
(1, 'AF', 'Afghanistan', 'AFG', 4, 93),
(2, 'AL', 'Albania', 'ALB', 8, 355),
(3, 'DZ', 'Algeria', 'DZA', 12, 213),
(4, 'AS', 'American Samoa', 'ASM', 16, 1684),
(5, 'AD', 'Andorra', 'AND', 20, 376),
(6, 'AO', 'Angola', 'AGO', 24, 244),
(7, 'AI', 'Anguilla', 'AIA', 660, 1264),
(8, 'AQ', 'Antarctica', NULL, NULL, 0),
(9, 'AG', 'Antigua and Barbuda', 'ATG', 28, 1268),
(10, 'AR', 'Argentina', 'ARG', 32, 54),
(11, 'AM', 'Armenia', 'ARM', 51, 374),
(12, 'AW', 'Aruba', 'ABW', 533, 297),
(13, 'AU', 'Australia', 'AUS', 36, 61),
(14, 'AT', 'Austria', 'AUT', 40, 43),
(15, 'AZ', 'Azerbaijan', 'AZE', 31, 994),
(16, 'BS', 'Bahamas', 'BHS', 44, 1242),
(17, 'BH', 'Bahrain', 'BHR', 48, 973),
(18, 'BD', 'Bangladesh', 'BGD', 50, 880),
(19, 'BB', 'Barbados', 'BRB', 52, 1246),
(20, 'BY', 'Belarus', 'BLR', 112, 375),
(21, 'BE', 'Belgium', 'BEL', 56, 32),
(22, 'BZ', 'Belize', 'BLZ', 84, 501),
(23, 'BJ', 'Benin', 'BEN', 204, 229),
(24, 'BM', 'Bermuda', 'BMU', 60, 1441),
(25, 'BT', 'Bhutan', 'BTN', 64, 975),
(26, 'BO', 'Bolivia', 'BOL', 68, 591),
(27, 'BA', 'Bosnia and Herzegovina', 'BIH', 70, 387),
(28, 'BW', 'Botswana', 'BWA', 72, 267),
(29, 'BV', 'Bouvet Island', NULL, NULL, 0),
(30, 'BR', 'Brazil', 'BRA', 76, 55),
(31, 'IO', 'British Indian Ocean Territory', NULL, NULL, 246),
(32, 'BN', 'Brunei Darussalam', 'BRN', 96, 673),
(33, 'BG', 'Bulgaria', 'BGR', 100, 359),
(34, 'BF', 'Burkina Faso', 'BFA', 854, 226),
(35, 'BI', 'Burundi', 'BDI', 108, 257),
(36, 'KH', 'Cambodia', 'KHM', 116, 855),
(37, 'CM', 'Cameroon', 'CMR', 120, 237),
(38, 'CA', 'Canada', 'CAN', 124, 1),
(39, 'CV', 'Cape Verde', 'CPV', 132, 238),
(40, 'KY', 'Cayman Islands', 'CYM', 136, 1345),
(41, 'CF', 'Central African Republic', 'CAF', 140, 236),
(42, 'TD', 'Chad', 'TCD', 148, 235),
(43, 'CL', 'Chile', 'CHL', 152, 56),
(44, 'CN', 'China', 'CHN', 156, 86),
(45, 'CX', 'Christmas Island', NULL, NULL, 61),
(46, 'CC', 'Cocos (Keeling) Islands', NULL, NULL, 672),
(47, 'CO', 'Colombia', 'COL', 170, 57),
(48, 'KM', 'Comoros', 'COM', 174, 269),
(49, 'CG', 'Congo', 'COG', 178, 242),
(50, 'CD', 'Congo, the Democratic Republic of the', 'COD', 180, 242),
(51, 'CK', 'Cook Islands', 'COK', 184, 682),
(52, 'CR', 'Costa Rica', 'CRI', 188, 506),
(53, 'CI', 'Cote D\'Ivoire', 'CIV', 384, 225),
(54, 'HR', 'Croatia', 'HRV', 191, 385),
(55, 'CU', 'Cuba', 'CUB', 192, 53),
(56, 'CY', 'Cyprus', 'CYP', 196, 357),
(57, 'CZ', 'Czech Republic', 'CZE', 203, 420),
(58, 'DK', 'Denmark', 'DNK', 208, 45),
(59, 'DJ', 'Djibouti', 'DJI', 262, 253),
(60, 'DM', 'Dominica', 'DMA', 212, 1767),
(61, 'DO', 'Dominican Republic', 'DOM', 214, 1809),
(62, 'EC', 'Ecuador', 'ECU', 218, 593),
(63, 'EG', 'Egypt', 'EGY', 818, 20),
(64, 'SV', 'El Salvador', 'SLV', 222, 503),
(65, 'GQ', 'Equatorial Guinea', 'GNQ', 226, 240),
(66, 'ER', 'Eritrea', 'ERI', 232, 291),
(67, 'EE', 'Estonia', 'EST', 233, 372),
(68, 'ET', 'Ethiopia', 'ETH', 231, 251),
(69, 'FK', 'Falkland Islands (Malvinas)', 'FLK', 238, 500),
(70, 'FO', 'Faroe Islands', 'FRO', 234, 298),
(71, 'FJ', 'Fiji', 'FJI', 242, 679),
(72, 'FI', 'Finland', 'FIN', 246, 358),
(73, 'FR', 'France', 'FRA', 250, 33),
(74, 'GF', 'French Guiana', 'GUF', 254, 594),
(75, 'PF', 'French Polynesia', 'PYF', 258, 689),
(76, 'TF', 'French Southern Territories', NULL, NULL, 0),
(77, 'GA', 'Gabon', 'GAB', 266, 241),
(78, 'GM', 'Gambia', 'GMB', 270, 220),
(79, 'GE', 'Georgia', 'GEO', 268, 995),
(80, 'DE', 'Germany', 'DEU', 276, 49),
(81, 'GH', 'Ghana', 'GHA', 288, 233),
(82, 'GI', 'Gibraltar', 'GIB', 292, 350),
(83, 'GR', 'Greece', 'GRC', 300, 30),
(84, 'GL', 'Greenland', 'GRL', 304, 299),
(85, 'GD', 'Grenada', 'GRD', 308, 1473),
(86, 'GP', 'Guadeloupe', 'GLP', 312, 590),
(87, 'GU', 'Guam', 'GUM', 316, 1671),
(88, 'GT', 'Guatemala', 'GTM', 320, 502),
(89, 'GN', 'Guinea', 'GIN', 324, 224),
(90, 'GW', 'Guinea-Bissau', 'GNB', 624, 245),
(91, 'GY', 'Guyana', 'GUY', 328, 592),
(92, 'HT', 'Haiti', 'HTI', 332, 509),
(93, 'HM', 'Heard Island and Mcdonald Islands', NULL, NULL, 0),
(94, 'VA', 'Holy See (Vatican City State)', 'VAT', 336, 39),
(95, 'HN', 'Honduras', 'HND', 340, 504),
(96, 'HK', 'Hong Kong', 'HKG', 344, 852),
(97, 'HU', 'Hungary', 'HUN', 348, 36),
(98, 'IS', 'Iceland', 'ISL', 352, 354),
(99, 'IN', 'India', 'IND', 356, 91),
(100, 'ID', 'Indonesia', 'IDN', 360, 62),
(101, 'IR', 'Iran, Islamic Republic of', 'IRN', 364, 98),
(102, 'IQ', 'Iraq', 'IRQ', 368, 964),
(103, 'IE', 'Ireland', 'IRL', 372, 353),
(104, 'IL', 'Israel', 'ISR', 376, 972),
(105, 'IT', 'Italy', 'ITA', 380, 39),
(106, 'JM', 'Jamaica', 'JAM', 388, 1876),
(107, 'JP', 'Japan', 'JPN', 392, 81),
(108, 'JO', 'Jordan', 'JOR', 400, 962),
(109, 'KZ', 'Kazakhstan', 'KAZ', 398, 7),
(110, 'KE', 'Kenya', 'KEN', 404, 254),
(111, 'KI', 'Kiribati', 'KIR', 296, 686),
(112, 'KP', 'Korea, Democratic People\'s Republic of', 'PRK', 408, 850),
(113, 'KR', 'Korea, Republic of', 'KOR', 410, 82),
(114, 'KW', 'Kuwait', 'KWT', 414, 965),
(115, 'KG', 'Kyrgyzstan', 'KGZ', 417, 996),
(116, 'LA', 'Lao People\'s Democratic Republic', 'LAO', 418, 856),
(117, 'LV', 'Latvia', 'LVA', 428, 371),
(118, 'LB', 'Lebanon', 'LBN', 422, 961),
(119, 'LS', 'Lesotho', 'LSO', 426, 266),
(120, 'LR', 'Liberia', 'LBR', 430, 231),
(121, 'LY', 'Libyan Arab Jamahiriya', 'LBY', 434, 218),
(122, 'LI', 'Liechtenstein', 'LIE', 438, 423),
(123, 'LT', 'Lithuania', 'LTU', 440, 370),
(124, 'LU', 'Luxembourg', 'LUX', 442, 352),
(125, 'MO', 'Macao', 'MAC', 446, 853),
(126, 'MK', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389),
(127, 'MG', 'Madagascar', 'MDG', 450, 261),
(128, 'MW', 'Malawi', 'MWI', 454, 265),
(129, 'MY', 'Malaysia', 'MYS', 458, 60),
(130, 'MV', 'Maldives', 'MDV', 462, 960),
(131, 'ML', 'Mali', 'MLI', 466, 223),
(132, 'MT', 'Malta', 'MLT', 470, 356),
(133, 'MH', 'Marshall Islands', 'MHL', 584, 692),
(134, 'MQ', 'Martinique', 'MTQ', 474, 596),
(135, 'MR', 'Mauritania', 'MRT', 478, 222),
(136, 'MU', 'Mauritius', 'MUS', 480, 230),
(137, 'YT', 'Mayotte', NULL, NULL, 269),
(138, 'MX', 'Mexico', 'MEX', 484, 52),
(139, 'FM', 'Micronesia, Federated States of', 'FSM', 583, 691),
(140, 'MD', 'Moldova, Republic of', 'MDA', 498, 373),
(141, 'MC', 'Monaco', 'MCO', 492, 377),
(142, 'MN', 'Mongolia', 'MNG', 496, 976),
(143, 'MS', 'Montserrat', 'MSR', 500, 1664),
(144, 'MA', 'Morocco', 'MAR', 504, 212),
(145, 'MZ', 'Mozambique', 'MOZ', 508, 258),
(146, 'MM', 'Myanmar', 'MMR', 104, 95),
(147, 'NA', 'Namibia', 'NAM', 516, 264),
(148, 'NR', 'Nauru', 'NRU', 520, 674),
(149, 'NP', 'Nepal', 'NPL', 524, 977),
(150, 'NL', 'Netherlands', 'NLD', 528, 31),
(151, 'AN', 'Netherlands Antilles', 'ANT', 530, 599),
(152, 'NC', 'New Caledonia', 'NCL', 540, 687),
(153, 'NZ', 'New Zealand', 'NZL', 554, 64),
(154, 'NI', 'Nicaragua', 'NIC', 558, 505),
(155, 'NE', 'Niger', 'NER', 562, 227),
(156, 'NG', 'Nigeria', 'NGA', 566, 234),
(157, 'NU', 'Niue', 'NIU', 570, 683),
(158, 'NF', 'Norfolk Island', 'NFK', 574, 672),
(159, 'MP', 'Northern Mariana Islands', 'MNP', 580, 1670),
(160, 'NO', 'Norway', 'NOR', 578, 47),
(161, 'OM', 'Oman', 'OMN', 512, 968),
(162, 'PK', 'Pakistan', 'PAK', 586, 92),
(163, 'PW', 'Palau', 'PLW', 585, 680),
(164, 'PS', 'Palestinian Territory, Occupied', NULL, NULL, 970),
(165, 'PA', 'Panama', 'PAN', 591, 507),
(166, 'PG', 'Papua New Guinea', 'PNG', 598, 675),
(167, 'PY', 'Paraguay', 'PRY', 600, 595),
(168, 'PE', 'Peru', 'PER', 604, 51),
(169, 'PH', 'Philippines', 'PHL', 608, 63),
(170, 'PN', 'Pitcairn', 'PCN', 612, 0),
(171, 'PL', 'Poland', 'POL', 616, 48),
(172, 'PT', 'Portugal', 'PRT', 620, 351),
(173, 'PR', 'Puerto Rico', 'PRI', 630, 1787),
(174, 'QA', 'Qatar', 'QAT', 634, 974),
(175, 'RE', 'Reunion', 'REU', 638, 262),
(176, 'RO', 'Romania', 'ROM', 642, 40),
(177, 'RU', 'Russian Federation', 'RUS', 643, 70),
(178, 'RW', 'Rwanda', 'RWA', 646, 250),
(179, 'SH', 'Saint Helena', 'SHN', 654, 290),
(180, 'KN', 'Saint Kitts and Nevis', 'KNA', 659, 1869),
(181, 'LC', 'Saint Lucia', 'LCA', 662, 1758),
(182, 'PM', 'Saint Pierre and Miquelon', 'SPM', 666, 508),
(183, 'VC', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784),
(184, 'WS', 'Samoa', 'WSM', 882, 684),
(185, 'SM', 'San Marino', 'SMR', 674, 378),
(186, 'ST', 'Sao Tome and Principe', 'STP', 678, 239),
(187, 'SA', 'Saudi Arabia', 'SAU', 682, 966),
(188, 'SN', 'Senegal', 'SEN', 686, 221),
(189, 'CS', 'Serbia and Montenegro', NULL, NULL, 381),
(190, 'SC', 'Seychelles', 'SYC', 690, 248),
(191, 'SL', 'Sierra Leone', 'SLE', 694, 232),
(192, 'SG', 'Singapore', 'SGP', 702, 65),
(193, 'SK', 'Slovakia', 'SVK', 703, 421),
(194, 'SI', 'Slovenia', 'SVN', 705, 386),
(195, 'SB', 'Solomon Islands', 'SLB', 90, 677),
(196, 'SO', 'Somalia', 'SOM', 706, 252),
(197, 'ZA', 'South Africa', 'ZAF', 710, 27),
(198, 'GS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0),
(199, 'ES', 'Spain', 'ESP', 724, 34),
(200, 'LK', 'Sri Lanka', 'LKA', 144, 94),
(201, 'SD', 'Sudan', 'SDN', 736, 249),
(202, 'SR', 'Suriname', 'SUR', 740, 597),
(203, 'SJ', 'Svalbard and Jan Mayen', 'SJM', 744, 47),
(204, 'SZ', 'Swaziland', 'SWZ', 748, 268),
(205, 'SE', 'Sweden', 'SWE', 752, 46),
(206, 'CH', 'Switzerland', 'CHE', 756, 41),
(207, 'SY', 'Syrian Arab Republic', 'SYR', 760, 963),
(208, 'TW', 'Taiwan, Province of China', 'TWN', 158, 886),
(209, 'TJ', 'Tajikistan', 'TJK', 762, 992),
(210, 'TZ', 'Tanzania, United Republic of', 'TZA', 834, 255),
(211, 'TH', 'Thailand', 'THA', 764, 66),
(212, 'TL', 'Timor-Leste', NULL, NULL, 670),
(213, 'TG', 'Togo', 'TGO', 768, 228),
(214, 'TK', 'Tokelau', 'TKL', 772, 690),
(215, 'TO', 'Tonga', 'TON', 776, 676),
(216, 'TT', 'Trinidad and Tobago', 'TTO', 780, 1868),
(217, 'TN', 'Tunisia', 'TUN', 788, 216),
(218, 'TR', 'Turkey', 'TUR', 792, 90),
(219, 'TM', 'Turkmenistan', 'TKM', 795, 7370),
(220, 'TC', 'Turks and Caicos Islands', 'TCA', 796, 1649),
(221, 'TV', 'Tuvalu', 'TUV', 798, 688),
(222, 'UG', 'Uganda', 'UGA', 800, 256),
(223, 'UA', 'Ukraine', 'UKR', 804, 380),
(224, 'AE', 'United Arab Emirates', 'ARE', 784, 971),
(225, 'GB', 'United Kingdom', 'GBR', 826, 44),
(226, 'US', 'United States', 'USA', 840, 1),
(227, 'UM', 'United States Minor Outlying Islands', NULL, NULL, 1),
(228, 'UY', 'Uruguay', 'URY', 858, 598),
(229, 'UZ', 'Uzbekistan', 'UZB', 860, 998),
(230, 'VU', 'Vanuatu', 'VUT', 548, 678),
(231, 'VE', 'Venezuela', 'VEN', 862, 58),
(232, 'VN', 'Viet Nam', 'VNM', 704, 84),
(233, 'VG', 'Virgin Islands, British', 'VGB', 92, 1284),
(234, 'VI', 'Virgin Islands, U.s.', 'VIR', 850, 1340),
(235, 'WF', 'Wallis and Futuna', 'WLF', 876, 681),
(236, 'EH', 'Western Sahara', 'ESH', 732, 212),
(237, 'YE', 'Yemen', 'YEM', 887, 967),
(238, 'ZM', 'Zambia', 'ZMB', 894, 260),
(239, 'ZW', 'Zimbabwe', 'ZWE', 716, 263);

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`id`, `name`) VALUES
(1, 'Lundi'),
(2, 'Mardi'),
(3, 'Mercredi'),
(4, 'Jeudi'),
(5, 'Vendredi'),
(6, 'Samedi'),
(7, 'Dimanche');

-- --------------------------------------------------------

--
-- Table structure for table `dish`
--

CREATE TABLE `dish` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `idType` int(11) DEFAULT NULL,
  `price` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dish`
--

INSERT INTO `dish` (`id`, `name`, `idType`, `price`) VALUES
(1, 'Carpacio de Saumon', 1, 12),
(2, 'Salade verte', 1, 7.5),
(3, 'Tartare de Saumon (Servi avec Frites et Toast)', 2, 22),
(4, 'Steack de boeuf', 2, 39),
(5, 'Mousse au chocolat', 3, 10),
(6, 'Tarte au citron', 3, 8),
(7, 'Boule de glace', 3, 3),
(8, 'Coca', 5, 3.5),
(9, 'Limonade', 5, 3),
(10, 'Vin blanc de Genève', 6, 8);

-- --------------------------------------------------------

--
-- Table structure for table `dish_has_image`
--

CREATE TABLE `dish_has_image` (
  `idDish` int(11) DEFAULT NULL,
  `idImages` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dish_has_image`
--

INSERT INTO `dish_has_image` (`idDish`, `idImages`) VALUES
(1, '5ea34d38ee6a4'),
(2, '5ea34d3f55041'),
(3, '5ea34d45754e4'),
(4, '5ea34d4aacc78'),
(5, '5ea34d54626b5'),
(6, '5ea34d5a982a1'),
(7, '5ea34d60d5b71'),
(8, '5ea34d65b0f8d'),
(9, '5ea34d6f0c57f'),
(10, '5ea3518831bbb');

-- --------------------------------------------------------

--
-- Table structure for table `dish_type`
--

CREATE TABLE `dish_type` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dish_type`
--

INSERT INTO `dish_type` (`id`, `name`) VALUES
(1, 'Entrance'),
(2, 'Main'),
(3, 'Dessert'),
(4, 'Soup'),
(5, 'Soda'),
(6, 'Vine');

-- --------------------------------------------------------

--
-- Table structure for table `establishment`
--

CREATE TABLE `establishment` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `id_subscription` int(1) NOT NULL DEFAULT '1' COMMENT 'l''id de l''abonnement',
  `street` varchar(200) NOT NULL,
  `npa` int(10) NOT NULL,
  `city` varchar(50) NOT NULL,
  `country` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `establishment`
--

INSERT INTO `establishment` (`id`, `name`, `phone`, `email`, `id_menu`, `id_subscription`, `street`, `npa`, `city`, `country`) VALUES
(1, 'Port Martignot', '022 354 75 34', 'info@portmartignot.ch', 1, 3, '', 0, '', 1),
(2, 'Beau-Rivage', '022 716 66 66', 'restauration@beau-rivage.ch', 2, 2, '', 0, '', 1),
(3, 'Les Clochettes', '0796636738', 'info@clochettes.ch', NULL, 3, '', 0, '', 1),
(5, 'Le chat', '022 463 73 82', 'info@chat.ch', NULL, 1, '', 0, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `etablishement_has_image`
--

CREATE TABLE `etablishement_has_image` (
  `idEtablishement` int(11) DEFAULT NULL,
  `idImages` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etablishement_has_image`
--

INSERT INTO `etablishement_has_image` (`idEtablishement`, `idImages`) VALUES
(1, '5ea34cf985371'),
(1, '5ea34cff43b9f'),
(2, '5ea34d07084f7'),
(2, '5ea34d0c19635'),
(2, '5ea34d121686d'),
(3, '5ea34d19c790b'),
(5, '5eaa7d4869833');

-- --------------------------------------------------------

--
-- Table structure for table `floor`
--

CREATE TABLE `floor` (
  `id` int(11) NOT NULL,
  `idEtablishment` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `floor`
--

INSERT INTO `floor` (`id`, `idEtablishment`, `name`) VALUES
(1, 1, 'Terasse'),
(2, 1, 'Salle principale'),
(3, 2, 'Salle Royale'),
(4, 2, 'Salle du jet d\'eau'),
(7, 1, 'Cave'),
(10, 1, '2ème sous-sol');

-- --------------------------------------------------------

--
-- Table structure for table `furniture`
--

CREATE TABLE `furniture` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `places` int(11) DEFAULT NULL,
  `idType` int(11) DEFAULT NULL,
  `idShape` int(11) DEFAULT NULL,
  `idEtablishement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `furniture`
--

INSERT INTO `furniture` (`id`, `name`, `color`, `places`, `idType`, `idShape`, `idEtablishement`) VALUES
(1, 'Curran', 'Bleu', 5, 4, 2, 1),
(2, 'Angelica', 'Bleu', 6, 2, 1, 1),
(3, 'Celeste', 'Bleu', 8, 1, 2, 1),
(4, 'May', 'Bleu', 1, 1, 3, 1),
(5, 'Sybil', 'Bleu', 2, 1, 2, 1),
(6, 'Whitney', 'Bleu', 9, 2, 4, 1),
(7, 'Eaton', 'Bleu', 7, 3, 4, 1),
(8, 'Scott', 'Bleu', 1, 4, 1, 16),
(9, 'Kennedy', 'Bleu', 3, 4, 3, 16),
(10, 'Nissim', 'Bleu', 9, 2, 2, 16),
(11, 'Amber', 'Bleu', 3, 2, 2, 16),
(12, 'Caesar', 'Bleu', 6, 4, 3, 16),
(13, 'Odysseus', 'Bleu', 9, 2, 3, 1),
(14, 'Vernon', 'Bleu', 8, 2, 4, 1),
(15, 'Aiko', 'Bleu', 6, 4, 1, 1),
(16, 'Prescott', 'Bleu', 10, 1, 2, 1),
(17, 'Flavia', 'Bleu', 1, 2, 4, 0),
(18, 'Maryam', 'Bleu', 8, 1, 1, 0),
(19, 'Graiden', 'Bleu', 3, 3, 2, 0),
(20, 'Bernard', 'Bleu', 5, 4, 1, 0),
(21, 'Bethany', 'Bleu', 3, 2, 3, 0),
(22, 'Quintessa', 'Bleu', 6, 3, 4, 0),
(23, 'Zephania', 'Bleu', 10, 3, 3, 0),
(24, 'Zorita', 'Bleu', 5, 3, 3, 0),
(25, 'Rooney', 'Bleu', 5, 1, 1, 0),
(26, 'Ralph', 'Bleu', 9, 2, 4, 0),
(27, 'Clinton', 'Bleu', 10, 3, 1, 0),
(28, 'Ignacia', 'Bleu', 1, 4, 2, 0),
(29, 'Courtney', 'Bleu', 2, 1, 4, 0),
(30, 'Imani', 'Bleu', 10, 1, 3, 0),
(31, 'Kaden', 'Bleu', 8, 4, 2, 0),
(32, 'Charde', 'Bleu', 5, 1, 2, 0),
(33, 'Cally', 'Bleu', 5, 1, 1, 0),
(34, 'Kitra', 'Bleu', 9, 3, 3, 0),
(35, 'Chloe', 'Bleu', 8, 4, 1, 0),
(36, 'Isabella', 'Bleu', 6, 4, 4, 0),
(37, 'Hayden', 'Bleu', 4, 3, 2, 0),
(38, 'Yeo', 'Bleu', 10, 3, 2, 0),
(39, 'Emi', 'Bleu', 8, 4, 4, 0),
(40, 'Malachi', 'Bleu', 9, 2, 1, 0),
(41, 'Kelsie', 'Bleu', 9, 3, 1, 0),
(42, 'Dolan', 'Bleu', 5, 2, 1, 0),
(43, 'Troy', 'Bleu', 2, 3, 1, 0),
(44, 'Isaiah', 'Bleu', 7, 1, 1, 0),
(45, 'Ishmael', 'Bleu', 5, 4, 4, 0),
(46, 'Cruz', 'Bleu', 9, 4, 1, 0),
(47, 'Kirsten', 'Bleu', 4, 4, 1, 0),
(48, 'Kadeem', 'Bleu', 2, 3, 2, 0),
(49, 'Orson', 'Bleu', 8, 2, 4, 0),
(50, 'Britanni', 'Bleu', 5, 4, 4, 0),
(51, 'Abdul', 'Bleu', 6, 2, 3, 0),
(52, 'Merritt', 'Bleu', 9, 2, 2, 0),
(53, 'Nissim', 'Bleu', 2, 3, 4, 0),
(54, 'Lee', 'Bleu', 1, 4, 4, 0),
(55, 'Connor', 'Bleu', 8, 3, 4, 0),
(56, 'Abigail', 'Bleu', 10, 1, 2, 0),
(57, 'Marny', 'Bleu', 8, 2, 1, 0),
(58, 'Yoshio', 'Bleu', 5, 3, 2, 0),
(59, 'Aileen', 'Bleu', 3, 2, 4, 0),
(60, 'Philip', 'Bleu', 9, 1, 2, 0),
(61, 'Gregory', 'Bleu', 2, 3, 4, 0),
(62, 'Gavin', 'Bleu', 9, 2, 4, 0),
(63, 'Byron', 'Bleu', 6, 2, 2, 0),
(64, 'Armando', 'Bleu', 1, 1, 4, 0),
(65, 'Amaya', 'Bleu', 3, 4, 3, 0),
(66, 'Cailin', 'Bleu', 4, 2, 2, 0),
(67, 'MacKenzie', 'Bleu', 7, 2, 2, 0),
(68, 'Althea', 'Bleu', 2, 2, 3, 0),
(69, 'Quyn', 'Bleu', 9, 2, 3, 0),
(70, 'Lance', 'Bleu', 5, 3, 3, 0),
(71, 'Kay', 'Bleu', 9, 3, 2, 0),
(72, 'Barry', 'Bleu', 6, 2, 1, 0),
(73, 'Deborah', 'Bleu', 10, 1, 1, 0),
(74, 'Preston', 'Bleu', 1, 4, 3, 0),
(75, 'Tyler', 'Bleu', 8, 4, 1, 0),
(76, 'Maisie', 'Bleu', 1, 1, 3, 0),
(77, 'Bruno', 'Bleu', 3, 4, 4, 0),
(78, 'Gail', 'Bleu', 7, 1, 1, 0),
(79, 'Eleanor', 'Bleu', 7, 3, 4, 0),
(80, 'Hilda', 'Bleu', 6, 1, 1, 0),
(81, 'Armando', 'Bleu', 3, 3, 1, 0),
(82, 'Neville', 'Bleu', 1, 2, 2, 0),
(83, 'Miriam', 'Bleu', 6, 4, 1, 0),
(84, 'Sloane', 'Bleu', 1, 3, 2, 0),
(85, 'Inez', 'Bleu', 2, 1, 1, 0),
(86, 'Simone', 'Bleu', 2, 3, 1, 0),
(87, 'Naida', 'Bleu', 8, 1, 2, 0),
(88, 'Davis', 'Bleu', 9, 2, 4, 0),
(89, 'Donovan', 'Bleu', 7, 3, 1, 0),
(90, 'Medge', 'Bleu', 10, 3, 4, 0),
(91, 'Gray', 'Bleu', 5, 1, 2, 0),
(92, 'Maile', 'Bleu', 6, 4, 2, 0),
(93, 'Carson', 'Bleu', 6, 3, 2, 0),
(94, 'Quinlan', 'Bleu', 4, 1, 3, 0),
(95, 'Claire', 'Bleu', 8, 2, 2, 0),
(96, 'Marah', 'Bleu', 7, 3, 1, 0),
(97, 'Leilani', 'Bleu', 2, 2, 2, 0),
(98, 'Mason', 'Bleu', 10, 4, 3, 0),
(99, 'Lucian', 'Bleu', 10, 4, 1, 0),
(100, 'Janna', 'Bleu', 9, 3, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `furniture_has_schudle`
--

CREATE TABLE `furniture_has_schudle` (
  `idFurniture` int(11) DEFAULT NULL,
  `idSchudle` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `furniture_has_schudle`
--

INSERT INTO `furniture_has_schudle` (`idFurniture`, `idSchudle`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `furniture_shape`
--

CREATE TABLE `furniture_shape` (
  `id` int(11) NOT NULL,
  `shape` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `furniture_shape`
--

INSERT INTO `furniture_shape` (`id`, `shape`) VALUES
(1, 'Ronde'),
(2, 'Carrée'),
(3, 'Ovale'),
(4, 'Différente');

-- --------------------------------------------------------

--
-- Table structure for table `furniture_type`
--

CREATE TABLE `furniture_type` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `furniture_type`
--

INSERT INTO `furniture_type` (`id`, `type`) VALUES
(1, 'Basse'),
(2, 'Assise'),
(3, 'Haute'),
(4, 'Comptoir');

-- --------------------------------------------------------

--
-- Table structure for table `habits`
--

CREATE TABLE `habits` (
  `id` int(11) NOT NULL,
  `idEtablishment` int(11) DEFAULT NULL,
  `comments` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `has_furniture`
--

CREATE TABLE `has_furniture` (
  `idZone` int(11) DEFAULT NULL,
  `idFurniture` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `has_furniture`
--

INSERT INTO `has_furniture` (`idZone`, `idFurniture`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(3, 6),
(3, 7),
(23, 8),
(23, 9),
(24, 10),
(24, 11),
(23, 12),
(22, 13),
(22, 14),
(22, 15),
(1, 16);

-- --------------------------------------------------------

--
-- Table structure for table `has_habits`
--

CREATE TABLE `has_habits` (
  `idUser` int(11) DEFAULT NULL,
  `idHabit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `has_reservation`
--

CREATE TABLE `has_reservation` (
  `idZone` int(11) DEFAULT NULL,
  `idReservation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `has_reservation`
--

INSERT INTO `has_reservation` (`idZone`, `idReservation`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `has_zone`
--

CREATE TABLE `has_zone` (
  `idFloor` int(11) DEFAULT NULL,
  `idZone` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `has_zone`
--

INSERT INTO `has_zone` (`idFloor`, `idZone`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(2, 5),
(3, 6),
(3, 7),
(4, 8),
(4, 9),
(1, 11),
(2, 13),
(7, 16),
(7, 17),
(1, 20),
(1, 21),
(10, 22),
(10, 25),
(1, 26);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` varchar(200) NOT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `path` text,
  `postedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `alt`, `path`, `postedby`) VALUES
('5ea34cf985371', NULL, 'images/restaurant/5ea34cf985371.jpg', 1),
('5ea34cff43b9f', NULL, 'images/restaurant/5ea34cff43b9f.jpg', 1),
('5ea34d07084f7', NULL, 'images/restaurant/5ea34d07084f7.jpg', 1),
('5ea34d0c19635', NULL, 'images/restaurant/5ea34d0c19635.jpg', 1),
('5ea34d121686d', NULL, 'images/restaurant/5ea34d121686d.jpg', 1),
('5ea34d19c790b', NULL, 'images/restaurant/5ea34d19c790b.jpg', 1),
('5ea34d38ee6a4', NULL, 'images/dish/5ea34d38ee6a4.jpg', 1),
('5ea34d3f55041', NULL, 'images/dish/5ea34d3f55041.jpg', 1),
('5ea34d45754e4', NULL, 'images/dish/5ea34d45754e4.jpg', 1),
('5ea34d4aacc78', NULL, 'images/dish/5ea34d4aacc78.jpg', 1),
('5ea34d54626b5', NULL, 'images/dish/5ea34d54626b5.jpg', 1),
('5ea34d5a982a1', NULL, 'images/dish/5ea34d5a982a1.jpg', 1),
('5ea34d60d5b71', NULL, 'images/dish/5ea34d60d5b71.jpg', 1),
('5ea34d65b0f8d', NULL, 'images/dish/5ea34d65b0f8d.jpg', 1),
('5ea34d6f0c57f', NULL, 'images/dish/5ea34d6f0c57f.jpg', 1),
('5ea3518831bbb', NULL, 'images/dish/5ea3518831bbb.jpg', 1),
('5ea9973bf332c', NULL, 'images/user/5ea9973bf332c.png', 1),
('5ea9978172cc1', NULL, 'images/user/5ea9978172cc1.jpg', 1),
('5eaa7d4869833', NULL, 'images/restaurant/5eaa7d4869833.jpg', 1),
('5eaa7d4f64c0f', NULL, 'images/restaurant/5eaa7d4f64c0f.jpg', 1),
('5eaae62c38dc4', NULL, 'images/restaurant/5eaae62c38dc4.png', 1),
('5eaae64b3b261', NULL, 'images/restaurant/5eaae64b3b261.png', 1),
('5eaae854494ab', NULL, 'images/restaurant/5eaae854494ab.jpg', 2),
('5eaae8fa82959', NULL, 'images/restaurant/5eaae8fa82959.jpg', 2),
('5eaaecb1c4cee', NULL, 'images/restaurant/5eaaecb1c4cee.jpg', 2),
('5eaaed0541183', NULL, 'images/restaurant/5eaaed0541183.jpg', 2),
('5eaaed6292795', NULL, 'images/restaurant/5eaaed6292795.jpg', 2),
('5eaaedf8ea34f', NULL, 'images/restaurant/5eaaedf8ea34f.jpg', 2),
('5eafcdd7b43fb', NULL, 'images/restaurant/5eafcdd7b43fb.jpg', 2),
('5eb508c56b1b1', NULL, 'images/restaurant/5eb508c56b1b1.jpg', 2),
('5eb508c56bf0d', NULL, 'images/restaurant/5eb508c56bf0d.jpg', 2),
('5eb508c56cae5', NULL, 'images/restaurant/5eb508c56cae5.jpg', 2),
('5eb508c56d6c6', NULL, 'images/restaurant/5eb508c56d6c6.jpg', 2),
('5eb508c56e7a2', NULL, 'images/restaurant/5eb508c56e7a2.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `is_in_as`
--

CREATE TABLE `is_in_as` (
  `idUser` int(11) DEFAULT NULL,
  `idEtablishement` int(11) DEFAULT NULL,
  `idPermission` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `is_in_as`
--

INSERT INTO `is_in_as` (`idUser`, `idEtablishement`, `idPermission`) VALUES
(2, 1, 2),
(3, 1, 3),
(4, 1, 3),
(5, 2, 3),
(NULL, 3, 3),
(2, 3, 3),
(1, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `meal`
--

CREATE TABLE `meal` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `entrance` int(11) DEFAULT NULL,
  `main` int(11) DEFAULT NULL,
  `dessert` int(11) DEFAULT NULL,
  `drink` int(11) DEFAULT NULL,
  `price` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `meal`
--

INSERT INTO `meal` (`id`, `name`, `entrance`, `main`, `dessert`, `drink`, `price`) VALUES
(1, 'La découverte', 2, 3, 6, NULL, 59),
(2, 'La joie', 1, 4, 5, 10, 0),
(3, '1000 m sous la mer', 1, 3, 6, 8, 49.9);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`) VALUES
(1, 'La joie de la mer', 'Ce menu va vous faire découvrir les joies de la mer à la façon de marco'),
(2, 'Bienvenu à Genève', 'Ce menu provient uniquement de Genève !'),
(3, 'Une traversée des montages ', 'Ce menu vous proposera dess plat montagnards');

-- --------------------------------------------------------

--
-- Table structure for table `menu_has_dishes`
--

CREATE TABLE `menu_has_dishes` (
  `idMenu` int(11) DEFAULT NULL,
  `idDish` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_has_dishes`
--

INSERT INTO `menu_has_dishes` (`idMenu`, `idDish`) VALUES
(1, 1),
(1, 5),
(1, 6),
(1, 3),
(2, 2),
(2, 4),
(2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `menu_has_meal`
--

CREATE TABLE `menu_has_meal` (
  `idMenu` int(11) NOT NULL,
  `idMeal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_has_meal`
--

INSERT INTO `menu_has_meal` (`idMenu`, `idMeal`) VALUES
(2, 1),
(2, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `method_used`
--

CREATE TABLE `method_used` (
  `idReservation` int(11) DEFAULT NULL,
  `idMethod` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `opening`
--

CREATE TABLE `opening` (
  `idEtablishement` int(11) NOT NULL,
  `idSchudle` int(11) NOT NULL,
  `idDay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `opening`
--

INSERT INTO `opening` (`idEtablishement`, `idSchudle`, `idDay`) VALUES
(1, 12, 2),
(1, 12, 3),
(1, 10, 5),
(1, 10, 6),
(5, 12, 1),
(5, 12, 2),
(5, 12, 3),
(5, 12, 4),
(1, 12, 4),
(1, 12, 5);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `name`, `level`) VALUES
(1, 'Administrateur', 1),
(2, 'Manager', 2),
(3, 'Serveur', 3),
(4, 'Stagiaire', 4),
(5, 'Client', 5),
(6, 'Invité', 6),
(7, 'Chef Cusinier', 2);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idEtablishement` int(11) NOT NULL,
  `arrival` datetime NOT NULL,
  `day` date NOT NULL,
  `amount` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `idFurniture` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `idUser`, `idEtablishement`, `arrival`, `day`, `amount`, `duration`, `idFurniture`) VALUES
(1, 1, 1, '2020-05-14 12:15:00', '2020-05-14', 3, 3600, 1),
(2, 2, 1, '2020-05-14 12:00:00', '2020-05-14', 6, 7200, 2),
(3, 3, 1, '2020-05-11 19:00:00', '2020-05-11', 5, 3600, 15),
(4, 5, 1, '2020-05-12 11:45:00', '2020-05-12', 6, 7200, 7),
(5, 4, 1, '2020-05-20 13:00:00', '2020-05-20', 4, 3600, 1),
(6, 3, 1, '2020-05-14 12:45:00', '2020-05-14', 5, 7200, 2);

-- --------------------------------------------------------

--
-- Table structure for table `reservation_method`
--

CREATE TABLE `reservation_method` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation_method`
--

INSERT INTO `reservation_method` (`id`, `name`) VALUES
(1, 'Téléphone'),
(2, 'Mail'),
(3, 'Resa'),
(4, 'Sur place');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_mark`
--

CREATE TABLE `restaurant_mark` (
  `id` int(11) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idEtablishment` int(11) DEFAULT NULL,
  `mark` int(11) DEFAULT NULL,
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schudle`
--

CREATE TABLE `schudle` (
  `id` int(11) NOT NULL,
  `begin` time DEFAULT NULL,
  `end` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schudle`
--

INSERT INTO `schudle` (`id`, `begin`, `end`) VALUES
(1, '11:00:00', '15:00:00'),
(2, '11:15:00', '23:30:00'),
(3, '11:15:00', '19:00:00'),
(4, '17:00:00', '23:00:00'),
(5, '11:00:00', '12:00:00'),
(6, '12:15:00', '13:15:00'),
(8, '11:00:00', '23:30:00'),
(9, '12:00:00', '17:00:00'),
(10, '11:30:00', '23:30:00'),
(11, '09:00:00', '15:00:00'),
(12, '00:00:00', '23:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `schudle_created_for`
--

CREATE TABLE `schudle_created_for` (
  `idSchudle` int(11) NOT NULL,
  `idEtablishement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schudle_created_for`
--

INSERT INTO `schudle_created_for` (`idSchudle`, `idEtablishement`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(8, 1),
(9, 1),
(10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL COMMENT 'l''id de l''abonnement',
  `name` varchar(100) NOT NULL COMMENT 'le nom de l''abonnement "FULL" "PRO" etc.',
  `price` int(11) NOT NULL COMMENT 'le prix par mois de l''abonnement',
  `level` int(11) NOT NULL COMMENT 'le niveau d''autorisations'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `name`, `price`, `level`) VALUES
(1, 'BLOG', 0, 1),
(2, 'PRO', 9, 2),
(3, 'FULL', 29, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `phone`, `email`, `username`, `password`) VALUES
(1, 'Constantin', 'Herrmann', '079 882 89 25', 'constantin.hrrmn@eduge.ch', '2008', 'b3ab939cbaa34ecf36b7e07bdcefce4d2c913517bd345daecab7f91c69fbe269'),
(2, 'Marco', 'Polo', '079 123 45 67', 'marco.polo@pm.ch', '3383', '30963bb3ca13371a5b776434c2959c87b53113d7817a23a1f523c15863350ee7'),
(3, 'Olivier', 'Demartin', '079 635 46 84', 'o.demartin@gmail.com', '5243', '4c4b520592f51d5456edd751d3f8d771a5c0895d65de5f8c9537804cffc32ad0'),
(4, 'Mathilde', 'Gason', '076 536 64 75', 'Math.gas@gmail.com', '9902', '4c4b520592f51d5456edd751d3f8d771a5c0895d65de5f8c9537804cffc32ad0'),
(5, 'Dominique', 'Gauthier', '079 837 73 73', 'd.gauthier@beaurivage.ch', '0001', '71d999e5065e5f42f4f6b378e82b429b94043cd07fdc6a9b9fe2241890d72300');

-- --------------------------------------------------------

--
-- Table structure for table `user_has_image`
--

CREATE TABLE `user_has_image` (
  `idUser` int(11) NOT NULL,
  `idImage` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_has_image`
--

INSERT INTO `user_has_image` (`idUser`, `idImage`) VALUES
(1, '5ea9973bf332c'),
(2, '5ea9978172cc1');

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE `zone` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zone`
--

INSERT INTO `zone` (`id`, `name`) VALUES
(1, 'Vue mer'),
(2, 'Vue village'),
(3, 'Piste de danse'),
(4, 'Côté bar'),
(5, 'Côté fenêtre'),
(6, 'Balcon Royal'),
(7, 'salle'),
(8, 'Côté Lac'),
(9, 'Côté Cuisine'),
(11, 'Escaliers'),
(13, 'Petit coin'),
(16, 'prison'),
(17, 'Hangar'),
(18, 'Dortoir'),
(19, 'Mickey'),
(20, 'Vue port'),
(21, 'Poto'),
(22, 'Kernozet'),
(23, 'Droite'),
(24, 'Gauche'),
(25, 'Home cinéma'),
(26, 'Salut');

-- --------------------------------------------------------

--
-- Table structure for table `zone_has_schudle`
--

CREATE TABLE `zone_has_schudle` (
  `idZone` int(11) DEFAULT NULL,
  `idSchudle` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zone_has_schudle`
--

INSERT INTO `zone_has_schudle` (`idZone`, `idSchudle`) VALUES
(1, 1),
(2, 1),
(3, 3),
(4, 4),
(5, 2),
(6, 5),
(6, 6),
(7, 4),
(8, 8),
(9, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client_mark`
--
ALTER TABLE `client_mark`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idEtablishment` (`idEtablishment`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dish`
--
ALTER TABLE `dish`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dish_type` (`idType`);

--
-- Indexes for table `dish_has_image`
--
ALTER TABLE `dish_has_image`
  ADD KEY `dish 4` (`idDish`),
  ADD KEY `img 2` (`idImages`);

--
-- Indexes for table `dish_type`
--
ALTER TABLE `dish_type`
  ADD KEY `id` (`id`);

--
-- Indexes for table `establishment`
--
ALTER TABLE `establishment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu 1` (`id_menu`),
  ADD KEY `count` (`country`),
  ADD KEY `level` (`id_subscription`);

--
-- Indexes for table `etablishement_has_image`
--
ALTER TABLE `etablishement_has_image`
  ADD KEY `etab4` (`idEtablishement`),
  ADD KEY `img` (`idImages`);

--
-- Indexes for table `floor`
--
ALTER TABLE `floor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `erab 3` (`idEtablishment`);

--
-- Indexes for table `furniture`
--
ALTER TABLE `furniture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type1` (`idType`),
  ADD KEY `shape1` (`idShape`);

--
-- Indexes for table `furniture_has_schudle`
--
ALTER TABLE `furniture_has_schudle`
  ADD KEY `furni2` (`idFurniture`),
  ADD KEY `schudle 2` (`idSchudle`);

--
-- Indexes for table `furniture_shape`
--
ALTER TABLE `furniture_shape`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `furniture_type`
--
ALTER TABLE `furniture_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `habits`
--
ALTER TABLE `habits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `has_furniture`
--
ALTER TABLE `has_furniture`
  ADD UNIQUE KEY `idFurniture` (`idFurniture`),
  ADD KEY `Zone4` (`idZone`);

--
-- Indexes for table `has_habits`
--
ALTER TABLE `has_habits`
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `has_reservation`
--
ALTER TABLE `has_reservation`
  ADD KEY `idReservation` (`idReservation`),
  ADD KEY `zone 6` (`idZone`);

--
-- Indexes for table `has_zone`
--
ALTER TABLE `has_zone`
  ADD KEY `Zone 1` (`idZone`),
  ADD KEY `Floor 1` (`idFloor`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `is_in_as`
--
ALTER TABLE `is_in_as`
  ADD KEY `user 4` (`idUser`),
  ADD KEY `etab 3` (`idEtablishement`),
  ADD KEY `permission 1` (`idPermission`);

--
-- Indexes for table `meal`
--
ALTER TABLE `meal`
  ADD KEY `id` (`id`),
  ADD KEY `dish1` (`entrance`),
  ADD KEY `dish2` (`main`),
  ADD KEY `dish3` (`dessert`),
  ADD KEY `drink1` (`drink`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_has_dishes`
--
ALTER TABLE `menu_has_dishes`
  ADD KEY `menu1` (`idMenu`),
  ADD KEY `dish5` (`idDish`);

--
-- Indexes for table `menu_has_meal`
--
ALTER TABLE `menu_has_meal`
  ADD KEY `meal1` (`idMeal`),
  ADD KEY `menu2` (`idMenu`);

--
-- Indexes for table `opening`
--
ALTER TABLE `opening`
  ADD KEY `d` (`idDay`),
  ADD KEY `e` (`idEtablishement`),
  ADD KEY `s` (`idSchudle`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user 8` (`idUser`),
  ADD KEY `etablishement 3` (`idEtablishement`),
  ADD KEY `furfur` (`idFurniture`);

--
-- Indexes for table `reservation_method`
--
ALTER TABLE `reservation_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_mark`
--
ALTER TABLE `restaurant_mark`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idEtablishment` (`idEtablishment`);

--
-- Indexes for table `schudle`
--
ALTER TABLE `schudle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schudle_created_for`
--
ALTER TABLE `schudle_created_for`
  ADD KEY `schulde9` (`idSchudle`),
  ADD KEY `etablishm` (`idEtablishement`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_has_image`
--
ALTER TABLE `user_has_image`
  ADD KEY `user 7` (`idUser`),
  ADD KEY `img 6` (`idImage`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zone_has_schudle`
--
ALTER TABLE `zone_has_schudle`
  ADD KEY `zone1` (`idZone`),
  ADD KEY `schudle1` (`idSchudle`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client_mark`
--
ALTER TABLE `client_mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dish`
--
ALTER TABLE `dish`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dish_type`
--
ALTER TABLE `dish_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `establishment`
--
ALTER TABLE `establishment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `floor`
--
ALTER TABLE `floor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `furniture`
--
ALTER TABLE `furniture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `furniture_shape`
--
ALTER TABLE `furniture_shape`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `furniture_type`
--
ALTER TABLE `furniture_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `habits`
--
ALTER TABLE `habits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meal`
--
ALTER TABLE `meal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reservation_method`
--
ALTER TABLE `reservation_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `restaurant_mark`
--
ALTER TABLE `restaurant_mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schudle`
--
ALTER TABLE `schudle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id de l''abonnement', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `zone`
--
ALTER TABLE `zone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client_mark`
--
ALTER TABLE `client_mark`
  ADD CONSTRAINT `client_mark_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `client_mark_ibfk_2` FOREIGN KEY (`idEtablishment`) REFERENCES `establishment` (`id`);

--
-- Constraints for table `dish`
--
ALTER TABLE `dish`
  ADD CONSTRAINT `dish_type` FOREIGN KEY (`idType`) REFERENCES `dish_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dish_has_image`
--
ALTER TABLE `dish_has_image`
  ADD CONSTRAINT `dish 4` FOREIGN KEY (`idDish`) REFERENCES `dish` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `img 2` FOREIGN KEY (`idImages`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `establishment`
--
ALTER TABLE `establishment`
  ADD CONSTRAINT `count` FOREIGN KEY (`country`) REFERENCES `countries` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `level` FOREIGN KEY (`id_subscription`) REFERENCES `subscriptions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `menu 1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `etablishement_has_image`
--
ALTER TABLE `etablishement_has_image`
  ADD CONSTRAINT `etab4` FOREIGN KEY (`idEtablishement`) REFERENCES `establishment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `img` FOREIGN KEY (`idImages`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `floor`
--
ALTER TABLE `floor`
  ADD CONSTRAINT `erab 3` FOREIGN KEY (`idEtablishment`) REFERENCES `establishment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `furniture`
--
ALTER TABLE `furniture`
  ADD CONSTRAINT `shape1` FOREIGN KEY (`idShape`) REFERENCES `furniture_shape` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `type1` FOREIGN KEY (`idType`) REFERENCES `furniture_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `furniture_has_schudle`
--
ALTER TABLE `furniture_has_schudle`
  ADD CONSTRAINT `furni2` FOREIGN KEY (`idFurniture`) REFERENCES `furniture` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schudle 2` FOREIGN KEY (`idSchudle`) REFERENCES `schudle` (`id`);

--
-- Constraints for table `has_furniture`
--
ALTER TABLE `has_furniture`
  ADD CONSTRAINT `Furniture1` FOREIGN KEY (`idFurniture`) REFERENCES `furniture` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Zone4` FOREIGN KEY (`idZone`) REFERENCES `zone` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `has_habits`
--
ALTER TABLE `has_habits`
  ADD CONSTRAINT `has_habits_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`);

--
-- Constraints for table `has_reservation`
--
ALTER TABLE `has_reservation`
  ADD CONSTRAINT `has_reservation_ibfk_1` FOREIGN KEY (`idReservation`) REFERENCES `reservation` (`id`),
  ADD CONSTRAINT `zone 6` FOREIGN KEY (`idZone`) REFERENCES `zone` (`id`);

--
-- Constraints for table `has_zone`
--
ALTER TABLE `has_zone`
  ADD CONSTRAINT `Floor 1` FOREIGN KEY (`idFloor`) REFERENCES `floor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Zone 1` FOREIGN KEY (`idZone`) REFERENCES `zone` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `is_in_as`
--
ALTER TABLE `is_in_as`
  ADD CONSTRAINT `etab 3` FOREIGN KEY (`idEtablishement`) REFERENCES `establishment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission 1` FOREIGN KEY (`idPermission`) REFERENCES `permission` (`id`),
  ADD CONSTRAINT `user 4` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `meal`
--
ALTER TABLE `meal`
  ADD CONSTRAINT `dish1` FOREIGN KEY (`entrance`) REFERENCES `dish` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dish2` FOREIGN KEY (`main`) REFERENCES `dish` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dish3` FOREIGN KEY (`dessert`) REFERENCES `dish` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `drink1` FOREIGN KEY (`drink`) REFERENCES `dish` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `menu_has_dishes`
--
ALTER TABLE `menu_has_dishes`
  ADD CONSTRAINT `dish5` FOREIGN KEY (`idDish`) REFERENCES `dish` (`id`),
  ADD CONSTRAINT `menu1` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_has_meal`
--
ALTER TABLE `menu_has_meal`
  ADD CONSTRAINT `meal1` FOREIGN KEY (`idMeal`) REFERENCES `meal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu2` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `opening`
--
ALTER TABLE `opening`
  ADD CONSTRAINT `d` FOREIGN KEY (`idDay`) REFERENCES `days` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `e` FOREIGN KEY (`idEtablishement`) REFERENCES `establishment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `s` FOREIGN KEY (`idSchudle`) REFERENCES `schudle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `etablishement 3` FOREIGN KEY (`idEtablishement`) REFERENCES `establishment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `furfur` FOREIGN KEY (`idFurniture`) REFERENCES `furniture` (`id`),
  ADD CONSTRAINT `user 8` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurant_mark`
--
ALTER TABLE `restaurant_mark`
  ADD CONSTRAINT `restaurant_mark_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `restaurant_mark_ibfk_2` FOREIGN KEY (`idEtablishment`) REFERENCES `establishment` (`id`);

--
-- Constraints for table `schudle_created_for`
--
ALTER TABLE `schudle_created_for`
  ADD CONSTRAINT `etablishm` FOREIGN KEY (`idEtablishement`) REFERENCES `establishment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schulde9` FOREIGN KEY (`idSchudle`) REFERENCES `schudle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_has_image`
--
ALTER TABLE `user_has_image`
  ADD CONSTRAINT `img 6` FOREIGN KEY (`idImage`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user 7` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zone_has_schudle`
--
ALTER TABLE `zone_has_schudle`
  ADD CONSTRAINT `schudle1` FOREIGN KEY (`idSchudle`) REFERENCES `schudle` (`id`),
  ADD CONSTRAINT `zone1` FOREIGN KEY (`idZone`) REFERENCES `zone` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
