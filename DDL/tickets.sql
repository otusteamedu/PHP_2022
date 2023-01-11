# Билетики
create table tickets (
    id           bigint unsigned auto_increment primary key,
    hall_show_id bigint unsigned NOT NULL,
    hall_place_id bigint unsigned NOT NULL,
    created_at   timestamp       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   timestamp       NULL     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    KEY `hall_show_id` (`hall_show_id`),
    KEY `hall_place_id` (`hall_place_id`),
    UNIQUE KEY `unique_hall_show_hall_place` (`hall_show_id`, `hall_place_id`),
    CONSTRAINT `tickets_movies_shows_fk` FOREIGN KEY (`hall_show_id`) REFERENCES `movies_shows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `tickets_halls_places_fk` FOREIGN KEY (`hall_place_id`) REFERENCES `halls_places` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) collate = utf8mb4_unicode_ci;