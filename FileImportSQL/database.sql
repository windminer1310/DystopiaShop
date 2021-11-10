-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:33066
-- Thời gian đã tạo: Th10 10, 2021 lúc 08:44 AM
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
('dasdasdas', 'CAS', 'asdasdsdsa', 'AMD', 96000000, 'dasdsadsa', 50, 'img/msi-rtx-3090.png', 2020, '2021-11-07', 5555, 0),
('LAPASUTUFF15', 'LAP', 'Asus TUF F15', 'ASU', 34990000, 'Laptop', 10, 'img/asus-tuf-f15.png', 2021, '2021-11-07', 120, 0),
('LAPACETRITON300', 'LAP', 'Acer Predator Triton 300', 'AC', 54990000, 'Laptop', 0, 'img/acer-predator-triton-300.png', 2021, '2021-11-07', 200, 0),
('LAPLENYOGA9', 'LAP', 'Lenovo Yoga 9', 'LEN', 39990000, 'Laptop', 20, 'img/lenovo-yoga-9.jpg', 2021, '2021-11-07', 128, 2),
('LAPMSIRAIDERGE66', 'LAP', 'MSI Raider GE66', 'MSI', 34990000, 'Laptop', 0, 'img/msi-raider-ge66.png', 2021, '2021-11-07', 200, 0),
('MBOMSIMEGZ590', 'MB', 'MSI MEG Z590 GODLIKE', 'MS', 20990000, 'Bo mạch chủ', 5, 'img/msi-meg-z590-godlike.jpg', 2021, '2021-11-07', 350, 0),
('fdsfasfsa', 'CAS', 'dfsd', 'AMD', 11111, 'fdsfads', 0, 'img/msi-rtx-3090.png', 2020, '2021-11-10', 0, 0);

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
