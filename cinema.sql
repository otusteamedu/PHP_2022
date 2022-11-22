CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `displays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hall_id` int(10) UNSIGNED NOT NULL,
  `movie_id` bigint(20) UNSIGNED NOT NULL,
  `price` double UNSIGNED DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `finished_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `halls` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `movies` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `display_id` bigint(20) UNSIGNED NOT NULL,
  `price` double UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `displays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hall_id` (`hall_id`),
  ADD KEY `movie_id` (`movie_id`);

ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `display_id` (`display_id`);

-- --------------------------------------------------------

ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

ALTER TABLE `displays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `halls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `movies`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

ALTER TABLE `displays`
  ADD CONSTRAINT `displays_ibfk_1` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `displays_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON UPDATE CASCADE;

ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`display_id`) REFERENCES `displays` (`id`);
