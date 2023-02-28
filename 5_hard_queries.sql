-- СЛОЖНЫЙ ЗАПРОС №1
-- Фильмы с наибольшими сборами за последний месяц

select m.name as movie_name,
       count(o.id) as tickets_sold,
       sum(schedule.price) as revenue
from "order" as o
         left join "schedule" on "schedule".id = o.schedule_id
         left join "movie" m on schedule.movie_id = m.id
where (o.paytime::date <= now()::date)
  and (o.paytime::date >= (now() - interval '30 day')::date)
group by movie_name
order by revenue desc;

-- movie_name                | tickets_sold | revenue
-- --------------------------+--------------+---------
--  idxY62vUhj3nTruujpUl6h   |           10 |    3582
--  bKqBHkZawSbnjAtJe1GuSGY  |           12 |    3531
--  vVaPaHlV1PAl             |           11 |    3449
--  jXsoyQX                  |           12 |    3331
--  SxwGPlk                  |            8 |    3021
--  2OVdns2VPjZ5Y            |            9 |    2817
--  ZVHX1bUjdgV5IHKr         |            9 |    2733
--  s2IHtx3PcSykH            |            5 |    1977
--  qdgh8Rnk                 |            5 |    1682
--  UphZUD4sfmkCZ            |            4 |    1638
--  RRAxWFQ                  |            6 |    1633
--  QNOcHKlcC                |            5 |    1606
--  6Xo8li6cOGD9hi3tvsKReN1  |            4 |    1260
--  UcULBDSSOQrC14Amw        |            3 |    1089
--  BTDnjq81kgi6Pyi          |            3 |    1038
--  HSnCeSH2cP               |            3 |     983
--  SudHyKnm2VWAhN           |            2 |     788
--  Y3UfEltRySq9OfwgE6TOa0HM |            2 |     590
--  baoyQZe7yzuG5h           |            2 |     267

-- анализируем запрос
-- Выборка без индекса i_order_paytime
explain analyse
select m.name as movie_name,
       count(o.id) as tickets_sold,
       sum(schedule.price) as revenue
from "order" as o
         left join "schedule" on "schedule".id = o.schedule_id
         left join "movie" m on schedule.movie_id = m.id
where (o.paytime::date <= now()::date)
  and (o.paytime::date >= (now() - interval '30 day')::date)
group by movie_name
order by revenue desc;

-- QUERY PLAN
/*
Sort  (cost=12.71..12.72 rows=1 width=31) (actual time=0.564..0.569 rows=56 loops=1)
  Sort Key: (sum(schedule.price)) DESC
  Sort Method: quicksort  Memory: 29kB
  ->  GroupAggregate  (cost=12.68..12.70 rows=1 width=31) (actual time=0.492..0.536 rows=56 loops=1)
        Group Key: m.name
        ->  Sort  (cost=12.68..12.69 rows=1 width=23) (actual time=0.484..0.490 rows=103 loops=1)
              Sort Key: m.name
              Sort Method: quicksort  Memory: 32kB
              ->  Nested Loop Left Join  (cost=9.79..12.67 rows=1 width=23) (actual time=0.192..0.428 rows=103 loops=1)
                    ->  Hash Right Join  (cost=9.51..11.90 rows=1 width=12) (actual time=0.177..0.227 rows=103 loops=1)
                          Hash Cond: (schedule.id = o.schedule_id)
                          ->  Seq Scan on schedule  (cost=0.00..2.00 rows=100 width=12) (actual time=0.011..0.019 rows=100 loops=1)
                          ->  Hash  (cost=9.50..9.50 rows=1 width=8) (actual time=0.156..0.157 rows=103 loops=1)
                                Buckets: 1024  Batches: 1  Memory Usage: 13kB
"                                ->  Seq Scan on ""order"" o  (cost=0.00..9.50 rows=1 width=8) (actual time=0.023..0.131 rows=103 loops=1)"
                                      Filter: (((paytime)::date <= (now())::date) AND ((paytime)::date >= ((now() - '30 days'::interval))::date))
                                      Rows Removed by Filter: 97
                    ->  Index Scan using movie_pk on movie m  (cost=0.28..0.77 rows=1 width=19) (actual time=0.002..0.002 rows=1 loops=103)
                          Index Cond: (id = schedule.movie_id)
Planning Time: 0.853 ms
Execution Time: 0.695 ms
*/

