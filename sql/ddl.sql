create table hall
(
    id              integer default nextval('cinema_id_seq'::regclass) not null
        constraint cinema_pk
            primary key,
    name            varchar,
    number_of_seats integer default 100                                not null
);

alter table hall
    owner to "user";

create table movie
(
    id   serial
        constraint movie_pk
            primary key,
    name varchar not null
);

alter table movie
    owner to "user";

create table session
(
    id         serial
        constraint session_pk
            primary key,
    hall_id    integer          not null
        constraint session_hall_id_fk
            references hall,
    movie_id   integer          not null
        constraint session_movie_id_fk
            references movie,
    start_time timestamp        not null,
    price      double precision not null
);

alter table session
    owner to "user";

create table viewer
(
    id      serial
        constraint viewer_pk
            primary key,
    name    varchar,
    surname varchar
);

alter table viewer
    owner to "user";

create table "order"
(
    id         serial
        constraint order_pk
            primary key,
    viewer_id  integer not null
        constraint order_viewer_id_fk
            references viewer,
    created_at timestamp default now()
);

alter table "order"
    owner to "user";

create table ticket
(
    id         serial
        constraint ticket_pk
            primary key,
    order_id   integer not null
        constraint ticket_order_id_fk
            references "order",
    session_id integer not null
        constraint ticket_session_id_fk
            references session
);

alter table ticket
    owner to "user";

