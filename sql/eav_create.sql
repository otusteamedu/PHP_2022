create table if not exists
    movie
(
    id         serial primary key,
    name       varchar(255) not null,
    duration   integer      not null,
    base_price numeric      not null
);

create table if not exists
    movie_attribute_type
(
    id   serial primary key,
    name varchar(255) unique not null
);

create table if not exists
    movie_attribute
(
    id                serial primary key,
    name              varchar(255) not null,
    attribute_type_id integer      not null,
    foreign key (attribute_type_id) references movie_attribute_type (id)
);

create table if not exists
    movie_attribute_value
(
    id                 serial primary key,
    movie_id           integer not null,
    movie_attribute_id integer not null,
    value_string       varchar(255),
    value_text         text,
    value_integer      integer,
    value_boolean      boolean,
    value_float        float,
    value_datetime     timestamp,
    foreign key (movie_id) references movie (id),
    foreign key (movie_attribute_id) references movie_attribute (id)
);