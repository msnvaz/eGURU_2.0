-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2025 at 06:10 PM
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
  `admin_id` int(15) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(1, 'admin1', '123');

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
(4, 10011, 'student', 'Technical issue', 'I am unable to access my scheduled session.', '2024-06-10 04:15:00', 'unread'),
(5, 20040, 'tutor', 'Class rescheduling', 'Can I reschedule my upcoming class?', '2024-07-02 08:50:00', 'read'),
(6, 20022, 'tutor', 'Session Recording Access', 'Can I access past session recordings?', '2024-08-10 05:00:00', 'unread'),
(7, 10012, 'student', 'Exam Tips', 'Do you have any tips for O/L exams?', '2024-09-12 06:45:00', 'read'),
(8, 20031, 'tutor', 'Account Verification', 'My account verification is still pending.', '2024-07-18 10:10:00', 'archived'),
(9, 10018, 'student', 'Point System Clarification', 'How do I earn and redeem points?', '2024-06-28 04:25:00', 'unread'),
(10, 20039, 'tutor', 'New Subject Request', 'Can I add ICT as a subject to teach?', '2024-05-23 11:50:00', 'read'),
(11, 10005, 'student', 'Schedule Issue', 'I booked a class, but the tutor is unavailable.', '2024-08-15 08:40:00', 'archived'),
(12, 20040, 'tutor', 'Teaching Material Request', 'Where can I upload additional teaching materials?', '2024-06-05 11:15:00', 'read'),
(13, 10020, 'student', 'Certificate of Completion', 'Do we get certificates for completed courses?', '2024-07-22 06:00:00', 'unread'),
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
(40, 15, 'admin1', 'We offer discounts for bulk purchases of 10+ sessions.', '2024-04-21 03:00:00');

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
(40010, 10005, 20025, '2024-02-05', '15:00:00', 'cancelled'),
(40011, 10001, 20021, '2024-02-06', '02:00:00', 'scheduled'),
(40012, 10002, 20022, '2024-02-07', '03:00:00', 'completed'),
(40013, 10003, 20023, '2024-02-08', '04:00:00', 'requested'),
(40014, 10004, 20024, '2024-02-09', '05:00:00', 'scheduled'),
(40015, 10005, 20025, '2024-02-10', '06:00:00', 'cancelled'),
(40016, 10011, 20031, '2024-02-11', '07:00:00', 'scheduled'),
(40017, 10012, 20032, '2024-02-12', '08:00:00', 'requested'),
(40018, 10013, 20033, '2024-02-13', '02:00:00', 'completed'),
(40019, 10014, 20034, '2024-02-14', '03:00:00', 'scheduled'),
(40020, 10015, 20035, '2024-02-15', '04:00:00', 'cancelled'),
(40021, 10016, 20036, '2024-02-16', '05:00:00', 'scheduled'),
(40022, 10017, 20037, '2024-02-17', '06:00:00', 'completed'),
(40023, 10018, 20038, '2024-02-18', '07:00:00', 'requested'),
(40024, 10019, 20039, '2024-02-19', '08:00:00', 'scheduled'),
(40025, 10020, 20040, '2024-02-20', '02:00:00', 'cancelled'),
(40026, 10001, 20021, '2024-02-21', '03:00:00', 'scheduled'),
(40027, 10002, 20022, '2024-02-22', '04:00:00', 'completed'),
(40028, 10003, 20023, '2024-02-23', '05:00:00', 'requested'),
(40029, 10004, 20024, '2024-02-24', '06:00:00', 'scheduled'),
(40030, 10005, 20025, '2024-02-25', '07:00:00', 'cancelled'),
(40031, 10011, 20031, '2024-02-26', '08:00:00', 'scheduled'),
(40032, 10012, 20032, '2024-02-27', '02:00:00', 'completed'),
(40033, 10013, 20033, '2024-02-28', '03:00:00', 'requested'),
(40034, 10014, 20034, '2024-02-29', '04:00:00', 'scheduled'),
(40035, 10015, 20035, '2024-03-01', '05:00:00', 'cancelled'),
(40036, 10016, 20036, '2024-03-02', '06:00:00', 'scheduled'),
(40037, 10017, 20037, '2024-03-03', '07:00:00', 'completed'),
(40038, 10018, 20038, '2024-03-04', '08:00:00', 'requested'),
(40039, 10019, 20039, '2024-03-05', '02:00:00', 'scheduled'),
(40040, 10020, 20040, '2024-03-06', '03:00:00', 'cancelled'),
(40041, 10001, 20021, '2024-03-07', '04:00:00', 'scheduled'),
(40042, 10002, 20022, '2024-03-08', '05:00:00', 'completed'),
(40043, 10003, 20023, '2024-03-09', '06:00:00', 'requested'),
(40044, 10004, 20024, '2024-03-10', '07:00:00', 'scheduled'),
(40045, 10005, 20025, '2024-03-11', '08:00:00', 'cancelled'),
(40046, 10011, 20031, '2024-03-12', '02:00:00', 'scheduled'),
(40047, 10012, 20032, '2024-03-13', '03:00:00', 'completed'),
(40048, 10013, 20033, '2024-03-14', '04:00:00', 'requested'),
(40049, 10014, 20034, '2024-03-15', '05:00:00', 'scheduled'),
(40050, 10015, 20035, '2024-03-16', '06:00:00', 'cancelled'),
(40051, 10016, 20036, '2024-03-17', '07:00:00', 'scheduled'),
(40052, 10017, 20037, '2024-03-18', '08:00:00', 'completed'),
(40053, 10018, 20038, '2024-03-19', '02:00:00', 'requested'),
(40054, 10019, 20039, '2024-03-20', '03:00:00', 'scheduled'),
(40055, 10020, 20040, '2024-03-21', '04:00:00', 'cancelled'),
(40056, 10001, 20021, '2024-03-22', '05:00:00', 'scheduled'),
(40057, 10002, 20022, '2024-03-23', '06:00:00', 'completed'),
(40058, 10003, 20023, '2024-03-24', '07:00:00', 'requested'),
(40059, 10004, 20024, '2024-03-25', '08:00:00', 'scheduled'),
(40060, 10005, 20025, '2024-03-26', '02:00:00', 'cancelled');

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

