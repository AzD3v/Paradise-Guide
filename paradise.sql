-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 18, 2018 at 10:46 PM
-- Server version: 5.7.24-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paradise`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `idAdmin` int(11) NOT NULL,
  `usernameAdmin` varchar(50) NOT NULL,
  `passwordAdmin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`idAdmin`, `usernameAdmin`, `passwordAdmin`) VALUES
(1, 'vendedor1', 'admin123'),
(2, 'vendedor2', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `atividades`
--

CREATE TABLE `atividades` (
  `idAtividade` int(11) NOT NULL,
  `idAdmin` int(11) NOT NULL,
  `nomeAtividade` varchar(50) CHARACTER SET utf8 NOT NULL,
  `descricaoAtividade` mediumtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `zonaAtividade` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `duracaoAtividade` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `precoAtividade` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `imagemAtividade` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estadoAtividade` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Por realizar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `atividades`
--

INSERT INTO `atividades` (`idAtividade`, `idAdmin`, `nomeAtividade`, `descricaoAtividade`, `zonaAtividade`, `duracaoAtividade`, `precoAtividade`, `imagemAtividade`, `estadoAtividade`) VALUES
(34, 1, 'Miradouro do Pico do Ferro', 'Explore 7 Cidades e Vista do Rei, os mais famosos mirantes de Sete Cidades, Portugal. Passe meio dia admirando a cratera, a costa sul da ilha e os famosos lagos azul e verde.', 'Sete Cidades', 'Aprox 4h', '25', 'pico_ferro.jpg', '0'),
(35, 1, 'Pico da Vara', 'Visita obrigatÃ³ria pela beleza da sua paisagem e pelo sÃ­mbolo emblemÃ¡tico da Ilha que Ã©.\r\nOferece tambÃ©m uma parte da histÃ³ria triste da aviaÃ§Ã£o local pois no seu percurso podemos estar no ponto onde duas aeronaves caÃ­ram nÃ£o deixando infelizmente qualquer sobrevivente.\r\nSendo sempre ascendente atÃ© ao pico (cerca de 3,5 km) e estando classificado de difÃ­cil.\r\nAconselha-se uma visita num dia limpo pois de outra forma nÃ£o poderÃ¡ ser observada a sua exuberante paisagem.', 'Nordeste', '2 a 3h', 'Atividade sem custos', 'pico_da_vara.jpg', '1'),
(57, 1, 'ExcursÃ£o de dia inteiro entre baleias e vulcÃµes ', 'Mergulhe na beleza natural de AÃ§ores nesta excursÃ£o de dia inteiro com uma excursÃ£o para observar baleias e vulcÃµes. Observe vÃ¡rias espÃ©cies de baleias em seu habitat natural e procure por golfinhos saltando na Ã¡gua. Viaje de barco pelo litoral rumo a Lagoa do Fogo e Caldeira Velha, desfrutando de um delicioso almoÃ§o ao longo do caminho. Visite um vulcÃ£o ativo e aprenda como os cientistas estÃ£o utilizando sua energia para produzir eletricidade. NÃ£o perca esta oportunidade de conhecer a verdadeira beleza de AÃ§ores.\r\n\r\nSua aventura na vista de baleias e vulcÃµes de AÃ§ores comeÃ§a ao encontrar o simpÃ¡tico guia local. Depois de ouvir breves instruÃ§Ãµes, parta rumo a AÃ§ores pelo litoral atÃ© a marina de Ponta Delgada. Ao longo do caminho, procure por uma grande variedade de vida selvagem, incluindo baleias-cachalotes, baleias-azuis, baleias-jubartes, baleias-francas-pigmeias, baleias-bicudas, golfinhos, tartarugas, peixes-voadores e aves oceÃ¢nicas.', 'Marina de Ponta Delgada', 'dia inteiro', '100', 'dia_inteiro.jpg', '0'),
(60, 2, 'ObservaÃ§Ã£o de baleias nos AÃ§ores - dia inteiro', 'ApÃ³s a excursÃ£o de observaÃ§Ã£o de baleias de 3 horas, faremos uma parada em Vila Franca do Campo para almoÃ§ar em um restaurante local, incluso no preÃ§o. Em seguida, embarcamos em um tradicional barco de pesca e seguiremos para a ilha Vila Franca do Campo, uma cratera vulcÃ¢nica fora da costa que abriga uma lagoa natural, onde Ã© possÃ­vel tomar um banho.', 'Vila Franca do Campo', 'dia inteiro', '80', 'whale_franca.jpg', '0'),
(61, 2, 'Passeio de SÃ£o Miguel Azores para Faial da Terra ', 'Essa Ã© realmente uma caminhada em que vocÃª pode &quot;cheirar&quot; todo o verde ao seu redor! Ao chegar Ã  cachoeira Salto do Prego, teremos a oportunidade para um mergulho, antes do nosso almoÃ§o (piquenique). No caminho de volta, faremos uma trilha diferente, mas com as mesmas caracterÃ­sticas.', 'Ponta Delgada', '3-4 horas', '50', 'faial_da_terra.jpg', '0');

-- --------------------------------------------------------

--
-- Table structure for table `comentarios`
--

CREATE TABLE `comentarios` (
  `idComentario` int(11) NOT NULL,
  `idAtividade` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `tituloComentario` varchar(100) CHARACTER SET utf8 NOT NULL,
  `textoComentario` text CHARACTER SET utf8 NOT NULL,
  `autorComentario` varchar(25) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comentarios`
--

INSERT INTO `comentarios` (`idComentario`, `idAtividade`, `idUser`, `tituloComentario`, `textoComentario`, `autorComentario`) VALUES
(9, 35, 94, 'Atividade muito bem organizada', 'A organizaÃ§Ã£o da atividade foi incrÃ­vel! Espero que a mesma equipa volte a organizar uma atividade deste gÃ©nero :)', 'Henrique');

-- --------------------------------------------------------

--
-- Table structure for table `reservas`
--

CREATE TABLE `reservas` (
  `idReserva` bigint(20) NOT NULL,
  `idAtividade` int(11) NOT NULL,
  `idAdmin` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `cartaoCredito` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiracaoCartao` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomeCartao` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estadoReserva` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Reservada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservas`
--

INSERT INTO `reservas` (`idReserva`, `idAtividade`, `idAdmin`, `idUser`, `cartaoCredito`, `expiracaoCartao`, `nomeCartao`, `estadoReserva`) VALUES
(786, 35, 1, 93, '+4URZH4pVz9aSjhgBsG6YA==', '06/10', 'Paulo Cunha', 'Realizada'),
(787, 57, 1, 93, '9GkLHLQB7XD/uGTUS59QUw==', '06/20', 'Paulo Cunha', 'Cancelada'),
(792, 34, 1, 96, 'VVn0NrQ4G1W+m9uud3ozTw==', '05/20', 'JÃºlio Furtado', 'Marcada'),
(793, 35, 1, 96, 'hSbQ4JTPhT9bM735Jka1tA==', '05/10', 'JÃºlio Furtado', 'Marcada');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUser`, `username`, `email`, `password`) VALUES
(93, 'paulo', 'paulo@paulo.com', '$2y$12$3VuM9K.tSY6LXPI.j5loRuLfP3lm8WfoJJ32L5CDzYnPYWbTMoOzi'),
(94, 'henrique', 'henrique@henrique.com', '$2y$12$9SEloquKovGFIKIxHkkofORBQVOhaCx6CY1DUBb7dAPkTETNaqwpm'),
(96, 'julio', 'julio@julio.com', '$2y$12$gVUs.AyyDd5lUJGheuCT4Obw2ej/kw7OqQDxvmGO7Lk/XgK5xH9Re');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indexes for table `atividades`
--
ALTER TABLE `atividades`
  ADD PRIMARY KEY (`idAtividade`);

--
-- Indexes for table `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`idComentario`);

--
-- Indexes for table `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`idReserva`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `atividades`
--
ALTER TABLE `atividades`
  MODIFY `idAtividade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `idComentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `reservas`
--
ALTER TABLE `reservas`
  MODIFY `idReserva` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=794;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
