create table halls
(
    id integer not null constraint pk_hall_id primary key,
    name varchar(250)
);

insert into halls
values
    (1, 'Большой'),
    (2, 'Средний'),
    (3, 'Малый');

create table films
(
    id integer not null constraint pk_film_id primary key,
    name varchar(250),
    duration float not null
);

insert into films
values
    (1, 'Аватар', 3.45),
    (2, 'Чебурашка', 2.10),
    (3, 'Человек Паук', 1.45);

create table seances
(
    id integer not null constraint pk_seance_id primary key,
    hall_id integer not null,
    film_id integer not null,
    start_seance timestamp not null,
    price int not null,
    constraint fk_hall_id foreign key (hall_id) references halls on delete cascade,
    constraint fk_film_id foreign key (film_id) references films on delete cascade
);

insert into seances
values
    (1, 1, 1, '2023-01-19 10:00:00', 200),
    (2, 2, 2, '2023-01-19 10:00:00', 300),
    (3, 3, 3, '2023-01-19 10:00:00', 400);

create table seates
(
    id integer not null constraint pk_seat_id primary key,
    seance_id integer not null,
    row_seat integer not null,
    place_seat integer not null,
    constraint pk_seance_id foreign key (seance_id) references seances on delete cascade,
    unique (seance_id, row_seat, place_seat)
);

insert into seates
values
    (1, 1, 2, 1),
    (2, 2, 3, 4),
    (3, 3, 6, 5),
    (4, 3, 6, 4);

create table hall_seates
(
    id integer not null constraint pk_hs_id primary key,
    hall_id integer not null,
    width_hall integer not null,
    row_hall integer not null,
    constraint pk_hall_id foreign key (hall_id) references halls on delete cascade
);

insert into hall_seates
values
    (1, 1, 15, 15),
    (2, 2, 13, 12),
    (3, 3, 10, 7);

create table order_client
(
    id integer not null constraint pk_order_client_id primary key,
    seance_id integer not null,
    total_price int not null,
    constraint fk_seance_id foreign key (seance_id) references seances on delete cascade
);

insert into order_client
values
    (1, 1, 200),
    (2, 2, 250),
    (3, 3, 400);
