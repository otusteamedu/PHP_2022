// Создание таблицы фильмов.
CREATE TABLE films
(
    id integer NOT NULL INCREMENT, -- Идентификатор фильма
    name character varying(200), -- Название фильма
    description character varying(400), -- Описание фильмы
    CONSTRAINT film_pkey PRIMARY KEY (id)
)

// Создание таблицы цен.
CREATE TABLE pricelist
(
    id integer NOT NULL INCREMENT, -- Идентификатор цены
    id_film integer NOT NULL, -- Идентификатор фильма
    price integer, -- Цена
    CONSTRAINT price_pkey PRIMARY KEY (id)
    CONSTRAINT film_fkey FOREIGN KEY (id_film)
      REFERENCES films (id)
)

// Создание таблицы залов.
CREATE TABLE hall
(
    id integer NOT NULL INCREMENT, -- Идентификатор зала
    id_film integer NOT NULL, -- Идентификатор фильма
    CONSTRAINT hall_pkey PRIMARY KEY (id)
    CONSTRAINT film_fkey FOREIGN KEY (id_film)
      REFERENCES films (id)
)

// Создание таблицы клиентов.
CREATE TABLE clients
(
    id integer NOT NULL INCREMENT, -- Идентификатор клиента
    name character varying(200), -- Имя клиента
    number_phone integer, -- Номер телефона
    CONSTRAINT client_pkey PRIMARY KEY (id)
)

// Создание таблицы билетов.
CREATE TABLE tickets
(
    id integer NOT NULL INCREMENT, -- Идентификатор цены
    id_client integer NOT NULL, -- Идентификатор клиента
    id_film integer NOT NULL, -- Идентификатор фильма
    id_hall integer NOT NULL, -- Идентификатор зала
    CONSTRAINT ticket_pkey PRIMARY KEY (id)
    CONSTRAINT client_pkey FOREIGN KEY (id_client)
      REFERENCES clients (id)
    CONSTRAINT film_fkey FOREIGN KEY (id_film)
      REFERENCES films (id)
    CONSTRAINT hall_fkey FOREIGN KEY (id_hall)
      REFERENCES hall (id)
)