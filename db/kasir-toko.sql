-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 27, 2018 at 04:01 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir-toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(15) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `postdate` datetime DEFAULT NULL,
  `time_login` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`kd`, `username`, `password`, `postdate`, `time_login`) VALUES
('e4ea2f7dfb2e5c51e38998599e90afc2', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2011-01-15 14:37:27', '2018-06-27 14:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `admks`
--

CREATE TABLE `admks` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(15) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `postdate` datetime DEFAULT NULL,
  `time_login` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admks`
--

INSERT INTO `admks` (`kd`, `username`, `password`, `postdate`, `time_login`) VALUES
('4e4050f2b46ead637ea2539efaac6566', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2008-01-15 14:43:27', '2010-12-19 14:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `item_laris`
--

CREATE TABLE `item_laris` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `bln` char(2) NOT NULL DEFAULT '',
  `thn` varchar(4) NOT NULL DEFAULT '',
  `kd_brg` varchar(50) NOT NULL DEFAULT '',
  `jml` varchar(10) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_laris`
--

INSERT INTO `item_laris` (`kd`, `bln`, `thn`, `kd_brg`, `jml`) VALUES
('f43757908c58c984d5fb449505700e52', '11', '2008', 'e7aa9eef5badc2e5984d2f6c8e92e287', '45'),
('f43757908c58c984d5fb449505700e52', '11', '2008', '1e16c9eeb928d1232c759d4d34f967b9', '5'),
('23e1578b52fd29fcc1b7b6e575f554a5', '11', '2008', 'f8a9f5afd75a5c31a65d4515a03aaea9', '10'),
('f43757908c58c984d5fb449505700e52', '12', '2008', 'ac53b65e398d2e557a28879b29354dbe', '3'),
('23e1578b52fd29fcc1b7b6e575f554a5', '12', '2008', 'f8a9f5afd75a5c31a65d4515a03aaea9', '1'),
('23e1578b52fd29fcc1b7b6e575f554a5', '6', '2018', '0abad26af31965f36cb5f86992fd1c94', '2');

-- --------------------------------------------------------

--
-- Table structure for table `m_brg`
--

CREATE TABLE `m_brg` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `kd_kategori` varchar(50) NOT NULL DEFAULT '',
  `kd_merk` varchar(50) NOT NULL DEFAULT '',
  `kd_satuan` varchar(50) NOT NULL DEFAULT '',
  `kode` varchar(15) NOT NULL DEFAULT '',
  `barkode` varchar(30) NOT NULL DEFAULT '',
  `nama` varchar(100) NOT NULL DEFAULT '',
  `postdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_brg`
--

INSERT INTO `m_brg` (`kd`, `kd_kategori`, `kd_merk`, `kd_satuan`, `kode`, `barkode`, `nama`, `postdate`) VALUES
('0abad26af31965f36cb5f86992fd1c94', '9aaec1af30395248142cddd279c53779', '5410daca04b041fb47290b77c24a2454', '9965355c9d8131d7ddd519a350710c20', '1', '', '1', '2018-06-27 15:17:26');

-- --------------------------------------------------------

--
-- Table structure for table `m_kategori`
--

CREATE TABLE `m_kategori` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `kategori` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_kategori`
--

INSERT INTO `m_kategori` (`kd`, `kategori`) VALUES
('ad24c2fd4f1fefcc3d65ff8d89201150', 'Jeans Celana'),
('e99d64fc424ac0ada612dc083ed144c0', 'Kaos'),
('d01ba9b34e86a51e0a2f823a8183c1b9', 'Jaket'),
('73a0448c999ffb369d699ced8a478cfd', 'Sweater'),
('9aaec1af30395248142cddd279c53779', 'Celana'),
('c1932e514a82b8831e523315c0520ca5', 'Jeans Jaket'),
('adf1a4c40b43b2483306a49b8c16dc54', 'Gamis'),
('81424c4021f6a5970f1163906885758a', 'BH'),
('26191e312fa179e673125faf7bfe11a6', 'Singlet'),
('c9d0557c2d07a7aa06f5d9740a208fcc', 'Korset');

-- --------------------------------------------------------

--
-- Table structure for table `m_merk`
--

CREATE TABLE `m_merk` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `merk` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_merk`
--

INSERT INTO `m_merk` (`kd`, `merk`) VALUES
('ed6d89e70f28d4064d4e767335a08e41', 'A'),
('5410daca04b041fb47290b77c24a2454', 'Wrangler'),
('edf3d16317e513cc6793badbbd7efbab', 'Polo'),
('b0a0562c9fbe421088ee1ae63fd33b02', 'B'),
('bea5c7fe75b38bf9b78f05b33afe10c3', 'C');

-- --------------------------------------------------------

--
-- Table structure for table `m_satuan`
--

CREATE TABLE `m_satuan` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `satuan` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_satuan`
--

INSERT INTO `m_satuan` (`kd`, `satuan`) VALUES
('9965355c9d8131d7ddd519a350710c20', 'Pcs'),
('aa30d4c29f28c138d7c2fe1fc2fb3d66', 'Set');

-- --------------------------------------------------------

--
-- Table structure for table `nota`
--

CREATE TABLE `nota` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `pelanggan` varchar(100) NOT NULL DEFAULT '',
  `tgl` datetime DEFAULT NULL,
  `no_nota` varchar(20) NOT NULL DEFAULT '',
  `total` varchar(15) NOT NULL DEFAULT '',
  `total_bayar` varchar(15) NOT NULL DEFAULT '',
  `total_kembali` varchar(15) NOT NULL DEFAULT '',
  `pending` enum('true','false') NOT NULL DEFAULT 'false',
  `postdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nota`
--

INSERT INTO `nota` (`kd`, `pelanggan`, `tgl`, `no_nota`, `total`, `total_bayar`, `total_kembali`, `pending`, `postdate`) VALUES
('ee444e3221dded136f0e63a5ea2e71ff', '', '2018-06-27 06:57:53', '20180627065753', '4000', '10000', '6000', 'false', '2018-06-27 06:57:53'),
('c2f4f21a20a51ea6abe7ccd2d28b9ae5', '', '2018-06-27 15:40:52', '20180627154052', '175000', '200000', '25000', 'false', '2018-06-27 15:40:52'),
('bd542c9f60dcf2e68109dfe13d3a4dff', '', '2018-06-27 15:42:44', '20180627154244', '175000', '200000', '25000', 'false', '2018-06-27 15:42:44');

-- --------------------------------------------------------

--
-- Table structure for table `nota_detail`
--

CREATE TABLE `nota_detail` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `kd_nota` varchar(50) NOT NULL DEFAULT '',
  `kd_brg` varchar(50) NOT NULL DEFAULT '',
  `qty` varchar(10) NOT NULL DEFAULT '',
  `subtotal` varchar(15) NOT NULL DEFAULT '',
  `postdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nota_detail`
--

INSERT INTO `nota_detail` (`kd`, `kd_nota`, `kd_brg`, `qty`, `subtotal`, `postdate`) VALUES
('f2864641aba7f8144100ca3eed0505e9', 'c2f4f21a20a51ea6abe7ccd2d28b9ae5', '0abad26af31965f36cb5f86992fd1c94', '1', '175000', '2018-06-27 15:48:52'),
('32f4642f2d6a6f7e8acc74a870845375', 'bd542c9f60dcf2e68109dfe13d3a4dff', '0abad26af31965f36cb5f86992fd1c94', '1', '175000', '2018-06-27 15:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `kd_brg` varchar(50) NOT NULL DEFAULT '',
  `jml_min` varchar(10) NOT NULL DEFAULT '',
  `jml_toko` varchar(10) NOT NULL DEFAULT '',
  `hrg_beli` varchar(15) NOT NULL DEFAULT '',
  `persen` varchar(5) NOT NULL DEFAULT '',
  `hrg_jual` varchar(15) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`kd`, `kd_brg`, `jml_min`, `jml_toko`, `hrg_beli`, `persen`, `hrg_jual`) VALUES
('5c6f544900cd56c778d3c0e3d532bec1', '0abad26af31965f36cb5f86992fd1c94', '10', '203', '140000', '20', '175000');

-- --------------------------------------------------------

--
-- Table structure for table `stock_hilang`
--

CREATE TABLE `stock_hilang` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `kd_brg` varchar(50) NOT NULL DEFAULT '',
  `jml` varchar(10) NOT NULL DEFAULT '',
  `postdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_rusak`
--

CREATE TABLE `stock_rusak` (
  `kd` varchar(50) NOT NULL DEFAULT '',
  `kd_brg` varchar(50) NOT NULL DEFAULT '',
  `jml` varchar(10) NOT NULL DEFAULT '',
  `postdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `admks`
--
ALTER TABLE `admks`
  ADD PRIMARY KEY (`kd`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
