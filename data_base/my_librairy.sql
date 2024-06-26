-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 14 juin 2024 à 11:08
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
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `type` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `type`) VALUES
(1, 'admin@gmail.com', 'admin2024', 'Administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `auteur` varchar(255) DEFAULT NULL,
  `categorie` int(11) DEFAULT NULL,
  `date_parution` date NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`id`, `titre`, `auteur`, `categorie`, `date_parution`, `description`) VALUES
(1, 'ONE PIECE', 'ONE PIECE', 1, '2000-09-20', 'Nous sommes à l&#039;ère des pirates. Luffy, un garçon espiègle, rêve de devenir le roi des pirates en trouvant le “One Piece”, un fabuleux trésor. Seulement, Luffy a avalé un fruit du démon qui l&#039;a transformé en homme élastique. Depuis, il est capab'),
(2, 'DRAGON BALL', 'AKIRA TORIYAMA', 1, '1993-02-10', 'Son Goku, un enfant étrange vivant seul dans la forêt, rencontre Bulma, et décide de la suivre à travers le monde à la recherche de 7 boules de cristal appelées Dragon Ball.'),
(3, 'DEATH NOTE', 'TAKESHI OBATA', 1, '2007-01-25', 'Light Yagami ramasse un étrange carnet. Selon les instructions, la personne dont le nom est écrit dans les pages meurt dans les 40 secondes !'),
(4, 'LE PACTE DES MARCHOMBRES', 'PIERRE BOTTERO', 2, '1996-04-30', 'aventure saga roman fantastique fantasy poésie classique littérature jeunesse jeunesse prophétie quête combat liberté heroic fantasy univers parallèles science-fiction amour adolescence littérature française auteur français'),
(5, 'LADY MECHANIKA', 'MARCIA CHEN', 3, '2003-02-25', 'La beauté n’est parfois qu’une façadeLady Mechanika a désormais de solides indices pour retrouver son passé perdu. Mais pour le moment, ses pensées sont tournées vers M. Lewis lorsque le comportement de celui-ci devient'),
(6, 'LA VéRITABLE HISTOIRE DU PèRE NOëL', 'GRANT MORRISON', 3, '1999-06-15', 'Les origines « bad-ass » du Père Noël !Dans un monde médiéval fantastique, un trappeur itinérant du nom de Klaus entre dans l’enceinte de Grimsvig. Mais la ville a bien changé depuis sa dernière visite... Celle qui respirait la joie de vivre est'),
(7, 'SEIGNEUR DES ANNEAUX', 'TOLKIEN', 2, '1890-05-18', 'aventure saga roman fantastique fantasy classique adapté au cinéma littérature quête magie elfes hobbits nains heroic fantasy science-fiction guerre voyages littérature anglaise littérature britannique 20ème siècle'),
(8, 'HARRY POTTER', 'ROWLING', 2, '2004-08-10', 'aventure saga roman fantasy fantastique littérature jeunesse jeunesse quête magie adapté au cinéma école amitié harry potter sfff science-fiction sorcellerie sorciers adolescence littérature anglaise littérature contemporaine'),
(9, 'DIALOGUE SUR LES DEUX GRANDS SYSTèMES DU MONDE', 'GALILéE', 4, '2000-06-12', 'Choix de Jean-Marc Lévy-Leblond, physicien, essayiste, professeur émérite de l&#039;université de Nice et directeur des collections scientifiques au Seuil et de la revue Alliage. Il a écrit des essais sur la place et le rôle de la science dans la culture '),
(10, 'QU&#039;EST-CE QUE LA SCIENCE ?', 'CHALMERS', 4, '1990-05-14', 'Choix de Yaël Nazé, astrophysicienne à l&#039;université de Liège. Elle est spécialisée dans l&#039;étude &quot;des étoiles très massives&quot;.'),
(11, 'TECHNIQUE ET LANGAGE', 'ANDRé LEROI-GOURHAN', 4, '1964-11-18', 'Choix de Jean-Paul Demoule, professeur de protohistoire européenne à l&#039;université Paris I, membre de l&#039;Institut universitaire de France, directeur de fouilles sur des sites français, grecs et bulgares, premier président de l&#039;Institut Nation'),
(12, 'LA VIE DANS L&#039;AU DELA', 'LIGHT COEURTUS', 5, '0004-06-15', 'Il existe une seconde vie après la mort');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) DEFAULT NULL
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
-- Structure de la table `emprunt_livre`
--

CREATE TABLE `emprunt_livre` (
  `id` int(11) NOT NULL,
  `idBook` int(11) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL,
  `date_emprunt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `emprunt_livre`
--

INSERT INTO `emprunt_livre` (`id`, `idBook`, `idUser`, `date_emprunt`) VALUES
(1, 1, 7, '2024-06-13 01:51:02'),
(2, 2, 7, '2024-06-13 01:51:30'),
(5, 8, 3, '2024-06-13 01:52:35'),
(6, 11, 3, '2024-06-13 01:52:46'),
(7, 5, 1, '2024-06-13 01:53:01'),
(8, 7, 2, '2024-06-13 01:53:23'),
(9, 9, 6, '2024-06-14 01:20:48'),
(10, 4, 1, '2024-06-14 10:28:53');

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
  `ville` text DEFAULT NULL,
  `sexe` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password`, `ville`, `sexe`) VALUES
(1, 'YOMBI OLONGO', 'Prince Light', 'prince@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Brazzaville', 1),
(2, 'OSSEBI', 'Malonne', 'malonne@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Dakar', 2),
(3, 'ITOUA', 'Ruisneige', 'itoua@hotmail.fr', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Lagos', 1),
(4, 'OLONGO', 'Judia', 'judia@hotmail.fr', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Pointe Noire', 2),
(5, 'NGATSE', 'Jador', 'jador@gmail.fr', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Munich', 1),
(6, 'MBENDIMA', 'Meilleur', 'meilleur@yaho.fr', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Libreville', 1),
(7, 'OMPATA', 'Jioa', 'jioa@hotmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Miami', 1),
(8, 'WATA', 'Blaisecia', 'wata@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Dolisie', 2);

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
-- Index pour la table `emprunt_livre`
--
ALTER TABLE `emprunt_livre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idBook` (`idBook`),
  ADD KEY `idUser` (`idUser`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `emprunt_livre`
--
ALTER TABLE `emprunt_livre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`categorie`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `emprunt_livre`
--
ALTER TABLE `emprunt_livre`
  ADD CONSTRAINT `emprunt_livre_ibfk_1` FOREIGN KEY (`idBook`) REFERENCES `book` (`id`),
  ADD CONSTRAINT `emprunt_livre_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
