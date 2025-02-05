-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2025 at 08:20 PM
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
-- Database: `eguru_full`
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
-- Table structure for table `admin_inbox`
--

CREATE TABLE `admin_inbox` (
  `id` int(11) NOT NULL,
  `sender_type` enum('student','teacher','admin') NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime NOT NULL,
  `status` enum('unread','read','archived') DEFAULT 'unread',
  `priority` enum('low','medium','high') DEFAULT 'medium'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_inbox`
--

INSERT INTO `admin_inbox` (`id`, `sender_type`, `sender_name`, `subject`, `message`, `timestamp`, `status`, `priority`) VALUES
(1, 'student', 'John Doe', 'Question about booking', 'Hi, I\'m having trouble booking a session...', '2024-02-15 14:30:00', 'unread', 'high'),
(2, 'teacher', 'Jane Smith', 'Issue with payment', 'I have not received my payment for last week.', '2024-02-16 10:45:00', 'unread', 'high'),
(3, 'student', 'Michael Lee', 'Session reschedule request', 'Can I reschedule my session to next Monday?', '2024-02-17 08:15:00', 'read', 'medium'),
(4, 'admin', 'Support Team', 'System Maintenance Alert', 'The platform will be down for maintenance tomorrow.', '2024-02-17 12:00:00', 'read', 'high'),
(5, 'student', 'Emily Clark', 'Forgot password', 'I am unable to reset my password.', '2024-02-18 09:30:00', 'unread', 'high'),
(6, 'teacher', 'Robert Brown', 'New feature suggestion', 'It would be great to have a calendar sync option.', '2024-02-18 15:45:00', 'read', 'medium'),
(7, 'student', 'Alice Johnson', 'Technical issue', 'My video is not working during sessions.', '2024-02-19 11:00:00', 'unread', 'high'),
(8, 'admin', 'Support Team', 'Policy Update', 'We have updated our privacy policy.', '2024-02-19 18:20:00', 'read', 'low'),
(9, 'student', 'David Wilson', 'Booking confirmation', 'I want to confirm if my booking was successful.', '2024-02-20 07:10:00', 'unread', 'medium'),
(10, 'teacher', 'Sophia Martinez', 'Change profile picture', 'How can I update my profile picture?', '2024-02-20 14:30:00', 'archived', 'low'),
(11, 'student', 'Lucas Green', 'Complaint about tutor', 'The tutor did not show up for the session.', '2024-02-21 16:00:00', 'unread', 'high'),
(12, 'teacher', 'Olivia Baker', 'Payment delayed', 'I still have not received my last payment.', '2024-02-22 13:15:00', 'read', 'high'),
(13, 'admin', 'Support Team', 'Scheduled Downtime', 'System will be down for updates.', '2024-02-22 22:00:00', 'read', 'medium'),
(14, 'student', 'Mason Carter', 'Refund request', 'I need a refund for a cancelled session.', '2024-02-23 10:45:00', 'unread', 'high'),
(15, 'teacher', 'William Harris', 'Account verification', 'I have uploaded my verification documents.', '2024-02-24 08:55:00', 'archived', 'medium'),
(16, 'student', 'Charlotte King', 'How to contact support?', 'Is there a direct number for support?', '2024-02-25 12:25:00', 'read', 'low'),
(17, 'admin', 'Support Team', 'New Feature Announcement', 'We have introduced a new scheduling feature.', '2024-02-26 17:40:00', 'read', 'low'),
(18, 'teacher', 'James White', 'Student no-show', 'The student did not attend the session.', '2024-02-27 14:10:00', 'unread', 'medium'),
(19, 'student', 'Ethan Thomas', 'Website not loading', 'The website is very slow today.', '2024-02-28 09:50:00', 'unread', 'high'),
(20, 'teacher', 'Liam Walker', 'Session feedback', 'Here is my feedback for my last session.', '2024-02-28 16:30:00', 'archived', 'medium');

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advertisements`
--

INSERT INTO `advertisements` (`id`, `image_path`, `description`, `created_at`) VALUES
(4, 'uploads/management.jpg', 'man', '2024-12-02 04:39:00');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `student_name` text NOT NULL,
  `tutor_name` text NOT NULL,
  `comments` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `student_id`, `tutor_id`, `student_name`, `tutor_name`, `comments`) VALUES