-- добавляем индекс
create index i_order_paytime on "order" (date(paytime));

-- Выборка с индексом i_order_paytime
explain analyse
select m.name as movie_name,
       count(o.id) as tickets_sold,
       sum(schedule.price) as revenue
from "order" as o
         left join "schedule" on "schedule".id = o.schedule_id
         left join "movie" m on schedule.movie_id = m.id
where (o.paytime::date <= now()::date)
  and (o.paytime::date >= (now() - interval '30 day')::date)
group by movie_name
order by revenue desc;

-- QUERY PLAN
/*
Sort  (cost=11.39..11.40 rows=1 width=31) (actual time=0.480..0.484 rows=56 loops=1)
  Sort Key: (sum(schedule.price)) DESC
  Sort Method: quicksort  Memory: 29kB
  ->  GroupAggregate  (cost=11.36..11.38 rows=1 width=31) (actual time=0.415..0.458 rows=56 loops=1)
        Group Key: m.name
        ->  Sort  (cost=11.36..11.36 rows=1 width=23) (actual time=0.407..0.414 rows=103 loops=1)
              Sort Key: m.name
              Sort Method: quicksort  Memory: 32kB
              ->  Nested Loop Left Join  (cost=8.46..11.35 rows=1 width=23) (actual time=0.138..0.355 rows=103 loops=1)
                    ->  Hash Right Join  (cost=8.19..10.57 rows=1 width=12) (actual time=0.126..0.171 rows=103 loops=1)
                          Hash Cond: (schedule.id = o.schedule_id)
                          ->  Seq Scan on schedule  (cost=0.00..2.00 rows=100 width=12) (actual time=0.012..0.019 rows=100 loops=1)
                          ->  Hash  (cost=8.18..8.18 rows=1 width=8) (actual time=0.101..0.101 rows=103 loops=1)
                                Buckets: 1024  Batches: 1  Memory Usage: 13kB
"                                ->  Index Scan using i_order_paytime on ""order"" o  (cost=0.16..8.18 rows=1 width=8) (actual time=0.043..0.078 rows=103 loops=1)"
                                      Index Cond: (((paytime)::date <= (now())::date) AND ((paytime)::date >= ((now() - '30 days'::interval))::date))
                    ->  Index Scan using movie_pk on movie m  (cost=0.28..0.77 rows=1 width=19) (actual time=0.001..0.001 rows=1 loops=103)
                          Index Cond: (id = schedule.movie_id)
Planning Time: 0.855 ms
Execution Time: 0.587 ms
*/

 -- Итого: выборка с индексом и без него сработали примерно одинаково: 0.587 и 0.695
 -- почему индекс не сработал? - Загадка дыры ...

-- del index
drop index i_order_paytime;

----------------------------------------------------------------------------------------------------------------------------------------------------------------------
-- СЛОЖНЫЙ ЗАПРОС №2
-- Список юзеров, посмотревших фильмы из 10 букв

select u.name
from "order" as o
         left join "schedule" on "schedule".id = o.schedule_id
         left join "movie" m on schedule.movie_id = m.id
         left join "user" as u on o."user_id" = u.id
where length(m."name") = 10;

-- анаилизируем выборку без индекса
explain analyze
select u.name
from "order" as o
         left join "schedule" on "schedule".id = o.schedule_id
         left join "movie" m on schedule.movie_id = m.id
         left join "user" as u on o."user_id" = u.id
where length(m."name") = 10;

