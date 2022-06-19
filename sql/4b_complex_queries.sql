-- Фильмы с наибольшими сборами
explain analyse
select m.name                as Movie,
       count(s2.id)          as Sessions,
       count(t.id)           as Tickets,
       sum(t.sold_for_price) as Revenue
from ticket as t
         join ticket_status ts on t.id = ts.ticket_id
         join status s on s.id = ts.status_id
         join seat_session ss on ts.seat_session_id = ss.id
         join session s2 on ss.session_id = s2.id
         join movie m on s2.movie_id = m.id
where s.name = 'Prepaid'
group by Movie
order by Revenue desc;

/*
Sort  (cost=13.57..13.57 rows=1 width=64) (actual time=0.497..0.501 rows=37 loops=1)
  Sort Key: (sum(t.sold_for_price)) DESC
  Sort Method: quicksort  Memory: 28kB
  ->  GroupAggregate  (cost=13.53..13.56 rows=1 width=64) (actual time=0.434..0.485 rows=37 loops=1)
        Group Key: m.name
        ->  Sort  (cost=13.53..13.54 rows=1 width=29) (actual time=0.427..0.432 rows=48 loops=1)
              Sort Key: m.name
              Sort Method: quicksort  Memory: 28kB
              ->  Nested Loop  (cost=0.88..13.52 rows=1 width=29) (actual time=0.043..0.388 rows=48 loops=1)
                    ->  Nested Loop  (cost=0.59..11.76 rows=1 width=17) (actual time=0.038..0.302 rows=48 loops=1)
                          ->  Nested Loop  (cost=0.44..11.50 rows=1 width=13) (actual time=0.034..0.250 rows=48 loops=1)
                                ->  Nested Loop  (cost=0.30..11.26 rows=1 width=13) (actual time=0.026..0.164 rows=48 loops=1)
                                      ->  Nested Loop  (cost=0.15..11.01 rows=1 width=8) (actual time=0.021..0.109 rows=48 loops=1)
                                            ->  Seq Scan on ticket_status ts  (cost=0.00..4.00 rows=200 width=12) (actual time=0.006..0.021 rows=200 loops=1)
                                            ->  Memoize  (cost=0.15..0.42 rows=1 width=4) (actual time=0.000..0.000 rows=0 loops=200)
                                                  Cache Key: ts.status_id
                                                  Cache Mode: logical
                                                  Hits: 196  Misses: 4  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                                                  ->  Index Scan using status_pkey on status s  (cost=0.14..0.41 rows=1 width=4) (actual time=0.003..0.003 rows=0 loops=4)
                                                        Index Cond: (id = ts.status_id)
                                                        Filter: ((name)::text = 'Prepaid'::text)
                                                        Rows Removed by Filter: 1
                                      ->  Index Scan using ticket_pkey on ticket t  (cost=0.14..0.24 rows=1 width=9) (actual time=0.001..0.001 rows=1 loops=48)
                                            Index Cond: (id = ts.ticket_id)
                                ->  Index Scan using seat_session_pkey on seat_session ss  (cost=0.14..0.24 rows=1 width=8) (actual time=0.001..0.001 rows=1 loops=48)
                                      Index Cond: (id = ts.seat_session_id)
                          ->  Index Scan using session_pkey on session s2  (cost=0.15..0.27 rows=1 width=8) (actual time=0.001..0.001 rows=1 loops=48)
                                Index Cond: (id = ss.session_id)
                    ->  Index Scan using movie_pkey on movie m  (cost=0.29..1.76 rows=1 width=20) (actual time=0.001..0.001 rows=1 loops=48)
                          Index Cond: (id = s2.movie_id)
Planning Time: 0.716 ms
Execution Time: 0.542 ms
*/

