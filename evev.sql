-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018 年 5 月 25 日 06:51
-- サーバのバージョン： 5.7.17
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evev`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `event`
--

CREATE TABLE `event` (
  `eventID` int(8) NOT NULL,
  `holderID` int(8) NOT NULL,
  `name` varchar(400) NOT NULL,
  `category` varchar(20) NOT NULL,
  `organisation` varchar(10) NOT NULL,
  `location` varchar(50) NOT NULL,
  `eventDateTime` datetime DEFAULT NULL,
  `description` varchar(10000) DEFAULT NULL,
  `image1` varbinary(10000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `event`
--

INSERT INTO `event` (`eventID`, `holderID`, `name`, `category`, `organisation`, `location`, `eventDateTime`, `description`, `image1`) VALUES
(15480811, 10750463, 'Sheep and Goats', 'PARTY', 'UQ', 'UQ', '2018-06-01 12:40:00', 'As part of a semesterly drama course offered by UQ, students create a public production of classic and modern playtexts alike. \r\nJoin us on the 1st of June in the Geoffrey Rush Drama Studio (beneath Schonell Theatre) for UQ Drama’s “Sheep and Goats”. ediiii\r\n', 0x75706c6f61642f33323731303831325f313438363039323033313439363537365f363431333531373533363033333234333133365f6e2e6a7067),
(30095723, 42696851, '1 First ', 'PARTY', 'Griffith', '??', '2020-07-20 10:40:00', 'second oldest company and largest ASX listed owner, operator and developer of renewable energy to thrive in a carbon constrained future. Educated in New York\r\n', 0x75706c6f61642f6e65746d656574696e672e6a7067),
(42048759, 99343014, 'TWILIGHT CITY WALKING TOURS', 'MEET-UP', 'Griffith', 'Gold Coast city', '2018-09-13 14:40:00', 'iscover the beauty of \r\n', 0x75706c6f61642f696d616765732e6a7067),
(56402387, 99343014, 'Play Your Way!', 'CLUB', 'UQ', 'UQ', '2018-07-19 16:00:00', 'At UQ Sport, there’s 75+ sports and activities to choose from, including 90+ group fitness classes, 30+ sporting clubs and 10+ social sports. Discover all the sporting options, and explore our world-class venues, at our short Play Your Way presentation.\r\n', 0x75706c6f61642f363630333335703637363445444e4d61696e3230353532383175715f747261636b5f363930783335302e6a7067),
(71424940, 75801969, 'CULTURAL MORNING TEA', 'CLUB', 'QUT', 'UQ', '2019-09-10 12:40:00', 'Join the Griffith Mates for a free morning tea, cultural games and activities in Week 3. Drop by to enjoy a cool drink, a delicious spread of snacks and meet other students studying in Trimester 1. There is no need to register and everyone is welcome.\r\n', 0x75706c6f61642f61727469636c652d31312d6865726f2e6a7067),
(84726286, 10750463, 'Harry Potter and the Deathly Hangover', 'CLUB', 'UQ', 'UQ', '2018-08-25 13:00:00', 'Before we begin this crawl, we would like to say a few words. And here they are: \r\n\r\nNitwit! Blubber! Oddment! Tweak!\r\nNow onto the more important information….you would be riddikulus to miss out on this pub crawl! We’re being sirius here...', 0x75706c6f61642f696d61676573342e6a7067),
(96612336, 36290779, 'Wedding Garden Party', 'CASUAL-LUNCH', 'QUT', 'QUT', '2019-06-08 11:30:00', 'The pleasure of your company is requested at our free family day out on the lawns of Old Government House.\r\n', 0x75706c6f61642f626573742d636c7562732d6b75616c612d6c756d7075722e6a7067);

-- --------------------------------------------------------

--
-- テーブルの構造 `joinEventUser`
--

CREATE TABLE `joinEventUser` (
  `joinID` int(8) NOT NULL,
  `joinEventID` int(8) NOT NULL,
  `joinUserID` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `user`
--

CREATE TABLE `user` (
  `id` int(8) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `password`, `email`) VALUES
(1, 'Masanari', 'Tsutsumi', 'masa8424', 'pass1234', 'c.bao@uq.net.au'),
(10750463, 'Daniel', 'Zhao', '1074408445@qq.com', '$2y$10$OCwfNESATGgci.02gqX98OI4LopEvOusQxSQuCwRshn3pxwfOguC6', '1074408445@qq.com'),
(11185700, 'Cheng', 'Bao', 'cheng2404', '$2y$10$Ej6RfXsDWyYetm9w7B.yDur58lhCw0mFk7SL2nhnMsJS.V8iz//JC', 'c.bao@uqconnect.edu.au'),
(22100500, 'Margarent', 'Lie', 'Margarent', '$2y$10$/qEuguib5lRboUQUrljSMeI/tk.Ml3IrvaGiGwC9NK6cxcV7QX4a2', 'Lie5666@icloud.com'),
(34695146, 'wewtre', 'dasdfsa', 'gdgdgdg', '$2y$10$bbS/OdZDEOlP2u7Zsx3FduAYDAlhMsv1nnQrPgAZIQYf1efjbgb06', 'gygdagd@agdjhb.com'),
(36290779, 'haahah', 'hahhaha', 'jijam', '$2y$10$ttnadZluRWSzusoUTZ7.n.yd0n9UUSv4icFPmQg7.4SqnaBY5nR7.', '1323244@qq.com'),
(42696851, 'qwqq', 'qwqq', 'qwqw', '$2y$10$Ma1oyjnhKJFZr/LaGifdgeRh/WCTt1C8L7FeX6zVjMGWd2QWPDlaO', 'qwqwqw@qq.com'),
(49698496, 'Davie', 'Jone', 'Davie', '$2y$10$RuBBFlWxHmLKa83bovuJtuOSucs/8oTKVYkInbSKK0OMIWidyiUYq', 'david@gmail.com'),
(50080731, 'sdfwx', 'wsf', 'dadsfxsx', '$2y$10$kgKto8v8vWE5Ws5Y155uEua9K9pCCN9nbr8x7nGOsbI5fV0jphmda', 'xxf@sdfegc.com'),
(57703772, 'asdfdfd', 'sassd', 'saasa', '$2y$10$W.2CGto4wIsUg0GTTu9b5uePX4SAiHVAZM/SzEU7FlyqovikmJDWG', '647326@qq.com'),
(75801969, 'bebe', 'bebe', 'Rachellllll', '$2y$10$8CHMvCzICBMAkmNM3WB1YuCbuL8ef5Xr/inDjf8G/MZKcZj1g4dpy', 'bennn55@gmail.com'),
(93431865, 'asdas', 'dasdas', 'sadasd', '$2y$10$NN.U3hcnA8aPSzbDZVG5Surg/B9yU7.WJ2SvMw1D6q5Q2UmSgDnya', '182272727@qq.com'),
(99343014, 'chengcheng', 'Bao', 'Bao111', '$2y$10$Ij76ZTRxJe94Gp5x2WUrpu5QPRbzHFuAjvW.wlC32k3MHNScPDKdO', 'bcc07333@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`eventID`),
  ADD KEY `eventHold` (`holderID`);

--
-- Indexes for table `joinEventUser`
--
ALTER TABLE `joinEventUser`
  ADD PRIMARY KEY (`joinID`),
  ADD KEY `joinEvent` (`joinEventID`),
  ADD KEY `joinUser` (`joinUserID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `eventHold` FOREIGN KEY (`holderID`) REFERENCES `user` (`id`);

--
-- テーブルの制約 `joinEventUser`
--
ALTER TABLE `joinEventUser`
  ADD CONSTRAINT `joinEvent` FOREIGN KEY (`joinEventID`) REFERENCES `event` (`eventID`),
  ADD CONSTRAINT `joinUser` FOREIGN KEY (`joinUserID`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
