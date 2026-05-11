-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 10 jan. 2026 à 13:57
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
-- Base de données : `locationmaison`
--

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `maisons`
--

CREATE TABLE `maisons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `utilisateur_id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `prix` int(11) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `maisons`
--

INSERT INTO `maisons` (`id`, `utilisateur_id`, `titre`, `description`, `prix`, `adresse`, `image`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(6, 1, 'gjkhljk', 'ifhkgjll', 56583, 'fgkhjglyhjvkhkl /', 'maisons/principales/cZxRfoDSII2lqDUPV2dC6QxF8UEdHFxqrnza6x0Q.jpg', 6.2007042, 1.1965656, '2025-07-12 18:04:05', '2025-07-12 18:04:05'),
(7, 1, 'iuyy', 'tyutiutit', 54353, 'hkjhgkjhk,hkj', 'maisons/principales/iHcdRiEbTs9xv3z1JZxXAqvh8xAaxQckDjK93AjU.png', 6.1882460, 1.2051487, '2025-07-12 18:13:23', '2025-07-12 18:13:23'),
(8, 1, 'kghjj', 'jffjghj', 53565, 'hgfkgjh,kh', 'maisons/principales/ceBvQIawTRgDsWs73BYVfaPwSZYmVve4IzxM0UKA.jpg', 6.1872221, 1.1802578, '2025-07-12 18:15:27', '2025-07-12 18:15:27'),
(9, 1, 'fjghjkh', 'jfuhgkjg', 536645, 'ghj,f', 'maisons/principales/rLCBqGgnTsTZwO7a10eUgcmWKt82lAAqrL795oDy.jpg', 6.1773236, 1.1900425, '2025-07-12 18:16:02', '2025-07-12 18:16:02'),
(10, 1, 'kugkhjl', 'jyukilou', 4567865, 'jfkglkgkfujhkghfjklkgujvhgbknkfvhgcjbmlgjhcf', 'maisons/principales/6naESL6HsvNq0wVieqRPVZi2Fz68ilzTGlGkwnMr.jpg', 6.1996802, 1.2006855, '2025-07-12 18:16:42', '2025-07-12 18:16:42');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_05_050208_create_maisons_table', 2),
(5, '2025_06_05_060912_create_photos_table', 3),
(6, '2025_06_05_071609_add_latitude_longitude_to_maisons_table', 4),
(7, '2025_07_10_132413_create_utilisateurs_table', 5),
(8, '2025_07_10_133613_add_utilisateur_id_to_maisons_table', 6);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

CREATE TABLE `photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `maison_id` bigint(20) UNSIGNED NOT NULL,
  `chemin` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `photos`
--

INSERT INTO `photos` (`id`, `maison_id`, `chemin`, `created_at`, `updated_at`) VALUES
(17, 6, 'maisons/secondaires/VYdRPrasicE5vEXFJ5HmvaoiRsTTxh8fhD72lEMi.png', '2025-07-12 18:04:06', '2025-07-12 18:04:06'),
(18, 6, 'maisons/secondaires/CsINNKnDNsEJX4Ackkzxb6EvdSgDRkBH2brse3AB.jpg', '2025-07-12 18:04:09', '2025-07-12 18:04:09'),
(19, 6, 'maisons/secondaires/V7r3Q7v5kcq9ZcwDPoTfAxpuZMIHr3WMGXksG8ub.png', '2025-07-12 18:04:10', '2025-07-12 18:04:10'),
(20, 7, 'maisons/secondaires/RXd4x9UDf7HcDNodZgUvyQBYACixULSLc290QVmK.png', '2025-07-12 18:13:25', '2025-07-12 18:13:25'),
(21, 7, 'maisons/secondaires/1uNWpm8clGTvST43WQmtTsDUgmzAtIdxslHxZsUz.png', '2025-07-12 18:13:25', '2025-07-12 18:13:25'),
(22, 7, 'maisons/secondaires/SPhKn384Yh9rgxrHNBJjHVUielvXwYy47Q51M8b3.jpg', '2025-07-12 18:13:26', '2025-07-12 18:13:26'),
(23, 8, 'maisons/secondaires/6HzbXBaY3AXGNz5Bj9ZILUmt9LmBwPZnQKjUb1Xl.jpg', '2025-07-12 18:15:28', '2025-07-12 18:15:28'),
(24, 8, 'maisons/secondaires/z323irQrzEXTubdCy6SNMA8Ecn2aLot3F3ljQZ8t.jpg', '2025-07-12 18:15:28', '2025-07-12 18:15:28'),
(25, 8, 'maisons/secondaires/skTFkYULbHahyYVRcEcOD9o0hKRudQ1z2e5BkAAV.jpg', '2025-07-12 18:15:28', '2025-07-12 18:15:28'),
(26, 9, 'maisons/secondaires/Er5e6mzUurWz1kCndvoUQV6uLcfi3SyhIRZvICrs.jpg', '2025-07-12 18:16:02', '2025-07-12 18:16:02'),
(27, 9, 'maisons/secondaires/IPFLFtsZlhRoUHZIFYvVLvwQhH6aMjxfsEoBVzm6.jpg', '2025-07-12 18:16:02', '2025-07-12 18:16:02'),
(28, 9, 'maisons/secondaires/tlNntoyct0PHstB1tQjJZYkkyU6MelU2oOIhQXeO.jpg', '2025-07-12 18:16:02', '2025-07-12 18:16:02'),
(29, 10, 'maisons/secondaires/d1H2XeGa4XlUzeQP71V1nTzkZREH4Pe2p1Kqw5Ob.jpg', '2025-07-12 18:16:42', '2025-07-12 18:16:42'),
(30, 10, 'maisons/secondaires/JsHnQbNBGqEZMaa5LNlUqduuloB7Ry9eWEeErH6y.jpg', '2025-07-12 18:16:42', '2025-07-12 18:16:42'),
(31, 10, 'maisons/secondaires/4QFaGKuZ8QLfxPDIf4vM6eLfiKeBD7B01yRpPZ7u.png', '2025-07-12 18:16:42', '2025-07-12 18:16:42');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('jNGvgX2OLRoirQglfEtTLvINRkY7HYBYl6eNZz70', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWW94UGRUSGlBMHU1bU43SjRsc0h3aTF2S2Q4b0FQODBRb0JVdjFPYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9sb2NhdGlvbi1odG1sLWNzcy1qcy50ZXN0L3JlY2hlcmNoZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1767723991);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `name`, `prenom`, `contact`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'yy', 'yy', '656565656', 'yy@gmail.com', '$2y$12$pJPmOgxrBNB5bgemD70uEOOaNNtagIEvFd20PIDaKcx1MFdCnOIRm', 'admin', '2025-07-10 12:11:38', '2025-07-10 12:11:38'),
(2, 'ii', 'ii', '857687', 'ii@gmail.com', '$2y$12$56KpzRbnbEhhg8uOqMYovuyAhaDv3xbTV/wbTyVXl.ovJsHx3Ne0G', 'client', '2025-07-10 13:41:37', '2025-07-10 13:41:37'),
(3, 'qq', 'qq', '435456', 'qq@gmail.com', '$2y$12$okLl7xfrwhRZx5Sr.PMeDeuG5XEE06cck.WXDCqXBIG2AElW7plZ6', 'admin', '2025-07-13 07:44:30', '2025-07-13 07:44:30'),
(4, 'bn', 'hg', '775756765', 'vbcc@hfjhg.com', '$2y$12$UYt.d2gDwdfklanIPoh4fOpf2LYhGNU2FUrNpfnndzv8yIKsmTnam', 'admin', '2025-07-13 07:49:02', '2025-07-13 07:49:02'),
(5, 'xx', 'xx', '435252', 'xx@gmail.com', '$2y$12$ruatMlXLZOj7BKzGdeY86uAVaTlbnNryLd0S1i.U3hvuNOGTmspMS', 'admin', '2025-07-15 19:48:09', '2025-07-15 19:48:09'),
(6, 'rr', 'rr', '3243424', 'rr@gmail.com', '$2y$12$n9OatyXJSPEFUn7AyT6QrONjFnhBqVDd2Pljf.UA9irQLC1BcU3mW', 'client', '2025-07-15 19:48:45', '2025-07-15 19:48:45');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `maisons`
--
ALTER TABLE `maisons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photos_maison_id_foreign` (`maison_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `utilisateurs_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `maisons`
--
ALTER TABLE `maisons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `maisons`
--
ALTER TABLE `maisons`
  ADD CONSTRAINT `maisons_utilisateur_id_foreign` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_maison_id_foreign` FOREIGN KEY (`maison_id`) REFERENCES `maisons` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
