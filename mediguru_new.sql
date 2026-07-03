-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2022 at 12:19 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mediguru_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `mobile`, `role_id`, `password`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@mediguru.in', '1234567890', 1, '$2y$10$Hm1VkIK1rXDtHvt1Xy/NoetgVOphbWxSlR7I3S5KVgCVe7tts4xHW', 1, '2020-09-14 13:00:00', '2021-10-08 04:24:14'),
(8, 'qwerty', 'qwerty@gmail.com', '1234567888', 3, '$2y$10$Rket6SD/Vb5B9InBH5nk1ObylJ6tNHZCqh6I3/opIyBkSkhzYhPde', 1, '2022-07-19 00:36:35', '2022-07-19 01:31:23');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `unique_id` int(11) DEFAULT NULL,
  `course_name` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `course_icon` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `unique_id`, `course_name`, `description`, `course_icon`, `status`, `created_at`, `updated_at`) VALUES
(11, 4563, 'AIAPGET', '<p>czxcxc zcxzc xzcxz cxzzxcxzc</p><p> cxzcxz cxzcxzcxz cxz cxzcxzcxzcx</p><p>z erwwqew w wqw wqwq wqwwq eqweqe</p>', 'course_icons/icon_20211231010507.png', 1, '2021-12-31 11:36:22', '2022-07-14 07:00:52'),
(12, 1235, 'PSC', 'czxcxc zcxzc xzcxz cxzzxcxzc cxzcxz cxzcxzcxz cxz cxzcxzcxzcxz cxzcxzcxzcx xzczxcxzcczczxcxzcxzcxz\"\"', 'course_icons/icon_20211231010531.png', 1, '2021-12-31 11:36:22', '2021-12-31 13:05:31'),
(13, 3652, 'UPSC', 'czxcxc zcxzc xzcxz cxzzxcxzc cxzcxz cxzcxzcxz cxz cxzcxzcxzcxz cxzcxzcxzcx xzczxcxzcczczxcxzcxzcxz\"', 'course_icons/icon_20211231010507.png', 1, '2021-12-31 11:36:22', '2021-12-31 13:05:07'),
(14, 3456, 'TESTING', '<p>DSFSFFSFSDFDFFF FFDSFFDSFD</p><p>FSDFDSFFFDSFDSFDSFSFDSFDSF</p><p>FSD FDSFSDFDSFDSFDSFDSFDSFF</p><p>FSDFSFDSFDSFDSFDFF</p>', 'course_icons/fjv3jONpbGiVB1LG1CbAJDGT3jc27npUGw35vHBS.png', 1, '2022-07-14 07:01:25', '2022-07-14 07:01:25');

-- --------------------------------------------------------

--
-- Table structure for table `course_subjects`
--

