-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 08-08-2024 a las 05:52:43
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbproductor`
--

CREATE TABLE `tbproductor` (
  `idcedula` varchar(300) NOT NULL,
  `nombre` varchar(300) NOT NULL,
  `apellido` varchar(300) NOT NULL,
  `telefono` varchar(300) NOT NULL,
  `correo` varchar(300) NOT NULL,
  `estado` tinyint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbproductor`
--

INSERT INTO `tbproductor` (`idcedula`, `nombre`, `apellido`, `telefono`, `correo`, `estado`) VALUES
('206290384', 'david', 'padilla', '85111356', 'alleriaysebastian@gmail.com', 1);

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
(32, 'AS', 'Blue Angus', 'as', 0);

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
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbestadoproductor`
--
ALTER TABLE `tbestadoproductor`
  ADD PRIMARY KEY (`tbestadoproductorid`);

--
-- Indices de la tabla `tbproductor`
--
ALTER TABLE `tbproductor`
  ADD PRIMARY KEY (`idcedula`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
