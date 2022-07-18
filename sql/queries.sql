1) -- Билеты, стоимость которых дороже 150, но дешевле 200 рублей
EXPLAIN ANALYZE
select full_price
from ticket
where full_price > 150
  AND full_price < 200

/*
   Gather  (cost=1000.00..160657.79 rows=462451 width=5) (actual time=25.061..762.125 rows=518086 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on ticket  (cost=0.00..113412.69 rows=192688 width=5) (actual time=10.439..636.231 rows=172695 loops=3)
        Filter: ((full_price > '150'::numeric) AND (full_price < '200'::numeric))
        Rows Removed by Filter: 2823009
Planning Time: 0.239 ms
JIT:
  Functions: 12
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 7.690 ms, Inlining 0.000 ms, Optimization 8.139 ms, Emission 22.385 ms, Total 38.213 ms
Execution Time: 789.736 ms
   */

CREATE INDEX ON ticket (full_price);

/*
Index Only Scan using ticket_full_price_idx on ticket  (cost=0.43..14329.41 rows=462449 width=5) (actual time=0.030..92.298 rows=518086 loops=1)
  Index Cond: ((full_price > '150'::numeric) AND (full_price < '200'::numeric))
  Heap Fetches: 0
Planning Time: 0.818 ms
Execution Time: 111.114 ms
 */

После добавления индекса, скорость выполнения увеличиась почти в 7 раз

2) -- Фильмы с длительностью от 01:40:00 до 02:00:00
explain analyze
select duration
from film
where duration >= '01:40:00'
  and duration <= '02:00:00'

/*
Seq Scan on film  (cost=0.00..24.00 rows=140 width=8) (actual time=0.760..1.517 rows=140 loops=1)
  Filter: ((duration >= '01:40:00'::time without time zone) AND (duration <= '02:00:00'::time without time zone))
  Rows Removed by Filter: 860
Planning Time: 2.207 ms
Execution Time: 1.537 ms
 */

CREATE INDEX on film (duration);
/*
Bitmap Heap Scan on film  (cost=5.71..16.81 rows=140 width=8) (actual time=0.073..0.126 rows=140 loops=1)
  Recheck Cond: ((duration >= '01:40:00'::time without time zone) AND (duration <= '02:00:00'::time without time zone))
  Heap Blocks: exact=9
  ->  Bitmap Index Scan on film_duration_idx  (cost=0.00..5.68 rows=140 width=0) (actual time=0.067..0.067 rows=140 loops=1)
        Index Cond: ((duration >= '01:40:00'::time without time zone) AND (duration <= '02:00:00'::time without time zone))
Planning Time: 0.219 ms
Execution Time: 0.257 ms
 */

После добавления индекса, скорость выполнения запроса увеличилась

3) -- все сеансы с 1 по 10 марта
explain analyze
select *
from session
where time > '2022-03-01 00:00:00'
  and time < '2022-03-10 23:59:59'

/*
Gather  (cost=1000.00..19053.60 rows=54336 width=24) (actual time=0.267..102.020 rows=55377 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on session  (cost=0.00..12620.00 rows=22640 width=24) (actual time=0.013..55.409 rows=18459 loops=3)
        Filter: (("time" > '2022-03-01 00:00:00'::timestamp without time zone) AND ("time" < '2022-03-10 23:59:59'::timestamp without time zone))
        Rows Removed by Filter: 314874
Planning Time: 0.266 ms
Execution Time: 105.687 ms
 */

create index on session (time);

/*
Bitmap Heap Scan on session  (cost=1157.37..8342.41 rows=54336 width=24) (actual time=6.114..23.731 rows=55377 loops=1)
  Recheck Cond: (("time" > '2022-03-01 00:00:00'::timestamp without time zone) AND ("time" < '2022-03-10 23:59:59'::timestamp without time zone))
  Heap Blocks: exact=6368
  ->  Bitmap Index Scan on session_time_idx  (cost=0.00..1143.79 rows=54336 width=0) (actual time=5.173..5.174 rows=55377 loops=1)
        Index Cond: (("time" > '2022-03-01 00:00:00'::timestamp without time zone) AND ("time" < '2022-03-10 23:59:59'::timestamp without time zone))
Planning Time: 0.202 ms
Execution Time: 25.909 ms
 */
