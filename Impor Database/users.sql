/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `kelas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jurusan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nisn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_nisn_unique` (`nisn`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `kelas`, `jurusan`, `nisn`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$gAxs1MxzQJ1FwSpoqEgfY.2yBP4vryhgyEmy9K7V8F/t3GoqXqB.W', 'admin', NULL, NULL, NULL, NULL, '2026-04-22 23:43:21', '2026-04-22 23:43:21');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `kelas`, `jurusan`, `nisn`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'M. Rafa Auliaurahaman', 'rafa@gmail.com', NULL, '$2y$12$4CdD18Vn.87eftbkSuO18ujEL59v8yDJwqVXPRjoigZ5V7LbCyQ8u', 'user', 'XII PPLG 1', 'PPLG', '0088783129', NULL, '2026-04-22 23:45:33', '2026-04-23 23:49:56');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `kelas`, `jurusan`, `nisn`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'Muhammad Zidan Qawy', 'mzidanqawy08@gmail.com', NULL, '$2y$12$vm/URCd12A3abPSG0Nba8eFDaNAPv5..WchgK9FnPU.kMrWJGjlbu', 'user', 'XII PPLG 1', 'PPLG', '0081010200', NULL, '2026-04-23 14:33:09', '2026-04-23 14:33:09');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;