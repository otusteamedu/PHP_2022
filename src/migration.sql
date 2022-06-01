

create table if not exists film
(
    id     serial primary key,
    name   varchar(256) not null,
    length int          not null
);

create table if not exists film_attribute_type
(
    id   smallserial primary key,
    name varchar(16) not null
);


create table if not exists film_attribute
(
    id             serial primary key,
    name           varchar(256) not null ,
    attribute_type smallint references film_attribute_type (id) not null ,
    parent_attribute_id int references film_attribute (id)
);

create table if not exists film_attribute_value
(
    id           bigserial primary key,
    film_id      int references film (id) not null ,
    attribute_id int references film_attribute (id) not null ,
    v_int        bigint,
    v_float      float,
    v_bool       bool,
    v_string     varchar(128),
    v_text       text,
    v_binary     bytea,
    v_date       date,
    created_at   timestamp default now(),
    updated_at   timestamp default now()
);

insert into film_attribute_type (id, name)
values (1, 'int'),
       (2, 'float'),
       (3, 'bool'),
       (4, 'string'),
       (5, 'text'),
       (6, 'resource'),
       (7, 'date');

insert into film_attribute (id, name, attribute_type, parent_attribute_id)
    values (1, 'Рецензии', 5, null),
           (2, 'Рецензии критиков', 5, 1),
           (3, 'Отзывы диванных войск', 5, 1),
           (4, 'Премии', 3, null),
           (5, 'Оскар', 3, 4),
           (6, 'Ника', 3, 4),
           (7, 'Золотая малина', 3, 4),
           (8, 'Важные даты', 7, null),
           (9, 'Мировая премьера', 7, 8),
           (10, 'Премьера в России', 7, 8),
           (11, 'Релиз на RuTracker', 7, 8),
           (12, 'Служебные даты', 7, null),
           (13, 'Дата начала продажи билетов', 7, 12),
           (14, 'Дата окончания показа', 7, 12),
           (15, 'Дата запуска рекламы на тв', 7, 12);