--
-- Dumping data for table `session_feedback`
--

INSERT INTO `session_feedback` (`feedback_id`, `session_id`, `student_feedback`, `tutor_reply`, `last_updated`, `time_created`, `session_rating`) VALUES
(1, 40006, 'The session was very informative and engaging.', 'Glad to hear that! Keep practicing.', '2025-02-09 14:30:00', '2025-02-09 13:00:00', 4),
(2, 40007, 'The pace was a bit too fast for me.', 'I’ll try to slow down next time.', '2025-02-09 15:00:00', '2025-02-09 14:00:00', 3),
(3, 40008, 'I loved the teaching style. Very interactive!', 'Thank you! Happy to help.', '2025-02-17 11:45:00', '2025-02-17 10:30:00', 5),
(4, 40009, 'Some topics were confusing, but overall good.', 'I’ll clarify them in the next session.', '2025-01-16 17:30:00', '2025-01-16 16:00:00', 3),
(5, 40010, 'Would like more examples for better understanding.', 'I’ll include more examples next time.', '2025-02-07 09:15:00', '2025-02-07 08:00:00', 4),
(6, 40011, 'Excellent session! Very clear explanations.', 'Happy to hear that! Keep learning.', '2025-01-08 18:30:00', '2025-01-08 17:00:00', 5),
(7, 40012, 'The content was helpful, but I need more exercises.', 'I’ll share extra practice questions.', '2025-02-09 12:00:00', '2025-02-09 11:00:00', 4),
(8, 40013, 'Great session! I understand the topic better now.', 'Awesome! Keep practicing.', '2025-01-17 13:45:00', '2025-01-17 12:30:00', 5),
(9, 40014, 'The explanations were a bit rushed.', 'I’ll try to slow down and explain better.', '2025-01-31 10:30:00', '2025-01-31 09:00:00', 3),
(10, 40015, 'Overall, a good session but some topics need revision.', 'I’ll go over them again in the next class.', '2025-02-05 15:15:00', '2025-02-05 14:00:00', 4),
(11, 40016, 'It was too basic for my level.', 'I’ll prepare more advanced content next time.', '2025-01-19 16:00:00', '2025-01-19 15:00:00', 2),
(12, 40017, 'The tutor was very patient and explained well.', 'Glad to help! Keep asking questions.', '2025-03-01 18:45:00', '2025-03-01 17:30:00', 5),
(13, 40018, 'I struggled with some of the concepts.', 'I’ll provide more examples next session.', '2025-01-11 09:45:00', '2025-01-11 08:30:00', 3),
(14, 40019, 'Really enjoyed the lesson. Very helpful.', 'Thank you! Hope to see you in the next session.', '2025-01-17 14:30:00', '2025-01-17 13:00:00', 5),
(15, 40020, 'Some parts were unclear, but overall good.', 'Let me know which parts and I’ll explain again.', '2025-01-25 12:15:00', '2025-01-25 11:00:00', 3),
(16, 40021, 'I learned a lot today. Thank you!', 'You’re welcome! Keep practicing.', '2025-01-19 16:30:00', '2025-01-19 15:15:00', 5),
(17, 40022, 'More practical exercises would be great.', 'I’ll add more practice next time.', '2025-02-17 10:00:00', '2025-02-17 08:45:00', 4),
(18, 40023, 'Very detailed explanations. Enjoyed the session.', 'Glad to hear that! Keep studying.', '2025-02-22 14:45:00', '2025-02-22 13:30:00', 5),
(19, 40024, 'I had difficulty following the examples.', 'I’ll break them down further next time.', '2025-02-13 17:00:00', '2025-02-13 16:00:00', 3),
(20, 40025, 'The session was well-structured and informative.', 'Thanks! Hope it was helpful.', '2025-03-02 11:30:00', '2025-03-02 10:00:00', 5),
(21, 40026, 'Great tutor! I understood everything well.', 'Awesome! Keep up the good work.', '2025-01-05 14:00:00', '2025-01-05 12:45:00', 5),
(22, 40027, 'Could use a slower pace for better understanding.', 'Noted! I’ll adjust in future lessons.', '2025-01-06 10:15:00', '2025-01-06 09:00:00', 4),
(23, 40028, 'Very interactive and engaging session.', 'Glad you enjoyed it!', '2025-01-27 15:45:00', '2025-01-27 14:30:00', 5),
(24, 40029, 'The tutor clarified all my doubts.', 'That’s great! Keep asking questions.', '2025-01-16 17:30:00', '2025-01-16 16:15:00', 5),
(25, 40030, 'Good lesson, but I need more revision.', 'I’ll send some extra materials.', '2025-01-22 11:00:00', '2025-01-22 09:45:00', 4);

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
(7, 40009, 10004, 20024, 40.00, 'refunded', '2025-01-16 16:05:00'),
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
(20, 40022, 10002, 20022, 45.00, 'okay', '2025-02-17 08:50:00'),
(21, 40023, 10003, 20023, 60.00, 'okay', '2025-02-22 13:35:00'),
(22, 40024, 10004, 20024, 40.00, 'refunded', '2025-02-13 16:05:00'),
(23, 40025, 10005, 20025, 55.00, 'okay', '2025-03-02 10:10:00'),
(24, 40026, 10011, 20031, 50.00, 'okay', '2025-01-05 12:50:00'),
(25, 40027, 10012, 20032, 45.00, 'okay', '2025-01-06 09:05:00'),
(26, 40028, 10013, 20033, 60.00, 'okay', '2025-01-27 14:35:00'),
(27, 40029, 10014, 20034, 40.00, 'refunded', '2025-01-16 16:20:00'),
(28, 40030, 10015, 20035, 55.00, 'okay', '2025-01-22 09:50:00');

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

