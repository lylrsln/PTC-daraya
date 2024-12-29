-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Des 2024 pada 20.13
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjadwalan2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`, `created_at`) VALUES
(1, 'adminith@gmail.com', '$2y$10$Qfea/4ObFeskt/H0MPJOAefcJMB/JCNF7ZIc7QDMgx970bhfIAbnG', '2024-12-29 18:16:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `dosen_id` int(11) NOT NULL,
  `nama_dosen` varchar(255) NOT NULL,
  `nip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`dosen_id`, `nama_dosen`, `nip`) VALUES
(1, 'PUTRI AYU MAHARANI, S.T., M.Sc.       ', '19940611202203202'),
(2, 'NAILI SURI INTIZHAMI, S.Kom., M.Kom.', '19950308 202203 2 01'),
(3, 'EKA QADRI NURANTI B., S.Kom., M.Kom.', '19950208 202203 2 01'),
(4, 'MARDHIYYAH RAFRIN, S.T., M.Sc.  ', '19900921 202203 2 01'),
(5, 'MUH. AGUS, S.Kom., M.Kom.  ', '19950821 202203 1 01'),
(6, 'NUR RAHMI, S.Pd., M.Si.  ', '19921006 202203 2 01'),
(7, 'WAHYUNI EKASASMITA, S.Pd., M.Sc.', '19910413 202203 2 01'),
(8, 'AHMAD FAJRI S., S.Si., M.Si.  ', '19950508 202203 1 00'),
(9, 'MIFTAHULKHAIRAH, M.Sc.     ', '19880922 202203 2 00'),
(10, 'NURUL FUADY ADHALIA H, S.Pd., M.Si.     ', '19901210 202203 2 00'),
(13, 'MAR\'ATUTTAHIRAH, S.Pd., M.T.   ', '19940701 202203 2 01'),
(15, 'ROSMIATI, S.Kom., M.Kom. ', '19900328 202203 2 00'),
(16, 'KHAERA TUNNISA, S.Tr.Kom., M.Kom.', '19960506 202203 2 02'),
(17, 'RAKHMADI RAHMAN, M.Kom. ', '19900316 202203 1 00'),
(18, 'AHMAD HUSAIN, S.SI., M.STAT.', '199510192024061001'),
(19, 'MUHAMMAD IKHWAN BURHAN, S.KOM., M.KOM.', '199512292024061002'),
(20, 'NURUL FEBRIANI PUTRI, M.SI.', '199302012024062001'),
(23, 'MUNADRAH, S.T., M.T.', '199507222024062001'),
(24, 'MUHAIMIN HADING, S.T., M.ENG.', '199011282024062002'),
(25, 'ERFIN KURNIAWAN, S.P., M.SI.', '199502042024061003 '),
(26, 'ROZALINA AMRAN, S.T., M.ENG.', '199102242024062001'),
(27, 'SYAHRUL SATAR, S.T.,M.T.', '199802042024061001'),
(28, 'ANAS, S.KOM., M.KOM.', '198904182024061003'),
(29, 'MUHAMMAD ULIAH SHAFAR, S.ARS., M.ARS.', '199606262024061001'),
(30, 'FITRIAGUSTIANI, S.SI, M.SI.', '199108202024062001'),
(31, 'MUH. CHAERIL IKRAMULLAH, S.PD., M.BIOTECH.', '199508282024061002'),
(32, 'PASMAWATI, S.SI., M.SI.', '199311102024062002'),
(33, 'ANDRI DWI UTOMO, S.KOM., M.T.', '199205032024061001'),
(34, 'ANDI TAUFIQURRAHMAN AKBAR, M.KOM.', '199804102024061001'),
(35, 'MUHAMMAD RUSDIN JUMURDIN, S.ARS., M.ARS', '199312192024061001'),
(36, 'ANDI NURFADILLAH ALI, S.TR.KOM., M.KOM.', '199709202024062002'),
(37, 'RADHIANSYAH, M.T.', '199606062024061002'),
(38, 'MUZAKKIR, S.E., M.SI.', '199312162024061001'),
(39, 'NI\'MAH NATSIR, S.T., M.ARS.', '199410152024062003'),
(40, 'MUH ZULFADLI A SUYUTI, S.T., M.KOM.', '199606302024061002'),
(41, 'HUSNUL HATIMAH, M.T.P.', '199608222024062003'),
(42, 'YUSRI PRAYITNA, S.SI., M.T.', '199012062024061001'),
(43, 'NURUL CHAIRUNNISA NOOR, S.T., M.T.', '199511302024062003'),
(44, 'MUHAMMAD SYAFAAT, S.KOM., M.KOM.', '199502042024061001'),
(45, 'FITRI HANDAYANI, M.SI.', '199412072024062001'),
(46, 'SYUKRIKA PUTRI, M.T.', '199601182024062001'),
(47, 'A. INAYAH AULIYAH, M.KOM.', '199707172024062001'),
(48, 'A. SYAHRINALDY SYAHRUDDIN, M.T.', '199201012024061002'),
(49, 'AHMAD TAMSIL YUNUS, M.T.', '199203102024061001'),
(50, 'NUR AZISAH SYAM, S.ST., M.SI.', '199305022024062003'),
(51, 'PRIHATIN, S.P., M.SI.', '19930903202406100'),
(52, 'RISMAN FIRMAN, M.T', '199307102024061004'),
(53, 'RIZKI ARISTYARINI, M.SI.', '199312072024062002'),
(54, 'YANNY FEBRY FITRIANI SOFYAN, S.T., M.T.', '199503072024062002'),
(55, 'FITRAWATY ORISTA EVAR, S.P., M.SI.', '199403122024062002'),
(56, 'ARDI MANGGALA PUTRA, S.TP., M.SI.', '199205142024061004'),
(57, 'IKA RESKIANA ADRIANI, M.SI.', '199410242024062002'),
(58, 'JEFFRY, S.KOM., M.T.', '199211212024061002'),
(59, 'WAKHID YUNENDAR, S.PD., M.PD.', '199201142024061001'),
(60, 'MUHAMMAD IRSAN, S.T., M.T.', '198501212010121003'),
(61, 'DR. ANWAR, S.E., M.AK., AKT.', '197001042005021004'),
(62, 'DR. Ir. ABDULLAH B., M.M.', '19661231 199703 1 03'),
(63, 'SURYANSYAH SURAHMAN', '002'),
(65, 'NUR HARDINA', '003'),
(66, 'ANDRIYANA GUSTAM', '004'),
(67, 'NURMALASARI S.', '005'),
(68, 'SURIYANTO BAKRI', '006'),
(69, 'MUHAMMAD RIFKI NISARDI', '007'),
(70, 'ABDUL ZAIN', '008'),
(71, 'JOEY LIMBONGAN', '009'),
(72, 'ANDI WIDIASARI MARUDDANI', '010'),
(73, 'ZULKIFLI ANSHARI', '011'),
(74, 'INRIYANI', '012'),
(75, 'IWAN AS\'AD', '013'),
(76, 'RIFALDY ATLANT TUNGGA', '014'),
(77, 'KUSNAENI', '015'),
(78, 'APRIZAL RESKY', '016'),
(79, 'ZAITUN', '017'),
(80, 'HARTINA HUSAIN', '018'),
(81, 'MARWAN SAM', '019'),
(82, 'JABALUDDIN HAMUD', '020'),
(83, 'IRMAYANI', '021'),
(84, 'AMALUDDIN', '022'),
(85, 'ALFIANSYAH ANWAR', '023'),
(86, 'PUTRI DEWI', '024'),
(87, 'AMIRUDDIN Z. NUR', '025'),
(88, 'SYAIFUL MAHSAN', '026'),
(89, 'HASDAR BACHTIAR', '027'),
(90, 'FERRY KEINTJEM', '028'),
(91, 'MARTINUS JIMUNG', '029'),
(92, 'ALVIAN TRI PUTRA DARTI A, S.Kom., M.Kom.', '19940219 202203 1 00'),
(95, 'A. IKA PUTRIANI', '030'),
(96, 'MUHAIMIN. H', '031'),
(97, 'MUH IKHWAN BURHAN', '032');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen_mk`
--

CREATE TABLE `dosen_mk` (
  `dosen_mk_id` int(11) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `matkul_id` int(11) NOT NULL,
  `prodi_id` int(11) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `tahun_akademik_id` int(11) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dosen_mk`
--

