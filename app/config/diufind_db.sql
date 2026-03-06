-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2026 at 09:22 PM
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
-- Database: `diufind_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archived_posts`
--

CREATE TABLE `archived_posts` (
  `id` int(11) NOT NULL,
  `original_post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `archived_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE `badges` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT 'fa-award',
  `color` varchar(20) DEFAULT '#FFD700',
  `required_score` int(11) DEFAULT 0,
  `type` enum('return','response','streak','special') DEFAULT 'special'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `badges`
--

INSERT INTO `badges` (`id`, `name`, `description`, `icon`, `color`, `required_score`, `type`) VALUES
(1, 'Honest Finder', 'Returned 1 item to its owner', 'fa-hand-holding-heart', '#FFD700', 1, 'return'),
(2, 'Campus Hero', 'Returned 10 items successfully', 'fa-trophy', '#FF6B6B', 10, 'return'),
(3, 'Fast Responder', 'Replies within 5 minutes average', 'fa-bolt', '#0056D2', 0, 'response'),
(4, 'Trusted Member', 'Maintained 8+ trust score for 3 months', 'fa-shield-check', '#00843D', 0, 'special');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon_class` varchar(50) DEFAULT 'fa-box',
  `color` varchar(20) DEFAULT '#00843D'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon_class`, `color`) VALUES
(1, 'Electronics', 'fa-laptop', '#0056D2'),
(2, 'ID Cards', 'fa-id-card', '#00843D'),
(3, 'Books', 'fa-book', '#FF6B6B'),
(4, 'Accessories', 'fa-ring', '#FFD93D');

-- --------------------------------------------------------

--
-- Table structure for table `claims`
--

