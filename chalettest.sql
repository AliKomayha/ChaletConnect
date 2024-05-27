-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2024 at 03:40 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chalettest`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `cuid` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `status` text NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `cid`, `cuid`, `booking_date`, `status`) VALUES
(1, 2, 1, '2024-05-29', 'Canceled by customer'),
(2, 1, 1, '2024-05-30', 'Accepted'),
(3, 2, 4, '2024-06-18', 'Accepted'),
(4, 5, 4, '2024-06-29', 'Pending'),
(5, 1, 4, '2024-05-24', 'Declined');

-- --------------------------------------------------------

--
-- Table structure for table `caccount`
--

CREATE TABLE `caccount` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `cid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `caccount`
--

INSERT INTO `caccount` (`id`, `username`, `password`, `cid`) VALUES
(1, 'mahdikomayha', 'f5bb0c8de146c67b44babbf4e6584cc0', 1),
(2, 'mariamkomayha', 'f5bb0c8de146c67b44babbf4e6584cc0', 2),
(3, 'nourkomayha', 'f5bb0c8de146c67b44babbf4e6584cc0', 3),
(4, 'najwakomayha', 'f5bb0c8de146c67b44babbf4e6584cc0', 4);

-- --------------------------------------------------------

--
-- Table structure for table `chalet`
--

CREATE TABLE `chalet` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `oid` int(11) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `rooms` int(11) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chalet`
--

INSERT INTO `chalet` (`id`, `name`, `location`, `description`, `price`, `oid`, `capacity`, `rooms`, `status`) VALUES
(1, 'Komayha Chalet', 'Kfarsir, Al Nabaa', 'lalala la la la la l a\\r\\nlala     lalalalal lala lala ', 150, 1, 5, 4, 'available'),
(2, 'Chalet Al Reef ', 'Kfarsir, Al Naher', 'alksa sj    saidjoaiosjdoiajsd!!!!!!!!! ijdoasjdoiasjdoiasjdasiojd', 180, 1, 7, 5, 'available'),
(3, 'Mimo Chalet', 'Nabatieh', 'isjadiasjd            iaosdojasdiopja sijsodpaj apio dasjdi', 200, 2, 7, 6, 'available'),
(4, 'Janoub Chalet', 'Nabatieh', 'kkkkkkkkkkkkkkkkkkkkkkk\\r\\nkkkkkkkkk\\r\\nkkkk\\r\\nk\\r\\nkkkk\\r\\nkkk\\r\\nkkk', 100, 2, 4, 3, 'available'),
(5, 'AL SAHA', 'Kfaromen', 'kkklllllllllllllllllllllll \\r\\nl\\r\\n\\r\\n\\r\\nlsjw', 120, 2, 4, 4, 'available'),
(6, 'Chalet Rizk', 'Dweir', 'kkkkkkkk\\r\\nMountain View', 100, 5, 3, 2, 'available'),
(7, 'Todo\\\'s', 'Jebaa', 'samdklsadklsadjksa', 80, 3, 3, 1, 'available');

-- --------------------------------------------------------

--
-- Table structure for table `chalet_pictures`
--

CREATE TABLE `chalet_pictures` (
  `id` int(11) NOT NULL,
  `cid` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `main_image` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chalet_pictures`
--

INSERT INTO `chalet_pictures` (`id`, `cid`, `url`, `main_image`) VALUES
(1, 1, 'uploads/783e557802725de96afa82c301444c14.jpg', 1),
(2, 1, 'uploads/3224-exterior.jpg', 0),
(3, 1, 'uploads/Al-Paca-pool-1.jpg', 0),
(4, 1, 'uploads/b42f59477145c67955c35664870f1a9999435700.jpg', 0),
(5, 1, 'uploads/Mon-Izba.jpg', 0),
(6, 2, 'uploads/3224-exterior.jpg', 1),
(7, 2, 'uploads/Al-Paca-pool-1.jpg', 0),
(8, 2, 'uploads/chalet-kitchen-view-to-rear.jpg', 0),
(9, 2, 'uploads/mountain-view-chalets.jpg', 0),
(10, 2, 'uploads/view-from-garden-view.jpg', 0),
(11, 3, 'uploads/chalet-kitchen-view-to-rear.jpg', 1),
(12, 3, 'uploads/luxury-chalet-grande-corniche-les-gets-outdoor-pool-night.jpg', 0),
(13, 3, 'uploads/492758639.jpg', 0),
(14, 3, 'uploads/ajar16e853152493e3017f6893efb4386bf9.jpeg', 0),
(15, 3, 'uploads/b42f59477145c67955c35664870f1a9999435700.jpg', 0),
(16, 3, 'uploads/be3c5547a8091b2aea2d930752e06643.jpg', 0),
(17, 4, 'uploads/484758089.jpg', 1),
(18, 4, 'uploads/Al-Paca-pool-1.jpg', 0),
(19, 4, 'uploads/be3c5547a8091b2aea2d930752e06643.jpg', 0),
(20, 5, 'uploads/783e557802725de96afa82c301444c14.jpg', 1),
(21, 5, 'uploads/ajar16e853152493e3017f6893efb4386bf9.jpeg', 0),
(22, 5, 'uploads/b42f59477145c67955c35664870f1a9999435700.jpg', 0),
(23, 5, 'uploads/luxury-chalet-grande-corniche-les-gets-outdoor-pool-night.jpg', 0),
(24, 6, 'uploads/492758639.jpg', 1),
(25, 6, 'uploads/ajar16e853152493e3017f6893efb4386bf9.jpeg', 0),
(26, 6, 'uploads/b42f59477145c67955c35664870f1a9999435700.jpg', 0),
(27, 6, 'uploads/mountain-view-chalets.jpg', 0),
(28, 7, 'uploads/b42f59477145c67955c35664870f1a9999435700.jpg', 1),
(29, 7, 'uploads/Mon-Izba.jpg', 0),
(30, 7, 'uploads/view-from-garden-view.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `chalet_services`
--

CREATE TABLE `chalet_services` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `sid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chalet_services`
--

INSERT INTO `chalet_services` (`id`, `cid`, `sid`) VALUES
(3, 1, 1),
(1, 1, 3),
(2, 1, 5),
(8, 2, 1),
(7, 2, 2),
(5, 2, 3),
(4, 2, 4),
(6, 2, 5),
(12, 3, 1),
(11, 3, 2),
(9, 3, 4),
(10, 3, 5),
(14, 4, 1),
(13, 4, 2),
(19, 5, 1),
(18, 5, 2),
(16, 5, 3),
(15, 5, 4),
(17, 5, 5),
(22, 6, 1),
(21, 6, 2),
(20, 6, 4),
(26, 7, 1),
(25, 7, 2),
(24, 7, 6),
(23, 7, 9);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `phone` int(11) NOT NULL,
  `email` text NOT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `fname`, `lname`, `phone`, `email`, `address`) VALUES