/*
Sort  (cost=27.20..27.20 rows=1 width=64) (actual time=0.473..0.481 rows=37 loops=1)
  Sort Key: (sum(t.sold_for_price)) DESC
  Sort Method: quicksort  Memory: 28kB
  ->  GroupAggregate  (cost=27.16..27.19 rows=1 width=64) (actual time=0.425..0.462 rows=37 loops=1)
        Group Key: m.name
        ->  Sort  (cost=27.16..27.16 rows=1 width=29) (actual time=0.418..0.425 rows=48 loops=1)
              Sort Key: m.name
              Sort Method: quicksort  Memory: 28kB
              ->  Nested Loop  (cost=12.18..27.15 rows=1 width=29) (actual time=0.130..0.390 rows=48 loops=1)
                    ->  Nested Loop  (cost=11.75..18.71 rows=1 width=17) (actual time=0.125..0.283 rows=48 loops=1)
                          ->  Nested Loop  (cost=11.60..18.44 rows=1 width=13) (actual time=0.121..0.228 rows=48 loops=1)
                                ->  Merge Join  (cost=11.46..18.20 rows=1 width=13) (actual time=0.119..0.175 rows=48 loops=1)
                                      Merge Cond: (t.id = ts.ticket_id)
                                      ->  Index Scan using ticket_pkey on ticket t  (cost=0.43..344596.43 rows=10000000 width=9) (actual time=0.006..0.032 rows=198 loops=1)
                                      ->  Sort  (cost=11.02..11.03 rows=1 width=8) (actual time=0.109..0.114 rows=48 loops=1)
                                            Sort Key: ts.ticket_id
                                            Sort Method: quicksort  Memory: 27kB
                                            ->  Nested Loop  (cost=0.15..11.01 rows=1 width=8) (actual time=0.017..0.100 rows=48 loops=1)
                                                  ->  Seq Scan on ticket_status ts  (cost=0.00..4.00 rows=200 width=12) (actual time=0.007..0.021 rows=200 loops=1)
                                                  ->  Memoize  (cost=0.15..0.42 rows=1 width=4) (actual time=0.000..0.000 rows=0 loops=200)
                                                        Cache Key: ts.status_id
                                                        Cache Mode: logical
                                                        Hits: 196  Misses: 4  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                                                        ->  Index Scan using status_pkey on status s  (cost=0.14..0.41 rows=1 width=4) (actual time=0.002..0.002 rows=0 loops=4)
                                                              Index Cond: (id = ts.status_id)
                                                              Filter: ((name)::text = 'Prepaid'::text)
                                                              Rows Removed by Filter: 1
                                ->  Index Scan using seat_session_pkey on seat_session ss  (cost=0.14..0.24 rows=1 width=8) (actual time=0.001..0.001 rows=1 loops=48)
                                      Index Cond: (id = ts.seat_session_id)
                          ->  Index Scan using session_pkey on session s2  (cost=0.15..0.27 rows=1 width=8) (actual time=0.001..0.001 rows=1 loops=48)
                                Index Cond: (id = ss.session_id)
                    ->  Index Scan using movie_pkey on movie m  (cost=0.43..8.44 rows=1 width=20) (actual time=0.002..0.002 rows=1 loops=48)
                          Index Cond: (id = s2.movie_id)
Planning Time: 0.812 ms
Execution Time: 0.531 ms
*/

-- Увеличение количества записей не вызвало изменений, из-за небольшого количества записей в таблице status добавление
-- индекса не имеет практического смысла

/*==================================================================================================*/

-- фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней
explain analyse
select m.name as MovieName, ma.name as today, null as in_20_days
from movie as m
         join movie_attribute_value mav on m.id = mav.movie_id
         join movie_attribute ma on ma.id = mav.movie_attribute_id
         join movie_attribute_type mat on mat.id = ma.attribute_type_id
where mav.value_datetime::date = date 'today'
union all
select m.name as MovieName, null as today, ma.name as in_20_days
from movie as m
         join movie_attribute_value mav on m.id = mav.movie_id
         join movie_attribute ma on ma.id = mav.movie_attribute_id
         join movie_attribute_type mat on mat.id = ma.attribute_type_id
where mav.value_datetime::date = (now() + interval '20 days')::date
order by MovieName;

