-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 09 avr. 2019 à 17:10
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `info-lyon1`
--


-- --------------------------------------------------------

--
-- Structure de la table `absence_type`
--

DROP TABLE IF EXISTS `absence_type`;
CREATE TABLE IF NOT EXISTS `absence_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `absenceTypeName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_FBCF99B6F5D58880` (`absenceTypeName`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `absence_type`
--

INSERT INTO `absence_type` (`id`, `absenceTypeName`) VALUES
(1, 'Absence'),
(2, 'Contrôle'),
(3, 'Infirmerie'),
(4, 'Retard');

-- --------------------------------------------------------

--
-- Structure de la table `choix_groupe`
--

DROP TABLE IF EXISTS `choix_groupe`;
CREATE TABLE IF NOT EXISTS `choix_groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `choixName` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1715911C41BD575` (`choixName`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `choix_groupe`
--

INSERT INTO `choix_groupe` (`id`, `choixName`) VALUES
(1, 'G1'),
(2, 'G2'),
(3, 'G3'),
(4, 'G4'),
(5, 'G5'),
(6, 'G6'),
(7, 'G7'),
(8, 'G8');

-- --------------------------------------------------------

--
-- Structure de la table `controller`
--

DROP TABLE IF EXISTS `controller`;
CREATE TABLE IF NOT EXISTS `controller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomBundle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nomController` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valide` tinyint(1) NOT NULL,
  `nomRoute` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nomNavbar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `alterable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4CF2669ADAC2B516` (`nomController`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `controller`
--

INSERT INTO `controller` (`id`, `nomBundle`, `nomController`, `valide`, `nomRoute`, `nomNavbar`, `roles`, `alterable`) VALUES
(1, 'Mark', 'Mark', 1, 'teckmeb_mark_view', 'Notes', 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 1),
(2, 'Absence', 'Absence', 1, 'teckmeb_absence_homepage', 'Absences', 'a:1:{i:0;s:16:\"ROLE_SECRETARIAT\";}', 1),
(3, 'Control', 'Control', 1, 'teckmeb_control_homepage', 'Controles', 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 1),
(4, 'Ptut', 'Ptut', 1, 'teckmeb_ptut_homepage', 'Ptut', 'a:2:{i:0;s:12:\"ROLE_TEACHER\";i:1;s:13:\"ROLE_ETUDIANT\";}', 1),
(5, 'Question', 'Question', 1, 'teckmeb_question_homepage', 'Question', 'a:2:{i:0;s:12:\"ROLE_TEACHER\";i:1;s:13:\"ROLE_ETUDIANT\";}', 1),
(6, 'Suivi', 'Suivi', 1, 'teckmeb_suivi_homepage', 'Suivi', 'a:2:{i:0;s:12:\"ROLE_TEACHER\";i:1;s:16:\"ROLE_SECRETARIAT\";}', 1),
(7, 'TimeTable', 'Timetable', 1, 'teckmeb_time_table_homepage', 'Emploi du temps', 'a:2:{i:0;s:12:\"ROLE_TEACHER\";i:1;s:13:\"ROLE_ETUDIANT\";}', 1),
(9, 'Control', 'MarkExcel', 1, 'pas vide', 'Controles', 'N;', 1),
(10, 'Absence', 'AbsenceEtudiant', 1, 'teckmeb_absence_view', 'Absences', 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 1),
(11, 'Administration', 'SQLFile', 1, 'pas de route', 'Administration', 'N;', 0),
(12, 'Administration', 'RemoveBD', 1, 'pas de route', 'Administration', 'N;', 0),
(13, 'Administration', 'SubjectTeacher', 1, 'pas de route', 'Administration', 'N;', 0),
(14, 'Administration', 'SuiviAdministration', 1, 'pas de route', 'Administration', 'N;', 0),
(15, 'Administration', 'StudentExcel', 1, 'pas de route', 'Administration', 'N;', 0),
(16, 'Administration', 'Course', 1, 'pas de route', 'Administration', 'N;', 0),
(17, 'Administration', 'TU', 1, 'pas de route', 'Administration', 'N;', 0),
(18, 'Administration', 'ModuleAdministration', 1, 'pas de route', 'Administration', 'N;', 0),
(19, 'Administration', 'Subject', 1, 'pas de route', 'Administration', 'N;', 0),
(20, 'Administration', 'Semestre', 1, 'pas de route', 'Administration', 'N;', 0),
(21, 'Administration', 'Groupe', 1, 'pas de route', 'Administration', 'N;', 0);
-- --------------------------------------------------------

--
-- Structure de la table `control_type`
--

DROP TABLE IF EXISTS `control_type`;
CREATE TABLE IF NOT EXISTS `control_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controlTypeName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `control_type`
--

INSERT INTO `control_type` (`id`, `controlTypeName`) VALUES
(1, 'Promo'),
(2, 'Groupe');

-- --------------------------------------------------------

--
-- Structure de la table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_type_id` int(11) NOT NULL,
  `creationYear` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_169E6FB9CD8F897F` (`course_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `course`
--

INSERT INTO `course` (`id`, `course_type_id`, `creationYear`) VALUES
(1, 1, 2018),
(2, 2, 2018),
(3, 3, 2019),
(4, 4, 2019);

-- --------------------------------------------------------

--
-- Structure de la table `course_teaching_unit`
--

DROP TABLE IF EXISTS `course_teaching_unit`;
CREATE TABLE IF NOT EXISTS `course_teaching_unit` (
  `course_id` int(11) NOT NULL,
  `teaching_unit_id` int(11) NOT NULL,
  PRIMARY KEY (`course_id`,`teaching_unit_id`),
  KEY `IDX_C14E2F9591CC992` (`course_id`),
  KEY `IDX_C14E2F92F82B390` (`teaching_unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `course_teaching_unit`
--

INSERT INTO `course_teaching_unit` (`course_id`, `teaching_unit_id`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 5),
(3, 6),
(3, 7),
(4, 8),
(4, 9),
(4, 10);

-- --------------------------------------------------------

--
-- Structure de la table `course_type`
--

DROP TABLE IF EXISTS `course_type`;
CREATE TABLE IF NOT EXISTS `course_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_447C8A2F5E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `course_type`
--

INSERT INTO `course_type` (`id`, `name`) VALUES
(1, 'S1'),
(2, 'S2'),
(3, 'S3'),
(4, 'S4');

-- --------------------------------------------------------

--
-- Structure de la table `education`
--

DROP TABLE IF EXISTS `education`;
CREATE TABLE IF NOT EXISTS `education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupe_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `educationName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DB0A5ED27A45358C` (`groupe_id`) USING BTREE,
  KEY `IDX_DB0A5ED241807E1D` (`teacher_id`) USING BTREE,
  KEY `IDX_DB0A5ED223EDC87` (`subject_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `education`
--

INSERT INTO `education` (`id`, `groupe_id`, `teacher_id`, `subject_id`, `educationName`) VALUES
(1, 5, 8, 1, 'G5S1 - Architecture'),
(4, 26, 8, 1, 'G1S1 - Architecture'),
(5, 2, 8, 1, 'G2S1 - Architecture'),
(6, 2, 1, 5, 'G2S1 - C Introduction'),
(7, 8, 1, 23, 'G1S2 - Java'),
(10, 4, 8, 1, 'G4S1 - Architecture'),
(11, 26, 3, 2, 'G1S1 - Initiation Windows'),
(12, 26, 4, 13, 'G1S1 - Mathématiques discrètes'),
(13, 26, 5, 16, 'G1S1 - Fonctionnement des organisations'),
(14, 26, 6, 8, 'G1S1 - MDD'),
(15, 26, 3, 3, 'G1S1 - Initiation Linux'),
(16, 26, 4, 14, 'G1S1 - Algèbre linéaire'),
(17, 26, 7, 17, 'G1S1 - Expression-Communication – Fondamentaux de la communication'),
(18, 26, 6, 9, 'G1S1 - SQL'),
(19, 3, 9, 18, 'G3S1 - Anglais et Informatique'),
(20, 3, 10, 8, 'G3S1 - MDD'),
(21, 3, 11, 3, 'G3S1 - Initiation Linux'),
(22, 3, 12, 13, 'G3S1 - Mathématiques discrètes'),
(23, 3, 3, 2, 'G3S1 - Initiation Windows'),
(24, 3, 3, 9, 'G3S1 - SQL'),
(25, 3, 13, 16, 'G3S1 - Fonctionnement des organisations'),
(26, 3, 12, 14, 'G3S1 - Algèbre linéaire'),
(27, 3, 14, 17, 'G3S1 - Expression-Communication – Fondamentaux de la communication'),
(28, 3, 8, 1, 'G3S1 - Architecture'),
(29, 2, 15, 2, 'G2S1 - Initiation Windows'),
(30, 2, 9, 18, 'G2S1 - Anglais et Informatique'),
(31, 2, 4, 14, 'G2S1 - Algèbre linéaire'),
(32, 2, 6, 9, 'G2S1 - SQL'),
(33, 2, 16, 17, 'G2S1 - Expression-Communication – Fondamentaux de la communication'),
(34, 2, 13, 16, 'G2S1 - Fonctionnement des organisations'),
(35, 2, 17, 8, 'G2S1 - MDD'),
(36, 2, 4, 13, 'G2S1 - Mathématiques discrètes'),
(37, 2, 3, 3, 'G2S1 - Initiation Linux'),
(38, 4, 18, 16, 'G4S1 - Fonctionnement des organisations'),
(39, 4, 6, 9, 'G4S1 - SQL'),
(40, 4, 19, 2, 'G4S1 - Initiation Windows'),
(41, 4, 16, 17, 'G4S1 - Expression-Communication – Fondamentaux de la communication'),
(42, 4, 20, 3, 'G4S1 - Initiation Linux'),
(43, 4, 17, 8, 'G4S1 - MDD'),
(44, 4, 12, 13, 'G4S1 - Mathématiques discrètes'),
(45, 4, 12, 14, 'G4S1 - Algèbre linéaire'),
(46, 5, 10, 8, 'G5S1 - MDD'),
(47, 5, 21, 13, 'G5S1 - Mathématiques discrètes'),
(48, 5, 19, 2, 'G5S1 - Initiation Windows'),
(49, 5, 22, 9, 'G5S1 - SQL'),
(50, 5, 23, 3, 'G5S1 - Initiation Linux'),
(51, 5, 13, 16, 'G5S1 - Fonctionnement des organisations'),
(52, 5, 21, 14, 'G5S1 - Algèbre linéaire'),
(53, 2, 24, 10, 'G2S1 - Web'),
(54, 2, 25, 11, 'G2S1 - Documents numériques'),
(56, 2, 27, 15, 'G2S1 - Environnement économique'),
(57, 2, 28, 19, 'G2S1 - PPP - Connaître le monde professionnel'),
(58, 8, 11, 28, 'G1S2 - Programmation et administration des bases de données'),
(59, 8, 28, 37, 'G1S2 - PPP – Identifier ses compétences'),
(60, 8, 7, 35, 'G1S2 - Expression-Communication – Communication, information et argumentation'),
(61, 8, 4, 31, 'G1S2 - Analyse et méthodes numériques'),
(62, 8, 13, 32, 'G1S2 - Environnement comptable, financier, juridique et social'),
(63, 8, 4, 30, 'G1S2 - Graphes et langages'),
(64, 8, 31, 36, 'G1S2 - Communiquer en anglais'),
(65, 8, 32, 24, 'G1S2 - Cycle de vie du développement d\'application'),
(66, 8, 33, 25, 'G1S2 - UML'),
(67, 8, 29, 20, 'G1S2 - Architecture et programmation des mécanismes de base d\'un système informatique'),
(68, 27, 4, 30, 'G2S2 - Graphes et langages'),
(69, 27, 31, 36, 'G2S2 - Communiquer en anglais'),
(70, 27, 34, 24, 'G2S2 - Cycle de vie du développement d\'application'),
(71, 27, 35, 25, 'G2S2 - UML'),
(72, 27, 7, 35, 'G2S2 - Expression-Communication – Communication, information et argumentation'),
(73, 27, 33, 28, 'G2S2 - Programmation et administration des bases de données'),
(74, 27, 28, 37, 'G2S2 - PPP – Identifier ses compétences'),
(75, 27, 36, 32, 'G2S2 - Environnement comptable, financier, juridique et social'),
(76, 27, 4, 31, 'G2S2 - Analyse et méthodes numériques'),
(77, 27, 29, 20, 'G2S2 - Architecture et programmation des mécanismes de base d\'un système informatique'),
(78, 28, 35, 28, 'G3S2 - Programmation et administration des bases de données'),
(79, 28, 12, 30, 'G3S2 - Graphes et langages'),
(80, 28, 3, 25, 'G3S2 - UML'),
(81, 28, 7, 35, 'G3S2 - Expression-Communication – Communication, information et argumentation'),
(82, 28, 21, 31, 'G3S2 - Analyse et méthodes numériques'),
(83, 28, 13, 32, 'G3S2 - Environnement comptable, financier, juridique et social'),
(84, 28, 31, 36, 'G3S2 - Communiquer en anglais'),
(85, 28, 32, 24, 'G3S2 - Cycle de vie du développement d\'application'),
(86, 28, 7, 37, 'G3S2 - PPP – Identifier ses compétences'),
(87, 28, 8, 20, 'G3S2 - Architecture et programmation des mécanismes de base d\'un système informatique'),
(88, 29, 34, 24, 'G4S2 - Cycle de vie du développement d\'application'),
(89, 29, 13, 32, 'G4S2 - Environnement comptable, financier, juridique et social'),
(90, 29, 14, 35, 'G4S2 - Expression-Communication – Communication, information et argumentation'),
(91, 29, 3, 28, 'G4S2 - Programmation et administration des bases de données'),
(92, 29, 37, 20, 'G4S2 - Architecture et programmation des mécanismes de base d\'un système informatique'),
(93, 29, 35, 25, 'G4S2 - UML'),
(94, 29, 28, 37, 'G4S2 - PPP – Identifier ses compétences'),
(95, 29, 12, 30, 'G4S2 - Graphes et langages'),
(96, 29, 31, 36, 'G4S2 - Communiquer en anglais'),
(97, 29, 21, 31, 'G4S2 - Analyse et méthodes numériques'),
(98, 29, 38, 27, 'G4S2 - Programmation d\'IHM'),
(99, 29, 39, 26, 'G4S2 - Ergonomie'),
(100, 29, 27, 33, 'G4S2 - Environnement juridique'),
(101, 29, 33, 23, 'G4S2 - Java'),
(102, 29, 37, 21, 'G4S2 - Architecture des réseaux'),
(103, 29, 40, 22, 'G4S2 - SDD'),
(104, 29, 41, 34, 'G4S2 - Gestion de projet informatique');

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

DROP TABLE IF EXISTS `groupe`;
CREATE TABLE IF NOT EXISTS `groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semestre_id` int(11) DEFAULT NULL,
  `groupFullName` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `group_name_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4B98C215577AFDB` (`semestre_id`),
  KEY `IDX_4B98C21F717C8DA` (`group_name_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `groupe`
--

INSERT INTO `groupe` (`id`, `semestre_id`, `groupFullName`, `group_name_id`) VALUES
(2, 5, 'G2S1', 2),
(3, 5, 'G3S1', 3),
(4, 5, 'G4S1', 4),
(5, 5, 'G5S1', 5),
(8, 7, 'G1S2', 1),
(26, 5, 'G1S1', 1),
(27, 7, 'G2S2', 2),
(28, 7, 'G3S2', 3),
(29, 7, 'G4S2', 4);

-- --------------------------------------------------------

--
-- Structure de la table `groupe_student`
--

DROP TABLE IF EXISTS `groupe_student`;
CREATE TABLE IF NOT EXISTS `groupe_student` (
  `groupe_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`groupe_id`,`student_id`),
  KEY `IDX_7144487D7A45358C` (`groupe_id`),
  KEY `IDX_7144487DCB944F1A` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `groupe_student`
--

INSERT INTO `groupe_student` (`groupe_id`, `student_id`) VALUES
(2, 5),
(2, 742),
(2, 743),
(2, 744),
(2, 745),
(2, 746),
(2, 747),
(2, 748),
(2, 749),
(2, 750),
(2, 751),
(2, 752),
(2, 753),
(2, 754),
(2, 755),
(2, 756),
(2, 757),
(2, 758),
(2, 759),
(2, 760),
(2, 761),
(2, 762),
(2, 763),
(2, 764),
(2, 765),
(2, 766),
(2, 767),
(2, 768),
(2, 769),
(3, 4),
(3, 694),
(3, 695),
(3, 696),
(3, 697),
(3, 698),
(3, 699),
(3, 700),
(3, 701),
(3, 702),
(3, 703),
(3, 704),
(3, 705),
(3, 706),
(3, 707),
(3, 708),
(3, 709),
(3, 710),
(3, 711),
(3, 712),
(3, 713),
(3, 714),
(3, 715),
(3, 716),
(3, 717),
(4, 770),
(4, 771),
(4, 772),
(4, 773),
(4, 774),
(4, 775),
(4, 776),
(4, 777),
(4, 778),
(4, 779),
(4, 780),
(4, 781),
(4, 782),
(4, 783),
(4, 784),
(4, 785),
(4, 786),
(4, 787),
(4, 788),
(4, 789),
(4, 790),
(4, 791),
(4, 792),
(4, 793),
(4, 794),
(4, 795),
(4, 796),
(4, 797),
(5, 5),
(5, 666),
(5, 667),
(5, 668),
(5, 669),
(5, 670),
(5, 671),
(5, 672),
(5, 673),
(5, 674),
(5, 675),
(5, 676),
(5, 677),
(5, 678),
(5, 679),
(5, 680),
(5, 681),
(5, 682),
(5, 683),
(5, 684),
(5, 685),
(5, 686),
(5, 687),
(5, 688),
(5, 689),
(5, 690),
(5, 691),
(5, 692),
(5, 693),
(8, 5),
(8, 667),
(8, 670),
(8, 671),
(8, 676),
(8, 681),
(8, 689),
(8, 690),
(8, 691),
(8, 693),
(8, 694),
(8, 696),
(8, 700),
(8, 707),
(8, 712),
(8, 718),
(8, 725),
(8, 727),
(8, 729),
(8, 742),
(8, 747),
(8, 752),
(8, 754),
(8, 761),
(8, 762),
(8, 765),
(8, 783),
(8, 787),
(8, 795),
(8, 796),
(26, 2),
(26, 718),
(26, 719),
(26, 720),
(26, 721),
(26, 722),
(26, 723),
(26, 724),
(26, 725),
(26, 726),
(26, 727),
(26, 728),
(26, 729),
(26, 730),
(26, 731),
(26, 732),
(26, 733),
(26, 734),
(26, 735),
(26, 736),
(26, 737),
(26, 738),
(26, 739),
(26, 740),
(26, 741),
(27, 666),
(27, 668),
(27, 678),
(27, 679),
(27, 680),
(27, 682),
(27, 685),
(27, 698),
(27, 701),
(27, 703),
(27, 704),
(27, 706),
(27, 721),
(27, 722),
(27, 726),
(27, 731),
(27, 741),
(27, 746),
(27, 748),
(27, 750),
(27, 758),
(27, 760),
(27, 767),
(27, 772),
(27, 786),
(27, 788),
(27, 791),
(27, 794),
(28, 673),
(28, 683),
(28, 684),
(28, 686),
(28, 708),
(28, 714),
(28, 716),
(28, 728),
(28, 730),
(28, 733),
(28, 736),
(28, 740),
(28, 749),
(28, 751),
(28, 755),
(28, 759),
(28, 763),
(28, 764),
(28, 768),
(28, 769),
(28, 773),
(28, 780),
(28, 781),
(28, 784),
(28, 785),
(28, 789),
(28, 790),
(28, 797),
(29, 669),
(29, 674),
(29, 675),
(29, 677),
(29, 687),
(29, 692),
(29, 697),
(29, 705),
(29, 709),
(29, 710),
(29, 711),
(29, 717),
(29, 720),
(29, 724),
(29, 735),
(29, 739),
(29, 744),
(29, 745),
(29, 753),
(29, 756),
(29, 757),
(29, 766),
(29, 770),
(29, 774),
(29, 775),
(29, 776),
(29, 777),
(29, 778),
(29, 792);

--
-- Structure de la table `module`
--

DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moduleCode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `moduleName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `moduleFullName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `module`
--

INSERT INTO `module` (`id`, `moduleCode`, `moduleName`, `moduleFullName`) VALUES
(1, 'M1101', 'Introduction aux systèmes informatiques', 'M1101 Introduction aux systèmes informatiques'),
(2, 'M1102', 'Introduction à l\'algorithmique et à la programmation', 'M1102 Introduction à l\'algorithmique et à la programmation'),
(3, 'M1103', 'Structures de données et algorithmes fondamentaux', 'M1103 Structures de données et algorithmes fondamentaux'),
(4, 'M1104', 'Introduction aux bases de données', 'M1104 Introduction aux bases de données'),
(5, 'M1105', 'Conception de documents et d\'interfaces numériques', 'M1105 Conception de documents et d\'interfaces numériques'),
(6, 'M1106', 'Projet tutoré – Découverte', 'M1106 Projet tutoré – Découverte'),
(7, 'M1201', 'Mathématiques discrètes', 'M1201 Mathématiques discrètes'),
(8, 'M1202', 'Algèbre linéaire', 'M1202 Algèbre linéaire'),
(9, 'M1203', 'Environnement économique', 'M1203 Environnement économique'),
(10, 'M1204', 'Fonctionnement des organisations', 'M1204 Fonctionnement des organisations'),
(11, 'M1205', 'Expression-Communication – Fondamentaux de la communication', 'M1205 Expression-Communication – Fondamentaux de la communication'),
(12, 'M1206', 'Anglais et Informatique', 'M1206 Anglais et Informatique'),
(13, 'M1207', 'PPP - Connaître le monde professionnel', 'M1207 PPP - Connaître le monde professionnel'),
(14, 'M2101', 'Architecture et programmation des mécanismes de base d\'un système informatique', 'M2101 Architecture et programmation des mécanismes de base d\'un système informatique'),
(15, 'M2102', 'Architecture des réseaux', 'M2102 Architecture des réseaux'),
(16, 'M2103', 'Bases de la programmation orientée objet', 'M2103 Bases de la programmation orientée objet'),
(17, 'M2104', 'Bases de la conception orientée objet', 'M2104 Bases de la conception orientée objet'),
(18, 'M2105', 'Introduction aux interfaces homme-machine (IHM)', 'M2105 Introduction aux interfaces homme-machine (IHM)'),
(19, 'M2106', 'Programmation et administration des bases de données', 'M2106 Programmation et administration des bases de données'),
(20, 'M2107', 'Projet tutoré – Description et planification de projet', 'M2107 Projet tutoré – Description et planification de projet'),
(21, 'M2201', 'Graphes et langages', 'M2201 Graphes et langages'),
(22, 'M2202', 'Analyse et méthodes numériques', 'M2202 Analyse et méthodes numériques'),
(23, 'M2203', 'Environnement comptable, financier, juridique et social', 'M2203 Environnement comptable, financier, juridique et social'),
(24, 'M2204', 'Gestion de projet informatique', 'M2204 Gestion de projet informatique'),
(25, 'M2205', 'Expression-Communication – Communication, information et argumentation', 'M2205 Expression-Communication – Communication, information et argumentation'),
(26, 'M2206', 'Communiquer en anglais', 'M2206 Communiquer en anglais'),
(27, 'M2207', 'PPP – Identifier ses compétences', 'M2207 PPP – Identifier ses compétences'),
(28, 'M3101', 'Principes des systèmes d\'exploitation', 'M3101 Principes des systèmes d\'exploitation'),
(29, 'M3102', 'Services réseaux', 'M3102 Services réseaux'),
(30, 'M3103', 'Algorithmique avancée', 'M3103 Algorithmique avancée'),
(31, 'M3104', 'Programmation Web côté serveur', 'M3104 Programmation Web côté serveur'),
(32, 'M3105', 'Conception et programmation objet avancées', 'M3105 Conception et programmation objet avancées'),
(33, 'M3106C', 'Bases de données avancées', 'M3106C Bases de données avancées'),
(34, 'M3201', 'Probabilités et statistiques', 'M3201 Probabilités et statistiques'),
(35, 'M3202C', 'Modélisations mathématiques', 'M3202C Modélisations mathématiques'),
(36, 'M3203', 'Droit des technologies de l’information et de la communication (TIC)', 'M3203 Droit des technologies de l’information et de la communication (TIC)'),
(37, 'M3204', 'Gestion des systèmes d\'information', 'M3204 Gestion des systèmes d\'information'),
(38, 'M3205', 'Expression-Communication – Communication professionnelle', 'M3205 Expression-Communication – Communication professionnelle'),
(39, 'M3206', 'Collaborer en anglais', 'M3206 Collaborer en anglais'),
(40, 'M3301', 'Méthodologie de la production d’applications', 'M3301 Méthodologie de la production d’applications'),
(41, 'M3302', 'Projet tutoré – Mise en situation professionnelle', 'M3302 Projet tutoré – Mise en situation professionnelle'),
(42, 'M3303', 'PPP – Préciser son projet', 'M3303 PPP – Préciser son projet'),
(43, 'M4101C', 'Administration système et réseau', 'M4101C Administration système et réseau'),
(44, 'M4102C', 'Programmation répartie', 'M4102C Programmation répartie'),
(45, 'M4103C', 'Programmation Web – client riche', 'M4103C Programmation Web – client riche'),
(46, 'M4104C', 'Conception et développement d’applications mobiles', 'M4104C Conception et développement d’applications mobiles'),
(47, 'M4105C', 'Compléments d’informatique en vue d’une insertion immédiate', 'M4105C Compléments d’informatique en vue d’une insertion immédiate'),
(48, 'M4106', 'Projet tutoré – Compléments', 'M4106 Projet tutoré – Compléments'),
(49, 'M4201C', 'Ateliers de création d\'entreprise', 'M4201C Ateliers de création d\'entreprise'),
(50, 'M4202C', 'Recherche opérationnelle et aide à la décision', 'M4202C Recherche opérationnelle et aide à la décision'),
(51, 'M4203', 'Expression-communication – Communiquer dans les organisations', 'M4203 Expression-communication – Communiquer dans les organisations'),
(52, 'M4204', 'Travailler en anglais', 'M4204 Travailler en anglais'),
(53, 'M4301', 'Stage professionnel', 'M4301 Stage professionnel');

-- --------------------------------------------------------

--
-- Structure de la table `module_subject`
--

DROP TABLE IF EXISTS `module_subject`;
CREATE TABLE IF NOT EXISTS `module_subject` (
  `module_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  PRIMARY KEY (`module_id`,`subject_id`),
  KEY `IDX_50B50063AFC2B591` (`module_id`),
  KEY `IDX_50B5006323EDC87` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `module_subject`
--

INSERT INTO `module_subject` (`module_id`, `subject_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 5),
(3, 6),
(3, 7),
(4, 8),
(4, 9),
(5, 10),
(5, 11),
(6, 12),
(7, 13),
(8, 14),
(9, 15),
(10, 16),
(11, 17),
(12, 18),
(13, 19),
(14, 20),
(15, 21),
(16, 22),
(16, 23),
(17, 24),
(17, 25),
(18, 26),
(18, 27),
(19, 28),
(20, 29),
(21, 30),
(22, 31),
(23, 32),
(24, 33),
(24, 34),
(25, 35),
(26, 36),
(27, 37),
(28, 38),
(28, 39),
(29, 40),
(30, 41),
(31, 42),
(31, 43),
(32, 44),
(33, 45),
(34, 46),
(35, 47),
(36, 48),
(37, 49),
(37, 50),
(38, 51),
(39, 52),
(40, 53),
(40, 54),
(41, 55),
(42, 56);

-- --------------------------------------------------------

--
-- Structure de la table `option_controller`
--

DROP TABLE IF EXISTS `option_controller`;
CREATE TABLE IF NOT EXISTS `option_controller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller_id` int(11) NOT NULL,
  `nomOption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tips` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A19B7EAAF6D1A74B` (`controller_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `option_controller`
--

INSERT INTO `option_controller` (`id`, `controller_id`, `nomOption`, `value`, `tips`) VALUES
(1, 9, 'Position du nom du DS', 'A1', 'La valeur doit être du type \"A1\"'),
(2, 9, 'Position du nom du groupe', 'A2', 'La valeur doit être du type \"A1\"'),
(3, 9, 'Position du numero étudiant', 'A3', 'La valeur doit être du type \"A1\"'),
(4, 9, 'Position du nom de l\'étudiant', 'B3', 'La valeur doit être du type \"A1\"'),
(5, 9, 'Position du prénom de l\'étudiant', 'C3', 'La valeur doit être du type \"A1\"'),
(6, 9, 'Position de la note', 'D3', 'La valeur doit être du type \"A1\"');

-- --------------------------------------------------------

--
-- Structure de la table `promo`
--

DROP TABLE IF EXISTS `promo`;
CREATE TABLE IF NOT EXISTS `promo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semestre_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `promoName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B0139AFB5577AFDB` (`semestre_id`),
  KEY `IDX_B0139AFB23EDC87` (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `promo`
--

INSERT INTO `promo` (`id`, `semestre_id`, `subject_id`, `promoName`) VALUES
(2, 5, 1, 'S1 - M1101-1 Architecture'),
(3, 5, 5, 'S1 - M1102-2 C Introduction'),
(4, 7, 23, 'S2 - M2103-2 Java'),
(7, 5, 13, 'S1 - M1201 Mathématiques discrètes'),
(8, 5, 8, 'S1 - M1104-1 MDD'),
(9, 5, 16, 'S1 - M1204 Fonctionnement des organisations'),
(10, 5, 2, 'S1 - M1101-2 Initiation Windows'),
(11, 5, 9, 'S1 - M1104-2 SQL'),
(12, 5, 3, 'S1 - M1101-3 Initiation Linux'),
(13, 5, 14, 'S1 - M1202 Algèbre linéaire'),
(14, 5, 18, 'S1 - M1206 Anglais et Informatique'),
(15, 5, 17, 'S1 - M1205 Expression-Communication – Fondamentaux de la communication'),
(16, 5, 10, 'S1 - M1105-Web Web'),
(17, 5, 11, 'S1 - M1105-Com Documents numériques'),
(18, 5, 19, 'S1 - M1207 PPP - Connaître le monde professionnel'),
(19, 5, 15, 'S1 - M1203 Environnement économique'),
(20, 7, 28, 'S2 - M2106 Programmation et administration des bases de données'),
(21, 7, 37, 'S2 - M2207 PPP – Identifier ses compétences'),
(22, 7, 35, 'S2 - M2205 Expression-Communication – Communication, information et argumentation'),
(23, 7, 31, 'S2 - M2202 Analyse et méthodes numériques'),
(24, 7, 32, 'S2 - M2203 Environnement comptable, financier, juridique et social'),
(25, 7, 30, 'S2 - M2201 Graphes et langages'),
(26, 7, 36, 'S2 - M2206 Communiquer en anglais'),
(27, 7, 24, 'S2 - M2104-1 Cycle de vie du développement d\'application'),
(28, 7, 25, 'S2 - M2104-2 UML'),
(29, 7, 20, 'S2 - M2101 Architecture et programmation des mécanismes de base d\'un système informatique'),
(30, 7, 27, 'S2 - M2105-2 Programmation d\'IHM'),
(31, 7, 26, 'S2 - M2105-1 Ergonomie'),
(32, 7, 33, 'S2 - M2204-1 Environnement juridique'),
(33, 7, 21, 'S2 - M2102 Architecture des réseaux'),
(34, 7, 22, 'S2 - M2103-1 SDD'),
(35, 7, 34, 'S2 - M2204-2 Gestion de projet informatique');

-- --------------------------------------------------------

--
-- Structure de la table `secretariat`
--

DROP TABLE IF EXISTS `secretariat`;
CREATE TABLE IF NOT EXISTS `secretariat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F0C364B5A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `secretariat`
--

INSERT INTO `secretariat` (`id`, `user_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `semestre`
--

DROP TABLE IF EXISTS `semestre`;
CREATE TABLE IF NOT EXISTS `semestre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `schoolYear` int(11) NOT NULL,
  `delay` tinyint(1) NOT NULL,
  `semestreFullName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `beginDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_71688FBC591CC992` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `semestre`
--

INSERT INTO `semestre` (`id`, `course_id`, `schoolYear`, `delay`, `semestreFullName`, `beginDate`, `endDate`) VALUES
(5, 1, 2018, 0, '2018 S1 - Normal', '2018-09-01 00:00:00', '2019-02-02 00:00:00'),
(7, 2, 2019, 0, '2019 S2 - Normal', '2019-01-30 00:00:00', '2019-06-30 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `numStudent` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B723AF33A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=798 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `student`
--

INSERT INTO `student` (`id`, `user_id`, `numStudent`) VALUES
(2, 3, 'p1705632'),
(4, 6, 'p1789562'),
(5, 7, 'p1723568'),
(666, 829, 'p1804920'),
(667, 830, 'p1806052'),
(668, 831, 'p1804229'),
(669, 832, 'p1806213'),
(670, 833, 'p1804713'),
(671, 834, 'p1804835'),
(672, 835, 'p1803365'),
(673, 836, 'p1801979'),
(674, 837, 'p1812347'),
(675, 838, 'p1804238'),
(676, 839, 'p1806351'),
(677, 840, 'p1807341'),
(678, 841, 'p1806674'),
(679, 842, 'p1806822'),
(680, 843, 'p1806158'),
(681, 844, 'p1802266'),
(682, 845, 'p1802456'),
(683, 846, 'p1812104'),
(684, 847, 'p1800666'),
(685, 848, 'p1801690'),
(686, 849, 'p1804807'),
(687, 850, 'p1806612'),
(688, 851, 'p1800363'),
(689, 852, 'p1806493'),
(690, 853, 'p1805596'),
(691, 854, 'p1803998'),
(692, 855, 'p1801713'),
(693, 856, 'p1808399'),
(694, 857, 'p1804939'),
(695, 858, 'p1806332'),
(696, 859, 'p1802210'),
(697, 860, 'p1803502'),
(698, 861, 'p1802858'),
(699, 862, 'p1808077'),
(700, 863, 'p1800744'),
(701, 864, 'p1807470'),
(702, 865, 'p1800218'),
(703, 866, 'p1714018'),
(704, 867, 'p1801135'),
(705, 868, 'p1801045'),
(706, 869, 'p1807638'),
(707, 870, 'p1806764'),
(708, 871, 'p1804207'),
(709, 872, 'p1801627'),
(710, 873, 'p1801869'),
(711, 874, 'p1802436'),
(712, 875, 'p1801981'),
(713, 876, 'p1804744'),
(714, 877, 'p1800849'),
(715, 878, 'p1807684'),
(716, 879, 'p1804503'),
(717, 880, 'p1807249'),
(718, 881, 'p1800576'),
(719, 882, 'p1807201'),
(720, 883, 'p1806029'),
(721, 884, 'p1803816'),
(722, 885, 'p1806102'),
(723, 886, 'p1805403'),
(724, 887, 'p1801372'),
(725, 888, 'p1805285'),
(726, 889, 'p1802235'),
(727, 890, 'p1804704'),
(728, 891, 'p1806287'),
(729, 892, 'p1800869'),
(730, 893, 'p1808155'),
(731, 894, 'p1803227'),
(732, 895, 'p1807070'),
(733, 896, 'p1800621'),
(734, 897, 'p1807994'),
(735, 898, 'p1800639'),
(736, 899, 'p1810803'),
(737, 900, 'p1804634'),
(738, 901, 'p1804860'),
(739, 902, 'p1802574'),
(740, 903, 'p1809412'),
(741, 904, 'p1801551'),
(742, 905, 'p1803091'),
(743, 906, 'p1803858'),
(744, 907, 'p1800250'),
(745, 908, 'p1802498'),
(746, 909, 'p1804059'),
(747, 910, 'p1803980'),
(748, 911, 'p1802098'),
(749, 912, 'p1811220'),
(750, 913, 'p1804898'),
(751, 914, 'p1805935'),
(752, 915, 'p1806978'),
(753, 916, 'p1802404'),
(754, 917, 'p1801454'),
(755, 918, 'p1801444'),
(756, 919, 'p1810882'),
(757, 920, 'p1800946'),
(758, 921, 'p1801234'),
(759, 922, 'p1809561'),
(760, 923, 'p1803343'),
(761, 924, 'p1808057'),
(762, 925, 'p1805896'),
(763, 926, 'p1805041'),
(764, 927, 'p1808171'),
(765, 928, 'p1812047'),
(766, 929, 'p1422359'),
(767, 930, 'p1806530'),
(768, 931, 'p1801008'),
(769, 932, 'p1812167'),
(770, 933, 'p1802162'),
(771, 934, 'p1812028'),
(772, 935, 'p1801076'),
(773, 936, 'p1801970'),
(774, 937, 'p1804884'),
(775, 938, 'p1805797'),
(776, 939, 'p1711577'),
(777, 940, 'p1801229'),
(778, 941, 'p1805864'),
(779, 942, 'p1806846'),
(780, 943, 'p1804134'),
(781, 944, 'p1801978'),
(782, 945, 'p1809617'),
(783, 946, 'p1801906'),
(784, 947, 'p1807220'),
(785, 948, 'p1805931'),
(786, 949, 'p1804383'),
(787, 950, 'p1800907'),
(788, 951, 'p1805738'),
(789, 952, 'p1802145'),
(790, 953, 'p1801835'),
(791, 954, 'p1808438'),
(792, 955, 'p1806451'),
(793, 956, 'p1809576'),
(794, 957, 'p1801601'),
(795, 958, 'p1810980'),
(796, 959, 'p1808627'),
(797, 960, 'p1802277');

-- --------------------------------------------------------

--
-- Structure de la table `subject`
--

DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subjectCode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `subjectName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subjectCoefficient` decimal(10,2) NOT NULL,
  `subjectFullName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_FBCE3E7A8246C690` (`subjectCode`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `subject`
--

INSERT INTO `subject` (`id`, `subjectCode`, `subjectName`, `subjectCoefficient`, `subjectFullName`) VALUES
(1, 'M1101-1', 'Architecture', '1.50', 'M1101-1 Architecture'),
(2, 'M1101-2', 'Initiation Windows', '1.00', 'M1101-2 Initiation Windows'),
(3, 'M1101-3', 'Initiation Linux', '1.00', 'M1101-3 Initiation Linux'),
(4, 'M1102-1', 'Algorithmique 1', '1.70', 'M1102-1 Algorithmique 1'),
(5, 'M1102-2', 'C Introduction', '1.80', 'M1102-2 C Introduction'),
(6, 'M1103-1', 'Algorithmique 2', '1.20', 'M1103-1 Algorithmique 2'),
(7, 'M1103-2', 'C Avancé', '1.30', 'M1103-2 C Avancé'),
(8, 'M1104-1', 'MDD', '1.70', 'M1104-1 MDD'),
(9, 'M1104-2', 'SQL', '1.80', 'M1104-2 SQL'),
(10, 'M1105-Web', 'Web', '1.70', 'M1105-1 Web'),
(11, 'M1105-COM', 'Documents numériques', '0.80', 'M1105-2 Documents numériques'),
(12, 'M1106', 'Projet tutoré – Découverte', '1.50', 'M1106 Projet tutoré – Découverte'),
(13, 'M1201', 'Mathématiques discrètes', '2.50', 'M1201 Mathématiques discrètes'),
(14, 'M1202', 'Algèbre linéaire', '2.00', 'M1202 Algèbre linéaire'),
(15, 'M1203', 'Environnement économique', '1.50', 'M1203 Environnement économique'),
(16, 'M1204', 'Fonctionnement des organisations', '2.50', 'M1204 Fonctionnement des organisations'),
(17, 'M1205', 'Expression-Communication – Fondamentaux de la communication', '2.00', 'M1205 Expression-Communication – Fondamentaux de la communication'),
(18, 'M1206', 'Anglais et Informatique', '1.50', 'M1206 Anglais et Informatique'),
(19, 'M1207', 'PPP - Connaître le monde professionnel', '1.00', 'M1207 PPP - Connaître le monde professionnel'),
(20, 'M2101', 'Architecture et programmation des mécanismes de base d\'un système informatique', '1.50', 'M2101 Architecture et programmation des mécanismes de base d\'un système informatique'),
(21, 'M2102-1', 'Architecture des réseaux', '1.50', 'M2102 Architecture des réseaux'),
(22, 'M2103-SDD', 'SDD', '1.00', 'M2103-1 SDD'),
(23, 'M2103-Java', 'Java', '2.50', 'M2103-2 Java'),
(24, 'M2104-1', 'Cycle de vie du développement d\'application', '1.25', 'M2104-1 Cycle de vie du développement d\'application'),
(25, 'M2104-2', 'UML', '1.25', 'M2104-2 UML'),
(26, 'M2105', 'Ergonomie', '1.00', 'M2105-1 Ergonomie'),
(27, 'M2105-Prog', 'Programmation d\'IHM', '1.50', 'M2105-Prog Programmation d\'IHM'),
(28, 'M2106', 'Programmation et administration des bases de données', '2.50', 'M2106 Programmation et administration des bases de données'),
(29, 'M2107', 'Projet tutoré – Description et planification de projet', '2.00', 'M2107 Projet tutoré – Description et planification de projet'),
(30, 'M2201', 'Graphes et langages', '2.50', 'M2201 Graphes et langages'),
(31, 'M2202', 'Analyse et méthodes numériques', '2.00', 'M2202 Analyse et méthodes numériques'),
(32, 'M2203', 'Environnement comptable, financier, juridique et social', '3.00', 'M2203 Environnement comptable, financier, juridique et social'),
(33, 'M2204', 'Environnement juridique', '0.75', 'M2204-1 Environnement juridique'),
(34, 'M2204.2', 'Gestion de projet informatique', '0.75', 'M2204-2 Gestion de projet informatique'),
(35, 'M2205', 'Expression-Communication – Communication, information et argumentation', '1.50', 'M2205 Expression-Communication – Communication, information et argumentation'),
(36, 'M2206', 'Communiquer en anglais', '2.50', 'M2206 Communiquer en anglais'),
(37, 'M2207', 'PPP – Identifier ses compétences', '1.00', 'M2207 PPP – Identifier ses compétences'),
(38, 'M3101-1', 'Systèmes d\'exploitation - Cours', '1.50', 'M3101-1 Systèmes d\'exploitation - Cours'),
(39, 'M3101-2', 'Systèmes d\'exploitation - TP', '1.00', 'M3101-2 Systèmes d\'exploitation - TP'),
(40, 'M3102', 'Services réseaux', '1.50', 'M3102 Services réseaux'),
(41, 'M3103', 'Algorithmique avancée', '1.50', 'M3103 Algorithmique avancée'),
(42, 'M3104-1', 'PHP', '1.50', 'M3104-1 PHP'),
(43, 'M3104-2', 'JAVA', '1.00', 'M3104-2 JAVA'),
(44, 'M3105', 'Conception et programmation objet avancées', '2.50', 'M3105 Conception et programmation objet avancées'),
(45, 'M3106C', 'Base de données avancées', '1.50', 'M3106C Base de données avancées'),
(46, 'M3201', 'Probabilités et statistiques', '2.50', 'M3201 Probabilités et statistiques'),
(47, 'M3202C', 'Modélisation mathématiques', '1.50', 'M3202C Modélisation mathématiques'),
(48, 'M3203', 'Droit des technologies de l\'info & de la communication', '1.50', 'M3203 Droit des technologies de l\'info & de la communication'),
(49, 'M3204-1', 'Gestion des systèmes d\'information - Partie 1', '1.30', 'M3204-1 Gestion des systèmes d\'information - Partie 1'),
(50, 'M3204-2', 'Gestion des systèmes d\'information - Partie 2', '1.20', 'M3204-2 Gestion des systèmes d\'information - Partie 2'),
(51, 'M3205', 'Expression-Communication – Communication professionnelle', '1.50', 'M3205 Expression-Communication – Communication professionnelle'),
(52, 'M3206', 'Collaborer en anglais', '2.50', 'M3206 Collaborer en anglais'),
(53, 'M3301-1', 'Modélisation des processus', '1.80', 'M3301-1 Modélisation des processus'),
(54, 'M3301-2', 'Partie EGO', '1.20', 'M3301-2 Partie EGO'),
(55, 'M3302', 'Projet tutoré – Mise en situation professionnelle', '2.00', 'M3302 Projet tutoré – Mise en situation professionnelle'),
(56, 'M3303', 'PPP – Préciser son projet', '1.00', 'M3303 PPP – Préciser son projet');

-- --------------------------------------------------------

--
-- Structure de la table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B0F6A6D5A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `teacher`
--

INSERT INTO `teacher` (`id`, `user_id`) VALUES
(1, 2),
(2, 4),
(6, 966),
(5, 967),
(3, 968),
(4, 969),
(7, 970),
(8, 971),
(9, 972),
(10, 973),
(11, 974),
(12, 975),
(13, 976),
(14, 977),
(15, 978),
(16, 979),
(17, 980),
(18, 981),
(19, 982),
(20, 983),
(21, 984),
(22, 985),
(23, 986),
(24, 987),
(25, 988),
(27, 990),
(28, 992),
(29, 993),
(30, 994),
(31, 996),
(32, 997),
(33, 998),
(34, 999),
(35, 1000),
(36, 1001),
(37, 1002),
(38, 1003),
(39, 1004),
(40, 1005),
(41, 1006);

-- --------------------------------------------------------

--
-- Structure de la table `teacher_subject`
--

DROP TABLE IF EXISTS `teacher_subject`;
CREATE TABLE IF NOT EXISTS `teacher_subject` (
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  PRIMARY KEY (`teacher_id`,`subject_id`),
  KEY `IDX_360CB33B41807E1D` (`teacher_id`),
  KEY `IDX_360CB33B23EDC87` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `teacher_subject`
--

INSERT INTO `teacher_subject` (`teacher_id`, `subject_id`) VALUES
(1, 1),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 22),
(1, 23),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 6),
(3, 2),
(3, 3),
(3, 9),
(3, 25),
(3, 28),
(4, 13),
(4, 14),
(4, 30),
(4, 31),
(5, 16),
(6, 8),
(6, 9),
(7, 17),
(7, 35),
(7, 37),
(8, 1),
(8, 20),
(9, 18),
(9, 36),
(10, 8),
(11, 3),
(11, 28),
(12, 13),
(12, 14),
(12, 30),
(13, 16),
(13, 32),
(14, 17),
(14, 35),
(15, 2),
(16, 17),
(17, 8),
(18, 16),
(19, 2),
(20, 3),
(21, 13),
(21, 14),
(21, 31),
(22, 9),
(23, 3),
(24, 10),
(25, 11),
(27, 15),
(27, 33),
(28, 19),
(28, 37),
(29, 1),
(29, 20),
(30, 19),
(31, 36),
(32, 24),
(33, 23),
(33, 25),
(33, 28),
(34, 24),
(35, 25),
(35, 28),
(36, 32),
(37, 20),
(37, 21),
(38, 27),
(39, 26),
(40, 22),
(41, 34);

-- --------------------------------------------------------

--
-- Structure de la table `teaching_unit`
--

DROP TABLE IF EXISTS `teaching_unit`;
CREATE TABLE IF NOT EXISTS `teaching_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teachingUnitCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `teachingUnitName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `creationYear` int(11) NOT NULL,
  `teachingUnitFullName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `teaching_unit`
--

INSERT INTO `teaching_unit` (`id`, `teachingUnitCode`, `teachingUnitName`, `creationYear`, `teachingUnitFullName`) VALUES
(1, 'UE11', 'Bases de l’informatique', 2013, '2013 UE11 - Bases de l’informatique'),
(2, 'UE12', 'Bases de culture scientifique, sociale et humaine', 2013, '2013 UE12 - Bases de culture scientifique, sociale et humaine'),
(3, 'UE21', 'Approfondissements en informatique', 2013, '2013 UE21 - Approfondissements en informatique'),
(4, 'UE22', 'Approfondissements en culture scientifique, sociale et humaine', 2013, '2013 UE22 - Approfondissements en culture scientifique, sociale et humaine'),
(5, 'UE31', 'Informatique avancée', 2013, '2013 UE31 - Informatique avancée'),
(6, 'UE32', 'Culture scientifique, sociale et humaine avancées', 2013, '2013 UE32 - Culture scientifique, sociale et humaine avancées'),
(7, 'UE33', 'Méthodologie et Projets', 2013, '2013 UE33 - Méthodologie et Projets'),
(8, 'UE41', 'Compléments d’informatique', 2013, '2013 UE41 - Compléments d’informatique'),
(9, 'UE42', 'Compléments de culture', 2013, '2013 UE42 - Compléments de culture'),
(10, 'UE43', 'Mise en situation professionnelle', 2013, '2013 UE43 - Mise en situation professionnelle');

-- --------------------------------------------------------

--
-- Structure de la table `teaching_unit_module`
--

DROP TABLE IF EXISTS `teaching_unit_module`;
CREATE TABLE IF NOT EXISTS `teaching_unit_module` (
  `teaching_unit_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`teaching_unit_id`,`module_id`),
  KEY `IDX_7D7B1F52F82B390` (`teaching_unit_id`),
  KEY `IDX_7D7B1F5AFC2B591` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `teaching_unit_module`
--

INSERT INTO `teaching_unit_module` (`teaching_unit_id`, `module_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(3, 14),
(3, 15),
(3, 16),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(4, 21),
(4, 22),
(4, 23),
(4, 24),
(4, 25),
(4, 26),
(4, 27),
(5, 28),
(5, 29),
(5, 30),
(5, 31),
(5, 32),
(5, 33),
(6, 34),
(6, 35),
(6, 36),
(6, 37),
(6, 38),
(6, 39),
(7, 40),
(7, 41),
(7, 42),
(8, 43),
(8, 44),
(8, 45),
(8, 46),
(8, 47),
(8, 48),
(9, 49),
(9, 50),
(9, 51),
(9, 52),
(10, 53);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `surname_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`)
) ENGINE=InnoDB AUTO_INCREMENT=1008 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `name`, `surname`, `name_canonical`, `surname_canonical`) VALUES
(1, 'secretariat', 'secretariat', 'nathan@iutinfo.fr', 'nathan@iutinfo.fr', 1, '8fIx3ca1YTVL7MsbNQt8dkSNKmddfuesmoBKnEeVYaU', 'S4TlswcJYIixRtGGKS80t5II5ApGeHDycl0bcyfTizv9dBsw2XJKecI9iAgwTxaFE1s6P0KKqkax8OU6AXtztw==', '2019-04-06 12:59:17', NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SECRETARIAT\";}', '', '', '', ''),
(2, 'richard.hardouin', 'richard.hardouin', 'rich@info.fr', 'rich@info.fr', 1, 'LtmgbCIkSuy9TP0pKtsZHkoenExQJasgOAIrZwJ4Nyk', 'SHSODd8KEZF2N2XjLP79jTw7Aw9i9JZxoog7QaRT/603U4ZLRTO6B2qsWXPTuxtskNmQ+9atMiND6YA+ofhqIw==', '2019-03-17 15:18:44', NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'Richard', 'Hardouin', 'richard', 'hardouin'),
(3, 'p1705632', 'p1705632', 'mich@info.fr', 'mich@info.fr', 1, 'GoE2.vEG4cQq0mYlxyIglrUFxccp6jpdMkyfZs/bEps', '6Km9U7HX+qgrh7bUVu42RbBPfzy0jbRa149DNJzj6xvAFqrSh3hNWoMUVfSS5tfUNnMLuNVSQHPR0SNiyOT+tQ==', '2019-01-24 10:21:44', NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Micheal', 'FERNANDEZ', 'micheal', 'fernandez'),
(4, 'john.arturo', 'john.arturo', 'natovoi@hotmail.fr', 'natovoi@hotmail.fr', 1, 'XdZ5rEBAftA8GjJn4yfDjKefMkExDb1vVZvzPHlw/nM', 'DlKcSKPAVsDylVcN9dWfPuwZxuU7ZFFley29xmGZ7wT78MIvS9EC6bMBLH3hlnlmH8lcPLiZawUG9GpULKPg0A==', '2018-10-16 10:19:15', NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'John', 'Arturo', 'john', 'arturo'),
(6, 'p1789562', 'p1789562', 'thomas@info.fr', 'thomas@info.fr', 1, '74peMAjNNMDR5neGof5DCQOHbh7zFIC.ENxC/eBlVPE', 'IpCn9pdXZ07kXFOgkTZd6wYfFZjHUbN5bXKOrLORODH5AATvNBsjOmgxdO7ea0GLwO/Sd9sAn56xM0LqXLRtKQ==', '2019-03-08 17:27:23', NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Thomas', 'JACQUES', 'thomas', 'jacques'),
(7, 'p1723568', 'p1723568', 'voviva@hotmail.fr', 'voviva@hotmail.fr', 1, 'Mw.ZnilZVXYHz44YX2zSd1USnLK4lGc7ESEURwmWCYc', 'wBDZbNELLRCQMa89m594p8/J4Cn05r0T0eGiPqvEtlfQtj4nAMEZnGEZ+yfl3PXVy/b2uaPTzpJSp2TI3aY5cA==', '2019-04-09 17:07:36', 'dFpseAxwW42s-HXoOQGWBSkVTtmB4i2_Ig5UlEeeZCs', '2018-11-26 08:27:59', 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Bérangé', 'MAYOUD', 'berange', 'mayoud'),
(829, 'p1804920', 'p1804920', 'ABOUCHI.Younes@etu.univ-lyon1.fr', 'abouchi.younes@etu.univ-lyon1.fr', 1, 'Egq5zAAcqTQKy74dkcIxRWUa7po/heBSZESLZRFTesU', 'rPgrD1wTl1j6H/1s5EgfF80t3hB0OqMeJ7RNW6xqLRRhVb8NePyAdxjpbSDEofGZ8jI9CW7T/mAA5erTZp2DNA==', '2019-01-23 23:26:30', NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Younes', 'ABOUCHI', 'younes', 'abouchi'),
(830, 'p1806052', 'p1806052', 'AL YACOUB.Angelo@etu.univ-lyon1.fr', 'al yacoub.angelo@etu.univ-lyon1.fr', 1, 'ZTwjSXQraFd6mMXa.a6NlMhQXBlV.B2xXRMHOy6Y5I4', 'ZWt1UcKDevg1PAhE3Or2/dJKu8TKE9r5U+V0hmaqKhgg6M5NyhbfYiTcPTwWDc2+l/9/xDYQB4y1VwSFBuR+vg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Angelo', 'AL YACOUB', 'angelo', 'al yacoub'),
(831, 'p1804229', 'p1804229', 'ALEXANDRE.Bastien@etu.univ-lyon1.fr', 'alexandre.bastien@etu.univ-lyon1.fr', 1, 'jyR8OIssUEgW.w87BHGxFp5Op4/oca.V1/vGpQJ0pBY', 'Ni564I4SBT6Gi+ELRXLEL+2a0c/CVnLZuoxWh7vGE2FrWSsgHw09tc6OvfIcYwHvgBHdxxeqNqzrz3ferLxNBg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Bastien', 'ALEXANDRE', 'bastien', 'alexandre'),
(832, 'p1806213', 'p1806213', 'AULAGNIER.Alexis@etu.univ-lyon1.fr', 'aulagnier.alexis@etu.univ-lyon1.fr', 1, 'eR04IqmBWKXG/SuRhaP.dD0yiygZuTJRbrX5Tt9sMzI', 'JqSjyCnfB9kZhfMJbF4hf9lRTKuTt6kuc9Sc6iSHFWKZekwlL5AjoZSaN5xTUYgQWxmyumhLQihdCIpVc2C6Iw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Alexis', 'AULAGNIER', 'alexis', 'aulagnier'),
(833, 'p1804713', 'p1804713', 'BEN HAMIDA.Hana@etu.univ-lyon1.fr', 'ben hamida.hana@etu.univ-lyon1.fr', 1, '74d6boVpGUgKOEKIH9ggJz00HqSwLoeMPWFKAmJUCZ8', 'dYkzuHlt4z6Of5Sum7CH/z7pAwdAY/AwX7vjWxJU3eT3u3SJ9dJrw5lBGE3ySnk3JYK21VlUgY3WEg4MD1321A==', '2019-03-08 17:31:38', NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Hana', 'BEN HAMIDA', 'hana', 'ben hamida'),
(834, 'p1804835', 'p1804835', 'CHAPUIS.Mathis@etu.univ-lyon1.fr', 'chapuis.mathis@etu.univ-lyon1.fr', 1, '25u1AIhUcuoOKsh0J90jjg7WJsIPORLHP3//Bx4riQw', 'uaIFyxJH0Wd6R/Aa2LepNKnk21p1sLCtDCBD81jjZaS27RT6C4VrnYm6NnjY3BUA/mItXIoLrdT5PB3JR9Ou6g==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Mathis', 'CHAPUIS', 'mathis', 'chapuis'),
(835, 'p1803365', 'p1803365', 'DEBOUTE.Adrien@etu.univ-lyon1.fr', 'deboute.adrien@etu.univ-lyon1.fr', 1, 'Y0wBcnZrTdrnhNxzUWsb4AfV1WL60A6Nzs/SVVt3.cw', 'jmBVmO3dQ/RLbmcNEbcT1mI6NadyyFhS3GuYmAKgl4U4Vi4y+pNQrhFirKUvT3wfBIOHgum45GOox4bnsewAQw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Adrien', 'DEBOUTE', 'adrien', 'deboute'),
(836, 'p1801979', 'p1801979', 'DÉCHER.Nathan@etu.univ-lyon1.fr', 'décher.nathan@etu.univ-lyon1.fr', 1, 'G/ZENNnVHp2upCtd9yo3tvpoC1KiK24WMp.6ZRWhd0w', 'mpICtJBV0hozHEhDjhDNqlIDy97PpWukeTzjKfT8rbwuyf/55/dxte4wFVT4KriPgzbULBv0ipjMDaY7hLOlSg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Nathan', 'DÉCHER', 'nathan', 'decher'),
(837, 'p1812347', 'p1812347', 'DIOUF.Samba Diarra@etu.univ-lyon1.fr', 'diouf.samba diarra@etu.univ-lyon1.fr', 1, 'cZIH.1rr6oc3U2IWPU1W9whHdL4kviTaLSsLZWKEFxs', 'tw6CcJbnnJ2tTgAXp20DFThYVmNAnM+O47PkD3zM6XywchayBpBXXudqfJIJV+guMtvR+nNGtQfn8yi4QorTbg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Samba Diarra', 'DIOUF', 'samba diarra', 'diouf'),
(838, 'p1804238', 'p1804238', 'GEOFFROY.Lucas@etu.univ-lyon1.fr', 'geoffroy.lucas@etu.univ-lyon1.fr', 1, 'FTK2QRajdBQWjWOf5qz44rpbtoP6ALOFZ2ZW27oDPPo', 'kUsilNDlQvC8QufUFMFVS2crpdIT++BFRjnvZJeREAJNcfJmyiiMqKcnTl6HYSa+0E9mjYCBQXHdN3tBcom3/Q==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Lucas', 'GEOFFROY', 'lucas', 'geoffroy'),
(839, 'p1806351', 'p1806351', 'GOMES-CORREIA.Maxime@etu.univ-lyon1.fr', 'gomes-correia.maxime@etu.univ-lyon1.fr', 1, 'HOTcJ0emh5.RgCI0bj8UT37Xcd5IP7pwDaSNhRbHoFo', 'SQpcZzs+fxE2zwDE6RmsPBAO1nBzbnkdPMV1UxhPXEzTHMht4Mez7sGLH11EMb8UTT0QiQxI0MLUUdrTkFxxjw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Maxime', 'GOMES-CORREIA', 'maxime', 'gomes-correia'),
(840, 'p1807341', 'p1807341', 'HERVIER.Thibault@etu.univ-lyon1.fr', 'hervier.thibault@etu.univ-lyon1.fr', 1, 'UBYz3HguoEbNRjMeXALrNVBDX6OE.o2ikCr342UBB1Q', '/mz/0X78yvQ48tDzw6/i1CubbEW/kTCmE3KFkXhNbfRhDiEjekstuv/3SLECvvl9JMMKF2A/KqmslXIr1YJfVg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Thibault', 'HERVIER', 'thibault', 'hervier'),
(841, 'p1806674', 'p1806674', 'HUBERT.Pierre@etu.univ-lyon1.fr', 'hubert.pierre@etu.univ-lyon1.fr', 1, '3WFRH/JJJ4ls7cmOZkNixetFrNeMXynZDUOD0AH9108', 'ZpRapeLsEKif6oqIDCV2VrxGb8N2c9iK2k8sjPJhq6gPzyVjEjxxK7krcufF8ugHQ3zojRsEAUAcvDlku1IGzQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Pierre', 'HUBERT', 'pierre', 'hubert'),
(842, 'p1806822', 'p1806822', 'LAVERRIERE.Fanch@etu.univ-lyon1.fr', 'laverriere.fanch@etu.univ-lyon1.fr', 1, '7Fc0DDt97Vt5WNANDFofsYPxsPpuKRcEaoYupaDBd8Y', 'kcdd29GUSCJG9+RFP8wJSY7jfrliduhRtHFyTBcDj6Vu1PgBB1upJs2oWlKTItZFU26EbQ6hP3HHSPDsWsoTlg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Fanch', 'LAVERRIERE', 'fanch', 'laverriere'),
(843, 'p1806158', 'p1806158', 'MAISONNETTE.Mathieu@etu.univ-lyon1.fr', 'maisonnette.mathieu@etu.univ-lyon1.fr', 1, 'wc5I3Wln5Es.jQPYdkOnOiQ7L7MQ.FXdBtnbFgWMTHM', 'dkNB/sdB4mp0XKOhIBaG838QSE2jRJEDE2ytmT+DUpLV7e+4jPmjc8VR/unwTYdlqVnl28ZpGpqtjfCGlqsb2A==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Mathieu', 'MAISONNETTE', 'mathieu', 'maisonnette'),
(844, 'p1802266', 'p1802266', 'MARCHAND.Roxane@etu.univ-lyon1.fr', 'marchand.roxane@etu.univ-lyon1.fr', 1, '8EzBUHef/xVvw6sW5fl7HUAHDFwuIoY7ldORCWMqIhA', 'rqRuhGo9mJeX6XYKKCDd/lXLGr63qw5MVlmn218ZDDzzXRNlr6jK84IIAHMLWO2HnekRuBe/yR4l/Omn3zB+8Q==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Roxane', 'MARCHAND', 'roxane', 'marchand'),
(845, 'p1802456', 'p1802456', 'MESEGUER.Axel@etu.univ-lyon1.fr', 'meseguer.axel@etu.univ-lyon1.fr', 1, 'nXQ2fY0OwbkDYag.DhgDzH6X/Et1aiN7NdivdqmsnGU', 'SZ9+YIP1UNxuqwgOyqIAacf4D9AQp+oCfCmCewN/CtYFASEd79ybrfv88NNQA8nDsClScDknbz6VAWaSYZw9lA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Axel', 'MESEGUER', 'axel', 'meseguer'),
(846, 'p1812104', 'p1812104', 'MONTERO.Thomas@etu.univ-lyon1.fr', 'montero.thomas@etu.univ-lyon1.fr', 1, 'Ahc7UvzQX3OaJ9NNentb/VHoecFuWxkidKRp8xvjlc0', 'KkX0rzWm/LOOV2UCwsw3YBHFV9FaMi+Ojw1Xjo7qeX7Xs+/583/NQn9EIqC2QISTLzC8xCtf9P8YnDiJjPdK8g==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Thomas', 'MONTERO', 'thomas', 'montero'),
(847, 'p1800666', 'p1800666', 'RAYMOND.Nicolas@etu.univ-lyon1.fr', 'raymond.nicolas@etu.univ-lyon1.fr', 1, 'cItDLO9PnSc6efB4rPx4H7G4THw5Gz84.f3vBr6JBC0', 'o16Ma3FR9WzMOVdJSbiyadHPFx6bPSfQ3y077PDOgqPpM+SaAeHJfhIVEeQI+90yKhYcoXXcSjtH6yTCprHmlw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Nicolas', 'RAYMOND', 'nicolas', 'raymond'),
(848, 'p1801690', 'p1801690', 'ROJKOVSKA.Julia@etu.univ-lyon1.fr', 'rojkovska.julia@etu.univ-lyon1.fr', 1, 'voK.UdIguO4HCOJeUyoa354TPGnAiUsO7MgpZqgOz4Y', 'kyh4xMQ5gTx3vhFZFZOSRA7tP0uKjqddo+6D79zyMAzEUwFIiUY5eBC1mybRAnmNiqLx/jh+EmvdPeFTPlDKvg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Julia', 'ROJKOVSKA', 'julia', 'rojkovska'),
(849, 'p1804807', 'p1804807', 'RUELEN.Marin@etu.univ-lyon1.fr', 'ruelen.marin@etu.univ-lyon1.fr', 1, 'pSvq6YWRFhG8y4KtkOipMuUeJ46QzJUVcOiZwJbvxls', 'HCBI1DtUx5kpNdCZdweNGtPVVC1zaUUPkB0RO8mX6vZPwveRfaTCXRAz/GWZrFLew6pCjaHx2GAufHpzj6ftpQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Marin', 'RUELEN', 'marin', 'ruelen'),
(850, 'p1806612', 'p1806612', 'RUSSIAS.Arthur@etu.univ-lyon1.fr', 'russias.arthur@etu.univ-lyon1.fr', 1, 'ZJhcrZj1K4nXVkQVCxtFLQVEeDJb/kPqjjX5LP4EXNY', 't5hN6eMWbRLBGgE16oDcc1YCgVOrUe76HjRNBCTz5t7RMmC8hH4J237l3mkQIPQGDnZHAGgpEqZJHx/urhxp3w==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Arthur', 'RUSSIAS', 'arthur', 'russias'),
(851, 'p1800363', 'p1800363', 'STCHETININE.Océane@etu.univ-lyon1.fr', 'stchetinine.océane@etu.univ-lyon1.fr', 1, 's1p/.lPVW1wA89Hc/0T4G6Je4ZBloMrQ/FgikCUQO4Q', '6Cdrz9iQ4+NvJfpZSlOLgrIXE1CZJWyGaMwVAW+mSqVkoFmF/nKlAsj6oBRa9Cg3Hhvxfox0bfd9FUmhZfuSjQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Océane', 'STCHETININE', 'oceane', 'stchetinine'),
(852, 'p1806493', 'p1806493', 'THAMRI.Fayçal@etu.univ-lyon1.fr', 'thamri.fayçal@etu.univ-lyon1.fr', 1, 'Q/1dgApGXpNX3WNpmseEucYu6OpgJ4sh8nmYA7vzm7M', '7saG8j/IdurSKkrA80nRiaYV/h9vuPXtt2/0k7o6uop768uiwcx4pWPr+iA6PEXfjQZoNzIHqTM7+eJd1TXIqA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Fayçal', 'THAMRI', 'faycal', 'thamri'),
(853, 'p1805596', 'p1805596', 'TOUHARDJI.Hamza@etu.univ-lyon1.fr', 'touhardji.hamza@etu.univ-lyon1.fr', 1, 'LnKx7VW.k67EjIOZjhZ4MabrpTDifoiMeHv7Ege61yU', 'xIYX/B+KX/qOANG1FhdecGbQJnF0XneqoxNp2VRsFb3JW3e6n84I9023b2kjqihtWrJ46yR/zs6D2vHCtfRfkg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Hamza', 'TOUHARDJI', 'hamza', 'touhardji'),
(854, 'p1803998', 'p1803998', 'VALEMBOIS.Felix@etu.univ-lyon1.fr', 'valembois.felix@etu.univ-lyon1.fr', 1, 'gk3FibjooEW4ET2NVwtcUyqMY.etO0T9l4OPRgUQP3U', 'fm7zTbb6/SjGNt+ICnyexIr6tMRlC+U+T6DZkZU1cr/mEdc258O3lFLFSY18KxAq37CshZcypFFYrYIXEQjvmA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Felix', 'VALEMBOIS', 'felix', 'valembois'),
(855, 'p1801713', 'p1801713', 'VERHILLE.Thomas@etu.univ-lyon1.fr', 'verhille.thomas@etu.univ-lyon1.fr', 1, 'XT4q1Qm3NvAcSFl.egEc/tGwpWX9K4/xtO4/zzRRJqk', 'FpiQA7Jbk+fykemeIjgSSvY5AIxZQWNxhZHETWItfGOfU9wpRwf/upG79kzEaZRMEt8IbcfB119JeTpLb3racA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Thomas', 'VERHILLE', 'thomas', 'verhille'),
(856, 'p1808399', 'p1808399', 'YADETTE.Abrhamme Kassaye@etu.univ-lyon1.fr', 'yadette.abrhamme kassaye@etu.univ-lyon1.fr', 1, '.aD872Pv1HuNjnqVZ2ThqSQOypMdUb65LvEuxmj2jrc', '8SYfuxQC2GOGKuYntr0LeyBv7ppSiqfLdk0Rc2nX2Bep3SMJ1oTYHehiFEbFqXEzNHd6MScQ7IEsrk8uFsZTyg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Abrhamme Kassaye', 'YADETTE', 'abrhamme kassaye', 'yadette'),
(857, 'p1804939', 'p1804939', 'ACHERCHOUR.Kheldin@etu.univ-lyon1.fr', 'acherchour.kheldin@etu.univ-lyon1.fr', 1, '92GLCHnSFeOR1hlciIbFbIQOBvH4lvGATaj0CglRw0Q', 'E+eDbt+GZ3MVZwLwbufPB1hWvNRPLL+l3ZnPYpsJC0iCBOT+0T5UrHKKzkiMccKF0BoMoMl1+Xj0ouRGjSmmng==', '2018-12-12 09:31:16', NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Kheldin', 'ACHERCHOUR', 'kheldin', 'acherchour'),
(858, 'p1806332', 'p1806332', 'BASTIAN.Matthias@etu.univ-lyon1.fr', 'bastian.matthias@etu.univ-lyon1.fr', 1, 'euV5BETln1cBEbRZkx1kCFOW/vF9oaXi1SFzSaJyBeY', 'V4rSV+aduNmcG2+QTFQ2XTtOn021o+/pz7SbBow+hGhydVTR2Suqn66L3UsiL9CyLBGhZJ4c7uT7Sqi9gnye0Q==', '2018-12-12 09:32:02', NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Matthias', 'BASTIAN', 'matthias', 'bastian'),
(859, 'p1802210', 'p1802210', 'BELABBAS BENGRAA.Brahim@etu.univ-lyon1.fr', 'belabbas bengraa.brahim@etu.univ-lyon1.fr', 1, 'Di5FSOjt94HmRjzqDbGCHhd3xzvSCYknH5li52VwiVA', 'IrX33CPHwCj0n41Za68AUxOgU52mu8S3CmUae883pRKJrGQttVA8ar4go0YgxdWvkRbKQMdF25qap2PNR7bs8g==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Brahim', 'BELABBAS BENGRAA', 'brahim', 'belabbas bengraa'),
(860, 'p1803502', 'p1803502', 'BERTRAND.Baptiste@etu.univ-lyon1.fr', 'bertrand.baptiste@etu.univ-lyon1.fr', 1, 'pm8ucp9Zl/lPogWqbOtbmSQdgcChrdqX34gDvGRw610', '7XkyQ8DoAOB0oDQoIAHJyBAQ/b70eioSAZ+7w5Iz7IelQYSDdXf4/b2Q0qmPki3gxiPszZes6aRlFoal545XIQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Baptiste', 'BERTRAND', 'baptiste', 'bertrand'),
(861, 'p1802858', 'p1802858', 'CHAMPION.Hugo@etu.univ-lyon1.fr', 'champion.hugo@etu.univ-lyon1.fr', 1, 'mde8L9rJd7W.yZfegmb3/fWlNtySvCj/riW6ZVwRjB8', 'YzAy4+y6GPz2zNu3NIEE3zi5h9N9Qdh/EeDJTXk/EHrFHNoG36BsgdEDmkm4oc1y0+YIM8xSRSmoq+L3C3qZXg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Hugo', 'CHAMPION', 'hugo', 'champion'),
(862, 'p1808077', 'p1808077', 'CLEMENT.Théotime@etu.univ-lyon1.fr', 'clement.théotime@etu.univ-lyon1.fr', 1, 'qQcrY4vjRvnjiEHbJI9sU4.PjJTrHpW8pKt4dJN6ItI', 'GyyNBlxoE37kgQgBNtwYaSpocv11Yh/oKjjevvYAZb7H/h/DhQVk6pyeu0vHre7s7lYTBj5HNGPVi2LiKV2sgQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Théotime', 'CLEMENT', 'theotime', 'clement'),
(863, 'p1800744', 'p1800744', 'FOREL.Hugo@etu.univ-lyon1.fr', 'forel.hugo@etu.univ-lyon1.fr', 1, 'y9tpN5HJ.0.n.BO23cJBXg7vD9pXA7iqCIS5zyk7rQc', '89phjjdx9FFXdEaIcHO62xgdQuG+xZ7MyArCvKaegcto3KLe/nnQ7o7/Z65kxzdAjhaOLhJzIclu0QO/DaJcug==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Hugo', 'FOREL', 'hugo', 'forel'),
(864, 'p1807470', 'p1807470', 'GARNIER.Aubin@etu.univ-lyon1.fr', 'garnier.aubin@etu.univ-lyon1.fr', 1, 'AeBUXOvK/BCs/T9u8TTZlXmcku48vSP01dyG5uQHK.4', 'ryMmXuTACEgLyrIfcAF7RfDfpzob28PRCPjUU8CyNIW+/Gg2xmZkw7FlyVhuAebFwOngET0rdJriQbLDYHX7yg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Aubin', 'GARNIER', 'aubin', 'garnier'),
(865, 'p1800218', 'p1800218', 'GIROUD.Benjamin@etu.univ-lyon1.fr', 'giroud.benjamin@etu.univ-lyon1.fr', 1, 'O6tNFXL1DicD1yBM4LkN2kdYXlYBnEoyvIsScN1xw5U', '1VPOP3f5CH4KvY+VCR3iaeCcOODEsFfD5ptEec7Z2IinnrPObT8gldYgPWOhQit0ZkOW/5OS7Cp3n4+4+ZyK+Q==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Benjamin', 'GIROUD', 'benjamin', 'giroud'),
(866, 'p1714018', 'p1714018', 'HAMZA-ZERIGAT.Naïm@etu.univ-lyon1.fr', 'hamza-zerigat.naïm@etu.univ-lyon1.fr', 1, 'w2pcbwaScDMQ53uQVLhcDjBgVRRsnDF9XvHqFTFwoMY', 'VBY2EcF7kCzgA+mR9N3SOZYa6+XGklLL+q1aycu6NK0mj9TaJRGzJvpwAooEJKH1Ug4LlqBLuMyU+Z3UTKlQ3Q==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Naïm', 'HAMZA-ZERIGAT', 'naim', 'hamza-zerigat'),
(867, 'p1801135', 'p1801135', 'JACQUEMARD.Tristan@etu.univ-lyon1.fr', 'jacquemard.tristan@etu.univ-lyon1.fr', 1, 'jBXY69qkwMlf/DaMgvRq0/AegbmIcTVkmzl6UxHQNio', '51975GgAzgpZQKhB54V5tYHGsuvaJGdH9Xu8iqXF5gYY4p1V5YFss/CPYWrD17tkqK1xC0TgoZqZE2jQlIq2lw==', '2019-01-22 19:54:33', NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Tristan', 'JACQUEMARD', 'tristan', 'jacquemard'),
(868, 'p1801045', 'p1801045', 'JUNUZOVIC.Said@etu.univ-lyon1.fr', 'junuzovic.said@etu.univ-lyon1.fr', 1, 'pUcSXatE9nr4ga3OVSihPt78jaeT17grH9yko14nVfA', 'PJB8gFlYSi8GVkvAnNODSCcaQorw85On32cz2euiO2nj944xb+ClIgC+G5RcKtotV0U67dAZtKlELjjFcQBDmg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Said', 'JUNUZOVIC', 'said', 'junuzovic'),
(869, 'p1807638', 'p1807638', 'MATHON.Nolan@etu.univ-lyon1.fr', 'mathon.nolan@etu.univ-lyon1.fr', 1, 'Q.6tt/fEb4tNb9EIFj/g6E.9cnjGvMDgcXWQl.6cii4', 'HNn/e1u9gFTDRv8+hRNvc+m2Zk68/6sAuG5cJKDrVnoqdrOggXEoNsHintq71XGFXggfEMU2b3tEOfvo7AN89w==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Nolan', 'MATHON', 'nolan', 'mathon'),
(870, 'p1806764', 'p1806764', 'MFOUEMO MAYELA.Norland@etu.univ-lyon1.fr', 'mfouemo mayela.norland@etu.univ-lyon1.fr', 1, 'izXIJtlmo4Jvwa7gW2V92efFkaaad5mv9B/YRGIb6LU', 'CPA9pQI9rdRgVxTW9ViUZop77CjX4SliLyyTnr9jOQGA/nq6J1iI/q47d3eHhoV3d34UuT9V7rgbL2d11KQ+dA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Norland', 'MFOUEMO MAYELA', 'norland', 'mfouemo mayela'),
(871, 'p1804207', 'p1804207', 'NINI.Rayane@etu.univ-lyon1.fr', 'nini.rayane@etu.univ-lyon1.fr', 1, '/9qoMyneRu7NdFw8x8V9jlnFSKkkETk.IkDef8qOyaI', 'eDH+Q2uy6iD7aSo2T9cJEWqRnVAfYT76oRJsGYQKIi2L4HNOWZa0YQROclbvnqz4Hmy9XIXTbfRf1pIy2wEDCQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Rayane', 'NINI', 'rayane', 'nini'),
(872, 'p1801627', 'p1801627', 'PINO.Maxime@etu.univ-lyon1.fr', 'pino.maxime@etu.univ-lyon1.fr', 1, '3UdIX6DBOVXEuZ.bVwQe2/NZI2ebU3Jl4xEWn8NJdMA', 'Do9aTfZDSaxU1yeLB5iBkavBxIgSGDreYMsy266z/6Oz/ag6yAXsz1FFzt+kWuk9V7BIU2i7HX3cRn6kf/twOw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Maxime', 'PINO', 'maxime', 'pino'),
(873, 'p1801869', 'p1801869', 'POTUS.Rémy@etu.univ-lyon1.fr', 'potus.rémy@etu.univ-lyon1.fr', 1, '16AoRY5DnuMXTdED4wZ3m/5NbKK1DNeSO71ZIOjJJj8', 'mFJO9j55eUJvr8V72e5+26sCFWXLqAelm1dw6uQy/C+0nO7QXY3lJuUuQcTKBd9GFkUJ7IJUrw/aMvJUS/t52w==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Rémy', 'POTUS', 'remy', 'potus'),
(874, 'p1802436', 'p1802436', 'RICHEMONT.Mathis@etu.univ-lyon1.fr', 'richemont.mathis@etu.univ-lyon1.fr', 1, '3zqg3d4rNyccWa6mqF7bomA6YLjaZBG96XJDQkc9Q9w', 'ZvmhH2LWhp3u13PL2GlJYNOEYtWKgWC/QWtqoNj0C7uyUcfKnFh1AUo2mvJUCXzHCawfsMUoNLJleyS6EyiAFA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Mathis', 'RICHEMONT', 'mathis', 'richemont'),
(875, 'p1801981', 'p1801981', 'SA.Mario@etu.univ-lyon1.fr', 'sa.mario@etu.univ-lyon1.fr', 1, 'bCWotxXmZ3ZPc.TY3FbHOmAvmK8m1itTETI56gpWW60', 'Fjdi+6N39G3HZ6nT7fxlKCGcwymecsv9T4aH6wN20zpc/eTyCfXJLnbdL1YQEO+OJ2s9OodlX0tgMy9r2jMlHA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Mario', 'SA', 'mario', 'sa'),
(876, 'p1804744', 'p1804744', 'SALAH.Sofian@etu.univ-lyon1.fr', 'salah.sofian@etu.univ-lyon1.fr', 1, 'fPJ4xRI8FXoL8.7zmazSJ45MbuxsgWb2hNxv9WgfZGA', 'yCpyeRw8WaBlYKUVkT4EbLpx+LE2GVKv4SNXOtqaObxzjuVzMU1ZtWuwThFI1C+mbbcY1CDUtCAE5EGPKmQcDg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Sofian', 'SALAH', 'sofian', 'salah'),
(877, 'p1800849', 'p1800849', 'SRISIVA.Venthan@etu.univ-lyon1.fr', 'srisiva.venthan@etu.univ-lyon1.fr', 1, 'KfTMiNpd2rIKreFAxevcd/o/7UqOPAnyeH31DbZYvrI', 'uRh0tBKuJBpBPYJk2ZejW5B/rIJFnfrTObMkYO1Gc7KoakgA4bdg34655/0lQpOk9rekMWLqmzWnJVeNVt91fQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Venthan', 'SRISIVA', 'venthan', 'srisiva'),
(878, 'p1807684', 'p1807684', 'TRIN.Quentin@etu.univ-lyon1.fr', 'trin.quentin@etu.univ-lyon1.fr', 1, 'vKdZc4WxmzM2wm.pMV2fc9lQkrq2sitRlYeRM.23gZ8', 'GwYacfOwoKLKxnLOWl/DwMe5PZi4VWdMcgTdZ6YobByu1BJ7jhUJgeOniMglcnElfKUUa3i48CGV2d4BjYk4Yw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Quentin', 'TRIN', 'quentin', 'trin'),
(879, 'p1804503', 'p1804503', 'VALLOT.Joris@etu.univ-lyon1.fr', 'vallot.joris@etu.univ-lyon1.fr', 1, 'j7Pj/YnAFCsKlUzxYC95IBxOJMttAuUVzkyRY3vbPy0', 'X7YmaG/9HQvOep3GzC5LvOZn+5YR3mL3/M5JjvfpXl4bHkopDJYhT21O1oboVTpym2kh/mn7OBRiHGLOo5hJQg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Joris', 'VALLOT', 'joris', 'vallot'),
(880, 'p1807249', 'p1807249', 'ZEKPA.Mathias@etu.univ-lyon1.fr', 'zekpa.mathias@etu.univ-lyon1.fr', 1, '2fcPmEdefvkme.owY3CWbib6tJJCX9.qrA08xYaC8hg', 'qCZizESnHubK+GEPYMdszs12Jf8yE7a9rI9/0TCA03WgVB103yviafR7Gcr+R2cewSLZUn8OIKqSNnDgAKEUUw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Mathias', 'ZEKPA', 'mathias', 'zekpa'),
(881, 'p1800576', 'p1800576', 'ARALOU.Clement@etu.univ-lyon1.fr', 'aralou.clement@etu.univ-lyon1.fr', 1, 'Yhbef9F0QD0U77VnM4Kf6Z3ex/zi3IIrFHJXNqI8uhI', '8XFtIGE7X3CWQO/XONkH20R+QmfAWrp0ewFDkTeiXoC7iI2vGnw2PUIJ63JVwClXvOY867o1BHDVXnoPnXkFrA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Clement', 'ARALOU', 'clement', 'aralou'),
(882, 'p1807201', 'p1807201', 'AZZAM.Rami@etu.univ-lyon1.fr', 'azzam.rami@etu.univ-lyon1.fr', 1, 'cImiudytahXkpCUDR1t1gpAwi6FFKaguXLorF98YY3g', 'DfkZESn5eSVYtnKF7LDFbvSGypXTmqXT4P1ZGOe3/PnYCBDJwWRnUoqoo12z0ITukBnn1Fh0uXmOOpa6MNpBhQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Rami', 'AZZAM', 'rami', 'azzam'),
(883, 'p1806029', 'p1806029', 'BENALIA.Mohamed@etu.univ-lyon1.fr', 'benalia.mohamed@etu.univ-lyon1.fr', 1, 'VtlQ/SZLT7loe/YsgCIDvGFThCR64eAv9C8mAYmx1dA', 'tlmc97TMgJkOEjQfs0vrE2bhbF8zlYeNosCZ0N3jRY51LgB9xq6DCP+DcEIof4pw/bOAsSl+OwaoFYFsKUV+/w==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Mohamed', 'BENALIA', 'mohamed', 'benalia'),
(884, 'p1803816', 'p1803816', 'BERTHOMÉ.Alyssia@etu.univ-lyon1.fr', 'berthomé.alyssia@etu.univ-lyon1.fr', 1, 'npXPWTXjt10gYt.IQmRGUmr3ilfG8bDlO5C8MOa33vI', 'nahf215fm0L1Ld3X+HXmhL8Ea21uC/lQpZ4wKNXFtUc6attz3d+RBB5dDjTMdpc/qOpeZaPbKlZUdHU/iJ9o/w==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Alyssia', 'BERTHOMÉ', 'alyssia', 'berthome'),
(885, 'p1806102', 'p1806102', 'BOULIO.Laurine@etu.univ-lyon1.fr', 'boulio.laurine@etu.univ-lyon1.fr', 1, '21URFR9L2.bmiL1D.CTM/0eZaqBV2Os7bIgagcYwXZM', 'g5uvRwjl581rUYQKzVIqylrRyIvrt4xmwEM2l3FEfO8Fzv/AfPHhLMZqWGymoZHv8NPFFeNG5ewHnNAHxrOIGg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Laurine', 'BOULIO', 'laurine', 'boulio'),
(886, 'p1805403', 'p1805403', 'COMAJUAN.Milan@etu.univ-lyon1.fr', 'comajuan.milan@etu.univ-lyon1.fr', 1, '8AKVMspoPmhlQ4E6n7Ku99OxmP5zpWx17yOnA0FBi1g', '8aggUPlj+NveKA09UcRfZmPn7t4YBUPKeoVDs44wWsOFcrUtsSo+sLqdhJ9eu8C3ppSOyxoM84ekWmHCSPeLPw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Milan', 'COMAJUAN', 'milan', 'comajuan'),
(887, 'p1801372', 'p1801372', 'DE ALMEIDA.Jonathan@etu.univ-lyon1.fr', 'de almeida.jonathan@etu.univ-lyon1.fr', 1, 'b5JQy2y3EnHluwnhd5RfLXUlqQl9SQCRxK1jl05EwKI', 'mylo7nb4wWSQgubOrMr7Wx9coOpJs8imDuQhgDv+X4X10TCEkjLBi3F0bpqqiacQR2lf34z95ujTL8H4jkmleg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Jonathan', 'DE ALMEIDA', 'jonathan', 'de almeida'),
(888, 'p1805285', 'p1805285', 'DUPORT.Quentin@etu.univ-lyon1.fr', 'duport.quentin@etu.univ-lyon1.fr', 1, '27PGS6lQXqFoZR5unmrT3j.3ijs/b8PG3RzDDoL/OkE', 'EmBTAELkbULpOYjKUS+dnb2FT8EsUu46AZp+hrHfC2x0JagWhU0vns5RBhAwY76U2OWULtGouQuTg/IsMfgJ3A==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Quentin', 'DUPORT', 'quentin', 'duport'),
(889, 'p1802235', 'p1802235', 'GARCIA.Romain@etu.univ-lyon1.fr', 'garcia.romain@etu.univ-lyon1.fr', 1, '69tMO8tK13Ro2MNA8KoYLUPRQCiT5R6S4PTjAp0ignY', 'taP5tJEQ8C/WUHKb+e815/LQXE4OeMzmWJotMQbo+inyZf2xQI1yWPaj84lYV4Dhv+ln/jzAtIdbuXjpespDMQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Romain', 'GARCIA', 'romain', 'garcia'),
(890, 'p1804704', 'p1804704', 'GARDIEN.Paul@etu.univ-lyon1.fr', 'gardien.paul@etu.univ-lyon1.fr', 1, '/HwljPLDuXRtLeDaEjgj7kLPhEGMXcaIkmxTDifVyRI', 'jYEVFRDn4ezIHtk2tvh13dmf86h0h4POEsjKGwyGFO2XO77reElprz2pYfmyz8ZIJynNdzOmBFhAXIExqerypA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Paul', 'GARDIEN', 'paul', 'gardien'),
(891, 'p1806287', 'p1806287', 'GIRAULT.Maxence@etu.univ-lyon1.fr', 'girault.maxence@etu.univ-lyon1.fr', 1, '/4wy56uoPdCIVOrg1.i85vxsaZhi0HfUzvKctHcRweo', 'wZnkaMcEziFnGoZTfuOqrOlbl7roYV19fqnwYaiq6tbUkVNlqg/8nh3C9EsKBkoYcvZTAOMFCL6JTyD8LAICAQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Maxence', 'GIRAULT', 'maxence', 'girault'),
(892, 'p1800869', 'p1800869', 'JALLAMION.Valentin@etu.univ-lyon1.fr', 'jallamion.valentin@etu.univ-lyon1.fr', 1, 'rkvCEf2kvkR3E.SFoWwG5TW.jZjJAA/cFQLRi/f0/Pg', 'bzYXW7JQiMA3Wp7PcinlZevFkTZEOsEHCo0jy1xvJs0o1H/JquhLCZmLT6E9ul1HspDQJpv6tjieg9QVcUYKPA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Valentin', 'JALLAMION', 'valentin', 'jallamion'),
(893, 'p1808155', 'p1808155', 'KOWALSKI.Romain@etu.univ-lyon1.fr', 'kowalski.romain@etu.univ-lyon1.fr', 1, 'vil2WWTnS9e2On/Iu8ZTNr9sDYOldDbW7Dak7wBZVOI', 'V/VNpZrGQJsuYjoaHvtDeC7AEHhKoZcNHCvhGn6z98SUxx8+63PIykrwe86J2SzxXAaNzBu9Oauic0CQs0ljxw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Romain', 'KOWALSKI', 'romain', 'kowalski'),
(894, 'p1803227', 'p1803227', 'LAURANS.Bastien@etu.univ-lyon1.fr', 'laurans.bastien@etu.univ-lyon1.fr', 1, 'lGwEP4bhXCGRtgFDBTeM0Wv6aNftoSo8i5mc5x1NV6c', 'IgJX4T8senOxf6Lu0FalDi4kHTasZCQD7MjU/85dm3CDxFrY8uCBZcKVUGXC4TrvPYFC5TxxKyWQVjjAZVe6sg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Bastien', 'LAURANS', 'bastien', 'laurans'),
(895, 'p1807070', 'p1807070', 'MAUCHAMP.Jules@etu.univ-lyon1.fr', 'mauchamp.jules@etu.univ-lyon1.fr', 1, 'g9/L3glJ8xkmsRaIYU9rwx2QOb2YlToOy7ib6as0WlQ', 'aYEMYQJjgMHTYUBBHJFmYcAc76Og0WKOHCymcXSOsM1n5kSAxxiukT67Vuk4CUa5DUiH3YD2GeFK7nl9hCyurQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Jules', 'MAUCHAMP', 'jules', 'mauchamp'),
(896, 'p1800621', 'p1800621', 'MERLIN.Enora@etu.univ-lyon1.fr', 'merlin.enora@etu.univ-lyon1.fr', 1, 't.HR/720y3hCSpB3zJgZDcbYtJH8UTfBZCXgezFvygI', 'JyVA/mi+U7LPuNmAL1QanU7vPMsLXm1FuAU6wASJsttw1plH/mJYGbx+zr22SfQjOIsWfC00LE26TswO0do0kw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Enora', 'MERLIN', 'enora', 'merlin'),
(897, 'p1807994', 'p1807994', 'MOPERO MASSA.Rachidi@etu.univ-lyon1.fr', 'mopero massa.rachidi@etu.univ-lyon1.fr', 1, 'bpy2VH1TQ7zUrABQKYbenzn4Fwk1hOtO9nF85CtQoA4', '74d2RPr5v386e8I9ZSof6S5teUMp/4pPHvnRQkcdhVWVbttDKOv2GGBZsQf7SY7y00hO108N2ZRCeZL9zI0x7Q==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Rachidi', 'MOPERO MASSA', 'rachidi', 'mopero massa'),
(898, 'p1800639', 'p1800639', 'MOTEL.Killian@etu.univ-lyon1.fr', 'motel.killian@etu.univ-lyon1.fr', 1, 'QxdF7E6R0aG9YCy8MiigCOQFbkSbNTsttGe4UlY8HKk', 'PgG8HMMGWNNqt/HUwkbx3m5u6T7PU/S/A312XEhozynOwtTrwq/3DCAIdG72NA6yXvzbKV5tEklG+f4iCUwBCQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Killian', 'MOTEL', 'killian', 'motel'),
(899, 'p1810803', 'p1810803', 'PAGE--LEONIE.Nemuel@etu.univ-lyon1.fr', 'page--leonie.nemuel@etu.univ-lyon1.fr', 1, 'NSPfPL3DCsK53xX39.i6hBPuB7NeGhhHfhXpp64ude8', 'ictBclOZtvzBT2BC3UlCw70JrJtw5Z4nfZo7VMsBO1JcxrNwWZRlMACSf3Y1QhbM6KCkg7xFxX5fj6TlohIBlA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Nemuel', 'PAGE--LEONIE', 'nemuel', 'page--leonie'),
(900, 'p1804634', 'p1804634', 'SAFEEK.Fadi@etu.univ-lyon1.fr', 'safeek.fadi@etu.univ-lyon1.fr', 1, 'Ipf8olYKiAP0DFpNK7I6DRG9wTEhE4ya12aF0EhndaU', 'bX0SU0Y2r6JWWKYGIXZ6UGkZy4tOmDqN//KOLr8n3UpOmW7b38A05ax/89PYWi5A7nRwIXQ2E9CVmINQuE0vVA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Fadi', 'SAFEEK', 'fadi', 'safeek'),
(901, 'p1804860', 'p1804860', 'SAINT-SORNY.Evan@etu.univ-lyon1.fr', 'saint-sorny.evan@etu.univ-lyon1.fr', 1, 'YqwC2i1wl82qVAX3q9naKo1lYDZEGZAaBcmxRb7TUgw', 'KCBLZ9Hntmn8pS418mmSxOjp+7xgusBUTrGt+il+yj5nd/rFJ6l9cm6mS6GtdKyQ3ZVfgTIqCInpzbc62e7Ygw==', '2019-01-08 08:58:21', NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Evan', 'SAINT-SORNY', 'evan', 'saint-sorny'),
(902, 'p1802574', 'p1802574', 'THOBOIS.Antonin@etu.univ-lyon1.fr', 'thobois.antonin@etu.univ-lyon1.fr', 1, '.9IciwFr287ifri8jxqrZwOPxY2On8yWVpoVt62E7Kc', 'yfH8zt8GkufVJz0buO4CmuZLzu+0aVm44j4BtO+vgjQ80zkQOh4Doc6sU6/h2o1xxt5ex7w78cuZj6D7ly3uEg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Antonin', 'THOBOIS', 'antonin', 'thobois'),
(903, 'p1809412', 'p1809412', 'TILLY.Fabien@etu.univ-lyon1.fr', 'tilly.fabien@etu.univ-lyon1.fr', 1, 'bhCnG7gGI/hunXdp/195BPSrcn9jq80qwGYVqbhSpxU', 'VOJBu17yaHvuWpXG6LdHYyMaZxNxcXMvFhmJVnexK7WHHjXIRwvjqW4iOXn3fh9TeB7uvh2IWMwuySai4EOquw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Fabien', 'TILLY', 'fabien', 'tilly'),
(904, 'p1801551', 'p1801551', 'VALLOT.Nicolas@etu.univ-lyon1.fr', 'vallot.nicolas@etu.univ-lyon1.fr', 1, '35CryzaZnASKkoPm00OrJ/14yFE6cr.VVk5ME.RfDYY', 'a9EnYX47/mhPP10xrN+gPR4gATiap8RASQo5fVp/ZsWMK/PfDcl0Hh93nPlbteL+eV5hR5GTdZpkbe2RqdDLHA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Nicolas', 'VALLOT', 'nicolas', 'vallot'),
(905, 'p1803091', 'p1803091', 'ARQUILLIERE.Emilie@etu.univ-lyon1.fr', 'arquilliere.emilie@etu.univ-lyon1.fr', 1, 'FMu3fhv5bNbyu6qPOq4Q34tufQ.rB0aBxQFwFvf1.1U', 'YhvyMvEOYpgyHPxcluiKdsSjAvBLEpOLTzFiNB2B8OpRrxKagTdyxBqp4rs9HERNWG/xIbTVjOGJSn8eDO+bKw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Emilie', 'ARQUILLIERE', 'emilie', 'arquilliere'),
(906, 'p1803858', 'p1803858', 'BORDONNET.Vincent@etu.univ-lyon1.fr', 'bordonnet.vincent@etu.univ-lyon1.fr', 1, 'FlC35SDQUretOR8OVT/Xz3cZrYk1IC7TVZmVahapMB8', 'vu6C+H7IOxr09tcgUZRipBtFBARwynN5HG/lyWPhkcOWt9i3e214CgBZ0Rgh3iwTEZsQ7OEKhA47+PPXCa6q+w==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Vincent', 'BORDONNET', 'vincent', 'bordonnet'),
(907, 'p1800250', 'p1800250', 'BRUNO.Ludovic@etu.univ-lyon1.fr', 'bruno.ludovic@etu.univ-lyon1.fr', 1, 'HyOYly.i8TdDBLpvPyXIYOOSwNErOngYFRtof/UcZhY', '/UzEkyCdxxlUFfmlxKuElvML5bQogIYypb2WQumqGrLVT8h5GxUK9w96iGr2nV6h6gqKOhB0tqKR89MUM5nMtg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Ludovic', 'BRUNO', 'ludovic', 'bruno'),
(908, 'p1802498', 'p1802498', 'CHAHBAZIAN.Maxime@etu.univ-lyon1.fr', 'chahbazian.maxime@etu.univ-lyon1.fr', 1, 'CrZVA9S6jhf89jLSw/c8zz0zGQn8Fw4oUgdqEc6/u4I', 'zxJZVznNqSh8Punc8t4QxD59EVKKE8+ZyyfWe/neh7K8o4hTRnEtcaQyl/ZRh6fV818T6L9ZxP6pgksvs0X2BA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Maxime', 'CHAHBAZIAN', 'maxime', 'chahbazian'),
(909, 'p1804059', 'p1804059', 'COULLON.Camil@etu.univ-lyon1.fr', 'coullon.camil@etu.univ-lyon1.fr', 1, 'X3/vlCSXrA7UMutIXlW.2Ik3e4FbcQFvy3XKo7uI70g', 'BwFKy8zNheRlfPLEyIOW4oSmqz4BVv13Ht97Zf9Mn632QjmC2GiyVENiO8FhUDG4JQJCsflReMKBuj3689csOw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Camil', 'COULLON', 'camil', 'coullon'),
(910, 'p1803980', 'p1803980', 'DO ESPIRITO SANTO.Valentin@etu.univ-lyon1.fr', 'do espirito santo.valentin@etu.univ-lyon1.fr', 1, 'qYsQaat6gdGg6ktLotYB3La3tQmYFKHzaTGnoLtrlFI', 'itx3cP2YCAaIybr0CqnqdPsq5NvGe4wxQ5g8HVFCMvDtxAoFZZTjEnyhcVBs32F2iP1g2y+yc4/Bupadhvw7YQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Valentin', 'DO ESPIRITO SANTO', 'valentin', 'do espirito santo'),
(911, 'p1802098', 'p1802098', 'DUVEAU.Dorian@etu.univ-lyon1.fr', 'duveau.dorian@etu.univ-lyon1.fr', 1, 'oCM6DT7TRsC34SZKEjVU6CO9kPF6ibp7Mf4LVkuh4xw', 'zzgn4ZVG4Cvs9EapNGTf10Z0IIJk1OuTgul+5nljpkHCHj5ngNeJAbbKFo4XQJYJsXo/tS3aXsIf39OZKNZJDw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Dorian', 'DUVEAU', 'dorian', 'duveau'),
(912, 'p1811220', 'p1811220', 'GEAY.Hugo@etu.univ-lyon1.fr', 'geay.hugo@etu.univ-lyon1.fr', 1, '5oFLkjFFmZqjHOqWeZPAx5wUDeKqOLL/qExZQRfPOn8', 'Mrq8QH0/2IDt/A/VESv0a5Dq2kCWevcLOeznbWZCJatj4al8qz53KTfdVwtxIvwsYk7j97L6Tbd7twZGsH8v4A==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Hugo', 'GEAY', 'hugo', 'geay'),
(913, 'p1804898', 'p1804898', 'HADJEB.Sami@etu.univ-lyon1.fr', 'hadjeb.sami@etu.univ-lyon1.fr', 1, 'ZjTixxW77vmo2DuDOvgQUUI1pMTR48AQUtq1Ha1qN78', 'g+bzNK1OwVWMEIVuXT1AYQsSvPMMD8XvVjBZm1XZ4kJIvZLWbDK0RK0RRK2Jm42ekOPZe8C96KDX/4W8bUMgVQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Sami', 'HADJEB', 'sami', 'hadjeb'),
(914, 'p1805935', 'p1805935', 'HAM.Vak Sam Sophie@etu.univ-lyon1.fr', 'ham.vak sam sophie@etu.univ-lyon1.fr', 1, '/9pdLMPdsuZgtVr/Qhq1YZWsQSsINUP4hq/3uSSC99U', '8j6SMPj/ArAu8VKZerc/hqc4YInLnN4EWLztPCr7zWgHEgcd22B/qKX4LuHVdpcfktuilk5StHtK8kwPHn3uhg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Vak Sam Sophie', 'HAM', 'vak sam sophie', 'ham'),
(915, 'p1806978', 'p1806978', 'HUSSEIN.Ali@etu.univ-lyon1.fr', 'hussein.ali@etu.univ-lyon1.fr', 1, 'TGnFmrxN5lFNPakTOXcurfoLKaiUzUQhBlf2Nwu/W6w', 'Lbg2rGQR7QXfKTcihBuY953CLPYrLAyZpDmczAPbzPmsWEga97SPO3zh4gAjU+ckzKEu4Z4nAypOo+NDO826Bw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Ali', 'HUSSEIN', 'ali', 'hussein'),
(916, 'p1802404', 'p1802404', 'JERRAF.Wissale@etu.univ-lyon1.fr', 'jerraf.wissale@etu.univ-lyon1.fr', 1, 'qlMEzTfhYaSKWmXJU2Wf8K/dmhUxzRtiv9o0kgFeoT8', 'XC7meE+mLw5pSxnzW9xg0z7icNDoxfuNpWxqAdKa9zJQ+BaC+dzVC2hw24BLlpC0325HZNKNOD7QY3ctgb9YZw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Wissale', 'JERRAF', 'wissale', 'jerraf'),
(917, 'p1801454', 'p1801454', 'KHEMMAR.Rayan@etu.univ-lyon1.fr', 'khemmar.rayan@etu.univ-lyon1.fr', 1, 'e9MInrYdcMYAD34lqGDmZJ5OYKVbTY6WZ33wseJg5xA', '+SvP3ZolzI649q38NML1pwjh3nLm8QxFnNmoXFLchkP9IKkyHYGRlCySvF/BN+RfNWhbC3oPxzit2w+Dj+3W2A==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Rayan', 'KHEMMAR', 'rayan', 'khemmar'),
(918, 'p1801444', 'p1801444', 'KHETTAL.Pierre@etu.univ-lyon1.fr', 'khettal.pierre@etu.univ-lyon1.fr', 1, '96XYMEK3Zv6zV1tl5rksFUby1P7EPbchRvrA6S5d/eQ', 'Rfyjj2WZfqe+Tx3wpFHnBAZ/5qNWqtw/guNgWKgwI4bf/OGT3P0W0RAkVCg6zNHIuFCDByeFRvc7oJmiNzVEiQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Pierre', 'KHETTAL', 'pierre', 'khettal'),
(919, 'p1810882', 'p1810882', 'LEMAITRE.Robin@etu.univ-lyon1.fr', 'lemaitre.robin@etu.univ-lyon1.fr', 1, 'CJ9R/t.Q/I622W2id3Iel4PhiRb/0raXoSgpPZaN30s', 'igNl5Ie0iwA+oI6jYgUgAkXxg+kIxeHtrZ3gEelqOU1dBUqjNxLsR5eJrtEwOawTlcBycZnJrXZH5OhyTqmrVA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Robin', 'LEMAITRE', 'robin', 'lemaitre'),
(920, 'p1800946', 'p1800946', 'MACE.Lucas@etu.univ-lyon1.fr', 'mace.lucas@etu.univ-lyon1.fr', 1, 'v2EHtrhNyeOYizLwCqi2gmESM/s1a7Rz6bl5yKnfstE', 'xB4ZvKk8nDvTas7AdPJxdXCcTmCE+80n+kGt1hQBlVu9NH4B2brxFoWBWR3Q2xTS4LPZvZdh8Oin+UZVCsAMOQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Lucas', 'MACE', 'lucas', 'mace'),
(921, 'p1801234', 'p1801234', 'MATRAY.Clément@etu.univ-lyon1.fr', 'matray.clément@etu.univ-lyon1.fr', 1, 'tgwqXRwyWxzWtQISJQ2PG0tJMI22CZGhf6y6.5uvAmM', '5qUrDeEccLOnSK0l65GtaL2Pk5tBcrKBDkaz0BqA5pcjETdYaNNoayxorVULW6fPXpwNmp4jc01bm1rS9Dmrrg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Clément', 'MATRAY', 'clement', 'matray'),
(922, 'p1809561', 'p1809561', 'MECHIN.Fergal@etu.univ-lyon1.fr', 'mechin.fergal@etu.univ-lyon1.fr', 1, 'C3lPlVTGswVSxx5nNOliI2NO4GuUxfAdB5mD6Wr3USk', 'ulXnCcqIegJ/nMyolnO67DwU4SGD8bVTuDmpFb+xJk518LbJfD/UEs5mO5WHtIfshj706kWbeXhNRhxI860VQA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Fergal', 'MECHIN', 'fergal', 'mechin'),
(923, 'p1803343', 'p1803343', 'MONLON.Andry@etu.univ-lyon1.fr', 'monlon.andry@etu.univ-lyon1.fr', 1, 'rxG6cfnuLWEGX2luU40jq.pwfNxW3C0fqm1PXal2/cY', 'Wzqwh81v+Mrzr4pVbmAdw6ABmwOYS0SUqaVfV0p55nf5EaRIjGTVuKeaNvRqpa+1iCzgonSNVMMVPlvNhsdqFA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Andry', 'MONLON', 'andry', 'monlon'),
(924, 'p1808057', 'p1808057', 'MORONVAL.Bastien@etu.univ-lyon1.fr', 'moronval.bastien@etu.univ-lyon1.fr', 1, 'yihRrWPLCZyzl.oAGVWuxIC1kwYRRSqeU.0qBdbgr/M', '+JSCmHFVXdJ5NPeHEYBkXuoUtiDy+r7JEplaSNGSYkLhm1uneaOqQAbEwqDAt2MEMcCmoCM6PqMOJtbC9D7NOQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Bastien', 'MORONVAL', 'bastien', 'moronval'),
(925, 'p1805896', 'p1805896', 'NEERMAN.Malcolm@etu.univ-lyon1.fr', 'neerman.malcolm@etu.univ-lyon1.fr', 1, 'VpfMDSSuTNiRfVbI1uKtzczSE7ejxMa6iN2GW27z5Tg', 'gvNJU6Z6c726l4/unudZMhwHgSHJXbi4XIsmLirIPLwQf5n/sFLpMldnnf2LdZTL8m2QqVuR/lFMjbkIMb5paQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Malcolm', 'NEERMAN', 'malcolm', 'neerman'),
(926, 'p1805041', 'p1805041', 'PEREZ.Hugo@etu.univ-lyon1.fr', 'perez.hugo@etu.univ-lyon1.fr', 1, '2zHhtSaXCQpJtA/8q6KIiuE6R0f9FCUql6rRsU3rBiI', 'o/nP/51aYRdsWJnHf/OvrevRDhdEy1to7DQ1X3KybVPOHnxaKnPiqNnnc8pB5IVNQANNI+ROxEwwVNLac0D2vg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Hugo', 'PEREZ', 'hugo', 'perez'),
(927, 'p1808171', 'p1808171', 'RAY.Yann@etu.univ-lyon1.fr', 'ray.yann@etu.univ-lyon1.fr', 1, 'K1q.ZylHgtlAeRlqVVDg0c1TN.3Q7W9Oyj8V2vlw0zM', '9znVy9jRxXgA2/usgN9GOEYDdi5PbyHmztotz49S4MBmX48joEEZFcmfRL8Nj5vROpScvNXwJX4phYNaOsr4Hg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Yann', 'RAY', 'yann', 'ray'),
(928, 'p1812047', 'p1812047', 'RENAUDIN.Célestin@etu.univ-lyon1.fr', 'renaudin.célestin@etu.univ-lyon1.fr', 1, 'LFY2crrLS91n.EulhdzSbUKALTOiF6OTUIfSIp8hSEE', 'pa3MDC6+ObjzwRAjCvafruU8H0VcLjOgW8N1/l3+klaHtMfdFzt4AFgSC+zEuhNXOoFAuLkKEiEdOPpvVOEQcA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Célestin', 'RENAUDIN', 'celestin', 'renaudin'),
(929, 'p1422359', 'p1422359', 'RUIZ.Erwan@etu.univ-lyon1.fr', 'ruiz.erwan@etu.univ-lyon1.fr', 1, 'ZX3E.jhAfYppOm.3YbPcZY2sK4Nkh3XMABpeqzUzYk4', 'P9SUKbpJdVQVHTqvE0sFJlAoYHKlG330gUqtFBggQZxXx4kcGTFlrcprLEzRC6xDyHp83jNkqAkjNsfUmeMD/g==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Erwan', 'RUIZ', 'erwan', 'ruiz'),
(930, 'p1806530', 'p1806530', 'SEMLALI.Amine@etu.univ-lyon1.fr', 'semlali.amine@etu.univ-lyon1.fr', 1, 'yIbNTLD3WL41tOANmYVJSYvT0R3qu6l62.8yTZkxG3I', 'Orw0jJ7txe/PszE1SqIaJbc1QT0F8p4jF/7wNf1Fin3uN8HuN7M/3oXrB1t28/Epnt63z0QKQnp9CfVwp0RPJg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Amine', 'SEMLALI', 'amine', 'semlali'),
(931, 'p1801008', 'p1801008', 'SERPOLLIER.Rémi@etu.univ-lyon1.fr', 'serpollier.rémi@etu.univ-lyon1.fr', 1, 'T7dITXT2Q8X9L4wwwxpK1QCBE2ImYrRjHjWlacdli.0', 'OZOu4PkC8EMR8TyAY3qNT/ePYmpBe6O8vrInTJtQipDNRvDjRFZdqOTdRK7Gzy7/8da5pKusDk9Qv3V1EyDccg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Rémi', 'SERPOLLIER', 'remi', 'serpollier'),
(932, 'p1812167', 'p1812167', 'YANGNI-ANGATE.BODJE@etu.univ-lyon1.fr', 'yangni-angate.bodje@etu.univ-lyon1.fr', 1, 'XJvVqlXEzL4KkGtGRwtzW3xsoIs8cW0bhx4GgoyYwME', '9wwSmDKE4IOE9luwYopZn76njWxDODaMyVYQeByG+HyRvK3kHpL7xfRS15V9EEG5U/CaKvxBjDs5Lpix9UEteQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'BODJE', 'YANGNI-ANGATE', 'bodje', 'yangni-angate'),
(933, 'p1802162', 'p1802162', 'ATTAL.Paulinee@etu.univ-lyon1.fr', 'attal.paulinee@etu.univ-lyon1.fr', 1, 'Gc1umEwvmOSLkoIvPvZwk9aTIX0dyz/h6JzOrS/DoeQ', 'mm03rCoykpfIFpFGYqjUjKJlKsom0aRs3yASni7kb+vNhqnk+zHgEq/dS1xYV0sxpXbuGiH57y30Gal5OCArwg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Pauline', 'ATTAL', 'pauline', 'attal'),
(934, 'p1812028', 'p1812028', 'BELAGGOUNE.Amir@etu.univ-lyon1.fr', 'belaggoune.amir@etu.univ-lyon1.fr', 1, 'zoq9eCufIBU1dH5TE63wfn97CmShMHIp62qhGlx7p9g', '2vaNqhIMW+FPwKYL0xUYwSRHX9edH3wve7oYuYP+nXpPbNITf+aV3h+R/XuXrXuiP8zKukATlRkPeken0d3kSg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Amir', 'BELAGGOUNE', 'amir', 'belaggoune'),
(935, 'p1801076', 'p1801076', 'BLASKO.Daniel@etu.univ-lyon1.fr', 'blasko.daniel@etu.univ-lyon1.fr', 1, 'T//gvsCzSfQQ1XXJII6DefCFAYoENlk93RapK17crMM', 'rqlILgx9BWjXmBdLaKErnwqN1+MChAf6Xj/UuGswcn+npM+lh1inyYXuSWb4eshQlNiNXpZSKlmU+dAgaOIg0A==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Daniel', 'BLASKO', 'daniel', 'blasko'),
(936, 'p1801970', 'p1801970', 'BROUTIER.Olivier@etu.univ-lyon1.fr', 'broutier.olivier@etu.univ-lyon1.fr', 1, 'MJRY7chDN3/YVgpyle/oIS3sJuS/AW3ywF9ncdilvio', 'Xn95xlH2PYh/KFl0E5T/TW6efgbYmSLO5JUIwZEoM1HsLYQyt2bgF4cb+mDHvBdLcManoiEahVaaDh01C3qI6w==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Olivier', 'BROUTIER', 'olivier', 'broutier'),
(937, 'p1804884', 'p1804884', 'BRUN.Julien@etu.univ-lyon1.fr', 'brun.julien@etu.univ-lyon1.fr', 1, 'ekT7fIakr.Mih.y9dB9fDUhJK4RAr08eU0oudhTX/s4', 'ByAojbM+7W9q9059m1g9kFa91NiMUqHAedX4wuYS65cTCQ8QZzj+Z1JPJ+/9TJbVpVxPxO8D26/NP+Lr40r8hg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Julien', 'BRUN', 'julien', 'brun'),
(938, 'p1805797', 'p1805797', 'CAMIER.Mattéo@etu.univ-lyon1.fr', 'camier.mattéo@etu.univ-lyon1.fr', 1, 'xdj5m46VJZKOQo8t/K0HM/TRdFIIXjTO1MWj3FuMX7I', 'g5eiojTFLyCoWdfermzoMphtxGENQw7yRAHNOI+SmlP77PRs8o6rDyek1riKiUg36gOSa/vNOuTdu2UZbcI9zw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Mattéo', 'CAMIER', 'matteo', 'camier'),
(939, 'p1711577', 'p1711577', 'CHAUSSEAU.Daniel@etu.univ-lyon1.fr', 'chausseau.daniel@etu.univ-lyon1.fr', 1, 'yIYBNMDG9uvd6/OHr3FpMjbiQXHyQLsxTxYc/Zpbfys', 'XzNyci79zeQHlr2ImqkZX8xVuMx8VVw/T5zy0hpkQVyJ7TCL6Y+or50bgv1hKhjN6akp6fC+TgY9yJpEjDPLIg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Daniel', 'CHAUSSEAU', 'daniel', 'chausseau'),
(940, 'p1801229', 'p1801229', 'DAURELLE.Timothée@etu.univ-lyon1.fr', 'daurelle.timothée@etu.univ-lyon1.fr', 1, 'p37fQgJPko9VLU91y32k656qnoTRCUVSFoIgUvNC7RQ', 'y6WkYFRgET8infPmu7LIce26ALA29+xUFDd1aIKV5jfdP+GLaw/ls3eIbmGDifNI+Cmw8VguJAZmpgSNmcEd6A==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Timothée', 'DAURELLE', 'timothee', 'daurelle'),
(941, 'p1805864', 'p1805864', 'DOUKI.Jérémy@etu.univ-lyon1.fr', 'douki.jérémy@etu.univ-lyon1.fr', 1, 'ohNvx/ejWCuiAEa7/DIaP9/4w7.D2RFEkl6G8obrsiU', 'eLfSrQEopFOopDLEe8La77QP6ibD/QsijZxZyhzPgFL60Glkp7VHz6xds9pQ1+b7gH1RDrbRGcdJzY528Eoj7Q==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Jérémy', 'DOUKI', 'jeremy', 'douki'),
(942, 'p1806846', 'p1806846', 'DUGAUQUIER.Angélique@etu.univ-lyon1.fr', 'dugauquier.angélique@etu.univ-lyon1.fr', 1, 'ekd6pkQKTotjZ/TSuduQIq1ILqrMSwbjyzGG3wf5twI', 'Nt+vLUD4zp+3USsvj8I4SGokKFz8+IxsGFwUSrCepuR+JtNHBKjdjRE8BZHeGCN2Icv7ANnsZAU/XMEmNpCKaQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Angélique', 'DUGAUQUIER', 'angelique', 'dugauquier'),
(943, 'p1804134', 'p1804134', 'EL AZZOUZI.Mohamed@etu.univ-lyon1.fr', 'el azzouzi.mohamed@etu.univ-lyon1.fr', 1, 'OQGvVY.jwt6yEKDEIZL3Q1xHLO8HccARQVbapVoD7qY', 'AD9WICqd/Q9MSFHER1g2xf2gBsBBpSrjJln3nPqKTj4lD7fel3lSQt954JV7w44INR2X7VMbHgCtQ/4s8GVGtQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Mohamed', 'EL AZZOUZI', 'mohamed', 'el azzouzi'),
(944, 'p1801978', 'p1801978', 'FAGGION.Jeremy@etu.univ-lyon1.fr', 'faggion.jeremy@etu.univ-lyon1.fr', 1, 'mlHdOXXAxnL0cUFkBAiDtIbYYJy8LRfuJJwfoDBM2sg', '3+/c+8uONKbbAautK6b0kpI5IaTrGbWafcKxMAnWjTyXreilWftUAqExwVTwmk7FKKbm2hRt3acx6TY+7cMjhw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Jeremy', 'FAGGION', 'jeremy', 'faggion'),
(945, 'p1809617', 'p1809617', 'FIDRY.Tom@etu.univ-lyon1.fr', 'fidry.tom@etu.univ-lyon1.fr', 1, 'lXZYS5xIe2qqxKvDPqzm7XCECExsibGZ8NA69NjBXJM', 'Y16oqfuqFwYZYkSrHNEiWx2phHOJwvuGiVJg/QcVggivHdjKzER0tCnfIV4eS0st4gJPDyumpjcCxskOaxmykQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Tom', 'FIDRY', 'tom', 'fidry'),
(946, 'p1801906', 'p1801906', 'GAILLARD.Loic@etu.univ-lyon1.fr', 'gaillard.loic@etu.univ-lyon1.fr', 1, 'N94OJo.sGCxSh35E3dEHN5T5rZ9VFu6rLj6gUXZsasQ', 'VJfo7dpvQd9JCo7j3hJTiEtrA16wxS6ZCpa91TJpmOuNVo8uQZRR5Hw5llns6f09GvQ7VDAAtbLS6V+Li+JmDw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Loic', 'GAILLARD', 'loic', 'gaillard'),
(947, 'p1807220', 'p1807220', 'GUYON.Tom@etu.univ-lyon1.fr', 'guyon.tom@etu.univ-lyon1.fr', 1, 'CEgrvfcrLPZFcTCOHDWtBpxFwNMPleyY0Z7yoDDhoVs', 'sfAp19SmOBeBqwGErSfPrcdIbiurFV9QyjqyY29iWfGyoRcb/wzKYx5soQwZlriCPkFVE4e9mIybO/GfPMMx4g==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Tom', 'GUYON', 'tom', 'guyon'),
(948, 'p1805931', 'p1805931', 'HUBERT.Joseph@etu.univ-lyon1.fr', 'hubert.joseph@etu.univ-lyon1.fr', 1, 'tNenltSqSrT5Y37C1cVtI49mTbtbTaTYp2uYuWSjDEg', 'FIDHTRrxHSZmpw58VYQLZ2BoULvVw1qkR2HLvlLr5XoalUDgfMQhUINQ7K0IpDPZa4S4m6D/T1I54bJ2SVnxLQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Joseph', 'HUBERT', 'joseph', 'hubert'),
(949, 'p1804383', 'p1804383', 'LAMBERT.Ugo@etu.univ-lyon1.fr', 'lambert.ugo@etu.univ-lyon1.fr', 1, '8BmbCHtdVJ3PWbkD9Z2QUCoW0I/dmPICkkQ8US5yWGc', 'r0oNWzGBptlssOajC1LPiFw96qa2KBAN5oBtcqxrswez6EX5raVXgfx8rR+//IsE/ou+b5J/qA71yuELpPfFaw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Ugo', 'LAMBERT', 'ugo', 'lambert'),
(950, 'p1800907', 'p1800907', 'LAVILLE.Guillaume@etu.univ-lyon1.fr', 'laville.guillaume@etu.univ-lyon1.fr', 1, 'OzjsuofubU4gsFl77f4lBLm.sB.mgqZHJVk4QgprV2c', 'AGqwl98AetTBAUQaWt7IGecGVH8pKnXdvzPjZ0Swv7iqGKAUHterZcwUtOX4OEM2ThayAulVwPPnzEErPaihsg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Guillaume', 'LAVILLE', 'guillaume', 'laville'),
(951, 'p1805738', 'p1805738', 'NARET.Steven@etu.univ-lyon1.fr', 'naret.steven@etu.univ-lyon1.fr', 1, 'DGe/EhsLkkmK/k9m.jH3zlPz8CQocO.PmzahbNnscv8', 'BX36tXw37yQEUDePppmWIGh5Ua14QVhxts6nQOzDwaqKnC5ZUu0LFoKczkncbRhyX5CFyT0SKQjPMxsDnQwqSA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Steven', 'NARET', 'steven', 'naret'),
(952, 'p1802145', 'p1802145', 'RANCHON.Dorian@etu.univ-lyon1.fr', 'ranchon.dorian@etu.univ-lyon1.fr', 1, 'YMUVtTyXyh3lc3jEZmt3VKrnTbXRLbFbfh/uXuItkyk', 'Cc5Mkbbk9wyqbIjcE1oqcuNGnvKpVrvA1Z6eTcTlVLJn84/aHfnpd7CGr2h8oTXlpslbmycin0aTeGo7W4g0yQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Dorian', 'RANCHON', 'dorian', 'ranchon'),
(953, 'p1801835', 'p1801835', 'RODRIGUEZ.Eric@etu.univ-lyon1.fr', 'rodriguez.eric@etu.univ-lyon1.fr', 1, 'Vag5gHFBjep/Jws3oaCXtrETd18fZfgradJSEoUfNAg', 'wth5422T8km0sVL9uxxjQPw7mfLCWntHCvazgokAsnsotOl2OwTNKfUCq/jsM2HzUm5vkygBgnsKNOpap1y5jQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Eric', 'RODRIGUEZ', 'eric', 'rodriguez'),
(954, 'p1808438', 'p1808438', 'ROMANET.Lucas@etu.univ-lyon1.fr', 'romanet.lucas@etu.univ-lyon1.fr', 1, 'yj67i.a77.CsW0UT3qcEU.whZucs1iAKa/Ada5ZnXvU', 'fruyn11R/oMLNzm5vNf54ew9Mc0xx0NFOkA/4yYHMBnPZXGKpqf9lfzfQK6GtNvo5DCoK4JVKGElIpAd4pEyKA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Lucas', 'ROMANET', 'lucas', 'romanet'),
(955, 'p1806451', 'p1806451', 'ROTH.Antoine@etu.univ-lyon1.fr', 'roth.antoine@etu.univ-lyon1.fr', 1, 'ghUyr2/C5YQycMJwVUAg1UgbbLjAjM6r.k/TMtqQtiU', 'xRRApE5S+O2hW23KD9XC5X47VMn/9L4+n8xEKB8zlfPD2gFs4V/1vFjpIyXGYI0C79mRpbjkzkTDqZ4XW4myMA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Antoine', 'ROTH', 'antoine', 'roth'),
(956, 'p1809576', 'p1809576', 'SAID ACHIRAFI.Hakim@etu.univ-lyon1.fr', 'said achirafi.hakim@etu.univ-lyon1.fr', 1, '/oPlJWgWQtcfuZdYHlnidCWjDLE07C3zFFA/zEGjrWU', '3tnA8s39cw34Az9Wk1HufZcywO/6l7KCWJkM+m+NsyZ/v4SCdD4oLGc7LYWmJDP/Kx1PJGHTIXmpOsxpXoY3Bg==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Hakim', 'SAID ACHIRAFI', 'hakim', 'said achirafi'),
(957, 'p1801601', 'p1801601', 'SENER.Emre@etu.univ-lyon1.fr', 'sener.emre@etu.univ-lyon1.fr', 1, 'g5jDKEgBylRkA4PCtWLQgujwssZV86eVj11YCbKWGV8', 'FmkyjLjzwE9MW93LCwEaK5u7d9O0yrtpA4N4m5NNb1q3uYrXryb0vivxfTWy/CS2xH57V7JIILISMxex3dh2Aw==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Emre', 'SENER', 'emre', 'sener'),
(958, 'p1810980', 'p1810980', 'VAUDAINE.Vincent@etu.univ-lyon1.fr', 'vaudaine.vincent@etu.univ-lyon1.fr', 1, 'hnkmaTZ2JuJ7cvaDd0GEOUj5Q0vkTGOQAeAwnb/NsdQ', '2APTEKu8/LohA77o5SmQgPUMWECUplRRD/t/2kdRuLkeQPaqmDqp/R2B0FUHbItCfeQ15GQODzeaABNhK3aF7g==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Vincent', 'VAUDAINE', 'vincent', 'vaudaine'),
(959, 'p1808627', 'p1808627', 'VIGNAT.Jean@etu.univ-lyon1.fr', 'vignat.jean@etu.univ-lyon1.fr', 1, '/lXKRUEpzqytVB2r1G.oF1gQYdDGHncdKPltyQj7xFk', 'OUHul2z63Pucxs/TY0bV9iHrBd8kfVbOPPzj8ZnX5vHCuWr1Mn3VwOsUA54iratwLFLUX37Zg4aW/xnY4CTtvA==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Jean', 'VIGNAT', 'jean', 'vignat'),
(960, 'p1802277', 'p1802277', 'ZOUIRI.Lina@etu.univ-lyon1.fr', 'zouiri.lina@etu.univ-lyon1.fr', 1, 'MP/SwywZRY92uf.VXLOQjUgxiBk1W/SRtPklwCHmUus', 'ZBGP7DKNiFZFuGvRAmxOPB3ETpdCH4sfir/SxbzrNW1kG9WTUvzEzBvHnNQLz/vVDUZhZuCbMauMS1161EFFJQ==', NULL, NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_ETUDIANT\";}', 'Lina', 'ZOUIRI', 'lina', 'zouiri'),
(966, 'djamal.benslimane', 'djamal.benslimane', 'benslimane.djamal@info.com', 'benslimane.djamal@info.com', 1, '4FncDs2EsBM9yhr.0UhRuM4zBRd6TLcCYdLRv683zuk', 'xozsja1UY9IBPn7ZigCZq6j06xnVSzNN8ztxbICUS1r4fIYfB1iWf84ZGO556waAp/J1asNAKOiyGf+K6bSfpg==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'DJAMAL', 'BENSLIMANE', 'djamal', 'benslimane'),
(967, 'kouami.toffa', 'kouami.toffa', 'toffa.kouami@info.com', 'toffa.kouami@info.com', 1, 'PvMYDF3Nz1p3Dq7c/6gMYSSVkKOpmjq8h5n2VtOATVU', 'KJJixRhDpLn6cdM5tZpBtYhETqOCjyXQPzBfpM0/D5kUQcpXNW8OpR9thW6NDMc7Ei6RERmn7cq+5FC3g4B58g==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'KOUAMI', 'TOFFA', 'kouami', 'toffa'),
(968, 'ariane.baron', 'ariane.baron', 'baron.ariane@info.com', 'baron.ariane@info.com', 1, 'Kz65GQKkBAT04xqcGwCFD229B2CAfDaRjGSyk2b9xP0', 'ztYAI1VKP0kvWPXuzrHsDWZdpNrwT608jUukfBrAhxyzX/j7svPNBXSxfaB6HZJSnSYGyFdFIAzNXOLCk5G6mQ==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'ARIANE', 'BARON', 'ariane', 'baron'),
(969, 'christophe.jaloux', 'christophe.jaloux', 'jaloux.christophe@info.com', 'jaloux.christophe@info.com', 1, '5s4IIMqTtBGS36dm3Rq/u1ztAgcBg19ERqK50cI/z6I', '1lW2EFCZX2wgqn2/+oxbA2Lxy7ZBAknP+brW9dxZg9PNhaRsryWYXZur0+pEbJK1UWO70E8dvOHbMW03Nc61QA==', '2019-04-06 14:53:38', NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'CHRISTOPHE', 'JALOUX', 'christophe', 'jaloux'),
(970, 'jocelyne.deboute', 'jocelyne.deboute', 'deboute.jocelyne@info.com', 'deboute.jocelyne@info.com', 1, 'RwZj.nbRuzsIdy30PC6qvkSSD/4RlXoRWcg2PXR8l6U', 'QqtZfdkdPFWkm1i+TkrYrururN3AMiZBHyccYJJPl+LxMWNSMHX2OPTWGkeI91NRmwU3oLzRumjaDQe/Roj/mQ==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'JOCELYNE', 'DEBOUTE', 'jocelyne', 'deboute'),
(971, 'xavier.merrheim', 'xavier.merrheim', 'merrheim.xavier@info.com', 'merrheim.xavier@info.com', 1, 'cqKUruD/34n73kkMzdul.aqO2fcHMwXgf/IWPar8THs', 'F3VYtBs4ENzxSAoGP8IILlVjz9+gxKDAoU1MW5jbiblmoNjn1oQ085m8HQUUWXfig57Ld+tKVOBblx8gs+Uopw==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'XAVIER', 'MERRHEIM', 'xavier', 'merrheim'),
(972, 'dufaud.abauzit', 'dufaud.abauzit', 'abauzit.dufaud@info.com', 'abauzit.dufaud@info.com', 1, 'PBmAjSCvWCjmdE7L1AK88niU7tImgqvTN1s9fgu/weo', 'KjIP2YJW23YA3kSYWbZ2hU8yQtKyD9n9IQxwzsoPCSjce0nq6xqQAgaoNHKxwI+9z4zr1Xx+fdtp1FlhpnoOSw==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'DUFAUD', 'ABAUZIT', 'dufaud', 'abauzit');
INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `name`, `surname`, `name_canonical`, `surname_canonical`) VALUES
(973, 'noura.faci', 'noura.faci', 'faci.noura@info.com', 'faci.noura@info.com', 1, 'EkYtG7aXIArAi19n.PcNVNirQnkeQf0JO4BvyuSsS/Q', '97rocHO5MhzVvJuwiXy/7CI6AzyvXskswrYe3wI04PM5OuWYp6TidsYZK/KkJKEYmOBZBBTR6ruytcVMUIegZg==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'NOURA', 'FACI', 'noura', 'faci'),
(974, 'isabelle.goncalves', 'isabelle.goncalves', 'goncalves.isabelle@info.com', 'goncalves.isabelle@info.com', 1, 'GwuZ.a6.qvPs.QOE7J7VyDRL/ab2GSc8ftYTG7TDS0o', 'S6aMzlwCl8QVcpVGwdMppxo+LkXPFcCsM+k/s+iIOypvcz2PTapPYgcwwKoby+V9C6ZaaA/4UGNEgCfRp/38tQ==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'ISABELLE', 'GONCALVES', 'isabelle', 'goncalves'),
(975, 'aude.joubert', 'aude.joubert', 'joubert.aude@info.com', 'joubert.aude@info.com', 1, 'Cp91ojDjST1yywky14rMEBmYf4Se27O7gj67J6u1q7k', 'DwOLbU0c2CLFNGv6oO/X2QLh8GmXpKyFiJTp3VEBQFrYC568rzZgKUIljqZiizsfWe0+QQx7FX4cKqc/FPbFCA==', '2019-01-17 18:19:21', NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'AUDE', 'JOUBERT', 'aude', 'joubert'),
(976, 'alexandra.lagache', 'alexandra.lagache', 'lagache.alexandra@info.com', 'lagache.alexandra@info.com', 1, 'yboEsTcotPVJTkdx9pNC0dfTlvRjhdi80iKz0IPS4BY', '7EiIihnTEz3BqL0DxeqqeU/ur/h79IXEEQQH/+J71kdACPu8I9BgktAl9vVmiQsdwWU7CCjnbpUYkxmyPSQLrA==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'ALEXANDRA', 'LAGACHE', 'alexandra', 'lagache'),
(977, 'aurelie.olivesi', 'aurelie.olivesi', 'olivesi.aurelie@info.com', 'olivesi.aurelie@info.com', 1, 'IGDI0v0YVc8YJc5l5AK.PQxGv2ttQBPJElu/JfpKIys', 'CutJJxhL/XPrkqScdfgCWC3zUbX0+hJqctM+8KaqTxALHPicH0I+Jvw2GXnWaLb/q2VyPLe7QEcuI/quoVo9uA==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'AURELIE', 'OLIVESI', 'aurelie', 'olivesi'),
(978, 'pierre.laforet', 'pierre.laforet', 'laforet.pierre@info.com', 'laforet.pierre@info.com', 1, 'jpi1na2caQ/pF4VYXh9hk07c.pdF1WY6rU1xTb5NMVE', 'H2xtGAYVoEhq2dsA+kXFzzW1ay6HkBy02W7EpgVEyQUUGMQ+g1Xud8lWBgt82olcqn8ESKeRYa8bJ0UQzfo5Qw==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'PIERRE', 'LAFORET', 'pierre', 'laforet'),
(979, 'ali.harkat', 'ali.harkat', 'harkat.ali@info.com', 'harkat.ali@info.com', 1, 'D.7v13EG.2ceW3Xzz/oFwdbXb9FXaQGF0PxBlCvgVGs', 'BGuXtGiLuIaM/6Kc0dw4bSpZ6X37Kdtj/b882Mi/0mXvbJahOuON+WfE3GbzlzgEk/m+3fN5PoripB9ckFpUsw==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'ALI', 'HARKAT', 'ali', 'harkat'),
(980, 'alves.domingues', 'alves.domingues', 'domingues.alves@info.com', 'domingues.alves@info.com', 1, 'U4eazBYC8N8tFyiKWVVlspKP4fNdyHq8qUK19YLqrO0', 'PpZfX9qF4wfQBRVYuOJgSku46Mn+OLvOZudjUxY1qhnMG3kX8VOiICdXufFupg8KmQE03d7xgE3DRzyvmoeK8w==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'ALVES', 'DOMINGUES', 'alves', 'domingues'),
(981, 'moneir.karouri', 'moneir.karouri', 'karouri.moneir@info.com', 'karouri.moneir@info.com', 1, 'WXa5RqR3BibkufLrCvB0.VSAaV6PiBgSITiR0Pj/3Ec', 'lrDEMyi1eC+Vuhy6GQfl1chavvPfPZmR2rwGy+fsx7SlPj6MOAz0o9FNx0GLJ7kDEWCou6F+G3IAeF/7PZtgEw==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'MONEIR', 'KAROURI', 'moneir', 'karouri'),
(982, 'isabelle.dautraix', 'isabelle.dautraix', 'dautraix.isabelle@info.com', 'dautraix.isabelle@info.com', 1, 'I8ymBPnLDKHqzzbhuD1NUBEc6qpoTktLM./QTZGl3BA', 'b+IAFAia3nHu2EAqaj28wF93lj9sGlLJ8miNPVc76Vg3R9XzJ2LiFBWDnK3YDeFl94yrLh3CRNYs8o9TYcGFEg==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'ISABELLE', 'DAUTRAIX', 'isabelle', 'dautraix'),
(983, 'samba.ndiaye', 'samba.ndiaye', 'ndiaye.samba@info.com', 'ndiaye.samba@info.com', 1, '4zEtPqoxr4.YfvbtTvaUG8mx0fV3u9OS3Jl/oK3FGZo', 'lAqcW4BrawJOz8pHH4HAd4vDfOZ2lbQfnkBYd7TUiJRcS0XIXJPrmFyNsfWnfhwOYFXptX+20HFKA1OL+cUy2w==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'SAMBA', 'NDIAYE', 'samba', 'ndiaye'),
(984, 'stephane.leroux', 'stephane.leroux', 'leroux.stephane@info.com', 'leroux.stephane@info.com', 1, 'r0ajCH1MkdUTZ5VsX4MU1g6a1QmM/C1HNKB0LxtKAQU', '7wSVqFFWb+xUCmLpP75gxBM/xZnIgAfZRkC29060bxpZtQJPt8at5H3le60v44hrIKdV5Tbc7Ayte1vrSvqVOw==', '2019-01-24 10:24:31', NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'STEPHANE', 'LEROUX', 'stephane', 'leroux'),
(985, 'ikbel.guidara', 'ikbel.guidara', 'guidara.ikbel@info.com', 'guidara.ikbel@info.com', 1, 'dRdjHQ.gL1mUTY6FDjOYe.5FICOsRTESrwNe4jU8ew8', '2XuRaOLjK6bAhXeRJTsz+7suhFOD41db4gnQVBR0AhaU+9TnWHM8xGaKm4xOviPLNFNwTKitGk0ppmoLOcciHw==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'IKBEL', 'GUIDARA', 'ikbel', 'guidara'),
(986, 'alain.pillot', 'alain.pillot', 'pillot.alain@info.com', 'pillot.alain@info.com', 1, 'bWEMQbOpP3njoEo9QmKy5HnMOZ8O20sMxeUdjMrugWA', 'KL+YeVdJgz4KSiuhvAFLqWzcRurUtDdnSRlgCQ9lJrDykVrsTJmBXslozDZvwHrdlvyWlhFu1I207hVSHck6Cw==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'ALAIN', 'PILLOT', 'alain', 'pillot'),
(987, 'clementine.breed', 'clementine.breed', 'breed.clementine@info.com', 'breed.clementine@info.com', 1, '4lgIxp3RTmgMQsYrPulXlWSLCtktWElC5suG1Qagpsk', 'tUdVXG81cBlaBYUlvpLF5O40TlkHlwVzPTl3MFlKhOd0zq83WZD2JwLylrxIgEIFsrbx0FmTroVbNzmc/AQg6g==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'CLEMENTINE', 'BREED', 'clementine', 'breed'),
(988, 'cedric.gallo', 'cedric.gallo', 'gallo.cedric@info.com', 'gallo.cedric@info.com', 1, '5OoCFde4MA4eFobttG5jhPoj0xT7nT7nVt3gxOehZ6A', '8flfH5V/bM1hD/bhq7JX0Lryr56WndDQG8xsMSd3MVGMFW9Uvh/s8wIvnWM2i3CN+tyi7wHvFnTHJwqKOjnuIA==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'CEDRIC', 'GALLO', 'cedric', 'gallo'),
(990, 'dominique.rouille', 'dominique.rouille', 'rouille.dominique@info.com', 'rouille.dominique@info.com', 1, '9kg/iN2lRCsAMDn4Fd95IUV4SguVNsyyK.GxM9UxLJw', 'hK6wgxmCKc2WQBxrPXgh34D0rRHP2dqZ7h6vE24absiiwCXN/vUQYAdc7Kd2hsbHeifDf2seNacP7cMERGFgXg==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'DOMINIQUE', 'ROUILLE', 'dominique', 'rouille'),
(992, 'laurine.dechavanne', 'laurine.dechavanne', 'dechavanne.laurine@info.com', 'dechavanne.laurine@info.com', 1, 'ed7d5bW0xWALqhh83mlA4112rCw1a8VsqZ5PRbGxyyI', '4GuYYHcu/YIx08qQFzwQFAoBlQcXFci5Nc0AJu+aJvV2bnfc7YosTJuNFl9+QBvUXMSUaEgTbKWDyrz+RsOtqg==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'LAURINE', 'DECHAVANNE', 'laurine', 'dechavanne'),
(993, 'remi.watrigant', 'remi.watrigant', 'watrigant.remi@info.com', 'watrigant.remi@info.com', 1, 'oZsTaTB5QkPO7.fvEFOHaBqB58X.B3ulc8IGSEZttUU', 'asoIBCnuK/ObUZ9c5KWY7ar4Xzx5kAltUE59iDO/tgYGOawTaCEWb/Z/2Fcv+7y2tmMhYeMHzR6KnidZMUE6Yg==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'REMI', 'WATRIGANT', 'remi', 'watrigant'),
(994, 'veronique.deslandres', 'veronique.deslandres', 'deslandres.veronique@info.com', 'deslandres.veronique@info.com', 1, 'G.PXCfg0lmFgCubk375Y/Bk7CkVaSkKcLX7TwsVZfSY', 'IOghgmGXLp2v6aFnG201HozgNq83lpiX2pRTPie6JPjsrDKbJOI7PiRiSamHOGgsdeqjtRTRngpL9AxdwxT1sw==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'VERONIQUE', 'DESLANDRES', 'veronique', 'deslandres'),
(996, 'anne.corrigan', 'anne.corrigan', 'corrigan.anne@info.com', 'corrigan.anne@info.com', 1, 'u1wY6ry9CSvR86ywmjOJVKFq1BZ/2mDDyD3SrnQrGhc', 'GpuqgZYODD/pCtGjhcB2zrfOf+T4qedu01vKaSjDK6rI02oIgcesXqgLmbUVvc8H/PBLAduBa6WrDv/Wfo7bmQ==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'ANNE', 'CORRIGAN', 'anne', 'corrigan'),
(997, 'victor.perrin', 'victor.perrin', 'perrin.victor@info.com', 'perrin.victor@info.com', 1, 'TX.qqD3s9yFrqC6QVP623DBm/TdkEWOURA4QSHEl7kw', 'KPkLt3ySzlbHBmkBdE/+refaZbfBxDQIeuo+WKCwAAd8rAYskzvSs6R8VCTZLi2vlzxd8aFV32eF8OfrIColwg==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'VICTOR', 'PERRIN', 'victor', 'perrin'),
(998, 'christine.bonnet', 'christine.bonnet', 'bonnet.christine@info.com', 'bonnet.christine@info.com', 1, 'vRdTIpe90FBon6amsvYPgsiNADu/yFJYEyyZdBx4UJQ', 'MWGg774pWm3uIUsiK5n879mXFW1yQ/oPNxUXaXM6gy4wNOoI7fLrSV+fcbTpsmW2x3jTP58pKSJv2xxUM8eCNw==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'CHRISTINE', 'BONNET', 'christine', 'bonnet'),
(999, 'julien.bonneton', 'julien.bonneton', 'bonneton.julien@info.com', 'bonneton.julien@info.com', 1, '470m7sfej/U5JeepGh6YYIQDkQgAhmIdskqYGe7MGLw', 'vLFkQ8AWIFH8iSG/NuaMklOGAWoriPJ4nb6iQHwDTirgp7cSpCt8pSFcU7NaSkNJGbnyW7Lwud6wVLYvBorymA==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'JULIEN', 'BONNETON', 'julien', 'bonneton'),
(1000, 'myriam.fort', 'myriam.fort', 'fort.myriam@info.com', 'fort.myriam@info.com', 1, 'uNWx6CKfX0ugZkqzuy5yrAbeI2regJySR6pyfBjsBeA', 'Ab5WrzgmKrIy2ncDxbnBc41fM35gWRAbIOnMt6qMvTCGM7+b7Pyk3S2t/EdsXwdFQYRjKrKDcYAJ8Tr/IFVLAg==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'MYRIAM', 'FORT', 'myriam', 'fort'),
(1001, 'xavier.ribot', 'xavier.ribot', 'ribot.xavier@info.com', 'ribot.xavier@info.com', 1, 'tJ.AvF/g50Q302bakauOh3oiPySrKbfbEALZimm4qqo', 'KdoGTAOYWk0mPfCTTqwgQuNRY8pN75PAo1UisUEYhXtRMMlfgQNYp+NH5ClMNxH9WljqzeXWtDPUE6p7nj+yzg==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'XAVIER', 'RIBOT', 'xavier', 'ribot'),
(1002, 'anthony.busson', 'anthony.busson', 'busson.anthony@info.com', 'busson.anthony@info.com', 1, 'uj7NL.8HSLb37O4B/uiHncn5T1gYpou1HLYFNlk5y40', 's9ixvYPMaYi7oYePAxtt5qVIBui4grnd7A9Mvt5Styv7u/ADlLid+AI8B6w+Em68wU/95jdEybdjua1LBSNgrQ==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'ANTHONY', 'BUSSON', 'anthony', 'busson'),
(1003, 'florent.duclos', 'florent.duclos', 'duclos.florent@info.com', 'duclos.florent@info.com', 1, '2ppnbNbILAa/.u/aTRK935To2TFNf0UT1wJtjVzZu2o', 'd3ZQBqQEcjsapAMLX7DBlLEoZPFw7QdcBvTBB1oOgtHlkdrbwXZ8OwQ4JsgS2yougzsjpIqBaifYbX49/iCvLQ==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'FLORENT', 'DUCLOS', 'florent', 'duclos'),
(1004, 'ludovic.maindron', 'ludovic.maindron', 'maindron.ludovic@info.com', 'maindron.ludovic@info.com', 1, 'Qrzgc2Ps3gvcUIZss6qDqXv9zkHmkK7Ts06RRPcbYrk', 'rbm30CBHYVRhpaJUTTtLgPiaS1mJgAWTPt4Pv3+oGzSlGXFbBEGNSoUKUoSBkJd18ToYPblujiZWvt9/EJFXow==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'LUDOVIC', 'MAINDRON', 'ludovic', 'maindron'),
(1005, 'mohammed.belkhatir', 'mohammed.belkhatir', 'belkhatir.mohammed@info.com', 'belkhatir.mohammed@info.com', 1, 'nTR7KXzw5oJVcQhHA055Pl0Zf7Jv2.LNRbAuzHZEVzM', 'OHkw0qnlxOZeST8DmJtnCDHiRDAm+j37pyuQ9ZrHU7lZ2CQDjoZwY1jve76h87i1keMz9RDJ9CIGg26IciJsWg==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'MOHAMMED', 'BELKHATIR', 'mohammed', 'belkhatir'),
(1006, 'zied.sayari', 'zied.sayari', 'sayari.zied@info.com', 'sayari.zied@info.com', 1, 'aDZklEPfrxELOS7wy4GD2sY4MNcAiG4pqepo6Ip6YnM', 'IiIlfRNYe78pybSUvMHoiQVPxO1hlaH0gpvTOINv2YJ3cpNg8IxZn4ibo02xOJXSMEHrySu1WSWEHxK2DcH/Dw==', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_TEACHER\";}', 'ZIED', 'SAYARI', 'zied', 'sayari'),
(1007, 'administrateur', 'administrateur', 'administrateur@univ-lyon.fr', 'administrateur@univ-lyon.fr', 1, 'PQfvzGgtblrs/PSJAjR21KSrGlPtuA.pI1PhbkvNmPM', 'q9+A++zDImgxyHziPP//+TV27V77Lo+0Gl4p/BwAX9ea3X33cv4QPLudaeQd2ZeYCGN3pPsvaowFmMwmazqUhw==', '2019-04-03 10:19:25', NULL, NULL, 'a:1:{i:0;s:19:\"ROLE_ADMINISTRATEUR\";}', 'Monsieur', 'Administrateur', 'monsieur', 'administrateur');


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