--
-- Dumping data for table `student_availability`
--

INSERT INTO `student_availability` (`student_id`, `time_slot_id`, `day`) VALUES
(10001, 1, 'Monday'),
(10001, 2, 'Tuesday'),
(10001, 3, 'Wednesday'),
(10002, 2, 'Tuesday'),
(10002, 3, 'Wednesday'),
(10002, 4, 'Thursday'),
(10003, 3, 'Wednesday'),
(10003, 4, 'Thursday'),
(10003, 5, 'Friday'),
(10004, 4, 'Thursday'),
(10004, 5, 'Friday'),
(10004, 6, 'Saturday'),
(10005, 5, 'Friday'),
(10005, 6, 'Saturday'),
(10005, 7, 'Sunday'),
(10011, 6, 'Saturday'),
(10011, 7, 'Sunday'),
(10012, 1, 'Monday'),
(10012, 7, 'Sunday'),
(10013, 1, 'Monday'),
(10013, 2, 'Tuesday'),
(10014, 2, 'Tuesday'),
(10014, 3, 'Wednesday'),
(10015, 3, 'Wednesday'),
(10015, 4, 'Thursday'),
(10016, 4, 'Thursday'),
(10016, 5, 'Friday'),
(10017, 5, 'Friday'),
(10017, 6, 'Saturday'),
(10018, 6, 'Saturday'),
(10018, 7, 'Sunday'),
(10019, 1, 'Monday'),
(10019, 7, 'Sunday'),
(10020, 1, 'Monday'),
(10020, 2, 'Tuesday');

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
  `subject_display_pic` varchar(255) DEFAULT NULL,
  `subject_status` varchar(15) NOT NULL DEFAULT 'set'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_name`, `subject_display_pic`, `subject_status`) VALUES
(1, 'Mathematics', 'math_icon.png', 'set'),
(2, 'Science', 'science_icon.png', 'set'),
(3, 'English', 'english_icon.png', 'set'),
(4, 'Sinhala', 'sinhala_icon.png', 'set'),
(5, 'Tamil', 'tamil_icon.png', 'set'),
(6, 'History', 'history_icon.png', 'set'),
(7, 'Geography', 'geography_icon.png', 'set'),
(8, 'Buddhism', 'buddhism_icon.png', 'set'),
(9, 'Information Technology', 'it_icon.png', 'set'),
(10, 'Physics', 'physics_icon.png', 'set'),
(11, 'Chemistry', 'chemistry_icon.png', 'set'),
(12, 'Biology', 'biology_icon.png', 'set');

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
  `ad_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ad_status` varchar(15) NOT NULL DEFAULT 'set'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_advertisement`
