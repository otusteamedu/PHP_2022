DROP TABLE IF EXISTS films CASCADE;
CREATE TABLE films
(
    id    serial    NOT NULL
        CONSTRAINT pk_film_id PRIMARY KEY,
    title char(255) NOT NULL
);
INSERT INTO films
VALUES (1, 'Операция «Фортуна»: Искусство побеждать'),
       (2, 'Аватар: Путь воды');

DROP TABLE IF EXISTS film_values;
CREATE TABLE film_values
(
    id            serial NOT NULL CONSTRAINT pk_film_values_id PRIMARY KEY,
    film_id       serial NOT NULL,
    attribute_id  serial NOT NULL,
    value         text    DEFAULT NULL,
    value_date    date    DEFAULT NULL,
    value_boolean boolean DEFAULT false,
    value_int     interval DEFAULT NULL,
    value_float   float DEFAULT NULL
);

INSERT INTO film_values (film_id, attribute_id,  value_boolean)
VALUES (1, 4, true),
       (2, 4,  false);

INSERT INTO film_values (film_id, attribute_id,  value_date)
VALUES (1, 6, '2022-12-29'),
       (2, 6, '2022-12-29'),
       (1, 9,  '2022-12-29'),
       (2, 9,  '2022-12-29'),
       (1, 10, '2023-01-17'),
       (2, 10, '2023-01-15');

DROP TABLE IF EXISTS film_types CASCADE;
CREATE TABLE film_types
(
    id       serial   NOT NULL CONSTRAINT pk_film_film_types_id PRIMARY KEY,
    type     char(12) NOT NULL,
    title    char(12) NOT NULL,
    is_staff boolean DEFAULT false
);

INSERT INTO film_types(type, title, is_staff)
VALUES ('text', 'Текст', false),
       ('date', 'Дата', false),
       ('boolean', 'Да/Нет', false),
       ('date', 'Дата', true);

DROP TABLE IF EXISTS film_attributes CASCADE;
CREATE TABLE film_attributes
(
    id           serial    NOT NULL CONSTRAINT pk_film_attributes_id PRIMARY KEY,
    film_type_id serial    NOT NULL,
    title        char(125) NOT NULL,
    CONSTRAINT fk_film_type_id
        FOREIGN KEY (film_type_id) REFERENCES film_types

);
INSERT INTO film_attributes
VALUES (1, 1, 'Рецензия критика'),
       (2, 1, 'Национальной Академии кинематографических искусств и наук России'),
       (3, 1, 'Нью-Йоркская киноакадемия'),
       (4, 3, 'Оскар'),
       (5, 3, 'Золотая малина'),
       (6, 2, 'Дата начала продаж'),
       (7, 2, 'Мировая премьера'),
       (8, 2, 'Премьера в РФ'),
       (9, 4, 'Когда запускать рекламу на ТВ'),
       (10, 4, 'Когда запускать рекламу на Радио'),
       (11, 4, 'Дата закупки новой кинолетны');




