-- функция генерации строк
CREATE OR REPLACE FUNCTION generate_string(length integer)  RETURNS TEXT AS
$$
    DECLARE
        chars text[] := '{0,1,2,3,4,5,6,7,8,9,А,Б,В,Г,Д,Е,Ё,Ж,З,И,Й,К,Л,М,Н,О,П,Р,С,Т,У,Ф,Х,Ц,Ч,Ш,Щ,Ъ,Ы,Ь,Э,Ю,Я,а,б,в,г,д,е,ё,ж,з,и,й,к,л,м,н,о,п,р,с,т,у,ф,х,ц,ч,ш,щ,ъ,ы,ь,э,ю,я}';
        result text := '';
    BEGIN
        IF length < 0 THEN
            raise exception 'Given length cannot be less than 0';
        END IF;
        FOR i in 1..length LOOP
                result := result || chars[1+random()*(array_length(chars, 1)-1)];
            END LOOP;
        RETURN result;
    END;
$$ language plpgsql;

-- функция генерации названий фильмов
CREATE OR REPLACE FUNCTION generate_film_name() RETURNS text AS
$$
DECLARE
    string1 text[] := array['Боль', 'Успех', 'Смысл', 'Радость', 'Приобретение', 'Счастье', 'Сумрак', 'Восход', 'Рассвет', 'Закат', 'Цветы', 'Пустыня', 'Море', 'Океан', 'Река', 'Боги', 'Ад', 'Рай'];
    string2 text[] := array['жизни', 'человека', 'утраты', 'других', 'присутствия', 'приобретения', 'на Земле', 'на Луне', 'на Марсе', 'на Венере', 'на Юпитере', 'на Нибиру', 'на Нептуне'];
BEGIN
    RETURN (string1::text[])[ceil(random()*array_length(string1::text[], 1))]
        || ' ' || (string2::text[])[ceil(random()*array_length(string2::text[], 1))]
        || ' (' || generate_string(10) || ')';
END
$$ language plpgsql;

-- функция генерации дат
CREATE OR REPLACE FUNCTION generate_timestamp() RETURNS timestamp AS
$$
BEGIN
    IF random() < 0.5 THEN
        RETURN now() - random() * (interval '181 days');
    END IF;
    RETURN now() + random() * (interval '184 days');
END
$$ language plpgsql;

-- функция генерации чисел указанного диапазон
CREATE OR REPLACE FUNCTION generate_int_to_range(low integer, high integer) RETURNS integer AS
$$
BEGIN
    RETURN floor(random() * (high - low) + low);
END
$$ language plpgsql;

-- Заполнение таблицы фильмов
DO
$$
    BEGIN
        FOR i IN 1..1000000 LOOP
            INSERT INTO film (name,date_premier,description,duration,price)
            VALUES (generate_film_name(), generate_timestamp()::date, generate_string((random() * 1000)::integer), generate_int_to_range(60, 250), generate_int_to_range(100, 500));
        END LOOP;
    END;
$$;

-- Заполнение таблицы киношников
DO
$$
    BEGIN
        FOR i IN 1..1000000 LOOP
                INSERT INTO film_worker (surname, name)
                VALUES (generate_string(10), generate_string(8));
            END LOOP;
    END;
$$;

-- Заполнение таблицы связки фильма и киношника
DO
$$
    DECLARE
        count_films integer := (SELECT COUNT(*) FROM film);
        count_worker integer := (SELECT COUNT(*) FROM film_worker);
        type_worker text;
    BEGIN
        FOR i IN 1..1000000 LOOP
            IF (random() < 0.8)
                THEN type_worker := 'actor';
                ELSE type_worker := 'director';
            END IF;
            INSERT INTO film_composition (film_id, film_worker_id, type)
            VALUES (generate_int_to_range(1, count_films), generate_int_to_range(1, count_worker), type_worker::enum_film_composition);
        END LOOP;
    END;
$$;

-- Заполнение таблицы залов (взято из прошлого ДЗ)
INSERT INTO hall(name) VALUES ('Большой стандартный зал');
INSERT INTO hall(name) VALUES ('Малый стандартный зал');
INSERT INTO hall(name, vip) VALUES ('VIP-зал', true);

