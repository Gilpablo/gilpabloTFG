<<<<<<< Updated upstream
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-05-2023 a las 00:05:46
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
=======
create schema mi_armario;
use mi_armario;
>>>>>>> Stashed changes


--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  constraint pk_rol primary key(id)
);

INSERT INTO `rol` (`nombre`) VALUES
('Administrador'),
('Usuario');


--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `nombre` varchar(50) NOT NULL,
	  `apellidos` varchar(50) NOT NULL,
	  `correo` varchar(100) NOT NULL,
	  `username` varchar(50) NOT NULL,
	  `password` varchar(100) NOT NULL unique,
	  `id_rol` int(11) NOT NULL,
	  constraint pk_usuario primary key(id),
	  constraint fk_usuario foreign key(id_rol) references rol(id) on delete cascade on update cascade
) ;

INSERT INTO `usuario` (`nombre`, `apellidos`, `correo`, `username`, `password`, `id_rol`) VALUES
('Juan', 'Perez', 'juan@example.com', 'juan', '1234', 1),
('Gil Pablo', 'Blanco Pérez', 'gilpablo@example.com', 'gilpablo', '1234', 2);



CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  constraint pk_categoria primary key(id)
);

INSERT INTO `categoria` (`nombre`) VALUES
('Prendas'),
('Zapatos'),
('Complementos');

-- --------------------------------------------------------

CREATE TABLE `subcategoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  constraint pk_subcategoria primary key(id),
  constraint fk_subcategoria foreign key(id_categoria) references categoria(id) on delete cascade on update cascade
);
INSERT INTO `subcategoria` (`nombre`, `id_categoria`) VALUES
('Chaquetas', 1),
('Camisetas', 1),
('Pantalones', 1);


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prenda`
--

CREATE TABLE `prenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
<<<<<<< Updated upstream
  `id_subcategoria` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
=======
  `id_subcategoria` int(11) DEFAULT NULL,
  constraint pk_prenda primary key(id),
  constraint fk_prenda foreign key(id_subcategoria) references subcategoria(id) on delete cascade on update cascade
);
>>>>>>> Stashed changes

INSERT INTO `prenda` (`nombre`, `descripcion`, `id_subcategoria`) VALUES
('Camiseta Manga Corta', 'Camiseta de manga corta para verano', 1),
('Pantalón Vaquero', 'Pantalón vaquero para uso diario', 2);

<<<<<<< Updated upstream
INSERT INTO `prenda` (`id`, `nombre`, `descripcion`, `id_subcategoria`, `id_usuario`) VALUES
(1, 'Camiseta Manga Corta', 'Camiseta de manga corta para verano', 1, 2),
(2, 'Pantalón Vaquero', 'Pantalón vaquero para uso diario', 2, 2),
(3, 'Tacones Rojos Altos', NULL, 4, 2),
(4, 'Zapatillas Deporte', NULL, 5, 2);

-- --------------------------------------------------------
=======
>>>>>>> Stashed changes

-- ----------------------------------------------------------------
--
-- Estructura de tabla para la tabla `conjunto`
--

CREATE TABLE `conjunto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  constraint pk_conjunto primary key(id),
  constraint fk_conjunto foreign key(id_usuario) references usuario(id) on delete cascade on update cascade
);

INSERT INTO `conjunto` (`nombre`, `descripcion`, `id_usuario`) VALUES
('Conjunto de Verano', 'Conjunto para días calurosos', 2),
('Conjunto de Invierno', 'Conjunto para días fríos', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conjunto_prenda`
--

CREATE TABLE `conjunto_prenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_conjunto` int(11) NOT NULL,
  `id_prenda` int(11) NOT NULL,
  constraint pk_conjunto_prenda primary key(id),
  constraint fk_conjunto_prenda1 foreign key(id_conjunto) references conjunto(id) on delete cascade on update cascade,
  constraint fk_conjunto_prenda2 foreign key(id_prenda) references prenda(id) on delete cascade on update cascade
);

<<<<<<< Updated upstream
INSERT INTO `subcategoria` (`id`, `nombre`, `id_categoria`) VALUES
(1, 'Camisetas', 1),
(2, 'Pantalones', 1),
(3, 'Chaquetas', 1),
(4, 'Tacones', 2),
(5, 'Zapatillas', 2);
=======
INSERT INTO `conjunto_prenda` (`id_conjunto`, `id_prenda`) VALUES
(1, 1),
(2, 2);
>>>>>>> Stashed changes

-- --------------------------------------------------------

--
<<<<<<< Updated upstream
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `id_rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellidos`, `correo`, `username`, `password`, `id_rol`) VALUES
(1, 'Juan', 'Perez', 'juan@example.com', 'juan', '1234', 1),
(2, 'Gil Pablo', 'Blanco Pérez', 'gilpablo@example.com', 'gilpablo', '1234', 2);

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
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `conjunto_prenda`
--
ALTER TABLE `conjunto_prenda`
  ADD PRIMARY KEY (`id_conjunto`,`id_prenda`),
  ADD KEY `id_prenda` (`id_prenda`);

--
-- Indices de la tabla `historialuso`
--
ALTER TABLE `historialuso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_conjunto` (`id_conjunto`);

--
-- Indices de la tabla `prenda`
--
ALTER TABLE `prenda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_subcategoria` (`id_subcategoria`),
  ADD KEY `id_usuario` (`id_usuario`);

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
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Restricciones para tablas volcadas
=======
-- Estructura de tabla para la tabla `historialuso`
>>>>>>> Stashed changes
--

CREATE TABLE `historialuso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_conjunto` int(11) NOT NULL,
  `fecha` date NOT NULL,
  constraint pk_historialuso primary key(id),
  constraint fk_historialuso1 foreign key(id_usuario) references usuario(id) on delete cascade on update cascade,
  constraint fk_historialuso2 foreign key(id_conjunto) references conjunto(id) on delete cascade on update cascade
);

INSERT INTO `historialuso` (`id_usuario`, `id_conjunto`, `fecha`) VALUES
(2, 1, '2022-07-15'),
(2, 2, '2022-12-20');


<<<<<<< Updated upstream
--
-- Filtros para la tabla `prenda`
--
ALTER TABLE `prenda`
  ADD CONSTRAINT `prenda_ibfk_1` FOREIGN KEY (`id_subcategoria`) REFERENCES `subcategoria` (`id`),
  ADD CONSTRAINT `prenda_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);
=======
>>>>>>> Stashed changes