-- QUERY PLAN
/*
Nested Loop Left Join  (cost=24.61..30.70 rows=1 width=17) (actual time=0.464..0.569 rows=17 loops=1)
  ->  Hash Join  (cost=24.34..30.11 rows=1 width=4) (actual time=0.435..0.483 rows=17 loops=1)
        Hash Cond: (o.schedule_id = schedule.id)
"        ->  Seq Scan on ""order"" o  (cost=0.00..5.00 rows=200 width=8) (actual time=0.020..0.039 rows=200 loops=1)"
        ->  Hash  (cost=24.32..24.32 rows=1 width=4) (actual time=0.396..0.398 rows=8 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 9kB
              ->  Hash Join  (cost=22.06..24.32 rows=1 width=4) (actual time=0.346..0.384 rows=8 loops=1)
                    Hash Cond: (schedule.movie_id = m.id)
                    ->  Seq Scan on schedule  (cost=0.00..2.00 rows=100 width=8) (actual time=0.013..0.025 rows=100 loops=1)
                    ->  Hash  (cost=22.00..22.00 rows=5 width=4) (actual time=0.307..0.308 rows=61 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 11kB
                          ->  Seq Scan on movie m  (cost=0.00..22.00 rows=5 width=4) (actual time=0.026..0.278 rows=61 loops=1)
                                Filter: (length((name)::text) = 10)
                                Rows Removed by Filter: 939
"  ->  Index Scan using user_pk on ""user"" u  (cost=0.28..0.59 rows=1 width=21) (actual time=0.004..0.004 rows=1 loops=17)"
        Index Cond: (id = o.user_id)
Planning Time: 1.045 ms
Execution Time: 0.693 ms
*/

-- Создадим функциональный индекс: по длине имен фильмов
create index i_movie_name_length on "movie" using btree (length("name"));

-- выборка с индексом
explain analyze
select u.name
from "order" as o
         left join "schedule" on "schedule".id = o.schedule_id
         left join "movie" m on schedule.movie_id = m.id
         left join "user" as u on o."user_id" = u.id
where length(m."name") = 10;

-- QUERY PLAN
/*
Nested Loop Left Join  (cost=13.81..19.89 rows=1 width=17) (actual time=0.319..0.450 rows=17 loops=1)
  ->  Hash Join  (cost=13.53..19.30 rows=1 width=4) (actual time=0.306..0.373 rows=17 loops=1)
        Hash Cond: (o.schedule_id = schedule.id)
"        ->  Seq Scan on ""order"" o  (cost=0.00..5.00 rows=200 width=8) (actual time=0.020..0.039 rows=200 loops=1)"
        ->  Hash  (cost=13.52..13.52 rows=1 width=4) (actual time=0.268..0.269 rows=8 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 9kB
              ->  Hash Join  (cost=11.26..13.52 rows=1 width=4) (actual time=0.248..0.265 rows=8 loops=1)
                    Hash Cond: (schedule.movie_id = m.id)
                    ->  Seq Scan on schedule  (cost=0.00..2.00 rows=100 width=8) (actual time=0.010..0.017 rows=100 loops=1)
                    ->  Hash  (cost=11.19..11.19 rows=5 width=4) (actual time=0.223..0.224 rows=61 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 11kB
                          ->  Bitmap Heap Scan on movie m  (cost=4.19..11.19 rows=5 width=4) (actual time=0.181..0.200 rows=61 loops=1)
                                Recheck Cond: (length((name)::text) = 10)
                                Heap Blocks: exact=7
                                ->  Bitmap Index Scan on i_movie_name_length  (cost=0.00..4.19 rows=5 width=0) (actual time=0.173..0.173 rows=61 loops=1)
                                      Index Cond: (length((name)::text) = 10)
"  ->  Index Scan using user_pk on ""user"" u  (cost=0.28..0.59 rows=1 width=21) (actual time=0.004..0.004 rows=1 loops=17)"
        Index Cond: (id = o.user_id)
Planning Time: 1.238 ms
Execution Time: 0.579 ms
*/

 -- Итого: на малых объемах данных применение функционального индекса НЕ ускорило выборку, ускорение не значительное: в 1.19 раз

-- del index
drop index i_movie_name_length;

----------------------------------------------------------------------------------------------------------------------------------------------------------------------
-- СЛОЖНЫЙ ЗАПРОС №3
-- Названия топ-10 фильмов с самымми дорогими сеансами (но не дороже 500 руб) за последний месяц
select m.name, s.price
from schedule s
join movie m on s.movie_id = m.id
where (s.start_time::date >= (now() - interval '30 day')::date)
and s.price <= 500
order by s.price desc
limit 10;

