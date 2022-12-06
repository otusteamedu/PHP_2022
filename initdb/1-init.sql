CREATE TABLE films (
    id INT UNIQUE NOT NULL,
    name VARCHAR (255) NOT NULL
);

CREATE TABLE film_attribute_types(
    id INT UNIQUE NOT NULL,
    type VARCHAR (255) UNIQUE NOT NULL
);

CREATE TABLE film_attributes(
    id INT UNIQUE NOT NULL,
    label VARCHAR (255) NOT NULL,
    film_attribute_type_id INT NOT NULL, FOREIGN KEY (film_attribute_type_id) REFERENCES film_attribute_types (id)
);

CREATE TABLE film_values(
   id serial PRIMARY KEY,

   film_id INT NOT NULL, FOREIGN KEY (film_id) REFERENCES films (id),
   attribute_id INT NOT NULL, FOREIGN KEY (attribute_id) REFERENCES film_attributes (id),

   value_num NUMERIC,
   value_date DATE,
   value_boolean BOOLEAN,
   value_text TEXT
);

