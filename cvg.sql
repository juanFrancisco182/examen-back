-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 08-09-2022 a las 23:07:37
-- Versión del servidor: 5.7.34
-- Versión de PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cvg`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(30) NOT NULL,
  `descripcion_producto` text NOT NULL,
  `precio_producto` float NOT NULL,
  `fecha_registro_producto` date NOT NULL,
  `fecha_actualizacion_producto` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id_producto`, `nombre_producto`, `descripcion_producto`, `precio_producto`, `fecha_registro_producto`, `fecha_actualizacion_producto`) VALUES
(1, 'pantalla LG 90 pulgs 12', 'Pantalla 90 pulg', 10001, '2007-09-22', '2022-09-08 10:54:12'),
(6, 'producto 55', 'pruebas ', 102938, '2022-09-08', '0000-00-00 00:00:00'),
(7, 'prueba 33', 'descripcion 33', 99, '2022-09-08', '0000-00-00 00:00:00'),
(8, 'pruebas ssss', 'test', 10, '2022-09-08', '0000-00-00 00:00:00'),
(9, 'prueba 5677', 'test', 74, '2022-09-08', '0000-00-00 00:00:00'),
(10, 'prueba 200', 'esto es una prueba', 10.3, '2022-09-08', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `avatar` varchar(130) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `first_name`, `last_name`, `avatar`) VALUES
(1, 'george.bluth@reqres.in', 'George', 'Bluth', 'https://reqres.in/img/faces/1-image.jpg'),
(2, 'janet.weaver@reqres.in', 'Janet', 'Weaver', 'https://reqres.in/img/faces/2-image.jpg'),
(3, 'emma.wong@reqres.in', 'Emma', 'Wong', 'https://reqres.in/img/faces/3-image.jpg'),
(4, 'eve.holt@reqres.in', 'Eve', 'Holt', 'https://reqres.in/img/faces/4-image.jpg'),
(5, 'charles.morris@reqres.in', 'Charles', 'Morris', 'https://reqres.in/img/faces/5-image.jpg'),
(6, 'francisco.echavarria182@gmail.com', 'Francisco', 'Guerra', 'https://reqres.in/img/faces/6-image.jpg'),
(7, 'michael.lawson@reqres.in', 'Michael', 'Lawson', 'https://reqres.in/img/faces/7-image.jpg'),
(8, 'lindsay.ferguson@reqres.in', 'Lindsay', 'Ferguson', 'https://reqres.in/img/faces/8-image.jpg'),
(9, 'tobias.funke@reqres.in', 'Tobias', 'Funke', 'https://reqres.in/img/faces/9-image.jpg'),
(10, 'byron.fields@reqres.in', 'Byron', 'Fields', 'https://reqres.in/img/faces/10-image.jpg'),
(11, 'george.edwards@reqres.in', 'George', 'Edwards', 'https://reqres.in/img/faces/11-image.jpg'),
(12, 'rachel.howell@reqres.in', 'Rachel', 'Howell', 'https://reqres.in/img/faces/12-image.jpg'),
(892, 'paco.echavarria182@gmail.com', 'Juan', 'echavarria', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=893;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
