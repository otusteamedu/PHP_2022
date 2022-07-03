CREATE TABLE IF NOT EXISTS hall
(
    id   SERIAL PRIMARY KEY NOT NULL,
    name varchar(50)        NOT NULL
);

CREATE TABLE IF NOT EXISTS film
(
    id       SERIAL PRIMARY KEY NOT NULL,
    name     VARCHAR            NOT NULL,
    duration TIME               NOT NULL,
    base_price INT NOT NULL
);

CREATE TABLE IF NOT EXISTS session
(
    id      SERIAL PRIMARY KEY NOT NULL,
    film_id int REFERENCES film,
    time    timestamp,
    price_multiplier float NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS customer
(
    id    SERIAL PRIMARY KEY NOT NULL,
    phone numeric
);

CREATE TABLE IF NOT EXISTS hall_session
(
    session_id int REFERENCES session,
    hall_id    int REFERENCES hall
);

CREATE TABLE IF NOT EXISTS place
(
    id      SERIAL   NOT NULL PRIMARY KEY,
    row     smallint NOT NULL,
    place   smallint NOT NULL,
    hall_id int REFERENCES hall,
    price_multiplier float NOT NULL DEFAULT 1
);
CREATE UNIQUE INDEX ON place (row, place, hall_id);

CREATE TABLE IF NOT EXISTS ticket
(
    id             SERIAL PRIMARY KEY NOT NULL,
    session_id     int REFERENCES session,
    customer_id    int REFERENCES customer,
    place_id       int REFERENCES place,
    full_price money NOT NULL
);

CREATE UNIQUE INDEX ON ticket (session_id, place_id);