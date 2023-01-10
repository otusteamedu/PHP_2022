create table movies (
    id         bigint unsigned auto_increment primary key,
    name       varchar(255) NOT NULL,
    duration   int          NOT NULL,
    created_at timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp    NULL     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
)
    collate = utf8mb4_unicode_ci;