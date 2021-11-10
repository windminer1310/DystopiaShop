-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 12, 2021 lúc 10:58 AM
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
-- Cơ sở dữ liệu: `bshop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(255) NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `password` varchar(128) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `authority` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `name`, `phone`, `password`, `authority`) VALUES
(1, 'LHL', '0123456789', 'c8837b23ff8aaa8a2dde915473ce0991', 1),
(8, 'aa', '0111111111', 'c8837b23ff8aaa8a2dde915473ce0991', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(255) NOT NULL,
  `category` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(15) NOT NULL DEFAULT 0,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
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

INSERT INTO `product` (`id`, `category`, `name`, `brand`, `price`, `content`, `discount`, `image_link`, `date_first_available`, `saledate`, `amount`, `sold`) VALUES
(16, 'Lịch sử', 'Súng, vi trùng và thép', 'Thế giới', 275000, '', 0, 'img/product_00.jpg', 2020, '2021-08-12', 500, 0),
(18, 'Tiểu thuyết', 'Hỏa Ngục', 'Bách Việt', 185000, '', 0, 'img/product_02.jpg', 2013, '2021-08-11', 311, 3),
(19, 'Lịch sử', 'Thế giới cho đến ngày hôm qua', 'Thế giới', 195000, 'Trống', 0, 'img/product_01.jpg', 2019, '2021-08-03', 196, 5),
(20, 'Truyện tranh', 'Doraemon tập 1', 'Kim Đồng', 21000, 'Trống', 0, 'img/product_03.png', 2021, '2021-08-03', 4980, 16),
(21, 'Tiểu thuyết', 'Nhà giả kim', 'Thế Giới', 55000, '', 0, 'img/product-03.jpg', 2020, '2021-08-11', 100, 0),
(22, 'Tiểu thuyết', 'Dấu chân trên cát', 'Thái Hà', 148000, '', 0, 'img/product-04.jpg', 2020, '2021-08-01', 145, 5),
(23, 'Tiểu thuyết', 'Con chim xanh biếc bay về', 'NXB Trẻ', 112000, '', 0, 'img/product-05.jpg', 2020, '2021-08-01', 2019, 1),
(24, 'Tiểu thuyết', 'Bố già (Đông A)', 'NXB Trẻ', 69000, '', 0, 'img/product-06.jpg', 2020, '2021-08-01', 195, 5),
(25, 'Tiểu thuyết', 'Tôi là Bêtô', 'NXB Trẻ', 72000, '', 0, 'img/product-07.jpg', 2020, '2021-08-01', 200, 0),
(26, 'Huyền bí - Giả tưởng - Kinh dị', 'Harry Potter và hòn đá phù thủy - Tập 1', 'NXB Trẻ', 117000, '', 0, 'img/product-08.jpg', 2017, '2021-08-11', 55, 0),
(27, 'Huyền bí - Giả tưởng - Kinh dị', 'Điều kỳ diệu của tiệm tạp hóa Namiya', 'Phương Nam product', 73000, '', 0, 'img/product-09.jpg', 2018, '2021-08-11', 222, 0),
(28, 'Huyền bí - Giả tưởng - Kinh dị', 'Harry Potter và phòng chứa bí mật - Tập 2', 'NXB Trẻ', 130000, '', 0, 'img/product-10.jpg', 2017, '2021-08-11', 244, 0),
(29, 'Tiểu thuyết', 'Harry Potter và hoàng tử lai - Tập 6', 'NXB Trẻ', 175000, '', 0, 'img/product-11.jpg', 2017, '2021-08-11', 111, 0),
(30, 'Huyền bí - Giả tưởng - Kinh dị', 'Bảy Thanh Hung Giản 1', 'Thế Giới', 160000, '', 0, 'img/product-12.jpg', 2019, '2021-08-11', 155, 0),
(31, 'Trinh thám', 'Sherlock Holmes (Trọn bộ 3 cuốn)', 'Phương Nam product', 293000, '', 0, 'img/product-13.jpg', 2018, '2021-08-11', 50, 0),
(32, 'Kiếm hiệp', 'Ác Ý', 'Nhã Nam', 98000, '', 23, 'img/product-14.jpg', 2018, '2021-08-11', 398, 2),
(33, 'Tiểu thuyết', 'Mắt biếc', 'NXB Trẻ', 93000, '', 0, 'img/product-15.jpg', 2019, '2021-08-11', 350, 0),
(34, 'Tiểu thuyết', 'Trường ca Achilles', 'Thế Giới', 148000, '', 0, 'img/product-16.jpg', 2020, '2021-08-11', 120, 0),
(36, 'Huyền bí - Giả tưởng - Kinh dị', 'Combo Harry Potter (Bộ 8 Cuốn)', 'NXB Trẻ', 1700000, '', 17, 'img/product-18.jpg', 2020, '2021-08-11', 144, 4),
(37, 'Tiểu thuyết', 'Liêu Trai Chí Dị', 'Thanh Niên', 118000, '', 0, 'img/product-19.jpg', 2017, '2021-08-11', 199, 0),
(38, 'Trinh thám', 'Manh Mối Tử Thần', 'NXB Trẻ', 125000, '', 0, 'img/product-20.jpg', 2020, '2021-08-11', 500, 0),
(39, 'Tiểu thuyết', 'Hừng Đông', 'Thái Hà', 216000, '', 0, 'img/product-21.jpg', 2020, '2021-08-11', 200, 0),
(40, 'Kiếm hiệp', 'Hồn Hồ Ly', 'Thanh Niên', 72000, '', 0, 'img/product-22.jpg', 2020, '2021-08-11', 200, 0),
(41, 'Tiểu thuyết', 'Ba Người Bạn', 'NXB Trẻ', 72000, '', 0, 'img/product-23.jpg', 2016, '2021-08-11', 123, 0),
(42, 'Huyền bí - Giả tưởng - Kinh dị', 'Thư Viện Kỳ Lạ', 'NXB Trẻ', 129000, '', 18, 'img/product-24.jpg', 2020, '2021-08-11', 450, 0),
(43, 'Huyền bí - Giả tưởng - Kinh dị', 'Tội Ác Và Hình Phạt', 'Bách Việt', 210000, '', 0, 'img/product-25.jpg', 2021, '2021-08-11', 255, 0),
(44, 'Sách giáo khoa - Tham khảo', 'Tiếng Việt 1 - Tập 2', 'NXB Trẻ', 33000, '', 0, 'img/product-26.jpg', 2020, '2021-08-11', 200, 0),
(45, 'Sách giáo khoa - Tham khảo', 'Atlat Địa Lí Việt Nam - 2021', 'Thanh Niên', 29000, '', 0, 'img/product-27.jpg', 2021, '2021-08-11', 600, 0),
(46, 'Sách giáo khoa - Tham khảo', 'Hóa Học 12', 'Thanh Niên', 30000, '', 0, 'img/product-28.jpg', 2020, '2021-08-11', 444, 0),
(47, 'Sách giáo khoa - Tham khảo', 'Giải Tích 12 (Nâng Cao)', 'Thanh Niên', 35000, '', 0, 'img/product-29.jpg', 2020, '2021-08-11', 147, 0),
(48, 'Sách giáo khoa - Tham khảo', 'Hướng Dẫn Học Và Ôn Tập Giáo Dục Công Dân', 'Thanh Niên', 45000, '', 38, 'img/product-30.jpg', 2020, '2021-08-12', 789, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `user_id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(24, 'Lịch sử'),
(25, 'Thiên văn học'),
(26, 'Tiểu thuyết'),
(27, 'Truyện tranh'),
(28, 'Light novel'),
(29, 'Thiếu nhi'),
(30, 'Ẩm thực'),
(31, 'Tin học'),
(32, 'Văn học'),
(35, 'Y học'),
(36, 'Huyền bí - Giả tưởng - Kinh dị'),
(37, 'Trinh thám'),
(38, 'Kiếm hiệp'),
(39, 'Sách giáo khoa - Tham khảo');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Đang đổ dữ liệu cho bảng `brand`
--

