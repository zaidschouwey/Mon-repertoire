-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 16 mars 2018 à 14:00
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `horaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `tblhoraire`
--

DROP TABLE IF EXISTS `tblhoraire`;
CREATE TABLE IF NOT EXISTS `tblhoraire` (
  `idhoraire` int(11) NOT NULL AUTO_INCREMENT,
  `datedebut` date NOT NULL,
  `datefin` date NOT NULL,
  `fk_utilisateur` int(11) NOT NULL,
  `fk_plagehoraire` int(11) NOT NULL,
  PRIMARY KEY (`idhoraire`),
  KEY `fk_utilisateur` (`fk_utilisateur`),
  KEY `fk_plagehoraire` (`fk_plagehoraire`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tblhoraire`
--

INSERT INTO `tblhoraire` (`idhoraire`, `datedebut`, `datefin`, `fk_utilisateur`, `fk_plagehoraire`) VALUES
(56, '2018-03-01', '2018-03-13', 15, 2),
(55, '2018-03-23', '2018-03-31', 35, 1),
(54, '2018-03-14', '2018-03-15', 35, 1),
(53, '2018-03-22', '2018-03-31', 19, 3),
(52, '2018-03-01', '2018-03-08', 19, 3),
(51, '2018-03-16', '2018-03-31', 32, 3),
(50, '2018-03-01', '2018-03-14', 32, 2),
(49, '2018-03-10', '2018-03-14', 1, 2),
(48, '2018-03-01', '2018-03-04', 1, 1),
(47, '2018-03-18', '2018-03-31', 2, 1),
(46, '2018-03-06', '2018-03-16', 2, 2),
(45, '2018-03-19', '2018-03-23', 12, 2),
(44, '2018-03-16', '2018-03-18', 12, 3),
(43, '2018-03-06', '2018-03-12', 25, 3),
(42, '2018-03-01', '2018-03-03', 25, 1),
(57, '2018-03-15', '2018-03-31', 15, 1),
(58, '2018-03-18', '2018-03-20', 17, 1),
(59, '2018-03-21', '2018-03-31', 17, 3),
(60, '2018-03-01', '2018-03-13', 8, 2),
(61, '2018-03-15', '2018-03-27', 8, 3),
(62, '2018-03-01', '2018-03-25', 10, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
