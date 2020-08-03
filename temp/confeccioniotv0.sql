-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2020 a las 07:44:48
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `confeccioniot`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_precio_producto` (`n_cantidad` INT, `n_precio` DECIMAL(10,2), `codigo` INT)  BEGIN
    	DECLARE nueva_existencia int;
        DECLARE nuevo_total  decimal(10,2);
        DECLARE nuevo_precio decimal(10,2);
        
        DECLARE cant_actual int;
        DECLARE pre_actual decimal(10,2);
        
        DECLARE actual_existencia int;
        DECLARE actual_precio decimal(10,2);
                
        SELECT precio,existencia INTO actual_precio,actual_existencia FROM producto WHERE idproducto = codigo;
        
        SET nueva_existencia = actual_existencia + n_cantidad;
        SET nuevo_total = (actual_existencia * actual_precio) + (n_cantidad * n_precio);
        SET nuevo_precio = nuevo_total / nueva_existencia;
        
        UPDATE producto SET existencia = nueva_existencia, precio = nuevo_precio WHERE idproducto = codigo;
        
        SELECT nueva_existencia,nuevo_precio;
        
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nit` int(11) DEFAULT NULL,
  `nombre` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `direccion` mediumtext COLLATE utf8_spanish_ci,
  `usuario_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `dateadd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nit`, `nombre`, `telefono`, `direccion`, `usuario_id`, `status`, `dateadd`, `updated_at`, `deleted_at`) VALUES
(1, 666666, 'Avalo', 234556, 'dfssdsdf', 1, 1, '2020-05-24 21:21:03', NULL, NULL),
(2, 1234, 'Casa', 123456, '7687685tytuty', 1, 1, '2020-05-25 11:05:29', NULL, NULL),
(3, 0, 'Pepe', 7777, '7656', 1, 0, '2020-05-25 11:06:35', NULL, '2020-05-28 12:31:03'),
(4, 0, 'El carvajal', 34567, 'dfsdf', 1, 0, '2020-05-25 13:42:41', NULL, '2020-05-28 20:16:45'),
(5, 0, 'El carvajal', 34567, 'dfsdf', 1, 0, '2020-05-25 13:42:41', NULL, '2020-05-27 19:21:54'),
(6, 0, 'domeco', 3454333, 'gfdgd', 1, 1, '2020-05-25 13:43:59', '2020-05-28 19:37:11', NULL),
(7, 0, 'Oswaldo', 5555555, '555555', 1, 0, '2020-05-25 13:45:40', NULL, '2020-05-27 13:06:36'),
(8, 5432435, 'Leon', 87543, '7687685tytuty', 1, 0, '2020-05-25 13:46:07', NULL, '2020-05-27 12:45:54'),
(9, 34567765, 'Pepe', 345, 'dfsfd', 1, 1, '2020-05-25 13:46:25', NULL, NULL),
(10, 1111111, 'Jorge Andres', 333, '3333', 1, 1, '2020-05-25 13:46:56', NULL, NULL),
(11, 6666666, 'Pepe', 77777, '00001', 1, 0, '2020-05-25 13:47:29', NULL, '2020-05-31 01:23:57'),
(12, 123999999, 'dfsdflskdfsdfsf', 33333333, 'dgsdfgsgdfsfg', 1, 0, '2020-05-26 23:17:24', NULL, '2020-05-31 01:23:08'),
(13, 0, 'Pepe', 2147483647, '444444', 1, 1, '2020-05-27 00:38:51', NULL, NULL),
(14, 12348888, 'bibm', 33333, '4433454345', 1, 1, '2020-05-27 00:40:12', NULL, NULL),
(15, 2147483647, 'gfdfgdg', 54545, '7656', 1, 1, '2020-05-27 00:40:48', NULL, NULL),
(16, 765678, 'calson', 44444, '44444', 1, 1, '2020-05-27 00:41:26', NULL, NULL),
(17, 1234654, 'Pepe3', 22222, '222222', 1, 1, '2020-05-27 01:22:10', NULL, NULL),
(18, 0, 'Gloria', 44444, 'fgdfgdg', 1, 1, '2020-05-27 01:48:40', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

CREATE TABLE `detallefactura` (
  `correlativo` bigint(11) NOT NULL,
  `nofactura` bigint(11) DEFAULT NULL,
  `codproducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `preciototal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleordendeproduccion`
