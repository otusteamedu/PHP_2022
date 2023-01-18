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
    (3, 3, 3, '2023-01-19 10:00:00', 300);

create table order_client
(
    id integer not null constraint pk_order_client_id primary key,
    seance_id integer not null,
    row_hall integer not null,
    constraint fk_seance_id foreign key (seance_id) references seances on delete cascade
);

insert into order_client
values
    (1, 1, 3),
    (2, 2, 4),
    (3, 3, 5);
