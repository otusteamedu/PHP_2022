create table hall
(
    id       serial primary key,
    capacity int not null
);

create table movie
(
    id       serial primary key,
    name     varchar(255) not null,
    price    int          not null,
    duration time         not null
);

create table session
(
    id         serial primary key,
    start_date date not null,
    start_time time not null,
    movie_id   int  not null,
    hall_id    int  not null,
    foreign key (hall_id) references hall (id),
    foreign key (movie_id) references movie (id)
);

create table ticket
(
    id          serial primary key,
    seat_number int not null,
    session_id  int not null,
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