-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-06-2023 a las 09:57:43
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
-- Base de datos: `mi_armario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(1, 'Ropas'),
(2, 'Zapatos'),
(3, 'Complementos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conjunto`
--

CREATE TABLE `conjunto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `fecha_creacion` date NOT NULL,
  `imagen_conjunto` varchar(100) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `conjunto`
--

INSERT INTO `conjunto` (`id`, `nombre`, `descripcion`, `fecha_creacion`, `imagen_conjunto`, `id_usuario`) VALUES
(1, 'Conjunto de piscina', 'Conjunto para días calurosos', '2023-06-13', '', 2),
(2, 'Conjunto de Invierno', 'Conjunto para días fríos', '2023-06-13', '', 2),
(6, 'Conjunto dia normal clase', 'Conjunto dia normal clase', '2023-06-14', 'Conjunto_dia_normal_clase', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conjuntos_temporadas`
--

CREATE TABLE `conjuntos_temporadas` (
  `id_conjunto` int(11) NOT NULL,
  `id_temporada` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `conjuntos_temporadas`
--

INSERT INTO `conjuntos_temporadas` (`id_conjunto`, `id_temporada`) VALUES
(1, 1),
(2, 2),
(6, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialuso`
--

CREATE TABLE `historialuso` (
  `id_historial` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_conjunto` int(11) NOT NULL,
  `evento_dia` varchar(200) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historialuso`
--

INSERT INTO `historialuso` (`id_historial`, `id_usuario`, `id_conjunto`, `evento_dia`, `fecha`) VALUES
(3, 2, 6, 'Para el lunes de clase', '2023-06-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prenda`
--

CREATE TABLE `prenda` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `talla` varchar(10) NOT NULL,
  `color` varchar(30) NOT NULL,
  `marca` varchar(30) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `fecha_insercion` date DEFAULT NULL,
  `id_subcategoria` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prenda`
--

INSERT INTO `prenda` (`id`, `nombre`, `descripcion`, `talla`, `color`, `marca`, `imagen`, `fecha_insercion`, `id_subcategoria`, `id_usuario`) VALUES
(1, 'Camiseta Manga Corta', 'Camiseta de manga corta para verano', 's', 'Blanco', 'Nike', '303ar5004-101', '2023-01-01', 2, 2),
(2, 'Pantalón Vaquero', 'Pantalón vaquero largo para uso diario', 'M', 'Azul Marino', 'Levis', 'gallery_M154028_1', '2023-06-12', 3, 2),
(3, 'Zapatillas Running Pro', 'Zapatillas azules running Pro perfectas para largos recorridos', '41', '', 'Adidas', 'zapatillasAdidasRunningAzules', NULL, 4, 2),
(4, 'Zapatos Traje', 'Zapatos de traje negros', '41', 'Negro', 'Louis Vuitton', 'zapatosNegros', '1970-01-01', 5, 2),
(5, 'Sandalias rojas', 'Sandalias rojas perfectas para ir por la playa en verano', '41', '', 'Adidas', 'chanclasRojasAdidas', NULL, 6, 2),
(7, 'Chanclas Nike', 'Chanclas Nike negras pa veranito', '41', 'negro', 'nike', 'chanclaNikeNengra', '2023-05-29', 6, 2),
(9, 'air force', 'air force nike blancas', '41', 'blanco', 'nike', 'Nike-air-force-1', '2023-05-29', 4, 2),
(12, 'bolso sobre', 'de sobre pequeño poco espacio', 's', 'fucsia', 'louis voitton', 'bolsos-de-fiesta-tipo-sobre-fucsias-bugambilias-ideales-para-tu-vestido', '2023-06-12', 33, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prendas_conjuntos`
--

CREATE TABLE `prendas_conjuntos` (
  `id_prenda` int(11) NOT NULL,
  `id_conjunto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prendas_conjuntos`
--

INSERT INTO `prendas_conjuntos` (`id_prenda`, `id_conjunto`) VALUES
(1, 6),
(2, 2),
(2, 6),
(4, 2),
(9, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prendas_temporadas`
--

CREATE TABLE `prendas_temporadas` (
  `id_prenda` int(11) NOT NULL,
  `id_temporada` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prendas_temporadas`
--

INSERT INTO `prendas_temporadas` (`id_prenda`, `id_temporada`) VALUES
(1, 4),
(2, 2),
(2, 3),
(3, 4),
(4, 4),
(5, 1),
(7, 1),
(9, 4),
(12, 3),
(12, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Usuario'),
(3, 'SuperUser');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategoria`
--

CREATE TABLE `subcategoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `subcategoria`
--

INSERT INTO `subcategoria` (`id`, `nombre`, `id_categoria`) VALUES
(2, 'Camisetas', 1),
(3, 'Pantalones', 1),
(4, 'Zapatillas', 2),
(5, 'Zapatos', 2),
(6, 'Sandalias', 2),
(29, 'Botas', 2),
(30, 'Zapatos con tacón', 2),
(31, 'Gorretas', 3),
(32, 'Gafas', 3),
(33, 'Bolsos', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temporada`
--

CREATE TABLE `temporada` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `temporada`
--

INSERT INTO `temporada` (`id`, `nombre`) VALUES
(1, 'verano'),
(2, 'invierno'),
(3, 'primavera/otono'),
(4, 'cualquiera');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellidos`, `correo`, `username`, `password`, `id_rol`) VALUES
(1, 'Juan', 'Perez', 'juan@example.com', 'juan', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 3),
(2, 'Gil Pablo', 'Blanco Pérez', 'gilpablo@example.com', 'gilpablo', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 1),
(6, 'Diego', 'Blanco Pérez', 'diego@example.com', 'diego', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 2),
(8, 'prueba', 'pruebasa', 'prueba@example.es', 'prueba', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `conjunto`
--
ALTER TABLE `conjunto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_conjunto` (`id_usuario`);

--
-- Indices de la tabla `conjuntos_temporadas`
--
ALTER TABLE `conjuntos_temporadas`
  ADD PRIMARY KEY (`id_conjunto`,`id_temporada`),
  ADD KEY `id_temporada` (`id_temporada`);

--
-- Indices de la tabla `historialuso`
--
ALTER TABLE `historialuso`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `fk_historialuso1` (`id_usuario`),
  ADD KEY `fk_historialuso2` (`id_conjunto`);

--
-- Indices de la tabla `prenda`
--
ALTER TABLE `prenda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_prenda1` (`id_subcategoria`),
  ADD KEY `fk_prenda2` (`id_usuario`);

--
-- Indices de la tabla `prendas_conjuntos`
--
ALTER TABLE `prendas_conjuntos`
  ADD PRIMARY KEY (`id_prenda`,`id_conjunto`),
  ADD KEY `id_conjunto` (`id_conjunto`);

--
-- Indices de la tabla `prendas_temporadas`
--
ALTER TABLE `prendas_temporadas`
  ADD PRIMARY KEY (`id_prenda`,`id_temporada`),
  ADD KEY `id_temporada` (`id_temporada`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subcategoria` (`id_categoria`);

--
-- Indices de la tabla `temporada`
--
ALTER TABLE `temporada`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `conjunto`
--
ALTER TABLE `conjunto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `historialuso`
--
ALTER TABLE `historialuso`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `prenda`
--
ALTER TABLE `prenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `temporada`
--
ALTER TABLE `temporada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `conjunto`
--
ALTER TABLE `conjunto`
  ADD CONSTRAINT `fk_conjunto` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `conjuntos_temporadas`
--
ALTER TABLE `conjuntos_temporadas`
  ADD CONSTRAINT `conjuntos_temporadas_ibfk_1` FOREIGN KEY (`id_conjunto`) REFERENCES `conjunto` (`id`),
  ADD CONSTRAINT `conjuntos_temporadas_ibfk_2` FOREIGN KEY (`id_temporada`) REFERENCES `temporada` (`id`);

--
-- Filtros para la tabla `historialuso`
--
ALTER TABLE `historialuso`
  ADD CONSTRAINT `fk_historialuso1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_historialuso2` FOREIGN KEY (`id_conjunto`) REFERENCES `conjunto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prenda`
--
ALTER TABLE `prenda`
  ADD CONSTRAINT `fk_prenda` FOREIGN KEY (`id_subcategoria`) REFERENCES `subcategoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prenda2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prendas_conjuntos`
--
ALTER TABLE `prendas_conjuntos`
  ADD CONSTRAINT `prendas_conjuntos_ibfk_1` FOREIGN KEY (`id_prenda`) REFERENCES `prenda` (`id`),
  ADD CONSTRAINT `prendas_conjuntos_ibfk_2` FOREIGN KEY (`id_conjunto`) REFERENCES `conjunto` (`id`);

--
-- Filtros para la tabla `prendas_temporadas`
--
ALTER TABLE `prendas_temporadas`
  ADD CONSTRAINT `fk_prendas_temporadas_prenda` FOREIGN KEY (`id_prenda`) REFERENCES `prenda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prendas_temporadas_ibfk_1` FOREIGN KEY (`id_prenda`) REFERENCES `prenda` (`id`),
  ADD CONSTRAINT `prendas_temporadas_ibfk_2` FOREIGN KEY (`id_temporada`) REFERENCES `temporada` (`id`);

--
-- Filtros para la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD CONSTRAINT `fk_subcategoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
