-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for pmd_profile
CREATE DATABASE IF NOT EXISTS `pmd_profile` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `pmd_profile`;

-- Dumping structure for table pmd_profile.activity_logs
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `properties` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `activity_logs_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `activity_logs_action_index` (`action`),
  KEY `activity_logs_created_at_index` (`created_at`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.activity_logs: ~1 rows (approximately)
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `model_type`, `model_id`, `ip_address`, `user_agent`, `properties`, `created_at`) VALUES
	(1, NULL, 'created', 'membuat user "Audent Kent"', 'App\\Models\\User', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '[]', '2025-11-17 19:46:42'),
	(3, 2, 'created', 'membuat dokumen "Section 1.10.32 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC"', 'App\\Models\\Document', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '[]', '2025-11-17 20:27:10'),
	(4, 2, 'created', 'membuat hero/slider "ini adalah judul"', 'App\\Models\\Hero', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '[]', '2025-11-17 20:36:28'),
	(7, 2, 'created', 'membuat user "Admin PMD Katingan"', 'App\\Models\\User', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '[]', '2025-11-17 20:54:05'),
	(8, 2, 'created', 'membuat berita "Test Berita API"', 'App\\Models\\News', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.6899', '[]', '2025-11-17 21:09:51');

-- Dumping structure for table pmd_profile.agendas
CREATE TABLE IF NOT EXISTS `agendas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','scheduled','ongoing','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order_position` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agendas_user_id_foreign` (`user_id`),
  KEY `agendas_status_start_date_index` (`status`,`start_date`),
  KEY `agendas_is_active_start_date_index` (`is_active`,`start_date`),
  KEY `agendas_order_position_index` (`order_position`),
  CONSTRAINT `agendas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.agendas: ~0 rows (approximately)

-- Dumping structure for table pmd_profile.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.cache: ~0 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1763439032),
	('5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1763439032;', 1763439032),
	('da4b9237bacccdf19c0760cab7aec4a8359010b0', 'i:1;', 1763439051),
	('da4b9237bacccdf19c0760cab7aec4a8359010b0:timer', 'i:1763439051;', 1763439051),
	('footer_contact', 'O:18:"App\\Models\\Contact":30:{s:13:"\0*\0connection";s:5:"mysql";s:8:"\0*\0table";s:8:"contacts";s:13:"\0*\0primaryKey";s:2:"id";s:10:"\0*\0keyType";s:3:"int";s:12:"incrementing";b:1;s:7:"\0*\0with";a:0:{}s:12:"\0*\0withCount";a:0:{}s:19:"preventsLazyLoading";b:0;s:10:"\0*\0perPage";i:15;s:6:"exists";b:1;s:18:"wasRecentlyCreated";b:0;s:28:"\0*\0escapeWhenCastingToString";b:0;s:13:"\0*\0attributes";a:15:{s:2:"id";i:1;s:5:"email";s:27:"setbpmdeskatingan@gmail.com";s:5:"phone";N;s:8:"whatsapp";N;s:8:"facebook";s:55:"https://www.facebook.com/profile.php?id=61552613027312#";s:9:"instagram";s:40:"https://www.instagram.com/dpmd_katingan/";s:7:"twitter";N;s:7:"youtube";N;s:7:"address";s:106:"Jl.A. Yani Kereng Humbang, Kasongan Lama, Kec. Katingan Hilir, Kabupaten Katingan, Kalimantan Tengah 74413";s:17:"google_maps_embed";s:477:"<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.697201933883!2d113.3966698!3d-1.8683695000000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dfce246471d67bb%3A0xf2db9a410b98a678!2sDinas%20Pemberdayaan%20Masyarakat%20Dan%20Pemerintahan%20Desa%20Kabupaten%20Katingan!5e0!3m2!1sid!2sid!4v1763438167657!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>";s:17:"office_hours_open";s:5:"07:00";s:18:"office_hours_close";s:5:"16:00";s:11:"office_days";s:13:"Senin - Jumat";s:10:"created_at";s:19:"2025-11-18 03:56:35";s:10:"updated_at";s:19:"2025-11-18 03:56:35";}s:11:"\0*\0original";a:15:{s:2:"id";i:1;s:5:"email";s:27:"setbpmdeskatingan@gmail.com";s:5:"phone";N;s:8:"whatsapp";N;s:8:"facebook";s:55:"https://www.facebook.com/profile.php?id=61552613027312#";s:9:"instagram";s:40:"https://www.instagram.com/dpmd_katingan/";s:7:"twitter";N;s:7:"youtube";N;s:7:"address";s:106:"Jl.A. Yani Kereng Humbang, Kasongan Lama, Kec. Katingan Hilir, Kabupaten Katingan, Kalimantan Tengah 74413";s:17:"google_maps_embed";s:477:"<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.697201933883!2d113.3966698!3d-1.8683695000000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dfce246471d67bb%3A0xf2db9a410b98a678!2sDinas%20Pemberdayaan%20Masyarakat%20Dan%20Pemerintahan%20Desa%20Kabupaten%20Katingan!5e0!3m2!1sid!2sid!4v1763438167657!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>";s:17:"office_hours_open";s:5:"07:00";s:18:"office_hours_close";s:5:"16:00";s:11:"office_days";s:13:"Senin - Jumat";s:10:"created_at";s:19:"2025-11-18 03:56:35";s:10:"updated_at";s:19:"2025-11-18 03:56:35";}s:10:"\0*\0changes";a:0:{}s:8:"\0*\0casts";a:0:{}s:17:"\0*\0classCastCache";a:0:{}s:21:"\0*\0attributeCastCache";a:0:{}s:13:"\0*\0dateFormat";N;s:10:"\0*\0appends";a:0:{}s:19:"\0*\0dispatchesEvents";a:0:{}s:14:"\0*\0observables";a:0:{}s:12:"\0*\0relations";a:0:{}s:10:"\0*\0touches";a:0:{}s:10:"timestamps";b:1;s:13:"usesUniqueIds";b:0;s:9:"\0*\0hidden";a:0:{}s:10:"\0*\0visible";a:0:{}s:11:"\0*\0fillable";a:12:{i:0;s:5:"email";i:1;s:5:"phone";i:2;s:8:"whatsapp";i:3;s:8:"facebook";i:4;s:9:"instagram";i:5;s:7:"twitter";i:6;s:7:"youtube";i:7;s:7:"address";i:8;s:17:"google_maps_embed";i:9;s:17:"office_hours_open";i:10;s:18:"office_hours_close";i:11;s:11:"office_days";}s:10:"\0*\0guarded";a:1:{i:0;s:1:"*";}}', 1763442367);

-- Dumping structure for table pmd_profile.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.cache_locks: ~0 rows (approximately)

-- Dumping structure for table pmd_profile.contacts
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_maps_embed` text COLLATE utf8mb4_unicode_ci,
  `office_hours_open` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_hours_close` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `office_days` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Senin - Jumat',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.contacts: ~0 rows (approximately)
INSERT INTO `contacts` (`id`, `email`, `phone`, `whatsapp`, `facebook`, `instagram`, `twitter`, `youtube`, `address`, `google_maps_embed`, `office_hours_open`, `office_hours_close`, `office_days`, `created_at`, `updated_at`) VALUES
	(1, 'setbpmdeskatingan@gmail.com', NULL, NULL, 'https://www.facebook.com/profile.php?id=61552613027312#', 'https://www.instagram.com/dpmd_katingan/', NULL, NULL, 'Jl.A. Yani Kereng Humbang, Kasongan Lama, Kec. Katingan Hilir, Kabupaten Katingan, Kalimantan Tengah 74413', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.697201933883!2d113.3966698!3d-1.8683695000000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dfce246471d67bb%3A0xf2db9a410b98a678!2sDinas%20Pemberdayaan%20Masyarakat%20Dan%20Pemerintahan%20Desa%20Kabupaten%20Katingan!5e0!3m2!1sid!2sid!4v1763438167657!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>', '07:00', '16:00', 'Senin - Jumat', '2025-11-17 20:56:35', '2025-11-17 20:56:35');

-- Dumping structure for table pmd_profile.documents
CREATE TABLE IF NOT EXISTS `documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int NOT NULL,
  `download_count` int NOT NULL DEFAULT '0',
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `documents_slug_unique` (`slug`),
  KEY `documents_user_id_foreign` (`user_id`),
  CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.documents: ~0 rows (approximately)
