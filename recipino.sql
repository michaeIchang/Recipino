-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 26, 2018 at 11:09 PM
-- Server version: 5.6.34-log
-- PHP Version: 7.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipino`
--

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `username` varchar(255) NOT NULL,
  `recipe_name` varchar(255) NOT NULL DEFAULT '',
  `recipe_steps` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`username`, `recipe_name`, `recipe_steps`) VALUES
('user1', 'Chocolate Chip Cookies', 'Ingredients\r\n5 oz Butter\r\n2/3 cup Brown Sugar\r\n1/2 cup Granulated Sugar\r\n1 ea Eggs\r\n1 tsp Vanilla Extract\r\n1 cup Cake Flour\r\n3/4 cup Bread Flour\r\n2/3 tsp Baking Soda\r\n3/4 tsp Baking Powder\r\n3/4 tsp Salt\r\n8 oz Semi-sweet Chocolate Chips\r\n\r\nMethod\r\n1. Cream the Butter and Sugars\r\n2. Add Vanilla and Eggs - beat until incorporated\r\n3. Add Flour, Baking Powder, Baking Soda, and Salt\r\n4. When dough comes together, fold in chocolate chips - do not over-mix!\r\n5. Using room-temperature dough, scoop into balls and place on a lined sheet tray, arranging them in a staggered pattern\r\n6. Bake 350 for 10 minutes - when you remove them from the oven, drop the tray on the floor to \"flatten\" the cookies\r\n7. When cool, store/serve appropriately'),
('user1', 'Custom Recipe #1', 'Custom Recipe!'),
('user1', 'Custom Recipe #2', 'Custom Recipe'),
('user1', 'Custom Recipe #3', 'Custom Recipe'),
('user1', 'Custom Recipe #4', 'Custom Recipe'),
('user2', 'Chocolate Chip Cookies', 'Ingredients\r\n5 oz Butter\r\n2/3 cup Brown Sugar\r\n1/2 cup Granulated Sugar\r\n1 ea Eggs\r\n1 tsp Vanilla Extract\r\n1 cup Cake Flour\r\n3/4 cup Bread Flour\r\n2/3 tsp Baking Soda\r\n3/4 tsp Baking Powder\r\n3/4 tsp Salt\r\n8 oz Semi-sweet Chocolate Chips\r\n\r\nMethod\r\n1. Cream the Butter and Sugars\r\n2. Add Vanilla and Eggs - beat until incorporated\r\n3. Add Flour, Baking Powder, Baking Soda, and Salt\r\n4. When dough comes together, fold in chocolate chips - do not over-mix!\r\n5. Using room-temperature dough, scoop into balls and place on a lined sheet tray, arranging them in a staggered pattern\r\n6. Bake 350 for 10 minutes - when you remove them from the oven, drop the tray on the floor to \"flatten\" the cookies\r\n7. When cool, store/serve appropriately'),
('user2', 'Custom Recipe #1', 'Custom Recipe Changed!'),
('user2', 'Custom Recipe #2', 'Custom Recipe'),
('user2', 'Custom Recipe #3', 'Custom Recipe'),
('user2', 'Custom Recipe #4', 'Custom Recipe'),
('user3', 'Chocolate Chip Cookies', 'Ingredients\r\n5 oz Butter\r\n2/3 cup Brown Sugar\r\n1/2 cup Granulated Sugar\r\n1 ea Eggs\r\n1 tsp Vanilla Extract\r\n1 cup Cake Flour\r\n3/4 cup Bread Flour\r\n2/3 tsp Baking Soda\r\n3/4 tsp Baking Powder\r\n3/4 tsp Salt\r\n8 oz Semi-sweet Chocolate Chips\r\n\r\nMethod\r\n1. Cream the Butter and Sugars\r\n2. Add Vanilla and Eggs - beat until incorporated\r\n3. Add Flour, Baking Powder, Baking Soda, and Salt\r\n4. When dough comes together, fold in chocolate chips - do not over-mix!\r\n5. Using room-temperature dough, scoop into balls and place on a lined sheet tray, arranging them in a staggered pattern\r\n6. Bake 350 for 10 minutes - when you remove them from the oven, drop the tray on the floor to \"flatten\" the cookies\r\n7. When cool, store/serve appropriately'),
('user3', 'Custom Recipe #1', 'Custom Recipe'),
('user3', 'Custom Recipe #2', 'Custom Recipe'),
('user3', 'Custom Recipe #3', 'Custom Recipe'),
('user3', 'Custom Recipe #4', 'Custom Recipe');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`) VALUES
('user1', '$2y$10$aY/IO6MQce6.XJGD8BiVWO2LBidKRP6CVll9tS4jzOIh9oN57C2JS'),
('user2', '$2y$10$VtS1pvRrdCLFCYxpN7vnkuu8glDA/KnBb/BnrBSXTc1hB27/pqE7S'),
('user3', '$2y$10$CeUutwxLZUN5I3Q9oRG4qeKCQ5kCYy8BGhUPDyxSKElZ.8VXdLP8i');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`username`,`recipe_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
