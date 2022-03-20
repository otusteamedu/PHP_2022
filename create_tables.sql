create table attr_type
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

create table attribute
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

create table cinema_hall
(
    hall_id            serial
        constraint cinema_hall_pk
            primary key,
    name               varchar(100) not null,
    quantity_of_places integer      not null
);

alter table cinema_hall
    owner to root;

create table place_type
(
    place_type_id serial
        constraint place_type_pk
            primary key,
    type          varchar(255) not null
);

alter table place_type
    owner to root;

create table session
(
    session_id serial
        constraint session_pk
            primary key,
    title      varchar(255) not null,
    time       time         not null
);

alter table session
    owner to root;

create table genre
(
    genre_id serial
        constraint genre_pk
            primary key,
    title    varchar not null
);

alter table genre
    owner to root;

create table film
(
    film_id      serial
        constraint film_pk
            primary key,
    film_name    varchar(255) not null,
    description  text,
    premier_date timestamp,
    genre_id     integer
        constraint genre_id_fk
            references genre
);

alter table film
    owner to root;

create table attr_value
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

create index text_val_index
    on attr_value (text_val);

create table price
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

create table ticket
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


