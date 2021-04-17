-- phpMyAdmin SQL Dump
-- version 5.0.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 28, 2020 at 07:58 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19
--test

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emow`
--

-- --------------------------------------------------------

--
-- Table structure for table `ahli`
--

CREATE TABLE `ahli` (
  `id_ah` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `pend_ah` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kat` enum('penyuluh','inseminator') COLLATE utf8_unicode_ci DEFAULT NULL,
  `avail` tinyint(1) NOT NULL,
  `thn_mulai` int(4) DEFAULT NULL,
  `last_seen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ahli`
--

INSERT INTO `ahli` (`id_ah`, `id_user`, `pend_ah`, `kat`, `avail`, `thn_mulai`, `last_seen`) VALUES
(1, 7, 'Institut Pertanian Bogor', 'penyuluh', 0, 2014, '2020-09-04 07:47:55');

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id_a` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `img` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `judul` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `isi` text COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `view` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id_a`, `id_user`, `img`, `judul`, `isi`, `file`, `view`, `created`) VALUES
(3, 10, 'quotacowisne.jpg', 'Cara Memelihara Sapi dengan baik dan benar', 'Cara Memelihara Sapi dengan baik dan benar menurut para ahli adalah dengan cara ......\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et laoreet mauris. Ut sit amet vestibulum lorem. Fusce nunc mauris, sollicitudin pellentesque ex in, porta condimentum libero. Donec aliquam non est varius sodales. Integer mattis convallis ex ut sollicitudin. Fusce dignissim ornare nisi sed tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In ullamcorper felis ipsum, sed pharetra enim maximus et. Maecenas at purus rutrum, pellentesque nulla eu, porttitor lorem. Maecenas bibendum pulvinar blandit. Morbi nulla lacus, rhoncus eu lectus ac, viverra ultrices purus.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et laoreet mauris. Ut sit amet vestibulum lorem. Fusce nunc mauris, sollicitudin pellentesque ex in, porta condimentum libero. Donec aliquam non est varius sodales. Integer mattis convallis ex ut sollicitudin. Fusce dignissim ornare nisi sed tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In ullamcorper felis ipsum, sed pharetra enim maximus et. Maecenas at purus rutrum, pellentesque nulla eu, porttitor lorem. Maecenas bibendum pulvinar blandit. Morbi nulla lacus, rhoncus eu lectus ac, viverra ultrices purus.', 'robbins.pdf', 19, '2020-06-12 21:27:09'),
(4, 10, 'brown-Guernsey-cow.jpg', 'Makanan Sapi Ber nutrisi', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et laoreet mauris. Ut sit amet vestibulum lorem. Fusce nunc mauris, sollicitudin pellentesque ex in, porta condimentum libero. Donec aliquam non est varius sodales. Integer mattis convallis ex ut sollicitudin. Fusce dignissim ornare nisi sed tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In ullamcorper felis ipsum, sed pharetra enim maximus et. Maecenas at purus rutrum, pellentesque nulla eu, porttitor lorem. Maecenas bibendum pulvinar blandit. Morbi nulla lacus, rhoncus eu lectus ac, viverra ultrices purus.', 'robbins.pdf', 21, '2020-06-12 21:52:22'),
(5, 10, 'cow-field-one-health-uc-davis.jpg', 'Wow Susu Sapi Ternyata punya manfaat ini', 'Lorem Ipsum Dolor Sit Amet Sapi', 'chat.mp3', 4, '2020-06-13 06:41:27');

-- --------------------------------------------------------

--
-- Table structure for table `biaya`
--

CREATE TABLE `biaya` (
  `id_b` int(11) NOT NULL,
  `id_p` int(11) NOT NULL,
  `id_k` int(11) NOT NULL,
  `tahun` int(4) NOT NULL,
  `bulan` int(2) NOT NULL,
  `mingguke` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `biaya`
--

INSERT INTO `biaya` (`id_b`, `id_p`, `id_k`, `tahun`, `bulan`, `mingguke`) VALUES
(2, 6, 9, 2020, 7, 1),
(4, 6, 9, 2020, 7, 0),
(5, 8, 9, 2020, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `biaya_ext`
--

CREATE TABLE `biaya_ext` (
  `id_be` int(11) NOT NULL,
  `id_b` int(11) NOT NULL,
  `nama_b` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `jenis` enum('kredit','debit') COLLATE utf8_unicode_ci NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `biaya_ext`
--

INSERT INTO `biaya_ext` (`id_be`, `id_b`, `nama_b`, `jenis`, `nominal`) VALUES
(2, 2, 'Insulasi', 'kredit', 3000),
(3, 2, 'Insulasi2', 'debit', 2000),
(5, 2, 'Insulasi3', 'kredit', 4000),
(7, 4, 'hehe', 'kredit', 1000),
(8, 5, 'Biaya1', 'kredit', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id_chat` int(11) NOT NULL,
  `id_u1` int(11) NOT NULL,
  `id_u2` int(11) NOT NULL,
  `created` timestamp NOT NULL,
  `closed` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `rating` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id_chat`, `id_u1`, `id_u2`, `created`, `closed`, `status`, `rating`) VALUES
(10, 8, 7, '2020-07-13 06:53:33', '2020-07-13 06:58:00', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `deauthor`
--

CREATE TABLE `deauthor` (
  `id_de` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `pend_de` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `deauthor`
--

INSERT INTO `deauthor` (`id_de`, `id_user`, `pend_de`) VALUES
(1, 10, 'Institut Pertanian Bogor');

-- --------------------------------------------------------

--
-- Table structure for table `isichat`
--

CREATE TABLE `isichat` (
  `id_isichat` int(11) NOT NULL,
  `id_chat` int(11) NOT NULL,
  `who` enum('u1','u2') COLLATE utf8_unicode_ci NOT NULL,
  `isi` text COLLATE utf8_unicode_ci NOT NULL,
  `seen` tinyint(1) NOT NULL,
  `created` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `isichat`
--

INSERT INTO `isichat` (`id_isichat`, `id_chat`, `who`, `isi`, `seen`, `created`) VALUES
(150, 10, 'u1', 'Test', 1, '2020-07-13 06:53:38'),
(151, 10, 'u2', 'test', 1, '2020-07-13 06:54:22');

-- --------------------------------------------------------

--
-- Table structure for table `koperasi`
--

CREATE TABLE `koperasi` (
  `id_koperasi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_kp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `sejarah` text COLLATE utf8_unicode_ci,
  `alamat` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `koperasi`
--

INSERT INTO `koperasi` (`id_koperasi`, `id_user`, `nama_kp`, `tgl`, `sejarah`, `alamat`) VALUES
(1, 9, 'Koperasi Doa Ibu', '2020-06-01', 'Lorem Ipsum Dolor sit amer', 'Jl. Baru Bangett');

-- --------------------------------------------------------

--
-- Table structure for table `peternak`
--

CREATE TABLE `peternak` (
  `id_pt` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_kop` int(11) DEFAULT NULL,
  `kop_stat` tinyint(1) NOT NULL DEFAULT '0',
  `ttl` date DEFAULT NULL,
  `pend_pt` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thn_mulai` int(4) DEFAULT NULL,
  `last_seen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `peternak`
--

INSERT INTO `peternak` (`id_pt`, `id_user`, `id_kop`, `kop_stat`, `ttl`, `pend_pt`, `thn_mulai`, `last_seen`) VALUES
(1, 6, 1, 1, '1998-09-12', 'Institut Pertanian Bogor', 2012, '2020-10-10 09:17:14'),
(2, 8, 1, 1, '2020-07-14', 'Sekolah Vokasi IPB', 2010, '2020-10-10 09:17:14');

-- --------------------------------------------------------

--
-- Table structure for table `setor`
--

CREATE TABLE `setor` (
  `id_s` int(11) NOT NULL,
  `id_p` int(11) NOT NULL,
  `id_k` int(11) NOT NULL,
  `bagian` enum('pagi','sore') COLLATE utf8_unicode_ci NOT NULL,
  `jumlah` int(11) NOT NULL,
  `biaya_susu` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setor`
--

INSERT INTO `setor` (`id_s`, `id_p`, `id_k`, `bagian`, `jumlah`, `biaya_susu`, `tgl`, `total`) VALUES
(1, 6, 9, 'pagi', 5, 2000, '2020-07-10', 10000),
(2, 6, 9, 'pagi', 10, 3000, '2020-07-11', 30000),
(3, 6, 9, 'sore', 10, 2000, '2020-07-15', 20000),
(4, 8, 9, 'pagi', 5, 2000, '2020-07-13', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `ternak`
--

CREATE TABLE `ternak` (
  `id_ternak` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `no_ternak` int(11) NOT NULL,
  `bulan` int(2) NOT NULL,
  `tahun` int(4) NOT NULL,
  `dara` enum('Bunting','Siap kawin') COLLATE utf8_unicode_ci NOT NULL,
  `pedet` enum('Betina','Jantan') COLLATE utf8_unicode_ci NOT NULL,
  `created` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ternak`
--

INSERT INTO `ternak` (`id_ternak`, `id_user`, `no_ternak`, `bulan`, `tahun`, `dara`, `pedet`, `created`) VALUES
(2, 6, 2, 10, 1, 'Siap kawin', 'Jantan', '2020-06-12 14:42:34'),
(3, 6, 2, 2, 10, 'Bunting', 'Betina', '2020-06-12 15:41:35'),
(4, 8, 1, 2, 10, 'Bunting', 'Betina', '2020-06-16 13:04:45'),
(5, 8, 2, 1, 1, 'Bunting', 'Betina', '2020-06-16 13:16:01'),
(6, 8, 3, 5, 2, 'Siap kawin', 'Jantan', '2020-07-13 07:03:50');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `uname` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nama` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dp` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `role` enum('admin','deauthor','peternak','ahli','koperasi') COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `uname`, `pass`, `email`, `nama`, `dp`, `role`, `status`, `created`) VALUES
(1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'yazfdlh@gmail.com', 'Diaz Fadilah', '1', 'admin', 1, '2020-06-06 19:29:18'),
(6, 'peternak1', '827ccb0eea8a706c4c34a16891f84e7b', 'test1@mail.com', 'Saya Peternak', '6', 'peternak', 1, '2020-06-07 02:40:31'),
(7, 'penyuluh1', '827ccb0eea8a706c4c34a16891f84e7b', 'penyuluh@mail.com', 'Penyuluh S.Pt', '7', 'ahli', 1, '2020-06-08 14:14:43'),
(8, 'peternak2', '827ccb0eea8a706c4c34a16891f84e7b', 'test@mail.com', 'Bambang', '8', 'peternak', 1, '2020-06-08 19:36:00'),
(9, 'koperasi', '827ccb0eea8a706c4c34a16891f84e7b', 'koperasi@mail.com', 'Koperasi1', '9', 'koperasi', 1, '2020-06-12 16:00:41'),
(10, 'admindu', '827ccb0eea8a706c4c34a16891f84e7b', 'admindu@mail.com', 'Admin DU', '10', 'deauthor', 1, '2020-06-12 16:35:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ahli`
--
ALTER TABLE `ahli`
  ADD PRIMARY KEY (`id_ah`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id_a`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `biaya`
--
ALTER TABLE `biaya`
  ADD PRIMARY KEY (`id_b`),
  ADD KEY `id_k` (`id_k`),
  ADD KEY `id_p` (`id_p`);

--
-- Indexes for table `biaya_ext`
--
ALTER TABLE `biaya_ext`
  ADD PRIMARY KEY (`id_be`),
  ADD KEY `biaya_ext_ibfk_1` (`id_b`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `id_u1` (`id_u1`),
  ADD KEY `id_u2` (`id_u2`);

--
-- Indexes for table `deauthor`
--
ALTER TABLE `deauthor`
  ADD PRIMARY KEY (`id_de`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `isichat`
--
ALTER TABLE `isichat`
  ADD PRIMARY KEY (`id_isichat`),
  ADD KEY `id_chat` (`id_chat`);

--
-- Indexes for table `koperasi`
--
ALTER TABLE `koperasi`
  ADD PRIMARY KEY (`id_koperasi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `peternak`
--
ALTER TABLE `peternak`
  ADD PRIMARY KEY (`id_pt`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_kop` (`id_kop`);

--
-- Indexes for table `setor`
--
ALTER TABLE `setor`
  ADD PRIMARY KEY (`id_s`),
  ADD KEY `id_p` (`id_p`),
  ADD KEY `id_k` (`id_k`);

--
-- Indexes for table `ternak`
--
ALTER TABLE `ternak`
  ADD PRIMARY KEY (`id_ternak`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ahli`
--
ALTER TABLE `ahli`
  MODIFY `id_ah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id_a` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `biaya`
--
ALTER TABLE `biaya`
  MODIFY `id_b` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `biaya_ext`
--
ALTER TABLE `biaya_ext`
  MODIFY `id_be` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `deauthor`
--
ALTER TABLE `deauthor`
  MODIFY `id_de` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `isichat`
--
ALTER TABLE `isichat`
  MODIFY `id_isichat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `koperasi`
--
ALTER TABLE `koperasi`
  MODIFY `id_koperasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `peternak`
--
ALTER TABLE `peternak`
  MODIFY `id_pt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `setor`
--
ALTER TABLE `setor`
  MODIFY `id_s` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ternak`
--
ALTER TABLE `ternak`
  MODIFY `id_ternak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ahli`
--
ALTER TABLE `ahli`
  ADD CONSTRAINT `ahli_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `artikel_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `biaya`
--
ALTER TABLE `biaya`
  ADD CONSTRAINT `biaya_ibfk_1` FOREIGN KEY (`id_k`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `biaya_ibfk_2` FOREIGN KEY (`id_p`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `biaya_ext`
--
ALTER TABLE `biaya_ext`
  ADD CONSTRAINT `biaya_ext_ibfk_1` FOREIGN KEY (`id_b`) REFERENCES `biaya` (`id_b`);

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`id_u1`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`id_u2`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `deauthor`
--
ALTER TABLE `deauthor`
  ADD CONSTRAINT `deauthor_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `isichat`
--
ALTER TABLE `isichat`
  ADD CONSTRAINT `isichat_ibfk_1` FOREIGN KEY (`id_chat`) REFERENCES `chat` (`id_chat`);

--
-- Constraints for table `koperasi`
--
ALTER TABLE `koperasi`
  ADD CONSTRAINT `koperasi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `peternak`
--
ALTER TABLE `peternak`
  ADD CONSTRAINT `peternak_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `peternak_ibfk_2` FOREIGN KEY (`id_kop`) REFERENCES `koperasi` (`id_koperasi`);

--
-- Constraints for table `setor`
--
ALTER TABLE `setor`
  ADD CONSTRAINT `setor_ibfk_1` FOREIGN KEY (`id_p`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `setor_ibfk_2` FOREIGN KEY (`id_k`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `ternak`
--
ALTER TABLE `ternak`
  ADD CONSTRAINT `ternak_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

