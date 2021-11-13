-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Nov 2021 pada 10.53
-- Versi server: 10.1.40-MariaDB
-- Versi PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arisan_manajemen`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `agen`
--

CREATE TABLE `agen` (
  `id_agen` char(10) NOT NULL,
  `id_kelompok` varchar(255) NOT NULL,
  `nama_agen` varchar(128) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `nominal_kocokan` varchar(255) NOT NULL,
  `periode_arisan` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `agen`
--

INSERT INTO `agen` (`id_agen`, `id_kelompok`, `nama_agen`, `alamat`, `telepon`, `nominal_kocokan`, `periode_arisan`, `keterangan`) VALUES
('AGN00001', 'KLP00001', 'Agen', 'bandung', '083822623170', '10', '12', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akses_role`
--

CREATE TABLE `akses_role` (
  `akses_role` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `akses_role`
--

INSERT INTO `akses_role` (`akses_role`, `id_menu`, `id_role`) VALUES
(75, 9, 1),
(76, 11, 1),
(77, 1, 1),
(78, 2, 1),
(80, 4, 1),
(81, 5, 1),
(82, 6, 1),
(83, 7, 1),
(84, 8, 1),
(85, 10, 1),
(86, 12, 1),
(87, 37, 1),
(88, 18, 1),
(101, 34, 1),
(105, 23, 1),
(106, 24, 1),
(109, 22, 1),
(114, 37, 2),
(121, 22, 2),
(127, 42, 1),
(128, 43, 1),
(129, 44, 1),
(137, 13, 1),
(138, 38, 1),
(139, 19, 1),
(144, 2, 2),
(145, 7, 2),
(171, 12, 2),
(183, 3, 1),
(184, 1, 2),
(198, 18, 2),
(199, 46, 2),
(200, 47, 2),
(201, 48, 2),
(209, 53, 2),
(210, 17, 2),
(211, 36, 2),
(212, 17, 1),
(214, 8, 2),
(215, 13, 2),
(216, 38, 2),
(217, 19, 2),
(220, 52, 2),
(221, 28, 2),
(223, 58, 1),
(224, 59, 1),
(225, 21, 1),
(226, 60, 1),
(227, 61, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `backup`
--

CREATE TABLE `backup` (
  `id_backup` int(11) NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `file` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` char(10) NOT NULL,
  `id_kategori` char(10) DEFAULT NULL,
  `id_supplier` char(10) DEFAULT NULL,
  `satuan` varchar(12) DEFAULT NULL,
  `barcode` varchar(128) DEFAULT NULL,
  `nama_barang` varchar(128) DEFAULT NULL,
  `nama_pendek` varchar(128) DEFAULT NULL,
  `harga_pokok` int(11) DEFAULT NULL,
  `golongan_1` int(11) DEFAULT '0',
  `profit_1` int(11) DEFAULT '0',
  `golongan_2` int(11) DEFAULT '0',
  `profit_2` int(11) DEFAULT '0',
  `golongan_3` int(11) DEFAULT '0',
  `profit_3` int(11) DEFAULT '0',
  `golongan_4` int(11) DEFAULT '0',
  `profit_4` int(11) DEFAULT '0',
  `stok` float DEFAULT '0',
  `diskon` int(11) DEFAULT '0',
  `gambar` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `id_kategori`, `id_supplier`, `satuan`, `barcode`, `nama_barang`, `nama_pendek`, `harga_pokok`, `golongan_1`, `profit_1`, `golongan_2`, `profit_2`, `golongan_3`, `profit_3`, `golongan_4`, `profit_4`, `stok`, `diskon`, `gambar`) VALUES
('BRG00001', 'KTR00001', 'SPL00001', 'UNIT', '', 'KOMPUTER', 'KOMPUTER', 1000000, 13000000, 12000000, 0, -1000000, 0, -1000000, 0, -1000000, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `biaya`
--

CREATE TABLE `biaya` (
  `id_biaya` char(128) NOT NULL,
  `id_petugas` char(10) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `keterangan_biaya` varchar(225) NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `keterangan` text NOT NULL,
  `id_outlet` char(10) NOT NULL,
  `status` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `id_detail_pembelian` int(11) NOT NULL,
  `faktur_pembelian` varchar(128) NOT NULL,
  `id_barang` char(10) NOT NULL,
  `jumlah` float NOT NULL,
  `total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_pembelian`
--

INSERT INTO `detail_pembelian` (`id_detail_pembelian`, `faktur_pembelian`, `id_barang`, `jumlah`, `total_harga`) VALUES
(1, 'P-211100001', 'BRG00001', 1, 1000000),
(2, 'P-211100002', 'BRG00001', 11, 11000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail_penjualan` int(11) NOT NULL,
  `faktur_penjualan` varchar(128) NOT NULL,
  `id_barang` char(10) NOT NULL,
  `type_golongan` varchar(30) NOT NULL,
  `jumlah` float NOT NULL,
  `total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_detail_penjualan`, `faktur_penjualan`, `id_barang`, `type_golongan`, `jumlah`, `total_harga`) VALUES
(9, 'SL-KPVJ4WHGR7', 'BRG00001', 'golongan_1', 1, 13000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_stok`
--

CREATE TABLE `detail_stok` (
  `id_stok` char(10) NOT NULL,
  `id_barang` char(10) NOT NULL,
  `jumlah` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_stok_opname`
--

CREATE TABLE `detail_stok_opname` (
  `id_detail_stok_opname` int(11) NOT NULL,
  `id_stok_opname` char(10) NOT NULL,
  `id_barang` char(10) NOT NULL,
  `stok_komputer` float NOT NULL,
  `stok_fisik` float NOT NULL,
  `selisih` float NOT NULL,
  `kerugian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_kocokan`
--

CREATE TABLE `jadwal_kocokan` (
  `id_jadwal_kocokan` varchar(255) NOT NULL,
  `id_agen` varchar(255) NOT NULL,
  `id_kelompok` varchar(255) NOT NULL,
  `nominal` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jadwal_kocokan`
--

INSERT INTO `jadwal_kocokan` (`id_jadwal_kocokan`, `id_agen`, `id_kelompok`, `nominal`, `tanggal`, `keterangan`) VALUES
('JDW00001', 'AGN00001', 'KLP00001', 120000, '2021-11-14', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` char(10) NOT NULL,
  `id_outlet` char(10) NOT NULL,
  `nama_karyawan` varchar(128) NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `telepon` char(12) NOT NULL,
  `email` varchar(30) NOT NULL,
  `jabatan` varchar(128) NOT NULL,
  `gambar` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `id_outlet`, `nama_karyawan`, `alamat`, `jk`, `telepon`, `email`, `jabatan`, `gambar`) VALUES
('KRY00001', 'OTL00001', 'Karyawan', 'Bandung', 'L', '083822623170', 'karyawan@mail.com', 'Kasir', 'man1.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` char(10) NOT NULL,
  `nama_kategori` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
('KTR00001', 'ALL');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelompok`
--

CREATE TABLE `kelompok` (
  `id_kelompok` char(10) NOT NULL,
  `nama_kelompok` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kelompok`
--

INSERT INTO `kelompok` (`id_kelompok`, `nama_kelompok`) VALUES
('KLP00001', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `ada_submenu` int(11) NOT NULL,
  `submenu` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `urutan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `icon`, `ada_submenu`, `submenu`, `url`, `urutan`) VALUES
(1, 'Dashboard', 'fa fa-dashboard', 0, 0, 'dashboard', 1),
(2, 'Data Master', 'fa fa-archive', 1, 0, 'master', 2),
(3, 'Data Outlet', '', 0, 2, 'master/outlet', 1),
(4, 'Data Kategori', '', 0, 2, 'master/kategori', 2),
(5, 'Data Supplier', '', 0, 2, 'master/supplier', 3),
(7, 'Data Pelanggan', '', 0, 2, 'master/pelanggan', 5),
(8, 'Data Barang', '', 0, 2, 'master/barang', 6),
(9, 'Petugas', 'fa fa-shield', 1, 0, 'petugas', 3),
(10, 'Data Petugas', '', 0, 9, 'petugas', 1),
(11, 'Akses Menu Petugas', '', 0, 9, 'petugas/akses', 2),
(12, 'Penjualan', 'fa fa-shopping-cart', 1, 0, 'penjualan', 5),
(13, 'Pembelian', 'fa fa-cart-arrow-down', 1, 0, 'pembelian', 4),
(14, 'Stok', 'fa fa-sitemap', 1, 0, 'stok', 8),
(15, 'Penyesuaian Stok', '', 0, 14, 'stok', 2),
(17, 'Laporan', 'fa fa-book', 1, 0, 'laporan', 9),
(18, 'Riwayat Penjualan', '', 0, 12, 'penjualan/riwayat_penjualan', 2),
(19, 'Riwayat Pembelian', '', 0, 13, 'pembelian/riwayat_pembelian', 2),
(20, 'Laporan Penjualan', '', 0, 17, 'laporan/penjualan', 4),
(21, 'Laporan Pembelian', '', 0, 17, 'laporan/pembelian', 5),
(22, 'Profil Saya', 'fa fa-user', 0, 0, 'profil', 14),
(23, 'Utilitas', 'fa fa-database', 1, 0, 'utilitas', 12),
(24, 'Backup Database', '', 0, 23, 'utilitas/backup', 1),
(27, 'Pengaturan', 'fa fa-cogs', 0, 0, 'pengaturan', 13),
(28, 'Laporan Register', '', 0, 17, 'laporan/register', 7),
(29, 'Buka Laci', '', 0, 23, 'utilitas/buka_laci', 2),
(30, 'Sinkronisasi Database', '', 0, 23, 'utilitas/sinkronisasi_database', 3),
(31, 'Stok Barang', '', 0, 14, 'stok/barang', 3),
(35, 'Laporan Hutang', '', 0, 17, 'laporan/hutang', 8),
(36, 'Laporan Piutang', '', 0, 17, 'laporan/piutang', 9),
(37, 'Penjualan', '', 0, 12, 'penjualan', 1),
(38, 'Pembelian', '', 0, 13, 'pembelian', 1),
(39, 'Pengembalian', '', 0, 32, 'pengembalian', 1),
(40, 'Stok Opname', '', 0, 14, 'stok_opname', 1),
(41, 'Cetak Label', '', 0, 23, 'utilitas/cetak_label', 4),
(44, 'Riwayat Transaksi Pulsa', '', 0, 42, 'pulsa/riwayat', 2),
(45, 'Data Karyawan', '', 0, 2, 'master/karyawan', 7),
(46, 'Transaksi Biaya', 'fa fa-industry', 1, 0, 'biaya', 10),
(47, 'Transaksi Baru', '', 0, 46, 'biaya/tambah', 1),
(48, 'Riwayat Transaksi', '', 0, 46, 'biaya', 2),
(52, 'Laporan Laba Rugi', '', 0, 17, 'laporan/laba_rugi', 7),
(53, 'Daftar Hold', '', 0, 12, 'penjualan/hold', 3),
(54, 'Pulsa', 'fa fa-phone', 1, 0, 'pulsa', 6),
(55, 'Transaksi Pulsa', '', 0, 54, 'pulsa', 1),
(56, 'History Transaksi', '', 9, 54, 'pulsa/riwayat', 2),
(57, 'Aset Persediaan', '', 0, 14, 'stok/aset_persediaan', 4),
(58, 'Data Agen', '', 0, 2, 'master/agen', 9),
(59, 'Data Kelompok', '', 0, 2, 'master/kelompok', 8),
(60, 'Data Jadwal Kocokan', '', 0, 2, 'master/jadwal_kocokan', 10),
(61, 'Laporan Kelompok', '', 0, 17, 'laporan/kelompok', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `outlet`
--

CREATE TABLE `outlet` (
  `id_outlet` char(10) NOT NULL,
  `nama_outlet` varchar(30) NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `telepon` char(12) NOT NULL,
  `email` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `outlet`
--

INSERT INTO `outlet` (`id_outlet`, `nama_outlet`, `alamat`, `telepon`, `email`) VALUES
('OTL00001', 'ARISAN CRA', 'Bandung', '-', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` char(128) NOT NULL,
  `barcode` varchar(128) NOT NULL,
  `nama_pelanggan` varchar(30) NOT NULL,
  `alamat` varchar(128) DEFAULT NULL,
  `telepon` char(12) DEFAULT NULL,
  `jk` enum('L','P') NOT NULL,
  `jenis` enum('umum','member') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `barcode`, `nama_pelanggan`, `alamat`, `telepon`, `jk`, `jenis`) VALUES
('OTL00001PLG00001', '202012040001', 'Umum', 'Bandung', '-', 'L', 'umum');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` varchar(128) NOT NULL,
  `faktur_penjualan` varchar(128) NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dibayar_dengan` varchar(128) NOT NULL,
  `nominal` int(11) NOT NULL,
  `no_kredit` varchar(128) NOT NULL,
  `no_debit` varchar(128) NOT NULL,
  `lampiran` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `faktur_penjualan`, `tgl`, `dibayar_dengan`, `nominal`, `no_kredit`, `no_debit`, `lampiran`) VALUES
('PB-NMNV8MUX4J', 'SL-KPVJ4WHGR7', '2021-11-13 09:49:46', 'Cash', 13000000, '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran_pembelian`
--

CREATE TABLE `pembayaran_pembelian` (
  `id_pembayaran` int(11) NOT NULL,
  `faktur_pembelian` varchar(11) NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dibayar_dengan` varchar(128) NOT NULL,
  `nominal` int(11) NOT NULL,
  `no_kredit` varchar(128) NOT NULL,
  `no_debit` varchar(128) NOT NULL,
  `lampiran` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembayaran_pembelian`
--

INSERT INTO `pembayaran_pembelian` (`id_pembayaran`, `faktur_pembelian`, `tgl`, `dibayar_dengan`, `nominal`, `no_kredit`, `no_debit`, `lampiran`) VALUES
(1, 'P-211100001', '2021-11-13 05:05:50', 'Cash', 1000000, '', '', ''),
(2, 'P-211100002', '2021-11-13 08:42:38', 'Cash', 11000000, '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `faktur_pembelian` varchar(128) NOT NULL,
  `id_supplier` char(10) NOT NULL,
  `id_petugas` char(10) NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_jatuh_tempo` date DEFAULT NULL,
  `total_bayar` int(11) NOT NULL,
  `status` varchar(128) NOT NULL,
  `tgl_pembelian` timestamp NULL DEFAULT NULL,
  `referensi` varchar(128) NOT NULL,
  `total_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`faktur_pembelian`, `id_supplier`, `id_petugas`, `tgl`, `tgl_jatuh_tempo`, `total_bayar`, `status`, `tgl_pembelian`, `referensi`, `total_item`) VALUES
('P-211100001', 'SPL00001', 'PTS00001', '2021-11-13 05:05:50', NULL, 1000000, 'Lunas', '2021-11-13 05:05:41', '', 1),
('P-211100002', 'SPL00001', 'PTS00001', '2021-11-13 08:42:38', NULL, 11000000, 'Lunas', '2021-11-13 08:42:25', '', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id_pengaturan` int(11) NOT NULL,
  `logo` varchar(128) NOT NULL,
  `keterangan_invoice` varchar(225) NOT NULL,
  `nama_printer` varchar(128) NOT NULL,
  `print_otomatis` tinyint(4) NOT NULL,
  `smtp_host` varchar(128) NOT NULL,
  `smtp_email` varchar(128) NOT NULL,
  `smtp_username` varchar(128) NOT NULL,
  `smtp_password` varchar(128) NOT NULL,
  `smtp_port` int(11) NOT NULL,
  `peringatan_stok` int(11) NOT NULL,
  `hapus_riwayat_penjualan_otomatis` tinyint(4) NOT NULL,
  `lama_hari_penjualan` varchar(11) NOT NULL,
  `sesuaikan_hari_penjualan` int(11) NOT NULL,
  `hapus_riwayat_pembelian_otomatis` int(11) NOT NULL,
  `lama_hari_pembelian` varchar(11) NOT NULL,
  `sesuaikan_hari_pembelian` int(11) NOT NULL,
  `url_server` varchar(128) NOT NULL,
  `multi_outlet` tinyint(4) NOT NULL,
  `tampilkan_pendapatan_dashboard` tinyint(4) NOT NULL,
  `kunci_penjualan` tinyint(4) NOT NULL,
  `password_penjualan` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`id_pengaturan`, `logo`, `keterangan_invoice`, `nama_printer`, `print_otomatis`, `smtp_host`, `smtp_email`, `smtp_username`, `smtp_password`, `smtp_port`, `peringatan_stok`, `hapus_riwayat_penjualan_otomatis`, `lama_hari_penjualan`, `sesuaikan_hari_penjualan`, `hapus_riwayat_pembelian_otomatis`, `lama_hari_pembelian`, `sesuaikan_hari_pembelian`, `url_server`, `multi_outlet`, `tampilkan_pendapatan_dashboard`, `kunci_penjualan`, `password_penjualan`) VALUES
(1, 'favicon.png', 'BRG YG SUDAH  DIBELI TIDAK DAPAT DIKEMBALIKAN\r\n', 'epos', 2, 'ssl://smtp.gmail.com', 'email@email.com', 'email', 'secret', 465, 15, 0, '1', 0, 0, '1', 0, 'http://localhost/e_pos', 0, 1, 0, 'password');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `faktur_penjualan` varchar(128) NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tgl_jatuh_tempo` date DEFAULT NULL,
  `id_petugas` char(10) NOT NULL,
  `id_agen` char(10) NOT NULL,
  `id_pelanggan` char(128) NOT NULL,
  `id_outlet` char(10) DEFAULT NULL,
  `total_bayar` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `potongan` int(11) NOT NULL,
  `status` varchar(128) NOT NULL,
  `nama_pengiriman` varchar(128) DEFAULT NULL,
  `alamat_pengiriman` varchar(128) DEFAULT NULL,
  `total_item` int(11) NOT NULL,
  `piutang` int(11) DEFAULT NULL,
  `angsuran` int(11) NOT NULL,
  `tgl_terima_kocokan` date DEFAULT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`faktur_penjualan`, `tgl`, `tgl_jatuh_tempo`, `id_petugas`, `id_agen`, `id_pelanggan`, `id_outlet`, `total_bayar`, `diskon`, `potongan`, `status`, `nama_pengiriman`, `alamat_pengiriman`, `total_item`, `piutang`, `angsuran`, `tgl_terima_kocokan`, `keterangan`) VALUES
('SL-KPVJ4WHGR7', '2021-11-13 09:47:15', NULL, 'PTS00001', 'AGN00001', 'OTL00001PLG00001', 'OTL00001', 13000000, 0, 0, 'Lunas', NULL, NULL, 1, 1, 1083333, '2021-11-13', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` char(10) NOT NULL,
  `id_outlet` char(10) DEFAULT NULL,
  `nama_petugas` varchar(128) NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `telepon` char(12) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(128) NOT NULL,
  `gambar` varchar(128) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `id_outlet`, `nama_petugas`, `alamat`, `jk`, `telepon`, `email`, `password`, `gambar`, `id_role`) VALUES
('PTS00001', '', 'Administrator', 'Bandung', 'L', '083822623170', 'admin@admin.com', '$2y$10$RK5KJkDSgNJJyn/rypakeu30jCAHtKx.LJDB5Yg1lxXuIJS9.3.ci', 'man-1.png', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pulsa`
--

CREATE TABLE `pulsa` (
  `id_pulsa` varchar(128) NOT NULL,
  `id_outlet` char(10) NOT NULL,
  `id_petugas` char(10) NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `saldo_awal` int(11) NOT NULL,
  `harga_pulsa` int(11) NOT NULL,
  `saldo_akhir` int(11) NOT NULL,
  `keterangan` varchar(225) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `tambah_saldo` int(11) DEFAULT NULL,
  `type` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `register`
--

CREATE TABLE `register` (
  `id_register` int(11) NOT NULL,
  `id_petugas` char(10) NOT NULL,
  `id_outlet` char(10) DEFAULT NULL,
  `uang_awal` int(11) NOT NULL,
  `total_uang` int(11) NOT NULL,
  `mulai` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `berakhir` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` enum('open','close') NOT NULL,
  `penjualan` int(11) NOT NULL,
  `pemasukan` int(11) NOT NULL,
  `pengeluaran` int(11) NOT NULL,
  `piutang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id_role`, `nama_role`) VALUES
(1, 'Admin'),
(2, 'Kasir');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok`
--

CREATE TABLE `stok` (
  `id_stok` char(10) NOT NULL,
  `id_petugas` char(10) NOT NULL,
  `dari` varchar(128) NOT NULL,
  `ke` char(128) NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_opname`
--

CREATE TABLE `stok_opname` (
  `id_stok_opname` char(10) NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_outlet` char(10) NOT NULL,
  `id_petugas` char(10) NOT NULL,
  `keterangan` text NOT NULL,
  `total_kerugian` int(11) NOT NULL,
  `golongan` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_outlet`
--

CREATE TABLE `stok_outlet` (
  `id_stok_outlet` int(11) NOT NULL,
  `id_outlet` char(10) NOT NULL,
  `id_barang` char(10) NOT NULL,
  `stok` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `stok_outlet`
--

INSERT INTO `stok_outlet` (`id_stok_outlet`, `id_outlet`, `id_barang`, `stok`) VALUES
(1, 'OTL00001', 'BRG00001', 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` char(10) NOT NULL,
  `nama_supplier` varchar(30) NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `telepon` char(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `telepon`) VALUES
('SPL00001', 'ALL', '-', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `token_petugas`
--

CREATE TABLE `token_petugas` (
  `id_token_petugas` int(11) NOT NULL,
  `id_petugas` char(10) NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `agen`
--
ALTER TABLE `agen`
  ADD PRIMARY KEY (`id_agen`);

--
-- Indeks untuk tabel `akses_role`
--
ALTER TABLE `akses_role`
  ADD PRIMARY KEY (`akses_role`);

--
-- Indeks untuk tabel `backup`
--
ALTER TABLE `backup`
  ADD PRIMARY KEY (`id_backup`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `biaya`
--
ALTER TABLE `biaya`
  ADD PRIMARY KEY (`id_biaya`);

--
-- Indeks untuk tabel `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`id_detail_pembelian`);

--
-- Indeks untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail_penjualan`);

--
-- Indeks untuk tabel `detail_stok_opname`
--
ALTER TABLE `detail_stok_opname`
  ADD PRIMARY KEY (`id_detail_stok_opname`);

--
-- Indeks untuk tabel `jadwal_kocokan`
--
ALTER TABLE `jadwal_kocokan`
  ADD PRIMARY KEY (`id_jadwal_kocokan`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `kelompok`
--
ALTER TABLE `kelompok`
  ADD PRIMARY KEY (`id_kelompok`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `outlet`
--
ALTER TABLE `outlet`
  ADD PRIMARY KEY (`id_outlet`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indeks untuk tabel `pembayaran_pembelian`
--
ALTER TABLE `pembayaran_pembelian`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`faktur_pembelian`);

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id_pengaturan`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`faktur_penjualan`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indeks untuk tabel `pulsa`
--
ALTER TABLE `pulsa`
  ADD PRIMARY KEY (`id_pulsa`);

--
-- Indeks untuk tabel `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id_register`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id_stok`);

--
-- Indeks untuk tabel `stok_opname`
--
ALTER TABLE `stok_opname`
  ADD PRIMARY KEY (`id_stok_opname`);

--
-- Indeks untuk tabel `stok_outlet`
--
ALTER TABLE `stok_outlet`
  ADD PRIMARY KEY (`id_stok_outlet`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `token_petugas`
--
ALTER TABLE `token_petugas`
  ADD PRIMARY KEY (`id_token_petugas`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akses_role`
--
ALTER TABLE `akses_role`
  MODIFY `akses_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

--
-- AUTO_INCREMENT untuk tabel `backup`
--
ALTER TABLE `backup`
  MODIFY `id_backup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  MODIFY `id_detail_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_detail_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `detail_stok_opname`
--
ALTER TABLE `detail_stok_opname`
  MODIFY `id_detail_stok_opname` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT untuk tabel `pembayaran_pembelian`
--
ALTER TABLE `pembayaran_pembelian`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id_pengaturan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `register`
--
ALTER TABLE `register`
  MODIFY `id_register` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `stok_outlet`
--
ALTER TABLE `stok_outlet`
  MODIFY `id_stok_outlet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `token_petugas`
--
ALTER TABLE `token_petugas`
  MODIFY `id_token_petugas` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
