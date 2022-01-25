-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-01-2022 a las 21:04:31
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eatstore`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `descripcion`) VALUES
(1, 'Arroces', 'Plato cuyo ingrediente principal es el arroz'),
(2, 'Carnes', 'Nuestras mejores carnes.'),
(3, 'Pescados', 'Recién salidos del mar.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) UNSIGNED NOT NULL,
  `dni` varchar(9) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `correoe` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `contras` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `dni`, `nombre`, `direccion`, `correoe`, `contras`) VALUES
(1, '11111111H', 'Lourdes Izquierdo', 'Avd. Comuneros, 123, 5G. 37007 Salamanca', 'prueba@gmail.com', '$2y$10$RUrVQ8Zq3t/z/RQRVyFWD.JlWSN7/nQV.3AKiubPBj0CJqcRIsJnO'),
(7, '12345', 'Fernando', 'Direccion prueba', 'fer@fer.com', '$2y$10$o/L/lrm4hyHaxk/zV29JlOTHRpR1f.HuQ3e5TT8C0kiXgRTRc2E22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` int(11) UNSIGNED NOT NULL,
  `idcliente` int(11) UNSIGNED NOT NULL,
  `fcompra` date NOT NULL,
  `descuento` double DEFAULT 0,
  `formapago` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT 'Efectivo',
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `iddetalle` int(10) UNSIGNED NOT NULL,
  `idplato` int(11) UNSIGNED NOT NULL,
  `idcompra` int(11) UNSIGNED NOT NULL,
  `cantidad` int(11) UNSIGNED DEFAULT 1,
  `precio` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plato`
--

CREATE TABLE `plato` (
  `idplato` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `precio` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `plato`
--

INSERT INTO `plato` (`idplato`, `nombre`, `foto`, `descripcion`, `idcategoria`, `precio`) VALUES
(1, 'Paella', 'paella.jpg', 'Paella con piña.', 1, 12),
(2, 'Arroz a la cubana', 'arroz_cubana.jpg', 'Arroz a la cubana con salsa barbacoa', 1, 17),
(3, 'Entrecot', 'entrecot.jpg', 'Entrecot mu rico.', 2, 25),
(4, 'Pollo', 'pollo.jpg', 'Pollo del de comer.', 2, 20),
(5, 'Sardinas', 'sardinas.jpg', 'Sardinas riquisimas.', 3, 12),
(6, 'Merluza', 'merluza.jpg', 'No seas merluzo...', 3, 12),
(7, 'Rodaballo', 'rodaballo.jpg', 'Rodaballo rima con caballo', 3, 10),
(8, 'Alitas de pollo', 'alitas.jpg', 'Alitas de pollo con salsa barbacoa', 2, 11),
(9, 'Carrilleras', 'carrilleras.jpg', 'Carrilleras super super ricas', 2, 15);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `correoe` (`correoe`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`),
  ADD KEY `compra_ibfk_1` (`idcliente`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`iddetalle`,`idplato`,`idcompra`),
  ADD KEY `detalle_compra_ibfk_1` (`idplato`),
  ADD KEY `detalle_compra_ibfk_2` (`idcompra`);

--
-- Indices de la tabla `plato`
--
ALTER TABLE `plato`
  ADD PRIMARY KEY (`idplato`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `plato_ibfk_1` (`idcategoria`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `iddetalle` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plato`
--
ALTER TABLE `plato`
  MODIFY `idplato` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `detalle_compra_ibfk_1` FOREIGN KEY (`idplato`) REFERENCES `plato` (`idplato`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `detalle_compra_ibfk_2` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `plato`
--
ALTER TABLE `plato`
  ADD CONSTRAINT `plato_ibfk_1` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
