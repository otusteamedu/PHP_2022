-- Создаем БД для кинотеатров
CREATE
    DATABASE cinema;

-- Залы
-- title - название зала (мб, что-то поинтереснее, чем "Зал №1", "Зал №2" и тд)
CREATE TABLE halls
(
    id         BIGSERIAL PRIMARY KEY,
    title      VARCHAR(100) NOT NULL,
    created_at TIMESTAMP default CURRENT_TIMESTAMP
);

-- Посадочные места в зале
-- row - ряд
-- number - номер
-- hall_id - идентификатор зала
CREATE TABLE seats
(
    id      BIGSERIAL PRIMARY KEY,
    row     INT    NOT NULL,
    number  INT    NOT NULL,
    hall_id BIGINT NOT NULL,
    CONSTRAINT fk_hall
        FOREIGN KEY (hall_id)
            REFERENCES halls (id)
);

-- Фильмы
-- title - название фильма
-- director - режиссер
-- stars - звездный состав
-- description - описание
-- duration_min - продолжительность в минутах
-- release_data - дата релиза
-- is_active - идут ли сейчас показы
--
-- В принципе, половину полей можно было бы сделать необязательными, но реально же все эти данные
-- известны к премьере, нечего лениться, надо все заполнять.
CREATE TABLE films
(
    id           BIGSERIAL PRIMARY KEY,
    title        VARCHAR(300) NOT NULL,
    director     VARCHAR(200) NOT NULL,
    stars        text         NOT NULL,
    description  text         NOT NULL,
    duration_min int          NOT NULL,
    release_data TIMESTAMP    NOT NULL,
    is_active    BOOLEAN      NOT NULL,
    created_at   TIMESTAMP default CURRENT_TIMESTAMP
);

-- Сеансы
-- film_id - идентификатор фильма
-- hall_id - идентификатор зала
-- time_start - время начала сеанса
-- time_end - время окончание сеанса
-- Уникальный ключ по трем поля (film_id, hall_id, time_start), чтобы не было показов в одно время в одном зале
CREATE TABLE film_sessions
(
    id         BIGSERIAL PRIMARY KEY,
    film_id    BIGINT NOT NULL,
    hall_id    BIGINT NOT NULL,
    time_start TIME   NOT NULL,
    time_end   TIME   NOT NULL,
    CONSTRAINT fk_film
        FOREIGN KEY (film_id)
            REFERENCES films (id),
    CONSTRAINT fk_hall
        FOREIGN KEY (hall_id)
            REFERENCES halls (id),
    UNIQUE (film_id, hall_id, time_start)
);

-- Цены на посадочные места конкретного сеанса
-- film_session_id - идентификатор фильма
-- seat_id - идентификатор посадочного места
-- price - цена
-- уникальный ключ (film_session_id, seat_id) используется, чтобы не устанавливать дублировались цены на одни и те же
-- посадочные места в рамках одного сеанса
CREATE TABLE seat_session_price
(
    film_session_id BIGINT NOT NULL,
    seat_id         BIGINT NOT NULL,
    price           INT    NOT NULL,
    CONSTRAINT fk_film_session_id
        FOREIGN KEY (film_session_id)
            REFERENCES film_sessions (id),
    CONSTRAINT fk_seat_id
        FOREIGN KEY (seat_id)
            REFERENCES seats (id),
    UNIQUE (film_session_id, seat_id)

);

-- Зрители, т.е те, кто купил билет
-- mobile_phone - телефон
-- email - адрес почты
-- password - хэш пароля. Логином может быть телефон или email
-- first_name - имя
-- last_name - фамилия
-- is_active - активный или нет. Мало ли, может придется кого-то банить
CREATE TABLE clients
(
    id           BIGSERIAL PRIMARY KEY,
    mobile_phone VARCHAR(20)  NOT NULL UNIQUE,
    email        VARCHAR(200) UNIQUE,
    password     VARCHAR(200) NOT NULL,
    first_name   VARCHAR(100) NOT NULL,
    last_name    VARCHAR(100),
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active    BOOLEAN   DEFAULT TRUE,
    UNIQUE (mobile_phone),
    UNIQUE (email)
);

