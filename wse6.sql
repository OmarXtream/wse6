-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 09, 2019 at 04:56 PM
-- Server version: 5.7.24
-- PHP Version: 7.3.2-3+0~20190208150725.31+stretch~1.gbp0912bd

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wse6`
--

-- --------------------------------------------------------

--
-- Table structure for table `alert_printer`
--

CREATE TABLE `alert_printer` (
  `id` int(11) NOT NULL,
  `alert_id` int(11) NOT NULL,
  `alert_position` varchar(20) CHARACTER SET latin1 NOT NULL,
  `alert_type` varchar(20) CHARACTER SET latin1 NOT NULL,
  `alert_timer` int(11) NOT NULL,
  `alert_msg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `alert_printer`
--

INSERT INTO `alert_printer` (`id`, `alert_id`, `alert_position`, `alert_type`, `alert_timer`, `alert_msg`) VALUES
(1, 1, 'bottom-left', 'error', 5000, 'حدث خطأ ولم تتم عملية الشراء'),
(2, 2, 'bottom-left', 'success', 5000, 'تم إضافة الرصيد بنجاح'),
(3, 3, 'bottom-left', 'error', 5000, 'من فضلك تأكد من المدخلات');

-- --------------------------------------------------------

--
-- Table structure for table `apply_requests`
--

