-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2025 at 09:22 AM
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
-- Database: `mvc-library`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`) VALUES
(1, 'admin', 'admin', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `nama`, `username`, `password`) VALUES
(1, 'andrew', 'andrew', '12345'),
(9, 'qqq', 'qqq', '111');

-- --------------------------------------------------------

--
-- Table structure for table `library_system`
--

CREATE TABLE `library_system` (
  `id` int(11) NOT NULL,
  `nama_buku` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `penerbit_buku` varchar(255) NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `statuss` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `library_system`
--

INSERT INTO `library_system` (`id`, `nama_buku`, `penulis`, `penerbit_buku`, `isbn`, `statuss`) VALUES
(3, 'Dasar-Dasar MySQL', 'Budi Santoso', 'Gramedia', '978-602-02-1234-2', ''),
(4, 'JavaScript: Panduan Lengkap', 'Joko Prasetyo', 'Penerbit Elex Media', '978-979-29-9999-9', ''),
(5, 'Belajar Python dengan Mudah', 'Siti Aisyah', 'Penerbit Pustaka', '978-602-03-9999-8', ''),
(6, 'Framework Laravel untuk Web Development', 'Rina Kurniawati', 'Penerbit Sinergi', '978-602-02-6789-7', ''),
(7, 'HTML & CSS: Panduan Lengkap', 'Dedi Setiawan', 'Penerbit Educa', '978-602-02-4567-5', ''),
(8, 'PHP dan MySQL untuk Pemula', 'Wahyu Aji', 'Penerbit Informatika', '978-979-11-8888-4', ''),
(9, 'Java: Dari Pemula hingga Mahir', 'Tommy Rahmat', 'Penerbit Informatika', '978-602-02-1133-5', ''),
(10, 'Pengembangan Aplikasi Mobile dengan Flutter', 'Fahmi Rizky', 'Penerbit Pustaka Belajar', '978-602-11-5555-6', ''),
(11, 'Kotlin untuk Android Development', 'Rani Mulya', 'Penerbit Teknologi', '978-602-01-9876-0', ''),
(12, 'Kotlin untuk Web Development', 'Andrew Lin', 'Penerbit Informatika', '978-602-01-9876-11', ''),
(14, 'The Understanding of Big Data', 'Andi Setiawan', 'Penerbit Teknologi ', '978-602-01-9876-12', ''),
(15, 'Data mining', 'Wahyu Wawan', 'Penerbit Teknologi', '978-602-01-9876-13', ''),
(16, 'Code Igniter: Dari Pemula hingga Mahir ', 'Wahyu Setiadi', 'Penerbit Alfabeta', '978-602-01-9876-15', ''),
(17, 'Data mining in Transgretion', 'Rahayu Jiyaya', 'Penerbit Alfabeta', '978-602-01-9876-17', ''),
(18, 'Pengembangan Aplikasi Mobile dengan Flutter Big Data', 'Gunawan', 'Penerbit Alfabeta', '978-602-01-9876-21', ''),
(23, 'Jungle Book', 'Andrew', 'Penerbit Alfabeta', '978-602-01-9876-34', ''),
(24, 'Kotlin untuk Web Development', 'Andrew Lin', 'Penerbit Alfabeta', '978-602-01-9876-89', ''),
(25, 'Data mining', 'Andi Setiawan', 'Penerbit Teknologi', '978-602-01-9876-157', ''),
(28, 'Jungle Book', 'Andi Setiawan', 'Penerbit Erlangga', '978-602-01-9876-1112', ''),
(29, 'The Principle of Big Data Statistic', 'Wahyu Setiadi', 'Penerbit Informatika	', '978-602-01-9876-157', ''),
(34, 'The Principle of Big Data Statistic', 'Wahyu Setiadi', 'Penerbit Informatika	', '978-602-01-9876-157', ''),
(35, 'Jungle Book', 'Andi Setiawan', 'Penerbit Erlanggaq', '978-602-01-9876-1112', ''),
(36, 'Jungle Book', 'Andi Setiawan', 'Penerbit Erlanggaq', '978-602-01-9876-1112', '');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `penulis_buku` varchar(255) NOT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `judul_buku`, `penulis_buku`, `tanggal_pinjam`, `tanggal_kembali`, `username`) VALUES
(19, 'Pemrograman PHP untuk Pemula', 'Andi Wijaya', '2024-12-09', '2024-12-16', ''),
(20, 'JavaScript: Panduan Lengkap', 'Joko Prasetyo', '2024-12-04', '2024-12-11', ''),
(22, 'Pengembangan Aplikasi Mobile dengan Flutter', 'Fahmi Rizky', '2024-12-11', '2024-12-18', ''),
(23, 'Belajar Python dengan Mudah', 'Siti Aisyah', '2024-12-04', '2024-12-11', ''),
(24, 'Code Igniter: Dari Pemula hingga Mahir ', 'Wahyu Setiadi', '2024-12-04', '2024-12-11', ''),
(25, 'Pemrograman PHP untuk Pemula', 'Rahayu Wijaya', '2024-12-17', '2024-12-24', ''),
(26, 'Pemrograman PHP untuk Pemula', 'Rahayu Wijaya', '2024-12-10', '2024-12-17', ''),
(27, 'Pemrograman PHP untuk Pemula', 'Rahayu Wijaya', '2024-12-03', '2024-12-10', ''),
(28, 'Java: Dari Pemula hingga Mahir', 'Tommy Rahmat', '2024-12-06', '2024-12-13', ''),
(29, 'Kotlin untuk Web Development', 'Andrew Lin', '2024-12-06', '2024-12-13', ''),
(30, 'The Understanding of Big Data', 'Andi Setiawan', '2024-12-31', '2025-01-07', ''),
(31, 'Belajar Python dengan Mudah', 'Siti Aisyah', '2024-12-31', '2025-01-07', 'andrew'),
(32, 'Pemrograman PHP untuk Pemula', 'Rahayu Wijaya', '2024-12-31', '2025-01-07', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_system`
--
ALTER TABLE `library_system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `library_system`
--
ALTER TABLE `library_system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
