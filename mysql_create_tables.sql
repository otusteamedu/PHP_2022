CREATE TABLE films
(
    `id`         INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
    `title`      VARCHAR(255)  NOT NULL UNIQUE,
    `base_price` DECIMAL(8, 2) NOT NULL,
    `deleted_at` TIMESTAMP,
    PRIMARY KEY (`id`),
);

CREATE TABLE `halls`
(
    `id`     INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
    `number` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `places`
(
    `id`      INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
    `number`  INT UNSIGNED NOT NULL,
    `hall_id` INT UNSIGNED NOT NULL,
    `markup`  DECIMAL(8, 2) NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `place_session_place_id_foreign`
        FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
);

CREATE TABLE `sessions`
(
    `id`         INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
    `from`       TIMESTAMP     NOT NULL,
    `to`         TIMESTAMP     NOT NULL,
    `markup`     DECIMAL(8, 2) NOT NULL,
    `deleted_at` TIMESTAMP,
    PRIMARY KEY (`id`)
);

CREATE TABLE `film_session`
(
    `film_id`    INT UNSIGNED NOT NULL,
    `session_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`film_id`, `session_id`),
    CONSTRAINT `film_session_film_id_foreign`
        FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT `film_session_session_id_foreign`
        FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `hall_session`
(
    `hall_id`   INT UNSIGNED NOT NULL,
    `session_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`hall_id`, `session_id`),
    CONSTRAINT `hall_session_hall_id_foreign`
        FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT `hall_session_session_id_foreign`
        FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE `clients`
(
    `id`   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `orders`
(
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `film_id`     INT UNSIGNED,
    `session_id`  INT UNSIGNED,
    `place_id`    INT UNSIGNED,
    `user_id`     INT UNSIGNED,
    `final_price` DECIMAL UNSIGNED NOT NULL,
    `refund_at`   TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (`user_id`) REFERENCES `clients` (`id`) ON UPDATE CASCADE ON DELETE SET NULL
);