INSERT INTO `brand` (`id`, `name`) VALUES
(1, 'Kim Đồng'),
(2, 'Nhã Nam'),
(3, 'Thanh Niên'),
(4, 'NXB Trẻ'),
(5, 'Thế Giới'),
(6, 'Bách Việt'),
(12, 'Phương Nam product'),
(10, 'Thái Hà'),
(11, 'Phương Nam product');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transaction`
--

CREATE TABLE `transaction` (
  `id` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `address` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `user_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(50) COLLATE utf8_bin NOT NULL,
  `user_phone` varchar(20) COLLATE utf8_bin NOT NULL,
  `amount` text COLLATE utf8_bin NOT NULL DEFAULT '0',
  `product_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `payment` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Đang đổ dữ liệu cho bảng `transaction`
--

INSERT INTO `transaction` (`id`, `status`, `address`, `user_id`, `user_name`, `user_email`, `user_phone`, `amount`, `product_id`, `payment`, `message`, `date`) VALUES
(7, 3, 'Ninh Hòa-Khánh Hòa', 19, 'L15C', 'lehuuloc126@gmail.com', '0966215020', '1', '20', '56000', '', '2021-08-07 16:20:07'),
(8, 4, 'Ninh Hòa-Khánh Hòa', 19, 'L15C', 'lehuuloc126@gmail.com', '0966215020', '1', '16', '310000', '', '2021-08-07 16:45:56'),
(29, 0, 'KH---KH', 19, 'Lê Hữu Lộc', 'lehuuloc126@gmail.com', '0966215020', '1', '23', '147000', '', '2021-08-12 14:01:24'),
(22, 4, 'Ninh Hòa-Khánh Hòa', 19, 'L15C', 'lehuuloc126@gmail.com', '0966215020', '4', '21', '255000', '', '2021-08-11 19:48:06'),
(28, 0, 'Khánh Hòa---Ninh Hòa', 19, 'Lê Hữu Lộc', '1', '0123456789', '5', '24', '380000', '', '2021-08-12 13:54:41'),
(25, 3, 'Ninh Hòa-Khánh Hòa', 19, 'L15C', 'lehuuloc126@gmail.com', '0966215020', '5', '22', '775000', '', '2021-08-11 20:39:17'),
(27, 0, 'Ninh Hòa-Khánh Hòa', 19, 'L15C', 'lehuuloc126@gmail.com', '0966215020', '1', '32', '110460', '', '2021-08-12 13:10:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `phone`, `password`) VALUES
(19, 'Lê Hữu Lộc', 'lehuuloc126@gmail.com', '0966215020', 'e10adc3949ba59abbe56e057f20f883e');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `product` ADD FULLTEXT KEY `name` (`name`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`user_id`,`product_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
