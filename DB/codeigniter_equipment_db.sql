-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 2018 年 12 月 05 日 19:00
-- 伺服器版本: 10.1.36-MariaDB
-- PHP 版本： 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `codeigniter_equipment_db`
--

-- --------------------------------------------------------

--
-- 資料表結構 `borrow`
--

CREATE TABLE `borrow` (
  `U_Id` int(20) DEFAULT NULL COMMENT 'U_學號',
  `D_Id` int(20) DEFAULT NULL COMMENT 'D_產編',
  `B_Day` date NOT NULL COMMENT 'B_借出日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `borrow`
--

INSERT INTO `borrow` (`U_Id`, `D_Id`, `B_Day`) VALUES
(17113120, 1, '2018-12-01');

-- --------------------------------------------------------

--
-- 資料表結構 `device`
--

CREATE TABLE `device` (
  `D_Id` int(11) NOT NULL COMMENT 'D_編號',
  `D_Number` int(20) NOT NULL COMMENT 'D_流水號',
  `D_Name` varchar(10) NOT NULL COMMENT 'D_設備名稱',
  `D_Model` int(20) NOT NULL COMMENT 'D_型號',
  `D_Day` date NOT NULL COMMENT 'D_財增日',
  `D_Unit` varchar(10) NOT NULL COMMENT 'D_保管單位'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `device`
--

INSERT INTO `device` (`D_Id`, `D_Number`, `D_Name`, `D_Model`, `D_Day`, `D_Unit`) VALUES
(1, 1111111, '滑鼠', 11, '2018-12-03', 'XX');

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `U_Id` int(8) NOT NULL COMMENT 'U_學號',
  `U_Password` varchar(20) NOT NULL COMMENT 'U_密碼',
  `U_Name` varchar(5) NOT NULL COMMENT 'U_姓名',
  `U_Tel` int(10) NOT NULL COMMENT 'U_電話',
  `U_Permission` varchar(5) NOT NULL COMMENT 'U_權限'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `user`
--

INSERT INTO `user` (`U_Id`, `U_Password`, `U_Name`, `U_Tel`, `U_Permission`) VALUES
(17113120, '123', '蘇厚安', 911111111, '管理員');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `borrow`
--
ALTER TABLE `borrow`
  ADD KEY `U_Id` (`U_Id`),
  ADD KEY `D_Id` (`D_Id`);

--
-- 資料表索引 `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`D_Id`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`U_Id`);

--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `borrow_ibfk_1` FOREIGN KEY (`D_Id`) REFERENCES `device` (`D_Id`),
  ADD CONSTRAINT `borrow_ibfk_2` FOREIGN KEY (`U_Id`) REFERENCES `user` (`U_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
