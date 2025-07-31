-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2025 at 09:24 AM
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
-- Database: `db1_akuntansi`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `kode_cat` varchar(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `kode_cat`, `name`, `description`, `otoritas`, `nama_ky`, `batas_tanggal_sistem`, `mode_batas_tanggal`, `created_at`, `updated_at`, `deleted_at`, `recovered_at`) VALUES
(2, '', 'Mouse', '', 'F', NULL, NULL, NULL, '2025-07-07 06:44:40', '2025-07-31 15:16:59', '2025-07-07 07:08:19', NULL),
(3, 'LAPT', 'LAPTOP', '', 'F', NULL, NULL, NULL, '2025-07-07 07:11:24', '2025-07-31 15:17:03', NULL, NULL),
(4, '', 'Speaker', '', 'F', 'Genius Hartono', NULL, NULL, '2025-07-07 07:33:19', '2025-07-31 15:17:06', NULL, NULL),
(5, 'LACI', 'LACI', '', NULL, NULL, NULL, NULL, '2025-07-08 03:21:09', '2025-07-10 03:22:53', NULL, NULL),
(6, '', 'LEMARI', '', NULL, NULL, NULL, 'automatic', '2025-07-08 03:21:33', '2025-07-08 03:21:33', NULL, NULL),
(7, 'bat', 'baterai', '', NULL, NULL, NULL, 'automatic', '2025-07-09 07:24:10', '2025-07-09 07:24:10', NULL, NULL),
(8, 'MEJA', 'MEJA', '', NULL, NULL, NULL, 'automatic', '2025-07-10 03:22:39', '2025-07-10 03:22:39', NULL, NULL),
(9, 'GELA', 'GELAS', '', NULL, NULL, NULL, 'automatic', '2025-07-10 03:27:02', '2025-07-10 03:27:02', NULL, NULL),
(10, 'PRIN', 'PRINTER', '', NULL, NULL, NULL, 'automatic', '2025-07-10 03:31:30', '2025-07-10 03:31:30', NULL, NULL),
(11, 'PINT', 'PINTU', '', NULL, 'geni', NULL, 'automatic', '2025-07-10 03:36:22', '2025-07-10 03:36:22', NULL, NULL),
(12, 'LUKI', 'LUKISAN', '', NULL, 'geni', NULL, 'automatic', '2025-07-10 03:58:45', '2025-07-10 03:58:45', NULL, NULL),
(13, 'GALO', 'GALON', '', NULL, 'geni', NULL, 'automatic', '2025-07-10 03:59:38', '2025-07-10 03:59:38', NULL, NULL),
(14, 'MONI', 'MONITOR', '', NULL, 'Genius Hartono', NULL, 'automatic', '2025-07-12 21:36:28', '2025-07-12 21:51:24', NULL, NULL),
(15, 'TABL', 'TABLET', '', NULL, 'Genius Hartono', NULL, 'automatic', '2025-07-25 10:28:27', '2025-07-25 10:28:27', NULL, NULL),
(16, 'TAS', 'TAS', '', NULL, 'Genius Hartono', NULL, 'automatic', '2025-07-25 10:32:03', '2025-07-25 10:32:03', NULL, NULL),
(17, 'BUKU', 'BUKU', '', NULL, 'Genius Hartono', NULL, 'automatic', '2025-07-25 10:32:51', '2025-07-25 10:32:51', NULL, NULL),
(18, 'MOBI', 'MOBIL', '', NULL, 'Genius Hartono', NULL, 'automatic', '2025-07-25 10:33:20', '2025-07-25 10:33:20', NULL, NULL),
(19, 'TEKO', 'TEKO', '', NULL, 'Genius Hartono', NULL, 'automatic', '2025-07-25 11:02:24', '2025-07-25 11:02:24', NULL, NULL),
(20, 'HELM', 'HELM', '', NULL, 'Genius Hartono', NULL, 'automatic', '2025-07-26 15:35:46', '2025-07-26 15:35:46', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telepon` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daya`
--

CREATE TABLE `daya` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daya`
--

INSERT INTO `daya` (`id`, `name`, `description`, `otoritas`, `nama_ky`, `created_at`, `updated_at`, `deleted_at`, `recovered_at`, `batas_tanggal_sistem`, `mode_batas_tanggal`) VALUES
(1, '100W', '', NULL, NULL, '2025-07-10 01:04:20', '2025-07-10 01:04:20', NULL, NULL, NULL, 'automatic'),
(2, '200W', '', NULL, 'Genius Hartono', '2025-07-12 22:07:20', '2025-07-12 22:07:20', NULL, NULL, NULL, 'automatic'),
(3, '300W', '', NULL, 'Genius Hartono', '2025-07-12 23:03:02', '2025-07-12 23:03:02', NULL, NULL, NULL, 'automatic'),
(4, '250W', '', NULL, 'Genius Hartono', '2025-07-15 00:23:16', '2025-07-15 00:23:16', NULL, NULL, NULL, 'automatic'),
(5, '28ur8892r93hr3h4f3h4f3uh4f3434r34r', '', NULL, 'Genius Hartono', '2025-07-24 10:50:33', '2025-07-24 10:50:33', NULL, NULL, NULL, 'automatic'),
(6, 'fhewfhuewfh2u9hf29fh2938hf2398h29839823e982u39r823r923h9fuhu3fh92hf923h23r', '', NULL, 'Genius Hartono', '2025-07-24 10:50:51', '2025-07-24 10:50:51', NULL, NULL, NULL, 'automatic'),
(7, '700W', '', NULL, 'Genius Hartono', '2025-07-26 15:26:01', '2025-07-26 15:26:01', NULL, NULL, NULL, 'automatic');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `deleted_at`, `recovered_at`, `created_at`) VALUES
(1, 'POS', 'Point of Sales - Kasir', NULL, NULL, '2025-07-06'),
(2, 'Back Office', 'Akunting dan Administrasi', NULL, NULL, '2025-07-06'),
(3, 'General', 'Owner dan Management', NULL, NULL, '2025-07-06');

-- --------------------------------------------------------

--
-- Table structure for table `dimensi`
--

CREATE TABLE `dimensi` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dimensi`
--

INSERT INTO `dimensi` (`id`, `name`, `description`, `otoritas`, `nama_ky`, `created_at`, `updated_at`, `deleted_at`, `recovered_at`, `batas_tanggal_sistem`, `mode_batas_tanggal`) VALUES
(3, '10M', NULL, NULL, 'Genius Hartono', '2025-07-14 00:14:40', '2025-07-14 00:14:40', NULL, NULL, NULL, 'automatic'),
(6, '20M', NULL, NULL, 'Genius Hartono', '2025-07-14 00:27:38', '2025-07-14 00:27:38', NULL, NULL, NULL, 'automatic'),
(7, '30M', NULL, NULL, 'Genius Hartono', '2025-07-14 00:35:37', '2025-07-14 00:35:37', NULL, NULL, NULL, 'automatic'),
(8, '30M', NULL, NULL, 'Genius Hartono', '2025-07-14 00:37:10', '2025-07-14 00:37:10', NULL, NULL, NULL, 'automatic'),
(9, '30M', NULL, NULL, 'Genius Hartono', '2025-07-14 00:47:09', '2025-07-14 00:47:09', NULL, NULL, NULL, 'automatic'),
(10, '20M', NULL, NULL, 'Genius Hartono', '2025-07-15 00:23:31', '2025-07-15 00:23:31', NULL, NULL, NULL, 'automatic'),
(11, '300M', NULL, NULL, 'Genius Hartono', '2025-07-26 15:35:22', '2025-07-26 15:35:22', NULL, NULL, NULL, 'automatic');

-- --------------------------------------------------------

--
-- Table structure for table `fiting`
--

CREATE TABLE `fiting` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fiting`
--

INSERT INTO `fiting` (`id`, `name`, `description`, `otoritas`, `nama_ky`, `created_at`, `updated_at`, `deleted_at`, `recovered_at`, `batas_tanggal_sistem`, `mode_batas_tanggal`) VALUES
(1, 'KOTAK', NULL, NULL, 'Genius Hartono', '2025-07-15 00:24:25', '2025-07-15 00:24:25', NULL, NULL, NULL, 'automatic');

-- --------------------------------------------------------

--
-- Table structure for table `gondola`
--

CREATE TABLE `gondola` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gondola`
--

INSERT INTO `gondola` (`id`, `name`, `description`, `otoritas`, `nama_ky`, `created_at`, `updated_at`, `deleted_at`, `recovered_at`, `batas_tanggal_sistem`, `mode_batas_tanggal`) VALUES
(1, 'RAK A', NULL, NULL, 'Genius Hartono', '2025-07-14 01:02:35', '2025-07-14 01:02:35', NULL, NULL, NULL, 'automatic'),
(2, 'RAK B', NULL, NULL, 'Genius Hartono', '2025-07-15 00:25:08', '2025-07-15 00:25:08', NULL, NULL, NULL, 'automatic');

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id`, `name`, `description`, `otoritas`, `nama_ky`, `batas_tanggal_sistem`, `mode_batas_tanggal`, `created_at`, `updated_at`, `deleted_at`, `recovered_at`) VALUES
(1, '', NULL, NULL, 'Genius Hartono', NULL, 'automatic', '2025-07-15 00:25:26', '2025-07-15 00:25:26', NULL, NULL),
(2, 'SPEAKER AKTIF', NULL, NULL, 'Genius Hartono', NULL, 'automatic', '2025-07-15 00:28:49', '2025-07-15 00:28:49', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jumlah_mata`
--

CREATE TABLE `jumlah_mata` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jumlah_mata`
--

INSERT INTO `jumlah_mata` (`id`, `name`, `description`, `otoritas`, `nama_ky`, `created_at`, `updated_at`, `deleted_at`, `recovered_at`, `batas_tanggal_sistem`, `mode_batas_tanggal`) VALUES
(1, 'TIGA MATA', '', NULL, NULL, '2025-07-10 01:33:09', '2025-07-10 01:33:09', NULL, NULL, NULL, 'automatic'),
(3, 'DUA MATA', NULL, NULL, 'Genius Hartono', '2025-07-15 00:40:26', '2025-07-15 00:40:26', NULL, NULL, NULL, 'automatic');

-- --------------------------------------------------------

--
-- Table structure for table `kaki`
--

CREATE TABLE `kaki` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kaki`
--

INSERT INTO `kaki` (`id`, `name`, `description`, `otoritas`, `nama_ky`, `created_at`, `updated_at`, `deleted_at`, `recovered_at`, `batas_tanggal_sistem`, `mode_batas_tanggal`) VALUES
(2, 'KAKI TIGA', NULL, NULL, 'Genius Hartono', '2025-07-15 00:43:12', '2025-07-15 00:43:12', NULL, NULL, NULL, 'automatic'),
(3, 'KAKI EMPAT', NULL, NULL, 'Genius Hartono', '2025-07-15 09:33:03', '2025-07-15 09:33:03', NULL, NULL, NULL, 'automatic');

-- --------------------------------------------------------

--
-- Table structure for table `mastercustomer`
--

CREATE TABLE `mastercustomer` (
  `id` int(11) NOT NULL,
  `kode_customer` varchar(20) NOT NULL,
  `nama_customer` varchar(100) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `sales` varchar(100) DEFAULT NULL,
  `no_hp` varchar(30) DEFAULT NULL,
  `batas_piutang` decimal(18,2) DEFAULT 0.00,
  `npwp_nomor` varchar(50) DEFAULT NULL,
  `npwp_atas_nama` varchar(100) DEFAULT NULL,
  `npwp_alamat` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mastercustomer`
--

INSERT INTO `mastercustomer` (`id`, `kode_customer`, `nama_customer`, `alamat`, `contact_person`, `kota`, `provinsi`, `sales`, `no_hp`, `batas_piutang`, `npwp_nomor`, `npwp_atas_nama`, `npwp_alamat`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'TOYOTA', 'TOYOTA', 'Jl Gunung Sanghyang No 10', 'Genius Hartono', 'Badung', 'Bali', 'TONO - HARUN', '081906426886', 19902212.00, '232443455443233', 'TOYOTA', 'Jl Gunung Sanghyang No 10', '2025-07-16 16:06:27', '2025-07-25 13:54:42', NULL),
(2, 'DAIHATSU', 'DAIHATSU', 'Jl Gunung Sanghyang No 10', 'Genius Hartono', 'Badung', 'Bali', 'BONO - BONU', '081906426886', 1000000000.00, '235351268768656', 'DAIHATSU', 'Canggu', '2025-07-19 11:23:07', '2025-07-22 11:32:42', NULL),
(3, 'Jayfen', 'Jayfen Dashiell Glorious Liem', 'Jl Gunung Sanghyang No 10', 'Genius Hartono', 'Badung', 'Bali', 'BONO - BONU', '081906426886', 1000000000.00, '948759348759348', 'Jayfen', 'Canggu', '2025-07-25 13:10:03', '2025-07-25 13:53:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mastersales`
--

CREATE TABLE `mastersales` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `no_ktp` varchar(30) DEFAULT NULL,
  `status` enum('Menikah','Belum Menikah') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mastersales`
--

INSERT INTO `mastersales` (`id`, `kode`, `nama`, `alamat`, `tempat_lahir`, `no_hp`, `no_ktp`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'BONO', 'BONU', 'CANGGU', 'DPS', '0819292331312', '82124124128313', 'Menikah', '2025-07-16 07:21:56', '2025-07-16 07:24:09', NULL),
(5, 'CACA', 'COCO', 'DENPASAR', 'DPS', '01934928374982', '273473246238', 'Menikah', '2025-07-16 07:24:44', '2025-07-16 07:24:48', '2025-07-16 07:24:48'),
(6, 'TONO', 'HARUN', 'CANGGU', 'DENPASAR', '081263612361', '237486327468723234234243', 'Menikah', '2025-07-16 07:34:32', '2025-07-21 01:49:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `merk`
--

CREATE TABLE `merk` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merk`
--

INSERT INTO `merk` (`id`, `name`, `description`, `otoritas`, `nama_ky`, `created_at`, `updated_at`, `deleted_at`, `recovered_at`, `batas_tanggal_sistem`, `mode_batas_tanggal`) VALUES
(4, 'ASUS', NULL, NULL, 'Genius Hartono', '2025-07-15 09:56:40', '2025-07-15 09:56:40', NULL, NULL, NULL, 'automatic');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

CREATE TABLE `model` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `model`
--

INSERT INTO `model` (`id`, `name`, `description`, `otoritas`, `nama_ky`, `created_at`, `updated_at`, `deleted_at`, `recovered_at`) VALUES
(2, 'MODEL VINTAGE', NULL, NULL, 'Genius Hartono', '2025-07-15 10:06:48', '2025-07-15 10:06:48', NULL, NULL),
(3, 'MODEL MODERN', NULL, NULL, 'Genius Hartono', '2025-07-15 10:08:29', '2025-07-15 10:08:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pelengkap`
--

CREATE TABLE `pelengkap` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelengkap`
--

INSERT INTO `pelengkap` (`id`, `name`, `description`, `otoritas`, `nama_ky`, `created_at`, `updated_at`, `deleted_at`, `recovered_at`, `batas_tanggal_sistem`, `mode_batas_tanggal`) VALUES
(1, 'TUTUP', '', NULL, NULL, '2025-07-10 01:34:56', '2025-07-10 01:34:56', NULL, NULL, NULL, 'automatic'),
(4, 'BAUT', NULL, NULL, 'Genius Hartono', '2025-07-15 10:16:02', '2025-07-15 10:16:02', NULL, NULL, NULL, 'automatic');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `satuan_id` int(11) DEFAULT NULL,
  `jenis_id` int(11) DEFAULT NULL,
  `pelengkap_id` int(11) DEFAULT NULL,
  `gondola_id` int(11) DEFAULT NULL,
  `merk_id` int(11) DEFAULT NULL,
  `warna_sinar_id` int(11) DEFAULT NULL,
  `ukuran_barang_id` int(11) DEFAULT NULL,
  `voltase_id` int(11) DEFAULT NULL,
  `dimensi_id` int(11) DEFAULT NULL,
  `warna_body_id` int(11) DEFAULT NULL,
  `warna_bibir_id` int(11) DEFAULT NULL,
  `kaki_id` int(11) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `fiting_id` int(11) DEFAULT NULL,
  `daya_id` int(11) DEFAULT NULL,
  `jumlah_mata_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic',
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `satuan_id`, `jenis_id`, `pelengkap_id`, `gondola_id`, `merk_id`, `warna_sinar_id`, `ukuran_barang_id`, `voltase_id`, `dimensi_id`, `warna_body_id`, `warna_bibir_id`, `kaki_id`, `model_id`, `fiting_id`, `daya_id`, `jumlah_mata_id`, `name`, `price`, `stock`, `created_at`, `updated_at`, `deleted_at`, `recovered_at`, `batas_tanggal_sistem`, `mode_batas_tanggal`, `otoritas`, `nama_ky`) VALUES
(3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'LAPTOP Asus', 1242123.00, 12, '2025-07-10 05:42:42', '2025-07-22 11:38:27', '2025-07-22 03:38:27', NULL, NULL, 'automatic', NULL, 'Genius Hartono'),
(4, 3, 4, 2, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 2, 0, 'Laptop HP Pavilion wefhiweufhiwuefhiuwefiuwe', 32000333.00, 12, '2025-07-22 10:30:21', '2025-07-24 10:49:54', NULL, NULL, NULL, 'automatic', NULL, 'Genius Hartono'),
(5, 3, 4, 2, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, 1, 'LAPTOP HP PAVILION', 99999999.99, 12, '2025-07-22 11:10:55', '2025-07-22 11:10:55', NULL, NULL, NULL, 'automatic', NULL, NULL),
(6, 3, 4, 2, 1, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 'Notebook Asus', 12678456345.00, 12, '2025-07-22 12:22:14', '2025-07-22 12:22:14', NULL, NULL, NULL, 'automatic', NULL, 'Genius Hartono');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `nomor_nota` varchar(32) NOT NULL,
  `tanggal_nota` date NOT NULL,
  `customer` varchar(100) DEFAULT NULL,
  `sales` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'draft',
  `total` decimal(18,2) NOT NULL,
  `discount` decimal(18,2) DEFAULT 0.00,
  `tax` decimal(18,2) DEFAULT 0.00,
  `grand_total` decimal(18,2) NOT NULL,
  `nama_ky` varchar(100) DEFAULT NULL,
  `payment_a` decimal(18,2) DEFAULT 0.00,
  `payment_b` decimal(18,2) DEFAULT 0.00,
  `account_receivable` decimal(18,2) DEFAULT 0.00,
  `payment_system` varchar(50) DEFAULT NULL,
  `otoritas` char(1) DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'manual',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `nomor_nota`, `tanggal_nota`, `customer`, `sales`, `status`, `total`, `discount`, `tax`, `grand_total`, `nama_ky`, `payment_a`, `payment_b`, `account_receivable`, `payment_system`, `otoritas`, `batas_tanggal_sistem`, `mode_batas_tanggal`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'INV-20250716-A2DA7', '2025-07-16', 'dsfsd', 'sddsd', 'draft', 0.00, 0.00, 0.00, 0.00, NULL, 0.00, 0.00, 0.00, NULL, NULL, NULL, 'manual', '2025-07-16 13:49:24', '2025-07-21 14:12:16', '2025-07-21 06:12:16'),
(4, 'INV-20250721-230CE', '2025-07-21', 'DAIHATSU - DAIHATSU', 'TONO - HARUN', 'draft', 0.00, 0.00, 0.00, 0.00, NULL, 0.00, 0.00, 0.00, NULL, NULL, NULL, 'manual', '2025-07-21 11:29:26', NULL, NULL),
(5, 'INV-20250721-FEF5E', '2025-07-21', 'DAIHATSU - DAIHATSU', 'TONO - HARUN', 'draft', 0.00, 0.00, 0.00, 0.00, NULL, 0.00, 0.00, 0.00, NULL, NULL, NULL, 'manual', '2025-07-21 12:50:23', NULL, NULL),
(6, 'INV-20250721-5E009', '2025-07-21', 'DAIHATSU - DAIHATSU', 'TONO - HARUN', 'draft', 0.00, 0.00, 0.00, 0.00, 'Genius Hartono', 0.00, 0.00, 0.00, NULL, NULL, NULL, 'manual', '2025-07-21 12:55:48', NULL, NULL),
(7, 'INV-20250721-4A344', '2025-07-21', 'DAIHATSU - DAIHATSU', 'BONO - BONU', 'draft', 0.00, 0.00, 0.00, 0.00, 'Genius Hartono', 0.00, 0.00, 0.00, NULL, NULL, NULL, 'manual', '2025-07-21 14:23:08', NULL, NULL),
(8, 'INV-20250729-43BCA', '2025-07-11', 'Jayfen - Jayfen Dashiell Glorious Liem', 'TONO - HARUN', 'draft', 0.00, 0.00, 0.00, 0.00, 'Genius Hartono', 0.00, 0.00, 0.00, NULL, NULL, NULL, 'manual', '2025-07-29 15:16:43', NULL, NULL),
(9, 'INV-20250729-1AC7E', '2025-07-29', 'TOYOTA - TOYOTA', 'BONO - BONU', 'draft', 0.00, 0.00, 0.00, 0.00, 'Genius Hartono', 0.00, 0.00, 0.00, NULL, NULL, NULL, 'manual', '2025-07-29 16:12:50', '2025-07-29 16:16:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_items`
--

CREATE TABLE `sales_items` (
  `id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `qty` decimal(10,2) NOT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `price` decimal(18,2) NOT NULL,
  `discount` decimal(18,2) DEFAULT 0.00,
  `total` decimal(18,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id`, `name`, `description`, `otoritas`, `nama_ky`, `batas_tanggal_sistem`, `mode_batas_tanggal`, `created_at`, `updated_at`, `deleted_at`, `recovered_at`) VALUES
(1, 'cms', '', NULL, NULL, NULL, 'automatic', '2025-07-08 01:42:42', '2025-07-08 04:02:02', '2025-07-08 04:02:02', NULL),
(2, 'cm', '', NULL, NULL, NULL, 'automatic', '2025-07-08 04:02:25', '2025-07-08 04:02:25', NULL, NULL),
(3, 'kg', '', NULL, NULL, NULL, 'automatic', '2025-07-08 04:02:33', '2025-07-08 04:02:33', NULL, NULL),
(4, 'pcs', '', NULL, 'geni', NULL, 'automatic', '2025-07-10 04:54:01', '2025-07-10 04:54:01', NULL, NULL),
(5, 'gram', NULL, NULL, 'Genius Hartono', NULL, 'automatic', '2025-07-15 10:16:18', '2025-07-15 10:16:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_date_limits`
--

CREATE TABLE `system_date_limits` (
  `id` int(11) NOT NULL,
  `menu` varchar(50) NOT NULL,
  `batas_tanggal` date NOT NULL,
  `mode_batas_tanggal` varchar(20) NOT NULL DEFAULT 'manual',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_date_limits`
--

INSERT INTO `system_date_limits` (`id`, `menu`, `batas_tanggal`, `mode_batas_tanggal`, `created_at`, `updated_at`) VALUES
(10, 'penjualan', '2025-07-10', 'manual', '2025-07-08 08:32:28', '2025-07-29 14:40:38');

-- --------------------------------------------------------

--
-- Table structure for table `ukuran_barang`
--

CREATE TABLE `ukuran_barang` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ukuran_barang`
--

INSERT INTO `ukuran_barang` (`id`, `name`, `description`, `otoritas`, `nama_ky`, `created_at`, `updated_at`, `deleted_at`, `recovered_at`, `batas_tanggal_sistem`, `mode_batas_tanggal`) VALUES
(1, '30L', NULL, NULL, 'Genius Hartono', '2025-07-15 10:16:59', '2025-07-15 10:16:59', NULL, NULL, NULL, 'automatic');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `noktp` varchar(40) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `otoritas` char(1) DEFAULT 'T',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `alamat`, `noktp`, `deleted_at`, `recovered_at`, `otoritas`, `created_at`, `updated_at`) VALUES
(234, 'delby', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'delby', NULL, '', '2025-07-07 05:46:54', '2025-07-07 05:46:46', 'T', '2025-07-05 14:20:16', '2025-07-07 05:46:54'),
(909, 'geni1819', '$2y$10$yCVdmEq9i2kd62zm98/6X.I/ichcTL/s/ePbIL4zNAHrUJ9Sm6tOK', 'Genius Hartono', 'canggu', '32534535434534', NULL, NULL, NULL, '2025-07-05 14:20:16', '2025-07-12 19:14:47'),
(910, 'test1819', 'Genius1819', 'test', 'Canggu', '9727312873218312', '2025-07-07 04:29:52', NULL, 'T', '2025-07-05 14:34:12', '2025-07-07 04:29:52'),
(911, 'yono1819', '$2y$10$gRiHXmoawoyrbXpCeWcR.ObcuEAkH/TgbSy3IdxEYKl5xIIYzNrwu', 'yono', 'buduk', '', '2025-07-12 08:22:00', NULL, NULL, '2025-07-09 03:34:37', '2025-07-12 16:22:00'),
(912, 'budi123', '$2y$10$kXkZA9UcGmuATZjoX5RpZuh6PO3xz/zyg3YuFJ/A4HaWfnzwUCKUG', 'budi', 'canggu', '', '2025-07-12 08:22:08', '2025-07-09 03:47:36', NULL, '2025-07-09 03:37:25', '2025-07-12 16:22:08'),
(913, 'budis123', '$2y$10$y7HuCFphwIK.9mgwzLqSNOy0.CJCy2PzmEiPT9TvVVR/ny7s/Ja4y', 'budis', 'canggu', '', '2025-07-12 08:27:59', '2025-07-09 03:47:34', NULL, '2025-07-09 03:40:16', '2025-07-12 16:27:59'),
(914, 'tono123', '$2y$10$JNP1mOPI1U.ZlA.HRXHOQOYfpHla3/n2OEWRlDHczcnbt47ouzruG', 'tono', 'sfewfwe', '', '2025-07-12 08:27:56', NULL, NULL, '2025-07-09 03:42:13', '2025-07-12 16:27:56'),
(918, 'babi1819', '$2y$10$x9hUob.AJi82gLlO6ghRfeURyawWXWpoVCT5j6OLDqi50wmqojq6.', 'babi', 'canggu', '42372397843928742', '2025-07-12 06:43:31', NULL, NULL, '2025-07-12 14:38:01', '2025-07-12 14:43:31'),
(919, 'babi1819', '$2y$10$tiXdrlRlGa5bxJNOiESQTeLSvSWOPbXjHBn1hEMNY6gmDsPJtCOcm', 'babi', 'canggu', '42372397843928742', '2025-07-12 06:43:31', NULL, NULL, '2025-07-12 14:38:02', '2025-07-12 14:49:45'),
(920, 'test123', '$2y$10$.HqjCYLqGA87L7w6AkxUPOGY5xPtjGg.GvZw5U4Z6KRyaTYNuKMA2', 'Testing', 'canggu', '23949328492834', NULL, NULL, NULL, '2025-07-12 14:48:00', '2025-07-12 19:15:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_departments`
--

CREATE TABLE `user_departments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_departments`
--

INSERT INTO `user_departments` (`id`, `user_id`, `department_id`, `deleted_at`) VALUES
(7, 920, 1, '2025-07-12 08:04:39'),
(8, 920, 2, '2025-07-12 08:04:39'),
(9, 920, 3, '2025-07-12 08:04:39'),
(10, 909, 1, NULL),
(11, 909, 2, '2025-07-12 08:21:48'),
(12, 909, 3, NULL),
(13, 920, 1, NULL),
(14, 920, 2, NULL),
(15, 920, 3, NULL),
(16, 909, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `voltase`
--

CREATE TABLE `voltase` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voltase`
--

INSERT INTO `voltase` (`id`, `name`, `description`, `otoritas`, `nama_ky`, `created_at`, `updated_at`, `deleted_at`, `recovered_at`, `batas_tanggal_sistem`, `mode_batas_tanggal`) VALUES
(1, '10V', NULL, NULL, 'Genius Hartono', '2025-07-15 10:17:12', '2025-07-15 10:17:12', NULL, NULL, NULL, 'automatic');

-- --------------------------------------------------------

--
-- Table structure for table `warna_bibir`
--

CREATE TABLE `warna_bibir` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warna_body`
--

CREATE TABLE `warna_body` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warna_sinar`
--

CREATE TABLE `warna_sinar` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `otoritas` varchar(100) DEFAULT NULL,
  `nama_ky` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `recovered_at` datetime DEFAULT NULL,
  `batas_tanggal_sistem` date DEFAULT NULL,
  `mode_batas_tanggal` varchar(20) DEFAULT 'automatic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daya`
--
ALTER TABLE `daya`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dimensi`
--
ALTER TABLE `dimensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fiting`
--
ALTER TABLE `fiting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gondola`
--
ALTER TABLE `gondola`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jumlah_mata`
--
ALTER TABLE `jumlah_mata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kaki`
--
ALTER TABLE `kaki`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mastercustomer`
--
ALTER TABLE `mastercustomer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_customer` (`kode_customer`);

--
-- Indexes for table `mastersales`
--
ALTER TABLE `mastersales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `merk`
--
ALTER TABLE `merk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelengkap`
--
ALTER TABLE `pelengkap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_items`
--
ALTER TABLE `sales_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_id` (`sales_id`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_date_limits`
--
ALTER TABLE `system_date_limits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_menu` (`menu`);

--
-- Indexes for table `ukuran_barang`
--
ALTER TABLE `ukuran_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_departments`
--
ALTER TABLE `user_departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `voltase`
--
ALTER TABLE `voltase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warna_bibir`
--
ALTER TABLE `warna_bibir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warna_body`
--
ALTER TABLE `warna_body`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warna_sinar`
--
ALTER TABLE `warna_sinar`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daya`
--
ALTER TABLE `daya`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dimensi`
--
ALTER TABLE `dimensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `fiting`
--
ALTER TABLE `fiting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gondola`
--
ALTER TABLE `gondola`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jumlah_mata`
--
ALTER TABLE `jumlah_mata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kaki`
--
ALTER TABLE `kaki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mastercustomer`
--
ALTER TABLE `mastercustomer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mastersales`
--
ALTER TABLE `mastersales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `merk`
--
ALTER TABLE `merk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `model`
--
ALTER TABLE `model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pelengkap`
--
ALTER TABLE `pelengkap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sales_items`
--
ALTER TABLE `sales_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `system_date_limits`
--
ALTER TABLE `system_date_limits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ukuran_barang`
--
ALTER TABLE `ukuran_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=921;

--
-- AUTO_INCREMENT for table `user_departments`
--
ALTER TABLE `user_departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `voltase`
--
ALTER TABLE `voltase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `warna_bibir`
--
ALTER TABLE `warna_bibir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warna_body`
--
ALTER TABLE `warna_body`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warna_sinar`
--
ALTER TABLE `warna_sinar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_items`
--
ALTER TABLE `sales_items`
  ADD CONSTRAINT `sales_items_ibfk_1` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`id`);

--
-- Constraints for table `user_departments`
--
ALTER TABLE `user_departments`
  ADD CONSTRAINT `user_departments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_departments_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
