DROP TABLE IF EXISTS attr_film;
DROP TABLE IF EXISTS attrs;
DROP TABLE IF EXISTS films;
DROP TABLE IF EXISTS attr_types;
DROP TABLE IF EXISTS attr_names;

-- Films
CREATE TABLE films
(
    id   serial PRIMARY KEY,
    name varchar(50) NOT NULL
);

-- Attr types
CREATE TABLE attr_types
(
    id    serial PRIMARY KEY,
    value varchar(50) NOT NULL
);

-- Attr names
CREATE TABLE attr_names
(
    id    serial PRIMARY KEY,
    value text NOT NULL
);

-- Attrs
CREATE TABLE attrs
(
    id              serial PRIMARY KEY,
    attr_type_id    int          NOT NULL,
    attr_name_id    int          NOT NULL,
    int_value       int          DEFAULT NUll,
    text_value      text         DEFAULT NUll,
    bool_value      bool         DEFAULT NUll,
    decimal_value   decimal      DEFAULT NUll,
    timestamp_value timestamp    DEFAULT NUll
);
ALTER TABLE attrs
    ADD CONSTRAINT attrs_attr_type_id FOREIGN KEY (attr_type_id) REFERENCES attr_types (id) MATCH FULL;
ALTER TABLE attrs
    ADD CONSTRAINT attrs_attr_name_id FOREIGN KEY (attr_name_id) REFERENCES attr_names (id) MATCH FULL;

-- Attr film
CREATE TABLE attr_film
(
    attr_id int NOT NULL,
    film_id int NOT NULL
);
ALTER TABLE attr_film
    ADD PRIMARY KEY (film_id, attr_id);
ALTER TABLE attr_film
    ADD CONSTRAINT films_film_id FOREIGN KEY (film_id) REFERENCES films (id) MATCH FULL;
ALTER TABLE attr_film
    ADD CONSTRAINT attrs_attr_id FOREIGN KEY (attr_id) REFERENCES attrs (id) MATCH FULL;