-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 29-Out-2026 às 21:53
-- Versão do servidor: 8.4.7
-- versão do PHP: 8.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dados: `mydb`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `bilhete`
--

DROP TABLE IF EXISTS `bilhete`;
CREATE TABLE IF NOT EXISTS `bilhete` (
  `id_bilhete` int NOT NULL AUTO_INCREMENT,
  `id_utilizador` int NOT NULL,
  `id_museu` int NOT NULL,
  `id_desconto` int DEFAULT NULL,
  `data_visita` date NOT NULL,
  `hora_visita` time NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `estado` varchar(30) NOT NULL DEFAULT 'confirmado',
  PRIMARY KEY (`id_bilhete`),
  KEY `fk_bilhete_utilizador` (`id_utilizador`),
  KEY `fk_bilhete_museu` (`id_museu`),
  KEY `fk_bilhete_desconto` (`id_desconto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `colaborador`
--

DROP TABLE IF EXISTS `colaborador`;
CREATE TABLE IF NOT EXISTS `colaborador` (
  `id_colaborador` int NOT NULL AUTO_INCREMENT,
  `id_museu` int DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(30) NOT NULL,
  PRIMARY KEY (`id_colaborador`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_colaborador_museu` (`id_museu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `desconto`
--

DROP TABLE IF EXISTS `desconto`;
CREATE TABLE IF NOT EXISTS `desconto` (
  `id_desconto` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(150) NOT NULL,
  `percentagem` decimal(5,2) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  PRIMARY KEY (`id_desconto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomenda`
--

DROP TABLE IF EXISTS `encomenda`;
CREATE TABLE IF NOT EXISTS `encomenda` (
  `id_encomenda` int NOT NULL AUTO_INCREMENT,
  `id_utilizador` int NOT NULL,
  `data_encomenda` date NOT NULL,
  `estado` varchar(30) NOT NULL DEFAULT 'pendente',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id_encomenda`),
  KEY `fk_encomenda_utilizador` (`id_utilizador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomenda_lembranca`
--

DROP TABLE IF EXISTS `encomenda_lembranca`;
CREATE TABLE IF NOT EXISTS `encomenda_lembranca` (
  `id_encomenda` int NOT NULL,
  `id_lembranca` int NOT NULL,
  `quantidade` int NOT NULL DEFAULT '1',
  `preco_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_encomenda`,`id_lembranca`),
  KEY `fk_encline_lembranca` (`id_lembranca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lembranca`
--

DROP TABLE IF EXISTS `lembranca`;
CREATE TABLE IF NOT EXISTS `lembranca` (
  `id_lembranca` int NOT NULL AUTO_INCREMENT,
  `id_museu` int NOT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text,
  `preco` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_lembranca`),
  KEY `fk_lembranca_museu` (`id_museu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `localizacao`
--

DROP TABLE IF EXISTS `localizacao`;
CREATE TABLE IF NOT EXISTS `localizacao` (
  `id_localizacao` int NOT NULL AUTO_INCREMENT,
  `id_museu` int NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  PRIMARY KEY (`id_localizacao`),
  UNIQUE KEY `id_museu` (`id_museu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lotacao_hora`
--

DROP TABLE IF EXISTS `lotacao_hora`;
CREATE TABLE IF NOT EXISTS `lotacao_hora` (
  `id_lotacao` int NOT NULL AUTO_INCREMENT,
  `id_museu` int NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `lotacao_maxima` int NOT NULL,
  `lugares_ocupados` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_lotacao`),
  UNIQUE KEY `uq_lotacao_museu_data_hora` (`id_museu`,`data`,`hora`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `museu`
--

DROP TABLE IF EXISTS `museu`;
CREATE TABLE IF NOT EXISTS `museu` (
  `id_museu` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `tipo` varchar(20) NOT NULL DEFAULT 'museu',
  `descricao` text,
  `morada` varchar(200) DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL DEFAULT '0.00',
  `horario_abertura` time DEFAULT NULL,
  `horario_fecho` time DEFAULT NULL,
  PRIMARY KEY (`id_museu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `obra`
--

DROP TABLE IF EXISTS `obra`;
CREATE TABLE IF NOT EXISTS `obra` (
  `id_obra` int NOT NULL AUTO_INCREMENT,
  `id_museu` int NOT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text,
  `ano` int DEFAULT NULL,
  PRIMARY KEY (`id_obra`),
  KEY `fk_obra_museu` (`id_museu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `turno`
--

DROP TABLE IF EXISTS `turno`;
CREATE TABLE IF NOT EXISTS `turno` (
  `id_turno` int NOT NULL AUTO_INCREMENT,
  `id_colaborador` int NOT NULL,
  `data` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL,
  PRIMARY KEY (`id_turno`),
  KEY `fk_turno_colaborador` (`id_colaborador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizador`
--

DROP TABLE IF EXISTS `utilizador`;
CREATE TABLE IF NOT EXISTS `utilizador` (
  `id_utilizador` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `data_registo` date NOT NULL,
  `numero_visitas` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_utilizador`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `verificacao_diaria`
--

DROP TABLE IF EXISTS `verificacao_diaria`;
CREATE TABLE IF NOT EXISTS `verificacao_diaria` (
  `id_verificacao` int NOT NULL AUTO_INCREMENT,
  `id_colaborador` int NOT NULL,
  `id_museu` int NOT NULL,
  `data` date NOT NULL,
  `descricao` text NOT NULL,
  `estado` varchar(30) NOT NULL DEFAULT 'ok',
  PRIMARY KEY (`id_verificacao`),
  KEY `fk_verificacao_colaborador` (`id_colaborador`),
  KEY `fk_verificacao_museu` (`id_museu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `visita`
--

DROP TABLE IF EXISTS `visita`;
CREATE TABLE IF NOT EXISTS `visita` (
  `id_visita` int NOT NULL AUTO_INCREMENT,
  `id_utilizador` int NOT NULL,
  `id_museu` int NOT NULL,
  `id_bilhete` int DEFAULT NULL,
  `data_visita` date NOT NULL,
  PRIMARY KEY (`id_visita`),
  KEY `fk_visita_utilizador` (`id_utilizador`),
  KEY `fk_visita_museu` (`id_museu`),
  KEY `fk_visita_bilhete` (`id_bilhete`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `bilhete`
--
ALTER TABLE `bilhete`
  ADD CONSTRAINT `fk_bilhete_desconto` FOREIGN KEY (`id_desconto`) REFERENCES `desconto` (`id_desconto`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_bilhete_museu` FOREIGN KEY (`id_museu`) REFERENCES `museu` (`id_museu`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bilhete_utilizador` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizador` (`id_utilizador`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `colaborador`
--
ALTER TABLE `colaborador`
  ADD CONSTRAINT `fk_colaborador_museu` FOREIGN KEY (`id_museu`) REFERENCES `museu` (`id_museu`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `encomenda`
--
ALTER TABLE `encomenda`
  ADD CONSTRAINT `fk_encomenda_utilizador` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizador` (`id_utilizador`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `encomenda_lembranca`
--
ALTER TABLE `encomenda_lembranca`
  ADD CONSTRAINT `fk_encline_encomenda` FOREIGN KEY (`id_encomenda`) REFERENCES `encomenda` (`id_encomenda`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_encline_lembranca` FOREIGN KEY (`id_lembranca`) REFERENCES `lembranca` (`id_lembranca`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `lembranca`
--
ALTER TABLE `lembranca`
  ADD CONSTRAINT `fk_lembranca_museu` FOREIGN KEY (`id_museu`) REFERENCES `museu` (`id_museu`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `localizacao`
--
ALTER TABLE `localizacao`
  ADD CONSTRAINT `fk_localizacao_museu` FOREIGN KEY (`id_museu`) REFERENCES `museu` (`id_museu`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `lotacao_hora`
--
ALTER TABLE `lotacao_hora`
  ADD CONSTRAINT `fk_lotacao_museu` FOREIGN KEY (`id_museu`) REFERENCES `museu` (`id_museu`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `obra`
--
ALTER TABLE `obra`
  ADD CONSTRAINT `fk_obra_museu` FOREIGN KEY (`id_museu`) REFERENCES `museu` (`id_museu`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `turno`
--
ALTER TABLE `turno`
  ADD CONSTRAINT `fk_turno_colaborador` FOREIGN KEY (`id_colaborador`) REFERENCES `colaborador` (`id_colaborador`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `verificacao_diaria`
--
ALTER TABLE `verificacao_diaria`
  ADD CONSTRAINT `fk_verificacao_colaborador` FOREIGN KEY (`id_colaborador`) REFERENCES `colaborador` (`id_colaborador`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_verificacao_museu` FOREIGN KEY (`id_museu`) REFERENCES `museu` (`id_museu`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `visita`
--
ALTER TABLE `visita`
  ADD CONSTRAINT `fk_visita_bilhete` FOREIGN KEY (`id_bilhete`) REFERENCES `bilhete` (`id_bilhete`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_visita_museu` FOREIGN KEY (`id_museu`) REFERENCES `museu` (`id_museu`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_visita_utilizador` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizador` (`id_utilizador`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