INSERT INTO `dosen_mk` (`dosen_mk_id`, `dosen_id`, `matkul_id`, `prodi_id`, `jurusan`, `tahun_akademik_id`, `kelas_id`) VALUES
(1, 2, 42, 1, 'Teknologi Produksi dan Industri', 1, 2),
(2, 2, 47, 1, 'Teknologi Produksi dan Industri', 1, 3),
(3, 3, 17, 1, 'Teknologi Produksi dan Industri', 1, 20),
(4, 3, 42, 1, 'Teknologi Produksi dan Industri', 1, 2),
(5, 3, 55, 1, 'Teknologi Produksi dan Industri', 1, 2),
(6, 4, 46, 1, 'Teknologi Produksi dan Industri', 1, 4),
(7, 4, 55, 1, 'Teknologi Produksi dan Industri', 1, 2),
(8, 1, 21, 1, 'Teknologi Produksi dan Industri', 1, 21),
(9, 1, 50, 1, 'Teknologi Produksi dan Industri', 1, 1),
(10, 1, 48, 1, 'Teknologi Produksi dan Industri', 1, 1),
(11, 5, 56, 1, 'Teknologi Produksi dan Industri', 1, 5),
(12, 5, 53, 1, 'Teknologi Produksi dan Industri', 1, 5),
(13, 40, 20, 1, 'Teknologi Produksi dan Industri', 1, 21),
(14, 40, 46, 1, 'Teknologi Produksi dan Industri', 1, 3),
(15, 40, 51, 1, 'Teknologi Produksi dan Industri', 1, 3),
(16, 58, 1, 1, 'Teknologi Produksi dan Industri', 1, 7),
(17, 58, 4, 1, 'Teknologi Produksi dan Industri', 1, 7),
(18, 58, 18, 1, 'Teknologi Produksi dan Industri', 1, 20),
(19, 34, 1, 1, 'Teknologi Produksi dan Industri', 1, 7),
(20, 34, 56, 1, 'Teknologi Produksi dan Industri', 1, 5),
(21, 34, 19, 1, 'Teknologi Produksi dan Industri', 1, 22),
(22, 44, 18, 1, 'Teknologi Produksi dan Industri', 1, 20),
(23, 44, 19, 1, 'Teknologi Produksi dan Industri', 1, 22),
(24, 44, 53, 1, 'Teknologi Produksi dan Industri', 1, 5),
(25, 33, 20, 1, 'Teknologi Produksi dan Industri', 1, 21),
(26, 33, 17, 1, 'Teknologi Produksi dan Industri', 1, 21),
(27, 33, 48, 1, 'Teknologi Produksi dan Industri', 1, 1),
(28, 55, 128, 4, 'Teknologi Produksi dan Industri', 1, 15),
(29, 55, 70, 4, 'Teknologi Produksi dan Industri', 1, 15),
(30, 55, 76, 4, 'Teknologi Produksi dan Industri', 1, 17),
(31, 92, 86, 2, 'Sains\r\n', 1, 10),
(32, 41, 62, 5, 'Sains', 1, 24),
(34, 56, 136, 1, 'Teknologi Produksi dan Industri', 1, 1),
(35, 56, 71, 4, 'Teknologi Produksi dan Industri', 1, 13),
(36, 53, 72, 4, 'Teknologi Produksi dan Industri', 1, 17),
(37, 53, 70, 4, 'Teknologi Produksi dan Industri', 1, 27),
(38, 53, 147, 4, 'Teknologi Produksi dan Industri', 1, 15),
(39, 63, 74, 4, 'Teknologi Produksi dan Industri', 1, 17),
(40, 63, 73, 4, 'Teknologi Produksi dan Industri', 1, 17),
(41, 65, 128, 4, 'Teknologi Produksi dan Industri', 1, 15),
(42, 65, 72, 4, 'Teknologi Produksi dan Industri', 1, 27),
(44, 65, 71, 4, 'Teknologi Produksi dan Industri', 1, 14),
(45, 66, 69, 4, 'Teknologi Produksi dan Industri', 1, 35),
(46, 66, 71, 4, 'Teknologi Produksi dan Industri', 1, 31),
(47, 66, 76, 4, 'Teknologi Produksi dan Industri', 1, 27),
(48, 66, 74, 4, 'Teknologi Produksi dan Industri', 1, 17),
(49, 46, 148, 10, 'Teknologi Produksi dan Industri', 1, 31),
(50, 46, 121, 10, 'Teknologi Produksi dan Industri', 1, 35),
(51, 46, 149, 10, 'Teknologi Produksi dan Industri', 1, 31),
(52, 46, 106, 10, 'Teknologi Produksi dan Industri', 1, 35),
(53, 46, 150, 10, 'Teknologi Produksi dan Industri', 1, 31),
(54, 46, 151, 10, 'Teknologi Produksi dan Industri', 1, 32),
(55, 42, 152, 10, 'Teknologi Produksi dan Industri', 1, 10),
(56, 42, 138, 10, 'Teknologi Produksi dan Industri', 1, 3),
(57, 42, 153, 10, 'Teknologi Produksi dan Industri', 1, 13),
(58, 42, 154, 10, 'Teknologi Produksi dan Industri', 1, 10),
(59, 67, 151, 10, 'Teknologi Produksi dan Industri', 1, 14),
(60, 67, 148, 10, 'Teknologi Produksi dan Industri', 1, 27),
(61, 67, 152, 10, 'Teknologi Produksi dan Industri', 1, 10),
(62, 67, 154, 10, 'Teknologi Produksi dan Industri', 1, 11),
(63, 68, 149, 10, 'Teknologi Produksi dan Industri', 1, 14),
(64, 68, 122, 10, 'Teknologi Produksi dan Industri', 1, 12),
(65, 68, 106, 10, 'Teknologi Produksi dan Industri', 1, 31),
(66, 68, 153, 10, 'Teknologi Produksi dan Industri', 1, 11),
(67, 68, 150, 10, 'Teknologi Produksi dan Industri', 1, 12),
(68, 69, 2, 10, 'Teknologi Produksi dan Industri', 1, 18),
(69, 69, 1, 10, 'Teknologi Produksi dan Industri', 1, 12),
(70, 69, 93, 3, 'Sains', 1, 18),
(72, 70, 111, 11, 'Teknologi Produksi dan Industri', 1, 10),
(73, 70, 43, 11, 'Teknologi Produksi dan Industri', 1, 11),
(74, 43, 105, 11, 'Teknologi Produksi dan Industri', 1, 5),
(75, 43, 109, 11, 'Teknologi Produksi dan Industri', 1, 19),
(76, 37, 107, 11, 'Teknologi Produksi dan Industri', 1, 17),
(77, 37, 108, 11, 'Teknologi Produksi dan Industri', 1, 33),
(78, 48, 106, 11, 'Teknologi Produksi dan Industri', 1, 17),
(79, 48, 120, 11, 'Teknologi Produksi dan Industri', 1, 35),
(80, 48, 110, 11, 'Teknologi Produksi dan Industri', 1, 13),
(81, 52, 136, 9, 'Teknologi Produksi dan Industri', 1, 11),
(82, 52, 5, 9, 'Teknologi Produksi dan Industri', 1, 10),
(83, 52, 5, 8, 'Teknologi Produksi dan Industri', 1, 11),
(84, 54, 136, 9, 'Teknologi Produksi dan Industri', 1, 9),
(85, 71, 2, 9, 'Teknologi Produksi dan Industri', 1, 11),
(86, 71, 1, 9, 'Teknologi Produksi dan Industri', 1, 6),
(87, 49, 1, 9, 'Teknologi Produksi dan Industri', 1, 11),
(88, 49, 120, 9, 'Teknologi Produksi dan Industri', 1, 19),
(89, 27, 2, 9, 'Teknologi Produksi dan Industri', 1, 18),
(90, 23, 120, 9, 'Teknologi Produksi dan Industri', 1, 9),
(91, 72, 143, 8, 'Teknologi Produksi dan Industri', 1, 12),
(92, 72, 1, 8, 'Teknologi Produksi dan Industri', 1, 11),
(93, 72, 1, 9, 'Teknologi Produksi dan Industri', 1, 8),
(94, 72, 5, 1, 'Teknologi Produksi dan Industri', 1, 8),
(95, 72, 5, 9, 'Teknologi Produksi dan Industri', 1, 3),
(96, 72, 4, 8, 'Teknologi Produksi dan Industri', 1, 6),
(97, 29, 141, 8, 'Teknologi Produksi dan Industri', 1, 1),
(98, 29, 122, 8, 'Teknologi Produksi dan Industri', 1, 10),
(99, 35, 139, 8, 'Teknologi Produksi dan Industri', 1, 5),
(100, 39, 139, 8, 'Teknologi Produksi dan Industri', 1, 2),
(101, 25, 139, 8, 'Teknologi Produksi dan Industri', 1, 5),
(102, 72, 1, 8, 'Teknologi Produksi dan Industri', 1, 3),
(103, 73, 143, 8, 'Teknologi Produksi dan Industri', 1, 2),
(104, 73, 142, 8, 'Teknologi Produksi dan Industri', 1, 13),
(105, 73, 5, 8, 'Teknologi Produksi dan Industri', 1, 11),
(106, 73, 5, 9, 'Teknologi Produksi dan Industri', 1, 34),
(107, 73, 122, 8, 'Teknologi Produksi dan Industri', 1, 3),
(108, 73, 49, 3, 'Sains', 1, 8),
(109, 74, 1, 8, 'Teknologi Produksi dan Industri', 1, 2),
(110, 74, 142, 8, 'Teknologi Produksi dan Industri', 1, 10),
(111, 74, 140, 8, 'Teknologi Produksi dan Industri', 1, 3),
(112, 74, 5, 8, 'Teknologi Produksi dan Industri', 1, 13),
(113, 74, 5, 9, 'Teknologi Produksi dan Industri', 1, 5),
(114, 74, 122, 8, 'Teknologi Produksi dan Industri', 1, 7),
(115, 10, 163, 3, 'Sains', 1, 9),
(116, 10, 158, 3, 'Sains', 1, 6),
(117, 10, 96, 3, 'Sains', 1, 4),
(118, 10, 96, 1, 'Teknologi Produksi dan Industri', 1, 8),
(119, 10, 90, 3, 'Sains', 1, 5),
(120, 10, 155, 3, 'Sains', 1, 3),
(121, 6, 168, 1, 'Teknologi Produksi dan Industri', 1, 10),
(122, 6, 159, 3, 'Sains', 1, 4),
(123, 6, 5, 1, 'Teknologi Produksi dan Industri', 1, 8),
(124, 6, 92, 3, 'Sains', 1, 11),
(125, 6, 161, 3, 'Sains', 1, 27),
(126, 9, 2, 1, 'Teknologi Produksi dan Industri', 1, 11),
(127, 9, 5, 2, 'Sains\r\n', 1, 11),
(129, 9, 167, 3, 'Sains', 1, 9),
(130, 9, 160, 3, 'Sains', 1, 10),
(131, 75, 131, 3, 'Sains', 1, 7),
(132, 75, 114, 2, 'Sains\r\n', 1, 10),
(133, 75, 131, 5, 'Sains', 1, 9),
(134, 75, 131, 6, 'Sains', 1, 10),
(135, 75, 131, 7, 'Sains', 1, 32),
(136, 75, 7, 1, 'Teknologi Produksi dan Industri', 1, 13),
(137, 75, 7, 4, 'Teknologi Produksi dan Industri', 1, 11),
(138, 75, 7, 8, 'Teknologi Produksi dan Industri', 1, 16),
(139, 75, 7, 9, 'Teknologi Produksi dan Industri', 1, 31),
(140, 75, 7, 10, 'Teknologi Produksi dan Industri', 1, 20),
(141, 75, 7, 11, 'Teknologi Produksi dan Industri', 1, 31),
(142, 76, 126, 9, 'Teknologi Produksi dan Industri', 1, 9),
(143, 76, 89, 3, 'Sains', 1, 12),
(144, 76, 166, 3, 'Sains', 1, 15),
(145, 76, 92, 3, 'Sains', 1, 17),
(146, 76, 156, 3, 'Sains', 1, 31),
(147, 76, 161, 3, 'Sains', 1, 11),
(148, 77, 2, 1, 'Teknologi Produksi dan Industri', 1, 9),
(149, 77, 159, 3, 'Sains', 1, 10),
(150, 77, 132, 2, 'Sains\r\n', 1, 10),
(151, 77, 167, 3, 'Sains', 1, 8),
(152, 77, 160, 3, 'Sains', 1, 9),
(153, 78, 126, 2, 'Sains\r\n', 1, 16),
(154, 78, 1, 2, 'Sains\r\n', 1, 9),
(155, 78, 124, 3, 'Sains', 1, 26),
(156, 78, 124, 7, 'Sains', 1, 19),
(157, 78, 101, 7, 'Sains', 1, 19),
(158, 79, 133, 3, 'Sains', 1, 26),
(159, 79, 124, 7, 'Sains', 1, 32),
(160, 79, 95, 7, 'Sains', 1, 19),
(161, 79, 126, 2, 'Sains\r\n', 1, 11),
(162, 79, 103, 7, 'Sains', 1, 19),
(163, 79, 101, 7, 'Sains', 1, 19),
(164, 79, 112, 11, 'Teknologi Produksi dan Industri', 1, 35),
(165, 80, 137, 2, 'Sains\r\n', 1, 11),
(166, 80, 137, 3, 'Sains', 1, 26),
(167, 80, 137, 7, 'Sains', 1, 19),
(168, 80, 104, 7, 'Sains', 1, 19),
(169, 80, 125, 7, 'Sains', 1, 19),
(170, 28, 98, 7, 'Sains', 1, 19),
(171, 28, 162, 3, 'Sains', 1, 26),
(172, 28, 100, 7, 'Sains', 1, 19),
(173, 59, 4, 1, 'Teknologi Produksi dan Industri', 1, 7),
(174, 58, 124, 2, 'Sains\r\n', 1, 10),
(175, 59, 125, 3, 'Sains', 1, 26),
(176, 59, 125, 7, 'Sains', 1, 19),
(177, 59, 98, 7, 'Sains', 1, 19),
(178, 59, 162, 3, 'Sains', 1, 18),
(179, 26, 125, 3, 'Sains', 1, 26),
(180, 26, 102, 7, 'Sains', 1, 19),
(181, 26, 100, 7, 'Sains', 1, 19),
(182, 18, 137, 2, 'Sains\r\n', 1, 10),
(183, 18, 99, 7, 'Sains', 1, 19),
(184, 18, 102, 7, 'Sains', 1, 19),
(185, 18, 103, 7, 'Sains', 1, 19),
(186, 81, 137, 3, 'Sains', 1, 26),
(187, 81, 137, 7, 'Sains', 1, 19),
(188, 81, 93, 3, 'Sains', 1, 26),
(189, 81, 97, 7, 'Sains', 1, 19),
(190, 81, 22, 1, 'Teknologi Produksi dan Industri', 1, 20),
(191, 81, 104, 7, 'Sains', 1, 19),
(192, 38, 1, 10, 'Teknologi Produksi dan Industri', 1, 31),
(193, 38, 23, 1, 'Teknologi Produksi dan Industri', 1, 20),
(194, 50, 124, 2, 'Sains\r\n', 1, 10),
(195, 50, 23, 1, 'Teknologi Produksi dan Industri', 1, 20),
(196, 57, 126, 4, 'Teknologi Produksi dan Industri', 1, 15),
(197, 57, 126, 6, 'Sains', 1, 32),
(198, 57, 94, 3, 'Sains', 1, 26),
(199, 57, 1, 11, 'Teknologi Produksi dan Industri', 1, 13),
(200, 57, 95, 3, 'Sains', 1, 18),
(201, 82, 124, 6, 'Sains', 1, 32),
(202, 82, 124, 5, 'Sains', 1, 16),
(203, 82, 23, 1, 'Teknologi Produksi dan Industri', 1, 21),
(204, 82, 5, 1, 'Teknologi Produksi dan Industri', 1, 9),
(205, 82, 79, 2, 'Sains\r\n', 1, NULL),
(206, 81, 79, 2, 'Sains\r\n', 1, NULL),
(207, 82, 79, 3, 'Sains', 1, NULL),
(208, 7, 169, 6, 'Sains', 1, NULL),
(209, 7, 158, 3, 'Sains', 1, NULL),
(210, 7, 165, 3, 'Sains', 1, NULL),
(211, 7, 90, 3, 'Sains', 1, NULL),
(212, 7, 78, 2, 'Sains\r\n', 1, NULL),
(213, 8, 89, 3, 'Sains', 1, NULL),
(214, 8, 169, 6, 'Sains', 1, NULL),
(215, 8, 158, 3, 'Sains', 1, NULL),
(216, 8, 166, 3, 'Sains', 1, NULL),
(217, 8, 22, 1, 'Teknologi Produksi dan Industri', 1, NULL),
(218, 8, 156, 3, 'Sains', 1, NULL),
(219, 8, 95, 3, 'Sains', 1, NULL),
(220, 83, 137, 4, 'Teknologi Produksi dan Industri', 1, NULL),
(221, 83, 126, 6, 'Sains', 1, NULL),
(222, 83, 78, 2, 'Sains\r\n', 1, NULL),
(223, 83, 22, 1, 'Teknologi Produksi dan Industri', 1, NULL),
(224, 83, 96, 3, 'Sains', 1, NULL),
(225, 83, 4, 11, 'Teknologi Produksi dan Industri', 1, NULL),
(226, 83, 112, 11, 'Teknologi Produksi dan Industri', 1, NULL),
(227, 62, 132, 2, 'Sains\r\n', 1, NULL),
(228, 61, 119, 3, 'Sains', 1, NULL),
(229, 62, 119, 5, 'Sains', 1, NULL),
(230, 62, 119, 6, 'Sains', 1, NULL),
(231, 62, 119, 7, 'Sains', 1, NULL),
(232, 62, 79, 2, 'Sains\r\n', 1, NULL),
(233, 62, 79, 3, 'Sains', 1, NULL),
(234, 62, 73, 4, 'Teknologi Produksi dan Industri', 1, NULL),
(235, 55, 119, 2, 'Sains\r\n', 1, NULL),
(236, 45, 119, 3, 'Sains', 1, NULL),
(237, 45, 119, 5, 'Sains', 1, NULL),
(238, 45, 119, 6, 'Sains', 1, NULL),
(239, 45, 119, 7, 'Sains', 1, NULL),
(240, 45, 134, 5, 'Sains', 1, NULL),
(241, 30, 128, 5, 'Sains', 1, NULL),
(242, 30, 119, 2, 'Sains\r\n', 1, NULL),
(243, 30, 119, 3, 'Sains', 1, NULL),
(244, 30, 119, 5, 'Sains', 1, NULL),
(245, 30, 119, 6, 'Sains', 1, NULL),
(246, 30, 119, 7, 'Sains', 1, NULL),
(247, 31, 124, 6, 'Sains', 1, NULL),
(248, 20, 134, 5, 'Sains', 1, NULL),
(249, 20, 119, 2, 'Sains\r\n', 1, NULL),
(250, 20, 119, 3, 'Sains', 1, NULL),
(251, 20, 119, 5, 'Sains', 1, NULL),
(252, 20, 119, 6, 'Sains', 1, NULL),
(253, 20, 119, 7, 'Sains', 1, NULL),
(254, 32, 128, 5, 'Sains', 1, NULL),
(255, 32, 119, 2, 'Sains\r\n', 1, NULL),
(256, 32, 119, 3, 'Sains', 1, NULL),
(257, 32, 119, 5, 'Sains', 1, NULL),
(258, 32, 119, 6, 'Sains', 1, NULL),
(259, 32, 119, 7, 'Sains', 1, NULL),
(260, 84, 127, 2, 'Sains\r\n', 1, NULL),
(261, 84, 6, 1, 'Teknologi Produksi dan Industri', 1, NULL),
(262, 84, 6, 9, 'Teknologi Produksi dan Industri', 1, NULL),
(263, 84, 6, 8, 'Teknologi Produksi dan Industri', 1, NULL),
(264, 84, 6, 4, 'Teknologi Produksi dan Industri', 1, NULL),
(265, 84, 130, 10, 'Teknologi Produksi dan Industri', 1, NULL),
(266, 85, 114, 4, 'Teknologi Produksi dan Industri', 1, NULL),
(267, 85, 114, 10, 'Teknologi Produksi dan Industri', 1, NULL),
(268, 84, 6, 9, 'Teknologi Produksi dan Industri', 1, NULL),
(269, 85, 131, 8, 'Teknologi Produksi dan Industri', 1, NULL),
(270, 85, 131, 2, 'Sains\r\n', 1, NULL),
(271, 85, 7, 1, 'Teknologi Produksi dan Industri', 1, NULL),
(272, 86, 8, 2, 'Sains\r\n', 1, NULL),
(273, 86, 8, 3, 'Sains', 1, NULL),
(274, 85, 8, 5, 'Sains', 1, NULL),
(275, 86, 8, 6, 'Sains', 1, NULL),
(276, 86, 8, 7, 'Sains', 1, NULL),
(277, 86, 8, 1, 'Teknologi Produksi dan Industri', 1, NULL),
(278, 87, 123, 2, 'Sains\r\n', 1, NULL),
(279, 87, 8, 1, 'Teknologi Produksi dan Industri', 1, NULL),
(280, 88, 123, 2, 'Sains\r\n', 1, NULL),
(281, 88, 8, 1, 'Teknologi Produksi dan Industri', 1, NULL),
(282, 89, 8, 4, 'Teknologi Produksi dan Industri', 1, NULL),
(283, 89, 8, 10, 'Teknologi Produksi dan Industri', 1, NULL),
(284, 89, 8, 9, 'Teknologi Produksi dan Industri', 1, NULL),
(285, 89, 8, 8, 'Teknologi Produksi dan Industri', 1, NULL),
(286, 90, 115, 2, 'Sains\r\n', 1, NULL),
(287, 91, 116, 2, 'Sains\r\n', 1, NULL),
(289, 16, 60, 2, 'Sains\r\n', 1, NULL),
(290, 16, 84, 2, 'Sains\r\n', 1, NULL),
(291, 16, 83, 2, 'Sains\r\n', 1, NULL),
(292, 13, 125, 2, 'Sains\r\n', 1, NULL),
(293, 13, 58, 2, 'Sains\r\n', 1, NULL),
(294, 15, 81, 2, 'Sains\r\n', 1, NULL),
(295, 15, 60, 2, 'Sains\r\n', 1, NULL),
(296, 92, 8, 2, 'Sains\r\n', 1, NULL),
(297, 92, 68, 2, 'Sains\r\n', 1, NULL),
(298, 92, 67, 2, 'Sains\r\n', 1, NULL),
(299, 17, 57, 2, 'Sains\r\n', 1, NULL),
(300, 17, 62, 2, 'Sains\r\n', 1, NULL),
(301, 17, 85, 2, 'Sains\r\n', 1, NULL),
(302, 17, 83, 2, 'Sains\r\n', 1, NULL),
(303, 95, 1, 1, 'Teknologi Produksi dan Industri', 1, NULL),
(304, 95, 78, 2, 'Sains\r\n', 1, NULL),
(305, 96, 66, 2, 'Sains\r\n', 1, NULL),
(306, 96, 85, 2, 'Sains\r\n', 1, NULL),
(307, 97, 67, 2, 'Sains\r\n', 1, NULL),
(308, 97, 125, 2, 'Sains\r\n', 1, NULL),
(309, 97, 66, 2, 'Sains\r\n', 1, NULL),
(310, 47, 86, 2, 'Sains\r\n', 1, NULL),
(311, 47, 81, 2, 'Sains\r\n', 1, NULL),
(312, 47, 61, 2, 'Sains\r\n', 1, NULL),
(313, 36, 84, 2, 'Sains\r\n', 1, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `hari` varchar(20) DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `nama_ruangan` varchar(100) DEFAULT NULL,
  `nama_matkul` varchar(100) DEFAULT NULL,
  `nama_dosen` varchar(100) DEFAULT NULL,
  `nama_kelas` varchar(100) DEFAULT NULL,
  `tahun_akademik_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id`, `hari`, `jam_mulai`, `jam_selesai`, `nama_ruangan`, `nama_matkul`, `nama_dosen`, `nama_kelas`, `tahun_akademik_id`) VALUES
