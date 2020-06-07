-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 06, 2020 at 04:37 PM
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
CREATE DATABASE IF NOT EXISTS `resa_v2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `resa_v2`;

-- --------------------------------------------------------

--
-- Table structure for table `client_mark`
--

DROP TABLE IF EXISTS `client_mark`;
CREATE TABLE `client_mark` (
  `id` int(11) NOT NULL COMMENT 'l''id de la note',
  `idUser` int(11) DEFAULT NULL COMMENT 'l''id de l''utilisateur',
  `idEtablishment` int(11) DEFAULT NULL COMMENT 'l''id du restaurant ',
  `mark` int(11) DEFAULT NULL COMMENT 'la note donnée',
  `comment` text COMMENT 'le commentaire de la note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `Id` int(11) NOT NULL COMMENT 'l''id du pays',
  `ISO` varchar(2) NOT NULL COMMENT 'le code iso sur 2 caractères',
  `Name` varchar(100) NOT NULL COMMENT 'le nom du pays',
  `Iso3` varchar(3) DEFAULT NULL COMMENT 'le code iso3 sur 3 caractères',
  `NumCode` int(11) DEFAULT NULL COMMENT 'le numéro code du pays',
  `PhoneCode` int(11) DEFAULT NULL COMMENT 'le code de téléphone du pays'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

DROP TABLE IF EXISTS `days`;
CREATE TABLE `days` (
  `id` int(11) NOT NULL COMMENT 'l''id du jour',
  `name` varchar(25) NOT NULL COMMENT 'le nom du jour'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dish`
--

