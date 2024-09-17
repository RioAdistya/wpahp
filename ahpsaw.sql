-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2024 at 03:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ahpsaw`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(99) NOT NULL COMMENT 'Nama alternatif',
  `desc` varchar(255) DEFAULT NULL COMMENT 'Keterangan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id`, `name`, `desc`, `created_at`, `updated_at`) VALUES
(1, 'dwi rahmad', NULL, '2024-06-18 21:05:43', '2024-06-18 21:05:54'),
(2, 'ahmad jaya', NULL, '2024-07-04 07:38:52', '2024-07-04 07:38:52'),
(3, 'selamat riyadi', NULL, '2024-07-04 07:39:02', '2024-07-04 07:39:02'),
(4, 'nurcahyo', NULL, '2024-07-04 07:39:08', '2024-07-04 07:39:08'),
(5, 'mauren', NULL, '2024-07-04 07:39:16', '2024-07-04 07:39:16');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `hasil`
--

CREATE TABLE `hasil` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alternatif_id` bigint(20) UNSIGNED NOT NULL,
  `skor` double(8,5) NOT NULL DEFAULT 0.00000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hasil`
--

INSERT INTO `hasil` (`id`, `alternatif_id`, `skor`, `created_at`, `updated_at`) VALUES
(1, 1, 0.21900, '2024-07-04 07:46:09', '2024-07-04 07:46:09'),
(2, 2, 0.21000, '2024-07-04 07:46:09', '2024-07-04 07:46:09'),
(3, 3, 0.19100, '2024-07-04 07:46:09', '2024-07-04 07:46:09'),
(4, 4, 0.15700, '2024-07-04 07:46:09', '2024-07-04 07:46:09'),
(5, 5, 0.22200, '2024-07-04 07:46:09', '2024-07-04 07:46:09');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(99) NOT NULL COMMENT 'Nama kriteria',
  `bobot` double(8,5) NOT NULL DEFAULT 0.00000,
  `type` enum('cost','benefit') NOT NULL COMMENT 'Atribut',
  `desc` varchar(255) DEFAULT NULL COMMENT 'Keterangan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id`, `name`, `bobot`, `type`, `desc`, `created_at`, `updated_at`) VALUES
