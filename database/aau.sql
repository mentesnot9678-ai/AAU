-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2026 at 01:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aau`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `subject` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `first_name`, `last_name`, `subject`, `created_at`) VALUES
(1, 'SOSSINA ', 'KASSAYE ', 'TESTING CONTACT FORM ON HOME PAGE.', '2026-06-01 14:37:32');

-- --------------------------------------------------------

--
-- Table structure for table `driver_comments`
--

CREATE TABLE `driver_comments` (
  `id` int(11) NOT NULL,
  `driver_name` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Unread','Read') DEFAULT 'Unread',
  `reply` text DEFAULT NULL,
  `replied_by` varchar(100) DEFAULT NULL,
  `replied_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver_comments`
--

INSERT INTO `driver_comments` (`id`, `driver_name`, `message`, `created_at`, `status`, `reply`, `replied_by`, `replied_at`) VALUES
(1, '', 'Sample Comment ', '2026-05-31 11:45:40', 'Unread', NULL, NULL, NULL),
(2, 'Driver', 'Sample Comment ', '2026-05-31 11:47:13', 'Unread', NULL, NULL, NULL),
(3, 'Driver', 'Comment -2 \r\nThis is just a test ', '2026-05-31 11:48:17', 'Unread', NULL, NULL, NULL),
(4, 'mutexs', 'I have a problem with my front lights again.', '2026-06-01 09:08:32', '', 'Will be resolved, This is just a test to see if we can reply comments. ', 'Ezra ', '2026-06-01 12:13:35'),
(5, 'mutexs', 'I have a problem with my front lights again.', '2026-06-01 09:09:17', 'Unread', NULL, NULL, NULL),
(6, 'MIKI', 'we arrived adama ', '2026-06-01 15:23:06', '', 'okay\r\n', 'Ezra ', '2026-06-01 08:23:33'),
(7, 'mutexs', 'h hey boss', '2026-06-01 20:54:01', 'Read', 'what do you want', 'sosi', '2026-06-01 13:54:38'),
(8, 'mutexs', 'h hey boss', '2026-06-01 20:54:53', 'Read', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exit_requests`
--

