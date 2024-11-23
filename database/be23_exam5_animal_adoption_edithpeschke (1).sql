-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2024 at 12:54 AM
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
-- Database: `be23_exam5_animal_adoption_edithpeschke`
--
CREATE DATABASE IF NOT EXISTS `be23_exam5_animal_adoption_edithpeschke` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `be23_exam5_animal_adoption_edithpeschke`;

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `breed` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `size` varchar(10) NOT NULL,
  `age` smallint(6) NOT NULL,
  `vaccine` varchar(3) NOT NULL DEFAULT 'YES',
  `picture` varchar(255) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'AVAILABLE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `breed`, `gender`, `location`, `description`, `size`, `age`, `vaccine`, `picture`, `status`) VALUES
(1, 'Poppy', 'Poodle', 'MALE', 'Vienna', 'Sometimes pets outlive their owners. Unfortunately, Poppy was one of them who had to cope with the death of her owner. After no one was able to look after her, she was handed in to us and is now looking for a nice new home. ', 'SMALL', 6, 'YES', '6740922e0493f.png', 'AVAILABLE'),
(2, 'Bobo', 'Shiba Inu', 'MALE', 'Wiener Neustadt', 'Only for experienced dog owners. There are no problems with sufficient exercise. Very affectionate.', 'SMALL', 3, 'NO', '674096b965878.png', 'ADOPTED'),
(3, 'Clara', 'Horse', 'MALE', 'Breitenfurt', 'Old, very cozy mare who needs a good place for her last days. Cuddly beginner mare.', 'LARGE', 15, 'YES', '674097864fc2c.png', 'AVAILABLE'),
(5, 'Fleur', 'Donkey', 'FEMALE', 'Eisenstadt', 'Old lady waiting for your support', 'LARGE', 12, 'YES', '6740d664c4b82.png', 'AVAILABLE'),
(6, 'Kassandra', 'Turtle', 'FEMALE', 'Tulln', 'Was handed in by an old lady who has had her for 20 years and would have liked to keep her. We are looking for long-term care.', 'SMALL', 25, 'YES', '6740d6ead43a3.png', 'AVAILABLE'),
(7, 'Siego', 'Rabbit', 'MALE', 'Vienna', 'Siego and eleven other rabbits were confiscated due to very poor care and brought to us. All of them were neglected, had eye infections and unkempt fur. They are now really thriving and are looking for a new home. Siego lives with us in a group in an outd', 'SMALL', 7, 'YES', '6740d7606f9a1.png', 'AVAILABLE'),
(10, 'Pauli', 'Hamster', 'MALE', 'Linz', 'Small little nice hamster waiting for you searching for a nice home.', 'SMALL', 5, 'YES', '6740e1d0eb181.png', 'AVAILABLE'),
(11, 'Viki', 'Snake', 'FEMALE', 'Purbach', 'Viki was found on a forest path and taken to a veterinary clinic for initial treatment. She was then taken to an animal shelter and is now looking for a good home. Viki currently lives alone and can be given to interested parties with previous experience.', 'SMALL', 15, 'YES', '6741af075751a.png', 'AVAILABLE'),
(12, 'Edda', 'Labrador', 'MALE', 'Vienna', 'Edda comes from an unplanned litter. Edda has not yet experienced much from a normal dogs life.', 'SMALL', 3, 'YES', '6741b2c604455.png', 'ADOPTED'),
(13, 'Lisa and Lola', 'Budgerigar', 'FEMALE', 'Purkersdorf', 'Lisa and Lola lived for a long time with an old woman who can no longer look after them. After a long illness, she unfortunately had to bring them to the shelter. They are very uncomplicated and we would only like to place them together.', 'SMALL', 10, 'NO', '6741b70ff095b.png', 'AVAILABLE'),
(14, 'Greteln', 'Chicken', 'MALE', 'Breitenfurt', 'By giving up a farm, a group of 30 chickens becomes available for allocation. ', 'SMALL', 3, 'YES', '6741b7b23ab4a.png', 'ADOPTED'),
(15, 'Filou', 'German Mastiff', 'MALE', 'Vienna', 'Filou was almost skin and bones when he was taken away from his owner by the authorities. For health reasons, he was no longer able to look after his male dog properly and no one else took care of him either. Since he has been with us, Filou has put on we', 'LARGE', 12, 'YES', '6741b8f0e466a.png', 'AVAILABLE');

-- --------------------------------------------------------

--
-- Table structure for table `pet_adoption`
--

CREATE TABLE `pet_adoption` (
  `adopt_int` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `adopt_date` date NOT NULL,
  `fk_user_id` int(11) DEFAULT NULL,
  `fk_animal_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_adoption`
--

INSERT INTO `pet_adoption` (`adopt_int`, `first_name`, `last_name`, `email`, `adopt_date`, `fk_user_id`, `fk_animal_id`) VALUES
(1, 'Yasmina', 'Peschke', 'yasmina2707@gmail.com', '2024-12-01', 3, 14),
(3, 'Marcel', 'Kadlec', 'marcel1@gmail.com', '2024-12-10', 6, 2),
(4, 'Yasmina', 'Peschke', 'yasmina2707@gmail.com', '2024-12-05', 3, 12);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `phone_number` varchar(30) DEFAULT NULL,
  `status` varchar(4) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `email`, `address`, `picture`, `phone_number`, `status`) VALUES
(3, 'Yasmina', 'Peschke', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'yasmina2707@gmail.com', '1230 Wien, Gregorygasse 19', '67406a670e99a.jpg', '6509938928', 'user'),
(4, 'Manfred', 'Zillinger', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'admin1@gmail.com', 'Grabenweg 12, 2230 Gänserndorf', '674200ed6efa4.png', '0699128866', 'adm'),
(6, 'Marcel', 'Kadlec', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'marcel1@gmail.com', '1100 Wien, Laxenburgerstrasse 39', '674200929f383.png', '06645287814', 'user'),
(7, 'Amelie', 'Deutsch', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'amelie1@gmail.com', 'Steinbruchweg 3, 7051 Grosshöflein', '6742013ce8c03.png', '06605874512', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD PRIMARY KEY (`adopt_int`),
  ADD KEY `fk_user_id` (`fk_user_id`),
  ADD KEY `fk_animal_id` (`fk_animal_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  MODIFY `adopt_int` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD CONSTRAINT `pet_adoption_ibfk_1` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pet_adoption_ibfk_2` FOREIGN KEY (`fk_animal_id`) REFERENCES `animals` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