CREATE TABLE `claims` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `claimant_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `confidence_score` decimal(5,2) DEFAULT 0.00,
  `security_answer` text DEFAULT NULL,
  `proof_image` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','rejected','admin_review') DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `claims`
--

INSERT INTO `claims` (`id`, `post_id`, `claimant_id`, `message`, `confidence_score`, `security_answer`, `proof_image`, `status`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 14, 5, 'User claims this item belongs to them.', 0.00, NULL, NULL, 'accepted', NULL, '2026-02-01 00:35:41', '2026-02-01 00:36:43'),
(2, 12, 5, 'User claims this item belongs to them.', 0.00, NULL, NULL, 'rejected', NULL, '2026-02-01 01:01:09', '2026-02-01 01:48:40'),
(3, 16, 5, 'User claims this item belongs to them.', 0.00, NULL, NULL, 'admin_review', NULL, '2026-02-01 01:48:14', '2026-02-01 01:48:56'),
(4, 6, 5, 'User claims this item belongs to them.', 0.00, NULL, NULL, 'accepted', NULL, '2026-02-01 02:49:28', '2026-02-01 02:50:00'),
(5, 16, 6, 'User claims this item belongs to them.', 0.00, NULL, NULL, 'accepted', NULL, '2026-02-01 03:28:17', '2026-02-09 01:08:48'),
(6, 12, 6, 'User claims this item belongs to them.', 0.00, NULL, NULL, 'accepted', NULL, '2026-02-02 01:18:18', '2026-02-02 01:20:30'),
(7, 23, 4, 'User claims this item belongs to them.', 0.00, NULL, NULL, 'accepted', NULL, '2026-02-09 00:36:17', '2026-02-09 00:37:41'),
(8, 20, 5, 'User claims this item belongs to them.', 0.00, NULL, NULL, 'accepted', NULL, '2026-02-09 01:07:52', '2026-02-09 01:08:54'),
(9, 24, 4, 'User claims this item belongs to them.', 0.00, NULL, NULL, 'accepted', NULL, '2026-02-09 01:14:29', '2026-02-09 01:14:47');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `parent_id`, `user_id`, `body`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, 4, 'its mine', '2026-01-30 10:45:10', '2026-01-30 10:45:10'),
(2, 5, NULL, 1, 'hi', '2026-01-30 15:42:15', '2026-01-30 15:42:15'),
(3, 6, NULL, 5, 'hi', '2026-01-30 15:42:58', '2026-01-30 15:42:58'),
(4, 6, 3, 1, 'hey', '2026-01-30 15:50:52', '2026-01-30 15:50:52'),
(5, 6, 4, 1, 'koi', '2026-01-30 16:09:51', '2026-01-30 16:09:51'),
(6, 6, 5, 5, 'hehe', '2026-01-30 16:23:13', '2026-01-30 16:23:13'),
(7, 6, 6, 1, 'h', '2026-01-30 16:31:32', '2026-01-30 16:31:32'),
(8, 6, 5, 5, 'hehe', '2026-01-30 16:31:56', '2026-01-30 16:31:56'),
(9, 6, 7, 5, 'ki', '2026-01-30 16:32:17', '2026-01-30 16:32:17'),
(10, 6, NULL, 5, 'a bara ayta amr', '2026-01-30 22:09:18', '2026-01-30 22:09:18'),
(11, 6, 9, 5, 'a tham', '2026-01-30 22:09:34', '2026-01-30 22:09:34'),
(12, 12, NULL, 5, 'HI', '2026-01-31 23:47:40', '2026-01-31 23:47:40'),
(13, 12, NULL, 6, 'please inbox dekho', '2026-02-02 01:18:49', '2026-02-02 01:18:49'),
(14, 17, NULL, 6, 'ami paici didi', '2026-02-07 18:57:01', '2026-02-07 18:57:01'),
(15, 17, 14, 4, 'inbox koro sala', '2026-02-07 18:57:36', '2026-02-07 18:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('campus','transport','hall','building') DEFAULT 'campus',
  `danger_level` int(11) DEFAULT 0,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `type`, `danger_level`, `latitude`, `longitude`) VALUES
(1, 'AB4 Building', 'building', 3, NULL, NULL),
(2, 'Knowledge Tower', 'building', 2, NULL, NULL),
(3, 'Library', 'campus', 1, NULL, NULL),
(4, 'Food Court', 'campus', 4, NULL, NULL),
(5, 'Bus Station - Mirpur Route', 'transport', 5, NULL, NULL),
(6, 'Innovation Lab', 'building', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `message_text` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `is_template` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'User who receives the notification',
  `actor_id` int(11) DEFAULT NULL COMMENT 'User who performed the action',
  `type` enum('post_created','post_reaction','post_comment','comment_reply','comment_reaction','profile_updated','avatar_updated','pdf_downloaded') NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `actor_id`, `type`, `post_id`, `comment_id`, `message`, `is_read`, `created_at`) VALUES
(1, 5, 1, 'comment_reply', 6, 6, 'Admin User replied to your comment', 1, '2026-01-30 16:31:32'),
(2, 1, 5, 'comment_reply', 6, 5, 'fghfgjfhjhfj replied to your comment', 1, '2026-01-30 16:31:56'),
(3, 4, 5, 'post_reaction', 6, NULL, 'fghfgjfhjhfj reacted ❤️ to your post', 1, '2026-01-30 16:32:07'),
(4, 1, 5, 'comment_reply', 6, 7, 'fghfgjfhjhfj replied to your comment', 1, '2026-01-30 16:32:17'),
(5, 1, 1, 'post_created', NULL, NULL, 'You created a new post: \"test\"', 1, '2026-01-30 21:59:01'),
(6, 1, 5, 'post_reaction', 7, NULL, 'fghfgjfhjhfj reacted 😮 to your post', 1, '2026-01-30 22:01:46'),
(7, 4, 5, 'post_comment', 6, NULL, 'fghfgjfhjhfj commented on your post', 1, '2026-01-30 22:09:18'),
(8, 1, 1, 'post_created', NULL, NULL, 'You created a new post: \"zzzzzzzzzz\"', 0, '2026-01-30 22:25:55'),
(9, 1, 5, 'post_reaction', 8, NULL, 'fghfgjfhjhfj reacted 🤗 to your post', 0, '2026-01-30 22:26:26'),
(10, 1, 1, 'post_created', NULL, NULL, 'You created a new post: \"rrrrrrrrrrrrrrrrrrrrr\"', 0, '2026-01-30 22:38:28'),
(11, 1, 5, 'post_reaction', 9, NULL, 'fghfgjfhjhfj reacted 🤗 to your post', 0, '2026-01-30 22:39:09'),
(12, 5, 5, 'post_created', NULL, NULL, 'You created a new post: \"no\"', 1, '2026-01-30 22:47:53'),
(13, 5, 1, 'post_reaction', 10, NULL, 'Admin User reacted ❤️ to your post', 1, '2026-01-31 01:33:45'),
(14, 4, 4, 'post_created', NULL, NULL, 'You created a new post: \"HHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH\"', 1, '2026-01-31 23:01:39'),
(15, 4, 5, 'post_reaction', 11, NULL, 'fghfgjfhjhfj reacted 🤗 to your post', 1, '2026-01-31 23:02:11'),
(16, 4, 4, 'post_created', NULL, NULL, 'You created a new post: \"FOUUUUUUUUUUUNNNNNNNDDDDD\"', 1, '2026-01-31 23:06:59'),
(17, 4, 4, 'post_created', NULL, NULL, 'You created a new post: \"TEST PORPOSE প্রথমত কথা হচ??\"', 1, '2026-01-31 23:11:19'),
(18, 4, 5, 'post_reaction', 12, NULL, 'fghfgjfhjhfj reacted 🤗 to your post', 1, '2026-01-31 23:47:06'),
(19, 4, 5, 'post_comment', 12, NULL, 'fghfgjfhjhfj commented on your post', 1, '2026-01-31 23:47:40'),
(20, 4, 4, 'post_created', NULL, NULL, 'You created a new post: \"VAII\"', 1, '2026-01-31 23:51:04'),
(21, 4, 5, 'post_reaction', 14, NULL, 'fghfgjfhjhfj reacted 🤗 to your post', 1, '2026-02-01 00:13:16'),
(22, 4, 5, '', 14, NULL, 'fghfgjfhjhfj has requested to claim your post: \"VAII\"', 1, '2026-02-01 00:35:41'),
(23, 5, 4, '', 14, NULL, '✅ Your claim for \"VAII\" has been APPROVED! Contact owner: 01723521415', 1, '2026-02-01 00:36:43'),
(24, 4, 4, '', 14, NULL, 'You approved the claim request for \"VAII\"', 1, '2026-02-01 00:36:43'),
(25, 4, 4, '', 14, NULL, '🎉 Post marked as resolved! Great job helping the community.', 1, '2026-02-01 00:44:20'),
(26, 4, 4, '', 14, NULL, '🎉 Post marked as resolved! Great job helping the community.', 1, '2026-02-01 00:44:36'),
(27, 4, 4, '', 14, NULL, '🎉 Post marked as resolved! Great job helping the community.', 1, '2026-02-01 00:45:09'),
(28, 4, 4, '', 14, NULL, '🎉 Post marked as resolved! Great job helping the community.', 1, '2026-02-01 00:48:25'),
(29, 4, 4, '', 4, NULL, '🎉 Post marked as resolved! Great job helping the community.', 1, '2026-02-01 00:49:26'),
(30, 4, 4, 'post_created', NULL, NULL, 'You created a new post: \"TEST MAP\"', 1, '2026-02-01 00:57:50'),
(31, 4, 5, '', 12, NULL, 'fghfgjfhjhfj has requested to claim your post: \"FOUUUUUUUUUUUNNNNNNNDDDDD\"', 1, '2026-02-01 01:01:09'),
(32, 4, 4, 'post_created', NULL, NULL, 'You created a new post: \"ID CARD PAWA GESE\"', 1, '2026-02-01 01:47:49'),
(33, 4, 5, '', 16, NULL, 'fghfgjfhjhfj has requested to claim your post: \"ID CARD PAWA GESE\"', 1, '2026-02-01 01:48:14'),
(34, 5, 4, '', 12, NULL, '❌ Your claim for \"FOUUUUUUUUUUUNNNNNNNDDDDD\" has been rejected.', 1, '2026-02-01 01:48:40'),
(35, 4, 4, '', 12, NULL, 'You rejected the claim request for \"FOUUUUUUUUUUUNNNNNNNDDDDD\"', 1, '2026-02-01 01:48:40'),
(36, 5, 4, '', 16, NULL, '⚠️ Your claim for \"ID CARD PAWA GESE\" has been escalated to admin for review.', 1, '2026-02-01 01:48:56'),
(37, 4, 4, '', 16, NULL, 'You escalated the claim request for \"ID CARD PAWA GESE\" to admin.', 1, '2026-02-01 01:48:56'),
(38, 4, 5, '', 6, NULL, 'fghfgjfhjhfj has requested to claim your post: \"mmmmmmmmmmmmmmm\"', 1, '2026-02-01 02:49:28'),
(39, 5, 4, '', 6, NULL, '✅ Your claim for \"mmmmmmmmmmmmmmm\" has been APPROVED! Contact owner: 01723521415', 1, '2026-02-01 02:50:00'),
(40, 4, 4, '', 6, NULL, 'You approved the claim request for \"mmmmmmmmmmmmmmm\"', 1, '2026-02-01 02:50:00'),
(41, 4, 6, '', 16, NULL, 'Abdul Jabber Jack khankirpola has requested to claim your post: \"ID CARD PAWA GESE\"', 1, '2026-02-01 03:28:17'),
(42, 4, 6, 'post_reaction', 16, NULL, 'Abdul Jabber Jack khankirpola reacted 😢 to your post', 1, '2026-02-02 01:17:30'),
(43, 4, 6, '', 12, NULL, 'Abdul Jabber Jack khankirpola has requested to claim your post: \"FOUUUUUUUUUUUNNNNNNNDDDDD\"', 1, '2026-02-02 01:18:18'),
(44, 4, 6, 'post_comment', 12, NULL, 'Abdul Jabber Jack khankirpola commented on your post', 1, '2026-02-02 01:18:49'),
(45, 6, 4, '', 12, NULL, '✅ Your claim for \"FOUUUUUUUUUUUNNNNNNNDDDDD\" has been APPROVED! Contact owner: 01723521415', 1, '2026-02-02 01:20:30'),
(46, 4, 4, '', 12, NULL, 'You approved the claim request for \"FOUUUUUUUUUUUNNNNNNNDDDDD\"', 1, '2026-02-02 01:20:30'),
(47, 4, 4, '', 12, NULL, '🎉 Post marked as resolved! Great job helping the community.', 1, '2026-02-02 01:21:48'),
(48, 4, 4, 'post_created', NULL, NULL, 'You created a new post: \"🔔 হারানো বিজ্ঞপ্ত??\"', 1, '2026-02-07 18:48:19'),
(49, 4, 6, 'post_comment', 17, NULL, 'Abdul Jabber Jack khankirpola commented on your post', 1, '2026-02-07 18:57:01'),
(50, 6, 4, 'comment_reply', 17, 14, 'oyn replied to your comment', 1, '2026-02-07 18:57:36'),
(51, 4, 4, 'post_created', NULL, NULL, 'You created a new post: \"id card\"', 1, '2026-02-09 00:02:26'),
(52, 4, 4, 'post_created', NULL, NULL, 'You created a new post: \"ID CARD\"', 1, '2026-02-09 00:07:19'),
(53, 4, 4, 'post_created', NULL, NULL, 'You created a new post: \"ID CARD\"', 1, '2026-02-09 00:26:01'),
(54, 4, 4, 'post_created', NULL, NULL, 'You created a new post: \"HI\"', 1, '2026-02-09 00:30:22'),
(55, 6, 6, 'post_created', NULL, NULL, 'You created a new post: \"NNNNNNNNNNNNNN\"', 0, '2026-02-09 00:32:17'),
(56, 6, 6, 'post_created', NULL, NULL, 'You created a new post: \"MMMMMMMMMMMMMMMMMMM\"', 0, '2026-02-09 00:33:42'),
(57, 6, 4, '', 23, NULL, 'oyn has requested to claim your post: \"MMMMMMMMMMMMMMMMMMM\"', 0, '2026-02-09 00:36:17'),
(58, 6, 4, 'post_reaction', 22, NULL, 'oyn reacted 😂 to your post', 0, '2026-02-09 00:37:28'),
(59, 4, 6, '', 23, NULL, '✅ Your claim for \"MMMMMMMMMMMMMMMMMMM\" has been APPROVED! Contact owner: 01412141518', 1, '2026-02-09 00:37:41'),
(60, 6, 6, '', 23, NULL, 'You approved the claim request for \"MMMMMMMMMMMMMMMMMMM\"', 1, '2026-02-09 00:37:41'),
(61, 6, 6, '', 23, NULL, '🎉 Post marked as resolved! Great job helping the community.', 0, '2026-02-09 00:56:30'),
(62, 4, 5, '', 20, NULL, 'fghfgjfhjhfj has requested to claim your post: \"ID CARD\"', 1, '2026-02-09 01:07:52'),
(63, 6, 4, '', 16, NULL, '✅ Your claim for \"ID CARD PAWA GESE\" has been APPROVED! Contact owner: 01723521415', 0, '2026-02-09 01:08:48'),
(64, 4, 4, '', 16, NULL, 'You approved the claim request for \"ID CARD PAWA GESE\"', 1, '2026-02-09 01:08:48'),
(65, 5, 4, '', 20, NULL, '✅ Your claim for \"ID CARD\" has been APPROVED! Contact owner: 01723521415', 1, '2026-02-09 01:08:54'),
(66, 4, 4, '', 20, NULL, 'You approved the claim request for \"ID CARD\"', 1, '2026-02-09 01:08:54'),
(67, 4, 4, '', 20, NULL, '🎉 Post marked as resolved! Great job helping the community.', 1, '2026-02-09 01:10:40'),
(68, 5, 5, 'post_created', NULL, NULL, 'You created a new post: \"XXXXXXXXXXZZZZZZZ\"', 1, '2026-02-09 01:14:07'),
(69, 5, 4, '', 24, NULL, 'oyn has requested to claim your post: \"XXXXXXXXXXZZZZZZZ\"', 1, '2026-02-09 01:14:29'),
(70, 4, 5, '', 24, NULL, '✅ Your claim for \"XXXXXXXXXXZZZZZZZ\" has been APPROVED! Contact owner: 01412141518', 0, '2026-02-09 01:14:47'),
(71, 5, 5, '', 24, NULL, 'You approved the claim request for \"XXXXXXXXXXZZZZZZZ\"', 1, '2026-02-09 01:14:47'),
(72, 5, 5, '', 24, NULL, '🎉 Post marked as resolved! Great job helping the community.', 1, '2026-02-09 01:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `type` enum('Lost','Found','Other') NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL DEFAULT 'General',
  `body` text NOT NULL,
  `auto_tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`auto_tags`)),
  `image_path` varchar(255) DEFAULT NULL,
  `status` enum('active','Open','Matched','Handover','Closed','Archived','resolved') DEFAULT 'active',
  `points_awarded` tinyint(1) DEFAULT 0,
  `privacy_mode` tinyint(1) DEFAULT 0,
  `reward_offered` decimal(10,2) DEFAULT 0.00,
  `views` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(10,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `category_id`, `location_id`, `type`, `title`, `category`, `body`, `auto_tags`, `image_path`, `status`, `points_awarded`, `privacy_mode`, `reward_offered`, `views`, `created_at`, `updated_at`, `latitude`, `longitude`) VALUES
