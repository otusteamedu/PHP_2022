create table movie
(
    id   serial
        constraint movie_pk
            primary key,
    name varchar not null
);

create table attribute_type
(
    id   serial
        primary key,
    name varchar not null
);

create table attribute
(
    id      serial
        primary key,
    name    varchar not null,
    type_id integer not null
        constraint fk_attribute_type_id
            references attribute_type
            on update restrict on delete restrict
);

create table value
(
    id           serial
        primary key,
    attribute_id integer               not null
        constraint fk_attribute_id
            references attribute
            on update restrict on delete restrict,
    movie_id     integer               not null
        constraint fk_movie_id
            references movie
            on update restrict on delete restrict,
    text         text,
    int          integer,
    date         timestamp,
    bool         boolean default false not null
);
