-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-01-2023 a las 16:15:10
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
(2, 'Test numero 2', '2022-12-07', 'Alejandro', 'Rodriguez Mena', 0),
(5, 'No existe información sobre el usuario deniceyerba@gmail.com', '2022-12-28', NULL, NULL, 0),
(6, 'No existe información sobre el usuario aloxfloyd1@gmail.com', '2022-12-31', NULL, NULL, 0),
(7, 'No existe información sobre el usuario test1@gmail.com', '2023-01-10', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comics`
--

DROP TABLE IF EXISTS `comics`;
CREATE TABLE `comics` (
  `IDcomic` int(11) NOT NULL,
  `NameComic` varchar(150) NOT NULL,
  `NumComic` int(10) NOT NULL,
  `CoverArtist` varchar(150) NOT NULL,
  `publisher` varchar(45) NOT NULL,
  `date_published` date NOT NULL,
  `Writer` varchar(150) NOT NULL,
  `Penciler` varchar(150) NOT NULL,
  `Cover` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `possession`
--

DROP TABLE IF EXISTS `possession`;
CREATE TABLE `possession` (
  `user` int(11) NOT NULL,
  `comic` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

DROP TABLE IF EXISTS `respuestas`;
CREATE TABLE `respuestas` (
  `respuesta_id` int(11) NOT NULL,
  `mensaje` varchar(450) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fecha_respuesta` date NOT NULL
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
  `fecha_ticket` date NOT NULL,
  `status` enum('abierto','cerrado') NOT NULL DEFAULT 'cerrado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, 'admin', 'admin', '$2y$10$4ImxFH90yk4.HiEtCmmnneE8OzYZ1Dy39kShi0zJZwAlhCkvBfeAu', 'aloxfloyd@gmail.com', 'assets/pictureProfile/2-aloxfloyd/profile.jpg', 'active'),
(5, 'user', 'MisterioRojo', '$2y$10$pHXbqrDwk3CBI3Y6maBbFO8foVA0mMXTd296PQCW845XuKWmNMigy', 'deniceyerba@gmail.com', 'assets/pictureProfile/5-deniceyerba/profile.jpg', 'active'),
(6, 'user', 'admininin', '$2y$10$l0eP2NiwW1LNQm4juRtlK./661muz8/cDvrL0pvlL/DXVlWDXcY5.', 'aloxfloyd1@gmail.com', 'assets/pictureProfile/6-aloxfloyd1/profile.jpg', 'active'),
(7, 'user', 'test', '$2y$10$nqxhJrZIIZj/J1F8G8tfSeC171cCWIX5h/hnNY3KNmPQ4k2m1jiwq', 'test1@gmail.com', 'assets/pictureProfile/7-test1/profile.jpg', 'active');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wanted`
--

DROP TABLE IF EXISTS `wanted`;
CREATE TABLE `wanted` (
  `comic` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indices de la tabla `possession`
--
ALTER TABLE `possession`
  ADD PRIMARY KEY (`user`,`comic`),
  ADD KEY `comic_id` (`comic`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`respuesta_id`,`ticket_id`),
  ADD KEY `ticketID` (`ticket_id`),
  ADD KEY `userID` (`user_id`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `user` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`IDuser`,`email`,`userName`);

--
-- Indices de la tabla `wanted`
--
ALTER TABLE `wanted`
  ADD PRIMARY KEY (`comic`,`user`),
  ADD KEY `idUser` (`user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comics`
--
ALTER TABLE `comics`
  MODIFY `IDcomic` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `respuesta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `IDuser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aboutuser`
--
ALTER TABLE `aboutuser`
  ADD CONSTRAINT `id_user` FOREIGN KEY (`IDuser`) REFERENCES `users` (`IDuser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `possession`
--
ALTER TABLE `possession`
  ADD CONSTRAINT `comic_id` FOREIGN KEY (`comic`) REFERENCES `comics` (`IDcomic`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user`) REFERENCES `users` (`IDuser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `ticketID` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userID` FOREIGN KEY (`user_id`) REFERENCES `users` (`IDuser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`IDuser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `wanted`
--
ALTER TABLE `wanted`
  ADD CONSTRAINT `idComic` FOREIGN KEY (`comic`) REFERENCES `comics` (`IDcomic`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idUser` FOREIGN KEY (`user`) REFERENCES `users` (`IDuser`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;