(1, 3, 2, 3, 'Lost', 'zc', 'General', 'zc', NULL, NULL, 'active', 0, 0, 0.00, 0, '2026-01-30 09:34:08', '2026-02-01 00:48:13', 23.87629200, 90.32118900),
(2, 3, 1, 1, 'Lost', 'ee', 'General', 'eeeeeeeeeeeeeee', NULL, NULL, 'active', 0, 0, 0.00, 0, '2026-01-30 09:44:02', '2026-02-01 00:48:13', 23.87580000, 90.32050000),
(3, 1, 1, 3, 'Lost', 'hhhh', 'General', 'hhhhhhhhhhhhhhhhh', NULL, NULL, 'active', 0, 0, 0.00, 0, '2026-01-30 09:50:41', '2026-02-01 00:48:13', 23.87700000, 90.32200000),
(4, 4, NULL, 5, 'Lost', 'mmmmmmmmmmmmmmmmmm', 'General', 'mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm', NULL, NULL, 'resolved', 0, 0, 0.00, 0, '2026-01-30 10:01:44', '2026-02-01 00:49:26', NULL, NULL),
(5, 4, 2, 1, 'Found', 'akta id card pawa gese', 'General', 'same', NULL, '697c32f30cb06_1769747187.jpg', 'active', 0, 0, 0.00, 0, '2026-01-30 10:26:27', '2026-02-01 00:48:13', NULL, NULL),
(6, 4, 3, 1, 'Found', 'mmmmmmmmmmmmmmm', 'General', 'iiiiiiiiiiiiiiii', NULL, '697c45225e7ee_1769751842.png', '', 0, 0, 0.00, 0, '2026-01-30 11:44:02', '2026-01-31 21:08:54', NULL, NULL),
(7, 1, 1, 1, '', 'test', 'General', 'testing map', NULL, '697cd54530a2a_1769788741.jpg', 'active', 0, 0, 0.00, 0, '2026-01-30 21:59:01', '2026-02-01 00:48:13', NULL, NULL),
(8, 1, 1, 1, 'Lost', 'zzzzzzzzzz', 'General', 'zzzzzzzzzzzzzzzzzzzzz', NULL, '697cdb93afc4c_1769790355.png', 'active', 0, 0, 0.00, 0, '2026-01-30 22:25:55', '2026-02-01 00:48:13', NULL, NULL),
(9, 1, 3, 1, 'Lost', 'rrrrrrrrrrrrrrrrrrrrr', 'General', 'rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', NULL, '697cde844a6a4_1769791108.jpg', 'active', 0, 0, 0.00, 0, '2026-01-30 22:38:28', '2026-02-01 00:48:13', NULL, NULL),
(10, 5, 2, 1, 'Lost', 'no', 'General', 'no', NULL, '697ce0b90a3ab_1769791673.jpg', '', 0, 0, 0.00, 0, '2026-01-30 22:47:53', '2026-01-31 21:11:19', NULL, NULL),
(11, 4, 1, 1, 'Lost', 'HHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH', 'General', 'GGGGGGGGGGGGGGGGGGGGGGGGGGGGG', NULL, '697e3573aaeda_1769878899.jpg', 'active', 0, 0, 0.00, 0, '2026-01-31 23:01:39', '2026-02-01 00:48:13', NULL, NULL),
(12, 4, 1, 1, 'Found', 'FOUUUUUUUUUUUNNNNNNNDDDDD', 'General', 'NNNNNNNNNNNNNNOOOOOOOOOOOOO', NULL, NULL, 'resolved', 0, 0, 0.00, 0, '2026-01-31 23:06:59', '2026-02-02 01:21:48', NULL, NULL),
(14, 4, 2, 1, 'Found', 'VAII', 'General', 'BAL', NULL, '697e4108b7f91_1769881864.png', 'resolved', 0, 0, 0.00, 0, '2026-01-31 23:51:04', '2026-02-01 00:48:25', NULL, NULL),
(15, 4, 1, 1, 'Lost', 'TEST MAP', 'General', 'NO', NULL, '697e50ae1e3c0_1769885870.jpg', 'active', 0, 0, 0.00, 0, '2026-02-01 00:57:50', '2026-02-01 00:57:50', 23.87736800, 90.32324100),
(16, 4, 2, 4, 'Found', 'ID CARD PAWA GESE', 'General', 'NO', NULL, '697e5c6555598_1769888869.jpeg', 'active', 0, 0, 0.00, 0, '2026-02-01 01:47:49', '2026-02-01 01:47:49', 23.87733400, 90.32273600),
(17, 4, 4, 1, 'Lost', 'LOST NOTICE', 'General', 'This is to inform that an umbrella has been lost inside or around Daffodil Medical Center. The umbrella is black in color, folding in type, with a black plastic handle and a small white spot on one side. If anyone has found the umbrella or has any information regarding it, kindly contact the number mentioned below. Your kind cooperation will be highly appreciated.\r\n\r\nContact: 01XXXXXXXXX\r\n\r\nThank you.', NULL, '69873493a4fe9_1770468499.jpg', 'active', 0, 0, 0.00, 0, '2026-02-07 18:48:19', '2026-02-07 18:53:58', 23.87853900, 90.33920600),
(18, 4, NULL, NULL, 'Lost', 'id card', 'General', 'id card', NULL, NULL, 'active', 0, 0, 0.00, 0, '2026-02-09 00:02:26', '2026-02-09 00:02:26', NULL, NULL),
(19, 4, 4, 1, 'Lost', 'ID CARD', 'General', 'ID CARD', NULL, '6988d0d78b0ff_1770574039.jpg', 'active', 0, 0, 0.00, 0, '2026-02-09 00:07:19', '2026-02-09 00:07:19', 23.87722400, 90.32158800),
(20, 4, 1, 1, 'Found', 'ID CARD', 'General', 'ID CARD', NULL, NULL, 'resolved', 0, 0, 0.00, 0, '2026-02-09 00:26:01', '2026-02-09 01:10:40', 23.87760900, 90.32302600),
(21, 4, 1, 1, 'Lost', 'HI', 'General', 'NKK', NULL, NULL, 'active', 0, 0, 0.00, 0, '2026-02-09 00:30:22', '2026-02-09 00:30:22', 23.87643500, 90.32287600),
(22, 6, 1, 1, 'Lost', 'NNNNNNNNNNNNNN', 'General', 'NNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN', NULL, '6988d6b169964_1770575537.jpg', 'active', 0, 0, 0.00, 0, '2026-02-09 00:32:17', '2026-02-09 00:32:17', 23.87768700, 90.32225400),
(23, 6, 2, 1, 'Found', 'MMMMMMMMMMMMMMMMMMM', 'General', 'LLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLL', NULL, '6988d70628877_1770575622.png', 'resolved', 0, 0, 0.00, 0, '2026-02-09 00:33:42', '2026-02-09 00:56:30', 23.87389300, 90.31023700),
(24, 5, 1, 1, 'Found', 'XXXXXXXXXXZZZZZZZ', 'General', 'CCCCCCCCCCCCCCCCCC', NULL, '6988e07f4ac8d_1770578047.png', 'resolved', 0, 0, 0.00, 0, '2026-02-09 01:14:07', '2026-02-09 01:15:00', 23.87787200, 90.31976400);

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('like','love','care','haha','wow','sad','angry') NOT NULL DEFAULT 'like',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`id`, `post_id`, `user_id`, `type`, `created_at`) VALUES
(1, 6, 1, 'love', '2026-01-30 15:50:08'),
(4, 5, 1, 'haha', '2026-01-30 16:12:05'),
(15, 3, 5, 'love', '2026-01-30 16:19:57'),
(19, 6, 5, 'wow', '2026-01-30 16:32:07'),
(20, 7, 5, 'wow', '2026-01-30 22:01:46'),
(21, 8, 5, 'care', '2026-01-30 22:26:26'),
(22, 9, 5, 'care', '2026-01-30 22:39:09'),
(23, 10, 1, 'love', '2026-01-31 01:33:45'),
(24, 5, 4, 'wow', '2026-01-31 21:10:22'),
(25, 11, 5, 'care', '2026-01-31 23:02:11'),
(26, 12, 5, 'care', '2026-01-31 23:47:06'),
(27, 14, 5, 'care', '2026-02-01 00:13:16'),
(28, 16, 6, 'sad', '2026-02-02 01:17:30'),
(29, 16, 4, 'love', '2026-02-07 15:55:39'),
(30, 17, 4, 'sad', '2026-02-07 18:48:45'),
(31, 22, 4, 'haha', '2026-02-09 00:37:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('student','faculty','admin','security') DEFAULT 'student',
  `points` int(11) DEFAULT 0,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'default-avatar.png',
  `trust_score` decimal(3,1) DEFAULT 5.0,
  `items_returned` int(11) DEFAULT 0,
  `items_claimed` int(11) DEFAULT 0,
  `false_claims` int(11) DEFAULT 0,
  `is_verified` tinyint(1) DEFAULT 0,
  `status` enum('active','banned','suspended') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `points`, `phone`, `avatar`, `trust_score`, `items_returned`, `items_claimed`, `false_claims`, `is_verified`, `status`, `created_at`) VALUES
