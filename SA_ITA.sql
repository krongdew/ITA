-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Feb 07, 2024 at 06:18 AM
-- Server version: 8.1.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `SA_ITA`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `Report`
-- (See below for the actual view)
--
CREATE TABLE `Report` (
`Apr` decimal(32,0)
,`Aug` decimal(32,0)
,`Dec` decimal(32,0)
,`Feb` decimal(32,0)
,`ID` int
,`Jan` decimal(32,0)
,`Jul` decimal(32,0)
,`Jun` decimal(32,0)
,`Mar` decimal(32,0)
,`May` decimal(32,0)
,`Nov` decimal(32,0)
,`Oct` decimal(32,0)
,`Sep` decimal(32,0)
,`service_Access` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `sa_assessment`
--

CREATE TABLE `sa_assessment` (
  `AssessmentID` int NOT NULL,
  `AssessmentName` varchar(255) DEFAULT NULL,
  `CreatorUserID` int DEFAULT NULL,
  `ApprovalStatus` varchar(50) DEFAULT NULL,
  `ApproverUserID` int DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `AssessmentURL` varchar(255) DEFAULT NULL,
  `QrCodeImageName` varchar(255) DEFAULT NULL,
  `service_id` int DEFAULT NULL,
  `AssessmentStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sa_assessment`
--

INSERT INTO `sa_assessment` (`AssessmentID`, `AssessmentName`, `CreatorUserID`, `ApprovalStatus`, `ApproverUserID`, `CreationDate`, `AssessmentURL`, `QrCodeImageName`, `service_id`, `AssessmentStatus`) VALUES
(2, 'แบบประเมินห้องพยาบาล', 13, 'ยังไม่อนุมัติ', NULL, '2024-01-26 09:29:04', NULL, NULL, 2, 'รอสร้างข้อคำถาม'),
(8, 'ดนตรี', 13, 'ยังไม่อนุมัติ', NULL, '2024-02-01 08:54:00', NULL, NULL, 14, 'รอสร้างข้อคำถาม'),
(9, 'BLS', 13, 'ยังไม่อนุมัติ', NULL, '2024-02-01 08:54:15', NULL, NULL, 11, 'รอสร้างข้อคำถาม');

-- --------------------------------------------------------

--
-- Table structure for table `sa_department`
--

CREATE TABLE `sa_department` (
  `ID` int NOT NULL,
  `department_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `owner_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `department_memo` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sa_department`
--

INSERT INTO `sa_department` (`ID`, `department_name`, `owner_name`, `department_memo`, `timestamp`) VALUES
(1, 'งานพัฒนานักศึกษา', 'จุฬารักษ์ เครือจันทร์', '', '2024-01-23 03:59:58'),
(2, 'งานบริการและสวัสดิการนักศึกษา', 'นางสาวกนกรัตน์', 'งานบริการและสวัสดิการนักศึกษา', '2024-01-04 07:54:17'),
(3, 'งานหอพักนักศึกษา', ' นายธนกฤต เส็งมา', 'งานหอพักนักศึกษา', '2024-01-04 07:57:27'),
(5, 'งานศิษย์เก่าสัมพันธ์และบริการด้านอาชีพ', 'นายพัฒนศักดิ์ ตันบุตร', 'งานศิษย์เก่าสัมพันธ์และบริการด้านอาชีพ', '2024-01-04 07:59:11'),
(6, 'หน่วยบริหารและพัฒนาระบบ', ' นายปเนต กุลฉันท์วิทย์', 'หน่วยบริหารและพัฒนาระบบ', '2024-01-04 08:00:22');

-- --------------------------------------------------------

--
-- Table structure for table `sa_number_of_people`
--

CREATE TABLE `sa_number_of_people` (
  `ID` int NOT NULL,
  `service_id` int NOT NULL,
  `subservice_id` int NOT NULL,
  `number_people` decimal(10,0) NOT NULL,
  `Date` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sa_number_of_people`
--

INSERT INTO `sa_number_of_people` (`ID`, `service_id`, `subservice_id`, `number_people`, `Date`, `timestamp`) VALUES
(11, 2, 3, 1, '2024-01-29', '2024-01-29 08:38:20'),
(12, 2, 4, 2, '2024-01-29', '2024-01-29 08:38:20'),
(13, 2, 5, 3, '2024-01-29', '2024-01-29 08:38:20'),
(14, 11, 22, 100, '2024-01-31', '2024-01-31 02:36:58'),
(16, 11, 22, 100, '2024-01-30', '2024-01-31 02:47:16'),
(18, 11, 22, 50, '2024-01-29', '2024-01-31 02:51:17'),
(20, 11, 22, 250, '2024-01-28', '2024-01-31 03:17:18'),
(27, 11, 22, 150, '2024-01-27', '2024-01-31 04:14:38'),
(29, 14, 30, 20, '2024-01-31', '2024-01-31 04:17:32'),
(30, 14, 31, 20, '2024-01-31', '2024-01-31 04:17:32'),
(31, 14, 30, 15, '2024-01-30', '2024-01-31 04:17:44'),
(32, 14, 31, 15, '2024-01-30', '2024-01-31 04:17:44'),
(36, 11, 22, 100, '2024-01-26', '2024-01-31 07:20:17'),
(38, 11, 22, 11, '2024-01-24', '2024-01-31 07:33:18'),
(39, 11, 29, 21, '2024-01-24', '2024-01-31 07:33:18'),
(40, 11, 22, 10, '2024-02-01', '2024-02-01 06:39:06'),
(41, 11, 29, 10, '2024-02-01', '2024-02-01 06:39:06'),
(42, 2, 3, 100, '2024-02-01', '2024-02-01 06:39:19'),
(43, 2, 4, 10, '2024-02-01', '2024-02-01 06:39:19'),
(44, 2, 5, 45, '2024-02-01', '2024-02-01 06:39:19'),
(45, 14, 30, 10, '2024-02-01', '2024-02-01 06:39:31'),
(46, 14, 31, 56, '2024-02-01', '2024-02-01 06:39:31'),
(47, 11, 22, 10, '2023-12-31', '2024-02-01 06:55:47'),
(48, 11, 29, 10, '2023-12-31', '2024-02-01 06:55:47'),
(49, 19, 34, 10, '2024-02-01', '2024-02-01 07:25:01'),
(50, 19, 35, 10, '2024-02-01', '2024-02-01 07:25:01'),
(51, 19, 36, 10, '2024-02-01', '2024-02-01 07:25:01'),
(52, 20, 37, 120, '2024-02-01', '2024-02-01 07:30:19'),
(53, 2, 3, 10, '2024-02-06', '2024-02-06 08:52:28'),
(54, 2, 4, 10, '2024-02-06', '2024-02-06 08:52:28'),
(55, 2, 5, 10, '2024-02-06', '2024-02-06 08:52:28');

-- --------------------------------------------------------

--
-- Table structure for table `sa_question`
--

CREATE TABLE `sa_question` (
  `QuestionID` int NOT NULL,
  `AssessmentID` int DEFAULT NULL,
  `QuestionText` text,
  `QuestionOrder` int DEFAULT NULL,
  `QuestionType` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sa_respondent`
--

CREATE TABLE `sa_respondent` (
  `RespondentID` int NOT NULL,
  `AssessmentID` int DEFAULT NULL,
  `SubmissionDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sa_response`
--

CREATE TABLE `sa_response` (
  `ResponseID` int NOT NULL,
  `RespondentID` int DEFAULT NULL,
  `QuestionID` int DEFAULT NULL,
  `Rating` int DEFAULT NULL,
  `Comment` text,
  `Choices` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sa_services`
--

CREATE TABLE `sa_services` (
  `ID` int NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_detail` text,
  `service_status` varchar(50) DEFAULT NULL,
  `service_Access` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sa_services`
--

INSERT INTO `sa_services` (`ID`, `service_name`, `service_detail`, `service_status`, `service_Access`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(2, 'muhealth', 'ห้องพยาบาล', '1', '2', '2024-01-23 03:40:42', 'admin', '2024-01-31 07:52:45', 'admin'),
(11, 'BLS', 'BLS', '1', '2', '2024-01-31 02:35:01', 'admin', '2024-01-31 02:35:01', 'admin'),
(14, 'ห้องซ้อมดนตรี', 'ห้องดนตรีรายละเอียด', '1', '6', '2024-01-31 04:17:00', 'admin', '2024-01-31 04:17:00', 'admin'),
(19, 'ทุนการศึกษา', 'ทุนการศึกษา', '1', '2', '2024-02-01 07:24:22', 'admin', '2024-02-01 07:24:22', 'admin'),
(20, 'test', 'test', '1', '1', '2024-02-01 07:29:52', 'admin', '2024-02-01 07:29:52', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `sa_subservices`
--

CREATE TABLE `sa_subservices` (
  `ID` int NOT NULL,
  `service_id` int DEFAULT NULL,
  `subservice_name` varchar(255) NOT NULL,
  `subservice_detail` text,
  `subservice_status` varchar(50) DEFAULT NULL,
  `subservice_Access` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sa_subservices`
--

INSERT INTO `sa_subservices` (`ID`, `service_id`, `subservice_name`, `subservice_detail`, `subservice_status`, `subservice_Access`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(3, 2, 'ทำแผล', 'ทำแผล', '1', '4', '2024-01-23 03:40:42', 'admin', '2024-01-31 07:53:30', 'admin'),
(4, 2, 'ขอยา', 'ขอยา', '1', '4', '2024-01-23 03:40:42', 'admin', '2024-01-31 07:53:25', 'admin'),
(5, 2, 'พบแพทย์', 'พบแพทย์', '1', '4', '2024-01-23 03:40:42', 'admin', '2024-01-31 07:53:34', 'admin'),
(22, 11, 'อบรมออนไลน์', 'อบรมออนไลน์', '1', '4', '2024-01-31 02:35:01', 'admin', '2024-01-31 07:53:37', 'admin'),
(29, 11, 'อบรมออนไซต์', 'ให้ข้อมูล', '1', '4', '2024-01-31 04:16:18', NULL, '2024-01-31 07:53:39', NULL),
(30, 14, 'ห้องซ้อม1', '', '1', '14', '2024-01-31 04:17:00', 'admin', '2024-01-31 04:17:00', 'admin'),
(31, 14, 'ห้องซ้อม2', '', '1', '14', '2024-01-31 04:17:00', 'admin', '2024-01-31 04:17:00', 'admin'),
(34, 19, 'ทุนภายใน', 'ทุนภายใน', '1', '5', '2024-02-01 07:24:22', 'admin', '2024-02-01 07:24:22', 'admin'),
(35, 19, 'ทุนภายนอก', 'ทุนภายนอก', '1', '5', '2024-02-01 07:24:22', 'admin', '2024-02-01 07:24:22', 'admin'),
(36, 19, 'กองทุนการศึกษา', 'กองทุนการศึกษา', '1', '5', '2024-02-01 07:24:22', 'admin', '2024-02-01 07:24:22', 'admin'),
(37, 20, 'test', '1', '1', '1', '2024-02-01 07:29:52', 'admin', '2024-02-01 07:29:52', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `sa_unit`
--

CREATE TABLE `sa_unit` (
  `ID` int NOT NULL,
  `unit_name` varchar(100) NOT NULL,
  `department_id` int NOT NULL,
  `memo` varchar(500) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sa_unit`
--

INSERT INTO `sa_unit` (`ID`, `unit_name`, `department_id`, `memo`, `timestamp`) VALUES
(1, 'หน่วยองค์กร/กิจกรรมพัฒนานักศึกษา', 1, '', '2024-01-15 03:15:35'),
(2, 'หน่วยบำรุงศิลปวัฒนธรรม', 1, '', '2024-01-15 03:43:53'),
(3, 'หน่วยกีฬา', 1, '', '2024-01-15 03:44:04'),
(4, 'หน่วยบริการด้านสุขภาพนักศึกษา', 2, '', '2024-01-15 03:44:57'),
(5, 'หน่วยทุนการศึกษา', 2, '', '2024-01-15 03:45:06'),
(6, 'หน่วยแนะแนวการศึกษาและจัดหางาน', 2, '', '2024-01-15 03:45:13'),
(7, 'หน่วยวินัยนักศึกษา', 2, '', '2024-01-15 03:45:21'),
(8, 'หน่วยนักศึกษาวิชาทหาร', 2, '', '2024-01-15 03:45:28'),
(9, 'หน่วยบริการสนับสนุนสำหรับนักศึกษาพิการ', 2, '', '2024-01-15 03:45:36'),
(10, 'หน่วยบริการหอพักและกิจกรรมหอพักนักศึกษา', 3, '', '2024-01-15 03:46:04'),
(11, 'ทรัพยากรบุคคล', 6, '', '2024-01-15 03:46:37'),
(12, 'การเงิน คลังและพัสดุ', 6, '', '2024-01-15 03:46:44'),
(13, 'เทคโนโลยีสารสนเทศ', 6, '', '2024-01-15 03:46:53'),
(14, 'โสตทัศนูปกรณ์', 6, '', '2024-01-15 03:47:12'),
(15, 'ธุรการ สารบรรณ และยานพาหนะ', 6, '', '2024-01-15 03:47:27'),
(18, '-', 5, '', '2024-01-16 07:43:30');

-- --------------------------------------------------------

--
-- Table structure for table `sa_useraccess`
--

CREATE TABLE `sa_useraccess` (
  `user_id` int NOT NULL,
  `service_id` int NOT NULL,
  `sub_service_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sa_users`
--

CREATE TABLE `sa_users` (
  `ID` int NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `name_surname` varchar(255) NOT NULL,
  `department` int DEFAULT NULL,
  `unit` int DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `position_c` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_other` varchar(200) NOT NULL,
  `tell` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `UserType` varchar(255) NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `sa_users`
--

INSERT INTO `sa_users` (`ID`, `Username`, `Password`, `name_surname`, `department`, `unit`, `position`, `position_c`, `email`, `email_other`, `tell`, `phone`, `image`, `UserType`, `created_at`, `updated_at`) VALUES
(5, 'dewwiisunny2', '$2y$10$2Z6sMf8YUZKviqPpq4vQ0OoRaHSDLya7uGczln7V41PubhWlW0G/a', 'dew', 2, 4, 'test', '', 'dewwiisunny14@gmail.com', '', '', 'dewwiisunny', '../upload/dewwiisunny2.png', 'user', '2024-01-16 07:36:07', '2024-01-25 03:26:59'),
(6, 'dewwiisunny3', '$2y$10$VKtsCg24xaf0QAIR9IIhj.0yT69bbYzxBTrdRuEhOQu1C0i9zteHi', 'dew2', 3, 10, 'test', '', 'dewwiisunny14@gmail.com', '', '', '0875350828', '../upload/dewwiisunny3.png', 'user', '2024-01-16 07:38:22', '2024-01-25 03:27:27'),
(7, 'dewwiisunny4', '$2y$10$sKHtVFgyBg1TntcaBS/aj.bT1UDizIwEbXqE.mU8Kc6DFpHFQFFqK', 'dew3', 3, 10, 'หกดหกด', '', 'dewwiisunny14@gmail.com', '', '', '0875350828', '../upload/dewwiisunny4.jpg', 'user', '2024-01-16 07:39:48', '2024-01-25 03:27:30'),
(9, 'dewwiisunny6', '$2y$10$M7f5MMQGgMRLTi0HHRoE3eoBdPLem2z70UurOPcEKJlYBXb.1XL4m', 'dew4', 2, 4, 'test', '', 'dewwiisunny14@gmail.com', '', '', '0875350828', '../upload/dewwiisunny6.jpg', 'user', '2024-01-16 07:41:39', '2024-01-25 03:27:33'),
(10, 'dewwiisunny7', '$2y$10$amP6x.7Or..GK0.2zSsdhu7TiT2Gb0bhfkzfugJPGmMd5mA/oJeFa', 'dew5', 6, 11, 'test', '', 'dewwiisunny14@gmail.com', '', '', '0875350828', '../upload/dewwiisunny7.jpg', 'user', '2024-01-16 07:42:43', '2024-01-25 03:27:36'),
(11, 'dewwiisunny', '$2y$10$R.OUwcaTbu.hTQz9LXrBe.xVjWAJ.gCKviDccJRf6hA5m.BNGEwES', 'dew6', 2, 5, 'นักวิชาการสารสนเทศ', 'หัวหน้างาน', 'dewwiisunny14@gmail.com', 'dewwiisunny14@gmail.com', '88888', '0000000', '../upload/AEDmahidol.png', 'user', '2024-01-19 03:20:37', '2024-01-25 03:27:39'),
(12, 'admin', '$2y$10$.HnBHc/9shsgn.iMXvYxuulhVtp6TR3PKuTTB1qXdYptvkuPKagu.', 'ครองขวัญ บัวยอม', 2, 4, 'นักวิชาการสารสนเทศ', 'admin', 'krongkwan.bua@mahidol.ac.th', 'dewwiisunny14@gmail.com', '0875350828', '028494501', '../upload/admin.jpg', 'user', '2024-01-23 03:02:27', '2024-01-31 03:25:33'),
(13, 'admin_dew', '$2y$10$QIqtVsD4etYO3S2DkJpO/elE9S39OgOwdpesI3h0AMYT9KxPQeFLO', 'ครองขวัญ บัวยอม', 0, 13, 'นักวิชาการสารสนเทศ', '', 'dewwiisunny14@gmail.com', '', '', '0875350828', '../upload/admin_dew.jpg', 'admin', '2024-01-25 02:32:46', '2024-02-01 08:38:03');

-- --------------------------------------------------------

--
-- Structure for view `Report`
--
DROP TABLE IF EXISTS `Report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admin_dew`@`%` SQL SECURITY DEFINER VIEW `Report`  AS SELECT `sa_services`.`service_Access` AS `service_Access`, `sa_services`.`ID` AS `ID`, sum((case when (month(`sa_number_of_people`.`Date`) = 1) then `sa_number_of_people`.`number_people` else 0 end)) AS `Jan`, sum((case when (month(`sa_number_of_people`.`Date`) = 2) then `sa_number_of_people`.`number_people` else 0 end)) AS `Feb`, sum((case when (month(`sa_number_of_people`.`Date`) = 3) then `sa_number_of_people`.`number_people` else 0 end)) AS `Mar`, sum((case when (month(`sa_number_of_people`.`Date`) = 4) then `sa_number_of_people`.`number_people` else 0 end)) AS `Apr`, sum((case when (month(`sa_number_of_people`.`Date`) = 5) then `sa_number_of_people`.`number_people` else 0 end)) AS `May`, sum((case when (month(`sa_number_of_people`.`Date`) = 6) then `sa_number_of_people`.`number_people` else 0 end)) AS `Jun`, sum((case when (month(`sa_number_of_people`.`Date`) = 7) then `sa_number_of_people`.`number_people` else 0 end)) AS `Jul`, sum((case when (month(`sa_number_of_people`.`Date`) = 8) then `sa_number_of_people`.`number_people` else 0 end)) AS `Aug`, sum((case when (month(`sa_number_of_people`.`Date`) = 9) then `sa_number_of_people`.`number_people` else 0 end)) AS `Sep`, sum((case when (month(`sa_number_of_people`.`Date`) = 10) then `sa_number_of_people`.`number_people` else 0 end)) AS `Oct`, sum((case when (month(`sa_number_of_people`.`Date`) = 11) then `sa_number_of_people`.`number_people` else 0 end)) AS `Nov`, sum((case when (month(`sa_number_of_people`.`Date`) = 12) then `sa_number_of_people`.`number_people` else 0 end)) AS `Dec` FROM (`sa_number_of_people` join `sa_services` on((`sa_number_of_people`.`service_id` = `sa_services`.`ID`))) GROUP BY `sa_services`.`service_Access`, `sa_services`.`ID` ORDER BY `sa_services`.`service_Access` ASC, `sa_services`.`ID` ASC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sa_assessment`
--
ALTER TABLE `sa_assessment`
  ADD PRIMARY KEY (`AssessmentID`),
  ADD KEY `sa_assessment_ibfk_1` (`CreatorUserID`),
  ADD KEY `sa_assessment_ibfk_2` (`ApproverUserID`),
  ADD KEY `sa_assessment_ibfk_3` (`service_id`);

--
-- Indexes for table `sa_department`
--
ALTER TABLE `sa_department`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sa_number_of_people`
--
ALTER TABLE `sa_number_of_people`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `subservice_id` (`subservice_id`) USING BTREE;

--
-- Indexes for table `sa_question`
--
ALTER TABLE `sa_question`
  ADD PRIMARY KEY (`QuestionID`),
  ADD KEY `AssessmentID` (`AssessmentID`);

--
-- Indexes for table `sa_respondent`
--
ALTER TABLE `sa_respondent`
  ADD PRIMARY KEY (`RespondentID`),
  ADD KEY `AssessmentID` (`AssessmentID`);

--
-- Indexes for table `sa_response`
--
ALTER TABLE `sa_response`
  ADD PRIMARY KEY (`ResponseID`),
  ADD KEY `QuestionID` (`QuestionID`),
  ADD KEY `sa_response_ibfk_2` (`RespondentID`);

--
-- Indexes for table `sa_services`
--
ALTER TABLE `sa_services`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sa_subservices`
--
ALTER TABLE `sa_subservices`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `sa_unit`
--
ALTER TABLE `sa_unit`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sa_useraccess`
--
ALTER TABLE `sa_useraccess`
  ADD PRIMARY KEY (`user_id`,`service_id`,`sub_service_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `sub_service_id` (`sub_service_id`);

--
-- Indexes for table `sa_users`
--
ALTER TABLE `sa_users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sa_assessment`
--
ALTER TABLE `sa_assessment`
  MODIFY `AssessmentID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sa_department`
--
ALTER TABLE `sa_department`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `sa_number_of_people`
--
ALTER TABLE `sa_number_of_people`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `sa_question`
--
ALTER TABLE `sa_question`
  MODIFY `QuestionID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sa_respondent`
--
ALTER TABLE `sa_respondent`
  MODIFY `RespondentID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sa_response`
--
ALTER TABLE `sa_response`
  MODIFY `ResponseID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sa_services`
--
ALTER TABLE `sa_services`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sa_subservices`
--
ALTER TABLE `sa_subservices`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `sa_unit`
--
ALTER TABLE `sa_unit`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sa_users`
--
ALTER TABLE `sa_users`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sa_assessment`
--
ALTER TABLE `sa_assessment`
  ADD CONSTRAINT `sa_assessment_ibfk_1` FOREIGN KEY (`CreatorUserID`) REFERENCES `sa_users` (`ID`),
  ADD CONSTRAINT `sa_assessment_ibfk_2` FOREIGN KEY (`ApproverUserID`) REFERENCES `sa_users` (`ID`),
  ADD CONSTRAINT `sa_assessment_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `sa_services` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sa_number_of_people`
--
ALTER TABLE `sa_number_of_people`
  ADD CONSTRAINT `sa_number_of_prople_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `sa_services` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sa_question`
--
ALTER TABLE `sa_question`
  ADD CONSTRAINT `sa_question_ibfk_1` FOREIGN KEY (`AssessmentID`) REFERENCES `sa_assessment` (`AssessmentID`);

--
-- Constraints for table `sa_respondent`
--
ALTER TABLE `sa_respondent`
  ADD CONSTRAINT `sa_respondent_ibfk_1` FOREIGN KEY (`AssessmentID`) REFERENCES `sa_assessment` (`AssessmentID`);

--
-- Constraints for table `sa_response`
--
ALTER TABLE `sa_response`
  ADD CONSTRAINT `sa_response_ibfk_1` FOREIGN KEY (`QuestionID`) REFERENCES `sa_question` (`QuestionID`),
  ADD CONSTRAINT `sa_response_ibfk_2` FOREIGN KEY (`RespondentID`) REFERENCES `sa_respondent` (`RespondentID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sa_subservices`
--
ALTER TABLE `sa_subservices`
  ADD CONSTRAINT `sa_subservices_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `sa_services` (`ID`);

--
-- Constraints for table `sa_useraccess`
--
ALTER TABLE `sa_useraccess`
  ADD CONSTRAINT `sa_useraccess_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sa_users` (`ID`),
  ADD CONSTRAINT `sa_useraccess_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `sa_services` (`ID`),
  ADD CONSTRAINT `sa_useraccess_ibfk_3` FOREIGN KEY (`sub_service_id`) REFERENCES `sa_subservices` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
