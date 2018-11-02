-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 01, 2018 at 12:21 AM
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
  `id_username_admin` int(11) NOT NULL,
  `username_admin` varchar(50) NOT NULL,
  `password_admin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `atividades`
--

CREATE TABLE `atividades` (
  `idAtividade` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `nomeAtividade` varchar(50) NOT NULL,
  `descricaoAtividade` varchar(500) NOT NULL,
  `zonaAtividade` varchar(50) NOT NULL,
  `imagemAtividade` text NOT NULL,
  `precoAtividade` int(11) NOT NULL,
  `duracaoAtividade` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `atividades`
--

INSERT INTO `atividades` (`idAtividade`, `idCategoria`, `nomeAtividade`, `descricaoAtividade`, `zonaAtividade`, `imagemAtividade`, `precoAtividade`, `duracaoAtividade`) VALUES
(1, 1, 'Azores Fishing', 'Atividades de pesca do mais alto nível na ilha de São Miguel. Com certeza não encontrará melhor.', 'Vila Franca do Campo', '', 0, ''),
(2, 2, 'Miradouro do Pico do Ferro', 'Excursão pelo leste de São Miguel.\r\n Duração sugerida: < 1 hora.', 'Furnas', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `comentarios`
--

CREATE TABLE `comentarios` (
  `comentario_id` int(11) NOT NULL,
  `comentario_titulo` varchar(50) NOT NULL,
  `comentario_texto` text NOT NULL,
  `comentario_author` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` bigint(20) NOT NULL,
  `id_atividade` int(11) NOT NULL,
  `id_utilizador` int(11) NOT NULL,
  `nr_cartao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_atividades`
--

CREATE TABLE `tipo_atividades` (
  `id` int(11) NOT NULL,
  `categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipo_atividades`
--

INSERT INTO `tipo_atividades` (`id`, `categoria`) VALUES
(1, 'whale watching');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`) VALUES
(88, 'paulo', 'paulo@paulo.com', '12345678'),
(89, 'henrique', 'henrique@henrique.com', '$2y$12$Zxm80C9V8.HewF6.CuSs/.NAHAhJdZMXzrcddUYdp7N.IKXgqT5um'),
(90, 'cunha', 'cunha@cunha.com', '$2y$12$Fz0Oe8CKVFnrfCNVz.b2ouyTaYSv7iy6O1CXQk25RWmlsAgdmg2RS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id_username_admin`);

--
-- Indexes for table `atividades`
--
ALTER TABLE `atividades`
  ADD PRIMARY KEY (`idAtividade`);

--
-- Indexes for table `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`comentario_id`);

--
-- Indexes for table `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`);

--
-- Indexes for table `tipo_atividades`
--
ALTER TABLE `tipo_atividades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id_username_admin` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `atividades`
--
ALTER TABLE `atividades`
  MODIFY `idAtividade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `comentario_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
