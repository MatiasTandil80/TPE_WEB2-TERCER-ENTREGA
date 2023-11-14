-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-11-2023 a las 01:16:17
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `motos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(2) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `origen` varchar(20) NOT NULL,
  `año_fundacion` int(4) NOT NULL,
  `cant_empleados` int(5) NOT NULL,
  `produccion_anual` int(8) NOT NULL,
  `facturacion_M_USD` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`, `origen`, `año_fundacion`, `cant_empleados`, `produccion_anual`, `facturacion_M_USD`) VALUES
(134, 'honda', 'japon', 1949, 220, 14000000, 68),
(135, 'yamaha', 'japon', 1955, 74000, 6, 22000),
(140, 'zanella', 'Argentina', 1950, 22, 140000, 1000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `id` int(2) NOT NULL,
  `id_marca` int(2) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `cilindrada_cm3` int(4) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `potencia_hp` int(3) NOT NULL,
  `peso_kg` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`id`, `id_marca`, `nombre`, `cilindrada_cm3`, `tipo`, `potencia_hp`, `peso_kg`) VALUES
(43, 135, 'YZF-R1', 998, 'deportiva', 200, 200),
(44, 135, 'MT-09', 889, 'naked', 119, 193),
(45, 135, 'XSR900 Retro', 889, 'retro', 119, 193),
(46, 134, 'CBR1000RR-R', 999, 'deportiva', 217, 198),
(47, 134, 'CB650R', 649, 'naked', 95, 199),
(50, 135, 'prueba2', 998, 'NADA', 2, 2000),
(51, 135, '', 0, '', 0, 0),
(52, 135, 'NUEVITA', 998, 'NADA', 2, 2000),
(53, 135, 'SUPERVIEJITA3', 998, 'NADA', 2, 2000),
(56, 135, 'Jueves 9/11', 998, 'deportiva', 250, 201),
(57, 135, 'tarde de jueves', 998, 'deportiva', 252, 202),
(58, 135, 'Postman Modificada', 1000, 'Ascenso', 653, 210);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseñas_marcas`
--

CREATE TABLE `reseñas_marcas` (
  `id_marca` int(2) NOT NULL,
  `detalle` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reseñas_marcas`
--

INSERT INTO `reseñas_marcas` (`id_marca`, `detalle`) VALUES
(135, 'Es una marca japonesa'),
(134, 'Esta fábrica comenzó en Japón con Soichiro Honda'),
(140, 'Es una marca japonesa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `mail`, `password`) VALUES
(1, 'webadmin', '$2y$10$foMxsHfqnLSb9B/MSfy3jOPVX/plsRSgws3bv6kMP/H.rZkK0IDwm');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_marca` (`id_marca`);

--
-- Indices de la tabla `reseñas_marcas`
--
ALTER TABLE `reseñas_marcas`
  ADD KEY `id_marca` (`id_marca`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT de la tabla `modelos`
--
ALTER TABLE `modelos`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD CONSTRAINT `modelos_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reseñas_marcas`
--
ALTER TABLE `reseñas_marcas`
  ADD CONSTRAINT `reseñas_marcas_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
