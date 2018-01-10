-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Gen 10, 2018 alle 12:00
-- Versione del server: 5.6.33-log
-- PHP Version: 5.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `my_policeapps`
--
CREATE DATABASE IF NOT EXISTS `my_policeapps` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci;
USE `my_policeapps`;

-- --------------------------------------------------------

--
-- Struttura della tabella `Accertamento`
--

DROP TABLE IF EXISTS `Accertamento`;
CREATE TABLE IF NOT EXISTS `Accertamento` (
  `idAccertamento` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `anno` int(11) NOT NULL,
  `targa` char(15) COLLATE latin1_general_ci DEFAULT NULL,
  `luogo` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `data` datetime(3) NOT NULL,
  `descrizione` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `descrizione_estesa` longtext COLLATE latin1_general_ci,
  `eliminato` tinyint(4) NOT NULL DEFAULT '0',
  `NumNdR` int(11) DEFAULT NULL,
  PRIMARY KEY (`idAccertamento`),
  UNIQUE KEY `uniconumacc` (`anno`,`numero`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=95 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `Attivita`
--

DROP TABLE IF EXISTS `Attivita`;
CREATE TABLE IF NOT EXISTS `Attivita` (
  `idAttivita` int(11) NOT NULL AUTO_INCREMENT,
  `descrizione` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `completata` tinyint(4) NOT NULL DEFAULT '0',
  `idAccertamento` int(11) NOT NULL,
  `data` datetime(3) DEFAULT NULL,
  PRIMARY KEY (`idAttivita`),
  KEY `R_13` (`idAccertamento`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=104 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `Documento`
--

DROP TABLE IF EXISTS `Documento`;
CREATE TABLE IF NOT EXISTS `Documento` (
  `idDocumento` int(11) NOT NULL AUTO_INCREMENT,
  `File` longblob NOT NULL,
  `idAccertamento` int(11) NOT NULL,
  `filename` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `dataDocumento` datetime(3) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `descrizione` varchar(1000) COLLATE latin1_general_ci DEFAULT NULL,
  `conttype` varchar(50) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`idDocumento`),
  KEY `AccDoc` (`idAccertamento`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `Log`
--

DROP TABLE IF EXISTS `Log`;
CREATE TABLE IF NOT EXISTS `Log` (
  `idLog` int(11) NOT NULL AUTO_INCREMENT,
  `dataora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `operazione` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `idPersona` int(11) DEFAULT NULL,
  `idAccertamento` int(11) DEFAULT NULL,
  PRIMARY KEY (`idLog`),
  KEY `R_11` (`idPersona`),
  KEY `R_12` (`idAccertamento`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=711 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `RuoloSoggetto`
--

DROP TABLE IF EXISTS `RuoloSoggetto`;
CREATE TABLE IF NOT EXISTS `RuoloSoggetto` (
  `idRuolo` smallint(6) NOT NULL,
  `nomeRuolo` varchar(30) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`idRuolo`),
  UNIQUE KEY `nomeRuolo` (`nomeRuolo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `Soggetto`
--

DROP TABLE IF EXISTS `Soggetto`;
CREATE TABLE IF NOT EXISTS `Soggetto` (
  `idSoggetto` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `dataNascita` datetime(3) DEFAULT NULL,
  `luogoNascita` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `residenza` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `tel` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `mail` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `documento` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `indirizzo` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `tipo` smallint(6) NOT NULL,
  `winUN` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `login` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `password` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `permessi` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `societa` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`idSoggetto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=155 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `SoggettoAccertamento`
--

DROP TABLE IF EXISTS `SoggettoAccertamento`;
CREATE TABLE IF NOT EXISTS `SoggettoAccertamento` (
  `idSoggetto` int(11) NOT NULL,
  `idAccertamento` int(11) NOT NULL,
  `ruolo` smallint(6) NOT NULL,
  `idSoggettoAccertamento` int(11) NOT NULL AUTO_INCREMENT,
  `descRuolo` varchar(300) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`idSoggettoAccertamento`),
  UNIQUE KEY `XAK1PersonaAccertamento` (`idSoggetto`,`idAccertamento`,`ruolo`),
  KEY `AccPersAcc` (`idAccertamento`),
  KEY `idSoggetto` (`idSoggetto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=196 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
