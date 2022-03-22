CREATE TABLE hall
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(50)
);

CREATE TABLE film
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(200),
    timing TIME
);

CREATE TABLE sector
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(50)
);

CREATE TABLE row
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(50),
    sector_id INT REFERENCES sector (id)
);

CREATE TABLE place
(
    id SERIAL PRIMARY KEY,
    place_number INT,
    row_id INT REFERENCES row (id),
    hall_id INT REFERENCES hall (id)
);

CREATE TABLE film_session
(
    id SERIAL PRIMARY KEY,
    hall_id INT REFERENCES hall (id),
    film_id INT REFERENCES film (id),
    date DATE,
    start_time TIME,
    end_time TIME
);

CREATE TABLE day_type
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(30)
);

CREATE TABLE time_of_day
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(30)
);

CREATE TABLE price
(
    id SERIAL PRIMARY KEY,
    sector_id INT REFERENCES sector (id),
    day_type_id INT REFERENCES day_type (id),
    time_of_day_id INT REFERENCES time_of_day (id),
    price MONEY
);

CREATE TABLE ticket
(
    id SERIAL PRIMARY KEY,
    price MONEY,
    film_session_id INT REFERENCES film_session (id),
    place_id INT REFERENCES place (id)
);

ALTER TABLE ticket ALTER COLUMN price TYPE REAL;