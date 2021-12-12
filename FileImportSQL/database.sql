-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 12, 2021 lúc 05:17 PM
-- Phiên bản máy phục vụ: 10.4.19-MariaDB
-- Phiên bản PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `database`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(255) NOT NULL,
  `admin_name` varchar(128) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `admin_phone` varchar(20) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `admin_password` varchar(128) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `authority` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_phone`, `admin_password`, `authority`) VALUES
(1, 'Phong', '0123456789', '25f9e794323b453885f5181f1b624d0b', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brand`
--

CREATE TABLE `brand` (
  `brand_id` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `brand_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Đang đổ dữ liệu cho bảng `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`) VALUES
('ACE', 'Acer'),
('MSI', 'MSI'),
('GIG', 'Gigabyte'),
('LEN', 'Lenovo'),
('LOG', 'Logitech'),
('HPC', 'HP'),
('CLM', 'Cooler Master'),
('INT', 'Intel'),
('AMD', 'AMD'),
('ASU', 'Asus');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `user_id` int(128) NOT NULL,
  `product_id` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `category_id` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `category_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
('CPU', 'Vi xử lý'),
('VGA', 'Card đồ họa'),
('CAS', 'Vỏ case'),
('PSU', 'Nguồn'),
('RAM', 'Ram'),
('MOR', 'Màn hình'),
('HDD', 'HDD'),
('SSD', 'SSD'),
('FAN', 'Quạt'),
('MBO', 'Bo mạch chủ'),
('MOU', 'Chuột'),
('KEY', 'Bàn phím'),
('PHO', 'Tai nghe'),
('SPK', 'Loa'),
('COL', 'Tản nhiệt'),
('LAP', 'Laptop');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `transaction_id` int(255) NOT NULL,
  `order_id` int(255) NOT NULL,
  `product_id` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `amount` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `data` text COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `product_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `brand_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(15) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `discount` int(11) NOT NULL,
  `image_link` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_first_available` int(11) NOT NULL DEFAULT 0,
  `saledate` date NOT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `sold` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`product_id`, `category_id`, `product_name`, `brand_id`, `price`, `description`, `discount`, `image_link`, `date_first_available`, `saledate`, `amount`, `sold`) VALUES
('LAPASUTUFF15', 'LAP', 'Asus TUF F15', 'ASUS', 34990000, 'Laptop', 10, 'img/asus-tuf-f15.png', 2021, '2021-11-07', 120, 0),
('LAPACETRITON300', 'LAP', 'Acer Predator Triton 300', 'ACER', 54990000, 'Laptop', 0, 'img/acer-predator-triton-300.png', 2021, '2021-11-07', 200, 0),
('LAPLENYOGA9', 'LAP', 'Lenovo Yoga 9', 'LENOVO', 39990000, 'Laptop', 20, 'img/lenovo-yoga-9.jpg', 2021, '2021-11-07', 128, 2),
('LAPMSIRAIDERGE66', 'LAP', 'MSI Raider GE66', 'MSI', 34990000, 'Laptop', 0, 'img/msi-raider-ge66.png', 2021, '2021-11-07', 200, 0),
('MBOMSIMEGZ590', 'MB', 'MSI MEG Z590 GODLIKE', 'MSI', 20990000, 'Bo mạch chủ', 5, 'img/msi-meg-z590-godlike.jpg', 2021, '2021-11-07', 350, 0),
('1807469', 'LAP', 'Laptop Acer Nitro 5 AN515-52-51LW', 'ACER', 24040000, '', 0, 'img/LAPTOP/ACER/1807469/1.png', 2021, '2021-12-11', 10, 0),
('1810659', 'LAP', 'Laptop Acer Spin 3 SP314-51-51LE', 'ACER', 16400000, '', 0, 'img/LAPTOP/ACER/1810659/1.png', 2021, '2021-12-11', 10, 0),
('19010019', 'LAP', 'Laptop Acer Aspire 5 A515-53G-5788', 'ACER', 15490000, '', 0, 'img/LAPTOP/ACER/19010019/1.png', 2021, '2021-12-11', 10, 0),
('19030302', 'LAP', 'Laptop Acer Swift 3 SF313-51-56UW', 'ACER', 26490000, '', 10, 'img/LAPTOP/ACER/19030302/1.png', 2021, '2021-12-11', 10, 0),
('201000019', 'LAP', 'Laptop ACER Aspire 7 A715-41G-R150 A715-41G-R150', 'ACER', 21490000, '', 0, 'img/LAPTOP/ACER/201000019/1.png', 2021, '2021-12-11', 10, 0),
('201100388', 'LAP', 'Laptop ACER Swift 3 SF314-510G-5742 NX.A10SV.003', 'ACER', 27990000, '', 0, 'img/LAPTOP/ACER/201100388/1.png', 2021, '2021-12-11', 10, 0),
('210101708', 'LAP', 'Laptop ACER Aspire 3 A315-57G-524Z NX.HZRSV.009', 'ACER', 16990000, '', 0, 'img/LAPTOP/ACER/210101708/1.png', 2021, '2021-12-11', 10, 0),
('210400387', 'LAP', 'Laptop ACER Nitro 5 AN515-56-79U2', 'ACER', 29290000, '', 0, 'img/LAPTOP/ACER/210400387/1.png', 2021, '2021-12-11', 10, 0),
('210400696', 'LAP', 'Laptop ACER Nitro 5 AN515-45-R9SC', 'ACER', 39990000, '', 0, 'img/LAPTOP/ACER/210400696/1.png', 2021, '2021-12-11', 10, 0),
('210701137', 'LAP', 'Laptop ACER Nitro 5 AN515-57-77KU NH.QDGSV.001', 'ACER', 38990000, '', 0, 'img/LAPTOP/ACER/210701137/1.png', 2021, '2021-12-11', 10, 0),
('210901841', 'LAP', 'Laptop ACER Nitro 5 Eagle AN515-57-54MV NH.QENSV.003', 'ACER', 26490000, '', 0, 'img/LAPTOP/ACER/210901841/1.png', 2021, '2021-12-11', 10, 0),
('211000000', 'LAP', 'Laptop ACER Nitro 5 Eagle AN515-57-720A NH.QEQSV.004', 'ACER', 30490000, '', 0, 'img/LAPTOP/ACER/211000000/1.png', 2021, '2021-12-11', 10, 0),
('211001891', 'LAP', 'Laptop ACER Predator Helios 300 PH315-54-74RU NH.QC1SV.002', 'ACER', 45990000, '', 5, 'img/LAPTOP/ACER/211001891/1.png', 2021, '2021-12-11', 10, 0),
('211006748', 'LAP', 'Laptop ACER TravelMate P2 TMP214-53-51CU NX.VPNSV.01S', 'ACER', 24990000, '', 10, 'img/LAPTOP/ACER/211006748/1.png', 2021, '2021-12-11', 10, 0),
('211006749', 'LAP', 'Laptop ACER TravelMate P2 TMP214-53-5571 NX.VPNSV.01V', 'ACER', 21990000, '', 0, 'img/LAPTOP/ACER/211006749/1.png', 2021, '2021-12-11', 10, 0),
('211012728', 'LAP', 'Laptop ACER Swift 3 SF314-43-R4X3 NX.AB1SV.004', 'ACER', 20990000, '', 20, 'img/LAPTOP/ACER/211012728/1.png', 2021, '2021-12-11', 10, 0),
('211013133', 'LAP', 'Laptop ACER Gaming Nitro 5 AN515-45-R86D NH.QBCSV.005', 'ACER', 33990000, '', 0, 'img/LAPTOP/ACER/211013133/1.png', 2021, '2021-12-11', 10, 0),
('211101852', 'LAP', 'Laptop ACER Aspire 3 A315-58G-50S4 NX.ADUSV.001', 'ACER', 18990000, '', 15, 'img/LAPTOP/ACER/211101852/1.png', 2021, '2021-12-11', 10, 0),
('211101853', 'LAP', 'Laptop ACER Swift 3 SF314-511-55QE NX.ABNSV.003', 'ACER', 22990000, '', 0, 'img/LAPTOP/ACER/211101853/1.png', 2021, '2021-12-11', 10, 0),
('211104709', 'LAP', 'Laptop ACER Aspire 7 A715-42G-R05G NH.QAYSV.007', 'ACER', 21990000, '', 0, 'img/LAPTOP/ACER/211104709/1.png', 2021, '2021-12-11', 10, 0),
('211104710', 'LAP', 'Laptop ACER Aspire 7 A715-42G-R4XX NH.QAYSV.008', 'ACER', 19990000, '', 10, 'img/LAPTOP/ACER/211104710/1.png', 2021, '2021-12-11', 10, 0),
('211104711', 'LAP', 'Laptop ACER Nitro 5 AN515-57-71VV NH.QENSV.005', 'ACER', 28990000, '', 20, 'img/LAPTOP/ACER/211104711/1.png', 2021, '2021-12-11', 10, 0),
('1808314', 'LAP', 'Laptop Apple Macbook Pro 2018 13.3\" MR9U2', 'APPLE', 44390000, '', 0, 'img/LAPTOP/APPLE/1808314/1.png', 2021, '2021-12-11', 10, 0),
('1808315', 'LAP', 'Laptop Apple MacBook Pro 2018 13.3inch MR9R2', 'APPLE', 49890000, '', 0, 'img/LAPTOP/APPLE/1808315/1.png', 2021, '2021-12-11', 10, 0),
('201201615', 'LAP', 'Laptop APPLE MacBook Air 2020 MGN93SA/A', 'APPLE', 28990000, '', 0, 'img/LAPTOP/APPLE/201201615/1.png', 2021, '2021-12-11', 10, 0),
('201201617', 'LAP', 'Laptop APPLE MacBook Air 2020 MGN63SA/A', 'APPLE', 28990000, '', 0, 'img/LAPTOP/APPLE/201201617/1.png', 2021, '2021-12-11', 10, 0),
('201201622', 'LAP', 'Laptop APPLE MacBook Pro 2020 MYD82SA/A', 'APPLE', 34990000, '', 20, 'img/LAPTOP/APPLE/201201622/1.png', 2021, '2021-12-11', 10, 0),
('201201624', 'LAP', 'Laptop APPLE MacBook Pro 2020 MYD92SA/A ', 'APPLE', 39990000, '', 0, 'img/LAPTOP/APPLE/201201624/1.png', 2021, '2021-12-11', 10, 0),
('210400892', 'LAP', 'Laptop APPLE MacBook Air 2020 13.3\" Z127000DE', 'APPLE', 33990000, '', 5, 'img/LAPTOP/APPLE/210400892/1.png', 2021, '2021-12-11', 10, 0),
('210400893', 'LAP', 'Laptop APPLE MacBook Air 2020 Z12A0004Z', 'APPLE', 33990000, '', 0, 'img/LAPTOP/APPLE/210400893/1.png', 2021, '2021-12-11', 10, 0),
('210400894', 'LAP', 'Laptop APPLE MacBook Air 2020 Z124000DE', 'APPLE', 33990000, '', 10, 'img/LAPTOP/APPLE/210400894/1.png', 2021, '2021-12-11', 10, 0),
('210401192', 'LAP', 'Laptop APPLE MacBook Pro 2020 Z11D000E5', 'APPLE', 41990000, '', 0, 'img/LAPTOP/APPLE/210401192/1.png', 2021, '2021-12-11', 10, 0),
('210401197', 'LAP', 'Laptop APPLE MacBook Pro 2020 Z11C000CH', 'APPLE', 43690000, '', 0, 'img/LAPTOP/APPLE/210401197/1.png', 2021, '2021-12-11', 10, 0),
('210401198', 'LAP', 'Laptop APPLE MacBook Pro 2020 Z11F000CF', 'APPLE', 46990000, '', 5, 'img/LAPTOP/APPLE/210401198/1.png', 2021, '2021-12-11', 10, 0),
('211108000', 'LAP', 'Laptop APPLE MacBook Pro 2020 Z11D000E7', 'APPLE', 46990000, '', 0, 'img/LAPTOP/APPLE/211108000/1.png', 2021, '2021-12-11', 10, 0),
('201201496', 'LAP', 'Laptop ASUS Zenbook UX363EA- HP130T', 'ASUS', 27990000, '', 0, 'img/LAPTOP/ASUS/201201496/1.png', 2021, '2021-12-11', 10, 0),
('210300402', 'LAP', 'Laptop ASUS TUF Gaming FX506LH-HN002T', 'ASUS', 21990000, '', 0, 'img/LAPTOP/ASUS/210300402/1.png', 2021, '2021-12-11', 10, 0),
('210500135', 'LAP', 'Laptop ASUS ROG Strix Scar 15 G533QR-HQ098T', 'ASUS', 59990000, '', 0, 'img/LAPTOP/ASUS/210500135/1.png', 2021, '2021-12-11', 10, 0),
('210601940', 'LAP', 'Laptop ASUS Vivobook S533EA-BN293T', 'ASUS', 20590000, '', 10, 'img/LAPTOP/ASUS/210601940/1.png', 2021, '2021-12-11', 10, 0),
('210701594', 'LAP', 'Laptop ASUS X515EA-BQ1006T 90NB0TY2-M16620', 'ASUS', 13990000, '', 0, 'img/LAPTOP/ASUS/210701594/1.png', 2021, '2021-12-11', 10, 0),
('210801106', 'LAP', 'Laptop ASUS ROG Zephyrus G14 Alan Walker Edition GA401QEC-K2064T 90NR05R7-M02570', 'ASUS', 49990000, '', 10, 'img/LAPTOP/ASUS/210801106/1.png', 2021, '2021-12-11', 10, 0),
('210801181', 'LAP', 'Laptop ASUS ROG Zephyrus G14 GA401QE-K2097T 90NR05R6-M01500', 'ASUS', 43990000, '', 10, 'img/LAPTOP/ASUS/210801181/1.png', 2021, '2021-12-11', 10, 0),
('210801185', 'LAP', 'Laptop ASUS ROG Flow X13 GV301QC-K6052T 90NR04G1-M00900', 'ASUS', 39990000, '', 10, 'img/LAPTOP/ASUS/210801185/1.png', 2021, '2021-12-11', 10, 0),
('211000567', 'LAP', 'Laptop ASUS ROG Zephyrus GX703HS-K4016T 90NR06F1-M00290', 'ASUS', 99990000, '', 0, 'img/LAPTOP/ASUS/211000567/1.png', 2021, '2021-12-11', 10, 0),
('211008655', 'LAP', 'Laptop ASUS VivoBook Pro M3401QA-KM040T 90NB0VZ2-M00650', 'ASUS', 23990000, '', 0, 'img/LAPTOP/ASUS/211008655/1.png', 2021, '2021-12-11', 10, 0),
('211010562', 'LAP', 'Laptop ASUS UX482EA-KA274T 90NB0S41-M05030', 'ASUS', 32990000, '', 0, 'img/LAPTOP/ASUS/211010562/1.png', 2021, '2021-12-11', 10, 0),
('211103372', 'LAP', 'Laptop ASUS FX516PM-HN002W 90NR05X1-M06730', 'ASUS', 32990000, '', 0, 'img/LAPTOP/ASUS/211103372/1.png', 2021, '2021-12-11', 10, 0),
('211106056', 'LAP', 'Laptop ASUS UX371EA-HL725WS 90NB0RZ2-M17940', 'ASUS', 41990000, '', 20, 'img/LAPTOP/ASUS/211106056/1.png', 2021, '2021-12-11', 10, 0),
('211107193', 'LAP', 'Laptop ASUS B9400CEA-KC0773T 90NX0SX1-M09760', 'ASUS', 29990000, '', 0, 'img/LAPTOP/ASUS/211107193/1.png', 2021, '2021-12-11', 10, 0),
('211108419', 'LAP', 'Laptop ASUS E210MA-GJ353T 90NB0R41-M13130', 'ASUS', 8990000, '', 0, 'img/LAPTOP/ASUS/211108419/1.png', 2021, '2021-12-11', 10, 0),
('201100386', 'LAP', 'Laptop Dell Vostro 14 3405 V4R53500U001W', 'DELL', 16490000, '', 0, 'img/LAPTOP/DELL/201100386/1.png', 2021, '2021-12-11', 10, 0),
('201104873', 'LAP', 'Laptop Dell Vostro 14 3405 V4R53500U003W', 'DELL', 18490000, '', 10, 'img/LAPTOP/DELL/201104873/1.png', 2021, '2021-12-11', 10, 0),
('210601910', 'LAP', 'Laptop Doanh Nghiệp Dell Latitude 3520 70251603', 'DELL', 15890000, '', 0, 'img/LAPTOP/DELL/210601910/1.png', 2021, '2021-12-11', 10, 0),
('210602259', 'LAP', 'Laptop Doanh Nghiệp Dell Latitude 3420 L3420I5SSD', 'DELL', 21490000, '', 10, 'img/LAPTOP/DELL/210602259/1.png', 2021, '2021-12-11', 10, 0),
('210700867', 'LAP', 'Laptop Dell Inspiron 5410 2-in-1 N4I5147W', 'DELL', 27290000, '', 20, 'img/LAPTOP/DELL/210700867/1.png', 2021, '2021-12-11', 10, 0),
('210701155', 'LAP', 'Laptop Doanh Nghiệp Dell Latitude 3420 L3420I3SSD', 'DELL', 17490000, '', 0, 'img/LAPTOP/DELL/210701155/1.png', 2021, '2021-12-11', 10, 0),
('210901940', 'LAP', 'Laptop Dell Vostro 3400 3400-70253899', 'DELL', 15690000, '', 0, 'img/LAPTOP/DELL/210901940/1.png', 2021, '2021-12-11', 10, 0),
('210901941', 'LAP', 'Laptop Dell Vostro 3400 3400-70253900', 'DELL', 18990000, '', 0, 'img/LAPTOP/DELL/210901941/1.png', 2021, '2021-12-11', 10, 0),
('210902970', 'LAP', 'Laptop Dell Inspiron 15 3511 P112F001BBL', 'DELL', 19990000, '', 0, 'img/LAPTOP/DELL/210902970/1.png', 2021, '2021-12-11', 10, 0),
('211000019', 'LAP', 'Laptop Dell Vostro 15 3510 3510-7T2YC1', 'DELL', 20990000, '', 0, 'img/LAPTOP/DELL/211000019/1.png', 2021, '2021-12-11', 10, 0),
('211001489', 'LAP', 'Laptop Doanh Nghiệp Dell Latitude 3520 3520-70251594', 'DELL', 20990000, '', 10, 'img/LAPTOP/DELL/211001489/1.png', 2021, '2021-12-11', 10, 0),
('211002601', 'LAP', 'Laptop Dell Alienware M15 R6 P109F001', 'DELL', 61990000, '', 0, 'img/LAPTOP/DELL/211002601/1.png', 2021, '2021-12-11', 10, 0),
('211104712', 'LAP', 'Laptop Dell Inspiron 14 5410 P143G001ASL', 'DELL', 24490000, '', 0, 'img/LAPTOP/DELL/211104712/1.png', 2021, '2021-12-11', 10, 0),
('211104715', 'LAP', 'Laptop Dell Gaming G15 5511 5511-P105F006AGR', 'DELL', 33990000, '', 15, 'img/LAPTOP/DELL/211104715/1.png', 2021, '2021-12-11', 10, 0),
('211105066', 'LAP', 'Laptop Dell Vostro 5415 V4R55500U015W ', 'DELL', 21190000, '', 5, 'img/LAPTOP/DELL/211105066/1.png', 2021, '2021-12-11', 10, 0),
('211105067', 'LAP', 'Laptop Dell Vostro 5410 V4I5214W', 'DELL', 23690000, '', 0, 'img/LAPTOP/DELL/211105067/1.png', 2021, '2021-12-11', 10, 0),
('211106090', 'LAP', 'Laptop Dell Gaming G15 5515 5515-70266674', 'DELL', 30990000, '', 0, 'img/LAPTOP/DELL/211106090/1.png', 2021, '2021-12-11', 10, 0),
('211106091', 'LAP', 'Laptop Dell Gaming G15 5515 5515-70266675', 'DELL', 33990000, '', 0, 'img/LAPTOP/DELL/211106091/1.png', 2021, '2021-12-11', 10, 0),
('211110871', 'LAP', 'Laptop Dell Vostro 15 3510 V5I3305W', 'DELL', 15990000, '', 15, 'img/LAPTOP/DELL/211110871/1.png', 2021, '2021-12-11', 10, 0),
('210700018', 'LAP', 'Laptop GIGABYTE Aorus 15P KD-72S1223GH', 'GIGABYTE', 45990000, '', 0, 'img/LAPTOP/GIGABYTE/210700018/1.png', 2021, '2021-12-11', 10, 0),
('210700020', 'LAP', 'Laptop GIGABYTE G5 MD 51S1123SH', 'GIGABYTE', 29990000, '', 5, 'img/LAPTOP/GIGABYTE/210700020/1.png', 2021, '2021-12-11', 10, 0),
('210700021', 'LAP', 'Laptop GIGABYTE G5 GD 51S1123SH', 'GIGABYTE', 26900000, '', 20, 'img/LAPTOP/GIGABYTE/210700021/1.png', 2021, '2021-12-11', 10, 0),
('211109776', 'LAP', 'Laptop GIGABYTE G5 KC G5 KC-5S11130SB', 'GIGABYTE', 29990000, '', 0, 'img/LAPTOP/GIGABYTE/211109776/1.png', 2021, '2021-12-11', 10, 0),
('210701369', 'LAP', 'Laptop HP 240 G8 3D0E8PA', 'HP', 21890000, '', 0, 'img/LAPTOP/HP/210701369/1.png', 2021, '2021-12-11', 10, 0),
('210900192', 'LAP', 'Laptop HP OMEN 16-b0141TX 4Y0Z7PA', 'HP', 43990000, '', 15, 'img/LAPTOP/HP/210900192/1.png', 2021, '2021-12-11', 10, 0),
('211001906', 'LAP', 'Laptop HP Envy 13-ba1535TU 4U6M4PA', 'HP', 29890000, '', 0, 'img/LAPTOP/HP/211001906/1.png', 2021, '2021-12-11', 10, 0),
('201201232', 'LAP', 'Laptop Lenovo Yoga Slim 7 14ITL05- 82A3002QVN', 'LENOVO', 22790000, '', 0, 'img/LAPTOP/LENOVO/201201232/1.png', 2021, '2021-12-11', 10, 0),
('201202413', 'LAP', 'Laptop Lenovo Yoga Slim 7 14ITL05- 82A3004FVN', 'LENOVO', 26690000, '', 10, 'img/LAPTOP/LENOVO/201202413/1.png', 2021, '2021-12-11', 10, 0),
('210103987', 'LAP', 'Laptop Lenovo Yoga Duet 7 13IML05- 82AS009AVN', 'LENOVO', 26990000, '', 0, 'img/LAPTOP/LENOVO/210103987/1.png', 2021, '2021-12-11', 10, 0),
('210600187', 'LAP', 'Laptop Lenovo Yoga Slim 9 14ITL5 82D1004JVN', 'LENOVO', 51990000, '', 0, 'img/LAPTOP/LENOVO/210600187/1.png', 2021, '2021-12-11', 10, 0),
('210500985', 'LAP', 'Laptop LG Gram 2021 14ZD90P G.AX51A5', 'LG', 31990000, '', 0, 'img/LAPTOP/LG/210500985/1.png', 2021, '2021-12-11', 10, 0),
('210500986', 'LAP', 'Laptop LG Gram 2021 14ZD90P G.AX56A5', 'LG', 34990000, '', 0, 'img/LAPTOP/LG/210500986/1.png', 2021, '2021-12-11', 10, 0),
('210500990', 'LAP', 'Laptop LG Gram 2021 16Z90P G.AH75A5', 'LG', 50900000, '', 5, 'img/LAPTOP/LG/210500990/1.png', 2021, '2021-12-11', 10, 0),
('191007067', 'LAP', 'Laptop MSI GS65 Stealth 9SD-1409VN', 'MSI', 34990000, '', 0, 'img/LAPTOP/MSI/191007067/1.png', 2021, '2021-12-11', 10, 0),
('210300884', 'LAP', 'Laptop MSI Thin GF63 10SC- 020VN', 'MSI', 22990000, '', 0, 'img/LAPTOP/MSI/210300884/1.png', 2021, '2021-12-11', 10, 0),
('210300885', 'LAP', 'Laptop MSI Thin GF63 10SC- 014VN', 'MSI', 20990000, '', 0, 'img/LAPTOP/MSI/210300885/1.png', 2021, '2021-12-11', 10, 0),
('210600075', 'LAP', 'Laptop MSI Katana GF76 11UC 096VN', 'MSI', 29990000, '', 0, 'img/LAPTOP/MSI/210600075/1.png', 2021, '2021-12-11', 10, 0),
('211005812', 'LAP', 'Laptop MSI Modern 15 A10M 667VN', 'MSI', 17990000, '', 10, 'img/LAPTOP/MSI/211005812/1.png', 2021, '2021-12-11', 10, 0),
('211105060', 'LAP', 'Laptop MSI Modern 14 B11SBU 668VN', 'MSI', 21990000, '', 0, 'img/LAPTOP/MSI/211105060/1.png', 2021, '2021-12-11', 10, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `user_id` int(255) NOT NULL DEFAULT 0,
  `user_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(128) COLLATE utf8_bin NOT NULL,
  `user_phone` varchar(20) COLLATE utf8_bin NOT NULL,
  `amount` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `payment` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL DEFAULT '1900-01-01',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `product_id` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Đang đổ dữ liệu cho bảng `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `status`, `user_id`, `user_name`, `user_email`, `user_phone`, `amount`, `payment`, `message`, `date`, `address`, `product_id`) VALUES
(2, 3, 0, 'fdsfsadfdsfs', 'abac@gmail.com', '0147258369', '2.0000', '110015000', 'fasdfsadfds', '2021-11-10', 'fdsfsdfdsfdas-fadsfdasfdas-fdasdfdsafds-dfadsfadsfds', 'LAPACETRITON300'),
(3, 3, 0, 'fdasdfadsfas', 'fdsfads@gmail.com', '0258147369', '2.0000', '64019000', 'fdsafads', '2021-11-10', 'fdfadsfsad-fadsfsadfsad-fdasfdsa-fdsafsad', 'LAPLENYOGA9');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `user_id` int(255) NOT NULL,
  `user_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `user_phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `user_phone`, `user_password`) VALUES
(0, 'Huỳnh Phong', 'phong@gmail.com', '0123456789', '25f9e794323b453885f5181f1b624d0b');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Chỉ mục cho bảng `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`user_id`,`product_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);
ALTER TABLE `product` ADD FULLTEXT KEY `product_name` (`product_name`);

--
-- Chỉ mục cho bảng `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_phone` (`user_phone`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
