-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th5 15, 2023 lúc 09:56 AM
-- Phiên bản máy phục vụ: 5.7.36
-- Phiên bản PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `dblaptopluanvan`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `idadmin` int(11) NOT NULL,
  `tenadmin` varchar(255) NOT NULL,
  `passadmin` varchar(255) NOT NULL,
  `trangthai` int(11) DEFAULT NULL,
  PRIMARY KEY (`idadmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banner`
--

DROP TABLE IF EXISTS `banner`;
CREATE TABLE IF NOT EXISTS `banner` (
  `idbanner` int(11) NOT NULL,
  `tenbanner` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `motabanner` text NOT NULL,
  `trangthai` int(11) DEFAULT NULL,
  PRIMARY KEY (`idbanner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonhang`
--

DROP TABLE IF EXISTS `chitietdonhang`;
CREATE TABLE IF NOT EXISTS `chitietdonhang` (
  `iddonhang` int(11) NOT NULL,
  `soluong` varchar(255) NOT NULL,
  `gia` varchar(45) NOT NULL,
  `idsanpham` varchar(100) NOT NULL,
  `trangthai` int(11) DEFAULT NULL,
  PRIMARY KEY (`iddonhang`,`idsanpham`),
  KEY `fk_o_sp_idx` (`idsanpham`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietkhuyenmai`
--

DROP TABLE IF EXISTS `chitietkhuyenmai`;
CREATE TABLE IF NOT EXISTS `chitietkhuyenmai` (
  `idkhuyenmai` int(11) NOT NULL,
  `phantramkhuyenmai` varchar(255) NOT NULL,
  `idsanpham` varchar(100) NOT NULL,
  `trangthai` int(11) DEFAULT NULL,
  PRIMARY KEY (`idkhuyenmai`,`idsanpham`),
  KEY `fk_km_sp_idx` (`idsanpham`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cpu`
--

DROP TABLE IF EXISTS `cpu`;
CREATE TABLE IF NOT EXISTS `cpu` (
  `idCPU` int(11) NOT NULL AUTO_INCREMENT,
  `tenCPU` varchar(255) NOT NULL,
  `slug_CPU` varchar(255) NOT NULL,
  `mota_CPU` text NOT NULL,
  `trangthai` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCPU`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dohoa`
--

DROP TABLE IF EXISTS `dohoa`;
CREATE TABLE IF NOT EXISTS `dohoa` (
  `iddohoa` int(11) NOT NULL AUTO_INCREMENT,
  `tendohoa` varchar(255) NOT NULL,
  `slug_dohoa` varchar(255) NOT NULL,
  `motadohoa` text NOT NULL,
  `trangthai` int(11) DEFAULT NULL,
  PRIMARY KEY (`iddohoa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

DROP TABLE IF EXISTS `donhang`;
CREATE TABLE IF NOT EXISTS `donhang` (
  `iddonhang` int(11) NOT NULL AUTO_INCREMENT,
  `tennguoinhan` varchar(255) NOT NULL,
  `sdtnguoinhan` varchar(255) NOT NULL,
  `diachinguoinhan` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `idnguoidung` int(11) NOT NULL,
  `trangthai` int(11) DEFAULT NULL,
  `ngaydat` date NOT NULL,
  `hinhthuc` int(11) NOT NULL,
  PRIMARY KEY (`iddonhang`),
  KEY `fk_dh_nd_idx` (`idnguoidung`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyenmai`
--

DROP TABLE IF EXISTS `khuyenmai`;
CREATE TABLE IF NOT EXISTS `khuyenmai` (
  `idkhuyenmai` int(11) NOT NULL AUTO_INCREMENT,
  `tenkhuyenmai` varchar(255) NOT NULL,
  `ngaybatdau` date NOT NULL,
  `ngayketthuc` date NOT NULL,
  `trangthai` int(11) DEFAULT NULL,
  PRIMARY KEY (`idkhuyenmai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisanpham`
--

DROP TABLE IF EXISTS `loaisanpham`;
CREATE TABLE IF NOT EXISTS `loaisanpham` (
  `idloaisanpham` int(11) NOT NULL AUTO_INCREMENT,
  `tenloai` varchar(255) NOT NULL,
  `slug_loai` varchar(255) NOT NULL,
  `motaloai` text NOT NULL,
  `trangthai` int(11) DEFAULT NULL,
  PRIMARY KEY (`idloaisanpham`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `loaisanpham`
--

INSERT INTO `loaisanpham` (`idloaisanpham`, `tenloai`, `slug_loai`, `motaloai`, `trangthai`) VALUES
(1, 'Laptop Gaming', 'l-gaming', 'Laptop dành cho Gaming', 1),
(2, 'Laptop Đồ Họa', 'l-dohoa', 'LapTop dành cho đồ họa', 1),
(3, 'Laptop Sinh Viên-Học Sinh', 'l-sinhvienhocsinh', 'Laptop Dành Cho Sinh Viên-Học Sinh', 1),
(4, 'Laptop Doanh Nhân', 'l-doanhnhan', 'Laptop Dành Cho Doanh Nhân', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `luutru`
--

DROP TABLE IF EXISTS `luutru`;
CREATE TABLE IF NOT EXISTS `luutru` (
  `idluutru` int(11) NOT NULL AUTO_INCREMENT,
  `tenluutru` varchar(255) NOT NULL,
  `slug_luutru` varchar(255) NOT NULL,
  `motaluutru` text NOT NULL,
  `trangthai` int(11) DEFAULT NULL,
  PRIMARY KEY (`idluutru`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `manhinh`
--

DROP TABLE IF EXISTS `manhinh`;
CREATE TABLE IF NOT EXISTS `manhinh` (
  `idmanhinh` int(11) NOT NULL AUTO_INCREMENT,
  `tenmanhinh` varchar(255) NOT NULL,
  `slug_manhinh` varchar(255) NOT NULL,
  `motamanhinh` text NOT NULL,
  `trangthai` int(11) DEFAULT NULL,
  PRIMARY KEY (`idmanhinh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

DROP TABLE IF EXISTS `nguoidung`;
CREATE TABLE IF NOT EXISTS `nguoidung` (
  `idnguoidung` int(11) NOT NULL AUTO_INCREMENT,
  `tennguoidung` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sdt` varchar(255) NOT NULL,
  `trangthai` int(11) DEFAULT NULL,
  PRIMARY KEY (`idnguoidung`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ram`
--

DROP TABLE IF EXISTS `ram`;
CREATE TABLE IF NOT EXISTS `ram` (
  `idram` int(11) NOT NULL AUTO_INCREMENT,
  `tenram` varchar(255) NOT NULL,
  `slug_ram` varchar(255) NOT NULL,
  `motaram` text NOT NULL,
  `trangthai` int(11) DEFAULT NULL,
  PRIMARY KEY (`idram`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
CREATE TABLE IF NOT EXISTS `sanpham` (
  `idsanpham` varchar(100) NOT NULL,
  `tensanpham` varchar(255) NOT NULL,
  `gia` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `soluong` varchar(100) NOT NULL,
  `motasanpham` text NOT NULL,
  `slug_sanpham` varchar(255) NOT NULL,
  `noidung` text NOT NULL,
  `idthuonghieu` int(11) NOT NULL,
  `idram` int(11) NOT NULL,
  `idmanhinh` int(11) NOT NULL,
  `idluutru` int(11) NOT NULL,
  `idloaisanpham` int(11) NOT NULL,
  `iddohoa` int(11) NOT NULL,
  `idCPU` int(11) NOT NULL,
  `trangthai` int(11) DEFAULT NULL,
  PRIMARY KEY (`idsanpham`),
  KEY `fk_sp_cpu_idx` (`idCPU`),
  KEY `fk_sp_dohoa_idx` (`iddohoa`),
  KEY `fk_sp_luutru_idx` (`idluutru`),
  KEY `fk_sp_manhinh_idx` (`idmanhinh`),
  KEY `fk_sp_ram_idx` (`idram`),
  KEY `fk_sp_thuonghieu_idx` (`idthuonghieu`),
  KEY `fk_sp_loaisp_idx` (`idloaisanpham`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thuonghieu`
--

DROP TABLE IF EXISTS `thuonghieu`;
CREATE TABLE IF NOT EXISTS `thuonghieu` (
  `idthuonghieu` int(11) NOT NULL AUTO_INCREMENT,
  `tenthuonghieu` varchar(255) NOT NULL,
  `slug_thuonghieu` varchar(255) NOT NULL,
  `motathuonghieu` text NOT NULL,
  `trangthai` int(11) DEFAULT NULL,
  PRIMARY KEY (`idthuonghieu`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `thuonghieu`
--

INSERT INTO `thuonghieu` (`idthuonghieu`, `tenthuonghieu`, `slug_thuonghieu`, `motathuonghieu`, `trangthai`) VALUES
(1, 'Acer', 'acer', 'Thương hiệu Acer', 1),
(2, 'Dell', 'dell', 'Thương hiệu Dell', 1),
(3, 'Asus', 'asus', 'Thương hiệu Asus', 1),
(4, 'HP', 'hp', 'Thương hiệu HP', 1),
(5, 'MSI', 'msi', 'Thương hiệu MSI', 1),
(6, 'LG', 'lg', 'Thương hiệu LG', 1);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `fk_dh_ctdh` FOREIGN KEY (`iddonhang`) REFERENCES `donhang` (`iddonhang`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dh_sp` FOREIGN KEY (`idsanpham`) REFERENCES `sanpham` (`idsanpham`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `chitietkhuyenmai`
--
ALTER TABLE `chitietkhuyenmai`
  ADD CONSTRAINT `fk_km_km` FOREIGN KEY (`idkhuyenmai`) REFERENCES `khuyenmai` (`idkhuyenmai`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_km_sp` FOREIGN KEY (`idsanpham`) REFERENCES `sanpham` (`idsanpham`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `fk_dh_nd` FOREIGN KEY (`idnguoidung`) REFERENCES `nguoidung` (`idnguoidung`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `fk_sp_cpu` FOREIGN KEY (`idCPU`) REFERENCES `cpu` (`idCPU`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sp_dohoa` FOREIGN KEY (`iddohoa`) REFERENCES `dohoa` (`iddohoa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sp_loaisp` FOREIGN KEY (`idloaisanpham`) REFERENCES `loaisanpham` (`idloaisanpham`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sp_luutru` FOREIGN KEY (`idluutru`) REFERENCES `luutru` (`idluutru`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sp_manhinh` FOREIGN KEY (`idmanhinh`) REFERENCES `manhinh` (`idmanhinh`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sp_ram` FOREIGN KEY (`idram`) REFERENCES `ram` (`idram`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sp_thuonghieu` FOREIGN KEY (`idthuonghieu`) REFERENCES `thuonghieu` (`idthuonghieu`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
