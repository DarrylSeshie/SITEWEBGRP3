-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 17 avr. 2024 à 20:00
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cermed_test`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

CREATE TABLE `adresse` (
  `id_adresse` int(11) NOT NULL,
  `rue_numero` varchar(100) DEFAULT NULL,
  `code_postal` int(11) DEFAULT NULL,
  `localite` varchar(100) DEFAULT NULL,
  `pays` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`id_adresse`, `rue_numero`, `code_postal`, `localite`, `pays`) VALUES
(1, 'Trieu Kaisin 136 ', 6061, 'Charleroi', 'Belgique'),
(2, 'Chauss de binche 159 ', 7000, 'Mons', 'Belgique'),
(3, 'Bd Dolez 31 ', 7000, 'Mons', 'Belgique'),
(4, '123 Rue Principale', 1000, 'Bruxelles', 'Belgique'),
(5, '456 Avenue Centrale', 2000, 'Anvers', 'Belgique'),
(6, '789 Boulevard Central', 3000, 'Louvain', 'Belgique'),
(7, '101 Rue du Centre', 4000, 'Liège', 'Belgique'),
(8, 'Bd Dolez 31 ', 7000, 'Mons', 'Belgique'),
(9, '123 Rue Principale', 1000, 'Bruxelles', 'Belgique'),
(10, '456 Avenue Centrale', 2000, 'Anvers', 'Belgique'),
(11, '789 Boulevard Central', 3000, 'Louvain', 'Belgique'),
(12, '101 Rue du Centre', 4000, 'Liège', 'Belgique'),
(13, 'Bd Dolez 31 ', 7000, 'Mons', 'Belgique'),
(14, '123 Rue Principale', 1000, 'Bruxelles', 'Belgique'),
(15, '456 Avenue Centrale', 2000, 'Anvers', 'Belgique'),
(16, '789 Boulevard Central', 3000, 'Louvain', 'Belgique'),
(17, '101 Rue du Centre', 4000, 'Liège', 'Belgique');

-- --------------------------------------------------------

--
-- Structure de la table `donne`
--

CREATE TABLE `donne` (
  `id_utilisateur` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `donne`
--

INSERT INTO `donne` (`id_utilisateur`, `id_produit`) VALUES
(11, 4),
(11, 5),
(12, 3),
(12, 6),
(12, 9),
(15, 2),
(15, 6),
(15, 7),
(19, 1),
(19, 4);

-- --------------------------------------------------------

--
-- Structure de la table `est_partenaire`
--

CREATE TABLE `est_partenaire` (
  `id_institution` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `type_de_partenariat` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `est_partenaire`
--

INSERT INTO `est_partenaire` (`id_institution`, `id_produit`, `type_de_partenariat`) VALUES
(1, 1, 'Assension A'),
(1, 10, 'OEH J'),
(2, 1, 'Amour K'),
(2, 2, 'Budget Commune B'),
(3, 2, 'Bien etre L'),
(3, 3, 'Patriote C'),
(4, 3, 'Sante M'),
(4, 4, 'Revolution D'),
(5, 4, 'Planing Familiale N'),
(5, 5, 'Lutte E'),
(6, 5, 'Vie commun O'),
(6, 6, 'Agression F'),
(7, 7, 'Justice G'),
(7, 9, 'FFF I');

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `id_image` int(11) NOT NULL,
  `url_image` varchar(200) DEFAULT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id_image`, `url_image`, `nom`) VALUES
(1, 'https://www.helha.be/app/uploads/2022/05/vignette-helha2.jpg', 'Image Helha 1'),
(2, 'https://www.bde-group.be/wp-content/uploads/2017/11/Image1-300x169.png', 'Image BDE Group'),
(3, 'https://pbs.twimg.com/profile_images/651375653082652672/fEr3_2_M_400x400.png', 'Twitter Profile Image'),
(4, 'https://www.helha.be/app/uploads/2022/07/dernierjourdecours-PUB.jpg', 'Dernier Jour de Cours'),
(5, 'https://www.helha.be/app/uploads/2023/09/Ecrire-a-la-HELHa-ConnectED.png', 'Ecrire à la HELHa ConnectED');