/*
Sort  (cost=1114.97..1115.22 rows=100 width=564) (actual time=6.323..6.350 rows=433 loops=1)
  Sort Key: m.name
  Sort Method: quicksort  Memory: 58kB
  ->  Append  (cost=13.59..1111.65 rows=100 width=564) (actual time=0.044..5.906 rows=433 loops=1)
        ->  Hash Join  (cost=13.59..517.58 rows=50 width=564) (actual time=0.043..1.707 rows=118 loops=1)
              Hash Cond: (ma.attribute_type_id = mat.id)
              ->  Nested Loop  (cost=0.44..504.29 rows=50 width=536) (actual time=0.034..1.649 rows=118 loops=1)
                    ->  Nested Loop  (cost=0.29..493.13 rows=50 width=20) (actual time=0.026..1.548 rows=118 loops=1)
                          ->  Seq Scan on movie_attribute_value mav  (cost=0.00..214.00 rows=50 width=8) (actual time=0.011..1.304 rows=118 loops=1)
                                Filter: ((value_datetime)::date = '2022-06-18'::date)
                                Rows Removed by Filter: 9882
                          ->  Index Scan using movie_pkey on movie m  (cost=0.29..5.58 rows=1 width=20) (actual time=0.001..0.001 rows=1 loops=118)
                                Index Cond: (id = mav.movie_id)
                    ->  Memoize  (cost=0.15..1.13 rows=1 width=524) (actual time=0.000..0.000 rows=1 loops=118)
                          Cache Key: mav.movie_attribute_id
                          Cache Mode: logical
                          Hits: 110  Misses: 8  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                          ->  Index Scan using movie_attribute_pkey on movie_attribute ma  (cost=0.14..1.12 rows=1 width=524) (actual time=0.001..0.001 rows=1 loops=8)
                                Index Cond: (id = mav.movie_attribute_id)
              ->  Hash  (cost=11.40..11.40 rows=140 width=4) (actual time=0.004..0.005 rows=5 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 9kB
                    ->  Seq Scan on movie_attribute_type mat  (cost=0.00..11.40 rows=140 width=4) (actual time=0.002..0.003 rows=5 loops=1)
        ->  Hash Join  (cost=13.59..592.58 rows=50 width=564) (actual time=0.029..4.155 rows=315 loops=1)
              Hash Cond: (ma_1.attribute_type_id = mat_1.id)
              ->  Nested Loop  (cost=0.44..579.29 rows=50 width=536) (actual time=0.021..4.059 rows=315 loops=1)
                    ->  Nested Loop  (cost=0.29..568.13 rows=50 width=20) (actual time=0.015..3.834 rows=315 loops=1)
                          ->  Seq Scan on movie_attribute_value mav_1  (cost=0.00..289.00 rows=50 width=8) (actual time=0.009..3.217 rows=315 loops=1)
                                Filter: ((value_datetime)::date = ((now() + '20 days'::interval))::date)
                                Rows Removed by Filter: 9685
                          ->  Index Scan using movie_pkey on movie m_1  (cost=0.29..5.58 rows=1 width=20) (actual time=0.001..0.001 rows=1 loops=315)
                                Index Cond: (id = mav_1.movie_id)
                    ->  Memoize  (cost=0.15..1.13 rows=1 width=524) (actual time=0.000..0.000 rows=1 loops=315)
                          Cache Key: mav_1.movie_attribute_id
                          Cache Mode: logical
                          Hits: 307  Misses: 8  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                          ->  Index Scan using movie_attribute_pkey on movie_attribute ma_1  (cost=0.14..1.12 rows=1 width=524) (actual time=0.001..0.001 rows=1 loops=8)
                                Index Cond: (id = mav_1.movie_attribute_id)
              ->  Hash  (cost=11.40..11.40 rows=140 width=4) (actual time=0.004..0.005 rows=5 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 9kB
                    ->  Seq Scan on movie_attribute_type mat_1  (cost=0.00..11.40 rows=140 width=4) (actual time=0.002..0.002 rows=5 loops=1)
Planning Time: 0.583 ms
Execution Time: 6.412 ms
*/

