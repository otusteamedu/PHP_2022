START TRANSACTION;
-- Справочник фильмов. --
CREATE TABLE movies
(
    id SERIAL NOT NULL,
    title VARCHAR(255) NOT NULL CHECK (title != ''),
    PRIMARY KEY(id)
);
COMMENT ON TABLE movies IS 'Справочник фильмов.';
COMMENT ON COLUMN movies.id IS 'Идентификатор.';
COMMENT ON COLUMN movies.title IS 'Название.';

-- Кинозалы. --
CREATE TABLE halls
(
    id SERIAL NOT NULL,
    title VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);
CREATE UNIQUE INDEX unique_idx_hall_title ON halls (title);

COMMENT ON TABLE halls IS 'Кинозалы.';
COMMENT ON COLUMN halls.id IS 'Идентификатор.';
COMMENT ON COLUMN halls.title IS 'Название.';

-- Места в кинозалах. --
CREATE TABLE halls_places
(
    id SERIAL NOT NULL,
    hall_id SMALLINT NOT NULL,
    row SMALLINT NOT NULL CHECK (row > 0),
    place SMALLINT NOT NULL CHECK (place > 0),
    PRIMARY KEY(id),
    CONSTRAINT fk_halls_places_hall_id
        FOREIGN KEY(hall_id)
            REFERENCES halls(id)
            DEFERRABLE INITIALLY IMMEDIATE
);
CREATE UNIQUE INDEX unique_idx_hall_place ON halls_places (hall_id, row, place);

COMMENT ON TABLE halls_places IS 'Места в зале.';
COMMENT ON COLUMN halls_places.id IS 'Идентификатор.';
COMMENT ON COLUMN halls_places.hall_id IS 'Идентификатор зала.';
COMMENT ON COLUMN halls_places.row IS 'Ряд.';
COMMENT ON COLUMN halls_places.place IS 'Номер места.';

-- Сеансы фильмов в кинозалах. --
CREATE TABLE sessions
(
    id SERIAL NOT NULL,
    movie_id SMALLINT NOT NULL,
    hall_id SMALLINT NOT NULL,
    start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    price INT NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT fk_session_movie_id
        FOREIGN KEY(movie_id)
            REFERENCES movies(id)
            DEFERRABLE INITIALLY IMMEDIATE,
    CONSTRAINT fk_session_hall_id
        FOREIGN KEY(hall_id)
            REFERENCES halls(id)
            DEFERRABLE INITIALLY IMMEDIATE
);
COMMENT ON TABLE sessions IS 'Сеансы фильмов в кинозалах.';
COMMENT ON COLUMN sessions.id IS 'Идентификатор.';
COMMENT ON COLUMN sessions.movie_id IS 'Идентификатор фильма.';
COMMENT ON COLUMN sessions.hall_id IS 'Идентификатор кинозала.';
COMMENT ON COLUMN sessions.start_at IS 'Дата и время начала.';
COMMENT ON COLUMN sessions.price IS 'Цена на сеанс.';

-- Билеты в кино. --
CREATE TABLE tickets
(
    id SERIAL NOT NULL,
    session_id INT NOT NULL,
    hall_place_id INT NOT NULL,
    price INT,
    PRIMARY KEY(id),
    CONSTRAINT fk_ticket_session_id
        FOREIGN KEY(session_id)
            REFERENCES sessions(id)
            DEFERRABLE INITIALLY IMMEDIATE,
    CONSTRAINT fk_ticket_hall_place_id
        FOREIGN KEY(hall_place_id)
            REFERENCES halls_places(id)
            DEFERRABLE INITIALLY IMMEDIATE
);

COMMENT ON TABLE tickets IS 'Билеты в кино.';
COMMENT ON COLUMN tickets.id IS 'Идентификатор.';
COMMENT ON COLUMN tickets.session_id IS 'Идентификатор сеанса.';
COMMENT ON COLUMN tickets.hall_place_id IS 'Идентификатор места.';
COMMENT ON COLUMN tickets.price IS 'Стоимость.';

-- FUNCTIONS/VIEWS --
CREATE OR REPLACE FUNCTION generate_places(hall_title VARCHAR(255), rows_count INT, place_count INT) RETURNS VOID AS $$
DECLARE
    hall_identity SMALLINT;
BEGIN
    hall_identity = (SELECT id FROM halls WHERE title = hall_title);

    FOR row IN 1..rows_count LOOP
        FOR place IN 1..place_count LOOP
                INSERT INTO halls_places (hall_id, row, place) VALUES (hall_identity, row, place);
            END LOOP;
    END LOOP;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION generate_places IS 'Генерация мест в кинозалы.';

CREATE OR REPLACE FUNCTION create_session(
    movie_title TEXT,
    hall_title TEXT,
    session_start TIMESTAMP WITHOUT TIME ZONE,
    ticket_price INT
) RETURNS SMALLINT AS $$
DECLARE
    identity SMALLINT;
    movie_identity SMALLINT;
    hall_identity SMALLINT;
BEGIN
    movie_identity = (SELECT id FROM movies WHERE title = movie_title);
    hall_identity = (SELECT id FROM halls WHERE title = hall_title);

    INSERT INTO sessions (movie_id, hall_id, start_at, price)
    VALUES (movie_identity, hall_identity, session_start, ticket_price)
    RETURNING id INTO identity;

    RETURN identity;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION create_session IS 'Создание сеанса в кинозал.';

CREATE OR REPLACE FUNCTION generate_tickets(
    movie_title TEXT,
    hall_title TEXT,
    session_start TIMESTAMP WITHOUT TIME ZONE,
    ticket_price INT
) RETURNS VOID AS $$
DECLARE
    movie_identity SMALLINT;
    hall_identity SMALLINT;
    session_identity SMALLINT;
