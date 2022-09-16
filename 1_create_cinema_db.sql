-- Otus homeWork #11 (cinema DB, extended version)
-- all files in one 

-- create db
create database otus_hw11 WITH OWNER = postgres  ENCODING = 'UTF8'  IS_TEMPLATE = False;
GRANT ALL PRIVILEGES ON DATABASE "otus_hw11" to postgres;
comment on database otus_hw11 is 'Otus HomeWork #11 (cinema DB with indexes)';

-- connect to created db
\c otus_hw11;

-- use shema
SET search_path TO public;

-- Halls
create table hall
(
    id   serial
        constraint hall_pk
            primary key,
    name varchar(255)
);
comment on table hall is 'Cinema halls';
comment on column hall.id is 'PK';
comment on column hall.name is 'Hall name/number';

-- Movies
create table movie
(
    id   serial
        constraint movie_pk
            primary key,
    name varchar(255),
    duration int not null
);
comment on table movie is 'Movies in cinema';
comment on column movie.name is 'Movie name';
comment on column movie.duration is 'Film duration in minutes';


-- Schedule
create table schedule
(
    id         serial,
    hall_id    int not null
        constraint schedule_hall_id_fk
            references hall
            on update cascade on delete cascade,
    movie_id   int not null
        constraint schedule_movie_id_fk
            references movie
            on update cascade on delete cascade,
    start_time timestamp not null,
    price int not null
);
comment on table schedule is 'Moview schedule';
comment on column schedule.id is 'PK';
comment on column schedule.hall_id is 'Hall id (where moview is showing)';
comment on column schedule.movie_id is 'Moview to show, FK';
comment on column schedule.start_time is 'When movie starts';
comment on column schedule.price is 'Ticket price';

alter table schedule add constraint schedule_pk primary key (id);

-- Users
create table "user"
(
    id       serial,
    login    varchar(255) not null,
    password varchar      not null,
    name     varchar      not null
);

comment on table "user" is 'Cinema visitors';
comment on column "user".login is 'Login';
comment on column "user".password is 'User password';
comment on column "user".name is 'User name / FIO';

create unique index user_id_uindex on "user" (id);
alter table "user" add constraint user_pk primary key (id);

-- Places in halls
create table place
(
    id      serial,
    row     int,
    number  int,
    hall_id int
        constraint place_hall_id_fk
            references hall
            on update cascade on delete cascade
);

comment on table place is 'Plaves in halls';
comment on column place.row is 'Row number';
comment on column place.number is 'Place number inside row';
comment on column place.hall_id is 'Hall ID';

create unique index place_id_uindex
    on place (id);

alter table place
    add constraint place_pk
        primary key (id);

-- skip duplicates in places
create index place_row_number_hall_id_index
    on place (row, number, hall_id);

-- Orders
create table "order"
(
    id          serial,
    user_id     int       not null
        constraint order_user_id_fk
            references "user"
            on update cascade on delete cascade,
    schedule_id int       not null
        constraint order_schedule_id_fk
            references schedule
            on update cascade on delete cascade,
    paytime     timestamp not null,
    place_id    int       not null
        constraint order_place_id_fk
            references place
            on update cascade on delete cascade
);

comment on table "order" is 'Tickets/orders';
comment on column "order".id is 'PK';
comment on column "order".user_id is 'User ID';
comment on column "order".paytime is 'When ticket was payed';
comment on column "order".place_id is 'Ordered place';

create unique index order_id_uindex
    on "order" (id);

alter table "order"
    add constraint order_pk
        primary key (id);