CREATE TABLE `course_subjects` (
  `id` int(11) NOT NULL,
  `course_unique_id` int(11) NOT NULL,
  `subject_unique_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course_subjects`
--

INSERT INTO `course_subjects` (`id`, `course_unique_id`, `subject_unique_id`, `created_at`, `updated_at`) VALUES
(2, 4563, 113, '2022-07-12 07:28:36', '2022-07-12 07:28:36');

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_banners`
--

CREATE TABLE `dashboard_banners` (
  `id` int(11) NOT NULL,
  `banner_image` varchar(100) NOT NULL,
  `banner_section` tinyint(4) NOT NULL COMMENT '1-dashboard,2-subject page',
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dashboard_banners`
--

INSERT INTO `dashboard_banners` (`id`, `banner_image`, `banner_section`, `status`, `created_at`, `updated_at`) VALUES
(1, 'dashboard_banner/dash_banner_1.png', 1, 1, '2022-01-21 12:46:12', '2022-01-21 12:46:12'),
(2, 'dashboard_banner/dash_banner_2.png', 2, 1, '2022-01-21 12:46:12', '2022-01-21 12:46:12');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `lesson_name` varchar(100) DEFAULT NULL,
  `lesson_icon` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `subject_id`, `lesson_name`, `lesson_icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 12, 1, '[lesson-1]: Simulated Test', 'lesson_icons/kuYyz79ZffNxx787hq8zcyCD41oSZEiVM1cWXIZD.png', 1, '2022-07-14 07:22:12', '2022-07-15 04:59:18'),
(2, 11, 1, '[lesson-1]: Simulated Test-advanced', 'lesson_icons/3UQlXQGxQB82j7A45nHnXw9fehoHahZCbA7zciJW.png', 1, '2022-07-14 07:22:39', '2022-07-14 07:22:39'),
(4, 11, 8, '[lesson-10]: Testing', '', 1, '2022-07-15 05:27:24', '2022-07-15 05:27:24');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_live_tests`
--

CREATE TABLE `lesson_live_tests` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `live_unique_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lesson_live_tests`
--

INSERT INTO `lesson_live_tests` (`id`, `subject_id`, `lesson_id`, `live_unique_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 121, '2022-07-29 06:05:06', '2022-07-29 06:05:06'),
(2, 1, 1, 135, '2022-07-29 06:05:10', '2022-07-29 06:05:10');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_materials`
--

CREATE TABLE `lesson_materials` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `material_unique_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lesson_materials`
--

INSERT INTO `lesson_materials` (`id`, `subject_id`, `lesson_id`, `material_unique_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3876, '2022-07-29 06:00:35', '2022-07-29 06:00:35'),
(2, 1, 1, 1654, '2022-07-29 06:00:43', '2022-07-29 06:00:43');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_mcq_tests`
--

CREATE TABLE `lesson_mcq_tests` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `mcq_unique_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lesson_mcq_tests`
--

INSERT INTO `lesson_mcq_tests` (`id`, `subject_id`, `lesson_id`, `mcq_unique_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 120, '2022-07-28 11:38:47', '2022-07-28 11:38:47'),
(2, 1, 1, 132, '2022-07-28 11:42:59', '2022-07-28 11:42:59'),
(3, 1, 1, 128, '2022-07-28 11:43:02', '2022-07-28 11:43:02');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_videos`
--

CREATE TABLE `lesson_videos` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `video_unique_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lesson_videos`
--

INSERT INTO `lesson_videos` (`id`, `subject_id`, `lesson_id`, `video_unique_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4567, '2022-07-29 04:33:41', '2022-07-29 04:33:41'),
(2, 1, 1, 2345, '2022-07-29 04:33:45', '2022-07-29 04:33:45');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `unique_id` int(11) DEFAULT NULL,
  `material_title` varchar(100) DEFAULT NULL,
  `material_data` longtext DEFAULT NULL,
  `material_icon` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `unique_id`, `material_title`, `material_data`, `material_icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 1654, 'testing materials fsdfdfdf dsfdsfdsf', '<p>f fdsfd fdsfds fdsf dsfds fdsfddfdsfds fds fdsfdsfds fsfdsfdsfsdfs dfsdfsdfds fdsfdsfds fsdfdsfsd fsdfsdfsdfsd fdsfsdfdsfdsfdsfdsfds fdsfdsfdsfds fdsfdsfdsfsdfdsfds fdsfdsfdsfdsfsfdsfdsfsdfdsfdsfdsfdsfdsdfd ssdfsd</p><p><br></p><p><img style=\"width: 267px;\" src=\"data:image/png;base64,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\" data-filename=\"aa1.png\"></p><p>cf fdsfdsfdsfd dsfds fdsfdsfds fdsfdsfdsfsdfsdf</p><p>ddsf fdsdsfdf sdfdsfsdfdsf ds<br></p>', 'material_icons/S0gNTYDjyyzitEvlseyTfQJhYwIFDRgtChk4Chhj.png', 1, '2022-07-11 06:14:30', '2022-07-11 07:31:22');
INSERT INTO `materials` (`id`, `unique_id`, `material_title`, `material_data`, `material_icon`, `status`, `created_at`, `updated_at`) VALUES
(2, 3876, 'qwerty fdsfdsf fdsfsfsdfdf ddsfdsf', '<p>&nbsp;f fdsfdsfdf df dfdsf fds fdf dsfdsf dfd sfds fsd fd sfd fds f dfff sfsdfsd fsdfdsf fsfsdfsdf&nbsp; f fdsfdsfdf df dfdsf fds fdf dsfdsf dfd sfds fsd fd sfd fds f dfff sfsdfsd fsdfdsf fsfsdfsdf f fdsfdsfdf df dfdsf fds fdf dsfdsf dfd sfds fsd fd sfd fds f dfff sfsdfsd fsdfdsf fsfsdfsdf f fdsfdsfdf df dfdsf fds fdf dsfdsf dfd sfds fsd fd sfd fds f dfff sfsdfsd fsdfdsf fsfsdfsdf f fdsfdsfdf df dfdsf fds fdf dsfdsf dfd sfds fsd fd sfd fds f dfff sfsdfsd fsdfdsf fsfsdfsdf f fdsfdsfdf df dfdsf fds fdf dsfdsf dfd sfds fsd fd sfd fds f dfff sfsdfsd fsdfdsf fsfsdfsdf f fdsfdsfdf df dfdsf fds fdf dsfdsf dfd sfds fsd fd sfd fds f dfff sfsdfsd fsdfdsf fsfsdfsdf f fdsfdsfdf df dfdsf fds fdf dsfdsf dfd sfds fsd fd sfd fds f dfff sfsdfsd fsdfdsf fsfsdfsdf f fdsfdsfdf df dfdsf fds fdf dsfdsf dfd sfds fsd fd sfd fds f dfff sfsdfsd fsdfdsf fsfsdfsdf f fdsfdsfdf df dfdsf fds fdf dsfdsf dfd sfds fsd fd sfd fds f dfff sfsdfsd fsdfdsf fsfsdfsdf</p><p><br></p>', 'material_icons/IS05wAp3HcVNcUkGkQlXX42dUnjU7Tfxtq4NdApP.png', 1, '2022-07-11 07:32:20', '2022-07-11 07:32:20');

-- --------------------------------------------------------

--
-- Table structure for table `material_comments`
--

CREATE TABLE `material_comments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `mat_unique_id` int(11) NOT NULL,
  `material_title` varchar(150) DEFAULT NULL,
  `material_type` int(11) NOT NULL COMMENT '1-video, 2-pdf, 3- mock test, 4-live test',
  `comments` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `material_comments`
--

INSERT INTO `material_comments` (`id`, `student_id`, `mat_unique_id`, `material_title`, `material_type`, `comments`, `created_at`, `updated_at`) VALUES
(2, 1, 4567, 'fzdfd fdf dssd', 1, 'fsdfdsfdsfdsfds fdsfdsfdsfdsfdsfdsfdsfds fdsfds fdsfdsfdsfdsfdsfds fdsf d sf', '2022-07-27 10:30:53', '2022-07-27 10:30:53'),
(3, 1, 4567, 'qwerty fxdgfdg dfgfd', 2, 'gfdg gg g gfddfgfdgfdg dfdfgf dgggdgdfg ggdgdfgdf gfdgdfg dfgdfgdf gdf gfdgfdgfd gfdgfd gfgdfgg bvbvcbcvb \r\n vcbvcbvcbd gfdre rtreter rtterterer ', '2022-07-27 10:31:55', '2022-07-27 10:31:55');

-- --------------------------------------------------------

--
-- Table structure for table `material_likes`
--

CREATE TABLE `material_likes` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `mat_unique_id` int(11) NOT NULL,
  `material_title` varchar(150) DEFAULT NULL,
  `material_type` int(11) NOT NULL COMMENT '1-video, 2-pdf, 3- mock test, 4-live test',
  `likes` tinyint(4) NOT NULL COMMENT '1-like, 0-dislike',
  `dislikes` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `material_likes`
--

INSERT INTO `material_likes` (`id`, `student_id`, `mat_unique_id`, `material_title`, `material_type`, `likes`, `dislikes`, `created_at`, `updated_at`) VALUES
(1, 1, 4567, 'qwerty', 1, 2, 2, '2022-07-25 15:39:59', '2022-07-25 15:39:59'),
(4, 1, 2345, 'qwerty 11', 2, 3, 5, '2022-07-25 15:39:59', '2022-07-25 15:39:59'),
(7, 1, 1345, 'qwerty 11', 3, 1, 0, '2022-07-25 15:39:59', '2022-07-25 15:39:59'),
(8, 2, 3345, 'qwerty 11', 4, 0, 0, '2022-07-25 15:39:59', '2022-07-25 15:39:59');

-- --------------------------------------------------------

--
-- Table structure for table `mcq_all_results`
--

CREATE TABLE `mcq_all_results` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `mcq_question_paper_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `test_date` date DEFAULT NULL,
  `answer` int(11) DEFAULT NULL,
  `wrong` int(11) DEFAULT NULL,
  `skipped` int(11) DEFAULT NULL,
  `marks` varchar(10) DEFAULT NULL,
  `negative` float DEFAULT NULL,
  `score` float DEFAULT NULL,
  `total_time` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mcq_all_results`
--

INSERT INTO `mcq_all_results` (`id`, `subject_id`, `mcq_question_paper_id`, `student_id`, `test_date`, `answer`, `wrong`, `skipped`, `marks`, `negative`, `score`, `total_time`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 1, '2022-01-27', 0, 0, 14, '0/14', 0, 0, NULL, 1, '2022-01-27 08:28:16', '2022-01-27 08:28:16'),
(2, 2, 4, 1, '2022-01-27', 0, 0, 14, '0/14', 0, 0, NULL, 1, '2022-01-27 08:28:16', '2022-01-27 08:28:16'),
(3, 2, 4, 1, '2022-01-27', 0, 0, 14, '0/14', 0, 0, NULL, 1, '2022-01-27 08:28:16', '2022-01-27 08:28:16'),
(4, 3, 2, 1, '2022-01-27', 0, 0, 5, '0/5', 0, 0, NULL, 1, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(5, 3, 2, 1, '2022-01-27', 0, 0, 5, '0/5', 0, 0, NULL, 1, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(6, 3, 2, 1, '2022-01-27', 0, 0, 5, '0/5', 0, 0, NULL, 1, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(7, 1, NULL, 4, '2022-07-29', 0, 10, 0, '0/10', 0, 0, 120, 1, '2022-07-29 09:15:45', '2022-07-29 09:15:45'),
(8, 1, NULL, 4, '2022-07-29', 0, 10, 0, '0/10', 0, 0, 120, 1, '2022-07-29 09:26:33', '2022-07-29 09:26:33'),
(9, 1, 1, 4, '2022-07-29', 0, 10, 0, '0/10', 0, 0, 120, 1, '2022-07-29 09:28:50', '2022-07-29 09:28:50'),
(10, 1, NULL, 4, '2022-07-29', 2, 3, 0, '2/5', 0, 2, NULL, 1, '2022-07-29 10:00:11', '2022-07-29 10:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `mcq_emd_results`
--

CREATE TABLE `mcq_emd_results` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `mcq_question_paper_id` int(11) DEFAULT NULL,
  `easy_total` int(11) DEFAULT NULL,
  `easy_correct` int(11) DEFAULT NULL,
  `easy_wrong` int(11) DEFAULT NULL,
  `easy_skip` int(11) DEFAULT NULL,
  `medium_total` int(11) DEFAULT NULL,
  `medium_correct` int(11) DEFAULT NULL,
  `medium_wrong` int(11) DEFAULT NULL,
  `medium_skip` int(11) DEFAULT NULL,
  `difficult_total` int(11) DEFAULT NULL,
  `difficult_correct` int(11) DEFAULT NULL,
  `difficult_wrong` int(11) DEFAULT NULL,
  `difficult_skip` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mcq_emd_results`
--

INSERT INTO `mcq_emd_results` (`id`, `student_id`, `subject_id`, `mcq_question_paper_id`, `easy_total`, `easy_correct`, `easy_wrong`, `easy_skip`, `medium_total`, `medium_correct`, `medium_wrong`, `medium_skip`, `difficult_total`, `difficult_correct`, `difficult_wrong`, `difficult_skip`, `created_at`, `updated_at`) VALUES
(3, 4, 1, 1, 4, 0, 4, 0, 4, 0, 4, 0, 2, 0, 2, 0, '2022-07-29 09:28:50', '2022-07-29 09:28:50'),
(4, 4, 1, NULL, 1, 0, 1, 0, 1, 1, 0, 0, 2, 1, 1, 0, '2022-07-29 10:00:11', '2022-07-29 10:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `mcq_questions`
--

CREATE TABLE `mcq_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mcq_question_paper_id` int(11) NOT NULL,
  `question_mode` tinyint(4) DEFAULT NULL,
  `question_type` tinyint(4) NOT NULL COMMENT '1-text, 2-image',
  `question` varchar(300) DEFAULT NULL,
  `question_image` varchar(100) DEFAULT NULL,
  `answer_1` varchar(500) DEFAULT NULL,
  `answer_2` varchar(500) DEFAULT NULL,
  `answer_3` varchar(500) DEFAULT NULL,
  `answer_4` varchar(500) DEFAULT NULL,
  `correct_answer` int(11) DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mcq_questions`
--

INSERT INTO `mcq_questions` (`id`, `mcq_question_paper_id`, `question_mode`, `question_type`, `question`, `question_image`, `answer_1`, `answer_2`, `answer_3`, `answer_4`, `correct_answer`, `explanation`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, 'test question-11', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:00:28', '2022-01-27 08:00:28'),
(2, 3, 2, 1, 'test question-21', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 08:00:28', '2022-01-27 08:00:28'),
(3, 3, 3, 1, 'test question-31', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 08:00:28', '2022-01-27 08:00:28'),
(4, 3, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 08:00:28', '2022-01-27 08:00:28'),
(5, 3, 2, 1, 'test question-51', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:00:28', '2022-01-27 08:00:28'),
(6, 2, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 08:01:53', '2022-01-27 08:01:53'),
(7, 2, 4, 1, 'test question-61', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 08:01:53', '2022-01-27 08:01:53'),
(8, 2, 3, 1, 'test question-81', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 08:01:53', '2022-01-27 08:01:53'),
(9, 2, 2, 1, 'test question-21', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 08:01:53', '2022-01-27 08:01:53'),
(10, 2, 3, 1, 'test question-31', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 08:01:53', '2022-01-27 08:01:53'),
(11, 4, 2, 1, 'test question-21', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 08:02:55', '2022-01-27 08:02:55'),
(12, 4, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 08:02:55', '2022-01-27 08:02:55'),
(13, 4, 2, 1, 'test question-51', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:02:55', '2022-01-27 08:02:55'),
(14, 4, 2, 1, 'test question-71', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:02:55', '2022-01-27 08:02:55'),
(15, 4, 3, 1, 'test question-81', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 08:02:55', '2022-01-27 08:02:55'),
(16, 4, 1, 1, 'test question-11', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:06:13', '2022-01-27 08:06:13'),
(17, 4, 2, 1, 'test question-21', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 08:06:13', '2022-01-27 08:06:13'),
(18, 4, 3, 1, 'test question-31', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 08:06:13', '2022-01-27 08:06:13'),
(19, 4, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 08:06:13', '2022-01-27 08:06:13'),
(20, 4, 2, 1, 'test question-51', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:06:13', '2022-01-27 08:06:13'),
(21, 16, 1, 1, 'test question-61', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 08:06:13', '2022-01-27 08:06:13'),
(22, 16, 2, 1, 'test question-71', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:06:13', '2022-01-27 08:06:13'),
(23, 16, 3, 1, 'test question-81', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 08:06:13', '2022-01-27 08:06:13'),
(24, 16, 1, 1, 'test question-91', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 08:06:13', '2022-01-27 08:06:13'),
(25, 6, 2, 1, 'test question-21', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 08:11:19', '2022-01-27 08:11:19'),
(26, 6, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 08:11:19', '2022-01-27 08:11:19'),
(27, 6, 1, 1, 'test question-61', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 08:11:19', '2022-01-27 08:11:19'),
(28, 6, 3, 1, 'test question-81', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 08:11:19', '2022-01-27 08:11:19'),
(29, 3, 1, 1, 'test question-11', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:14:03', '2022-01-27 08:14:03'),
(30, 3, 2, 1, 'test question-21', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 08:14:03', '2022-01-27 08:14:03'),
(31, 3, 3, 1, 'test question-31', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 08:14:03', '2022-01-27 08:14:03'),
(32, 3, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 08:14:03', '2022-01-27 08:14:03'),
(33, 3, 2, 1, 'test question-51', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:14:03', '2022-01-27 08:14:03'),
(34, 3, 1, 1, 'test question-61', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 08:14:03', '2022-01-27 08:14:03'),
(35, 3, 2, 1, 'test question-71', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:14:03', '2022-01-27 08:14:03'),
(36, 3, 3, 1, 'test question-81', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 08:14:03', '2022-01-27 08:14:03'),
(37, 3, 1, 1, 'test question-91', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 08:14:03', '2022-01-27 08:14:03'),
(38, 3, 1, 1, 'test question-11', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:17:02', '2022-01-27 08:17:02'),
(39, 3, 2, 1, 'test question-21', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 08:17:02', '2022-01-27 08:17:02'),
(40, 3, 3, 1, 'test question-31', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 08:17:02', '2022-01-27 08:17:02'),
(41, 3, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 08:17:02', '2022-01-27 08:17:02'),
(42, 3, 2, 1, 'test question-51', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:17:02', '2022-01-27 08:17:02'),
(43, 3, 1, 1, 'test question-61', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 08:17:02', '2022-01-27 08:17:02'),
(44, 3, 2, 1, 'test question-71', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:17:02', '2022-01-27 08:17:02'),
(45, 3, 3, 1, 'test question-81', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 08:17:02', '2022-01-27 08:17:02'),
(46, 3, 1, 1, 'test question-91', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 08:17:02', '2022-01-27 08:17:02'),
(47, 7, 1, 1, 'test question-11', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:21:20', '2022-01-27 08:21:20'),
(48, 7, 2, 1, 'test question-21', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 08:21:20', '2022-01-27 08:21:20'),
(49, 7, 3, 1, 'test question-31', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 08:21:20', '2022-01-27 08:21:20'),
(50, 7, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 08:21:20', '2022-01-27 08:21:20'),
(51, 7, 2, 1, 'test question-51', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:21:20', '2022-01-27 08:21:20'),
(52, 7, 1, 1, 'test question-61', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 08:21:20', '2022-01-27 08:21:20'),
(53, 7, 2, 1, 'test question-71', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 08:21:20', '2022-01-27 08:21:20'),
(54, 7, 3, 1, 'test question-81', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 08:21:20', '2022-01-27 08:21:20'),
(55, 7, 1, 1, 'test question-91', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 08:21:20', '2022-01-27 08:21:20'),
(56, 1, 1, 1, 'test question-11', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-07-15 04:57:45', '2022-07-15 04:57:45'),
(57, 1, 2, 1, 'test question-51', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-07-15 04:57:45', '2022-07-15 04:57:45'),
(58, 1, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-07-15 04:57:45', '2022-07-15 04:57:45'),
(59, 1, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-07-15 05:12:44', '2022-07-15 05:12:44'),
(60, 1, 3, 1, 'test question-31', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-07-15 05:12:44', '2022-07-15 05:12:44');

-- --------------------------------------------------------

--
-- Table structure for table `mcq_question_papers`
--

CREATE TABLE `mcq_question_papers` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `unique_id` int(11) NOT NULL,
  `question_paper_type` int(11) DEFAULT NULL,
  `question_paper_name` varchar(100) NOT NULL,
  `premium` tinyint(4) DEFAULT NULL,
  `instruction` text DEFAULT NULL,
  `test_time` int(11) NOT NULL,
  `test_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `start_time_text` varchar(50) DEFAULT NULL,
  `schedule_date` date DEFAULT NULL,
  `question_paper_icon` varchar(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mcq_question_papers`
--

INSERT INTO `mcq_question_papers` (`id`, `course_id`, `unique_id`, `question_paper_type`, `question_paper_name`, `premium`, `instruction`, `test_time`, `test_date`, `start_time`, `start_time_text`, `schedule_date`, `question_paper_icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 11, 120, 1, 'qwe-143232', 0, '<p>ffds d fdsfdsfd fdssd</p><p>fds dsf dfdsfd fdfds fdsfdsfds fdsfdsf df ds ffdsfds fds</p>', 45, NULL, NULL, NULL, '2022-07-13', 'qpaper_icons/GnR5HUzeijPgkWhVNN6nS80jfARkjjArSqdybOhl.png', 1, '2022-07-13 08:19:37', '2022-07-15 12:25:05'),
(2, 11, 121, 2, 'qwerty-145555', 0, '<p>dasdasdasd sadsd dsadas d</p><p>da dasdasd sd</p><p>sad</p><p>dsa</p><p>d&nbsp;</p>', 45, '2022-07-16', '22:30:00', '10:30 PM', NULL, 'qpaper_icons/bR5kTpRIB3sZoPHtRYUfKu9hhVqXRA9GPFvlCl2U.png', 1, '2022-07-15 12:44:29', '2022-07-15 12:59:12'),
(3, 11, 122, 1, 'ASD-143232', 0, '<p>ffds d fdsfdsfd fdssd</p><p>fds dsf dfdsfd fdfds fdsfdsfds fdsfdsf df ds ffdsfds fds</p>', 45, NULL, NULL, NULL, '2022-07-13', 'qpaper_icons/GnR5HUzeijPgkWhVNN6nS80jfARkjjArSqdybOhl.png', 1, '2022-07-13 08:19:37', '2022-07-15 12:25:05'),
(4, 11, 123, 2, 'RTY-145555', 0, '<p>dasdasdasd sadsd dsadas d</p><p>da dasdasd sd</p><p>sad</p><p>dsa</p><p>d&nbsp;</p>', 45, '2022-07-16', '22:30:00', '10:30 PM', NULL, 'qpaper_icons/bR5kTpRIB3sZoPHtRYUfKu9hhVqXRA9GPFvlCl2U.png', 1, '2022-07-15 12:44:29', '2022-07-15 12:59:12'),
(5, 11, 124, 1, 'MCB-143232', 0, '<p>ffds d fdsfdsfd fdssd</p><p>fds dsf dfdsfd fdfds fdsfdsfds fdsfdsf df ds ffdsfds fds</p>', 45, NULL, NULL, NULL, '2022-07-13', 'qpaper_icons/GnR5HUzeijPgkWhVNN6nS80jfARkjjArSqdybOhl.png', 1, '2022-07-13 08:19:37', '2022-07-15 12:25:05'),
(6, 11, 125, 2, 'YUT-145555', 0, '<p>dasdasdasd sadsd dsadas d</p><p>da dasdasd sd</p><p>sad</p><p>dsa</p><p>d&nbsp;</p>', 45, '2022-07-16', '22:30:00', '10:30 PM', NULL, 'qpaper_icons/bR5kTpRIB3sZoPHtRYUfKu9hhVqXRA9GPFvlCl2U.png', 1, '2022-07-15 12:44:29', '2022-07-15 12:59:12'),
(7, 11, 126, 1, 'WERT-143232', 0, '<p>ffds d fdsfdsfd fdssd</p><p>fds dsf dfdsfd fdfds fdsfdsfds fdsfdsf df ds ffdsfds fds</p>', 45, NULL, NULL, NULL, '2022-07-13', 'qpaper_icons/GnR5HUzeijPgkWhVNN6nS80jfARkjjArSqdybOhl.png', 1, '2022-07-13 08:19:37', '2022-07-15 12:25:05'),
(8, 11, 127, 2, 'YUTR-145555', 0, '<p>dasdasdasd sadsd dsadas d</p><p>da dasdasd sd</p><p>sad</p><p>dsa</p><p>d&nbsp;</p>', 45, '2022-07-16', '22:30:00', '10:30 PM', NULL, 'qpaper_icons/bR5kTpRIB3sZoPHtRYUfKu9hhVqXRA9GPFvlCl2U.png', 1, '2022-07-15 12:44:29', '2022-07-15 12:59:12'),
(9, 11, 128, 1, 'KYUT-143232', 0, '<p>ffds d fdsfdsfd fdssd</p><p>fds dsf dfdsfd fdfds fdsfdsfds fdsfdsf df ds ffdsfds fds</p>', 45, NULL, NULL, NULL, '2022-07-13', 'qpaper_icons/GnR5HUzeijPgkWhVNN6nS80jfARkjjArSqdybOhl.png', 1, '2022-07-13 08:19:37', '2022-07-15 12:25:05'),
(10, 11, 129, 2, 'KKUU-145555', 0, '<p>dasdasdasd sadsd dsadas d</p><p>da dasdasd sd</p><p>sad</p><p>dsa</p><p>d&nbsp;</p>', 45, '2022-07-16', '22:30:00', '10:30 PM', NULL, 'qpaper_icons/bR5kTpRIB3sZoPHtRYUfKu9hhVqXRA9GPFvlCl2U.png', 1, '2022-07-15 12:44:29', '2022-07-15 12:59:12'),
(11, 11, 130, 1, 'MMMMHH-143232', 0, '<p>ffds d fdsfdsfd fdssd</p><p>fds dsf dfdsfd fdfds fdsfdsfds fdsfdsf df ds ffdsfds fds</p>', 45, NULL, NULL, NULL, '2022-07-13', 'qpaper_icons/GnR5HUzeijPgkWhVNN6nS80jfARkjjArSqdybOhl.png', 1, '2022-07-13 08:19:37', '2022-07-15 12:25:05'),
(12, 11, 131, 2, 'YTR-145555', 0, '<p>dasdasdasd sadsd dsadas d</p><p>da dasdasd sd</p><p>sad</p><p>dsa</p><p>d&nbsp;</p>', 45, '2022-07-16', '22:30:00', '10:30 PM', NULL, 'qpaper_icons/bR5kTpRIB3sZoPHtRYUfKu9hhVqXRA9GPFvlCl2U.png', 1, '2022-07-15 12:44:29', '2022-07-15 12:59:12'),
(13, 11, 132, 1, 'KKKty-143232', 0, '<p>ffds d fdsfdsfd fdssd</p><p>fds dsf dfdsfd fdfds fdsfdsfds fdsfdsf df ds ffdsfds fds</p>', 45, NULL, NULL, NULL, '2022-07-13', 'qpaper_icons/GnR5HUzeijPgkWhVNN6nS80jfARkjjArSqdybOhl.png', 1, '2022-07-13 08:19:37', '2022-07-15 12:25:05'),
(14, 11, 133, 2, 'EEEty-145555', 0, '<p>dasdasdasd sadsd dsadas d</p><p>da dasdasd sd</p><p>sad</p><p>dsa</p><p>d&nbsp;</p>', 45, '2022-07-16', '22:30:00', '10:30 PM', NULL, 'qpaper_icons/bR5kTpRIB3sZoPHtRYUfKu9hhVqXRA9GPFvlCl2U.png', 1, '2022-07-15 12:44:29', '2022-07-15 12:59:12'),
(15, 11, 134, 1, 'BBBty-143232', 0, '<p>ffds d fdsfdsfd fdssd</p><p>fds dsf dfdsfd fdfds fdsfdsfds fdsfdsf df ds ffdsfds fds</p>', 45, NULL, NULL, NULL, '2022-07-13', 'qpaper_icons/GnR5HUzeijPgkWhVNN6nS80jfARkjjArSqdybOhl.png', 1, '2022-07-13 08:19:37', '2022-07-15 12:25:05'),
(16, 11, 135, 2, 'HHty-145555', 0, '<p>dasdasdasd sadsd dsadas d</p><p>da dasdasd sd</p><p>sad</p><p>dsa</p><p>d&nbsp;</p>', 45, '2022-07-16', '22:30:00', '10:30 PM', NULL, 'qpaper_icons/bR5kTpRIB3sZoPHtRYUfKu9hhVqXRA9GPFvlCl2U.png', 1, '2022-07-15 12:44:29', '2022-07-15 12:59:12');

-- --------------------------------------------------------

--
-- Table structure for table `mcq_test_all_results`
--

CREATE TABLE `mcq_test_all_results` (
  `id` int(11) NOT NULL,
  `result_date` date DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `mcq_question_paper_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `question_mode` tinyint(4) DEFAULT NULL,
  `question_type` tinyint(4) DEFAULT NULL,
  `correct_answer` int(11) DEFAULT NULL,
  `answer` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mcq_test_all_results`
--

INSERT INTO `mcq_test_all_results` (`id`, `result_date`, `subject_id`, `mcq_question_paper_id`, `student_id`, `question_id`, `question_mode`, `question_type`, `correct_answer`, `answer`, `created_at`, `updated_at`) VALUES
(81, '2022-07-29', 1, 1, 4, 5, 2, 1, 2, 4, '2022-07-29 09:28:50', '2022-07-29 09:28:50'),
(80, '2022-07-29', 1, 1, 4, 4, 1, 1, 1, 3, '2022-07-29 09:28:50', '2022-07-29 09:28:50'),
(79, '2022-07-29', 1, 1, 4, 3, 3, 1, 4, 2, '2022-07-29 09:28:50', '2022-07-29 09:28:50'),
(31, '2022-01-27', 3, 2, 5, 9, 2, 1, 3, 3, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(30, '2022-01-27', 3, 2, 2, 8, 3, 1, 4, 4, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(29, '2022-01-27', 3, 2, 1, 7, 1, 1, 1, 1, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(28, '2022-01-27', 3, 2, 3, 6, 1, 1, 1, 2, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(27, '2022-01-27', 3, 2, 5, 9, 2, 1, 3, 3, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(26, '2022-01-27', 3, 2, 2, 8, 3, 1, 4, 4, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(25, '2022-01-27', 3, 2, 1, 7, 1, 1, 1, 1, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(24, '2022-01-27', 3, 2, 3, 6, 1, 1, 1, 2, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(23, '2022-01-27', 3, 2, 5, 9, 2, 1, 3, 3, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(22, '2022-01-27', 3, 2, 2, 8, 3, 1, 4, 4, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(21, '2022-01-27', 3, 2, 1, 7, 1, 1, 1, 1, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(15, '2022-01-27', 3, 2, 3, 6, 1, 1, 1, 2, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(16, '2022-01-27', 3, 2, 1, 7, 1, 1, 1, 1, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(17, '2022-01-27', 3, 2, 2, 8, 3, 1, 4, 4, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(18, '2022-01-27', 3, 2, 5, 9, 2, 1, 3, 3, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(20, '2022-01-27', 3, 2, 3, 6, 1, 1, 1, 2, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(78, '2022-07-29', 1, 1, 4, 2, 2, 1, 3, 4, '2022-07-29 09:28:50', '2022-07-29 09:28:50'),
(77, '2022-07-29', 1, 1, 4, 1, 1, 1, 2, 3, '2022-07-29 09:28:50', '2022-07-29 09:28:50'),
(76, '2022-07-29', 1, 1, 4, 5, 2, 1, 2, 4, '2022-07-29 09:28:50', '2022-07-29 09:28:50'),
(75, '2022-07-29', 1, 1, 4, 4, 1, 1, 1, 3, '2022-07-29 09:28:50', '2022-07-29 09:28:50'),
(74, '2022-07-29', 1, 1, 4, 3, 3, 1, 4, 2, '2022-07-29 09:28:50', '2022-07-29 09:28:50'),
(73, '2022-07-29', 1, 1, 4, 2, 2, 1, 3, 4, '2022-07-29 09:28:50', '2022-07-29 09:28:50'),
(72, '2022-07-29', 1, 1, 4, 1, 1, 1, 2, 3, '2022-07-29 09:28:50', '2022-07-29 09:28:50'),
(86, '2022-07-29', 1, NULL, 4, 10, 3, 1, 4, 4, '2022-07-29 10:00:11', '2022-07-29 10:00:11'),
(85, '2022-07-29', 1, NULL, 4, 9, 2, 1, 3, 3, '2022-07-29 10:00:11', '2022-07-29 10:00:11'),
(84, '2022-07-29', 1, NULL, 4, 8, 3, 1, 4, 2, '2022-07-29 10:00:11', '2022-07-29 10:00:11'),
(83, '2022-07-29', 1, NULL, 4, 7, 4, 1, 1, 4, '2022-07-29 10:00:11', '2022-07-29 10:00:11'),
(82, '2022-07-29', 1, NULL, 4, 6, 1, 1, 1, 3, '2022-07-29 10:00:11', '2022-07-29 10:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `mcq_test_results`
--

CREATE TABLE `mcq_test_results` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `mcq_question_paper_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `test_date` date DEFAULT NULL,
  `answer` int(11) DEFAULT NULL,
  `wrong` int(11) DEFAULT NULL,
  `skipped` int(11) DEFAULT NULL,
  `marks` varchar(10) DEFAULT NULL,
  `negative` float DEFAULT NULL,
  `score` float DEFAULT NULL,
  `total_time` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mcq_test_results`
--

INSERT INTO `mcq_test_results` (`id`, `subject_id`, `mcq_question_paper_id`, `student_id`, `test_date`, `answer`, `wrong`, `skipped`, `marks`, `negative`, `score`, `total_time`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 1, '2022-01-27', 0, 0, 14, '0/14', 0, 0, 125, 1, '2022-01-27 08:28:16', '2022-01-27 08:28:16'),
(2, 3, 2, 1, '2022-01-27', 0, 0, 5, '0/5', 0, 0, 125, 1, '2022-01-27 08:28:34', '2022-01-27 08:28:34'),
(3, 1, 2, 4, '2022-07-29', 0, 10, 0, '0/10', 0, 0, 120, 1, '2022-07-29 09:15:45', '2022-07-29 09:15:45'),
(4, 1, 1, 4, '2022-07-29', 0, 10, 0, '0/10', 0, 0, 120, 1, '2022-07-29 09:26:33', '2022-07-29 09:26:33'),
(5, 1, 1, 4, '2022-07-29', 0, 10, 0, '0/10', 0, 0, 120, 1, '2022-07-29 09:28:50', '2022-07-29 09:28:50'),
(6, 1, NULL, 4, '2022-07-29', 2, 3, 0, '2/5', 0, 2, NULL, 1, '2022-07-29 10:00:11', '2022-07-29 10:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('01e5faffae831c1335db562be4799fed1745dfc064f9e8735a9f3d6c76ac094a187ec78e194c3e38', 8, 1, 'becompetitive', '[]', 0, '2022-01-20 05:56:26', '2022-01-20 05:56:26', '2023-01-20 05:56:26'),
('0d270fb95f5f128ad1de5791440400e5a20d5922a05599811124017e0e35388e60ea32ab62f8a083', 37, 1, 'becompetitive', '[]', 0, '2022-01-26 09:23:32', '2022-01-26 09:23:32', '2023-01-26 09:23:32'),
('0fcfda04899a9f2d7785b998a12ffe6534bcee2a70cf9f69935642e4771871e44abd78a00235baa3', 37, 1, 'becompetitive', '[]', 0, '2022-01-26 09:16:33', '2022-01-26 09:16:33', '2023-01-26 09:16:33'),
('10c7cbd21f336ed998eded86aed848b5de0f0bc03e8d3cff64398268f1f74717b53b7e37161e6e2f', 44, 1, 'becompetitive', '[]', 0, '2022-01-27 10:18:26', '2022-01-27 10:18:26', '2023-01-27 10:18:26'),
('17506a9a040b1d5389dabfae7ff635984468e2b61f2e8f523c6d5fa187fbde98a38c67cafabe0684', 35, 1, 'becompetitive', '[]', 0, '2022-01-20 07:05:40', '2022-01-20 07:05:40', '2023-01-20 07:05:40'),
('1a1a2e47de1328baca159293e6e427b88f9aaec3be8a9203d1498a5386276260abb03e0f0b9a86a1', 43, 1, 'becompetitive', '[]', 0, '2022-01-27 03:59:07', '2022-01-27 03:59:07', '2023-01-27 03:59:07'),
('20a8f77969d3ae32cd96ca83b6e462c44cc73d14a2e28aa34c8e1c4b796a0192ecbf48ce367bacb6', 42, 1, 'becompetitive', '[]', 0, '2022-01-27 08:35:12', '2022-01-27 08:35:12', '2023-01-27 08:35:12'),
('215d49132d16190631709549e96139286e823e0cfc62417387e27109b6f6c76fd5d01d71a0793cb1', 35, 1, 'becompetitive', '[]', 0, '2022-01-24 04:12:29', '2022-01-24 04:12:29', '2023-01-24 04:12:29'),
('21a24cbce66a45abadd1470d8e5d02b4d0c0c11703894e2200895f5ca6a08d64fef2b7b7651f161f', 3, 1, 'becompetitive', '[]', 0, '2022-01-14 03:40:11', '2022-01-14 03:40:11', '2023-01-14 09:10:11'),
('241d760b045c63dc4721b499a134107d79846eaa8a48ed71f80c7b4eb98d33b4b6eeab0620bca21b', 40, 1, 'becompetitive', '[]', 0, '2022-01-26 12:33:15', '2022-01-26 12:33:15', '2023-01-26 12:33:15'),
('2560f4a64678d63602dd7f24196e96648527f460f15a00d96e9c2144cd1025fe416aec0a18f8ebfc', 43, 1, 'becompetitive', '[]', 0, '2022-01-27 04:04:22', '2022-01-27 04:04:22', '2023-01-27 04:04:22'),
('26bcf3b1577d17749e0610621884ed2117ed5873950618fb090c38226d005ea977dcd7ea40371d5f', 42, 3, 'becompetitive', '[]', 0, '2022-07-21 06:53:12', '2022-07-21 06:53:12', '2023-07-21 12:23:12'),
('2a16a4aec243cfd11ddab780cc65ee334bd9d4bcd67943c99877944f7dd90ca7d07adfba76dc83c8', 3, 1, 'becompetitive', '[]', 0, '2022-01-15 09:33:37', '2022-01-15 09:33:37', '2023-01-15 09:33:37'),
('2b35c0c85e2c84ffdc82030a0ce4358f98b477a73281cd9319bea4c5860ca7aee5e0dd63634707dc', 35, 1, 'becompetitive', '[]', 0, '2022-01-21 05:26:35', '2022-01-21 05:26:35', '2023-01-21 05:26:35'),
('2dba7b3c07b91181ef8a35d5f9098ddad5f08ea7563e9e38411c245d67afc321484e8eac503f9b1b', 37, 1, 'becompetitive', '[]', 0, '2022-01-24 08:22:29', '2022-01-24 08:22:29', '2023-01-24 08:22:29'),
('2fa9b910d5c02e72c287f60c238d511773c86fb09609a4354cf3590588ad7a4769c762f7c11198d6', 33, 1, 'becompetitive', '[]', 0, '2022-01-19 06:54:28', '2022-01-19 06:54:28', '2023-01-19 06:54:28'),
('30ecf92d14c1ae986e4aab84c6f8b6ea039f8fe598c08d18aa2a600fb0011f53957d42e311826a97', 35, 1, 'becompetitive', '[]', 0, '2022-01-21 05:23:55', '2022-01-21 05:23:55', '2023-01-21 05:23:55'),
('316d60e7c40c019c7dd626e7db32ccfcf387b8b34765046671fe41fb13abcfc4f7428aa22eba0422', 33, 1, 'becompetitive', '[]', 0, '2022-01-19 06:53:12', '2022-01-19 06:53:12', '2023-01-19 06:53:12'),
('31ff1f858d2ab02347e2abbaba90d305da8f4973c83ec9f36068cc7db3f6096855282cc2d8d21388', 3, 1, 'becompetitive', '[]', 0, '2022-01-14 03:41:55', '2022-01-14 03:41:55', '2023-01-14 09:11:55'),
('32c73b74cf1c7a204ea07c6b29337bd8fe2f860c48fe6a4595e42687d6701e570ac3fbf57b559dde', 35, 1, 'becompetitive', '[]', 0, '2022-01-21 05:32:00', '2022-01-21 05:32:00', '2023-01-21 05:32:00'),
('33b296fc3058724aaddbd706daef10490c6a21ce2997e33f95d7d09ecf5b3263231528781f8e9098', 42, 3, 'becompetitive', '[]', 0, '2022-07-21 06:35:08', '2022-07-21 06:35:08', '2023-07-21 12:05:08'),
('3788dbec6adbb7e2fa000b183b53e2cd324632c830cc287af50473ec570dbe5e180f51408d5893f4', 43, 1, 'becompetitive', '[]', 0, '2022-01-27 05:36:01', '2022-01-27 05:36:01', '2023-01-27 05:36:01'),
('379717a228ab2f1e04627fc2130195a5026e65c799d4729ee2ac1340896641a13571cea1e3ae246b', 40, 1, 'becompetitive', '[]', 0, '2022-01-26 11:14:39', '2022-01-26 11:14:39', '2023-01-26 11:14:39'),
('387591fa2036ae6dfce46ec3b0d1c171956fd825bcf00e6660711b8aa03b92e0e2e13cb687d362fe', 35, 1, 'becompetitive', '[]', 0, '2022-01-21 05:08:59', '2022-01-21 05:08:59', '2023-01-21 05:08:59'),
('388e72ff75cf8acb2cf485f561e8e4f84b01f03a14150bac1efd44ca4b8b8d939f85e8a8b9843f1a', 3, 1, 'becompetitive', '[]', 0, '2022-01-19 04:10:18', '2022-01-19 04:10:18', '2023-01-19 04:10:18'),
('41d0eaa7cbadc68cd3de941447ce8ee711711d7b88098efb777dfb0844c42802378564d94ad6432f', 3, 1, 'becompetitive', '[]', 0, '2022-01-27 06:48:36', '2022-01-27 06:48:36', '2023-01-27 06:48:36'),
('41fb73adbd216302abb1b3ab5d4a4c29d87b7751091652b646eb2d0da7a56a26259a638095ce9f45', 35, 1, 'becompetitive', '[]', 0, '2022-01-22 04:34:45', '2022-01-22 04:34:45', '2023-01-22 04:34:45'),
('464c60392025f78ab63c1f42a8292eb4f4d0377d2df71169201c38e26b2eaf0976582ebb555782a1', 3, 1, 'becompetitive', '[]', 0, '2022-01-14 03:34:17', '2022-01-14 03:34:17', '2023-01-14 09:04:17'),
('4784f8d3ef186af98d8bdc6488f6eaf45f10fd2467b871621dc34062ea8e40089c8c1ec1901f7fc0', 35, 1, 'becompetitive', '[]', 0, '2022-01-20 07:41:47', '2022-01-20 07:41:47', '2023-01-20 07:41:47'),
('483229900b40598741eec6cddd228fce693dbd21663aa429b03e003cb6ac98aa069ff90eca50614f', 42, 3, 'becompetitive', '[]', 0, '2022-07-29 03:40:14', '2022-07-29 03:40:14', '2023-07-29 09:10:14'),
('48f09e3fbed46204097a1f9382749c60faf34ccaf35c257d672cbb358fa8702a6220293f521bd681', 3, 1, 'becompetitive', '[]', 0, '2022-01-21 04:36:51', '2022-01-21 04:36:51', '2023-01-21 04:36:51'),
('4933fa3cde56c1f53dfeaa021d9ff77222282a96de5c6dd694cffeae7153d1b412829e1dfb20ff12', 42, 1, 'becompetitive', '[]', 0, '2022-01-26 13:54:58', '2022-01-26 13:54:58', '2023-01-26 13:54:58'),
('4d1dac0abae314ef97cd185b20e5ac543d14b0cc356b3132b10bdfee53c2532e961e55e66ee5859a', 3, 1, 'becompetitive', '[]', 0, '2022-01-26 04:48:21', '2022-01-26 04:48:21', '2023-01-26 04:48:21'),
('4d546fdcc8bdc6d6b0bab6c038c9cc4c4003a010373205a3791f522e3c27c04d418fa40e9d31b14a', 42, 3, 'becompetitive', '[]', 0, '2022-07-21 06:31:54', '2022-07-21 06:31:54', '2023-07-21 12:01:54'),
('4e04b28d824aad6b8965de3716d936985573d7aae45ebabf0a4e9e6f5cb425f1d8e61f9085956868', 42, 3, 'becompetitive', '[]', 0, '2022-07-22 02:00:53', '2022-07-22 02:00:53', '2023-07-22 07:30:53'),
('4e132dbf809463932178cff0ec00e25c11924f167b738a71773fa9e82d51ac5e4b23195e79715c97', 3, 1, 'becompetitive', '[]', 0, '2022-01-14 03:42:40', '2022-01-14 03:42:40', '2023-01-14 09:12:40'),
('506f3c3c960c1a2c1eefbe4d788acfd1f67031dc4560341b1e9fa5f0502aecd5d2f82fd40f5d9b81', 42, 3, 'becompetitive', '[]', 0, '2022-07-21 06:27:44', '2022-07-21 06:27:44', '2023-07-21 11:57:44'),
('508a687fd235b1e28806bc1c8664576546d9683c6869c9ae9ddf08f77e5a021243203ec95c9ad84a', 42, 3, 'becompetitive', '[]', 0, '2022-07-21 06:34:00', '2022-07-21 06:34:00', '2023-07-21 12:04:00'),
('56d960b80c47a613243f626641cc884b726000b2826b12eeaa4cb3b9b4793c22dff2d6f07e53ba95', 35, 1, 'becompetitive', '[]', 0, '2022-01-22 10:18:45', '2022-01-22 10:18:45', '2023-01-22 10:18:45'),
('5a27d05210f27138f05b422388589cadbf6d3839fd121a9e8279bd001519266c57010376dd86cb81', 35, 1, 'becompetitive', '[]', 0, '2022-01-25 05:54:46', '2022-01-25 05:54:46', '2023-01-25 05:54:46'),
('5a8575e4fe4aec22bf1a014dec17e1a3f396b3bd6bd13a151e3938be237ec34e37ea02e9c5ab52a0', 42, 3, 'becompetitive', '[]', 0, '2022-07-28 05:48:27', '2022-07-28 05:48:27', '2023-07-28 11:18:27'),
('5b145c319705805b437f5d00e35e23a7bf16fdc4dab8e267c91e06138f1180fb7bf7f6a0d75dd7aa', 35, 1, 'becompetitive', '[]', 0, '2022-01-21 07:35:52', '2022-01-21 07:35:52', '2023-01-21 07:35:52'),
('5ed5fc269fa283a2dc0ae120f9938a73635c4178c186e5f12fc064cb3db38947bd65b55902882c31', 42, 3, 'becompetitive', '[]', 0, '2022-07-22 01:20:48', '2022-07-22 01:20:48', '2023-07-22 06:50:48'),
('5f2223f17265e58ebc5306dc00f00aa4d7cfd8889393e0401ce3e0cd11c88c139c4dc14f52f27a43', 42, 3, 'becompetitive', '[]', 0, '2022-07-21 06:24:32', '2022-07-21 06:24:32', '2023-07-21 11:54:32'),
('5fae6db7a444782b1060c3012d08624f574fd16e8ae5d176809a712ae2c75ad3a940af34c27eb858', 3, 1, 'becompetitive', '[]', 0, '2022-01-27 07:06:38', '2022-01-27 07:06:38', '2023-01-27 07:06:38'),
('5fbe58e99718f275545d27ff8a116f76c2ac7322a897f2b1fcca0eddbb411ad6d7fb1c4d8eb42081', 35, 1, 'becompetitive', '[]', 0, '2022-01-22 10:02:22', '2022-01-22 10:02:22', '2023-01-22 10:02:22'),
('628b582c94004d38b36981edad23808d83f0fe64050cf2244495250d01b32971761abfa4bcbd150d', 8, 1, 'becompetitive', '[]', 0, '2022-01-19 09:56:49', '2022-01-19 09:56:49', '2023-01-19 09:56:49'),
('633bb1eea154ade97d9f0d0a0a9d16eb75bf76a8e5f05a2080f04cb9b2b6eabc69c4541b9373733c', 35, 1, 'becompetitive', '[]', 0, '2022-01-21 04:49:03', '2022-01-21 04:49:03', '2023-01-21 04:49:03'),
('639cf9cbb8f229c389c091d6c0bcba4c53d95bb2a48dfdfbb5213dfb82c4d9136f1e2abcdd4dce81', 3, 1, 'becompetitive', '[]', 0, '2022-01-15 00:16:01', '2022-01-15 00:16:01', '2023-01-15 05:46:01'),
('65d9cb152d2ad97c6c33869a9b1deb2a3d446d03ec4bb950c23e37845c900f92c4feb684f7cb199d', 3, 1, 'becompetitive', '[]', 0, '2022-01-27 07:29:07', '2022-01-27 07:29:07', '2023-01-27 07:29:07'),
('6678d43e68cfac52092db371836ad691ef16451fda51f485ea5cea7b6528b93a9f390d504d0bca20', 42, 3, 'becompetitive', '[]', 0, '2022-07-21 06:29:05', '2022-07-21 06:29:05', '2023-07-21 11:59:05'),
('679a08f8bff15b8735d19704c820593c52fa0575ac1ab3a4ffdecdc0585d9fad12064dcd0f221e4d', 8, 1, 'becompetitive', '[]', 0, '2022-01-20 03:25:09', '2022-01-20 03:25:09', '2023-01-20 03:25:09'),
('701ad3da1ab97aa5c8164ecfbc08d65a98e1360b39f4dc00005bf786fb780b61b9c65e284be1d210', 3, 1, 'becompetitive', '[]', 0, '2022-01-14 03:35:52', '2022-01-14 03:35:52', '2023-01-14 09:05:52'),
('721a78b262473a17ede7c22de58526d80738abaf63e7f93c0743a3eccb24c7809029ebeba3b248d7', 38, 1, 'becompetitive', '[]', 0, '2022-01-26 04:10:02', '2022-01-26 04:10:02', '2023-01-26 04:10:02'),
('77d29448266baa2c93a7b2fd50e2b98c64d664aa6f862ac3ad512d26e80a51ec3cedabbec96602cf', 35, 1, 'becompetitive', '[]', 0, '2022-01-19 11:27:40', '2022-01-19 11:27:40', '2023-01-19 11:27:40'),
('78465deef8927fa04cba9410c99d3b2323a1fb9c95d3fcd1821f6aa3d2df7bbd6a9404784b4352fa', 40, 1, 'becompetitive', '[]', 0, '2022-01-26 11:20:40', '2022-01-26 11:20:40', '2023-01-26 11:20:40'),
('79057e032607debf1d14c0007645754dd6ef28d37c7121d7c21c93cf4e48e9a57698612cb98cf229', 3, 1, 'becompetitive', '[]', 0, '2022-01-20 06:17:34', '2022-01-20 06:17:34', '2023-01-20 06:17:34'),
('7a1b442c7af4e70cebcb0bb13e6a8b883f714456afa86282927fa566649a6598139ce2e84cdff8b8', 8, 1, 'becompetitive', '[]', 0, '2022-01-20 06:01:11', '2022-01-20 06:01:11', '2023-01-20 06:01:11'),
('7b2d94eb27aff9f93883dee0e26593af045e589e45a73c0e54143bd8fac7cc9f79730dd32a7c4e10', 3, 1, 'becompetitive', '[]', 0, '2022-01-21 05:13:08', '2022-01-21 05:13:08', '2023-01-21 05:13:08'),
('7c5af3f8de5474c794d9a769640bbddad25c550b5cc91f88bab361be0c818032c3e8ebe3efc288a4', 42, 3, 'becompetitive', '[]', 0, '2022-07-21 06:31:07', '2022-07-21 06:31:07', '2023-07-21 12:01:07'),
('7d30a946843f3d4ffdd29e90ee090075465c8da5ad076023c6e3fba1fe143030166f0aa4ccef06c8', 3, 1, 'becompetitive', '[]', 0, '2022-01-26 11:07:42', '2022-01-26 11:07:42', '2023-01-26 11:07:42'),
('7e7a47c1c83120ff0a7bf9fea6030d7304b666235e60db2b1ebc52aa1b900d1fc056e2dc95999be7', 39, 1, 'becompetitive', '[]', 0, '2022-01-26 09:27:44', '2022-01-26 09:27:44', '2023-01-26 09:27:44'),
('81a9db71d7bf0677b2f0db6b4419b768e7db86107d46a7db43e6b235864ddac93db256db05e469a6', 3, 1, 'becompetitive', '[]', 0, '2022-01-14 03:44:18', '2022-01-14 03:44:18', '2023-01-14 09:14:18'),
('84ee6f6481df09648473cb789481da6aceb7cb0190df11bdf0759aa59324ab082ee707c410471f08', 3, 1, 'becompetitive', '[]', 0, '2022-01-26 12:56:52', '2022-01-26 12:56:52', '2023-01-26 12:56:52'),
('870804639ae5624b61251d9461b1215bd6f77c596329d5f0c9f02bfc7e37abaf91c6736beb12d49f', 34, 1, 'becompetitive', '[]', 0, '2022-01-19 07:22:35', '2022-01-19 07:22:35', '2023-01-19 07:22:35'),
('9634fa639cbf95cf2bd17dd28380b57e0af6f4f92fddf1d887fb0fcb545b60fdf206aeaffed8868f', 42, 3, 'becompetitive', '[]', 0, '2022-07-21 06:01:44', '2022-07-21 06:01:44', '2023-07-21 11:31:44'),
('9780ed8c340569cdbee7921b652717a8f92e0cc6f6ff8135a8521dcfce52330c4a02498034fa0190', 3, 1, 'becompetitive', '[]', 0, '2022-01-14 03:40:53', '2022-01-14 03:40:53', '2023-01-14 09:10:53'),
('9a8a5d3e13b62802a184d9a2a0e27c7cd07b189f598781c308c75567fd76b196f82be9153a2efe13', 3, 1, 'becompetitive', '[]', 0, '2022-01-14 09:19:08', '2022-01-14 09:19:08', '2023-01-14 14:49:08'),
('a56c1eac3fd3719948dc7d1d4487c0be156b50416c35e8e1f5c69ccafa4d036bf6954f8e2fdb7c6d', 42, 3, 'becompetitive', '[]', 0, '2022-07-21 06:29:52', '2022-07-21 06:29:52', '2023-07-21 11:59:52'),
('a8b53920e2381c925834cc8962de62ba4fcfafccc8ef801114730c37de1d74db23697edd0cc7fe02', 42, 3, 'becompetitive', '[]', 0, '2022-07-21 06:53:43', '2022-07-21 06:53:43', '2023-07-21 12:23:43'),
('a92dc6bc952411805e881f962adf21e8356d2fb4f2de11573946c7fc863c8f19ab05e1cf12a8eb7a', 3, 1, 'becompetitive', '[]', 0, '2022-01-14 03:34:03', '2022-01-14 03:34:03', '2023-01-14 09:04:03'),
('ab9f49d6f0f5490223d0e2cb63d8ddbd6c008aba90b43cb62bbe977a28754d4cc0c8d17a3a4123e7', 3, 1, 'becompetitive', '[]', 0, '2022-01-22 04:19:26', '2022-01-22 04:19:26', '2023-01-22 04:19:26'),
('abb6a74e5ae790ff5509d801baa798e870acafb7dafeafcfb089ab9c65e368edd94ac5f4174002ee', 38, 1, 'becompetitive', '[]', 0, '2022-01-26 05:30:44', '2022-01-26 05:30:44', '2023-01-26 05:30:44'),
('ad6b68831ca85ac521d43fcd587f7cf22b9d40406e5274c5296a73ef76b0400a030facec4b99f132', 3, 1, 'becompetitive', '[]', 0, '2022-01-15 09:38:16', '2022-01-15 09:38:16', '2023-01-15 09:38:16'),
('af6feb284f973420cbd0afc7af38de96f12c9c65b40ba4bf0a0edbf8df6aea909222a117fb524b14', 42, 1, 'becompetitive', '[]', 0, '2022-01-27 08:26:31', '2022-01-27 08:26:31', '2023-01-27 08:26:31'),
('afa56f845148151fd2b2a3064ddfc4632c7d807825fbfc68c44ec5ce4e129a989046f343ad44d53a', 3, 1, 'becompetitive', '[]', 0, '2022-01-25 06:19:47', '2022-01-25 06:19:47', '2023-01-25 06:19:47'),
('b171c390f5eafc004b764fbe6ae91d57e7eba6be6950acd02a6053992492f2daff35b12a17c4eec2', 3, 1, 'becompetitive', '[]', 0, '2022-01-26 11:07:23', '2022-01-26 11:07:23', '2023-01-26 11:07:23'),
('b20dc0dea11c2058bad23211c4c1b326e44d0f82d16952c54e06db6ed85a52782b3a229305d51747', 3, 1, 'becompetitive', '[]', 0, '2022-01-22 09:14:44', '2022-01-22 09:14:44', '2023-01-22 09:14:44'),
('b2c6e76c03ebae7189d1e2ea99322db50f2b987e47906730cbcdc18b78850e62477bdea5eedee052', 38, 1, 'becompetitive', '[]', 0, '2022-01-26 05:25:35', '2022-01-26 05:25:35', '2023-01-26 05:25:35'),
('b59bb6a0dc4479a22005f13d8d55ba0d63de3deb4b57a783d15610effb2e8cd2896f35c392a3ff64', 35, 1, 'becompetitive', '[]', 0, '2022-01-20 07:35:39', '2022-01-20 07:35:39', '2023-01-20 07:35:39'),
('b69e885f7383609cca757033f4ded5d19d2beb32c0d55280328922d8ecbd272fb39f91e13e383d6e', 34, 1, 'becompetitive', '[]', 0, '2022-01-19 08:00:49', '2022-01-19 08:00:49', '2023-01-19 08:00:49'),
('bcfb8b84add93b1f0d61f79b2208d8742667ec9d544010e8762c1a1043bb7445d2f2bbe4b24674f0', 44, 1, 'becompetitive', '[]', 0, '2022-01-27 08:53:21', '2022-01-27 08:53:21', '2023-01-27 08:53:21'),
('bd7c2cbe84a57d3a6e81cf15fc0c0ab578bf3e864d1ddb05595d5a40f8e902b5880d4a0fd0f70a73', 35, 1, 'becompetitive', '[]', 0, '2022-01-19 09:28:48', '2022-01-19 09:28:48', '2023-01-19 09:28:48'),
('c168b66442eeef46555ddeda783f2c9b93bb7af5e10c5503da94deb49f900648959d834c31200b2b', 35, 1, 'becompetitive', '[]', 0, '2022-01-19 08:01:06', '2022-01-19 08:01:06', '2023-01-19 08:01:06'),
('c27fed299263af3999b91a48622c2c9cdb72ef08cff5439c4a798fc053b4c5dff38b863a3ee549ff', 40, 1, 'becompetitive', '[]', 0, '2022-01-26 12:04:13', '2022-01-26 12:04:13', '2023-01-26 12:04:13'),
('c46bbccdf74ac160a8cef652d1c2d7e3d01acc29270598166d5010fd389bb9ba15e6edd142931508', 35, 1, 'becompetitive', '[]', 0, '2022-01-25 09:31:19', '2022-01-25 09:31:19', '2023-01-25 09:31:19'),
('c5fc7e6fe17c71ba54be719e0eb5e4442a7b83463913496d59124f5df6466079b8152230aec60638', 8, 1, 'becompetitive', '[]', 0, '2022-01-20 06:00:00', '2022-01-20 06:00:00', '2023-01-20 06:00:00'),
('c726a3a1047a02e61255d192c144ffaf108b9e7a14513140a4422f6eabb1ebfdf749d3a7d28a7689', 3, 1, 'becompetitive', '[]', 0, '2022-01-26 12:15:49', '2022-01-26 12:15:49', '2023-01-26 12:15:49'),
('c7a6b4f62b7d5f0ec916f38a8ce859c8e2b89191f398b57db6925d45166e1dfa358d0900a85c51e4', 34, 1, 'becompetitive', '[]', 0, '2022-01-19 07:09:30', '2022-01-19 07:09:30', '2023-01-19 07:09:30'),
('c8de6d501cf88e927cb92252da8a27aa07ea2ff26d284da334f63ecb0cc10bb18966662165b47062', 35, 1, 'becompetitive', '[]', 0, '2022-01-20 06:30:08', '2022-01-20 06:30:08', '2023-01-20 06:30:08'),
('ca12c17c75706a891d2e7b3586e6114739dad23de03dcefb336401312fb7390b0450be19b84974ce', 3, 1, 'becompetitive', '[]', 0, '2022-01-15 08:48:38', '2022-01-15 08:48:38', '2023-01-15 08:48:38'),
('cc9d201e9df150848be76c2e46f2a813a49c457658afec1fbc6cc6f2111f7e829120a0b64dc0ce09', 37, 1, 'becompetitive', '[]', 0, '2022-01-24 06:38:29', '2022-01-24 06:38:29', '2023-01-24 06:38:29'),
('cef869d445ccc2c05b09465bc476238483326a87ebf5d2b08e18635c39ae9abe8c04778d9a9d5e5c', 8, 1, 'becompetitive', '[]', 0, '2022-01-20 05:57:59', '2022-01-20 05:57:59', '2023-01-20 05:57:59'),
('d22636d861f208fa5f8e879a52f0056a663f845730fad7347a4b0a70b13b9bdbd0ba30d48b8a659e', 44, 1, 'becompetitive', '[]', 0, '2022-01-27 09:39:04', '2022-01-27 09:39:04', '2023-01-27 09:39:04'),
('d367361919eef919f493b4103319b4b6822e436fdda0c21bcf37c80e6846eda1c75bf209494b4678', 38, 1, 'becompetitive', '[]', 0, '2022-01-25 05:44:08', '2022-01-25 05:44:08', '2023-01-25 05:44:08'),
('d48ffd5fe1fedb8f08b44737676f50635896e623eb55c1e4e54ba97396207502f2ff68a3dc9aa2af', 44, 1, 'becompetitive', '[]', 0, '2022-01-27 09:22:28', '2022-01-27 09:22:28', '2023-01-27 09:22:28'),
('d7a892fedd9e941a009ea5a8fe84505e6887218641b8de4f3081b737688be3d2da598220a7dcdc27', 3, 1, 'becompetitive', '[]', 0, '2022-01-22 14:25:05', '2022-01-22 14:25:05', '2023-01-22 14:25:05'),
('db4c8955d568778698dd2d15b547e3994830918a43ef2da74be07a1d32c8b2d8e7bf58020f4d1898', 42, 3, 'becompetitive', '[]', 0, '2022-07-21 06:31:33', '2022-07-21 06:31:33', '2023-07-21 12:01:33'),
('dffd2ee71fcded648d8b96df696edacfb189feb9982ae6f8e01fae746064dd591c5b2995a955c8f8', 42, 1, 'becompetitive', '[]', 0, '2022-01-27 08:30:57', '2022-01-27 08:30:57', '2023-01-27 08:30:57'),
('e9aaab0cd64445c81f64e7cae0294b5f4f81cacdd86912f723582845add067689d5fb790e909fa3c', 35, 1, 'becompetitive', '[]', 0, '2022-01-25 05:51:22', '2022-01-25 05:51:22', '2023-01-25 05:51:22'),
('eb30af2cee358153fb05f0adfa02b61a6ac12883856b9581111d765ae6a9877eb03c8ce3ba5cf2f2', 42, 3, 'becompetitive', '[]', 0, '2022-07-21 06:32:58', '2022-07-21 06:32:58', '2023-07-21 12:02:58'),
('f1578884d2163ce3be46d6bad1b7009e82899b3e68269d05990d18e615b8271404f5f4c0d9e7d6e3', 35, 1, 'becompetitive', '[]', 0, '2022-01-19 08:05:43', '2022-01-19 08:05:43', '2023-01-19 08:05:43'),
('f3fe058121b72d2ae35b0fab7367ac24d618cc79d3b628f744c2778866237e6c2ff1b2b028309d2a', 41, 1, 'becompetitive', '[]', 0, '2022-01-26 11:49:25', '2022-01-26 11:49:25', '2023-01-26 11:49:25'),
('f58f0106f3ccdb112434cfc5a6b359325647e016f83b10db20e93d691dbbbac5aff168022e4d8b7d', 3, 1, 'becompetitive', '[]', 0, '2022-01-21 09:36:40', '2022-01-21 09:36:40', '2023-01-21 09:36:40'),
('f91c4de2f351dbb45f7744a5be5764c3e05f2e34c3cec36264a5459326f08feddd6dbffb1cfb2dab', 3, 1, 'becompetitive', '[]', 0, '2022-01-20 04:51:01', '2022-01-20 04:51:01', '2023-01-20 04:51:01'),
('fd3f829f51043eac94c033bb3e94e69cc3f7897f7cbce9156a64cf58e20fb9c082af9d34a682e8e6', 35, 1, 'becompetitive', '[]', 0, '2022-01-21 05:40:43', '2022-01-21 05:40:43', '2023-01-21 05:40:43'),
('fd5f804cf695b8eb5ef08f35632539d7af60ed6b97b062629655e0c80a27483fa775b29ae02350aa', 35, 1, 'becompetitive', '[]', 0, '2022-01-26 06:01:32', '2022-01-26 06:01:32', '2023-01-26 06:01:32');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'QwYZ9RnxkrKqNB7Q7wDLx2sXRi5tisf6GeLnni68', NULL, 'http://localhost', 1, 0, 0, '2022-01-14 01:19:52', '2022-01-14 01:19:52'),
(2, NULL, 'Laravel Password Grant Client', 'Ioa0sSneV3XhkhBcZBqnmRcOQyP472Lq2pI6NBLP', 'users', 'http://localhost', 0, 1, 0, '2022-01-14 01:19:52', '2022-01-14 01:19:52'),
(3, NULL, 'Laravel Personal Access Client', '7Q1revQZiS5eWYR4rY4XZAJcgBHdFsPLSXWWbI53', NULL, 'http://localhost', 1, 0, 0, '2022-07-21 05:53:26', '2022-07-21 05:53:26'),
(4, NULL, 'Laravel Password Grant Client', 'ANsrYCNswYlCQ4DpolKSR9JUYEVWomTs4z9aPnPW', 'users', 'http://localhost', 0, 1, 0, '2022-07-21 05:53:26', '2022-07-21 05:53:26');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-01-14 01:19:52', '2022-01-14 01:19:52'),
(2, 3, '2022-07-21 05:53:26', '2022-07-21 05:53:26');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `course_unique_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `package_name` varchar(100) NOT NULL,
  `package_type` tinyint(4) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `course_unique_id`, `subject_id`, `package_name`, `package_type`, `start_date`, `expiry_date`, `rate`, `status`, `created_at`, `updated_at`) VALUES
(17, 4563, NULL, 'aiapget', 1, '2022-07-13', '2022-07-30', 10000, 1, '2022-07-13 05:27:30', '2022-07-13 05:27:30'),
(21, 4563, 8, 'indian politics-4563', 2, '2022-07-18', '2022-07-31', 5000, 1, '2022-07-18 09:21:42', '2022-07-18 09:21:42'),
(22, 1235, NULL, 'History of Indioa-1235', 1, '2022-07-18', '2022-07-31', 6000, 1, '2022-07-18 09:22:37', '2022-07-18 09:22:37');

-- --------------------------------------------------------

--
-- Table structure for table `package_payments`
--

CREATE TABLE `package_payments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `promocode` varchar(50) DEFAULT NULL,
  `promocode_value` int(11) DEFAULT 0,
  `referral_code` varchar(50) DEFAULT NULL,
  `referral_value` int(11) DEFAULT 0,
  `package_rate` int(11) DEFAULT NULL,
  `net_amount` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `package_payments`
--

INSERT INTO `package_payments` (`id`, `student_id`, `package_id`, `payment_id`, `promocode`, `promocode_value`, `referral_code`, `referral_value`, `package_rate`, `net_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 17, 'fsdf23111dscsd4322', 'ASD222', 0, NULL, NULL, NULL, 4800, 1, '2021-01-22 11:49:10', '2022-01-22 11:49:10'),
(2, 2, 17, 'fsdf23111dscsd4322', 'ASD222', 500, 'sdffsfs', 0, 5000, 4500, 1, '2022-01-22 11:52:36', '2022-01-22 11:52:36'),
(3, 3, 21, 'fsd2311', 'ASD222', 200, 'sdffi', 0, 5000, 4800, 1, '2021-01-26 08:08:16', '2022-01-26 08:08:16'),
(4, 3, 22, 'fsd2311', 'ASD2022C100', 450, 'SHA2022', 450, 5000, 4100, 1, '2022-01-26 09:33:44', '2022-01-26 09:33:44'),
(5, 5, 22, 'fsd2311', NULL, 0, NULL, 0, 5000, 5000, 1, '2021-01-26 09:38:53', '2022-01-26 09:38:53');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `promocodes`
--

CREATE TABLE `promocodes` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `promocode` varchar(100) NOT NULL,
  `promocode_value` int(11) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `promocodes`
--

INSERT INTO `promocodes` (`id`, `course_id`, `promocode`, `promocode_value`, `expiry_date`, `description`, `status`, `created_at`, `updated_at`) VALUES
(3, 11, 'ABC2021M44', 500, NULL, 'dasdsa adas dasdasdadsadas', 1, '2022-01-13 05:35:25', '2022-07-15 04:35:12'),
(4, 11, 'ASD20111', 750, '2022-07-31', 'DSDSADASDSADS  DSAD DADSAD\r\nD SASD SASD DD DSADS SADSADSDSADSADSA DSA\r\nDSA DSDSDD SADSDSA DSAD SSADSAD', 0, '2022-07-14 07:26:40', '2022-07-15 04:34:01');

-- --------------------------------------------------------

--
-- Table structure for table `purchased_packages`
--

CREATE TABLE `purchased_packages` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `promocode` varchar(50) DEFAULT NULL,
  `promocode_amount` float DEFAULT NULL,
  `referral_code` varchar(100) DEFAULT NULL,
  `referral_amount` float DEFAULT NULL,
  `amount` float NOT NULL,
  `net_amount` float NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchased_packages`
--

INSERT INTO `purchased_packages` (`id`, `student_id`, `package_id`, `promocode`, `promocode_amount`, `referral_code`, `referral_amount`, `amount`, `net_amount`, `status`, `created_at`, `updated_at`) VALUES
(21, 1, 17, NULL, 0, NULL, 0, 5000, 5000, 1, '2022-01-22 10:12:21', '2022-01-22 10:12:21'),
(22, 2, 17, 'ASD2022C100', 450, 'SHA2022', 450, 5000, 4100, 1, '2022-01-24 06:49:12', '2022-01-24 06:49:12'),
(23, 3, 21, NULL, 0, NULL, 0, 5000, 5000, 1, '2022-01-26 09:43:02', '2022-01-26 09:43:02'),
(25, 55, 22, NULL, 0, NULL, 0, 5000, 5000, 1, '2022-07-22 14:16:13', '2022-01-26 14:16:13');

-- --------------------------------------------------------

--
-- Table structure for table `qb_subjects`
--

CREATE TABLE `qb_subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `qb_subjects`
--

INSERT INTO `qb_subjects` (`id`, `subject_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Simulated Test -Foundation Level -Free', 1, '2022-01-27 07:47:17', '2022-01-27 07:47:17'),
(2, 'Indian Politics & Governance', 1, '2022-01-27 07:47:17', '2022-01-27 07:47:17'),
(3, 'History Of India and Indian Nation Movement', 1, '2022-01-27 07:47:17', '2022-01-27 07:47:17'),
(4, 'Indian And World Geography', 1, '2022-01-27 07:47:17', '2022-01-27 07:47:17'),
(5, 'Economic and Social Development', 1, '2022-01-27 07:47:17', '2022-01-27 07:47:17'),
(6, 'General Science & Technology', 1, '2022-01-27 07:47:17', '2022-01-27 07:47:17');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `qb_subject_id` int(11) NOT NULL,
  `question_type` tinyint(4) NOT NULL COMMENT '1-text, 2-image',
  `question_mode` tinyint(4) DEFAULT NULL,
  `question` varchar(300) DEFAULT NULL,
  `question_image` varchar(100) DEFAULT NULL,
  `answer_1` varchar(500) DEFAULT NULL,
  `answer_2` varchar(500) DEFAULT NULL,
  `answer_3` varchar(500) DEFAULT NULL,
  `answer_4` varchar(500) DEFAULT NULL,
  `correct_answer` int(11) DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `qb_subject_id`, `question_type`, `question_mode`, `question`, `question_image`, `answer_1`, `answer_2`, `answer_3`, `answer_4`, `correct_answer`, `explanation`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 'test question-11', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:56:53', '2022-01-27 07:56:53'),
(2, 2, 1, 2, 'test question-21', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 07:56:53', '2022-01-27 07:56:53'),
(3, 2, 1, 3, 'test question-31', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 07:56:53', '2022-01-27 07:56:53'),
(4, 2, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 07:56:53', '2022-01-27 07:56:53'),
(5, 2, 1, 2, 'test question-51', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:56:53', '2022-01-27 07:56:53'),
(6, 2, 1, 1, 'test question-61', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 07:56:53', '2022-01-27 07:56:53'),
(7, 2, 1, 2, 'test question-71', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:56:53', '2022-01-27 07:56:53'),
(8, 2, 1, 3, 'test question-81', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 07:56:53', '2022-01-27 07:56:53'),
(9, 2, 1, 1, 'test question-91', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 07:56:53', '2022-01-27 07:56:53'),
(10, 1, 1, 1, 'test question-11', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:57:57', '2022-01-27 07:57:57'),
(11, 1, 1, 2, 'test question-21', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 07:57:57', '2022-01-27 07:57:57'),
(12, 1, 1, 3, 'test question-31', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 07:57:57', '2022-01-27 07:57:57'),
(13, 1, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 07:57:57', '2022-01-27 07:57:57'),
(14, 1, 1, 2, 'test question-51', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:57:57', '2022-01-27 07:57:57'),
(15, 1, 1, 1, 'test question-61', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 07:57:57', '2022-01-27 07:57:57'),
(16, 1, 1, 2, 'test question-71', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:57:57', '2022-01-27 07:57:57'),
(17, 1, 1, 3, 'test question-81', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 07:57:58', '2022-01-27 07:57:58'),
(18, 1, 1, 1, 'test question-91', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 07:57:58', '2022-01-27 07:57:58'),
(19, 3, 1, 1, 'test question-11', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:58:04', '2022-01-27 07:58:04'),
(20, 3, 1, 2, 'test question-21', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 07:58:04', '2022-01-27 07:58:04'),
(21, 3, 1, 3, 'test question-31', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 07:58:04', '2022-01-27 07:58:04'),
(22, 3, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 07:58:04', '2022-01-27 07:58:04'),
(23, 3, 1, 2, 'test question-51', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:58:04', '2022-01-27 07:58:04'),
(24, 3, 1, 1, 'test question-61', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 07:58:04', '2022-01-27 07:58:04'),
(25, 3, 1, 2, 'test question-71', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:58:04', '2022-01-27 07:58:04'),
(26, 3, 1, 3, 'test question-81', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 07:58:04', '2022-01-27 07:58:04'),
(27, 3, 1, 1, 'test question-91', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 07:58:04', '2022-01-27 07:58:04'),
(28, 4, 1, 1, 'test question-11', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:58:14', '2022-01-27 07:58:14'),
(29, 4, 1, 2, 'test question-21', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 07:58:14', '2022-01-27 07:58:14'),
(30, 4, 1, 3, 'test question-31', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 07:58:14', '2022-01-27 07:58:14'),
(31, 4, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 07:58:14', '2022-01-27 07:58:14'),
(32, 4, 1, 2, 'test question-51', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:58:14', '2022-01-27 07:58:14'),
(33, 4, 1, 1, 'test question-61', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 07:58:14', '2022-01-27 07:58:14'),
(34, 4, 1, 2, 'test question-71', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:58:14', '2022-01-27 07:58:14'),
(35, 4, 1, 3, 'test question-81', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 07:58:14', '2022-01-27 07:58:14'),
(36, 4, 1, 1, 'test question-91', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 07:58:14', '2022-01-27 07:58:14'),
(37, 5, 1, 1, 'test question-11', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:58:23', '2022-01-27 07:58:23'),
(38, 5, 1, 2, 'test question-21', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 07:58:23', '2022-01-27 07:58:23'),
(39, 5, 1, 3, 'test question-31', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 07:58:23', '2022-01-27 07:58:23'),
(40, 5, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 07:58:23', '2022-01-27 07:58:23'),
(41, 5, 1, 2, 'test question-51', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:58:24', '2022-01-27 07:58:24'),
(42, 5, 1, 1, 'test question-61', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 07:58:24', '2022-01-27 07:58:24'),
(43, 5, 1, 2, 'test question-71', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:58:24', '2022-01-27 07:58:24'),
(44, 5, 1, 3, 'test question-81', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 07:58:24', '2022-01-27 07:58:24'),
(45, 5, 1, 1, 'test question-91', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 07:58:24', '2022-01-27 07:58:24'),
(46, 6, 1, 1, 'test question-11', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:58:31', '2022-01-27 07:58:31'),
(47, 6, 1, 2, 'test question-21', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 07:58:31', '2022-01-27 07:58:31'),
(48, 6, 1, 3, 'test question-31', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 07:58:31', '2022-01-27 07:58:31'),
(49, 6, 1, 1, 'test question-41', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 07:58:31', '2022-01-27 07:58:31'),
(50, 6, 1, 2, 'test question-51', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:58:31', '2022-01-27 07:58:31'),
(51, 6, 1, 1, 'test question-61', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 1, 'testing', 1, '2022-01-27 07:58:31', '2022-01-27 07:58:31'),
(52, 6, 1, 2, 'test question-71', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 2, 'testing', 1, '2022-01-27 07:58:31', '2022-01-27 07:58:31'),
(53, 6, 1, 3, 'test question-81', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 4, 'testing', 1, '2022-01-27 07:58:31', '2022-01-27 07:58:31'),
(54, 6, 1, 1, 'test question-91', NULL, 'test-1', 'test-2', 'test-2', 'test-4', 3, 'testing', 1, '2022-01-27 07:58:31', '2022-01-27 07:58:31');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'SuperAdmin', '2021-12-31 10:30:36', '2021-12-31 10:30:36'),
(2, 'Admin', '2021-12-31 10:30:36', '2021-12-31 10:30:36'),
(3, 'User', '2021-12-31 10:30:43', '2021-12-31 10:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` int(11) NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `referral_code` varchar(100) NOT NULL,
  `referral_value` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `staff_name`, `gender`, `email`, `mobile`, `referral_code`, `referral_value`, `status`, `created_at`, `updated_at`) VALUES
(1, 'shaji', 'male', 'shaji@gmail.com', '1234567890', 'SHA2022', 450, 0, '2022-01-13 11:38:11', '2022-01-13 08:19:50'),
(2, 'TEST', 'Male', 'geofarms@ggf.com', '1234567899', 'ASD2334', 333, 1, '2022-01-13 06:21:41', '2022-01-13 08:19:54');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `state` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `state`, `created_at`, `updated_at`) VALUES
(1, 'Andhra Pradesh', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(2, 'Arunachal Pradesh', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(3, 'Assam', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(4, 'Bihar', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(5, 'Chattisgarh Pradesh', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(6, 'Goa', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(7, 'Gujarat', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(8, 'Haryana', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(9, 'Himachal Pradesh', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(10, 'Jharkhand', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(11, 'Karnataka', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(12, 'Kerala', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(13, 'Madhya Pradesh', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(14, 'Maharashtra', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(15, 'Manipur', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(16, 'Meghalaya', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(17, 'Mizoram', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(18, 'Nagaland', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(19, 'Odisha', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(20, 'Punjab', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(21, 'Rajasthan', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(22, 'Sikkim', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(23, 'Tamil Nadu', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(24, 'Telangana', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(25, 'Tripura', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(26, 'Uttar Pradesh', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(27, 'Uttarakhand', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(28, 'West Bengal', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(29, 'Andaman and Nicobar Islands', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(30, 'Chandigarh', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(31, 'Dadra & Nagar Haveli and Daman & Diu', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(32, 'Delhi', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(33, 'Jammu and Kashmir', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(34, 'Lakshadweep', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(35, 'Puducherry', '2022-01-17 15:42:20', '2022-01-17 15:42:20'),
(36, 'Ladakh', '2022-01-17 15:42:20', '2022-01-17 15:42:20');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `mobile` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `student_image` varchar(100) DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `gender`, `date_of_birth`, `mobile`, `email`, `state`, `student_image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SHAJI TEST', 'Male', '2022-01-13', '1234567891', 'sha1@gmail.com', 'kerala', 'student_images/a1.png', '1', '2022-01-06 12:34:11', '2022-01-06 12:34:11'),
(2, 'sssssss', 'Female', '2022-01-06', '9995338385', 'enclaps@gmail.com', 'kerala', 'student_images/st_20220106101843.png', '1', '2022-01-06 09:54:11', '2022-01-06 10:18:43'),
(3, 'bvbvbcbc', 'Female', '2022-01-12', '1234567886', 'sha2@gmail.com', 'kerala', 'student_images/st_20220106095513.png', '1', '2022-07-18 09:55:13', '2022-01-06 09:55:13'),
(5, 'TEST', 'MALE', '2020-10-20', '2222222222', 'vb@gmail.com', 'kerala', 'student_images/st_20220722065556.png', '1', '2022-07-22 10:05:22', '2022-07-22 06:55:56'),
(55, 'TEST', 'MALE', '2020-10-20', '1234567831', 'vb@gmail.com', 'kerala', 'student_images/st_20220722064925.png', '1', '2022-07-22 06:49:25', '2022-07-28 11:25:24');

-- --------------------------------------------------------

--
-- Table structure for table `student_devices`
--

CREATE TABLE `student_devices` (
  `id` int(11) NOT NULL,
  `reg_date` date NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `version_release` varchar(100) DEFAULT NULL,
  `manufacturer` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `androidid` varchar(100) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `device` varchar(100) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student_devices`
--

INSERT INTO `student_devices` (`id`, `reg_date`, `student_id`, `student_name`, `mobile`, `version_release`, `manufacturer`, `model`, `androidid`, `brand`, `device`, `status`, `created_at`, `updated_at`) VALUES
(1, '2022-01-14', 6, NULL, '9995338385', '11', 'samsung', 'a30', 'android12233', 'samsung', 'a30', 1, '2022-01-14 09:03:06', '2022-01-14 09:03:06'),
(3, '2022-01-27', 4, NULL, '1234567899', '11', 'samsung', 'SM-M215F', 'RP1A.200720.012', 'samsung', 'm21', 1, '2022-01-14 09:05:52', '2022-01-27 07:29:07'),
(4, '2022-01-19', 43, NULL, '9999999991', '8.1.0', 'YU', 'YU5014', 'O11019', 'YU', 'YU5014', 1, '2022-01-19 06:53:12', '2022-01-19 06:54:28'),
(5, '2022-01-19', 44, NULL, '9999999992', '11', 'samsung', 'a30', 'android12233', 'samsung', 'a30', 1, '2022-01-19 07:09:30', '2022-01-19 08:00:49'),
(6, '2022-01-26', 45, NULL, '9999999993', '8.1.0', 'YU', 'YU5014', 'O11019', 'YU', 'YU5014', 1, '2022-01-19 08:01:06', '2022-01-26 11:06:53'),
(7, '2022-07-29', 5, NULL, '2222222222', '11', 'samsung', 'a30', 'android12233', 'samsung', 'a30', 1, '2022-01-19 09:54:48', '2022-07-29 09:10:13'),
(8, '2022-01-26', 47, NULL, '9999999994', '8.1.0', 'YU', 'YU5014', 'O11019', 'YU', 'YU5014', 1, '2022-01-24 06:38:29', '2022-01-26 11:07:00'),
(9, '2022-01-26', 48, NULL, '9999999995', '8.1.0', 'YU', 'YU5014', 'O11019', 'YU', 'YU5014', 1, '2022-01-25 05:44:08', '2022-01-26 09:20:31'),
(10, '2022-01-27', 49, NULL, '9999999996', '8.0.0', 'LENOVO', 'Lenovo K8 Plus', 'OMC27.70-56', 'Lenovo', 'marino_f', 1, '2022-01-26 09:27:44', '2022-01-27 06:48:17'),
(11, '2022-01-27', 50, NULL, '9999999997', '8.0.0', 'LENOVO', 'Lenovo K8 Plus', 'OMC27.70-56', 'Lenovo', 'marino_f', 1, '2022-01-26 11:14:39', '2022-01-27 08:52:16'),
(12, '2022-01-26', 51, NULL, '6238501007', '11', 'OPPO', 'CPH2119', 'RP1A.200720.011', 'OPPO', 'OP4C51L1', 1, '2022-01-26 11:49:25', '2022-01-26 11:49:25'),
(13, '2022-07-21', 52, NULL, '9526468385', '11', 'samsung', 'a30', 'android12233', 'samsung', 'a30', 1, '2022-01-26 13:54:58', '2022-07-21 12:23:12'),
(14, '2022-01-27', 53, NULL, '9072064047', '11', 'samsung', 'SM-M215F', 'RP1A.200720.012', 'samsung', 'm21', 1, '2022-01-27 03:59:06', '2022-01-27 07:06:20'),
(15, '2022-01-27', 54, NULL, '9999999998', '8.0.0', 'LENOVO', 'Lenovo K8 Plus', 'OMC27.70-56', 'Lenovo', 'marino_f', 1, '2022-01-27 08:53:21', '2022-01-27 10:18:26');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `course_unique_id` int(11) DEFAULT NULL,
  `subject_name` varchar(100) NOT NULL,
  `subject_type` varchar(50) DEFAULT NULL,
  `reorder_no` int(11) DEFAULT NULL,
  `description` varchar(1000) NOT NULL,
  `subject_icon` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `course_id`, `course_unique_id`, `subject_name`, `subject_type`, `reorder_no`, `description`, `subject_icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 11, 4563, 'Simulated Test -Foundation Level -Free', 'MCQ', 5, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\"\"', 'subject_icons/icon_20220101125935.png', 1, '2022-01-01 12:30:14', '2022-07-21 07:30:31'),
(2, 13, 3652, 'Indian Politics & Governance', 'MCQ', 2, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\"', 'subject_icons/icon_20220110113506.png', 1, '2022-01-10 11:35:06', '2022-07-21 07:55:30'),
(3, 12, 4563, 'History Of India and Indian Nation Movement', 'MCQ', 4, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\"', 'subject_icons/icon_20220110125007.png', 1, '2022-01-10 12:50:07', '2022-07-21 07:30:31'),
(4, 11, 4563, 'Indian And World Geography', 'MCQ', 3, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\"', 'subject_icons/icon_20220111035439.png', 1, '2022-01-11 03:54:40', '2022-07-21 07:30:31'),
(5, 12, 1235, 'Economic and Social Development', 'MCQ', 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'subject_icons/icon_20220111035759.png', 1, '2022-01-11 03:57:59', '2022-07-21 07:41:03'),
(6, 13, 3652, 'General Science & Technology', 'MCQ', 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'subject_icons/icon_20220115042730.png', 1, '2022-01-15 04:27:30', '2022-07-21 07:55:30'),
(7, 13, 4563, 'qwerty', 'MCQ', 2, '<p>fdsf dfdffsdfsfdf</p><p>fdfdsfsdfd sffdsfdsfds&nbsp;</p><p>fd sfdfdfdsf</p>\"', 'subject_icons/Ol5IP0RTk6tMTS6N6QQ86z6F9l89m7Z6VdozbGrR.png', 1, '2022-07-14 07:05:54', '2022-07-21 07:30:31'),
(8, 11, 4563, 'ASDFG', NULL, 1, 'FDGFG FDGDGFD GDFGFDGFD GFDGDFG', 'subject_icons/BN76y84HHxOGg6G6xG8BbbcKzNgkQrLFkrj3eX9f.png', 1, '2022-07-15 05:19:08', '2022-07-21 07:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `tempotps`
--

CREATE TABLE `tempotps` (
  `id` int(11) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `otp` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` int(11) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `student_id`, `mobile`, `email`, `password`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
(30, 40, '1234567881', 'vb@gm.com', '$2y$10$llPSruQc5ruZQoMIoKRJ8ukFfvjFlZ2YEA/oAuIBmhm08sr0WGYp6', NULL, 1, '2022-01-15 09:57:02', '2022-01-15 09:57:02'),
(31, 41, '1234567882', 'vb@gm.com', '$2y$10$4zuTWw.2VkQu9NOdmV4cxuYIouU0kjJLHRN6EgS1vF33Rs/n05yZS', NULL, 1, '2022-01-15 12:07:56', '2022-01-15 12:07:56'),
(32, 42, '999999991', 'vb@g.com', '$2y$10$RwyGn6zFX1tgYfO4XmW8j.U8RMmPmNf6OJiOO7AAwiCtq4xuKCe12', NULL, 1, '2022-01-19 06:37:40', '2022-01-19 06:37:40'),
(33, 43, '9999999991', 'vb@g.com', '$2y$10$.lu9MV4D7gHGocR6KhGjIetDnMxfPtAsQ53oiKuxbz/jBnPYrJulG', NULL, 1, '2022-01-19 06:51:52', '2022-01-19 06:51:52'),
(34, 44, '9999999992', 'vb@g.com', '$2y$10$ZdJrV4v5dnbVUzp7TUvieuLFRLu/.2ZRXGfr1ps0WPUHNP/s9MgIK', NULL, 1, '2022-01-19 07:08:00', '2022-01-19 07:08:00'),
(35, 45, '9999999993', 'vb@gmail.com', '$2y$10$DD53tB0Y2d./a7kImg.QCOpslulpOTulNr7Ckizns2HdyFGTzAm5C', NULL, 1, '2022-01-19 07:20:33', '2022-01-26 07:43:19'),
(36, 46, '1234567811', 'shaju@gmail.com', '$2y$10$ru7TXWYDyHBxVFe4t5Sx2uO3w6Y1NSlyJZ1zJoIAb6cWzp0aAcvO.', NULL, 1, '2022-01-20 04:52:21', '2022-01-20 04:52:21'),
(37, 47, '9999999994', 'vb@gm.com', '$2y$10$WwJ8eFeSna09xvkWhYnnk.VVIXlglhoq8Zk6eLvWY9UklcA9VuJI6', NULL, 1, '2022-01-24 06:38:12', '2022-01-26 09:24:24'),
(38, 48, '9999999995', 'vb@g.com', '$2y$10$nCTxGsmRCcRTd2GUbiQbLOiRtrVud8/oeo6u/pvVIibcSTy0WkT2y', NULL, 1, '2022-01-25 05:43:34', '2022-01-26 05:31:34'),
(39, 49, '9999999996', 'v@g.com', '$2y$10$RwVH8/X4oV7AUWRAUGLq1uV/gdM0y4diUHOvDGf8SIgFkQDZkiV1y', NULL, 1, '2022-01-26 09:26:02', '2022-01-26 09:29:42'),
(40, 50, '9999999997', 'v@g.com', '$2y$10$VegutiRHoXCObqYyqNE6tesiJXiLaPdOz3zdv7teyNMSLe9u6iz42', NULL, 1, '2022-01-26 11:14:16', '2022-01-26 12:33:33'),
(41, 51, '6238501007', 'haris@getlead.co.uk', '$2y$10$CpJPAxczaHlIJgBEOt/rseWbXKWIiZj7Chz0Gd3rQC5YpBhtHiWuO', NULL, 1, '2022-01-26 11:48:59', '2022-01-26 11:48:59'),
(42, 5, '2222222222', 'vb@gmail.com', '$2y$10$d9RQwJuDxXqAMeOlkt/VRe53HI5mun6rdzb2VpDl4BmKkQOKHj9IW', NULL, 1, '2022-01-26 13:54:41', '2022-07-22 01:35:36'),
(43, 53, '9072064047', 'zxc@gmail.com', '$2y$10$GxIgm2m/x/mZMf3md0KN0O2/plyQMNNOApWuTFSuVAJZnu4wrP2ZO', NULL, 1, '2022-01-27 03:58:49', '2022-01-27 05:45:55'),
(44, 54, '9999999998', 'v@g.com', '$2y$10$6mVJgJWPazBBL7XMoEORtOYYy2Gj.n5Ipy5CXFiY.nbYZiScRTkIO', NULL, 1, '2022-01-27 08:53:07', '2022-01-27 08:53:07'),
(45, 55, '1234567831', 'vb@gmail.com', '$2y$10$ztR4RiadeyY/ZCLDfPDTPOivvUlsHVsqHHueLHemC.OQPIAtfhfDC', NULL, 1, '2022-07-22 01:19:26', '2022-07-28 05:56:14');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `unique_id` int(11) DEFAULT NULL,
  `vimeo_id` varchar(50) DEFAULT NULL,
  `premium` int(11) DEFAULT NULL COMMENT '0-free,1-premium',
  `icon` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `unique_id`, `vimeo_id`, `premium`, `icon`, `title`, `created_at`, `updated_at`) VALUES
(1, 2345, '4324324', 0, 'video_icons/i30pdyVX3duDN2chiFy6ZgvBKLxidHDcdG4yB5KF.png', 'This is testing', '2022-07-13 09:11:57', '2022-07-13 09:11:57'),
(2, 2346, '4324324', 1, 'video_icons/TuS4zk00HfNlJweD0k6dKBUBvKiSHXi7Qzr5bsoY.png', 'This is testing', '2022-07-13 09:11:58', '2022-07-13 09:11:58'),
(3, 4567, '4324678', NULL, 'video_icons/ER9VOnU97R6U33eieuEU1BxMKsrHP73NN8Jy9xNc.png', 'qwertyu ffvafdfffdfsdfsfd dffdffdffdsfdsfds', '2022-07-14 07:43:31', '2022-07-14 07:43:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_subjects`
--
ALTER TABLE `course_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboard_banners`
--
ALTER TABLE `dashboard_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_live_tests`
--
ALTER TABLE `lesson_live_tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_materials`
--
ALTER TABLE `lesson_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_mcq_tests`
--
ALTER TABLE `lesson_mcq_tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_videos`
--
ALTER TABLE `lesson_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_comments`
--
ALTER TABLE `material_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_likes`
--
ALTER TABLE `material_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mcq_all_results`
--
ALTER TABLE `mcq_all_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mcq_emd_results`
--
ALTER TABLE `mcq_emd_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mcq_questions`
--
ALTER TABLE `mcq_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mcq_question_papers`
--
ALTER TABLE `mcq_question_papers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mcq_test_all_results`
--
ALTER TABLE `mcq_test_all_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mcq_test_results`
--
ALTER TABLE `mcq_test_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_payments`
--
ALTER TABLE `package_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `promocodes`
--
ALTER TABLE `promocodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchased_packages`
--
ALTER TABLE `purchased_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qb_subjects`
--
ALTER TABLE `qb_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `referral_code` (`referral_code`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_devices`
--
ALTER TABLE `student_devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tempotps`
--
ALTER TABLE `tempotps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `course_subjects`
--
ALTER TABLE `course_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dashboard_banners`
--
ALTER TABLE `dashboard_banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lesson_live_tests`
--
ALTER TABLE `lesson_live_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lesson_materials`
--
ALTER TABLE `lesson_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lesson_mcq_tests`
--
ALTER TABLE `lesson_mcq_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lesson_videos`
--
ALTER TABLE `lesson_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `material_comments`
--
ALTER TABLE `material_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `material_likes`
--
ALTER TABLE `material_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mcq_all_results`
--
ALTER TABLE `mcq_all_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mcq_emd_results`
--
ALTER TABLE `mcq_emd_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mcq_questions`
--
ALTER TABLE `mcq_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `mcq_question_papers`
--
ALTER TABLE `mcq_question_papers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `mcq_test_all_results`
--
ALTER TABLE `mcq_test_all_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `mcq_test_results`
--
ALTER TABLE `mcq_test_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `package_payments`
--
ALTER TABLE `package_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promocodes`
--
ALTER TABLE `promocodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchased_packages`
--
ALTER TABLE `purchased_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `qb_subjects`
--
ALTER TABLE `qb_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `student_devices`
--
ALTER TABLE `student_devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tempotps`
--
ALTER TABLE `tempotps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=998;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
