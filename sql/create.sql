CREATE TABLE movie
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE movie_attribute_type
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL
);

CREATE TABLE movie_attribute
(
    id                      SERIAL PRIMARY KEY,
    name                    VARCHAR(255) NOT NULL,
    movie_attribute_type_id INT          NOT NULL,
    FOREIGN KEY (movie_attribute_type_id) REFERENCES movie_attribute_type (id)
);

CREATE TABLE movie_attribute_value
(
    id                 SERIAL PRIMARY KEY,
    movie_id           INT NOT NULL,
    movie_attribute_id INT NOT NULL,
    value_int          INT,
    value_bool         BOOLEAN,
    value_date         DATE,
    value_string       VARCHAR(3000),
    value_float        FLOAT,
    FOREIGN KEY (movie_id) REFERENCES movie (id),
    FOREIGN KEY (movie_attribute_id) REFERENCES movie_attribute (id)
);