/*
Gather Merge  (cost=552513.15..564305.39 rows=99998 width=564) (actual time=109791.240..110159.346 rows=667239 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Sort  (cost=551513.12..551763.12 rows=99998 width=564) (actual time=109761.614..109880.071 rows=222413 loops=3)
        Sort Key: m.name
        Sort Method: external merge  Disk: 7408kB
        Worker 0:  Sort Method: external merge  Disk: 7424kB
        Worker 1:  Sort Method: external merge  Disk: 11512kB
        ->  Parallel Append  (cost=26.73..517913.98 rows=99998 width=564) (actual time=315.461..109327.728 rows=222413 loops=3)
              ->  Hash Join  (cost=26.73..273831.81 rows=20833 width=564) (actual time=108.335..36583.251 rows=111169 loops=3)
                    Hash Cond: (ma.attribute_type_id = mat.id)
                    ->  Hash Join  (cost=13.59..273762.31 rows=20833 width=536) (actual time=14.343..36463.584 rows=111169 loops=3)
                          Hash Cond: (mav.movie_attribute_id = ma.id)
                          ->  Nested Loop  (cost=0.43..273692.82 rows=20833 width=20) (actual time=14.321..36432.485 rows=111169 loops=3)
                                ->  Parallel Seq Scan on movie_attribute_value mav  (cost=0.00..157443.79 rows=20833 width=8) (actual time=7.673..827.653 rows=111169 loops=3)
                                      Filter: ((value_datetime)::date = ((now() + '20 days'::interval))::date)
                                      Rows Removed by Filter: 3222164
                                ->  Index Scan using movie_pkey on movie m  (cost=0.43..5.58 rows=1 width=20) (actual time=0.320..0.320 rows=1 loops=333507)
                                      Index Cond: (id = mav.movie_id)
                          ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.014..0.015 rows=13 loops=3)
                                Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                ->  Seq Scan on movie_attribute ma  (cost=0.00..11.40 rows=140 width=524) (actual time=0.007..0.009 rows=13 loops=3)
                    ->  Hash  (cost=11.40..11.40 rows=140 width=4) (actual time=93.968..93.968 rows=5 loops=3)
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB
                          ->  Seq Scan on movie_attribute_type mat  (cost=0.00..11.40 rows=140 width=4) (actual time=93.962..93.963 rows=5 loops=3)
              ->  Hash Join  (cost=26.73..242582.21 rows=20833 width=564) (actual time=310.750..109077.285 rows=166866 loops=2)
                    Hash Cond: (ma_1.attribute_type_id = mat_1.id)
                    ->  Hash Join  (cost=13.59..242512.71 rows=20833 width=536) (actual time=46.926..108771.678 rows=166866 loops=2)
                          Hash Cond: (mav_1.movie_attribute_id = ma_1.id)
                          ->  Nested Loop  (cost=0.43..242443.22 rows=20833 width=20) (actual time=46.501..108716.380 rows=166866 loops=2)
                                ->  Parallel Seq Scan on movie_attribute_value mav_1  (cost=0.00..126194.19 rows=20833 width=8) (actual time=34.186..4857.166 rows=166866 loops=2)
                                      Filter: ((value_datetime)::date = '2022-06-19'::date)
                                      Rows Removed by Filter: 4833134
                                ->  Index Scan using movie_pkey on movie m_1  (cost=0.43..5.58 rows=1 width=20) (actual time=0.622..0.622 rows=1 loops=333732)
                                      Index Cond: (id = mav_1.movie_id)
                          ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.415..0.415 rows=13 loops=2)
                                Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                ->  Seq Scan on movie_attribute ma_1  (cost=0.00..11.40 rows=140 width=524) (actual time=0.404..0.406 rows=13 loops=2)
                    ->  Hash  (cost=11.40..11.40 rows=140 width=4) (actual time=263.775..263.775 rows=5 loops=2)
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB
                          ->  Seq Scan on movie_attribute_type mat_1  (cost=0.00..11.40 rows=140 width=4) (actual time=263.761..263.765 rows=5 loops=2)
Planning Time: 73.626 ms
JIT:
  Functions: 138
"  Options: Inlining true, Optimization true, Expressions true, Deforming true"
"  Timing: Generation 8.600 ms, Inlining 131.945 ms, Optimization 389.490 ms, Emission 286.685 ms, Total 816.720 ms"
Execution Time: 110188.710 ms
*/

-- Увеличение количества записей вызвало драматическое увеличение времени выполнения запроса

-- Создаем индекс по дате
create index on movie_attribute_value (date(value_datetime));

