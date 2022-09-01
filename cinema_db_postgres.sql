create database otus_hw8;

comment on database otus_hw8 is 'Otus homeWork #8 (cinema DB)';

-- Halls
create table hall
(
    id   serial
        constraint hall_pk
            primary key,
    name varchar(255)
);
create unique index hall_name_uindex on hall (name);
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
create unique index movie_name_uindex on movie (name);
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
    start_time timestamp,
    price int not null
);
comment on table schedule is 'Moview schedule';
comment on column schedule.id is 'PK';
comment on column schedule.hall_id is 'Hall id (where moview is showing)';
comment on column schedule.movie_id is 'Moview to show, FK';
comment on column schedule.start_time is 'When movie starts';
comment on column schedule.price is 'Ticket price';

create unique index schedule_id_uindex on schedule (id);
alter table schedule add constraint schedule_pk primary key (id);
alter table schedule alter column start_time set not null;

-- skip duplicates om moviews shows
create unique index schedule_movie_id_hall_id_start_time_uindex
    on schedule (movie_id, hall_id, start_time);

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
create unique index user_login_uindex on "user" (login);
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

-- skip duplcate orders (same movie/time/place)
create unique index order_schedule_id_place_id_uindex
    on "order" (schedule_id, place_id);

-- Fill by data
INSERT INTO public.hall (id, name) VALUES (1, 'Hall #1');
INSERT INTO public.hall (id, name) VALUES (2, 'Hall #2');
INSERT INTO public.hall (id, name) VALUES (3, 'Hall #3');

INSERT INTO public.movie (id, name, duration) VALUES (1, 'Avengers', 90);
INSERT INTO public.movie (id, name, duration) VALUES (2, 'Terminator 2', 75);

INSERT INTO public.place (id, row, number, hall_id) VALUES (1, 1, 1, 1);
INSERT INTO public.place (id, row, number, hall_id) VALUES (2, 1, 2, 1);
INSERT INTO public.place (id, row, number, hall_id) VALUES (3, 1, 3, 1);
INSERT INTO public.place (id, row, number, hall_id) VALUES (4, 1, 4, 1);
INSERT INTO public.place (id, row, number, hall_id) VALUES (5, 2, 1, 1);
INSERT INTO public.place (id, row, number, hall_id) VALUES (6, 2, 2, 1);
INSERT INTO public.place (id, row, number, hall_id) VALUES (7, 2, 3, 1);
INSERT INTO public.place (id, row, number, hall_id) VALUES (8, 2, 4, 1);

INSERT INTO public."user" (id, login, password, name) VALUES (1, 'mishaikon', 'sdfsfsaf', 'Mikhail');
INSERT INTO public."user" (id, login, password, name) VALUES (2, 'amely', 'dfsgdsgds', 'Elena');

INSERT INTO public.schedule (id, hall_id, movie_id, start_time, price) 
VALUES (1, 1, 1, '2022-09-01 16:30:28.000000', 100);

INSERT INTO public.schedule (id, hall_id, movie_id, start_time, price) 
VALUES (2, 2, 2, '2022-09-02 16:32:43.000000', 200);

INSERT INTO public.schedule (id, hall_id, movie_id, start_time, price) 
VALUES (3, 1, 2, '2022-09-03 16:32:58.000000', 300);

INSERT INTO public."order" (id, user_id, schedule_id, paytime, place_id) VALUES (3, 1, 1, '2022-09-01 14:33:48.000000', 2);
INSERT INTO public."order" (id, user_id, schedule_id, paytime, place_id) VALUES (4, 1, 1, '2022-09-01 10:34:07.000000', 3);
INSERT INTO public."order" (id, user_id, schedule_id, paytime, place_id) VALUES (5, 1, 2, '2022-09-01 10:34:40.000000', 1);
INSERT INTO public."order" (id, user_id, schedule_id, paytime, place_id) VALUES (6, 2, 2, '2022-09-01 16:28:53.000000', 2);
INSERT INTO public."order" (id, user_id, schedule_id, paytime, place_id) VALUES (7, 1, 3, '2022-06-01 16:32:10.000000', 1);
INSERT INTO public."order" (id, user_id, schedule_id, paytime, place_id) VALUES (8, 1, 3, '2022-09-04 16:35:38.000000', 4);

-- Query: get most profitable film
select *
FROM (select m.name AS movie_name, SUM(s.price) as kassa
      from "order" o
               left join schedule s on o.schedule_id = s.id
               left join movie m on m.id = s.movie_id
      GROUP BY m.name
      ORDER BY kassa DESC) t
limit 1;