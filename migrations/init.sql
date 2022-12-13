CREATE DATABASE app;

CREATE TABLE halls
(
    id SERIAL PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE seats
(
    id SERIAL PRIMARY KEY,
    row INT,
    number INT,
    hall_id INT REFERENCES halls(id) ON DELETE CASCADE
);

CREATE table films
(
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sessions
(
    id SERIAL PRIMARY KEY,
    begin TIMESTAMP,
    film_id INT REFERENCES films(id),
    hall_id INT REFERENCES halls(id)
);

CREATE TABLE tickets
(
    id SERIAL PRIMARY KEY,
    session_id INT REFERENCES sessions(id),
    seats
)