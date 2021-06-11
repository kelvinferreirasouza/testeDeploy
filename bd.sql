-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02-Jun-2021 às 02:24
-- Versão do servidor: 10.4.13-MariaDB
-- versão do PHP: 7.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ops_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `configuracao_sistema`
--

CREATE TABLE `configuracao_sistema` (
  `id` int(11) NOT NULL,
  `titulo` text CHARACTER SET latin1 NOT NULL,
  `path_image` text CHARACTER SET latin1 NOT NULL,
  `rodape` text CHARACTER SET latin1 NOT NULL,
  `id_empresa` int(11) NOT NULL DEFAULT 1,
  `script_tawkto` text CHARACTER SET latin1 DEFAULT NULL,
  `dados_bancarios` text CHARACTER SET latin1 NOT NULL,
  `termo_uso_plataforma` text CHARACTER SET latin1 NOT NULL,
  `modo_manutencao` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `configuracao_sistema`
--

INSERT INTO `configuracao_sistema` (`id`, `titulo`, `path_image`, `rodape`, `id_empresa`, `script_tawkto`, `dados_bancarios`, `termo_uso_plataforma`, `modo_manutencao`) VALUES
(1, 'Ops | Administrativo', 'img', 'Ops', 1, ' ', ' ', ' ', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `rota` varchar(100) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT NULL,
  `id_sub_pagina` int(11) DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL,
  `icone` varchar(50) NOT NULL,
  `acesso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `menu`
--

INSERT INTO `menu` (`id_menu`, `nome`, `rota`, `ativo`, `id_sub_pagina`, `ordem`, `icone`, `acesso`) VALUES
(1, 'Configurações', 'configuracoes', 1, 0, 2, 'fa-cogs', 10),
(2, 'Usuários', 'configuracoes/usuarios', 1, 1, 1, 'fa-users', 10),
(3, 'Geral', 'configuracoes/geral', 1, 1, 2, 'fa-cog', 10),
(4, 'Home', 'home', 1, 0, 1, 'fa-home', 30);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `senha` varchar(250) NOT NULL,
  `nivel` tinyint(4) NOT NULL DEFAULT 1,
  `id_perfil` int(11) NOT NULL DEFAULT 1,
  `foto` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `cep` varchar(20) DEFAULT NULL,
  `uf_estado` varchar(2) DEFAULT NULL,
  `id_cidade` int(11) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `senha`, `nivel`, `id_perfil`, `foto`, `cep`, `uf_estado`, `id_cidade`, `endereco`, `bairro`, `rg`, `cpf`, `telefone`, `celular`, `ativo`) VALUES
(1, 'KELVIN SOUZA', 'KELVIN@YDEALTECNOLOGIA.COM.BR', '435c4bc93fef05063084c2af04b898a4', 10, 1, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, 1),
(2, 'ADMIN', 'DEV@YDEALTECNOLOGIA.COM.BR', '81dc9bdb52d04dc20036dbd8313ed055', 10, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_perfil`
--

CREATE TABLE `usuario_perfil` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `nivel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario_perfil`
--

INSERT INTO `usuario_perfil` (`id`, `nome`, `nivel`) VALUES
(1, 'ADMINISTRADOR', '10');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `configuracao_sistema`
--
ALTER TABLE `configuracao_sistema`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices para tabela `usuario_perfil`
--
ALTER TABLE `usuario_perfil`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `configuracao_sistema`
--
ALTER TABLE `configuracao_sistema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuario_perfil`
--
ALTER TABLE `usuario_perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
