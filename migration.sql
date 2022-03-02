DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS prices;
DROP TABLE IF EXISTS hall_places;
DROP TABLE IF EXISTS halls;
DROP TABLE IF EXISTS films;

CREATE TABLE halls
(
    id   serial PRIMARY KEY,
    name varchar(40) NOT NULL CHECK (name <> '')
);

CREATE TABLE hall_places
(
    id      serial PRIMARY KEY,
    number  varchar(4),
    hull_id int         NOT NULL CHECK (hull_id > 0),
    type    varchar(16) NOT NULL CHECK (type = 'BUSINESS' or type = 'COMFORT' or type = 'VIP'),
    UNIQUE (number, hull_id),
    CONSTRAINT hall_place_id FOREIGN KEY (hull_id) REFERENCES halls (id)
);

CREATE TABLE films
(
    id   serial PRIMARY KEY,
    name varchar(40) NOT NULL CHECK (name <> '')
);

CREATE TABLE prices
(
    id             serial PRIMARY KEY,
    film           int NOT NULL CHECK (film > 0),
    session        int NOT NULL CHECK (session > 0),
    vip_place      int NOT NULL CHECK (vip_place > 0),
    business_place int NOT NULL CHECK (business_place > 0),
    comfort_place  int NOT NULL CHECK (comfort_place > 0)
);

CREATE TABLE sessions
(
    id         serial PRIMARY KEY,
    hall_id    int       NOT NULL,
    film_id    int       NOT NULL,
    price_id   int       NOT NULL,
    date_start timestamp NOT NULL,
    date_end   timestamp NOT NULL,
    CONSTRAINT session_hall_id FOREIGN KEY (hall_id) REFERENCES halls (id),
    CONSTRAINT session_film_id FOREIGN KEY (film_id) REFERENCES films (id),
    CONSTRAINT session_price_id FOREIGN KEY (price_id) REFERENCES prices (id)
);

CREATE TABLE orders
(
    id         serial PRIMARY KEY,
    session_id int         NOT NULL,
    place_id   int         NOT NULL,
    status     varchar(16) NOT NULL CHECK (status = 'PAID' or status = 'BOOKED'),
    amount     int         NOT NULL CHECK (amount > 0),
    UNIQUE (session_id, place_id),
    CONSTRAINT order_session_id FOREIGN KEY (session_id) REFERENCES sessions (id),
    CONSTRAINT order_hall_place_id FOREIGN KEY (place_id) REFERENCES hall_places (id)
);

CREATE TABLE transactions
(
    id       serial PRIMARY KEY,
    order_id int NOT NULL,
    status   varchar(16),
    amount   int NOT NULL CHECK (amount > 0),
    CONSTRAINT transaction_order_id FOREIGN KEY (order_id) REFERENCES orders (id)
);



