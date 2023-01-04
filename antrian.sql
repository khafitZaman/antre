-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.22-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table antrian.antrian_detail
CREATE TABLE IF NOT EXISTS `antrian_detail` (
  `id_antrian_detail` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_antrian_kategori` int(10) unsigned DEFAULT NULL,
  `id_antrian_tujuan` int(10) unsigned DEFAULT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  `tgl_update` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_antrian_detail`),
  UNIQUE KEY `id_antrian_kategori_id_antrian_tujuan` (`id_antrian_kategori`,`id_antrian_tujuan`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table antrian.antrian_detail: ~11 rows (approximately)
INSERT INTO `antrian_detail` (`id_antrian_detail`, `id_antrian_kategori`, `id_antrian_tujuan`, `aktif`, `tgl_update`) VALUES
	(1, 1, 1, 'Y', '2022-07-09 19:56:32'),
	(2, 2, 12, 'Y', '2022-07-17 05:36:17'),
	(3, 2, 13, 'Y', '2022-07-24 15:08:21'),
	(4, 2, 14, 'Y', '2022-07-17 05:37:01'),
	(5, 2, 15, 'Y', '2022-07-24 15:09:33'),
	(6, 3, 17, 'Y', '2022-07-17 05:41:06'),
	(7, 3, 18, 'Y', '2022-07-17 05:41:00'),
	(8, 5, 3, 'Y', '2022-07-09 19:56:32'),
	(9, 4, 2, 'Y', '2022-07-09 19:56:32'),
	(10, 6, 4, 'Y', '2022-07-09 19:56:32'),
	(11, 7, 5, 'Y', '2022-07-09 19:56:32');

-- Dumping structure for table antrian.antrian_kategori
CREATE TABLE IF NOT EXISTS `antrian_kategori` (
  `id_antrian_kategori` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_antrian_kategori` varchar(255) NOT NULL,
  `awalan` char(1) NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
  `tgl_input` datetime DEFAULT NULL,
  `id_user_input` int(10) unsigned DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `id_user_update` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_antrian_kategori`) USING BTREE,
  UNIQUE KEY `nama_antrian_kategori` (`nama_antrian_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table antrian.antrian_kategori: ~8 rows (approximately)
INSERT INTO `antrian_kategori` (`id_antrian_kategori`, `nama_antrian_kategori`, `awalan`, `aktif`, `tgl_input`, `id_user_input`, `tgl_update`, `id_user_update`) VALUES
	(1, 'Poliklinik Gigi dan Mulut', 'A', 'N', '2022-01-12 08:28:06', 1, '2022-07-24 14:34:26', 1),
	(2, 'Customer Service', 'A', 'Y', '2022-01-12 08:30:38', 1, '2022-07-24 14:54:37', NULL),
	(3, 'Loket', 'B', 'Y', '2022-07-03 18:34:48', 1, '2022-07-24 14:46:28', 1),
	(4, 'Poliklinik Ibu dan Anak', 'B', 'Y', '2022-07-03 18:39:16', 1, '2022-07-17 06:42:31', 1),
	(5, 'Poliklinik Umum', 'C', 'Y', '2022-07-03 18:39:45', 1, '2022-07-17 06:42:35', 1),
	(6, 'Poliklinik Kebidanan', 'D', 'Y', '2022-07-03 18:39:55', 1, '2022-07-03 19:43:05', 1),
	(7, 'Poliklinik Mata', 'E', 'Y', '2022-07-03 19:43:20', 1, NULL, NULL),
	(8, 'Counter', '', 'Y', '2022-07-16 12:40:13', 1, NULL, NULL);

-- Dumping structure for table antrian.antrian_panggil
CREATE TABLE IF NOT EXISTS `antrian_panggil` (
  `id_antrian_panggil` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_antrian_kategori` int(10) unsigned NOT NULL,
  `jml_antrian` smallint(5) unsigned NOT NULL,
  `jml_dipanggil` smallint(5) unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `time_ambil` time NOT NULL,
  `time_dipanggil` time NOT NULL,
  PRIMARY KEY (`id_antrian_panggil`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table antrian.antrian_panggil: ~11 rows (approximately)
INSERT INTO `antrian_panggil` (`id_antrian_panggil`, `id_antrian_kategori`, `jml_antrian`, `jml_dipanggil`, `tanggal`, `time_ambil`, `time_dipanggil`) VALUES
	(1, 2, 20, 20, '2022-07-16', '21:12:21', '21:37:26'),
	(2, 3, 14, 0, '2022-07-16', '21:08:29', '00:00:00'),
	(3, 2, 17, 7, '2022-07-17', '13:25:33', '13:03:58'),
	(4, 3, 13, 5, '2022-07-17', '13:22:55', '05:49:10'),
	(5, 5, 2, 2, '2022-07-17', '07:05:37', '07:20:15'),
	(6, 4, 9, 0, '2022-07-17', '14:00:50', '00:00:00'),
	(7, 6, 3, 0, '2022-07-17', '07:05:40', '00:00:00'),
	(8, 1, 10, 3, '2022-07-17', '14:07:02', '07:22:21'),
	(9, 7, 1, 0, '2022-07-17', '07:05:35', '00:00:00'),
	(10, 2, 15, 7, '2022-07-24', '11:51:09', '14:49:36'),
	(11, 3, 7, 5, '2022-07-24', '14:47:07', '14:47:25');

-- Dumping structure for table antrian.antrian_panggil_awalan
CREATE TABLE IF NOT EXISTS `antrian_panggil_awalan` (
  `nama_file` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='Pengaturan suara sebawai awalan pemanggilan antrian, seperti bunyi bell';

-- Dumping data for table antrian.antrian_panggil_awalan: ~1 rows (approximately)
INSERT INTO `antrian_panggil_awalan` (`nama_file`) VALUES
	('["bell_long.wav","nomor_antrian.wav"]');

-- Dumping structure for table antrian.antrian_panggil_detail
CREATE TABLE IF NOT EXISTS `antrian_panggil_detail` (
  `id_antrian_panggil_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_antrian_panggil` int(11) unsigned NOT NULL,
  `id_antrian_detail` int(11) unsigned NOT NULL,
  `awalan_panggil` char(1) NOT NULL,
  `nomor_panggil` smallint(5) unsigned NOT NULL,
  `waktu_panggil` time DEFAULT current_timestamp(),
  PRIMARY KEY (`id_antrian_panggil_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table antrian.antrian_panggil_detail: ~49 rows (approximately)
INSERT INTO `antrian_panggil_detail` (`id_antrian_panggil_detail`, `id_antrian_panggil`, `id_antrian_detail`, `awalan_panggil`, `nomor_panggil`, `waktu_panggil`) VALUES
	(1, 1, 3, 'A', 1, '20:11:18'),
	(2, 1, 3, 'A', 2, '20:11:35'),
	(3, 1, 4, 'A', 3, '20:11:51'),
	(4, 1, 2, 'A', 4, '20:11:55'),
	(5, 1, 2, 'A', 5, '20:11:57'),
	(6, 1, 2, 'A', 6, '20:11:57'),
	(7, 1, 4, 'A', 7, '20:11:58'),
	(8, 1, 4, 'A', 8, '20:11:59'),
	(9, 1, 4, 'A', 9, '20:12:00'),
	(10, 1, 3, 'A', 10, '20:17:31'),
	(11, 1, 3, 'A', 11, '20:28:39'),
	(12, 1, 5, 'A', 12, '20:33:07'),
	(13, 1, 2, 'A', 13, '20:35:03'),
	(14, 1, 5, 'A', 14, '20:35:10'),
	(15, 1, 3, 'A', 15, '20:54:17'),
	(16, 1, 2, 'A', 16, '21:12:32'),
	(17, 1, 4, 'A', 17, '21:31:00'),
	(18, 1, 5, 'A', 18, '21:35:59'),
	(19, 1, 2, 'A', 19, '21:36:24'),
	(20, 1, 4, 'A', 20, '21:37:26'),
	(21, 3, 2, 'A', 1, '05:10:21'),
	(22, 3, 3, 'A', 2, '05:10:38'),
	(23, 3, 2, 'A', 3, '05:11:41'),
	(24, 4, 6, 'B', 1, '05:37:35'),
	(25, 4, 6, 'B', 2, '05:42:02'),
	(26, 4, 6, 'B', 3, '05:45:33'),
	(27, 4, 6, 'B', 4, '05:49:00'),
	(28, 4, 7, 'B', 5, '05:49:10'),
	(29, 8, 1, 'A', 1, '07:07:37'),
	(30, 3, 3, 'A', 4, '07:07:57'),
	(31, 5, 8, 'C', 1, '07:19:58'),
	(32, 5, 8, 'C', 2, '07:20:15'),
	(33, 8, 1, 'A', 2, '07:21:54'),
	(34, 8, 1, 'A', 3, '07:22:21'),
	(35, 3, 2, 'A', 5, '07:23:55'),
	(36, 3, 4, 'A', 6, '07:24:01'),
	(37, 3, 3, 'A', 7, '13:03:59'),
	(65, 11, 6, 'B', 1, '14:47:17'),
	(66, 11, 7, 'B', 2, '14:47:18'),
	(67, 11, 6, 'B', 3, '14:47:22'),
	(68, 11, 6, 'B', 4, '14:47:23'),
	(69, 11, 7, 'B', 5, '14:47:25'),
	(70, 10, 2, 'A', 1, '14:49:24'),
	(71, 10, 3, 'A', 2, '14:49:25'),
	(72, 10, 5, 'A', 3, '14:49:28'),
	(73, 10, 2, 'A', 4, '14:49:31'),
	(74, 10, 3, 'A', 5, '14:49:32'),
	(75, 10, 2, 'A', 6, '14:49:34'),
	(76, 10, 5, 'A', 7, '14:49:36');

-- Dumping structure for table antrian.antrian_panggil_ulang
CREATE TABLE IF NOT EXISTS `antrian_panggil_ulang` (
  `id_setting_layar` int(11) unsigned DEFAULT NULL,
  `id_antrian_panggil_detail` int(11) unsigned DEFAULT NULL,
  `tanggal_panggil_ulang` date DEFAULT curdate(),
  `waktu_panggil_ulang` time DEFAULT curtime()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table antrian.antrian_panggil_ulang: ~9 rows (approximately)
INSERT INTO `antrian_panggil_ulang` (`id_setting_layar`, `id_antrian_panggil_detail`, `tanggal_panggil_ulang`, `waktu_panggil_ulang`) VALUES
	(1, 30, '2022-07-17', '13:00:11'),
	(1, 30, '2022-07-17', '13:02:15'),
	(1, 35, '2022-07-17', '13:05:20'),
	(1, 35, '2022-07-17', '13:05:50'),
	(1, 36, '2022-07-17', '13:06:09'),
	(1, 49, '2022-07-24', '11:28:03'),
	(1, 60, '2022-07-24', '11:50:08'),
	(1, 61, '2022-07-24', '11:51:02'),
	(1, 64, '2022-07-24', '11:51:47');

-- Dumping structure for table antrian.antrian_tujuan
CREATE TABLE IF NOT EXISTS `antrian_tujuan` (
  `id_antrian_tujuan` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_antrian_tujuan` varchar(255) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  PRIMARY KEY (`id_antrian_tujuan`) USING BTREE,
  UNIQUE KEY `nama_poliklinik` (`nama_antrian_tujuan`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table antrian.antrian_tujuan: ~21 rows (approximately)
INSERT INTO `antrian_tujuan` (`id_antrian_tujuan`, `nama_antrian_tujuan`, `nama_file`) VALUES
	(1, 'Poliklinik Gigi dan Mulut', '["poliklinik.wav","gigi_dan_mulut.wav"]'),
	(2, 'Poliklinik Ibu dan Anak', '["poliklinik.wav","ibu_dan_anak.wav"]'),
	(3, 'Poliklinik Umum', '["poliklinik.wav","umum.wav"]'),
	(4, 'Poliklinik Kebidanan', '["poliklinik.wav","kebidanan.wav"]'),
	(5, 'Poliklinik Mata', '["poliklinik.wav","mata.wav"]'),
	(6, 'Apotik', '["apotik.wav"]'),
	(7, 'Counter 1', '["counter.wav","satu.wav"]'),
	(8, 'Counter 2', '["counter.wav","dua.wav"]'),
	(9, 'Counter 3', '["counter.wav","tiga.wav"]'),
	(10, 'Counter 4', '["counter.wav","empat.wav"]'),
	(11, 'Counter 5', '["counter.wav","lima.wav"]'),
	(12, 'Customer Service 1', '["customer_service.wav","satu.wav"]'),
	(13, 'Customer Service 2', '["customer_service.wav","dua.wav"]'),
	(14, 'Customer Service 3', '["customer_service.wav","tiga.wav"]'),
	(15, 'Customer Service 4', '["customer_service.wav","empat.wav"]'),
	(16, 'Customer Service 5', '["customer_service.wav","lima.wav"]'),
	(17, 'Loket 1', '["loket.wav","satu.wav"]'),
	(18, 'Loket 2', '["loket.wav","dua.wav"]'),
	(19, 'Loket 3', '["loket.wav","tiga.wav"]'),
	(20, 'Loket 4', '["loket.wav","empat.wav"]'),
	(21, 'Loket 5', '["loket.wav","lima.wav"]');

-- Dumping structure for table antrian.identitas
CREATE TABLE IF NOT EXISTS `identitas` (
  `nama` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `file_logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table antrian.identitas: ~1 rows (approximately)
INSERT INTO `identitas` (`nama`, `alamat`, `no_hp`, `email`, `website`, `file_logo`) VALUES
	('Jagowebdev Virtual Office', 'Perumahan Muria Indah Kudus', '08561363962', 'info@jagowebdev.com', 'https://jagowebdev.com', 'logo_layar_monitor.png');

-- Dumping structure for table antrian.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id_menu` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(50) NOT NULL,
  `class` varchar(50) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  `id_module` smallint(5) unsigned DEFAULT NULL,
  `id_parent` smallint(5) unsigned DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `new` tinyint(1) NOT NULL DEFAULT 0,
  `urut` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_menu`) USING BTREE,
  KEY `menu_module` (`id_module`) USING BTREE,
  KEY `menu_menu` (`id_parent`),
  CONSTRAINT `menu_menu` FOREIGN KEY (`id_parent`) REFERENCES `menu` (`id_menu`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `menu_module` FOREIGN KEY (`id_module`) REFERENCES `module` (`id_module`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT COMMENT='Tabel menu aplikasi';

-- Dumping data for table antrian.menu: ~28 rows (approximately)
INSERT INTO `menu` (`id_menu`, `nama_menu`, `class`, `url`, `id_module`, `id_parent`, `aktif`, `new`, `urut`) VALUES
	(1, 'User', 'fas fa-users', 'builtin/user', 5, 8, 1, 0, 1),
	(2, 'Assign Role', 'fas fa-link', '#', 1, 8, 1, 0, 6),
	(3, 'User Role', 'fas fa-user-tag', 'builtin/user-role', 7, 2, 1, 0, 2),
	(4, 'Module', 'fas fa-network-wired', 'builtin/module', 2, 8, 1, 0, 4),
	(6, 'Menu', 'fas fa-clone', 'builtin/menu', 1, 8, 1, 0, 2),
	(7, 'Menu Role', 'fas fa-folder-minus', 'builtin/menu-role', 8, 2, 1, 0, 3),
	(8, 'Aplikasi', 'fas fa-globe', '#', 1, NULL, 1, 0, 1),
	(9, 'Role', 'fas fa-briefcase', 'builtin/role', 4, 8, 1, 0, 3),
	(10, 'Setting Website', 'fas fa-cog', 'builtin/setting-web', 16, 8, 1, 0, 8),
	(11, 'Layout Setting', 'fas fa-brush', 'builtin/setting', 15, 8, 1, 0, 9),
	(23, 'Setting Registrasi', 'fas fa-user-plus', 'setting-registrasi', 34, 8, 1, 0, 7),
	(36, 'Module Permission', 'fas fa-shield-alt', 'builtin/permission', 43, 8, 1, 0, 5),
	(37, 'Role Permission', 'fas fa-user-tag', 'builtin/role-permission', 44, 2, 1, 0, 1),
	(38, 'Antrian', 'fas fa-users', 'antrian', 72, NULL, 1, 0, 3),
	(39, 'Layar', 'fas fa-tv', '#', NULL, NULL, 1, 0, 4),
	(40, 'Layar Ambil Antrian', 'fas fa-desktop', 'layar/antrian', 73, 39, 1, 0, 1),
	(41, 'Ambil Antrian', 'fas fa-tasks', 'antrian-ambil', 81, 38, 1, 0, 2),
	(42, 'Panggil Antrian', 'fas fa-volume-up', 'antrian-panggil', 80, 38, 1, 0, 3),
	(43, 'Layar Monitor', 'fas fa-tv', 'layar/show-layar-monitor', 73, 39, 1, 0, 2),
	(44, 'Identitas', 'far fa-hospital', 'identitas', 75, NULL, 1, 0, 2),
	(45, 'Setting Printer', 'fas fa-print', 'setting-printer', 76, NULL, 1, 0, 5),
	(46, 'Referensi Tujuan', 'fas fa-person-booth', 'tujuan', 77, 38, 1, 0, 5),
	(47, 'Setting Layout', 'fas fa-palette', 'layar-monitor-setting-layout', 79, 39, 1, 0, 4),
	(48, 'Rekap Antrian', 'fas fa-history', 'antrian-rekap', 82, 38, 1, 0, 6),
	(49, 'Reset Antrian', 'fas fa-retweet', 'antrian-reset', 83, 38, 1, 0, 4),
	(50, 'Setting Display', 'fas fa-cog', 'layar-monitor-setting', 84, 39, 1, 0, 3),
	(51, 'Suara Awalan', 'fas fa-volume-up', 'awalan-panggil', 85, NULL, 1, 0, 6),
	(52, 'Group Antrian', 'fas fa-users-cog', 'antrian', 72, 38, 1, 0, 1);

-- Dumping structure for table antrian.menu_role
CREATE TABLE IF NOT EXISTS `menu_role` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_menu` smallint(5) unsigned NOT NULL,
  `id_role` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_role_module` (`id_menu`),
  KEY `module_role_role` (`id_role`),
  CONSTRAINT `menu_role_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `menu_role_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT COMMENT='Tabel hak akses dari menu aplikasi';

-- Dumping data for table antrian.menu_role: ~34 rows (approximately)
INSERT INTO `menu_role` (`id`, `id_menu`, `id_role`) VALUES
	(6, 2, 1),
	(7, 3, 1),
	(8, 4, 1),
	(9, 6, 1),
	(19, 1, 1),
	(20, 1, 2),
	(23, 8, 1),
	(25, 7, 1),
	(29, 9, 1),
	(30, 10, 1),
	(32, 11, 1),
	(64, 23, 1),
	(75, 36, 1),
	(77, 37, 1),
	(78, 38, 1),
	(79, 39, 1),
	(80, 40, 1),
	(81, 41, 1),
	(82, 42, 1),
	(83, 43, 1),
	(84, 44, 1),
	(85, 45, 1),
	(86, 46, 1),
	(87, 47, 1),
	(88, 48, 1),
	(89, 8, 2),
	(90, 11, 2),
	(91, 41, 2),
	(92, 42, 2),
	(93, 38, 2),
	(94, 49, 1),
	(95, 50, 1),
	(96, 51, 1),
	(97, 52, 1);

-- Dumping structure for table antrian.module
CREATE TABLE IF NOT EXISTS `module` (
  `id_module` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nama_module` varchar(50) DEFAULT NULL,
  `judul_module` varchar(50) DEFAULT NULL,
  `id_module_status` tinyint(1) DEFAULT NULL,
  `login` enum('Y','N','R') NOT NULL DEFAULT 'Y',
  `deskripsi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_module`),
  UNIQUE KEY `module_nama` (`nama_module`),
  KEY `module_module_status` (`id_module_status`),
  CONSTRAINT `module_module_status` FOREIGN KEY (`id_module_status`) REFERENCES `module_status` (`id_module_status`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Tabel modul aplikasi';

-- Dumping data for table antrian.module: ~29 rows (approximately)
INSERT INTO `module` (`id_module`, `nama_module`, `judul_module`, `id_module_status`, `login`, `deskripsi`) VALUES
	(1, 'builtin/menu', 'Menu Manager', 1, 'Y', 'Administrasi Menu'),
	(2, 'builtin/module', 'Module Manager', 1, 'Y', 'Pengaturan Module'),
	(3, 'builtin/module-role', 'Assign Role ke Module', 1, 'Y', 'Assign Role ke Module'),
	(4, 'builtin/role', 'Role Manager', 1, 'Y', 'Pengaturan Role'),
	(5, 'builtin/user', 'User Manager', 1, 'Y', 'Pengaturan user'),
	(6, 'login', 'Login', 1, 'R', 'Login ke akun Anda'),
	(7, 'builtin/user-role', 'Assign Role ke User', 1, 'Y', 'Assign role ke user'),
	(8, 'builtin/menu-role', 'Menu - Role', 1, 'Y', 'Assign role ke menu'),
	(15, 'builtin/setting', 'Setting Layout', 1, 'Y', 'Web Setting'),
	(16, 'builtin/setting-web', 'Setting Web', 1, 'Y', 'Pengaturan website seperti nama web, logo, dll'),
	(25, 'home', 'Home', 1, 'Y', 'Home'),
	(33, 'register', 'Register Akun', 1, 'R', 'Register Akun'),
	(34, 'setting-registrasi', 'Setting Registrasi Akun', 1, 'Y', 'Setting Registrasi Akun'),
	(35, 'recovery', 'Reset Password', 1, 'R', 'Reset Password'),
	(43, 'builtin/permission', 'Permission', 1, 'Y', 'Permission'),
	(44, 'builtin/role-permission', 'Role Permission', 1, 'Y', 'Role Permission'),
	(72, 'antrian', 'Antrian', 1, 'Y', 'Antrian'),
	(73, 'layar', 'Layar', 1, 'N', 'Layar Antrian dan Monitor'),
	(74, 'longpolling', 'Long Polling', 1, 'N', 'Long Polling'),
	(75, 'identitas', 'Identitas', 1, 'Y', 'Identitas'),
	(76, 'setting-printer', 'Setting Printer', 1, 'Y', 'Setting Printer'),
	(77, 'tujuan', 'Tujuan', 1, 'Y', 'Tujuan Antrian'),
	(79, 'layar-monitor-setting-layout', 'Setting Layout Layar', 1, 'Y', 'Setting Layout Layar'),
	(80, 'antrian-panggil', 'Panggil Antrian', 1, 'Y', 'Panggil Antrian'),
	(81, 'antrian-ambil', 'Ambil Antrian', 1, 'Y', 'Ambil Antrian'),
	(82, 'antrian-rekap', 'Rekapitulasi Antrian', 1, 'Y', 'Rekapitulasi Antrian'),
	(83, 'antrian-reset', 'Reset Antrian', 1, 'Y', 'Reset Antrian'),
	(84, 'layar-monitor-setting', 'Setting Monitor Antrian', 1, 'Y', 'Setting Monitor Antrian'),
	(85, 'awalan-panggil', 'Suara Awalan Panggil Antrian', 1, 'Y', 'Suara Awalan Panggil Antrian');

-- Dumping structure for table antrian.module_permission
CREATE TABLE IF NOT EXISTS `module_permission` (
  `id_module_permission` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_module` smallint(5) unsigned NOT NULL DEFAULT 0,
  `nama_permission` varchar(50) NOT NULL,
  `judul_permission` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_module_permission`) USING BTREE,
  UNIQUE KEY `id_module_nama_permission` (`id_module`,`nama_permission`)
) ENGINE=InnoDB AUTO_INCREMENT=382 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table antrian.module_permission: ~208 rows (approximately)
INSERT INTO `module_permission` (`id_module_permission`, `id_module`, `nama_permission`, `judul_permission`, `keterangan`) VALUES
	(10, 25, 'create', 'Create Data', 'Hak akses untuk menambah data\r'),
	(13, 6, 'create', 'Create Data', 'Hak akses untuk menambah data\r'),
	(14, 1, 'create', 'Create Data', 'Hak akses untuk menambah data\r'),
	(15, 8, 'create', 'Create Data', 'Hak akses untuk menambah data\r'),
	(16, 2, 'create', 'Create Data', 'Hak akses untuk menambah data\r'),
	(17, 3, 'create', 'Create Data', 'Hak akses untuk menambah data\r'),
	(22, 35, 'create', 'Create Data', 'Hak akses untuk menambah data\r'),
	(23, 33, 'create', 'Create Data', 'Hak akses untuk menambah data\r'),
	(24, 4, 'create', 'Create Data', 'Hak akses untuk menambah data\r'),
	(25, 15, 'create', 'Create Data', 'Hak akses untuk menambah data\r'),
	(26, 34, 'create', 'Create Data', 'Hak akses untuk menambah data\r'),
	(27, 16, 'create', 'Create Data', 'Hak akses untuk menambah data\r'),
	(29, 5, 'create', 'Create Data', 'Hak akses untuk menambah data\r'),
	(30, 7, 'create', 'Create Data', 'Hak akses untuk menambah data\r'),
	(40, 25, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data\r'),
	(43, 6, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data\r'),
	(44, 1, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data\r'),
	(45, 8, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data\r'),
	(46, 2, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data\r'),
	(47, 3, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data\r'),
	(52, 35, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data\r'),
	(53, 33, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data\r'),
	(54, 4, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data\r'),
	(55, 15, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data\r'),
	(56, 34, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data\r'),
	(57, 16, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data\r'),
	(59, 5, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data\r'),
	(60, 7, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data\r'),
	(70, 25, 'read_all', 'Read All Data', 'Hak akses untuk membaca data home\r'),
	(73, 6, 'read_all', 'Read All Data', 'Hak akses untuk membaca data login\r'),
	(74, 1, 'read_all', 'Read All Data', 'Hak akses untuk membaca data menu\r'),
	(75, 8, 'read_all', 'Read All Data', 'Hak akses untuk membaca data menu role\r'),
	(76, 2, 'read_all', 'Read All Data', 'Hak akses untuk membaca data module\r'),
	(77, 3, 'read_all', 'Read All Data', 'Hak akses untuk membaca data module role\r'),
	(82, 35, 'read_all', 'Read All Data', 'Hak akses untuk membaca data recovery\r'),
	(83, 33, 'read_all', 'Read All Data', 'Hak akses untuk membaca data register\r'),
	(84, 4, 'read_all', 'Read All Data', 'Hak akses untuk membaca data role\r'),
	(85, 15, 'read_all', 'Read All Data', 'Hak akses untuk membaca data setting\r'),
	(86, 34, 'read_all', 'Read All Data', 'Hak akses untuk membaca data setting registrasi\r'),
	(87, 16, 'read_all', 'Read All Data', 'Hak akses untuk membaca data setting web\r'),
	(89, 5, 'read_all', 'Read All Data', 'Hak akses untuk membaca data user\r'),
	(90, 7, 'read_all', 'Read All Data', 'Hak akses untuk membaca data user role\r'),
	(100, 25, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data\r'),
	(103, 6, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data\r'),
	(104, 1, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data\r'),
	(105, 8, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data\r'),
	(106, 2, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data\r'),
	(107, 3, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data\r'),
	(112, 35, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data\r'),
	(113, 33, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data\r'),
	(114, 4, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data\r'),
	(115, 15, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data\r'),
	(116, 34, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data\r'),
	(117, 16, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data\r'),
	(119, 5, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data\r'),
	(120, 7, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data\r'),
	(125, 43, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(126, 43, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(127, 43, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(128, 43, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(129, 44, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(130, 44, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(131, 44, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(132, 44, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(133, 5, 'read_own', 'Read Own Data', 'Hak akses untuk membaca data miliknya sendiri'),
	(134, 5, 'update_own', 'Update Own Data', 'Hak akses untuk mengupdate data miliknya sendiri'),
	(135, 5, 'delete_own', 'Delete Own Data', 'Hak akses untuk menghapus data miliknya sendiri'),
	(138, 50, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(139, 50, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(140, 50, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(141, 50, 'read_own', 'Read Own Data', 'Hak akses untuk membaca data miliknya sendiri'),
	(142, 50, 'update_own', 'Update Own Data', 'Hak akses untuk mengupdate data miliknya sendiri'),
	(143, 50, 'delete_own', 'Delete Own Data', 'Hak akses untuk menghapus data miliknya sendiri'),
	(152, 53, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(153, 53, 'read_own', 'Read Own Data', 'Hak akses untuk membaca data miliknya sendiri'),
	(154, 53, 'update_own', 'Update Own Data', 'Hak akses untuk mengupdate data miliknya sendiri'),
	(155, 53, 'delete_own', 'Delete Own Data', 'Hak akses untuk menghapus data miliknya sendiri'),
	(156, 54, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(157, 54, 'read_own', 'Read Own Data', 'Hak akses untuk membaca data miliknya sendiri'),
	(158, 54, 'update_own', 'Update Own Data', 'Hak akses untuk mengupdate data miliknya sendiri'),
	(159, 54, 'delete_own', 'Delete Own Data', 'Hak akses untuk menghapus data miliknya sendiri'),
	(160, 55, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(161, 55, 'read_own', 'Read Own Data', 'Hak akses untuk membaca data miliknya sendiri'),
	(162, 55, 'update_own', 'Update Own Data', 'Hak akses untuk mengupdate data miliknya sendiri'),
	(163, 55, 'delete_own', 'Delete Own Data', 'Hak akses untuk menghapus data miliknya sendiri'),
	(164, 56, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(165, 56, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(166, 56, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(167, 56, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(171, 56, 'read_own', 'Read Own Data', 'Hak akses untuk membaca data miliknya sendiri'),
	(172, 56, 'update_own', 'Update Own Data', 'Hak akses untuk mengupdate data miliknya sendiri'),
	(173, 56, 'delete_own', 'Delete Own Data', 'Hak akses untuk menghapus data miliknya sendiri'),
	(185, 57, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(186, 57, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(187, 57, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(188, 57, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(193, 60, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(194, 60, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(195, 60, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(196, 60, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(197, 61, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(198, 61, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(199, 61, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(200, 61, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(201, 62, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(202, 62, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(203, 62, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(204, 62, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(205, 63, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(206, 63, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(207, 63, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(208, 63, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(213, 65, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(214, 65, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(215, 65, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(216, 65, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(217, 66, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(218, 66, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(219, 66, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(220, 66, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(221, 67, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(222, 67, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(223, 67, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(224, 67, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(227, 68, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(229, 69, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(230, 69, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(231, 69, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(232, 69, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(233, 70, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(234, 70, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(235, 70, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(236, 70, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(244, 58, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(245, 58, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(246, 58, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(247, 58, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(248, 58, 'read_own', 'Read Own Data', 'Hak akses untuk membaca data miliknya sendiri'),
	(249, 58, 'update_own', 'Update Own Data', 'Hak akses untuk mengupdate data miliknya sendiri'),
	(250, 58, 'delete_own', 'Delete Own Data', 'Hak akses untuk menghapus data miliknya sendiri'),
	(258, 71, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(259, 71, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(260, 71, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(261, 71, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(262, 71, 'read_own', 'Read Own Data', 'Hak akses untuk membaca data miliknya sendiri'),
	(263, 71, 'update_own', 'Update Own Data', 'Hak akses untuk mengupdate data miliknya sendiri'),
	(264, 71, 'delete_own', 'Delete Own Data', 'Hak akses untuk menghapus data miliknya sendiri'),
	(265, 71, 'read_test', 'Read_test', 'read_test'),
	(308, 64, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(309, 64, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(310, 64, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(311, 64, 'read_own', 'Read Own Data', 'Hak akses untuk membaca data miliknya sendiri'),
	(312, 64, 'update_own', 'Update Own Data', 'Hak akses untuk mengupdate data miliknya sendiri'),
	(313, 64, 'delete_own', 'Delete Own Data', 'Hak akses untuk menghapus data miliknya sendiri'),
	(318, 64, 'create', 'create', 'create'),
	(325, 64, 'send_email', 'send_email', 'KIrim email'),
	(326, 72, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(327, 72, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(328, 72, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(329, 72, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(330, 73, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(331, 73, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(332, 73, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(333, 73, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(334, 74, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(335, 74, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(336, 74, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(337, 74, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(338, 75, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(339, 75, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(340, 75, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(341, 75, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(342, 76, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(343, 76, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(344, 76, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(345, 76, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(346, 77, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(347, 77, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(348, 77, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(349, 77, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(350, 79, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(351, 79, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(352, 79, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(353, 79, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(354, 80, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(355, 80, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(356, 80, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(357, 80, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(358, 81, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(359, 81, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(360, 81, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(361, 81, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(362, 82, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(363, 82, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(364, 82, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(365, 82, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(366, 83, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(367, 83, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(368, 83, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(369, 83, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(374, 84, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(375, 84, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(376, 84, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(377, 84, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data'),
	(378, 85, 'create', 'Create Data', 'Hak akses untuk membuat data'),
	(379, 85, 'read_all', 'Read All Data', 'Hak akses untuk membaca semua data'),
	(380, 85, 'update_all', 'Update All Data', 'Hak akses untuk mengupdate semua data'),
	(381, 85, 'delete_all', 'Delete All Data', 'Hak akses untuk menghapus semua data');

-- Dumping structure for table antrian.module_role
CREATE TABLE IF NOT EXISTS `module_role` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_module` smallint(5) unsigned NOT NULL,
  `id_role` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_role_module` (`id_module`),
  KEY `module_role_role` (`id_role`),
  CONSTRAINT `module_role_module` FOREIGN KEY (`id_module`) REFERENCES `module` (`id_module`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `module_role_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Tabel hak akses module aplikasi, module aplikasi boleh diakses oleh user yang mempunyai role apa saja';

-- Dumping data for table antrian.module_role: ~26 rows (approximately)
INSERT INTO `module_role` (`id`, `id_module`, `id_role`) VALUES
	(1, 3, 1),
	(2, 8, 1),
	(3, 4, 1),
	(5, 2, 1),
	(6, 1, 1),
	(7, 7, 1),
	(26, 15, 1),
	(27, 15, 2),
	(28, 16, 1),
	(38, 25, 1),
	(39, 25, 2),
	(68, 5, 1),
	(69, 5, 2),
	(106, 34, 1),
	(114, 43, 1),
	(115, 44, 1),
	(147, 72, 1),
	(148, 73, 1),
	(149, 74, 1),
	(150, 75, 1),
	(151, 76, 1),
	(152, 77, 1),
	(153, 79, 1),
	(154, 80, 1),
	(155, 81, 1),
	(156, 82, 1);

-- Dumping structure for table antrian.module_status
CREATE TABLE IF NOT EXISTS `module_status` (
  `id_module_status` tinyint(1) NOT NULL AUTO_INCREMENT,
  `nama_status` varchar(50) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_module_status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Tabel status modul, seperti: aktif, non aktif, dalam perbaikan';

-- Dumping data for table antrian.module_status: ~3 rows (approximately)
INSERT INTO `module_status` (`id_module_status`, `nama_status`, `keterangan`) VALUES
	(1, 'Aktif', NULL),
	(2, 'Dalam Perbaikan', 'Hanya role developer yang dapat mengakses module dengan status ini'),
	(3, 'Non Aktif', NULL);

-- Dumping structure for table antrian.role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nama_role` varchar(50) NOT NULL,
  `judul_role` varchar(50) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `id_module` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_role`),
  UNIQUE KEY `role_nama` (`nama_role`),
  KEY `role_module` (`id_module`),
  CONSTRAINT `role_module` FOREIGN KEY (`id_module`) REFERENCES `module` (`id_module`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='Tabel yang berisi daftar role, role ini mengatur bagaimana user mengakses module, role ini nantinya diassign ke user';

-- Dumping data for table antrian.role: ~3 rows (approximately)
INSERT INTO `role` (`id_role`, `nama_role`, `judul_role`, `keterangan`, `id_module`) VALUES
	(1, 'admin', 'Administrator', 'Administrator', 5),
	(2, 'user', 'User', 'Pengguna umum', 5),
	(3, 'webdev', 'Web Developer', 'Pengembang aplikasi', 5);

-- Dumping structure for table antrian.role_detail
CREATE TABLE IF NOT EXISTS `role_detail` (
  `id_role_detail` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nama_role_detail` varchar(255) DEFAULT NULL,
  `judul_role_detail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_role_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table antrian.role_detail: ~3 rows (approximately)
INSERT INTO `role_detail` (`id_role_detail`, `nama_role_detail`, `judul_role_detail`) VALUES
	(1, 'all', 'Boleh Akses Semua Data'),
	(2, 'no', 'Tidak Boleh Akses Semua Data'),
	(3, 'own', 'Hanya Data Miliknya Sendiri');

-- Dumping structure for table antrian.role_module_permission
CREATE TABLE IF NOT EXISTS `role_module_permission` (
  `id_role` smallint(5) unsigned NOT NULL DEFAULT 0,
  `id_module_permission` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id_role`,`id_module_permission`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table antrian.role_module_permission: ~131 rows (approximately)
INSERT INTO `role_module_permission` (`id_role`, `id_module_permission`) VALUES
	(1, 10),
	(1, 13),
	(1, 14),
	(1, 15),
	(1, 16),
	(1, 17),
	(1, 22),
	(1, 23),
	(1, 24),
	(1, 25),
	(1, 26),
	(1, 27),
	(1, 29),
	(1, 30),
	(1, 40),
	(1, 43),
	(1, 44),
	(1, 45),
	(1, 46),
	(1, 47),
	(1, 52),
	(1, 53),
	(1, 54),
	(1, 55),
	(1, 56),
	(1, 57),
	(1, 59),
	(1, 60),
	(1, 70),
	(1, 73),
	(1, 74),
	(1, 75),
	(1, 76),
	(1, 77),
	(1, 82),
	(1, 83),
	(1, 84),
	(1, 85),
	(1, 86),
	(1, 87),
	(1, 89),
	(1, 90),
	(1, 100),
	(1, 103),
	(1, 104),
	(1, 105),
	(1, 106),
	(1, 107),
	(1, 112),
	(1, 113),
	(1, 114),
	(1, 115),
	(1, 116),
	(1, 117),
	(1, 119),
	(1, 120),
	(1, 125),
	(1, 126),
	(1, 127),
	(1, 128),
	(1, 129),
	(1, 130),
	(1, 131),
	(1, 132),
	(1, 134),
	(1, 135),
	(1, 326),
	(1, 327),
	(1, 328),
	(1, 329),
	(1, 330),
	(1, 331),
	(1, 332),
	(1, 333),
	(1, 334),
	(1, 335),
	(1, 336),
	(1, 337),
	(1, 338),
	(1, 339),
	(1, 340),
	(1, 341),
	(1, 342),
	(1, 343),
	(1, 344),
	(1, 345),
	(1, 346),
	(1, 347),
	(1, 348),
	(1, 349),
	(1, 350),
	(1, 351),
	(1, 352),
	(1, 353),
	(1, 354),
	(1, 355),
	(1, 356),
	(1, 357),
	(1, 358),
	(1, 359),
	(1, 360),
	(1, 361),
	(1, 362),
	(1, 363),
	(1, 364),
	(1, 365),
	(1, 366),
	(1, 367),
	(1, 368),
	(1, 369),
	(1, 374),
	(1, 375),
	(1, 376),
	(1, 377),
	(1, 378),
	(1, 379),
	(1, 380),
	(1, 381),
	(2, 85),
	(2, 115),
	(2, 133),
	(2, 134),
	(2, 135),
	(2, 326),
	(2, 327),
	(2, 328),
	(2, 329),
	(2, 335),
	(2, 355),
	(2, 359),
	(3, 133);

-- Dumping structure for table antrian.setting_app
CREATE TABLE IF NOT EXISTS `setting_app` (
  `param` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table antrian.setting_app: ~1 rows (approximately)
INSERT INTO `setting_app` (`param`, `value`) VALUES
	('using_printer', 'N');

-- Dumping structure for table antrian.setting_app_tampilan
CREATE TABLE IF NOT EXISTS `setting_app_tampilan` (
  `param` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`param`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Dumping data for table antrian.setting_app_tampilan: 5 rows
/*!40000 ALTER TABLE `setting_app_tampilan` DISABLE KEYS */;
INSERT INTO `setting_app_tampilan` (`param`, `value`) VALUES
	('color_scheme', 'purple'),
	('sidebar_color', 'dark'),
	('logo_background_color', 'dark'),
	('font_family', 'poppins'),
	('font_size', '14.5');
/*!40000 ALTER TABLE `setting_app_tampilan` ENABLE KEYS */;

-- Dumping structure for table antrian.setting_app_user
CREATE TABLE IF NOT EXISTS `setting_app_user` (
  `id_user` int(11) unsigned NOT NULL,
  `param` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Dumping data for table antrian.setting_app_user: 1 rows
/*!40000 ALTER TABLE `setting_app_user` DISABLE KEYS */;
INSERT INTO `setting_app_user` (`id_user`, `param`) VALUES
	(2, '{"color_scheme":"blue-dark","sidebar_color":"dark","logo_background_color":"default","font_family":"open-sans","font_size":"15"}');
/*!40000 ALTER TABLE `setting_app_user` ENABLE KEYS */;

-- Dumping structure for table antrian.setting_layar
CREATE TABLE IF NOT EXISTS `setting_layar` (
  `id_setting_layar` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_setting` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_setting_layar`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table antrian.setting_layar: ~2 rows (approximately)
INSERT INTO `setting_layar` (`id_setting_layar`, `nama_setting`) VALUES
	(1, 'Layar Pelayanan'),
	(2, 'Layar Poliklinik');

-- Dumping structure for table antrian.setting_layar_detail
CREATE TABLE IF NOT EXISTS `setting_layar_detail` (
  `id_setting_layar` int(11) unsigned NOT NULL,
  `id_antrian_kategori` int(11) unsigned NOT NULL,
  `urut` tinyint(3) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table antrian.setting_layar_detail: ~7 rows (approximately)
INSERT INTO `setting_layar_detail` (`id_setting_layar`, `id_antrian_kategori`, `urut`) VALUES
	(1, 2, 1),
	(1, 3, 2),
	(2, 5, 1),
	(2, 4, 2),
	(2, 1, 3),
	(2, 6, 4),
	(2, 7, 5);

-- Dumping structure for table antrian.setting_layar_layout
CREATE TABLE IF NOT EXISTS `setting_layar_layout` (
  `param` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`param`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table antrian.setting_layar_layout: ~8 rows (approximately)
INSERT INTO `setting_layar_layout` (`param`, `value`) VALUES
	('color_scheme', 'gradient'),
	('font_family', 'poppins'),
	('font_size', '100'),
	('jenis_video', 'folder'),
	('link_video', 'public/videos/'),
	('text_footer', 'JAM BUKA LAYANAN KAMI ADALAH PUKUL 07:00 s.d 21.00. TERIMA KASIH ATAS KUNJUNGAN ANDA . KAMI SENANTIASA MELAYANI SEPENUH HATI'),
	('text_footer_mode', 'statis'),
	('text_footer_speed', '25');

-- Dumping structure for table antrian.setting_printer
CREATE TABLE IF NOT EXISTS `setting_printer` (
  `id_setting_printer` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_setting_printer` varchar(255) DEFAULT NULL,
  `alamat_server` varchar(255) DEFAULT NULL,
  `aktif` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_setting_printer`),
  UNIQUE KEY `nama_setting_printer` (`nama_setting_printer`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table antrian.setting_printer: ~2 rows (approximately)
INSERT INTO `setting_printer` (`id_setting_printer`, `nama_setting_printer`, `alamat_server`, `aktif`) VALUES
	(1, 'Printer Pengunjung', 'smb://LOCALHOST/POS58', 0),
	(2, 'Printer Back Office', 'smb://LOCALHOST/POS57', 0);

-- Dumping structure for table antrian.setting_register
CREATE TABLE IF NOT EXISTS `setting_register` (
  `param` varchar(255) NOT NULL,
  `value` tinytext DEFAULT NULL,
  PRIMARY KEY (`param`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table antrian.setting_register: ~3 rows (approximately)
INSERT INTO `setting_register` (`param`, `value`) VALUES
	('enable', 'Y'),
	('id_role', '2'),
	('metode_aktivasi', 'email');

-- Dumping structure for table antrian.setting_web
CREATE TABLE IF NOT EXISTS `setting_web` (
  `param` varchar(255) NOT NULL,
  `value` tinytext DEFAULT NULL,
  PRIMARY KEY (`param`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table antrian.setting_web: ~10 rows (approximately)
INSERT INTO `setting_web` (`param`, `value`) VALUES
	('background_logo', 'transparent'),
	('btn_login', 'btn-danger'),
	('deskripsi_web', 'Apliaksi antrian professional berbasis web lengkap dengan suara.'),
	('favicon', 'favicon.png'),
	('footer_app', '© {{YEAR}} <a href="https://jagowebdev.com" target="_blank">www.Jagowebdev.com</a>'),
	('footer_login', '© {{YEAR}} <a href="https://jagowebdev.com" target="_blank">Jagowebdev.com</a>'),
	('judul_web', 'Aplikasi Antrian Jagowebdev'),
	('logo_app', 'logo_aplikasi.png'),
	('logo_login', 'logo_login.png'),
	('logo_register', 'logo_register.png');

-- Dumping structure for table antrian.user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verified` tinyint(4) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `created` datetime NOT NULL DEFAULT curdate(),
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT COMMENT='Tabel user untuk login';

-- Dumping data for table antrian.user: ~3 rows (approximately)
INSERT INTO `user` (`id_user`, `email`, `username`, `nama`, `password`, `verified`, `status`, `created`, `avatar`) VALUES
	(1, 'prawoto.hadi@gmail.com', 'admin', 'Agus Prawoto Hadi', '$2y$10$luCbrAdrDWgxckIYfjQymeeN.6WuV656.MNUth8AxF94H8Mb.enmK', 1, 0, '2018-09-20 16:04:35', 'Agus Prawoto Hadi.png'),
	(3, 'user.administrasi@gmail.com', 'user', 'User Administrasi', '$2y$10$n2hGjOQUW2EYRskCF2rgaOJR5w0dR3h8hqWln/5OXkAW2XT6vpujO', 1, 1, '2020-04-05 10:12:22', 'Ahmad Basuki.png'),
	(5, 'guest@gmail.com', 'guest', 'Guest', '$2y$10$FjaeXtJ7f/vrOfCJuUW2GebEVuTgOEhlVpQ3jtY4BDGlfUaWsPz4G', 1, 1, '2022-02-14 00:00:00', '');

-- Dumping structure for table antrian.user_login_activity
CREATE TABLE IF NOT EXISTS `user_login_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `id_activity` tinyint(4) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_login_activity_user` (`id_user`),
  CONSTRAINT `user_login_activity_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Dumping data for table antrian.user_login_activity: ~15 rows (approximately)
INSERT INTO `user_login_activity` (`id`, `id_user`, `id_activity`, `time`) VALUES
	(1, 1, 1, '2022-06-01 09:47:55'),
	(2, 1, 1, '2022-06-01 09:50:16'),
	(3, 1, 1, '2022-06-10 04:46:58'),
	(4, 1, 1, '2022-07-03 05:50:22'),
	(5, 1, 1, '2022-07-03 06:57:22'),
	(6, 1, 1, '2022-07-03 17:38:44'),
	(7, 1, 1, '2022-07-09 16:30:06'),
	(8, 1, 1, '2022-07-11 05:48:28'),
	(9, 1, 1, '2022-07-11 08:15:26'),
	(10, 1, 1, '2022-07-12 05:09:28'),
	(11, 1, 1, '2022-07-16 12:23:54'),
	(12, 1, 1, '2022-07-17 05:02:44'),
	(13, 1, 1, '2022-07-17 07:19:24'),
	(14, 1, 1, '2022-07-17 12:40:23'),
	(15, 1, 1, '2022-07-17 13:02:05');

-- Dumping structure for table antrian.user_login_activity_ref
CREATE TABLE IF NOT EXISTS `user_login_activity_ref` (
  `id_activity` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(50) NOT NULL,
  PRIMARY KEY (`id_activity`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table antrian.user_login_activity_ref: ~0 rows (approximately)

-- Dumping structure for table antrian.user_role
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `id_role` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_role_module` (`id_user`),
  KEY `module_role_role` (`id_role`),
  CONSTRAINT `user_role_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT COMMENT='Tabel yang berisi role yang dimili oleh masing masing user';

-- Dumping data for table antrian.user_role: ~3 rows (approximately)
INSERT INTO `user_role` (`id`, `id_user`, `id_role`) VALUES
	(1, 1, 1),
	(5, 3, 2),
	(7, 5, 2);

-- Dumping structure for table antrian.user_token
CREATE TABLE IF NOT EXISTS `user_token` (
  `selector` varchar(255) CHARACTER SET latin1 NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 NOT NULL,
  `action` enum('register','remember','recovery','activation') CHARACTER SET latin1 NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`selector`),
  KEY `user_token_user` (`id_user`),
  CONSTRAINT `user_token_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table antrian.user_token: ~3 rows (approximately)
INSERT INTO `user_token` (`selector`, `token`, `action`, `id_user`, `created`, `expires`) VALUES
	('076fdd45d7ebbcdd4a', '75dcbaa30b9d0c5a1007ede43158f7a290a7593d4e0bf22ca1c06fde8a3be6c7', 'remember', 1, '2022-07-03 05:50:22', '2022-07-10 05:50:22'),
	('1c4c266f45e7996aa4', '9b46d8ba31ea065a1e2481b747a55ba96261482c996fdd518b581cfa53077556', 'remember', 1, '2022-06-10 04:46:58', '2022-06-17 04:46:58'),
	('e2dad81b9c43c3f794', '1323a42591f02503e274d1d7aef0cef49b41e39e1baa869429174534f7797f34', 'remember', 1, '2022-07-09 16:30:06', '2022-07-16 16:30:06');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