--

INSERT INTO `tutor_advertisement` (`ad_id`, `tutor_id`, `ad_display_pic`, `ad_description`, `ad_created_at`, `ad_status`) VALUES
(7, 20021, 'ads/math_ol.jpg', 'O/L Mathematics classes with a focus on problem-solving techniques.', '2024-01-09 18:30:00', 'set'),
(8, 20021, 'ads/algebra.jpg', 'Master Algebra with step-by-step explanations and past paper discussions.', '2024-02-04 18:30:00', 'set'),
(9, 20022, 'ads/science_ol.jpg', 'Science lessons for O/L students covering Physics, Chemistry, and Biology.', '2024-01-14 18:30:00', 'set'),
(10, 20022, 'ads/chemistry.jpg', 'A/L Chemistry coaching with practical demonstrations and past papers.', '2024-03-09 18:30:00', 'set'),
(11, 20023, 'ads/physics.jpg', 'Physics A/L classes with in-depth explanations of theories and calculations.', '2024-02-24 18:30:00', 'set'),
(12, 20023, 'ads/math_al.jpg', 'Pure and Applied Mathematics coaching for A/L students.', '2024-03-31 18:30:00', 'set'),
(13, 20024, 'ads/english_lit.jpg', 'English Literature discussions with novel and poem analysis.', '2024-04-19 18:30:00', 'set'),
(14, 20024, 'ads/english_ol.jpg', 'Improve your English writing, speaking, and grammar for O/L exams.', '2024-05-04 18:30:00', 'set'),
(15, 20025, 'ads/biology.jpg', 'Biology lessons covering both theory and practical for A/L students.', '2024-03-14 18:30:00', 'set'),
(16, 20025, 'ads/science.jpg', 'Interactive Science lessons with experiments and real-life applications.', '2024-04-09 18:30:00', 'set'),
(17, 20031, 'ads/ict.jpg', 'ICT classes for O/L students covering databases, programming, and networking.', '2024-04-30 18:30:00', 'set'),
(18, 20031, 'ads/computer_science.jpg', 'Computer Science coaching including Python, Java, and Web Development.', '2024-05-14 18:30:00', 'set'),
(19, 20032, 'ads/business.jpg', 'Business Studies coaching for O/L and A/L students.', '2024-05-31 18:30:00', 'set'),
(20, 20032, 'ads/accounting.jpg', 'Accounting lessons covering financial statements and cost analysis.', '2024-06-19 18:30:00', 'set'),
(21, 20033, 'ads/economics.jpg', 'A/L Economics classes focusing on real-world applications.', '2024-07-04 18:30:00', 'set'),
(22, 20033, 'ads/history.jpg', 'History O/L coaching with structured study plans and model papers.', '2024-07-17 18:30:00', 'set'),
(23, 20034, 'ads/geography.jpg', 'Geography lessons covering map reading, climate, and landforms.', '2024-08-09 18:30:00', 'set'),
(24, 20034, 'ads/math_papers.jpg', 'O/L Mathematics paper discussion and exam techniques.', '2024-08-24 18:30:00', 'set'),
(25, 20035, 'ads/sinhala.jpg', 'Sinhala language training focusing on essay writing and comprehension.', '2024-09-04 18:30:00', 'set'),
(26, 20035, 'ads/ict_advanced.jpg', 'Advanced ICT lessons covering cybersecurity and AI basics.', '2024-09-14 18:30:00', 'set'),
(27, 20036, 'ads/physics_individual.jpg', 'One-on-one Physics coaching for A/L students.', '2024-09-29 18:30:00', 'set'),
(28, 20036, 'ads/chemistry_practical.jpg', 'Special A/L Chemistry practical session training.', '2024-10-04 18:30:00', 'set'),
(29, 20037, 'ads/biology_deep.jpg', 'A/L Biology deep dive with genetics and cellular biology focus.', '2024-10-19 18:30:00', 'set'),
(30, 20037, 'ads/science_middle.jpg', 'Science lessons for middle school students with fun experiments.', '2024-10-31 18:30:00', 'set'),
(31, 20038, 'ads/economics_crash.jpg', 'Fast-track A/L Economics revision course.', '2024-11-09 18:30:00', 'set'),
(32, 20038, 'ads/business_management.jpg', 'Business management concepts explained with case studies.', '2024-11-24 18:30:00', 'set'),
(33, 20039, 'ads/accounting_al.jpg', 'Accounting coaching with focus on financial reporting.', '2024-12-04 18:30:00', 'set'),
(34, 20040, 'ads/history_easy.jpg', 'History lessons with interactive storytelling and visuals.', '2024-12-14 18:30:00', 'set'),
(35, 20040, 'ads/geography_basics.jpg', 'Geography for beginners covering Sri Lankan and world geography.', '2024-12-19 18:30:00', 'set');

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
(20021, 2, 'Tuesday'),
(20021, 3, 'Wednesday'),
(20022, 2, 'Tuesday'),
(20022, 3, 'Wednesday'),
(20022, 4, 'Thursday'),
(20023, 3, 'Wednesday'),
(20023, 4, 'Thursday'),
(20023, 5, 'Friday'),
(20024, 4, 'Thursday'),
(20024, 5, 'Friday'),
(20024, 6, 'Saturday'),
(20025, 5, 'Friday'),
(20025, 6, 'Saturday'),
(20025, 7, 'Sunday'),
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
(29, 20040, 10013, 'Student was rude and refused to cooperate.', 'Misconduct', '2024-06-17 05:20:00');

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
  `tutor_qualification_proof` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_requests`
--

INSERT INTO `tutor_requests` (`request_id`, `tutor_first_name`, `tutor_last_name`, `tutor_email`, `tutor_password`, `tutor_NIC`, `tutor_DOB`, `tutor_points`, `tutor_profile_photo`, `tutor_status`, `tutor_registration_date`, `tutor_time_slots`, `tutor_last_login`, `tutor_log`, `tutor_level_id`, `tutor_qualification_proof`) VALUES
(21, 'Kamal', 'Perera', 'kamalp@gmail.com', 'hashedpassword123', 872345678, '1985-07-21', 50, 'profile1.jpg', 'set', '2025-02-25', 0, '2025-02-25 22:10:28', 'offline', 'G01', 'degree_certificate1.pdf'),
(22, 'Saman', 'Fernando', 'samanf@gmail.com', 'hashedpassword234', 912345678, '1990-10-12', 40, 'profile2.jpg', 'set', '2025-02-25', 0, '2025-02-25 22:10:28', 'offline', 'G02', 'diploma_certificate2.pdf'),
(23, 'Nuwan', 'Silva', 'nuwans@gmail.com', 'hashedpassword345', 882345678, '1992-05-18', 30, 'profile3.jpg', 'set', '2025-02-25', 0, '2025-02-25 22:10:28', 'offline', 'G03', 'certificate3.pdf'),
(24, 'Mahesh', 'Kumara', 'maheshk@gmail.com', 'hashedpassword456', 912365478, '1988-12-05', 25, 'profile4.jpg', 'set', '2025-02-25', 0, '2025-02-25 22:10:28', 'offline', 'G04', 'certificate4.pdf'),
(25, 'Nadeesha', 'Wijesinghe', 'nadeeshaw@gmail.com', 'hashedpassword567', 902345978, '1995-08-22', 20, 'profile5.jpg', 'set', '2025-02-25', 0, '2025-02-25 22:10:28', 'offline', 'G05', 'certificate5.pdf'),
(26, 'Kasun', 'Bandara', 'kasunb@gmail.com', 'hashedpassword678', 882345698, '1997-03-30', 10, 'profile6.jpg', 'set', '2025-02-25', 0, '2025-02-25 22:10:28', 'offline', 'G06', 'certificate6.pdf'),
(27, 'Tharindu', 'Rathnayake', 'tharindur@gmail.com', 'hashedpassword789', 922347678, '1986-09-15', 45, 'profile7.jpg', 'set', '2025-02-25', 0, '2025-02-25 22:10:28', 'offline', 'G01', 'degree_certificate7.pdf'),
(28, 'Amali', 'Rajapaksha', 'amali.rajapaksha@gmail.com', 'hashedpassword890', 882349678, '1994-06-11', 35, 'profile8.jpg', 'set', '2025-02-25', 0, '2025-02-25 22:10:28', 'offline', 'G02', 'diploma_certificate8.pdf'),
(29, 'Chathura', 'Jayasinghe', 'chathuraj@gmail.com', 'hashedpassword901', 902345678, '1989-11-20', 28, 'profile9.jpg', 'set', '2025-02-25', 0, '2025-02-25 22:10:28', 'offline', 'G03', 'certificate9.pdf'),
(30, 'Isuru', 'Senanayake', 'isurus@gmail.com', 'hashedpassword012', 912345678, '1993-02-14', 22, 'profile10.jpg', 'set', '2025-02-25', 0, '2025-02-25 22:10:28', 'offline', 'G04', 'certificate10.pdf');

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
  `material_status` varchar(15) NOT NULL DEFAULT 'set'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_study_material`
