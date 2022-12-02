/* создание таблиц */
CREATE TABLE movie (movie_id serial NOT NULL, name VARCHAR(256) NOT NULL, description VARCHAR(256)  NULL,  created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(movie_id));
CREATE TABLE attribute_type (attribute_type_id smallserial NOT NULL, name VARCHAR(20) NOT NULL, description VARCHAR(30), created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(attribute_type_id));
CREATE TABLE attribute (attribute_id serial NOT NULL, name VARCHAR(50) NOT NULL, attribute_type_id smallint NOT NULL,  created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(attribute_id));
CREATE TABLE attribute_value (attribute_value_id serial NOT NULL,
                              movie_id integer NOT NULL,
                              attribute_id  integer NOT NULL,
                              v_int  integer  NULL,
                              v_numeric numeric NULL,
                              v_text text NULL,
                              v_bool boolean NULL,
                              v_datetime TIMESTAMP(0) WITHOUT TIME ZONE  NULL,
                              created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(attribute_value_id));

/*Данные*/
insert into movie(name, created_at, updated_at) values ('film 1', now(), now());
insert into movie(name, created_at, updated_at) values ('film 2', now(), now());
insert into movie(name, created_at, updated_at) values ('film 3', now(), now());
insert into movie(name, created_at, updated_at) values ('film 4', now(), now());

insert into attribute_type(name, description, created_at, updated_at) values ('int', 'integer', now(), now());
insert into attribute_type(name, description, created_at, updated_at) values ('numeric', 'numeric', now(), now());
insert into attribute_type(name, description, created_at, updated_at) values ('text', 'text', now(), now());
insert into attribute_type(name, description, created_at, updated_at) values ('bool', 'boolean', now(), now());
insert into attribute_type(name, description, created_at, updated_at) values ('datetime', 'TIMESTAMP', now(), now());

insert into attribute(name, attribute_type_id, created_at, updated_at) values ('Рецензия', 3, now(), now());
insert into attribute(name, attribute_type_id, created_at, updated_at) values ('Премия', 3, now(), now());
insert into attribute(name, attribute_type_id, created_at, updated_at) values ('Мировая премьера', 5, now(), now());
insert into attribute(name, attribute_type_id, created_at, updated_at) values ('Премьера в РФ', 5, now(), now());
insert into attribute(name, attribute_type_id, created_at, updated_at) values ('Дата начала продажи билетов', 5, now(), now());
insert into attribute(name, attribute_type_id, created_at, updated_at) values ('Дата старта рекламы', 5, now(), now());
insert into attribute(name, attribute_type_id, created_at, updated_at) values ('Минимальный возраст', 1, now(), now());
insert into attribute(name, attribute_type_id, created_at, updated_at) values ('Наличии премии', 4, now(), now());


insert into attribute_value(movie_id, attribute_id, v_text,   created_at, updated_at) values (1, 1, 'Резенция для фильма 1 Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',  now(), now());
insert into attribute_value(movie_id, attribute_id, v_text,   created_at, updated_at) values (2, 1, 'Резенция для фильма 2 Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',  now(), now());
insert into attribute_value(movie_id, attribute_id, v_text,   created_at, updated_at) values (3, 1, 'Резенция для фильма 3 Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',  now(), now());
insert into attribute_value(movie_id, attribute_id, v_text,   created_at, updated_at) values (1, 2, 'Оскар',  now(), now());
insert into attribute_value(movie_id, attribute_id, v_text,   created_at, updated_at) values (2, 2, 'Ника',  now(), now());
insert into attribute_value(movie_id, attribute_id, v_bool,   created_at, updated_at) values (1, 9, true ,  now(), now());
insert into attribute_value(movie_id, attribute_id, v_bool,   created_at, updated_at) values (2, 9, true,  now(), now());


insert into attribute_value(movie_id, attribute_id, v_int,   created_at, updated_at) values (2, 7, 18,  now(), now());
insert into attribute_value(movie_id, attribute_id, v_int,   created_at, updated_at) values (3, 7,  14,  now(), now());

insert into attribute_value(movie_id, attribute_id, v_datetime,   created_at, updated_at) values (1, 4, current_date +  INTERVAL '40 day',  now(), now());
insert into attribute_value(movie_id, attribute_id, v_datetime,   created_at, updated_at) values (2, 4, current_date +  INTERVAL '35 day',  now(), now());
insert into attribute_value(movie_id, attribute_id, v_datetime,   created_at, updated_at) values (3, 4, current_date +  INTERVAL '20 day',  now(), now());

insert into attribute_value(movie_id, attribute_id, v_datetime,   created_at, updated_at) values (1, 5, current_date +  INTERVAL '20 day',  now(), now());
insert into attribute_value(movie_id, attribute_id, v_datetime,   created_at, updated_at) values (2, 5, current_date +  INTERVAL '15 day',  now(), now());
insert into attribute_value(movie_id, attribute_id, v_datetime,   created_at, updated_at) values (3, 5, current_date +  INTERVAL '5 day',  now(), now());

insert into attribute_value(movie_id, attribute_id, v_datetime,   created_at, updated_at) values (1, 6, current_date +  INTERVAL '10 day',  now(), now());
insert into attribute_value(movie_id, attribute_id, v_datetime,   created_at, updated_at) values (2, 6, current_date +  INTERVAL '5 day',  now(), now());
insert into attribute_value(movie_id, attribute_id, v_datetime,   created_at, updated_at) values (3, 6, current_date,  now(), now());

insert into attribute_value(movie_id, attribute_id, v_datetime,   created_at, updated_at) values (4, 6, current_date,  now(), now());
insert into attribute_value(movie_id, attribute_id, v_datetime,   created_at, updated_at) values (4, 5,  current_date +  INTERVAL '20 day',  now(), now());


/* view */
create view todo_today (movie_name, attribute_name) as
select m.name, a.name from  attribute_value av
inner join attribute a on a.attribute_id = av.attribute_id
inner join attribute_type at on at.attribute_type_id = a.attribute_type_id
inner join movie m on m.movie_id =  av.movie_id
where av.v_datetime = current_date  and  av.attribute_id in (5,6)
order by m.name, a.name;



create view todo_in_20_days(movie_name, attribute_name) as
select m.name, a.name from  attribute_value av
inner join attribute a on a.attribute_id = av.attribute_id
inner join attribute_type at on at.attribute_type_id = a.attribute_type_id
inner join movie m on m.movie_id =  av.movie_id
where (av.v_datetime = (current_date + INTERVAL '20 day')) and  av.attribute_id in (5,6)
order by m.name, a.name;

/*select * from  attribute_value where (v_datetime between current_date + INTERVAL '14 day' and current_date + INTERVAL '15 day' ) and  attribute_id in (5,6);*/

create view movie_attribute(movie_name,attribute_type, attribute_name, value)  as
select m.name, at.name, a.name,
       CASE
           WHEN at.name = 'int' THEN av.v_int:: text
           WHEN at.name = 'text' THEN av.v_text::text
           WHEN at.name = 'bool' THEN

               CASE
                   WHEN av.v_bool = 't' THEN 'есть'
                   WHEN av.v_bool = 'f' THEN 'нет'
               end

           WHEN at.name = 'datetime' THEN to_char(av.v_datetime , 'DD-MM-YYYY')
       END atrr_value
from  attribute_value av
inner join attribute a on a.attribute_id = av.attribute_id
inner join attribute_type at on at.attribute_type_id = a.attribute_type_id
inner join movie m on m.movie_id =  av.movie_id
order by m.name, a.name,at.name ;











