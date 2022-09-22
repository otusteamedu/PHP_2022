/* Логирование */
CREATE OR REPLACE PROCEDURE prn(IN tbl VARCHAR, IN txt VARCHAR)
    LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO log (tbl, txt) VALUES (tbl, txt);
END;
$$;

/* Генерирует случайное число от 0 до 1, но не менее min_value и добавляет к нему additional_value */
CREATE OR REPLACE PROCEDURE rnd(IN min_value DECIMAL, IN additional_value DECIMAL, INOUT result DECIMAL)
    LANGUAGE plpgsql
AS $$
BEGIN
    result := random();
    WHILE result < min_value LOOP
            result := random();
    END LOOP;

    result := result + additional_value;
END;
$$;

/* Возвращает случайно выбранный фильм из таблицы фильмов */
CREATE OR REPLACE PROCEDURE get_random_film(IN count_films INT, INOUT random_film RECORD)
    LANGUAGE plpgsql
AS $$
DECLARE
    offset_film INT;
BEGIN
    offset_film := round(count_films*random());
    IF offset_film = count_films THEN
        offset_film = count_films - 1;
    END IF;

    SELECT * FROM film INTO random_film OFFSET offset_film LIMIT 1;
END;
$$;

/* Добавляет фильмы */
CREATE OR REPLACE PROCEDURE insert_films()
    LANGUAGE plpgsql
AS $$
DECLARE
    count_films INT;
BEGIN
    INSERT INTO film (name, duration, base_price) VALUES ('Иван Васильевич меняет профессию', 90, 500.0),
                                                         ('Зеленая миля', 130, 700.0),
                                                         ('Побег из Шоушенка', 120, 600.0),
                                                         ('Бриллиантовая рука', 95, 600.0),
                                                         ('Джентльмены удачи', 85, 450.0),
                                                         ('Москва слезам не верит', 150, 650.0),
                                                         ('Служебный роман', 100, 500.0),
                                                         ('Собачье сердце', 105, 450.0),
                                                         ('Начало', 125, 550.0),
                                                         ('Титаник', 140, 600.0),
                                                         ('Властелин колец: Возвращение короля', 155, 680.0),
                                                         ('Властелин колец: Две крепости', 135, 530.0),
                                                         ('Властелин колец: Братство кольца', 130, 510.0);

    SELECT count(*) FROM film INTO count_films;
    CALL prn('film', 'Добавлено: ' || count_films || ' фильмов');
END;
$$;

/* Добавляет кинозалы */
CREATE OR REPLACE PROCEDURE insert_cinema_halls(IN count_cinema_halls INT)
    LANGUAGE plpgsql
AS $$
BEGIN
    FOR i IN 1..count_cinema_halls LOOP
        INSERT INTO cinema_hall (name) VALUES ('Кинозал ' || i);
    END LOOP;

    CALL prn('cinema_hall', 'Добавлено: ' || count_cinema_halls || ' кинозалов');
END;
$$;

/* Добавляет ряды и места */
CREATE OR REPLACE PROCEDURE insert_places(IN count_rows INT, IN count_cols INT)
    LANGUAGE plpgsql
AS $$
BEGIN
    FOR i IN 1..count_rows LOOP
        FOR j IN 1..count_cols LOOP
            INSERT INTO place (row, col) VALUES (i, j);
        END LOOP;
    END LOOP;

    CALL prn('place', 'Добавлено: ' || count_rows || ' рядов, ' || count_cols || ' мест в ряду. Всего: ' || count_rows * count_cols || ' мест');
END;
$$;

/* Добавляет отношения кинозалов и мест */
CREATE OR REPLACE PROCEDURE insert_cinema_hall_place_relations(IN count_rows INT, IN count_cols INT)
    LANGUAGE plpgsql
AS $$
DECLARE
    random_decimal_value DECIMAL;
    coefficient_rows DECIMAL := 0.5;
    coefficient_cols DECIMAL := 0.5;
    count_rows_cinema_hall INT;
    count_cols_cinema_hall INT;
    cinema_hall_id INT;
    place_id INT;
BEGIN
    FOR cinema_hall_id IN SELECT id FROM cinema_hall LOOP

        CALL rnd(coefficient_rows, 0.0, random_decimal_value);
        count_rows_cinema_hall := round(random_decimal_value * count_rows);

        CALL rnd(coefficient_cols, 0.0, random_decimal_value);
        count_cols_cinema_hall := round(random_decimal_value * count_cols);

        FOR place_id IN SELECT id FROM place WHERE row <= count_rows_cinema_hall AND col <= count_cols_cinema_hall LOOP
            INSERT INTO cinema_hall_place_relation (cinema_hall_id, place_id) VALUES (cinema_hall_id, place_id);
        END LOOP;

        CALL prn(
            'cinema_hall_place_relation, Кинозал с id: ' || cinema_hall_id,
            'Рядов: ' || count_rows_cinema_hall || ', мест в ряду: ' || count_cols_cinema_hall || '. Всего: ' || count_rows_cinema_hall * count_cols_cinema_hall || ' мест'
        );
    END LOOP;
END;
$$;

