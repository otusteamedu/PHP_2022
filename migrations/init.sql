CREATE DATABASE app;

CREATE TABLE films
(
    id SERIAL PRIMARY KEY,
    title VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE attribute_types
(
    id SERIAL PRIMARY KEY,
    type VARCHAR(255)
);

CREATE TABLE attributes
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(255),
    type_id INT REFERENCES attribute_types(id)
);

CREATE TABLE attribute_film
(
    id SERIAL PRIMARY KEY,
    attribute_id INT REFERENCES attributes(id) ON DELETE CASCADE,
    film_id INT REFERENCES films(id) ON DELETE CASCADE,
    value TEXT
);

-- Фильмы
INSERT INTO films (title) VALUES ('Фильм №1');
INSERT INTO films (title) VALUES ('Фильм №2');
INSERT INTO films (title) VALUES ('Фильм №3');

-- Типы атрибутов
INSERT INTO attribute_types (type) VALUES ('string');
INSERT INTO attribute_types (type) VALUES ('date');
INSERT INTO attribute_types (type) VALUES ('bool');

-- Атрибуты
INSERT INTO attributes (name, type_id) VALUES ('reviews', 1);
INSERT INTO attributes (name, type_id) VALUES ('prize', 3);
INSERT INTO attributes (name, type_id) VALUES ('world_premiere', 2);
INSERT INTO attributes (name, type_id) VALUES ('russian_premiere', 2);
INSERT INTO attributes (name, type_id) VALUES ('start_ticket_sale', 2);

-- Заполнение атрибутов
INSERT INTO attribute_film (attribute_id, film_id, value) VALUES (1, 1, 'Рецензия на фильм №1');
INSERT INTO attribute_film (attribute_id, film_id, value) VALUES (1, 2, 'Рецензия на фильм №2');
INSERT INTO attribute_film (attribute_id, film_id, value) VALUES (1, 3, 'Рецензия на фильм №3');
INSERT INTO attribute_film (attribute_id, film_id, value) VALUES (2, 1, '1');
INSERT INTO attribute_film (attribute_id, film_id, value) VALUES (3, 3, '2022-12-27');
INSERT INTO attribute_film (attribute_id, film_id, value) VALUES (4, 3, '2023-01-16');
INSERT INTO attribute_film (attribute_id, film_id, value) VALUES (5, 3, '2022-12-08');
INSERT INTO attribute_film (attribute_id, film_id, value) VALUES (3, 1, '2022-12-27');
INSERT INTO attribute_film (attribute_id, film_id, value) VALUES (4, 1, '2022-12-16');
INSERT INTO attribute_film (attribute_id, film_id, value) VALUES (5, 2, '2022-01-16');
INSERT INTO attribute_film (attribute_id, film_id, value) VALUES (3, 3, '2022-12-13');

-- Index
CREATE index attribute_type ON attribute_types(type);

-- View
CREATE OR REPLACE VIEW movies_tasks AS
    SELECT films.title, attributes.name, attribute_film.value
    FROM films
        INNER JOIN attribute_film on films.id = attribute_film.film_id
        INNER JOIN attributes on attribute_film.attribute_id = attributes.id
        INNER JOIN attribute_types on attributes.type_id = attribute_types.id
    WHERE
        CASE
            WHEN attribute_types.type = 'date'
                THEN CURRENT_DATE = (attribute_film.value::DATE) OR CURRENT_DATE + 20 = (attribute_film.value::DATE)
            ELSE false
        END
    ORDER BY films.title, attribute_film.value::DATE;

CREATE OR REPLACE VIEW movies AS
    SELECT films.title, attribute_types.type, attributes.name, attribute_film.value
    FROM attribute_film
        INNER JOIN films on attribute_film.film_id = films.id
        INNER JOIN attributes on attribute_film.attribute_id = attributes.id
        INNER JOIN attribute_types on attributes.type_id = attribute_types.id