/*
Gather Merge  (cost=396273.01..408065.49 rows=100000 width=564) (actual time=2388.967..2779.558 rows=667239 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Sort  (cost=395272.98..395522.98 rows=100000 width=564) (actual time=2357.495..2471.868 rows=222413 loops=3)
        Sort Key: m.name
        Sort Method: external merge  Disk: 8984kB
        Worker 0:  Sort Method: external merge  Disk: 8736kB
        Worker 1:  Sort Method: external merge  Disk: 8624kB
        ->  Parallel Append  (cost=586.67..361673.66 rows=100000 width=564) (actual time=51.344..1942.706 rows=222413 loops=3)
              ->  Hash Join  (cost=586.68..180164.96 rows=20833 width=564) (actual time=24.489..957.909 rows=111169 loops=3)
                    Hash Cond: (ma.attribute_type_id = mat.id)
                    ->  Hash Join  (cost=573.53..180095.47 rows=20833 width=536) (actual time=16.783..923.655 rows=111169 loops=3)
                          Hash Cond: (mav.movie_attribute_id = ma.id)
                          ->  Nested Loop  (cost=560.38..180025.97 rows=20833 width=20) (actual time=16.758..892.281 rows=111169 loops=3)
                                ->  Parallel Bitmap Heap Scan on movie_attribute_value mav  (cost=559.94..63777.41 rows=20833 width=8) (actual time=16.732..118.882 rows=111169 loops=3)
                                      Recheck Cond: ((value_datetime)::date = ((now() + '20 days'::interval))::date)
                                      Heap Blocks: exact=10932
                                      ->  Bitmap Index Scan on movie_attribute_value_date_idx  (cost=0.00..547.44 rows=50000 width=0) (actual time=33.860..33.861 rows=333507 loops=1)
                                            Index Cond: ((value_datetime)::date = ((now() + '20 days'::interval))::date)
                                ->  Index Scan using movie_pkey on movie m  (cost=0.43..5.58 rows=1 width=20) (actual time=0.006..0.006 rows=1 loops=333507)
                                      Index Cond: (id = mav.movie_id)
                          ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.018..0.018 rows=13 loops=3)
                                Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                ->  Seq Scan on movie_attribute ma  (cost=0.00..11.40 rows=140 width=524) (actual time=0.012..0.014 rows=13 loops=3)
                    ->  Hash  (cost=11.40..11.40 rows=140 width=4) (actual time=7.667..7.668 rows=5 loops=3)
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB
                          ->  Seq Scan on movie_attribute_type mat  (cost=0.00..11.40 rows=140 width=4) (actual time=7.660..7.661 rows=5 loops=3)
              ->  Hash Join  (cost=586.67..180008.70 rows=20833 width=564) (actual time=40.376..1443.703 rows=166866 loops=2)
                    Hash Cond: (ma_1.attribute_type_id = mat_1.id)
                    ->  Hash Join  (cost=573.52..179939.21 rows=20833 width=536) (actual time=19.707..1382.264 rows=166866 loops=2)
                          Hash Cond: (mav_1.movie_attribute_id = ma_1.id)
                          ->  Nested Loop  (cost=560.37..179869.71 rows=20833 width=20) (actual time=19.671..1333.384 rows=166866 loops=2)
                                ->  Parallel Bitmap Heap Scan on movie_attribute_value mav_1  (cost=559.93..63621.16 rows=20833 width=8) (actual time=19.596..174.457 rows=166866 loops=2)
                                      Recheck Cond: ((value_datetime)::date = '2022-06-19'::date)
                                      Heap Blocks: exact=32249
                                      ->  Bitmap Index Scan on movie_attribute_value_date_idx  (cost=0.00..547.43 rows=50000 width=0) (actual time=24.028..24.028 rows=333732 loops=1)
                                            Index Cond: ((value_datetime)::date = '2022-06-19'::date)
                                ->  Index Scan using movie_pkey on movie m_1  (cost=0.43..5.58 rows=1 width=20) (actual time=0.006..0.006 rows=1 loops=333732)
                                      Index Cond: (id = mav_1.movie_id)
                          ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.028..0.028 rows=13 loops=2)
                                Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                ->  Seq Scan on movie_attribute ma_1  (cost=0.00..11.40 rows=140 width=524) (actual time=0.023..0.024 rows=13 loops=2)
                    ->  Hash  (cost=11.40..11.40 rows=140 width=4) (actual time=20.598..20.598 rows=5 loops=2)
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB
                          ->  Seq Scan on movie_attribute_type mat_1  (cost=0.00..11.40 rows=140 width=4) (actual time=20.585..20.589 rows=5 loops=2)
Planning Time: 0.747 ms
JIT:
  Functions: 141
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 9.520 ms, Inlining 0.000 ms, Optimization 3.833 ms, Emission 59.018 ms, Total 72.371 ms"
Execution Time: 2809.483 ms
*/

-- Вывод: а в этом случае применение индекса для даты уменьшило время выполнения запроса в ~40 раз

/*==================================================================================================*/

-- Вывод всех атрибутов для фильмов, в названии которых пять букв
explain analyse
select movie.name                 as MovieName,
       mat.name                   as AttributeType,
       ma.name                    as AttributeName,
       concat(mav.value_string, mav.value_integer, mav.value_float, mav.value_boolean,
              mav.value_datetime) as AttributeValue

from movie
         join movie_attribute_value mav on movie.id = mav.movie_id
         join movie_attribute ma on ma.id = mav.movie_attribute_id
         join movie_attribute_type mat on mat.id = ma.attribute_type_id
where length(movie.name) = 5;

