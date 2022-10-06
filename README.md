# PHP_2022 Домашнее задание HW9 - explain, index

# скрипт создания БД (с предыдущих занятий) - create_tables.sql
```
CREATE TABLE IF NOT EXISTS public.film
(
    id_film integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    film_name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT "PK_id_film" PRIMARY KEY (id_film)
)

CREATE TABLE IF NOT EXISTS public.film_attr_type
(
    id_type_attr integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    attr_type_name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT "PK_id_type_attr" PRIMARY KEY (id_type_attr),
    CONSTRAINT "UNIQUE_attr_type_name" UNIQUE (attr_type_name)
        INCLUDE(attr_type_name)
)

CREATE TABLE IF NOT EXISTS public.film_attr
(
    "id_attr int" integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    id_type_attr integer NOT NULL,
    attr_name character varying(50) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT "PK_id_attr" PRIMARY KEY ("id_attr int"),
    CONSTRAINT "UNIQUE_attr_name" UNIQUE (attr_name)
        INCLUDE(attr_name),
    CONSTRAINT "FK1_id_type_attr" FOREIGN KEY (id_type_attr)
        REFERENCES public.film_attr_type (id_type_attr) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
        NOT VALID
)

CREATE TABLE IF NOT EXISTS public.film_values
(
    id_val integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    id_film integer NOT NULL,
    id_attr integer NOT NULL,
    val_int integer,
    val_char character varying COLLATE pg_catalog."default",
    val_date date,
    val_boolean boolean,
    "val_float " numeric,
    CONSTRAINT "PK_id_val" PRIMARY KEY (id_val),
    CONSTRAINT "FK1_id_film" FOREIGN KEY (id_film)
        REFERENCES public.film (id_film) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT "FK2_id_attr" FOREIGN KEY (id_attr)
        REFERENCES public.film_attr ("id_attr int") MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
)


CREATE UNIQUE INDEX index_film_values
ON film_values(id_film, id_attr);
```
# скрипт заполнения БД тестовыми данными - insert_into.sql
```
INSERT INTO film(film_name)
    select md5(random()::text) 
FROM generate_series(1,500000);

INSERT INTO film_attr_type(attr_type_name)
    select md5(random()::text) 
FROM generate_series(1,500000);

INSERT INTO public.film_attr(id_type_attr, attr_name)
    select floor(random()*(16-1+1))+1,
           md5(random()::text)
FROM generate_series(1,500000);

INSERT INTO public.film_values(id_film,id_attr)
    select film.id_film, 1 
FROM film
	LEFT JOIN film_values ON film_values.id_film=film.id_film
WHERE film_values.id_film IS NULL;

UPDATE public.film_values 
SET val_char = 'ну такое', val_date = '2022-08-14'
WHERE MOD(id_film,2) = 0; 
```


# запросы - select.sql
```
SELECT film_name 
FROM film
WHERE film_name like 'b%';


SELECT count(*) 
FROM film_values
WHERE val_date is not null 
      and id_attr=3 
      and val_char = 'ну такое';


SELECT id_type_attr as "Тип атрибута", 
       count(id_type_attr) as "Сколько атрибутов такого типа" 
FROM film_attr
GROUP BY id_type_attr
ORDER BY id_type_attr ASC;


SELECT film_attr.id_type_attr as "Тип атрибута",
	   film_attr_type.attr_type_name as "Название атрибута",
	   count(film_attr.id_type_attr) as "Сколько атрибутов такого типа" 
FROM film_attr
    JOIN film_attr_type ON film_attr.id_type_attr = film_attr_type.id_type_attr
GROUP BY film_attr.id_type_attr, film_attr_type.attr_type_name
ORDER BY film_attr.id_type_attr ASC; 



SELECT film.film_name AS "Фильм",
film_attr_type.attr_type_name AS "Тип атрибута",
film_attr.attr_name AS "Атрибут",
    CASE
        WHEN film_values.val_int IS NOT NULL THEN film_values.val_int::text
        WHEN film_values.val_char IS NOT NULL THEN film_values.val_char::text
        WHEN film_values.val_date IS NOT NULL THEN film_values.val_date::text
        WHEN film_values.val_boolean IS NOT NULL THEN film_values.val_boolean::text
        WHEN film_values.val_float IS NOT NULL THEN film_values.val_float::text
        ELSE NULL::text
    END AS "Значение"
FROM film
    JOIN film_values ON film.id_film = film_values.id_film
    JOIN film_attr ON film_attr.id_attr = film_values.id_attr
    JOIN film_attr_type ON film_attr_type.id_type_attr = film_attr.id_type_attr
WHERE film_values.val_char != 'ну такое' and film.film_name like 'c%3%'
ORDER BY film.film_name, film_attr_type.attr_type_name, film_attr.attr_name;


SELECT film.film_name AS "Фильм",
film_attr_type.attr_type_name AS "Задача",
film_values.val_date AS "Дата задачи"
FROM film
    JOIN film_values ON film.id_film = film_values.id_film
    JOIN film_attr ON film_attr.id_attr = film_values.id_attr
    JOIN film_attr_type ON film_attr_type.id_type_attr = film_attr.id_type_attr
WHERE film_values.val_date >= to_date('2014', 'YYYY') and film_values.val_date <  to_date('2023', 'YYYY')
ORDER BY film_values.val_date, film.film_name;
```



# запрос #1 
```
SELECT film_name 
FROM film
WHERE film_name like 'b%';

           film_name
----------------------------------
 b000103788879231ca2f471cd765c411
 b00089e6c84e91d71ad1c60d4e00da22
 b0009f942d802a0bb147e63d3796e9b3
 b0009fb9a6fa32342a6210c1ad5fded8
 b000d318ef4ed713352fd1f877b9aba2
.................................


    # explain на 10 000 строках
    "Seq Scan on film  (cost=0.00..231.91 rows=10215 width=32)"
    "  Filter: ((film_name)::text ~~ 'b%'::text)"

    # explain analyse на 10 000 строках
    "Seq Scan on film  (cost=0.00..231.91 rows=10215 width=32) (actual time=0.012..2.489 rows=9686 loops=1)"
    "  Filter: ((film_name)::text ~~ 'b%'::text)"
    "  Rows Removed by Filter: 1427"
    "Planning Time: 0.062 ms"
    "Execution Time: 3.046 ms"

    # explain на 500 000 строках
    "Seq Scan on film  (cost=0.00..10648.91 rows=443997 width=33)"
    "  Filter: ((film_name)::text ~~ 'b%'::text)"


    # explain analyse на 500 000 строках
    "Seq Scan on film  (cost=0.00..10648.91 rows=443997 width=33) (actual time=0.013..133.985 rows=446510 loops=1)"
    "  Filter: ((film_name)::text ~~ 'b%'::text)"
    "  Rows Removed by Filter: 64603"
    "Planning Time: 0.079 ms"
    "Execution Time: 161.522 ms"

#Вариант оптимизации
#Сделать индекс на поле с названием
#Так как база у меня для текстовых полей использует формат UTF-8, 
#чтобы он корректно работал, надо при создании индекса в таких случаях 
#использовать класс оператора text_pattern_ops:

    CREATE INDEX index_film_name_utf8 ON film(film_name text_pattern_ops);
    
    # explain на 500 000 строках
    "Index Only Scan using index_film_name_utf8 on film  (cost=0.42..1821.46 rows=36139 width=33)"
    "  Index Cond: ((film_name ~>=~ 'b'::text) AND (film_name ~<~ 'c'::text))"
    "  Filter: ((film_name)::text ~~ 'b%'::text)"
```

