-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 19, 2026 at 08:51 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scheduler_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('pending','confirmed','cancelled','rejected','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `doctor_id`, `patient_id`, `appointment_date`, `appointment_time`, `status`, `created_at`) VALUES
(6, 2, 4, '2026-01-04', '13:15:00', 'confirmed', '2026-01-03 09:51:41'),
(7, 2, 4, '2026-01-21', '08:00:00', 'pending', '2026-01-05 05:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
  `availability_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `available_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_booked` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `availability`
--

INSERT INTO `availability` (`availability_id`, `doctor_id`, `available_date`, `start_time`, `end_time`, `is_booked`) VALUES
(6, 2, '2026-01-04', '08:00:00', '17:00:00', 0),
(7, 2, '2026-01-21', '08:00:00', '17:00:00', 0),
(8, 2, '2026-01-09', '10:00:00', '13:00:00', 0),
(9, 2, '2026-01-10', '10:00:00', '13:00:00', 0),
(10, 2, '2026-01-11', '10:00:00', '13:00:00', 0),
(11, 2, '2026-01-12', '10:00:00', '13:00:00', 0),
(12, 2, '2026-01-13', '10:00:00', '13:00:00', 0),
(13, 2, '2026-01-14', '10:00:00', '13:00:00', 0),
(14, 2, '2026-01-15', '10:00:00', '13:00:00', 0),
(15, 2, '2026-01-16', '10:00:00', '13:00:00', 0),
(16, 2, '2026-01-17', '10:00:00', '13:00:00', 0),
(17, 2, '2026-01-18', '10:00:00', '13:00:00', 0),
(18, 2, '2026-01-19', '10:00:00', '13:00:00', 0),
(19, 2, '2026-01-20', '10:00:00', '13:00:00', 0),
(20, 2, '2026-01-22', '10:00:00', '13:00:00', 0),
(21, 2, '2026-01-23', '10:00:00', '13:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_profiles`
--

CREATE TABLE `doctor_profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `specialization` varchar(100) NOT NULL,
  `bio` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_profiles`
--

INSERT INTO `doctor_profiles` (`profile_id`, `user_id`, `specialization`, `bio`, `phone`) VALUES
(1, 2, 'Cardiologist', 'Expert in heart rhythm disorders and preventative cardiology. 10+ years experience.', '+8801700000001'),
(2, 3, 'Dermatologist', 'Specializing in cosmetic dermatology and laser treatments.', '+8801700000002'),
(3, 7, 'Dermatologist', NULL, NULL),
(4, 9, 'Neurologist', NULL, NULL),
(5, 11, 'Dermatologist', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','doctor','patient') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_approved` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password_hash`, `role`, `created_at`, `is_approved`) VALUES
(1, 'Admin User', 'admin@techspace.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-01-02 12:08:49', 1),
(2, 'Dr. Adnan Ratul', 'adnan@techspace.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'doctor', '2026-01-02 12:08:49', 1),
(3, 'Dr. Sarah Khan', 'sarah@techspace.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'doctor', '2026-01-02 12:08:49', 1),
(4, 'Rafid Abrar', 'rafid@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'patient', '2026-01-02 12:08:49', 1),
(5, 'Nusrat Jahan', 'nusrat@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'patient', '2026-01-02 12:08:49', 1),
(6, 'John', 'john@gmail.com', '$2y$10$nYPJscY5ZGItARxSwzTBkOrs9nYPt.VNcJ7wuycGhvQrLf5R7y68q', 'patient', '2026-01-05 15:22:31', 1),
(7, 'Deacon', 'deacon@gmail.com', '$2y$10$dwS8GTgAY1JvgFSDiOIij.T7OuzEzql9HAjav4BXnm6.eE3j5byM6', 'doctor', '2026-01-05 16:19:57', 1),
(8, 'Buzer', 'buzer@gmail.com', '$2y$10$9c5bKm/cjihGqqhPR7M5xO.AU1qQ2TGrLLeTrlzrL/WJ3iv0ek4mG', 'patient', '2026-01-05 16:20:52', 1),
(9, 'Aurthor Morgan', 'aurthor@gmail.com', '$2y$10$nztv5sO2Tm/QPYgkprCj8etN6t/iUqZmLYzM73G8YsDcb53afyvry', 'doctor', '2026-01-07 12:21:13', 1),
(10, 'Dutch Venderlin', 'dutch@gmail.com', '$2y$10$Vx9j20xZds/yfavt0WIshOtNmg4giRe7.j7fcCyfIJKTrB0/Fai3O', 'patient', '2026-01-07 12:27:02', 1),
(11, 'Sadie Adler', 'sadie@gmail.com', '$2y$10$SXjk8GDwH8YmuiaG.fBUyuG.bl3tdmR2U7qcJlzQ3CuTDKq8wEnly', 'doctor', '2026-01-07 12:27:33', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`availability_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctor_profiles`
--
ALTER TABLE `doctor_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `availability`
--
ALTER TABLE `availability`
  MODIFY `availability_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `doctor_profiles`
--
ALTER TABLE `doctor_profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `availability`
--
ALTER TABLE `availability`
  ADD CONSTRAINT `availability_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `doctor_profiles`
--
ALTER TABLE `doctor_profiles`
  ADD CONSTRAINT `doctor_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
