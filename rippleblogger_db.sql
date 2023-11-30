-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3309
-- Generation Time: Nov 28, 2023 at 01:04 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rippleblogger_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`) VALUES
(14, 'uncategory', 'uncategory'),
(21, 'Science and Technology', 'science and technology related things'),
(22, 'Art', 'art&#13;&#10;'),
(23, 'Programming', 'Programming'),
(24, 'Artificial Inteligents', 'Artificial Inteligents'),
(25, 'Relationship', 'Relationship');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) UNSIGNED NOT NULL,
  `post_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `body`, `created_at`) VALUES
(1, 21, 13, 'hello', '2023-11-27 15:39:48'),
(2, 21, 13, 'another comment', '2023-11-27 15:46:13'),
(3, 21, 13, 'hello sri lanka', '2023-11-27 15:49:36'),
(4, 21, 13, 'Machine Learning, the backbone of Artificial Intelligence, transforms computers into learning entities. This article serves as a primer on the foundations of machine learning, exploring concepts such as supervised and unsupervised learning, neural networks, and algorithms. From predicting use', '2023-11-27 15:57:08'),
(20, 20, 16, 'e process, turning challenges into opportunities for learning and growth. From breakpoints to print statements, mastering the art of debugging is a journey every programmer undertakes, enriching their coding prowess and resilience.', '2023-11-27 20:22:36'),
(23, 21, 16, 'yeah fucking update function is working !', '2023-11-27 20:42:21'),
(24, 21, 16, 'ithms. From predicting user preferences to optimizing processes, machine learning&#039;s real-world applications are vast and ever-expanding. As we demystify the complexities of this transformative technology, we unveil the potential it holds for revolutionizing industries and shaping the future of AI-driven innovati', '2023-11-27 21:13:59'),
(25, 21, 16, 'ithms. From predicting user preferences to optimizing processes, machine learning&#039;s real-world applications are vast and ever-expanding. As we demystify the complexities of this transformative technology, we unveil the potential it holds for revolutionizing industries and shaping the future of AI-driven innovati', '2023-11-27 21:14:04'),
(26, 21, 13, 'fuck like and dislike sucks!!!', '2023-11-27 22:10:55'),
(27, 20, 13, 'ints to print statements, ', '2023-11-27 22:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `likes_dislikes`
--

CREATE TABLE `likes_dislikes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` enum('like','dislike') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes_dislikes`
--

INSERT INTO `likes_dislikes` (`id`, `post_id`, `user_id`, `action`, `created_at`) VALUES
(5, 21, 16, 'dislike', '2023-11-27 22:04:11'),
(21, 20, 13, 'like', '2023-11-27 22:41:04'),
(43, 21, 13, 'dislike', '2023-11-28 00:02:06');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) UNSIGNED DEFAULT NULL,
  `author_id` int(11) UNSIGNED NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  `comments_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `thumbnail`, `date_time`, `category_id`, `author_id`, `is_featured`, `comments_count`) VALUES
(20, 'The Art of Debugging: Mastering the Detective Work in Programming', 'Debugging, often likened to detective work, is an integral skill for programmers. In this article, we unravel the nuances of effective debugging, from identifying common errors to utilizing debugging tools. \r\nDebugging is not merely about fixing code; it&#039;s a methodical approach to problem-solving that enhances a programmer&#039;s analytical skills. \r\nAs we navigate through the art of debugging, we uncover strategies to streamline the process, turning challenges into opportunities for learning and growth. From breakpoints to print statements, mastering the art of debugging is a journey every programmer undertakes, enriching their coding prowess and resilience.', '1700506511blog14.jpg', '2023-11-20 18:54:27', 14, 17, 0, 2),
(21, 'Demystifying Machine Learning: A Primer on the Foundations of AI', 'Machine Learning, the backbone of Artificial Intelligence, transforms computers into learning entities. This article serves as a primer on the foundations of machine learning, exploring concepts such as supervised and unsupervised learning, neural networks, and algorithms. From predicting user preferences to optimizing processes, machine learning&#039;s real-world applications are vast and ever-expanding. As we demystify the complexities of this transformative technology, we unveil the potential it holds for revolutionizing industries and shaping the future of AI-driven innovation.', '1700506616blog54.jpg', '2023-11-20 18:56:56', 24, 13, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `is_admin`) VALUES
(13, 'alen', 'walker', 'alen', 'alen@gmail.com', '$2y$10$8JlhjQtMD860V5mOpzP/huY8jCP2pWttPdgttNnnd15lG3GXS9NMG', '1700495822avatar1.jpg', 1),
(16, 'Nora', 'walker', 'nora', 'nora@gmail.com', '$2y$10$LYH8hdQACgNfPkCgk4x6P.jif5/oztgZkZzLoB0b.U/yc5/zk5.xi', '1700505662avatar5.jpg', 0),
(17, 'jerry', 'adam', 'jerry', 'jerry@gmail.com', '$2y$10$.e/rehMBqKX/XtSltopD5eZ7Lseev/lgUGRGGUNZL74zepeMunCxe', '1700506378avatar10.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_post_id` (`post_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `likes_dislikes`
--
ALTER TABLE `likes_dislikes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_vote` (`post_id`,`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_blog_category` (`category_id`),
  ADD KEY `FK_blog_author` (`author_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `likes_dislikes`
--
ALTER TABLE `likes_dislikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_blog_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_blog_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