# запрос #2
```
SELECT count(*) 
FROM film_values
WHERE val_date is not null 
      and id_attr=3 
      and val_char = 'ну такое';

count
-------
1644

    # explain на 10 000 строках
    "Aggregate  (cost=283.57..283.58 rows=1 width=8)"
    "  ->  Seq Scan on film_values  (cost=0.00..281.51 rows=824 width=0)"
    "        Filter: ((val_date IS NOT NULL) AND (id_attr = 3) AND ((val_char)::text = 'ну такое'::text))"

    # explain analyse на 10 000 строках
    "Finalize Aggregate  (cost=8867.72..8867.73 rows=1 width=8)"
    "  ->  Gather  (cost=8867.50..8867.71 rows=2 width=8)"
    "        Workers Planned: 2"
    "        ->  Partial Aggregate  (cost=7867.50..7867.51 rows=1 width=8)"
    "              ->  Parallel Seq Scan on film_values  (cost=0.00..7866.63 rows=348 width=0)"
    "                    Filter: ((val_date IS NOT NULL) AND (id_attr = 3) AND ((val_char)::text = 'ну такое'::text))"

    # explain на 500 000 строках
    "Finalize Aggregate  (cost=8867.72..8867.73 rows=1 width=8)"
    "  ->  Gather  (cost=8867.50..8867.71 rows=2 width=8)"
    "        Workers Planned: 2"
    "        ->  Partial Aggregate  (cost=7867.50..7867.51 rows=1 width=8)"
    "              ->  Parallel Seq Scan on film_values  (cost=0.00..7866.63 rows=348 width=0)"
    "                    Filter: ((val_date IS NOT NULL) AND (id_attr = 3) AND ((val_char)::text = 'ну такое'::text))"

    # explain analyse на 500 000 строках
    "Finalize Aggregate  (cost=8867.72..8867.73 rows=1 width=8) (actual time=72.947..76.785 rows=1 loops=1)"
    "  ->  Gather  (cost=8867.50..8867.71 rows=2 width=8) (actual time=72.657..76.769 rows=3 loops=1)"
    "        Workers Planned: 2"
    "        Workers Launched: 2"
    "        ->  Partial Aggregate  (cost=7867.50..7867.51 rows=1 width=8) (actual time=31.473..31.476 rows=1 loops=3)"
    "              ->  Parallel Seq Scan on film_values  (cost=0.00..7866.63 rows=348 width=0) (actual time=21.527..31.416 rows=548 loops=3)"
    "                    Filter: ((val_date IS NOT NULL) AND (id_attr = 3) AND ((val_char)::text = 'ну такое'::text))"
    "                    Rows Removed by Filter: 169832"
    "Planning Time: 0.261 ms"
    "Execution Time: 77.008 ms" 
        
#Вариант оптимизации
Создать частичный индекс для строк, где есть атрибут 3-его типа (рецензия средняя)

    CREATE INDEX index_medium_kino ON film_values (val_char)
    WHERE id_attr=3;

    # explain на 500 000 строках
    "Aggregate  (cost=87.61..87.62 rows=1 width=8)"
    "  ->  Index Scan using index_medium_kino on film_values  (cost=0.28..85.47 rows=857 width=0)"
    "        Index Cond: ((val_char)::text = 'ну такое'::text)"
    "        Filter: (val_date IS NOT NULL)"

#Можно подогнать индекс уж совсем по задачу:

    CREATE INDEX index_medium_kino ON film_values (val_char)
    WHERE id_attr=3 and val_char = 'ну такое';

#И это дает преимущество в скорости:

    # explain на 500 000 строках
    "Aggregate  (cost=62.92..62.93 rows=1 width=8)"
    "  ->  Index Scan using index_medium_kino on film_values  (cost=0.28..60.78 rows=857 width=0)"
    "        Filter: (val_date IS NOT NULL)"
    
#Но это уже какой то не реалистичный индекс, это подгонять задачу под решение мне кажется.
#Так можно каждый индекс делать под запрос, но для БД это же редкоиспользуемый индекс получится
#по итогу и только место займет.     
```

# запрос #3
```
SELECT id_type_attr as "Тип атрибута", 
       count(id_type_attr) as "Сколько атрибутов такого типа" 
FROM film_attr
GROUP BY id_type_attr
ORDER BY id_type_attr ASC;


Тип атрибута | Сколько атрибутов такого типа
--------------+-------------------------------
            1 |                         31819
            2 |                         31958
            3 |                         31847
            4 |                         31773
            5 |                         31788
            6 |                         31773
            7 |                         31818
            8 |                         32045
            9 |                         32044
           10 |                         31999
           11 |                         31687
           12 |                         31858
           13 |                         31659
           14 |                         31976
           15 |                         32183
           16 |                         31809
           
    # explain на 10 000 строках
    "Sort  (cost=245.02..245.06 rows=16 width=12)"
    "  Sort Key: id_type_attr"
    "  ->  HashAggregate  (cost=244.54..244.70 rows=16 width=12)"
    "        Group Key: id_type_attr"
    "        ->  Seq Scan on film_attr  (cost=0.00..194.36 rows=10036 width=4)"

    # explain analyse на 10 000 строках
    "Sort  (cost=245.02..245.06 rows=16 width=12) (actual time=4.834..4.837 rows=16 loops=1)"
    "  Sort Key: id_type_attr"
    "  Sort Method: quicksort  Memory: 25kB"
    "  ->  HashAggregate  (cost=244.54..244.70 rows=16 width=12) (actual time=4.811..4.817 rows=16 loops=1)"
    "        Group Key: id_type_attr"
    "        Batches: 1  Memory Usage: 24kB"
    "        ->  Seq Scan on film_attr  (cost=0.00..194.36 rows=10036 width=4) (actual time=0.010..1.083 rows=10036 loops=1)"
    "Planning Time: 0.076 ms"
    "Execution Time: 4.932 ms"

    # explain на 500 000 строках
    "Finalize GroupAggregate  (cost=8955.23..8959.28 rows=16 width=12)"
    "  Group Key: id_type_attr"
    "  ->  Gather Merge  (cost=8955.23..8958.96 rows=32 width=12)"
    "        Workers Planned: 2"
    "        ->  Sort  (cost=7955.20..7955.24 rows=16 width=12)"
    "              Sort Key: id_type_attr"
    "              ->  Partial HashAggregate  (cost=7954.73..7954.89 rows=16 width=12)"
    "                    Group Key: id_type_attr"
    "                    ->  Parallel Seq Scan on film_attr  (cost=0.00..6892.15 rows=212515 width=4)"

    # explain analyse на 500 000 строках
    "Finalize GroupAggregate  (cost=8955.23..8959.28 rows=16 width=12) (actual time=145.865..149.145 rows=16 loops=1)"
    "  Group Key: id_type_attr"
    "  ->  Gather Merge  (cost=8955.23..8958.96 rows=32 width=12) (actual time=145.856..149.123 rows=48 loops=1)"
    "        Workers Planned: 2"
    "        Workers Launched: 2"
    "        ->  Sort  (cost=7955.20..7955.24 rows=16 width=12) (actual time=107.844..107.849 rows=16 loops=3)"
    "              Sort Key: id_type_attr"
    "              Sort Method: quicksort  Memory: 25kB"
    "              Worker 0:  Sort Method: quicksort  Memory: 25kB"
    "              Worker 1:  Sort Method: quicksort  Memory: 25kB"
    "              ->  Partial HashAggregate  (cost=7954.73..7954.89 rows=16 width=12) (actual time=107.155..107.160 rows=16 loops=3)"
    "                    Group Key: id_type_attr"
    "                    Batches: 1  Memory Usage: 24kB"
    "                    Worker 0:  Batches: 1  Memory Usage: 24kB"
    "                    Worker 1:  Batches: 1  Memory Usage: 24kB"
    "                    ->  Parallel Seq Scan on film_attr  (cost=0.00..6892.15 rows=212515 width=4) (actual time=0.066..35.438 rows=170012 loops=3)"
    "Planning Time: 0.129 ms"
    "Execution Time: 149.235 ms"
    
    
# Вариант оптимизации
#Как и в первом запросе сделать индекс по колонке с типом атрибута, только тут цифра, а там был текст.
    
    CREATE INDEX index_id_type_attr ON film_attr(id_type_attr);
    
    # explain на 500 000 строках
    "Finalize GroupAggregate  (cost=1000.45..8486.52 rows=16 width=12)"
    "  Group Key: id_type_attr"
    "  ->  Gather Merge  (cost=1000.45..8486.20 rows=32 width=12)"
    "        Workers Planned: 2"
    "        ->  Partial GroupAggregate  (cost=0.42..7482.49 rows=16 width=12)"
    "              Group Key: id_type_attr"
    "              ->  Parallel Index Only Scan using index_id_type_attr on film_attr  (cost=0.42..6419.75 rows=212515 width=4)"
```