DROP TABLE IF EXISTS `dish`;
CREATE TABLE `dish` (
  `id` int(11) NOT NULL COMMENT 'l''id du repas',
  `name` varchar(250) NOT NULL COMMENT 'le nom du repas',
  `idType` int(11) DEFAULT NULL COMMENT 'l''id du type de repas',
  `price` double NOT NULL DEFAULT '0' COMMENT 'le prix du repas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dish_has_image`
--

DROP TABLE IF EXISTS `dish_has_image`;
CREATE TABLE `dish_has_image` (
  `idDish` int(11) DEFAULT NULL COMMENT 'l''id du plat',
  `idImages` varchar(200) DEFAULT NULL COMMENT 'l''id de l''image'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dish_type`
--

DROP TABLE IF EXISTS `dish_type`;
CREATE TABLE `dish_type` (
  `id` int(11) NOT NULL COMMENT 'l''id du type de plat',
  `name` varchar(250) NOT NULL COMMENT 'le nom du type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `establishment`
--

DROP TABLE IF EXISTS `establishment`;
CREATE TABLE `establishment` (
  `id` int(11) NOT NULL COMMENT 'l''id de l''établissement',
  `name` varchar(255) DEFAULT NULL COMMENT 'le nom de l''établissement',
  `phone` varchar(255) DEFAULT NULL COMMENT 'le numéro de téléphone',
  `email` varchar(255) DEFAULT NULL COMMENT 'l''email de contact',
  `id_menu` int(11) DEFAULT NULL COMMENT 'l''id du menu du restaurnat',
  `id_subscription` int(1) NOT NULL DEFAULT '1' COMMENT 'l''id de l''abonnement',
  `street` varchar(200) NOT NULL COMMENT 'la rue de l''adresse',
  `npa` int(10) NOT NULL COMMENT 'le code npa de l''adresse',
  `city` varchar(50) NOT NULL COMMENT 'la vile de l''adresse',
  `country` int(11) NOT NULL COMMENT 'l''id du pays de l''adresse'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `etablishement_has_image`
--

DROP TABLE IF EXISTS `etablishement_has_image`;
CREATE TABLE `etablishement_has_image` (
  `idEtablishement` int(11) DEFAULT NULL COMMENT 'l''id de l''établissement',
  `idImages` varchar(200) DEFAULT NULL COMMENT 'l''id de l''image'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `floor`
--

DROP TABLE IF EXISTS `floor`;
CREATE TABLE `floor` (
  `id` int(11) NOT NULL COMMENT 'id de l''étage',
  `idEtablishment` int(11) DEFAULT NULL COMMENT 'l''id de l''établissement',
  `name` varchar(255) DEFAULT NULL COMMENT 'le nom de l''étage'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `furniture`
--

DROP TABLE IF EXISTS `furniture`;
CREATE TABLE `furniture` (
  `id` int(11) NOT NULL COMMENT 'l''id de la fourniture',
  `name` varchar(255) DEFAULT NULL COMMENT 'le nom de la fourniture',
  `color` varchar(255) DEFAULT NULL COMMENT 'la couleur de la fourniture',
  `places` int(11) DEFAULT NULL COMMENT 'le nombre de places disponibles',
  `idType` int(11) DEFAULT NULL COMMENT 'l''id du type',
  `idShape` int(11) DEFAULT NULL COMMENT 'l''id de la forme',
  `idEtablishement` int(11) NOT NULL COMMENT 'l''id de l''établissement'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `furniture_has_schudle`
--

DROP TABLE IF EXISTS `furniture_has_schudle`;
CREATE TABLE `furniture_has_schudle` (
  `idFurniture` int(11) DEFAULT NULL COMMENT 'l''id de la fourniture',
  `idSchudle` int(11) DEFAULT NULL COMMENT 'l''id de l''horaire'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `furniture_shape`
--

DROP TABLE IF EXISTS `furniture_shape`;
CREATE TABLE `furniture_shape` (
  `id` int(11) NOT NULL COMMENT 'l''id de la forme de la fourniture',
  `shape` varchar(255) DEFAULT NULL COMMENT 'le nom de la forme'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `furniture_type`
--

DROP TABLE IF EXISTS `furniture_type`;
CREATE TABLE `furniture_type` (
  `id` int(11) NOT NULL COMMENT 'l''id du type de fourniture',
  `type` varchar(255) DEFAULT NULL COMMENT 'le nom du type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `habits`
--

DROP TABLE IF EXISTS `habits`;
CREATE TABLE `habits` (
  `id` int(11) NOT NULL COMMENT 'l''id de l''habitude',
  `idEtablishment` int(11) DEFAULT NULL COMMENT 'l''id de l''établissement',
  `comments` text COMMENT 'le commentaire de l''habitude'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `has_furniture`
--

DROP TABLE IF EXISTS `has_furniture`;
CREATE TABLE `has_furniture` (
  `idZone` int(11) DEFAULT NULL COMMENT 'l''id de la zone',
  `idFurniture` int(11) DEFAULT NULL COMMENT 'l''id de la fourniture'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `has_habits`
--

DROP TABLE IF EXISTS `has_habits`;
CREATE TABLE `has_habits` (
  `idUser` int(11) DEFAULT NULL COMMENT 'l''id de l''utilisateur',
  `idHabit` int(11) DEFAULT NULL COMMENT 'l''id de l''habitude'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `has_reservation`
--

DROP TABLE IF EXISTS `has_reservation`;
CREATE TABLE `has_reservation` (
  `idZone` int(11) DEFAULT NULL COMMENT 'l''id de la zone',
  `idReservation` int(11) DEFAULT NULL COMMENT 'l''id de la réservation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `has_zone`
--

DROP TABLE IF EXISTS `has_zone`;
CREATE TABLE `has_zone` (
  `idFloor` int(11) DEFAULT NULL COMMENT 'l''id de l''étage',
  `idZone` int(11) DEFAULT NULL COMMENT 'l''id de la zone'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` varchar(200) NOT NULL COMMENT 'l''id de l''image (généré par le code)',
  `alt` varchar(255) DEFAULT NULL COMMENT 'l''alt de l''image ',
  `path` text COMMENT 'le chemin de l''image dans l''API',
  `postedby` int(11) DEFAULT NULL COMMENT 'l''id de l''utilisateur qui à posté l''image'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `is_in_as`
--

DROP TABLE IF EXISTS `is_in_as`;
CREATE TABLE `is_in_as` (
  `idUser` int(11) DEFAULT NULL COMMENT 'l''id de l''utilisateur',
  `idEtablishement` int(11) DEFAULT NULL COMMENT 'l''id de l''établissement',
  `idPermission` int(11) DEFAULT NULL COMMENT 'l''id de la permission de l''utilisateur dans l''établissement'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `meal`
--

DROP TABLE IF EXISTS `meal`;
CREATE TABLE `meal` (
  `id` int(11) NOT NULL COMMENT 'l''id du menu composé',
  `name` varchar(250) NOT NULL COMMENT 'le nom du menu composé',
  `entrance` int(11) DEFAULT NULL COMMENT 'l''id de son plat d''entrée',
  `main` int(11) DEFAULT NULL COMMENT 'l''id du plat principal',
  `dessert` int(11) DEFAULT NULL COMMENT 'l''id du dessert',
  `drink` int(11) DEFAULT NULL COMMENT 'l''id de la boisson',
  `price` double NOT NULL DEFAULT '0' COMMENT 'le prix du menu composé'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL COMMENT 'l''id de la carte',
  `name` varchar(255) DEFAULT NULL COMMENT 'le nom de la carte',
  `description` text COMMENT 'la description de la carte'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_has_dishes`
--

DROP TABLE IF EXISTS `menu_has_dishes`;
CREATE TABLE `menu_has_dishes` (
  `idMenu` int(11) DEFAULT NULL COMMENT 'l''id de la carte',
  `idDish` int(11) DEFAULT NULL COMMENT 'l''id du plat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu_has_meal`
--

DROP TABLE IF EXISTS `menu_has_meal`;
CREATE TABLE `menu_has_meal` (
  `idMenu` int(11) NOT NULL COMMENT 'l''id de la carte',
  `idMeal` int(11) NOT NULL COMMENT 'l''id du menu composé'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `method_used`
--

DROP TABLE IF EXISTS `method_used`;
CREATE TABLE `method_used` (
  `idReservation` int(11) DEFAULT NULL COMMENT 'l''id de la réservation',
  `idMethod` int(11) DEFAULT NULL COMMENT 'l''id de la méthode utilisée pour réserver'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `opening`
--

DROP TABLE IF EXISTS `opening`;
CREATE TABLE `opening` (
  `idEtablishement` int(11) NOT NULL COMMENT 'id de l''établissement',
  `idSchudle` int(11) NOT NULL COMMENT 'l''id de l''horaire',
  `idDay` int(11) NOT NULL COMMENT 'l''id du jour de la semaine'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `id` int(11) NOT NULL COMMENT 'l''id de la permission',
  `name` varchar(255) DEFAULT NULL COMMENT 'le nom de la permission',
  `level` int(11) DEFAULT NULL COMMENT 'le niveau de la permission'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  `id` int(11) NOT NULL COMMENT 'l''id de la réservation',
  `idUser` int(11) NOT NULL COMMENT 'l''id de l''utilisateur qui à fait la réservation',
  `idEtablishement` int(11) NOT NULL COMMENT 'l''id de l''établissement',
  `arrival` datetime NOT NULL COMMENT 'l''heure d''arrivée',
  `day` date NOT NULL COMMENT 'la date de la réservation',
  `amount` int(11) NOT NULL COMMENT 'le nombre de personnes',
  `duration` int(11) NOT NULL COMMENT 'la durée estimée de la réservation',
  `idFurniture` int(11) NOT NULL COMMENT 'l''id de la fourniture'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_method`
--

DROP TABLE IF EXISTS `reservation_method`;
CREATE TABLE `reservation_method` (
  `id` int(11) NOT NULL COMMENT 'l''id de la méthode',
  `name` varchar(255) DEFAULT NULL COMMENT 'le nom de la méthode'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_mark`
--

DROP TABLE IF EXISTS `restaurant_mark`;
CREATE TABLE `restaurant_mark` (
  `id` int(11) NOT NULL COMMENT 'l''id de la note restaurant',
  `idUser` int(11) DEFAULT NULL COMMENT 'l''id de l''utilisateur',
  `idEtablishment` int(11) DEFAULT NULL COMMENT 'l''id du restaurant noté',
  `mark` int(11) DEFAULT NULL COMMENT 'la note donnée',
  `comment` text COMMENT 'le commentaire de la note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schudle`
--

DROP TABLE IF EXISTS `schudle`;
CREATE TABLE `schudle` (
  `id` int(11) NOT NULL COMMENT 'l''id de l''horaire',
  `begin` time DEFAULT NULL COMMENT 'l''heure de début',
  `end` time DEFAULT NULL COMMENT 'l''heure de fin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schudle_created_for`
--

DROP TABLE IF EXISTS `schudle_created_for`;
CREATE TABLE `schudle_created_for` (
  `idSchudle` int(11) NOT NULL COMMENT 'l''id de l''horaire',
  `idEtablishement` int(11) NOT NULL COMMENT 'l''id de l''établissement'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL COMMENT 'l''id de l''abonnement',
  `name` varchar(100) NOT NULL COMMENT 'le nom de l''abonnement "FULL" "PRO" etc.',
  `price` int(11) NOT NULL COMMENT 'le prix par mois de l''abonnement',
  `level` int(11) NOT NULL COMMENT 'le niveau d''autorisations'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL COMMENT 'l''id de l''utilisateur',
  `first_name` varchar(255) DEFAULT NULL COMMENT 'son prénom',
  `last_name` varchar(255) DEFAULT NULL COMMENT 'son nom',
  `phone` varchar(255) DEFAULT NULL COMMENT 'son numéro de téléphone',
  `email` varchar(255) DEFAULT NULL COMMENT 'son email',
  `username` varchar(255) DEFAULT NULL COMMENT 'son nom d''utilisateur (pour les employés)',
  `password` varchar(255) DEFAULT NULL COMMENT 'son mot de passe hashé'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_has_image`
--

DROP TABLE IF EXISTS `user_has_image`;
CREATE TABLE `user_has_image` (
  `idUser` int(11) NOT NULL COMMENT 'l''id de l''utilisateur',
  `idImage` varchar(200) NOT NULL COMMENT 'l''id de l''image'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

DROP TABLE IF EXISTS `zone`;
CREATE TABLE `zone` (
  `id` int(11) NOT NULL COMMENT 'l''id de la zone',
  `name` varchar(255) DEFAULT NULL COMMENT 'le nom de la zone'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `zone_has_schudle`
--

DROP TABLE IF EXISTS `zone_has_schudle`;
CREATE TABLE `zone_has_schudle` (
  `idZone` int(11) DEFAULT NULL COMMENT 'l''id de la zone',
  `idSchudle` int(11) DEFAULT NULL COMMENT 'l''id de l''horaire'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id de la note';

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id du pays';

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id du jour';

--
-- AUTO_INCREMENT for table `dish`
--
ALTER TABLE `dish`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id du repas';

--
-- AUTO_INCREMENT for table `dish_type`
--
ALTER TABLE `dish_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id du type de plat';

--
-- AUTO_INCREMENT for table `establishment`
--
ALTER TABLE `establishment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id de l''établissement';

--
-- AUTO_INCREMENT for table `floor`
--
ALTER TABLE `floor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de l''étage';

--
-- AUTO_INCREMENT for table `furniture`
--
ALTER TABLE `furniture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id de la fourniture';

--
-- AUTO_INCREMENT for table `furniture_shape`
--
ALTER TABLE `furniture_shape`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id de la forme de la fourniture';

--
-- AUTO_INCREMENT for table `furniture_type`
--
ALTER TABLE `furniture_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id du type de fourniture';

--
-- AUTO_INCREMENT for table `habits`
--
ALTER TABLE `habits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id de l''habitude';

--
-- AUTO_INCREMENT for table `meal`
--
ALTER TABLE `meal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id du menu composé';

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id de la carte';

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id de la permission';

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id de la réservation';

--
-- AUTO_INCREMENT for table `reservation_method`
--
ALTER TABLE `reservation_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id de la méthode';

--
-- AUTO_INCREMENT for table `restaurant_mark`
--
ALTER TABLE `restaurant_mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id de la note restaurant';

--
-- AUTO_INCREMENT for table `schudle`
--
ALTER TABLE `schudle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id de l''horaire';

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id de l''abonnement';

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id de l''utilisateur';

--
-- AUTO_INCREMENT for table `zone`
--
ALTER TABLE `zone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'l''id de la zone';

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
