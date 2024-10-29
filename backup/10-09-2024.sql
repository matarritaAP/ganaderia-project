-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-09-2024 a las 04:11:25
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
-- Base de datos: `dbganaderia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbadministrador`
--

CREATE TABLE `tbadministrador` (
  `tbadministradorid` int(11) NOT NULL,
  `tbadministradoremail` varchar(255) NOT NULL,
  `tbadministradornombre` varchar(255) NOT NULL,
  `tbadministradorestadocuenta` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbadministrador`
--

INSERT INTO `tbadministrador` (`tbadministradorid`, `tbadministradoremail`, `tbadministradornombre`, `tbadministradorestadocuenta`) VALUES
(1, 'admin@gmail.com', 'Admin', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcomprafertilizantes`
--

CREATE TABLE `tbcomprafertilizantes` (
  `tbcomprafertilizanteid` int(10) NOT NULL,
  `tbcomprafertilizantecodigo` varchar(300) NOT NULL,
  `tbcomprafertilizantenombre` varchar(300) DEFAULT NULL,
  `tbcomprafertilizantenombrecomun` varchar(300) DEFAULT NULL,
  `tbcomprafertilizantepresentacion` varchar(300) DEFAULT NULL,
  `tbcomprafertilizantecasacomercial` varchar(300) DEFAULT NULL,
  `tbcomprafertilizantecantidad` int(10) NOT NULL,
  `tbcomprafertilizantefuncion` varchar(300) DEFAULT NULL,
  `tbcomprafertilizantedosificacion` varchar(300) DEFAULT NULL,
  `tbcomprafertilizantedescripcion` varchar(300) DEFAULT NULL,
  `tbcomprafertilizanteformula` varchar(300) DEFAULT NULL,
  `tbcomprafertilizanteproveedor` varchar(300) DEFAULT NULL,
  `tbcomprafertilizanteprecio` varchar(300) DEFAULT NULL,
  `tbcomprafertilizantefechacompra` varchar(300) DEFAULT NULL,
  `tbcomprafertilizanteestado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbcomprafertilizantes`
--

INSERT INTO `tbcomprafertilizantes` (`tbcomprafertilizanteid`, `tbcomprafertilizantecodigo`, `tbcomprafertilizantenombre`, `tbcomprafertilizantenombrecomun`, `tbcomprafertilizantepresentacion`, `tbcomprafertilizantecasacomercial`, `tbcomprafertilizantecantidad`, `tbcomprafertilizantefuncion`, `tbcomprafertilizantedosificacion`, `tbcomprafertilizantedescripcion`, `tbcomprafertilizanteformula`, `tbcomprafertilizanteproveedor`, `tbcomprafertilizanteprecio`, `tbcomprafertilizantefechacompra`, `tbcomprafertilizanteestado`) VALUES
(1, 'COD-123', 'PruebaCompraFertilizantes', 'Fertelizante Común', 'Galón', 'Casa', 1, 'FuncionCompra', 'ASD', 'Raza de ganado', 'ASD', '1', '15000', '2024-10-06', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcompraherbicidas`
--

CREATE TABLE `tbcompraherbicidas` (
  `tbcompraherbicidasid` int(10) NOT NULL,
  `tbcompracodigo` varchar(300) NOT NULL,
  `tbcompranombre` varchar(300) DEFAULT NULL,
  `tbcompranombrecomun` varchar(300) DEFAULT NULL,
  `tbcomprapresentacion` varchar(300) DEFAULT NULL,
  `tbcompracasacomercial` varchar(300) DEFAULT NULL,
  `tbcompracantidad` int(10) NOT NULL,
  `tbcomprafuncion` varchar(300) DEFAULT NULL,
  `tbcompraaplicacion` varchar(300) DEFAULT NULL,
  `tbcompradescripcion` varchar(300) NOT NULL,
  `tbcompraformula` varchar(300) DEFAULT NULL,
  `tbcompraprovedor` varchar(300) DEFAULT NULL,
  `tbcompraprecio` decimal(10,2) DEFAULT NULL,
  `tbcomprafechacompra` date DEFAULT NULL,
  `tbcompraestado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbcompraherbicidas`
--

INSERT INTO `tbcompraherbicidas` (`tbcompraherbicidasid`, `tbcompracodigo`, `tbcompranombre`, `tbcompranombrecomun`, `tbcomprapresentacion`, `tbcompracasacomercial`, `tbcompracantidad`, `tbcomprafuncion`, `tbcompraaplicacion`, `tbcompradescripcion`, `tbcompraformula`, `tbcompraprovedor`, `tbcompraprecio`, `tbcomprafechacompra`, `tbcompraestado`) VALUES
(1, '1', 'PruebaCompra', 'Compra', 'Galón', 'Casa', 1, 'FuncionCompra', 'Aplicación Modificado', 'Raza de ganado', 'ASD', 'Proveedor', 9000.00, '2024-09-02', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcompraproductoalimenticio`
--

CREATE TABLE `tbcompraproductoalimenticio` (
  `tbcompraproductoalimenticioid` int(11) NOT NULL,
  `tbcompraproductoalimenticionombre` varchar(300) NOT NULL,
  `tbcompraproductoalimenticiotipo` int(11) NOT NULL,
  `tbcompraproductoalimenticiocantidad` int(11) NOT NULL,
  `tbcompraproductoalimenticiofechavencimiento` date NOT NULL,
  `tbcompraproductoalimenticioproveedor` int(11) NOT NULL,
  `tbcompraproductoalimenticioproductor` int(11) NOT NULL,
  `tbcompraproductoalimenticioprecio` decimal(10,2) NOT NULL,
  `tbcompraproductoalimenticiofechacompra` date NOT NULL,
  `tbcompraproductoalimenticioestado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbcompraproductoalimenticio`
--

INSERT INTO `tbcompraproductoalimenticio` (`tbcompraproductoalimenticioid`, `tbcompraproductoalimenticionombre`, `tbcompraproductoalimenticiotipo`, `tbcompraproductoalimenticiocantidad`, `tbcompraproductoalimenticiofechavencimiento`, `tbcompraproductoalimenticioproveedor`, `tbcompraproductoalimenticioproductor`, `tbcompraproductoalimenticioprecio`, `tbcompraproductoalimenticiofechacompra`, `tbcompraproductoalimenticioestado`) VALUES
(1, 'Compra Producto', 1, 12, '2024-12-13', 5, 3, 15.00, '2024-09-02', 0),
(2, 'Compra Producto 1', 2, 12, '1212-12-12', 2, 3, 12.00, '2024-08-28', 1),
(3, 'cas', 2, 12, '0000-00-00', 5, 3, 12.00, '2024-09-02', 0),
(4, 'Compra Producto Nuevo', 1, 12, '2026-10-06', 5, 3, 12.00, '2024-09-08', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcompraproductoveterinario`
--

CREATE TABLE `tbcompraproductoveterinario` (
  `tbcompraid` tinyint(4) NOT NULL,
  `tbcompranombre` varchar(300) NOT NULL,
  `tbcomprafechacompra` date NOT NULL,
  `tbcompracantidad` int(10) DEFAULT NULL,
  `tbcompraprecio` int(10) DEFAULT NULL,
  `tbcompraidproductor` varchar(10) NOT NULL,
  `tbcompraestado` tinyint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcvo`
--

CREATE TABLE `tbcvo` (
  `tbcvoid` int(11) NOT NULL,
  `tbcvonumero` varchar(100) NOT NULL,
  `tbcvofechaEmision` date NOT NULL,
  `tbcvofechaVencimiento` date NOT NULL,
  `tbcvoimagen` varchar(300) NOT NULL,
  `tbcvoestado` tinyint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbcvo`
--

INSERT INTO `tbcvo` (`tbcvoid`, `tbcvonumero`, `tbcvofechaEmision`, `tbcvofechaVencimiento`, `tbcvoimagen`, `tbcvoestado`) VALUES
(1, '123', '2024-08-26', '2026-08-30', '../docs/imagenCVO/123.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcvoproductor`
--

CREATE TABLE `tbcvoproductor` (
  `tbcvoproductorid` int(10) NOT NULL,
  `tbcvoproductornumCVO` varchar(300) NOT NULL,
  `tbcvoproductorcedproductor` varchar(300) NOT NULL,
  `tbcvoproductorestado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbcvoproductor`
--

INSERT INTO `tbcvoproductor` (`tbcvoproductorid`, `tbcvoproductornumCVO`, `tbcvoproductorcedproductor`, `tbcvoproductorestado`) VALUES
(1, 'undefined', '3', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbestado`
--

CREATE TABLE `tbestado` (
  `tbestadoid` int(10) NOT NULL,
  `tbestadocodigo` varchar(300) NOT NULL,
  `tbestadonombre` varchar(300) NOT NULL,
  `tbestadodescripcion` varchar(300) NOT NULL,
  `tbestadoactivo` tinyint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbestado`
--

INSERT INTO `tbestado` (`tbestadoid`, `tbestadocodigo`, `tbestadonombre`, `tbestadodescripcion`, `tbestadoactivo`) VALUES
(1, 'NBL', 'Novillo', 'Estado de novillo, ganado joven', 1),
(2, 'TRN', 'Ternero', 'Estado de ternero, ganado joven', 1),
(3, 'VCL', 'Vaca Lechera', 'Estado de vaca dedicada a la producción de leche', 1),
(4, 'TRO', 'Toro', 'Estado de toro, macho adulto', 1),
(5, 'RPL', 'Reproductor', 'Estado de ganado utilizado para reproducción', 1),
(6, 'VCR', 'Vaca en Receso', 'Estado de vaca que no está en producción de leche actualmente', 1),
(7, 'CRD', 'Cría Destetada', 'Estado de cría que ha sido separada de su madre', 1),
(8, 'VCE', 'Vaca Embarazada', 'Estado de vaca que está gestando', 1),
(9, 'BEC', 'Becerro', 'Estado de becerro, cría joven', 1),
(10, 'VTJ', 'Vaca de Trabajo', 'Estado de vaca utilizada para trabajos de campo', 1),
(11, 'NES', 'Nobillo Mod', 'Estado de novillo, ganado joven', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbestadoproductor`
--

CREATE TABLE `tbestadoproductor` (
  `tbestadoproductorid` int(10) NOT NULL,
  `tbestadoproductorcodestado` varchar(300) NOT NULL,
  `tbestadoproductorcedproductor` varchar(300) NOT NULL,
  `tbestadoproductorestado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbestadoproductor`
--

INSERT INTO `tbestadoproductor` (`tbestadoproductorid`, `tbestadoproductorcodestado`, `tbestadoproductorcedproductor`, `tbestadoproductorestado`) VALUES
(1, 'NBL', '1', 1),
(2, 'TRN', '1', 1),
(3, 'TRO', '1', 0),
(4, 'NBL', '3', 1),
(5, 'NBL', '4', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbfertilizantes`
--

CREATE TABLE `tbfertilizantes` (
  `tbfertilizanteid` int(10) NOT NULL,
  `tbfertilizantecodigo` varchar(300) NOT NULL,
  `tbfertilizantenombre` varchar(300) DEFAULT NULL,
  `tbfertilizantenombrecomun` varchar(300) DEFAULT NULL,
  `tbfertilizantepresentacion` varchar(300) DEFAULT NULL,
  `tbfertilizantecasacomercial` varchar(300) DEFAULT NULL,
  `tbfertilizantecantidad` int(10) NOT NULL,
  `tbfertilizantefuncion` varchar(300) DEFAULT NULL,
  `tbfertilizantedosificacion` varchar(300) DEFAULT NULL,
  `tbfertilizantedescripcion` varchar(300) DEFAULT NULL,
  `tbfertilizanteformula` varchar(300) DEFAULT NULL,
  `tbfertilizanteproveedor` varchar(300) DEFAULT NULL,
  `tbfertilizanteestado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbfertilizantes`
--

INSERT INTO `tbfertilizantes` (`tbfertilizanteid`, `tbfertilizantecodigo`, `tbfertilizantenombre`, `tbfertilizantenombrecomun`, `tbfertilizantepresentacion`, `tbfertilizantecasacomercial`, `tbfertilizantecantidad`, `tbfertilizantefuncion`, `tbfertilizantedosificacion`, `tbfertilizantedescripcion`, `tbfertilizanteformula`, `tbfertilizanteproveedor`, `tbfertilizanteestado`) VALUES
(1, 'ssd', 'asd', 'ad', 'ad', 'ad', 2147483647, 'asd', 'ad', '66666', 'ad', 'ad', 1),
(2, '0', '0', '0', '0', '0', 0, '0', '00', '0', '0', '0', 0),
(3, '55555', '5', '55', '5', '5', 5, '5', '5', '5', '55', '5', 0),
(4, '0', '0', '0', '0', '0', 0, '0', '0', '00', '0', '0', 0),
(5, '1', '1', '1', '1', '1', 1, '1', '1', '1', '1', '1', 1),
(6, '44', '9', '945345egfwet', '9', '9', 9, '9', '9', '9', '99', '9', 1),
(7, '1', 'Fertilizante', 'Fertelizante Común', 'Galón', 'Casa', 1, 'ASD', 'ASD', 'ASD', 'ASD', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbfierro`
--

CREATE TABLE `tbfierro` (
  `tbfierroid` int(11) NOT NULL,
  `tbfierronumero` varchar(255) DEFAULT NULL,
  `tbfierrofechaemision` date DEFAULT NULL,
  `tbfierrofechavencimiento` date DEFAULT NULL,
  `tbfierroimagen` varchar(255) DEFAULT NULL,
  `tbestado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbfierro`
--

INSERT INTO `tbfierro` (`tbfierroid`, `tbfierronumero`, `tbfierrofechaemision`, `tbfierrofechavencimiento`, `tbfierroimagen`, `tbestado`) VALUES
(1, '123', '2024-08-01', '2024-08-22', '../docs/imagenFierro/123.jpg', 1),
(2, '321', '2024-08-20', '2027-02-20', '../docs/imagenFierro/321.jpg', 1),
(3, '444', '2024-08-21', '2024-08-10', '../docs/imagenFierro/444.jpg', 1),
(4, '777', '2024-08-21', '2024-08-30', '../docs/imagenFierro/777.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbfinca`
--

CREATE TABLE `tbfinca` (
  `tbfincaid` int(11) NOT NULL,
  `tbfincanumplano` varchar(255) DEFAULT NULL,
  `tbfincacoordenada` varchar(255) DEFAULT NULL,
  `tbfincaareapastoreo` float DEFAULT NULL,
  `tbfincaareaconstruccion` float DEFAULT NULL,
  `tbfincaareaforestal` float DEFAULT NULL,
  `tbfincaareacamino` float DEFAULT NULL,
  `tbfincaestado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbfinca`
--

INSERT INTO `tbfinca` (`tbfincaid`, `tbfincanumplano`, `tbfincacoordenada`, `tbfincaareapastoreo`, `tbfincaareaconstruccion`, `tbfincaareaforestal`, `tbfincaareacamino`, `tbfincaestado`) VALUES
(1, 'PLAN001', '12345', 34, 20, 20, 12, 0),
(2, 'PLAN002', '79-12', 10, 15, 20, 5, 1),
(3, 'PLAN003', '12-76', 20, 30, 40, 10, 1),
(4, 'PLAN004', '86-90', 40, 30, 20, 10, 1),
(5, 'PLAN0012', '1', 1, 1, 1, 1, 1),
(6, 'h-001283', '23424', 2342430, 234242, 2342, 243, 1),
(7, 'H-12324', '1', NULL, 12345, NULL, 1, 0),
(8, 'Prueba', NULL, NULL, NULL, NULL, NULL, 0),
(9, 'PPPP', '12345', 122, 2222, 5555, 12, 0),
(10, 'P-001', '12-124', NULL, 12, NULL, NULL, 1),
(11, 'P-00112', '76-88', NULL, NULL, 12, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbfincaherramienta`
--

CREATE TABLE `tbfincaherramienta` (
  `tbfincaherramientaid` int(11) DEFAULT NULL,
  `tbfincaherramientafincaid` int(11) DEFAULT NULL,
  `tbfincaherramientaherramientaid` int(11) NOT NULL,
  `tbfincaherramientaestado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbfincaherramienta`
--

INSERT INTO `tbfincaherramienta` (`tbfincaherramientaid`, `tbfincaherramientafincaid`, `tbfincaherramientaherramientaid`, `tbfincaherramientaestado`) VALUES
(1, 2, 1, 1),
(2, 2, 2, 1),
(3, 3, 4, 0),
(4, 3, 4, 1),
(5, 2, 9, 1),
(6, 5, 3, 1),
(7, 5, 6, 1),
(8, 5, 8, 1),
(9, 5, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbfincanaturaleza`
--

CREATE TABLE `tbfincanaturaleza` (
  `tbfincanaturalezaid` int(11) DEFAULT NULL,
  `tbfincanaturalezafincaid` int(11) DEFAULT NULL,
  `tbfincanaturalezanaturalezaid` int(11) NOT NULL,
  `tbfincanaturalezaestado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbfincanaturaleza`
--

INSERT INTO `tbfincanaturaleza` (`tbfincanaturalezaid`, `tbfincanaturalezafincaid`, `tbfincanaturalezanaturalezaid`, `tbfincanaturalezaestado`) VALUES
(1, 3, 1, 1),
(2, 3, 2, 0),
(3, 4, 4, 1),
(4, 4, 2, 0),
(5, 5, 1, 1),
(6, 5, 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbfincaproductor`
--

CREATE TABLE `tbfincaproductor` (
  `tbfincaproductorid` int(11) NOT NULL,
  `tbfincaproductorproductorid` int(11) DEFAULT NULL,
  `tbfincaproductorfincaid` int(11) DEFAULT NULL,
  `tbfincaproductorestado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbfincaproductor`
--

INSERT INTO `tbfincaproductor` (`tbfincaproductorid`, `tbfincaproductorproductorid`, `tbfincaproductorfincaid`, `tbfincaproductorestado`) VALUES
(1, 3, 1, 0),
(2, 3, 2, 1),
(3, 3, 3, 1),
(4, 3, 4, 1),
(5, 4, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbfincaservicio`
--

CREATE TABLE `tbfincaservicio` (
  `tbfincaservicioid` int(11) DEFAULT NULL,
  `tbfincaserviciofincaid` int(11) NOT NULL,
  `tbfincaservicioservicioid` int(11) DEFAULT NULL,
  `tbfincaservicioestado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbfincaservicio`
--

INSERT INTO `tbfincaservicio` (`tbfincaservicioid`, `tbfincaserviciofincaid`, `tbfincaservicioservicioid`, `tbfincaservicioestado`) VALUES
(1, 2, 1, 1),
(2, 2, 2, 0),
(3, 2, 2, 1),
(4, 2, 4, 1),
(5, 4, 1, 0),
(6, 4, 1, 1),
(7, 4, 2, 1),
(8, 3, 6, 1),
(9, 2, 10, 1),
(10, 5, 1, 1),
(11, 5, 2, 1),
(12, 5, 3, 1),
(13, 5, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbherbicidas`
--

CREATE TABLE `tbherbicidas` (
  `tbherbicidasid` int(10) NOT NULL,
  `tbcodigo` varchar(300) NOT NULL,
  `tbnombre` varchar(300) DEFAULT NULL,
  `tbnombrecomun` varchar(300) DEFAULT NULL,
  `tbpresentacion` varchar(300) DEFAULT NULL,
  `tbcasacomercial` varchar(300) DEFAULT NULL,
  `tbcantidad` int(10) NOT NULL,
  `tbfuncion` varchar(300) DEFAULT NULL,
  `tbaplicacion` varchar(300) DEFAULT NULL,
  `tbdescripcion` varchar(300) NOT NULL,
  `tbformula` varchar(300) DEFAULT NULL,
  `tbprovedor` varchar(300) DEFAULT NULL,
  `tbestado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbherbicidas`
--

INSERT INTO `tbherbicidas` (`tbherbicidasid`, `tbcodigo`, `tbnombre`, `tbnombrecomun`, `tbpresentacion`, `tbcasacomercial`, `tbcantidad`, `tbfuncion`, `tbaplicacion`, `tbdescripcion`, `tbformula`, `tbprovedor`, `tbestado`) VALUES
(1, '1', 'PruebaCompra', 'Compra', 'Galón', 'Casa', 1, 'FuncionCompra', 'as', 'Raza de ganado', '1', 'Proveedor', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbherramienta`
--

CREATE TABLE `tbherramienta` (
  `tbherramientaid` int(11) NOT NULL,
  `tbherramientacodigo` varchar(255) DEFAULT NULL,
  `tbherramientanombre` varchar(255) DEFAULT NULL,
  `tbherramientadescripcion` varchar(255) NOT NULL,
  `tbherramientaestado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbherramienta`
--

INSERT INTO `tbherramienta` (`tbherramientaid`, `tbherramientacodigo`, `tbherramientanombre`, `tbherramientadescripcion`, `tbherramientaestado`) VALUES
(1, 'H01', 'Ariete', 'Herramienta para cavar y mover tierra', 0),
(2, 'H02', 'ArieteMOD', 'Herramienta para cavar y mover tierra', 0),
(3, 'H03', 'Rastrillo', 'Herramienta para nivelar y recoger material', 1),
(4, 'H04', 'Azadón', 'Herramienta para cortar raíces y preparar el suelo', 1),
(5, 'H05', 'Podadora', 'Herramienta para cortar ramas y arbustos', 1),
(6, 'H06', 'Manguera', 'Herramienta para riego y limpieza', 1),
(7, 'H07', 'Sierra', 'Herramienta para cortar madera', 1),
(8, 'H08', 'Desmalezadora', 'Herramienta para eliminar maleza', 1),
(9, 'H09', 'Carretilla', 'Herramienta para transportar materiales', 1),
(10, 'H10', 'ArieteM', 'Herramienta para cavar y mover tierra', 1),
(11, 'PALHER00', 'Pala', 'Herramienta para cavar y mover tierra', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbnaturaleza`
--

CREATE TABLE `tbnaturaleza` (
  `tbnaturalezaid` int(11) NOT NULL,
  `tbnaturalezacodigo` varchar(255) DEFAULT NULL,
  `tbnaturalezanombre` varchar(255) DEFAULT NULL,
  `tbnaturalezadescripcion` varchar(255) DEFAULT NULL,
  `tbnaturalezaestado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbnaturaleza`
--

INSERT INTO `tbnaturaleza` (`tbnaturalezaid`, `tbnaturalezacodigo`, `tbnaturalezanombre`, `tbnaturalezadescripcion`, `tbnaturalezaestado`) VALUES
(1, 'BOV01', 'Ganado Lechero', 'Finca dedicada a la producción de leche bovina.', 1),
(2, 'BOV02', 'Ganado Cárnico', 'Finca enfocada en la cría de ganado para producción de carne.', 1),
(3, 'AV01', 'Aves de Corral', 'Finca destinada a la cría de aves para producción de carne y huevos.', 0),
(4, 'POR01', 'Cerdos', 'Finca especializada en la cría de cerdos para producción de carne.', 1),
(5, 'OV01', 'Ovejas', 'Finca dedicada a la cría de ovejas para lana y carne.', 1),
(6, 'CAP01', 'Cabras', 'Finca enfocada en la cría de cabras para leche y carne.', 1),
(7, 'MIS01', 'Mixto', 'Finca con una combinación de diferentes tipos de ganado y cultivos.', 1),
(8, 'AG01', 'Cultivos de Granos', 'Finca dedicada a la producción de granos como maíz, trigo y soja.', 1),
(9, 'FR01', 'Frutales', 'Finca especializada en el cultivo de frutas como manzanas, naranjas y uvas.', 1),
(10, 'VEG01', 'Hortalizas', 'Finca enfocada en la producción de hortalizas y vegetales.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbproductoalimenticio`
--

CREATE TABLE `tbproductoalimenticio` (
  `tbproductoalimenticioid` int(11) NOT NULL,
  `tbproductoalimenticionombre` varchar(300) NOT NULL,
  `tbproductoalimenticiotipo` int(11) NOT NULL,
  `tbproductoalimenticiocantidad` int(11) NOT NULL,
  `tbproductoalimenticiofechavencimiento` date NOT NULL,
  `tbproductoalimenticioproveedor` int(11) NOT NULL,
  `tbproductoalimenticioproductor` int(11) NOT NULL,
  `tbproductoalimenticioestado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbproductoalimenticio`
--

INSERT INTO `tbproductoalimenticio` (`tbproductoalimenticioid`, `tbproductoalimenticionombre`, `tbproductoalimenticiotipo`, `tbproductoalimenticiocantidad`, `tbproductoalimenticiofechavencimiento`, `tbproductoalimenticioproveedor`, `tbproductoalimenticioproductor`, `tbproductoalimenticioestado`) VALUES
(1, 'Producto Alimenticio', 5, 19, '2026-07-09', 2, 3, 1),
(2, 'Producto Alimenticio 2', 5, 130, '2027-09-20', 6, 4, 0),
(3, 'Producto Alimenticio NUEVO', 1, 12, '2026-07-09', 6, 4, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbproductor`
--

CREATE TABLE `tbproductor` (
  `tbproductorid` int(11) NOT NULL,
  `tbproductordocidentidad` varchar(255) DEFAULT NULL,
  `tbproductornombre` varchar(255) DEFAULT NULL,
  `tbproductorprimerapellido` varchar(255) DEFAULT NULL,
  `tbproductorsegundoapellido` varchar(255) DEFAULT NULL,
  `tbproductorfechanac` date DEFAULT NULL,
  `tbproductoremail` varchar(255) DEFAULT NULL,
  `tbproductorcelular` varchar(255) DEFAULT NULL,
  `tbproductordireccion` varchar(255) DEFAULT NULL,
  `tbproductorcontrasenia` varchar(300) DEFAULT NULL,
  `tbproductorestado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbproductor`
--

INSERT INTO `tbproductor` (`tbproductorid`, `tbproductordocidentidad`, `tbproductornombre`, `tbproductorprimerapellido`, `tbproductorsegundoapellido`, `tbproductorfechanac`, `tbproductoremail`, `tbproductorcelular`, `tbproductordireccion`, `tbproductorcontrasenia`, `tbproductorestado`) VALUES
(1, '702160258', 'Michael', 'Umaña', 'Rojas', '1992-10-05', 'maikolur@gmail.com', '84944221', 'Guacimo-LImon', '$2y$10$BpcEIS3DU/hzuFzlEpxeReF2jVciEEWW81ttJYPVjA3Af9HAzIWrG', 1),
(2, '702580654', 'Juan', 'Mendez', 'Sequeira', '2024-08-01', 'juan@gmail.com', '84256447', 'San Jose', '$2y$10$I1Vs3gYfln9XP0JDtaMZB.OV5qU1FX9Cx/T4Syw2LsJuOBeQB42/2', 1),
(3, '119160537', 'Aaron', 'Matarrita', 'Portuguez', '2004-09-10', 'aaronmatarritaportuguez@gmail.com', '60900809', 'Heredia, Sarapiquí', '$2y$10$I1Vs3gYfln9XP0JDtaMZB.OV5qU1FX9Cx/T4Syw2LsJuOBeQB42/2', 1),
(4, '888888', 'Prueba', 'Prueba', 'Prueba', '2024-08-22', 'Prueba', '12345678', 'Heredia - Barva', '$2y$10$I1Vs3gYfln9XP0JDtaMZB.OV5qU1FX9Cx/T4Syw2LsJuOBeQB42/2', 1),
(5, '000000', 'Test', 'Apellido Test', 'Apellido Segundo Test', '2024-09-08', 'test@gmail.com', '12345677', 'San José, Costa Rica', '$2y$10$jYsFEM2kqYIQcuFe7t446ufpPe7Hy.kk4VMYxKW.pW.TSNHjAcyei', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbproductorfierro`
--

CREATE TABLE `tbproductorfierro` (
  `tbproductorfierroid` int(11) NOT NULL,
  `tbproductorid` varchar(300) DEFAULT NULL,
  `tbfierroid` varchar(300) DEFAULT NULL,
  `tbproductorfierroestado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbproductorfierro`
--

INSERT INTO `tbproductorfierro` (`tbproductorfierroid`, `tbproductorid`, `tbfierroid`, `tbproductorfierroestado`) VALUES
(1, '3', '123', 1),
(2, '3', '321', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbproductoveterinario`
--

CREATE TABLE `tbproductoveterinario` (
  `tbproductoveterinarioid` int(11) NOT NULL,
  `tbproductoveterinarionombre` varchar(300) NOT NULL,
  `tbproductoveterinarioprincipioactivo` varchar(300) DEFAULT NULL,
  `tbproductoveterinariodosificacion` varchar(300) DEFAULT NULL,
  `tbproductoveterinariofechavencimiento` date DEFAULT NULL,
  `tbproductoveterinariofuncion` varchar(300) DEFAULT NULL,
  `tbproductoveterinariodescripcion` varchar(300) DEFAULT NULL,
  `tbproductoveterinariotipomedicamento` varchar(300) DEFAULT NULL,
  `tbproductoveterinarioproveedor` varchar(300) DEFAULT NULL,
  `tbproductoveterinarioproductorid` varchar(300) NOT NULL,
  `tbproductoveterinarioestado` tinyint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbproveedor`
--

CREATE TABLE `tbproveedor` (
  `tbproveedorid` int(11) NOT NULL,
  `tbproveedornombrecomercial` varchar(300) NOT NULL,
  `tbproveedorpropietario` varchar(300) NOT NULL,
  `tbproveedortelefonowhatsapp` varchar(300) NOT NULL,
  `tbproveedorcorreo` varchar(300) NOT NULL,
  `tbproveedorsinpe` varchar(300) NOT NULL,
  `tbproveedortelefonofijo` varchar(300) NOT NULL,
  `tbproveedorestado` tinyint(4) NOT NULL,
  `tbproveedorproductorid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbproveedor`
--

INSERT INTO `tbproveedor` (`tbproveedorid`, `tbproveedornombrecomercial`, `tbproveedorpropietario`, `tbproveedortelefonowhatsapp`, `tbproveedorcorreo`, `tbproveedorsinpe`, `tbproveedortelefonofijo`, `tbproveedorestado`, `tbproveedorproductorid`) VALUES
(1, 'Alimentos Bovinos S.A.', 'Carlos Ramírez', '8888-1111', 'carlos@bovinos.com', '1234567890', '2222-3333', 1, 1),
(2, 'Fertilizantes Verdes', 'María Fernández', '8888-2222', 'maria@verdes.com', '2345678901', '2222-4444', 1, 3),
(3, 'Herbicidas y Control', 'Pedro Martínez', '8888-3333', 'pedro@control.com', '3456789012', '2222-5555', 1, 1),
(4, 'Granos del Campo', 'Laura Rodríguez', '8888-4444', 'laura@granos.com', '4567890123', '2222-6666', 1, 2),
(5, 'Suplementos Ganaderos', 'José González', '8888-5555', 'jose@ganaderos.com', '5678901234', '2222-7777', 0, 4),
(6, 'Alimentos Bovinos S', 'Carlos Ramírez', '8888-1111', 'carlos@bovinos.com', '1234567890', '2222-3333', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbraza`
--

CREATE TABLE `tbraza` (
  `tbrazaid` int(10) NOT NULL,
  `tbrazacodigo` varchar(300) NOT NULL,
  `tbrazanombre` varchar(300) NOT NULL,
  `tbrazadescripcion` varchar(300) NOT NULL,
  `tbrazaestado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbraza`
--

INSERT INTO `tbraza` (`tbrazaid`, `tbrazacodigo`, `tbrazanombre`, `tbrazadescripcion`, `tbrazaestado`) VALUES
(1, 'ADM-HOL', 'Holstein', 'Raza lechera con alta producción de leche', 1),
(2, 'ADM-JER', 'Jersey', 'Raza lechera conocida por su leche rica en grasas.', 1),
(3, 'ADM-ANG', 'Angus', 'Raza de carne conocida por su calidad y marmoleo.', 1),
(4, 'ADM-HER', 'Hereford', 'Raza de carne resistente y adaptable.', 1),
(5, 'ADM-CHA', 'Charolais', 'Raza de carne de origen francés, conocida por su rápido crecimiento.', 1),
(6, 'ADM-SIM', 'Simmental', 'Raza de doble propósito (leche y carne).', 1),
(7, 'ADM-LIM', 'Limousin', 'Raza de carne con excelente conversión alimenticia.', 1),
(8, 'ADM-BRA', 'Brahman', 'Raza de carne resistente al calor y a los parásitos.', 1),
(9, 'ADM-DEV', 'Devon', 'Raza de carne con buena calidad de carne y adaptabilidad.', 1),
(10, 'ADM-GUE', 'Guernsey', 'Raza lechera conocida por su leche rica en betacarotenos.', 1),
(11, 'ADM-BRN', 'Brown Swiss', 'Raza lechera conocida por su longevidad y producción de leche.', 1),
(12, 'ADM-AYR', 'Ayrshire', 'Raza lechera con buena producción y adaptabilidad.', 1),
(13, 'ADM-GEL', 'Gelbvieh', 'Raza de carne de origen alemán, conocida por su fertilidad.', 1),
(14, 'ADM-SHO', 'Shorthorn', 'Raza de carne y leche con buen crecimiento y producción.', 1),
(15, 'ADM-DEX', 'Dexter', 'Raza pequeña de doble propósito (leche y carne).', 1),
(16, 'ADM-NOR', 'Normande', 'Raza de doble propósito con buena calidad de leche y carne.', 1),
(17, 'ADM-RED', 'Red Angus', 'Variante de Angus con pelaje rojo y buena calidad de carne.', 1),
(18, 'ADM-SEN', 'Senepol', 'Raza de carne resistente al calor y a los parásitos.', 1),
(19, 'ADM-CHI', 'Chianina', 'Raza de carne de gran tamaño y crecimiento rápido.', 1),
(20, 'ADM-TAR', 'Tarentaise', 'Raza de doble propósito con buena adaptabilidad y producción.', 1),
(21, 'ADM-PIE', 'Piedmontese', 'Raza de carne conocida por su alta musculatura.', 1),
(22, 'ADM-BLK', 'Belted Galloway', 'Raza de carne con buena calidad y adaptabilidad.', 1),
(23, 'ADM-HIG', 'Highland', 'Raza de carne resistente y adaptada a climas fríos.', 1),
(24, 'ADM-BEL', 'Belgian Blue', 'Raza de carne conocida por su alta musculatura.', 1),
(25, 'ADM-BLO', 'Blonde d\'Aquitaine', 'Raza de carne con buen crecimiento y rendimiento.', 1),
(26, 'ADM-WAG', 'Wagyu', 'Raza de carne conocida por su marmoleo excepcional.', 1),
(27, 'ADM-BUE', 'Bue Lapon', 'Raza resistente adaptada a climas fríos.', 1),
(28, 'ADM-LON', 'Longhorn', 'Raza de carne conocida por su resistencia y adaptabilidad.', 1),
(29, 'ADM-BRM', 'Brahmousin', 'Cruce entre Brahman y Limousin, combinando resistencia y calidad de carne.', 1),
(30, 'ADM-SAN', 'Santa Gertrudis', 'Raza de carne conocida por su resistencia y buena adaptabilidad a diferentes climas.', 1),
(31, 'ADM-BLA', 'Bramha', 'AS', 1),
(32, 'ADM-AS', 'Blue Angus', 'as', 0),
(33, 'PRD-3-NUECRU00', 'Nueva raza', 'cruce propio', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbrazaproductor`
--

CREATE TABLE `tbrazaproductor` (
  `tbrazaproductorid` int(11) NOT NULL,
  `tbrazaproductorcodraza` varchar(300) NOT NULL,
  `tbrazaproductorcedproductor` varchar(300) NOT NULL,
  `tbrazaproductorestado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbrazaproductor`
--

INSERT INTO `tbrazaproductor` (`tbrazaproductorid`, `tbrazaproductorcodraza`, `tbrazaproductorcedproductor`, `tbrazaproductorestado`) VALUES
(1, 'ADM-ANG', '4', 1),
(2, 'ADM-GUE', '4', 1),
(3, 'ADM-AYR', '4', 1),
(4, 'ADM-CHI', '4', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbservicio`
--

CREATE TABLE `tbservicio` (
  `tbservicioid` int(11) NOT NULL,
  `tbserviciocodigo` varchar(255) NOT NULL,
  `tbservicionombre` varchar(255) NOT NULL,
  `tbserviciodescripcion` text NOT NULL,
  `tbservicioestado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbservicio`
--

INSERT INTO `tbservicio` (`tbservicioid`, `tbserviciocodigo`, `tbservicionombre`, `tbserviciodescripcion`, `tbservicioestado`) VALUES
(1, 'S01', 'Agua', 'Servicio de suministro de agua para la finca', 1),
(2, 'S02', 'Luz', 'Servicio de suministro eléctrico para la finca', 1),
(3, 'S03', 'Internet', 'Servicio de conexión a Internet en la finca', 1),
(4, 'S04', 'Recolección de Basura', 'Servicio de recolección y disposición de residuos', 1),
(5, 'S05', 'Mantenimiento de Equipos', 'Servicio de mantenimiento de equipos y maquinaria', 1),
(6, 'S06', 'Control de Plagas', 'Servicio para el control y prevención de plagas', 1),
(7, 'SO7', 'Atención veterinaria para el ganado', 'Servicios de salud y cuidado animal', 1),
(8, 'SO8', 'Suministro de alimentos para el ganado', 'Servicios de alimentación para animales', 1),
(9, 'SO9', 'Servicio de transporte para la finca', 'Transporte de productos y materiales', 1),
(10, 'SO10', 'Servicio de seguridad en la finca', 'Servicios de vigilancia y seguridad', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbsesion`
--

CREATE TABLE `tbsesion` (
  `tbsesionid` int(11) DEFAULT NULL,
  `tbsesionrol` enum('ADMIN','PRODUCTOR') NOT NULL,
  `tbsesionproductorid` int(11) DEFAULT NULL,
  `tbsesionadministradorid` int(11) DEFAULT NULL,
  `tbsesionusuarionombre` varchar(255) NOT NULL,
  `tbsesionusuariocontrasenia` varchar(300) NOT NULL,
  `tbsesionusuarioestado` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbsesion`
--

INSERT INTO `tbsesion` (`tbsesionid`, `tbsesionrol`, `tbsesionproductorid`, `tbsesionadministradorid`, `tbsesionusuarionombre`, `tbsesionusuariocontrasenia`, `tbsesionusuarioestado`) VALUES
(4, 'PRODUCTOR', 3, NULL, 'aaronmatarritaportuguez@gmail.com', '$2y$10$I1Vs3gYfln9XP0JDtaMZB.OV5qU1FX9Cx/T4Syw2LsJuOBeQB42/2', 1),
(1, 'ADMIN', NULL, 1, 'admin@gmail.com', '$2y$10$I1Vs3gYfln9XP0JDtaMZB.OV5qU1FX9Cx/T4Syw2LsJuOBeQB42/2', 1),
(3, 'PRODUCTOR', 2, NULL, 'juan@gmail.com', '$2y$10$I1Vs3gYfln9XP0JDtaMZB.OV5qU1FX9Cx/T4Syw2LsJuOBeQB42/2', 1),
(2, 'PRODUCTOR', 1, NULL, 'maikolur@gmail.com', '$2y$10$BpcEIS3DU/hzuFzlEpxeReF2jVciEEWW81ttJYPVjA3Af9HAzIWrG', 1),
(5, 'PRODUCTOR', 4, NULL, 'Prueba', '$2y$10$I1Vs3gYfln9XP0JDtaMZB.OV5qU1FX9Cx/T4Syw2LsJuOBeQB42/2', 1),
(6, 'PRODUCTOR', 5, NULL, 'test@gmail.com', '$2y$10$jYsFEM2kqYIQcuFe7t446ufpPe7Hy.kk4VMYxKW.pW.TSNHjAcyei', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipomedicamento`
--

CREATE TABLE `tbtipomedicamento` (
  `tbtipoMedicamentoid` int(11) NOT NULL,
  `tbtipoMedicamentoTipoMedicamento` varchar(300) NOT NULL,
  `tbtipoMedicamentoEstado` tinyint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbtipomedicamento`
--

INSERT INTO `tbtipomedicamento` (`tbtipoMedicamentoid`, `tbtipoMedicamentoTipoMedicamento`, `tbtipoMedicamentoEstado`) VALUES
(1, 'Antibióticos', 1),
(2, 'Antiinflamatorios', 1),
(3, 'Analgesicos', 1),
(4, 'Vitaminas', 1),
(5, 'Antiparasitarios', 1),
(6, 'Hormonas', 1),
(7, 'Antifúngicos', 1),
(8, 'Suplementos Minerales', 1),
(9, 'Sedantes', 1),
(10, 'Vacunas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipoproductoalimenticio`
--

CREATE TABLE `tbtipoproductoalimenticio` (
  `tbtipoproductoalimenticioid` int(11) NOT NULL,
  `tbtipoproductoalimenticionombre` varchar(300) NOT NULL,
  `tbtipoproductoalimenticiodescripcion` varchar(300) NOT NULL,
  `tbtipoproductoalimenticioestado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbtipoproductoalimenticio`
--

INSERT INTO `tbtipoproductoalimenticio` (`tbtipoproductoalimenticioid`, `tbtipoproductoalimenticionombre`, `tbtipoproductoalimenticiodescripcion`, `tbtipoproductoalimenticioestado`) VALUES
(1, 'Concentrado de alta energía', 'Alimento balanceado rico en energía, diseñado para maximizar la producción de leche en vacas lecheras.', 1),
(2, 'Forraje de corte', 'Cosecha de pastos o leguminosas cortadas y almacenadas para alimentar al ganado en épocas de escasez de pasto fresco.', 1),
(3, 'Suplemento mineral', 'Mezcla de minerales esenciales para cubrir las deficiencias dietéticas del ganado en pastoreo.', 1),
(4, 'Concentrado de crecimiento', 'Alimento balanceado especialmente formulado para promover un crecimiento rápido y saludable en terneros.', 1),
(5, 'Henolaje de leguminosas', 'Ensilado de leguminosas con alta concentración de proteínas, utilizado como suplemento en la alimentación del ganado durante el invierno.', 1),
(6, 'Prueba', 'Prueba', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbunidadmedida`
--

CREATE TABLE `tbunidadmedida` (
  `tbunidadMedidaid` int(11) NOT NULL,
  `tbUnidadMedidaTipoUnidad` varchar(300) NOT NULL,
  `tbUnidadMedidaEstado` tinyint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tbunidadmedida`
--

INSERT INTO `tbunidadmedida` (`tbunidadMedidaid`, `tbUnidadMedidaTipoUnidad`, `tbUnidadMedidaEstado`) VALUES
(1, 'Galones', 1),
(2, 'Litros', 1),
(3, 'Kilogramos', 1),
(4, 'Gramos', 1),
(5, 'Metros', 1),
(6, 'Centímetros', 1),
(7, 'Hectáreas', 1),
(8, 'Pulgadas', 1),
(9, 'Milímetros', 1),
(10, 'Onzas', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbestadoproductor`
--
ALTER TABLE `tbestadoproductor`
  ADD PRIMARY KEY (`tbestadoproductorid`);

--
-- Indices de la tabla `tbfincaproductor`
--
ALTER TABLE `tbfincaproductor`
  ADD PRIMARY KEY (`tbfincaproductorid`);

--
-- Indices de la tabla `tbproductoalimenticio`
--
ALTER TABLE `tbproductoalimenticio`
  ADD PRIMARY KEY (`tbproductoalimenticioid`),
  ADD KEY `tbproductoalimenticiotipo` (`tbproductoalimenticiotipo`),
  ADD KEY `tbproductoalimenticioproductor` (`tbproductoalimenticioproductor`),
  ADD KEY `tbproductoalimenticioproveedor` (`tbproductoalimenticioproveedor`);

--
-- Indices de la tabla `tbproductor`
--
ALTER TABLE `tbproductor`
  ADD PRIMARY KEY (`tbproductorid`);

--
-- Indices de la tabla `tbproveedor`
--
ALTER TABLE `tbproveedor`
  ADD PRIMARY KEY (`tbproveedorid`);

--
-- Indices de la tabla `tbservicio`
--
ALTER TABLE `tbservicio`
  ADD PRIMARY KEY (`tbservicioid`);

--
-- Indices de la tabla `tbsesion`
--
ALTER TABLE `tbsesion`
  ADD UNIQUE KEY `tbsesionusuarionombre` (`tbsesionusuarionombre`);

--
-- Indices de la tabla `tbtipoproductoalimenticio`
--
ALTER TABLE `tbtipoproductoalimenticio`
  ADD PRIMARY KEY (`tbtipoproductoalimenticioid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