После добавления индекса, скорость выполнения увеличилась больше чем в 4 раза.


4) -- самый дорогой фильм
explain analyze
SELECT f.name, sum(t.full_price::numeric) AS total
FROM ticket t
         LEFT JOIN session s ON s.id = t.session_id
         LEFT JOIN film f ON f.id = s.film_id
GROUP BY f.name
ORDER BY total desc
LIMIT 1;

/*
Limit  (cost=190044.19..190044.19 rows=1 width=48) (actual time=7623.029..7693.268 rows=1 loops=1)
  ->  Sort  (cost=190044.19..190046.69 rows=1000 width=48) (actual time=7609.145..7679.383 rows=1 loops=1)
        Sort Key: (sum((t.full_price)::numeric)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=189778.34..190039.19 rows=1000 width=48) (actual time=7604.189..7678.995 rows=1000 loops=1)
              Group Key: f.name
              ->  Gather Merge  (cost=189778.34..190011.69 rows=2000 width=48) (actual time=7604.122..7675.909 rows=3000 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Sort  (cost=188778.32..188780.82 rows=1000 width=48) (actual time=7580.169..7580.390 rows=1000 loops=3)
                          Sort Key: f.name
                          Sort Method: quicksort  Memory: 165kB
                          Worker 0:  Sort Method: quicksort  Memory: 165kB
                          Worker 1:  Sort Method: quicksort  Memory: 165kB
                          ->  Partial HashAggregate  (cost=188715.99..188728.49 rows=1000 width=48) (actual time=7576.413..7577.540 rows=1000 loops=3)
                                Group Key: f.name
                                Batches: 1  Memory Usage: 577kB
                                Worker 0:  Batches: 1  Memory Usage: 577kB
                                Worker 1:  Batches: 1  Memory Usage: 577kB
                                ->  Hash Left Join  (cost=17404.50..169992.83 rows=3744631 width=21) (actual time=2088.175..5703.235 rows=2995705 loops=3)
                                      Hash Cond: (s.film_id = f.id)
                                      ->  Parallel Hash Left Join  (cost=17373.00..160090.01 rows=3744631 width=9) (actual time=2087.561..4303.092 rows=2995705 loops=3)
                                            Hash Cond: (t.session_id = s.id)
                                            ->  Parallel Seq Scan on ticket t  (cost=0.00..94689.31 rows=3744631 width=9) (actual time=0.041..559.439 rows=2995705 loops=3)
                                            ->  Parallel Hash  (cost=10536.67..10536.67 rows=416667 width=8) (actual time=117.664..117.665 rows=333333 loops=3)
                                                  Buckets: 131072  Batches: 16  Memory Usage: 3520kB
                                                  ->  Parallel Seq Scan on session s  (cost=0.00..10536.67 rows=416667 width=8) (actual time=6.328..49.886 rows=333333 loops=3)
                                      ->  Hash  (cost=19.00..19.00 rows=1000 width=20) (actual time=0.574..0.575 rows=1000 loops=3)
                                            Buckets: 1024  Batches: 1  Memory Usage: 59kB
                                            ->  Seq Scan on film f  (cost=0.00..19.00 rows=1000 width=20) (actual time=0.033..0.283 rows=1000 loops=3)
Planning Time: 7.394 ms
JIT:
  Functions: 73
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 5.676 ms, Inlining 0.000 ms, Optimization 1.522 ms, Emission 30.656 ms, Total 37.854 ms
Execution Time: 7696.764 ms
 */

create index on film (name)

