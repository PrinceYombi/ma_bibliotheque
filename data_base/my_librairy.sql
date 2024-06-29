-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 30 juin 2024 à 01:12
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
-- Base de données : `my_librairy`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', 'admin2024');

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `auteur` varchar(255) DEFAULT NULL,
  `categorie` int(11) DEFAULT NULL,
  `date_parution` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`id`, `titre`, `auteur`, `categorie`, `date_parution`, `description`, `image`) VALUES
(10, 'Ogy et Cafard', 'Light', 3, '2023-05-19', 'Un déssin animé comic.', '34805-950-1457794892-19.png'),
(11, 'LE WEB', 'ESPERO AKPOLI', 4, '2022-09-16', 'Dans ce livre vous apprendrez tout ce qui est du developpement web avec Mr Espero', 'digital-marketing-marketing-strategy-business-web-design-png-favpng-Mjyc8gswb2gN2F1veBHe2tjvb.jpg'),
(12, 'DRAGON BALL Z', 'NGO KU', 1, '2004-02-12', 'Le dessin animé Dragon BAll Z', 'camels-group-front-cl-4.jpg'),
(13, 'DYNASTIE', 'FERRE GOLA', 5, '2023-10-20', 'L&#039;album dynastie Volume II', '34205-950-1457794892-Amitabha.jpg'),
(14, 'FORMULE7', 'FALLY', 3, '2022-09-09', 'L&#039;albume Formule 7', '20-photos-incroyables-qui-vont-vous-donner-le-vertige5.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`) VALUES
(1, 'Manga'),
(2, 'Roman'),
(3, 'Comics'),
(4, 'Sciences'),
(5, 'Autres');

-- --------------------------------------------------------

--
-- Structure de la table `emprunt_book`
--

CREATE TABLE `emprunt_book` (
  `id` int(11) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idBook` int(11) DEFAULT NULL,
  `date_emprunt` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `emprunt_book`
--

INSERT INTO `emprunt_book` (`id`, `idUser`, `idBook`, `date_emprunt`) VALUES
(3, 1, 10, '2024-06-30'),
(4, 2, 11, '2024-06-30');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `sexe` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password`, `ville`, `sexe`) VALUES
(1, 'YOMBI OLONGO', 'Prince De Fanny Juveldy', 'yombifanny@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Brazzaville', 1),
(2, 'OSSEBI', 'Malonne', 'malonne@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Dakar', 2),
(3, 'AKPOLI', 'Espero', 'esperosoft@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Lille', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie` (`categorie`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `emprunt_book`
--
ALTER TABLE `emprunt_book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idBook` (`idBook`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `emprunt_book`
--
ALTER TABLE `emprunt_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`categorie`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `emprunt_book`
--
ALTER TABLE `emprunt_book`
  ADD CONSTRAINT `emprunt_book_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `emprunt_book_ibfk_2` FOREIGN KEY (`idBook`) REFERENCES `book` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
