-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-07-2025 a las 03:44:14
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `2h_signos_para_todos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadistica`
--

CREATE TABLE `estadistica` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(255) NOT NULL,
  `total_completadas` int(11) NOT NULL,
  `tiempo_total` int(11) NOT NULL,
  `precision_media` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `glosario`
--

CREATE TABLE `glosario` (
  `id` int(11) NOT NULL,
  `id_personal` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `glosario`
--

INSERT INTO `glosario` (`id`, `id_personal`, `nombre`, `descripcion`, `fecha_creacion`) VALUES
(1, '123', 'THIS IS RADIOACTIVEEEEE!!!', 'Señas para canciones pers.', '2000-10-10'),
(2, 'T906', 'Casa', 'Señas para cada cosita en casa', '2025-12-15'),
(3, '123', 'ANIMALES', 'Favoritos por la comunidad LSV', '2025-07-11'),
(17, '123', 'Favoritas', 'Todas mis señas favoritas de uso cotidiano', '2025-07-13'),
(30, '123', 'Colores', 'Señas básicas de los colores primarios', '2025-07-10'),
(31, '123', 'Animales', 'Señas de animales menos favoritas', '2025-07-11'),
(40, '123', 'Kitsune', 'XXX', '2025-07-29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `id` int(11) NOT NULL,
  `nivel` varchar(40) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`id`, `nivel`, `descripcion`, `orden`) VALUES
(1, 'basico', 'sin conocimientos - maneja lo basico', 1),
(2, 'intermedio', 'punto medio', 2),
(3, 'avanzado', 'avanzado - interprete', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sena`
--

CREATE TABLE `sena` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `video_path` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sena`
--

INSERT INTO `sena` (`id`, `nombre`, `descripcion`, `video_path`, `tipo`) VALUES
(59, 'Pruebas XD', 'XXX', 'videos/6875c8802d581.webm', 'Testeo'),
(69, 'Seña personal', 'Seña alusiva a mi nombre dada por Moises', 'videos/6887f6c7a9187.webm', 'Personales'),
(70, 'Perro', 'Seña para los perros en general', 'videos/6887f6e82c17a.webm', 'Animales'),
(71, 'Zorro', 'Animal favorito', 'videos/6887f706ad563.webm', 'Animales'),
(72, 'Angel', 'Seña personal', 'videos/6887fd91b9919.webm', 'Personales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sen_glosario`
--

CREATE TABLE `sen_glosario` (
  `id` int(11) NOT NULL,
  `id_sena` int(11) NOT NULL,
  `id_glosario` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sen_glosario`
--

INSERT INTO `sen_glosario` (`id`, `id_sena`, `id_glosario`, `descripcion`) VALUES
(22, 59, 3, ''),
(32, 69, 1, ''),
(33, 70, 1, ''),
(34, 71, 1, ''),
(35, 72, 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

CREATE TABLE `tema` (
  `id` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `link_pdf` varchar(255) DEFAULT NULL,
  `link_youtube` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tema`
--

INSERT INTO `tema` (`id`, `id_modulo`, `nombre`, `descripcion`, `link_pdf`, `link_youtube`) VALUES
(26, 1, 'Abecedario LSV - Estado Bolivar', 'Abecedario LSV Estado Bolivar Bolivar', '/2h_signos_para_todos/pdfs/tema_68854ce7751ac1.07515967.pdf', 'https://www.youtube.com/shorts/BMylP5uo42w?feature=share'),
(27, 1, 'Emociones LSV - Estado Bolivar', 'Mención de algunas de las señas para las emociones', '/2h_signos_para_todos/pdfs/tema_6887ea0ca08556.68582728.pdf', 'https://www.youtube.com/watch?v=Q7VvbUQDOn4&pp=ygUNZW1vY2lvbmVzIGxzdg%3D%3D'),
(28, 1, 'Profesiones LSV - Estado Bolivar', 'Mencion de unas cuantas profesiones', '/2h_signos_para_todos/pdfs/tema_6887ea5e8aa4e3.56241513.pdf', 'https://www.youtube.com/watch?v=a16WLgQ9Onk&pp=ygUPcHJvZmVzaW9uZXMgbHN2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_personal` varchar(255) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `foto_perfil` varchar(255) NOT NULL,
  `nivel` varchar(255) NOT NULL,
  `fecha_nac` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_personal`, `nombre`, `apellido`, `email`, `contrasena`, `tipo`, `foto_perfil`, `nivel`, `fecha_nac`) VALUES
('023', 'Lexa', 'Nemia', 'kitsune@gmail.com', '321', 'hablante', '', 'sin conocimientos', '2002-12-03'),
('123', 'angelg', 'castillo', 'paulitoangel@hotmail.com', '321', 'estudiante', 'FP - Pinceladas.png', 'sin conocimientos', '2025-05-01'),
('anel', 'Angel', 'Gonzalez', 'anel@gmail.com', '123', 'estudiante', '[value-6]', 'sin conocimientos', '2025-12-03'),
('axelox', 'angel', 'gonzalez', 'anel123@gmail.com', '1234', 'estudiante', 'FP - Pinceladas - IG.png', 'sin conocimientos', '2025-05-19'),
('T906', 'Miguel', 'Patatero', 'miguel@gmail.com', '123', 'estudiante', '', 'sin conocimientos', '2025-07-04'),
('U001', 'Juan', 'Pérez', 'juan.perez@example.com', 'pass123', 'estudiante', '', 'basico', '1995-04-12'),
('U002', 'María', 'González', 'maria.gonzalez@example.com', 'maria456', 'hablante', '', 'intermedio', '1990-08-22'),
('U003', 'Carlos', 'Ramírez', 'carlos.ramirez@example.com', 'carlos789', 'interprete', '', 'avanzado', '1985-12-01'),
('U004', 'Ana', 'Martínez', 'ana.martinez@example.com', 'ana321', 'estudiante', '', 'sin conocimientos', '2000-03-18'),
('U005', 'Luis', 'Fernández', 'luis.fernandez@example.com', 'luis654', 'hablante', '', 'basico', '1998-07-07'),
('U006', 'Alicia', 'Suarez', 'alicia.suarez@example.com', 'alicia123', 'estudiante', '', 'basico', '1997-05-15'),
('U007', 'Diego', 'Lopez', 'diego.lopez@example.com', 'diego456', 'hablante', '', 'intermedio', '1992-11-23'),
('U008', 'Lorena', 'Diaz', 'lorena.diaz@example.com', 'lorena789', 'interprete', '', 'avanzado', '1988-02-10'),
('U009', 'Santiago', 'Rojas', 'santiago.rojas@example.com', 'santiago321', 'estudiante', '', 'sin conocimientos', '2001-06-30'),
('U010', 'Valeria', 'Castillo', 'valeria.castillo@example.com', 'valeria654', 'hablante', '', 'basico', '1995-09-12'),
('U011', 'Fernando', 'Gomez', 'fernando.gomez@example.com', 'fernando987', 'interprete', '', 'intermedio', '1987-04-05'),
('U012', 'Mariana', 'Herrera', 'mariana.herrera@example.com', 'mariana159', 'estudiante', '', 'avanzado', '1993-12-19'),
('U013', 'Ricardo', 'Vargas', 'ricardo.vargas@example.com', 'ricardo753', 'hablante', '', 'sin conocimientos', '2000-01-25'),
('U014', 'Arelis', 'Turkish', 'petrovika@gmail.com', 'patata', 'interprete', '', 'intermedio', '1998-08-14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_modulo`
--

CREATE TABLE `usuario_modulo` (
  `id` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `id_personal` varchar(255) NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estadistica`
--
ALTER TABLE `estadistica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_usuario_2` (`id_usuario`);

--
-- Indices de la tabla `glosario`
--
ALTER TABLE `glosario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_personal`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sena`
--
ALTER TABLE `sena`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sen_glosario`
--
ALTER TABLE `sen_glosario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Id_sena` (`id_sena`,`id_glosario`),
  ADD KEY `id_glosario` (`id_glosario`);

--
-- Indices de la tabla `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tema_modulo` (`id_modulo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_personal`);

--
-- Indices de la tabla `usuario_modulo`
--
ALTER TABLE `usuario_modulo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_modulo` (`id_modulo`),
  ADD UNIQUE KEY `id_personal` (`id_personal`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `glosario`
--
ALTER TABLE `glosario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sena`
--
ALTER TABLE `sena`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `sen_glosario`
--
ALTER TABLE `sen_glosario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `tema`
--
ALTER TABLE `tema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `usuario_modulo`
--
ALTER TABLE `usuario_modulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `estadistica`
--
ALTER TABLE `estadistica`
  ADD CONSTRAINT `estadistica_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_personal`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `glosario`
--
ALTER TABLE `glosario`
  ADD CONSTRAINT `glosario_ibfk_1` FOREIGN KEY (`id_personal`) REFERENCES `usuario` (`id_personal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sen_glosario`
--
ALTER TABLE `sen_glosario`
  ADD CONSTRAINT `sen_glosario_ibfk_1` FOREIGN KEY (`Id_sena`) REFERENCES `sena` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sen_glosario_ibfk_2` FOREIGN KEY (`Id_glosario`) REFERENCES `glosario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sen_glosario_ibfk_3` FOREIGN KEY (`id_sena`) REFERENCES `sena` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sen_glosario_ibfk_4` FOREIGN KEY (`id_glosario`) REFERENCES `glosario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tema`
--
ALTER TABLE `tema`
  ADD CONSTRAINT `fk_tema_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `modulo` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuario_modulo`
--
ALTER TABLE `usuario_modulo`
  ADD CONSTRAINT `usuario_modulo_ibfk_1` FOREIGN KEY (`id_modulo`) REFERENCES `modulo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_modulo_ibfk_2` FOREIGN KEY (`id_personal`) REFERENCES `usuario` (`id_personal`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