/*
 Limit  (cost=190044.19..190044.19 rows=1 width=48) (actual time=4603.250..4661.028 rows=1 loops=1)
  ->  Sort  (cost=190044.19..190046.69 rows=1000 width=48) (actual time=4592.076..4649.853 rows=1 loops=1)
        Sort Key: (sum((t.full_price)::numeric)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=189778.34..190039.19 rows=1000 width=48) (actual time=4588.925..4649.628 rows=1000 loops=1)
              Group Key: f.name
              ->  Gather Merge  (cost=189778.34..190011.69 rows=2000 width=48) (actual time=4588.906..4647.708 rows=3000 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Sort  (cost=188778.32..188780.82 rows=1000 width=48) (actual time=4563.749..4563.831 rows=1000 loops=3)
                          Sort Key: f.name
                          Sort Method: quicksort  Memory: 165kB
                          Worker 0:  Sort Method: quicksort  Memory: 165kB
                          Worker 1:  Sort Method: quicksort  Memory: 165kB
                          ->  Partial HashAggregate  (cost=188715.99..188728.49 rows=1000 width=48) (actual time=4561.445..4561.988 rows=1000 loops=3)
                                Group Key: f.name
                                Batches: 1  Memory Usage: 577kB
                                Worker 0:  Batches: 1  Memory Usage: 577kB
                                Worker 1:  Batches: 1  Memory Usage: 577kB
                                ->  Hash Left Join  (cost=17404.50..169992.83 rows=3744631 width=21) (actual time=1352.743..3509.603 rows=2995705 loops=3)
                                      Hash Cond: (s.film_id = f.id)
                                      ->  Parallel Hash Left Join  (cost=17373.00..160090.01 rows=3744631 width=9) (actual time=1352.269..2716.931 rows=2995705 loops=3)
                                            Hash Cond: (t.session_id = s.id)
                                            ->  Parallel Seq Scan on ticket t  (cost=0.00..94689.31 rows=3744631 width=9) (actual time=0.039..521.511 rows=2995705 loops=3)
                                            ->  Parallel Hash  (cost=10536.67..10536.67 rows=416667 width=8) (actual time=126.177..126.178 rows=333333 loops=3)
                                                  Buckets: 131072  Batches: 16  Memory Usage: 3520kB
                                                  ->  Parallel Seq Scan on session s  (cost=0.00..10536.67 rows=416667 width=8) (actual time=6.270..52.879 rows=333333 loops=3)
                                      ->  Hash  (cost=19.00..19.00 rows=1000 width=20) (actual time=0.297..0.297 rows=1000 loops=3)
                                            Buckets: 1024  Batches: 1  Memory Usage: 59kB
                                            ->  Seq Scan on film f  (cost=0.00..19.00 rows=1000 width=20) (actual time=0.021..0.148 rows=1000 loops=3)
Planning Time: 0.682 ms
JIT:
  Functions: 73
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 5.399 ms, Inlining 0.000 ms, Optimization 1.448 ms, Emission 27.725 ms, Total 34.572 ms
Execution Time: 4663.205 ms
 */

Добавление обычного индекса на name в таблице film не изменило ситуацию.


Поэтому попробуем добавить Generalized Inverted Index

create index on film using gin (TO_TSVECTOR('english', name));

