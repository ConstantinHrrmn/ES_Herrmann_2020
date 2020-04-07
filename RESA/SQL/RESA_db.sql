CREATE TABLE `Establishment` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `address` varchar(255),
  `phone` varchar(255),
  `id_manager` int,
  `email` varchar(255),
  `id_menu` int
);

CREATE TABLE `Employe` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `first_name` varchar(255),
  `last_name` varchar(255),
  `phone` varchar(255),
  `email` varchar(255),
  `idPermission` int
);

CREATE TABLE `Permission` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `level` int
);

CREATE TABLE `Menu` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `description` text
);

CREATE TABLE `Dish` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `drink` varchar(255),
  `entrance` varchar(255),
  `main` varchar(255),
  `dessert` varchar(255)
);

CREATE TABLE `Furniture` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `color` varchar(255),
  `places` int,
  `idType` int,
  `idShape` int
);

CREATE TABLE `Furniture_Type` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `type` varchar(255)
);

CREATE TABLE `Furniture_Shape` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `shape` varchar(255)
);

CREATE TABLE `Zone` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255)
);

CREATE TABLE `Floor` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `idEtablishment` int,
  `name` varchar(255)
);

CREATE TABLE `Schudle` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `begin` timestamp,
  `end` timestamp
);

CREATE TABLE `Reservation` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `idClient` int,
  `idSchudle` int
);

CREATE TABLE `Client` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `first_name` varchar(255),
  `last_name` varchar(255),
  `phone` varchar(255),
  `email` varchar(255)
);

CREATE TABLE `Habits` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `idEtablishment` int,
  `comments` text
);

CREATE TABLE `has_habits` (
  `idClient` int,
  `idHabit` int
);

CREATE TABLE `has_reservation` (
  `idZone` int,
  `idReservation` int,
  `idShudle` int
);

CREATE TABLE `zone_has_schudle` (
  `idZone` int,
  `idSchudle` int
);

CREATE TABLE `Furniture_has_schudle` (
  `idFurniture` int,
  `idSchudle` int
);

CREATE TABLE `work_for` (
  `idEtablishment` int,
  `idEmployee` int
);

CREATE TABLE `has_zone` (
  `idFloor` int,
  `idZone` int
);

CREATE TABLE `has_furniture` (
  `idZone` int,
  `idFurniture` int
);

CREATE TABLE `menu_dishes` (
  `idMenu` int,
  `idDish` int
);

ALTER TABLE `work_for` ADD FOREIGN KEY (`idEtablishment`) REFERENCES `Establishment` (`id`);

ALTER TABLE `Employe` ADD FOREIGN KEY (`id`) REFERENCES `work_for` (`idEmployee`);

ALTER TABLE `Employe` ADD FOREIGN KEY (`idPermission`) REFERENCES `Permission` (`id`);

ALTER TABLE `Menu` ADD FOREIGN KEY (`id`) REFERENCES `Establishment` (`id_menu`);

ALTER TABLE `Floor` ADD FOREIGN KEY (`idEtablishment`) REFERENCES `Establishment` (`id`);

ALTER TABLE `has_zone` ADD FOREIGN KEY (`idFloor`) REFERENCES `Floor` (`id`);

ALTER TABLE `Zone` ADD FOREIGN KEY (`id`) REFERENCES `has_zone` (`idZone`);

ALTER TABLE `has_furniture` ADD FOREIGN KEY (`idZone`) REFERENCES `Zone` (`id`);

ALTER TABLE `has_furniture` ADD FOREIGN KEY (`idFurniture`) REFERENCES `Furniture` (`id`);

ALTER TABLE `Furniture` ADD FOREIGN KEY (`idType`) REFERENCES `Furniture_Type` (`id`);

ALTER TABLE `Furniture` ADD FOREIGN KEY (`idShape`) REFERENCES `Furniture_Shape` (`id`);

ALTER TABLE `has_reservation` ADD FOREIGN KEY (`idZone`) REFERENCES `Zone` (`id`);

ALTER TABLE `zone_has_schudle` ADD FOREIGN KEY (`idZone`) REFERENCES `Zone` (`id`);

ALTER TABLE `zone_has_schudle` ADD FOREIGN KEY (`idSchudle`) REFERENCES `Schudle` (`id`);

ALTER TABLE `Furniture_has_schudle` ADD FOREIGN KEY (`idFurniture`) REFERENCES `Furniture` (`id`);

ALTER TABLE `Schudle` ADD FOREIGN KEY (`id`) REFERENCES `Furniture_has_schudle` (`idSchudle`);

ALTER TABLE `Reservation` ADD FOREIGN KEY (`id`) REFERENCES `has_reservation` (`idReservation`);

ALTER TABLE `Reservation` ADD FOREIGN KEY (`idClient`) REFERENCES `Client` (`id`);

ALTER TABLE `has_reservation` ADD FOREIGN KEY (`idShudle`) REFERENCES `Schudle` (`id`);

ALTER TABLE `Establishment` ADD FOREIGN KEY (`id_manager`) REFERENCES `Employe` (`id`);

ALTER TABLE `Habits` ADD FOREIGN KEY (`idEtablishment`) REFERENCES `Establishment` (`id`);

ALTER TABLE `has_habits` ADD FOREIGN KEY (`idClient`) REFERENCES `Client` (`id`);

ALTER TABLE `has_habits` ADD FOREIGN KEY (`idHabit`) REFERENCES `Habits` (`id`);

ALTER TABLE `menu_dishes` ADD FOREIGN KEY (`idMenu`) REFERENCES `Menu` (`id`);

ALTER TABLE `Dish` ADD FOREIGN KEY (`id`) REFERENCES `menu_dishes` (`idDish`);
