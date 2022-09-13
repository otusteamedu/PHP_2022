/* Добавляет фильмы */
CREATE OR REPLACE PROCEDURE insert_films()
    LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO film (name, duration) VALUES ('Иван Васильевич меняет профессию', 90),
                                             ('Зеленая миля', 130),
                                             ('Побег из Шоушенка', 120),
                                             ('Бриллиантовая рука', 95),
                                             ('Джентльмены удачи', 85),
                                             ('Москва слезам не верит', 150),
                                             ('Служебный роман', 100),
                                             ('Собачье сердце', 105),
                                             ('Начало', 125),
                                             ('Титаник', 140),
                                             ('Властелин колец: Возвращение короля', 155),
                                             ('Властелин колец: Две крепости', 135),
                                             ('Властелин колец: Братство кольца', 130);
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
END;
$$;

/* Добавляет отношения кинозалов и мест */
CREATE OR REPLACE PROCEDURE insert_cinema_hall_place_relations(IN count_rows INT, IN count_cols INT)
    LANGUAGE plpgsql
AS $$
DECLARE
    count_rows_cinema_hall INT;
    count_cols_cinema_hall INT;
    cinema_hall_id INT;
    place_id INT;
BEGIN
    FOR cinema_hall_id IN SELECT id FROM cinema_hall LOOP
        count_rows_cinema_hall := round(random() * count_rows);
        IF count_rows_cinema_hall = 0 THEN
            count_rows_cinema_hall := round(random() * count_rows);
        END IF;

        count_cols_cinema_hall := round(random() * count_cols);
        IF count_cols_cinema_hall = 0 THEN
            count_cols_cinema_hall := round(random() * count_cols);
        END IF;

        FOR place_id IN SELECT id FROM place WHERE row <= count_rows_cinema_hall AND col <= count_cols_cinema_hall LOOP
            INSERT INTO cinema_hall_place_relation (cinema_hall_id, place_id) VALUES (cinema_hall_id, place_id);
        END LOOP;
    END LOOP;
END;
$$;



DO $$
    DECLARE
        count_cinema_halls INT := 8; /* Количество кинозалов */
        count_rows INT := 20; /* Количество рядов */
        count_cols INT := 100; /* Количество мест в ряду */
    BEGIN
        CALL insert_films();
        CALL insert_cinema_halls(count_cinema_halls);
        CALL insert_places(count_rows, count_cols);
        CALL insert_cinema_hall_place_relations(count_rows, count_cols);


    END;
$$;
