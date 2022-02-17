-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Jan 2022 pada 11.54
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newapotik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_alat`
--

CREATE TABLE `tb_alat` (
  `id` int(11) NOT NULL,
  `nama_alat` varchar(150) NOT NULL,
  `kode_alat` varchar(50) NOT NULL,
  `satuan` char(10) NOT NULL,
  `expired` char(30) NOT NULL,
  `harga` char(20) NOT NULL,
  `stok` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_alat`
--

INSERT INTO `tb_alat` (`id`, `nama_alat`, `kode_alat`, `satuan`, `expired`, `harga`, `stok`) VALUES
(1, 'arumpils', 'dsw0001', 'box', '01/10/2020', '14000', '115'),
(3, 'batunir', 'dsw0002', 'box', '07/10/2020', '14000', '129'),
(4, 'brisquin', 'dsw0003', 'box', '08/10/2020', '14000', '340'),
(5, 'uricid', 'dsw0004', 'box', '07/10/2020', '14000', '175'),
(6, 'Sang Putih', 'dsw0005', 'Box', '05/10/2020', '14000', '115'),
(8, 'Migranial', 'DSW0006', 'Box', '09/10/2020', '14000', '140'),
(9, 'Kataxan', 'DSW0007', 'Box', '06/10/2020', '14000', '123'),
(10, 'Galian Rapet', 'DSW0008', 'Box', '09/10/2020', '14000', '215'),
(11, 'Habis Bersalin', 'DSW0009', 'Box', '08/10/2020', '14000', '118'),
(12, 'Maagfit', 'DSW0010', 'Box', '08/10/2020', '80000', '250'),
(13, 'top up box', 'DSW0011', 'Box', '08/10/2020', '45000', '147'),
(14, 'Top Up', 'DSW0012', 'Botol', '09/10/2020', '80000', '110'),
(15, 'Thyponisix', 'DSW0013', 'Box', '08/10/2020', '80000', '150'),
(16, 'Wasir', 'DSW0014', 'Box', '08/10/2020', '14000', '160'),
(17, 'Diapil', 'DSW0015', 'Box', '09/10/2020', '14000', '206'),
(18, 'Keladi Tikus', 'DSW0016', 'Box', '30/09/2020', '106000', '140'),
(19, 'Tensilon', 'DSW0017', 'Box', '10/10/2020', '14000', '218'),
(20, 'Klir Y', 'DSW0018', 'Box', '08/10/2020', '80000', '201'),
(21, 'Negatal', 'DSW0019', 'Botol', '21/10/2020', '22000', '134'),
(22, 'Menses Kapsul', 'DSW0020', 'Box', '21/10/2020', '22000', '132'),
(23, 'Menses Cair Hanger', 'DSW0021', 'Karton', '21/10/2020', '2750', '206'),
(24, 'Menses Cair Box', 'DSW0022', 'Karton', '23/10/2020', '2750', '134'),
(25, 'Prostalon', 'DSW0023', 'Box', '', '14000', '211'),
(26, 'Penenang', 'DSW0024', 'Box', '', '14000', '212'),
(27, 'ACT Move', 'DSW0025', 'Box', '', '80000', '134'),
(28, 'Kolespil', 'DSW0026', 'Box', '', '14000', '173'),
(29, 'Sehat Kandungan', 'DSW0027', 'Box', '', '14000', '243'),
(30, 'ALCOHOL 70% 100ML', 'LKP0001', 'Btl', '', '5534', '185'),
(31, 'ALCOHOL 95% 100ML', 'LKP0002', 'Btl', '', '8820', '178'),
(32, 'MEDIKACARE 0,5% 500ML', 'LKP0003', 'Btl', '30/10/2020', '59009', '216'),
(33, 'MEDIKACARE 0,5% 1 LITER', 'LKP0004', 'Btl', '28/10/2020', '86602', '210'),
(34, 'MEDIKACARE 2,5% 500ML', 'LKP0005', 'Btl', '30/10/2020', '80167', '230'),
(35, 'MEDIKACARE 2,5% 1 LITER', 'LKP0006', 'Btl', '10/10/2020', '156922', '175'),
(36, 'SASKLIN HANDSANITIZER 60ML', 'LKP0007', 'Btl', '07/10/2020', '16500', '75'),
(37, 'HANDRUB 500ML 70% PUMP', 'LKP0009', 'btl', '07/10/2020', '54506', '200'),
(38, 'masker earloop luna lite', 'EVR0001', 'btl', '', '125000', '50'),
(40, 'minyak gosok cap singa laut 30ml', 'UMS0001', 'btl', '05/10/2020', '17250', '70'),
(41, 'obat obatan', 'OBT0001', 'box', '31/01/2022', '14000', '50'),
(42, 'sahrul mahani', 'msm01', 'pcs', '1/31/2022', '15000', '50'),
(43, 'havid', 'msm02', 'pcs', '2/1/2022', '15000', '30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_customer`
--

CREATE TABLE `tb_customer` (
  `kode_customer` varchar(20) NOT NULL,
  `nama_customer` varchar(200) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `telp` varchar(200) NOT NULL,
  `faks` char(30) NOT NULL,
  `email` varchar(200) NOT NULL,
  `konfir` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_customer`
--

INSERT INTO `tb_customer` (`kode_customer`, `nama_customer`, `alamat`, `telp`, `faks`, `email`, `konfir`) VALUES
('CUS01', 'PT.XYZ', 'Jlan XYZ', '0822872555', '0256564', 'XYZ@gmail.com', 1),
('CUS02', 'PT. Sinar Jaya Abadi', 'Jalan jalan lewat gunung', '0822224444444', '0435212', 'SJA@gmail.com', 1),
('CUS03', 'PT. Kayu Kitas', 'Sultan Botutihe', '084485458', '084485458', 'kayukitakayungana@gmail.com', 1),
('CUS04', 'PT.Bakoffie', 'Arif Rahman Hakim', '05522255', '08112', 'bakofiejo@gmail.cpm', 1),
('CUS05', 'PT.ZW', 'limboto', '8228', '0812345', 'iniemailloe@email.com', 0),
('CUS06', 'pt ian barokah', 'jln kayumerah', '0822564578', '0435889945', 'ian@gmail.com', 0),
('CUS07', 'pt harian harian', 'jln kayumerah', '08123456', '0435889945', 'harian@gmail.com', 0),
('CUS08', 'pt kayubulan', 'jln kayubulan', '08229252215', '0435212', 'sahrul.mahani@yahoo.co.id', 0),
('CUS09', 'pt sawar', 'jln sawah sawah', '08229252215', '0256564', 'maman@gmail.com', 0),
('CUS10', 'pt andrean', 'buladu ortodox', '08229252215', '0435212', 'iskandar@gmail.com', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_invoice`
--

CREATE TABLE `tb_invoice` (
  `id` int(11) NOT NULL,
  `kode_customer` char(30) NOT NULL,
  `jumlah_alat` char(15) NOT NULL,
  `tanggal` char(30) NOT NULL,
  `invoice` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_invoice`
--

INSERT INTO `tb_invoice` (`id`, `kode_customer`, `jumlah_alat`, `tanggal`, `invoice`) VALUES
(2, 'CUS02', '40', '06/Oktober/2020', 'INV/06/CUS02/040/236'),
(3, 'CUS01', '101', '07/Oktober/2020', 'INV/07/CUS01/101/876'),
(5, 'CUS03', '330', '17/Oktober/2020', 'INV/17/CUS03/330/979'),
(12, 'CUS04', '21', '19/Januari/2022', 'INV/19/CUS04/016/826');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pesan`
--

CREATE TABLE `tb_pesan` (
  `id` int(11) NOT NULL,
  `kode_alat` char(50) NOT NULL,
  `nama_alat` varchar(200) NOT NULL,
  `kode_customer` char(50) NOT NULL,
  `harga` char(20) NOT NULL,
  `disc` int(15) NOT NULL,
  `jumlah` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pesan`
--

INSERT INTO `tb_pesan` (`id`, `kode_alat`, `nama_alat`, `kode_customer`, `harga`, `disc`, `jumlah`) VALUES
(9, 'DSW0001', 'Arumpil', 'CUS02', '14000', 10, '10'),
(10, 'DSW0002', 'Batunir', 'CUS02', '14000', 15, '20'),
(12, 'DSW0001', 'Arumpil', 'CUS01', '14000', 0, '10'),
(13, 'DSW0002', 'Batunir', 'CUS01', '14000', 10, '10'),
(14, 'DSW0003', 'Brisquin', 'CUS01', '14000', 0, '10'),
(15, 'DSW0004', 'Uricid', 'CUS01', '14000', 0, '10'),
(16, 'DSW0005', 'Sang Putih', 'CUS01', '14000', 50, '2'),
(17, 'DSW0006', 'Migranial', 'CUS01', '14000', 0, '2'),
(18, 'DSW0007', 'Kataxan', 'CUS01', '14000', 0, '2'),
(19, 'DSW0008', 'Galian Rapet', 'CUS01', '14000', 0, '2'),
(20, 'DSW0009', 'Habis Bersalin', 'CUS01', '14000', 0, '2'),
(21, 'DSW0010', 'Maagfit', 'CUS01', '80000', 0, '10'),
(22, 'DSW0011', 'Top Up Box', 'CUS01', '45000', 0, '4'),
(23, 'DSW0012', 'Top Up', 'CUS01', '80000', 0, '2'),
(24, 'DSW0013', 'Thyponisix', 'CUS01', '80000', 0, '4'),
(30, 'DSW0004', 'Uricid', 'CUS03', '14000', 0, '30'),
(33, 'DSW0014', 'Wasir', 'CUS01', '14000', 0, '5'),
(34, 'DSW0015', 'Diapil', 'CUS01', '14000', 0, '2'),
(35, 'DSW0016', 'Keladi Tikus', 'CUS01', '106000', 0, '5'),
(36, 'DSW0017', 'Tensilon', 'CUS01', '14000', 0, '2'),
(39, 'DSW0003', 'Brisquin', 'CUS03', '14000', 0, '15'),
(41, 'UMS0001', 'Minyak Gosok Cap Singa Laut 30ml', 'CUS02', '17250', 0, '10'),
(44, 'LKP0003', 'MEDIKACARE 0,5% 500ML', 'CUS01', '59009', 0, '2'),
(46, 'LKP0004', 'MEDIKACARE 0,5% 1 LITER', 'CUS01', '86602', 0, '5'),
(47, 'LKP0005', 'MEDIKACARE 2,5% 500ML', 'CUS01', '80167', 0, '5'),
(48, 'LKP0006', 'MEDIKACARE 2,5% 1 LITER', 'CUS01', '156922', 0, '5'),
(62, 'DSW0001', 'Arumpils', 'CUS03', '14000', 0, '5'),
(63, 'DSW0005', 'Sang Putih', 'CUS03', '14000', 0, '5'),
(64, 'DSW0006', 'Migranial', 'CUS03', '14000', 0, '1'),
(65, 'DSW0002', 'Batunir', 'CUS03', '14000', 0, '5'),
(66, 'DSW0007', 'Kataxan', 'CUS03', '14000', 0, '5'),
(67, 'DSW0008', 'Galian Rapet', 'CUS03', '14000', 0, '5'),
(68, 'DSW0009', 'Habis Bersalin', 'CUS03', '14000', 0, '2'),
(69, 'DSW0010', 'Maagfit', 'CUS03', '80000', 0, '1'),
(70, 'DSW0011', 'Top Up Box', 'CUS03', '45000', 0, '3'),
(71, 'DSW0001', 'Arumpils', 'CUS04', '70000', 0, '5'),
(72, 'DSW0002', 'Batunir', 'CUS04', '14000', 0, '1'),
(73, 'DSW0003', 'Brisquin', 'CUS04', '140000', 10, '10'),
(77, 'DSW0004', 'Uricid', 'CUS04', '70000', 0, '5');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sementara`
--

CREATE TABLE `tb_sementara` (
  `id` int(11) NOT NULL,
  `kode_alat` char(20) NOT NULL,
  `nama_alat` varchar(200) NOT NULL,
  `harga` char(20) NOT NULL,
  `disc` int(3) NOT NULL,
  `jumlah` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `pic` varchar(100) NOT NULL,
  `online` int(1) NOT NULL,
  `level` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `pic`, `online`, `level`) VALUES
(1, 'sahrul', 'sahrul@gmail.com', '$2y$10$nKi82WcU8YqW5tL.AZFplO/hMHIcn8jG4LCnlXuFsel6fa1muKwvy', 'upload/sahrul_mahani.JPG', 1, 0),
(3, 'harian rahman', 'hari@gmail.com', '$2y$10$H7CelLcRFYBBYI2JMSQG1ODwdMVQO8A4KhEQMwKzXYgfdMshO1vR6', 'upload/harian_rahman.jpg', 0, 1),
(4, 'iskandar ibrahim', 'iskandar@gmail.com', '$2y$10$oGurbmO6Xw1G2bB/GuVBKe2JWvmVMStFUmyWAZtaTpxN0zhIP4Z5O', 'profile.jpg', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_alat`
--
ALTER TABLE `tb_alat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`kode_customer`);

--
-- Indeks untuk tabel `tb_invoice`
--
ALTER TABLE `tb_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_pesan`
--
ALTER TABLE `tb_pesan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_sementara`
--
ALTER TABLE `tb_sementara`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_alat`
--
ALTER TABLE `tb_alat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `tb_invoice`
--
ALTER TABLE `tb_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tb_pesan`
--
ALTER TABLE `tb_pesan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT untuk tabel `tb_sementara`
--
ALTER TABLE `tb_sementara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
