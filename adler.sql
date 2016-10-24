-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 24, 2016 at 02:56 AM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

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
-- Table structure for table `avaliadordeprojetos`
--

CREATE TABLE IF NOT EXISTS `avaliadordeprojetos` (
  `idusuario` int(11) NOT NULL,
  `categoria` set('pesquisa','competicaotecnologica','inovacaoensino','manutencaoreforma','pequenasobras') NOT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `categoria` (`categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `nome` varchar(30) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