# запрос #4
```
SELECT film_attr.id_type_attr as "Тип атрибута",
	   film_attr_type.attr_type_name as "Название атрибута",
	   count(film_attr.id_type_attr) as "Сколько атрибутов такого типа" 
FROM film_attr
    JOIN film_attr_type ON film_attr.id_type_attr = film_attr_type.id_type_attr
GROUP BY film_attr.id_type_attr, film_attr_type.attr_type_name
ORDER BY film_attr.id_type_attr ASC;


Тип атрибута |        Название атрибута         | Сколько атрибутов такого типа
--------------+----------------------------------+-------------------------------
            1 | ЁхЎхэчшш                         |                         31819
            2 | эруЁрф√                          |                         31958
            3 | трцэ√х фрЄ√                      |                         31847
            4 | ёыєцхсэ√х фрЄ√                   |                         31773
            5 | чЁшЄхыхщ                         |                         31788
            6 | ёсюЁ√                            |                         31773
            7 | c1c333876d0e9e7df3458de5022b3bfe |                         31818
            8 | 3efd0f93adbaf030b6253e7b53bded12 |                         32045
            9 | fcf7940490bff2d0dc8da3438c6a1d5a |                         32044
           10 | 33dd2d36150c5757543f7ea1d08c81f6 |                         31999
           11 | 67c265f9e38987b9a025a57949b8aa5c |                         31687
           12 | 0c300a19ca44e24a04bb6aaa6138070d |                         31858
           13 | 6a0bac7b9ba4b01eb39577b57ff6c4db |                         31659
           14 | 3481ce9765cbbb202a559e673bae733d |                         31976
           15 | 3314b470ac5edf638ed58d4804e717e5 |                         32183
           16 | bb3392c1a1c9503f815d063e74d1dc8c |                         31809

    # explain на 10 000 строках
    "GroupAggregate  (cost=1118.19..1318.91 rows=10036 width=44)"
    "  Group Key: film_attr.id_type_attr, film_attr_type.attr_type_name"
    "  ->  Sort  (cost=1118.19..1143.28 rows=10036 width=36)"
    "        Sort Key: film_attr.id_type_attr, film_attr_type.attr_type_name"
    "        ->  Nested Loop  (cost=0.30..451.15 rows=10036 width=36)"
    "              ->  Seq Scan on film_attr  (cost=0.00..194.36 rows=10036 width=4)"
    "              ->  Memoize  (cost=0.30..0.36 rows=1 width=36)"
    "                    Cache Key: film_attr.id_type_attr"
    "                    Cache Mode: logical"
    "                    ->  Index Scan using ""PK_id_type_attr"" on film_attr_type  (cost=0.29..0.35 rows=1 width=36)"
    "                          Index Cond: (id_type_attr = film_attr.id_type_attr)"

    
    # explain analyse на 10 000 строках
    "  ->  Sort  (cost=1118.19..1143.28 rows=10036 width=36) (actual time=11.325..12.894 rows=10036 loops=1)"
    "        Sort Key: film_attr.id_type_attr, film_attr_type.attr_type_name"
    "        Sort Method: quicksort  Memory: 1149kB"
    "        ->  Nested Loop  (cost=0.30..451.15 rows=10036 width=36) (actual time=0.019..8.411 rows=10036 loops=1)"
    "              ->  Seq Scan on film_attr  (cost=0.00..194.36 rows=10036 width=4) (actual time=0.006..1.167 rows=10036 loops=1)"
    "              ->  Memoize  (cost=0.30..0.36 rows=1 width=36) (actual time=0.000..0.000 rows=1 loops=10036)"
    "                    Cache Key: film_attr.id_type_attr"
    "                    Cache Mode: logical"
    "                    Hits: 10020  Misses: 16  Evictions: 0  Overflows: 0  Memory Usage: 3kB"
    "                    ->  Index Scan using ""PK_id_type_attr"" on film_attr_type  (cost=0.29..0.35 rows=1 width=36) (actual time=0.002..0.002 rows=1 loops=16)"
    "                          Index Cond: (id_type_attr = film_attr.id_type_attr)"
    "Planning Time: 0.202 ms"
    "Execution Time: 16.908 ms"

    # explain на 500 000 строках
    "GroupAggregate  (cost=84926.00..95126.72 rows=510036 width=45)"
    "  Group Key: film_attr.id_type_attr, film_attr_type.attr_type_name"
    "  ->  Sort  (cost=84926.00..86201.09 rows=510036 width=37)"
    "        Sort Key: film_attr.id_type_attr, film_attr_type.attr_type_name"
    "        ->  Nested Loop  (cost=0.43..22626.47 rows=510036 width=37)"
    "              ->  Seq Scan on film_attr  (cost=0.00..9867.36 rows=510036 width=4)"
    "              ->  Memoize  (cost=0.43..0.49 rows=1 width=37)"
    "                    Cache Key: film_attr.id_type_attr"
    "                    Cache Mode: logical"
    "                    ->  Index Scan using ""PK_id_type_attr"" on film_attr_type  (cost=0.42..0.48 rows=1 width=37)"
    "                          Index Cond: (id_type_attr = film_attr.id_type_attr)"

    # explain analyse на 500 000 строках
    "GroupAggregate  (cost=84926.00..95126.72 rows=510036 width=45) (actual time=894.065..1208.399 rows=16 loops=1)"
    "  Group Key: film_attr.id_type_attr, film_attr_type.attr_type_name"
    "  ->  Sort  (cost=84926.00..86201.09 rows=510036 width=37) (actual time=873.193..1023.534 rows=510036 loops=1)"
    "        Sort Key: film_attr.id_type_attr, film_attr_type.attr_type_name"
    "        Sort Method: external merge  Disk: 20792kB"
    "        ->  Nested Loop  (cost=0.43..22626.47 rows=510036 width=37) (actual time=0.339..544.487 rows=510036 loops=1)"
    "              ->  Seq Scan on film_attr  (cost=0.00..9867.36 rows=510036 width=4) (actual time=0.019..103.482 rows=510036 loops=1)"
    "              ->  Memoize  (cost=0.43..0.49 rows=1 width=37) (actual time=0.000..0.000 rows=1 loops=510036)"
    "                    Cache Key: film_attr.id_type_attr"
    "                    Cache Mode: logical"
    "                    Hits: 510020  Misses: 16  Evictions: 0  Overflows: 0  Memory Usage: 3kB"
    "                    ->  Index Scan using ""PK_id_type_attr"" on film_attr_type  (cost=0.42..0.48 rows=1 width=37) (actual time=0.020..0.020 rows=1 loops=16)"
    "                          Index Cond: (id_type_attr = film_attr.id_type_attr)"
    "Planning Time: 3.426 ms"
    "Execution Time: 1213.774 ms"


#Вариант оптимизации
#Для "III simple" запроса сделал index index_id_type_attr он помог и тут для запроса из нескольких таблиц
 
    CREATE INDEX index_id_type_attr ON film_attr(id_type_attr);
    
    # explain на 500 000 строках
    "GroupAggregate  (cost=39338.48..56691.26 rows=510036 width=45)"
    "  Group Key: film_attr.id_type_attr, film_attr_type.attr_type_name"
    "  ->  Merge Join  (cost=39338.48..47765.63 rows=510036 width=37)"
    "        Merge Cond: (film_attr_type.id_type_attr = film_attr.id_type_attr)"
    "        ->  Gather Merge  (cost=31993.43..91393.20 rows=510016 width=37)"
    "              Workers Planned: 2"
    "              ->  Sort  (cost=30993.41..31524.68 rows=212507 width=37)"
    "                    Sort Key: film_attr_type.id_type_attr, film_attr_type.attr_type_name"
    "                    ->  Parallel Seq Scan on film_attr_type  (cost=0.00..6376.07 rows=212507 width=37)"
    "        ->  Index Only Scan using index_id_type_attr on film_attr  (cost=0.42..9394.96 rows=510036 width=4)"
```

