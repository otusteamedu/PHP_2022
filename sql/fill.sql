-- Залы
INSERT INTO halls (title) VALUES ('Зал №1');
INSERT INTO halls (title) VALUES ('Зал №2');
INSERT INTO halls (title) VALUES ('Зал №3');
INSERT INTO halls (title) VALUES ('Зал №4');
INSERT INTO halls (title) VALUES ('Зал №5');
INSERT INTO halls (title) VALUES ('Зал №6');
INSERT INTO halls (title) VALUES ('Зал №7');
INSERT INTO halls (title) VALUES ('Зал №8');
INSERT INTO halls (title) VALUES ('Зал №9');
INSERT INTO halls (title) VALUES ('Зал №10');

-- Типы сеансов
INSERT INTO sessions_type (title) VALUES ('Дневной');
INSERT INTO sessions_type (title) VALUES ('Вечерний');
INSERT INTO sessions_type (title) VALUES ('Ночной');

-- Тип места
INSERT INTO seats_type (title) VALUES ('Кресло');
INSERT INTO seats_type (title) VALUES ('Диван');

-- Места
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 1, 1, 1);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 2, 2, 1);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 3, 3, 2);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 1, 4, 1);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 2, 5, 1);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 3, 6, 2);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 1, 7, 1);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 2, 8, 1);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 3, 9, 2);
INSERT INTO seats (row, number, hall_id, seats_type_id) VALUES (1, 3, 10, 2);

DO $$
    DECLARE
        count integer := 10000000;
        film_id integer := 0;
        session_id integer := 0;

    BEGIN
        FOR i IN 1..count LOOP
            INSERT INTO films (title, description) VALUES (md5(random()::text), md5(random()::text)) RETURNING id into film_id;
            INSERT INTO sessions (start, film_id, hall_id, session_type_id) VALUES (CURRENT_TIMESTAMP, film_id, floor(random() * 10 + 1), floor(random() * 3 + 1)) RETURNING id into session_id;
            INSERT INTO tickets (session_id, seat_id, cost) VALUES (session_id, floor(random() * 10 + 1), random() * 10000);
        END LOOP;
    END
$$;