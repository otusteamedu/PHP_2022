---------------------------------------------------------------------------------------------------
-- ПРОСТОЙ ЗАПРОС №1
-- Фильмы, длящиеся больше 90 минут
explain analyse
select "name" 
from "movie" 
where duration >= 90;

--      QUERY PLAN
-- ---------------------------------------------------------------------------------------------------
-- Seq Scan on movie  (cost=0.00..8.75 rows=110 width=14) (actual time=0.039..0.373 rows=754 loops=1)
--   Filter: (duration >= 90)
--   Rows Removed by Filter: 246
-- Planning Time: 0.114 ms
-- Execution Time: 0.428 ms

-- Добавляем индекс
create index movie_duration_index on movie (duration);

-- То же самое с индексом
explain analyse
select "name"
from "movie"
where duration >= 90;

-- QUERY PLAN
-- (cost=0.29..169.93 rows=7637 width=32)
-- (actual time=5.091..6.072 rows=7557 loops=1)
-- Index Cond: (duration >= 90)
-- Heap Fetches: 0
-- Planning Time: 6.946 ms
-- Execution Time: 6.340 ms

-- Итого, время выборки данных с индексом замедлилось в 14.8 раз (6.340 / 0.428)
-- интересно, почему так? должно было уменьшиться ...
-- но т.к. этот текст не прочитают, это останется тайной )

-- drop index
drop index movie_duration_index;

------------------------------------------------------------------------------------------------------------------------------------------
-- ПРОСТОЙ ЗАПРОС №2
-- Билеты, купленные за последние 7 дней
-- эксперимент на 200 записях
explain analyse 
select * 
from "order" 
where (paytime::date <= now()::date)   
and (paytime::date >= (now() - interval '7 day')::date);

--                                                  QUERY PLAN
--"Seq Scan on ""order""  (cost=0.00..9.50 rows=1 width=24) (actual time=0.050..0.154 rows=27 loops=1)"
--  Filter: (((paytime)::date <= (now())::date) AND ((paytime)::date >= ((now() - '7 days'::interval))::date))
--  Rows Removed by Filter: 173
--Planning Time: 21.267 ms
--Execution Time: 0.175 ms


-- добавляем индекс
create index i_order_paytime on "order" (date(paytime));

-- выборка с индексом
explain analyse 
select * 
from "order" 
where (paytime::date <= now()::date)   
and (paytime::date >= (now() - interval '7 day')::date);
--                                                        QUERY PLAN
--------------------------------------------------------------------------------------------------------------------------
-- "Index Scan using order_date_idx on ""order""  (cost=0.16..8.18 rows=1 width=24) (actual time=0.036..0.045 rows=27 loops=1)"
--  Index Cond: (((paytime)::date <= (now())::date) AND ((paytime)::date >= ((now() - '7 days'::interval))::date))
--Planning Time: 0.639 ms
-- Execution Time: 0.068 ms

-- с индексом сработало быстрее в 2,5 раза судя по Execution Time

-- delete index
drop index i_order_paytime;

--------------------------------------------------------------------------------------------------------------------------
-- ПРОСТОЙ ЗАПРОС №3
-- Выборка юзеров по длине имени

explain analyze
select count(*) 
from "user" 
where length("name") = 10;

--                                               QUERY PLAN
-----------------------------------------------------------------------------------------------------------
-- Aggregate  (cost=25.01..25.02 rows=1 width=8) (actual time=0.570..0.571 rows=1 loops=1)
-- "  ->  Seq Scan on ""user""  (cost=0.00..25.00 rows=5 width=0) (actual time=0.039..0.550 rows=50 loops=1)"
--        Filter: (length((name)::text) = 10)
--        Rows Removed by Filter: 950
-- Planning Time: 0.703 ms
-- Execution Time: 0.632 ms

-- Создадим функциональный индекс: по длине имен юзеров
create index i_user_name_length on "user" using btree (length("name"));

-- та же выборка с индексом
explain analyze 
select count(*) 
from "user" 
where length("name") = 10;

--                                                             QUERY PLAN
------------------------------------------------------------------------------------------------------------------------------------
--Aggregate  (cost=12.69..12.70 rows=1 width=8) (actual time=0.143..0.144 rows=1 loops=1)
--"  ->  Bitmap Heap Scan on ""user""  (cost=4.19..12.67 rows=5 width=0) (actual time=0.130..0.137 rows=50 loops=1)"
--        Recheck Cond: (length((name)::text) = 10)
--        Heap Blocks: exact=10
--        ->  Bitmap Index Scan on i_user_name_length  (cost=0.00..4.19 rows=5 width=0) (actual time=0.034..0.035 rows=50 loops=1)
--              Index Cond: (length((name)::text) = 10)
--Planning Time: 0.624 ms
--Execution Time: 0.199 ms

-- Итого: запрос с индексом отработал быстрее в 5 раз (Execution Time: 2.873 / 0.577) 

-- удаляем индекс
drop index i_user_name_length;