(1, 'Admin User', 'admin@diu.edu.bd', '$2y$10$3Rj6jm30yqRP5GpDp3b2EuUqWT2YUG/yOKFA/KhFZpMCFqoxnxe16', 'admin', 0, '01454857545', 'avatar_697c833fd3a1a4.10072468.png', 10.0, 0, 0, 0, 1, 'active', '2026-01-30 03:29:16'),
(2, 'John Doe', 'john.doe@diu.edu.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 0, NULL, 'default-avatar.png', 8.5, 0, 0, 0, 1, 'active', '2026-01-30 03:29:16'),
(3, 'Sourav', 'apu@gmail.com', '$2y$10$V9fy1uT7Ih5qiY840sKAf.shJIAjm2YvUGw7YhB6ILmaoRqKSzgQC', 'student', 0, NULL, 'default-avatar.png', 5.0, 0, 0, 0, 0, 'active', '2026-01-30 09:32:10'),
(4, 'oyn', 'oyn@diu.edu.bd', '$2y$10$8u7pK3R5t6fXM9IpHFgei.OIQ2TuQ4PmJqgW899K9P.kJe.vHvlA6', '', 20, '01723521415', 'avatar_697e53aeb18793.83532250.jpg', 5.0, 0, 0, 0, 0, 'active', '2026-01-30 09:54:32'),
(5, 'fghfgjfhjhfj', 'gjhghjg@g.com', '$2y$10$JZj4XcdVNpAvu23C90CLA.Iux77MnFYfDFRGCqFo5N9Ka02hDaV2u', '', 10, '01412141518', 'avatar_697c7273e108a7.27229262.jpg', 5.0, 0, 0, 0, 0, 'active', '2026-01-30 10:42:06'),
(6, 'Abdul Jabber Jack', 'jack@gmail.com', '$2y$10$AM2UPUxn.MY6HFbw5rk3bOOlFwIegY5txMOzj4BS9Lq.ng0VrpA6e', 'student', 10, '01412141518', 'avatar_697e73bf75a135.25606982.jpg', 5.0, 0, 0, 0, 0, 'active', '2026-02-01 03:22:19');

-- --------------------------------------------------------

--
-- Table structure for table `user_badges`
--

CREATE TABLE `user_badges` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `badge_id` int(11) NOT NULL,
  `earned_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_action` (`action`),
  ADD KEY `idx_created` (`created_at`);

--
-- Indexes for table `archived_posts`
--
ALTER TABLE `archived_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_archived_date` (`archived_at`);

--
-- Indexes for table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `claims`
--
ALTER TABLE `claims`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_post` (`post_id`),
  ADD KEY `idx_claimant` (`claimant_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_type` (`type`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sender` (`sender_id`),
  ADD KEY `idx_receiver` (`receiver_id`),
  ADD KEY `idx_post` (`post_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_read` (`user_id`,`is_read`),
  ADD KEY `idx_created` (`created_at`),
  ADD KEY `actor_id` (`actor_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_location` (`location_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_created` (`created_at`);
ALTER TABLE `posts` ADD FULLTEXT KEY `idx_search` (`title`,`body`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_reaction` (`post_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_trust_score` (`trust_score`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_users_points` (`points`);

--
-- Indexes for table `user_badges`
--
ALTER TABLE `user_badges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_badge` (`user_id`,`badge_id`),
  ADD KEY `idx_badge` (`badge_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `archived_posts`
--
ALTER TABLE `archived_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `badges`
--
ALTER TABLE `badges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `claims`
--
ALTER TABLE `claims`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_badges`
--
ALTER TABLE `user_badges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `fk_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `claims`
--
ALTER TABLE `claims`
  ADD CONSTRAINT `fk_claims_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_claims_user` FOREIGN KEY (`claimant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_messages_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_messages_receiver` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_messages_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_posts_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_posts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reactions`
--
ALTER TABLE `reactions`
  ADD CONSTRAINT `reactions_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_badges`
--
ALTER TABLE `user_badges`
  ADD CONSTRAINT `fk_userbadges_badge` FOREIGN KEY (`badge_id`) REFERENCES `badges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_userbadges_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
