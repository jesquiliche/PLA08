-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-10-2021 a las 21:13:22
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `banco`
--
CREATE DATABASE IF NOT EXISTS `banco` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `banco`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

DROP TABLE IF EXISTS `cuentas`;
CREATE TABLE `cuentas` (
  `idcuenta` int(11) NOT NULL,
  `entidad` char(4) NOT NULL,
  `oficina` char(4) NOT NULL,
  `dc` char(2) NOT NULL,
  `cuenta` char(10) NOT NULL,
  `saldo` decimal(11,2) NOT NULL,
  `idpersona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`idcuenta`, `entidad`, `oficina`, `dc`, `cuenta`, `saldo`, `idpersona`) VALUES
(3, '0010', '0100', '01', '1234567890', '200.00', 36),
(5, '0001', '0200', '10', '0200123331', '30000.00', 80);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

DROP TABLE IF EXISTS `personas`;
CREATE TABLE `personas` (
  `idpersona` int(11) NOT NULL,
  `nif` char(9) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `apellidos` varchar(80) NOT NULL,
  `direccion` varchar(120) NOT NULL,
  `telefono` char(9) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`idpersona`, `nif`, `nombre`, `apellidos`, `direccion`, `telefono`, `email`, `timestamp`) VALUES
(36, '44608800L', 'David', 'Alcolea', 'Gran Via, 77', '338888477', 'david@mail.com', '2021-10-06 15:08:47'),
(37, '45000000L', 'Johny', 'Mentero', 'Av Torrente 123 4o 1a', '34567890', 'pierre@mail.com', '2017-06-03 10:07:09'),
(72, '12345678K', 'Virgil', 'Solozzo', 'Foscarelli avenue, 45', '121121121', 'virgil@mail.com', '2021-10-06 13:59:19'),
(73, '22345678J', 'O-Ren', 'Ishii', 'Foscarelli avenue, 45', '', 'oren@mail.com', '2021-10-06 13:59:53'),
(74, '32345678P', 'Beatrix', 'Kiddo', 'Margheritti street, 101', '222311888', 'beatrix@mail.com', '2021-10-06 16:01:01'),
(75, '32555678P', 'Vernita', 'Green', 'Foscarelli avenue, 45', '', 'vernita@mail.com', '2021-10-06 14:23:07'),
(80, '45334433T', 'Gogo', 'Yubari', 'Dulcinea, 34', '', 'gogo@mail.com', '2021-10-06 19:12:04');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`idcuenta`),
  ADD UNIQUE KEY `entidad` (`entidad`,`oficina`,`dc`,`cuenta`),
  ADD KEY `idpersona` (`idpersona`),
  ADD KEY `idpersona_2` (`idpersona`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`idpersona`),
  ADD UNIQUE KEY `nif` (`nif`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `idcuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD CONSTRAINT `cuentas_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `personas` (`idpersona`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
