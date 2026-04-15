-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 14, 2026 at 10:09 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `odod`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured_video` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery` json DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_breaking` tinyint(1) NOT NULL DEFAULT '0',
  `is_trending` tinyint(1) NOT NULL DEFAULT '0',
  `views_count` bigint UNSIGNED NOT NULL DEFAULT '0',
  `reading_time` smallint UNSIGNED DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `meta` json DEFAULT NULL,
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8mb4_unicode_ci,
  `source_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`),
  KEY `articles_category_id_foreign` (`category_id`),
  KEY `articles_author_id_foreign` (`author_id`),
  KEY `articles_status_published_at_index` (`status`,`published_at`),
  KEY `articles_is_featured_index` (`is_featured`),
  KEY `articles_is_trending_index` (`is_trending`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `slug`, `excerpt`, `body`, `featured_image`, `featured_video`, `gallery`, `category_id`, `author_id`, `status`, `is_featured`, `is_breaking`, `is_trending`, `views_count`, `reading_time`, `published_at`, `meta`, `seo_title`, `seo_description`, `source_name`, `source_url`, `created_at`, `updated_at`) VALUES
(1, 'Монгол Улсын эдийн засаг 2026 онд 6.2 хувиар өсөх төлөвтэй', 'mongol-ulsyn-ediin-zasag-2026-ond-62-xuviar-osox-tolovtei', 'Дэлхийн банкны урьдчилсан тооцоогоор Монгол Улсын эдийн засаг энэ онд 6.2 хувиар өсөх төлөвтэй байна.', '<p>Дэлхийн банкны шинэчилсэн тооцоогоор Монгол Улсын ДНБ 2026 онд 6.2 хувиар өсөх төлөвтэй байна. Энэ нь өмнөх оны 5.8 хувийн өсөлтөөс дээгүүр үзүүлэлт юм.</p><p>Уул уурхайн экспорт нэмэгдсэн, дотоодын хэрэглээ сэргэсэн зэрэг хүчин зүйлс эдийн засгийн өсөлтөд эерэгээр нөлөөлж байна.</p>', NULL, NULL, NULL, 2, 4, 'published', 1, 0, 1, 15423, NULL, '2026-04-14 04:43:33', NULL, NULL, NULL, NULL, NULL, '2026-04-14 06:43:33', '2026-04-14 07:22:10'),
(2, 'УИХ-ын намрын чуулган эхэллээ', 'uix-yn-namryn-cuulgan-exellee', 'Улсын Их Хурлын 2026 оны намрын ээлжит чуулган өнөөдөр нээлтээ хийлээ.', '<p>Улсын Их Хурлын 2026 оны намрын ээлжит чуулган өнөөдөр нээлтээ хийв. Чуулганаар төсвийн тухай хууль, нийгмийн даатгалын шинэчлэл зэрэг чухал асуудлуудыг хэлэлцэх юм байна.</p>', 'articles/SV2ltXysgfoWmxdmWAbcNFi3ieGasqd89OUVk3pt.jpg', NULL, NULL, 1, 1, 'published', 1, 1, 0, 23106, 1, '2026-04-14 05:43:00', NULL, NULL, NULL, NULL, NULL, '2026-04-14 06:43:34', '2026-04-14 09:07:46'),
(3, 'Монголын стартап экосистем хурдацтай хөгжиж байна', 'mongolyn-startap-ekosistem-xurdactai-xogziz-baina', '\"Startup Mongolia\" хөтөлбөрийн хүрээнд 50 гаруй шинэ стартап компани байгуулагдлаа.', '<p>Сүүлийн нэг жилд Монголын стартап экосистем мэдэгдэхүйц хөгжил гарган ажиллаж байна. \"Startup Mongolia\" хөтөлбөрийн дэмжлэгтэйгээр 50 гаруй стартап шинээр байгуулагдлаа.</p>', NULL, NULL, NULL, 5, 3, 'published', 1, 0, 1, 8930, NULL, '2026-04-14 02:43:33', NULL, NULL, NULL, NULL, NULL, '2026-04-14 06:43:34', '2026-04-14 06:43:34'),
(4, 'Монголын боксчин олимпийн алтан медаль хүртлээ', 'mongolyn-bokscin-olimpiin-altan-medal-xurtlee', 'Монголын боксын тамирчин олон улсын тэмцээнд алтан медаль хүртэж, түүхэн амжилт тогтоолоо.', '<p>Монголын боксын тамирчин Н. Баатарсүх олон улсын боксын аварга шалгаруулах тэмцээнд алтан медаль хүртлээ.</p>', NULL, NULL, NULL, 4, 2, 'published', 1, 0, 1, 31200, NULL, '2026-04-14 00:43:33', NULL, NULL, NULL, NULL, NULL, '2026-04-14 06:43:34', '2026-04-14 06:43:34'),
(5, 'Улаанбаатарт шинэ метроны барилга эхэллээ', 'ulaanbaatart-sine-metrony-barilga-exellee', 'Улаанбаатар хотын метроны анхны шугамын барилга ажил албан ёсоор эхэлж байна.', '<p>Улаанбаатар хотын олон жилийн мөрөөдөл болсон метроны анхны шугамын барилга ажил албан ёсоор эхэлж байна. Метроны анхны шугам 18 км урттай, 14 буудалтай байх юм.</p>', NULL, NULL, NULL, 3, 1, 'published', 0, 0, 1, 19501, NULL, '2026-04-13 22:43:33', NULL, NULL, NULL, NULL, NULL, '2026-04-14 06:43:34', '2026-04-14 07:22:08'),
(6, 'AI технологи Монголын боловсролд нэвтэрч байна', 'ai-texnologi-mongolyn-bolovsrold-nevterc-baina', 'Хиймэл оюун ухаан ашигласан сургалтын платформууд Монголын их дээд сургуулиудад нэвтэрч эхэллээ.', '<p>Монголын их дээд сургуулиудад хиймэл оюун ухаан дээр суурилсан сургалтын платформууд нэвтэрч эхэллээ.</p>', NULL, NULL, NULL, 7, 3, 'published', 1, 0, 0, 6700, NULL, '2026-04-13 20:43:00', NULL, NULL, NULL, NULL, NULL, '2026-04-14 06:43:34', '2026-04-14 08:46:16'),
(7, 'Монголын аялал жуулчлал рекорд тогтоолоо', 'mongolyn-aialal-zuulclal-rekord-togtooloo', '2026 оны эхний хагас жилд Монголд 500,000 гаруй жуулчин зочилсон байна.', '<p>2026 оны эхний хагас жилд Монголд 500,000 гаруй гадаадын жуулчин зочилж, рекорд тогтоожээ.</p>', NULL, NULL, NULL, 3, 4, 'published', 1, 0, 0, 12300, NULL, '2026-04-13 18:43:33', NULL, NULL, NULL, NULL, NULL, '2026-04-14 06:43:34', '2026-04-14 06:43:34'),
(8, 'Зэсийн үнэ дэлхийн зах зээл дээр өсчээ', 'zesiin-une-delxiin-zax-zeel-deer-oscee', 'Дэлхийн зах зээл дээр зэсийн үнэ тонн нь 10,000 ам.доллар давлаа.', '<p>Дэлхийн зах зээл дээр зэсийн үнэ тонн нь 10,000 ам.доллар давж, сүүлийн 2 жилийн дээд түвшинд хүрлээ.</p>', NULL, NULL, NULL, 2, 4, 'published', 0, 0, 1, 9801, NULL, '2026-04-13 16:43:33', NULL, NULL, NULL, NULL, NULL, '2026-04-14 06:43:34', '2026-04-14 06:47:41'),
(9, 'Монголын кино Каннын наадамд оролцоно', 'mongolyn-kino-kannyn-naadamd-orolcono', 'Монголын найруулагч Б.Баясгалангийн шинэ кино Каннын олон улсын кино наадмын хөтөлбөрт багтлаа.', '<p>Монголын найруулагч Б.Баясгалангийн \"Мөнх тэнгэр\" кино Каннын олон улсын кино наадмын албан ёсны хөтөлбөрт сонгогдлоо.</p>', NULL, NULL, NULL, 6, 1, 'published', 0, 0, 0, 7200, NULL, '2026-04-13 14:43:33', NULL, NULL, NULL, NULL, NULL, '2026-04-14 06:43:34', '2026-04-14 06:43:34'),
(10, 'Эрүүл мэндийн шинэ даатгалын тогтолцоо нэвтэрнэ', 'eruul-mendiin-sine-daatgalyn-togtolcoo-nevterne', '2026 оноос эхлэн эрүүл мэндийн даатгалын шинэ тогтолцоо хэрэгжиж эхэлнэ.', '<p>Засгийн газраас эрүүл мэндийн даатгалын шинэ тогтолцоог 2026 оноос эхлэн нэвтрүүлэхээр болсон.</p>', NULL, NULL, NULL, 8, 1, 'published', 0, 0, 0, 5400, NULL, '2026-04-13 12:43:33', NULL, NULL, NULL, NULL, NULL, '2026-04-14 06:43:34', '2026-04-14 06:43:34'),
(11, 'Дэлхийн цаг уурын өөрчлөлтийн бага хурал эхэллээ', 'delxiin-cag-uuryn-oorcloltiin-baga-xural-exellee', 'НҮБ-ын цаг уурын өөрчлөлтийн бага хурал энэ долоо хоногт эхэлж байна.', '<p>НҮБ-ын цаг уурын өөрчлөлтийн талаарх дараагийн бага хурал Женевт эхэлж байна.</p>', NULL, NULL, NULL, 9, 4, 'published', 0, 0, 0, 4100, NULL, '2026-04-13 10:43:33', NULL, NULL, NULL, NULL, NULL, '2026-04-14 06:43:34', '2026-04-14 06:43:34'),
(12, 'Монголын сагсан бөмбөгийн шигшээ баг Азийн аваргад оролцоно', 'mongolyn-sagsan-bombogiin-sigsee-bag-aziin-avargad-orolcono', 'Монголын сагсан бөмбөгийн эрэгтэй шигшээ баг Азийн аварга шалгаруулах тэмцээнд бэлтгэж байна.', '<p>Монголын сагсан бөмбөгийн эрэгтэй шигшээ баг ирэх сарын Азийн аварга шалгаруулах тэмцээнд бэлтгэж байна.</p>', NULL, NULL, NULL, 4, 2, 'published', 0, 0, 0, 8500, NULL, '2026-04-13 08:43:33', NULL, NULL, NULL, NULL, NULL, '2026-04-14 06:43:34', '2026-04-14 06:43:34');

-- --------------------------------------------------------

--
-- Table structure for table `article_tag`
--

DROP TABLE IF EXISTS `article_tag`;
CREATE TABLE IF NOT EXISTS `article_tag` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` bigint UNSIGNED NOT NULL,
  `tag_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `article_tag_article_id_tag_id_unique` (`article_id`,`tag_id`),
  KEY `article_tag_tag_id_foreign` (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `article_tag`
--

INSERT INTO `article_tag` (`id`, `article_id`, `tag_id`) VALUES
(1, 1, 10),
(2, 1, 11),
(3, 1, 13),
(4, 1, 15),
(5, 2, 1),
(6, 2, 2),
(7, 2, 6),
(8, 2, 11),
(9, 3, 9),
(10, 3, 12),
(11, 3, 13),
(12, 4, 2),
(13, 4, 7),
(14, 4, 9),
(15, 4, 10),
(16, 5, 4),
(17, 5, 10),
(18, 6, 9),
(19, 6, 13),
(20, 6, 15),
(21, 7, 2),
(22, 7, 3),
(23, 7, 5),
(24, 7, 12),
(25, 8, 1),
(26, 8, 6),
(27, 8, 8),
(28, 9, 3),
(29, 9, 12),
(30, 9, 15),
(31, 10, 2),
(32, 10, 4),
(33, 10, 12),
(34, 10, 14),
(35, 11, 4),
(36, 11, 5),
(37, 11, 13),
(38, 12, 9),
(39, 12, 11);

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
CREATE TABLE IF NOT EXISTS `authors` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_links` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `authors_slug_unique` (`slug`),
  KEY `authors_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `user_id`, `name`, `slug`, `email`, `bio`, `avatar`, `position`, `social_links`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Б. Болормаа', 'b-bolormaa', 'bolormaa@odod.mn', 'Улс төрийн мэдээний ахлах сэтгүүлч, 10 жилийн туршлагатай.', NULL, 'Ахлах сэтгүүлч', NULL, 1, '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(2, NULL, 'Д. Ганбаатар', 'd-ganbaatar', 'ganbaatar@odod.mn', 'Монголын спортын мэдээний мэргэжилтэн.', NULL, 'Спорт сэтгүүлч', NULL, 1, '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(3, NULL, 'С. Сарантуяа', 's-sarantuiaa', 'sarantuya@odod.mn', 'Технологи, инновацийн чиглэлийн сэтгүүлч.', NULL, 'Технологи сэтгүүлч', NULL, 1, '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(4, NULL, 'Т. Тэмүүлэн', 't-temuulen', 'temuulen@odod.mn', 'Эдийн засаг, санхүүгийн мэдээний шинжээч.', NULL, 'Эдийн засаг сэтгүүлч', NULL, 1, '2026-04-14 06:43:33', '2026-04-14 06:43:33');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#3B82F6',
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `show_in_menu` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `name_en`, `slug`, `description`, `color`, `icon`, `parent_id`, `sort_order`, `is_active`, `show_in_menu`, `created_at`, `updated_at`) VALUES
(1, 'Улс төр', 'Politics', 'politics', NULL, '#EF4444', NULL, NULL, 1, 1, 1, '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(2, 'Эдийн засаг', 'Economy', 'economy', NULL, '#F59E0B', NULL, NULL, 2, 1, 1, '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(3, 'Нийгэм', 'Society', 'society', NULL, '#3B82F6', NULL, NULL, 3, 1, 1, '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(4, 'Спорт', 'Sports', 'sports', NULL, '#10B981', NULL, NULL, 4, 1, 1, '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(5, 'Технологи', 'Technology', 'technology', NULL, '#8B5CF6', NULL, NULL, 5, 1, 1, '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(6, 'Соёл урлаг', 'Culture', 'culture', NULL, '#EC4899', NULL, NULL, 6, 1, 1, '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(7, 'Боловсрол', 'Education', 'education', NULL, '#06B6D4', NULL, NULL, 7, 1, 1, '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(8, 'Эрүүл мэнд', 'Health', 'health', NULL, '#14B8A6', NULL, NULL, 8, 1, 1, '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(9, 'Дэлхий', 'World', 'world', NULL, '#6366F1', NULL, NULL, 9, 1, 1, '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(10, 'Видео', 'Video', 'video', NULL, '#F43F5E', NULL, NULL, 10, 1, 1, '2026-04-14 06:43:33', '2026-04-14 06:43:33');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_uuid_unique` (`uuid`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `media_order_column_index` (`order_column`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000001_create_categories_table', 1),
(5, '2024_01_01_000002_create_authors_table', 1),
(6, '2024_01_01_000003_create_tags_table', 1),
(7, '2024_01_01_000004_create_articles_table', 1),
(8, '2024_01_01_000005_create_article_tag_table', 1),
(9, '2024_01_01_000006_add_is_admin_to_users_table', 1),
(10, '2026_04_14_135924_create_media_table', 1),
(11, '2026_04_15_000001_enhance_articles_table', 2),
(12, '2026_04_15_000002_create_uploads_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('258I0M57uqSxTQBya3LxZtLUT6u9lzwz0nmUmEaO', NULL, '::1', 'curl/8.18.0', 'eyJfdG9rZW4iOiJ5ZXdkMGJ1dU5BS2ZWMGtLYUFkSWRqVXM0OVlHYUNFcUhRWUN4WmtnIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvb2RvZFwvYmFja2VuZCIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1776182280),
('7baqy6FXfVboc0aWfNqMA2UApwndmZ5Nn8eIZ3kN', NULL, '::1', 'curl/8.18.0', 'eyJfdG9rZW4iOiJDZzlzcWFDSnRIVE51bnNlQUpBTVF3UzRaaXkzdUtMdFFJdGswckg0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvb2RvZFwvYmFja2VuZFwvcHVibGljIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1776181786),
('eWTZS81pGG6QQzlwE51Guicmh6Ob3U9jQJkGN4kK', NULL, '::1', 'curl/8.18.0', 'eyJfdG9rZW4iOiJOUmhkMGF5VVM5allTUlBCNWxVMnRycTNDV3hSdlFBa01zbzU0NVdJIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvb2RvZFwvYmFja2VuZFwvbG9naW4iLCJyb3V0ZSI6ImFkbWluLmxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1776182485),
('Knf7ATykQRQ5HPJrD8sIgqUOFFT3V3cBOg6Hji0g', NULL, '::1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920', 'eyJfdG9rZW4iOiJhMHJCbzllamJVcGFFSXZjb091UXpINWc1UkN5OFBuVXBicThBalVwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvb2RvZFwvYmFja2VuZFwvcHVibGljIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1776181768),
('t1FvWJTlquinViPWtnAb20yzckBJ7dezTeKtUbAL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'eyJfdG9rZW4iOiI1TW9oM1pXY3lSb1c3eGxVZU9wdWt0UDNPeXlweVZpMWhxMGRRZWZJIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1776177925),
('Ttkdbl6rhvDGw96XGT32BaW0qZ2GC8xJVwta6xcB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920', 'eyJfdG9rZW4iOiJEOUdMMVZjckFNVzlydTQwMHF2bWFSUE10THo0a1dobE81NFY5eWlQIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6ImFkbWluLmxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1776180152),
('Tu8NdaRR84ZQF5EvBuYZo1sUA1N49OsDZjpArUX1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920', 'eyJfdG9rZW4iOiJjSVd4ZnRqWndIb2hpTWJZZE5kSjZsUFdxb2ZDWlplWDNMSDFwa1A4IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6ImFkbWluLmxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1776180309),
('VqeAiVtL3M6U0pFCM7e1FZQUFxSrhYkSkOAq3HhI', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'eyJfdG9rZW4iOiI5OFJMN3FIWHpMblV1T3NaRm5aWWtQb3FxdjFkSWxWNHVabGh0S0hWIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0XC9vZG9kXC9iYWNrZW5kXC9hcnRpY2xlc1wvMlwvZWRpdCIsInJvdXRlIjoiYWRtaW4uYXJ0aWNsZXMuZWRpdCJ9LCJ1cmwiOltdLCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MSwicGFzc3dvcmRfaGFzaF93ZWIiOiI3MTY4M2EzMzRmYWI3MWFhZDY3MDlhNDExOWU3MWM3M2NlZTViZjBjZmM1NTMxOGZmYjMzNTY3Y2UxYTk0NWRmIn0=', 1776187073),
('WQyOYakJ658MZ2nHv6vahaCBsjNIHMsrCjeOEpGa', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7920', 'eyJfdG9rZW4iOiJNUk8waW1UNlJxeE1WNjhxMlpPY2JpTnd0VnFDN2VrSk9jdWc3ZUhQIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6ImFkbWluLmxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1776180347),
('xg1QvHbr1mDEXPPlYofxcoU4oxfrMRkB0V0KTTKj', NULL, NULL, '', 'eyJfdG9rZW4iOiJPVDl2eFV6UkRwbGxGZzRmRFcxcm1LbFhhYnBPTDBsRUlCZE1qNlNCIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzoiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1776178377),
('XgyIi9gLkDRV6NxUwyU70P08vbvAHGPnASVkMFKe', NULL, NULL, '', 'eyJfdG9rZW4iOiJ5eW5BSVB2cmFremhNOW9NZ0tMVTZpeFZ1bU5JbTB2cEF0azhpa0dxIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzoiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1776178360),
('Y1BUdo7bTvLWlMbkmHpuuCh3Z7JbNDJiRjYcJ90K', NULL, '::1', 'curl/8.18.0', 'eyJfdG9rZW4iOiJWS2N0MENyYjRhZ20zang4U3BSclFUWEg3amU2S1VYWUxTVllQZHB4IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvb2RvZFwvYmFja2VuZFwvcHVibGljIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1776181779),
('yu2KZ7KC9eXjg9HWzJAVs2gUOApkhj8z4t7nuqwB', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'eyJfdG9rZW4iOiJFMzRRdU1HWW5sTTIzN3dwM0hwTGMzTWNVUUdkUWFEWUEzaTFlUXlHIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvb2RvZFwvYmFja2VuZFwvbWVkaWEiLCJyb3V0ZSI6ImFkbWluLm1lZGlhLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9', 1776204518);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Монгол Улс', 'mongol-uls', '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(2, 'УИХ', 'uix', '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(3, 'Засгийн газар', 'zasgiin-gazar', '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(4, 'Эдийн засаг', 'ediin-zasag', '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(5, 'Бизнес', 'biznes', '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(6, 'Уул уурхай', 'uul-uurxai', '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(7, 'Боловсрол', 'bolovsrol', '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(8, 'Эрүүл мэнд', 'eruul-mend', '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(9, 'Хөрөнгө оруулалт', 'xorongo-oruulalt', '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(10, 'Технологи', 'texnologi', '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(11, 'Startup', 'startup', '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(12, 'AI', 'ai', '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(13, 'Спорт', 'sport', '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(14, 'Хөл бөмбөг', 'xol-bombog', '2026-04-14 06:43:33', '2026-04-14 06:43:33'),
(15, 'Бөх', 'box', '2026-04-14 06:43:33', '2026-04-14 06:43:33');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

DROP TABLE IF EXISTS `uploads`;
CREATE TABLE IF NOT EXISTS `uploads` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `filename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `mime_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `folder` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `alt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uploads_folder_index` (`folder`),
  KEY `uploads_mime_type_index` (`mime_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Админ', 'admin@odod.mn', NULL, '$2y$12$DJqu7DeEUWcbQRt.rHhKcOqfW/M32Fc9MsU7bi8/JJFw7BkvbewN6', 1, NULL, '2026-04-14 06:43:33', '2026-04-14 06:52:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles` ADD FULLTEXT KEY `articles_title_excerpt_body_fulltext` (`title`,`excerpt`,`body`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `article_tag`
--
ALTER TABLE `article_tag`
  ADD CONSTRAINT `article_tag_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `authors`
--
ALTER TABLE `authors`
  ADD CONSTRAINT `authors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