--

INSERT INTO `tutor_study_material` (`material_id`, `subject_id`, `material_description`, `grade`, `tutor_id`, `material_status`) VALUES
(13, 1, 'Comprehensive guide on Algebra for Grade 6 students', 6, 20021, 'set'),
(14, 2, 'Physics notes on Newton’s Laws of Motion', 7, 20022, 'set'),
(15, 3, 'Essay writing techniques for Grade 8 students', 8, 20023, 'set'),
(16, 4, 'Detailed study on Sri Lankan History', 9, 20024, 'set'),
(17, 5, 'Advanced Trigonometry exercises for Grade 10', 10, 20025, 'set'),
(18, 6, 'Chemical Reactions and Equations - Grade 11', 11, 20031, 'set'),
(19, 7, 'Basic Sinhala Grammar lessons', 6, 20032, 'set'),
(20, 8, 'Introduction to Economics for Grade 7', 7, 20033, 'set'),
(21, 9, 'Geography notes on climate change', 8, 20034, 'set'),
(22, 10, 'Biology workbook on Human Anatomy', 9, 20035, 'set'),
(23, 11, 'English Literature summaries for Grade 10', 10, 20036, 'set'),
(24, 12, 'Mathematical problem-solving techniques', 11, 20037, 'set'),
(25, 1, 'Fun activities for learning fractions', 6, 20038, 'set'),
(26, 2, 'Electricity and Magnetism notes', 7, 20039, 'set'),
(27, 3, 'Creative writing guide for essays', 8, 20040, 'set'),
(28, 4, 'Historical events of Sri Lanka', 9, 20021, 'set'),
(29, 5, 'Statistics and Probability exercises', 10, 20022, 'set'),
(30, 6, 'Practical experiments for Chemistry', 11, 20023, 'set'),
(31, 7, 'Advanced Sinhala literary analysis', 6, 20024, 'set'),
(32, 8, 'Fundamentals of Business Studies', 7, 20025, 'set');

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
(20022, 4),
(20022, 5),
(20022, 6),
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
(20032, 2),
(20032, 4),
(20032, 8),
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_inbox`
--
ALTER TABLE `admin_inbox`
  MODIFY `inbox_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `admin_inbox_reply`
--
ALTER TABLE `admin_inbox_reply`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40061;

--
-- AUTO_INCREMENT for table `session_feedback`
--
ALTER TABLE `session_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `session_payment`
--
ALTER TABLE `session_payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tutor_report`
--
ALTER TABLE `tutor_report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tutor_requests`
--
ALTER TABLE `tutor_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tutor_study_material`
--
ALTER TABLE `tutor_study_material`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
