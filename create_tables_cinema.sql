CREATE TABLE films (
    id_films      integer  PRIMARY KEY,
    title         varchar(50) NOT NULL UNIQUE,
    tiket_count   integer NOT NULL,
);

CREATE TABLE hall (
    id_hall       integer  PRIMARY KEY,
    name          varchar(50) NOT NULL check (location in('красный', 'синий')),
    time_session  time NOT NULL,
);

CREATE TABLE films_hall (
    id          integer  PRIMARY KEY,
    id_hall     integer NOT NULL,
    id_films    integer NOT NULL,
    FOREIGN KEY (id_hall) REFERENCES films (id_hall),
    FOREIGN KEY (id_films) REFERENCES films (id_films),
);
