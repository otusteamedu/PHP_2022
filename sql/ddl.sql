create table hall
(
    id           serial primary key,
    seat_row     int          not null,
    seats_in_row int          not null,
    category     varchar(255) not null
);

create table movie
(
    id       serial primary key,
    name     varchar(255) not null,
    duration time         not null
);

create table time
(
    id      serial primary key,
    weekday varchar(255) not null,
    daytime varchar(255) not null
);

create table session
(
    id       serial primary key,
    movie_id int not null,
    hall_id  int not null,
    time_id  int not null,
    foreign key (movie_id) references movie (id),
    foreign key (hall_id) references hall (id),
    foreign key (time_id) references time (id)
);

create table seat
(
    id          serial primary key,
    seat_row    int not null,
    seat_number int not null
);

create table ticket
(
    id         serial primary key,
    price      int not null,
    seat_id    int not null,
    session_id int not null,
    foreign key (seat_id) references seat (id),
    foreign key (session_id) references session (id)
);

create table viewer
(
    id         serial primary key,
    first_name varchar(255),
    last_name  varchar(255),
    ticket_id  int not null,
    foreign key (ticket_id) references ticket (id)
);