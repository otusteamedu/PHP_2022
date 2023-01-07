create table movies
(
    id    serial primary key,
    title varchar(255)
);

create table halls
(
    id    serial primary key,
    title varchar(20) -- название зала
);

create table places
(
    id      serial primary key,
    number  integer not null, -- номер кресла
    row     integer not null, -- номер ряда
    hall_id integer references halls (id)
);

create table sessions
(
    id       serial primary key,
    movie_id integer references movies (id),
    hall_id  integer references halls (id),
    start_at timestamp,
    cost     decimal(5, 2) -- стоимость одного билета
);

create table tickets
(
    id         serial primary key,
    total_cost decimal(5, 2), -- итоговая стоимость билета с учетом примененных скидок
    session_id integer references sessions (id),
    place_id   integer references places (id)
);