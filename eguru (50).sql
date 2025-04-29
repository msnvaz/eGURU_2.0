-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 09:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

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
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_login_status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `admin_login_status`) VALUES
(1, 'admin1', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0),
(2, 'admin2', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin_inbox`
--

CREATE TABLE `admin_inbox` (
  `inbox_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_type` enum('student','tutor') NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('unread','read','archived') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_inbox`
--

INSERT INTO `admin_inbox` (`inbox_id`, `sender_id`, `sender_type`, `subject`, `message`, `sent_at`, `status`) VALUES
(1, 20035, 'tutor', 'Issue with payment', 'I have an issue with the latest payment.', '2024-09-23 08:14:00', 'read'),
(2, 10014, 'student', 'Request for extra session', 'Can I schedule an extra session this week?', '2024-03-14 23:52:00', 'unread'),
(3, 20025, 'tutor', 'Profile update request', 'I want to update my profile details.', '2024-04-27 07:00:00', 'archived'),
(4, 10011, 'student', 'Technical issue', 'I am unable to access my scheduled session.', '2024-06-10 04:15:00', 'read'),
(5, 20040, 'tutor', 'Class rescheduling', 'Can I reschedule my upcoming class?', '2024-07-02 08:50:00', 'read'),
(6, 20022, 'tutor', 'Session Recording Access', 'Can I access past session recordings?', '2024-08-10 05:00:00', 'read'),
(7, 10012, 'student', 'Exam Tips', 'Do you have any tips for O/L exams?', '2024-09-12 06:45:00', 'read'),
(8, 20031, 'tutor', 'Account Verification', 'My account verification is still pending.', '2024-07-18 10:10:00', 'archived'),
(9, 10018, 'student', 'Point System Clarification', 'How do I earn and redeem points?', '2024-06-28 04:25:00', 'read'),
(10, 20039, 'tutor', 'New Subject Request', 'Can I add ICT as a subject to teach?', '2024-05-23 11:50:00', 'read'),
(11, 10005, 'student', 'Schedule Issue', 'I booked a class, but the tutor is unavailable.', '2024-08-15 08:40:00', 'archived'),
(12, 20040, 'tutor', 'Teaching Material Request', 'Where can I upload additional teaching materials?', '2024-06-05 11:15:00', 'read'),
(13, 10020, 'student', 'Certificate of Completion', 'Do we get certificates for completed courses?', '2024-07-22 06:00:00', 'read'),
(14, 20024, 'tutor', 'Technical Issue with Whiteboard', 'The online whiteboard is not working properly.', '2024-09-05 14:40:00', 'read'),
(15, 10011, 'student', 'Tuition Discounts', 'Are there any discounts for bulk session purchases?', '2024-04-20 02:20:00', 'archived');

-- --------------------------------------------------------

--
-- Table structure for table `admin_inbox_reply`
--

CREATE TABLE `admin_inbox_reply` (
  `reply_id` int(11) NOT NULL,
  `inbox_id` int(11) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `reply_message` text NOT NULL,
  `replied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_inbox_reply`
--

INSERT INTO `admin_inbox_reply` (`reply_id`, `inbox_id`, `admin_username`, `reply_message`, `replied_at`) VALUES
(26, 1, 'admin1', 'We have checked the issue, and the payment will be processed soon.', '2024-09-24 04:30:00'),
(27, 2, 'admin1', 'You can request an extra session through the booking page.', '2024-03-16 00:30:00'),
(28, 3, 'admin1', 'Your profile update request has been approved.', '2024-04-28 10:00:00'),
(29, 4, 'admin1', 'We are looking into the technical issue. Try clearing your cache.', '2024-06-11 05:30:00'),
(30, 5, 'admin1', 'Yes, you can reschedule your class through your dashboard.', '2024-07-03 03:15:00'),
(31, 6, 'admin1', 'We are working on enabling session recordings soon.', '2024-08-11 05:30:00'),
(32, 7, 'admin1', 'For O/L exams, focus on past papers and time management.', '2024-09-13 07:30:00'),
(33, 8, 'admin1', 'Your account verification is under review.', '2024-07-19 10:30:00'),
(34, 9, 'admin1', 'You can earn points by attending sessions and referring friends.', '2024-06-29 05:00:00'),
(35, 10, 'admin1', 'ICT subject is available for tutors now.', '2024-05-24 12:40:00'),
(36, 11, 'admin1', 'We are resolving the scheduling issue. Please check again.', '2024-08-16 10:00:00'),
(37, 12, 'admin1', 'You can upload materials under the \"Resources\" tab.', '2024-06-06 11:30:00'),
(38, 13, 'admin1', 'Yes, certificates are issued for completed courses.', '2024-07-23 06:30:00'),
(39, 14, 'admin1', 'The technical team is fixing the whiteboard issue.', '2024-09-06 15:30:00'),
(40, 15, 'admin1', 'We offer discounts for bulk purchases of 10+ sessions.', '2024-04-21 03:00:00'),
(42, 1, 'admin1', 'Yes', '2025-04-10 09:17:42'),
(43, 7, 'admin1', 'There is a guide for you in the vle', '2025-04-10 09:18:26'),
(44, 9, 'admin1', 'You have to purchase from the vle\r\n', '2025-04-10 09:26:04'),
(45, 1, 'admin1', 'Is it resolved', '2025-04-22 08:18:58');

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE `admin_settings` (
  `admin_setting_id` int(11) NOT NULL,
  `admin_setting_name` varchar(255) NOT NULL,
  `admin_setting_description` varchar(255) DEFAULT NULL,
  `admin_setting_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_settings`
--

INSERT INTO `admin_settings` (`admin_setting_id`, `admin_setting_name`, `admin_setting_description`, `admin_setting_value`) VALUES
(3, 'student_registration', 'Allow students to register if true', '1'),
(4, 'tutor_registration', 'allow tutors to register if true', '1'),
(6, 'platform_fee', 'The platform payment fee percentage', '5'),
(8, 'default_duration', 'default_session_duration', '60'),
(9, 'default_duration', 'Default session duration in minutes', '60'),
(10, 'booking_window', 'Advance booking period in days', '7'),
(11, 'cancellation_window', 'Minimum notice for cancellation in hours', '24'),
(12, 'noshow_penalty', 'Consequences for missed sessions', '0'),
(13, 'email_notifications', 'Send booking confirmations via email', '1'),
(14, 'reminder_time', 'When to send reminders (hours before session)', '24'),
(15, 'payout_schedule', 'Teacher payment frequency in days', '7'),
(16, 'require_2fa', 'Require two-factor authentication for all users', '0'),
(17, 'password_policy', 'Password security requirements', 'basic'),
(18, 'session_timeout', 'Auto logout after inactivity in minutes', '30'),
(19, 'content_approval', 'Require approval for tutor uploads', '1'),
(20, 'max_file_size', 'File upload size limit in MB', '10'),
(21, 'allowed_file_types', 'File formats for course materials', '0'),
(22, 'theme', 'Platform visual appearance', '0'),
(23, 'custom_logo', 'Path to custom logo file', ''),
(24, 'video_platform', 'Platform for virtual sessions', '0'),
(25, 'calendar_integration', 'Sync sessions with calendars', '0'),
(26, 'point_value', 'The cash value of a point', '10');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announce_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `announcement` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announce_id`, `title`, `announcement`, `created_at`, `updated_at`, `status`) VALUES
(1, '', 'Welcome to e-Guru Your Individualized  Platform! Getting Statred', '2025-03-06 05:22:13', '2025-04-27 12:09:45', 'inactive'),
(2, '', 'Getting Started with e-Guru!! First Day', '2025-03-06 12:06:10', '2025-04-27 12:09:49', 'inactive'),
(3, 'Welcome Note!', 'Great Offer!! Half the regisitration fee for first 50 students', '2025-03-06 12:15:12', '2025-03-09 07:23:45', 'inactive'),
(4, 'Offer Alert!!', 'Great Offer!! Independence Day Offer!!', '2025-03-07 00:27:49', '2025-03-09 07:24:12', 'active'),
(5, 'Holiday Alert!!', 'Poya Day Holiday on 13th March 2025', '2025-03-07 00:34:21', '2025-03-09 07:24:42', 'active'),
(6, 'Session extension notice', 'School-vacation learning shifts to day!!!', '2025-03-07 06:08:12', '2025-03-09 07:25:25', 'active'),
(7, 'Fresh tutors are enrolled', 'New Teachers are welcomed!!', '2025-03-07 06:35:34', '2025-03-09 07:25:48', 'active'),
(8, 'Admin gone crazy!', 'Change Made Successfully!!', '2025-03-07 09:11:48', '2025-04-27 12:09:27', 'inactive'),
(9, 'Inconvenience Caused!', 'Sorry for the inconvenience caused!!', '2025-03-07 09:14:26', '2025-03-09 07:26:33', 'active'),
(10, 'Recovered Just Now!!', 'Successful Recovery!', '2025-03-07 09:38:18', '2025-03-09 07:27:11', 'active'),
(11, 'Sorry for the inconvenience', 'Session aborted!', '2025-03-08 10:58:55', '2025-04-29 03:14:44', 'active'),
(12, 'Sessions Extended!!!', 'Due to Term Examinations Sessions extended up to 12 midnight!!', '2025-03-08 11:06:33', '2025-03-11 21:21:12', 'inactive'),
(13, 'Test Checking!', 'God', '2025-03-11 21:22:22', '2025-03-11 21:22:33', 'inactive'),
(14, 'Examinations Starts!!', 'Good luck all students!', '2025-03-12 07:02:58', '2025-03-12 08:03:17', 'inactive'),
(15, 'Resume Sessions!!', 'After Term Examination Session starts on 24th April 2025!', '2025-03-12 08:05:08', '2025-03-12 08:05:08', 'active'),
(16, 'Development Alert!!', 'Digital ID will be given to everyone!!', '2025-03-13 05:32:09', '2025-03-13 05:32:22', 'inactive'),
(17, 'Today is final day', 'Presentation @ 10:30', '2025-04-29 03:15:31', '2025-04-29 03:15:31', 'active'),
(18, 'Session Resumes', 'After term exam  sessions will be resumed', '2025-04-29 03:16:07', '2025-04-29 03:16:17', 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `message_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `message_status` varchar(15) NOT NULL DEFAULT 'set'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`message_id`, `student_id`, `message`, `time`, `message_status`) VALUES
(16, 10002, 'How can I improve my exam scores?', '2024-08-19 14:23:00', 'set'),
(17, 10011, 'Is there a way to track my learning progress?', '2024-07-10 06:31:00', 'set'),
(18, 10015, 'Any recommendations for good study materials?', '2024-05-05 10:45:00', 'set'),
(19, 10020, 'Can we have a group study feature?', '2024-06-20 18:20:00', 'set'),
(20, 10003, 'What are the best strategies for time management in exams?', '2024-04-01 08:10:00', 'set'),
(21, 10015, 'What are the best apps for learning mathematics?', '2024-03-15 14:30:00', 'set'),
(22, 10003, 'Is there a scholarship program available for top students?', '2024-05-10 10:10:00', 'set'),
(23, 10011, 'How do I participate in online quizzes on this platform?', '2024-06-25 18:50:00', 'set'),
(24, 10018, 'Any tips for balancing school and tuition classes?', '2024-07-30 09:15:00', 'set'),
(25, 10005, 'Can we request additional notes from tutors?', '2024-09-05 16:40:00', 'set'),
(26, 10002, 'What are the best universities in Sri Lanka for engineering?', '2024-04-12 08:00:00', 'set'),
(27, 10012, 'How do I improve my essay writing skills for English?', '2024-08-19 19:25:00', 'set'),
(28, 10017, 'Are there any group study features available here?', '2024-06-14 11:45:00', 'set'),
(29, 10001, 'Is there a way to track my attendance in online sessions?', '2024-07-08 15:35:00', 'set'),
(30, 10020, 'What are the best science experiment websites for school students?', '2024-09-10 12:20:00', 'set');

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

--
-- Dumping data for table `forum_reply`
--

INSERT INTO `forum_reply` (`reply_id`, `message_id`, `time`, `reply`) VALUES
(6, 16, '2024-08-20 15:00:00', 'Try solving past papers and reviewing difficult topics.'),
(7, 17, '2024-07-11 08:45:00', 'Yes, your profile dashboard shows progress based on completed sessions.'),
(8, 18, '2024-05-06 12:30:00', 'You can check the resource section for study guides.'),
(9, 19, '2024-06-21 10:15:00', 'That would be a great feature! I support this idea.'),
(10, 20, '2024-04-02 09:00:00', 'Create a daily study plan and stick to it for better results.'),
(31, 30, '2024-03-16 15:00:00', 'Try using Khan Academy, Photomath, and GeoGebra.'),
(32, 21, '2024-05-11 11:00:00', 'Yes, there are scholarships for top performers.'),
(33, 22, '2024-06-26 19:00:00', 'You can join quizzes under the \"Activities\" section.'),
(34, 23, '2024-07-31 10:00:00', 'Create a timetable and balance study with breaks.'),
(35, 24, '2024-09-06 17:00:00', 'Yes, you can request extra notes from tutors via messages.'),
(36, 25, '2024-04-13 09:00:00', 'University of Moratuwa and Peradeniya are top choices.'),
(37, 26, '2024-08-20 20:00:00', 'Practice writing essays on different topics regularly.'),
(38, 27, '2024-06-15 12:00:00', 'Group study features would be a great addition!'),
(39, 28, '2024-07-09 16:00:00', 'Attendance tracking is available in your profile.'),
(40, 29, '2024-09-11 13:00:00', 'Check out Science Buddies and Exploratorium for experiments.');

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
  `session_status` enum('scheduled','completed','cancelled','requested','rejected') DEFAULT 'requested',
  `subject_id` int(11) NOT NULL,
  `meeting_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`session_id`, `student_id`, `tutor_id`, `scheduled_date`, `schedule_time`, `session_status`, `subject_id`, `meeting_link`) VALUES
(40006, 10001, 20021, '2024-02-01', '10:00:00', 'completed', 1, NULL),
(40007, 10002, 20022, '2024-02-02', '11:00:00', 'cancelled', 10, NULL),
(40008, 10003, 20023, '2024-02-03', '12:00:00', 'completed', 2, NULL),
(40009, 10021, 20024, '2024-02-04', '14:00:00', 'completed', 3, NULL),
(40010, 10005, 20025, '2024-02-05', '15:00:00', 'cancelled', 4, NULL),
(40011, 10001, 20021, '2024-02-06', '02:00:00', 'completed', 5, NULL),
(40012, 10021, 20022, '2024-02-07', '03:00:00', 'completed', 10, NULL),
(40013, 10003, 20023, '2024-02-08', '04:00:00', 'cancelled', 6, NULL),
(40014, 10004, 20024, '2024-02-09', '05:00:00', 'scheduled', 7, NULL),
(40015, 10005, 20025, '2024-02-10', '06:00:00', 'cancelled', 8, NULL),
(40016, 10011, 20031, '2024-02-11', '07:00:00', 'completed', 9, NULL),
(40017, 10012, 20032, '2024-02-12', '08:00:00', 'cancelled', 10, NULL),
(40018, 10021, 20033, '2024-02-13', '02:00:00', 'completed', 11, NULL),
(40019, 10014, 20034, '2024-02-14', '03:00:00', 'completed', 12, NULL),
(40020, 10015, 20035, '2024-02-15', '04:00:00', 'cancelled', 1, NULL),
(40021, 10016, 20036, '2024-02-16', '05:00:00', 'completed', 2, NULL),
(40022, 10017, 20037, '2024-02-17', '06:00:00', 'completed', 3, NULL),
(40023, 10018, 20038, '2024-02-18', '07:00:00', 'cancelled', 4, NULL),
(40024, 10019, 20039, '2024-02-19', '08:00:00', 'completed', 5, NULL),
(40025, 10020, 20040, '2024-02-20', '02:00:00', 'cancelled', 6, NULL),
(40026, 10001, 20021, '2024-02-21', '03:00:00', 'completed', 7, NULL),
(40027, 10021, 20022, '2024-02-22', '04:00:00', 'completed', 8, NULL),
(40028, 10003, 20023, '2024-02-23', '05:00:00', 'cancelled', 9, NULL),
(40029, 10004, 20024, '2024-02-24', '06:00:00', 'scheduled', 10, NULL),
(40030, 10005, 20025, '2024-02-25', '07:00:00', 'cancelled', 11, NULL),
(40031, 10011, 20031, '2024-02-26', '08:00:00', 'completed', 5, NULL),
(40032, 10012, 20032, '2024-02-27', '02:00:00', 'completed', 1, NULL),
(40033, 10013, 20033, '2024-02-28', '03:00:00', 'cancelled', 1, NULL),
(40034, 10014, 20034, '2024-02-29', '04:00:00', 'completed', 1, NULL),
(40035, 10027, 20035, '2024-03-01', '05:00:00', 'cancelled', 1, NULL),
(40036, 10016, 20036, '2024-03-02', '06:00:00', 'completed', 1, NULL),
(40037, 10017, 20037, '2024-03-03', '07:00:00', 'completed', 1, NULL),
(40038, 10018, 20038, '2024-03-04', '08:00:00', 'cancelled', 1, NULL),
(40039, 10019, 20039, '2024-03-05', '02:00:00', 'completed', 1, NULL),
(40040, 10020, 20040, '2024-03-06', '03:00:00', 'cancelled', 1, NULL),
(40041, 10001, 20021, '2024-03-07', '04:00:00', 'completed', 1, NULL),
(40042, 10002, 20022, '2024-03-08', '05:00:00', 'completed', 1, NULL),
(40043, 10003, 20023, '2024-03-09', '06:00:00', 'cancelled', 1, NULL),
(40044, 10004, 20024, '2024-03-10', '07:00:00', 'scheduled', 1, NULL),
(40045, 10005, 20025, '2024-03-11', '08:00:00', 'cancelled', 1, NULL),
(40046, 10011, 20035, '2024-03-12', '02:00:00', 'completed', 1, NULL),
(40047, 10027, 20035, '2024-03-13', '03:00:00', 'completed', 1, NULL),
(40048, 10027, 20035, '2024-03-14', '04:00:00', 'cancelled', 1, NULL),
(40049, 10014, 20035, '2024-03-15', '05:00:00', 'completed', 1, NULL),
(40050, 10015, 20035, '2024-03-16', '06:00:00', 'cancelled', 1, NULL),
(40051, 10016, 20036, '2024-03-17', '07:00:00', 'completed', 1, NULL),
(40052, 10017, 20037, '2024-03-18', '08:00:00', 'completed', 1, NULL),
(40053, 10018, 20038, '2024-03-19', '02:00:00', 'cancelled', 1, NULL),
(40054, 10019, 20039, '2024-03-20', '03:00:00', 'completed', 1, NULL),
(40055, 10020, 20035, '2024-03-21', '04:00:00', 'cancelled', 1, NULL),
(40056, 10001, 20021, '2024-03-22', '05:00:00', 'completed', 1, NULL),
(40057, 10002, 20022, '2024-03-23', '06:00:00', 'completed', 1, NULL),
(40058, 10027, 20035, '2024-03-24', '07:00:00', 'cancelled', 1, NULL),
(40059, 10004, 20035, '2024-03-25', '08:00:00', 'completed', 1, NULL),
(40060, 10005, 20025, '2024-03-26', '02:00:00', 'cancelled', 1, NULL),
(40061, 10021, 20023, '2024-02-27', '08:00:00', 'completed', 5, NULL),
(40062, 10021, 20024, '2024-02-28', '08:00:00', 'completed', 2, NULL),
(40063, 10021, 20033, '2024-02-29', '02:00:00', 'completed', 8, NULL),
(40064, 10021, 20021, NULL, NULL, 'cancelled', 1, NULL),
(40065, 10021, 20021, '2025-04-09', '13:42:00', 'completed', 1, 'https://meet.google.com/abc-defg-hij'),
(40066, 10021, 20021, '2025-04-09', '13:48:00', 'completed', 1, 'https://meet.google.com/abc-defg-hij'),
(40067, 10021, 20021, '2025-04-09', '13:51:00', 'cancelled', 1, NULL),
(40068, 10021, 20021, '2025-04-09', '13:52:00', 'cancelled', 1, NULL),
(40069, 10021, 20021, NULL, NULL, 'rejected', 1, NULL),
(40070, 10021, 20021, NULL, NULL, 'rejected', 1, NULL),
(40071, 10021, 20021, NULL, NULL, 'rejected', 1, NULL),
(40072, 10021, 20021, '2025-04-01', '10:42:25', 'rejected', 1, NULL),
(40073, 10021, 20021, NULL, NULL, 'rejected', 1, NULL),
(40074, 10021, 20021, NULL, NULL, 'cancelled', 3, NULL),
(40075, 10021, 20021, NULL, NULL, 'cancelled', 3, NULL),
(40076, 10021, 20021, NULL, NULL, 'cancelled', 3, NULL),
(40077, 10021, 20021, '2025-04-02', '10:34:25', 'rejected', 3, NULL),
(40078, 10021, 20035, NULL, NULL, 'cancelled', 3, NULL),
(40086, 10021, 20021, '2025-04-30', '09:00:00', 'cancelled', 3, NULL),
(40087, 10021, 20023, '2025-04-25', '11:00:00', 'completed', 8, NULL),
(40088, 10021, 20031, '2025-04-26', '12:00:00', 'cancelled', 7, NULL),
(40089, 10021, 20021, '2025-04-27', '19:00:00', 'cancelled', 3, NULL),
(40090, 10021, 20021, '2025-04-26', '18:00:00', 'cancelled', 1, NULL),
(40091, 10021, 20034, '2025-04-29', '08:00:00', 'cancelled', 12, NULL),
(40092, 10021, 20022, '2025-04-29', '08:00:00', 'cancelled', 1, NULL),
(40093, 10021, 20023, '2025-05-01', '10:00:00', 'cancelled', 7, NULL),
(40094, 10021, 20022, '2025-04-29', '08:00:00', 'cancelled', 1, 'https://zoom.us/meeting/placeholder'),
(40095, 10021, 20022, '2025-04-29', '08:00:00', 'scheduled', 6, 'https://us04web.zoom.us/j/77105840131?pwd=itmtlvfdHti4GnpSNFeg3itNB2Wkw1.1'),
(40096, 10021, 20022, '2025-04-29', '08:00:00', 'requested', 6, 'https://us04web.zoom.us/j/72433987146?pwd=4mHu80lwsKkcxazPqxbXYQqiTxyvou.1'),
(40097, 10025, 20022, '2025-04-29', '08:00:00', 'cancelled', 6, 'https://us04web.zoom.us/j/73315808331?pwd=BGLvlNZ2mrymHM4ziA9EC9aMTAVH3l.1'),
(40098, 10025, 20021, '2025-04-28', '14:00:00', 'completed', 2, 'https://us04web.zoom.us/j/73414433351?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAJ.1'),
(40099, 10025, 20021, '2025-05-02', '20:00:00', 'scheduled', 3, 'https://us04web.zoom.us/j/71452766174?pwd=TFKTgnMnTPIUgGmAaKUY6mR7DgPven.1'),
(40100, 10025, 20021, '2025-05-02', '11:00:00', 'requested', 1, 'https://us04web.zoom.us/j/71750014437?pwd=ZQblmFEnt4aOaTJYiqhGtLLNe91BYa.1'),
(40101, 10027, 20021, '2025-04-29', '17:00:00', 'requested', 3, 'https://us04web.zoom.us/j/76539662774?pwd=3Rh4muUcakDPh7CdDSriCmKqEDbXKj.1'),
(40102, 10027, 20021, '2025-05-02', '18:00:00', 'requested', 2, 'https://us04web.zoom.us/j/74501135887?pwd=Cv0p8U2GbIT93okl05CDWHsN9aNwwr.1'),
(40103, 10025, 20035, '2025-04-30', '18:00:00', 'requested', 7, 'https://us04web.zoom.us/j/76939638596?pwd=Bjc8NshyDwq2B2UH0IoeRbwhbsebCk.1'),
(40104, 10021, 20021, '2025-05-01', '14:00:00', 'scheduled', 2, 'https://us04web.zoom.us/j/73414433352?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAK.1'),
(40105, 10021, 20021, '2025-05-03', '16:00:00', 'requested', 5, 'https://us04web.zoom.us/j/73414433353?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAL.1'),
(40106, 10025, 20021, '2025-05-01', '16:00:00', 'scheduled', 4, 'https://us04web.zoom.us/j/73414433354?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAM.1'),
(40107, 10025, 20021, '2025-05-04', '15:00:00', 'requested', 5, 'https://us04web.zoom.us/j/73414433355?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAN.1'),
(40108, 10026, 20021, '2025-05-03', '10:00:00', 'scheduled', 1, 'https://us04web.zoom.us/j/73414433356?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAO.1'),
(40109, 10026, 20021, '2025-05-05', '13:00:00', 'scheduled', 3, 'https://us04web.zoom.us/j/73414433357?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAP.1'),
(40110, 10027, 20021, '2025-05-04', '11:00:00', 'scheduled', 5, 'https://us04web.zoom.us/j/73414433358?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAQ.1'),
(40111, 10021, 20035, '2025-05-01', '10:00:00', 'scheduled', 5, 'https://us04web.zoom.us/j/73414433359?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAR.1'),
(40112, 10021, 20035, '2025-05-03', '12:00:00', 'requested', 1, 'https://us04web.zoom.us/j/73414433360?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAS.1'),
(40113, 10026, 20035, '2025-05-02', '11:00:00', 'scheduled', 5, 'https://us04web.zoom.us/j/73414433361?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAT.1'),
(40114, 10026, 20035, '2025-05-04', '17:00:00', 'requested', 8, 'https://us04web.zoom.us/j/73414433362?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAU.1'),
(40115, 10027, 20035, '2025-05-03', '14:00:00', 'scheduled', 10, 'https://us04web.zoom.us/j/73414433363?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAV.1'),
(40116, 10027, 20035, '2025-05-05', '09:00:00', 'requested', 11, 'https://us04web.zoom.us/j/73414433364?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAW.1'),
(40117, 10021, 20021, '2025-04-15', '15:30:00', 'completed', 3, 'https://us04web.zoom.us/j/73414433365?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAX.1'),
(40118, 10025, 20021, '2025-04-20', '13:00:00', 'completed', 1, 'https://us04web.zoom.us/j/73414433366?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAY.1'),
(40119, 10026, 20021, '2025-04-18', '11:45:00', 'completed', 4, 'https://us04web.zoom.us/j/73414433367?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GAZ.1'),
(40120, 10027, 20021, '2025-04-22', '16:15:00', 'completed', 2, 'https://us04web.zoom.us/j/73414433368?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GBA.1'),
(40121, 10021, 20021, '2025-04-12', '10:00:00', 'cancelled', 5, 'https://us04web.zoom.us/j/73414433369?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GBB.1'),
(40122, 10025, 20021, '2025-04-17', '14:30:00', 'cancelled', 6, 'https://us04web.zoom.us/j/73414433370?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GBC.1'),
(40123, 10026, 20021, '2025-04-24', '09:15:00', 'cancelled', 7, 'https://us04web.zoom.us/j/73414433371?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GBD.1'),
(40124, 10027, 20021, '2025-04-19', '17:00:00', 'cancelled', 8, 'https://us04web.zoom.us/j/73414433372?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GBE.1'),
(40125, 10021, 20035, '2025-04-10', '11:30:00', 'completed', 9, 'https://us04web.zoom.us/j/73414433373?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GBF.1'),
(40126, 10025, 20035, '2025-04-16', '15:45:00', 'completed', 10, 'https://us04web.zoom.us/j/73414433374?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GBG.1'),
(40127, 10026, 20035, '2025-04-21', '13:30:00', 'completed', 11, 'https://us04web.zoom.us/j/73414433375?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GBH.1'),
(40128, 10027, 20035, '2025-04-23', '12:00:00', 'completed', 12, 'https://us04web.zoom.us/j/73414433376?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GBI.1'),
(40129, 10021, 20035, '2025-04-11', '09:00:00', 'cancelled', 1, 'https://us04web.zoom.us/j/73414433377?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GBJ.1'),
(40130, 10025, 20035, '2025-04-14', '10:45:00', 'cancelled', 2, 'https://us04web.zoom.us/j/73414433378?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GBK.1'),
(40131, 10026, 20035, '2025-04-19', '14:15:00', 'cancelled', 3, 'https://us04web.zoom.us/j/73414433379?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GBL.1'),
(40132, 10027, 20035, '2025-04-25', '16:30:00', 'cancelled', 4, 'https://us04web.zoom.us/j/73414433380?pwd=1a3wQ01waQeYMA3R2tletHH4nJ8GBM.1'),
(40133, 10021, 20021, '2025-05-02', '18:00:00', 'scheduled', 3, 'https://us04web.zoom.us/j/76089291901?pwd=4xa3ImnDItlKu3OCBGdKXbLkQRk34s.1'),
(40134, 10021, 20021, '2025-05-05', '07:00:00', 'cancelled', 12, 'https://us04web.zoom.us/j/79608718731?pwd=YlRMsnKUjYkJZVvmJYDNKmtsZHUqNa.1'),
(40135, 10021, 20021, '2025-05-05', '07:00:00', 'requested', 12, 'https://us04web.zoom.us/j/73619690952?pwd=i9p8WC9NEH4khUOirEG7nTyI3QJpuj.1'),
(40136, 10021, 20021, '2025-05-05', '13:00:00', 'requested', 8, 'https://us04web.zoom.us/j/72636876028?pwd=RoFYsFr4pFCluaZB5Nqa1KHXOUhoJE.1');

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
  `session_rating` int(11) DEFAULT NULL,
  `session_feedback_status` varchar(10) DEFAULT 'set',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session_feedback`
--

INSERT INTO `session_feedback` (`feedback_id`, `session_id`, `student_feedback`, `tutor_reply`, `last_updated`, `time_created`, `session_rating`, `session_feedback_status`, `deleted_at`) VALUES
(1, 40006, 'The session was very engaging.', 'Glad to hear that! Keep practicing.', '2025-02-09 14:30:00', '2025-02-09 13:00:00', 5, NULL, NULL),
(2, 40007, 'The pace was a bit too fast for me.', NULL, '2025-02-09 15:00:00', '2025-02-09 14:00:00', 2, NULL, NULL),
(3, 40008, 'I loved the teaching style. Very interactive!', 'Thank you! Happy to help.', '2025-02-17 11:45:00', '2025-02-17 10:30:00', 4, NULL, NULL),
(4, 40009, 'Some topics were confusing, but overall good.', NULL, '2025-01-16 17:30:00', '2025-01-16 16:00:00', 3, NULL, NULL),
(5, 40010, 'Would like more examples for better understanding.', 'I’ll include more examples next time.', '2025-02-07 09:15:00', '2025-02-07 08:00:00', 4, NULL, NULL),
(6, 40011, 'Excellent session! Very clear explanations.', 'Thank you! Hope to see you again.', '2025-01-08 18:30:00', '2025-01-08 17:00:00', 5, NULL, NULL),
(7, 40012, 'The content was helpful, but need more exercises.', 'I’ll share extra practice questions.', '2025-02-09 12:00:00', '2025-02-09 11:00:00', 4, NULL, NULL),
(8, 40013, 'Great session! I understand the topic better now.', 'Awesome! Keep practicing.', '2025-01-17 13:45:00', '2025-01-17 12:30:00', 5, NULL, NULL),
(9, 40014, 'The explanations were a bit rushed.', 'I’ll try to slow down and explain better.', '2025-01-31 10:30:00', '2025-01-31 09:00:00', 3, NULL, NULL),
(10, 40015, 'Overall, a good session.', 'I’ll go over them again in the next class.', '2025-02-05 15:15:00', '2025-02-05 14:00:00', 4, NULL, NULL),
(11, 40016, 'It was too basic for my level.', 'I’ll prepare more advanced content next time.', '2025-01-19 16:00:00', '2025-01-19 15:00:00', 2, NULL, NULL),
(12, 40017, 'The tutor was very patient and explained well.', 'Glad to help! Keep asking questions.', '2025-03-01 18:45:00', '2025-03-01 17:30:00', 5, NULL, NULL),
(13, 40018, NULL, '', '2025-01-11 09:45:00', '2025-01-11 08:30:00', 3, NULL, '0000-00-00 00:00:00'),
(14, 40019, 'Really enjoyed the lesson. Very helpful.', NULL, '2025-01-17 14:30:00', '2025-01-17 13:00:00', 5, NULL, NULL),
(15, 40020, 'Some parts were unclear, but overall good.', 'Let me know which parts and I’ll explain again.', '2025-01-25 12:15:00', '2025-01-25 11:00:00', 3, NULL, NULL),
(16, 40021, 'I learned a lot today. Thank you!', 'You’re welcome! Keep practicing.', '2025-01-19 16:30:00', '2025-01-19 15:15:00', 5, NULL, NULL),
(17, 40022, 'More practical exercises would be great.', 'I’ll add more practice next time.', '2025-02-17 10:00:00', '2025-02-17 08:45:00', 4, NULL, NULL),
(18, 40023, 'Enjoyed the session.', 'Glad to hear that! Keep studying.', '2025-02-22 14:45:00', '2025-02-22 13:30:00', 5, NULL, NULL),
(19, 40024, 'I had difficulty following the examples.', 'I’ll break them down further next time.', '2025-02-13 17:00:00', '2025-02-13 16:00:00', 3, NULL, NULL),
(20, 40025, 'The session was well-structured and informative.', 'Thanks! Hope it was helpful.', '2025-03-02 11:30:00', '2025-03-02 10:00:00', 5, NULL, NULL),
(21, 40026, 'Great tutor! I understood everything well.', 'Awesome! Keep up the good work.', '2025-01-05 14:00:00', '2025-01-05 12:45:00', 5, NULL, NULL),
(22, 40027, 'Could use a slower pace for better understanding.', 'Noted! I’ll adjust in future lessons.', '2025-03-04 13:42:44', '2025-01-06 09:00:00', 3, NULL, NULL),
(23, 40028, 'Very interactive and engaging session.', 'Glad you enjoyed it!', '2025-01-27 15:45:00', '2025-01-27 14:30:00', 5, NULL, NULL),
(24, 40029, 'The tutor clarified all my doubts.', 'That’s great! Keep asking questions.', '2025-01-16 17:30:00', '2025-01-16 16:15:00', 5, NULL, NULL),
(25, 40030, 'Good lesson, but I need more revision.', 'I’ll send some extra materials.', '2025-01-22 11:00:00', '2025-01-22 09:45:00', 4, NULL, NULL),
(26, NULL, 'hi\r\n', NULL, NULL, '2025-03-01 13:31:44', NULL, NULL, NULL),
(27, NULL, 'bhg\r\n', NULL, NULL, '2025-03-01 15:21:32', NULL, NULL, NULL),
(28, NULL, 'hghgh', NULL, NULL, '2025-03-01 15:42:55', NULL, NULL, NULL),
(29, NULL, 'ehwgqge', NULL, NULL, '2025-03-01 15:43:57', NULL, NULL, NULL),
(30, NULL, ' bg', NULL, NULL, '2025-03-01 15:45:12', NULL, NULL, NULL),
(33, 40062, 'hi sir.hey', NULL, '2025-03-05 02:45:03', '2025-03-05 02:43:58', 3, NULL, '2025-03-05 01:48:05'),
(34, 40062, 'hello sir', NULL, '2025-03-05 02:56:14', '2025-03-05 02:56:14', 4, NULL, '2025-03-05 01:57:14'),
(35, 40062, 'very boring', NULL, '2025-03-05 02:57:43', '2025-03-05 02:57:43', 3, NULL, '2025-03-05 01:58:07'),
(36, 40062, 'thank you sir', NULL, '2025-03-05 03:03:34', '2025-03-05 03:03:34', 3, NULL, '2025-03-05 02:03:55'),
(37, 40062, 'thank you for the valuable session sir', 'you\'re welcome. Keep up the good work', '2025-03-05 05:57:36', '2025-03-05 05:57:36', 4, NULL, '2025-03-05 04:59:49'),
(38, 40062, 'I really understood by your teaching method. very helpful', NULL, '2025-03-05 14:20:11', '2025-03-05 14:20:11', 4, NULL, '2025-03-05 13:21:59'),
(39, 40063, 'Madam thank you very much for explain me from the basics', NULL, '2025-03-05 14:27:35', '2025-03-05 14:27:35', 3, 'set', '2025-03-05 13:37:29'),
(40, 40061, 'session was very boring sir', NULL, '2025-03-05 14:28:58', '2025-03-05 14:28:58', 2, 'set', '2025-03-05 13:29:21'),
(41, 40062, 'no comments', NULL, '2025-03-05 14:38:18', '2025-03-05 14:38:18', 1, 'set', '2025-03-05 13:38:35'),
(42, 40061, 'the session was really useful sir', NULL, '2025-03-05 14:40:09', '2025-03-05 14:40:09', 5, 'set', '2025-03-05 13:40:21'),
(43, 40063, 'hello madam', NULL, '2025-03-05 14:43:22', '2025-03-05 14:43:22', 2, 'set', '2025-03-05 13:43:35'),
(44, 40063, 'very well explained', NULL, '2025-03-05 14:45:59', '2025-03-05 14:45:59', 5, 'set', '2025-03-05 13:46:14'),
(45, 40061, 'hello sir', NULL, '2025-03-05 14:55:57', '2025-03-05 14:55:57', 3, 'set', '2025-03-05 13:56:09'),
(46, 40061, 'sir, thank you for the valuable session', NULL, '2025-03-05 16:04:50', '2025-03-05 16:04:50', 2, 'set', '2025-03-05 15:05:18'),
(47, 40063, 'hi mam', NULL, '2025-03-05 16:09:32', '2025-03-05 16:09:32', 2, 'set', '2025-03-05 15:10:20'),
(48, 40063, 'hi mam. this is a very good session. thank you very much.', NULL, '2025-03-07 05:17:01', '2025-03-07 05:17:01', 3, 'set', '2025-03-07 04:18:55'),
(49, 40061, 'hi hey', NULL, '2025-03-07 05:19:18', '2025-03-07 05:19:12', 3, 'set', '2025-03-07 04:25:01'),
(50, 40062, 'hi', NULL, '2025-03-07 05:24:52', '2025-03-07 05:24:52', 3, 'set', '2025-03-07 04:24:58'),
(51, 40062, 'yes sir', NULL, '2025-03-07 05:27:01', '2025-03-07 05:27:01', 4, 'set', '2025-03-07 04:28:38'),
(52, 40063, 'hey mam', NULL, '2025-03-07 05:27:55', '2025-03-07 05:27:55', 4, 'set', '2025-03-07 04:28:30'),
(53, 40062, 'yes sir', NULL, '2025-03-07 05:29:06', '2025-03-07 05:29:06', 4, 'set', '2025-03-07 04:29:25'),
(54, 40062, 'very useful', NULL, '2025-03-07 05:31:19', '2025-03-07 05:31:19', 4, 'set', '2025-03-07 04:32:05'),
(55, 40061, 'very boring', NULL, '2025-03-07 05:32:30', '2025-03-07 05:32:30', 2, 'set', '2025-03-07 04:32:43'),
(56, 40062, 'yes', NULL, '2025-03-07 05:33:04', '2025-03-07 05:33:04', 3, 'set', '2025-03-07 04:33:18'),
(57, 40061, 'understood', NULL, '2025-03-07 05:33:40', '2025-03-07 05:33:40', 2, 'set', '2025-03-07 04:34:02'),
(58, 40126, 'nice session thank you so much', NULL, '2025-04-28 19:38:32', '2025-04-28 19:38:32', 5, 'set', NULL),
(59, 40117, 'The session was extremely helpful.', 'Thank you for your kind words! ', '2025-04-15 16:45:00', '2025-04-15 16:30:00', 5, 'set', NULL),
(60, 40118, 'The session was good but I would appreciate more practice problems next time.', 'Thank you ', '2025-04-20 14:15:00', '2025-04-20 14:00:00', 4, 'set', NULL),
(61, 40119, 'The tutor answered all my questions. Very satisfied!', '', '2025-04-18 12:30:00', '2025-04-18 12:15:00', 5, 'set', NULL),
(62, 40120, 'Some concepts were still confusing to me. ', 'We\'ll review those concepts in our next meeting.', '2025-04-22 17:00:00', '2025-04-22 16:45:00', 3, 'set', NULL),
(63, 40125, 'The session helped me understand the subject much better. The visual aids were very useful.', 'Glad to hear that!', '2025-04-10 12:15:00', '2025-04-10 12:00:00', 5, 'set', NULL),
(64, 40127, 'I found the pace a bit too fast. Would appreciate if we could slow down next time.', 'I apologize. We\'ll take it slower in next session.', '2025-04-21 14:15:00', '2025-04-21 14:00:00', 3, 'set', NULL),
(65, 40128, 'The tutor provided excellent examples. Thank you!', 'I\'m glad the examples were helpful to you.', '2025-04-23 12:45:00', '2025-04-23 12:30:00', 5, 'set', NULL),
(66, 40087, 'The session was informative but I need more clarification.', 'I\'ll give you materials', '2025-04-25 12:15:00', '2025-04-25 12:00:00', 4, 'set', NULL),
(67, 40065, 'The session exceeded my expectations.', 'Thank you for your feedback! ', '2025-04-09 14:30:00', '2025-04-09 14:15:00', 5, 'set', NULL),
(68, 40066, 'I would like more interactive elements next time.', 'Thanks for the suggestion!', '2025-04-09 14:45:00', '2025-04-09 14:30:00', 4, 'set', NULL);

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

--
-- Dumping data for table `session_payment`
--

INSERT INTO `session_payment` (`payment_id`, `session_id`, `student_id`, `tutor_id`, `payment_point_amount`, `payment_status`, `payment_time`) VALUES
(4, 40006, 10001, 20021, 50.00, 'okay', '2025-02-09 13:05:00'),
(5, 40007, 10002, 20022, 45.00, 'okay', '2025-02-09 14:10:00'),
(6, 40008, 10003, 20023, 60.00, 'okay', '2025-02-17 10:35:00'),
(7, 40009, 10004, 20024, 40.00, 'okay', '2025-01-16 16:05:00'),
(8, 40010, 10005, 20025, 55.00, 'okay', '2025-02-07 08:10:00'),
(9, 40011, 10011, 20031, 50.00, 'okay', '2025-01-08 17:05:00'),
(10, 40012, 10012, 20032, 45.00, 'okay', '2025-02-09 11:05:00'),
(11, 40013, 10013, 20033, 60.00, 'okay', '2025-01-17 12:35:00'),
(12, 40014, 10014, 20034, 40.00, 'refunded', '2025-01-31 09:05:00'),
(13, 40015, 10015, 20035, 55.00, 'okay', '2025-02-05 14:10:00'),
(14, 40016, 10016, 20036, 50.00, 'okay', '2025-01-19 15:05:00'),
(15, 40017, 10017, 20037, 45.00, 'okay', '2025-03-01 17:35:00'),
(16, 40018, 10018, 20038, 60.00, 'okay', '2025-01-11 08:35:00'),
(17, 40019, 10019, 20039, 40.00, 'refunded', '2025-01-17 13:05:00'),
(18, 40020, 10020, 20040, 55.00, 'okay', '2025-01-25 11:05:00'),
(19, 40021, 10001, 20021, 50.00, 'okay', '2025-01-19 15:20:00'),
(20, 40022, 10002, 20022, 45.00, 'refunded', '2025-02-17 08:50:00'),
(21, 40023, 10003, 20023, 60.00, 'okay', '2025-02-22 13:35:00'),
(22, 40024, 10004, 20024, 40.00, 'refunded', '2025-02-13 16:05:00'),
(23, 40025, 10005, 20025, 55.00, 'okay', '2025-03-02 10:10:00'),
(24, 40026, 10011, 20031, 50.00, 'okay', '2025-01-05 12:50:00'),
(25, 40027, 10012, 20032, 45.00, 'okay', '2025-01-06 09:05:00'),
(26, 40028, 10013, 20033, 60.00, 'okay', '2025-01-27 14:35:00'),
(27, 40029, 10014, 20034, 40.00, 'refunded', '2025-01-16 16:20:00'),
(28, 40030, 10015, 20035, 55.00, 'okay', '2025-01-22 09:50:00'),
(49, 40066, 10021, 20021, 160.00, 'okay', '2025-04-28 15:30:02'),
(50, 40059, 10004, 20035, 120.00, 'okay', '2025-04-28 17:14:04'),
(51, 40098, 10025, 20021, 160.00, 'okay', '2025-04-28 17:14:04');

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
  `student_status` enum('set','unset','requested','blocked') DEFAULT 'set',
  `student_registration_date` date DEFAULT NULL,
  `student_last_login` datetime DEFAULT NULL,
  `student_log` enum('online','offline') DEFAULT 'offline',
  `student_free_slots` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_first_name`, `student_last_name`, `student_DOB`, `student_grade`, `student_email`, `student_password`, `student_phonenumber`, `student_points`, `student_profile_photo`, `student_status`, `student_registration_date`, `student_last_login`, `student_log`, `student_free_slots`) VALUES
(10001, 'Tharindu', 'Silva', '2008-03-14', 10, 'tharindus@gmail.com', 'pass123', '0771234567', 7980, 'default.jpg', 'blocked', '2024-01-05', NULL, 'offline', 1),
(10002, 'Pasan', 'Wijesinghe', '2009-05-20', 9, 'pasanw@gmail.com', 'pass123', '0772345678', 105, 'default.jpg', 'blocked', '2024-01-08', NULL, 'offline', 1),
(10003, 'Isuru', 'Herath', '2010-08-30', 8, 'isuruh@gmail.com', 'pass123', '0773456781', 990, '1745158683_123 (1 of 1).jpg', 'set', '2024-01-10', NULL, 'offline', 1),
(10004, 'Sajith', 'Fernando', '2007-12-12', 11, 'sajithf@gmail.com', 'pass123', '0774567890', -95, '1745308461_Screenshot 2025-04-01 133528.png', 'set', '2024-01-12', NULL, 'offline', 1),
(10005, 'Dinuka', 'Rajapaksa', '2006-06-22', 11, 'dinukar@gmail.com', 'pass123', '0775678901', 30, 'default.jpg', 'set', '2024-01-15', NULL, 'offline', 0),
(10011, 'Kavindu', 'Perera', '2010-05-14', 8, 'kavindu.perera@example.lk', 'pass123', '0776543210', 5950, 'default.jpg', 'set', '2025-02-10', '2025-02-24 23:42:20', 'online', 1),
(10012, 'Sanduni', 'Fernando', '2011-07-22', 7, 'sanduni.fernando@example.lk', 'pass123', '0766543211', 85, 'default.jpg', 'set', '2025-02-11', '2025-02-24 23:42:20', 'offline', 1),
(10013, 'Hasitha', 'Bandara', '2009-03-18', 9, 'hasitha.bandara@example.lk', 'pass123', '0716543212', 60, 'default.jpg', 'set', '2025-02-12', '2025-02-24 23:42:20', 'online', 0),
(10014, 'Tharushi', 'Wijesinghe', '2012-01-10', 6, 'tharushi.wijesinghe@example.lk', 'pass123', '0726543213', 4170, '1745214326_istockphoto-494466008-612x612.jpg', 'set', '2025-02-13', '2025-02-24 23:42:20', 'offline', 1),
(10015, 'Ravindu', 'Jayasinghe', '2008-09-05', 10, 'ravindu.jayasinghe@example.lk', 'pass123', '0746543214', 55, 'default.jpg', 'set', '2025-02-14', '2025-02-24 23:42:20', 'online', 1),
(10016, 'Nethmi', 'Gunawardena', '2009-11-21', 9, 'nethmi.gunawardena@example.lk', 'pass123', '0756543215', 5955, 'default.jpg', 'set', '2025-02-15', '2025-02-24 23:42:20', 'offline', 0),
(10017, 'Pasindu', 'Ratnayake', '2011-04-30', 7, 'pasindu.ratnayake@example.lk', 'pass123', '0786543216', 35, 'default.jpg', 'unset', '2025-02-16', '2025-02-24 23:42:20', 'online', 1),
(10018, 'Dilini', 'Ekanayake', '2010-06-12', 8, 'dilini.ekanayake@example.lk', 'pass123', '0706543217', 110, 'default.jpg', 'set', '2025-02-17', '2025-02-24 23:42:20', 'offline', 1),
(10019, 'Kasun', 'Dias', '2008-02-18', 11, 'kasun.dias@example.lk', 'pass123', '0776543218', 4135, 'default.jpg', 'set', '2025-02-18', '2025-02-24 23:42:20', 'online', 0),
(10020, 'Sajini', 'Senanayake', '2007-12-05', 11, 'sajini.senanayake@example.lk', 'pass123', '0766543219', 70, 'default.jpg', 'set', '2025-02-19', '2025-02-24 23:42:20', 'offline', 1),
(10021, 'Dinithi', 'Herath', '2015-02-03', 10, 'dinithi@gmail.com', '$2y$10$nvg9GczyAlgoyaVmZnhgI.6m/fz.nkzTQLTiUF83yhafeom0F0oyK', '0772546854', 1480, '680df21707f4f_680760255369e_stu2.jpg', 'set', NULL, '2025-04-29 11:57:51', 'offline', 0),
(10022, 'Sandya', 'Weerasooriya', '2008-10-28', NULL, 'sandya@gmail.com', '$2y$10$WxDkW1.MPRxcF0ykSyZbeuG1AbKPiG0GOnPtQV3lX/3KIs4x4ZR3C', '0772536147', 1200, NULL, 'set', NULL, NULL, 'offline', 0),
(10023, 'Piyumi', 'Herath', '2014-06-10', NULL, 'piyumi@gmail.com', '$2y$10$XLUcpur0gtLLarPa4WwSeOEBmMuuVkTZjHon2tlCM/KC7ICF4z7/K', '0775698992', 500, 'student_1.jpg', 'set', NULL, NULL, 'offline', 0),
(10024, 'Nirukshi', 'Loganathan', '2013-11-06', NULL, 'nirukshi@gmail.com', '$2y$10$4ZOEtigK9O62kIgGQg2CzeqUj3Vep88u.Uk9pKq.CtP3zL3D.EFge', '0762594731', 750, 'student_2.jpg', 'unset', NULL, NULL, 'offline', 0),
(10025, 'Sandeep', 'Vaz', '2010-03-13', 11, 'sv@gmail.com', '$2y$10$AbYlsyYygXDLVma2kTTvyehTg1j2zYIS0KXzgoQj5iMzuhGarlVrG', '0767777777', 840, '680f5932922c6_111.jpg', 'set', '2025-04-28', '2025-04-28 19:37:44', 'offline', 0),
(10026, 'Anban', 'Shayan', '2009-06-12', 10, 'shayan@gmail.com', '$2y$10$IoIgpq5WiNWIblSzk/QCBeKxTabHr9o1S2C0dJT4sfeamU5z6TNFO', '0705226201', 2000, '680f6b58736d2_shayan.jpg', 'set', '2025-04-28', '2025-04-28 17:15:48', 'offline', 0),
(10027, 'Thiruveni', 'Kumarasoriya', '2008-08-21', 9, 'thiru@gmail.com', '$2y$10$WfyX173ytvelEaVbk6Mg9OxZh6oTVAJGu4zdREeeGIZgoNOmVDYwy', '0705226201', 2200, '680f6c9b92bb6_33.jpg', 'set', '2025-04-28', '2025-04-28 19:06:59', 'online', 0),
(10028, 'Parami', 'Anupama', '2014-05-15', 8, 'parami@gmail.com', '$2y$10$FyOsupmxf2ZGB9zvJJkr4eHR.a0AHGx9Xw16f/CEcpLzz9M6qZkQy', '0789466123', 2000, '680f6db690a8b_22.jpg', 'set', '2025-04-28', '2025-04-28 17:28:30', 'offline', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_availability`
--

CREATE TABLE `student_availability` (
  `student_id` int(11) NOT NULL,
  `time_slot_id` int(11) NOT NULL,
  `day` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_availability`
--

INSERT INTO `student_availability` (`student_id`, `time_slot_id`, `day`) VALUES
(10021, 1, 'Monday'),
(10021, 1, 'Tuesday'),
(10021, 2, 'Monday'),
(10021, 3, 'Monday'),
(10021, 4, 'Monday'),
(10021, 5, 'Monday'),
(10021, 6, 'Monday'),
(10021, 7, 'Monday'),
(10021, 7, 'Sunday'),
(10021, 8, 'Friday'),
(10021, 8, 'Monday'),
(10021, 8, 'Saturday'),
(10021, 8, 'Sunday'),
(10021, 8, 'Tuesday'),
(10021, 9, 'Friday'),
(10021, 9, 'Monday'),
(10021, 9, 'Saturday'),
(10021, 9, 'Sunday'),
(10021, 9, 'Thursday'),
(10021, 9, 'Tuesday'),
(10021, 9, 'Wednesday'),
(10021, 10, 'Friday'),
(10021, 10, 'Monday'),
(10021, 10, 'Saturday'),
(10021, 10, 'Sunday'),
(10021, 10, 'Thursday'),
(10021, 10, 'Tuesday'),
(10021, 10, 'Wednesday'),
(10021, 11, 'Friday'),
(10021, 11, 'Monday'),
(10021, 11, 'Sunday'),
(10021, 11, 'Thursday'),
(10021, 11, 'Tuesday'),
(10021, 11, 'Wednesday'),
(10021, 16, 'Friday'),
(10021, 16, 'Monday'),
(10021, 16, 'Saturday'),
(10021, 16, 'Sunday'),
(10021, 16, 'Thursday'),
(10021, 16, 'Tuesday'),
(10021, 16, 'Wednesday'),
(10021, 17, 'Friday'),
(10021, 17, 'Monday'),
(10021, 17, 'Saturday'),
(10021, 17, 'Sunday'),
(10021, 17, 'Thursday'),
(10021, 17, 'Tuesday'),
(10021, 17, 'Wednesday'),
(10021, 18, 'Friday'),
(10021, 18, 'Monday'),
(10021, 18, 'Saturday'),
(10021, 18, 'Sunday'),
(10021, 18, 'Thursday'),
(10021, 18, 'Tuesday'),
(10021, 18, 'Wednesday'),
(10025, 1, 'Friday'),
(10025, 1, 'Monday'),
(10025, 1, 'Saturday'),
(10025, 1, 'Sunday'),
(10025, 1, 'Thursday'),
(10025, 1, 'Tuesday'),
(10025, 1, 'Wednesday'),
(10025, 2, 'Friday'),
(10025, 2, 'Monday'),
(10025, 2, 'Saturday'),
(10025, 2, 'Sunday'),
(10025, 2, 'Thursday'),
(10025, 2, 'Tuesday'),
(10025, 2, 'Wednesday'),
(10025, 3, 'Friday'),
(10025, 3, 'Monday'),
(10025, 3, 'Saturday'),
(10025, 3, 'Sunday'),
(10025, 3, 'Thursday'),
(10025, 3, 'Tuesday'),
(10025, 3, 'Wednesday'),
(10025, 4, 'Friday'),
(10025, 4, 'Monday'),
(10025, 4, 'Saturday'),
(10025, 4, 'Sunday'),
(10025, 4, 'Thursday'),
(10025, 4, 'Tuesday'),
(10025, 4, 'Wednesday'),
(10025, 5, 'Friday'),
(10025, 5, 'Monday'),
(10025, 5, 'Saturday'),
(10025, 5, 'Sunday'),
(10025, 5, 'Thursday'),
(10025, 5, 'Tuesday'),
(10025, 5, 'Wednesday'),
(10025, 6, 'Friday'),
(10025, 6, 'Monday'),
(10025, 6, 'Saturday'),
(10025, 6, 'Sunday'),
(10025, 6, 'Thursday'),
(10025, 6, 'Tuesday'),
(10025, 6, 'Wednesday'),
(10025, 7, 'Friday'),
(10025, 7, 'Monday'),
(10025, 7, 'Saturday'),
(10025, 7, 'Sunday'),
(10025, 7, 'Thursday'),
(10025, 7, 'Tuesday'),
(10025, 7, 'Wednesday'),
(10025, 8, 'Friday'),
(10025, 8, 'Monday'),
(10025, 8, 'Saturday'),
(10025, 8, 'Sunday'),
(10025, 8, 'Thursday'),
(10025, 8, 'Tuesday'),
(10025, 8, 'Wednesday'),
(10025, 9, 'Friday'),
(10025, 9, 'Monday'),
(10025, 9, 'Saturday'),
(10025, 9, 'Sunday'),
(10025, 9, 'Thursday'),
(10025, 9, 'Tuesday'),
(10025, 9, 'Wednesday'),
(10025, 10, 'Friday'),
(10025, 10, 'Monday'),
(10025, 10, 'Saturday'),
(10025, 10, 'Sunday'),
(10025, 10, 'Thursday'),
(10025, 10, 'Tuesday'),
(10025, 10, 'Wednesday'),
(10025, 11, 'Friday'),
(10025, 11, 'Monday'),
(10025, 11, 'Saturday'),
(10025, 11, 'Sunday'),
(10025, 11, 'Thursday'),
(10025, 11, 'Tuesday'),
(10025, 11, 'Wednesday'),
(10025, 16, 'Friday'),
(10025, 16, 'Monday'),
(10025, 16, 'Saturday'),
(10025, 16, 'Sunday'),
(10025, 16, 'Thursday'),
(10025, 16, 'Tuesday'),
(10025, 16, 'Wednesday'),
(10025, 17, 'Friday'),
(10025, 17, 'Monday'),
(10025, 17, 'Saturday'),
(10025, 17, 'Sunday'),
(10025, 17, 'Thursday'),
(10025, 17, 'Tuesday'),
(10025, 17, 'Wednesday'),
(10025, 18, 'Friday'),
(10025, 18, 'Monday'),
(10025, 18, 'Saturday'),
(10025, 18, 'Sunday'),
(10025, 18, 'Thursday'),
(10025, 18, 'Tuesday'),
(10025, 18, 'Wednesday'),
(10026, 1, 'Saturday'),
(10026, 2, 'Saturday'),
(10026, 3, 'Saturday'),
(10026, 4, 'Saturday'),
(10026, 5, 'Saturday'),
(10026, 6, 'Saturday'),
(10026, 7, 'Saturday'),
(10026, 8, 'Friday'),
(10026, 8, 'Monday'),
(10026, 8, 'Saturday'),
(10026, 8, 'Thursday'),
(10026, 8, 'Tuesday'),
(10026, 8, 'Wednesday'),
(10026, 9, 'Friday'),
(10026, 9, 'Monday'),
(10026, 9, 'Saturday'),
(10026, 9, 'Thursday'),
(10026, 9, 'Tuesday'),
(10026, 9, 'Wednesday'),
(10026, 10, 'Friday'),
(10026, 10, 'Monday'),
(10026, 10, 'Saturday'),
(10026, 10, 'Thursday'),
(10026, 10, 'Tuesday'),
(10026, 10, 'Wednesday'),
(10026, 11, 'Friday'),
(10026, 11, 'Monday'),
(10026, 11, 'Saturday'),
(10026, 11, 'Thursday'),
(10026, 11, 'Tuesday'),
(10026, 11, 'Wednesday'),
(10026, 16, 'Friday'),
(10026, 16, 'Monday'),
(10026, 16, 'Saturday'),
(10026, 16, 'Thursday'),
(10026, 16, 'Tuesday'),
(10026, 16, 'Wednesday'),
(10026, 17, 'Friday'),
(10026, 17, 'Monday'),
(10026, 17, 'Saturday'),
(10026, 17, 'Thursday'),
(10026, 17, 'Tuesday'),
(10026, 17, 'Wednesday'),
(10026, 18, 'Friday'),
(10026, 18, 'Monday'),
(10026, 18, 'Saturday'),
(10026, 18, 'Thursday'),
(10026, 18, 'Tuesday'),
(10026, 18, 'Wednesday'),
(10027, 8, 'Friday'),
(10027, 8, 'Monday'),
(10027, 8, 'Saturday'),
(10027, 8, 'Sunday'),
(10027, 8, 'Thursday'),
(10027, 8, 'Tuesday'),
(10027, 8, 'Wednesday'),
(10027, 9, 'Friday'),
(10027, 9, 'Monday'),
(10027, 9, 'Saturday'),
(10027, 9, 'Sunday'),
(10027, 9, 'Thursday'),
(10027, 9, 'Tuesday'),
(10027, 9, 'Wednesday'),
(10027, 10, 'Friday'),
(10027, 10, 'Monday'),
(10027, 10, 'Saturday'),
(10027, 10, 'Sunday'),
(10027, 10, 'Thursday'),
(10027, 10, 'Tuesday'),
(10027, 10, 'Wednesday'),
(10027, 11, 'Friday'),
(10027, 11, 'Monday'),
(10027, 11, 'Saturday'),
(10027, 11, 'Sunday'),
(10027, 11, 'Thursday'),
(10027, 11, 'Tuesday'),
(10027, 11, 'Wednesday'),
(10027, 16, 'Friday'),
(10027, 16, 'Monday'),
(10027, 16, 'Saturday'),
(10027, 16, 'Sunday'),
(10027, 16, 'Thursday'),
(10027, 16, 'Tuesday'),
(10027, 16, 'Wednesday'),
(10027, 17, 'Friday'),
(10027, 17, 'Monday'),
(10027, 17, 'Saturday'),
(10027, 17, 'Sunday'),
(10027, 17, 'Thursday'),
(10027, 17, 'Tuesday'),
(10027, 17, 'Wednesday'),
(10027, 18, 'Friday'),
(10027, 18, 'Monday'),
(10027, 18, 'Saturday'),
(10027, 18, 'Sunday'),
(10027, 18, 'Thursday'),
(10027, 18, 'Tuesday'),
(10027, 18, 'Wednesday');

-- --------------------------------------------------------

--
-- Table structure for table `student_forum`
--

CREATE TABLE `student_forum` (
  `forum_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `reply_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_forum`
--

INSERT INTO `student_forum` (`forum_id`, `name`, `comment`, `date`, `reply_id`) VALUES
(1, 'anban', 'vairavar', 'April 13 2025, 09:50:23 AM', 0),
(2, 'john', 'doubt solved', 'April 13 2025, 10:33:19 AM', 0),
(3, 'shayan', 'How photosynthesis occurs in winter in western countries', 'April 13 2025, 10:35:30 AM', 0),
(4, 'thiwanga', 'hello there', 'April 13 2025, 10:36:33 AM', 0),
(5, 'A Shayan', 'leave a comment', '2025-04-13 14:13:14', 0),
(6, 'kuga', 'mission proceeded', '2025-04-13 14:21:15', 0),
(7, 'thiwanga', 'green house', '2025-04-13 14:34:50', 3),
(8, 's vaz', 'can you recommend it?', '2025-04-29 07:48:09', 0),
(9, 'thiwanga', 'it\'s a good platform', '2025-04-29 07:48:26', 8);

-- --------------------------------------------------------

--
-- Table structure for table `student_inbox`
--

CREATE TABLE `student_inbox` (
  `inbox_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `sender_type` enum('admin','tutor') NOT NULL,
  `sender_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('unread','read','archived') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_inbox`
--

INSERT INTO `student_inbox` (`inbox_id`, `student_id`, `sender_type`, `sender_id`, `subject`, `message`, `sent_at`, `status`) VALUES
(1, 10001, 'admin', 1, 'Welcome to eGuru', 'Welcome to our platform! We are excited to have you join our learning community.', '2025-04-01 04:30:00', 'unread'),
(2, 10002, 'admin', 1, 'Session Schedule Update', 'Please note that your requested session has been scheduled for next week.', '2025-04-02 06:00:00', 'read'),
(3, 10003, 'tutor', 20023, 'Upcoming Mathematics Session', 'I have prepared additional materials for our next session. Please review them before class.', '2025-04-03 03:45:00', 'unread'),
(4, 10004, 'admin', 1, 'Payment Confirmation', 'Your payment for the Science course has been successfully processed.', '2025-04-04 08:50:00', 'read'),
(5, 10005, 'tutor', 20025, 'Homework Feedback', 'I have reviewed your homework. You did well but please focus more on the problem-solving section.', '2025-04-05 11:15:00', 'unread'),
(6, 10011, 'admin', 1, 'System Maintenance Notice', 'Our platform will be undergoing maintenance this Saturday from 2 AM to 5 AM.', '2025-04-06 03:00:00', 'archived'),
(7, 10012, 'tutor', 20031, 'English Session Rescheduled', 'Due to unforeseen circumstances, our session has been moved to Friday at 4 PM.', '2025-04-07 06:40:00', 'read'),
(8, 10013, 'admin', 1, 'New Course Available', 'We have added a new ICT course that might interest you. Check it out!', '2025-04-08 03:30:00', 'unread'),
(9, 10014, 'tutor', 20034, 'Assignment Submission', 'Your last assignment has not been submitted. Please submit it as soon as possible.', '2025-04-09 10:00:00', 'read'),
(10, 10015, 'admin', 1, 'Special Discount Offer', 'As a valued student, you are eligible for a 15% discount on your next course purchase.', '2025-04-10 06:15:00', 'unread'),
(11, 10016, 'tutor', 20035, 'Progress Update', 'I am pleased with your progress in the Physics course. Keep up the good work!', '2025-04-11 07:50:00', 'read'),
(12, 10017, 'admin', 1, 'Account Verification Complete', 'Your account has been successfully verified. You now have access to all features.', '2025-04-12 05:20:00', 'unread'),
(13, 10018, 'tutor', 20038, 'Study Material Shared', 'I have shared some additional study materials in the resources section.', '2025-04-13 08:45:00', 'read'),
(14, 10019, 'admin', 1, 'Feedback Request', 'Please take a moment to provide feedback on your recent session with Tutor Asela.', '2025-04-14 04:00:00', 'unread'),
(15, 10020, 'tutor', 20040, 'Exam Preparation', 'Let\'s focus on past papers in our next session to prepare for your upcoming exam.', '2025-04-15 10:30:00', 'read'),
(16, 10021, 'admin', 1, 'Testing Message', 'Test1', '2025-04-18 15:56:33', 'unread'),
(17, 10021, 'admin', 2, 'Test1', 'test', '2025-04-20 11:42:08', 'unread'),
(18, 10021, 'admin', 2, 'Test1', 'test', '2025-04-21 07:50:27', 'unread'),
(19, 10013, 'admin', 2, 'test', 'test', '2025-04-21 07:50:39', 'unread'),
(20, 10018, 'tutor', 20021, 'Thank you message', 'Thanks for attending my session. if you have any further inquiries please feel free to ask.', '2025-04-28 18:08:17', 'unread'),
(21, 10027, 'tutor', 20021, 'Thank you message', 'Thanks for attending my session. if you have any further inquiries please feel free to ask.', '2025-04-28 18:08:17', 'unread'),
(22, 10021, 'tutor', 20021, 'Thanks for the feedback', 'Thank you so much for the positive feedback. It matters a lot to me. If you need anymore further assistance feel free to contact me.', '2025-04-28 18:14:24', 'archived');

-- --------------------------------------------------------

--
-- Table structure for table `student_inbox_reply`
--

CREATE TABLE `student_inbox_reply` (
  `id` int(11) NOT NULL,
  `inbox_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sender_type` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_inbox_reply`
--

INSERT INTO `student_inbox_reply` (`id`, `inbox_id`, `message`, `sender_type`, `created_at`) VALUES
(1, 1, 'Hello, I have a question about the assignment.', 'student', '2025-04-21 10:15:00'),
(2, 1, 'Sure, what specifically are you confused about?', 'tutor', '2025-04-21 10:20:00'),
(3, 2, 'I submitted my homework late. Will it be graded?', 'student', '2025-04-21 11:00:00'),
(4, 2, 'Please reach out to your course tutor about this.', 'admin', '2025-04-21 00:00:00'),
(5, 1, 'Hi, I’m having trouble accessing my session link.', 'student', '2025-04-20 08:00:00'),
(6, 1, 'Thanks for reporting. A new link has been sent to your email.', 'admin', '2025-04-20 08:10:00'),
(7, 1, 'Got it. It’s working now. Appreciate the help!', 'student', '2025-04-20 08:15:00'),
(8, 2, 'Can I change my session time to 5pm instead of 4pm?', 'student', '2025-04-20 12:30:00'),
(9, 2, 'Let me check with your tutor and get back to you.', 'admin', '2025-04-20 12:40:00'),
(10, 2, 'Your session has been updated to 5pm as requested.', 'admin', '2025-04-20 13:00:00'),
(11, 3, 'I accidentally booked two sessions on the same day.', 'student', '2025-04-21 09:45:00'),
(12, 3, 'No worries. I’ll cancel one and refund your points.', 'admin', '2025-04-21 09:55:00'),
(13, 4, 'Can I get feedback on my last math session?', 'student', '2025-04-21 14:00:00'),
(14, 4, 'Yes, your tutor gave positive remarks. It’s been uploaded to your profile.', 'admin', '2025-04-21 14:10:00'),
(15, 5, 'I tried paying for points but it failed.', 'student', '2025-04-21 15:00:00'),
(16, 5, 'Sorry about that! Please try again using a different method or wait a few minutes.', 'admin', '2025-04-21 15:05:00'),
(17, 5, 'It worked the second time. Thanks!', 'student', '2025-04-21 15:15:00'),
(18, 22, 'My pleasure. You deserve it sir. Don\'t forget to accept  my new request.', 'student', '2025-04-28 23:50:31');

-- --------------------------------------------------------

--
-- Table structure for table `student_point_purchase`
--

CREATE TABLE `student_point_purchase` (
  `payment_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `point_amount` int(11) DEFAULT NULL,
  `cash_value` int(11) DEFAULT NULL,
  `bank_transaction_id` varchar(255) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `transaction_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_point_purchase`
--

INSERT INTO `student_point_purchase` (`payment_id`, `student_id`, `point_amount`, `cash_value`, `bank_transaction_id`, `transaction_date`, `transaction_time`) VALUES
(1, 10011, 120, 1200, 'TXN10011A', '2025-04-23', '2025-04-23 06:55:00'),
(2, 10012, 2000, 20000, 'TXN10012B', '2025-04-23', '2025-04-23 06:55:00'),
(3, 10013, 1500, 15000, 'TXN10013C', '2025-04-23', '2025-04-23 06:55:00'),
(4, 10014, 3000, 30000, 'TXN10014D', '2025-04-23', '2025-04-23 06:55:00'),
(5, 10015, 100, 1000, 'TXN10015E', '2025-04-23', '2025-04-23 06:55:00'),
(6, 10016, 400, 4000, 'TXN10016F', '2025-04-23', '2025-04-23 06:55:00'),
(7, 10017, 250, 2500, 'TXN10017G', '2025-04-23', '2025-04-23 06:55:00'),
(8, 10018, 1800, 18000, 'TXN10018H', '2025-04-23', '2025-04-23 06:55:00'),
(9, 10019, 3200, 32000, 'TXN10019I', '2025-04-23', '2025-04-23 06:55:00'),
(10, 10020, 2100, 21000, 'TXN10020J', '2025-04-23', '2025-04-23 06:55:00'),
(11, 10021, 130, 1300, 'TXN10021K', '2025-04-23', '2025-04-23 06:55:00'),
(12, 10022, 270, 2700, 'TXN10022L', '2025-04-23', '2025-04-23 06:55:00'),
(13, 10023, 360, 3600, 'TXN10023M', '2025-04-23', '2025-04-23 06:55:00'),
(14, 10024, 110, 1100, 'TXN10024N', '2025-04-23', '2025-04-23 06:55:00'),
(16, 10004, 1000, 10000, 'TNX1234556td', '2025-04-09', '0000-00-00 00:00:00'),
(17, 10004, 1000, 10000, 'TNX1234556td', '2025-04-09', '0000-00-00 00:00:00'),
(18, 10021, 100, 1000, 'TXN100216', '2025-04-27', '2025-04-27 08:52:42'),
(19, 10021, 50, 500, 'TXN10021D', '2025-04-27', '2025-04-27 13:16:36'),
(20, 10021, 1000, 7500, 'TXN100216', '2025-04-28', '2025-04-28 09:55:45'),
(22, 10025, 50, 500, 'TXN10025A', '2025-04-28', '2025-04-28 11:27:30'),
(23, 10025, 1000, 10000, 'TXN10025F', '2025-04-28', '2025-04-28 11:34:47'),
(24, 10026, 1000, 7500, 'TXN100260', '2025-04-28', '2025-04-28 11:51:03'),
(25, 10026, 1000, 10000, 'TXN100261', '2025-04-28', '2025-04-28 11:51:31'),
(26, 10028, 1000, 7500, 'TXN10028D', '2025-04-28', '2025-04-28 12:00:31'),
(27, 10028, 1000, 7500, 'TXN10028E', '2025-04-28', '2025-04-28 12:00:52'),
(28, 10027, 1000, 7500, 'TXN10027B', '2025-04-28', '2025-04-28 13:39:02'),
(29, 10027, 1200, 12000, 'TXN100276', '2025-04-28', '2025-04-28 13:39:44'),
(30, 10021, 1000, 7500, 'TXN100215', '2025-04-29', '2025-04-29 04:19:21'),
(31, 10021, 300, 2700, 'TXN100216', '2025-04-29', '2025-04-29 05:49:40');

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
  `city_town` varchar(100) DEFAULT NULL,
  `student_profile_photo` varchar(255) DEFAULT NULL,
  `student_grade` int(11) DEFAULT NULL,
  `profile_status` enum('set','unset') DEFAULT 'set'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_profile`
--

INSERT INTO `student_profile` (`student_id`, `bio`, `education`, `interests`, `country`, `city_town`, `student_profile_photo`, `student_grade`, `profile_status`) VALUES
(10001, 'A Grade 10 student interested in Science.', 'Ongoing school education', 'Reading, Chess', 'Sri Lanka', 'Colombo', NULL, NULL, 'set'),
(10002, 'Grade 9 student who loves math and coding.', 'Ongoing school education', 'Programming, Cricket', 'Sri Lanka', 'Kandy', NULL, NULL, 'set'),
(10003, 'Enthusiastic learner of English literature.', 'Ongoing school education', 'Writing, Drama', 'Sri Lanka', 'Galle', NULL, NULL, 'set'),
(10004, 'Aspiring engineer passionate about physics.', 'Ongoing school education', 'Electronics, Robotics', 'Sri Lanka', 'Kurunegala', NULL, NULL, 'set'),
(10005, 'Music lover and aspiring singer.', 'Ongoing school education', 'Singing, Guitar', 'Sri Lanka', 'Negombo', NULL, NULL, 'set'),
(10011, 'Aspiring engineer', 'Grade 9', 'Physics, Robotics', 'Sri Lanka', 'Matara', NULL, NULL, 'set'),
(10012, 'Sports enthusiast', 'Grade 7', 'Cricket, Athletics', 'Sri Lanka', 'Negombo', NULL, NULL, 'set'),
(10013, 'Music lover', 'Grade 8', 'Piano, Singing', 'Sri Lanka', 'Anuradhapura', NULL, NULL, 'set'),
(10014, 'Math genius', 'Grade 11', 'Math Olympiads, Puzzles', 'Sri Lanka', 'Ratnapura', NULL, NULL, 'set'),
(10015, 'Future doctor', 'Grade 10', 'Biology, Human Anatomy', 'Sri Lanka', 'Badulla', NULL, NULL, 'set'),
(10016, 'Tech enthusiast', 'Grade 9', 'Programming, AI', 'Sri Lanka', 'Gampaha', NULL, NULL, 'set'),
(10017, 'Bookworm', 'Grade 8', 'Fiction, Literature', 'Sri Lanka', 'Kurunegala', NULL, NULL, 'set'),
(10018, 'Environmentalist', 'Grade 7', 'Sustainability, Wildlife', 'Sri Lanka', 'Jaffna', NULL, NULL, 'set'),
(10019, 'Chess player', 'Grade 10', 'Strategy games, Logic puzzles', 'Sri Lanka', 'Colombo', NULL, NULL, 'set'),
(10020, 'Budding artist', 'Grade 6', 'Painting, Sketching', 'Sri Lanka', 'Kandy', NULL, NULL, 'set'),
(10021, 'A Grade 10 student interested in Science.', 'Ongoing school education', 'Reading, Chess', 'SriLanka', 'Colombo', '', 10, 'set'),
(10023, 'Dancer, Badminton player', 'student at pnc', 'like to play badminton', 'SriLanka', 'Kandy', '67cd02830ae02_stu2.jpg', 10, 'set'),
(10024, 'Music lover, dancer', 'grade 8 student at PNC', 'like to play chess and carrom', 'SriLanka', 'Jaffna', NULL, 8, 'unset'),
(10025, 'I&#039;m a passionate student who likes learning new things', 'St.Sebastian&#039;s College', 'Uyana,Moratuwa', 'Sri Lanka', 'Moratuwa', '680f591faaba9_111.jpg', 11, 'set'),
(10026, 'I am nothing', 'Hindu College, Jaffna', 'Food', 'Sri Lanka', 'Jaffna', '680f6b50722cd_shayan.jpg', 10, 'set'),
(10027, 'UCSC Colombo', 'Pakkiyam National College Matale', 'Java Script', 'Sri Lanka', 'Matale', '680f6c9332334_33.jpg', 9, 'set'),
(10028, '', 'Anula Vidyalaya, Nugegoda', 'Cats', 'Sri Lanka', 'Maharagama', '680f6da5bc418_22.jpg', 8, 'set');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `subject_display_pic` varchar(255) DEFAULT NULL,
  `subject_status` varchar(15) NOT NULL DEFAULT 'set'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_name`, `subject_display_pic`, `subject_status`) VALUES
(1, 'Mathematics', 'math_icon.jpg', 'set'),
(2, 'Science', 'Chemistry.jpg', 'set'),
(3, 'English', 'English.jpg', 'set'),
(4, 'Sinhala', 'Sinhala.jpg', 'set'),
(5, 'Tamil', 'Tamil.svg', 'set'),
(6, 'History', 'History.png', 'set'),
(7, 'Geography', 'Geography.jpg', 'set'),
(8, 'Buddhism', 'Buddhism.jpeg', 'set'),
(9, 'Information Technology', 'IT.jpg', 'set'),
(10, 'Physics', 'Physics.jpg', 'set'),
(11, 'Chemistry', 'Chemistry.jpg', 'set'),
(12, 'Biology', 'Biology.jpg', 'set'),
(30001, 'guitar', 'First lane.png', 'unset');

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
(1, 7, 9),
(2, 8, 10),
(3, 9, 11),
(4, 10, 12),
(5, 11, 13),
(6, 12, 14),
(7, 13, 15),
(8, 14, 16),
(9, 15, 17),
(10, 16, 18),
(11, 17, 19),
(16, 18, 20),
(17, 19, 21),
(18, 20, 22);

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
  `tutor_status` enum('set','unset','requested','blocked') DEFAULT 'set',
  `tutor_registration_date` date DEFAULT NULL,
  `tutor_time_slots` tinyint(1) DEFAULT 0,
  `tutor_last_login` datetime DEFAULT NULL,
  `tutor_log` enum('online','offline') DEFAULT 'offline',
  `tutor_level_id` varchar(50) DEFAULT NULL,
  `tutor_qualification_proof` varchar(255) DEFAULT NULL,
  `tutor_ad_id` int(11) DEFAULT NULL,
  `tutor_contact_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`tutor_id`, `tutor_first_name`, `tutor_last_name`, `tutor_email`, `tutor_password`, `tutor_NIC`, `tutor_DOB`, `tutor_points`, `tutor_profile_photo`, `tutor_status`, `tutor_registration_date`, `tutor_time_slots`, `tutor_last_login`, `tutor_log`, `tutor_level_id`, `tutor_qualification_proof`, `tutor_ad_id`, `tutor_contact_number`) VALUES
(20021, 'Kasun', 'Perera', 'kasunp@gmail.com', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 872345678, '1985-06-15', 7980, 'tutor8.jpg', 'set', '2024-01-10', 1, '2025-04-26 20:17:09', 'offline', 'G02', 'kasun_cert.pdf', 54, 767873445),
(20022, 'Nimal', 'Fernando', 'nimalf@gmail.com', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 882345678, '1987-09-21', 955, 'nimal.jpg', 'requested', '2024-01-12', 1, NULL, 'offline', 'G04', 'nimal_cert.pdf', NULL, NULL),
(20023, 'Amal', 'Jayasinghe', 'amalj@gmail.com', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 902345678, '1990-02-11', 2700, '1745159207_123 (1 of 1).jpg', 'set', '2024-01-15', 0, NULL, 'offline', 'G06', 'amal_cert.pdf', NULL, 767777777),
(20024, 'Chathura', 'Senanayake', 'chathuras@gmail.com', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 912345678, '1983-11-30', 540, '1745159476_il_1080xN.4426095458_sd2f.jpg', 'blocked', '2024-01-18', 0, NULL, 'offline', NULL, 'chathura_cert.pdf', NULL, 767777777),
(20025, 'Dilan', 'Rathnayake', 'dilanr@gmail.com', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 922345678, '1988-07-05', 100, '1745159585_gpic.jpg', 'set', '2024-01-20', 0, NULL, 'offline', 'G05', 'dilan_cert.pdf', NULL, 767777777),
(20031, 'Mahesh', 'De Silva', 'mahesh.desilva@example.lk', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 922345678, '1985-03-15', 6200, '1745582086__MG_9073.jpg', 'set', '2025-02-10', 1, '2025-02-24 23:43:55', 'online', 'G01', 'degree.pdf', NULL, 767777777),
(20032, 'Nisansala', 'Wijeratne', 'nisansala.wijeratne@example.lk', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 921234567, '1990-08-22', 135, 'nisansala.jpg', 'set', '2025-02-11', 1, '2025-02-24 23:43:55', 'offline', 'G06', 'masters.pdf', NULL, NULL),
(20033, 'Asela', 'Rathnayaka', 'asela.rathnayaka@example.lk', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 923456789, '1982-12-05', 220, 'asela.jpg', 'set', '2025-02-12', 1, '2025-02-24 23:43:55', 'online', 'G06', 'phd.pdf', NULL, NULL),
(20034, 'Chamodi', 'Fernando', 'chamodi.fernando@example.lk', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 924567890, '1991-02-20', 4370, 'chamodi.jpg', 'set', '2025-02-13', 1, '2025-02-24 23:43:55', 'offline', 'G04', 'bachelor.pdf', NULL, 767873445),
(20035, 'Dilan', 'Peris', 'dilan.peris@example.lk', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 925678901, '1988-07-14', 310, 'dilan.jpg', 'set', '2025-02-14', 1, '2025-02-24 23:43:55', 'offline', 'G05', 'degree.pdf', NULL, NULL),
(20036, 'Madhuka', 'Senarath', 'madhuka.senarath@example.lk', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 926789012, '1993-02-19', 6160, 'madhuka.jpg', 'set', '2025-02-15', 1, '2025-02-24 23:43:55', 'online', 'G01', 'bachelor.pdf', NULL, NULL),
(20037, 'Amali', 'Karunaratne', 'amali.karunaratne@example.lk', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 927890123, '1986-06-08', 210, 'amali.jpg', 'unset', '2025-02-16', 1, '2025-02-24 23:43:55', 'offline', 'G02', 'degree.pdf', NULL, NULL),
(20038, 'Nuwan', 'Samarasekara', 'nuwan.samarasekara@example.lk', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 928901234, '1990-11-25', 135, 'nuwan.jpg', 'set', '2025-02-17', 1, '2025-02-24 23:43:55', 'online', 'G03', 'masters.pdf', NULL, NULL),
(20039, 'Pradeep', 'Jayawardena', 'pradeep.jayawardena@example.lk', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 929012345, '1984-09-30', 4430, 'pradeep.jpg', 'set', '2025-02-18', 1, '2025-02-24 23:43:55', 'offline', 'G04', 'phd.pdf', NULL, NULL),
(20040, 'Sulochana', 'Peiris', 'sulochana.peiris@example.lk', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 930123456, '1992-01-11', 175, '1745582134_il_1080xN.4426095458_sd2f.jpg', 'set', '2025-02-19', 1, '2025-02-24 23:43:55', 'online', 'G06', 'bachelor.pdf', NULL, 767873445),
(20043, 'Sanduni', 'Gamage', 'sandunig@gmail.com', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 1234567891, '2025-04-16', NULL, NULL, 'set', '2025-04-17', 0, NULL, 'offline', NULL, 'L3.pdf', NULL, 1234567890),
(20044, 'Linara', 'Herath', 'linarah@gmail.com', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 1234567891, '2025-04-17', NULL, NULL, 'unset', '2025-04-17', 0, NULL, 'offline', NULL, 'L1.pdf', NULL, 1234567890),
(20045, 'Manithi', 'Lokuge', 'manithil@gmail.com', '$2y$10$dncfjNpXbPFIZIMcU.SHVugDBiP1mTcXM7mlk/fOz0UWLhA3byu9i', 1234567891, '2025-04-09', NULL, NULL, 'set', '2025-04-18', 0, NULL, 'offline', NULL, 'proof 1.jpg', NULL, 1234567890),
(20046, 'Lahiru', 'Perera', 'lahirup@gmail.com', '$2y$10$OP36t8.1t1sPFPH2SMEPtOfMwYPkOMxaNMVDMbn7bVNw3wjnBsQWa', 2147483647, '2002-03-13', NULL, 'default_tutor.png', 'requested', '2025-04-28', 0, NULL, 'offline', NULL, 'image.jpg', NULL, 767873445),
(20047, 'Sandeep', 'Vaz', 'vazsandeep@gmail.com', '$2y$10$zSsKW2pE2j69EdRd0LYhDuuerK1gCRcvOvegnXK4pI9NUKqFt2Fcq', 2147483647, '2002-03-13', NULL, 'default_tutor.png', 'requested', '2025-04-28', 0, NULL, 'offline', 'G06', 'image.jpg', NULL, 767777777),
(20048, 'Lalith', 'Hewage', 'lalithh@gmail.com', '$2y$10$nYNfOMcrfUiXSq0HizkX4ebaXhCLKd36PYuZOKgkaG3FNubX6nPg6', 2147483647, '2000-01-04', NULL, 'default_tutor.png', 'requested', '2025-04-29', 0, NULL, 'offline', 'G06', 'New e-guru ERD.drawio.png', NULL, 767777777);

-- --------------------------------------------------------

--
-- Table structure for table `tutor_advertisement`
--

CREATE TABLE `tutor_advertisement` (
  `ad_id` int(11) NOT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `ad_display_pic` varchar(255) DEFAULT NULL,
  `ad_description` text DEFAULT NULL,
  `ad_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ad_status` varchar(15) NOT NULL DEFAULT 'set'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_advertisement`
--

INSERT INTO `tutor_advertisement` (`ad_id`, `tutor_id`, `ad_display_pic`, `ad_description`, `ad_created_at`, `ad_status`) VALUES
(7, 20021, 'ad_4.jpg', 'O/L Mathematics classes with a focus on problem-solving techniques.', '2024-01-09 18:30:00', 'unset'),
(8, 20021, 'ad_2.jpeg', 'Master Algebra with step-by-step explanations and past paper discussions.', '2024-02-04 18:30:00', 'unset'),
(9, 20021, 'ad_4.jpg', 'Science lessons for O/L students covering Physics, Chemistry, and Biology.', '2024-01-14 18:30:00', 'unset'),
(10, 20022, 'ad_5.jpg', 'A/L Chemistry coaching with practical demonstrations and past papers.', '2024-03-09 18:30:00', 'set'),
(11, 20023, 'ad_1.jpeg', 'Physics A/L classes with in-depth explanations of theories and calculations.', '2024-02-24 18:30:00', 'unset'),
(12, 20023, 'ad_2.jpeg', 'Pure and Applied Mathematics coaching for A/L students.', '2024-03-31 18:30:00', 'unset'),
(13, 20024, 'ad_1.jpeg', 'English Literature discussions with novel and poem analysis.', '2024-04-19 18:30:00', 'set'),
(14, 20021, 'ad_2.jpeg', 'Improve your English writing, speaking, and grammar for O/L exams.', '2024-05-04 18:30:00', 'unset'),
(15, 20021, 'ad_1.jpeg', 'Biology lessons covering both theory and practical for A/L students.', '2024-03-14 18:30:00', 'unset'),
(16, 20025, 'ad_3.jpeg', 'Interactive Science lessons with experiments and real-life applications.', '2024-04-09 18:30:00', 'set'),
(17, 20021, 'ad_5.jpg', 'ICT classes for O/L students covering databases, programming, and networking.', '2024-04-30 18:30:00', 'unset'),
(18, 20031, 'ad_2.jpeg', 'Computer Science coaching including Python, Java, and Web Development.', '2024-05-14 18:30:00', 'set'),
(19, 20032, 'ad_1.jpeg', 'Business Studies coaching for O/L and A/L students.', '2024-05-31 18:30:00', 'set'),
(20, 20032, 'ad_2.jpeg', 'Accounting lessons covering financial statements and cost analysis.', '2024-06-19 18:30:00', 'unset'),
(21, 20033, 'ad_1.jpeg', 'A/L Economics classes focusing on real-world applications.', '2024-07-04 18:30:00', 'set'),
(22, 20033, 'ad_1.jpeg', 'History O/L coaching with structured study plans and model papers.', '2024-07-17 18:30:00', 'unset'),
(23, 20034, 'ad_3.jpeg', 'Geography lessons covering map reading, climate, and landforms.', '2024-08-09 18:30:00', 'set'),
(24, 20034, 'ad_1.jpeg', 'O/L Mathematics paper discussion and exam techniques.', '2024-08-24 18:30:00', 'unset'),
(25, 20035, 'ad_2.jpeg', 'Sinhala language training focusing on essay writing and comprehension.', '2024-09-04 18:30:00', 'set'),
(26, 20035, 'ad_5.jpg', 'Advanced ICT lessons covering cybersecurity and AI basics.', '2024-09-14 18:30:00', 'set'),
(27, 20036, 'ad_2.jpeg', 'One-on-one Physics coaching for A/L students.', '2024-09-29 18:30:00', 'set'),
(28, 20036, 'ad_1.jpeg', 'Special A/L Chemistry practical session training.', '2024-10-04 18:30:00', 'unset'),
(29, 20037, 'ad_4.jpg', 'A/L Biology deep dive with genetics and cellular biology focus.', '2024-10-19 18:30:00', 'set'),
(30, 20037, 'ad_1.jpeg', 'Science lessons for middle school students with fun experiments.', '2024-10-31 18:30:00', 'unset'),
(31, 20038, 'ad_3.jpeg', 'Fast-track A/L Economics revision course.', '2024-11-09 18:30:00', 'set'),
(32, 20038, 'ad_1.jpeg', 'Business management concepts explained with case studies.', '2024-11-24 18:30:00', 'set'),
(33, 20021, 'ad_5.jpg', 'Accounting coaching with focus on financial reporting.', '2024-12-04 18:30:00', 'set'),
(34, 20040, 'ad_4.jpg', 'History lessons with interactive storytelling and visuals.', '2024-12-14 18:30:00', 'set'),
(35, 20040, 'ad_1.jpeg', 'Geography for beginners covering Sri Lankan and world geography.', '2024-12-19 18:30:00', 'set'),
(41, 20021, 'ad_4.jpg', 'economics for practical use', '2025-03-12 04:12:27', 'set'),
(42, 20021, 'ad_tuition.jpg', 'new ad', '2025-04-17 05:58:28', 'unset'),
(43, 20021, 'ad_tuition.jpg', 'new ad 2', '2025-04-17 06:05:30', 'unset'),
(44, 20021, 'ad_tuition.jpg', 'new ad 3', '2025-04-17 06:11:18', 'unset'),
(45, 20021, 'ad_tuition.jpg', 'new ad 4', '2025-04-17 06:22:41', 'unset'),
(46, 20021, 'ad_new.jpg', 'my ad', '2025-04-17 16:41:08', 'unset'),
(47, 20021, 'ad.jpg', 'new', '2025-04-17 16:45:08', 'unset'),
(48, 20021, 'ad.jpg', 'Join Nowwwww!', '2025-04-17 16:46:30', 'set'),
(49, 20021, 'advertisement.jpg', 'Mathematics online join now!!!!1', '2025-04-18 14:22:15', 'unset'),
(50, 20021, 'ad_new.jpg', 'my ad', '2025-04-19 19:15:38', 'unset'),
(51, 20021, 'ad.jpg', 'test ad', '2025-04-20 19:53:09', 'unset'),
(52, 20021, 'ad_tuition.jpg', 'new test 2', '2025-04-20 19:55:01', 'unset'),
(53, 20021, '1745674873_astronaut-playing-guitar-moon_889227-14583.avif', 'New Ad', '2025-04-26 13:41:13', 'unset'),
(54, 20021, '1745853786_advertisement.jpg', 'Join Nowwwww!!!1', '2025-04-28 15:23:06', 'set'),
(55, 20021, 'ad ex 1.jpg', 'new  updated ad', '2025-04-29 03:55:53', 'unset'),
(56, 20021, 'ad ex 2.png', 'ad', '2025-04-29 06:00:38', 'set');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_availability`
--

CREATE TABLE `tutor_availability` (
  `tutor_id` int(11) NOT NULL,
  `time_slot_id` int(11) NOT NULL,
  `day` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_availability`
--

INSERT INTO `tutor_availability` (`tutor_id`, `time_slot_id`, `day`) VALUES
(20021, 1, 'Monday'),
(20021, 2, 'Monday'),
(20021, 3, 'Monday'),
(20021, 3, 'Thursday'),
(20021, 3, 'Wednesday'),
(20021, 4, 'Friday'),
(20021, 4, 'Monday'),
(20021, 5, 'Friday'),
(20021, 5, 'Monday'),
(20021, 6, 'Monday'),
(20021, 7, 'Monday'),
(20021, 8, 'Monday'),
(20021, 8, 'Tuesday'),
(20021, 9, 'Friday'),
(20021, 9, 'Monday'),
(20021, 9, 'Sunday'),
(20021, 10, 'Monday'),
(20021, 10, 'Sunday'),
(20021, 11, 'Monday'),
(20021, 11, 'Saturday'),
(20021, 11, 'Sunday'),
(20021, 11, 'Tuesday'),
(20021, 11, 'Wednesday'),
(20021, 16, 'Friday'),
(20021, 16, 'Monday'),
(20021, 16, 'Saturday'),
(20021, 16, 'Sunday'),
(20021, 16, 'Tuesday'),
(20021, 16, 'Wednesday'),
(20021, 17, 'Friday'),
(20021, 17, 'Monday'),
(20021, 17, 'Saturday'),
(20021, 17, 'Sunday'),
(20021, 17, 'Thursday'),
(20021, 17, 'Tuesday'),
(20021, 17, 'Wednesday'),
(20021, 18, 'Friday'),
(20021, 18, 'Monday'),
(20021, 18, 'Saturday'),
(20021, 18, 'Sunday'),
(20021, 18, 'Tuesday'),
(20021, 18, 'Wednesday'),
(20022, 2, 'Tuesday'),
(20022, 3, 'Wednesday'),
(20022, 4, 'Thursday'),
(20022, 6, 'Friday'),
(20023, 1, 'Monday'),
(20023, 3, 'Wednesday'),
(20023, 4, 'Thursday'),
(20023, 5, 'Friday'),
(20024, 2, 'Monday'),
(20024, 4, 'Thursday'),
(20024, 5, 'Friday'),
(20024, 6, 'Saturday'),
(20025, 5, 'Friday'),
(20025, 6, 'Saturday'),
(20025, 7, 'Sunday'),
(20025, 9, 'Monday'),
(20031, 6, 'Saturday'),
(20031, 7, 'Sunday'),
(20032, 1, 'Monday'),
(20032, 7, 'Sunday'),
(20033, 1, 'Monday'),
(20033, 2, 'Tuesday'),
(20034, 2, 'Tuesday'),
(20034, 3, 'Wednesday'),
(20035, 3, 'Wednesday'),
(20035, 4, 'Thursday'),
(20035, 16, 'Wednesday'),
(20036, 4, 'Thursday'),
(20036, 5, 'Friday'),
(20037, 5, 'Friday'),
(20037, 6, 'Saturday'),
(20038, 6, 'Saturday'),
(20038, 7, 'Sunday'),
(20039, 1, 'Monday'),
(20039, 7, 'Sunday'),
(20040, 1, 'Monday'),
(20040, 2, 'Tuesday');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_grades`
--

CREATE TABLE `tutor_grades` (
  `tutor_id` int(11) NOT NULL,
  `grade` enum('6','7','8','9','10','11') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_grades`
--

INSERT INTO `tutor_grades` (`tutor_id`, `grade`) VALUES
(20021, '6'),
(20021, '9'),
(20021, '10'),
(20021, '11'),
(20022, '6'),
(20022, '8'),
(20022, '9'),
(20023, '6'),
(20023, '10'),
(20023, '11'),
(20024, '6'),
(20024, '7'),
(20024, '8'),
(20025, '9'),
(20025, '10'),
(20025, '11'),
(20031, '6'),
(20031, '7'),
(20031, '8'),
(20031, '9'),
(20032, '6'),
(20032, '10'),
(20032, '11'),
(20033, '6'),
(20033, '7'),
(20034, '6'),
(20034, '8'),
(20034, '9'),
(20035, '10'),
(20035, '11'),
(20036, '6'),
(20036, '7'),
(20036, '8'),
(20036, '9'),
(20036, '10'),
(20036, '11');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_inbox`
--

CREATE TABLE `tutor_inbox` (
  `inbox_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `sender_type` enum('admin','student') NOT NULL,
  `sender_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('unread','read','archived') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_inbox`
--

INSERT INTO `tutor_inbox` (`inbox_id`, `tutor_id`, `sender_type`, `sender_id`, `subject`, `message`, `sent_at`, `status`) VALUES
(1, 20021, 'admin', 1, 'Welcome to eGuru Teaching Team', 'We are delighted to have you join our platform as a tutor. Please review the tutor guidelines.', '2025-04-01 04:00:00', 'archived'),
(2, 20022, 'student', 10002, 'Question about yesterday\'s class', 'I couldn\'t understand the concept you explained at the end of the class. Could you please clarify?', '2025-04-02 08:30:00', 'unread'),
(3, 20023, 'admin', 1, 'Schedule Confirmation', 'Your teaching schedule for next week has been confirmed.', '2025-04-03 04:45:00', 'read'),
(4, 20024, 'student', 10004, 'Extra help needed', 'I am struggling with the latest chapter. Can we arrange an extra session?', '2025-04-04 10:15:00', 'unread'),
(5, 20025, 'admin', 1, 'Payment Processed', 'Your payment for the previous month\'s sessions has been processed.', '2025-04-05 06:00:00', 'read'),
(6, 20031, 'student', 10011, 'Study materials request', 'Could you please provide additional study materials for the upcoming test?', '2025-04-06 07:30:00', 'unread'),
(7, 20032, 'admin', 1, 'New Feature Announcement', 'We have added a new whiteboard feature to enhance your teaching experience.', '2025-04-07 04:15:00', 'read'),
(8, 20033, 'student', 10013, 'Session recording issue', 'I can\'t access the recording of our last session. Could you please help?', '2025-04-08 10:50:00', 'unread'),
(9, 20034, 'admin', 1, 'Teaching Excellence Award', 'Congratulations! You have been nominated for our Teaching Excellence Award.', '2025-04-09 05:00:00', 'read'),
(10, 20035, 'student', 10015, 'Homework clarification', 'I\'m not sure I understood the homework assignment correctly. Could you provide more details?', '2025-04-10 09:20:00', 'unread'),
(11, 20036, 'admin', 1, 'Workshop Invitation', 'You are invited to participate in our upcoming teaching methods workshop.', '2025-04-11 03:45:00', 'read'),
(12, 20037, 'student', 10017, 'Missed class', 'I missed yesterday\'s class due to illness. Could you please share what I missed?', '2025-04-12 08:10:00', 'unread'),
(13, 20038, 'admin', 1, 'Profile Update Required', 'Please update your qualification information in your profile.', '2025-04-13 04:30:00', 'read'),
(14, 20039, 'student', 10019, 'Exam preparation', 'Can you suggest some additional resources for exam preparation?', '2025-04-14 10:00:00', 'unread'),
(15, 20040, 'admin', 1, 'Feedback on Your Sessions', 'You have received excellent feedback from your students this month.', '2025-04-15 05:40:00', 'read'),
(16, 20043, 'student', 10001, 'Help with mathematics problem', 'I\'m struggling with the calculus problems you assigned last week. Could we go through them again?', '2025-04-16 08:55:00', 'unread'),
(17, 20044, 'admin', 1, 'Course Material Update', 'Please update your course materials according to the new syllabus by next week.', '2025-04-17 04:20:00', 'read'),
(18, 20045, 'student', 10003, 'Session cancellation request', 'I need to cancel our session scheduled for tomorrow due to a family emergency.', '2025-04-18 07:45:00', 'unread'),
(19, 20037, 'admin', 2, 'Test1', 'test', '2025-04-21 07:50:16', 'unread'),
(20, 20037, 'admin', 2, 'test', 'test', '2025-04-21 07:50:39', 'unread'),
(21, 20021, 'admin', 1, 'Congratulations on your first successful session!', 'test1', '2025-04-22 08:15:14', 'unread'),
(22, 20021, 'student', 10021, 'Please accept my session  request', 'Sir i had the pleasure to have a session with you and it was amazing. Please accept my new request', '2025-04-28 19:14:40', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_inbox_reply`
--

CREATE TABLE `tutor_inbox_reply` (
  `id` int(11) NOT NULL,
  `inbox_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sender_type` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_inbox_reply`
--

INSERT INTO `tutor_inbox_reply` (`id`, `inbox_id`, `message`, `sender_type`, `created_at`) VALUES
(1, 1, 'Can you confirm if you received the lesson plan?', 'tutor', '2025-04-20 09:30:00'),
(2, 1, 'Yes, I received it. Thank you!', 'admin', '2025-04-20 09:35:00'),
(3, 2, 'A student asked for an extension on their project.', 'tutor', '2025-04-20 10:00:00'),
(4, 2, 'Let me know the details and I’ll approve it if needed.', 'admin', '2025-04-20 00:00:00'),
(5, 1, 'Can you confirm if you received the lesson plan?', 'tutor', '2025-04-20 09:30:00'),
(6, 1, 'Yes, I received it. Thank you!', 'admin', '2025-04-20 09:35:00'),
(7, 1, 'Great, please share your feedback once reviewed.', 'tutor', '2025-04-20 09:40:00'),
(8, 2, 'A student asked for an extension on their project.', 'tutor', '2025-04-20 10:00:00'),
(9, 2, 'Let me know the details and I’ll approve it if needed.', 'admin', '2025-04-20 10:10:00'),
(10, 2, 'They requested 2 more days due to illness.', 'tutor', '2025-04-20 10:15:00'),
(11, 2, 'Approved. Please update their portal status accordingly.', 'admin', '2025-04-20 10:20:00'),
(12, 3, 'Could you recheck my session feedback? I think there’s a mistake.', 'tutor', '2025-04-21 08:40:00'),
(13, 3, 'Sure, I’ll look into it and get back to you.', 'admin', '2025-04-21 08:50:00'),
(14, 3, 'Thanks. It’s showing 2 stars instead of 5.', 'tutor', '2025-04-21 08:55:00'),
(15, 4, 'Can we move tomorrow’s class to the afternoon?', 'tutor', '2025-04-21 10:20:00'),
(16, 4, 'Afternoon is fine. I’ll update the schedule.', 'admin', '2025-04-21 10:25:00'),
(17, 4, 'Thanks. I’ll notify the student as well.', 'tutor', '2025-04-21 10:30:00'),
(18, 5, 'I haven’t received my payment for last month.', 'tutor', '2025-04-21 11:05:00'),
(19, 5, 'Thanks for the heads-up. Finance will check and get back shortly.', 'admin', '2025-04-21 11:15:00'),
(20, 5, 'Please let me know once it’s resolved.', 'tutor', '2025-04-21 11:25:00'),
(21, 5, 'Payment has been processed today. Expect clearance in 2 days.', 'admin', '2025-04-21 11:40:00');

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
('G01', 'Diamond', 'Degree Holding School Teachers', 1000, '#b3ffb366'),
('G02', 'Platinum', 'Junior Teachers, Training Teachers', 900, '#ffff8066'),
('G03', 'Gold', 'Experienced Undergraduate, Trainee Teachers', 800, '#B0E0E666'),
('G04', 'Silver', 'Undergraduates', 700, '#FAF9F6'),
('G05', 'Bronze+', 'Diploma Holders', 600, '#FAF9F6'),
('G06', 'Bronze', 'Post AL Students / Other', 500, '#FAF9F6');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_level_upgrade`
--

CREATE TABLE `tutor_level_upgrade` (
  `request_id` int(11) NOT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `request_date` date NOT NULL,
  `status` enum('accepted','rejected','pending','cancelled') DEFAULT 'pending',
  `status_updated_date` date DEFAULT NULL,
  `request_body` text DEFAULT NULL,
  `current_level_id` varchar(50) DEFAULT NULL,
  `requested_level_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_level_upgrade`
--

INSERT INTO `tutor_level_upgrade` (`request_id`, `tutor_id`, `request_date`, `status`, `status_updated_date`, `request_body`, `current_level_id`, `requested_level_id`) VALUES
(1, 20021, '2024-07-01', 'accepted', '2025-04-21', NULL, NULL, NULL),
(2, 20021, '2024-07-02', 'accepted', '2024-07-05', 'nothing', 'G06', 'G05'),
(3, 20021, '2024-07-03', 'rejected', '2024-07-06', 'nah', 'G06', 'G01'),
(4, 20024, '2024-07-04', 'rejected', '2025-04-21', NULL, NULL, NULL),
(5, 20025, '2024-07-05', 'accepted', '2024-07-07', NULL, NULL, NULL),
(6, 20031, '2024-07-06', 'rejected', '2024-07-08', NULL, NULL, NULL),
(7, 20032, '2024-07-07', 'pending', NULL, NULL, 'G02', 'G01'),
(8, 20021, '2024-07-08', 'accepted', '2024-07-09', 'yah', 'G06', 'G03'),
(9, 20034, '2024-07-09', 'pending', NULL, NULL, 'G06', 'G05'),
(11, 20021, '2025-04-19', 'cancelled', '2025-04-19', 'no reason', 'G06', 'G04'),
(12, 20021, '2025-04-19', 'cancelled', '2025-04-19', 'my reason', 'G06', 'G02'),
(13, 20021, '2025-04-19', 'cancelled', '2025-04-19', 'come on', 'G06', 'G04'),
(17, 20021, '2025-04-21', 'cancelled', '2025-04-21', 'test 1', 'G04', 'G05'),
(18, 20021, '2025-04-21', 'rejected', '2025-04-21', 'message', 'G04', 'G02'),
(19, 20021, '2025-04-21', 'cancelled', '2025-04-21', 'new req', 'G04', 'G01'),
(20, 20021, '2025-04-21', 'cancelled', '2025-04-21', 'my', 'G04', 'G01'),
(21, 20021, '2025-04-21', 'cancelled', '2025-04-21', 'my new request', 'G04', 'G01'),
(22, 20021, '2025-04-21', 'accepted', '2025-04-21', 'new', 'G04', 'G03'),
(23, 20021, '2025-04-21', 'accepted', '2025-04-21', 'my new req', 'G04', 'G02'),
(24, 20021, '2025-04-21', 'cancelled', '2025-04-21', 'test2', 'G04', 'G04'),
(25, 20021, '2025-04-21', 'cancelled', '2025-04-21', 'test 3', 'G04', 'G01'),
(26, 20021, '2025-04-21', 'cancelled', '2025-04-21', 'test 4', 'G04', 'G04'),
(27, 20021, '2025-04-21', 'cancelled', '2025-04-21', 'test 5', 'G04', 'G01'),
(28, 20021, '2025-04-21', 'accepted', '2025-04-21', 'test 6', 'G04', 'G02'),
(29, 20021, '2025-04-21', 'rejected', '2025-04-21', 'test 7', 'G04', 'G01'),
(30, 20046, '2025-04-28', 'pending', NULL, 'Newly joined', 'G04', 'G03'),
(31, 20021, '2025-04-28', 'pending', NULL, 'I have been diligently teaching on this platform for more than 2 years. Please accept my request', 'G03', 'G02'),
(32, 20021, '2025-04-28', 'pending', NULL, 'I have finished my doctorate and have been teaching on this platform for 6 months. I believe i deserve this upgrade. I hope for your understanding. Thank you!', 'G03', 'G02'),
(33, 20021, '2025-04-29', 'cancelled', '2025-04-29', 'i have worked for 6 months', 'G03', 'G02'),
(34, 20021, '2025-04-29', 'accepted', '2025-04-29', 'i have worked for 5 months', 'G03', 'G01');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_point_cashout`
--

CREATE TABLE `tutor_point_cashout` (
  `cashout_id` int(11) NOT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `point_amount` int(11) DEFAULT NULL,
  `cash_value` int(11) DEFAULT NULL,
  `bank_transaction_id` varchar(255) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `transaction_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_point_cashout`
--

INSERT INTO `tutor_point_cashout` (`cashout_id`, `tutor_id`, `point_amount`, `cash_value`, `bank_transaction_id`, `transaction_date`, `transaction_time`) VALUES
(21, 20021, 150, 1500, 'TXN20021A', '2024-04-25', '12:28:09'),
(22, 20022, 220, 2200, 'TXN20022B', '2024-05-12', '12:28:09'),
(23, 20023, 300, 3000, 'TXN20023C', '2024-06-03', '12:28:09'),
(24, 20024, 110, 1100, 'TXN20024D', '2024-06-28', '12:28:09'),
(25, 20025, 190, 1900, 'TXN20025E', '2024-07-15', '12:28:09'),
(26, 20031, 400, 4000, 'TXN20031F', '2024-08-02', '12:28:09'),
(27, 20032, 180, 1800, 'TXN20032G', '2024-08-19', '12:28:09'),
(28, 20033, 240, 2400, 'TXN20033H', '2024-09-07', '12:28:09'),
(29, 20034, 130, 1300, 'TXN20034I', '2024-09-25', '12:28:09'),
(30, 20035, 360, 3600, 'TXN20035J', '2024-10-12', '12:28:09'),
(31, 20036, 100, 1000, 'TXN20036K', '2024-10-30', '12:28:09'),
(32, 20037, 270, 2700, 'TXN20037L', '2024-11-17', '12:28:09'),
(33, 20038, 310, 3100, 'TXN20038M', '2024-12-04', '12:28:09'),
(34, 20039, 140, 1400, 'TXN20039N', '2024-12-22', '12:28:09'),
(35, 20040, 330, 3300, 'TXN20040O', '2025-01-09', '12:28:09'),
(36, 20043, 120, 1200, 'TXN20043R', '2025-01-27', '12:28:09'),
(37, 20044, 290, 2900, 'TXN20044S', '2025-02-14', '12:28:09'),
(38, 20045, 250, 2500, 'TXN20045T', '2025-03-05', '12:28:09'),
(39, 20021, 180, 1800, 'TXN20021U', '2025-03-22', '00:01:32'),
(40, 20022, 135, 1350, 'TXN20022V', '2025-04-01', '00:01:32'),
(41, 20023, 210, 2100, 'TXN20023W', '2025-04-10', '00:01:32'),
(42, 20024, 160, 1600, 'TXN20024X', '2025-04-18', '00:01:32'),
(43, 20025, 225, 2250, 'TXN20025Y', '2024-05-05', '00:01:32'),
(44, 20031, 195, 1950, 'TXN20031Z', '2024-05-20', '00:01:32'),
(45, 20032, 280, 2800, 'TXN20032AA', '2024-06-15', '00:01:32'),
(46, 20033, 150, 1500, 'TXN20033AB', '2024-07-02', '00:01:32'),
(47, 20034, 320, 3200, 'TXN20034AC', '2024-07-25', '00:01:32'),
(48, 20035, 175, 1750, 'TXN20035AD', '2024-08-10', '00:01:32'),
(49, 20036, 230, 2300, 'TXN20036AE', '2024-08-28', '00:01:32'),
(50, 20037, 145, 1450, 'TXN20037AF', '2024-09-15', '00:01:32'),
(51, 20038, 265, 2650, 'TXN20038AG', '2024-10-05', '00:01:32'),
(52, 20039, 190, 1900, 'TXN20039AH', '2024-10-22', '00:01:32'),
(53, 20040, 170, 1700, 'TXN20040AI', '2024-11-08', '00:01:32'),
(54, 20043, 310, 3100, 'TXN20043AJ', '2024-11-26', '00:01:32'),
(55, 20044, 155, 1550, 'TXN20044AK', '2024-12-14', '00:01:32'),
(56, 20045, 285, 2850, 'TXN20045AL', '2025-01-03', '00:01:32'),
(57, 20021, 200, 2000, 'TXN20021AM', '2025-01-19', '00:01:32'),
(58, 20022, 165, 1650, 'TXN20022AN', '2025-02-05', '00:01:32'),
(59, 20023, 245, 2450, 'TXN20023AO', '2025-02-22', '00:01:32'),
(60, 20024, 185, 1850, 'TXN20024AP', '2025-03-10', '00:01:32'),
(61, 20025, 270, 2700, 'TXN20025AQ', '2025-03-27', '00:01:32'),
(62, 20031, 140, 1400, 'TXN20031AR', '2025-04-02', '00:01:32'),
(63, 20032, 0, 2950, 'TXN20032AS', '2025-04-15', '00:01:32'),
(64, 20033, 175, 1750, 'TXN20033AT', '2024-04-28', '00:01:32'),
(65, 20034, 220, 2200, 'TXN20034AU', '2024-05-15', '00:01:32'),
(66, 20035, 260, 2600, 'TXN20035AV', '2024-06-01', '00:01:32'),
(67, 20036, 150, 1500, 'TXN20036AW', '2024-06-18', '00:01:32'),
(68, 20037, 315, 3150, 'TXN20037AX', '2024-07-05', '00:01:32'),
(69, 20038, 185, 1850, 'TXN20038AY', '2024-07-22', '00:01:32'),
(70, 20039, 230, 2300, 'TXN20039AZ', '2024-08-08', '00:01:32'),
(71, 20040, 275, 2750, 'TXN20040BA', '2024-08-25', '00:01:32'),
(72, 20043, 160, 1600, 'TXN20043BB', '2024-09-12', '00:01:32'),
(73, 20044, 205, 2050, 'TXN20044BC', '2024-09-30', '00:01:32'),
(74, 20045, 325, 3250, 'TXN20045BD', '2024-10-17', '00:01:32'),
(75, 20021, 100, 950, 'TXN20021155E311B', NULL, NULL),
(76, 20021, 500, 4750, 'TXN20021497AA2BC', NULL, NULL),
(77, 20021, 200, 1900, 'TXN200217F0F47CB', NULL, NULL),
(78, 20021, 200, 1900, 'TXN20021C7B21AD9', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tutor_profile`
--

CREATE TABLE `tutor_profile` (
  `tutor_id` int(11) NOT NULL,
  `bio` text DEFAULT NULL,
  `specialization` text DEFAULT NULL,
  `education` text DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city_town` varchar(100) DEFAULT NULL,
  `profile_status` varchar(10) DEFAULT 'set'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_profile`
--

INSERT INTO `tutor_profile` (`tutor_id`, `bio`, `specialization`, `education`, `experience`, `country`, `city_town`, `profile_status`) VALUES
(20021, 'ICT instructor focused on practical learning and real-world applications.', 'Information &amp; Communication Technology\r\nMaths and Science', 'B.Sc. in IT, Sri Lanka Institute of Information Technology (SLIIT)', '3 years teaching ICT at international schools', 'Sri Lanka', 'Kandy', 'set'),
(20023, 'English language tutor specializing in spoken and written English for school students.', 'English Language', 'BA in English, University of Kelaniya', '6 years of private tutoring and school teaching', 'Sri Lanka', 'Galle', 'set'),
(20024, 'Physics teacher with a strong background in A/L curriculum and exam preparation.', 'Physics', 'B.Sc. in Physics, University of Peradeniya', '4 years as a tuition center instructor', 'Sri Lanka', 'Matara', 'set'),
(20025, 'Chemistry graduate who enjoys breaking down complex topics into simple explanations.', 'Chemistry', 'B.Sc. in Chemistry, University of Jaffna', '2 years of online and home tutoring', 'Sri Lanka', 'Jaffna', 'set');

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

--
-- Dumping data for table `tutor_report`
--

INSERT INTO `tutor_report` (`report_id`, `tutor_id`, `student_id`, `description`, `issue_type`, `report_time`) VALUES
(1, 20021, 10001, 'Student missed multiple scheduled sessions without prior notice.', 'Missed Class', '2024-01-10 03:00:00'),
(2, 20021, 10012, 'Disruptive behavior during class, causing distractions for other students.', 'Misconduct', '2024-02-15 05:15:00'),
(3, 20022, 10002, 'Payment for a completed session is still pending.', 'Payment Issue', '2024-03-05 09:50:00'),
(4, 20022, 10013, 'Student was unresponsive after scheduling a session.', 'Missed Class', '2024-04-18 08:30:00'),
(5, 20023, 10003, 'Repeated instances of offensive language during the class.', 'Misconduct', '2024-05-22 11:45:00'),
(6, 20023, 10014, 'Student requested a refund after attending the entire session.', 'Payment Issue', '2024-06-02 03:40:00'),
(7, 20024, 10004, 'Technical issues reported by the student, causing disruptions.', 'Technical Issue', '2024-07-08 07:00:00'),
(8, 20024, 10015, 'Student was late for multiple sessions, delaying the schedule.', 'Missed Class', '2024-08-01 11:15:00'),
(9, 20025, 10005, 'Student used inappropriate language in class discussion.', 'Misconduct', '2024-09-10 12:30:00'),
(10, 20025, 10016, 'Connection issues from student’s side, unable to conduct the session.', 'Technical Issue', '2024-10-03 05:30:00'),
(11, 20031, 10011, 'Student logged in but did not respond during the class.', 'Missed Class', '2024-01-20 08:10:00'),
(12, 20031, 10017, 'Technical issue with student’s microphone; unable to communicate.', 'Technical Issue', '2024-02-25 03:50:00'),
(13, 20032, 10012, 'Payment for the last session is still not received.', 'Payment Issue', '2024-03-14 10:25:00'),
(14, 20032, 10018, 'Student was caught copying answers during an online test.', 'Misconduct', '2024-04-09 12:00:00'),
(15, 20033, 10013, 'Missed multiple sessions without notice.', 'Missed Class', '2024-05-19 04:40:00'),
(16, 20033, 10019, 'Student’s camera was off the entire session, ignoring instructions.', 'Misconduct', '2024-06-22 03:20:00'),
(17, 20034, 10014, 'Student attended class using a fake account.', 'Misconduct', '2024-07-15 06:30:00'),
(18, 20034, 10020, 'Request for refund due to dissatisfaction with session quality.', 'Payment Issue', '2024-08-10 10:50:00'),
(19, 20035, 10015, 'Frequent disconnections during class due to poor internet.', 'Technical Issue', '2024-09-25 09:00:00'),
(20, 20035, 10011, 'Student was disrespectful towards the tutor.', 'Misconduct', '2024-10-05 13:45:00'),
(21, 20036, 10016, 'Session started late due to student joining late.', 'Missed Class', '2024-11-07 02:15:00'),
(22, 20036, 10012, 'Technical issues prevented the student from hearing the tutor.', 'Technical Issue', '2024-12-01 04:35:00'),
(23, 20037, 10017, 'Student claimed session was not helpful and requested a refund.', 'Payment Issue', '2024-12-12 05:50:00'),
(24, 20037, 10018, 'Student was playing games during the session.', 'Misconduct', '2024-01-03 09:10:00'),
(25, 20038, 10019, 'Student did not complete assigned homework multiple times.', 'Misconduct', '2024-02-10 07:40:00'),
(26, 20038, 10020, 'Poor internet connection caused multiple disruptions.', 'Technical Issue', '2024-03-18 10:30:00'),
(27, 20039, 10011, 'Student joined session but was completely silent throughout.', 'Missed Class', '2024-04-22 10:15:00'),
(28, 20040, 10015, 'Request for a refund due to session cancellation.', 'Payment Issue', '2024-05-30 04:05:00'),
(29, 20040, 10013, 'Student was rude and refused to cooperate.', 'Misconduct', '2024-06-17 05:20:00'),
(30, 20022, 10021, 'The tutor does not answer questions or help properly', 'Misconduct', '2025-03-04 07:41:40'),
(31, 20033, 10021, 'Video was not clear during the session', 'Technical Issue', '2025-03-06 05:16:52');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_study_material`
--

CREATE TABLE `tutor_study_material` (
  `material_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `material_description` text DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `material_status` varchar(15) NOT NULL DEFAULT 'set',
  `material_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_study_material`
--

INSERT INTO `tutor_study_material` (`material_id`, `subject_id`, `material_description`, `grade`, `tutor_id`, `material_status`, `material_path`) VALUES
(13, 1, 'Comprehensive guide on Algebra for Grade 6 students', 6, 20021, 'unset', NULL),
(14, 2, 'Physics notes on Newton’s Laws of Motion', 7, 20022, 'set', 'L3.pdf'),
(15, 3, 'Essay writing techniques for Grade 8 students', 8, 20023, 'set', 'L3.pdf'),
(16, 4, 'Detailed study on Sri Lankan History', 9, 20024, 'set', 'L3.pdf'),
(17, 5, 'Advanced Trigonometry exercises for Grade 10', 10, 20025, 'set', 'L3.pdf'),
(18, 6, 'Chemical Reactions and Equations - Grade 11', 11, 20031, 'set', 'L3.pdf'),
(19, 7, 'Basic Sinhala Grammar lessons', 6, 20032, 'set', 'L3.pdf'),
(20, 8, 'Introduction to Economics for Grade 7', 7, 20033, 'set', 'L3.pdf'),
(21, 9, 'Geography notes on climate change', 8, 20034, 'set', 'L3.pdf'),
(22, 10, 'Biology workbook on Human Anatomy', 9, 20035, 'set', 'L3.pdf'),
(23, 11, 'English Literature summaries for Grade 10', 10, 20036, 'set', 'L3.pdf'),
(24, 12, 'Mathematical problem-solving techniques', 11, 20037, 'set', 'L3.pdf'),
(25, 1, 'Fun activities for learning fractions', 6, 20038, 'set', 'L3.pdf'),
(26, 2, 'Electricity and Magnetism notes', 7, 20039, 'set', 'L3.pdf'),
(27, 3, 'Creative writing guide for essays', 8, 20040, 'set', 'L3.pdf'),
(28, 4, 'Historical events of Sri Lanka', 9, 20021, 'unset', NULL),
(29, 5, 'Statistics and Probability exercises', 10, 20022, 'set', 'L3.pdf'),
(30, 6, 'Practical experiments for Chemistry', 11, 20023, 'set', 'L3.pdf'),
(31, 7, 'Advanced Sinhala literary analysis', 6, 20024, 'set', 'L3.pdf'),
(32, 8, 'Fundamentals of Business Studies', 7, 20025, 'set', 'L3.pdf'),
(33, 1, 'new lec ', 9, 20021, 'unset', 'L3.pdf'),
(34, 11, 'material 1', 8, 20021, 'unset', 'proof 1.jpg'),
(35, 7, 'material 2', 7, 20021, 'unset', 'Untitled document (11).docx'),
(36, 9, 'my new note', 7, 20021, 'unset', 'L1.pdf'),
(37, 8, 'test img new', 8, 20021, 'unset', 'ad_tuition.jpg'),
(38, 12, 'new pic test', 6, 20021, 'unset', 'wallpic.jpg'),
(39, 1, 'Edexcel\r\n', 9, 20021, 'set', 'Solving-Equations-PQ.pdf'),
(40, 3, 'English Presentation Aadhaar', 8, 20021, 'set', 'India’s Aadhaar System & Its Feasibility in Sri Lanka (1).pdf'),
(41, 9, 'Web Past Paper', 11, 20021, 'set', 'IS 1109.pdf'),
(42, 2, 'Additional lecture - 3', 7, 20021, 'set', 'L3.pdf'),
(43, 9, 'Example class diagram', 6, 20021, 'set', 'classdiagram.drawio.png'),
(44, 9, 'Computer Networks PP', 10, 20021, 'set', 'IS 2111 (1).pdf'),
(45, 9, 'solving equations', 10, 20021, 'set', 'Solving-Equations-PQ (1).pdf'),
(46, 3, 'new diagram', 6, 20021, 'unset', 'proof ex 2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_subject`
--

CREATE TABLE `tutor_subject` (
  `tutor_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_subject`
--

INSERT INTO `tutor_subject` (`tutor_id`, `subject_id`) VALUES
(20021, 1),
(20021, 2),
(20021, 3),
(20021, 8),
(20021, 9),
(20021, 12),
(20022, 1),
(20022, 4),
(20022, 5),
(20022, 6),
(20023, 1),
(20023, 7),
(20023, 8),
(20023, 9),
(20024, 10),
(20024, 11),
(20024, 12),
(20025, 1),
(20025, 6),
(20025, 12),
(20031, 3),
(20031, 7),
(20031, 9),
(20032, 1),
(20032, 2),
(20032, 4),
(20032, 8),
(20033, 1),
(20033, 5),
(20033, 10),
(20033, 11),
(20034, 1),
(20034, 9),
(20034, 12),
(20035, 3),
(20035, 6),
(20035, 7),
(20036, 2),
(20036, 5),
(20036, 8),
(20037, 4),
(20037, 6),
(20037, 11),
(20038, 1),
(20038, 7),
(20038, 10),
(20039, 3),
(20039, 5),
(20039, 9),
(20040, 2),
(20040, 8),
(20040, 12);

-- --------------------------------------------------------

--
-- Table structure for table `visitor_query`
--

CREATE TABLE `visitor_query` (
  `query_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `district` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitor_query`
--

INSERT INTO `visitor_query` (`query_id`, `first_name`, `last_name`, `email`, `district`, `message`, `created_at`) VALUES
(1, 'sai', 'baba', 'sai@gmail.com', 'Colombo', 'om sai ram!!', '2025-03-13 09:59:40'),
(2, 'Anban', 'Shayan', 'anban@gmail.com', 'Colombo', 'Hello there', '2025-03-13 10:05:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `admin_inbox`
--
ALTER TABLE `admin_inbox`
  ADD PRIMARY KEY (`inbox_id`);

--
-- Indexes for table `admin_inbox_reply`
--
ALTER TABLE `admin_inbox_reply`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `inbox_id` (`inbox_id`),
  ADD KEY `admin_username` (`admin_username`);

--
-- Indexes for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`admin_setting_id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announce_id`);

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
  ADD KEY `tutor_id` (`tutor_id`),
  ADD KEY `fk_session_subject_id` (`subject_id`);

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
-- Indexes for table `student_forum`
--
ALTER TABLE `student_forum`
  ADD PRIMARY KEY (`forum_id`);

--
-- Indexes for table `student_inbox`
--
ALTER TABLE `student_inbox`
  ADD PRIMARY KEY (`inbox_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_inbox_reply`
--
ALTER TABLE `student_inbox_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_student_inbox_reply_inbox` (`inbox_id`);

--
-- Indexes for table `student_point_purchase`
--
ALTER TABLE `student_point_purchase`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `student_id` (`student_id`);

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
-- Indexes for table `tutor_grades`
--
ALTER TABLE `tutor_grades`
  ADD PRIMARY KEY (`tutor_id`,`grade`);

--
-- Indexes for table `tutor_inbox`
--
ALTER TABLE `tutor_inbox`
  ADD PRIMARY KEY (`inbox_id`),
  ADD KEY `tutor_id` (`tutor_id`);

--
-- Indexes for table `tutor_inbox_reply`
--
ALTER TABLE `tutor_inbox_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tutor_inbox_reply_inbox` (`inbox_id`);

--
-- Indexes for table `tutor_level`
--
ALTER TABLE `tutor_level`
  ADD PRIMARY KEY (`tutor_level_id`),
  ADD UNIQUE KEY `tutor_level` (`tutor_level`);

--
-- Indexes for table `tutor_level_upgrade`
--
ALTER TABLE `tutor_level_upgrade`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `fk_tutor_level_upgrade_tutor` (`tutor_id`),
  ADD KEY `fk_current_tutor_level__tutor` (`current_level_id`),
  ADD KEY `fk_requested_tutor_level__tutor` (`requested_level_id`);

--
-- Indexes for table `tutor_point_cashout`
--
ALTER TABLE `tutor_point_cashout`
  ADD PRIMARY KEY (`cashout_id`),
  ADD KEY `tutor_id` (`tutor_id`);

--
-- Indexes for table `tutor_profile`
--
ALTER TABLE `tutor_profile`
  ADD PRIMARY KEY (`tutor_id`);

--
-- Indexes for table `tutor_report`
--
ALTER TABLE `tutor_report`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `tutor_id` (`tutor_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `tutor_study_material`
--
ALTER TABLE `tutor_study_material`
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
-- Indexes for table `visitor_query`
--
ALTER TABLE `visitor_query`
  ADD PRIMARY KEY (`query_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_inbox`
--
ALTER TABLE `admin_inbox`
  MODIFY `inbox_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `admin_inbox_reply`
--
ALTER TABLE `admin_inbox_reply`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `admin_settings`
--
ALTER TABLE `admin_settings`
  MODIFY `admin_setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announce_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `forum_reply`
--
ALTER TABLE `forum_reply`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40137;

--
-- AUTO_INCREMENT for table `session_feedback`
--
ALTER TABLE `session_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `session_payment`
--
ALTER TABLE `session_payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10029;

--
-- AUTO_INCREMENT for table `student_forum`
--
ALTER TABLE `student_forum`
  MODIFY `forum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student_inbox`
--
ALTER TABLE `student_inbox`
  MODIFY `inbox_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `student_inbox_reply`
--
ALTER TABLE `student_inbox_reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `student_point_purchase`
--
ALTER TABLE `student_point_purchase`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30002;

--
-- AUTO_INCREMENT for table `time_slot`
--
ALTER TABLE `time_slot`
  MODIFY `time_slot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tutor`
--
ALTER TABLE `tutor`
  MODIFY `tutor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20049;

--
-- AUTO_INCREMENT for table `tutor_advertisement`
--
ALTER TABLE `tutor_advertisement`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `tutor_inbox`
--
ALTER TABLE `tutor_inbox`
  MODIFY `inbox_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tutor_inbox_reply`
--
ALTER TABLE `tutor_inbox_reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tutor_level_upgrade`
--
ALTER TABLE `tutor_level_upgrade`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tutor_point_cashout`
--
ALTER TABLE `tutor_point_cashout`
  MODIFY `cashout_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `tutor_report`
--
ALTER TABLE `tutor_report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tutor_study_material`
--
ALTER TABLE `tutor_study_material`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `visitor_query`
--
ALTER TABLE `visitor_query`
  MODIFY `query_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_inbox_reply`
--
ALTER TABLE `admin_inbox_reply`
  ADD CONSTRAINT `admin_inbox_reply_ibfk_1` FOREIGN KEY (`inbox_id`) REFERENCES `admin_inbox` (`inbox_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_inbox_reply_ibfk_2` FOREIGN KEY (`admin_username`) REFERENCES `admin` (`username`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `fk_session_subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE CASCADE,
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
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `student_availability_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `student_availability_ibfk_2` FOREIGN KEY (`time_slot_id`) REFERENCES `time_slot` (`time_slot_id`);

--
-- Constraints for table `student_inbox`
--
ALTER TABLE `student_inbox`
  ADD CONSTRAINT `student_inbox_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_inbox_reply`
--
ALTER TABLE `student_inbox_reply`
  ADD CONSTRAINT `fk_student_inbox_reply_inbox` FOREIGN KEY (`inbox_id`) REFERENCES `student_inbox` (`inbox_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_point_purchase`
--
ALTER TABLE `student_point_purchase`
  ADD CONSTRAINT `student_point_purchase_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

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
-- Constraints for table `tutor_grades`
--
ALTER TABLE `tutor_grades`
  ADD CONSTRAINT `tutor_grades_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`tutor_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tutor_inbox`
--
ALTER TABLE `tutor_inbox`
  ADD CONSTRAINT `tutor_inbox_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`tutor_id`) ON DELETE CASCADE;

--
-- Constraints for table `tutor_inbox_reply`
--
ALTER TABLE `tutor_inbox_reply`
  ADD CONSTRAINT `fk_tutor_inbox_reply_inbox` FOREIGN KEY (`inbox_id`) REFERENCES `tutor_inbox` (`inbox_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tutor_level_upgrade`
--
ALTER TABLE `tutor_level_upgrade`
  ADD CONSTRAINT `fk_current_tutor_level__tutor` FOREIGN KEY (`current_level_id`) REFERENCES `tutor_level` (`tutor_level_id`),
  ADD CONSTRAINT `fk_requested_tutor_level__tutor` FOREIGN KEY (`requested_level_id`) REFERENCES `tutor_level` (`tutor_level_id`),
  ADD CONSTRAINT `fk_tutor_level_upgrade_tutor` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`tutor_id`);

--
-- Constraints for table `tutor_point_cashout`
--
ALTER TABLE `tutor_point_cashout`
  ADD CONSTRAINT `tutor_point_cashout_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`tutor_id`);

--
-- Constraints for table `tutor_profile`
--
ALTER TABLE `tutor_profile`
  ADD CONSTRAINT `tutor_profile_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`tutor_id`);

--
-- Constraints for table `tutor_report`
--
ALTER TABLE `tutor_report`
  ADD CONSTRAINT `tutor_report_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`tutor_id`),
  ADD CONSTRAINT `tutor_report_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `tutor_study_material`
--
ALTER TABLE `tutor_study_material`
  ADD CONSTRAINT `tutor_study_material_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`),
  ADD CONSTRAINT `tutor_study_material_ibfk_2` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`tutor_id`);

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
