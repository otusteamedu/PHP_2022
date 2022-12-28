CREATE DATABASE app;

CREATE TABLE halls
(
    id SERIAL PRIMARY KEY,
    title VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE seats_type
(
    id SERIAL PRIMARY KEY,
    title VARCHAR(255)
);

CREATE TABLE seats
(
    id SERIAL PRIMARY KEY,
    row INT,
    number INT,
    seats_type_id INT REFERENCES seats_type(id),
    hall_id INT REFERENCES halls(id) ON DELETE CASCADE
);

CREATE TABLE seats_cost
(
    id SERIAL PRIMARY KEY,
    cost NUMERIC,
    seats_id INT REFERENCES seats(id) ON DELETE CASCADE,
    session_type_id INT REFERENCES sessions_type(id)
);

CREATE table films
(
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE table sessions_type
(
    id SERIAL PRIMARY KEY,
    title VARCHAR(255)
);

CREATE TABLE sessions
(
    id SERIAL PRIMARY KEY,
    start TIMESTAMP,
    film_id INT REFERENCES films(id),
    hall_id INT REFERENCES halls(id),
    session_type_id INT REFERENCES sessions_type(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
    cost NUMERIC,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Залы
INSERT INTO halls (title) VALUES ('Зал №1');
INSERT INTO halls (title) VALUES ('Зал №2');
INSERT INTO halls (title) VALUES ('Зал №3');

-- Тип места
INSERT INTO seats_type (title) VALUES ('Кресло');
INSERT INTO seats_type (title) VALUES ('Диван');

-- Места
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 1, 1, 1);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 2, 1, 1);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 3, 1, 2);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 1, 2, 1);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 2, 2, 1);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 3, 2, 2);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 1, 3, 1);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 2, 3, 1);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 3, 3, 2);

-- Типы сеансов
INSERT INTO sessions_type (title) VALUES ('Дневной');
INSERT INTO sessions_type (title) VALUES ('Вечерний');
INSERT INTO sessions_type (title) VALUES ('Ночной');

-- Стоимость мест на сеансе
INSERT INTO seats_cost (cost, seats_id, session_type_id) VALUES (350, 1, 1);
INSERT INTO seats_cost (cost, seats_id, session_type_id) VALUES (500, 1, 2);
INSERT INTO seats_cost (cost, seats_id, session_type_id) VALUES (500, 2, 2);
INSERT INTO seats_cost (cost, seats_id, session_type_id) VALUES (650, 3, 2);
INSERT INTO seats_cost (cost, seats_id, session_type_id) VALUES (500, 4, 2);
INSERT INTO seats_cost (cost, seats_id, session_type_id) VALUES (500, 5, 2);
INSERT INTO seats_cost (cost, seats_id, session_type_id) VALUES (500, 7, 2);

-- Фильмы
INSERT INTO films (title, description) VALUES ('Фильм №1', 'Описание фильма №1');
INSERT INTO films (title, description) VALUES ('Фильм №2', 'Описание фильма №2');
INSERT INTO films (title, description) VALUES ('Фильм №3', 'Описание фильма №3');

-- Сеансы
INSERT INTO sessions (start, film_id, hall_id, session_type_id) VALUES ('2022-10-11 10:00:00', 1, 1, 1);
INSERT INTO sessions (start, film_id, hall_id, session_type_id) VALUES ('2022-10-11 15:00:00', 2, 2, 1);
INSERT INTO sessions (start, film_id, hall_id, session_type_id) VALUES ('2022-10-11 19:00:00', 3, 3, 3);

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