--

CREATE TABLE `detalleordendeproduccion` (
  `idordendeproduccion` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp`
--

CREATE TABLE `detalle_temp` (
  `correlativo` int(11) NOT NULL,
  `nofactura` bigint(11) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `preciototal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `idempresa` int(11) NOT NULL,
  `codigo` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `idrelacionempresa` int(11) NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `NIT` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `celular` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `web` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `logo` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`idempresa`, `codigo`, `nombre`, `direccion`, `telefono`, `created_at`, `updated_at`, `deleted_at`, `idrelacionempresa`, `descripcion`, `NIT`, `celular`, `correo`, `web`, `logo`, `status`) VALUES
(1, '01', 'Gaviotas', 'Calle gaviotas', '300000000', '2020-04-12 00:00:00', '2020-04-12 00:00:00', '0000-00-00 00:00:00', 1, 'Venta de gaviotas', '1111111', '30000000', '', 'www.gaviotas.com', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `correlativo` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`correlativo`, `idproducto`, `fecha`, `cantidad`, `precio`, `usuario_id`) VALUES
(1, 8, '2020-06-08 00:26:13', 20, '1000.00', 1),
(2, 12, '2020-06-08 00:46:41', 400, '233.00', 1),
(3, 13, '2020-06-08 00:47:54', 20, '1000.00', 1),
(4, 14, '2020-06-08 00:52:02', 345, '8999.00', 1),
(5, 15, '2020-06-08 00:58:24', 200, '300.00', 1),
(8, 15, '2020-06-09 01:05:40', 200, '500.00', 1),
(9, 15, '2020-06-09 01:06:02', 200, '500.00', 1),
(10, 13, '2020-06-09 02:08:38', 20, '2000.00', 1),
(11, 13, '2020-06-09 02:11:53', 33, '4444.00', 1),
(12, 12, '2020-06-09 02:37:16', 40, '200.00', 1),
(13, 13, '2020-06-09 02:41:02', 34, '555.00', 1),
(14, 13, '2020-06-09 02:41:13', 444, '333.00', 1),
(15, 13, '2020-06-09 02:41:13', 444, '333.00', 1),
(16, 13, '2020-06-09 02:42:22', 34, '23.00', 1),
(17, 12, '2020-06-09 02:42:42', 30, '1000.00', 1),
(18, 12, '2020-06-09 02:43:11', 60, '400.00', 1),
(19, 8, '2020-06-09 02:43:27', 30, '200.00', 1),
(20, 12, '2020-06-09 02:45:06', 23, '23.00', 1),
(21, 8, '2020-06-09 02:45:19', 60, '1000.00', 1),
(22, 8, '2020-06-09 02:48:28', 120, '1000.00', 1),
(23, 8, '2020-06-09 02:53:02', 240, '1000.00', 1),
(24, 15, '2020-06-09 02:53:17', 600, '1000.00', 1),
(25, 12, '2020-06-09 02:54:28', 447, '1000.00', 1),
(26, 16, '2020-06-09 21:25:58', 30, '5.00', 1),
(27, 12, '2020-06-11 00:56:54', 0, '0.00', 1),
(28, 12, '2020-06-11 00:56:58', 0, '0.00', 1),
(29, 12, '2020-06-11 00:56:58', 0, '0.00', 1),
(30, 12, '2020-06-11 00:57:00', 0, '0.00', 1),
(31, 12, '2020-06-11 00:57:00', 0, '0.00', 1),
(32, 12, '2020-06-11 00:57:01', 0, '0.00', 1),
(33, 12, '2020-06-11 00:57:01', 0, '0.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadosmaquinas`
--

CREATE TABLE `estadosmaquinas` (
  `idestado` int(11) NOT NULL,
  `estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estadosmaquinas`
--

INSERT INTO `estadosmaquinas` (`idestado`, `estado`, `status`) VALUES
(1, 'En Mantenimiento', 1),
(2, 'Ocupada', 1),
(3, 'Retirada', 1),
(4, 'Disponible', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadosordenproduccion`
--

CREATE TABLE `estadosordenproduccion` (
  `idestadoordenproduccion` int(11) NOT NULL,
  `estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estadosordenproduccion`
--

INSERT INTO `estadosordenproduccion` (`idestadoordenproduccion`, `estado`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Inscrita', 1, '2020-05-25 17:22:06', NULL, NULL),
(2, 'En Proceso', 1, '2020-05-25 17:22:06', NULL, NULL),
(3, 'Pausada', 1, '2020-05-25 17:22:52', NULL, NULL),
(4, 'Cancelada', 1, '2020-05-25 17:22:52', NULL, NULL),
(5, 'Terminada', 1, '2020-05-25 17:23:08', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `nofactura` bigint(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `codcliente` int(11) DEFAULT NULL,
  `totaltactura` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maquinas`
--

CREATE TABLE `maquinas` (
  `idmaquina` int(11) NOT NULL,
  `idmodulo` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `serial` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `corriente_encenmotap` double NOT NULL,
  `corriente_encendido` double NOT NULL,
  `MTTF` int(10) NOT NULL,
  `MTBF` int(10) NOT NULL,
  `tipo_maquina` int(10) NOT NULL,
  `idestado` int(11) NOT NULL,
  `fotohref` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `centrocostos` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `fechacompra` datetime DEFAULT NULL,
  `fechasalida` datetime DEFAULT NULL,
  `manuales` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `maquinas`
--

INSERT INTO `maquinas` (`idmaquina`, `idmodulo`, `created_at`, `updated_at`, `serial`, `nombre`, `corriente_encenmotap`, `corriente_encendido`, `MTTF`, `MTBF`, `tipo_maquina`, `idestado`, `fotohref`, `centrocostos`, `descripcion`, `fechacompra`, `fechasalida`, `manuales`, `deleted_at`, `status`) VALUES
(1, 1, '2020-05-25 21:18:28', NULL, '123456', 'Maquina Plana1', 12, 15, 12, 12, 1, 4, '', '1234', 'maquina Plana', '2020-05-25 00:00:00', '0000-00-00 00:00:00', '', NULL, 1),
(2, 1, '2020-05-25 21:25:23', NULL, '234567', 'Fileteadora Singer', 1, 1.3, 40, 23, 0, 4, '', '', 'Fileteadora Feliz', '2020-05-25 00:00:00', '0000-00-00 00:00:00', '', NULL, 1),
(3, 2, '2020-05-25 21:29:02', NULL, '54345676', 'Fileteadora Singer1', 3.4, 3.4, 23, 22, 0, 3, '', '34665', 'Ojaladora', '2020-05-25 00:00:00', NULL, '', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moduloiot`
--

CREATE TABLE `moduloiot` (
  `idmoduloIoT` int(11) NOT NULL,
  `direccion` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `serie` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `idtipomoduloiot` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `moduloiot`
--

INSERT INTO `moduloiot` (`idmoduloIoT`, `direccion`, `nombre`, `descripcion`, `serie`, `idtipomoduloiot`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '123456', 'MedEn Plana1', 'Medicion en Máquina 1', '001', 1, 1, '2020-05-25 14:00:11', NULL, NULL),
(2, '233454', 'Medicion en sal', 'Medicion en Máquina 8', '23453', 1, 1, '2020-05-25 14:00:11', NULL, NULL),
(3, '00001', 'maquina2', '', '111111', 1, 1, '2020-05-25 14:00:11', NULL, NULL),
(4, 'dfdsdff', 'dddff', 'Medicion de corrente en maquina 2', '11111', 1, 1, '2020-05-25 14:00:11', NULL, NULL),
(5, 'sdfdfdf', 'dggffdfg', 'Medicion de corrente en maquina 2', '3333333', 1, 1, '2020-05-25 14:00:11', NULL, NULL),
(6, '1234567', 'sdfsdf', 'dsfsdfsd', 'dfsfsf', 1, 1, '2020-05-25 14:00:11', NULL, NULL),
(7, '4444444', 'Gloria', 'dfsfdsfs', 'sfdsfsfds', 1, 1, '2020-05-25 14:00:39', NULL, NULL),
(8, '1111111111', 'Pepe', 'dsfsfsdf', 'sdfdsfdsfd', 1, 1, '2020-05-25 14:00:53', NULL, NULL),
(9, '555555555', 'dfgdfgdg', 'dgfdgd', 'dfgdfgdgdg', 1, 1, '2020-05-25 14:01:14', NULL, NULL),
(10, 'rtrerty', 'ertyyte', 'werttrw', 'werttrw', 1, 1, '2020-05-25 14:01:29', NULL, NULL),
(11, 'iutuityiu', 'tuyiiuyt', 'ytiuytuyi', 'tyutyuityi', 1, 1, '2020-05-25 14:01:43', NULL, NULL),
(12, '7687685tyt', 'dfsfd', 'sfdsdfsdf', '3333', 2, 1, '2020-05-26 22:10:32', NULL, NULL),
(13, '7687685tyt', 'gfgfdgdd', 'dsdfsdf', '0013', 5, 1, '2020-05-26 22:15:12', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `idmodulo` int(11) NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `idplanta` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uptdated_at` datetime DEFAULT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`idmodulo`, `nombre`, `idplanta`, `created_at`, `uptdated_at`, `descripcion`, `deleted_at`, `status`) VALUES
(1, 'Camisas Polo', 1, '2020-05-25 19:33:37', NULL, 'Modulo Camisas Polo', NULL, 1),
(2, 'Pantalones Jeans', 2, '2020-05-25 19:33:37', NULL, 'Modulo de Pantalones', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenesproduccion`
--

CREATE TABLE `ordenesproduccion` (
  `idordenproduccion` int(11) NOT NULL,
  `fechaprogramacion` date DEFAULT NULL,
  `fechapausa` date DEFAULT NULL,
  `fechacontinuacion` date DEFAULT NULL,
  `fechacierre` date DEFAULT NULL,
  `numeroordenproduccion` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `idestadoordenproduccion` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ordenesproduccion`
--

INSERT INTO `ordenesproduccion` (`idordenproduccion`, `fechaprogramacion`, `fechapausa`, `fechacontinuacion`, `fechacierre`, `numeroordenproduccion`, `created_at`, `updated_at`, `deleted_at`, `descripcion`, `idestadoordenproduccion`, `status`) VALUES
(1, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 1, '2020-05-25 18:04:34', NULL, NULL, '100 Camisas para Pedido para carsil', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantas`
--

CREATE TABLE `plantas` (
  `idplanta` int(11) NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `codigo` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `plantas`
--

INSERT INTO `plantas` (`idplanta`, `nombre`, `direccion`, `codigo`, `ciudad`, `telefono`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Planta1 Planetario', 'Calle Planetario', '1', 'Medellín', '2222222', 1, '2020-05-25 18:56:52', NULL, NULL),
(2, 'Planta2 Itagui', 'Calle1 ', '', 'Itagui', '222223333', 1, '2020-05-25 18:56:52', NULL, NULL),
(3, 'Planta Zamora', 'zamora', '3', 'Medellin', '234567', 1, '2020-05-26 22:31:12', NULL, NULL),
(4, 'Planta de PeÃ±ol', 'peÃ±ol', '4', 'PeÃ±os', '4567564', 1, '2020-05-26 22:32:07', NULL, NULL),
(5, 'Cali', 'cali', '5', 'cali', '4567', 1, '2020-05-26 22:32:47', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `referencia` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `existencia` int(11) DEFAULT NULL,
  `foto` mediumtext COLLATE utf8_spanish_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `nombre`, `referencia`, `descripcion`, `precio`, `existencia`, `foto`, `created_at`, `updated_at`, `deleted_at`, `status`, `usuario_id`) VALUES
(8, 'Vaso Pinpinela', '1', 'De cristal', '939.59', 480, 'img_producto.png', '2020-06-08 00:26:13', NULL, NULL, 1, 1),
(12, 'Galletas Wafer', '2', NULL, '602.73', 1000, 'img_producto.png', '2020-06-08 00:46:41', NULL, NULL, 1, 1),
(13, 'Diccionario', '3', '', '507.30', 1029, 'img_producto.png', '2020-06-08 00:47:54', NULL, NULL, 1, 1),
(14, 'Mermelada', '4', '', '8999.00', 345, 'img_producto.png', '2020-06-08 00:52:02', NULL, '2020-06-08 10:53:41', 0, 1),
(15, 'Tabaco', '6', 'Verde', '716.67', 1200, 'img_producto.png', '2020-06-08 00:58:24', NULL, NULL, 1, 1),
(16, 'bingo', '33334', '4444', '5.00', 30, 'img_e2ea0e22920425dc4f8f352ff94680f1.jpg', '2020-06-09 21:25:58', NULL, NULL, 0, 1);

--
-- Disparadores `producto`
--
DELIMITER $$
CREATE TRIGGER `entradas_A_I` AFTER INSERT ON `producto` FOR EACH ROW BEGIN
		INSERT INTO entradas (idproducto, cantidad, precio, usuario_id) 
		VALUES (new.idproducto, new.existencia, new.precio, new.usuario_id);
	END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `codproveedor` int(11) NOT NULL,
  `proveedor` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `contacto` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` bigint(11) DEFAULT NULL,
  `direccion` mediumtext COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`codproveedor`, `proveedor`, `contacto`, `telefono`, `direccion`) VALUES
(1, 'BIC', 'Claudia Rosales', 789877889, 'Avenida las Americas'),
(2, 'CASIO', 'Jorge Herrera', 565656565656, 'Calzada Las Flores'),
(3, 'Omega', 'Julio Estrada', 982877489, 'Avenida Elena Zona 4, Guatemala'),
(4, 'Dell Compani', 'Roberto Estrada', 2147483647, 'Guatemala, Guatemala'),
(5, 'Olimpia S.A', 'Elena Franco Morales', 564535676, '5ta. Avenida Zona 4 Ciudad'),
(6, 'Oster', 'Fernando Guerra', 78987678, 'Calzada La Paz, Guatemala'),
(7, 'ACELTECSA S.A', 'Ruben PÃ©rez', 789879889, 'Colonia las Victorias'),
(8, 'Sony', 'Julieta Contreras', 89476787, 'Antigua Guatemala'),
(9, 'VAIO', 'Felix Arnoldo Rojas', 476378276, 'Avenida las Americas Zona 13'),
(10, 'SUMAR', 'Oscar Maldonado', 788376787, 'Colonia San Jose, Zona 5 Guatemala'),
(11, 'HP', 'Angel Cardona', 2147483647, '5ta. calle zona 4 Guatemala');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacionempresas`
--

CREATE TABLE `relacionempresas` (
  `idrelacionempresa` int(11) NOT NULL,
  `relacionempresa` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `uptdated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `relacionempresas`
--

INSERT INTO `relacionempresas` (`idrelacionempresa`, `relacionempresa`, `status`, `created_at`, `uptdated_at`, `deleted_at`) VALUES
(1, 'Cliente', 1, '2020-05-22 00:00:00', NULL, NULL),
(2, 'Proveedor', 1, '2020-05-22 00:00:00', NULL, NULL),
(3, 'Contratista', 1, '2020-05-22 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `rol`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 1, NULL, NULL, NULL),
(2, 'Supervisor', 1, NULL, NULL, NULL),
(3, 'Operario', 1, NULL, NULL, NULL),
(4, 'Gerente', 1, NULL, NULL, NULL),
(5, 'Administrador', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposmodulosiot`
--

CREATE TABLE `tiposmodulosiot` (
  `idtipomoduloiot` int(11) NOT NULL,
  `tipomoduloIoT` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `referencia` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tiposmodulosiot`
--

INSERT INTO `tiposmodulosiot` (`idtipomoduloiot`, `tipomoduloIoT`, `descripcion`, `referencia`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'A1 Corriente', 'MediciÃ³n de corriente en maquina de coser', 'A2', 1, NULL, NULL, NULL),
(2, 'V voltaje', 'MediciÃ³n de voltaje', '124444', 1, '2020-05-26 19:23:49', NULL, NULL),
(3, 'medidor de presion', 'medicion de presion', '9999999', 1, '2020-05-26 21:23:40', NULL, NULL),
(4, 'Medidor Presion', 'dsfsdfsd', '1244444', 0, '2020-05-26 21:24:19', NULL, '2020-05-28 17:26:30'),
(5, 'Medidor Presencia Hi', 'Valor Presencia Hilo', '12323454', 1, '2020-05-26 21:25:05', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `clave` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rol` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `correo`, `usuario`, `clave`, `rol`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Jorge Andres', 'jorgecock@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 1, NULL, NULL, NULL),
(2, 'Gloria Eugenia', 'magenial@gmail.com', 'magenial', '81dc9bdb52d04dc20036dbd8313ed055', 2, 0, NULL, NULL, '2020-05-27 13:59:07'),
(3, 'Juan Pablo', 'juanpablo@gmail.com', 'juanpablo', '25ef8924973420229be604d76afcbd9b', 3, 1, NULL, NULL, NULL),
(4, 'Pepe', 'pepe1@gmail.com', 'pepe1', '202cb962ac59075b964b07152d234b70', 2, 1, NULL, NULL, NULL),
(5, 'Manuel Fernando', 'manuel@gmail.com', 'rooticon12', '202cb962ac59075b964b07152d234b70', 4, 1, NULL, NULL, NULL),
(8, 'gonzalo', 'gonzalo@gmail.com', 'gonzo', '81dc9bdb52d04dc20036dbd8313ed055', 3, 1, NULL, NULL, '2020-05-27 13:07:44'),
(9, 'Marcela', 'marcela@gmail.com', 'marce', '202cb962ac59075b964b07152d234b70', 2, 1, NULL, NULL, NULL),
(10, 'Alberto', 'alberto@gmail.com', 'alberto', '202cb962ac59075b964b07152d234b70', 3, 0, NULL, NULL, '2020-05-28 17:22:43'),
(11, 'Matilde', 'matilde@matilde.com', 'matilde', '11c0d3f31578732d1aebdad4f70c6985', 4, 1, NULL, NULL, '2020-05-27 13:44:45'),
(12, 'Oswaldo', 'oswaldo@oswaldo.com', 'oswaldo', '633d2c523d43600cca8b0d1d8bb795b0', 5, 1, NULL, NULL, NULL),
(13, 'Yidis', 'Yidis@gmail.com', 'yidis', '01303fc071799c4af6697a4802e19c7c', 3, 1, NULL, NULL, NULL),
(14, 'Marcela B', 'marcelab@gmail.com', 'marce1', '0d54d1a7a5de5c491dbc3162b9919bc8', 2, 1, NULL, NULL, NULL),
(15, 'Jorge Andres Cock', 'jorgecock1@gmail.com', 'gogogog', '827ccb0eea8a706c4c34a16891f84e7b', 1, 1, '2020-05-26 20:40:12', NULL, NULL),
(16, 'Liliana', 'liliana@gmail.com', 'liliana', 'a071495b74b65a34559c76227e0633a4', 4, 1, '2020-05-26 20:45:13', NULL, NULL),
(17, 'casandra', 'cccc@gmail.com', 'pepe3', '81dc9bdb52d04dc20036dbd8313ed055', 4, 1, '2020-05-27 00:37:48', NULL, NULL),
(18, 'catalina', 'catalina@gmail.com', 'Catalina', '827ccb0eea8a706c4c34a16891f84e7b', 4, 1, '2020-05-27 13:58:52', NULL, NULL),
(19, 'Oscar', 'oscar@gmail.com', 'magenial', '827ccb0eea8a706c4c34a16891f84e7b', 4, 0, '2020-05-27 13:59:41', NULL, '2020-05-27 14:00:37');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `usuario_id_2` (`usuario_id`);

--
-- Indices de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `codproducto` (`codproducto`),
  ADD KEY `nofactura` (`nofactura`);

--
-- Indices de la tabla `detalleordendeproduccion`
--
ALTER TABLE `detalleordendeproduccion`
  ADD KEY `idordendeproduccion` (`idordendeproduccion`),
  ADD KEY `idproducto` (`idproducto`);

--
-- Indices de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `nofactura` (`nofactura`),
  ADD KEY `codproducto` (`codproducto`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`idempresa`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `relacionempresa` (`idrelacionempresa`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `idproducto` (`idproducto`);

--
-- Indices de la tabla `estadosmaquinas`
--
ALTER TABLE `estadosmaquinas`
  ADD PRIMARY KEY (`idestado`);

--
-- Indices de la tabla `estadosordenproduccion`
--
ALTER TABLE `estadosordenproduccion`
  ADD PRIMARY KEY (`idestadoordenproduccion`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`nofactura`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `codcliente` (`codcliente`);

--
-- Indices de la tabla `maquinas`
--
ALTER TABLE `maquinas`
  ADD PRIMARY KEY (`idmaquina`),
  ADD KEY `idestado` (`idestado`),
  ADD KEY `idmodulo` (`idmodulo`),
  ADD KEY `tipo_maquina` (`tipo_maquina`);

--
-- Indices de la tabla `moduloiot`
--
ALTER TABLE `moduloiot`
  ADD PRIMARY KEY (`idmoduloIoT`),
  ADD KEY `idtipomoduloiot` (`idtipomoduloiot`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`idmodulo`),
  ADD KEY `idplanta` (`idplanta`);

--
-- Indices de la tabla `ordenesproduccion`
--
ALTER TABLE `ordenesproduccion`
  ADD PRIMARY KEY (`idordenproduccion`),
  ADD KEY `idestadoordenproduccion` (`idestadoordenproduccion`);

--
-- Indices de la tabla `plantas`
--
ALTER TABLE `plantas`
  ADD PRIMARY KEY (`idplanta`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`codproveedor`);

--
-- Indices de la tabla `relacionempresas`
--
ALTER TABLE `relacionempresas`
  ADD PRIMARY KEY (`idrelacionempresa`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `tiposmodulosiot`
--
ALTER TABLE `tiposmodulosiot`
  ADD PRIMARY KEY (`idtipomoduloiot`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  MODIFY `correlativo` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `idempresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `estadosmaquinas`
--
ALTER TABLE `estadosmaquinas`
  MODIFY `idestado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estadosordenproduccion`
--
ALTER TABLE `estadosordenproduccion`
  MODIFY `idestadoordenproduccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `nofactura` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `maquinas`
--
ALTER TABLE `maquinas`
  MODIFY `idmaquina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `moduloiot`
--
ALTER TABLE `moduloiot`
  MODIFY `idmoduloIoT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `idmodulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ordenesproduccion`
--
ALTER TABLE `ordenesproduccion`
  MODIFY `idordenproduccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `plantas`
--
ALTER TABLE `plantas`
  MODIFY `idplanta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `codproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `relacionempresas`
--
ALTER TABLE `relacionempresas`
  MODIFY `idrelacionempresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tiposmodulosiot`
--
ALTER TABLE `tiposmodulosiot`
  MODIFY `idtipomoduloiot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `detallefactura_ibfk_1` FOREIGN KEY (`nofactura`) REFERENCES `factura` (`nofactura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detallefactura_ibfk_2` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalleordendeproduccion`
--
ALTER TABLE `detalleordendeproduccion`
  ADD CONSTRAINT `detalleordendeproduccion_ibfk_1` FOREIGN KEY (`idordendeproduccion`) REFERENCES `ordenesproduccion` (`idordenproduccion`);

--
-- Filtros para la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD CONSTRAINT `detalle_temp_ibfk_1` FOREIGN KEY (`nofactura`) REFERENCES `factura` (`nofactura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_temp_ibfk_2` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD CONSTRAINT `empresas_ibfk_1` FOREIGN KEY (`idrelacionempresa`) REFERENCES `relacionempresas` (`idrelacionempresa`);

--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entradas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`codcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `maquinas`
--
ALTER TABLE `maquinas`
  ADD CONSTRAINT `maquinas_ibfk_1` FOREIGN KEY (`idestado`) REFERENCES `estadosmaquinas` (`idestado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `maquinas_ibfk_2` FOREIGN KEY (`idmodulo`) REFERENCES `modulos` (`idmodulo`);

--
-- Filtros para la tabla `moduloiot`
--
ALTER TABLE `moduloiot`
  ADD CONSTRAINT `moduloiot_ibfk_1` FOREIGN KEY (`idtipomoduloiot`) REFERENCES `tiposmodulosiot` (`idtipomoduloiot`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD CONSTRAINT `modulos_ibfk_1` FOREIGN KEY (`idplanta`) REFERENCES `plantas` (`idplanta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ordenesproduccion`
--
ALTER TABLE `ordenesproduccion`
  ADD CONSTRAINT `idestadoordenproduccion` FOREIGN KEY (`idestadoordenproduccion`) REFERENCES `estadosordenproduccion` (`idestadoordenproduccion`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