INSERT INTO `documents` (`id`, `title`, `slug`, `description`, `file_path`, `file_name`, `file_type`, `file_size`, `download_count`, `category`, `user_id`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Section 1.10.32 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC', 'section-11032-of-de-finibus-bonorum-et-malorum-written-by-cicero-in-45-bc', '"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"', 'documents/1763436429_Gemini Certified Educator.pdf', 'Gemini Certified Educator.pdf', 'pdf', 461787, 0, 'Sertifikat', 2, 1, '2025-11-17 20:27:10', '2025-11-17 20:27:10');

-- Dumping structure for table pmd_profile.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table pmd_profile.galleries
CREATE TABLE IF NOT EXISTS `galleries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `galleries_user_id_foreign` (`user_id`),
  CONSTRAINT `galleries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.galleries: ~0 rows (approximately)

-- Dumping structure for table pmd_profile.heroes
CREATE TABLE IF NOT EXISTS `heroes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `show_title` tinyint(1) NOT NULL DEFAULT '1',
  `order_position` int NOT NULL DEFAULT '0',
  `button1_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button1_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button1_style` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'primary',
  `button2_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button2_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button2_style` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'secondary',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `heroes_user_id_foreign` (`user_id`),
  CONSTRAINT `heroes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.heroes: ~0 rows (approximately)
INSERT INTO `heroes` (`id`, `title`, `description`, `image`, `is_active`, `show_title`, `order_position`, `button1_text`, `button1_url`, `button1_style`, `button2_text`, `button2_url`, `button2_style`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'ini adalah judul', NULL, 'heroes/1763436988_ini-adalah-judul.jpg', 1, 0, 1, NULL, NULL, 'primary', NULL, NULL, 'secondary', 2, '2025-11-17 20:36:28', '2025-11-17 20:36:28');

-- Dumping structure for table pmd_profile.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.jobs: ~0 rows (approximately)

-- Dumping structure for table pmd_profile.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.job_batches: ~0 rows (approximately)

-- Dumping structure for table pmd_profile.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.messages: ~0 rows (approximately)

-- Dumping structure for table pmd_profile.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.migrations: ~19 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_10_07_013240_create_news_table', 1),
	(5, '2025_10_07_023515_create_heroes_table', 1),
	(6, '2025_10_07_034433_create_agendas_table', 1),
	(7, '2025_10_07_075125_modify_agendas_table_make_start_time_nullable', 1),
	(8, '2025_10_08_074630_create_organization_structures_table', 1),
	(9, '2025_10_08_075906_add_photo_to_organization_structures_table', 1),
	(10, '2025_10_24_015649_create_galleries_table', 1),
	(11, '2025_10_24_021229_create_documents_table', 1),
	(12, '2025_10_24_025515_create_vision_missions_table', 1),
	(13, '2025_10_30_023657_create_contacts_table', 1),
	(14, '2025_10_30_023710_create_messages_table', 1),
	(15, '2025_11_03_020154_create_welcome_messages_table', 1),
	(16, '2025_11_03_023537_add_role_to_users_table', 1),
	(17, '2025_11_03_024120_update_existing_user_to_super_admin', 1),
	(18, '2025_11_13_022452_remove_unique_constraint_from_organization_structures_order', 1),
	(19, '2025_11_13_033319_create_personal_access_tokens_table', 1),
	(20, '2025_11_18_000001_create_activity_log_table', 1),
	(21, '2025_11_18_023323_create_activity_logs_table', 2),
	(22, '2025_11_18_025613_drop_activity_log_table', 3);

-- Dumping structure for table pmd_profile.news
CREATE TABLE IF NOT EXISTS `news` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_slug_unique` (`slug`),
  KEY `news_user_id_foreign` (`user_id`),
  CONSTRAINT `news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.news: ~0 rows (approximately)
INSERT INTO `news` (`id`, `title`, `slug`, `content`, `excerpt`, `image`, `user_id`, `is_published`, `published_at`, `created_at`, `updated_at`) VALUES
	(1, 'Test Berita API', 'test-berita-api', 'Ini adalah konten test dari API', 'Ini adalah konten test dari API', NULL, 2, 1, '2025-11-17 21:09:51', '2025-11-17 21:09:51', '2025-11-17 21:09:51');

-- Dumping structure for table pmd_profile.organization_structures
CREATE TABLE IF NOT EXISTS `organization_structures` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organization_structures_nip_unique` (`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.organization_structures: ~0 rows (approximately)

-- Dumping structure for table pmd_profile.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table pmd_profile.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.personal_access_tokens: ~0 rows (approximately)
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
	(1, 'App\\Models\\User', 2, 'Swagger UI', 'ba49cf82aa55f0fcb28d1ea4d27253caa3ba260731aaffb3605da19519432720', '["*"]', '2025-11-17 21:05:51', NULL, '2025-11-17 20:59:14', '2025-11-17 21:05:51'),
	(2, 'App\\Models\\User', 2, 'API Token', 'af2ece1ac76195ca3b4e1cc43a0b649c33164d40713a487ba6ced32a54f3b7c4', '["*"]', '2025-11-17 21:09:51', NULL, '2025-11-17 21:09:32', '2025-11-17 21:09:51');

-- Dumping structure for table pmd_profile.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('LcEhWP8X4ZzyXZnfSdqqKubGgCAnTgimcC6YOdQG', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiWXdtOEEzM0JOTnZaSU42Z21qWmVTMGlMMHAzeWVudVdubm5ZZkpHaCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vbmV3cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoxNDoiY2FwdGNoYV9hbnN3ZXIiO2k6MTY7fQ==', 1763439884);

-- Dumping structure for table pmd_profile.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('super-admin','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `role`, `is_active`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(2, 'Audent Kent', 'audentkent@gmail.com', 'super-admin', 1, NULL, '$2y$12$d4YNv9IA1jdbThEt04BQoe2H9qGLnk3wDmKP3I7lCx7SN2S7I8BFi', NULL, '2025-11-17 19:46:42', '2025-11-17 19:46:42'),
	(4, 'Admin PMD Katingan', 'setbpmdeskatingan@gmail.com', 'super-admin', 1, NULL, '$2y$12$EHtA83LjWTrqgFJw7SDH/.pg/JTGR4qAC03NmH4ns69rsUH/D5jYq', NULL, '2025-11-17 20:54:05', '2025-11-17 20:54:05');

-- Dumping structure for table pmd_profile.vision_missions
CREATE TABLE IF NOT EXISTS `vision_missions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vision` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mission` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vision_missions_user_id_foreign` (`user_id`),
  CONSTRAINT `vision_missions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.vision_missions: ~0 rows (approximately)

-- Dumping structure for table pmd_profile.welcome_messages
CREATE TABLE IF NOT EXISTS `welcome_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pmd_profile.welcome_messages: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