(1, 'Mahdi', 'Komayha', 3901803, 'mahdi@gmail.com', NULL),
(2, 'Mariam', 'Komayha', 71232321, 'komayhamaryam@gmail.com', NULL),
(3, 'Nour', 'Komayha', 71572980, 'nourkomayha@gmail.com', NULL),
(4, 'Najwa', 'Komayha', 70096542, 'najwakomayha123@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oaccount`
--

CREATE TABLE `oaccount` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `oid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oaccount`
--

INSERT INTO `oaccount` (`id`, `username`, `password`, `oid`) VALUES
(1, 'alikomayha', 'f5bb0c8de146c67b44babbf4e6584cc0', 1),
(2, 'mariamkomayha', 'f5bb0c8de146c67b44babbf4e6584cc0', 2),
(3, 'fatimarizk', 'f5bb0c8de146c67b44babbf4e6584cc0', 3),
(4, 'batoulrizk', 'f5bb0c8de146c67b44babbf4e6584cc0', 4),
(5, 'ahmadrizk', 'f5bb0c8de146c67b44babbf4e6584cc0', 5);

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `id` int(11) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `email` text NOT NULL,
  `phone` int(11) NOT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`id`, `fname`, `lname`, `email`, `phone`, `address`) VALUES
(1, 'Ali', 'Komayha', 'allikomayha789@gmail.com', 71435483, NULL),
(2, 'mariam', 'komayha', 'komayhamaryam@gmail.com', 70052776, NULL),
(3, 'Fatima', 'Rizk', 'fatimarizk@outlook.com', 78543562, NULL),
(4, 'Batoul', 'Rizk', 'batoulrizk@gmail.com', 78662563, NULL),
(5, 'Ahmad', 'Rizk', 'ahmadrizk@gmail.com', 71628829, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`) VALUES
(4, 'Air Conditioning'),
(9, 'BBQ'),
(3, 'Fire Place'),
(6, 'Garden'),
(5, 'Kitchen'),
(8, 'Parking'),
(7, 'Sauna'),
(2, 'Swimming Pool'),
(1, 'Wi-Fi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chaletBooking` (`cid`),
  ADD KEY `customerBooking` (`cuid`);

--
-- Indexes for table `caccount`
--
ALTER TABLE `caccount`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING HASH,
  ADD KEY `customerAccount` (`cid`);

--
-- Indexes for table `chalet`
--
ALTER TABLE `chalet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oid` (`oid`);

--
-- Indexes for table `chalet_pictures`
--
ALTER TABLE `chalet_pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `chalet_services`
--
ALTER TABLE `chalet_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cid` (`cid`,`sid`),
  ADD KEY `sid` (`sid`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oaccount`
--
ALTER TABLE `oaccount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ownerAccount` (`oid`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `caccount`
--
ALTER TABLE `caccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chalet`
--
ALTER TABLE `chalet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `chalet_pictures`
--
ALTER TABLE `chalet_pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `chalet_services`
--
ALTER TABLE `chalet_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `oaccount`
--
ALTER TABLE `oaccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `chaletBooking` FOREIGN KEY (`cid`) REFERENCES `chalet` (`id`),
  ADD CONSTRAINT `customerBooking` FOREIGN KEY (`cuid`) REFERENCES `customer` (`id`);

--
-- Constraints for table `caccount`
--
ALTER TABLE `caccount`
  ADD CONSTRAINT `customerAccount` FOREIGN KEY (`cid`) REFERENCES `customer` (`id`);

--
-- Constraints for table `chalet`
--
ALTER TABLE `chalet`
  ADD CONSTRAINT `chalet_ibfk_1` FOREIGN KEY (`oid`) REFERENCES `owner` (`id`);

--
-- Constraints for table `chalet_pictures`
--
ALTER TABLE `chalet_pictures`
  ADD CONSTRAINT `chalet_pictures_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `chalet` (`id`);

--
-- Constraints for table `chalet_services`
--
ALTER TABLE `chalet_services`
  ADD CONSTRAINT `chalet_services_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `chalet` (`id`),
  ADD CONSTRAINT `chalet_services_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `services` (`id`);

--
-- Constraints for table `oaccount`
--
ALTER TABLE `oaccount`
  ADD CONSTRAINT `ownerAccount` FOREIGN KEY (`oid`) REFERENCES `owner` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
