-- Homework for Lesson #10: EAV databases
-- @author Mikhail Ikonnikov <mishaikon@gmail.com>
-- Otus PHP Pro course: https://fas.st/wRyRs

--------------------------------------------------------------------------------
-- STRUCTURE 

-- ������� "�����":
-- id - ���������� ID
-- name - ��� ������
-- year - ��� ������������
CREATE TABLE IF NOT EXISTS film_ent (
    id serial PRIMARY KEY NOT NULL,
    name varchar(255) NOT NULL,
    year varchar(4) NOT NULL
);

-- ������� "���� ��������� ������":
-- id - ���������� ID
-- name - �������� ���� ��������
CREATE TABLE IF NOT EXISTS film_attr_type (
    id smallserial PRIMARY KEY NOT NULL,
    name varchar(100) NOT NULL UNIQUE
);

-- ������� "�������� ������":
-- id - ���������� ID
-- film_attr_type_id - ��� �������� ������
-- name - �������� ��������
CREATE TABLE IF NOT EXISTS film_attr (
    id smallserial PRIMARY KEY NOT NULL,
    film_attr_type_id smallint NOT NULL,
    name varchar(100) NOT NULL UNIQUE,
    FOREIGN KEY (film_attr_type_id) REFERENCES film_attr_type (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- ������� "�������� ��������� ������":
-- id - ���������� ID
-- film_ent_id - id ������
-- film_attr_id - id ��������
-- value_char - �������� ���� varchar
-- value_text - �������� ���� text
-- value_int - �������� ���� money
-- value_float - �������� ���� numeric
-- value_date - �������� ���� date
-- value_boolean - �������� ���� boolean
CREATE TABLE IF NOT EXISTS film_attr_value (
    id serial PRIMARY KEY NOT NULL,
    film_ent_id integer NOT NULL,
    film_attr_id smallint NOT NULL,
    value_char varchar(255) DEFAULT NULL,
    value_text text DEFAULT NULL,
    value_int int DEFAULT NULL,
    value_float float DEFAULT NULL,
    value_date date  DEFAULT NULL,
    value_boolean boolean  DEFAULT NULL,
    FOREIGN KEY (film_ent_id) REFERENCES film_ent (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (film_attr_id) REFERENCES film_attr (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Some indexes
CREATE UNIQUE INDEX index_film_attr_value
ON film_attr_value(film_ent_id, film_attr_id);

CREATE UNIQUE INDEX index_film_attr
ON film_attr(name, film_attr_type_id);

CREATE UNIQUE INDEX index_film_ent
ON film_ent(name, year);

CREATE UNIQUE INDEX index_film_attr_type
ON film_attr_type(name);

--------------------------------------------------------------------------------
-- DATA

INSERT INTO film_attr_type(name) VALUES
    ('��������'),
    ('������'),
    ('������ ����'),
    ('��������� ����');
    
INSERT INTO film_ent(name, year) VALUES
    ('Terminator', 1984),
    ('Cruel Intentions', 1999),
    ('The Godfather', 1972);
    
INSERT INTO film_attr(film_attr_type_id, name) VALUES
    (1, '�������� ��������'),
    (1, '�������� ������������'),
    (2, '������ �����'),
    (2, '������ �����'),
    (3, '�������� � ����'),
    (3, '�������� � ������'),
    (4, '���� ������ ������� �������'),
    (4, '������ �������');

INSERT INTO public.film_attr_value(film_ent_id, film_attr_id, value_text) VALUES (1, 1, '�����!');              
INSERT INTO public.film_attr_value(film_ent_id, film_attr_id, value_text) VALUES (1, 2, '������ �������.');
INSERT INTO public.film_attr_value(film_ent_id, film_attr_id, value_text) VALUES (2, 2, '� � ��������!');
INSERT INTO public.film_attr_value(film_ent_id, film_attr_id, value_text) VALUES (3, 1, '�������� ���� �� �����.');

INSERT INTO public.film_attr_value(film_ent_id, film_attr_id, value_boolean) VALUES (1, 3, true);
INSERT INTO public.film_attr_value(film_ent_id, film_attr_id, value_boolean) VALUES (2, 4, true);
INSERT INTO public.film_attr_value(film_ent_id, film_attr_id, value_boolean) VALUES (1, 4, true);

INSERT INTO public.film_attr_value(film_ent_id, film_attr_id, value_date) VALUES (3, 8, '1972-08-12');
INSERT INTO public.film_attr_value(film_ent_id, film_attr_id, value_date) VALUES (1, 5, '1984-05-03');
INSERT INTO public.film_attr_value(film_ent_id, film_attr_id, value_date) VALUES (1, 6, '1984-06-12');
INSERT INTO public.film_attr_value(film_ent_id, film_attr_id, value_date) VALUES (2, 7, current_date);
INSERT INTO public.film_attr_value(film_ent_id, film_attr_id, value_date) VALUES (1, 8, current_date);
INSERT INTO public.film_attr_value(film_ent_id, film_attr_id, value_date) VALUES (3, 7, current_date + interval '3 day');	
INSERT INTO public.film_attr_value(film_ent_id, film_attr_id, value_date) VALUES (2, 8, current_date + interval '20 day');


--------------------------------------------------------------------------------
-- VIEWS

CREATE OR REPLACE VIEW view_actual_tasks as
    SELECT
        film.name || ' (' || film.year || ')' "Film",
        fa.name as "Task",
        fav.value_date::text as "Exec date"
    FROM film_ent as film
         INNER JOIN film_attr_value fav on film.id = fav.film_ent_id
         INNER JOIN film_attr fa on fav.film_attr_id = fa.id
         INNER JOIN film_attr_type fat on fa.film_attr_type_id = fat.id
    WHERE
        fav.value_date = current_date OR fav.value_date = current_date + interval '20 days'
        AND fat.id = 4
    ORDER BY fav.value_date, film.id;

CREATE OR REPLACE VIEW view_films_data as
    SELECT
        film.name || ' (' || film.year || ')' "Film",
        fat.name as "Attribute type",
        fa.name as "Attribute subtype",
        CASE
            WHEN fav.value_char IS NOT NULL THEN fav.value_char
            WHEN fav.value_text IS NOT NULL THEN fav.value_text
            WHEN fav.value_int IS NOT NULL THEN fav.value_int::text
            WHEN fav.value_float IS NOT NULL THEN fav.value_float::text
            WHEN fav.value_date IS NOT NULL THEN fav.value_date::text
            WHEN fav.value_boolean IS NOT NULL THEN fav.value_boolean::text
        END "Attribute value"
    FROM film_ent as film
         INNER JOIN film_attr_value fav on film.id = fav.film_ent_id
         INNER JOIN film_attr fa on fav.film_attr_id = fa.id
         INNER JOIN film_attr_type fat on fa.film_attr_type_id = fat.id
    ORDER BY film.name, film.year, fat.name, fa.name, fav.film_attr_id;
    
--------------------------------------------------------------------------------
    