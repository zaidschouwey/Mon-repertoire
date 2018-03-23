-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 23 mars 2018 à 13:05
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
-- Structure de la table `tblechange`
--

DROP TABLE IF EXISTS `tblechange`;
CREATE TABLE IF NOT EXISTS `tblechange` (
  `idechange` int(11) NOT NULL AUTO_INCREMENT,
  `jourechange` date NOT NULL,
  `userask` int(11) NOT NULL,
  `userto` int(11) NOT NULL,
  `usertoidhoraire` int(11) NOT NULL,
  `useraskjdisp` date NOT NULL,
  `userasktranche` int(11) NOT NULL,
  PRIMARY KEY (`idechange`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tblechange`
--

INSERT INTO `tblechange` (`idechange`, `jourechange`, `userask`, `userto`, `usertoidhoraire`, `useraskjdisp`, `userasktranche`) VALUES
(8, '2018-03-30', 1, 8, 61, '2018-03-25', 2);

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
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tblhoraire`
--

INSERT INTO `tblhoraire` (`idhoraire`, `datedebut`, `datefin`, `fk_utilisateur`, `fk_plagehoraire`) VALUES
(56, '2018-03-01', '2018-03-20', 15, 2),
(55, '2018-03-23', '2018-03-31', 35, 1),
(54, '2018-03-14', '2018-03-15', 35, 1),
(87, '2018-03-14', '2018-03-14', 1, 2),
(52, '2018-03-01', '2018-03-08', 19, 3),
(51, '2018-03-16', '2018-03-31', 32, 3),
(50, '2018-03-01', '2018-03-14', 32, 2),
(49, '2018-03-10', '2018-03-12', 1, 2),
(48, '2018-03-01', '2018-03-02', 1, 1),
(47, '2018-03-18', '2018-03-31', 2, 1),
(46, '2018-03-06', '2018-03-16', 2, 2),
(45, '2018-03-19', '2018-03-23', 12, 2),
(44, '2018-03-16', '2018-03-18', 12, 3),
(43, '2018-03-06', '2018-03-12', 25, 3),
(42, '2018-03-01', '2018-03-03', 25, 1),
(92, '2018-03-29', '2018-03-29', 1, 3),
(58, '2018-03-18', '2018-03-20', 17, 1),
(59, '2018-03-21', '2018-03-31', 17, 3),
(60, '2018-03-01', '2018-03-12', 8, 2),
(61, '2018-03-15', '2018-03-27', 8, 3),
(62, '2018-03-01', '2018-03-13', 10, 1),
(70, '2018-03-09', '2018-03-17', 23, 2),
(69, '2018-03-02', '2018-03-02', 23, 3),
(71, '2018-03-02', '2018-03-04', 11, 2),
(72, '2018-03-08', '2018-03-30', 11, 1),
(91, '2018-03-03', '2018-03-03', 8, 1),
(90, '2018-03-04', '2018-03-04', 1, 1),
(89, '2018-03-30', '2018-03-30', 1, 2),
(88, '2018-03-13', '2018-03-13', 8, 3);

-- --------------------------------------------------------

--
-- Structure de la table `tblplagehoraire`
--

DROP TABLE IF EXISTS `tblplagehoraire`;
CREATE TABLE IF NOT EXISTS `tblplagehoraire` (
  `idhorairepersonnel` int(11) NOT NULL AUTO_INCREMENT,
  `debut` time NOT NULL,
  `fin` time NOT NULL,
  PRIMARY KEY (`idhorairepersonnel`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tblplagehoraire`
--

INSERT INTO `tblplagehoraire` (`idhorairepersonnel`, `debut`, `fin`) VALUES
(1, '05:00:00', '13:45:00'),
(2, '13:15:00', '22:00:00'),
(3, '21:30:00', '05:45:00');

-- --------------------------------------------------------

--
-- Structure de la table `tbltypeutilisateurs`
--

DROP TABLE IF EXISTS `tbltypeutilisateurs`;
CREATE TABLE IF NOT EXISTS `tbltypeutilisateurs` (
  `idtypeutilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `typeutilisateur` varchar(32) NOT NULL,
  PRIMARY KEY (`idtypeutilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tbltypeutilisateurs`
--

INSERT INTO `tbltypeutilisateurs` (`idtypeutilisateur`, `typeutilisateur`) VALUES
(2, 'ICUS'),
(1, 'Infirmière'),
(3, 'Admin');

-- --------------------------------------------------------

--
-- Structure de la table `tblutilisateurs`
--

DROP TABLE IF EXISTS `tblutilisateurs`;
CREATE TABLE IF NOT EXISTS `tblutilisateurs` (
  `idutilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(63) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nom` varchar(63) NOT NULL,
  `prenom` varchar(63) NOT NULL,
  `datedenaissance` date NOT NULL,
  `groupesanguin` varchar(7) NOT NULL,
  `rue` varchar(255) NOT NULL,
  `npa` smallint(6) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `fk_typeutilisateur` int(11) NOT NULL,
  PRIMARY KEY (`idutilisateur`),
  KEY `fk_typeutilisateur` (`fk_typeutilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tblutilisateurs`
--

INSERT INTO `tblutilisateurs` (`idutilisateur`, `login`, `password`, `nom`, `prenom`, `datedenaissance`, `groupesanguin`, `rue`, `npa`, `ville`, `mail`, `tel`, `fk_typeutilisateur`) VALUES
(1, 'alice', 'password', 'Bler', 'Alice', '1985-09-05', 'O+', 'Tösstalstrasse 113', 8468, 'Waltalingen', 'AliceBler@rhyta-com', '052 299 48 28', 2),
(2, 'Ligh1978', 'fohMai4raej', 'Blais', 'Tilly', '1978-08-04', 'B+', 'Schuepisstrasse 70', 1977, 'Icogne', 'TillyBlais@jourrapide-com', '027 787 60 95', 2),
(3, 'Theasketione88', 'eiHeinai1', 'Dionne', 'Agate', '1988-05-10', 'A+', 'Allmenrüti 20', 2747, 'Seehof', 'AgateDionne@teleworm-us', '032 572 96 29', 2),
(4, 'Prationfles1978', 'ja8Aigheth', 'St-Jean', 'Valentine', '1978-10-11', 'A+', 'Studhaldenstrasse 52', 1080, 'Les Cullayes', 'ValentineSt-Jean@superrito-com', '021 473 46 23', 2),
(5, 'Altatter', 'xai6Fey0', 'Guédry', 'Orane', '1991-08-02', 'B+', 'Betburweg 132', 2732, 'Loveresse', 'OraneGuedry@jourrapide-com', '032 708 51 46', 2),
(6, 'Youreaver', 'Aek5keeYee', 'Lemaître', 'Felicienne', '1988-02-19', 'A+', 'Casut 129', 1854, 'Leysin', 'FelicienneLemaitre@superrito-com', '024 743 53 95', 2),
(7, 'Elbectern', 'Chue5quooleung', 'Pelland', 'Edmee', '1970-02-03', 'A+', 'Rägetenstrasse 39', 8372, 'Horben bei Sirnach', 'EdmeePelland@gustr-com', '044 583 43 20', 2),
(8, 'Raveld', 'ro2aey2oGh', 'Duhamel', 'Campbell', '1973-08-09', 'O+', 'Valéestrasse 79', 1377, 'Oulens-sous-Echallens', 'zazar981@hotmail.com', '021 452 28 91', 1),
(9, 'Suchaticke', 'faech5Aetae', 'Dufour', 'Diane', '1996-08-08', 'O+', 'Tösstalstrasse 48', 6242, 'Wauwil', 'DianeDufour@gustr-com', '041 236 20 32', 1),
(10, 'Acantiming', 'Iche6iivioj', 'Clavet', 'Aurélie', '1985-10-12', 'O+', 'Valéestrasse 119', 8913, 'Ottenbach', 'AurelieClavet@rhyta-com', '044 383 87 28', 1),
(11, 'Imbly1985', 'OhBafo4Ai', 'Tougas', 'Capucine', '1985-10-20', 'B+', 'Gerbiweg 147', 8180, 'Bülach', 'CapucineTougas@armyspy-com', '044 655 79 36', 1),
(12, 'Somenct', 'Bulie8joov', 'Étoile', 'Brunella', '1991-10-11', 'O+', 'Bergrain 69', 1279, 'Chavannes-de-Bogis', 'BrunellaEtoile@cuvox-de', '022 378 36 99', 1),
(13, 'Fooke1994', 'ieM2soh4j', 'Guernon', 'Clementine', '1994-06-05', 'B+', 'Kornquaderweg 101', 9532, 'Rickenbach', 'ClementineGuernon@teleworm-us', '071 724 19 79', 1),
(14, 'Thadince', 'Yieb1bi9c', 'Létourneau', 'Cheney', '1987-06-09', 'B+', 'Kammelenbergstrasse 61', 2902, 'Fontenais', 'CheneyLetourneau@dayrep-com', '032 376 46 19', 1),
(15, 'Therevized1996', 'theiM0men', 'Cinq-Mars', 'Juliette', '1996-09-08', 'O+', 'Via Albarelle 121', 3066, 'Stettlen', 'JulietteCinq-Mars@teleworm-us', '031 588 60 81', 1),
(16, 'Folls1995', 'Ohk0Eephais', 'St-Pierre', 'Royale', '1995-01-05', 'A+', 'Gerbiweg 5', 3935, 'Bürchen', 'RoyaleSt-Pierre@gustr-com', '027 903 98 44', 1),
(17, 'Somps1982', 'pee0ar7Ahz', 'CinqMars', 'Blanche', '1982-05-05', 'A+', 'Allmenrüti 105', 8607, 'Seegräben', 'BlancheCinqMars@armyspy-com', '052 530 83 12', 1),
(18, 'Oting1994', 'EithiJook9', 'de Launay', 'Romain', '1994-07-01', 'O-', 'Mühle 107', 5012, 'Schönenwerd', 'RomaindeLaunay@teleworm-us', '062 467 35 72', 1),
(19, 'Thathis', 'NaXah9uTah', 'Brisebois', 'Agathe', '1981-11-01', 'A+', 'Via Verbano 10', 7077, 'Valbella', 'AgatheBrisebois@superrito-com', '081 276 18 75', 1),
(20, 'Alateve', 'ieng1Xiceepie', 'Pomerleau', 'Olivie', '1993-02-05', 'O+', 'Kopfhölzistrasse 61', 1892, 'Lavey les Bains', 'OliviePomerleau@cuvox-de', '024 630 11 86', 1),
(21, 'Sucel1993', 'Kiewei7seex', 'Lavallée', 'Alphonsine', '1993-08-09', 'B+', 'Brunnenstrasse 95', 1659, 'Rougemont', 'AlphonsineLavallee@fleckens-hu', '026 992 46 80', 1),
(22, 'Prighted1972', 'daiHoh2ah', 'Parenteau', 'Aymon', '1972-07-24', 'B+', 'Wiesenstrasse 57', 4438, 'Bärenwil', 'AymonParenteau@gustr-com', '061 807 57 11', 1),
(23, 'Hingive', 'kahPee3fe9ei', 'Trépanier', 'Karlotta', '1977-07-01', 'B+', 'Im Sandbüel 9', 3267, 'Frienisberg', 'KarlottaTrepanier@fleckens-hu', '032 436 54 54', 1),
(24, 'Waskinge', 'quo0Kungeith', 'Rochefort', 'Alexandrin', '1968-01-04', 'B+', 'Via Pestariso 96', 8735, 'St- Gallenkappel', 'AlexandrinRochefort@gustr-com', '044 406 40 12', 1),
(25, 'Therejorty', 'RohT4Jaej', 'Bergeron', 'Vivienne', '1994-03-07', 'A+', 'Im Sandbüel 35', 1707, 'Fribourg', 'VivienneBergeron@dayrep-com', '026 451 28 70', 1),
(26, 'Wougen1997', 'ieW2uang5Chu', 'Desnoyers', 'Fanchon', '1997-07-06', 'O+', 'Kappelergasse 3', 5645, 'Aettenschwil', 'FanchonDesnoyers@fleckens-hu', '062 562 80 63', 1),
(27, 'Wrisee', 'au2Zua8aeth', 'Saurel', 'Jeanette', '1983-10-08', 'B+', 'Grossmatt 53', 3991, 'Betten', 'JeanetteSaurel@fleckens-hu', '027 436 62 38', 1),
(28, 'Cred1989', 'Xaetaev1', 'Sorel', 'Sydney', '1989-05-09', 'O+', 'Seefeldstrasse 54', 5313, 'Klingnau', 'SydneySorel@teleworm-us', '062 487 67 25', 1),
(29, 'Ruitheroming', 'Yae0gaib8loo', 'Étoile', 'Ansel', '1977-11-05', 'O+', 'Kronwiesenweg 132', 8288, 'Kreuzlingen', 'AnselEtoile@gustr-com', '044 912 82 19', 1),
(30, 'Appotherged', 'weef9Hoh5w', 'Grivois', 'Monique', '1968-11-05', 'B+', 'Bergrain 139', 1744, 'Chénens', 'MoniqueGrivois@dayrep-com', '026 781 66 29', 1),
(31, 'Calloseven', 'eagh1Mie2oo', 'D\'Aoust', 'Angelette', '1972-12-08', 'B+', 'Kappelergasse 19', 9466, 'Aeugstisried', 'AngeletteDAoust@teleworm-us', '071 951 60 75', 1),
(32, 'Feremabight', 'uoXohy7boh', 'Bourque', 'Armina', '1997-02-11', 'A+', 'Lungolago 65', 1226, 'Thônex', 'ArminaBourque@teleworm-us', '022 595 14 31', 1),
(33, 'Hime1979', 'Xoo7eibee', 'Hervieux', 'Demi', '1979-05-07', 'B+', 'Breitenstrasse 90', 4053, 'Basel', 'DemiHervieux@dayrep-com', '061 770 93 35', 1),
(34, 'Shettlees', 'EeceeNo8', 'Mailly', 'Toussaint', '1971-04-06', 'B+', 'Strickstrasse 63', 8130, 'Zumikon', 'ToussaintMailly@dayrep-com', '044 208 85 33', 1),
(35, 'Texplass', 'fu6shahtooD', 'Charrette', 'Telford', '1989-01-11', 'B+', 'Via Franscini 45', 3661, 'Uetendorf', 'TelfordCharrette@superrito-com', '033 284 34 12', 1),
(36, 'Claying', 'olod9Lu2', 'Simon', 'Adélaïde', '1978-11-01', 'B+', 'Wingertweg 74', 2885, 'Epauvillers', 'AdelaideSimon@jourrapide-com', '032 451 75 68', 1),
(37, 'Sailse', 'aiT4Owenaij', 'Lapointe', 'Catherine', '1992-06-26', 'AB+', 'Hasenbühlstrasse 139', 8493, 'Blitterswil', 'CatherineLapointe@superrito-com', '052 480 23 24', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
