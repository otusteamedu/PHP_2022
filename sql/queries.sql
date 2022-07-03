-- Билеты, стоимость которых дороже 150, но дешевле 200 рублей
EXPLAIN ANALYZE
select full_price
from ticket
where full_price::numeric > 150
  AND full_price::numeric < 200

/* Gather  (cost=1000.00..137636.65 rows=44938 width=8) (actual time=5.367..5047.006 rows=518908 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on ticket  (cost=0.00..132142.85 rows=18724 width=8) (actual time=4.379..4967.396 rows=172969 loops=3)
        Filter: (((full_price)::numeric > '150'::numeric) AND ((full_price)::numeric < '200'::numeric))
        Rows Removed by Filter: 2822888
Planning Time: 0.190 ms
JIT:
  Functions: 12
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 1.824 ms, Inlining 0.000 ms, Optimization 1.064 ms, Emission 11.483 ms, Total 14.371 ms
Execution Time: 5084.442 ms
   */

CREATE INDEX ON ticket (full_price);

/*
 Gather  (cost=1000.00..137636.24 rows=44938 width=8) (actual time=5.223..3571.167 rows=518908 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on ticket  (cost=0.00..132142.44 rows=18724 width=8) (actual time=4.202..3509.980 rows=172969 loops=3)
        Filter: (((full_price)::numeric > '150'::numeric) AND ((full_price)::numeric < '200'::numeric))
        Rows Removed by Filter: 2822888
Planning Time: 0.141 ms
JIT:
  Functions: 12
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 1.732 ms, Inlining 0.000 ms, Optimization 0.920 ms, Emission 11.083 ms, Total 13.735 ms
Execution Time: 3596.643 ms
 */

-- Фильмы с длительностью от 01:40:00 до 02:00:00
explain analyze
select duration
from film
where duration >= '01:40:00'
  and duration <= '02:00:00'

/*
 Seq Scan on film  (cost=0.00..24.00 rows=161 width=8) (actual time=0.597..1.242 rows=160 loops=1)
  Filter: ((duration >= '01:40:00'::time without time zone) AND (duration <= '02:00:00'::time without time zone))
  Rows Removed by Filter: 840
Planning Time: 1.006 ms
Execution Time: 1.260 ms
 */

CREATE INDEX on film (duration);
/*
 Bitmap Heap Scan on film  (cost=5.93..17.34 rows=161 width=8) (actual time=0.026..0.060 rows=160 loops=1)
  Recheck Cond: ((duration >= '01:40:00'::time without time zone) AND (duration <= '02:00:00'::time without time zone))
  Heap Blocks: exact=9
  ->  Bitmap Index Scan on film_duration_idx  (cost=0.00..5.89 rows=161 width=0) (actual time=0.019..0.019 rows=160 loops=1)
        Index Cond: ((duration >= '01:40:00'::time without time zone) AND (duration <= '02:00:00'::time without time zone))
Planning Time: 0.221 ms
Execution Time: 0.081 ms
 */

-- все сеансы с 1 по 10 марта
explain analyze
select *
from session
where time > '2022-03-01 00:00:00'
  and time < '2022-03-10 23:59:59'

/*
 Gather  (cost=1000.00..19058.60 rows=54386 width=24) (actual time=0.346..61.086 rows=54978 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Parallel Seq Scan on session  (cost=0.00..12620.00 rows=22661 width=24) (actual time=0.011..32.102 rows=18326 loops=3)
        Filter: (("time" > '2022-03-01 00:00:00'::timestamp without time zone) AND ("time" < '2022-03-10 23:59:59'::timestamp without time zone))
        Rows Removed by Filter: 315007
Planning Time: 0.098 ms
Execution Time: 63.315 ms
 */

create index on session (time);

/*
 Bitmap Heap Scan on session  (cost=1157.88..8343.67 rows=54386 width=24) (actual time=5.557..21.732 rows=54978 loops=1)
 Recheck Cond: (("time" > '2022-03-01 00:00:00'::timestamp without time zone) AND ("time" < '2022-03-10 23:59:59'::timestamp without time zone))
 Heap Blocks: exact=6370
 ->  Bitmap Index Scan on session_time_idx  (cost=0.00..1144.29 rows=54386 width=0) (actual time=4.765..4.766 rows=54978 loops=1)
       Index Cond: (("time" > '2022-03-01 00:00:00'::timestamp without time zone) AND ("time" < '2022-03-10 23:59:59'::timestamp without time zone))
Planning Time: 0.336 ms
Execution Time: 23.734 ms
 */

-- самый дорогой фильм
explain analyze
SELECT f.name, sum(t.full_price::numeric) AS total
FROM ticket t
         LEFT JOIN session s ON s.id = t.session_id
         LEFT JOIN film f ON f.id = s.film_id