/*
Hash Join  (cost=242.93..436.02 rows=50 width=1080) (actual time=1.630..4.133 rows=351 loops=1)
  Hash Cond: (ma.attribute_type_id = mat.id)
  ->  Nested Loop  (cost=229.78..422.61 rows=50 width=589) (actual time=1.613..3.900 rows=351 loops=1)
        ->  Hash Join  (cost=229.62..419.89 rows=50 width=73) (actual time=1.601..3.623 rows=351 loops=1)
              Hash Cond: (mav.movie_id = movie.id)
              ->  Seq Scan on movie_attribute_value mav  (cost=0.00..164.00 rows=10000 width=61) (actual time=0.002..0.744 rows=10000 loops=1)
              ->  Hash  (cost=229.00..229.00 rows=50 width=20) (actual time=1.593..1.594 rows=354 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 24kB
                    ->  Seq Scan on movie  (cost=0.00..229.00 rows=50 width=20) (actual time=0.004..1.512 rows=354 loops=1)
                          Filter: (length((name)::text) = 5)
                          Rows Removed by Filter: 9646
        ->  Memoize  (cost=0.15..0.18 rows=1 width=524) (actual time=0.000..0.000 rows=1 loops=351)
              Cache Key: mav.movie_attribute_id
              Cache Mode: logical
              Hits: 343  Misses: 8  Evictions: 0  Overflows: 0  Memory Usage: 1kB
              ->  Index Scan using movie_attribute_pkey on movie_attribute ma  (cost=0.14..0.17 rows=1 width=524) (actual time=0.001..0.001 rows=1 loops=8)
                    Index Cond: (id = mav.movie_attribute_id)
  ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.008..0.009 rows=5 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Seq Scan on movie_attribute_type mat  (cost=0.00..11.40 rows=140 width=520) (actual time=0.005..0.006 rows=5 loops=1)
Planning Time: 0.220 ms
Execution Time: 4.178 ms
*/

/*
Gather  (cost=142422.71..263885.87 rows=49999 width=1080) (actual time=1259.036..1893.673 rows=346006 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Hash Join  (cost=141422.71..257885.97 rows=20833 width=1080) (actual time=1234.567..1782.964 rows=115335 loops=3)
        Hash Cond: (ma.attribute_type_id = mat.id)
        ->  Hash Join  (cost=141409.56..257764.40 rows=20833 width=589) (actual time=1219.036..1722.056 rows=115335 loops=3)
              Hash Cond: (mav.movie_attribute_id = ma.id)
              ->  Parallel Hash Join  (cost=141396.41..257694.90 rows=20833 width=73) (actual time=1218.996..1693.151 rows=115335 loops=3)
                    Hash Cond: (mav.movie_id = movie.id)
                    ->  Parallel Seq Scan on movie_attribute_value mav  (cost=0.00..105361.13 rows=4166613 width=61) (actual time=0.018..232.209 rows=3333333 loops=3)
                    ->  Parallel Hash  (cost=141136.00..141136.00 rows=20833 width=20) (actual time=463.047..463.047 rows=115145 loops=3)
                          Buckets: 65536 (originally 65536)  Batches: 8 (originally 1)  Memory Usage: 2592kB
                          ->  Parallel Seq Scan on movie  (cost=0.00..141136.00 rows=20833 width=20) (actual time=0.021..419.881 rows=115145 loops=3)
                                Filter: (length((name)::text) = 5)
                                Rows Removed by Filter: 3218188
              ->  Hash  (cost=11.40..11.40 rows=140 width=524) (actual time=0.030..0.030 rows=13 loops=3)
                    Buckets: 1024  Batches: 1  Memory Usage: 9kB
                    ->  Seq Scan on movie_attribute ma  (cost=0.00..11.40 rows=140 width=524) (actual time=0.024..0.026 rows=13 loops=3)
        ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=15.421..15.422 rows=5 loops=3)
              Buckets: 1024  Batches: 1  Memory Usage: 9kB
              ->  Seq Scan on movie_attribute_type mat  (cost=0.00..11.40 rows=140 width=520) (actual time=15.409..15.413 rows=5 loops=3)
Planning Time: 0.314 ms
JIT:
  Functions: 87
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 6.383 ms, Inlining 0.000 ms, Optimization 2.792 ms, Emission 42.613 ms, Total 51.787 ms"
Execution Time: 1909.360 ms
*/

-- Увеличение количества записей вызвало увеличение времени запроса

-- Вывод аналогичен ситуации с простым запросом:
-- если нужен запрос, где в условии используется функция, то, вероятно, лучше высчитывать значения предварительно
-- и сохранять в отдельную колонку, на которую уже создавать индекс