/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `bukus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_buku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `jumlah_buku` int NOT NULL DEFAULT '0',
  `stok_tersedia` int NOT NULL DEFAULT '0',
  `kategori_id` bigint unsigned DEFAULT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengarang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penerbit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_terbit` year DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bukus_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `bukus_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `bukus` (`id`, `nama_buku`, `deskripsi`, `jumlah_buku`, `stok_tersedia`, `kategori_id`, `gambar`, `pengarang`, `penerbit`, `tahun_terbit`, `created_at`, `updated_at`) VALUES
(1, 'Si Kancil', 'singkat saja', 5, 5, 1, 'bukus/lzJV1rknTvsw0aq2wQcblWIxREQX2vBpmy37qjJc.png', 'Mahmud', 'Surya Kencana', '2022', '2026-04-23 00:37:04', '2026-04-23 23:54:06');
INSERT INTO `bukus` (`id`, `nama_buku`, `deskripsi`, `jumlah_buku`, `stok_tersedia`, `kategori_id`, `gambar`, `pengarang`, `penerbit`, `tahun_terbit`, `created_at`, `updated_at`) VALUES
(2, 'Laskar Pelangi', 'Novel inspiratif', 5, 5, 1, NULL, 'Andrea Hirata', 'Bentang Pustaka', '2005', '2026-04-23 06:18:56', '2026-04-23 06:18:56');
INSERT INTO `bukus` (`id`, `nama_buku`, `deskripsi`, `jumlah_buku`, `stok_tersedia`, `kategori_id`, `gambar`, `pengarang`, `penerbit`, `tahun_terbit`, `created_at`, `updated_at`) VALUES
(3, 'Belajar Laravel', 'Panduan web development', 2, 3, 1, NULL, 'Pak Budi', 'Elex Media', '2023', '2026-04-23 06:18:56', '2026-04-24 00:11:24');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;