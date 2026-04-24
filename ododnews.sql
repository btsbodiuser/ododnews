-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 24, 2026 at 05:59 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ododnews`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  KEY `activity_logs_subject_type_subject_id_index` (`subject_type`,`subject_id`),
  KEY `activity_logs_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

DROP TABLE IF EXISTS `admin_notifications`;
CREATE TABLE IF NOT EXISTS `admin_notifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` enum('info','success','warning','danger') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'info',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_notifications_user_id_read_at_index` (`user_id`,`read_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

DROP TABLE IF EXISTS `ads`;
CREATE TABLE IF NOT EXISTS `ads` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `slot_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('image','html','adsense') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image',
  `image_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `html_code` longtext COLLATE utf8mb4_unicode_ci,
  `target_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `geo_targets` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `impressions` int UNSIGNED NOT NULL DEFAULT '0',
  `clicks` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ads_slot_id_is_active_index` (`slot_id`,`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ad_slots`
--

DROP TABLE IF EXISTS `ad_slots`;
CREATE TABLE IF NOT EXISTS `ad_slots` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ad_slots_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

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
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_breaking` tinyint(1) NOT NULL DEFAULT '0',
  `is_trending` tinyint(1) NOT NULL DEFAULT '0',
  `views_count` bigint UNSIGNED NOT NULL DEFAULT '0',
  `reading_time` smallint UNSIGNED DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `meta` json DEFAULT NULL,
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8mb4_unicode_ci,
  `canonical_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`),
  KEY `articles_category_id_foreign` (`category_id`),
  KEY `articles_author_id_foreign` (`author_id`),
  KEY `articles_status_published_at_index` (`status`,`published_at`),
  KEY `articles_is_featured_index` (`is_featured`),
  KEY `articles_is_trending_index` (`is_trending`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `slug`, `excerpt`, `body`, `featured_image`, `featured_video`, `gallery`, `category_id`, `author_id`, `user_id`, `status`, `is_featured`, `is_breaking`, `is_trending`, `views_count`, `reading_time`, `published_at`, `scheduled_at`, `meta`, `seo_title`, `seo_description`, `canonical_url`, `og_image`, `source_name`, `source_url`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'УИХ-ын намрын чуулган эхэллээ', 'uix-yn-namryn-cuulgan-exellee', 'Улсын Их Хурлын 2026 оны намрын ээлжит чуулган өнөөдөр нээлтээ хийлээ.', '<p>Улсын Их Хурлын 2026 оны намрын ээлжит чуулган өнөөдөр нээлтээ хийв. Чуулганаар төсвийн тухай хууль, нийгмийн даатгалын шинэчлэл зэрэг чухал асуудлуудыг хэлэлцэх юм байна.</p>', NULL, NULL, NULL, 1, 2, NULL, 'published', 1, 1, 0, 23100, NULL, '2026-04-14 15:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(2, 'Засгийн газрын шинэ бүтэц батлагдлаа', 'zasgiin-gazryn-sine-butec-batlagdlaa', 'Засгийн газрын шинэ бүтцийг УИХ-аар баталлаа.', '<p>Засгийн газрын шинэ бүтцийг УИХ-аар хэлэлцэн баталлаа. Шинэ бүтцэд 16 яам, 12 агентлаг багтаж байна.</p>', NULL, NULL, NULL, 1, 3, NULL, 'published', 0, 0, 1, 18200, NULL, '2026-04-14 13:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(3, 'Сонгуулийн шинэ хууль хэлэлцэж байна', 'songuuliin-sine-xuul-xelelcez-baina', 'УИХ сонгуулийн тухай хуулийн шинэчлэлийг хэлэлцэж эхэллээ.', '<p>Сонгуулийн тухай хуулийн шинэчилсэн төслийг УИХ-ын чуулганаар хэлэлцэж байна. Пропорционал тогтолцоонд шилжих асуудал хамгийн их маргаан дагуулж байна.</p>', NULL, NULL, NULL, 1, 1, NULL, 'published', 0, 0, 0, 14501, NULL, '2026-04-14 11:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-20 18:59:03', NULL),
(4, 'Ерөнхийлөгч БНХАУ-д албан ёсны айлчлал хийлээ', 'eronxiilogc-bnxau-d-alban-esny-ailclal-xiilee', 'Монгол Улсын Ерөнхийлөгч БНХАУ-д гурван өдрийн албан ёсны айлчлал хийв.', '<p>Монгол Улсын Ерөнхийлөгч БНХАУ-д гурван өдрийн айлчлалын хүрээнд худалдаа, эдийн засгийн хэд хэдэн гэрээ байгууллаа.</p>', NULL, NULL, NULL, 1, 1, NULL, 'published', 1, 0, 0, 21001, NULL, '2026-04-14 10:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:43:46', NULL),
(5, 'Авилгын эсрэг шинэ хөтөлбөр батлагдлаа', 'avilgyn-esreg-sine-xotolbor-batlagdlaa', 'Засгийн газар авилгатай тэмцэх шинэ хөтөлбөр батлан гаргалаа.', '<p>Засгийн газраас авилгын эсрэг үндэсний шинэ хөтөлбөр батлан, хэрэгжүүлж эхэллээ.</p>', NULL, NULL, NULL, 1, 2, NULL, 'published', 0, 0, 0, 11200, NULL, '2026-04-14 07:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(6, 'Орон нутгийн сонгуулийн дүн гарлаа', 'oron-nutgiin-songuuliin-dun-garlaa', 'Орон нутгийн сонгуулийн эцсийн дүн гарч, шинэ засаг дарга нар тодорлоо.', '<p>2026 оны орон нутгийн сонгуулийн эцсийн албан ёсны дүнг Сонгуулийн ерөнхий хороо зарлалаа.</p>', NULL, NULL, NULL, 1, 4, NULL, 'published', 0, 0, 1, 16800, NULL, '2026-04-14 06:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(7, 'Улс төрийн намуудын санхүүжилтийн тайлан нийтлэгдлээ', 'uls-toriin-namuudyn-sanxuuziltiin-tailan-niitlegdlee', 'Улс төрийн намуудын санхүүжилтийн тайланг СЕХ нийтэд мэдээлэв.', '<p>Сонгуулийн ерөнхий хорооноос улс төрийн намуудын санхүүгийн тайланг нийтэд ил болголоо.</p>', NULL, NULL, NULL, 1, 2, NULL, 'published', 0, 0, 0, 8900, NULL, '2026-04-14 02:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(8, 'Шинэ Үндсэн хуулийн нэмэлт өөрчлөлт хэлэлцэгдэж байна', 'sine-undsen-xuuliin-nemelt-oorclolt-xelelcegdez-baina', 'Үндсэн хуулийн нэмэлт өөрчлөлтийн төслийг УИХ хэлэлцэж байна.', '<p>Үндсэн хуулийн 10 зүйлд нэмэлт өөрчлөлт оруулах төслийг УИХ-ын гишүүд хэлэлцэж байна.</p>', NULL, NULL, NULL, 1, 1, NULL, 'published', 0, 0, 0, 13400, NULL, '2026-04-14 00:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(9, 'Монгол-Оросын дипломат харилцааны 100 жил', 'mongol-orosyn-diplomat-xarilcaany-100-zil', 'Монгол-Оросын дипломат харилцаа тогтоосны 100 жилийн ой тохиож байна.', '<p>Монгол-Оросын дипломат харилцаа тогтоосны 100 жилийн ойг тэмдэглэн, хоёр орны удирдагчид уулзалт хийв.</p>', NULL, NULL, NULL, 1, 3, NULL, 'published', 1, 0, 0, 10500, NULL, '2026-04-13 21:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(10, 'Төрийн албаны шинэчлэлийн хууль батлагдлаа', 'toriin-albany-sinecleliin-xuul-batlagdlaa', 'Төрийн албаны тухай хуулийн шинэчилсэн найруулга батлагдлаа.', '<p>УИХ-аар Төрийн албаны тухай хуулийн шинэчилсэн найруулгыг олонхийн саналаар батлав.</p>', NULL, NULL, NULL, 1, 3, NULL, 'published', 0, 0, 0, 9700, NULL, '2026-04-13 17:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(11, 'Парламентын ардчилал сэдвээр олон улсын форум болно', 'parlamentyn-ardcilal-sedveer-olon-ulsyn-forum-bolno', 'Улаанбаатарт парламентын ардчиллын чиглэлээр олон улсын форум зохион байгуулна.', '<p>Парламентын ардчиллын хөгжлийн чиглэлээр олон улсын форумыг Улаанбаатарт зохион байгуулахаар болжээ.</p>', NULL, NULL, NULL, 1, 4, NULL, 'published', 0, 0, 0, 7600, NULL, '2026-04-13 15:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(12, 'Засгийн газрын тогтоолоор шинэ хөтөлбөр хэрэгжинэ', 'zasgiin-gazryn-togtooloor-sine-xotolbor-xeregzine', 'Засгийн газраас хөдөө аж ахуйн дэмжлэгийн шинэ хөтөлбөр батлав.', '<p>Засгийн газраас малчдын амьжиргааг дэмжих шинэ хөтөлбөр батлан, хэрэгжүүлж эхэллээ.</p>', NULL, NULL, NULL, 1, 2, NULL, 'published', 0, 0, 0, 6800, NULL, '2026-04-13 12:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(13, 'Монгол Улсын эдийн засаг 2026 онд 6.2 хувиар өсөх төлөвтэй', 'mongol-ulsyn-ediin-zasag-2026-ond-62-xuviar-osox-tolovtei', 'Дэлхийн банкны урьдчилсан тооцоогоор Монгол Улсын эдийн засаг энэ онд 6.2 хувиар өсөх төлөвтэй байна.', '<p>Дэлхийн банкны шинэчилсэн тооцоогоор Монгол Улсын ДНБ 2026 онд 6.2 хувиар өсөх төлөвтэй байна. Энэ нь өмнөх оны 5.8 хувийн өсөлтөөс дээгүүр үзүүлэлт юм.</p>', NULL, NULL, NULL, 2, 2, NULL, 'published', 1, 0, 1, 15421, NULL, '2026-04-13 09:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-20 16:25:23', NULL),
(14, 'Зэсийн үнэ дэлхийн зах зээл дээр өсчээ', 'zesiin-une-delxiin-zax-zeel-deer-oscee', 'Дэлхийн зах зээл дээр зэсийн үнэ тонн нь 10,000 ам.доллар давлаа.', '<p>Дэлхийн зах зээл дээр зэсийн үнэ тонн нь 10,000 ам.доллар давж, сүүлийн 2 жилийн дээд түвшинд хүрлээ.</p>', NULL, NULL, NULL, 2, 4, NULL, 'published', 0, 0, 1, 9800, NULL, '2026-04-13 05:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(15, 'Төгрөгийн ханш тогтворжлоо', 'togrogiin-xans-togtvorzloo', 'Монголбанкны бодлогоор төгрөгийн ханш тогтвортой байна.', '<p>Монголбанкны мөнгөний бодлогын үр дүнд төгрөгийн ханш сүүлийн 3 сарын хугацаанд тогтвортой байдлаа хадгалж байна.</p>', NULL, NULL, NULL, 2, 2, NULL, 'published', 0, 0, 0, 12101, NULL, '2026-04-13 03:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-20 18:59:08', NULL),
(16, 'Оюу толгойн далд уурхайн олборлолт эхэллээ', 'oiuu-tolgoin-dald-uurxain-olborlolt-exellee', 'Оюу толгойн далд уурхайн олборлолт албан ёсоор эхэлж байна.', '<p>Оюу толгой далд уурхайн олборлолтыг албан ёсоор эхлүүлж, анхны хүдрийг олборлолоо.</p>', NULL, NULL, NULL, 2, 1, NULL, 'published', 1, 1, 0, 25300, NULL, '2026-04-13 02:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(17, 'Монголын хөрөнгийн бирж шинэ рекорд тогтоолоо', 'mongolyn-xorongiin-birz-sine-rekord-togtooloo', 'MSE-ийн индекс түүхэн дээд түвшинд хүрлээ.', '<p>Монголын хөрөнгийн биржийн TOP-20 индекс 50,000 оноог давж, түүхэн дээд амжилт тогтоолоо.</p>', NULL, NULL, NULL, 2, 1, NULL, 'published', 0, 0, 1, 11500, NULL, '2026-04-13 01:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(18, 'Гадаадын шууд хөрөнгө оруулалт нэмэгдлээ', 'gadaadyn-suud-xorongo-oruulalt-nemegdlee', 'Монголд чиглэсэн гадаадын шууд хөрөнгө оруулалт өсөлттэй байна.', '<p>2026 оны эхний хагас жилд Монголд чиглэсэн гадаадын шууд хөрөнгө оруулалт өмнөх оноос 15 хувиар нэмэгджээ.</p>', NULL, NULL, NULL, 2, 2, NULL, 'published', 0, 0, 0, 8700, NULL, '2026-04-13 00:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(19, 'Инфляцийн түвшин буурч байна', 'infliaciin-tuvsin-buurc-baina', 'Монгол Улсын инфляци сүүлийн 6 сард тогтмол буурч байна.', '<p>Үндэсний статистикийн хорооны мэдээгээр инфляцийн түвшин 5.2 хувь болж буурсан байна.</p>', NULL, NULL, NULL, 2, 1, NULL, 'published', 0, 0, 0, 7300, NULL, '2026-04-12 21:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(20, 'Нүүрсний экспорт сэргэлээ', 'nuursnii-eksport-sergelee', 'Хятадын зах зээлд чиглэсэн нүүрсний экспорт сэргэж байна.', '<p>Монголоос БНХАУ-д чиглэсэн нүүрсний экспорт сүүлийн 3 сард мэдэгдэхүйц сэргэж, сарын 8 сая тонн давлаа.</p>', NULL, NULL, NULL, 2, 1, NULL, 'published', 0, 0, 0, 10200, NULL, '2026-04-12 19:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(21, 'Жижиг дунд бизнесийн зээлийн хүү буурлаа', 'zizig-dund-biznesiin-zeeliin-xuu-buurlaa', 'Банкууд ЖДҮ-ийн зээлийн хүүг бууруулж байна.', '<p>Арилжааны банкууд жижиг дунд үйлдвэрлэлийн зээлийн хүүг дунджаар 2 нэгжээр бууруулсан байна.</p>', NULL, NULL, NULL, 2, 1, NULL, 'published', 0, 0, 0, 6500, NULL, '2026-04-12 16:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(22, 'Монгол-Хятадын худалдааны эргэлт өслөө', 'mongol-xiatadyn-xudaldaany-ergelt-osloo', 'Хоёр орны худалдааны эргэлт 15 тэрбум ам.доллар давлаа.', '<p>Монгол-Хятадын хоёр талын худалдааны эргэлт 2026 оны эхний хагас жилд 15 тэрбум ам.долларт хүрсэн байна.</p>', NULL, NULL, NULL, 2, 2, NULL, 'published', 1, 0, 0, 9100, NULL, '2026-04-12 13:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(23, 'Шинэ татварын хууль хэрэгжиж эхэллээ', 'sine-tatvaryn-xuul-xeregziz-exellee', 'Татварын шинэчилсэн хууль 2026 оноос хэрэгжиж эхэллээ.', '<p>Татварын ерөнхий хуулийн шинэчилсэн найруулга энэ оны 1-р сараас хэрэгжиж эхэлсэн.</p>', NULL, NULL, NULL, 2, 2, NULL, 'published', 0, 0, 0, 8401, NULL, '2026-04-12 12:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:43:38', NULL),
(24, 'Барилгын салбарын өсөлт үргэлжилж байна', 'barilgyn-salbaryn-osolt-urgelzilz-baina', 'Барилгын салбар жилийн 8 хувийн өсөлттэй байна.', '<p>Барилгын салбар 2026 онд жилийн 8 хувийн өсөлттэй ажиллаж, шинэ орон сууцны нийлүүлэлт нэмэгджээ.</p>', NULL, NULL, NULL, 2, 4, NULL, 'published', 0, 0, 0, 5900, NULL, '2026-04-12 09:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(25, 'Улаанбаатарт шинэ метроны барилга эхэллээ', 'ulaanbaatart-sine-metrony-barilga-exellee', 'Улаанбаатар хотын метроны анхны шугамын барилга ажил албан ёсоор эхэлж байна.', '<p>Улаанбаатар хотын метроны анхны шугамын барилга ажил албан ёсоор эхэлж байна. Метроны анхны шугам 18 км урттай, 14 буудалтай байх юм.</p>', NULL, NULL, NULL, 3, 4, NULL, 'published', 0, 0, 1, 19500, NULL, '2026-04-12 08:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(26, 'Монголын аялал жуулчлал рекорд тогтоолоо', 'mongolyn-aialal-zuulclal-rekord-togtooloo', '2026 оны эхний хагас жилд Монголд 500,000 гаруй жуулчин зочилсон байна.', '<p>2026 оны эхний хагас жилд Монголд 500,000 гаруй гадаадын жуулчин зочилж, рекорд тогтоожээ.</p>', NULL, NULL, NULL, 3, 4, NULL, 'published', 1, 0, 0, 12300, NULL, '2026-04-12 05:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(27, 'Шинэ орон сууцны хороолол нээгдлээ', 'sine-oron-suucny-xoroolol-neegdlee', 'Улаанбаатарт 5000 айлын шинэ хороолол ашиглалтад орлоо.', '<p>Яармагийн бүсэд баригдсан 5000 айлын шинэ орон сууцны хороолол албан ёсоор нээгдлээ.</p>', NULL, NULL, NULL, 3, 2, NULL, 'published', 0, 0, 0, 14200, NULL, '2026-04-12 04:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(28, 'Хөдөөгийн хүн амын нүүдэл буурч байна', 'xodoogiin-xun-amyn-nuudel-buurc-baina', 'Хөдөөнөөс хот руу чиглэсэн шилжилт хөдөлгөөн буурсан байна.', '<p>Орон нутгийн хөгжлийн бодлогын үр дүнд хөдөөнөөс хот руу шилжих хүн амын тоо буурч байна.</p>', NULL, NULL, NULL, 3, 3, NULL, 'published', 0, 0, 0, 8100, NULL, '2026-04-12 00:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(29, 'Агаарын бохирдол буурсан тайлан гарлаа', 'agaaryn-boxirdol-buursan-tailan-garlaa', 'Улаанбаатарын агаарын бохирдол өмнөх оноос 20 хувиар буурсан байна.', '<p>Агаарын чанарын хэмжилтийн дүнгээр Улаанбаатарын агаарын бохирдол өмнөх оноос 20 хувиар буурсан байна.</p>', NULL, NULL, NULL, 3, 4, NULL, 'published', 0, 0, 1, 16700, NULL, '2026-04-11 20:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(30, 'Хүүхдийн цэцэрлэгийн хүрэлцээ сайжирч байна', 'xuuxdiin-cecerlegiin-xurelcee-saizirc-baina', 'Энэ онд 30 шинэ цэцэрлэг ашиглалтад орсон байна.', '<p>Боловсролын яамны мэдээгээр 2026 онд улсын хэмжээнд 30 шинэ цэцэрлэг ашиглалтад оржээ.</p>', NULL, NULL, NULL, 3, 2, NULL, 'published', 0, 0, 0, 6900, NULL, '2026-04-11 19:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(31, 'Замын хөдөлгөөний шинэ дүрэм мөрдөгдөж эхэллээ', 'zamyn-xodolgoonii-sine-durem-mordogdoz-exellee', 'Замын хөдөлгөөний аюулгүй байдлын шинэ дүрэм хэрэгжиж эхэллээ.', '<p>Замын хөдөлгөөний аюулгүй байдлын тухай хуулийн дагуу шинэ дүрэм журам энэ сараас мөрдөгдөж эхэлж байна.</p>', NULL, NULL, NULL, 3, 1, NULL, 'published', 0, 0, 0, 11300, NULL, '2026-04-11 17:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(32, 'Нийтийн тээврийн шинэчлэл үргэлжилж байна', 'niitiin-teevriin-sineclel-urgelzilz-baina', '200 шинэ автобус нийтийн тээвэрт нэмэгдлээ.', '<p>Улаанбаатар хотын нийтийн тээвэрт 200 шинэ автобус нэмэгдэж, иргэдэд үйлчилж эхэллээ.</p>', NULL, NULL, NULL, 3, 4, NULL, 'published', 0, 0, 0, 9400, NULL, '2026-04-11 14:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(33, 'Ахмад настны тэтгэмж нэмэгдлээ', 'axmad-nastny-tetgemz-nemegdlee', 'Ахмад настны нийгмийн тэтгэмж 20 хувиар өслөө.', '<p>Засгийн газрын шийдвэрээр ахмад настны нийгмийн тэтгэмжийг 20 хувиар нэмэгдүүлсэн байна.</p>', NULL, NULL, NULL, 3, 1, NULL, 'published', 0, 0, 0, 7800, NULL, '2026-04-11 12:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(34, 'Монголд шинэ олон улсын нисэх буудал нээгдлээ', 'mongold-sine-olon-ulsyn-nisex-buudal-neegdlee', 'Чингис хаан олон улсын шинэ нисэх буудал бүрэн хүчин чадлаараа ажиллаж эхэллээ.', '<p>Чингис хаан олон улсын шинэ нисэх буудал жилд 3 сая зорчигчид үйлчлэх хүчин чадалтайгаар бүрэн ажиллаж эхэллээ.</p>', NULL, NULL, NULL, 3, 3, NULL, 'published', 1, 0, 0, 22100, NULL, '2026-04-11 09:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(35, 'Хүүхдийн эрхийн тухай шинэ хууль батлагдлаа', 'xuuxdiin-erxiin-tuxai-sine-xuul-batlagdlaa', 'Хүүхдийн эрхийг хамгаалах шинэ хуулийг УИХ батлав.', '<p>Хүүхдийн эрхийг хамгаалах тухай хуулийн шинэчилсэн найруулгыг УИХ-аар батлан гаргалаа.</p>', NULL, NULL, NULL, 3, 1, NULL, 'published', 0, 0, 0, 5600, NULL, '2026-04-11 06:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(36, 'Ус хангамжийн шинэ систем нэвтэрлээ', 'us-xangamziin-sine-sistem-nevterlee', 'Улаанбаатарын ус хангамжийн шинэ систем ашиглалтад орлоо.', '<p>Улаанбаатар хотын ус хангамж, ариутгах татуургын шинэ систем бүрэн ашиглалтад орлоо.</p>', NULL, NULL, NULL, 3, 4, NULL, 'published', 0, 0, 0, 8300, NULL, '2026-04-11 02:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(37, 'Монголын боксчин олимпийн алтан медаль хүртлээ', 'mongolyn-bokscin-olimpiin-altan-medal-xurtlee', 'Монголын боксын тамирчин олон улсын тэмцээнд алтан медаль хүртэж, түүхэн амжилт тогтоолоо.', '<p>Монголын боксын тамирчин Н. Баатарсүх олон улсын боксын аварга шалгаруулах тэмцээнд алтан медаль хүртлээ.</p>', NULL, NULL, NULL, 4, 3, NULL, 'published', 1, 0, 1, 31201, NULL, '2026-04-10 23:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-23 18:56:14', NULL),
(38, 'Монголын сагсан бөмбөгийн шигшээ баг Азийн аваргад оролцоно', 'mongolyn-sagsan-bombogiin-sigsee-bag-aziin-avargad-orolcono', 'Монголын сагсан бөмбөгийн эрэгтэй шигшээ баг Азийн аварга шалгаруулах тэмцээнд бэлтгэж байна.', '<p>Монголын сагсан бөмбөгийн эрэгтэй шигшээ баг ирэх сарын Азийн аварга шалгаруулах тэмцээнд бэлтгэж байна.</p>', NULL, NULL, NULL, 4, 2, NULL, 'published', 0, 0, 0, 8500, NULL, '2026-04-10 22:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(39, 'Д. Бямбадорж сумогийн аварга болов', 'd-biambadorz-sumogiin-avarga-bolov', 'Монголын бөхчин Д. Бямбадорж сумогийн сарын тэмцээнд түрүүлэв.', '<p>Монголын бөхчин Д. Бямбадорж Токиогийн сумогийн тэмцээнд 13-2 үзүүлэлтээр түрүүлж, аварга боллоо.</p>', NULL, NULL, NULL, 4, 3, NULL, 'published', 1, 0, 1, 28000, NULL, '2026-04-10 20:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(40, 'Хөл бөмбөгийн лиг шинэ улирлаа эхлүүллээ', 'xol-bombogiin-lig-sine-ulirlaa-exluullee', 'Монголын хөл бөмбөгийн дээд лиг 2026 оны улирлаа нээлээ.', '<p>Монголын хөл бөмбөгийн дээд лиг шинэ улирлын нээлтийн тоглолтоо амжилттай зохион байгууллаа.</p>', NULL, NULL, NULL, 4, 1, NULL, 'published', 0, 0, 0, 11200, NULL, '2026-04-10 19:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(41, 'Монголын буудагч дэлхийн цомд медаль хүртлээ', 'mongolyn-buudagc-delxiin-comd-medal-xurtlee', 'Монголын буудагч Г.Болдбаатар дэлхийн цомын тэмцээнд хүрэл медаль хүртэв.', '<p>Монголын буудагч Г.Болдбаатар дэлхийн цомын тэмцээнд хүрэл медаль хүртэж, Монголын спортын нэрийг дуурсгалаа.</p>', NULL, NULL, NULL, 4, 3, NULL, 'published', 0, 0, 1, 14600, NULL, '2026-04-10 15:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(42, 'Наадмын бөхийн барилдаанд шинэ дүрэм гарлаа', 'naadmyn-boxiin-barildaand-sine-durem-garlaa', 'Наадмын бөхийн барилдаанд энэ оноос шинэ дүрэм мөрдөнө.', '<p>Монголын үндэсний бөхийн холбооноос Наадмын бөхийн барилдаанд шинэ дүрэм журам мөрдүүлэхээр шийдвэрлэв.</p>', NULL, NULL, NULL, 4, 2, NULL, 'published', 0, 0, 0, 17800, NULL, '2026-04-10 11:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(43, 'Монголын волейболчид Азийн лигт шалгарлаа', 'mongolyn-voleibolcid-aziin-ligt-salgarlaa', 'Монголын эмэгтэй волейболын баг Азийн клубын лигт шалгарч орлоо.', '<p>Монголын эмэгтэй волейболын баг Азийн клубын лигийн шалгаруулалтад амжилттай оролцож, үндсэн шатанд шалгарлаа.</p>', NULL, NULL, NULL, 4, 4, NULL, 'published', 0, 0, 0, 7200, NULL, '2026-04-10 10:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(44, 'Хөнгөн атлетикийн шинэ рекорд тогтоогдлоо', 'xongon-atletikiin-sine-rekord-togtoogdloo', '100 метрийн гүйлтэд Монголын шинэ рекорд тогтоогдлоо.', '<p>Монголын хөнгөн атлетикийн тамирчин 100 метрийн гүйлтэд 10.32 секундын шинэ үндэсний рекорд тогтоолоо.</p>', NULL, NULL, NULL, 4, 3, NULL, 'published', 0, 0, 0, 9300, NULL, '2026-04-10 06:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(45, 'Монголын жүдочин дэлхийн жагсаалтад тэргүүлж байна', 'mongolyn-zudocin-delxiin-zagsaaltad-terguulz-baina', 'Монголын жүдочин М. Уранцэцэг дэлхийн жагсаалтад эхний байрт оролоо.', '<p>Монголын жүдочин М. Уранцэцэг 57 кг-ийн жиндээ дэлхийн жагсаалтын тэргүүн байранд оржээ.</p>', NULL, NULL, NULL, 4, 3, NULL, 'published', 1, 0, 0, 19100, NULL, '2026-04-10 03:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(46, 'Монголд олон улсын марафон болно', 'mongold-olon-ulsyn-marafon-bolno', 'Улаанбаатар марафон олон улсын зэрэглэлтэй болж байна.', '<p>Улаанбаатар марафон энэ жил олон улсын зэрэглэлд шилжиж, 20 орны тамирчид оролцоно.</p>', NULL, NULL, NULL, 4, 4, NULL, 'published', 0, 0, 0, 6100, NULL, '2026-04-10 00:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(47, 'Шатарчин Д. Мөнхзул гроссмейстер цол хүртлээ', 'satarcin-d-monxzul-grossmeister-col-xurtlee', 'Монголын шатарчин Д. Мөнхзул олон улсын гроссмейстер цолыг хүртлээ.', '<p>Монголын шатарчин Д. Мөнхзул олон улсын гроссмейстер цол авсан Монголын 5 дахь тамирчин боллоо.</p>', NULL, NULL, NULL, 4, 3, NULL, 'published', 0, 0, 1, 10800, NULL, '2026-04-09 21:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(48, 'Чөлөөт бөхийн баг олимпийн эрх авлаа', 'coloot-boxiin-bag-olimpiin-erx-avlaa', 'Монголын чөлөөт бөхийн баг 2028 оны олимпийн 3 эрх авлаа.', '<p>Монголын чөлөөт бөхийн баг Азийн тив шалгаруулалтаас 2028 оны олимпийн наадмын 3 эрх авахад амжилт гаргалаа.</p>', NULL, NULL, NULL, 4, 2, NULL, 'published', 1, 0, 0, 21500, NULL, '2026-04-09 17:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(49, 'Монголын стартап экосистем хурдацтай хөгжиж байна', 'mongolyn-startap-ekosistem-xurdactai-xogziz-baina', '\"Startup Mongolia\" хөтөлбөрийн хүрээнд 50 гаруй шинэ стартап компани байгуулагдлаа.', '<p>Сүүлийн нэг жилд Монголын стартап экосистем мэдэгдэхүйц хөгжил гарган ажиллаж байна.</p>', NULL, NULL, NULL, 5, 1, NULL, 'published', 1, 0, 1, 8930, NULL, '2026-04-09 16:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(50, 'Монголын AI стартап 5 сая ам.долларын хөрөнгө оруулалт авлаа', 'mongolyn-ai-startap-5-saia-amdollaryn-xorongo-oruulalt-avlaa', 'Монголын хиймэл оюун ухааны стартап олон улсын хөрөнгө оруулагчдаас санхүүжилт авлаа.', '<p>Монголын AI чиглэлийн \"MongolAI\" стартап компани Сингапурын хөрөнгө оруулалтын сангаас 5 сая ам.долларын санхүүжилт авлаа.</p>', NULL, NULL, NULL, 5, 2, NULL, 'published', 0, 0, 1, 12400, NULL, '2026-04-09 15:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(51, '5G сүлжээ Улаанбаатарт нэвтэрлээ', '5g-sulzee-ulaanbaatart-nevterlee', 'Улаанбаатар хотод 5G сүлжээ албан ёсоор нэвтэрлээ.', '<p>Монголын мобиком компани 5G сүлжээг Улаанбаатар хотод албан ёсоор нэвтрүүлж, хэрэглэгчдэд үйлчилж эхэллээ.</p>', NULL, NULL, NULL, 5, 1, NULL, 'published', 1, 1, 0, 18700, NULL, '2026-04-09 13:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(52, 'E-Mongolia платформ шинэчлэгдлээ', 'e-mongolia-platform-sineclegdlee', 'Цахим засаглалын E-Mongolia платформ шинэ хувилбараа танилцууллаа.', '<p>E-Mongolia цахим засаглалын платформ шинэ хувилбарт шилжиж, 1000 гаруй үйлчилгээг цахимаар үзүүлж байна.</p>', NULL, NULL, NULL, 5, 2, NULL, 'published', 0, 0, 0, 10500, NULL, '2026-04-09 12:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(53, 'Монголын финтек салбар хурдацтай өсч байна', 'mongolyn-fintek-salbar-xurdactai-osc-baina', 'Финтек компаниудын тоо сүүлийн жилд 2 дахин нэмэгджээ.', '<p>Монголын финтек салбарт үйл ажиллагаа явуулж буй компаниудын тоо сүүлийн нэг жилд 2 дахин өсч, 80 гаруй болжээ.</p>', NULL, NULL, NULL, 5, 3, NULL, 'published', 0, 0, 0, 7800, NULL, '2026-04-09 11:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(54, 'Кибер аюулгүй байдлын шинэ төв байгуулагдлаа', 'kiber-aiuulgui-baidlyn-sine-tov-baiguulagdlaa', 'Монголд кибер аюулгүй байдлын үндэсний төв байгуулагдан ажиллаж эхэллээ.', '<p>Кибер аюулгүй байдлын үндэсний төв байгуулагдаж, улсын хэмжээний мэдээллийн аюулгүй байдлыг хангах чиглэлээр ажиллаж эхэллээ.</p>', NULL, NULL, NULL, 5, 4, NULL, 'published', 0, 0, 0, 6200, NULL, '2026-04-09 09:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(55, 'Блокчэйн технологи засгийн газрын систем нэвтэрнэ', 'blokcein-texnologi-zasgiin-gazryn-sistem-nevterne', 'Засгийн газрын бүртгэлийн системд блокчэйн технологи нэвтрүүлнэ.', '<p>Засгийн газар газрын бүртгэлийн системд блокчэйн технологи нэвтрүүлэхээр шийдвэрлэж, туршилтын ажлыг эхлүүллээ.</p>', NULL, NULL, NULL, 5, 4, NULL, 'published', 0, 0, 0, 9100, NULL, '2026-04-09 07:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(56, 'Программ хөгжүүлэгчдийн тоо 10,000 давлаа', 'programm-xogzuulegcdiin-too-10000-davlaa', 'Монголд IT чиглэлийн мэргэжилтнүүдийн тоо хурдацтай өсч байна.', '<p>Монголд бүртгэлтэй программ хангамж хөгжүүлэгчдийн тоо 10,000 давж, IT салбар хүний нөөцөөр баяжиж байна.</p>', NULL, NULL, NULL, 5, 1, NULL, 'published', 0, 0, 0, 8300, NULL, '2026-04-09 05:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(57, 'Ухаалаг хотын төсөл хэрэгжиж байна', 'uxaalag-xotyn-tosol-xeregziz-baina', 'Улаанбаатар ухаалаг хот төслийн хүрээнд шинэ технологиуд нэвтэрч байна.', '<p>Улаанбаатар хотын ухаалаг хот төслийн хүрээнд замын гэрлэн дохио, камерын систем шинэчлэгдэж байна.</p>', NULL, NULL, NULL, 5, 3, NULL, 'published', 0, 0, 0, 5700, NULL, '2026-04-09 04:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(58, 'Монголын робот техникийн баг олон улсын тэмцээнд амжилт гаргалаа', 'mongolyn-robot-texnikiin-bag-olon-ulsyn-temceend-amzilt-gargalaa', 'Монголын робот техникийн баг олон улсын тэмцээнд шагнал хүртлээ.', '<p>Монголын оюутнуудын робот техникийн баг олон улсын робот техникийн олимпиадад мөнгөн медаль хүртлээ.</p>', NULL, NULL, NULL, 5, 3, NULL, 'published', 0, 0, 1, 7400, NULL, '2026-04-09 03:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(59, 'Цахим худалдааны зах зээл 1 тэрбум доллар давлаа', 'caxim-xudaldaany-zax-zeel-1-terbum-dollar-davlaa', 'Монголын цахим худалдааны зах зээлийн хэмжээ түүхэн рекорд тогтоолоо.', '<p>Монголын цахим худалдааны зах зээлийн хэмжээ 1 тэрбум ам.доллар давж, түүхэн дээд амжилт тогтоолоо.</p>', NULL, NULL, NULL, 5, 2, NULL, 'published', 1, 0, 0, 11600, NULL, '2026-04-09 02:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(60, 'Сансрын технологийн анхны Монгол хиймэл дагуул хөөргөлөө', 'sansryn-texnologiin-anxny-mongol-xiimel-daguul-xoorgoloo', 'Монголын анхны хиймэл дагуулыг сансарт амжилттай хөөрлөө.', '<p>\"MongolSat-1\" хиймэл дагуулыг сансарт амжилттай хөөргөж, Монгол Улс сансрын технологитой орнуудын эгнээнд нэгдлээ.</p>', NULL, NULL, NULL, 5, 4, NULL, 'published', 1, 1, 0, 25600, NULL, '2026-04-09 01:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(61, 'Монголын кино Каннын наадамд оролцоно', 'mongolyn-kino-kannyn-naadamd-orolcono', 'Монголын найруулагч Б.Баясгалангийн шинэ кино Каннын олон улсын кино наадмын хөтөлбөрт багтлаа.', '<p>Монголын найруулагч Б.Баясгалангийн \"Мөнх тэнгэр\" кино Каннын олон улсын кино наадмын албан ёсны хөтөлбөрт сонгогдлоо.</p>', NULL, NULL, NULL, 6, 2, NULL, 'published', 1, 0, 0, 7200, NULL, '2026-04-08 21:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(62, 'Хөөмий ЮНЕСКО-гийн соёлын өвд бүртгэгдлээ', 'xoomii-iunesko-giin-soelyn-ovd-burtgegdlee', 'Монголын хөөмий дуулах урлагийг ЮНЕСКО соёлын биет бус өвд бүртгэв.', '<p>Монголын хөөмий дуулах урлагийг ЮНЕСКО-гийн Хүн төрөлхтний соёлын биет бус өвийн жагсаалтад бүртгэлээ.</p>', NULL, NULL, NULL, 6, 4, NULL, 'published', 0, 0, 1, 15800, NULL, '2026-04-08 20:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(63, 'Үндэсний музейн шинэ барилга нээгдлээ', 'undesnii-muzein-sine-barilga-neegdlee', 'Монголын үндэсний музейн шинэ байр албан ёсоор нээгдлээ.', '<p>Монголын үндэсний музейн шинэ орчин үеийн байр ашиглалтад орж, олон нийтэд нээлтээ хийлээ.</p>', NULL, NULL, NULL, 6, 3, NULL, 'published', 1, 0, 0, 11400, NULL, '2026-04-08 17:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(64, 'Монголын зураач Венецийн биеннальд оролцов', 'mongolyn-zuraac-veneciin-biennald-orolcov', 'Монголын зураач Э.Энхболд Венецийн биеннальд бүтээлээ танилцуулав.', '<p>Монголын зураач Э.Энхболд Венецийн олон улсын урлагийн биеннальд бүтээлээ амжилттай танилцууллаа.</p>', NULL, NULL, NULL, 6, 2, NULL, 'published', 0, 0, 0, 6300, NULL, '2026-04-08 13:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(65, 'Морин хуурын олон улсын наадам болно', 'morin-xuuryn-olon-ulsyn-naadam-bolno', 'Морин хуурын олон улсын анхны наадам Улаанбаатарт зохион байгуулагдана.', '<p>Морин хуурчдын олон улсын анхны наадмыг Улаанбаатарт зохион байгуулахаар бэлтгэж байна.</p>', NULL, NULL, NULL, 6, 2, NULL, 'published', 0, 0, 0, 8900, NULL, '2026-04-08 12:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(66, 'Монголын ном Английн шилдэг номын жагсаалтад оров', 'mongolyn-nom-angliin-sildeg-nomyn-zagsaaltad-orov', 'Монголын зохиолч Б. Лхагвасүрэнгийн ном New York Times шилдэг номд оров.', '<p>Монголын зохиолч Б. Лхагвасүрэнгийн англи хэлнээ орчуулагдсан ном New York Times бестселлерийн жагсаалтад оржээ.</p>', NULL, NULL, NULL, 6, 1, NULL, 'published', 0, 0, 1, 13500, NULL, '2026-04-08 08:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(67, 'Наадмын соёлын арга хэмжээний хөтөлбөр гарлаа', 'naadmyn-soelyn-arga-xemzeenii-xotolbor-garlaa', 'Энэ оны Наадмын соёлын арга хэмжээний хөтөлбөр танилцуулагдлаа.', '<p>2026 оны Үндэсний их баяр Наадмын соёл урлагийн арга хэмжээний хөтөлбөрийг Нийслэлийн соёлын газар танилцуулав.</p>', NULL, NULL, NULL, 6, 1, NULL, 'published', 0, 0, 0, 10201, NULL, '2026-04-08 04:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-20 16:50:55', NULL),
(68, 'Монголын дуучин Азийн шагнал хүртлээ', 'mongolyn-duucin-aziin-sagnal-xurtlee', 'Монголын дуучин Б.Одгэрэл Азийн хөгжмийн шагнал хүртэв.', '<p>Монголын дуучин Б.Одгэрэл Азийн хөгжмийн шагнал (AMA) тэмцээнд шилдэг дуучнаар шалгарлаа.</p>', NULL, NULL, NULL, 6, 2, NULL, 'published', 1, 0, 0, 9700, NULL, '2026-04-08 00:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(69, 'Археологийн шинэ нээлт: Эртний хот олджээ', 'arxeologiin-sine-neelt-ertnii-xot-oldzee', 'Монголын говьд эртний хотын туурь олдожээ.', '<p>Говь-Алтай аймагт археологийн судалгааны явцад 13-р зууны үеийн хотын туурь олдсон байна.</p>', NULL, NULL, NULL, 6, 4, NULL, 'published', 0, 0, 1, 14300, NULL, '2026-04-07 21:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(70, 'Монголын уран бичлэгийн үзэсгэлэн нээгдлээ', 'mongolyn-uran-biclegiin-uzesgelen-neegdlee', 'Монгол бичгийн уран бичлэгийн үзэсгэлэн нээлтээ хийлээ.', '<p>Монгол бичгийн уран бичлэгийн үзэсгэлэн Үндэсний музейд нээлтээ хийж, 100 гаруй бүтээл дэлгэгдэж байна.</p>', NULL, NULL, NULL, 6, 1, NULL, 'published', 0, 0, 0, 5800, NULL, '2026-04-07 17:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(71, 'Кино фестиваль амжилттай зохион байгуулагдлаа', 'kino-festival-amzilttai-zoxion-baiguulagdlaa', 'Улаанбаатар олон улсын кино наадам амжилттай болж өндөрлөлөө.', '<p>Улаанбаатар олон улсын кино наадамд 30 гаруй орны 200 кино оролцож, Монголын кино тусгай шагнал хүртлээ.</p>', NULL, NULL, NULL, 6, 2, NULL, 'published', 0, 0, 0, 7500, NULL, '2026-04-07 13:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(72, 'Соёлын өвийг хамгаалах шинэ хууль хэрэгжиж эхэллээ', 'soelyn-oviig-xamgaalax-sine-xuul-xeregziz-exellee', 'Түүх соёлын өвийг хамгаалах шинэ хууль хэрэгжиж эхэллээ.', '<p>Түүх соёлын дурсгалт зүйлийг хамгаалах тухай хуулийн шинэчилсэн найруулга хэрэгжиж эхэлсэн байна.</p>', NULL, NULL, NULL, 6, 4, NULL, 'published', 0, 0, 0, 4900, NULL, '2026-04-07 09:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(73, 'AI технологи Монголын боловсролд нэвтэрч байна', 'ai-texnologi-mongolyn-bolovsrold-nevterc-baina', 'Хиймэл оюун ухаан ашигласан сургалтын платформууд Монголын их дээд сургуулиудад нэвтэрч эхэллээ.', '<p>Монголын их дээд сургуулиудад хиймэл оюун ухаан дээр суурилсан сургалтын платформууд нэвтэрч эхэллээ.</p>', NULL, NULL, NULL, 7, 1, NULL, 'published', 1, 0, 0, 6700, NULL, '2026-04-07 05:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(74, 'МУИС дэлхийн шилдэг 500 их сургуулийн жагсаалтад оров', 'muis-delxiin-sildeg-500-ix-surguuliin-zagsaaltad-orov', 'МУИС дэлхийн их сургуулиудын жагсаалтад анх удаа оржээ.', '<p>Монгол Улсын Их Сургууль QS дэлхийн их сургуулиудын жагсаалтад анх удаа шилдэг 500-д оролоо.</p>', NULL, NULL, NULL, 7, 1, NULL, 'published', 1, 0, 1, 14200, NULL, '2026-04-07 01:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(75, 'Тэтгэлэгт хөтөлбөрт 2000 оюутан хамрагдлаа', 'tetgelegt-xotolbort-2000-oiuutan-xamragdlaa', 'Засгийн газрын тэтгэлэгт хөтөлбөрт 2000 оюутан шинээр хамрагдлаа.', '<p>Засгийн газрын тэтгэлэгт хөтөлбөрөөр гадаадын нэр хүндтэй их сургуулиудад 2000 оюутан суралцаж эхэллээ.</p>', NULL, NULL, NULL, 7, 2, NULL, 'published', 0, 0, 0, 9800, NULL, '2026-04-06 22:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(76, 'Сургуулийн өмнөх боловсрол шинэчлэгдлээ', 'surguuliin-omnox-bolovsrol-sineclegdlee', 'Сургуулийн өмнөх боловсролын стандарт шинэчлэгдлээ.', '<p>Боловсролын яамнаас сургуулийн өмнөх боловсролын шинэ стандартыг баталж, хэрэгжүүлж эхэллээ.</p>', NULL, NULL, NULL, 7, 2, NULL, 'published', 0, 0, 0, 5400, NULL, '2026-04-06 19:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(77, 'Мэргэжлийн боловсролын төв нээгдлээ', 'mergezliin-bolovsrolyn-tov-neegdlee', 'Шинэ мэргэжлийн боловсрол, сургалтын төв ашиглалтад орлоо.', '<p>Олон улсын стандартад нийцсэн шинэ мэргэжлийн боловсрол, сургалтын төв Дархан-Уул аймагт нээгдлээ.</p>', NULL, NULL, NULL, 7, 3, NULL, 'published', 0, 0, 0, 6100, NULL, '2026-04-06 15:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(78, 'Цахим сургалтын платформ 100,000 хэрэглэгчтэй боллоо', 'caxim-surgaltyn-platform-100000-xereglegctei-bolloo', 'Монголын цахим сургалтын платформ хэрэглэгчдийн тоогоор рекорд тогтоолоо.', '<p>\"EduMN\" цахим сургалтын платформын бүртгэлтэй хэрэглэгчдийн тоо 100,000 давлаа.</p>', NULL, NULL, NULL, 7, 4, NULL, 'published', 0, 0, 1, 8200, NULL, '2026-04-06 11:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(79, 'Монголын сурагчид олон улсын математикийн олимпиадад медаль хүртлээ', 'mongolyn-suragcid-olon-ulsyn-matematikiin-olimpiadad-medal-xurtlee', 'Монголын сурагчид олон улсын математикийн олимпиадад 3 медаль хүртлээ.', '<p>Монголын багийн 6 гишүүнээс 3 нь олон улсын математикийн олимпиадад хүрэл медаль хүртэж, сайн амжилт гаргалаа.</p>', NULL, NULL, NULL, 7, 2, NULL, 'published', 1, 0, 0, 11500, NULL, '2026-04-06 10:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(80, 'Багш нарын цалин 30 хувиар нэмэгдлээ', 'bags-naryn-calin-30-xuviar-nemegdlee', 'Ерөнхий боловсролын сургуулийн багш нарын цалинг нэмэгдүүллээ.', '<p>Засгийн газрын шийдвэрээр ерөнхий боловсролын сургуулийн багш нарын цалинг 30 хувиар нэмэгдүүлсэн байна.</p>', NULL, NULL, NULL, 7, 3, NULL, 'published', 0, 0, 1, 16300, NULL, '2026-04-06 08:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(81, 'Англи хэлний сургалтын шинэ хөтөлбөр нэвтэрлээ', 'angli-xelnii-surgaltyn-sine-xotolbor-nevterlee', 'Бүх шатны сургуульд англи хэлний сургалтын шинэ хөтөлбөр нэвтэрлээ.', '<p>Бүх шатны ерөнхий боловсролын сургуульд англи хэлний сургалтын олон улсын шинэ хөтөлбөр нэвтэрлээ.</p>', NULL, NULL, NULL, 7, 4, NULL, 'published', 0, 0, 0, 7600, NULL, '2026-04-06 06:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(82, 'Номын сангийн сүлжээ өргөжлөө', 'nomyn-sangiin-sulzee-orgozloo', 'Улсын хэмжээнд 50 шинэ номын сан нээгдлээ.', '<p>Боловсролын яамны хөтөлбөрөөр улсын хэмжээнд 50 шинэ орчин үеийн номын сан ашиглалтад оржээ.</p>', NULL, NULL, NULL, 7, 1, NULL, 'published', 0, 0, 0, 4800, NULL, '2026-04-06 02:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(83, 'Оюутны дотуур байрны нөхцөл сайжирлаа', 'oiuutny-dotuur-bairny-noxcol-saizirlaa', 'Их дээд сургуулиудын дотуур байр шинэчлэгдлээ.', '<p>Засгийн газрын хөрөнгө оруулалтаар 10 их дээд сургуулийн дотуур байрыг шинэчилж, нөхцлийг сайжруулав.</p>', NULL, NULL, NULL, 7, 3, NULL, 'published', 0, 0, 0, 5200, NULL, '2026-04-05 23:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(84, 'STEM боловсролын хөтөлбөр бүх сургуульд нэвтэрлээ', 'stem-bolovsrolyn-xotolbor-bux-surguuld-nevterlee', 'STEM чиглэлийн сургалтын хөтөлбөр бүх ерөнхий боловсролын сургуульд хүрлээ.', '<p>STEM (Шинжлэх ухаан, Технологи, Инженерчлэл, Математик) боловсролын хөтөлбөр бүх сургуульд амжилттай нэвтэрлээ.</p>', NULL, NULL, NULL, 7, 3, NULL, 'published', 1, 0, 0, 9900, NULL, '2026-04-05 22:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(85, 'Эрүүл мэндийн шинэ даатгалын тогтолцоо нэвтэрнэ', 'eruul-mendiin-sine-daatgalyn-togtolcoo-nevterne', '2026 оноос эхлэн эрүүл мэндийн даатгалын шинэ тогтолцоо хэрэгжиж эхэлнэ.', '<p>Засгийн газраас эрүүл мэндийн даатгалын шинэ тогтолцоог 2026 оноос эхлэн нэвтрүүлэхээр болсон.</p>', NULL, NULL, NULL, 8, 3, NULL, 'published', 1, 0, 0, 5400, NULL, '2026-04-05 21:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(86, 'Шинэ эмнэлэг ашиглалтад орлоо', 'sine-emneleg-asiglaltad-orloo', 'Улаанбаатарт 500 ортой шинэ эмнэлэг ашиглалтад орлоо.', '<p>Улаанбаатар хотод 500 ортой олон улсын стандартад нийцсэн шинэ эмнэлэг ашиглалтад оржээ.</p>', NULL, NULL, NULL, 8, 1, NULL, 'published', 1, 0, 0, 12600, NULL, '2026-04-05 20:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(87, 'Хорт хавдрын эсрэг шинэ эмчилгээ нэвтэрлээ', 'xort-xavdryn-esreg-sine-emcilgee-nevterlee', 'Монголд хорт хавдрын эсрэг шинэ эмчилгээний арга нэвтэрлээ.', '<p>Үндэсний хавдрын төвд хорт хавдрын эсрэг олон улсын шинэ иммунотерапийн эмчилгээг нэвтрүүлж эхэллээ.</p>', NULL, NULL, NULL, 8, 3, NULL, 'published', 0, 0, 1, 14800, NULL, '2026-04-05 18:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(88, 'Хүүхдийн вакцинжуулалтын хамрагдалт 95 хувьд хүрлээ', 'xuuxdiin-vakcinzuulaltyn-xamragdalt-95-xuvd-xurlee', 'Хүүхдийн вакцинжуулалтын хамрагдалт түүхэн дээд түвшинд хүрлээ.', '<p>Монгол Улсын хүүхдийн вакцинжуулалтын хамрагдалт 95 хувьд хүрч, ДЭМБ-ын стандартыг хангалаа.</p>', NULL, NULL, NULL, 8, 1, NULL, 'published', 0, 0, 0, 8200, NULL, '2026-04-05 15:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(89, 'Сэтгэцийн эрүүл мэндийн үйлчилгээ сайжирч байна', 'setgeciin-eruul-mendiin-uilcilgee-saizirc-baina', 'Сэтгэцийн эрүүл мэндийн үйлчилгээний хүртээмж нэмэгджээ.', '<p>Сэтгэцийн эрүүл мэндийн тусламжийн үйлчилгээг бүх аймагт бий болгож, мэргэжилтнүүдийн тоо нэмэгдлээ.</p>', NULL, NULL, NULL, 8, 2, NULL, 'published', 0, 0, 0, 6700, NULL, '2026-04-05 11:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(90, 'Цахим эрүүл мэндийн карт нэвтэрлээ', 'caxim-eruul-mendiin-kart-nevterlee', 'Иргэн бүр цахим эрүүл мэндийн карттай болно.', '<p>Эрүүл мэндийн яамнаас иргэн бүрт цахим эрүүл мэндийн карт олгож, эмнэлгийн бүртгэлийг нэгтгэж байна.</p>', NULL, NULL, NULL, 8, 2, NULL, 'published', 0, 0, 0, 9500, NULL, '2026-04-05 09:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(91, 'Монголд робот мэс засал нэвтэрлээ', 'mongold-robot-mes-zasal-nevterlee', 'Анхны робот мэс заслыг Монголд амжилттай хийлээ.', '<p>Монголын зүрхний төвийн эмч нар робот ашигласан мэс заслыг анх удаа амжилттай хийж гүйцэтгэлээ.</p>', NULL, NULL, NULL, 8, 1, NULL, 'published', 1, 0, 1, 17200, NULL, '2026-04-05 07:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(92, 'Уламжлалт анагаах ухааны төв нээгдлээ', 'ulamzlalt-anagaax-uxaany-tov-neegdlee', 'Монголын уламжлалт анагаах ухааны шинэ төв ашиглалтад орлоо.', '<p>Монголын уламжлалт анагаах ухааны олон улсын судалгааны шинэ төв Улаанбаатарт нээгдлээ.</p>', NULL, NULL, NULL, 8, 1, NULL, 'published', 0, 0, 0, 7100, NULL, '2026-04-05 05:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(93, 'Агаарын бохирдлоос үүдэлтэй өвчлөл буурлаа', 'agaaryn-boxirdloos-uudeltei-ovclol-buurlaa', 'Агаарын чанар сайжирсантай холбоотой амьсгалын замын өвчлөл буурсан байна.', '<p>Агаарын бохирдол буурсантай холбоотойгоор амьсгалын замын өвчний тохиолдол 25 хувиар буурсан гэж НЭМГ мэдээлэв.</p>', NULL, NULL, NULL, 8, 3, NULL, 'published', 0, 0, 0, 8800, NULL, '2026-04-05 04:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(94, 'Эрүүл мэндийн салбарт 2000 шинэ ажлын байр бий боллоо', 'eruul-mendiin-salbart-2000-sine-azlyn-bair-bii-bolloo', 'Эрүүл мэндийн салбарт ажлын байр нэмэгдлээ.', '<p>Шинэ эмнэлгүүд ашиглалтад орсонтой холбоотой эрүүл мэндийн салбарт 2000 шинэ ажлын байр бий болжээ.</p>', NULL, NULL, NULL, 8, 3, NULL, 'published', 0, 0, 0, 5300, NULL, '2026-04-05 01:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(95, 'Хөдөө орон нутагт эмнэлгийн тусламж хүрч байна', 'xodoo-oron-nutagt-emnelgiin-tuslamz-xurc-baina', 'Хөдөө орон нутагт явуулын эмнэлгийн үйлчилгээг өргөжүүллээ.', '<p>Хөдөө орон нутагт явуулын эмнэлгийн үйлчилгээг өргөжүүлж, 50 шинэ машин ажиллаж эхэллээ.</p>', NULL, NULL, NULL, 8, 2, NULL, 'published', 0, 0, 0, 6100, NULL, '2026-04-05 00:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(96, 'Эмийн үнэ буурах шинэ бодлого хэрэгжинэ', 'emiin-une-buurax-sine-bodlogo-xeregzine', 'Засгийн газраас эмийн үнийг бууруулах бодлого хэрэгжүүлж эхэллээ.', '<p>Засгийн газраас эмийн үнийг бууруулах зорилгоор дотоодын эм үйлдвэрлэлийг дэмжих бодлого хэрэгжүүлж эхэллээ.</p>', NULL, NULL, NULL, 8, 4, NULL, 'published', 0, 0, 0, 10400, NULL, '2026-04-04 23:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(97, 'Дэлхийн цаг уурын өөрчлөлтийн бага хурал эхэллээ', 'delxiin-cag-uuryn-oorcloltiin-baga-xural-exellee', 'НҮБ-ын цаг уурын өөрчлөлтийн бага хурал энэ долоо хоногт эхэлж байна.', '<p>НҮБ-ын цаг уурын өөрчлөлтийн талаарх дараагийн бага хурал Женевт эхэлж байна.</p>', NULL, NULL, NULL, 9, 1, NULL, 'published', 1, 0, 0, 4100, NULL, '2026-04-04 20:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(98, 'АНУ-Хятадын худалдааны хэлэлцээр амжилттай болов', 'anu-xiatadyn-xudaldaany-xelelceer-amzilttai-bolov', 'АНУ, Хятадын хооронд худалдааны шинэ хэлэлцээр байгуулагдлаа.', '<p>АНУ, Хятадын хооронд худалдааны шинэ хэлэлцээр байгуулагдаж, гаалийн тарифыг бууруулахаар тохиролцов.</p>', NULL, NULL, NULL, 9, 2, NULL, 'published', 0, 0, 1, 11200, NULL, '2026-04-04 18:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(99, 'Европын холбоо AI-ийн зохицуулалтын хууль батлав', 'evropyn-xolboo-ai-iin-zoxicuulaltyn-xuul-batlav', 'ЕХ хиймэл оюун ухааны зохицуулалтын хуулийг батлан гаргалаа.', '<p>Европын холбоо хиймэл оюун ухааны зохицуулалтын дэлхийн анхны иж бүрэн хуулийг батлан, хэрэгжүүлж эхэллээ.</p>', NULL, NULL, NULL, 9, 1, NULL, 'published', 1, 0, 0, 9800, NULL, '2026-04-04 14:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(100, 'Сарны суурин нээгдлээ', 'sarny-suurin-neegdlee', 'NASA болон олон улсын сансрын байгууллагууд сарны суурин ашиглалтад орууллаа.', '<p>NASA, ESA хамтран сарны гадаргуу дээр байнгын судалгааны суурин байгуулж, ашиглалтад оруулав.</p>', NULL, NULL, NULL, 9, 3, NULL, 'published', 0, 1, 0, 22500, NULL, '2026-04-04 11:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(101, 'Африкийн холбоо НҮБ-ын Аюулгүйн зөвлөлд суудал авлаа', 'afrikiin-xolboo-nub-yn-aiuulguin-zovlold-suudal-avlaa', 'Африкийн холбоо НҮБ-ын Аюулгүйн зөвлөлд байнгын суудалтай болов.', '<p>Олон жилийн хэлэлцээрийн дүнд Африкийн холбоо НҮБ-ын Аюулгүйн зөвлөлд байнгын суудал авахаар боллоо.</p>', NULL, NULL, NULL, 9, 3, NULL, 'published', 0, 0, 0, 7600, NULL, '2026-04-04 09:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(102, 'Дэлхийн эдийн засаг 3.5 хувиар өсөх төлөвтэй', 'delxiin-ediin-zasag-35-xuviar-osox-tolovtei', 'ОУВС дэлхийн эдийн засгийн өсөлтийн төлөвийг тодорхойлов.', '<p>Олон улсын валютын сангаас дэлхийн эдийн засаг 2026 онд 3.5 хувиар өсөх төлөвтэй гэж мэдээлэв.</p>', NULL, NULL, NULL, 9, 3, NULL, 'published', 0, 0, 0, 8400, NULL, '2026-04-04 07:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(103, 'Их Британи ЕХ-той шинэ худалдааны гэрээ байгуулав', 'ix-britani-ex-toi-sine-xudaldaany-geree-baiguulav', 'Брексит-ийн дараах шинэ худалдааны гэрээ байгуулагдлаа.', '<p>Их Британи Европын холбоотой шинэ худалдааны гэрээ байгуулж, хоёр талын харилцаа шинэ шатанд гарлаа.</p>', NULL, NULL, NULL, 9, 4, NULL, 'published', 0, 0, 0, 6200, NULL, '2026-04-04 06:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(104, 'Энэтхэг дэлхийн 3 дахь том эдийн засаг боллоо', 'enetxeg-delxiin-3-dax-tom-ediin-zasag-bolloo', 'Энэтхэг Японыг гүйцэж, дэлхийн 3 дахь том эдийн засагтай орон боллоо.', '<p>Энэтхэг ДНБ-ээрээ Японыг гүйцэж, АНУ, БНХАУ-ын дараа дэлхийн 3 дахь том эдийн засагтай орон боллоо.</p>', NULL, NULL, NULL, 9, 4, NULL, 'published', 0, 0, 1, 10100, NULL, '2026-04-04 03:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(105, 'Дэлхийн хүн ам 8.5 тэрбумд хүрлээ', 'delxiin-xun-am-85-terbumd-xurlee', 'НҮБ-ын мэдээгээр дэлхийн хүн ам 8.5 тэрбумд хүрсэн байна.', '<p>НҮБ-ын хүн амын сангийн мэдээгээр дэлхийн хүн ам 8.5 тэрбумд хүрч, хүн ам зүйн шинэ сорилтуудыг бий болгож байна.</p>', NULL, NULL, NULL, 9, 2, NULL, 'published', 0, 0, 0, 7800, NULL, '2026-04-04 01:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(106, 'Олон улсын сэргээгдэх эрчим хүчний хөрөнгө оруулалт нэмэгдлээ', 'olon-ulsyn-sergeegdex-ercim-xucnii-xorongo-oruulalt-nemegdlee', 'Сэргээгдэх эрчим хүчний хөрөнгө оруулалт түүхэн дээд түвшинд хүрлээ.', '<p>2026 онд дэлхий нийтийн сэргээгдэх эрчим хүчний хөрөнгө оруулалт 500 тэрбум ам.доллар давж, түүхэн рекорд тогтоолоо.</p>', NULL, NULL, NULL, 9, 1, NULL, 'published', 1, 0, 0, 8900, NULL, '2026-04-03 23:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(107, 'БНСУ-Хойд Солонгосын яриа хэлэлцээ сэргэлээ', 'bnsu-xoid-solongosyn-iaria-xelelcee-sergelee', 'Хоёр Солонгосын хоорондын яриа хэлэлцээ дахин эхэлж байна.', '<p>БНСУ, БНАСАУ-ын хооронд дипломат яриа хэлэлцээ олон жилийн завсарлагааны дараа дахин эхэлж байна.</p>', NULL, NULL, NULL, 9, 3, NULL, 'published', 0, 0, 0, 9500, NULL, '2026-04-03 19:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL);
INSERT INTO `articles` (`id`, `title`, `slug`, `excerpt`, `body`, `featured_image`, `featured_video`, `gallery`, `category_id`, `author_id`, `user_id`, `status`, `is_featured`, `is_breaking`, `is_trending`, `views_count`, `reading_time`, `published_at`, `scheduled_at`, `meta`, `seo_title`, `seo_description`, `canonical_url`, `og_image`, `source_name`, `source_url`, `created_at`, `updated_at`, `deleted_at`) VALUES
(108, 'Дэлхийн анхны цөмийн нэгдлийн цахилгаан станц баригдаж байна', 'delxiin-anxny-comiin-negdliin-caxilgaan-stanc-barigdaz-baina', 'Францад дэлхийн анхны цөмийн нэгдлийн цахилгаан станцыг барьж байна.', '<p>Францын Кадараш хотод ITER төслийн хүрээнд дэлхийн анхны цөмийн нэгдлийн цахилгаан станцын барилга ажил үргэлжилж байна.</p>', NULL, NULL, NULL, 9, 2, NULL, 'published', 0, 0, 1, 13400, NULL, '2026-04-03 18:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:11', '2026-04-14 16:42:11', NULL),
(109, 'Наадмын нээлтийн ёслол: Бүрэн видео', 'naadmyn-neeltiin-eslol-buren-video', '2026 оны Наадмын нээлтийн ёслолын бүрэн бичлэг.', '<p>2026 оны Үндэсний их баяр Наадмын нээлтийн ёслолын бүрэн видео бичлэгийг хүргэж байна.</p>', NULL, NULL, NULL, 10, 2, NULL, 'published', 1, 0, 0, 45001, NULL, '2026-04-03 14:42:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:12', '2026-04-15 02:33:49', NULL),
(110, 'Ерөнхийлөгчийн мэдэгдлийн бүрэн бичлэг', 'eronxiilogciin-medegdliin-buren-bicleg', 'Монгол Улсын Ерөнхийлөгчийн үндэстэн дамнасан мэдэгдлийн бичлэг.', '<p>Монгол Улсын Ерөнхийлөгчийн үндэстэн дамнасан мэдэгдлийн бүрэн бичлэгийг хүргэж байна.</p>', NULL, NULL, NULL, 10, 4, NULL, 'published', 0, 1, 0, 32000, NULL, '2026-04-03 12:42:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:12', '2026-04-14 16:42:12', NULL),
(111, 'Монголын байгаль: Говийн тал нутаг', 'mongolyn-baigal-goviin-tal-nutag', 'Монголын говийн байгалийн үзэсгэлэнт дүр зургийг хүргэж байна.', '<p>Монголын говийн тал нутгийн байгалийн үзэсгэлэнт газруудын видео баримтат нэвтрүүлэг.</p>', NULL, NULL, NULL, 10, 4, NULL, 'published', 0, 0, 0, 18500, NULL, '2026-04-03 08:42:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:12', '2026-04-14 16:42:12', NULL),
(112, 'Метроны барилгын явцын видео тайлан', 'metrony-barilgyn-iavcyn-video-tailan', 'Улаанбаатарын метроны барилга ажлын явцын видео тайлан.', '<p>Улаанбаатар хотын метроны барилга ажлын явц, хэрэгжилтийн талаарх дэлгэрэнгүй видео тайланг хүргэж байна.</p>', NULL, NULL, NULL, 10, 4, NULL, 'published', 0, 0, 1, 14200, NULL, '2026-04-03 04:42:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:12', '2026-04-14 16:42:12', NULL),
(113, 'Олимпийн алтан медалист боксчинтай ярилцлага', 'olimpiin-altan-medalist-bokscintai-iarilclaga', 'Олимпийн аварга Н. Баатарсүхтэй хийсэн тусгай ярилцлага.', '<p>Олимпийн алтан медалист Н. Баатарсүхтэй хийсэн онцгой ярилцлагын бүрэн бичлэг.</p>', NULL, NULL, NULL, 10, 4, NULL, 'published', 1, 0, 0, 27300, NULL, '2026-04-03 02:42:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:12', '2026-04-14 16:42:12', NULL),
(114, 'УИХ-ын чуулганы шууд дамжуулалт', 'uix-yn-cuulgany-suud-damzuulalt', 'УИХ-ын намрын чуулганы нэгдсэн хуралдааны бичлэг.', '<p>УИХ-ын намрын чуулганы нэгдсэн хуралдааны шууд дамжуулалтын бичлэг.</p>', NULL, NULL, NULL, 10, 3, NULL, 'published', 0, 0, 0, 11800, NULL, '2026-04-02 23:42:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:12', '2026-04-14 16:42:12', NULL),
(115, 'Оюу толгой далд уурхай: Дотроос нь харуулав', 'oiuu-tolgoi-dald-uurxai-dotroos-n-xaruulav', 'Оюу толгойн далд уурхайн дотор талыг анх удаа камерт буулгалаа.', '<p>Оюу толгойн далд уурхайн дотор талыг анх удаа камерт буулгаж, олон нийтэд хүргэж байна.</p>', NULL, NULL, NULL, 10, 1, NULL, 'published', 0, 0, 1, 21500, NULL, '2026-04-02 19:42:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:12', '2026-04-14 16:42:12', NULL),
(116, '5G сүлжээний нэвтрүүлэх ёслолын бичлэг', '5g-sulzeenii-nevtruulex-eslolyn-bicleg', '5G сүлжээг албан ёсоор нэвтрүүлсэн ёслолын бичлэг.', '<p>Монголд 5G сүлжээг албан ёсоор нэвтрүүлсэн ёслолын бүрэн бичлэгийг хүргэж байна.</p>', NULL, NULL, NULL, 10, 4, NULL, 'published', 0, 0, 0, 9600, NULL, '2026-04-02 15:42:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:12', '2026-04-14 16:42:12', NULL),
(117, 'Монгол бөхийн аварга шалгаруулах тэмцээн', 'mongol-boxiin-avarga-salgaruulax-temceen', 'Монголын үндэсний бөхийн аварга шалгаруулах тэмцээний бичлэг.', '<p>Монголын үндэсний бөхийн аварга шалгаруулах тэмцээний шилдэг мөчүүдийн тойм бичлэг.</p>', NULL, NULL, NULL, 10, 3, NULL, 'published', 1, 0, 0, 16700, NULL, '2026-04-02 14:42:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:12', '2026-04-14 16:42:12', NULL),
(118, 'Хөвсгөл нуурын аялалын видео гарын авлага', 'xovsgol-nuuryn-aialalyn-video-garyn-avlaga', 'Хөвсгөл нуурын аялалын бүрэн видео гарын авлага.', '<p>Хөвсгөл нуурын аялалын талаарх бүрэн дэлгэрэнгүй видео гарын авлагыг хүргэж байна.</p>', NULL, NULL, NULL, 10, 4, NULL, 'published', 0, 0, 0, 13400, NULL, '2026-04-02 11:42:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:12', '2026-04-14 16:42:12', NULL),
(119, 'Шинэ нисэх буудлын танилцуулга видео', 'sine-nisex-buudlyn-tanilcuulga-video', 'Чингис хаан олон улсын шинэ нисэх буудлын танилцуулга.', '<p>Чингис хаан олон улсын шинэ нисэх буудлын бүрэн танилцуулга видеог хүргэж байна.</p>', NULL, NULL, NULL, 10, 4, NULL, 'published', 0, 0, 0, 19800, NULL, '2026-04-02 09:42:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:12', '2026-04-14 16:42:12', NULL),
(120, 'Монголын робот олимпиадын шилдэг мөчүүд', 'mongolyn-robot-olimpiadyn-sildeg-mocuud', 'Олон улсын робот олимпиадад Монголын баг оролцсон бичлэг.', '<p>Олон улсын робот олимпиадад Монголын багийн оролцоо, шилдэг мөчүүдийн тойм бичлэг.</p>', NULL, NULL, NULL, 10, 4, NULL, 'published', 0, 0, 1, 8200, NULL, '2026-04-02 08:42:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 16:42:12', '2026-04-14 16:42:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `article_revisions`
--

DROP TABLE IF EXISTS `article_revisions`;
CREATE TABLE IF NOT EXISTS `article_revisions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `snapshot` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_revisions_user_id_foreign` (`user_id`),
  KEY `article_revisions_article_id_created_at_index` (`article_id`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

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
) ENGINE=InnoDB AUTO_INCREMENT=346 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `article_tag`
--

INSERT INTO `article_tag` (`id`, `article_id`, `tag_id`) VALUES
(1, 1, 2),
(2, 1, 6),
(3, 1, 10),
(4, 1, 12),
(5, 2, 1),
(6, 2, 11),
(7, 3, 2),
(8, 3, 8),
(9, 4, 9),
(10, 4, 14),
(11, 5, 7),
(12, 5, 10),
(13, 6, 2),
(14, 6, 6),
(15, 6, 14),
(16, 6, 15),
(17, 7, 9),
(18, 7, 10),
(19, 7, 14),
(20, 8, 5),
(21, 8, 6),
(22, 8, 7),
(23, 8, 15),
(24, 9, 2),
(25, 9, 11),
(26, 9, 15),
(27, 10, 2),
(28, 10, 14),
(29, 10, 15),
(30, 11, 1),
(31, 11, 2),
(32, 11, 3),
(33, 11, 9),
(34, 12, 4),
(35, 12, 6),
(36, 13, 3),
(37, 13, 8),
(38, 13, 13),
(39, 13, 15),
(40, 14, 2),
(41, 14, 6),
(42, 14, 8),
(43, 15, 5),
(44, 15, 6),
(45, 16, 2),
(46, 16, 3),
(47, 16, 15),
(48, 17, 4),
(49, 17, 8),
(50, 17, 10),
(51, 17, 12),
(52, 18, 8),
(53, 18, 9),
(54, 19, 7),
(55, 19, 9),
(56, 20, 3),
(57, 20, 5),
(58, 20, 12),
(59, 21, 2),
(60, 21, 3),
(61, 21, 14),
(62, 22, 2),
(63, 22, 8),
(64, 23, 3),
(65, 23, 7),
(66, 23, 13),
(67, 24, 2),
(68, 24, 5),
(69, 24, 10),
(70, 24, 11),
(71, 25, 3),
(72, 25, 4),
(73, 26, 4),
(74, 26, 6),
(75, 26, 10),
(76, 27, 1),
(77, 27, 8),
(78, 28, 10),
(79, 28, 13),
(80, 29, 5),
(81, 29, 11),
(82, 29, 12),
(83, 30, 7),
(84, 30, 9),
(85, 31, 13),
(86, 31, 14),
(87, 32, 7),
(88, 32, 11),
(89, 33, 1),
(90, 33, 6),
(91, 34, 4),
(92, 34, 6),
(93, 34, 7),
(94, 34, 13),
(95, 35, 1),
(96, 35, 3),
(97, 35, 10),
(98, 36, 8),
(99, 36, 11),
(100, 37, 10),
(101, 37, 12),
(102, 38, 6),
(103, 38, 10),
(104, 38, 11),
(105, 38, 14),
(106, 39, 5),
(107, 39, 14),
(108, 39, 15),
(109, 40, 2),
(110, 40, 5),
(111, 40, 10),
(112, 41, 10),
(113, 41, 11),
(114, 42, 10),
(115, 42, 11),
(116, 42, 13),
(117, 43, 4),
(118, 43, 7),
(119, 43, 13),
(120, 44, 1),
(121, 44, 3),
(122, 44, 13),
(123, 44, 15),
(124, 45, 1),
(125, 45, 2),
(126, 46, 2),
(127, 46, 3),
(128, 46, 13),
(129, 47, 3),
(130, 47, 6),
(131, 48, 1),
(132, 48, 6),
(133, 48, 12),
(134, 49, 3),
(135, 49, 4),
(136, 49, 6),
(137, 49, 10),
(138, 50, 6),
(139, 50, 7),
(140, 50, 11),
(141, 50, 14),
(142, 51, 13),
(143, 51, 15),
(144, 52, 4),
(145, 52, 7),
(146, 52, 11),
(147, 53, 4),
(148, 53, 7),
(149, 53, 10),
(150, 53, 11),
(151, 54, 6),
(152, 54, 10),
(153, 55, 8),
(154, 55, 12),
(155, 55, 14),
(156, 56, 3),
(157, 56, 12),
(158, 57, 5),
(159, 57, 10),
(160, 58, 3),
(161, 58, 6),
(162, 58, 7),
(163, 59, 2),
(164, 59, 5),
(165, 59, 7),
(166, 60, 1),
(167, 60, 3),
(168, 60, 6),
(169, 60, 9),
(170, 61, 8),
(171, 61, 9),
(172, 62, 3),
(173, 62, 6),
(174, 62, 9),
(175, 63, 2),
(176, 63, 5),
(177, 63, 8),
(178, 63, 15),
(179, 64, 1),
(180, 64, 7),
(181, 65, 9),
(182, 65, 10),
(183, 66, 9),
(184, 66, 10),
(185, 67, 11),
(186, 67, 12),
(187, 68, 9),
(188, 68, 13),
(189, 69, 1),
(190, 69, 5),
(191, 69, 6),
(192, 69, 15),
(193, 70, 2),
(194, 70, 10),
(195, 70, 15),
(196, 71, 5),
(197, 71, 8),
(198, 71, 11),
(199, 71, 14),
(200, 72, 13),
(201, 72, 14),
(202, 72, 15),
(203, 73, 3),
(204, 73, 6),
(205, 73, 12),
(206, 74, 4),
(207, 74, 5),
(208, 74, 7),
(209, 75, 3),
(210, 75, 8),
(211, 75, 9),
(212, 76, 2),
(213, 76, 3),
(214, 76, 6),
(215, 76, 12),
(216, 77, 2),
(217, 77, 3),
(218, 78, 2),
(219, 78, 6),
(220, 78, 7),
(221, 79, 1),
(222, 79, 4),
(223, 79, 13),
(224, 80, 5),
(225, 80, 7),
(226, 80, 11),
(227, 80, 13),
(228, 81, 1),
(229, 81, 5),
(230, 81, 9),
(231, 81, 15),
(232, 82, 2),
(233, 82, 5),
(234, 82, 11),
(235, 82, 15),
(236, 83, 4),
(237, 83, 5),
(238, 83, 8),
(239, 84, 1),
(240, 84, 3),
(241, 84, 6),
(242, 84, 13),
(243, 85, 5),
(244, 85, 7),
(245, 85, 9),
(246, 85, 15),
(247, 86, 7),
(248, 86, 9),
(249, 87, 3),
(250, 87, 7),
(251, 87, 14),
(252, 87, 15),
(253, 88, 5),
(254, 88, 10),
(255, 88, 12),
(256, 89, 5),
(257, 89, 13),
(258, 89, 15),
(259, 90, 6),
(260, 90, 9),
(261, 91, 1),
(262, 91, 6),
(263, 91, 14),
(264, 91, 15),
(265, 92, 2),
(266, 92, 3),
(267, 92, 5),
(268, 92, 8),
(269, 93, 4),
(270, 93, 9),
(271, 93, 14),
(272, 94, 1),
(273, 94, 2),
(274, 95, 3),
(275, 95, 14),
(276, 96, 1),
(277, 96, 2),
(278, 96, 7),
(279, 96, 10),
(280, 97, 6),
(281, 97, 7),
(282, 97, 10),
(283, 98, 11),
(284, 98, 12),
(285, 99, 5),
(286, 99, 11),
(287, 100, 7),
(288, 100, 8),
(289, 100, 12),
(290, 100, 13),
(291, 101, 5),
(292, 101, 8),
(293, 102, 3),
(294, 102, 4),
(295, 102, 13),
(296, 102, 15),
(297, 103, 1),
(298, 103, 13),
(299, 104, 4),
(300, 104, 5),
(301, 104, 15),
(302, 105, 3),
(303, 105, 10),
(304, 106, 2),
(305, 106, 3),
(306, 106, 7),
(307, 106, 10),
(308, 107, 14),
(309, 107, 15),
(310, 108, 3),
(311, 108, 10),
(312, 109, 2),
(313, 109, 3),
(314, 109, 14),
(315, 109, 15),
(316, 110, 3),
(317, 110, 12),
(318, 110, 15),
(319, 111, 2),
(320, 111, 8),
(321, 111, 14),
(322, 111, 15),
(323, 112, 1),
(324, 112, 12),
(325, 112, 15),
(326, 113, 6),
(327, 113, 15),
(328, 114, 6),
(329, 114, 13),
(330, 115, 7),
(331, 115, 15),
(332, 116, 6),
(333, 116, 11),
(334, 116, 15),
(335, 117, 2),
(336, 117, 5),
(337, 117, 6),
(338, 117, 15),
(339, 118, 1),
(340, 118, 5),
(341, 118, 9),
(342, 119, 9),
(343, 119, 14),
(344, 120, 3),
(345, 120, 7);

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
(1, 1, 'Б. Болормаа', 'b-bolormaa', 'bolormaa@odod.mn', 'Улс төрийн мэдээний ахлах сэтгүүлч, 10 жилийн туршлагатай.', NULL, 'Ахлах сэтгүүлч', NULL, 1, '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(2, NULL, 'Д. Ганбаатар', 'd-ganbaatar', 'ganbaatar@odod.mn', 'Монголын спортын мэдээний мэргэжилтэн.', NULL, 'Спорт сэтгүүлч', NULL, 1, '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(3, NULL, 'С. Сарантуяа', 's-sarantuiaa', 'sarantuya@odod.mn', 'Технологи, инновацийн чиглэлийн сэтгүүлч.', NULL, 'Технологи сэтгүүлч', NULL, 1, '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(4, NULL, 'Т. Тэмүүлэн', 't-temuulen', 'temuulen@odod.mn', 'Эдийн засаг, санхүүгийн мэдээний шинжээч.', NULL, 'Эдийн засаг сэтгүүлч', NULL, 1, '2026-04-14 16:42:11', '2026-04-14 16:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `banned_ips`
--

DROP TABLE IF EXISTS `banned_ips`;
CREATE TABLE IF NOT EXISTS `banned_ips` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `banned_ips_ip_unique` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `breaking_alerts`
--

DROP TABLE IF EXISTS `breaking_alerts`;
CREATE TABLE IF NOT EXISTS `breaking_alerts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` bigint UNSIGNED DEFAULT NULL,
  `headline` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` enum('low','medium','high','urgent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `status` enum('draft','active','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `push_sent` tinyint(1) NOT NULL DEFAULT '0',
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `breaking_alerts_article_id_foreign` (`article_id`),
  KEY `breaking_alerts_user_id_foreign` (`user_id`),
  KEY `breaking_alerts_status_starts_at_index` (`status`,`starts_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

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
-- Table structure for table `campaign_recipients`
--

DROP TABLE IF EXISTS `campaign_recipients`;
CREATE TABLE IF NOT EXISTS `campaign_recipients` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `campaign_id` bigint UNSIGNED NOT NULL,
  `subscriber_id` bigint UNSIGNED NOT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `opened_at` timestamp NULL DEFAULT NULL,
  `clicked_at` timestamp NULL DEFAULT NULL,
  `tracking_token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `campaign_recipients_tracking_token_unique` (`tracking_token`),
  KEY `campaign_recipients_campaign_id_foreign` (`campaign_id`),
  KEY `campaign_recipients_subscriber_id_foreign` (`subscriber_id`)
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
(1, 'Улс төр', 'Politics', 'politics', NULL, '#EF4444', NULL, NULL, 1, 1, 1, '2026-04-14 16:42:10', '2026-04-14 16:42:10'),
(2, 'Эдийн засаг', 'Economy', 'economy', NULL, '#F59E0B', NULL, NULL, 2, 1, 1, '2026-04-14 16:42:10', '2026-04-14 16:42:10'),
(3, 'Нийгэм', 'Society', 'society', NULL, '#3B82F6', NULL, NULL, 3, 1, 1, '2026-04-14 16:42:10', '2026-04-14 16:42:10'),
(4, 'Спорт', 'Sports', 'sports', NULL, '#10B981', NULL, NULL, 4, 1, 1, '2026-04-14 16:42:10', '2026-04-14 16:42:10'),
(5, 'Технологи', 'Technology', 'technology', NULL, '#8B5CF6', NULL, NULL, 5, 1, 1, '2026-04-14 16:42:10', '2026-04-14 16:42:10'),
(6, 'Соёл урлаг', 'Culture', 'culture', NULL, '#EC4899', NULL, NULL, 6, 1, 1, '2026-04-14 16:42:10', '2026-04-14 16:42:10'),
(7, 'Боловсрол', 'Education', 'education', NULL, '#06B6D4', NULL, NULL, 7, 1, 1, '2026-04-14 16:42:10', '2026-04-14 16:42:10'),
(8, 'Эрүүл мэнд', 'Health', 'health', NULL, '#14B8A6', NULL, NULL, 8, 1, 1, '2026-04-14 16:42:10', '2026-04-14 16:42:10'),
(9, 'Дэлхий', 'World', 'world', NULL, '#6366F1', NULL, NULL, 9, 1, 1, '2026-04-14 16:42:10', '2026-04-14 16:42:10'),
(10, 'Видео', 'Video', 'video', NULL, '#F43F5E', NULL, NULL, 10, 1, 1, '2026-04-14 16:42:10', '2026-04-14 16:42:10');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `author_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected','spam') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_flagged` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_parent_id_foreign` (`parent_id`),
  KEY `comments_article_id_status_index` (`article_id`,`status`),
  KEY `comments_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

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
(11, '2026_04_15_000001_enhance_articles_table', 1),
(12, '2026_04_15_000002_create_uploads_table', 1),
(13, '2026_04_24_000001_build_admin_modules', 2);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_campaigns`
--

DROP TABLE IF EXISTS `newsletter_campaigns`;
CREATE TABLE IF NOT EXISTS `newsletter_campaigns` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ODOD News',
  `from_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'news@ododnews.mn',
  `html_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `plain_body` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','scheduled','sending','sent','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `recipients_count` int UNSIGNED NOT NULL DEFAULT '0',
  `opens_count` int UNSIGNED NOT NULL DEFAULT '0',
  `clicks_count` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `newsletter_campaigns_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

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
('7yOmsuI7aLN1x5s0UjRpzGBqOASxel7iPOO1YldP', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ2dU5PWEdKazdrbHN2dHE0S3NMN0hOV1ppcXBxTU5aVEVJbjM2RGV3IiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvb2RvZG5ld3NcL2JhY2tlbmRcL2xvZ2luIiwicm91dGUiOiJhZG1pbi5sb2dpbiJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1777010233),
('VnUk6y3g0TCDwib9D46vNFrYgW4KwBj4jAajFTtf', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'eyJfdG9rZW4iOiJSZ0R1amNzd2Q2bVVUemt2UzZ5OTMyVGlZcTF2WlQyakNXdEI5WlJCIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvb2RvZG5ld3NcL2JhY2tlbmRcL21lZGlhIiwicm91dGUiOiJhZG1pbi5tZWRpYS5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1777010344);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

DROP TABLE IF EXISTS `subscribers`;
CREATE TABLE IF NOT EXISTS `subscribers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','active','unsubscribed','bounced') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `confirmation_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `unsubscribed_at` timestamp NULL DEFAULT NULL,
  `source` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscribers_email_unique` (`email`),
  KEY `subscribers_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

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
(1, 'Монгол Улс', 'mongol-uls', '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(2, 'УИХ', 'uix', '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(3, 'Засгийн газар', 'zasgiin-gazar', '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(4, 'Эдийн засаг', 'ediin-zasag', '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(5, 'Бизнес', 'biznes', '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(6, 'Уул уурхай', 'uul-uurxai', '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(7, 'Боловсрол', 'bolovsrol', '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(8, 'Эрүүл мэнд', 'eruul-mend', '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(9, 'Хөрөнгө оруулалт', 'xorongo-oruulalt', '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(10, 'Технологи', 'texnologi', '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(11, 'Startup', 'startup', '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(12, 'AI', 'ai', '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(13, 'Спорт', 'sport', '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(14, 'Хөл бөмбөг', 'xol-bombog', '2026-04-14 16:42:11', '2026-04-14 16:42:11'),
(15, 'Бөх', 'box', '2026-04-14 16:42:11', '2026-04-14 16:42:11');

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
  `role` enum('admin','editor','author') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'author',
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_secret` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('active','suspended','invited') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `invite_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `role`, `avatar`, `two_factor_secret`, `two_factor_enabled`, `status`, `last_login_at`, `invite_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Админ', 'admin@odod.mn', NULL, '$2y$12$SrQ.rSS3eusICyLPaoK15erhImKToRxArHKyT.sOFfHXLLdBib9LW', 1, 'author', NULL, NULL, 0, 'active', NULL, NULL, NULL, '2026-04-14 16:42:10', '2026-04-14 16:42:10');

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
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD CONSTRAINT `admin_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ads`
--
ALTER TABLE `ads`
  ADD CONSTRAINT `ads_slot_id_foreign` FOREIGN KEY (`slot_id`) REFERENCES `ad_slots` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `article_revisions`
--
ALTER TABLE `article_revisions`
  ADD CONSTRAINT `article_revisions_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_revisions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `breaking_alerts`
--
ALTER TABLE `breaking_alerts`
  ADD CONSTRAINT `breaking_alerts_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `breaking_alerts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `campaign_recipients`
--
ALTER TABLE `campaign_recipients`
  ADD CONSTRAINT `campaign_recipients_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `newsletter_campaigns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `campaign_recipients_subscriber_id_foreign` FOREIGN KEY (`subscriber_id`) REFERENCES `subscribers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `newsletter_campaigns`
--
ALTER TABLE `newsletter_campaigns`
  ADD CONSTRAINT `newsletter_campaigns_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
