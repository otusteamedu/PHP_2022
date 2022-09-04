create table customer
(
    id         serial
        primary key
        unique,
    first_name varchar,
    last_name  varchar,
    email      varchar,
    phone      varchar
);

create table hall
(
    id   serial
        constraint hall_pk
            primary key
        unique,
    name varchar
);

create table movie
(
    id          serial
        constraint movie_pk
            primary key
        unique,
    name        varchar not null,
    description text    not null
);

create table seat
(
    id      serial
        constraint seat_pk
            primary key
        unique,
    hall_id integer not null
        constraint fk_hall_id
            references hall (id) on delete restrict on update restrict,
    row     integer not null,
    seat    integer not null
);

create table session
(
    id       serial
        constraint session_pk
            primary key
        unique,
    movie_id integer   not null
        constraint fk_movie_id
            references movie (id) on delete restrict on update restrict,
    hall_id  integer   not null
        constraint fk_hall_id
            references hall (id) on delete restrict on update restrict,
    price    integer   not null,
    start    timestamp not null,
    "end"    timestamp not null
);

create table ticket
(
    id          serial
        constraint ticket_pk
            primary key
        unique,
    session_id  integer not null
        constraint fk_session_id
            references session (id) on delete restrict on update restrict,
    seat_id     integer not null
        constraint fk_seat_id
            references seat (id) on delete restrict on update restrict,
    customer_id integer not null
        constraint fk_customer_id
            references customer (id) on delete restrict on update restrict
);
