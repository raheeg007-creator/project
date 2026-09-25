

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `comments` (`id`, `photo_id`, `user_id`, `comment`, `date_time`) VALUES
(1, 1, 2, 'جميلة', '2026-09-12 20:54:33'),
(2, 6, 2, 'naice', '2026-09-12 21:14:22');



CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `photos` (`id`, `user_id`, `file_name`, `title`, `description`, `date_time`) VALUES
(1, 2, 'photo_6aa5bbc6e51d11.79687992.jfif', 'picture1', '', '2026-09-12 20:53:26'),
(2, 2, 'photo_6aa5bc3a4bcf61.95809094.jfif', 'pictuer2', '', '2026-09-12 20:55:22'),
(3, 2, 'photo_6aa5bc5a1216a3.02944591.jfif', 'picture3', '', '2026-09-12 20:55:54'),
(4, 2, 'photo_6aa5bc7c8f2df8.20528584.jfif', 'picture4', '', '2026-09-12 20:56:28'),
(5, 2, 'photo_6aa5bc96f41677.37162293.jfif', 'picture5', '', '2026-09-12 20:56:55'),
(6, 2, 'photo_6aa5bcba7d3839.18336235.jfif', 'pictuer6', '', '2026-09-12 20:57:30');



CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `location`, `description`, `occupation`) VALUES
(2, 'raheeg', 'abd', 'raheeg007@gmail.com', '$2y$10$KQgH9PED.YN3m1AMuL7eJ.YsuB1C0U.T.L0ue7YQhPXfsp4ytEUfa', NULL, NULL, NULL),
(3, 'mohamed', 'abd', 'raheeg004@gmail.com', '$2y$10$Z69wqc7j5ECVFtmWYAJSpeVyoeb8wl/xloFrziKMRaQvG80WO38fC', NULL, NULL, NULL),
(4, 'wewe', 'yty', 'wedr56@gmail.com', '$2y$10$AEM/lL6zUCPBbJdKzTUAg.fO1gnzDqXRofEjCDZt.1B2dNZL81AWK', NULL, NULL, NULL);

ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photo_id` (`photo_id`),
  ADD KEY `user_id` (`user_id`);


ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;




ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `photos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;


ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

