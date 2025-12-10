CREATE DATABASE IF NOT EXISTS barberkush
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE barberkush;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `criado_em` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `barbeiros` (
  `id_barbeiro` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `apelido` varchar(80) DEFAULT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `especialidades` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `criado_em` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_barbeiro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `servicos` (
  `id_servico` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `duracao_min` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `criado_em` datetime DEFAULT current_timestamp(),
  `duracao` int(11) NOT NULL DEFAULT 10,
  PRIMARY KEY (`id_servico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `agendamentos` (
  `id_agendamento` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_barbeiro` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `data_inicio` datetime NOT NULL,
  `data_fim` datetime NOT NULL,
  `status` enum('pendente','confirmado','cancelado','concluido') DEFAULT 'pendente',
  `observacoes` text DEFAULT NULL,
  `criado_em` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_agendamento`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_servico` (`id_servico`),
  KEY `idx_conflict` (`id_barbeiro`,`data_inicio`,`data_fim`),
  CONSTRAINT `agendamentos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON UPDATE CASCADE,
  CONSTRAINT `agendamentos_ibfk_2` FOREIGN KEY (`id_barbeiro`) REFERENCES `barbeiros` (`id_barbeiro`) ON UPDATE CASCADE,
  CONSTRAINT `agendamentos_ibfk_3` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id_servico`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;
