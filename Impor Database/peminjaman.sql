/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `peminjaman` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_rencana_kembali` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('pengajuan','disetujui','ditolak','pengajuan_kembali','dikembalikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pengajuan',
  `foto_pengembalian` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_bukti_denda` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `kondisi_buku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_admin` text COLLATE utf8mb4_unicode_ci,
  `hari_terlambat` int NOT NULL DEFAULT '0',
  `jumlah_denda` decimal(10,2) NOT NULL DEFAULT '0.00',
  `denda_lunas` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peminjaman_user_id_foreign` (`user_id`),
  CONSTRAINT `peminjaman_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `peminjaman` (`id`, `user_id`, `tanggal_pinjam`, `tanggal_rencana_kembali`, `tanggal_kembali`, `status`, `foto_pengembalian`, `foto_bukti_denda`, `catatan`, `kondisi_buku`, `catatan_admin`, `hari_terlambat`, `jumlah_denda`, `denda_lunas`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-04-23', '2026-04-24', '2026-04-24', 'dikembalikan', 'pengembalian/3lxfNRvK5EQrkkwQh4btSYlfXNDFHGgbc9o6Clrq.png', NULL, NULL, 'Baik', NULL, 0, '0.00', 0, '2026-04-23 00:43:31', '2026-04-23 00:58:13');
INSERT INTO `peminjaman` (`id`, `user_id`, `tanggal_pinjam`, `tanggal_rencana_kembali`, `tanggal_kembali`, `status`, `foto_pengembalian`, `foto_bukti_denda`, `catatan`, `kondisi_buku`, `catatan_admin`, `hari_terlambat`, `jumlah_denda`, `denda_lunas`, `created_at`, `updated_at`) VALUES
(2, 2, '2026-04-23', '2026-04-24', '2026-04-23', 'dikembalikan', 'pengembalian/OjV0ImQPwbUMVLmRxGSIiB4LTJpXKOupfTmVmIFb.png', NULL, NULL, 'Baik', NULL, 0, '0.00', 0, '2026-04-23 01:02:38', '2026-04-23 01:03:36');
INSERT INTO `peminjaman` (`id`, `user_id`, `tanggal_pinjam`, `tanggal_rencana_kembali`, `tanggal_kembali`, `status`, `foto_pengembalian`, `foto_bukti_denda`, `catatan`, `kondisi_buku`, `catatan_admin`, `hari_terlambat`, `jumlah_denda`, `denda_lunas`, `created_at`, `updated_at`) VALUES
(3, 2, '2026-04-23', '2026-04-24', '2026-04-25', 'dikembalikan', 'pengembalian/ExTEteh3Q4z2mbYSan1rL17H9ihkM2dYwBnRvVyy.png', NULL, NULL, 'Baik', NULL, 1, '0.00', 0, '2026-04-23 01:03:55', '2026-04-23 01:05:14');
INSERT INTO `peminjaman` (`id`, `user_id`, `tanggal_pinjam`, `tanggal_rencana_kembali`, `tanggal_kembali`, `status`, `foto_pengembalian`, `foto_bukti_denda`, `catatan`, `kondisi_buku`, `catatan_admin`, `hari_terlambat`, `jumlah_denda`, `denda_lunas`, `created_at`, `updated_at`) VALUES
(4, 2, '2026-04-23', '2026-04-24', '2026-04-25', 'dikembalikan', 'pengembalian/O6wo3pcwe1qcHjLa6RPIOVGZnbBd4NhHHveGK4Bp.png', 'bukti_denda/LuNiHaFC4u3KxQvtz0zoLsHWOecG8shUIGaICkHN.png', NULL, 'Baik', NULL, 1, '1000.00', 1, '2026-04-23 01:13:08', '2026-04-23 02:22:44'),
(5, 2, '2026-04-23', '2026-04-24', '2026-04-25', 'dikembalikan', 'pengembalian/LLSmdQlOltOv5WN1arhdDDfe6ZFrsY91ZVFOgTJP.png', 'bukti_denda/HxXkhX0tetZ5pJBBVoPBPZf3UAompxpXQwHcK4Jl.png', NULL, 'Baik', NULL, 1, '1000.00', 1, '2026-04-23 02:23:03', '2026-04-23 02:31:58'),
(6, 2, '2026-04-23', '2026-04-24', '2026-04-25', 'dikembalikan', 'pengembalian/cSTzxYZk90IDEddM8QSC0vCTsN3sABJxu9SxXJ4L.jpg', 'bukti_denda/mFHfXOEOSYRw5TT7USpU8P4mst267YRFTXNuBLbn.jpg', NULL, 'Baik', NULL, 1, '1000.00', 1, '2026-04-23 02:32:15', '2026-04-23 03:08:12'),
(7, 2, '2026-04-23', '2026-04-25', '2026-04-26', 'dikembalikan', 'pengembalian/HxA168YVOdC1KmpGkCPWuxq5IjcZTU3THxv15YWo.png', 'bukti_denda/5I9qKICOdQosbnI0xLMRjlQDMg8IFHep8XcP6DR4.png', NULL, 'Baik', NULL, 1, '1000.00', 1, '2026-04-23 03:08:41', '2026-04-23 03:15:58'),
(8, 2, '2026-04-23', '2026-04-24', '2026-04-25', 'dikembalikan', 'pengembalian/ImIw0m0Xqwr3YHZ5duAz01A9OdhlhZLpq2SGifyx.png', 'bukti_denda/Fw3PAUMOTrKXZcGI2I5Ao7hpwhy2WIr8IjSxtdaY.png', NULL, 'Baik', NULL, 1, '1000.00', 1, '2026-04-23 03:57:42', '2026-04-23 03:58:48'),
(9, 2, '2026-04-23', '2026-04-25', '2026-04-23', 'dikembalikan', 'pengembalian/NLFwUBUovsiGIWzKyqsCBwrZno5sEiMRbd5WOHn7.png', NULL, NULL, 'Baik', NULL, 0, '0.00', 0, '2026-04-23 04:05:57', '2026-04-23 04:29:50'),
(10, 2, '2026-04-23', '2026-04-26', '2026-04-23', 'dikembalikan', 'pengembalian/8aXHsTU7ZcUkBczWPFzo6Zbp7HDezUi3lX4XS7jj.png', NULL, NULL, 'Baik', NULL, 0, '0.00', 0, '2026-04-23 04:18:14', '2026-04-23 04:30:30'),
(11, 2, '2026-04-23', '2026-04-23', '2026-04-24', 'dikembalikan', 'pengembalian/J3czZCfY8DhmUyw9Qg1CXLGH3gnlEtLbvHdG6bvk.png', 'bukti_denda/CBCPm0OS8fNDycRpicxX6sWNVC7kLT1Pso2XxYlj.png', NULL, 'Baik', NULL, 1, '1000.00', 1, '2026-04-23 07:23:17', '2026-04-23 07:24:42'),
(12, 2, '2026-04-23', '2026-04-23', '2026-04-23', 'dikembalikan', 'pengembalian/f4rZdLBxd3qCpVtCKBSeAYZvDke8QOjQoQFY6Rir.png', NULL, NULL, 'Baik', NULL, 0, '0.00', 0, '2026-04-23 23:52:33', '2026-04-23 23:54:06'),
(13, 2, '2026-04-24', '2026-04-24', NULL, 'ditolak', NULL, NULL, NULL, NULL, 'tidak jelas', 0, '0.00', 0, '2026-04-24 00:05:40', '2026-04-24 00:06:04'),
(14, 2, '2026-04-24', '2026-04-24', NULL, 'disetujui', NULL, NULL, NULL, NULL, NULL, 0, '0.00', 0, '2026-04-24 00:11:13', '2026-04-24 00:11:24');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;