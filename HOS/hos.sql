-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 28, 2022 at 01:21 PM
-- Server version: 8.0.27
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hos`
--

-- --------------------------------------------------------

--
-- Table structure for table `appoinment`
--

DROP TABLE IF EXISTS `appoinment`;
CREATE TABLE IF NOT EXISTS `appoinment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patientName` varchar(225) NOT NULL,
  `AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `visitDate` date NOT NULL,
  `visitTime` time NOT NULL,
  `Symptoms` varchar(225) NOT NULL,
  `phno` bigint NOT NULL,
  `email` varchar(225) NOT NULL,
  `doctorName` varchar(225) NOT NULL,
  `status` varchar(225) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `appoinment`
--

INSERT INTO `appoinment` (`id`, `patientName`, `AT`, `visitDate`, `visitTime`, `Symptoms`, `phno`, `email`, `doctorName`, `status`) VALUES
(3, 'Abi', '2022-06-26 22:58:54', '2022-06-27', '10:40:00', 'fever', 9791521808, 'Doctor1@gmail.com', 'Doctor1', 'Completed'),
(2, 'prasanna', '2022-06-26 10:34:48', '2022-06-27', '10:10:00', 'fever', 9791521808, 'patient1@gmail.com', 'Doctor1', 'Completed'),
(4, 'prasanna', '2022-06-27 08:18:36', '2022-06-28', '15:50:00', 'stomachache', 9791521808, 'patient1@gmail.com', 'Doctor1', 'Completed'),
(5, 'prasanna', '2022-06-27 10:43:11', '2022-06-28', '18:07:00', 'fever', 9791521808, 'patient1@gmail.com', 'Doctor1', 'Pending'),
(6, 'prasanna', '2022-06-27 10:58:50', '2022-06-28', '20:32:00', 'cold', 9791521808, 'patient1@gmail.com', 'Doctor1', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

DROP TABLE IF EXISTS `bill`;
CREATE TABLE IF NOT EXISTS `bill` (
  `name` varchar(225) NOT NULL,
  `serviceCharge` int NOT NULL,
  `medFee` int NOT NULL,
  `visitId` int NOT NULL,
  `items` varchar(225) NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `billDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`name`, `serviceCharge`, `medFee`, `visitId`, `items`, `id`, `billDate`, `total`) VALUES
('prasanna', 500, 6, 1, 'Omeprazole 20 mg x 3', 1, '2022-06-26 16:54:44', 506),
('Abi', 500, 9, 2, 'Paracetamol x 3', 2, '2022-06-26 23:10:46', 509),
('prasanna', 500, 9, 3, 'Paracetamol x 3', 3, '2022-06-27 08:21:40', 509),
('prasanna', 500, 21, 3, 'Amoxicillin 500 mg x 3', 4, '2022-06-27 11:00:29', 521);

-- --------------------------------------------------------

--
-- Table structure for table `doctorvisit`
--

DROP TABLE IF EXISTS `doctorvisit`;
CREATE TABLE IF NOT EXISTS `doctorvisit` (
  `doctorName` varchar(225) NOT NULL,
  `patientName` varchar(225) NOT NULL,
  `visitTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Symptoms` varchar(225) NOT NULL,
  `Medicine` varchar(225) NOT NULL,
  `fees` int NOT NULL DEFAULT '500',
  `medCount` int NOT NULL,
  `inTake` varchar(225) NOT NULL,
  `remarks` varchar(225) NOT NULL,
  `diet` varchar(225) NOT NULL,
  `status` varchar(225) NOT NULL,
  `appoinmentid` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctorvisit`
--

INSERT INTO `doctorvisit` (`doctorName`, `patientName`, `visitTime`, `Symptoms`, `Medicine`, `fees`, `medCount`, `inTake`, `remarks`, `diet`, `status`, `appoinmentid`, `id`) VALUES
('Doctor1', 'prasanna', '2022-06-26 16:54:44', 'fever', 'Omeprazole 20 mg', 506, 3, '|MAF|NAF|', 'Good', 'soft diet', 'Completed', 2, 1),
('Doctor1', 'Abi', '2022-06-26 23:10:46', 'fever', 'Paracetamol', 509, 3, '|MAF|NAF|', 'Good', 'soft diet', 'Completed', 3, 2),
('Doctor1', 'prasanna', '2022-06-27 08:21:40', 'stomachache', 'Paracetamol', 521, 3, '|MAF|NAF|', 'Good', 'soft diet', 'Completed', 4, 3),
('Doctor1', 'prasanna', '2022-06-27 11:00:29', 'cold', 'Amoxicillin 500 mg', 521, 3, '|MAF|NAF|', 'Good', 'soft diet', 'Completed', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `role` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phno` bigint NOT NULL,
  `email` varchar(225) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`, `role`, `name`, `phno`, `email`) VALUES
('Patient1', '123', 'Patient', 'prasanna', 9791521808, 'patient1@gmail.com'),
('Patient2', '123', 'Patient', 'kishore', 9791521808, 'patient2@gmail.com'),
('Admin1', '123', 'Admin', 'Anshio', 9791521808, 'Admin1@gmail.com'),
('Doctor2', '123', 'Doctor', 'Kalees', 9791521808, 'doctor2@gmail.com'),
('Doctor1', '123', 'Doctor', 'Abi', 9791521808, 'doctor1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tablets`
--

DROP TABLE IF EXISTS `tablets`;
CREATE TABLE IF NOT EXISTS `tablets` (
  `medName` varchar(225) NOT NULL,
  `medCount` int NOT NULL,
  `medFee` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tablets`
--

INSERT INTO `tablets` (`medName`, `medCount`, `medFee`) VALUES
('Vitamin D 50,000 IU', 97, 25),
('Amoxicillin 500 mg', 91, 7),
('Cephalexin 500 mg', 94, 5),
('Omeprazole 20 mg', 91, 2),
('Paracetamol', 81, 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
