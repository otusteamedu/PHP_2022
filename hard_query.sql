-- Запрос 1 -- получить название фильма и цену для фильмов, в названии которых содержится "2" (например Часть 2)
explain analyse
select f.film_name, amount
from price p
         join film f on p.film_id = f.film_id
where f.film_name LIKE '%2%';
;

/* Без индекса по названию фильма 10 000 строк
Hash Join  (cost=293.10..331.35 rows=402 width=50) (actual time=6.108..7.261 rows=381 loops=1)
  Hash Cond: (p.film_id = f.film_id)
  ->  Seq Scan on price p  (cost=0.00..33.00 rows=2000 width=8) (actual time=0.016..0.358 rows=2000 loops=1)
  ->  Hash  (cost=268.00..268.00 rows=2008 width=50) (actual time=6.079..6.080 rows=1947 loops=1)
        Buckets: 2048  Batches: 1  Memory Usage: 176kB
        ->  Seq Scan on film f  (cost=0.00..268.00 rows=2008 width=50) (actual time=0.054..5.108 rows=1947 loops=1)
              Filter: ((film_name)::text ~~ '%2%'::text)
              Rows Removed by Filter: 8053
Planning Time: 0.360 ms
Execution Time: 7.341 ms
*/

/* С индексом по названию фильма 10 000 строк
Hash Join  (cost=293.10..331.35 rows=402 width=50) (actual time=6.389..8.050 rows=381 loops=1)
  Hash Cond: (p.film_id = f.film_id)
  ->  Seq Scan on price p  (cost=0.00..33.00 rows=2000 width=8) (actual time=0.020..0.534 rows=2000 loops=1)
  ->  Hash  (cost=268.00..268.00 rows=2008 width=50) (actual time=6.349..6.351 rows=1947 loops=1)
        Buckets: 2048  Batches: 1  Memory Usage: 176kB
        ->  Seq Scan on film f  (cost=0.00..268.00 rows=2008 width=50) (actual time=0.029..5.424 rows=1947 loops=1)
              Filter: ((film_name)::text ~~ '%2%'::text)
              Rows Removed by Filter: 8053
Planning Time: 3.061 ms
Execution Time: 8.158 ms
*/

/*
Несмотря на наличие индекса по названию фильма он не использовался, время планирования и выполнения значительно ухудшилось.
Я так понимаю, что логичнее было бы использовать полнотекстовый индекс
*/




-- Запрос 2 -- получить названия фильмов с датой премьеры сегодня
explain analyse select f.film_name from ticket t
join price p on t.price_id = p.price_id
join film f on p.film_id = f.film_id
where f.premier_date = NOW();
;

/*
Без индекса, таблица на 1 000 000 строк
Gather  (cost=1331.28..12478.52 rows=100 width=46) (actual time=187.982..193.384 rows=0 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Hash Join  (cost=331.27..11468.52 rows=42 width=46) (actual time=6.703..6.707 rows=0 loops=3)
        Hash Cond: (t.price_id = p.price_id)
        ->  Parallel Seq Scan on ticket t  (cost=0.00..9572.67 rows=416667 width=4) (actual time=0.010..0.010 rows=1 loops=3)
        ->  Hash  (cost=331.26..331.26 rows=1 width=50) (actual time=6.439..6.442 rows=0 loops=3)
              Buckets: 1024  Batches: 1  Memory Usage: 8kB
              ->  Hash Join  (cost=293.01..331.26 rows=1 width=50) (actual time=6.438..6.441 rows=0 loops=3)
                    Hash Cond: (p.film_id = f.film_id)
                    ->  Seq Scan on price p  (cost=0.00..33.00 rows=2000 width=8) (actual time=0.720..0.721 rows=1 loops=3)
                    ->  Hash  (cost=293.00..293.00 rows=1 width=50) (actual time=5.695..5.696 rows=0 loops=3)
                          Buckets: 1024  Batches: 1  Memory Usage: 8kB
                          ->  Seq Scan on film f  (cost=0.00..293.00 rows=1 width=50) (actual time=5.694..5.694 rows=0 loops=3)
                                Filter: (premier_date = now())
                                Rows Removed by Filter: 10000
Planning Time: 5.345 ms
Execution Time: 193.444 ms

После создания следующих индексов:

create index idx_premier_date on film(premier_date);
create index idx_ticket_price_id on ticket(price_id);
create index idx_price_film_id on price(film_id);

Можно наблюдать существенное уменьшение времени выполнения запроса

Nested Loop  (cost=0.99..32.56 rows=100 width=46) (actual time=1.409..1.410 rows=0 loops=1)
  ->  Nested Loop  (cost=0.56..16.61 rows=1 width=50) (actual time=1.408..1.409 rows=0 loops=1)
        ->  Index Scan using idx_premier_date on film f  (cost=0.29..8.30 rows=1 width=50) (actual time=1.407..1.407 rows=0 loops=1)
              Index Cond: (premier_date = now())
        ->  Index Scan using idx_price_film_id on price p  (cost=0.28..8.29 rows=1 width=8) (never executed)
              Index Cond: (film_id = f.film_id)
  ->  Index Only Scan using idx_ticket_price_id on ticket t  (cost=0.42..10.95 rows=500 width=4) (never executed)
        Index Cond: (price_id = p.price_id)
        Heap Fetches: 0
Planning Time: 77.868 ms
Execution Time: 1.447 ms
*/





-- Запрос 3.
explain analyse
select f.film_name, p.amount
from price p
         join film f on p.film_id = f.film_id
where f.premier_date > NOW();
;

/* Без индекса по дате премьеры 10 000 строк
Hash Join  (cost=299.55..337.80 rows=105 width=46) (actual time=5.085..6.259 rows=105 loops=1)
  Hash Cond: (p.film_id = f.film_id)
  ->  Seq Scan on price p  (cost=0.00..33.00 rows=2000 width=4) (actual time=0.035..0.503 rows=2000 loops=1)
  ->  Hash  (cost=293.00..293.00 rows=524 width=50) (actual time=4.962..4.963 rows=532 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 52kB
        ->  Seq Scan on film f  (cost=0.00..293.00 rows=524 width=50) (actual time=0.026..4.645 rows=532 loops=1)
              Filter: (premier_date > now())
              Rows Removed by Filter: 9468
Planning Time: 9.854 ms
Execution Time: 6.376 ms
*/

/* index premier_date 10 000 строк
Hash Join  (cost=174.53..204.36 rows=86 width=46) (actual time=0.013..0.016 rows=0 loops=1)
  Hash Cond: (p.film_id = f.film_id)
  ->  Seq Scan on price p  (cost=0.00..25.70 rows=1570 width=4) (actual time=0.011..0.011 rows=0 loops=1)
  ->  Hash  (cost=167.71..167.71 rows=546 width=50) (never executed)
        ->  Bitmap Heap Scan on film f  (cost=16.52..167.71 rows=546 width=50) (never executed)
              Recheck Cond: (premier_date > now())
              ->  Bitmap Index Scan on premier_date  (cost=0.00..16.38 rows=546 width=0) (never executed)
                    Index Cond: (premier_date > now())
Planning Time: 0.504 ms
Execution Time: 0.084 ms

create index premier_date on film(premier_date)
Применение индекса оправдано, произошли значительные улучшения стоимости запроса и времени выполнения
*/
