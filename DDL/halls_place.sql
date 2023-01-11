# Места в зале
create table halls_places (
    id         bigint unsigned auto_increment primary key,
    hall_id    bigint unsigned NOT NULL,
    line       int       NOT NULL,
    number     int       NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NULL     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    KEY `hall_id` (`hall_id`),
    CONSTRAINT `halls_places_halls_fk ` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) collate = utf8mb4_unicode_ci;