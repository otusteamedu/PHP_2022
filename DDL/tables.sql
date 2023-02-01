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
CREATE TABLE genres (
    id          SERIAL PRIMARY KEY,
    name        VARCHAR(25),
    is_deleted  BOOL      NOT NULL DEFAULT false,
    created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO genres (name) VALUES ('Боевик');
INSERT INTO genres (name) VALUES ('Вестерн');
INSERT INTO genres (name) VALUES ('Гангстерский фильм');
INSERT INTO genres (name) VALUES ('Детектив');
INSERT INTO genres (name) VALUES ('Драма');
INSERT INTO genres (name) VALUES ('Исторический фильм');
INSERT INTO genres (name) VALUES ('Комедия');
INSERT INTO genres (name) VALUES ('Мелодрама');
INSERT INTO genres (name) VALUES ('Музыкальный фильм');
INSERT INTO genres (name) VALUES ('Нуар');
INSERT INTO genres (name) VALUES ('Политический фильм');
INSERT INTO genres (name) VALUES ('Приключенческий фильм');
INSERT INTO genres (name) VALUES ('Сказка');
INSERT INTO genres (name) VALUES ('Трагедия');
INSERT INTO genres (name) VALUES ('Трагикомедия');

CREATE TABLE movies_genre (
    id          SERIAL PRIMARY KEY,
    movie_id   INT       NOT NULL,
    genre_id   INT       NOT NULL,
    is_deleted BOOL      NOT NULL DEFAULT false,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies (id),
    FOREIGN KEY (genre_id) REFERENCES genres (id)
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

-- AEV
CREATE TABLE aev_types (
    id         VARCHAR(10) PRIMARY KEY,
    name       VARCHAR(50),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO aev_types (id, name) VALUES ('int', 'Целое число');
INSERT INTO aev_types (id, name) VALUES ('float', 'Дробное число');
INSERT INTO aev_types (id, name) VALUES ('text', 'Текстовое поле');
INSERT INTO aev_types (id, name) VALUES ('bool', 'Логическое значение');
INSERT INTO aev_types (id, name) VALUES ('date', 'Дата');
INSERT INTO aev_types (id, name) VALUES ('task', 'Задача');

CREATE TABLE aev_attributes (
    id         SERIAL PRIMARY KEY,
    type_id    VARCHAR(10) NOT NULL,
    name       VARCHAR(255),
    created_at TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (type_id) REFERENCES aev_types (id)
);
INSERT INTO aev_attributes (type_id, name) VALUES ('text', 'Рецензии критиков');
INSERT INTO aev_attributes (type_id, name) VALUES ('bool', 'Премия Оскар');
INSERT INTO aev_attributes (type_id, name) VALUES ('bool', 'Премия Ника');
INSERT INTO aev_attributes (type_id, name) VALUES ('int', 'Кол-во актеров');
INSERT INTO aev_attributes (type_id, name) VALUES ('float', 'Средняя стоимость цены за билет в городе');

CREATE TABLE aev_values (
    id            SERIAL PRIMARY KEY,
    movie_id      INT       NOT NULL,
    attribute_id  INT       NOT NULL,
    value_int     INT NULL,
    value_numeric NUMERIC NULL,
    value_text    TEXT NULL,
    value_date    DATE NULL,
    value_bool    BOOLEAN NULL,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies (id),
    FOREIGN KEY (attribute_id) REFERENCES aev_attributes (id)
);