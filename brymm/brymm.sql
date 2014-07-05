-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-11-2012 a las 12:03:33
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `brymm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos_local`
--

CREATE TABLE IF NOT EXISTS `articulos_local` (
  `id_articulo_local` int(12) NOT NULL AUTO_INCREMENT,
  `id_local` int(12) NOT NULL,
  `id_tipo_articulo` int(12) NOT NULL,
  `articulo` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `disponible` tinyint(1) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `fecha_alta` date NOT NULL,
  PRIMARY KEY (`id_articulo_local`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabla donde se dan de alta los articulos del local' AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `articulos_local`
--

INSERT INTO `articulos_local` (`id_articulo_local`, `id_local`, `id_tipo_articulo`, `articulo`, `descripcion`, `disponible`, `precio`, `fecha_alta`) VALUES
(1, 1, 1, 'pepito 1', 'jamon-bacon-queso', 1, 4, '2012-02-28'),
(2, 1, 1, 'pepito 2', 'jamon-pv', 1, 4, '2012-02-28'),
(3, 1, 2, 'pc 1', 'lomo - bacon-pv', 1, 6, '2012-02-28'),
(4, 1, 0, 'pepito 3', 'lomo - p.verde', 1, 4, '2012-04-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `det_articulo`
--

CREATE TABLE IF NOT EXISTS `det_articulo` (
  `id_det_articulo` int(12) NOT NULL AUTO_INCREMENT,
  `id_articulo_local` int(12) NOT NULL,
  `id_ingrediente` int(12) NOT NULL,
  PRIMARY KEY (`id_det_articulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `det_articulo`
--

INSERT INTO `det_articulo` (`id_det_articulo`, `id_articulo_local`, `id_ingrediente`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 1, 4),
(6, 2, 4),
(7, 2, 5),
(8, 3, 1),
(9, 3, 2),
(10, 3, 5),
(13, 4, 1),
(14, 4, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `det_articulo_personalizado`
--

CREATE TABLE IF NOT EXISTS `det_articulo_personalizado` (
  `id_det_articulo_personalizado` int(12) NOT NULL AUTO_INCREMENT,
  `id_det_pedido` int(12) NOT NULL,
  `id_ingrediente` int(12) NOT NULL,
  PRIMARY KEY (`id_det_articulo_personalizado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Detalle de los articulos personalizados.' AUTO_INCREMENT=78 ;

--
-- Volcado de datos para la tabla `det_articulo_personalizado`
--

INSERT INTO `det_articulo_personalizado` (`id_det_articulo_personalizado`, `id_det_pedido`, `id_ingrediente`) VALUES
(46, 65, 1),
(47, 65, 5),
(48, 67, 1),
(49, 67, 2),
(50, 75, 1),
(51, 75, 2),
(52, 75, 3),
(53, 75, 4),
(54, 75, 5),
(55, 76, 1),
(56, 76, 2),
(57, 78, 1),
(58, 78, 5),
(59, 80, 1),
(60, 80, 2),
(61, 81, 1),
(62, 81, 5),
(63, 84, 1),
(64, 84, 2),
(65, 86, 4),
(66, 86, 5),
(67, 93, 1),
(68, 93, 2),
(69, 93, 3),
(70, 93, 4),
(71, 93, 5),
(72, 103, 1),
(73, 103, 3),
(74, 114, 1),
(75, 114, 3),
(76, 114, 4),
(77, 114, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `det_pedido`
--

CREATE TABLE IF NOT EXISTS `det_pedido` (
  `id_det_pedido` int(12) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(12) NOT NULL,
  `id_articulo` int(12) NOT NULL,
  `precio_articulo` decimal(6,2) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `id_tipo_articulo` int(12) NOT NULL,
  `personalizado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_det_pedido`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=116 ;

--
-- Volcado de datos para la tabla `det_pedido`
--

INSERT INTO `det_pedido` (`id_det_pedido`, `id_pedido`, `id_articulo`, `precio_articulo`, `cantidad`, `id_tipo_articulo`, `personalizado`) VALUES
(64, 46, 2, 4.00, 1, 1, 0),
(65, 46, 84, 4.50, 1, 1, 1),
(66, 47, 1, 4.00, 1, 1, 0),
(67, 47, 7, 5.50, 1, 1, 1),
(68, 48, 1, 4.00, 1, 1, 0),
(69, 48, 3, 6.00, 1, 2, 0),
(70, 49, 1, 4.00, 1, 1, 0),
(71, 49, 3, 6.00, 1, 2, 0),
(72, 50, 2, 4.00, 1, 1, 0),
(73, 50, 3, 6.00, 1, 2, 0),
(74, 51, 1, 4.00, 1, 1, 0),
(75, 51, 18, 8.00, 1, 1, 1),
(76, 52, 12, 5.50, 1, 1, 1),
(77, 52, 2, 4.00, 1, 1, 0),
(78, 53, 39, 4.50, 1, 1, 1),
(79, 54, 1, 4.00, 1, 1, 0),
(80, 54, 87, 5.50, 1, 1, 1),
(81, 55, 23, 4.50, 1, 1, 1),
(82, 55, 3, 6.00, 1, 2, 0),
(83, 56, 2, 4.00, 1, 1, 0),
(84, 56, 58, 5.50, 1, 1, 1),
(85, 57, 2, 4.00, 3, 1, 0),
(86, 57, 12, 4.00, 2, 1, 1),
(87, 57, 3, 6.00, 1, 2, 0),
(88, 58, 2, 4.00, 1, 1, 0),
(89, 58, 3, 6.00, 1, 2, 0),
(90, 59, 2, 4.00, 1, 1, 0),
(91, 59, 3, 6.00, 1, 2, 0),
(92, 59, 1, 4.00, 1, 1, 0),
(93, 60, 68, 8.00, 3, 1, 1),
(94, 61, 1, 4.00, 1, 1, 0),
(95, 61, 3, 6.00, 1, 2, 0),
(96, 61, 2, 4.00, 1, 1, 0),
(97, 62, 2, 4.00, 1, 1, 0),
(98, 62, 3, 6.00, 1, 2, 0),
(99, 63, 1, 4.00, 1, 1, 0),
(100, 63, 3, 6.00, 1, 2, 0),
(101, 64, 1, 4.00, 1, 1, 0),
(102, 64, 3, 6.00, 1, 2, 0),
(103, 65, 9, 4.50, 1, 1, 1),
(104, 65, 1, 4.00, 1, 1, 0),
(105, 66, 2, 4.00, 1, 1, 0),
(106, 67, 1, 4.00, 1, 1, 0),
(107, 67, 2, 4.00, 1, 1, 0),
(108, 68, 2, 4.00, 1, 1, 0),
(109, 68, 1, 4.00, 1, 1, 0),
(110, 69, 2, 4.00, 1, 1, 0),
(111, 69, 1, 4.00, 1, 1, 0),
(112, 70, 2, 4.00, 1, 1, 0),
(113, 70, 1, 4.00, 1, 1, 0),
(114, 71, 69, 6.50, 1, 1, 1),
(115, 71, 2, 4.00, 1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dias_semana`
--

CREATE TABLE IF NOT EXISTS `dias_semana` (
  `id_dia` int(12) NOT NULL COMMENT 'Id del dia de la semana',
  `dia` varchar(50) NOT NULL COMMENT 'Día de la semana',
  PRIMARY KEY (`id_dia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los días de la semana';

--
-- Volcado de datos para la tabla `dias_semana`
--

INSERT INTO `dias_semana` (`id_dia`, `dia`) VALUES
(1, 'Lunes'),
(2, 'Martes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion_envio`
--

CREATE TABLE IF NOT EXISTS `direccion_envio` (
  `id_direccion_envio` int(12) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `id_usuario` int(12) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `poblacion` varchar(100) NOT NULL,
  PRIMARY KEY (`id_direccion_envio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabla donde se guardan las direcciones de envio de los usuarios.' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `direccion_envio`
--

INSERT INTO `direccion_envio` (`id_direccion_envio`, `nombre`, `id_usuario`, `direccion`, `poblacion`) VALUES
(1, 'Mikelats', 3, 'Gorosibay 16 3 izq', ''),
(2, 'Mikelats 2', 3, 'Ander deuna', 'usansolo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios_local`
--

CREATE TABLE IF NOT EXISTS `horarios_local` (
  `id_horario_local` int(12) NOT NULL AUTO_INCREMENT,
  `id_local` int(12) NOT NULL,
  `id_dia` int(12) NOT NULL COMMENT 'Lunes 1 ... Domingo 7',
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  PRIMARY KEY (`id_horario_local`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `horarios_local`
--

INSERT INTO `horarios_local` (`id_horario_local`, `id_local`, `id_dia`, `hora_inicio`, `hora_fin`) VALUES
(2, 1, 1, '09:00:00', '23:00:00'),
(3, 1, 1, '09:00:00', '23:00:00'),
(6, 1, 1, '09:00:00', '23:00:00'),
(7, 1, 1, '09:00:00', '22:33:00'),
(8, 1, 2, '22:00:00', '22:22:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios_pedidos`
--

CREATE TABLE IF NOT EXISTS `horarios_pedidos` (
  `id_horario_pedido` int(12) NOT NULL AUTO_INCREMENT,
  `id_local` int(12) NOT NULL,
  `id_dia` int(12) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  PRIMARY KEY (`id_horario_pedido`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabla donde se dan de alta los horarios de los pedidos' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `horarios_pedidos`
--

INSERT INTO `horarios_pedidos` (`id_horario_pedido`, `id_local`, `id_dia`, `hora_inicio`, `hora_fin`) VALUES
(1, 1, 1, '18:00:00', '22:00:00'),
(2, 1, 2, '18:00:00', '22:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE IF NOT EXISTS `ingredientes` (
  `id_ingrediente` int(12) NOT NULL AUTO_INCREMENT,
  `id_local` int(12) NOT NULL,
  `ingrediente` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `precio` decimal(4,2) NOT NULL,
  `disponible` tinyint(1) NOT NULL,
  `fecha_alta` date NOT NULL,
  PRIMARY KEY (`id_ingrediente`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabla donde se guardan los ingredientes por local' AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`id_ingrediente`, `id_local`, `ingrediente`, `descripcion`, `precio`, `disponible`, `fecha_alta`) VALUES
(1, 1, 'lomo', 'lomo', 2.00, 1, '2012-02-28'),
(2, 1, 'bacon', 'bacon', 1.50, 1, '2012-02-28'),
(3, 1, 'queso', 'queso', 0.50, 1, '2012-02-28'),
(4, 1, 'jamon', 'jamon', 1.50, 1, '2012-02-28'),
(5, 1, 'pimiento verde', 'pimiento verde', 0.50, 1, '2012-02-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locales`
--

CREATE TABLE IF NOT EXISTS `locales` (
  `id_local` int(12) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `password` varchar(12) NOT NULL,
  `id_tipo_comida` int(12) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `provincia` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `cod_postal` int(10) NOT NULL,
  `fecha_alta` date NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `estado_local` int(1) NOT NULL COMMENT '0-Activo,1-Sin horarios,2-Sin horario pedidos,9-No activo',
  PRIMARY KEY (`id_local`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabla donde se dan de alta los locales' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `locales`
--

INSERT INTO `locales` (`id_local`, `nombre`, `password`, `id_tipo_comida`, `localidad`, `provincia`, `direccion`, `cod_postal`, `fecha_alta`, `email`, `estado_local`) VALUES
(1, '1', '1', 1, '1', '1', '1', 1, '2012-02-28', '1', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locales_favoritos`
--

CREATE TABLE IF NOT EXISTS `locales_favoritos` (
  `id_locales_favoritos` int(12) NOT NULL AUTO_INCREMENT,
  `id_local` int(12) NOT NULL,
  `id_usuario` int(12) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  PRIMARY KEY (`id_locales_favoritos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabla donde se guardan los locales favoritos.' AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `id_pedido` int(12) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(12) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(1) NOT NULL,
  `precio` decimal(6,2) NOT NULL,
  `id_local` int(12) NOT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `id_direccion_envio` int(12) DEFAULT NULL,
  `envio` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_pedido`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabla donde se guardan los pedidos realizados por los usuaios' AUTO_INCREMENT=72 ;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `id_usuario`, `fecha`, `estado`, `precio`, `id_local`, `observaciones`, `id_direccion_envio`, `envio`) VALUES
(46, 3, '2012-04-29 09:31:37', 'P', 8.50, 1, '', 1, 0),
(47, 3, '2012-04-29 10:16:56', 'P', 9.50, 1, '', 1, 0),
(48, 3, '2012-04-29 10:46:09', 'P', 10.00, 1, '', 1, 0),
(49, 3, '2012-04-29 10:47:12', 'P', 10.00, 1, '', 1, 0),
(50, 3, '2012-04-29 10:48:02', 'P', 10.00, 1, '', 1, 0),
(51, 3, '2012-04-29 10:52:13', 'P', 12.00, 1, '', 1, 0),
(52, 3, '2012-04-29 11:30:19', 'P', 9.50, 1, '', 1, 0),
(53, 3, '2012-04-29 11:47:38', 'P', 4.50, 1, '', 1, 0),
(54, 3, '2012-04-29 11:50:40', 'P', 9.50, 1, '', 1, 0),
(55, 3, '2012-04-29 12:01:05', 'P', 10.50, 1, '', 1, 0),
(56, 3, '2012-04-29 12:03:36', 'P', 9.50, 1, '', 1, 0),
(57, 3, '2012-05-01 09:24:06', 'P', 26.00, 1, '', 1, 0),
(58, 3, '2012-05-01 11:31:45', 'P', 10.00, 1, '', 1, 1),
(59, 3, '2012-05-01 11:36:43', 'P', 14.00, 1, '', 1, 0),
(60, 3, '2012-05-01 11:37:04', 'P', 24.00, 1, '', 1, 1),
(61, 3, '2012-06-10 19:03:27', 'P', 14.00, 1, '', 1, 0),
(62, 3, '2012-06-23 19:48:43', 'P', 10.00, 1, '', 1, 0),
(63, 3, '2012-06-23 19:50:07', 'P', 10.00, 1, '', 1, 0),
(64, 3, '2012-06-23 19:53:46', 'P', 10.00, 1, '', 1, 0),
(65, 3, '2012-06-24 17:12:01', 'P', 8.50, 1, '', 1, 0),
(66, 3, '2012-08-22 12:57:21', 'T', 4.00, 1, '', 1, 0),
(67, 3, '2012-08-27 16:58:17', 'P', 8.00, 1, '', 1, 0),
(68, 3, '2012-09-01 18:29:53', 'P', 8.00, 1, '', 1, 0),
(69, 3, '2012-09-29 12:28:53', 'A', 8.00, 1, '', 1, 0),
(70, 3, '2012-10-29 11:37:08', 'T', 8.00, 1, '', 1, 0),
(71, 4, '2012-10-29 11:46:05', 'T', 10.50, 1, '', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precio_servicio_local`
--

CREATE TABLE IF NOT EXISTS `precio_servicio_local` (
  `id_servicio_local` int(12) NOT NULL,
  `importe_minimo` decimal(5,2) NOT NULL,
  `precio` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id_servicio_local`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla donde se guardan precios de los servicios';

--
-- Volcado de datos para la tabla `precio_servicio_local`
--

INSERT INTO `precio_servicio_local` (`id_servicio_local`, `importe_minimo`, `precio`) VALUES
(12, 10.00, 1.50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_local`
--

CREATE TABLE IF NOT EXISTS `servicios_local` (
  `id_servicio_local` int(12) NOT NULL AUTO_INCREMENT,
  `id_local` int(12) NOT NULL,
  `id_tipo_servicio_local` int(12) NOT NULL,
  PRIMARY KEY (`id_servicio_local`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `servicios_local`
--

INSERT INTO `servicios_local` (`id_servicio_local`, `id_local`, `id_tipo_servicio_local`) VALUES
(3, 1, 3),
(5, 1, 1),
(12, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_articulo`
--

CREATE TABLE IF NOT EXISTS `tipos_articulo` (
  `id_tipo_articulo` int(12) NOT NULL AUTO_INCREMENT,
  `tipo_articulo` varchar(50) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  PRIMARY KEY (`id_tipo_articulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabla donde se guardan los tipos de articulos' AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tipos_articulo`
--

INSERT INTO `tipos_articulo` (`id_tipo_articulo`, `tipo_articulo`, `descripcion`) VALUES
(1, 'bocadillo', 'Bocadillo'),
(2, 'plato combinado', 'plato combinado'),
(3, 'Entrantes', 'Entrantes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_articulo_local`
--

CREATE TABLE IF NOT EXISTS `tipos_articulo_local` (
  `id_tipo_articulo_local` int(12) NOT NULL AUTO_INCREMENT,
  `id_tipo_articulo` int(12) NOT NULL,
  `id_local` int(12) NOT NULL,
  `personalizar` tinyint(1) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id_tipo_articulo_local`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabla donde se guardan los tipos de articulos de un local' AUTO_INCREMENT=60 ;

--
-- Volcado de datos para la tabla `tipos_articulo_local`
--

INSERT INTO `tipos_articulo_local` (`id_tipo_articulo_local`, `id_tipo_articulo`, `id_local`, `personalizar`, `precio`) VALUES
(57, 1, 1, 1, 2),
(58, 2, 1, 1, 2),
(59, 3, 1, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_comida`
--

CREATE TABLE IF NOT EXISTS `tipos_comida` (
  `id_tipo_comida` int(12) NOT NULL AUTO_INCREMENT,
  `tipo_comida` varchar(100) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_comida`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tipos_comida`
--

INSERT INTO `tipos_comida` (`id_tipo_comida`, `tipo_comida`, `descripcion`) VALUES
(1, 'mediterranea', NULL),
(2, 'italiana', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_servicios_local`
--

CREATE TABLE IF NOT EXISTS `tipos_servicios_local` (
  `id_tipo_servicio_local` int(12) NOT NULL AUTO_INCREMENT,
  `servicio` varchar(100) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_servicio_local`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tipos_servicios_local`
--

INSERT INTO `tipos_servicios_local` (`id_tipo_servicio_local`, `servicio`, `descripcion`) VALUES
(1, 'pedidos', 'Se pueden realizar pedidos.'),
(2, 'Envio pedidos', 'Se envian los pedidos a domicilio'),
(3, 'Reservas', 'El local permite reservas.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(12) NOT NULL AUTO_INCREMENT,
  `nick` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha_alta` date NOT NULL,
  `password` varchar(12) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `provincia` varchar(50) NOT NULL,
  `cod_postal` int(10) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nick`, `nombre`, `apellido`, `email`, `fecha_alta`, `password`, `localidad`, `provincia`, `cod_postal`) VALUES
(1, '1', '1', '1', '1', '2012-02-28', 'bZpMiCHd6eB0', '1', '1', 1),
(2, '2', '2', '2', '2', '2012-04-01', 'iLk74npTvj7z', '2', '2', 2),
(3, '3', '3', '3', '3', '2012-04-01', '3', '3', '3', 3),
(4, '4', '4', '4', '4', '2012-10-27', '4', '4', '4', 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