-- Заполнение таблицы мест (взято из прошлого ДЗ)
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 1, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 2, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 3, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 4, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 5, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 6, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 7, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 8, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 9, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 1, 10, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 1, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 2, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 3, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 4, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 5, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 6, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 7, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 8, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 9, 0.9);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (1, 2, 10, 0.9);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 1);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 2);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 3);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 4);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 5);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 6);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 7);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 8);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 9);
INSERT INTO place(hall_id, row, seat) VALUES (1, 3, 10);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 1);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 2);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 3);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 4);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 5);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 6);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 7);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 8);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 9);
INSERT INTO place(hall_id, row, seat) VALUES (1, 4, 10);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 1, 1, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 1, 2, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 1, 3, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 1, 4, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 2, 1, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 2, 2, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 2, 3, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 2, 4, 1.1);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 3, 1, 1.2);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 3, 2, 1.2);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 3, 3, 1.2);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 3, 4, 1.2);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 4, 1, 1.5);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 4, 2, 1.5);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 4, 3, 1.5);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (2, 4, 4, 1.5);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (3, 1, 1, 2);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (3, 1, 2, 2);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (3, 2, 1, 2);
INSERT INTO place(hall_id, row, seat, price_ratio) VALUES (3, 2, 2, 2);

-- Заполнение таблицы сеансов
DO
$$
    DECLARE
        count_films integer := (SELECT COUNT(*) FROM film);
        count_hall integer := (SELECT COUNT(*) FROM hall);
        hall integer;
        film integer;
        start timestamp;
        count_loop integer := 0;
    BEGIN
        WHILE count_loop < 1000000 LOOP
                hall := generate_int_to_range(1, count_hall);
                film := generate_int_to_range(1, count_films);
                start := generate_timestamp();

                IF (SELECT COUNT(*) FROM session WHERE session.hall_id = hall AND session.film_id = film  AND session.start_timestamp = start)  != 0
                    THEN CONTINUE;
                END IF;

            INSERT INTO session (hall_id, film_id, start_timestamp, end_timestamp, price_ratio)
                VALUES (hall, film, start, start  + (interval '90 minutes'), round((random() + 0.5)::numeric, 1));

            count_loop = count_loop + 1;
        END LOOP;
    END;
$$;

-- Заполнение таблицы мест (взято из прошлого ДЗ)
INSERT INTO customer(surname, name, phone, email) VALUES ('Иванов', 'Иван', '+7 (900) 111-11-11', '111@email.com');
INSERT INTO customer(surname, name, phone, email) VALUES ('Петрова', 'Мария', '+7 (900) 222-22-22', '222@email.com');
INSERT INTO customer(surname, name, phone, email) VALUES ('Арбузова', 'Виктория', '+7 (900) 333-33-33', '333@email.com');
INSERT INTO customer(surname, name, phone, email) VALUES ('Сидоров', 'Аркадий', '+7 (900) 444-44-44', '444@email.com');
INSERT INTO customer(surname, name, phone, email) VALUES ('Пронченко', 'Зинаида', '+7 (900) 555-55-55', '555@email.com');

-- Заполнение таблицы мест (взято из прошлого ДЗ)
INSERT INTO purchase_method(name) VALUES ('веб-сайт'), ('касса в кинотеатре'), ('терминал в кинотеатре');

-- Заполнение таблицы заказов
DO
$$
    DECLARE
        count_purchase integer := (SELECT COUNT(*) FROM purchase_method);
        status text;
    BEGIN
        FOR i IN 1..1000000 LOOP
                IF (random() < 0.5)
                    THEN status := 'not paid';
                    ELSE
                        IF (random() > 0.5)
                            THEN status := 'paid';
                            ELSE status := 'canceled';
                        END IF;
                END IF;
                INSERT INTO orders (date_create, purchase_method_id, status)
                VALUES (generate_timestamp(), generate_int_to_range(1, count_purchase), status::enum_status_order);
            END LOOP;
    END;
$$;

-- Заполнение таблицы билетов
DO
$$
    DECLARE
        count_order integer := (SELECT COUNT(*) FROM orders);
        count_session integer := (SELECT COUNT(*) FROM session);
        count_place integer := (SELECT COUNT(*) FROM place);
        session integer;
        place integer;
        count_loop integer := 0;
    BEGIN
        WHILE count_loop < 1000000 LOOP
                session := generate_int_to_range(1, count_session);
                place := generate_int_to_range(1, count_place);
                IF (SELECT COUNT(*) FROM tickets WHERE tickets.session_id = session AND tickets.place_id = place)  != 0
                    THEN CONTINUE;
                END IF;

                INSERT INTO tickets (order_id, session_id, place_id, price, active)
                VALUES (generate_int_to_range(1, count_order), session, place, generate_int_to_range(100, 500), random() < 0.7);

                count_loop := count_loop + 1;
            END LOOP;
    END;
$$;