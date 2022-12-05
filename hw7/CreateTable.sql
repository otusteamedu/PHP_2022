// Создание таблицы фильмов.
CREATE TABLE films
(
    id integer NOT NULL INCREMENT,      -- Идентификатор фильма
    name character varying(200),        -- Название фильма
    description character varying(400), -- Описание фильмы
    CONSTRAINT film_pkey PRIMARY KEY (id)
)

// Создание таблицы цен.
CREATE TABLE pricelist
(
    id integer NOT NULL INCREMENT, -- Идентификатор цены
    price integer,                 -- Цена
    CONSTRAINT price_pkey PRIMARY KEY (id)
)

// Создание таблицы залов.
CREATE TABLE hall
(
    id integer NOT NULL INCREMENT,       -- Идентификатор зала
    count_row integer NOT NULL,          -- Количество рядов
    CONSTRAINT hall_pkey PRIMARY KEY (id)
)

// Создание таблицы рядов.
CREATE TABLE row
(
    id integer NOT NULL INCREMENT,       -- Идентификатор зала
    count_place_in_row integer NOT NULL, -- Количество мест в ряду
    CONSTRAINT row_pkey PRIMARY KEY (id)
)

// Создание таблицы клиентов.
CREATE TABLE clients
(
    id integer NOT NULL INCREMENT, -- Идентификатор клиента
    name character varying(200),   -- Имя клиента
    number_phone integer,          -- Номер телефона
    CONSTRAINT client_pkey PRIMARY KEY (id)
)

// Создание таблицы сеансов.
CREATE TABLE sessions
(
    id integer NOT NULL INCREMENT, -- Идентификатор сеанса
    id_film integer NOT NULL,      -- Идентификатор фильма
    id_hall integer NOT NULL ,     -- Идентификатор зала
    datetime_session datetime,     -- Время и дата
    CONSTRAINT session_pkey PRIMARY KEY (id)
    CONSTRAINT film_fkey FOREIGN KEY (id_film)
      REFERENCES films (id)
    CONSTRAINT hall_fkey FOREIGN KEY (id_hall)
      REFERENCES hall (id)
)

// Создание таблицы билетов.
CREATE TABLE tickets
(
    id integer NOT NULL INCREMENT, -- Идентификатор цены
    id_client integer NOT NULL,    -- Идентификатор клиента
    id_price integer NOT NULL,     -- Идентификатор цены
    id_session integer NOT NULL,   -- Идентификатор сеанса
    id_row integer NOT NULL,       -- Идентификатор ряда
    place integer NOT NULL,        -- Место
    CONSTRAINT ticket_pkey PRIMARY KEY (id)
    CONSTRAINT client_pkey FOREIGN KEY (id_client)
      REFERENCES clients (id)
    CONSTRAINT session_fkey FOREIGN KEY (id_hall)
      REFERENCES sessions (id)
    CONSTRAINT row_fkey FOREIGN KEY (id_hall)
      REFERENCES row (id)
    CONSTRAINT price_fkey FOREIGN KEY (id_hall)
      REFERENCES pricelist (id)
)