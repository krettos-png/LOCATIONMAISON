-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 17 mai 2026 à 11:18
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
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Villas', 'https://images.unsplash.com/photo-1613977257363-707ba9348227?q=80&w=1400', NULL, NULL),
(2, 'Appartements', 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=1400', NULL, NULL),
(3, 'Maisons', 'https://images.unsplash.com/photo-1494526585095-c41746248156?q=80&w=1200', NULL, NULL);

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
  `titre` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `prix` int(18) NOT NULL,
  `vues` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `est_loue` tinyint(1) NOT NULL DEFAULT 0,
  `adresse` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `utilisateur_id` bigint(20) UNSIGNED NOT NULL,
  `categorie_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `visites_demandees` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `maisons`
--

INSERT INTO `maisons` (`id`, `titre`, `description`, `prix`, `vues`, `est_loue`, `adresse`, `image`, `latitude`, `longitude`, `created_at`, `updated_at`, `utilisateur_id`, `categorie_id`, `ville`, `visites_demandees`) VALUES
(1, 'fjhgjfdgGHJKLjk', 'ghjNBV?khgfdhjk', 4546877, 0, 1, 'fsaghssfa', 'maisons/principales/wK4ZTajlS8loCDKPlzCl064lrNBEB0ZbpouCxTFS.png', 6.1985522, 1.1837147, '2026-05-11 17:33:55', '2026-05-17 02:04:57', 1, NULL, 'anie', 0),
(2, 'fjhgjfdgGHJKLjk', 'jfkdjfhgklfhjggklhg fbehjterhtrejvrntjmb5j5 mj5m5 mu5 k5jb65m 57bm5n67nm65m56666 m5m7m56 m75m56nvb45b', 655678, 0, 1, 'jfgkhlkcj', 'maisons/principales/DIceqBiTV4PDGO7RIFb1tjjtVW60dlHeBoJdJvPQ.jpg', 6.1911776, 1.1935023, '2026-05-11 17:59:46', '2026-05-17 00:34:15', 1, 1, 'yyyyyy', 0),
(3, 'fjhgjfdghfggkjg788', 't687btotbo98o', 99999, 3, 0, 'ykutdfghlf', 'maisons/principales/fzIo9rFRvMcyqBbDl3Hwxc5QO2OFAwt0nPx1UHNO.webp', 6.1995542, 1.2017446, '2026-05-11 18:00:58', '2026-05-17 09:01:02', 1, 3, 'ouiou', 0),
(4, 'yterbtrwveq', 'uuuuutbhryjmiytrbv4', 53455, 1, 0, 'bhgdf s', 'maisons/principales/WVKGtQohj7IiUNQXr8ZRYAg4GZ5xaLVMpnLIHxCX.webp', 6.2163260, 1.2055223, '2026-05-12 00:45:40', '2026-05-17 05:41:10', 1, 2, 'cvnbnc', 0),
(5, 'thjynrbever v', 'trhmtyjmn rtb ev', 45344, 4, 0, 'ghjgk', 'maisons/principales/Hn7XWI7Uegqw1FYfy1qVrciBi92oYPgVdbWlJzEA.webp', 6.1985877, 1.2031183, '2026-05-12 00:46:28', '2026-05-17 06:26:50', 1, 3, 'oiu0up', 1),
(8, 'rrrrrrrrrrr', 'rrrrrrrrrrrrr', 9909909, 0, 1, 'legbassito', 'maisons/principales/uZerMXagIJSnNqlB47Q3VVd7BefwLsamf2Vl9Y12.webp', 6.2020913, 1.2024314, '2026-05-12 03:06:16', '2026-05-17 00:24:04', 2, 1, 'lome', 0),
(9, 'fdgbdfbdf', 'db dsfbs', 3452534, 1, 0, 'AKPAME', 'maisons/principales/UYYAv8ZE7ykJi8kEPTXVudQN1JblgfR0dyU7DlEw.jpg', 6.2205000, 1.1975956, '2026-05-12 04:05:35', '2026-05-17 05:41:07', 4, 2, 'SOKODE3', 0),
(11, 'HGFKHJGLHJKER jhfjfjh jhfjhf jgfkj dkhgkjh gfk jhv', 'DKFJOIUTIUHGILUWAGW', 1111175, 2, 0, 'agoe', 'maisons/principales/rfKajJhlErcHpHlxa9DF43iTHnigISpPbm84DZ7y.png', 6.2062985, 1.2024314, '2026-05-13 19:24:34', '2026-05-17 09:01:24', 2, 3, 'ANEHO', 1),
(12, 'HGFKHJGLHJKER FJHFJ HFJ JGHKHJKVKJVLH JKBK', 'DKFJOIUTIUHGILUWAGW', 6666666, 22, 0, 'agoe', 'maisons/principales/T3gd5TJOoXe2Y4RlUToTTMfgxJaxe2YR0EKtcaUJ.png', 6.1923123, 1.1981386, '2026-05-13 19:26:27', '2026-05-17 08:59:01', 2, 3, 'ANEHO', 12),
(13, 'Deux Chambres Salon WC Douche Interne', 'DKFJOIUTIUHGILUWAGW', 999999999, 1, 0, 'jfgkhlkcjgvbjlkhjcb mn', 'maisons/principales/ZXfnCm05My2aGENrGIsezo6kPWK28DjhOGRjblNA.png', 6.2178966, 1.2135928, '2026-05-13 19:39:22', '2026-05-17 05:41:02', 2, 2, 'yyyyyy', 0),
(14, 'sgsdfasvsaa', 'SDFNGMHG,FGKGFD', 36433, 1, 0, 'DFDFHJFJFDHD', 'maisons/principales/bMF4StT4gDW8O9B7K2ZyMhllYGCArF7aF7SQ7zQs.webp', 6.2148685, 1.2005138, '2026-05-17 02:01:17', '2026-05-17 05:40:51', 1, 1, 'GFFJFJGF', 0);

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
(4, '2025_06_05_050208_create_maisons_table', 1),
(5, '2025_06_05_060912_create_photos_table', 1),
(6, '2025_06_05_071609_add_latitude_longitude_to_maisons_table', 1),
(7, '2025_07_10_132413_create_utilisateurs_table', 1),
(8, '2025_07_10_133613_add_utilisateur_id_to_maisons_table', 1),
(9, '2026_05_11_161724_create_categories_table', 1),
(10, '2026_05_11_165527_add_categorie_id_to_maisons_table--table=maisons', 1),
(11, '2026_05_12_025717_add_ville_to_maisons_table--table=maisons', 2),
(12, '2026_05_16_213448_add_est_loue_to_maisons_table', 3),
(13, '2026_05_17_051754_add_vues_to_maisons_table', 4),
(14, '2026_05_17_053900_add_vues_to_maisons_table', 5),
(15, '2026_05_17_054914_add_visites_to_maisons_table', 6);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('rr@gmail.com', 'sl9bCOhIvYaFrALDeaEVrbKGQOz5S6bNR4B5cvZz3rHQycNpou0ntBfLHy7VJBtJ', '2026-05-14 03:45:25'),
('smithkrettos@gmail.com', 'wlmRyJrSTSORJpAWvTIQf7cnk2iktmdw2nZ8B4417mdojcIDqfZBDdR1YGMlsT1j', '2026-05-14 03:46:11');

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
(1, 1, 'maisons/secondaires/rdk17Le3inQJW1xz9flWZYlyO5PEzGkBdE1qletf.png', '2026-05-11 17:33:55', '2026-05-11 17:33:55'),
(2, 1, 'maisons/secondaires/9wtVWtjIfmJEB1Sm2DC2MYotfEGi121GC3maPfvM.png', '2026-05-11 17:33:55', '2026-05-11 17:33:55'),
(3, 1, 'maisons/secondaires/wdK1jJs678K9689JscBC7oBeBhaL8iGJbe2HeVwU.png', '2026-05-11 17:33:55', '2026-05-11 17:33:55'),
(4, 1, 'maisons/secondaires/l132fjdNPYKKUoNPKvFANLtyoFn2oB1DYFlbQZbj.png', '2026-05-11 17:33:55', '2026-05-11 17:33:55'),
(8, 3, 'maisons/secondaires/AOLlYgr2cqLcgUCR6KrvQEBaGEmy4j5Pm23Yhmkn.webp', '2026-05-11 18:00:58', '2026-05-11 18:00:58'),
(9, 3, 'maisons/secondaires/vOKnFB74elwOh3l8cwlmj5VXWI17QjDBTJle6zME.webp', '2026-05-11 18:00:58', '2026-05-11 18:00:58'),
(10, 3, 'maisons/secondaires/RmhWl7hT5dyA4prBMxHMqM8yXYBR0oxzQFSvDMMX.webp', '2026-05-11 18:00:59', '2026-05-11 18:00:59'),
(11, 4, 'maisons/secondaires/E0QHQM0ySlqAu8XcIFs3xMWCjGfj9IwUZhNRnxtC.webp', '2026-05-12 00:45:41', '2026-05-12 00:45:41'),
(12, 4, 'maisons/secondaires/kblfF6zRgbTc0kJjdAOPb6t1GTFsuFyCpe6rwsda.webp', '2026-05-12 00:45:41', '2026-05-12 00:45:41'),
(13, 4, 'maisons/secondaires/DUDh5G3gpjCEZX3ASWOxdieOwAWwVSCsEX6qP0Bj.webp', '2026-05-12 00:45:41', '2026-05-12 00:45:41'),
(14, 5, 'maisons/secondaires/z7IFJzSAwblzQug2wmKZz6mDfsCO8KlO9SGQXmmG.webp', '2026-05-12 00:46:28', '2026-05-12 00:46:28'),
(15, 5, 'maisons/secondaires/QDUS7yaUOLuIyQ3O7dr8jtJ8cfsMRfGLGnFFl6YE.webp', '2026-05-12 00:46:28', '2026-05-12 00:46:28'),
(16, 5, 'maisons/secondaires/Hot9vhEyw6YbMIZvRizG5mrnrEvxZtUf2NplLAxs.webp', '2026-05-12 00:46:28', '2026-05-12 00:46:28'),
(31, 8, 'maisons/secondaires/5c9d1bywwYWBs9p3a2ZXfKd7l8pRWGY2XnqZNPsh.webp', '2026-05-12 03:06:16', '2026-05-12 03:06:16'),
(32, 8, 'maisons/secondaires/thIHbfUDRAKTYFO5j6vCR6gO0nhO8yb5S8IYTsqL.webp', '2026-05-12 03:06:16', '2026-05-12 03:06:16'),
(33, 8, 'maisons/secondaires/D5K3eB3AxGzQGMVcGTgxqChwVwfYgfwLGvRVNXHJ.webp', '2026-05-12 03:06:17', '2026-05-12 03:06:17'),
(34, 9, 'maisons/secondaires/9m5mQysA5HQnwMVMMtHbUBnjRXTVMnmd5lkgZI67.jpg', '2026-05-12 04:05:35', '2026-05-12 04:05:35'),
(35, 9, 'maisons/secondaires/gUGWQLKc3iuYJOR1hgJe6nQeYWdkas5Q8E8EOwfO.jpg', '2026-05-12 04:05:35', '2026-05-12 04:05:35'),
(36, 9, 'maisons/secondaires/13q3mXYvUv5zZaIriuu9JelzjkSWkaFXCwzyyrDa.jpg', '2026-05-12 04:05:35', '2026-05-12 04:05:35'),
(37, 2, 'maisons/secondaires/b163IOLbLgh0X8VD7pgnuQLtHejhyGrNDAqOAhZt.webp', '2026-05-12 04:25:52', '2026-05-12 04:25:52'),
(38, 2, 'maisons/secondaires/pJWUOuUg36YtZVl8iqMs6zsYxII3RG2ueD42LzXS.webp', '2026-05-12 04:25:52', '2026-05-12 04:25:52'),
(39, 2, 'maisons/secondaires/DpgRc8z8MYHps9snwBYgahAkhfE8D1znE4Chs4cT.webp', '2026-05-12 04:25:52', '2026-05-12 04:25:52'),
(42, 11, 'maisons/secondaires/9bPZBlTjqD7g4OM3tmGGH92w7gmH59aJhiAq2aww.png', '2026-05-13 19:24:34', '2026-05-13 19:24:34'),
(43, 11, 'maisons/secondaires/BjloI8UR0vTL6yElPre2pTtUZ4n5w2kAtBz9yb2Q.png', '2026-05-13 19:24:34', '2026-05-13 19:24:34'),
(44, 11, 'maisons/secondaires/8I9Ay6HFh7wGPeZHLcVoKOOdzlX8NPUOcw4lFcnD.png', '2026-05-13 19:24:34', '2026-05-13 19:24:34'),
(45, 12, 'maisons/secondaires/HbL4b7bwspJZOOZKwciNc2KcXQuieictK1HN03Bz.png', '2026-05-13 19:26:28', '2026-05-13 19:26:28'),
(46, 12, 'maisons/secondaires/TSO01VXg673sHfHKW1T0xfZlpzJ9kzYKMkibADwL.png', '2026-05-13 19:26:28', '2026-05-13 19:26:28'),
(47, 12, 'maisons/secondaires/cWQLJtG75O3I3FynhWHWML6V97Lvl27PoLNA7kek.png', '2026-05-13 19:26:28', '2026-05-13 19:26:28'),
(48, 13, 'maisons/secondaires/c55qh1uJw16flMAClbzC2It7PIuLIRGwPKdM1YCK.png', '2026-05-13 19:39:22', '2026-05-13 19:39:22'),
(49, 13, 'maisons/secondaires/mq7k5xHDqYrN7IGSrLq9GHvnxhoCdELAL77z9Jiw.png', '2026-05-13 19:39:22', '2026-05-13 19:39:22'),
(50, 13, 'maisons/secondaires/lb5wQEIYOeboBv0VbDc3DDfEZYOae7d7oWebiya0.png', '2026-05-13 19:39:22', '2026-05-13 19:39:22'),
(51, 13, 'maisons/secondaires/yz7AybCT3svAu7H9we2uPK3E4NVXWhoLZjk0vXr9.png', '2026-05-13 19:39:22', '2026-05-13 19:39:22'),
(52, 14, 'maisons/secondaires/nVgnXCppR42CmbtUCJCB07vnebronWffu8DYqvZW.webp', '2026-05-17 02:01:17', '2026-05-17 02:01:17'),
(53, 14, 'maisons/secondaires/bKm7OpHtVFw0PX1hkfpXmt9kCxwlmY9pe7jP1Quk.webp', '2026-05-17 02:01:17', '2026-05-17 02:01:17'),
(54, 14, 'maisons/secondaires/lXNnGEXB7KCxeVJE4Sd7cPzPhNhso9YBcmeUXrv4.webp', '2026-05-17 02:01:18', '2026-05-17 02:01:18');

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
('JcvEpF843Nq88FbsXKVSzcCL5ZHMCEEU5H36VItq', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', 'YToxMTp7czo2OiJfdG9rZW4iO3M6NDA6IlM1RXFiazhJWjI4bk5yemFuZmRGYnNadzVtYUYyN2ZOZ043MW1hWEUiO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ0OiJodHRwOi8vbG9jYXRpb24taHRtbC1jc3MtanMudGVzdC9hZG1pbi90YWJsZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTU6InZpZXdlZF9tYWlzb25fNSI7YjoxO3M6MTY6InZpZXdlZF9tYWlzb25fMTQiO2I6MTtzOjE2OiJ2aWV3ZWRfbWFpc29uXzEzIjtiOjE7czoxNToidmlld2VkX21haXNvbl85IjtiOjE7czoxNToidmlld2VkX21haXNvbl80IjtiOjE7czoxNjoidmlld2VkX21haXNvbl8xMiI7YjoxO3M6MTU6InZpZXdlZF9tYWlzb25fMyI7YjoxO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1779008766);

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `name`, `prenom`, `contact`, `email`, `password`, `role`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'rr', 'rr', '3243424', 'rr@gmail.com', '$2y$12$VQXJtJzQ5X3NUlGWVYfE1OtwMIvg8EmgxAFkGs3JdkGPlAghZx8B.', 'admin', '2026-05-11 17:32:38', '2026-05-11 17:32:38', NULL),
(2, 'TAGBA', 'Gerard', '91304000', 'smithkrettos@gmail.com', '$2y$12$6zyRxW85/S6gWc8I5iXzKuhz7jf8SLTmKy70GYavlpjoumGSNXOh6', 'admin', '2026-05-11 20:52:46', '2026-05-11 20:52:46', NULL),
(3, 'RT', 'GJHK', '57675765', 'GH@gmail.com', '$2y$12$p17oavudVAdgaaO3lkWBPO416yAskH7M5WEb.UOjpUBR0kcKEonOq', 'client', '2026-05-12 02:19:04', '2026-05-12 02:19:04', 'frotDNLMiAbSX20tTkMAknyJzBxdl65VAOY5woQOUi1OoP3FceTOxCRi5Taq'),
(4, 'uu', 'uu', '76754635', 'smithkrettos@gmail.c0m', '$2y$12$tGAu.wD4787EZYdbbAmL0.OSgh5MZT7DFUIi.uExIWM4ApId4TeS.', 'admin', '2026-05-12 04:03:47', '2026-05-12 04:03:47', NULL),
(5, 'ykjjk', 'jvhvkhvbkjhb', '3543545', 'qq@gmail.com', '$2y$12$RKwj9kgYMk0SQ16o2EYBc.SmMV2sRUREjQajekKbSNfiiiswW4gv.', 'admin', '2026-05-14 02:22:35', '2026-05-14 02:22:35', NULL),
(6, 'hjhjkh', 'vbbnbvmn', '454647545', 'pp@gmail.com', '$2y$12$Wg.MukIPS61woTObo3BDAek/FEOkBCn4SZRFvPZcE.SXiajhhMttm', 'admin', '2026-05-14 02:47:16', '2026-05-14 02:47:16', NULL),
(7, 'erteterrte', 'eewtwewer', '343535353', 'shkrettos@gmail.com', '$2y$12$e1lALL1/Bu6eBA7nyWmYjesKV4wj8Uw9KU4RMPc1UeMsEdTDpaRdG', 'admin', '2026-05-14 02:49:43', '2026-05-14 02:49:43', NULL),
(8, 'dsfhd', 'gfsdgfg', '3534553', 'tgos@gmail.com', '$2y$12$HQAqDiP18nsLSr6YMiQhOOvkfjMJdkHSHL.1KAiAyFVDne.B2LgVi', 'admin', '2026-05-14 02:52:38', '2026-05-14 02:52:38', NULL),
(9, 'dsfhd', 'gfsdgfg', '3534553', 'tgodfgfgs@gmail.com', '$2y$12$lWoXn2fRv.lWFGWPASidBOdWY.U9eI4vTqU8gWR2JmZYSFZw.pDA6', 'admin', '2026-05-14 02:54:25', '2026-05-14 02:54:25', NULL),
(10, 'dsfhd', 'gfsdgfg', '3534553', 'fyts@gmail.com', '$2y$12$MxKgY1jzoVFZ0h0XkH2zm.fs6YF4GXmLl/pKy8uaqYaWbSzcgsYgq', 'admin', '2026-05-14 02:59:39', '2026-05-14 02:59:39', 'uQnOPUrxurdBQ9So16zfvm3sjC8CfEzvnuxg2mHPmvyOwVXl7DssP8csfy8N');

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
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `maisons_utilisateur_id_foreign` (`utilisateur_id`),
  ADD KEY `maisons_categorie_id_foreign` (`categorie_id`);

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
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `maisons`
--
ALTER TABLE `maisons`
  ADD CONSTRAINT `maisons_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
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
