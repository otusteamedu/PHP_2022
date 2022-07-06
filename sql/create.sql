-- Таблица "Фильм":
-- id - уникальный ID
-- name - имя фильма
-- date_premier - дата премьеры
-- description - описание фильма
-- duration - длительность (в мин)
-- price - базовая цена 1 билета, без учета конкретного сеанса, конкретного места
CREATE TABLE IF NOT EXISTS film (
    id serial PRIMARY KEY NOT NULL,
    name varchar(255) NOT NULL,
    date_premier date,
    description text,
    duration smallint NOT NULL,
    price decimal(6,2) NOT NULL CHECK (price > 0)
);

-- Таблица "Киноделы":
-- id - уникальный ID
-- surname - фамилия
-- name - имя
-- birthdate - дата рождения (может быть не заполнено)
-- description - текстовая информация о человеке
CREATE TABLE IF NOT EXISTS film_worker (
    id serial PRIMARY KEY NOT NULL,
    surname varchar(100) NOT NULL,
    name varchar(100) NOT NULL,
    birthdate date,
    description text
);

-- Перечисление, в котором содержится список киношных профессий: режиссер, актер, композитор, оператор, монтажер, сценарист
DO $$
    BEGIN
        IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_film_composition') THEN
            CREATE TYPE enum_film_composition AS ENUM ('director', 'actor', 'composer', 'cameraman', 'editor', 'screenwriter');
        END IF;
    END
$$;

-- Таблица связи фильма и кинодела:
-- film_id - ID фильма
-- film_worker_id - ID кинодела
-- type - перечисление кем был кинодел, в этом фильме
CREATE TABLE IF NOT EXISTS film_composition (
    film_id integer NOT NULL,
    film_worker_id integer NOT NULL,
    type enum_film_composition NOT NULL DEFAULT 'actor',
    FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE,
    FOREIGN KEY (film_worker_id) REFERENCES film_worker (id) ON DELETE CASCADE
);

-- Таблица "Зал":
-- id - уникальный ID
-- name - название зала
-- vip - признак вип-зал или нет
CREATE TABLE IF NOT EXISTS hall (
    id serial PRIMARY KEY NOT NULL,
    name varchar(100) NOT NULL,
    vip boolean DEFAULT false
);

-- Таблица "Место":
-- id - уникальный ID
-- hall_id - ID зала
-- row - ряд
-- seat - место
-- price_ratio - коэффициент цены (в зависимости от места базовая цена фильма может быть больше или меньше)
CREATE TABLE IF NOT EXISTS place (
    id serial PRIMARY KEY NOT NULL,
    hall_id integer NOT NULL,
    row smallint NOT NULL,
    seat smallint NOT NULL,
    price_ratio decimal(2,1) NOT NULL default 1.0,
    FOREIGN KEY (hall_id) REFERENCES hall (id) ON DELETE CASCADE,
    unique (hall_id, row, seat)
);

-- Таблица "Сеанс":
-- id - уникальный ID
-- hall_id - ID зала
-- film_id - ID фильма
-- start_timestamp - время начала сеанса
-- end_timestamp - время конца сеанса (не используем продолжительность фильма на случай доп. рекламных роликов или, например, творческой встречи перед просмотром)
-- price_ratio - коэффициент цены (в зависимости от сеанса базовая цена фильма может быть больше или меньше, например, утренний сеанс дешевле вечернего)
CREATE TABLE IF NOT EXISTS session (
    id serial PRIMARY KEY NOT NULL,
    hall_id integer NOT NULL,
    film_id integer NOT NULL,
    start_timestamp timestamp NOT NULL,
    end_timestamp timestamp NOT NULL,
    price_ratio decimal(2,1) NOT NULL default 1.0,
    FOREIGN KEY (hall_id) REFERENCES hall (id) ON DELETE CASCADE,
    FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE,
    unique (hall_id, film_id, start_timestamp)
);

-- Таблица "Покупатель":
-- id - уникальный ID
-- surname - фамилия
-- name - имя
-- phone - телефон
-- email - email-адрес
CREATE TABLE IF NOT EXISTS customer (
    id serial PRIMARY KEY NOT NULL,
    surname varchar(100) NOT NULL,
    name varchar(100) NOT NULL,
    phone varchar(20) NOT NULL UNIQUE,
    email varchar(100) NOT NULL UNIQUE
);

-- Таблица "Способ покупки":
-- id - уникальный ID
-- name - название
CREATE TABLE IF NOT EXISTS purchase_method (
    id smallserial PRIMARY KEY NOT NULL,
    name varchar(100) NOT NULL
);

-- Перечисление, в котором содержится список статусов заказа: не оплачен, оплачен, отменен (для аналитики заказов в будущем)
DO $$
    BEGIN
        IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_status_order') THEN
            CREATE TYPE enum_status_order AS ENUM ('not paid', 'paid', 'canceled');
        END IF;
    END
$$;

-- Таблица "Заказы":
-- id - уникальный ID
-- customer_id - ID покупателя (может быть пустым, если был удален покупатель, но удалять билет нельзя, особенно оплаченный из-за статистики или приобретение было офлайн)
-- purchase_method_id - место покупки (может быть пустым, если был удален способ покупки, а билеты и заказы удалять не можем)
-- date_create - дата заказа
-- status - статус заказа
CREATE TABLE IF NOT EXISTS orders (
    id serial PRIMARY KEY NOT NULL,
    customer_id integer DEFAULT NULL,
    purchase_method_id smallint,
    date_create timestamp NOT NULL,
    status enum_status_order NOT NULL DEFAULT 'not paid',
    FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE SET NULL,
    FOREIGN KEY (purchase_method_id) REFERENCES purchase_method (id) ON DELETE SET NULL
);

-- Таблица "Билеты":
-- id - уникальный ID
-- order_id - ID заказа (в одном заказе может быть много билетов)
-- session_id - ID сеанса
-- place_id - ID места
-- price - цена билета - итоговая цена из базовой цены * на коэффициент цены места * на коэффициент цены сеанса, фиксируем на случай, если покупатель приобрел билет, а ценовая составляющая изменилась и пдсчет налету не даст нам корректного значения
-- active - определение действующий билет или нет. Ориентироваться на статус заказа нельзя, т.к. по какой-то причине в заказе часть билетов может быть оплачена, часть - нет. А неоплаченные билеты хотим сохранить для сбора статистики/аналитики
CREATE TABLE IF NOT EXISTS tickets (
    id serial PRIMARY KEY NOT NULL,
    order_id integer NOT NULL,
    session_id integer,
    place_id integer,
    price decimal(6,2) NOT NULL CHECK (price > 0),
    active boolean DEFAULT false,
    FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE,
    FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE SET NULL,
    FOREIGN KEY (place_id) REFERENCES place (id) ON DELETE SET NULL,
    unique (session_id, place_id)
);