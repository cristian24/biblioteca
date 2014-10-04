-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-10-2014 a las 04:50:18
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE IF NOT EXISTS `autores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`id`, `nombre`) VALUES
(1, 'Anonimo'),
(2, 'Fabian Andrés'),
(3, 'Carmen'),
(4, 'Antonio'),
(5, 'Juan Zolano'),
(6, 'Jhon Lennon'),
(7, 'Armando'),
(8, 'Daniel Hepe'),
(9, 'Pruebin Autor'),
(10, 'Marcon Antonio Solis'),
(11, 'Autorin'),
(12, 'Pruebin 3'),
(13, 'Autor1'),
(14, 'Tomato'),
(15, 'Tomato2'),
(16, 'Tomatin'),
(17, 'coso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE IF NOT EXISTS `documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo_p` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `titulo_s` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `idioma` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `ruta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `palabras_clave` varchar(300) COLLATE utf8_spanish2_ci NOT NULL,
  `id_editorial` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_editorial` (`id_editorial`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `documento`
--

INSERT INTO `documento` (`id`, `titulo_p`, `titulo_s`, `idioma`, `tipo`, `ruta`, `descripcion`, `palabras_clave`, `id_editorial`) VALUES
(8, 'Php Deitel', 'Php Para Principiantes', 'Español', 'Libro', 'foto.jpg', 'Es el libro para principiantes de php en el podras encontar ejemplos practicos como fuerte documentación que te serviran para volverte un programador experto.', 'php, ciclos, condicionales, html, excepciones, manejo archivos, formularios, logica', 6),
(9, 'Java desde ''0''', 'Java para principiantes', 'Español', 'Libro', 'foto1.jpg', 'Libro de java desde 0 el cual aborada temas muy simples, pero a medida que avanza los capitulos, se mostraran temas más complejos.', 'java, poo, oo, ciclos, excepciones, archivos', 6),
(10, 'Manejo de Windows 8', 'Windows 8', 'Español', 'Escrito/Resumen', '1910168_10152179671336879_4411991258.jpg', 'Guia basica del manejo de windows 8 en el aprenderas a navegar a través de la nueva interfaz metro, se abordaran temas de la compatibilidad de otros  S.O.', 'Metro UI, Compatibilidad, Pantallazo Azul', 1),
(11, 'Metodo Relajación China', 'Relajación China', 'Español', 'Diagrama', '1910168_10152179671336879_4411991258.jpg', 'Imagen que representa un metodo de relajacion china, la cual nos sirve para equilibrar nuestra mente y cuerpo, en caso de tener ira, preocupación, temor etc..', 'Relajación, Mano, Dedos, Ira, Temor', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editorial`
--

CREATE TABLE IF NOT EXISTS `editorial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `editorial`
--

INSERT INTO `editorial` (`id`, `nombre`) VALUES
(1, 'No Aplica'),
(2, 'Head the First O''relly'),
(3, 'Los tres Editores S.A.S'),
(4, 'Los Camelitos'),
(5, 'Pruebin Editorial ñandú'),
(6, 'Deitel & Deitel'),
(7, 'Editorial Prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escrito`
--

CREATE TABLE IF NOT EXISTS `escrito` (
  `id_documento` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  PRIMARY KEY (`id_documento`,`id_autor`),
  KEY `id_autor` (`id_autor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `escrito`
--

INSERT INTO `escrito` (`id_documento`, `id_autor`) VALUES
(11, 1),
(8, 4),
(8, 7),
(10, 8),
(9, 9),
(9, 10),
(8, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `login` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `pass` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` varchar(11) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `perfil` enum('Administrador','Catalogador','Usuario') COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'Usuario',
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=19 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `login`, `pass`, `correo`, `telefono`, `perfil`) VALUES
(1, 'Cristian Andrés Cuspoca Salcedo', 'cris', '202cb962ac59075b964b07152d234b70', 'yancris_15@hotmail.com', '3185090472', 'Administrador'),
(4, 'Viviana Maria', 'vivianita', '202cb962ac59075b964b07152d234b70', 'vivianita@hotmail.com', '3185090477', 'Usuario'),
(5, 'Amanda Gonzalez', 'amandita', '202cb962ac59075b964b07152d234b70', 'amandita@hotmail.com', '3185090477', 'Catalogador'),
(7, 'Armando', 'armando1', '202cb962ac59075b964b07152d234b70', 'armando12@hotmail.com', '3185590477', 'Usuario'),
(13, 'Lina Maria', 'linita', '202cb962ac59075b964b07152d234b70', 'lina12@hotmail.com', '3185090472', 'Catalogador'),
(14, 'Andrea Camello', 'andreina', '202cb962ac59075b964b07152d234b70', 'andreas12@hotmail.com', '3185090474', 'Catalogador'),
(16, 'Martha Lorena Cuspoca', 'lorenita12', '202cb962ac59075b964b07152d234b70', 'martha@hotmail.com', '3156789456', 'Usuario'),
(18, 'Alberto Camelo', 'albertin', '202cb962ac59075b964b07152d234b70', 'albertin@hotmail.com', '3185090472', 'Administrador');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`id_editorial`) REFERENCES `editorial` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `escrito`
--
ALTER TABLE `escrito`
  ADD CONSTRAINT `escrito_ibfk_1` FOREIGN KEY (`id_documento`) REFERENCES `documento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `escrito_ibfk_2` FOREIGN KEY (`id_autor`) REFERENCES `autores` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
