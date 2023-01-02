DROP TABLE IF EXISTS films CASCADE;
CREATE TABLE films
(
    id serial NOT NULL CONSTRAINT pk_film_id PRIMARY KEY,
    title varchar(255) NOT NULL,
    rating integer,
    release_date date
);


DROP TABLE IF EXISTS film_attribute_values;
CREATE TABLE film_attribute_values
(
    id            serial NOT NULL CONSTRAINT pk_film_values_id PRIMARY KEY,
    film_id       serial NOT NULL,
    attribute_id  serial NOT NULL,
    value         text    DEFAULT NULL,
    value_date    date    DEFAULT NULL,
    value_boolean boolean DEFAULT NULL,
    value_int     integer DEFAULT NULL,
    value_float   float DEFAULT NULL,
        CONSTRAINT fk_film_id
            FOREIGN KEY (film_id) REFERENCES films
);

DROP TABLE IF EXISTS film_attribute_types CASCADE;
CREATE TABLE film_attribute_types
(
    id serial NOT NULL CONSTRAINT pk_film_attribute_type_id PRIMARY KEY,
    type varchar(12) NOT NULL,
    title varchar(55) NOT NULL
);


DROP TABLE IF EXISTS film_attributes CASCADE;
CREATE TABLE film_attributes
(
    id serial NOT NULL CONSTRAINT pk_film_attributes_id PRIMARY KEY,
    film_type_id serial NOT NULL,
    title char(125) NOT NULL,
        CONSTRAINT fk_film_type_id
            FOREIGN KEY (film_type_id) REFERENCES film_attribute_types
);


DROP TABLE IF EXISTS film_attributes CASCADE;
CREATE TABLE film_attributes
(
    id           serial    NOT NULL CONSTRAINT pk_film_attributes_id PRIMARY KEY,
    film_type_id serial    NOT NULL,
    title        char(125) NOT NULL,
    CONSTRAINT fk_film_type_id
        FOREIGN KEY (film_type_id) REFERENCES film_attribute_types

);




