-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 08 août 2026 à 16:09
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
(1, 'Habitations', 'https://images.unsplash.com/photo-1613977257363-707ba9348227?q=80&w=1400', NULL, '2026-07-01 19:10:40'),
(2, 'Bureauxs', 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=1400', NULL, '2026-06-12 21:11:29'),
(3, 'Boutiques', 'https://images.unsplash.com/photo-1494526585095-c41746248156?q=80&w=1200', NULL, '2026-08-06 19:43:45');

-- --------------------------------------------------------

--
-- Structure de la table `contrats`
--

CREATE TABLE `contrats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `utilisateur_id` bigint(20) UNSIGNED NOT NULL,
  `maison_id` bigint(20) UNSIGNED NOT NULL,
  `date_debut` date NOT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'actif',
  `motif` varchar(221) NOT NULL DEFAULT 'RIEN',
  `date_fin` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contrats`
--

INSERT INTO `contrats` (`id`, `utilisateur_id`, `maison_id`, `date_debut`, `statut`, `motif`, `date_fin`, `created_at`, `updated_at`) VALUES
(36, 24, 43, '2026-08-07', 'actif', 'RIEN', NULL, '2026-08-07 18:18:52', '2026-08-07 18:18:52'),
(37, 24, 44, '2026-08-07', 'actif', 'RIEN', NULL, '2026-08-07 18:28:10', '2026-08-07 18:28:10');

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
  `statut_moderation` varchar(255) NOT NULL DEFAULT 'en_attente',
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
  `visites_demandees` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `immeuble_etage` tinyint(1) NOT NULL DEFAULT 0,
  `meuble` tinyint(1) NOT NULL DEFAULT 0,
  `climatise` tinyint(1) NOT NULL DEFAULT 0,
  `sanitaire` tinyint(1) NOT NULL DEFAULT 0,
  `adapte_pmr` tinyint(1) NOT NULL DEFAULT 0,
  `compteur_elec_perso` tinyint(1) NOT NULL DEFAULT 0,
  `compteur_eau_perso` tinyint(1) NOT NULL DEFAULT 0,
  `caution_mois` int(11) DEFAULT NULL,
  `prepaiement_mois` int(11) DEFAULT NULL,
  `frais_visite` int(11) DEFAULT NULL,
  `commission` int(11) DEFAULT NULL,
  `caution_elec` int(11) DEFAULT NULL,
  `caution_eau` int(11) DEFAULT NULL,
  `caution_elec_eau` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `maisons`
--

INSERT INTO `maisons` (`id`, `titre`, `description`, `prix`, `statut_moderation`, `vues`, `est_loue`, `adresse`, `image`, `latitude`, `longitude`, `created_at`, `updated_at`, `utilisateur_id`, `categorie_id`, `ville`, `visites_demandees`, `immeuble_etage`, `meuble`, `climatise`, `sanitaire`, `adapte_pmr`, `compteur_elec_perso`, `compteur_eau_perso`, `caution_mois`, `prepaiement_mois`, `frais_visite`, `commission`, `caution_elec`, `caution_eau`, `caution_elec_eau`) VALUES
(43, 'Deux Chambres Salon WC Douche Interne', 'jkvlbljkhlv', 65876, 'publiee', 43, 1, 'legbassito', 'maisons/principales/1781272202_ab6b7d38d066c6a4f1649237d113f6ad.png', 6.1939738, 1.1900425, '2026-06-12 13:50:03', '2026-08-08 07:17:18', 13, 1, 'Lomé', 2, 0, 1, 1, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 4000, 4000, 5000),
(44, 'Deux Chambres Salon WC Douche Interne', 'etbrevwc', 3443435, 'publiee', 38, 1, 'agoe', 'maisons/principales/1781279161_Capture d’écran 2025-09-16 050923.png', 6.1781023, 1.1991405, '2026-06-12 15:34:51', '2026-08-07 18:28:10', 13, 1, 'Kétao', 1, 1, 1, 1, 1, 1, 1, 1, 4, 4, 5000, NULL, 4000, 5000, NULL),
(45, 'rhgfdhdhhd', 'rstbrythnbrsv', 54354, 'en_attente', 10, 0, 'agoe', 'maisons/principales/1781279753_Capture d’écran 2025-09-16 003110.png', 6.2054079, 1.1816311, '2026-06-12 15:55:53', '2026-06-30 13:03:04', 13, 1, 'lome', 0, 1, 0, 1, 1, 0, 0, 0, 4, 4, 5000, 645, 4000, 354, NULL),
(46, '5e64gyetrjy', 'ternyertyum,ountrbyevt', 3456534, 'en_attente', 4, 0, 'agoe', 'maisons/principales/1781279799_Capture d’écran 2025-09-16 002742.png', 6.5650000, 5.5550000, '2026-06-12 15:56:39', '2026-06-30 14:15:02', 13, 1, 'lome', 0, 1, 0, 1, 0, 0, 0, 0, 4, 4, 5000, 645, 4000, 354, NULL),
(47, '5e64gyetrjyehutr', 'rwetytnurebywvtca', 5344, 'en_attente', 4, 0, 'apessito', 'maisons/principales/1781279837_Capture d’écran 2025-09-16 044922.png', 6.5650000, 5.5550000, '2026-06-12 15:57:17', '2026-06-30 14:15:17', 13, 1, 'lome', 2, 1, 0, 1, 0, 1, 0, 0, 4, 4, 5000, 645, 4000, 354, NULL),
(48, '3 chmabre salon', 'gfh drtsevrbht d', 5344, 'publiee', 29, 0, 'apessito', 'maisons/principales/1781279879_Capture d’écran 2025-09-16 051058.png', 6.1394941, 1.2145632, '2026-06-12 15:57:59', '2026-08-07 18:17:52', 13, 1, 'Lomé', 1, 0, 0, 0, 0, 0, 0, 0, 4, 4, 5000, 645, 4000, 354, NULL),
(49, '3 chmabre 5salon', 'gttnfjdhbrgvsf', 500000, 'publiee', 9, 0, 'apessito', 'maisons/principales/1781279916_Capture d’écran 2025-09-16 003110.png', 6.1304848, 1.2154484, '2026-06-12 15:58:36', '2026-08-08 07:18:06', 13, 1, 'Lomé', 1, 0, 1, 1, 0, 0, 1, 0, 4, 4, 5000, 645, 4000, 354, NULL),
(50, '5 chambre', 'vghfjygkmujfynhtdbfss', 99999, 'publiee', 14, 0, 'avedji', 'maisons/principales/1781279972_Capture d’écran 2025-09-16 002742.png', 8.9841380, 1.1304667, '2026-06-12 15:59:32', '2026-08-06 20:25:42', 13, 1, 'Sokodé', 3, 1, 1, 0, 0, 0, 0, 0, 4, 4, 5000, 645, 4000, 354, NULL),
(51, 'evsgvbrebsv', 'rbh tjyftdrgsef', 3456435, 'publiee', 4, 0, 'kolo', 'maisons/principales/1781280030_Capture d’écran 2025-09-16 003110.png', 6.1360318, 1.2275940, '2026-06-12 16:00:30', '2026-07-21 17:48:03', 13, 1, 'Anié', 0, 1, 1, 1, 1, 1, 1, 1, 5, 4, 4000, NULL, NULL, NULL, NULL),
(52, 'rwnjdnfgf', 'tdyfnbg hjyr td', 5645, 'publiee', 4, 0, 'hhhh', 'maisons/principales/1781285080_Capture d’écran 2025-09-16 002902.png', 6.1919259, 1.1967373, '2026-06-12 17:24:40', '2026-07-19 20:38:36', 13, 2, 'Togoville', 0, 1, 0, 0, 1, 0, 0, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 'uneChambres Salon WC Douche Interne', 'gcmbvn, jdbfc hj nklyhjv', 6544, 'en_attente', 2, 0, 'logote', 'maisons/principales/1782254762_Capture d’écran 2026-05-11 111806.png', 6.5650000, 5.5550000, '2026-06-23 22:46:02', '2026-06-30 14:40:11', 13, 1, 'lome', 0, 1, 1, 1, 1, 0, 1, 1, 4, 4, 3400, NULL, 2000, 2000, NULL),
(54, 'trxxxxxx', 'Jxgxxihxohx', 50000, 'en_attente', 3, 0, 'Lamde', 'maisons/principales/1782254983_747127.jpg', 6.2155811, 1.2014992, '2026-06-23 22:49:43', '2026-06-30 14:27:58', 13, 1, 'Kara', 0, 1, 1, 1, 0, 0, 0, 0, 5, 2, NULL, NULL, NULL, NULL, NULL),
(55, 'Deux Chambres Salon WC Douche Interne', 'kjgffjghkhgjlnuignou', 60000, 'publiee', 17, 0, 'jjjJJjjJJJ', 'maisons/principales/1782473437_Capture d’écran 2026-05-11 112137.png', 6.2151352, 1.2008572, '2026-06-26 11:30:37', '2026-08-07 11:23:56', 13, 1, 'Bombouaka', 1, 1, 1, 1, 1, 1, 1, 1, 5, 9, 999999, 9000, 89898, 99999, NULL),
(57, 'Cchjbnju', 'Ccvjj vhv', 50000, 'publiee', 3, 0, 'Pagala', 'maisons/principales/1782901413_777221.jpg', 6.1888936, 1.1894879, '2026-07-01 10:23:33', '2026-08-07 10:32:51', 22, 2, 'Bafilo', 0, 1, 1, 1, 1, 0, 1, 1, 2, 5, 3000, 5000, 2000, 2000, NULL),
(58, 'Rthbbju', 'Fcvvhj vhhjj. Gukjb hhhh', 50000, 'publiee', 2, 1, 'Jannn', 'maisons/principales/1785916064_912309.png', 6.1933714, 1.1946391, '2026-08-05 07:47:44', '2026-08-08 00:30:39', 25, 3, 'Bafilo', 0, 1, 1, 1, 0, 1, 0, 1, 9, 9, 4000, 5000, 2000, 2000, NULL),
(59, 'ggggggg', 'gggggggggg', 4444437, 'en_attente', 0, 0, 'GGGGG', 'maisons/principales/1786054699_1.png', 6.2006295, 1.2005138, '2026-08-06 22:18:19', '2026-08-06 22:18:19', 13, 1, 'Notsé', 0, 0, 1, 0, 1, 1, 0, 1, 4, 4, 4000, 4000, NULL, NULL, NULL),
(60, 'ggggggg', 'hkgk  kjglk lljglklkj', 4444437, 'publiee', 2, 0, 'ggggg', 'maisons/principales/1786102206_6.jpg', 6.1909446, 1.1972523, '2026-08-07 11:30:06', '2026-08-07 15:24:57', 13, 3, 'Atakpamé', 0, 1, 0, 0, 1, 0, 0, 1, 4, 4, 4000, 4000, NULL, 77777, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `maison_id` bigint(20) UNSIGNED NOT NULL,
  `contenu` text NOT NULL,
  `lu` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(15, '2026_05_17_054914_add_visites_to_maisons_table', 6),
(16, '2026_06_07_192619_create_messages_table', 7),
(17, '2026_06_12_131043_add_options_to_maisons_table', 8),
(18, '2026_06_30_122619_add_moderation_to_maisons_table', 9),
(19, '2026_07_19_155245_create_contrats_table', 10),
(20, '2026_07_19_165717_create_paiements_table', 11);

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE `paiements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contrat_id` bigint(20) UNSIGNED NOT NULL,
  `montant` double NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0,
  `mois_concerne` varchar(255) NOT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'En attente',
  `date_concerne` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `moyen_paiement` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `date_paiement` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `paiements`
--

INSERT INTO `paiements` (`id`, `contrat_id`, `montant`, `type`, `mois_concerne`, `statut`, `date_concerne`, `moyen_paiement`, `transaction_id`, `date_paiement`, `created_at`, `updated_at`) VALUES
(197, 36, 65876, 0, 'August 2026', 'Payé', '2026-08-07 18:19:33', 'Orange Money', 'TRX-45172850', '2026-08-07 18:19:33', '2026-08-07 18:18:52', '2026-08-07 18:19:33'),
(198, 36, 4000, 0, 'Caution Électricité', 'Payé', '2026-08-07 18:20:04', NULL, NULL, '2026-08-07 18:20:04', '2026-08-07 18:18:52', '2026-08-07 18:20:04'),
(199, 36, 4000, 0, 'Caution Eau', 'Payé', '2026-08-07 18:20:04', NULL, NULL, '2026-08-07 18:20:04', '2026-08-07 18:18:52', '2026-08-07 18:20:04'),
(200, 36, 65876, 1, 'Août 2026', 'Payé', '2026-08-07 18:23:44', NULL, NULL, '2026-08-07 18:23:44', '2026-08-07 18:23:44', '2026-08-07 18:23:44'),
(201, 37, 3443435, 0, 'August 2026', 'Payé', '2026-08-07 18:28:25', 'MTN MoMo', 'TRX-55757513', '2026-08-07 18:28:25', '2026-08-07 18:28:10', '2026-08-07 18:28:25'),
(202, 37, 3443435, 0, 'Caution - September 2026', 'Payé', '2026-08-07 18:33:07', 'MTN MoMo', 'TRX-75111287-2', '2026-08-07 18:33:07', '2026-08-07 18:28:10', '2026-08-07 18:33:07'),
(203, 37, 3443435, 0, 'Caution - October 2026', 'Payé', '2026-08-07 18:33:07', 'MTN MoMo', 'TRX-75111287-3', '2026-08-07 18:33:07', '2026-08-07 18:28:10', '2026-08-07 18:33:07'),
(204, 37, 3443435, 0, 'Caution - November 2026', 'Payé', '2026-08-07 18:33:07', 'MTN MoMo', 'TRX-75111287-4', '2026-08-07 18:33:07', '2026-08-07 18:28:10', '2026-08-07 18:33:07'),
(205, 37, 3443435, 0, 'Caution - December 2026', 'Payé', '2026-08-07 18:33:07', 'MTN MoMo', 'TRX-75111287-5', '2026-08-07 18:33:07', '2026-08-07 18:28:10', '2026-08-07 18:33:07'),
(206, 37, 4000, 0, 'Caution Électricité', 'Payé', '2026-08-07 18:33:07', 'MTN MoMo', 'TRX-75111287-6', '2026-08-07 18:33:07', '2026-08-07 18:28:10', '2026-08-07 18:33:07'),
(207, 37, 5000, 0, 'Caution Eau', 'Payé', '2026-08-07 18:33:07', 'MTN MoMo', 'TRX-75111287-7', '2026-08-07 18:33:07', '2026-08-07 18:28:10', '2026-08-07 18:33:07'),
(208, 37, 5000, 0, 'Frais de Visite', 'Payé', '2026-08-07 18:33:07', 'MTN MoMo', 'TRX-75111287-8', '2026-08-07 18:33:07', '2026-08-07 18:28:10', '2026-08-07 18:33:07'),
(209, 37, 3443435, 1, 'Août 2026', 'Payé', '2026-08-07 18:37:02', 'Moov Money', 'TRX-78365451-1', '2026-08-07 18:37:02', '2026-08-07 18:37:02', '2026-08-07 18:37:02'),
(210, 37, 3443435, 1, 'Septembre 2026', 'Payé', '2026-08-07 18:37:57', 'T-Money', 'TRX-60111883-1', '2026-08-07 18:37:57', '2026-08-07 18:37:57', '2026-08-07 18:37:57'),
(211, 37, 3443435, 1, 'Octobre 2026', 'Payé', '2026-08-07 18:37:57', 'T-Money', 'TRX-60111883-2', '2026-08-07 18:37:57', '2026-08-07 18:37:57', '2026-08-07 18:37:57'),
(212, 37, 3443435, 1, 'Novembre 2026', 'Payé', '2026-08-07 18:37:57', 'T-Money', 'TRX-60111883-3', '2026-08-07 18:37:57', '2026-08-07 18:37:57', '2026-08-07 18:37:57'),
(213, 37, 3443435, 1, 'Décembre 2026', 'Payé', '2026-08-07 18:37:57', 'T-Money', 'TRX-60111883-4', '2026-08-07 18:37:57', '2026-08-07 18:37:57', '2026-08-07 18:37:57'),
(214, 37, 3443435, 1, 'Janvier 2027', 'Payé', '2026-08-07 18:37:57', 'T-Money', 'TRX-60111883-5', '2026-08-07 18:37:57', '2026-08-07 18:37:57', '2026-08-07 18:37:57'),
(215, 37, 3443435, 1, 'Février 2027', 'Payé', '2026-08-07 18:37:57', 'T-Money', 'TRX-60111883-6', '2026-08-07 18:37:57', '2026-08-07 18:37:57', '2026-08-07 18:37:57');

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
('smithkrettos@gmail.com', 'h87YzsNJ0xAtu3Y6DN5vLHzI4MyvRpNP0Y0kbtGgZFJvbnvh3HbTRbJGePL56gob', '2026-08-08 07:16:17');

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
(177, 44, 'maisons/secondaires/1781278491_ab6b7d38d066c6a4f1649237d113f6ad.png', '2026-06-12 15:34:51', '2026-06-12 15:34:51'),
(178, 44, 'maisons/secondaires/1781278491_b2a34e7fd3db657d6a4738ab0bdd2174.png', '2026-06-12 15:34:51', '2026-06-12 15:34:51'),
(180, 43, 'maisons/secondaires/1781279412_Capture d’écran 2025-09-16 003018.png', '2026-06-12 15:50:12', '2026-06-12 15:50:12'),
(181, 43, 'maisons/secondaires/1781279413_Capture d’écran 2025-09-16 003110.png', '2026-06-12 15:50:13', '2026-06-12 15:50:13'),
(182, 43, 'maisons/secondaires/1781279413_Capture d’écran 2025-09-16 003144.png', '2026-06-12 15:50:13', '2026-06-12 15:50:13'),
(183, 43, 'maisons/secondaires/1781279413_Capture d’écran 2025-09-16 044922.png', '2026-06-12 15:50:13', '2026-06-12 15:50:13'),
(184, 45, 'maisons/secondaires/1781279753_Capture d’écran 2025-09-16 003018.png', '2026-06-12 15:55:53', '2026-06-12 15:55:53'),
(185, 45, 'maisons/secondaires/1781279754_Capture d’écran 2025-09-16 003110.png', '2026-06-12 15:55:54', '2026-06-12 15:55:54'),
(186, 45, 'maisons/secondaires/1781279754_Capture d’écran 2025-09-16 003144.png', '2026-06-12 15:55:54', '2026-06-12 15:55:54'),
(187, 46, 'maisons/secondaires/1781279799_Capture d’écran 2025-09-16 003018.png', '2026-06-12 15:56:39', '2026-06-12 15:56:39'),
(188, 46, 'maisons/secondaires/1781279799_Capture d’écran 2025-09-16 003110.png', '2026-06-12 15:56:39', '2026-06-12 15:56:39'),
(189, 47, 'maisons/secondaires/1781279838_Capture d’écran 2025-09-16 003018.png', '2026-06-12 15:57:18', '2026-06-12 15:57:18'),
(190, 47, 'maisons/secondaires/1781279838_Capture d’écran 2025-09-16 003110.png', '2026-06-12 15:57:18', '2026-06-12 15:57:18'),
(191, 47, 'maisons/secondaires/1781279838_Capture d’écran 2025-09-16 003144.png', '2026-06-12 15:57:18', '2026-06-12 15:57:18'),
(192, 47, 'maisons/secondaires/1781279838_Capture d’écran 2025-09-16 044922.png', '2026-06-12 15:57:18', '2026-06-12 15:57:18'),
(193, 48, 'maisons/secondaires/1781279879_Capture d’écran 2025-09-16 003144.png', '2026-06-12 15:57:59', '2026-06-12 15:57:59'),
(194, 48, 'maisons/secondaires/1781279879_Capture d’écran 2025-09-16 044922.png', '2026-06-12 15:57:59', '2026-06-12 15:57:59'),
(195, 49, 'maisons/secondaires/1781279916_Capture d’écran 2025-09-16 003018.png', '2026-06-12 15:58:36', '2026-06-12 15:58:36'),
(196, 49, 'maisons/secondaires/1781279916_Capture d’écran 2025-09-16 003110.png', '2026-06-12 15:58:36', '2026-06-12 15:58:36'),
(197, 49, 'maisons/secondaires/1781279916_Capture d’écran 2025-09-16 003144.png', '2026-06-12 15:58:36', '2026-06-12 15:58:36'),
(198, 49, 'maisons/secondaires/1781279916_Capture d’écran 2025-09-16 044922.png', '2026-06-12 15:58:36', '2026-06-12 15:58:36'),
(199, 50, 'maisons/secondaires/1781279972_Capture d’écran 2025-09-16 050711.png', '2026-06-12 15:59:32', '2026-06-12 15:59:32'),
(200, 50, 'maisons/secondaires/1781279972_Capture d’écran 2025-09-16 050923.png', '2026-06-12 15:59:32', '2026-06-12 15:59:32'),
(201, 51, 'maisons/secondaires/1781280031_Capture d’écran 2025-09-16 003110.png', '2026-06-12 16:00:31', '2026-06-12 16:00:31'),
(202, 51, 'maisons/secondaires/1781280031_Capture d’écran 2025-09-16 003144.png', '2026-06-12 16:00:31', '2026-06-12 16:00:31'),
(203, 52, 'maisons/secondaires/1781285081_Capture d’écran 2025-09-16 002742.png', '2026-06-12 17:24:41', '2026-06-12 17:24:41'),
(204, 52, 'maisons/secondaires/1781285081_Capture d’écran 2025-09-16 002902.png', '2026-06-12 17:24:41', '2026-06-12 17:24:41'),
(205, 52, 'maisons/secondaires/1781285081_Capture d’écran 2025-09-16 003018.png', '2026-06-12 17:24:41', '2026-06-12 17:24:41'),
(206, 52, 'maisons/secondaires/1781285082_Capture d’écran 2025-09-16 003110.png', '2026-06-12 17:24:42', '2026-06-12 17:24:42'),
(207, 52, 'maisons/secondaires/1781285082_Capture d’écran 2025-09-16 003144.png', '2026-06-12 17:24:42', '2026-06-12 17:24:42'),
(208, 52, 'maisons/secondaires/1781285082_Capture d’écran 2025-09-16 044922.png', '2026-06-12 17:24:42', '2026-06-12 17:24:42'),
(209, 52, 'maisons/secondaires/1781285082_Capture d’écran 2025-09-16 050642.png', '2026-06-12 17:24:42', '2026-06-12 17:24:42'),
(210, 52, 'maisons/secondaires/1781285082_Capture d’écran 2025-09-16 050711.png', '2026-06-12 17:24:42', '2026-06-12 17:24:42'),
(211, 52, 'maisons/secondaires/1781285083_Capture d’écran 2025-09-16 050923.png', '2026-06-12 17:24:43', '2026-06-12 17:24:43'),
(214, 53, 'maisons/secondaires/1782254762_ACCUEIL 1.png', '2026-06-23 22:46:02', '2026-06-23 22:46:02'),
(215, 53, 'maisons/secondaires/1782254762_AJOUT CATEGORIE.png', '2026-06-23 22:46:02', '2026-06-23 22:46:02'),
(216, 53, 'maisons/secondaires/1782254762_Capture d’écran 2026-05-11 111806.png', '2026-06-23 22:46:02', '2026-06-23 22:46:02'),
(217, 53, 'maisons/secondaires/1782254763_Capture d’écran 2026-05-11 112137.png', '2026-06-23 22:46:03', '2026-06-23 22:46:03'),
(218, 54, 'maisons/secondaires/1782254983_745607.jpg', '2026-06-23 22:49:43', '2026-06-23 22:49:43'),
(219, 54, 'maisons/secondaires/1782254983_748766.jpg', '2026-06-23 22:49:43', '2026-06-23 22:49:43'),
(220, 54, 'maisons/secondaires/1782254983_748763.jpg', '2026-06-23 22:49:43', '2026-06-23 22:49:43'),
(221, 54, 'maisons/secondaires/1782254983_748769.jpg', '2026-06-23 22:49:43', '2026-06-23 22:49:43'),
(222, 54, 'maisons/secondaires/1782254983_748470.jpg', '2026-06-23 22:49:43', '2026-06-23 22:49:43'),
(223, 54, 'maisons/secondaires/1782254983_748721.jpg', '2026-06-23 22:49:43', '2026-06-23 22:49:43'),
(231, 57, 'maisons/secondaires/1782901413_781084.png', '2026-07-01 10:23:33', '2026-07-01 10:23:33'),
(232, 57, 'maisons/secondaires/1782901414_780447.png', '2026-07-01 10:23:34', '2026-07-01 10:23:34'),
(233, 57, 'maisons/secondaires/1782901414_779999.jpg', '2026-07-01 10:23:34', '2026-07-01 10:23:34'),
(234, 57, 'maisons/secondaires/1782901414_779806.jpg', '2026-07-01 10:23:34', '2026-07-01 10:23:34'),
(235, 57, 'maisons/secondaires/1782901414_778014.jpg', '2026-07-01 10:23:34', '2026-07-01 10:23:34'),
(236, 57, 'maisons/secondaires/1782901414_779705.jpg', '2026-07-01 10:23:34', '2026-07-01 10:23:34'),
(237, 58, 'maisons/secondaires/1785916064_912503.jpg', '2026-08-05 07:47:44', '2026-08-05 07:47:44'),
(238, 58, 'maisons/secondaires/1785916064_912502.jpg', '2026-08-05 07:47:44', '2026-08-05 07:47:44'),
(239, 58, 'maisons/secondaires/1785916064_912501.jpg', '2026-08-05 07:47:44', '2026-08-05 07:47:44'),
(240, 58, 'maisons/secondaires/1785916064_912500.jpg', '2026-08-05 07:47:44', '2026-08-05 07:47:44'),
(241, 58, 'maisons/secondaires/1785916064_912499.jpg', '2026-08-05 07:47:44', '2026-08-05 07:47:44'),
(242, 59, 'maisons/secondaires/1786054699_5.jpg', '2026-08-06 22:18:19', '2026-08-06 22:18:19'),
(243, 59, 'maisons/secondaires/1786054699_6.jpg', '2026-08-06 22:18:19', '2026-08-06 22:18:19'),
(244, 55, 'maisons/secondaires/1786101561_5.jpg', '2026-08-07 11:19:21', '2026-08-07 11:19:21'),
(245, 55, 'maisons/secondaires/1786101561_6.jpg', '2026-08-07 11:19:21', '2026-08-07 11:19:21'),
(246, 60, 'maisons/secondaires/1786102206_5.jpg', '2026-08-07 11:30:07', '2026-08-07 11:30:07'),
(247, 60, 'maisons/secondaires/1786102207_6.jpg', '2026-08-07 11:30:07', '2026-08-07 11:30:07');

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
('44n7LVcHqH52Bm4PVK2qMfMgNilnDO148swF1lxw', 24, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieTk0Nm1DOWF0cHh1QklNMjk5b0NpdlhIZDdMcUprMUQyMTREdVExayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3QvbG9jYXRpb24vcHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjQ7fQ==', 1786197477),
('8om6Z1zCd331uIZIh8HSZ8m7E8e2CbbPeeT5zOLY', 28, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaGdjTVQ3VHFucjF0WEU1QnJvVlFpSmZOUzZPMHFLU2p3a2ZuQlNQOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3QvbG9jYXRpb24vcHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjg7fQ==', 1786198095),
('jZGKoIX5qioH7VYXkAIKCq4Fd8ioyGc2wPyItSDR', 24, '192.168.0.102', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNlcwOFRSbnY1cXNQcDV0WGtFVFNBQWI1Q3BTaXlRM1JwOE83ZUNyaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjE6Imh0dHA6Ly8xOTIuMTY4LjAuMTA4L2xvY2F0aW9uL3B1YmxpYy9tb24tZXNwYWNlP2NvbnRyYXRfaWQ9MzciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyNDt9', 1786174356),
('MICm2H4aLiPZabEqJFZ1WbqsmIwP8D44X92yvWvF', 13, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiekNubjFUMjB3UUNnMkZqZ1RHS0k4dnF6ZU85aEx1c2d1eTdjSmlDWiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ0OiJodHRwOi8vbG9jYWxob3N0L2xvY2F0aW9uL3B1YmxpYy9hZG1pbi90YWJsZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEzO30=', 1786176226),
('NH2wmcWsHNPhUpmQksBued40WuheRyUyvD4O3hHG', 24, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQWp2QWU2M2ZiN1R1VExNeTY2WlVxMGxxOTBqMzd4SW9Denl6TWN0TiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vbG9jYWxob3N0L2xvY2F0aW9uL3B1YmxpYyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI0O30=', 1786173170);

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
(11, 'TAGBA', 'Gerard', '91304000', 'krettossmith@gmail.com', '$2y$12$zGF5SPUzNlZE4hueg2kvm.heG9s0FlyH0MKJybch7JGnGoscCF/Ie', 'dev', '2026-05-24 02:34:10', '2026-05-24 02:34:10', NULL),
(13, 'rr', 'rr', '4342324536', 'aa@gmail.com', '$2y$12$sS7xdwCa/bHzLeD3xj9AmeYtUW.IXtN6zYmafbrJfTE0CedPuCMBi', 'dev', '2026-06-09 14:27:39', '2026-06-09 14:27:39', NULL),
(14, 'TAGBA', 'Matthieu', '90140930', 'matthieutagba211998@gmail.com', '$2y$12$FLJWfbJit9StiQ5H2aq8FuGA.v5ugLXwWhiarONlZCx5dXIPuWqz2', 'client', '2026-06-09 17:40:09', '2026-06-09 17:40:09', NULL),
(15, 'Yy', 'Yy', '2580008', 'yy@gmail.com', '$2y$12$L5Y9a8T4GQUOqnsDW.D8Ue0GbN33YwBP9v4k.bNj4jbmIR7IP.6wW', 'admin', '2026-06-09 17:55:28', '2026-06-09 17:55:28', NULL),
(18, 'rr', 'rr', '56878768', 'rr@gmail.com', '$2y$12$ha27iAH4iskvvomiMdtu4.0wt2c46EUURt3Q8ajUn02vIPa2ezkwq', 'admin', '2026-06-12 10:39:15', '2026-06-12 10:39:15', NULL),
(19, 'rr', 'rr', '6588575', '00@gmail.com', '$2y$12$aEUznxmhkkbo/i9ZmMGc5.ocoPF9GxYgWLt0oaYrsD284A/uJGdRK', 'admin', '2026-06-12 10:40:59', '2026-06-12 10:40:59', NULL),
(20, 'rr', 'rr', '789978', 'rer@gmail.com', '$2y$12$AWcIZpt2Ib5UdUenukOSfewb/AtWyYHr3Y2guwhHJxDfUB1HG8FaO', 'admin', '2026-06-12 11:52:28', '2026-06-12 11:52:28', NULL),
(21, 'Kadjo', 'Koffi', '93625807', 'razak@gmail.com', '$2y$12$awzkiRr1lFHL58lPSzKaCuxnzt4Z1cwPsueRLnchUGxVxeJJLhqJe', 'admin', '2026-06-12 12:01:33', '2026-06-12 12:01:33', 'mSpauV8ENq6qIb39PwEEQlLgbSMfz7bG6zVYjgvLgnFnLZYko2LybkciQkUr'),
(22, 'Gg', 'Gg', '91304000', 'smithkrettos@gmail.com', '$2y$12$En/enMjy5p7KoRTZMQqKmOGhvNpGrFiHFajxfva2qU2Z6iguh.iFW', 'admin', '2026-07-01 10:19:14', '2026-07-01 10:19:14', NULL),
(23, 'bb', 'bb', '77777777', 'bb@gmail.com', '$2y$12$L7viCbZHVq/0NhKgWaqSH.nkCUaurs2q06191l07dUSQsjLMOs8aK', 'client', '2026-07-19 18:02:10', '2026-07-19 18:02:10', NULL),
(24, 'ww', 'ww', '7878787', 'ww@gmail.com', '$2y$12$3ibIQ1.rnc4PekP4GcezyesP7rdhbUik2MmMnYSKHXdWwx7pQpnhi', 'client', '2026-07-19 19:02:43', '2026-07-19 19:02:43', NULL),
(25, 'nnnn', 'nn', '90090909', 'nn@gmail.com', '$2y$12$YwsC.njrci40nWba85Ept..zb/oLHezZ5237Cfdw7X6s5CThj0reK', 'admin', '2026-08-05 07:22:32', '2026-08-05 07:22:32', NULL),
(26, 'zz', 'zz', '34343434', 'zz@gmail.com', '$2y$12$Syi8aMZrOUITPmD0ubSrD.31AOsVMsSDZJf7OcBKQ9nvRQFguDSIm', 'client', '2026-08-05 07:49:49', '2026-08-05 07:49:49', NULL),
(27, 'TAGBA', 'Gérard', '25809632', 'amm@gmail.com', '$2y$12$7iqA0Gcog8ffPHReyi3BIOlfHkegE4mpEFRrVUF16V7KduSdGe0uy', 'admin', '2026-08-06 22:33:20', '2026-08-06 22:33:20', NULL),
(28, 'AyengréBBBBB', 'khkj', '97879875', 'POO@gmail.com', '$2y$12$8APYZTthHR4QbcP0cfcX4eLdK3uqMe5xebzvfcfl.85XlBAB4SxWC', 'admin', '2026-08-08 14:08:06', '2026-08-08 14:08:06', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

CREATE TABLE `villes` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `region` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `villes`
--

INSERT INTO `villes` (`id`, `nom`, `region`, `created_at`) VALUES
(1, 'Lomé', 'Maritime', '2026-06-26 11:21:09'),
(2, 'Tsévié', 'Maritime', '2026-06-26 11:21:09'),
(3, 'Aného', 'Maritime', '2026-06-26 11:21:09'),
(4, 'Tabligbo', 'Maritime', '2026-06-26 11:21:09'),
(5, 'Vogan', 'Maritime', '2026-06-26 11:21:09'),
(6, 'Kévé', 'Maritime', '2026-06-26 11:21:09'),
(7, 'Afagnangan', 'Maritime', '2026-06-26 11:21:09'),
(8, 'Baguida', 'Maritime', '2026-06-26 11:21:09'),
(9, 'Agbodrafo', 'Maritime', '2026-06-26 11:21:09'),
(10, 'Togoville', 'Maritime', '2026-06-26 11:21:09'),
(11, 'Atakpamé', 'Plateaux', '2026-06-26 11:21:09'),
(12, 'Kpalimé', 'Plateaux', '2026-06-26 11:21:09'),
(13, 'Badou', 'Plateaux', '2026-06-26 11:21:09'),
(14, 'Notsé', 'Plateaux', '2026-06-26 11:21:09'),
(15, 'Anié', 'Plateaux', '2026-06-26 11:21:09'),
(16, 'Amlamé', 'Plateaux', '2026-06-26 11:21:09'),
(17, 'Danyi Apéyemé', 'Plateaux', '2026-06-26 11:21:09'),
(18, 'Elavagnon', 'Plateaux', '2026-06-26 11:21:09'),
(19, 'Adéta', 'Plateaux', '2026-06-26 11:21:09'),
(20, 'Tohoun', 'Plateaux', '2026-06-26 11:21:09'),
(21, 'Sokodé', 'Centrale', '2026-06-26 11:21:09'),
(22, 'Tchamba', 'Centrale', '2026-06-26 11:21:09'),
(23, 'Sotouboua', 'Centrale', '2026-06-26 11:21:09'),
(24, 'Blitta', 'Centrale', '2026-06-26 11:21:09'),
(25, 'Djarkpanga', 'Centrale', '2026-06-26 11:21:09'),
(26, 'Kambolé', 'Centrale', '2026-06-26 11:21:09'),
(27, 'Ayengré', 'Centrale', '2026-06-26 11:21:09'),
(28, 'Kara', 'Kara', '2026-06-26 11:21:09'),
(29, 'Bassar', 'Kara', '2026-06-26 11:21:09'),
(30, 'Niamtougou', 'Kara', '2026-06-26 11:21:09'),
(31, 'Bafilo', 'Kara', '2026-06-26 11:21:09'),
(32, 'Pagouda', 'Kara', '2026-06-26 11:21:09'),
(33, 'Kandé', 'Kara', '2026-06-26 11:21:09'),
(34, 'Guérin-Kouka', 'Kara', '2026-06-26 11:21:09'),
(35, 'Kabou', 'Kara', '2026-06-26 11:21:09'),
(36, 'Kétao', 'Kara', '2026-06-26 11:21:09'),
(37, 'Dapaong', 'Savanes', '2026-06-26 11:21:09'),
(38, 'Sansanné-Mango', 'Savanes', '2026-06-26 11:21:09'),
(39, 'Cinkassé', 'Savanes', '2026-06-26 11:21:09'),
(40, 'Mandouri', 'Savanes', '2026-06-26 11:21:09'),
(41, 'Tandjouaré', 'Savanes', '2026-06-26 11:21:09'),
(42, 'Gando', 'Savanes', '2026-06-26 11:21:09'),
(43, 'Bombouaka', 'Savanes', '2026-06-26 11:21:09'),
(44, 'Biankouri', 'Savanes', '2026-06-26 11:21:09');

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
-- Index pour la table `contrats`
--
ALTER TABLE `contrats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contrats_utilisateur_id_foreign` (`utilisateur_id`),
  ADD KEY `contrats_maison_id_foreign` (`maison_id`);

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
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`),
  ADD KEY `messages_maison_id_foreign` (`maison_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paiements_contrat_id_foreign` (`contrat_id`);

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
-- Index pour la table `villes`
--
ALTER TABLE `villes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `contrats`
--
ALTER TABLE `contrats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `villes`
--
ALTER TABLE `villes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contrats`
--
ALTER TABLE `contrats`
  ADD CONSTRAINT `contrats_maison_id_foreign` FOREIGN KEY (`maison_id`) REFERENCES `maisons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contrats_utilisateur_id_foreign` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `maisons`
--
ALTER TABLE `maisons`
  ADD CONSTRAINT `maisons_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maisons_utilisateur_id_foreign` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD CONSTRAINT `paiements_contrat_id_foreign` FOREIGN KEY (`contrat_id`) REFERENCES `contrats` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_maison_id_foreign` FOREIGN KEY (`maison_id`) REFERENCES `maisons` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
