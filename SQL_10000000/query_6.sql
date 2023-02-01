-- 6. Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс
explain analyse
select
    m.name as movie,
    max(ms.price) as max_price,
    min(ms.price) as min_price
from
    movies_shows as ms
    inner join movies m on m.id = ms.movie_id
where m.id = 20
group by m.id;

-- GroupAggregate  (cost=1000.29..14551.83 rows=1 width=38) (actual time=42.711..45.850 rows=1 loops=1)
--   Group Key: m.id
--   ->  Nested Loop  (cost=1000.29..14551.74 rows=10 width=34) (actual time=0.170..45.840 rows=10 loops=1)
--         ->  Index Scan using movies_pkey on movies m  (cost=0.29..8.31 rows=1 width=30) (actual time=0.007..0.011 rows=1 loops=1)
--               Index Cond: (id = 20)
--         ->  Gather  (cost=1000.00..14543.33 rows=10 width=8) (actual time=0.162..45.825 rows=10 loops=1)
--               Workers Planned: 2
--               Workers Launched: 2
--               ->  Parallel Seq Scan on movies_shows ms  (cost=0.00..13542.33 rows=4 width=8) (actual time=12.239..26.372 rows=3 loops=3)
--                     Filter: (movie_id = 20)
--                     Rows Removed by Filter: 333330
-- Planning Time: 0.083 ms
-- Execution Time: 45.890 ms

-- Индекс по полю movie_id
CREATE INDEX idx_movie_id ON movies_shows(movie_id);

-- GroupAggregate  (cost=0.72..17.19 rows=1 width=38) (actual time=0.029..0.029 rows=1 loops=1)
--   Group Key: m.id
--   ->  Nested Loop  (cost=0.72..17.10 rows=10 width=34) (actual time=0.020..0.023 rows=10 loops=1)
--         ->  Index Scan using movies_pkey on movies m  (cost=0.29..8.31 rows=1 width=30) (actual time=0.007..0.008 rows=1 loops=1)
--               Index Cond: (id = 20)
--         ->  Index Scan using idx_movie_id on movies_shows ms  (cost=0.42..8.69 rows=10 width=8) (actual time=0.011..0.012 rows=10 loops=1)
--               Index Cond: (movie_id = 20)
-- Planning Time: 0.179 ms
-- Execution Time: 0.050 ms

