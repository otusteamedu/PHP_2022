-- Таблица "Фильм":
-- id - уникальный ID
-- name - имя фильма
-- year - год производства
CREATE TABLE IF NOT EXISTS film_entity (
    id serial PRIMARY KEY NOT NULL,
    name varchar(255) NOT NULL,
    year varchar(4) NOT NULL
);

-- Таблица "Типы атрибутов фильма":
-- id - уникальный ID
-- name - название типа атрибута
CREATE TABLE IF NOT EXISTS film_attribute_type (
    id smallserial PRIMARY KEY NOT NULL,
    name varchar(100) NOT NULL UNIQUE
);

-- Таблица "Атрибуты фильма":
-- id - уникальный ID
-- type_id - тип атрибута фильма
-- name - название атрибута
CREATE TABLE IF NOT EXISTS film_attribute (
    id smallserial PRIMARY KEY NOT NULL,
    type_id smallint NOT NULL,
    name varchar(100) NOT NULL UNIQUE,

    FOREIGN KEY (type_id) REFERENCES film_attribute_type (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Таблица "Значения атрибутов фильма":
-- id - уникальный ID
-- film_id - id фильма
-- attribute_id - id атрибута
-- value_char - значение типа varchar
-- value_text - значение типа text
-- value_money - значение типа money
-- value_numeric - значение типа numeric
-- value_date - значение типа date
-- value_boolean - значение типа boolean
CREATE TABLE IF NOT EXISTS film_attribute_value (
    id serial PRIMARY KEY NOT NULL,
    film_id integer NOT NULL,
    attribute_id smallint NOT NULL,
    value_char varchar(255) DEFAULT NULL,
    value_text text DEFAULT NULL,
    value_money money DEFAULT NULL,
    value_numeric numeric DEFAULT NULL,
    value_date date  DEFAULT NULL,
    value_boolean boolean  DEFAULT NULL,
    FOREIGN KEY (film_id) REFERENCES film_entity (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (attribute_id) REFERENCES film_attribute (id) ON DELETE CASCADE ON UPDATE CASCADE
);