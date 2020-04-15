CREATE TABLE `Establishment` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `address` varchar(255),
  `phone` varchar(255),
  `email` varchar(255),
  `id_menu` int
);

CREATE TABLE `User` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `first_name` varchar(255),
  `last_name` varchar(255),
  `phone` varchar(255),
  `email` varchar(255),
  `username` varchar(255),
  `password` varchar(255),
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
  `dessert` varchar(255),
  `price` int
);

CREATE TABLE `Furniture` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `color` varchar(255),
  `places` int,
  `idType` int,
  `idShape` int
);

CREATE TABLE `Restaurant_mark` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `idUser` int,
  `idEtablishment` int,
  `mark` int,
  `comment` text
);

CREATE TABLE `Client_mark` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `idUser` int,
  `idEtablishment` int,
  `mark` int,
  `comment` text
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
  `idUser` int,
  `idSchudle` int
);

CREATE TABLE `Habits` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `idEtablishment` int,
  `comments` text
);

CREATE TABLE `has_habits` (
  `idUser` int,
  `idHabit` int
);

CREATE TABLE `has_reservation` (
  `idZone` int,
  `idReservation` int
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
  `idUser` int
);

CREATE TABLE `is_manager` (
  `idEtablishment` int,
  `idUser` int
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

CREATE TABLE `Images` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `alt` varchar(255),
  `image` blob,
  `postedby` int
);

CREATE TABLE `dish_has_image` (
  `idDish` int,
  `idImages` int
);

CREATE TABLE `etablishement_has_image` (
  `idEtablishement` int,
  `idImages` int
);

CREATE TABLE `method_used` (
  `idReservation` int,
  `idMethod` int
);

CREATE TABLE `Reservation_Method` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255)
);

ALTER TABLE `User` ADD FOREIGN KEY (`idPermission`) REFERENCES `Permission` (`id`);

ALTER TABLE `Client_mark` ADD FOREIGN KEY (`idUser`) REFERENCES `User` (`id`);

ALTER TABLE `Restaurant_mark` ADD FOREIGN KEY (`idUser`) REFERENCES `User` (`id`);

ALTER TABLE `work_for` ADD FOREIGN KEY (`idUser`) REFERENCES `User` (`id`);

ALTER TABLE `is_manager` ADD FOREIGN KEY (`idUser`) REFERENCES `User` (`id`);

ALTER TABLE `has_habits` ADD FOREIGN KEY (`idUser`) REFERENCES `User` (`id`);

ALTER TABLE `Habits` ADD FOREIGN KEY (`id`) REFERENCES `has_habits` (`idHabit`);

ALTER TABLE `Reservation` ADD FOREIGN KEY (`idUser`) REFERENCES `User` (`id`);

ALTER TABLE `Restaurant_mark` ADD FOREIGN KEY (`idEtablishment`) REFERENCES `Establishment` (`id`);

ALTER TABLE `Client_mark` ADD FOREIGN KEY (`idEtablishment`) REFERENCES `Establishment` (`id`);

ALTER TABLE `Menu` ADD FOREIGN KEY (`id`) REFERENCES `Establishment` (`id_menu`);

ALTER TABLE `menu_dishes` ADD FOREIGN KEY (`idMenu`) REFERENCES `Menu` (`id`);

ALTER TABLE `Dish` ADD FOREIGN KEY (`id`) REFERENCES `menu_dishes` (`idDish`);

ALTER TABLE `has_reservation` ADD FOREIGN KEY (`idReservation`) REFERENCES `Reservation` (`id`);

ALTER TABLE `Schudle` ADD FOREIGN KEY (`id`) REFERENCES `Reservation` (`idSchudle`);

ALTER TABLE `Zone` ADD FOREIGN KEY (`id`) REFERENCES `has_reservation` (`idZone`);

ALTER TABLE `has_zone` ADD FOREIGN KEY (`idZone`) REFERENCES `Zone` (`id`);

ALTER TABLE `Floor` ADD FOREIGN KEY (`id`) REFERENCES `has_zone` (`idFloor`);

ALTER TABLE `Establishment` ADD FOREIGN KEY (`id`) REFERENCES `Floor` (`idEtablishment`);

ALTER TABLE `Schudle` ADD FOREIGN KEY (`id`) REFERENCES `Furniture_has_schudle` (`idSchudle`);

ALTER TABLE `Schudle` ADD FOREIGN KEY (`id`) REFERENCES `zone_has_schudle` (`idSchudle`);

ALTER TABLE `zone_has_schudle` ADD FOREIGN KEY (`idZone`) REFERENCES `Zone` (`id`);

ALTER TABLE `has_furniture` ADD FOREIGN KEY (`idZone`) REFERENCES `Zone` (`id`);

ALTER TABLE `Furniture` ADD FOREIGN KEY (`id`) REFERENCES `has_furniture` (`idFurniture`);

ALTER TABLE `Furniture_Type` ADD FOREIGN KEY (`id`) REFERENCES `Furniture` (`idType`);

ALTER TABLE `Furniture_Shape` ADD FOREIGN KEY (`id`) REFERENCES `Furniture` (`idShape`);

ALTER TABLE `Furniture_has_schudle` ADD FOREIGN KEY (`idFurniture`) REFERENCES `Furniture` (`id`);

ALTER TABLE `dish_has_image` ADD FOREIGN KEY (`idDish`) REFERENCES `Dish` (`id`);

ALTER TABLE `Images` ADD FOREIGN KEY (`id`) REFERENCES `dish_has_image` (`idImages`);

ALTER TABLE `etablishement_has_image` ADD FOREIGN KEY (`idEtablishement`) REFERENCES `Establishment` (`id`);

ALTER TABLE `Images` ADD FOREIGN KEY (`id`) REFERENCES `etablishement_has_image` (`idImages`);

ALTER TABLE `Images` ADD FOREIGN KEY (`postedby`) REFERENCES `User` (`id`);

ALTER TABLE `Establishment` ADD FOREIGN KEY (`id`) REFERENCES `is_manager` (`idEtablishment`);

ALTER TABLE `Establishment` ADD FOREIGN KEY (`id`) REFERENCES `work_for` (`idEtablishment`);

ALTER TABLE `Establishment` ADD FOREIGN KEY (`id`) REFERENCES `Habits` (`idEtablishment`);

ALTER TABLE `Reservation` ADD FOREIGN KEY (`id`) REFERENCES `method_used` (`idReservation`);

ALTER TABLE `method_used` ADD FOREIGN KEY (`idMethod`) REFERENCES `Reservation_Method` (`id`);
