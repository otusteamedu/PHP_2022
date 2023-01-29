DROP SCHEMA public CASCADE;
CREATE SCHEMA public;

-- Кинофильмы
CREATE TABLE movies (
    id          SERIAL PRIMARY KEY,
    name        VARCHAR(50),
    description VARCHAR(255),
    duration    INT       NOT NULL,
    is_deleted  BOOL      NOT NULL DEFAULT false,
    created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);


-- Залы
CREATE TABLE halls (
    id          SERIAL PRIMARY KEY,
    name        VARCHAR(50),
    is_deleted  BOOL      NOT NULL DEFAULT false,
    created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO halls (id, name) VALUES (1, 'Синий зал');
INSERT INTO halls (id, name) VALUES (2, 'Красный зал');
INSERT INTO halls (id, name) VALUES (3, 'Оранжевый зал');

-- Места в зале
CREATE TABLE halls_places (
    id         SERIAL PRIMARY KEY,
    hall_id    INT       NOT NULL,
    line       INT       NOT NULL,
    number     INT       NOT NULL,
    is_deleted BOOL      NOT NULL DEFAULT false,
    created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hall_id) REFERENCES halls (id)
);
CREATE UNIQUE INDEX idx_halls_places_line_number ON halls_places (hall_id, line, number);

-- Показы фильмов
create table movies_shows (
    id         SERIAL PRIMARY KEY,
    hall_id    INT       NOT NULL,
    movie_id   INT       NOT NULL,
    price      INT       NOT NULL,
    start_date timestamp NOT NULL,
    is_deleted BOOL      NOT NULL DEFAULT false,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hall_id) REFERENCES halls (id),
    FOREIGN KEY (movie_id) REFERENCES movies (id)
);

-- Билетики
create table tickets (
    id         SERIAL PRIMARY KEY,
    show_id    INT       NOT NULL,
    place_id   INT       NOT NULL,
    is_deleted BOOL      NOT NULL DEFAULT false,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (show_id) REFERENCES movies_shows (id),
    FOREIGN KEY (place_id) REFERENCES halls_places (id)
);