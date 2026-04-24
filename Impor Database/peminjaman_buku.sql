/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `peminjaman_buku` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `peminjaman_id` bigint unsigned NOT NULL,
  `buku_id` bigint unsigned NOT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peminjaman_buku_peminjaman_id_foreign` (`peminjaman_id`),
  KEY `peminjaman_buku_buku_id_foreign` (`buku_id`),
  CONSTRAINT `peminjaman_buku_buku_id_foreign` FOREIGN KEY (`buku_id`) REFERENCES `bukus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `peminjaman_buku_peminjaman_id_foreign` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `peminjaman_buku` (`id`, `peminjaman_id`, `buku_id`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2026-04-23 00:43:31', '2026-04-23 00:43:31');
INSERT INTO `peminjaman_buku` (`id`, `peminjaman_id`, `buku_id`, `jumlah`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 2, '2026-04-23 01:02:38', '2026-04-23 01:02:38');
INSERT INTO `peminjaman_buku` (`id`, `peminjaman_id`, `buku_id`, `jumlah`, `created_at`, `updated_at`) VALUES
(3, 3, 1, 1, '2026-04-23 01:03:55', '2026-04-23 01:03:55');
INSERT INTO `peminjaman_buku` (`id`, `peminjaman_id`, `buku_id`, `jumlah`, `created_at`, `updated_at`) VALUES
(4, 4, 1, 2, '2026-04-23 01:13:08', '2026-04-23 01:13:08'),
(5, 5, 1, 1, '2026-04-23 02:23:03', '2026-04-23 02:23:03'),
(6, 6, 1, 1, '2026-04-23 02:32:15', '2026-04-23 02:32:15'),
(7, 7, 1, 2, '2026-04-23 03:08:41', '2026-04-23 03:08:41'),
(8, 8, 1, 2, '2026-04-23 03:57:42', '2026-04-23 03:57:42'),
(9, 9, 1, 2, '2026-04-23 04:05:57', '2026-04-23 04:05:57'),
(10, 11, 1, 1, '2026-04-23 07:23:17', '2026-04-23 07:23:17'),
(11, 11, 3, 1, '2026-04-23 07:23:17', '2026-04-23 07:23:17'),
(12, 12, 1, 1, '2026-04-23 23:52:33', '2026-04-23 23:52:33'),
(13, 12, 3, 1, '2026-04-23 23:52:33', '2026-04-23 23:52:33'),
(14, 13, 3, 1, '2026-04-24 00:05:40', '2026-04-24 00:05:40'),
(15, 14, 3, 1, '2026-04-24 00:11:13', '2026-04-24 00:11:13');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;