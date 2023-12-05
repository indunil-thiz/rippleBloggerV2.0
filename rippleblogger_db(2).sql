-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3309
-- Generation Time: Dec 05, 2023 at 03:14 PM
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
(1, 'uncategory', 'Discover a diverse collection of topics that defy categorization. From eclectic musings to random thoughts, this category is a melting pot of ideas that don&#39;t neatly fit into traditional classifications. Expect the unexpected and explore the uncharted territories of creativity and curiosity. Whether it&#39;s a personal anecdote, a spontaneous reflection, or an unconventional exploration, the &#34;Uncategorized&#34; section is a space for the unplanned and the uniquely unclassifiable. Embark on a journey where each post promises surprise and invites readers to embrace the unpredictable nature of life&#39;s various facets.&#13;&#10;'),
(2, 'Technology Trends', 'Explore the latest advancements in technology, gadgets, and software. Discuss how these innovations impact daily life and industries.'),
(3, 'Travel Adventures', 'Share personal travel experiences, tips, and destination guides. Inspire readers to explore new places and cultures.'),
(4, 'Health and Wellness', 'Cover topics related to physical and mental health, fitness routines, healthy recipes, and overall well-being.'),
(5, 'Food and Cooking', 'Feature recipes, cooking tips, and food-related stories. Explore different cuisines and culinary experiences.'),
(6, 'Personal Finance', 'Offer advice on budgeting, saving, investing, and managing personal finances for a secure financial future.'),
(7, 'Sport', 'article related to the difference sports'),
(8, 'Hand Craft', 'hand craft things');

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

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'indunil jay', 'induexample@gmail.com', 'contact me', '2023-12-05 12:17:01'),
(2, 'jessica', 'jesi@gmail.com', 'providing a tantalizing glimpse of the Andean landscape. As the train winds its way through narrow valleys and lush greenery, anticipation builds for the grand reveal of Machu Picchu.\r\n\r\nUpon arrival at the site, travelers are greeted by the iconic sun gate, Inti Punku, offering the first panoramic view of the ancient city. Walking through the intricate stone structures, terraced fields, and ceremonial plazas, one can\'t help but marvel at the precision with which the Incas crafted this architectural marvel. The Temple of the Sun, the Room of the Three Windows, and the Intihuatana stone are just a few of the highlights that transport visitors back in time.', '2023-12-05 12:22:22');

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
(44, 24, 19, 'like', '2023-12-05 11:14:17');

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
(22, 'Smart Strategies for Building Your Emergency Fund', 'In today&#039;s unpredictable world, having a robust emergency fund is crucial for financial stability. Whether unexpected medical expenses or sudden job loss, unforeseen circumstances can arise at any moment. To safeguard your financial well-being, consider implementing these smart strategies to build and maintain a solid emergency fund.<br />\r\n<br />\r\nEmergencies often come unannounced, so start by setting a realistic monthly savings goal. Allocate a portion of your income specifically for this fund. Cutting down on non-essential expenses can free up more money for your savings. Automating this process through direct transfers to a dedicated savings account ensures consistency.<br />\r\n<br />\r\nExplore high-interest savings accounts to make your emergency fund work for you. While traditional savings accounts offer safety, accounts with higher interest rates enable your money to grow over time. Additionally, consider diversifying your emergency fund by incorporating low-risk investments to potentially increase returns.<br />\r\n<br />\r\nRegularly review and adjust your savings goals to accommodate changes in your financial situation. A salary increase or decrease, major life events, or changes in expenses may necessitate adjustments to your emergency fund strategy. Being proactive in reassessing your financial goals ensures that you&#039;re adequately prepared for whatever life throws your way.<br />\r\n<br />\r\nRemember, an emergency fund isn&#039;t just about the amount saved but also about having quick access to funds when needed. Having a well-thought-out emergency plan can provide peace of mind and financial security for you and your loved ones.', '1701772892pexels-tima-miroshnichenko-6693661.jpg', '2023-12-05 09:26:51', 6, 1, 0, 0),
(23, 'The Rise of Artificial Intelligence in Everyday Life', 'While blockchain technology gained prominence through cryptocurrencies like Bitcoin, its applications extend far beyond the realm of digital currencies. This article delves into the diverse uses of blockchain and its potential to reshape industries ranging from finance to supply chain management.<br />\r\n<br />\r\nBlockchain is essentially a decentralized, tamper-resistant ledger that records transactions across multiple computers. In finance, it offers transparency and security by eliminating the need for intermediaries. Smart contracts, self-executing contracts with the terms of the agreement directly written into code, streamline and automate complex financial processes.<br />\r\n<br />\r\nSupply chain management is another sector where blockchain is making significant inroads. By providing a transparent and immutable record of every transaction along the supply chain, blockchain enhances traceability, reduces fraud, and ensures the authenticity of products. This is particularly crucial in industries where the origin and authenticity of goods are paramount.<br />\r\n<br />\r\nBeyond these sectors, blockchain technology is also being explored in healthcare for secure and interoperable patient records, in voting systems to enhance the integrity of elections, and in the legal industry for smart contracts and transparent legal processes.<br />\r\n<br />\r\nAs the technology continues to evolve, its potential applications are likely to grow even further. Embracing blockchain&#039;s decentralized and transparent nature has the potential to revolutionize the way we conduct business and interact in various facets of our lives.<br />\r\n', '1701775187pexels-cottonbro-studio-8721318(1).jpg', '2023-12-05 10:52:36', 2, 19, 1, 0),
(24, 'Blockchain Technology: Beyond Cryptocurrencies', 'While blockchain technology gained prominence through cryptocurrencies like Bitcoin, its applications extend far beyond the realm of digital currencies. This article delves into the diverse uses of blockchain and its potential to reshape industries ranging from finance to supply chain management.<br />\r\n<br />\r\n<br />\r\n<br />\r\nBlockchain is essentially a decentralized, tamper-resistant ledger that records transactions across multiple computers. In finance, it offers transparency and security by eliminating the need for intermediaries. Smart contracts, self-executing contracts with the terms of the agreement directly written into code, streamline and automate complex financial processes.<br />\r\n<br />\r\n<br />\r\n<br />\r\nSupply chain management is another sector where blockchain is making significant inroads. By providing a transparent and immutable record of every transaction along the supply chain, blockchain enhances traceability, reduces fraud, and ensures the authenticity of products. This is particularly crucial in industries where the origin and authenticity of goods are paramount.<br />\r\n<br />\r\n<br />\r\n<br />\r\nBeyond these sectors, blockchain technology is also being explored in healthcare for secure and interoperable patient records, in voting systems to enhance the integrity of elections, and in the legal industry for smart contracts and transparent legal processes.<br />\r\n<br />\r\n<br />\r\n<br />\r\nAs the technology continues to evolve, its potential applications are likely to grow even further. Embracing blockchain&#039;s decentralized and transparent nature has the potential to revolutionize the way we conduct business and interact in various facets of our lives.<br />\r\n<br />\r\n', '1701775075Untitled.png', '2023-12-05 10:55:33', 2, 19, 0, 0),
(25, 'Unveiling the Mysteries of Machu Picchu: A Journey through Ancient Inca Ruins', 'Perched high in the Andes Mountains of Peru, Machu Picchu stands as a testament to the architectural brilliance of the ancient Inca civilization. This UNESCO World Heritage Site attracts adventurers and history enthusiasts from around the globe, offering a unique blend of breathtaking scenery and cultural immersion.<br />\r\n<br />\r\nThe journey to Machu Picchu often begins in the charming town of Cusco, where travelers acclimate to the high altitude and immerse themselves in the local culture. From Cusco, a scenic train ride takes visitors through the picturesque Sacred Valley, providing a tantalizing glimpse of the Andean landscape. As the train winds its way through narrow valleys and lush greenery, anticipation builds for the grand reveal of Machu Picchu.<br />\r\n<br />\r\nUpon arrival at the site, travelers are greeted by the iconic sun gate, Inti Punku, offering the first panoramic view of the ancient city. Walking through the intricate stone structures, terraced fields, and ceremonial plazas, one can&#039;t help but marvel at the precision with which the Incas crafted this architectural marvel. The Temple of the Sun, the Room of the Three Windows, and the Intihuatana stone are just a few of the highlights that transport visitors back in time.<br />\r\n<br />\r\nFor the more adventurous souls, the Inca Trail presents an opportunity to trek through the Andean wilderness, passing through diverse ecosystems and ancient ruins en route to Machu Picchu. The four-day trek is a challenging yet rewarding experience, culminating in an unforgettable sunrise entry to the ancient city.<br />\r\n<br />\r\nMachu Picchu&#039;s allure extends beyond its architectural wonders. Surrounded by mist-shrouded peaks and lush greenery, the site offers a spiritual connection to nature. As the sun rises over the Andes, casting a warm glow on the stone structures, visitors can&#039;t help but feel a profound sense of awe and wonder.<br />\r\n<br />\r\nIn the heart of the Andes, Machu Picchu remains a symbol of human ingenuity and a testament to the mysteries of ancient civilizations. A journey to this awe-inspiring site is not just a travel adventure; it&#039;s a pilgrimage through time, leaving an indelible mark on the soul.', '1701776143pexels-paolo-salazar-13923041.jpg', '2023-12-05 11:34:42', 2, 20, 0, 0),
(26, 'Sailing the Turquoise Waters of the Greek Islands: A Nautical Odyssey', 'Embarking on a sailing adventure through the enchanting Greek Islands is a dream for many, and rightfully so. The azure waters of the Aegean Sea, dotted with pristine islands steeped in history and mythology, create a canvas for an unforgettable maritime journey.<br />\r\n<br />\r\nStarting from the vibrant city of Athens, the sailing odyssey typically begins with a leisurely cruise towards the Cyclades, a cluster of islands known for their white-washed buildings, crystal-clear waters, and vibrant nightlife. Santorini, with its iconic blue-domed churches perched on cliffs overlooking the sea, is a highlight that never fails to captivate.<br />\r\n<br />\r\nAs the sailboat glides through the open sea, the islands of Mykonos, Naxos, and Paros beckon with their unique charms. From exploring ancient ruins to relaxing on pristine beaches, each island offers a distinct experience. Mykonos&#039; lively streets and legendary parties contrast with the tranquil beauty of Paros, where whitewashed villages and traditional tavernas create a serene atmosphere.<br />\r\n<br />\r\nFor the more adventurous sailors, a journey to the less-traveled islands of the Dodecanese or the Sporades promises secluded anchorages and a taste of authentic Greek island life. Exploring hidden coves, snorkeling in crystal-clear waters, and indulging in local cuisine add layers of discovery to the nautical adventure.<br />\r\n<br />\r\nSailing in the Aegean is not just about the destinations; it&#039;s about the journey itself. The gentle sway of the boat, the sound of the wind in the sails, and the ever-changing hues of the sea create a sensory symphony that heightens the overall experience. Watching the sunset from the deck, with the silhouette of an ancient island on the horizon, becomes a ritual that encapsulates the magic of Greek island sailing.<br />\r\n<br />\r\nAs the sailboat returns to Athens, the memories of this nautical odyssey linger, creating a desire to return and explore more of the countless islands that make up this maritime paradise. Sailing the Greek Islands is not just a vacation; it&#039;s a seafaring adventure that leaves an indelible mark on the soul, a tale to be shared and a journey to be cherished.', '1701776288pexels-diego-f-parra-843633.jpg', '2023-12-05 11:37:24', 2, 20, 0, 0);

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
(1, 'Alen', 'Josh', 'Alen josh', 'alen@gmail.com', '$2y$10$FA6lskEZaYOgu/ybYnQ9.OlsCg4/BKsYK9Pno9dC6xb0bGJPr6Nye', '1701767076pexels-italo-melo-2379005.jpg', 1),
(19, 'Jenifer', 'Alexsandra', 'Jenny', 'jenifer@gmail.com', '$2y$10$TjR0V2/Fid8JXlXF3s0AoOwJ25trOF5sOOavrB8j00zEWLOGYYwma', '1701773385pexels-pixabay-415829.jpg', 0),
(20, 'Thomas', 'Benito', 'Thomas Benito', 'thomas@gmail.com', '$2y$10$pSShIEb4Dn/c3v6iHly6guAYB8tlUsrk1JGqgjPcqWvZ5Ka1JjXIm', '1701783976man-852770_1280.jpg', 0);

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
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `likes_dislikes`
--
ALTER TABLE `likes_dislikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
