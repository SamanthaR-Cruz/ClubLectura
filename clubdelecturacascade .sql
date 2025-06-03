-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-05-2025 a las 14:39:16
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `clubdelecturacascade`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `idComentario` int(11) NOT NULL,
  `tituloComentario` varchar(50) NOT NULL,
  `descripcionComentario` text NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`idComentario`, `tituloComentario`, `descripcionComentario`, `idUsuario`) VALUES
(4, 'Gran Lectura', 'Cada frase me dejó una enseñanza', 1),
(9, 'El principito', 'Me encantaron todas las enseñanzas', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `idEvento` int(11) NOT NULL,
  `nombreEvento` varchar(75) NOT NULL,
  `fechaEvento` date NOT NULL,
  `descripcionEvento` varchar(30) NOT NULL,
  `lugarEvento` varchar(30) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`idEvento`, `nombreEvento`, `fechaEvento`, `descripcionEvento`, `lugarEvento`, `idUsuario`) VALUES
(1, 'Taller de narrativa', '2025-06-05', 'Ejercicios para crear personaj', 'Biblioteca central', 1),
(2, 'Club de lectura: Rayuela', '2025-06-10', 'Discusión literaria sobre Rayu', 'Aula 2', 1),
(3, 'Foro abierto: Literatura Feminista', '2025-06-15', 'Intercambio de ideas sobre aut', 'Auditorio norte', 1),
(4, 'Discusion: El Principito', '2025-05-31', 'Discusión mejores Reflexiones', 'Biblioteca', 1),
(5, 'Intercambio de Libros', '2025-05-30', 'Trae un libro viejo y llevate ', 'Sala ITS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventosusuario`
--

CREATE TABLE `eventosusuario` (
  `idEventoUsuario` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventosusuario`
--

INSERT INTO `eventosusuario` (`idEventoUsuario`, `idEvento`, `idUsuario`) VALUES
(9, 4, 4),
(39, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `idLibro` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `autor` varchar(30) NOT NULL,
  `genero` varchar(20) NOT NULL,
  `numPag` int(11) NOT NULL,
  `descripcionLibro` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`idLibro`, `titulo`, `autor`, `genero`, `numPag`, `descripcionLibro`) VALUES
(3, 'El primer amor', 'Iván Turguénev', 'Ficcion', 65, 'Yaprak ha estado alejada del mundo de las chicas de su edad...'),
(14, 'Mujercitas', 'Louisa May Alcott', 'Literatura', 345, 'Muejrcitas'),
(16, 'Dracula', 'Bram Stoker', 'Novela', 234, 'Dracula');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `librousuario`
--

CREATE TABLE `librousuario` (
  `idLibroUsuario` int(11) NOT NULL,
  `idLibro` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaTermino` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `librousuario`
--

INSERT INTO `librousuario` (`idLibroUsuario`, `idLibro`, `idUsuario`, `fechaInicio`, `fechaTermino`) VALUES
(3, 3, 1, '2025-05-28', '2025-05-28'),
(9, 14, 1, '2025-05-28', '2025-05-28'),
(12, 3, 5, '2025-05-28', NULL),
(16, 16, 1, '2025-05-28', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `numeroControl` varchar(20) NOT NULL,
  `contrasena` varchar(20) NOT NULL,
  `nombreCompleto` varchar(30) NOT NULL,
  `correo` varchar(30) NOT NULL,
  `rol` int(11) NOT NULL COMMENT '1 - Administrador | 2 - Cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `numeroControl`, `contrasena`, `nombreCompleto`, `correo`, `rol`) VALUES
(1, '22010986', '2312', 'Maria de Jesus Rivera Gomez', '22010986@gmail.com', 1),
(2, '22010987', '2312', 'Samantha Rodriguez Cruz', '22010987@gmail.com', 1),
(3, '22011015', '2312', 'Victor Zuñiga Avalos', '22011015@gmail.com', 1),
(4, '22010899', '2312', 'Padro Coronado Carmona', '22010899@gmail.com', 2),
(5, '22010906', '2312', 'Isabel Diaz Galindo', '22010906@gmail.com', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`idComentario`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`idEvento`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `eventosusuario`
--
ALTER TABLE `eventosusuario`
  ADD PRIMARY KEY (`idEventoUsuario`),
  ADD KEY `idEvento` (`idEvento`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`idLibro`);

--
-- Indices de la tabla `librousuario`
--
ALTER TABLE `librousuario`
  ADD PRIMARY KEY (`idLibroUsuario`),
  ADD KEY `idLibro` (`idLibro`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `idComentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `idEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `eventosusuario`
--
ALTER TABLE `eventosusuario`
  MODIFY `idEventoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `idLibro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `librousuario`
--
ALTER TABLE `librousuario`
  MODIFY `idLibroUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `eventosusuario`
--
ALTER TABLE `eventosusuario`
  ADD CONSTRAINT `idEvento` FOREIGN KEY (`idEvento`) REFERENCES `eventos` (`idEvento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `librousuario`
--
ALTER TABLE `librousuario`
  ADD CONSTRAINT `librousuario_ibfk_1` FOREIGN KEY (`idLibro`) REFERENCES `libros` (`idLibro`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `librousuario_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