# запрос #5
```
SELECT film.film_name AS "Фильм",
film_attr_type.attr_type_name AS "Тип атрибута",
film_attr.attr_name AS "Атрибут",
    CASE
        WHEN film_values.val_int IS NOT NULL THEN film_values.val_int::text
        WHEN film_values.val_char IS NOT NULL THEN film_values.val_char::text
        WHEN film_values.val_date IS NOT NULL THEN film_values.val_date::text
        WHEN film_values.val_boolean IS NOT NULL THEN film_values.val_boolean::text
        WHEN film_values.val_float IS NOT NULL THEN film_values.val_float::text
        ELSE NULL::text
    END AS "Значение"
FROM film
    JOIN film_values ON film.id_film = film_values.id_film
    JOIN film_attr ON film_attr.id_attr = film_values.id_attr
    JOIN film_attr_type ON film_attr_type.id_type_attr = film_attr.id_type_attr
WHERE film_values.val_char != 'ну такое' and film.film_name like 'c%3%'
ORDER BY film.film_name, film_attr_type.attr_type_name, film_attr.attr_name;


             Фильм               | Тип атрибута |        Атрибут         | Значение
----------------------------------+--------------+------------------------+----------
 c00036f44d3f38f89c86169dee2ee2e9 | ЁхЎхэчшш     | ЁхЎхэчшш яюыюцшЄхы№э√х | эє Єръюх
 c0006cd83c367b47ae7e702857443f23 | ЁхЎхэчшш     | ЁхЎхэчшш яюыюцшЄхы№э√х | эє Єръюх
 c0006f47f23c92c7189c2a0d93e3ab3e | ЁхЎхэчшш     | ЁхЎхэчшш яюыюцшЄхы№э√х | эє Єръюх
 c000b407bcd683c483a32f5bad22a0bc | ЁхЎхэчшш     | ЁхЎхэчшш яюыюцшЄхы№э√х | эє Єръюх
 c000cb38149ba365445a1c9a100bf2f4 | ЁхЎхэчшш     | ЁхЎхэчшш яюыюцшЄхы№э√х | эє Єръюх
 c00120e421765b3b2a87824816ce58b4 | ЁхЎхэчшш     | ЁхЎхэчшш яюыюцшЄхы№э√х | эє Єръюх
 c0018e316b8a3c7ef133c04b15038a45 | ЁхЎхэчшш     | ЁхЎхэчшш яюыюцшЄхы№э√х | эє Єръюх
 c001b1c67982da36ab0dd87c5decda9f | ЁхЎхэчшш     | ЁхЎхэчшш яюыюцшЄхы№э√х | эє Єръюх
 c001d49a4ffc64657af603f6858b0318 | ЁхЎхэчшш     | ЁхЎхэчшш яюыюцшЄхы№э√х | эє Єръюх
 c001e53692a338dbb69a3bf8e6f90e23 | ЁхЎхэчшш     | ЁхЎхэчшш яюыюцшЄхы№э√х | эє Єръюх
....................................................................................

    # explain на 10 000 строках
    "Sort  (cost=1010.84..1018.94 rows=3240 width=129)"
    "  Sort Key: film.film_name, film_attr_type.attr_type_name, film_attr.attr_name"
    "  ->  Nested Loop  (cost=322.30..821.92 rows=3240 width=129)"
    "        ->  Nested Loop  (cost=322.01..678.31 rows=3240 width=109)"
    "              ->  Hash Join  (cost=321.71..591.29 rows=3240 width=76)"
    "                    Hash Cond: (film_values.id_film = film.id_film)"
    "                    ->  Seq Scan on film_values  (cost=0.00..256.43 rows=5012 width=48)"
    "                          Filter: ((val_char)::text <> 'ну такое'::text)"
    "                    ->  Hash  (cost=231.91..231.91 rows=7184 width=36)"
    "                          ->  Seq Scan on film  (cost=0.00..231.91 rows=7184 width=36)"
    "                                Filter: ((film_name)::text ~~ 'c%3%'::text)"
    "              ->  Memoize  (cost=0.30..0.41 rows=1 width=41)"
    "                    Cache Key: film_values.id_attr"
    "                    Cache Mode: logical"
    "                    ->  Index Scan using ""PK_id_attr"" on film_attr  (cost=0.29..0.40 rows=1 width=41)"
    "                          Index Cond: (id_attr = film_values.id_attr)"
    "        ->  Memoize  (cost=0.30..0.36 rows=1 width=36)"
    "              Cache Key: film_attr.id_type_attr"
    "              Cache Mode: logical"
    "              ->  Index Scan using ""PK_id_type_attr"" on film_attr_type  (cost=0.29..0.35 rows=1 width=36)"
    "                    Index Cond: (id_type_attr = film_attr.id_type_attr)"


    # explain analyse на 10 000 строках
    "Sort  (cost=1010.84..1018.94 rows=3240 width=129) (actual time=28.515..28.848 rows=3000 loops=1)"
    "  Sort Key: film.film_name, film_attr_type.attr_type_name, film_attr.attr_name"
    "  Sort Method: quicksort  Memory: 893kB"
    "  ->  Nested Loop  (cost=322.30..821.92 rows=3240 width=129) (actual time=7.447..21.599 rows=3000 loops=1)"
    "        ->  Nested Loop  (cost=322.01..678.31 rows=3240 width=109) (actual time=7.433..18.153 rows=3000 loops=1)"
    "              ->  Hash Join  (cost=321.71..591.29 rows=3240 width=76) (actual time=7.396..14.258 rows=3000 loops=1)"
    "                    Hash Cond: (film_values.id_film = film.id_film)"
    "                    ->  Seq Scan on film_values  (cost=0.00..256.43 rows=5012 width=48) (actual time=0.016..3.691 rows=5012 loops=1)"
    "                          Filter: ((val_char)::text <> 'ну такое'::text)"
    "                          Rows Removed by Filter: 5022"
    "                    ->  Hash  (cost=231.91..231.91 rows=7184 width=36) (actual time=7.357..7.359 rows=6657 loops=1)"
    "                          Buckets: 8192  Batches: 1  Memory Usage: 533kB"
    "                          ->  Seq Scan on film  (cost=0.00..231.91 rows=7184 width=36) (actual time=0.009..5.010 rows=6657 loops=1)"
    "                                Filter: ((film_name)::text ~~ 'c%3%'::text)"
    "                                Rows Removed by Filter: 4456"
    "              ->  Memoize  (cost=0.30..0.41 rows=1 width=41) (actual time=0.000..0.000 rows=1 loops=3000)"
    "                    Cache Key: film_values.id_attr"
    "                    Cache Mode: logical"
    "                    Hits: 2996  Misses: 4  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "                    ->  Index Scan using ""PK_id_attr"" on film_attr  (cost=0.29..0.40 rows=1 width=41) (actual time=0.008..0.008 rows=1 loops=4)"
    "                          Index Cond: (id_attr = film_values.id_attr)"
    "        ->  Memoize  (cost=0.30..0.36 rows=1 width=36) (actual time=0.000..0.000 rows=1 loops=3000)"
    "              Cache Key: film_attr.id_type_attr"
    "              Cache Mode: logical"
    "              Hits: 2998  Misses: 2  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "              ->  Index Scan using ""PK_id_type_attr"" on film_attr_type  (cost=0.29..0.35 rows=1 width=36) (actual time=0.005..0.006 rows=1 loops=2)"
    "                    Index Cond: (id_type_attr = film_attr.id_type_attr)"
    "Planning Time: 0.949 ms"
    "Execution Time: 29.120 ms"

    # explain на 500 000 строках
    "Gather Merge  (cost=15361.27..15384.61 rows=200 width=131)"
    "  Workers Planned: 2"
    "  ->  Sort  (cost=14361.25..14361.50 rows=100 width=131)"
    "        Sort Key: film.film_name, film_attr_type.attr_type_name, film_attr.attr_name"
    "        ->  Nested Loop  (cost=7359.82..14357.92 rows=100 width=131)"
    "              ->  Nested Loop  (cost=7359.39..14345.52 rows=100 width=127)"
    "                    ->  Parallel Hash Join  (cost=7358.96..14321.76 rows=100 width=94)"
    "                          Hash Cond: (film.id_film = film_values.id_film)"
    "                          ->  Parallel Seq Scan on film  (cost=0.00..6922.05 rows=10756 width=37)"
    "                                Filter: ((film_name)::text ~~ 'c%3%'::text)"
    "                          ->  Parallel Hash  (cost=7334.19..7334.19 rows=1981 width=65)"
    "                                ->  Parallel Seq Scan on film_values  (cost=0.00..7334.19 rows=1981 width=65)"
    "                                      Filter: ((val_char)::text <> 'ну такое'::text)"
    "                    ->  Memoize  (cost=0.43..4.30 rows=1 width=41)"
    "                          Cache Key: film_values.id_attr"
    "                          Cache Mode: logical"
    "                          ->  Index Scan using ""PK_id_attr"" on film_attr  (cost=0.42..4.29 rows=1 width=41)"
    "                                Index Cond: (id_attr = film_values.id_attr)"
    "              ->  Memoize  (cost=0.43..0.49 rows=1 width=37)"
    "                    Cache Key: film_attr.id_type_attr"
    "                    Cache Mode: logical"
    "                    ->  Index Scan using ""PK_id_type_attr"" on film_attr_type  (cost=0.42..0.48 rows=1 width=37)"
    "                          Index Cond: (id_type_attr = film_attr.id_type_attr)"

    # explain analyse на 500 000 строках
    "Gather Merge  (cost=16010.00..16343.92 rows=2862 width=131) (actual time=267.601..284.763 rows=3000 loops=1)"
    "  Workers Planned: 2"
    "  Workers Launched: 2"
    "  ->  Sort  (cost=15009.98..15013.55 rows=1431 width=131) (actual time=203.756..203.930 rows=1000 loops=3)"
    "        Sort Key: film.film_name, film_attr_type.attr_type_name, film_attr.attr_name"
    "        Sort Method: quicksort  Memory: 326kB"
    "        Worker 0:  Sort Method: quicksort  Memory: 275kB"
    "        Worker 1:  Sort Method: quicksort  Memory: 292kB"
    "        ->  Nested Loop  (cost=7362.31..14934.97 rows=1431 width=131) (actual time=104.366..200.686 rows=1000 loops=3)"
    "              ->  Nested Loop  (cost=7361.88..14865.93 rows=1431 width=127) (actual time=104.335..199.799 rows=1000 loops=3)"
    "                    ->  Parallel Hash Join  (cost=7361.44..14813.79 rows=1431 width=94) (actual time=104.279..198.804 rows=1000 loops=3)"
    "                          Hash Cond: (film.id_film = film_values.id_film)"
    "                          ->  Parallel Seq Scan on film  (cost=0.00..6922.05 rows=139825 width=37) (actual time=0.027..109.051 rows=102561 loops=3)"
    "                                Filter: ((film_name)::text ~~ 'c%3%'::text)"
    "                                Rows Removed by Filter: 67810"
    "                          ->  Parallel Hash  (cost=7334.19..7334.19 rows=2180 width=65) (actual time=57.423..57.425 rows=1671 loops=3)"
    "                                Buckets: 8192  Batches: 1  Memory Usage: 480kB"
    "                                ->  Parallel Seq Scan on film_values  (cost=0.00..7334.19 rows=2180 width=65) (actual time=17.498..56.410 rows=1671 loops=3)"
    "                                      Filter: ((val_char)::text <> 'ну такое'::text)"
    "                                      Rows Removed by Filter: 168710"
    "                    ->  Memoize  (cost=0.43..4.10 rows=1 width=41) (actual time=0.000..0.000 rows=1 loops=3000)"
    "                          Cache Key: film_values.id_attr"
    "                          Cache Mode: logical"
    "                          Hits: 1043  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "                          Worker 0:  Hits: 942  Misses: 4  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "                          Worker 1:  Hits: 1005  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "                          ->  Index Scan using ""PK_id_attr"" on film_attr  (cost=0.42..4.09 rows=1 width=41) (actual time=0.016..0.016 rows=1 loops=10)"
    "                                Index Cond: (id_attr = film_values.id_attr)"
    "              ->  Memoize  (cost=0.43..0.49 rows=1 width=37) (actual time=0.000..0.000 rows=1 loops=3000)"
    "                    Cache Key: film_attr.id_type_attr"
    "                    Cache Mode: logical"
    "                    Hits: 1045  Misses: 1  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "                    Worker 0:  Hits: 944  Misses: 2  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "                    Worker 1:  Hits: 1007  Misses: 1  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "                    ->  Index Scan using ""PK_id_type_attr"" on film_attr_type  (cost=0.42..0.48 rows=1 width=37) (actual time=0.018..0.019 rows=1 loops=4)"
    "                          Index Cond: (id_type_attr = film_attr.id_type_attr)"
    "Planning Time: 1.127 ms"
    "Execution Time: 285.115 ms"

#Вариант оптимизации
#Для "I simple" запроса сделал index index_id_type_attr он помог и тут для запроса из нескольких таблиц

    CREATE INDEX index_film_name_utf8 ON film(film_name text_pattern_ops);

    
    # explain на 500 000 строках
   "Gather Merge  (cost=14047.87..14071.20 rows=200 width=131)"
    "  Workers Planned: 2"
    "  ->  Sort  (cost=13047.85..13048.10 rows=100 width=131)"
    "        Sort Key: film.film_name, film_attr_type.attr_type_name, film_attr.attr_name"
    "        ->  Nested Loop  (cost=8550.33..13044.52 rows=100 width=131)"
    "              ->  Nested Loop  (cost=8549.89..13032.12 rows=100 width=127)"
    "                    ->  Parallel Hash Join  (cost=8549.46..13008.36 rows=100 width=94)"
    "                          Hash Cond: (film.id_film = film_values.id_film)"
    "                          ->  Parallel Bitmap Heap Scan on film  (cost=1190.51..5608.65 rows=10756 width=37)"
    "                                Filter: ((film_name)::text ~~ 'c%3%'::text)"
    "                                ->  Bitmap Index Scan on index_film_name_utf8  (cost=0.00..1184.05 rows=30363 width=0)"
    "                                      Index Cond: (((film_name)::text ~>=~ 'c'::text) AND ((film_name)::text ~<~ 'd'::text))"
    "                          ->  Parallel Hash  (cost=7334.19..7334.19 rows=1981 width=65)"
    "                                ->  Parallel Seq Scan on film_values  (cost=0.00..7334.19 rows=1981 width=65)"
    "                                      Filter: ((val_char)::text <> 'ну такое'::text)"
    "                    ->  Memoize  (cost=0.43..4.30 rows=1 width=41)"
    "                          Cache Key: film_values.id_attr"
    "                          Cache Mode: logical"
    "                          ->  Index Scan using ""PK_id_attr"" on film_attr  (cost=0.42..4.29 rows=1 width=41)"
    "                                Index Cond: (id_attr = film_values.id_attr)"
    "              ->  Memoize  (cost=0.43..0.49 rows=1 width=37)"
    "                    Cache Key: film_attr.id_type_attr"

#Если сделать еще дополнительно частичный индекс по значению не равно "ну такое", 
#то в двое сокращает стоимость

    CREATE INDEX index_ne_nu_takoe ON film_values (val_char)
    WHERE val_char != 'ну такое';

    "Sort  (cost=6310.66..6311.26 rows=240 width=131)"
    "  Sort Key: film.film_name, film_attr_type.attr_type_name, film_attr.attr_name"
    "  ->  Nested Loop  (cost=1517.54..6301.17 rows=240 width=131)"
    "        ->  Nested Loop  (cost=1517.10..6282.78 rows=240 width=127)"
    "              ->  Hash Join  (cost=1516.67..6255.41 rows=240 width=94)"
    "                    Hash Cond: (film.id_film = film_values.id_film)"
    "                    ->  Bitmap Heap Scan on film  (cost=1190.51..5830.04 rows=25814 width=37)"
    "                          Filter: ((film_name)::text ~~ 'c%3%'::text)"
    "                          ->  Bitmap Index Scan on index_film_name_utf8  (cost=0.00..1184.05 rows=30363 width=0)"
    "                                Index Cond: (((film_name)::text ~>=~ 'c'::text) AND ((film_name)::text ~<~ 'd'::text))"
    "                    ->  Hash  (cost=266.74..266.74 rows=4754 width=65)"
    "                          ->  Index Scan using index_ne_nu_takoe on film_values  (cost=0.28..266.74 rows=4754 width=65)"
    "              ->  Memoize  (cost=0.43..4.30 rows=1 width=41)"
    "                    Cache Key: film_values.id_attr"
    "                    Cache Mode: logical"
    "                    ->  Index Scan using ""PK_id_attr"" on film_attr  (cost=0.42..4.29 rows=1 width=41)"
```