-- Билеты
-- film_session_id - идентификатор сеанса
-- client_id - идентификатор аккаунта зрителя
-- seat_id - идентификатор посадочного места
-- price - окончательная цена (после учета акций, скидок или каких-то модификаторов, которые могут быть в системе)
-- session_date - дата сеанса
-- Уникальный ключ (film_session, seat_id, session_date) используется, чтобы не было заказов на одно место на одном сеансе
CREATE TABLE tickets
(
    id              BIGSERIAL PRIMARY KEY,
    film_session_id BIGINT NOT NULL,
    client_id       BIGINT NOT NULL,
    seat_id         BIGINT NOT NULL,
    price           INT    NOT NULL,
    session_date    DATE   NOT NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (film_session_id, seat_id, session_date),
    CONSTRAINT fk_film_session
        FOREIGN KEY (film_session_id)
            REFERENCES film_sessions (id),
    CONSTRAINT fk_seat
        FOREIGN KEY (seat_id)
            REFERENCES seats (id),
    CONSTRAINT fk_client
        FOREIGN KEY (client_id)
            REFERENCES clients (id)
);

-- Заполняем данными
INSERT INTO halls (id, title, created_at)
VALUES (DEFAULT, 'Зал 1', DEFAULT);
INSERT INTO halls (id, title, created_at)
VALUES (DEFAULT, 'Зал 2', DEFAULT);
INSERT INTO halls (id, title, created_at)
VALUES (DEFAULT, 'Зал 3', DEFAULT);
INSERT INTO halls (id, title, created_at)
VALUES (DEFAULT, 'Зал 4', DEFAULT);
INSERT INTO halls (id, title, created_at)
VALUES (DEFAULT, 'Зал 5', DEFAULT);

INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 1, 1);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 2, 1);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 3, 1);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 4, 1);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 5, 1);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 1, 1);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 2, 1);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 3, 1);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 4, 1);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 5, 1);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 1, 2);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 2, 2);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 3, 2);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 4, 2);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 5, 2);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 1, 2);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 2, 2);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 3, 2);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 4, 2);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 5, 2);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 1, 3);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 2, 3);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 3, 3);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 4, 3);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 5, 3);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 1, 3);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 2, 3);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 3, 3);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 4, 3);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 5, 3);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 1, 4);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 2, 4);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 3, 4);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 4, 4);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 1, 5, 4);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 1, 4);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 2, 4);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 3, 4);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 4, 4);
INSERT INTO seats (id, row, number, hall_id)
VALUES (DEFAULT, 2, 5, 4);

INSERT INTO films (id, title, director, stars, description, duration_min, release_data, is_active, created_at)
VALUES (DEFAULT, 'Человек-Гадюк', 'Иванов', 'Иванов, Петров, Куценко', 'супер фильм', 120, '2022-11-23 00:07:30.000000',
        true, DEFAULT);
INSERT INTO films (id, title, director, stars, description, duration_min, release_data, is_active, created_at)
VALUES (DEFAULT, 'Зеленый пони', 'Агент Смит', 'Иванов, Петров, Куценко', 'супер фильм', 130,
        '2022-11-23 00:07:30.000000', true, DEFAULT);
INSERT INTO films (id, title, director, stars, description, duration_min, release_data, is_active, created_at)
VALUES (DEFAULT, 'Чистый Гарри', 'Павел Морозов', 'Иванов, Петров, Куценко', 'супер фильм', 140,
        '2022-11-23 00:07:30.000000', true, DEFAULT);
INSERT INTO films (id, title, director, stars, description, duration_min, release_data, is_active, created_at)
VALUES (DEFAULT, 'Полицейский из трущоб', 'Алена Апина', 'Иванов, Петров, Куценко', 'супер фильм', 111,
        '2022-11-23 00:07:30.000000', true, DEFAULT);
INSERT INTO films (id, title, director, stars, description, duration_min, release_data, is_active, created_at)
VALUES (DEFAULT, 'Фанаты с зеленой улицы разбитых фонарей', 'Тарантино', 'Иванов, Петров, Куценко', 'супер фильм', 129,
        '2022-11-23 00:07:30.000000', true, DEFAULT);

