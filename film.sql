create table film
(
    film_id      serial
        constraint film_pk
            primary key,
    film_name     varchar(255) not null,
    description   text,
    country_id    integer,
    premier_date  timestamp,
    genre_id      integer,
    producer_id   integer,
    scenario_id   integer,
    world_charges integer
);
