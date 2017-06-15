-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 15 Jun 2017 pada 13.44
-- Versi Server: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `turboly`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `task_prior` varchar(10) NOT NULL,
  `task_title` varchar(50) NOT NULL,
  `task_desc` varchar(255) NOT NULL,
  `task_due_date` date NOT NULL,
  `task_status` varchar(8) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tasks`
--

INSERT INTO `tasks` (`task_id`, `id`, `task_prior`, `task_title`, `task_desc`, `task_due_date`, `task_status`, `created_at`, `updated_at`) VALUES
(1, 4, 'low', 'teask 1', 'tes', '2017-06-02', 'deleted', '2017-06-15 11:43:22', '2017-06-15 02:56:37'),
(2, 4, 'medium', 'teask 2', 'asdasd', '2017-06-02', 'done', '2017-06-15 11:43:42', '2017-06-15 02:40:45'),
(3, 4, 'high', 'teask 3', 'sfd', '2017-06-15', 'done', '2017-06-15 11:43:36', '2017-06-15 02:53:46'),
(4, 4, 'medium', 'teask 4', 'sadasd asdasd asdasd', '2017-06-23', 'ongoing', '2017-06-15 11:43:33', '2017-06-15 02:59:47'),
(5, 4, 'high', 'teask 5', 'sdfsdf', '2017-06-15', 'ongoing', '2017-06-15 11:43:59', '2017-06-15 04:42:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
