# Показы фильмов
create table movies_shows (
    id         bigint unsigned auto_increment primary key,
    hall_id    bigint unsigned NOT NULL,
    movie_id   bigint unsigned NOT NULL,
    price      int             NOT NULL,
    start_date timestamp       NOT NULL,
    created_at timestamp       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp       NULL     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    KEY `hall_id` (`hall_id`),
    KEY `movie_id` (`movie_id`),
    CONSTRAINT `movies_shows_halls_fk` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `movies_shows_movies_fk` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) collate = utf8mb4_unicode_ci;