/*
Limit  (cost=190044.19..190044.19 rows=1 width=48) (actual time=4634.907..4684.791 rows=1 loops=1)
  ->  Sort  (cost=190044.19..190046.69 rows=1000 width=48) (actual time=4623.232..4673.115 rows=1 loops=1)
        Sort Key: (sum((t.full_price)::numeric)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=189778.34..190039.19 rows=1000 width=48) (actual time=4619.996..4672.886 rows=1000 loops=1)
              Group Key: f.name
              ->  Gather Merge  (cost=189778.34..190011.69 rows=2000 width=48) (actual time=4619.877..4670.813 rows=3000 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Sort  (cost=188778.32..188780.82 rows=1000 width=48) (actual time=4591.443..4591.536 rows=1000 loops=3)
                          Sort Key: f.name
                          Sort Method: quicksort  Memory: 165kB
                          Worker 0:  Sort Method: quicksort  Memory: 165kB
                          Worker 1:  Sort Method: quicksort  Memory: 165kB
                          ->  Partial HashAggregate  (cost=188715.99..188728.49 rows=1000 width=48) (actual time=4588.914..4589.542 rows=1000 loops=3)
                                Group Key: f.name
                                Batches: 1  Memory Usage: 577kB
                                Worker 0:  Batches: 1  Memory Usage: 577kB
                                Worker 1:  Batches: 1  Memory Usage: 577kB
                                ->  Hash Left Join  (cost=17404.50..169992.83 rows=3744631 width=21) (actual time=1283.718..3508.105 rows=2995705 loops=3)
                                      Hash Cond: (s.film_id = f.id)
                                      ->  Parallel Hash Left Join  (cost=17373.00..160090.01 rows=3744631 width=9) (actual time=1283.196..2692.861 rows=2995705 loops=3)
                                            Hash Cond: (t.session_id = s.id)
                                            ->  Parallel Seq Scan on ticket t  (cost=0.00..94689.31 rows=3744631 width=9) (actual time=0.052..499.729 rows=2995705 loops=3)
                                            ->  Parallel Hash  (cost=10536.67..10536.67 rows=416667 width=8) (actual time=116.010..116.011 rows=333333 loops=3)
                                                  Buckets: 131072  Batches: 16  Memory Usage: 3520kB
                                                  ->  Parallel Seq Scan on session s  (cost=0.00..10536.67 rows=416667 width=8) (actual time=6.503..50.053 rows=333333 loops=3)
                                      ->  Hash  (cost=19.00..19.00 rows=1000 width=20) (actual time=0.344..0.345 rows=1000 loops=3)
                                            Buckets: 1024  Batches: 1  Memory Usage: 59kB
                                            ->  Seq Scan on film f  (cost=0.00..19.00 rows=1000 width=20) (actual time=0.040..0.183 rows=1000 loops=3)
Planning Time: 0.601 ms
JIT:
  Functions: 73
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 5.439 ms, Inlining 0.000 ms, Optimization 1.419 ms, Emission 29.035 ms, Total 35.893 ms
Execution Time: 4687.115 ms
 */

В данном случае, это так же сильно не изменило ситуацию. Значит индекс не нужен.

drop index film_to_tsvector_idx
drop index film_name_idx

5) -- самый длинный фильм, на который куплено больше всего билетов
explain analyze
SELECT f.name, f.duration, count (t.*) as ticket_count
FROM film f
         INNER JOIN session s ON f.id = s.film_id
         INNER JOIN ticket t ON s.id = t.session_id
WHERE f.duration = (select MAX(duration) from film)
GROUP BY f.name, f.duration
LIMIT 1;

