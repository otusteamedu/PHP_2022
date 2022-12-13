CREATE DATABASE app;

CREATE TABLE halls
(
    id SERIAL PRIMARY KEY,
    title VARCHAR(255),
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
    start TIMESTAMP,
    film_id INT REFERENCES films(id),
    hall_id INT REFERENCES halls(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE seat_session
(
    id SERIAL PRIMARY KEY,
    seat_id INT REFERENCES seats(id),
    session_id INT REFERENCES sessions(id),
    cost FLOAT
);

CREATE TABLE clients
(
    id SERIAL PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tickets
(
    id SERIAL PRIMARY KEY,
    session_id INT REFERENCES sessions(id),
    seat_id INT REFERENCES seats(id),
    client_id INT REFERENCES clients(id),
    cost FLOAT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Залы
INSERT INTO halls (title) VALUES ('Зал №1');
INSERT INTO halls (title) VALUES ('Зал №2');
INSERT INTO halls (title) VALUES ('Зал №3');

-- Места
INSERT INTO seats (row, number, hall_id) VALUES (1, 1, 1);
INSERT INTO seats (row, number, hall_id) VALUES (1, 2, 1);
INSERT INTO seats (row, number, hall_id) VALUES (1, 3, 1);
INSERT INTO seats (row, number, hall_id) VALUES (1, 1, 2);
INSERT INTO seats (row, number, hall_id) VALUES (1, 2, 2);
INSERT INTO seats (row, number, hall_id) VALUES (1, 3, 2);
INSERT INTO seats (row, number, hall_id) VALUES (1, 1, 3);
INSERT INTO seats (row, number, hall_id) VALUES (1, 2, 3);
INSERT INTO seats (row, number, hall_id) VALUES (1, 3, 3);

-- Фильмы
INSERT INTO films (title, description) VALUES ('Фильм №1', 'Описание фильма №1');
INSERT INTO films (title, description) VALUES ('Фильм №2', 'Описание фильма №2');
INSERT INTO films (title, description) VALUES ('Фильм №3', 'Описание фильма №3');

-- Сеансы
INSERT INTO sessions (start, film_id, hall_id) VALUES ('2022-10-11 10:00:00', 1, 1);
INSERT INTO sessions (start, film_id, hall_id) VALUES ('2022-10-11 15:00:00', 2, 2);
INSERT INTO sessions (start, film_id, hall_id) VALUES ('2022-10-11 17:00:00', 3, 3);

-- Стоимость мест на сеансах
INSERT INTO seat_session (seat_id, session_id, cost) VALUES (1, 1, 500);
INSERT INTO seat_session (seat_id, session_id, cost) VALUES (2, 1, 500);
INSERT INTO seat_session (seat_id, session_id, cost) VALUES (3, 1, 500);
INSERT INTO seat_session (seat_id, session_id, cost) VALUES (4, 2, 350);
INSERT INTO seat_session (seat_id, session_id, cost) VALUES (5, 2, 700);
INSERT INTO seat_session (seat_id, session_id, cost) VALUES (6, 2, 200);
INSERT INTO seat_session (seat_id, session_id, cost) VALUES (7, 3, 900);
INSERT INTO seat_session (seat_id, session_id, cost) VALUES (8, 3, 600);
INSERT INTO seat_session (seat_id, session_id, cost) VALUES (9, 3, 750);

-- Клиенты
INSERT INTO clients (first_name, last_name) VALUES ('Иван', 'Иванов');
INSERT INTO clients (first_name, last_name) VALUES ('Илья', 'Сидоров');
INSERT INTO clients (first_name, last_name) VALUES ('Александр', 'Петров');

-- Билеты
INSERT INTO tickets (session_id, seat_id, client_id, cost) VALUES (1, 2, 1, 500);
INSERT INTO tickets (session_id, seat_id, client_id, cost) VALUES (2, 4, 1, 350);
INSERT INTO tickets (session_id, seat_id, client_id, cost) VALUES (1, 1, 2, 500);
INSERT INTO tickets (session_id, seat_id, client_id, cost) VALUES (1, 3, 3, 500);
INSERT INTO tickets (session_id, seat_id, client_id, cost) VALUES (3, 9, 1, 750);
INSERT INTO tickets (session_id, seat_id, client_id, cost) VALUES (3, 8, 2, 600);