GROUP BY f.name
ORDER BY total desc
LIMIT 1;

/*
 Limit  (cost=199434.90..199434.90 rows=1 width=48) (actual time=6356.139..6408.308 rows=1 loops=1)
  ->  Sort  (cost=199434.90..199437.40 rows=1000 width=48) (actual time=6345.165..6397.333 rows=1 loops=1)
        Sort Key: (sum((t.full_price)::numeric)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=199169.05..199429.90 rows=1000 width=48) (actual time=6342.033..6397.104 rows=1000 loops=1)
              Group Key: f.name
              ->  Gather Merge  (cost=199169.05..199402.40 rows=2000 width=48) (actual time=6342.013..6395.244 rows=3000 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Sort  (cost=198169.03..198171.53 rows=1000 width=48) (actual time=6317.730..6318.170 rows=1000 loops=3)
                          Sort Key: f.name
                          Sort Method: quicksort  Memory: 165kB
                          Worker 0:  Sort Method: quicksort  Memory: 165kB
                          Worker 1:  Sort Method: quicksort  Memory: 165kB
                          ->  Partial HashAggregate  (cost=198106.70..198119.20 rows=1000 width=48) (actual time=6316.074..6316.887 rows=1000 loops=3)
                                Group Key: f.name
                                Batches: 1  Memory Usage: 577kB
                                Worker 0:  Batches: 1  Memory Usage: 577kB
                                Worker 1:  Batches: 1  Memory Usage: 577kB
                                ->  Hash Left Join  (cost=17404.50..170017.64 rows=3745208 width=24) (actual time=1295.580..3623.592 rows=2996202 loops=3)
                                      Hash Cond: (s.film_id = f.id)
                                      ->  Parallel Hash Left Join  (cost=17373.00..160113.30 rows=3745208 width=12) (actual time=1295.252..2737.097 rows=2996202 loops=3)
                                            Hash Cond: (t.session_id = s.id)
                                            ->  Parallel Seq Scan on ticket t  (cost=0.00..94705.08 rows=3745208 width=12) (actual time=0.060..504.336 rows=2996202 loops=3)
                                            ->  Parallel Hash  (cost=10536.67..10536.67 rows=416667 width=8) (actual time=121.996..121.997 rows=333333 loops=3)
                                                  Buckets: 131072  Batches: 16  Memory Usage: 3520kB
                                                  ->  Parallel Seq Scan on session s  (cost=0.00..10536.67 rows=416667 width=8) (actual time=6.395..53.047 rows=333333 loops=3)
                                      ->  Hash  (cost=19.00..19.00 rows=1000 width=20) (actual time=0.312..0.313 rows=1000 loops=3)
                                            Buckets: 1024  Batches: 1  Memory Usage: 59kB
                                            ->  Seq Scan on film f  (cost=0.00..19.00 rows=1000 width=20) (actual time=0.017..0.155 rows=1000 loops=3)
Planning Time: 0.286 ms
JIT:
  Functions: 73
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 6.704 ms, Inlining 0.000 ms, Optimization 1.586 ms, Emission 27.839 ms, Total 36.129 ms
Execution Time: 6412.045 ms
 */

Добавление индекса на name в таблице film не изменило ситуацию.INSERT INTO

-- самый длинный фильм, на который куплено больше всего билетов
explain analyze
SELECT f.name, f.duration, count (t.*) as ticket_count
FROM film f
         INNER JOIN session s ON f.id = s.film_id
         INNER JOIN ticket t ON s.id = t.session_id
WHERE f.duration = (select MAX(duration) from film)
GROUP BY f.name, f.duration
LIMIT 1;