/*
Limit  (cost=13119.03..13119.29 rows=1 width=32) (actual time=188.131..193.235 rows=1 loops=1)
  InitPlan 2 (returns $1)
    ->  Result  (cost=0.35..0.36 rows=1 width=8) (actual time=0.020..0.022 rows=1 loops=1)
          InitPlan 1 (returns $0)
            ->  Limit  (cost=0.28..0.35 rows=1 width=8) (actual time=0.018..0.019 rows=1 loops=1)
                  ->  Index Only Scan Backward using film_duration_idx on film  (cost=0.28..73.75 rows=1000 width=8) (actual time=0.017..0.018 rows=1 loops=1)
                        Index Cond: (duration IS NOT NULL)
                        Heap Fetches: 1
  ->  Finalize GroupAggregate  (cost=13118.68..13118.94 rows=1 width=32) (actual time=188.129..193.231 rows=1 loops=1)
        Group Key: f.name, f.duration
        ->  Gather Merge  (cost=13118.68..13118.91 rows=2 width=32) (actual time=188.120..193.222 rows=3 loops=1)
              Workers Planned: 2
              Params Evaluated: $1
              Workers Launched: 2
              ->  Sort  (cost=12118.65..12118.66 rows=1 width=32) (actual time=162.937..162.940 rows=1 loops=3)
                    Sort Key: f.name
                    Sort Method: quicksort  Memory: 25kB
                    Worker 0:  Sort Method: quicksort  Memory: 25kB
                    Worker 1:  Sort Method: quicksort  Memory: 25kB
                    ->  Partial HashAggregate  (cost=12118.63..12118.64 rows=1 width=32) (actual time=162.920..162.922 rows=1 loops=3)
                          Group Key: f.name, f.duration
                          Batches: 1  Memory Usage: 24kB
                          Worker 0:  Batches: 1  Memory Usage: 24kB
                          Worker 1:  Batches: 1  Memory Usage: 24kB
                          ->  Nested Loop  (cost=8.74..12090.54 rows=3745 width=69) (actual time=0.645..160.335 rows=2969 loops=3)
                                ->  Hash Join  (cost=8.30..11643.36 rows=417 width=28) (actual time=0.118..67.079 rows=331 loops=3)
                                      Hash Cond: (s.film_id = f.id)
                                      ->  Parallel Seq Scan on session s  (cost=0.00..10536.67 rows=416667 width=8) (actual time=0.006..29.456 rows=333333 loops=3)
                                      ->  Hash  (cost=8.29..8.29 rows=1 width=28) (actual time=0.015..0.016 rows=1 loops=3)
                                            Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                            ->  Index Scan using film_duration_idx on film f  (cost=0.28..8.29 rows=1 width=28) (actual time=0.012..0.012 rows=1 loops=3)
                                                  Index Cond: (duration = $1)
                                ->  Index Scan using ticket_session_id_place_id_idx on ticket t  (cost=0.43..0.97 rows=10 width=49) (actual time=0.175..0.278 rows=9 loops=992)
                                      Index Cond: (session_id = s.id)
Planning Time: 0.490 ms
Execution Time: 193.343 ms
 */

Также, можно добавить индекс на film_id в таблице session
create index on session (film_id)

/*
Limit  (cost=3845.71..3845.72 rows=1 width=32) (actual time=20.634..20.638 rows=1 loops=1)
  InitPlan 2 (returns $1)
    ->  Result  (cost=0.35..0.36 rows=1 width=8) (actual time=0.014..0.016 rows=1 loops=1)
          InitPlan 1 (returns $0)
            ->  Limit  (cost=0.28..0.35 rows=1 width=8) (actual time=0.013..0.014 rows=1 loops=1)
                  ->  Index Only Scan Backward using film_duration_idx on film  (cost=0.28..73.75 rows=1000 width=8) (actual time=0.012..0.013 rows=1 loops=1)
                        Index Cond: (duration IS NOT NULL)
                        Heap Fetches: 1
  ->  HashAggregate  (cost=3845.35..3845.36 rows=1 width=32) (actual time=20.632..20.634 rows=1 loops=1)
        Group Key: f.name, f.duration
        Batches: 1  Memory Usage: 24kB
        ->  Nested Loop  (cost=12.61..3777.95 rows=8987 width=69) (actual time=0.417..17.487 rows=8907 loops=1)
              ->  Nested Loop  (cost=12.18..2705.57 rows=1000 width=28) (actual time=0.399..2.431 rows=992 loops=1)
                    ->  Seq Scan on film f  (cost=0.00..21.50 rows=1 width=28) (actual time=0.025..0.098 rows=1 loops=1)
                          Filter: (duration = $1)
                          Rows Removed by Filter: 999
                    ->  Bitmap Heap Scan on session s  (cost=12.18..2674.07 rows=1000 width=8) (actual time=0.370..2.134 rows=992 loops=1)
                          Recheck Cond: (film_id = f.id)
                          Heap Blocks: exact=926
                          ->  Bitmap Index Scan on session_film_id_idx  (cost=0.00..11.93 rows=1000 width=0) (actual time=0.132..0.133 rows=992 loops=1)
                                Index Cond: (film_id = f.id)
              ->  Index Scan using ticket_session_id_place_id_idx on ticket t  (cost=0.43..0.97 rows=10 width=49) (actual time=0.004..0.014 rows=9 loops=992)
                    Index Cond: (session_id = s.id)
Planning Time: 0.728 ms
Execution Time: 20.687 ms
 */

 Добавление еще одного индекса ускорило запрос в 9 раз

