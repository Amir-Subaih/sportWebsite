-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2023 at 01:53 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sport`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `unique_id` int(15) NOT NULL,
  `username` varchar(15) NOT NULL,
  `comment` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`unique_id`, `username`, `comment`) VALUES
(848820767, 'al.ta54', 'my name is ali'),
(868069270, 'al.ta54', 'hi in my PC'),
(870113116, 'ah.su23', 'welcome in my websit '),
(1312198619, 'mo.km62', 'the website is good');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `f_name` varchar(60) NOT NULL,
  `l_name` varchar(60) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(100) NOT NULL,
  `birth_date` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `bio` varchar(1000) NOT NULL,
  `unique_id` int(100) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`f_name`, `l_name`, `username`, `email`, `password`, `birth_date`, `gender`, `bio`, `unique_id`, `status`) VALUES
('Ahmed', 'Subaih', 'ah.su23', 'tu3jdh@gmail.com', '1a92754ef29777509edecc77fcd36fe8', '2023-01-04', 'Male', 'welcome to home', 812073370, 'Active now'),
('Moner', 'Kmail', 'mo.km62', 'sobmy45@gmail.com', 'b0f8b3e58f093359fe1af416b5ea8ed6', '2023-01-02', 'Male', 'hi my dad welcome in my account ', 924081006, 'Active now'),
('Ali', 'Taleb', 'al.ta54', 'aa5614314@gmail.com', '25f9e794323b453885f5181f1b624d0b', '2023-01-01', 'Male', 'this is my account', 1464344179, 'Active now');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`unique_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD UNIQUE KEY `unique_id` (`unique_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