/*
 Limit  (cost=3754.40..3754.41 rows=1 width=32) (actual time=18.288..18.292 rows=1 loops=1)
  InitPlan 2 (returns $1)
    ->  Result  (cost=0.35..0.36 rows=1 width=8) (actual time=0.015..0.016 rows=1 loops=1)
          InitPlan 1 (returns $0)
            ->  Limit  (cost=0.28..0.35 rows=1 width=8) (actual time=0.013..0.014 rows=1 loops=1)
                  ->  Index Only Scan Backward using film_duration_idx on film  (cost=0.28..73.75 rows=1000 width=8) (actual time=0.013..0.013 rows=1 loops=1)
                        Index Cond: (duration IS NOT NULL)
                        Heap Fetches: 1
  ->  HashAggregate  (cost=3754.04..3754.05 rows=1 width=32) (actual time=18.287..18.288 rows=1 loops=1)
        Group Key: f.name, f.duration
        Batches: 1  Memory Usage: 24kB
        ->  Nested Loop  (cost=12.61..3686.62 rows=8989 width=72) (actual time=0.214..15.382 rows=8676 loops=1)
              ->  Nested Loop  (cost=12.18..2705.57 rows=1000 width=28) (actual time=0.204..1.703 rows=981 loops=1)
                    ->  Seq Scan on film f  (cost=0.00..21.50 rows=1 width=28) (actual time=0.061..0.107 rows=1 loops=1)
                          Filter: (duration = $1)
                          Rows Removed by Filter: 999
                    ->  Bitmap Heap Scan on session s  (cost=12.18..2674.07 rows=1000 width=8) (actual time=0.141..1.404 rows=981 loops=1)
                          Recheck Cond: (film_id = f.id)
                          Heap Blocks: exact=910
                          ->  Bitmap Index Scan on session_film_id_idx  (cost=0.00..11.93 rows=1000 width=0) (actual time=0.061..0.061 rows=981 loops=1)
                                Index Cond: (film_id = f.id)
              ->  Index Scan using ticket_session_id_idx on ticket t  (cost=0.43..0.88 rows=10 width=52) (actual time=0.003..0.012 rows=9 loops=981)
                    Index Cond: (session_id = s.id)
Planning Time: 0.510 ms
Execution Time: 18.351 ms
 */

-- Самый частый клиент и фильм на котором он был
explain analyze
select t.customer_id, count(t.*) as count, f.name
from ticket as t
         inner join session s on t.session_id=s.id
         inner join film f on s.film_id = f.id
group by f.name, t.customer_id
order by count desc
limit 1

/*
 Limit  (cost=2054243.68..2054243.68 rows=1 width=28) (actual time=24447.880..24570.861 rows=1 loops=1)
  ->  Sort  (cost=2054243.68..2076715.19 rows=8988605 width=28) (actual time=24264.996..24387.976 rows=1 loops=1)
        Sort Key: (count(t.*)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=923740.77..2009300.66 rows=8988605 width=28) (actual time=14608.537..23032.362 rows=8725180 loops=1)
              Group Key: f.name, t.customer_id
              ->  Gather Merge  (cost=923740.77..1863235.83 rows=7490504 width=28) (actual time=14608.520..19938.068 rows=8899577 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Partial GroupAggregate  (cost=922740.74..997645.78 rows=3745252 width=28) (actual time=14502.741..16788.841 rows=2966526 loops=3)
                          Group Key: f.name, t.customer_id
                          ->  Sort  (cost=922740.74..932103.87 rows=3745252 width=68) (actual time=14502.714..15506.825 rows=2996202 loops=3)
                                Sort Key: f.name, t.customer_id
                                Sort Method: external merge  Disk: 218240kB
                                Worker 0:  Sort Method: external merge  Disk: 217312kB
                                Worker 1:  Sort Method: external merge  Disk: 224360kB
                                ->  Hash Join  (cost=17404.50..206592.31 rows=3745252 width=68) (actual time=2405.094..4615.645 rows=2996202 loops=3)
                                      Hash Cond: (s.film_id = f.id)
                                      ->  Parallel Hash Join  (cost=17373.00..196687.86 rows=3745252 width=56) (actual time=2279.439..3717.921 rows=2996202 loops=3)
                                            Hash Cond: (t.session_id = s.id)
                                            ->  Parallel Seq Scan on ticket t  (cost=0.00..94705.52 rows=3745252 width=56) (actual time=0.038..1183.125 rows=2996202 loops=3)
                                            ->  Parallel Hash  (cost=10536.67..10536.67 rows=416667 width=8) (actual time=106.237..106.238 rows=333333 loops=3)
                                                  Buckets: 131072  Batches: 16  Memory Usage: 3520kB
                                                  ->  Parallel Seq Scan on session s  (cost=0.00..10536.67 rows=416667 width=8) (actual time=0.011..38.747 rows=333333 loops=3)
                                      ->  Hash  (cost=19.00..19.00 rows=1000 width=20) (actual time=125.634..125.635 rows=1000 loops=3)
                                            Buckets: 1024  Batches: 1  Memory Usage: 59kB
                                            ->  Seq Scan on film f  (cost=0.00..19.00 rows=1000 width=20) (actual time=125.344..125.466 rows=1000 loops=3)
Planning Time: 0.625 ms
JIT:
  Functions: 73
  Options: Inlining true, Optimization true, Expressions true, Deforming true
  Timing: Generation 6.138 ms, Inlining 114.954 ms, Optimization 261.351 ms, Emission 181.650 ms, Total 564.094 ms
Execution Time: 24596.375 ms
 */