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

CREATE OR REPLACE PROCEDURE random_string(IN length INT, INOUT film_name TEXT)
    LANGUAGE plpgsql
AS $$
DECLARE
    chars TEXT[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    i INT := 0;
BEGIN
    IF length < 0 THEN
        RAISE EXCEPTION 'Given length cannot be less than 0';
    END IF;

    FOR i IN 1..length LOOP
        film_name := film_name || chars[1+random()*(array_length(chars, 1)-1)];
    END LOOP;
END;
$$;

/* Добавляет фильмы */
CREATE OR REPLACE PROCEDURE insert_films(IN count_films INT)
    LANGUAGE plpgsql
AS $$
DECLARE
    default_duration INT := 70;
    default_base_price DECIMAL := 400;
    default_film_name_length INT := 40;
    random_duration DECIMAL;
    random_base_price DECIMAL;
    random_film_name_length DECIMAL;
    random_film_name TEXT;
BEGIN
    FOR i IN 1..count_films LOOP
        random_film_name := '';
        CALL rnd(0.5, 1.0, random_duration);
        CALL rnd(0.5, 1.0, random_base_price);
        CALL rnd(0.5, 1.0, random_film_name_length);
        CALL random_string(round(random_film_name_length * default_film_name_length)::INT, random_film_name);

        INSERT INTO film (name, duration, base_price) VALUES (
           'Фильм ' || random_film_name,
           round(random_duration * default_duration),
           round(random_base_price * default_base_price)
        );
    END LOOP;

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
    count_schedule INT := 0;
BEGIN
    SELECT count(*) from film INTO count_films;

    FOR cinema_hall_id IN SELECT id FROM cinema_hall LOOP
        WHILE date_temporary <= date_end LOOP
            WHILE time_temporary >= time_begining AND time_temporary <= time_end LOOP
                CALL get_random_film(count_films, random_film);

                INSERT INTO schedule (begin_session, film_id, cinema_hall_id)
                VALUES (date_temporary + time_temporary, random_film.id, cinema_hall_id);
                count_schedule := count_schedule + 1;
                time_interval := (random_film.duration + duration_break) || 'minute';
                time_temporary := time_temporary + time_interval;
            END LOOP;
            time_temporary := time_begining;

            date_temporary := date_temporary + 1;
        END LOOP;
        date_temporary = date_begining;
    END LOOP;

    CALL prn('schedule', 'Добавлено: ' || count_schedule || ' сеансов!');
END;
$$;

/* Добавляет билеты (проданные и нет) */
CREATE OR REPLACE PROCEDURE insert_tickets()
    LANGUAGE plpgsql
AS $$
DECLARE
    ticket_rec RECORD;
    count_tickets INT := 0;
    coefficient_price DECIMAL; /* билет в 1,5 - 2 раза дороже базовой цены */
    status_decimal DECIMAL;
    status BOOLEAN;
BEGIN
    FOR ticket_rec IN
        SELECT sch.id AS schedule_id, f.base_price, rel.id AS cinema_hall_place_relation_id
        FROM schedule sch
        JOIN film f ON sch.film_id = f.id
        JOIN cinema_hall_place_relation rel on sch.cinema_hall_id = rel.cinema_hall_id
    LOOP
        status_decimal := round(random());
        IF status_decimal = 0 THEN
            status := false;
        ELSE
            status := true;
        END IF;

        CALL rnd(0.5, 1.0, coefficient_price);

        INSERT INTO ticket (schedule_id, cinema_hall_place_relation_id, price, status)
        VALUES (
                    ticket_rec.schedule_id,
                    ticket_rec.cinema_hall_place_relation_id,
                    round(ticket_rec.base_price * coefficient_price, 2),
                    status
                );

        count_tickets := count_tickets + 1;
    END LOOP;

    CALL prn('ticket', 'Добавлено: ' || count_tickets || ' билетов!');
END;
$$;

DO $$
    DECLARE
        count_films INT := 1000000;
        count_cinema_halls INT := 8; /* Количество кинозалов */
        count_rows INT := 20; /* Максимальное количество рядов */
        count_cols INT := 100; /* Максимальное количество мест в ряду */
        date_begining DATE := '2022-07-14'; /* Дата начала расписания */
        date_end DATE := '2022-12-15'; /* Дата окончания расписания */
        time_begining TIME := '08:00:00'; /* Время начала первого сеанса */
        time_end TIME := '23:55:00'; /* Время начала последнего сеанса */
    BEGIN
        CALL insert_films(count_films);
        CALL insert_cinema_halls(count_cinema_halls);
        CALL insert_places(count_rows, count_cols);
        CALL insert_cinema_hall_place_relations(count_rows, count_cols);
        CALL insert_schedule(date_begining, date_end, time_begining, time_end);
        CALL insert_tickets();
    END;
$$;
