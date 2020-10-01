-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Set-2020 às 22:44
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `servers`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_internal_servers`
--

CREATE TABLE `tb_internal_servers` (
  `id_server` int(4) NOT NULL,
  `id_creator` int(4) NOT NULL,
  `hostname` varchar(50) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `status_server` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_internal_servers`
--

INSERT INTO `tb_internal_servers` (`id_server`, `id_creator`, `hostname`, `ip_address`, `status_server`) VALUES
(1, 1, 'Google DNS', '8.8.8.8', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_name_port`
--

CREATE TABLE `tb_name_port` (
  `id_name_port` int(2) NOT NULL,
  `nome_port` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_name_port`
--

INSERT INTO `tb_name_port` (`id_name_port`, `nome_port`) VALUES
(1, 'HTTP'),
(2, 'HTTPS'),
(3, 'FTP'),
(4, 'SSH'),
(5, 'RDP'),
(6, 'MySQL'),
(7, 'OracleDB'),
(8, 'PostgreSQL'),
(9, 'Firebird'),
(10, 'Kerberos'),
(11, 'TomCat'),
(12, 'Outros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_ports`
--

CREATE TABLE `tb_ports` (
  `id_port` int(4) NOT NULL,
  `id_server` int(4) NOT NULL,
  `port_name` varchar(10) NOT NULL,
  `port` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_ports`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_reason_fail`
--

CREATE TABLE `tb_reason_fail` (
  `id_reason` int(4) NOT NULL,
  `id_fail` int(4) NOT NULL,
  `reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_server_fails`
--

CREATE TABLE `tb_server_fails` (
  `id_fail` int(4) NOT NULL,
  `id_server` int(4) NOT NULL,
  `data_fail` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_return` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_users`
--

CREATE TABLE `tb_users` (
  `id_user` int(4) NOT NULL,
  `nome_user` varchar(100) NOT NULL,
  `login_user` varchar(30) NOT NULL,
  `psw_user` varchar(50) NOT NULL,
  `data_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_user` tinyint(1) NOT NULL,
  `data_inactive` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_users`
--

INSERT INTO `tb_users` (`id_user`, `nome_user`, `login_user`, `psw_user`, `data_creation`, `status_user`, `data_inactive`) VALUES
(1, 'Your Name', 'your.name', 'teste', '2020-01-01 03:00:00', 1, '0000-00-00 00:00:00');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_internal_servers`
--
ALTER TABLE `tb_internal_servers`
  ADD PRIMARY KEY (`id_server`),
  ADD KEY `id_creator` (`id_creator`);

--
-- Índices para tabela `tb_name_port`
--
ALTER TABLE `tb_name_port`
  ADD PRIMARY KEY (`id_name_port`);

--
-- Índices para tabela `tb_ports`
--
ALTER TABLE `tb_ports`
  ADD PRIMARY KEY (`id_port`),
  ADD KEY `id_server` (`id_server`);

--
-- Índices para tabela `tb_reason_fail`
--
ALTER TABLE `tb_reason_fail`
  ADD PRIMARY KEY (`id_reason`),
  ADD KEY `id_fail` (`id_fail`);

--
-- Índices para tabela `tb_server_fails`
--
ALTER TABLE `tb_server_fails`
  ADD PRIMARY KEY (`id_fail`),
  ADD KEY `id_server` (`id_server`);

--
-- Índices para tabela `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_internal_servers`
--
ALTER TABLE `tb_internal_servers`
  MODIFY `id_server` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_name_port`
--
ALTER TABLE `tb_name_port`
  MODIFY `id_name_port` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_ports`
--
ALTER TABLE `tb_ports`
  MODIFY `id_port` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_reason_fail`
--
ALTER TABLE `tb_reason_fail`
  MODIFY `id_reason` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_server_fails`
--
ALTER TABLE `tb_server_fails`
  MODIFY `id_fail` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id_user` int(4) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_internal_servers`
--
ALTER TABLE `tb_internal_servers`
  ADD CONSTRAINT `tb_internal_servers_ibfk_1` FOREIGN KEY (`id_creator`) REFERENCES `tb_users` (`id_user`);

--
-- Limitadores para a tabela `tb_ports`
--
ALTER TABLE `tb_ports`
  ADD CONSTRAINT `tb_ports_ibfk_1` FOREIGN KEY (`id_server`) REFERENCES `tb_internal_servers` (`id_server`);

--
-- Limitadores para a tabela `tb_reason_fail`
--
ALTER TABLE `tb_reason_fail`
  ADD CONSTRAINT `tb_reason_fail_ibfk_1` FOREIGN KEY (`id_fail`) REFERENCES `tb_server_fails` (`id_fail`);

--
-- Limitadores para a tabela `tb_server_fails`
--
ALTER TABLE `tb_server_fails`
  ADD CONSTRAINT `tb_server_fails_ibfk_1` FOREIGN KEY (`id_server`) REFERENCES `tb_internal_servers` (`id_server`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
