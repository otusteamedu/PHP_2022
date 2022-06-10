create table
    hall
(
    id   serial primary key,
    name varchar(255) unique not null
);

create table
    movie
(
    id         serial primary key,
    name       varchar(255) not null,
    duration   integer      not null,
    base_price numeric      not null
);

create table
    session
(
    id                serial primary key,
    movie_id          integer   not null,
    hall_id           integer   not null,
    time_start        timestamp not null,
    price_coefficient numeric   not null default 1,
    unique (hall_id, time_start),
    foreign key (movie_id) references movie (id),
    foreign key (hall_id) references hall (id)
);

create table
    seat_type
(
    id        serial primary key,
    type      varchar unique not null,
    min_price numeric        not null
);

create table
    seat
(
    id           serial primary key,
    hall_id      integer not null,
    seat_type_id integer not null,
    row_number   integer not null,
    seat_number  integer not null,
    unique (hall_id, row_number, seat_number),
    foreign key (hall_id) references hall (id),
    foreign key (seat_type_id) references seat_type (id)
);

create table
    seat_session
(
    id         serial primary key,
    session_id integer not null,
    seat_id    integer not null,
    unique (session_id, seat_id),
    foreign key (session_id) references session (id),
    foreign key (seat_id) references seat (id)
);

create table
    ticket
(
    id             serial primary key,
    created        timestamp not null default now(),
    sold_for_price numeric   not null,
    customer_data  text      not null
);

create table
    status
(
    id   serial primary key,
    name varchar(255) unique not null
);

create table ticket_status
(
    id              serial primary key,
    ticket_id       integer not null,
    seat_session_id integer not null,
    status_id       integer not null,
    unique (ticket_id, seat_session_id, status_id),
    foreign key (ticket_id) references ticket (id),
    foreign key (seat_session_id) references seat_session (id),
    foreign key (status_id) references status (id)
);