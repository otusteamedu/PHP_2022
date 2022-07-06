-------------------------------------ПРОСТОЙ ЗАПРОС 1-------------------------------------------------------------------

-- Список фильмов за определенный день
explain analyse SELECT film.name as "Название", film.description as "Описание", film.duration as "Длительность (мин)", film.price as "Базовая стоимость билета (руб)"
FROM film
WHERE film.date_premier = now()::date;

-- Выполнение запроса без индексов при 10 тыс записей:
-- Seq Scan on film  (cost=0.00..1473.00 rows=25 width=989) (actual time=0.060..3.739 rows=19 loops=1)
--   Filter: (date_premier = (now())::date)
--   Rows Removed by Filter: 9981
-- Planning Time: 0.080 ms
-- Execution Time: 3.759 ms

-- Выполнение запроса без индексов при 1 млн записей
-- Gather  (cost=1000.00..140827.67 rows=2741 width=999) (actual time=6.029..396.124 rows=2733 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Seq Scan on film  (cost=0.00..139553.57 rows=1142 width=999) (actual time=7.751..336.441 rows=911 loops=3)
--         Filter: (date_premier = (now())::date)
--         Rows Removed by Filter: 335756
-- Planning Time: 0.112 ms
-- JIT:
--   Functions: 12
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.915 ms, Inlining 0.000 ms, Optimization 1.572 ms, Emission 19.434 ms, Total 23.921 ms"
-- Execution Time: 397.658 ms

-- Добавлен индекс
create index film_date_premier_index on film using btree (date_premier);

-- Выполнение запроса c индексом при 10 тыс записей:
-- Bitmap Heap Scan on film  (cost=4.48..94.51 rows=25 width=989) (actual time=0.024..0.053 rows=19 loops=1)
--   Recheck Cond: (date_premier = (now())::date)
--   Heap Blocks: exact=19
--   ->  Bitmap Index Scan on film_date_premier_index  (cost=0.00..4.48 rows=25 width=0) (actual time=0.015..0.015 rows=19 loops=1)
--         Index Cond: (date_premier = (now())::date)
-- Planning Time: 0.089 ms
-- Execution Time: 0.074 ms

-- Выполнение запроса c индексом при 1 млн записей
-- Bitmap Heap Scan on film  (cost=33.68..9771.03 rows=2742 width=999) (actual time=0.872..5.013 rows=2733 loops=1)
--   Recheck Cond: (date_premier = (now())::date)
--   Heap Blocks: exact=2703
--   ->  Bitmap Index Scan on film_date_premier_index  (cost=0.00..32.99 rows=2742 width=0) (actual time=0.374..0.374 rows=2733 loops=1)
--         Index Cond: (date_premier = (now())::date)
-- Planning Time: 0.127 ms
-- Execution Time: 5.207 ms


-- ВЫВОД: Добавление индекса film_date_premier_index дало очень ощутимый прирост быстродействия, что при 10 тыс запсией, что при 1 млн
-- С индексом запрос быстрее в 50-70 раз


-------------------------------------ПРОСТОЙ ЗАПРОС 2-------------------------------------------------------------------

-- Список сеансов с повышенным коэффициентом цены (больше 1) за 2 недели
explain analyse SELECT start_timestamp::text, end_timestamp::text
FROM session
WHERE start_timestamp >= '2022-06-01 00:00:00' AND start_timestamp <= '2022-06-14 23:59:00' AND price_ratio > 1;

-- Выполнение запроса без индексов при 10 тыс записей:
-- Seq Scan on session  (cost=0.00..260.74 rows=174 width=64) (actual time=0.031..2.203 rows=168 loops=1)
--   Filter: ((start_timestamp >= '2022-06-01 00:00:00'::timestamp without time zone) AND (start_timestamp <= '2022-06-14 23:59:00'::timestamp without time zone) AND (price_ratio > '1'::numeric))
--   Rows Removed by Filter: 9832
-- Planning Time: 0.119 ms
-- Execution Time: 2.241 ms

-- Выполнение запроса без индексов при 1 млн записей
-- Gather  (cost=1000.00..18538.87 rows=16870 width=64) (actual time=0.320..125.557 rows=17457 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Seq Scan on session  (cost=0.00..15851.87 rows=7029 width=64) (actual time=0.074..76.254 rows=5819 loops=3)
--         Filter: ((start_timestamp >= '2022-06-01 00:00:00'::timestamp without time zone) AND (start_timestamp <= '2022-06-14 23:59:00'::timestamp without time zone) AND (price_ratio > '1'::numeric))
--         Rows Removed by Filter: 330848
-- Planning Time: 0.097 ms
-- Execution Time: 127.306 ms


-- Добавлен индекс
create index session_start_price_ratio_index on session using btree (start_timestamp, price_ratio);

-- Выполнение запроса c индексом при 10 тыс записей:
-- Bitmap Heap Scan on session  (cost=13.15..101.94 rows=174 width=64) (actual time=0.081..0.271 rows=168 loops=1)
--   Recheck Cond: ((start_timestamp >= '2022-06-01 00:00:00'::timestamp without time zone) AND (start_timestamp <= '2022-06-14 23:59:00'::timestamp without time zone) AND (price_ratio > '1'::numeric))
--   Heap Blocks: exact=74
--   ->  Bitmap Index Scan on session_start_price_ratio_index  (cost=0.00..13.11 rows=174 width=0) (actual time=0.062..0.062 rows=168 loops=1)
--         Index Cond: ((start_timestamp >= '2022-06-01 00:00:00'::timestamp without time zone) AND (start_timestamp <= '2022-06-14 23:59:00'::timestamp without time zone) AND (price_ratio > '1'::numeric))
-- Planning Time: 0.128 ms
-- Execution Time: 0.313 ms


-- Выполнение запроса c индексом при 1 млн записей
-- Bitmap Heap Scan on session  (cost=1055.04..9935.97 rows=16870 width=64) (actual time=7.296..28.085 rows=17457 loops=1)
--   Recheck Cond: ((start_timestamp >= '2022-06-01 00:00:00'::timestamp without time zone) AND (start_timestamp <= '2022-06-14 23:59:00'::timestamp without time zone) AND (price_ratio > '1'::numeric))
--   Heap Blocks: exact=7389
--   ->  Bitmap Index Scan on session_start_price_ratio_index  (cost=0.00..1050.83 rows=16870 width=0) (actual time=5.983..5.984 rows=17457 loops=1)
--         Index Cond: ((start_timestamp >= '2022-06-01 00:00:00'::timestamp without time zone) AND (start_timestamp <= '2022-06-14 23:59:00'::timestamp without time zone) AND (price_ratio > '1'::numeric))
-- Planning Time: 0.173 ms
-- Execution Time: 29.053 ms


-- ВЫВОД: Добавление индекса session_start_price_ratio_index дало прирост быстродействия, что при 10 тыс записей, что при 1 млн
-- С индексом запрос быстрее в 4-7 раз

-------------------------------------ПРОСТОЙ ЗАПРОС 3-------------------------------------------------------------------

-- Список отмененных заказов
explain analyse SELECT * FROM orders WHERE status = 'canceled';

-- Выполнение запроса без индексов при 10 тыс записей
-- Seq Scan on orders  (cost=0.00..189.00 rows=2504 width=4) (actual time=0.015..1.123 rows=2504 loops=1)
--   Filter: (status = 'canceled'::enum_status_order)
--   Rows Removed by Filter: 7496
-- Planning Time: 0.087 ms
-- Execution Time: 2.087 ms

-- Выполнение запроса без индексов при 1 млн записей
-- Seq Scan on orders  (cost=0.00..19059.00 rows=247820 width=22) (actual time=0.084..145.919 rows=252023 loops=1)
--   Filter: (status = 'canceled'::enum_status_order)
--   Rows Removed by Filter: 757977
-- Planning Time: 0.130 ms
-- Execution Time: 160.815 ms


-- Добавлен индекс
create index orders_status_index on orders using btree (status);

-- Выполнение запроса c индексом при 10 тыс записей:
-- Bitmap Heap Scan on orders  (cost=31.69..126.99 rows=2504 width=22) (actual time=0.093..0.594 rows=2504 loops=1)
--   Recheck Cond: (status = 'canceled'::enum_status_order)
--   Heap Blocks: exact=64
--   ->  Bitmap Index Scan on orders_status_index  (cost=0.00..31.06 rows=2504 width=0) (actual time=0.076..0.077 rows=2504 loops=1)
--         Index Cond: (status = 'canceled'::enum_status_order)
-- Planning Time: 0.087 ms
-- Execution Time: 0.740 ms

-- Выполнение запроса c индексом при 1 млн записей
-- Bitmap Heap Scan on orders  (cost=2765.03..12296.78 rows=247820 width=22) (actual time=10.567..66.496 rows=252023 loops=1)
--   Recheck Cond: (status = 'canceled'::enum_status_order)
--   Heap Blocks: exact=6434
--   ->  Bitmap Index Scan on orders_status_index  (cost=0.00..2703.07 rows=247820 width=0) (actual time=9.174..9.175 rows=252023 loops=1)
--         Index Cond: (status = 'canceled'::enum_status_order)
-- Planning Time: 0.069 ms
-- Execution Time: 65.849 ms


-- ВЫВОД: Добавление индекса orders_status_index дало прирост быстродействия, что при 10 тыс записей, что при 1 млн
-- С индексом запрос быстрее в 2.5-3 раза

-------------------------------------СЛОЖНЫЙ ЗАПРОС 1-------------------------------------------------------------------

-- Вывод списка актеров для каждого фильма
explain analyse SELECT film.name as "Название",
    string_agg(film_worker.name || ' ' ||  film_worker.surname, ', ')  as "Актерский состав"
FROM film
    INNER JOIN film_composition ON film.id=film_composition.film_id
    INNER JOIN film_worker ON film_composition.film_worker_id=film_worker.id
WHERE film.date_premier = '2022-06-09' AND film_composition.type = 'actor'
GROUP BY film.name;

-- Выполнение запроса без индексов при 10 тыс записей
-- GroupAggregate  (cost=1631.84..1632.34 rows=20 width=82) (actual time=4.839..4.865 rows=20 loops=1)
--   Group Key: film.name
--   ->  Sort  (cost=1631.84..1631.89 rows=20 width=84) (actual time=4.830..4.834 rows=28 loops=1)
--         Sort Key: film.name
--         Sort Method: quicksort  Memory: 28kB
--         ->  Nested Loop  (cost=1423.60..1631.41 rows=20 width=84) (actual time=2.623..4.692 rows=28 loops=1)
--               ->  Hash Join  (cost=1423.31..1624.18 rows=20 width=54) (actual time=2.604..4.571 rows=28 loops=1)
--                     Hash Cond: (film_composition.film_id = film.id)
--                     ->  Seq Scan on film_composition  (cost=0.00..180.00 rows=7945 width=8) (actual time=0.012..1.210 rows=7945 loops=1)
--                           Filter: (type = 'actor'::enum_film_composition)
--                           Rows Removed by Filter: 2055
--                     ->  Hash  (cost=1423.00..1423.00 rows=25 width=54) (actual time=2.558..2.558 rows=28 loops=1)
--                           Buckets: 1024  Batches: 1  Memory Usage: 11kB
--                           ->  Seq Scan on film  (cost=0.00..1423.00 rows=25 width=54) (actual time=0.015..2.536 rows=28 loops=1)
--                                 Filter: (date_premier = '2022-06-09'::date)
--                                 Rows Removed by Filter: 9972
--               ->  Index Scan using film_worker_pkey on film_worker  (cost=0.29..0.36 rows=1 width=38) (actual time=0.003..0.003 rows=1 loops=28)
--                     Index Cond: (id = film_composition.film_worker_id)
-- Planning Time: 0.514 ms
-- Execution Time: 6.154 ms

-- Выполнение запроса без индексов при 1 млн записей
-- GroupAggregate  (cost=150716.17..151105.56 rows=2802 width=82) (actual time=480.441..488.176 rows=1560 loops=1)
--   Group Key: film.name
--   ->  Gather Merge  (cost=150716.17..151042.51 rows=2802 width=84) (actual time=480.413..486.403 rows=2283 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Sort  (cost=149716.15..149719.07 rows=1168 width=84) (actual time=422.407..422.504 rows=761 loops=3)
--               Sort Key: film.name
--               Sort Method: quicksort  Memory: 130kB
--               Worker 0:  Sort Method: quicksort  Memory: 139kB
--               Worker 1:  Sort Method: quicksort  Memory: 126kB
--               ->  Nested Loop  (cost=137469.08..149656.64 rows=1168 width=84) (actual time=298.026..419.300 rows=761 loops=3)
--                     ->  Parallel Hash Join  (cost=137468.65..149073.19 rows=1168 width=54) (actual time=297.977..412.870 rows=761 loops=3)
--                           Hash Cond: (film_composition.film_id = film.id)
--                           ->  Parallel Seq Scan on film_composition  (cost=0.00..10720.42 rows=336807 width=8) (actual time=0.048..64.692 rows=269122 loops=3)
--                                 Filter: (type = 'actor'::enum_film_composition)
--                                 Rows Removed by Filter: 67544
--                           ->  Parallel Hash  (cost=137450.42..137450.42 rows=1459 width=54) (actual time=297.375..297.377 rows=933 loops=3)
--                                 Buckets: 4096  Batches: 1  Memory Usage: 352kB
--                                 ->  Parallel Seq Scan on film  (cost=0.00..137450.42 rows=1459 width=54) (actual time=33.809..295.226 rows=933 loops=3)
--                                       Filter: (date_premier = '2022-06-09'::date)
--                                       Rows Removed by Filter: 335734
--                     ->  Index Scan using film_worker_pkey on film_worker  (cost=0.42..0.50 rows=1 width=38) (actual time=0.007..0.007 rows=1 loops=2283)
--                           Index Cond: (id = film_composition.film_worker_id)
-- Planning Time: 0.358 ms
-- JIT:
--   Functions: 63
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 10.717 ms, Inlining 0.000 ms, Optimization 3.853 ms, Emission 95.743 ms, Total 110.313 ms"
-- Execution Time: 490.435 ms



-- Добавлен индекс
create index film_date_premier_index on film using btree (date_premier);

-- Выполнение запроса c индексом при 10 тыс записей:
-- GroupAggregate  (cost=303.22..303.72 rows=20 width=82) (actual time=2.587..2.616 rows=20 loops=1)
--   Group Key: film.name
--   ->  Sort  (cost=303.22..303.27 rows=20 width=84) (actual time=2.572..2.578 rows=28 loops=1)
--         Sort Key: film.name
--         Sort Method: quicksort  Memory: 28kB
--         ->  Nested Loop  (cost=94.98..302.79 rows=20 width=84) (actual time=0.118..2.514 rows=28 loops=1)
--               ->  Hash Join  (cost=94.70..295.56 rows=20 width=54) (actual time=0.110..2.362 rows=28 loops=1)
--                     Hash Cond: (film_composition.film_id = film.id)
--                     ->  Seq Scan on film_composition  (cost=0.00..180.00 rows=7945 width=8) (actual time=0.010..1.411 rows=7945 loops=1)
--                           Filter: (type = 'actor'::enum_film_composition)
--                           Rows Removed by Filter: 2055
--                     ->  Hash  (cost=94.38..94.38 rows=25 width=54) (actual time=0.071..0.073 rows=28 loops=1)
--                           Buckets: 1024  Batches: 1  Memory Usage: 11kB
--                           ->  Bitmap Heap Scan on film  (cost=4.48..94.38 rows=25 width=54) (actual time=0.018..0.061 rows=28 loops=1)
--                                 Recheck Cond: (date_premier = '2022-06-09'::date)
--                                 Heap Blocks: exact=28
--                                 ->  Bitmap Index Scan on film_date_premier_index  (cost=0.00..4.47 rows=25 width=0) (actual time=0.009..0.010 rows=28 loops=1)
--                                       Index Cond: (date_premier = '2022-06-09'::date)
--               ->  Index Scan using film_worker_pkey on film_worker  (cost=0.29..0.36 rows=1 width=38) (actual time=0.004..0.004 rows=1 loops=28)
--                     Index Cond: (id = film_composition.film_worker_id)
-- Planning Time: 0.397 ms
-- Execution Time: 2.691 ms

-- Выполнение запроса c индексом при 1 млн записей
-- GroupAggregate  (cost=25475.13..25864.52 rows=2802 width=82) (actual time=177.056..183.482 rows=1560 loops=1)
--   Group Key: film.name
--   ->  Gather Merge  (cost=25475.13..25801.47 rows=2802 width=84) (actual time=177.039..181.397 rows=2283 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Sort  (cost=24475.11..24478.03 rows=1168 width=84) (actual time=138.355..138.454 rows=761 loops=3)
--               Sort Key: film.name
--               Sort Method: quicksort  Memory: 153kB
--               Worker 0:  Sort Method: quicksort  Memory: 115kB
--               Worker 1:  Sort Method: quicksort  Memory: 126kB
--               ->  Nested Loop  (cost=12228.04..24415.60 rows=1168 width=84) (actual time=2.295..134.586 rows=761 loops=3)
--                     ->  Parallel Hash Join  (cost=12227.61..23832.15 rows=1168 width=54) (actual time=2.252..126.816 rows=761 loops=3)
--                           Hash Cond: (film_composition.film_id = film.id)
--                           ->  Parallel Seq Scan on film_composition  (cost=0.00..10720.42 rows=336807 width=8) (actual time=0.046..73.616 rows=269122 loops=3)
--                                 Filter: (type = 'actor'::enum_film_composition)
--                                 Rows Removed by Filter: 67544
--                           ->  Parallel Hash  (cost=12209.37..12209.37 rows=1459 width=54) (actual time=1.714..1.715 rows=933 loops=3)
--                                 Buckets: 4096  Batches: 1  Memory Usage: 288kB
--                                 ->  Parallel Bitmap Heap Scan on film  (cost=43.56..12209.37 rows=1459 width=54) (actual time=0.831..4.265 rows=2799 loops=1)
--                                       Recheck Cond: (date_premier = '2022-06-09'::date)
--                                       Heap Blocks: exact=2775
--                                       ->  Bitmap Index Scan on film_date_premier_index  (cost=0.00..42.68 rows=3501 width=0) (actual time=0.435..0.436 rows=2799 loops=1)
--                                             Index Cond: (date_premier = '2022-06-09'::date)
--                     ->  Index Scan using film_worker_pkey on film_worker  (cost=0.42..0.50 rows=1 width=38) (actual time=0.009..0.009 rows=1 loops=2283)
--                           Index Cond: (id = film_composition.film_worker_id)
-- Planning Time: 0.394 ms
-- Execution Time: 183.635 ms


-- Добавлен еще 1 индекс
create index film_composition_type_film_index on film_composition using btree (type, film_id);

-- Выполнение запроса c индексом при 10 тыс записей:
-- GroupAggregate  (cost=265.92..266.42 rows=20 width=82) (actual time=0.420..0.446 rows=20 loops=1)
--   Group Key: film.name
--   ->  Sort  (cost=265.92..265.97 rows=20 width=84) (actual time=0.409..0.413 rows=28 loops=1)
--         Sort Key: film.name
--         Sort Method: quicksort  Memory: 28kB
--         ->  Nested Loop  (cost=5.05..265.49 rows=20 width=84) (actual time=0.046..0.352 rows=28 loops=1)
--               ->  Nested Loop  (cost=4.76..258.26 rows=20 width=54) (actual time=0.036..0.225 rows=28 loops=1)
--                     ->  Bitmap Heap Scan on film  (cost=4.48..94.38 rows=25 width=54) (actual time=0.019..0.066 rows=28 loops=1)
--                           Recheck Cond: (date_premier = '2022-06-09'::date)
--                           Heap Blocks: exact=28
--                           ->  Bitmap Index Scan on film_date_premier_index  (cost=0.00..4.47 rows=25 width=0) (actual time=0.010..0.010 rows=28 loops=1)
--                                 Index Cond: (date_premier = '2022-06-09'::date)
--                     ->  Index Scan using film_composition_type_film_index on film_composition  (cost=0.29..6.54 rows=1 width=8) (actual time=0.004..0.005 rows=1 loops=28)
--                           Index Cond: ((type = 'actor'::enum_film_composition) AND (film_id = film.id))
--               ->  Index Scan using film_worker_pkey on film_worker  (cost=0.29..0.36 rows=1 width=38) (actual time=0.004..0.004 rows=1 loops=28)
--                     Index Cond: (id = film_composition.film_worker_id)
-- Planning Time: 0.513 ms
-- Execution Time: 0.504 ms

-- Выполнение запроса c индексом при 1 млн записей
-- GroupAggregate  (cost=24445.69..24835.07 rows=2802 width=82) (actual time=56.157..59.897 rows=1560 loops=1)
--   Group Key: film.name
--   ->  Gather Merge  (cost=24445.69..24772.03 rows=2802 width=84) (actual time=56.135..57.206 rows=2283 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Sort  (cost=23445.66..23448.58 rows=1168 width=84) (actual time=17.618..17.770 rows=761 loops=3)
--               Sort Key: film.name
--               Sort Method: quicksort  Memory: 418kB
--               Worker 0:  Sort Method: quicksort  Memory: 25kB
--               Worker 1:  Sort Method: quicksort  Memory: 25kB
--               ->  Nested Loop  (cost=44.41..23386.16 rows=1168 width=84) (actual time=0.652..12.842 rows=761 loops=3)
--                     ->  Nested Loop  (cost=43.98..22802.70 rows=1168 width=54) (actual time=0.646..8.093 rows=761 loops=3)
--                           ->  Parallel Bitmap Heap Scan on film  (cost=43.56..12209.37 rows=1459 width=54) (actual time=0.637..2.388 rows=933 loops=3)
--                                 Recheck Cond: (date_premier = '2022-06-09'::date)
--                                 Heap Blocks: exact=2775
--                                 ->  Bitmap Index Scan on film_date_premier_index  (cost=0.00..42.68 rows=3501 width=0) (actual time=1.367..1.368 rows=2799 loops=1)
--                                       Index Cond: (date_premier = '2022-06-09'::date)
--                           ->  Index Scan using film_composition_type_film_index on film_composition  (cost=0.42..7.24 rows=2 width=8) (actual time=0.005..0.005 rows=1 loops=2799)
--                                 Index Cond: ((type = 'actor'::enum_film_composition) AND (film_id = film.id))
--                     ->  Index Scan using film_worker_pkey on film_worker  (cost=0.42..0.50 rows=1 width=38) (actual time=0.005..0.005 rows=1 loops=2283)
--                           Index Cond: (id = film_composition.film_worker_id)
-- Planning Time: 0.513 ms
-- Execution Time: 60.080 ms

-- ВЫВОД: Добавление индекса film_date_premier_index дало прирост быстродействия, что при 10 тыс запсией, что при 1 млн
-- С индексом запрос быстрее в 2-3 раза.
-- После добавления еще одного индекса film_composition_type_film_index запрос стал по итогу быстрее в 5-8 раз

-------------------------------------СЛОЖНЫЙ ЗАПРОС 2-------------------------------------------------------------------

-- Запрос с ДЗ 7 - нахождение самого прибыльного фильма
explain analyse SELECT session.film_id, film.name, SUM(tickets.price) AS total
FROM tickets
    INNER JOIN session ON tickets.session_id=session.id
    INNER JOIN film ON session.film_id=film.id
WHERE tickets.active = true
GROUP BY session.film_id, film.name
ORDER BY total DESC
LIMIT 1;

-- Выполнение запроса без индексов при 10 тыс записей
-- Limit  (cost=2209.22..2209.23 rows=1 width=86) (actual time=31.701..31.708 rows=1 loops=1)
--   ->  Sort  (cost=2209.22..2226.84 rows=7048 width=86) (actual time=31.699..31.704 rows=1 loops=1)
--         Sort Key: (sum(tickets.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=2085.88..2173.98 rows=7048 width=86) (actual time=27.411..30.364 rows=3980 loops=1)
-- "              Group Key: session.film_id, film.name"
--               Batches: 1  Memory Usage: 2257kB
--               ->  Hash Join  (cost=1832.00..2033.02 rows=7048 width=59) (actual time=11.122..21.660 rows=7048 loops=1)
--                     Hash Cond: (session.film_id = film.id)
--                     ->  Hash Join  (cost=309.00..491.51 rows=7048 width=9) (actual time=4.947..11.570 rows=7048 loops=1)
--                           Hash Cond: (tickets.session_id = session.id)
--                           ->  Seq Scan on tickets  (cost=0.00..164.00 rows=7048 width=9) (actual time=0.013..2.514 rows=7048 loops=1)
--                                 Filter: active
--                                 Rows Removed by Filter: 2952
--                           ->  Hash  (cost=184.00..184.00 rows=10000 width=8) (actual time=4.921..4.922 rows=10000 loops=1)
--                                 Buckets: 16384  Batches: 1  Memory Usage: 519kB
--                                 ->  Seq Scan on session  (cost=0.00..184.00 rows=10000 width=8) (actual time=0.006..2.140 rows=10000 loops=1)
--                     ->  Hash  (cost=1398.00..1398.00 rows=10000 width=54) (actual time=6.155..6.157 rows=10000 loops=1)
--                           Buckets: 16384  Batches: 1  Memory Usage: 990kB
--                           ->  Seq Scan on film  (cost=0.00..1398.00 rows=10000 width=54) (actual time=0.013..3.342 rows=10000 loops=1)
-- Planning Time: 0.607 ms
-- Execution Time: 31.792 ms

-- Выполнение запроса без индексов при 1 млн записей
-- Limit  (cost=320858.21..320858.22 rows=1 width=86) (actual time=2840.955..2896.263 rows=1 loops=1)
--   ->  Sort  (cost=320858.21..322627.31 rows=707640 width=86) (actual time=2820.741..2876.048 rows=1 loops=1)
--         Sort Key: (sum(tickets.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=227877.38..317320.01 rows=707640 width=86) (actual time=1690.487..2734.990 rows=398774 loops=1)
-- "              Group Key: session.film_id, film.name"
--               ->  Gather Merge  (cost=227877.38..302577.51 rows=589700 width=86) (actual time=1690.468..2219.303 rows=403984 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=226877.35..233511.48 rows=294850 width=86) (actual time=1635.366..1918.226 rows=134661 loops=3)
-- "                          Group Key: session.film_id, film.name"
--                           ->  Sort  (cost=226877.35..227614.48 rows=294850 width=59) (actual time=1635.331..1704.883 rows=235833 loops=3)
-- "                                Sort Key: session.film_id, film.name"
--                                 Sort Method: external merge  Disk: 17464kB
--                                 Worker 0:  Sort Method: external merge  Disk: 16072kB
--                                 Worker 1:  Sort Method: external merge  Disk: 14976kB
--                                 ->  Parallel Hash Join  (cost=165298.49..189002.79 rows=294850 width=59) (actual time=1198.983..1417.499 rows=235833 loops=3)
--                                       Hash Cond: (session.film_id = film.id)
--                                       ->  Parallel Hash Join  (cost=19529.75..35470.06 rows=294850 width=9) (actual time=440.313..627.684 rows=235833 loops=3)
--                                             Hash Cond: (tickets.session_id = session.id)
--                                             ->  Parallel Seq Scan on tickets  (cost=0.00..10642.33 rows=294850 width=9) (actual time=0.056..88.990 rows=235833 loops=3)
--                                                   Filter: active
--                                                   Rows Removed by Filter: 100834
--                                             ->  Parallel Hash  (cost=12625.33..12625.33 rows=420833 width=8) (actual time=249.708..249.709 rows=336667 loops=3)
--                                                   Buckets: 131072  Batches: 16  Memory Usage: 3552kB
--                                                   ->  Parallel Seq Scan on session  (cost=0.00..12625.33 rows=420833 width=8) (actual time=0.029..81.530 rows=336667 loops=3)
--                                       ->  Parallel Hash  (cost=136398.33..136398.33 rows=420833 width=54) (actual time=481.528..481.529 rows=336667 loops=3)
--                                             Buckets: 65536  Batches: 32  Memory Usage: 3360kB
--                                             ->  Parallel Seq Scan on film  (cost=0.00..136398.33 rows=420833 width=54) (actual time=13.234..267.188 rows=336667 loops=3)
-- Planning Time: 0.552 ms
-- JIT:
--   Functions: 79
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 10.357 ms, Inlining 0.000 ms, Optimization 2.890 ms, Emission 55.719 ms, Total 68.966 ms"
-- Execution Time: 2901.932 ms


-- ВЫВОД: Подобрать индекс, который бы использовался в запросе не удалось, несмотря на различные попытки:
-- create index tickets_active_index on tickets using btree (active);
-- create index tickets_active_session_index on tickets using btree (active, session_id);
-- create index tickets_active_session_price_index on tickets using btree (active, session_id, price);

-------------------------------------СЛОЖНЫЙ ЗАПРОС 3-------------------------------------------------------------------

-- Подсчет на какую сумму приобретено билетов каждым из способов приобретения (сайт, касса, терминал) среди всех не VIP залов
explain analyse SELECT purchase_method.name, SUM(tickets.price) as sum
FROM orders
    INNER JOIN purchase_method ON orders.purchase_method_id=purchase_method.id
    INNER JOIN tickets ON orders.id=tickets.order_id
    INNER JOIN place ON tickets.place_id=place.id
    INNER JOIN hall ON place.hall_id=hall.id
WHERE orders.status = 'paid' AND hall.vip = false
GROUP BY purchase_method.name
ORDER BY sum DESC;

-- Выполнение запроса без индексов при 10 тыс записей
-- Sort  (cost=476.17..476.67 rows=200 width=250) (actual time=9.050..9.057 rows=2 loops=1)
--   Sort Key: (sum(tickets.price)) DESC
--   Sort Method: quicksort  Memory: 25kB
--   ->  HashAggregate  (cost=466.03..468.53 rows=200 width=250) (actual time=9.039..9.047 rows=2 loops=1)
--         Group Key: purchase_method.name
--         Batches: 1  Memory Usage: 40kB
--         ->  Hash Join  (cost=244.52..459.82 rows=1242 width=223) (actual time=1.843..7.814 rows=2367 loops=1)
--               Hash Cond: (orders.purchase_method_id = purchase_method.id)
--               ->  Hash Join  (cost=227.32..439.31 rows=1242 width=7) (actual time=1.823..7.008 rows=2367 loops=1)
--                     Hash Cond: (tickets.place_id = place.id)
--                     ->  Hash Join  (cost=220.04..410.30 rows=2483 width=11) (actual time=1.754..6.029 rows=2487 loops=1)
--                           Hash Cond: (tickets.order_id = orders.id)
--                           ->  Seq Scan on tickets  (cost=0.00..164.00 rows=10000 width=13) (actual time=0.003..1.150 rows=10000 loops=1)
--                           ->  Hash  (cost=189.00..189.00 rows=2483 width=6) (actual time=1.745..1.746 rows=2483 loops=1)
--                                 Buckets: 4096  Batches: 1  Memory Usage: 129kB
--                                 ->  Seq Scan on orders  (cost=0.00..189.00 rows=2483 width=6) (actual time=0.005..1.275 rows=2483 loops=1)
--                                       Filter: (status = 'paid'::enum_status_order)
--                                       Rows Removed by Filter: 7517
--                     ->  Hash  (cost=6.91..6.91 rows=30 width=4) (actual time=0.064..0.066 rows=56 loops=1)
--                           Buckets: 1024  Batches: 1  Memory Usage: 10kB
--                           ->  Nested Loop  (cost=0.16..6.91 rows=30 width=4) (actual time=0.014..0.056 rows=56 loops=1)
--                                 ->  Seq Scan on place  (cost=0.00..1.60 rows=60 width=8) (actual time=0.003..0.009 rows=60 loops=1)
--                                 ->  Memoize  (cost=0.16..0.97 rows=1 width=4) (actual time=0.000..0.000 rows=1 loops=60)
--                                       Cache Key: place.hall_id
--                                       Cache Mode: logical
--                                       Hits: 57  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB
--                                       ->  Index Scan using hall_pkey on hall  (cost=0.15..0.96 rows=1 width=4) (actual time=0.003..0.003 rows=1 loops=3)
--                                             Index Cond: (id = place.hall_id)
--                                             Filter: (NOT vip)
--                                             Rows Removed by Filter: 0
--               ->  Hash  (cost=13.20..13.20 rows=320 width=220) (actual time=0.015..0.016 rows=3 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Seq Scan on purchase_method  (cost=0.00..13.20 rows=320 width=220) (actual time=0.011..0.012 rows=3 loops=1)
-- Planning Time: 0.641 ms
-- Execution Time: 9.130 ms

-- Выполнение запроса без индексов при 1 млн записей
-- Sort  (cost=30929.10..30929.60 rows=200 width=250) (actual time=826.226..839.337 rows=2 loops=1)
--   Sort Key: (sum(tickets.price)) DESC
--   Sort Method: quicksort  Memory: 25kB
--   ->  Finalize GroupAggregate  (cost=30869.28..30921.45 rows=200 width=250) (actual time=826.214..839.330 rows=2 loops=1)
--         Group Key: purchase_method.name
--         ->  Gather Merge  (cost=30869.28..30915.95 rows=400 width=250) (actual time=826.198..839.312 rows=6 loops=1)
--               Workers Planned: 2
--               Workers Launched: 2
--               ->  Sort  (cost=29869.26..29869.76 rows=200 width=250) (actual time=787.654..787.661 rows=2 loops=3)
--                     Sort Key: purchase_method.name
--                     Sort Method: quicksort  Memory: 25kB
--                     Worker 0:  Sort Method: quicksort  Memory: 25kB
--                     Worker 1:  Sort Method: quicksort  Memory: 25kB
--                     ->  Partial HashAggregate  (cost=29859.12..29861.62 rows=200 width=250) (actual time=787.615..787.624 rows=2 loops=3)
--                           Group Key: purchase_method.name
--                           Batches: 1  Memory Usage: 40kB
--                           Worker 0:  Batches: 1  Memory Usage: 40kB
--                           Worker 1:  Batches: 1  Memory Usage: 40kB
--                           ->  Hash Join  (cost=13480.55..29592.24 rows=53376 width=223) (actual time=559.854..739.462 rows=79747 loops=3)
--                                 Hash Cond: (orders.purchase_method_id = purchase_method.id)
--                                 ->  Parallel Hash Join  (cost=13463.35..29433.07 rows=53376 width=7) (actual time=559.794..706.002 rows=79747 loops=3)
--                                       Hash Cond: (tickets.order_id = orders.id)
--                                       ->  Hash Join  (cost=17.55..12961.92 rows=210417 width=9) (actual time=0.122..358.380 rows=319421 loops=3)
--                                             Hash Cond: (place.hall_id = hall.id)
--                                             ->  Hash Join  (cost=2.35..11827.40 rows=420833 width=13) (actual time=0.089..236.046 rows=336667 loops=3)
--                                                   Hash Cond: (tickets.place_id = place.id)
--                                                   ->  Parallel Seq Scan on tickets  (cost=0.00..10642.33 rows=420833 width=13) (actual time=0.039..58.648 rows=336667 loops=3)
--                                                   ->  Hash  (cost=1.60..1.60 rows=60 width=8) (actual time=0.038..0.039 rows=60 loops=3)
--                                                         Buckets: 1024  Batches: 1  Memory Usage: 11kB
--                                                         ->  Seq Scan on place  (cost=0.00..1.60 rows=60 width=8) (actual time=0.013..0.023 rows=60 loops=3)
--                                             ->  Hash  (cost=13.20..13.20 rows=160 width=4) (actual time=0.028..0.029 rows=4 loops=3)
--                                                   Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                                   ->  Seq Scan on hall  (cost=0.00..13.20 rows=160 width=4) (actual time=0.018..0.020 rows=4 loops=3)
--                                                         Filter: (NOT vip)
--                                                         Rows Removed by Filter: 2
--                                       ->  Parallel Hash  (cost=11694.42..11694.42 rows=106751 width=6) (actual time=91.534..91.535 rows=84287 loops=3)
--                                             Buckets: 131072  Batches: 4  Memory Usage: 3552kB
--                                             ->  Parallel Seq Scan on orders  (cost=0.00..11694.42 rows=106751 width=6) (actual time=0.043..62.245 rows=84287 loops=3)
--                                                   Filter: (status = 'paid'::enum_status_order)
--                                                   Rows Removed by Filter: 252380
--                                 ->  Hash  (cost=13.20..13.20 rows=320 width=220) (actual time=0.025..0.026 rows=3 loops=3)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                       ->  Seq Scan on purchase_method  (cost=0.00..13.20 rows=320 width=220) (actual time=0.016..0.018 rows=3 loops=3)
-- Planning Time: 0.636 ms
-- Execution Time: 839.423 ms


-- Добавлен индекс
create index orders_status_index on orders using btree (status);

-- Выполнение запроса c индексом при 10 тыс записей:
-- Sort  (cost=413.74..414.24 rows=200 width=250) (actual time=7.501..7.508 rows=2 loops=1)
--   Sort Key: (sum(tickets.price)) DESC
--   Sort Method: quicksort  Memory: 25kB
--   ->  HashAggregate  (cost=403.59..406.09 rows=200 width=250) (actual time=7.490..7.498 rows=2 loops=1)
--         Group Key: purchase_method.name
--         Batches: 1  Memory Usage: 40kB
--         ->  Hash Join  (cost=182.08..397.38 rows=1242 width=223) (actual time=1.235..6.437 rows=2367 loops=1)
--               Hash Cond: (orders.purchase_method_id = purchase_method.id)
--               ->  Hash Join  (cost=164.88..376.88 rows=1242 width=7) (actual time=1.219..5.708 rows=2367 loops=1)
--                     Hash Cond: (tickets.place_id = place.id)
--                     ->  Hash Join  (cost=157.60..347.86 rows=2483 width=11) (actual time=1.152..4.841 rows=2487 loops=1)
--                           Hash Cond: (tickets.order_id = orders.id)
--                           ->  Seq Scan on tickets  (cost=0.00..164.00 rows=10000 width=13) (actual time=0.004..0.979 rows=10000 loops=1)
--                           ->  Hash  (cost=126.57..126.57 rows=2483 width=6) (actual time=1.142..1.144 rows=2483 loops=1)
--                                 Buckets: 4096  Batches: 1  Memory Usage: 129kB
--                                 ->  Bitmap Heap Scan on orders  (cost=31.53..126.57 rows=2483 width=6) (actual time=0.075..0.690 rows=2483 loops=1)
--                                       Recheck Cond: (status = 'paid'::enum_status_order)
--                                       Heap Blocks: exact=64
--                                       ->  Bitmap Index Scan on orders_status_index  (cost=0.00..30.91 rows=2483 width=0) (actual time=0.061..0.061 rows=2483 loops=1)
--                                             Index Cond: (status = 'paid'::enum_status_order)
--                     ->  Hash  (cost=6.91..6.91 rows=30 width=4) (actual time=0.064..0.066 rows=56 loops=1)
--                           Buckets: 1024  Batches: 1  Memory Usage: 10kB
--                           ->  Nested Loop  (cost=0.16..6.91 rows=30 width=4) (actual time=0.014..0.055 rows=56 loops=1)
--                                 ->  Seq Scan on place  (cost=0.00..1.60 rows=60 width=8) (actual time=0.003..0.009 rows=60 loops=1)
--                                 ->  Memoize  (cost=0.16..0.97 rows=1 width=4) (actual time=0.000..0.000 rows=1 loops=60)
--                                       Cache Key: place.hall_id
--                                       Cache Mode: logical
--                                       Hits: 57  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB
--                                       ->  Index Scan using hall_pkey on hall  (cost=0.15..0.96 rows=1 width=4) (actual time=0.003..0.003 rows=1 loops=3)
--                                             Index Cond: (id = place.hall_id)
--                                             Filter: (NOT vip)
--                                             Rows Removed by Filter: 0
--               ->  Hash  (cost=13.20..13.20 rows=320 width=220) (actual time=0.012..0.013 rows=3 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Seq Scan on purchase_method  (cost=0.00..13.20 rows=320 width=220) (actual time=0.008..0.008 rows=3 loops=1)
-- Planning Time: 0.571 ms
-- Execution Time: 7.586 ms

-- Выполнение запроса c индексом при 1 млн записей
-- Sort  (cost=29861.07..29861.57 rows=200 width=250) (actual time=776.468..788.852 rows=2 loops=1)
--   Sort Key: (sum(tickets.price)) DESC
--   Sort Method: quicksort  Memory: 25kB
--   ->  Finalize GroupAggregate  (cost=29801.26..29853.43 rows=200 width=250) (actual time=776.458..788.845 rows=2 loops=1)
--         Group Key: purchase_method.name
--         ->  Gather Merge  (cost=29801.26..29847.93 rows=400 width=250) (actual time=776.446..788.830 rows=6 loops=1)
--               Workers Planned: 2
--               Workers Launched: 2
--               ->  Sort  (cost=28801.23..28801.73 rows=200 width=250) (actual time=732.015..732.024 rows=2 loops=3)
--                     Sort Key: purchase_method.name
--                     Sort Method: quicksort  Memory: 25kB
--                     Worker 0:  Sort Method: quicksort  Memory: 25kB
--                     Worker 1:  Sort Method: quicksort  Memory: 25kB
--                     ->  Partial HashAggregate  (cost=28791.09..28793.59 rows=200 width=250) (actual time=731.971..731.981 rows=2 loops=3)
--                           Group Key: purchase_method.name
--                           Batches: 1  Memory Usage: 40kB
--                           Worker 0:  Batches: 1  Memory Usage: 40kB
--                           Worker 1:  Batches: 1  Memory Usage: 40kB
--                           ->  Hash Join  (cost=12412.53..28524.21 rows=53376 width=223) (actual time=523.368..687.145 rows=79747 loops=3)
--                                 Hash Cond: (orders.purchase_method_id = purchase_method.id)
--                                 ->  Parallel Hash Join  (cost=12395.33..28365.04 rows=53376 width=7) (actual time=523.296..656.026 rows=79747 loops=3)
--                                       Hash Cond: (tickets.order_id = orders.id)
--                                       ->  Hash Join  (cost=17.55..12961.92 rows=210417 width=9) (actual time=0.135..355.745 rows=319421 loops=3)
--                                             Hash Cond: (place.hall_id = hall.id)
--                                             ->  Hash Join  (cost=2.35..11827.40 rows=420833 width=13) (actual time=0.111..233.302 rows=336667 loops=3)
--                                                   Hash Cond: (tickets.place_id = place.id)
--                                                   ->  Parallel Seq Scan on tickets  (cost=0.00..10642.33 rows=420833 width=13) (actual time=0.055..56.867 rows=336667 loops=3)
--                                                   ->  Hash  (cost=1.60..1.60 rows=60 width=8) (actual time=0.043..0.044 rows=60 loops=3)
--                                                         Buckets: 1024  Batches: 1  Memory Usage: 11kB
--                                                         ->  Seq Scan on place  (cost=0.00..1.60 rows=60 width=8) (actual time=0.013..0.025 rows=60 loops=3)
--                                             ->  Hash  (cost=13.20..13.20 rows=160 width=4) (actual time=0.018..0.019 rows=4 loops=3)
--                                                   Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                                   ->  Seq Scan on hall  (cost=0.00..13.20 rows=160 width=4) (actual time=0.011..0.013 rows=4 loops=3)
--                                                         Filter: (NOT vip)
--                                                         Rows Removed by Filter: 2
--                                       ->  Parallel Hash  (cost=10626.39..10626.39 rows=106751 width=6) (actual time=58.841..58.842 rows=84287 loops=3)
--                                             Buckets: 131072  Batches: 4  Memory Usage: 3552kB
--                                             ->  Parallel Bitmap Heap Scan on orders  (cost=2858.00..10626.39 rows=106751 width=6) (actual time=3.668..32.802 rows=84287 loops=3)
--                                                   Recheck Cond: (status = 'paid'::enum_status_order)
--                                                   Heap Blocks: exact=3471
--                                                   ->  Bitmap Index Scan on orders_status_index  (cost=0.00..2793.95 rows=256203 width=0) (actual time=9.812..9.812 rows=252860 loops=1)
--                                                         Index Cond: (status = 'paid'::enum_status_order)
--                                 ->  Hash  (cost=13.20..13.20 rows=320 width=220) (actual time=0.040..0.040 rows=3 loops=3)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                       ->  Seq Scan on purchase_method  (cost=0.00..13.20 rows=320 width=220) (actual time=0.029..0.031 rows=3 loops=3)
-- Planning Time: 0.679 ms
-- Execution Time: 788.954 ms

-- ВЫВОД: Добавление индекса orders_status_index дало почти не ощутимый прирост быстродействия, что при 10 тыс запсией, что при 1 млн
-- С индексом запрос быстрее всего в 1.2 раза.
-- Подобрать подходящий еще индекс для данного запроса не удалось

-------------------------------------ВЫВОДЫ-----------------------------------------------------------------------------
-- 1. На простых запросах индекс дает прирост в разы, а иногда и в десятки раз лучший результат
-- 2. Значимой разницы в быстродействии работы запроса с индексом между количеством данных в 10 тыс строк и 1 млн строк не удалось выявить.
-- Значит, даже при таком не большом количестве строк как 10 тыс полезно использовать индекс
-- 3. Не ко всем сложным запросам удалось подобрать индекс (или вообще не решаемая задача, или не хватает опыта), кроме того один запрос стал лишь немного быстрее