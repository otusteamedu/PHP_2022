create table tickets (
    id           bigint unsigned auto_increment primary key,
    hall_show_id bigint unsigned NOT NULL,
    line         int             NOT NULL,
    number       int             NOT NULL,
    created_at   timestamp       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   timestamp       NULL     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    KEY `hall_show_id` (`hall_show_id`),
    UNIQUE KEY `unique_hall_show_line_number` (`hall_show_id`, `line`, `number`),
    CONSTRAINT `fk_hall_show_id` FOREIGN KEY (`hall_show_id`) REFERENCES `hall_shows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)
    collate = utf8mb4_unicode_ci;