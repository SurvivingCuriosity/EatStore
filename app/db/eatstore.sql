-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-01-2022 a las 18:58:48
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.3.30

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
(3, 'Pescados', 'Recién salidos del mar.'),
(4, 'Postres', 'Los tenemos ligeros y menos ligeros...');

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
(22, '11946693X', 'Fer', 'Calle Alegría', 'fer2@fer.com', '$2y$10$9uQFRX6whufo2BDG2VlTkuHokbhkPmDNToAR7EKwkww05DG90f5FC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` int(11) UNSIGNED NOT NULL,
  `idcliente` int(11) UNSIGNED NOT NULL,
  `fcompra` timestamp NULL DEFAULT current_timestamp(),
  `descuento` double DEFAULT 0,
  `formapago` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT 'Efectivo',
  `total_sinDescuento` double NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idcompra`, `idcliente`, `fcompra`, `descuento`, `formapago`, `total_sinDescuento`, `total`) VALUES
(12, 22, '2022-01-27 17:38:32', 20, 'efectivo', 41, 32.8),
(13, 22, '2022-01-27 17:38:41', 20, 'efectivo', 41, 32.8),
(14, 22, '2022-01-27 17:39:50', 20, 'efectivo', 41, 32.8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuento`
--

CREATE TABLE `descuento` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `porcentaje` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `descuento`
--

INSERT INTO `descuento` (`id`, `codigo`, `porcentaje`) VALUES
(1, 'navidad', 20),
(2, 'fernando', 50);

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

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`iddetalle`, `idplato`, `idcompra`, `cantidad`, `precio`) VALUES
(27, 1, 12, 2, 12),
(28, 2, 12, 1, 17),
(29, 1, 13, 2, 12),
(30, 2, 13, 1, 17),
(31, 1, 14, 2, 12),
(32, 2, 14, 1, 17);

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
(9, 'Carrilleras', 'carrilleras.jpg', 'Carrilleras super super ricas', 2, 15),
(10, 'Trufas', 'trufas.jpg', 'Trufas heladas con ketchup', 4, 17),
(11, 'Helado', 'helado.jpg', 'Helado de chocolate o vainilla', 4, 5),
(12, 'Salmón', 'salmon.jpg', 'Salmón recién salido del mar', 3, 30),
(13, 'Gambas', 'gambas.jpg', 'Gambas gambitas gambotas', 3, 67);

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
-- Indices de la tabla `descuento`
--
ALTER TABLE `descuento`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `descuento`
--
ALTER TABLE `descuento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `iddetalle` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `plato`
--
ALTER TABLE `plato`
  MODIFY `idplato` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
