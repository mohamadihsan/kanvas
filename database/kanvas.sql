-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Nov 13, 2017 at 01:08 PM
-- Server version: 5.7.20-0ubuntu0.16.04.1
-- PHP Version: 5.6.32-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kanvas`
--

-- --------------------------------------------------------

--
-- Table structure for table `bahan_baku`
--

CREATE TABLE `bahan_baku` (
  `id_bahan_baku` char(5) NOT NULL COMMENT '001BB',
  `nama_bahan_baku` varchar(20) NOT NULL,
  `jenis_bahan_baku` varchar(20) NOT NULL COMMENT '10s cotton, 20s PE, pewarna kain, obat',
  `satuan` varchar(10) NOT NULL,
  `safety_stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bahan_baku`
--

INSERT INTO `bahan_baku` (`id_bahan_baku`, `nama_bahan_baku`, `jenis_bahan_baku`, `satuan`, `safety_stock`) VALUES
('001BB', 'benang', '10s cotton', 'bal', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_pemesanan_bahan_baku`
--

CREATE TABLE `detail_pemesanan_bahan_baku` (
  `nomor_faktur` char(15) NOT NULL,
  `id_bahan_baku` char(5) NOT NULL,
  `jumlah_pemesanan` int(11) NOT NULL,
  `harga_bahan_baku` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_pemesanan_produk`
--

CREATE TABLE `detail_pemesanan_produk` (
  `nomor_faktur` char(14) NOT NULL,
  `id_produk` char(5) NOT NULL,
  `jumlah_pemesanan` int(11) NOT NULL,
  `harga_produk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detail_supplier`
--

CREATE TABLE `detail_supplier` (
  `id_supplier` char(11) NOT NULL,
  `id_bahan_baku` char(5) NOT NULL,
  `harga` int(11) DEFAULT NULL,
  `minimal_order` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `distribusi`
--

CREATE TABLE `distribusi` (
  `id_distribusi` char(13) NOT NULL COMMENT 'DIS1010171420',
  `nomor_faktur` char(14) NOT NULL,
  `plat_nomor_kendaraan` varchar(10) NOT NULL,
  `tanggal_pengiriman` timestamp NULL DEFAULT NULL,
  `status_pengiriman` char(1) NOT NULL DEFAULT '0' COMMENT '1 = sudah diterima, 0 = belum diterima'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `plat_nomor_kendaraan` varchar(10) NOT NULL,
  `nama_kendaraan` varchar(30) NOT NULL,
  `kapasitas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `komposisi`
--

CREATE TABLE `komposisi` (
  `id_produk` char(5) NOT NULL,
  `id_bahan_baku` char(5) NOT NULL,
  `takaran` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` char(9) NOT NULL COMMENT '101710001',
  `nama_pegawai` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `jabatan` varchar(30) NOT NULL COMMENT 'Manager Pemasaran, Manager Produksi, Manager Pembelian, Manager Keuangan, Supplier',
  `nama_pengguna` varchar(20) NOT NULL,
  `kata_sandi` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nama_pegawai`, `alamat`, `no_telp`, `email`, `jabatan`, `nama_pengguna`, `kata_sandi`) VALUES
('101710001', 'Manager Produksi', 'Bandung', '081723454204', 'manager_produksi@gmail.com', 'manager produksi', 'mproduksi', '1ca95f95f48d5ac6038260840d2fe6a6'),
('101710002', 'Manager Pembelian', 'Bandung', '081740054207', 'manager_pembelian@gmail.com', 'manager pembelian', 'mpembelian', 'dd7bf9147fc3fe015d44e2cd02eb8575'),
('101710003', 'Manager Keuangan', 'Bandung', '085740064304', 'manager_keuangan@gmail.com', 'manager keuangan', 'mkeuangan', '10d7225fa8766364f57e278a4065508d'),
('101710004', 'Manager Pemasaran', 'Bandung', '085730074206', 'manager_pemasaran@gmail.com', 'manager pemasaran', 'mpemasaran', '1b940e4efdac46422010db27d71274a1');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` char(11) NOT NULL COMMENT '1017PEL0001',
  `nama_pelanggan` varchar(30) NOT NULL,
  `alamat` text,
  `no_telp` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan_bahan_baku`
--

CREATE TABLE `pemesanan_bahan_baku` (
  `nomor_faktur` char(15) NOT NULL COMMENT '101017FAK00001P',
  `id_supplier` char(11) NOT NULL,
  `id_pegawai` char(9) NOT NULL,
  `status_pemesanan` char(2) NOT NULL DEFAULT 'sp' COMMENT 'sp=sedang di proses, s=dikirim',
  `status_pembayaran` char(1) NOT NULL DEFAULT '0' COMMENT '1 = sudah dibayar, 0 = belum dibaya',
  `tanggal_pemesanan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan_produk`
--

CREATE TABLE `pemesanan_produk` (
  `nomor_faktur` char(14) NOT NULL COMMENT '101017FAK00001',
  `id_pelanggan` char(11) NOT NULL,
  `id_pegawai` char(9) NOT NULL,
  `status_pemesanan` char(2) NOT NULL DEFAULT 'sp' COMMENT 'sp=sedang di proses, s=dikirim',
  `status_pembayaran` char(1) NOT NULL DEFAULT '0' COMMENT '1 = sudah dibayar, 0 = belum dibayar',
  `tanggal_pemesanan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_pembayaran` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `peramalan`
--

CREATE TABLE `peramalan` (
  `id_peramalan` int(11) NOT NULL,
  `periode` datetime NOT NULL,
  `id_produk` char(5) NOT NULL,
  `hasil_peramalan` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `persediaan_bahan_baku`
--

CREATE TABLE `persediaan_bahan_baku` (
  `id_bahan_baku` char(5) NOT NULL,
  `stok_awal` int(11) NOT NULL,
  `jumlah_pembelian` int(11) NOT NULL DEFAULT '0',
  `jumlah_pemakaian` int(11) NOT NULL DEFAULT '0',
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` char(5) NOT NULL COMMENT 'PR001',
  `nama_produk` varchar(30) NOT NULL,
  `jenis_produk` varchar(20) NOT NULL COMMENT 'kain tas, kain kanvas, kain terpal',
  `harga` int(11) NOT NULL,
  `gambar_produk` varchar(20) NOT NULL DEFAULT 'produk.jpg',
  `stok` int(11) NOT NULL DEFAULT '0',
  `safety_stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `jenis_produk`, `harga`, `gambar_produk`, `stok`, `safety_stock`) VALUES
('PR001', 'kain waterproof', 'KSA-32/103 BROWN', 5000, 'produk.jpg', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produksi`
--

CREATE TABLE `produksi` (
  `id_produksi` char(13) NOT NULL COMMENT 'PRD1010171420',
  `id_produk` char(5) NOT NULL,
  `jumlah_produksi` int(11) NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` char(11) NOT NULL COMMENT '1017SUP0001',
  `nama_supplier` varchar(30) NOT NULL,
  `alamat` text,
  `no_telp` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `waktu_pengiriman` tinyint(4) DEFAULT NULL,
  `nama_pengguna` varchar(20) NOT NULL,
  `kata_sandi` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `no_telp`, `email`, `waktu_pengiriman`, `nama_pengguna`, `kata_sandi`) VALUES
('1017SUP0001', 'SUNSON', NULL, '085730074402', 'sunson@gmail.com', 3, 'supplier', '99b0e8da24e29e4ccb5d7d76e677c2ac');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD PRIMARY KEY (`id_bahan_baku`),
  ADD UNIQUE KEY `nama_bahan_baku` (`nama_bahan_baku`);

--
-- Indexes for table `detail_pemesanan_bahan_baku`
--
ALTER TABLE `detail_pemesanan_bahan_baku`
  ADD KEY `nomor_faktur` (`nomor_faktur`),
  ADD KEY `id_bahan_baku` (`id_bahan_baku`);

--
-- Indexes for table `detail_pemesanan_produk`
--
ALTER TABLE `detail_pemesanan_produk`
  ADD KEY `nomor_faktur` (`nomor_faktur`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `detail_supplier`
--
ALTER TABLE `detail_supplier`
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_bahan_baku` (`id_bahan_baku`);

--
-- Indexes for table `distribusi`
--
ALTER TABLE `distribusi`
  ADD PRIMARY KEY (`id_distribusi`),
  ADD KEY `nomor_faktur` (`nomor_faktur`),
  ADD KEY `plat_nomor_kendaraan` (`plat_nomor_kendaraan`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`plat_nomor_kendaraan`);

--
-- Indexes for table `komposisi`
--
ALTER TABLE `komposisi`
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_bahan_baku` (`id_bahan_baku`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD UNIQUE KEY `nama_pengguna` (`nama_pengguna`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pemesanan_bahan_baku`
--
ALTER TABLE `pemesanan_bahan_baku`
  ADD PRIMARY KEY (`nomor_faktur`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `pemesanan_produk`
--
ALTER TABLE `pemesanan_produk`
  ADD PRIMARY KEY (`nomor_faktur`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `peramalan`
--
ALTER TABLE `peramalan`
  ADD PRIMARY KEY (`id_peramalan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `persediaan_bahan_baku`
--
ALTER TABLE `persediaan_bahan_baku`
  ADD KEY `id_bahan_baku` (`id_bahan_baku`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD UNIQUE KEY `nama_produk` (`nama_produk`);

--
-- Indexes for table `produksi`
--
ALTER TABLE `produksi`
  ADD PRIMARY KEY (`id_produksi`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`),
  ADD UNIQUE KEY `nama_pengguna` (`nama_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `peramalan`
--
ALTER TABLE `peramalan`
  MODIFY `id_peramalan` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pemesanan_bahan_baku`
--
ALTER TABLE `detail_pemesanan_bahan_baku`
  ADD CONSTRAINT `fk_id_bahan_baku_detail` FOREIGN KEY (`id_bahan_baku`) REFERENCES `bahan_baku` (`id_bahan_baku`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nomor_faktur_detail` FOREIGN KEY (`nomor_faktur`) REFERENCES `pemesanan_bahan_baku` (`nomor_faktur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_pemesanan_produk`
--
ALTER TABLE `detail_pemesanan_produk`
  ADD CONSTRAINT `fk_id_produk_dibeli` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nomor_faktur` FOREIGN KEY (`nomor_faktur`) REFERENCES `pemesanan_produk` (`nomor_faktur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_supplier`
--
ALTER TABLE `detail_supplier`
  ADD CONSTRAINT `fk_id_bahan_baku` FOREIGN KEY (`id_bahan_baku`) REFERENCES `bahan_baku` (`id_bahan_baku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `distribusi`
--
ALTER TABLE `distribusi`
  ADD CONSTRAINT `fk_nomor_faktur_distribusi` FOREIGN KEY (`nomor_faktur`) REFERENCES `pemesanan_produk` (`nomor_faktur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_plat_nomor_kendaraan` FOREIGN KEY (`plat_nomor_kendaraan`) REFERENCES `kendaraan` (`plat_nomor_kendaraan`) ON UPDATE CASCADE;

--
-- Constraints for table `komposisi`
--
ALTER TABLE `komposisi`
  ADD CONSTRAINT `fk_id_bahan_baku_komposisi` FOREIGN KEY (`id_bahan_baku`) REFERENCES `bahan_baku` (`id_bahan_baku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_produk_komposisi` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pemesanan_bahan_baku`
--
ALTER TABLE `pemesanan_bahan_baku`
  ADD CONSTRAINT `fk_id_pegawai_pemesanan_bahan` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_supplier_pemesanan_bahan` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON UPDATE CASCADE;

--
-- Constraints for table `pemesanan_produk`
--
ALTER TABLE `pemesanan_produk`
  ADD CONSTRAINT `fk_id_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON UPDATE CASCADE;

--
-- Constraints for table `peramalan`
--
ALTER TABLE `peramalan`
  ADD CONSTRAINT `fk_id_produk_peramalan` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `persediaan_bahan_baku`
--
ALTER TABLE `persediaan_bahan_baku`
  ADD CONSTRAINT `fk_id_bahan_baku_persediaan` FOREIGN KEY (`id_bahan_baku`) REFERENCES `bahan_baku` (`id_bahan_baku`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produksi`
--
ALTER TABLE `produksi`
  ADD CONSTRAINT `fk_id_produk_produksi` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
