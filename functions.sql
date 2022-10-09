CREATE OR REPLACE FUNCTION get_random_int(a int, b int) RETURNS int AS
$$
BEGIN
    RETURN random() * (b - a) + a;
END
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_random_timestamp(for_future bool DEFAULT false) RETURNS timestamp AS
$$
BEGIN
    IF for_future = TRUE THEN
        RETURN now() + random() * (interval '365 days');
    ELSE
        RETURN now() - random() * (interval '365 days');
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_random_string(length int) RETURNS text AS
$$
DECLARE
    chars   text[] := '{0,1,2,3,4,5,6,7,8,9,А,Б,В,Г,Д,Е,Ё,Ж,З,И,Й,К,Л,М,Н,О,П,Р,С,Т,У,Ф,Х,Ц,Ч,Ш,Щ,Ъ,Ы,Ь,Э,Ю,Я,а,б,в,г,д,е,ё,ж,з,и,й,к,л,м,н,о,п,р,с,т,у,ф,х,ц,ч,ш,щ,ъ,ы,ь,э,ю,я}';
    result  text   := '';
    counter int    := 0;
BEGIN
    IF length < 0 THEN
        raise exception 'Длина строки не может быть меньше нуля';
    END IF;
    WHILE counter < length
        LOOP
            result := result || chars[1 + random() * (array_length(chars, 1) - 1)];
            counter := counter + 1;
        END LOOP;
    RETURN result;
END
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION insert_seats(hall int, rows_number int, seats_number int) RETURNS void AS
$$
BEGIN
    FOR current_row IN 1..rows_number
        LOOP
            FOR current_seat IN 1..seats_number
                LOOP
                    INSERT INTO seat (hall_id, row, seat) VALUES (hall, current_row, current_seat);
                END LOOP;
        END LOOP;
END
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION insert_movie(number_films int) RETURNS void AS
$$
BEGIN
    FOR movie_id IN 1..number_films
        LOOP
            INSERT INTO movie (id, premiere_date, name, description)
            VALUES (movie_id, get_random_timestamp(true), get_random_string(get_random_int(10, 30)), get_random_string(get_random_int(150, 300)));
        END LOOP;
END
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION insert_sessions(number_sessions int) RETURNS void AS
$$
DECLARE
    count_movie int := (SELECT max(id)
                        FROM movie);
    counter     int := 0;
    movie       int;
    movie_price int;
    start_date  timestamp;
    end_date    timestamp;
BEGIN
    WHILE counter < number_sessions
        LOOP
            movie := get_random_int(1, count_movie);
            movie_price := get_random_int(150, 300);
            start_date := get_random_timestamp();
            end_date := start_date + '2 hour';
            INSERT INTO session (movie_id, hall_id, price, start, "end")
            VALUES (movie, 1, movie_price, start_date, end_date);
            counter := counter + 1;
        END LOOP;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION insert_customers(number_customers int) RETURNS void AS
$$
BEGIN
    FOR customer_id IN 1..number_customers
        LOOP
            INSERT INTO customer (id, first_name, last_name)
            VALUES (customer_id, get_random_string(get_random_int(4, 10)), get_random_string(get_random_int(3, 15)));
        END LOOP;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION insert_tickets(number_tickets int) RETURNS void AS
$$
DECLARE
    count_sessions  int := (SELECT max(id)
                            FROM session);
    count_seats     int := (SELECT max(id)
                            FROM seat);
    count_customers int := (SELECT max(id)
                            from customer);
    counter         int := 0;
BEGIN
    WHILE counter < number_tickets
        LOOP
            INSERT INTO ticket (price, session_id, seat_id, customer_id)
            VALUES (get_random_int(150, 300),
                    get_random_int(1, count_sessions),
                    get_random_int(1, count_seats),
                    get_random_int(1, count_customers));
            counter := counter + 1;
        END LOOP;
END;
$$ LANGUAGE plpgsql;
