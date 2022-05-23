CREATE TAbLE IF NOT EXISTS film (
    id SERIAL PRIMARY KEY NOT NULL,
    name text NOT NULL,
    duration time NOT NULL
);
CREATE INDEX ON film(id);

CREATE TABLE IF NOT EXISTS film_attribute_type (
    id SERIAL PRIMARY KEY NOT NULL,
    type varchar NOT NULL UNIQUE
);
CREATE INDEX ON film_attribute_type(id);

CREATE TABLE IF NOT EXISTS film_attribute (
    id SERIAL NOT NULL PRIMARY KEY,
    film_attribute_type_id int REFERENCES film_attribute_type,
    name VARCHAR
);

CREATE INDEX ON film_attribute(id);


CREATE TABLE IF NOT EXISTS film_attribute_value (
    id SERIAL PRIMARY KEY ,
    film_id int NOT NULL REFERENCES film,
    film_attribute_id int NOT NULL REFERENCES film_attribute,
    val_int INT,
    val_float float,
    val_varchar VARCHAR(100),
    val_text TEXT,
    val_boolean BOOLEAN,
    val_date DATE
);
CREATE INDEX ON film_attribute_value(id);