CREATE OR REPLACE FUNCTION get_date_interval() RETURNS interval AS
$$
BEGIN
    RETURN CONCAT(floor(random() * random() * 100) + 1, ' days')::interval;
END
$$ language plpgsql;

DO
$$
    DECLARE
        r int;
    BEGIN
        FOR r IN SELECT * FROM generate_series(1, 10000)
            LOOP
                INSERT INTO film(title, rating, date_from, date_to)
                values (CONCAT('Фильм', r), (r * floor(random() * 10) * 0.5), now() - get_date_interval(),
                        now() + get_date_interval());
            END LOOP;
    END;
$$;


CREATE OR REPLACE FUNCTION random_between(low INT, high INT)
    RETURNS INT AS
$$
BEGIN
    RETURN floor(random() * (high - low + 1) + low);
END
$$ language plpgsql;


DO
$$
    DECLARE
        r int;
    BEGIN
        FOR r IN SELECT * FROM generate_series(1, 10)
            LOOP
                INSERT INTO hall_type(title)
                values (CONCAT('Тип', r));
            END LOOP;
    END;
$$;


DO
$$
    DECLARE
        r int;
    BEGIN
        FOR r IN SELECT * FROM generate_series(1, 10)
            LOOP
                INSERT INTO hall(number, id_hall_type)
                values (random_between(1, 10), random_between(1, 5));
            END LOOP;
    END;
$$;


DO
$$
    DECLARE
        r int;
    BEGIN
        FOR r IN SELECT * FROM generate_series(1, 10000)
            LOOP
                INSERT INTO session(id_film, id_hall, price)
                values (random_between(1, 10000), random_between(1, 5), random_between(500, 1000));
            END LOOP;
    END;
$$;

DO
$$
    DECLARE
        r int;
    BEGIN
        FOR r IN SELECT * FROM generate_series(1, 100)
            LOOP
                INSERT INTO seat(number, row, hall_type_id)
                values (r, random_between(1, 30), random_between(1, 10));
            END LOOP;
    END;
$$;


DO
$$
    DECLARE
        r int;
    BEGIN
        FOR r IN SELECT * FROM generate_series(1, 100)
            LOOP
                INSERT INTO session_seat(id_session, id_seat)
                values (random_between(1, 10000), random_between(1, 100));
            END LOOP;
    END;
$$;

DO
$$
    DECLARE
        r int;
    BEGIN
        FOR r IN SELECT * FROM generate_series(1, 10000)
            LOOP
                INSERT INTO ticket(id_film, id_seat, id_hall, id_session, ticket_price)
                values (random_between(1, 10000), random_between(1, 100), random_between(1, 10),
                        random_between(1, 10000), random_between(500, 1000));
            END LOOP;
    END;
$$;