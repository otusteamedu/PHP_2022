CREATE TABLE movies
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

CREATE TABLE attribute_movie
(
    `movie_id`      INT UNSIGNED NOT NULL,
    `attribute_id` INT UNSIGNED NOT NULL,
    `val_string`   TEXT,
    `val_integer`      INT,
    `val_bool`     BOOLEAN,
    `val_date`     DATE,
    `val_float`    DECIMAL,
    PRIMARY KEY (`movie_id`, `attribute_id`),
    CONSTRAINT `attribute_movie_movie_id_foreign`
        FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT `attribute_movie_attribute_id_foreign`
        FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);
