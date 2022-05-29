-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2021 at 11:50 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chhori_bachat`
--

-- --------------------------------------------------------

--
-- Table structure for table `apangata`
--

CREATE TABLE `apangata` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `created_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `apangata`
--

INSERT INTO `apangata` (`id`, `name`, `created_date`, `status`) VALUES
(6, 'पूर्ण असक्त अपाङ्गता', '2021-07-07', 1),
(7, 'अति असक्त अपाङ्गता', '2021-07-07', 1),
(8, 'मध्यम अपाङ्गता', '2021-07-07', 1),
(9, 'सामान्य अपाङ्गता ', '2021-07-07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_municipal_id` int(11) NOT NULL,
  `created_date` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_province_id` int(11) NOT NULL,
  `fk_district_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `bank_details`
--

INSERT INTO `bank_details` (`id`, `bank_name`, `fk_user_id`, `fk_municipal_id`, `created_date`, `fk_province_id`, `fk_district_id`, `status`) VALUES
(21, 'राष्ट्रिय वाणिज्य बैंक', 32, 638, '2021-11-18', 6, 80, 0),
(23, 'NIC Asia Bank Limited', 32, 638, '2021-11-18', 6, 80, 1);

-- --------------------------------------------------------

--
-- Table structure for table `caste`
--

CREATE TABLE `caste` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `caste`
--

INSERT INTO `caste` (`id`, `name`, `created_date`, `status`) VALUES
(6, 'ब्राह्मण', '2021-07-07', 1),
(7, 'क्षेत्री', '2021-07-07', 1),
(8, 'जनजाति', '2021-07-07', 1),
(9, 'मुस्लिम', '2021-07-07', 1),
(31, 'दलित', '2021-07-07', 1),
(33, 'अन्य', '2021-07-07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `check_payment`
--

CREATE TABLE `check_payment` (
  `id` int(11) NOT NULL,
  `fk_economic_year` int(11) NOT NULL,
  `fk_chori_bachat` varchar(55) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_month` varchar(45) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `created_date` varchar(234) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chori_account_details`
--

CREATE TABLE `chori_account_details` (
  `id` int(11) NOT NULL,
  `chori_unique_id` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `fk_chori_bachat` varchar(45) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_municipal_id` int(11) NOT NULL,
  `bank_name` int(11) NOT NULL,
  `account_no` varchar(45) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `account_open_date` varchar(234) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `radio_status` int(11) NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `fk_user_id` int(11) NOT NULL,
  `bank_status` int(11) NOT NULL,
  `created_date` varchar(300) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_province_id` int(11) NOT NULL,
  `fk_district_id` int(11) NOT NULL,
  `fk_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `chori_account_details`
--

INSERT INTO `chori_account_details` (`id`, `chori_unique_id`, `fk_chori_bachat`, `fk_municipal_id`, `bank_name`, `account_no`, `account_open_date`, `radio_status`, `remarks`, `fk_user_id`, `bank_status`, `created_date`, `fk_province_id`, `fk_district_id`, `fk_year`) VALUES
(336, '2078/79-1-1', '263', 638, 23, '000034568213121', '2078-08-02', 1, '', 32, 2, '2021-11-18', 6, 80, 4),
(337, '2078/79-1-2', '264', 638, 23, '000034568213121', '2078-08-03', 1, '', 32, 2, '2021-11-19', 6, 80, 4);

-- --------------------------------------------------------

--
-- Table structure for table `chori_bachat`
--

CREATE TABLE `chori_bachat` (
  `id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_municipal_id` int(11) NOT NULL,
  `fk_bank_details` int(11) DEFAULT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `camera_image` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `thumb_left` text COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `left_iso_template` text COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `left_ansi_template` text COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `thumb_right` text COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `iso_template` text COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `ansi_template` text COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `guardian_image` varchar(200) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `name` varchar(500) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `dob` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `age` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `phone_no` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `mobile_no` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `birth_certificate_no` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `birth_certificate_date` varchar(300) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_caste` int(11) NOT NULL,
  `fk_apangata` int(11) DEFAULT NULL,
  `father_name` varchar(234) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `father_citizenship_no` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `mother_name` varchar(200) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `mother_citizenship_no` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `take_care_person` varchar(300) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `take_care_citizenship_no` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `fk_per_province` int(11) NOT NULL,
  `fk_per_district` int(11) NOT NULL,
  `fk_per_municipal` int(11) NOT NULL,
  `fk_ward` int(11) NOT NULL,
  `tole_name` varchar(500) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_month` int(11) NOT NULL,
  `chori_birth_certificate_doc` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `parents_citizenship_doc` varchar(200) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `mother_citizenship_doc` varchar(500) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `woda_sifarish_doc` varchar(500) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `sastha_certificate` varchar(300) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `hospital_certificate` varchar(300) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `bank_status` int(11) DEFAULT NULL,
  `payment_status` int(11) NOT NULL,
  `created_date` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `unique_id` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_economic_year` int(11) NOT NULL,
  `verified_date` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `chori_bachat`
--

INSERT INTO `chori_bachat` (`id`, `fk_user_id`, `fk_municipal_id`, `fk_bank_details`, `image`, `camera_image`, `thumb_left`, `left_iso_template`, `left_ansi_template`, `thumb_right`, `iso_template`, `ansi_template`, `guardian_image`, `name`, `dob`, `age`, `email`, `phone_no`, `mobile_no`, `birth_certificate_no`, `birth_certificate_date`, `fk_caste`, `fk_apangata`, `father_name`, `father_citizenship_no`, `mother_name`, `mother_citizenship_no`, `take_care_person`, `take_care_citizenship_no`, `fk_per_province`, `fk_per_district`, `fk_per_municipal`, `fk_ward`, `tole_name`, `fk_month`, `chori_birth_certificate_doc`, `parents_citizenship_doc`, `mother_citizenship_doc`, `woda_sifarish_doc`, `sastha_certificate`, `hospital_certificate`, `status`, `bank_status`, `payment_status`, `created_date`, `unique_id`, `fk_economic_year`, `verified_date`) VALUES
(263, 32, 638, NULL, 'images/32/chori-image/15iBpXU_P1t0IZjJQyDfcyVzyq1tCPtw.jpg', NULL, NULL, '', '', NULL, '', '', 'images/32/parent-photo/xPhxVt29r2dqnd-eVqHWAGuzO5gkPdrz.jpg', 'सिता पौडेल', '2078-08-02', 0, '', '', '9868211339', '22532423423', '2078-08-02', 6, NULL, '', '', '', '', '', '', 6, 80, 638, 60, 'शान्ति टोल', 5, '', '', '', '', '', '', 5, 0, 0, '2078-08-02', '2078/79-1-1', 4, '2078-08-02'),
(264, 32, 638, NULL, 'images/32/chori-image/_CeVHD_99tqdRZ_0WppbHtdtaCNDQdpC.jpg', NULL, NULL, '', '', NULL, '', '', 'images/32/parent-photo/2F6Qm4ZKwn5ADY2R0kpGbbWolGYTHEJB.jpg', 'गीता अधिकारी', '2078-08-01', 0, '', '', '9868211339', '22532423423', '2078-08-04', 7, NULL, '', '', '', '', '', '', 6, 80, 638, 60, 'शान्ति टोल', 5, '', '', '', '', '', '', 5, 0, 0, '2078-08-03', '2078/79-1-2', 4, '2078-08-03');

-- --------------------------------------------------------

--
-- Table structure for table `dismiss`
--

CREATE TABLE `dismiss` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_municipal_id` int(11) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dismiss`
--

INSERT INTO `dismiss` (`id`, `name`, `fk_user_id`, `fk_municipal_id`, `created_date`, `type`) VALUES
(5, 'बिहे', 32, 638, '2021-11-18', 2),
(7, 'परिपक्क भैसकेको', 32, 638, '2021-11-18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `id` int(11) NOT NULL,
  `district` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `district_nepali` varchar(3000) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_province` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`id`, `district`, `district_nepali`, `fk_province`) VALUES
(1, 'Jhapa', 'झापा ', 1),
(2, 'Morang', 'मोरंग', 1),
(3, 'Ilam', 'इलाम', 1),
(4, 'Sunsari', 'सुनसरी', 1),
(5, 'Dhankuta', 'धनकुटा', 1),
(6, 'Pachthar', 'पांचथर', 1),
(7, 'Teharthum', 'तेह्रथुम', 1),
(8, 'Taplejung', 'ताप्लेजुंग', 1),
(9, 'Bhojpur', 'भोजपुर', 1),
(10, 'Sankhuwasabha', 'संखुवासभा', 1),
(11, 'Khotang', 'खोटाँग', 1),
(12, 'Udaipur', 'उदयपुर', 1),
(13, 'Okhaldhunga', 'ओखलढुंगा', 1),
(14, 'Solukhumbu', 'सोलुखुम्बू', 1),
(15, 'Parsa', 'पर्सा', 2),
(16, 'Bara', 'बारा', 2),
(17, 'Rautahat', 'रौतहट ', 2),
(18, 'Sarlahi', 'सर्लाही', 2),
(19, 'Mahottari', 'महोत्तरी', 2),
(20, 'Dhanusa', 'धनुषा ', 2),
(21, 'Siraha', 'सिराहा', 2),
(22, 'Saptari', 'सप्तरी', 2),
(37, 'Rasuwa', 'रसुवा ', 3),
(38, 'Chitwan', 'चितवन', 3),
(39, 'Makwanpur', 'मकवानपुर', 3),
(40, 'Sindhuli', 'सिन्दुली', 3),
(41, 'Dhading', 'धादिङ', 3),
(42, 'Nuwakot', ' नुवाकोट', 3),
(43, 'Lalitpur', 'ललितपुर', 3),
(44, 'Bhaktapur', 'भक्तपुर', 3),
(45, 'Kathmandu', 'काठमाडौँ', 3),
(46, 'Kabhre', 'काभ्रे', 3),
(47, 'Ramechhap', 'रामेछाप', 3),
(48, 'Dolakha', 'धोलाखा', 3),
(49, 'Sindhupalchok', 'सिन्धुपाल्चोक', 3),
(50, 'Manang', 'मनाङ', 4),
(51, 'Mustang', 'मुस्ताङ ', 4),
(52, 'Gorkha', 'गोर्खा', 4),
(53, 'Lamjung', 'लमजुङ', 4),
(54, 'Kaski', 'कास्की', 4),
(55, 'Tanahu', 'तनहु', 4),
(56, 'Nawalparasi East', ' नवलपरासी ', 4),
(57, 'Syanja', 'स्याङग्जा', 4),
(58, 'Parbat', 'पर्वत', 4),
(59, 'Baglung ', 'बागलुङ', 4),
(60, 'Myagdi', 'म्याग्दी ', 4),
(61, 'Bardiya', '	बर्दिया', 5),
(62, 'Banke', 'बाँके', 5),
(63, 'Dang', 'दाङ', 5),
(64, 'Rolpa', 'रोल्पा ', 5),
(65, 'Rukum East', 'पश्चिमी रूकुम ', 5),
(67, 'Pyuthan', 'प्युठान', 5),
(68, 'Gulmi', 'गुल्मी', 5),
(69, 'Arghakhanchi', 'अर्घाखाँची', 5),
(70, 'Kapilbastu', 'कपिलवस्तु ', 5),
(71, 'Palpa', 'पाल्पा', 5),
(72, 'Rupendehi', 'रुपन्देही', 5),
(73, 'Nawalparasi', 'नवलपरासी', 5),
(74, 'Humla', 'हुम्ला', 6),
(75, 'Kalikot', 'कालिकोट', 6),
(76, 'Mugu', 'मुगु', 6),
(77, 'Jumla', 'जुम्ला', 6),
(78, 'Dolpa', 'डोल्पा', 6),
(79, 'Dailekh', 'दैलेख', 6),
(80, 'Surkhet', 'सुर्खेत', 6),
(81, 'Salyan', 'सल्यान', 6),
(82, 'Rukum West', 'पश्चिमी रूकुम', 6),
(83, 'Jajarkot', '	जाजरकोट', 6),
(84, 'Darchula', 'दार्चुला', 7),
(85, 'Baitadi', 'बैतडी', 7),
(86, 'Bajhang', 'बझाङ', 7),
(87, 'Bajura', 'बाजुरा', 7),
(88, 'Dadeldhura', 'डडेलधुरा ', 7),
(89, 'Doti', 'डोटी', 7),
(90, 'Achham', 'अछाम', 7),
(91, 'Kanchanpur', 'कंचनपुर', 7),
(92, 'Kailali', 'कैलाली', 7);

-- --------------------------------------------------------

--
-- Table structure for table `economic_year`
--

CREATE TABLE `economic_year` (
  `id` int(11) NOT NULL,
  `economic_year` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` varchar(200) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `fk_province_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `economic_year`
--

INSERT INTO `economic_year` (`id`, `economic_year`, `status`, `created_date`, `fk_province_id`) VALUES
(1, '3', 0, '2021-06-04', 6),
(2, '4', 1, '2021-06-04', 6),
(3, '5', 0, '2078-5-5', 6),
(10, '4', 1, '2021-07-20', 3),
(11, '4', 0, '2021-07-20', 5),
(12, '5', 0, '2021-07-21', 5),
(13, '6', 1, NULL, 5),
(14, '7', 0, '2021-07-27', 5),
(15, '6', 0, '2021-10-01', 6),
(20, '7', 0, '2021-11-11', 6),
(21, '8', 0, '2021-11-13', 6);

-- --------------------------------------------------------

--
-- Table structure for table `initial`
--

CREATE TABLE `initial` (
  `id` int(11) NOT NULL,
  `fk_year` int(11) NOT NULL,
  `fk_province_id` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `fk_municipal` int(11) NOT NULL,
  `fk_district` int(11) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `fk_bank` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `initial`
--

INSERT INTO `initial` (`id`, `fk_year`, `fk_province_id`, `fk_user`, `fk_municipal`, `fk_district`, `created_date`, `payment_id`, `status`, `fk_bank`) VALUES
(14, 4, 6, 32, 638, 80, '2078-08-02', '2078/79-1', 1, 21),
(17, 4, 6, 32, 638, 80, '2078-08-03', '2078/79-2', 1, 23);

-- --------------------------------------------------------

--
-- Table structure for table `money_set`
--

CREATE TABLE `money_set` (
  `id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_municipal_id` int(11) NOT NULL,
  `initial_payment` int(11) NOT NULL,
  `previous_payment` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` varchar(300) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `money_set`
--

INSERT INTO `money_set` (`id`, `fk_user_id`, `fk_municipal_id`, `initial_payment`, `previous_payment`, `status`, `created_date`) VALUES
(19, 32, 638, 1000, 500, 1, '2021-11-18');

-- --------------------------------------------------------

--
-- Table structure for table `month`
--

CREATE TABLE `month` (
  `id` int(11) NOT NULL,
  `month_name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `created_date` varchar(234) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `month`
--

INSERT INTO `month` (`id`, `month_name`, `created_date`) VALUES
(1, 'श्रावण', '2078-02-25'),
(2, 'भदौ', '2078-02-25'),
(3, 'असोज', '2078-02-25'),
(4, 'कार्तिक', '2078-02-25'),
(5, 'मंसिर', '2078-02-25'),
(6, 'पौष', '2078-02-25'),
(7, 'माघ', '2078-02-25'),
(8, 'फाल्गुण', '2078-02-25'),
(9, 'चैत्र', '2078-02-25'),
(10, 'वैशाख', '2078-02-25'),
(11, 'जेठ', '2078-02-25'),
(12, 'आषाढ़', '2078-02-25');

-- --------------------------------------------------------

--
-- Table structure for table `municipal`
--

CREATE TABLE `municipal` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_province` int(11) NOT NULL,
  `fk_district` int(11) NOT NULL,
  `address` varchar(234) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `head_officer` varchar(200) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `municipal_code` varchar(45) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `fk_user_id` int(11) NOT NULL,
  `logo` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `created_date` varchar(34) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `municipal`
--

INSERT INTO `municipal` (`id`, `name`, `fk_province`, `fk_district`, `address`, `head_officer`, `municipal_code`, `fk_user_id`, `logo`, `created_date`) VALUES
(1, 'बधैयातल गाउपालिका ', 5, 61, 'बर्दिया ', ' अर्जुन गौतम ', 'B2020', 1, '', '2021-03-04'),
(2, 'गुलरिया नगरपालिका ', 5, 61, 'बर्दिया ', ' अर्जुन गौतम ', 'B2020', 1, '', '2021-03-04'),
(3, 'मधुवन नगरपालिका ', 5, 61, 'बर्दिया ', 'हरि अधिकारी ', 'G2020', 1, '', '2021-03-04'),
(4, 'नरैनापुर गाउपालिका ', 5, 62, 'बाँके', ' राम पौडेल ', 'N3030', 1, '', '2021-03-04');

-- --------------------------------------------------------

--
-- Table structure for table `municipals`
--

CREATE TABLE `municipals` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `municipal_nepali` varchar(500) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_district` int(11) NOT NULL,
  `fk_province` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `municipals`
--

INSERT INTO `municipals` (`id`, `name`, `municipal_nepali`, `fk_district`, `fk_province`) VALUES
(15, 'Damak Municipality', 'दमक नगरपालिका', 1, 1),
(16, 'Kamal', 'कमल गाउँपालिका', 1, 1),
(17, 'Gauradhaha', 'गौरादह नगरपालिका', 1, 1),
(18, 'Shivasataxi', 'शिवशताक्षी नगरपालिका', 1, 1),
(19, 'Kankai', '	कन्काई नगरपालिका', 1, 1),
(20, 'Jhapa', '	झापा गाउँपालिका', 1, 1),
(21, 'Barhadashi', 'बाह्रदशी गाउँपालिका', 1, 1),
(22, 'Birtamod', 'विर्तामोड नगरपालिका', 1, 1),
(23, 'Haldibari', '	हल्दिवारी गाउँपालिका', 1, 1),
(24, 'Bhadrapur', '	भद्रपुर नगरपालिका', 1, 1),
(25, 'Kachankawal', '	कचनकवल गाउँपालिका', 1, 1),
(26, 'Arjundhara', '	अर्जुनधारा नगरपालिका', 1, 1),
(27, 'Mechinagar', '	मेचीनगर नगरपालिका', 1, 1),
(28, 'Buddhashanti', '	बुद्धशान्ति गाउँपालिका', 1, 1),
(29, 'kerabari', 'केरावारी गाउँपालिका', 2, 1),
(30, 'Letang Municipality', '	लेटाङ नगरपालिका', 2, 1),
(31, 'Miklajung', 'मिक्लाजुङ गाउँपालिका', 2, 1),
(32, 'Sundarharaicha', 'सुन्दरहरैचा नगरपालिका', 2, 1),
(33, 'Belbari', 'बेलवारी नगरपालिका', 2, 1),
(34, 'Kanepokhari', 'कानेपोखरी गाउँपालिका', 2, 1),
(35, 'Pataharishanishchare', 'पथरी शनिश्चरे नगरपालिका', 2, 1),
(36, 'Budhiganga', 'बुढीगंगा गाउँपालिका', 2, 1),
(37, 'Katahari', 'कटहरी गाउँपालिका', 2, 1),
(38, 'Rangeli Municipality', 'रंगेली नगरपालिका', 2, 1),
(39, 'Biratnagar', 'विराटनगर महानगरपालिका', 2, 1),
(40, 'Jahada', 'जहदा गाउँपालिका', 2, 1),
(41, 'Dhanpalthan', 'धनपालथान गाउँपालिका', 2, 1),
(42, 'Sunwarshi', 'सुनवर्षि नगरपालिका', 2, 1),
(43, 'RAtuwamai', 'रतुवामाई नगरपालिका', 2, 1),
(44, 'Urlabari', '	उर्लावारी नगरपालिका', 2, 1),
(45, 'Gramthan', 'ग्रामथान गाउँपालिका', 2, 1),
(46, 'Sandakpur', 'सन्दकपुर गाउँपालिका', 3, 1),
(47, 'Fakphokthum', 'फाकफोकथुम गाउँपालिका', 3, 1),
(48, 'Deumai', 'देउमाई नगरपालिका', 3, 1),
(49, 'Ilam', 'ईलाम नगरपालिका', 3, 1),
(50, 'Maijogmai', 'माईजोगमाई गाउँपालिका', 3, 1),
(51, 'Suryodaya', '	सूर्योदय नगरपालिका', 3, 1),
(52, 'Rong', 'रोङ गाउँपालिका', 3, 1),
(53, 'Mai', 'माई नगरपालिका', 3, 1),
(54, 'Chulachuli', 'चुलाचुली गाउँपालिका', 3, 1),
(55, 'Mangsebung', '	माङसेबुङ गाउँपालिका', 3, 1),
(56, 'Barahchhetra', 'बराहक्षेत्र नगरपालिका', 4, 1),
(57, 'Dharan', 'धरान उपमहानगरपालिका', 4, 1),
(58, 'Ramdhuni', 'रामधुनी नगरपालिका', 4, 1),
(59, 'Itahari', 'ईटहरी उपमहानगरपालिका', 4, 1),
(60, 'Inaruwa', 'ईनरुवा नगरपालिका', 4, 1),
(61, 'Gadhi', 'गढी गाउँपालिका', 4, 1),
(62, 'Duhabi', 'दुहवी नगरपालिका', 4, 1),
(63, 'Barju', 'बर्जु गाउँपालिका', 4, 1),
(64, 'Dewanganj', 'देवानगञ्ज गाउँपालिका', 4, 1),
(65, 'Harinagar', '	हरिनगर गाउँपालिका', 4, 1),
(66, 'Koshi', 'कोशी गाउँपालिका', 4, 1),
(67, 'Bhokraha Nursing', 'भोक्राहा नरसिंह गाउँपालिका', 4, 1),
(68, 'Mahalaxmi', 'महालक्ष्मी नगरपालिका', 5, 1),
(69, 'Pakhribas', 'पाख्रिबास नगरपालिका', 5, 1),
(70, 'Shahidbhumi', 'सहिदभूमि गाउँपालिका', 5, 1),
(71, 'Sangurigadhi', 'साँगुरीगढी गाउँपालिका', 5, 1),
(72, 'Chaubise', 'चौविसे गाउँपालिका', 5, 1),
(73, 'Dhankuta', '	धनकुटा नगरपालिका', 5, 1),
(74, 'Chhathar Jorpati', '	छथर जोरपाटी गाउँपालिका', 5, 1),
(75, 'Miklajung', 'मिक्लाजुङ गाउँपालिका', 6, 1),
(76, 'Tumbewa', 'तुम्बेवा गाउँपालिका', 6, 1),
(77, 'Kummayak', 'कुम्मायक गाउँपालिका', 6, 1),
(78, 'Falgunanda', '	फाल्गुनन्द गाउँपालिका', 6, 1),
(79, 'Falelung', 'फालेलुङ गाउँपालिका', 6, 1),
(80, 'Yangwarak', 'याङवरक गाउँपालिका', 6, 1),
(81, 'Phidim', 'फिदिम नगरपालिका', 6, 1),
(82, 'Hilihang', '	हिलिहाङ गाउँपालिका', 6, 1),
(83, 'Menchayam', 'मेन्छयायेम गाउँपालिका', 7, 1),
(84, 'Athrai', 'आठराई गाउँपालिका', 7, 1),
(85, 'Phedap', 'फेदाप गाउँपालिका', 7, 1),
(86, 'Myanglum', '	म्याङलुङ नगरपालिका', 7, 1),
(87, 'Laligurans', 'लालीगुराँस नगरपालिका', 7, 1),
(88, 'Chhathar', '	छथर गाउँपालिका', 7, 1),
(89, 'Phaktanglung', 'फक्ताङलुङ गाउँपालिका', 8, 1),
(90, 'Mikwakhola', '	मैवाखोला गाउँपालिका', 8, 1),
(91, 'Meringden', 'मेरिङदेन गाउँपालिका', 8, 1),
(92, 'Maiwakhola', '	मिक्वाखोला गाउँपालिका', 8, 1),
(93, 'Phunling', 'फुङलिङ नगरपालिका', 8, 1),
(94, 'Sirijangha', 'सिरीजङ्घा गाउँपालिका', 8, 1),
(95, 'Sidingba', '	सिदिङ्वा गाउँपालिका', 8, 1),
(96, 'Athrai Tribeni', '	आठराई त्रिवेणी गाउँपालिका', 8, 1),
(97, 'Pathibhara Yangwarak', 'पाथीभरा याङवरक गाउँपालिका', 8, 1),
(98, 'Salpasilichho', 'साल्पासिलिछो गाउँपालिका', 9, 1),
(99, 'Shadananda', '	षडानन्द नगरपालिका', 9, 1),
(100, 'Bhojpur', 'भोजपुर नगरपालिका', 9, 1),
(101, 'Temkemaiyum', '	टेम्केमैयुङ गाउँपालिका', 9, 1),
(102, 'Arun', 'अरुण गाउँपालिका', 9, 1),
(103, 'Pauwadungma', 'पौवादुङमा गाउँपालिका', 9, 1),
(104, 'Ramprasad Rai', 'रामप्रसाद राई गाउँपालिका', 9, 1),
(105, 'Hatuwagadhi', 'हतुवागढी गाउँपालिका', 9, 1),
(106, 'Aamchowk', 'आमचोक गाउँपालिका', 9, 1),
(107, 'Bhotkhola', 'भोटखोला गाउँपालिका', 10, 1),
(108, 'Makalu', 'मकालु गाउँपालिका', 10, 1),
(109, 'Silichong', 'सिलीचोङ गाउँपालिका', 10, 1),
(110, 'Chichila', 'चिचिला गाउँपालिका', 10, 1),
(111, 'Khandabari', 'खाँदवारी नगरपालिका', 10, 1),
(112, 'Sabhapokhari', 'सभापोखरी गाउँपालिका', 10, 1),
(113, 'Panchakhapan', 'पाँचखपन नगरपालिका', 10, 1),
(114, 'Chainpur', '	चैनपुर नगरपालिका', 10, 1),
(115, 'Madi', 'मादी नगरपालिका', 10, 1),
(116, 'Dharmadevi', 'धर्मदेवी नगरपालिका', 10, 1),
(117, 'Ainselukhark', 'ऐसेलुखर्क गाउँपालिका', 11, 1),
(118, 'Kepilasagadhi', 'केपिलासगढी गाउँपालिका', 11, 1),
(119, 'Rawa Besi', 'रावा बेसी गाउँपालिका', 11, 1),
(120, 'Doktel Rupkot Majhuwagadi', 'दिक्तेल रुपाकोट मझुवागढी नगरपालिका', 11, 1),
(121, 'Sakela', 'साकेला गाउँपालिका', 11, 1),
(122, 'Halesi Tuwachung', 'हलेसी तुवाचुङ नगरपालिका', 11, 1),
(123, 'Diprung Chuichumma', 'दिप्रुङ चुइचुम्मा गाउँपालिका', 11, 1),
(124, 'Khotehang', 'खोटेहाङ गाउँपालिका', 11, 1),
(125, 'Jantedhunga', 'जन्तेढुंगा गाउँपालिका', 11, 1),
(126, 'Barahpokhari', '	वराहपोखरी गाउँपालिका', 11, 1),
(127, 'Katari', 'कटारी नगरपालिका', 12, 1),
(128, 'Tapil', '	ताप्ली गाउँपालिका', 12, 1),
(129, 'Limchungbung', '	लिम्चुङ्बुङ गाउँपालिका', 12, 1),
(130, 'Udayapurgadhi', 'उदयपुरगढी गाउँपालिका', 12, 1),
(131, 'Rautamai', 'रौतामाई गाउँपालिका', 12, 1),
(132, 'Triyuga', '	त्रियुगा नगरपालिका', 12, 1),
(133, 'Chaudandigadhi', 'चौदण्डीगढी नगरपालिका', 12, 1),
(134, 'baleka', 'वेलका नगरपालिका', 12, 1),
(135, 'Khijidemba', 'खिजिदेम्बा गाउँपालिका', 13, 1),
(136, 'Likhu', '	लिखु गाउँपालिका', 13, 1),
(137, 'Molung', 'मोलुङ गाउँपालिका', 13, 1),
(138, 'Champadevi', 'चम्पादेवी गाउँपालिका', 13, 1),
(139, 'Sunkoshi', '	सुनकोशी गाउँपालिका', 13, 1),
(140, 'Siddhicharan', 'सिद्दिचरण नगरपालिका', 13, 1),
(141, 'Manebhanjyang', 'मानेभञ्याङ गाउँपालिका', 13, 1),
(142, 'Khumbupasanglahmu', 'खुम्वु पासाङल्हमु गाउँपालिका', 14, 1),
(143, 'Mahakulung', 'माहाकुलुङ गाउँपालिका', 14, 1),
(144, 'Likhupike', 'लिखु पिके गाउँपालिका', 14, 1),
(145, 'SoluDudhakunda', 'सोलुदुधकुण्ड नगरपालिका', 14, 1),
(146, 'Mapya Dudhakoshi', 'माप्य दुधकोशी गाउँपालिका', 14, 1),
(147, 'Sotang', 'सोताङ गाउँपालिका', 14, 1),
(148, 'NechaSalyan', 'नेचासल्यान गाउँपालिका', 14, 1),
(149, 'Thori', 'ठोरी गाउँपालिका', 15, 2),
(150, 'Jirabhawani', 'जिरा भवानी गाउँपालिका', 15, 2),
(151, 'Paterwasugauli', '	पटेर्वा सुगौली गाउँपालिका', 15, 2),
(152, 'SakhuwaPrasauni', 'सखुवा प्रसौनी गाउँपालिका', 15, 2),
(153, 'Parsagadhi', 'पर्सागढी नगरपालिका', 15, 2),
(154, 'Jagarnathpur', '	जगरनाथपुर गाउँपालिका', 15, 2),
(155, 'Dhobini', 'धोबीनी गाउँपालिका', 15, 2),
(156, 'Pokhariya', 'पोखरिया नगरपालिका', 15, 2),
(157, 'Bahudaramai', 'बहुदरमाई नगरपालिका', 15, 2),
(158, 'Birgunj', 'बिरगंज महानगरपालिका', 15, 2),
(159, 'Kalikamai', 'कालिकामाई गाउँपालिका', 15, 2),
(160, 'Bindabasini', 'बिन्दबासिनी गाउँपालिका', 15, 2),
(161, 'Chhipaharmai', 'छिपहरमाई गाउँपालिका', 15, 2),
(162, 'Pakahamainpur', 'पकाहा मैनपुर गाउँपालिका', 15, 2),
(163, 'Jitpur Simara', 'जीतपुर सिमरा उपमहानगरपालिका', 16, 2),
(164, 'Nigadh', 'निजगढ नगरपालिका', 16, 2),
(165, 'Kolhabi', 'कोल्हवी नगरपालिका', 16, 2),
(166, 'Kalaiya', 'कलैया उपमहानगरपालिका', 16, 2),
(167, 'Karaiyamai', '	करैयामाई गाउँपालिका', 16, 2),
(168, 'Baragadhi', 'बारागढीगाउँपालिका', 16, 2),
(169, 'AdarshKotwal', 'आदर्श कोटवाल गाउँपालिका', 16, 2),
(170, 'Mahangadhimai', 'महागढीमाई नगरपालिका', 16, 2),
(171, 'Devtal', '	देवताल गाउँपालिका', 16, 2),
(172, 'Suwarna', 'सुवर्ण गाउँपालिका', 16, 2),
(173, 'Simraungadh', 'सिम्रौनगढ नगरपालिका', 16, 2),
(174, 'Pacharauta', 'पचरौता नगरपालिका', 16, 2),
(175, 'Bishrampur', 'विश्रामपुर गाउँपालिका', 16, 2),
(176, 'Pheta', 'फेटा गाउँपालिका', 16, 2),
(177, 'Prasauni', '	प्रसौनी गाउँपालिका', 16, 2),
(178, 'Chandrapur', 'चन्द्रपुर नगरपालिका', 17, 2),
(179, 'Gujara', 'गुजरा नगरपालिका', 17, 2),
(180, 'Brindaban', 'बृन्दावन नगरपालिका', 17, 2),
(181, 'Kathariya', 'कटहरिया नगरपालिका', 17, 2),
(182, 'Phatuwa Bijayapur', 'फतुवाबिजयपुर नगरपालिका', 17, 2),
(183, 'Garuda', 'गरुडा नगरपालिका', 17, 2),
(184, 'Gadhimai', '	गढीमाई नगरपालिका', 17, 2),
(185, 'Maulapur', 'मौलापुर नगरपालिका', 17, 2),
(186, 'Debahhi Gonahi', 'देवाही गोनाही नगरपालिका', 17, 2),
(187, 'Baudhimai', 'बौधीमाई नगरपालिका', 17, 2),
(188, 'Paroha', 'परोहा नगरपालिका', 17, 2),
(189, 'Yamunamai', 'यमुनामाई गाउँपालिका', 17, 2),
(190, 'Durga Bhagawati', 'दुर्गा भगवती गाउँपालिका', 17, 2),
(191, 'Rajpur', 'राजपुर नगरपालिका', 17, 2),
(192, 'Ishanath', 'ईशनाथ नगरपालिका', 17, 2),
(193, 'Gaur', 'गौर नगरपालिका', 17, 2),
(194, 'Rajdevi', 'राजदेवी नगरपालिका', 17, 2),
(195, 'Bagmati', 'बागमती नगरपालिका', 18, 2),
(196, 'Hariwan', '	हरिवन नगरपालिका', 18, 2),
(197, 'Haripur', '	हरिपुर नगरपालिका', 18, 2),
(198, 'Ishworpur', 'ईश्वरपुर नगरपालिका', 18, 2),
(199, 'Barahathawa', 'बरहथवा नगरपालिका', 18, 2),
(200, 'Basbariya', 'बसबरीया गाउँपालिका', 18, 2),
(201, 'Kabilasi', '	कविलासी नगरपालिका', 18, 2),
(202, 'Chandranagar', 'चन्द्रनगर गाउँपालिका', 18, 2),
(203, 'Haripurwa', 'हरिपुर्वा नगरपालिका', 18, 2),
(204, 'Chakraghatta', 'चक्रघट्टा गाउँपालिका', 18, 2),
(205, 'Bramhapuri', 'ब्रह्मपुरी गाउँपालिका', 18, 2),
(206, 'Parsa', 'पर्सा गाउँपालिका', 18, 2),
(207, 'Malangawa', 'मलंगवा नगरपालिका', 18, 2),
(208, 'Kaudena', 'कौडेना गाउँपालिका', 18, 2),
(209, 'Godaita', 'गोडैटा नगरपालिका', 18, 2),
(210, 'Ramnagar', 'रामनगर गाउँपालिका', 18, 2),
(211, 'Bishnu', 'विष्णु गाउँपालिका', 18, 2),
(212, 'Balara', 'बलरा नगरपालिका', 18, 2),
(213, 'Bardibas', 'बर्दिबास नगरपालिका', 19, 2),
(214, 'Gaushala', 'गौशाला नगरपालिका', 19, 2),
(215, 'Sonama', 'सोनमा गाउँपालिका', 19, 2),
(216, 'Aurahi', 'औरही नगरपालिका', 19, 2),
(217, 'Bhangaha', 'भँगाहा नगरपालिका', 19, 2),
(218, 'Samsi', 'साम्सी गाउँपालिका', 19, 2),
(219, 'Ramgopalpur', 'रामगोपालपुर नगरपालिका', 19, 2),
(220, 'Balwa', 'बलवा नगरपालिका', 19, 2),
(221, 'Loharpatti', 'लोहरपट्टी नगरपालिका', 19, 2),
(222, 'Manra Siswa', 'मनरा शिसवा नगरपालिका', 19, 2),
(223, 'Maottari', 'महोत्तरी गाउँपालिका', 19, 2),
(224, 'Ekdanra', 'एकडारा गाउँपालिका', 19, 2),
(225, 'Jaleswor', 'जलेश्वर नगरपालिका', 19, 2),
(226, 'Matihani', 'मटिहानी नगरपालिका', 19, 2),
(227, 'Mithila', 'मिथिला नगरपालिका', 20, 2),
(228, 'Bateshwor', 'बटेश्वर गाउँपालिका', 20, 2),
(229, 'Dhanusadham', 'धनुषाधाम नगरपालिका', 20, 2),
(230, 'Ganeshman Charnath', 'गणेशमान चारनाथ नगरपालिका', 20, 2),
(231, 'Chhireshwornath', 'क्षिरेश्वरनाथ नगरपालिका', 20, 2),
(232, 'Lakshminiya', 'लक्ष्मीनिया गाउँपालिका', 20, 2),
(233, 'Mithila Bihari', 'मिथिला बिहारी नगरपालिका', 20, 2),
(234, 'Sabaila', 'सबैला नगरपालिका', 20, 2),
(235, 'Hansapur', 'हंसपुर नगरपालिका', 20, 2),
(236, 'Janakpurdham', 'जनकपुरधाम उपमहानगरपालिका', 20, 2),
(237, 'Aurahi', 'औरही गाउँपालिका', 20, 2),
(238, 'Sahidnagar', 'शहीदनगर नगरपालिका', 20, 2),
(239, 'Kamala', 'कमला नगरपालिका', 20, 2),
(240, 'Bideha', 'विदेह नगरपालिका', 20, 2),
(241, 'Janaknandani', 'जनकनन्दिनी गाउँपालिका', 20, 2),
(242, 'Dhanauji', 'धनौजी गाउँपालिका', 20, 2),
(243, 'Nagarain', 'नगराइन नगरपालिका', 20, 2),
(244, 'Mukhaiyapatti Musaharmiya', 'मुखियापट्टी मुसहरमिया गाउँपालिका', 20, 2),
(245, 'Karjanha', 'कर्जन्हा नगरपालिका', 21, 2),
(246, 'Mirchaiya', 'मिर्चैयाँ नगरपालिका', 21, 2),
(247, 'Kalyanpur', 'कल्याणपुर नगरपालिका', 21, 2),
(248, 'Bishnupur', 'विष्णुपुर गाउँपालिका', 21, 2),
(249, 'Siraha', 'सिरहा नगरपालिका', 21, 2),
(250, 'Arnama', 'अर्नमा गाउँपालिका', 21, 2),
(251, 'Lahan', 'लहान नगरपालिका', 21, 2),
(252, 'Naraha', '	नरहा गाउँपालिका', 21, 2),
(253, 'Dhangadhimai', 'धनगढीमाई नगरपालिका', 21, 2),
(254, 'Golbazar', 'गोलबजार नगरपालिका', 21, 2),
(255, 'Sukhipur', 'सुखीपुर नगरपालिका', 21, 2),
(256, 'Laxmipur', 'लक्ष्मीपुर पतारी गाउँपालिका', 21, 2),
(257, 'Aurahi', 'औरही गाउँपालिका', 21, 2),
(258, 'Bariyarpatti', 'बरियारपट्टी गाउँपालिका', 21, 2),
(259, 'Nawarajpur', 'नवराजपुर गाउँपालिका', 21, 2),
(260, 'Bhagawanpur', 'भगवानपुर गाउँपालिका', 21, 2),
(261, 'Surunga', 'सुरुङ्‍गा नगरपालिका', 22, 2),
(262, 'Khadak', 'खडक नगरपालिका', 22, 2),
(263, 'Shambhunath', 'शम्भुनाथ नगरपालिका', 22, 2),
(264, 'Rupani', 'रुपनी गाउँपालिका', 22, 2),
(265, 'Balan Bihul', 'बलान-बिहुल गाउँपालिका', 22, 2),
(266, 'Bode Barsain', 'बोदेबरसाईन नगरपालिका', 22, 2),
(267, 'Dakneshwori', 'डाक्नेश्वरी नगरपालिका', 22, 2),
(268, 'Agnisair Krishna Savaran', 'अग्निसाइर कृष्णासरवन गाउँपालिका', 22, 2),
(269, 'Saptkoshi', 'सप्तकोशी नगरपालिका', 22, 2),
(270, 'Kanchanrup', '	कञ्चनरुप नगरपालिका', 22, 2),
(271, 'Tirahut', 'तिरहुत गाउँपालिका', 22, 2),
(272, 'Mahadeva', 'महादेवा गाउँपालिका', 22, 2),
(273, 'Rajbiraj', 'राजविराज नगरपालिका', 22, 2),
(274, 'Hanumannagar Kankalini', 'हनुमाननगर कङ्‌कालिनी नगरपालिका', 22, 2),
(275, 'Tilathi Koladi', '	तिलाठी कोईलाडी गाउँपालिका', 22, 2),
(276, 'Chhinnamasta', 'छिन्नमस्ता गाउँपालिका', 22, 2),
(277, 'Rajgadh', 'राजगढ गाउँपालिका', 22, 2),
(278, 'Aamachhodingmo', 'आमाछोदिङमो गाउँपालिका', 37, 3),
(279, 'Gosainkunda', 'गोसाईकुण्ड गाउँपालिका', 37, 3),
(280, 'Uttargaya', 'उत्तरगया गाउँपालिका', 37, 3),
(281, 'Kalika', 'कालिका गाउँपालिका', 37, 3),
(282, 'Nakunda', 'नौकुण्ड गाउँपालिका', 37, 3),
(283, 'Madi', 'माडी नगरपालिका', 38, 3),
(284, 'Bharatpur', 'भरतपुर महानगरपालिका', 38, 3),
(285, 'Ratnangar', 'रत्ननगर नगरपालिका', 38, 3),
(286, 'Khairahani', 'खैरहनी नगरपालिका', 38, 3),
(287, 'Rapti', '	राप्ती नगरपालिका', 38, 3),
(288, 'Kalika', 'कालिका नगरपालिका', 38, 3),
(289, 'Ichchhyakamana', 'इच्छाकामना गाउँपालिका', 38, 3),
(290, 'Raksirang', 'राक्सिराङ्ग गाउँपालिका', 39, 3),
(291, 'Kailash', 'कैलाश गाउँपालिका', 39, 3),
(292, 'Thaha', 'थाहा नगरपालिका', 39, 3),
(293, 'Indrasarowar', 'इन्द्रसरोबर गाउँपालिका', 39, 3),
(294, 'Bhimphedi', 'भिमफेदी गाउँपालिका', 39, 3),
(295, 'Manahari', 'मनहरी गाउँपालिका', 39, 3),
(296, 'Makwanpurgadhi', '	मकवानपुरगढी गाउँपालिका', 39, 3),
(297, 'Hetauda', 'हेटौडा उपमहानगरपालिका', 39, 3),
(298, 'Bakaiya', 'बकैया गाउँपालिका', 39, 3),
(299, 'Bagmati', 'बाग्मति गाउँपालिका', 39, 3),
(300, 'Sunakoshi', 'सुनकोशी गाउँपालिका', 40, 3),
(301, 'Ganglekh', 'घ्याङलेख गाउँपालिका', 40, 3),
(302, 'Hariharpurgadhi', 'हरिहरपुरगढी गाउँपालिका', 40, 3),
(303, 'Marin', 'मरिण गाउँपालिका', 40, 3),
(304, 'Kamalamai', 'कमलामाई नगरपालिका', 40, 3),
(305, 'Golanjor', 'गोलन्जर गाउँपालिका', 40, 3),
(306, 'Phikkal', 'फिक्कल गाउँपालिका', 40, 3),
(307, 'Tinpatan', 'तीनपाटन गाउँपालिका', 40, 3),
(308, 'Dudhauli', 'दुधौली नगरपालिका', 40, 3),
(309, 'Rubi Valley', 'रुवी भ्याली गाउँपालिका', 41, 3),
(310, 'Gangajamuna', 'गङ्गाजमुना गाउँपालिका', 41, 3),
(311, 'Khaniyabash', 'खनियाबास गाउँपालिका', 41, 3),
(312, 'Tripura Sundari', 'त्रिपुरासुन्दरी गाउँपालिका', 41, 3),
(313, 'Netrawati Dabjong', 'नेत्रावती डबजोङ गाउँपालिका', 41, 3),
(314, 'Jwalamukhi', 'ज्वालामूखी गाउँपालिका', 41, 3),
(315, 'Nilakantha', 'निलकण्ठ नगरपालिका', 41, 3),
(316, 'Siddhalek', '	सिद्धलेक गाउँपालिका', 41, 3),
(317, 'Galchhi', 'गल्छी गाउँपालिका', 41, 3),
(318, 'Benighat', 'बेनीघाट रोराङ्ग गाउँपालिका', 41, 3),
(319, 'Gajuri', 'गजुरी गाउँपालिका', 41, 3),
(320, 'Thakre', '	थाक्रे गाउँपालिका', 41, 3),
(321, 'Kispang', '	किस्पाङ गाउँपालिका', 42, 3),
(322, 'Myagang', 'म्यगङ गाउँपालिका', 42, 3),
(323, 'Bidur', 'विदुर नगरपालिका', 42, 3),
(324, 'Tarkeshwar', 'तारकेश्वर गाउँपालिका', 42, 3),
(325, 'Suryagadhi', 'सुर्यगढी गाउँपालिका', 42, 3),
(326, 'Likhu', 'लिखु गाउँपालिका', 42, 3),
(327, 'Tadi', 'तादी गाउँपालिका', 42, 3),
(328, 'Panchakanya', 'पञ्चकन्या गाउँपालिका', 42, 3),
(329, 'Dupcheswar', 'दुप्चेश्वर गाउँपालिका', 42, 3),
(330, 'Shivapuri', '	शिवपुरी गाउँपालिका', 42, 3),
(331, 'Kakani', 'ककनी गाउँपालिका', 42, 3),
(332, 'Belkotgadhi', '	बेलकोटगढी नगरपालिका', 42, 3),
(333, 'Lalitpur', 'ललितपुर महानगरपालिका', 43, 3),
(334, 'Mahalaxmi', 'महालक्ष्मी नगरपालिका', 43, 3),
(335, 'Godawari', '	गोदावरी नगरपालिका', 43, 3),
(336, 'Bagmati', 'बागमती गाउँपालिका', 43, 3),
(337, 'Mahankal', 'महाङ्काल गाउँपालिका', 43, 3),
(338, 'Konjyosom', 'कोन्ज्योसोम गाउँपालिका', 43, 3),
(339, 'Madhyapur Thimi', 'मध्यपुर थिमी नगरपालिका', 44, 3),
(340, 'Changunarayan', 'चाँगुनारायण नगरपालिका', 44, 3),
(341, 'Bhaktapur', '	भक्तपुर नगरपालिका', 44, 3),
(342, 'Suryabinayak', '	सूर्यविनायक नगरपालिका', 44, 3),
(343, 'Dakshinkali', 'दक्षिणकाली नगरपालिका', 45, 3),
(344, 'Kirtipur', 'कीर्तिपुर नगरपालिका', 45, 3),
(345, 'Chandragiri', 'चन्द्रागिरी नगरपालिका', 45, 3),
(346, 'Kathmandu', 'काठमाण्डौं महानगरपालिका', 45, 3),
(347, 'Nagarjun', 'नागार्जुन नगरपालिका', 45, 3),
(348, 'Tarakeshwar', 'तारकेश्वर नगरपालिका', 45, 3),
(349, 'Budhanilkanth', 'बुढानिलकण्ठ नगरपालिका', 45, 3),
(350, 'Tokha', 'टोखा नगरपालिका', 45, 3),
(351, 'Gokarneshwar', 'गोकर्णेश्वर नगरपालिका', 45, 3),
(352, 'Shankarapur', 'शङ्खरापुर नगरपालिका', 45, 3),
(353, 'Kageshwori Manahora', 'कागेश्वरी मनोहरा नगरपालिका', 45, 3),
(354, 'Mandendeupur', 'मण्डनदेउपुर नगरपालिका', 46, 3),
(355, 'Banepa', 'बनेपा नगरपालिका', 46, 3),
(356, 'Panauti', 'पनौती नगरपालिका', 46, 3),
(357, 'Dhulikhel', 'धुलिखेल नगरपालिका', 46, 3),
(358, 'Panchkhal', 'पाँचखाल नगरपालिका', 46, 3),
(359, 'Bhumlu', 'भुम्लु गाउँपालिका', 46, 3),
(360, 'Chaurideurali', 'चौंरीदेउराली गाउँपालिका', 46, 3),
(361, 'Temal', '	तेमाल गाउँपालिका', 46, 3),
(362, 'Namobuddha', 'नमोबुद्ध नगरपालिका', 46, 3),
(363, 'Rosi', 'रोशी गाउँपालिका', 46, 3),
(364, 'Khanikhola', 'खानीखोला गाउँपालिका', 46, 3),
(365, 'Mahabharat', 'महाभारत गाँउपालिका', 46, 3),
(366, 'Doramba', 'दोरम्बा गाउँपालिका', 47, 3),
(367, 'Sunapati', 'सुनापती गाउँपालिका', 47, 3),
(368, 'Khadadevi', 'खाँडादेवी गाउँपालिका', 47, 3),
(369, 'Manthali', 'मन्थली नगरपालिका', 47, 3),
(370, 'Ramechhap', '	रामेछाप नगरपालिका', 47, 3),
(371, 'Likhu Tamakoshi', 'लिखु तामाकोशी गाउँपालिका', 47, 3),
(372, 'Gokulganga', 'गोकुलगङ्गा गाउँपालिका', 47, 3),
(373, 'Umakunda', 'उमाकुण्ड गाउँपालिका', 47, 3),
(374, 'Bigu', 'विगु गाउँपालिका', 48, 3),
(375, 'Gaurishankhar', 'गौरीशङ्कर गाउँपालिका', 48, 3),
(376, 'Kalinchok', 'कालिन्चोक गाउँपालिका', 48, 3),
(377, 'Jiri', '	जिरी नगरपालिका', 48, 3),
(378, 'Bhimeshwar', 'भिमेश्वर नगरपालिका', 48, 3),
(379, 'Baiteshwar', 'वैतेश्वर गाउँपालिका', 48, 3),
(380, 'Sailung', 'शैलुङ्ग गाउँपालिका', 48, 3),
(381, 'Melung', 'मेलुङ्ग गाउँपालिका', 48, 3),
(382, 'Tamakoshi', 'तामाकोशी गाउँपालिका', 48, 3),
(383, 'Helambu', '	हेलम्बु गाउँपालिका', 49, 3),
(384, 'Panchapokhari Thangpal', '	पाँचपोखरी थाङपाल गाउँपालिका', 49, 3),
(385, 'Jugal', 'जुगल गाउँपालिका', 49, 3),
(386, 'Bhotekoshi', 'भोटेकोशी गाउँपालिका', 49, 3),
(387, 'Melamchi', 'मेलम्ची नगरपालिका', 49, 3),
(388, 'Barhabise', 'बाह्रविसे नगरपालिका', 49, 3),
(389, 'Tripurasundari', 'त्रिपुरासुन्दरी गाउँपालिका', 49, 3),
(390, 'Sunkoshi', 'सुनकोशी गाउँपालिका', 49, 3),
(391, 'Lisangkhu Pakhar', 'लिसङ्खु पाखर गाउँपालिका', 49, 3),
(392, 'Indrawati', 'ईन्द्रावती गाउँपालिका', 49, 3),
(393, 'Balefi', 'बलेफी गाउँपालिका', 49, 3),
(394, 'Chautara Sangachokgadhi', 'चौतारा साँगाचोकगढी नगरपालिका', 49, 3),
(395, 'Narpa Bhumi', 'नार्पा भूमि गाउँपालिका', 50, 4),
(396, 'Chame', 'चामे गाउँपालिका', 50, 4),
(397, 'Nason', 'नासोँ गाउँपालिका', 50, 4),
(398, 'Manang Ngisyang', 'मनाङ ङिस्याङ गाउँपालिका', 50, 4),
(399, 'Lomanthang', 'लोमन्थाङ गाउँपालिका', 51, 4),
(400, 'Lo Gherkar Damodarkunda', 'लो-घेकर दामोदरकुण्ड गाउँपालिका', 51, 4),
(401, 'Varagung Muktichhetra', 'वारागुङ मुक्तिक्षेत्र गाउँपालिका', 51, 4),
(402, 'Gharapjhong', 'घरपझोङ गाउँपालिका', 51, 4),
(403, 'Thasang', 'थासाङ गाउँपालिका', 51, 4),
(404, 'Chum Nubri', 'चुमनुव्री गाउँपालिका', 52, 4),
(405, 'Dharche', '	धार्चे गाउँपालिका', 52, 4),
(406, 'Ajirkot', 'अजिरकोट गाउँपालिका', 52, 4),
(407, 'Barpak', 'बारपाक सुलिकोट गाउँपालिका', 52, 4),
(408, 'Gandaki Rural Municipality', 'गण्डकी गाउँपालिका', 52, 4),
(409, 'Aarughat', 'आरूघाट गाउँपालिका', 52, 4),
(410, 'Siranchok', 'सिरानचोक गाउँपालिका', 52, 4),
(411, 'Palungtar', 'पालुङटार नगरपालिका', 52, 4),
(412, 'Bhimsenthapa', 'भिमसेनथापा गाउँपालिका', 52, 4),
(413, 'Gorkha', 'गोरखा नगरपालिका', 52, 4),
(414, 'Sahid Lekhan', 'शहिद लखन गाउँपालिका', 52, 4),
(415, 'Marsyangdi', 'मर्स्याङदी गाउँपालिका', 53, 4),
(416, 'Kwholwsothar', 'क्व्होलासोथार गाउँपालिका', 53, 4),
(417, 'Besisahar', 'बेसीशहर नगरपालिका', 53, 4),
(418, 'Dordi', 'दोर्दी गाउँपालिका', 53, 4),
(419, 'Dudhpokhari', 'दूधपोखरी गाउँपालिका', 53, 4),
(420, 'Madhyanepal', 'मध्यनेपाल नगरपालिका', 53, 4),
(421, 'Sundarbazar', 'सुन्दरबजार नगरपालिका', 53, 4),
(422, 'Rainas', 'रार्इनास नगरपालिका', 53, 4),
(423, 'Annapurna', 'अन्नपूर्ण गाउँपालिका', 54, 4),
(424, 'Machhapuchchhre', 'माछापुच्छ्रे गाउँपालिका', 54, 4),
(425, 'Madi', 'मादी गाउँपालिका', 54, 4),
(426, 'Pokhara', 'पोखरा महानगरपालिका', 54, 4),
(427, 'Rupa', 'रूपा गाउँपालिका', 54, 4),
(428, 'Shuklagandaki', 'शुक्लागण्डकी नगरपालिका', 55, 4),
(429, 'Bhimad', 'भिमाद नगरपालिका', 55, 4),
(430, 'Magde', 'म्याग्दे गाउँपालिका', 55, 4),
(431, 'Vyas', 'व्यास नगरपालिका', 55, 4),
(432, 'Bhanu', 'भानु नगरपालिका', 55, 4),
(433, 'Bandipur', 'वन्दिपुर गाउँपालिका', 55, 4),
(434, 'Anbukhaireni', 'आँबुखैरेनी गाउँपालिका', 55, 4),
(435, 'Devghat', 'देवघाट गाउँपालिका', 55, 4),
(436, 'Rhising', 'ऋषिङ्ग गाउँपालिका', 55, 4),
(437, 'Ghiring', 'घिरिङ गाउँपालिका', 55, 4),
(438, 'Baudikali', 'बौदीकाली गाउँपालिका', 56, 4),
(439, 'Bulingtar', 'बुलिङटार गाउँपालिका', 56, 4),
(440, 'Hupsekot', 'हुप्सेकोट गाउँपालिका', 56, 4),
(441, 'Devchuli', 'देवचुली नगरपालिका', 56, 4),
(442, 'Gaidakot', '	गैडाकोट नगरपालिका', 56, 4),
(443, 'Kawasoti', 'कावासोती नगरपालिका', 56, 4),
(444, 'Madhyabindu', '	मध्यविन्दु नगरपालिका', 56, 4),
(445, 'Binayee Tribeni', 'विनयी त्रिवेणी गाउँपालिका', 56, 4),
(446, 'Kaligandaki', '	कालीगण्डकी गाउँपालिका', 57, 4),
(447, 'Galyang', 'गल्याङ नगरपालिका', 57, 4),
(448, 'Chapakot', 'चापाकोट नगरपालिका', 57, 4),
(449, 'Waling', '	वालिङ नगरपालिका', 57, 4),
(450, 'Biruwa', 'बिरुवा गाउँपालिका', 57, 4),
(451, 'Harinas', 'हरिनास गाउँपालिका', 57, 4),
(452, 'Bhirkot', '	भीरकोट नगरपालिका', 57, 4),
(453, 'Arjunchaupari', '	अर्जुनचौपारी गाउँपालिका', 57, 4),
(454, 'Putalibazar', 'पुतलीबजार नगरपालिका', 57, 4),
(455, 'Aandhikhola', 'आँधिखोला गाउँपालिका', 57, 4),
(456, 'Phedikhola', 'फेदीखोला गाउँपालिका', 57, 4),
(457, 'Jaljala', 'जलजला गाउँपालिका', 58, 4),
(458, 'Modi', 'मोदी गाउँपालिका', 58, 4),
(459, 'Kushma', '	कुश्मा नगरपालिका', 58, 4),
(460, 'Phalebas', 'फलेवास नगरपालिका', 58, 4),
(461, 'Mahashila', '	महाशिला गाउँपालिका', 58, 4),
(462, 'Bihadi', 'विहादी गाउँपालिका', 58, 4),
(463, 'Painyu', 'पैयूं गाउँपालिका', 58, 4),
(464, 'Nisikhola', '	निसीखोला गाउँपालिका', 59, 4),
(465, 'Dhorpatan', 'ढोरपाटन नगरपालिका', 59, 4),
(466, 'Taman khola', 'तमानखोला गाउँपालिका', 59, 4),
(467, 'Badigad', '	वडिगाड गाउँपालिका', 59, 4),
(468, 'Tara Khola', 'ताराखोला गाउँपालिका', 59, 4),
(469, 'Galkot', 'गल्कोट नगरपालिका', 59, 4),
(470, 'Kanthekhola', 'काठेखोला गाउँपालिका', 59, 4),
(471, 'Baglung', '	बागलुङ नगरपालिका', 59, 4),
(472, 'Jaimuni', '	जैमूनी नगरपालिका', 59, 4),
(473, 'Bareng', '	वरेङ गाउँपालिका', 59, 4),
(474, 'Dhaulagiri', '	धवलागिरी गाउँपालिका', 60, 4),
(475, 'Malika', 'मालिका गाउँपालिका', 60, 4),
(476, 'Raghuganga', 'रघुगंगा गाउँपालिका', 60, 4),
(477, 'Annapurna', 'अन्नपुर्ण गाउँपालिका', 60, 4),
(478, 'Mangala', '	मंगला गाउँपालिका', 60, 4),
(479, 'Beni', 'बेनी नगरपालिका', 60, 4),
(480, 'Geruwa', 'गेरुवा गाउँपालिका', 61, 5),
(481, 'Rajapur', 'राजापुर नगरपालिका', 61, 5),
(482, 'Thakurbaba', 'ठाकुरबाबा नगरपालिका', 61, 5),
(483, 'Madhuban', '	मधुवन नगरपालिका', 61, 5),
(484, 'Barbardiya', '	बारबर्दिया नगरपालिका', 61, 5),
(485, 'Bansgadhi', 'बाँसगढी नगरपालिका', 61, 5),
(486, 'Gulariya', 'गुलरिया नगरपालिका', 61, 5),
(487, 'Badhaiyatal', 'बढैयाताल गाउँपालिका', 61, 5),
(488, 'Baijanath', 'बैजनाथ गाउँपालिका', 62, 5),
(489, 'Kohalpur', 'कोहलपुर नगरपालिका', 62, 5),
(490, 'Khajura', '	खजुरा गाउँपालिका', 62, 5),
(491, 'Janaki', '	जानकी गाउँपालिका', 62, 5),
(492, 'Nepalgunj', 'नेपालगंज उपमहानगरपालिका', 62, 5),
(493, 'Duduwa', 'डुडुवा गाउँपालिका', 62, 5),
(494, 'Rapti Sonari', 'राप्ती सोनारी गाउँपालिका', 62, 5),
(495, 'Narainapur', 'नरैनापुर गाउँपालिका', 62, 5),
(496, 'Babai', '	बबई गाउँपालिका', 63, 5),
(497, 'Shantinagar', '	शान्तिनगर गाउँपालिका', 63, 5),
(498, 'Dangisharan', 'दंगीशरण गाउँपालिका', 63, 5),
(499, 'Tulsipur', '	तुल्सीपुर उपमहानगरपालिका', 63, 5),
(500, 'Ghorahi', 'घोराही उपमहानगरपालिका', 63, 5),
(501, 'Lamahi', 'लमही नगरपालिका', 63, 5),
(502, 'Banglachuli', 'बंगलाचुली गाउँपालिका', 63, 5),
(503, 'Rapti', 'राप्ती गाउँपालिका', 63, 5),
(504, 'Rajpur', 'राजपुर गाउँपालिका', 63, 5),
(505, 'Gadhawa', 'गढवा गाउँपालिका', 63, 5),
(506, 'Gangadev', 'गंगादेव गाउँपालिका', 64, 5),
(507, 'Madi', 'माडी गाउँपालिका', 64, 5),
(508, 'Tribeni', '	त्रिवेणी गाउँपालिका', 64, 5),
(509, 'Runtigadhi', 'रुन्टीगढी गाउँपालिका', 64, 5),
(510, 'Sunil Smriti', 'सुनिल स्मृति गाउँपालिका', 64, 5),
(511, 'Lungri', '	लुङग्री गाउँपालिका', 64, 5),
(512, 'Rolpa', '	रोल्पा नगरपालिका', 64, 5),
(513, 'Sunchhahari', 'सुनछहरी गाउँपालिका', 64, 5),
(514, 'Thawang', 'थवाङ गाउँपालिका', 64, 5),
(515, 'Pariwartan', '	परिवर्तन गाउँपालिका', 64, 5),
(516, 'Sisne', '	सिस्ने गाउँपालिका', 65, 5),
(517, 'Bhume', 'भूमे गाउँपालिका', 65, 5),
(518, 'Putha Uttarganga', '	पुथा उत्तरगंगा गाउँपालिका', 65, 5),
(519, 'Naubahini', 'नौवहिनी गाउँपालिका', 67, 5),
(520, 'Gaumukhi', '	गौमुखी गाउँपालिका', 67, 5),
(521, 'Jhimruk', '	झिमरुक गाउँपालिका', 67, 5),
(522, 'Pyuthan', '	प्यूठान नगरपालिका', 67, 5),
(523, 'Mallarani', '	मल्लरानी गाउँपालिका', 67, 5),
(524, 'Swargadwari', '	स्वर्गद्वारी नगरपालिका', 67, 5),
(525, 'Mandavi', 'माण्डवी गाउँपालिका', 67, 5),
(526, 'Sarumarani', 'सरुमारानी गाउँपालिका', 67, 5),
(527, 'Ayirabati', 'ऐरावती गाउँपालिका', 67, 5),
(528, 'Malika', 'मालिका गाउँपालिका', 68, 5),
(529, 'Madane', '	मदाने गाउँपालिका', 68, 5),
(530, 'Dhurkot', 'धुर्कोट गाउँपालिका', 68, 5),
(531, 'Isma', 'ईस्मा गाउँपालिका', 68, 5),
(532, 'Musikot', '	मुसिकोट नगरपालिका', 68, 5),
(533, 'Resunga', 'रेसुङ्गा नगरपालिका', 68, 5),
(534, 'Gulmidarbar', 'गुल्मी दरबार गाउँपालिका', 68, 5),
(535, 'Chandrakot', '	चन्द्रकोट गाउँपालिका', 68, 5),
(536, 'Satyawati', 'सत्यवती गाउँपालिका', 68, 5),
(537, 'Kaligandaki', '	कालीगण्डकी गाउँपालिका', 68, 5),
(538, 'Chatrakot', '	छत्रकोट गाउँपालिका', 68, 5),
(539, 'RuruKshetra', 'रुरुक्षेत्र गाउँपालिका', 68, 5),
(540, 'Malarani', 'मालारानी गाउँपालिका', 69, 5),
(541, 'Bhumekasthan', 'भूमिकास्थान नगरपालिका', 69, 5),
(542, 'Sandhikharka', 'सन्धिखर्क नगरपालिका', 69, 5),
(543, 'Chhatradev', 'छत्रदेव गाउँपालिका', 69, 5),
(544, 'Panini', 'पाणिनी गाउँपालिका', 69, 5),
(545, 'Sitganga', 'शितगंगा नगरपालिका', 69, 5),
(546, 'Bijayanagar', 'विजयनगर गाउँपालिका', 70, 5),
(547, 'Shivaraj', 'शिवराज नगरपालिका', 70, 5),
(548, 'Budhdhabhumi', 'बुद्धभुमी नगरपालिका', 70, 5),
(549, 'Krishnanagar', '	कृष्णनगर नगरपालिका', 70, 5),
(550, 'Maharajgunj', '	महाराजगंज नगरपालिका', 70, 5),
(552, 'Banganga', '	बाणगंगा नगरपालिका', 70, 5),
(553, 'Yasodhara', '	यसोधरा गाउँपालिका', 70, 5),
(554, 'Mayadevi', 'मायादेवी गाउँपालिका', 70, 5),
(555, 'Sudhodhan', 'सुद्धोधन गाउँपालिका', 70, 5),
(556, 'Rainadevi Chhahara', 'रैनादेवी छहरा गाउँपालिका', 71, 5),
(557, 'Ridikot', 'रिब्दिकोट गाउँपालिका', 71, 5),
(558, 'Tansen', '	तानसेन नगरपालिका', 71, 5),
(559, 'Tinau', '	तिनाउ गाउँपालिका', 71, 5),
(560, 'Bagnaskali', '	बगनासकाली गाउँपालिका', 71, 5),
(561, 'Rambha', 'रम्भा गाउँपालिका', 71, 5),
(562, 'Mathagadhi', 'माथागढी गाउँपालिका', 71, 5),
(563, 'Purbakhola', '	पूर्वखोला गाउँपालिका', 71, 5),
(564, 'Rampur', '	रामपुर नगरपालिका', 71, 5),
(565, 'Nisdi', '	निस्दी गाउँपालिका', 71, 5),
(566, 'Sunwal', 'सुनवल नगरपालिका', 73, 5),
(567, 'Bardaghat', '	बर्दघाट नगरपालिका', 73, 5),
(568, 'Ramgram', 'रामग्राम नगरपालिका', 73, 5),
(569, 'Sarawal', 'सरावल गाउँपालिका', 73, 5),
(570, 'Palhi Nandan', 'पाल्हीनन्दन गाउँपालिका', 73, 5),
(571, 'Pratappur', '	प्रतापपुर गाउँपालिका', 73, 5),
(573, 'Sainamaina', '	सैनामैना नगरपालिका', 72, 5),
(574, 'Butwal', 'बुटवल उपमहानगरपालिका', 72, 5),
(575, 'Devdaha', '	देवदह नगरपालिका', 72, 5),
(576, 'Kanchan', 'कन्चन गाउँपालिका', 72, 5),
(577, 'Gaidahawa', 'गैडहवा गाउँपालिका', 72, 5),
(578, 'Sudhdhodhan', '	शुद्धोधन गाउँपालिका', 72, 5),
(579, 'Tilotam', 'तिलोत्तमा नगरपालिका', 72, 5),
(580, 'Siyari', '	सियारी गाउँपालिका', 72, 5),
(581, 'Om Satiya', 'ओमसतिया गाउँपालिका', 72, 5),
(582, 'Rohini', 'रोहिणी गाउँपालिका', 72, 5),
(583, 'Siddharthanagar', 'सिद्धार्थनगर नगरपालिका', 72, 5),
(584, 'Mayadevi', '	मायादेवी गाउँपालिका', 72, 5),
(585, 'Lumbini Sanskritik', '	लुम्बिनी सांस्कृतिक नगरपालिका', 72, 5),
(586, 'Kotahimai', 'कोटहीमाई गाउँपालिका', 72, 5),
(587, 'Sammarimai', '	सम्मरीमाई गाउँपालिका', 72, 5),
(588, 'Marchawari', 'मर्चवारी गाउँपालिका', 72, 5),
(589, 'Namkha', '	नाम्खा गाउँपालिका', 74, 6),
(590, 'Simkot', 'सिमकोट गाउँपालिका', 74, 6),
(591, 'Kharpunath', 'खार्पुनाथ गाउँपालिका', 74, 6),
(592, 'Sarkegad', 'सर्केगाड गाउँपालिका', 74, 6),
(593, 'Chankheli', '	चंखेली गाउँपालिका', 74, 6),
(594, 'Adanchuli', '	अदानचुली गाउँपालिका', 74, 6),
(595, 'Tanjakot', '	ताँजाकोट गाउँपालिका', 74, 6),
(596, 'Palata', 'पलाता गाउँपालिका', 75, 6),
(597, 'Sanni Tribeni', 'सान्नी त्रिवेणी गाउँपालिका', 75, 6),
(598, 'Raskot', 'रास्कोट नगरपालिका', 75, 6),
(599, 'Pachjharana', 'पचालझरना गाउँपालिका', 75, 6),
(600, 'Naraharinath', 'नरहरिनाथ गाउँपालिका', 75, 6),
(601, 'Khandachakra', 'खाँडाचक्र नगरपालिका', 75, 6),
(602, 'Tilugufa', '	तिलागुफा नगरपालिका', 75, 6),
(603, 'Shuva Kalika', 'शुभ कालीका गाउँपालिका', 75, 6),
(604, 'Mahawai', 'महावै गाउँपालिका', 75, 6),
(605, 'Soru', 'सोरु गाउँपालिका', 76, 6),
(606, 'Khatyad', '	खत्याड गाउँपालिका', 76, 6),
(607, 'Chhayanath Rara', 'छायाँनाथ रारा नगरपालिका', 76, 6),
(608, 'Mugum Kharmarong', 'मुगुम कार्मारोंग गाउँपालिका', 76, 6),
(609, 'Kanaka Sundari', 'कनकासुन्दरी गाउँपालिका', 77, 6),
(610, 'Sinja', 'सिंजा गाउँपालिका', 77, 6),
(611, 'Patrasi', '	पातारासी गाउँपालिका', 77, 6),
(612, 'Chandannath', 'चन्दननाथ नगरपालिका', 77, 6),
(613, 'Tila', '	तिला गाउँपालिका', 77, 6),
(614, 'Tatopani', '	तातोपानी गाउँपालिका', 77, 6),
(615, 'Guthichaur', 'गुठिचौर गाउँपालिका', 77, 6),
(616, 'Shey phoksundo', '	शे फोक्सुन्डो गाउँपालिका', 78, 6),
(617, 'Dolpo Buddha', '	डोल्पो बुद्ध गाउँपालिका', 78, 6),
(618, 'Jagadulla', 'जगदुल्ला गाउँपालिका', 78, 6),
(619, 'Mudkechula', '	मुड्केचुला गाउँपालिका', 78, 6),
(620, 'Tripurasundari', 'त्रिपुरासुन्दरी नगरपालिका', 78, 6),
(621, 'Thuli Bheri', 'ठूली भेरी नगरपालिका', 78, 6),
(622, 'Kaike', '	काईके गाउँपालिका', 78, 6),
(623, 'Chharka Tangsong', 'छार्का ताङसोङ गाउँपालिका', 78, 6),
(624, 'Aathbis', 'आठबीस नगरपालिका', 79, 6),
(625, 'Thantikandh', 'ठाँटीकाँध गाउँपालिका', 79, 6),
(626, 'Bhairabi', '	भैरवी गाउँपालिका', 79, 6),
(627, 'Mahabu', 'महावु गाउँपालिका', 79, 6),
(628, 'Chamunda Bindrasaini', 'चामुण्डा विन्द्रासैनी नगरपालिका', 79, 6),
(629, 'Dullu', 'दुल्लु नगरपालिका', 79, 6),
(630, 'Narayan', 'नारायण नगरपालिका', 79, 6),
(631, 'Naumule', 'नौमुले गाउँपालिका', 79, 6),
(632, 'Bhagawatimai', '	भगवतीमाई गाउँपालिका', 79, 6),
(633, 'Dungeshwor', 'डुंगेश्वर गाउँपालिका', 79, 6),
(634, 'Gurans', '	गुराँस गाउँपालिका', 79, 6),
(635, 'Chaukune', 'चौकुने गाउँपालिका', 80, 6),
(636, 'Panchapuri', 'पञ्चपुरी नगरपालिका', 80, 6),
(637, 'Barahtal', 'बराहताल गाउँपालिका', 80, 6),
(638, 'Birendranagar', 'बीरेन्द्रनगर नगरपालिका', 80, 6),
(639, 'Lekbeshi', 'लेकवेशी नगरपालिका', 80, 6),
(640, 'Chingad', '	चिङ्गाड गाउँपालिका', 80, 6),
(641, 'Simta', '	सिम्ता गाउँपालिका', 80, 6),
(642, 'Bheriganga', 'भेरीगंगा नगरपालिका', 80, 6),
(643, 'Gurbhakot', 'गुर्भाकोट नगरपालिका', 80, 6),
(644, 'Kalimati', 'कालिमाटी गाउँपालिका', 81, 6),
(645, 'Tribeni', '	त्रिवेणी गाउँपालिका', 81, 6),
(646, 'Kapurkot', 'कपुरकोट गाउँपालिका', 81, 6),
(647, 'Chhatraeshwori', '	छत्रेश्वरी गाउँपालिका', 81, 6),
(648, 'Sharada', '	शारदा नगरपालिका', 81, 6),
(649, 'Siddha Kumakh', '	सिद्ध कुमाख गाउँपालिका', 81, 6),
(650, 'Bagchaur', 'बागचौर नगरपालिका', 81, 6),
(651, 'Darma', '	दार्मा गाउँपालिका', 81, 6),
(652, 'Kumakh', 'कुमाख गाउँपालिका', 81, 6),
(653, 'Bangad Kupinde', 'बनगाड कुपिण्डे नगरपालिका', 81, 6),
(654, 'Athbiskot', 'आठबिसकोट नगरपालिका', 82, 6),
(655, 'Banfikot', 'बाँफिकोट गाउँपालिका', 82, 6),
(656, 'Sani Bheri', 'सानी भेरी गाउँपालिका', 82, 6),
(657, 'Musikot', '	मुसिकोट नगरपालिका', 82, 6),
(658, 'Chaurjahari', '	चौरजहारी नगरपालिका', 82, 6),
(659, 'Tribeni', 'त्रिवेणी गाउँपालिका', 82, 6),
(660, 'Barekot', 'बारेकोट गाउँपालिका', 83, 6),
(661, 'Nalgad', '	नलगाड नगरपालिका', 83, 6),
(662, 'Kuse', '	कुसे गाउँपालिका', 83, 6),
(663, 'Junichande', 'जुनीचाँदे गाउँपालिका', 83, 6),
(664, 'Chhedagad', '	छेडागाड नगरपालिका', 83, 6),
(665, 'Bheri', 'भेरी नगरपालिका', 83, 6),
(666, 'Siwalaya', '	शिवालय गाउँपालिका', 83, 6),
(667, 'Byas', 'ब्याँस गाउँपालिका', 84, 7),
(668, 'Apihimal', 'अपिहिमाल गाउँपालिका', 84, 7),
(669, 'Dunhu', 'दुहुँ गाउँपालिका', 84, 7),
(670, 'Mahakali', '	महाकाली नगरपालिका', 84, 7),
(671, 'Naugad', 'नौगाड गाउँपालिका', 84, 7),
(672, 'Marma', 'मार्मा गाउँपालिका', 84, 7),
(673, 'MalikaArjun', 'मालिकार्जुन गाउँपालिका', 84, 7),
(674, 'Shailesikhar', 'शैल्यशिखर नगरपालिका', 84, 7),
(675, 'Lekam', 'लेकम गाउँपालिका', 84, 7),
(676, 'Dilasaini', 'डीलासैनी गाउँपालिका', 85, 7),
(677, 'Purchaudi', 'पुर्चौडी नगरपालिका', 85, 7),
(678, 'Dogadakedar', 'दोगडाकेदार गाउँपालिका', 85, 7),
(679, 'Surnaya', 'सुर्नया गाउँपालिका', 85, 7),
(680, 'Patan', 'पाटन नगरपालिका', 85, 7),
(681, 'Sigas', '	सिगास गाउँपालिका', 85, 7),
(682, 'Dashrathchanda', 'दशरथचन्द नगरपालिका', 85, 7),
(683, 'Pancheshwor', 'पञ्चेश्वर गाउँपालिका', 85, 7),
(684, 'Melauli', 'मेलौली नगरपालिका', 85, 7),
(685, 'Shivanath', 'शिवनाथ गाउँपालिका', 85, 7),
(686, 'Sailpal', 'साइपाल गाउँपालिका', 86, 7),
(687, 'Surma', 'सूर्मा गाउँपालिका', 86, 7),
(688, 'Talikot', 'तलकोट गाउँपालिका', 86, 7),
(689, 'Bungal', 'बुंगल नगरपालिका', 86, 7),
(690, 'Bithadchir', '	वित्थडचिर गाउँपालिका', 86, 7),
(691, 'Kedarseu', 'केदारस्युँ गाउँपालिका', 86, 7),
(692, 'Durgathali', '	दुर्गाथली गाउँपालिका', 86, 7),
(693, 'Jayaprithivi', 'जयपृथ्वी नगरपालिका', 86, 7),
(694, 'Masta', 'मष्टा गाउँपालिका', 86, 7),
(695, 'Chabispathivera', '	छबिसपाथिभेरा गाउँपालिका', 86, 7),
(696, 'Thalara', 'थलारा गाउँपालिका', 86, 7),
(697, 'Khaptadchhanna', '	खप्तडछान्ना गाउँपालिका', 86, 7),
(698, 'Himali', 'हिमाली गाउँपालिका', 87, 7),
(699, 'Gaumul', 'गौमुल गाउँपालिका', 87, 7),
(700, 'Budhinand', '	बुढीनन्दा नगरपालिका', 87, 7),
(701, 'Badimalika', '	बडीमालिका नगरपालिका', 87, 7),
(702, 'Jagannath', 'जगन्‍नाथ गाउँपालिका', 87, 7),
(703, 'Tribeni', 'त्रिवेणी नगरपालिका', 87, 7),
(704, 'Budhiganga', 'बुढीगंगा नगरपालिका', 87, 7),
(705, 'Khapdad Chhededaha', 'खप्तड छेडेदह गाउँपालिका', 87, 7),
(706, 'Ajaymeru', 'अजयमेरु गाउँपालिका', 88, 7),
(707, 'Nawadurga', 'नवदुर्गा गाउँपालिका', 88, 7),
(708, 'Amargadhi', '	अमरगढी नगरपालिका', 88, 7),
(709, 'Bhageshwar', 'भागेश्वर गाउँपालिका', 88, 7),
(710, 'Alital', 'आलिताल गाउँपालिका', 88, 7),
(711, 'Parashuram', 'परशुराम नगरपालिका', 88, 7),
(712, 'Sayal', 'सायल गाउँपालिका', 89, 7),
(713, 'Adharsha', 'आदर्श गाउँपालिका', 89, 7),
(714, 'Purbichauki', '	पूर्वीचौकी गाउँपालिका', 89, 7),
(715, 'Dipayal silgadi', 'दिपायल सिलगढी नगरपालिका', 89, 7),
(716, 'Shikhar', 'शिखर नगरपालिका', 89, 7),
(717, 'K.I. Singh', 'के.आई.सिं. गाउँपालिका', 89, 7),
(718, 'Jorayal', 'जोरायल गाउँपालिका', 89, 7),
(719, 'Bandikedar', 'बडीकेदार गाउँपालिका', 89, 7),
(720, 'Bogatan Phudsil', 'बोगटान फुड्सिल गाउँपालिका', 89, 7),
(721, 'Sanphebagar', 'साँफेबगर नगरपालिका', 90, 7),
(722, 'Mallekh', '	मेल्लेख गाउँपालिका', 90, 7),
(723, 'Chaurapati', '	चौरपाटी गाउँपालिका', 90, 7),
(724, 'Bannigadhi Jayagadh', 'बान्निगढी जयगढ गाउँपालिका', 90, 7),
(725, 'Ramroshan', 'रामारोशन गाउँपालिका', 90, 7),
(726, 'Mangalsen', '	मंगलसेन नगरपालिका', 90, 7),
(727, 'Kamalbazar', '	कमलबजार नगरपालिका', 90, 7),
(728, 'Panchadewai Binayak', 'पन्चदेवल विनायक नगरपालिका', 90, 7),
(729, 'Dhakari', '	ढकारी गाउँपालिका', 90, 7),
(730, 'Turmakhad', '	तुर्माखाँद गाउँपालिका', 90, 7),
(731, 'Bhimadatta', 'भीमदत्त नगरपालिका', 91, 7),
(732, 'Bedkot', 'वेदकोट नगरपालिका', 91, 7),
(733, 'Shuklaphanta', 'शुक्लाफाँटा नगरपालिका', 91, 7),
(734, 'Krishnapur', 'कृष्णपुर नगरपालिका', 91, 7),
(735, 'Beldandi', '	बेलडाडी गाउँपालिका', 91, 7),
(736, 'Lajhadi', 'लालझाडी गाउँपालिका', 91, 7),
(737, 'Belauri', '	बेलौरी नगरपालिका', 91, 7),
(738, 'Purnabas', 'पुर्नवास नगरपालिका', 91, 7),
(739, 'Chure', '	चुरे गाउँपालिका', 92, 7),
(740, 'Godawari', 'गोदावरी नगरपालिका', 92, 7),
(741, 'Dhangadi', 'धनगढी उपमहानगरपालिका', 92, 7),
(742, 'Gauriganga', 'गौरीगंगा नगरपालिका', 92, 7),
(743, 'Kailari', 'कैलारी गाउँपालिका', 92, 7),
(744, 'Bhajani', '	भजनी नगरपालिका', 92, 7),
(745, 'Tikapur', '	टिकापुर नगरपालिका', 92, 7),
(746, 'Janaki', 'जानकी गाउँपालिका', 92, 7),
(747, 'Joshipur', 'जोशीपुर गाउँपालिका', 92, 7),
(748, 'Ghodaghodi', 'घोडाघोडी नगरपालिका', 92, 7),
(749, 'Bardagoriya', 'बर्दगोरिया गाउँपालिका', 92, 7),
(750, 'Lamkichuha', 'लम्कीचुहा नगरपालिका', 92, 7),
(751, 'Mohanyal', 'मोहन्याल गाउँपालिका', 92, 7),
(752, 'Chishankhugadhi Rural Municipal\r\n', 'चिशंखुगढी गाउँपालिका', 13, 1),
(753, 'Thulung Dudhkoshi Rural Municipal\r\n', 'थुलुङ दुधकोशी गाउँपालिका', 14, 1),
(754, 'Parwanipur Rural Municipality\r\n', 'परवानीपुर गाउँपालिका', 16, 2),
(755, 'Madhav Narayan Municipality', 'माधव नारायण नगरपालिका', 17, 2),
(756, 'Dhankaul Rural Municipality', 'धनकौल गाउँपालिका', 18, 2),
(757, 'Lalbandi Municipality', 'लालबन्दी नगरपालिका', 18, 2),
(758, 'Pipara Rural Municipality', 'पिपरा गाउँपालिका', 19, 2),
(759, 'Sakhuwanankarkatti Ruralmunicipality', 'सखुवानान्कारकट्टी गाउँपालिका', 21, 2),
(760, 'Bishnupur Ruralmunicipality', 'बिष्णुपुर गाउँपालिका', 22, 2),
(761, 'DhurniBesi Municipality', 'धुनीबेंशी नगरपालिका', 41, 3),
(762, 'Bethanchowk Ruralmunicipality', 'बेथानचोक गाउँपालिका', 46, 3),
(763, 'Kapilvastu Municipality', 'कपिलवस्तु नगरपालिका', 70, 5),
(764, 'Susta Rural Municipality', 'सुस्ता गाउँपालिका', 73, 5),
(765, 'HIma Rural Municipality', '	हिमा गाउँपालिका', 77, 6),
(766, 'Swamikartik khapar Rural Municipality', '	स्वामीकार्तिक खापर गाउँपालिका', 87, 7),
(767, 'GanyaPadhura Rural Municipality', 'गन्यापधुरा गाउँपालिका', 88, 7),
(768, 'Mahakali Municipality', 'महाकाली नगरपालिका', 91, 7);

-- --------------------------------------------------------

--
-- Table structure for table `other_month_payment`
--

CREATE TABLE `other_month_payment` (
  `id` int(11) NOT NULL,
  `fk_year` int(11) NOT NULL,
  `fk_month` int(11) NOT NULL,
  `fk_payment_chori` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_municipal` int(11) NOT NULL,
  `created_date` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_bank` int(11) NOT NULL,
  `cheque_no` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_province_id` int(11) NOT NULL,
  `fk_district_id` int(11) NOT NULL,
  `fk_chori_bachat` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `other_month_payment`
--

INSERT INTO `other_month_payment` (`id`, `fk_year`, `fk_month`, `fk_payment_chori`, `fk_user_id`, `fk_municipal`, `created_date`, `fk_bank`, `cheque_no`, `fk_province_id`, `fk_district_id`, `fk_chori_bachat`, `amount`) VALUES
(3142, 4, 5, 712, 32, 638, '2078-08-02', 23, '273742387238', 6, 80, 263, 500),
(3143, 4, 6, 712, 32, 638, '2078-08-02', 23, '273742387238', 6, 80, 263, 500),
(3144, 4, 7, 712, 32, 638, '2078-08-02', 23, '273742387238', 6, 80, 263, 500),
(3145, 4, 8, 712, 32, 638, '2078-08-02', 23, '273742387238', 6, 80, 263, 500),
(3146, 4, 9, 713, 32, 638, '2078-08-03', 23, '273742387238', 6, 80, 264, 500),
(3147, 4, 9, 712, 32, 638, '2078-08-03', 23, '273742387238', 6, 80, 263, 500),
(3148, 4, 10, 713, 32, 638, '2078-08-03', 23, '273742387238', 6, 80, 264, 500),
(3149, 4, 10, 712, 32, 638, '2078-08-03', 23, '273742387238', 6, 80, 263, 500),
(3150, 4, 11, 713, 32, 638, '2078-08-03', 23, '273742387238', 6, 80, 264, 500),
(3151, 4, 11, 712, 32, 638, '2078-08-03', 23, '273742387238', 6, 80, 263, 500),
(3152, 4, 12, 713, 32, 638, '2078-08-03', 23, '273742387238', 6, 80, 264, 500),
(3153, 4, 12, 712, 32, 638, '2078-08-03', 23, '273742387238', 6, 80, 263, 500);

-- --------------------------------------------------------

--
-- Table structure for table `payment_chori`
--

CREATE TABLE `payment_chori` (
  `id` int(11) NOT NULL,
  `post_date` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_economic_year` int(11) NOT NULL,
  `fk_month` int(11) DEFAULT NULL,
  `fk_chori_bachat` int(11) NOT NULL,
  `fk_bank_details` int(11) NOT NULL,
  `fk_chori_account_details` int(11) NOT NULL,
  `amount` varchar(234) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_municipal` int(11) NOT NULL,
  `created_date` varchar(233) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status` int(11) DEFAULT NULL,
  `fk_initial` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `bank_request` int(11) NOT NULL,
  `cheque_no` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_province_id` int(11) NOT NULL,
  `fk_district_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `payment_chori`
--

INSERT INTO `payment_chori` (`id`, `post_date`, `fk_economic_year`, `fk_month`, `fk_chori_bachat`, `fk_bank_details`, `fk_chori_account_details`, `amount`, `fk_user_id`, `fk_municipal`, `created_date`, `status`, `fk_initial`, `bank_request`, `cheque_no`, `fk_province_id`, `fk_district_id`) VALUES
(712, '2078-08-02', 4, 5, 263, 21, 336, '1000', 32, 638, '2078-08-02', 7, '14', 21, '214211434224', 6, 80),
(713, '2078-08-03', 4, 5, 264, 23, 337, '1000', 32, 638, '2078-08-03', 7, '17', 21, '214211434224', 6, 80);

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE `province` (
  `id` int(11) NOT NULL,
  `province` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `province_nepali` varchar(250) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`id`, `province`, `province_nepali`) VALUES
(1, 'Province 1', 'प्रदेश नं १'),
(2, 'Province 2', 'प्रदेश नं २'),
(3, 'Province 3', 'बाग्मती प्रदेश'),
(4, 'Province 4', 'गण्डकी प्रदेश'),
(5, 'Province 5', 'लुम्बिनी प्रदेश '),
(6, 'Province 6', 'कर्णाली प्रदेश'),
(7, 'Province 7', ' सुदुरपश्चिम प्रदेश');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fk_municipal_id` int(11) DEFAULT NULL,
  `name` varchar(2000) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `position` varchar(2000) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `username` varchar(2000) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `password` varchar(2000) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `authkey` varchar(2000) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `created_date` varchar(250) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `updated_date` varchar(456) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fk_province_id` int(11) DEFAULT NULL,
  `fk_district_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fk_municipal_id`, `name`, `phone`, `position`, `username`, `password`, `authkey`, `created_date`, `updated_date`, `user_type`, `fk_province_id`, `fk_district_id`) VALUES
(12, NULL, 'Karnali Province', '9868211339', 'Head', 'karnali@gmail.com', 'chhori', '1234', '2021-07-06', '2021-07-06', '1', 6, NULL),
(31, NULL, 'Surkhet District', '9868211339', 'Head', 'Surkhet@gmail.com', 'chhori', '1234', '2021-11-18', '2021-11-18', '2', 6, 80),
(32, 638, 'Birendranagar', '9868211339', 'Head', 'Bnagar@gmail.com', 'chhori', '1234', '2021-11-18', '2021-11-18', '3', 6, 80),
(33, NULL, 'Eagel Eye', '9868211339', 'Head', 'tuki@gmail.com', 'tuki@12345', '1234', '2021-11-18', '2021-11-18', '4', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ward`
--

CREATE TABLE `ward` (
  `id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_municipal_id` int(11) NOT NULL,
  `ward_name` varchar(500) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `created_date` varchar(300) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `ward`
--

INSERT INTO `ward` (`id`, `fk_user_id`, `fk_municipal_id`, `ward_name`, `created_date`) VALUES
(60, 32, 638, '१', '2021-11-18');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `id` int(11) NOT NULL,
  `fk_chori` int(11) NOT NULL,
  `fk_dismiss` int(11) NOT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `fk_bank` int(11) NOT NULL,
  `fk_account` int(11) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_municipal` int(11) NOT NULL,
  `fk_economic_year` int(11) NOT NULL,
  `fk_month` int(11) NOT NULL,
  `fk_province` int(11) NOT NULL,
  `fk_district` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `year`
--

CREATE TABLE `year` (
  `id` int(11) NOT NULL,
  `economic_year` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `year`
--

INSERT INTO `year` (`id`, `economic_year`, `status`, `created_date`) VALUES
(1, '2075/76', 1, '2078-08-02'),
(2, '2076/77', 1, '2078-08-02'),
(3, '2077/78', 1, '2078-08-02'),
(4, '2078/79', 1, '2078-08-02'),
(5, '2079/80', 1, '2078-08-02'),
(6, '2080/81', 1, '2078-08-02'),
(7, '2081/82', 1, '2078-08-02'),
(8, '2082/83', 1, '2078-08-02'),
(9, '2083/84', 1, '2078-08-02'),
(10, '2084/85', 1, '2078-08-02'),
(11, '2085/86', 1, '2078-08-03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apangata`
--
ALTER TABLE `apangata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `caste`
--
ALTER TABLE `caste`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `check_payment`
--
ALTER TABLE `check_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chori_account_details`
--
ALTER TABLE `chori_account_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chori_bachat`
--
ALTER TABLE `chori_bachat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dismiss`
--
ALTER TABLE `dismiss`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `economic_year`
--
ALTER TABLE `economic_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `initial`
--
ALTER TABLE `initial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `money_set`
--
ALTER TABLE `money_set`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `month`
--
ALTER TABLE `month`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `municipal`
--
ALTER TABLE `municipal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `municipals`
--
ALTER TABLE `municipals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_month_payment`
--
ALTER TABLE `other_month_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_chori`
--
ALTER TABLE `payment_chori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `province`
--
ALTER TABLE `province`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ward`
--
ALTER TABLE `ward`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `year`
--
ALTER TABLE `year`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apangata`
--
ALTER TABLE `apangata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bank_details`
--
ALTER TABLE `bank_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `caste`
--
ALTER TABLE `caste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `check_payment`
--
ALTER TABLE `check_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chori_account_details`
--
ALTER TABLE `chori_account_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=338;

--
-- AUTO_INCREMENT for table `chori_bachat`
--
ALTER TABLE `chori_bachat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT for table `dismiss`
--
ALTER TABLE `dismiss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `economic_year`
--
ALTER TABLE `economic_year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `initial`
--
ALTER TABLE `initial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `money_set`
--
ALTER TABLE `money_set`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `month`
--
ALTER TABLE `month`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `municipal`
--
ALTER TABLE `municipal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `municipals`
--
ALTER TABLE `municipals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=769;

--
-- AUTO_INCREMENT for table `other_month_payment`
--
ALTER TABLE `other_month_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3154;

--
-- AUTO_INCREMENT for table `payment_chori`
--
ALTER TABLE `payment_chori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=714;

--
-- AUTO_INCREMENT for table `province`
--
ALTER TABLE `province`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `ward`
--
ALTER TABLE `ward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `year`
--
ALTER TABLE `year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
