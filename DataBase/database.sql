-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-12-2022 a las 19:08:53
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

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
CREATE TABLE IF NOT EXISTS `comics` (
  `IDcomic` int(11) NOT NULL AUTO_INCREMENT,
  `NameComic` varchar(150) NOT NULL,
  `NumComic` int(10) NOT NULL,
  `CoverArtist` varchar(150) NOT NULL,
  `publisher` varchar(45) NOT NULL,
  `Writer` varchar(150) NOT NULL,
  `Penciler` varchar(150) NOT NULL,
  `Cover` blob NOT NULL,
  PRIMARY KEY (`IDcomic`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `possession`
--

DROP TABLE IF EXISTS `possession`;
CREATE TABLE IF NOT EXISTS `possession` (
  `user` int(11) NOT NULL,
  `comic` int(11) NOT NULL,
  PRIMARY KEY (`user`,`comic`),
  KEY `comic_id` (`comic`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `UserName` varchar(50) NOT NULL,
  `Pass` varchar(50) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `IDuser` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`IDuser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wanted`
--

DROP TABLE IF EXISTS `wanted`;
CREATE TABLE IF NOT EXISTS `wanted` (
  `comic` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`comic`,`user`),
  KEY `idUser` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `possession`
--
ALTER TABLE `possession`
  ADD CONSTRAINT `comic_id` FOREIGN KEY (`comic`) REFERENCES `comics` (`IDcomic`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user`) REFERENCES `user` (`IDuser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `wanted`
--
ALTER TABLE `wanted`
  ADD CONSTRAINT `idComic` FOREIGN KEY (`comic`) REFERENCES `comics` (`IDcomic`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idUser` FOREIGN KEY (`user`) REFERENCES `user` (`IDuser`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
