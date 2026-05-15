-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2025 at 08:15 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logistik`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` varchar(50) NOT NULL DEFAULT 'AUTO_INCREMENT',
  `nama_barang` varchar(50) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `stok` int(25) DEFAULT NULL,
  `terakhir_masuk` datetime DEFAULT NULL,
  `terakhir_keluar` datetime DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `kategori`, `stok`, `terakhir_masuk`, `terakhir_keluar`, `username`) VALUES
('ATK-012', 'Pulpen', 'ATK', 333, '2024-11-24 22:39:30', NULL, NULL),
('ATK-129', 'Stiker Label', 'ATK', 0, NULL, NULL, NULL),
('ATK-174', 'Klip Kertas', 'ATK', 0, NULL, NULL, NULL),
('ATK-245', 'Kertas HVS', 'ATK', 0, NULL, NULL, NULL),
('ATK-277', 'Kertas Label', 'ATK', 0, NULL, NULL, NULL),
('ATK-280', 'Spidol', 'ATK', 0, NULL, NULL, NULL),
('ATK-310', 'Kertas Foto', 'ATK', 0, NULL, NULL, NULL),
('ATK-368', 'Printer', 'ATK', 45, '2024-11-24 22:38:58', NULL, NULL),
('ATK-465', 'Gunting', 'ATK', 0, NULL, NULL, NULL),
('ATK-573', 'Tinta Printer', 'ATK', 0, NULL, NULL, NULL),
('ATK-801', 'Staples', 'ATK', 0, NULL, NULL, NULL),
('ATK-819', 'Buku Agenda', 'ATK', 0, NULL, NULL, NULL),
('ATK-874', 'Buku Catatan', 'ATK', 234, '2024-11-18 10:51:16', NULL, NULL),
('ATK-936', 'Pensil', 'ATK', 0, NULL, NULL, NULL),
('ATK-949', 'Stapler', 'ATK', 22, '2024-11-24 22:39:45', NULL, NULL),
('ATK-974', 'Papan Klip', 'ATK', 0, NULL, NULL, NULL),
('MD-117', 'Plester operasi', 'Medis', 0, NULL, NULL, NULL),
('MD-249', 'Perban', 'Medis', 0, NULL, NULL, NULL),
('MD-336', 'alkoholik', 'Medis', 311, '2024-11-25 11:33:32', '2024-11-25 11:33:37', NULL),
('MD-358', 'Bahan Desinfektan', 'Medis', 600, '2024-11-18 10:51:10', '2024-11-25 10:56:11', NULL),
('MD-393', 'Alat Tes Urin', 'Medis', 44, '2025-01-05 20:51:55', NULL, NULL),
('MD-440', 'pensil sikkk', 'Medis', 0, NULL, NULL, NULL),
('MD-488', 'Alat Pelindung Diri (APD)', 'Medis', 20, '2025-01-05 20:48:26', '2025-01-05 20:58:49', NULL),
('MD-491', 'Sarung Tangan	', 'Medis', 33, '2024-11-25 11:36:46', NULL, NULL),
('MD-521', 'Infus', 'Medis', 0, NULL, NULL, NULL),
('MD-555', 'Jarum Suntik', 'Medis', 69, '2024-11-18 08:43:12', '2024-11-18 08:43:23', NULL),
('MD-594', 'Termometer Digital	', 'Medis', 344, '2024-11-25 11:37:02', NULL, NULL),
('MD-628', 'Alcohol', 'Medis', 222, '2024-11-18 10:50:30', NULL, NULL),
('MD-706', 'Masker Bedah', 'Medis', 66, '2024-11-24 22:45:09', NULL, NULL),
('MD-719', 'Pipet obat', 'Medis', 0, NULL, NULL, NULL),
('MD-722', 'Alat Sterilisasi', 'Medis', 24, '2024-11-25 02:23:05', '2024-11-25 10:55:56', NULL),
('MD-738', 'Kantong Darah', 'Medis', 0, NULL, NULL, NULL),
('MD-783', 'Tensimeter	', 'Medis', 465, '2024-11-25 11:36:56', NULL, NULL),
('MD-828', 'Plester Luka	', 'Medis', 131, '2024-11-24 22:39:08', NULL, NULL),
('MD-866', 'Perban Elastis', 'Medis', 0, NULL, NULL, NULL),
('MD-945', 'O2', 'Medis', 90, '2024-11-24 22:45:21', NULL, NULL),
('MD-949', 'Alat Cek Kolesterol', 'Medis', 9, '2025-01-05 21:29:11', '2025-01-05 21:29:17', NULL),
('MD-967', 'Stetoskop	', 'Medis', 22, '2024-11-24 22:40:05', NULL, NULL),
('NM-011', 'Gelas Plastik', 'Non-Medis', 0, NULL, NULL, NULL),
('NM-057', 'Lemari Arsip', 'Non-Medis', 0, NULL, NULL, NULL),
('NM-124', 'Kipas Angin', 'Non-Medis', 0, NULL, NULL, NULL),
('NM-191', 'Kursi Tunggu Pasien', 'Non-Medis', 0, NULL, NULL, NULL),
('NM-209', 'Kursi Roda', 'Non-Medis', 44, '2024-11-18 10:50:49', NULL, NULL),
('NM-269', 'Meja Operasi	', 'Non-Medis', 2323, '2024-11-18 10:50:43', NULL, NULL),
('NM-286', 'Meja Resepsionis', 'Non-Medis', 0, NULL, NULL, NULL),
('NM-325', 'Alat Pembersih Kaca', 'Non-Medis', 33, '2025-01-05 20:51:25', NULL, NULL),
('NM-362', 'Alat Pemadam Api', 'Non-Medis', 11, '2025-01-05 20:49:06', NULL, NULL),
('NM-411', 'Tempat Sampah', 'Non-Medis', 0, NULL, NULL, NULL),
('NM-413', 'Kursi', 'Non-Medis', 1324, '2024-11-18 10:51:41', NULL, NULL),
('NM-584', 'Rak Penyimpanan Barang', 'Non-Medis', 0, NULL, NULL, NULL),
('NM-611', 'Papan Tulis', 'Non-Medis', 0, NULL, NULL, NULL),
('NM-651', 'contoh', 'Non-Medis', 0, NULL, NULL, NULL),
('NM-710', 'Trolley Pembersih', 'Non-Medis', 0, NULL, NULL, NULL),
('NM-865', 'Kardus', 'Non-Medis', 545, '2024-11-18 10:51:00', NULL, NULL),
('NM-918', 'Lampu Operasi	', 'Non-Medis', 67, '2024-11-18 10:51:52', NULL, NULL),
('NM-920', 'Tempat Tidur Pasien	', 'Non-Medis', 21, '2024-11-24 22:39:58', '2024-11-24 22:43:04', NULL),
('NM-932', 'Lampu Meja', 'Non-Medis', 0, NULL, NULL, NULL),
('NM-946', 'Kursi Kantor', 'Non-Medis', 0, NULL, NULL, NULL),
('NM-954', 'meja rapat', 'Non-Medis', 7, '2025-01-02 09:17:32', '2025-01-02 09:18:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_bk` varchar(50) NOT NULL DEFAULT '',
  `id_barang` varchar(50) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `terakhir_keluar` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_bk`, `id_barang`, `kategori`, `jumlah`, `terakhir_keluar`) VALUES
('25', 'MD-555', 'Medis', 31, '2024-11-18 08:43:23'),
('26', 'NM-920', 'Non-Medis', 1, '2024-11-24 22:43:04'),
('27', 'MD-722', 'Medis', 11, '2024-11-25 10:55:56'),
('29', 'MD-358', 'Medis', 55, '2024-11-25 10:56:11'),
('30', 'MD-336', 'Medis', 22, '2024-11-25 11:33:37'),
('31', 'NM-954', 'Non-Medis', 3, '2025-01-02 09:18:09'),
('bk-tco', 'MD-949', 'Medis', 1, '2025-01-05 21:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_bm` varchar(50) NOT NULL DEFAULT 'AUTO_INCREMENT',
  `id_barang` varchar(50) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `terakhir_masuk` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_bm`, `id_barang`, `kategori`, `jumlah`, `terakhir_masuk`) VALUES
('1278', 'MD-555', 'Medis', 100, '2024-11-18 08:43:12'),
('1279', 'MD-722', 'Medis', 35, '2024-11-25 02:23:05'),
('1280', 'MD-628', 'Medis', 222, '2024-11-18 10:50:30'),
('1281', 'NM-269', 'Non-Medis', 2323, '2024-11-18 10:50:43'),
('1282', 'NM-209', 'Non-Medis', 44, '2024-11-18 10:50:49'),
('1283', 'NM-865', 'Non-Medis', 545, '2024-11-18 10:51:00'),
('1284', 'MD-358', 'Medis', 655, '2024-11-18 10:51:10'),
('1285', 'ATK-874', 'ATK', 234, '2024-11-18 10:51:16'),
('1287', 'NM-413', 'Non-Medis', 1324, '2024-11-18 10:51:41'),
('1288', 'NM-918', 'Non-Medis', 67, '2024-11-18 10:51:52'),
('1289', 'MD-594', 'Medis', 344, '2024-11-25 11:37:02'),
('1290', 'ATK-368', 'ATK', 45, '2024-11-24 22:38:58'),
('1291', 'MD-828', 'Medis', 131, '2024-11-24 22:39:08'),
('1292', 'ATK-012', 'ATK', 333, '2024-11-24 22:39:30'),
('1293', 'ATK-949', 'ATK', 22, '2024-11-24 22:39:45'),
('1294', 'NM-920', 'Non-Medis', 22, '2024-11-24 22:39:58'),
('1295', 'MD-967', 'Medis', 22, '2024-11-24 22:40:05'),
('1296', 'MD-783', 'Medis', 465, '2024-11-25 11:36:56'),
('1297', 'MD-706', 'Medis', 66, '2024-11-24 22:45:09'),
('1298', 'MD-945', 'Medis', 90, '2024-11-24 22:45:21'),
('1301', 'MD-336', 'Medis', 333, '2024-11-25 11:33:32'),
('1302', 'MD-491', 'Medis', 33, '2024-11-25 11:36:46'),
('1304', 'NM-954', 'Non-Medis', 10, '2025-01-02 09:17:32'),
('bm-h8t', 'MD-393', 'Medis', 44, '2025-01-05 20:51:55'),
('bm-xzg', 'NM-362', 'Non-Medis', 11, '2025-01-05 20:49:06'),
('bm677a8c2f3b8da', 'MD-949', 'Medis', 11, '2025-01-05 21:29:11'),
('bm6e', 'NM-325', 'Non-Medis', 33, '2025-01-05 20:51:25'),
('bmt', 'MD-488', 'Medis', 22, '2025-01-05 20:48:26');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_barang`
--

CREATE TABLE `permintaan_barang` (
  `id_permintaan` varchar(50) NOT NULL DEFAULT 'AUTO_INCREMENT',
  `id_barang` varchar(50) NOT NULL DEFAULT '',
  `jumlah` int(11) NOT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `status` enum('menunggu konfirmasi','Diterima','Ditolak') NOT NULL DEFAULT 'menunggu konfirmasi',
  `keterangan_diterima` varchar(50) NOT NULL DEFAULT '',
  `keterangan_penolakan` varchar(50) DEFAULT '',
  `username` varchar(50) DEFAULT NULL,
  `tanggal_permintaan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permintaan_barang`
--

INSERT INTO `permintaan_barang` (`id_permintaan`, `id_barang`, `jumlah`, `keterangan`, `status`, `keterangan_diterima`, `keterangan_penolakan`, `username`, `tanggal_permintaan`) VALUES
('PB-0367', 'MD-336', 123, NULL, 'Ditolak', '', 'buat sekarang dibatasi untuk pengambilan', 'admin', '2025-01-05 12:17:22'),
('PB-1835', 'ATK-819', 1, 'untuk catatan', '', '', '', 'admin', '2025-01-08 12:36:58'),
('PB-3045', 'NM-651', 32, 'untuk contoh', 'Ditolak', 'ok contoh', 'tolak', 'admin', '2025-01-05 13:49:50'),
('PB-4533', 'MD-628', 32, NULL, 'Diterima', 'siap', '', 'admin', '2025-01-05 12:17:19'),
('PB-5571', 'MD-249', 5, 'butuh di igh secepatnya', 'Diterima', 'nanti langsung ke ruangan saja', '', 'admin', '2025-01-05 19:47:04'),
('PB-5684', 'MD-628', 22, NULL, 'Ditolak', 'ok', 'ga', 'admin', '2025-01-05 12:17:30'),
('PB-8523', 'MD-358', 33, NULL, 'Diterima', 'cuman bisa ambil 5 saja ya ', '', 'admin', '2025-01-05 12:17:25'),
('PB-8536', 'ATK-129', 10, NULL, 'Diterima', 'ambil 5 saja ya mas/mbak', '', 'admin', '2025-01-05 12:39:45'),
('PB-9803', 'MD-949', 22, NULL, 'Diterima', 'nanti ambil di gudang ya\r\n', NULL, 'admin', '2025-01-05 11:12:07');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(25) NOT NULL,
  `departemen` varchar(50) DEFAULT NULL,
  `password` varchar(25) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `departemen`, `password`, `role`, `email`) VALUES
('adi', 'Poli', '1', 'user', 'adi@gmail.com'),
('admin', 'IT', '1', 'admin', 'admin@gmail.com'),
('rama', 'Rawat Inap', '1', 'user', 'rama@gmail.com'),
('rifqi', 'administrasi', '1', 'user', 'rifqi@gmail.com'),
('robait', 'Rawat Jalan', '1', 'user', 'robait@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `FK_barang_user` (`username`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_bk`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_bm`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `permintaan_barang`
--
ALTER TABLE `permintaan_barang`
  ADD PRIMARY KEY (`id_permintaan`),
  ADD KEY `username` (`username`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `FK_barang_user` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `FK_barang_keluar_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `FK_barang_masuk_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `permintaan_barang`
--
ALTER TABLE `permintaan_barang`
  ADD CONSTRAINT `FK_permintaan_barang_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_permintaan_barang_user` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
