-- Создаем БД для кинотеатров
CREATE
DATABASE cinema;

-- Залы
CREATE TABLE halls
(
    id         BIGSERIAL PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    created_at TIMESTAMP default CURRENT_TIMESTAMP
);

-- Фильмы
CREATE TABLE films
(
    id           BIGSERIAL PRIMARY KEY,
    name         VARCHAR(200) NOT NULL,
    release_data TIMESTAMP    NOT NULL,
    is_active    BOOLEAN      NOT NULL,
    created_at   TIMESTAMP default CURRENT_TIMESTAMP
);

-- Сеансы
CREATE TABLE film_sessions
(
    id         BIGSERIAL PRIMARY KEY,
    film_id    BIGINT    NOT NULL,
    hall_id    BIGINT    NOT NULL,
    time_from  TIME NOT NULL,
    time_to    TIME NOT NULL,
    date_start DATE      NOT NULL,
    date_end   DATE      NOT NULL,
    CONSTRAINT fk_film
        FOREIGN KEY (film_id)
            REFERENCES films (id),
    CONSTRAINT fk_hall
        FOREIGN KEY (hall_id)
            REFERENCES halls (id),
    UNIQUE (film_id, hall_id, time_from, time_to, date_start, date_end)
);

-- Цены на сеансы на конкретные посадочные места
CREATE TABLE session_prices
(
    id               BIGSERIAL PRIMARY KEY,
    session_id       BIGINT NOT NULL,
    seat_range_start INT    NOT NULL,
    seat_range_end   INT    NOT NULL,
    price            INT    NOT NULL,
    CONSTRAINT fk_session
        FOREIGN KEY (session_id)
            REFERENCES film_sessions (id)
);

-- Зрители, т.е те, кто купил билет
CREATE TABLE clients
(
    id           BIGSERIAL PRIMARY KEY,
    mobile_phone VARCHAR(20)  NOT NULL UNIQUE,
    email        VARCHAR(200) UNIQUE,
    first_name   VARCHAR(100) NOT NULL,
    last_name    VARCHAR(100),
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active    BOOLEAN   DEFAULT TRUE
);

-- Билеты
CREATE TABLE tickets
(
    id               BIGSERIAL PRIMARY KEY,
    session_price_id BIGINT NOT NULL,
    client_id        BIGINT NOT NULL,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_session_price
        FOREIGN KEY (session_price_id)
            REFERENCES session_prices (id),
    CONSTRAINT fk_client
        FOREIGN KEY (client_id)
            REFERENCES clients (id)
);

-- Заполняем данныеми
INSERT INTO halls (id, name, created_at) VALUES (DEFAULT, 'Зал 1', DEFAULT)
INSERT INTO halls (id, name, created_at) VALUES (DEFAULT, 'Зал 2', DEFAULT)
INSERT INTO halls (id, name, created_at) VALUES (DEFAULT, 'Зал 3', DEFAULT)
INSERT INTO halls (id, name, created_at) VALUES (DEFAULT, 'Зал 4', DEFAULT)
INSERT INTO halls (id, name, created_at) VALUES (DEFAULT, 'Зал 5', DEFAULT)

INSERT INTO films (id, name, release_data, is_active, created_at) VALUES (DEFAULT, 'Человек-Гадюк', '2022-11-17 10:48:11.000000', true, DEFAULT)
INSERT INTO films (id, name, release_data, is_active, created_at) VALUES (DEFAULT, 'Зеленый пони', '2022-07-12 10:48:16.000000', true, DEFAULT)
INSERT INTO films (id, name, release_data, is_active, created_at) VALUES (DEFAULT, 'Чистый Гарри', '2022-08-30 10:49:05.000000', true, DEFAULT)
INSERT INTO films (id, name, release_data, is_active, created_at) VALUES (DEFAULT, 'Полицейский из трущоб', '2022-02-02 10:49:11.000000', true, DEFAULT)
INSERT INTO films (id, name, release_data, is_active, created_at) VALUES (DEFAULT, 'Фанаты с зеленой улицы разбитых фонарей', '2022-03-03 10:49:19.000000', true, DEFAULT)

