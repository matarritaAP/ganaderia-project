-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 20-08-2024 a las 05:22:59
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
-- Base de datos: `dbganaderia`
--

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
(10, 'VTJ', 'Vaca de Trabajo', 'Estado de vaca utilizada para trabajos de campo', 1);

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
(1, 'VTJ', '1', 0);

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
(1, '123', '2024-08-01', '2024-08-22', '../docs/imagenFierro/123.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbfinca`
--

CREATE TABLE `tbfinca` (
  `tbfincaid` int(11) NOT NULL,
  `tbfincanumeroplano` varchar(255) DEFAULT NULL,
  `tbfincacordenada` float DEFAULT NULL,
  `tbfincaareapastoreo` float DEFAULT NULL,
  `tbfincaareaconstruccion` float DEFAULT NULL,
  `tbfincaareaforestal` float DEFAULT NULL,
  `tbfincaareacamino` float DEFAULT NULL,
  `tbfincaestado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbfincaherramienta`
--

CREATE TABLE `tbfincaherramienta` (
  `tbfincaid` int(11) DEFAULT NULL,
  `tbherramientaid` int(11) DEFAULT NULL,
  `tbfincaherramienta` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbfincanaturaleza`
--

CREATE TABLE `tbfincanaturaleza` (
  `tbfincaid` int(11) DEFAULT NULL,
  `tbnaturalezaid` int(11) DEFAULT NULL,
  `tbfincanaturalezaestado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbfincaservicio`
--

CREATE TABLE `tbfincaservicio` (
  `tbfincaid` int(11) DEFAULT NULL,
  `tbservicioid` int(11) DEFAULT NULL,
  `tbfincaservicioestado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbnaturaleza`
--

CREATE TABLE `tbnaturaleza` (
  `tbnaturalezaid` int(11) NOT NULL,
  `tbnaturalezanombre` varchar(255) DEFAULT NULL,
  `tbnaturalezadescrip` varchar(255) DEFAULT NULL,
  `tbnaturalezaestado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `tbproductorestado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbproductor`
--

INSERT INTO `tbproductor` (`tbproductorid`, `tbproductordocidentidad`, `tbproductornombre`, `tbproductorprimerapellido`, `tbproductorsegundoapellido`, `tbproductorfechanac`, `tbproductoremail`, `tbproductorcelular`, `tbproductordireccion`, `tbproductorestado`) VALUES
(1, '702160258', 'Michael', 'Umaña', 'Rojas', '1992-10-05', 'maikolur@gmail.com', '84944221', 'Guacimo-LImon', 1),
(2, '702580654', 'Juan', 'Mendez', 'Sequeira', '2024-08-01', 'juan@gmail.com', '84256447', 'San Jose', 0);

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
(1, '702160258', '123', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbproductorfinca`
--

CREATE TABLE `tbproductorfinca` (
  `tbproductorfincaid` int(11) NOT NULL,
  `tbproductorid` int(11) DEFAULT NULL,
  `tbfincaid` int(11) DEFAULT NULL,
  `tbproductorfincaestado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'HOL', 'Holstein', 'Raza lechera con alta producción de leche.', 1),
(2, 'JER', 'Jersey', 'Raza lechera conocida por su leche rica en grasas.', 1),
(3, 'ANG', 'Angus', 'Raza de carne conocida por su calidad y marmoleo.', 1),
(4, 'HER', 'Hereford', 'Raza de carne resistente y adaptable.', 1),
(5, 'CHA', 'Charolais', 'Raza de carne de origen francés, conocida por su rápido crecimiento.', 1),
(6, 'SIM', 'Simmental', 'Raza de doble propósito (leche y carne).', 1),
(7, 'LIM', 'Limousin', 'Raza de carne con excelente conversión alimenticia.', 1),
(8, 'BRA', 'Brahman', 'Raza de carne resistente al calor y a los parásitos.', 1),
(9, 'DEV', 'Devon', 'Raza de carne con buena calidad de carne y adaptabilidad.', 1),
(10, 'GUE', 'Guernsey', 'Raza lechera conocida por su leche rica en betacarotenos.', 1),
(11, 'BRN', 'Brown Swiss', 'Raza lechera conocida por su longevidad y producción de leche.', 1),
(12, 'AYR', 'Ayrshire', 'Raza lechera con buena producción y adaptabilidad.', 1),
(13, 'GEL', 'Gelbvieh', 'Raza de carne de origen alemán, conocida por su fertilidad.', 1),
(14, 'SHO', 'Shorthorn', 'Raza de carne y leche con buen crecimiento y producción.', 1),
(15, 'DEX', 'Dexter', 'Raza pequeña de doble propósito (leche y carne).', 1),
(16, 'NOR', 'Normande', 'Raza de doble propósito con buena calidad de leche y carne.', 1),
(17, 'RED', 'Red Angus', 'Variante de Angus con pelaje rojo y buena calidad de carne.', 1),
(18, 'SEN', 'Senepol', 'Raza de carne resistente al calor y a los parásitos.', 1),
(19, 'CHI', 'Chianina', 'Raza de carne de gran tamaño y crecimiento rápido.', 1),
(20, 'TAR', 'Tarentaise', 'Raza de doble propósito con buena adaptabilidad y producción.', 1),
(21, 'PIE', 'Piedmontese', 'Raza de carne conocida por su alta musculatura.', 1),
(22, 'BLK', 'Belted Galloway', 'Raza de carne con buena calidad y adaptabilidad.', 1),
(23, 'HIG', 'Highland', 'Raza de carne resistente y adaptada a climas fríos.', 1),
(24, 'BEL', 'Belgian Blue', 'Raza de carne conocida por su alta musculatura.', 1),
(25, 'BLO', 'Blonde d\'Aquitaine', 'Raza de carne con buen crecimiento y rendimiento.', 1),
(26, 'WAG', 'Wagyu', 'Raza de carne conocida por su marmoleo excepcional.', 1),
(27, 'BUE', 'Bue Lapon', 'Raza resistente adaptada a climas fríos.', 1),
(28, 'LON', 'Longhorn', 'Raza de carne conocida por su resistencia y adaptabilidad.', 1),
(29, 'BRM', 'Brahmousin', 'Cruce entre Brahman y Limousin, combinando resistencia y calidad de carne.', 1),
(30, 'SAN', 'Santa Gertrudis', 'Raza de carne conocida por su resistencia y buena adaptabilidad a diferentes climas.', 1),
(31, 'BLA', 'Bramha', 'AS', 0),
(32, 'AS', 'Blue Angus', 'as', 0),
(33, '123', '1234', '12345', 1);

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
(1, 'SAN', '1', 0);

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
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbestadoproductor`
--
ALTER TABLE `tbestadoproductor`
  ADD PRIMARY KEY (`tbestadoproductorid`);

--
-- Indices de la tabla `tbservicio`
--
ALTER TABLE `tbservicio`
  ADD PRIMARY KEY (`tbservicioid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
