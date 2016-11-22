-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2016 at 01:40 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `avaliacao`
--

INSERT INTO `avaliacao` (`id`, `codProjeto`, `codAvaliador`, `data`, `nota`, `sugestao`) VALUES
(12, 9, 26, '2016-11-07', 7.89, NULL),
(13, 11, 26, '2016-11-07', 8.57, NULL),
(14, 12, 26, '2016-11-07', 9.57, NULL),
(15, 13, 26, '2016-11-07', 7.14, NULL),
(16, 14, 26, '2016-11-20', 2.57, 'pÃ©ssimo trabalho'),
(17, 10, 27, '2016-11-20', 10, 'ok'),
(18, 15, 27, '2016-11-20', 9.2, 'ok');

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
(25, 'inovacaoensino'),
(27, 'manutencaoreforma');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `criteriodeavaliacao`
--

INSERT INTO `criteriodeavaliacao` (`id`, `categoria`, `descricao`, `status`, `peso`) VALUES
(7, 'competicaotecnologica', 'Impacto', 1, 8),
(10, 'pequenasobras', 'Descricao', 1, 4),
(11, 'pesquisa', 'Impacto Social', 1, 6),
(13, 'pesquisa', 'InovaÃ§Ã£o', 1, 8),
(14, 'manutencaoreforma', 'Importancia', 1, 8),
(15, 'manutencaoreforma', 'Criterio outro', 1, 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `financiar`
--

INSERT INTO `financiar` (`id`, `idusuario`, `idprojeto`, `tipo`, `valor`, `formapagamento`) VALUES
(1, 28, 10, 'integral', 3500000, 'cartaocredito'),
(2, 28, 10, 'integral', 22, 'cartaocredito'),
(3, 28, 10, 'integral', 22, 'cartaocredito');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `itemavaliacao`
--

INSERT INTO `itemavaliacao` (`id`, `idAvaliacao`, `idCriterio`, `nota`, `peso`) VALUES
(6, 12, 11, 6, 6),
(7, 12, 13, 9.3, 8),
(8, 13, 11, 8, 6),
(9, 13, 13, 9, 8),
(10, 14, 11, 9, 6),
(11, 14, 13, 10, 8),
(12, 15, 11, 6, 6),
(13, 15, 13, 8, 8),
(14, 16, 11, 2, 6),
(15, 16, 13, 3, 8),
(16, 17, 14, 10, 8),
(17, 17, 15, 10, 2),
(18, 18, 14, 9.5, 8),
(19, 18, 15, 8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `projeto`
--

CREATE TABLE IF NOT EXISTS `projeto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` char(6) DEFAULT NULL,
  `nome` varchar(30) NOT NULL,
  `coordenador` int(11) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `projeto`
--

INSERT INTO `projeto` (`id`, `codigo`, `nome`, `coordenador`, `categoria`, `status`, `duracaoprevista`, `valor`, `prazomaximo`, `valorminimo`, `valormaximo`, `imagem`) VALUES
(9, 'prj100', 'Black Bee', 24, 'pesquisa', 'aprovado', '20', 20000, NULL, NULL, NULL, NULL),
(10, 'prj909', 'Reforma IMC', 24, 'manutencaoreforma', 'aprovado', '60', 3500000, NULL, NULL, NULL, NULL),
(11, 'pr3000', 'Uairrior', 24, 'pesquisa', 'aprovado', '30', 12000, NULL, NULL, NULL, NULL),
(12, 'pr5000', 'Cheetah', 24, 'pesquisa', 'finalizado', '90', 12000, NULL, NULL, NULL, NULL),
(13, 'proj40', 'Pesquisa offloading', 24, 'pesquisa', 'aprovado', '30', 3000, NULL, NULL, NULL, NULL),
(14, 'tes123', 'teste', 24, 'pesquisa', 'reprovado', '128', 120000, NULL, NULL, NULL, NULL),
(15, 'prj154', 'Outro Ctegoria', 24, 'manutencaoreforma', 'aprovado', '120', 200, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recompensa`
--

CREATE TABLE IF NOT EXISTS `recompensa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprojeto` int(11) NOT NULL DEFAULT '0',
  `descricao` varchar(200) NOT NULL,
  `valorminimo` double DEFAULT NULL,
  `valormaximo` double DEFAULT NULL,
  `limite` int(11) DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`,`idprojeto`),
  KEY `idprojeto` (`idprojeto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `recompensa`
--

INSERT INTO `recompensa` (`id`, `idprojeto`, `descricao`, `valorminimo`, `valormaximo`, `limite`, `valor`, `titulo`) VALUES
(1, 10, 'recompensa teste com um texto bem longo para testar a quebra de texto também O texto ficou muito pequeno', 0, NULL, 20, 22.00, 'Chaveiro'),
(2, 10, 'recompensa teste com um texto bem longo para testar a quebra de texto também', 20, NULL, NULL, 22.00, 'Chaveiro');

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
  `tipo` set('gestordeprojeto','avaliadordeprojeto','financiadoracademico','usuariopublico') NOT NULL,
  `pais` varchar(35) NOT NULL,
  `estado` varchar(35) NOT NULL,
  `cidade` varchar(35) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `ativo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `login`, `senha`, `nome`, `cpf`, `datanascimento`, `email`, `tipo`, `pais`, `estado`, `cidade`, `endereco`, `ativo`) VALUES
(24, 'Danielle', 'dani', 'Danielle da Silva Melo', '10618127666', '1991-03-20', 'danielle@gmail.com', 'gestordeprojeto', 'Brasil', 'Minas Gerais', 'Itajuba', 'Rua Simao', 1),
(25, 'Prado', 'pedro', 'Pedro', '1234567890', '2010-10-10', 'pedro@bol.com.br', 'avaliadordeprojeto', 'Brasil', 'Minas Gerais', 'Itajuba', 'Rua Tigre maia', 1),
(26, 'wallaceFelipe', 'wf123', 'Wallace', '41430893869', '1994-04-19', 'wallace.feliper@hotmail.com', 'avaliadordeprojeto', 'Brasil', 'Minas Gerais', 'Itajuba', 'Av. Doutor Henriqueto Cardinalli', 1),
(27, 'guimerlan', 'gui123', 'Guilherme Merlan', '12345689200', '1994-05-20', 'gui@hotmail.com', 'avaliadordeprojeto', 'Brasil', 'SÃ£o Paulo', 'Pindamonhangaba', 'Avenida AbaetÃ©', 1),
(28, 'augPerroni', '12345', 'Augustus Perroni', '02566384819', '1992-10-20', 'augustus@gmail.com', 'usuariopublico', 'Brasil', 'SÃ£o Paulo', 'TaubatÃ©', 'Rua Chiquinha de Matos, 55', 1),
(29, 'robCamp', '12345', 'Roberto Campos', '78654938299', '1979-10-07', 'roberto.campos@gmail.com', 'usuariopublico', 'Brasil', 'SÃ£o Paulo', 'SÃ£o Paulo', 'Rua das MagnÃ³lias, 625', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuariorecompensa`
--

CREATE TABLE IF NOT EXISTS `usuariorecompensa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `financiador` int(11) NOT NULL,
  `idrecompensa` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `usuariorecompensa`
--

INSERT INTO `usuariorecompensa` (`id`, `financiador`, `idrecompensa`) VALUES
(1, 28, 1),
(2, 28, 1),
(3, 28, 1);

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
