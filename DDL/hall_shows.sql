create table hall_shows (
    id         bigint unsigned auto_increment primary key,
    hall_id    bigint unsigned NOT NULL,
    movie_id   bigint unsigned NOT NULL,
    price      int             NOT NULL,
    start_date timestamp       NOT NULL,
    created_at timestamp       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp       NULL     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    KEY `hall_id` (`hall_id`),
    KEY `movie_id` (`movie_id`),
    CONSTRAINT `fk_hall_id` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_movie_id` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)
    collate = utf8mb4_unicode_ci;