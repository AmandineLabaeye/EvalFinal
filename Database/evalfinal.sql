-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 09 avr. 2019 à 10:51
-- Version du serveur :  5.7.17
-- Version de PHP :  7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `evalfinal`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `users_id_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `users_id_id`, `title`, `photo`, `description`, `date`, `active`) VALUES
(1, 4, 'Plante', 'http://www.herbesetvie.herbotheque.com/wp-content/uploads/2016/02/PlanteAraignee-WIKI.jpg', 'Les plantes sont agréable à regarder et à s\'en occuper', '03-04-2019 11:48:36', 1),
(2, 4, 'Foot', 'https://images.sudouest.fr/2018/07/16/5b4caa0f66a4bd0854b04b73/widescreen/1000x500/le-succes-des-bleus-devrait-donner-un-coup-d-accelerateur-au-football-francais.jpg?v1', 'Le foot est sport', '03-04-2019 12:13:07', 1),
(4, 4, 'Plotique', 'https://images.sudouest.fr/2018/07/16/5b4caa0f66a4bd0854b04b73/widescreen/1000x500/le-succes-des-bleus-devrait-donner-un-coup-d-accelerateur-au-football-francais.jpg?v1', 'sdofjiodsfhsodihf', '05-04-2019 14:08:22', 1);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `users_id_id` int(11) NOT NULL,
  `articles_id_id` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `users_id_id`, `articles_id_id`, `content`, `date`, `active`) VALUES
(2, 4, 2, 'ooooh bravo', '04-04-2019 08:14:44', 1),
(3, 2, 1, 'Good', '05-04-2019 08:41:20', 1),
(4, 4, 1, 'Très beau', '05-04-2019 14:36:26', 1),
(5, 2, 2, 'test', '08-04-2019 07:34:51', 1);

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20190402130125', '2019-04-02 13:01:35'),
('20190403114657', '2019-04-03 11:47:34');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `users_level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `surname`, `age`, `users_level`, `email`, `password`, `active`) VALUES
(2, 'Sakura', 'Labaeye', 'Amandine', 18, 'ROLE_ADMIN', 'amandine59kentin@gmail.com', '$2y$13$VW.z1LCJjMqKDjeMD0O44.fi6SDgXoEDiZrDZvq1LhxWSZfhRtf9i', 1),
(3, 'Modjo', 'Leclercq', 'Cyriak', 27, 'ROLE_USER', 'cyriak@gmail.fr', '$2y$13$lN..tEfZpcksIwSIW1jfUuWuzloBXuJSvZx6ubZhobZpd9b3/NJA2', 1),
(4, 'Wilson__Turner', 'Joaquin', 'Medine', 18, 'ROLE_ADMIN', 'Zepek@gmail.com', '$2y$13$VW.z1LCJjMqKDjeMD0O44.fi6SDgXoEDiZrDZvq1LhxWSZfhRtf9i', 1),
(5, 'Jamesouille', 'Durvin', 'James', 21, 'ROLE_USER', 'james.durvin@gmail.fr', '$2y$13$L/sbrqqqD7I4eyrRhUB/L.QQUwPaT5HxNI0kF5z5/tvMwnOp08FeC', 1),
(7, 'Max', 'Ducamp', 'Maxime', 33, 'ROLE_USER', 'sjdsiof@dsfosdijf.fr', '$2y$13$bhfSHOa5dfrjP0upGdmdWulA2baIMSknX9ICVVBiIQ/Api0wOfXZy', 1),
(8, 'La__Mignetta', 'Lodge', 'Veronica', 21, 'ROLE_USER', 'veronica.lodge@orange.fr', '$2y$13$03F/4sDJw7TYabGxNwmLp.GX6bDADJl7p4kHn9E6CncLNCj668BuO', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BFDD316898333A1E` (`users_id_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5F9E962A98333A1E` (`users_id_id`),
  ADD KEY `IDX_5F9E962A97A6B6A3` (`articles_id_id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `FK_BFDD316898333A1E` FOREIGN KEY (`users_id_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_5F9E962A97A6B6A3` FOREIGN KEY (`articles_id_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_5F9E962A98333A1E` FOREIGN KEY (`users_id_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
