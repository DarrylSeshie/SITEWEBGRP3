-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 27 mai 2024 à 02:17
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ceref`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

CREATE TABLE `adresse` (
  `id_adresse` int(11) NOT NULL,
  `rue_numero` varchar(100) NOT NULL DEFAULT 'VIDE',
  `code_postal` int(11) NOT NULL DEFAULT 0,
  `localite` varchar(100) NOT NULL DEFAULT 'VIDE',
  `pays` varchar(50) NOT NULL DEFAULT 'VIDE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`id_adresse`, `rue_numero`, `code_postal`, `localite`, `pays`) VALUES
(1, 'Bd Tirou 15', 6000, 'Charleroi', 'Belgique'),
(2, 'Chauss de binche 159 ', 7000, 'Mons', 'Belgique'),
(3, 'Bd Dolez 32 ', 7000, 'Mons', 'Belgique'),
(4, '123 Rue Principale', 1000, 'Bruxelles', 'Belgique'),
(5, '456 Avenue Centrale', 2000, 'Anvers', 'Belgique'),
(6, '784 Boulevard Central', 3000, 'Louvain', 'Belgique'),
(7, '123 Rue du Centre', 4000, 'Liège', 'Belgique'),
(8, 'Bd Dolez 39 ', 6000, 'Charleroi', 'Belgique'),
(9, '45 Avenue Europe', 1000, 'Bruxelles', 'Belgique'),
(10, '1089 Boulevard Gauche', 3000, 'Louvain', 'Belgique'),
(11, '108 Rue du Centre', 4000, 'Liège', 'Belgique'),
(12, '3  Bd Marie Louis ', 7000, 'Mons', 'Belgique'),
(13, '1 Rue Boordelen', 1200, 'Bruxelles', 'Belgique'),
(14, '45 JustermanWoorld', 2000, 'Anvers', 'Belgique'),
(15, '41  Central parc Est', 3000, 'Louvain', 'Belgique'),
(16, '136 Trieu Kaisin ', 6061, 'Montignie Sur Sambre', 'Belgique'),
(17, '120 Chaussée de charleroi', 6000, 'Charleroi', 'Belgique');

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
-- Structure de la table `estpartenaire`
--

CREATE TABLE `estpartenaire` (
  `id_institution` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `type_de_partenariat` varchar(100) DEFAULT 'VIDE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `estpartenaire`
--

INSERT INTO `estpartenaire` (`id_institution`, `id_produit`, `type_de_partenariat`) VALUES
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
  `url_image` varchar(200) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id_image`, `url_image`, `nom`) VALUES
(1, 'https://www.helha.be/app/uploads/2022/05/vignette-helha2.jpg', 'Image Helha '),
(2, 'https://www.bde-group.be/wp-content/uploads/2017/11/Image1-300x169.png', 'Image BDE Groud'),
(3, 'https://pbs.twimg.com/profile_images/651375653082652672/fEr3_2_M_400x400.png', 'Twitter Profile Image'),
(4, 'https://www.helha.be/app/uploads/2022/07/dernierjourdecours-PUB.jpg', 'Dernier Jour de Cours'),
(5, 'https://www.helha.be/app/uploads/2023/09/Ecrire-a-la-HELHa-ConnectED.png', 'Ecrire à la HELHa ConnectED'),
(6, 'https://cermed.helha.be/wp-content/plugins/helha/uploads/colloque/311.jpg', 'union'),
(7, 'https://cermed.helha.be/wp-content/plugins/helha/uploads/colloque/316.jpg', 'meditaion'),
(8, 'https://cermed.helha.be/wp-content/plugins/helha/uploads/colloque/324.jpg', 'bandage'),
(9, 'https://cermed.helha.be/wp-content/plugins/helha/uploads/colloque/349.jpg', 'mal de dos'),
(10, 'https://cermed.helha.be/wp-content/plugins/helha/uploads/colloque/355.jpg', 'huile'),
(11, 'https://cermed.helha.be/wp-content/plugins/helha/uploads/colloque/314.jpg', 'secour'),
(12, 'https://cermed.helha.be/wp-content/plugins/helha/uploads/colloque/305.jpg', 'icon');

-- --------------------------------------------------------

--
-- Structure de la table `institution`
--

