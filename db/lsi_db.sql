-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: db
-- Thời gian đã tạo: Th4 19, 2023 lúc 03:10 PM
-- Phiên bản máy phục vụ: 8.0.32
-- Phiên bản PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `lsi_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_checkinout`
--

CREATE TABLE `tbl_checkinout` (
  `check_id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `action` enum('check_in','check_out','start_break','end_break') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_time` datetime DEFAULT NULL,
  `latitude` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remote` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_employees`
--

CREATE TABLE `tbl_employees` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_employees`
--

INSERT INTO `tbl_employees` (`id`, `name`, `username`, `email`, `password`, `role`) VALUES
(1, 'ADMIN', 'admin', 'admin@lsi-dev.co.jp', '$2y$10$NEUntzaSR3rzP7Du7NpsRufVd71.Ag.joxcicpgbXWgdh3XZqdd26', 1),
(2, 'A氏', 'ashi', 'ashi@lsi-dev.co.jp', '$2y$10$pZ4yrOnO3otW0AKXz683JOXnSkznrdn./3DRy.TtEHOLDdL4cvH6C', 0),
(3, 'B氏', 'bshi', 'bshi@lsi-dev.co.jp', '$2y$10$9gMJaI4wAs66KSRH6JFe9OxOCpM1lWxRphvtegZ9oC0TpWp2.Zuga', 0),
(4, 'C氏', 'cshi', 'cshi@lsi-dev.co.jp', '$2y$10$ErmPiu0PAY/CRu1uV605Z.f0h1ZpYvQWVngtnd5skhi1uYkNeRwDC', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_checkinout`
--
ALTER TABLE `tbl_checkinout`
  ADD PRIMARY KEY (`check_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `location_id` (`latitude`);

--
-- Chỉ mục cho bảng `tbl_employees`
--
ALTER TABLE `tbl_employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbl_checkinout`
--
ALTER TABLE `tbl_checkinout`
  MODIFY `check_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_employees`
--
ALTER TABLE `tbl_employees`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tbl_checkinout`
--
ALTER TABLE `tbl_checkinout`
  ADD CONSTRAINT `tbl_checkinout_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_employees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;