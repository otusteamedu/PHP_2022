create table if not exists film
(
    film_id      serial
        constraint film_pk
            primary key,
    film_name    varchar(255) not null,
    description  text,
    premier_date timestamp
);

alter table film
    owner to root;

create table if not exists attr_type
(
    type_id   serial
        constraint attr_type_pk
            primary key
        constraint attr_type_fk0
            references attr_type,
    type_name varchar(255) not null,
    t_type_id integer
);

alter table attr_type
    owner to root;

create table if not exists attribute
(
    attr_id      serial
        constraint attribute_pk
            primary key,
    attr_name    varchar(255) not null
        unique,
    attr_type_id integer      not null
        constraint attribute_fk0
            references attr_type
);

alter table attribute
    owner to root;

create table if not exists attr_value
(
    attr_value_id serial
        constraint attr_value_pk
            primary key,
    attr_id       serial
        constraint attr_value_fk0
            references attribute,
    text_val      text,
    bool_val      boolean,
    date_val      timestamp,
    int_val       integer,
    float_val     double precision,
    film_id       integer not null
        constraint attr_value_fk1
            references film
);

alter table attr_value
    owner to root;

create table if not exists cinema_hall
(
    hall_id            serial
        constraint cinema_hall_pk
            primary key,
    name               varchar(100) not null,
    quantity_of_places integer      not null
);

alter table cinema_hall
    owner to root;

create table if not exists place_type
(
    place_type_id serial
        constraint place_type_pk
            primary key,
    type          varchar(255) not null
);

alter table place_type
    owner to root;

create table if not exists session
(
    session_id serial
        constraint session_pk
            primary key,
    title      varchar(255) not null,
    time       time         not null
);

alter table session
    owner to root;

create table if not exists price
(
    price_id      serial
        constraint price_pk
            primary key,
    hall_id       integer not null
        constraint price_fk0
            references cinema_hall,
    place_type_id integer not null
        constraint price_fk1
            references place_type,
    session_id    integer not null
        constraint price_fk2
            references session,
    film_id       integer not null
        constraint price_fk3
            references film,
    amount        integer not null
);

alter table price
    owner to root;

create table if not exists ticket
(
    ticket_id     serial
        constraint ticket_pk
            primary key,
    price_id      integer not null
        constraint ticket_fk0
            references price,
    purchase_date date    not null
);

alter table ticket
    owner to root;
