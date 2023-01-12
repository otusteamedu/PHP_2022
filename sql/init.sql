-- Залы
CREATE TABLE halls
(
    id SERIAL PRIMARY KEY,
    title VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Типы мест
CREATE TABLE seats_type
(
    id SERIAL PRIMARY KEY,
    title VARCHAR(255)
);

-- Места
CREATE TABLE seats
(
    id SERIAL PRIMARY KEY,
    row INT,
    number INT,
    seats_type_id INT REFERENCES seats_type(id),
    hall_id INT REFERENCES halls(id) ON DELETE CASCADE
);

-- Типы сеансов
CREATE table sessions_type
(
    id SERIAL PRIMARY KEY,
    title VARCHAR(255)
);

-- Стоимость места
CREATE TABLE seats_cost
(
    id SERIAL PRIMARY KEY,
    cost NUMERIC,
    seats_id INT REFERENCES seats(id) ON DELETE CASCADE,
    session_type_id INT REFERENCES sessions_type(id)
);

-- Фильмы
CREATE table films
(
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Сеансы
CREATE TABLE sessions
(
    id SERIAL PRIMARY KEY,
    start TIMESTAMP,
    film_id INT REFERENCES films(id),
    hall_id INT REFERENCES halls(id),
    session_type_id INT REFERENCES sessions_type(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Билеты
CREATE TABLE tickets
(
    id SERIAL PRIMARY KEY,
    session_id INT REFERENCES sessions(id),
    seat_id INT REFERENCES seats(id),
    cost NUMERIC,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);