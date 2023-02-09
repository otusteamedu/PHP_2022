CREATE DATABASE `cinema`;

USE `cinema`;

CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `hall` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `hall_scheme` (
  `hall_id` int(11) NOT NULL,
  `row_number` smallint(2) NOT NULL,
  `seat_count` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `hall_scheme` ADD PRIMARY KEY( `hall_id`, `row_number`);
ALTER TABLE `hall_scheme`
  ADD KEY `hall_fk` (`hall_id`);
ALTER TABLE `hall_scheme`
  ADD CONSTRAINT `hall_fk` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE `movie` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(128) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `description` text,
  `country_id` int(11) DEFAULT NULL,
  `restriction_id` int(11) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `release_date` date NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `duration` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `restriction` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(16) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `movie`
  ADD KEY `country_fk` (`country_id`),
  ADD KEY `genre_fk` (`genre_id`),
  ADD KEY `restriction_fk` (`restriction_id`);
ALTER TABLE `movie`
  ADD CONSTRAINT `country_fk` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `genre_fk` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `restriction_fk` FOREIGN KEY (`restriction_id`) REFERENCES `restriction` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;


CREATE TABLE `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `hall_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `price` decimal(4,2) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `session`
  ADD KEY `session_hall_fk` (`hall_id`),
  ADD KEY `session_movie_fk` (`movie_id`);
ALTER TABLE `session`
  ADD CONSTRAINT `session_hall_fk` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `session_movie_fk` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON UPDATE CASCADE;


CREATE TABLE `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `code` varchar(32) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `row_number` smallint(2) NOT NULL,
  `seat_number` smallint(3) NOT NULL,
  `total` decimal(4,2) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `ticket`
  ADD KEY `customer_fk` (`customer_id`),
  ADD KEY `session_fk` (`session_id`);
ALTER TABLE `ticket`
  ADD CONSTRAINT `customer_fk` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `session_fk` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON UPDATE CASCADE;