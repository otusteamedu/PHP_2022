CREATE TABLE films
(
    `id`    INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL UNIQUE,
    PRIMARY KEY (`id`)
);

CREATE TABLE attribute_types
(
    `id`    INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
    `field` VARCHAR(255) NOT NULL,
    `name`  VARCHAR(255) NOT NULL UNIQUE,
    PRIMARY KEY (`id`)
);

CREATE TABLE attributes
(
    `id`                INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
    `attribute_type_id` INT UNSIGNED NOT NULL,
    `name`              VARCHAR(255) NOT NULL UNIQUE,
    PRIMARY KEY (`id`),
    CONSTRAINT `attribute_type_id_foreign`
        FOREIGN KEY (`attribute_type_id`) REFERENCES `attribute_types` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE attribute_film
(
    `film_id`      INT UNSIGNED NOT NULL,
    `attribute_id` INT UNSIGNED NOT NULL,
    `val_string`   VARCHAR(255),
    `val_text`     TEXT,
    `val_int`      INT,
    `val_bool`     BOOLEAN,
    `val_date`     DATE,
    `val_float`    DECIMAL,
    PRIMARY KEY (`film_id`, `attribute_id`),
    CONSTRAINT `attribute_film_film_id_foreign`
        FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT `attribute_film_attribute_id_foreign`
        FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);