-- запускаем без индекса
explain analyze
select m.name, s.price
from schedule s
         join movie m on s.movie_id = m.id
where (s.start_time::date >= (now() - interval '30 day')::date)
  and s.price <= 500
order by s.price desc
limit 10;
/*
 Limit  (cost=654.09..654.11 rows=10 width=19) (actual time=9.054..9.059 rows=10 loops=1)
  ->  Sort  (cost=654.09..657.81 rows=1489 width=19) (actual time=9.053..9.056 rows=10 loops=1)
        Sort Key: s.price DESC
        Sort Method: top-N heapsort  Memory: 26kB
        ->  Hash Join  (cost=294.00..621.91 rows=1489 width=19) (actual time=3.606..8.269 rows=4470 loops=1)
              Hash Cond: (s.movie_id = m.id)
              ->  Seq Scan on schedule s  (cost=0.00..324.00 rows=1489 width=8) (actual time=0.021..3.212 rows=4470 loops=1)
                    Filter: ((price <= 500) AND ((start_time)::date >= ((now() - '30 days'::interval))::date))
                    Rows Removed by Filter: 5530
              ->  Hash  (cost=169.00..169.00 rows=10000 width=19) (actual time=3.492..3.493 rows=10000 loops=1)
                    Buckets: 16384  Batches: 1  Memory Usage: 651kB
                    ->  Seq Scan on movie m  (cost=0.00..169.00 rows=10000 width=19) (actual time=0.011..1.459 rows=10000 loops=1)
Planning Time: 0.333 ms
Execution Time: 9.236 ms
 */

-- для ускорения поиска используем составной индекс:
create index i_schedule_time_price
    on "schedule"
        using btree (date(start_time), "price" desc);

-- запуск с индексом
explain analyze
select m.name, s.price
from schedule s
         join movie m on s.movie_id = m.id
where (s.start_time::date >= (now() - interval '30 day')::date)
  and s.price <= 500
order by s.price desc
limit 10;

/*
Limit  (cost=515.31..515.33 rows=10 width=19) (actual time=13.181..13.186 rows=10 loops=1)
  ->  Sort  (cost=515.31..519.03 rows=1489 width=19) (actual time=13.177..13.181 rows=10 loops=1)
        Sort Key: s.price DESC
        Sort Method: top-N heapsort  Memory: 26kB
        ->  Hash Join  (cost=367.99..483.13 rows=1489 width=19) (actual time=8.129..12.075 rows=4470 loops=1)
              Hash Cond: (s.movie_id = m.id)
              ->  Bitmap Heap Scan on schedule s  (cost=73.99..185.22 rows=1489 width=8) (actual time=0.893..1.775 rows=4470 loops=1)
                    Recheck Cond: (((start_time)::date >= ((now() - '30 days'::interval))::date) AND (price <= 500))
                    Heap Blocks: exact=74
                    ->  Bitmap Index Scan on i_schedule_time_price  (cost=0.00..73.62 rows=1489 width=0) (actual time=0.868..0.869 rows=4470 loops=1)
                          Index Cond: (((start_time)::date >= ((now() - '30 days'::interval))::date) AND (price <= 500))
              ->  Hash  (cost=169.00..169.00 rows=10000 width=19) (actual time=7.125..7.126 rows=10000 loops=1)
                    Buckets: 16384  Batches: 1  Memory Usage: 651kB
                    ->  Seq Scan on movie m  (cost=0.00..169.00 rows=10000 width=19) (actual time=0.028..2.982 rows=10000 loops=1)
Planning Time: 0.924 ms
Execution Time: 13.457 ms
*/

-- время выбоорки с индексом увеличилось: 13.457 ms вместо  9.236 ms
-- хотя видно что индекс был использован:
--  Index Cond: (((start_time)::date >= ((now() - '30 days'::interval))::date) AND (price <= 500))
-- почему так? ХЗ

-- del index
drop index i_schedule_time_price;