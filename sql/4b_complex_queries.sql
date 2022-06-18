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