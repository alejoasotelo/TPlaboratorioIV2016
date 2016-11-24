-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-11-2016 a las 04:55:56
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `alejo_lab4`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipo`, `username`, `password`, `email`, `nombre`, `apellido`) VALUES
(1, 'administrador', 'administrador', '91f5167c34c400758115c2a6826ec2e3', 'administrador@administrador.com', 'administrador', 'administrador'),
(2, 'encargado', 'encargado', 'cb0d0277094bffbf04eceb3a6091cfaa', 'encargado@encargado.com', 'encargado', 'encargado'),
(3, 'cliente', 'cliente', '4983a0ab83ed86e0e7213c8783940193', 'cliente@cliente.com', 'cliente', 'cliente'),
(4, 'empleado', 'empleado', '088ef99bff55c67dc863f83980a66a9b', 'empleado@empleado.com', 'empleado', 'empleado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);