CREATE TABLE `exit_requests` (
  `id` int(11) NOT NULL,
  `driver` varchar(100) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exit_requests`
--

INSERT INTO `exit_requests` (`id`, `driver`, `vehicle_id`, `reason`, `request_date`, `status`) VALUES
(1, 'mutexs', 1, 'Testing ', '2026-06-01 08:58:30', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `service_type` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `service_date` date NOT NULL,
  `maintenance_date` date DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`id`, `vehicle_id`, `service_type`, `description`, `service_date`, `maintenance_date`, `status`) VALUES
(1, 3, 'OIL REPAIR', 'FUll SERvice ', '2026-10-03', NULL, 'Unrepairable'),
(2, 1, 'FILTER ', 'TO BE FILTERED ', '2026-03-10', NULL, 'Fixed'),
(3, 5, 'Tyre Services ', 'Tyre Services exchange for both front tyres.', '2026-10-07', NULL, 'Completed'),
(4, 6, 'Oil Refil ', 'this is just a test ', '2026-12-04', NULL, 'Fixed'),
(5, 7, 'Oil Refil ', 'testing ', '2026-12-04', NULL, 'Fixed');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_requests`
--

CREATE TABLE `maintenance_requests` (
  `id` int(11) NOT NULL,
  `vehicle_plate` varchar(50) DEFAULT NULL,
  `issue` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mechanic_jobs`
--

CREATE TABLE `mechanic_jobs` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `plate_number` varchar(50) DEFAULT NULL,
  `problem` text DEFAULT NULL,
  `assigned_by` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `mechanic_report` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `issue` text DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `driver_id`, `issue`, `status`, `created_at`) VALUES
(1, 8, 'Testing Service Request ', 'Approved', '2026-04-07 11:56:43'),
(2, 8, 'Testing Service Request ', 'Fixed', '2026-04-07 12:07:04'),
(3, 8, 'Oil Change Request for tomorrow ', 'Fixed', '2026-04-07 12:07:29'),
(4, 8, 'Oil Change Request for tomorrow ', 'Fixed', '2026-04-07 12:09:11'),
(5, 8, 'Requesting Full Service Check Up ', 'Fixed', '2026-04-21 14:14:26'),
(6, 8, 'oil change ', 'Rejected', '2026-05-13 12:08:18'),
(7, 8, 'oil change ', 'Rejected', '2026-05-13 12:08:48'),
(8, 8, 'oil change ', 'Rejected', '2026-05-13 12:08:53'),
(9, 8, 'light change', 'Approved', '2026-05-13 12:09:49'),
(10, 8, 'light change', 'Approved', '2026-05-13 12:10:08'),
(11, 8, 'light change', 'Approved', '2026-05-13 12:10:13'),
(12, 8, 'light change', 'Approved', '2026-05-13 12:10:16'),
(13, 8, 'light change', 'Approved', '2026-05-13 12:10:19'),
(14, 8, 'light change', 'Approved', '2026-05-13 12:10:32'),
(15, 8, 'light change', 'Approved', '2026-05-13 12:12:30'),
(16, 8, 'light change', 'Rejected', '2026-05-13 12:12:35'),
(17, 8, 'add fuel', 'Rejected', '2026-05-13 12:21:16'),
(18, 25, 'paint', 'Fixed', '2026-05-23 16:39:50'),
(19, 25, 'oil chnge', 'Rejected', '2026-05-23 16:45:07'),
(23, 25, 'New Request show on manager and Mechnic this request', 'Sent to Mechanic', '2026-06-01 05:30:44'),
(24, 25, 'New Request For Body Paint', 'Sent to Mechanic', '2026-06-01 12:05:10'),
(25, 25, 'New Request For Body Paint', 'Sent to Mechanic', '2026-06-01 13:10:56'),
(26, 25, 'New Request Oil Filter', 'Sent to Mechanic', '2026-06-01 13:13:42'),
(27, 25, 'Tires Exchange- Both front wheel tire s', 'Sent to Mechanic', '2026-06-01 13:30:14'),
(28, 25, 'New Request for back Tires exchange', 'Sent to Mechanic', '2026-06-01 13:36:30'),
(29, 25, 'Exchange For wheel Drive', 'Rejected', '2026-06-01 13:36:53'),
(30, 31, 'chair belt replacement', 'Sent to Mechanic', '2026-06-01 15:15:22'),
(31, 31, 'lamp replacement', 'Sent to Mechanic', '2026-06-01 15:16:27'),
(32, 31, 'air house', 'Sent to Mechanic', '2026-06-01 15:43:29'),
(33, 31, 'door maintenance', 'Sent to Mechanic', '2026-06-01 15:46:15'),
(34, 25, 'paint', 'Unrepairable', '2026-06-01 16:21:53');

-- --------------------------------------------------------

--
-- Table structure for table `staff_comments`
--

CREATE TABLE `staff_comments` (
  `id` int(11) NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Unread','Read') DEFAULT 'Unread',
  `reply` text DEFAULT NULL,
  `replied_by` varchar(100) DEFAULT NULL,
  `replied_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_comments`
--

INSERT INTO `staff_comments` (`id`, `staff_name`, `message`, `created_at`, `status`, `reply`, `replied_by`, `replied_at`) VALUES
(1, 'seada', 'Staff Message Request Testing ', '2026-05-31 11:57:21', 'Read', 'rEAD STAFF MESSAGE , HI SEADA ', 'Ezra ', '2026-06-01 12:22:25'),
(2, 'Ezra - Staff', 'This Is The Staff Sedning Message to the manager, testing Hi.', '2026-06-01 13:11:41', 'Read', 'Hi from Manager , message recived. \r\n', 'Ezra ', '2026-06-01 16:14:03'),
(3, 'Ezra - Staff', 'This Is The Staff Sedning Message to the manager, testing Hi.', '2026-06-01 13:14:16', 'Unread', NULL, NULL, NULL),
(4, 'seada', 'hey bosss', '2026-06-01 15:21:52', 'Read', 'what can i help you', 'Ezra ', '2026-06-01 08:22:21'),
(5, 'seada', 'hey can i get a service', '2026-06-01 20:56:04', 'Read', 'no', 'sosi', '2026-06-01 13:57:03'),
(6, 'seada', 'hey can i get a service', '2026-06-01 20:57:20', 'Unread', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `driver` varchar(100) DEFAULT NULL,
  `destination` varchar(200) DEFAULT NULL,
  `trip_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `staff` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `vehicle_id`, `driver`, `destination`, `trip_date`, `status`, `created_at`, `staff`) VALUES
(3, 3, 'Hayat Nuredin ', 'ADDIS ABABA', '0000-00-00', 'Approved', '2026-05-31 11:02:39', NULL),
(4, 5, 'sossina', 'ADDIS ABABA', '2026-12-05', 'Approved', '2026-05-31 11:02:39', NULL),
(5, 6, 'Sossina ', 'ADDIS ABABA', '2026-10-04', 'Approved', '2026-05-31 11:02:39', NULL),
(6, 3, 'Sossina ', 'ADAMA', '2026-02-01', 'Approved', '2026-05-31 11:02:39', NULL),
(9, 3, 'seada', 'ADDIS ABABA', '0206-10-06', 'Rejected', '2026-05-31 11:02:39', NULL),
(10, 3, 'seada', 'ADDIS ABABA', '2026-03-10', 'Approved', '2026-05-31 11:02:39', NULL),
(11, 3, 'seada', 'ADDIS ABABA', '2026-03-10', 'Pending Manager Approval', '2026-05-31 11:02:39', NULL),
(12, 3, 'seada', 'ADDIS ABABA', '2026-03-10', 'Rejected', '2026-05-31 11:02:39', NULL),
(16, 1, 'seada', 'MOJO', '2026-05-31', 'Pending Manager Approval', '2026-05-31 11:02:39', NULL),
(17, 5, 'Test Driver Mintesiont ', 'ADAAMA', '2026-06-17', 'Pending', '2026-06-01 06:04:02', NULL),
(18, 5, 'mutexs', 'ADDIS ABABA', '2026-06-20', 'Completed', '2026-06-01 06:06:31', NULL),
(19, 6, '', 'Adama ', '2026-06-27', 'Pending', '2026-06-01 06:08:31', NULL),
(20, 3, '', 'Addis Ababa ', '2026-10-07', 'Pending Manager Approval', '2026-06-01 06:11:13', NULL),
(21, 7, 'mutexs', 'Adama ', '2026-06-03', 'Pending Manager Approval', '2026-06-01 06:11:39', NULL),
(22, 5, 'MIKI', 'ADDIS ABABA UNIVERISTY ', '2026-06-03', 'Approved', '2026-06-01 06:51:48', NULL),
(23, 5, 'MIKI', 'akaki kaliti', '2026-06-02', 'Approved', '2026-06-01 15:37:49', NULL),
(24, 5, 'seada', 'kebena', '2026-06-15', 'Pending Manager Approval', '2026-06-01 16:44:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `status`) VALUES
(1, 'admin', NULL, 'admin123', 'admin', '2026-04-02 10:01:02', 'active'),
(8, 'sosi', 'sosina@gmail.com', '123456', 'manager', '2026-04-06 13:20:58', 'active'),
(21, 'hayat', NULL, '123456', 'Mechanic', '2026-05-23 15:14:37', 'active'),
(23, 'seada', NULL, '123456', 'staff', '2026-05-23 15:15:20', 'active'),
(25, 'mutexs', 'mutex@gmail.com', '123456', 'driver', '2026-05-23 15:51:36', 'active'),
(27, 'Ezra ', NULL, '123456', 'Manager', '2026-06-01 05:03:14', 'active'),
(31, 'MIKI', 'mmikemeti@gmail.com', '$2y$10$54LaHr9g0Ux5zrg0wtudpemdsBSC.ep2DkpRN6s5H6CI3xT9vc4me', 'driver', '2026-06-01 06:52:42', 'active'),
(32, 'Ezra - Staff', '', '$2y$10$UmE52ArV4C/hcATPtTcdK.bLEtZt8IltJSMB6/wxoX3iEtawhR8Bu', 'staff', '2026-06-01 08:07:35', 'active'),
(33, 'admin mentesnot', NULL, '$2y$10$L8GHXngbfaV8EWNLDvk1I.xK2097OtsgbYnBmCTjjMxjmD6U4bnX.', 'admin', '2026-06-01 15:13:18', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `vehicle_name` varchar(100) DEFAULT NULL,
  `plate_number` varchar(50) DEFAULT NULL,
  `driver` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `service` text DEFAULT '',
  `service_date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT '',
  `lat` double DEFAULT 9.03,
  `lng` double DEFAULT 38.74
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_name`, `plate_number`, `driver`, `status`, `service`, `service_date`, `location`, `lat`, `lng`) VALUES
(1, 'TOYOTA', 'AA00890', 'Ezra Atlaw', 'Active', 'Gas Leak ', '2026-11-03', '9.033834759533283, 38.763692424239544', 9.03, 38.74),
(3, 'BYD E2', 'AA00890', 'Sossina ', 'Active', 'Oil Change ', '2026-01-04', 'https://maps.app.goo.gl/3QBbn7zadcraUkTg8', 9.03, 38.74),
(5, 'HILUX', 'AA58055', 'Hayat Nuredin ', 'Active', 'Tyres Exchange ', '2024-10-10', '9.02254306580428, 38.85406001716947', 9.03, 38.74),
(6, 'BYD ', 'AA00053', 'Mintesinot ', 'Active', 'Oil Refil ', '2025-12-04', '', 9.03, 38.74),
(7, 'RAV4', 'BB00988', 'mutex', 'Active', '', '2026-12-04', '', 9.03, 38.74);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_assignments`
--

CREATE TABLE `vehicle_assignments` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `assigned_date` datetime DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_comments`
--
ALTER TABLE `driver_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exit_requests`
--
ALTER TABLE `exit_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mechanic_jobs`
--
ALTER TABLE `mechanic_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `staff_comments`
--
ALTER TABLE `staff_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_assignments`
--
ALTER TABLE `vehicle_assignments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `driver_comments`
--
ALTER TABLE `driver_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `exit_requests`
--
ALTER TABLE `exit_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mechanic_jobs`
--
ALTER TABLE `mechanic_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `staff_comments`
--
ALTER TABLE `staff_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vehicle_assignments`
--
ALTER TABLE `vehicle_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD CONSTRAINT `service_requests_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