(9, 4, 3, 'Sachini Wimalasiri', 'Mr. Nuwan', 'good teaching'),
(2, 11, 2, 'Vimalraj Lagithan', 'Mr. Dulanjaya', 'dfnsmfn');

-- --------------------------------------------------------

--
-- Table structure for table `fee_request`
--

CREATE TABLE `fee_request` (
  `requestID` int(11) NOT NULL,
  `teacherID` int(11) NOT NULL,
  `date` date NOT NULL,
  `attachments` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Denied') DEFAULT 'Pending',
  `current_fee` decimal(10,2) DEFAULT NULL,
  `requested_fee` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fee_request`
--

INSERT INTO `fee_request` (`requestID`, `teacherID`, `date`, `attachments`, `status`, `current_fee`, `requested_fee`, `created_at`, `updated_at`) VALUES
(1, 101, '2024-11-01', 'attachment1.pdf', 'Pending', 1500.00, 1800.00, '2024-11-01 12:18:08', '2024-11-03 07:35:24'),
(2, 102, '2024-11-02', 'attachment2.pdf', 'Approved', 1200.00, 1300.00, '2024-11-01 12:18:08', '2024-11-03 07:35:24'),
(3, 103, '2024-11-03', 'attachment3.pdf', 'Denied', 900.00, 950.00, '2024-11-01 12:18:08', '2024-11-03 07:35:24'),
(4, 104, '2024-11-04', NULL, 'Pending', 1600.00, 1700.00, '2024-11-01 12:18:08', '2024-11-03 07:35:24'),
(5, 105, '2024-11-05', 'attachment4.pdf', 'Approved', 1100.00, 1200.00, '2024-11-01 12:18:08', '2024-11-03 07:35:24'),
(6, 106, '2024-11-06', 'attachment5.pdf', 'Pending', 1400.00, 1500.00, '2024-11-01 12:18:28', '2024-11-03 07:35:24'),
(7, 107, '2024-11-07', 'attachment6.pdf', 'Approved', 1300.00, 1450.00, '2024-11-01 12:18:28', '2024-11-03 07:35:24'),
(8, 108, '2024-11-08', NULL, 'Denied', 1550.00, 1650.00, '2024-11-01 12:18:28', '2024-11-03 07:35:24'),
(9, 109, '2024-11-09', 'attachment7.pdf', 'Pending', 1250.00, 1350.00, '2024-11-01 12:18:28', '2024-11-03 07:35:24'),
(10, 110, '2024-11-10', 'attachment8.pdf', 'Approved', 1450.00, 1550.00, '2024-11-01 12:18:28', '2024-11-03 07:35:24'),
(11, 111, '2024-11-11', NULL, 'Pending', 1000.00, 1050.00, '2024-11-01 12:18:28', '2024-11-03 07:35:24'),
(12, 112, '2024-11-12', 'attachment9.pdf', 'Denied', 1150.00, 1250.00, '2024-11-01 12:18:28', '2024-11-03 07:35:24'),
(13, 113, '2024-11-13', 'attachment10.pdf', 'Approved', 1350.00, 1500.00, '2024-11-01 12:18:28', '2024-11-03 07:35:24'),
(14, 114, '2024-11-14', NULL, 'Pending', 900.00, 950.00, '2024-11-01 12:18:28', '2024-11-03 07:35:24'),
(15, 115, '2024-11-15', 'attachment11.pdf', 'Denied', 1600.00, 1800.00, '2024-11-01 12:18:28', '2024-11-03 07:35:24');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_type` enum('student','tutor','admin') DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('pending','completed','failed') DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `scheduled_date` date NOT NULL,
  `scheduled_time` time NOT NULL,
  `progress` varchar(255) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `status` enum('scheduled','completed','canceled','pending') DEFAULT 'scheduled',
  `subject_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `student_id`, `tutor_id`, `scheduled_date`, `scheduled_time`, `progress`, `feedback`, `status`, `subject_id`) VALUES
(1, 1, 1, '2024-11-05', '10:00:00', 'in progress', 'Good progress so far.', 'scheduled', 1),
(2, 2, 1, '2024-11-06', '11:30:00', 'completed', 'Student grasped the topic well.', 'completed', 2),
(3, 3, 2, '2024-11-07', '09:00:00', 'in progress', 'Student needs more practice.', 'scheduled', 3),
(4, 4, 3, '2024-11-08', '14:00:00', 'not started', '', 'scheduled', 4),
(5, 5, 1, '2024-11-09', '15:30:00', 'completed', 'Great session, showed improvement.', 'completed', 5),
(6, 6, 2, '2024-11-10', '16:00:00', 'in progress', 'Student is struggling with basics.', 'scheduled', 6),
(7, 7, 3, '2024-11-11', '12:30:00', 'canceled', 'Student was unavailable.', 'canceled', 7),
(8, 8, 4, '2024-11-12', '13:00:00', 'completed', 'Covered all planned topics.', 'completed', 5),
(9, 9, 5, '2024-11-13', '11:00:00', 'not started', '', 'scheduled', 3),
(10, 1, 6, '2024-11-14', '10:30:00', 'in progress', 'Starting new topics.', 'scheduled', 33),
(11, 2, 7, '2024-11-15', '09:30:00', 'completed', 'Quick learner.', 'completed', 1),
(12, 3, 8, '2024-11-16', '14:30:00', 'in progress', 'Requires additional sessions.', 'scheduled', 2),
(13, 4, 9, '2024-11-17', '08:30:00', 'completed', 'Good understanding of material.', 'completed', 3),
(14, 5, 4, '2024-11-18', '15:00:00', 'in progress', 'Discussed new strategies.', 'scheduled', 4),
(15, 6, 5, '2024-11-19', '10:45:00', 'not started', '', 'pending', 5);

-- --------------------------------------------------------

--
-- Table structure for table `session_requests`
--

CREATE TABLE `session_requests` (
  `request_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `requested_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Accepted','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session_requests`
--

INSERT INTO `session_requests` (`request_id`, `student_id`, `tutor_id`, `requested_date`, `status`) VALUES
(1, 1, 1, '2023-05-20 03:30:00', 'Accepted'),
(2, 2, 2, '2023-05-22 04:30:00', 'Pending'),
(3, 3, 3, '2023-05-25 05:30:00', 'Rejected'),
(4, 4, 4, '2023-05-27 06:30:00', 'Accepted'),
(5, 5, 5, '2023-05-29 07:30:00', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `phonenumber` text NOT NULL,
  `dateofbirth` date NOT NULL,
  `grade` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `profile_photo` varchar(255) NOT NULL DEFAULT 'stu1.jpg',
  `registration_date` date NOT NULL DEFAULT '2025-01-01',
  `status` varchar(6) NOT NULL DEFAULT 'set',
  `last_login` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `firstname`, `lastname`, `email`, `password`, `phonenumber`, `dateofbirth`, `grade`, `points`, `profile_photo`, `registration_date`, `status`, `last_login`) VALUES
(1, 'Thiruveni', 'Kumarasooriya', 'thiruveni976@gmail.com', '123', '0773815648', '2024-11-13', 8, 65, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(2, 'Thiruveni', 'Kumarasooriya', 'thiruveni976@gmail.com', '123', '0773815648', '2024-11-13', 9, 80, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(3, 'Thiruveni', 'Kumarasooriya', 'thiruveni976@gmail.com', '1234', '0773815648', '2024-11-20', 10, 62, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(4, 'Sachini', 'Wimalasiri', 'sachini10@gmail.com', '12345', '0771234567', '2024-11-21', 6, 82, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(5, 'Sachini', 'Wimalasiri', 'sachini10@gmail.com', '12345', '0771234567', '2024-11-21', 8, 63, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(6, 'Laxmitha', 'Chandrakumar', 'lax16@gmail.com', 'laxmitha', '0771654373', '2024-06-18', 8, 87, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(7, 'Laxmitha', 'Chandrakumar', 'thiruveni976@gmail.com', 'laxmitha', '0771654373', '2024-06-18', 7, 98, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(8, 'Laxmitha', 'Chandrakumar', 'thiruveni976@gmail.com', '1234', '0773815648', '2024-11-10', 6, 87, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(9, 'Thiruveni', 'Kumarasooriya', 'thiruveni976@gmail.com', '12345678', '0773815648', '2024-10-27', 6, 81, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(11, 'Vimalraj', 'Lagithan', 'vimalrajlagithan@gmail.com', '123456', '0763679558', '2024-11-30', 7, 87, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(12, 'Vimalraj', 'Lagithan', 'vimalrajlagithan@gmail.com', '123456', '0763679558', '2024-11-30', 9, 66, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(13, 'Vimalraj', 'Lagithan', 'vimalrajlagithan@gmail.com', '123456', '0763679558', '2024-11-30', 11, 99, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(14, 'Thiruveni', 'Kumarasooriya', 'thirushanu@gmail.com', '$2y$10$2uO4QZJqL/js5lMJoF4yhe3ULlUGj6QLn5CJTIkNHpA6yGVcU/20O', '0773815648', '2024-12-04', 6, 94, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(15, 'Sachini', 'Wimalasiri', 'sachi10@gmail.com', '$2y$10$3kRpO09JTQQ9mv4BSzn2e.X/0pRJQscWMJfTYokhN/jyv4H3.lV42', '0773815648', '2024-12-11', 10, 77, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(16, 'Thiruveni', 'Kumarasooriya', 'thiru1234@gmail.com', '$2y$10$S7HuBHksy49j9gTcnZCRQOiI5bd9wuZDawGXg6RDPAFDSMZOMk7Bu', '0773815648', '2024-12-05', 10, 83, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(17, 'Thiruveni', 'Kumarasooriya', 'sss@gmail.com', '$2y$10$TzOVJlcGk6xzNQPEIB1n5.GR8fMEdVK6JXLgBk163EXnNASKS7YQW', '0773815648', '2024-12-19', 9, 94, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(18, 'Student1', 'Last1', 'student1@example.com', 'pass1', '123456781', '2004-10-20', 6, 83, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(19, 'Student2', 'Last2', 'student2@example.com', 'pass2', '123456782', '2001-07-28', 8, 84, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(20, 'Student3', 'Last3', 'student3@example.com', 'pass3', '123456783', '1995-09-03', 11, 64, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(21, 'Student4', 'Last4', 'student4@example.com', 'pass4', '123456784', '1998-06-17', 8, 71, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46'),
(22, 'Student5', 'Last5', 'student5@example.com', 'pass5', '123456785', '2003-04-17', 9, 97, 'stu1.jpg', '2025-01-01', 'set', '2025-01-11 19:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `profile_photo` blob DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` date NOT NULL,
  `points_balance` int(11) DEFAULT 0,
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `phone_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `name`, `profile_photo`, `email`, `password`, `registration_date`, `points_balance`, `status`, `last_login`, `phone_number`, `address`) VALUES
(1, 'Alice Johnson', NULL, 'alice@example.com', 'password123', '2023-01-15', 100, 'active', '2025-01-06 09:07:40', NULL, NULL),
(2, 'Bob Smith', NULL, 'bob@example.com', 'password456', '2023-01-17', 150, 'active', '2025-01-06 09:07:40', NULL, NULL),
(3, 'Cathy Brown', NULL, 'cathy@example.com', 'password789', '2023-02-01', 200, 'active', '2025-01-06 09:07:40', NULL, NULL),
(4, 'David Wilson', NULL, 'david@example.com', 'password012', '2023-02-05', 120, 'active', '2025-01-06 09:07:40', NULL, NULL),
(5, 'Emma Taylor', NULL, 'emma@example.com', 'password345', '2023-02-10', 180, 'active', '2025-01-06 09:07:40', NULL, NULL),
(6, 'Frank Harris', NULL, 'frank@example.com', 'password678', '2023-02-20', 130, 'active', '2025-01-06 09:07:40', NULL, NULL),
(7, 'Grace Lee', NULL, 'grace@example.com', 'password901', '2023-03-01', 170, 'active', '2025-01-06 09:07:40', NULL, NULL),
(8, 'Hannah King', NULL, 'hannah@example.com', 'password234', '2023-03-10', 90, 'active', '2025-01-06 09:07:40', NULL, NULL),
(9, 'Ian Wright', NULL, 'ian@example.com', 'password567', '2023-03-15', 210, 'active', '2025-01-06 09:07:40', NULL, NULL),
(10, 'Jack Green', NULL, 'jack@example.com', 'password890', '2023-04-01', 160, 'active', '2025-01-06 09:07:40', NULL, NULL),
(11, 'Karen White', NULL, 'karen@example.com', 'password1234', '2023-04-10', 110, 'active', '2025-01-06 09:07:40', NULL, NULL),
(12, 'Liam Adams', NULL, 'liam@example.com', 'password5678', '2023-04-15', 140, 'active', '2025-01-06 09:07:40', NULL, NULL),
(13, 'Mia Hill', NULL, 'mia@example.com', 'password9012', '2023-05-01', 80, 'active', '2025-01-06 09:07:40', NULL, NULL),
(14, 'Noah Clark', NULL, 'noah@example.com', 'password3456', '2023-05-10', 190, 'active', '2025-01-06 09:07:40', NULL, NULL),
(15, 'Olivia Lewis', NULL, 'olivia@example.com', 'password7890', '2023-05-15', 100, 'active', '2025-01-06 09:07:40', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `grade_6` tinyint(1) DEFAULT 0,
  `grade_7` tinyint(1) DEFAULT 0,
  `grade_8` tinyint(1) DEFAULT 0,
  `grade_9` tinyint(1) DEFAULT 0,
  `grade_10` tinyint(1) DEFAULT 0,
  `grade_11` tinyint(1) DEFAULT 0,
  `display_pic` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'set',
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `grade_6`, `grade_7`, `grade_8`, `grade_9`, `grade_10`, `grade_11`, `display_pic`, `status`, `category_id`) VALUES
(1, 'Mathematics', 0, 0, 0, 0, 1, 1, 'Mathematics.jpg', 'set', NULL),
(2, 'Physics', 0, 0, 1, 1, 1, 1, 'Physics.jpg', 'set', NULL),
(3, 'Chemistry', 0, 0, 1, 1, 1, 1, 'Chemistry.jpg', 'set', NULL),
(4, 'Biology', 0, 0, 0, 1, 1, 1, 'Biology.jpg', 'set', NULL),
(5, 'History', 1, 1, 1, 1, 1, 1, 'History.png', 'set', NULL),
(6, 'Geography', 1, 1, 1, 1, 1, 1, 'Geography.jpg', 'set', NULL),
(7, 'English', 1, 1, 1, 1, 1, 1, 'English.jpg', 'set', NULL),
(29, 'DSA II ', 0, 0, 1, 1, 1, 1, 'dsa.png', 'set', NULL),
(30, 'Test', 0, 0, 0, 0, 1, 1, 'download (1).jpeg', 'set', NULL),
(31, 'Sandeep', 0, 0, 0, 0, 0, 1, 'gpic.jpg', 'unset', NULL),
(32, 'hhh', 0, 0, 0, 0, 1, 1, 'istockphoto-494466008-612x612.jpg', 'unset', NULL),
(33, 'yyy', 0, 0, 0, 1, 1, 1, '_MG_9192.jpg', 'set', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject_categories`
--

CREATE TABLE `subject_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teaching_materials`
--

CREATE TABLE `teaching_materials` (
  `material_id` int(11) NOT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `material_type` enum('document','video','quiz','presentation') DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `points_purchased` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `student_id`, `transaction_date`, `points_purchased`, `amount`) VALUES
(1, 1, '2023-01-15 04:30:00', 100, 10.00),
(2, 2, '2023-01-17 06:00:00', 150, 15.00),
(3, 3, '2023-02-01 04:15:00', 200, 20.00),
(4, 4, '2023-02-05 07:45:00', 120, 12.00),
(5, 5, '2023-02-10 08:30:00', 180, 18.00);

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `tutor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `profile_photo` blob DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` date NOT NULL,
  `tutor_level` varchar(50) DEFAULT NULL,
  `teaching_grades` varchar(20) DEFAULT NULL,
  `educational_qualifications` text DEFAULT NULL,
  `current_points` int(11) DEFAULT 0,
  `sessions_done` int(11) DEFAULT 0,
  `is_approved` tinyint(1) DEFAULT 0,
  `hourly_rate` decimal(10,2) DEFAULT NULL,
  `availability_status` enum('available','busy','offline') DEFAULT 'offline',
  `bio` text DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `total_earnings` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`tutor_id`, `name`, `profile_photo`, `email`, `password`, `registration_date`, `tutor_level`, `teaching_grades`, `educational_qualifications`, `current_points`, `sessions_done`, `is_approved`, `hourly_rate`, `availability_status`, `bio`, `phone_number`, `address`, `total_earnings`) VALUES
(1, 'Tom Parker', NULL, 'tom@example.com', 'pass123', '2023-01-05', 'Expert', '6-8', 'B.Ed, M.Ed', 500, 15, 1, NULL, 'offline', NULL, NULL, NULL, 0.00),
(2, 'Sara Evans', NULL, 'sara@example.com', 'pass456', '2023-01-12', 'Advanced', '9-11', 'B.A. in Math', 300, 10, 1, NULL, 'offline', NULL, NULL, NULL, 0.00),
(3, 'Mark Allen', NULL, 'mark@example.com', 'pass789', '2023-01-20', 'Beginner', '6-7', 'M.Sc. in Physics', 150, 5, 0, NULL, 'offline', NULL, NULL, NULL, 0.00),
(4, 'Emily Thomas', NULL, 'emily@example.com', 'pass012', '2023-02-05', 'Intermediate', '8-10', 'B.A. in English', 200, 8, 1, NULL, 'offline', NULL, NULL, NULL, 0.00),
(5, 'Nathan Baker', NULL, 'nathan@example.com', 'pass345', '2023-02-10', 'Advanced', '6-9', 'M.A. in History', 400, 12, 0, NULL, 'offline', NULL, NULL, NULL, 0.00),
(6, 'Sophie Edwards', NULL, 'sophie@example.com', 'pass678', '2023-02-20', 'Expert', '10-11', 'M.A. in Literature', 450, 14, 1, NULL, 'offline', NULL, NULL, NULL, 0.00),
(7, 'Chris Jones', NULL, 'chris@example.com', 'pass901', '2023-03-01', 'Intermediate', '7-8', 'B.Ed', 300, 11, 1, NULL, 'offline', NULL, NULL, NULL, 0.00),
(8, 'Laura Scott', NULL, 'laura@example.com', 'pass234', '2023-03-10', 'Beginner', '6', 'M.Sc. in Chemistry', 100, 3, 0, NULL, 'offline', NULL, NULL, NULL, 0.00),
(9, 'Mike Turner', NULL, 'mike@example.com', 'pass567', '2023-03-15', 'Advanced', '8-10', 'B.A. in Geography', 350, 9, 1, NULL, 'offline', NULL, NULL, NULL, 0.00),
(10, 'Anna Mitchell', NULL, 'anna@example.com', 'pass890', '2023-04-01', 'Expert', '6-11', 'Ph.D. in Biology', 600, 18, 1, NULL, 'offline', NULL, NULL, NULL, 0.00),
(11, 'James Ross', NULL, 'james@example.com', 'pass1234', '2023-04-10', 'Beginner', '6-7', 'B.A. in Psychology', 200, 6, 0, NULL, 'offline', NULL, NULL, NULL, 0.00),
(12, 'Lucy Morgan', NULL, 'lucy@example.com', 'pass5678', '2023-04-15', 'Intermediate', '9-11', 'M.Sc. in Statistics', 320, 8, 1, NULL, 'offline', NULL, NULL, NULL, 0.00),
(13, 'Oliver Wood', NULL, 'oliver@example.com', 'pass9012', '2023-05-01', 'Expert', '6-8', 'Ph.D. in Math', 500, 15, 1, NULL, 'offline', NULL, NULL, NULL, 0.00),
(14, 'Sophia Nelson', NULL, 'sophia@example.com', 'pass3456', '2023-05-10', 'Intermediate', '10-11', 'B.Sc. in Physics', 250, 10, 1, NULL, 'offline', NULL, NULL, NULL, 0.00),
(15, 'Jackie Rogers', NULL, 'jackie@example.com', 'pass7890', '2023-05-15', 'Advanced', '7-9', 'M.Ed in English', 400, 12, 1, NULL, 'offline', NULL, NULL, NULL, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `tutor_availability`
--
-- Error reading structure for table eguru_full.tutor_availability: #1932 - Table &#039;eguru_full.tutor_availability&#039; doesn&#039;t exist in engine
-- Error reading data for table eguru_full.tutor_availability: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `eguru_full`.`tutor_availability`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `tutor_grading`
--

CREATE TABLE `tutor_grading` (
  `grade` varchar(50) DEFAULT NULL,
  `qualification` varchar(100) DEFAULT NULL,
  `pay_per_hour` varchar(50) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `grade_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_grading`
--

INSERT INTO `tutor_grading` (`grade`, `qualification`, `pay_per_hour`, `color`, `grade_id`) VALUES
('Gold', 'Qualification: Qualification: Qualification: Degree Holding School Teachers', '1000', '#b3ffb366', 'G01'),
('A', 'Junior Teachers,Trainee Teachers,Post Graduates', '900', '#ffff8066', 'G02'),
('B+', 'Experienced Undergraduate,Trainee Teachers', '800', '#B0E0E666', 'G03'),
('B', 'Undergraduates', '700', '#FAF9F6', 'G04'),
('C', 'Diploma Holders', '600', '#FAF9F6', 'G05'),
('D', 'Post AL Students / Other', '500', '#FAF9F6', 'G06');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_new`
--

CREATE TABLE `tutor_new` (
  `tutor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `tutor_level` varchar(50) NOT NULL,
  `grade` varchar(20) NOT NULL,
  `availability` enum('available','tutoring','unavailable') DEFAULT 'unavailable',
  `rating` decimal(3,2) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `hour_fees` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_new`
--

INSERT INTO `tutor_new` (`tutor_id`, `name`, `subject`, `tutor_level`, `grade`, `availability`, `rating`, `hour_fees`) VALUES
(1, 'Anban Shayan', 'Science', 'Undergraduate', 'Secondary', 'available', 4.00, 1000.00),
(2, 'Ravindu Sooriya', 'Science', 'Graduate', 'Secondary', 'tutoring', 3.50, 1500.00),
(3, 'Amar Lareef', 'Science', 'Full-time', 'Secondary', 'unavailable', 2.00, 2000.00),
(4, 'Kasun Zoysa', 'Science', 'Retired', 'Secondary', 'available', 4.80, 1000.00),
(5, 'Gihan Jayasinghe', 'Science', 'Grduate', 'Secondary', 'tutoring', 4.30, 1200.00),
(6, 'Anban Kuga', 'Science', 'Undergraduate', 'Secondary', 'unavailable', 5.00, 800.00),
(7, 'Wasim Khan', 'Science', 'Full-time', 'Secondary', 'unavailable', 5.00, 1500.00),
(8, 'Kumara Thanrindu', 'Science', 'Retired', 'Secondary', 'available', 3.90, 800.00);

-- --------------------------------------------------------

--
-- Table structure for table `tutor_requests`
--

CREATE TABLE `tutor_requests` (
  `request_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_requests`
--

INSERT INTO `tutor_requests` (`request_id`, `tutor_id`, `request_date`, `status`) VALUES
(1, 3, '2023-01-20 04:30:00', 'Pending'),
(2, 5, '2023-02-10 06:00:00', 'Pending'),
(3, 8, '2023-03-10 04:15:00', 'Pending'),
(4, 11, '2023-04-10 07:45:00', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_subjects`
--

CREATE TABLE `tutor_subjects` (
  `tutor_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutor_subjects`
--

INSERT INTO `tutor_subjects` (`tutor_id`, `subject_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 5),
(3, 4),
(4, 3),
(5, 6),
(6, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_inbox`
--
ALTER TABLE `admin_inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee_request`
--
ALTER TABLE `fee_request`
  ADD PRIMARY KEY (`requestID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `tutor_id` (`tutor_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `tutor_id` (`tutor_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `session_requests`
--
ALTER TABLE `session_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `tutor_id` (`tutor_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `subject_categories`
--
ALTER TABLE `subject_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `teaching_materials`
--
ALTER TABLE `teaching_materials`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `tutor_id` (`tutor_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `tutors`
--
ALTER TABLE `tutors`
  ADD PRIMARY KEY (`tutor_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tutor_new`
--
ALTER TABLE `tutor_new`
  ADD PRIMARY KEY (`tutor_id`);

--
-- Indexes for table `tutor_requests`
--
ALTER TABLE `tutor_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `tutor_id` (`tutor_id`);

--
-- Indexes for table `tutor_subjects`
--
ALTER TABLE `tutor_subjects`
  ADD PRIMARY KEY (`tutor_id`,`subject_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_inbox`
--
ALTER TABLE `admin_inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `fee_request`
--
ALTER TABLE `fee_request`
  MODIFY `requestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `session_requests`
--
ALTER TABLE `session_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `subject_categories`
--
ALTER TABLE `subject_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teaching_materials`
--
ALTER TABLE `teaching_materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tutors`
--
ALTER TABLE `tutors`
  MODIFY `tutor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tutor_new`
--
ALTER TABLE `tutor_new`
  MODIFY `tutor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tutor_requests`
--
ALTER TABLE `tutor_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `payments_ibfk_3` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`tutor_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`tutor_id`),
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`);

--
-- Constraints for table `session_requests`
--
ALTER TABLE `session_requests`
  ADD CONSTRAINT `session_requests_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `session_requests_ibfk_2` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`tutor_id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `subject_categories` (`category_id`);

--
-- Constraints for table `teaching_materials`
--
ALTER TABLE `teaching_materials`
  ADD CONSTRAINT `teaching_materials_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`tutor_id`),
  ADD CONSTRAINT `teaching_materials_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE;

--
-- Constraints for table `tutor_requests`
--
ALTER TABLE `tutor_requests`
  ADD CONSTRAINT `tutor_requests_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`tutor_id`) ON DELETE CASCADE;

--
-- Constraints for table `tutor_subjects`
--
ALTER TABLE `tutor_subjects`
  ADD CONSTRAINT `tutor_subjects_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`tutor_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tutor_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
