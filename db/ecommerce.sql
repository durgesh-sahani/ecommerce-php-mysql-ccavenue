-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2018 at 12:33 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `quantity` tinyint(4) NOT NULL,
  `totalAmount` float NOT NULL,
  `createdOn` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `mobile` bigint(10) NOT NULL,
  `address` varchar(200) NOT NULL,
  `createdOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `mobile`, `address`, `createdOn`) VALUES
(1, 'Durgesh', 'durgesh@gmail.com', 9988776655, 'Pune', '2018-05-28 05:13:15');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `quantity` tinyint(4) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `orderStatus` tinyint(4) NOT NULL,
  `createdOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `cid`, `quantity`, `amount`, `orderStatus`, `createdOn`) VALUES
(1, 1, 2, 28030.00, 0, '2018-06-09 11:18:41'),
(2, 1, 2, 28030.00, 0, '2018-06-09 11:31:50'),
(3, 1, 1, 12010.00, 2, '2018-06-09 11:39:13'),
(4, 1, 1, 10010.00, 1, '2018-06-09 11:42:21'),
(5, 1, 2, 20020.00, 3, '2018-06-09 11:44:16'),
(6, 1, 2, 20020.00, 1, '2018-06-09 11:45:07');

-- --------------------------------------------------------

--
-- Table structure for table `workshops`
--

CREATE TABLE `workshops` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `description` varchar(500) NOT NULL,
  `image` varchar(200) NOT NULL,
  `createdOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `workshops`
--

INSERT INTO `workshops` (`id`, `title`, `price`, `description`, `image`, `createdOn`) VALUES
(1, 'PHP', '12000', 'PHP: Hypertext Preprocessor is a server-side scripting language designed for web development but also used as a general-purpose programming language.', 'php.png', '2018-05-28 07:35:26'),
(2, 'MySQL', '8000', 'MySQL is an open-source relational database management system.', 'mysql.png', '2018-05-28 07:39:53'),
(3, 'JavaScript', '10000', 'JavaScript, often abbreviated as JS, is a high-level, interpreted programming language.', 'js.png', '2018-05-28 07:39:53'),
(4, 'HTML & CSS', '8000', 'HTML Hypertext Markup Language) and CSS Cascading Style Sheets are two of the core technologies for building Web pages.', 'html_css.png', '2018-05-29 02:11:20');

-- --------------------------------------------------------

--
-- Table structure for table `workshop_seats`
--

CREATE TABLE `workshop_seats` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `wid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `createdOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `workshop_seats`
--

INSERT INTO `workshop_seats` (`id`, `tid`, `wid`, `quantity`, `createdOn`) VALUES
(1, 1, 1, 1, '2018-06-09 11:18:41'),
(2, 1, 2, 2, '2018-06-09 11:18:41'),
(3, 2, 1, 1, '2018-06-09 11:31:50'),
(4, 2, 2, 2, '2018-06-09 11:31:50'),
(5, 3, 1, 1, '2018-06-09 11:39:13'),
(6, 4, 3, 1, '2018-06-09 11:42:21'),
(7, 5, 1, 1, '2018-06-09 11:44:16'),
(8, 5, 4, 1, '2018-06-09 11:44:17'),
(9, 6, 1, 1, '2018-06-09 11:45:07'),
(10, 6, 4, 1, '2018-06-09 11:45:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workshops`
--
ALTER TABLE `workshops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workshop_seats`
--
ALTER TABLE `workshop_seats`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `workshops`
--
ALTER TABLE `workshops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `workshop_seats`
--
ALTER TABLE `workshop_seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