(1, 'Jenis kandang', 0.34415, 'benefit', NULL, '2024-06-18 19:36:29', '2024-07-13 09:50:14'),
(2, 'Populasi kandang', 0.09016, 'benefit', NULL, '2024-06-18 19:36:44', '2024-07-13 09:50:14'),
(3, 'Luas kandang', 0.02818, 'benefit', NULL, '2024-06-18 19:36:56', '2024-07-13 09:50:14'),
(4, 'Kondisi kandang', 0.06104, 'benefit', NULL, '2024-06-18 19:37:12', '2024-07-13 09:50:14'),
(5, 'Lokasi kandang', 0.07381, 'benefit', NULL, '2024-06-18 19:37:28', '2024-07-13 09:50:14'),
(6, 'Fasilitas kandang', 0.22651, 'benefit', NULL, '2024-06-18 19:37:43', '2024-07-13 09:50:14'),
(7, 'Pengalaman peternak', 0.17615, 'benefit', NULL, '2024-06-18 19:38:01', '2024-07-13 09:50:14');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria_banding`
--

CREATE TABLE `kriteria_banding` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kriteria1` bigint(20) UNSIGNED NOT NULL,
  `kriteria2` bigint(20) UNSIGNED NOT NULL,
  `nilai` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kriteria_banding`
--

INSERT INTO `kriteria_banding` (`id`, `kriteria1`, `kriteria2`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2024-06-18 19:43:43', '2024-06-18 19:43:43'),
(2, 1, 2, 3, '2024-06-18 19:43:43', '2024-06-18 20:54:23'),
(3, 1, 3, 9, '2024-06-18 19:43:43', '2024-06-18 20:54:23'),
(4, 1, 4, 7, '2024-06-18 19:43:43', '2024-06-18 20:54:23'),
(5, 1, 5, 5, '2024-06-18 19:43:43', '2024-06-18 20:54:23'),
(6, 1, 6, 2, '2024-06-18 19:43:43', '2024-06-18 19:43:43'),
(7, 1, 7, 3, '2024-06-18 19:43:43', '2024-06-18 19:43:43'),
(8, 2, 2, 1, '2024-06-18 19:43:43', '2024-06-18 19:43:43'),
(9, 2, 3, 3, '2024-06-18 19:43:43', '2024-06-18 20:54:23'),
(10, 2, 4, 3, '2024-06-18 19:43:43', '2024-06-18 20:54:23'),
(11, 2, 5, -2, '2024-06-18 19:43:43', '2024-06-18 20:54:23'),
(12, 2, 6, -3, '2024-06-18 19:43:43', '2024-06-18 20:26:09'),
(13, 2, 7, -2, '2024-06-18 19:43:43', '2024-06-18 20:26:09'),
(14, 3, 3, 1, '2024-06-18 19:43:43', '2024-06-18 19:43:43'),
(15, 3, 4, -3, '2024-06-18 19:43:43', '2024-06-18 20:54:23'),
(16, 3, 5, -3, '2024-06-18 19:43:44', '2024-06-18 20:54:23'),
(17, 3, 6, -7, '2024-06-18 19:43:44', '2024-06-18 20:26:09'),
(18, 3, 7, -5, '2024-06-18 19:43:44', '2024-06-18 19:43:44'),
(19, 4, 4, 1, '2024-06-18 19:43:44', '2024-06-18 19:43:44'),
(20, 4, 5, 2, '2024-06-18 19:43:44', '2024-06-18 19:43:44'),
(21, 4, 6, -5, '2024-06-18 19:43:44', '2024-06-18 19:43:44'),
(22, 4, 7, -3, '2024-06-18 19:43:44', '2024-06-18 20:26:52'),
(23, 5, 5, 1, '2024-06-18 19:43:44', '2024-06-18 19:43:44'),
(24, 5, 6, -3, '2024-06-18 19:43:44', '2024-06-18 20:54:23'),
(25, 5, 7, -7, '2024-06-18 19:43:44', '2024-06-18 20:26:37'),
(26, 6, 6, 1, '2024-06-18 19:43:44', '2024-06-18 19:43:44'),
(27, 6, 7, 2, '2024-06-18 19:43:44', '2024-06-18 20:26:28'),
(28, 7, 7, 1, '2024-06-18 19:43:44', '2024-06-18 19:43:44');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(13, '2014_10_12_000000_create_users_table', 1),
(14, '2014_10_12_100000_create_password_resets_table', 1),
(15, '2019_08_19_000000_create_failed_jobs_table', 1),
(16, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(17, '2023_02_25_132820_create_alternatif_table', 1),
(18, '2023_03_02_213457_create_kriteria_table', 1),
(19, '2023_03_05_182640_create_kriteria_banding_table', 1),
(20, '2023_03_08_212513_create_subkriteria_table', 1),
(21, '2023_03_09_181154_create_subkriteria_banding_table', 1),
(22, '2023_03_11_122618_create_nilai_table', 1),
(23, '2023_03_12_140602_create_hasil_table', 1),
(24, '2023_03_24_183443_create_sessions_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alternatif_id` bigint(20) UNSIGNED NOT NULL,
  `kriteria_id` bigint(20) UNSIGNED NOT NULL,
  `subkriteria_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id`, `alternatif_id`, `kriteria_id`, `subkriteria_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2024-07-04 07:44:57', '2024-07-04 07:44:57'),
(2, 1, 2, 5, '2024-07-04 07:44:57', '2024-07-04 07:44:57'),
(3, 1, 3, 11, '2024-07-04 07:44:57', '2024-07-04 07:44:57'),
(4, 1, 4, 15, '2024-07-04 07:44:57', '2024-07-04 07:44:57'),
(5, 1, 5, 18, '2024-07-04 07:44:57', '2024-07-04 07:44:57'),
(6, 1, 6, 24, '2024-07-04 07:44:57', '2024-07-04 07:44:57'),
(7, 1, 7, 27, '2024-07-04 07:44:57', '2024-07-04 07:44:57'),
(8, 2, 1, 1, '2024-07-04 07:45:11', '2024-07-04 07:45:11'),
(9, 2, 2, 6, '2024-07-04 07:45:11', '2024-07-04 07:45:11'),
(10, 2, 3, 9, '2024-07-04 07:45:11', '2024-07-04 07:45:11'),
(11, 2, 4, 16, '2024-07-04 07:45:12', '2024-07-04 07:45:12'),
(12, 2, 5, 18, '2024-07-04 07:45:12', '2024-07-04 07:45:12'),
(13, 2, 6, 23, '2024-07-04 07:45:12', '2024-07-04 07:45:12'),
(14, 2, 7, 28, '2024-07-04 07:45:12', '2024-07-04 07:45:12'),
(15, 3, 1, 2, '2024-07-04 07:45:28', '2024-07-04 07:45:28'),
(16, 3, 2, 5, '2024-07-04 07:45:28', '2024-07-04 07:45:28'),
(17, 3, 3, 10, '2024-07-04 07:45:28', '2024-07-04 07:45:28'),
(18, 3, 4, 16, '2024-07-04 07:45:28', '2024-07-04 07:45:28'),
(19, 3, 5, 19, '2024-07-04 07:45:28', '2024-07-04 07:45:28'),
(20, 3, 6, 22, '2024-07-04 07:45:28', '2024-07-04 07:45:28'),
(21, 3, 7, 28, '2024-07-04 07:45:28', '2024-07-04 07:45:28'),
(22, 4, 1, 2, '2024-07-04 07:45:49', '2024-07-04 07:45:49'),
(23, 4, 2, 6, '2024-07-04 07:45:49', '2024-07-04 07:45:49'),
(24, 4, 3, 11, '2024-07-04 07:45:49', '2024-07-04 07:45:49'),
(25, 4, 4, 15, '2024-07-04 07:45:49', '2024-07-04 07:45:49'),
(26, 4, 5, 18, '2024-07-04 07:45:49', '2024-07-04 07:45:49'),
(27, 4, 6, 24, '2024-07-04 07:45:49', '2024-07-04 07:45:49'),
(28, 4, 7, 27, '2024-07-04 07:45:49', '2024-07-04 07:45:49'),
(29, 5, 1, 1, '2024-07-04 07:46:06', '2024-07-04 07:46:06'),
(30, 5, 2, 5, '2024-07-04 07:46:06', '2024-07-04 07:46:06'),
(31, 5, 3, 10, '2024-07-04 07:46:06', '2024-07-04 07:46:06'),
(32, 5, 4, 15, '2024-07-04 07:46:06', '2024-07-04 07:46:06'),
(33, 5, 5, 18, '2024-07-04 07:46:06', '2024-07-04 07:46:06'),
(34, 5, 6, 24, '2024-07-04 07:46:06', '2024-07-04 07:46:06'),
(35, 5, 7, 27, '2024-07-04 07:46:06', '2024-07-04 07:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subkriteria`
--

