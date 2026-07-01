-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 17 juin 2026 à 10:57
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `basephp`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `Login` varchar(20) NOT NULL,
  `Code_Admin` int(10) NOT NULL,
  `MotdePasse` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`Login`, `Code_Admin`, `MotdePasse`) VALUES
('Kanto', 2447, '1234');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `Matriculle` varchar(20) NOT NULL,
  `Nom` varchar(60) NOT NULL,
  `Prénoms` varchar(60) NOT NULL,
  `Niveau` enum('L1','L2','L3','M1','M2') NOT NULL,
  `Parcours` enum('GB','SR','IG') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`Matriculle`, `Nom`, `Prénoms`, `Niveau`, `Parcours`) VALUES
('2112', 'MIRARINTSOA ', 'Tendry Niaina', 'M2', 'GB'),
('2113', 'SAFIDISOA ', 'Ferdinand Fanilo', 'M2', 'GB'),
('2414 H-F', 'RAZAFISTOA', 'Tefinjanahary Olivia', 'L3', 'IG'),
('2447 H-F', 'HERINAINA', 'Sarindra Harikanto', 'L3', 'IG'),
('2545', 'MALALATIANA', 'Sedera Sarobidy', 'M2', 'SR'),
('2554', 'RAZANADRAKOTO', 'Finoana Fenohasina', 'L3', 'SR'),
('268 H-Tol', 'HERIMANJAKA', 'Finaritra TIana', 'L3', 'IG'),
('448 H-Tol', 'ZAFINDRAMORA', 'Mahefa Anthonio', 'M2', 'IG');

-- --------------------------------------------------------

--
-- Structure de la table `organisme`
--

CREATE TABLE `organisme` (
  `Id_Organisme` int(10) NOT NULL,
  `Design` varchar(30) NOT NULL,
  `Lieu` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

CREATE TABLE `professeur` (
  `Id_Prof` varchar(20) NOT NULL,
  `Nom_Prof` varchar(60) NOT NULL,
  `Prenom_Prof` varchar(60) NOT NULL,
  `Civilite` enum('Mr','Mlle','Mme') NOT NULL,
  `Grade` enum('Professeur titulaire','Maître de Conférences','Assistant\r\n    d''Enseignement Supérieur et de Recherche','Docteur HDR','Docteur en Informatique','Doctorant en informatique') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `soutenir`
--

CREATE TABLE `soutenir` (
  `Matriculle` varchar(20) NOT NULL,
  `Id_Organisme` int(10) NOT NULL,
  `Annee_Universitaire` varchar(9) NOT NULL,
  `Note` int(11) DEFAULT NULL CHECK (`Note` >= 0 and `Note` <= 20),
  `President` varchar(20) NOT NULL,
  `Examinateur` varchar(20) NOT NULL,
  `Rapporteur_int` varchar(20) NOT NULL,
  `Rapporteur_ext` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Code_Admin`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`Matriculle`);

--
-- Index pour la table `organisme`
--
ALTER TABLE `organisme`
  ADD PRIMARY KEY (`Id_Organisme`);

--
-- Index pour la table `professeur`
--
ALTER TABLE `professeur`
  ADD PRIMARY KEY (`Id_Prof`);

--
-- Index pour la table `soutenir`
--
ALTER TABLE `soutenir`
  ADD PRIMARY KEY (`Matriculle`,`Id_Organisme`,`Annee_Universitaire`),
  ADD KEY `President` (`President`),
  ADD KEY `Examinateur` (`Examinateur`),
  ADD KEY `Rapporteur_int` (`Rapporteur_int`),
  ADD KEY `Rapporteur_ext` (`Rapporteur_ext`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `soutenir`
--
ALTER TABLE `soutenir`
  ADD CONSTRAINT `soutenir_ibfk_1` FOREIGN KEY (`Matriculle`) REFERENCES `etudiant` (`Matriculle`),
  ADD CONSTRAINT `soutenir_ibfk_2` FOREIGN KEY (`President`) REFERENCES `professeur` (`Id_Prof`),
  ADD CONSTRAINT `soutenir_ibfk_3` FOREIGN KEY (`Examinateur`) REFERENCES `professeur` (`Id_Prof`),
  ADD CONSTRAINT `soutenir_ibfk_4` FOREIGN KEY (`Rapporteur_int`) REFERENCES `professeur` (`Id_Prof`),
  ADD CONSTRAINT `soutenir_ibfk_5` FOREIGN KEY (`Rapporteur_ext`) REFERENCES `professeur` (`Id_Prof`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
