create table movie
(
    id   serial
        constraint movie_pk
            primary key,
    name varchar(255) not null
);

alter table movie
    owner to "user";

create unique index movie_name_uindex
    on movie (name);

create table movie_attribute_type
(
    type          varchar(20)          not null
        constraint movie_attribute_type_pk
            primary key,
    use_in_filter boolean default true not null
);

comment on column movie_attribute_type.use_in_filter is 'Показывать аттрибуты этого типа в фильтре по фильмам';

alter table movie_attribute_type
    owner to "user";

create table movie_attribute
(
    id   serial
        constraint movie_attribute_pk
            primary key,
    name varchar(255) not null,
    type varchar(20)
        constraint movie_attribute_movie_attribute_type_type_fk
            references movie_attribute_type
);

alter table movie_attribute
    owner to "user";

create unique index movie_attribute_name_uindex
    on movie_attribute (name);

create table movie_attribute_value
(
    attribute_id   integer not null
        constraint movie_attribute_value_movie_attribute_id_fk
            references movie_attribute,
    movie_id       integer not null
        constraint movie_attribute_value_movie_id_fk
            references movie,
    value_int      integer,
    value_numeric  numeric,
    value_date     date,
    value_datetime timestamp with time zone,
    value_boolean  boolean,
    value_text     text,
    id             serial
        constraint movie_attribute_value_pk
            primary key,
    value_float    double precision
);

alter table movie_attribute_value
    owner to "user";