CREATE TABLE `subkriteria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kriteria_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(99) NOT NULL COMMENT 'Nama sub kriteria',
  `bobot` double(8,5) NOT NULL DEFAULT 0.00000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subkriteria`
--

INSERT INTO `subkriteria` (`id`, `kriteria_id`, `name`, `bobot`, `created_at`, `updated_at`) VALUES
(1, 1, 'Closed house', 0.64862, '2024-06-18 20:57:52', '2024-06-18 21:05:20'),
(2, 1, 'Semiclosed house', 0.29464, '2024-06-18 20:58:12', '2024-06-18 20:59:20'),
(3, 1, 'Open house', 0.05674, '2024-06-18 20:58:26', '2024-06-18 20:59:20'),
(4, 2, '> 15000 ekor', 0.50282, '2024-06-18 21:00:01', '2024-06-18 21:03:25'),
(5, 2, '12001 – 15000 ekor', 0.26023, '2024-06-18 21:00:25', '2024-06-18 21:04:14'),
(6, 2, '9001 – 12000 ekor', 0.13435, '2024-06-18 21:00:55', '2024-06-18 21:03:25'),
(7, 2, '6000 – 9000 ekor', 0.06778, '2024-06-18 21:01:21', '2024-06-18 21:03:25'),
(8, 2, '< 5000 ekor', 0.03482, '2024-06-18 21:01:44', '2024-06-18 21:03:25'),
(9, 3, '>1401 m2', 0.50282, '2024-06-18 21:07:54', '2024-06-18 21:09:58'),
(10, 3, '1201 – 1400 m2', 0.26023, '2024-06-18 21:08:07', '2024-06-18 21:09:58'),
(11, 3, '1001 – 1200 m2', 0.13435, '2024-06-18 21:08:23', '2024-06-18 21:09:58'),
(12, 3, '801 – 1000 m2', 0.06778, '2024-06-18 21:08:43', '2024-06-18 21:09:58'),
(13, 3, '< 800 m2', 0.03482, '2024-06-18 21:08:57', '2024-06-18 21:09:58'),
(14, 4, 'sangat baik', 0.55789, '2024-07-04 07:34:38', '2024-07-04 07:41:36'),
(15, 4, 'baik', 0.26335, '2024-07-04 07:34:53', '2024-07-04 07:41:36'),
(16, 4, 'cukup baik', 0.12187, '2024-07-04 07:35:02', '2024-07-04 07:41:36'),
(17, 4, 'kurang baik', 0.05689, '2024-07-04 07:35:11', '2024-07-04 07:41:36'),
(18, 5, 'sangat baik', 0.55789, '2024-07-04 07:35:32', '2024-07-04 07:42:16'),
(19, 5, 'baik', 0.26335, '2024-07-04 07:35:41', '2024-07-04 07:42:16'),
(20, 5, 'cukup baik', 0.12187, '2024-07-04 07:35:48', '2024-07-04 07:42:16'),
(21, 5, 'kurang baik', 0.05689, '2024-07-04 07:35:57', '2024-07-04 07:42:16'),
(22, 6, 'sangat baik', 0.55789, '2024-07-04 07:36:07', '2024-07-04 07:42:46'),
(23, 6, 'baik', 0.26335, '2024-07-04 07:36:16', '2024-07-04 07:42:46'),
(24, 6, 'cukup baik', 0.12187, '2024-07-04 07:36:25', '2024-07-04 07:42:46'),
(25, 6, 'kurang baik', 0.05689, '2024-07-04 07:36:43', '2024-07-04 07:42:46'),
(26, 7, 'sangat baik', 0.55789, '2024-07-04 07:37:52', '2024-07-04 07:43:15'),
(27, 7, 'baik', 0.26335, '2024-07-04 07:37:59', '2024-07-04 07:43:15'),
(28, 7, 'cukup baik', 0.12187, '2024-07-04 07:38:07', '2024-07-04 07:43:15'),
(29, 7, 'kurang baik', 0.05689, '2024-07-04 07:38:35', '2024-07-04 07:43:15');