INSERT INTO film_sessions (id, film_id, hall_id, time_start, time_end)
VALUES (DEFAULT, 1, 1, '09:00:00', '11:00:00');
INSERT INTO film_sessions (id, film_id, hall_id, time_start, time_end)
VALUES (DEFAULT, 2, 1, '15:00:00', '17:00:00');
INSERT INTO film_sessions (id, film_id, hall_id, time_start, time_end)
VALUES (DEFAULT, 3, 1, '18:00:00', '20:00:00');
INSERT INTO film_sessions (id, film_id, hall_id, time_start, time_end)
VALUES (DEFAULT, 1, 2, '15:00:00', '17:00:00');
INSERT INTO film_sessions (id, film_id, hall_id, time_start, time_end)
VALUES (DEFAULT, 2, 2, '09:00:00', '11:00:00');
INSERT INTO film_sessions (id, film_id, hall_id, time_start, time_end)
VALUES (DEFAULT, 3, 2, '15:00:00', '17:00:00');
INSERT INTO film_sessions (id, film_id, hall_id, time_start, time_end)
VALUES (DEFAULT, 1, 3, '09:00:00', '11:00:00');

INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (1, 1, 1200);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (2, 2, 1100);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (3, 3, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (4, 4, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (5, 5, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (6, 6, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (7, 7, 2000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (1, 8, 1200);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (2, 9, 1100);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (3, 10, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (4, 11, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (5, 12, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (6, 13, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (7, 14, 2000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (1, 15, 1200);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (2, 16, 1100);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (3, 17, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (4, 18, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (5, 19, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (6, 20, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (7, 21, 2000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (1, 22, 1200);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (2, 23, 1100);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (3, 24, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (4, 25, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (5, 26, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (6, 27, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (7, 28, 2000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (1, 29, 1200);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (2, 30, 1100);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (3, 31, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (4, 32, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (5, 33, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (6, 34, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (7, 35, 2000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (1, 36, 1200);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (2, 37, 1100);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (3, 38, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (4, 39, 1000);
INSERT INTO seat_session_price (film_session_id, seat_id, price)
VALUES (5, 40, 1000);

INSERT INTO clients (id, mobile_phone, email, password, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '89858850000', 'test0@test.com', 'asdfasef', 'Джон', 'Иванов', DEFAULT, DEFAULT);
INSERT INTO clients (id, mobile_phone, email, password, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '89858850001', 'test1@test.com', 'asdfasef', 'Петр', 'Иванов', DEFAULT, DEFAULT);
INSERT INTO clients (id, mobile_phone, email, password, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '89858850002', 'test2@test.com', 'asdfasef', 'Квентин', 'Иванов', DEFAULT, DEFAULT);
INSERT INTO clients (id, mobile_phone, email, password, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '89858850003', 'test3@test.com', 'asdfasef', 'Жан', 'Иванов', DEFAULT, DEFAULT);
INSERT INTO clients (id, mobile_phone, email, password, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '89858850004', 'test4@test.com', 'asdfasef', 'Роман', 'Иванов', DEFAULT, DEFAULT);
INSERT INTO clients (id, mobile_phone, email, password, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '89858850005', 'test5@test.com', 'asdfasef', 'Бедрос', 'Иванов', DEFAULT, DEFAULT);
INSERT INTO clients (id, mobile_phone, email, password, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '89858850006', 'test6@test.com', 'asdfasef', 'Владлен', 'Иванов', DEFAULT, DEFAULT);
INSERT INTO clients (id, mobile_phone, email, password, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '89858850007', 'test7@test.com', 'asdfasef', 'Жорик', 'Иванов', DEFAULT, DEFAULT);
INSERT INTO clients (id, mobile_phone, email, password, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '89858850008', 'test8@test.com', 'asdfasef', 'Петро', 'Иванов', DEFAULT, DEFAULT);
INSERT INTO clients (id, mobile_phone, email, password, first_name, last_name, created_at, is_active) VALUES (DEFAULT, '89858850009', 'test9@test.com', 'asdfasef', 'Геворг', 'Иванов', DEFAULT, DEFAULT);


INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 1, 1, 1, 900, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 2, 2, 2, 2012, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 3, 3, 3, 2342, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 4, 4, 4, 333, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 5, 5, 5, 23, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 6, 5, 6, 555, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 7, 6, 7, 1000, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 1, 1, 8, 1000, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 2, 2, 9, 1000, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 3, 3, 10, 1000, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 4, 4, 11, 1000, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 5, 5, 12, 1000, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 6, 5, 13, 900, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 7, 6, 14, 2012, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 1, 1, 15, 2342, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 2, 2, 16, 333, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 3, 3, 17, 23, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 4, 4, 18, 555, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 5, 5, 19, 1000, '2022-11-26', DEFAULT);
INSERT INTO public.tickets (id, film_session_id, client_id, seat_id, price, session_date, created_at) VALUES (DEFAULT, 6, 5, 20, 1000, '2022-11-26', DEFAULT);