# запрос #6
```
SELECT film.film_name AS "Фильм",
film_attr_type.attr_type_name AS "Задача",
film_values.val_date AS "Дата задачи"
FROM film
    JOIN film_values ON film.id_film = film_values.id_film
    JOIN film_attr ON film_attr.id_attr = film_values.id_attr
    JOIN film_attr_type ON film_attr_type.id_type_attr = film_attr.id_type_attr
WHERE film_values.val_date >= to_date('2014', 'YYYY') and film_values.val_date <  to_date('2023', 'YYYY')
ORDER BY film_values.val_date, film.film_name;


             Фильм               |   Задача    | Дата задачи
----------------------------------+-------------+-------------
 ╨юъъш                            | трцэ√х фрЄ√ | 2014-02-13
 00001a5dc029054d8df5726293fd816a | ЁхЎхэчшш    | 2022-08-14
 00002e307e6609b8087c8d4424be80c0 | ЁхЎхэчшш    | 2022-08-14
 00004e0815fe54499ea39a6368868d6c | ЁхЎхэчшш    | 2022-08-14
 000081b140ecf82a796187fb3d74fb0e | ЁхЎхэчшш    | 2022-08-14
 0000ab57d7fb42e8190096ee5a187ffa | ЁхЎхэчшш    | 2022-08-14
 00013ec41eeba478229e95ed25b27f46 | ЁхЎхэчшш    | 2022-08-14
 00015f8b715670185f23fb1993fd392d | ЁхЎхэчшш    | 2022-08-14
 00017036db69f5d8c40d48d4a0909301 | ЁхЎхэчшш    | 2022-08-14
 000189b1155281e925b29f16424e4911 | ЁхЎхэчшш    | 2022-08-14
 ...........................................................
 
    # explain на 10 000 строках
    "Sort  (cost=1258.77..1271.31 rows=5015 width=68)"
    "  Sort Key: film_values.val_date, film.film_name"
    "  ->  Nested Loop  (cost=343.63..950.55 rows=5015 width=68)"
    "        ->  Nested Loop  (cost=343.34..819.28 rows=5015 width=40)"
    "              ->  Hash Join  (cost=343.04..687.89 rows=5015 width=40)"
    "                    Hash Cond: (film_values.id_film = film.id_film)"
    "                    ->  Seq Scan on film_values  (cost=0.00..331.68 rows=5015 width=12)"
    "                          Filter: ((val_date >= to_date('2014'::text, 'YYYY'::text)) AND (val_date < to_date('2023'::text, 'YYYY'::text)))"
    "                    ->  Hash  (cost=204.13..204.13 rows=11113 width=36)"
    "                          ->  Seq Scan on film  (cost=0.00..204.13 rows=11113 width=36)"
    "              ->  Memoize  (cost=0.30..0.41 rows=1 width=8)"
    "                    Cache Key: film_values.id_attr"
    "                    Cache Mode: logical"
    "                    ->  Index Scan using ""PK_id_attr"" on film_attr  (cost=0.29..0.40 rows=1 width=8)"
    "                          Index Cond: (id_attr = film_values.id_attr)"
    "        ->  Memoize  (cost=0.30..0.36 rows=1 width=36)"
    "              Cache Key: film_attr.id_type_attr"
    "              Cache Mode: logical"
    "              ->  Index Scan using ""PK_id_type_attr"" on film_attr_type  (cost=0.29..0.35 rows=1 width=36)"
    "                    Index Cond: (id_type_attr = film_attr.id_type_attr)"

    # explain analyse на 10 000 строках
    "Sort  (cost=1258.77..1271.31 rows=5015 width=68) (actual time=60.722..61.536 rows=5014 loops=1)"
    "  Sort Key: film_values.val_date, film.film_name"
    "  Sort Method: quicksort  Memory: 897kB"
    "  ->  Nested Loop  (cost=343.63..950.55 rows=5015 width=68) (actual time=8.633..41.439 rows=5014 loops=1)"
    "        ->  Nested Loop  (cost=343.34..819.28 rows=5015 width=40) (actual time=8.606..35.096 rows=5014 loops=1)"
    "              ->  Hash Join  (cost=343.04..687.89 rows=5015 width=40) (actual time=8.571..27.957 rows=5014 loops=1)"
    "                    Hash Cond: (film_values.id_film = film.id_film)"
    "                    ->  Seq Scan on film_values  (cost=0.00..331.68 rows=5015 width=12) (actual time=0.021..14.509 rows=5014 loops=1)"
    "                          Filter: ((val_date >= to_date('2014'::text, 'YYYY'::text)) AND (val_date < to_date('2023'::text, 'YYYY'::text)))"
    "                          Rows Removed by Filter: 5020"
    "                    ->  Hash  (cost=204.13..204.13 rows=11113 width=36) (actual time=8.527..8.530 rows=11113 loops=1)"
    "                          Buckets: 16384  Batches: 1  Memory Usage: 910kB"
    "                          ->  Seq Scan on film  (cost=0.00..204.13 rows=11113 width=36) (actual time=0.005..3.770 rows=11113 loops=1)"
    "              ->  Memoize  (cost=0.30..0.41 rows=1 width=8) (actual time=0.001..0.001 rows=1 loops=5014)"
    "                    Cache Key: film_values.id_attr"
    "                    Cache Mode: logical"
    "                    Hits: 5006  Misses: 8  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "                    ->  Index Scan using ""PK_id_attr"" on film_attr  (cost=0.29..0.40 rows=1 width=8) (actual time=0.008..0.008 rows=1 loops=8)"
    "                          Index Cond: (id_attr = film_values.id_attr)"
    "        ->  Memoize  (cost=0.30..0.36 rows=1 width=36) (actual time=0.000..0.000 rows=1 loops=5014)"
    "              Cache Key: film_attr.id_type_attr"
    "              Cache Mode: logical"
    "              Hits: 5010  Misses: 4  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "              ->  Index Scan using ""PK_id_type_attr"" on film_attr_type  (cost=0.29..0.35 rows=1 width=36) (actual time=0.008..0.008 rows=1 loops=4)"
    "                    Index Cond: (id_type_attr = film_attr.id_type_attr)"
    "Planning Time: 0.990 ms"
    "Execution Time: 62.016 ms"


    # explain на 500 000 строках
    "Gather Merge  (cost=41869.36..66728.10 rows=213060 width=70)"
    "  Workers Planned: 2"
    "  ->  Sort  (cost=40869.34..41135.66 rows=106530 width=70)"
    "        Sort Key: film_values.val_date, film.film_name"
    "        ->  Nested Loop  (cost=10785.00..27602.11 rows=106530 width=70)"
    "              ->  Nested Loop  (cost=10784.57..24930.63 rows=106530 width=41)"
    "                    ->  Parallel Hash Join  (cost=10784.13..22265.24 rows=106530 width=41)"
    "                          Hash Cond: (film.id_film = film_values.id_film)"
    "                          ->  Parallel Seq Scan on film  (cost=0.00..6389.64 rows=212964 width=37)"
    "                          ->  Parallel Hash  (cost=8931.51..8931.51 rows=106530 width=12)"
    "                                ->  Parallel Seq Scan on film_values  (cost=0.00..8931.51 rows=106530 width=12)"
    "                                      Filter: ((val_date >= to_date('2014'::text, 'YYYY'::text)) AND (val_date < to_date('2023'::text, 'YYYY'::text)))"
    "                    ->  Memoize  (cost=0.43..0.55 rows=1 width=8)"
    "                          Cache Key: film_values.id_attr"
    "                          Cache Mode: logical"
    "                          ->  Index Scan using ""PK_id_attr"" on film_attr  (cost=0.42..0.54 rows=1 width=8)"
    "                                Index Cond: (id_attr = film_values.id_attr)"
    "              ->  Memoize  (cost=0.43..0.49 rows=1 width=37)"
    "                    Cache Key: film_attr.id_type_attr"
    "                    Cache Mode: logical"
    "                    ->  Index Scan using ""PK_id_type_attr"" on film_attr_type  (cost=0.42..0.48 rows=1 width=37)"
    "                          Index Cond: (id_type_attr = film_attr.id_type_attr)"


    # explain analyse на 500 000 строках
    "Gather Merge  (cost=41869.36..66728.10 rows=213060 width=70) (actual time=1091.704..1442.426 rows=255567 loops=1)"
    "  Workers Planned: 2"
    "  Workers Launched: 2"
    "  ->  Sort  (cost=40869.34..41135.66 rows=106530 width=70) (actual time=1028.086..1111.943 rows=85189 loops=3)"
    "        Sort Key: film_values.val_date, film.film_name"
    "        Sort Method: external merge  Disk: 5240kB"
    "        Worker 0:  Sort Method: external merge  Disk: 5808kB"
    "        Worker 1:  Sort Method: external merge  Disk: 5528kB"
    "        ->  Nested Loop  (cost=10785.00..27602.11 rows=106530 width=70) (actual time=345.824..631.305 rows=85189 loops=3)"
    "              ->  Nested Loop  (cost=10784.57..24930.63 rows=106530 width=41) (actual time=345.805..555.240 rows=85189 loops=3)"
    "                    ->  Parallel Hash Join  (cost=10784.13..22265.24 rows=106530 width=41) (actual time=345.763..475.690 rows=85189 loops=3)"
    "                          Hash Cond: (film.id_film = film_values.id_film)"
    "                          ->  Parallel Seq Scan on film  (cost=0.00..6389.64 rows=212964 width=37) (actual time=0.132..44.231 rows=170371 loops=3)"
    "                          ->  Parallel Hash  (cost=8931.51..8931.51 rows=106530 width=12) (actual time=209.634..209.636 rows=85189 loops=3)"
    "                                Buckets: 131072  Batches: 8  Memory Usage: 2560kB"
    "                                ->  Parallel Seq Scan on film_values  (cost=0.00..8931.51 rows=106530 width=12) (actual time=18.878..161.188 rows=85189 loops=3)"
    "                                      Filter: ((val_date >= to_date('2014'::text, 'YYYY'::text)) AND (val_date < to_date('2023'::text, 'YYYY'::text)))"
    "                                      Rows Removed by Filter: 85191"
    "                    ->  Memoize  (cost=0.43..0.55 rows=1 width=8) (actual time=0.000..0.000 rows=1 loops=255567)"
    "                          Cache Key: film_values.id_attr"
    "                          Cache Mode: logical"
    "                          Hits: 80759  Misses: 4  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "                          Worker 0:  Hits: 89570  Misses: 4  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "                          Worker 1:  Hits: 85223  Misses: 7  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "                          ->  Index Scan using ""PK_id_attr"" on film_attr  (cost=0.42..0.54 rows=1 width=8) (actual time=0.014..0.014 rows=1 loops=15)"
    "                                Index Cond: (id_attr = film_values.id_attr)"
    "              ->  Memoize  (cost=0.43..0.49 rows=1 width=37) (actual time=0.000..0.000 rows=1 loops=255567)"
    "                    Cache Key: film_attr.id_type_attr"
    "                    Cache Mode: logical"
    "                    Hits: 80761  Misses: 2  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "                    Worker 0:  Hits: 89572  Misses: 2  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "                    Worker 1:  Hits: 85227  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
    "                    ->  Index Scan using ""PK_id_type_attr"" on film_attr_type  (cost=0.42..0.48 rows=1 width=37) (actual time=0.012..0.012 rows=1 loops=7)"
    "                          Index Cond: (id_type_attr = film_attr.id_type_attr)"
    "Planning Time: 1.701 ms"
    "Execution Time: 1462.023 ms"

#Вариант оптимизации
#Вариант создать индекс по полю дата

    CREATE INDEX index_film_date ON film_values (val_date);

#Незначительно убыстрило
 
    # explain analyse на 500 000 строках
    "Gather Merge  (cost=39627.70..64360.66 rows=211982 width=70)"
    "  Workers Planned: 2"
    "  ->  Sort  (cost=38627.67..38892.65 rows=105991 width=70)"
    "        Sort Key: film_values.val_date, film.film_name"
    "        ->  Nested Loop  (cost=8644.87..25430.32 rows=105991 width=70)"
    "              ->  Nested Loop  (cost=8644.44..22772.32 rows=105991 width=41)"
    "                    ->  Parallel Hash Join  (cost=8644.00..20119.87 rows=105991 width=41)"
    "                          Hash Cond: (film.id_film = film_values.id_film)"
    "                          ->  Parallel Seq Scan on film  (cost=0.00..6389.64 rows=212964 width=37)"
    "                          ->  Parallel Hash  (cost=6801.12..6801.12 rows=105991 width=12)"
    "                                ->  Parallel Index Scan using index_film_date on film_values  (cost=0.43..6801.12 rows=105991 width=12)"
    "                                      Index Cond: ((val_date >= to_date('2014'::text, 'YYYY'::text)) AND (val_date < to_date('2023'::text, 'YYYY'::text)))"
    "                    ->  Memoize  (cost=0.43..0.55 rows=1 width=8)"
    "                          Cache Key: film_values.id_attr"
    "                          Cache Mode: logical"
    "                          ->  Index Scan using ""PK_id_attr"" on film_attr  (cost=0.42..0.54 rows=1 width=8)"
    "                                Index Cond: (id_attr = film_values.id_attr)"
    "              ->  Memoize  (cost=0.43..0.49 rows=1 width=37)"
    "                    Cache Key: film_attr.id_type_attr"
    "                    Cache Mode: logical"
    "                    ->  Index Scan using ""PK_id_type_attr"" on film_attr_type  (cost=0.42..0.48 rows=1 width=37)"
    "                          Index Cond: (id_type_attr = film_attr.id_type_attr)"

#Тогда для ускорения этого запроса можно сделать индекс по датам, которые от 2014 и новее.

    CREATE INDEX index_film_date_ot_2014 ON film_values (val_date)
    WHERE val_date >= '2014-01-01';

    # explain analyse на 500 000 строках
    "Sort  (cost=6310.66..6311.26 rows=240 width=131)"
    "  Sort Key: film.film_name, film_attr_type.attr_type_name, film_attr.attr_name"
    "  ->  Nested Loop  (cost=1517.54..6301.17 rows=240 width=131)"
    "        ->  Nested Loop  (cost=1517.10..6282.78 rows=240 width=127)"
    "              ->  Hash Join  (cost=1516.67..6255.41 rows=240 width=94)"
    "                    Hash Cond: (film.id_film = film_values.id_film)"
    "                    ->  Bitmap Heap Scan on film  (cost=1190.51..5830.04 rows=25814 width=37)"
    "                          Filter: ((film_name)::text ~~ 'c%3%'::text)"
    "                          ->  Bitmap Index Scan on index_film_name_utf8  (cost=0.00..1184.05 rows=30363 width=0)"
    "                                Index Cond: (((film_name)::text ~>=~ 'c'::text) AND ((film_name)::text ~<~ 'd'::text))"
    "                    ->  Hash  (cost=266.74..266.74 rows=4754 width=65)"
    "                          ->  Index Scan using index_ne_nu_takoe on film_values  (cost=0.28..266.74 rows=4754 width=65)"
    "              ->  Memoize  (cost=0.43..4.30 rows=1 width=41)"
    "                    Cache Key: film_values.id_attr"
    "                    Cache Mode: logical"
    "                    ->  Index Scan using ""PK_id_attr"" on film_attr  (cost=0.42..4.29 rows=1 width=41)"
    "                          Index Cond: (id_attr = film_values.id_attr)"
    "        ->  Memoize  (cost=0.43..0.49 rows=1 width=37)"
    "              Cache Key: film_attr.id_type_attr"
    "              Cache Mode: logical"
    "              ->  Index Scan using ""PK_id_type_attr"" on film_attr_type  (cost=0.42..0.48 rows=1 width=37)"
    "                    Index Cond: (id_type_attr = film_attr.id_type_attr)"
```

