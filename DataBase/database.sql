-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-12-2022 a las 18:41:01
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
(2, 'admin', 'Alejandro', '$2y$10$jYtWDGxaCKHYfLz9u4Zzoe1lle1j0UaKl9K8QkkO51wUHcARStMJy', 'aloxfloyd@gmail.com', 'assets/pictureProfile/2-aloxfloyd/profile.jpg', 'active');

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
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`IDuser`,`email`);

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
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `IDuser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `possession`
--
ALTER TABLE `possession`
  ADD CONSTRAINT `comic_id` FOREIGN KEY (`comic`) REFERENCES `comics` (`IDcomic`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user`) REFERENCES `users` (`IDuser`) ON DELETE CASCADE ON UPDATE CASCADE;

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
