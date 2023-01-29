DROP SCHEMA public CASCADE;
CREATE SCHEMA public;

-- Таблица с кинофильмами
CREATE TABLE movies (
    id          SERIAL PRIMARY KEY,
    name        VARCHAR(50),
    description VARCHAR(255),
    duration    INT       NOT NULL,
    is_deleted  BOOL      NOT NULL DEFAULT false,
    created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);