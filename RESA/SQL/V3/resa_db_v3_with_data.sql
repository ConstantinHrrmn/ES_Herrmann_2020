-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 14, 2020 at 09:13 AM
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
-- Database: `resa`
--
CREATE DATABASE IF NOT EXISTS `resa` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `resa`;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `first_name`, `last_name`, `phone`, `email`, `password`) VALUES
(1, 'Constantin', 'Herrmann', '0798828925', 'constantin@waview.ch', '9fd5bef47ecc6663f3e81d7c931a95fd52ca2a4a3374c5b65ecd392d6ed9f830');

-- --------------------------------------------------------

--
-- Table structure for table `client_mark`
--

CREATE TABLE `client_mark` (
  `id` int(11) NOT NULL,
  `idClient` int(11) DEFAULT NULL,
  `idEtablishment` int(11) DEFAULT NULL,
  `mark` int(11) DEFAULT NULL,
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dish`
--

CREATE TABLE `dish` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `drink` varchar(255) DEFAULT NULL,
  `entrance` varchar(255) DEFAULT NULL,
  `main` varchar(255) DEFAULT NULL,
  `dessert` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dish`
--

INSERT INTO `dish` (`id`, `name`, `drink`, `entrance`, `main`, `dessert`) VALUES
(1, 'Decouverte de la mer', '1 verre à vin OU 1 boisson', 'Saumon fumé sur toast', 'truite sur son nid de pommes de terres avec légumes de la saison', 'Mousse au chocolat maison'),
(2, 'le lac', '1 coupe de chamagne', 'salde', 'filet de pêche marinières avec frites', 'dessert au choix');

-- --------------------------------------------------------

--
-- Table structure for table `employe`
--

CREATE TABLE `employe` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` int(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `idPermission` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employe`
--

INSERT INTO `employe` (`id`, `first_name`, `last_name`, `phone`, `email`, `username`, `password`, `idPermission`) VALUES
(3, 'Constantin', 'Herrmann', '0798828925', 'constantin.hrrmn@eduge.ch', 2008, 'b3ab939cbaa34ecf36b7e07bdcefce4d2c913517bd345daecab7f91c69fbe269', 1),
(4, 'Marcus', 'Lemarin', '0791234567', 'marcus.lemarin@gmail.com', 3383, '30963bb3ca13371a5b776434c2959c87b53113d7817a23a1f523c15863350ee7', 2),
(5, 'Olivier', 'Mastigno', '0798837846', 'o.mastigno@gmail.com', 5243, '3710f1a472febbc82026d64452ee8f1b38e801149b1c72310dc8e576b1d3b972', 3),
(6, 'Mathilde', 'Tombey', '0227843943', 'm.tomtom@yahoo.fr', 9902, '4c4b520592f51d5456edd751d3f8d771a5c0895d65de5f8c9537804cffc32ad0', 3);

-- --------------------------------------------------------

--
-- Table structure for table `establishment`
--

CREATE TABLE `establishment` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `establishment`
--

INSERT INTO `establishment` (`id`, `name`, `address`, `phone`, `email`, `id_menu`) VALUES
(1, 'Port Martignot', 'Route du port 45', '0221344323', 'info@portmartgnot.ch', 1);

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
(1, 1, 'Terrasse'),
(2, 1, 'Salle principale');

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
  `idShape` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `furniture`
--

INSERT INTO `furniture` (`id`, `name`, `color`, `places`, `idType`, `idShape`) VALUES
(1, 'Table fav', 'Blanc', 4, 1, 1),
(2, 'Table Danse 1', 'Bleu', 2, 1, 2),
(3, 'Table Danse 2', 'Bleu', 2, 1, 2),
(4, 'Table Longue Droite', 'Jaune', 6, 1, 2),
(5, 'Table Dansante 1', 'Vert', 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `furniture_has_schudle`
--

CREATE TABLE `furniture_has_schudle` (
  `idFurniture` int(11) DEFAULT NULL,
  `idSchudle` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 'Rond'),
(2, 'Carré'),
(3, 'Ovale'),
(4, 'Triangulaire');

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
(1, 'Table normale'),
(2, 'Table debout'),
(3, 'Bar'),
(4, 'Table haute sans chaise');

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

-- --------------------------------------------------------

--
-- Table structure for table `has_habits`
--

CREATE TABLE `has_habits` (
  `idClient` int(11) DEFAULT NULL,
  `idHabit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `has_reservation`
--

CREATE TABLE `has_reservation` (
  `idZone` int(11) DEFAULT NULL,
  `idReservation` int(11) DEFAULT NULL,
  `idShudle` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 4),
(1, 5),
(2, 1),
(2, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `is_manager`
--

CREATE TABLE `is_manager` (
  `idEtablishment` int(11) DEFAULT NULL,
  `idEmployee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `is_manager`
--

INSERT INTO `is_manager` (`idEtablishment`, `idEmployee`) VALUES
(1, 4);

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
(1, 'L\'eau', 'Ce menu à por but de vous faire découvrir des repas marins');

-- --------------------------------------------------------

--
-- Table structure for table `menu_dishes`
--

CREATE TABLE `menu_dishes` (
  `idMenu` int(11) DEFAULT NULL,
  `idDish` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_dishes`
--

INSERT INTO `menu_dishes` (`idMenu`, `idDish`) VALUES
(1, 1),
(1, 2);

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
(1, 'Administrator', 1),
(2, 'Manager', 2),
(3, 'waiter', 3),
(4, 'Client', 4);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `idClient` int(11) DEFAULT NULL,
  `idSchudle` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_mark`
--

CREATE TABLE `restaurant_mark` (
  `id` int(11) NOT NULL,
  `idClient` int(11) DEFAULT NULL,
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
(1, '11:15:00', '19:30:00'),
(2, '11:15:00', '23:30:00'),
(3, '11:00:00', '15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `work_for`
--

CREATE TABLE `work_for` (
  `idEtablishment` int(11) DEFAULT NULL,
  `idEmployee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `work_for`
--

INSERT INTO `work_for` (`idEtablishment`, `idEmployee`) VALUES
(1, 5),
(1, 6);

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
(1, 'Piste de danse'),
(2, 'Cote bar'),
(3, 'Cote fenetre'),
(4, 'vue mer'),
(5, 'vue village');

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
(2, 2),
(3, 2),
(4, 3),
(5, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_mark`
--
ALTER TABLE `client_mark`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cmark1` (`idClient`),
  ADD KEY `emark1` (`idEtablishment`);

--
-- Indexes for table `dish`
--
ALTER TABLE `dish`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `perm` (`idPermission`);

--
-- Indexes for table `establishment`
--
ALTER TABLE `establishment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu` (`id_menu`);

--
-- Indexes for table `floor`
--
ALTER TABLE `floor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEtablishment` (`idEtablishment`);

--
-- Indexes for table `furniture`
--
ALTER TABLE `furniture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `furniture_ibfk_1` (`idType`),
  ADD KEY `furniture_ibfk_2` (`idShape`);

--
-- Indexes for table `furniture_has_schudle`
--
ALTER TABLE `furniture_has_schudle`
  ADD KEY `fur` (`idFurniture`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEtablishment` (`idEtablishment`);

--
-- Indexes for table `has_furniture`
--
ALTER TABLE `has_furniture`
  ADD KEY `idZone` (`idZone`),
  ADD KEY `idFurniture` (`idFurniture`);

--
-- Indexes for table `has_habits`
--
ALTER TABLE `has_habits`
  ADD KEY `idClient` (`idClient`),
  ADD KEY `idHabit` (`idHabit`);

--
-- Indexes for table `has_reservation`
--
ALTER TABLE `has_reservation`
  ADD KEY `idZone` (`idZone`),
  ADD KEY `idShudle` (`idShudle`);

--
-- Indexes for table `has_zone`
--
ALTER TABLE `has_zone`
  ADD KEY `flo` (`idFloor`),
  ADD KEY `zo` (`idZone`);

--
-- Indexes for table `is_manager`
--
ALTER TABLE `is_manager`
  ADD KEY `manager` (`idEmployee`),
  ADD KEY `resto1` (`idEtablishment`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_dishes`
--
ALTER TABLE `menu_dishes`
  ADD KEY `menu1` (`idMenu`),
  ADD KEY `repas1` (`idDish`);

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
  ADD KEY `idClient` (`idClient`);

--
-- Indexes for table `restaurant_mark`
--
ALTER TABLE `restaurant_mark`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idClient` (`idClient`),
  ADD KEY `idEtablishment` (`idEtablishment`);

--
-- Indexes for table `schudle`
--
ALTER TABLE `schudle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_for`
--
ALTER TABLE `work_for`
  ADD KEY `employer` (`idEmployee`),
  ADD KEY `resto` (`idEtablishment`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zone_has_schudle`
--
ALTER TABLE `zone_has_schudle`
  ADD KEY `zone_has_schudle_ibfk_1` (`idZone`),
  ADD KEY `zone_has_schudle_ibfk_2` (`idSchudle`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `client_mark`
--
ALTER TABLE `client_mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dish`
--
ALTER TABLE `dish`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employe`
--
ALTER TABLE `employe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `establishment`
--
ALTER TABLE `establishment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `floor`
--
ALTER TABLE `floor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `furniture`
--
ALTER TABLE `furniture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurant_mark`
--
ALTER TABLE `restaurant_mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schudle`
--
ALTER TABLE `schudle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `zone`
--
ALTER TABLE `zone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client_mark`
--
ALTER TABLE `client_mark`
  ADD CONSTRAINT `cmark1` FOREIGN KEY (`idClient`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `emark1` FOREIGN KEY (`idEtablishment`) REFERENCES `establishment` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `perm` FOREIGN KEY (`idPermission`) REFERENCES `permission` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `establishment`
--
ALTER TABLE `establishment`
  ADD CONSTRAINT `menu` FOREIGN KEY (`id_menu`) REFERENCES `dish` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `floor`
--
ALTER TABLE `floor`
  ADD CONSTRAINT `floor_ibfk_1` FOREIGN KEY (`idEtablishment`) REFERENCES `establishment` (`id`);

--
-- Constraints for table `furniture`
--
ALTER TABLE `furniture`
  ADD CONSTRAINT `furniture_ibfk_1` FOREIGN KEY (`idType`) REFERENCES `furniture_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `furniture_ibfk_2` FOREIGN KEY (`idShape`) REFERENCES `furniture_shape` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `furniture_has_schudle`
--
ALTER TABLE `furniture_has_schudle`
  ADD CONSTRAINT `fur` FOREIGN KEY (`idFurniture`) REFERENCES `furniture` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `habits`
--
ALTER TABLE `habits`
  ADD CONSTRAINT `habits_ibfk_1` FOREIGN KEY (`idEtablishment`) REFERENCES `establishment` (`id`);

--
-- Constraints for table `has_furniture`
--
ALTER TABLE `has_furniture`
  ADD CONSTRAINT `has_furniture_ibfk_1` FOREIGN KEY (`idZone`) REFERENCES `zone` (`id`),
  ADD CONSTRAINT `has_furniture_ibfk_2` FOREIGN KEY (`idFurniture`) REFERENCES `furniture` (`id`);

--
-- Constraints for table `has_habits`
--
ALTER TABLE `has_habits`
  ADD CONSTRAINT `has_habits_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `has_habits_ibfk_2` FOREIGN KEY (`idHabit`) REFERENCES `habits` (`id`);

--
-- Constraints for table `has_reservation`
--
ALTER TABLE `has_reservation`
  ADD CONSTRAINT `has_reservation_ibfk_1` FOREIGN KEY (`idZone`) REFERENCES `zone` (`id`),
  ADD CONSTRAINT `has_reservation_ibfk_2` FOREIGN KEY (`idShudle`) REFERENCES `schudle` (`id`);

--
-- Constraints for table `has_zone`
--
ALTER TABLE `has_zone`
  ADD CONSTRAINT `flo` FOREIGN KEY (`idFloor`) REFERENCES `floor` (`id`),
  ADD CONSTRAINT `zo` FOREIGN KEY (`idZone`) REFERENCES `zone` (`id`);

--
-- Constraints for table `is_manager`
--
ALTER TABLE `is_manager`
  ADD CONSTRAINT `manager` FOREIGN KEY (`idEmployee`) REFERENCES `employe` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `resto1` FOREIGN KEY (`idEtablishment`) REFERENCES `establishment` (`id`);

--
-- Constraints for table `menu_dishes`
--
ALTER TABLE `menu_dishes`
  ADD CONSTRAINT `menu1` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `repas1` FOREIGN KEY (`idDish`) REFERENCES `dish` (`id`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`id`);

--
-- Constraints for table `restaurant_mark`
--
ALTER TABLE `restaurant_mark`
  ADD CONSTRAINT `restaurant_mark_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `restaurant_mark_ibfk_2` FOREIGN KEY (`idEtablishment`) REFERENCES `establishment` (`id`);

--
-- Constraints for table `work_for`
--
ALTER TABLE `work_for`
  ADD CONSTRAINT `employer` FOREIGN KEY (`idEmployee`) REFERENCES `employe` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `resto` FOREIGN KEY (`idEtablishment`) REFERENCES `establishment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zone_has_schudle`
--
ALTER TABLE `zone_has_schudle`
  ADD CONSTRAINT `zone_has_schudle_ibfk_1` FOREIGN KEY (`idZone`) REFERENCES `zone` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zone_has_schudle_ibfk_2` FOREIGN KEY (`idSchudle`) REFERENCES `schudle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
