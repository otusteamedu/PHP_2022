CREATE TABLE film
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(200),
    timing TIME
);

CREATE INDEX on film(id);

CREATE TABLE film_attribute_type
(
    id SERIAL PRIMARY KEY,
    type VARCHAR(50)
);

CREATE INDEX on film_attribute_type(id);

CREATE TABLE film_attribute
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(50),
    film_attribute_type_id INT REFERENCES film_attribute_type (id)
);

CREATE INDEX on film_attribute(id);

CREATE TABLE film_value
(
    film_id INT REFERENCES film (id),
    film_attribute_id INT REFERENCES film_attribute (id),
    value_int INT,
    value_numeric NUMERIC(2),
    value_varchar VARCHAR(100),
    value_text TEXT,
    value_boolean BOOLEAN,
    value_date DATE,
    PRIMARY KEY (film_id, film_attribute_id)
);

CREATE INDEX on film_value(film_id, film_attribute_id);
