-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 07, 2016 at 04:15 PM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `adler`
--

-- --------------------------------------------------------

--
-- Table structure for table `avaliacao`
--

CREATE TABLE IF NOT EXISTS `avaliacao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codProjeto` int(11) NOT NULL,
  `codAvaliador` int(11) NOT NULL,
  `data` date NOT NULL,
  `nota` float NOT NULL,
  `sugestao` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `avaliacao`
--

INSERT INTO `avaliacao` (`id`, `codProjeto`, `codAvaliador`, `data`, `nota`, `sugestao`) VALUES
(12, 9, 26, '2016-11-07', 7.89, NULL),
(13, 11, 26, '2016-11-07', 8.57, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `avaliadordeprojetos`
--

CREATE TABLE IF NOT EXISTS `avaliadordeprojetos` (
  `idusuario` int(11) NOT NULL,
  `categoria` set('pesquisa','competicaotecnologica','inovacaoensino','manutencaoreforma','pequenasobras') NOT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `categoria` (`categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `avaliadordeprojetos`
--

INSERT INTO `avaliadordeprojetos` (`idusuario`, `categoria`) VALUES
(26, 'pesquisa'),
(25, 'inovacaoensino');

-- --------------------------------------------------------

--
-- Table structure for table `cotafinanciamento`
--

CREATE TABLE IF NOT EXISTS `cotafinanciamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) DEFAULT NULL,
  `idprojeto` int(11) DEFAULT NULL,
  `valortotal` double NOT NULL,
  `valorcota` double NOT NULL,
  `datarepasse` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idusuario` (`idusuario`),
  KEY `idprojeto` (`idprojeto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `criteriodeavaliacao`
--

CREATE TABLE IF NOT EXISTS `criteriodeavaliacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` set('pesquisa','competicaotecnologica','inovacaoensino','manutencaoreforma','pequenasobras') NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `peso` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `criteriodeavaliacao`
--

INSERT INTO `criteriodeavaliacao` (`id`, `categoria`, `descricao`, `status`, `peso`) VALUES
(7, 'competicaotecnologica', 'Impacto', 1, 8),
(10, 'pequenasobras', 'Descricao', 1, 4),
(11, 'pesquisa', 'Impacto Social', 1, 6),
(13, 'pesquisa', 'InovaÃ§Ã£o', 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `edital`
--

CREATE TABLE IF NOT EXISTS `edital` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) DEFAULT NULL,
  `nome` varchar(30) NOT NULL,
  `datatermino` date NOT NULL,
  `valordisponiel` double NOT NULL,
  `valorminimo` double NOT NULL,
  `valormaximo` double NOT NULL,
  `patharquivo` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idusuario` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `financiar`
--

CREATE TABLE IF NOT EXISTS `financiar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) DEFAULT NULL,
  `idprojeto` int(11) DEFAULT NULL,
  `tipo` enum('modulo','integral') NOT NULL,
  `valor` double NOT NULL,
  `formapagamento` set('boletobancario','cartaocredito','cartaodebito','cheque','transferenciabancaria') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idusuario` (`idusuario`),
  KEY `idprojeto` (`idprojeto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `itemavaliacao`
--

CREATE TABLE IF NOT EXISTS `itemavaliacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idAvaliacao` int(11) NOT NULL,
  `idCriterio` int(11) NOT NULL,
  `nota` float NOT NULL,
  `peso` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `itemavaliacao`
--

INSERT INTO `itemavaliacao` (`id`, `idAvaliacao`, `idCriterio`, `nota`, `peso`) VALUES
(6, 12, 11, 6, 6),
(7, 12, 13, 9.3, 8),
(8, 13, 11, 8, 6),
(9, 13, 13, 9, 8);

-- --------------------------------------------------------

--
-- Table structure for table `projeto`
--

CREATE TABLE IF NOT EXISTS `projeto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` char(6) DEFAULT NULL,
  `nome` varchar(30) NOT NULL,
  `categoria` set('pesquisa','competicaotecnologica','inovacaoensino','manutencaoreforma','pequenasobras') NOT NULL,
  `status` set('candidato','aprovado','reprovado','finalizado') DEFAULT 'candidato',
  `duracaoprevista` varchar(10) NOT NULL,
  `valor` double NOT NULL,
  `prazomaximo` date DEFAULT NULL,
  `valorminimo` double DEFAULT NULL,
  `valormaximo` double DEFAULT NULL,
  `imagem` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `projeto`
--

INSERT INTO `projeto` (`id`, `codigo`, `nome`, `categoria`, `status`, `duracaoprevista`, `valor`, `prazomaximo`, `valorminimo`, `valormaximo`, `imagem`) VALUES
(9, 'prj100', 'Black Bee', 'pesquisa', 'aprovado', '20', 20000, NULL, NULL, NULL, NULL),
(10, 'prj909', 'Reforma IMC', 'manutencaoreforma', 'candidato', '60', 3500000, NULL, NULL, NULL, NULL),
(11, 'pr3000', 'Uairrior', 'pesquisa', 'aprovado', '30', 12000, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recompensa`
--

CREATE TABLE IF NOT EXISTS `recompensa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprojeto` int(11) NOT NULL DEFAULT '0',
  `descricao` varchar(200) NOT NULL,
  `valorminimo` double NOT NULL,
  `valormaximo` double DEFAULT NULL,
  `limite` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`idprojeto`),
  KEY `idprojeto` (`idprojeto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `repassefinanceiro`
--

CREATE TABLE IF NOT EXISTS `repassefinanceiro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprojeto` int(11) DEFAULT NULL,
  `data` date NOT NULL,
  `valor` double NOT NULL,
  `status` enum('quitado','naoquitado') DEFAULT 'naoquitado',
  PRIMARY KEY (`id`),
  KEY `idprojeto` (`idprojeto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(30) DEFAULT NULL,
  `senha` varchar(30) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` char(11) NOT NULL,
  `datanascimento` date NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `tipo` set('gestordeprojeto','avaliadordeprojeto','financiadoracademico') NOT NULL,
  `pais` varchar(35) NOT NULL,
  `estado` varchar(35) NOT NULL,
  `cidade` varchar(35) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `ativo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `login`, `senha`, `nome`, `cpf`, `datanascimento`, `email`, `tipo`, `pais`, `estado`, `cidade`, `endereco`, `ativo`) VALUES
(24, 'Danielle', 'dani', 'Danielle da Silva Melo', '10618127666', '1991-03-20', 'danielle@gmail.com', 'gestordeprojeto', 'Brasil', 'Minas Gerais', 'Itajuba', 'Rua Simao', 1),
(25, 'Prado', 'pedro', 'Pedro', '1234567890', '2010-10-10', 'pedro@bol.com.br', 'avaliadordeprojeto', 'Brasil', 'Minas Gerais', 'Itajuba', 'Rua Tigre maia', 1),
(26, 'wallaceFelipe', 'wf123', 'Wallace', '41430893869', '1994-04-19', 'wallace.feliper@hotmail.com', 'avaliadordeprojeto', 'Brasil', 'Minas Gerais', 'Itajuba', 'Av. Doutor Henriqueto Cardinalli', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `avaliadordeprojetos`
--
ALTER TABLE `avaliadordeprojetos`
  ADD CONSTRAINT `avaliadordeprojetos_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `cotafinanciamento`
--
ALTER TABLE `cotafinanciamento`
  ADD CONSTRAINT `cotafinanciamento_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `cotafinanciamento_ibfk_2` FOREIGN KEY (`idprojeto`) REFERENCES `projeto` (`id`);

--
-- Constraints for table `edital`
--
ALTER TABLE `edital`
  ADD CONSTRAINT `edital_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `financiar`
--
ALTER TABLE `financiar`
  ADD CONSTRAINT `financiar_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `financiar_ibfk_2` FOREIGN KEY (`idprojeto`) REFERENCES `projeto` (`id`);

--
-- Constraints for table `recompensa`
--
ALTER TABLE `recompensa`
  ADD CONSTRAINT `recompensa_ibfk_1` FOREIGN KEY (`idprojeto`) REFERENCES `projeto` (`id`);

--
-- Constraints for table `repassefinanceiro`
--
ALTER TABLE `repassefinanceiro`
  ADD CONSTRAINT `repassefinanceiro_ibfk_1` FOREIGN KEY (`idprojeto`) REFERENCES `projeto` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
