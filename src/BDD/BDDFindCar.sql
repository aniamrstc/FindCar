-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 27 fév. 2023 à 08:46
-- Version du serveur :  10.3.37-MariaDB-0ubuntu0.20.04.1
-- Version de PHP : 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `BDDFindCar`
--
CREATE DATABASE IF NOT EXISTS `BDDFindCar` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `BDDFindCar`;

-- --------------------------------------------------------

--
-- Structure de la table `Carburant`
--

CREATE TABLE `Carburant` (
  `IdCarburant` int(11) NOT NULL,
  `typeCarburant` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Marques`
--

CREATE TABLE `Marques` (
  `IdMarque` int(11) NOT NULL,
  `Marque` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Places`
--

CREATE TABLE `Places` (
  `IdNbPlaces` int(11) NOT NULL,
  `nbPlace` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Portes`
--

CREATE TABLE `Portes` (
  `IdNbPorte` int(11) NOT NULL,
  `NbPorte` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Reservation`
--

CREATE TABLE `Reservation` (
  `IdUtilisateur` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `DateFin` date NOT NULL,
  `IdVehicule` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Transmission`
--

CREATE TABLE `Transmission` (
  `IdTransmission` int(11) NOT NULL,
  `typeTransmission` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE `Utilisateurs` (
  `IdUtilisateur` int(11) NOT NULL,
  `Email` text NOT NULL,
  `MotDePasse` text NOT NULL,
  `NbPermis` int(100) NOT NULL,
  `Date` date NOT NULL,
  `Actif` varchar(50) NOT NULL,
  `Admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Vehicules`
--

CREATE TABLE `Vehicules` (
  `IdVehicule` int(11) NOT NULL,
  `nomVehicule` text NOT NULL,
  `prixJour` varchar(100) NOT NULL,
  `IdNbPlaces` int(11) NOT NULL,
  `IdTransmission` int(11) NOT NULL,
  `IdCarburant` int(11) NOT NULL,
  `IdNbPortes` int(11) NOT NULL,
  `IdMarque` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Carburant`
--
ALTER TABLE `Carburant`
  ADD PRIMARY KEY (`IdCarburant`);

--
-- Index pour la table `Marques`
--
ALTER TABLE `Marques`
  ADD PRIMARY KEY (`IdMarque`);

--
-- Index pour la table `Places`
--
ALTER TABLE `Places`
  ADD PRIMARY KEY (`IdNbPlaces`);

--
-- Index pour la table `Portes`
--
ALTER TABLE `Portes`
  ADD PRIMARY KEY (`IdNbPorte`);

--
-- Index pour la table `Reservation`
--
ALTER TABLE `Reservation`
  ADD KEY `IdUtilisateur` (`IdUtilisateur`),
  ADD KEY `IdVehicule` (`IdVehicule`);

--
-- Index pour la table `Transmission`
--
ALTER TABLE `Transmission`
  ADD PRIMARY KEY (`IdTransmission`);

--
-- Index pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  ADD PRIMARY KEY (`IdUtilisateur`);

--
-- Index pour la table `Vehicules`
--
ALTER TABLE `Vehicules`
  ADD PRIMARY KEY (`IdVehicule`),
  ADD KEY `IdCarburant` (`IdCarburant`),
  ADD KEY `IdMarque` (`IdMarque`),
  ADD KEY `IdNbPlaces` (`IdNbPlaces`),
  ADD KEY `IdNbPortes` (`IdNbPortes`),
  ADD KEY `IdTransmission` (`IdTransmission`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Carburant`
--
ALTER TABLE `Carburant`
  MODIFY `IdCarburant` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Marques`
--
ALTER TABLE `Marques`
  MODIFY `IdMarque` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Places`
--
ALTER TABLE `Places`
  MODIFY `IdNbPlaces` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Portes`
--
ALTER TABLE `Portes`
  MODIFY `IdNbPorte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Transmission`
--
ALTER TABLE `Transmission`
  MODIFY `IdTransmission` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  MODIFY `IdUtilisateur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Vehicules`
--
ALTER TABLE `Vehicules`
  MODIFY `IdVehicule` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Reservation`
--
ALTER TABLE `Reservation`
  ADD CONSTRAINT `Reservation_ibfk_1` FOREIGN KEY (`IdUtilisateur`) REFERENCES `Utilisateurs` (`IdUtilisateur`),
  ADD CONSTRAINT `Reservation_ibfk_2` FOREIGN KEY (`IdVehicule`) REFERENCES `Vehicules` (`IdVehicule`);

--
-- Contraintes pour la table `Vehicules`
--
ALTER TABLE `Vehicules`
  ADD CONSTRAINT `Vehicules_ibfk_1` FOREIGN KEY (`IdCarburant`) REFERENCES `Carburant` (`IdCarburant`),
  ADD CONSTRAINT `Vehicules_ibfk_2` FOREIGN KEY (`IdMarque`) REFERENCES `Marques` (`IdMarque`),
  ADD CONSTRAINT `Vehicules_ibfk_3` FOREIGN KEY (`IdNbPlaces`) REFERENCES `Places` (`IdNbPlaces`),
  ADD CONSTRAINT `Vehicules_ibfk_4` FOREIGN KEY (`IdNbPortes`) REFERENCES `Portes` (`IdNbPorte`),
  ADD CONSTRAINT `Vehicules_ibfk_5` FOREIGN KEY (`IdTransmission`) REFERENCES `Transmission` (`IdTransmission`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
