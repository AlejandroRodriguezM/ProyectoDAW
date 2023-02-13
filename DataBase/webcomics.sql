-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-02-2023 a las 23:11:33
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `webcomics`
--
CREATE DATABASE IF NOT EXISTS `webcomics` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `webcomics`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aboutuser`
--

DROP TABLE IF EXISTS `aboutuser`;
CREATE TABLE `aboutuser` (
  `IDuser` int(11) NOT NULL,
  `infoUser` varchar(450) NOT NULL,
  `fechaCreacion` date NOT NULL,
  `nombreUser` varchar(250) DEFAULT NULL,
  `apellidoUser` varchar(250) DEFAULT NULL,
  `strikes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Donde se guardan los datos de cada usuario';

--
-- Volcado de datos para la tabla `aboutuser`
--

INSERT INTO `aboutuser` (`IDuser`, `infoUser`, `fechaCreacion`, `nombreUser`, `apellidoUser`, `strikes`) VALUES
(1, 'Usuario invitado', '2022-12-07', 'Guest', 'Guest', 0),
(2, 'Test 3 jaja probando', '2022-12-07', 'Alejandro', 'Rodriguez Mena', 0),
(12, 'Test descipcion test', '2023-02-03', 'Alejandro', 'Rodriguez Mena', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comics`
--

DROP TABLE IF EXISTS `comics`;
CREATE TABLE `comics` (
  `IDcomic` int(11) NOT NULL,
  `nomComic` varchar(150) NOT NULL,
  `numComic` int(10) NOT NULL,
  `nomVariante` varchar(150) NOT NULL,
  `nomEditorial` varchar(45) NOT NULL,
  `Formato` varchar(45) NOT NULL,
  `Procedencia` varchar(45) NOT NULL,
  `date_published` varchar(10) NOT NULL,
  `nomGuionista` varchar(150) NOT NULL,
  `nomDibujante` varchar(150) NOT NULL,
  `Cover` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comics`
--

INSERT INTO `comics` (`IDcomic`, `nomComic`, `numComic`, `nomVariante`, `nomEditorial`, `Formato`, `Procedencia`, `date_published`, `nomGuionista`, `nomDibujante`, `Cover`) VALUES
(1, 'A.X.E: Avengers', 1, 'Salvador Larroca', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Federico Vicentini', './assets/covers_img/1.jpg'),
(2, 'A.X.E: Death to the mutants', 1, 'Esad Ribic', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Guiu Vilanova', './assets/covers_img/2.jpg'),
(3, 'A.X.E: Death to the mutants', 2, 'Esad Ribic', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Guiu Vilanova', './assets/covers_img/3.jpg'),
(4, 'A.X.E: Death to the mutants', 3, 'Bianchi', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Guiu Vilanova', './assets/covers_img/4.jpg'),
(5, 'A.X.E: Eternals', 1, 'Salvador Larroca', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Pascual Ferry', './assets/covers_img/5.jpg'),
(6, 'A.X.E: EVE of Judgment Day', 1, 'John Cassaday', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Pasqual Ferry', './assets/covers_img/6.jpg'),
(7, 'A.X.E: Judgment Day', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Valerio Schiti', './assets/covers_img/7.jpg'),
(8, 'A.X.E: Judgment Day', 2, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Valerio Schiti', './assets/covers_img/8.jpg'),
(9, 'A.X.E: Judgment Day', 3, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Valerio Schiti', './assets/covers_img/9.jpg'),
(10, 'A.X.E: Judgment Day', 4, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Valerio Schiti', './assets/covers_img/10.jpg'),
(11, 'A.X.E: Judgment Day', 5, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Valerio Schiti', './assets/covers_img/11.jpg'),
(12, 'A.X.E: Judgment Day', 6, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Valerio Schiti', './assets/covers_img/12.jpg'),
(13, 'A.X.E: Judgment Day Omega', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Guiu Villanova', './assets/covers_img/13.jpg'),
(14, 'A.X.E: Judment Day', 3, 'Skottie Young', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Valerio Schiti', './assets/covers_img/14.jpg'),
(15, 'A.X.E: X-Men', 1, 'Nic Klein', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Francesco Mobili', './assets/covers_img/15.jpg'),
(16, 'Alien', 6, 'Bjorn Barends', 'Marvel', 'Grapa', 'USA', '2023', 'Philip Kennedy Johnson', 'Julius Ohta', './assets/covers_img/16.jpg'),
(17, 'Alien', 1, 'Bjorn Barends', 'Marvel', 'Grapa', 'USA', '2022', 'Phillip Kennedy Johnson', 'Julius Ohta', './assets/covers_img/17.jpg'),
(18, 'Alien', 1, 'In-Hyuk Inhyuk Lee', 'Marvel', 'Grapa', 'USA', '2020', 'Phillip Kennedy Johnson', 'Julius Ohta', './assets/covers_img/18.jpg'),
(19, 'Alien', 2, 'Stephanie Hans', 'Marvel', 'Grapa', 'USA', '2021', 'Phillip Kennedy Johnson', 'Salvador Larroca', './assets/covers_img/19.jpg'),
(20, 'Alien', 2, 'Bjorn Barends', 'Marvel', 'Grapa', 'USA', '2022', 'Phillip Kennedy Johnson', 'Julius Ohta', './assets/covers_img/20.jpg'),
(21, 'Alien', 3, 'Adam Kubert', 'Marvel', 'Grapa', 'USA', '2021', 'Phillip Kennedy Johnson', 'Salvador Larroca', './assets/covers_img/21.jpg'),
(22, 'Alien', 4, 'Ken Ken Lashley', 'Marvel', 'Grapa', 'USA', '2021', 'Phillip Kennedy Johnson', 'Salvador Larroca', './assets/covers_img/22.jpg'),
(23, 'Alien', 5, 'In-Hyuk Inhyuk Lee', 'Marvel', 'Grapa', 'USA', '2021', 'Phillip Kennedy Johnson', 'Salvador Larroca', './assets/covers_img/23.jpg'),
(24, 'Alien', 6, 'Salvador Larroca', 'Marvel', 'Grapa', 'USA', '2021', 'Phillip Kennedy Johnson', 'Salvador Larroca', './assets/covers_img/24.jpg'),
(25, 'Alien', 7, 'Marc Aspinall', 'Marvel', 'Grapa', 'USA', '2021', 'Phillip Kennedy Johnson', 'Salvador Larroca', './assets/covers_img/25.jpg'),
(26, 'Alien', 8, 'Marc Aspinall', 'Marvel', 'Grapa', 'USA', '2021', 'Phillip Kennedy Johnson', 'Salvador Larroca', './assets/covers_img/26.jpg'),
(27, 'Alien', 9, 'Marc Aspinall', 'Marvel', 'Grapa', 'USA', '2022', 'Phillip Kennedy Johnson', 'Salvador Larroca', './assets/covers_img/27.jpg'),
(28, 'Alien', 10, 'Dan Panosian', 'Marvel', 'Grapa', 'USA', '2022', 'Phillip Kennedy Johnson', 'Salvador Larroca', './assets/covers_img/28.jpg'),
(29, 'Alien', 11, 'Marc Aspinall', 'Marvel', 'Grapa', 'USA', '2022', 'Phillip Kennedy Johnson', 'Salvador Larroca', './assets/covers_img/29.jpg'),
(30, 'Alien', 12, 'Marc Aspinall', 'Marvel', 'Grapa', 'USA', '2022', 'Phillip Kennedy Johnson', 'Salvador Larroca', './assets/covers_img/30.jpg'),
(31, 'Alien', 3, 'Iban Coello', 'Marvel', 'Grapa', 'USA', '2022', 'Phillip Kennedy Johnson', 'Julius Ohta', './assets/covers_img/31.jpg'),
(32, 'All-Out Avengers', 1, 'Salvador Larroca', 'Marvel', 'Grapa', 'USA', '2022', 'Derek Landy', 'Greg Land', './assets/covers_img/32.jpg'),
(33, 'All-Out Avengers', 3, 'Greg Land', 'Marvel', 'Grapa', 'USA', '2022', 'Derek Landy', 'Greg Land', './assets/covers_img/33.jpg'),
(34, 'Amazing Fantasy', 1000, 'Mcniven', 'Marvel', 'Grapa', 'USA', '2022', 'Kurt Busiek', 'Goran Parlov', './assets/covers_img/34.jpg'),
(35, 'Amazing Spider-Man', 22, 'John Romita Jr', 'Marvel', 'Grapa', 'USA', '2023', 'Zeb Wells', 'John Romita Jr', './assets/covers_img/35.jpg'),
(36, 'Amazing Spider-Man', 21, 'Bazaldua', 'Marvel', 'Grapa', 'USA', '2023', 'Zeb Wells', 'John Romita Jr', './assets/covers_img/36.jpg'),
(37, 'Amazing Spider-Man', 5, 'Darboe', 'Marvel', 'Grapa', 'USA', '2023', 'Dan Slott', 'Mark Bagley', './assets/covers_img/37.jpg'),
(38, 'Amazing Spider-Man', 18, 'Ryan Stegman', 'Marvel', 'Grapa', 'USA', '2023', 'Zeb Wells', 'Ed McGuinness', './assets/covers_img/38.jpg'),
(39, 'Amazing Spider-Man', 17, 'John Romita Jr', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'Ed McGuinness', './assets/covers_img/39.jpg'),
(40, 'Amazing Spider-Man', 16, 'John Romita Jr.', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'Ed McGuinness', './assets/covers_img/40.jpg'),
(41, 'Amazing Spider-Man', 3, 'Salvador Larroca', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'John Romita', './assets/covers_img/41.jpg'),
(42, 'Amazing Spider-Man', 20, 'Jan Bazaldua', 'Marvel', 'Grapa', 'USA', '2023', 'Joe Kelly', 'Terry Dodson', './assets/covers_img/42.jpg'),
(43, 'Amazing Spider-Man', 4, 'John Romita', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'John Romita', './assets/covers_img/43.jpg'),
(44, 'Amazing Spider-Man', 5, 'Mercado', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'John Romita', './assets/covers_img/44.jpg'),
(45, 'Amazing Spider-Man', 6, 'Skottie Young', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott - Daniel Kibblesmith - Zeb Wells', 'Ed McGuinness', './assets/covers_img/45.jpg'),
(46, 'Amazing Spider-Man', 6, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott - Daniel Kibblesmith - Zeb Wells', 'Ed McGuinness', './assets/covers_img/46.jpg'),
(47, 'Amazing Spider-Man', 7, 'John Romita', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'John Romita', './assets/covers_img/47.jpg'),
(48, 'Amazing Spider-Man', 8, 'Iban Coello', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'Patrick Gleason', './assets/covers_img/48.jpg'),
(49, 'Amazing Spider-Man', 8, 'John Romita', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'John Romita', './assets/covers_img/49.jpg'),
(50, 'Amazing Spider-Man', 9, 'Gleason', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'Patrick Gleason', './assets/covers_img/50.jpg'),
(51, 'Amazing Spider-Man', 10, 'Martin Beyond', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'Nick Dragotta', './assets/covers_img/51.jpg'),
(52, 'Amazing Spider-Man', 11, 'Gomez', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'John Romita', './assets/covers_img/52.jpg'),
(53, 'Amazing Spider-Man', 12, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'John Romita', './assets/covers_img/53.jpg'),
(54, 'Amazing Spider-Man', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'John Romita', './assets/covers_img/54.jpg'),
(55, 'Amazing Spider-Man', 1, 'Gleaso', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'John Romita', './assets/covers_img/55.jpg'),
(56, 'Amazing Spider-Man', 2, 'Inhyuk Lee', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'John Romita', './assets/covers_img/56.jpg'),
(57, 'Amazing Spider-Man', 14, 'John Romita Jr', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'Michael Dowling - Kyle Hotz', './assets/covers_img/57.jpg'),
(58, 'Amazing Spider-Man', 13, 'John Romita Jr', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'John Romita Jr', './assets/covers_img/58.jpg'),
(59, 'Amazing Spider-Man', 15, 'Salvador Larroca', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'Ed McGuinness', './assets/covers_img/59.jpg'),
(60, 'Amazing Spider-Man: Edge of Spider-Verse', 1, 'Skottie Young', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'Mark Mark Bagley', './assets/covers_img/60.jpg'),
(61, 'Amazing Spider-Man: Edge of Spider-Verse', 5, 'Josemaria Casanovas', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'Bob McLeod', './assets/covers_img/61.jpg'),
(62, 'Amazing Spider-Man: Edge of Spider-Verse', 2, 'Josemaria Casanovas', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'Mark Mark Bagley', './assets/covers_img/62.jpg'),
(63, 'Amazing Spider-Man: Edge of Spider-Verse', 1, 'Josemaria Casanovas', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'Mark Mark Bagley', './assets/covers_img/63.jpg'),
(64, 'Amazing Spider-Man: Edge of Spider-Verse', 1, 'Giuseppe Camuncoli', 'Marvel', 'Tomo', 'USA', '2015', 'David Hine - Christos Gage ', 'Giuseppe Camuncoli', './assets/covers_img/64.jpg'),
(65, 'Amazing Spider-Man: Edge of Spider-Verse', 3, 'Josemaria Casanovas', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'Mark Mark Bagley', './assets/covers_img/65.jpg'),
(66, 'Amazing Spider-Man: Edge of Spider-Verse', 4, 'Josemaria Casanovas', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'Nathan Stockman', './assets/covers_img/66.jpg'),
(67, 'America Chavez: Made in the USA', 5, 'Natacha Bustos', 'Marvel', 'Grapa', 'USA', '2021', 'Kalinda Vazquez', 'Carlos Gomez', './assets/covers_img/67.jpg'),
(68, 'Ant-Man', 1, 'Gleason', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Tom Reilly', './assets/covers_img/68.jpg'),
(69, 'Ant-Man', 4, 'Tom Reilly', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Tom Reilly', './assets/covers_img/69.jpg'),
(70, 'Ant-Man', 3, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Tom Reilly', './assets/covers_img/70.jpg'),
(71, 'Ant-Man', 2, 'Tom Reilly', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Tom Reilly', './assets/covers_img/71.jpg'),
(72, 'Arma plus: IV guerra mundial', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Georges Jeanty', 'Benjamin Percy', './assets/covers_img/72.jpg'),
(73, 'Avengers', 56, 'Javier Garron', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'Javier Garron', './assets/covers_img/73.jpg'),
(74, 'Avengers', 57, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'Javier Garron', './assets/covers_img/74.jpg'),
(75, 'Avengers', 59, 'Mark Bagley', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'Javier Garron', './assets/covers_img/75.jpg'),
(76, 'Avengers', 60, 'Frank Martin', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'Javier Garron', './assets/covers_img/76.jpg'),
(77, 'Avengers Assemble Alpha', 1, 'Salvador Larroca', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'Bryan Hitch', './assets/covers_img/77.jpg'),
(78, 'Avengers forever', 5, 'Aaron Kuder', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'James Towe', './assets/covers_img/78.jpg'),
(79, 'Avengers forever', 6, 'Aaron Kuder', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'James Towe', './assets/covers_img/79.jpg'),
(80, 'Avengers forever', 7, 'Luciano Vecchio', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'Aaron Kuder', './assets/covers_img/80.jpg'),
(81, 'Avengers forever', 8, 'Aaron Kuder', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'Aaron Kuder', './assets/covers_img/81.jpg'),
(82, 'Avengers forever', 9, 'Conley', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'Aaron Kuder', './assets/covers_img/82.jpg'),
(83, 'Avengers forever', 1, 'Aaron Kuder', 'Marvel', 'Grapa', 'USA', '2021', 'Jason Aaron', 'Aaron Kuder', './assets/covers_img/83.jpg'),
(84, 'Avengers forever', 2, 'Aaron Kuder', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'Aaron Kuder -  Carlos Magno', './assets/covers_img/84.jpg'),
(85, 'Avengers forever', 3, 'Ed Mcguinness', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'Aaron Kuder', './assets/covers_img/85.jpg'),
(86, 'Avengers forever', 3, 'Aaron Kuder', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'Aaron Kuder', './assets/covers_img/86.jpg'),
(87, 'Avengers forever', 4, 'R. B. Silva', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'James Towe', './assets/covers_img/87.jpg'),
(88, 'Avengers forever', 4, 'Aaron Kuder', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'James Towe', './assets/covers_img/88.jpg'),
(89, 'Avengers: 1.000.000 BC', 1, 'Skottie Young', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'Kev Walker', './assets/covers_img/89.jpg'),
(90, 'Avengers: End Times - Marvel Tales 1', 1, 'Nick Bradshaw', 'Marvel', 'Grapa', 'USA', '2023', 'Brian Michael Bendis', 'Mike Mayhew - Brandon Peterson', './assets/covers_img/90.jpg'),
(91, 'Baños Pleamar', 1, 'Isaac Sánchez González', 'Plan B Publicaciones', 'Tomo', 'Spain', '2022', 'Isaac Sánchez González', 'Isaac Sánchez González', './assets/covers_img/91.jpg'),
(92, 'Batman (2016 3RD Series)', 117, 'Jorge Molina', 'DC', 'Grapa', 'USA', '2021', 'James Tynion IV - Becky Cloonan - Michael W. Conrad ', 'Jorge Jimenez - Jorge Corona', './assets/covers_img/92.jpg'),
(93, 'Batman (2016 3RD Series)', 117, 'Jorge Jimenez', 'DC', 'Grapa', 'USA', '2021', 'James Tynion IV - Becky Cloonan - Michael W. Conrad', 'Jorge Jimenez - Jorge Corona', './assets/covers_img/93.jpg'),
(94, 'Batman (2016 3RD Series)', 125, 'Jorge Jimenez', 'DC', 'Grapa', 'USA', '2021', 'James Tynion IV - Becky Cloonan - Michael W. Conrad ', 'Jorge Jimenez - Jorge Corona', './assets/covers_img/94.jpg'),
(95, 'Batman / Spawn: Unplugged', 1, 'Todd McFarlane', 'DC', 'Grapa', 'USA', '2023', 'Greg Capullo', 'Greg Capullo', './assets/covers_img/95.jpg'),
(96, 'Ben Reilly: Spider-Man', 1, 'Dan Jurgens', 'Marvel', 'Grapa', 'USA', '2022', 'J.M. DeMatteis', 'David Baldeon', './assets/covers_img/96.jpg'),
(97, 'Ben Reilly: Spider-Man', 2, 'Dan Jurgens', 'Marvel', 'Grapa', 'USA', '2022', 'J.M. DeMatteis', 'David Baldeon', './assets/covers_img/97.jpg'),
(98, 'Ben Reilly: Spider-Man', 3, 'Dan Jurgens', 'Marvel', 'Grapa', 'USA', '2022', 'J.M. DeMatteis', 'David Baldeon', './assets/covers_img/98.jpg'),
(99, 'Ben Reilly: Spider-Man', 4, 'Steve Skroce', 'Marvel', 'Grapa', 'USA', '2022', 'J.M. DeMatteis', 'David Baldeon', './assets/covers_img/99.jpg'),
(100, 'Ben Reilly: Spider-Man', 5, 'Steve Skroce', 'Marvel', 'Grapa', 'USA', '2022', 'J.M. DeMatteis', 'David Baldeon', './assets/covers_img/100.jpg'),
(101, 'Berserk', 2, 'Kentaro Miura', 'Dark Horse', 'Tomo', 'USA', '2019', 'Kentaro Miura', 'Kentaro Miura', './assets/covers_img/101.jpg'),
(102, 'Berserk Deluxe Edition HC', 12, 'Kentaro Miura', 'Dark Horse', 'Manga', 'USA', '2023', 'Kentaro Miura', 'Kentaro Miura', './assets/covers_img/102.jpg'),
(103, 'Berserk Deluxe Edition HC', 10, 'Kentaro Miura', 'Dark Horse', 'Tomo', 'USA', '2022', 'Kentaro Miura', 'Kentaro Miura', './assets/covers_img/103.jpg'),
(104, 'Berserk Deluxe Edition HC', 11, 'Kentaro Miura', 'Dark Horse', 'Tomo', 'USA', '2022', 'Kentaro Miura', 'Kentaro Miura', './assets/covers_img/104.jpg'),
(105, 'Berserk Deluxe Edition HC', 9, 'Kentaro Miura', 'Dark Horse', 'Manga', 'USA', '2019', 'Kentaro Miura', 'Kentaro Miura', './assets/covers_img/105.jpg'),
(106, 'Berserk Deluxe Edition HC', 8, 'Kentaro Miura', 'Dark Horse', 'Manga', 'USA', '2019', 'Kentaro Miura', 'Kentaro Miura', './assets/covers_img/106.jpg'),
(107, 'Berserk Deluxe Edition HC', 7, 'Kentaro Miura', 'Dark Horse', 'Manga', 'USA', '2019', 'Kentaro Miura', 'Kentaro Miura', './assets/covers_img/107.jpg'),
(108, 'Berserk Deluxe Edition HC', 6, 'Kentaro Miura', 'Dark Horse', 'Manga', 'USA', '2019', 'Kentaro Miura', 'Kentaro Miura', './assets/covers_img/108.jpg'),
(109, 'Berserk Deluxe Edition HC', 5, 'Kentaro Miura', 'Dark Horse', 'Manga', 'USA', '2019', 'Kentaro Miura', 'Kentaro Miura', './assets/covers_img/109.jpg'),
(110, 'Berserk Deluxe Edition HC', 4, 'Kentaro Miura', 'Dark Horse', 'Manga', 'USA', '2019', 'Kentaro Miura', 'Kentaro Miura', './assets/covers_img/110.jpg'),
(111, 'Berserk Deluxe Edition HC', 3, 'Kentaro Miura', 'Dark Horse', 'Manga', 'USA', '2019', 'Kentaro Miura', 'Kentaro Miura', './assets/covers_img/111.jpg'),
(112, 'Berserk Deluxe Edition HC', 1, 'Kentaro Miura', 'Dark Horse', 'Manga', 'USA', '2019', 'Kentaro Miura', 'Kentaro Miura', './assets/covers_img/112.jpg'),
(113, 'Berserk Deluxe Edition HC', 2, 'Kentaro Miura', 'Dark Horse', 'Manga', 'USA', '2019', 'Kentaro Miura', 'Kentaro Miura', './assets/covers_img/113.jpg'),
(114, 'Big Girls', 1, 'Peach Momoko', 'Image Comics', 'Grapa', 'USA', '2020', 'Jason Howard', 'Jason Howard', './assets/covers_img/114.jpg'),
(115, 'Black Bolt HC', 1, 'Christian Ward', 'Marvel', 'Tomo', 'USA', '2017', 'Saladin Ahmed- Christian Ward', 'Christian Ward', './assets/covers_img/115.jpg'),
(116, 'Black Panther', 15, 'Alex Ross', 'Marvel', 'Grapa', 'USA', '2023', 'John Ridley', 'German Peralta', './assets/covers_img/116.jpg'),
(117, 'Black Panther', 14, 'Romero', 'Marvel', 'Grapa', 'USA', '2023', 'John Ridley', 'German Peralta', './assets/covers_img/117.jpg'),
(118, 'Black Panther', 13, 'Paco Medina', 'Marvel', 'Grapa', 'USA', '2023', 'John Ridley', 'German Peralta', './assets/covers_img/118.jpg'),
(119, 'Black Panther', 12, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'John Ridley', 'German Peralta', './assets/covers_img/119.jpg'),
(120, 'Black Panther', 1, 'John Romita', 'Marvel', 'Grapa', 'USA', '2021', 'John Ridley', 'Juan Cabal', './assets/covers_img/120.jpg'),
(121, 'Black Panther', 2, 'Ken Lashley', 'Marvel', 'Grapa', 'USA', '2021', 'John Ridley', 'Juan Cabal', './assets/covers_img/121.jpg'),
(122, 'Black Panther', 3, 'Joe Jusko', 'Marvel', 'Grapa', 'USA', '2022', 'John Ridley', 'Stefano Landini', './assets/covers_img/122.jpg'),
(123, 'Black Panther', 4, 'Noto', 'Marvel', 'Grapa', 'USA', '2022', 'John Ridley', 'Juan Cabal', './assets/covers_img/123.jpg'),
(124, 'Black Panther', 5, 'Greg Land', 'Marvel', 'Grapa', 'USA', '2022', 'John Ridley', 'Juann Cabal', './assets/covers_img/124.jpg'),
(125, 'Black Panther', 5, 'Juan Cabal', 'Marvel', 'Grapa', 'USA', '2022', 'John Ridley', 'German Peralta', './assets/covers_img/125.jpg'),
(126, 'Black Panther', 6, 'Dike Ruan', 'Marvel', 'Grapa', 'USA', '2022', 'John Ridley', 'Stefano Landini', './assets/covers_img/126.jpg'),
(127, 'Black Panther', 7, 'R. B. Silva', 'Marvel', 'Grapa', 'USA', '2022', 'John Ridley', 'Stefano Landini', './assets/covers_img/127.jpg'),
(128, 'Black Panther', 8, 'Stefano Landini', 'Marvel', 'Grapa', 'USA', '2022', 'John Ridley', 'Stefano Landini', './assets/covers_img/128.jpg'),
(129, 'Black Panther', 9, 'German Peralta', 'Marvel', 'Grapa', 'USA', '2022', 'John Ridley', 'German Peralta', './assets/covers_img/129.jpg'),
(130, 'Black Panther', 10, 'German Peralta', 'Marvel', 'Grapa', 'USA', '2022', 'John Ridley', 'Juan Cabal', './assets/covers_img/130.jpg'),
(131, 'Black Panther', 25, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2021', 'Ta-Nehisi Coates', 'Brian Stelfreeze -  Daniel Acuna', './assets/covers_img/131.jpg'),
(132, 'Black Panther ', 11, 'Alex Ross', 'Marvel', 'Grapa', 'USA', '2022', 'John Ridley', 'German Peralta', './assets/covers_img/132.jpg'),
(133, 'Black Widow', 13, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2020', 'Kelly Thompson', 'Rafael Pimentel', './assets/covers_img/133.jpg'),
(134, 'Bone Orchard Black Feathers', 1, 'Andrea Sorrentino', 'Image Comics', 'Grapa', 'USA', '2022', 'Jeff Lemire', 'Dave Stewart', './assets/covers_img/134.jpg'),
(135, 'Bone Orchard Black Feathers', 2, 'Dani - Brad Simpson', 'Image Comics', 'Grapa', 'USA', '2022', 'Jeff Lemire', ' Andrea Sorrentino - Dave Stewart', './assets/covers_img/135.jpg'),
(136, 'Bone Orchard Mythos HC Black Feathers', 1, 'Andrea Sorrentino', 'Image Comics', 'Tomo', 'USA', '2023', 'Jeff Lemire', 'Dave Stewart - Andrea Sorrentino', './assets/covers_img/136.jpg'),
(137, 'Bone Orchard Mythos HC Passageway', 1, 'Andrea Sorrentino', 'Image Comics', 'Tomo', 'USA', '2023', 'Jeff Lemire', 'Andrea Sorrentino', './assets/covers_img/137.jpg'),
(138, 'Captain America: Sentinel of Liberty', 10, 'R. B. Silva', 'Marvel', 'Grapa', 'USA', '2023', 'Tochi Onyebuchi', 'Ig Guara', './assets/covers_img/138.jpg'),
(139, 'Captain America: Sentinel of Liberty', 9, 'Ron Lim', 'Marvel', 'Grapa', 'USA', '2023', 'Collin Kelly - Jackson Lanzing', 'Carmen Carnero', './assets/covers_img/139.jpg'),
(140, 'Captain America: Sentinel of Liberty', 8, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2023', 'Collin Kelly - Jackson Lanzing', 'Carmen Carnero', './assets/covers_img/140.jpg'),
(141, 'Captain America: Sentinel of Liberty', 7, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2022', 'Collin Kelly - Jackson Lanzing', 'Carmen Carnero', './assets/covers_img/141.jpg'),
(142, 'Captain America: Sentinel of Liberty', 1, 'Skottie Young', 'Marvel', 'Grapa', 'USA', '2022', 'Jackson Lanzing - Collin Kelly', 'Carmen Carnero', './assets/covers_img/142.jpg'),
(143, 'Captain America: Sentinel of Liberty', 2, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Collin Kelly - Jackson Lanzing', 'Carmen Carnero', './assets/covers_img/143.jpg'),
(144, 'Captain America: Sentinel of Liberty', 5, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2022', 'Jackson Lanzing - Collin Kelly', 'Carmen Carnero', './assets/covers_img/144.jpg'),
(145, 'Captain America: Sentinel of Liberty', 3, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2022', 'Jackson Lanzing - Collin Kelly', 'Carmen Carnero', './assets/covers_img/145.jpg'),
(146, 'Captain America: Sentinel of Liberty', 4, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2022', 'Jackson Lanzing - Collin Kelly', 'Carmen Carnero', './assets/covers_img/146.jpg'),
(147, 'Captain America: Sentinel of Liberty', 6, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2022', 'Collin Kelly - Jackson Lanzing', 'Carmen Carnero', './assets/covers_img/147.jpg'),
(148, 'Captain America: Winter Soldier Special', 1, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2022', 'Collin Kelly - Jackson Lanzing', 'Kev Walker', './assets/covers_img/148.jpg'),
(149, 'Captain Carter', 2, 'Jamie McKelvie', 'Marvel', 'Grapa', 'USA', '2022', 'Jamie Mckelvie', 'Marika Cresta', './assets/covers_img/149.jpg'),
(150, 'Captain Carter', 3, 'Jamie McKelvie', 'Marvel', 'Grapa', 'USA', '2022', 'Jamie Mckelvie', 'Marika Cresta', './assets/covers_img/150.jpg'),
(151, 'Captain Carter', 4, 'Jamie McKelvie', 'Marvel', 'Grapa', 'USA', '2022', 'Jamie Mckelvie', 'Marika Cresta', './assets/covers_img/151.jpg'),
(152, 'Captain Carter', 5, 'Jamie McKelvie', 'Marvel', 'Grapa', 'USA', '2022', 'Jamie Mckelvie', 'Marika Cresta', './assets/covers_img/152.jpg'),
(153, 'Captain Carter', 1, 'Declan Shalvey', 'Marvel', 'Grapa', 'USA', '2022', 'Jamie Mckelvie', 'Marika Cresta', './assets/covers_img/153.jpg'),
(154, 'Captain Carter', 1, 'Jamie McKelvie', 'Marvel', 'Grapa', 'USA', '2022', 'Jamie Mckelvie', 'Marika Cresta', './assets/covers_img/154.jpg'),
(155, 'Captain Marvel', 47, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2023', 'Kelly Thompson', 'Sergio Davila', './assets/covers_img/155.jpg'),
(156, 'Carnage', 11, 'Marco Mastrazzo', 'Marvel', 'Grapa', 'USA', '2023', 'Alex Paknadel', 'Roge Antonia', './assets/covers_img/156.jpg'),
(157, 'Carnage', 10, 'VACIO', 'Marvel', 'Grapa', 'USA', '2023', 'VACIO', 'VACIO', './assets/covers_img/157.jpg'),
(158, 'Carnage', 11, 'Kendrick Lim', 'Marvel', 'Grapa', 'USA', '2023', 'Francesco Manna', 'Ram. V.', './assets/covers_img/158.jpg'),
(159, 'Carnage', 9, 'Paulo Siqueira', 'Marvel', 'Grapa', 'USA', '2023', 'Ram. V.', 'Francesco Manna', './assets/covers_img/159.jpg'),
(160, 'Carnage', 8, 'Jonboy Meyers', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V.', 'Roge Antonia', './assets/covers_img/160.jpg'),
(161, 'Carnage', 2, 'Iban Coello', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V.', 'Francesco Manna', './assets/covers_img/161.jpg'),
(162, 'Carnage', 3, 'Ron Lim', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V.', 'Roge Antonio', './assets/covers_img/162.jpg'),
(163, 'Carnage', 4, 'Nakayama', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V.', 'Francesco Manna', './assets/covers_img/163.jpg'),
(164, 'Carnage', 5, 'Nakayama', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V.', 'Francesco Manna', './assets/covers_img/164.jpg'),
(165, 'Carnage', 6, 'Kendrick Lim', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V.', 'Roge Antonio', './assets/covers_img/165.jpg'),
(166, 'Carnage', 7, 'Kendrick Lim', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V.', 'Roge Antonio', './assets/covers_img/166.jpg'),
(167, 'Carnage', 1, 'Kendrick Lim', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V. - David Michelinie', 'Francesco Manna - Ron Lim', './assets/covers_img/167.jpg'),
(168, 'Carnage Forever (2022)', 1, 'Mark Bagley', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V. - Ty Templeton - Phillip Kennedy Johnson', 'Ty Templeton - Edgar Salazar - Salvador Larroca', './assets/covers_img/168.jpg'),
(169, 'Colección 100% Marvel - Bill Rayos Beta: Estrella Argentea', 1, 'Daniel Warren Johnson', 'Panini', 'Tomo', 'Spain', '2021', 'Daniel Warren Johnson', 'Mike Spicer', './assets/covers_img/169.jpg'),
(170, 'Cosmic Ghost Rider', 1, 'Ryan Stegman', 'Marvel', 'Grapa', 'USA', '2023', 'VACIO', 'VACIO', './assets/covers_img/170.jpg'),
(171, 'Crossover', 2, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Donny Cates', 'Dee Cunniffe - Geoff Shaw', './assets/covers_img/171.jpg'),
(172, 'Crossover', 1, 'Geoff Shaw', 'Panini', 'Tomo', 'Spain', '2022', 'Donny Cates', 'Geoff Shaw', './assets/covers_img/172.jpg'),
(173, 'Crypt of Shadows', 1, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2022', 'Rebecca Roanhorse', 'Karen Darboe', './assets/covers_img/173.jpg'),
(174, 'Damage control', 3, 'Anthony Michael FInhyuk Leecs', 'Marvel', 'Grapa', 'USA', '2022', 'Hans Rodionoff - Adam Goldberg', 'Nathan Stockman - Will Robson', './assets/covers_img/174.jpg'),
(175, 'Damage control', 1, 'Carlos Pacheco', 'Marvel', 'Grapa', 'USA', '2022', 'Goldberg - Hans Rodionoff - Charlotte Fullerton', 'Will Robson - Jay Fosgitt', './assets/covers_img/175.jpg'),
(176, 'Daredevil', 9, 'Marco Checchetto', 'Marvel', 'Grapa', 'USA', '2023', 'Chip Zdarsky', 'Rafael De Latorre', './assets/covers_img/176.jpg'),
(177, 'Daredevil', 6, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Rafael De Latorre', './assets/covers_img/177.jpg'),
(178, 'Daredevil', 6, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Rafael De Latorre', './assets/covers_img/178.jpg'),
(179, 'Daredevil', 1, 'John Romita', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Rafael De Latorre - Marco Checchetto', './assets/covers_img/179.jpg'),
(180, 'Daredevil', 1, 'Panosi', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Rafael De Latorre - Marco Checchetto', './assets/covers_img/180.jpg'),
(181, 'Daredevil', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Rafael De Latorre - Marco Checchetto', './assets/covers_img/181.jpg'),
(182, 'Daredevil', 1, 'Dan Panosian', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Rafael De Latorre - Marco Checchetto', './assets/covers_img/182.jpg'),
(183, 'Daredevil', 2, 'Bill Sienkiewicz', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Rafael De Latorre - Marco Checchetto', './assets/covers_img/183.jpg'),
(184, 'Daredevil', 3, 'Marco Checchetto', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Rafael De Latorre', './assets/covers_img/184.jpg'),
(185, 'Daredevil', 4, 'Marco Checchetto', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Rafael De Latorre', './assets/covers_img/185.jpg'),
(186, 'Daredevil', 319, 'Scott McDaniel', 'Marvel', 'Grapa', 'USA', '1993', 'D.G. Chichester', 'Scott McDaniel', './assets/covers_img/186.jpg'),
(187, 'Daredevil', 2, 'Bill Sienkiewicz', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Rafael De Latorre - Marco Checchetto', './assets/covers_img/187.jpg'),
(188, 'Daredevil', 5, 'Marco Checchetto', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Marco Checchetto', './assets/covers_img/188.jpg'),
(189, 'Daredevil Woman Without fear', 1, 'Chris Bachalo', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Rafael De Latorre', './assets/covers_img/189.jpg'),
(190, 'Daredevil Woman Without fear', 2, 'Chris Bachalo', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Rafael De Latorre', './assets/covers_img/190.jpg'),
(191, 'Daredevil Woman Without fear', 3, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Rafael De Latorre', './assets/covers_img/191.jpg'),
(192, 'Daredevil: Amarillo', 1, 'Tim Sale', 'Panini', 'Tomo', 'Spain', '2022', 'Tim Sale', 'Jeph Loeb', './assets/covers_img/192.jpg'),
(193, 'Dark ages', 1, 'Iban Coello', 'Marvel', 'Grapa', 'USA', '2021', 'Tom Taylor', 'Iban Coello', './assets/covers_img/193.jpg'),
(194, 'Dark ages', 2, 'Iban Coello', 'Marvel', 'Grapa', 'USA', '2021', 'Tom Taylor', 'Iban Coello', './assets/covers_img/194.jpg'),
(195, 'Dark ages', 3, 'Okazaki', 'Marvel', 'Grapa', 'USA', '2022', 'Tom Taylor', 'Iban Coello', './assets/covers_img/195.jpg'),
(196, 'Dark ages', 3, 'Iban Coello', 'Marvel', 'Grapa', 'USA', '2022', 'Tom Taylor', 'Iban Coello', './assets/covers_img/196.jpg'),
(197, 'Dark ages', 4, 'Mckone', 'Marvel', 'Grapa', 'USA', '2022', 'Tom Taylor', 'Iban Coello', './assets/covers_img/197.jpg'),
(198, 'Dark ages', 5, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Tom Taylor', 'Iban Coello', './assets/covers_img/198.jpg'),
(199, 'Dark ages', 6, 'Asrar', 'Marvel', 'Grapa', 'USA', '2022', 'Tom Taylor', 'Iban Coello', './assets/covers_img/199.jpg'),
(200, 'Dark ages', 6, 'Iban Coello', 'Marvel', 'Grapa', 'USA', '2022', 'Tom Taylor', 'Iban Coello', './assets/covers_img/200.jpg'),
(201, 'Dark ages', 1, 'Iban Coello', 'Marvel', 'Grapa', 'USA', '2021', 'Tom Taylor', 'Iban Coello', './assets/covers_img/201.jpg'),
(202, 'Dark Crisis', 1, 'Daniel Sampere', 'DC', 'Grapa', 'USA', '2022', 'Joshua Williamson', 'Daniel Sampere', './assets/covers_img/202.jpg'),
(203, 'Dark One', 1, 'Collin Kelly', 'Vault Comics', 'Tomo', 'USA', '2021', 'Jackson Lanzing - Brandom Sanderson', 'Collin Kelly', './assets/covers_img/203.jpg'),
(204, 'Dark Web', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells', 'Adam Kubert', './assets/covers_img/204.jpg'),
(205, 'Dark Web Finale', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2023', 'VACIO', 'VACIO', './assets/covers_img/205.jpg'),
(206, 'Darkhold Alpha', 1, 'Greg Smallwood', 'Marvel', 'Grapa', 'USA', '2021', 'Steve Orlando', 'Cian Tormey', './assets/covers_img/206.jpg'),
(207, 'Darkhold TP', 1, 'Greg Smallwood', 'Marvel', 'Tomo', 'USA', '2022', 'Steve Orlando', 'Cian Tormey', './assets/covers_img/207.jpg'),
(208, 'Deadly Neighborhood Spider-Man', 1, 'Iban Coello', 'Marvel', 'Grapa', 'USA', '2022', 'B. Earl', 'Juan Ferreyra', './assets/covers_img/208.jpg'),
(209, 'Deadpool', 2, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Alyssa Wong', 'Martin Coccolo', './assets/covers_img/209.jpg'),
(210, 'Death of doctor Strange', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2021', 'Jed Mackay', 'Inhyuk Lee Garbett', './assets/covers_img/210.jpg'),
(211, 'Death of doctor Strange', 1, 'Kaare Andrews', 'Marvel', 'Grapa', 'USA', '2021', 'Jed Mackay', 'Inhyuk Lee Garbett', './assets/covers_img/211.jpg'),
(212, 'Death of doctor Strange', 2, 'Jusko', 'Marvel', 'Grapa', 'USA', '2021', 'Jed Mackay', 'Inhyuk Lee Garbett', './assets/covers_img/212.jpg'),
(213, 'Death of doctor Strange', 3, 'Inhyuk Lee', 'Marvel', 'Grapa', 'USA', '2021', 'Jed Mackay', 'Inhyuk Lee Garbett', './assets/covers_img/213.jpg'),
(214, 'Death of doctor Strange', 4, 'Devils Reign', 'Marvel', 'Grapa', 'USA', '2021', 'Jed Mackay', 'Inhyuk Lee Garbett', './assets/covers_img/214.jpg'),
(215, 'Death of doctor Strange', 5, 'David Lopez', 'Marvel', 'Grapa', 'USA', '2022', 'Jed Mackay', 'Inhyuk Lee Garbett', './assets/covers_img/215.jpg'),
(216, 'Death of doctor Strange', 5, 'Kaare Andrews', 'Marvel', 'Grapa', 'USA', '2022', 'Jed Mackay', 'Inhyuk Lee Garbett', './assets/covers_img/216.jpg'),
(217, 'Death of Doctor Strange Companion TP', 1, 'Cory Smith', 'Marvel', 'Tomo', 'USA', '2022', 'Alex Paknadel - More ', 'Ryan Bodenheim - More', './assets/covers_img/217.jpg'),
(218, 'Defenders (2021)', 1, 'Marcos Martin', 'Marvel', 'Grapa', 'USA', '2021', 'Al Ewing', 'Javier Rodriguez', './assets/covers_img/218.jpg'),
(219, 'Defenders (2021)', 1, 'Javier Rodriguez', 'Marvel', 'Grapa', 'USA', '2021', 'Al Ewing', 'Javier Rodriguez', './assets/covers_img/219.jpg'),
(220, 'Defenders (2021)', 2, 'Javier Rodriguez', 'Marvel', 'Grapa', 'USA', '2021', 'Al Ewing', 'Javier Rodriguez', './assets/covers_img/220.jpg'),
(221, 'Defenders (2021)', 3, 'Javier Rodriguez', 'Marvel', 'Grapa', 'USA', '2021', 'Al Ewing', 'Javier Rodriguez', './assets/covers_img/221.jpg'),
(222, 'Defenders (2021)', 4, 'Javier Rodriguez', 'Marvel', 'Grapa', 'USA', '2021', 'Al Ewing', 'Javier Rodriguez', './assets/covers_img/222.jpg'),
(223, 'Defenders (2021)', 5, 'Neuware', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Javier Rodriguez', './assets/covers_img/223.jpg'),
(224, 'Defenders (2021)', 5, 'Javier Rodriguez', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Javier Rodriguez', './assets/covers_img/224.jpg'),
(225, 'Defenders: Beyond', 1, 'Natacha Bustos', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Javier Rodriguez', './assets/covers_img/225.jpg'),
(226, 'Defenders: Beyond', 2, 'Javier Rodriguez', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Javier Rodriguez', './assets/covers_img/226.jpg'),
(227, 'Defenders: Beyond', 3, 'Javier Rodriguez', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Javier Rodriguez', './assets/covers_img/227.jpg'),
(228, 'Defenders: Beyond', 4, 'Javier Rodriguez', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Javier Rodriguez', './assets/covers_img/228.jpg'),
(229, 'Defenders: Beyond', 5, 'Javier Rodriguez', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Javier Rodriguez', './assets/covers_img/229.jpg'),
(230, 'Demon Days X-Men ', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2021', 'Peach Momoko - Zack Davisson', 'Peach Momoko', './assets/covers_img/230.jpg'),
(231, 'Devil Reign', 1, 'Marco Checchetto', 'Marvel', 'Grapa', 'USA', '2021', 'Chip Zdarsky', 'Marco Checchetto', './assets/covers_img/231.jpg'),
(232, 'Devil Reign', 2, 'Marco Checchetto', 'Marvel', 'Grapa', 'USA', '2021', 'Chip Zdarsky', 'Marco Checchetto', './assets/covers_img/232.jpg'),
(233, 'Devil Reign', 3, 'Marco Checchetto', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Marco Checchetto', './assets/covers_img/233.jpg'),
(234, 'Devil Reign', 4, 'Marco Checchetto', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Marco Checchetto', './assets/covers_img/234.jpg'),
(235, 'Devil Reign', 5, 'Marco Checchetto', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Marco Checchetto', './assets/covers_img/235.jpg'),
(236, 'Devil Reign', 6, 'Marco Checchetto', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky', 'Marco Checchetto', './assets/covers_img/236.jpg'),
(237, 'Devil Reign Omega', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Chip Zdarsky - Jim Zub - Rodney Barnes', 'Guillermo Sanna - Luciano Vecchio - Rafael De Latorre', './assets/covers_img/237.jpg'),
(238, 'Doctor Extraño', 29, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Dennis Hopeless', 'Niko Henrichon', './assets/covers_img/238.jpg'),
(239, 'Doctor Extraño', 30, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Dennis Hopeless', 'Niko Henrichon', './assets/covers_img/239.jpg'),
(240, 'Doctor Extraño', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/240.jpg'),
(241, 'Doctor Extraño', 13, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/241.jpg'),
(242, 'Doctor Extraño', 14, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/242.jpg'),
(243, 'Doctor Extraño', 15, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/243.jpg'),
(244, 'Doctor Extraño', 16, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/244.jpg'),
(245, 'Doctor Extraño', 17, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/245.jpg'),
(246, 'Doctor Extraño', 18, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/246.jpg'),
(247, 'Doctor Extraño', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/247.jpg'),
(248, 'Doctor Extraño', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/248.jpg'),
(249, 'Doctor Extraño', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/249.jpg'),
(250, 'Doctor Extraño', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/250.jpg'),
(251, 'Doctor Extraño', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/251.jpg'),
(252, 'Doctor Extraño', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/252.jpg'),
(253, 'Doctor Extraño', 10, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/253.jpg'),
(254, 'Doctor Extraño', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/254.jpg'),
(255, 'Doctor Extraño', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/255.jpg'),
(256, 'Doctor Extraño', 11, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/256.jpg'),
(257, 'Doctor Extraño', 12, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/257.jpg'),
(258, 'Doctor Extraño', 12, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/258.jpg'),
(259, 'Doctor Extraño', 13, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/259.jpg'),
(260, 'Doctor Extraño', 14, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/260.jpg'),
(261, 'Doctor Extraño', 15, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/261.jpg'),
(262, 'Doctor Extraño', 16, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/262.jpg'),
(263, 'Doctor Extraño', 17, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/263.jpg'),
(264, 'Doctor Extraño', 18, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/264.jpg'),
(265, 'Doctor Extraño', 19, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/265.jpg'),
(266, 'Doctor Extraño', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/266.jpg'),
(267, 'Doctor Extraño', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/267.jpg'),
(268, 'Doctor Extraño', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/268.jpg'),
(269, 'Doctor Extraño', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/269.jpg'),
(270, 'Doctor Extraño', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/270.jpg'),
(271, 'Doctor Extraño', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/271.jpg'),
(272, 'Doctor Extraño', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/272.jpg'),
(273, 'Doctor Extraño', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/273.jpg'),
(274, 'Doctor Extraño', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/274.jpg'),
(275, 'Doctor Extraño', 10, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/275.jpg'),
(276, 'Doctor Extraño', 11, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/276.jpg'),
(277, 'Doctor Extraño', 23, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Dennis Hopeless', 'Niko Henrichon', './assets/covers_img/277.jpg'),
(278, 'Doctor Extraño', 24, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Dennis Hopeless', 'Niko Henrichon', './assets/covers_img/278.jpg'),
(279, 'Doctor Extraño', 25, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Dennis Hopeless', 'Niko Henrichon', './assets/covers_img/279.jpg'),
(280, 'Doctor Extraño', 26, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Dennis Hopeless', 'Niko Henrichon', './assets/covers_img/280.jpg'),
(281, 'Doctor Extraño', 27, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Dennis Hopeless', 'Niko Henrichon', './assets/covers_img/281.jpg'),
(282, 'Doctor Extraño', 20, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Chris Bachalo', './assets/covers_img/282.jpg'),
(283, 'Doctor Extraño', 21, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Dennis Hopeless', 'Niko Henrichon', './assets/covers_img/283.jpg'),
(284, 'Doctor Extraño', 22, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Dennis Hopeless', 'Niko Henrichon', './assets/covers_img/284.jpg'),
(285, 'Doctor Extraño', 31, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Mark Waid', 'Jesús Saiz', './assets/covers_img/285.jpg'),
(286, 'Doctor Extraño', 28, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Dennis Hopeless', 'Niko Henrichon', './assets/covers_img/286.jpg'),
(287, 'Doctor Extraño Cirujano supremo', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Mark Waid', 'Kev Walker', './assets/covers_img/287.jpg'),
(288, 'Doctor Extraño Cirujano supremo', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Mark Waid', 'Kev Walker', './assets/covers_img/288.jpg'),
(289, 'Doctor Extraño Cirujano supremo', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Mark Waid', 'Kev Walker', './assets/covers_img/289.jpg'),
(290, 'Doctor Extraño Cirujano supremo', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Mark Waid', 'Kev Walker', './assets/covers_img/290.jpg'),
(291, 'Doctor Extraño: El fin', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Filipe Andrade', 'Leah Williams', './assets/covers_img/291.jpg'),
(292, 'Doctor Extraño: Y los hechiceros supremos', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Robbie Thompson', 'Javier Rodríguez', './assets/covers_img/292.jpg'),
(293, 'Doctor Strange', 1, 'Steve Skroce', 'Marvel', 'Grapa', 'USA', '2023', 'Jed MacKaysky', 'Pasqual Ferry', './assets/covers_img/293.jpg'),
(294, 'Doctor Strange HC', 1, 'Mike Perkins', 'Marvel', 'Grapa', 'USA', '2021', 'Kathryn Immonen - James Robinson - Robbie Thompson - Gerry Duggan - Jason Aaron', 'Mike Deodato Jr. - Danilo S. Beyruth - Leonardo Romero - Jonathan Marks - Kev Walker - Mike Perkins - Chris Bachalo - Jorge Fornes - Kevin Nowlan', './assets/covers_img/294.jpg'),
(295, 'Doctor Strange: Fall Sunrise', 4, 'Tradd Moore', 'Marvel', 'Grapa', 'USA', '2023', 'Tradd Moore', 'Tradd Moore', './assets/covers_img/295.jpg'),
(296, 'Doctor Strange: Fall Sunrise', 3, 'Tradd Moore', 'Marvel', 'Grapa', 'USA', '2023', 'Tradd Moore', 'Tradd Moore', './assets/covers_img/296.jpg'),
(297, 'Doctor Strange: Fall Sunrise', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Tradd Moore', 'Tradd Moore', './assets/covers_img/297.jpg'),
(298, 'Doctor Strange: Fall Sunrise', 2, 'Tradd Moore', 'Marvel', 'Grapa', 'USA', '2022', 'Tradd Moore', 'Tradd Moore', './assets/covers_img/298.jpg'),
(299, 'Doctor Strange: Nexus of Nightmares', 1, 'Todd Nauck', 'Marvel', 'Grapa', 'USA', '2022', 'Ralph Macchio', 'Ibrahim Moustafa', './assets/covers_img/299.jpg'),
(300, 'Doctor Strange: Nexus of Nightmares', 1, 'Salvador Larroca', 'Marvel', 'Grapa', 'USA', '2022', 'Ralph Macchio', 'Ibrahim Moustafa', './assets/covers_img/300.jpg'),
(301, 'El abismo del infinito', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2003', 'Jim Starlin', 'Jim Starlin', './assets/covers_img/301.jpg'),
(302, 'El abismo del infinito', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2003', 'Jim Starlin', 'Jim Starlin', './assets/covers_img/302.jpg'),
(303, 'El abismo del infinito', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2003', 'Jim Starlin', 'Jim Starlin', './assets/covers_img/303.jpg'),
(304, 'El abismo del infinito', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2003', 'Jim Starlin', 'Jim Starlin', './assets/covers_img/304.jpg'),
(305, 'El abismo del infinito', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2003', 'Jim Starlin', 'Jim Starlin', './assets/covers_img/305.jpg'),
(306, 'El Don', 1, 'Isaac Sánchez González', 'Dolmen ediciones', 'Tomo', 'Spain', '2020', 'Isaac Sánchez González', 'Isaac Sánchez González', './assets/covers_img/306.jpg'),
(307, 'El velo', 1, 'Gabriel Hernandez', 'Dibbuks', 'Tomo', 'Spain', '2022', 'El Torres ', 'Gabriel Hernandez', './assets/covers_img/307.jpg'),
(308, 'Estala plateada: especial ', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Stan Lee - John Buscema', 'Stan Lee - John Buscema', './assets/covers_img/308.jpg'),
(309, 'Estela plateada negro', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Tradd Moore', './assets/covers_img/309.jpg'),
(310, 'Estela plateada negro', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Tradd Moore', './assets/covers_img/310.jpg'),
(311, 'Estela plateada negro', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Tradd Moore', './assets/covers_img/311.jpg'),
(312, 'Estela plateada negro', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Tradd Moore', './assets/covers_img/312.jpg'),
(313, 'Estela plateada negro', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Tradd Moore', './assets/covers_img/313.jpg'),
(314, 'Eternals', 7, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2021', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/314.jpg'),
(315, 'Eternals HC', 1, 'John Romita Jr', 'Marvel', 'Tomo', 'USA', '2007', 'Neil gaiman', 'John Romita Jr', './assets/covers_img/315.jpg'),
(316, 'Eternals: The Heretic', 1, 'Andrea Sorrentino', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Ryan Bodenheim', './assets/covers_img/316.jpg'),
(317, 'Eternos', 17, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2023', 'Kieron Gillen', 'Guiu Vilanova', './assets/covers_img/317.jpg'),
(318, 'Eternos', 16, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Kieron Gillen', 'Guiu Vilanova', './assets/covers_img/318.jpg'),
(319, 'Eternos', 15, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/319.jpg'),
(320, 'Eternos', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/320.jpg'),
(321, 'Eternos', 14, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/321.jpg'),
(322, 'Eternos', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/322.jpg'),
(323, 'Eternos', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/323.jpg'),
(324, 'Eternos', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/324.jpg'),
(325, 'Eternos', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/325.jpg'),
(326, 'Eternos', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/326.jpg'),
(327, 'Eternos', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/327.jpg'),
(328, 'Eternos', 10, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/328.jpg'),
(329, 'Eternos', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/329.jpg'),
(330, 'Eternos', 11, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/330.jpg'),
(331, 'Eternos', 12, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/331.jpg');
INSERT INTO `comics` (`IDcomic`, `nomComic`, `numComic`, `nomVariante`, `nomEditorial`, `Formato`, `Procedencia`, `date_published`, `nomGuionista`, `nomDibujante`, `Cover`) VALUES
(332, 'Eternos', 13, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/332.jpg'),
(333, 'Eternos', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Kieron Gillen', 'Esad Ribic', './assets/covers_img/333.jpg'),
(334, 'Ether HC', 1, 'David Rubin', 'Dark Horse', 'Tomo', 'USA', '2021', 'Matt Kindt', 'David Rubin - Gabriel Walta - Kevin Nowlan - Paul Azaceta', './assets/covers_img/334.jpg'),
(335, 'Excalibur HC', 2, 'Mahmud Asrar', 'Marvel', 'Tomo', 'USA', '2022', 'Tini Howard', 'Marcus To', './assets/covers_img/335.jpg'),
(336, 'Excalibur HC', 1, 'Mahmud A. Asrar', 'Marvel', 'Tomo', 'USA', '2022', 'Tini Howard', 'Marcus To - Wilton Santos', './assets/covers_img/336.jpg'),
(337, 'Extraordinary X-Men', 1, 'Pepe Larraz', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman - Tom Taylor', 'Iban Coello - Pepe Larraz', './assets/covers_img/337.jpg'),
(338, 'Extreme Carnage', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Phillip Kennedy Johnson', 'Manuel García', './assets/covers_img/338.jpg'),
(339, 'Extreme Carnage', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Phillip Kennedy Johnson', 'Manuel García', './assets/covers_img/339.jpg'),
(340, 'Extreme Carnage', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Phillip Kennedy Johnson', 'Manuel García', './assets/covers_img/340.jpg'),
(341, 'Extreme Carnage', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Phillip Kennedy Johnson', 'Manuel García', './assets/covers_img/341.jpg'),
(342, 'Extreme Carnage', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Phillip Kennedy Johnson', 'Manuel García', './assets/covers_img/342.jpg'),
(343, 'Fantastic Four', 5, 'Chris Bachalo', 'Marvel', 'Grapa', 'USA', '2023', 'Ryan North ', 'Ivan Fiorelli', './assets/covers_img/343.jpg'),
(344, 'Fantastic Four', 3, 'Alex Ross', 'Marvel', 'Grapa', 'USA', '2023', 'Ryan North', 'Iban Coello', './assets/covers_img/344.jpg'),
(345, 'Fantastic Four', 3, 'Alex Ross', 'Marvel', 'Grapa', 'USA', '2022', 'Ryan North', 'Iban Coello', './assets/covers_img/345.jpg'),
(346, 'Fantastic Four', 2, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Ryan North', 'Iban Coello', './assets/covers_img/346.jpg'),
(347, 'Fantastic Four', 35, 'Nick Bradshaw - Mark Brooks', 'Marvel', 'Grapa', 'USA', '2021', 'Mark Waid - Dan Slott - Jason Loo', 'John Romita - Paul Renaud - Jason Loo', './assets/covers_img/347.jpg'),
(348, 'Fantastic Four', 45, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'R.B. R. B. Silva', './assets/covers_img/348.jpg'),
(349, 'Fantastic Four', 40, 'Pacheco', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'Rachael Stott', './assets/covers_img/349.jpg'),
(350, 'Fantastic Four', 45, 'Daute', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/350.jpg'),
(351, 'Fantastic Four', 1, 'Iban Coello', 'Marvel', 'Grapa', 'USA', '2022', 'Ryan North', 'Iban Coello', './assets/covers_img/351.jpg'),
(352, 'Fantastic Four Anniversary Tribute', 1, 'Steve Mcniven', 'Marvel', 'Grapa', 'USA', '2021', 'Stan Inhyuk Lee - Jack Kirby', 'Jack Kirby', './assets/covers_img/352.jpg'),
(353, 'Fantastic Four Reckoning War Alpha', 1, 'Carlos Pacheco', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'Carlos Magno - Carlos Pacheco', './assets/covers_img/353.jpg'),
(354, 'Free Comic Book Day: Batman', 1, 'Mico Suayan - Tomeu Morey', 'DC', 'Grapa', 'USA', '2022', 'John Ridley', 'Mico Suayan - Tomeu Morey - Jorge Jimenez', './assets/covers_img/354.jpg'),
(355, 'Free Comic Book Day: Best of 2000 AD Issue Zero', 1, 'Ian McQue', '7000 AD', 'Grapa', 'USA', '2022', 'Al Ewing - John Wagner - Pat Mills - Chris Burnham', 'Vv Glass - Mick McMahon - Kevin O\'Neill - Chris Burnham', './assets/covers_img/355.jpg'),
(356, 'Free Comic Book Day: Bloodborne', 1, 'Cullen Bunn', 'Titan Comics', 'Grapa', 'USA', '2022', 'Cullen Bunn', 'Piotr Kowalski - Cullen Bunn', './assets/covers_img/356.jpg'),
(357, 'Free Comic Book Day: Buffy the Vampire Slayer', 1, 'Christa Miesner', 'Boom Studios', 'Grapa', 'USA', '2022', 'Jeremy Lambert - Jordie Bellaire', 'Dan Mora - Marianna Ignazzi', './assets/covers_img/357.jpg'),
(358, 'Free Comic Book Day: Clementine', 1, 'Tillie Walden', 'Titan Comics', 'Grapa', 'USA', '2022', 'Tillie Walden - Irma Kniivila - Tri Vuong - Mairghread Scott', 'Irma Kniivila - Tri Vuong - Pablo Tunica', './assets/covers_img/358.jpg'),
(359, 'Free Comic Book Day: Doctor Who', 1, 'Roberta Ingranata', 'Titan Comics', 'Grapa', 'USA', '2022', 'Jody Houser', 'Roberta Ingranata', './assets/covers_img/359.jpg'),
(360, 'Free Comic Book Day: Guardian of Fukushima', 1, 'Ewen Blain', 'TokyoPop', 'Grapa', 'USA', '2022', 'Fabien Grolleau', 'Ewen Blain', './assets/covers_img/360.jpg'),
(361, 'Free Comic Book Day: Hollow', 1, 'Naomi Franquiz', 'Boom! Box', 'Grapa', 'USA', '2022', 'Shannon Watters - Branden Boyer-White', 'Berenice Nelle', './assets/covers_img/361.jpg'),
(362, 'Free Comic Book Day: Judgment Day', 1, 'Valerio Schiti', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen - Gerry Duggan - Danny Lore', 'Dustin Weaver - Matteo Lolli - Karen Darboe', './assets/covers_img/362.jpg'),
(363, 'Free Comic Book Day: League of SuperPets', 1, 'Bobby Timony', 'Marvel', 'Grapa', 'USA', '2022', 'Heath Corson', 'Bobby Timony', './assets/covers_img/363.jpg'),
(364, 'Free Comic Book Day: Marvel Voices', 1, 'Carlos E. Gomez - Jesus Aburtov', 'Marvel', 'Grapa', 'USA', '2022', 'Nadia Shammas', 'Luciano Vecchio', './assets/covers_img/364.jpg'),
(365, 'Free Comic Book Day: Spider-Man and Venom', 1, 'John Romita Jr', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing - Ram V. - Zeb Wells', 'Bryan Hitch- John Romita Jr', './assets/covers_img/365.jpg'),
(366, 'Free Comic Book Day: Spider-Man and Venom', 1, 'Alejandro Sanchez', 'Marvel', 'Grapa', 'USA', '2022', 'Zeb Wells - Al Ewing - Chip Zdarsky - Ram. V', 'Patrick Gleason - Bryan Hitch - Greg Smallwood', './assets/covers_img/366.jpg'),
(367, 'Free Comic Book Day: Star Wars the High Republic', 1, 'Nick Brokenshire', 'IDW', 'Grapa', 'USA', '2021', 'Daniel Jose Older', 'Harvey Tolibao - Nick Brokenshire', './assets/covers_img/367.jpg'),
(368, 'Free Comic Book Day: Stranger Things', 1, 'Diego Galindo', 'Dark Horse', 'Grapa', 'USA', '2022', 'Michael Moreci - Peter Hogan', 'Pius Bak - Steve Parkhouse', './assets/covers_img/368.jpg'),
(369, 'Free Comic Book Day: Welive The Last Days', 1, 'Inaki Miranda', 'Titan Comics', 'Grapa', 'USA', '2022', 'Inaki Miranda - Roy Miranda', 'Inaki Miranda', './assets/covers_img/369.jpg'),
(370, 'Free Comic Book Day: X-Men', 1, 'Pepe Larraz', 'Marvel', 'Grapa', 'USA', '2022', 'Tom Taylor - Jonathan Hickman', 'Pepe Larraz - Iban Coello', './assets/covers_img/370.jpg'),
(371, 'Free Comic Book Day: X-Men', 1, 'Humberto Ramos', 'Marvel', 'Grapa', 'USA', '2015', 'Jeff Lemire', 'Humberto Ramos', './assets/covers_img/371.jpg'),
(372, 'Gambit', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Chris Claremont', 'Sid Kotian', './assets/covers_img/372.jpg'),
(373, 'Gambit', 5, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2022', 'Chris Claremont', 'Sid Kotian', './assets/covers_img/373.jpg'),
(374, 'Gambit ', 2, 'Russell Dauterman - Hellfire gala', 'Marvel', 'Grapa', 'USA', '2022', 'Chris Claremont', 'Sid Kotian', './assets/covers_img/374.jpg'),
(375, 'Gambit ', 3, 'Whilce Portacio', 'Marvel', 'Grapa', 'USA', '2022', 'Chris Claremont', 'Sid Kotian', './assets/covers_img/375.jpg'),
(376, 'Geiger TP VL 01', 1, 'Gary Frank - Brad Anderson', 'Image Comics', 'Tomo', 'Spain', '2022', 'Geoff Johns', 'Gary Frank - Brad Anderson', './assets/covers_img/376.jpg'),
(377, 'Genis-Vell: Captain Marvel', 2, 'Mike Mckone', 'Marvel', 'Grapa', 'USA', '2022', 'Peter David', 'Juanan Ramirez', './assets/covers_img/377.jpg'),
(378, 'Genis-Vell: Captain Marvel', 3, 'Mike Mckone', 'Marvel', 'Grapa', 'USA', '2022', 'Peter David', 'Juanan Ramirez', './assets/covers_img/378.jpg'),
(379, 'Genis-Vell: Captain Marvel', 4, 'Mike Mckone', 'Marvel', 'Grapa', 'USA', '2022', 'Peter David', 'Juanan Ramirez', './assets/covers_img/379.jpg'),
(380, 'Genis-Vell: Captain Marvel', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Peter David', 'Juanan Ramirez', './assets/covers_img/380.jpg'),
(381, 'Genis-Vell: Captain Marvel', 1, 'Dan Jurgens', 'Marvel', 'Grapa', 'USA', '2022', 'Peter David', 'Juanan Ramirez', './assets/covers_img/381.jpg'),
(382, 'Genis-Vell: Captain Marvel', 1, 'Mike Mckone', 'Marvel', 'Grapa', 'USA', '2022', 'Peter David', 'Juanan Ramirez', './assets/covers_img/382.jpg'),
(383, 'Genis-Vell: Captain Marvel', 5, 'Mike McKone', 'Marvel', 'Grapa', 'USA', '2022', 'Peter David', 'Juanan Ramirez', './assets/covers_img/383.jpg'),
(384, 'Ghost Rider', 12, 'Bjorn Barends', 'Marvel', 'Grapa', 'USA', '2023', 'Ben Percy', 'Cory Smith', './assets/covers_img/384.jpg'),
(385, 'Ghost Rider', 11, 'Luke Ross', 'Marvel', 'Grapa', 'USA', '2023', 'Ben Percy', 'Smith - Cory', './assets/covers_img/385.jpg'),
(386, 'Ghost Rider', 9, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Ben Percy', 'Cory Smith', './assets/covers_img/386.jpg'),
(387, 'Ghost Rider', 5, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Benjamin Percy', 'Cory Smith', './assets/covers_img/387.jpg'),
(388, 'Ghost Rider', 6, 'Kael Ngu', 'Marvel', 'Grapa', 'USA', '2022', 'Benjamin Percy', 'Brent Peeples', './assets/covers_img/388.jpg'),
(389, 'Ghost Rider', 7, 'Maria Wolf', 'Marvel', 'Grapa', 'USA', '2022', 'Benjamin Percy', 'Cory Smith', './assets/covers_img/389.jpg'),
(390, 'Ghost Rider', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Benjamin Percy', 'Joe Bennett - Cory Smith', './assets/covers_img/390.jpg'),
(391, 'Ghost Rider', 1, 'Kael Ngu', 'Marvel', 'Grapa', 'USA', '2022', 'Benjamin Percy', 'Joe Bennett - Cory Smith', './assets/covers_img/391.jpg'),
(392, 'Ghost Rider', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Ed Brisson', 'Aaron Kuder', './assets/covers_img/392.jpg'),
(393, 'Ghost Rider', 2, 'Kael Ngu', 'Marvel', 'Grapa', 'USA', '2022', 'Benjamin Percy', 'Cory Smith - Brent Peeples', './assets/covers_img/393.jpg'),
(394, 'Ghost Rider', 3, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Benjamin Percy', 'Cory Smith', './assets/covers_img/394.jpg'),
(395, 'Ghost Rider', 4, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Benjamin Percy', 'Cory Smith', './assets/covers_img/395.jpg'),
(396, 'Ghost Rider', 8, 'Kael Ngu', 'Marvel', 'Grapa', 'USA', '2022', 'Ben Percy', 'Cory Smith', './assets/covers_img/396.jpg'),
(397, 'Ghost Rider: Vengeance Forever', 1, 'Larraz', 'Marvel', 'Grapa', 'USA', '2022', 'Benjamin Percy', 'Björn Barends - Juan Jose Ryp', './assets/covers_img/397.jpg'),
(398, 'Giant size: Gwen Stacy', 1, 'Vatine Olivier', 'Marvel', 'Grapa', 'USA', '2022', 'Christos Gage', 'Todd Nauck', './assets/covers_img/398.jpg'),
(399, 'Giant-Size X-Men: Jean Grey and Emma Frost', 1, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Russell Dauterman', './assets/covers_img/399.jpg'),
(400, 'Gideon Falls: El fin', 6, 'Variante de Panini Comics', 'Astiberri', 'Tomo', 'Spain', '2021', 'Jeff Lemire', 'Andrea Sorrentino', './assets/covers_img/400.jpg'),
(401, 'Gideon Falls: El granero negro', 1, 'Variante de Panini Comics', 'Astiberri', 'Tomo', 'Spain', '2019', 'Jeff Lemire', 'Andrea Sorrentino', './assets/covers_img/401.jpg'),
(402, 'Gideon Falls: El pentaculo', 4, 'Variante de Panini Comics', 'Astiberri', 'Tomo', 'Spain', '2020', 'Jeff Lemire', 'Andrea Sorrentino', './assets/covers_img/402.jpg'),
(403, 'Gideon Falls: Mundos Perversos', 5, 'Variante de Panini Comics', 'Astiberri', 'Tomo', 'Spain', '2021', 'Jeff Lemire', 'Andrea Sorrentino', './assets/covers_img/403.jpg'),
(404, 'Gideon Falls: Pecados Originales', 2, 'Variante de Panini Comics', 'Astiberri', 'Tomo', 'Spain', '2019', 'Jeff Lemire', 'Andrea Sorrentino', './assets/covers_img/404.jpg'),
(405, 'Gideon Falls: Via Crucis', 3, 'Variante de Panini Comics', 'Astiberri', 'Tomo', 'Spain', '2019', 'Jeff Lemire', 'Andrea Sorrentino', './assets/covers_img/405.jpg'),
(406, 'Gospel', 1, 'Ver', 'Image Comics', 'Grapa', 'USA', '2022', 'Will Morris', 'Will Morris', './assets/covers_img/406.jpg'),
(407, 'Grafitys Wall HC', 2, 'Anand Radhakrishnan', 'Dark Horse', 'Tomo', 'USA', '2020', 'Ram. V.', 'Anand Radhakrishnan', './assets/covers_img/407.jpg'),
(408, 'Guardianes de la Galaxia', 17, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Al Ewing', 'Juann Cabal', './assets/covers_img/408.jpg'),
(409, 'Guardianes de la Galaxia', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Al Ewing', 'Juann Cabal', './assets/covers_img/409.jpg'),
(410, 'Guardianes de la Galaxia', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Al Ewing', 'Juann Cabal', './assets/covers_img/410.jpg'),
(411, 'Guardianes de la Galaxia', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Al Ewing', 'Juann Cabal', './assets/covers_img/411.jpg'),
(412, 'Guardianes de la Galaxia', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Al Ewing', 'Juann Cabal', './assets/covers_img/412.jpg'),
(413, 'Guardianes de la Galaxia', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Al Ewing', 'Juann Cabal', './assets/covers_img/413.jpg'),
(414, 'Guardianes de la Galaxia', 12, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Al Ewing', 'Juann Cabal', './assets/covers_img/414.jpg'),
(415, 'Guardianes de la Galaxia', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Al Ewing', 'Juann Cabal', './assets/covers_img/415.jpg'),
(416, 'Guardianes de la Galaxia', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Al Ewing', 'Juann Cabal', './assets/covers_img/416.jpg'),
(417, 'Guardianes de la Galaxia', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Al Ewing', 'Juann Cabal', './assets/covers_img/417.jpg'),
(418, 'Guardianes de la Galaxia', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Al Ewing', 'Juann Cabal', './assets/covers_img/418.jpg'),
(419, 'Guardianes de la Galaxia', 13, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Al Ewing', 'Juann Cabal', './assets/covers_img/419.jpg'),
(420, 'Guardianes de la Galaxia', 14, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Al Ewing', 'Juann Cabal', './assets/covers_img/420.jpg'),
(421, 'Guardianes de la Galaxia', 15, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Al Ewing', 'Juann Cabal', './assets/covers_img/421.jpg'),
(422, 'Guardianes de la Galaxia', 16, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Al Ewing', 'Juann Cabal', './assets/covers_img/422.jpg'),
(423, 'Guardianes de la Galaxia', 11, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Al Ewing', 'Juann Cabal', './assets/covers_img/423.jpg'),
(424, 'Guardianes de la Galaxia', 10, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Al Ewing', 'Juann Cabal', './assets/covers_img/424.jpg'),
(425, 'Guardianes de la Galaxia', 18, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Al Ewing', 'Juann Cabal', './assets/covers_img/425.jpg'),
(426, 'Guardianes de la Galaxia', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Geoff Shaw', './assets/covers_img/426.jpg'),
(427, 'Guardianes de la Galaxia', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Geoff Shaw', './assets/covers_img/427.jpg'),
(428, 'Guardianes de la Galaxia', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Geoff Shaw', './assets/covers_img/428.jpg'),
(429, 'Guardianes de la Galaxia', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Geoff Shaw', './assets/covers_img/429.jpg'),
(430, 'Guardianes de la Galaxia', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Geoff Shaw', './assets/covers_img/430.jpg'),
(431, 'Guardianes de la Galaxia', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Geoff Shaw', './assets/covers_img/431.jpg'),
(432, 'Guardianes de la Galaxia', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Geoff Shaw', './assets/covers_img/432.jpg'),
(433, 'Guardianes de la Galaxia', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Geoff Shaw', './assets/covers_img/433.jpg'),
(434, 'Guardianes de la Galaxia', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Geoff Shaw', './assets/covers_img/434.jpg'),
(435, 'Guardianes de la Galaxia', 10, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Geoff Shaw', './assets/covers_img/435.jpg'),
(436, 'Guardianes de la Galaxia', 11, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Geoff Shaw', './assets/covers_img/436.jpg'),
(437, 'Guardianes de la Galaxia', 12, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Donny Cates', 'Geoff Shaw', './assets/covers_img/437.jpg'),
(438, 'Guerra de los reinos', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'Russell Dauterman', './assets/covers_img/438.jpg'),
(439, 'Guerra de los reinos', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'Russell Dauterman', './assets/covers_img/439.jpg'),
(440, 'Guerra de los reinos', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'Russell Dauterman', './assets/covers_img/440.jpg'),
(441, 'Guerra de los reinos', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'Russell Dauterman', './assets/covers_img/441.jpg'),
(442, 'Guerra de los Reinos: Omega', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'Russell Dauterman', './assets/covers_img/442.jpg'),
(443, 'Hawkeye Kate Bishop', 2, 'Jahnoy Lindsay', 'Marvel', 'Grapa', 'USA', '2021', 'Marieke Nijkamp', 'Enid Balam', './assets/covers_img/443.jpg'),
(444, 'Hawkeye Kate Bishop', 3, 'Jahnoy Lindsay', 'Marvel', 'Grapa', 'USA', '2022', 'Marieke Nijkamp', 'Enid Balam', './assets/covers_img/444.jpg'),
(445, 'Hawkeye Kate Bishop', 4, 'Jahnoy Lindsay', 'Marvel', 'Grapa', 'USA', '2022', 'Marieke Nijkamp', 'Enid Balam', './assets/covers_img/445.jpg'),
(446, 'Hawkeye Kate Bishop', 5, 'Yagawa', 'Marvel', 'Grapa', 'USA', '2022', 'Marieke Nijkamp', 'Enid Balam', './assets/covers_img/446.jpg'),
(447, 'Hawkeye Kate Bishop', 1, 'Jahnoy Lindsay', 'Marvel', 'Grapa', 'USA', '2021', 'Marieke Nijkamp', 'Enid Balam', './assets/covers_img/447.jpg'),
(448, 'Hellions', 1, 'Stephen Segovia', 'Marvel', 'Tomo', 'USA', '2022', 'Zeb Well', 'Stephen Segovia', './assets/covers_img/448.jpg'),
(449, 'Héroes Marvel - Alerta: El futuro comieza aquí', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Chip Zdarsky - Jonathan Hickman - Dan Slott', 'Andrea Sorrentino - Jim Cheung - Carmen Carnero - Javier Garrón - Carlos Pacheco - Humberto Ramos - Jason Aaron - Al Ewing - Donny Cates - Joe Bennett', './assets/covers_img/449.jpg'),
(450, 'Heroes marvel - Contagio', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Ed Brisson', 'Mack Chater - Damian Couceiro', './assets/covers_img/450.jpg'),
(451, 'Héroes Marvel - El asombroso Spider-Man: Matanza maxima', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'David Michelinie - J. M. DeMatteis - Al Milgrom - Tom DeFalco - Eric Fein - Terry Kavanagh - Steven Grant - Jack C. Harris - Mike Lackley', 'Jerry Bingham - Mark Mark Bagley - Aaron Lopresti - Todd Smith - Patrick Oliffe - Dan Panosian - Jeff Johnson - Tom Lyle - Scott Kolins - Larry Alexan', './assets/covers_img/451.jpg'),
(452, 'Héroes Marvel - El guantelete del infinito', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2018', 'Jim Starlin', 'George Pérez - Ron Lim', './assets/covers_img/452.jpg'),
(453, 'Héroes Marvel - El guantelete del infinito: El Día después', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2018', 'Ron Marz', 'Ron Lim', './assets/covers_img/453.jpg'),
(454, 'Héroes Marvel - El guantelete del infinito: Estela plateada', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2018', 'Ron Marz', 'Ron Lim', './assets/covers_img/454.jpg'),
(455, 'Héroes Marvel - El guantelete del infinito: Héroes Marvel', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2018', 'Jim Starlin', 'Ron Lim', './assets/covers_img/455.jpg'),
(456, 'Héroes Marvel - El guantelete del infinito: Prologo', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2018', 'Jim Starlin - Ron Marz', 'Ron Lim', './assets/covers_img/456.jpg'),
(457, 'Héroes Marvel - El renacimiento de thanos', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2018', 'Jim Starlin', 'Ron Lim', './assets/covers_img/457.jpg'),
(458, 'Héroes Marvel - Guerra de los reinos: vengadores', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'DennisHopeless Hallum - Bryan Edward Hill - Tom Taylor', 'Jorge Molina - Leinil Francis Yu - Kim Jacinto - ', './assets/covers_img/458.jpg'),
(459, 'Héroes Marvel - Guerra de los reinos: Viaje al misterio', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Los McElroy', 'Andre Ron Lima Araujo', './assets/covers_img/459.jpg'),
(460, 'Héroes Marvel - La orden Negra: Los Maestros de la Guerra de Thanos', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Derek Landy', 'Carlos Magno - Scott Hanna - Dono Sánchez-Amara - Clayton Cowles', './assets/covers_img/460.jpg'),
(461, 'Heroes Marvel - Loki: El dios que cayó a la guerra', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Daniel Kibblesmith', 'Oscar Bazaldua', './assets/covers_img/461.jpg'),
(462, 'Héroes Marvel - Los eternos: El día de los dioses', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Jack Kirby', 'Jack Kirby', './assets/covers_img/462.jpg'),
(463, 'Héroes Marvel - Marvel zombis Resurection', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Phillip Kennedy', 'Leonard Kirk', './assets/covers_img/463.jpg'),
(464, 'Héroes Marvel - Matanza absoluta: Protectores letales', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Frank Tieri - lay McLeod Chapman', 'Flaviano Armentaro - Brian Level', './assets/covers_img/464.jpg'),
(465, 'Héroes Marvel - Rey de Negro: Los Héroes', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Ed Brisson - Geoffrey Thorne - Simon Spurrier', 'Germán Peralta - Jesús Saiz - Juan Frigeri - Luciano Vecchio', './assets/covers_img/465.jpg'),
(466, 'Héroes Marvel - Rey de Negro: Planeta de Simbiontes', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Simon Spurrier - Geoffrey Thorne - Tini Howard - Ed Brisson - Seanan McGuire - Clay McLeod Chapman - Frank Tieri - Marc Bernardin - Rodney Barnes - St', 'Jesús Sáiz - Germán Peralta - Luciano Vecchio - Juan Frigeri - Flaviano - Ig Guara - Guiu Vilanova - Danilo S. Beyruth - Kyle Hotz - Jan Bazaldua - Ge', './assets/covers_img/466.jpg'),
(467, 'Heroes Reborn', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Ed McGuinness', './assets/covers_img/467.jpg'),
(468, 'Heroes Reborn', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Federico Vicentin', './assets/covers_img/468.jpg'),
(469, 'Heroes Reborn', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Ed McGuinness', './assets/covers_img/469.jpg'),
(470, 'Heroes Reborn', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Ed McGuinness', './assets/covers_img/470.jpg'),
(471, 'Heroes Reborn', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Ed McGuinness', './assets/covers_img/471.jpg'),
(472, 'Historia del universo Marvel', 45, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Mark Waid', 'Javier Rodríguez', './assets/covers_img/472.jpg'),
(473, 'Historia del universo Marvel', 49, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Mark Waid', 'Javier Rodríguez', './assets/covers_img/473.jpg'),
(474, 'Historia del universo Marvel', 46, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Mark Waid', 'Javier Rodríguez', './assets/covers_img/474.jpg'),
(475, 'Historia del universo Marvel', 47, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Mark Waid', 'Javier Rodríguez', './assets/covers_img/475.jpg'),
(476, 'Historia del universo Marvel', 48, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Mark Waid', 'Javier Rodríguez', './assets/covers_img/476.jpg'),
(477, 'Historia del universo Marvel', 50, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Mark Waid', 'Javier Rodríguez', './assets/covers_img/477.jpg'),
(478, 'History Of The Marvel Universe', 6, 'Javier Rodriguez', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Stefano Caselli', './assets/covers_img/478.jpg'),
(479, 'Hulk', 13, 'Steve McNiven', 'Marvel', 'Grapa', 'USA', '2023', 'Ryan Ottley', 'Ryan Ottley', './assets/covers_img/479.jpg'),
(480, 'Hulk', 12, 'Salvador Larroca', 'Marvel', 'Grapa', 'USA', '2023', 'Donny Cates', 'Ryan Ottley', './assets/covers_img/480.jpg'),
(481, 'Hulk', 11, 'Ryan Ottley', 'Marvel', 'Grapa', 'USA', '2022', 'Donny Cates', 'Ryan Ottley', './assets/covers_img/481.jpg'),
(482, 'Hulk', 1, 'Ryan Ottley', 'Marvel', 'Grapa', 'USA', '2021', 'Donny Cates', 'Ryan Ottley', './assets/covers_img/482.jpg'),
(483, 'Hulk', 8, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2022', 'Donny Cates', 'Martin Coccolo', './assets/covers_img/483.jpg'),
(484, 'Hulk', 8, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2022', 'Donny Cates', 'Martin Coccolo', './assets/covers_img/484.jpg'),
(485, 'Hulk', 9, 'Ryan Ottley', 'Marvel', 'Grapa', 'USA', '2022', 'Donny Cates', 'Ryan Ottley', './assets/covers_img/485.jpg'),
(486, 'Hulk', 3, 'Ryan Ottley', 'Marvel', 'Grapa', 'USA', '2022', 'Donny Cates', 'Ryan Ottley', './assets/covers_img/486.jpg'),
(487, 'Hulk', 4, 'Bradshaw', 'Marvel', 'Grapa', 'USA', '2022', 'Donny Cates', 'Ryan Ottley', './assets/covers_img/487.jpg'),
(488, 'Hulk', 5, 'Fornes', 'Marvel', 'Grapa', 'USA', '2022', 'Donny Cates', 'Ryan Ottley', './assets/covers_img/488.jpg'),
(489, 'Hulk', 2, 'Devils Reign', 'Marvel', 'Grapa', 'USA', '2021', 'Donny Cates', 'Ryan Ottley', './assets/covers_img/489.jpg'),
(490, 'Hulk', 3, 'Cheung', 'Marvel', 'Grapa', 'USA', '2022', 'Donny Cates', 'Ryan Ottley', './assets/covers_img/490.jpg'),
(491, 'Hulk', 6, 'Ryan Ottley', 'Marvel', 'Grapa', 'USA', '2022', 'Donny Cates', 'Ryan Ottley', './assets/covers_img/491.jpg'),
(492, 'Hulk', 7, 'Zullo', 'Marvel', 'Grapa', 'USA', '2022', 'Donny Cates', 'Martin Coccolo', './assets/covers_img/492.jpg'),
(493, 'Hulk', 10, 'Ryan Ottley', 'Marvel', 'Grapa', 'USA', '2022', 'Donny Cates', 'Ryan Ottley', './assets/covers_img/493.jpg'),
(494, 'Hulk vs Thor: Banner of war alpha', 1, 'Eeden', 'Marvel', 'Grapa', 'USA', '2022', 'Donny Cates', 'Martin Coccolo', './assets/covers_img/494.jpg'),
(495, 'Hulk: Gran Design - Monster', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Jim Rugg -  Mike O\'sullivan', 'Jim Rugg', './assets/covers_img/495.jpg'),
(496, 'Hulkling and Wiccan', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Josh Trujillo - Jodi Nishijima', 'Jasmine Alvarez', './assets/covers_img/496.jpg'),
(497, 'Immoral X-Men', 1, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2023', 'Kieron Gillen', 'Paco Medina', './assets/covers_img/497.jpg'),
(498, 'Imperio', 0, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Valerio Schiti - Al Ewing', './assets/covers_img/498.jpg'),
(499, 'Imperio', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Valerio Schiti - Al Ewing', './assets/covers_img/499.jpg'),
(500, 'Imperio', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Valerio Schiti - Al Ewing', './assets/covers_img/500.jpg'),
(501, 'Imperio', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Valerio Schiti - Al Ewing', './assets/covers_img/501.jpg'),
(502, 'Imperio', 0, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Valerio Schiti - Al Ewing', './assets/covers_img/502.jpg'),
(503, 'Imperio', 0, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Valerio Schiti - Al Ewing', './assets/covers_img/503.jpg'),
(504, 'Imperio', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Valerio Schiti - Al Ewing', './assets/covers_img/504.jpg'),
(505, 'Imperio (El dia despues)', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Al Ewing', 'Valerio Schiti', './assets/covers_img/505.jpg'),
(506, 'Imperio(La caida)', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Sean Izaakse', './assets/covers_img/506.jpg'),
(507, 'Inferno', 2, 'Jerome Opena', 'Marvel', 'Grapa', 'USA', '2021', 'Jonathan Hickman', 'Stefano Caselli', './assets/covers_img/507.jpg'),
(508, 'Inferno', 4, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2021', 'Jonathan Hickman', 'Valerio Schiti - Stefano Caselli', './assets/covers_img/508.jpg'),
(509, 'Inferno', 4, 'Jerome Opena', 'Marvel', 'Grapa', 'USA', '2021', 'Jonathan Hickman', 'Valerio Schiti - Stefano Caselli', './assets/covers_img/509.jpg'),
(510, 'Inferno', 1, 'Jerome Opena', 'Marvel', 'Grapa', 'USA', '2021', 'Jonathan Hickman', 'Valerio Schiti', './assets/covers_img/510.jpg'),
(511, 'Inferno', 3, 'Jerome Opena', 'Marvel', 'Grapa', 'USA', '2021', 'Jonathan Hickman', 'Stefano Caselli - Valerio Schiti - R.B. R. B. Silva', './assets/covers_img/511.jpg'),
(512, 'Infinity Wars: Complete Edition', 1, 'Mike Deodato', 'Marvel', 'Tomo', 'USA', '2019', 'Gerry Duggan', 'Mike Deodato Jr - Mike Allred ', './assets/covers_img/512.jpg'),
(513, 'Inmortal Hulk', 20, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Joe Bennett', 'Al Ewing', './assets/covers_img/513.jpg'),
(514, 'Inmortal Hulk', 21, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Joe Bennett', 'Al Ewing', './assets/covers_img/514.jpg'),
(515, 'Inmortal Hulk', 22, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Joe Bennett', 'Al Ewing', './assets/covers_img/515.jpg'),
(516, 'Inmortal Hulk', 23, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Joe Bennett', 'Al Ewing', './assets/covers_img/516.jpg'),
(517, 'Inmortal Hulk', 24, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Joe Bennett', 'Al Ewing', './assets/covers_img/517.jpg'),
(518, 'Inmortal Hulk', 25, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Joe Bennett', 'Al Ewing', './assets/covers_img/518.jpg'),
(519, 'Inmortal Hulk', 25, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Joe Bennett', 'Al Ewing', './assets/covers_img/519.jpg'),
(520, 'Inmortal Hulk', 26, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Joe Bennett', 'Al Ewing', './assets/covers_img/520.jpg'),
(521, 'Inmortal Hulk', 27, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Joe Bennett', 'Al Ewing', './assets/covers_img/521.jpg'),
(522, 'Inmortal Hulk', 28, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Joe Bennett', 'Al Ewing', './assets/covers_img/522.jpg'),
(523, 'Inmortal Hulk', 39, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Joe Bennett', 'Al Ewing', './assets/covers_img/523.jpg'),
(524, 'Inmortal Hulk', 34, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Joe Bennett', 'Al Ewing', './assets/covers_img/524.jpg'),
(525, 'Inmortal Hulk', 38, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Joe Bennett', 'Al Ewing', './assets/covers_img/525.jpg'),
(526, 'Inmortal Hulk', 33, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Joe Bennett', 'Al Ewing', './assets/covers_img/526.jpg'),
(527, 'Inmortal Hulk', 37, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Joe Bennett', 'Al Ewing', './assets/covers_img/527.jpg'),
(528, 'Inmortal Hulk', 32, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Joe Bennett', 'Al Ewing', './assets/covers_img/528.jpg'),
(529, 'Inmortal Hulk', 36, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Joe Bennett', 'Al Ewing', './assets/covers_img/529.jpg'),
(530, 'Inmortal Hulk', 31, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Joe Bennett', 'Al Ewing', './assets/covers_img/530.jpg'),
(531, 'Inmortal Hulk', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Joe Bennett', 'Al Ewing', './assets/covers_img/531.jpg'),
(532, 'Inmortal Hulk', 30, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Joe Bennett', 'Al Ewing', './assets/covers_img/532.jpg'),
(533, 'Inmortal Hulk', 35, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Joe Bennett', 'Al Ewing', './assets/covers_img/533.jpg'),
(534, 'Inmortal Hulk', 29, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Joe Bennett', 'Al Ewing', './assets/covers_img/534.jpg'),
(535, 'Inmortal Hulk', 50, 'Joe Bennett', 'Marvel', 'Grapa', 'USA', '2021', 'Joe Bennett', 'Al Ewing', './assets/covers_img/535.jpg'),
(536, 'Inmortal Hulk', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Joe Bennett', 'Al Ewing', './assets/covers_img/536.jpg'),
(537, 'Inmortal Hulk', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Joe Bennett', 'Al Ewing', './assets/covers_img/537.jpg'),
(538, 'Inmortal Hulk', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Joe Bennett', 'Al Ewing', './assets/covers_img/538.jpg'),
(539, 'Inmortal Hulk', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Joe Bennett', 'Al Ewing', './assets/covers_img/539.jpg'),
(540, 'Inmortal Hulk', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Joe Bennett', 'Al Ewing', './assets/covers_img/540.jpg'),
(541, 'Inmortal Hulk', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Joe Bennett', 'Al Ewing', './assets/covers_img/541.jpg'),
(542, 'Inmortal Hulk', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Joe Bennett', 'Al Ewing', './assets/covers_img/542.jpg'),
(543, 'Inmortal Hulk', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Joe Bennett', 'Al Ewing', './assets/covers_img/543.jpg'),
(544, 'Inmortal Hulk', 10, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Joe Bennett', 'Al Ewing', './assets/covers_img/544.jpg'),
(545, 'Inmortal Hulk', 11, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Joe Bennett', 'Al Ewing', './assets/covers_img/545.jpg'),
(546, 'Inmortal Hulk', 12, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Joe Bennett', 'Al Ewing', './assets/covers_img/546.jpg'),
(547, 'Inmortal Hulk', 13, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Joe Bennett', 'Al Ewing', './assets/covers_img/547.jpg'),
(548, 'Inmortal Hulk', 14, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Joe Bennett', 'Al Ewing', './assets/covers_img/548.jpg'),
(549, 'Inmortal Hulk', 15, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Joe Bennett', 'Al Ewing', './assets/covers_img/549.jpg'),
(550, 'Inmortal Hulk', 16, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Joe Bennett', 'Al Ewing', './assets/covers_img/550.jpg'),
(551, 'Inmortal Hulk', 17, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Joe Bennett', 'Al Ewing', './assets/covers_img/551.jpg'),
(552, 'Inmortal Hulk', 18, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Joe Bennett', 'Al Ewing', './assets/covers_img/552.jpg'),
(553, 'Inmortal Hulk', 19, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Joe Bennett', 'Al Ewing', './assets/covers_img/553.jpg'),
(554, 'Inmortal X-Men', 9, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Lucas Werneck', './assets/covers_img/554.jpg'),
(555, 'Inmortal X-Men', 4, 'Mark Brooks', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Michele Bandini', './assets/covers_img/555.jpg'),
(556, 'Inmortal X-Men', 10, 'Phil Noto', 'Marvel', 'Grapa', 'USA', '2023', 'Kieron Gillen', 'Lucas Werneck', './assets/covers_img/556.jpg'),
(557, 'Inmortal X-Men', 5, 'Adams', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Michele Bandini', './assets/covers_img/557.jpg'),
(558, 'Inmortal X-Men', 6, 'A.X.E', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Lucas Werneck', './assets/covers_img/558.jpg'),
(559, 'Inmortal X-Men', 7, 'Phil Noto', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Lucas Werneck', './assets/covers_img/559.jpg'),
(560, 'Inmortal X-Men', 1, 'Mark Brooks', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Lucas Werneck', './assets/covers_img/560.jpg'),
(561, 'Inmortal X-Men', 2, 'Mark Brooks', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Lucas Werneck', './assets/covers_img/561.jpg'),
(562, 'Inmortal X-Men', 3, 'Mark Brooks', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Lucas Werneck', './assets/covers_img/562.jpg'),
(563, 'Inmortal X-Men', 8, 'Mark Brooks', 'Marvel', 'Grapa', 'USA', '2022', 'Kieron Gillen', 'Michele Bandini', './assets/covers_img/563.jpg'),
(564, 'Inmortal X-Men [sin]', 2, 'Leinil Yu', 'Marvel', 'Grapa', 'USA', '2023', 'Kieron Gillen', 'Andrea Di Vito', './assets/covers_img/564.jpg'),
(565, 'Instantánea Marvels: El Hombre Submarino', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Kurt Busiek - Alan Brennert', 'Jerry Ordway', './assets/covers_img/565.jpg'),
(566, 'Invincible Iron Man', 3, 'Bob Layton', 'Marvel', 'Grapa', 'USA', '2023', 'Gerry Duggan', 'Juan Frigeri', './assets/covers_img/566.jpg'),
(567, 'Invincible Iron Man', 2, 'Kael Ngu', 'Marvel', 'Grapa', 'USA', '2023', 'Gerry Duggan', 'Juan Frigeri', './assets/covers_img/567.jpg'),
(568, 'Invincible Iron Man', 4, 'Iban Coello', 'Marvel', 'Grapa', 'USA', '2023', 'Gerry Duggan', 'Juan Frigeri', './assets/covers_img/568.jpg'),
(569, 'Invincible Iron Man', 1, 'Kael Ngu', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'Juan Frigeri', './assets/covers_img/569.jpg'),
(570, 'Iron Man', 24, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2023', 'Christopher Cantwell', 'Ángel Unzueta', './assets/covers_img/570.jpg'),
(571, 'Iron Man', 23, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Christopher Cantwell', 'Ángel Unzueta', './assets/covers_img/571.jpg'),
(572, 'Iron Man', 21, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Christopher Cantwell', 'Ruairi Coleman', './assets/covers_img/572.jpg'),
(573, 'Iron Man', 22, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Christopher Cantwell', 'Ángel Unzueta', './assets/covers_img/573.jpg'),
(574, 'Iron Man', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Chris Cantwell', 'Cafu', './assets/covers_img/574.jpg'),
(575, 'Iron Man', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Chris Cantwell', 'Cafu', './assets/covers_img/575.jpg'),
(576, 'Iron Man', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Chris Cantwell', 'Cafu', './assets/covers_img/576.jpg'),
(577, 'Iron Man', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Chris Cantwell', 'Cafu', './assets/covers_img/577.jpg'),
(578, 'Iron Man', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Chris Cantwell', 'Cafu', './assets/covers_img/578.jpg'),
(579, 'Iron Man', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Chris Cantwell', 'Cafu', './assets/covers_img/579.jpg'),
(580, 'Iron Man', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Chris Cantwell', 'Salvador Larroca', './assets/covers_img/580.jpg'),
(581, 'Iron Man', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Chris Cantwell', 'Salvador Larroca', './assets/covers_img/581.jpg'),
(582, 'Iron Man', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Chris Cantwell', 'Salvador Larroca', './assets/covers_img/582.jpg'),
(583, 'Iron Man', 10, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Chris Cantwell', 'Salvador Larroca', './assets/covers_img/583.jpg'),
(584, 'Iron Man', 11, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Chris Cantwell', 'Salvador Larroca', './assets/covers_img/584.jpg'),
(585, 'Iron Man', 12, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Chris Cantwell', 'Salvador Larroca', './assets/covers_img/585.jpg'),
(586, 'Iron Man', 13, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Chris Cantwell', 'Salvador Larroca', './assets/covers_img/586.jpg'),
(587, 'Iron Man', 14, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Chris Cantwell', 'Salvador Larroca', './assets/covers_img/587.jpg'),
(588, 'Iron Man', 15, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Chris Cantwell', 'Salvador Larroca', './assets/covers_img/588.jpg'),
(589, 'Iron Man', 17, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Chris Cantwell', 'Salvador Larroca', './assets/covers_img/589.jpg'),
(590, 'Iron Man', 18, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Chris Cantwell', 'Salvador Larroca', './assets/covers_img/590.jpg'),
(591, 'Iron Man', 19, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Chris Cantwell', 'Salvador Larroca', './assets/covers_img/591.jpg'),
(592, 'Iron Man', 16, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Chris Cantwell', 'Salvador Larroca', './assets/covers_img/592.jpg'),
(593, 'Iron Man', 20, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Christopher Cantwell', 'Ángel Unzueta', './assets/covers_img/593.jpg'),
(594, 'Iron Man 2020', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott - Christos Gage', 'Pete Woods', './assets/covers_img/594.jpg'),
(595, 'Iron Man 2020', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott - Christos Gage', 'Pete Woods', './assets/covers_img/595.jpg'),
(596, 'Iron Man 2020', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott - Christos Gage', 'Pete Woods', './assets/covers_img/596.jpg'),
(597, 'Iron Man 2020', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott - Christos Gage', 'Pete Woods', './assets/covers_img/597.jpg'),
(598, 'Iron Man 2020', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott - Christos Gage', 'Pete Woods', './assets/covers_img/598.jpg'),
(599, 'Iron Man 2020', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott - Christos Gage', 'Pete Woods', './assets/covers_img/599.jpg'),
(600, 'Iron Man: Director de S.H.I.E.L.D', 1, 'Roberto de la Torre - Jackson Guice - Harvey Tolibao - Carlo Pagulayan - Steve Kurth', 'Panini', 'Tomo', 'Spain', '2021', 'Daniel Knauf - Charles Knauf - Christos Gage - Stuart Moore', 'Roberto de la Torre - Jackson Guice - Harvey Tolibao - Carlo Pagulayan - Steve Kurth', './assets/covers_img/600.jpg'),
(601, 'Iron man/Hellcat Annual', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Christopher Cantwell', 'Ruairi Coleman', './assets/covers_img/601.jpg'),
(602, 'Its Jeff', 1, 'Ron Lim', 'Marvel', 'Grapa', 'USA', '2023', 'Kelly Thompson', 'Gurihiru', './assets/covers_img/602.jpg'),
(603, 'Jane Foster & the mighty Thor', 2, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Torunn Gronbekk', 'Michael Dowling', './assets/covers_img/603.jpg'),
(604, 'Jane Foster & the mighty Thor', 3, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Torunn Gronbekk', 'Michael Dowling', './assets/covers_img/604.jpg'),
(605, 'Jane Foster & the mighty Thor', 4, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Torunn Gronbekk', 'Michael Dowling', './assets/covers_img/605.jpg'),
(606, 'Jane Foster & the mighty Thor', 5, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Torunn Gronbekk', 'Michael Dowling', './assets/covers_img/606.jpg'),
(607, 'Jane Foster & the mighty Thor', 1, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2022', 'Torunn Gronbekk', 'Michael Dowling', './assets/covers_img/607.jpg'),
(608, 'Jane Foster & the mighty Thor', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Torunn Gronbekk', 'Michael Dowling', './assets/covers_img/608.jpg'),
(609, 'Kang El Conquistador: La conquista de uno mismo', 1, 'Collin Kelly', 'Panini', 'Tomo', 'Spain', '2022', 'Collin Kelly - Jackson Lanzing', 'Carlos Magno', './assets/covers_img/609.jpg'),
(610, 'Kang the Conqueror', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2021', 'Collin Kelly -  Jackson Lanzing', 'Carlos Magno', './assets/covers_img/610.jpg'),
(611, 'King in Black Omnibus', 1, 'Mahmud A. Asrar', 'Simon And Sch UK', 'Tomo', 'USA', '2014', 'Donny Cates - Tini Howard', 'Marcus To - Wilton Santos', './assets/covers_img/611.jpg'),
(612, 'King in Black: Wiccan and Hukling ', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2021', 'Tini Howard', 'Luciano Vecchio', './assets/covers_img/612.jpg'),
(613, 'La Bruja Escarlata: La senda de las brujas', 1, 'David Aja', 'Panini', 'Tomo', 'Spain', '2021', 'James Robinson', 'Vanesa Del Rey', './assets/covers_img/613.jpg'),
(614, 'La Magnífica Ms. Marvel', 12, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Saladin Ahmed', 'Minkyu Jung', './assets/covers_img/614.jpg'),
(615, 'La Magnífica Ms. Marvel', 13, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Saladin Ahmed', 'Minkyu Jung', './assets/covers_img/615.jpg'),
(616, 'La Magnífica Ms. Marvel', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Saladin Ahmed', 'Minkyu Jung', './assets/covers_img/616.jpg'),
(617, 'La Magnífica Ms. Marvel', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Saladin Ahmed', 'Minkyu Jung', './assets/covers_img/617.jpg'),
(618, 'La Magnífica Ms. Marvel', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Saladin Ahmed', 'Minkyu Jung', './assets/covers_img/618.jpg'),
(619, 'La Magnífica Ms. Marvel', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Saladin Ahmed', 'Minkyu Jung', './assets/covers_img/619.jpg'),
(620, 'La Magnífica Ms. Marvel', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Saladin Ahmed', 'Minkyu Jung', './assets/covers_img/620.jpg'),
(621, 'La Magnífica Ms. Marvel', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Saladin Ahmed', 'Minkyu Jung', './assets/covers_img/621.jpg'),
(622, 'La Magnífica Ms. Marvel', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Saladin Ahmed', 'Minkyu Jung', './assets/covers_img/622.jpg'),
(623, 'La Magnífica Ms. Marvel', 11, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Saladin Ahmed', 'Minkyu Jung', './assets/covers_img/623.jpg'),
(624, 'La Magnífica Ms. Marvel', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Saladin Ahmed', 'Minkyu Jung', './assets/covers_img/624.jpg'),
(625, 'La Magnífica Ms. Marvel', 10, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Saladin Ahmed', 'Minkyu Jung', './assets/covers_img/625.jpg'),
(626, 'La Magnífica Ms. Marvel', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Saladin Ahmed', 'Minkyu Jung', './assets/covers_img/626.jpg'),
(627, 'La Visión. Marvel Integral', 1, 'Gabriel Hernández Walta', 'Panini', 'Tomo', 'Spain', '2018', 'Tom King', 'Gabriel Hernández Walta', './assets/covers_img/627.jpg'),
(628, 'Lara Croft & The Frozen Omen', 1, 'Jean-Sebastien Rossbach', 'Dark Horse', 'Grapa', 'USA', '2015', 'Corinna Bechko', 'Randy Green', './assets/covers_img/628.jpg'),
(629, 'Lara Croft & The Frozen Omen', 2, 'Jean-Sebastien Rossbach', 'Dark Horse', 'Grapa', 'USA', '2015', 'Corinna Bechko', 'Carmen Carnero', './assets/covers_img/629.jpg'),
(630, 'Las montañas de la locura', 1, 'Tanabe Gou', 'Planeta Comics', 'Tomo', 'Spain', '2021', 'Tanabe Gou', 'Tanabe Gou', './assets/covers_img/630.jpg'),
(631, 'Las montañas de la locura', 2, 'Tanabe Gou', 'Planeta Comics', 'Tomo', 'Spain', '2021', 'Tanabe Gou', 'Tanabe Gou', './assets/covers_img/631.jpg'),
(632, 'Las Poderosas Valquirias', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Mattia de Iulis', './assets/covers_img/632.jpg'),
(633, 'Las Poderosas Valquirias', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Mattia de Iulis', './assets/covers_img/633.jpg'),
(634, 'Loki: Viaje al misterio', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Matt Fraction - Kieron Gillen - Dan Abnett - Andy Lanning', 'Mitch Breitweiser - Doug Braithwaite - Richard Elson - Whilce Portacio', './assets/covers_img/634.jpg'),
(635, 'Los cuatro Fantasticos', 49, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2023', 'David Pepose', 'Juann Cabal', './assets/covers_img/635.jpg'),
(636, 'Los cuatro Fantasticos', 47, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Dan Slott', 'Andrea Di Vito', './assets/covers_img/636.jpg'),
(637, 'Los cuatro Fantasticos', 48, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Dan Slott', 'Cafu', './assets/covers_img/637.jpg'),
(638, 'Los cuatro Fantasticos', 46, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Dan Slott', 'Rachael Stott - Andrea Di Vito', './assets/covers_img/638.jpg');
INSERT INTO `comics` (`IDcomic`, `nomComic`, `numComic`, `nomVariante`, `nomEditorial`, `Formato`, `Procedencia`, `date_published`, `nomGuionista`, `nomDibujante`, `Cover`) VALUES
(639, 'Los cuatro fantasticos', 19, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/639.jpg'),
(640, 'Los cuatro fantasticos', 20, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/640.jpg'),
(641, 'Los cuatro fantasticos', 21, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/641.jpg'),
(642, 'Los cuatro fantasticos', 22, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/642.jpg'),
(643, 'Los cuatro fantasticos', 23, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/643.jpg'),
(644, 'Los cuatro fantasticos', 24, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/644.jpg'),
(645, 'Los cuatro fantasticos', 25, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/645.jpg'),
(646, 'Los cuatro fantasticos', 26, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/646.jpg'),
(647, 'Los cuatro fantasticos', 27, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/647.jpg'),
(648, 'Los cuatro fantasticos', 28, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/648.jpg'),
(649, 'Los cuatro fantasticos', 29, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/649.jpg'),
(650, 'Los cuatro fantasticos', 30, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/650.jpg'),
(651, 'Los cuatro fantasticos', 31, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/651.jpg'),
(652, 'Los cuatro fantasticos', 32, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/652.jpg'),
(653, 'Los cuatro fantasticos', 33, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/653.jpg'),
(654, 'Los cuatro fantasticos', 34, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/654.jpg'),
(655, 'Los cuatro fantasticos', 35, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/655.jpg'),
(656, 'Los cuatro fantasticos', 36, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/656.jpg'),
(657, 'Los cuatro fantasticos', 37, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/657.jpg'),
(658, 'Los cuatro fantasticos', 38, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/658.jpg'),
(659, 'Los cuatro fantasticos', 39, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/659.jpg'),
(660, 'Los cuatro fantasticos', 40, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/660.jpg'),
(661, 'Los cuatro fantasticos', 41, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/661.jpg'),
(662, 'Los cuatro fantasticos', 42, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/662.jpg'),
(663, 'Los cuatro fantasticos', 44, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/663.jpg'),
(664, 'Los cuatro fantasticos', 43, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/664.jpg'),
(665, 'Los cuatro fantasticos', 45, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/665.jpg'),
(666, 'Los cuatro fantasticos', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/666.jpg'),
(667, 'Los cuatro fantasticos', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/667.jpg'),
(668, 'Los cuatro fantasticos', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/668.jpg'),
(669, 'Los cuatro fantasticos', 10, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/669.jpg'),
(670, 'Los cuatro fantasticos', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/670.jpg'),
(671, 'Los cuatro fantasticos', 11, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/671.jpg'),
(672, 'Los cuatro fantasticos', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/672.jpg'),
(673, 'Los cuatro fantasticos', 17, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/673.jpg'),
(674, 'Los cuatro fantasticos', 18, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/674.jpg'),
(675, 'Los cuatro fantasticos', 13, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/675.jpg'),
(676, 'Los cuatro fantasticos', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/676.jpg'),
(677, 'Los cuatro fantasticos', 14, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/677.jpg'),
(678, 'Los cuatro fantasticos', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/678.jpg'),
(679, 'Los cuatro fantasticos', 15, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/679.jpg'),
(680, 'Los cuatro fantasticos', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/680.jpg'),
(681, 'Los cuatro fantasticos', 16, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/681.jpg'),
(682, 'Los cuatro fantasticos', 12, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/682.jpg'),
(683, 'Los cuatro fantasticos', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Sara Pichelli', './assets/covers_img/683.jpg'),
(684, 'Los eternos ', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2007', 'Neil Gaiman', 'John Romita Jr', './assets/covers_img/684.jpg'),
(685, 'Los eternos ', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2007', 'Neil Gaiman', 'John Romita Jr', './assets/covers_img/685.jpg'),
(686, 'Los eternos ', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2007', 'Neil Gaiman', 'John Romita Jr', './assets/covers_img/686.jpg'),
(687, 'Los eternos ', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2007', 'Neil Gaiman', 'John Romita Jr', './assets/covers_img/687.jpg'),
(688, 'Los eternos ', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2007', 'Neil Gaiman', 'John Romita Jr', './assets/covers_img/688.jpg'),
(689, 'Los eternos ', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2007', 'Neil Gaiman', 'John Romita Jr', './assets/covers_img/689.jpg'),
(690, 'Los eternos ', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2007', 'Neil Gaiman', 'John Romita Jr', './assets/covers_img/690.jpg'),
(691, 'Los Malditos: Antes del diluvio', 1, 'Variante de Panini Comics', 'Planeta de Agostini', 'Tomo', 'Spain', '2018', 'Jason Aaron', 'R. M. Guéra', './assets/covers_img/691.jpg'),
(692, 'Los Malditos: Las doncellas vírgenes', 2, 'Variante de Panini Comics', 'Planeta de Agostini', 'Tomo', 'Spain', '2022', 'Jason Aaron', 'R. M. Guéra', './assets/covers_img/692.jpg'),
(693, 'Many Deaths of laila Starr TP', 1, 'Filipe Andrade', 'Boom Studios', 'Tomo', 'USA', '2021', 'Ram V', 'Filipe Andrade ', './assets/covers_img/693.jpg'),
(694, 'Marauders', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Steve Orlando', 'Eleonora Carlini', './assets/covers_img/694.jpg'),
(695, 'Marauders Anual 2022', 1, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2022', 'Steve Orlando', 'Creees Inhyuk Lee', './assets/covers_img/695.jpg'),
(696, 'Marauders HC', 1, 'Russell Dauterman', 'Marvel', 'Tomo', 'USA', '2021', 'Gerry Duggan', 'Matteo Lolli - Lucas Werneck', './assets/covers_img/696.jpg'),
(697, 'Marvel Collection - She-Hulk', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2018', 'Dan Slott', 'Juan Bobillo - Paul Pelletier', './assets/covers_img/697.jpg'),
(698, 'Marvel Deluxe - Civil war: Preludio', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2013', 'Brian Michael Bendis', 'Alex MaInhyuk Leev - Ron Garney - Joe Michael Straczynski', './assets/covers_img/698.jpg'),
(699, 'Marvel Deluxe - Dinastia M', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2016', 'Brian Michael Bendis', 'Olivier Coipel', './assets/covers_img/699.jpg'),
(700, 'Marvel Deluxe - Invasion Secreta', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Brian Michael Bendis', 'Leinil Francis Yu', './assets/covers_img/700.jpg'),
(701, 'Marvel Deluxe - Marvel zombis: Hambre insaciable', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2010', 'Robert Kirkman', 'Greg Land - Mark Millar - Sean Phillips', './assets/covers_img/701.jpg'),
(702, 'Marvel Deluxe - Vengadores: Desunidos', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2016', 'Brian Michael Bendis', 'Olivier Coipel', './assets/covers_img/702.jpg'),
(703, 'Marvel Deluxe - World war Hulk integral', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2012', 'Greg Pak', 'John Romita Jr', './assets/covers_img/703.jpg'),
(704, 'Marvel Edicion de lujo - Historia del universo Marvel', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Mark Waid', 'Javier Rodriguez', './assets/covers_img/704.jpg'),
(705, 'Marvel HC - Aniquilación: Plaga', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Matthew Rosenberg - Christos Gage - Dan Abnett - Michael Moreci', 'Juanan Ramírez - Cian Tormey - Diego Olórtegui - Ibraim Roberson - Paul Davidson - Alberto Alburquereque - Manuel García', './assets/covers_img/705.jpg'),
(706, 'Marvel HC - Caballero Luna', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Bill Mantlo', 'Rick Leonardi - Ed Hannigan', './assets/covers_img/706.jpg'),
(707, 'Marvel HC - Caballero Luna de Bendis: Actos y consecuencias', 2, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2012', 'Brian Michael Bendis', 'Alex Mallev', './assets/covers_img/707.jpg'),
(708, 'Marvel HC - Caballero Luna de Bendis: Los amigos imaginarios', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2012', 'Brian Michael Bendis', 'Alex Mallev', './assets/covers_img/708.jpg'),
(709, 'Marvel HC - Estela plateada: Libertad', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Stan Lee - John Byrne - Steve Englehart', 'John Byrne - Marshall Rogers', './assets/covers_img/709.jpg'),
(710, 'Marvel HC - Estela plateada: Pesos pesados', 3, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Stan Lee - Steve Englehart', 'Joe Staton - Ron Lim - Moebius', './assets/covers_img/710.jpg'),
(711, 'Marvel HC - Estela plateada: Triangulo', 2, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Steve Englehart', 'Marshall Rogers - Joe Stanton', './assets/covers_img/711.jpg'),
(712, 'Marvel HC - Lobezna: Cuatro Hermanas', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2016', 'Tom Taylor', 'David López y David Navarrot', './assets/covers_img/712.jpg'),
(713, 'Marvel HC - Thanos: Orígenes', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2018', 'Jason Aaron', 'Simone Bianchi', './assets/covers_img/713.jpg'),
(714, 'Marvel HC - Veveno: Greats Hits', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2018', 'David Michelinie.', 'Todd Mcfarnalane - Erik Larsen y Mark Mark Bagley', './assets/covers_img/714.jpg'),
(715, 'Marvel hc daredevil. amarillo', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Jeph Loeb', 'Tim Sale', './assets/covers_img/715.jpg'),
(716, 'Marvel integral - Civil war', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2016', 'Brian Michael Bendis - Mark Millar', 'Alex MaInhyuk Leex - Steve McNiven', './assets/covers_img/716.jpg'),
(717, 'Marvel integral - Ojo de alcón', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Matt Fraction', 'David Aja - Alan Davis - Javier Pulido', './assets/covers_img/717.jpg'),
(718, 'Marvel integral - Thanos: La primera triologia', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Jim Starlin', 'Jim Starlin - Ron Lim - Alan Davis', './assets/covers_img/718.jpg'),
(719, 'Marvel Legacy Alpha', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Ed McGuinness - Stuart Immonen - Chris Samnee - Daniel Acuña - Jim Cheung - Russell Dauterman - Alex Maleev - Esad Ribic - Pepe Larraz - Greg Land - S', './assets/covers_img/719.jpg'),
(720, 'Marvel must Have - Daredevil: El hombre sin miedo ', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Frank Miller', 'John Romita Jr', './assets/covers_img/720.jpg'),
(721, 'Marvel must Have - Los vengadores - Las guerras asgardianas', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Brian Michael Bendis', 'Alan Davis', './assets/covers_img/721.jpg'),
(722, 'Marvel must Have - Planeta Hulk', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Greg Pak', 'Gary Frank - Aaron Lopresti - Carlo Pagulayan', './assets/covers_img/722.jpg'),
(723, 'Marvel must Have - Universo Spider-Man Spider-cero', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Dan Slott', 'Olivier Coipel - Giuseppe Camuncoli', './assets/covers_img/723.jpg'),
(724, 'Marvel must-have: Los nuevos vengadores: Civil War', 5, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Brian Michael Bendis', 'Alex MaInhyuk Leev - Howard Chaykin - Leinil Francis Yu - Pasqual Ferry - Jim Cheung - Olivier Coipel', './assets/covers_img/724.jpg'),
(725, 'Marvel must-have: Los nuevos vengadores: Confianza', 7, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Brian Michael Bendis', 'Leinil Francis Yu - Carlo Pagulayan - David Mack', './assets/covers_img/725.jpg'),
(726, 'Marvel must-have: Los nuevos vengadores: El colectivo', 4, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Brian Michael Bendis', 'Steve McNiven - Mike Deodato - Olivier Coipel', './assets/covers_img/726.jpg'),
(727, 'Marvel must-have: Los nuevos vengadores: El vigia', 2, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Brian Michael Bendis', 'Steve McNiven', './assets/covers_img/727.jpg'),
(728, 'Marvel must-have: Los nuevos vengadores: Fuga', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Brian Michael Bendis', 'David Finch', './assets/covers_img/728.jpg'),
(729, 'Marvel must-have: Los nuevos vengadores: Illuminati', 8, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Brian Michael Bendis', 'Jim Cheung - Brian Reed', './assets/covers_img/729.jpg'),
(730, 'Marvel must-have: Los nuevos vengadores: Invasión Secreta', 9, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Brian Michael Bendis', 'Jim Cheung - Michael Gaydos - Billy Tan', './assets/covers_img/730.jpg'),
(731, 'Marvel must-have: Los nuevos vengadores: Revolución', 6, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Brian Michael Bendis', 'Leinil Francis Yu', './assets/covers_img/731.jpg'),
(732, 'Marvel must-have: Los nuevos vengadores: Secretos y mentiras', 3, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Brian Michael Bendis', 'Frank Cho - David Finch - Rick Mays', './assets/covers_img/732.jpg'),
(733, 'Marvel Now Deluxe - Capitan America : Capitan Anti-America', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Nick Spencer', 'Daniel Acuña - Jesús Saiz - Paul Renaud - Joe Bennett - Mark Mark Bagley', './assets/covers_img/733.jpg'),
(734, 'Marvel Now Deluxe - Capitan America : Hail Hydra', 2, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Nick Spencer', 'Daniel Acuña - Jesús Saiz - Ángel Unzueta - Miguel Ángel Sepúlveda - Javier Pina', './assets/covers_img/734.jpg'),
(735, 'Marvel Now Deluxe - Guardianes de la galaxia', 2, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Gerry Duggan', 'Michael Allred - Marcus To', './assets/covers_img/735.jpg'),
(736, 'Marvel Now Deluxe - Guardianes de la galaxia', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Brian Michael Bendis', 'Steve McNiven - Sara Pichelli', './assets/covers_img/736.jpg'),
(737, 'Marvel Now Deluxe - Guardianes de la galaxia', 2, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2018', 'Brian Michael Bendis', 'Nick Bradshaw - Arthur Adams', './assets/covers_img/737.jpg'),
(738, 'Marvel Now Deluxe - Guardianes de la galaxia', 3, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Brian Michael Bendis', 'Steve McNiven - Sara Pichelli', './assets/covers_img/738.jpg'),
(739, 'Marvel Now Deluxe - Guardianes de la galaxia', 4, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Brian Michael Bendis', 'Nick Bradshaw - Arthur Adams', './assets/covers_img/739.jpg'),
(740, 'Marvel Now Deluxe - Guardianes de la galaxia', 5, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Brian Michael Bendis', 'Nick Bradshaw - Arthur Adams', './assets/covers_img/740.jpg'),
(741, 'Marvel Now Deluxe - Invencible Iron man : Internacional', 2, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Brian Michael Bendis', 'Alex MaInhyuk Leev - Mike Deodato', './assets/covers_img/741.jpg'),
(742, 'Marvel Now Deluxe - Invencible Iron man : Reinicio', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Brian Michael Bendis', 'David Marquez - Mike Deodato', './assets/covers_img/742.jpg'),
(743, 'Marvel Now Deluxe - Invencible Iron man: Riri Williams', 4, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Brian Michael Bendis', 'Kate Niemczyk - Taki Soma - Kiichi Mizushima - Stefano Caselli', './assets/covers_img/743.jpg'),
(744, 'Marvel Now Deluxe - Pecado Original: Quien mato al observador', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2018', 'Jason Aaron', 'Mike Deodato', './assets/covers_img/744.jpg'),
(745, 'Marvel Now Deluxe - Secret Wars', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Jonathan Hickman', 'Esad Ribic - Ive Svorcina', './assets/covers_img/745.jpg'),
(746, 'Marvel Now Deluxe - Thor El dios del trueno: Camino de guerra de los reinos', 7, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Jason Aaron', 'Lee Garbett - Michael Del Mundo - Tony Moore - Christian Ward', './assets/covers_img/746.jpg'),
(747, 'Marvel Now Deluxe - Thor El dios del trueno: El carnicero de los dioses', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Jason Aaron', 'Esad Ribic - Butch Guice - Nic Klein', './assets/covers_img/747.jpg'),
(748, 'Marvel Now Deluxe - Thor El dios del trueno: El indigno Thor', 5, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Jason Aaron', 'Olivier Coipel - Steve Epting - Kim Jacinto - Pascal Alixe - Frazer Irving - Esad Ribic - Russell Dauterman - Valentino Schiti', './assets/covers_img/748.jpg'),
(749, 'Marvel Now Deluxe - Thor El dios del trueno: El maldito', 2, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Jason Aaron', 'Ron Garney - Esad Ribic', './assets/covers_img/749.jpg'),
(750, 'Marvel Now Deluxe - Thor El dios del trueno: El trueno en las venas', 3, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Jason Aaron', 'Russell Dauterman - Rafa Garrés', './assets/covers_img/750.jpg'),
(751, 'Marvel Now Deluxe - Thor El dios del trueno: La diosa del trueno', 4, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Jason Aaron', 'Jorge Molina - Russell Dauterman - Chris Sprouse', './assets/covers_img/751.jpg'),
(752, 'Marvel Now Deluxe - Thor El dios del trueno: La muerte de thor', 6, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Jason Aaron', 'Michael Del Mundo - Russell Dauterman - Walter Simonson - Daniel Acuña - Valerio Schiti - Das Pastoras - Olivier Coipel', './assets/covers_img/752.jpg'),
(753, 'Marvel Now Deluxe - Vengadores: Adaprtarse o morir', 5, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Jonathan Hickman', 'Esad Ribic - Simone Bianchi - Rags Morales - Salvador Larroca', './assets/covers_img/753.jpg'),
(754, 'Marvel Now Deluxe - Vengadores: El tiempo se acaba Parte 1', 8, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Jonathan Hickman', 'Jim Cheung - Frank Barbiere - Marco Checchetto - Kev Walker - Stefano Caselli', './assets/covers_img/754.jpg'),
(755, 'Marvel Now Deluxe - Vengadores: El tiempo se acaba Parte 2', 9, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Jonathan Hickman', 'Mike Mayhew - Mike Deodato - Kev Walker - Stefano Caselli', './assets/covers_img/755.jpg'),
(756, 'Marvel Now Deluxe - Vengadores: El ultimo evento blanco', 2, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Jonathan Hickman', 'Dustin Weaver - Mike Deodato', './assets/covers_img/756.jpg'),
(757, 'Marvel Now Deluxe - Vengadores: Infinito', 3, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Jonathan Hickman', 'Dustin Weaver - Jim Cheung - Jerome Opeña', './assets/covers_img/757.jpg'),
(758, 'Marvel Now Deluxe - Vengadores: Infinito segunda parte', 4, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Jonathan Hickman', 'Dustin Weaver - Jim Cheung - Jerome Opeña', './assets/covers_img/758.jpg'),
(759, 'Marvel Now Deluxe - Vengadores: Los siete magnificos', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2018', 'Mark Waid', 'Adam Kubert - Mahmud Asrar - Alan Davis', './assets/covers_img/759.jpg'),
(760, 'Marvel Now Deluxe - Vengadores: Pecado original', 7, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Jonathan Hickman', 'Leinil Francis Yu - Valerio Schiti - Kev Walker - Salvador Larroca', './assets/covers_img/760.jpg'),
(761, 'Marvel Now Deluxe - Vengadores: Todo muere', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Jonathan Hickman', 'Steve McNiven - Jerome Opeña', './assets/covers_img/761.jpg'),
(762, 'Marvel Now Deluxe - Vengadores: Vengadores mundiales', 6, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Jonathan Hickman - Nick Spencer', 'Marco Checchetto - Stefano Caselli', './assets/covers_img/762.jpg'),
(763, 'Marvel Omnibus - Estela plateada', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Dan Slott', 'Mike Allred', './assets/covers_img/763.jpg'),
(764, 'Marvel Omnibus - Ms.Marvel: Conquistada', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Dan Slott - Christos Gage - Mark Waid - G. Willow Wilson - James Robinson', 'Giuseppe Cammuncoli - Humberto Ramos - Elmo Bondoc - Takeshi Miyazawa - Adrian Alphona - Chris Samnee', './assets/covers_img/764.jpg'),
(765, 'Marvel Omnibus - Ms.Marvel: Fuera de lo normal', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'G. Willow Wilson.', 'Adrian Alphona - Jacob Wyatt', './assets/covers_img/765.jpg'),
(766, 'Marvel Omnibus - X-Statix 1', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Peter Milligan', 'Mike Allred', './assets/covers_img/766.jpg'),
(767, 'Marvel Omnibus: Hulka', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Charles Soule', 'Javier Pulido - Ronald Winberly - Jason Masters - Langdon Foss', './assets/covers_img/767.jpg'),
(768, 'Marvel Premiere - Corporación-x', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Tini Howard', 'Alberto Foche', './assets/covers_img/768.jpg'),
(769, 'Marvel Premiere - Daredevil: Conoce el miedo', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Chip Zdarsky', 'Marco Checchetto - Chip Zdarsky', './assets/covers_img/769.jpg'),
(770, 'Marvel Premiere - Daredevil: El fin del infierno', 4, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Chip Zdarsky', 'Steve Murray', './assets/covers_img/770.jpg'),
(771, 'Marvel Premiere - Daredevil: No hay diablos - sólo dios', 2, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Chip Zdarsky', 'Lalit Kumar Sharma - Jorge Fornes', './assets/covers_img/771.jpg'),
(772, 'Marvel Premiere - Daredevil: Por el infierno', 3, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Chip Zdarsky', 'Marco Checchetto - Francesco Mobili', './assets/covers_img/772.jpg'),
(773, 'Marvel Premiere - Dinastia de X/Potencias de X: La dinastia que creo Xavier', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Jonathan Hickman', 'Pepe Larraz - R.B. R. B. Silva', './assets/covers_img/773.jpg'),
(774, 'Marvel Premiere - Dinastia de X/Potencias de X: La increíble vida de Moira-X', 2, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Jonathan Hickman', 'Pepe Larraz - R.B. R. B. Silva', './assets/covers_img/774.jpg'),
(775, 'Marvel Premiere - Dinastia de X/Potencias de X: Nunca más', 3, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Jonathan Hickman', 'Pepe Larraz - R.B. R. B. Silva', './assets/covers_img/775.jpg'),
(776, 'Marvel Premiere - Dinastia de X/Potencias de X: Y ahora construímos', 4, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Jonathan Hickman', 'Pepe Larraz - R.B. R. B. Silva', './assets/covers_img/776.jpg'),
(777, 'Marvel Premiere - Los vengadores: La guerra Kree-Skrull', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Roy Thomas', 'Sal Buscema - Neal Adams - John Buscema', './assets/covers_img/777.jpg'),
(778, 'Marvel Premiere - Senda de X', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Simon Spurrier', 'Bob Quinn', './assets/covers_img/778.jpg'),
(779, 'Marvel Premiere - Spider-Man de Spencer: Amigos y enemigos', 2, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Nick Spencer', 'Michele Bandini - Humberto Ramos', './assets/covers_img/779.jpg'),
(780, 'Marvel Premiere - Spider-Man de Spencer: Cazado 1º parte', 4, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Nick Spencer', 'Ken Ken Lashley - Iban Coello - Humberto Ramos', './assets/covers_img/780.jpg'),
(781, 'Marvel Premiere - Spider-Man de Spencer: Cazado 2º parte', 5, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Nick Spencer', 'Ryan Ottley - Gerardo Sandoval - Chris Bachalo - Humberto Ramos - Cory Smith', './assets/covers_img/781.jpg'),
(782, 'Marvel Premiere - Spider-Man de Spencer: Matanza absoluta', 7, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Nick Spencer', 'Francesco Manna - Ryan Ottley', './assets/covers_img/782.jpg'),
(783, 'Marvel Premiere - Spider-Man de Spencer: Premio a toda una vida', 3, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Nick Spencer', 'Ryan Ottley - Chris Bachalo', './assets/covers_img/783.jpg'),
(784, 'Marvel Premiere - Spider-Man de Spencer: Regreso a las esencias', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Nick Spencer', 'Ryan Ottley', './assets/covers_img/784.jpg'),
(785, 'Marvel saga - Aniquilación saga : Nova y Estela Plateada', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Keith Giffen', 'Renato Arlem - Andy Lanning - Dan Abnett - Kev Walker', './assets/covers_img/785.jpg'),
(786, 'Marvel saga - Aniquilación saga: Prologo', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Keith Giffen', 'Ariel Olivetti - Mitch Breitweiser - Scott Kolins', './assets/covers_img/786.jpg'),
(787, 'Marvel saga - El asombroso Spider-Man: La conspiración del clon', 55, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2010', 'Dan Slott', 'Ron Frenz - Giuseppe Cammuncoli - Jim Cheung - Stuart Immonen - Christos Gage - Mark Mark Bagley - Peter David', './assets/covers_img/787.jpg'),
(788, 'Marvel saga - Los 4 fantasticos', 4, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Jonathan Hickman', 'Barry Kitson - Steve Epting', './assets/covers_img/788.jpg'),
(789, 'Marvel saga - Los 4 fantasticos', 5, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Jonathan Hickman', 'Barry Kitson - Steve Epting', './assets/covers_img/789.jpg'),
(790, 'Marvel saga - Los 4 fantasticos', 6, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Jonathan Hickman', 'Leinil Francis Yu - Barry Kitson - Ming Doyle - Steve Epting', './assets/covers_img/790.jpg'),
(791, 'Marvel saga - Los 4 fantasticos ', 9, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Jonathan Hickman', 'Ryan Stegman - Nick Dragotta', './assets/covers_img/791.jpg'),
(792, 'Marvel saga - Los 4 fantasticos', 7, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Jonathan Hickman', 'Juan Bobillo - Nick Dragotta', './assets/covers_img/792.jpg'),
(793, 'Marvel saga - Los 4 fantasticos', 8, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Jonathan Hickman', 'Giuseppe Camuncoli - Ron Garney - Mike Choi - Gabriel Hernández Walta - Nick Dragotta', './assets/covers_img/793.jpg'),
(794, 'Marvel saga - Los 4 fantasticos', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Jonathan Hickman', 'Adi Granov - Sean Chen', './assets/covers_img/794.jpg'),
(795, 'Marvel saga - Los 4 fantasticos', 2, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Jonathan Hickman', 'Neil Edwards - Dale Eaglesham', './assets/covers_img/795.jpg'),
(796, 'Marvel saga - Los 4 fantasticos', 3, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Jonathan Hickman', 'Neil Edwards - Steve Epting', './assets/covers_img/796.jpg'),
(797, 'Marvel Skottie Young Adults - Ojo de halcon - Al oeste', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2022', 'Kelly Thompson', 'Stefano Raffaele - Leonardo Romero - Stefano Caselli', './assets/covers_img/797.jpg'),
(798, 'Marvel Skottie Young Adults - Ojo de halcon - Detective privado', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2021', 'Kelly Thompson', 'Leonardo Romero - Michael Walsh', './assets/covers_img/798.jpg'),
(799, 'Marvel Voices Pride(2022)', 1, 'Amy Reeder', 'Marvel', 'Grapa', 'USA', '2022', 'Alyssa Wong', 'Stephen Byrne', './assets/covers_img/799.jpg'),
(800, 'Marvel Zombies: Hambre insaciable', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2010', 'Mark Millar - Sean Phillips - Robert Kirkman', 'Greg Land', './assets/covers_img/800.jpg'),
(801, 'Marvels Voices Pride', 1, 'Amy Reeder', 'Marvel', 'Grapa', 'USA', '2022', 'Alyssa Wong', 'Stephen Byrne', './assets/covers_img/801.jpg'),
(802, 'Mary Jane and Black Cat', 4, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2023', 'Jed MacKay', 'Vincenzo Carratu', './assets/covers_img/802.jpg'),
(803, 'Matanza absoluta', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/803.jpg'),
(804, 'Matanza absoluta', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/804.jpg'),
(805, 'Matanza absoluta', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/805.jpg'),
(806, 'Matanza absoluta Arma+', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jed Mackay', 'Stefano Raffaele', './assets/covers_img/806.jpg'),
(807, 'Matanza absoluta vs masacre', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Frank Tieri', 'Marcelo Ferreira', './assets/covers_img/807.jpg'),
(808, 'Matanza absoluta vs masacre', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Frank Tieri', 'Marcelo Ferreira', './assets/covers_img/808.jpg'),
(809, 'Maus: Edición 40 aniversario', 1, 'Variante de Panini Comics', 'Sd reservoir books', 'Tomo', 'Spain', '2021', 'Art Spiegelman', 'Art Spiegelman', './assets/covers_img/809.jpg'),
(810, 'Midnight Suns', 1, 'David Nakayama', 'Marvel', 'Grapa', 'USA', '2022', 'Ethan Sacks', 'Luigi Zagaria', './assets/covers_img/810.jpg'),
(811, 'Midnight Suns', 2, 'David Nakayama', 'Marvel', 'Grapa', 'USA', '2022', 'Ethan Sacks', 'Luigi Zagaria', './assets/covers_img/811.jpg'),
(812, 'Miles Morales & Moon Girl', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Mohale Mashigo', 'Ig Guara', './assets/covers_img/812.jpg'),
(813, 'Miles Morales: Spider-Man', 4, 'Chris Bachalo', 'Marvel', 'Grapa', 'USA', '2023', 'Cody Ziglar', 'Federico Vicentini', './assets/covers_img/813.jpg'),
(814, 'Miles Morales: Spider-Man', 22, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Alberto Foche', 'Saladin Ahmed', './assets/covers_img/814.jpg'),
(815, 'Miles Morales: Spider-Man', 21, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Saladin Ahmed', 'Chris Allen', './assets/covers_img/815.jpg'),
(816, 'Miles Morales: Spider-Man', 19, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/816.jpg'),
(817, 'Miles Morales: Spider-Man', 14, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/817.jpg'),
(818, 'Miles Morales: Spider-Man', 15, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/818.jpg'),
(819, 'Miles Morales: Spider-Man', 30, 'Taurin Clarke', 'Marvel', 'Grapa', 'USA', '2022', 'Saladin Ahmed', 'Anthony Piper - Carmen Carnero - Sara Pichelli', './assets/covers_img/819.jpg'),
(820, 'Miles Morales: Spider-Man', 18, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/820.jpg'),
(821, 'Miles Morales: Spider-Man', 19, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/821.jpg'),
(822, 'Miles Morales: Spider-Man', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/822.jpg'),
(823, 'Miles Morales: Spider-Man', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/823.jpg'),
(824, 'Miles Morales: Spider-Man', 17, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Saladin Ahmed', 'Carmen Carnero', './assets/covers_img/824.jpg'),
(825, 'Miles Morales: Spider-Man', 20, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/825.jpg'),
(826, 'Miles Morales: Spider-Man', 16, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/826.jpg'),
(827, 'Miles Morales: Spider-Man', 3, 'Dike Ruan', 'Marvel', 'Grapa', 'USA', '2023', 'Cody Ziglar', 'Federico Vicentini', './assets/covers_img/827.jpg'),
(828, 'Miles Morales: Spider-Man', 2, 'Hans', 'Marvel', 'Grapa', 'USA', '2022', 'Cody Ziglar', 'Federico Vicentini', './assets/covers_img/828.jpg'),
(829, 'Miles Morales: Spider-Man', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Cody Ziglar', 'Federico Vicentini', './assets/covers_img/829.jpg'),
(830, 'Miles Morales: Spider-Man', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/830.jpg'),
(831, 'Miles Morales: Spider-Man', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/831.jpg'),
(832, 'Miles Morales: Spider-Man', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/832.jpg'),
(833, 'Miles Morales: Spider-Man', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/833.jpg'),
(834, 'Miles Morales: Spider-Man', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/834.jpg'),
(835, 'Miles Morales: Spider-Man', 10, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/835.jpg'),
(836, 'Miles Morales: Spider-Man', 11, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/836.jpg'),
(837, 'Miles Morales: Spider-Man', 12, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/837.jpg'),
(838, 'Miles Morales: Spider-Man', 13, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/838.jpg'),
(839, 'Miles Morales: Spider-Man', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/839.jpg'),
(840, 'Miles Morales: Spider-Man', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Saladin Ahmed', 'Javier Garrón', './assets/covers_img/840.jpg'),
(841, 'Miracleman: The Silver Age', 2, 'Declan Shalvey', 'Marvel', 'Grapa', 'USA', '2022', 'Neil Gaiman', 'Mark Buckingham', './assets/covers_img/841.jpg'),
(842, 'Miracleman: The Silver Age', 1, 'Martin Coccolo', 'Marvel', 'Grapa', 'USA', '2023', 'Neil Gaiman', 'Mark Buckingham', './assets/covers_img/842.jpg'),
(843, 'Monica Rambeau: Photon', 4, 'Lucas Werneck', 'Marvel', 'Grapa', 'USA', '2023', 'Eve L. Ewing', 'Eve L. Ewing - Luca Maresca', './assets/covers_img/843.jpg'),
(844, 'Monica Rambeau: Photon', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Eve L. Ewing', 'Michael Sta. Maria', './assets/covers_img/844.jpg'),
(845, 'Monica Rambeau: Photon', 2, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Eve L. Ewing', 'Michael Sta. Maria', './assets/covers_img/845.jpg'),
(846, 'Monica Rambeau: Photon', 3, 'Lucas Werneck', 'Marvel', 'Grapa', 'USA', '2023', 'Eve L. Ewing', 'Eve L. Ewing - Michael Sta. Maria', './assets/covers_img/846.jpg'),
(847, 'Monster Unreleash ', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Cullen Bunn', 'Steve McNiven', './assets/covers_img/847.jpg'),
(848, 'Monster Unreleash ', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Cullen Bunn', 'Steve McNiven', './assets/covers_img/848.jpg'),
(849, 'Monster Unreleash ', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Cullen Bunn', 'Steve McNiven', './assets/covers_img/849.jpg'),
(850, 'Monster Unreleash ', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Cullen Bunn', 'Steve McNiven', './assets/covers_img/850.jpg'),
(851, 'Monster Unreleash ', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Cullen Bunn', 'Steve McNiven', './assets/covers_img/851.jpg'),
(852, 'Monster Unreleash ', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2017', 'Cullen Bunn', 'Steve McNiven', './assets/covers_img/852.jpg'),
(853, 'Moon Knight (2021)', 12, 'Daute', 'Marvel', 'Grapa', 'USA', '2022', 'Jed Mackay', 'Alessandro Cappuccio', './assets/covers_img/853.jpg'),
(854, 'Moon Knight TP vol01', 1, 'Steve McNiven', 'Marvel', 'Tomo', 'USA', '2022', 'Jed MacKay', 'Alessandro Cappuccio', './assets/covers_img/854.jpg'),
(855, 'Moon Knight: Black - white & blood', 1, 'Bill Sienkiewicz', 'Marvel', 'Grapa', 'USA', '2022', 'Jonathan Hickman - Marc Guggenheim - Murewa Ayodele', 'Chris Bachalo - Akande Adedotun - Jorge Fornes', './assets/covers_img/855.jpg'),
(856, 'Moon Knight: Black - white & blood', 2, 'Ryan Stegman', 'Marvel', 'Grapa', 'USA', '2022', 'Benjamin Percy - David Pepose - Patch Zircher', 'Leonardo Romero - Vanesa Del Rey - Patch Zircher', './assets/covers_img/856.jpg'),
(857, 'Moon Knight: Black - white & blood', 3, 'Klein', 'Marvel', 'Grapa', 'USA', '2022', 'Jim Zub - Erica Schultz - Dan Slott - Ann Nocenti', 'Stefano Raffaele - Djibril Morissette-Phan - David Lopez', './assets/covers_img/857.jpg'),
(858, 'Moon Knight: Black - white & blood', 4, 'Rod Reis', 'Marvel', 'Grapa', 'USA', '2022', 'Paul Azaceta - Christopher Cantwell - Nadia Shammas', 'Paul Azaceta - Alex Lins - Dante Bastianoni', './assets/covers_img/858.jpg'),
(859, 'Ms Marvel - Beyond Ron Limit', 1, 'Mashal Ahmed', 'Marvel', 'Grapa', 'USA', '2021', 'Samira Ahmed', 'Andres Genolet', './assets/covers_img/859.jpg'),
(860, 'Ms Marvel - Beyond Ron Limit', 3, 'Mashal Ahmed', 'Marvel', 'Grapa', 'USA', '2022', 'Samira Ahmed', 'Andres Genolet', './assets/covers_img/860.jpg'),
(861, 'Ms Marvel - Beyond Ron Limit', 4, 'Ruan', 'Marvel', 'Grapa', 'USA', '2022', 'Samira Ahmed', 'Andres Genolet', './assets/covers_img/861.jpg'),
(862, 'Ms Marvel - Beyond Ron Limit', 5, 'Sabine Rich', 'Marvel', 'Grapa', 'USA', '2022', 'Samira Ahmed', 'Andres Genolet', './assets/covers_img/862.jpg'),
(863, 'Ms Marvel & Venom', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Jody Houser', 'Dave Wachter', './assets/covers_img/863.jpg'),
(864, 'Ms Marvel & Wolverine', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Jody Houser', 'Ze Carlos', './assets/covers_img/864.jpg'),
(865, 'Ms Marvel and the moon Knight', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Jody Houser', 'Ibraim Roberson', './assets/covers_img/865.jpg'),
(866, 'New Mutants', 32, 'Gerardo Sandoval', 'Marvel', 'Grapa', 'USA', '2022', 'Charlie Jane Anders', 'Alberto Alburquerque - Ro Stein', './assets/covers_img/866.jpg'),
(867, 'New Mutants', 16, 'Christian Ward', 'Marvel', 'Grapa', 'USA', '2020', 'Vita Ayala', 'Rod Reis', './assets/covers_img/867.jpg'),
(868, 'New Mutants', 17, 'Christian Ward', 'Marvel', 'Grapa', 'USA', '2021', 'Vita Ayala', 'Rod Reis', './assets/covers_img/868.jpg'),
(869, 'New Mutants', 18, 'Christian Ward', 'Marvel', 'Grapa', 'USA', '2021', 'Vita Ayala', 'Christian Ward', './assets/covers_img/869.jpg'),
(870, 'New Mutants', 19, 'Martin Simmonds', 'Marvel', 'Grapa', 'USA', '2021', 'Vita Ayala', 'Alex Lins', './assets/covers_img/870.jpg'),
(871, 'New Mutants', 20, 'Martin Simmonds', 'Marvel', 'Grapa', 'USA', '2021', 'Vita Ayala', 'Alex Lins', './assets/covers_img/871.jpg'),
(872, 'New Mutants', 21, 'Martin Simmonds', 'Marvel', 'Grapa', 'USA', '2021', 'Vita Ayala', 'Alex Lins', './assets/covers_img/872.jpg'),
(873, 'New Mutants', 22, 'Martin Simmonds', 'Marvel', 'Grapa', 'USA', '2021', 'Vita Ayala', 'Rod Reis', './assets/covers_img/873.jpg'),
(874, 'New Mutants', 23, 'Martin Simmonds', 'Marvel', 'Grapa', 'USA', '2021', 'Vita Ayala', 'Rod Reis', './assets/covers_img/874.jpg'),
(875, 'New Mutants', 24, 'Martin Simmonds', 'Marvel', 'Grapa', 'USA', '2021', 'Vita Ayala', 'Martin Simmonds', './assets/covers_img/875.jpg'),
(876, 'New Mutants', 25, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2022', 'Vita Ayala', 'Rod Reis', './assets/covers_img/876.jpg'),
(877, 'New Mutants', 26, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2022', 'Vita Ayala', 'Rod Reis', './assets/covers_img/877.jpg'),
(878, 'New Mutants', 27, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2022', 'Vita Ayala', 'Jan Duursema', './assets/covers_img/878.jpg'),
(879, 'New Mutants', 28, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2022', 'Vita Ayala', 'Jan Duursema - Rod Reis', './assets/covers_img/879.jpg'),
(880, 'New Mutants', 29, 'Rod Reis', 'Marvel', 'Grapa', 'USA', '2022', 'Vita Ayala', 'Guillermo Sanna', './assets/covers_img/880.jpg'),
(881, 'New Mutants', 30, 'Rafael De Latorre', 'Marvel', 'Grapa', 'USA', '2022', 'Alyssa Wong - Vita Ayala', 'Justin Mason - Geoffrey Shaw - Alex Lins - Jason Loo', './assets/covers_img/881.jpg'),
(882, 'New Mutants', 31, 'Rafael De Latorre', 'Marvel', 'Grapa', 'USA', '2022', 'Charlie Jane Anders', 'Ro Stein - Alberto Alburquerque', './assets/covers_img/882.jpg'),
(883, 'New Mutants', 1, 'Rod Reis', 'Marvel', 'Grapa', 'USA', '2019', 'Jonathan Hickman - Ed Brisson', 'Rod Reis', './assets/covers_img/883.jpg'),
(884, 'New Mutants', 2, 'Rod Reis', 'Marvel', 'Grapa', 'USA', '2019', 'Jonathan Hickman', 'Rod Reis', './assets/covers_img/884.jpg'),
(885, 'New Mutants', 3, 'Rod Reis', 'Marvel', 'Grapa', 'USA', '2019', 'Ed Brisson', 'Flaviano', './assets/covers_img/885.jpg'),
(886, 'New Mutants', 4, 'Rod Reis', 'Marvel', 'Grapa', 'USA', '2019', 'Jonathan Hickman', 'Rod Reis', './assets/covers_img/886.jpg'),
(887, 'New Mutants', 5, 'Rod Reis', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Rod Reis', './assets/covers_img/887.jpg'),
(888, 'New Mutants', 6, 'Rod Reis', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Flaviano', './assets/covers_img/888.jpg'),
(889, 'New Mutants', 33, 'Rafael De Latorre', 'Marvel', 'Grapa', 'USA', '2022', 'Charlie Jane Anders', 'Alberto Alburquerque - Ro Stein - Ted Brandt', './assets/covers_img/889.jpg'),
(890, 'New Mutants', 7, 'Rod Reis', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Rod Reis', './assets/covers_img/890.jpg'),
(891, 'New Mutants', 8, 'Rod Reis', 'Marvel', 'Grapa', 'USA', '2022', 'Ed Brisson', 'Marco Failla', './assets/covers_img/891.jpg'),
(892, 'New Mutants', 9, 'Mike Del Mundo', 'Marvel', 'Grapa', 'USA', '2020', 'Ed Brisson', 'Flaviano', './assets/covers_img/892.jpg'),
(893, 'New Mutants', 10, 'Mike Del Mundo', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Flaviano', './assets/covers_img/893.jpg'),
(894, 'New Mutants', 11, 'Mike Del Mundo', 'Marvel', 'Grapa', 'USA', '2020', 'Ed Brisson', 'Flaviano', './assets/covers_img/894.jpg'),
(895, 'New Mutants', 12, 'Mike Del Mundo', 'Marvel', 'Grapa', 'USA', '2020', 'Ed Brisson', 'Rod Reis', './assets/covers_img/895.jpg'),
(896, 'New Mutants', 13, 'Mike Del Mundo', 'Marvel', 'Grapa', 'USA', '2020', 'Ed Brisson', 'Rod Reis', './assets/covers_img/896.jpg'),
(897, 'New Mutants', 14, 'Rod Reis', 'Marvel', 'Grapa', 'USA', '2020', 'Vita Ayala', 'Rod Reis', './assets/covers_img/897.jpg'),
(898, 'New Mutants', 15, 'Rod Reis', 'Marvel', 'Grapa', 'USA', '2020', 'Vita Ayala', 'Rod Reis', './assets/covers_img/898.jpg'),
(899, 'New Mutants: Lethal Legion', 4, 'Javier Fernandez', 'Marvel', 'Grapa', 'USA', '2023', 'Charlie Jane Anders', 'Enid Balam', './assets/covers_img/899.jpg'),
(900, 'Nimona', 1, 'Noelle Stevenson', 'Editorial Océano', 'Tomo', 'Spain', '2015', 'Noelle Stevenson', 'Noelle Stevenson', './assets/covers_img/900.jpg'),
(901, 'Once upon a time at end of world', 4, 'Mike Del Mundo', 'Boom Studios', 'Grapa', 'USA', '2023', 'Jason Aaron', 'Alexandre Tefenkgi', './assets/covers_img/901.jpg'),
(902, 'Once upon a time at end of world', 2, 'Frany', 'Boom Studios', 'Grapa', 'USA', '2022', 'Jason Aaron', 'Alexandre Tefenkgi', './assets/covers_img/902.jpg'),
(903, 'Once upon a time at end of world', 1, 'Mike Del Mundo', 'Boom Studios', 'Grapa', 'USA', '2022', 'Jason Aaron', 'Alexandre Tefenkgi', './assets/covers_img/903.jpg'),
(904, 'Ones', 4, 'Laura Allred - Michael Allred', 'Dark Horse', 'Grapa', 'USA', '2023', 'Brian Michael Bendis', 'Jacob Edgar', './assets/covers_img/904.jpg'),
(905, 'Ones', 3, 'Jacob Edgar', 'Dark Horse', 'Grapa', 'USA', '2023', 'Brian Michael Bendi', 'Jacob Edgar', './assets/covers_img/905.jpg'),
(906, 'Ones', 2, 'Tyler Boss', 'Dark Horse', 'Grapa', 'USA', '2022', 'Brian Michael Bendis', 'Jacob Edgar', './assets/covers_img/906.jpg'),
(907, 'Ones', 1, 'Jacob Edgar', 'Dark Horse', 'Grapa', 'USA', '2022', 'Brian Michael Bendis', 'Jacob Edgar', './assets/covers_img/907.jpg'),
(908, 'Pantera Negra: Dos mil estaciones', 3, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2020', 'Ta-Nehisi Coates', 'Daniel Acuña', './assets/covers_img/908.jpg'),
(909, 'Pantera Negra: El significado de mi nombre', 2, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Ta-Nehisi Coates', 'Kev Walker', './assets/covers_img/909.jpg'),
(910, 'Pantera Negra: Imperio', 1, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Ta-Nehisi Coates', 'Daniel Acuña', './assets/covers_img/910.jpg'),
(911, 'Pantera Negra: Wakanda desatada', 4, 'Variante de Panini Comics', 'Panini', 'Tomo', 'Spain', '2019', 'Ta-Nehisi Coates', 'Daniel Acuña - Ryan Bodenheim', './assets/covers_img/911.jpg'),
(912, 'Paper Girls Deluxe Edition', 1, 'Matt Wilson', 'Image Comics', 'Tomo', 'USA', '2017', 'Brian K Vaughan', 'Cliff Chiang - Matt Wilson', './assets/covers_img/912.jpg'),
(913, 'Paper Girls Deluxe Edition', 2, 'Matt Wilson', 'Image Comics', 'Tomo', 'USA', '2017', 'Brian K Vaughan', 'Cliff Chiang - Matt Wilson', './assets/covers_img/913.jpg'),
(914, 'Paper Girls Deluxe Edition', 3, 'Matt Wilson', 'Image Comics', 'Tomo', 'USA', '2017', 'Brian K Vaughan', 'Cliff Chiang - Matt Wilson', './assets/covers_img/914.jpg');
INSERT INTO `comics` (`IDcomic`, `nomComic`, `numComic`, `nomVariante`, `nomEditorial`, `Formato`, `Procedencia`, `date_published`, `nomGuionista`, `nomDibujante`, `Cover`) VALUES
(915, 'Patrulla X: Dia del comic gratis', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jonathan Hickman - Tini Howard - Tom Taylor', 'Pepe Larraz - Iban Coello', './assets/covers_img/915.jpg'),
(916, 'Pecado Original: Especial', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2015', 'Jason Latour', 'Enis Cisic', './assets/covers_img/916.jpg'),
(917, 'Pecado Original: Thor y Loki', 44, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron - Al Ewing', 'Lee Garbett - Simone Bianchi', './assets/covers_img/917.jpg'),
(918, 'Pecado Original: Thor y Loki', 42, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron - Al Ewing', 'Lee Garbett - Simone Bianchi', './assets/covers_img/918.jpg'),
(919, 'Pecado Original: Thor y Loki', 43, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron - Al Ewing', 'Lee Garbett - Simone Bianchi', './assets/covers_img/919.jpg'),
(920, 'Periodic Table of marvel', 1, 'Melanie Scott', 'Marvel', 'Tomo', 'USA', '2021', 'Melanie Scott', 'Melanie Scott', './assets/covers_img/920.jpg'),
(921, 'Phantasmagoria Ed. Extendida', 1, 'Joe Bocardo', 'Karras', 'Tomo', 'Spain', '2022', 'El Torres ', 'Joe Bocardo', './assets/covers_img/921.jpg'),
(922, 'Phantom Road', 1, 'Gabriel Hernandez Walta', 'Image Comics', 'Grapa', 'USA', '2023', 'Jeff Lemire', 'Gabriel Hernandez Walta - Jordie Bellaire', './assets/covers_img/922.jpg'),
(923, 'Planet-Size X-Men', 1, 'Pepe Larraz', 'Marvel', 'Grapa', 'USA', '2021', 'Gerry Duggan', 'Pepe Larraz', './assets/covers_img/923.jpg'),
(924, 'Predator', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Ed Brisson', 'Kev Walker', './assets/covers_img/924.jpg'),
(925, 'Predator', 2, 'Natacha Bustos', 'Marvel', 'Grapa', 'USA', '2022', 'Ed Brisson', 'Kev Walker', './assets/covers_img/925.jpg'),
(926, 'Predator', 3, 'Ben Harvey', 'Marvel', 'Grapa', 'USA', '2022', 'Ed Brisson', 'Kev Walker', './assets/covers_img/926.jpg'),
(927, 'Primavera del 68', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Gianfranco Manfredi', 'Gianluca Casalanguida', './assets/covers_img/927.jpg'),
(928, 'Proscritos: Alfa', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', ' Eve L. Ewing', 'Kim Jacinto', './assets/covers_img/928.jpg'),
(929, 'Providence Compendium', 1, 'Jacen Burrows', 'Dark Horse', 'Tomo', 'USA', '2021', 'Alan Moore', 'Jacen Burrows', './assets/covers_img/929.jpg'),
(930, 'Punisher ', 1, 'Parlov', 'Marvel', 'Grapa', 'USA', '2022', 'Jason Aaron', 'Jesus Saiz - Paul Azaceta', './assets/covers_img/930.jpg'),
(931, 'Rayo negro: La colección completa', 1, 'Christian Ward', 'Panini', 'Tomo', 'Spain', '2018', 'Saladin Ahmed', 'Christian Ward', './assets/covers_img/931.jpg'),
(932, 'Reckoning war: Trial of the Watcher', 1, 'Javier Rodriguez', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'Javier Rodriguez', './assets/covers_img/932.jpg'),
(933, 'Reckoning war: Trial of the Watcher', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'Javier Rodriguez', './assets/covers_img/933.jpg'),
(934, 'Reckoning war: Trial of the Watcher', 1, 'Javier Rodriguez', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'Javier Rodriguez', './assets/covers_img/934.jpg'),
(935, 'Rey de Negro', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/935.jpg'),
(936, 'Rey de Negro', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/936.jpg'),
(937, 'Rey de Negro', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/937.jpg'),
(938, 'Rey de Negro: El retorno de las valquirias', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron - Torunn Grønbekk', 'Nina Vakueva', './assets/covers_img/938.jpg'),
(939, 'Rey de Negro: El retorno de las valquirias', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron - Torunn Grønbekk', 'Nina Vakueva', './assets/covers_img/939.jpg'),
(940, 'Rey de Negro: Simbionte Spider-Man ', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Peter David', 'Greg Land', './assets/covers_img/940.jpg'),
(941, 'Rey de Negro: Simbionte Spider-Man ', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Peter David', 'Greg Land', './assets/covers_img/941.jpg'),
(942, 'Rey de Negro: Simbionte Spider-Man ', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Peter David', 'Greg Land', './assets/covers_img/942.jpg'),
(943, 'Rey Thor', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'Esad Ribic', './assets/covers_img/943.jpg'),
(944, 'Rey Thor', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'Esad Ribic', './assets/covers_img/944.jpg'),
(945, 'Rey Thor', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'Esad Ribic', './assets/covers_img/945.jpg'),
(946, 'Rey Thor', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'Esad Ribic', './assets/covers_img/946.jpg'),
(947, 'Savage Spider-Man', 1, 'Nick Bradshaw', 'Marvel', 'Grapa', 'USA', '2022', 'Joe Kelly', 'Gerardo Sandoval', './assets/covers_img/947.jpg'),
(948, 'Savage Spider-Man', 2, 'Ron Lim', 'Marvel', 'Grapa', 'USA', '2022', 'Joe Kelly', 'Gerardo Sandoval', './assets/covers_img/948.jpg'),
(949, 'Savage Spider-Man', 3, 'Mark Bagley', 'Marvel', 'Grapa', 'USA', '2022', 'Joe Kelly', 'Mike Bowden - Gerardo Sandoval', './assets/covers_img/949.jpg'),
(950, 'Savage Spider-Man', 4, 'Jung-Geun Yoon', 'Marvel', 'Grapa', 'USA', '2022', 'Joe Kelly', 'Gerardo Sandoval', './assets/covers_img/950.jpg'),
(951, 'Savage Spider-Man', 5, 'Nick Bradshaw', 'Marvel', 'Grapa', 'USA', '2022', 'Joe Kelly', 'Gerardo Sandoval', './assets/covers_img/951.jpg'),
(952, 'Scarlet Witch', 3, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2023', 'Steve Orlando', 'Sara Pichelli', './assets/covers_img/952.jpg'),
(953, 'Scarlet Witch', 3, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2023', 'Steve Orlando', 'Sara Pichelli', './assets/covers_img/953.jpg'),
(954, 'Scarlet Witch', 2, 'Villa', 'Marvel', 'Grapa', 'USA', '2023', 'VACIO', 'VACIO', './assets/covers_img/954.jpg'),
(955, 'Scarlet Witch', 1, 'Hughes', 'Marvel', 'Grapa', 'USA', '2023', 'Steve Orlando', 'Sara Pichelli', './assets/covers_img/955.jpg'),
(956, 'Secret Invasion', 1, 'Skottie Young', 'Marvel', 'Grapa', 'USA', '2022', 'Ryan North', 'Francesco Mobili', './assets/covers_img/956.jpg'),
(957, 'Secret Wars', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2015', 'Jonathan Hickman', 'Esad Ribic', './assets/covers_img/957.jpg'),
(958, 'Secret Wars', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2015', 'Jonathan Hickman', 'Esad Ribic', './assets/covers_img/958.jpg'),
(959, 'Secret Wars', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2015', 'Jonathan Hickman', 'Esad Ribic', './assets/covers_img/959.jpg'),
(960, 'Secret Wars', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2015', 'Jonathan Hickman', 'Esad Ribic', './assets/covers_img/960.jpg'),
(961, 'Secret Wars', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2015', 'Jonathan Hickman', 'Esad Ribic', './assets/covers_img/961.jpg'),
(962, 'Secret Wars', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2015', 'Jonathan Hickman', 'Esad Ribic', './assets/covers_img/962.jpg'),
(963, 'Secret Wars', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2015', 'Jonathan Hickman', 'Esad Ribic', './assets/covers_img/963.jpg'),
(964, 'Secret Wars', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2015', 'Jonathan Hickman', 'Esad Ribic', './assets/covers_img/964.jpg'),
(965, 'Secret Wars', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2015', 'Jonathan Hickman', 'Esad Ribic', './assets/covers_img/965.jpg'),
(966, 'Secret Wars: Asedio', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2015', 'Kieron Gillen', 'Filipe Andrade', './assets/covers_img/966.jpg'),
(967, 'Secret Wars: Asedio', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2015', 'Kieron Gillen', 'Filipe Andrade', './assets/covers_img/967.jpg'),
(968, 'Secret Wars: Guia de Lectura', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2015', 'Jonathan Hickman', 'Esad Ribic', './assets/covers_img/968.jpg'),
(969, 'Sentient', 1, 'Gabriel Hernández Walta', 'Panini', 'Tomo', 'Spain', '2019', 'Jeff Lemire', 'Gabriel Hernández Walta', './assets/covers_img/969.jpg'),
(970, 'Sentient', 1, 'Gabriel Walta', 'TKO', 'Grapa', 'USA', '2019', 'Jeff Lemire', 'Gabriel Hernández Walta', './assets/covers_img/970.jpg'),
(971, 'Sentient', 2, 'Gabriel Walta', 'TKO', 'Grapa', 'USA', '2019', 'Jeff Lemire', 'Gabriel Hernández Walta', './assets/covers_img/971.jpg'),
(972, 'Sentient', 3, 'Gabriel Walta', 'TKO', 'Grapa', 'USA', '2019', 'Jeff Lemire', 'Gabriel Hernández Walta', './assets/covers_img/972.jpg'),
(973, 'Sentient', 4, 'Gabriel Walta', 'TKO', 'Grapa', 'USA', '2019', 'Jeff Lemire', 'Gabriel Hernández Walta', './assets/covers_img/973.jpg'),
(974, 'Sentient', 5, 'Gabriel Walta', 'TKO', 'Grapa', 'USA', '2019', 'Jeff Lemire', 'Gabriel Hernández Walta', './assets/covers_img/974.jpg'),
(975, 'She-Hulk', 11, 'Yagawa - Rickie', 'Marvel', 'Grapa', 'USA', '2023', 'Rainbow Rowell', 'Genolet - Andres', './assets/covers_img/975.jpg'),
(976, 'She-Hulk', 9, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Rainbow Rowell', 'Takeshi Miyazawa', './assets/covers_img/976.jpg'),
(977, 'She-Hulk', 1, 'Adam Hughes', 'Marvel', 'Grapa', 'USA', '2022', 'Rainbow Rowell', 'Roge Antonia', './assets/covers_img/977.jpg'),
(978, 'She-Hulk', 1, 'Adam Hughes - Jen Bartel', 'Marvel', 'Grapa', 'USA', '2022', 'Rainbow Rowell', 'Roge Antonia', './assets/covers_img/978.jpg'),
(979, 'She-Hulk', 4, 'Jen Bartel', 'Marvel', 'Grapa', 'USA', '2022', 'Rainbow Rowell', 'Roge Antonia', './assets/covers_img/979.jpg'),
(980, 'She-Hulk', 5, 'Jen Bartel', 'Marvel', 'Grapa', 'USA', '2022', 'Rainbow Rowell', 'Roge Antonia', './assets/covers_img/980.jpg'),
(981, 'She-Hulk', 3, 'Bazaldua', 'Marvel', 'Grapa', 'USA', '2022', 'Rainbow Rowell', 'Roge Antonia', './assets/covers_img/981.jpg'),
(982, 'She-Hulk', 4, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2022', 'Rainbow Rowell', 'Roge Antonia', './assets/covers_img/982.jpg'),
(983, 'She-Hulk', 6, 'Jen Bartel', 'Marvel', 'Grapa', 'USA', '2022', 'Rainbow Rowell', 'Luca Maresca', './assets/covers_img/983.jpg'),
(984, 'She-Hulk', 19, 'Greg Horn', 'Marvel', 'Grapa', 'USA', '2007', 'Dan Slott - Ty Templeton', 'Rick Burchett', './assets/covers_img/984.jpg'),
(985, 'She-Hulk', 7, 'Jen Bartel', 'Marvel', 'Grapa', 'USA', '2022', 'Rainbow Rowell', 'Luca Maresca', './assets/covers_img/985.jpg'),
(986, 'She-Hulk', 20, 'John Watson', 'Marvel', 'Grapa', 'USA', '2007', 'Dan Slott - Ty Templeton', 'Rick Burchett', './assets/covers_img/986.jpg'),
(987, 'She-Hulk', 21, 'Greg Horn', 'Marvel', 'Grapa', 'USA', '2007', 'Dan Slott - Ty Templeton', 'Rick Burchett', './assets/covers_img/987.jpg'),
(988, 'She-Hulk', 2, 'Jen Bartel', 'Marvel', 'Grapa', 'USA', '2022', 'Rainbow Rowell', 'Roge Antonia', './assets/covers_img/988.jpg'),
(989, 'She-Hulk', 8, 'Jen Bartel', 'Marvel', 'Grapa', 'USA', '2022', 'Rainbow Rowell ', 'Takeshi Miyazawa', './assets/covers_img/989.jpg'),
(990, 'Silk', 2, 'Audrey Mok', 'Marvel', 'Grapa', 'USA', '2022', 'Emily Kim', 'Takeshi Miyazawa', './assets/covers_img/990.jpg'),
(991, 'Silk', 3, 'Dike Ruan', 'Marvel', 'Grapa', 'USA', '2022', 'Emily Kim', 'Takeshi Miyazawa', './assets/covers_img/991.jpg'),
(992, 'Silk', 4, 'Bengal', 'Marvel', 'Grapa', 'USA', '2022', 'Emily Kim', 'Takeshi Miyazawa', './assets/covers_img/992.jpg'),
(993, 'Silk', 5, 'Neuware', 'Marvel', 'Grapa', 'USA', '2022', 'Emily Kim', 'Takeshi Miyazawa', './assets/covers_img/993.jpg'),
(994, 'Silk', 5, 'In-Hyuk Inhyuk Lee', 'Marvel', 'Grapa', 'USA', '2022', 'Emily Kim', 'Takeshi Miyazawa', './assets/covers_img/994.jpg'),
(995, 'Silk', 1, 'Audrey Mok', 'Marvel', 'Grapa', 'USA', '2022', 'Emily Kim', 'Takeshi Miyazawa', './assets/covers_img/995.jpg'),
(996, 'Silk', 1, 'In-Hyuk Inhyuk Lee', 'Marvel', 'Grapa', 'USA', '2022', 'Emily Kim', 'Takeshi Miyazawa', './assets/covers_img/996.jpg'),
(997, 'Silver Surfer (2016)', 1, 'Mike Allred', 'Marvel', 'Grapa', 'USA', '2016', 'Dan Slott', 'Mike Allred', './assets/covers_img/997.jpg'),
(998, 'Silver Surfer (2016)', 2, 'Michael Allred', 'Marvel', 'Grapa', 'USA', '2016', 'Dan Slott', 'Michael Allred', './assets/covers_img/998.jpg'),
(999, 'Silver Surfer (2016)', 3, 'Mike Allred', 'Marvel', 'Grapa', 'USA', '2016', 'Dan Slott', 'Mike Allred', './assets/covers_img/999.jpg'),
(1000, 'Silver Surfer (2016)', 4, 'Mike Allred', 'Marvel', 'Grapa', 'USA', '2016', 'Dan Slott', 'Mike Allred', './assets/covers_img/1000.jpg'),
(1001, 'Silver Surfer (2016)', 5, 'Mike Allred', 'Marvel', 'Grapa', 'USA', '2016', 'Dan Slott', 'Mike Allred', './assets/covers_img/1001.jpg'),
(1002, 'Silver Surfer (2016)', 7, 'Mike Allred', 'Marvel', 'Grapa', 'USA', '2016', 'Dan Slott', 'Mike Allred', './assets/covers_img/1002.jpg'),
(1003, 'Silver Surfer Rebirth', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Ron Marz', 'Ron Lim', './assets/covers_img/1003.jpg'),
(1004, 'Silver Surfer Rebirth', 1, 'Cheung', 'Marvel', 'Grapa', 'USA', '2022', 'Ron Marz', 'Ron Lim', './assets/covers_img/1004.jpg'),
(1005, 'Silver Surfer Rebirth', 2, 'Charles', 'Marvel', 'Grapa', 'USA', '2022', 'Ron Marz', 'Ron Lim', './assets/covers_img/1005.jpg'),
(1006, 'Silver Surfer Rebirth', 3, 'Talaski', 'Marvel', 'Grapa', 'USA', '2022', 'Ron Marz', 'Ron Lim', './assets/covers_img/1006.jpg'),
(1007, 'Silver Surfer Rebirth', 4, 'Ferry', 'Marvel', 'Grapa', 'USA', '2022', 'Ron Marz', 'Ron Lim', './assets/covers_img/1007.jpg'),
(1008, 'Silver Surfer Rebirth', 5, 'Ron Lim', 'Marvel', 'Grapa', 'USA', '2022', 'Ron Marz', 'Ron Lim', './assets/covers_img/1008.jpg'),
(1009, 'Silver Surfer Vol 3', 10, 'Marshall Rogers', 'Marvel', 'Grapa', 'USA', '1988', 'Steve Englehart', 'Marshall Rogers', './assets/covers_img/1009.jpg'),
(1010, 'Silver Surfer Vol 3', 11, 'Marshall Rogers', 'Marvel', 'Grapa', 'USA', '1988', 'Steve Englehart', 'Joe Staton', './assets/covers_img/1010.jpg'),
(1011, 'Silver Surfer Vol 3', 12, 'Marshall Rogers', 'Marvel', 'Grapa', 'USA', '1988', 'Steve Englehart', 'Marshall Rogers', './assets/covers_img/1011.jpg'),
(1012, 'Silver Surfer Vol 3', 38, 'Marshall Rogers', 'Marvel', 'Grapa', 'USA', '1990', 'Jim Starlin', 'Ron Lim', './assets/covers_img/1012.jpg'),
(1013, 'Silver Surfer Vol 3', 55, 'Ron Lim', 'Marvel', 'Grapa', 'USA', '1991', 'Jim Starlin', 'Ron Lim', './assets/covers_img/1013.jpg'),
(1014, 'Silver Surfer Vol 4', 1, 'Moebius', 'Marvel', 'Grapa', 'USA', '1988', 'Stan Inhyuk Lee', 'Moebius', './assets/covers_img/1014.jpg'),
(1015, 'Silver Surfer Vol 4', 2, 'Moebius', 'Marvel', 'Grapa', 'USA', '1988', 'Stan Inhyuk Lee', 'Moebius', './assets/covers_img/1015.jpg'),
(1016, 'Silver Surfer: Ghost Light', 2, 'Alex Maleev', 'Marvel', 'Grapa', 'USA', '2023', 'John Jennings', 'Valentine De Landro', './assets/covers_img/1016.jpg'),
(1017, 'Silver Surfer: Ghost Light', 1, 'Marco Checchetto', 'Marvel', 'Grapa', 'USA', '2023', 'J. Holtham', 'Sean Damien Hill', './assets/covers_img/1017.jpg'),
(1018, 'Sins of Sinister', 1, 'Francis Yu', 'Marvel', 'Grapa', 'USA', '2023', 'Kieron Gillen', 'Lucas Werneck', './assets/covers_img/1018.jpg'),
(1019, 'Something is killing the children', 1, 'Werther Dell\'Edera', 'Boom Studios', 'Tomo', 'USA', '2023', 'James TynionIV', 'Werther Dell\'Edera', './assets/covers_img/1019.jpg'),
(1020, 'Spider-Gwen', 2, 'Robbi Rodriguez', 'Marvel', 'Tomo', 'USA', '2017', 'Jason Latour', 'Robbi Javier Rodriguez - Bengal', './assets/covers_img/1020.jpg'),
(1021, 'Spider-Gwen', 3, 'Robbi Rodriguez', 'Marvel', 'Tomo', 'USA', '2017', 'Jason Latour', 'Robbi Javier Rodriguez', './assets/covers_img/1021.jpg'),
(1022, 'Spider-Gwen', 1, 'Robbi Rodriguez', 'Marvel', 'Tomo', 'USA', '2017', 'Jason Latour', 'Chris Visions - Robbi Javier Rodriguez', './assets/covers_img/1022.jpg'),
(1023, 'Spider-Gwen Omnibus', 1, 'Robbi Rodriguez', 'Marvel', 'Tomo', 'USA', '2023', ' Jason Latour - Hannah Blumenreich', 'Chris Visions', './assets/covers_img/1023.jpg'),
(1024, 'Spider-Gwen: Gweneverse', 2, 'Land', 'Marvel', 'Grapa', 'USA', '2022', 'Tim Seeley', 'Jodi Nishijima', './assets/covers_img/1024.jpg'),
(1025, 'Spider-Gwen: Gweneverse', 1, 'David Nakayama', 'Marvel', 'Grapa', 'USA', '2022', 'Tim Seeley', 'Jodi Nishijima', './assets/covers_img/1025.jpg'),
(1026, 'Spider-Gwen: Gwenom', 5, 'Robbi Rodriguez', 'Marvel', 'Tomo', 'USA', '2018', 'Jason Latour', 'Robbi Javier Rodriguez', './assets/covers_img/1026.jpg'),
(1027, 'Spider-Gwen: Predators', 4, 'Robbi Rodriguez', 'Marvel', 'Tomo', 'USA', '2017', 'Jason Latour', 'Robbi Rodriquez', './assets/covers_img/1027.jpg'),
(1028, 'Spider-Gwen: Shadow Clones', 1, 'VACIO', 'Marvel', 'Grapa', 'USA', '2023', 'VACIO', 'VACIO', './assets/covers_img/1028.jpg'),
(1029, 'Spider-Gwen: The Life and Times of Gwen Stacy', 6, 'Robbi Rodriguez', 'Marvel', 'Tomo', 'USA', '2018', 'Jason Latour', 'Chris Visions - Robbi Javier Rodriguez', './assets/covers_img/1029.jpg'),
(1030, 'Spider-Man', 17, 'Rick Leonardi', 'Marvel', 'Grapa', 'USA', '1990', 'Ann Nocenti', 'Rick Leonardi', './assets/covers_img/1030.jpg'),
(1031, 'Spider-Man ', 1, 'Mark Bagley', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'Mark Mark Bagley', './assets/covers_img/1031.jpg'),
(1032, 'Spider-Man ', 2, 'Sara Pichelli', 'Marvel', 'Grapa', 'USA', '2016', 'Brian Michael Bendis', 'Sara Pichelli', './assets/covers_img/1032.jpg'),
(1033, 'Spider-Man ', 3, 'Sara Pichelli', 'Marvel', 'Grapa', 'USA', '2016', 'Brian Michael Bendis', 'Sara Pichelli', './assets/covers_img/1033.jpg'),
(1034, 'Spider-Man', 6, 'VACIO', 'Marvel', 'Grapa', 'USA', '2023', 'Dan Slott', 'Mark Bagley', './assets/covers_img/1034.jpg'),
(1035, 'Spider-Man', 4, 'Mark Bagley', 'Marvel', 'Grapa', 'USA', '2023', 'Dan Slott', 'Mark Bagley', './assets/covers_img/1035.jpg'),
(1036, 'Spider-Man', 3, 'Mark Bagley', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'Mark Bagley', './assets/covers_img/1036.jpg'),
(1037, 'Spider-Man', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'J. J. Abrams', 'Henry Abrams - Sara Pichelli', './assets/covers_img/1037.jpg'),
(1038, 'Spider-Man', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'J. J. Abrams', 'Henry Abrams - Sara Pichelli', './assets/covers_img/1038.jpg'),
(1039, 'Spider-Man', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'J. J. Abrams', 'Henry Abrams - Sara Pichelli', './assets/covers_img/1039.jpg'),
(1040, 'Spider-Man', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'J. J. Abrams', 'Henry Abrams - Sara Pichelli', './assets/covers_img/1040.jpg'),
(1041, 'Spider-Man', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'J. J. Abrams', 'Henry Abrams - Sara Pichelli', './assets/covers_img/1041.jpg'),
(1042, 'Spider-Man', 2, 'Mark Bagley', 'Marvel', 'Grapa', 'USA', '2022', 'Dan Slott', 'Mark Bagley', './assets/covers_img/1042.jpg'),
(1043, 'Spider-Man - Simbionte Spider-Man: Humo y espejos', 1, 'Variante de Panini Comics', 'Marvel', 'Tomo', 'Spain', '2020', 'Greg Land - Iban Coello', 'Jay Leisten - Iban Coello', './assets/covers_img/1043.jpg'),
(1044, 'Spider-Man: Dia del comic gratis', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Al Ewing - Ram.V - Zeb Wells', 'Alejandro Sanchez - Patrick Gleason', './assets/covers_img/1044.jpg'),
(1045, 'Spider-Punk', 1, 'Olivier Coipel', 'Marvel', 'Grapa', 'USA', '2022', 'Cody Ziglar', 'Justin Mason', './assets/covers_img/1045.jpg'),
(1046, 'Spider-Punk', 2, 'Takashi Okazaki', 'Marvel', 'Grapa', 'USA', '2022', 'Cody Ziglar', 'Justin Mason', './assets/covers_img/1046.jpg'),
(1047, 'Spider-Punk', 3, 'Takashi Okazaki', 'Marvel', 'Grapa', 'USA', '2022', 'Cody Ziglar', 'Justin Mason', './assets/covers_img/1047.jpg'),
(1048, 'Spider-Punk', 4, 'Takashi Okazaki', 'Marvel', 'Grapa', 'USA', '2022', 'Cody Ziglar', 'Justin Mason', './assets/covers_img/1048.jpg'),
(1049, 'Spider-Punk', 5, 'Takashi Okazaki', 'Marvel', 'Grapa', 'USA', '2022', 'Cody Ziglar', 'Justin Mason', './assets/covers_img/1049.jpg'),
(1050, 'Star Trek: Picard - Stargazer', 1, 'Levens', 'Marvel', 'Grapa', 'USA', '2022', 'Mike Johnson - Kirsten Beyer', 'Angel Hernandez', './assets/covers_img/1050.jpg'),
(1051, 'Star Wars: The Mandalorian', 4, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Rodney Barnes', 'Georges Jeanty', './assets/covers_img/1051.jpg'),
(1052, 'Star Wars: The Mandalorian', 1, 'TBA', 'Marvel', 'Grapa', 'USA', '2022', 'Rodney Barnes', 'Georges Jeanty', './assets/covers_img/1052.jpg'),
(1053, 'Star Wars: Visions', 1, 'Takashi Okazaki', 'Marvel', 'Grapa', 'Spain', '2022', 'Takashi Okazaki', 'Takashi Okazaki', './assets/covers_img/1053.jpg'),
(1054, 'Storm & The Brotherhood of Mutants', 2, 'Leinil Yu', 'Marvel', 'Grapa', 'USA', '2023', 'Al Ewing', 'Andrea Di Vito', './assets/covers_img/1054.jpg'),
(1055, 'Storm & The Brotherhood of Mutants', 1, 'Casagrande', 'Marvel', 'Grapa', 'USA', '2023', 'Al Ewing', 'Paco Medina', './assets/covers_img/1055.jpg'),
(1056, 'Strange', 4, 'Lee Garbett', 'Marvel', 'Grapa', 'USA', '2022', 'Jed Mackay', 'Marcelo Ferreira', './assets/covers_img/1056.jpg'),
(1057, 'Strange', 5, 'Lee Garbett', 'Marvel', 'Grapa', 'USA', '2022', 'Jed Mackay', 'Marcelo Ferreira', './assets/covers_img/1057.jpg'),
(1058, 'Strange', 3, 'Bjorn Barends', 'Marvel', 'Grapa', 'USA', '2022', 'Jed Mackay', 'Marcelo Ferreira', './assets/covers_img/1058.jpg'),
(1059, 'Strange', 8, 'Lee Garbett', 'Marvel', 'Grapa', 'USA', '2022', 'Jed MacKay', 'Marcelo Ferreira', './assets/covers_img/1059.jpg'),
(1060, 'Strange', 10, 'Iban Coello', 'Marvel', 'Grapa', 'USA', '2023', 'Jed MacKay', 'Marcelo Ferreira', './assets/covers_img/1060.jpg'),
(1061, 'Strange', 9, 'Lee Garbett', 'Marvel', 'Grapa', 'Spain', '2022', 'Jed MacKay', 'Marcelo Ferreira', './assets/covers_img/1061.jpg'),
(1062, 'Strange', 1, 'Artgerm', 'Marvel', 'Grapa', 'Spain', '2022', 'Jed Mackay', 'Marcelo Ferreira', './assets/covers_img/1062.jpg'),
(1063, 'Strange', 1, 'Bjorn Barends', 'Marvel', 'Grapa', 'USA', '2022', 'Jed Mackay', 'Marcelo Ferreira', './assets/covers_img/1063.jpg'),
(1064, 'Strange', 2, 'Bjorn Barends', 'Marvel', 'Grapa', 'USA', '2022', 'Jed Mackay', 'Marcelo Ferreira', './assets/covers_img/1064.jpg'),
(1065, 'Strange', 6, 'Lee Garbett', 'Marvel', 'Grapa', 'USA', '2022', 'Jed Mackay', 'Inhyuk Lee Garbett', './assets/covers_img/1065.jpg'),
(1066, 'Strange', 7, 'Lee Garbett', 'Marvel', 'Grapa', 'USA', '2022', 'Jed Mackay', 'Marcelo Ferreira', './assets/covers_img/1066.jpg'),
(1067, 'Superman Son of Kal-El', 5, '5B', 'DC', 'Grapa', 'USA', '2021', 'Tom Taylor', 'John Timms ', './assets/covers_img/1067.jpg'),
(1068, 'Superman Son of Kal-El', 5, '2ND', 'DC', 'Grapa', 'USA', '2021', 'Tom Taylor', 'John Timms ', './assets/covers_img/1068.jpg'),
(1069, 'Superman Son of Kal-El', 5, 'John Timms', 'DC', 'Grapa', 'USA', '2021', 'Tom Taylor', 'John Timms ', './assets/covers_img/1069.jpg'),
(1070, 'Thanos: Death Notes', 1, 'Andrea Sorrentino', 'Marvel', 'Grapa', 'USA', '2022', 'Christopher Cantwell - J. Michael Straczynski', 'Ron Lim - Andrea DiVito', './assets/covers_img/1070.jpg'),
(1071, 'Thanos: Infinity Abyss', 1, 'Jim Starlin', 'Marvel', 'Grapa', 'USA', '2002', 'Jim Starlin', 'Jim Starlin', './assets/covers_img/1071.jpg'),
(1072, 'The infinity gauntlet', 5, 'Jim Starlin', 'Marvel', 'Grapa', 'USA', '1991', 'Jim Starlin', 'George Perez', './assets/covers_img/1072.jpg'),
(1073, 'The infinity gauntlet', 6, 'Jim Starlin', 'Marvel', 'Grapa', 'USA', '1991', 'Jim Starlin', 'George Perez', './assets/covers_img/1073.jpg'),
(1074, 'The infinity gauntlet', 3, 'Jim Starlin', 'Marvel', 'Grapa', 'USA', '1991', 'Jim Starlin', 'George Perez', './assets/covers_img/1074.jpg'),
(1075, 'The infinity gauntlet', 4, 'Jim Starlin', 'Marvel', 'Grapa', 'USA', '1991', 'Jim Starlin', 'George Perez', './assets/covers_img/1075.jpg'),
(1076, 'The infinity gauntlet', 1, 'Jim Starlin', 'Marvel', 'Grapa', 'USA', '1991', 'Jim Starlin', 'George Perez', './assets/covers_img/1076.jpg'),
(1077, 'The infinity gauntlet', 1, 'Jim Starlin', 'Marvel', 'Grapa', 'USA', '1991', 'Jim Starlin', 'George Perez', './assets/covers_img/1077.jpg'),
(1078, 'The infinity gauntlet', 2, 'Jim Starlin', 'Marvel', 'Grapa', 'USA', '1991', 'Jim Starlin', 'George Perez', './assets/covers_img/1078.jpg'),
(1079, 'The Infinity War', 5, 'Ron Lim', 'Marvel', 'Grapa', 'USA', '1992', 'Jim Starlin', 'Ron Lim', './assets/covers_img/1079.jpg'),
(1080, 'The nice house of the Lake', 1, 'Variante de Panini Comics', 'ECC', 'Tomo', 'Spain', '2022', 'James Tynion IV', 'Alvaro Martinez', './assets/covers_img/1080.jpg'),
(1081, 'The Nice House on the Lake', 8, 'Alvaro Martinez', 'DC', 'Grapa', 'USA', '2021', 'James Tynion', 'Alvaro Martinez', './assets/covers_img/1081.jpg'),
(1082, 'The Nice House on the Lake', 3, 'Variante de Panini Comics', 'DC', 'Grapa', 'Spain', '2021', 'James Tynion', 'Alvaro Martinez', './assets/covers_img/1082.jpg'),
(1083, 'The Nice House on the Lake', 6, 'Variante de Panini Comics', 'DC', 'Grapa', 'Spain', '2021', 'James Tynion', 'Alvaro Martinez', './assets/covers_img/1083.jpg'),
(1084, 'The Nice House on the Lake', 5, 'Variante de Panini Comics', 'DC', 'Grapa', 'Spain', '2021', 'James Tynion', 'Alvaro Martinez', './assets/covers_img/1084.jpg'),
(1085, 'The Nice House on the Lake', 4, 'Variante de Panini Comics', 'DC', 'Grapa', 'Spain', '2021', 'James Tynion', 'Alvaro Martinez', './assets/covers_img/1085.jpg'),
(1086, 'The Nice House on the Lake', 9, 'Alvaro Martinez', 'DC', 'Grapa', 'USA', '2021', 'James Tynion', 'Alvaro Martinez', './assets/covers_img/1086.jpg'),
(1087, 'The Nice House on the Lake', 1, 'Alvaro Martinez', 'DC', 'Grapa', 'USA', '2021', 'James Tynion', 'Alvaro Martinez', './assets/covers_img/1087.jpg'),
(1088, 'The Nice House on the Lake', 2, 'Alvaro Martinez', 'DC', 'Grapa', 'USA', '2021', 'James Tynion', 'Alvaro Martinez', './assets/covers_img/1088.jpg'),
(1089, 'The Nice House on the Lake', 12, 'Alvaro Martinez', 'DC', 'Grapa', 'USA', '2022', 'James Tynion', 'Alvaro Martinez', './assets/covers_img/1089.jpg'),
(1090, 'Thor', 28, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2023', 'Donny Cates', 'Salvador Larroca', './assets/covers_img/1090.jpg'),
(1091, 'Thor', 27, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Donny Cates', 'Salvador Larroca', './assets/covers_img/1091.jpg'),
(1092, 'Thor', 26, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Donny Cates', 'Martin Coccolo', './assets/covers_img/1092.jpg'),
(1093, 'Thor', 20, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1093.jpg'),
(1094, 'Thor', 16, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1094.jpg'),
(1095, 'Thor', 25, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Donny Cates', 'Martin Coccolo', './assets/covers_img/1095.jpg'),
(1096, 'Thor', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1096.jpg'),
(1097, 'Thor', 10, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1097.jpg'),
(1098, 'Thor', 11, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1098.jpg'),
(1099, 'Thor', 12, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1099.jpg'),
(1100, 'Thor', 13, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1100.jpg'),
(1101, 'Thor', 14, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1101.jpg'),
(1102, 'Thor', 15, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1102.jpg'),
(1103, 'Thor', 21, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1103.jpg'),
(1104, 'Thor', 22, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1104.jpg'),
(1105, 'Thor', 31, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Donny Cates', 'Nic Klein', './assets/covers_img/1105.jpg'),
(1106, 'Thor', 23, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1106.jpg'),
(1107, 'Thor', 24, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1107.jpg'),
(1108, 'Thor', 23, '2ND', 'Marvel', 'Grapa', 'USA', '2022', 'Donny Cates', 'Nic Klein', './assets/covers_img/1108.jpg'),
(1109, 'Thor', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Donny Cates', 'Nic Klein', './assets/covers_img/1109.jpg'),
(1110, 'Thor', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1110.jpg'),
(1111, 'Thor', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1111.jpg'),
(1112, 'Thor', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1112.jpg'),
(1113, 'Thor', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1113.jpg'),
(1114, 'Thor', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1114.jpg'),
(1115, 'Thor', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1115.jpg'),
(1116, 'Thor', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1116.jpg'),
(1117, 'Thor', 17, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1117.jpg'),
(1118, 'Thor', 18, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1118.jpg'),
(1119, 'Thor', 19, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Donny Cates', 'Michele Bandini', './assets/covers_img/1119.jpg'),
(1120, 'Thor - la diosa del trueno', 86, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1120.jpg'),
(1121, 'Thor - la diosa del trueno', 87, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1121.jpg'),
(1122, 'Thor - la diosa del trueno', 88, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1122.jpg'),
(1123, 'Thor - la diosa del trueno', 46, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1123.jpg'),
(1124, 'Thor - la diosa del trueno', 47, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1124.jpg'),
(1125, 'Thor - la diosa del trueno', 48, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1125.jpg'),
(1126, 'Thor - la diosa del trueno', 49, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1126.jpg'),
(1127, 'Thor - la diosa del trueno', 50, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1127.jpg'),
(1128, 'Thor - la diosa del trueno', 51, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1128.jpg'),
(1129, 'Thor - la diosa del trueno', 52, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1129.jpg'),
(1130, 'Thor - la diosa del trueno', 53, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1130.jpg'),
(1131, 'Thor - la diosa del trueno', 54, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1131.jpg'),
(1132, 'Thor - la diosa del trueno', 55, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1132.jpg'),
(1133, 'Thor - la diosa del trueno', 56, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1133.jpg'),
(1134, 'Thor - la diosa del trueno', 57, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1134.jpg'),
(1135, 'Thor - la diosa del trueno', 58, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1135.jpg'),
(1136, 'Thor - la diosa del trueno', 59, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1136.jpg'),
(1137, 'Thor - la diosa del trueno', 60, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1137.jpg'),
(1138, 'Thor - la diosa del trueno', 61, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1138.jpg'),
(1139, 'Thor - la diosa del trueno', 62, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1139.jpg'),
(1140, 'Thor - la diosa del trueno', 63, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1140.jpg'),
(1141, 'Thor - la diosa del trueno', 64, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1141.jpg'),
(1142, 'Thor - la diosa del trueno', 65, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1142.jpg'),
(1143, 'Thor - la diosa del trueno', 66, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1143.jpg'),
(1144, 'Thor - la diosa del trueno', 67, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1144.jpg'),
(1145, 'Thor - la diosa del trueno', 68, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1145.jpg'),
(1146, 'Thor - la diosa del trueno', 69, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1146.jpg'),
(1147, 'Thor - la diosa del trueno', 70, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1147.jpg'),
(1148, 'Thor - la diosa del trueno', 71, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1148.jpg'),
(1149, 'Thor - la diosa del trueno', 72, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1149.jpg'),
(1150, 'Thor - la diosa del trueno', 73, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1150.jpg'),
(1151, 'Thor - la diosa del trueno', 74, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1151.jpg'),
(1152, 'Thor - la diosa del trueno', 75, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1152.jpg'),
(1153, 'Thor - la diosa del trueno', 76, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1153.jpg'),
(1154, 'Thor - la diosa del trueno', 79, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1154.jpg'),
(1155, 'Thor - la diosa del trueno', 80, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1155.jpg'),
(1156, 'Thor - la diosa del trueno', 81, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1156.jpg'),
(1157, 'Thor - la diosa del trueno', 82, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1157.jpg'),
(1158, 'Thor - la diosa del trueno', 83, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1158.jpg'),
(1159, 'Thor - la diosa del trueno', 84, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1159.jpg'),
(1160, 'Thor - la diosa del trueno', 85, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2014', 'Jason Aaron', 'Jorge Molina', './assets/covers_img/1160.jpg'),
(1161, 'Thor Los dignos', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Tom DeFalco', 'Walter Simonson - Ron Frenz', './assets/covers_img/1161.jpg'),
(1162, 'Thor: El dios del trueno renacido', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1162.jpg'),
(1163, 'Thor: El dios del trueno renacido', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1163.jpg'),
(1164, 'Thor: El dios del trueno renacido', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1164.jpg'),
(1165, 'Thor: El dios del trueno renacido', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1165.jpg'),
(1166, 'Thor: El dios del trueno renacido', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1166.jpg'),
(1167, 'Thor: El dios del trueno renacido', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1167.jpg'),
(1168, 'Thor: El dios del trueno renacido', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1168.jpg'),
(1169, 'Thor: El dios del trueno renacido', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1169.jpg'),
(1170, 'Thor: El dios del trueno renacido', 10, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1170.jpg'),
(1171, 'Thor: El dios del trueno renacido', 11, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1171.jpg'),
(1172, 'Thor: El dios del trueno renacido', 12, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1172.jpg'),
(1173, 'Thor: El dios del trueno renacido', 13, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1173.jpg'),
(1174, 'Thor: El dios del trueno renacido', 14, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1174.jpg'),
(1175, 'Thor: El dios del trueno renacido', 15, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Italia', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1175.jpg'),
(1176, 'Thor: El dios del trueno renacido', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1176.jpg'),
(1177, 'Thor: El dios del trueno renacido', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Michael Del Mundo', './assets/covers_img/1177.jpg'),
(1178, 'Thor: El indigno', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Olivier Coipel', './assets/covers_img/1178.jpg'),
(1179, 'Thor: El indigno', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2016', 'Jason Aaron', 'Olivier Coipel', './assets/covers_img/1179.jpg'),
(1180, 'Timeless', 1, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2022', 'Jed MacKay', 'Greg Land - Patch Zircher - Salvador Larroca', './assets/covers_img/1180.jpg'),
(1181, 'Timeless', 1, 'R. B. Silva', 'Marvel', 'Grapa', 'USA', '2021', 'Jed Mackay', 'Kev Walker - Greg Land - Mark Mark Bagley', './assets/covers_img/1181.jpg'),
(1182, 'Timeless', 1, 'Cassar', 'Marvel', 'Grapa', 'USA', '2021', 'Jed Mackay', 'Kev Walker - Greg Land - Mark Mark Bagley', './assets/covers_img/1182.jpg'),
(1183, 'Timeless', 1, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2021', 'Jed Mackay', 'Kev Walker - Greg Land - Mark Mark Bagley', './assets/covers_img/1183.jpg'),
(1184, 'Timeless', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2021', 'Jed Mackay', 'Kev Walker - Greg Land - Mark Mark Bagley', './assets/covers_img/1184.jpg'),
(1185, 'Timeless', 1, 'Kael Ngu', 'Marvel', 'Grapa', 'USA', '2021', 'Jed Mackay', 'Kev Walker - Greg Land - Mark Mark Bagley', './assets/covers_img/1185.jpg'),
(1186, 'Tony Stark Iron man', 14, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Valerio Schiti', './assets/covers_img/1186.jpg'),
(1187, 'Tony Stark Iron man', 10, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Valerio Schiti', './assets/covers_img/1187.jpg'),
(1188, 'Tony Stark Iron man', 11, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Valerio Schiti', './assets/covers_img/1188.jpg'),
(1189, 'Tony Stark Iron man', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Valerio Schiti', './assets/covers_img/1189.jpg'),
(1190, 'Tony Stark Iron man', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Valerio Schiti', './assets/covers_img/1190.jpg'),
(1191, 'Tony Stark Iron man', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Valerio Schiti', './assets/covers_img/1191.jpg'),
(1192, 'Tony Stark Iron man', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Valerio Schiti', './assets/covers_img/1192.jpg'),
(1193, 'Tony Stark Iron man', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Valerio Schiti', './assets/covers_img/1193.jpg'),
(1194, 'Tony Stark Iron man', 12, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Valerio Schiti', './assets/covers_img/1194.jpg'),
(1195, 'Tony Stark Iron man', 13, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Valerio Schiti', './assets/covers_img/1195.jpg'),
(1196, 'Tony Stark Iron man', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Valerio Schiti', './assets/covers_img/1196.jpg'),
(1197, 'Tony Stark Iron man', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Valerio Schiti', './assets/covers_img/1197.jpg'),
(1198, 'Tony Stark Iron man', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Valerio Schiti', './assets/covers_img/1198.jpg'),
(1199, 'Tony Stark Iron man', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Dan Slott', 'Valerio Schiti', './assets/covers_img/1199.jpg'),
(1200, 'Ultimate Integral - Miles morales: El nuevo Spider-Man', 1, 'Variante de Panini Comics', 'Marvel', 'Tomo', 'Spain', '2018', 'Brian Michael Bendis', 'Sara Pichelli - Chris Samnee y David Marquez', './assets/covers_img/1200.jpg'),
(1201, 'Ultimate Integral - Miles Morales: La guerra de Veneno', 3, 'Variante de Panini Comics', 'Marvel', 'Tomo', 'Spain', '2021', 'Brian Michael Bendis', 'Sara Pichelli - David Marquez', './assets/covers_img/1201.jpg'),
(1202, 'Ultimate Integral - Miles Morales: Spider-Man', 2, 'Variante de Panini Comics', 'Marvel', 'Tomo', 'Spain', '2020', 'Brian Michael Bendis', 'Sara Pichelli - David Marquez - Pepe Larraz', './assets/covers_img/1202.jpg'),
(1203, 'Vagabond - Volume 1: Invincible Under the Sun', 1, 'Takehiko Inoue', 'Simon And Sch UK', 'Tomo', 'USA', '2014', 'Takehiko Inoue', 'Takehiko Inoue', './assets/covers_img/1203.jpg'),
(1204, 'Valquiria: Jane foster', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron - Al Ewing', 'Cafu', './assets/covers_img/1204.jpg'),
(1205, 'Valquiria: Jane foster', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron - Al Ewing', 'Cafu', './assets/covers_img/1205.jpg'),
(1206, 'Valquiria: Jane foster', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron - Al Ewing', 'Cafu', './assets/covers_img/1206.jpg'),
(1207, 'Valquiria: Jane foster', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron - Al Ewing', 'Cafu', './assets/covers_img/1207.jpg'),
(1208, 'Valquiria: Jane foster', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron - Al Ewing', 'Cafu', './assets/covers_img/1208.jpg'),
(1209, 'Valquiria: Jane foster', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron - Al Ewing', 'Cafu', './assets/covers_img/1209.jpg'),
(1210, 'Valquiria: Jane foster', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron - Al Ewing', 'Cafu', './assets/covers_img/1210.jpg'),
(1211, 'Valquiria: Jane foster', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron - Al Ewing', 'Cafu', './assets/covers_img/1211.jpg'),
(1212, 'Valquiria: Jane foster', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron - Al Ewing', 'Cafu', './assets/covers_img/1212.jpg'),
(1213, 'Vanish', 5, 'Ryan Stegman', 'Image Comics', 'Grapa', 'USA', '2023', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1213.jpg'),
(1214, 'Vanish', 4, 'Ryan Stegman', 'Image Comics', 'Grapa', 'USA', '2022', 'Al Ewing', 'Ryan Stegman', './assets/covers_img/1214.jpg'),
(1215, 'Vanish', 1, 'Ryan Stegman', 'Image Comics', 'Grapa', 'USA', '2022', 'Donny Cates', 'J. P. Mayer - Sonia Oback - John J. Hill', './assets/covers_img/1215.jpg'),
(1216, 'Vanish', 1, 'Daniel Warren Johnson', 'Image Comics', 'Grapa', 'USA', '2022', 'Donny Cates', 'J. P. Mayer - Sonia Oback - John J. Hill', './assets/covers_img/1216.jpg'),
(1217, 'Vanish', 2, 'Daniel Warren Johnson', 'Image Comics', 'Grapa', 'USA', '2022', 'Donny Cates', 'J. P. Mayer - Sonia Oback - John J. Hill', './assets/covers_img/1217.jpg'),
(1218, 'Vanish', 3, 'Daniel Warren Johnson', 'Image Comics', 'Grapa', 'USA', '2022', 'Chris Claremont', 'Ryan Stegman - J. P. Mayer - Sonia Oback - John J. Hill', './assets/covers_img/1218.jpg'),
(1219, 'Veneno', 10, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1219.jpg'),
(1220, 'Veneno', 11, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1220.jpg'),
(1221, 'Veneno', 12, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1221.jpg'),
(1222, 'Veneno', 13, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1222.jpg'),
(1223, 'Veneno', 14, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1223.jpg'),
(1224, 'Veneno', 15, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1224.jpg'),
(1225, 'Veneno', 16, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1225.jpg'),
(1226, 'Veneno', 17, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1226.jpg'),
(1227, 'Veneno', 18, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1227.jpg'),
(1228, 'Veneno', 19, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1228.jpg'),
(1229, 'Veneno', 20, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1229.jpg'),
(1230, 'Veneno', 21, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1230.jpg'),
(1231, 'Veneno', 22, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1231.jpg'),
(1232, 'Veneno', 23, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1232.jpg'),
(1233, 'Veneno', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1233.jpg'),
(1234, 'Veneno', 29, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1234.jpg');
INSERT INTO `comics` (`IDcomic`, `nomComic`, `numComic`, `nomVariante`, `nomEditorial`, `Formato`, `Procedencia`, `date_published`, `nomGuionista`, `nomDibujante`, `Cover`) VALUES
(1235, 'Veneno', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1235.jpg'),
(1236, 'Veneno', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1236.jpg'),
(1237, 'Veneno', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1237.jpg'),
(1238, 'Veneno', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1238.jpg'),
(1239, 'Veneno', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1239.jpg'),
(1240, 'Veneno', 24, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1240.jpg'),
(1241, 'Veneno', 26, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1241.jpg'),
(1242, 'Veneno', 27, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1242.jpg'),
(1243, 'Veneno', 30, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1243.jpg'),
(1244, 'Veneno', 31, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1244.jpg'),
(1245, 'Veneno', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1245.jpg'),
(1246, 'Veneno', 25, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1246.jpg'),
(1247, 'Veneno', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1247.jpg'),
(1248, 'Veneno', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1248.jpg'),
(1249, 'Veneno', 28, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Donny Cates', 'Ryan Stegman', './assets/covers_img/1249.jpg'),
(1250, 'Veneno: El fin', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Adam Warren', 'Jeffrey “Chamba” Cruz', './assets/covers_img/1250.jpg'),
(1251, 'Vengadores', 45, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2023', 'Jason Aaron - Greg Land', 'Mark Russell - Aaron Kuder', './assets/covers_img/1251.jpg'),
(1252, 'Vengadores', 31, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1252.jpg'),
(1253, 'Vengadores', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Sara Pichelli', './assets/covers_img/1253.jpg'),
(1254, 'Vengadores', 2, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Sara Pichelli', './assets/covers_img/1254.jpg'),
(1255, 'Vengadores', 3, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Sara Pichelli', './assets/covers_img/1255.jpg'),
(1256, 'Vengadores', 4, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Sara Pichelli', './assets/covers_img/1256.jpg'),
(1257, 'Vengadores', 22, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1257.jpg'),
(1258, 'Vengadores', 23, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1258.jpg'),
(1259, 'Vengadores', 29, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1259.jpg'),
(1260, 'Vengadores', 30, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1260.jpg'),
(1261, 'Vengadores', 9, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'David Marquez', './assets/covers_img/1261.jpg'),
(1262, 'Vengadores', 10, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'David Marquez', './assets/covers_img/1262.jpg'),
(1263, 'Vengadores', 11, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'David Marquez', './assets/covers_img/1263.jpg'),
(1264, 'Vengadores', 12, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'David Marquez', './assets/covers_img/1264.jpg'),
(1265, 'Vengadores', 13, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'David Marquez', './assets/covers_img/1265.jpg'),
(1266, 'Vengadores', 37, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1266.jpg'),
(1267, 'Vengadores', 28, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1267.jpg'),
(1268, 'Vengadores', 40, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1268.jpg'),
(1269, 'Vengadores', 17, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron', 'Stefano Caselli', './assets/covers_img/1269.jpg'),
(1270, 'Vengadores', 18, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron', 'Stefano Caselli', './assets/covers_img/1270.jpg'),
(1271, 'Vengadores', 19, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron', 'Gerardo Zaffino', './assets/covers_img/1271.jpg'),
(1272, 'Vengadores', 20, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron', 'Gerardo Zaffino', './assets/covers_img/1272.jpg'),
(1273, 'Vengadores', 21, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron', 'Gerardo Zaffino', './assets/covers_img/1273.jpg'),
(1274, 'Vengadores', 38, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1274.jpg'),
(1275, 'Vengadores', 39, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1275.jpg'),
(1276, 'Vengadores', 24, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1276.jpg'),
(1277, 'Vengadores', 25, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1277.jpg'),
(1278, 'Vengadores', 26, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1278.jpg'),
(1279, 'Vengadores', 27, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1279.jpg'),
(1280, 'Vengadores', 5, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Sara Pichelli', './assets/covers_img/1280.jpg'),
(1281, 'Vengadores', 6, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2018', 'Jason Aaron', 'Sara Pichelli', './assets/covers_img/1281.jpg'),
(1282, 'Vengadores', 41, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1282.jpg'),
(1283, 'Vengadores', 44, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Jason Aaron', 'Kev Walker - Aaron Kuder', './assets/covers_img/1283.jpg'),
(1284, 'Vengadores', 42, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Jason Aaron', 'Javier Garrón - Aaron Kuder', './assets/covers_img/1284.jpg'),
(1285, 'Vengadores', 43, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1285.jpg'),
(1286, 'Vengadores', 7, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'David Marquez', './assets/covers_img/1286.jpg'),
(1287, 'Vengadores', 8, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2019', 'Jason Aaron', 'David Marquez', './assets/covers_img/1287.jpg'),
(1288, 'Vengadores', 32, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2021', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1288.jpg'),
(1289, 'Vengadores', 33, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1289.jpg'),
(1290, 'Vengadores', 34, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1290.jpg'),
(1291, 'Vengadores', 35, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1291.jpg'),
(1292, 'Vengadores', 36, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2022', 'Jason Aaron', 'Javier Garrón', './assets/covers_img/1292.jpg'),
(1293, 'Vengadores', 14, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron', 'Stefano Caselli', './assets/covers_img/1293.jpg'),
(1294, 'Vengadores', 15, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron', 'Stefano Caselli', './assets/covers_img/1294.jpg'),
(1295, 'Vengadores', 16, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Jason Aaron', 'Stefano Caselli', './assets/covers_img/1295.jpg'),
(1296, 'Vengadores: Dia del comic gratis', 1, 'Variante de Panini Comics', 'Panini', 'Grapa', 'Spain', '2020', 'Donny Cates - Jason Aaron', 'Frank Martin - Ryan Ottley', './assets/covers_img/1296.jpg'),
(1297, 'Venom', 3, 'Bryan Hitch', 'Marvel', 'Grapa', 'USA', '2021', 'Ram. V. - Al Ewing', 'Bryan Hitch', './assets/covers_img/1297.jpg'),
(1298, 'Venom', 9, 'Bryan Hitch', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Bryan Hitch', './assets/covers_img/1298.jpg'),
(1299, 'Venom', 10, 'Siqueira', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Bryan Hitch', './assets/covers_img/1299.jpg'),
(1300, 'Venom', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2021', 'Ram. V. - Al Ewing', 'Bryan Hitch', './assets/covers_img/1300.jpg'),
(1301, 'Venom', 4, 'Bryan Hitch', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V. - Al Ewing', 'Bryan Hitch', './assets/covers_img/1301.jpg'),
(1302, 'Venom', 5, 'Bryan Hitch', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V. - Al Ewing', 'Bryan Hitch', './assets/covers_img/1302.jpg'),
(1303, 'Venom', 6, 'Mark Bagley', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V. - Al Ewing', 'Bryan Hitch', './assets/covers_img/1303.jpg'),
(1304, 'Venom', 11, 'Siqueira', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V.', 'Bryan Hitch', './assets/covers_img/1304.jpg'),
(1305, 'Venom', 13, 'Bryan Hitch', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Bryan Hitch', './assets/covers_img/1305.jpg'),
(1306, 'Venom', 4, 'Yardin', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V. - Al Ewing', 'Bryan Hitch', './assets/covers_img/1306.jpg'),
(1307, 'Venom', 17, 'Bryan Hitch', 'Marvel', 'Grapa', 'USA', '2023', 'Al Ewing', 'Bryan Hitch', './assets/covers_img/1307.jpg'),
(1308, 'Venom', 16, 'Martin Coccolo', 'Marvel', 'Grapa', 'USA', '2023', 'Al Ewing', 'VACIO', './assets/covers_img/1308.jpg'),
(1309, 'Venom', 15, 'Bryan Hitch', 'Marvel', 'Grapa', 'USA', '2023', 'Al Ewing', 'Bryan Hitch', './assets/covers_img/1309.jpg'),
(1310, 'Venom', 14, 'Salvador Larroca', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Bryan Hitch', './assets/covers_img/1310.jpg'),
(1311, 'Venom', 12, 'Bryan Hitch', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V.', 'Bryan Hitch', './assets/covers_img/1311.jpg'),
(1312, 'Venom', 34, 'Iban Coello', 'Marvel', 'Grapa', 'USA', '2020', 'Donny Cates', 'Iban Coello', './assets/covers_img/1312.jpg'),
(1313, 'Venom', 7, 'Bryan Hitch', 'Marvel', 'Grapa', 'USA', '2022', 'Ram. V. - Al Ewing', 'Bryan Hitch', './assets/covers_img/1313.jpg'),
(1314, 'Venom', 8, 'Bryan Hitch', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Bryan Hitch', './assets/covers_img/1314.jpg'),
(1315, 'Venom', 1, 'Gabriele Dell\'otto', 'Marvel', 'Grapa', 'USA', '2021', 'Ram. V. - Al Ewing', 'Bryan Hitch', './assets/covers_img/1315.jpg'),
(1316, 'Venom', 2, 'Bryan Hitch', 'Marvel', 'Grapa', 'USA', '2021', 'Ram. V. - Al Ewing', 'Bryan Hitch', './assets/covers_img/1316.jpg'),
(1317, 'Venom HC', 2, 'Iban Coello', 'Marvel', 'Tomo', 'USA', '2022', 'Donny Cates - Mark Bagley', 'Juan Gedeon - Iban Coello - Ryan Stegman', './assets/covers_img/1317.jpg'),
(1318, 'Venom HC', 3, 'Iban Coello', 'Marvel', 'Tomo', 'USA', '2022', 'Donny Cates', 'Juan Gedeon - Iban Coello- Ryan Stegman', './assets/covers_img/1318.jpg'),
(1319, 'Venom HC', 1, 'Iban Coello', 'Marvel', 'Tomo', 'USA', '2021', 'Donny Cates', 'Ryan Stegman - Iban Coello', './assets/covers_img/1319.jpg'),
(1320, 'Venom: Lethal Protector', 5, 'Paulo Siqueira', 'Marvel', 'Grapa', 'USA', '2022', 'David Michelinie', 'Ivan Fiorelli', './assets/covers_img/1320.jpg'),
(1321, 'Venom: Lethal Protector', 1, 'Bill Sienkiewicz', 'Marvel', 'Grapa', 'USA', '2022', 'David Michelinie', 'Ivan Fiorelli - Ken Ken Lashley', './assets/covers_img/1321.jpg'),
(1322, 'Venom: Lethal Protector', 3, 'Paulo Siqueira', 'Marvel', 'Grapa', 'USA', '2022', 'David Michelinie', 'Ivan Fiorelli', './assets/covers_img/1322.jpg'),
(1323, 'Venom: Lethal Protector', 4, 'Paulo Siqueira', 'Marvel', 'Grapa', 'USA', '2022', 'David Michelinie', 'Ivan Fiorelli', './assets/covers_img/1323.jpg'),
(1324, 'Venom: Lethal Protector', 2, 'Paulo Siqueira - Ken Lashley', 'Marvel', 'Grapa', 'USA', '2022', 'David Michelinie', 'Ivan Fiorelli', './assets/covers_img/1324.jpg'),
(1325, 'Venom: Lethal Protector II', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2023', 'David Michelinie', 'Farid Karami', './assets/covers_img/1325.jpg'),
(1326, 'Wasp', 3, 'Tom Reilly', 'Marvel', 'Grapa', 'USA', '2023', 'Al Ewing', 'Nie - Kasia', './assets/covers_img/1326.jpg'),
(1327, 'Wasp', 1, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2023', 'Al Ewing', 'Nie - Kasia', './assets/covers_img/1327.jpg'),
(1328, 'Wasp', 2, 'VACIO', 'Marvel', 'Grapa', 'USA', '2023', 'Al Ewing', 'VACIO', './assets/covers_img/1328.jpg'),
(1329, 'White Sand', 1, 'Julius Gopez', 'Dynamite Entertainment', 'Tomo', 'USA', '2019', 'Rick Hoskin - Brandom Sanderson', 'Julius Gopez', './assets/covers_img/1329.jpg'),
(1330, 'White Sand', 1, 'Julius Gopez', 'Dynamite Entertainment', 'Tomo', 'USA', '2016', 'Rick Hoskin - Brandom Sanderson', 'Julius Gopez', './assets/covers_img/1330.jpg'),
(1331, 'White Sand', 2, 'Julius Gopez', 'Dynamite Entertainment', 'Tomo', 'USA', '2018', 'Rick Hoskin - Brandom Sanderson', 'Julius Gopez', './assets/covers_img/1331.jpg'),
(1332, 'Wolverine ', 22, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2022', 'Benjamin Percy', 'Adam Kubert', './assets/covers_img/1332.jpg'),
(1333, 'Wolverine HC', 1, 'Benjamin Percy', 'Marvel', 'Tomo', 'USA', '2022', 'Benjamin Percy', 'Adam Kubert - Scot Eaton - Viktor Bogdanovic', './assets/covers_img/1333.jpg'),
(1334, 'X Lives and Deaths of Wolverine', 1, 'Adam Kubert', 'Marvel', 'Tomo', 'USA', '2022', 'Ben Percy', 'Joshua Cassara - Federico Vincentini', './assets/covers_img/1334.jpg'),
(1335, 'X of Sword HC', 1, 'Pepe Larraz', 'Marvel', 'Tomo', 'USA', '2020', 'Jonathan Hickman - Tini Howard', 'Pepe Larraz', './assets/covers_img/1335.jpg'),
(1336, 'X of Sword: Creation', 1, 'Pepe Larraz', 'Marvel', 'Tomo', 'USA', '2020', 'Jonathan Hickman - Tini Howard', 'Pepe Larraz', './assets/covers_img/1336.jpg'),
(1337, 'X of Sword: Destruction', 2, 'Pepe Larraz', 'Marvel', 'Tomo', 'USA', '2020', 'Jonathan Hickman - Tini Howard', 'Pepe Larraz', './assets/covers_img/1337.jpg'),
(1338, 'X-23: Deadly Regenesis', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2023', 'Erica Schultz', 'Edgar Salazar', './assets/covers_img/1338.jpg'),
(1339, 'X-Cellent', 1, 'Mike Allred', 'Marvel', 'Grapa', 'USA', '2023', 'Peter Milligan', 'Mike Allred', './assets/covers_img/1339.jpg'),
(1340, 'X-Death of Wolverine', 4, 'Adam Kubert', 'Marvel', 'Grapa', 'USA', '2022', 'Benjamin Percy', 'Federico Vicentini', './assets/covers_img/1340.jpg'),
(1341, 'X-Death of Wolverine', 5, 'Mateus Manhanini', 'Marvel', 'Grapa', 'USA', '2022', 'Benjamin Percy', 'Federico Vicentini', './assets/covers_img/1341.jpg'),
(1342, 'X-Death of Wolverine', 1, 'Adam Kubert', 'Marvel', 'Grapa', 'USA', '2021', 'Benjamin Percy', 'Federico Vicentini', './assets/covers_img/1342.jpg'),
(1343, 'X-Death of Wolverine', 3, 'Adam Kubert', 'Marvel', 'Grapa', 'USA', '2021', 'Benjamin Percy', 'Federico Vicentini', './assets/covers_img/1343.jpg'),
(1344, 'X-Death of Wolverine', 2, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2021', 'Benjamin Percy', 'Federico Vicentini', './assets/covers_img/1344.jpg'),
(1345, 'X-Force', 32, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Benjamin Percy', 'Robert Gill', './assets/covers_img/1345.jpg'),
(1346, 'X-Force HC', 1, 'Russell Dauterman', 'Marvel', 'Tomo', 'USA', '2022', 'Benjamin Percy', 'Joshua Cassara - More', './assets/covers_img/1346.jpg'),
(1347, 'X-Live of Wolverine', 1, 'Adam Kubert', 'Marvel', 'Grapa', 'USA', '2021', 'Benjamin Percy', 'Joshua Cassara', './assets/covers_img/1347.jpg'),
(1348, 'X-Live of Wolverine', 2, 'Adam Kubert', 'Marvel', 'Grapa', 'USA', '2021', 'Benjamin Percy', 'Joshua Cassara', './assets/covers_img/1348.jpg'),
(1349, 'X-Live of Wolverine', 3, 'Bartel', 'Marvel', 'Grapa', 'USA', '2021', 'Benjamin Percy', 'Joshua Cassara', './assets/covers_img/1349.jpg'),
(1350, 'X-Live of Wolverine', 4, 'Granof', 'Marvel', 'Grapa', 'USA', '2021', 'Benjamin Percy', 'Joshua Cassara - Federico Vicentini', './assets/covers_img/1350.jpg'),
(1351, 'X-Live of Wolverine', 5, 'Javi fernandez', 'Marvel', 'Grapa', 'USA', '2022', 'Benjamin Percy', 'Joshua Cassara', './assets/covers_img/1351.jpg'),
(1352, 'X-Men', 20, 'Stefano Caselli', 'Marvel', 'Grapa', 'USA', '2023', 'Gerry Duggan', 'Juan Frigeri', './assets/covers_img/1352.jpg'),
(1353, 'X-Men', 2, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2019', 'Jonathan Hickman', 'Leinil Francis Yu', './assets/covers_img/1353.jpg'),
(1354, 'X-Men', 4, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2019', 'Jonathan Hickman', 'Leinil Francis Yu', './assets/covers_img/1354.jpg'),
(1355, 'X-Men', 5, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2019', 'Jonathan Hickman', 'R. B. R. B. Silva ', './assets/covers_img/1355.jpg'),
(1356, 'X-Men', 11, 'Leinil Francis Yu - Mike Hawthorne', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Leinil Francis Yu', './assets/covers_img/1356.jpg'),
(1357, 'X-Men', 13, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Mahmud Asrar', './assets/covers_img/1357.jpg'),
(1358, 'X-Men', 1, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2019', 'Jonathan Hickman', 'Leinil Francis Yu', './assets/covers_img/1358.jpg'),
(1359, 'X-Men', 6, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Matteo Buffagni', './assets/covers_img/1359.jpg'),
(1360, 'X-Men', 7, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Leinil Francis Yu', './assets/covers_img/1360.jpg'),
(1361, 'X-Men', 17, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2021', 'Jonathan Hickman', 'Brett Booth', './assets/covers_img/1361.jpg'),
(1362, 'X-Men', 18, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2021', 'Jonathan Hickman', 'Mahmud Asrar', './assets/covers_img/1362.jpg'),
(1363, 'X-Men', 19, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2021', 'Jonathan Hickman', 'Mahmud Asrar', './assets/covers_img/1363.jpg'),
(1364, 'X-Men', 20, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2021', 'Jonathan Hickman', 'Mahmud Asrar', './assets/covers_img/1364.jpg'),
(1365, 'X-Men', 21, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2021', 'Jonathan Hickman', 'Russell Dauterman', './assets/covers_img/1365.jpg'),
(1366, 'X-Men', 3, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2019', 'Jonathan Hickman', 'Leinil Francis Yu', './assets/covers_img/1366.jpg'),
(1367, 'X-Men', 19, 'Terry Dodson', 'Marvel', 'Grapa', 'USA', '2023', 'VACIO', 'VACIO', './assets/covers_img/1367.jpg'),
(1368, 'X-Men', 1, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2021', 'Gerry Duggan', 'Pepe Larraz', './assets/covers_img/1368.jpg'),
(1369, 'X-Men', 1, 'Jack Kirby', 'Marvel', 'Grapa', 'USA', '1964', 'Stan Lee', 'Jack Kirby', './assets/covers_img/1369.jpg'),
(1370, 'X-Men', 18, 'Casagrande', 'Marvel', 'Grapa', 'USA', '2023', 'Gerry Duggan', 'Joshua Cassara', './assets/covers_img/1370.jpg'),
(1371, 'X-Men', 13, 'James Stokoe', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'C.F. Villa', './assets/covers_img/1371.jpg'),
(1372, 'X-Men', 1, 'Pepe Larraz', 'Marvel', 'Grapa', 'USA', '2021', 'Gerry Duggan', 'Pepe Larraz', './assets/covers_img/1372.jpg'),
(1373, 'X-Men', 2, 'Pepe Larraz', 'Marvel', 'Grapa', 'USA', '2021', 'Gerry Duggan', 'Pepe Larraz', './assets/covers_img/1373.jpg'),
(1374, 'X-Men', 3, 'Pepe Larraz', 'Marvel', 'Grapa', 'USA', '2021', 'Gerry Duggan', 'Pepe Larraz', './assets/covers_img/1374.jpg'),
(1375, 'X-Men', 4, 'Pepe Larraz', 'Marvel', 'Grapa', 'USA', '2021', 'Gerry Duggan', 'Javier Pina', './assets/covers_img/1375.jpg'),
(1376, 'X-Men', 5, 'Pepe Larraz', 'Marvel', 'Grapa', 'USA', '2021', 'Gerry Duggan', 'Ze Carlos - Javier Pina', './assets/covers_img/1376.jpg'),
(1377, 'X-Men', 5, 'Pepe Larraz', 'Marvel', 'Grapa', 'USA', '2021', 'Gerry Duggan', 'Ze Carlos - Javier Pina', './assets/covers_img/1377.jpg'),
(1378, 'X-Men', 6, 'Pepe Larraz', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'Pepe Larraz', './assets/covers_img/1378.jpg'),
(1379, 'X-Men', 7, 'Cheung', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'Pepe Larraz', './assets/covers_img/1379.jpg'),
(1380, 'X-Men', 8, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'Javier Pina', './assets/covers_img/1380.jpg'),
(1381, 'X-Men', 9, 'Natacha Bustos', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'C.F. Villa', './assets/covers_img/1381.jpg'),
(1382, 'X-Men', 10, 'Pepe Larraz', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'Javier Pina', './assets/covers_img/1382.jpg'),
(1383, 'X-Men', 11, 'Carmen Carnero', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'Pepe Larraz', './assets/covers_img/1383.jpg'),
(1384, 'X-Men', 12, 'Inhyuk Lee - Hellfire gala', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'Pepe Larraz', './assets/covers_img/1384.jpg'),
(1385, 'X-Men', 12, 'Pepe Larraz', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'Pepe Larraz', './assets/covers_img/1385.jpg'),
(1386, 'X-Men', 13, 'Stoko', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'C.F. Villa', './assets/covers_img/1386.jpg'),
(1387, 'X-Men', 13, 'A.X.E', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'C.F. Villa', './assets/covers_img/1387.jpg'),
(1388, 'X-Men', 15, 'Dodson', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'Joshua Cassara', './assets/covers_img/1388.jpg'),
(1389, 'X-Men', 17, 'Martin Coccolo', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'Joshua Cassara', './assets/covers_img/1389.jpg'),
(1390, 'X-Men', 14, 'Martin Coccolo', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'C.F. Villa', './assets/covers_img/1390.jpg'),
(1391, 'X-Men', 12, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Leinil Francis Yu', './assets/covers_img/1391.jpg'),
(1392, 'X-Men', 14, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Mahmud Asrar', './assets/covers_img/1392.jpg'),
(1393, 'X-Men', 15, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Mahmud Asrar', './assets/covers_img/1393.jpg'),
(1394, 'X-Men', 16, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Phil Noto', './assets/covers_img/1394.jpg'),
(1395, 'X-Men', 8, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'R. B. R. B. Silva ', './assets/covers_img/1395.jpg'),
(1396, 'X-Men', 9, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Leinil Francis Yu', './assets/covers_img/1396.jpg'),
(1397, 'X-Men', 10, 'Leinil Francis Yu', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Leinil Francis Yu', './assets/covers_img/1397.jpg'),
(1398, 'X-Men Annual', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Steve Foxe', 'Andrea Di Vito', './assets/covers_img/1398.jpg'),
(1399, 'X-Men UnLimited Latitude ', 1, 'Mike Henderson', 'Marvel', 'Grapa', 'USA', '2022', 'Jonathan Hickman', 'Declan Shalvey', './assets/covers_img/1399.jpg'),
(1400, 'X-Men: Empyre', 4, 'Kyle Hotz', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman', 'Jorge Molina', './assets/covers_img/1400.jpg'),
(1401, 'X-Men: Empyre', 1, 'Mike Mckone', 'Marvel', 'Grapa', 'USA', '2020', 'Jonathan Hickman - Tini Howard', 'Matteo Buffagni', './assets/covers_img/1401.jpg'),
(1402, 'X-Men: Empyre', 2, 'Stephen Segovia', 'Marvel', 'Grapa', 'USA', '2020', 'Gerry Duggan - Ben Percy - Leah Williams', ' Lucas Werneck', './assets/covers_img/1402.jpg'),
(1403, 'X-Men: Empyre', 3, 'Eduard Petrovich', 'Marvel', 'Grapa', 'USA', '2020', 'Ed Brisson - Vita Ayala - Zeb Wells', 'Eduard Petrovich', './assets/covers_img/1403.jpg'),
(1404, 'X-Men: Fantastic Four', 2, 'Terry Dodson', 'Marvel', 'Grapa', 'USA', '2020', 'Chip Zdarsky', 'Terry Dodson', './assets/covers_img/1404.jpg'),
(1405, 'X-Men: Fantastic Four', 4, 'Terry Dodson', 'Marvel', 'Grapa', 'USA', '2020', 'Chip Zdarsky', 'Terry Dodson', './assets/covers_img/1405.jpg'),
(1406, 'X-Men: Fantastic Four', 3, 'Terry Dodson', 'Marvel', 'Grapa', 'USA', '2020', 'Chip Zdarsky', 'Terry Dodson', './assets/covers_img/1406.jpg'),
(1407, 'X-Men: Fantastic Four', 1, 'Terry Dodson', 'Marvel', 'Grapa', 'USA', '2020', 'Chip Zdarsky', 'Terry Dodson', './assets/covers_img/1407.jpg'),
(1408, 'X-Men: Hellfire gala', 1, 'Gerry Duggan - Carlos Gomez', 'Marvel', 'Grapa', 'USA', '2022', 'Gerry Duggan', 'C.F. Villa - Matteo Lolli - Russell Dauterman - Kris Anka', './assets/covers_img/1408.jpg'),
(1409, 'X-Men: Hellfire Gala Red Carpet Collection', 1, 'Pepe Larraz', 'Marvel', 'Tomo', 'USA', '2021', 'Jonathan Hickman - Gerry Duggan - Al Ewing', 'Russell Dauterman -  Alex Lins -  Joshua Cassara - David Baldeon - Nick Dragotta - David Messina - Valerio Schiti', './assets/covers_img/1409.jpg'),
(1410, 'X-Men: House of X & Powers of X HC', 1, 'Mark Brooks', 'Marvel', 'Tomo', 'USA', '2019', 'Jonathan Hickman', 'R.B. Silva - Pepe Larraz', './assets/covers_img/1410.jpg'),
(1411, 'X-Men: Omnibus', 1, 'Leinil Francis Yu', 'Marvel', 'Tomo', 'USA', '2021', 'Jonathan Hickman', 'Russell Dauterman - Francesco Mobili - Leinil Francis Yu - Ramon K. Perez - Mahmud Asrar - R.B. Silva - Alan Davis - Phil Noto - Matteo Buffagni - Ro', './assets/covers_img/1411.jpg'),
(1412, 'X-Men: Red', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Stefano Caselli', './assets/covers_img/1412.jpg'),
(1413, 'X-Men: Red', 6, 'A.X.E', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Stefano Caselli', './assets/covers_img/1413.jpg'),
(1414, 'X-Men: Red', 1, 'David Lopez', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Stefano Caselli', './assets/covers_img/1414.jpg'),
(1415, 'X-Men: Red', 2, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Stefano Caselli', './assets/covers_img/1415.jpg'),
(1416, 'X-Men: Red', 3, 'Gomez', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Stefano Caselli', './assets/covers_img/1416.jpg'),
(1417, 'X-Men: Red', 3, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Stefano Caselli', './assets/covers_img/1417.jpg'),
(1418, 'X-Men: Red', 4, 'Bartel - Hellfire gala', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Juann Cabal -  Michael Sta. Maria -  Andres Genolet', './assets/covers_img/1418.jpg'),
(1419, 'X-Men: Red', 5, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Stefano Caselli', './assets/covers_img/1419.jpg'),
(1420, 'X-Men: Red', 7, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2022', 'Al Ewing', 'Madibek Musabekov', './assets/covers_img/1420.jpg'),
(1421, 'X-Men: Red', 10, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2023', 'Al Ewing', 'Madibek Musabekov', './assets/covers_img/1421.jpg'),
(1422, 'X-Men: Red', 9, 'Russell Dauterman', 'Marvel', 'Grapa', 'USA', '2023', 'Al Ewing', 'Madibek Musabekov', './assets/covers_img/1422.jpg'),
(1423, 'X-Men: Unforgiven', 1, 'Peach Momoko', 'Marvel', 'Grapa', 'USA', '2023', 'Tim Seeley', 'Sid Kotian', './assets/covers_img/1423.jpg'),
(1424, 'X-Men: X-Treme', 1, 'Carlos E. Gomez', 'Marvel', 'Grapa', 'USA', '2022', 'Chris Claremont', 'Salvador Larroca', './assets/covers_img/1424.jpg'),
(1425, 'X-Treme X-Men ', 23, 'Salvador Larroca', 'Marvel', 'Grapa', 'USA', '2003', 'Chris Claremont', 'Salvador Larroca', './assets/covers_img/1425.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comics_guardados`
--

DROP TABLE IF EXISTS `comics_guardados`;
CREATE TABLE `comics_guardados` (
  `id_guardado` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comics_guardados`
--

INSERT INTO `comics_guardados` (`id_guardado`, `user_id`, `comic_id`) VALUES
(9, 2, 653),
(10, 2, 1028),
(11, 2, 252),
(12, 2, 503),
(13, 2, 1359),
(14, 2, 112),
(15, 2, 365),
(16, 2, 200);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenido_listas`
--

DROP TABLE IF EXISTS `contenido_listas`;
CREATE TABLE `contenido_listas` (
  `id_contenido` int(11) NOT NULL,
  `id_lista` int(11) NOT NULL,
  `id_comic` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_comics`
--

DROP TABLE IF EXISTS `lista_comics`;
CREATE TABLE `lista_comics` (
  `id_lista` int(11) NOT NULL,
  `nombre_lista` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lista_comics`
--

INSERT INTO `lista_comics` (`id_lista`, `nombre_lista`, `id_user`) VALUES
(1, 'test', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opiniones_comics`
--

DROP TABLE IF EXISTS `opiniones_comics`;
CREATE TABLE `opiniones_comics` (
  `id_opinion` int(11) NOT NULL,
  `id_comic` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `opinion` varchar(300) NOT NULL,
  `puntuacion` float NOT NULL
) ;

--
-- Volcado de datos para la tabla `opiniones_comics`
--

INSERT INTO `opiniones_comics` (`id_opinion`, `id_comic`, `id_usuario`, `opinion`, `puntuacion`) VALUES
(1, 964, 2, 'rrrrr', 3),
(2, 964, 2, 'rrrrr', 3),
(3, 964, 2, 'juajajsjas', 2),
(4, 964, 2, 'gerghrhberhnrhnt', 4),
(5, 625, 2, 'test2', 3),
(6, 946, 2, 'es la ostia', 5),
(7, 710, 2, 'hghgh', 1),
(8, 710, 2, 'fgjhgh', 3),
(9, 1028, 2, 'hfghghfgh', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opiniones_pagina`
--

DROP TABLE IF EXISTS `opiniones_pagina`;
CREATE TABLE `opiniones_pagina` (
  `id_opinion` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `comentario` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `asunto_ticket` varchar(255) NOT NULL,
  `mensaje` varchar(450) NOT NULL,
  `fecha_ticket` datetime NOT NULL,
  `status` enum('abierto','cerrado') NOT NULL DEFAULT 'abierto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `user_id`, `asunto_ticket`, `mensaje`, `fecha_ticket`, `status`) VALUES
(6, 12, 'test', 'test1', '2023-02-04 14:10:23', 'cerrado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets_respuestas`
--

DROP TABLE IF EXISTS `tickets_respuestas`;
CREATE TABLE `tickets_respuestas` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `respuesta_ticket` varchar(450) NOT NULL,
  `fecha_respuesta` datetime NOT NULL,
  `nombre_admin` varchar(150) NOT NULL,
  `privilegio_user` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tickets_respuestas`
--

INSERT INTO `tickets_respuestas` (`id`, `ticket_id`, `user_id`, `respuesta_ticket`, `fecha_respuesta`, `nombre_admin`, `privilegio_user`) VALUES
(7, 6, 0, 'esto es una respuesta test', '2023-02-04 14:11:01', 'test', 'user'),
(8, 6, 0, 'esto es una respuesta', '2023-02-04 14:11:37', 'admin', 'admin'),
(9, 6, 0, 'sdsd', '2023-02-04 14:28:56', 'test', 'user'),
(10, 6, 0, 'dfdfdf', '2023-02-04 14:30:11', 'admin', 'admin'),
(11, 6, 0, 'dfdfdf', '2023-02-04 14:31:02', 'admin', 'admin'),
(12, 6, 0, 'ffff', '2023-02-04 14:31:16', 'admin', 'admin'),
(13, 6, 0, 'cerrado', '2023-02-04 15:42:51', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `IDuser` int(11) NOT NULL,
  `privilege` enum('user','admin','guest') NOT NULL DEFAULT 'user',
  `userName` varchar(250) NOT NULL,
  `password` varchar(150) NOT NULL,
  `email` varchar(250) NOT NULL,
  `userPicture` varchar(250) NOT NULL,
  `accountStatus` enum('active','block') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`IDuser`, `privilege`, `userName`, `password`, `email`, `userPicture`, `accountStatus`) VALUES
(1, 'guest', 'guest', 'guest', 'guest@webComics.com', 'assets/pictureProfile/default/default.jpg', 'active'),
(2, 'admin', 'admin', '$2y$10$UUVBrnJ5CPP0rLTI2z2f0u3o.NBnHY1TOBT54Ix7aSFfvMyRzGJrK', 'aloxfloyd@gmail.com', 'assets/pictureProfile/2-aloxfloyd/profile.jpg', 'active'),
(12, 'user', 'test', '$2y$10$LwLY93PV5fqpnZQ.zLz/ke/PnTppn8gz0.5r7jwm1aBpig/8gFFlS', 'test@gmail.com', 'assets/pictureProfile/12-test/profile.jpg', 'active');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aboutuser`
--
ALTER TABLE `aboutuser`
  ADD PRIMARY KEY (`IDuser`),
  ADD KEY `idUser` (`IDuser`);

--
-- Indices de la tabla `comics`
--
ALTER TABLE `comics`
  ADD PRIMARY KEY (`IDcomic`);

--
-- Indices de la tabla `comics_guardados`
--
ALTER TABLE `comics_guardados`
  ADD PRIMARY KEY (`id_guardado`),
  ADD KEY `user_id_ibfk_1` (`user_id`),
  ADD KEY `comic_id_ibfk_1` (`comic_id`);

--
-- Indices de la tabla `contenido_listas`
--
ALTER TABLE `contenido_listas`
  ADD PRIMARY KEY (`id_contenido`),
  ADD KEY `id_lista_ibfk_1` (`id_lista`),
  ADD KEY `id_comic_ibfk_1` (`id_comic`);

--
-- Indices de la tabla `lista_comics`
--
ALTER TABLE `lista_comics`
  ADD PRIMARY KEY (`id_lista`),
  ADD KEY `lista_comics_ibfk_1` (`id_user`);

--
-- Indices de la tabla `opiniones_comics`
--
ALTER TABLE `opiniones_comics`
  ADD PRIMARY KEY (`id_opinion`),
  ADD KEY `FK_id_comic` (`id_comic`),
  ADD KEY `FK_id_usuario` (`id_usuario`);

--
-- Indices de la tabla `opiniones_pagina`
--
ALTER TABLE `opiniones_pagina`
  ADD PRIMARY KEY (`id_opinion`),
  ADD KEY `fk_opiniones_pagina_users` (`id_user`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `user` (`user_id`);

--
-- Indices de la tabla `tickets_respuestas`
--
ALTER TABLE `tickets_respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id_index` (`ticket_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`IDuser`,`email`,`userName`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comics`
--
ALTER TABLE `comics`
  MODIFY `IDcomic` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1426;

--
-- AUTO_INCREMENT de la tabla `comics_guardados`
--
ALTER TABLE `comics_guardados`
  MODIFY `id_guardado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `contenido_listas`
--
ALTER TABLE `contenido_listas`
  MODIFY `id_contenido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lista_comics`
--
ALTER TABLE `lista_comics`
  MODIFY `id_lista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `opiniones_comics`
--
ALTER TABLE `opiniones_comics`
  MODIFY `id_opinion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `opiniones_pagina`
--
ALTER TABLE `opiniones_pagina`
  MODIFY `id_opinion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tickets_respuestas`
--
ALTER TABLE `tickets_respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `IDuser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aboutuser`
--
ALTER TABLE `aboutuser`
  ADD CONSTRAINT `id_user` FOREIGN KEY (`IDuser`) REFERENCES `users` (`IDuser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comics_guardados`
--
ALTER TABLE `comics_guardados`
  ADD CONSTRAINT `comic_id_ibfk_1` FOREIGN KEY (`comic_id`) REFERENCES `comics` (`IDcomic`),
  ADD CONSTRAINT `user_id_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`IDuser`);

--
-- Filtros para la tabla `contenido_listas`
--
ALTER TABLE `contenido_listas`
  ADD CONSTRAINT `id_comic_ibfk_1` FOREIGN KEY (`id_comic`) REFERENCES `comics` (`IDcomic`),
  ADD CONSTRAINT `id_lista_ibfk_1` FOREIGN KEY (`id_lista`) REFERENCES `lista_comics` (`id_lista`);

--
-- Filtros para la tabla `lista_comics`
--
ALTER TABLE `lista_comics`
  ADD CONSTRAINT `lista_comics_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`IDuser`);

--
-- Filtros para la tabla `opiniones_comics`
--
ALTER TABLE `opiniones_comics`
  ADD CONSTRAINT `FK_id_comic` FOREIGN KEY (`id_comic`) REFERENCES `comics` (`IDcomic`),
  ADD CONSTRAINT `FK_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`IDuser`);

--
-- Filtros para la tabla `opiniones_pagina`
--
ALTER TABLE `opiniones_pagina`
  ADD CONSTRAINT `fk_opiniones_pagina_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`IDuser`);

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`IDuser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tickets_respuestas`
--
ALTER TABLE `tickets_respuestas`
  ADD CONSTRAINT `tickets_respuestas_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`ticket_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