# отсортированный список (15 значений) самых больших по размеру объектов БД 
(таблицы, включая индексы, сами индексы)
```
SELECT
    nspname || '.' || relname  AS name,
    pg_size_pretty(pg_total_relation_size(c.oid)) AS totalsize,
    pg_size_pretty(pg_relation_size(c.oid)) AS relsize
FROM pg_class C
    LEFT JOIN pg_namespace N ON N.oid = C.relnamespace
WHERE
    nspname NOT IN ('pg_catalog', 'information_schema')
ORDER BY pg_total_relation_size(c.oid) DESC
LIMIT 15;


"public.film"	                        "158 MB"	"33 MB"
"public.film_attr"	                "112 MB"	"37 MB"
"public.film_attr_type"	                "105 MB"	"33 MB"
"public.PK_id_film"	                "96 MB"	        "96 MB"
"public.film_values"	                "86 MB"	        "37 MB"
"public.UNIQUE_attr_type_name"	        "60 MB"	        "60 MB"
"public.UNIQUE_attr_name"	        "60 MB"	        "60 MB"
"public.index_film_name_utf8"	        "29 MB"	        "29 MB"
"public.PK_id_val"	                "22 MB"	        "22 MB"
"public.index_film_values"	        "22 MB"	        "22 MB"
"public.PK_id_type_attr"	        "11 MB"	        "11 MB"
"public.PK_id_attr"	                "11 MB"	        "11 MB"
"public.index_id_type_attr"	        "3488 kB"	"3488 kB"
"public.index_film_date"	        "3488 kB"	"3488 kB"
"public.index_film_date_ot_2014"	"1760 kB"	"1760 kB"
```


