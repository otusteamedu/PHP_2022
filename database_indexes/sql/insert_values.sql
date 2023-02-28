INSERT INTO hall (name)
VALUES ('Зал 1'),
       ('Зал 2'),
       ('Зал 3'),
       ('Зал 4'),
       ('Зал 5');

INSERT INTO sector (name)
VALUES ('Сектор 1'),
       ('Сектор 2'),
       ('Сектор 3');

INSERT INTO row (name, sector_id)
VALUES ('Ряд 1', 1),
       ('Ряд 2', 1),
       ('Ряд 3', 2),
       ('Ряд 4', 2),
       ('Ряд 5', 3),
       ('Ряд 6', 3);

INSERT INTO film (name, timing)
VALUES ('Гладиатор', '02:05'),
       ('Титаник', '03:15'),
       ('Храброе сердце', '02:10'),
       ('Аватар', '02:35'),
       ('Начало', '02:15'),
       ('Матрица', '01:55');

DO
$$
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

DO
$$
    BEGIN
        FOR i IN 0..43480 LOOP --"FOR i IN 0..434 LOOP" наполнить таблицу на ~10000 записей

                INSERT INTO film_session (hall_id, film_id, date, start_time, end_time)
                VALUES (1, 1, now() + i * interval '1 day', '10:00', '12:05'),
                       (1, 2, now() + i * interval '1 day', '12:30', '16:30'),
                       (1, 3, now() + i * interval '1 day', '16:50', '19:00'),
                       (1, 4, now() + i * interval '1 day', '19:20', '21:55'),

                       (2, 6, now() + i * interval '1 day', '09:00', '10:55'),
                       (2, 5, now() + i * interval '1 day', '11:10', '12:05'),
                       (2, 4, now() + i * interval '1 day', '12:20', '14:55'),
                       (2, 3, now() + i * interval '1 day', '15:10', '17:20'),
                       (2, 2, now() + i * interval '1 day', '17:40', '20:55'),

                       (3, 1, now() + i * interval '1 day', '09:30', '11:35'),
                       (3, 2, now() + i * interval '1 day', '11:50', '15:05'),
                       (3, 5, now() + i * interval '1 day', '15:20', '17:35'),
                       (3, 6, now() + i * interval '1 day', '17:50', '19:45'),
                       (3, 1, now() + i * interval '1 day', '20:00', '22:05'),

                       (4, 2, now() + i * interval '1 day', '10:00', '13:15'),
                       (4, 4, now() + i * interval '1 day', '13:30', '16:05'),
                       (4, 1, now() + i * interval '1 day', '16:15', '18:20'),
                       (4, 6, now() + i * interval '1 day', '18:30', '20:25'),

                       (5, 5, now() + i * interval '1 day', '09:30', '11:45'),
                       (5, 4, now() + i * interval '1 day', '12:00', '14:35'),
                       (5, 3, now() + i * interval '1 day', '14:40', '15:50'),
                       (5, 6, now() + i * interval '1 day', '16:00', '17:55'),
                       (5, 3, now() + i * interval '1 day', '18:10', '20:20');
        END LOOP;
    END
$$;


INSERT INTO day_type (name)
VALUES ('weekday'),
       ('weekends');

INSERT INTO time_of_day (name)
VALUES ('morning'),
       ('day'),
       ('evening');

INSERT INTO price (sector_id, day_type_id, time_of_day_id, price)
VALUES (1, 1, 1, 100), (1, 1, 2, 150), (1, 1, 3, 200),
       (2, 1, 1, 150), (2, 1, 2, 200), (2, 1, 3, 250),
       (3, 1, 1, 100), (3, 1, 2, 150), (3, 1, 3, 200),
       (1, 2, 1, 200), (1, 2, 2, 250), (1, 2, 3, 300),
       (2, 2, 1, 300), (2, 2, 2, 350), (2, 2, 3, 400),
       (3, 2, 1, 200), (3, 2, 2, 250), (3, 2, 3, 300);

DO
$$
    BEGIN
        FOR i IN 1..16667 LOOP -- "FOR i IN 1..167 LOOP" наполнить таблицу на ~10000 записей
            FOR j IN 0..59 LOOP
                INSERT INTO ticket (price, film_session_id, place_id)
                VALUES (100, i, (
                        SELECT place.id FROM place, hall, film_session
                        WHERE place.hall_id = film_session.hall_id AND film_session.id = i
                        ORDER BY place.id LIMIT 1) + j
                    );
            END LOOP;
        END LOOP;
    END
$$;


