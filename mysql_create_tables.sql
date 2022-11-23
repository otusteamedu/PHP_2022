CREATE TABLE films
(
    `id`         INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
    `name`       VARCHAR(255)  NOT NULL UNIQUE,
    `base_price` DECIMAL(8, 2) NOT NULL,
    PRIMARY KEY (`id`),
);


CREATE TABLE `places`
(
    `id`          INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
    `number`      INT UNSIGNED NOT NULL,
    `hall_number` INT UNSIGNED NOT NULL,
    `markup`      DECIMAL(8, 2) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `sessions`
(
    `id`     INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
    `from`   TIMESTAMP     NOT NULL,
    `to`     TIMESTAMP     NOT NULL,
    `markup` DECIMAL(8, 2) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `film_session`
(
    `film_id`    INT UNSIGNED NOT NULL,
    `session_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`film_id`, `session_id`)
);

CREATE TABLE `place_session`
(
    `place_id`   INT UNSIGNED NOT NULL,
    `session_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`place_id`, `session_id`)
);

CREATE TABLE `orders`
(
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `film_id`     INT NOT NULL,
    `session_id`  INT NOT NULL,
    `place_id`    INT NOT NULL,
    `user_id`     INT NOT NULL,
    `final_price` INT NOT NULL
);
ALTER TABLE
    `orders`
    ADD PRIMARY KEY `orders_id_primary`(`id`);
CREATE TABLE `clients`
(
    `id`   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL
);
ALTER TABLE
    `clients`
    ADD PRIMARY KEY `clients_id_primary`(`id`);
ALTER TABLE
    `film_session`
    ADD CONSTRAINT `film_session_film_id_foreign` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`);
ALTER TABLE
    `film_session`
    ADD CONSTRAINT `film_session_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`);
ALTER TABLE
    `place_session`
    ADD CONSTRAINT `place_session_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`);
ALTER TABLE
    `place_session`
    ADD CONSTRAINT `place_session_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`);
ALTER TABLE
    `orders`
    ADD CONSTRAINT `orders_film_id_foreign` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`);
ALTER TABLE
    `orders`
    ADD CONSTRAINT `orders_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`);
ALTER TABLE
    `orders`
    ADD CONSTRAINT `orders_place_id_foreign` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`);
ALTER TABLE
    `orders`
    ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `clients` (`id`);