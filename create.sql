create table films
(
    id integer not null constraint pk_film_id primary key,
    name varchar(250) not null
)

create table halls
(
    id integer not null constraint pk_hall_id primary key,
    name varchar(250) not null,
    count_rows integer not null,
    count_places integer not null
)

create table seances
(
    id integer not null constraint pk_seance_id primary key,
    film_id integer not null,
    date date not null,
    price float not null,
    constraint fk_film_id foreign key (film_id) references films on delete cascade
)

create table orders
(
    id integer not null constraint pk_order_id primary key,
    seance_id integer not null,
    hall_id integer not null,
    row integer not null,
    seat integer not null,
    date date not null,
    count float not null,
    constraint fk_seance_id foreign key (seance_id) references seances on delete cascade,
    constraint fk_hall_id foreign key (hall_id) references halls on delete cascade
)