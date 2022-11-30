create table movies
(
    id    serial primary key,
    title varchar(255)
);

create table halls
(
    id     serial primary key,
    places integer

);

create table sessions
(
    id       serial primary key,
    movie_id integer references movies (id),
    hall_id  integer references halls (id),
    start_at timestamp,
    cost     decimal(5, 2)
);

create table tickets
(
    id         serial primary key,
    session_id integer references sessions (id)
);