-- --------------------------------------------------------

--
-- Structure de la table `institution`
--

CREATE TABLE `institution` (
  `id_institution` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `logo` varchar(200) DEFAULT NULL,
  `id_adresse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `institution`
--

INSERT INTO `institution` (`id_institution`, `nom`, `logo`, `id_adresse`) VALUES
(1, 'Helha', 'https://www.helha.be/app/uploads/2022/05/vignette-helha2.jpg', 1),
(2, 'Umons', 'https://i.ytimg.com/vi/hpfYij7Wx0k/maxresdefault.jpg', 3),
(3, 'UNamur', 'https://i.ytimg.com/vi/hpfYij7Wx0k/maxresdefault.jpg', 4),
(4, 'ULiege', 'https://i.ytimg.com/vi/hpfYij7Wx0k/maxresdefault.jpg', 3),
(5, 'ULB', 'https://i.ytimg.com/vi/hpfYij7Wx0k/maxresdefault.jpg', 4),
(6, 'HEH', 'https://i.ytimg.com/vi/hpfYij7Wx0k/maxresdefault.jpg', 3),
(7, 'ULouvain la Neuve', 'https://i.ytimg.com/vi/hpfYij7Wx0k/maxresdefault.jpg', 3),
(8, 'UGI', 'https://i.ytimg.com/vi/hpfYij7Wx0k/maxresdefault.jpg', 3);

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

CREATE TABLE `lieu` (
  `id_lieu` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `batiment` varchar(50) DEFAULT NULL,
  `locaux` varchar(50) DEFAULT NULL,
  `id_institution` int(11) NOT NULL,
  `id_adresse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `lieu`
--

INSERT INTO `lieu` (`id_lieu`, `nom`, `batiment`, `locaux`, `id_institution`, `id_adresse`) VALUES
(1, 'Helha_montignie', 'Batiment A', 'E206', 1, 1),
(2, 'Helha_Mons', 'Batiment B', 'B201', 1, 2),
(3, 'Umons', 'Batiment C', 'Locaux C', 2, 3),
(4, 'Helha_gilly', 'Batiment A', 'E206', 1, 1),
(5, 'HEH_', 'Batiment B', 'B201', 1, 2),
(6, 'Umons', 'Batiment C', 'Locaux C', 2, 3),
(7, 'Umons', 'Batiment C', 'Locaux C', 2, 3),
(8, 'Helha_gilly', 'Batiment A', 'E206', 1, 1),
(9, 'HEH_', 'Batiment B', 'B201', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `participe`
--

CREATE TABLE `participe` (
  `id_utilisateur` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `participe`
--

INSERT INTO `participe` (`id_utilisateur`, `id_produit`) VALUES
(20, 1),
(20, 2),
(20, 3),
(21, 2),
(21, 3),
(21, 6),
(22, 3),
(22, 4),
(22, 7),
(23, 2),
(23, 4),
(23, 6),
(24, 2),
(24, 5),
(24, 9),
(25, 4),
(25, 6),
(25, 9);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL,
  `titre` varchar(100) DEFAULT NULL,
  `sous_titre` varchar(150) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `date_fin_inscription` date DEFAULT NULL,
  `descriptif` varchar(500) NOT NULL,
  `objectif` varchar(250) DEFAULT NULL,
  `contenu` varchar(250) DEFAULT NULL,
  `methodologie` varchar(250) DEFAULT NULL,
  `public_cible` varchar(250) DEFAULT NULL,
  `prix` double DEFAULT NULL,
  `id_image` int(11) NOT NULL,
  `id_lieu` int(11) NOT NULL,
  `id_type_produit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `titre`, `sous_titre`, `date_debut`, `date_fin`, `date_fin_inscription`, `descriptif`, `objectif`, `contenu`, `methodologie`, `public_cible`, `prix`, `id_image`, `id_lieu`, `id_type_produit`) VALUES
(1, 'Formation 1', 'Description de la formation 1', '2024-05-01', '2024-05-10', '2024-04-25', 'Ceci est le descriptif de la formation 1', 'Objectif de la formation 1', 'Contenu de la formation 1', 'Méthodologie de la formation 1', 'Public cible de la formation 1', 10, 1, 1, 1),
(2, 'Formation 2', 'Description de la formation 2', '2024-06-01', '2024-06-10', '2024-05-25', 'Ceci est le descriptif de la formation 2', 'Objectif de la formation 2', 'Contenu de la formation 2', 'Méthodologie de la formation 2', 'Public cible de la formation 2', 12, 2, 1, 1),
(3, 'Formation 3', 'Description de la formation 3', '2024-07-01', '2024-07-10', '2024-06-25', 'Ceci est le descriptif de la formation 3', 'Objectif de la formation 3', 'Contenu de la formation 3', 'Méthodologie de la formation 3', 'Public cible de la formation 3', 20, 3, 1, 1),
(4, 'Formation 4', 'Description de la formation 4', '2024-08-01', '2024-08-10', '2024-07-25', 'Ceci est le descriptif de la formation 4', 'Objectif de la formation 4', 'Contenu de la formation 4', 'Méthodologie de la formation 4', 'Public cible de la formation 4', 11, 4, 1, 1),
(5, 'Formation 5', 'Description de la formation 5', '2024-09-01', '2024-09-10', '2024-08-25', 'Ceci est le descriptif de la formation 5', 'Objectif de la formation 5', 'Contenu de la formation 5', 'Méthodologie de la formation 5', 'Public cible de la formation 5', 5, 5, 1, 1),
(6, 'Journée 1', 'Description de la journée 1', '2024-05-15', '2024-05-15', '2024-05-10', 'Ceci est le descriptif de la journée 1', 'Objectif de la journée 1', 'Contenu de la journée 1', 'Méthodologie de la journée 1', 'Public cible de la journée 1', 50, 5, 1, 2),
(7, 'Journée 2', 'Description de la journée 2', '2024-06-15', '2024-06-15', '2024-06-10', 'Ceci est le descriptif de la journée 2', 'Objectif de la journée 2', 'Contenu de la journée 2', 'Méthodologie de la journée 2', 'Public cible de la journée 2', 60, 4, 1, 2),
(8, 'Journée 3', 'Description de la journée 3', '2024-07-15', '2024-07-15', '2024-07-10', 'Ceci est le descriptif de la journée 3', 'Objectif de la journée 3', 'Contenu de la journée 3', 'Méthodologie de la journée 3', 'Public cible de la journée 3', 55, 3, 1, 2),
(9, 'Journée 4', 'Description de la journée 4', '2024-08-15', '2024-08-15', '2024-08-10', 'Ceci est le descriptif de la journée 4', 'Objectif de la journée 4', 'Contenu de la journée 4', 'Méthodologie de la journée 4', 'Public cible de la journée 4', 65, 2, 1, 2),
(10, 'Journée 5', 'Description de la journée 5', '2024-09-15', '2024-09-15', '2024-09-10', 'Ceci est le descriptif de la journée 5', 'Objectif de la journée 5', 'Contenu de la journée 5', 'Méthodologie de la journée 5', 'Public cible de la journée 5', 70, 1, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_role`, `nom`) VALUES
(1, 'Admin'),
(2, 'Gestionnaire'),
(3, 'Formateur'),
(4, 'Client');

-- --------------------------------------------------------

--
-- Structure de la table `type_produit`
--

CREATE TABLE `type_produit` (
  `id_type_produit` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type_produit`
--

INSERT INTO `type_produit` (`id_type_produit`, `nom`) VALUES
(1, 'Formation'),
(2, 'Journée');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `civilite` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(50) DEFAULT NULL,
  `gsm` varchar(50) DEFAULT NULL,
  `TVA` varchar(100) DEFAULT NULL,
  `profession` varchar(50) DEFAULT NULL,
  `gsm_pro` varchar(50) DEFAULT NULL,
  `email_pro` varchar(100) DEFAULT NULL,
  `id_role` int(11) NOT NULL,
  `id_institution` int(11) DEFAULT NULL,
  `id_adresse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `civilite`, `nom`, `prenom`, `email`, `mot_de_passe`, `gsm`, `TVA`, `profession`, `gsm_pro`, `email_pro`, `id_role`, `id_institution`, `id_adresse`) VALUES
(2, 'Mr', 'Stoffel', 'Jean-Francois', 'stoffeljf@helha.be', 'AdminHelha1234', '048xxxxxxx', NULL, 'Etudiant', NULL, NULL, 1, NULL, 1),
(3, 'Mr', 'The_D', 'Darryl', 'la226963@student.helha.be', 'mdp123', '123456789', NULL, 'Etudiant', NULL, NULL, 1, NULL, 4),
(4, 'Mr', 'Celestinio', 'Geni', 'la22xxxx@student.helha.be', 'mdp123', '987654321', NULL, 'Etudiant', NULL, NULL, 1, NULL, 5),
(5, 'M.', 'Durand', 'Pierre', 'pierre.durand@example.com', 'securepwd789', '0487654321', 'LU456789123', 'Chirurgien orthopédiste', '0456789012', 'pierre.durand@clinique.lu', 4, 1, 3),
(6, 'Mlle', 'Lefevre', 'Sophie', 'sophie.lefevre@example.com', 'pass123word', '0654321876', 'DE654321789', 'Kinésithérapeute', '0478901234', 's.lefevre@cabinet.de', 2, 2, 4),
(7, 'Mme', 'Moreau', 'Julie', 'julie.moreau@example.com', 'password789', '0687654321', 'IT987654321', 'Sage-femme', '0487654321', 'j.moreau@clinique.it', 2, 1, 4),
(8, 'M.', 'Garcia', 'Antoine', 'antoine.garcia@example.com', 'securepwd987', '0756789012', 'NL123456789', 'Psychiatre', '0456789012', 'antoine.garcia@hopital.nl', 4, 1, 2),
(9, 'Mr', 'Roux', 'Luc', 'luc.roux@example.com', 'mdp789012', '0612345678', 'PT456789123', 'Dentiste', '0478901234', 'l.roux@dental.pt', 2, 2, 4),
(10, 'Mme', 'Leroy', 'Claire', 'claire.leroy@example.com', 'password123', '0734567890', 'CH987654321', 'Pharmacienne', '0490123456', 'c.leroy@pharma.ch', 2, 2, 4),
(11, 'Mme', 'Robert', 'Julie', 'julie.robert@example.com', 'password123', '0687654321', 'DE210987654', 'Enseignante', '0611223344', 'julie.robert@pro.example.com', 3, NULL, 6),
(12, 'M.', 'Moreau', 'Luc', 'luc.moreau@example.com', 'secret456', '0612345678', 'FR678901234', 'Développeur', '0687654321', 'luc.moreau@pro.example.com', 3, NULL, 7),
(13, 'M.', 'Garcia', 'Antoine', 'antoine.garcia@example.com', 'password789', '0612345678', 'DE109876543', 'Designer', '0698765432', 'antoine.garcia@pro.example.com', 4, NULL, 1),
(14, 'Mme', 'Fournier', 'Sophie', 'sophie.fournier@example.com', 'pass456', '0678912345', 'FR321098765', 'Chercheuse', '0612345678', 'sophie.fournier@pro.example.com', 4, NULL, 1),
(15, 'M.', 'Roux', 'Paul', 'paul.roux@example.com', 'secure123', '0601020304', 'BE987654321', 'Ingénieur Civil', '0678912345', 'paul.roux@pro.example.com', 3, NULL, 1),
(16, 'Mme', 'Caron', 'Céline', 'celine.caron@example.com', 'mdp456', '0698765432', 'DE876543210', 'Comptable', '0612345678', 'celine.caron@pro.example.com', 4, NULL, 2),
(17, 'Mme', 'Guerin', 'Camille', 'camille.guerin@example.com', 'secret789', '0612233445', 'BE210987654', 'Avocate', '0678901234', 'camille.guerin@pro.example.com', 4, NULL, 4),
(18, 'M.', 'Marchand', 'Louis', 'louis.marchand@example.com', 'password789', '0698765432', 'DE876543210', 'Ingénieur Biomédical', '0612233445', 'louis.marchand@pro.example.com', 4, NULL, 5),
(19, 'Mme', 'Andre', 'Marine', 'marine.andre@example.com', 'pass789', '0612345678', 'FR987654321', 'Journaliste', '0698765432', 'marine.andre@pro.example.com', 3, NULL, 6),
(20, 'Mme', 'Martin', 'Marie', 'marie.martin@example.com', 'password456', '0712345678', 'FR987654321', 'Infirmière', '0498765432', 'marie.martin@hopital.fr', 4, 2, 2),
(21, 'M.', 'Durand', 'Pierre', 'pierre.durand@example.com', 'securepwd789', '0487654321', 'LU456789123', 'Chirurgien orthopédiste', '0456789012', 'pierre.durand@clinique.lu', 4, 1, 3),
(22, 'Mlle', 'Lefevre', 'Sophie', 'sophie.lefevre@example.com', 'pass123word', '0654321876', 'DE654321789', 'Kinésithérapeute', '0478901234', 's.lefevre@cabinet.de', 4, 2, 4),
(23, 'M.', 'Dupont', 'Jean', 'jean.dupont@example.com', 'motdepasse123', '0612345678', 'BE123456789', 'Médecin généraliste', '0478901234', 'jean.dupont@clinique.com', 4, 1, 2),
(24, 'Mme', 'Martin', 'Marie', 'marie.martin@example.com', 'password456', '0712345678', 'FR987654321', 'Infirmière', '0498765432', 'marie.martin@hopital.fr', 4, 2, 2),
(25, 'M.', 'Durand', 'Pierre', 'pierre.durand@example.com', 'securepwd789', '0487654321', 'LU456789123', 'Chirurgien orthopédiste', '0456789012', 'pierre.durand@clinique.lu', 4, 1, 3),
(26, 'Mlle', 'Lefevre', 'Sophie', 'sophie.lefevre@example.com', 'pass123word', '0654321876', 'DE654321789', 'Kinésithérapeute', '0478901234', 's.lefevre@cabinet.de', 4, 2, 4),
(27, 'Mr', 'Dubois', 'François', 'francois.dubois@example.com', 'mdp456789', '0789012345', 'ES321987654', 'Cardiologue', '0490123456', 'francois.dubois@cardio.es', 4, 2, 3),
(28, 'Mme', 'Moreau', 'Julie', 'julie.moreau@example.com', 'password789', '0687654321', 'IT987654321', 'Sage-femme', '0487654321', 'j.moreau@clinique.it', 3, 1, 4),
(29, 'M.', 'Garcia', 'Antoine', 'antoine.garcia@example.com', 'securepwd987', '0756789012', 'NL123456789', 'Psychiatre', '0456789012', 'antoine.garcia@hopital.nl', 4, 1, 2),
(30, 'Mr', 'Roux', 'Luc', 'luc.roux@example.com', 'mdp789012', '0612345678', 'PT456789123', 'Dentiste', '0478901234', 'l.roux@dental.pt', 4, 2, 4),
(31, 'Mme', 'Leroy', 'Claire', 'claire.leroy@example.com', 'password123', '0734567890', 'CH987654321', 'Pharmacienne', '0490123456', 'c.leroy@pharma.ch', 4, 2, 4),
(32, 'M.', 'Sanchez', 'Carlos', 'carlos.sanchez@example.com', 'pwd987654', '0790123456', 'AT321987654', 'Médecin urgentiste', '0487654321', 'c.sanchez@hopital.at', 4, 1, 2),
(33, 'M.', 'Dupont', 'Jean', 'jean.dupont@example.com', 'motdepasse123', '0612345678', 'BE123456789', 'Médecin généraliste', '0478901234', 'jean.dupont@clinique.com', 4, 1, 2),
(34, 'Mme', 'Martin', 'Marie', 'marie.martin@example.com', 'password456', '0712345678', 'FR987654321', 'Infirmière', '0498765432', 'marie.martin@hopital.fr', 3, 2, 2),
(35, 'M.', 'Durand', 'Pierre', 'pierre.durand@example.com', 'securepwd789', '0487654321', 'LU456789123', 'Chirurgien orthopédiste', '0456789012', 'pierre.durand@clinique.lu', 4, 1, 3),
(36, 'Mlle', 'Lefevre', 'Sophie', 'sophie.lefevre@example.com', 'pass123word', '0654321876', 'DE654321789', 'Kinésithérapeute', '0478901234', 's.lefevre@cabinet.de', 4, 2, 4),
(37, 'Mr', 'Dubois', 'François', 'francois.dubois@example.com', 'mdp456789', '0789012345', 'ES321987654', 'Cardiologue', '0490123456', 'francois.dubois@cardio.es', 4, 2, 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD PRIMARY KEY (`id_adresse`);

--
-- Index pour la table `donne`
--
ALTER TABLE `donne`
  ADD PRIMARY KEY (`id_utilisateur`,`id_produit`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `est_partenaire`
--
ALTER TABLE `est_partenaire`
  ADD PRIMARY KEY (`id_institution`,`id_produit`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id_image`);

--
-- Index pour la table `institution`
--
ALTER TABLE `institution`
  ADD PRIMARY KEY (`id_institution`),
  ADD KEY `id_adresse` (`id_adresse`);

--
-- Index pour la table `lieu`
--
ALTER TABLE `lieu`
  ADD PRIMARY KEY (`id_lieu`),
  ADD KEY `id_institution` (`id_institution`),
  ADD KEY `id_adresse` (`id_adresse`);

--
-- Index pour la table `participe`
--
ALTER TABLE `participe`
  ADD PRIMARY KEY (`id_utilisateur`,`id_produit`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`),
  ADD KEY `id_image` (`id_image`),
  ADD KEY `id_lieu` (`id_lieu`),
  ADD KEY `id_type_produit` (`id_type_produit`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `type_produit`
--
ALTER TABLE `type_produit`
  ADD PRIMARY KEY (`id_type_produit`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_institution` (`id_institution`),
  ADD KEY `id_adresse` (`id_adresse`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adresse`
--
ALTER TABLE `adresse`
  MODIFY `id_adresse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `institution`
--
ALTER TABLE `institution`
  MODIFY `id_institution` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `lieu`
--
ALTER TABLE `lieu`
  MODIFY `id_lieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `type_produit`
--
ALTER TABLE `type_produit`
  MODIFY `id_type_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `donne`
--
ALTER TABLE `donne`
  ADD CONSTRAINT `donne_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `donne_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`);

--
-- Contraintes pour la table `est_partenaire`
--
ALTER TABLE `est_partenaire`
  ADD CONSTRAINT `est_partenaire_ibfk_1` FOREIGN KEY (`id_institution`) REFERENCES `institution` (`id_institution`),
  ADD CONSTRAINT `est_partenaire_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`);

--
-- Contraintes pour la table `institution`
--
ALTER TABLE `institution`
  ADD CONSTRAINT `institution_ibfk_1` FOREIGN KEY (`id_adresse`) REFERENCES `adresse` (`id_adresse`);

--
-- Contraintes pour la table `lieu`
--
ALTER TABLE `lieu`
  ADD CONSTRAINT `lieu_ibfk_1` FOREIGN KEY (`id_institution`) REFERENCES `institution` (`id_institution`),
  ADD CONSTRAINT `lieu_ibfk_2` FOREIGN KEY (`id_adresse`) REFERENCES `adresse` (`id_adresse`);

--
-- Contraintes pour la table `participe`
--
ALTER TABLE `participe`
  ADD CONSTRAINT `participe_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `participe_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`id_image`) REFERENCES `image` (`id_image`),
  ADD CONSTRAINT `produit_ibfk_2` FOREIGN KEY (`id_lieu`) REFERENCES `lieu` (`id_lieu`),
  ADD CONSTRAINT `produit_ibfk_3` FOREIGN KEY (`id_type_produit`) REFERENCES `type_produit` (`id_type_produit`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`),
  ADD CONSTRAINT `utilisateur_ibfk_2` FOREIGN KEY (`id_institution`) REFERENCES `institution` (`id_institution`),
  ADD CONSTRAINT `utilisateur_ibfk_3` FOREIGN KEY (`id_adresse`) REFERENCES `adresse` (`id_adresse`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
