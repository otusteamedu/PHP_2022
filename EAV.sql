CREATE TABLE movie
(
    id    SERIAL PRIMARY KEY NOT NULL,
    title VARCHAR(100)       NOT NULL
);

CREATE TABLE attribute_type
(
    id   SERIAL PRIMARY KEY NOT NULL,
    type VARCHAR(100)       NOT NULL
);

CREATE TABLE movie_attribute
(
    id                SERIAL PRIMARY KEY NOT NULL,
    name              VARCHAR(100)       NOT NULL,
    attribute_type_id INTEGER            NOT NULL,
    CONSTRAINT fk_attribute_type
        FOREIGN KEY (attribute_type_id)
            REFERENCES attribute_type (id)
);

CREATE TABLE movie_attribute_values
(
    id                 SERIAL PRIMARY KEY NOT NULL,
    movie_attribute_id INTEGER            NOT NULL,
    v_int              INTEGER,
    v_float            NUMERIC,
    v_boolean          BOOLEAN,
    v_text             VARCHAR(1000),
    v_date             DATE,
    movie_id           INTEGER            NOT NULL,
    CONSTRAINT fk_attribute
        FOREIGN KEY (movie_attribute_id)
            REFERENCES movie_attribute (id),
    CONSTRAINT fk_movie
        FOREIGN KEY (movie_id)
            REFERENCES movie (id)
);