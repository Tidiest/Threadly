-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Лис 13 2026 р., 20:15
-- Версія сервера: 10.4.32-MariaDB
-- Версія PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `forum2pr_final`
--

-- --------------------------------------------------------

--
-- Структура таблиці `category`
--

CREATE TABLE `category` (
  `url_name` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `category`
--

INSERT INTO `category` (`url_name`, `name`, `info`) VALUES
('anime', 'Anime', ''),
('art', 'Art', ''),
('education', 'Education', ''),
('fun', 'Fun', ''),
('games', 'Games', ''),
('nature', 'Nature', ''),
('other', 'Other', ''),
('programming', 'Programming', ''),
('reading', 'Reading', ''),
('science', 'Science', ''),
('space', 'Space', ''),
('sport', 'Sport', '');

-- --------------------------------------------------------

--
-- Структура таблиці `comments`
--

CREATE TABLE `comments` (
  `id_comment` int(11) NOT NULL,
  `user_login` varchar(50) NOT NULL,
  `post_id` int(11) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `comments`
--

INSERT INTO `comments` (`id_comment`, `user_login`, `post_id`, `content`, `date`) VALUES
(1, '0', 18, 'Hello, very cool post, i ', '2024-11-24 00:54:47'),
(2, '0', 18, 'hello, very original!!!&#039;&#039;&#039;```', '2024-11-24 00:55:58'),
(3, '0', 18, 'Username bugtest', '2024-11-24 00:58:54'),
(4, '0', 18, 'dfdfdf', '2024-11-24 09:39:27'),
(5, '0', 18, 'SahsaTestLogIn', '2024-11-24 09:40:00'),
(6, '0', 18, 'sdsdd', '2024-11-24 09:42:08'),
(7, 'SahsaTestLogIn', 18, 'ACTUAL comment with working USER LOGIN\r\nreal\r\nno cap', '2024-11-24 09:43:47'),
(8, 'SahsaTestLogIn', 18, 'adasdafsdfs\r\ngerg97152379187!(&*@#^$(*!@\r\nefsfs', '2024-11-24 09:46:19'),
(9, 'SahsaTestLogIn', 18, '@#*&amp;^#(@$(@*#&amp;$\r\nwef\r\nf\r\n\r\nfewfw', '2024-11-24 09:46:53'),
(10, 'SahsaTestLogIn', 18, '&lt;span style=&#039;color:red;&#039;&gt;HELLO&lt;/span&gt;', '2024-11-24 09:48:05'),
(14, 'SahsaTestLogIn', 18, 'r\n\n\nf\n\n\nf\n\n\n\nw', '2024-11-24 10:04:33'),
(15, 'SahsaTestLogIn', 18, 'hello\ni\nam\nexcited \nto\ncomment \nhere', '2024-11-24 10:13:59'),
(16, 'SahsaTestLogIn', 18, 'sd1\nsd2\nsd3\nsd4\nsd5\nsd6\nsd7\nsd8\nsd9\nsd10\na', '2024-11-24 10:15:35'),
(17, 'SahsaTestLogIn', 18, 'sd1\nsd2\nsd3\nsd4\nsd5\nsd6\nsd7\nsd8\nsd9\nsd10\na', '2024-11-24 10:15:56'),
(18, 'SahsaTestLogIn', 18, 'a                                                                                               \n                         d                          \n       d                     dsd', '2024-11-24 10:17:05'),
(19, 'SahsaTestLogIn', 18, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2024-11-24 10:58:31'),
(20, 'SahsaTestLogIn', 18, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2024-11-24 10:59:43'),
(21, 'SahsaTestLogIn', 18, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2024-11-24 11:00:23'),
(22, 'PasswordPattern', 17, 'asdas  \n\n\n \n  1', '2024-11-26 17:49:19'),
(23, 'PasswordPattern', 1, 'LOLOLOLO, \nWOW\nhow \ncan \nsomeone \nbe\nTHIS\nSTU\nPID\nBRUUHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH', '2024-11-26 17:51:15'),
(24, 'PasswordPattern', 1, 'Some jobs are a very acquired taste\n\nYou have movers that have to literally engineer and plan moving obscenely large, heavy objects through existing infrastructure, sometimes internationally.\n\nYou have garbage men that must go through their planned routes, timed out in detail, while dealing with our rubbish, with few holidays and through rain and snow.\n\nYou have tower climbers whose entire job involves being so high off the ground that one wrong move is fatal.\n\nThose aren&#039;t jobs just anyone can be willing to do. Maybe short term, but to make a career of it requires something special', '2024-11-26 17:51:46'),
(25, 'PasswordPattern', 1, '&lt;a href=&quot;#&quot;&gt;some link&lt;/a&gt;', '2024-11-26 17:52:48'),
(26, 'PasswordPattern', 1, 'https://www.reddit.com/r/osugame/comments/1gzl4nf/my_friends_quite_literally/', '2024-11-26 17:53:07'),
(28, 'SahsaTestLogIn', 11, 'admin test\nalalala', '2024-11-27 13:54:17'),
(35, 'admin', 35, 'sd', '2024-11-29 07:56:56'),
(38, 'SahsaTestLogIn', 39, '&lt;script&gt;alert(&#039;hello&#039;);&lt;/script&gt;', '2024-12-04 14:32:27'),
(39, 'Aa', 40, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '2024-12-11 14:21:45'),
(40, 'SahsaTestLogIn', 10, 'sdfsdfsdf', '2024-12-13 08:39:26'),
(41, 'SahsaTestLogIn', 41, 'lol', '2024-12-13 08:45:58'),
(42, 'SahsaTestLogIn', 45, 'dfdf', '2024-12-13 08:46:15'),
(43, 'SahsaTestLogIn', 1, 'dfdf', '2024-12-13 08:47:35'),
(44, 'SahsaTestLogIn', 2, 'kk', '2025-01-15 12:57:42'),
(48, 'banban', 72, 'ban \nban', '2025-02-20 19:27:02');

-- --------------------------------------------------------

--
-- Структура таблиці `posts`
--

CREATE TABLE `posts` (
  `id_post` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(700) NOT NULL,
  `user_login` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `rate` int(11) NOT NULL,
  `tags` text NOT NULL,
  `thread` varchar(100) NOT NULL,
  `closed_comments` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `posts`
--

INSERT INTO `posts` (`id_post`, `title`, `content`, `user_login`, `date`, `rate`, `tags`, `thread`, `closed_comments`) VALUES
(1, 'firs', 'assfdsgdvdvsdsdvs', 'user', '2024-11-20 00:00:00', 0, '', 'ar', 0),
(2, 'I wanted to share my thoughts', 'hello, askjakjkfjsdlfskdnfknkend, askjakjkfjsdlfskdnfknkend, askjakjkfjsdlfskdnfknkend,askjakjkfjsdlfskdnfknkendaskjakjkfjsdlfskdnfknkendaskjakjkfjsdlfskdnfknkend,askjakjkfjsdlfskdnfknkendaskjakjkfjsdlfskdnfknkendaskjakjkfjsdlfskdnfknkend,askjakjkfjsdlfskdnfknkendaskjakjkfjsdlfskdnfknkendaskjakjkfjsdlfskdnfknkendaskjakjkfjsdlfskdnfknkend', 'user2', '2024-11-23 00:00:00', 0, '', 'animation', 0),
(3, 'YOOOO, this Threadly website is soo cool))!!', 'this Threadly website is soooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo', 'threadly_lover123', '2024-11-06 00:00:00', 3, '', 'art', 0),
(10, 'Hello, this is test post to the art thread', 'Welcome, this is test post for the art thread, i&#039;m so excited!!))', 'SahsaTestLogIn', '2024-11-23 00:00:00', 0, '', 'art', 0),
(11, 'KEOROKEOFKPL:LMDf', ';as&#039;.&#039;;csl;mcs;kcmwepiricsdc', 'SahsaTestLogIn', '2024-11-23 00:00:00', 0, '', 'art', 0),
(12, 'ffffff', 'fffffff', 'SahsaTestLogIn', '2024-11-23 21:31:56', 0, '', 'art', 0),
(13, 'tetetetetet', 'LOOOOOOOOOOOOOOOOOOLAS', 'SahsaTestLogIn', '2024-11-23 21:34:17', 0, '', 'animation', 0),
(14, 'sfdfd', 'dsdfsdfsdfs', 'SahsaTestLogIn', '2024-11-23 21:42:14', 898990, '', 'art', 0),
(15, 'sdsdsdfsdsdsdfsdsdsdfsdsdsdfsdsdsdfsdsdsdfsdsdsdfsdsdsdfsdsdsdfsdsdsdfsdsdsdfsdsdsdfsdsd', 'asasdasd', 'SahsaTestLogIn', '2024-11-23 21:44:42', 2, '', 'art', 0),
(16, 'LOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOONG TITLE', 'LOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO', 'SahsaTestLogIn', '2024-11-23 21:45:56', 0, '', 'animation', 0),
(17, 'hello, this is the first post in this thread', 'I&#039;m so excited to start this thread, i don&#039;t even know, what to say...', 'SahsaTestLogIn', '2024-11-23 21:51:38', 3, '', 'gaming', 0),
(18, 'Hello from WebKiller, boys!!', 'WEBKILLER IS HERE', 'WebKiller', '2024-11-23 22:00:55', 3, '', 'animation', 0),
(19, 'Hello, just testing this cool new website i found', 'Hello, just testing this cool new website i found. Hello, just testing this cool new website i found. Hello, just testing this cool new website i found. Hello, just testing this cool new website i found. Hello, just testing this cool new website i found. ', 'SahsaTestLogIn', '2024-11-23 23:56:47', 1, '', 'digitaldrawing', 0),
(20, '/.,zxc/.,zxc/.z,cx/z.cxz(!*&&^@&^(!@#*_(!*$@$<br>', 'hello watermelon', 'SahsaTestLogIn', '2024-11-24 11:22:44', 0, '', 'adminfeaturetest', 0),
(34, 'Hello, it&#039;s debugging time, let&#039;s GOOOOOOO', 'Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug Debug', 'PasswordPattern', '2024-11-26 17:58:50', 0, '', 'animation', 0),
(35, '&#039;&#039;', '&#039;&#039;', 'PasswordPattern', '2024-11-26 18:06:26', 1, '', 'animation', 0),
(39, '&lt;script&gt;alert(&#039;hello&#039;);&lt;/script&gt;', '&lt;script&gt;alert(&#039;hello&#039;);&lt;/script&gt;', 'SahsaTestLogIn', '2024-12-04 14:32:18', 0, '', 'animation', 0),
(40, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAA', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', 'Aa', '2024-12-11 14:21:31', 0, '', 'aaaaaa', 0),
(41, 'post', 'asfsdfs', 'SahsaTestLogIn', '2024-12-13 08:40:51', 0, '', 'nonecattest', 0),
(42, 'RULES', '-No Spamming\n-No Promoting\n-No Swearing\n-No NSFW', 'SahsaTestLogIn', '2024-12-13 08:42:48', 0, '', 'books', 0),
(43, 'My favourite game', 'I love this game so much', 'LolLol', '2024-12-13 09:41:00', 0, '', 'terraria', 0),
(44, 'I played for 1600+ hours', 'So, my story is...', 'LolLol', '2024-12-13 09:41:18', 0, '', 'terraria', 0),
(45, 'Is this behaviour okay?', 'Look at this...', 'LolLol', '2024-12-13 09:41:37', 0, '', 'terraria', 0),
(46, 'hey', 'blablabla', 'SahsaTestLogIn', '2025-01-08 14:09:15', 0, '', 'aaa', 0),
(50, 'Whatever', 'Whatever', 'SahsaTestLogIn', '2025-01-15 12:58:24', 0, '', 'books', 0),
(51, 'RULES', '1. Don&#039;t swear!\n2. NO NSFW POSTS (create your own thread and post there if you want so)\n3. No AI generated images\n4. No shaming others, be nice\n5. Enjoy!)', 'newuser', '2025-01-15 13:11:52', 1, '', 'anime', 1),
(69, 'sdsd', 'sdsd', 'admin', '2025-02-20 17:21:14', 0, '', 'edit11finale', 0),
(70, 'adasd', 'asdasd', 'admin', '2025-02-20 17:26:48', 0, '', 'debug271', 0),
(71, 'Hello! I&#039;m Aka Akasaka', 'I&#039;m Aka Akasaka a manga author. \nI am happy to be here!', 'AkaAkasaka', '2025-02-20 18:55:49', 1, '', 'anime', 0),
(72, 'ban', 'ban', 'banban', '2025-02-20 19:26:55', 0, '', 'banned', 0);

-- --------------------------------------------------------

--
-- Структура таблиці `threads`
--

CREATE TABLE `threads` (
  `name` varchar(100) NOT NULL,
  `url_name` varchar(30) NOT NULL,
  `user_login` varchar(50) NOT NULL,
  `description` varchar(700) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` enum('Public','Private') NOT NULL,
  `name_category` varchar(50) NOT NULL,
  `pinned_post` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `threads`
--

INSERT INTO `threads` (`name`, `url_name`, `user_login`, `description`, `date`, `status`, `name_category`, `pinned_post`) VALUES
('Animation', 'animation', 'admin', 'this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread this is animation thread ', '2024-11-20', 'Public', '1', 2),
('Anime', 'anime', 'newuser', 'This is the thread, where anyone can express themselfs and show love for anime without gudgement!', '2025-01-15', 'Public', 'anime', 51),
('Art', 'art', 'admin', 'this is art thread', '2024-11-23', 'Public', '1', 3),
('Art thread', 'categorytest', 'SahsaTestLogIn', 'TESSSSSSSSSSSSSSSSSSSSSSSSSSST', '2024-12-04', 'Public', 'art', NULL),
('ASA', 'adslol', 'PasswordPattern', 'asdsdfsf', '2024-11-26', 'Public', '', NULL),
('asdasdas&#039;;!&quot;@:&quot;#:@#$', 'debug12314', 'PasswordPattern', 'saadasda', '2024-11-26', 'Public', '', NULL),
('Banned', 'banned', 'banban', 'i&#039;m banned', '2025-02-20', 'Public', 'other', NULL),
('Books', 'books', 'SahsaTestLogIn', 'I love reading, reading thread', '2024-12-13', 'Public', 'programming', 42),
('Digital Drawing', 'digitaldrawing', 'admin', 'This thread is all about digital drawings, you can share your drawings here and rate other people&#039;s drawings. RULE: DON&#039;T BE MEAN.', '2024-11-23', 'Public', '', NULL),
('edit11 (FINAL, i hope)', 'edit11finale', 'admin', 'edit11 FINAL, PLEEEEEEEEEEEEEASE', '2025-02-20', 'Public', 'games', 69),
('Gaming', 'gaming', 'admin', 'this is gaming thread where we are posting about different games of different genres', '2024-11-23', 'Public', '1', NULL),
('I CREATED THIS THREAD FOR DEBUGGGGGGING 2478@*#&amp;^$)!)($_#$:L&quot;:??&lt;&lt;?ssd', 'debug271', 'admin', '@()*)#(*#)*$&amp;#%&gt;&quot;:SVDC&gt;L{#OKRFKW)I@U!)#UEQWOKD{Lpodwjeoufh209ue0o2k[[', '2025-02-20', 'Public', '', NULL),
('LOL', 'lol', 'admin', 'lololol', '2025-02-20', 'Public', 'lol', NULL),
('NASA', 'nasa', 'admin', 'This is a thread all about NASA. Learn, discover and spectate news about space exploration and rocket-building.', '2025-02-20', 'Public', 'science', NULL),
('None category test1', 'nonecattest', 'SahsaTestLogIn', 'NONE', '2024-12-04', 'Public', '', NULL),
('Terraria', 'terraria', 'SahsaTestLogIn', 'this is terraria thread', '2024-12-06', 'Public', 'games', 44),
('This is a test thread for admin feature', 'adminfeaturetest', 'SahsaTestLogIn', 'This is a test thread for admin feature. This is a test thread for admin feature. This is a test thread for admin feature. This is a test thread for admin feature. This is a test thread for admin feature. This is a test thread for admin feature. This is a test thread for admin feature. This is a test thread for admin feature. This is a test thread for admin feature. This is a test thread for admin feature. This is a test thread for admin feature. This is a test thread for admin feature. This is a test thread for admin feature. This is a test thread for admin feature. This is a test thread for admin feature. ', '2024-11-24', 'Public', '', 0);

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `login` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `pfp` varchar(255) NOT NULL DEFAULT 'default_pfp.png',
  `about` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`login`, `name`, `surname`, `email`, `password`, `birth_date`, `role`, `pfp`, `about`) VALUES
('Aa', 'A', 'a', 'a@a.com', '$2y$10$fy96vCRrwYwtN.F.dBc/8O6wSN6HznMEzakwBx/Y0L5xmfx6hxzaW', '2024-12-01', 'user', '67599194cfa65_pobrane.png', NULL),
('admin', 'ad', 'min', 'admin@gmail.com', '$2y$10$QouY97xfi9FOjTYtv14/QOT35/fOxk4WqgBVyy6/oUKQXiINaVcl.', '2024-11-02', 'admin', '67b7538e69901_admin.jpg', 'I&#039;m THE admin\nNOONE should disrespect  MEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE'),
('AkaAkasaka', 'Aka', 'Akasaka', 'akaakasaka@manga.com', '$2y$10$m0n6xZhNdgB/JRRxzkpOse0QODLqyyfOa0TAa3v5JX.qr.8S4RJr2', '2011-06-09', 'user', 'default_pfp.png', 'I&#039;m a manga author! \nWelcome!'),
('LolLol', 'Lol', 'Lol', 'lol@lol.com', '$2y$10$R0XhWjGCCKvceQKcn1peyOjI2RBMtSXrP9Hj51L/7THuXtZ7U7AwO', '2024-12-03', 'user', '675bf2f51a78e_pobrane.png', 'this is my first time here'),
('newuser', 'new', 'user', 'blah@blah.blah', '$2y$10$A7fArbeweNMvUxTmQVn6JOvG1tkfbFGg6xjaU.II/krPIBtO8PxFy', '2025-01-26', 'user', 'default_pfp.png', 'HELOOOOOOOOOOOOOOOOOOOO\nOOOOOOOOOOOOOOOO'),
('PasswordPattern', 'Password', 'Pattern', 'passregex@test.com', '$2y$10$KzXWJXouZmejyoIVd/zwbubavHXtQ4/pd2QBTS3a8Ch6kKsObYgk.', '2024-11-06', '', 'default_pfp.png', NULL),
('SahsaTestLogIn', 'Sahsa', 'TestLogIn', 'testlogin@lol', '$2y$10$0Xp.nz8fJTyHm4AlnXLA/uRq406uCdYrrdoyxMpK9x5eXHHtmakva', '2024-11-06', 'user', '67598f7e5e0a0_Demokracja.jpeg', 'Hello!!\nIt&#039;s a nice forum'),
('TidiestMender3', 'Tidiest', 'Mender', 'sss@sdd', '$2y$10$IHA2KLlGv65z2BJhtVzKAuWRbMp7IzbvEBrtUP7HEEbMdvLeYogqW', '2024-11-09', '', 'default_pfp.png', NULL),
('WebKiller', 'Web', 'Killer', 'webkiller@gmail.com', '$2y$10$VJIHvYH2z.9EWS5EpmtOUuPdaxBVTsS3wdqTZEsWd50tFLjcJDopu', '2024-11-01', '', 'default_pfp.png', NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `user_likes`
--

CREATE TABLE `user_likes` (
  `id_like` bigint(20) NOT NULL,
  `user_login` varchar(50) NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `user_likes`
--

INSERT INTO `user_likes` (`id_like`, `user_login`, `id_post`) VALUES
(15, 'WebKiller', 15),
(16, 'WebKiller', 14),
(17, 'WebKiller', 17),
(21, 'WebKiller', 18),
(24, 'SahsaTestLogIn', 19),
(25, 'SahsaTestLogIn', 17),
(26, 'IAmNew', 18),
(27, 'IAmNew', 17),
(29, 'admin', 35),
(31, 'SahsaTestLogIn', 15),
(33, 'newuser', 51),
(35, 'AkaAkasaka', 71);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`url_name`),
  ADD UNIQUE KEY `name_category` (`name`);

--
-- Індекси таблиці `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comment`);

--
-- Індекси таблиці `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `thread` (`thread`);

--
-- Індекси таблиці `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `url_name` (`url_name`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Індекси таблиці `user_likes`
--
ALTER TABLE `user_likes`
  ADD PRIMARY KEY (`id_like`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT для таблиці `posts`
--
ALTER TABLE `posts`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT для таблиці `user_likes`
--
ALTER TABLE `user_likes`
  MODIFY `id_like` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