/* Добавляет расписание сеансов */
CREATE OR REPLACE PROCEDURE insert_schedule(
    IN date_begining DATE,
    IN date_end DATE,
    IN time_begining TIME,
    IN time_end TIME
)
    LANGUAGE plpgsql
AS $$
DECLARE
    duration_break INT := 15; /* Длительность перерыва между сеансами, в минутах */
    date_temporary DATE := date_begining;
    time_temporary TIME := time_begining;
    time_interval INTERVAL;
    cinema_hall_id INT;
    count_films INT; /* Количество фильмов */
    random_film film%rowtype; /* Случайно выбранный фильм */
BEGIN
    SELECT count(*) from film INTO count_films;

    FOR cinema_hall_id IN SELECT id FROM cinema_hall LOOP
        WHILE date_temporary <= date_end LOOP
            WHILE time_temporary >= time_begining AND time_temporary <= time_end LOOP
                CALL get_random_film(count_films, random_film);

                INSERT INTO schedule (begin_session, film_id, cinema_hall_id)
                VALUES (date_temporary + time_temporary, random_film.id, cinema_hall_id);

                CALL prn('schedule', 'Begin_session: ' || date_temporary + time_temporary ||
                                     ' cinema_hall_id: ' || cinema_hall_id ||
                                     ' film_id: ' || random_film.id || ' duration: ' || random_film.duration);

                time_interval := (random_film.duration + duration_break) || 'minute';
                time_temporary := time_temporary + time_interval;
            END LOOP;
            time_temporary := time_begining;

            date_temporary := date_temporary + 1;
        END LOOP;
        date_temporary = date_begining;
    END LOOP;
END;
$$;

/* Добавляет коэффициенты цен для билетов */
CREATE OR REPLACE PROCEDURE insert_price_settings()
    LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO price_setting (name, coefficient) VALUES ('Вечерний сеанс', 0.2),
                                                         ('Сеанс в выходные', 0.3),
                                                         ('Ближний ряд', 0.1),
                                                         ('Место в середине ряда', 0.15),
                                                         ('VIP зал', 0.25);
END;
$$;

/* Добавляет билет */
CREATE OR REPLACE PROCEDURE insert_ticket(IN ticket_rec RECORD)
    LANGUAGE plpgsql
AS $$
DECLARE
    total_sum_coefficients DECIMAL := 0;
    price_setting_rec RECORD;
    price_setting_ids INT[];
    target_price_setting_id INT;
    status BOOLEAN := false;
BEGIN
    IF round(random()) > 0 THEN
        status := true;
    END IF;

    FOR price_setting_rec IN SELECT * FROM price_setting LOOP
        IF round(random()) > 0 THEN
            total_sum_coefficients := total_sum_coefficients + price_setting_rec.coefficient;
            price_setting_ids := array_append(price_setting_ids, price_setting_rec.id);
        END IF;
    END LOOP;

    INSERT INTO ticket (schedule_id, cinema_hall_place_relation_id, price, status)
    VALUES (
               ticket_rec.schedule_id,
               ticket_rec.cinema_hall_place_relation_id,
               round(ticket_rec.base_price * (1.0 + total_sum_coefficients), 2),
               status
           );

    IF array_length(price_setting_ids, 1) > 0 THEN
        FOREACH target_price_setting_id IN ARRAY price_setting_ids LOOP
            INSERT INTO ticket_price_setting_relation (ticket_id, price_setting_id)
            VALUES (pg_catalog.currval('ticket_id_seq'), target_price_setting_id);
        END LOOP;
    END IF;
END;
$$;

/* Добавляет билеты (проданные и нет) */
CREATE OR REPLACE PROCEDURE insert_tickets()
    LANGUAGE plpgsql
AS $$
DECLARE
    ticket_rec RECORD;
    count_tickets INT := 0;
BEGIN
    FOR ticket_rec IN
        SELECT sch.id AS schedule_id, f.base_price, rel.id AS cinema_hall_place_relation_id
        FROM schedule sch
        JOIN film f ON sch.film_id = f.id
        JOIN cinema_hall_place_relation rel on sch.cinema_hall_id = rel.cinema_hall_id
    LOOP
        CALL insert_ticket(ticket_rec);
        count_tickets := count_tickets + 1;
    END LOOP;

    CALL prn('ticket', 'Добавлено: ' || count_tickets || ' билетов!');
END;
$$;

DO $$
    DECLARE
        count_cinema_halls INT := 8; /* Количество кинозалов */
        count_rows INT := 20; /* Максимальное количество рядов */
        count_cols INT := 100; /* Максимальное количество мест в ряду */
        date_begining DATE := '2022-09-14'; /* Дата начала расписания */
        date_end DATE := '2022-10-15'; /* Дата окончания расписания */
        time_begining TIME := '08:00:00'; /* Время начала первого сеанса */
        time_end TIME := '23:55:00'; /* Время начала последнего сеанса */
    BEGIN
        CALL insert_films();
        CALL insert_cinema_halls(count_cinema_halls);
        CALL insert_places(count_rows, count_cols);
        CALL insert_cinema_hall_place_relations(count_rows, count_cols);
        CALL insert_schedule(date_begining, date_end, time_begining, time_end);
        CALL insert_price_settings();
        CALL insert_tickets();
    END;
$$;
