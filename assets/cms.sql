-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2017 a las 00:33:38
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cms_incalake`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bloqueo`
--

CREATE TABLE `bloqueo` (
  `id_bloqueo` int(11) NOT NULL,
  `descripcion_bloqueo` text,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `id_producto` int(11) NOT NULL,
  `color_bloqueo` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `bloqueo`
--

INSERT INTO `bloqueo` (`id_bloqueo`, `descripcion_bloqueo`, `fecha_inicio`, `fecha_fin`, `id_producto`, `color_bloqueo`) VALUES
(6, 'huelga 01', '2017-09-14 00:00:00', '2017-09-15 23:59:59', 31, '#d9534f'),
(7, 'Vuelga 02', '2017-09-18 00:00:00', '2017-09-22 00:00:00', 31, '#d9534f'),
(8, 'vuelga', '2017-08-30 00:00:00', '2017-08-30 23:59:59', 32, '#d9534f'),
(9, 'Santa Rosa de Lima', '2017-08-30 00:00:00', '2017-08-30 23:59:59', 33, '#d9534f'),
(10, 'Vuelga', '2017-08-30 00:00:00', '2017-08-30 23:59:59', 34, '#d9534f');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campo_categoria`
--

CREATE TABLE `campo_categoria` (
  `id_campo_categoria` int(11) NOT NULL,
  `nombre_campo_categoria` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `campo_categoria`
--

INSERT INTO `campo_categoria` (`id_campo_categoria`, `nombre_campo_categoria`) VALUES
(1, '{\"es\":\"asdasdasdasdasd\",\"en\":\"\",\"fr\":\"\",\"de\":\"\",\"br\":\"\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campo_formulario`
--

CREATE TABLE `campo_formulario` (
  `id_campo_formulario` int(11) NOT NULL,
  `nombre_campo` text,
  `name_campo` text,
  `tipo_campo` text,
  `placeholder_campo` text,
  `value_campo` text,
  `valores_campo` text,
  `prioridad_campo` int(11) DEFAULT NULL,
  `id_campo_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `campo_formulario`
--

INSERT INTO `campo_formulario` (`id_campo_formulario`, `nombre_campo`, `name_campo`, `tipo_campo`, `placeholder_campo`, `value_campo`, `valores_campo`, `prioridad_campo`, `id_campo_categoria`) VALUES
(1, '{\"es\":\"nombres\",\"en\":\"dasd\",\"fr\":\"\",\"de\":\"\",\"br\":\"\"}', 'nombres', 'text', '{\"es\":\"asdasdas\",\"en\":\"asdsadasd\",\"fr\":\"\",\"de\":\"\",\"br\":\"\"}', NULL, NULL, NULL, 1),
(2, '{\"es\":\"fecha de nacimiento\",\"en\":\"dasd\",\"fr\":\"\",\"de\":\"\",\"br\":\"\"}', 'bithday', 'date', '{\"es\":\"asdasdas\",\"en\":\"asdsadasd\",\"fr\":\"\",\"de\":\"\",\"br\":\"\"}', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(128) NOT NULL,
  `descripcion_categoria` varchar(255) DEFAULT NULL,
  `id_idioma` int(11) NOT NULL,
  `id_codigo_categoria` int(11) NOT NULL,
  `id_usuarios` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`, `descripcion_categoria`, `id_idioma`, `id_codigo_categoria`, `id_usuarios`) VALUES
(1, 'Turismo Astronómico', 'Turismo Astronómico', 1, 1, 1),
(2, 'Turismo Astronómico', 'Turismo Astronómico', 2, 1, 1),
(3, 'Turismo Astronómico', 'Turismo Astronómico', 3, 1, 1),
(4, 'Turismo Astronómico', 'Turismo Astronómico', 4, 1, 1),
(5, 'Turismo Astronómico', 'Turismo Astronómico', 5, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo_categoria`
--

CREATE TABLE `codigo_categoria` (
  `id_codigo_categoria` int(11) NOT NULL,
  `codigo_categoria` varchar(128) NOT NULL,
  `imagen_categoria` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `codigo_categoria`
--

INSERT INTO `codigo_categoria` (`id_codigo_categoria`, `codigo_categoria`, `imagen_categoria`) VALUES
(1, 'turismo-astronómico', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo_producto`
--

CREATE TABLE `codigo_producto` (
  `id_codigo_producto` int(11) NOT NULL,
  `codigo_producto` varchar(128) DEFAULT NULL COMMENT 'Es el codigo atraves del cual sabremos en que versiones de idioma existe un Producto',
  `id_usuarios` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Agrupa Productos en sus diferentes idiomas';

--
-- Volcado de datos para la tabla `codigo_producto`
--

INSERT INTO `codigo_producto` (`id_codigo_producto`, `codigo_producto`, `id_usuarios`) VALUES
(22, '045602260817', 1),
(23, '191303260817', 1),
(24, '450512280817', 1),
(25, '031212280817', 1),
(26, '491612280817', 1),
(27, '272612280817', 1),
(28, '212912280817', 1),
(29, '134812280817', 1),
(30, '365312280817', 1),
(31, '241901280817', 1),
(32, '135003280817', 1),
(33, '031704280817', 1),
(34, '262506280817', 1),
(35, '492606280817', 1),
(36, '134906280817', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo_servicio`
--

CREATE TABLE `codigo_servicio` (
  `id_codigo_servicio` int(11) NOT NULL,
  `codigo_servicio` varchar(64) NOT NULL,
  `id_usuarios` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Agrupa las páginas web en sus diferentes idiomas.';

--
-- Volcado de datos para la tabla `codigo_servicio`
--

INSERT INTO `codigo_servicio` (`id_codigo_servicio`, `codigo_servicio`, `id_usuarios`) VALUES
(1, 'INCALAKE-20170825-194319', 1),
(2, 'INCALAKE-20170828-153907', 1),
(3, 'INCALAKE-20170828-181649', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id_configuracion` int(11) NOT NULL,
  `nombre_empresa` text,
  `titulo_index` text,
  `keywords_index` text,
  `descripcion_index` text,
  `logo_index` int(11) DEFAULT NULL,
  `favicon-index` int(11) DEFAULT NULL,
  `codigo_google_analitics` text,
  `codigo_zoopim` text,
  `id_usuarios` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cupon`
--

CREATE TABLE `cupon` (
  `id_cupon` int(11) NOT NULL,
  `descripcion_cupon` varchar(128) DEFAULT NULL,
  `codigo_cupon` varchar(16) DEFAULT NULL,
  `descuento_cupon` decimal(7,3) DEFAULT NULL,
  `tipo_descuento_cupon` int(9) DEFAULT NULL COMMENT '0=descuento porcenje\n1=descuento cantidad',
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallereserva`
--

CREATE TABLE `detallereserva` (
  `id_detallereserva` int(11) NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `telefono` varchar(64) DEFAULT NULL,
  `nombre_lider` varchar(128) DEFAULT NULL,
  `id_reserva` int(11) NOT NULL,
  `id_grupo_informacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_precio`
--

CREATE TABLE `detalle_precio` (
  `id_detalle_precio` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_etapa_edad` int(11) NOT NULL,
  `id_nacionalidad` int(11) DEFAULT NULL,
  `edad_minimo` int(3) NOT NULL,
  `edad_maximo` int(3) DEFAULT '999'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_precio`
--

INSERT INTO `detalle_precio` (`id_detalle_precio`, `id_producto`, `id_etapa_edad`, `id_nacionalidad`, `edad_minimo`, `edad_maximo`) VALUES
(3, 31, 2, NULL, 0, 3),
(7, 31, 1, NULL, 2, 34),
(8, 31, 1, 1, 2, 5),
(9, 32, 2, NULL, 9, 999);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_servicio`
--

CREATE TABLE `detalle_servicio` (
  `id_detalle_servicio` int(11) NOT NULL,
  `fecha_detalle_servicio` datetime DEFAULT NULL COMMENT 'fecha en que se realizará el servicio',
  `cantidad` int(4) DEFAULT NULL,
  `precio_total` decimal(8,3) DEFAULT '0.000' COMMENT 'Precio Total Servicio',
  `descuento` decimal(8,3) DEFAULT '0.000' COMMENT 'Descuento por el Servicio',
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disponibilidad`
--

CREATE TABLE `disponibilidad` (
  `id_disponibilidad` int(11) NOT NULL,
  `descripcion_disponibilidad` text,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `color_disponibilidad` varchar(32) DEFAULT NULL,
  `dias_activos` varchar(128) DEFAULT NULL,
  `dias_no_activos` varchar(128) DEFAULT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `disponibilidad`
--

INSERT INTO `disponibilidad` (`id_disponibilidad`, `descripcion_disponibilidad`, `fecha_inicio`, `fecha_fin`, `color_disponibilidad`, `dias_activos`, `dias_no_activos`, `id_producto`) VALUES
(3, 'Disponible', '2017-09-14 00:00:00', '2027-08-31 23:59:59', '#5bc0de', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', '[]', 31),
(5, 'Disponible', '2017-07-28 00:00:00', '2027-08-31 23:59:59', '#5bc0de', '[\"0\",\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', '[]', 32),
(6, 'Disponible', '2017-06-28 00:00:00', '2027-08-31 23:59:59', '#5bc0de', '[\"0\",\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', '[]', 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etapa_edad`
--

CREATE TABLE `etapa_edad` (
  `id_etapa_edad` int(11) NOT NULL,
  `descripcion_etapa_edad` varchar(45) NOT NULL,
  `edad_min` int(3) NOT NULL,
  `edad_max` int(3) DEFAULT '999',
  `editar` tinyint(1) DEFAULT '1' COMMENT 'si = se cambia \nNo = no se puede cambiar',
  `traducciones` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Almacena las descripciones del precio; Ejemplo: Niño, Peruano, Adulto Extranjero, ';

--
-- Volcado de datos para la tabla `etapa_edad`
--

INSERT INTO `etapa_edad` (`id_etapa_edad`, `descripcion_etapa_edad`, `edad_min`, `edad_max`, `editar`, `traducciones`) VALUES
(1, 'Niño', 0, 3, 0, NULL),
(2, 'Adulto', 18, 99, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galeria`
--

CREATE TABLE `galeria` (
  `id_galeria` int(11) NOT NULL,
  `url_archivo` varchar(100) DEFAULT NULL,
  `detalles_archivo` text,
  `tipo_archivo` tinyint(4) DEFAULT NULL,
  `carpeta_archivo` varchar(100) DEFAULT NULL,
  `id_usuarios` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `galeria`
--

INSERT INTO `galeria` (`id_galeria`, `url_archivo`, `detalles_archivo`, `tipo_archivo`, `carpeta_archivo`, `id_usuarios`) VALUES
(1, 'aramu-muru.png', '', 2, 'arequipa', 1),
(2, 'portal-aramu-muru.png', '', 2, 'arequipa', 1),
(3, 'vista--panoramica-de-laguna.jpg', '', 2, 'arequipa', 1),
(4, 'muros-coloniales.jpg', '', 2, 'arequipa', 1),
(5, 'muros-coloniales-en-arequipa.jpg', '', 1, 'Vinicunca', 1),
(6, 'cuatro-mexpress.jpg', '', 3, 'Uros', 1),
(7, 'logo.png', '', 4, 'recurso', 1),
(8, 'automovil.png', '', 6, 'Categorias', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galeria_has_producto`
--

CREATE TABLE `galeria_has_producto` (
  `id_galeria_has_producto` int(11) NOT NULL,
  `id_galeria` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `galeria_has_producto`
--

INSERT INTO `galeria_has_producto` (`id_galeria_has_producto`, `id_galeria`, `id_producto`) VALUES
(10, 1, 31),
(11, 1, 32),
(12, 3, 33),
(13, 2, 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_informacion`
--

CREATE TABLE `grupo_informacion` (
  `id_grupo_informacion` int(11) NOT NULL,
  `codigo_grupo` varchar(64) DEFAULT NULL,
  `fecha_grupo_informacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idioma`
--

CREATE TABLE `idioma` (
  `id_idioma` int(11) NOT NULL,
  `pais` varchar(128) DEFAULT NULL,
  `codigo` varchar(2) DEFAULT NULL,
  `id_usuarios` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `idioma`
--

INSERT INTO `idioma` (`id_idioma`, `pais`, `codigo`, `id_usuarios`) VALUES
(1, 'ESPAÑOL', 'ES', NULL),
(2, 'INGLES', 'EN', NULL),
(3, 'FRANCES', 'FR', NULL),
(4, 'ALEMAN', 'DE', NULL),
(5, 'PORTUGUES', 'BR', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_reserva`
--

CREATE TABLE `informacion_reserva` (
  `id_informacion_reserva` int(11) NOT NULL,
  `valor_informacion` varchar(128) DEFAULT NULL,
  `id_campo_formulario` int(11) NOT NULL,
  `id_grupo_informacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodo_pago`
--

CREATE TABLE `metodo_pago` (
  `id_metodo_pago` int(11) NOT NULL,
  `nombre_metodo_pago` varchar(45) NOT NULL,
  `descripcion_metodo_pago` varchar(45) DEFAULT NULL,
  `id_usuarios` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nacionalidad`
--

CREATE TABLE `nacionalidad` (
  `id_nacionalidad` int(11) NOT NULL,
  `descripcion_nacionalidad` varchar(128) NOT NULL,
  `traducciones_nacionalidad` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nacionalidad`
--

INSERT INTO `nacionalidad` (`id_nacionalidad`, `descripcion_nacionalidad`, `traducciones_nacionalidad`) VALUES
(1, 'Peruana', ''),
(2, 'Extranjero', NULL),
(3, 'Boliviana', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE `notificacion` (
  `id_notificacion` int(11) NOT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `notificacion` text,
  `id_servicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta`
--

CREATE TABLE `oferta` (
  `id_oferta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `valor_oferta` decimal(7,3) DEFAULT NULL,
  `tipo_oferta` int(4) DEFAULT NULL COMMENT '0=descuento porcentaje\n1=decuento cantidad',
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `color_oferta` varchar(32) DEFAULT NULL,
  `descripcion_oferta` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `oferta`
--

INSERT INTO `oferta` (`id_oferta`, `id_producto`, `valor_oferta`, `tipo_oferta`, `fecha_inicio`, `fecha_fin`, `color_oferta`, `descripcion_oferta`) VALUES
(27, 31, '5.000', 0, '2017-09-01 00:00:00', '2017-10-19 23:59:59', '#449d44', 'Oferta: -12%');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id_pago` int(11) NOT NULL,
  `monto` decimal(8,3) DEFAULT NULL,
  `Descripcion_pago` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_has_detallereserva`
--

CREATE TABLE `pago_has_detallereserva` (
  `id_pago` int(11) NOT NULL,
  `id_detallereserva` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios`
--

CREATE TABLE `precios` (
  `id_precio` int(11) NOT NULL,
  `cantidad` int(3) DEFAULT NULL,
  `monto` decimal(7,3) DEFAULT NULL,
  `id_detalle_precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `precios`
--

INSERT INTO `precios` (`id_precio`, `cantidad`, `monto`, `id_detalle_precio`) VALUES
(1, 1, '15.000', 3),
(2, 2, '7.000', 3),
(3, 1, '5.000', 8),
(4, 1, '3.000', 7),
(5, 1, '5.000', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `titulo_producto` varchar(255) NOT NULL,
  `subtitulo_producto` varchar(255) NOT NULL,
  `codigo_producto` varchar(64) NOT NULL,
  `ciudad_cercana` varchar(255) DEFAULT NULL,
  `aeropuerto_cercano` varchar(255) DEFAULT NULL,
  `id_servicio` int(11) NOT NULL,
  `hora_inicio` text,
  `duracion` text,
  `capacidad` int(3) DEFAULT '999' COMMENT 'Es la cantidad de personas que \npueden estar en un tour .\n(Es el aforo)',
  `adjuntos_producto` varchar(128) DEFAULT NULL COMMENT 'Versión PDF del Paquete',
  `id_codigo_producto` int(11) NOT NULL,
  `estado_producto` tinyint(1) DEFAULT '1' COMMENT '0= paquete no visible en web\n1= paquete visible en web',
  `politicas_producto` char(10) DEFAULT NULL,
  `anticipacion_reserva_producto` char(10) DEFAULT NULL,
  `requerimiento_datos` tinyint(1) NOT NULL COMMENT '1 = pedir datos antes de la compra\n2 = despues de la compra\n3 = no requiere datos del pasajero',
  `fecha` datetime DEFAULT NULL,
  `forms_multiple` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `titulo_producto`, `subtitulo_producto`, `codigo_producto`, `ciudad_cercana`, `aeropuerto_cercano`, `id_servicio`, `hora_inicio`, `duracion`, `capacidad`, `adjuntos_producto`, `id_codigo_producto`, `estado_producto`, `politicas_producto`, `anticipacion_reserva_producto`, `requerimiento_datos`, `fecha`, `forms_multiple`) VALUES
(31, 'TOUR TO THE SILLUSTANI IN PUNO', 'SHARED TOUR TO CHULLPAS OF SILLUSTANI (AFTERNOON)', 'PUNO001', 'Puno, Perú', 'Aeropuerto Internacional Inca Manco Capac, Juliaca, Puno, Perú', 3, '9:00 AM,1:00 PM,4:00 PM', '1!0,1!1,1!2', 30, NULL, 32, 1, '', '30:0', 1, '2017-08-26 18:26:49', 0),
(32, 'TOUR A LA ISLA FLOTANTE DE LOS UROS', 'TOUR COMPARTIDO A LAS ISLAS DE LOS UROS.', 'PUNO002', 'Puno, Perú', 'Aeropuerto, Juliaca, Puno, Perú', 1, '8:00 AM', '1!1', 30, NULL, 33, 1, '', '30:0', 1, '2017-08-27 18:26:49', 1),
(33, ' TOUR COMPARTIDO A LOS UROS Y TAQUILE', ' TOUR COMPARTIDO A LOS UROS Y TAQUILE', 'PUNO004', 'Puno, Perú', 'Aeropuerto, Juliaca, Puno, Perú', 5, '8:00 AM', '2!1', 30, NULL, 35, 1, '', '3:1', 1, '2017-08-28 18:26:49', 0),
(34, 'TOUR UROS Y TAQUILE LANCHA NORMAL + GUÍA PRIVADO ', ' (Transporte compartido con guía privado)', 'PUNO005', 'Puno, Perú', 'Aeropuerto, Juliaca, Puno, Perú', 5, '9:00 AM', '30!0', 30, NULL, 36, 1, '', '3:1', 1, '2017-08-28 18:49:13', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_has_campoform`
--

CREATE TABLE `producto_has_campoform` (
  `id_producto_has_campoform` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_campo_formulario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto_has_campoform`
--

INSERT INTO `producto_has_campoform` (`id_producto_has_campoform`, `id_producto`, `id_campo_formulario`) VALUES
(1, 31, 1),
(2, 31, 2),
(3, 32, 2),
(4, 32, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_has_categoria`
--

CREATE TABLE `producto_has_categoria` (
  `id_producto_has_categoria` int(11) NOT NULL,
  `producto_id_producto` int(11) NOT NULL,
  `categoria_id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE `recurso` (
  `id_recurso` int(11) NOT NULL,
  `nombre_recurso` text,
  `descripcion_recurso` text,
  `precio_recurso` text,
  `regalo_recurso` tinyint(1) DEFAULT '0' COMMENT '0 = no es un regalo\n1 = es un ragalo\n',
  `id_usuarios` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Recursos';

--
-- Volcado de datos para la tabla `recurso`
--

INSERT INTO `recurso` (`id_recurso`, `nombre_recurso`, `descripcion_recurso`, `precio_recurso`, `regalo_recurso`, `id_usuarios`) VALUES
(1, '{\"ES\":\"Chullo\",\"EN\":\"Chullo EN\",\"FR\":\"Chullo FR\",\"DE\":\"Chullo DE\",\"BR\":\"Chullo BR\"}', '{\"ES\":\"Chullo\",\"EN\":\"Chullo EN\",\"FR\":\"Chullo FR\",\"DE\":\"Chullo DE\",\"BR\":\"Chullo BR\"}', '{\"ES\":\"30\",\"EN\":\"30\",\"FR\":\"30\",\"DE\":\"30\",\"BR\":\"30\"}', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso_has_galeria`
--

CREATE TABLE `recurso_has_galeria` (
  `id_recurso_has_galeria` int(11) NOT NULL,
  `recurso_id_recurso` int(11) NOT NULL,
  `galeria_id_galeria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `recurso_has_galeria`
--

INSERT INTO `recurso_has_galeria` (`id_recurso_has_galeria`, `recurso_id_recurso`, `galeria_id_galeria`) VALUES
(1, 1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso_has_producto`
--

CREATE TABLE `recurso_has_producto` (
  `id_recurso_has_producto` int(11) NOT NULL,
  `id_recurso` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `recurso_has_producto`
--

INSERT INTO `recurso_has_producto` (`id_recurso_has_producto`, `id_recurso`, `id_producto`) VALUES
(1, 1, 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id_reserva` int(11) NOT NULL,
  `fecha_creacion_reserva` datetime DEFAULT NULL COMMENT 'Fecha de creación reserva\n',
  `codigo_reserva` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicio` int(11) NOT NULL,
  `url_servicio` varchar(255) NOT NULL,
  `titulo_pagina` varchar(255) NOT NULL,
  `descripcion_pagina` varchar(255) NOT NULL,
  `imagen_principal` varchar(255) DEFAULT NULL,
  `ver_slider` tinyint(1) NOT NULL DEFAULT '0',
  `miniatura` varchar(255) DEFAULT 'miniatura.png',
  `valoracion` decimal(3,2) DEFAULT NULL,
  `reviews` text,
  `idioma_id_idioma` int(11) NOT NULL,
  `codigo_servicio_id_codigo_servicio` int(11) NOT NULL,
  `ubicacion_servicio` varchar(128) DEFAULT NULL,
  `uri_servicio` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id_servicio`, `url_servicio`, `titulo_pagina`, `descripcion_pagina`, `imagen_principal`, `ver_slider`, `miniatura`, `valoracion`, `reviews`, `idioma_id_idioma`, `codigo_servicio_id_codigo_servicio`, `ubicacion_servicio`, `uri_servicio`, `fecha`) VALUES
(1, 'http://incalake.com/es/puno/islas-flotantes-uros.html', 'Excursion y tours diarios a las Islas de Los Uros en el Lago Titicaca', 'Tours diarios a las islas flotantes de los uros | Tour horarios MAÑANA, MEDIO DÍA Y TARDE a los Uros | Tours privados y compartidos a los Uros |Incluye: traslados + barco a motor + guía + entradas, Haz tu reserva ya! Salidas diarias', '5', 1, '6', '2.50', '{\"items\":[{\"nombres\":\"23234\",\"nacionalidad\":\"SADSAD\",\"comentario\":\"SADSADSAD\",\"fecha\":\"\"}]}', 1, 1, 'Puno, Perú', '0', NULL),
(2, 'http://incalake.com/es/puno/chullpas-sillustani.html', 'Tours privados y compartidos a las Chullpas de Sillustani en Puno | Especialistas en la región Puno', 'Tour a Sillustani en Puno Todo incluido | Tours a Sillustani desde el Aeropuerto antes de llegar a Puno o con visita a Lampa', '5', 0, '6', '3.00', '', 1, 2, 'Puno, Perú', 'chullpas-sillustani', NULL),
(3, 'http://incalake.com/en/puno/chullpas-sillustani.html', 'Tour Chullpas of Sillustani (Half Day) | Puno', 'Tour to Chullpas of Sillustani in Puno | visit the great necropolis Inca Sillustani | Beautiful landscapes on Sillustani |$19USD All included', '5', 0, '6', '4.50', '', 2, 2, 'Puno, Perú', 'chullpas-sillustani', NULL),
(4, 'http://incalake.com/en/puno/uros-floating-islands-tour.html', 'Uros Floating Islands Tour | Tours to Uros in half Day', 'Travel to Uros with us, We offer private and shared services to Uros Floating Island on Lake Titicaca | Morning and AFTERNOON daily departures from $14.USD!.', '5', 0, '6', '4.50', '', 2, 1, 'Puno, Perú', 'uros-floating-islands-tour', NULL),
(5, 'http://incalake.com/es/puno/tour-uros-taquile.html', 'Tour a la isla de Taquile y Uros | Turismo en Taquile | Tours en el Lago Titicaca - Taquile.', 'Tours Lago Titicaca: Tour a la Isla de Taquile; brindamos tours diarios a la isla de Taquile', '5', 0, '6', '1.20', '', 1, 3, 'Puno, Perú', 'tour-uros-taquile', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio_has_detallereserva`
--

CREATE TABLE `servicio_has_detallereserva` (
  `id_servicio` int(11) NOT NULL,
  `id_detallereserva` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `slider`
--

CREATE TABLE `slider` (
  `id_slider` int(11) NOT NULL,
  `titulo_slider` text,
  `descripcion_slider` text,
  `url_destino` text,
  `id_galeria` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab`
--

CREATE TABLE `tab` (
  `id_tab` int(11) NOT NULL,
  `descripcion_tab` text,
  `itinerario_ta` text,
  `incluye_tab` text,
  `informacion_tab` text,
  `mapa_tab` text,
  `recomendacion_tab` text,
  `salida_retorno_tab` text,
  `producto_id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tab`
--

INSERT INTO `tab` (`id_tab`, `descripcion_tab`, `itinerario_ta`, `incluye_tab`, `informacion_tab`, `mapa_tab`, `recomendacion_tab`, `salida_retorno_tab`, `producto_id_producto`) VALUES
(29, '<div>\n<h4>Description</h4>\n\n<p>On this tour we&rsquo;ll pick you up from downtown hotels in the afternoon (approx. 1:50 pm), to take a transport, that will take us to our destination of Sillustani (40 min travel time). After arriving at the complex of Sillustani, the guide will take you for a walk of about 30 minutes (walking soft) for different Chullpas of Sillustani or funerary towers from Inca and Pre-Inca cultures that rise up to 12 meters height!, we can also see the beauty of the lagoon Umayo around the location of the chullpas. If the group want, you can visit a farmhouse on the road (where we see the life of the Andean people), and then return to the city after Puno.</p>\n</div>\n', '<div class=\"typography\">\n<h4>Itinerary</h4>\n<strong>Afternoon hours</strong>\n\n<table class=\"table table-hover\">\n	<thead>\n		<tr>\n			<td><strong>ITINERARY</strong></td>\n			<td><strong>APPROX TIME</strong></td>\n		</tr>\n	</thead>\n	<tbody>\n		<tr>\n			<td>Pick up from hotels (Downtown hotels).</td>\n			<td>01:50PM-2.10pm</td>\n		</tr>\n		<tr>\n			<td>Departure to sillustani complex.</td>\n			<td>02:30PM</td>\n		</tr>\n		<tr>\n			<td>Arrival and guided visit(around 1 1/2 hours).</td>\n			<td>03:30PM</td>\n		</tr>\n		<tr>\n			<td>Return to the hotels in Puno.</td>\n			<td>05:40PM</td>\n		</tr>\n	</tbody>\n</table>\n</div>\n', '<div class=\"typography\">\n<h4><strong>INCLUDED</strong></h4>\n\n<ul>\n	<li>Entradas tur&iacute;sticas.</li>\n	<li>Guia Espa&ntilde;ol/Ingl&eacute;s.</li>\n	<li>Transporte Puno - Sillustani (viceversa).</li>\n</ul>\n\n<h4><strong>DON&#39;T INCLUDED</strong></h4>\n\n<ul>\n	<li>Extra expenses</li>\n</ul>\n\n<hr />\n<div class=\"alert alert-danger\" style=\"padding:20px\"><strong>Extra cost for picking up from the following hotels:</strong>\n\n<ul>\n	<li>Casa Andina Private Collection.</li>\n	<li>Posada del Inka.</li>\n	<li>Hotel Eco Inn.</li>\n	<li>Libertadores.</li>\n</ul>\n\n<p><strong>Extra charge of $5USD or S/15 PEN per person</strong></p>\n</div>\n</div>\n', '', '{\"lugares\":[{\"id\":null,\"nombre\":\"Puno, Perú\",\"descripcion\":\"Puno, Perú\",\"coordenadas\":\"-15.8402218,-70.02188050000001\",\"tipo\":\"8\",\"orden\":1},{\"id\":null,\"nombre\":\"Sillustani, Puno, Perú\",\"descripcion\":\"Perú\",\"coordenadas\":\"-15.7214166,-70.15897619999998\",\"tipo\":\"3\",\"orden\":2}]}', '', NULL, 31),
(30, '<div style=\"padding:20px 0 0 20px;\">\n                                            <h4><b>Descripción</b></h4>\n                                            <br>\n                                            <p style=\"text-align:justify\">En este tour se le recogerá en sus hoteles desde el centro de Puno, para poder pasar al puerto de Puno; donde tomaremos nuestra embarcación cómoda, a motor; la cual nos llevará por su tour a las famosas Islas flotantes de los UROS; Tendrá un guía español/inglés (Requerimiento especial idiomas Alemán y Francés) que le mostrará este hermoso lugar, haciéndole conocer la vida y la historia de estos fascinantes Uros; puede elegir horario tanto en la mañana o en la tarde como se ve en el itinerario del lado. Una excursión de 3 horas que la recordará toda su vida.</p>\n                                            <br>\n                                            <h5 class=\"text-info\"><b>Ventajas de reservar su tour a Uros con nosotros:</b></h5>\n\n                                            <ul style=\"list-style: disc;margin-left: 20px;\">\n                                                <li> Barcos cómodos y modernos, cuentan con servicios higiénicos</li>\n                                                <li> Guías profesionales en idiomas español/inglés</li>\n                                                <li> Visita especializada con guías locales conocedores de Los Uros a profundidad</li>\n                                                <li> Mate de coca a bordo </li>\n                                                <li> Posibilidad de subirse a los famosos barcos de totora (opcional y no incluido, pago directo de S/15 por persona)</li>\n                                                <li style=\"text-align:justify\">Los Uros están construidas a base de inmensos bloques de raíces de totoras que se descomponen y producen gases que ayudan a la flotación. Los habitantes de los Uros cortan y reemplazan la totora cada 15 días; para luego ser ancladas al fondo, por medio de palos que atraviesan el piso de la isla.</li>\n                                                <li style=\"text-align:justify\">Las islas flotantes de Los Uros se encuentran ubicados en la bahía de puno, a 6 km del puerto de Puno, en dirección Sur-Este de Puno, reserva con nosotros para poder conocer más!</li>\n                                            </ul>\n                                        </div>', '<div class=\"row\">\n<h4>Itinerario</h4>\n\n<h4 style=\"text-align:center\">Horario Ma&ntilde;ana</h4>\n\n<table class=\"table table-hover\">\n	<thead>\n		<tr>\n			<td><strong>ITINERARIO (MA&Ntilde;ANA)</strong></td>\n			<td><strong>HORA APROX</strong></td>\n		</tr>\n	</thead>\n	<tbody>\n		<tr>\n			<td>Recojo en los hoteles del centro de Puno. (De acuerdo a su hotel le diremos una hora m&aacute;s exacta)</td>\n			<td>08:45AM</td>\n		</tr>\n		<tr>\n			<td>Salida del barco desde el Puerto.</td>\n			<td>09:15AM</td>\n		</tr>\n		<tr>\n			<td>Visita 2 Flotantes de los Uros.</td>\n			<td>10:00AM</td>\n		</tr>\n		<tr>\n			<td>Regreso a los Hoteles del Centro de Puno.</td>\n			<td>12:30PM</td>\n		</tr>\n	</tbody>\n</table>\n\n<h4 style=\"text-align:center\">Horario Medio Dia</h4>\n\n<table class=\"table table-hover\">\n	<thead>\n		<tr>\n			<td><strong>ITINERARIO (MEDIO D&Iacute;A)</strong></td>\n			<td><strong>HORA APROX</strong></td>\n		</tr>\n	</thead>\n	<tbody>\n		<tr>\n			<td>Recojo en los hoteles del centro de Puno. (De acuerdo a su hotel le diremos una hora m&aacute;s exacta)</td>\n			<td>11.50 &ndash; 12:10 PM</td>\n		</tr>\n		<tr>\n			<td>Salida rumbo a las islas flotantes de los uros.</td>\n			<td>12:15PM</td>\n		</tr>\n		<tr>\n			<td>Visita guiada a dos islas flotantes de los Uros.</td>\n			<td>01:00PM</td>\n		</tr>\n		<tr>\n			<td>Retorno a la ciudad de Puno y traslado hoteles del centro de Puno y/o plaza de armas.</td>\n			<td>03:00PM</td>\n		</tr>\n	</tbody>\n</table>\n\n<h4 style=\"text-align:center\">Horario Tarde</h4>\n\n<table class=\"table table-hover\">\n	<thead>\n		<tr>\n			<td><strong>ITINERARIO (TARDE)</strong></td>\n			<td><strong>HORA APROX</strong></td>\n		</tr>\n	</thead>\n	<tbody>\n		<tr>\n			<td>Recojo en los hoteles del centro de Puno.</td>\n			<td>03:50PM</td>\n		</tr>\n		<tr>\n			<td>Salida del barco desde el Puerto.</td>\n			<td>04:15PM</td>\n		</tr>\n		<tr>\n			<td>Visita 2 Islas Flotantes de los Uros.</td>\n			<td>05:00PM</td>\n		</tr>\n		<tr>\n			<td>Regreso a los Hoteles del Centro de Puno.</td>\n			<td>06:00PM</td>\n		</tr>\n	</tbody>\n</table>\n</div>\n', '<div class=\"row\">\n<h4><strong>INCLUYE:</strong></h4>\n\n<div class=\"container\">\n<ul>\n	<li>Entradas Uros.</li>\n	<li>Gu&iacute;a Espa&ntilde;ol/Ingl&eacute;s.</li>\n	<li>Traslado hotel - puerto - hotel.</li>\n	<li>Barco a motor (con SSHH y asientos tipo bus).</li>\n</ul>\n</div>\n\n<h4><strong>NO INCLUYE:</strong></h4>\n\n<div class=\"container\">\n<ul>\n	<li>Gastos Extras</li>\n</ul>\n</div>\n</div>\n', '', '{\"lugares\":[{\"id\":null,\"nombre\":\"Puno, Perú\",\"descripcion\":\"Puno, Perú\",\"coordenadas\":\"-15.8402218,-70.02188050000001\",\"tipo\":\"1\",\"orden\":1},{\"id\":null,\"nombre\":\"Sillustani, Puno, Perú\",\"descripcion\":\"Perú\",\"coordenadas\":\"-15.7214166,-70.15897619999998\",\"tipo\":\"3\",\"orden\":2}]}', '', NULL, 32),
(31, '<div style=\"padding:20px 0 0 20px\"><strong>Descripci&oacute;n</strong>\n<p style=\"margin-left:5px; text-align:justify\">En este tour recogemos pasajeros desde hoteles en el centro de Puno hasta el puerto, donde tomamos nuestra embarcaci&oacute;n c&oacute;moda a motor; nuestro gu&iacute;a (Espa&ntilde;ol/ingl&eacute;s) nos llevar&aacute; a conocer las <strong><a href=\"http://www.incalake.com/islas-flotantes-uros.html\">Islas flotantes de los Uros</a> antes de llegar a Taquile </strong>, donde arribaremos al promediar el medio d&iacute;a, caminaremos hasta llegar a la plaza de armas (ubicada en el centro de la isla de Taquile) <strong> para observar toda belleza del lago Titicaca;</strong> es en este mismo lugar donde almorzaremos y conoceremos m&aacute;s sobre los habitantes y textiles de esta isla declarada como <strong> &ldquo;Patrimonio Cultural de la Humanidad&rdquo; por la UNESCO;</strong> luego de almorzar y visitar la plaza principal, mercado artesanal y el museo local de esta isla, descenderemos hasta el puerto principal, donde tomaremos nuestro barco de retorno para llegar a Puno al promediar las 05:30 PM.</p>\n</div>\n', '<div class=\"typography\">\n<h4>Itinerario</h4>\n\n<h5 style=\"text-align:center\">Horario Ma&ntilde;ana</h5>\n\n<table class=\"table table-hover\">\n	<thead>\n		<tr>\n			<td><strong>ITINERARIO</strong></td>\n			<td><strong>HORA APROX</strong></td>\n		</tr>\n	</thead>\n	<tbody>\n		<tr>\n			<td>Recojo en los hoteles del centro de Puno.</td>\n			<td>06:45AM-07.10</td>\n		</tr>\n		<tr>\n			<td>Salida de barco desde Puerto de Puno.</td>\n			<td>07:20AM</td>\n		</tr>\n		<tr>\n			<td>Visita 2 Islas Flotantes de los Uros.</td>\n			<td>08:00AM</td>\n		</tr>\n		<tr>\n			<td>Salida de barco hacia la isla de Taquile.</td>\n			<td>09:00AM</td>\n		</tr>\n		<tr>\n			<td>Arribo al Puerto de la Isla de Taquile.</td>\n			<td>11:30AM</td>\n		</tr>\n		<tr>\n			<td>Explicaci&oacute;n de gu&iacute;a en Plaza de armas.</td>\n			<td>12:30PM</td>\n		</tr>\n		<tr>\n			<td>Almuerzo: Sopa de Quinua, Trucha frita con arroz y papas, mate de Mu&ntilde;a o Coca.</td>\n			<td>01:30PM</td>\n		</tr>\n		<tr>\n			<td>Retorno a la ciudad de Puno.</td>\n			<td>02:30PM</td>\n		</tr>\n		<tr>\n			<td>arribo a Puno y Transfers a los Hoteles.</td>\n			<td>05:30PM</td>\n		</tr>\n	</tbody>\n</table>\n\n<p><strong>Pago extra por recojo en los siguientes hoteles:</strong></p>\n\n<ul style=\"margin-left:20px\">\n	<li>Casa Andina Private Collection.</li>\n	<li>Posada del Inka.</li>\n	<li>Hotel Eco Inn.</li>\n	<li>Libertadores.</li>\n</ul>\n<strong>$5USD por persona</strong></div>\n', '<div class=\"typography\">\n<h4><strong>INCLUYE</strong></h4>\n\n<ul style=\"margin-left:20px\">\n	<li>Entradas t&uacute;risticas Uros/Taquile.</li>\n	<li>Gu&iacute;a profesional Espa&ntilde;ol/Ingl&eacute;s.</li>\n	<li>Transporte terrestre para el traslado desde hoteles</li>\n	<li>Barco a motor.</li>\n	<li>Almuerzo en Taquile (con un valor de $8 USD el almuerzo est&aacute; incluido en el precio)</li>\n</ul>\n</div>\n', '', '{\"lugares\":[{\"id\":null,\"nombre\":\"Puno, Perú\",\"descripcion\":\"Puno, Perú\",\"coordenadas\":\"-15.8402218,-70.02188050000001\",\"tipo\":\"8\",\"orden\":1},{\"id\":null,\"nombre\":\"Uros, Puno, Perú\",\"descripcion\":\"Uros, Perú\",\"coordenadas\":\"-15.8186675,-69.9689917\",\"tipo\":\"3\",\"orden\":2},{\"id\":null,\"nombre\":\"Taquile, Puno, Perú\",\"descripcion\":\"Taquile, Perú\",\"coordenadas\":\"-15.7725451,-69.6840125\",\"tipo\":\"3\",\"orden\":3}]}', '', NULL, 33),
(32, '<div class=\"col-md-6\" style=\"padding:20px 0 0 20px\">\n<h4 style=\"text-align:justify\">Descripci&oacute;n</h4>\n\n<p>Le damos la posibilidad que puede adicionar un gu&iacute;a privado al tour de Taquile cl&aacute;sico, esto le permitir&aacute; conocer m&aacute;s a profundidad ambas islas, ya que el gu&iacute;a estar&aacute; a su lado durante todo el recorrido, haciendo este tour m&aacute;s personalizado; tenga en cuenta que s&oacute;lo compartir&aacute; el transporte, pero la experiencia ser&aacute; suya y de su gu&iacute;a, as&iacute; tambi&eacute;n podr&aacute; tener m&aacute;s tiempo y conocer un poco m&aacute;s que el resto del grupo.</p>\n</div>\n', '', '<div class=\"typography\">\n<h4><strong>INCLUYE:</strong></h4>\n\n<ul>\n	<li>Traslados compartidos Hoteles del centro de Puno &ndash; Puerto &ndash; Hoteles del centro de Puno</li>\n	<li>Barco a motor compartido</li>\n	<li>Gu&iacute;a privado</li>\n	<li>Entradas a las Islas flotantes de los Uros y Taquile.</li>\n	<li>Almuerzo en Taquile</li>\n</ul>\n\n<h4><strong>NO INCLUYE:</strong></h4>\n\n<ul>\n	<li>Otros, que no se hayan mencionado en este documento.</li>\n</ul>\n</div>\n', '', '{\"lugares\":[{\"id\":null,\"nombre\":\"Puno, Perú\",\"descripcion\":\"Puno, Perú\",\"coordenadas\":\"-15.8402218,-70.02188050000001\",\"tipo\":\"8\",\"orden\":1},{\"id\":null,\"nombre\":\"Uros, Puno, Perú\",\"descripcion\":\"Uros, Perú\",\"coordenadas\":\"-15.8186675,-69.9689917\",\"tipo\":\"3\",\"orden\":2},{\"id\":null,\"nombre\":\"Taquile, Puno, Perú\",\"descripcion\":\"Taquile, Perú\",\"coordenadas\":\"-15.7725451,-69.6840125\",\"tipo\":\"3\",\"orden\":3}]}', '', NULL, 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_adicional`
--

CREATE TABLE `tab_adicional` (
  `id_tab_adicional` int(11) NOT NULL,
  `icono_tab_adicional` varchar(64) DEFAULT NULL,
  `nombre_tab` varchar(128) DEFAULT NULL,
  `contenido_tab` text,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tab_adicional`
--

INSERT INTO `tab_adicional` (`id_tab_adicional`, `icono_tab_adicional`, `nombre_tab`, `contenido_tab`, `id_producto`) VALUES
(1, '', '', '', 31),
(2, '', '', '', 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuarios` int(11) NOT NULL,
  `username_usuarios` char(15) NOT NULL,
  `password_usuarios` char(32) NOT NULL,
  `nombre_usuarios` varchar(45) NOT NULL,
  `mail_usuarios` varchar(45) DEFAULT NULL,
  `date_usuarios` datetime DEFAULT NULL,
  `tipo_usuarios` tinyint(1) DEFAULT '3' COMMENT '1= super admin\n2 = editor\n3= otros'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `username_usuarios`, `password_usuarios`, `nombre_usuarios`, `mail_usuarios`, `date_usuarios`, `tipo_usuarios`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Desarrolador Incalake', 'sistemas@incalake.com', '2017-02-01 00:00:00', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bloqueo`
--
ALTER TABLE `bloqueo`
  ADD PRIMARY KEY (`id_bloqueo`),
  ADD KEY `fk_bloqueo_producto2_idx` (`id_producto`);

--
-- Indices de la tabla `campo_categoria`
--
ALTER TABLE `campo_categoria`
  ADD PRIMARY KEY (`id_campo_categoria`);

--
-- Indices de la tabla `campo_formulario`
--
ALTER TABLE `campo_formulario`
  ADD PRIMARY KEY (`id_campo_formulario`),
  ADD KEY `fk_campo_formulario_campo_categoria1_idx` (`id_campo_categoria`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`),
  ADD KEY `fk_categoria_idioma1_idx` (`id_idioma`) USING BTREE,
  ADD KEY `fk_categoria_codigo_categoria1_idx` (`id_codigo_categoria`);

--
-- Indices de la tabla `codigo_categoria`
--
ALTER TABLE `codigo_categoria`
  ADD PRIMARY KEY (`id_codigo_categoria`);

--
-- Indices de la tabla `codigo_producto`
--
ALTER TABLE `codigo_producto`
  ADD PRIMARY KEY (`id_codigo_producto`);

--
-- Indices de la tabla `codigo_servicio`
--
ALTER TABLE `codigo_servicio`
  ADD PRIMARY KEY (`id_codigo_servicio`,`id_usuarios`),
  ADD KEY `fk_codigo_servicio_usuarios1_idx` (`id_usuarios`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id_configuracion`,`id_usuarios`),
  ADD KEY `fk_configuracion_usuarios1_idx` (`id_usuarios`);

--
-- Indices de la tabla `cupon`
--
ALTER TABLE `cupon`
  ADD PRIMARY KEY (`id_cupon`,`id_producto`),
  ADD KEY `fk_cupon_producto1_idx` (`id_producto`);

--
-- Indices de la tabla `detallereserva`
--
ALTER TABLE `detallereserva`
  ADD PRIMARY KEY (`id_detallereserva`,`id_reserva`,`id_grupo_informacion`),
  ADD KEY `fk_detallereserva_reserva1_idx` (`id_reserva`),
  ADD KEY `fk_detallereserva_grupo_informacion1_idx` (`id_grupo_informacion`);

--
-- Indices de la tabla `detalle_precio`
--
ALTER TABLE `detalle_precio`
  ADD PRIMARY KEY (`id_detalle_precio`,`id_producto`,`id_etapa_edad`),
  ADD KEY `fk_detalle_precio_etapa_edad1_idx` (`id_etapa_edad`),
  ADD KEY `fk_detalle_precio_producto1_idx` (`id_producto`),
  ADD KEY `fk_detalle_precio_nacionalidad1_idx` (`id_nacionalidad`);

--
-- Indices de la tabla `detalle_servicio`
--
ALTER TABLE `detalle_servicio`
  ADD PRIMARY KEY (`id_detalle_servicio`),
  ADD KEY `fk_servicio_producto1_idx` (`id_producto`);

--
-- Indices de la tabla `disponibilidad`
--
ALTER TABLE `disponibilidad`
  ADD PRIMARY KEY (`id_disponibilidad`),
  ADD KEY `fk_bloqueo_producto1_idx` (`id_producto`);

--
-- Indices de la tabla `etapa_edad`
--
ALTER TABLE `etapa_edad`
  ADD PRIMARY KEY (`id_etapa_edad`);

--
-- Indices de la tabla `galeria`
--
ALTER TABLE `galeria`
  ADD PRIMARY KEY (`id_galeria`);

--
-- Indices de la tabla `galeria_has_producto`
--
ALTER TABLE `galeria_has_producto`
  ADD PRIMARY KEY (`id_galeria_has_producto`,`id_galeria`,`id_producto`),
  ADD KEY `fk_galeria_has_producto_producto1_idx` (`id_producto`),
  ADD KEY `fk_galeria_has_producto_galeria1_idx` (`id_galeria`);

--
-- Indices de la tabla `grupo_informacion`
--
ALTER TABLE `grupo_informacion`
  ADD PRIMARY KEY (`id_grupo_informacion`);

--
-- Indices de la tabla `idioma`
--
ALTER TABLE `idioma`
  ADD PRIMARY KEY (`id_idioma`);

--
-- Indices de la tabla `informacion_reserva`
--
ALTER TABLE `informacion_reserva`
  ADD PRIMARY KEY (`id_informacion_reserva`,`id_campo_formulario`,`id_grupo_informacion`),
  ADD KEY `fk_id_campo_formulario_campo_formulario1_idx` (`id_campo_formulario`),
  ADD KEY `fk_informacion_reserva_grupo_informacion1_idx` (`id_grupo_informacion`);

--
-- Indices de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  ADD PRIMARY KEY (`id_metodo_pago`);

--
-- Indices de la tabla `nacionalidad`
--
ALTER TABLE `nacionalidad`
  ADD PRIMARY KEY (`id_nacionalidad`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `fk_notificacion_servicio1_idx` (`id_servicio`);

--
-- Indices de la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD PRIMARY KEY (`id_oferta`),
  ADD KEY `fk_oferta_producto1_idx` (`id_producto`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id_pago`);

--
-- Indices de la tabla `pago_has_detallereserva`
--
ALTER TABLE `pago_has_detallereserva`
  ADD PRIMARY KEY (`id_pago`,`id_detallereserva`),
  ADD KEY `fk_pago_has_detallereserva_detallereserva1_idx` (`id_detallereserva`),
  ADD KEY `fk_pago_has_detallereserva_pago1_idx` (`id_pago`);

--
-- Indices de la tabla `precios`
--
ALTER TABLE `precios`
  ADD PRIMARY KEY (`id_precio`),
  ADD KEY `fk_precio_detalle_precio1_idx` (`id_detalle_precio`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_producto_servicio1_idx` (`id_servicio`),
  ADD KEY `fk_producto_codigo_producto1_idx` (`id_codigo_producto`);

--
-- Indices de la tabla `producto_has_campoform`
--
ALTER TABLE `producto_has_campoform`
  ADD PRIMARY KEY (`id_producto_has_campoform`),
  ADD KEY `fk_producto_has_campo_formulario_campo_formulario1_idx` (`id_campo_formulario`),
  ADD KEY `fk_producto_has_campo_formulario_producto1_idx` (`id_producto`);

--
-- Indices de la tabla `producto_has_categoria`
--
ALTER TABLE `producto_has_categoria`
  ADD PRIMARY KEY (`id_producto_has_categoria`,`producto_id_producto`,`categoria_id_categoria`),
  ADD KEY `fk_producto_has_categoria_categoria1_idx` (`categoria_id_categoria`),
  ADD KEY `fk_producto_has_categoria_producto1_idx` (`producto_id_producto`);

--
-- Indices de la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`id_recurso`);

--
-- Indices de la tabla `recurso_has_galeria`
--
ALTER TABLE `recurso_has_galeria`
  ADD PRIMARY KEY (`id_recurso_has_galeria`,`recurso_id_recurso`,`galeria_id_galeria`),
  ADD KEY `fk_artesania_has_galeria_galeria1_idx` (`galeria_id_galeria`),
  ADD KEY `fk_artesania_has_galeria_artesania1_idx` (`recurso_id_recurso`);

--
-- Indices de la tabla `recurso_has_producto`
--
ALTER TABLE `recurso_has_producto`
  ADD PRIMARY KEY (`id_recurso_has_producto`,`id_recurso`,`id_producto`),
  ADD KEY `fk_recurso_has_producto_producto1_idx` (`id_producto`),
  ADD KEY `fk_recurso_has_producto_recurso1_idx` (`id_recurso`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id_reserva`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicio`,`codigo_servicio_id_codigo_servicio`),
  ADD UNIQUE KEY `url_servicio_UNIQUE` (`url_servicio`),
  ADD KEY `fk_servicio_idioma1_idx` (`idioma_id_idioma`),
  ADD KEY `fk_servicio_codigo_servicio1_idx` (`codigo_servicio_id_codigo_servicio`);

--
-- Indices de la tabla `servicio_has_detallereserva`
--
ALTER TABLE `servicio_has_detallereserva`
  ADD PRIMARY KEY (`id_servicio`,`id_detallereserva`),
  ADD KEY `fk_servicio_has_detallereserva_detallereserva1_idx` (`id_detallereserva`),
  ADD KEY `fk_servicio_has_detallereserva_servicio1_idx` (`id_servicio`);

--
-- Indices de la tabla `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id_slider`);

--
-- Indices de la tabla `tab`
--
ALTER TABLE `tab`
  ADD PRIMARY KEY (`id_tab`),
  ADD KEY `fk_tab_producto1_idx` (`producto_id_producto`) USING BTREE;

--
-- Indices de la tabla `tab_adicional`
--
ALTER TABLE `tab_adicional`
  ADD PRIMARY KEY (`id_tab_adicional`),
  ADD KEY `fk_tab_adicional_producto1_idx` (`id_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuarios`,`username_usuarios`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bloqueo`
--
ALTER TABLE `bloqueo`
  MODIFY `id_bloqueo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `campo_categoria`
--
ALTER TABLE `campo_categoria`
  MODIFY `id_campo_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `campo_formulario`
--
ALTER TABLE `campo_formulario`
  MODIFY `id_campo_formulario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `codigo_categoria`
--
ALTER TABLE `codigo_categoria`
  MODIFY `id_codigo_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `codigo_producto`
--
ALTER TABLE `codigo_producto`
  MODIFY `id_codigo_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT de la tabla `codigo_servicio`
--
ALTER TABLE `codigo_servicio`
  MODIFY `id_codigo_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id_configuracion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cupon`
--
ALTER TABLE `cupon`
  MODIFY `id_cupon` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detallereserva`
--
ALTER TABLE `detallereserva`
  MODIFY `id_detallereserva` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalle_precio`
--
ALTER TABLE `detalle_precio`
  MODIFY `id_detalle_precio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `detalle_servicio`
--
ALTER TABLE `detalle_servicio`
  MODIFY `id_detalle_servicio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `disponibilidad`
--
ALTER TABLE `disponibilidad`
  MODIFY `id_disponibilidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `etapa_edad`
--
ALTER TABLE `etapa_edad`
  MODIFY `id_etapa_edad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `galeria`
--
ALTER TABLE `galeria`
  MODIFY `id_galeria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `galeria_has_producto`
--
ALTER TABLE `galeria_has_producto`
  MODIFY `id_galeria_has_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `grupo_informacion`
--
ALTER TABLE `grupo_informacion`
  MODIFY `id_grupo_informacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `idioma`
--
ALTER TABLE `idioma`
  MODIFY `id_idioma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `informacion_reserva`
--
ALTER TABLE `informacion_reserva`
  MODIFY `id_informacion_reserva` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  MODIFY `id_metodo_pago` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nacionalidad`
--
ALTER TABLE `nacionalidad`
  MODIFY `id_nacionalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `oferta`
--
ALTER TABLE `oferta`
  MODIFY `id_oferta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pago_has_detallereserva`
--
ALTER TABLE `pago_has_detallereserva`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `precios`
--
ALTER TABLE `precios`
  MODIFY `id_precio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT de la tabla `producto_has_campoform`
--
ALTER TABLE `producto_has_campoform`
  MODIFY `id_producto_has_campoform` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `producto_has_categoria`
--
ALTER TABLE `producto_has_categoria`
  MODIFY `id_producto_has_categoria` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `recurso`
--
ALTER TABLE `recurso`
  MODIFY `id_recurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `recurso_has_galeria`
--
ALTER TABLE `recurso_has_galeria`
  MODIFY `id_recurso_has_galeria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `recurso_has_producto`
--
ALTER TABLE `recurso_has_producto`
  MODIFY `id_recurso_has_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `slider`
--
ALTER TABLE `slider`
  MODIFY `id_slider` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tab`
--
ALTER TABLE `tab`
  MODIFY `id_tab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT de la tabla `tab_adicional`
--
ALTER TABLE `tab_adicional`
  MODIFY `id_tab_adicional` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bloqueo`
--
ALTER TABLE `bloqueo`
  ADD CONSTRAINT `fk_bloqueo_producto2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `campo_formulario`
--
ALTER TABLE `campo_formulario`
  ADD CONSTRAINT `fk_campo_formulario_campo_categoria1` FOREIGN KEY (`id_campo_categoria`) REFERENCES `campo_categoria` (`id_campo_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `fk_categoria_codigo_categoria1` FOREIGN KEY (`id_codigo_categoria`) REFERENCES `codigo_categoria` (`id_codigo_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_categoria_idioma1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `codigo_servicio`
--
ALTER TABLE `codigo_servicio`
  ADD CONSTRAINT `fk_codigo_servicio_usuarios1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD CONSTRAINT `fk_configuracion_usuarios1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cupon`
--
ALTER TABLE `cupon`
  ADD CONSTRAINT `fk_cupon_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detallereserva`
--
ALTER TABLE `detallereserva`
  ADD CONSTRAINT `fk_detallereserva_grupo_informacion1` FOREIGN KEY (`id_grupo_informacion`) REFERENCES `grupo_informacion` (`id_grupo_informacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detallereserva_reserva1` FOREIGN KEY (`id_reserva`) REFERENCES `reserva` (`id_reserva`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_precio`
--
ALTER TABLE `detalle_precio`
  ADD CONSTRAINT `fk_detalle_precio_etapa_edad1` FOREIGN KEY (`id_etapa_edad`) REFERENCES `etapa_edad` (`id_etapa_edad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalle_precio_nacionalidad1` FOREIGN KEY (`id_nacionalidad`) REFERENCES `nacionalidad` (`id_nacionalidad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalle_precio_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_servicio`
--
ALTER TABLE `detalle_servicio`
  ADD CONSTRAINT `fk_servicio_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `disponibilidad`
--
ALTER TABLE `disponibilidad`
  ADD CONSTRAINT `fk_bloqueo_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `galeria_has_producto`
--
ALTER TABLE `galeria_has_producto`
  ADD CONSTRAINT `fk_galeria_has_producto_galeria1` FOREIGN KEY (`id_galeria`) REFERENCES `galeria` (`id_galeria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_galeria_has_producto_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `informacion_reserva`
--
ALTER TABLE `informacion_reserva`
  ADD CONSTRAINT `fk_id_campo_formulario_campo_formulario1` FOREIGN KEY (`id_campo_formulario`) REFERENCES `campo_formulario` (`id_campo_formulario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_informacion_reserva_grupo_informacion1` FOREIGN KEY (`id_grupo_informacion`) REFERENCES `grupo_informacion` (`id_grupo_informacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD CONSTRAINT `fk_notificacion_servicio1` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD CONSTRAINT `fk_oferta_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pago_has_detallereserva`
--
ALTER TABLE `pago_has_detallereserva`
  ADD CONSTRAINT `fk_pago_has_detallereserva_detallereserva1` FOREIGN KEY (`id_detallereserva`) REFERENCES `detallereserva` (`id_detallereserva`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pago_has_detallereserva_pago1` FOREIGN KEY (`id_pago`) REFERENCES `pago` (`id_pago`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `precios`
--
ALTER TABLE `precios`
  ADD CONSTRAINT `fk_precio_detalle_precio1` FOREIGN KEY (`id_detalle_precio`) REFERENCES `detalle_precio` (`id_detalle_precio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_codigo_producto1` FOREIGN KEY (`id_codigo_producto`) REFERENCES `codigo_producto` (`id_codigo_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_producto_servicio1` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_has_campoform`
--
ALTER TABLE `producto_has_campoform`
  ADD CONSTRAINT `fk_producto_has_campo_formulario_campo_formulario1` FOREIGN KEY (`id_campo_formulario`) REFERENCES `campo_formulario` (`id_campo_formulario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_has_campo_formulario_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto_has_categoria`
--
ALTER TABLE `producto_has_categoria`
  ADD CONSTRAINT `fk_producto_has_categoria_categoria1` FOREIGN KEY (`categoria_id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_producto_has_categoria_producto1` FOREIGN KEY (`producto_id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recurso_has_galeria`
--
ALTER TABLE `recurso_has_galeria`
  ADD CONSTRAINT `fk_artesania_has_galeria_artesania1` FOREIGN KEY (`recurso_id_recurso`) REFERENCES `recurso` (`id_recurso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_artesania_has_galeria_galeria1` FOREIGN KEY (`galeria_id_galeria`) REFERENCES `galeria` (`id_galeria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recurso_has_producto`
--
ALTER TABLE `recurso_has_producto`
  ADD CONSTRAINT `fk_recurso_has_producto_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_recurso_has_producto_recurso1` FOREIGN KEY (`id_recurso`) REFERENCES `recurso` (`id_recurso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `fk_servicio_codigo_servicio1` FOREIGN KEY (`codigo_servicio_id_codigo_servicio`) REFERENCES `codigo_servicio` (`id_codigo_servicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_servicio_idioma1` FOREIGN KEY (`idioma_id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicio_has_detallereserva`
--
ALTER TABLE `servicio_has_detallereserva`
  ADD CONSTRAINT `fk_servicio_has_detallereserva_detallereserva1` FOREIGN KEY (`id_detallereserva`) REFERENCES `detallereserva` (`id_detallereserva`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_servicio_has_detallereserva_servicio1` FOREIGN KEY (`id_servicio`) REFERENCES `detalle_servicio` (`id_detalle_servicio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab`
--
ALTER TABLE `tab`
  ADD CONSTRAINT `fk_tab_producto1` FOREIGN KEY (`producto_id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_adicional`
--
ALTER TABLE `tab_adicional`
  ADD CONSTRAINT `fk_tab_adicional_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