# отсортированные списки используемых индексов (отсортированных по частоте использования)
```
SELECT
    idstat.relname    				        AS table_name,                  -- имя таблицы
    indexrelname    				        AS index_name,                  -- индекс
    idstat.idx_scan    			                AS index_scans_count,           -- число сканирований по этому индексу
    pg_size_pretty(pg_relation_size(indexrelid))        AS index_size,                  -- размер индекса
    tabstat.idx_scan    			        AS table_reads_index_count,     -- индексных чтений по таблице
    tabstat.seq_scan    			        AS table_reads_seq_count,       -- последовательных чтений по таблице
    tabstat.seq_scan + tabstat.idx_scan    	        AS table_reads_count,           -- чтений по таблице
    n_tup_upd + n_tup_ins + n_tup_del    	        AS table_writes_count,          -- операций записи
    pg_size_pretty(pg_relation_size(idstat.relid))      AS table_size                   -- размер таблицы
FROM pg_stat_user_indexes AS idstat
    JOIN pg_indexes ON indexrelname = indexname AND idstat.schemaname = pg_indexes.schemaname
    JOIN pg_stat_user_tables AS tabstat ON idstat.relid = tabstat.relid
WHERE indexdef !~* 'unique'
ORDER BY idstat.idx_scan DESC, pg_relation_size(indexrelid) DESC


"film_attr"	"index_id_type_attr"	        5	"3488 kB"	522426	    61	522487	    510036	"37 MB"
"film_values"	"index_film_date"	        3	"3488 kB"	163	    90	253	    1811764	"37 MB"
"film"	"index_film_name_utf8"	                2	"29 MB"	        22332	    72	522404	    4472280	"33 MB"
"film_values"	"index_medium_kino"	        2	"32 kB"	        163 	    90	253	    1811764	"37 MB"
"film_values"	"index_ne_nu_takoe"	        1	"304 kB"	163	    90	253	    1811764	"37 MB"
"film_values"	"index_film_date_ot_2014"	0	"1760 kB"	163	    90	253	    1811764	"37 MB"
```