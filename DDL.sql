create table films
(
    id integer not null constraint pk_film_id primary key,
    name varchar(250)
);

insert into films
values
    (1, 'Аватар'),
    (2, 'Матрица'),
    (3, 'Дэдпул');

create table film_attributes
(
    id integer not null constraint pk_attr_id primary key,
    film_id integer not null,
    name varchar(250),
    constraint pk_film_id foreign key (film_id) references films on delete cascade
);

insert into film_attributes
values
    (1, 1, 'Рецензия'),
    (2, 1, 'Премия'),
    (3, 1, 'Мировая премьера'),
    (4, 1, 'Начало продажи билетов'),
    (5, 2, 'Рецензия'),
    (6, 2, 'Премия'),
    (7, 2, 'Мировая премьера'),
    (8, 2, 'Начало продажи билетов'),
    (9, 3, 'Рецензия'),
    (10, 3, 'Премия'),
    (11, 3, 'Мировая премьера'),
    (12, 3, 'Начало продажи билетов');

create table film_attribute_type
(
    id integer not null constraint pk_type_id primary key,
    attr_id integer not null,
    type varchar(250) not null,
    constraint pk_attr_id foreign key (attr_id) references film_attributes on delete cascade
);

insert into film_attribute_type
values
    (1, 1, 'text'),
    (2, 7, 'timestamp'),
    (3, 12, 'timestamp');

create table film_values
(
    id integer not null constraint pk_values_id primary key,
    attr_id integer not null,
    attr_type_id integer not null,
    value char(125) not null,
    date timestamp default null,
    constraint pk_attr_id foreign key (attr_id) references film_attributes on delete cascade,
    constraint pk_type_id foreign key (attr_type_id) references film_attribute_type on delete cascade
);

insert into film_values
values
    (1, 1, 1, 'Тестовая рецензия', null),
    (2, 5, 1, 'Еще одна рецензия', null),
    (3, 10, 3, '2022-12-29', '2022-12-29');