CREATE TABLE `apply_requests` (
  `id` int(11) NOT NULL,
  `requester` int(11) NOT NULL,
  `requestrank` int(11) NOT NULL,
  `request_msg` varchar(280) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cardsPayments`
--

CREATE TABLE `cardsPayments` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `card` text NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cardsPayments`
--

INSERT INTO `cardsPayments` (`id`, `cid`, `pid`, `price`, `card`, `type`, `status`) VALUES
(1, 112, 16, 25, '3453454353453453', 50, 1),
(2, 112, 16, 25, '4353453453453453', 100, 2),
(3, 112, 17, 5, '2342343453453454', 50, 1),
(4, 112, 18, 5, '2342343453453454', 50, 2),
(5, 110, 19, 10, '5151515151515151', 50, 1),
(6, 110, 19, 10, '5315134543151345', 30, 1),
(7, 110, 20, 10, '5151515151515151', 50, 1),
(8, 110, 20, 10, '5315134543151345', 30, 1),
(9, 110, 21, 10, '5151515151515151', 50, 1),
(10, 110, 21, 10, '5315134543151345', 30, 1),
(11, 110, 22, 10, '5151515151515151', 50, 1),
(12, 110, 22, 10, '5315134543151345', 30, 1),
(13, 110, 23, 10, '5151515151515151', 50, 1),
(14, 110, 23, 10, '5315134543151345', 30, 1),
(15, 110, 24, 10, '5151515151515151', 50, 1),
(16, 110, 24, 10, '5315134543151345', 30, 1),
(17, 110, 25, 10, '5151515151515151', 50, 1),
(18, 110, 25, 10, '5315134543151345', 30, 1),
(19, 112, 26, 20, '111111111111111', 100, 1),
(20, 112, 26, 20, '222222222222222', 30, 4),
(21, 112, 26, 20, '4365456456456436', 30, 4),
(22, 110, 27, 15, '1213123123123123', 100, 1),
(23, 110, 27, 15, '2312312312321331', 20, 1),
(24, 110, 28, 15, '1231231231231231', 100, 4),
(25, 110, 28, 15, '2312312312312312', 20, 4),
(26, 110, 29, 15, '2141241241241241', 50, 4),
(27, 110, 29, 15, '2412412424124214', 50, 4),
(28, 110, 29, 15, '1241241212412411', 20, 4),
(29, 112, 30, 10, '2345432545345435', 100, 4),
(30, 112, 31, 10, '3453453453453454', 50, 1),
(31, 112, 31, 10, '6546436456456456', 30, 1),
(32, 110, 32, 15, '143459876543967', 100, 4),
(33, 110, 32, 15, '1231231231212321', 20, 4),
(34, 112, 33, 15, '2342342342342342', 20, 4),
(35, 112, 33, 15, '2345345345345453', 25, 4),
(36, 112, 33, 15, '3453465456456456', 25, 4),
(37, 112, 33, 15, '3453453453454553', 50, 4),
(38, 109, 34, 15, '3284177432841267', 100, 1),
(39, 109, 34, 15, '3284177432841222', 20, 1),
(40, 109, 35, 5, '655437563756462', 20, 4),
(41, 109, 35, 5, '655437563756463', 20, 4),
(42, 133, 36, 15, '1233342424242424', 20, 1),
(43, 133, 36, 15, '1111111111111111', 100, 1),
(44, 110, 37, 15, '5315151251512512', 25, 4),
(45, 110, 37, 15, '1251251251251251', 100, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Customers`
--

CREATE TABLE `Customers` (
  `id` int(11) NOT NULL,
  `username` varchar(16) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `email` varchar(254) DEFAULT NULL,
  `phonenumber` varchar(20) DEFAULT NULL,
  `Credits` float DEFAULT '0',
  `img` text,
  `verify` int(11) DEFAULT '0',
  `verifyCode` varchar(80) DEFAULT NULL,
  `createdTime` int(11) NOT NULL DEFAULT '0',
  `rank` int(11) NOT NULL DEFAULT '0',
  `isStaff` int(11) NOT NULL DEFAULT '0',
  `lastupname` int(11) NOT NULL DEFAULT '0',
  `lastphonechanged` int(11) NOT NULL DEFAULT '0',
  `lastpwdu` int(11) NOT NULL DEFAULT '0',
  `lastavatar` int(11) NOT NULL DEFAULT '0',
  `timeresetpass` int(11) NOT NULL DEFAULT '0',
  `resetpass` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Customers`
--

INSERT INTO `Customers` (`id`, `username`, `password`, `email`, `phonenumber`, `Credits`, `img`, `verify`, `verifyCode`, `createdTime`, `rank`, `isStaff`, `lastupname`, `lastphonechanged`, `lastpwdu`, `lastavatar`, `timeresetpass`, `resetpass`) VALUES
(109, 'ML7oS', '$2y$10$wKd/FWPxbMAxNWZD4E/4BeYhwLvGVCbCalYr.wugAcd/92ViByoMW', 'ml7osyt@gmail.com', '0533599890', 999, 'https://i.imgur.com/ODZPqjS.jpg', 1, '0b939df7f3dc244c24a348f363d421bef4f41c7363a28056bdd22665', 1533744752, 5, 1, 0, 0, 0, 1551995861, 0, 0),
(110, 'Faris', '$2y$10$wnZAjLUkvbSjVztLyvVS2ewgscp5gDwd1YBJJyl1MQOkg5kcF9qWW', 'irealfaris@gmail.com', '0553487093', 41.65, 'https://i.imgur.com/pWkWsXL.jpg', 1, '075aee5700bdd8023438919c8c8e153f6b098ac615c8', 1533750928, 5, 1, 1548701206, 0, 1548700826, 1552062054, 1552336657, 1),
(112, 'abod1913', '$2y$10$XhsjtIIA5GFrwIfJ9ddScOcMNguNA/MnBqgUS/YonGf4i.E2TBcs2', 'abdualrhmans.p.q@gmail.com', '966536882682', 155.35, 'https://i.imgur.com/WWl7peB.png', 1, '09f6c6ca216d0427c16b1606db4be274629db84fb464', 1533864655, 5, 1, 1551427827, 1550888657, 1551424948, 1551426640, 1551143461, 1),
(122, 'Fariseueueueieie', '$2y$10$AATpyVjVYAgCS68.j22RYemKXFK.VDOpPN0A6Fgp9AukVjUuroxre', 's9901yuu501@gmail.com', '05747483838', 0, '', 0, '98a8428c09cc18c25e1f29514a82c97b4fd63948342729b6ff6313f0', 1540452798, 0, 0, 0, 0, 0, 0, 0, 0),
(126, 'abdualrhman1', '$2y$10$7dtzx8TbmwWFl307TF3H9OsdRjxiBY8Ra9MQ9.bz6Vu3eCoc7ImUC', '2fa0922ff7@mailox.fun', ' 966536882682', 0, NULL, 1, '183cee69251934bd88ba9361cd73870260bea97329dd0ad7e6512a80', 1547558736, 0, 0, 0, 0, 0, 0, 0, 0),
(127, 'abdualrhman19132', '$2y$10$vO8LrPRfX/BCa5.MjrMBz.JhHmGm9pZBUBPNWXKRfcESngdhKYlQS', 'spq1913@gmail.com', '0555555555', 0, NULL, 0, 'd9202a5655d7da9b814467a5dcb57542481b13436ebb30dc5e595b1b', 1550882140, 0, 0, 0, 0, 0, 0, 0, 0),
(128, 'Muhanad', '$2y$10$erDrvjByUwiQ2tmpjUYaR.gxFN4xREBVsi33.T8H3YnLSV3Hm0vnC', 'mohan1d.ab@gmail.com', '0548350131', 0, NULL, 1, '3e402a17e109bec23ab1489afcac94a1bb25651ba7832afee05571b1', 1550882154, 3, 1, 0, 0, 0, 0, 0, 0),
(130, 'abdualrhn194132', '$2y$10$TNJvJv07FRiDrClhsI9f.uzwhANDEucpasFhGgafBZMRChVb.Tx9K', 'spq19132@gmail.com', '966536882682', 0, NULL, 0, '80595b3da035790f19fe382310df39e0a70aeaa762b7e452e3a1eb87', 1550883240, 0, 0, 0, 0, 0, 0, 0, 0),
(131, 'abd5lrhn144132', '$2y$10$CKR5BXHkOuFkNi.6ekBpd.Pu04GJ5VZvIOnqAfTcWUQBt8VbZKoNC', 'spq66332@gmail.com', '05368826', 0, NULL, 0, '3c624a7d921012895cb1462df1ecc3f40a28615e6027d71d287ed96c', 1550883421, 0, 0, 0, 0, 0, 0, 0, 0),
(132, 'N3SAN', '$2y$10$IBaySTBZ1Vh8vj1ucRksAuLMlqDaHbr1wIoGHGlkxKrTIFC5hdGMy', 'aaobaid2012@hotmail.com', '056446843', 4.1, NULL, 1, 'b7fdf0238566ebf7ae9e8575594b10db87eaf431bb6bcf7cb915d9eb', 1551399291, 1, 1, 1551400315, 1551400352, 0, 0, 0, 0),
(133, 'umar', '$2y$10$pyCAJzaasZMNtt/PFyKX6OCWOiHz0nRkHNTBuVz7BxAVMAm8dZCLy', 'o20121900@gmail.com', '05019657803', 113.6, 'https://i.imgur.com/ucmJ7eE.jpg', 1, '34641668ca4ccb313823e44bae8cb4f38a0cc75a93b0', 1551990660, 0, 0, 1551994824, 1551994850, 0, 1551994741, 1552250208, 1),
(134, 'Mohammed1999', '$2y$10$6s3dRNqARdmkjhERoNlyCOm1/nvzBVO15F8x2XDyUEr1Grp0mry5G', 'sloomy@outlook.com', '0570700866 ', 0, NULL, 0, 'f143dcae6cfb6b48baf6f7dce3f8e1f9e887b98011ac032e3d9ec755', 1552080470, 0, 0, 0, 0, 0, 0, 0, 0),
(135, 'KaSPeR1999', '$2y$10$ZxC7wJm/x4fi/WMBMb13i.v7D/.FMRH0fiC25LOOoPxp3SEAtigzq', 'sloomn@outlook.com', '0570700866 ', 0, NULL, 0, 'd7451595c3fd7627678de89a5c7fc5a48c4ff737c24ed566427c6f1d', 1552080682, 0, 0, 0, 0, 0, 0, 0, 0),
(136, '1RBRx', '$2y$10$jwcxTD1TPo/7jP5XoFe.FeWw/truj7u6PahXC3sLiPQIl1OdoCQb2', 'zn.b@mail.com', '962788814209', 0, NULL, 0, '1be0348bd3c90f4b3bcc43501c2fc823af4c5103e7976ca7ede1460a', 1552083803, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mediations`
--

CREATE TABLE `mediations` (
  `id` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `describes` varchar(256) NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `mid_accepted` int(11) NOT NULL DEFAULT '0',
  `accept_code` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mediations`
--

INSERT INTO `mediations` (`id`, `creator`, `type`, `describes`, `status`, `create_time`, `mid_accepted`, `accept_code`) VALUES
(14, 109, 1, 'hello :)', 0, 1552083224, 0, NULL),
(15, 109, 5, 'خخشثن', 1, 1552130709, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mediations_reply`
--

CREATE TABLE `mediations_reply` (
  `id` int(11) NOT NULL,
  `reply_id` int(11) NOT NULL,
  `reply_mid` int(11) NOT NULL,
  `reply_text` varchar(256) NOT NULL,
  `mid_price` float NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `notification` varchar(70) CHARACTER SET utf8 NOT NULL,
  `time` int(11) NOT NULL,
  `cid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `notification`, `time`, `cid`) VALUES
(48, 'اهلا بك في موقع وسيط', 1534069256, 11),
(53, 'اهلا بك في موقع وسيط', 1534069256, 11),
(54, 'اهلا بك في موقع وسيط', 1534069256, 11),
(57, 'اهلا بك في موقع وسيط', 1534069256, 11),
(58, 'اهلا بك في موقع وسيط', 1534069256, 11),
(59, 'اهلا بك في موقع وسيط', 1534069256, 11),
(60, 'اهلا بك في موقع وسيط', 1534069256, 11),
(61, 'اهلا بك في موقع وسيط', 1534069256, 11),
(62, 'اهلا بك في موقع وسيط', 1534069256, 11),
(63, 'اهلا بك في موقع وسيط', 1534069256, 11),
(64, 'اهلا بك في موقع وسيط', 1534069256, 11),
(65, 'اهلا بك في موقع وسيط', 1534069256, 11),
(66, 'اهلا بك في موقع وسيط', 1534069256, 11),
(67, 'اهلا بك في موقع وسيط', 1534069256, 11),
(68, 'اهلا بك في موقع وسيط', 1534069256, 11),
(69, 'اهلا بك في موقع وسيط', 1534069256, 11),
(70, 'اهلا بك في موقع وسيط', 1534069256, 11),
(71, 'اهلا بك في موقع وسيط', 1534069256, 11),
(72, 'اهلا بك في موقع وسيط', 1534069256, 11),
(73, 'اهلا بك في موقع وسيط', 1534069256, 11),
(75, 'لقد استلمت مبلغ:2 من FARIS', 1537548632, 0),
(77, 'لقد استلمت مبلغ:3 من FARIS', 1537548680, 0),
(79, 'لقد استلمت مبلغ:1 من FARIS', 1537548698, 0),
(81, 'لقد استلمت مبلغ:2 من FARIS', 1537549158, 0),
(83, 'لقد استلمت مبلغ:3 من FARIS', 1537549162, 0),
(85, 'لقد استلمت مبلغ:10 من FARIS', 1537549165, 0),
(87, 'لقد استلمت مبلغ:10 من FARIS', 1537553004, 0),
(89, 'لقد استلمت مبلغ:10 من FARIS', 1537553022, 0),
(91, 'لقد استلمت مبلغ:-8.5 من FARIS', 1537553118, 0),
(93, 'لقد استلمت مبلغ:-8.5 من ML7oS', 1537553379, 0),
(95, 'لقد استلمت مبلغ:18.5 من ML7oS', 1537553453, 0),
(97, 'لقد استلمت مبلغ:11.5 من ML7oS', 1537553551, 0),
(99, 'لقد استلمت مبلغ:8.5 من ML7oS', 1537553839, 0),
(101, 'لقد استلمت مبلغ:8.5 من ML7oS', 1537553934, 0),
(136, 'لقد استلمت مبلغ:8.5 من ML7oS', 1552083267, 110);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0',
  `method` int(11) NOT NULL DEFAULT '0',
  `email` varchar(300) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `firstname` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `lastname` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `token` varchar(500) DEFAULT NULL,
  `payerid` varchar(200) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `cid`, `price`, `method`, `email`, `status`, `firstname`, `lastname`, `token`, `payerid`, `country`, `time`) VALUES
(6, 109, 0, 1, 'IAmSkillsYT@gmail.com', 1, '', '', 'EC-6YP25161F04602743', '9WEXSU4YTMEFA', 'SA', 1533757172),
(7, 109, 0, 1, 'IAmSkillsYT@gmail.com', 1, '', '', 'EC-2M716034RG2809448', '9WEXSU4YTMEFA', 'SA', 1533837793),
(8, 112, 0, 1, 'payments@t2d.store', 1, '', '', 'EC-1TN80582BK952181A', 'QTATWZHREQ4RJ', 'SA', 1534395974),
(9, 112, 0, 1, 'payments@t2d.store', 1, '', '', 'EC-84X09484KH2543600', 'QTATWZHREQ4RJ', 'SA', 1534396024),
(16, 112, 25, 2, '', 1, '', '', '', '', '', 1545659764),
(17, 112, 5, 2, '', 1, '', '', '', '', '', 1545835130),
(18, 112, 5, 2, '', 1, '', '', '', '', '', 1545835134),
(19, 110, 10, 2, '', 1, '', '', '', '', '', 1545857106),
(20, 110, 10, 2, '', 1, '', '', '', '', '', 1545857117),
(21, 110, 10, 2, '', 5, '', '', '', '', '', 1545857121),
(22, 110, 10, 2, '', 1, '', '', '', '', '', 1545857129),
(23, 110, 10, 2, '', 1, '', '', '', '', '', 1545857143),
(24, 110, 10, 2, '', 1, '', '', '', '', '', 1545857147),
(25, 110, 10, 2, '', 1, '', '', '', '', '', 1545857151),
(26, 112, 20, 2, '', 1, '', '', '', '', '', 1546299864),
(27, 110, 15, 2, '', 1, '', '', '', '', '', 1546311454),
(28, 110, 15, 2, '', 4, '', '', '', '', '', 1546311472),
(29, 110, 15, 2, '', 4, '', '', '', '', '', 1546491063),
(30, 112, 10, 2, '', 5, '', '', '', '', '', 1546491083),
(31, 112, 10, 2, '', 1, '', '', '', '', '', 1546634563),
(32, 110, 15, 3, '', 4, '', '', '', '', '', 1546850224),
(33, 112, 15, 2, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1551443595),
(34, 109, 15, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1551461713),
(35, 109, 5, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1551995544),
(36, 133, 15, 2, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1551995545),
(37, 110, 15, 2, NULL, 4, NULL, NULL, NULL, NULL, NULL, 1552066901);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `title` varchar(32) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `title`) VALUES
(1, 'تواصل إجتماعي'),
(2, 'البلاي ستيشن'),
(3, 'العاب الكمبيوتر'),
(4, 'قسم فارس'),
(5, 'العاب الجوال'),
(6, 'العاب التسلية'),
(7, 'العاب بنات'),
(8, 'بابلو للإلعاب'),
(9, 'qwtwqet');

-- --------------------------------------------------------

--
-- Table structure for table `sitesettings`
--

CREATE TABLE `sitesettings` (
  `closeSite` int(11) NOT NULL DEFAULT '0',
  `closeapply` int(11) NOT NULL DEFAULT '0',
  `closepaypal` int(11) NOT NULL DEFAULT '0',
  `closestc` int(11) NOT NULL DEFAULT '0',
  `closemobily` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sitesettings`
--

INSERT INTO `sitesettings` (`closeSite`, `closeapply`, `closepaypal`, `closestc`, `closemobily`) VALUES
(0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `creator` int(11) DEFAULT '0',
  `title` varchar(64) DEFAULT NULL,
  `msg` varchar(260) DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  `time` int(11) DEFAULT '0',
  `forwho` int(11) DEFAULT '0',
  `for_rank` int(11) DEFAULT '0',
  `needed_see` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `creator`, `title`, `msg`, `type`, `status`, `time`, `forwho`, `for_rank`, `needed_see`) VALUES
(23, 109, 'شكوى على وسيط', 'ابشتكي على ملحوس\n', 3, 0, 1546486339, 110, 5, 0),
(24, 112, 'طلب أرباجي', 'الأرباح : 155.35', 5, 0, 1546897079, 0, 0, 0),
(25, 110, 'طلب أرباحي', 'الأرباح : 24.45', 5, 0, 1547214037, 0, 0, 0),
(26, 110, 'طلب أرباحي', 'الأرباح : 24.45', 5, 0, 1547215229, 0, 0, 0),
(27, 109, 'كيف اخذ فلوس', 'كيف اخذ فلوس ؟؟؟؟', 1, 0, 1546897079, 0, 0, 0),
(28, 128, 'تجربة', 'هلا كيف الحال انا مهند عبدالله', 2, 0, 1550882583, 0, 0, 0),
(29, 112, 'werwerwerwer', 'sdfsd4ewrtesdfgfgd', 2, 0, 1550884525, 0, 0, 0),
(30, 132, 'قرنبيط', 'الحين القرنبيط وش لونه ؟', 1, 0, 1551399792, 0, 0, 0),
(31, 132, 'موز', 'ما لون الموز ؟', 1, 0, 1551400500, 0, 0, 0),
(32, 109, 'طلب أرباحي', 'الأرباح : 78.35', 5, 0, 1551461174, 0, 5, 0),
(33, 133, 'فثسففف', 'فففف', 2, 2, 1551995562, 0, 0, 0),
(34, 109, 'طلب أرباحي', 'الأرباح : 998', 5, 0, 1551996661, 0, 5, 0),
(35, 110, 'طلب أرباحي', 'الأرباح : 20.4', 5, 0, 1552064171, 0, 5, 0),
(36, 110, 'واحد مب عاجبني', 'واحد قاهرني اسمه ملحوس مايرد علي\n', 4, 0, 1552064913, 0, 0, 0),
(37, 109, 'طلب أرباحي', 'الأرباح : 1003.5', 5, 1, 1552083248, 0, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `reply` varchar(260) CHARACTER SET utf8 NOT NULL,
  `replyfrom` int(11) NOT NULL,
  `reply_time` int(11) NOT NULL,
  `from_rank` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket_replies`
--

INSERT INTO `ticket_replies` (`id`, `tid`, `reply`, `replyfrom`, `reply_time`, `from_rank`) VALUES
(41, 21, 'qwerqwr', 110, 1545866245, 0),
(42, 21, 'qwerqr', 110, 1545866249, 0),
(43, 21, 'ewq', 110, 1545866267, 0),
(44, 21, 'wqeqweqwe', 110, 1545866269, 0),
(45, 21, 'wqewqewqeqe', 110, 1545866270, 0),
(46, 21, 'مرحبا بكم اخواني', 110, 1546205667, 0),
(47, 21, 'ق', 110, 1546213583, 0),
(48, 21, 'ثضص', 110, 1546213675, 0),
(49, 21, 'ضصثضث', 110, 1546213779, 0),
(50, 21, 'ضصقضص', 110, 1546213814, 0),
(51, 21, '124124', 110, 1546213872, 0),
(52, 21, 'wqrwqrqwr', 110, 1546213943, 0),
(53, 21, 'qweqwe', 110, 1546213974, 0),
(54, 21, 'll', 110, 1546214001, 0),
(55, 22, '1', 110, 1546385306, 0),
(56, 23, 'ليه ؟', 110, 1546486474, 0),
(57, 23, 'ضثصض', 110, 1546486480, 0),
(58, 23, '123', 110, 1546486546, 0),
(59, 25, '21341324', 110, 1547370689, 0),
(60, 25, 'qweqe', 110, 1547371046, 0),
(61, 25, 'مرحبل', 110, 1547371073, 0),
(62, 25, 'ضص', 110, 1547371114, 0),
(63, 25, 'صثضق', 110, 1547371115, 0),
(64, 25, 'ضثصفص', 110, 1547371117, 0),
(65, 27, 'عن طريق زفت الزفت', 110, 1547371365, 0),
(66, 27, 'فهمت ولا لا', 110, 1547371383, 0),
(67, 27, 'جاوبني', 110, 1547371416, 0),
(68, 27, 'لاالعن والدينك', 110, 1547371419, 0),
(69, 23, 'rewqrqwr', 110, 1547371694, 0),
(70, 23, 'wqerwqer', 110, 1547371696, 0),
(71, 30, 'لونه أصفر.', 109, 1551399882, 0),
(72, 30, 'شكرا', 132, 1551399946, 0),
(73, 30, 'عفوا', 109, 1551399980, 0),
(74, 33, 'كككككككك', 109, 1551995718, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alert_printer`
--
ALTER TABLE `alert_printer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apply_requests`
--
ALTER TABLE `apply_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cardsPayments`
--
ALTER TABLE `cardsPayments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Customers`
--
ALTER TABLE `Customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mediations`
--
ALTER TABLE `mediations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mediations_reply`
--
ALTER TABLE `mediations_reply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator` (`creator`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tid` (`tid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alert_printer`
--
ALTER TABLE `alert_printer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `apply_requests`
--
ALTER TABLE `apply_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `cardsPayments`
--
ALTER TABLE `cardsPayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `Customers`
--
ALTER TABLE `Customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;
--
-- AUTO_INCREMENT for table `mediations`
--
ALTER TABLE `mediations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `mediations_reply`
--
ALTER TABLE `mediations_reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
