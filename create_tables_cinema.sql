CREATE TABLE films (
    films_id    serial  PRIMARY KEY,
    title       varchar(50) NOT NULL UNIQUE,
    data        date NOT NULL,
);

CREATE TABLE hall (
    hall_id     serial  PRIMARY KEY,
    name        varchar(50) NOT NULL check (location in('красный', 'синий')),
    time_ses    time NOT NULL,
);

CREATE TABLE ticket (
    id_ticket   serial  PRIMARY KEY,
    id_hall     integer NOT NULL,
    id_films    integer NOT NULL,
    price       real    NOT NULL,
    FOREIGN KEY (id_hall) REFERENCES hall (hall_id) ON DELETE CASCADE,
    FOREIGN KEY (id_films) REFERENCES films (films_id) ON DELETE CASCADE,
);

CREATE TABLE user (
    user_id     serial  PRIMARY KEY,
    name        varchar(50) NOT NULL UNIQUE,
    phone       varchar(50) NOT NULL UNIQUE,
    ticket_id   integer NOT NULL,
    FOREIGN KEY (ticket_id) REFERENCES ticket (id_ticket) ON DELETE CASCADE,
);