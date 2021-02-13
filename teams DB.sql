-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2019 at 12:12 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teams`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(7) NOT NULL,
  `EID` varchar(365) NOT NULL,
  `banner` text NOT NULL,
  `title` varchar(80) NOT NULL,
  `host` text NOT NULL,
  `description` text NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `uploader` varchar(365) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `id` int(9) NOT NULL,
  `Tid` varchar(20) NOT NULL,
  `issue_id` varchar(360) NOT NULL,
  `issue_head` text NOT NULL,
  `issue_description` text NOT NULL,
  `uploader` varchar(360) NOT NULL,
  `severity` varchar(360) NOT NULL,
  `data_raised` datetime NOT NULL,
  `solved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`id`, `Tid`, `issue_id`, `issue_head`, `issue_description`, `uploader`, `severity`, `data_raised`, `solved`) VALUES
(1, '2cqn654', 'Mon102019102019083131CEST47_ISSUE_5da41b3f5d3f46.51422013', 'New Equipment Required', 'New Equipment is required by the Choir and other teams to replace the old equipment currently in service.', '7754657894564654', 'Medium', '2019-10-14 08:52:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lyrics`
--

CREATE TABLE `lyrics` (
  `id` int(9) NOT NULL,
  `LID` varchar(360) NOT NULL,
  `song` text NOT NULL,
  `singer` varchar(80) NOT NULL,
  `lyrics` text NOT NULL,
  `uploader` varchar(360) NOT NULL,
  `lyrics_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lyrics`
--

INSERT INTO `lyrics` (`id`, `LID`, `song`, `singer`, `lyrics`, `uploader`, `lyrics_date`) VALUES
(2, 'SepSun201908th0930_lyrics_5d90563fa96065@68079953', 'Phakama', 'Jeff', 'Phakama! Nkosi yeZulu (Arise! King of the heavens)\\r\\nPhakama! Nkosi yeZulu (Arise! King of the heavens)\\r\\nUwengamele umhlaba wonke (And reign over all)\\r\\nUwengamele wonkumhlaba (And reign over the whole earth)', '7754657894564675', '2019-09-29 09:57:45'),
(3, 'SepSun201909th0930_lyrics_5d9056df178fb3@10986014', 'Give you all the glory', 'Joyous Celebration ', 'Give you all the glory, give you all the praises\\r\\nGive you all the glory, you alone deserve it\\r\\nHallelujah, hallelujah\\r\\nHallelujah you alone deserve it\\r\\nSikunik\\\' inkazimulo, sikunika udumo\\r\\nSikunik\\\' inkazimulo wena ufanelwe\\r\\nHallelujah, hallelujah\\r\\nHallelujah wena ufanelwe\\r\\nGreat are you Lord most high you reign forever more\\r\\nGreat are you Lord most high you rule victoriously...\\r\\nHallelujah, hallelujah\\r\\nHallelujah you alone deserve it\\r\\nWe raise our voices to you O\\\'Lord\\r\\nWe declare that your name is great', '7754657894564675', '2019-09-29 10:00:24'),
(4, 'SepSun201909th0930_lyrics_5d90576a6f6437@26773189', 'Wena wedwa', 'Thee legacy', 'Right here with me its where you belong can i see,\\r\\nNgifuna wena wedwa\\r\\nCan i feel, ngifuna wena wedwa oh haaam;\\r\\nThrough thick and thin i still choose to be with you,\\r\\nNgifuna wena wedwa\\r\\nTo be with you, ngifuna wena wedwa\\r\\nSo i will, care for you,\\r\\ni will give you all, all that you deserve cause i love you baby;\\r\\nI will care for you, i will give all,\\r\\nall that you deserve cause i love you baby;\\r\\nNgi-funa wena wedwa,\\r\\nNgi-funa wena wedwa,\\r\\nNgi-funa wena wedwa,\\r\\nNgi-funa wena wedwa haaam,\\r\\nYou make me realize just how much you mean,\\r\\nNgifuna wena wedwa,\\r\\nYou mean to me, ngifuna wena wedwa ooh haaam,\\r\\nYou mean the world to me cause i love you,\\r\\nNgifuna wena wedwa,\\r\\nI love you, ngifuna wena wedwa ooh,\\r\\n', '7754657894564675', '2019-09-29 10:02:44')
;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(4) NOT NULL,
  `TID` varchar(10) NOT NULL,
  `team` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `TID`, `team`) VALUES
(1, 'mega1999', 'choir'),
(2, '2cqn654', 'technical'),
(3, 'mc775', 'mc');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(9) NOT NULL,
  `PID` varchar(360) NOT NULL,
  `UID` text NOT NULL,
  `category` varchar(25) NOT NULL,
  `title` text NOT NULL,
  `upload_text` text NOT NULL,
  `attachment` text NOT NULL,
  `upload_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploads`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `UID` varchar(350) NOT NULL,
  `Firstname` varchar(30) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `EmailAddress` varchar(150) NOT NULL,
  `Username` varchar(150) NOT NULL,
  `Password` text NOT NULL,
  `team` varchar(15) NOT NULL COMMENT 'team name',
  `role` int(3) NOT NULL,
  `photo` text NOT NULL,
  `Tid` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `UID`, `Firstname`, `Lastname`, `EmailAddress`, `Username`, `Password`, `team`, `role`, `photo`, `Tid`) VALUES
(1, '7754657894564654', 'Ronald', 'Ngwenya', '1999roniengwe@gmail.com', 'Ronnie', 'bef6db60202e35d43117b02ee7cbb120', 'technical', 0, 'user/dev.jpg', '2cqn654'),
(3, '7754657894564675', 'Ashton', 'Sixpence', 'Ashy@localhost', 'Ashy', 'bef6db60202e35d43117b02ee7cbb120', 'choir', 0, 'user/profile1.jpg', 'mega1999'),
(4, '5462164246542315623154231', 'Admin', 'MC Admin', 'MC@localhost', 'mc_admin', 'bef6db60202e35d43117b02ee7cbb120', 'mc', 0, 'user/mc.jpg', 'mc775'),

-- --------------------------------------------------------

--
-- Table structure for table `_user_roles`
--

CREATE TABLE `_user_roles` (
  `id` int(2) NOT NULL,
  `TID` varchar(10) NOT NULL,
  `role` varchar(20) NOT NULL,
  `value` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_user_roles`
--

INSERT INTO `_user_roles` (`id`, `TID`, `role`, `value`) VALUES
(1, 'all', '0', 'admin'),
(2, 'mega1999', '1', 'singer'),
(3, 'mc775', '2', 'mc'),
(4, 'all', '3', 'leader'),
(5, '2cqn654', '4', 'monitor'),
(6, '2cqn654', '5', 'projector'),
(7, '2cqn654', '6', 'photographer'),
(8, '2cqn654', '7', 'media'),
(9, 'mega1999', '8', 'b-vocal'),
(10, 'mega1999', '9', 'drummer'),
(15, 'mega1999', '10', 'pianist'),
(16, 'mega1999', '11', 'bassist');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `EID` (`EID`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`,`issue_id`);

--
-- Indexes for table `lyrics`
--
ALTER TABLE `lyrics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `LID` (`LID`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `TID` (`TID`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `PID` (`PID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UID` (`UID`),
  ADD UNIQUE KEY `EmailAddress` (`EmailAddress`);

--
-- Indexes for table `_user_roles`
--
ALTER TABLE `_user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `value` (`value`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lyrics`
--
ALTER TABLE `lyrics`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `_user_roles`
--
ALTER TABLE `_user_roles`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