BEGIN
    movie_identity = (SELECT id FROM movies WHERE title = movie_title);
    hall_identity = (SELECT id FROM halls WHERE title = hall_title);
    session_identity = (
        SELECT id
        FROM sessions
        WHERE movie_id = movie_identity AND
                hall_id = hall_identity AND
                start_at = session_start
    );

    IF (session_identity IS NULL) THEN
        session_identity = (SELECT create_session(movie_title, hall_title, session_start, ticket_price));
    END IF;



    INSERT INTO tickets (session_id, hall_place_id)
    SELECT session_identity, src.id
    FROM halls_places AS src
    WHERE src.hall_id = hall_identity;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION generate_tickets IS 'Генерация билетов в кинозал.';

CREATE OR REPLACE FUNCTION buy_ticket(
    movie_title TEXT,
    hall_title TEXT,
    row_number INT,
    place_number INT,
    session_start TIMESTAMP WITHOUT TIME ZONE,
    ticket_price INT = NULL
) RETURNS VOID AS $$
DECLARE
    movie_identity SMALLINT;
    hall_identity SMALLINT;
    session_identity SMALLINT;
    hall_place_identity SMALLINT;
BEGIN
    movie_identity = (SELECT id FROM movies WHERE title = movie_title);
    hall_identity = (SELECT id FROM halls WHERE title = hall_title);
    hall_place_identity = (
        SELECT hp.id
        FROM halls_places AS hp
        WHERE hp.hall_id = hall_identity AND hp.row = row_number AND hp.place = place_number
    );
    session_identity = (
        SELECT s.id
        FROM sessions AS s
        WHERE s.movie_id = movie_identity AND s.hall_id = hall_identity AND s.start_at = session_start
    );

    IF (ticket_price IS NULL) THEN
        ticket_price = (SELECT s.price FROM sessions AS s WHERE s.id = session_identity);
    END IF;

    UPDATE tickets
    SET price = ticket_price
    WHERE session_id = session_identity AND hall_place_id = hall_place_identity;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION buy_ticket IS 'Купить билет на фильм в кинозале.';

CREATE OR REPLACE VIEW top_grossing_movies AS
SELECT m.id, m.title, sum(t.price) AS profit
FROM tickets AS t
    LEFT JOIN sessions AS s ON t.session_id = s.id
    LEFT JOIN movies AS m ON s.movie_id = m.id
WHERE t.price IS NOT NULL
GROUP BY m.id, m.title
ORDER BY profit DESC;
COMMENT ON VIEW top_grossing_movies IS 'Рейтинг кассовых фильмов.';

-- DATASETS --
INSERT INTO movies (title)
VALUES ('Аватар'),
       ('Мстители: Финал'),
       ('Титаник'),
       ('Челюсти. Столкновение'),
       ('Выживший')
;

INSERT INTO halls(title)
VALUES ('Основной'),
       ('Малый'),
       ('Большой');

-- Генерация мест в залах --
----------------------- 5 рядов по 4 места. ------------------------------
SELECT generate_places('Основной', 5, 4); --
--------------------------------------------------------------------------
----------------------- 3 ряда по 3 места. -------------------------------
SELECT generate_places('Малый', 3, 3); -----
--------------------------------------------------------------------------
----------------------- 6 рядов по 10 мест. ------------------------------
SELECT generate_places('Большой', 6, 10); --
--------------------------------------------------------------------------

-- Генерация сеансов в залах --
SELECT create_session('Титаник', 'Основной', '2023-01-01 12:00:00', 500); --

-- Генерация билетов и если нужно сеансов --
SELECT generate_tickets('Титаник', 'Основной', '2023-01-01 12:00:00', 500);
SELECT generate_tickets('Аватар', 'Малый', '2023-01-01 12:00:00', 300);
SELECT generate_tickets('Выживший', 'Большой', '2023-01-01 12:00:00', 200);
-----------------------------------------------------------------------------------------------------------------------

-- Купили билеты -------------------------------------------------------------------------
-- В "Основной" зал на фильм Титаник - 5 билетов x 500 = 2500 ----------------------------
SELECT buy_ticket('Титаник', 'Основной', 1, 2, '2023-01-01 12:00:00');
SELECT buy_ticket('Титаник', 'Основной', 1, 2, '2023-01-01 12:00:00');
SELECT buy_ticket('Титаник', 'Основной', 1, 3, '2023-01-01 12:00:00');
SELECT buy_ticket('Титаник', 'Основной', 1, 4, '2023-01-01 12:00:00');
SELECT buy_ticket('Титаник', 'Основной', 2, 1, '2023-01-01 12:00:00');
-- В "Малый" зал на фильм Аватар - 9 билетов x 300 = 2700 --------------------------------
SELECT buy_ticket('Аватар', 'Малый', 1, 1, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 1, 2, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 1, 3, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 2, 1, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 2, 2, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 2, 3, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 3, 1, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 3, 2, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 3, 3, '2023-01-01 12:00:00');
-- В "Большой" зал на фильм Выживший - (13 билетов x 200) + 1 билет за 50 = 2650 ---------------------------
SELECT buy_ticket('Выживший', 'Большой', 1, 1, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 2, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 3, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 4, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 5, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 6, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 7, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 8, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 9, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 10, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 2, 1, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 2, 2, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 2, 3, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 2, 4, '2023-01-01 12:00:00', 50);
COMMIT TRANSACTION;

-- Результат. --
SELECT title = 'Аватар' AS is_expected FROM top_grossing_movies LIMIT 1;
