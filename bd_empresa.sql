-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `empresa`
--
CREATE DATABASE IF NOT EXISTS `empresa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE `empresa`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE IF NOT EXISTS `departamentos` (
  `NUM_DEPARTAMENTO` int(11) NOT NULL,
  `NOMBRE` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `LOCALIDAD` varchar(50) COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`NUM_DEPARTAMENTO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`NUM_DEPARTAMENTO`, `NOMBRE`, `LOCALIDAD`) VALUES
(10, 'CONTABILIDAD', 'NEW YORK'),
(20, 'INVESTIGACIÓN', 'DALLAS'),
(30, 'VENTAS', 'CHICAGO'),
(40, 'OPERACIONES', 'BOSTON'),
(50, 'VENTAS', 'DALLAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE IF NOT EXISTS `empleados` (
  `NUM_EMPLEADO` int(11) NOT NULL,
  `NOMBRE_EMPLEADO` varchar(35) COLLATE utf8mb4_spanish_ci NOT NULL,
  `PUESTO` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL,
  `NUM_JEFE` int(11) DEFAULT NULL,
  `FECHA_ALTA` date NOT NULL,
  `SALARIO` decimal(10,3) NOT NULL,
  `COMISION` decimal(10,3) DEFAULT NULL,
  `NUM_DEPARTAMENTO` int(11) DEFAULT NULL,
  PRIMARY KEY (`NUM_EMPLEADO`),
  KEY `NUM_DEPARTAMENTO` (`NUM_DEPARTAMENTO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`NUM_EMPLEADO`, `NOMBRE_EMPLEADO`, `PUESTO`, `NUM_JEFE`, `FECHA_ALTA`, `SALARIO`, `COMISION`, `NUM_DEPARTAMENTO`) VALUES
(7369, 'SMITH', 'ADMINISTRATIVO', 7902, '1980-12-17', '800.000', NULL, 20),
(7499, 'ALLEN', 'COMERCIAL', 7698, '1981-12-20', '1600.000', '300.000', 30),
(7521, 'WARD', 'COMERCIAL', 7698, '1981-12-22', '1250.000', '500.000', 30),
(7566, 'JONES', 'MANAGER', 7839, '1981-04-02', '2975.000', NULL, 20),
(7654, 'MARTIN', 'COMERCIAL', 7698, '1981-09-28', '1250.000', '1400.000', 30),
(7698, 'BLAKE', 'MANAGER', 7839, '1981-05-01', '2850.000', NULL, 30),
(7782, 'CLARK', 'MANAGER', 7839, '1981-06-09', '2450.000', NULL, 10),
(7788, 'SCOTT', 'ANALISTA', 7566, '1982-12-09', '3000.000', NULL, 20),
(7839, 'KING', 'PRESIDENTE', NULL, '1981-11-17', '5000.000', NULL, 10),
(7844, 'TURNER', 'COMERCIAL', 7698, '1981-09-08', '1500.000', '0.000', 30),
(7876, 'ADAMS', 'ADMINISTRATIVO', 7788, '1983-01-12', '1100.000', NULL, 20),
(7900, 'JAMES', 'ADMINISTRATIVO', 7698, '1981-12-03', '950.000', NULL, 30),
(7902, 'FORD', 'ANALISTA', 7566, '1981-12-03', '3000.000', NULL, 20),
(7934, 'MILLER', 'ADMINISTRATIVO', 7782, '1982-01-23', '1300.000', NULL, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `EMAIL` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `CLAVE` varchar(32) COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'La clave es el nombre en minúsculas y está encriptada con el algorimo MD5',
  `NOMBRE` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `APELLIDO1` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `APELLIDO2` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`EMAIL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`EMAIL`, `CLAVE`, `NOMBRE`, `APELLIDO1`, `APELLIDO2`) VALUES
('juan@gmail.com', 'a94652aa97c7211ba8954dd15a3cf838', 'Juan', 'Sánchez', 'López'),
('sonia@outlook.com', 'd31cb1e2b7902e8e9b4d1793e94c38a0', 'Sonia', 'Miguéns', 'Jimenez');

--
-- Estructura de tabla para la tabla `datos`
--
CREATE TABLE IF NOT EXISTS `datos` (
  `entero` int(11) NOT NULL,
  `texto` varchar(40) NOT NULL,
  `date` date NOT NULL,
  `datetime` datetime NOT NULL,
  `decimal` decimal(10,3) NOT NULL,
  `booleano` tinyint(1) NOT NULL,
  PRIMARY KEY (`entero`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `datos`
--

INSERT INTO `datos` (`entero`, `texto`, `date`, `datetime`, `decimal`, `booleano`) VALUES
(10, 'Cañón', '2017-03-28', '2017-03-28 08:32:35', '100.750', 1);


--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_2` FOREIGN KEY (`NUM_DEPARTAMENTO`) REFERENCES `departamentos` (`NUM_DEPARTAMENTO`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
