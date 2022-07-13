create table car
(
    id    serial   not null
        constraint table_name_pk
            primary key,
    name  char(30) not null,
    brand char(50) not null,
    color char(10) not null,
    price double precision
);