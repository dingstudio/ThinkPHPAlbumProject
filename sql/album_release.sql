-- phpMyAdmin SQL Dump
-- version 4.7.0-beta1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-01-29 20:38:41
-- 服务器版本： 5.7.17-log
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `album_release`
--

-- --------------------------------------------------------

--
-- 表的结构 `myalbum_basicinfo`
--

CREATE TABLE `myalbum_basicinfo` (
  `myalbum_name` varchar(255) DEFAULT NULL,
  `myalbum_nickname` varchar(255) DEFAULT NULL,
  `myalbum_icon` varchar(255) DEFAULT NULL,
  `myalbum_logo` varchar(255) DEFAULT NULL,
  `myalbum_saying` varchar(255) DEFAULT NULL,
  `myalbum_author` varchar(255) DEFAULT NULL,
  `myalbum_copyright` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `myalbum_basicinfo`
--

INSERT INTO `myalbum_basicinfo` (`myalbum_name`, `myalbum_nickname`, `myalbum_icon`, `myalbum_logo`, `myalbum_saying`, `myalbum_author`, `myalbum_copyright`) VALUES
('测试相册', 'Test Album', 'http://cdn-img.easyicon.net/png/11821/1182127.gif', 'http://cdn-img.easyicon.net/png/11821/1182127.gif', '您正在访问一个处于开发阶段的相册网站', 'DingStudio', 'DingCloud');

-- --------------------------------------------------------

--
-- 表的结构 `myalbum_cover`
--

CREATE TABLE `myalbum_cover` (
  `cid` int(5) NOT NULL,
  `style` int(1) NOT NULL,
  `open` int(1) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `inst` varchar(255) DEFAULT NULL,
  `coveraddr` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `myalbum_cover`
--

INSERT INTO `myalbum_cover` (`cid`, `style`, `open`, `name`, `inst`, `coveraddr`) VALUES
(1, 3, 1, '测试相册', '测试相册集，可自行修改或删除', 'http://longpic.dingstudio.cn/Public/Album-Admin/images/banner_demo.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `myalbum_navi`
--

CREATE TABLE `myalbum_navi` (
  `nid` int(2) NOT NULL,
  `nsid` int(2) NOT NULL DEFAULT '0',
  `navi` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `myalbum_navi`
--

INSERT INTO `myalbum_navi` (`nid`, `nsid`, `navi`, `link`) VALUES
(1, 0, '首页', './index.php'),
(2, 1, '后台管理', './admin.php');

-- --------------------------------------------------------

--
-- 表的结构 `myalbum_photo`
--

CREATE TABLE `myalbum_photo` (
  `pid` int(5) NOT NULL,
  `cid` int(5) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `inst` varchar(255) DEFAULT NULL,
  `preimg` varchar(255) DEFAULT NULL,
  `bigimg` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `myalbum_users`
--

CREATE TABLE `myalbum_users` (
  `uid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `userpwd` varchar(50) NOT NULL,
  `usertoken` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `myalbum_users`
--

INSERT INTO `myalbum_users` (`uid`, `username`, `userpwd`, `usertoken`, `email`) VALUES
(1, 'admin', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', '560edbd23a46984600ca608db6e9d0ec6f2816f8', 'admin@example.org');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `myalbum_cover`
--
ALTER TABLE `myalbum_cover`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `myalbum_navi`
--
ALTER TABLE `myalbum_navi`
  ADD PRIMARY KEY (`nid`);

--
-- Indexes for table `myalbum_photo`
--
ALTER TABLE `myalbum_photo`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `myalbum_users`
--
ALTER TABLE `myalbum_users`
  ADD PRIMARY KEY (`uid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `myalbum_cover`
--
ALTER TABLE `myalbum_cover`
  MODIFY `cid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `myalbum_navi`
--
ALTER TABLE `myalbum_navi`
  MODIFY `nid` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `myalbum_photo`
--
ALTER TABLE `myalbum_photo`
  MODIFY `pid` int(5) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `myalbum_users`
--
ALTER TABLE `myalbum_users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
