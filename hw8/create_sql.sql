-- База данных.
-- Database: otus_hw8

-- DROP DATABASE IF EXISTS otus_hw8;

CREATE DATABASE otus_hw8
    WITH
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Russian_Russia.1251'
    LC_CTYPE = 'Russian_Russia.1251'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;

-- Фильмы.
CREATE TABLE films (
    id          integer CONSTRAINT film_pkey PRIMARY KEY,
    title       varchar(100) NOT NULL,
    description varchar(500) NULL
);

-- Типы атрибутов.
CREATE TABLE type_attribute (
    id          integer CONSTRAINT type_attribute_pkey PRIMARY KEY,
    name_type   varchar(200) NOT NULL
);

-- Аттрибуты.
CREATE TABLE attributes (
    id              integer CONSTRAINT attribute_pkey PRIMARY KEY,
    id_type         integer REFERENCES type_attribute (id),
    name_attribute  varchar(200) NOT NULL
);

-- Значения.
CREATE TABLE values (
    id             integer CONSTRAINT value_pkey PRIMARY KEY,
    id_attribute   integer REFERENCES attributes (id),
    id_film        integer REFERENCES films (id),
    value_string   string
    value_bool     bool
    value_date     date
    value_float    float
    value_int      int
);

-- Заполнение Фильмы.
INSERT INTO films (id, title, description) VALUES
('1', 'Film1', 'Funny film'),
('2', 'Film2', 'Horror'),
('3', 'Film3', 'Interesting');

-- Заполнение Типы аттрибутов.
INSERT INTO type_attribute (id, name_type) VALUES
('1', 'string'),
('2', 'bool'),
('3', 'date'),
('4', 'float'),
('5', 'int');

-- Заполнение Аттрибуты.
INSERT INTO attributes (id, id_type, name_attribute) VALUES
(1, 1, 'Рецензия'),
(2, 2, 'Премия'),
(3, 3, 'Важные даты'),
(4, 3, 'Служебные даты');

-- Заполнение Значения.
INSERT INTO values (id, id_attribute, id_film, value_string, value_bool, value_date, value_float, value_int) VALUES
(1, 1, 1, 'Хороший фильм.', null, null, null, null),
(2, 2, 1, null, false, null, null, null),
(3, 3, 1, null, null, '2022-10-10', null, null),
(4, 3, 1, null, null, '2022-03-03', null, null)
(5, 2, 2, null, true, null, null, null),
(6, 4, 2, null, null, '2022-03-03', null, null),
(7, 4, 2, null, null, '2022-12-14', null, null),
(8, 3, 3, null, null, '2022-12-15', null, null),
(9, 3, 3, null, null, '2023-01-03', null, null),
(10, 4, 2, null, null, '2023-03-03', null, null);

CREATE VIEW view1 AS
SELECT * FROM values
         LEFT JOIN attributes ON attributes.id = values.id_attribute
         LEFT JOIN type_attribute ON type_attribute.id = attributes.id_type
WHERE (type_attribute.id = 3 OR type_attribute.id = 4)
  AND (values.value::date = NOW() OR  values.value::date > (NOW() + '20 day'::interval));

CREATE VIEW view2 AS
SELECT films.title, attributes.name_attribute, type_attribute.name_type
    CASE
        WHEN values.value_string IS NOT NULL THEN values.value_string::text
        WHEN values.value_bool IS NOT NULL THEN values.value_bool::text
        WHEN values.value_date IS NOT NULL THEN values.value_date::text
        WHEN values.value_float IS NOT NULL THEN values.value_float::text
        WHEN values.value_int IS NOT NULL THEN values.value_int::text
    END "value_attribute"
    FROM values
        LEFT JOIN attributes ON attributes.id = values.id_attribute
        LEFT JOIN films ON films.id = values.id_film
        LEFT JOIN type_attribute ON type_attribute.id = attributes.id_type