-- --------------------------------------------------------

--
-- Table structure for table `subkriteria_banding`
--

CREATE TABLE `subkriteria_banding` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idkriteria` bigint(20) UNSIGNED NOT NULL,
  `subkriteria1` bigint(20) UNSIGNED NOT NULL,
  `subkriteria2` bigint(20) UNSIGNED NOT NULL,
  `nilai` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subkriteria_banding`
--

INSERT INTO `subkriteria_banding` (`id`, `idkriteria`, `subkriteria1`, `subkriteria2`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '2024-06-18 20:59:20', '2024-06-18 20:59:20'),
(2, 1, 1, 2, 3, '2024-06-18 20:59:20', '2024-06-18 20:59:20'),
(3, 1, 1, 3, 9, '2024-06-18 20:59:20', '2024-06-18 20:59:20'),
(4, 1, 2, 2, 1, '2024-06-18 20:59:20', '2024-06-18 20:59:20'),
(5, 1, 2, 3, 7, '2024-06-18 20:59:20', '2024-06-18 20:59:20'),
(6, 1, 3, 3, 1, '2024-06-18 20:59:20', '2024-06-18 20:59:20'),
(7, 2, 4, 4, 1, '2024-06-18 21:03:25', '2024-06-18 21:03:25'),
(8, 2, 4, 5, 3, '2024-06-18 21:03:25', '2024-06-18 21:03:25'),
(9, 2, 4, 6, 5, '2024-06-18 21:03:25', '2024-06-18 21:03:25'),
(10, 2, 4, 7, 7, '2024-06-18 21:03:25', '2024-06-18 21:03:25'),
(11, 2, 4, 8, 9, '2024-06-18 21:03:25', '2024-06-18 21:03:25'),
(12, 2, 5, 5, 1, '2024-06-18 21:03:25', '2024-06-18 21:03:25'),
(13, 2, 5, 6, 3, '2024-06-18 21:03:25', '2024-06-18 21:03:25'),
(14, 2, 5, 7, 5, '2024-06-18 21:03:25', '2024-06-18 21:03:25'),
(15, 2, 5, 8, 7, '2024-06-18 21:03:25', '2024-06-18 21:03:25'),
(16, 2, 6, 6, 1, '2024-06-18 21:03:25', '2024-06-18 21:03:25'),
(17, 2, 6, 7, 3, '2024-06-18 21:03:25', '2024-06-18 21:03:25'),
(18, 2, 6, 8, 5, '2024-06-18 21:03:25', '2024-06-18 21:03:25'),
(19, 2, 7, 7, 1, '2024-06-18 21:03:25', '2024-06-18 21:03:25'),
(20, 2, 7, 8, 3, '2024-06-18 21:03:25', '2024-06-18 21:03:25'),
(21, 2, 8, 8, 1, '2024-06-18 21:03:25', '2024-06-18 21:03:25'),
(22, 3, 9, 9, 1, '2024-06-18 21:09:58', '2024-06-18 21:09:58'),
(23, 3, 9, 10, 3, '2024-06-18 21:09:58', '2024-06-18 21:09:58'),
(24, 3, 9, 11, 5, '2024-06-18 21:09:58', '2024-06-18 21:09:58'),
(25, 3, 9, 12, 7, '2024-06-18 21:09:58', '2024-06-18 21:09:58'),
(26, 3, 9, 13, 9, '2024-06-18 21:09:58', '2024-06-18 21:09:58'),
(27, 3, 10, 10, 1, '2024-06-18 21:09:58', '2024-06-18 21:09:58'),
(28, 3, 10, 11, 3, '2024-06-18 21:09:58', '2024-06-18 21:09:58'),
(29, 3, 10, 12, 5, '2024-06-18 21:09:58', '2024-06-18 21:09:58'),
(30, 3, 10, 13, 7, '2024-06-18 21:09:58', '2024-06-18 21:09:58'),
(31, 3, 11, 11, 1, '2024-06-18 21:09:58', '2024-06-18 21:09:58'),
(32, 3, 11, 12, 3, '2024-06-18 21:09:58', '2024-06-18 21:09:58'),
(33, 3, 11, 13, 5, '2024-06-18 21:09:58', '2024-06-18 21:09:58'),
(34, 3, 12, 12, 1, '2024-06-18 21:09:58', '2024-06-18 21:09:58'),
(35, 3, 12, 13, 3, '2024-06-18 21:09:58', '2024-06-18 21:09:58'),
(36, 3, 13, 13, 1, '2024-06-18 21:09:58', '2024-06-18 21:09:58'),
(37, 4, 14, 14, 1, '2024-07-04 07:41:35', '2024-07-04 07:41:35'),
(38, 4, 14, 15, 3, '2024-07-04 07:41:35', '2024-07-04 07:41:35'),
(39, 4, 14, 16, 5, '2024-07-04 07:41:35', '2024-07-04 07:41:35'),
(40, 4, 14, 17, 7, '2024-07-04 07:41:35', '2024-07-04 07:41:35'),
(41, 4, 15, 15, 1, '2024-07-04 07:41:35', '2024-07-04 07:41:35'),
(42, 4, 15, 16, 3, '2024-07-04 07:41:35', '2024-07-04 07:41:35'),
(43, 4, 15, 17, 5, '2024-07-04 07:41:35', '2024-07-04 07:41:35'),
(44, 4, 16, 16, 1, '2024-07-04 07:41:35', '2024-07-04 07:41:35'),
(45, 4, 16, 17, 3, '2024-07-04 07:41:35', '2024-07-04 07:41:35'),
(46, 4, 17, 17, 1, '2024-07-04 07:41:35', '2024-07-04 07:41:35'),
(47, 5, 18, 18, 1, '2024-07-04 07:42:16', '2024-07-04 07:42:16'),
(48, 5, 18, 19, 3, '2024-07-04 07:42:16', '2024-07-04 07:42:16'),
(49, 5, 18, 20, 5, '2024-07-04 07:42:16', '2024-07-04 07:42:16'),
(50, 5, 18, 21, 7, '2024-07-04 07:42:16', '2024-07-04 07:42:16'),
(51, 5, 19, 19, 1, '2024-07-04 07:42:16', '2024-07-04 07:42:16'),
(52, 5, 19, 20, 3, '2024-07-04 07:42:16', '2024-07-04 07:42:16'),
(53, 5, 19, 21, 5, '2024-07-04 07:42:16', '2024-07-04 07:42:16'),
(54, 5, 20, 20, 1, '2024-07-04 07:42:16', '2024-07-04 07:42:16'),
(55, 5, 20, 21, 3, '2024-07-04 07:42:16', '2024-07-04 07:42:16'),
(56, 5, 21, 21, 1, '2024-07-04 07:42:16', '2024-07-04 07:42:16'),
(57, 6, 22, 22, 1, '2024-07-04 07:42:45', '2024-07-04 07:42:45'),
(58, 6, 22, 23, 3, '2024-07-04 07:42:45', '2024-07-04 07:42:45'),
(59, 6, 22, 24, 5, '2024-07-04 07:42:45', '2024-07-04 07:42:45'),
(60, 6, 22, 25, 7, '2024-07-04 07:42:45', '2024-07-04 07:42:45'),
(61, 6, 23, 23, 1, '2024-07-04 07:42:45', '2024-07-04 07:42:45'),
(62, 6, 23, 24, 3, '2024-07-04 07:42:45', '2024-07-04 07:42:45'),
(63, 6, 23, 25, 5, '2024-07-04 07:42:45', '2024-07-04 07:42:45'),
(64, 6, 24, 24, 1, '2024-07-04 07:42:45', '2024-07-04 07:42:45'),
(65, 6, 24, 25, 3, '2024-07-04 07:42:45', '2024-07-04 07:42:45'),
(66, 6, 25, 25, 1, '2024-07-04 07:42:45', '2024-07-04 07:42:45'),
(67, 7, 26, 26, 1, '2024-07-04 07:43:15', '2024-07-04 07:43:15'),
(68, 7, 26, 27, 3, '2024-07-04 07:43:15', '2024-07-04 07:43:15'),
(69, 7, 26, 28, 5, '2024-07-04 07:43:15', '2024-07-04 07:43:15'),
(70, 7, 26, 29, 7, '2024-07-04 07:43:15', '2024-07-04 07:43:15'),
(71, 7, 27, 27, 1, '2024-07-04 07:43:15', '2024-07-04 07:43:15'),
(72, 7, 27, 28, 3, '2024-07-04 07:43:15', '2024-07-04 07:43:15'),
(73, 7, 27, 29, 5, '2024-07-04 07:43:15', '2024-07-04 07:43:15'),
(74, 7, 28, 28, 1, '2024-07-04 07:43:15', '2024-07-04 07:43:15'),
(75, 7, 28, 29, 3, '2024-07-04 07:43:15', '2024-07-04 07:43:15'),
(76, 7, 29, 29, 1, '2024-07-04 07:43:15', '2024-07-04 07:43:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin', 'employee') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`,`role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User Admin', 'admin@example.com', '2024-06-18 19:35:54', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin','mXVl7b4uOFtTsZG86lsEJ6WrYp3Ye9LYKEZ8dhQ7SXihFFZiWV4KUfKnMniF', '2024-06-18 19:35:54', '2024-06-18 19:35:54'),
(2, 'Test User Employee', 'employee@example.com', '2024-06-18 19:35:54', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employee', 'mXVl7b4uOFtTsZG86lsEJ6WrYp3Ye9LYKEZ8dhQ7SXihFFZiWV4KUfKnMniF', '2024-06-18 19:35:54', '2024-06-18 19:35:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hasil_alternatif_id_foreign` (`alternatif_id`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kriteria_banding`
--
ALTER TABLE `kriteria_banding`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kriteria_banding_kriteria1_foreign` (`kriteria1`),
  ADD KEY `kriteria_banding_kriteria2_foreign` (`kriteria2`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nilai_alternatif_id_foreign` (`alternatif_id`),
  ADD KEY `nilai_kriteria_id_foreign` (`kriteria_id`),
  ADD KEY `nilai_subkriteria_id_foreign` (`subkriteria_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subkriteria`
--
ALTER TABLE `subkriteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subkriteria_kriteria_id_foreign` (`kriteria_id`);

--
-- Indexes for table `subkriteria_banding`
--
ALTER TABLE `subkriteria_banding`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subkriteria_banding_idkriteria_foreign` (`idkriteria`),
  ADD KEY `subkriteria_banding_subkriteria1_foreign` (`subkriteria1`),
  ADD KEY `subkriteria_banding_subkriteria2_foreign` (`subkriteria2`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kriteria_banding`
--
ALTER TABLE `kriteria_banding`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subkriteria`
--
ALTER TABLE `subkriteria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `subkriteria_banding`
--
ALTER TABLE `subkriteria_banding`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil`
--
ALTER TABLE `hasil`
  ADD CONSTRAINT `hasil_alternatif_id_foreign` FOREIGN KEY (`alternatif_id`) REFERENCES `alternatif` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kriteria_banding`
--
ALTER TABLE `kriteria_banding`
  ADD CONSTRAINT `kriteria_banding_kriteria1_foreign` FOREIGN KEY (`kriteria1`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kriteria_banding_kriteria2_foreign` FOREIGN KEY (`kriteria2`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_alternatif_id_foreign` FOREIGN KEY (`alternatif_id`) REFERENCES `alternatif` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_subkriteria_id_foreign` FOREIGN KEY (`subkriteria_id`) REFERENCES `subkriteria` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subkriteria`
--
ALTER TABLE `subkriteria`
  ADD CONSTRAINT `subkriteria_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subkriteria_banding`
--
ALTER TABLE `subkriteria_banding`
  ADD CONSTRAINT `subkriteria_banding_idkriteria_foreign` FOREIGN KEY (`idkriteria`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subkriteria_banding_subkriteria1_foreign` FOREIGN KEY (`subkriteria1`) REFERENCES `subkriteria` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subkriteria_banding_subkriteria2_foreign` FOREIGN KEY (`subkriteria2`) REFERENCES `subkriteria` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