(1, 'Rabu', '09:05:00', '10:35:00', 'R. MATEPPE 203', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22-Mobile', NULL),
(2, 'Kamis', '16:40:00', '18:10:00', 'R. MAKKAWARU 102', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22 B', NULL),
(3, 'Rabu', '07:30:00', '09:00:00', 'R. MALEBBI 202', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-AR/VR', NULL),
(4, 'Senin', '07:30:00', '09:00:00', 'R. MAMASE 206', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22 B', NULL),
(5, 'Senin', '13:30:00', '15:00:00', 'R. MALEBBI 202', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-AR/VR', NULL),
(6, 'Selasa', '15:05:00', '16:35:00', 'R. MARESO 103 ', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-Mobile', NULL),
(7, 'Selasa', '10:40:00', '12:10:00', 'Ruang Kelas 205', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22-Mobile', NULL),
(8, 'Kamis', '07:30:00', '09:00:00', 'Ruang Kelas 205', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-Visi Komputer', NULL),
(9, 'Jumat', '15:05:00', '16:35:00', 'R. MAMASE 206', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-AR/VR', NULL),
(10, 'Rabu', '15:05:00', '16:35:00', 'Ruang Kelas 205', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22-Mobile', NULL),
(11, 'Selasa', '13:30:00', '15:00:00', 'R. MAMASE 206', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-AR/VR', NULL),
(12, 'Kamis', '10:40:00', '12:10:00', 'R. MALEBBI 202', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22 A', NULL),
(13, 'Selasa', '10:40:00', '12:10:00', 'R. MAKKAWARU 102', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22 B', NULL),
(14, 'Rabu', '10:40:00', '12:10:00', 'R. MARESO 103 ', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22 A', NULL),
(15, 'Jumat', '16:40:00', '18:10:00', 'R. MALEBBI 202', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-Visi Komputer', NULL),
(16, 'Rabu', '10:40:00', '12:10:00', 'R. MAMASE 206', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22-Visi Komputer', NULL),
(17, 'Selasa', '09:05:00', '10:35:00', 'R. MATEPPE 203', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22 B', NULL),
(18, 'Senin', '07:30:00', '09:00:00', 'R. MAKKAWARU 102', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-AR/VR', NULL),
(19, 'Kamis', '16:40:00', '18:10:00', 'R. MAKKAWARU 102', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22 A', NULL),
(20, 'Rabu', '16:40:00', '18:10:00', 'R. MALEBBI 202', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-Mobile', NULL),
(21, 'Rabu', '16:40:00', '18:10:00', 'Ruang Kelas 205', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-Visi Komputer', NULL),
(22, 'Kamis', '13:30:00', '15:00:00', 'R. MACCA 101', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22 A', NULL),
(23, 'Rabu', '13:30:00', '15:00:00', 'Ruang Kelas 205', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22 A', NULL),
(24, 'Senin', '09:05:00', '10:35:00', 'R. MARESO 103 ', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-AR/VR', NULL),
(25, 'Jumat', '15:05:00', '16:35:00', 'R. MALEBBI 202', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22 A', NULL),
(26, 'Rabu', '09:05:00', '10:35:00', 'Ruang Kelas 205', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22-Mobile', NULL),
(27, 'Jumat', '07:30:00', '09:00:00', 'R. MARESO 103 ', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22-Visi Komputer', NULL),
(28, 'Kamis', '13:30:00', '15:00:00', 'R. MACCA 101', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-Mobile', NULL),
(29, 'Senin', '09:05:00', '10:35:00', 'R. MAMASE 206', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22 A', NULL),
(30, 'Senin', '15:05:00', '16:35:00', 'R. MAKKAWARU 102', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22-Visi Komputer', NULL),
(31, 'Jumat', '15:05:00', '16:35:00', 'Ruang Kelas 205', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22 A', NULL),
(32, 'Jumat', '13:30:00', '15:00:00', 'R. MACCA 101', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22 B', NULL),
(33, 'Rabu', '13:30:00', '15:00:00', 'R. MAKKAWARU 102', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-AR/VR', NULL),
(34, 'Kamis', '15:05:00', '16:35:00', 'R. MAKKAWARU 102', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22 B', NULL),
(35, 'Selasa', '10:40:00', '12:10:00', 'R. MARESO 103 ', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22 A', NULL),
(36, 'Senin', '07:30:00', '09:00:00', 'R. MAKKAWARU 102', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22 A', NULL),
(37, 'Kamis', '07:30:00', '09:00:00', 'Ruang Kelas 205', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22 B', NULL),
(38, 'Jumat', '13:30:00', '15:00:00', 'R. MAGETTENG 104 ', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22-Mobile', NULL),
(39, 'Kamis', '10:40:00', '12:10:00', 'R. MAGETTENG 104 ', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22 A', NULL),
(40, 'Selasa', '16:40:00', '18:10:00', 'R. MALEBBI 202', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-Mobile', NULL),
(41, 'Selasa', '09:05:00', '10:35:00', 'R. MAKKAWARU 102', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-Mobile', NULL),
(42, 'Rabu', '09:05:00', '10:35:00', 'R. MALEBBI 202', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22-AR/VR', NULL),
(43, 'Jumat', '10:40:00', '12:10:00', 'Ruang Kelas 205', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22 A', NULL),
(44, 'Rabu', '09:05:00', '10:35:00', 'R. MATEPPE 203', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22 B', NULL),
(45, 'Selasa', '09:05:00', '10:35:00', 'Ruang Kelas 205', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22 B', NULL),
(46, 'Senin', '16:40:00', '18:10:00', 'R. MATEPPE 203', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22-AR/VR', NULL),
(47, 'Selasa', '07:30:00', '09:00:00', 'R. MAKKAWARU 102', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22 B', NULL),
(48, 'Senin', '13:30:00', '15:00:00', 'R. MAMASE 206', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-Visi Komputer', NULL),
(49, 'Rabu', '09:05:00', '10:35:00', 'R. MAMASE 206', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22 B', NULL),
(50, 'Jumat', '09:05:00', '10:35:00', 'R. MATEPPE 203', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22-Visi Komputer', NULL),
(51, 'Senin', '07:30:00', '09:00:00', 'R. MATEPPE 203', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22-Mobile', NULL),
(52, 'Kamis', '13:30:00', '15:00:00', 'Ruang Kelas 205', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-AR/VR', NULL),
(53, 'Rabu', '09:05:00', '10:35:00', 'R. MAKKAWARU 102', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-Visi Komputer', NULL),
(54, 'Senin', '16:40:00', '18:10:00', 'R. MAGETTENG 104 ', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22 A', NULL),
(55, 'Selasa', '07:30:00', '09:00:00', 'R. MAMASE 206', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22 B', NULL),
(56, 'Rabu', '13:30:00', '15:00:00', 'Ruang Kelas 205', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22 A', NULL),
(57, 'Jumat', '13:30:00', '15:00:00', 'R. MALEBBI 202', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-Visi Komputer', NULL),
(58, 'Rabu', '09:05:00', '10:35:00', 'R. MAGETTENG 104 ', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22-Mobile', NULL),
(59, 'Selasa', '09:05:00', '10:35:00', 'R. MACCA 101', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22 A', NULL),
(60, 'Selasa', '13:30:00', '15:00:00', 'R. MACCA 101', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-AR/VR', NULL),
(61, 'Senin', '13:30:00', '15:00:00', 'R. MAMASE 206', 'Basis Data', 'Dr. Budi Prasetyo', 'Ilmu Komputer 22-AR/VR', NULL),
(62, 'Rabu', '15:05:00', '16:35:00', 'R. MAMASE 206', 'Pemrograman Dasar', 'Dr. Andi Setiawann', 'Ilmu Komputer 22-Mobile', NULL),
(63, 'Selasa', '09:05:00', '10:35:00', 'R. MATEPPE 203', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Mobile', NULL),
(64, 'Selasa', '13:30:00', '15:00:00', 'R. MAKKAWARU 102', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22 B', NULL),
(65, 'Jumat', '13:30:00', '15:00:00', 'R. MATEPPE 203', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22 A', NULL),
(66, 'Jumat', '10:40:00', '12:10:00', 'R. MATEPPE 203', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22-AR/VR', NULL),
(67, 'Jumat', '10:40:00', '12:10:00', 'R. MARESO 103 ', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22 B', NULL),
(68, 'Senin', '09:05:00', '10:35:00', 'Ruang Kelas 205', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22 B', NULL),
(69, 'Rabu', '13:30:00', '15:00:00', 'Ruang Kelas 205', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22 A', NULL),
(70, 'Kamis', '16:40:00', '18:10:00', 'R. MATEPPE 203', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Mobile', NULL),
(71, 'Jumat', '16:40:00', '18:10:00', 'R. MAGETTENG 104 ', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Visi Komputer', NULL),
(72, 'Kamis', '16:40:00', '18:10:00', 'R. MAGETTENG 104 ', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22 B', NULL),
(73, 'Kamis', '10:40:00', '12:10:00', 'R. MALEBBI 202', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Visi Komputer', NULL),
(74, 'Rabu', '09:05:00', '10:35:00', 'R. MATEPPE 203', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Visi Komputer', NULL),
(75, 'Kamis', '09:05:00', '10:35:00', 'R. MATEPPE 203', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Visi Komputer', NULL),
(76, 'Senin', '09:05:00', '10:35:00', 'R. MARESO 103 ', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22-AR/VR', NULL),
(77, 'Senin', '07:30:00', '09:00:00', 'R. MAMASE 206', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22 B', NULL),
(78, 'Selasa', '15:05:00', '16:35:00', 'R. MAMASE 206', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Mobile', NULL),
(79, 'Senin', '09:05:00', '10:35:00', 'R. MATEPPE 203', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-AR/VR', NULL),
(80, 'Jumat', '15:05:00', '16:35:00', 'R. MARESO 103 ', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22 B', NULL),
(81, 'Kamis', '10:40:00', '12:10:00', 'R. MALEBBI 202', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Mobile', NULL),
(82, 'Jumat', '13:30:00', '15:00:00', 'R. MAGETTENG 104 ', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Mobile', NULL),
(83, 'Rabu', '10:40:00', '12:10:00', 'R. MACCA 101', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Visi Komputer', NULL),
(84, 'Kamis', '09:05:00', '10:35:00', 'R. MAGETTENG 104 ', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22-AR/VR', NULL),
(85, 'Selasa', '10:40:00', '12:10:00', 'R. MAMASE 206', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Visi Komputer', NULL),
(86, 'Senin', '16:40:00', '18:10:00', 'R. MACCA 101', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22 B', NULL),
(87, 'Rabu', '07:30:00', '09:00:00', 'R. MAMASE 206', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Mobile', NULL),
(88, 'Rabu', '10:40:00', '12:10:00', 'R. MALEBBI 202', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Visi Komputer', NULL),
(89, 'Kamis', '16:40:00', '18:10:00', 'R. MARESO 103 ', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Visi Komputer', NULL),
(90, 'Jumat', '10:40:00', '12:10:00', 'R. MAMASE 206', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22 B', NULL),
(91, 'Senin', '10:40:00', '12:10:00', 'R. MAMASE 206', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Mobile', NULL),
(92, 'Senin', '13:30:00', '15:00:00', 'R. MACCA 101', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22 B', NULL),
(93, 'Rabu', '16:40:00', '18:10:00', 'Ruang Kelas 205', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-AR/VR', NULL),
(94, 'Selasa', '10:40:00', '12:10:00', 'R. MAGETTENG 104 ', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22 A', NULL),
(95, 'Rabu', '10:40:00', '12:10:00', 'R. MARESO 103 ', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Visi Komputer', NULL),
(96, 'Jumat', '16:40:00', '18:10:00', 'R. MAMASE 206', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Mobile', NULL),
(97, 'Senin', '15:05:00', '16:35:00', 'R. MARESO 103 ', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22 B', NULL),
(98, 'Selasa', '09:05:00', '10:35:00', 'R. MATEPPE 203', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Mobile', NULL),
(99, 'Senin', '15:05:00', '16:35:00', 'R. MAGETTENG 104 ', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Visi Komputer', NULL),
(100, 'Jumat', '15:05:00', '16:35:00', 'R. MACCA 101', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Visi Komputer', NULL),
(101, 'Selasa', '15:05:00', '16:35:00', 'R. MAKKAWARU 102', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Mobile', NULL),
(102, 'Selasa', '10:40:00', '12:10:00', 'Ruang Kelas 205', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22 A', NULL),
(103, 'Jumat', '09:05:00', '10:35:00', 'R. MARESO 103 ', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Visi Komputer', NULL),
(104, 'Selasa', '15:05:00', '16:35:00', 'R. MARESO 103 ', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22 B', NULL),
(105, 'Rabu', '09:05:00', '10:35:00', 'R. MARESO 103 ', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-AR/VR', NULL),
(106, 'Rabu', '10:40:00', '12:10:00', 'R. MAMASE 206', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22 A', NULL),
(107, 'Senin', '09:05:00', '10:35:00', 'R. MARESO 103 ', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22 A', NULL),
(108, 'Selasa', '07:30:00', '09:00:00', 'R. MAMASE 206', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Visi Komputer', NULL),
(109, 'Jumat', '13:30:00', '15:00:00', 'R. MARESO 103 ', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22-AR/VR', NULL),
(110, 'Kamis', '09:05:00', '10:35:00', 'R. MAKKAWARU 102', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22 B', NULL),
(111, 'Senin', '15:05:00', '16:35:00', 'Ruang Kelas 205', 'Jaringan Komputer', 'Prof. Siti Amalia', 'Ilmu Komputer 22 B', NULL),
(112, 'Jumat', '13:30:00', '15:00:00', 'R. MAKKAWARU 102', 'Algoritma dan Struktur Data', 'Prof. Siti Amalia', 'Ilmu Komputer 22-Mobile', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal2`
--

CREATE TABLE `jadwal2` (
  `jadwal_id` int(11) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `ruangan_id` int(11) NOT NULL,
  `matkul_id` int(11) NOT NULL,
  `waktu_id` int(11) NOT NULL,
  `tahun_akademik_id` int(11) NOT NULL,
  `prodi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal2`
--

INSERT INTO `jadwal2` (`jadwal_id`, `dosen_id`, `kelas_id`, `ruangan_id`, `matkul_id`, `waktu_id`, `tahun_akademik_id`, `prodi_id`) VALUES
(1, 1, 21, 1, 21, 19, 1, 1),
(2, 1, 1, 1, 50, 23, 1, 1),
(3, 1, 1, 6, 48, 1, 1, 1),
(4, 2, 2, 6, 42, 7, 1, 1),
(5, 2, 3, 8, 47, 27, 1, 1),
(6, 3, 20, 6, 17, 25, 1, 1),
(7, 3, 2, 7, 42, 10, 1, 1),
(8, 3, 2, 3, 55, 8, 1, 1),
(9, 4, 4, 5, 46, 9, 1, 1),
(10, 4, 2, 8, 55, 30, 1, 1),
(11, 5, 5, 3, 56, 28, 1, 1),
(12, 5, 5, 8, 53, 15, 1, 1),
(13, 6, 10, 1, 168, 6, 1, 1),
(14, 6, 4, 1, 159, 27, 1, 3),
(15, 6, 8, 7, 5, 24, 1, 1),
(16, 6, 11, 8, 92, 28, 1, 3),
(17, 6, 27, 8, 161, 16, 1, 3),
(18, 9, 11, 1, 2, 9, 1, 1),
(19, 9, 11, 5, 5, 22, 1, 2),
(20, 9, 9, 7, 167, 4, 1, 3),
(21, 9, 10, 4, 160, 26, 1, 3),
(22, 10, 9, 4, 163, 19, 1, 3),
(23, 10, 6, 8, 158, 4, 1, 3),
(24, 10, 4, 8, 96, 10, 1, 3),
(25, 10, 8, 2, 96, 1, 1, 1),
(26, 10, 5, 7, 90, 13, 1, 3),
(27, 10, 3, 2, 155, 29, 1, 3),
(28, 18, 10, 4, 137, 12, 1, 2),
(29, 18, 19, 3, 99, 2, 1, 7),
(30, 18, 19, 4, 102, 16, 1, 7),
(31, 18, 19, 6, 103, 17, 1, 7),
(32, 23, 9, 8, 120, 22, 1, 9),
(33, 25, 5, 6, 139, 9, 1, 8),
(34, 26, 26, 8, 125, 24, 1, 3),
(35, 26, 19, 2, 102, 8, 1, 7),
(36, 26, 19, 8, 100, 8, 1, 7),
(37, 27, 18, 1, 2, 8, 1, 9),
(38, 28, 19, 2, 98, 16, 1, 7),
(39, 28, 26, 6, 162, 16, 1, 3),
(40, 28, 19, 2, 100, 11, 1, 7),
(41, 29, 1, 1, 141, 22, 1, 8),
(42, 29, 10, 3, 122, 9, 1, 8),
(43, 33, 21, 6, 20, 24, 1, 1),
(44, 33, 21, 4, 17, 27, 1, 1),
(45, 33, 1, 8, 48, 1, 1, 1),
(46, 34, 7, 1, 1, 1, 1, 1),
(47, 34, 5, 7, 56, 6, 1, 1),
(48, 34, 22, 8, 19, 21, 1, 1),
(49, 35, 5, 1, 139, 24, 1, 8),
(50, 37, 17, 7, 107, 16, 1, 11),
(51, 37, 33, 7, 108, 9, 1, 11),
(52, 38, 31, 5, 1, 16, 1, 10),
(53, 38, 20, 5, 23, 5, 1, 1),
(54, 39, 2, 1, 139, 11, 1, 8),
(55, 40, 21, 4, 20, 18, 1, 1),
(56, 40, 3, 6, 46, 4, 1, 1),
(57, 40, 3, 4, 51, 3, 1, 1),
(58, 41, 24, 3, 62, 13, 1, 5),
(59, 42, 10, 2, 152, 20, 1, 10),
(60, 42, 3, 6, 138, 5, 1, 10),
(61, 42, 13, 4, 153, 6, 1, 10),
(62, 42, 10, 5, 154, 21, 1, 10),
(63, 43, 5, 1, 105, 26, 1, 11),
(64, 43, 19, 1, 109, 10, 1, 11),
(65, 44, 20, 7, 18, 3, 1, 1),
(66, 44, 22, 2, 19, 14, 1, 1),
(67, 44, 5, 6, 53, 11, 1, 1),
(68, 46, 31, 8, 148, 17, 1, 10),
(69, 46, 35, 5, 121, 18, 1, 10),
(70, 46, 31, 3, 149, 14, 1, 10),
(71, 46, 35, 5, 106, 20, 1, 10),
(72, 46, 31, 6, 150, 3, 1, 10),
(73, 46, 32, 8, 151, 3, 1, 10),
(74, 48, 17, 8, 106, 23, 1, 11),
(75, 48, 35, 5, 120, 1, 1, 11),
(76, 48, 13, 6, 110, 10, 1, 11),
(77, 49, 11, 5, 1, 19, 1, 9),
(78, 49, 19, 5, 120, 28, 1, 9),
(79, 50, 10, 6, 124, 27, 1, 2),
(80, 50, 20, 6, 23, 20, 1, 1),
(81, 52, 11, 1, 136, 25, 1, 9),
(82, 52, 10, 5, 5, 4, 1, 9),
(83, 52, 11, 1, 5, 30, 1, 8),
(84, 53, 17, 2, 72, 25, 1, 4),
(85, 53, 27, 8, 70, 26, 1, 4),
(86, 53, 15, 3, 147, 3, 1, 4),
(87, 54, 9, 7, 136, 2, 1, 9),
(88, 55, 15, 7, 128, 15, 1, 4),
(89, 55, 15, 1, 70, 18, 1, 4),
(90, 55, 17, 8, 76, 13, 1, 4),
(91, 56, 1, 3, 136, 19, 1, 1),
(92, 56, 13, 4, 71, 28, 1, 4),
(93, 57, 15, 3, 126, 26, 1, 4),
(94, 57, 32, 2, 126, 30, 1, 6),
(95, 57, 26, 1, 94, 4, 1, 3),
(96, 57, 13, 6, 1, 6, 1, 11),
(97, 57, 18, 7, 95, 29, 1, 3),
(98, 58, 7, 2, 1, 24, 1, 1),
(99, 58, 7, 8, 4, 25, 1, 1),
(100, 58, 20, 2, 18, 13, 1, 1),
(101, 58, 10, 6, 124, 28, 1, 2),
(102, 59, 7, 1, 4, 20, 1, 1),
(103, 59, 26, 6, 125, 29, 1, 3),
(104, 59, 19, 2, 125, 9, 1, 7),
(105, 59, 19, 3, 98, 7, 1, 7),
(106, 59, 18, 7, 162, 25, 1, 3),
(107, 63, 17, 8, 74, 14, 1, 4),
(108, 63, 17, 4, 73, 9, 1, 4),
(109, 65, 15, 6, 128, 26, 1, 4),
(110, 65, 27, 5, 72, 7, 1, 4),
(111, 65, 14, 7, 71, 5, 1, 4),
(112, 66, 35, 5, 69, 8, 1, 4),
(113, 66, 31, 8, 71, 18, 1, 4),
(114, 66, 27, 3, 76, 20, 1, 4),
(115, 66, 17, 8, 74, 2, 1, 4),
(116, 67, 14, 1, 151, 5, 1, 10),
(117, 67, 27, 6, 148, 12, 1, 10),
(118, 67, 10, 5, 152, 10, 1, 10),
(119, 67, 11, 8, 154, 7, 1, 10),
(120, 68, 14, 7, 149, 21, 1, 10),
(121, 68, 12, 5, 122, 14, 1, 10),
(122, 68, 31, 8, 106, 12, 1, 10),
(123, 68, 11, 3, 153, 1, 1, 10),
(124, 68, 12, 7, 150, 17, 1, 10),
(125, 69, 18, 3, 2, 18, 1, 10),
(126, 69, 12, 4, 1, 14, 1, 10),
(127, 69, 18, 1, 93, 21, 1, 3),
(128, 70, 10, 4, 111, 30, 1, 11),
(129, 70, 11, 4, 43, 22, 1, 11),
(130, 71, 11, 5, 2, 3, 1, 9),
(131, 71, 6, 1, 1, 7, 1, 9),
(132, 72, 12, 7, 143, 11, 1, 8),
(133, 72, 11, 4, 1, 8, 1, 8),
(134, 72, 8, 7, 1, 20, 1, 9),
(135, 72, 8, 5, 5, 24, 1, 1),
(136, 72, 3, 1, 5, 28, 1, 9),
(137, 72, 6, 1, 4, 12, 1, 8),
(138, 72, 3, 2, 1, 19, 1, 8),
(139, 73, 2, 7, 143, 28, 1, 8),
(140, 73, 13, 2, 142, 7, 1, 8),
(141, 73, 11, 5, 5, 6, 1, 8),
(142, 73, 34, 7, 5, 22, 1, 9),
(143, 73, 3, 6, 122, 2, 1, 8),
(144, 73, 8, 2, 49, 28, 1, 3),
(145, 74, 2, 7, 1, 26, 1, 8),
(146, 74, 10, 3, 142, 24, 1, 8),
(147, 74, 3, 2, 140, 12, 1, 8),
(148, 74, 13, 4, 5, 5, 1, 8),
(149, 74, 5, 4, 5, 15, 1, 9),
(150, 74, 7, 8, 122, 9, 1, 8),
(151, 75, 7, 1, 131, 14, 1, 3),
(152, 75, 10, 7, 114, 30, 1, 2),
(153, 75, 9, 2, 131, 3, 1, 5),
(154, 75, 10, 3, 131, 4, 1, 6),
(155, 75, 32, 4, 131, 25, 1, 7),
(156, 75, 13, 3, 7, 16, 1, 1),
(157, 75, 11, 1, 7, 29, 1, 4),
(158, 75, 16, 7, 7, 1, 1, 8),
(159, 75, 31, 6, 7, 30, 1, 9),
(160, 75, 20, 3, 7, 23, 1, 10),
(161, 75, 31, 4, 7, 20, 1, 11),
(162, 76, 9, 5, 126, 17, 1, 9),
(163, 76, 12, 3, 89, 12, 1, 3),
(164, 76, 15, 4, 166, 1, 1, 3),
(165, 76, 17, 7, 92, 27, 1, 3),
(166, 76, 31, 2, 156, 2, 1, 3),
(167, 76, 11, 5, 161, 25, 1, 3),
(168, 77, 9, 5, 2, 2, 1, 1),
(169, 77, 10, 4, 159, 11, 1, 3),
(170, 77, 10, 4, 132, 10, 1, 2),
(171, 77, 8, 1, 167, 2, 1, 3),
(172, 77, 9, 3, 160, 29, 1, 3),
(173, 78, 16, 7, 126, 23, 1, 2),
(174, 78, 9, 5, 1, 12, 1, 2),
(175, 78, 26, 4, 124, 13, 1, 3),
(176, 78, 19, 5, 124, 23, 1, 7),
(177, 78, 19, 8, 101, 20, 1, 7),
(178, 79, 26, 3, 133, 15, 1, 3),
(179, 79, 32, 2, 124, 21, 1, 7),
(180, 79, 19, 1, 95, 16, 1, 7),
(181, 79, 11, 3, 126, 6, 1, 2),
(182, 79, 19, 4, 103, 2, 1, 7),
(183, 79, 19, 6, 101, 18, 1, 7),
(184, 79, 35, 6, 112, 23, 1, 11),
(185, 80, 11, 1, 137, 3, 1, 2),
(186, 80, 26, 4, 137, 29, 1, 3),
(187, 80, 19, 1, 137, 13, 1, 7),
(188, 80, 19, 7, 104, 19, 1, 7),
(189, 80, 19, 3, 125, 21, 1, 7),
(190, 81, 26, 2, 137, 18, 1, 3),
(191, 81, 19, 8, 137, 6, 1, 7),
(192, 81, 26, 5, 93, 26, 1, 3),
(193, 81, 19, 6, 97, 13, 1, 7),
(194, 81, 20, 7, 22, 8, 1, 1),
(195, 81, 19, 5, 104, 13, 1, 7),
(196, 82, 32, 2, 124, 10, 1, 6),
(197, 82, 16, 6, 124, 8, 1, 5),
(198, 82, 21, 6, 23, 15, 1, 1),
(199, 82, 9, 7, 5, 18, 1, 1),
(200, 92, 10, 4, 86, 21, 1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `kelas_id` int(11) NOT NULL,
  `kode_kelas` varchar(20) NOT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `prodi_id` int(11) NOT NULL,
  `jumlah_mhs` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`kelas_id`, `kode_kelas`, `nama_kelas`, `prodi_id`, `jumlah_mhs`) VALUES
(1, 'IK22-SE', 'Ilmu Komputer 22-Software Enginering', 1, 50),
(2, 'IK22-SC', 'Ilmu Komputer 22-Sistem Cerdas', 1, 50),
(3, 'IK22-A', 'Ilmu Komputer 22 A', 1, 40),
(4, 'IK22-B', 'Ilmu Komputer 22 B', 1, 40),
(5, 'IK22-IOT', 'Ilmu Komputer 22-Internet Of Things', 1, 40),
(6, 'AR24', 'Arsitektur 24', 8, 10),
(7, 'IK24-A', 'Ilmu Komputer 24 A', 1, 40),
(8, 'IK24-B', 'Ilmu Komputer 24 B', 1, 40),
(9, 'IK24-C', 'Ilmu Komputer 24 C', 1, 40),
(10, 'SI24-A', 'Sistem Informasi 24 A', 2, 40),
(11, 'SI24-B', 'Sistem Informasi 24 B', 2, 40),
(12, 'TS24-AB', 'Teknik Sipil 24-AB', 9, 40),
(13, 'TEM24', 'Teknik Sistem Energi 24', 11, 40),
(14, 'TM23', 'Teknik metalurgi 23', 10, 40),
(15, 'TP24', 'Teknologi Pangan 24', 4, 40),
(16, 'BT24', 'Bioteknologi 24', 5, 40),
(17, 'TP23', 'Teknologi Pangan 23', 4, 40),
(18, 'MA22-A', 'Matematika 22 A', 3, 40),
(19, 'SD23', 'Sains Data 23', 7, 40),
(20, 'IK23-A', 'Ilmu Komputer 23 A', 1, 40),
(21, 'IK23-B', 'Ilmu Komputer 23 B', 1, 40),
(22, 'IK23-C', 'Ilmu Komputer 23 C', 1, 40),
(23, 'SI23-A', 'Sistem Informasi 23 A', 2, 30),
(24, 'SI23-B', 'Sistem Informasi 23 B', 2, 40),
(25, 'SI23-C', 'Sistem Informasi 23 C', 2, 40),
(26, 'MA23-A', 'Matematika 23 A', 3, 40),
(27, 'TPME24', 'Teknologi Pangan, Sistem Energi 24', 11, 30),
(28, 'SI22-CS', 'Sistem Informasi 22- Cyber Security', 2, 40),
(29, 'SI22-Inter', 'Sistem Informasi 22- Interpress', 2, 30),
(30, 'SI22-BD', 'Sistem Informasi 22-Bisnis Digital', 2, 40),
(31, 'TM24', 'Teknik metalurgi 24', 10, 40),
(32, 'SA24', 'Sains aktuaria 24', 6, 40),
(33, 'SI22-A', 'Sistem Informasi 22 A', 2, 40),
(34, 'SI22-B', 'Sistem Informasi 22 B', 2, 40),
(35, 'TE23', 'Teknik Sistem Energi 23', 11, 40);

-- --------------------------------------------------------

--
-- Struktur dari tabel `matakuliah`
--

CREATE TABLE `matakuliah` (
  `matkul_id` int(11) NOT NULL,
  `nama_matkul` varchar(100) NOT NULL,
  `kode_matkul` varchar(20) NOT NULL,
  `sks` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `prodi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `matakuliah`
--

INSERT INTO `matakuliah` (`matkul_id`, `nama_matkul`, `kode_matkul`, `sks`, `semester`, `prodi_id`) VALUES
(1, 'PENGANTAR TEKNOLOGI INFORMASI', '22A0111073', 3, 1, 1),
(2, 'KALKULUS DASAR 1', '22A0111063', 3, 1, 1),
(4, 'PENGANTAR PEMROGRAMAN', '22A0111053', 3, 1, 1),
(5, 'WAWASAN CINTA IPTEK DAN IMTAQ', '22A0111042', 2, 1, 1),
(6, 'BAHASA INDONESIA', '22A0111032', 2, 1, 1),
(7, 'PANCASILA', '22A0111022', 2, 1, 1),
(8, 'AGAMA ISLAM', '22A0111012', 2, 1, 1),
(17, 'SISTEM BASIS DATA', '22A0112053', 3, 3, 1),
(18, 'SISTEM OPERASI', '22A0112063', 3, 3, 1),
(19, 'JARINGAN KOMPUTER', '22A0112073', 3, 3, 1),
(20, ' PEMROGRAMAN BERORIENTASI OBJEK', '22A0112043', 3, 3, 1),
(21, 'INTERAKSI MANUSIA DAN KOMPUTER', '22A0112013', 3, 3, 1),
(22, 'ALJABAR LINEAR', '22A0112023', 3, 3, 1),
(23, ' TECHNOPRENEURSHIP', '22A0112032', 2, 3, 1),
(42, 'VISI KOMPUTER', '22A0113123', 3, 5, 1),
(43, 'PENGANTAR SISTEM DIGITAL', '22A0111163', 3, 1, 1),
(46, 'PEMBELAJARAN MESIN', '22A0113013', 3, 5, 1),
(47, 'Metodologi Penelitian', '22A0113033', 3, 5, 1),
(48, 'TEKNOLOGI AR/VR', '22A0113163', 3, 5, 1),
(49, 'ETIKA PROFESI', '22A0113042', 2, 5, 1),
(50, 'PEMROGRAMAN MOBILE', '22A0113083', 3, 5, 1),
(51, 'BIG DATA', '22A0113073', 3, 5, 1),
(52, 'PROYEK TEKNOLOGI CERDAS', '22A0113064', 4, 5, 1),
(53, '  IOT DAN CLOUD COMPUTING (IOT)', '22A0113053', 3, 5, 1),
(55, 'PEMROSESAN BAHASA ALAMI', '22A0113023', 3, 5, 1),
(56, 'SENSOR', '22A0113203', 3, 5, 1),
(57, 'KEAMANAN SISTEM INFORMASI', '22B0213073', 3, 5, 2),
(58, 'BISNIS DIGITAL', '22B0213063', 3, 5, 2),
(59, 'COMMUNICATION SKILL', '22B0213033', 3, 5, 2),
(60, 'AUDIT SISTEM INFORMASI', '22B0213083', 3, 5, 2),
(61, 'TEKNOLOGI DAN INFRASTRUKTUR BISNIS DIGITAL ', '22B0213103', 3, 5, 2),
(62, 'KRIPTOGRAFI', '22B0213113', 3, 5, 2),
(65, 'PROYEK SISTEM INFORMASI', '22B0213023', 3, 5, 2),
(66, 'MANAJEMEN PROYEK SISTEM INFORMASI', '22B0213013', 3, 5, 2),
(67, 'SOFTWARE TESTING AND QUALITY ASSURANCE', '22B0213043', 3, 5, 2),
(68, 'ENTERPRISE INFORMATION SYSTEM', '22B0213093', 3, 5, 2),
(69, 'FISIOLOGI DAN TEKNOLOGI PASCAPANEN', '23A0412042', 2, 3, 4),
(70, 'KIMIA PANGAN 1 ', '23A0412013', 3, 3, 4),
(71, 'APLIKASI TEKNIK LABORATORIUM ', '23A0412023', 3, 3, 4),
(72, 'REKAYASA PROSES PANGAN ', '23A0412032', 2, 3, 4),
(73, 'ETIKA PROFESI', '23A0412092', 2, 3, 4),
(74, 'MANAJEMEN INDUSTRI PANGAN ', '23A0412083', 3, 3, 4),
(75, 'PENGETAHUAN BAHAN INDUSTRI PANGAN', '23A0412073', 3, 3, 4),
(76, 'TEKNOLOGI PENGOLAHAN BUAH & SAYUR', '23A0412062', 2, 3, 4),
(77, 'MIKROBIOLOGI PANGAN', '23A0412053', 3, 3, 4),
(78, 'METODE NUMERIK', '22B0213383', 3, 3, 2),
(79, 'TECHNOPRENEUSHIP', '22B0212282', 2, 3, 2),
(81, 'SUPPLY CHAIN MANAGEMENT', '22B0212272', 3, 3, 2),
(82, 'TRANSFORMASI DIGITAL', '22B0212253', 3, 3, 2),
(83, 'RISET TEKNOLOGI INFORMASI', '22B0212212', 2, 3, 2),
(84, 'ANALISIS DAN PERANCANGAN SISTEM', '22B0212233', 3, 3, 2),
(85, 'JARINGAN KOMPUTER', '22B0212223', 3, 3, 2),
(86, 'SISTEM BASIS DATA', '22B0212243', 3, 3, 2),
(89, 'MATEMATIKA BISNIS & TEKNOLOGI', '22B0112133', 3, 3, 3),
(90, 'ANALISIS SUKU BUNGA BERBASIS WEB', '22B0112143', 3, 3, 3),
(91, 'TECHNOPRENEURSHIP', '22B0112063', 2, 3, 3),
(92, 'PERSAMAAN DIFFERENSIAL BIASA', '22B0112053', 3, 3, 3),
(93, 'KALKULUS LANJUT', '22B0112043', 3, 3, 3),
(94, 'MATEMATIKA DISKRIT', '22B0112033', 3, 3, 3),
(95, 'TEORI PELUANG', '22B0112023', 3, 3, 3),
(96, 'ALJABAR LINEAR', '22B0112013', 3, 3, 3),
(97, 'TEORI PELUANG', '23B0612023', 3, 3, 7),
(98, 'PENGANTAR SISTEM BASIS DATA', '23B0612033', 3, 3, 7),
(99, 'STATISTIKA NONPARAMETRIK', '23B0612043', 3, 3, 7),
(100, 'SISTEM OPERASI', '23B0612053', 3, 3, 7),
(101, 'METODE VISUALISASI DATA', '23B0612063', 3, 3, 7),
(102, 'PENGANTAR MACHINE LEARNING', '23B0612073', 3, 3, 7),
(103, 'ANALISIS EKSPLORASI DATA', '23B0612083', 3, 3, 7),
(104, 'ALJABAR MATRIKS', '23B0612013', 3, 3, 7),
(105, 'SISTEM KENDALI', '23A0712083', 3, 3, 11),
(106, 'TERMODINAMIKA', '23A0712072', 2, 3, 11),
(107, 'KONVERSI ENERGI', '23A0712062', 2, 3, 11),
(108, 'DASAR SISTEM TENAGA LISTRIK', '23A0712053', 2, 3, 11),
(109, 'ELEKTRONIKA', '23A0712043', 3, 3, 11),
(110, 'MATERIAL ENERGI', '23A0712032', 2, 3, 11),
(111, 'RANGKAIAN ELEKTRIK 2', '23A0712023', 3, 3, 11),
(112, 'MATEMATIKA TEKNIK', '23A0712013', 3, 3, 11),
(114, 'PANCASILA', '23A0311062', 2, 1, 10),
(115, 'AGAMA KRISTEN PROTESTAN', '22U0111022', 2, 1, 10),
(116, 'AGAMA KATOLIK', '22U0111032', 2, 1, 10),
(117, 'AGAMA HINDU', '22U0111042', 2, 1, 10),
(118, 'AGAMA BUDHA', '22U0311052', 2, 1, 10),
(119, 'WAWASAN CINTA IMTAQ DAN IPTEK', '22U0111082', 2, 1, 10),
(120, 'FISIKA DASAR I', '23A0811093', 3, 1, 10),
(121, 'KIMIA DASAR', '23A0811103', 3, 1, 10),
(122, 'GAMBAR TEKNIK & CAD', '23A0811112', 2, 1, 10),
(123, 'AGAMA ISLAM', '22U0211012', 2, 1, 10),
(124, 'PENGANTAR TEKNOLOGI INFORMASI', '23A0811033', 3, 1, 10),
(125, 'PENGANTAR PEMROGRAMAN', '23A0811013', 3, 1, 10),
(126, 'KALKULUS DASAR 1', '23A0811023', 3, 1, 10),
(127, 'BAHASA INDONESIA', '23A0311072', 2, 1, 10),
(128, 'BIOLOGI DASAR', '24B0911033', 3, 1, 5),
(130, 'BAHASA INDONESIA', '22U0211072', 2, 1, 5),
(131, 'PANCASILA', '22U0211062', 2, 1, 5),
(132, 'WAWASAN CINTA IPTEK DAN IMTAQ', '22U0211082', 2, 1, 5),
(133, 'PENGANTAR TEKNOLOGI INFORMASI', '24B0911013', 3, 1, 5),
(134, 'PENGANTAR DAN ETIKA BIOTEKNOLOGI', '24B0911043', 3, 1, 5),
(135, 'SAINS TERPADU', '22B0211045', 3, 1, 5),
(136, 'STATIKA', '24A1011043', 3, 1, 9),
(137, 'KALKULUS DASAR 1', '24A1011023', 3, 1, 9),
(138, 'FISIKA DASAR I', '24A1011033', 3, 1, 8),
(139, 'MENGGAMBAR ARSITEKTUR', '24A1111033', 3, 1, 8),
(140, 'BAHASA INDONESIA', '23A0211072', 2, 1, 8),
(141, 'BAHAN BANGUNAN (SENI KETUKANGAN)', '24A1111022', 2, 1, 8),
(142, 'TEKNIK KOMUNIKASI & PRESENTASI', '24A1111042', 3, 1, 8),
(143, 'PENGANTAR ARSITEKTUR', '24A1111043', 2, 1, 8),
(147, 'PENG. TEKNOLOGI PANGAN', 'PTP', 3, 1, 4),
(148, ' PERPINDAHAN PANAS DAN MASSA', '23A0812212', 2, 3, 10),
(149, ' MINERALOGI DAN KRISTALOGRAFI', '23A0812193', 3, 3, 10),
(150, ' PENGOLAHAN MINERAL', '23A0812183', 3, 3, 10),
(151, 'TRANSFORMASI FASA', '23A0812173', 3, 3, 10),
(152, 'MEKANIKA KEKUATAN MATERIAL', '23A0812223', 3, 3, 10),
(153, 'PENGETAHUAN LINGKUNGAN DAN K3', '23A0812202', 2, 3, 10),
(154, 'METALURGI FISIK', '23A0812153', 3, 3, 10),
(155, 'ETIKA PROFESI DAN PROFESIONAL', '22B0113042', 2, 5, 3),
(156, 'FUNGSI KOMPLEKS', '22B0113023', 3, 5, 3),
(158, 'CAPSTONE PROJECT', '22B0113063', 3, 5, 3),
(159, 'METODOLOGI PENELITIAN', '22B0113052', 2, 5, 3),
(160, 'STATISTIKA NONPARAMETRIK', '22B0113083', 2, 5, 3),
(161, 'SISTEM DINAMIK', '22B0113073', 3, 5, 3),
(162, 'PENGOLAHAN CITRA DIGITAL', '22B0113103', 3, 5, 3),
(163, 'STRUKTUR ALJABAR II', '22B0113113', 3, 5, 3),
(164, 'MACHINE LEARNING', '22B0113093', 3, 5, 3),
(165, 'TEKNIK PERAMALAN', '22B0113122', 2, 5, 3),
(166, 'PROGRAM LINEAR', '22B0113013', 3, 5, 3),
(167, 'STATISTIKA MATEMATIKA', '22B0113033', 3, 5, 3),
(168, 'KALKULUS DASAR I', '22B0211013', 3, 1, 3),
(169, 'PENGANTAR SAINS AKTUARIA', '24B0511043', 3, 1, 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `prodi`
--

CREATE TABLE `prodi` (
  `prodi_id` int(11) NOT NULL,
  `kode_prodi` varchar(20) NOT NULL,
  `nama_prodi` varchar(100) NOT NULL,
  `jurusan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `prodi`
--

INSERT INTO `prodi` (`prodi_id`, `kode_prodi`, `nama_prodi`, `jurusan`) VALUES
(1, 'IK', 'Ilmu Komputer', 'Teknologi Produksi dan Industri'),
(2, 'SI', 'Sistem Informasi', 'Sains\r\n'),
(3, 'MA', 'Matematika', 'Sains'),
(4, 'TP', 'Teknologi Pangan ', 'Teknologi Produksi dan Industri'),
(5, 'BT', 'Bioteknologi', 'Sains'),
(6, 'SA', 'Sains aktuaria', 'Sains'),
(7, 'SD', 'Sains Data', 'Sains'),
(8, 'AR', 'Arsitektur', 'Teknologi Produksi dan Industri'),
(9, 'TS', 'Teknik Sipil', 'Teknologi Produksi dan Industri'),
(10, 'TM', 'Teknik Metalurgi', 'Teknologi Produksi dan Industri'),
(11, 'TE', 'Teknik Sistem Energi', 'Teknologi Produksi dan Industri');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangan`
--

CREATE TABLE `ruangan` (
  `ruangan_id` int(11) NOT NULL,
  `kode_ruangan` varchar(20) NOT NULL,
  `nama_ruangan` varchar(100) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `lokasi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ruangan`
--

INSERT INTO `ruangan` (`ruangan_id`, `kode_ruangan`, `nama_ruangan`, `kapasitas`, `lokasi`) VALUES
(1, '101', 'R. MACCA 101', 40, 'Kampus 2 Gedung Pemuda							'),
(2, '102', 'R. MAKKAWARU 102', 50, 'Kampus 2 Gedung Pemuda							'),
(3, '103', 'R. MARESO 103 ', 50, 'Kampus 2 Gedung Pemuda							'),
(4, '104', 'R. MAGETTENG 104 ', 50, 'Kampus 2 Gedung Pemuda							'),
(5, '202', 'R. MALEBBI 202', 70, 'Kampus 2 Gedung Pemuda							'),
(6, '203', 'R. MATEPPE 203', 70, 'Kampus 2 Gedung Pemuda							'),
(7, '205', 'Ruang Kelas 205', 70, 'Kampus 2 Gedung Pemuda							'),
(8, '206', 'R. MAMASE 206', 70, 'Kampus 2 Gedung Pemuda							');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_akademik`
--

CREATE TABLE `tahun_akademik` (
  `tahun_akademik_id` int(11) NOT NULL,
  `tahun_akademik_nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tahun_akademik`
--

INSERT INTO `tahun_akademik` (`tahun_akademik_id`, `tahun_akademik_nama`) VALUES
(1, '2024/2025 Ganjil');

-- --------------------------------------------------------

--
-- Struktur dari tabel `waktu`
--

CREATE TABLE `waktu` (
  `waktu_id` int(11) NOT NULL,
  `hari` varchar(20) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `waktu`
--

INSERT INTO `waktu` (`waktu_id`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
(1, 'Senin', '07:30:00', '09:00:00'),
(2, 'Senin', '09:05:00', '10:35:00'),
(3, 'Senin', '10:40:00', '12:10:00'),
(4, 'Senin', '13:30:00', '15:00:00'),
(5, 'Senin', '15:05:00', '16:35:00'),
(6, 'Senin', '16:40:00', '18:10:00'),
(7, 'Selasa', '07:30:00', '09:00:00'),
(8, 'Selasa', '09:05:00', '10:35:00'),
(9, 'Selasa', '10:40:00', '12:10:00'),
(10, 'Selasa', '13:30:00', '15:00:00'),
(11, 'Selasa', '15:05:00', '16:35:00'),
(12, 'Selasa', '16:40:00', '18:10:00'),
(13, 'Rabu', '07:30:00', '09:00:00'),
(14, 'Rabu', '09:05:00', '10:35:00'),
(15, 'Rabu', '10:40:00', '12:10:00'),
(16, 'Rabu', '13:30:00', '15:00:00'),
(17, 'Rabu', '15:05:00', '16:35:00'),
(18, 'Rabu', '16:40:00', '18:10:00'),
(19, 'Kamis', '07:30:00', '09:00:00'),
(20, 'Kamis', '09:05:00', '10:35:00'),
(21, 'Kamis', '10:40:00', '12:10:00'),
(22, 'Kamis', '13:30:00', '15:00:00'),
(23, 'Kamis', '15:05:00', '16:35:00'),
(24, 'Kamis', '16:40:00', '18:10:00'),
(25, 'Jumat', '07:30:00', '09:00:00'),
(26, 'Jumat', '09:05:00', '10:35:00'),
(27, 'Jumat', '10:40:00', '12:10:00'),
(28, 'Jumat', '13:30:00', '15:00:00'),
(29, 'Jumat', '15:05:00', '16:35:00'),
(30, 'Jumat', '16:40:00', '18:10:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`dosen_id`),
  ADD UNIQUE KEY `NIP` (`nip`);

--
-- Indeks untuk tabel `dosen_mk`
--
ALTER TABLE `dosen_mk`
  ADD PRIMARY KEY (`dosen_mk_id`),
  ADD KEY `tahun_akademik_id` (`tahun_akademik_id`),
  ADD KEY `dosen_id` (`dosen_id`),
  ADD KEY `matkul_id` (`matkul_id`),
  ADD KEY `prodi_id` (`prodi_id`),
  ADD KEY `fk_kelas` (`kelas_id`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tahun_akademik` (`tahun_akademik_id`);

--
-- Indeks untuk tabel `jadwal2`
--
ALTER TABLE `jadwal2`
  ADD PRIMARY KEY (`jadwal_id`),
  ADD UNIQUE KEY `unique_ruangan_waktu` (`ruangan_id`,`waktu_id`),
  ADD KEY `dosen_id` (`dosen_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `matkul_id` (`matkul_id`),
  ADD KEY `waktu_id` (`waktu_id`),
  ADD KEY `tahun_akademik_id` (`tahun_akademik_id`),
  ADD KEY `fk_prodi_id` (`prodi_id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kelas_id`),
  ADD UNIQUE KEY `kode_kelas` (`kode_kelas`),
  ADD KEY `prodi_id` (`prodi_id`);

--
-- Indeks untuk tabel `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`matkul_id`),
  ADD UNIQUE KEY `kode_matkul` (`kode_matkul`),
  ADD KEY `prodi_id` (`prodi_id`);

--
-- Indeks untuk tabel `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`prodi_id`),
  ADD UNIQUE KEY `kode_prodi` (`kode_prodi`);

--
-- Indeks untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`ruangan_id`),
  ADD UNIQUE KEY `kode_ruangan` (`kode_ruangan`);

--
-- Indeks untuk tabel `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  ADD PRIMARY KEY (`tahun_akademik_id`);

--
-- Indeks untuk tabel `waktu`
--
ALTER TABLE `waktu`
  ADD PRIMARY KEY (`waktu_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `dosen`
--
ALTER TABLE `dosen`
  MODIFY `dosen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT untuk tabel `dosen_mk`
--
ALTER TABLE `dosen_mk`
  MODIFY `dosen_mk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=314;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT untuk tabel `jadwal2`
--
ALTER TABLE `jadwal2`
  MODIFY `jadwal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `kelas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `matakuliah`
--
ALTER TABLE `matakuliah`
  MODIFY `matkul_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT untuk tabel `prodi`
--
ALTER TABLE `prodi`
  MODIFY `prodi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `ruangan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `tahun_akademik`
--
ALTER TABLE `tahun_akademik`
  MODIFY `tahun_akademik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `waktu`
--
ALTER TABLE `waktu`
  MODIFY `waktu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `dosen_mk`
--
ALTER TABLE `dosen_mk`
  ADD CONSTRAINT `dosen_mk_ibfk_1` FOREIGN KEY (`tahun_akademik_id`) REFERENCES `tahun_akademik` (`tahun_akademik_id`),
  ADD CONSTRAINT `dosen_mk_ibfk_2` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`dosen_id`),
  ADD CONSTRAINT `dosen_mk_ibfk_3` FOREIGN KEY (`matkul_id`) REFERENCES `matakuliah` (`matkul_id`),
  ADD CONSTRAINT `dosen_mk_ibfk_4` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`prodi_id`),
  ADD CONSTRAINT `fk_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`);

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `fk_tahun_akademik` FOREIGN KEY (`tahun_akademik_id`) REFERENCES `tahun_akademik` (`tahun_akademik_id`);

--
-- Ketidakleluasaan untuk tabel `jadwal2`
--
ALTER TABLE `jadwal2`
  ADD CONSTRAINT `fk_prodi_id` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`prodi_id`),
  ADD CONSTRAINT `jadwal2_ibfk_1` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`dosen_id`),
  ADD CONSTRAINT `jadwal2_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`kelas_id`),
  ADD CONSTRAINT `jadwal2_ibfk_3` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`ruangan_id`),
  ADD CONSTRAINT `jadwal2_ibfk_4` FOREIGN KEY (`matkul_id`) REFERENCES `matakuliah` (`matkul_id`),
  ADD CONSTRAINT `jadwal2_ibfk_5` FOREIGN KEY (`waktu_id`) REFERENCES `waktu` (`waktu_id`),
  ADD CONSTRAINT `jadwal2_ibfk_6` FOREIGN KEY (`tahun_akademik_id`) REFERENCES `tahun_akademik` (`tahun_akademik_id`);

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`prodi_id`);

--
-- Ketidakleluasaan untuk tabel `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD CONSTRAINT `matakuliah_ibfk_1` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`prodi_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