6) -- Самый частый клиент и фильм на котором он был
explain analyze
select t.customer_id, count(t.*) as count, f.name
from ticket as t
         inner join session s on t.session_id=s.id
         inner join film f on s.film_id = f.id
group by f.name, t.customer_id
order by count desc
limit 1

/*
 Limit  (cost=2053903.47..2053903.47 rows=1 width=28) (actual time=44265.990..44449.488 rows=1 loops=1)
  ->  Sort  (cost=2053903.47..2076371.25 rows=8987114 width=28) (actual time=43955.957..44139.454 rows=1 loops=1)
        Sort Key: (count(t.*)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=923588.01..2008967.90 rows=8987114 width=28) (actual time=30066.109..42205.858 rows=8723653 loops=1)
              Group Key: f.name, t.customer_id
              ->  Gather Merge  (cost=923588.01..1862927.29 rows=7489262 width=28) (actual time=30066.011..37765.270 rows=8898105 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Partial GroupAggregate  (cost=922587.99..997480.61 rows=3744631 width=28) (actual time=30013.278..33349.495 rows=2966035 loops=3)
                          Group Key: f.name, t.customer_id
                          ->  Sort  (cost=922587.99..931949.56 rows=3744631 width=65) (actual time=30013.029..31495.228 rows=2995705 loops=3)
                                Sort Key: f.name, t.customer_id
                                Sort Method: external merge  Disk: 210272kB
                                Worker 0:  Sort Method: external merge  Disk: 210272kB
                                Worker 1:  Sort Method: external merge  Disk: 212752kB
                                ->  Hash Join  (cost=17404.50..206560.83 rows=3744631 width=65) (actual time=7095.371..10485.924 rows=2995705 loops=3)
                                      Hash Cond: (s.film_id = f.id)
                                      ->  Parallel Hash Join  (cost=17373.00..196658.01 rows=3744631 width=53) (actual time=6958.179..9251.118 rows=2995705 loops=3)
                                            Hash Cond: (t.session_id = s.id)
                                            ->  Parallel Seq Scan on ticket t  (cost=0.00..94689.31 rows=3744631 width=53) (actual time=0.051..1245.229 rows=2995705 loops=3)
                                            ->  Parallel Hash  (cost=10536.67..10536.67 rows=416667 width=8) (actual time=113.305..113.306 rows=333333 loops=3)
                                                  Buckets: 131072  Batches: 16  Memory Usage: 3520kB
                                                  ->  Parallel Seq Scan on session s  (cost=0.00..10536.67 rows=416667 width=8) (actual time=0.011..37.779 rows=333333 loops=3)
                                      ->  Hash  (cost=19.00..19.00 rows=1000 width=20) (actual time=137.168..137.169 rows=1000 loops=3)
                                            Buckets: 1024  Batches: 1  Memory Usage: 59kB
                                            ->  Seq Scan on film f  (cost=0.00..19.00 rows=1000 width=20) (actual time=136.882..136.995 rows=1000 loops=3)
Planning Time: 0.391 ms
JIT:
  Functions: 73
  Options: Inlining true, Optimization true, Expressions true, Deforming true
  Timing: Generation 5.499 ms, Inlining 158.840 ms, Optimization 333.051 ms, Emission 227.970 ms, Total 725.360 ms
Execution Time: 44530.147 ms
 */

Добавление индексов не ускоряет запрос