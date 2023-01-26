create table films
(
    id integer not null constraint pk_film_id primary key,
    name varchar(250) not null
);

insert into films
values
    (1, 'Аватар'),
    (2, 'Матрица'),
    (3, 'Дэдпул');

create table film_type
(
    id integer not null constraint pk_type_id primary key,
    name varchar(250) not null
);

insert into film_type
values
    (1, 'Текст'),
    (2, 'Дата'),
    (3, 'Да/Нет');

create table film_attributes
(
    id integer not null constraint pk_attr_id primary key,
    type_id integer not null,
    name varchar(250) not null,
    constraint fk_type_id foreign key (type_id) references film_type on delete cascade
);

insert into film_attributes
values
    (1, 1, 'Рецензия'),
    (2, 2, 'Мировая премьера'),
    (3, 2, 'Премьера в РФ'),
    (4, 2, 'Ограничение по возрасту');

create table film_values
(
    id integer not null constraint pk_value_id primary key,
    attr_id integer not null,
    film_id integer not null,
    value text default null,
    value_date date default null,
    value_int int default null,
    value_float float default null,
    value_bool boolean default null,
    constraint fk_attr_id foreign key (attr_id) references film_attributes on delete cascade,
    constraint fk_film_id foreign key (film_id) references films on delete cascade
);

insert into film_values
values
    (1, 1, 1, 'Тестовая рецензия', null, null, null, null),
    (2, 2, 2, null, '2023-01-25', null, null, null),
    (3, 2, 2, null, '2023-02-25', null, null, null),
    (4, 4, 2, null, null, null, null, false);


