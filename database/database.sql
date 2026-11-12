-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-11-2026 a las 00:39:26
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `devforum`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`) VALUES
(5, 'Ciberseguridad'),
(2, 'Hardware'),
(1, 'Programación'),
(4, 'Tecnología'),
(3, 'Videojuegos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_publicacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `contenido`, `fecha_creacion`, `id_usuario`, `id_publicacion`) VALUES
(1, 'comentario de prueba', '2026-11-08 19:42:29', 2, 1),
(2, 'proba hacer for (int i ; i = 0 ; i >= 5 ; i++)', '2026-11-11 19:55:51', 4, 2),
(3, 'te va explotar la pc', '2026-11-12 18:35:18', 5, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `id_publicacion` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`id_publicacion`, `titulo`, `contenido`, `fecha_creacion`, `id_usuario`, `id_categoria`) VALUES
(1, 'Mi primera publicación', 'Esta es una publicación de prueba de DevForum.', '2026-11-04 19:00:13', 1, 1),
(2, '¿como programo usando java?', 'solo se hacer systems.out.print', '2026-11-05 17:22:18', 2, 1),
(3, 'que es mejor warzone o fortnite?', 'eso, no se que es mejor', '2026-11-11 19:56:57', 4, 3),
(4, 'si tengo un ryzen 5 5600g puedo renderiza en 4k?', 'eso gente saquenme la duda', '2026-11-11 20:01:53', 3, 2),
(5, 'me compro el iphone 18 o mejor un s26?', 'quiero comprar un telefono y no se cual', '2026-11-12 18:19:41', 4, 4),
(6, 'empiezo programando en python o en java?', 'me dijeron que empieze por java pero no se', '2026-11-12 18:35:02', 5, 1),
(7, 'como hackeo un wifi?', 'mi vecino tiene starlink y yo lo quiero usar igual', '2026-11-12 18:36:50', 6, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `rol`) VALUES
(1, 'UsuarioPrueba', 'prueba@devforum.com', '$2y$10$2BZMKmw1Xxq.WNaZZkJSee6X5CtFznQmpvXYftFugyiTCbnB2ln2a', 'usuario'),
(2, 'pepe', 'pepe@gmail.com', '$2y$10$yoQDwEu.AsddN6Mcy4Yw7OaUwEUxEXZYXg10jyx./L6isKq6roKBK', 'usuario'),
(3, 'juan', 'juancarlos@gmail.com', '$2y$10$XsPSTSXncgZwnQwCU9DOmuOQjEGDpS31WNptZi0HmDunlOn.UzRI2', 'usuario'),
(4, 'pedro', 'pedro@gmail.com', '$2y$10$L.P6ht88FigrpJLGivf4x.bzP5JHjWWQblrJ25ddO/gq88JpqDDOa', 'usuario'),
(5, 'estebanquito', 'esteban@gmail.com', '$2y$10$mofFmdWo5AVEmWZ9n/rY1ObWiwDCMO7x1XGUk0Mfx1RI6U8sOaT9u', 'usuario'),
(6, 'juanpacopedro', 'juan@gmail.com', '$2y$10$AkgI.REBXCbHWw6hGgxh/eQ7N6SR.gh/KNFgMd8mMLF22Xv0pOZBe', 'usuario'),
(7, 'estebanquitooo', 'estebannn@gmail.com', '$2y$10$UyVuxcU1biC9cN3LvovLG.LRM86FxnRrlbkhZZu0BhReaIqNiijrC', 'usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `comentarios_ibfk_1` (`id_publicacion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id_publicacion`),
  ADD KEY `publicaciones_ibfk_1` (`id_categoria`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id_publicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_publicacion`) REFERENCES `publicaciones` (`id_publicacion`) ON UPDATE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON UPDATE CASCADE,
  ADD CONSTRAINT `publicaciones_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
