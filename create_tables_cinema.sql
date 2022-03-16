CREATE TABLE films (
    film_id    serial  PRIMARY KEY,
    title       varchar(50) NOT NULL UNIQUE,
    data        date NOT NULL,
    price       integer NOT NULL,
);

CREATE TABLE session_time (
    session_id  serial PRIMARY KEY,
    time_sess   time NOT NULL,
);

CREATE TABLE hall (
    hall_id     serial  PRIMARY KEY,
    name        varchar(50) NOT NULL check (location in('красный', 'синий')),
    id_session  integer NOT NULL,
    FOREIGN KEY (id_session) REFERENCES session_time(session_id),
);

CREATE TABLE ticket (
    ticket_id   serial  PRIMARY KEY,
    id_hall     integer NOT NULL,
    id_film    integer NOT NULL,
    FOREIGN KEY (id_hall) REFERENCES hall (hall_id) ON DELETE CASCADE,
    FOREIGN KEY (id_film) REFERENCES films (film_id) ON DELETE CASCADE,
);

CREATE TABLE user (
    user_id     serial  PRIMARY KEY,
    name        varchar(50) NOT NULL UNIQUE,
    phone       varchar(50) NOT NULL UNIQUE,

    FOREIGN KEY (ticket_id) REFERENCES ticket (id_ticket) ON DELETE CASCADE,
);

CREATE TABLE user_ticket (
    id          serial PRIMARY KEY,
    id_user     integer NOT NULL,
    id_ticket   integer NOT NULL,
    FOREIGN KEY (id_user) REFERENCES user (user_id) ON DELETE CASCADE,
    FOREIGN KEY (id_ticket) REFERENCES ticket (ticket_id) ON DELETE CASCADE,
);