-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 07:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eguru`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin1', '123'),
('admin1', '123');

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `message_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forum_reply`
--

CREATE TABLE `forum_reply` (
  `reply_id` int(11) NOT NULL,
  `message_id` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `reply` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `session_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `scheduled_date` date DEFAULT NULL,
  `schedule_time` time DEFAULT NULL,
  `session_status` enum('scheduled','completed','cancelled','requested','rejected') DEFAULT 'requested'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`session_id`, `student_id`, `tutor_id`, `scheduled_date`, `schedule_time`, `session_status`) VALUES
(40006, 10001, 20021, '2024-02-01', '10:00:00', 'scheduled'),
(40007, 10002, 20022, '2024-02-02', '11:00:00', 'requested'),
(40008, 10003, 20023, '2024-02-03', '12:00:00', 'scheduled'),
(40009, 10004, 20024, '2024-02-04', '14:00:00', 'completed'),
(40010, 10005, 20025, '2024-02-05', '15:00:00', 'cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `session_feedback`
--

CREATE TABLE `session_feedback` (
  `feedback_id` int(11) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `student_feedback` text DEFAULT NULL,
  `tutor_reply` text DEFAULT NULL,
  `last_updated` datetime DEFAULT NULL,
  `time_created` datetime DEFAULT NULL,
  `session_rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session_payment`
--

CREATE TABLE `session_payment` (
  `payment_id` int(11) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `payment_point_amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('okay','refunded') DEFAULT 'okay',
  `payment_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `student_first_name` varchar(255) DEFAULT NULL,
  `student_last_name` varchar(255) DEFAULT NULL,
  `student_DOB` date DEFAULT NULL,
  `student_grade` int(11) DEFAULT NULL,
  `student_email` varchar(255) NOT NULL,
  `student_password` varchar(255) NOT NULL,
  `student_phonenumber` varchar(20) DEFAULT NULL,
  `student_points` int(11) DEFAULT NULL,
  `student_profile_photo` varchar(255) DEFAULT NULL,
  `student_status` enum('set','unset') DEFAULT 'set',
  `student_registration_date` date DEFAULT NULL,
  `student_last_login` datetime DEFAULT NULL,
  `student_log` enum('online','offline') DEFAULT 'offline',
  `student_free_slots` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_first_name`, `student_last_name`, `student_DOB`, `student_grade`, `student_email`, `student_password`, `student_phonenumber`, `student_points`, `student_profile_photo`, `student_status`, `student_registration_date`, `student_last_login`, `student_log`, `student_free_slots`) VALUES
(10001, 'Tharindu', 'Silva', '2008-03-14', 10, 'tharindus@gmail.com', 'pass123', '0771234567', 20, 'tharindu.jpg', 'set', '2024-01-05', NULL, 'offline', 1),
(10002, 'Pasan', 'Wijesinghe', '2009-05-20', 9, 'pasanw@gmail.com', 'pass123', '0772345678', 15, 'pasan.jpg', 'set', '2024-01-08', NULL, 'offline', 1),
(10003, 'Isuru', 'Herath', '2010-08-30', 8, 'isuruh@gmail.com', 'pass123', '0773456789', 10, 'isuru.jpg', 'set', '2024-01-10', NULL, 'offline', 1),
(10004, 'Sajith', 'Fernando', '2007-12-12', 11, 'sajithf@gmail.com', 'pass123', '0774567890', 25, 'sajith.jpg', 'set', '2024-01-12', NULL, 'offline', 1),
(10005, 'Dinuka', 'Rajapaksa', '2006-06-22', 11, 'dinukar@gmail.com', 'pass123', '0775678901', 30, 'dinuka.jpg', 'set', '2024-01-15', NULL, 'offline', 0),
(10011, 'Kavindu', 'Perera', '2010-05-14', 8, 'kavindu.perera@example.lk', 'pass123', '0776543210', 50, 'kavindu.jpg', 'set', '2025-02-10', '2025-02-24 23:42:20', 'online', 1),
(10012, 'Sanduni', 'Fernando', '2011-07-22', 7, 'sanduni.fernando@example.lk', 'pass123', '0766543211', 40, 'sanduni.jpg', 'set', '2025-02-11', '2025-02-24 23:42:20', 'offline', 1),
(10013, 'Hasitha', 'Bandara', '2009-03-18', 9, 'hasitha.bandara@example.lk', 'pass123', '0716543212', 60, 'hasitha.jpg', 'set', '2025-02-12', '2025-02-24 23:42:20', 'online', 0),
(10014, 'Tharushi', 'Wijesinghe', '2012-01-10', 6, 'tharushi.wijesinghe@example.lk', 'pass123', '0726543213', 30, 'tharushi.jpg', 'set', '2025-02-13', '2025-02-24 23:42:20', 'offline', 1),
(10015, 'Ravindu', 'Jayasinghe', '2008-09-05', 10, 'ravindu.jayasinghe@example.lk', 'pass123', '0746543214', 55, 'ravindu.jpg', 'set', '2025-02-14', '2025-02-24 23:42:20', 'online', 1),
(10016, 'Nethmi', 'Gunawardena', '2009-11-21', 9, 'nethmi.gunawardena@example.lk', 'pass123', '0756543215', 45, 'nethmi.jpg', 'set', '2025-02-15', '2025-02-24 23:42:20', 'offline', 0),
(10017, 'Pasindu', 'Ratnayake', '2011-04-30', 7, 'pasindu.ratnayake@example.lk', 'pass123', '0786543216', 35, 'pasindu.jpg', 'set', '2025-02-16', '2025-02-24 23:42:20', 'online', 1),
(10018, 'Dilini', 'Ekanayake', '2010-06-12', 8, 'dilini.ekanayake@example.lk', 'pass123', '0706543217', 50, 'dilini.jpg', 'set', '2025-02-17', '2025-02-24 23:42:20', 'offline', 1),
(10019, 'Kasun', 'Dias', '2008-02-18', 11, 'kasun.dias@example.lk', 'pass123', '0776543218', 65, 'kasun.jpg', 'set', '2025-02-18', '2025-02-24 23:42:20', 'online', 0),
(10020, 'Sajini', 'Senanayake', '2007-12-05', 11, 'sajini.senanayake@example.lk', 'pass123', '0766543219', 70, 'sajini.jpg', 'set', '2025-02-19', '2025-02-24 23:42:20', 'offline', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_availability`
--

CREATE TABLE `student_availability` (
  `student_id` int(11) NOT NULL,
  `time_slot_id` int(11) NOT NULL,
  `day` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_profile`
--

CREATE TABLE `student_profile` (
  `student_id` int(11) NOT NULL,
  `bio` text DEFAULT NULL,
  `education` text DEFAULT NULL,
  `interests` text DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city_town` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_profile`
--

INSERT INTO `student_profile` (`student_id`, `bio`, `education`, `interests`, `country`, `city_town`) VALUES
(10001, 'A Grade 10 student interested in Science.', 'Ongoing school education', 'Reading, Chess', 'Sri Lanka', 'Colombo'),
(10002, 'Grade 9 student who loves math and coding.', 'Ongoing school education', 'Programming, Cricket', 'Sri Lanka', 'Kandy'),
(10003, 'Enthusiastic learner of English literature.', 'Ongoing school education', 'Writing, Drama', 'Sri Lanka', 'Galle'),
(10004, 'Aspiring engineer passionate about physics.', 'Ongoing school education', 'Electronics, Robotics', 'Sri Lanka', 'Kurunegala'),
(10005, 'Music lover and aspiring singer.', 'Ongoing school education', 'Singing, Guitar', 'Sri Lanka', 'Negombo'),
(10011, 'Aspiring engineer', 'Grade 9', 'Physics, Robotics', 'Sri Lanka', 'Matara'),
(10012, 'Sports enthusiast', 'Grade 7', 'Cricket, Athletics', 'Sri Lanka', 'Negombo'),
(10013, 'Music lover', 'Grade 8', 'Piano, Singing', 'Sri Lanka', 'Anuradhapura'),
(10014, 'Math genius', 'Grade 11', 'Math Olympiads, Puzzles', 'Sri Lanka', 'Ratnapura'),
(10015, 'Future doctor', 'Grade 10', 'Biology, Human Anatomy', 'Sri Lanka', 'Badulla'),
(10016, 'Tech enthusiast', 'Grade 9', 'Programming, AI', 'Sri Lanka', 'Gampaha'),
(10017, 'Bookworm', 'Grade 8', 'Fiction, Literature', 'Sri Lanka', 'Kurunegala'),
(10018, 'Environmentalist', 'Grade 7', 'Sustainability, Wildlife', 'Sri Lanka', 'Jaffna'),
(10019, 'Chess player', 'Grade 10', 'Strategy games, Logic puzzles', 'Sri Lanka', 'Colombo'),
(10020, 'Budding artist', 'Grade 6', 'Painting, Sketching', 'Sri Lanka', 'Kandy');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `subject_display_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_name`, `subject_display_pic`) VALUES
(1, 'Mathematics', 'math_icon.png'),
(2, 'Science', 'science_icon.png'),
(3, 'English', 'english_icon.png'),
(4, 'Sinhala', 'sinhala_icon.png'),
(5, 'Tamil', 'tamil_icon.png'),
(6, 'History', 'history_icon.png'),
(7, 'Geography', 'geography_icon.png'),
(8, 'Buddhism', 'buddhism_icon.png'),
(9, 'Information Technology', 'it_icon.png'),
(10, 'Physics', 'physics_icon.png'),
(11, 'Chemistry', 'chemistry_icon.png'),
(12, 'Biology', 'biology_icon.png');

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

CREATE TABLE `time_slot` (
  `time_slot_id` int(11) NOT NULL,
  `starting_time` int(11) DEFAULT NULL,
  `ending_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_slot`
--

INSERT INTO `time_slot` (`time_slot_id`, `starting_time`, `ending_time`) VALUES
(1, 2, 4),
(2, 3, 5),
(3, 4, 6),
(4, 5, 7),
(5, 6, 8),
(6, 7, 9),
(7, 8, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE `tutor` (
  `tutor_id` int(11) NOT NULL,
  `tutor_first_name` varchar(255) DEFAULT NULL,
  `tutor_last_name` varchar(255) DEFAULT NULL,
  `tutor_email` varchar(255) NOT NULL,
  `tutor_password` varchar(255) NOT NULL,
  `tutor_NIC` int(11) DEFAULT NULL,
  `tutor_DOB` date DEFAULT NULL,
  `tutor_points` int(11) DEFAULT NULL,
  `tutor_profile_photo` varchar(255) DEFAULT NULL,
  `tutor_status` enum('set','unset') DEFAULT 'set',
  `tutor_registration_date` date DEFAULT NULL,
  `tutor_time_slots` tinyint(1) DEFAULT 0,
  `tutor_last_login` datetime DEFAULT NULL,
  `tutor_log` enum('online','offline') DEFAULT 'offline',
  `tutor_level_id` varchar(50) DEFAULT NULL,
  `tutor_qualification_proof` varchar(255) DEFAULT NULL,
  `tutor_ad_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`tutor_id`, `tutor_first_name`, `tutor_last_name`, `tutor_email`, `tutor_password`, `tutor_NIC`, `tutor_DOB`, `tutor_points`, `tutor_profile_photo`, `tutor_status`, `tutor_registration_date`, `tutor_time_slots`, `tutor_last_login`, `tutor_log`, `tutor_level_id`, `tutor_qualification_proof`, `tutor_ad_id`) VALUES
(20021, 'Kasun', 'Perera', 'kasunp@gmail.com', 'pass123', 872345678, '1985-06-15', 50, 'kasun.jpg', 'set', '2024-01-10', 1, NULL, 'offline', 'G06', 'kasun_cert.pdf', NULL),
(20022, 'Nimal', 'Fernando', 'nimalf@gmail.com', 'pass123', 882345678, '1987-09-21', 45, 'nimal.jpg', 'set', '2024-01-12', 1, NULL, 'offline', 'G04', 'nimal_cert.pdf', NULL),
(20023, 'Amal', 'Jayasinghe', 'amalj@gmail.com', 'pass123', 902345678, '1990-02-11', 60, 'amal.jpg', 'set', '2024-01-15', 0, NULL, 'offline', 'G06', 'amal_cert.pdf', NULL),
(20024, 'Chathura', 'Senanayake', 'chathuras@gmail.com', 'pass123', 912345678, '1983-11-30', 30, 'chathura.jpg', 'set', '2024-01-18', 0, NULL, 'offline', 'G01', 'chathura_cert.pdf', NULL),
(20025, 'Dilan', 'Rathnayake', 'dilanr@gmail.com', 'pass123', 922345678, '1988-07-05', 70, 'dilan.jpg', 'set', '2024-01-20', 0, NULL, 'offline', 'G05', 'dilan_cert.pdf', NULL),
(20031, 'Mahesh', 'De Silva', 'mahesh.desilva@example.lk', 'pass123', 922345678, '1985-03-15', 200, 'mahesh.jpg', 'set', '2025-02-10', 1, '2025-02-24 23:43:55', 'online', 'G01', 'degree.pdf', NULL),
(20032, 'Nisansala', 'Wijeratne', 'nisansala.wijeratne@example.lk', 'pass123', 921234567, '1990-08-22', 180, 'nisansala.jpg', 'set', '2025-02-11', 1, '2025-02-24 23:43:55', 'offline', 'G02', 'masters.pdf', NULL),
(20033, 'Asela', 'Rathnayaka', 'asela.rathnayaka@example.lk', 'pass123', 923456789, '1982-12-05', 220, 'asela.jpg', 'set', '2025-02-12', 1, '2025-02-24 23:43:55', 'online', 'G03', 'phd.pdf', NULL),
(20034, 'Chamodi', 'Fernando', 'chamodi.fernando@example.lk', 'pass123', 924567890, '1995-04-10', 170, 'chamodi.jpg', 'set', '2025-02-13', 1, '2025-02-24 23:43:55', 'offline', 'G04', 'bachelor.pdf', NULL),
(20035, 'Dilan', 'Peris', 'dilan.peris@example.lk', 'pass123', 925678901, '1988-07-14', 190, 'dilan.jpg', 'set', '2025-02-14', 1, '2025-02-24 23:43:55', 'online', 'G05', 'degree.pdf', NULL),
(20036, 'Madhuka', 'Senarath', 'madhuka.senarath@example.lk', 'pass123', 926789012, '1993-02-19', 160, 'madhuka.jpg', 'set', '2025-02-15', 1, '2025-02-24 23:43:55', 'online', 'G01', 'bachelor.pdf', NULL),
(20037, 'Amali', 'Karunaratne', 'amali.karunaratne@example.lk', 'pass123', 927890123, '1986-06-08', 210, 'amali.jpg', 'set', '2025-02-16', 1, '2025-02-24 23:43:55', 'offline', 'G02', 'degree.pdf', NULL),
(20038, 'Nuwan', 'Samarasekara', 'nuwan.samarasekara@example.lk', 'pass123', 928901234, '1990-11-25', 195, 'nuwan.jpg', 'set', '2025-02-17', 1, '2025-02-24 23:43:55', 'online', 'G03', 'masters.pdf', NULL),
(20039, 'Pradeep', 'Jayawardena', 'pradeep.jayawardena@example.lk', 'pass123', 929012345, '1984-09-30', 230, 'pradeep.jpg', 'set', '2025-02-18', 1, '2025-02-24 23:43:55', 'offline', 'G04', 'phd.pdf', NULL),
(20040, 'Sulochana', 'Peiris', 'sulochana.peiris@example.lk', 'pass123', 930123456, '1992-01-11', 175, 'sulochana.jpg', 'set', '2025-02-19', 1, '2025-02-24 23:43:55', 'online', 'G06', 'bachelor.pdf', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tutor_advertisement`
--

CREATE TABLE `tutor_advertisement` (
  `ad_id` int(11) NOT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `ad_display_pic` varchar(255) DEFAULT NULL,
  `ad_description` text DEFAULT NULL,
  `ad_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tutor_availability`
--

CREATE TABLE `tutor_availability` (
  `tutor_id` int(11) NOT NULL,
  `time_slot_id` int(11) NOT NULL,
  `day` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tutor_level`
--

CREATE TABLE `tutor_level` (
  `tutor_level_id` varchar(50) NOT NULL,
  `tutor_level` varchar(255) NOT NULL,
  `tutor_level_qualification` varchar(255) DEFAULT NULL,
  `tutor_pay_per_hour` int(11) DEFAULT NULL,
  `tutor_level_color` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_level`
--

INSERT INTO `tutor_level` (`tutor_level_id`, `tutor_level`, `tutor_level_qualification`, `tutor_pay_per_hour`, `tutor_level_color`) VALUES
('G01', 'Diamond\r\n', 'Degree Holding School Teachers', 1000, '#b3ffb366'),
('G02', 'Platinum', 'Junior Teachers, Training Teachers', 900, '#ffff8066'),
('G03', 'Gold', 'Experienced Undergraduate, Trainee Teachers', 800, '#B0E0E666'),
('G04', 'Silver', 'Undergraduates', 700, '#FAF9F6'),
('G05', 'Bronze+', 'Diploma Holders', 600, '#FAF9F6'),
('G06', 'Bronze', 'Post AL Students / Other', 500, '#FAF9F6');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_report`
--

CREATE TABLE `tutor_report` (
  `report_id` int(11) NOT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `issue_type` varchar(255) DEFAULT NULL,
  `report_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tutor_requests`
--

CREATE TABLE `tutor_requests` (
  `request_id` int(11) NOT NULL,
  `tutor_first_name` varchar(255) DEFAULT NULL,
  `tutor_last_name` varchar(255) DEFAULT NULL,
  `tutor_email` varchar(255) NOT NULL,
  `tutor_password` varchar(255) NOT NULL,
  `tutor_NIC` int(11) DEFAULT NULL,
  `tutor_DOB` date DEFAULT NULL,
  `tutor_points` int(11) DEFAULT NULL,
  `tutor_profile_photo` varchar(255) DEFAULT NULL,
  `tutor_status` enum('set','unset') DEFAULT 'set',
  `tutor_registration_date` date DEFAULT NULL,
  `tutor_time_slots` tinyint(1) DEFAULT NULL,
  `tutor_last_login` datetime DEFAULT NULL,
  `tutor_log` enum('online','offline') DEFAULT 'offline',
  `tutor_level_id` varchar(50) DEFAULT NULL,
  `tutor_qualification_proof` varchar(255) DEFAULT NULL,
  `tutor_ad_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tutor_study_materials`
--

CREATE TABLE `tutor_study_materials` (
  `material_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `material_description` text DEFAULT NULL,
  `grade_id` int(11) DEFAULT NULL,
  `tutor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tutor_subject`
--

CREATE TABLE `tutor_subject` (
  `tutor_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `forum_reply`
--
ALTER TABLE `forum_reply`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `tutor_id` (`tutor_id`);

--
-- Indexes for table `session_feedback`
--
ALTER TABLE `session_feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `session_payment`
--
ALTER TABLE `session_payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `tutor_id` (`tutor_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `student_email` (`student_email`);

--
-- Indexes for table `student_availability`
--
ALTER TABLE `student_availability`
  ADD PRIMARY KEY (`student_id`,`time_slot_id`,`day`),
  ADD KEY `time_slot_id` (`time_slot_id`);

--
-- Indexes for table `student_profile`
--
ALTER TABLE `student_profile`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `subject_name` (`subject_name`);

--
-- Indexes for table `time_slot`
--
ALTER TABLE `time_slot`
  ADD PRIMARY KEY (`time_slot_id`);

--
-- Indexes for table `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`tutor_id`),
  ADD UNIQUE KEY `tutor_email` (`tutor_email`),
  ADD KEY `tutor_level_id` (`tutor_level_id`);

--
-- Indexes for table `tutor_advertisement`
--
ALTER TABLE `tutor_advertisement`
  ADD PRIMARY KEY (`ad_id`),
  ADD KEY `tutor_id` (`tutor_id`);

--
-- Indexes for table `tutor_availability`
--
ALTER TABLE `tutor_availability`
  ADD PRIMARY KEY (`tutor_id`,`time_slot_id`,`day`),
  ADD KEY `time_slot_id` (`time_slot_id`);

--
-- Indexes for table `tutor_level`
--
ALTER TABLE `tutor_level`
  ADD PRIMARY KEY (`tutor_level_id`),
  ADD UNIQUE KEY `tutor_level` (`tutor_level`);

--
-- Indexes for table `tutor_report`
--
ALTER TABLE `tutor_report`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `tutor_id` (`tutor_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `tutor_requests`
--
ALTER TABLE `tutor_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD UNIQUE KEY `tutor_email` (`tutor_email`),
  ADD KEY `tutor_level_id` (`tutor_level_id`);

--
-- Indexes for table `tutor_study_materials`
--
ALTER TABLE `tutor_study_materials`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `tutor_id` (`tutor_id`);

--
-- Indexes for table `tutor_subject`
--
ALTER TABLE `tutor_subject`
  ADD PRIMARY KEY (`tutor_id`,`subject_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `forum_reply`
--
ALTER TABLE `forum_reply`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40011;

--
-- AUTO_INCREMENT for table `session_feedback`
--
ALTER TABLE `session_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `session_payment`
--
ALTER TABLE `session_payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10021;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30001;

--
-- AUTO_INCREMENT for table `time_slot`
--
ALTER TABLE `time_slot`
  MODIFY `time_slot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tutor`
--
ALTER TABLE `tutor`
  MODIFY `tutor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20041;

--
-- AUTO_INCREMENT for table `tutor_advertisement`
--
ALTER TABLE `tutor_advertisement`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tutor_report`
--
ALTER TABLE `tutor_report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tutor_requests`
--
ALTER TABLE `tutor_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tutor_study_materials`
--
ALTER TABLE `tutor_study_materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forum`
--
ALTER TABLE `forum`
  ADD CONSTRAINT `forum_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `forum_reply`
--
ALTER TABLE `forum_reply`
  ADD CONSTRAINT `forum_reply_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `forum` (`message_id`);

--
-- Constraints for table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `session_ibfk_2` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`tutor_id`);

--
-- Constraints for table `session_feedback`
--
ALTER TABLE `session_feedback`
  ADD CONSTRAINT `session_feedback_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `session` (`session_id`);

--
-- Constraints for table `session_payment`
--
ALTER TABLE `session_payment`
  ADD CONSTRAINT `session_payment_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `session` (`session_id`),
  ADD CONSTRAINT `session_payment_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `session_payment_ibfk_3` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`tutor_id`);

--
-- Constraints for table `student_availability`
--
ALTER TABLE `student_availability`
  ADD CONSTRAINT `student_availability_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `student_availability_ibfk_2` FOREIGN KEY (`time_slot_id`) REFERENCES `time_slot` (`time_slot_id`);

--
-- Constraints for table `student_profile`
--
ALTER TABLE `student_profile`
  ADD CONSTRAINT `student_profile_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `tutor`
--
ALTER TABLE `tutor`
  ADD CONSTRAINT `tutor_ibfk_1` FOREIGN KEY (`tutor_level_id`) REFERENCES `tutor_level` (`tutor_level_id`);

--
-- Constraints for table `tutor_advertisement`
--
ALTER TABLE `tutor_advertisement`
  ADD CONSTRAINT `tutor_advertisement_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`tutor_id`);

--
-- Constraints for table `tutor_availability`
--
ALTER TABLE `tutor_availability`
  ADD CONSTRAINT `tutor_availability_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`tutor_id`),
  ADD CONSTRAINT `tutor_availability_ibfk_2` FOREIGN KEY (`time_slot_id`) REFERENCES `time_slot` (`time_slot_id`);

--
-- Constraints for table `tutor_report`
--
ALTER TABLE `tutor_report`
  ADD CONSTRAINT `tutor_report_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`tutor_id`),
  ADD CONSTRAINT `tutor_report_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `tutor_requests`
--
ALTER TABLE `tutor_requests`
  ADD CONSTRAINT `tutor_requests_ibfk_1` FOREIGN KEY (`tutor_level_id`) REFERENCES `tutor_level` (`tutor_level_id`);

--
-- Constraints for table `tutor_study_materials`
--
ALTER TABLE `tutor_study_materials`
  ADD CONSTRAINT `tutor_study_materials_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`),
  ADD CONSTRAINT `tutor_study_materials_ibfk_2` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`tutor_id`);

--
-- Constraints for table `tutor_subject`
--
ALTER TABLE `tutor_subject`
  ADD CONSTRAINT `tutor_subject_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`tutor_id`),
  ADD CONSTRAINT `tutor_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
