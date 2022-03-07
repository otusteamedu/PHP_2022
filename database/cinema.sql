CREATE TABLE hall (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50)
);

CREATE TABLE film (
    id SERIAL PRIMARY KEY,
    name VARCHAR(200),
    timing TIME
);

CREATE TABLE sector (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50)
);

CREATE TABLE row (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50),
    sector_id INT REFERENCES sector (id)
);

CREATE TABLE place (
    id SERIAL PRIMARY KEY,
    place_number INT,
    row_id INT REFERENCES row (id),
    hall_id INT REFERENCES hall (id)
);

CREATE TABLE film_session (
    id SERIAL PRIMARY KEY,
    hall_id INT REFERENCES hall (id),
    film_id INT REFERENCES film (id),
    start_time TIMESTAMP,
    end_time TIMESTAMP
);

CREATE TABLE day_type (
    id SERIAL PRIMARY KEY,
    name VARCHAR(30)
);

CREATE TABLE time_of_day (
    id SERIAL PRIMARY KEY,
    name VARCHAR(30)
);

CREATE TABLE price (
    id SERIAL PRIMARY KEY,
    sector_id INT REFERENCES sector (id),
    day_type_id INT REFERENCES day_type (id),
    time_of_day_id INT REFERENCES time_of_day (id),
    price MONEY
);

CREATE TABLE ticket (
    id SERIAL PRIMARY KEY,
    price_id INT REFERENCES price (id),
    film_session_id INT REFERENCES film_session (id),
    place_id INT REFERENCES place (id)
);

INSERT INTO hall (name) VALUES ('Зал 1'), ('Зал 2'), ('Зал 3'), ('Зал 4'), ('Зал 5');

INSERT INTO sector (name) VALUES ('Сектор 1'), ('Сектор 2'), ('Сектор 3');

INSERT INTO row (name, sector_id)
VALUES
       ('Ряд 1', 1),
       ('Ряд 2', 1),
       ('Ряд 3', 2),
       ('Ряд 4', 2),
       ('Ряд 5', 3),
       ('Ряд 6', 3);

INSERT INTO film (name, timing)
VALUES
       ('Гладиатор', '02:05'),
       ('Титаник', '03:15'),
       ('Храброе сердце', '02:10'),
       ('Аватар', '02:35'),
       ('Начало', '02:15'),
       ('Матрица', '01:55');

DO $$
    BEGIN
        FOR i IN 1..5 LOOP
                FOR j IN 1..6 LOOP
                        FOR k IN 1..10 LOOP
                                INSERT INTO place (place_number, row_id, hall_id) values(k, j, i);
                            END LOOP;
                    END LOOP;
            END LOOP;
    END;
$$;

INSERT INTO film_session (hall_id, film_id, start_time, end_time)
VALUES
    (1, 1, '2022-03-02 10:00', '2022-03-02 12:05'),
    (1, 2, '2022-03-02 12:30', '2022-03-02 16:30'),
    (1, 3, '2022-03-02 16:50', '2022-03-02 19:00'),
    (1, 4, '2022-03-02 19:20', '2022-03-02 21:55'),

    (2, 6, '2022-03-02 09:00', '2022-03-02 10:55'),
    (2, 5, '2022-03-02 11:10', '2022-03-02 12:05'),
    (2, 4, '2022-03-02 12:20', '2022-03-02 14:55'),
    (2, 3, '2022-03-02 15:10', '2022-03-02 17:20'),
    (2, 2, '2022-03-02 17:40', '2022-03-02 20:55'),

    (3, 1, '2022-03-02 09:30', '2022-03-02 11:35'),
    (3, 2, '2022-03-02 11:50', '2022-03-02 15:05'),
    (3, 5, '2022-03-02 15:20', '2022-03-02 17:35'),
    (3, 6, '2022-03-02 17:50', '2022-03-02 19:45'),
    (3, 1, '2022-03-02 20:00', '2022-03-02 22:05'),

    (4, 2, '2022-03-02 10:00', '2022-03-02 13:15'),
    (4, 4, '2022-03-02 13:30', '2022-03-02 16:05'),
    (4, 1, '2022-03-02 16:15', '2022-03-02 18:20'),
    (4, 6, '2022-03-02 18:30', '2022-03-02 20:25'),

    (5, 5, '2022-03-02 09:30', '2022-03-02 11:45'),
    (5, 4, '2022-03-02 12:00', '2022-03-02 14:35'),
    (5, 3, '2022-03-02 14:40', '2022-03-02 15:50'),
    (5, 6, '2022-03-02 16:00', '2022-03-02 17:55'),
    (5, 3, '2022-03-02 18:10', '2022-03-02 20:20');

INSERT INTO day_type (name) VALUES ('weekday'), ('weekends');

INSERT INTO time_of_day (name) VALUES ('morning'), ('day'), ('evening');

INSERT INTO price (sector_id, day_type_id, time_of_day_id, price)
VALUES
       (1, 1, 1, 100),
       (1, 1, 2, 150),
       (1, 1, 3, 200),
       (2, 1, 1, 150),
       (2, 1, 2, 200),
       (2, 1, 3, 250),
       (3, 1, 1, 100),
       (3, 1, 2, 150),
       (3, 1, 3, 200),
       (1, 2, 1, 200),
       (1, 2, 2, 250),
       (1, 2, 3, 300),
       (2, 2, 1, 300),
       (2, 2, 2, 350),
       (2, 2, 3, 400),
       (3, 2, 1, 200),
       (3, 2, 2, 250),
       (3, 2, 3, 300);

INSERT INTO ticket (price_id, film_session_id, place_id)
VALUES
    (1, 1, 5), (4, 1, 22), (1, 1, 17),
    (5, 2, 23), (8, 2, 43),
    (6, 6, 21), (6, 3, 33), (3, 3, 13),
    (9, 4, 43), (9, 4, 49),
    (4, 5, 87), (4, 5, 94),
    (4, 6, 87), (7, 6, 56),
    (8, 7, 58), (5, 7, 82),
    (2, 8, 66), (2, 8, 78), (5, 8, 95),
    (3, 9, 67), (6, 9, 91),
    (7, 10, 112),
    (5, 11, 141), (2, 11, 132),
    (2, 12, 144), (5, 12, 139),
    (6, 13, 145), (3, 13, 139),
    (3, 14, 140), (6, 14, 141),
    (4, 15, 220), (7, 15, 230),
    (2, 16, 181), (2, 16, 186);