INSERT INTO film_sessions (id, film_id, hall_id, time_from, time_to, date_start, date_end) VALUES (DEFAULT, 1, 1, '09:00:00', '11:00:00', '2022-11-24', '2022-12-31')
INSERT INTO film_sessions (id, film_id, hall_id, time_from, time_to, date_start, date_end) VALUES (DEFAULT, 2, 1, '15:00:00', '17:00:00', '2022-11-24', '2022-12-31')
INSERT INTO film_sessions (id, film_id, hall_id, time_from, time_to, date_start, date_end) VALUES (DEFAULT, 3, 1, '18:00:00', '20:00:00', '2022-11-24', '2022-12-31')
INSERT INTO film_sessions (id, film_id, hall_id, time_from, time_to, date_start, date_end) VALUES (DEFAULT, 1, 2, '15:00:00', '17:00:00', '2022-11-24', '2022-12-31')
INSERT INTO film_sessions (id, film_id, hall_id, time_from, time_to, date_start, date_end) VALUES (DEFAULT, 2, 2, '09:00:00', '11:00:00', '2022-11-24', '2022-12-31')
INSERT INTO film_sessions (id, film_id, hall_id, time_from, time_to, date_start, date_end) VALUES (DEFAULT, 3, 2, '15:00:00', '17:00:00', '2022-11-24', '2022-12-31')
INSERT INTO film_sessions (id, film_id, hall_id, time_from, time_to, date_start, date_end) VALUES (DEFAULT, 1, 3, '09:00:00', '11:00:00', '2022-11-24', '2022-12-31')

INSERT INTO session_prices (id, session_id, seat_range_start, seat_range_end, price) VALUES (DEFAULT, 1, 1, 10, 1210)
INSERT INTO session_prices (id, session_id, seat_range_start, seat_range_end, price) VALUES (DEFAULT, 2, 1, 10, 3200)
INSERT INTO session_prices (id, session_id, seat_range_start, seat_range_end, price) VALUES (DEFAULT, 3, 1, 10, 2000)
INSERT INTO session_prices (id, session_id, seat_range_start, seat_range_end, price) VALUES (DEFAULT, 4, 1, 10, 1000)
INSERT INTO session_prices (id, session_id, seat_range_start, seat_range_end, price) VALUES (DEFAULT, 5, 1, 10, 1000)
INSERT INTO session_prices (id, session_id, seat_range_start, seat_range_end, price) VALUES (DEFAULT, 6, 1, 10, 1000)
INSERT INTO session_prices (id, session_id, seat_range_start, seat_range_end, price) VALUES (DEFAULT, 7, 1, 10, 1000)
INSERT INTO session_prices (id, session_id, seat_range_start, seat_range_end, price) VALUES (DEFAULT, 1, 11, 20, 2210)
INSERT INTO session_prices (id, session_id, seat_range_start, seat_range_end, price) VALUES (DEFAULT, 2, 11, 20, 4200)
INSERT INTO session_prices (id, session_id, seat_range_start, seat_range_end, price) VALUES (DEFAULT, 3, 11, 20, 3000)
INSERT INTO session_prices (id, session_id, seat_range_start, seat_range_end, price) VALUES (DEFAULT, 4, 11, 20, 2000)
INSERT INTO session_prices (id, session_id, seat_range_start, seat_range_end, price) VALUES (DEFAULT, 5, 11, 20, 2000)
INSERT INTO session_prices (id, session_id, seat_range_start, seat_range_end, price) VALUES (DEFAULT, 6, 11, 20, 2000)
INSERT INTO session_prices (id, session_id, seat_range_start, seat_range_end, price) VALUES (DEFAULT, 7, 11, 20, 2000)

INSERT INTO clients (id, mobile_phone, email, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '79858801111', 'test1@gmail.com', 'Вася', 'Круглов', DEFAULT, DEFAULT)
INSERT INTO clients (id, mobile_phone, email, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '79858801112', 'test2@gmail.com', 'Дима', 'Квадратов', DEFAULT, DEFAULT)
INSERT INTO clients (id, mobile_phone, email, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '79858801113', 'test3@gmail.com', 'Петро', 'Ромбов', DEFAULT, DEFAULT)
INSERT INTO clients (id, mobile_phone, email, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '79858801114', 'test4@gmail.com', 'Ежи', 'Шаров', DEFAULT, DEFAULT)
INSERT INTO clients (id, mobile_phone, email, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '79858801115', 'test5@gmail.com', 'Карл', null, DEFAULT, DEFAULT)
INSERT INTO clients (id, mobile_phone, email, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '79858801116', 'test6@gmail.com', 'Карл!!!', null, DEFAULT, DEFAULT)

INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 1, 1, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 1, 2, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 1, 3, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 1, 4, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 2, 5, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 2, 6, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 2, 1, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 2, 2, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 3, 3, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 3, 4, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 3, 5, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 5, 6, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 6, 1, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 7, 2, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 8, 3, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 9, 4, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 10, 5, DEFAULT)
INSERT INTO tickets (id, session_price_id, client_id, created_at) VALUES (DEFAULT, 11, 6, DEFAULT)