CREATE TABLE `institution` (
  `id_institution` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL DEFAULT 'VIDE',
  `logo` varchar(200) NOT NULL DEFAULT 'VIDE',
  `id_adresse` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `institution`
--

INSERT INTO `institution` (`id_institution`, `nom`, `logo`, `id_adresse`) VALUES
(1, 'Helha', 'https://www.helha.be/app/uploads/2022/05/vignette-helha2.jpg', 1),
(2, 'Umons', 'https://i.ytimg.com/vi/hpfYij7Wx0k/maxresdefault.jpg', 3),
(3, 'UNamur', 'https://pbs.twimg.com/profile_images/1261898496799657984/0LXybiZu_400x400.jpg', 4),
(4, 'ULiege', 'https://www.uliege.be/plugins/ULiegePlugin/images/uLiegeLogo.jpg', 10),
(5, 'ULB', 'https://logowik.com/content/uploads/images/free-university-of-brussels-ulb4361.jpg', 11),
(6, 'HEH', 'https://www.heh.be/design/logo_HEH.png', 8),
(7, 'UCLouvain', 'https://sites.uclouvain.be/louvaingamelab/assets/images/logo-uclouvain-2021.webp', 3),
(8, 'Ucharleroi', 'https://campusucharleroi.be/wp-content/uploads/2023/04/Logo-CampusUCharleroi_2023_300l.jpg', 14);

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

CREATE TABLE `lieu` (
  `id_lieu` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL DEFAULT 'VIDE',
  `batiment` varchar(50) DEFAULT 'VIDE',
  `locaux` varchar(50) DEFAULT 'VIDE',
  `id_institution` int(11) NOT NULL DEFAULT 1,
  `id_adresse` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `lieu`
--

INSERT INTO `lieu` (`id_lieu`, `nom`, `batiment`, `locaux`, `id_institution`, `id_adresse`) VALUES
(1, 'Helha_montignie', 'Batiment A', 'E206', 1, 1),
(2, 'Helha_Mons', 'Batiment B', 'B201', 1, 2),
(3, 'Umons', 'Batiment C', 'Locaux C', 2, 3),
(4, 'Helha_gilly', 'Batiment G', 'G2', 1, 4),
(5, 'HEH', 'Batiment H', 'H207', 4, 5),
(6, 'Ucharleroi', 'Batiment7', '126', 8, 6),
(7, 'Uliege', 'Batiment2', 'B120', 4, 7),
(8, 'Unamur', 'Batiment LBN', 'N26', 7, 7);

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
  `titre` varchar(100) NOT NULL DEFAULT 'VIDE',
  `sous_titre` varchar(150) NOT NULL DEFAULT 'VIDE',
  `date_debut` date NOT NULL DEFAULT curdate(),
  `date_fin` date NOT NULL DEFAULT curdate(),
  `date_fin_inscription` date NOT NULL,
  `descriptif` varchar(500) NOT NULL,
  `objectif` varchar(250) DEFAULT 'VIDE',
  `contenu` varchar(250) DEFAULT 'VIDE',
  `methodologie` varchar(250) DEFAULT 'VIDE',
  `public_cible` varchar(250) DEFAULT 'VIDE',
  `prix` double DEFAULT 0,
  `id_image` int(11) NOT NULL DEFAULT 1,
  `id_lieu` int(11) NOT NULL DEFAULT 1,
  `id_type_produit` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `titre`, `sous_titre`, `date_debut`, `date_fin`, `date_fin_inscription`, `descriptif`, `objectif`, `contenu`, `methodologie`, `public_cible`, `prix`, `id_image`, `id_lieu`, `id_type_produit`) VALUES
(1, 'F02', 'Accompagner l\'etudiant infirmier en stage ', '2024-05-20', '2024-05-23', '2024-05-16', 'Adopter la posture de refecrence/coach en equipe...', 'Devenir pro', 'Contenu de la formation 1', 'Méthodologie de la formation 1', 'Etudiant', 10, 12, 1, 1),
(2, 'R03', 'Solliciter l\'expression des émotion', '2024-05-23', '2024-05-30', '2024-05-21', 'Solliciter l\'expression des émotions chez les patients et résidents par le biais du journal créatif', 'Objectif de la formation 2', 'Contenu de la formation 2', 'Méthodologie de la formation 2', 'Etudiant', 12, 10, 1, 1),
(3, 'F03', 'Description de la formation 3', '2024-07-01', '2024-07-10', '2024-06-25', 'Ceci est le descriptif de la formation 3', 'Objectif de la formation 3', 'Contenu de la formation 3', 'Méthodologie de la formation 3', 'Public cible de la formation 3', 20, 3, 1, 1),
(4, 'FQ4', 'Description de la formation 4', '2024-08-01', '2024-08-10', '2024-07-25', 'Ceci est le descriptif de la formation 4', 'Objectif de la formation 4', 'Contenu de la formation 4', 'Méthodologie de la formation 4', 'Public cible de la formation 4', 11, 4, 1, 1),
(5, 'PH05', 'Description de la formation 5', '2024-09-01', '2024-09-10', '2024-08-25', 'Ceci est le descriptif de la formation 5', 'Objectif de la formation 5', 'Contenu de la formation 5', 'Méthodologie de la formation 5', 'Public cible de la formation 5', 5, 5, 1, 1),
(6, 'Q08', 'Initiation à l\'evaluation des apt pro', '2024-05-15', '2024-05-17', '2024-05-12', 'Il est parfois difficile d\'evaluer les aptitude professionelles de maniere objective .\r\nla methode ESAP change la donne.', 'Objectif de la journée 1', 'Contenu de la journée 1', 'Méthodologie de la journée 1', 'Travailleur', 50, 9, 1, 2),
(7, 'NM22', 'Description de la journée 2', '2024-06-15', '2024-06-15', '2024-06-10', 'Ceci est le descriptif de la journée 2', 'Objectif de la journée 2', 'Contenu de la journée 2', 'Méthodologie de la journée 2', 'Public cible de la journée 2', 60, 11, 1, 2),
(8, 'JDF003', 'Description de la journée 3', '2024-07-15', '2024-07-15', '2024-07-10', 'Ceci est le descriptif de la journée 3', 'Objectif de la journée 3', 'Contenu de la journée 3', 'Méthodologie de la journée 3', 'Public cible de la journée 3', 55, 3, 1, 2),
(9, 'JBBL09', 'Description de la journée 4', '2024-08-15', '2024-08-15', '2024-08-10', 'Ceci est le descriptif de la journée 4', 'Objectif de la journée 4', 'Contenu de la journée 4', 'Méthodologie de la journée 4', 'Public cible de la journée 4', 65, 2, 1, 2),
(10, 'T76Days', 'Description de la journée 5', '2024-09-15', '2024-09-15', '2024-09-10', 'Ceci est le descriptif de la journée 6', 'Objectif de la journée 6', 'Contenu de la journée 5', 'Méthodologie de la journée 5', 'Public cible de la journée 5', 705, 1, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
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
-- Structure de la table `typeproduit`
--

CREATE TABLE `typeproduit` (
  `id_type_produit` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `typeproduit`
--

INSERT INTO `typeproduit` (`id_type_produit`, `nom`) VALUES
(1, 'Formation'),
(2, 'Journée');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `civilite` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(250) NOT NULL,
  `gsm` varchar(50) NOT NULL,
  `TVA` varchar(100) DEFAULT 'VIDE',
  `profession` varchar(50) NOT NULL,
  `gsm_pro` varchar(50) DEFAULT 'VIDE',
  `email_pro` varchar(100) DEFAULT 'VIDE',
  `id_role` int(11) NOT NULL DEFAULT 4,
  `id_institution` int(11) NOT NULL DEFAULT 1,
  `id_adresse` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `civilite`, `nom`, `prenom`, `email`, `mot_de_passe`, `gsm`, `TVA`, `profession`, `gsm_pro`, `email_pro`, `id_role`, `id_institution`, `id_adresse`) VALUES
(1, 'M.', 'Stoffel', 'Jean-Francois', 'stoffeljf@helha.be', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '048xxxxxx', 'BE123456789', 'Ingénieur', '987654321', 'stoffeljf@gmail.com', 1, 1, 5),
(2, 'M.', 'Seshie', 'The_D', 'dsn2ur@gmail.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '048xxxxxx', 'BE123456789', 'Etudiant', '987654321', 'Thed_y@gmail.com', 1, 1, 1),
(3, 'MR', 'Sirjacjk', 'celestin', 'Sceles@helha.be', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '048xxxxxx', 'BE123456789', 'Etudiant', '987654321', 'celestinio@gmail.com', 2, 1, 12),
(4, 'M.', 'Lamdine', 'Houssam', 'lamhamdihoussameddine@gmail.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '048xxxxxx', 'BE123456789', 'Etudiant', '987654321', 'hou@gmail.com', 4, 1, 12),
(5, 'M.', 'Kawas', 'Helmajdi', 'Kw@helha.be', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '048xxxxxx', 'BE123456789', 'Professeur', '987654321', 'Kasw@gmail.com', 3, 1, 13),
(8, 'M.r', 'Lefevre', 'Pierre', 'pierre.lefevre@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '789456123', 'BE789456123', 'Architecte', '654987321', 'pierrelefevre@pro.com', 4, 1, 3),
(9, 'Mme', 'Dubois', 'Marie', 'marie.dubois@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '654789321', 'BE654789321', 'Consultant', '987654123', 'mariedubois@pro.com', 4, 1, 4),
(10, 'M.', 'Leroy', 'Thomas', 'thomas.leroy@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '456123789', 'BE456123789', 'Analyste', '321987654', 'thomasleroy@pro.com', 4, 1, 5),
(11, 'Mme', 'Moreau', 'Laura', 'laura.moreau@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '321654987', 'BE321654987', 'Designer', '654321987', 'lauramoreau@pro.com', 4, 1, 6),
(12, 'M.', 'Garcia', 'Antoine', 'antoine.garcia@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '789321654', 'BE789321654', 'Ingénieur', '456987321', 'antoinegarcia@pro.com', 4, 1, 7),
(13, 'Mme', 'Roux', 'Julie', 'julie.roux@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '987321654', 'BE987321654', 'Développeur', '321654987', 'julieroux@pro.com', 4, 1, 8),
(15, 'Mme', 'Sanchez', 'Emma', 'emma.sanchez@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '321987654', 'BE321987654', 'Analyste', '654123987', 'emmasanchez@pro.com', 3, 1, 10),
(16, 'Mlle', 'Alary', 'MrProf', 'alary.prof@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0654321876', 'DE654321789', 'Kinésithérapeute', '0478901234', 's.lefevre@cabinet.de', 3, 2, 4),
(17, 'Mme', 'Legrand', 'Olivier', 'legrand.moreau@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0687654321', 'IT987654321', 'Sage-femme', '0487654321', 'j.moreau@clinique.it', 3, 1, 4),
(18, 'M.', 'Theodor', 'Antoine', 'theodor.g@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0756789012', 'NL123456789', 'Psychiatre', '0456789012', 'antoine.garcia@hopital.nl', 4, 1, 2),
(19, 'Mr', 'Roux', 'Dupied', 'Dupier.roux@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0612345678', 'PT456789123', 'Dentiste', '0478901234', 'l.roux@dental.pt', 2, 2, 4),
(20, 'Mme', 'Malangro', 'Claire', 'Malangro.ly@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0734567890', 'CH987654321', 'Pharmacienne', '0490123456', 'c.leroy@pharma.ch', 3, 2, 4),
(21, 'M.', 'Som', 'Antoine', 'Som.g6@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0756789012', 'NL123456789', 'Psychiatre', '0456789012', 'antoine.garcia@hopital.nl', 4, 1, 2),
(22, 'Mr', 'Alleby', 'Luc', 'Alleby@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0612345678', 'PT456789123', 'Dentiste', '0478901234', 'l.roux@dental.pt', 4, 2, 4),
(23, 'Mme', 'Diarra', 'Claire', 'Diarra@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0734567890', 'CH987654321', 'Pharmacienne', '0490123456', 'c.leroy@pharma.ch', 4, 2, 4),
(24, 'M.', 'Sanchez', 'Pedro', 'Pedro.sanchez@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0790123456', 'AT321987654', 'Médecin urgentiste', '0487654321', 'c.sanchez@hopital.at', 4, 1, 2),
(25, 'M.', 'Kenko', 'Grace', 'Grace.Kenko@gmail.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0612345678', 'BE123456789', 'Médecin généraliste', '0478901234', 'jean.dupont@clinique.com', 3, 1, 2),
(26, 'Mlle', 'Mapuntopu', 'Sophie', 'sophie.pu@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0654321876', 'DE654321789', 'Kinésithérapeute', '0478901234', 's.lefevre@cabinet.de', 2, 2, 4),
(27, 'Mme', 'Scaut', 'Sherazade', 'Scaut.Ss@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0687654321', 'IT987654321', 'Sage-femme', '0487654321', 'j.moreau@clinique.it', 2, 1, 4),
(28, 'Mlle.', 'Slimani', 'Lina', 'SlimanLia@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0756789012', 'NL123456789', 'Psychiatre', '0456789012', 'antoine.garcia@hopital.nl', 4, 1, 2),
(29, 'Mr', 'Botoyu', 'Ezeckiel', 'Botoyu@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0612345678', 'PT456789123', 'Dentiste', '0478901234', 'l.roux@dental.pt', 3, 2, 4),
(30, 'Mme', 'Valentino', 'Claire', 'Valentino.Clr@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0734567890', 'CH987654321', 'Pharmacienne', '0490123456', 'c.leroy@pharma.ch', 2, 2, 4),
(31, 'Mlle', 'Gohu', 'Michelle', 'Gohu.arafat@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0654321876', 'DE654321789', 'Kinésithérapeute', '0478901234', 's.lefevre@cabinet.de', 4, 2, 4),
(32, 'M.', 'Seddoh', 'Jean', 'jean.seddoh@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0612345678', 'BE123456789', 'Médecin généraliste', '0478901234', 'jean.dupont@clinique.com', 4, 1, 2),
(33, 'Mme', 'Welscott', 'Marie', 'marie.Welscaut@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0712345678', 'FR987654321', 'Infirmière', '0498765432', 'marie.martin@hopital.fr', 4, 2, 2),
(34, 'M.', 'Tamakloe', 'Pierre', 'pierre.Tamak@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0487654321', 'LU456789123', 'Chirurgien orthopédiste', '0456789012', 'pierre.durand@clinique.lu', 4, 1, 3),
(35, 'Mlle', 'Lelo', 'Sophie', 'sophie.lelo@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0654321876', 'DE654321789', 'Kinésithérapeute', '0478901234', 's.lefevre@cabinet.de', 4, 2, 4),
(36, 'Mr', 'Ducobu', 'Franc', 'franc.dus@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0789012345', 'ES321987654', 'Cardiologue', '0490123456', 'francois.dubois@cardio.es', 4, 2, 3),
(37, 'M.', 'Africano', 'Gloria', 'gloglo.Af@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0756789012', 'NL123456789', 'Psychiatre', '0456789012', 'antoine.garcia@hopital.nl', 4, 1, 2),
(38, 'Mr', 'Milano', 'Luc', 'luc.mila@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0612345678', 'PT456789123', 'Dentiste', '0478901234', 'l.roux@dental.pt', 4, 2, 4),
(39, 'Mme', 'Paya', 'team', 'Team.paya@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0734567890', 'CH987654321', 'Pharmacienne', '0490123456', 'c.leroy@pharma.ch', 4, 2, 4),
(40, 'M.', 'Anani', 'Shalom', 'Shalom.anani@gmail.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0790123456', 'AT321987654', 'Médecin urgentiste', '0487654321', 'c.sanchez@hopital.at', 3, 1, 2),
(41, 'M.', 'Danne', 'Soanne', 'Soanne.LPB@example.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0612345678', 'BE123456789', 'Médecin généraliste', '0478901234', 'jean.dupont@clinique.com', 4, 1, 2),
(42, 'Mlle', 'Seshie', 'Jeremie', 'Jeremie.Seshie@gmail.com', '$2y$10$bZOgNA/cew9YpTZxvZzEPuNqnrRyvE9eb//kSpTWIAcB1R5V5D1bi', '0654321876', 'DE654321789', 'Kinésithérapeute', '0478901234', 's.lefevre@cabinet.de', 4, 2, 4);


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
-- Index pour la table `estpartenaire`
--
ALTER TABLE `estpartenaire`
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
-- Index pour la table `typeproduit`
--
ALTER TABLE `typeproduit`
  ADD PRIMARY KEY (`id_type_produit`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`),
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
  MODIFY `id_adresse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `institution`
--
ALTER TABLE `institution`
  MODIFY `id_institution` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `lieu`
--
ALTER TABLE `lieu`
  MODIFY `id_lieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `typeproduit`
--
ALTER TABLE `typeproduit`
  MODIFY `id_type_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

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
-- Contraintes pour la table `estpartenaire`
--
ALTER TABLE `estpartenaire`
  ADD CONSTRAINT `estpartenaire_ibfk_1` FOREIGN KEY (`id_institution`) REFERENCES `institution` (`id_institution`),
  ADD CONSTRAINT `estpartenaire_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`);

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
  ADD CONSTRAINT `produit_ibfk_3` FOREIGN KEY (`id_type_produit`) REFERENCES `typeproduit` (`id_type_produit`);

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
